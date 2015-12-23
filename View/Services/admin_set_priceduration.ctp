<style>
    .pos-rel{position: relative;}
</style>
<div class="modal-dialog vendor-setting overwrite" style="width:80%">
    <?php echo $this->Form->create('Service', array('url' => array('controller' => 'Services', 'action' => 'set_priceduration','admin'=>true),'id'=>'treatmentsettingForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2>Treatment Settings</h2>
        </div>
        <div class="modal-body clearfix">
            <div class="col-sm-12 nopadding">
                <div class="box">
                    <div class="box-content bookInchg  form-horizontal table-responsive nopadding">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Treatment</th>
                                    <th>Online Booking</th>
                                    <th>Voucher</th>
                                    <th>Duration</th>
                                    <th>Price(AED)</th>
                                    <th><?php echo ucfirst($auth_user['User']['first_name']).' '.ucfirst($auth_user['User']['last_name']);?></th>
                                    <?php if(!empty($staffList)){
                                        foreach($staffList as $thestaff){ ?>
                                            <th><?php echo ucfirst($thestaff['User']['first_name']).' '.ucfirst($thestaff['User']['last_name']);?></th>
                                        <?php     
                                        }
                                    }?>
                                    
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                $serviceOne =false;
                                if(!empty($services)){
                                    foreach($services as $service){
                                        if(!empty($service['children'])){
                                            foreach($service['children'] as $theService){
                                                if(empty($theService['ServicePricingOption'])){
                                                   $serviceOne = true;
                                                    ?>
                                                    <tr data-id="<?php echo $theService['SalonService']['id']; ?>" >
                                                <td class="col-sm-5"><?php echo (!empty($theService['SalonService']['eng_display_name']))? ucfirst($theService['SalonService']['eng_display_name']): (!empty($theService['SalonService']['eng_name']))? ucfirst($theService['SalonService']['eng_name']) : ucfirst($theService['Service']['eng_name']) ; ?>
                                                </td>
                                                <td align="center">
                                                    <div class="pos-rel">
                                                    <?php echo $this->Form->input('SalonServiceDetail.onlinebooking.'.$theService['SalonService']['id'],array('id'=>'online-'.$theService['SalonService']['id'],'value'=>$theService['SalonService']['id'],'div'=>false,'class'=>'','checked'=>true,'type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp;'))); ?>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <div class="pos-rel"><?php echo $this->Form->input('SalonServiceDetail.evoucher.'.$theService['SalonService']['id'],array('id'=>'evoucher-'.$theService['SalonService']['id'],'value'=>$theService['SalonService']['id'],'div'=>false,'class'=>'','checked'=>true,'type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp;'))); ?>
                                                    </div>
                                                </td>
                                                <td align="center">
                                                    <?php echo $this->Form->input('ServicePricingOption.duration.'.$theService['SalonService']['id'], array('type' => 'select', 'label' => false, 'div' => false,'class' => 'form-control duration-time', 'default'=>30,'options' => $this->common->get_duration())); ?></td>
                                                
                                                <td class="col-sm-2">
                                                    <?php echo $this->Form->input('ServicePricingOption.full_price.'.$theService['SalonService']['id'], array('type' => 'text', 'label' => false, 'div' => false,'class' => 'servicePrice form-control','required','validationMessage'=>'Price is required.','pattern'=>"^[0-9]+(\.[0-9]+)?$",'data-pattern-msg'=>"Please enter the valid price.",'data-maxlengthcustom-msg'=>"Maximum 10 numbers are allowed.",'maxlengthcustom'=>"10")); ?></td>
                                                    
                                                <td align="center">
                                                    <div class="pos-rel">
                                                        <?php echo $this->Form->input('SalonStaffService.'.$theService['SalonService']['id'].".",array('id'=>'servie-'.$auth_user['User']['id'].'-'.$theService['SalonService']['id'],'value'=>$auth_user['User']['id'],'div'=>false,'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp;'))); ?>
                                                    </div>
                                                </td>
                                                <?php if(!empty($staffList)){
                                                    foreach($staffList as $thestaff){ ?>
                                                        <td align="center">
                                                            <div class="pos-rel">
                                                            <?php echo $this->Form->input('SalonStaffService.'.$theService['SalonService']['id'].".",array('id'=>'servie-'.$thestaff['User']['id'].'-'.$theService['SalonService']['id'],'value'=>$thestaff['User']['id'],'div'=>false,'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp;'))); ?>
                                                            </div>
                                                        </td>
                                                    <?php     
                                                    }
                                                }?>
                                            </tr>
                                               <?php }else{
                                                
                                               }
                                                ?>
                                            
                                        <?php 
                                            }
                                        }
                                        ?>
                                          
                                    <?php
                                        }
                                    }else{
                                       
                                    }
                                    
                                    if($serviceOne == false){
                                        echo "<tr><td colspan = '13'>No treatments added</td></tr>";
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-3 pull-right">
                <input type="submit" name="next" class="treatmentsettingForm  btn btn-primary" value="Next" />
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    Custom.init();
</script>
