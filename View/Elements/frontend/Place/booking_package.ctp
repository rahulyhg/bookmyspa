<style>
.buk-emp-list { margin-right: 0px; margin-bottom:0px; 	}
.book-stylist{ padding-left:10px;	}
.serviceBukctnt{ position:relative; }
 .book-coupons {
	float: left !important;
	padding-top: 2px;
	font-size: 11px;
    }
</style>

<?php $lang = Configure::read('Config.language'); ?>
<?php
	if($eVoucher == 'true'){
		echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Myaccount','action'=>'bookeVoucherAppnmnt','id'=>'AppointmentPackageForm')));
		echo $this->Form->hidden('Evoucher.id',array('value'=>$eVoucherDetail['Evoucher']['id']));
		echo $this->Form->hidden('Evoucher.salon_id',array('value'=>$eVoucherDetail['Evoucher']['salon_id']));
		echo $this->Form->hidden('Order.id',array('value'=>$eVoucherDetail['Order']['id']));
		echo $this->Form->hidden('Order.eng_service_name',array('value'=>$eVoucherDetail['Order']['eng_service_name']));
		if(isset($deal) && $deal==true){
			echo $this->Form->hidden('Deal.id',array('value'=>$dealData['Deal']['id'],'label'=>false));
			echo $this->Form->hidden('Deal.blackoutDates',array('value'=>json_encode($blkDate),'label'=>false));	
		}
	 }else if($reschedule == 'true'){
		echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Myaccount','action'=>'reschedule','id'=>'AppointmentPackageForm')));
		if(!empty($appointmentDetail['Appointment'])){
			foreach($appointmentDetail['Appointment'] as $appointment){
				echo $this->Form->hidden('Appointment.service.'.$appointment['salon_service_id'].'.appointment_id',array('value'=>$appointment['id']));		
			}
		}
		if(isset($deal) && $deal==true){
			echo $this->Form->hidden('Deal.id',array('value'=>$dealData['Deal']['id'],'label'=>false));
			echo $this->Form->hidden('Deal.blackoutDates',array('value'=>json_encode($blkDate),'label'=>false));	
		}
		echo $this->Form->hidden('Order.salon_id',array('value'=>$appointmentDetail['Order']['salon_id']));
		echo $this->Form->hidden('Order.id',array('value'=>$appointmentDetail['Order']['id']));
		echo $this->Form->hidden('Order.eng_service_name',array('value'=>isset($appointmentDetail['Order']['eng_service_name']) ? $appointmentDetail['Order']['eng_service_name']:''));
		echo $this->Form->hidden('Appointment.salon_id',array('value'=>isset($appointmentDetail['Appointment']['salon_id']) ? $appointmentDetail['Order']['salon_id']:''));
	}else if(isset($deal) && $deal==true){
		echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Deals','action'=>'appointment','id'=>'AppointmentDealForm')));
		echo $this->Form->hidden('quantity',array('value'=>1,'label'=>false));
		echo $this->Form->hidden('deal_id',array('value'=>$dealData['Deal']['id'],'label'=>false));
		echo $this->Form->hidden('Deal.id',array('value'=>$dealData['Deal']['id'],'label'=>false));
		echo $this->Form->hidden('Deal.blackoutDates',array('value'=>json_encode($blkDate),'label'=>false));
	}else{
		echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Packagebooking','action'=>'appointment','id'=>'AppointmentPackageForm')));
		echo $this->Form->hidden('quantity',array('value'=>1,'label'=>false)); 
	}
?>

<?php
    $lastVisited =  $this->Session->read('lastVisited');
    if( !empty($lastVisited)){
        echo $this->Js->link(__('<< Back',true),$lastVisited,array('update' => '#update_ajax','class'=>'backLink'));
    }else{
?>
    <a class="backLink" href="<?php echo $this->request->referer();?>"><< Back</a>
<?php
    }

?>

<div class="big-lft">
	<div class="timer-details clearfix">
		<ul class="clearfix">
			<li>
				<span class="text-main"> 
					<?php
					
					    $leadTime = $packageDetails['SalonServiceDetail']['appointment_lead_time'];
						$leadTimeNew = '';
						if($packageDetails['Package']['type'] == 'Package'){
							if($leadTime < 24){
							  $leadTimeNew = 'day';
							}else{
							  $current = date("D M d Y");
							  $leadTimeNew = date('D M d Y H:i:s', strtotime($current.' + '.$leadTime.' hours'));
							}
							
						}else if($packageDetails['Package']['type'] == 'Spaday'){
							$current = date("D M d Y");
							$leadTime = $leadTime+1;
							$leadTimeNew = date('D M d Y H:i:s', strtotime($current.' + '.$leadTime.' days'));
								
						}
						
						if(isset($deal) && $deal){
							$current = date("D M d Y");
							$leadTimeNew = date('D M d Y H:i:s', strtotime($current.' + '.$leadTime.' hours'));
						  if(!empty($dealData['Deal'][$lang.'_name'])){
							 echo $dealData['Deal'][$lang.'_name']; }
							 if(!$eVoucher){
							    echo '<div id="clock1" class="clock" data-maxtime="'.date('m/d/Y',strtotime($dealData['Deal']['max_time'])).'">[clock]</div>';
							 }
						}else{
							if(!empty($packageDetails['Package'][$lang.'_name'])){
									echo $packageDetails['Package'][$lang.'_name'];
							}else if(!empty($packageDetails['Service'][$lang.'_name'])){
									echo $packageDetails['Service'][$lang.'_name'];
							}else{
									echo $packageDetails['Service']['eng_name'];
							}
						}
						echo $this->Form->hidden('leadTime',array('id'=>'leadTime','value'=>$leadTimeNew));	
					?>
				</span>
		
			</li>
			
			<?php if(isset($deal) && $deal && !$eVoucher){?>
			       <div><?php
				       if($dealData['Deal']['quantity_type'] == 1){
					       $Qty = $dealData['Deal']['quantity'];
					       $purchasedQty = $dealData['Deal']['purchased_quantity'];
					       $remainQty = $Qty - $purchasedQty;
					       if($remainQty > 0){
						       echo '<li style="float:right">
							       <span class="text-main"><div>';
						       echo $remainQty." Qty Remaining";
						       echo '</div></span>
							   </li>';
					       }
					       echo $this->Form->hidden('remainQty',array('value'=>$remainQty,'label'=>false));
				       }?>
				       </div>
			<?php } ?>
			  
		</ul>
		 
		 <?php if(isset($deal) && $deal && !$eVoucher){?>
			<script language="javascript">
			    var Maxlimit = '<?php echo date('m/d/Y',strtotime($dealData['Deal']['max_time'])); ?>';
				var currDate = new Date();
				var cd1  		  = new countdown('cd1');
				cd1.Div           = "clock1";
				cd1.TargetDate    = Maxlimit;
				cd1.DisplayFormat = "%%D%% Days : %%H%% Hours : %%M%% minutes : %%S%% seconds left";
				cd1.Setup();
			</script>
		 <?php } ?>
	  </div>
	  
	  
	  
	  
	<div class="deal-box-outer">
		<?php if(!empty($packageDetails['PackageService'])){ ?>
		    <div class="gallery">
			<!--<ul class="lightSlider" id="servicelightSlider">
				<?php //foreach($packageDetails['PackageImage'] as $image) { 
					//echo "<li data-thumb='/images/Service/150/".$image['image']."'>".$this->Html->image('/images/Service/500/'.$image['image']) ."</li>";
				//} ?>
			</ul>-->
			
			<?php //if(!empty($packageDetails['PackageImage'])){ ?>
			<ul class="bxslider">
				<?php foreach($packageDetails['PackageService'] as $packageService) {
                                       $images = $this->Common->getAllserviceImage($packageService['salon_service_id']);
                                       if(!empty($images)){
                                            foreach($images as $image){
                                            ?>
                                                <li><?php echo $this->Html->image('/images/Service/800/'.$image); ?></li>
                                            <?php
                                            }
                                       }else{
                                            echo "No images found";
                                       }
                                 } ?>
			
                        </ul>
		  
			<div id="bx-pager">
                        <?php
                            $i=0;
                        foreach($packageDetails['PackageService'] as $packageService) {
                                       $images = $this->Common->getAllserviceImage($packageService['salon_service_id']);
                                       if(!empty($images)){
                                            foreach($images as $image){
                                            ?>
                                            <a data-slide-index="<?php echo $i;?>" href="javascript:void(0);"><?php echo $this->Html->image('/images/Service/150/'.$image); ?></a>
                                            <?php
                                                $i++;
                                            }
                                       }else{
                                            echo "No images found";
                                       }
                                 } ?>
			</div>

		</div>
                
                <!--<div class="thumbnail clearfix"></div>-->
		<?php } ?>
                
		<div class="share-specific-deal clearfix">
			<ul class="share-icon-set">
				<li>Share this <?php echo (isset($deal) && $deal)?'Deal':'Package';?></li>
				<li><a href="#" class="msz"></a></li>
				<li><a href="#" class="fb"></a></li>
				<li><a href="#" class="tweet"></a></li>
				<li><a href="#" class="google"></a></li>
			</ul>
		</div>
	</div>
	
	<div class="specific-service-details">
		<h2 class="share-head"><?php echo __('in_nutshell');?></h2>
		<p>
		<?php
			if(isset($deal) && $deal){
				//pr($dealData);
				if(!empty($dealData['Deal'][$lang.'_description'])){
					 echo $dealData['Deal'][$lang.'_description'];
				  }else{
					echo $dealData['Deal']['eng_description'];
				  }
			}else{
				if(!empty($packageDetails['Package'][$lang.'_description'])){
					echo $packageDetails['Package'][$lang.'_description'];
				}else{
					echo $packageDetails['Package']['eng_description'];
				}
			}
		?>
                </p>
		<h2 class="share-head"><?php echo __('choose_following');?></h2>
		<ul class="specific-description">
			<?php
			
			if(isset($deal) && $deal){
				$packagePricingOption = array();
				foreach($dealData['DealServicePackage'] as $thePriceOpt){
					foreach($thePriceOpt['DealServicePackagePriceOption'] as $pacakgePriceOpt){
					//if($pacakgePriceOpt['price'] != 0){
							$packagePricingOption[$pacakgePriceOpt['option_id']]['service'][$thePriceOpt['salon_service_id']]= $this->Common->get_salon_service_name($thePriceOpt['salon_service_id']);
							$packagePricingOption[$pacakgePriceOpt['option_id']]['priceId'][] = $pacakgePriceOpt['id'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['option_duration'][]= $pacakgePriceOpt['duration'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['option_price'][] = (!empty($pacakgePriceOpt['sell_price']) ? $pacakgePriceOpt['sell_price'] : $pacakgePriceOpt['full_price']);
							$packagePricingOption[$pacakgePriceOpt['option_id']]['duration']= isset($packagePricingOption[$pacakgePriceOpt['option_id']]['duration']) ? $packagePricingOption[$pacakgePriceOpt['option_id']]['duration'] + $pacakgePriceOpt['duration'] :$pacakgePriceOpt['duration'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['price']= $pacakgePriceOpt['deal_price'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['originalprice']= !empty($pacakgePriceOpt['sell_price']) ? $pacakgePriceOpt['sell_price'] : $pacakgePriceOpt['full_price'];
							if(!empty($pacakgePriceOpt['eng_custom_title'])){
								$packagePricingOption[$pacakgePriceOpt['option_id']]['custom_title_eng']= $pacakgePriceOpt['eng_custom_title'];
								$packagePricingOption[$pacakgePriceOpt['option_id']]['custom_title_eng']= $pacakgePriceOpt['ara_custom_title'];    
							}
					}
				}
				//pr($packagePricingOption);
			}else{
				$packagePricingOption = array();
				foreach($packageDetails['PackageService'] as $thePriceOpt){
					foreach($thePriceOpt['PackagePricingOption'] as $pacakgePriceOpt){
						if($pacakgePriceOpt['price'] != 0){
							$packagePricingOption[$pacakgePriceOpt['option_id']]['service'][$thePriceOpt['salon_service_id']]= $this->Common->get_salon_service_name($thePriceOpt['salon_service_id']);
						}
							$packagePricingOption[$pacakgePriceOpt['option_id']]['priceId'][] = $pacakgePriceOpt['id'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['option_duration'][]= $pacakgePriceOpt['duration'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['option_price'][]= $pacakgePriceOpt['price'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['duration']= $pacakgePriceOpt['option_duration'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['price']= $pacakgePriceOpt['option_price'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['originalprice']= $pacakgePriceOpt['option_price'];
						if(!empty($pacakgePriceOpt['custom_title_eng'])){
							$packagePricingOption[$pacakgePriceOpt['option_id']]['custom_title_eng']= $pacakgePriceOpt['custom_title_eng'];
							$packagePricingOption[$pacakgePriceOpt['option_id']]['custom_title_ara']= $pacakgePriceOpt['custom_title_ara'];    
						}
					}
				}
			}
			
		//pr($packagePricingOption);
		//pr($packagePricingOption);      
		//die();
		if(!empty($packagePricingOption)){
			foreach($packagePricingOption as $option){
				
				?>
			<li><i class="fa fa-caret-right"></i><span><?php echo __('AED',true);?> <?php echo ($option['price']); ?> <?php echo __('for',true);?>
			<?php
			$priceDuration['duration'] = $option['duration'];
			$priceDuration['maxduration'] = '';
			$maxduration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
			$duration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
			if($priceDuration['duration'] < 60){
			    $duration = '%02d '.__('mins',true);
			}
			if($priceDuration['maxduration'] < 60){
			    $maxduration = '%02d '.__('mins',true);
			} ?>
			<?php echo $this->Common->convertToHoursMins($priceDuration['duration'], $duration);?> <?php echo !empty($priceDuration['maxduration']) ? '- '.$this->Common->convertToHoursMins($priceDuration['maxduration'], $maxduration): '' ?>
			
			<?php if(isset($option['custom_title_eng'])){
				echo $option['custom_title_eng'];
			}?>
					</br><b><?php echo __('service',true);?></b>
			<ul>
				<?php if(!empty($option['service'])){
					foreach($option['service'] as $service){
						echo "<li>".$service."</li>";
					}
				}
							?>
			</ul>
                         </span>
				</li>
                                <?php
                            }
                        }                        
                        
                        ?>
		</ul>
	</div>
	
	<div class="specific-service-details">
		<h2 class="share-head"><?php echo __('The_fine_print',true);?></h2>
		<?php
			if(isset($deal) && $deal){
					if($dealData['Deal']['listed_online'] && $dealData['Deal']['listed_online'] > 1){?>
					<p><span><?php echo __('Validity',true);?>:</span> Sieasta <?php echo __('valid_until',true);?> <?php echo date('d.m.Y',strtotime($dealData['Deal']['listed_online_end'])); ?>.</p>
					<?php } ?>
					<?php  if(!empty($dealData['Deal'][$lang.'_restriction'])){?>
						<p><span><?php echo __('Restriction',true);?>:</span> <?php echo $dealData['Deal'][$lang.'_restriction']; ?></p>
					<?php }else{ ?>
						<p><span><?php echo __('Restriction',true);?>:</span> <?php echo (!empty($dealData['Deal']['eng_restriction']))?$dealData['Deal']['eng_restriction']:__('NA',true); ?></p>
					<?php }?>
					<?php  if(!empty($dealData['Deal'][$lang.'_good_to_know'])){?>
						<p><span><?php echo __('good_to_know',true);?>:</span> <?php echo $dealData['Deal'][$lang.'_good_to_know']; ?></p>
					<?php }else{ ?>
						<p><span><?php echo __('good_to_know',true);?>:</span> <?php echo (!empty($dealData['Deal']['eng_good_to_know']))?$dealData['Deal']['eng_good_to_know']:__('NA',true); ?></p>
					<?php }
					if(!empty($policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy'])){?>
					<p><span><?php echo __('cancel_policy',true);?>:</span> <?php echo $policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']; ?></p>
					<?php }else{ ?>
						<p><span><?php echo __('cancel_policy',true);?>:</span> <?php echo (!empty($policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']))?$policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']:__('NA',true); ?></p>
					<?php } ?>
					<?php	if(!empty($policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy'])){?>
						<p><span><?php echo __('reschedule_policy',true);?>:</span> <?php echo $policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']; ?></p>
					<?php }else{ ?>
						<p><span><?php echo __('reschedule_policy',true);?>:</span> <?php echo (!empty($policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']))?$policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']:__('NA',true); ?></p>
					<?php } ?>
					<?php if($dealData['Deal']['avail_time']){  ?>
						<p><span><?php echo __('Expires on',true);?>:</span> <?php echo date('d F Y',strtotime($dealData['Deal']['avail_time'])); ?></p>
					<?php } ?>
					<?php 
					if(!empty($dealData['Deal']['blackout_dates'])){
						$blkDateNew = unserialize($dealData['Deal']['blackout_dates']);
						foreach($blkDateNew as $theBk=>$bkdat){
						    $blkDateNew[$theBk] = date('d F Y',$bkdat);
						}
					?>
					<p><span><?php echo __('Deal not valid on',true);?>:</span> <?php echo implode(', ' ,$blkDateNew); ?></p>
					<?php } ?>
					
					<?php
					if($dealData['Deal']['type'] == 'Spaday'){ ?>
					<p><span><?php echo __('check_in',true);?>:</span> <?php echo $dealData['Deal']['check_in']; ?></p>
					<p><span><?php echo __('check_out',true);?>:</span> <?php echo $dealData['Deal']['check_out']; ?></p>
					<?php } 
			 }else{
					if($packageDetails['SalonServiceDetail']['listed_online'] && $packageDetails['SalonServiceDetail']['listed_online'] > 1){?>
					<p><span><?php echo __('Validity',true);?>:</span> Sieasta <?php echo __('valid_until',true);?> <?php echo date('d.m.Y',strtotime($packageDetails['SalonServiceDetail']['listed_online_end'])); ?>.</p>
					<?php } ?>
					<?php  if(!empty($packageDetails['Package'][$lang.'_restriction'])){?>
						<p><span><?php echo __('Restriction',true);?>:</span> <?php echo $packageDetails['Package'][$lang.'_restriction']; ?></p>
					<?php }else{ ?>
						<p><span><?php echo __('Restriction',true);?>:</span> <?php echo (!empty($packageDetails['Package']['eng_restriction']))?$packageDetails['Package']['eng_restriction']:__('NA',true); ?></p>
					<?php }?>
					<?php  if(!empty($packageDetails['Package'][$lang.'_good_to_know'])){?>
						<p><span><?php echo __('good_to_know',true);?>:</span> <?php echo $packageDetails['Package'][$lang.'_good_to_know']; ?></p>
					<?php }else{ ?>
						<p><span><?php echo __('good_to_know',true);?>:</span> <?php echo (!empty($packageDetails['Package']['eng_good_to_know']))?$packageDetails['Package']['eng_good_to_know']:__('NA',true); ?></p>
					<?php }if(!empty($policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy'])){?>
					<p><span><?php echo __('cancel_policy',true);?>:</span> <?php echo $policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']; ?></p>
					<?php }else{ ?>
						<p><span><?php echo __('cancel_policy',true);?>:</span> <?php echo (!empty($policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']))?$policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']:__('NA',true); ?></p>
					<?php	if(!empty($policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy'])){?>
						<p><span><?php echo __('reschedule_policy',true);?>:</span> <?php echo $policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']; ?></p>
					<?php }else{ ?>
						<p><span><?php echo __('reschedule_policy',true);?>:</span> <?php echo (!empty($policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']))?$policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']:__('NA',true); ?></p>
					<?php } ?>
					<?php } if($packageDetails['Package']['type'] == 'Spaday'){ ?>
					
					<p><span><?php echo __('check_in',true);?>:</span> <?php echo $packageDetails['Package']['check_in']; ?></p>
					<p><span><?php echo __('check_out',true);?>:</span> <?php echo $packageDetails['Package']['check_out']; ?></p>
					<?php } 	
				
			}
		?>
		
                
	</div>
</div>

<div class="fixed-rgt soldOptions">
        	<div role="tabpanel" class="tabs">
            	<ul class="nav nav-tabs ulopts" role="tablist">
                	<?php
					$giftCheck = $buyCheck = true;
					if($packageDetails['SalonServiceDetail']['sold_as'] == 1){ $giftCheck = false;}
					if($packageDetails['SalonServiceDetail']['sold_as'] == 2){ $buyCheck = false;}
						if($eVoucher == 'true'){
							$giftCheck = $buyCheck = false; ?>
							<li role="presentation">
							<a   href="#evoucher" aria-expanded="true" href="javascript:void(0);" aria-controls="evoucher" role="tab" data-toggle="tab"><?php echo __('buk_app',true); ?></a>
							</li>
							<?php
						}
						if(!empty($deal) && $deal){
						   //$buyCheck = false;	
						}
						if($reschedule == 'true'){
							$giftCheck = $buyCheck = false;
							?>
							<li role="presentation">
							<a   href="#reschedule" aria-expanded="true" href="javascript:void(0);" aria-controls="reschedule" role="tab" data-toggle="tab"><?php echo __('resch_appntmnt',true); ?></a>
							</li>
						<?php }else{
							
						 if($buyCheck){ ?>
						<li role="presentation">
							<a   href="#bookappointment" aria-expanded="true" href="javascript:void(0);" aria-controls="bookappointment" role="tab" data-toggle="tab"><?php echo __('buk_app',true); ?></a>
						</li>
						<?php }
						if($giftCheck){ ?>
						<li role="presentation">
							<a  href="#buygift" aria-controls="buygift" role="tab" data-toggle="tab"><?php echo __('buy_gift_ev',true); ?></a>
						</li>
						<?php } 	
						}
						?>
                </ul>
            </div>
            <div class="tab-content min-hgt360 clearfix">
			<?php if($buyCheck){ ?>
			<div role="tabpanel" class="tab-pane" id="bookappointment">
				<span class="offerOn" style="display: none"><?php
				
				if(isset($deal) && $deal){
						if($dealData['Deal']['offer_available'] == 1){
							$offerOn = array_filter(unserialize($dealData['Deal']['offer_available_weekdays']));
							if(!empty($offerOn)){
								echo implode(',',array_keys($offerOn));
							}
						}else{
							echo "sun,mon,tue,wed,thu,fri,sat";
						}
					}else{
						if($packageDetails['SalonServiceDetail']['offer_available']){  $offerOn = array_filter(unserialize($packageDetails['SalonServiceDetail']['offer_available_weekdays']));
							if(!empty($offerOn)){
								echo implode(',',array_keys($offerOn));
							}
						}else{
							echo "sun,mon,tue,wed,thu,fri,sat";
						}
					} ?></span>

				<div class="list-group pricing-list allPriceOpt" >
                
					<?php
					 
					$durationArray = $this->common->get_duration();
					if(count($packagePricingOption) > 1){
						$priceotion = true;
					}
						?>
					<a href="javascript:void(0);" class="list-group-item no-hover">
						<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('select_opt',true); ?></h4>
					</a>
					<?php
					
				      foreach($packagePricingOption as $key=>$thePriceOpt){
						
						?>
						<?php
							$services = implode(',',array_flip($thePriceOpt['service']));
							$price = $thePriceOpt['price'];
							$originalprice = $thePriceOpt['originalprice'];
							$save = ($thePriceOpt['originalprice']-$thePriceOpt['price'])/$thePriceOpt['originalprice'] * 100;
							$priceooId  = $key;
							$priceooId = implode('-',$thePriceOpt['priceId']);
							$durationM = $thePriceOpt['duration'];
							$optionDuration = implode(',',$thePriceOpt['option_duration']);
							$optionPrice = implode(',',$thePriceOpt['option_price']);
							//$optionDuration = $thePriceOpt['option_duration'];
							//$optionPrice = $thePriceOpt['option_price'];
							//$customTitle = $thePriceOpt['custom_title_'.$lang];
							$maxduration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
							$duration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
							if($durationM < 60){
								$duration = '%02d '.__('mins',true);
							}
						?>
					<a href="javascript:void(0);" class="list-group-item priceOpt-here" data-priceID="<?php echo $priceooId; ?>" data-price="<?php echo $price; ?>" data-option-duration="<?php echo $optionDuration; ?>" data-services="<?php echo $services;?>">
						<span class="badge"><?php echo __('AED',true);?> <?php echo $price; ?>
							<?php if($save > 0){?>
								<span class="save"><?php echo __('Save',true); ?> <?php echo round($save,2);?>%</span>
							<?php }?>
						</span>
						<h4 class="list-group-item-heading">
						<?php  if(!empty($thePriceOpt['custom_title_'.$lang])){
								echo ucfirst($thePriceOpt['custom_title_'.$lang]);
							}else if(!empty($thePriceOpt['custom_title_eng'])){
								echo ucfirst($thePriceOpt['custom_title_eng']);
							}else{
								echo "Option ".$key;	
							}?>
						</h4>
						<p class="list-group-item-text">
						  <i class="fa fa-clock-o"></i>
						  <span class="text"> <?php  echo $this->Common->convertToHoursMins($durationM, $duration); ?> </span>
					  </p>
					</a>
					<?php } ?>
					
					<?php
					//}?>

                </div>
                <div class="PackageServices"></div>
				<div class="chooseBookingType list-group pricing-list" style="display:none">
					<a href="javascript:void(0);" class="list-group-item no-hover" data-type="">
						<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('select_opt',true); ?></h4>
					</a>
					<a href="javascript:void(0);" class="list-group-item" data-type="manual">
						</span>
						<h4 class="list-group-item-heading">
						     Manual staff selection
						</h4>
					</a>
					<a href="javascript:void(0);" class="list-group-item" data-type="automatic">
						</span>
						<h4 class="list-group-item-heading">
							Automatic staff selection
						</h4>
					</a>
				</div>
				<!--$packagePricingOption -->
				<div class='cal-sec widgetPackageCalendar <?php echo (isset($priceotion))?'disabled':''; ?>' style="display: none"></div>
				<?php if(!empty($packagePricingOption)){
					  foreach($packagePricingOption as $optionId => $options){ 
				?>
					<div class="packgServc list-group pricing-list" style="display:none" id="option_<?php echo implode('-',$options['priceId']); ?>">
						<a href="javascript:void(0);" class="list-group-item no-hover" data-type="">
							<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i>Package includes</h4>
						</a>
						<?php if(!empty($options['service'])){
							   $i=0;
							 foreach($options['service'] as $serviceID=>$packService){
						?>
						<a href="javascript:void(0);" id="<?php echo $serviceID ?>" data-option-duration="<?php echo $options['option_duration'][$i]?>" class="list-group-item" data-type="serviceSelect" style="display:none">
							
							<h4 class="list-group-item-heading">
								 <?php echo $packService; ?>
							</h4>
							<span class="badge"></span>
							<p class='list-group-item-text'></p>
						</a>
						
						<div class='stylistListData  buk-emp-list' style="display:none"  id="stafFor_<?php echo $serviceID ?>">
								<div style="display: none; position: relative;" class="loader-container" id="ajax_modal">
									<div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
								</div>
								<div class="allStylistHere"></div>
						</div>
						<?php $i++; } } ?>
					</div>
				<?php }} ?>
				
				<div class="serviceBukctnt">
					<div class="centering-wrapper">
						<div class="save" style="display: none">
							<span><?php echo __('you_save',true); ?></span>
							<strong><?php echo __('AED',true); ?><span class="DSPrice" style="display: none">0</span></strong>
						</div>
						<div class="pay tp-space">
							<span><?php echo __('Total',true); ?></span>
							<strong>
								<span class="enabled"><?php echo __('AED',true); ?><span class="Sprice"  style="display: none" ></span></span>
							</strong>
						</div>
						<div class="discount-type" style="display: none"><?php echo __('sale_price',true); ?></div>
						<div class="book-coupons">Coupons are applied after clicking on book now and before making payments online</div>

					</div>
					<a href="javascript:void(0);" class="action disabled" data-type="appointment" data-login_val="package">
						<span class="appointment"><?php echo __('Book',true); ?></span>
					</a>
				</div>
		</div>
            <?php } ?>
			<?php if($giftCheck){ ?>
			<div role="tabpanel" class="tab-pane" id="buygift">
				<div class="list-group pricing-list allPriceOpt">
					<?php
						$durationArray = $this->common->get_duration();
						if(count($packagePricingOption) > 1){
							$priceotion = true;
						}
					?>
					<a href="javascript:void(0);" class="list-group-item no-hover">
						<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('select_opt',true); ?></h4>
					</a>
					<?php foreach($packagePricingOption as $key=>$thePriceOpt){ ?>
					<?php
						//pr($thePriceOpt);
						$price = $thePriceOpt['price'];
						$originalprice = $thePriceOpt['originalprice'];
						$save = ($thePriceOpt['originalprice']-$thePriceOpt['price'])/$thePriceOpt['originalprice'] * 100;
						$durationM = $thePriceOpt['duration'];
						$priceooId = implode('-',$thePriceOpt['priceId']);
						//pr($thePriceOpt);
						//$customTitle = $thePriceOpt['custom_title_'.$lang];
						$maxduration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
						$duration = '%02d '.__('hrs',true).' %02d '.__('mins',true);
						if($durationM < 60){
							$duration = '%02d '.__('mins',true);
						}
					?>
					<a href="javascript:void(0);" class="list-group-item  priceOpt-here" data-priceID="<?php echo $priceooId;?>" data-price="<?php echo $price; ?>" >
						<span class="badge"><?php echo __('AED',true);?> <?php echo $price; ?>
							<?php if($save > 0){?>
								<span class="save"><?php echo __('Save',true); ?> <?php echo round($save,2);?>%</span>
							<?php }?>
						</span>
						<h4 class="list-group-item-heading">
						<?php  if(!empty($thePriceOpt['custom_title_'.$lang])){
								echo ucfirst($thePriceOpt['custom_title_'.$lang]);
							}else if(!empty($thePriceOpt['custom_title_eng'])){
								echo ucfirst($thePriceOpt['custom_title_eng']);
							}else{
								echo "Option ".$key;	
							} ?>
						</h4>
						<p class="list-group-item-text">
						  <i class="fa fa-clock-o"></i>
						  <span class="text"> <?php  echo $this->Common->convertToHoursMins($durationM, $duration); ?> </span>
					  </p>
					</a>
					<?php } ?>
					
					<?php
					//}?>

                </div>
				<div class="list-group pricing-list ">
					<a href="javascript:void(0);" class="list-group-item no-hover evoucher clearfix bod-btm-non">
					  <h4 class="list-group-item-heading"><i class="fa fa-ticket"></i> <?php echo __('eVoucher_details',true);?></h4>
					</a>
					<div class="cal-sec only-info">
						<ul class="clearfix">
							<?php $dayArray = array('sun','mon','tue','wed','thu','fri','sat' );?>
							<?php
								if(isset($deal) && $deal){
										if($dealData['Deal']['offer_available']){
										$offerOn = unserialize($dealData['Deal']['offer_available_weekdays']);
										
										foreach($dayArray  as $theDfortick){ ?>
											<li><a href="javascript:void(0);"><?php echo __(ucfirst($theDfortick),true);?><span class="fa <?php echo ($offerOn[$theDfortick])? 'fa-check' : 'fa-minus' ;?>"></span></a></li>
										<?php }	
									}else{
										foreach($dayArray  as $theDfortick){?>
										<li><a href="javascript:void(0);"><?php echo __(ucfirst($theDfortick),true);?><span class="fa fa-check"></span></a></li>
									<?php }
									}
									
									
								}else{
								
									if($packageDetails['SalonServiceDetail']['offer_available']){
										$offerOn = unserialize($packageDetails['SalonServiceDetail']['offer_available_weekdays']);
										
										foreach($dayArray  as $theDfortick){ ?>
											<li><a href="javascript:void(0);"><?php echo __(ucfirst($theDfortick),true);?><span class="fa <?php echo ($offerOn[$theDfortick])? 'fa-check' : 'fa-minus' ;?>"></span></a></li>
										<?php }	
									}else{
										foreach($dayArray  as $theDfortick){?>
										<li><a href="javascript:void(0);"><?php echo __(ucfirst($theDfortick),true);?><span class="fa fa-check"></span></a></li>
									<?php }
									}
									
								}
							?>
						</ul>
					</div>
				 </div>
				<div class="buk-emp-list">
				<p><?php  echo $this->Common->getEvoucherPolicy($salonId);  ?></p>
				<div class="clearfix pos-rgt expiry-box">
					<h4 class="pos-rgt"><?php echo __('eVoucher_expires',true);?>:</h4>
					<div class="">
					<?php
						if(isset($deal) && $deal){
							echo $this->Common->getEvoucherExpiry($packageDetails['Package']['id'],$salonId,2,$dealData['Deal']['id']);	
						}else{
							echo $this->Common->getEvoucherExpiry($packageDetails['Package']['id'],$salonId,2);	
						}
					?>
					</div>
				</div>
				<div class="clearfix pos-rgt expiry-box">
					<h4 class="pos-rgt tp-p-10"><?php echo __('Quantity',true);?>:</h4>
					<div class="">
					<?php echo $this->Form->input('quantity',array('id'=>'selQty','class'=>'w100','label'=>false,'options'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'))); ?>  
					</div>
				</div>
			</div>
				<div class="serviceBukctnt">
					<div class="centering-wrapper">
						<div class="save" style="display: none">
							<span><?php echo __('you_save',true); ?></span>
							<strong><?php echo __('AED',true); ?><span class="DSPrice" style="display: none;">0</span></strong>
						</div>
						<div class="pay tp-space">
							<span><?php echo __('Total',true); ?></span>
							<strong>
								<span class="enabled"><?php echo __('AED',true); ?><span class="Sprice"  style="display: none;"></span></span>
							</strong>
						</div>
						<div class="discount-type" style="display: none"><?php echo __('sale_price',true); ?></div>
						<div class="book-coupons">Coupons are applied after clicking on book now and before making payments online</div>

					</div>
					<?php
					$maxTime= '';
					if(isset($deal) && $deal){
						//pr($maxTime);
						$maxTime =  $dealData['Deal']['max_time'];
					} ?>
					<a href="javascript:void(0);" class="action disabled" data-maxtime="<?php echo $maxTime; ?>" data-type="eVoucher" data-login_val="package">
					  <span class="appointment"><?php echo __('Buy',true); ?></span>
					</a>
				</div>
			</div>
			<?php }elseif($eVoucher == 'true'){?>
			
			 <div role="tabpanel" class="tab-pane" id="evoucher">
				<span class="offerOn" style="display: none">
				
				<?php
					if(isset($deal) && $deal){
						if($dealData['Deal']['offer_available'] == 1){
							$offerOn = array_filter(unserialize($dealData['Deal']['offer_available_weekdays']));
							if(!empty($offerOn)){
								echo implode(',',array_keys($offerOn));
							}
						}else{
							echo "sun,mon,tue,wed,thu,fri,sat,sun";
						}
					}else{
						if($packageDetails['SalonServiceDetail']['offer_available'] == 1){
							$offerOn = array_filter(unserialize($dealData['SalonServiceDetail']['offer_available_weekdays']));
							if(!empty($offerOn)){
								echo implode(',',array_keys($offerOn));
							}
						}else{
							echo "sun,mon,tue,wed,thu,fri,sat,sun";
						}
					}
				?></span>

				<div class="list-group pricing-list allPriceOpt" >
				
                 <?php
					if(count($packagePricingOption) > 1){
						$priceotion = true;
					}
				    $price = 0;
					$duration1 = 0;
					//pr($eVoucherDetail['Order']['OrderDetail']);
					if(!empty($eVoucherDetail['Order']['OrderDetail'])){
					   $price = $eVoucherDetail['Order']['OrderDetail'][0]['option_price'];
					   $duration1 = $eVoucherDetail['Order']['OrderDetail'][0]['option_duration'];
					}
					$durationM = '%02d '.__('hrs',true).' %02d '.__('mins',true);
						if($duration1 < 60){
							$durationM = '%02d '.__('mins',true);
						}
					?>
					<?php
						
						$priceIDs = array();
						$services = array();
						$duration = array();
						if(!empty($eVoucherDetail['Order']['OrderDetail'])){
							foreach($eVoucherDetail['Order']['OrderDetail'] as $optionId => $options){
								$priceIDs[]= $options['price_option_id'];
								$services[]= $options['service_id'];
								$duration[]= $options['duration'];
							}
						}
						//pr($services);
						//pr($priceIDs);
						//pr($duration);
					?>
					
					<a href="javascript:void(0);" class="list-group-item priceOpt-here selectedPrice" data-priceid="<?php echo implode('-',$priceIDs); ?>" data-price="<?php echo $price; ?>" data-option-duration="<?php echo implode(',',$duration); ?>" data-services="<?php echo implode(',',$services); ?>">
						<span class="badge"><?php echo __('AED',true);?> <?php echo $price; ?>
						</span>
						<h4 class="list-group-item-heading">
						<?php  
								echo "Option ";	
						?>
						</h4>
						<p class="list-group-item-text">
						  <i class="fa fa-clock-o"></i>
						  <span class="text"> <?php  echo $this->Common->convertToHoursMins($duration1, $durationM); ?> </span>
					  </p>
					</a>
				
                </div>
			 <div class="PackageServices"></div>
				<div class="chooseBookingType list-group pricing-list">
					<a href="javascript:void(0);" class="list-group-item no-hover" data-type="">
						<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('select_opt',true); ?></h4>
					</a>
					<a href="javascript:void(0);" class="list-group-item" data-type="manual">
						</span>
						<h4 class="list-group-item-heading">
						     Manual staff selection
						</h4>
					</a>
					<a href="javascript:void(0);" class="list-group-item" data-type="automatic">
						</span>
						<h4 class="list-group-item-heading">
							Automatic staff selection
						</h4>
					</a>
				</div>
				<!--$packagePricingOption -->
				<div class='cal-sec eVoucherCal widgetPackageCalendar <?php echo (isset($priceotion))?'disabled':''; ?>' style="display: none"></div>
					
					<div class="packgServc list-group pricing-list" style="display:none" id="option_<?php echo implode('-',$priceIDs); ?>">
						<a href="javascript:void(0);" class="list-group-item no-hover" data-type="">
							<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i>Package includes</h4>
						</a>
						<?php
					if(!empty($eVoucherDetail['Order']['OrderDetail'])){
						//pr($options);
						  foreach($eVoucherDetail['Order']['OrderDetail'] as $optionId => $options){ 
					?>
						<a href="javascript:void(0);" id="<?php echo $options['service_id']; ?>" data-option-duration="<?php echo $options['option_duration'];?>" class="list-group-item" data-type="serviceSelect" style="display:none">
							
							<h4 class="list-group-item-heading">
								 <?php echo $options['eng_service_name']; ?>
							</h4>
							<span class="badge"></span>
							<p class='list-group-item-text'></p>
						</a>
						
						<div class='stylistListData  buk-emp-list' style="display:none"  id="stafFor_<?php echo $options['service_id']; ?>">
								<div style="display: none; position: relative;" class="loader-container" id="ajax_modal">
									<div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
								</div>
								<div class="allStylistHere"></div>
						</div>
						
						<?php } ?>
					
				<?php 
				} ?>
				</div>
				<div class="serviceBukctnt">
					<div class="centering-wrapper">
						<div class="save" style="display: none">
							<span><?php echo __('you_save',true); ?></span>
							<strong><?php echo __('AED',true); ?><span class="DSPrice" style="display: none">0</span></strong>
						</div>
						<div class="pay tp-space">
							<span><?php echo __('Total',true); ?></span>
							<strong>
								<span class="enabled"><?php echo __('AED',true); ?><span class="Sprice"  style="display: none" ></span></span>
							</strong>
						</div>
						<div class="discount-type" style="display: none"><?php echo __('sale_price',true); ?></div>
						<div class="book-coupons">Coupons are applied after clicking on book now and before making payments online</div>

					</div>
					<a href="javascript:void(0);" class="action disabled" data-type="appointment" data-login_val="package">
						<span class="appointment"><?php echo __('Book',true); ?></span>
					</a>
				</div>
		</div>
			<?php }elseif($reschedule == 'true') {?>
			
			
			 <div role="tabpanel" class="tab-pane" id="reschedule">
				<span class="offerOn" style="display: none"><?php
				if(isset($deal) && $deal){
						if($dealData['Deal']['offer_available'] == 1){
							$offerOn = array_filter(unserialize($dealData['Deal']['offer_available_weekdays']));
							if(!empty($offerOn)){
								echo implode(',',array_keys($offerOn));
							}
						}else{
							echo "sun,mon,tue,wed,thu,fri,sat,sun";
						}
					}else{
						if($packageDetails['SalonServiceDetail']['offer_available'] == 1){
							$offerOn = array_filter(unserialize($dealData['SalonServiceDetail']['offer_available_weekdays']));
							if(!empty($offerOn)){
								echo implode(',',array_keys($offerOn));
							}
						}else{
							echo "sun,mon,tue,wed,thu,fri,sat,sun";
						}
				} ?></span>

				<div class="list-group pricing-list allPriceOpt" >
				
                 <?php
					if(count($packagePricingOption) > 1){
						$priceotion = true;
					}
				    $price = 0;
					$duration1 = 0;
					//pr($eVoucherDetail['Order']['OrderDetail']);
					if(!empty($appointmentDetail['OrderDetail'])){
					   $price = $appointmentDetail['OrderDetail'][0]['option_price'];
					   $duration1 = $appointmentDetail['OrderDetail'][0]['option_duration'];
					}
					$durationM = '%02d '.__('hrs',true).' %02d '.__('mins',true);
						if($duration1 < 60){
							$durationM = '%02d '.__('mins',true);
						}
					?>
					<?php
					
						$priceIDs = array();
						$services = array();
						$duration = array();
						if(!empty($appointmentDetail['OrderDetail'])){
							foreach($appointmentDetail['OrderDetail'] as $optionId => $options){
								$priceIDs[]= $options['price_option_id'];
								$services[]= $options['service_id'];
								$duration[]= $options['duration'];
							}
						}
					
					?>
					
					<a href="javascript:void(0);" class="list-group-item priceOpt-here " data-priceid="<?php echo implode('-',$priceIDs); ?>" data-price="<?php echo $price; ?>" data-option-duration="<?php echo implode(',',$duration); ?>" data-services="<?php echo implode(',',$services); ?>">
						<span class="badge"><?php echo __('AED',true);?> <?php echo $price; ?>
						</span>
						<h4 class="list-group-item-heading">
						<?php  
								echo "Option ";	
						?>
						</h4>
						<p class="list-group-item-text">
						  <i class="fa fa-clock-o"></i>
						  <span class="text"> <?php  echo $this->Common->convertToHoursMins($duration1, $durationM); ?> </span>
					  </p>
					</a>
				
                </div>
                <div class="PackageServices"></div>
				<div class="chooseBookingType list-group pricing-list">
					<a href="javascript:void(0);" class="list-group-item no-hover" data-type="">
						<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('select_opt',true); ?></h4>
					</a>
					<a href="javascript:void(0);" class="list-group-item" data-type="manual">
						</span>
						<h4 class="list-group-item-heading">
						     Manual staff selection
						</h4>
					</a>
					<a href="javascript:void(0);" class="list-group-item" data-type="automatic">
						</span>
						<h4 class="list-group-item-heading">
							Automatic staff selection
						</h4>
					</a>
				</div>
				<!--$packagePricingOption -->
				<div class='cal-sec rescheduleCal widgetPackageCalendar <?php echo (isset($priceotion))?'disabled':''; ?>' style="display: none"></div>
					
					<div class="packgServc list-group pricing-list" style="display:none" id="option_<?php echo implode('-',$priceIDs); ?>">
						<a href="javascript:void(0);" class="list-group-item no-hover" data-type="">
							<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i>Package includes</h4>
						</a>
						<?php
					if(!empty($appointmentDetail['OrderDetail'])){
						  foreach($appointmentDetail['OrderDetail'] as $optionId => $options){ 
					?>
						
						<a href="javascript:void(0);" id="<?php echo $options['service_id']; ?>" data-option-duration="<?php echo $options['duration'];?>" class="list-group-item" data-type="serviceSelect" style="display:none">
							
							<h4 class="list-group-item-heading">
								 <?php echo $options['eng_service_name']; ?>
							</h4>
							<span class="badge"></span>
							<p class='list-group-item-text'></p>
						</a>
						
						<div class='stylistListData  buk-emp-list' style="display:none"  id="stafFor_<?php echo $options['service_id']; ?>">
								<div style="display: none; position: relative;" class="loader-container" id="ajax_modal">
									<div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
								</div>
								<div class="allStylistHere"></div>
						</div>
						
						<?php } ?>
					
				<?php 
				} ?>
				</div>
				<div class="serviceBukctnt">
					<div class="centering-wrapper">
						<div class="save" style="display: none">
							<span><?php echo __('you_save',true); ?></span>
							<strong><?php echo __('AED',true); ?><span class="DSPrice" style="display: none">0</span></strong>
						</div>
						<div class="pay tp-space">
							<span><?php echo __('Total',true); ?></span>
							<strong>
								<span class="enabled"><?php echo __('AED',true); ?><span class="Sprice"  style="display: none" ></span></span>
							</strong>
						</div>
						<div class="discount-type" style="display: none"><?php echo __('sale_price',true); ?></div>
						<div class="book-coupons">Coupons are applied after clicking on book now and before making payments online</div>

					</div>
					<a href="javascript:void(0);" class="action disabled" data-type="appointment" data-login_val="package">
						<span class="appointment"><?php echo __('Book',true); ?></span>
					</a>
				</div>
		</div>
			
			<?php }?>
			</div>
        </div>
		<div style="display: none" class="con_action"><?php echo $this->params['action']; ?></div>
		<div style="display: none" class="dataType_val"></div>
	<div id="theHiddenForm">
		<?php echo $this->Form->hidden('package_id',array('id'=>'PackageId','value'=>$packageDetails['Package']['id']));?>
		<?php echo $this->Form->hidden('package_price_opt',array('id'=>'PackagePriceOpt'));?>
		<?php 
		// to store date selected
		echo $this->Form->hidden('package_date',array('id'=>'selDate'));?>
		<?php 
		// check manual or automation 
		echo $this->Form->hidden('selection_type',array('id'=>'selType'));?>
		<?php echo $this->Form->hidden('package_price',array('id'=>'PackagePrice'));?>
		<?php echo $this->Form->hidden('advancebookinglimit',array('id'=>'maxBookingLimit','value'=>$maxBookingLimit));?>
		<?php echo $this->Form->hidden('selected_customer',array('id'=>'selCustomer'));?>
		<?php echo $this->Form->hidden('selected_quantity',array('value'=>1,'id'=>'selQuantity'));?>
		<?php echo $this->Form->hidden('theBuktype',array('id'=>'selBukTyp','value'=>'appointment'));?>
		<?php echo $this->Form->hidden('activeDay',array('id'=>'activeDay'));?>
		<?php echo $this->Form->hidden('thetype',array('data-chkin'=>$packageDetails['Package']['check_in'],'data-chkout'=>$packageDetails['Package']['check_out'],'id'=>'thetype','value'=>$packageDetails['Package']['type']));?>
	</div>
<?php echo $this->Form->end(); ?>
<script>
	$(document).ready(function(){
		$(document).find('div.soldOptions').find('ul.ulopts li:first').addClass('active');
		var tabID = $(document).find('div.soldOptions').find('ul.ulopts li:first a').attr('aria-controls');
		$(document).find('div.soldOptions').find('#'+tabID).addClass('active');
		if($(document).find('div.soldOptions').find('ul.ulopts li').length == 1){
			$(document).find('div.soldOptions').find('ul.ulopts li').addClass('full-w');
			//if(tabID == 'buygift'){
				
			//}
		}
		
		$(document).find("#selQty").select2({}).on('open', function(){
                $(document).find('.salon-typ .input.select').addClass('purple-bod');
		}).on('close',function(){
		$(document).find('.salon-typ .input.select').removeClass('purple-bod');
        });
		<?php if(!isset($priceotion)){ ?>
			setTimeout(function(){
				
				//var serviceId = $(document).find('input#serviceId').val();
				//var employeeId = $(document).find('input#employeeId').val();
				//var priceLvlId = $(document).find('input#priceLvlId').val();
				
				//packageObj.find('#PackagePriceOpt').val(thepriceId);
				//$(document).find('#bookappointment.active .chooseBookingType').show();
				//$(document).find('.allPriceOpt').find('a.list-group-item').hide();
				//$(document).find('.allPriceOpt').find('a.priceOpt-here:first').click();
				
				
				//var thedate = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').attr('data-date');
				//$(document).find('input#selDate').val(thedate);
				//getstaffforAppointment(thedate,serviceId,employeeId,priceLvlId);
				//toAddPrice();
				//enableSubmit();
				
			},500);
		<?php }?>
	});
</script>
<?php //pr($packageDetails); ?>
 
<?php //echo $this->Js->writeBuffer();?>
<?php echo $this->Js->writeBuffer();?>
