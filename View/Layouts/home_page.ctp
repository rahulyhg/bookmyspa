<!DOCTYPE html>
<html>
	<head>
		<?php
		ini_set('default_charset', 'utf-8');
		header ('Content-Type: text/html; charset=UTF-8'); ?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<?php echo $this->Html->meta( 'favicon.ico', '/img/favicon.ico', array (
			'type' => 'icon' )); ?>
		<!-- Bootstrap -->
		<?php echo $this->Html->charset(); ?>
		<!--<title>Sieasta | <?php //echo $title_for_layout; ?></title>-->
		<?php
		$metaData  = $this->frontCommon->getMetatags('1');
		     if(count($metaData)){ ?>
				   <title><?php echo $metaData['MetaTag']['title']; ?></title>
				   <meta name="description" content="<?php echo $metaData['MetaTag']['description']; ?>">
				   <meta name="keywords" content="<?php echo $metaData['MetaTag']['keywords']; ?>">
		<?php    }else{  ?>
			  <title>Sieasta | <?php echo $title_for_layout; ?></title>
		<?php }  ?>
		<!--<meta name="description" content="Sieasta">
		<meta name="author" content="Sieasta">-->
		<!-- Apple devices fullscreen -->
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<!-- Apple devices fullscreen -->
		<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		
		<?php
		$version_time = time();
		echo $this->Minify->css(array('frontend/bootstrap',
			'admin/plugins/select2/select2',
			'frontend/developer.css',
			//'frontend/form-step',
			//'frontend/multiple-select',
			//'frontend/form',
			//'admin/Font-Awesome/css/font-awesome.css',
			'Font-Awesome/css/font-awesome',
			'datepicker/datepicker-css',
			//'lightslider',
			//'radio-chkbox'
		));
		
		echo $this->Minify->css(array('frontend/custom.css','frontend/media.css','jquery-ui'));
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
		<!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
		<![endif]-->
		<?php 
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->Minify->script(array('html5shiv.min.js','respond.min.js','frontend/jquery-1.11.1.js'));
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
		<script>
	  
	
	</script>
	</head>
	<body>
		<div id="ajax_modal" class="loader-container" style="display: block;">
			<div class="inner-loader"><img title="" alt="" src="/img/gif-load.GIF"></div>
		</div>
		<div class="modal fade bs-example-modal-sm" id="mySmallModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		</div>
		<div class="modal fade"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
		<?php   echo $this->element('header');
			echo $this->Session->flash(); 
			echo $this->element('main_search');
		?> 
		<div id="update_ajax">
			<?php echo $this->fetch('content'); ?>
		</div>
		<?php
		echo $this->element('footer');
		
		echo $this->Minify->script(array('frontend/bootstrap.js','frontend/index.js','datepicker/datepicker-js','frontend/cookie.js','jquery-ui','easing.min.js'));
		
		echo $this->element('sql_dump'); ?>
		<!--<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>-->
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