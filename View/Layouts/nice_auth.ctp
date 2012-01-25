<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title_for_layout?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<?php echo $this->Html->css('/nice_auth/css/nice_auth.css'); ?>
</head>
<body>
<div id="container">
<div id="header">
	<h1><a href="/dashboard">NiceAuth - User Authorization Manager</a></h1>
</div>
<div id="nav">
	<ul class="menu">
		<li><?php echo $this->Html->link('Dashboard', array('plugin' => 'nice_auth', 'controller' => 'dashboard', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Groups', array('plugin' => 'nice_auth', 'controller' => 'dashboard', 'action' => 'groups')); ?></li>
		<li><?php echo $this->Html->link('Users', array('plugin' => 'nice_auth', 'controller' => 'dashboard', 'action' => 'users')); ?></li>
		<li><?php echo $this->Html->link('Database Functions', array('plugin' => 'nice_auth', 'controller' => 'dashboard', 'action' => 'database')); ?></li>
		<li><?php echo $this->Html->link('Help', array('plugin' => 'nice_auth', 'controller' => 'dashboard', 'action' => 'help')); ?></li>
	</ul>
	<div class="bottombar"></div>
</div>

<div id="content">
<?php
	echo $this->Session->flash();
	echo $content_for_layout;
?>
</div>

<div id="footer">NiceAuth</div>
</div>

</body>
</html>