<html>
<head>
<?php echo $this->Html->charset('UTF-8'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0,initial-scale=1.0,user-scalable=yes" />
  <?php 
        echo $this->Html->css('reset');
        echo $this->Html->css('layout'); 
		echo $this->Html->css('style');
		echo $this->Html->css('media');
		echo $this->Html->css('home/bootstrap.min');
        
        //echo $this->Html->css('admin/login');
	echo $this->Html->script('jquery-1.7.2.min.js');
	echo $this->Html->script('jquery.validate.js');
	echo $this->Html->script('user/sociallogin');
    ?>
    <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
<!--[if lt IE 9]>
      <style type="text/css">
		.bg{ behavior: url(js/PIE.htc); }
      </style>
      <![endif]-->
<title>FooTab</title>
</head>
<body id="page1">
<div class="body1">
	<div class="body2">
	    <div class="main">
		<header>
			<?php echo $this->element('header'); ?>
		  </header>
	    </div>
	</div>
</div>
	<section class="main-container">
        <?php echo $this->fetch('content'); ?>    
        </section>
<div class="main">
<!-- footer -->
      <footer>
	    <?php echo $this->element('footer'); ?>
      </footer>
<!-- footer end -->
</div>
</body>
</html> 
