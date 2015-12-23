<style type="text/css">
	.largeMap{
		cursor: pointer;
	}
</style>
<div id="bs-example-navbar-collapse-2" class="v-left-side collapse">
	<input type="hidden" name="inner-search" value="1">
	<div class="map-box1 largeMap">
	    <i style="cursor: pointer" class="map-view-icon"></i>View search results on map
	</div>
	<?php
	$salonName = isset($this->data['salon_name']) ? $this->data['salon_name'] :' '?>
	<input id="salonName" type="hidden" name="salon_name" value="<?php echo $salonName;?>">
	<div class="left-heading">Location</div>
	<div class="subnav">
		<div class="subnav-title">
		<?php
		 $locationCity = (isset($this->data['locationCity']) && !empty($this->data['locationCity'])) ? $this->data['locationCity'] :'';
		 $locationCityName = '';
		 if(!empty($locationCity)){
		    $locationCityName = $this->Common->getCity($locationCity);   
		 }
		 //echo 'ff'.$locationCity.'gg';
		 //echo 'tt'.$locationCityName.'hh';
		//exit;
		// $locationCity = isset($this->data['locationCity']) ? $this->data['locationCity'] :' '
		
		?>
			<input rel=""  value="<?php echo $locationCityName; ?>" name="location" id="pac-input" class="controls" type="text" placeholder="Type to search">
			<input type="hidden" name="loc" value="<?php echo $locationCity; ?>" id="loc">
			<ul  class="auto-search scroll" id="locations-left"  style="height: 162px;"></ul>
		</div>
	</div>
	<div class="left-heading">Salon Type</div>
	<div class="subnav">
		<div class="subnav-title">
			<ul class="subnav-menu" style="display: block; ">
				<?php
				echo $this->Form->hidden('hm_search',array('type'=>'input','div'=>false,'label'=>false,'name'=>'hm_search'));
				$salon_data = $this->Common->serviceprovidedTo();
				if(!empty($salon_data)) {
				    foreach($salon_data as $key => $val){
					if(!empty($this->request->data['service_to']) && ($this->request->data['service_to'] == $key)){
					    $checked_st = 'checked="checked"';
					} else {
					    $checked_st = '';
					}?>
					<li>
					    <a href="javascript:void(0);"><span>
					    <input name="service_to" class="service_to" type="radio" id="<?php echo $key?>" value="<?php echo $key ?>" <?php echo $checked_st;?> />
					    <label class="new-chk" for="<?php echo $key?>"><?php echo $val; ?></label>
					    </span></a>
					</li>
				    <?php }
				} ?> 
			</ul>
		</div>
	</div>
	<div class="left-heading">I Want</div>
	<div class="subnav">
		<div class="subnav-title">
			<ul class="subnav-menu" style="display: block;">
				<?php
				$iwant_bk = '';
				$menu_check = '';
				$deal_check = '';
				$package_check = '';
				$spaday_check = '';
				if(!empty($this->request->data['i_want'])){
				    $iwant_bk = $this->request->data['i_want'];
				}
				if($iwant_bk == 'menu'){
				    $menu_check = "checked='checked'";
				}
				if($iwant_bk == 'deal'){
				    $deal_check = "checked='checked'";
				}
				if($iwant_bk == 'package'){
				    $package_check = "checked='checked'";
				}
				if($iwant_bk == 'spaday'){
				    $spaday_check = "checked='checked'";
				}?>
				<li>
					<a href="javascript:void(0);">
						<span>
							<input class="i_want" type="radio" id="test3" name="i_want" <?php echo $menu_check?> value="menu"/>
							<label class="new-chk" for="test3">Menu</label>
						</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);"><span>
						<input class="i_want" type="radio" id="test4" name="i_want" <?php echo $deal_check?> value="deal" />
						<label class="new-chk" for="test4">Deals</label>
						</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);">
						<span>
							<input class="i_want" type="radio" id="test5" name="i_want" <?php echo $package_check?> value="package" />
							<label class="new-chk" for="test5">Packages</label>
						</span>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);">
					    <span>
						<input class="i_want" type="radio" id="test6" name="i_want" <?php echo $spaday_check;?> value="spaday" />
						<label class="new-chk" for="test6">Spa Days</label>
					    </span>
					</a>
				</li>
			</ul>
		</div>
		
	</div>
	<div class="left-heading">I want to Book</div>
	<div class="subnav">
		<div class="subnav-title">
			<?php $sold_as_online = '';
			$sold_as_ev = '';
			$sold_outcall = '';
			$sold_as_all = '';
			if(isset($this->request->data['sold_as'])){
				if($this->request->data['sold_as'] == 1){
					$sold_as_online = "checked = 'checked'";
				} else if($this->request->data['sold_as'] == 2){
					$sold_as_ev = "checked = 'checked'";
				} else if($this->request->data['sold_as'] == 3){
					$sold_outcall = "checked = 'checked'";
				} else if($this->request->data['sold_as'] == 0){
					$sold_as_all = "checked = 'checked'";
				} 
			} else {
				$sold_as_all = "checked = 'checked'";
			}?>
			<ul class="subnav-menu" style="display: block;">
				<li>
					<a href="#">
						<span>
							<input id="sold_as_online" name="sold_as" type="radio"  class="sold_as" value="1" <?php echo $sold_as_online;?>/>
							<label class="new-chk" for="sold_as_online">Online</label>
						</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span>
							<input id="sold_as_evoucher" name="sold_as" type="radio"  class="sold_as" value="2" <?php echo $sold_as_ev;?>/>
							<label class="new-chk" for="sold_as_evoucher">E-voucher (Only Voucher)</label>
						</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span>
							<input id="sold_as_offline" name="sold_as" type="radio"  class="sold_as" value="0" <?php echo $sold_as_all;?>/>
							<label class="new-chk" for="sold_as_offline">Show All</label>
						</span>
					</a>
				</li>
				<li>
					<a href="#">
						<span>
							<input id="sold_as_all" name="sold_as" type="radio"  class="sold_as" value="3" <?php echo $sold_outcall;?>/>
							<label class="new-chk" for="sold_as_all">Out Call</label>
						</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="left-heading">Availability</div>
	<div class="subnav">
		<div class="subnav-title">
			<ul class="subnav-menu avail-outer" style="display: block;">
				<?php if(!empty($this->request->data['select_date'])){
					$sel_date = $this->request->data['select_date'];
				} else {
					$sel_date = '';
				}
				if(!empty($this->request->data['select_time'])){
					$sel_time = $this->request->data['select_time'];
				} else {
					$sel_time = '';
				}
				?>
				<li><input value = "<?php echo $sel_date;?>" type="text" name="select_date" placeholder="Any Date" id="select_date" class="avail select_date"></li>
				<li><input value = "<?php echo $sel_time;?>" type="text" name="select_time" placeholder="Any Time" id="select_time" class="avail select_time timePKr"></li>
			</ul>
		</div>
	</div>
	<div class="left-heading">Treatment Type</div>
	<div class="subnav">
		<div class="subnav-title">
			<ul class="subnav-menu treatmentTT" style="display: block;">
				<?php if(!empty($getTreatment)) {
					$i= 0;
					$j = 0;
					$addClass='';
					$addEvent = '';
					//foreach($getTreatment as $treat){
						foreach($treat as $key=>$val){
							if($i >6){
								$j++;
								$addClass = 'hidden';
								$addEvent = 'showhidden';
							}
							$ckecked_treatment = '';
							if(!empty($this->request->data['service_parent'])){
								if($this->request->data['service_parent'] == $val['Service']['id']){
									$ckecked_treatment = 'checked = "checked"';
								} else {
									$ckecked_treatment = '';
								}
							}
							$value = $this->frontCommon->servicename($val);?>
							<li class="<?php echo $addClass ; ?> <?php echo $addEvent ?>">
								<a href="javascript:void(0)">
									<span>
										<input <?php echo $ckecked_treatment;?> value="<?php echo $val['Service']['id'];?>" name="service_parent"  type="radio" class="treatment" id="services_<?php echo $i; ?>" />
										<label class="new-chk" for="services_<?php echo $i; ?>">
											<?php echo $value; ?>
										</label>
									</span>
								</a>
							</li>
							<?php $i++;
						}
					//}
				} ?>
			</ul>
			<?php if($i > 5 ) { ?>
				<a href="javascript:void(0);" class="show-more showservices"><?php echo __('Show more',true); ?></a>
			<?php } ?>
		</div>
	</div> 
	<?php if(!empty($services_html)){
		$display = 'style="display:block;"';
	} else {
		$display = 'style="display:none;"';
	}?>
	<div class="treatment-display" <?php echo $display;?>>
		<div class="left-heading">Treatment</div>
		<div class="subnav">
			<div class="subnav-title">
				<ul class="treat-child subnav-menu" class="subnav-menu" style="display: block;list-style:none;">
					<?php if(!empty($services_html)){
						echo $services_html;
					} ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="left-heading">Price Range</div>
	<div class="subnav">
		<div class="subnav-title text-center">
			<input type="text" id="amount" readonly>
			<div class="pdng-tp-lft-rgt20">
			<div id="slider-range" class="range-slider"></div></div></br>
			<input id="min_price" type="hidden" name="min_price" value="">
			<input id="max_price" type="hidden" name="max_price" value="">
			<button type="button" class="reset">Reset all filters</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).find(".scroll").mCustomScrollbar({
		    advanced:{updateOnContentResize: true}
		});	
	})
</script>
