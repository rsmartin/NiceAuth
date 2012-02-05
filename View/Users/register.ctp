<?php
/**
 * User Registration Form View for NiceAuth Plugin
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

<h2>Register your account</h2> 

<?php

echo $this->Form->create('User');
echo $this->Form->input('username');
echo $this->Form->input('email');
echo $this->Form->input('password');
?>

<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?php echo Configure::read('NiceAuth.recaptchaPublic'); ?>"></script>
<noscript>
	<iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo Configure::read('NiceAuth.recaptchaPublic'); ?>" height="300" width="500" frameborder="0"></iframe><br>
	<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
	<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
</noscript>

<?php echo $this->Form->end('Register'); ?>

<form action="<?php echo $this->Html->url('/users/openid'); ?>" method="post" id="openid_form">
	<input type="hidden" name="action" value="verify" />
	<input type="hidden" name="type" value="register" />
	<fieldset>
		<legend>-or- Sign in with another account.</legend>
		<div id="openid_choice">
			<p>Please click your account provider:</p>
			<div id="openid_btns"></div>
		</div>
		<div id="openid_input_area">
			<input id="openid_identifier" name="openid" type="text" value="http://" />
			<input id="openid_submit" type="submit" value="Sign-In" />
		</div>
		<noscript>
			<p>OpenID is service that allows you to log-on to many different websites using a single identity.
			Find out <a href="http://openid.net/what/">more about OpenID</a> and <a href="http://openid.net/get/">how to get an OpenID enabled account</a>.</p>
		</noscript>
	</fieldset>
</form>
