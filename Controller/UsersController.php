<?php

App::uses('NiceAuthAppController', 'NiceAuth.Controller');
App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('AclComponent', 'Controller/Component');
App::uses('DbAcl', 'Model');

class UsersController extends NiceAuthAppController {
	public $name = "Users";
	public $uses = array("Aro", "NiceAuth.Group", "NiceAuth.User");
	public $components = array('Auth', 'Acl');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->userModel = 'User';
		//Allow Anyone to access the users controller
		$this->Auth->allow('*');
		}

	function fixAlias() {
		$user = $this->User->read();
		$this->Aro->findByForeignKey($user['User']['id']);
		$this->Aro->save(array('alias' => $user['User']['username']));
				}

    function register(){
    	$this->set('groups', $this->Group->find('list'));
        if ($this->request->is('post')) {
        	$this->User->create();
        	$this->User->set(array(
        		'group_id' => Configure::read('NiceAuth.defaultGroup')
        		));
            if ($this->User->save($this->request->data)) {
            	$this->fixAlias();
                $this->Session->setFlash(__('You\'r account has been setup.'));
                $this->redirect('/');
            	}
            else {
            	$this->Session->setFlash('Unable to create your\'re account. Please try again.');
            	}
        	}
        }

    function login(){
        if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
				}
			else {
				$this->Session->setFlash(__('Invalid username or password, try again'));
				}
			}
    	} 

    function logout(){
        $this->Auth->logout();
    	}
	}

?>