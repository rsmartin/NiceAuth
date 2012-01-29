<?php

App::uses('NiceAuth.Openid', 'Vendor');

class OpenidComponent extends Component {
	
	public function send($id) {
		$openid = new LightOpenID('cl2.olddominionentertainment.com');
		$openid->identity = $id;
		header('Location: ' . $openid->authUrl());
		//$openid = new LightOpenID('my-host.example.org');
		//if ($openid->mode) {
		//	echo $openid->validate() ? 'Logged in.' : 'Failed';
		//	}
		}
	
	}

?>