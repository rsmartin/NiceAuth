<?php
/**
 * User Profile View for NiceAuth Plugin
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

<h2>User Profile</h2>

Username: <?php echo $user['User']['username']; ?><br />
Email: <?php echo $user['User']['email']; ?><br />

<p></p>
<h3>Change Password</h3>

<?php

echo $this->Form->create('User');
echo $this->Form->input('old_password', array('type' => 'password', 'div' => array('class' => 'required')));
echo $this->Form->input('password', array('label' => 'New Password'));
echo $this->Form->input('password_verify', array('label' => 'Re-Type New Password', 'type' => 'password', 'div' => array('class' => 'required')));
echo $this->Form->end('Update Password');

?>