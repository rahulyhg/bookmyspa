<script>
$(document).ready(function(){
	$('.formSubmit').click(function(e){ 
        e.preventDefault();
		$.ajax({
            type: "POST",
            url: "/contents/ajaxlogin/",
            data: $("#userloginformid").serialize(),
            success: function(data) { 
			   if (data == 1){
					parent.window.location.href = parent.window.location.href;
                }else{
					$('.radioLogin').html(data);
				}
			}
        });
	
	});
	$('.facbook-btn-pop').click(function(e){
		var url = $(this).attr('href');
		parent.window.location.href = url;
	});
	$('.twitter-btn-pop').click(function(e){
		var url = $(this).attr('href');
		parent.window.location.href = url;});
	$('.forgot-pwd-pop').click(function(e){
		var url = $(this).attr('href');
		parent.window.location.href = url;});
});

</script>

   <?php  echo $this->Html->script('user/login'); ?>
    <div class="panel-body login-min-height">
    <div class="loginform loginform2">
    <div class="radioLogin">
    </div>
    <div class="formclass">
        <?php echo $this->Session->flash();  
      echo $this->Form->create('User', array('id'=>'userloginformid'));
    ?>
            <fieldset>
                <h6 class=login-heading>Signin!</h6>
                <div class="form-group form_margin">                                        
                    <?php echo $this->Form->input('email',array('label' => false,'div' => false, 'placeholder' => 'E-mail','class' => 'uname form-control','maxlength' => 55));?>
                </div>
                <div class="form-group form_margin">                    
                    <?php echo $this->Form->input('password',array('label' => false,'div' => false, 'placeholder' => 'Password','class' => 'password form-control','maxlength' => 30,'type '=> 'password'));?>
                </div>
                 <?php //$this->Captcha->render2($captchaSettings); ?>
                 <div class="checkbox checkbox-rw">
		    <ul>
			
			<li>  <?php echo $this->Html->link('<span>Forgot password</span>','/users/forgot_password',array('escape'=>false,'class'=>'forgot-pwd-pop','title' => 'Forgot password'));?></li>
		    </ul>
                </div>
                <?php echo $this->Form->submit('Login',array('div'=>array('class'=>'login-submit-rw'),'class' => 'btn btn-default formSubmit'));?>                
            </fieldset>
            <?php echo $this->Form->end(); ?>
            <div class="social-btns">
            <ul>
				<li><?php echo $this->Html->link(('Facebook'), array('action'=>'social_login' , 'controller'=>'users'),
									 array('escape' => false, 'class' => 'gray-btn facbook-btn facbook-btn-pop'));?></li>
				<li> <?php echo $this->Html->link(('Twitter'), array('action'=>'twitter_login' , 'controller'=>'users'),
									 array('escape' => false, 'class'=> 'blue-link twitter-btn twitter-btn-pop'));?></li>
			    <li style="margin-left:170px;"><?php echo $this->Html->link('Register', array('controller'=>'users','action'=>'register'),array('escape' => false));?></li>
			</ul>
			</div>
           <!-- <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button><div id="status"></div>
            span id="fbLogout" onclick="LogoutFacebook()"><a class="fb_button fb_button_medium"><span class="fb_button_text">Logout</span></a></span>
                
            Add a button for the user to click to initiate auth sequence 
            <button id="authorize-button" style="visibility: hidden">Google+</button>
            <!--a id="gPLogout" onclick="LogoutGoogle()">Logout</a-->
    
    </div>
    </div>
    </div>
    