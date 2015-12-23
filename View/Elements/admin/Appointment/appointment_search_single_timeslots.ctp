<div id="timeSlots">
    <?php $k=0; ?>
    <?php if(isset($getAppointmentSlots)){?>
    <?php foreach($getAppointmentSlots as $getAppointmentSlots){  ?>
        <?php if(count($getAppointmentSlots)>0){ ?>
        <div class="row">
            <div class="col-sm-12">
                <?php if(isset($staffDetail) && isset($getAppointmentSlots)){  ?>
                <?php //pr($getAdminSlots); die; ?>
                            <div class="col-sm-2">
                                <?php  if(isset($staffDetail[$k]['User']['image']) && !empty($staffDetail[$k]['User']['image']) ){
                                            echo $this->Html->image("/images/".$staffDetail[$k]['User']['id']."/User/150/".$staffDetail[$k]['User']['image'],array('data-id'=>$staffDetail[$k]['User']['id'],'width'=>'100'));
                                        }else{
                                            echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$staffDetail[$k]['User']['id'],'width'=>'100'));
                                        }?>
                            </div>
                            <div class="col-sm-2">
                                <?php echo $staffDetail[$k]['User']['first_name'].' '.$staffDetail[$k]['User']['last_name']; ?><br/>
                                <?php echo $ServiceName['SalonService']['eng_name']; ?><br/>
                            </div>
                <?php } ?>
                <div class="col-sm-8">
                    <div class="box">
                        <div class="box-content">
                            <?php if(isset($getAppointmentSlots['timeSlots']['morning'])){ ?>
                                    <h4>Morning</h4>
                                    <ul>
                                        <?php for($i=0;$i<=6;$i++){ 
                                            if(isset($getAppointmentSlots['timeSlots']['morning'][$i])){ ?>
                                                    <li data-time="<?php echo $getAppointmentSlots['timeSlots']['morning'][$i];?>" class="slots">
                                                        <?php echo $this->Form->button($getAppointmentSlots['timeSlots']['morning'][$i],array('type'=>'button','class'=>'btn btn-primary searchAppointmentSlots','label'=>false,'data-slot-time'=> strtotime($getAppointmentSlots['timeSlots']['morning'][$i]),'data-slot-user-id'=>$staffDetail[0]['User']['id'],'div'=>false,'value'=>$getAppointmentSlots['timeSlots']['morning'][$i]));?>
                                                    </li>
                                            <?php }
                                        } ?>
                                    </ul>
                            <?php  } ?>
                        </div>
                    </div>
                                <div class="box">
                                    <div class="box-content">
                                        <?php if(isset($getAppointmentSlots['timeSlots']['afternoon'])){ ?>
                                                <h4>AfterNoon</h4>
                                                <ul>
                                                <?php for($i=0;$i<=6;$i++){
                                                        if(isset($getAppointmentSlots['timeSlots']['afternoon'][$i])){ ?>
                                                            <li data-time="<?php echo $getAppointmentSlots['timeSlots']['afternoon'][$i];?>" class="slots">
                                                                <?php echo $this->Form->button($getAppointmentSlots['timeSlots']['afternoon'][$i],array('type'=>'button','class'=>'btn btn-primary searchAppointmentSlots','label'=>false,'data-slot-time'=> strtotime($getAppointmentSlots['timeSlots']['afternoon'][$i]),'data-slot-user-id'=>$staffDetail[0]['User']['id'],'div'=>false,'value'=>$getAppointmentSlots['timeSlots']['afternoon'][$i]));?>
                                                            </li>
                                                        <?php }
                                                } ?>
                                                </ul>
                                        <?php  } ?>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="box-content">
                                        <?php if(isset($getAppointmentSlots['timeSlots']['evening'])){ ?>
                                                <h4>Evening</h4>
                                                <ul>
                                                <?php for($i=0;$i<=6;$i++){
                                                        if(isset($getAppointmentSlots['timeSlots']['evening'][$i])){ ?>
                                                            <li data-time="<?php echo $getAppointmentSlots['timeSlots']['afternoon'][$i];?>" class="slots">
                                                                <?php echo $this->Form->button($getAppointmentSlots['timeSlots']['evening'][$i],array('type'=>'button','class'=>'btn btn-primary searchAppointmentSlots','label'=>false,'data-slot-time'=> strtotime($getAppointmentSlots['timeSlots']['evening'][$i]),'data-slot-user-id'=>$staffDetail[0]['User']['id'],'div'=>false,'value'=>$getAppointmentSlots['timeSlots']['evening'][$i]));?>
                                                            </li>
                                                        <?php }
                                                    } ?>
                                                </ul>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                    
                    <?php } $k++;
                }
            }  ?>
        </div>
    </div>
</div>
