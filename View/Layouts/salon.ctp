<!DOCTYPE html>
<html>
	<head>
		<?php
		ini_set('default_charset', 'utf-8');
		header ('Content-Type: text/html; charset=UTF-8'); ?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<?php echo $this->Html->meta ( 'favicon.ico', '/img/favicon.ico', array ('type' => 'icon' ) );?>
		<!-- Bootstrap -->
		<?php echo $this->Html->charset(); ?>
		
		<?php
		if(isset($salonId) && !empty($salonId)){
			$salonMataId = $salonId;
		}else{
			$salonMataId = 1;
		}
		$metaData  = $this->frontCommon->getMetatags($salonMataId);
		     if(count($metaData)){ ?>
				<title><?php echo $metaData['MetaTag']['title']; ?></title>
				<meta name="description" content="<?php echo $metaData['MetaTag']['description']; ?>">
				<meta name="keywords" content="<?php echo $metaData['MetaTag']['keywords']; ?>">
		<?php  }else{  ?>
			<title>Sieasta | <?php echo $title_for_layout; ?></title>
		<?php } ?>
		<!--<meta name="description" content="Sieasta">
		<meta name="author" content="Sieasta">-->
		<!-- Apple devices fullscreen -->
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<!-- Apple devices fullscreen -->
		<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<?php
		$version_time = time();
		echo $this->Minify->css(array('frontend/bootstrap','frontend/star-rating.css','frontend/developer.css','admin/Font-Awesome/css/font-awesome.css','Font-Awesome/css/font-awesome','jquery.bxslider','admin/jquery.mCustomScrollbar.css'));
		echo $this->Minify->css(array('frontend/custom.css','frontend/media.css','jquery-ui','/css/kendo/kendo.common.min.css','/css/kendo/kendo.rtl.min.css','/css/kendo/kendo.default.min.css','admin/plugins/select2/select2'));
		
		if($this->Session->read('Config.language')){
			$SessionLang = $this->Session->read('Config.language');
			if($SessionLang == 'ara'){
				echo $this->Html->css('frontend/arabic.css');
			}
		}
		
		?>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
		<!--<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>-->
		<![endif]-->
		<?php 
		echo $this->fetch('meta');
		echo $this->fetch('css');
		 echo $this->Minify->script(array('html5shiv.min.js','respond.min.js','frontend/jquery-1.11.1.js','frontend/star-rating.js?v=1')); 
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
		<?php echo $this->element('header');
		echo $this->Session->flash(); 
		//echo $this->Session->flash('auth');
		if(isset($showSearch) && ($showSearch==true)){
			echo $this->element('main_search');
		} elseif(isset($showSmallSearch) && ($showSmallSearch==true)){
			echo $this->element('frontend/Search/search-bar'); 
		} ?> 
		<div id="update_ajax">
			<?php echo $this->fetch('content'); ?>
		</div>
		<?php echo $this->element('footer');
		echo
	$this->Minify->script(array('easing.min.js','frontend/bootstrap.js','frontend/custom-form-elements.js','admin/jquery.form','admin/modal_common','frontend/index.js','jquery-ui','kendo/kendo.all.min.js','admin/plugins/select2/select2.min','admin/jquery.mCustomScrollbar.concat.min.js','jquery.bxslider','frontend/cookie.js','frontend/widget.js','frontend/date.js','frontend/jquery.weekcalendar.js'));
		 ?>
              
		
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
					},1000);
				});
				
				$(window).load(function(){
					setTimeout(function(){
							$(document).find('.loader-container').hide();
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
