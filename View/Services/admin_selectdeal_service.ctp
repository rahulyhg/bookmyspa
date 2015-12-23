<div class="modal-dialog vendor-setting overwrite">
    <div class="modal-content">
	<div class="modal-header">
	    <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    <h2>What services Package will include ?</h2>
	    <h4 class="modal-title" id="myModalLabel"></h4>
	</div>
	<div class="modal-body clearfix">
	    <div class="v-setting-right">
		<div>
		    <div class="serviceListV" style="height: 345px; overflow: auto;">
			<div class="panel-group" id="accordion-package" role="tablist" aria-multiselectable="true">
			    <?php if(!empty($Salonservices)){
				$theClosp = 0; 
				foreach($Salonservices as $kkk=> $theChildren){
				    if(!empty($theChildren['children'])){
				    $theChId = $theChildren['SalonService']['id']; ?>
					<div class="panel panel-default" id="service_<?php echo $theChId; ?>">
					    <div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
						    <a class=" <?php echo ($theClosp>0)?'collapsed':'';?> " data-toggle="collapse" data-parent="#accordion-package" href="#collapse-<?php echo $theChId ?>" aria-expanded="true" aria-controls="collapseOne">
						    <?php echo empty($theChildren['SalonService']['eng_name'])?$this->common->get_service_name($theChildren['SalonService']['service_id']):ucfirst($theChildren['SalonService']['eng_name']);?> <span>View all<i class="fa fa-angle-down"></i></span>
						    </a>
						    <?php echo $this->Form->checkbox('salon_service_id.',array('value'=>$theChId,'label'=>false,'div'=>false,'class'=>'rootservice','style'=>'display:none;')); ?>
						</h4>
					    </div>
					    <div id="collapse-<?php echo $theChId ?>" class="panel-collapse collapse <?php echo ($theClosp < 1)?'in':'';?>" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
						    <ul class="treatment clearfix root_tree" id="root_tree">
							<?php if(!empty($theChildren['children'])){
							    foreach($theChildren['children'] as $finalChild){
								$serviceName = empty($finalChild['SalonService']['eng_name'])?$this->common->get_service_name($finalChild['SalonService']['service_id']):ucfirst($finalChild['SalonService']['eng_name']);
								echo "<li id='child_".$finalChild['SalonService']['id']."'>";
								echo $this->Form->checkbox('salon_service_id.',array('id'=>'service_id_li'.$finalChild['SalonService']['id'],'value'=>$finalChild['SalonService']['id'],'div'=>false,'class'=>'styled subCheck'));
								echo "<label for='service_id_li".$finalChild['SalonService']['id']."' class='new-chk'>".$serviceName."</label>";
								echo "</li>";
							    }
							    
							}
							else{
							    echo "No Service";
							}?>
						    </ul>
						</div>
					    </div>
					</div>
				    <?php $theClosp++;
				    }
				}
			    } else{ ?>
				<div class="accordion-group ">
				    <div class="accordion-heading">
					<a href="javascript:void(0);" data-parent="#accordion-package" data-toggle="collapse" class="accordion-toggle">
					    No Service
					</a>
				    </div>
				</div>
			    <?php }?>
                        </div>
                    </div>	
		</div>
            </div>
        </div>
	<div class="modal-footer pdng20"></div>
    </div>
</div>