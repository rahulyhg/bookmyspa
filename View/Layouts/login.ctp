<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FooTab</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700italic,700,600italic,600,400italic,300italic,300,800,800italic' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <?php 
    echo $this->Html->script('jquery-1.7.2.min.js');
	echo $this->Html->script('jquery.validate.js');
        echo $this->Html->script('ajaxupload.js');
	echo $this->Html->script('user/sociallogin');
	
    echo $this->Html->css('home/bootstrap.min');
    echo $this->Html->css('home/custom');
    echo $this->Html->css('home/media');
   	echo $this->Html->css('layout'); 
	echo $this->Html->css('style');
	
    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<!--Header Start-->
	<header class="header navbar" role="navigation">
	    <?php echo $this->element('header'); ?>
	</header>
	<!--Header Closed-->
	  <!--Content Start-->
	  <section class="container"> 
	    <!--Wrapper Start-->
	    <section id="wrapper">
	      <!--Content Start-->
	      <section class="content">
		<?php echo $this->fetch('content'); ?>
	      </section>
	      <!--Content Closed-->
	      <!--Footer Start-->
	      <footer id="main-footer">
		<?php echo $this->element('footer'); ?>
	      </footer>
	      <!--Footer Closed-->
	    </section>
	    <!--Wrapper Closed-->
	  </section>
	  <!--Content Closed-->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
	<?php
		 //echo $this->Html->script('jquery.min'); 
		// echo $this->Html->script('jquery-1.7.2.min');	
	?>
  
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <?php
    echo $this->Html->script('bootstrap.min.js');
    //echo $this->Html->script('carousel.js');
    echo $this->Html->script('home/home.js');
    echo $this->Html->script('home/quiz.js');
    echo $this->Html->script('home/list.js');
    echo $this->Html->script('home/poll.js');
    echo $this->Html->script('home/lineup.js');
    ?>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
 <script>
$(function(){
        $('#add_open').click(function(){
        $( "#togle" ).toggle();
    });
});

</script>
        
    
    
  </body>
</html>
