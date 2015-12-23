<style>
a {
 text-decoration: none !important;
}
.gender-input {
    float: left;
    width: 30%;
}
</style>
 
<?php
	  $lang = Configure::read('Config.language');
	  $merchant_id = Configure::read('merchant_id');
	  $appointmentDetail =  $this->Session->read('appointmentData.Appointment');
	    //pr($serviceDetails);
	   //pr($appointmentDetail);   
	  //die;
?>
<div class="wrapper">
    <div class="container">
        <div class="fixed-rgt appBukrgt">
	<div class="deal-banner-rgt spabreakAppoint">
            <p><span>
	    <?php
	    $amount = '';
	    $points_redeem = '';
	    //pr($serviceDetails);
            if(!empty($serviceDetails)){
                
			   echo '<b>';
			    if(!empty($serviceDetails['Spabreak'][$lang.'_name'])){
		    		    echo $serviceDetails['Spabreak'][$lang.'_name'];
				}else{
			    	    echo $serviceDetails['Spabreak']['eng_name'];
				}
				echo '</b>';
			    echo '</span>';
            }

            if(!empty($spabreakOptions)){
                foreach($spabreakOptions as $spabreakOption){
                    foreach($spabreakOption['SpabreakOptionPerday'] as $priceOpt){
                        if($appointmentDetail['theBuktype'] == "appointment"){
                            $dayBreak = $appointmentDetail['breakDay'];
                            if($priceOpt[$dayBreak] == 1){
                                $appointmentDetail['price_id'] = $priceOpt['id'];
                                $_SESSION['appointmentData']['Appointment']['price_id'] = $priceOpt['id'];
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
                        }else{
                            //echo "sonam";
                            if($priceOpt['id'] == $appointmentDetail['price_id']){
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
                        }
                    } 
                }    
            }    
                ?>
                 
	    <div class="price service-name">
		<?php  if(!empty($serviceDetails['Spabreak'][$lang.'_name'])){
				      echo $serviceDetails['Spabreak'][$lang.'_name'];
				  }elseif(!empty($serviceDetails['Spabreak'][$lang.'_name'])){
				      echo $serviceDetails['Spabreak'][$lang.'_name'];
				  }else{
				      echo $serviceDetails['Spabreak']['eng_name'];
				  } ?>
	    </div>
	    <div class="info-details bod-tp-non">
		<h5><i class="fa fa-location-arrow"></i> <?php  if(!empty($serviceOwner['Salon'][$lang.'_name'])){ echo $serviceOwner['Salon'][$lang.'_name']; }else{ echo $serviceOwner['Salon']['eng_name']; } ?></h5>		
	    </div>
	     
                
           
	  
	     <?php if($theData['Appointment']['theBuktype'] != "appointment"){ ?>
            <div class="duration bod-tp-non spaAppQuantity" >
                    <h4><?php echo __('Quantity',true); ?></h4>
                    <div class="time"><i class="fa  fa-exclamation-triangle"></i> <?php echo $theData['Appointment']['selected_quantity']; ?></div>
            </div>
            <?php } ?>
                
            <?php if($theData['Appointment']['theBuktype'] == "appointment"){ ?>
            <div class="duration bod-tp-non">
                  <h5>Date</h5>
                  <div class="time"><i class="fa fa-calendar"></i>  <?php echo $theData['Appointment']['breakDateSelected'].' - '.$theData['Appointment']['breakDateEnd'] ; ?></div>
            </div>
            <div class="clearfix"></div>
            <?php }?>
                
            <div class="duration bod-tp-non">
                <div class="half-w">
                    <h5><?php echo __('CheckIn Time',true); ?></h5>
                    <div class="time">
                        <i class="fa fa-clock-o"></i>
                        <?php 
                             //pr($serviceDetails); 
                            if(!empty($serviceDetails)){
                                if(!empty($serviceDetails['Spabreak']['check_in'])){
                                    echo date('h:i A',strtotime($serviceDetails['Spabreak']['check_in']));
                                }                           
                            }

                        ?>
                    </div>
                </div>
                <div class="half-w">
                    <h5><?php echo __('CheckOut Time',true); ?></h5>
                    <div class="time">
                        <i class="fa fa-clock-o"></i>
                        <?php 
                             //pr($serviceDetails); 
                            if(!empty($serviceDetails)){
                                if(!empty($serviceDetails['Spabreak']['check_out'])){
                                    echo date('h:i A',strtotime($serviceDetails['Spabreak']['check_out']));
                                }
                            }

                        ?>
                    </div>
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
		      $type_service = ($appointmentDetail['theBuktype']=='eVoucher')?'eVoucher':'Spabreak';
		      echo __("Points Needed for this $type_service",true); ?></h5>
		      <div class="time"><i class="fa fa-file-powerpoint-o"></i>&nbsp;
			<span class="redeem_points" >
                            <?php
                                if(isset($pointsVal) && !empty($pointsVal)){
                                    echo $amount*$pointsVal['PointSetting']['aed_unit'];
                                }
                            ?>
			</span>
		     </div>
		</div>
	      <?php //} ?>
                
	    <div class="duration bod-non">
                <h5><?php echo __('cancel_policy',true); ?></h5>
                 <div class="time">
                     <i class="fa  fa-exclamation-triangle"></i>
                     <?php 
                         //pr($ownerPolicy); 
                         if(!empty($ownerPolicy)){
                             if($theData['Appointment']['theBuktype'] != "appointment"){
                                 if(!empty($ownerPolicy['PolicyDetail'][$lang.'_evocher_cancel_policy'])){
                                     echo $ownerPolicy['PolicyDetail'][$lang.'_evocher_cancel_policy'];
                                 }else{
                                     echo $ownerPolicy['PolicyDetail']['eng_evocher_cancel_policy'];
                                 }
                             }else{
                                 if(!empty($ownerPolicy['PolicyDetail'][$lang.'_cancellation_policy_text'])){
                                     echo $ownerPolicy['PolicyDetail'][$lang.'_cancellation_policy_text'];
                                 }else{
                                     echo $ownerPolicy['PolicyDetail']['eng_cancellation_policy_text'];
                                 }
                             }
                         }

                     ?>
                 </div>
            </div>
            
            <div class="duration bod-non">
                <h5><?php echo __('reschedule_policy',true); ?></h5>
                 <div class="time">
                     <i class="fa  fa-exclamation-triangle"></i>
                     <?php 
                         //pr($ownerPolicy); 
                         if(!empty($ownerPolicy)){
                             
                            if(!empty($ownerPolicy['PolicyDetail'][$lang.'_reschedule_policy_text'])){
                                echo $ownerPolicy['PolicyDetail'][$lang.'_reschedule_policy_text'];
                            }else{
                                echo $ownerPolicy['PolicyDetail']['eng_reschedule_policy_text'];
                            }

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
		    $uid = (isset($auth_user['User']['id']))?$auth_user['User']['id']:'';
    		    echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Spabreaks','action'=>'payment',$serviceDetails['Spabreak']['id'],$uid,'payment'))); 

		    ?>
		    <?php echo $this->Form->input('service_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$serviceDetails['Spabreak']['id'])); ?>
			<?php echo $this->Form->input('price_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$appointmentDetail['price_id'])); ?>
			<?php //echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
			<?php //echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
			<?php echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$merchant_id, 'type'=>'hidden')); ?>
			<?php echo $this->Form->input('order_id',array('value'=>rand(),'label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden')); ?>
                         <?php echo $this->Form->input('amount',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$amount)); ?>
                        <?php echo $this->Form->input('currency',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>'AED')); ?>
                        <?php
        		    $ret_funtion = 'payment';
                            echo $this->Form->input('redirect_url',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>Configure::read('BASE_URL').'/Spabreaks/'.$ret_funtion.'/'.$serviceDetails['Spabreak']['id'].'/'.$uid)); ?>
                        <?php echo $this->Form->input('cancel_url',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>Configure::read('BASE_URL').'/Spabreaks/'.$ret_funtion.'/'.$serviceDetails['Spabreak']['id'].'/'.$uid));
			
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
           <!-- <h2 class="fs-title" >Promo Code</h2>-->
          <div class="form-group">
                <section class="gender-input">
                    <?php
                      $options=array('gift'=>'Use promo/ gift card Code','points'=>'Use Points','card'=>'Pay with credit card');									      $attributes=array('legend'=>false,'separator'=>'</section><section class="gender-input">' ,'label'=>array('class'=>'new-chk'));
                      $attributes=array('legend'=>false,'separator'=>'</section><section class="gender-input">' ,'label'=>array('class'=>'new-chk'),'value'=>'card');
                      echo $this->Form->radio('UserDetail.gender',$options,$attributes);
                      ?>
                </section>
             <!--<div class="col-sm-4">
                    <?php  //echo $this->Form->input('gift_card',array('type'=>'checkbox','div'=>false,'label'=>array('class'=>'new-chk','text'=>'Use promo/ gift card Code'))); ?>
                </div>
                <div class="col-sm-3">
                     <?php  //echo $this->Form->input('points',array('type'=>'checkbox','div'=>false,'label'=>array('class'=>'new-chk','text'=>'Use Points'))); ?>
                </div> -->
            </div>
            <div class="row promo_div" style='display: none' >
               <div class="form-group">
                   <div class="col-sm-8">
                       <?php echo $this->Form->input('Point.promo_code',array('label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'Enter promo /  gift card code','id'=>'AppointmentPromoCode')); ?>
                       <?php echo $this->Form->input('customer_identifier',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
                   </div>
                   <div class="col-sm-4 no-pdng">
                       <?php echo $this->Form->button('Use Code',array('type'=>'button','label'=>false,'div'=>false,'class'=>'purple-btn promoCode pull-right','readonly'=>false)); ?>
                   </div>
               </div>
            </div>
        </div>

     <div class="col-sm-12" >
			    <div class="form-group">
			     <div class="pull-left">
				 <a style="display: none" class="cancel_gift gray-btn" href='javascript:void(0)'>Cancel</a></div>
				<div class="pull-right"><?php echo $this->Html->link('PAY' ,'javascript:void(0)',array('class'=>'purple-btn AppointmentCheckout')); ?></div>
				<?php //echo $this->Form->button('Pay',array('type'=>'submit','label'=>false,'div'=>false,'class'=>'purple-btn AppointmentCheckout pull-right')); ?>
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
	
	$ret_funtion = 'payment/'.$serviceDetails['Spabreak']['id'].'/'.$uid.'/payment';
      echo $this->form->input('form_action' ,array('type'=>'hidden','value'=>'/Spabreaks/'.$ret_funtion));
      $is_accept_siesasta = '';
      $is_accept_card = '';
      if(isset($ownerPolicy) && !empty($ownerPolicy)){
          $is_accept_siesasta = $ownerPolicy['PolicyDetail']['enable_sieasta_voucher'];
          $is_accept_card = $ownerPolicy['PolicyDetail']['enable_gfvocuher'];
      }
      echo $this->form->input('is_accept_sieasta_card' ,array('type'=>'hidden','value'=>$is_accept_siesasta));
      echo $this->form->input('is_accept_card' ,array('type'=>'hidden','value'=>$is_accept_card));
      echo $this->form->input('owner_salon_id' ,array('type'=>'hidden','value'=>$salon_id));
      echo $this->form->input('appointment_type' ,array('type'=>'hidden','value'=>$appointmentDetail['theBuktype']));
     echo $this->form->input('selected_quantity' ,array('type'=>'hidden','value'=>$appointmentDetail['selected_quantity']));
      
      
?>
<!--  Small Modal POPUP-->
<div class="modal fade" id="commonSmallModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>

<?php echo $this->element('frontend/Booking/commonpayment');?>