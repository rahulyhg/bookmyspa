<nav class="navbar navbar-default" role="navigation" id="header_navigation">
  <?php echo $this->element('header_navigation'); ?>
</nav>

<script type="text/javascript">
    function registrationValidate(){
	var regValidator = $("#userRegister,#UserForgetPasswordForm,#changePasswordId").kendoValidator({
	rules:{
	    minlength: function (input) {
		return minLegthValidation(input);
	    },
	    maxlength: function (input) {
		return maxLegthValidation(input);
	    },
	    pattern: function (input) {
		return patternValidation(input);
	    },maxlengthcustom: function (input) {
                    return maxLegthCustomValidation(input);
            },confirmpass: function (input) {
                    return confirmpassValidation(input);
            }
       },
	errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
	return regValidator;
    }
    
    function maxLegthValidation(input){
    if (input.is("[data-maxlength-msg]") && input.val() != "") {
        var maxChar = parseInt(input.attr('maxlength'));
        var inputLen = input.val().length;
        if(maxChar < inputLen){
            return false;
        }
    }
    return true;
}
    function confirmpassValidation(input){
        if (input.is("[data-confirmpass-msg]") && input.val() != "") {
            var pass = $('#UserPassword').val();
            var con_pass = input.val();
            if(pass != con_pass){
                return false;
            }
        }
        return true;
    }
    
    $(document).ready(function(){
	var regValid = null;
	var $sModal = $(document).find('#mySmallModal');
	$(document).on('click','.userLoginModal, .userRegisterModal',function(e){
	    e.preventDefault();
	    $sModal.load($(this).data('href'),function(){
		$sModal.modal('show');
		regValid = registrationValidate();
	    });
	});
	
	
	$sModal.on('click', '.submitLogin', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
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
                                    window.location.reload();
                                    return false;
                                }
                    }
                }
            }; 
            $('#UserLogin').unbind('submit').submit(function(){
                //if(regValid.validate()){
		  $(this).ajaxSubmit(options);
		//}
                e.preventDefault(); 
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
	
	//resend_phone
	
	$sModal.on('click','.resend_phone',function(){
	    var userId = $sModal.find('#UserId').val();
	    if(userId){
		 $.ajax({
			type:'post',
                        url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'sendPhoneCode','admin'=>false))?>",
			data:{'id':userId},
                        beforeSend: function () {
			    $(this).html('Sending OTP...');
                        },
                        success: function(res) {
                            $(this).html('Resend OTP ?');
                        },
                    });
	    }
	});
	
	
	$sModal.on('click','.checkPhoneCode',function(e){
	    var userId = $sModal.find('#UserId').val();
	    var userPhoneCode = $sModal.find('#UserPhoneCode').val();
	    var sendObj = $(this);
	    e.preventDefault();
	    if(userId){
		sendObj.text('<?php echo __('Sending...',true);?>');
		$.ajax({
			type:'post',
                        url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'varify_phone','admin'=>false))?>"+'/'+userId,
			data:{'id':userId,'phone_token':userPhoneCode},
                        beforeSend: function () {
			    $('.ajax_indicator').fadeIn('fast');
                        },
                        success: function(res) {
			    if(res=='s'){
				alert('<?php echo __('Phone verified successfully.',true); ?>');
				sendObj.text('<?php echo __('Verify',true);?>');
			    }
			    else{
				alert('<?php echo __('Invalid token',true); ?>');
				sendObj.text('<?php echo __('Verify',true);?>');
			    }
			    $('.ajax_indicator').fadeOut('fast');
                        }
                    });
	    }   
	});
	
	
	$sModal.on('click','.resendVEmail',function(e){
	    var userId = $sModal.find('.userId').val();
	    var sendObj = $(this);
	    e.preventDefault();
	    if(userId){
		sendObj.text('<?php echo __('Sending...',true);?>');
		$.ajax({
			type:'post',
                        url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'sendEmailCode','admin'=>false))?>"+'/'+userId,
			data:{'id':userId},
                        beforeSend: function () {
			    $('.ajax_indicator').fadeIn('fast');
                        },
                        success: function(res) {
			    if(res=='s'){
				sendObj.closest('li').html('<h5><?php echo __('Email sent successfully. Please Verify.',true); ?></h5>');  
			    }
                        }
                    });
	    }
	});
	
	
	$sModal.on('click', '.submitReg', function(e){
        var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    var data = jQuery.parseJSON(res);
		    if(data.data == 'regFacebook'){
			//$sModal.modal('hide');
			var loginURL = '<?php echo $this->Html->url(array('controller'=>'users','action'=>'login','admin'=>false));?>';
			$sModal.load(loginURL,function(){
			    $sModal.modal('show');
			    $sModal.find('.modal-body').prepend('<div class="alert alert-danger alert-dismissable"><div class="error help-block">'+data.message+'</div></div>');
			});
			
			return false;
		    }
		    
		    if(onResponse($sModal,'User',res)){
			var res = jQuery.parseJSON(res);
                        window.location = '/users/thanks/'+res.Id;
                    }
                }
            }; 
            $('#userRegister').unbind('submit').submit(function(e){
		//if(regValid.validate()){
		    $(this).ajaxSubmit(options);
		//}
		e.preventDefault(); 
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
	
	
	$(".custom-select").each(function(){
            $(this).wrap("<span class='select-wrapper pull-right'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(document).find(".custom-select").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
	    console.log($(this).val());
	    window.location = '/homes/index/language:'+$(this).val();
        });
	<?php
	$sessionLang = 'EN';
	$sLangVal = 'eng';
	if($this->Session->read('Config.language')){
	    if($this->Session->read('Config.language') == 'ara'){
		$sessionLang = 'AR';
		$sLangVal = 'ara';
	    }
	}?>
	$(document).find(".custom-select").next(".holder").text('<?php echo $sessionLang;?>');
	$(document).find(".custom-select option[value=<?php echo $sLangVal; ?>]").attr('selected','selected');
   
   
   /***************************** forget password ***********************************/
	$(document).on('click','.forgot',function(e){
	    e.preventDefault();
	    $sModal.modal('hide');
	    $sModal.load($(this).attr('href'),function(){
		$sModal.modal('show');
		regValid = registrationValidate();
	    });
	});
   
       $sModal.on('click', '.submitForgot', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($sModal,'User',res)){
                        window.location = '/';
                    }
                }
            }; 
            $('#UserForgetPasswordForm').submit(function(){
                if($('#UserForgetPasswordForm').validate()){
		    $(this).ajaxSubmit(options);
		}
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        $(document).on('click','.logout', function(e){
        var facebook_status = "<?php echo (isset($auth_user['User']['facebook_id']))?$auth_user['User']['facebook_id']:''; ?>";
         e.preventDefault(); 
            if(facebook_status){
                fbLogout();
            }else{
                window.location.href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'logout','admin'=>FALSE)); ?>";
            }
       }); 
        
 });
  
  function redirect_giftcertificate(){
    
  }
  
  function show_ajax(){
    $('#ajax_modal').show();
    $('#ajax_fade').show();     
}

function hide_ajax(){
    $('#ajax_modal').hide();
    $('#ajax_fade').hide();                      
}      
  
   var fbmm = {};
              window.fbAsyncInit = function() {
                FB.init({
                  appId : '<?php echo Configure::read('ExtAuth.Provider.Facebook.key'); ?>', // App ID
                  cookie: true, 
                  xfbml: true,
                  status: true,
                  oauth: true
                });
 
              $(document).on('click',"#facebook", function(){
                        var connected =false;
			FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
			   getUserInfo();
			} else {
			    FB.login(function(response) {
				if (response.authResponse) {
                                    getUserInfo();
				} else {
				}
			 },{scope: 'public_profile,email'});
			}
		       });
			
                    });
               };

          //(function(d){
          //   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
          //   if (d.getElementById(id)) {return;}
          //   js = d.createElement('script'); js.id = id; js.async = true;
          //   js.src = "//connect.facebook.net/en_US/all.js";
          //   ref.parentNode.insertBefore(js, ref);
          // }(document));
	  
	  
	  $(document).ready(function(){
	    var obj =  $(this);
	       obj.find('.login-text-field').focus(function(){
	       obj.find('.alert-dismissable').hide();
	    })
	  });

    function getUserInfo() {
        FB.api('/me', function(response) {
                     $.ajax({url: '<?php echo $this->Html->url(array("controller"=>"users","action"=>"facebook_login"))?>', 
                     data:{User:response},
                     type:'POST',
                     success: function(result){
                     if(result=='exist'){
                          FB.logout(function(response) {
                            message = "<?php echo __('This email is already registered with us. Please login with your sieasta account.'); ?>";  
                            $(document).find('.modal-body').prepend('<div class="alert alert-danger alert-dismissable"><div class="error help-block">'+message+'</div></div>');  
                        }); 
                     }else{
                        if(gift_check()){   
                            return false;
                        }else{    
		            window.location.reload();
		            return false;
                        }
                    }
            }}
        );
        });
   }
  
  function fbLogout(){
         FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                console.log('res');
		FB.logout(function(response) {
                 console.log('logout funct');
		 window.location.href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'logout','admin'=>FALSE)); ?>";
                });
                window.location.href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'logout','admin'=>FALSE)); ?>";
            }else{
             window.location.href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'logout','admin'=>FALSE)); ?>";
            }
        });
  }
  
  function gift_check(){
        var param = "<?php echo $this->params['controller']; ?>";
        if(param=="GiftCertificates"){
	      load_url = "<?php echo $this->Html->url(array('controller'=>'homes','action'=>'navigation','admin'=>FALSE)); ?>";  
	      $("#header_navigation").load(load_url, function(res){
		$(document).find('.siestaGCbutton').click();
		return true;
	      }); 
	      return true;
        }else if(param=="Place"){
	      load_url = "<?php echo $this->Html->url(array('controller'=>'homes','action'=>'navigation','admin'=>FALSE)); ?>";  
	        $("#header_navigation").load(load_url, function(res){
		theAppType =$('.bukingService a.action').data('type');
		if(theAppType){
		$(document).find('#selBukTyp').val(theAppType);
		$(document).find('#AppointmentShowServiceForm').submit();
		}else{
		  window.location.reload();
		}
		return true;
	      }); 
	      return true;   
	     
        }else{
	       return false;  
	}
  }
  
</script>
<div id="fb-root"></div>
<!--
<div id="header">
    <div class="lang-wrap">
	<ul>
	<li><?php //echo $this->Html->link('English(US)', array('language'=>'eng'),array('escape'=>false));?></li>
	<li><?php //echo $this->Html->link('Arabic(ar)', array('language'=>'ara'),array('escape'=>false));?></li>
	</ul>
    </div>
</div>-->
		