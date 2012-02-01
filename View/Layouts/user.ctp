<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title_for_layout?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<?php
echo $this->Html->css('/nice_auth/css/nice_auth.css');
echo $this->Html->css('/nice_auth/css/openid-shadow.css');
echo $this->Html->script('/nice_auth/js/jquery-1.2.6.min.js');
echo $this->Html->script('/nice_auth/js/openid-jquery.js');
echo $this->Html->script('/nice_auth/js/openid-en.js');
?>

<script type="text/javascript">
	$(document).ready(function() {
		openid.setImgPath('<?php echo $this->Html->url(array('plugin' => 'NiceAuth', 'controller' => 'img')); ?>/');
		openid.init('openid');
		openid.setDemoMode(false);
	});
</script>

</head>
<body>

<p>&nbsp;</p>
<div id="container">
	<div id="nav">
		<ul class="menu">
			<li><?php echo $this->Html->link('Home', '/'); ?></li>
			<li><?php echo $this->Html->link('Logout', '/logout'); ?></li>
		</ul>
		<div class="bottombar"></div>
	</div>

	<div id="content">
	<?php
		echo $this->Session->flash();
		echo $content_for_layout;
	?>
	</div>
</div>

</body>
</html>