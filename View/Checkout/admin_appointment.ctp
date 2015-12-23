<script src="/js/kendo/kendo.timezones.js"></script>
<link href="/css/timepicker/jquery.timepicker.css" rel="stylesheet">
<script src="/js/timepicker/jquery.timepicker.js"></script>
<?php echo $this->Html->script('checkout/checkout'); ?>
<div class="">            
    <div class="row">
		<div class="col-sm-12">
            <div class="box">
                <div class="box-content nopadding">
					<?php echo $this->Form->create('cart',array('novalidate','type' => 'file','id'=>'checkoutForm')); ?>
                    <?php echo $this->Form->hidden('appointment_time',array('value' => $appointmentTime,'id'=>'aptmntTime'));?>
					<?php echo $this->Form->hidden('appointment_date',array('value' => $appointment_date));?>
						<?php
							$appointmentId = array();
							if(isset($userAppointments) && $userAppointments != ''){
							    foreach($userAppointments as $key => $userAppointment){
									$appointmentId[] = $userAppointment['Appointment']['id'];
							    }
							}
							$appointmentId = implode(',',$appointmentId);
						?>
					<div class="col-sm-12 nopadding">
						<div class="col-sm-12 nopadding">
						<!----Customers detail section------>
						    <div class='col-sm-9 service-detail-new'>
								<div class='col-sm-12 nopadding emp-gender-radio'>            	                      <div class='col-sm-3 lft-p-non'>
										<div class="form-group">
											<label for="additionalfield" class="lft-p-non col-sm-12 control-label"><?php echo __('' , true); ?> :</label>
											<div class='col-sm-12  nopadding'>
												<div class='col-sm-12 mrgn-btm10 nopadding'>
													<?php
														$options = array('1'=>'Today\'s customers','2'=>'Walk In','3'=>'Group Customers');
														$attributes=array('label'=>array('class'=>'new-chk getUserType'),'legend'=>false ,'default'=>1,'class' => "customer_type",'appointment_id' => base64_encode($appointmentData['Appointment']['id']),'separator'=> '</div><div class="col-sm-12 mrgn-btm10 nopadding">');
														echo $this->Form->radio('UserDetail.user_type',$options,$attributes);
													?>
												</div>
												<div class="radio_error"></div>    
											</div>
										</div>
									</div>
									<div class='col-sm-9 rgt-p-non'>
										<?php echo $this->element('checkout/appointment_customer_detail'); ?>
									</div>
									<div class="col-sm-12 nopadding table-responsive apptmtDetail">
										<?php echo $this->element('checkout/appointment_details');?>   
									</div>
									<?php 
										echo $this->element('checkout/common_appointment_checkout');	
									?>
								</div>
							</div>
							<!----Customers detail section (Ends Here)--->
							<!----Checkout side panel starts here----> 
							<div class="col-sm-3 nopadding">
								<div class="chk-out-box-new">
									<?php echo $this->element('checkout/checkout_detail');?>      
								</div>
							</div>
							<!----Checkout side panel ends here----->
						</div>
						<div class="col-sm-12 nopadding pdng-tp20 fixed-foots">
							<div class="col-sm-12 col-md-6" style="margin-bottom:10px;">
								<button type="button" class="btn btn-primary addAppointment" buttonName="service" employeeId="<?php echo $employeeId; ?>" ><i class="fa fa-plus"></i> Service</button>
								<button type="button" class="btn btn-primary addedit_giftCertificate"><i class="fa fa-plus"></i> Gift</button>
								<input type="text" value="" class="w130 addProductText">
								<button type="button" class="btn btn-primary addProduct"><i class="fa fa-plus"></i> Product</button>
							</div>
							<div class="col-sm-12 col-md-6">
								<?php echo $this->Form->input('email',array('div'=>array('class'=>'col-sm-3 setNewMarginC'),'class'=>'chk','type'=>'checkbox','label'=>array('class'=>'new-chk control-label','text'=>'Email Receipt'))); ?>
								<?php echo $this->Form->input('print',array('div'=>array('class'=>'col-sm-3 setNewMarginC'),'class'=>'chk','type'=>'checkbox','label'=>array('class'=>'new-chk control-label','text'=>'print Receipt'))); ?>
								<button type="button"  class="btn btn-primary cancel">Cancel</button>
								<button type="submit" id ="proceedCheckout" class="btn btn-primary" buttonName="checkout" appointmentId="<?php echo $appointmentId; ?>" ><i class="fa fa-plus"></i> Checkout</button>
							</div>
						</div>
					</div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>      
</div>
<style>
      .apptmtDetail {
    border-top: 1px solid #ddd;
    margin-top: 25px;
}
.fixed-foots{position: fixed; padding-bottom: 15px !important; border-top:1px solid #ddd; left: 0; bottom: 0; background: #fff;}
</style>