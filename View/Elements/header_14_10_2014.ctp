<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
<?php 
echo $this->Html->css('tagit/jquery.tagsinput.css'); 
echo $this->Html->script('ckeditor/ckeditor'); 
 ?> 
<header class="header navbar" role="navigation">
<?php  echo $this->Html->script('home/jquery.form'); 
        echo $this->Html->script('jquery.validate');?>
	<script>
        $('document').ready(function(){            
        $(function(){
        $('#add_open').click(function(){
        $( "#togle" ).toggle();
    });
});


	$(function() {
	$('#tags_1').tagsInput({width:'auto',
        height:'auto' ,
        'interactive':true,
        autocomplete_url:'/homes/tags_json',
        autocomplete:{selectFirst:true,width:'100px',autoFill:true},
       });
        
        
  });});
</script>	
<section class="container">
		<div class="navbar-header">
		<button data-target=".bs-navbar-collapse" data-toggle="collapse" type="button" class="navbar-toggle" data-original-title="" title="">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<?php
		  echo $this->Html->link(
				$this->Html->image('home/logo.png', array('class' => 'img-responsive', 'alt' => 'FooTab',
				'width' => '196', 'height' => '132')),
			    '/', // or an array('controller' => 'mycontroller', 'action' => 'myaction')
			     array('escape' => false, 'class'=>'navbar-brand logo'));?>
		</div>
		<!--Nav Start-->
		<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
		<ul class="nav navbar-nav">
		    <li class="active">
			<?php echo $this->Html->link(('<i class="fa fa-lightbulb-o"></i> Highlights'),array('controller'=>'Contents','action'=>'tag_contents','Highlights'),array('escape' => false));?></li>
		    <li><?php echo $this->Html->link(('<i class="fa fa-bullhorn"></i> Transfer news'),array('controller'=>'Contents','action'=>'tag_contents','Transfer news'),array('escape' => false));?></li>
		    <li><?php echo $this->Html->link(('<i class="fa fa-smile-o"></i> Memes'),array('controller'=>'Contents','action'=>'tag_contents','Memes'),array('escape' => false));?></li>
		    <li><?php echo $this->Html->link(('<i class="fa fa-video-camera"></i> Videos'),array('controller'=>'Contents','action'=>'tag_contents','Videos'),array('escape' => false));?></li>
		    <li><?php echo $this->Html->link(('<i class="fa fa-question-circle"></i> Quizzes'),array('controller'=>'Contents','action'=>'tag_contents','Quizzes'),array('escape' => false));?></li> 
			<li><?php echo $this->Html->link(('<i class="fa fa-question-circle"></i> Team'),array('controller'=>'Contents','action'=>'tag_contents','Team'),array('escape' => false));?></li>   
		</ul>
		<!-- Right navigation start -->
		<ul class="nav navbar-nav navbar-right">
                    <?php $check = $this->Session->read('UserInfo');
                    if($check && isset($check) ){ ?>
                   
                    <li class="dropdown mega-dropdown"><a href="javascript:;" id="add_open" class="gray-btn"><i class="fa fa-plus-circle"></i>Create Post <i class="fa fa-caret-down"></i></a>
                    	<!--Dropdown-->
                   <?php echo $this->element('content_modal');?>
                    </li>
                    
                    <li class="dropdown"><a href="javascript:;" data-toggle="dropdown" class="blue-link"><i class="fa fa-user"></i> <?php echo $this->Session->read('UserInfo.first_name').' '.$this->Session->read('UserInfo.last_name'); ?> <i class="fa fa-caret-down"></i></a>
                    	<ul class="dropdown-menu">
                            <li>
                                 <?php echo $this->Html->link(('<i class="fa fa-fw fa-user"></i> Profile'), array('action'=>'profile' , 'controller'=>'users'),
				array('escape' => false, 'class'=> ''));?>
                                
                            </li>
                            <li>
                            <?php echo $this->Html->link(('<i class="fa fa-fw fa-envelope"></i> Inbox'), array('action'=>'#' , 'controller'=>'users'),
				array('escape' => false, 'class'=> ''));?>
                                
                            </li>
                            <li>
                                 <?php echo $this->Html->link(('<i class="fa fa-fw fa-gear"></i> Settings'), array('action'=>'edit_profile' , 'controller'=>'users'),
				array('escape' => false, 'class'=> ''));?>
                                
                                
                            </li>
                            <li class="divider"></li>
                            <li>
                                <?php echo $this->Html->link(('<i class="fa fa-fw fa-power-off"></i> Log Out'), array('action'=>'logout' , 'controller'=>'users'),
				array('escape' => false, 'class'=> ''));?>
                            </li>
                        </ul>
                    </li>
                 
                    <?php }else{ ?>
		    <li><?php echo $this->Html->link(('Login'), array('action'=>'login' , 'controller'=>'users'),array('escape' => false, 'class' => 'gray-btn'));?></li>
				           
		    <li class="dropdown mega-dropdown-menu"><a href="javascript:;" data-toggle="dropdown" class="blue-link"><i class="fa fa-plus-circle"></i>Create Account</a>
                     <section class="dropdown-menu mega-dropdown-menu signup-widget" role="menu" aria-labelledby="dLabel">
                        	<h2>Sign up with:</h2>
                                <ul class="signup liststyle-none">
                                <li><?php echo $this->Html->link(('<i class="fa social-icon fa-facebook"></i> Facebook Account'), array('action'=>'social_login' , 'controller'=>'users'),
				array('escape' => false, 'class'=> ''));?></li>
                                <li><?php echo $this->Html->link(('<i class="fa social-icon fa social-icon fa-twitter"></i> Twitter Account'), array('action'=>'twitter_login' , 'controller'=>'users'),
				array('escape' => false, 'class'=> ''));?></li>
                                <a href="../../home/sanjeevk/Desktop/buzzfeed/HTML/20140827/index-user.html"></a>
                                <li><?php echo $this->Html->link(('<i class="fa social-icon fa-google-plus"></i> Google plus Account'), array('action'=>'register' , 'controller'=>'users'),
				array('escape' => false, 'class'=> ''));?></li>
                                <li><?php echo $this->Html->link(('<i class="fa social-icon fa-envelope"></i> Footybase Account'), array('action'=>'register' , 'controller'=>'users'),
				array('escape' => false, 'class'=> ''));?></li>
                            </ul>
                        </section>
                    </li>
                    
                    <?php } ?>
		  </ul>
		  <!-- Right navigation end -->
		</nav>
		<!--Nav Closed-->
</section>
</header>
                            <?php //echo $this->element('photo_modal');?>
                            <?php //echo $this->element('video_modal');?>
                            <?php //echo $this->element('meme_modal');?>
<div id="defaultModal"  data-backdrop="static"  class="modal fade"><?php echo $this->element('default_modal');?> </div>
<div id="quizModal" class="modal fade">  <?php //echo $this->element('quiz_modal');?> </div>
                            <?php //echo $this->element('poll_modal');?>
                            <?php //echo $this->element('lineup_modal');?>                            
                        
