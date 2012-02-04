<?php

/**
 * User Controller for NiceAuth Plugin
 *
 * NiceAuth : User Authentication and Authorization Plugin for CakePHP
 * Copyright 2011, R.S.Martin (http://rsmartin.me)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author RSMartin
 * @copyright Copyright (c) 2011, RSMartin (http://rsmartin.me)
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

App::uses('NiceAuthAppController', 'NiceAuth.Controller');
App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('AclComponent', 'Controller/Component');
App::uses('DbAcl', 'Model');
App::uses('CakeEmail', 'Network/Email');
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
		if ($this->Auth->user('id')) {
			$user = $this->User->findById($this->Auth->user());
			$this->set('user', $user);
			if ($this->request->is('post')) {
				$req = $this->request->data;
				if ($user['User']['password'] == AuthComponent::password($req['User']['old_password'])) {
					if ($req['User']['password'] == $req['User']['password_verify']) {
						$user['User']['password'] = $req['User']['password'];
		        		if($this->User->save($user)) {
		        			$this->Session->setFlash('New Password Saved!');
		        			}
		        		else {
		        			$this->Session->setFlash('The new passwords didn\'t match.');
		        			}
						}
					else {
						$this->Session->setFlash('The new passwords didn\'t match.');
						}
					}
				else {
					$this->Session->setFlash('The old password you entered was incorrect');
					}
				}
			}
		else {
			$this->redirect('/login');
			}
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
	
	private function sendEmail($type, $to, $vars = null) {
		if ($type == "registration" && Configure::read('NiceAuth.regEmail') == true) {
			$email = new CakeEmail('default');
			$email->to($to)
				->emailFormat('html')
				->subject(Configure::read('NiceAuth.regSubject'))
				->template('NiceAuth.register')
				->viewVars($vars)
				->send();
			}
		elseif ($type == "reset") {
			$email = new CakeEmail('default');
			$email->to($to)
				->emailFormat('html')
				->subject(Configure::read('NiceAuth.resetSubject'))
				->template('NiceAuth.reset')
				->viewVars($vars)
				->send();			
			}
		}
	
	public function passwordReset() {
        if ($this->request->is('post')) {
        	if ($user = $this->User->findByEmail($this->request->data['User']['email'])) {
        		$newPass = uniqid(rand());
        		$user['User']['password'] = $newPass;
        		if($this->User->save($user)) {
        			$pass = array('password' => $newPass);
        			$this->sendEmail('reset', $this->request->data['User']['email'], $pass);
        			}
        		$this->Session->setFlash('You will receive an email shortly!');
        		//$this->redirect('/');
        		}
        	else {
        		$this->Session->setFlash('The email address you entered could not be found.');
        		}
			}		
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
                $newUser = $this->User->read();
                $emailVars = array('username' => $newUser['User']['username']);
                $this->sendEmail('register', $newUser['User']['email'], $emailVars);
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
    	            $emailVars = array('username' => $user['User']['username']);
	                $this->sendEmail('register', $user['User']['email'], $emailVars);
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

    public function logout(){
        $this->Auth->logout();
        $this->Session->setFlash('You have been successfully logged out.');
        $this->redirect('/');
    	}
	}

?>