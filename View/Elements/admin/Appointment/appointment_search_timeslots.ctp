<div id="timeSlots">
    <div class="box">
        <div class="box-content">
            <div class="col-sm-12">
                <?php if(isset($staffDetail) ){   ?>
                <?php //pr($getAppointmentSlots); die;
                
                ?>
                       <?php  $h=0; $slot=0; ?>
                            <?php foreach($staffDetail as $staffDetail){   ?>
                           
                                    <div class="col-sm-2">
                                        <?php if(isset($staffDetail['User']['image']) && !empty($staffDetail['User']['image']) ){
                                                echo $this->Html->image("/images/".$staffDetail['User']['id']."/User/150/".$staffDetail['User']['image'],array('data-id'=>$staffDetail['User']['id'],'class'=>'img-responsive','height'=>'100px'));
                                                }else{
                                                    echo $this->Html->image("admin/upload2.png",array('class'=>'','data-id'=>$staffDetail['User']['id'],'height'=>'100px'));
                                            } ?>
                                    </div>
                                    <div class="col-sm-2" style="height: 100px;">
                                        <?php echo $staffDetail['User']['first_name'].' '.$staffDetail['User']['last_name']; ?><br/>
                                        <?php if(isset($staffDetail['ser_name'])){ echo $staffDetail['ser_name']; } ?><br/>
                                    </div>
                                    <?php //} ?>
                                    <?php //pr($getAppointmentSlots[$slot]['timeSlots']['morning']); die; ?>
                                    <?php if($h==$services-1){ ?>
                                            <div class="col-sm-12">
                                                <div class="box">
                                                    <div class="box-content">
                                                        <?php //echo $staffDetail['User']['id']; ?>
                                                        <?php if(isset($staffDetail) && isset($getAppointmentSlots[$slot]['timeSlots']['morning'])){ ?>
                                                                <h4>Morning</h4>
                                                                <ul>
                                                                <?php for($i=0;$i<=count($getAppointmentSlots[$slot]['timeSlots']['morning']);$i++){ 
                                                                        if(isset($getAppointmentSlots[$slot]['timeSlots']['morning'][$i])){ ?>
                                                                            <li data-time="<?php echo $getAppointmentSlots[$slot]['timeSlots']['morning'][$i];?>" class="slots">
                                                                                <?php echo $this->Form->button($getAppointmentSlots[$slot]['timeSlots']['morning'][$i],array('type'=>'button','class'=>'btn btn-primary searchAppointmentSlots','label'=>false,'data-slot-time'=> strtotime($getAppointmentSlots[$slot]['timeSlots']['morning'][$i]),'data-slot-user-id'=>$staffDetail['User']['id'],'div'=>false,'value'=>$getAppointmentSlots[$slot]['timeSlots']['morning'][$i]));?>
                                                                            </li>
                                                                        <?php }
                                                                } ?>
                                                                </ul>
                                                        <?php  } ?>
                                                    </div>
                                                </div>
                                                <div class="box">
                                                    <div class="box-content">
                                                        <?php if(isset($staffDetail) && isset($getAppointmentSlots[$slot]['timeSlots']['afternoon'])){ ?>
                                                            <h4>AfterNoon</h4>
                                                            <ul>
                                                                <?php for($i=0;$i<=count($getAppointmentSlots[$slot]['timeSlots']['morning']);$i++){
                                                                        if(isset($getAppointmentSlots[$slot]['timeSlots']['afternoon'][$i])){ ?>
                                                                            <li data-time="<?php echo $getAppointmentSlots[$slot]['timeSlots']['afternoon'][$i];?>" class="slots">
                                                                                <?php echo $this->Form->button($getAppointmentSlots[$slot]['timeSlots']['afternoon'][$i],array('type'=>'button','class'=>'btn btn-primary searchAppointmentSlots','label'=>false,'data-slot-service-id'=>$staffDetail['ser_id'],'data-slot-time'=> strtotime($getAppointmentSlots[$slot]['timeSlots']['afternoon'][$i]),'div'=>false,'value'=>$getAppointmentSlots[$slot]['timeSlots']['afternoon'][$i]));?>
                                                                            </li>
                                                                        <?php }
                                                                } ?>
                                                            </ul>
                                                        <?php  } ?>
                                                    </div>
                                                </div>
                                                <div class="box">
                                                    <div class="box-content">
                                                        <?php if(isset($staffDetail) && isset($getAppointmentSlots[$slot]['timeSlots']['evening'])){ ?>
                                                                <h4>Evening</h4>
                                                                <ul>
                                                                    <?php for($i=0;$i<=count($getAppointmentSlots[$slot]['timeSlots']['morning']);$i++){
                                                                            if(isset($getAppointmentSlots[$slot]['timeSlots']['evening'][$i])){ ?>
                                                                                <li data-time="<?php echo $getAppointmentSlots[$slot]['timeSlots']['evening'][$i];?>" class="slots">
                                                                                    <?php echo $this->Form->button($getAppointmentSlots[$slot]['timeSlots']['evening'][$i],array('type'=>'button','class'=>'btn btn-primary searchAppointmentSlots','label'=>false,'data-slot-service-id'=>$staffDetail['ser_id'],'data-slot-time'=> strtotime($getAppointmentSlots[$slot]['timeSlots']['evening'][$i]),'div'=>false,'value'=>$getAppointmentSlots[$slot]['timeSlots']['evening'][$i]));?>
                                                                                </li>
                                                                            <?php }
                                                                    } ?>
                                                                </ul>
                                                        <?php  } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $h=-1;
                                      $slot++;  } $h++; 
                                    }
                                } ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
            <!--<div class="box">
                <div class="box-content">
                    <?php //if(isset($getAppointmentSlots)){pr($getAppointmentSlots); die;} ?>
                    <?php //if(isset($staffDetail) && isset($getAppointmentSlots[$staffDetail['User']['id']]['timeSlots']['morning'])){ ?>
                            <h4>Morning</h4>
                                <ul>
                                <?php //for($i=0;$i<=6;$i++){ 
                                        //if(isset($getAppointmentSlots['timeSlots']['morning'][$i])){ ?>
                                            <li data-time="<?php //echo $getAppointmentSlots['timeSlots']['morning'][$i];?>" class="slots">
                                                <?php //echo $this->Form->button($getAppointmentSlots['timeSlots']['morning'][$i],array('type'=>'button','class'=>'btn btn-primary forwardAppointment','label'=>false,'div'=>false,'value'=>$getAppointmentSlots['timeSlots']['morning'][$i]));?>
                                            </li>
                                    <?php //}
                                        //} ?>
                                    </ul>
                    <?php  //} ?>
                                           
                                           
                </div>
            </div>-->
            <!--<div class="box">
                <div class="box-content">
                    <?php //if(isset($getAppointmentSlots['timeSlots']['afternoon'])){ ?>
                            <h4>AfterNoon</h4>
                            <ul>
                                <?php //for($i=0;$i<=6;$i++){
                                        //if(isset($getAppointmentSlots['timeSlots']['afternoon'][$i])){ ?>
                                            <li data-time="<?php //echo $getAppointmentSlots['timeSlots']['afternoon'][$i];?>" class="slots">
                                                <?php //echo $this->Form->button($getAppointmentSlots['timeSlots']['afternoon'][$i],array('type'=>'button','class'=>'btn btn-primary forwardAppointment','label'=>false,'div'=>false,'value'=>$getAppointmentSlots['timeSlots']['afternoon'][$i]));?>
                                            </li>
                                    <?php //}
                                    //} ?>
                            </ul>
                    <?php  //} ?>
                </div>
            </div>-->
            <!--<div class="box">
                <div class="box-content">
                    <?php //if(isset($getAppointmentSlots['timeSlots']['evening'])){ ?>
                            <h4>Evening</h4>
                            <ul>
                                <?php //for($i=0;$i<=6;$i++){
                                        //if(isset($getAppointmentSlots['timeSlots']['evening'][$i])){ ?>
                                            <li data-time="<?php //echo $getAppointmentSlots['timeSlots']['afternoon'][$i];?>" class="slots">
                                                <?php //echo $this->Form->button($getAppointmentSlots['timeSlots']['evening'][$i],array('type'=>'button','class'=>'btn btn-primary forwardAppointment','label'=>false,'div'=>false,'value'=>$getAppointmentSlots['timeSlots']['evening'][$i]));?>
                                            </li>
                                    <?php //}
                                    //} ?>
                            </ul>
                    <?php  //} ?>
                </div>
            </div>-->
        </div>
    </div>
    <?php //} $k++; } }
    //die;?>
</div>
