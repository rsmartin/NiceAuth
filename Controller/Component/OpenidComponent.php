<?php

App::import('NiceAuth.Vendor', 'Lightopenid');

class OpenidComponent extends Component {
	
	public function send($id) {
		$openid = new Lightopenid('cl2.olddominionentertainment.com');
		$openid->identity = $id;
		$openid->required = array('namePerson/friendly', 'contact/email');
		header('Location: ' . $openid->authUrl());
		exit();

		//$openid = new LightOpenID('my-host.example.org');
		//if ($openid->mode) {
		//	echo $openid->validate() ? 'Logged in.' : 'Failed';
		//	}

		}
	
	}

?>