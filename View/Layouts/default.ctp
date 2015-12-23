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
	<?php
		$metaData  = $this->frontCommon->getMetatags('1');
		
		if(count($metaData)){ ?>
			   <title><?php echo $metaData['MetaTag']['title']; ?></title>
			  <meta name="description" content="<?php echo $metaData['MetaTag']['description']; ?>">
			  <meta name="keywords" content="<?php echo $metaData['MetaTag']['keywords']; ?>">
		<?php    }else{  ?>
			<title>Sieasta | <?php echo $title_for_layout; ?></title>
		<?php } ?>
	
	<!-- Bootstrap -->
        <?php echo $this->Html->charset(); ?>
	
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <?php
	$version_time = time();
	echo $this->Minify->css(array('frontend/bootstrap','frontend/star-rating','frontend/developer.css','frontend/form-step','frontend/multiple-select','frontend/form','admin/Font-Awesome/css/font-awesome','Font-Awesome/css/font-awesome','datepicker/datepicker-css','lightslider','admin/jquery.mCustomScrollbar.css'));

echo $this->Minify->css(array('frontend/custom.css','frontend/media','jquery-ui','radio-chkbox','/css/kendo/kendo.common.min.css','/css/kendo/kendo.rtl.min.css','/css/kendo/kendo.default.min.css','admin/plugins/colorbox/colorbox','admin/plugins/select2/select2'));	
	
	
	if($this->Session->read('Config.language')){
		$SessionLang = $this->Session->read('Config.language');
		if($SessionLang == 'ara'){
			echo $this->Html->css('frontend/arabic.css');
		}
	}
	?>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
	   
	<?php 
        echo $this->fetch('meta');
	echo $this->fetch('css');
	
	 echo $this->Minify->script(array('html5shiv.min.js','respond.min.js','frontend/jquery-1.11.1.js','frontend/custom-form-elements.js','frontend/star-rating.js',
					     'admin/jquery.form',
					     'admin/modal_common',
					     'admin/plugins/select2/select2.min',
					     'admin/plugins/colorbox/jquery.colorbox-min'
					)); 
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
			//echo $this->element('main_search');
		}
		elseif(isset($showSmallSearch) && ($showSmallSearch==true)){
			echo $this->element('frontend/Search/search-bar'); 
		}
		?> 
		<div id="update_ajax"><?php echo $this->fetch('content'); ?></div>
		<?php echo $this->element('footer'); ?>
		
<?php echo $this->Minify->script(array(	'easing.min.js',
					'frontend/bootstrap.js',
					'frontend/cookie.js',
					'frontend/index.js',
	                                'frontend/jquery.validate.js',
					'frontend/jquery.multiple.select.js',
					'datepicker/datepicker-js.js',
					'jquery.lightslider.js',
					'jquery-ui',
					'admin/jquery.mCustomScrollbar.concat.min.js'
					
				));
			?>		
	
	<?php 
	if($this->params['controller'] != 'search' && $this->params['action'] != 'index') {
	?>
		<script src="/js/kendo/kendo.all.min.js"></script>
	<?php }?>
	<?php echo $this->element('sql_dump'); ?>
	<script>
		
		function callRequiredForm(){
			$('label').each(function(){
			var text = $(this).text();
				if(text.indexOf('*') != -1){
					text = text.replace('*','<span style="color:red;">*</span>');
				       $(this).html(text);
				}else if(text.indexOf(':') != -1){
					if($.trim(text) != 'Search:'){
						text = text.replace(':','');
						$(this).html(text);
					}
					
				}
			})	
		}
		$(document).ready(function(){
			$(document)
			.ajaxStart(function(){
				$(document).find('.loader-container').show();
			})
			.ajaxStop(function(){
				setTimeout(function(){
					$(document).find('.loader-container').hide();
					callRequiredForm();
				},1000);
			});
			
			$(window).load(function(){
				setTimeout(function(){
						$(document).find('.loader-container').hide();
						callRequiredForm();
				},1000);
			});
			$(document).on("keyup","input[name='data[Contact][cell_phone]'],input[name='data[Contact][night_phone]'],input[name='data[Contact][day_phone]']" ,function(){
				if($(this).val().charAt(0)==='0')
				{
				  $(this).val('');
				}
			});		
			
		});
	</script>
  </body>
</html>

