<?php $lang = Configure::read('Config.language');
     $merchant_id = Configure::read('merchant_id');
     //pr($gift_detail);
?>
<style type="text/css">
    .modal-dialog.gift_certificate_width{
	width: 80% !important
    }
</style>
<div class="wrapper">
    <div class="container">
	  <div class="fixed-rgt appBukrgt">
	       <div class="deal-banner-rgt">
		    <div class="price">
			 <?php  $tax = $taxes['TaxCheckout']['tax1']+ $taxes['TaxCheckout']['tax2'];
				    $amount  = $gift_detail['GiftCertificate']['amount'];
			 ?>
			  AED <?php echo $amount; ?>
		    <!-- <div class="off-outer"><div class="off"></div>20% Off</div> -->
		    </div>
		    <?php  //echo '<span> including '.$tax.'% tax'; ?>
		    <div class="price service-name">
			 
		    </div>
		    <div class="info-details">
		       <h5><i class="fa fa-location-arrow"></i> Expiry On :
			
			<?php
			//pr($gift_detail['GiftCertificate']['expire_on']);
			
			if($gift_detail['GiftCertificate']['expire_on']=='0'){ ?>
			<i class="fa fa-clock-o"></i> Never Expire
			<?php } else{ ?>
			<i class="fa fa-clock-o"></i>
		        <?php echo ($gift_detail['GiftCertificate']['expire_on'])?$gift_detail['GiftCertificate']['expire_on']:'Never'; ?></div>
			<?php }?>
		    </h5>
		    <div class="duration">
			 <h5>Send To</h5>
			 <div class="time">
			   <?php echo $gift_detail['GiftCertificate']['email'] ?>
			 </div>
		    </div>
		    <div class="duration">
			 <h5>Gift Card</h5>
			 <div class="time">
			     <?php
				   if(!empty($gift_detail['GiftCertificate']['image'])){
					echo $this->Html->Image('/images/GiftImage/original/'.$gift_detail['GiftCertificate']['image'],array('class'=>'showGiftImage'));
				   }
			      ?>
			 </div>
		    </div>
	       </div>
	  </div>
        <div class="big-lft appBuklft">
            <div class="business">
                <div class="well clearfix text-left custom_well">
		    <div class="col-sm-12">
			<h2 class="fs-title" >Details</h2>
		    </div>
                    <?php 
		    //pr($gift_detail);
			echo $this->Form->create('Appointment',array('url'=>array('controller'=>'GiftCertificates','action'=>'payment'))); ?>
                        <?php echo $this->Form->input('gift_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$gift_detail['GiftCertificate']['id'])); ?>
			<?php echo $this->Form->input('price_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$gift_detail['GiftCertificate']['amount'])); ?>
			<?php echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$merchant_id, 'type'=>'hidden')); ?>
			<?php echo $this->Form->input('order_id',array('value'=>rand(),'label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden')); ?>
                        <?php echo $this->Form->input('amount',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$gift_detail['GiftCertificate']['amount'])); ?>
                        <?php echo $this->Form->input('currency',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>'AED')); ?>
                        <?php
			$uid = (isset($auth_user['User']['id']))?$auth_user['User']['id']:'';
			echo $this->Form->input('redirect_url',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>Configure::read('BASE_URL').'/GiftCertificates/payment/'.$gift_detail['GiftCertificate']['id'].'/'.$uid)); ?> 
                        <?php echo $this->Form->input('cancel_url',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>Configure::read('BASE_URL').'/GiftCertificates/payment/'.$gift_detail['GiftCertificate']['id'].'/'.$uid)); ?>
                        <?php echo $this->Form->input('language',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>"EN")); ?>
			 <div class="col-sm-6">
                            <div class="form-group">
                               <label><?php echo __('First Name');?> *</label>
                                <?php $firstName = $lastName = "";
				$address = $address_data = $country = $state =  $city =  $zip_code = $billing_name  = "";
				if(isset($auth_user)){
				    //pr($auth_user);
                                    $firstName = ucfirst($auth_user['User']['first_name']);
                                    $lastName  = ucfirst($auth_user['User']['last_name']);
				    $address = $auth_user['Address']['address'];
				    $address_data  =  $this->Common->get_UserAddress($auth_user['User']['id']);
				    $country = $address_data['Country']['name'];
				    $state = $address_data['State']['name'];
				    $city = $address_data['City']['city_name'];
				    $zip_code = $address_data['Address']['po_box'];
				    $billing_name  = ucfirst($auth_user['User']['first_name'].' '.$auth_user['User']['last_name']);
                                }
                               ?>
			<?php echo $this->Form->input('first_name',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$firstName,'minlength'=>'3','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>__("First Name is Required.",true),'data-minlength-msg'=>__("Minimum 3 characters.",true),'data-pattern-msg'=>__("Please enter only alphabets.",true),'maxlengthcustom'=>'55','data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'maxlength'=>58)); ?>                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                               <label><?php echo __('Last Name');?> *</label>
                           <?php echo $this->Form->input('last_name',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$lastName,'minlength'=>'3','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>__("Last Name is Required.",true),'data-minlength-msg'=>__("Minimum 3 characters.",true),'data-pattern-msg'=>__("Please enter only alphabets.",true),'maxlengthcustom'=>'55','data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'maxlength'=>58)); ?>
                                <?php echo $this->Form->input('billing_name',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$billing_name)); ?>
                                <?php echo $this->Form->input('billing_address',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$address)); ?>
                                <?php echo $this->Form->input('billing_city',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$city)); ?>
                                <?php echo $this->Form->input('billing_state',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$state)); ?>
                                <?php echo $this->Form->input('billing_zip',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$zip_code)); ?>
                                <?php echo $this->Form->input('billing_country',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$country)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                               <label class="col-sm-12 no-pdng"><?php echo __('Cell Number');?> *</label>
                                <div class="col-sm-12  no-pdng">
                                <div class="col-sm-4 pdng-lft0">
                                <?php
                                $phnNo = '';
                                if(isset($auth_user)){
                                    $phnNo = $auth_user['Contact']['cell_phone'];
                                    if($auth_user['Address']['country_id']){ ?>
                                        <script>
                                            $(document).ready(function(){
                                                $.ajax({ url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+'<?php echo $auth_user['Address']['country_id']; ?>', success: function(res) { $(document).find('.cPHcd').val(res); } });
                                            });
                                        </script>
                                    <?php }
                                }
                                echo $this->Form->input('country_code',array('label'=>false,'div'=>false,'class'=>'form-control cPHcd','disabled'=>'disabled','value'=>'+971')); ?>
                                </div>
                                <div class="col-sm-8 no-pdng">
                               <?php echo $this->Form->input('billing_tel',array('label'=>false,'div'=>false,'class'=>'form-control number','value'=>$phnNo,'required'=>true,'maxlength'=>10,'required','validationMessage'=>"Mobile Number is required.",'data-minlength-msg'=>__("Minimum 9 characters.",true),'minlength'=>'3')); ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                               <label>Email </label>
                            <?php $email = ""; $readonly = false;
                                if(isset($auth_user)){
                                    $email = $auth_user['User']['email'];
                                    $readonly = 'readonly';
                                }
                                ?>
                                <?php echo $this->Form->input('billing_email',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$email,'readonly'=>$readonly)); ?>
                                <?php echo $this->Form->input('billing_country',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('delivery_name',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('delivery_address',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('delivery_city',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('delivery_state',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('delivery_zip',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('delivery_country',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('delivery_tel',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('merchant_param1',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('merchant_param2',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('merchant_param3',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('merchant_param4',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('merchant_param5',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                            </div>
                        </div>
                        <!--<div class="col-sm-12" >
                            <h2 class="fs-title" >Promo Code</h2>
			    <div class="form-group">
                                <div class="col-sm-8 pdng-lft0">
				    <?php //echo $this->Form->input('promo_code',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter promo /  gift card code')); ?>
				    <?php //echo $this->Form->input('customer_identifier',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
				</div>
				<div class="col-sm-4 no-pdng">
				    <?php //echo $this->Form->button('Use Code',array('type'=>'submit','label'=>false,'div'=>false,'class'=>'purple-btn promoCode pull-right')); ?>
				</div>
                            </div>
                        </div>--> 
                        <div class="col-sm-12" >
                            <div class="form-group">
                              <?php //echo $this->Form->button('Pay',array('type'=>'submit','label'=>false,'div'=>false,'class'=>'purple-btn AppointmentCheckout pull-right')); ?>
			      <?php echo $this->Html->link(__('PAY') ,'javascript:void(0)',array('class'=>'purple-btn AppointmentCheckout pull-right')); ?>
			    </div>
                        </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<!--  Small Modal POPUP-->
<div class="modal fade" id="commonSmallModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>
<?php //echo $this->element('frontend/Booking/commonpayment');  ?>
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
		$("#AppointmentGiftCartForm").submit();
	    }else if((form_phone == userPhone) && is_verified !='1' && form_phone){
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
		    $("#AppointmentGiftCartForm").submit();
		   }else if($.trim(msg) == 'verification_sent'){
			
			itsId = '<?php echo base64_encode($auth_user["User"]["id"]); ?>';
			addeditURL = addeditURL+'/'+itsId;	
			var addeditURL = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'varify_phone','admin'=>false)); ?>";		 
		       fetchModal($modal,addeditURL);
		  }else{
		    //console.log('hererer');
		  }
	    });
	}    
    }	

    </script>
<?php } ?>
 <script>
    $(document).ready(function(e){
	 var prodValidator = $("#AppointmentGiftCartForm").kendoValidator({
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
                            
			    $("#AppointmentGiftCartForm").submit();
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
	 
 });
    
 </script>

