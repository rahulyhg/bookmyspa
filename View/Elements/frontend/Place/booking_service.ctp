<?php $lang = Configure::read('Config.language'); ?>
<?php //pr($this->request); ?>

<?php
    $lastVisited =  $this->Session->read('lastVisited');
    if( !empty($lastVisited)){
        echo $this->Js->link(__('<< Back ',true),$lastVisited,array('update' => '#update_ajax','class'=>'backLink'));
    }else{
?>
    <a class="backLink" href="<?php echo $this->request->referer();?>"><< Back</a>
<?php
    }

?>
<style>
    .book-coupons {
	float: left !important;
	padding-top: 2px;
	font-size: 11px;
    }
    @media(max-width:360px){
    .serviceBukctnt .centering-wrapper .pay {
	 font-size: 15px;
    }
</style>

   <div class="big-lft">
	<div class="timer-details clearfix">
		<ul class="clearfix">
			<li>
                <span class="text-main">
				<?php
				if(isset($deal) && $deal){
						
					  if(!empty($dealData['Deal'][$lang.'_name'])){
						  echo $dealData['Deal'][$lang.'_name']; }
						  if(!$eVoucher && !$reschedule){
								echo '<div id="clock1" class="clock" data-maxtime="'.date('m/d/Y',strtotime($dealData['Deal']['max_time'])).'">[clock]</div>';
						  }
						  
					  }else{
						  if(!empty($serviceDetails['SalonService'][$lang.'_name'])){
							  echo $serviceDetails['SalonService'][$lang.'_name'];
						  }elseif(!empty($serviceDetails['Service'][$lang.'_name'])){
							  echo $serviceDetails['Service'][$lang.'_name'];
						  }else{
							  echo $serviceDetails['Service']['eng_name'];
						  }
					  }
				?>
				
				
			
					 <?php if(isset($deal) && $deal && !$eVoucher && !$reschedule){?>
						<?php
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
								echo $this->Form->hidden('remainQty',array('id'=>'AppointmentRemainQty','value'=>$remainQty,'label'=>false));
							}?>
							
					 <?php } ?>
			    </span>
			</li>
		</ul>
		<?php if(isset($deal) && $deal && !$eVoucher && !$reschedule){?>
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
		<?php if(!empty($serviceDetails['SalonServiceImage'])){ ?>
		<div class="gallery">
			<!--<ul class="lightSlider" id="servicelightSlider">
				<?php //foreach($serviceDetails['SalonServiceImage'] as $image) { 
					//echo "<li data-thumb='/images/Service/150/".$image['image']."'>".$this->Html->image('/images/Service/500/'.$image['image']) ."</li>";
				//} ?>
			</ul>-->
			
			<?php //if(!empty($serviceDetails['SalonServiceImage'])){ ?>
			<ul class="bxslider">
				<?php foreach($serviceDetails['SalonServiceImage'] as $image) {  ?>
				<li><?php echo $this->Html->image('/images/Service/800/'.$image['image']); ?></li>
				<?php } ?>
			</ul>
		  
			<div id="bx-pager">
				<?php
				$i = 0;
				foreach($serviceDetails['SalonServiceImage'] as $image) {  ?>
				<a data-slide-index="<?php echo $i;?>" href="javascript:void(0);"><?php echo $this->Html->image('/images/Service/150/'.$image['image']); ?></a>
				<?php $i++; } ?>
			</div>

		</div>
		<!--<div class="thumbnail clearfix"></div>-->
		<?php } ?>
		<div class="share-specific-deal clearfix">
			<ul class="share-icon-set">
				<li>Share this service</li>
				<li><a href="#" class="msz"></a></li>
				<li><a href="#" class="fb"></a></li>
				<li><a href="#" class="tweet"></a></li>
				<li><a href="#" class="google"></a></li>
			</ul>
		</div>
	</div>
	
	<div class="specific-service-details">
		<h2 class="share-head"><?php echo __('in_nutshell');?></h2>
		<p><?php
			if(isset($deal) && $deal){
				//pr($dealData);
				if(!empty($dealData['Deal'][$lang.'_description'])){
					 echo $dealData['Deal'][$lang.'_description'];
				  }else{
					echo $dealData['Deal']['eng_description'];
				  }
			}else{
		if(!empty($serviceDetails['SalonService'][$lang.'_description'])){
						echo $serviceDetails['SalonService'][$lang.'_description'];
				    }else{
						echo $serviceDetails['SalonService']['eng_description'];
				    }
			}?></p>
		<h2 class="share-head"><?php echo __('choose_following');?></h2>
		<ul class="specific-description">
			<?php
			//(!empty($pacakgePriceOpt['sell_price']) ? $pacakgePriceOpt['sell_price'] : $pacakgePriceOpt['full_price']);
			if(isset($deal) && $deal){
				if(isset($dealData['DealServicePackage'][0]['DealServicePackagePriceOption']) && !empty($dealData['DealServicePackage'][0]['DealServicePackagePriceOption'])){
					foreach($dealData['DealServicePackage'][0]['DealServicePackagePriceOption'] as $options){ ?>
						
					<li><i class="fa fa-caret-right"></i><span><?php echo __('AED',true);?> <?php echo $options['deal_price']; ?> <?php echo __('for',true);?>
					<?php  if(!empty($options[$lang.'_custom_title'])){
						echo $options[$lang.'_custom_title'];
				    }else{
						echo $options['eng_custom_title'];
				    }?></span></li>	
						
					<?php }	
				}
			}else{
				foreach($serviceDetails['ServicePricingOption'] as $thePriceOpt){ ?>
				<li><i class="fa fa-caret-right"></i><span><?php echo __('AED',true);?> <?php echo ($thePriceOpt['sell_price'])? $thePriceOpt['sell_price'] :$thePriceOpt['full_price']; ?> <?php echo __('for',true);?> <?php  if(!empty($thePriceOpt['custom_title_'.$lang])){
						echo $thePriceOpt['custom_title_'.$lang];
				    }else{
						echo $thePriceOpt['custom_title_eng'];
				    }?></span></li>
			<?php } 
			}?>
				
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
			<p><span><?php echo __('good_to_know',true);?>:</span> <?php echo (!empty($dealData['Deal']['eng_good_to_know']))?$dealData['Deal']['eng_good_to_know']:((!empty($serviceDetails['SalonService']['eng_good_to_know']))?$serviceDetails['SalonService'][$lang.'_good_to_know']:__('NA',true)); ?></p>
		<?php }
		if(!empty($policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy'])){?>
			<p><span><?php echo __('cancel_policy',true);?>:</span> <?php echo $policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']; ?></p>
		<?php }else{ ?>
			<p><span><?php echo __('cancel_policy',true);?>:</span> <?php echo (!empty($policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']))?$policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']:__('NA',true); ?></p>
		<?php }if(!empty($policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy'])){?>
			<p><span><?php echo __('reschedule_policy',true);?>:</span> <?php echo $policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']; ?></p>
		<?php }else{ ?>
			<p><span><?php echo __('reschedule_policy',true);?>:</span> <?php echo (!empty($policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']))?$policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']:__('NA',true); ?></p>
		<?php }  ?>
		
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
					<?php } 
		
		
		
		}else{
			
		 if($serviceDetails['SalonServiceDetail']['listed_online'] && $serviceDetails['SalonServiceDetail']['listed_online'] > 1){?>
		<p><span><?php echo __('Validity',true);?>:</span> Sieasta <?php echo __('valid_until',true);?> <?php echo date('d.m.Y',strtotime($serviceDetails['SalonServiceDetail']['listed_online_end'])); ?>.</p>
		<?php } ?>
		<?php  if(!empty($serviceDetails['SalonService'][$lang.'_restriction'])){?>
			<p><span><?php echo __('Restriction',true);?>:</span> <?php echo $serviceDetails['SalonService'][$lang.'_restriction']; ?></p>
		<?php }else{ ?>
			<p><span><?php echo __('Restriction',true);?>:</span> <?php echo (!empty($serviceDetails['SalonService']['eng_restriction']))?$serviceDetails['SalonService']['eng_restriction']:__('NA',true); ?></p>
		<?php }?>
		<?php  if(!empty($serviceDetails['SalonService'][$lang.'_good_to_know'])){?>
			<p><span><?php echo __('good_to_know',true);?>:</span> <?php echo $serviceDetails['SalonService'][$lang.'_good_to_know']; ?></p>
		<?php }else{ ?>
			<p><span><?php echo __('good_to_know',true);?>:</span> <?php echo (!empty($serviceDetails['SalonService']['eng_good_to_know']))?$serviceDetails['SalonService']['eng_good_to_know']:__('NA',true); ?></p>
		<?php }
		if(!empty($policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy'])){?>
			<p><span><?php echo __('cancel_policy',true);?>:</span> <?php echo $policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']; ?></p>
		<?php }else{ ?>
			<p><span><?php echo __('cancel_policy',true);?>:</span> <?php echo (!empty($policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']))?$policyDetail['PolicyDetail'][$lang.'_cancel_appointment_policy']:__('NA',true); ?></p>
		<?php }
		//pr($policyDetail['PolicyDetail']);
		if(!empty($policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy'])){?>
			<p><span><?php echo __('reschedule_policy',true);?>:</span> <?php echo $policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']; ?></p>
		<?php }else{ ?>
			<p><span><?php echo __('reschedule_policy',true);?>:</span> <?php echo (!empty($policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']))?$policyDetail['PolicyDetail'][$lang.'_reschedule_appointment_policy']:__('NA',true); ?></p>
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
					if($serviceDetails['SalonServiceDetail']['sold_as'] == 1){ $giftCheck = false;}
					if($serviceDetails['SalonServiceDetail']['sold_as'] == 2){ $buyCheck = false;}
				if($eVoucher == 'true'){
					$giftCheck = $buyCheck = false; ?>
					<li role="presentation">
					<a   href="#evoucher" aria-expanded="true" href="javascript:void(0);" aria-controls="evoucher" role="tab" data-toggle="tab"><?php echo __('buk_app',true); ?></a>
					</li>
					<?php
				}
				//if(!empty($deal) && $deal){
				//			   //$buyCheck = false;	
				//}
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
			
			<div role="tabpanel" class="tab-pane appointmentVoucher" id="bookappointment">
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
					if($serviceDetails['SalonServiceDetail']['offer_available']==1){  $offerOn = array_filter(unserialize($serviceDetails['SalonServiceDetail']['offer_available_weekdays']));
					
						if(!empty($offerOn)){
								echo implode(',',array_keys($offerOn));
						
						} }else{
								echo "sun,mon,tue,wed,thu,fri,sat";	
						}
					}
					?>
				</span>
				<div class="list-group pricing-list allPriceOpt" >
					<?php
					$durationArray = $this->common->get_duration();
					if(count($serviceDetails['ServicePricingOption']) > 1){
						$priceotion = true;
						?>
					  <a href="javascript:void(0);" class="list-group-item no-hover">
						<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('Treatment Room',true); ?></h4>
					  </a>
					  <div class="form-group pdng6">
						<?php //echo $this->Form->hidden('Address.country_id',array('value'=>252,'div'=>false,'label'=>false));?>
						<div class='col-sm-12' style='margin-top: 8px'>
						    <?php echo $this->Form->input('resource',array('class'=>'form-control full-w','options'=>$resources,'empty'=>'Please Select','div'=>false,'label'=>false));?>
						</div>
					 </div>
					<a href="javascript:void(0);" class="list-group-item no-hover">
						<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('select_opt',true); ?></h4>
					</a>
					<?php
					
					 if(isset($deal) && $deal){
							foreach($dealData['DealServicePackage'][0]['DealServicePackagePriceOption'] as $thePriceOpt){
							
							?>
								<?php
									$SPrice = $thePriceOpt['deal_price']; $SDPrice ="";
									$SDPrice = $thePriceOpt['full_price']-$thePriceOpt['deal_price'];
									$APrice = $thePriceOpt['full_price'];
									if($thePriceOpt['sell_price']){
										$SPrice = $thePriceOpt['deal_price'];
										$SDPrice = $thePriceOpt['sell_price'] - $thePriceOpt['deal_price'];
										$APrice = $thePriceOpt['sell_price'];
									}
								?>
								<a href="javascript:void(0);" class="list-group-item" data-priceID="<?php echo $thePriceOpt['id']?>" data-price="<?php echo $SPrice; ?>" data-disprice="<?php echo $SDPrice; ?>" data-duration = "<?php echo $thePriceOpt['duration']; ?>" data-priceLevel="0">
									<span class="badge"><?php echo __('AED',true);?> <?php echo $thePriceOpt['deal_price']; ?>
										
										<span class="save"><?php echo __('Save',true); ?> <?php echo round((($APrice-$SPrice)/$APrice)*100,2); ?>%</span>
										
									</span>
									<h4 class="list-group-item-heading">
									<?php  if(!empty($thePriceOpt[$lang.'_custom_title'])){
											echo ucfirst($thePriceOpt[$lang.'_custom_title']);
										}else{
											echo ucfirst($thePriceOpt['custom_title_eng']);
										}?>
									</h4>
									<p class="list-group-item-text">
									  <i class="fa fa-clock-o"></i>
									  <span class="text"> <?php echo $durationArray[$thePriceOpt['duration']]; ?> </span>
								  </p>
								</a>
								<?php
							} 
						
						 }else{
							foreach($serviceDetails['ServicePricingOption'] as $thePriceOpt){
							$SPrice = $thePriceOpt['full_price']; $SDPrice ="";
							if($thePriceOpt['sell_price']){
								$SPrice = $thePriceOpt['sell_price'];
								$SDPrice = $thePriceOpt['full_price'] - $thePriceOpt['sell_price'];
							}
						?>
						<a href="javascript:void(0);" class="list-group-item" data-priceID="<?php echo $thePriceOpt['id']?>" data-price="<?php echo $SPrice; ?>" data-disprice="<?php echo $SDPrice; ?>" data-duration = "<?php echo $thePriceOpt['duration']; ?>" data-priceLevel="<?php echo $thePriceOpt['pricing_level_id']?>"  >
							<span class="badge"><?php echo __('AED',true);?> <?php echo ($thePriceOpt['sell_price'])? $thePriceOpt['sell_price'] :$thePriceOpt['full_price']; ?>
								<?php if(!empty($thePriceOpt['sell_price'])){ ?>
								<span class="save"><?php echo __('Save',true); ?> <?php echo (($thePriceOpt['full_price']-$thePriceOpt['sell_price'])/$thePriceOpt['full_price'])*100; ?>%</span>
								<?php } ?>
							</span>
							<h4 class="list-group-item-heading">
							<?php  if(!empty($thePriceOpt['custom_title_'.$lang])){
									echo ucfirst($thePriceOpt['custom_title_'.$lang]);
								}else{
									echo ucfirst($thePriceOpt['custom_title_eng']);
								}?>
							</h4>
							<p class="list-group-item-text">
							  <i class="fa fa-clock-o"></i>
							  <span class="text"> <?php echo $durationArray[$thePriceOpt['duration']]; ?> </span>
						  </p>
						</a>
						<?php }
						
					 }
				}?>

                </div>
                <div class='cal-sec widgetCalendar <?php echo (isset($priceotion))?'disabled':''; ?>'></div>
				<div class='stylistListData  buk-emp-list' >
					<div style="display: none; position: relative;" class="loader-container" id="ajax_modal">
						<div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
					</div>
					<div class="allStylistHere"></div>
				</div>
				
				<div class="serviceBukctnt">
				<?php if($reschedule == 'true'){
					
					?>
				<a href="javascript:void(0);" class="action">
						<span class="resch"><?php echo __('Reschedule',true); ?></span>
				</a>
				
				<?php }else{?>
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
					<a href="javascript:void(0);" class="action disabled" data-type="appointment" data-login_val="service">
						<span class="appointment"><?php echo __('Book',true); ?></span>
					</a>
					<?php }?>
				</div>
			</div>
            <?php } ?>
			<?php if($giftCheck){ ?>
			<div role="tabpanel" class="tab-pane appointmentVoucher" id="buygift">
				<div class="list-group pricing-list allPriceOpt">
					<?php
					$durationArray = $this->common->get_duration();
					
					if(count($serviceDetails['ServicePricingOption']) > 1){
						$priceotion = true;
						?>
					<a href="javascript:void(0);" class="list-group-item no-hover">
						<h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('select_opt',true); ?></h4>
					</a>
					<?php
					
					 if(isset($deal) && $deal){
						foreach($dealData['DealServicePackage'][0]['DealServicePackagePriceOption'] as $thePriceOpt){
							
							?>
								<?php
									$SPrice = $thePriceOpt['deal_price']; $SDPrice ="";
									$SDPrice = $thePriceOpt['full_price']-$thePriceOpt['deal_price'];
									$APrice = $thePriceOpt['full_price'];
									if($thePriceOpt['sell_price']){
										$SPrice = $thePriceOpt['deal_price'];
										$SDPrice = $thePriceOpt['sell_price'] - $thePriceOpt['deal_price'];
										$APrice = $thePriceOpt['sell_price'];
									}
								?>
								<a href="javascript:void(0);" class="list-group-item" data-priceID="<?php echo $thePriceOpt['id']?>" data-price="<?php echo $SPrice; ?>" data-disprice="<?php echo $SDPrice; ?>" data-priceLevel="<?php echo $thePriceOpt['option_id']?>">
									<span class="badge"><?php echo __('AED',true);?> <?php echo $thePriceOpt['deal_price']; ?>
										
										<span class="save"><?php echo __('Save',true); ?> <?php echo round((($APrice-$SPrice)/$APrice)*100,2); ?>%</span>
										
									</span>
									<h4 class="list-group-item-heading">
									<?php  if(!empty($thePriceOpt[$lang.'_custom_title'])){
											echo ucfirst($thePriceOpt[$lang.'_custom_title']);
										}else{
											echo ucfirst($thePriceOpt['custom_title_eng']);
										}?>
									</h4>
									<p class="list-group-item-text">
									  <i class="fa fa-clock-o"></i>
									  <span class="text"> <?php echo $durationArray[$thePriceOpt['duration']]; ?> </span>
								  </p>
								</a>
								<?php
							} 
						
					 }else{
						foreach($serviceDetails['ServicePricingOption'] as $thePriceOpt){ ?>
								<?php
									$SPrice = $thePriceOpt['full_price']; $SDPrice ="";
									if($thePriceOpt['sell_price']){
										$SPrice = $thePriceOpt['sell_price'];
										$SDPrice = $thePriceOpt['full_price'] - $thePriceOpt['sell_price'];
									}
								?>
								<a href="javascript:void(0);" class="list-group-item" data-priceID="<?php echo $thePriceOpt['id']?>" data-price="<?php echo $SPrice; ?>" data-disprice="<?php echo $SDPrice; ?>" data-priceLevel="<?php echo $thePriceOpt['pricing_level_id']?>"  >
									<span class="badge"><?php echo __('AED',true);?> <?php echo ($thePriceOpt['sell_price'])? $thePriceOpt['sell_price'] :$thePriceOpt['full_price']; ?>
										<?php if(!empty($thePriceOpt['sell_price'])){ ?>
										<span class="save"><?php echo __('Save',true); ?> <?php echo (($thePriceOpt['full_price']-$thePriceOpt['sell_price'])/$thePriceOpt['full_price'])*100; ?>%</span>
										<?php } ?>
									</span>
									<h4 class="list-group-item-heading">
									<?php  if(!empty($thePriceOpt['custom_title_'.$lang])){
											echo ucfirst($thePriceOpt['custom_title_'.$lang]);
										}else{
											echo ucfirst($thePriceOpt['custom_title_eng']);
										}?>
									</h4>
									<p class="list-group-item-text">
									  <i class="fa fa-clock-o"></i>
									  <span class="text"> <?php echo $durationArray[$thePriceOpt['duration']]; ?> </span>
								  </p>
								</a>
								<?php
							} 
					 }
					?>
					
					<?php
					}?>

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
								
									if($serviceDetails['SalonServiceDetail']['offer_available']){
										$offerOn = unserialize($serviceDetails['SalonServiceDetail']['offer_available_weekdays']);
										
										foreach($dayArray  as $theDfortick){ ?>
											<li><a href="javascript:void(0);"><?php echo __(ucfirst($theDfortick),true);?><span class="fa <?php echo ($offerOn[$theDfortick])? 'fa-check' : 'fa-minus' ;?>"></span></a></li>
										<?php }	
									}else{
										foreach($dayArray  as $theDfortick){?>
										<li><a href="javascript:void(0);"><?php echo __(ucfirst($theDfortick),true);?><span class="fa fa-check"></span></a></li>
									<?php }
									}
									
								}?>
						</ul>
					</div>
				 </div>
				<div class="buk-emp-list">
				<p><?php echo $this->Common->getEvoucherPolicy($salonId); ?></p>
				<div class="clearfix pos-rgt expiry-box">
					<h4 class="pos-rgt"><?php echo __('eVoucher_expires',true);?>:</h4>
					<div class="">
					<?php
						if(isset($deal) && $deal){
							
							echo $this->Common->getEvoucherExpiry($serviceDetails['SalonService']['id'],$salonId,1,$dealData['Deal']['id']);	
						}else{
							echo $this->Common->getEvoucherExpiry($serviceDetails['SalonService']['id'],$salonId,1);	
						}
						//echo $this->Common->getEvoucherExpiry($serviceDetails['SalonService']['id'],$salonId,1);
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
					<a href="javascript:void(0);" class="action disabled"  data-type="eVoucher" data-login_val="service">
						<span class="appointment"><?php echo __('Buy',true); ?></span>
					</a>
				</div>
			</div>
			<?php } ?>
			<?php if($reschedule=='true'){ ?>
			<div role="tabpanel" class="tab-pane" id="reschedule">
		 <div class='cal-sec widgetCalendar <?php echo (isset($priceotion))?'disabled':''; ?>'></div>
			<span class="offerOn" style="display: none"><?php
			
					if(isset($deal) && $deal){
						if($dealData['Deal']['offer_available'] == 1){  $offerOn = array_filter(unserialize($dealData['Deal']['offer_available_weekdays']));
					if(!empty($offerOn)){
						echo implode(',',array_keys($offerOn));
					} }else{
						echo "sun,mon,tue,wed,thu,fri,sat,sun";
					}
						
					}else{
						if($serviceDetails['SalonServiceDetail']['offer_available'] == 1){  $offerOn = array_filter(unserialize($serviceDetails['SalonServiceDetail']['offer_available_weekdays']));
					if(!empty($offerOn)){
						echo implode(',',array_keys($offerOn));
					} }else{
						echo "sun,mon,tue,wed,thu,fri,sat,sun";
					}
					}
						
						?>
				</span>
				<div class='stylistListData  buk-emp-list' >
					<div style="display: none; position: relative;" class="loader-container" id="ajax_modal">
						<div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
					</div>
					<div class="allStylistHere"></div>
				</div>
				
				<div class="serviceBukctnt">
					<?php if($reschedule == 'true'){
					
					?>
				<a href="javascript:void(0);" class="action disabled">
						<span class="resch"><?php echo __('Book',true); ?></span>
					</a>
				
				<?php }else{?>
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
						<div class="book-coupons" >Coupons are applied after clicking on book now and before making payments online</div>
					</div>
					<a href="javascript:void(0);" class="action disabled" data-type="appointment" data-login_val="service">
						<span class="appointment"><?php echo __('Book',true); ?></span>
					</a>
					<?php }?>
				</div>
				
			</div>
			<?php } if($eVoucher == 'true'){ ?>
				<div role="tabpanel" class="tab-pane" id="evoucher">
				<span class="offerOn" style="display: none">
				<?php
				
					if(isset($deal) && $deal){
						if($dealData['Deal']['offer_available'] == 1){  $offerOn = array_filter(unserialize($dealData['Deal']['offer_available_weekdays']));
					if(!empty($offerOn)){
						echo implode(',',array_keys($offerOn));
					} }else{
						echo "sun,mon,tue,wed,thu,fri,sat,sun";
					}
						
					}else{
						if($serviceDetails['SalonServiceDetail']['offer_available'] == 1){  $offerOn = array_filter(unserialize($serviceDetails['SalonServiceDetail']['offer_available_weekdays']));
					if(!empty($offerOn)){
						echo implode(',',array_keys($offerOn));
					} }else{
						echo "sun,mon,tue,wed,thu,fri,sat,sun";
					}
					}
					
				?>
					
				
				</span>
		 <div class='cal-sec widgetCalendar'></div>
			
				<div class='stylistListData  buk-emp-list' >
					<div style="display: none; position: relative;" class="loader-container" id="ajax_modal">
						<div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
					</div>
					<div class="allStylistHere"></div>
				</div>
				
				<div class="serviceBukctnt">
					
				<a href="javascript:void(0);" class="action disabled">
						<span class="resch"><?php echo __('Book',true); ?></span>
				</a>
				
				</div>
				
			</div>
			
				
			<?php } ?>
			</div>
        </div>
	 <?php
	
		if($reschedule == 'true'){
			echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Myaccount','action'=>'reschedule')));?>
		<?php }else if($eVoucher == 'true'){
			echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Myaccount','action'=>'bookeVoucherAppnmnt')));
		 }
		if(isset($deal) && $deal){
		?>
		<?php
		    echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Deals','action'=>'appointment')));
		    echo $this->Form->hidden('deal_id',array('value'=>$dealData['Deal']['id'],'label'=>false));
		    echo $this->Form->hidden('Deal.id',array('value'=>$dealData['Deal']['id'],'label'=>false));
		    echo $this->Form->hidden('Deal.blackoutDates',array('value'=>json_encode($blkDate),'label'=>false));
		?>
		<?php }else{?>
		<?php echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Bookings','action'=>'appointment')));?>
		<?php } ?>
		<?php echo $this->Form->hidden('service_id',array('id'=>'serviceId','value'=>$serviceDetails['SalonService']['id']));?>
		<?php echo $this->Form->hidden('employee_id',array('id'=>'employeeId','value'=>'0'));?>
		<?php if(!isset($priceotion)){
			
			if(isset($deal) && $deal){
				echo $this->Form->hidden('price_id',array('id'=>'priceOptId','value'=>$dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['id']));
			        echo $this->Form->hidden('price_level_id',array('id'=>'priceLvlId','value'=>$serviceDetails['ServicePricingOption'][0]['pricing_level_id']));
				echo $this->Form->hidden('duration',array('id'=>'durationId','value'=>$dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['duration']));
				$SPrice = $dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['deal_price']; $SDPrice ="";
									$SDPrice = $dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['full_price']-$dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['deal_price'];
									$APrice = $dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['full_price'];
									if($dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['sell_price']){
										$SPrice = $dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['deal_price'];
										$SDPrice = $dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['sell_price'] - $dealData['DealServicePackage'][0]['DealServicePackagePriceOption'][0]['deal_price'];
										//$APrice = $thePriceOpt['sell_price'];
									
			
			}
			}else{
				echo $this->Form->hidden('price_id',array('id'=>'priceOptId','value'=>$serviceDetails['ServicePricingOption'][0]['id']));
				echo $this->Form->hidden('price_level_id',array('id'=>'priceLvlId','value'=>$serviceDetails['ServicePricingOption'][0]['pricing_level_id']));
					echo $this->Form->hidden('duration',array('id'=>'durationId','value'=>$serviceDetails['ServicePricingOption'][0]['duration']));
					$SPrice = $serviceDetails['ServicePricingOption'][0]['full_price']; $SDPrice ="";
					if($serviceDetails['ServicePricingOption'][0]['sell_price']){
						$SPrice = $serviceDetails['ServicePricingOption'][0]['sell_price'];
						$SDPrice = $serviceDetails['ServicePricingOption'][0]['full_price'] - $serviceDetails['ServicePricingOption'][0]['sell_price'];
					}
				
				}			
							
			
			
			echo $this->Form->hidden('price',array('id'=>'priceVal','value'=>$SPrice));
			echo $this->Form->hidden('discount_price',array('id'=>'priceDisVal','value'=>$SDPrice));
		
		}else{
			echo $this->Form->hidden('price_id',array('id'=>'priceOptId'));
			echo $this->Form->hidden('price_level_id',array('id'=>'priceLvlId'));
			
			echo $this->Form->hidden('price',array('id'=>'priceVal'));
			echo $this->Form->hidden('discount_price',array('id'=>'priceDisVal'));
		}?>
		<?php
			  $leadTime = $serviceDetails['SalonServiceDetail']['appointment_lead_time'];
			  if($leadTime < 24){
				$leadTimeNew = 'day';
			  }else{
				$current = date("D M d Y");
				$leadTimeNew = date('D M d Y H:i:s', strtotime($current.' + '.$leadTime.' hours'));
				
			  }
		          echo $this->Form->hidden('leadTime',array('id'=>'leadTime','value'=>$leadTimeNew));
			  //echo $this->Form->hidden('currentDTime',array('id'=>'currentDTime','value'=>$current));
		?>
		<?php echo $this->Form->hidden('advancebookinglimit',array('id'=>'maxBookingLimit','value'=>$maxBookingLimit));?>
		<?php echo $this->Form->hidden('selected_employee_id',array('id'=>'selEmpId'));?>
		<?php echo $this->Form->hidden('selected_date',array('id'=>'selDate'));?>
		<?php echo $this->Form->hidden('selected_time',array('id'=>'selTime'));?>
		<?php echo $this->Form->hidden('selected_customer',array('id'=>'selCustomer'));?>
		<?php echo $this->Form->hidden('selected_quantity',array('value'=>1,'id'=>'selQuantity'));?>
		<?php echo $this->Form->hidden('theBuktype',array('id'=>'selBukTyp'));?>
		<?php echo $this->Form->hidden('activeDay',array('id'=>'activeDay'));?>
		<?php echo $this->Form->end(); ?>
<script>
	$(document).ready(function(){
		$(document).find('div.soldOptions').find('ul.ulopts li:first').addClass('active');
		var tabID = $(document).find('div.soldOptions').find('ul.ulopts li:first a').attr('aria-controls');
		$(document).find('div.soldOptions').find('#'+tabID).addClass('active');
		//alert($(document).find('div.soldOptions').find('ul.ulopts li').length);
		if($(document).find('div.soldOptions').find('ul.ulopts li').length == 1){
			$(document).find('div.soldOptions').find('ul.ulopts li').addClass('full-w');
			//alert(tabID);
			//if(tabID == 'buygift'){
			setTimeout(function(){
				toAddPrice();
			},500);
			//}
		}
		$(document).find("#selQty").select2({}).on('open', function(){
                $(document).find('.salon-typ .input.select').addClass('purple-bod');
		}).on('close',function(){
           $(document).find('.salon-typ .input.select').removeClass('purple-bod');
        });
		
		<?php if(!isset($priceotion) && ($reschedule != 'true' || $eVoucher != 'true') ){ ?>
			setTimeout(function(){
				var serviceId = $(document).find('input#serviceId').val();
				var employeeId = $(document).find('input#employeeId').val();
				var priceLvlId = $(document).find('input#priceLvlId').val();
				var thedate = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').attr('data-date');
				if($(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').find('span').hasClass("bright")){
					$(document).find('input#selDate').val(thedate);
					getstaffforAppointment(thedate,serviceId,employeeId,priceLvlId);
					toAddPrice();
					enableSubmit();
				   }else{
					$(document).find(".bukingService #bookappointment .stylistListData .allStylistHere").html("<p>Sorry, there are no available slots for today</p></br><p>Please select another day.</p>");
					 
				   }
				
			},500);
		<?php }?>
	<?php if($reschedule == 'true' || $eVoucher == 'true'){ ?>
		setTimeout(function(){
		var thedate = $(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').attr('data-date');
		//alert(thedate);
		var serviceId = $(document).find('input#serviceId').val();
		if($(document).find('div.cal-sec').find('div.wc-header').find('li.ui-state-active a').find('span').hasClass("bright")){
					$(document).find('input#selDate').val(thedate);
					//getstaffforAppointment(thedate,serviceId,0,0);
					if($(document).find(".bukingService .stylistListData .allStylistHere").find(".book-stylist").length ==0){
						
						$(document).find('.serviceBukctnt').find('a.action').addClass('disabled');	
					}else{
						$(document).find('.serviceBukctnt').find('a.action').removeClass('disabled');	
					}
				   }else{
				   // alert('f');
					$(document).find(".bukingService .stylistListData .allStylistHere").html("<p>Sorry, there are no available slots for today</p></br><p>Please select another day.</p>");
					$(document).find('.serviceBukctnt').find('a.action').addClass('disabled');
				   }
			
		},500);
		<?php }?>
	});
</script>
<?php //pr($serviceDetails); ?>
<?php echo $this->Js->writeBuffer();?>
