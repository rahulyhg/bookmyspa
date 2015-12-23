<div class="vendor-service-content clearfix" id="SERVICES">
                      <div class="panel-group"  role="tablist" aria-multiselectable="true">
<?php
if(!empty($services)){
    foreach($services as $key=>$service){
        $focus = false;
        if (isset($focus_class)) {
                if ($focus_class == "collapse-".$service['SalonService']['id']) {
                    $focus = true;
                }
            } else {
                if (($key == 0)) {
                    $focus = true;
                }
            }
            ?>
<div class="panel panel-default <?php echo ($focus)?'panel-active':'';?>" data-id="<?php echo $service['SalonService']['id']?>">
    <div class="panel-heading" role="tab" id="heading-<?php echo $service['SalonService']['id']?>">
      <h4 class="panel-title">
        <a class="forcheck <?php echo ($key != 0 )?'collapsed':'';?>" data-toggle="collapse" data-parent="#services-accordion" href="#collapse-<?php echo $service['SalonService']['id']?>" aria-expanded="true" aria-controls="collapse-<?php echo $service['SalonService']['id']?>">
            <span class="tag-icon"><i class="fa fa-hand-o-up"></i></span>
            <span class="cat-name-wrap"><?php if(!empty($service['SalonService']['eng_name'])){
                    echo ucfirst($service['SalonService']['eng_name']);
                }else{
                    echo ucfirst($service['Service']['eng_name']);
                } ?>
            </span>
        </a>
        <!--<span class="inner-diff-links">
            <a href="javascript:void(0);" data-id="<?php echo $service['SalonService']['id']?>" class="change-name" title="Change display name">Change display name</a>
            <a href="javascript:void(0);" data-id="<?php echo $service['SalonService']['id']?>" class="del del-service" title="Delete"><i class="fa fa-trash-o"></i></a>
            <a href="javascript:void(0);" data-parent-id="<?php echo $service['SalonService']['service_id']?>" data-id="null" data-cat = "<?php echo $service['SalonService']['id']?>" class="add editTreat" title="Add Treatment"><i class="fa fa-plus"></i></a>
        </span>-->
      </h4>
    </div>
    
    <div id="collapse-<?php echo $service['SalonService']['id']?>" class="panel-collapse collapse <?php echo ($focus)?'in':'';?>" role="tabpanel" aria-labelledby="heading-<?php echo $service['SalonService']['id']?>">
      <div class="panel-body">
        <div class="treat-list vendor-deal-content vendor-service clearfix">
            <?php
           if(!empty($service['children'])){
                 foreach($service['children'] as $treatment){ ?>
                    <div class="v-deal" data-id="<?php echo $treatment['SalonService']['id']; ?>">
                        <div class="v-deal-box">
                            <div class="upper">
                            <?php
                           
                           // if(isset($treatment['SalonServiceImage']) && (!empty($treatment['SalonServiceImage']))){
                                 //echo $this->Html->image('/images/Service/350/'.$treatment['SalonServiceImage'][0]['image']);
                                 echo $this->Html->image($this->Common->getsalonserviceImage($treatment['SalonService']['id'],$uid,350),array('class'=>" ")); 
                               // }else{?>
                               <!-- <img src="/img/admin/1.jpg" alt="" title=""/>-->
                                <?php //}?>
                                <?php if(!$treatment['SalonService']['status']){?>
                                <span class="status">Activate Service</span>
                                <?php } ?>
                            </div>
                        
                            <div class="bottom <?php if(!$treatment['SalonService']['status']){ echo 'dull'; } ?>">
                                <p class="p1"><?php echo  (!empty($treatment['SalonService']['eng_name']))? ucfirst($treatment['SalonService']['eng_name']) : ucfirst($treatment['Service']['eng_name']) ; ?></p>
                                <p class="p2">
                                    <?php
                                    
                                    $servicePrice = $this->frontCommon->getServicePrice($treatment['SalonService']['id']);
                                    if($servicePrice['from']){
                                        echo 'from AED '.$servicePrice['full'].'';
                                    }
                                    elseif($servicePrice['sell']){
                                        echo '<span>AED'.$servicePrice['full'].' </span><b> AED '.$servicePrice['sell'].'</b>';
                                    }
                                    else{
                                        echo 'AED '. $servicePrice['full'];
                                    }
                                    ?>
                                </p>
                               <!-- <p class="p3">
                                    <button class="active-deactive <?php echo ($treatment['SalonService']['status'])?'active':'';?>" data-id="<?php echo $treatment['SalonService']['id']?>" type="button">
                                    <?php echo ($treatment['SalonService']['status'])? 'Deactivate':'Activate'; ?></button>
                                    <a title="Delete" href="javascript:void(0);" data-id="<?php echo $treatment['SalonService']['id']?>" class="deleteTreat" ><i class="fa  fa-trash-o"></i></a>
                                    <a title="Edit" href="javascript:void(0);" data-cat="" data-parent-id="<?php echo $service['SalonService']['service_id']?>"  data-id="<?php echo $treatment['SalonService']['id']?>" class="editTreat" ><i class="fa fa-pencil"></i></a>		
                                </p>-->
                            </div>
                        </div>
                        <?php //pr($treatment); ?>
                    </div>
                    
                <?php }
            
            }else{
                echo "Please add treatment";
            }?>
        </div>
      </div>
    </div>
  </div>
  
<?php }
}else{
    echo "Please add Services";
}
?>
</div>
<div class="clear"></div>

                    </div>	