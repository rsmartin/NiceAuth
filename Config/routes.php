<?php

Router::connect('/login', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'logout'));
Router::connect('/register', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'register'));
Router::connect('/me', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'index'));
Router::connect('/users', array('plugin' => 'NiceAuth', 'controller' => 'users', 'action' => 'index'));
Router::connect('/dashboard', array('plugin' => 'NiceAuth', 'controller' => 'dashboard', 'action' => 'index'));
Router::connect('/users/:action/*', array('plugin' => 'NiceAuth', 'controller' => 'users'));
Router::connect('/dashboard/:action/*', array('plugin' => 'NiceAuth', 'controller' => 'dashboard'));
?>