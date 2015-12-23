<!DOCTYPE html>
<html lang="en">

        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title_for_layout; ?></title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700italic,700,600italic,600,400italic,300italic,300,800,800italic' rel='stylesheet' type='text/css'>
        <!-- Bootstrap -->
        <!--        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
        <script>var jQuery19 = jQuery.noConflict(); </script>-->
        <?php if(count($indexvalue)){   ?>
        <?php if (!empty($content['Text'])) {$des =  strip_tags(substr($content['Text'][0]['text'], 0,100));}else{$des="";} ?>
         <meta name="description" content="<?php echo  trim($des); ?>"/>
         <meta name="title" content="<?php echo $content['Content']['title'];?>"/>
         <link rel="canonical" href="<?php echo  $tagurl=Router::url( $this->here,true); ?>"/>
         <meta property="og:site_name" content="FootyBase"/>
         <meta property="og:type" content="article" />
         <meta property="og:url" content="<?php echo  $tagurl=Router::url( $this->here,true); ?>"/>
         <meta property="og:title" content="<?php echo $content['Content']['title'];?>"/>
         <meta property="og:description" content="<?php echo  trim($des); ?>"/>
         <?php if(!empty($content['Photo'][0]['image'])){ 
            if ($content['Photo'][0]['image_type'] == 'file') {
                  $image_name = $content['Photo'][0]['image'];
                  $meta_img =   BASE_URL."app/webroot/img/photos/original/".$image_name;
                    } else {
                   $meta_img =$content['Photo'][0]['image'];
                     }
                   } else {
                     if($this->Common->get_videothumb($content['Content']['id'])){
                      $meta_img = $this->Common->get_videothumb($content['Content']['id']);   
                     }else{
                     $meta_img =   BASE_URL."app/webroot/img/photos/original/soccer-ball-128.png"; }
                     //$this->Html->url('/img/photos/original/soccer-ball-128.png',true);
            } ?>
         <meta property="og:image" content="<?php echo $meta_img; ?>"/>  
         <link rel="image_src" href="<?php echo $meta_img; ?>"/>
        
        <?php   }  ?>
        <?php 
        echo $this->Html->css('home/bootstrap.min');
        echo $this->Html->css('home/custom');
        echo $this->Html->css('home/developer');
        echo $this->Html->css('home/media');
	echo $this->Html->css('jquery.bxslider');
        echo $this->Html->css('style/jquery.jscrollpane.css'); 
	echo $this->Html->script('jquery-1.7.2.min');
	echo $this->Html->script('jquery.bxslider');
        echo $this->Html->script('ajaxupload');
        echo $this->Html->script('home/scroll'); 
        //echo $this->Html->script('scroll/jquery.mCustomScrollbar.concat.min'); 
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
        <?php echo $this->element('header'); ?>
    <!--Header Closed-->
    <!--Slider Start-->
<?php if(($this->params['action'] =='post_details') || ($this->params['action'] =='tag_contents')){
		echo ''; 
		}else{ //echo $this->element('slider');
		}
	?>
    <!--Slider End--> 
<!--Content Start-->	
   <section class="container container-common"> 
<?php echo $this->fetch('content'); ?>
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
    echo $this->Html->script('bootstrap-hover-dropdown.js');
    echo $this->Html->script('carousel.js');
    echo $this->Html->script('home/home.js');
    echo $this->Html->script('home/quiz.js');
    echo $this->Html->script('home/list.js');
    echo $this->Html->script('home/poll.js');
    echo $this->Html->script('home/lineup.js');
    echo $this->Html->script('home/meme.js');
    echo $this->Html->script('home/text.js');
    echo $this->Html->script('home/photo.js');
    echo $this->Html->script('home/slide.js');
    echo $this->Html->script('home/video.js');
    echo $this->Html->script('home/comment.js');
    echo $this->Html->script('home/jquery.confirm.js');
    echo $this->html->script('tagit/jquery.tagsinput.js');
     ?>
<!--        
         <script type='text/javascript' src='http://xoxco.com/x/tagsinput/jquery-autocomplete/jquery.autocomplete.min.js'></script>-->
<!--	<link rel="stylesheet" type="text/css" href="http://xoxco.com/x/tagsinput/jquery-autocomplete/jquery.autocomplete.css" />

    -->
<!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    
    <script>
    // very simple to use!
    $(document).ready(function() {
      $('.js-activated').dropdownHover().dropdown();
    });
  </script>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js'></script>	
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<!--Footer Start-->
            <footer id="main-footer">
             <?php echo $this->element('footer'); ?>
            </footer>
			<?php echo $this->element('sql_dump');?>
            <!--Footer Closed-->
</body>
</html>
