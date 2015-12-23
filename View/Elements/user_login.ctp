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
   
   <div class="modal fade" id="myloginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
		<button data-dismiss="modal" class="close close-btn" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                        </button>
        <h4 class="modal-title" id="myModalLabel">Sign In</h4>
      </div>
      
    <div class="panel-body">
    <div class="loginform loginform2">
    <div class="radioLogin">
    </div>
    <div class="formclass">
        <?php echo $this->Session->flash();  
      echo $this->Form->create('User', array('id'=>'userloginformid'));
    ?>
            <fieldset>
                <!--h6 class=login-heading>Signin!</h6-->
				 <div class="social-btns">
            <ul>
				<li>
					
				<?php echo $this->Html->link(('<i class="fa fa-facebook-square"></i>Facebook'), array('action'=>'social_login' , 'controller'=>'users'),
									 array('escape' => false, 'class' => 'gray-btn facbook-btn facbook-btn-pop'));?></li>
				<li> <?php echo $this->Html->link(('<i class="fa fa-twitter-square"></i>Twitter'), array('action'=>'twitter_login' , 'controller'=>'users'),
									 array('escape' => false, 'class'=> 'blue-link twitter-btn twitter-btn-pop'));?></li>
			  
			</ul>
			</div>
				 <div class="upper_login">                                        
                    or Login with Footybase Account
                </div>
                <div class="form-group form_margin">                                        
                    <?php echo $this->Form->input('email',array('label' => false,'div' => false, 'placeholder' => 'E-mail','class' => 'uname form-control','maxlength' => 55));?>
                </div>
                <div class="form-group form_margin">                    
                    <?php echo $this->Form->input('password',array('label' => false,'div' => false, 'placeholder' => 'Password','class' => 'password form-control','maxlength' => 30,'type '=> 'password'));?>
                </div>
                 <?php //$this->Captcha->render2($captchaSettings); ?>
                 <div class="checkbox checkbox-rw">
		    <ul>
			
			<li>  
                        <a class="userActionModal" data-function="forgot_password" data-title="Forgot password" href="javascript:void(0)">Forgot password?</a>   
                        <?php //echo $this->Html->link('<span>Forgot password</span>','/users/forgot_password',array('escape'=>false,'class'=>'forgot-pwd-pop','title' => 'Forgot password'));?>
                        </li>
						<li> 
						<a type="button" data-function="register" data-title="User Registration" class="register_btn userActionModal" href="javascript:void(0)">Register</a>   
						</li>
						<li class="add_login_btn">
						
						
		<?php //echo $this->Html->link('Register', array('controller'=>'users','action'=>'register'),array('escape' => false,'class'=>"btn btn-default ch-login",'type'=>"button"));?>
        <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
		<?php echo $this->Form->submit('Login',array('class'=>'btn btn-default formSubmit ch-login btn btn-primary','type'=>"button"));?> 
        <!--button type="button" class="btn btn-primary">Save changes</button-->
						
						</li>
						
						
		    </ul>
                </div>
                               
            </fieldset>
           
            
    </div>
    </div>
    </div>
    <!--div class="modal-footer">
     
      </div-->
	   <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>