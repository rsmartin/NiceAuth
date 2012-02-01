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
	<h1><?php echo $this->Html->link('NiceAuth - User Authorization Manager', array('plugin' => 'NiceAuth', 'controller' => 'dashboard')); ?></h1>
</div>
<div id="nav">
	<ul class="menu">
		<li><?php echo $this->Html->link('Dashboard', array('controller' => 'dashboard', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('Groups', array('controller' => 'dashboard', 'action' => 'groups')); ?></li>
		<li><?php echo $this->Html->link('Users', array('controller' => 'dashboard', 'action' => 'users')); ?></li>
		<li><?php echo $this->Html->link('Database Functions', array('controller' => 'dashboard', 'action' => 'database')); ?></li>
		<li><?php echo $this->Html->link('Help', array('controller' => 'dashboard', 'action' => 'help')); ?></li>
	</ul>
	<div class="bottombar"></div>
</div>

<div id="content">
<?php
	echo $this->Session->flash();
	echo $content_for_layout;
?>
</div>

<div id="footer">NiceAuth : <a href="https://github.com/rsmartin/NiceAuth">GitHub</a></div>
</div>

</body>
</html>