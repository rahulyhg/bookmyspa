<nav class="navbar navbar-default" role="navigation" id="header_navigation">
  <?php echo $this->element('lock_header_navigation'); ?>
  <div class ="main_login" style='display: none'></div>
</nav>

<script type="text/javascript">
    $(document).ready(function(){
       
      /***********************Login from top login  **************/
	$('.login_text').click(function(e){
	    var msgm = (e.isTrigger)?'triggered':'clicked';
	    if(msgm=='clicked'){
	       $(document).find('.main_login').text('main_login');
	    }else if(msgm=='triggered'){
	       $(document).find('.main_login').text('payment');
	      } 
	});
      
	var regValid = null;
	var $sModal = $(document).find('#mySmallModal');
	$(document).on('click','.userLoginModal, .userRegisterModal',function(e){
	    e.preventDefault();
	    $sModal.load($(this).data('href'),function(){
		$sModal.modal('show');
		//regValid = registrationValidate();
	    });
	});
	
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
				$sModal.modal('hide');
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
	var $fModal = $(document).find('#myModal');
	$(document).on('click','.forgot',function(e){
	   // alert('click');
	    e.preventDefault();
	    $sModal.modal('hide');
	    $fModal.load($(this).attr('href'),function(){
	      
	   // alert('click2');
		$fModal.modal('show');
		//regValid = registrationValidate();
	    });
	});
   
       /*$fModal.on('click', '.submitForgot', function(e){
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
        });*/
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

          (function(d){
             var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement('script'); js.id = id; js.async = true;
             js.src = "//connect.facebook.net/en_US/all.js";
             ref.parentNode.insertBefore(js, ref);
           }(document));
	  
	  
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
		            window.location.href ='<?php echo $this->Html->url(array("controller"=>"Myaccount","action"=>"appointments")); ?>';
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
         var salonGift = $(document).find('.salon_gift').text();
	 redirectTo = $(document).find('a.action').data('login_val');
	 triger_from = $(document).find('.main_login').text();
	  if(triger_from=='main_login'){
	   return false; 
	  }
	  if(param=="GiftCertificates" || salonGift=="salon_gift"){
	      load_url = "<?php echo $this->Html->url(array('controller'=>'homes','action'=>'navigation','admin'=>FALSE)); ?>";  
	      $("#header_navigation").load(load_url, function(res){
		$(document).find('.siestaGCbutton').click();
		return true;
	      }); 
	      return true;
	 }else if(param=="Place" || param=="Bookings" ||param=="packagebooking"){
	       load_url = "<?php echo $this->Html->url(array('controller'=>'homes','action'=>'navigation','admin'=>FALSE)); ?>";  
	        $("#header_navigation").load(load_url, function(res){
		  theAppType =$(document).find('.dataType_val').text();
		  console.log(theAppType);
		  redirectTo = $(document).find('a.action').data('login_val');
		  //console.log(redirectTo);
		  if(redirectTo=='service'){
		      $(document).find('#selBukTyp').val(theAppType);
		      $(document).find('#AppointmentShowServiceForm').submit();
		  }else if(redirectTo=='package'){
		      //console.log(redirectTo);
		      $(document).find('#AppointmentShowPackageForm').submit();
		  }else if(redirectTo=='spabreak'){
		      $(document).find('#AppointmentShowSpaBreakForm').submit();	
		  }else{
		      window.location.href ='<?php echo $this->Html->url(array("controller"=>"Myaccount","action"=>"appointments")); ?>';
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
		