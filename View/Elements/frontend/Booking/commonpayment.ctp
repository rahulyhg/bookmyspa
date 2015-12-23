<?php if(!isset($auth_user)){ ?>
    <script>
        $(document).ready(function(){
            $(document).on('click','.AppointmentCheckout',function(e){
                $(document).find('.userLoginModal').click();
                e.preventDefault();
            });
        });
    </script>
<?php }else{ ?>
  <script>
        $(document).ready(function(){
//         var $modal = $('#commonSmallModal');
//		    itsId = '<?php echo base64_encode($auth_user["User"]["id"]); ?>';
//		    var addeditURL = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'varify_phone','admin'=>false)); ?>";
//		   addeditURL = addeditURL+'/'+itsId		 
//		   console.log(addeditURL);
//		   fetchModal($modal,addeditURL);
	//checkphone();
     $(document).on('click','.AppointmentCheckout',function(e){
	checkphone();
       });   
    });
	
    function checkphone(){
        var $modal = $('#commonSmallModal');
	var form_phone = $("#AppointmentBillingTel").val();
	var userPhone = '<?php echo $auth_user["Contact"]["cell_phone"]; ?>';
	var user_id = '<?php echo $auth_user["User"]["id"]; ?>';
	var is_verified = '<?php echo $auth_user["User"]["is_phone_verified"]; ?>';   
	    if((form_phone == userPhone) && is_verified=='1'){
		$("#AppointmentAppointmentForm").submit();
	    }else if((form_phone == userPhone) && is_verified !=1 && form_phone){
		itsId = '<?php echo base64_encode($auth_user["User"]["id"]); ?>';
			addeditURL = addeditURL+'/'+itsId;	
			var addeditURL = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'varify_phone','admin'=>false)); ?>";		 
		       fetchModal($modal,addeditURL);
	    }else{
	    $.ajax({
		    type: "POST",
		    url: "<?php echo $this->Html->url(array('controller'=>'Bookings','action'=>'check_phone','admin'=>false));?>",
		    data: { phone: form_phone , id:user_id}
		})
		.done(function(msg) {
		  if(msg=='blank'){
		    $("#AppointmentAppointmentForm").submit();
		   }else if($.trim(msg) == 'verification_sent'){
			itsId = '<?php echo base64_encode($auth_user["User"]["id"]); ?>';
			addeditURL = addeditURL+'/'+itsId;	
			var addeditURL = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'varify_phone','admin'=>false)); ?>";		 
		       fetchModal($modal,addeditURL);
		      
		  }else{
		    console.log('hererer');
		  }
	    });
	}    
    }	
    </script>
<?php } ?>
 <script>
    $(document).ready(function(e){
	 var prodValidator = $("#AppointmentAppointmentForm").kendoValidator({
        rules:{
            minlength: function (input) {
                return minLegthValidation(input);
            },
            maxlength: function (input) {
                return maxLegthValidation(input);
            },
            pattern: function (input) {
                return patternValidation(input);
            }
        },
        errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
	 $('.number').keyup(function(e){
	   var value = $(this).val();
	   if(isNaN(value)){
	       $(this).val('');
	   }
	  });
	 
	 $(document).on('click','.checkPhoneCode', function(e){
                e.preventDefault();
                 phone_code = $('#UserPhoneCode').val();
		 id = $(document).find('.resend_phone').data('id');
                 if(!phone_code){
                     alert('Kindly enter the phone OTP !!!');
                     return;
                 }
                 $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'varify_phone'))?>/"+id,
                        type: "POST",
                        data: {phone_token:phone_code ,id:id},
                        success: function(res) {
                            if ($.trim(res) =='s') {
                            alert('Your mobile no. is verified!!');
                            $("#AppointmentAppointmentForm").submit();
                            } else {
                                alert('OTP not match!!!');
                            }
                        }
                });
        });
	
	$(document).on('click','.resend_phone',function(){
        userId = $(this).data('id');             
        $url = '<?php echo $this->Html->url(array('controller'=>'Business','action'=>'sendPhoneCode','admin'=>false))?>';
        $url = $url+'/'+userId;
                    $.ajax({
                           url: $url,
                           type: "POST",
                           data:{id:userId},
                           beforeSend: function (xhr) {
                               $('.ajax_indicator').show();
                            },
                           success: function(res) {
                                $('.ajax_indicator').hide();
                                if(res=='1'){
                                    alert('Otp sent successfully!!');
                                }else{
                                    alert('Some error occured!!'); 
                                }
                           }
                   });
           });
	
	$('.cancel_gift').on('click' ,function(){
	   clearPointsData();
	   $(document).find('.promo_div').show();
	   $('.pay_hide_show').hide();
	});
	
/************************************Promo code *********************************************************/	
	$('#UserDetailGenderGift').on('change' , function(e){
		if( $(this).is( ":checked" ) ){
		    $('#AppointmentPoints').prop( "checked");
		    $('.promo_div').show();
		    $('.pay_hide_show').hide();
		    clearPointsData();  
		}else{
		    $('.promo_div').hide();
		     $('.pay_hide_show').show();
		    clearPointsData();
		}
	 });
	$('#UserDetailGenderPoints').on('change' , function(e){
	    if($(this).is(":checked")){
		    clearPointsData();
		    $('.promo_div').hide();
		    $('.pay_hide_show').show();
		    points();
		}else{
		    clearPointsData();   
		}
	});
	$('.promoCode').on('click', function(e){
	    gift_card();  
	});
	
	$('#UserDetailGenderCard').on('change' , function(e){
	  clearPointsData();
	  $('.promo_div').hide();
	   $('.pay_hide_show').show();
	});
	
	$('.common_vocher').on('change' , function(){
	   if($.trim($(this).val())=='no'){
	     $('.voucher_detail').fadeIn('slow');
	   }else{
	     $('.voucher_detail').fadeOut('slow');
	   }
	});
	
	
	//$(document).ajaxStart(function(){
	//    $(document).find('.loader-container').show();
	//    console.log('hererer');
	//}).ajaxStop(function(){
	//	setTimeout(function(){
	//	    console.log('hide');
	//		$(document).find('.loader-container').hide();
	//	},1000);
	//});
	
	
 });
  
  /***************Calculate amount for the points system************/
  
     function points(){
	var aed_price  = parseInt($('#aed_rate').val());
	//var points_redeem  = parseInt($('#points_redeem').val());
	var origna_amnt  = parseInt($('#amnt').val());
	var total_points  = parseInt($('#total_points').val());
	    if(total_points==0){
		alert('Sorry, you have not earned any point yet.');  
	    }else{
		point_amnt = total_points/aed_price;
		if(point_amnt >= origna_amnt){
		    form_action = $('#AppointmentRedirectUrl').val();
		    form_action = form_action+'/'+'points';
		    $('#AppointmentAppointmentForm').attr('action',form_action);
		    $(document).find('.AppointmentCheckout').text('Next'); 
		}else{
		    appointment_amount = origna_amnt-point_amnt;
		    $(document).find('.orginal_price').text(appointment_amount);
		    $(document).find('#AppointmentAmount').val(appointment_amount);
		    $(document).find('.user_point').text('0'); 
		    //console.log(appointment_amount);
		    $url ='<?php //echo $this->Html->url(array("controller"=>"Bookings" ,'action'=>'set_point')); ?>';
		    $.ajax({
			    url: $url,
			    type: "POST",
			    data:{is_usedpoint:1 ,use_point:total_points},
			    success: function(res){
				return false;
			    }
		     }); 
		}
	} 
   }
  
  
 /* function points(){
	var aed_price  = parseInt($('#aed_rate').val());
	var points_redeem  = parseInt($('#points_redeem').val());
	var origna_amnt  = parseInt($('#amnt').val());
	var total_points  = parseInt($('#total_points').val());
	if(total_points==0){
		alert('Sorry, you have not earned any point yet.');  
	    }else if(points_redeem=='' || points_redeem==0 || $.trim(points_redeem)=='NaN'){
		 alert("Sorry, you can't  use points for this service.");  
	    }else if(total_points >= points_redeem){
		form_action = $('#AppointmentRedirectUrl').val();
		form_action = form_action+'/'+'points';
		points_left = total_points-points_redeem;
		$(document).find('.user_point').text(points_left);
		$('#AppointmentAppointmentForm').attr('action',form_action);
		$(document).find('.AppointmentCheckout').text('Next');
	    }else{
		point_amnt = total_points/aed_price;
		appointment_amount = origna_amnt-point_amnt;
		$(document).find('.orginal_price').text(appointment_amount);
		$(document).find('#AppointmentAmount').val(appointment_amount);
		$(document).find('.user_point').text('0');
		//console.log(appointment_amount);
		$url ='<?php //echo $this->Html->url(array("controller"=>"Bookings" ,'action'=>'set_point')); ?>';
		$.ajax({
			url: $url,
			type: "POST",
			data:{is_usedpoint:1 ,use_point:total_points},
			success: function(res){
			    // console.log(res);
			}
		 });
	} 
   }
 */
  
  function clearPointsData(){
		    $(document).find('.orginal_price').text($('#amnt').val());
		    $(document).find('#AppointmentAmount').val($('#amnt').val());
		    $(document).find('.user_point').text($('#total_points').val());
		    $(document).find('#AppointmentAppointmentForm').attr('action',$('#form_action').val());
		    $(document).find('.AppointmentCheckout').text('Pay');
		    $(document).find('#AppointmentPromoCode').val('');
		    $(document).find('.cancel_gift').hide();
		    $url ='<?php echo $this->Html->url(array("controller"=>"Bookings" ,'action'=>'clear_cart')); ?>';
		    $.ajax({
			    url: $url,
			    type: "POST",
			    data:{is_usedpoint:0 ,use_point:0},
			    success: function(res) {
				// console.log(res);
			     }
		    });   
   }
   
   /*************** Calculate amount for the gift codes ************/
     function gift_card(){
        var gift_code = $('#AppointmentPromoCode').val();
	var orignal_amnt  = parseInt($('#amnt').val());
	var is_accept = parseInt($('#is_accept_card').val());
	var is_accept_siesta = parseInt($('#is_accept_sieasta_card').val());
	var owner_salon_id = $('#owner_salon_id').val();
	    if(is_accept==0){
	       alert('Sorry , this Salon not accept giftvoucher.');
	       return false;
	    }else if(gift_code=='' || !gift_code){
		alert('Please enter gift card code.');
		return false;
	     }else{
		    $url ='<?php echo $this->Html->url(array("controller"=>"Bookings" ,'action'=>'check_giftcard')); ?>';
		    $.ajax({
			    url: $url,
			    type: "POST",
			    data:{gift_code:gift_code,is_accept_siesta:is_accept_siesta,owner_salon_id:owner_salon_id},
			    success: function(res) {
				
			       if(res =='expired'){
				alert('Your gift certificate is expired.');   
			       }else if(res =='invalid'){
				alert('Your gift card code is invalid.');      
			       }else if(res =='not_accept_sieasta'){
				alert('This salon does not accept sieasta gift certificates.');
				}else if(res == 'offline'){
				alert('Offline Gift Certificate cannot be redeemed Online.');
				}else{
				   result  = jQuery.parseJSON( res);
				   gift_amnt = result.amount;
				   if(gift_amnt > orignal_amnt || gift_amnt == orignal_amnt){
				       if(gift_amnt == orignal_amnt){
						form_action = $('#AppointmentRedirectUrl').val();
						form_action = form_action+'/'+'gift';
						$('#AppointmentAppointmentForm').attr('action',form_action);
						$(document).find('.AppointmentCheckout').text('Next');
						gift_set(result);
					}else{
					    if(confirm("Your gift certificate amount is greater than the service amount.you can again use this gift certificate.")){
						form_action = $('#AppointmentRedirectUrl').val();
						form_action = form_action+'/'+'gift';
						$('#AppointmentAppointmentForm').attr('action',form_action);
						$(document).find('.AppointmentCheckout').text('Next');
						gift_set(result);
					     }
					}
				   }else{
				    after_amount = orignal_amnt-gift_amnt;
				    $(document).find('.orginal_price').text(after_amount);
				    $(document).find('#AppointmentAmount').val(after_amount);
				    $(document).find('#AppointmentAppointmentForm').attr('action',$('#form_action').val());
				    $(document).find('.AppointmentCheckout').text('Pay');
				    $url ='<?php echo $this->Html->url(array("controller"=>"Bookings" ,'action'=>'set_point')); ?>';
				    gift_set(result);		    
				   }
			       }
			   }
		       }); 
		}
	    }
   
    function valid_coupon(){
	$(document).find('.cancel_gift').show();
	$(document).find('.pay_hide_show').show();
	$(document).find('.promo_div').hide();
    }
    
    //function clear_giftcertificate(){
    //    
    //}
   function gift_set(result){
    $url ='<?php echo $this->Html->url(array("controller"=>"Bookings" ,'action'=>'set_point')); ?>';
    $.ajax({
	    url: $url,
	    type: "POST",
	    data:{is_usedpoint:1 ,use_gift_id:result.id,type:'gift'},
	    success: function(res) {
		valid_coupon();
	    }
       });  
   }
  </script>