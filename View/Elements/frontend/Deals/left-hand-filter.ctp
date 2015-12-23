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
        
        
        <div class="left-heading">Salon Type</div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu" style="display: block; ">
	      <?php
	      $salon_data = $this->Common->serviceprovidedTo(); 
	      if(!empty($salon_data)) {
		foreach($salon_data as $key => $val){ ?>
			<li>
			    <a href="javascript:void(0);"><span>
			    <input name="service_to" class="service_to" type="radio" id="<?php echo $key?>"  value="<?php echo $key ?>" />
			    <label class="new-chk" for="<?php echo $key?>"><?php echo $val; ?></label>
			    </span></a>
			</li>
		<?php }} ?> 
              </ul>
          </div>
        </div>
        <div class="left-heading">I Want</div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu" style="display: block;">
                  <li><a href="javascript:void(0);"><span><input class="i_want" type="radio" id="test3" name="i_want" value="menu" /><label class="new-chk" for="test3">Menu</label></span></a></li>
                  <li><a href="javascript:void(0);"><span><input class="i_want" type="radio" id="test5" name="i_want" value="package" /><label class="new-chk" for="test5">Packages</label></span></a></li>
                  <li><a href="javascript:void(0);"><span><input class="i_want" type="radio" id="test4" name="i_want" value="spaday" /><label class="new-chk" for="test4">Spa Days</label></span></a></li>
		 <!-- <li><a href="#"><span><input type="radio" id="test6" /><label class="new-chk" for="test6">Last Minute Deals</label></span></a></li>-->
              </ul>
          </div>
        </div>
        
        <div class="left-heading">I want to Book</div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu" style="display: block;">
                  <li>
		    <a href="#">
		    <span>
			<input id="sold_as_online" name="sold_as" type="radio"  class="sold_as" value="1"/>
			<label class="new-chk" for="sold_as_online">Online</label>
		    </span>
		    </a>
		  </li>
		  <li>
		    <a href="#">
		    <span>
			<input id="sold_as_evoucher" name="sold_as" type="radio"  class="sold_as" value="2"/>
			<label class="new-chk" for="sold_as_evoucher">E-voucher (Only Voucher)</label>
		    </span>
		    </a>
		  </li>
		  <li>
		    <a href="#">
		    <span>
			<input id="sold_as_offline" name="sold_as" type="radio"  class="sold_as" value="3"/>
			<label class="new-chk" for="sold_as_offline">Offline (Out Call Request)</label>
		    </span>
		    </a>
		  </li>
		  <li>
		    <a href="#">
		    <span>
			<input id="sold_as_all" name="sold_as" type="radio"  class="sold_as" value="4"/>
			<label class="new-chk" for="sold_as_all">Show All</label>
		    </span>
		    </a>
		  </li>
              </ul>
          </div>
        </div>
        
        <div class="left-heading"><?php echo __('Availability',true);?></div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu avail-outer" style="display: block;">
		  <input type="hidden" name="select_date" value="" id="select_date" >
		  <input type="hidden" name="select_time" value="" id="select_time" >
                  <li><input type="datetime-local" value="Any Date" class="avail select_date"></li>
                  <li><input type="datetime-local" value="Any Time" class="avail select_time timePKr"></li>
              </ul>
          </div>
        </div> 
        
        <div class="left-heading">Treatment Type</div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu" style="display: block;">
	      <?php
			if(!empty($getTreatment)) {
				$i= 0; $j = 0; $addClass=''; $addEvent = '';
				foreach($getTreatment as $treat){
					foreach($treat as $key=>$val){
						if($i >6){
								$j++;
								$addClass = 'hidden';
								$addEvent = 'showhidden';
							}
							$value = $this->frontCommon->servicename($val);
							?>
							
								<li class="<?php echo $addClass ; ?> <?php echo $addEvent ?>"><a href="javascript:void(0)"><span><input value="<?php echo $val['Service']['id'];?>" name="service_parent"  type="radio" class="treatment" id="services_<?php echo $i; ?>" /><label class="new-chk" for="services_<?php echo $i; ?>">
									<?php echo $value; ?>
								</label></span></a>
                                                                </li>
			<?php $i++;
			
			}}}?>
              </ul>
	      <?php if($i > 5 ) { ?>
		<a href="javascript:void(0);" class="show-more showservices"><?php echo __('Show more',true); ?></a>
	      <?php } ?>
          </div>
        </div> 
        
        <div class="treatment-display" style="display:none;">
		<div class="left-heading">Treatment</div>
		<div class="subnav">
		  <div class="subnav-title">
		      <ul class="treat-child subnav-menu" class="subnav-menu" style="display: block;list-style:none;"></ul>
		      <!--a href="#" class="show-more">Show more <span>(6)</span></a-->
		  </div>
		</div>
	</div>
        
        <!--div class="left-heading">Services</div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu" style="display: block;">
                  <li><a href="#"><span><input type="radio" id="test12" /><label class="new-chk" for="test12">Deep Tissue Massage</label></span></a></li>
                  <li><a href="#"><span><input type="radio" id="test13" /><label class="new-chk" for="test13">Swedish Massage</label></span></a></li>
                  <li><a href="#"><span><input type="radio" id="test14" /><label class="new-chk" for="test14">Therapeutic Massage</label></span></span></a></li>
                  <li><a href="#"><span><input type="radio" id="test15" /><label class="new-chk" for="test15">Aromatherapy Massage</label></span></a></li>
                  <li><a href="#"><span><input type="radio" id="test16" /><label class="new-chk" for="test16">Thai Massage</label></span></a></li>
                  <li><a href="#"><span><input type="radio" id="test17" /><label class="new-chk" for="test17">Stone Massage Therapy</label></span></a></li>
              </ul>
              <a href="#" class="show-more">Show more <span>(6)</span></a>
          </div>
        </div--> 
        

        
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
	
        
    
<?php echo $this->Form->end(); ?>
<script>
    $(document).ready(function(){
	$(document).find(".scroll").mCustomScrollbar({
	    advanced:{updateOnContentResize: true}
	});	
    })
</script>
<style>
	.largeMap{
		cursor: pointer;
	}
</style>
