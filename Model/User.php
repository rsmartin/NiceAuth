<?php

/**
 * User Model for NiceAuth Plugin
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

App::uses('NiceAuthAppModel', 'NiceAuth.Model');

class User extends NiceAuthAppModel {
	
	var $name = 'User';
	public $belongsTo = array(
		'Group' => array(
			'foreignKey' => 'group_id'
			)
		);
	
    //var $actsAs = array('Acl' => array('type' => 'requester'));
    var $actsAs = array('Acl' => 'requester');

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        	}
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        	} 
        else {
            $groupId = $this->field('group_id');
        	}
        if (!$groupId) {
            return null;
        	} 
        else {
            return array('Group' => array('id' => $groupId));
        	}
    	}
	
	var $validate = array(
		'username' => array( 
			'alphaNumeric' => array(
				//'rule' => 'alphaNumeric',
				'rule' => 'isUnique',
				'required' => true,
				'message' => 'This username already exists'
				),
			'between' => array(
				'rule' => array('between', 5, 400),
				'message' => 'Must be between 5 and 25 characters'
				)
			),
		'email' => array(
			'rule' => 'email',
			'message' => 'You must enter a valid email address'
			),
		'password' => array(
			'rule' => array('minLength', 8),
			'message' => 'Must be at least 8 characters long'
			)
		);

	public function beforeSave() {
    	if (isset($this->data[$this->alias]['password'])) {
        	$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    		}
    	return true;
		}

	}