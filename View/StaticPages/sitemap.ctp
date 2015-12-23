<?php $lang =  Configure::read('Config.language'); ?>
<div class="well clearfix text-left custom_well verify">
       	<h2 class="fs-title">SITEMAP</h2>
	<?php if(!empty($deals_salon)) {?>
		<ul class="site-map">
			<li><a href="#">Deals</a>
				<ul class="clearfix">
					<?php
					$total_deal_salons = count($deals_salon);
					$cnt_deal_salon = 0;
					foreach($deals_salon as $salon_deal) { //pr($salon_deal);?>
						<li>
							<?php
							if(!empty($salon_deal['Salon'][$lang.'_name'])){
								$salon_name = $salon_deal['Salon'][$lang.'_name'];
							} else {
								$salon_name = $salon_deal['Salon']['eng_name'];
							}
							echo $this->Html->link($salon_name,
								'/'.$salon_deal['Salon']['business_url'].'/deals',
								//array('controller' => 'Place', 'action' => 'salondeals','admin'=>false,$salon_deal['User']['id'],'deals'),
								array(
									'escape' => false,
									'title' => 'Deals for '.$salon_name
								)
							)?>
						</li>
						<?php if($cnt_deal_salon < ($total_deal_salons-1) ) { ?>
							<li>|</li>
						<?php }?>
					<?php
					$cnt_deal_salon++;
					}?>
				</ul>
		    </li>
		</ul>
        <?php }?>
	<?php if(!empty($packages_salon)) {?>
		<ul class="site-map">
			<li><a href="#">Packages</a>
				<ul class="clearfix">
					<?php
					$total_packages_salons = count($packages_salon);
					$cnt_packages_salon = 0;
					foreach($packages_salon as $package_salon) { //pr($salon_deal);?>
						<li>
							<?php 
							if(!empty($package_salon['Salon'][$lang.'_name'])){
								$salon_name = $package_salon['Salon'][$lang.'_name'];
							} else {
								$salon_name = $package_salon['Salon']['eng_name'];
							}
							echo $this->Html->link($salon_name,
								'/'.$package_salon['Salon']['business_url'].'/packages',
								//array('controller' => 'Place', 'action' => 'salonpackages','admin'=>false,$package_salon['User']['id'],'packages'),
								array(
									'escape' => false,
									'title' => 'Packages for '.$salon_name
								)
							)?>
						</li>
						<?php if($cnt_packages_salon < ($total_packages_salons-1) ) { ?>
							<li>|</li>
						<?php }?>
					<?php
					$cnt_packages_salon++;
					}?>
				</ul>
		    </li>
		</ul>
        <?php }?>
	
	<?php if(!empty($spadays_salon)) {?>
		<ul class="site-map">
			<li><a href="#">SpaDays</a>
				<ul class="clearfix">
					<?php
					$total_spadays_salons = count($spadays_salon);
					$cnt_spaday_salon = 0;
					foreach($spadays_salon as $spaday_salon) { //pr($salon_deal);?>
						<li>
							<?php 
							if(!empty($spaday_salon['Salon'][$lang.'_name'])){
								$salon_name = $spaday_salon['Salon'][$lang.'_name'];
							} else {
								$salon_name = $spaday_salon['Salon']['eng_name'];
							}
							echo $this->Html->link($salon_name,
								'/'.$spaday_salon['Salon']['business_url'].'/spadays',
								//arcontroller' => 'Place', 'action' => 'salonspaday','admin'=>false,$spaday_salon['User']['id'],'spadays'),
								array(
									'escape' => false,
									'title' => 'Spadays for '.$salon_name
								)
							)?>
						</li>
						<?php if($cnt_spaday_salon < ($total_spadays_salons-1) ) { ?>
							<li>|</li>
						<?php }?>
					<?php
					$cnt_spaday_salon++;
					}?>
				</ul>
		    </li>
		</ul>
        <?php }?>
	<?php if(!empty($services_salon)) {?>
		<ul class="site-map">
			<li><a href="#">Services</a>
				<ul class="clearfix">
					<?php
					$total_services_salons = count($services_salon);
					$cnt_service_salon = 0;
					foreach($services_salon as $service_salon) { //pr($salon_deal);?>
						<li>
							<?php 
							if(!empty($service_salon['Salon'][$lang.'_name'])){
								$salon_name = $service_salon['Salon'][$lang.'_name'];
							} else {
								$salon_name = $service_salon['Salon']['eng_name'];
							}
							echo $this->Html->link($salon_name,
								'/'.$service_salon['Salon']['business_url'].'/services',
								//array('controller' => 'Place', 'action' => 'salonservices','admin'=>false,$service_salon['User']['id'],'services'),
								array(
									'escape' => false,
									'title' => 'Services for '.$salon_name
								)
							)?>
						</li>
						<?php if($cnt_service_salon < ($total_services_salons-1) ) { ?>
							<li>|</li>
						<?php }?>
					<?php
					$cnt_service_salon++;
					}?>
				</ul>
		    </li>
		</ul>
        <?php }?>
	<?php if(!empty($gcs_salon)) {?>
		<ul class="site-map">
			<li><a href="#">Gift Certificates</a>
				<ul class="clearfix">
					<?php
					$total_gcs_salons = count($gcs_salon);
					$cnt_gcs_salon = 0;
					foreach($gcs_salon as $gc_salon) { //pr($salon_deal);?>
						<li>
							<?php 
							if(!empty($gc_salon['Salon'][$lang.'_name'])){
								$salon_name = $gc_salon['Salon'][$lang.'_name'];
							} else {
								$salon_name = $gc_salon['Salon']['eng_name'];
							}
							echo $this->Html->link($salon_name,
								'/'.$gc_salon['Salon']['business_url'].'/gift-certificates',
								//array('controller' => 'Place', 'action' => 'salongiftcertificate','admin'=>false,$gc_salon['User']['id'],'gift-certificates'),
								array(
									'escape' => false,
									'title' => 'Gift Certificates for '.$salon_name
								)
							)?>
						</li>
						<?php if($cnt_gcs_salon < ($total_gcs_salons-1) ) { ?>
							<li>|</li>
						<?php }?>
					<?php
					$cnt_gcs_salon++;
					}?>
				</ul>
		    </li>
		</ul>
        <?php }?>
	<?php if(!empty($staff_salon)) {?>
		<ul class="site-map">
			<li><a href="#">Staff</a>
				<ul class="clearfix">
					<?php
					$total_staff_salons = count($staff_salon);
					$cnt_staff_salon = 0;
					foreach($staff_salon as $staf_salon) { //pr($salon_deal);?>
						<li>
							<?php 
							if(!empty($staf_salon['Salon'][$lang.'_name'])){
								$salon_name = $staf_salon['Salon'][$lang.'_name'];
							} else {
								$salon_name = $staf_salon['Salon']['eng_name'];
							}
							echo $this->Html->link($salon_name,
								'/'.$staf_salon['Salon']['business_url'].'/staff',
								//array('controller' => 'SalonStaff', 'action' => 'salonStaff','admin'=>false,$staf_salon['User']['id'],'staff'),
								array(
									'escape' => false,
									'title' => 'Staff for '.$salon_name
								)
							)?>
						</li>
						<?php if($cnt_staff_salon < ($total_staff_salons-1) ) { ?>
							<li>|</li>
						<?php }?>
					<?php
					$cnt_staff_salon++;
					}?>
				</ul>
		    </li>
		</ul>
        <?php }?>
         <ul class="site-map">
         	<li><a href="#">Your Business</a>
            	<ul class="clearfix">
                	<li><a href="#">Salon Software</a></li>
                    <li>|</li>
                    <li><a href="#">Salon Software</a></li>
                    <li>|</li>
                    <li><a href="#">Salon Software</a></li>
                    <li>|</li>
                    <li><a href="#">Salon Software</a></li>
                    <li>|</li>
                    <li><a href="#">Salon Software</a></li>
                    <li>|</li>
                    <li><a href="#">Salon Software</a></li>
                </ul>
            </li>
         </ul>
        </div>