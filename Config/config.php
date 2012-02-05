<?php

/**
 * CakePHP config for NiceAuth Plugin
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

$config['NiceAuth'] = array(
	'defaultGroup' => 2, //Sets the default group ID for user registration
	'regEmail' => true, //Set to true to send new users an email when registering
	'regSubject' => 'Thank you for registering', //Subject of email sent to new users
	'resetSubject' => 'Password Reset Instructions',  //Subject of email sent for password resets
	'recaptchaPublic' => '6LdTQM0SAAAAAM-tRHEsCTX5PsaKcLyuugPza7dT',
	'recaptchaPrivate' => '6LdTQM0SAAAAAA1JyZ73JPYU_ta8LQr60ZbKNJ-K',
	);