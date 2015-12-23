<div id="timeSlots">
    <?php //pr($ServiceName); die; ?>
    <div class="col-sm-12">
        <?php if(isset($staffDetail) && isset($getAppointmentSlots['timeSlots']['morning'])){  //pr($staffDetail); die;?>
        <div class="col-sm-3">
                    <?php
                        if(isset($staffDetail['User']['image']) && !empty($staffDetail['User']['image']) ){
                            echo $this->Html->image("/images/".$staffDetail['User']['id']."/User/150/".$staffDetail['User']['image'],array('data-id'=>$staffDetail['User']['id']));
                        }else{
                            echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$staffDetail['User']['id']));
                        }?>
        </div>
        <div class="col-sm-2">
            
        <?php echo $staffDetail['User']['first_name'].' '.$staffDetail['User']['last_name']; ?><br/>
        <?php echo $ServiceName['SalonService']['eng_name']; ?><br/>
        <?php echo $Price['Appointment']['appointment_price']; ?>
        </div>
        <?php } ?>
        
        <div class="col-sm-6">
            <div class="box">
                <div class="box-content">
                    <?php if(isset($getAppointmentSlots['timeSlots']['morning'])){ ?>
                            <h4>Morning</h4>
                                <ul>
                                <?php for($i=0;$i<=6;$i++){ 
                                        if(isset($getAppointmentSlots['timeSlots']['morning'][$i])){ ?>
                                            <li data-time="<?php echo $getAppointmentSlots['timeSlots']['morning'][$i];?>" class="slots">
                                                <?php echo $this->Form->button($getAppointmentSlots['timeSlots']['morning'][$i],array('type'=>'button','class'=>'btn btn-primary forwardAppointment','label'=>false,'div'=>false,'data-time'=>$time,'value'=>$getAppointmentSlots['timeSlots']['morning'][$i]));?>
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
                                                <?php echo $this->Form->button($getAppointmentSlots['timeSlots']['afternoon'][$i],array('type'=>'button','class'=>'btn btn-primary forwardAppointment','label'=>false,'div'=>false,'data-time'=>$time,'value'=>$getAppointmentSlots['timeSlots']['afternoon'][$i]));?>
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
                                                <?php echo $this->Form->button($getAppointmentSlots['timeSlots']['evening'][$i],array('type'=>'button','class'=>'btn btn-primary forwardAppointment','label'=>false,'div'=>false,'data-time'=>$time,'value'=>$getAppointmentSlots['timeSlots']['evening'][$i]));?>
                                            </li>
                                    <?php }
                                    } ?>
                            </ul>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
</div>