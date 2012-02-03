<?php

/**
 * CakePHP Routes for NiceAuth Plugin
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

Router::connect('/login', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'logout'));
Router::connect('/register', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'register'));
Router::connect('/me', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'index'));
Router::connect('/users', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'index'));
Router::connect('/dashboard', array('plugin' => 'NiceAuth', 'controller' => 'dashboard', 'action' => 'index'));
Router::connect('/users/:action/*', array('plugin' => 'NiceAuth', 'controller' => 'users'));
Router::connect('/dashboard/:action/*', array('plugin' => 'NiceAuth', 'controller' => 'dashboard'));
?>