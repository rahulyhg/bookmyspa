<div id="effect_<?php echo $user['User']['id']; ?>" >
					<h2 class="share-head"><?php echo __('INFO',true); ?>
						<a id="<?php  echo $user['User']['id']; ?>" class="cross close-this" href="javascript:void(0);">
							<img title="" alt="" src="/img/cross.png">
						</a>
					</h2>
					<div class="deal-box-outer col-sm-12">
						  <div class="info-details">
							<h4 class="headding">Contact Info </h4>
								 <ul class="clearfix bod-btm-non mrgn-btm-non">
									<li>
										<label>Salon Name</label>
										<span>:</span>
										<section>
										 <?php echo $user['Salon'][$lang.'_name']; ?>
										 </section>
									</li>
									<li>
										<label>Location</label>
										<span>:</span>
										<section>
										 <?php 	$city = $this->Common->getCity($user['Address']['city_id']);
											if(!empty($city))
												echo $city.', ';
											$state = $this->Common->getState($user['Address']['state_id']);
											if(!empty($state))
												echo $state; ?>
										 </section>
									</li>
									<li>
										<label>Email</label>
										<span>:</span>
										<section>
										 <a href="mailto:<?php echo $user['Salon']['email'];?>" ><?php echo $user['Salon']['email'];?></a>
										 </section>
									</li>
									<li>
										<label>Phone</label>
										<span>:</span>
										<section>
										 <?php
											$phone_code = ($user['Contact']['country_code'])?$user['Contact']['country_code']:'+971';
											if($user['Contact']['day_phone']){
										            echo $phone_code.'-'.$user['Contact']['day_phone'];
											}
										  ?>
										 </section>
									</li>
									<li>
										<label>Sieasta Url</label>
										<span>:</span>
										<section>
										 <?php 
										      $business_url =  ($user['Salon']['business_url'] !='')?$user['Salon']['business_url']:$user['User']['username'];
										      echo $this->Html->link(Configure::read('BASE_URL').'/'.$business_url,array('controller'=>'Place','action'=>'index',$user['User']['id']),array('escape'=>false));
										  ?>
										 </section>
									</li>
                    	
                    </ul>
                </div>
<?php $salonOpeningHours = $this->requestAction(array('controller' => 'search', 'action' => 'getsalonOpeningHours',$user['User']['id']));//pr($galleryImages);?>
         <div class="info-details">
                	<h4 class="headding"><?php echo __('hours',true);?></h4>
                    <ul class="clearfix days-hrs">
                    	<?php if(count($salonOpeningHours)){ ?>
                        <li>
                            <label><?php echo __('sunday',true);?></label>
                            <span>:</span>
                            <section>
                        <?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_sun'])?$salonOpeningHours['SalonOpeningHour']['sunday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['sunday_to']:__('closed',true); ?> </section>
                        </li>
                        <li>
                         <label><?php echo __('monday',true);?></label>
                            <span>:</span>
                            <section>
                            <?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_mon'])?$salonOpeningHours['SalonOpeningHour']['monday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['monday_to']:__('closed',true); ?>     
                            </section>
                        </li>
                        <li>
                            <label><?php echo __('tuesday',true);?></label>
                            <span>:</span>
                            <section>
                        <?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_tue'])?$salonOpeningHours['SalonOpeningHour']['tuesday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['tuesday_to']:__('closed',true); ?>     
                            </section>
                        </li>
                        <li>
                            <label><?php echo __('wednesday',true);?></label>
                            <span>:</span>
                            <section>
                                <?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_wed'])?$salonOpeningHours['SalonOpeningHour']['wednesday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['wednesday_to']:__('closed',true); ?>     
                            </section>
                        </li>
                        <li>
                            <label><?php echo __('thursday',true);?></label>
                            <span>:</span>
                            <section>
                    <?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_thu'])?$salonOpeningHours['SalonOpeningHour']['thursday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['thursday_to']:__('closed',true); ?>     
                            </section>
                        </li>
                        <li>
                            <label><?php echo __('friday',true);?></label>
                            <span>:</span>
                            <section>
                             <?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_fri'])?$salonOpeningHours['SalonOpeningHour']['friday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['friday_to']:__('closed',true); ?>     
                            </section>
                        </li>
                        <li>
                        	<label><?php echo __('saturday',true);?></label>
                            <span>:</span>
                            <section>
                         <?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_sat'])?$salonOpeningHours['SalonOpeningHour']['saturday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['saturday_to']:__('closed',true); ?>     

                            </section>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
		<?php $facilityDetail = $this->requestAction(array('controller' => 'search', 'action' => 'getFacilityDetail',$user['User']['id']));
		
		//pr($galleryImages);?>
		
						<!--<div class="info-details">
							<h4 class="headding">Suitable for</h4>
						    <ul class="clearfix">
							<li>Business People</li>
						    </ul>
						</div> -->
			
						<div class="info-details">
							<h4 class="headding">Features &amp; Facilities</h4>
						    <ul class="clearfix bod-btm-non mrgn-btm-non">
							<li>
								<label>Kid Friendly</label>
							    <span>:</span>
							    <section>
								<?php if(isset($facilityDetail['FacilityDetail']['kids'])) {
									switch ($facilityDetail['FacilityDetail']['kids']){
									    case 1:
										echo "<li>Yes</li>";
										break;
									    case 2:
										echo "<li>Kids Only</li>";
										break;
									    case 3:
										echo "<li>No</li>";
										break;
									    default:
										echo "<li>No</li>";
									}	
								}else{
									echo "<li>No</li>";	
								}?>
							    </section>
							</li>
							<li>
								<label>Accepts Walk-in</label>
							    <span>:</span>
							    <section>
								<?php if(isset($user['FacilityDetail']['walk_in'])) {
									switch ($user['FacilityDetail']['walk_in']){
									    case 0:
										echo "<li>No</li>";
										break;
									     case 1:
										echo "<li>Yes</li>";
										break;
									
									    default:
										echo "<li>No</li>";
									}	
								}else{
									echo "<li>No</li>";	
								} ?>
							    </section>
							</li>
							<li>
								<label>Payment</label>
							    <span>:</span>
							    <section>	<?php if(!empty($facilityDetail['FacilityDetail']['payment_method'])){
								$i = unserialize($facilityDetail['FacilityDetail']['payment_method']);
								
							switch ($i[0]){
								    case 1:
									echo "<li>Visa and MasterCard</li>";
									break;
								    case 2:
									echo "<li>Discover</li>";
									break;
								    case 3:
									echo "<li>American Express</li>";
									break;
								    case 4:
									echo "<li>Debit</li>";
									break;
								    case 5:
									echo "<li>Other Credit Cards</li>";
									break;
								    case 6:
									echo "<li>Cash</li>";
									break;
								    case 7:
									echo "<li>Checks</li>";
									break;
								default:
									echo "<li>N.A</li>";
								
								}
							}else{
									echo "<li>N.A</li>";
							} ?>
							   </section>
							</li>
							<li>
					                    <label>WI-FI access</label>
							    <span>:</span>
							    <section><?php if(isset($facilityDetail['FacilityDetail']['wifi'])) {
									switch ($facilityDetail['FacilityDetail']['wifi']){
									    case 0:
										echo "<li>Not Available</li>";
										break;
									     case 1:
										echo "<li>Available</li>";
										break;
									
									    default:
										echo "<li>Not Available</li>";
									}	
								}else{
									echo "<li>Not Available</li>";	
								} ?>
								</section>
							</li>
					      <?php $salonOpolicyDetail = $this->requestAction(array('controller' => 'search', 'action' => 'getPolicyDetail',$user['User']['id']));//pr($galleryImages);?>
							<li>
					                    <label>Cancellation </label>
							    <span>:</span>
							    <section><?php
							    if(isset($salonOpolicyDetail['SalonOnlineBookingRule']['allow_cancel'])) {
									switch ($salonOpolicyDetail['SalonOnlineBookingRule']['allow_cancel']){
									    case 0:
										echo "<li>Not allowed</li>";
										break;
									     case 1:
										echo "<li>Allowed</li>";
										break;
									
									    default:
										echo "<li>Not allowed</li>";
									}	
								}else{
									echo "<li>Not Available</li>";	
								} ?>
							</section>
							</li>
							
							<li>
					                    <label>Re-schedule</label>
							    <span>:</span>
							    <section><?php
							    if(isset($salonOpolicyDetail['SalonOnlineBookingRule']['allow_reschedule'])) {
									switch ($salonOpolicyDetail['SalonOnlineBookingRule']['allow_reschedule']){
									    case 0:
										echo "<li>Not allowed</li>";
										break;
									     case 1:
										echo "<li>Allowed</li>";
										break;
									
									    default:
										echo "<li>Not allowed</li>";
									}	
								}else{
									echo "<li>Not Available</li>";	
								} ?>
							</section>
							</li>
						    </ul>
						</div>                
					</div>
				</div>