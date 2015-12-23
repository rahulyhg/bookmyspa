<div class="row">
    <div class="col-sm-12">
         <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                   <i class="icon-table"></i>
                   Payment Detail
                </h3>
                <?php
                 $model = 'EmailSubscriptionPlan';
               
                 //echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_blog pull-right'));?>
            </div>
        
            <div class="box-content">
               <div class="wrapper">
    <div class="container">
    <div class="fixed-rgt appBukrgt">
	<div class="deal-banner-rgt">
            <p><span>
		<?php
                            //$amount = $Plan[$model]['price'];
                            echo 'Total Price : '; 
			    echo __('AED',true);
			    echo '<span class="orginal_price">';
			    echo $amount;
			    echo '</span>';
			    echo '</div>';   
		?>
		<!--<div class="price">
                  ADE 20
                  <div class="off-outer"><div class="off"></div>20% Off</div>
              </div>-->
	    <div class="price service-name">
		 <?php echo $Plan[$model]['title'];  ?>
	    </div>
	    <div class="info-details">
		<h5>
                        <i class="fa fa-location-arrow"></i>
                <?php   $plan_type = $Plan[$model]['plan_type'];
                        if($plan_type=='M'){
                          $plan_type_val = '1 month';
                        }else if($plan_type=='BA'){
                           $plan_type_val = '6 month';
                        }else{
                          $plan_type_val = '1 Year';
                        }
                     echo "Validity $plan_type_val";      
                ?>
              </h5>		
	    </div>
	   
              <div class="duration bod-tp-non">
                  <h5><?php echo __('Duration',true); ?></h5>
               <div class="time"><i class="fa fa-clock-o"></i>
               <?php  echo "$plan_type_val";      
                ?>
	    </div>
              </div>
	  
	       <div class="duration bod-tp-non">
		    <h5><?php echo __('Discount',true); ?></h5>
		    <i class="fa fa-money"></i>&nbsp;
		    <span class="user_point" ><?php echo $Plan['EmailSubscriptionPlan']['discount']; ?>%</span>
               </div>
		<div class="duration bod-tp-non">
		      <h5> <?php  echo __("No. Of Emails",true); ?> </h5>
		     <div class="time">
			<i class="fa fa-file-powerpoint-o"></i>&nbsp;
			    <span class="redeem_points" >
				<?php   echo ($Plan[$model]['customer_type']==0)?$Plan[$model]['no_of_emails'].' Emails':'Unlimited Emails'; ?>
			    </span>
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
                     $lang = Configure::read('Config.language');
                     $merchant_id = Configure::read('merchant_id');
                    $uid = (isset($auth_user['User']['id']))?$auth_user['User']['id']:'';
			echo $this->Form->create('MarketingOrder',array('url'=>array('controller'=>'Marketing','action'=>'payment'))); 	
		    ?>
                        <?php echo $this->Form->input('plan_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$Plan[$model]['id'])); ?>
			<?php echo $this->Form->input('price_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$Plan[$model]['id'])); ?>
			<?php //echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
			<?php //echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;')); ?>
			<?php echo $this->Form->input('merchant_id',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$merchant_id, 'type'=>'hidden')); ?>
			<?php echo $this->Form->input('order_id',array('value'=>$this->Common->getRandPass(),'label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden')); ?>
                        <?php echo $this->Form->input('amount',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>$amount)); ?>
                        <?php echo $this->Form->input('currency',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden','value'=>'AED')); ?>
                        <?php echo $this->Form->input('redirect_url',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>Configure::read('BASE_URL').'admin/Marketing/'.$Plan[$model]['id'])); ?>
                        <?php echo $this->Form->input('cancel_url',array('label'=>false,'div'=>false,'class'=>'form-control','style'=>'display:none;','value'=>Configure::read('BASE_URL').'admin/Marketing/'.$Plan[$model]['id']));
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
				
 </div>
                        </div>
			</div>
     <div class="col-sm-12" >
            <div class="form-group">
                    <div class="pull-left">
                       <a style="display: none" class="cancel_gift gray-btn" href='javascript:void(0)'>Cancel</a>
                    </div>
                   <div class="pull-right pay_hide_show">
                       <?php echo $this->Form->button('PAY' ,array('class'=>'purple-btn AppointmentCheckout')); ?>
                   </div>
            </div>
    </div>
                    <?php echo $this->Form->end(); ?>
     </div>
            </div>

        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>