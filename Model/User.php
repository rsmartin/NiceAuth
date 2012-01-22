<?php

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
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Letters and Numbers Only'
				),
			'between' => array(
				'rule' => array('between', 5, 15),
				'message' => 'Must be between 5 and 15 characters'
				)
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