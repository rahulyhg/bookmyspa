<div class="container serviceList">
     <div class="wrapper">
     <div class="container">
	     <!--accordian starts-->
	 <div class="vendor-service-content clearfix">
	      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		  <?php if(count($services)){ 
		      // pr($services); 
		      $i = 1;
		      foreach($services as $service){
			 if(count($service['children']) == 0){
			     $i++;
			     continue;
			 }
		      ?>
		 <div class="panel panel-default">
	       <div class="panel-heading" role="tab" id="heading_<?php echo $service['SalonService']['id'];?>">
		 <h4 class="panel-title">
		   <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $service['SalonService']['id'];?>" aria-expanded="true" aria-controls="collapse_<?php echo $service['SalonService']['id'];?>">
		     <?php 
			 $lang = Configure::read('Config.language'); 
			 echo ($service['SalonService'][$lang.'_name'])?$service['SalonService'][$lang.'_name']:$service['Service'][$lang.'_name']; ?>
		       (<?php echo count($service['children']); ?>)
		   </a>
		  <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $service['SalonService']['id'];?>" aria-expanded="true" aria-controls="collapse_<?php echo $service['SalonService']['id'];?>" class="change-name"><?php echo  __('view_all',true); ?> <i class="fa fa-angle-down"></i></a>
		 </h4>
	       </div>
	       <div id="collapse_<?php echo $service['SalonService']['id'];?>" class="panel-collapse collapse <?php echo($i==1)?'in':'' ?>" role="tabpanel" aria-labelledby="heading_<?php echo $service['SalonService']['id'];?>">
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
		      <?php $i++; } } ?>
		   </div>
		 </div>
	       </div>
	     </div>
		      <?php }} ?>
	      </div>
	 </div>
	 <!--accordian ends-->
     </div>
     </div>
</div>