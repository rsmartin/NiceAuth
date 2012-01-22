<?php

Router::connect('/login', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'logout'));
Router::connect('/register', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'register'));
Router::connect('/dashboard', array('plugin' => 'NiceAuth', 'controller' => 'dashboard', 'action' => 'index'));

?>