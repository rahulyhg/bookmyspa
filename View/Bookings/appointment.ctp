<style>
a {
 text-decoration: none !important;
}
.gender-input {
    float: left;
    width: 30%;
}
.book-coupons {
    display: inherit;
    float: right;
    font-size: 20px;
}


</style>

<?php
	  $lang = Configure::read('Config.language');
	  $merchant_id = Configure::read('merchant_id');
	  $appointmentDetail =  $this->Session->read('appointmentData.Appointment');
	    //pr($serviceDetails);
	    //pr($this->Session->read('appointmentData'));   
	  //die;
?>
<div class="wrapper">
    <div class="container">
        <div class="fixed-rgt appBukrgt">
	<div class="deal-banner-rgt">
            <p><span>
	    <?php
	    $amount = '';
	    $points_redeem = '';
	    //pr($serviceDetails);
	    foreach($serviceDetails['ServicePricingOption'] as $priceOpt){
			if($priceOpt['id'] == $theData['Appointment']['price_id']){
			    echo '<b>';
			    if(!empty($priceOpt['custom_title_'.$lang])){
		    		    echo $priceOpt['custom_title_'.$lang];
				}else{
			    	    echo $priceOpt['custom_title_eng'];
				}
				echo '</b>';
			    echo '</span>';
			    echo '<div class="price">';
			    $tax = $taxes['TaxCheckout']['tax1']+ $taxes['TaxCheckout']['tax2'];
			    //echo 'Total Price including '.$tax.'% tax: ';
			    echo 'Total Price : '; 
			    echo __('AED',true);
			    echo '<span class="orginal_price">';
			    $amount =  ($priceOpt['sell_price'])? $priceOpt['sell_price'] :$priceOpt['full_price'];
				if($appointmentDetail['theBuktype']=='eVoucher'){
				   $quantity  = $appointmentDetail['selected_quantity'];
				   $amount = $quantity*$amount;
				}
				if($tax > 0){
				    $tax_amount = ($amount*$tax)/100;
				    $amount =  $tax_amount + $amount;
				}    
			    echo $amount;
			    echo '</span>';
			    echo '</div>';   
			    echo '<span> including '.$tax.'% tax';
			    break; 
			}
		    } ?>
                 
              <!--<div class="price">
                  ADE 20
                  <div class="off-outer"><div class="off"></div>20% Off</div>
              </div>-->
	    <div class="price service-name">
		<?php
		    if(!empty($serviceDetails['SalonService'][$lang.'_name'])){
				      echo $serviceDetails['SalonService'][$lang.'_name'];
				  }elseif(!empty($serviceDetails['Service'][$lang.'_name'])){
				      echo $serviceDetails['Service'][$lang.'_name'];
				  }else{
				      echo $serviceDetails['Service']['eng_name'];
				  }
		?>
	    </div>
	    <div class="info-details">
		<h5>
		    <i class="fa fa-location-arrow"></i>
		    <?php  if(!empty($serviceOwner['Salon'][$lang.'_name'])){ echo $serviceOwner['Salon'][$lang.'_name']; }else{ echo $serviceOwner['Salon']['eng_name']; } ?>
		</h5>		
	    </div>
	      <?php if($theData['Appointment']['theBuktype'] == "appointment"){ ?>
		<div class="duration bod-tp-non">
		       <h5><?php echo __('Service Provider Name',true); ?></h5>
			<div class="time"> <i class="fa fa-user"></i>
			    <?php
			 $nameArray =  $this->Common->employeeName($theData['Appointment']['selected_employee_id']);
			 echo $nameArray['User']['first_name'].' '.$nameArray['User']['last_name'];
		    ?>  
			</div>
		</div>
		
		<div class="duration half-w">
		    <h5>Time</h5>
		    <div class="time"><i class="fa fa-clock-o"></i> <?php echo $theData['Appointment']['selected_time']; ?></div>
		</div>
		<div class="duration half-w">
		      <h5>Date</h5>
		      <div class="time"><i class="fa fa-calendar"></i> <?php echo $theData['Appointment']['selected_date']; ?></div>
		</div>
		
		<div class="clearfix"></div>
		<?php }?>
              <div class="duration bod-tp-non">
                  <h5><?php echo __('Duration',true); ?></h5>
             <div class="time"><i class="fa fa-clock-o"></i> <?php $durationArray = $this->common->get_duration();
                        foreach($serviceDetails['ServicePricingOption'] as $priceOpt){
                            if($priceOpt['id'] == $theData['Appointment']['price_id']){
                                echo $durationArray[$priceOpt['duration']];
				$points_redeem  =$priceOpt['points_redeem']; 
				break; 
                            }
                        }  ?>
	    </div>
              </div>
	   <?php //if($appointmentDetail['theBuktype']=='appointment'){  ?>
	       <div class="duration bod-tp-non">
		    <h5><?php echo __('Your Total Points',true); ?></h5>
		    <div class="time"><i class="fa fa-file-powerpoint-o"></i>&nbsp;
		      <span class="user_point" ><?php echo isset($totalPoints)?$totalPoints:'0'; ?></span>
		   </div>
               </div>
	       
	       
	       
		<div class="duration bod-tp-non">
		      <h5>
		      <?php
		      $type_service = ($appointmentDetail['theBuktype']=='eVoucher')?'eVoucher':'Service';
		      echo __("Points Need for this $type_service",true); ?></h5>
		      <div class="time"><i class="fa fa-file-powerpoint-o"></i>&nbsp;
			<span class="redeem_points" >
			  <?php echo (isset($points_redeem) && !empty($points_redeem))?$points_redeem*$appointmentDetail['selected_quantity']:'Its not available on points.'; ?>
			</span>
		     </div>
		</div>
	      <?php //} ?>
	     <?php if($theData['Appointment']['theBuktype'] != "appointment"){ ?>
            <div class="duration bod-tp-non" >
                    <h4><?php echo __('Quantity',true); ?></h4>
                    <div class="time"><i class="fa  fa-exclamation-triangle"></i> <?php echo $theData['Appointment']['selected_quantity']; ?></div>
            </div>
            <?php } ?>
	   
            <?php if(!empty($ownerPolicy)){?>
                <div class="duration bod-non">
                    <h5><?php echo __('cancel_policy',true); ?></h5>
                    <div class="time">
                        <i class="fa  fa-exclamation-triangle"></i> 
                         <?php 
                             if(!empty($ownerPolicy['PolicyDetail'][$lang.'_cancel_appointment_policy'])){
                                 echo $ownerPolicy['PolicyDetail'][$lang.'_cancel_appointment_policy'];
                             }else{
                                 echo $ownerPolicy['PolicyDetail']['eng_cancel_appointment_policy'];
                             }
                         ?>                       
                     </div>
                </div>
                <div class="duration bod-non">
                    <h5><?php echo __('reschedule_policy',true); ?></h5>
                    <div class="time">
                        <i class="fa  fa-exclamation-triangle"></i> 
                         <?php 
                             if(!empty($ownerPolicy['PolicyDetail'][$lang.'_reschedule_appointment_policy'])){
                                 echo $ownerPolicy['PolicyDetail'][$lang.'_reschedule_appointment_policy'];
                             }else{
                                 echo $ownerPolicy['PolicyDetail']['eng_reschedule_appointment_policy'];
                             }
                         ?>                       
                     </div>
                </div>
            <?php } ?>
	    
	    </div>
        </div>
        <div class="big-lft appBuklft">
            <div class="business">
                <div class="well clearfix text-left custom_well">
		    <div class="col-sm-12">
			<h2 class="fs-title" >Details</h2>
		    </div>
		    <?php
		    $uid = (isset($auth_user['User']['id']))?$auth_user['User']['id']:'';
		    if($appointmentDetail['theBuktype']=='eVoucher'){
			echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Bookings','action'=>'book_evoucher',$serviceDetails['SalonService']['id'],$uid,'payment'))); 	
		    }else{ 
			echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Bookings','action'=>'payment',$serviceDetails['SalonService']['id'],$uid,'payment'))); 
		    }
		    ?>
		    <?php echo $this->Form->input('service_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$serviceDetails['SalonService']['id'])); ?>
			<?php echo $this->Form->input('price_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$theData['Appointment']['price_id'])); ?>
			<?php //echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
			<?php //echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
			<?php echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$merchant_id, 'type'=>'hidden')); ?>
			<?php echo $this->Form->input('order_id',array('value'=>$this->Common->getRandPass(),'label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden')); ?>
                         <?php echo $this->Form->input('amount',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$amount)); ?>
                        <?php echo $this->Form->input('currency',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>'AED')); ?>
                        <?php
			
			 if($appointmentDetail['theBuktype']=='eVoucher'){
			    $ret_funtion = 'book_evoucher';
			 }else{
			     $ret_funtion = 'payment';
			 }
    echo $this->Form->input('redirect_url',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>Configure::read('BASE_URL').'/Bookings/'.$ret_funtion.'/'.$serviceDetails['SalonService']['id'].'/'.$uid)); ?>
                        <?php echo $this->Form->input('cancel_url',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>Configure::read('BASE_URL').'/Bookings/'.$ret_funtion.'/'.$serviceDetails['SalonService']['id'].'/'.$uid));
			
			?>
			
			<?php echo $this->Form->input('language',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>"EN")); ?>
                        <div class="col-sm-12">
			<div class="col-sm-6">
                            <div class="form-group">
                               <label  >First Name </label>
                               <?php $firstName = $lastName = "";
				$address = $address_data = $country = $state =  $city =  $zip_code = $billing_name  = "";
				if(isset($auth_user)){
					//pr($auth_user);
                                    $firstName = ucfirst($auth_user['User']['first_name']);
                                    $lastName  = ucfirst($auth_user['User']['last_name']);
				    //pr($auth_user);
				    $address = $auth_user['Address']['address'];
				$address_data  =  $this->Common->get_UserAddress($auth_user['User']['id']);
				    $country = $address_data['Country']['name'];
				    $state = $address_data['State']['name'];
				    $city = $address_data['City']['city_name'];
				    $zip_code = $address_data['Address']['po_box'];
		    $billing_name  = ucfirst($auth_user['User']['first_name'].' '.$auth_user['User']['last_name']);
                                }
                               ?>
                               
                               <?php echo $this->Form->input('first_name',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$firstName,'minlength'=>'3','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>__("First Name is Required.",true),'data-minlength-msg'=>__("Minimum 3 characters.",true),'data-pattern-msg'=>__("Please enter only alphabets.",true),'maxlengthcustom'=>'55','data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'maxlength'=>58)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                               <label  >Last Name </label>
                               <?php echo $this->Form->input('last_name',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$lastName,'minlength'=>'3','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>__("Last Name is Required.",true),'data-minlength-msg'=>__("Minimum 3 characters.",true),'data-pattern-msg'=>__("Please enter only alphabets.",true),'maxlengthcustom'=>'55','data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'maxlength'=>58)); ?>
                                <?php echo $this->Form->input('billing_name',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$billing_name)); ?>
                                <?php echo $this->Form->input('billing_address',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$address)); ?>
                                <?php echo $this->Form->input('billing_city',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$city)); ?>
                                <?php echo $this->Form->input('billing_state',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$state)); ?>
                                <?php echo $this->Form->input('billing_zip',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$zip_code)); ?>
                                <?php echo $this->Form->input('billing_country',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>$country)); ?>
                            </div>
                        </div>
		</div>
			<div class="col-sm-12">
			<div class="col-sm-6">
                            <div class="form-group">
                               <label class="col-sm-12 no-pdng">Mobile Number </label>
                                <div class="col-sm-12  no-pdng">
                                <div class="col-sm-4 col-xs-4 pdng-lft0">
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
                                echo $this->Form->input('country_code',array('label'=>false,'div'=>false,'class'=>'form-control cPHcd','readonly'=>'readonly','value'=>'+971')); ?>
                                </div>
				    <div class="col-sm-8 col-xs-8 no-pdng">
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
				<?php echo $this->form->input('Points.aed_rate' ,array('type'=>'hidden' , 'value'=>$pointsVal['PointSetting']['aed_unit']));
				      echo $this->form->input('Points.given_per_aed' ,array('type'=>'hidden' , 'value'=>$pointsVal['PointSetting']['siesta_point_given']));
				      echo $this->form->input('Points.points_redeem' ,array('type'=>'hidden','value'=>$points_redeem));
				      echo $this->form->input('Points.total_points' ,array('type'=>'hidden','value'=>isset($totalPoints)?$totalPoints:'0'));
				      echo $this->form->input('Points.amnt' ,array('type'=>'hidden','value'=>$amount ));
				      ?>
 </div>
                        </div>
                        
			</div>
    
    <?php if($appointmentDetail['theBuktype']=='eVoucher'){ ?>		
	<div class="col-sm-12" >
	<div class="col-sm-3">
	    Is this for you?
	</div>
	<div class="col-sm-4 " >
	    <div class="form-group">
		
		<section class="gender-input">
		    <?php
		      $options=array('yes'=>'Yes','no'=>'No');
		      $attributes=array('legend'=>false,'separator'=>'</section><section class="gender-input">' ,'label'=>array('class'=>'new-chk'),'value'=>'yes','class'=>'common_vocher');
		      echo $this->Form->radio('UserDetail.voucher',$options,$attributes);
		      ?>
	       </section>
	 </div>
	    </div>
	</div>
	<div class="col-sm-12 voucher_detail" style="display: none">
	 <div class="col-sm-6 " >
	    <div class="form-group">
	    <label>Who is the lucky recipient?</label>
    <?php echo $this->Form->input('recipient_name',array('label'=>false,'div'=>false,'class'=>'form-control','validationMessage'=>__("lucky recipient name is required.",true),'maxlengthcustom'=>'55','data-maxlengthcustom-msg'=>__("Maximum 55 characters are allowed.",true),'maxlength'=>58 ,'type'=>'text','placeholder'=>'Name on voucher')); ?>
	    </div>
	</div>
	   <div class="col-sm-6 pdng-ryt0" >
		<div class="form-group">
		    <label>Gift message: </label>
	<?php echo $this->Form->input('recipient_message',array('label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>250 ,'type'=>'textarea','rows'=>'1','placeholder'=>'Voucher message')); ?>
		</div>
	    </div>
	</div>
	<?php } ?>
			<div class="col-sm-12 tp-p-10" >
			 <div class="col-sm-3">
			     Choose a payment method
			 </div>
                           <!-- <h2 class="fs-title" >Promo Code</h2>-->
			  
			   <div class="form-group col-sm-9">
				<section class="gender-input">
				    <?php
				      $options=array('gift'=>'Gift Certificate','points'=>'Use Points','card'=>'Pay with credit card');
				      $attributes=array('legend'=>false,'separator'=>'</section><section class="gender-input">' ,'label'=>array('class'=>'new-chk'),'value'=>'card');
				      echo $this->Form->radio('UserDetail.gender',$options,$attributes);
				      ?>
			       </section>
			    </div>
			     <div class="promo_div" style='display: none' >
				<div class="form-group">
				    <div class="col-sm-8">
					<?php echo $this->Form->input('Point.promo_code',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter promo /  gift card code','id'=>'AppointmentPromoCode')); ?>
					<?php echo $this->Form->input('customer_identifier',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
				    </div>
				    <div class="col-sm-4 no-pdng">
					<div class="pull-right"><?php echo $this->Form->button('Use Code',array('type'=>'button','label'=>false,'div'=>false,'class'=>'purple-btn promoCode ','readonly'=>false)); ?></div>
				    </div>
				</div>
			     </div>
                        </div>
     <div class="col-sm-12" >
			<div class="form-group">
			 <div class="pull-left">
		    <a style="display: none" class="cancel_gift gray-btn" href='javascript:void(0)'>Cancel</a>
			 </div>
			    <div class="pull-right pay_hide_show">
			    <?php echo $this->Html->link('PAY' ,'javascript:void(0)',array('class'=>'purple-btn AppointmentCheckout')); ?>
			    </br><div class="book-coupons"> coupon will apply at next page</div>
			    </div>
	</div>
    </div>
                    <?php echo $this->Form->end(); ?>
     </div>
            </div>

        </div>
    </div>
</div>
<!-- Hidden varibales --------------------->
    <?php echo $this->form->input('aed_rate' ,array('type'=>'hidden' , 'value'=>$pointsVal['PointSetting']['aed_unit']));
      echo $this->form->input('given_per_aed' ,array('type'=>'hidden' , 'value'=>$pointsVal['PointSetting']['siesta_point_given']));
      echo $this->form->input('points_redeem' ,array('type'=>'hidden','value'=>$points_redeem));
      echo $this->form->input('amnt' ,array('type'=>'hidden','value'=>$amount));
      echo $this->form->input('total_points' ,array('type'=>'hidden','value'=>isset($totalPoints)?$totalPoints:'0'));
	if($appointmentDetail['theBuktype']=='eVoucher'){
	   $ret_funtion = 'book_evoucher/'.$serviceDetails['SalonService']['id'].'/'.$uid.'/payment';
	}else{
	    $ret_funtion = 'payment/'.$serviceDetails['SalonService']['id'].'/'.$uid.'/payment';
	}
      echo $this->form->input('form_action' ,array('type'=>'hidden','value'=>'/Bookings/'.$ret_funtion));
      echo $this->form->input('is_accept_sieasta_card' ,array('type'=>'hidden','value'=>$ownerPolicy['PolicyDetail']['enable_sieasta_voucher']));
      echo $this->form->input('is_accept_card' ,array('type'=>'hidden','value'=>$ownerPolicy['PolicyDetail']['enable_gfvocuher']));
      echo $this->form->input('owner_salon_id' ,array('type'=>'hidden','value'=>$salon_id));
      echo $this->form->input('appointment_type' ,array('type'=>'hidden','value'=>$appointmentDetail['theBuktype']));
     echo $this->form->input('selected_quantity' ,array('type'=>'hidden','value'=>$appointmentDetail['selected_quantity']));
      
      
?>
<!--  Small Modal POPUP-->
<div class="modal fade" id="commonSmallModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>
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
		if($(this).is(":checked")){
		   $('.promo_div').hide();
		   $('.pay_hide_show').show();
		   clearPointsData();  
		}else{
		    clearPointsData();   
		}
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
	var points_redeem  = parseInt($('#points_redeem').val());
	var quantity = parseInt($('#selected_quantity').val());
	var points_redeem  = points_redeem*quantity;
	var origna_amnt  = parseInt($('#amnt').val());
	console.log(origna_amnt);
	//var origna_amnt  = origna_amnt*quantity;
	var total_points  = parseInt($('#total_points').val());
	console.log('total_point'+total_points);
	//console.log('redeem_point'+points_redeem);
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
		$url ='<?php echo $this->Html->url(array("controller"=>"Bookings" ,'action'=>'set_point')); ?>';
		$.ajax({
			  url: $url,
			  type: "POST",
			  data:{is_usedpoint:1 ,use_point:total_points},
			  success: function(res) {
			      // console.log(res);
			  }
		   });
	} 
   }
  
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
			       res = $.trim(res); 
			       if(res =='expired'){
				 alert('Your gift certificate is expired.');   
			       }else if(res =='invalid'){
				 alert('Your gift card code is invalid.');      
			       }else if(res =='not_accept_sieasta'){
				 alert('This salon does not accept sieasta gift certificate.');
				}else if(res == 'offline'){
				 alert('Offline Gift Certificate cannot be redeemed Online.');
				}else{
				   result  = jQuery.parseJSON(res);
				   gift_amnt = result.amount;
				   if(gift_amnt > orignal_amnt || gift_amnt == orignal_amnt){
				       if(gift_amnt == orignal_amnt){
						form_action = $('#AppointmentRedirectUrl').val();
						form_action = form_action+'/'+'gift';
						$('#AppointmentAppointmentForm').attr('action',form_action);
						$(document).find('.AppointmentCheckout').text('Next');
						gift_set(result);
					}else{
					    if(confirm("Your gift certificate amount is greater than the service amount.You can again use this gift certificate.")){
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
