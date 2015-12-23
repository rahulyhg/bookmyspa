<style>
.panel-group .panel .panel-heading .p2 span { font-weight: normal; text-decoration: line-through; color: #666; }
.panel-group .panel .panel-heading .p2{
    background: none repeat scroll 0 0 transparent;
    color: #787878;
    font-size: 12px;
    font-style: italic;
    font-weight: normal;
    position: absolute;
    right:158px;
    text-transform: none;
    top: 2px;
    color: #333; margin: 0 0 5px 0; font-weight: bold;
}
   
    .deal_disable.disabled{
         pointer-events: none;
         cursor: default;
    }


</style>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php
if(!empty($packages)){
		
    foreach($packages as $key=>$package){
		$add_class='';
                             /*   if(count($deals)){      
                                           foreach($deals as $dealData){
                                                if($dealData['DealServicePackage']['package_id'] ==$package['Package']['id']){
                                                    if($dealData['Deal']['status']==1 && ($dealData['Deal']['max_time'] > date('Y-m-d'))){
                                                        $add_class= 'disabled';
                                                         break; 
                                                    }
                                                }
                                            }  
                                      
				} */
	
	?>
<div class="panel panel-default <?php echo ($key == 0 )?'panel-active':'';?>" data-id="<?php echo $package['Package']['id']?>">
                  <div class="panel-heading" role="tab" id="heading-<?php echo $package['Package']['id']?>">
                      <h4 class="panel-title">
                         <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $package['Package']['id']?>" aria-expanded="true" aria-controls="collapse-<?php echo $package['Package']['id']?>">
                         <span class="tag-icon"><i title="Re-Order <?php echo $package['Package']['type'];?>" class="fa fa-hand-o-up"></i></span>
			 <div class="pkgImg-inhead" >
			    <img alt="" class=" " src="/images/Service/150/<?php echo $package['Package']['image']; ?>">
			 </div>
			 <?php echo ucfirst($package['Package']['eng_name']);?></a>
						 <p class="p2">
							<?php if(!empty($package['PackagePricingOption'])){
                                            $forMultiple = '';
                                          if(count($package['PackagePricingOption'])>1){
                                            $forMultiple = 'from';
                                          }
                                         // echo  ($package['PackagePricingOption'][0]['sell_price']< $package['PackagePricingOption'][0]['full_price']) ? '<span>AED '.$package['PackagePricingOption'][0]['full_price'].'</span>'.$forMultiple.' AED '.$package['PackagePricingOption'][0]['sell_price'] : $forMultiple.' AED '.$package['PackagePricingOption'][0]['sell_price'];
                                    } ?>
						 
						 </p>
			<div class="deal_disable <?php echo $add_class; ?>">			 
			 <a href="javascript:void(0)"  data-id="<?php echo $package['Package']['id']?>" title="Edit <?php echo ($this->params['action'] == 'admin_spaday')?'Spaday':'Package';?>" class="addPackage change-name"><i class="fa fa-pencil"></i></a>
                         <a href="javascript:void(0)" data-id="<?php echo $package['Package']['id']?>" title="Delete <?php echo ($this->params['action'] == 'admin_spaday')?'Spaday':'Package';?>" class="delete-package del"><i class="fa  fa-trash-o"></i></a>
						 <?php $status = ($package['Package']['status']==0) ? false : true;
						if($status==true){ ?>
						 <a href="javascript:void(0)" data-id="<?php echo $package['Package']['id']?>" title="Activate/Deactivate" class="changestatus-package add active"><i class="fa fa-check-square-o"></i></a>
						<?php }else{ ?>
						<a href="javascript:void(0)" data-id="<?php echo $package['Package']['id']?>" title="Activate/Deactivate" class="changestatus-package add"><i class="fa fa-square-o"></i></a>
						<?php }?>
			</div>			
                      </h4>
                    </div>
                    <div id="collapse-<?php echo $package['Package']['id']?>" class="panel-collapse collapse <?php echo ($key == 0 )?'in':'';?>" role="tabpanel" aria-labelledby="heading-<?php echo $package['Package']['id']?>">
                      <div class="panel-body">
		      <h3 class="inc-ser-txt">Included Services</h3>
                      	<div class="vendor-deal-content vendor-service clearfix">
						<?php if(!empty($package['PackageService'])) {
							foreach($package['PackageService'] as $packageService){
							?>
                            <div class="v-deal">
							
								<div class="v-deal-box">
									<div class="upper">
									<?php echo $this->Html->image($this->Common->getsalonserviceImage($packageService["salon_service_id"],$auth_user['User']['id'],150),array('class'=>" ")); ?>
										
									</div>
									
									<div class="bottom dull">
									   <!-- <p class="p1">Gold Facial</p>-->
									   <p class="p3">
										 <?php echo $this->Common->get_salon_service_name($packageService["salon_service_id"]) ?>
										<!--<a href="javascript:void(0)" data-id="<?php echo $packageService["id"]; ?>"  class="delete-package-service"><i class="fa  fa-trash-o"></i></a>-->
										</p>
									</div>
								</div>
							</div>
						<?php }}?>
					  </div>
                      </div>
                    </div>
                  </div>
                <?php }}?>
 </div>
                <div class="clear"></div>