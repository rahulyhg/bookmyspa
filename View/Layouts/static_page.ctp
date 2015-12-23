<!DOCTYPE html>
<html>
	<head>
		<?php
		ini_set('default_charset', 'utf-8');
		header ('Content-Type: text/html; charset=UTF-8'); ?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<?php echo $this->Html->meta ( 'favicon.ico', '/img/favicon.ico', array (
			'type' => 'icon' ) );?>
		<!-- Bootstrap -->
		<?php echo $this->Html->charset(); ?>
		<title>Sieasta | <?php echo $title_for_layout; ?></title>
		<meta name="description" content="Sieasta">
		<meta name="author" content="Sieasta">
		<!-- Apple devices fullscreen -->
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<!-- Apple devices fullscreen -->
		<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		
		<?php
		$version_time = time();
		echo $this->Html->css(array('frontend/bootstrap',
			'frontend/custom.css?v='.$version_time,
			'admin/plugins/select2/select2',
			'frontend/developer.css?v='.$version_time,
			'frontend/media.css?v='.$version_time,
			'Font-Awesome/css/font-awesome',
			'datepicker/datepicker-css',
			'jquery-ui',
		)); 
		if($this->Session->read('Config.language')){
			$SessionLang = $this->Session->read('Config.language');
			if($SessionLang == 'ara'){
				echo $this->Html->css('frontend/arabic.css');
			}
		}?>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<?php 
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Html->script('frontend/jquery-1.11.1.js');
		echo $this->fetch('script');
		?>
	</head>
	<body>
		<div class="modal fade bs-example-modal-sm" id="mySmallModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"></div>
		<div class="modal fade"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
		<?php echo $this->element('header'); ?> 
		<div class="wrapper">
			<?php echo $this->fetch('content'); ?>
		</div>
		<?php echo $this->element('footer'); ?>
		<?php echo $this->Html->script('frontend/bootstrap.js');
		echo $this->Html->script('jquery-ui');
		echo $this->element('sql_dump'); ?>
		<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>
	</body>
</html>