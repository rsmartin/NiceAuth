<?php
/**
 * Admin Help View for NiceAuth Plugin
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
?>
<h2>NiceAuth Help</h2>

<h3>Location of User Items</h3>

<pre>
http://yoursite.com/login  =  User Login
http://yoursite.com/logout  =  User Logout
http://yoursite.com/register  =  User Registration
http://yoursite.com/dashboard  =  Administrative Backend
</pre>

<p>&nbsp;</p>
<h3>Adding New Controllers and Actions</h3>

<p>When you add new controllers and actions, they must also be added to the Acl database, otherwise you will get an error (eg. Failed node lookup).</p>
<p>To add new controller and actions to the database, you will need to terminal into your cake installation.</p>

<pre>
cd pathToYourInstallation/cakephp/app
Console/app nice_auth.nice_auth update
</pre>

<p>&nbsp;</p>

<h3>Allowing Global Access to a controller</h3>

<p>You may want to make a controller viewable to anyone, including users that are not logged in. You can do this by adding a bit of code to the controller you with to allow public access to.</p>
<p>Inside your controller's class, enter:</p>

<pre>
public function beforeFilter() {
	$this->Auth->allow('*');
	}
</pre>

<p>&nbsp;</p>
<p>If you wish to only make certain actions public, use:</p>

<pre>
public function beforeFilter() {
	$this->Auth->allow('nameOfAction', 'anotherAction);
	}
</pre>

<p>&nbsp;</p>
<h3>Database Upkeep</h3>

<p>CakePHP's ACL uses MITT tables to determine parent and child elements via a "left" and "right" value. If you manually edit your Aco or Aro tables, you must rebuild your tables. This functions can be found under the "Database Functions" tab above.</p>