<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site Map</title>
    <!-- Bootstrap -->
    <?php 
    $version_time = time();
    echo $this->Html->css(
      array(
	'frontend/bootstrap',
	'frontend/custom.css?v='.$version_time,
	'frontend/form-step',
	'frontend/media.css?v='.$version_time,
	'frontend/form',
	'Font-Awesome/css/font-awesome'
      )
    ); ?>
    <!--arabic css--
    <link href="css/arabic.css" rel="stylesheet" type="text/css" />
    <!--arabic css-->
	<?php echo $this->Html->script('frontend/custom-form-elements.js'); ?>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
  
<?php   echo $this->element('header'); ?>
 
<div class="wrapper">
  <div class="container">
    <!--main body section starts-->
    <div class="col-sm-12 business">
      <?php echo $this->fetch('content'); ?>
    </div>
    <!--main body section ends-->
    </div>
  </div>
  <?php echo $this->element('footer'); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $(".custom-select").each(function(){
            $(this).wrap("<span class='select-wrapper pull-right'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom-select").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
		
		//////////// Another select option ////////////////
		
		$(".custom_option").each(function(){
            $(this).wrap("<span class='option_wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom_option").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
		
    })
	</script>
    <!-- jQuery easing plugin -->
	<script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>
    <script src="js/index.js"></script>
</body>
</html>