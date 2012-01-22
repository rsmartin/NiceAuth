<?php

class NiceAuthAppController extends AppController {

	var $components = array("Acl", "Auth", "Session");

	public function beforeFilter(){
		Configure::load('NiceAuth.config');
		$this->Auth->loginAction = '/login';
		}

	}

?>