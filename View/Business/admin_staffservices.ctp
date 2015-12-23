<style>
    .vendor-setting .v-setting-right {
        overflow: hidden;
        width: 68%;
    }
</style>
<?php echo $this->Html->script('bootbox.js'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-content vendor-setting">
                <?php echo $this->Form->create('SalonStaffService') ?>
                         <div id="theparentforp" class="panel-group staff-service-box v-setting-right " role="tablist" >
					    <?php if(!empty($serviceData)){
						foreach($serviceData as $kkk=> $theChildren){
                                                    
						$theChId = $theChildren['SalonService']['id']; ?>

                            <div class="panel panel-default" id="staff_<?php echo $theChId; ?>">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a class=" <?php echo ($kkk>0)?'collapsed':'';?> " data-toggle="collapse" data-parent="theparentforp" href="#collapse-<?php echo $theChId ?>" aria-expanded="true" aria-controls="collapseOne">
								<?php echo empty($theChildren['SalonService']['eng_name']) ? ucfirst($theChildren['Service']['eng_name']) : ucfirst($theChildren['SalonService']['eng_name']);?> <span>View all<i class="fa fa-angle-down"></i></span>
                                        </a>
							    <?php echo $this->Form->checkbox('salon_service_id.',array('value'=>$theChId,'label'=>false,'div'=>false,'class'=>'rootservice','style'=>'display:none;')); ?>
                                    </h4>

                                </div>
                                <div id="collapse-<?php echo $theChId ?>" class="panel-collapse collapse <?php echo ($kkk < 1)?'in':'';?>" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <ul class="treatment clearfix root_tree" id="root_tree">
							    <?php if(!empty($theChildren['children'])){
                                                                
								foreach($theChildren['children'] as $finalChild){
                                                                    $staffs = array();
                                                                     $serviceList = $this->Common->getStaffService($staffId);
                                                                    //$pricingLlevelid = $this->Common->get_price_level_id($staffId);
                                                                    // $serviceAccess = $this->Common->checkServiceAssociation($finalChild['SalonService']['id']);
                                                                     //$unique = array_unique($serviceAccess);
                                                                    
                                                                   // if(in_array($pricingLlevelid,$unique) || in_array(0,$unique) ){
                                                                        $checked = false;
                                                                        if(!empty($serviceList)){
                                                                            if(in_array($finalChild['SalonService']['id'],$serviceList)){
                                                                                $checked = 'checked';
                                                                            }
                                                                        }
                                                                        echo "<li id='child_".$finalChild['Service']['id']."'>";
                                                                        $sub_name =    $name =  empty($finalChild['SalonService']['eng_name']) ? ucfirst($finalChild['Service']['eng_name']) : ucfirst($finalChild['SalonService']['eng_name']);
									if(strlen($name) >15){
									    $sub_name = substr($name ,'0','15').'..';
									}
									echo $this->Form->input('salon_service_id.',array('type'=>'checkbox','id'=>"check_".$finalChild['SalonService']['id'] ,'value'=>$finalChild['SalonService']['id'],'checked'=>$checked,'label'=>array('title'=>$name,'class'=>'new-chk','text'=>$sub_name),'div'=>false,'class'=>'subCheck','data-id'=>$finalChild["SalonService"]["id"]));
                                                                        echo "</li>";
                                                                    //}
								}
								
							    }
							    else{
								echo "No Service";
							    }?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
    				    <?php } ?>
				<?php }else{ ?>
                            <div class="accordion-group ">
                                <div class="accordion-heading">
                                    <a href="javascript:void(0);" data-parent="theparentforp" data-toggle="collapse" class="accordion-toggle">
                                        No Service
                                    </a>
                                </div>
                            </div>
				<?php }?>
                        </div>
                        <?php echo $this->Form->hidden('pricingLevelService',array('value'=>implode(',',$pricingLevelServices)));?>
                        <?php echo $this->Form->hidden('allStaffServices',array('value'=>implode(',',$allStaffServices)));?>
                    <div class="form-actions col-sm-5 pull-right">
                        <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary submitTreatment', 'label' => false, 'div' => false)); ?>
                        <?php //echo $this->Html->link('Cancel',array('controller'=>'SalonStaff','action'=>'index','admin'=>true),array('escape'=>false,'class'=>'btn')); ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(document).find('#theparentforp').find('ul.treatment').on('click','input[type=checkbox]',function(){
      var obj = $(this);
      var serviceId = obj.attr("data-id");
      var plServices = $("#SalonStaffServicePricingLevelService").val();
      var allServices = $("#SalonStaffServiceAllStaffServices").val();
      var allserviceArr =   allServices.split(',');
      var plServicesArr =   plServices.split(',');
      var allserviceArrParse = new Array();
      var plId = "<?php echo $pricingLlevelid?>";
      var staffId = "<?php echo $staffId?>";
      var allPre = false;
      //console.log(allserviceArr);
      $.each( allserviceArr, function(  index, value ) {
        if(parseInt(value) == parseInt(serviceId)){
            if( obj.prop('checked') == false ){
             $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'checkStaffPricingLevel','admin'=>true))?>",
                type: "POST",
                data: {'service_id':serviceId,'pricing_level_id':plId,'staff_id':staffId,'type':'all'},
                success: function(res) {
                    if(res==1){
                        bootbox.alert('<h4>At least one staff is required for a particular option to provide this service.</h4>');
                          obj.prop('checked', true);
                        
                    }            
                }
            });
            }
              allPre = true;
        }
      });
      
    var plPre = false;
    //console.log(plServicesArr);
      $.each( plServicesArr, function(  index, value ) {
        if(parseInt(value) == parseInt(serviceId)){
            if( obj.prop('checked') == false ){
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonServices','action'=>'checkStaffPricingLevel','admin'=>true))?>",
                type: "POST",
                data: {'service_id':serviceId,'pricing_level_id':plId,'staff_id':staffId,'type':'prvl'},
                success: function(res) {
                    if(res==1){
                         bootbox.alert('<h4>At least one staff is required for a particular option to provide this service.</h4>');
                         obj.prop('checked', true);
                     }            
                }
            });
            }
            plPre = true;
            
        }
      });
      if(allPre == false && plPre == false){
        bootbox.alert('<h4>You have not set pricing option for this staff. </h4>');
         obj.prop('checked', false);  
      }
     
    });
})
    
</script>
