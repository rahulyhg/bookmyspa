<style>
.top_pad{
	margin-top:7%;
}
.top3Pad{
	margin-top:3%;
}
.ui-datepicker-trigger{
    opacity: 0.5;
    position: absolute;
    right: 5px;
    top: 5px;
}
.red{
    color: red;
}
</style>

<?php 
echo $this->Html->css('admin/plugins/select2/select2');
    echo $this->Html->script('admin/plugins/select2/select2.min.js'); ?>
	<div class="loader-container" style="display: none;">
	<div class="inner-loader"><img title="" alt="" src="/img/gif-load.GIF"></div>
</div>
<div class="modal-dialog vendor-setting overwrite">
<?php echo $this->Form->create('SalonService',array('admin'=>true,'novalidate','id'=>'SalonService','class'=>'form-vertical ServicePopForm'));?>

<div class="modal-content">
<div class="modal-header">
<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h2 class="no-mrgn"><?php echo $treatmentType;?> Treatment </h2>
</div>
<div class="modal-body clearfix SalonEditpop">
<div class="row">
<div class="col-sm-9 scrollError" style="height: 545px; overflow: auto;">
<div class="box">
<div class="box-content">
<?php echo $this->Form->hidden('SalonService.id',array('value'=>isset($salonservice['SalonService']['id']) ? $salonservice['SalonService']['id']:'','label'=>false,'div'=>false,'class'=>'salon_service_id'));?>
<?php echo $this->Form->hidden('Service.parent_id',array('label'=>false,'div'=>false,'value'=>$parent_id));?>
<?php echo $this->Form->hidden('SalonService.parent_id',array('label'=>false,'div'=>false));?>
<?php echo $this->Form->hidden('SalonService.service_id',array('label'=>false,'div'=>false));?>
<div class="col-sm-12">
<div class="box">
        <div class="box-title">
                <h3><i class="glyphicon-settings"></i>Treatment Details</h3>
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
				<?php
							if(empty($salonservice['SalonService']['eng_name']) && !empty($salonservice['Service']['eng_name'])){
						$this->request->data['SalonService']['eng_name'] = $salonservice['Service']['eng_name'];		
					}
						if(empty($salonservice['SalonService']['ara_name']) && !empty($salonservice['Service']['ara_name'])){
						$this->request->data['SalonService']['ara_name'] = $salonservice['Service']['ara_name'];		
					}
				?>
                <div class="tab-content lft-p-non rgt-p-non padding tab-content-inline tab-content-bottom ">
                        <div class="tab-pane active" id="first11">
                            <?php
							$nextDivClass = 'col-sm-12';
							if(isset($salonservice['SalonService']['service_id']) && $salonservice['SalonService']['service_id'] != 0){
								$nextDivClass = 'col-sm-6';
								?>
							<div class="col-sm-6 lft-p-non">
                                        <div class="form-group">
                                                <label >Sieasta Name *:</label>
                                                <?php echo $this->Form->input('Service.eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required'=>false,'readonly'=>true)); ?>
                                        </div>
                                </div>
							<?php } ?>
							    <div class="<?php echo $nextDivClass; ?> nopadding">
                                        <div class="form-group">
                                                <label class="">Display Name *:</label>
                    <?php echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required','minlength'=>'3','validationMessage'=>"Display name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-pattern-msg'=>"Please enter only alphabets.",'maxlengthcustom'=>'50','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
                                        </div>
                                </div>
                                <div class="col-sm-12 nopadding">
                                        <div class="form-group">
                                        <label>Description *:</label>
                                           <?php echo $this->Form->input('eng_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required','validationMessage'=>"Description is required.",'maxlengthcustom'=>'200','data-maxlengthcustom-msg'=>"Maximum 200 characters are allowed.")); ?>
                                   </div>
                                </div>
                </div>
                        <div class="tab-pane" id="second22">
						  <?php   if(isset($salonservice['SalonService']['service_id']) && $salonservice['SalonService']['service_id'] != 0){ ?>
                                <div class="col-sm-6 lft-p-non">
                                        <div class="form-group">
                                                <label class="">Sieasta Name :</label>
                                                        <?php echo $this->Form->input('Service.ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','readonly'=>true)); ?>
                                        </div>
                                </div>
								<?php } ?>
                                <div class="<?php echo $nextDivClass; ?> nopadding">
                                        <div class="form-group">
                                                        <label class="">Display Name :</label>
                                                                <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                        </div>
                                </div>
                                
                                 <div class="col-sm-12 nopadding">
                                        <div class="form-group">
                                        <label>Description:</label>
                                                  <?php echo $this->Form->input('ara_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required'=>false)); ?>
                                        </div>
                                </div>
                        </div>
                
                
                </div>
        </div>
</div>
</div>
<div class="col-sm-12">
<div class="box">
        <div class="box-title">
                <h3><i class="glyphicon-settings"></i>Pricing Options</h3>
                <span class="pull-right pdng10 pos-rel clearfix"><?php echo $this->Form->input('SalonService.inventory',array('type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp;&nbsp;Limit Inventory'),'div'=>false,'class'=>'form-control')); ?></span>
        </div>
        <div class="box-content tab-content" id="pricingOptionValues">
                        <?php echo $this->element('admin/SalonServices/pricing_option_table'); ?>
        </div>
    <div class="box-content">
	<div class="form-group">
		<div class="row ">
			<div class="col-sm-12">
				<?php echo $this->Html->Link('Add another pricing option','javascript:void(0)',array('title'=>'Add Another Pricing Level','data-id'=>'','class'=>'add_anotherpricing','escape'=>false));
					if($treatmentType == 'Edit'){
						echo $this->Html->Link('Make a deal','javascript:void(0)',array('title'=>'Make a deal','data-id'=>'','class'=>'create_servicedeal pull-right','escape'=>false));	
					}
				?>
			</div>
		</div>
	</div>
    </div>
</div>
</div>
<div class="col-sm-12">
<div class="box">
        <div class="box-title">
                <h3><i class="glyphicon-settings"></i>How would you like to sell this Service ?</h3>
        </div>
        <div class="box-content sell-service">
                <div class="form-group ">
                        
                                   <label>Listed Online:</label>
                                   <section>
                                     <?php echo $this->Form->input('SalonServiceDetail.id', array('type' => 'hidden', 'label' => false)); ?>
                                <?php
                                $default = isset($salonservice['SalonServiceDetail']['listed_online']) ? $salonservice['SalonServiceDetail']['listed_online']:0;
                                echo $this->Form->input('SalonServiceDetail.listed_online', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control ', 'options' => $this->common->get_listedonline_options(), 'default'=>$default)); ?>
                                
                                <?php
								if($default==0){
									$class = '';
								}else{
									$class = 'top3Pad';
								}
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
                                <div class="col-sm-12  nopadding top3Pad ajaxLoadC" id = "rangeShow" >
                                        <div class="date" style="<?php echo $from;?>" id="fromOnline">
						<?php echo $this->Form->input('SalonServiceDetail.listed_online_start', array('type' => 'text', 'label' => false,'validationmessage'=>'Start date is required.', 'div' => false, 'class' => 'datepicker')); ?>
                                        </div>
                                        <div class="to" style="<?php echo $range;?>" >
                                                 &nbsp;to
                                        </div>
                                        <div class="date" style="<?php echo $to;?>" id="toOnline">
                                           
                                                        <?php echo $this->Form->input('SalonServiceDetail.listed_online_end', array('type' => 'text', 'label' => false, 'validationmessage'=>'End date is required.','div' => false, 'class' => 'datepicker','data-greaterdate-field'=>"data[SalonServiceDetail][listed_online_start]", 'data-greaterdate-msg'=>'End date should be greater than or equal to start date.' )); ?> 
                                        </div>
                                </div>
                                </section>
                        
                </div>
                <div class="form-group">
                        
                                
                                        <label>Offer Available:</label>
                                        <section>
                                        <?php
                                        $displayofferDays='';
                                        $offerDay =  isset($salonservice['SalonServiceDetail']['offer_available']) ? $salonservice['SalonServiceDetail']['offer_available']:0;
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
				
                <div class="form-group">
				
			<?php
			
			       $default = isset($salonservice['SalonServiceDetail']['sold_as']) ? $salonservice['SalonServiceDetail']['sold_as']:0;
				
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
				<?php if($this->request->data['SalonServiceDetail']['appointment_lead_time'] ==''){
					$this->request->data['SalonServiceDetail']['appointment_lead_time'] = $defaultLeadtime;	
				}?>
				<?php echo $this->Form->input('SalonServiceDetail.appointment_lead_time', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_leadtime_options())); ?>
			</section>
                </div>
                <div class="form-group evoucherExpire" style="<?php echo $evoucherExpire;?>">
                                <?php
					$voucherExpire='';
                                        $offerDay =  isset($salonservice['SalonServiceDetail']['evoucher_expire']) ? $salonservice['SalonServiceDetail']['evoucher_expire']:0;
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
				<div class="form-group">
					<label>Treatment Rooms:</label>
					<section class="resource-pop">
					   <?php
					   $resourceids =array();
						if(!empty($salonservice['SalonServiceResource'])){
							foreach($salonservice['SalonServiceResource'] as $resources){
								$resourceids[]= $resources['salon_room_id'];
							}
						}
						
					   echo $this->Form->input('SalonService.salon_room_id',array('id'=>'','type'=>'select','label'=>false,'div'=>false,'class'=>'chosen-select','options'=>$this->Common->get_room_options($auth_user['User']['id'],'','resource'),'multiple'=>true,'default'=>$resourceids)); ?>
					</section>
			   </div>
                <div class="form-group ">
                        
                                        <label>Restrictions</br><i>(English)</i></label>
                                        <section>
                                                <?php echo $this->Form->input('SalonService.eng_restriction', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                        </section>
                </div>
		<div class="form-group ">
                        
                                        <label>Restrictions</br><i>(Arabic)</i></label>
                                        <section>
                                                <?php echo $this->Form->input('SalonService.ara_restriction', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                        </section>
                </div>
                <div class="form-group ">
                                        <label>Good to Know</br><i>(English)</i></label>
                                        <section>
                                        <?php echo $this->Form->input('SalonService.eng_good_to_know', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                        </section>
                </div>
		<div class="form-group ">
		      <label>Good to Know</br><i>(Arabic)</i></label>
		      <section>
		      <?php echo $this->Form->input('SalonService.ara_good_to_know', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
		      </section>
                </div>
                <div class="form-group taxation-box">
                        <!--<div class="col-sm-3 lft-p-non">-->
                                        <!--<label>Taxation:</label>-->
                                        <?php
                                        //$default =  isset($salonservice['SalonService']['tax_id']) ? $salonservice['SalonService']['tax_id']:'';
                                        //echo $this->Form->input('tax_id', array('type' => 'select', 'label' => false, 'div' => false, 'options' => $this->common->tax_options($auth_user['User']['id']), 'class' => 'form-control')); ?>
                        <!--</div>-->
                                <!--<div class="col-sm-3 lft-p-non">-->
                                        <!--<label>Deduction:</label>-->
                                        <?php
                                        //$default1 =  isset($salonservice['SalonService']['deduction_id']) ? $salonservice['SalonService']['deduction_id']:'';
                                        //echo $this->Form->input('deduction_id', array('type' => 'select', 'label' => false, 'div' => false, 'options' => $this->common->deduction_options($auth_user['User']['id']), 'class' => 'form-control')); ?>
                                <!--</div>-->
                                <div class="col-sm-3 lft-p-non">
                                        <label>Business Cost</label>
                                        <?php echo $this->Form->input('SalonService.cost_to_business', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control','maxlengthcustom'=>'3','data-maxlengthcustom-msg'=>"Maximum 3 numbers are allowed.",'required'=>false,'pattern'=>"\d+",'data-pattern-msg'=>'Please enter the valid numeric value.')); ?>
                                </div>
                                <div class="col-sm-3 nopadding">
				        <label>Outcall Service:</label>
                                        <div class="col-sm-12 top_pad">
					  <?php echo $this->Form->input('SalonService.outcall_service', array('type' => 'checkbox', 'label' =>  array('class'=>'new-chk','text'=>'&nbsp;'), 'div' => false, 'class' => 'form-control')); ?>
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
					<div class="form-group col-sm-12 lft-p-non serviceProviderList">
	<?php echo $this->element('admin/SalonServices/salon_service_provider'); ?>
				  </div>
			</div>
	</div>
</div>

</div>
</div>
</div>

<div class="col-sm-3">
<div class="box image-box">
<div class="box-title">
    <h3>Image<span class="red">*</span></h3>
</div>
<div class="box-content">
<ul class="tiles imagesList tiles-center nomargin">

<?php
$count = 5;
if(isset($salonservice['SalonServiceImage']) && !empty($salonservice['SalonServiceImage'])){
                $i=0;
				foreach($salonservice['SalonServiceImage'] as $thelimage){
                        
						if($count>0){?>
                        <li class="lightgrey theImgH ">
                        <?php ?>
                        <img alt="" class="" src="/images/Service/150/<?php echo $thelimage['image']; ?>" data-img="<?php echo $thelimage['image']; ?>">
						<?php if($i==0){?>
							<span class="caption-txt">Primary Image</span>
                        <?php }?>
						<div class="extras">
                                <div class="extras-inner">
                                        <a class="del-cat-pic" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                </div>
                        </div>
                        <?php echo $this->Form->hidden('serviceimage.',array('class'=>'serviceImg','label'=>false,'div'=>false,'value'=>$thelimage['image']));?>
                        </li>
                <?php
                 $count = $count - 1;
                        }
					$i++;
                }
        }
for($itra = 0 ; $itra < $count ; $itra++ ){ ?>
        <li class="lightgrey empty">
                <a href="javascript:void(0);" class="addImage"><span><i class="fa fa-plus"></i></span></a>
                <?php echo $this->Form->hidden('serviceimage.',array('class'=>'serviceImg','label'=>false,'div'=>false));?>
        </li>	
<?php }
?>
</ul>
</div>
</div>
</div>

</div>
</div>

<div class="modal-footer pdng20">
<?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitSalonService','label'=>false,'div'=>false));?>
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

	/***************End****************/
	$(document).find(".imagesList").sortable({
		placeholder: "placeholder",
		items: "li:not(.empty)",
		cancel: ".empty",
		stop: function( event, ui ) {
			var firstli = $(this).find('li').first();
			if(firstli.find('.caption-txt').length == 0){
				$(this).find(".caption-txt").remove();
				firstli.append("<span class='caption-txt'>Primary Image</span>");
				
			}
			
		}
	});
	
	   
$(".serviceStaffStatus").bootstrapSwitch();

$(document).on('switchChange.bootstrapSwitch','.serviceStaffStatus',function(event, state){
		var empChecked = 0;
		var pricingLevel = $(document).find('#SalonServiceTotalPricingIds').attr('data-id');
		
			var employeeSel = $(this);
			var pLevelIdArray = pricingLevel.split(',');
			$.each( pLevelIdArray, function(  index, value ) {
				
				if(value != 0){
					var empLength = $(document).find('div.serviceProviderList tr[data-pl='+value+']').length;
					if(empLength > 0){
						var checklen = 0;
						$(document).find('div.serviceProviderList tr[data-pl='+value+']').each(function(){
							if($(this).find('.serviceStaffStatus').is(':checked')){
								console.log('asd');
								empChecked = empChecked+1;
								checklen = checklen+1;
							}
						});
						if(checklen == 0){
							empChecked = 0;
							return false;
						}
						
					}else{
						empChecked = 0;
						return false;
					}
					
				}
				else{
					$(document).find('div.serviceProviderList tr').each(function(){
						if($(this).find('.serviceStaffStatus').is(':checked')){
							empChecked = empChecked+1;
						}
					});	
				}
			});
		if(empChecked > 0){
			$('#employeeCheckRequired').val('1');
			$(document).find('dfn[data-for=employeeCheckRequired]').css('display','none');
		}else{
			$('#employeeCheckRequired').val('');
			$(document).find('dfn[data-for=employeeCheckRequired]').css('display','inline');
		}
		//console.log(empChecked);
});

	$( ".datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: 0,
		showOn: "button",
		buttonImage: "/img/calendar.png",
		buttonImageOnly: true,
		onSelect: function(){
			$("#toOnline").find('input').trigger('blur');
			$("#fromOnline").find('input').trigger('blur');
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
		    //$("document").find('.add_pricingoption').bind('click');
		});	
	
	});

//$("#SalonServiceDetailListedOnline").on('change',function(){
//	var value = $(this).val();
//	$("#fromOnline").hide();
//	$("#toOnline").hide();
//	$(".to").hide();
//	var Range = ["1","2","3"];
//	var to = ["2","3"];
//	var from = ["1","3"];
//	if (Range.indexOf(value) !== -1){
//		if (to.indexOf(value) !== -1){
//			$("#toOnline").show();
//			$("#SalonServiceDetailListedOnlineEnd").attr('required',true);
//			$("#SalonServiceDetailListedOnlineStart").attr('required',false);
//			if($("#SalonServiceDetailListedOnlineStart").next().hasClass('k-invalid-msg')){
//				$("#SalonServiceDetailListedOnlineStart").next().remove();
//			}
//		}
//		if (from.indexOf(value) !== -1){
//			$("#fromOnline").show();
//			$("#SalonServiceDetailListedOnlineEnd").attr('required',false);
//			$("#SalonServiceDetailListedOnlineStart").attr('required',true);
//			if($("#SalonServiceDetailListedOnlineEnd").next().hasClass('k-invalid-msg')){
//				$("#SalonServiceDetailListedOnlineEnd").next().remove();
//			}
//			
//		}
//		if(value==3){
//			$(".to").show();
//			$("#SalonServiceDetailListedOnlineStart").attr('required',true);
//			$("#SalonServiceDetailListedOnlineEnd").attr('required',true);
//			
//		}
//	}
//    if(value==0){
//		$("#rangeShow").removeClass('top3Pad');
//		$("#SalonServiceDetailListedOnlineEnd").attr('required',false);
//		$("#SalonServiceDetailListedOnlineStart").attr('required',false);
//		if($("#SalonServiceDetailListedOnlineStart").next().hasClass('k-invalid-msg')){
//				$("#SalonServiceDetailListedOnlineStart").next().remove();
//			}
//			if($("#SalonServiceDetailListedOnlineEnd").next().hasClass('k-invalid-msg')){
//				$("#SalonServiceDetailListedOnlineEnd").next().remove();
//			}
//	}else{
//		$("#rangeShow").addClass('top3Pad');
//	}
//
//});


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

$("#SalonServiceDetailOfferAvailable").on('change',function(){
	var value = $(this).val();
	if(value == 1){
		$("#weekDays").show();
		$('#weekdayCheckRequired').attr('required',true).val('');
	}else{
		$("#weekDays").hide();
		$('#weekdayCheckRequired').attr('required',false).val('');
		if($("#weekdayCheckRequired").next().hasClass('k-invalid-msg')){
		    $("#weekdayCheckRequired").next().css('display','none');
		}
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
 $(".chosen-select").chosen({width: "100%",height:"100%"});
	$(".SalonEditpop .col-sm-9").scroll(function() {
		$(document).find('.datepicker').datepicker('hide');
	});
	
});
</script>


