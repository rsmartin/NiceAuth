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
		<li><a href="/nice_auth/dashboard">Dashboard</a></li>
		<li><a href="/nice_auth/dashboard/groups">Groups</a></li>
		<li><a href="/nice_auth/dashboard/users">Users</a></li>
		<li><a href="/nice_auth/dashboard/database">Database Functions</a></li>
		<li><a href="">Help</a></li>
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