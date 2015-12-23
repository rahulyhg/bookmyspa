<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	    <span class="sr-only">Toggle navigation</span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	</button>
	<select name="" class="custom-select">
	    <option value="eng"><?php echo __('EN');?></option>
	    <option value="ara"><?php echo __('AR');?></option>
	</select>
	<?php echo $this->Html->link($this->Html->image('frontend/logo.png'),array('controller'=>'homes','action'=>'index','admin'=>false),array('escape'=>false,'class'=>'navbar-brand')); ?>
    </div>
    <div class="en_box">
	<select name="" class="custom-select">
	    <option value="eng"><?php echo __('EN');?></option>
	    <option value="ara"><?php echo __('AR');?></option>
	</select>
	<p class="login_text">
	    <?php if(isset($auth_user)){ ?>
		<span class="wel-usr-name"><?php echo __('hi',true); ?>, <?php echo ucfirst($auth_user['User']['first_name']).' '.ucfirst($auth_user['User']['last_name']); ?>
		</span>/ 
		<?php if(isset($auth_user) && !empty($auth_user) && in_array($auth_user['User']['type'],array('2','3','4')) ){
		    echo '<span>';
		    echo $this->Html->link('<i class="fa fa-calendar"></i>',array('controller'=>'Appointments','action'=>'index','admin'=>true),array('escape'=>false,'title'=>__('calendar',true)));
		    echo '</span> / ';
		}
		echo '<span>';
		echo $this->Html->link('<i class="fa fa-user"></i>',array('controller'=>'users','action'=>'AccountManagement','admin'=>false),array('escape'=>false,'title'=>__('profile',true)));
		echo '</span> / ';
		echo '<span>';
		echo $this->Html->link('<i class="fa fa-clock-o"></i>',
		    '/Myaccount/appointments',
		    array('escape'=>false,'title'=>__('appointments',true)));
		echo '</span> / ';
		echo '<span>';
		echo $this->Html->link('<i class="fa fa-power-off"></i>','javascript:void(0)',array('escape'=>false,'title'=>__('log_out',true),'class'=>'logout'));
		echo '</span>';
	    } else{
		$loginUrl = $this->Html->url(array('controller'=>'users','action'=>'login','admin'=>false));
		$signUpUrl = $this->Html->url(array('controller'=>'users','action'=>'register','admin'=>false));
		echo $this->Html->link(__('login',true),'javascript:void(0)',array('class'=>'userLoginModal mainLogin','escape'=>false,'data-href'=>$loginUrl));
		echo " / ";
		echo $this->Html->link(__('sign_up',true),'javascript:void(0)',array('class'=>'userRegisterModal','escape'=>false,'data-href'=>$signUpUrl));
	    } ?>
	</p>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse col-sm-6 nav_box" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
	    <li <?php if(isset($menuActive) && in_array($menuActive,array('home'))){echo 'class="active"';}?>>
		<?php echo $this->Html->link(__('home',true),array('controller'=>'homes','action'=>'index','admin'=>false),array())?>
	    </li>
	    <li><?php echo $this->Html->link(__('deals',true),array('controller'=>'Deals','action'=>'index','admin'=>false),array('escape'=>false,'title'=>__('deals',true))); ?></li>
	    <li><?php echo $this->Html->link(__('spa_getaways',true),array('controller'=>'Spabreaks','action'=>'index','admin'=>false),array('escape'=>false,'title'=>__('spa_getaways',true))); ?></li>
	    <!--li><a href="#"><?php //echo __('last_min_deals',true); ?></a> </li-->
	    <li><?php echo $this->Html->link(__('stylists',true),array('controller'=>'Stylists','action'=>'index','admin'=>false),array()); ?></li>
	    <?php if(isset($auth_user) && !empty($auth_user) && in_array($auth_user['User']['type'],array('1','2','3','4')) ){
		if(!$auth_user['User']['is_phone_verified'] && $auth_user['User']['type'] != 1 ){ ?>
		    <li>
			<?php echo $this->Html->link(__('my_business',true),array('controller'=>'Business','action'=>'verify_sms','admin'=>false),array());  ?>
		    </li>
		<?php }else{ ?>
		    <li>
			<?php echo $this->Html->link(__('my_business',true),array('controller'=>'Dashboard','action'=>'index','admin'=>true),array()); ?>
		    </li>
		<?php } ?>
	    <?php }
	    else{ ?>
		<li  <?php if(isset($menuActive) && in_array($menuActive,array('business'))){echo 'class="active"';}?>>
		    <?php echo $this->Html->link(__('list_your_business',true),array('controller'=>'Business','action'=>'signup','admin'=>false),array())?>
		</li>
	    <?php }?>
	</ul>
    </div><!-- /.navbar-collapse -->
</div><!-- /.container -->