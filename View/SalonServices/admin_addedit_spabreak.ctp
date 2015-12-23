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
<?php echo $this->Html->script('admin/jquery.timepicker.js?v=1'); ?>
<?php echo $this->Html->css('admin/jquery.timepicker.css?v=1'); ?>
<div class="modal-dialog vendor-setting overwrite">
	<?php 
            echo $this->Form->create('Spabreak',array('admin'=>true,'novalidate','id'=>'Spabreak','class'=>'form-vertical ServicePopForm'));
            echo $this->Form->hidden('Spabreak.id');
            echo $this->Form->hidden('SalonServiceDetail.id');
        ?>
	
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h2 class="no-mrgn"><?php echo $type; ?> Spa Break </h2>
	    </div>
	    <div class="modal-body clearfix SalonEditpop">
            <div class="row">
            <div class="col-sm-9">
              <div style="height: 545px; overflow: auto;">
                <div class="box">
                    <div class="box-content">
                            <div class="col-sm-12">
                                    <div class="box">
                                            <div class="box-title">
                                                    <h3><i class="glyphicon-settings"></i>Spa Break Details</h3>
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
                                                                                    <label >Spa Break Name*:</label>
                                                                                    <?php echo $this->Form->input('Spabreak.eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required','minlength'=>'3','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Spa Break name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-pattern-msg'=>"Please enter only alphabets.",'maxlengthcustom'=>'50','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-sm-12 lft-p-non">
                                                                            <div class="form-group">
                                                                            <label> Description*:</label>
                                                                               <?php echo $this->Form->input('Spabreak.eng_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required','validationMessage'=>"Description is required.",'maxlengthcustom'=>'200','data-maxlengthcustom-msg'=>"Maximum 200 characters are allowed.")); ?>
                                                                       </div>
                                                                    </div>
                                                            </div>
                                                            <div class="tab-pane" id="second22">
                                                                    <div class="col-sm-12 lft-p-non ">
                                                                            <div class="form-group">
                                                                                    <label class="">Spa Break Name :</label>
                                                                                    <?php echo $this->Form->input('Spabreak.ara_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-sm-12 lft-p-non">
                                                                            <div class="form-group">
                   <label>Spa Break Description :</label>
                                                                                    <?php echo $this->Form->input('Spabreak.ara_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3)); ?>
                                                                            </div>
                                                                    </div>
                                                            </div>

                                                                            <div class="form-group">
                                                                            <section>
                                                                                    <div class="col-sm-6 lft-p-non">
                                                                                            <label class="col-sm-12 lft-p-non">No. of guests*:</label>
                                                                                                    <?php echo $this->Form->input('Spabreak.no_of_guest', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control full-w', 'options' => $this->common->getNumberRange())); ?>
                                                                                    </div>
                                                                                    </section>
                                                                                    <section>
                                                                                    <div class="col-sm-6">
                                                                                            <label class="col-sm-12 lft-p-non">No. of Nights*:</label> 
                                                                                            <?php echo $this->Form->input('Spabreak.no_of_nights', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control full-w', 'options' => $this->common->getSpabreakRange())); ?>
                                                                                    </div>
                                                                                    </section>
                                                                            </div>


                                                    </div>
                                            </div>
                                    </div>
                            </div>


    <div class="col-sm-12">
                                    <div class="box">
                                            <div class="box-title">
                                                    <h3><i class="glyphicon-settings"></i>Pricing Options</h3>

                                            </div>
                                            <div class="box-content tab-content" id="pricingOptionValues">
                                                            <?php echo $this->element('admin/SalonServices/spabreak_pricing_option'); ?>

            </div>

                                    </div>
                            </div>
                            <div class="col-sm-12">
                                    <div class="box">
                                            <div class="box-title">
                                                    <h3><i class="glyphicon-settings"></i>How would you like to sell this Spa Break?</h3>
                                            </div>
                                            <div class="box-content sell-service">
                                                    <div class="form-group ">

                                                                       <label>Listed Online*:</label>
                                                                       <section>
                                                                      
                                                                    <?php
                                                                    $default = isset($Spabreak['Spabreak']['listed_online']) ? $Spabreak['Spabreak']['listed_online']:0;
                                                                    echo $this->Form->input('Spabreak.listed_online', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_listedonline_options(), 'default'=>$default)); ?>
                                                                   
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
                                                                    <div class="col-sm-12  top3Pad nopadding <?php echo $class;?> ajaxLoadC" id = "rangeShow" >
                                                                            <div class="date" style="<?php echo $from;?>" id="fromOnline">

                                                                               <?php echo $this->Form->input('Spabreak.id', array('type' => 'hidden', 'label' => false)); ?>
                                                                                            <?php echo $this->Form->input('Spabreak.listed_online_start', array('type' => 'text','data-type'=>'date', 'label' => false, 'validationmessage'=>'Valid start date is required.',  'div' => false, 'class' => 'datepicker')); ?>
                                                                            </div>
                                                                            <div class="to" style="<?php echo $range;?>">

                                                                                    to
                                                                            </div>
                                                                            <div class="date" style="<?php echo $to;?>" id="toOnline">

                                                                                            <?php echo $this->Form->input('Spabreak.listed_online_end', array('type' => 'text','data-type'=>'date', 'label' => false, 'validationmessage'=>'Valid end date is required.','div' => false, 'class' => 'datepicker','data-greaterdate-field'=>"data[Spabreak][listed_online_start]", 'data-greaterdate-msg'=>'End date should be greater than or equal to start date.')); ?>
                                                                            </div>
                                                                    </div>
                                                                    </section>

                                                    </div>
                                                    <div class="form-group">


                                                                            <label>Offer Available:</label>
                                                                            <section>
                                                                            <?php
                                                                            $displayofferDays='';
                                                                            $offerDay =  isset($Spabreak['SalonServiceDetail']['offer_available']) ? $Spabreak['SalonServiceDetail']['offer_available']:0;
                                                                            if($offerDay==0){
                                                                                    $displayofferDays ='display:none';
                                                                            }
                                                                            echo $this->Form->input('SalonServiceDetail.offer_available', array('type' => 'select', 'default'=>$offerDay,'label' => false, 'div' => false, 'class' => 'form-control','id'=>'SalonServiceDetailOfferAvailable', 'options' => $this->common->get_offerdays_options())); ?>

                                                                    <div class="clear"></div>
                                                                    <div id="weekDays" style="<?php echo $displayofferDays;?>" class="week-days weekPricing">

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
                                                            
                                                            $default = isset($Spabreak['SalonServiceDetail']['sold_as']) ? $Spabreak['SalonServiceDetail']['sold_as']:0;

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
                                                                <?php echo $this->Form->input('SalonServiceDetail.appointment_lead_time', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_days())); ?>
                                                        </section>
                                                    </div>
                                                    <div class="form-group evoucherExpire" style="<?php echo $evoucherExpire;?>">
                                                        <?php
                                                            $voucherExpire='';
                                                            $offerDay =  isset($Spabreak['SalonServiceDetail']['evoucher_expire']) ? $Spabreak['SalonServiceDetail']['evoucher_expire']:0;
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

                                                        <label>Restrictions </br><i>(English)</i></label>
                                                        <section>
                                                                <?php echo $this->Form->input('Spabreak.eng_restrictions', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                                        </section>
                                                    </div>
                                                    <div class="form-group ">

                                                        <label>Restrictions </br><i>(Arabic)</i></label>
                                                        <section>
                                                                <?php echo $this->Form->input('Spabreak.ara_restrictions', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                                        </section>
                                                    </div>
                                                    <div class="form-group ">

                                                        <label>Good to know </br><i>(English)</i></label>
                                                        <section>
                                                        <?php echo $this->Form->input('Spabreak.eng_good_to_know', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                                        </section>

                                                    </div>
                                                    <div class="form-group ">

                                                        <label>Good to know </br><i>(Arabic)</i></label>
                                                        <section>
                                                        <?php echo $this->Form->input('Spabreak.ara_good_to_know', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2)); ?>
                                                        </section>

                                                    </div>
                                                    <div class="form-group">
                                                        <label>Check-in*:</label>
                                                        <section>
                                                        <?php echo $this->Form->input('Spabreak.check_in', array('type' => 'text', 'data-type'=>'date','label' => false, 'div' => array('class'=>'col-sm-6 nopadding'), 'class' => 'form-control timepicker','required'=>true,'validationmessage'=>'Valid check-in time is required.')); ?>
                                                        </section>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Checkout*:</label>
                                                        <section>
                                                        <?php echo $this->Form->input('Spabreak.check_out', array('type' => 'text','data-type'=>'date', 'label' => false, 'div' => array('class'=>'col-sm-6 nopadding'), 'class' => 'form-control timepicker','required'=>true,'validationmessage'=>'Valid check-out time is required.')); ?>		
                                                        </section>
                                                    </div>
                                                
                                                    <div class="form-group ">
                                                        <label>Blackout Dates</label>
                                                        <section>
                                                            <div class="nopadding theDates col-sm-12">
                                                                <?php 
                                                                    if(isset($Spabreak['Spabreak']['blackout_dates']) && !empty($Spabreak['Spabreak']['blackout_dates'])){
                                                                    foreach($Spabreak['Spabreak']['blackout_dates'] as $dky=> $dates){
                                                                    ?>
                                                                <div class="chkblkD">
                                                                    <div class="date mrgn-rgt10 w60 mrgn-btm10">
                                                                        <?php echo $this->Form->input('Spabreak.blackout_dates.'.($dky+1), array( 'label' => false, 'div' => false,'data-rel'=>($dky+1), 'class' => 'form-control full-w blackoutDateErr selBlkOutDates datepicker','value'=>$dates)); ?>
                                                                    </div>
                                                                    <div class="lft-p-non col-sm-4"><a class="removeblkdate" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a></div>
                                                                </div>
                                                                <?php }
                                                                } ?>

                                                            </div>
                                                            <div class="nopadding mainBkD col-sm-12">
                                                                <div class="date mrgn-rgt10 w60">
                                                                    <?php echo $this->Form->input('Spabreak.blackout_dates.', array( 'label' => false, 'div' => false, 'class' => 'form-control full-w blackoutDateErr selBlkOutDates datepicker')); ?>
                                                                    <dfn class="text-danger  k-invalid-msg" data-for="data[Spabreak][blackout_dates][]" role="alert" style="display: none;">Please select date.</dfn>
                                                                </div>
                                                                <div class="lft-p-non col-sm-4 pdng-tp4">
                                                                    <?php echo $this->Html->link('<i class="fa fa-plus"></i>','javascript:void(0);',array('escape'=>false,'class'=>'addblkdate')); ?>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div><!-- form-group -->

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
						<h3>Image*:</h3>
					</div>
					<div class="box-content">
					<ul class="tiles tiles-center nomargin imagesList">
					<?php
$count = 5;
if(isset($Spabreak['SalonSpabreakImage']) && !empty($Spabreak['SalonSpabreakImage'])){
                foreach($Spabreak['SalonSpabreakImage'] as $thelimage){
                        if($count>0){?>
                        <li class="lightgrey theImgH ">
                        <?php ?>
                        <img alt="" class="" src="/images/Service/150/<?php echo $thelimage['image']; ?>" data-img="<?php echo $thelimage['image']; ?>">
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
                }
        }
for($itra = 0 ; $itra < $count ; $itra++ ){ ?>
        <li class="lightgrey empty">
                <a href="javascript:void(0);" class="addImage"><span><i class="fa fa-plus"></i></span></a>
                <?php echo $this->Form->hidden('serviceimage.',array('class'=>'serviceImg','label'=>false,'div'=>false));?>
        </li>	
<?php }
?></ul>
					</div>
				</div>
</div>
        </div>
    
		<div class="modal-footer pdng20">
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitSpaBreak','label'=>false,'div'=>false));?>
                                    <?php echo $this->Form->button('Cancel',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'class'=>'btn' , 'data-dismiss'=>"modal")); ?>
                                    
			
        </div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script>
	Custom.init();
        
	/*------------------------------ blackout start here ----------------------------------*/
	$(document).ready(function(){
            $( ".selBlkOutDates" ).datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0,
                showOn: "button",
                buttonImage: "/img/calendar.png",
                buttonImageOnly: true,
            });
            $(document).on('click', '.addblkdate', function(e){
	    var theBkOj = $(this);
	    var theDate = theBkOj.closest('div.mainBkD').find('input').val();
	    theBkOj.closest('div.mainBkD').find('input').val('');
	    if(theDate){
		//var theHTML = theBkOj.closest('div.mainBkD').clone();
		var tillDates = theBkOj.closest('section').find('.theDates');
		var thelenCnt = tillDates.find('.chkblkD').length;
		if(thelenCnt > 0){
		    thelenCnt = tillDates.find('.selBlkOutDates:last').attr('data-rel');
		}
		var theIdNo = parseInt(thelenCnt)+1;
		theHTML = '<div class="chkblkD"><div class="date mrgn-rgt10 w60 mrgn-btm10"><input name="data[Spabreak][blackout_dates]['+theIdNo+']" data-rel="'+theIdNo+'" class="form-control selBlkOutDates" id="SpabreakBlackoutDates'+theIdNo+'" type="text"></div><div class="lft-p-non col-sm-4"><a href="javascript:void(0);" class="removeblkdate"><i class="fa fa-trash-o"></i></a></div></div>';
		tillDates.append(theHTML);
		tillDates.find('#SpabreakBlackoutDates'+theIdNo).val(theDate);
		$(document).find('#SpabreakBlackoutDates'+theIdNo).datepicker({dateFormat: 'yy-mm-dd',minDate: 0,showOn: "button",buttonImage: "/img/calendar.png",buttonImageOnly: true});
	    }
	    else{
		theBkOj.closest('div.mainBkD').find('dfn.text-danger').css('display','inline');
	    }
	});
        
        $(document).on('click', '.removeblkdate', function(e){
	    if(confirm('Are you sure, you want to delete this blackout date?')){
		$(this).closest('.chkblkD').remove(); 
	    }
	});
        
        /*------------------------------ blackout end here ----------------------------------*/
        
        $(".SalonEditpop .col-sm-9 > div").scroll(function() {
                $(document).find('.datepicker').datepicker('hide');
        });	
        $(".serviceStaffStatus").bootstrapSwitch();
        $( ".datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            showOn: "both",
            buttonImage: "/img/calendar.png",
            buttonImageOnly: true,
            onSelect: function(){
                    var id = $(this).attr('id');
                    $("#"+id).trigger('blur');
                    //$("#toOnline").find('input').trigger('blur');
                    //$("#fromOnline").find('input').trigger('blur');
            }
        });
	$("#SpabreakListedOnline").on('change',function(){
		var value = $(this).val();
		var type = 'spabreak';
		 itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'loadAjaxlistedOnline' ,'admin'=>false)); ?>"; 
				
		$(".ajaxLoadC").load(itsId+'/'+value+'/'+type,function(){
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
		    //$("document").find('.add_pricingoption').bind('click');
		});	
	
	});
        //$("#SpabreakListedOnline").on('change',function(){
        //    var value = $(this).val();
        //    $("#fromOnline").hide();
        //    $("#toOnline").hide();
        //    $(".to").hide();
        //    var Range = ["1","2","3"];
        //    var to = ["2","3"];
        //    var from = ["1","3"];
        //    if (Range.indexOf(value) !== -1){
        //        if (to.indexOf(value) !== -1){
        //            $("#toOnline").show();
        //            $("#SpabreakListedOnlineEnd").attr('required',true);
        //            $("#SpabreakListedOnlineStart").attr('required',false);
        //        }
        //        if (from.indexOf(value) !== -1){
        //            $("#fromOnline").show();
        //            $("#SpabreakListedOnlineEnd").attr('required',false);
        //            $("#SpabreakListedOnlineStart").attr('required',true);
        //        }
        //        if(value==3){
        //            $(".to").show();
        //            //$("#SalonServiceDetailListedOnlineStart").val(' ');
        //            //$("#SalonServiceDetailListedOnlineEnd").val(' ');
        //            $("#SpabreakListedOnlineStart").attr('required',true);
        //            $("#SpabreakListedOnlineEnd").attr('required',true);
        //
        //        }
        //    }
        //    if(value==0){
        //            $("#rangeShow").removeClass('top3Pad');
        //    }else{
        //            $("#rangeShow").addClass('top3Pad');
        //    }
        //});



        //$("#SpabreakListedOnline").on('change',function(){
        //    var value = $(this).val();
        //    $("#fromOnline").hide();
        //    $("#toOnline").hide();
        //    $(".to").hide();
        //    var Range = ["1","2","3"];
        //    var to = ["2","3"];
        //    var from = ["1","3"];
        //    if (Range.indexOf(value) !== -1){
        //            if (to.indexOf(value) !== -1){
        //                    $("#toOnline").show();
        //            }
        //            if (from.indexOf(value) !== -1){
        //                    $("#fromOnline").show();
        //            }
        //            if(value==3){
        //                    $(".to").show();
        //            }
        //    }
        //});


        /*------------------------ spa break offer available start --------------------*/
        $("#SalonServiceDetailOfferAvailable").on('change',function(){
            var value = $(this).val();
            if(value == 1){
                $(".weekPricing").show();
                $('#weekdayCheckRequired').attr('required',true).val('');
            }else{
                $(".weekPricing").hide();
                $('#weekdayCheckRequired').attr('required',false).val('');
                if($("#weekdayCheckRequired").next().hasClass('k-invalid-msg')){
                    $("#weekdayCheckRequired").next().css('display','none');
                }
            }
        }); 	

        $(".weekPricing").on('click','input[type=checkbox]',function(){
            var checked = 0;
            $(".weekPricing input[type=checkbox]").each(function(){
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

        /*------------------------ spa break offer available end --------------------*/

        /*-------------------------- spabreak sold as start ----------------------------*/
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
        /*-------------------------- spabreak sold as end ----------------------------*/


        $("#SalonServiceDetailEvoucherExpire").on('change',function(){
                var value = $(this).val();
                if(value == 1){
                        $(".expireAfter").show();
                }else{
                        $(".expireAfter").hide();
                }
        });

        $("#Spabreak").find("#weekDays input[type=checkbox]").on('change',function(){ 
            var length = $("#Spabreak").find(".days:checked").length;

            if(length<7){
                    $(document).find('#Spabreak').find('.addDayLink').show();
            }else{
                    $(document).find('#Spabreak').find('.addDayLink').hide();
            }
            if(length==1){
                    $(document).find(".days:checked").attr('disabled','disabled');
            var newName = $(document).find(".days:checked").attr('name');
                    $(document).find("#dayDynamic").attr('name',newName).val('1');
            }else if(length==2){
                    $(document).find(".days:checked").removeAttr('disabled');
                    $(document).find("#dayDynamic").removeAttr('name');
            }
            if($(this).is(':disabled')){
                    alert('Atleast One weekday must be selected');
            }
        });

        // enable timepicker
        $(".ui-timepicker-wrapper").css("width", "215px");
        $('.timepicker').timepicker();

	
	});
</script> 

            
