<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
         echo $this->Html->css('home/bootstrap.min');
        echo $this->Html->css('home/custom');
        echo $this->Html->css('home/developer');
        echo $this->Html->css('home/media');
	echo $this->Html->css('jquery.bxslider');
        echo $this->Html->css('style/jquery.jscrollpane.css'); 
	echo $this->Html->script('jquery-1.7.2.min');
	echo $this->Html->script('jquery.bxslider');
        //echo $this->Html->css('jquery.mCustomScrollbar'); 
        echo $this->Html->script('ajaxupload');
        echo $this->Html->script('home/scroll'); 
        //echo $this->Html->script('scroll/jquery.mCustomScrollbar.concat.min'); 
        ?>
        
</head>
<body>
	<div id="container">
		<section class="container container-common">
        		<?php echo $this->Session->flash(); ?>
        		<?php echo $this->fetch('content'); ?>
		</section
	</div>
	<?php //echo $this->element('sql_dump'); ?>
        <?php 
            echo $this->Html->script('bootstrap.min.js');
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
</body>
</html>
