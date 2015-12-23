<?php echo $this->Html->script('admin/jquery.form');?>
<style>
   .username,.password{ color: #A94442;font-size: 14px !important;font-style: italic !important;}
   .User_mar_2{margin-top: 2px;}
   .User_mar_5{margin-top: 5px;}
</style>
<div class="modal-dialog login">
<div class="modal-content">
    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo __('Login', true); ?></h4>
    </div>
    <div class="modal-body clearfix">
      <ul class="login-form">
        <?php echo $this->Form->create('User', array('novalidate','url' => array('controller' => 'users', 'action' => 'login'),'id'=>'UserLogin')); ?>
	  <li>
	      <label><?php echo __('email_username',true); ?>*</label>
	      <?php echo $this->Form->input('User.username',array('error'=>false,'type'=>'text','label'=>false,'div'=>false,'class'=>'login-text-field','validationMessage'=>__("Username_Email_is_Required",true),));?>
	  <p class="username"></p>
	  </li>
          <li>
	      <label><?php echo __('Password',true); ?>*</label>
	      <?php echo $this->Form->input('User.password',array('type'=>'password','label'=>false,'div'=>false,'class'=>'login-text-field','minlength'=>'8','maxlength'=>'55','required','validationMessage'=>__("Password_is_Required",true),'data-minlength-msg'=>__("Minimum_8_characters",true),'data-maxlength-msg'=>__("Maximum_55_characters.",true)));?>
	     <p class="password"></p>
	  </li>
	  <li class="clearfix">
		<section class="pull-left pos-rgt pos-rel">
		  <?php echo $this->Form->input('rememberme',array('type'=>'checkbox','div'=>false,'label'=>array('text'=>__('Remember_me'),'class'=>'new-chk'))); ?>
	        </section>
                <section class="pull-right pos-lft User_mar_2">
                    <?php echo $this->Html->link(__('Forgot_Password',true),array('controller'=>'users','action'=>'forgetPassword'),array('class'=>'frgtPwdModal forgot','escape'=>false)); ?>
                </section>
	  </li>
	  <li>
	     <?php echo $this->Form->submit(__('Login'),array('class'=>'action-button submitLogin','div'=>false,'label'=>false));  ?>
	  </li>
        <?php echo $this->Form->end(); ?>
       </ul> 
       <ul class="login-form social">
            	<li class="errorMsg">
                    <?php echo $this->Html->link(__('Login_with_facebook'),'javascript:void(0);',array('id'=>'facebook','class'=>'fb-btn')); ?> 
                    <em class="MoreInfoSieasta"><?php echo __('Recommended_and_we'); ?> </em>
                </li>
                <li>
<!--                    <div id="gSignInWrapper">
                        <span class="label">Sign in with:</span>
                        <div id="customBtn" class="customGPlusSignIn">
                          <span class="icon"></span>
                          <span class="buttonText">Google</span>
                        </div>
                      </div>-->

                    
                    
                    <!--<div class="g-signin2" data-longtitle="true" data-onsuccess="Google_signIn" data-theme="dark" data-width="300"></div>-->
                    <?php echo $this->Html->link(__('Login_with_google') ,'javascript:void(0)' , array('id'=>'googleLogin','class'=>'google-btn')); ?>
                    <?php //echo $this->Html->link(__('Login_with_google') ,'javascript:void(0)' , array('onclick'=>'googleLogin();','class'=>'google-btn')); ?>
                </li>
		<div class="check_booK">
		  <li class="or User_mar_5">or</li>
		  <li class="clearfix">
		      <button data-href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'register','1')); ?>" type="button" class="action-button black_btn userRegisterModal"><?php echo __('sign_up'); ?></button>
		  </li>
		</div>
       </ul>
       
    </div>
    </div>
  </div>
  <?php //echo $this->Html->script(array('https://apis.google.com/js/client:platform.js'));?>

  <script>
    $(document).ready(function(){
	
        //callRequiredForm();
	this_action = $(document).find('.con_action').text();
	if($.trim(this_action)=="salonservices" || $.trim(this_action)=="showPackage"){
	  $(document).find('.check_booK').hide();
	  $(document).find('.social').addClass('log-top');
	}
    });
</script>
<div id="fb-root"></div>
<!--<script src="/js/kendo/kendo.all.min.js"></script>-->

<?php echo $this->Html->script('admin/modal_common'); ?>
<script type="text/javascript">
$(document).ready(function(){
    var $sModal = $(document).find('#mySmallModal');
    // alert($sModal);
    function checkUsername(){
	    if($("#UserUsername").val()==''){
		$("#UserUsername").css({"border":"1px solid #A94442"});
		$(".username").text("E-mail / Username is required.");
		return false;
	    }else{
		$("#UserUsername").css({"border":"1px solid #CBCBCB"});
		$(".username").text("");
	    }
    }
    function checkPassword(){
	if($("#UserPassword").val()==''){
		$("#UserPassword").css({"border":"1px solid #A94442"});
		$(".password").text("Password is required.");
		return false;
	}else{
	    $("#UserPassword").css({"border":"1px solid #CBCBCB"});
	    $(".password").text("");
	}
    }
    
    function validateLogin(){
	var flag=true;
	if($("#UserUsername").val()==''){
		$("#UserUsername").css({"border":"1px solid #A94442"});
		$(".username").text("E-mail / Username is required.");
		flag= false;
	} else{
	    $("#UserUsername").css({"border":"1px solid #CBCBCB"});
	    $(".username").text("");
	}
	
	if($("#UserPassword").val()==''){
		$("#UserPassword").css({"border":"1px solid #A94442"});
		$(".password").text("Password is required.");
		flag= false;
	} else{
	    $("#UserPassword").css({"border":"1px solid #CBCBCB"});
	    $(".password").text("");
	}
	return flag;
    }
    
    
    $('#UserUsername').blur(function(){
	checkUsername();
    });
    
    $('#UserPassword').blur(function(){
	checkPassword();
    });
    
    $('#UserLogin').submit(function(){
	var ret_flg = validateLogin();
	if (ret_flg === true) {
		var options = { 
		    success:function(res){
			var data = jQuery.parseJSON(res);
			if(data.data == 'verify_email'){
			    $sModal.modal('hide');
			    var verifyEmail = '<?php echo $this->Html->url(array('controller'=>'users','action'=>'verfiyemail','admin'=>false));?>'+'/'+data.id;
			    $sModal.load(verifyEmail,function(){
				$sModal.modal('show');
			    });
			    return false;
			}
			if(data.data == 'varify_phone'){
			    $sModal.modal('hide');
			    var verifyPhone = '<?php echo $this->Html->url(array('controller'=>'users','action'=>'varify_phone','admin'=>false));?>'+'/'+data.id;
			    $sModal.load(verifyPhone,function(){
				$sModal.modal('show');
			    });
			    return false;
			}
			<?php if(strtolower($this->params['action']) == 'appointment' && strtolower($this->params['controller']) == 'bookings'){ ?>
			    window.location = '<?php echo $this->Html->url(array('controller'=>'Bookings','action'=>'appointment','admin'=>false));?>';
			    return false;
			<?php } ?>
			if(data.data == 'verify_phone'){
			    window.location = '<?php echo $this->Html->url(array('controller'=>'Business','action'=>'verify_sms','admin'=>false));?>';
			    return false;
			}
			if(data.data == 'admin'){
			    if(gift_check()){   
				    return false;
			    }else{    
				window.location = '<?php echo $this->Html->url(array('controller'=>'Dashboard','action'=>'index','admin'=>true));?>';
				return false;
			    }
			}
			if(onResponse($sModal,'User',res)){
                            if(gift_check()){   
                                return false;
                            }else{    
                               	window.location.href ='<?php echo $this->Html->url(array("controller"=>"Myaccount","action"=>"appointments")); ?>';
                                return false;
                            }
			}
		    }
		};
		$(this).ajaxSubmit(options);
		return false;
	} else {
	    return false;
	}
    });
   
   startApp(); //function use to attach google click event.
   
});

</script>
