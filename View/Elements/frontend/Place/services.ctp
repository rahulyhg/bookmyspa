<div class="wrapper">
<div class="container">
<?php if(!empty($staff_service_ids)) { ?>
<h2 class="share-head mrgnleft">
     <?php
	     echo __('Services provided by '.$name.'');
     ?>
     </h2>
<?php } ?>
	<!--accordian starts-->
    <div class="vendor-service-content clearfix">
   	 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
             <?php if(count($services)){
                 $i = 1;
                 foreach($services as $key => $service){

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
	  <div id="collapse_<?php echo $service['SalonService']['id'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?php echo $service['SalonService']['id'];?>">
	  </div>
        </div>
                 <?php }}else{ ?>
		   <div class="not_found">Current the business is not running any service.</div>
		 <?php } ?>
         </div>
    </div>
    <!--accordian ends-->
</div>
</div>
<style>
     .mrgnleft{
	  margin-left: 0px;
     }
</style>
