<div style="display: none" class="modal theAllMapModal fade bs-example-modal-sm" id="mapSalonStylist" role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				<button data-dismiss="modal" class="close" type="button"><span>x</span><span class="sr-only"><?php echo __('Close' , true); ?></span></button>
				<h4 id="myModalLabel" class="modal-title"><?php echo __('MAP' , true); ?></h4>
			</div>
			<div class="modal-body clearfix" style="height: 500px;width: 100%;">
				<div  id="mapAllSalon" style="height: 100%;"></div>
			</div>
		</div>
	</div>
</div>
<div class="map-box1 largeMapStylist">
	<i class="map-view-icon "></i> <?php echo __('View search results on map' , true); ?>
</div>
<div class="left-heading">
    <?php echo __('Location' , true); ?>
</div>
<div class="subnav">
    <div class="subnav-title">
	<input rel="" value="" name="location" id="pac-input" class="controls" type="text" placeholder="Type to search">
	<input type="hidden" name="loc" value="" id="loc">
	<ul  class="auto-search scroll" id="locations-left"  style="height: 162px;"></ul>
    </div>
</div>
<div class="left-heading"><?php echo __('Salon Type' , true); ?></div>
<div class="subnav">
	<div class="subnav-title">
		<ul class="subnav-menu" style="display: block;">
			<?php if(!empty($salon_data)) {
				foreach($salon_data as $key => $val){
					$checked_val = '';
					if(!empty($this->request->data['service_to'])){
						if($this->request->data['service_to'] == $key){
							$checked_val = 'checked = "checked"';
						} else {
							$checked_val = '';
						}
					} ?>
					<li>
						<span>
							<input <?php echo $checked_val;?> name="service_to" class="service_to" type="radio" id="<?php echo $key?>"  value="<?php echo $key ?>" />
							<label class="new-chk" for="<?php echo $key?>"><?php echo $val; ?></label>
						</span>
					</li>
				<?php }
			} ?>  
		</ul>
	</div>
</div>
<div class="left-heading"><?php echo __('Availability',true);?></div>
<div class="subnav">
	<div class="subnav-title">
		<ul class="subnav-menu avail-outer" style="display: block;">
			<input type="hidden" name="select_date" value="" id="select_date" >
			<input type="hidden" name="select_time" value="" id="select_time" >
			<li><input type="text" value="Any Date" class="avail select_date"></li>
			<li><input type="text" value="Any Time" class="avail select_time timePKr"></li>
		</ul>
	</div>
</div> 
<div class="left-heading">Treatment Type</div>
<div class="subnav">
	<div class="subnav-title">
		<ul class="subnav-menu treatmentTT" style="display: block;">
			<?php if(!empty($getTreatment)) {
				$i= 0; $j = 0; $addClass=''; $addEvent = '';
				foreach($getTreatment as $treat){
					foreach($treat as $key=>$val){
						if($i >6){
							$j++;
							$addClass = 'hidden';
							$addEvent = 'showhidden';
						}
						$value = $this->frontCommon->servicename($val); ?>
						<li class="<?php echo $addClass ; ?> <?php echo $addEvent ?>"><a href="javascript:void(0)"><span><input value="<?php echo $val['Service']['id'];?>" name="service_parent"  type="radio" class="treatment" id="services_<?php echo $i; ?>" /><label class="new-chk" for="services_<?php echo $i; ?>">
							<?php echo $value; ?>
						</label></span></a>
						</li>
						<?php $i++;
					}
				}
			}?>
		</ul>
		<?php if($i > 5 ) { ?>
			<a href="javascript:void(0);" class="show-more showservices"><?php echo __('Show more',true); ?></a>
		<?php } ?>
	</div>
</div>

<div class="treatment-display" style="display:none;">
	<div class="left-heading"><?php echo __('Treatment',true);?></div>
	<div class="subnav">
		<div class="subnav-title">
			<ul class="treat-child subnav-menu" class="subnav-menu" style="display: block;list-style:none;">
			    
			</ul>
		</div>
	</div>
</div>
<div class="subnav">
	<div class="subnav-title text-center">
	    <button type="button" class="reset"><?php echo __('Reset all filters',true);?></button>
	</div>
</div>
<style>
	.largeMapStylist{
		cursor: pointer;
	}
</style>