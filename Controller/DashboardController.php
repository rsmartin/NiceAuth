<?php
App::uses('NiceAuthAppController', 'NiceAuth.Controller');
App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('AclComponent', 'Controller/Component');
App::uses('DbAcl', 'Model');

class DashboardController extends NiceAuthAppController {
	
	var $uses = array('NiceAuth.User', 'NiceAuth.Group', 'Aco', 'Aro');
	var $helpers = array('Html', 'Form');
	public $components = array(
		'Acl',
		'Session',
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login'
				),
			'authError' => 'You are not authorized to view that page',
			'authorize' => array('Actions' => array('actionPath' => 'controllers')),
			)
		);
	
	public function beforeFilter() {
		$this->layout = 'nice_auth';
		}
	
	public function index() {
		}
	
	public function help() {
		}
	
	private function fixAroAlias($model) {
		if ($model == 'Group') {
			$insertId = $this->Group->id;
			$group = $this->Group->read('name');
			$alias = $group['Group']['name'];
			}
		elseif ($model == 'User') {
			$insertId = $this->User->id;
			$user = $this->User->read('username');
			$alias = $user['User']['username'];
			//$parent_id = $user['User']['group_id']
			}
		
		$aroRecord = $this->Aro->find('first', array('conditions' => array('foreign_key' => $insertId, 'model' => $model)));
		
		if ($aroRecord['Aro']['alias'] != $alias) {
			$aroRecord['Aro']['alias'] = $alias;
			$this->Aro->save($aroRecord);
			}
		
		}

	public function users() {
		$this->set('users', $this->paginate('User'));
		$this->set('groups', $this->Group->find('list'));
		}
	
	public function user_edit($id) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        	}
        if ($this->request->is('post') || $this->request->is('put')) {
            // leave password untouched if not modified
            $this->log($this->request->data);
            if ($this->request->data['User']['password'] == ''){
                unset($this->request->data['User']['password']);
            	}
            if ($this->User->save($this->request->data)) {
            	$this->fixAroAlias('User');
                $this->Session->setFlash(__('The user has been saved'));
            	}
            else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            	}
        	}
        else {
            $this->request->data = $this->User->read(null, $id);
        	}
        $groups = $this->Group->find('list');
        $this->set(compact('groups'));
		}

	public function user_delete($id) {
		$this->User->delete($id);
		$this->redirect('/nice_auth/dashboard/users');
		}

	public function user_permissions($id) {
		
		if (!empty($this->request->query)) {
			$req = $this->request->query;
			if ($req['perm'] == 'allow') {
				$this->Acl->allow($req['aro'], $req['aco']);
				$this->Session->setFlash('Aro has been allowed');
				}
			elseif ($req['perm'] == 'deny') {
				$this->Acl->deny($req['aro'], $req['aco']);
				$this->Session->setFlash('Aro has been denied');
				}
			}

	
		$this->User->id = $id;
		$user = $this->User->read();
	
		$acos = $this->Acl->Aco->find('threaded');
	
		$this->set('user', $user);
		$this->set('acos', $acos);
		
		$perms = array();
		
		$i = 0;
		
		foreach($acos as $aco) {
			$perms[$i]['Aco']['alias'] = $aco['Aco']['alias'];
			$perms[$i]['Aco']['layer'] = 1;
			if ($this->check($user['User']['username'], $aco['Aco']['alias']) == '1') {
				$perms[$i]['Aco']['perm'] = 'allow';
				}
			else {
				$perms[$i]['Aco']['perm'] = 'deny';
				}
			$i++;
			
			//Second Layer
			foreach($aco['children'] as $aco2) {
				$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias'];
				$perms[$i]['Aco']['layer'] = 2;
				if ($this->check($user['User']['username'], $aco2['Aco']['alias']) == '1') {
					$perms[$i]['Aco']['perm'] = 'allow';
					}
				else {
					$perms[$i]['Aco']['perm'] = 'deny';
					}
				$i++;

				//Third Layer
				foreach($aco2['children'] as $aco3) {
					$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias']."/".$aco3['Aco']['alias'];
					$perms[$i]['Aco']['layer'] = 3;
					if ($this->check($user['User']['username'], $aco2['Aco']['alias']."/".$aco3['Aco']['alias']) == '1') {
						$perms[$i]['Aco']['perm'] = 'allow';
						}
					else {
						$perms[$i]['Aco']['perm'] = 'deny';
						}
					$i++;

					//Fourth Layer
					foreach($aco3['children'] as $aco4) {
						$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias'];
						$perms[$i]['Aco']['layer'] = 4;
						if ($this->check($user['User']['username'], $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias']) == '1') {
							$perms[$i]['Aco']['perm'] = 'allow';
							}
						else {
							$perms[$i]['Aco']['perm'] = 'deny';
							}
						$i++;
						}

					}

				}

			}
				
		$this->set('perms', $perms);
	
		}


	public function groups() {
	
		if ($this->request->is('post')) {
			$this->Group->create();
            if ($this->Group->save($this->request->data)) {
            	$this->fixAroAlias('Group');
            	$group = $this->Group->read();
            	$this->Acl->deny($group['Group']['name'], 'controllers');
                $this->Session->setFlash(__('You\'r group has been added.'));
            	}
            else {
            	$this->Session->setFlash('Unable to create your\'re group. Please try again.');
            	}
			}
		
		$this->set('groups', $this->paginate('Group'));
		$defaultGroup = Configure::read('NiceAuth.defaultGroup');
		$this->set('defaultGroup', $defaultGroup);

		}
	
	public function group_edit($id) {
        $this->Group->id = $id;
        if (!$this->Group->exists()) {
            throw new NotFoundException(__('Invalid user'));
        	}
        if ($this->request->is('post') || $this->request->is('put')) {
            // leave password untouched if not modified
            $this->log($this->request->data);
            if ($this->Group->save($this->request->data)) {
            	$this->fixAroAlias('Group');
                $this->Session->setFlash(__('The group has been saved'));
            	}
            else {
                $this->Session->setFlash(__('The group could not be saved. Please, try again.'));
            	}
        	}
        else {
            $this->request->data = $this->Group->read(null, $id);
        	}		
		}
	
	public function group_delete($id) {
		$this->Group->delete($id);
		$this->redirect('/nice_auth/dashboard/groups');
		}
	
	private function check($aro, $aco) {
		return $this->Acl->check($aro, $aco);
		}
	
	public function group_permissions($id) {
		
		if (!empty($this->request->query)) {
			$req = $this->request->query;
			if ($req['perm'] == 'allow') {
				$this->Acl->allow($req['aro'], $req['aco']);
				$this->Session->setFlash('Aro has been allowed');
				}
			elseif ($req['perm'] == 'deny') {
				$this->Acl->deny($req['aro'], $req['aco']);
				$this->Session->setFlash('Aro has been denied');
				}
			}

	
		$this->Group->id = $id;
		$group = $this->Group->read();
	
		$acos = $this->Acl->Aco->find('threaded');
	
		$this->set('group', $group);
		$this->set('acos', $acos);
		
		$perms = array();
		
		$i = 0;
		
		foreach($acos as $aco) {
			$perms[$i]['Aco']['alias'] = $aco['Aco']['alias'];
			$perms[$i]['Aco']['layer'] = 1;
			if ($this->check($group['Group']['name'], $aco['Aco']['alias']) == '1') {
				$perms[$i]['Aco']['perm'] = 'allow';
				}
			else {
				$perms[$i]['Aco']['perm'] = 'deny';
				}
			$i++;
			
			//Second Layer
			foreach($aco['children'] as $aco2) {
				$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias'];
				$perms[$i]['Aco']['layer'] = 2;
				if ($this->check($group['Group']['name'], $aco2['Aco']['alias']) == '1') {
					$perms[$i]['Aco']['perm'] = 'allow';
					}
				else {
					$perms[$i]['Aco']['perm'] = 'deny';
					}
				$i++;

				//Third Layer
				foreach($aco2['children'] as $aco3) {
					$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias']."/".$aco3['Aco']['alias'];
					$perms[$i]['Aco']['layer'] = 3;
					if ($this->check($group['Group']['name'], $aco2['Aco']['alias']."/".$aco3['Aco']['alias']) == '1') {
						$perms[$i]['Aco']['perm'] = 'allow';
						}
					else {
						$perms[$i]['Aco']['perm'] = 'deny';
						}
					$i++;

					//Fourth Layer
					foreach($aco3['children'] as $aco4) {
						$perms[$i]['Aco']['alias'] = $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias'];
						$perms[$i]['Aco']['layer'] = 4;
						if ($this->check($group['Group']['name'], $aco2['Aco']['alias']."/".$aco3['Aco']['alias']."/".$aco4['Aco']['alias']) == '1') {
							$perms[$i]['Aco']['perm'] = 'allow';
							}
						else {
							$perms[$i]['Aco']['perm'] = 'deny';
							}
						$i++;
						}

					}

				}

			}
				
		$this->set('perms', $perms);
	
		}

	public function database() {
		if (isset($this->request->params['pass'][0])) {
			if ($this->request->params['pass'][0] == 'aco') {
				if($this->Acl->Aco->recover()) {
					$this->Session->setFlash('Aco Tree Rebuilt');
					}
				}
			elseif ($this->request->params['pass'][0] == 'aro') {
				if($this->Acl->Aro->recover()) {
					$this->Session->setFlash('Aro Tree Rebuilt');
					}
				}		
			}
		}
	

	
	}