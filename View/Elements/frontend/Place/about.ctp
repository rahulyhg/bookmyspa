<?php $lang =  Configure::read('Config.language'); ?>
<div class="wrapper">
	<div class="container">
    	<div class="fixed-rgt">
        	<div class="booking-section about clearfix">
            	<!--<div class="info-details">
                	<h4 class="headding"><?php echo __('Saloon_Rating',true); ?></h4>
                    <ul class="clearfix saloon-rating">
                    	<li>
							<label><?php echo __('punctuality',true);?></label>
							<span>:</span>
                            <section>
                            	<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <?php echo __('Excellent',true);?> 
                            </section>
                        </li>
                        <li>
                            <label><?php echo __('Value',true);?></label>
							<span>:</span>
                            <section>
                            	<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>	<?php echo __('Excellent',true);?> 
                            </section>
                        </li>
                        <li>
                            <label><?php echo __('services',true);?></label>
							<span>:</span>
                            <section>
                            	<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <?php echo __('Excellent',true);?> 
                            </section>
                        </li>
                    </ul>
                    <button class="purple-btn" type="button"> <?php echo __('book_now',true);?></button>
		</div>-->
                <div class="info-details">
                    <h4 class="headding"> <?php echo __('contact_info',true);?></h4>
                    <h5><?php echo $userDetails['Salon'][$lang.'_name']; ?></h5>
                    <ul class="clearfix contact-details">
                    	<li><i class="fa fa-map-marker"></i>
                        	<span>
				<?php 	$city = $this->Common->getCity($userDetails['Address']['city_id']);
					if(!empty($city))
						echo $city.', ';
					$state = $this->Common->getState($userDetails['Address']['state_id']);
					if(!empty($state))
						echo $state; ?>
							</span>
                        </li>
                        <li><i class="fa fa-envelope"></i>
                        	<span><a href="mailto:<?php echo $userDetails['Salon']['email'];?>" ><?php echo $userDetails['Salon']['email'];?></a></span>
                        </li>
                        <li><i class="fa fa-phone"></i>
                        	<span><?php
					$phone_code = ($userDetails['Contact']['country_code'])?$userDetails['Contact']['country_code']:'+971';
					if(!empty($userDetails['Contact']['day_phone'])){
					   echo $phone_code.'-'.$userDetails['Contact']['day_phone'];	
					}else{
					   echo '-';	
					}
				?></span>
                        </li>
                        <li><i class="fa fa-globe"></i>
                            <span><?php 
                            $business_url =  ($userDetails['Salon']['business_url'] !='')?$userDetails['Salon']['business_url']:$userDetails['User']['username'];
                            echo Configure::read('BASE_URL').'/'.$business_url; ?></span>
                        </li>
                    </ul>
                </div>
                <div class="info-details">
                    <ul class="clearfix gift-details">
                    	<li class="clearfix <?php echo ($userDetails['PolicyDetail']['enable_online_booking']==0)?'disable':''; ?>">
                            <span class="icon"><i class="fa fa-calendar"></i></span>
                            <span><?php echo __('accept_online_bookings',true);?></span>
						</li>
                        <li class="clearfix <?php echo ($userDetails['PolicyDetail']['enable_gfvocuher']==0)?'disable':''; ?>">
                            <span class="icon"><i class="fa fa-tag"></i></span>
                            <span><?php echo __('accept_voucher',true);?></span>
			</li>
                        <li class="clearfix <?php echo ($userDetails['PolicyDetail']['enable_sieasta_voucher']==0)?'disable':''; ?>">
                            <span class="icon"><i class="fa  fa-gift"></i></span>
                            <span><?php echo __('sieasta_gift_card_accepted',true);?></span>
			</li>
                    </ul>
                </div>
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
            </div>
        </div>
        		<div class="big-lft">
        	<div class="booking-section about clearfix">
            <div class="deal-box-outer">
            	<div class="info-details">
                	<h4 class="headding"><?php echo __('description',true); ?></h4>
                    <ul class="clearfix">
                    	<li>
                         <?php echo (!empty($userDetails['Salon'][$lang.'_description']))?$userDetails['Salon'][$lang.'_description']:$userDetails['Salon']['eng_description']; ?>   
                        </li>
                    </ul>
                </div>
                <div class="info-details">
                	<h4 class="headding"><?php echo __('special_instruction',true); ?></h4>
                    <ul class="clearfix">
                    	<li><?php echo (!empty($userDetails['FacilityDetail'][$lang.'_special_instruction']))?$userDetails['FacilityDetail'][$lang.'_special_instruction']: ( (!empty($userDetails['FacilityDetail']['eng_special_instruction'])? $userDetails['FacilityDetail']['eng_special_instruction'] :'----' )); ?>   </li>
                    </ul>
                </div>
                <div class="info-details">
                	<h4 class="headding"><?php echo __('features_n_facilities',true); ?></h4>
                    <ul class="clearfix feature bod-btm-non mrgn-btm-non">
                    	<li>
			<label><?php echo __('kid_friendly',true); ?>	</label>
                            <span>:</span>
                            <section><?php
                            $kidFrnd = $this->Common->kidsfrnd();
                            echo ($userDetails['FacilityDetail']['kids'])?$kidFrnd[$userDetails['FacilityDetail']['kids']]:__('no',true); 
                           ?> </section>   
                        </li>
			
		<li>
                         <label><?php echo __('Business Type',true); ?>	</label>
                            <span>:</span>
                            <section><?php
                             if(!empty($userDetails['Salon']['business_type_id']) && isset($bType)){
				foreach($bType as $kB=>$bTypeVal){ 
					if(!empty($userDetails['Salon']['business_type_id'])){
						if(in_array($kB,unserialize($userDetails['Salon']['business_type_id']))){
						    $business_type[] = $bTypeVal;
						}
				    } 
				
				}
				echo (isset($business_type) && count($business_type))?implode(', ' ,$business_type):'---';
				}
				
				?>
			    
			                            
			   </section>   
                        </li>
			
			
			<li>
                        	<label><?php echo __('kid_friendly',true); ?>	</label>
                            <span>:</span>
                            <section><?php
                            $kidFrnd = $this->Common->kidsfrnd();
                            echo ($userDetails['FacilityDetail']['kids'])?$kidFrnd[$userDetails['FacilityDetail']['kids']]:__('no',true); 
                           ?> </section>   
                        </li>
			
			
                       <li>
                        	<label><?php echo __('parking_fees',true); ?></label>
                            <span>:</span>
                            <section>
                                <?php 
                                $parking = $this->Common->parkingFee();
                                $salon_parking = ($userDetails['FacilityDetail']['parking_fee'])?  unserialize($userDetails['FacilityDetail']['parking_fee']):'';
                                echo $this->Common->getImplodeVal($parking ,$salon_parking ,",&nbsp;");
                                 ?>
                            </section>
                        </li>
			 <li>
                        	<label><?php echo __('accepts_walkin',true); ?></label>
                            <span>:</span>
                             <section><?php echo ($userDetails['FacilityDetail']['walk_in']==1)?__('yes',true):__('no',true); ?></section>
                        </li>
			
                        <li>
                          <label><?php echo __('wifi_access',true); ?></label>
                            <span>:</span>
                            <section><?php echo ($userDetails['FacilityDetail']['wifi']==1)?__('available',true):__('unavailable',true); ?></section>
                        </li>
                        <li>
                            <label><?php echo __('snack_bar',true); ?></label>
                            <span>:</span>
                            <section><?php echo __($userDetails['FacilityDetail']['snack_bar']==1)?__('available',true):__('unavailable',true); ?></section>
                        </li>
						<li>
                            <label><?php echo __('beer_wine_bar',true); ?></label>
                            <span>:</span>
                            <section><?php echo __($userDetails['FacilityDetail']['beer_wine_bar']==1)?__('available',true):__('unavailable',true); ?></section>
                        </li>
			<li>
                            <label><?php echo __('TV',true); ?></label>
                            <span>:</span>
                            <section><?php echo __($userDetails['FacilityDetail']['tv']==1)?__('available',true):__('unavailable',true); ?></section>
                        </li>
                        <li>
                        	<label><?php echo __('handicap_access',true); ?></label>
                            <span>:</span>
                            <section><?php echo __($userDetails['FacilityDetail']['hadicap_acces']==1)?__('available',true):__('unavailable',true); ?></section>
                        </li>
			<li>
                        <label><?php echo __('Other Languages',true); ?></label>
                            <span>:</span>
                            <section><?php echo __($userDetails['FacilityDetail']['other_lang'])?$userDetails['FacilityDetail']['other_lang']:'----'; ?></section>
                        </li>
			
			<li>
                            <label><?php echo __('spoken_langs',true); ?></label>
                            <span>:</span>
                            <section><?php 
                            $all_spoken = $this->Common->spokenLang();
                            $salon_langs = ($userDetails['FacilityDetail']['spoken_language'])?  unserialize($userDetails['FacilityDetail']['spoken_language']):'';
                            echo $this->Common->getImplodeVal($all_spoken ,$salon_langs ,",&nbsp;");
                             ?></section>
                        </li>
			 <?php $salonOpolicyDetail = $this->requestAction(array('controller' => 'search', 'action' => 'getPolicyDetail',$userDetails['User']['id']));//pr($galleryImages);?>
						
			<li>
                        <label><?php echo __('Cancellation',true); ?></label>
                            <span>:</span>
                            <section>
			    <?php
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
                        <label><?php echo __('Re-schedule',true); ?></label>
                            <span>:</span>
                            <section>
			    <?php
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
                    <ul class="clearfix feature one bod-btm-non mrgn-btm-non">
                    	<li>
                            <label><?php echo __('payment_methods',true); ?></label>
                            <span>:</span>
                            <section>
                                <?php  $all_payment = $this->Common->paymentTypes();
                                  $salon_payments = ($userDetails['FacilityDetail']['payment_method'])?  unserialize($userDetails['FacilityDetail']['payment_method']):'';
                                  echo $this->Common->getImplodeVal($all_payment ,$salon_payments ,"&nbsp;/&nbsp;");   
                            ?>
                             </section>
                        </li>
                        <li>
                        	<label><?php echo __('cancellation_policy',true); ?></label>
                            <span>:</span>
                            <section><?php echo (!empty($userDetails['FacilityDetail'][$lang.'_cancel_policy']))?$userDetails['FacilityDetail'][$lang.'_cancel_policy']: ( (!empty($userDetails['FacilityDetail']['eng_cancel_policy'])? $userDetails['FacilityDetail']['eng_cancel_policy'] :'----' )); ?></section>
                        </li>
			<!-- <li>
                        	<label><?php //echo __('Special Instruction',true); ?></label>
                            <span>:</span>
                            <section><?php //echo (!empty($userDetails['FacilityDetail'][$lang.'_special_instruction']))?$userDetails['FacilityDetail'][$lang.'_special_instruction']: ( (!empty($userDetails['FacilityDetail']['eng_special_instruction'])? $userDetails['FacilityDetail']['eng_special_instruction'] :'----' )); ?></section>
                        </li> -->   
			
                    </ul>
					<?php //pr($userDetails['FacilityDetail']); ?>
                </div>                
            </div>
        </div>
            <div class="clearfix"></div>
            <div class="map-box">
            	<div id="map1" class="map">
                	
                </div>
                <div class="caption-container">
                	<h3><?php echo $userDetails['Salon'][$lang.'_name'] ?></h3>
                        <p><i class="fa  fa-map-marker"></i><?php echo $userDetails['Address']['address']; ?><?php
					echo ', ';
					$city = $this->Common->getCity($userDetails['Address']['city_id']);
					if(!empty($city))
						echo $city.', ';
					$state = $this->Common->getState($userDetails['Address']['state_id']);
					if(!empty($state))
						echo $state; ?></p>
                </div>
            </div>
        </div>
        
        <div class="fixed-rgt  tab-show">
        	<div class="booking-section about clearfix">
                <div class="info-details">
                        <h4 class="headding"><?php echo __('Saloon_Rating',true); ?></h4>
                        <ul class="clearfix saloon-rating">
                            <li>
                                <label><?php echo __('punctuality',true);?></label>
                                <span>:</span>
                                <section>
                                    <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <?php echo __('Excellent',true);?>
                                </section>
                            </li>
                            <li>
                                <label><?php echo __('Value',true);?></label>
                                <span>:</span>
                                <section>
                                    <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <?php echo __('Excellent',true);?>
                                </section>
                            </li>
                            <li>
                                <label><?php echo __('services',true);?></label>
                                <span>:</span>
                                <section>
                                    <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <?php echo __('Excellent',true);?>
                                </section>
                            </li>
                        </ul>
                        <button class="purple-btn" type="button"><?php echo __('book_now',true);?></button>
                    </div>
                    
                <div class="info-details">
                    <h4 class="headding"><?php echo __('contact_info',true);?></h4>
                    <h5><?php echo $userDetails['Salon'][$lang.'_name']; ?></h5>
                    <ul class="clearfix contact-details">
                        <li><i class="fa fa-map-marker"></i>
                        <span>
			<?php $addressNew=explode(',',$userDetails['Address']['address']);
				echo !empty($addressNew[0]) ? $addressNew[0].',' :'';
				echo !empty($addressNew[1]) ? $addressNew[1].',' :'';
				echo !empty($addressNew[2]) ? $addressNew[2].',' :'';
				echo !empty($addressNew[3]) ? $addressNew[3].' ' :' '.$userDetails['Address']['po_box']; ?>
			</span>
                        </li>
                        <li><i class="fa fa-envelope"></i>
                             <span><a href="mailto:<?php echo $userDetails['Salon']['email'];?>" ><?php echo $userDetails['Salon']['email'];?></a></span>
                        </li>
                        <li><i class="fa fa-phone"></i>
                            <span><?php echo $userDetails['Contact']['cell_phone']; ?></span>
                        </li>
                        <li><i class="fa fa-globe"></i>
                            <span><?php 
                            $business_url =  ($userDetails['Salon']['business_url'] !='')?$userDetails['Salon']['business_url']:$userDetails['User']['username'];
                            echo Configure::read('BASE_URL').'/'.$business_url; ?></span>
                        </li>
                    </ul>
                </div>
                
                <div class="info-details">
                    <ul class="clearfix gift-details">
                        <li class="clearfix <?php echo ($userDetails['PolicyDetail']['enable_online_booking']==0)?'disable':''; ?> ">
                            <span class="icon"><i class="fa fa-calendar"></i></span>
                            <span><?php echo __('accept_online_bookings',true);?></span>
                        </li>
                        <li class="clearfix <?php echo ($userDetails['PolicyDetail']['enable_gfvocuher']==0)?'disable':''; ?>">
                            <span class="icon"><i class="fa fa-tag"></i></span>
                            <span><?php echo __('accept_voucher',true);?></span>
                        </li>
                        <li class="clearfix <?php echo ($userDetails['PolicyDetail']['enable_sieasta_voucher']==0)?'disable':''; ?>">
                            <span class="icon"><i class="fa  fa-gift"></i></span>
                            <span><?php echo __('sieasta_gift_card_not_accepted',true);?></span>
                        </li>
                    </ul>
                </div>
                
                <div class="info-details">
                    <h4 class="headding"><?php echo __('hours',true);?></h4>
                    <ul class="clearfix days-hrs">
                        <?php if(count($salonOpeningHours)){ ?>
						<li>
                            <label><?php echo __('sunday',true);?></label>
                            <span>:</span>
                            <section><?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_sun'])?$salonOpeningHours['SalonOpeningHour']['sunday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['sunday_to']:__('closed',true); ?> </section>
                        </li>
                        <li>
                            <label><?php echo __('monday',true);?></label>
                            <span>:</span>
                            <section><?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_mon'])?$salonOpeningHours['SalonOpeningHour']['monday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['monday_to']:__('closed',true); ?></section>
                        </li>
                        <li>
                            <label><?php echo __('tuesday',true);?></label>
                            <span>:</span>
                            <section><?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_tue'])?$salonOpeningHours['SalonOpeningHour']['tuesday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['tuesday_to']:__('closed',true); ?> </section>
                        </li>
                        <li>
                            <label><?php echo __('wednesday',true);?></label>
                            <span>:</span>
                            <section><?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_wed'])?$salonOpeningHours['SalonOpeningHour']['wednesday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['wednesday_to']:__('closed',true); ?></section>
                        </li>
                        <li>
                            <label><?php echo __('thursday',true);?></label>
                            <span>:</span>
                            <section><?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_thu'])?$salonOpeningHours['SalonOpeningHour']['thursday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['thursday_to']:__('closed',true); ?></section>
                        </li>
                        <li>
                            <label><?php echo __('friday',true);?></label>
                            <span>:</span>
                            <section><?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_fri'])?$salonOpeningHours['SalonOpeningHour']['friday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['friday_to']:__('closed',true); ?></section>
                        </li>
                        <li>
                            <label><?php echo __('saturday',true);?></label>
                            <span>:</span>
                            <section><?php  echo ($salonOpeningHours['SalonOpeningHour']['is_checked_disable_sat'])?$salonOpeningHours['SalonOpeningHour']['saturday_from'].' - '.$salonOpeningHours['SalonOpeningHour']['saturday_to']:__('closed',true); ?></section>
                        </li>
						<?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>

     $(document).ready(function(){
        <?php if(!empty($userDetails['Address']['latitude']) && !empty($userDetails['Address']['longitude'])){  ?>
        var zoomlevel = 14;
        var  lat = '<?php echo $userDetails['Address']['latitude']; ?>';
        var  long = '<?php echo $userDetails['Address']['longitude']; ?>';
	$(window).on( "scroll", function(){
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src ="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places;&callback=changeN";
		document.getElementsByTagName('body')[0].appendChild(script);
		 $(window).off( "scroll");
	});
	
       
   
     <?php }else{  ?>
	$(window).on( "scroll", function(){
		var script = document.createElement("script");
	       script.type = "text/javascript";
	       script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places;&callback=changeMap";
	       document.getElementsByTagName('body')[0].appendChild(script);
		$(window).off( "scroll");
	});
     <?php } ?>
     
          });    
         
	 function changeN(){
		var  lat = '<?php echo $userDetails['Address']['latitude']; ?>';
		var  long = '<?php echo $userDetails['Address']['longitude']; ?>';
			
		 if($("#map1").length > 0){
             
			var mapOptions = {
				zoom: 15,
				center: new google.maps.LatLng(lat, long)
			};
			
			var map = new google.maps.Map(document.getElementById('map1'),mapOptions);
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat,long),
				map: map
			});
			
		}
	 }
       function changeMap(){
		var showAddress='';
		var country = '<?php echo $this->Common->getCountryById($userDetails['Address']['country_id']); ?>';
		var state = '<?php echo $this->Common->getStatesBYid($userDetails['Address']['state_id']); ?>';
		var address = '<?php echo $userDetails['Address']['address']; ?>';
		var poBox =  '<?php echo $userDetails['Address']['po_box']; ?>';
		    if(address !=''){
			  showAddress+= ','+address;
		    }
		    
		    if(poBox !=''){
			  showAddress+= ','+poBox;
		    }
		    if(state !='Please Select'){
			  showAddress+= ','+state;
		    }
		    if(country !='Please Select'){
			  showAddress+= ','+country;
		    }
		    
		   var geocoder = new google.maps.Geocoder();
		geocoder.geocode({ 'address': showAddress }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			    var mapOptions = { zoom: 15, mapTypeId: google.maps.MapTypeId.ROADMAP };
			    var map = new google.maps.Map(document.getElementById('map1'), mapOptions);
			    map.setCenter(results[0].geometry.location);
			    var marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
			    });
			} else {
			    alert("Geocode was not successful for the following reason: " + status);
			}
		});
		
    }
    
    function updateMarker(marker){
        var latLng = marker.getPosition();
	 //        document.getElementById('AddressLatitude').value = latLng.lat();
	//        document.getElementById('AddressLongitude').value = latLng.lng();
    }
    
</script>