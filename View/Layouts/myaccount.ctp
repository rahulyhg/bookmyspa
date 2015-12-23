<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
 
?>
<!DOCTYPE html>
<html>
<head>
	
	<?php
	ini_set('default_charset', 'utf-8');
	header ('Content-Type: text/html; charset=UTF-8'); ?>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
       
	<?php       echo $this->Html->meta ( 'favicon.ico', '/img/favicon.ico', array (
			'type' => 'icon' 
		    ) );
	 ?>
	
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
	echo $this->Html->css('frontend/bootstrap'); ?>
	<?php echo $this->Html->css('frontend/custom.css?v='.$version_time); ?>
	<?php echo $this->Html->css('admin/plugins/select2/select2'); ?>
	<?php echo $this->Html->css('frontend/developer.css?v='.$version_time); ?>
	<?php echo $this->Html->css('frontend/media.css?v='.$version_time); ?>
	<?php echo $this->Html->css('admin/Font-Awesome/css/font-awesome.css'); ?>
	<?php echo $this->Html->css('Font-Awesome/css/font-awesome'); ?>
	<?php echo $this->Html->css('jquery-ui'); ?>
	
	
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
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php 
        echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->Html->script('frontend/jquery-1.11.1.js');
	 echo $this->Html->script('admin/modal_common'); 
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


		<?php   echo $this->element('header'); ?>
		<?php 	echo $this->Session->flash(); 
			//echo $this->Session->flash('auth'); ?>
		<?php
		if(isset($showSearch) && ($showSearch==true)){
			echo $this->element('main_search');
		}
		elseif(isset($showSmallSearch) && ($showSmallSearch==true)){
			echo $this->element('frontend/Search/search-bar'); 
		}
		?> 
		<div id="update_ajax">
			<?php echo $this->fetch('content'); ?>
		</div>
		<?php echo $this->element('footer'); ?>
		
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<?php echo $this->Html->script('frontend/bootstrap.js'); ?>
	<!-- Form.js -->
	 <?php //echo $this->Html->script('frontend/custom-form-elements.js'); ?>

	<!-- jQuery easing plugin -->
	<!--<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>-->
	
	<?php echo $this->Html->script('frontend/index.js'); ?>
	<?php echo $this->Html->script('jquery-ui'); ?>
	<?php echo $this->Html->script('admin/jquery.form'); ?>
	<?php echo $this->element('sql_dump'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document)
			.ajaxStart(function(){
				$(document).find('.loader-container').show();
			})
			.ajaxStop(function(){
				setTimeout(function(){
					$(document).find('.loader-container').hide();
					//callRequiredForm();
				},1000);
			});
			
			$(window).load(function(){
				setTimeout(function(){
						$(document).find('.loader-container').hide();
						//callRequiredForm();
				},1000);
			});
			
		});
	</script>
	
  </body>
</html>
