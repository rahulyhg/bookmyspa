<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
        <title><?php echo 'Sieasta'?> | <?php echo $page_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="description" content="Sieasta">
        <meta name="author" content="Sieasta">
		<!-- Apple devices fullscreen -->
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<!-- Apple devices fullscreen -->
		<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<?php //echo $this->Html->meta('icon');
                echo $this->Html->meta ( 'favicon.ico', '/img/favicon.ico', array (
                        'type' => 'icon' 
                    ) );
                ?>
            <?php echo $this->Html->css('admin/bootstrap3'); ?>
			<?php //echo $this->Html->css('admin/plugins/jquery-ui/smoothness/jquery-ui'); ?>
			<?php //echo $this->Html->css('admin/plugins/jquery-ui/smoothness/jquery.ui.theme'); ?>
			<?php echo $this->Html->css('admin/plugins/datatable/TableTools'); ?>
			<?php echo $this->Html->css('admin/plugins/pageguide/pageguide'); ?>
			<?php echo $this->Html->css('admin/plugins/chosen/chosen'); ?>
			<?php echo $this->Html->css('admin/plugins/select2/select2.css?v=1'); ?>
			<?php //echo $this->Html->css('admin/plugins/icheck/all'); ?>
			<?php echo $this->Html->css('admin/form'); ?>
			<?php echo $this->Html->css('admin/bootstrap-switch'); ?>
			<?php echo $this->Html->css('admin/developers'); ?>
			<?php echo $this->Html->css('admin/custom'); ?>
			<?php echo $this->Html->css('frontend/multiple-select'); ?>
			<?php echo $this->Html->css('admin/themes_not_minified'); ?>
			
			<?php echo $this->Html->css('admin/developer.css?v=1'); ?>
			
			<?php echo $this->Html->css('admin/style_not_minified.css?v=7'); ?>
			
			<?php echo $this->Html->css('admin/color/red.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/orange.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/green.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/brown.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/blue.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/lime.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/teal.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/purple.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/pink.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/magenta.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/grey.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/darkblue.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/lightred.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/lightgrey.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/satblue.css?v=5'); ?>
			<?php echo $this->Html->css('admin/color/satgreen.css?v=5'); ?>
			
			<?php echo $this->Html->css('lightslider'); ?>
			<?php echo $this->fetch('meta'); ?>
			<?php echo $this->fetch('css'); ?>
			<?php echo $this->Html->css('admin/Font-Awesome/css/font-awesome.css'); ?>
			<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
			<?php echo $this->Html->css('admin/jquery.mCustomScrollbar.css') ?>
			<?php echo $this->Html->css('admin/jquery.bxslider.css'); ?>
			<?php echo $this->Html->css('admin/plugins/colorbox/colorbox'); ?>
                        <?php echo $this->Html->css('bootstrap-switch/bootstrap3/bootstrap-switch'); ?>
                        <?php echo $this->Html->css('jquery-ui'); ?>

                        <link href="/css/kendo/kendo.common.min.css" rel="stylesheet">
			<link href="/css/kendo/kendo.rtl.min.css" rel="stylesheet">
			<link href="/css/kendo/kendo.default.min.css" rel="stylesheet">
     
			<!-- jQuery -->
			<?php echo $this->Html->script('admin/jquery.min.js?v=1'); ?>
			<?php echo $this->Html->script('admin/plugins/touchwipe/touchwipe.min'); ?>
			<?php echo $this->Html->script('admin/plugins/nicescroll/jquery.nicescroll.min'); ?>
			<?php echo $this->Html->script('admin/plugins/jquery-ui/jquery.ui.core.min'); ?>
			<?php echo $this->Html->script('admin/plugins/jquery-ui/jquery.ui.widget.min'); ?>
			<?php echo $this->Html->script('admin/plugins/jquery-ui/jquery.ui.mouse.min'); ?>
			<?php echo $this->Html->script('admin/plugins/jquery-ui/jquery.ui.draggable.min'); ?>
			<?php echo $this->Html->script('admin/plugins/jquery-ui/jquery.ui.resizable.min'); ?>
			<?php echo $this->Html->script('admin/plugins/jquery-ui/jquery.ui.sortable.min'); ?>
			<?php echo $this->Html->script('admin/plugins/jquery-ui/jquery.ui.spinner.js'); ?>
			<?php echo $this->Html->script('admin/plugins/touch-punch/jquery.touch-punch.min'); ?>
			<?php echo $this->Html->script('admin/plugins/slimscroll/jquery.slimscroll.min'); ?>
			<?php echo $this->Html->script('admin/bootstrap.min'); ?>
			<?php echo $this->Html->script('admin/bootstrap-modalmanager'); ?>
			<?php echo $this->Html->script('admin/bootstrap-modal'); ?>
			<?php echo $this->Html->script('admin/custom-form-elements'); ?>
			<?php echo $this->Html->script('admin/jquery.mCustomScrollbar.concat.min.js'); ?>
			<?php echo $this->Html->script('admin/plugins/bootbox/jquery.bootbox'); ?>
			<?php echo $this->Html->script('admin/plugins/datatable/jquery.dataTables'); ?>
			<?php echo $this->Html->script('admin/plugins/datatable/ColReorderWithResize'); ?>
			<?php echo $this->Html->script('admin/plugins/flot/jquery.flot.min'); ?>
			<?php echo $this->Html->script('admin/plugins/flot/jquery.flot.bar.order.min'); ?>
			<?php echo $this->Html->script('admin/plugins/flot/jquery.flot.pie.min'); ?>
			<?php echo $this->Html->script('admin/plugins/flot/jquery.flot.resize.min'); ?>
			<?php echo $this->Html->script('admin/plugins/imagesLoaded/jquery.imagesloaded.min'); ?>
			<?php echo $this->Html->script('admin/plugins/pageguide/jquery.pageguide'); ?>
			<?php echo $this->Html->script('admin/plugins/chosen/chosen.jquery.min'); ?>
			<?php echo $this->Html->script('admin/plugins/select2/select2.min'); ?>
			<?php //echo $this->Html->script('admin/plugins/icheck/jquery.icheck.min'); ?>
			<?php echo $this->Html->script('admin/plugins/masonry/jquery.masonry.min'); ?>
			<?php echo $this->Html->script('admin/eakroko.min'); ?>
			<?php echo $this->Html->script('admin/application'); ?>
			<?php echo $this->Html->script('admin/demonstration'); ?>
			<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
			<?php echo $this->Html->script('ckfinder/ckfinder'); ?>
			<?php echo $this->Html->script('admin/jquery.form'); ?>
			<?php echo $this->Html->script('admin/modal_common'); ?>
			<?php echo $this->Html->script('admin/plugins/colorbox/jquery.colorbox-min'); ?>
			<?php echo $this->Html->script('admin/jquery.bxslider.js'); ?>
			<?php //echo $this->Html->script('admin/plugins/datepicker/bootstrap-datepicker'); ?>
			
			<?php echo $this->Html->css('lightslider/lightGallery'); ?>
			<?php echo $this->Html->script('lightslider/lightGallery'); ?>
			<?php echo $this->Html->script('jquery-ui'); ?>
			<?php echo $this->Html->script('jquery.lightslider'); ?>
			<?php //echo $this->Html->script('checkout/checkout'); ?>

			<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
			<!--[if lte IE 9]>
		        <?php echo $this->Html->script('admin/plugins/placeholder/jquery.placeholder.min'); ?>
            	<script>
					$(document).ready(function() {
						$('input, textarea').placeholder();
					});
				</script>
			<![endif]-->
			<!-- Validations -->
			<?php echo $this->Html->script('frontend/jquery.validate'); ?>
			<?php echo $this->Html->script('admin/additional-methods.min'); ?>
			<?php echo $this->Html->script('frontend/jquery.multiple.select'); ?>
<!--			<link rel="shortcut icon" href="img/favicon.ico" />-->
                        <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-precomposed.png" />
			<?php echo $this->Html->script('bootstrap-switch/js/bootstrap-switch'); ?>
			 <script src="/js/kendo/kendo.all.min.js"></script>
			
			<?php echo $this->fetch('script'); ?>

</head>
<?php
if(isset($auth_user)){$theme = $this->Common->getThemeId($auth_user);} ?>
<body <?php if(isset($theme)){ echo 'class="theme-'.$theme.'" data-theme="theme-'.$theme.'"'; } ?> data-mobile-sidebar="button" >
<div class="loader-container">
	<div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
</div>

<!--  Large Container Modal POPUP-->
<div class="modal fade" id="commonContainerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!--<div id="commonContainerModal" class="modal container hide fade" tabindex="-1"></div>-->

<!--  Medium Container Modal POPUP-->
<div class="modal fade" id="commonMediumModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<!--  Small Modal POPUP-->
<div class="modal fade" id="commonSmallModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<!--  Vendor Modal POPUP-->
<div class="modal fade" id="commonVendorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	
</div>
 <?php echo $this->element('admin/header'); ?>
        <div class="container-fluid " id="content">
		<?php
			if(isset($this->params) && !empty($this->params) && strtolower($this->params['controller']) == 'appointments' ){
				echo $this->element('admin/left_menu_appointment');
				?>
				
			<?php
			}
			elseif(isset($leftMenu)){
				 echo $this->element('admin/left_menu'); 
			}else{ ?>
				<style>
					#main{
						margin-left: 0px;
					}
				</style>
			<?php }
			?>
			<div id="main">
				<div class="container-fluid">
					<div class="page-header">
						<?php 	echo $this->element('admin/page_header');  ?>
					</div>
					<?php if(isset($breadcrumb)){
						echo $this->element('admin/breadcrumb');
					}
					?>
						<?php echo $this->Session->flash(); ?>
						<div class="cust-manage123">
						<?php echo $this->fetch('content'); ?></div>
					
<?php echo $this->element('sql_dump'); ?>
				</div>
			</div>
        </div>
<?php
// $sec should be dynamic;
if(AuthComponent::User()){

      if(!($this->Session->read('Auth.from_user') && $this->Session->read('Auth.from_user')==1)){
      
      
	if($auth_user['Salon']['logout_time']){
	
		$sec = 60 * $auth_user['Salon']['logout_time'];
		$redirectURL = $this->Html->url(array('controller'=>'Users','action'=>'lock','admin'=>true));
		$toLogout = $sec * 1000;
	?>
		<script>
			var logoutTimeInMin = <?php echo $auth_user['Salon']['logout_time']?>;
			var logoutTimeInSec = <?php echo $toLogout ?>;
			var idleTime = 0;
				//Increment the idle time counter every minute.
				var idleInterval = setInterval(timerIncrement, logoutTimeInSec/2); // 1 minute
				//Zero the idle timer on mouse movement.
				$(this).mousemove(function (e) {
					idleTime = 0;
				});
				$(this).keypress(function (e) {
					idleTime = 0;
				});
			
			function timerIncrement() {
				if (logoutTimeInMin == 1) {
					idleTime = idleTime + 0.5;
				}else{
					idleTime = idleTime + 1;
				}
				if (idleTime >= logoutTimeInMin) { 
					window.location.href = "<?php echo $redirectURL ?>";
				}
			}
			
			//setInterval(function(){
			//	window.location.href = "<?php echo $redirectURL ?>";
			//}, '<?php echo $toLogout; ?>');
		</script>
		<?php 
	}
 }
    
      echo $this->element('admin/wizard_popup_new');
	
}
?>
<script>
	$(window).load(function(){
		 $('label').each(function(){
                  var text = $(this).html();
			if(text.indexOf('*') != -1){
				text = text.replace('*:','<span style="color:red;">*</span>');
			       $(this).html(text);
			}else if(text.indexOf(':') != -1){
				if($.trim(text) != 'Search:'){
					text = text.replace(':','');
					$(this).html(text);
				}
				
			}
			
            
            });	
		
	});
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
		
		var windowH = $( window ).height();
		var leftH = windowH-72;
		$(document).find("#left").css('height',leftH+'px');
		$(document).find("#left").mCustomScrollbar({
			advanced:{updateOnContentResize: true,
                        },
		});
	/*********************For phone validation **************************/	
	$(document).on("keyup","input[name='data[Contact][cell_phone]'],input[name='data[Contact][night_phone]'], .phone_err" ,function(){
		if($(this).val().charAt(0)==='0')
		{
		  $(this).val('');
		}
		$(this).attr("minlength", '9');
		$(this).attr("data-minlength-msg", 'Minimum 9 characters.');	
			
	});
	
	$(document).on("keyup","input[name='data[Contact][day_phone]']" ,function(){
		if($(this).val().charAt(0)==='0')
		{
		  $(this).val('');
		}
		$(this).attr("minlength", '6');
		$(this).attr("data-minlength-msg", 'Minimum 6 characters.');	
			
	});
	/*********************For disable manual enter dates**************************/
	$(document).on('keypress','.datepicker',function(e){
		e.preventDefault();	
	});	
		
	});
</script>
</body>
</html>
