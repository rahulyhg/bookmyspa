<style>
.top_pad{
	margin-top:7%;
}
.top3Pad{
	margin-top:3%;
}
.ui-datepicker-trigger{
    position: absolute;
    right: 3px;
    top: 7px;
}
.red{
    color: red;
}
</style>
<?php
	echo $this->Html->script('admin/jquery.timepicker');
	echo $this->Html->css('admin/jquery.timepicker'); 
?>

<div class="modal-dialog vendor-setting sm-vendor-setting">
	<?php echo $this->Form->create('Package',array('admin'=>true,'novalidate','id'=>'Package','class'=>'form-vertical PackagePopForm'));?>
	
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h2 class="no-mrgn"><?php echo $Type;?> <?php echo $pkgType; ?></h2>
	    </div>
	    <div class="modal-body clearfix SalonEditpop">
            <div class="row">
            <div class="col-sm-12">
              <div class="scrollError" style="height: 545px; overflow: auto;">
				    <div class="box">
					<div class="box-content no-mrgn">
						<?php echo $this->Form->hidden('Package.id',array('value'=>isset($package['Package']['id']) ? $package['Package']['id']:'','label'=>false,'div'=>false,'class'=>'package_class'));?>
						<?php echo $this->Form->hidden('Package.type',array('value'=>$pkgType,'label'=>false,'div'=>false)); ?>
						<div class="col-sm-12 nopadding">
							<div class="box">
								<div class="box-title">
									<h3 class="mrgn-tp0"><i class="glyphicon-settings"></i><?php echo $pkgType; ?> Details</h3>
								</div>
								<div class="box-content nopadding">
									<div class="col-sm-3 lft-p-non">
									<ul class="tiles pkg-img tiles-center nomargin ">
										<li class="lightgrey empty">
											<?php if(isset($this->data['Package']['image']) && !empty($this->data['Package']['image'])){ ?>
											<img alt="" class="" src="/images/Service/150/<?php echo $this->data['Package']['image']; ?>" data-img="<?php echo $this->data['Package']['image']; ?>">
											<div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="addPkgImage"><i class="fa fa-pencil"></i></a></div></div>
											<?php echo $this->Form->hidden('Package.image',array('label'=>false,'div'=>false,'required','validationMessage'=>"Image is required.",'value'=>$this->data['Package']['image']));
											$add = false;
											}else{ ?>
											<a href="javascript:void(0);" class="addPkgImage theChk"><span><i class="fa fa-plus"></i></span></a>
											<?php echo $this->Form->hidden('Package.image',array('label'=>false,'div'=>false,'required','validationMessage'=>"Image is required."));
											$add = true;
											} ?>
											
										</li>
										<?php if($add){
											echo "</br><i>( Select primary image )</i>";
										}else{
											echo "</br><i>( Change primary image )</i>";
										}
										?>
									</ul>
									</div>
									<div class="col-sm-9 rgt-p-non">
									<ul class="tabs tabs-inline tabs-top">
										<li class='active'>
											<a href="#first11" data-toggle='tab'>English</a>
										</li>
										<li>
											<a href="#second22" data-toggle='tab'>Arabic</a>
										</li>
									</ul>
									<div class="tab-content  tab-content-inline tab-content-bottom ">
										<div class="tab-pane active" id="first11">
											<div class="col-sm-12 nopadding ">
												<div class="form-group">
													<label><?php echo $pkgType; ?> Name*:</label>
													<?php echo $this->Form->input('Package.eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required','minlength'=>'3','pattern'=>'^[A-Za-z ]+$','validationMessage'=>$pkgType." name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-pattern-msg'=>"Please enter only alphabets.",'maxlengthcustom'=>'50','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
												</div>
											</div>
											<div class="col-sm-12 nopadding">
												<div class="form-group">
												<label><?php echo $pkgType; ?> Description*:</label>
												   <?php echo $this->Form->input('Package.eng_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required','validationMessage'=>"Description is required.")); ?>
											   </div>
											</div>
                                                                                </div>
										<div class="tab-pane" id="second22">
											<div class="col-sm-12 nopadding">
												<div class="form-group">
													<label class=""><?php echo $pkgType; ?> Name :</label>
													<?php echo $this->Form->input('Package.ara_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
												</div>
											</div>
											<div class="col-sm-12  nopadding">
												<div class="form-group">
                                       <label><?php echo $pkgType; ?> Description :</label>
													<?php echo $this->Form->input('Package.ara_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required'=>false)); ?>
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12  nopadding">
							<div class="box">
							
								<?php //get_salon_service_name
									$content = '';
									$addTreatmentLink = "";
									$editTreatmentLink = "display:none";
									$showServicesList = "display:none";
									if(!empty($package['PackageService'])){
										foreach($package['PackageService'] as $packageService){
											$content.='<div class="col-sm-6 lft-p-non"><i class="fa fa-check"></i>'.$this->Common->get_salon_service_name($packageService["salon_service_id"]).'</div>';
										}
										$showServicesList="";
										$addTreatmentLink="display:none";
										$editTreatmentLink="";
									}
								
								?>
								<div class="box-title">
									<h3><i class="glyphicon-settings"></i><?php echo $pkgType; ?> Includes<label>*:</label></h3><h3 class="editTreatmentsLink pull-right" style="<?php echo $editTreatmentLink;?>"><?php echo $this->Html->Link('<i class="fa fa-pencil"></i>','javascript:void(0)',array('title'=>'Edit Treatments','data-id'=>'','class'=>'addTreatments','escape'=>false)) ?></h3>
									<h3  class="pull-right addTreatmentLink" style="<?php echo $addTreatmentLink;?>"><?php echo $this->Html->Link('Add Treatments','javascript:void(0)',array('title'=>'Add Treatments','data-id'=>'','class'=>'btn btn-primary addTreatments pull-right','escape'=>false)) ?></h3>
								</div>
								<div class="box-content showServicesList">
										
									<div class="col-sm-12 nopadding">
										<?php
											if(!empty($content)){
												echo $content;	
											}else{
												echo 'No treatments added.';
												echo $this->Form->input('addtreatment',array('type'=>'hidden','required','validationmessage'=>'</br>Please add treatments.'));
											}
										?>
									
									</div>
								</div>
					</div>		
				  </div>
						</div>
                     <div class="col-sm-12">
							<div class="box">
								<div class="box-title">
									<h3 class="mrgn-tp0"><i class="glyphicon-settings"></i>Pricing Options<label>*:</label></h3>
								</div>
								<div class="box-content nopadding" id="pricingOptionTablePackage">
										<?php echo $this->element('admin/SalonServices/package_pricing_option_table'); ?>
								</div>
								<?php if($Type == 'Edit'){
									echo $this->Html->Link('Make a deal','javascript:void(0)',array('title'=>'Make a deal','data-id'=>'','class'=>'create_pkgdeal pull-right','escape'=>false));
								} ?>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="box">
								<div class="box-title">
									<h3><i class="glyphicon-settings"></i>How would you like to sell this <?php echo $pkgType; ?> ?</h3>
								</div>
								  <div class="box-content sell-service">
                <div class="form-group ">
                        
                                   <label>Listed Online:</label>
                                   <section>
                                     <?php echo $this->Form->input('SalonServiceDetail.id', array('type' => 'hidden', 'label' => false)); ?>
                                <?php
                                $default = isset($package['SalonServiceDetail']['listed_online']) ? $package['SalonServiceDetail']['listed_online']:0;
                                echo $this->Form->input('SalonServiceDetail.listed_online', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control ', 'options' => $this->common->get_listedonline_options(), 'default'=>$default)); ?>
                                
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
                                <div class="col-sm-12 top3Pad nopadding ajaxLoadC">
                                        <div class="date" style="<?php echo $from;?>" id="fromOnline">
                                          
                                        
                                                        <?php echo $this->Form->input('SalonServiceDetail.listed_online_start', array('type' => 'text','validationmessage'=>'Valid start date is required.','data-type'=>'date', 'label' => false, 'div' => false, 'class' => 'datepicker')); ?>
                                        </div>
                                        <div class="to" style="<?php echo $range;?>" >
                                                 &nbsp;to
                                        </div>
                                        <div class="date" style="<?php echo $to;?>" id="toOnline">
                                           
                                                        <?php echo $this->Form->input('SalonServiceDetail.listed_online_end', array('type' => 'text','data-type'=>'date', 'label' => false, 'div' => false, 'class' => 'datepicker','validationmessage'=>'Valid end date is required.','data-greaterdate-field'=>"data[SalonServiceDetail][listed_online_start]", 'data-greaterdate-msg'=>'End date should be greater than start date.' )); ?> 
                                        </div>
                                </div>
                                </section>
                        
                </div>
                <div class="form-group">
                        
                                
                                        <label>Offer Available:</label>
                                        <section>
                                        <?php
                                        $displayofferDays='';
                                        $offerDay =  isset($package['SalonServiceDetail']['offer_available']) ? $package['SalonServiceDetail']['offer_available']:0;
                                        if($offerDay==0){
                                                $displayofferDays ='display:none';
                                        }
                                        echo $this->Form->input('SalonServiceDetail.offer_available', array('type' => 'select', 'default'=>$offerDay,'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_offerdays_options())); ?>
                                
                                <div class="clear"></div>
                                <div id="weekDays" style="<?php echo $displayofferDays;?>" class="week-days pdng-tp7">
                                        
                                        <div class="col-sm-1">
                                                <?php echo $this->Form->input('SalonServiceDetail.offer_available_weekdays.sun', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1 ">
                                                <?php echo $this->Form->input('SalonServiceDetail.offer_available_weekdays.mon', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'M'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1 ">
                                                <?php echo $this->Form->input('SalonServiceDetail.offer_available_weekdays.tue', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'T'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1">
                                                <?php echo $this->Form->input('SalonServiceDetail.offer_available_weekdays.wed', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'W'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1">
                                                <?php echo $this->Form->input('SalonServiceDetail.offer_available_weekdays.thu', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'T'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1">
                                                <?php echo $this->Form->input('SalonServiceDetail.offer_available_weekdays.fri', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'F'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1 ">
                                                <?php echo $this->Form->input('SalonServiceDetail.offer_available_weekdays.sat', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                </div>
										  <input type="hidden" id="weekdayCheckRequired" name="weekdayCheckRequired"   validationmessage="Please select atleast one day." >
								<dfn class="text-danger k-invalid-msg" data-for="weekdayCheckRequired" role="alert" style="display: none;">Please select atleast one day.</dfn>
                        </section>
                        
                </div>
			
		<?php if($pkgType == 'Spaday'){ ?>
		<div class="form-group">
			<label>Check In</label>
			<div class="col-sm-9 pdng0">
			<?php
			 $checkInOut = $this->Common->get_defaultCheckIn($auth_user['User']['id']);
			 $defaultCheckIn = '';
			 if(isset($checkInOut['PolicyDetail']['arrival_time']) && !empty($checkInOut['PolicyDetail']['arrival_time'])){
				$defaultCheckIn = $checkInOut['PolicyDetail']['arrival_time'];
			 }
			 $defaultCheckOut = '';
			 if(isset($checkInOut['PolicyDetail']['departure_time']) && !empty($checkInOut['PolicyDetail']['departure_time'])){
				$defaultCheckOut = $checkInOut['PolicyDetail']['departure_time'];
			 }
			$check_from = (isset($this->data['Package']['check_in']) && $this->data['Package']['check_in'])?$this->data['Package']['check_in']:$defaultCheckIn; ?>
			<?php echo $this->Form->input('Package.check_in',array('value'=>$check_from,'label'=>false,'div'=>false,'class'=>'w60 form-control timeStart timePKr')); ?>
			</div>
		</div>
		<div class="form-group">
			<label>Check Out</label>
			<div class="col-sm-9 pdng0">
                        <?php $check_to = (isset($this->data['Package']['check_out']) && $this->data['Package']['check_out'])?$this->data['Package']['check_out']:$defaultCheckOut; ?>
                        <?php echo $this->Form->input('Package.check_out',array('value'=>$check_to,'label'=>false,'div'=>false,'class'=>'w60 form-control timeEnd timePKr')); ?>
			</div>
                </div>
		<?php } ?>
		
		
                <div class="form-group">
				
				 <?php
				 
				 $default = isset($package['SalonServiceDetail']['sold_as']) ? $package['SalonServiceDetail']['sold_as']:0;
				 
                                $leadTime=$evoucherExpire= "display:none";
										  if(in_array($default,(array(0,1,2)))){
                                                if(in_array($default,(array(0,1)))){
                                                 $leadTime="display:block";
                                                }if(in_array($default,(array(0,2)))){
                                                 $evoucherExpire="display:block";
                                                }
                                               
                                        }
                                ?>
                        
                                        <label>Sold As:</label>
                                        <section>
                                        <?php echo $this->Form->input('SalonServiceDetail.sold_as', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_soldas_options())); ?>
                                        </section>
                </div>
                <div class="form-group appLeadTime" style="<?php echo $leadTime;?>">
                        
                                        <label>Appointment Lead Time:</label>
                                        <section>
						<?php if($pkgType == 'Spaday'){
							$options = $this->common->get_days();
						}else{
							$options =  $this->common->get_leadtime_options();
						}
						?>
						<?php if($this->request->data['SalonServiceDetail']['appointment_lead_time'] ==''){
							$this->request->data['SalonServiceDetail']['appointment_lead_time'] = $defaultLeadtime;	
						}?>
                                                <?php echo $this->Form->input('SalonServiceDetail.appointment_lead_time', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $options)); ?>
                                        </section>
                </div>
                <div class="form-group evoucherExpire" style="<?php echo $evoucherExpire;?>">
                        
                                <?php
										$voucherExpire='';
                                        $offerDay =  isset($package['SalonServiceDetail']['evoucher_expire']) ? $package['SalonServiceDetail']['evoucher_expire']:0;
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
                        
                                        <label>Restrictions</br><i>(English)</i></label>
                                        <section>
                                                <?php echo $this->Form->input('Package.eng_restriction', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                        </section>
                </div>
					 <div class="form-group ">
                        
                                        <label>Restrictions</br><i>(Arabic)</i></label>
                                        <section>
                                                <?php echo $this->Form->input('Package.ara_restriction', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                        </section>
                </div>
                <div class="form-group ">
                                                
                                        <label>Good to Know</br><i>(English)</i></label>
                                        <section>
                                        <?php echo $this->Form->input('Package.eng_good_to_know', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                        </section>
                                        
                </div>
					  <div class="form-group ">
                                                
                                        <label>Good to Know</br><i>(Arabic)</i></label>
                                        <section>
                                        <?php echo $this->Form->input('Package.ara_good_to_know', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                        </section>
                                        
                </div>
                <div class="form-group taxation-box">
                        <!--<div class="col-sm-3 lft-p-non">-->
                                        <!--<label>Taxation:</label>-->
                                        <?php
                                        //$default =  isset($package['Package']['tax_id']) ? $package['Package']['tax_id']:'';
                                        //echo $this->Form->input('tax_id', array('type' => 'select', 'label' => false, 'div' => false, 'options' => $this->common->tax_options($auth_user['User']['id']), 'class' => 'form-control')); ?>
                        <!--</div>-->
                                <!--<div class="col-sm-3 lft-p-non">-->
                                        <!--<label>Deduction:</label>-->
                                        <?php
                                        //$default1 =  isset($package['Package']['deduction_id']) ? $package['Package']['deduction_id']:'';
                                        //echo $this->Form->input('deduction_id', array('type' => 'select', 'label' => false, 'div' => false, 'options' => $this->common->deduction_options($auth_user['User']['id']), 'class' => 'form-control')); ?>
                                <!--</div>-->
                                <div class="col-sm-3 lft-p-non">
                                        <label>Business Cost</label>
                                        <?php echo $this->Form->input('Package.cost_to_business', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control','maxlengthcustom'=>'3','data-maxlengthcustom-msg'=>"Maximum 3 numbers are allowed.",'required'=>false,'pattern'=>"\d+",'data-pattern-msg'=>'Please enter the valid numeric value.')); ?>
                                </div>
                                <!--<div class="col-sm-3 nopadding">
                                <label>Outcall Service:</label>
                                   <div class="col-sm-12 top_pad">
                                                        <?php echo $this->Form->input('Package.outcall_service', array('type' => 'checkbox', 'label' =>  array('class'=>'new-chk','text'=>'&nbsp;'), 'div' => false, 'class' => 'form-control')); ?>
                                                        
                                        </div>
                                </div>-->
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
             
          
            
			</div>
        </div>
    
		<div class="modal-footer pdng20">
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
		 
		$("#Package").on('change',".optionDuration",function(){
			callforValidtion("Package");
			var durationID  = $(this).attr('id');
			var durationVAL = $(this).val();
			var priceID 	 = durationID+"_price";
			var keys = durationID.split("_");
			var totalRow = $("#totalrow").val();
			var totalduration	=	0;
			var total = 0;
			var selCount =0 ;
			for (i = 0; i < totalRow; i++) {
					parseFloat($("#"+i+'_'+keys[1]).val())
					if(!isNaN(parseFloat($("#"+i+'_'+keys[1]).val()))){
						totalduration = parseFloat($("#"+i+'_'+keys[1]).val()) + totalduration;
						if(parseFloat($("#"+i+'_'+keys[1]).val()) !=0 ){
							selCount = selCount+1;
						}
					}
					parseFloat($("#"+i+'_'+keys[1]+'_price').val())
					if(!isNaN(parseFloat($("#"+i+'_'+keys[1]+'_price').val()))){
						total = parseFloat($("#"+i+'_'+keys[1]+'_price').val()) + total;
					}
				//	$(totalSelcount_)
				}
				
			$("."+'_'+keys[1]+'_optionprice').val(total);
			$("."+'_'+keys[1]+'_optionduration').val(totalduration);
			$("#totalSelcount_"+keys[1]).val('');
			
			if (selCount > 1) {
				$("#totalSelcount_"+keys[1]).val(1);
			}
			
			if(durationVAL == 0){
				$("#"+priceID).attr("required",false);
				$("#"+priceID).removeClass("k-invalid");
				$("#"+priceID).parent().find('dfn').remove();
				$("#"+priceID).val(' ').attr("readonly","readonly");
				
			}else{
				$("#"+priceID).removeAttr("readonly");
				
			}
			
		});
		
		$("#Package").on("blur",".optionPrce",function(){
			var priceID  = $(this).attr('id');
			var keys = priceID.split("_");
			var totalRow = $("#totalrow").val();
			var total = 0;
				for (i = 0; i < totalRow; i++) {
					parseFloat($("#"+i+'_'+keys[1]+'_price').val())
					if(!isNaN(parseFloat($("#"+i+'_'+keys[1]+'_price').val()))){
						total = parseFloat($("#"+i+'_'+keys[1]+'_price').val()) + total;
					}
				}
			 if(total > 0){
				$("#totalcount_"+keys[1]).val(1);
			 }else{
				$("#totalcount_"+keys[1]).val('');
			 }
			$("#total_"+keys[1]+" p").html("AED "+total);
			$("."+'_'+keys[1]+'_optionprice').val(total);
			//$(this).closest('.optionDuration').trigger('change');
		});
		
		
		
		 
     	$(".serviceStaffStatus").bootstrapSwitch();
				
			$( ".datepicker" ).datepicker({
				dateFormat: 'yy-mm-dd',
				minDate: 0,
				showOn: "both",
				buttonImage: "/img/calendar.png",
				buttonImageOnly: true,
				onSelect: function(){
					$("#toOnline").find('input').trigger('blur');
					$("#fromOnline").find('input').trigger('blur');
				}
			 });
			//$('.datepicker').datepicker('setDate', new Date());
			$("#SalonServiceDetailSoldAs").on('change',function(){
				var value = $(this).val();
				$(".evoucherExpire").hide();
				$(".appLeadTime").hide();
				var appeVoucher = ["0","1","2"];
				var app = ["0","1"];
				var evoucher = ["0","2"];
				if (appeVoucher.indexOf(value) !== -1){
					if (app.indexOf(value) !== -1){
					$(".appLeadTime").show();
					}
					if (evoucher.indexOf(value) !== -1){
					$(".evoucherExpire").show();
					}
				}
			});
		
		$("#SalonServiceDetailListedOnline").on('change',function(){
			var value = $(this).val();
			
			 itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'loadAjaxlistedOnline' ,'admin'=>false)); ?>"; 
					
			$(".ajaxLoadC").load(itsId+'/'+value,function(){
				$( ".datepickerStart" ).datepicker({
					dateFormat: 'yy-mm-dd',
					minDate: 0,
					showOn: "both",
					buttonImage: "/img/calendar.png",
					buttonImageOnly: true,
					onSelect: function(selected){
						//alert(selected);
						$("#SalonServiceDetailListedOnlineStart").trigger('blur');
						//$("#SalonServiceDetailListedOnlineEnd").trigger('blur');
					}
				 });
					$( ".datepickerEnd" ).datepicker({
					dateFormat: 'yy-mm-dd',
					minDate: 0,
					showOn: "both",
					buttonImage: "/img/calendar.png",
					buttonImageOnly: true,
					onSelect: function(selected){
						//alert(selected);
						$("#SalonServiceDetailListedOnlineEnd").trigger('blur');
						//$("#SalonServiceDetailListedOnlineEnd").trigger('blur');
					}
				 });
					//	$( ".datepicker" ).datepicker({
			//	dateFormat: 'yy-mm-dd',
			//	minDate: 0,
			//	showOn: "both",
			//	buttonImage: "/img/calendar.png",
			//	buttonImageOnly: true,
			//	onSelect: function(){
			//		$("#toOnline").find('input').trigger('blur');
			//		$("#fromOnline").find('input').trigger('blur');
			//	}
			// });
			    //$("document").find('.add_pricingoption').bind('click');
			});	
		
		});
		
			
			
		$("#SalonServiceDetailOfferAvailable").on('change',function(){
			var value = $(this).val();
			if(value == 1){
				$("#weekDays").show();
				$('#weekdayCheckRequired').attr('required',true).val('');
			}else{
				$("#weekDays").hide();
				$('#weekdayCheckRequired').attr('required',false).val('');
			}
		});
		
		$("#weekDays").on('click','input[type=checkbox]',function(){
			var checked = 0;
			$("#weekDays input[type=checkbox]").each(function(){
				if($(this).is(':checked')){
					checked = checked+1;
				}
			});
			
			if(checked > 0){
				$('#weekdayCheckRequired').val('1');
				$(document).find('dfn[data-for=weekdayCheckRequired]').css('display','none');
			}else{
				$('#weekdayCheckRequired').val('');
				$(document).find('dfn[data-for=weekdayCheckRequired]').css('display','inline');
			}
			//alert(checked);
		});
		
		$("#SalonServiceDetailEvoucherExpire").on('change',function(){
			var value = $(this).val();
			if(value == 1){
				$(".expireAfter").show();
			}else{
				$(".expireAfter").hide();
			}
		});
		$("#Package").find(".scrollError").scroll(function() {
			$(document).find('.datepicker').datepicker('hide');
		});
		
		$('.timePKr').timepicker();
		
	});
</script>

            
