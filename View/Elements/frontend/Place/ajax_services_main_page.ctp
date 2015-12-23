<div class="panel-body">
              <div class="vendor-deal-content vendor-service clearfix">
                 <?php if(count($subService)){ 
                     foreach($subService as $sub_service){
			 
		     ?>
                  <div class="v-deal">
                      <div class="v-deal-box">
                          <div class="upper">
                              <?php 
                               echo $this->Html->image($this->Common->serviceImage(isset($sub_service['SalonServiceImage']['0']['image'])?$sub_service['SalonServiceImage']['0']['image']:''),array('class'=>" ")); ?>
                              <!--<img src="img/1.jpg" alt="" title=""/>-->
                          </div>
                          <div class="bottom clearfix">
			      <p class="p1">
				<?php  if(!empty($sub_service['SalonService'][$lang.'_name'])){
					$serviname = $sub_service['SalonService'][$lang.'_name'];
				    }elseif(!empty($sub_service['Service'][$lang.'_name'])){
					$serviname = $sub_service['Service'][$lang.'_name'];
				    }else{
					$serviname = $sub_service['Service']['eng_name'];
				    }
				   echo substr($serviname,0,30); 
				    ?>
			      </p>
                            <p class="p3">
				<button type="button" data-id="<?php echo $sub_service['SalonService']['id']; ?>" class="book-now forBooking" ><?php echo ($sub_service['SalonServiceDetail']['sold_as'] == 2)? __('buy_voucher',true) : __('book_now',true); ?></button>
			    </p>
                            <p class="p2">
                                  <?php
				    $servicePrice = $this->frontCommon->getServicePrice($sub_service['SalonService']['id']);
				    if($servicePrice['from']){
                                        echo __('from',true).' '.__('AED',true).' '.$servicePrice['full'].'';
                                    }
                                    elseif($servicePrice['sell']){
                                        echo '<span>'.__('AED',true).$servicePrice['full'].' </span>&nbsp;<b>'.__('AED',true).' '.$servicePrice['sell'].'</b>';
                                    }
                                    else{
                                        echo __('AED',true).' '. $servicePrice['full'];
                                    }
				    $lowestPrice[] = $servicePrice['full'];
				    ?>
                            </p>
                       </div>
                      </div>
                  </div>
                 <?php  } } ?>
              </div>
    </div>
         