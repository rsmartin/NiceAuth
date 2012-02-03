<?php
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