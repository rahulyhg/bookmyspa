<div class="modal-dialog login Service-buk-size">
    <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('Services', true); ?></h4>
        </div>
        <div class="modal-body clearfix">
                <?php
                //pr($getSalonServices);
                if(!empty($getSalonServices))
                {
                ?>

	<!--accordian starts-->
    <div class="vendor-service-content clearfix">
   	 <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
             <?php if(count($getSalonServices)){ 
                 // pr($services); 
                 $i = 1;
                 foreach($getSalonServices as $service){
		    if(count($service['children']) == 0){
			$i++;
			continue;
		    }
                 ?>
            <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="heading_<?php echo $service['SalonService']['id'];?>">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion1" href="#collapsedata_<?php echo $service['SalonService']['id'];?>" aria-expanded="true" aria-controls="collapsedata_<?php echo $service['SalonService']['id'];?>">
                <?php 
                    $lang = Configure::read('Config.language'); 
                    echo ($service['SalonService'][$lang.'_name'])?$service['SalonService'][$lang.'_name']:$service['Service'][$lang.'_name']; ?>
                  (<?php echo count($service['children']); ?>)
              </a>
             <a data-toggle="collapse" data-parent="#accordion1" href="#collapsedata_<?php echo $service['SalonService']['id'];?>" aria-expanded="true" aria-controls="collapsedata_<?php echo $service['SalonService']['id'];?>" class="change-name"><?php echo  __('view_all',true); ?> <i class="fa fa-angle-down"></i></a>
            </h4>
          </div>
          <div id="collapsedata_<?php echo $service['SalonService']['id'];?>" class="panel-collapse collapse <?php echo($i==1)?'in':'' ?>" role="tabpanel" aria-labelledby="heading_<?php echo $service['SalonService']['id'];?>">
            <div class="panel-body">
              <div class="vendor-deal-content vendor-service clearfix">
                 <?php if(count($service['children'])){ 
                     foreach($service['children'] as $sub_service){
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
					echo $sub_service['SalonService'][$lang.'_name'];
				    }elseif(!empty($sub_service['Service'][$lang.'_name'])){
					echo $sub_service['Service'][$lang.'_name'];
				    }else{
					echo $sub_service['Service']['eng_name'];
				    }?>
			    </p>
			    
                            <p class="p3">
				<button type="button" data-id="<?php echo $sub_service['SalonService']['id']; ?>" class="book-now forBookingdata" ><?php echo ($sub_service['SalonServiceDetail']['sold_as'] == 2)? __('buy_voucher',true) : __('book_now',true); ?></button>
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
                 <?php $i++; } } ?>
              </div>
            </div>
          </div>
        </div>
                 <?php }} ?>
         </div>
    </div>
    <!--accordian ends-->
    <?php
     }
     else
     {
    ?>
    <div>No service found.</div>
    <?php
     }
    ?>
                
        </div>
    </div>
</div>
<script>
    $(document).on('click','.forBookingdata',function(){
            var theObj = $(this);
            var serviceId = theObj.attr('data-id');
            if(serviceId){
                bookserviceshow(serviceId,0);
            }
        });
</script>