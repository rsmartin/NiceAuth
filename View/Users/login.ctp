<?php
/**
 * User Login Form View for NiceAuth Plugin
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

<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
    <?php
        echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login'));?>

<form action="<?php echo $this->Html->url('/users/openid'); ?>" method="post" id="openid_form">
	<input type="hidden" name="action" value="verify" />
	<input type="hidden" name="type" value="login" />
	<fieldset>
		<legend>-or- Sign in with another account.</legend>
		<div id="openid_choice">
			<p>Please click your account provider:</p>
			<div id="openid_btns"></div>
		</div>
		<div id="openid_input_area">
			<input id="openid_identifier" name="openid" type="text" value="http://" />
			<input id="openid_submit" type="submit" value="Sign-In"/>
		</div>
		<noscript>
			<p>OpenID is service that allows you to log-on to many different websites using a single identity.
			Find out <a href="http://openid.net/what/">more about OpenID</a> and <a href="http://openid.net/get/">how to get an OpenID enabled account</a>.</p>
		</noscript>
	</fieldset>
</form>
