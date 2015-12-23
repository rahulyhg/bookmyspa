<!DOCTYPE html>
<html>
<head>
	<?php ini_set('default_charset', 'utf-8');
	header ('Content-Type: text/html; charset=UTF-8'); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<?php echo $this->Html->meta ( 'favicon.ico', '/img/favicon.ico', array ( 'type' => 'icon'  ) ); ?>
	<!-- Bootstrap -->
        <?php echo $this->Html->charset(); ?>
	
       <?php
		     $metaData  = $this->frontCommon->getMetatags('1');
		     if(count($metaData)){ ?>
				   <title>Sieasta | <?php echo $title_for_layout; ?></title>
				   <meta name="description" content="<?php echo $metaData['MetaTag']['description']; ?>">
				   <meta name="keywords" content="<?php echo $metaData['MetaTag']['keywords']; ?>">
		<?php    }else{ ?>
				<title>Sieasta | <?php echo $title_for_layout; ?></title>
		<?php }  ?>
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <?php
	$version_time = time(); 
	echo $this->Minify->css(array('frontend/bootstrap',
				    'admin/plugins/select2/select2',
				    'frontend/developer.css',
				    'frontend/form-step',
				   
				    //'frontend/multiple-select',
				    'frontend/form',
				    'Font-Awesome/css/font-awesome',
				    'datepicker/datepicker-css',
				    'admin/jquery.mCustomScrollbar.css',
				    )); ?>
	<?php echo $this->Minify->css(array('frontend/custom.css', 'frontend/media.css','radio-chkbox','jquery-ui','admin/jquery.timepicker')); ?>
	<?php //echo $this->Html->css('admin/plugins/colorbox/colorbox'); ?>
	<!-- select2 -->
	<?php

	if($this->Session->read('Config.language')){
		$SessionLang = $this->Session->read('Config.language');
		if($SessionLang == 'ara'){
			echo $this->Html->css('frontend/arabic.css');
		}
	}
	?>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
	<![endif]-->
	<?php 
        echo $this->fetch('meta');
	echo $this->fetch('css');
	 echo $this->Minify->script(array('html5shiv.min.js','respond.min.js','frontend/jquery-1.11.1.js','frontend/cookie.js')); 
	/* development js end*/
	echo $this->fetch('script');
	
	?>
	<style>
	.loader-container {
	    background: rgba(0, 0, 0, 0.5);
	    height: 100%;
	    position: fixed;
	    width: 100%;
	    z-index: 1;
	}
	.loader-container .inner-loader {
	    left: 50%;
	    margin-left: -16px;
	    margin-top: -16px;
	    position: absolute;
	    top: 50%;
	}
	</style>
	
</head>
<body>
	<div id="ajax_modal" class="loader-container" style="display: block;">
		<div class="inner-loader"><img title="" alt="" src="/img/gif-load.GIF"></div>
	</div>
	
	<div class="modal fade bs-example-modal-sm" id="mySmallModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	</div>
	<div class="modal fade"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
      <?php //echo $this->Html->script('frontend/cookie.js'); ?>
	<?php echo $this->element('header'); 
	echo $this->Session->flash();
	echo $this->Form->create('User', array('type' => 'post'), array( 'url' => array('controller' => 'search', 'action' => 'index')));
	echo $this->element('frontend/Search/search-bar'); ?>
		<div id="update_ajax"><?php echo $this->fetch('content'); ?></div>
	<?php echo $this->Form->end();
	echo $this->element('footer'); ?>
		
		
	<?php echo $this->Minify->script(array('frontend/bootstrap',
			'frontend/custom-form-elements',
			'admin/jquery.form',
			'admin/modal_common',
			'admin/plugins/select2/select2.min',
			'frontend/index',
			'datepicker/datepicker-js',
			'jquery-ui',
			'admin/jquery.mCustomScrollbar.concat.min.js',
			'admin/jquery.timepicker',
			'easing.min.js'
		)); ?>

	<?php //echo $this->Html->script('frontend/index.js'); ?>
	<?php //echo $this->Html->script('frontend/jquery.validate'); ?>
	<?php //echo $this->Html->script('frontend/jquery.multiple.select'); ?>
	<?php //echo $this->Html->script('datepicker/datepicker-js'); ?>
	<?php //echo $this->Html->script('jquery.lightslider'); ?>
	<?php //echo $this->Html->script('jquery-ui');
	echo $this->element('sql_dump');
	//echo $this->Html->script('admin/jquery.mCustomScrollbar.concat.min.js'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document)
			.ajaxStart(function(){
				$(document).find('#ajax_modal').show();
			})
			.ajaxStop(function(){
				setTimeout(function(){
					$(document).find('#ajax_modal').hide();
				},1000);
			});
			
			$(window).load(function(){
				setTimeout(function(){
					$(document).find('#ajax_modal').hide();
				},1000);
			});
			$('.main-search .navbar-toggle').on('click',function(){
	    
				if(!$("#bs-example-navbar-collapse-2").hasClass('in')){
				   $('.big-rgt').css('margin-top','900px');
				    $('#ajax_modal').show();
				   setTimeout(function(){
					 $('#ajax_modal').hide();
					     $('.big-rgt').css('margin-top','0px');
				   },5700);   
				}else{
					 $('#ajax_modal').hide();
				   $('.big-rgt').css('margin-top','0px');
				}
				
			});
		});
	</script>
  </body>
</html>