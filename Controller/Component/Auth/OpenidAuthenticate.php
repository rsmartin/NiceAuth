<?php

/**
 * OpenID Auth Component for NiceAuth Plugin
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

App::uses('BaseAuthenticate', 'Controller/Component/Auth');
App::import('NiceAuth.Vendor', 'Lightopenid');

class OpenidAuthenticate extends BaseAuthenticate {

	public $settings = array(
		'fields' => array(
			'username' => 'email',
			'password' => 'password'
		),
		'userModel' => 'User',
		'scope' => array()
	);

    public function authenticate(CakeRequest $request, CakeResponse $response) {
    	$req = $request->query;
    	if (isset($req['openid_mode']) && $req['openid_mode'] != 'cancel') {
			$openid = new Lightopenid($_SERVER['SERVER_NAME']);
    		$attr = $openid->getAttributes();
    		$data = $openid->data;
    		return($this->_findUser($attr['contact/email'], $data['openid_identity']));        	}
        else {
        	return false;
        	}
    	}

	}