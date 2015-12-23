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
        <div class="map-box1">
        	<i class="map-view-icon largeMapStylist"></i> <?php echo __('View search results on map' , true); ?>
        </div>
        <div class="left-heading">
            <?php echo __('Location' , true); ?>
        </div>
        <div class="subnav">
	    <div class="subnav-title">
		<input rel=""  value="<?php echo $loc1; ?>" name="location" id="pac-input" class="controls" type="text" placeholder="Type to search">
		<input type="hidden" name="loc" value="<?php echo $city_id; ?>" id="loc">
   		<ul  class="auto-search scroll" id="locations-left"  style="height: 162px;"></ul>
	    </div>
        </div>
        
        <div class="left-heading"><?php echo __('Salon Type' , true); ?></div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu" style="display: block;">
                <?php 
                    $salon_type = '';
                    if(!empty($salon_data)) {
                        if(!empty($this->request->data['salon_type']) && isset($this->request->data['salon_type'])){
                            $salon_type = $this->request->data['salon_type'];
                        }
                        
                        foreach($salon_data as $key => $val){ ?>
                            <li>
                                <span>
                                    <input name="service_to" class="service_to" type="radio" id="<?php echo $key?>"  value="<?php echo $key ?>" <?php if($salon_type == $key){ echo "checked='checked'";}?> />
                                    <label class="new-chk" for="<?php echo $key?>"><?php echo $val; ?></label>
                                </span>
                            </li>
                    <?php }} ?>  
              </ul>
          </div>
        </div>
        
        <div class="left-heading"><?php echo __('CheckIn Date',true);?></div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu avail-outer" style="display: block;">
                    <?php
                        $available_date = '';
                        if(!empty($this->request->data['available_date']) && isset($this->request->data['available_date'])){
                            $available_date = $this->request->data['available_date'];
                        }
                    ?>
                  <li><input type="datetime-local" paceholder="Any Date" class="avail select_date" name='availability_date' readonly="readonly" value="<?php echo $available_date;?>"></li>                  
              </ul>
          </div>
        </div> 
        
        <div class="left-heading"><?php echo __('Number of Nights' , true); ?></div>
        <div class="subnav">
          <div class="subnav-title">
              <ul class="subnav-menu" style="display: block;">
                  <?php
                    $break_type = '';
		    $breaktypes = $this->Common->getSpaBreakType();
                    if(!empty($breaktypes)) {
                        if(!empty($this->request->data['break_types']) && isset($this->request->data['break_types'])){
                            $break_type= $this->request->data['break_types'];
                        }
                        foreach($breaktypes as $key1 => $val1){ ?>
			<li>
                            <span>
                                <input name="break_type" class="break_type" type="radio" id="<?php echo $key1?>"  value="<?php echo $key1 ?>" <?php if($break_type == $key1){ echo "checked='checked'";}?> />
                                <label class="new-chk" for="<?php echo $key1?>"><?php echo $val1; ?></label>
                            </span>
			</li>
		<?php }} ?>  
              </ul>
          </div>
        </div>
        
        <div class="left-heading">I want to Book</div>
        <div class="subnav">
	    <div class="subnav-title">
              <ul class="subnav-menu" style="display: block;">
                  <li>
		    <a href="javascript:void(0);">
		    <span>
			<input id="sold_as_online" name="sold_as" type="radio"  class="sold_as" value="1"/>
			<label class="new-chk" for="sold_as_online">Online</label>
		    </span>
		    </a>
		  </li>
		  <li>
		    <a href="javascript:void(0);">
		    <span>
			<input id="sold_as_evoucher" name="sold_as" type="radio"  class="sold_as" value="2"/>
			<label class="new-chk" for="sold_as_evoucher">E-voucher (Only Voucher)</label>
		    </span>
		    </a>
		  </li>
		  <!--<li>
		    <a href="javascript:void(0);">
		    <span>
			<input id="sold_as_offline" name="sold_as" type="radio"  class="sold_as" value="3"/>
			<label class="new-chk" for="sold_as_offline">Both</label>
		    </span>
		    </a>
		  </li>-->
		  <li>
		    <a href="javascript:void(0);">
		    <span>
			<input id="sold_as_all" name="sold_as" type="radio"  class="sold_as" value="4"/>
			<label class="new-chk" for="sold_as_all">Show All</label>
		    </span>
		    </a>
		  </li>
              </ul>
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
              <button type="button" class="reset"><?php echo __('Reset all filters',true);?></button>
          </div>
        </div>



	