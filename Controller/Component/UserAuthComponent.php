<?php

class UserAuthComponent extends Component {
	
	var $components = array("Acl", "Auth", "Session");
	var $uses = array('User', 'Group');

	public function checkAccess($aco){ 

	    if ($this->Auth->loggedIn()) { 
			$user = $this->Auth->user('username');
	    	if ($this->Acl->check($user, $aco, '*')) { 
	        	return;  
    			}
    		else {
    			$this->Session->setFlash('You are not allowed to access this page.');
    			$this->Auth->redirect('/login');
    			}
			$this->Session->setFlash('You must be logged in to access this page.');
			$this->Auth->redirect('/login');
    		}
    	}

    }
