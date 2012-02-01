<?php

App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('AclComponent', 'Controller/Component');
App::uses('DbAcl', 'Model');
App::import('Component', 'Auth');

class NiceAuthShell extends AppShell {

	public $uses = array('NiceAuth.User', 'NiceAuth.Group', 'Aro');
		
	public $Acl;
	
	public function startup() {
		parent::startup();
		$collection = new ComponentCollection();
		$this->Acl = new AclComponent($collection);
		}
	
	public function update() {
		$this->dispatchShell("nice_auth.acl_extras aco_update");
		}

	public function db_init() {

		$this->dispatchShell('schema create DbAcl');
		$this->dispatchShell("schema create --plugin NiceAuth --file nice_auth");
		$this->dispatchShell("acl create aco root controllers");
		$this->dispatchShell("nice_auth.acl_extras aco_sync");

		$this->Group->create();
		$this->Group->save(array('name' => 'superadmin'));
		$groupId = $this->Group->Id;
		$this->Aro->findByForeignKey($groupId);
		$this->Aro->save(array('alias' => 'superadmin'));

		$this->Group->create();
		$this->Group->save(array('name' => 'member'));
		$groupId = $this->Group->Id;
		$this->Aro->findByForeignKey($groupId);
		$this->Aro->save(array('alias' => 'member'));

		$this->User->create();
		$this->User->save(array('username' => 'admin', 'email' => 'admin@example.com', 'password' => 'pass1234', 'group_id' => 1));
		$this->Aro->findByForeignKey($this->User->Id);
		$this->Aro->save(array('alias' => 'admin'));
		$this->Acl->allow('superadmin', 'controllers');
		$this->Acl->deny('member', 'controllers');
		$this->out('NiceAuth is now setup. Your username: admin password: pass1234');
		}

	public function getOptionParser() {
		return parent::getOptionParser()
		->description('NiceAuth setup and maintenance console')
		->addSubcommand('db_init', array('help' => 'Initialize the ACL, User and Group databases. Also sets up a default admin user.'))
		->addSubcommand('update', array('help' => 'Update the Access Control Objects database with new controllers and actions.'));
		}

	
	}