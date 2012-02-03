<?php

/**
 * NiceAuth App Controller for NiceAuth Plugin
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

class NiceAuthAppController extends AppController {

	var $components = array("Acl", "Auth", "Session");

	public function beforeFilter(){
		Configure::load('NiceAuth.config');
		$this->Auth->loginAction = '/login';
		}

	}

?>