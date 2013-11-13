<?php echo $this->Html->docType('html5'); ?>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php echo Configure::read('App.meta.description'); ?>">
    <meta name="author" content="<?php echo Configure::read('App.meta.author'); ?>">
    <title><?php echo $title_for_layout; ?></title>
    <?php
        echo $this->Html->meta('icon');

        echo $this->fetch('meta');

        echo $this->Html->css('bootstrap3');
        echo $this->Html->css('application');
        echo $this->Html->css('signin');

        echo $this->fetch('css');

        echo $this->fetch('script');
    ?>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <?php echo $this->Html->script('html5shiv'); ?>
        <?php echo $this->Html->script('respond.min'); ?>
    <![endif]-->
  </head>
  <body>
    <div class="container">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>
    <?php echo $this->element('sql_dump'); ?>
  </body>
</html>