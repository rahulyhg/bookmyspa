<style>
.top_pad{
	margin-top:7%;
}

.content:before{
	content: "✔"; position: absolute;/* top: 2px; */left: 4px; color: #5b3671;
}
.content{
	padding-top:5px;
}
</style>

<div class="modal-dialog vendor-setting overwrite">
	<?php echo $this->Form->create('Spaday',array('admin'=>true,'novalidate','id'=>'Package','class'=>'form-vertical PackagePopForm'));?>
	
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h2 class="no-mrgn"><?php echo (isset($this->data))?'Edit':'Add';?> Spa Day </h2>
	    </div>
	    <div class="modal-body clearfix SalonEditpop">
            <div class="row">
            <div class="col-sm-12">
              <div style="height: 545px; overflow: auto;">
				    <div class="box">
					<div class="box-content">
						<?php echo $this->Form->hidden('Spaday.id',array('value'=>isset($spaday['Spaday']['id']) ? $spaday['Spaday']['id']:'','label'=>false,'div'=>false,'class'=>'package_class'));?>
						<div class="col-sm-12">
							<div class="box">
								<div class="box-title">
									<h3><i class="glyphicon-settings"></i>Spa Day Details</h3>
								</div>
								<div class="box-content">
									<ul class="tabs tabs-inline tabs-top">
										<li class='active'>
											<a href="#first11" data-toggle='tab'>English</a>
										</li>
										<li>
											<a href="#second22" data-toggle='tab'>Arabic</a>
										</li>
									</ul>
									<div class="tab-content lft-p-non rgt-p-non padding tab-content-inline tab-content-bottom ">
										<div class="tab-pane active" id="first11">
											<div class="col-sm-12 lft-p-non ">
												<div class="form-group">
													<label >Spa Day Name(English)*:</label>
													<?php echo $this->Form->input('Spaday.eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required'=>false)); ?>
												</div>
											</div>
											<div class="col-sm-12 lft-p-non">
												<div class="form-group">
												<label>Spa Day Description(English):</label>
												   <?php echo $this->Form->input('Spaday.eng_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required'=>false)); ?>
											   </div>
											</div>
                                                                                </div>
										<div class="tab-pane" id="second22">
											<div class="col-sm-12 lft-p-non ">
												<div class="form-group">
													<label class="">Spa Day Name(Arabic)*:</label>
													<?php echo $this->Form->input('Spaday.ara_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
												</div>
											</div>
											<div class="col-sm-12 lft-p-non">
												<div class="form-group">
                                       <label>Package Description(Arabic):</label>
													<?php echo $this->Form->input('Spaday.ara_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required'=>false)); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="box">
							
								<?php //get_salon_service_name
								  $content = '';
								  $addTreatmentLink = "";
								  $editTreatmentLink = "display:none";
								  $showServicesList = "display:none";
									if(!empty($spaday['PackageService'])){
										foreach($spaday['PackageService'] as $spadayService){
											$content.='<div class="col-sm-3 content">'.$this->Common->get_salon_service_name($spadayService["salon_service_id"]).'</div>';
										}
										$showServicesList="";
										$addTreatmentLink="display:none";
										$editTreatmentLink="";
									}
								
									?>
								<div class="box-title">
									<h3><i class="glyphicon-settings"></i>Spa Day Includes</h3><h3 class="editTreatmentsLink" style="<?php echo $editTreatmentLink;?>"><?php echo $this->Html->Link('(edit)','javascript:void(0)',array('title'=>'Edit Treatments','data-id'=>'','class'=>'addTreatments','escape'=>false)) ?></h3>
									
								</div>
								
								
								<div class="box-content addTreatmentLink" style="<?php echo $addTreatmentLink;?>">
										<div class="form-group">
											<div class="row ">
												<div class="col-sm-12">
													<?php echo $this->Html->Link('Add Treatments','javascript:void(0)',array('title'=>'Add Treatments','data-id'=>'','class'=>'btn btn-primary addTreatments','escape'=>false)) ?></php>
												</div>
											</div>
										</div>
								</div>
								
								<div class="box-content showServicesList" style="<?php echo $showServicesList;?>">
										
									<div class="col-sm-12 ">
									 	<?php echo $content;?>
									</div>
								</div>
					</div>		
				  </div>
						</div>
                                                <div class="col-sm-12">
							<div class="box">
								<div class="box-title">
									<h3><i class="glyphicon-settings"></i>Pricing Options</h3>
									<span class="pull-right clearfix"></br><?php echo $this->Form->input('Package.inventory',array('type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp;&nbsp;Limit Inventory'),'div'=>false,'class'=>'form-control')); ?></span>
								</div>
								<div class="box-content tab-content" id="pricingOptionValues">
										<?php echo $this->element('admin/SalonServices/spaday_pricing_option_table'); ?>
								
                                                                </div>
								<div class="box-content">
										<div class="form-group">
											<div class="row ">
												<div class="col-sm-12">
													<?php echo $this->Html->Link('Pricing for other weekdays','javascript:void(0)',array('title'=>'Add Another Pricing Level','data-id'=>'','class'=>'add_anotherpricing','escape'=>false)) ?></php>
												</div>
											</div>
										</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="box">
								<div class="box-title">
									<h3><i class="glyphicon-settings"></i>How would you like to sell this Service?</h3>
								</div>
								<div class="box-content sell-service">
									<div class="form-group ">
										
											   <label>Listed Online:</label>
											   <section>
											   <div class="col-sm-4 lft-p-non">
											<?php
											$default = isset($spaday['SalonServiceDetail']['listed_online']) ? $spaday['SalonServiceDetail']['listed_online']:0;
											echo $this->Form->input('SalonServiceDetail.listed_online', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control full-w', 'options' => $this->common->get_listedonline_options(), 'default'=>$default)); ?>
											</div>
											<?php
											$from=$to=$range = "display:none";
									if(in_array($default,(array(1,2,3)))){
													if(in_array($default,(array(1,3)))){
													 $from="display:block";
													}if(in_array($default,(array(3,2)))){
													 $to="display:block";
													}
													if($default==3){
													 $range="display:block";
													}
												}
											?>
											<div class="col-sm-8">
												<div class="date" style="<?php echo $from;?>" id="fromOnline">
												  
												   <?php echo $this->Form->input('SalonServiceDetail.id', array('type' => 'hidden', 'label' => false)); ?>
														<?php echo $this->Form->input('SalonServiceDetail.listed_online_start', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'datepicker')); ?>
												</div>
												<div class="to" style="<?php echo $range;?>">
													to
												</div>
												<div class="date" style="<?php echo $to;?>" id="toOnline">
												   
														<?php echo $this->Form->input('SalonServiceDetail.listed_online_end', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'datepicker')); ?>
												</div>
											</div>
											</section>
										
									</div>
									<!--<div class="form-group">
										
											
												<label>Offer Available:</label>
												<section>
												<?php
												$displayofferDays='';
												$offerDay =  isset($spaday['SalonServiceDetail']['offer_available']) ? $spaday['SalonServiceDetail']['offer_available']:0;
												if($offerDay==0){
													$displayofferDays ='display:none';
												}
												echo $this->Form->input('SalonServiceDetail.offer_available', array('type' => 'select', 'default'=>$offerDay,'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_offerdays_options())); ?>
											
											<div class="clear"></div>
											<div id="weekDays" style="<?php echo $displayofferDays;?>" class="week-days">
												
												<div class="col-sm-1">
													<?php echo $this->Form->input('SpadayPricingOption.sun', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control')); ?>
												</div>
												<div class="col-sm-1 ">
													<?php echo $this->Form->input('SpadayPricingOption.mon', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'M'), 'div' => false, 'class' => 'form-control')); ?>
												</div>
												<div class="col-sm-1 ">
													<?php echo $this->Form->input('SpadayPricingOption.tue', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'T'), 'div' => false, 'class' => 'form-control')); ?>
												</div>
												<div class="col-sm-1">
													<?php echo $this->Form->input('SpadayPricingOption.wed', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'W'), 'div' => false, 'class' => 'form-control')); ?>
												</div>
												<div class="col-sm-1">
													<?php echo $this->Form->input('SpadayPricingOption.thr', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'T'), 'div' => false, 'class' => 'form-control')); ?>
												</div>
												<div class="col-sm-1">
													<?php echo $this->Form->input('SpadayPricingOption.fri', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'F'), 'div' => false, 'class' => 'form-control')); ?>
												</div>
												<div class="col-sm-1 ">
													<?php echo $this->Form->input('SpadayPricingOption.sat', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control')); ?>
												</div>
											</div>
										</section>
										
									</div>-->
									<div class="form-group">
										
												<label>Display Price:</label>
												<section>
												<?php echo $this->Form->input('Spaday.display_price', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_soldas_options())); ?>
												</section>
									</div>
									<div class="form-group">
										
												<label>Appointment Lead Time:</label>
												<section>
													<?php echo $this->Form->input('SalonServiceDetail.appointment_lead_time', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_leadtime_options())); ?>
												</section>
									</div>
									<div class="form-group ">
										
											<?php
											   $voucherExpire='';
												$offerDay =  isset($spaday['SalonServiceDetail']['evoucher_expire']) ? $spaday['SalonServiceDetail']['evoucher_expire']:0;
												if($offerDay==0){
													$voucherExpire ='display:none';
												}
												?>
												<label>eVoucher expire:</label>
												<section>
												<?php echo $this->Form->input('SalonServiceDetail.evoucher_expire', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_evoucherexpire_options())); ?>
											
											
											<div class="after-select expireAfter " style="<?php echo $voucherExpire; ?>">
												<?php echo $this->Form->input('SalonServiceDetail.evoucher_expire_after', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_expireafter_options())); ?>
											</div>
										</section>
									</div>
									<div class="form-group ">
										
												<label>Restrictions:</label>
												<section>
													<?php echo $this->Form->input('Package.restriction', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
												</section>
									</div>
									<div class="form-group ">
													
												<label>Good to Know:</label>
												<section>
												<?php echo $this->Form->input('Package.good_to_know', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
												</section>
												
									</div>
									<div class="form-group taxation-box">
										<div class="col-sm-3 lft-p-non">
												<label>Taxation:</label>
												<?php
												$default =  isset($spaday['Package']['tax_id']) ? $spaday['Package']['tax_id']:'';
												echo $this->Form->input('tax_id', array('type' => 'select', 'label' => false, 'div' => false, 'options' => $this->common->tax_options($auth_user['User']['id']), 'class' => 'form-control')); ?>
										</div>
											<div class="col-sm-3 lft-p-non">
												<label>Deduction:</label>
												<?php
												$default1 =  isset($spaday['Package']['deduction_id']) ? $spaday['Package']['deduction_id']:'';
												echo $this->Form->input('deduction_id', array('type' => 'select', 'label' => false, 'div' => false, 'options' => $this->common->deduction_options($auth_user['User']['id']), 'class' => 'form-control')); ?>
											</div>
											<div class="col-sm-3 lft-p-non">
												<label>Cost to Business</label>
												<?php echo $this->Form->input('Package.cost_to_business', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control')); ?>
											</div>
											<div class="col-sm-3 nopadding">
											<label>Outcall Service:</label>
											   <div class="col-sm-12 top_pad">
														<?php echo $this->Form->input('Package.outcall_service', array('type' => 'checkbox', 'label' =>  array('class'=>'new-chk','text'=>'&nbsp;'), 'div' => false, 'class' => 'form-control')); ?>
														
												</div>
											</div>
										
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="box">
								<div class="box-title">
									<h3><i class="glyphicon-settings"></i>Add Service Provider </h3>
								</div>
								<div class="box-content">
									<div class="form-group col-sm-12 lft-p-non">
									    <table class="table table-hover table-nomargin dataTable table-bordered">
											<thead>
												<tr>
													<th>Powered By</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
											<?php
											
											//$SalonStaff = $this->Common->get_salon_staff($auth_user['User']['id']);
											//pr(array_flip($SalonStaff));
											//pr($spaday['SalonStaffService']);
											//exit;
											$matchArray=array();
											$statusArray=array();
											if(isset($spaday['SalonStaffPackage']) && !empty($spaday['SalonStaffPackage'])){
												foreach($spaday['SalonStaffPackage'] as $key=>$salonStaff){
													$matchArray[$salonStaff['staff_id']] = $salonStaff['id'];
													$statusArray[$salonStaff['staff_id']] = $salonStaff['status']; 
												 }
											}
											
											// FOr Acount Owner
											  if(in_array($auth_user['User']['id'],array_flip($matchArray))){
                                        echo '<tr>';
                                        echo '<td>'.$this->Common->get_user_name($auth_user['User']['id']).'</td>';
                                        echo $this->Form->hidden('SalonStaffPackage.0.id',array('class'=>'','label'=>false,'div'=>false,'value'=>$matchArray[$auth_user['User']['id']]));
                                        //echo $this->Form->hidden('SalonStaffService.'.$key.'.id',array('class'=>'','label'=>false,'div'=>false,'value'=>$salonservice['SalonService']['id']));
                                        $active_status = ($statusArray[$auth_user['User']['id']]==1)?true:false;
                                        echo '<td>'. $this->Form->input('SalonStaffPackage.0.status' , array('checked'=>$active_status,'data-active-id'=>$matchArray[$auth_user['User']['id']],'class'=>'custom_switch serviceStaffStatus','hiddenField'=>true,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')).'</td>';
                                        echo '</tr>';
                                }else{
                                        echo '<tr>';
                                        echo '<td>'.$this->Common->get_user_name($auth_user['User']['id']).'</td>';
                                        echo $this->Form->hidden('SalonStaffPackage.0.staff_id',array('class'=>'','label'=>false,'div'=>false,'value'=>$auth_user['User']['id']));
                                        echo $this->Form->hidden('SalonStaffPackage.0.salon_service_id',array('class'=>'','label'=>false,'div'=>false,'value'=>isset($spaday['Package']['id']) ? $spaday['Package']['id'] :'' ));
                                        //echo $this->Form->hidden('SalonStaffService.'.$key.'.id',array('class'=>'','label'=>false,'div'=>false,'value'=>$salonservice['SalonService']['id']));
                                        //$active_status = ($salonStaff['status'])?true:false;
                                        echo '<td>'. $this->Form->input('SalonStaffService.0.status' , array('checked'=>false,'data-active-id'=>0,'class'=>'custom_switch serviceStaffStatus','hiddenField'=>true,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')).'</td>';
                                        echo '</tr>';
                                }
										  //For Staff
											if(isset($SalonStaff) && !empty($SalonStaff)){
												 foreach($SalonStaff as $key=>$staff){
													$key=$key+1;
													if(in_array($staff['User']['id'],array_flip($matchArray))){
														echo '<tr>';
														echo '<td>'.$this->Common->get_user_name($staff['User']['id']).'</td>';
														echo $this->Form->hidden('SalonStaffPackage.'.$key.'.id',array('class'=>'','label'=>false,'div'=>false,'value'=>$matchArray[$staff['User']['id']]));
														//echo $this->Form->hidden('SalonStaffService.'.$key.'.id',array('class'=>'','label'=>false,'div'=>false,'value'=>$spaday['SalonService']['id']));
														$active_status = ($statusArray[$staff['User']['id']]==1)?true:false;
														echo '<td>'. $this->Form->input('SalonStaffPackage.'.$key.'.status' , array('checked'=>$active_status,'data-active-id'=>$matchArray[$staff['User']['id']],'class'=>'custom_switch serviceStaffStatus','hiddenField'=>true,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')).'</td>';
														echo '</tr>';
													}else{
														echo '<tr>';
														echo '<td>'.$this->Common->get_user_name($staff['User']['id']).'</td>';
														echo $this->Form->hidden('SalonStaffPackage.'.$key.'.staff_id',array('class'=>'','label'=>false,'div'=>false,'value'=>$staff['User']['id']));
														echo $this->Form->hidden('SalonStaffPackage.'.$key.'.package_id',array('class'=>'','label'=>false,'div'=>false,'value'=>isset($spaday['Package']['id']) ? $spaday['Package']['id'] :'' ));
														//echo $this->Form->hidden('SalonStaffService.'.$key.'.id',array('class'=>'','label'=>false,'div'=>false,'value'=>$spaday['SalonService']['id']));
														//$active_status = ($salonStaff['status'])?true:false;
														echo '<td>'. $this->Form->input('SalonStaffPackage.'.$key.'.status' , array('checked'=>false,'data-active-id'=>0,'class'=>'custom_switch serviceStaffStatus','hiddenField'=>true,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')).'</td>';
														echo '</tr>';
													}
												 }
											}
												// pr($matchArray);
											 ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
             
          
            
			</div>
        </div>
    
		<div class="modal-footer">
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitPackage','label'=>false,'div'=>false));?>
                                    <?php echo $this->Form->button('Cancel',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'class'=>'btn' , 'data-dismiss'=>"modal")); ?>
                                    
			
        </div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script>
	Custom.init();
	
	$(document).ready(function(){
			$(".serviceStaffStatus").bootstrapSwitch();
			$(".datepicker").datepicker({ 'format': "yyyy-mm-dd"});
			
			$("#SalonServiceDetailListedOnline").on('change',function(){
					var value = $(this).val();
					$("#fromOnline").hide();
					$("#toOnline").hide();
					$(".to").hide();
					var Range = ["1","2","3"];
					var to = ["2","3"];
					var from = ["1","3"];
					if (Range.indexOf(value) !== -1){
						if (to.indexOf(value) !== -1){
							$("#toOnline").show();
						}
						if (from.indexOf(value) !== -1){
							$("#fromOnline").show();
						}
						if(value==3){
							$(".to").show();
						}
					}
				
				
			})
			
			
		$("#SalonServiceDetailOfferAvailable").on('change',function(){
			var value = $(this).val();
			if(value == 1){
				$("#weekDays").show();
			}else{
				$("#weekDays").hide();
			}
		})
		
		$("#SalonServiceDetailEvoucherExpire").on('change',function(){
			var value = $(this).val();
			if(value == 1){
				$(".expireAfter").show();
			}else{
				$(".expireAfter").hide();
			}
		})	

			
	})
</script>

            
