<?php $version_time = time(); ?>

 <div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h2 id="myModalLabel"><i class="icon-edit"></i><?php echo (isset($this->data) && !empty($this->data))?'Edit':'Create';?> Deal</h2>
        </div>
        <?php
	    echo $this->Form->create('Deal',array('id'=>'DealcreateForm','novalidate','class'=>'form-shorizontal ServicePopForm'));
	    echo $this->Form->hidden('id',array('label'=>false,'div'=>false));
	    echo $this->Form->hidden('DealServicePackage.0.salon_service_id',array('label'=>false,'div'=>false,'value'=>$service_id));
	    echo $this->Form->hidden('DealServicePackage.0.id',array('label'=>false,'div'=>false));
	    echo $this->Form->hidden('DealServicePackage.0.package_id',array('label'=>false,'div'=>false));
	    echo $this->Form->hidden('DealServicePackage.0.deal_id',array('label'=>false,'div'=>false,'value'=>isset($deal['Deal']['id']) ? $deal['Deal']['id']:''));
	?>
        <div class="modal-body pdng20 SalonEditpop">
            <div class="row">
	    <div class="col-sm-12 scrollError" style="height: 545px; overflow: auto;">
		<div class="col-sm-12 nopadding">
		    <div class="box">
			<div class="box-title"><h3><i class="glyphicon-settings"></i>Deal Details - (<?php echo ucfirst($serviceData['SalonService']['eng_name']); ?>)</h3></div>
			<div class="box-content nopadding">
			    <div class="col-sm-3 lft-p-non">
				<ul class="tiles deal-img tiles-center nomargin ">
					<li class="lightgrey empty">
						<?php if(isset($this->data['Deal']['image']) && !empty($this->data['Deal']['image'])){ ?>
						    <img alt="" class="" src="/images/Service/150/<?php echo $this->data['Deal']['image']; ?>" data-img="<?php echo $this->data['Deal']['image']; ?>">
						    <div class="extras"><div class="extras-inner"><a href="javascript:void(0);" class="addDealImage"><i class="fa fa-pencil"></i></a></div></div>
						    <?php echo $this->Form->hidden('image',array('label'=>false,'div'=>false,'required','validationMessage'=>"Image is required.",'value'=>$this->data['Deal']['image']));
						    $add = false;
						}else{ ?>
						    <a href="javascript:void(0);" class="addDealImage theChk"><span><i class="fa fa-plus"></i></span></a>
						    <?php echo $this->Form->hidden('image',array('label'=>false,'div'=>false,'required','validationMessage'=>"Image is required."));
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
				    <li class='active'><a href="#dealfirst1" data-toggle='tab'>English</a></li>
				    <li><a href="#dealsecond2" data-toggle='tab'>Arabic</a></li>
				</ul>
				<div class="tab-content lft-p-non rgt-p-non padding tab-content-inline tab-content-bottom ">
				    <div class="tab-pane active" id="dealfirst1">
					<div class="col-sm-12 nopadding">
					    <div class="form-group">
						<label class="">Deal Name *:</label>
						<?php echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required','minlength'=>'3',/*'pattern'=>'^[A-Za-z ]+$',*/'validationMessage'=>"Deal name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",/*'data-pattern-msg'=>"Please enter only alphabets.",*/'maxlengthcustom'=>'50','maxlength'=>'55','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
					    </div>
					</div>
					<div class="col-sm-12 nopadding">
					    <div class="form-group">
						<label>Deal Description *:</label>
						<?php echo $this->Form->input('eng_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required','validationMessage'=>"Description is required.")); ?>
					   </div>
					</div>
				    </div>
				    <div class="tab-pane" id="dealsecond2">
					<div class="col-sm-12 nopadding">
					    <div class="form-group">
						<label class="">Deal Name :</label>
						<?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
					    </div>
					</div>
					<div class="col-sm-12 nopadding">
					    <div class="form-group">
						<label>Deal Description:</label>
						<?php echo $this->Form->input('ara_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'required'=>false)); ?>
					    </div>
					</div>
				    </div>
				</div>
				</div>
			    </div>
		    </div>
		</div>
		<div class="col-sm-12 nopadding">
		    <div class="box">
			<div class="box-title"><h3><i class="glyphicon-settings"></i>Pricing Options</h3></div>
			<div class="box-content">
		      <?php $durationArray = $this->common->get_validduration(); 
			    $itrPrc = 0;
			    foreach($serviceData['ServicePricingOption'] as $pricekey=>$thePriceOp){ ?>
				<?php echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.deal_service_package_id", array('type' => 'hidden', 'label' => false));
				echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.id", array('type' => 'hidden', 'label' => false));
				echo $this->Form->hidden("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.salon_service_id",array('label'=>false,'div'=>false,'value'=>$service_id));
				echo $this->Form->hidden("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.deal_id",array('label'=>false,'div'=>false,'value'=>isset($deal['Deal']['id']) ? $deal['Deal']['id']:''));
				    ?>
				<?php echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.option_id", array('type' => 'text', 'label' => false,'div'=>false,'style'=>'display:none;','value'=>$thePriceOp['id'])); ?>
				<?php echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.duration", array('type' => 'text', 'label' => false,'div'=>false,'style'=>'display:none;','value'=>$thePriceOp['duration'])); ?>
				<?php echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.full_price", array('type' => 'text', 'label' => false,'div'=>false,'style'=>'display:none;','value'=>$thePriceOp['full_price'])); ?>
				<?php echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.sell_price", array('type' => 'text', 'label' => false,'div'=>false,'style'=>'display:none;','value'=>$thePriceOp['sell_price'])); ?>
				
				<div class="deal-show-box">
				    <ul>
					<li>
					    <section class="heading-box">
						<label> Original Sale Price </label>
						<h3><?php echo ucfirst($thePriceOp['custom_title_eng']); ?></h3>
					    </section>
					    <section class="price-duration">
						<section class="price">AED <?php
					        $actualPrice =  (!empty($thePriceOp['sell_price']))? $thePriceOp['sell_price']: $thePriceOp['full_price'];
						echo $actualPrice; ?></section>
						<section class="duration"><?php echo $durationArray[$thePriceOp['duration']]; ?></section>
					    </section>
					</li>
				    </ul>
				<div class="form-group clearfix">
				    <section>
					<div class="col-sm-6 lft-p-non">
					    <label class="">Pricing option name <i>(English) </i>*:</label>
					    <div class="col-sm-12 nopadding">
					       <?php echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.eng_custom_title", array('value'=>$thePriceOp['custom_title_eng'],'type' => 'text', 'label' => false,'div'=>false,'required','minlength'=>'3','validationMessage'=>"Deal pricing option name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'maxlengthcustom'=>'50','maxlength'=>'55','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
					    </div>
					</div>
					<div class="col-sm-6 nopadding">
					   <label class="">Pricing option name <i>(Arabic) </i></label>
					   <div class="col-sm-12 nopadding ">
					       <?php echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.ara_custom_title", array('type' => 'text', 'label' => false,'div'=>false)); ?>
					    </div>
					</div>
				    </section>
				</div>
				<div class="form-group mrgn-btm0 clearfix">
				    <section>
					<div class="col-sm-6 lft-p-non">
					    <label class="">Deal Price *:</label>
					    <div class="col-sm-12 nopadding">
					       <?php echo $this->Form->input("DealServicePackage.0.DealServicePackagePriceOption.$itrPrc.deal_price", array('type' => 'text', 'label' => false,'div'=>false,'validationMessage'=>"Deal price is required.",'class'=>'form-control','required'=>true,'maxlengthcustom'=>'10','maxValue'=>$actualPrice-1,'data-maxValue-msg'=>"Deal price should be less than service price.",'data-maxlengthcustom-msg'=>"Maximum 10 numbers are allowed.",'pattern'=>"^[0-9]+(\\.[0-9]+)?$" ,'data-pattern-msg'=>'Please enter the valid price.')); ?>
					    </div>
					</div>
					
				    </section>
				</div>
			    </div>
			    
			    <?php
			    $itrPrc++;
			    } ?>
			    <?php //pr($serviceData); ?>
			</div>
		    </div>
		</div>
		<div class="col-sm-12 nopadding">
		    <div class="box ">
			<div class="box-title">
			    <h3><i class="glyphicon-settings"></i>How would you like to sell this Deal?</h3>
			</div>
			<div class="box-content sell-service">
			    <div class="form-group ">
				<label>Deal Start Date*:</label>
				    <section>
                                    <?php
				    echo $this->Form->input('Deal.id', array('type' => 'hidden', 'label' => false)); ?>
				    <?php echo $this->Form->input('Deal.service_deal_id', array('type' => 'hidden', 'label' => false)); ?>
				   <div class="date mrgn-rgt10 w60">
				    <?php $default = date('Y-m-d');
					echo $this->Form->hidden('Deal.listed_online', array('value'=>1));
				        if(isset($this->request->data['Deal']['listed_online_start']) && !empty($this->request->data['Deal']['listed_online_start'])){
					    $default =  date('Y-m-d',strtotime($this->request->data['Deal']['listed_online_start']));
				        }
				        $readOnly = false;
					$current = strtotime(date('Y-m-d'));
					if(($current >=strtotime($deal['Deal']['listed_online_start'])) && ($current <=strtotime($deal['Deal']['max_time']))){
					   $readOnly = true;
					}
					
					//if((strtotime($deal['Deal']['listed_online_start']) < strtotime(date("Y-m-d"))) && (strtotime($deal['Deal']['max_time']) > strtotime(date("Y-m-d")))){
					//  $readOnly = true;
					//}
					//$readOnly = (strtotime($deal['Deal']['listed_online_start']) < strtotime(date("Y-m-d"))) && (strtotime($deal['Deal']['max_time']) > strtotime(date("Y-m-d")))  ? true:false;
				        $created =  date('Y-m-d',strtotime($default. ' + 13 day'));
					if($readOnly){
					    echo $this->Form->input('Deal.listed_online_start', array('type' => 'text', 'id'=>"",'label' => false,'validationmessage'=>'Start date is required.', 'default'=>$default, 'div' => false, 'data-max'=>$created,'class' => 'disableInput','readonly'=>$readOnly));
					}else{
					    echo $this->Form->input('Deal.listed_online_start', array('type' => 'text', 'id'=>"datepicker",'label' => false,'validationmessage'=>'Start date is required.', 'default'=>$default, 'div' => false, 'data-max'=>$created,'class' => 'datepicker disableInput','readonly'=>$readOnly));
					}
				    ?>
				    <?php
					  if($default==0){
					      $class = '';
					  }else{
					      $class = 'mrgn-tp10';
					  }
					  $from=$to=$range = "display:none";
					  if(in_array($default,(array(1,2,3)))){
					      if(in_array($default,(array(1,3)))){
						  $from="display:block";
					      }
					      if(in_array($default,(array(3,2)))){
						  $to="display:block";
					      }
					      if($default==3){
						  $range="display:block";
					      }
					  }
				    ?>
				    </div>
				    <!--<div class="col-sm-12  nopadding <?php echo $class;?> ajaxLoadC" id = "dealrangeShow"  >
                                        <div class="date" style="<?php echo $from;?>" id="dealfromOnline">
					    <?php echo $this->Form->input('Deal.listed_online_start', array('type' => 'text', 'label' => false,'validationmessage'=>'Start date is required.', 'div' => false, 'class' => 'datepicker')); ?>
                                        </div>
                                        <div class="dealto" style="<?php echo $range;?>" >&nbsp;to</div>
                                        <div class="date" style="<?php echo $to;?>" id="dealtoOnline">
					    <?php echo $this->Form->input('Deal.listed_online_end', array('type' => 'text', 'label' => false, 'validationmessage'=>'End date is required.','div' => false, 'class' => 'datepicker','data-greaterdate-field'=>"data[Deal][listed_online_start]", 'data-greaterdate-msg'=>'End date should be greater than or equal to start date.' )); ?> 
                                        </div>
				    </div>-->
                                </section>
			    </div>
		
			    <div class="form-group ">
				<label class="">Maximum Deal Quantity*:</label>
				<section>
				    <?php echo $this->Form->input('Deal.quantity_type',array('type'=>'select','label'=>false,'div'=>false, 'class'=>'form-control','options'=>$this->Common->getDealQty())); ?>
			       </section>
			    </div>
			    <div class="form-group clearfix dealQty" style="<?php echo (isset($deal['Deal']['quantity_type']) && $deal['Deal']['quantity_type'] == 1)?'':'display:none';?>">
				<label class="">Deal Quantity*:</label>
    				<section>
				    <?php echo $this->Form->input('Deal.quantity',array('type'=>'text','label'=>false,'div'=>false, 'class'=>'form-control w60','validationmessage'=>'Deal quantity is required.','pattern'=>"^[0-9]+?$" ,'data-pattern-msg'=>'Please enter the valid number.')); ?>
				</section>
			    </div>
			    <div class="form-group clearfix">
				<label class="">Limit per customer*:</label>
				<section>
				    <?php echo $this->Form->input('Deal.limit_per_customer',array('type'=>'select','label'=>false,'div'=>false,'options'=>$this->Common->limitCustomer(),'class'=>'form-control w60','maxlength'=>'10','maxlengthcustom'=>'5','data-maxlengthcustom-msg'=>"Maximum 5 numbers are allowed.",'validationmessage'=>'Limit per customer is required.','required'=>true,'pattern'=>"^[0-9]+?$" ,'data-pattern-msg'=>'Please enter the valid number.')); ?>
				</section>
			    </div>
			    <!--<div class="form-group clearfix">
				<label class="">Maximum Time*:</label>
				<section>
				    <?php //echo $this->Form->input('Deal.max_time',array('type'=>'select','label'=>false,'class'=>'form-control','div'=>false,'options'=>$this->Common->getDealDuration())); ?>
			       </section>
			   </div>-->
				<div class="form-group clearfix">
				<label class="">Deal Close Date*:</label>
				<section>
					<div class="date mrgn-rgt10 w60">
					<?php
					
					   if(isset($this->request->data['Deal']['max_time']) && !empty($this->request->data['Deal']['max_time']) && ($this->request->data['Deal']['max_time'] != 0000-00-00)){
					      $maxdate =  $this->request->data['Deal']['max_time'];
					   }else{
					       $maxdate = $created;
					   }
					   
					?>
				     <?php
				     if($readOnly){
					    echo $this->Form->input('Deal.max_time', array( 'type'=>'text','label' => false, 'div' => false, 'class' => 'form-control disableInput','id'=>'','value'=>$maxdate,'default'=>$maxdate,'data-max'=>$created,'required'=>true,'validationmessage'=>'Deal Close Date is required.','readonly'=>'readonly'));
				     }else{
					 echo $this->Form->input('Deal.max_time', array( 'type'=>'text','label' => false, 'div' => false, 'class' => 'form-control maxTimeCal disableInput','id'=>'maxTimeCal','value'=>$maxdate,'default'=>$maxdate,'data-max'=>$created,'required'=>true,'validationmessage'=>'Deal Close Date is required.','autocomplete'=>'off','style'=>"background:white;"));
				    }
				   
				     ?>
					</div>
				    <?php //echo $this->Form->input('Deal.max_time',array('type'=>'select','label'=>false,'class'=>'form-control','div'=>false,'options'=>$this->Common->getDealDuration())); ?>
			       </section>
			   </div>
			   <div class="form-group clearfix">
				<label class="">Deal Avail Time*:</label>
				<section >
					<div class="date mrgn-rgt10 w60">
					<?php echo $this->Form->input('Deal.avail_time', array( 'type'=>'text','label' => false, 'div' => false, 'class' => 'form-control maxTimeCal disableInput','id'=>'maxAvailTimeCal','required'=>true,'validationmessage'=>'Avail Time is required.','autocomplete'=>'off','style'=>"background:white;")); ?>
					</div>
			       </section>
			   </div>
			   <div class="form-group">
				<label>Offer Available:</label>
                                <section>
				    <?php
                                        $displayofferDays='';
                                        $offerDay =  isset($deal['Deal']['offer_available']) ? $deal['Deal']['offer_available']:0;
                                        if($offerDay==0){
                                                $displayofferDays ='display:none';
                                        }
                                        echo $this->Form->input('Deal.offer_available', array('type' => 'select', 'default'=>$offerDay,'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_offerdays_options())); ?>
                                
                                <div class="clear"></div>
                                <div id="dealwkDays" style="<?php echo $displayofferDays;?>" class="week-days pdng-tp7">
                                        
                                        <div class="col-sm-1">
                                                <?php echo $this->Form->input('Deal.offer_available_weekdays.sun', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1 ">
                                                <?php echo $this->Form->input('Deal.offer_available_weekdays.mon', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'M'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1 ">
                                                <?php echo $this->Form->input('Deal.offer_available_weekdays.tue', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'T'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1">
                                                <?php echo $this->Form->input('Deal.offer_available_weekdays.wed', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'W'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1">
                                                <?php echo $this->Form->input('Deal.offer_available_weekdays.thu', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'T'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1">
                                                <?php echo $this->Form->input('Deal.offer_available_weekdays.fri', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'F'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-1 ">
                                                <?php echo $this->Form->input('Deal.offer_available_weekdays.sat', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control')); ?>
                                        </div>
                                </div>
								<input type="hidden" id="dealwkDcheckRequired" name="dealwkDcheckRequired"   validationmessage="Please select atleast one day." >
								<dfn class="text-danger k-invalid-msg" data-for="dealwkDcheckRequired" role="alert" style="display: none;">Please select atleast one day.</dfn>
                        </section>
                        
		    </div>
			    <div class="form-group ">
				<label>Blackout Dates</label>
				<section>
                                    <div class="nopadding theDates col-sm-12">
					<?php if(isset($deal['Deal']['blackout_dates']) && !empty($deal['Deal']['blackout_dates'])){
					    foreach($deal['Deal']['blackout_dates'] as $dky=> $dates){
					    ?>
					<div class="chkblkD">
					    <div class="date mrgn-rgt10 w60 mrgn-btm10">
						<?php echo $this->Form->input('Deal.blackout_dates.'.($dky+1), array( 'label' => false, 'div' => false,'data-rel'=>($dky+1), 'class' => 'form-control full-w  selBlkOutDates','value'=>$dates,'readonly'=>'readonly','autocomplete'=>'off','style'=>"background:white;")); ?>
					    </div>
					    <div class="lft-p-non col-sm-4"><a class="removeblkdate" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a></div>
					</div>
					<?php }
					} ?>
					
				    </div>
				    <div class="nopadding mainBkD col-sm-12">
					<div class="date mrgn-rgt10 w60">
					    <?php echo $this->Form->input('Deal.blackout_dates.', array( 'label' => false, 'div' => false, 'class' => 'form-control full-w selBlkOutDates','required'=>false,'readonly'=>'readonly','autocomplete'=>'off','style'=>"background:white;")); ?>
					</div>
					<div class="lft-p-non col-sm-4 pdng-tp4">
					    <?php echo $this->Html->link('<i class="fa fa-plus"></i>','javascript:void(0);',array('escape'=>false,'class'=>'addblkdate')); ?>
					</div>
				    </div>
                                </section>
			    </div>
			    <div class="form-group ">
				<label>Restrictions</br><i>(English)</i></label>
				<section>
                                    <?php echo $this->Form->input('Deal.eng_restriction', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2,'maxlengthcustom'=>'200','data-maxlengthcustom-msg'=>"Maximum 200 characters are allowed.",'required'=>false)); ?>
                                </section>
			    </div>
			   
			   <div class="form-group ">
				<label>Restrictions</br><i>(Arabic)</i></label>
				<section>
                                    <?php echo $this->Form->input('Deal.ara_restriction', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control','rows'=>2,'maxlengthcustom'=>'200','data-maxlengthcustom-msg'=>"Maximum 200 characters are allowed.",'required'=>false)); ?>
                                </section>
			    </div>
			  
			</div>
		    </div>
		</div>
       
	    </div>
	    <div class="col-sm-3">
    </div>
</div>
</div>
        <div class="modal-footer pdng20">
	   
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitTheDeal','label'=>false,'div'=>false));?>
            <?php echo $this->Form->button('Cancel',array( 'type'=>'button','label'=>false,'div'=>false, 'class'=>'btn' , 'data-dismiss'=>"modal")); ?>
        </div>
        <?php echo $this->Form->end();
	//exit;
	?>
    </div>
</div>

<script>
    $(document).ready(function(){
      $(document).on('keydown',".disableInput",function(e)
      { 
	  var key = e.charCode || e.keyCode;
	  if(key == 122 || key == 27 )
	      {}
	  else
	      e.preventDefault();
      });
      
      
        $( ".selBlkOutDates" ).datepicker({
	    dateFormat: 'yy-mm-dd',
	    minDate: 0,
	    showOn: "button",
	    buttonImage: "/img/calendar.png",
	    buttonImageOnly: true,
	    onSelect: function(){
		    var myDate = $(this).val();
		    var maxTime = $("#maxAvailTimeCal").val();
		    if (maxTime == undefined || maxTime == "") {
			    $(this).val('');
			    return false;
		    }
		    if(new Date(maxTime) <= new Date(myDate))
		    {
			    alert("Blackout date must be less than Avail time.");
			    $(this).val('');
		    }
	    //$("#dealfromOnline").find('input').trigger('blur');
	    }
	});
	
	//$("#DealListedOnline").on('change',function(){
	//	var value = $(this).val();
	//	itsId = "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'loadAjaxlistedOnline' ,'admin'=>false)); ?>"; 
	//	$("#DealcreateForm").find(".ajaxLoadC").load(itsId+'/'+value+'/deal',function(){
	//	     $( ".datepicker").datepicker({
	//		dateFormat: 'yy-mm-dd',
	//		minDate: 0,
	//		showOn: "both",
	//		buttonImage: "/img/calendar.png",
	//		buttonImageOnly: true,
	//		onSelect: function(selectedDate){
	//		   alert(selectedDate);
	//			//$("#DealListedOnlineStart").find('input').trigger('blur');
	//			//$("#DealListedOnlineEnd").find('input').trigger('blur');
	//			//    if(value=='1'){
	//			//       var date2 =     $(document).find('#DealListedOnlineStart').datepicker('getDate');
	//			//       date2.setDate(date2.getDate()+15);
	//			//       $(".maxTimeCal" ).datepicker("option", "minDate", selectedDate);
	//			//       $(".maxTimeCal" ).datepicker("option", "maxDate", date2);
	//			//    }else if(value=='3'){
	//			//	 var date1 =     $(document).find('#DealListedOnlineStart').datepicker('getDate');
	//			//         date1.setDate(date1.getDate());
	//			//	 $(".maxTimeCal" ).datepicker("option", "minDate", date1);
	//			//	 date2 = $(document).find('#DealListedOnlineEnd').val();
	//			//	if(date2){
	//			//	    var date2 =     $(document).find('#DealListedOnlineEnd').datepicker('getDate');
	//			//	    date2.setDate(date2.getDate());
	//			//	    $(".maxTimeCal" ).datepicker("option", "maxDate", date2);
	//			//	}else{
	//			//	     $("#DealListedOnlineEnd" ).datepicker("option", "minDate", date1);
	//			//	}
	//			//    }else if(value=='2'){
	//			//	 $(".maxTimeCal" ).datepicker("option", "minDate", 0);
	//			//	 $(".maxTimeCal" ).datepicker("option", "maxDate", selectedDate);
	//			//    }
	//		}
	//	     }); 
	//	    //$("document").find('.add_pricingoption').bind('click');
	//	});	
	//
	//});
	
	
	$( "#datepicker" ).datepicker({
	    dateFormat: 'yy-mm-dd',
	    minDate: 0,
	    showOn: "button",
	    buttonImage: "/img/calendar.png",
	    buttonImageOnly: true,
	    onSelect: function(selectedDate){
	         $("#maxTimeCal").val('');
		 //alert(selectedDate);
		 var d = new Date(selectedDate);
		 d.setDate(d.getDate() + 13);
		 //alert(d);
		 selectedDateN = formatDate(d,'y-MM-dd','ist');
		    //alert(selectedDateN);
		   //alert(selectedDate.getTime());
		 $("#maxTimeCal").datepicker("option", "minDate", selectedDate);
		 $("#maxTimeCal").datepicker("option", "maxDate", selectedDateN);
		 $("#dealfromOnline").find('input').trigger('blur');
	    }
	});
	
	
	$( "#maxTimeCal").datepicker({
	    dateFormat: 'yy-mm-dd',
	    minDate: $("#datepicker").val(),
	    maxDate:$("#datepicker").data("max"),
	    showOn: "button",
	    buttonImage: "/img/calendar.png",
	    buttonImageOnly: true,
	    onSelect: function(selectedDate){
	       $("#maxAvailTimeCal").val("");
	       $("#maxAvailTimeCal").datepicker("option", "minDate", selectedDate);
	        $("#maxTimeCal").trigger('blur');
	    }
	});
	
	$( "#maxAvailTimeCal").datepicker({
	    dateFormat: 'yy-mm-dd',
	    minDate: 0,
	    showOn: "button",
	    buttonImage: "/img/calendar.png",
	    buttonImageOnly: true,
	    onSelect: function(){
		 $("#maxAvailTimeCal").trigger('blur');
	    }
	});
	
	
	$(document).find("#DealQuantityType").on('change',function(){
            if($(this).val() == 1){
		$(".dealQty").show();
		$("#DealDealQuantity").attr('required',true);
	    }
	    else{ $(".dealQty").hide(); $("#DealDealQuantity").attr('required',false);
		if($("#DealDealQuantity").next().hasClass('k-invalid-msg')){
		    $("#DealDealQuantity").next().remove();
		}
	    }
        });
	
	$("#DealOfferAvailable").on('change',function(){
	    var value = $(this).val();
	    if(value == 1){
		$("#dealwkDays").show();$('#dealwkDcheckRequired').attr('required',true).val('');
	    }else{
		$("#dealwkDays").hide();$('#dealwkDcheckRequired').attr('required',false).val('');
		if($("#dealwkDcheckRequired").next().hasClass('k-invalid-msg')){
		    $("#dealwkDcheckRequired").next().css('display','none');
		}
	    }
	});
	
	$("#dealwkDays").on('click','input[type=checkbox]',function(){
	    var checked = 0;
	    $("#dealwkDays input[type=checkbox]").each(function(){
		    if($(this).is(':checked')){
			    checked = checked+1;
		    }
	    });
	    if(checked > 0){
		    $('#dealwkDcheckRequired').val('1');
		    $(document).find('dfn[data-for=dealwkDcheckRequired]').css('display','none');
	    }else{
		    $('#dealwkDcheckRequired').val('');
		    $(document).find('dfn[data-for=dealwkDcheckRequired]').css('display','inline');
	    }
	    //alert(checked);
	});
    
    });
    function formatDate(date, format, utc) {
    var MMMM = ["\x00", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var MMM = ["\x01", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var dddd = ["\x02", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var ddd = ["\x03", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    function ii(i, len) {
        var s = i + "";
        len = len || 2;
        while (s.length < len) s = "0" + s;
        return s;
    }
       //date = new Date(date);
	
    var y = utc ? date.getUTCFullYear() : date.getFullYear();
    format = format.replace(/(^|[^\\])yyyy+/g, "$1" + y);
    format = format.replace(/(^|[^\\])yy/g, "$1" + y.toString().substr(2, 2));
    format = format.replace(/(^|[^\\])y/g, "$1" + y);

    var M = (utc ? date.getUTCMonth() : date.getMonth()) + 1;
    format = format.replace(/(^|[^\\])MMMM+/g, "$1" + MMMM[0]);
    format = format.replace(/(^|[^\\])MMM/g, "$1" + MMM[0]);
    format = format.replace(/(^|[^\\])MM/g, "$1" + ii(M));
    format = format.replace(/(^|[^\\])M/g, "$1" + M);

    var d = utc ? date.getUTCDate() : date.getDate();
    format = format.replace(/(^|[^\\])dddd+/g, "$1" + dddd[0]);
    format = format.replace(/(^|[^\\])ddd/g, "$1" + ddd[0]);
    format = format.replace(/(^|[^\\])dd/g, "$1" + ii(d));
    format = format.replace(/(^|[^\\])d/g, "$1" + d);

    var H = utc ? date.getUTCHours() : date.getHours();
    format = format.replace(/(^|[^\\])HH+/g, "$1" + ii(H));
    format = format.replace(/(^|[^\\])H/g, "$1" + H);

    var h = H > 12 ? H - 12 : H == 0 ? 12 : H;
    format = format.replace(/(^|[^\\])hh+/g, "$1" + ii(h));
    format = format.replace(/(^|[^\\])h/g, "$1" + h);

    var m = utc ? date.getUTCMinutes() : date.getMinutes();
    format = format.replace(/(^|[^\\])mm+/g, "$1" + ii(m));
    format = format.replace(/(^|[^\\])m/g, "$1" + m);

    var s = utc ? date.getUTCSeconds() : date.getSeconds();
    format = format.replace(/(^|[^\\])ss+/g, "$1" + ii(s));
    format = format.replace(/(^|[^\\])s/g, "$1" + s);

    var f = utc ? date.getUTCMilliseconds() : date.getMilliseconds();
    format = format.replace(/(^|[^\\])fff+/g, "$1" + ii(f, 3));
    f = Math.round(f / 10);
    format = format.replace(/(^|[^\\])ff/g, "$1" + ii(f));
    f = Math.round(f / 10);
    format = format.replace(/(^|[^\\])f/g, "$1" + f);

    var T = H < 12 ? "AM" : "PM";
    format = format.replace(/(^|[^\\])TT+/g, "$1" + T);
    format = format.replace(/(^|[^\\])T/g, "$1" + T.charAt(0));

    var t = T.toLowerCase();
    format = format.replace(/(^|[^\\])tt+/g, "$1" + t);
    format = format.replace(/(^|[^\\])t/g, "$1" + t.charAt(0));

    var tz = -date.getTimezoneOffset();
    var K = utc || !tz ? "Z" : tz > 0 ? "+" : "-";
    if (!utc) {
        tz = Math.abs(tz);
        var tzHrs = Math.floor(tz / 60);
        var tzMin = tz % 60;
        K += ii(tzHrs) + ":" + ii(tzMin);
    }
    format = format.replace(/(^|[^\\])K/g, "$1" + K);

    var day = (utc ? date.getUTCDay() : date.getDay()) + 1;
    format = format.replace(new RegExp(dddd[0], "g"), dddd[day]);
    format = format.replace(new RegExp(ddd[0], "g"), ddd[day]);

    format = format.replace(new RegExp(MMMM[0], "g"), MMMM[M]);
    format = format.replace(new RegExp(MMM[0], "g"), MMM[M]);

    format = format.replace(/\\(.)/g, "$1");

    return format;
}
  
</script>
