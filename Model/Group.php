<?php

App::uses('NiceAuthAppModel', 'NiceAuth.Model');

class Group extends NiceAuthAppModel {

	var $name = 'Group';
	var $hasMany = array('User');
    var $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        return null;
	    }
	
	}