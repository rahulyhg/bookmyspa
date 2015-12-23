<?php //($this->Session->read('Auth')); ?>
<nav class="navbar admin-outer navbar-default mrgn-btm-non" role="navigation">
	<div class="navbar-outer" >
		<div class="navbar-header welcome-drop">
			<?php if(isset($leftMenu) || (isset($this->params) && !empty($this->params) && strtolower($this->params['controller']) == 'appointments' )){ ?>
			<a href="javascript:void(0);" class="mobile-sidebar-toggle"><i class="icon-th-list"></i></a>
			<?php } ?>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
			<?php echo $this->Html->link('<img src="/img/logo.png" alt=""/>',array('controller'=>'homes','action'=>'index','admin'=>false),array('class'=>'navbar-brand','escape'=>false)); ?>
			
		</div>
		
		<div class="en_box ">
			<ul class="head-rgt-details">
				<li class="dropdown welcome-drop" >
					
				<?php  if(isset($auth_user['Salon']['eng_name']) && !empty($auth_user['Salon']['eng_name'])){ 
					if (strlen($auth_user['Salon']['eng_name']) > 12){
					    $salon_name = substr($auth_user['Salon']['eng_name'], 0, 12) . '...';
					} else{
					    $salon_name=$auth_user['Salon']['eng_name'];
					}
					echo ucfirst($salon_name).' ,';
				} ?>
				<a href="javascript:void(0);" class='dropdown-toggle' data-toggle="dropdown">
				<?php  if(isset($auth_user['User']['first_name']) && !empty($auth_user['User']['first_name'])){ echo ucfirst($auth_user['User']['first_name']); }else{ echo $auth_user['User']['username']; } ?>
				<i class="fa  fa-caret-down"></i>
				</a>
					<ul class="dropdown-menu pull-right">
						<li><?php echo $this->Html->link('Edit Profile',array('controller'=>'users','action'=>'editProfile','admin'=>true)); ?></li>
						<li><?php echo $this->Html->link('Change Password',array('controller'=>'users','action'=>'changePassword','admin'=>true)); ?></li>
						<li><?php echo $this->Html->link('Sign out',array('controller'=>'users','action'=>'logout','admin'=>false));?></li>
						
					</ul>
				</li>
				<li> | </li>
				<li class="dropdown welcome-drop notification" >
                                    <?php echo $this->element('admin/notification'); ?>
				</li>
			</ul>
			<?php $from_user = $this->Session->read('Auth.from_user');
			$from_fo_id = $this->Session->read('Auth.from_fo_id');
			if(!empty($from_fo_id)){ ?>
				<div class="welcome-drop" style="text-align:center">
					<?php echo $this->Html->link('<b>Back to Owner</b>',array('controller'=>'Dashboard','action'=>'force_login','admin'=>true),array('escape'=>false,'class'=>'white')); ?>
				</div>
			<?php } else if(!empty($from_user )) { ?>
				<div class="welcome-drop" style="text-align:center">
					<?php echo $this->Html->link('<b>Back to Super Admin</b>',array('controller'=>'Dashboard','action'=>'force_login','admin'=>true),array('escape'=>false,'class'=>'white')); ?>
				</div>
			<?php } else {
				
			} ?>
		</div>
		<div class="en_box_clear"></div>
		<div class="user color-settings">
			<ul class="nav navbar-nav admin">
				<li class='dropdown colo'>
					<a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-tint"></i></a>
					<ul class="dropdown-menu pull-right theme-colors">
						<li class="subtitle">
							Predefined colors
						</li>
						<li>
							<span class='red'></span>
							<span class='orange'></span>
							<span class='green'></span>
							<span class="brown"></span>
							<span class="blue"></span>
							<span class='lime'></span>
							<span class="teal"></span>
							<span class="purple"></span>
							<span class="pink"></span>
							<span class="magenta"></span>
							<span class="grey"></span>
							<span class="darkblue"></span>
							<span class="lightred"></span>
							<span class="lightgrey"></span>
							<span class="satblue"></span>
							<span class="satgreen"></span>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		
		<?php echo $this->element('admin/top_menu'); ?>
	</div>
</nav>
<script>
$(document).ready(function(){
    $(".theme-colors > li > span").hover(function(e){
        var $el = $(this),
        body = $('body');
        body.attr("class","").addClass("theme-"+$el.attr("class"));
     }, function(){
        var $el = $(this),
        body = $('body');
        if(body.attr("data-theme") !== undefined) {
           body.attr("class","").addClass(body.attr("data-theme"));
        } else {
           body.attr("class","");
        }
     }).click(function(){
        var $el = $(this);
        $("body").addClass("theme-"+$el.attr("class")).attr("data-theme","theme-"+$el.attr("class"));
        $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'siteTheme','admin'=>true));?>",
            type:'POST',
            data:{'theme': $el.attr("class") }
            });
    });
});
</script>