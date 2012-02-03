<?php

App::uses('NiceAuthAppController', 'NiceAuth.Controller');
App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('AclComponent', 'Controller/Component');
App::uses('DbAcl', 'Model');
App::import('NiceAuth.Vendor', 'Lightopenid');

class UsersController extends NiceAuthAppController {
	public $name = "Users";
	public $uses = array("Aro", "NiceAuth.Group", "NiceAuth.User");
	public $components = array(
		'Auth' => array(
			'authenticate' => array(
				'Form',
				'NiceAuth.Openid'
				)
			),
		'Acl'
		);
	
	public function index() {
		$this->set('user', $this->User->findById($this->Auth->user()));
		}
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->userModel = 'User';
		$this->Auth->allow('*');
		//Custom Layout for User Controller
		$this->layout = 'user';
		}

	private function fixAlias() {
		$user = $this->User->read();
		$this->Aro->findByForeignKey($user['User']['id']);
		$this->Aro->save(array('alias' => $user['User']['username']));
				}

    public function register(){
    	$this->set('groups', $this->Group->find('list'));
        if ($this->request->is('post')) {
        	$this->User->create();
        	$this->User->set(array(
        		'group_id' => Configure::read('NiceAuth.defaultGroup')
        		));
            if ($this->User->save($this->request->data)) {
            	$this->fixAlias();
                $this->Session->setFlash(__('You\'r account has been setup.'));
                $this->redirect('/me');
            	}
            else {
            	$this->Session->setFlash('Unable to create your\'re account. Please try again.');
            	}
        	}
        elseif ($this->request->is('get')) {
        	if (isset($this->request->query['openid_mode'])) {
        		$openid = new Lightopenid($_SERVER['SERVER_NAME']);
				$ret = $openid->getAttributes();
	    		$data = $openid->data;
				if ($this->User->findByEmail($ret['contact/email']) == false) {
					$this->User->create();
					$newUser = array('username' => $ret['contact/email'], 'email' => $ret['contact/email'], 'password' => $data['openid_identity'], 'group_id' => Configure::read('NiceAuth.defaultGroup'));
					$this->User->save($newUser);
					$user = $this->User->read();
					$this->fixAlias();
					$this->Auth->login($user['User']);
					$this->Session->setFlash('Your account has been created.');
					$this->redirect('/me');
					}
				else {
					$this->Session->setFlash('This email address already exists, please try logging in instead.');
					}
        		}
        	}
        }

    public function login(){
        if ($this->request->is('post') || ($this->request->is('get') && isset($this->request->query['openid_mode']))) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
				}
			else {
				$this->Session->setFlash(__('Invalid username or password, try again'));
				}
			}
    	}
    
    public function openid() {
        if ($this->request->is('post')) {
			$openid = new Lightopenid($_SERVER['SERVER_NAME']);
			$openid->identity = $this->request->data['openid'];
			$openid->required = array('contact/email');
			if ($this->request->data['type'] == 'register') {
				$openid->returnUrl = 'http://'.$_SERVER['SERVER_NAME'].Router::url(array('controller' => 'users', 'action' => 'register'));
				}
			else {
				$openid->returnUrl = 'http://'.$_SERVER['SERVER_NAME'].Router::url(array('controller' => 'users', 'action' => 'login'));
				}
			$this->redirect($openid->authUrl());
			}
    	}
/*
	public function openid_return() {
		$openid = new Lightopenid($_SERVER['SERVER_NAME']);
		$ret = $openid->getAttributes();
		echo "<pre>";
		print_r($openid);
		exit();
		if($openid->mode) { 
			if($this->User->findByUsername($ret['contact/email']) == false) {
				$this->User->create();
				$newUser = array('username' => $ret['contact/email'], 'email' => $ret['contact/email'], 'password' => 'authopeniduser!', 'group_id' => Configure::read('NiceAuth.defaultGroup'));
				$this->User->save($newUser);
				$user = $this->User->read();
				$this->fixAlias();
				$this->Auth->login($user['User']);
				$this->Session->setFlash('Your account has been created.');
				$this->redirect('/me');
				}
			else {
				$user = $this->User->findByUsername($ret['contact/email']);
				$this->Auth->login($user['User']);
				$this->Session->setFlash('Welcome Back!');
				$this->redirect($this->Auth->redirect()); //'/me');
				}
			}
		}
*/
    public function logout(){
        $this->Auth->logout();
        $this->Session->setFlash('You have been successfully logged out.');
        $this->redirect('/');
    	}
	}

?>