    <?php $lang = Configure::read('Config.language'); ?>
    <?php if(!empty($staffData)){
    foreach($staffData as $thetimeD){
        ?>
        <div class="book-stylist" data-staff-close ="<?php echo $thetimeD['timeSlots']['closing_time'];?>"  data-staffid="<?php echo $thetimeD['staff']['User']['id'];?>">
            <div class="lft">
                <?php
                
                $staff_img = '';
                if(!empty($thetimeD['staff']['User']['image'])){
                        $img_name = $this->Common->get_image_stylist($thetimeD['staff']['User']['image'],
                                $thetimeD['staff']['User']['id'] ,
                                'User',200);
                        if(!empty($img_name)){
                                $staff_img = substr($img_name,1);
                        }
                }
                if(!empty($staff_img)){
                        //echo $staff_img;
                        if (file_exists(WWW_ROOT.$staff_img)) {
                                echo $this->Html->image('/'.$staff_img,
                                        array('title' => ucfirst(@$thetimeD['staff']['User']['first_name']).' '.ucfirst(@$thetimeD['staff']['User']['last_name'])));
                        }
                }
                
                //echo $this->Html->image($this->Common->get_image($thetimeD['staff']['User']['image'],$thetimeD['staff']['User']['id'],'User'),array()); ?>
                <!--<img src="img/stylist-book.jpg" alt="stylist" title="stylist">-->
                <span><?php echo ucfirst($thetimeD['staff']['User']['first_name'])." ".ucfirst($thetimeD['staff']['User']['last_name']); ?></span>
                <br/>
                <h3><?php
                    $day = strtolower(date('l',strtotime($dateTimestamp)));
                    echo __($day,true);?>, <br><?php
                    $mnth = date('F',strtotime($dateTimestamp));
                    echo __($mnth,true);echo '-';echo date('d',strtotime($dateTimestamp));echo '-';
                    echo date('Y',strtotime($dateTimestamp)); ?>
                </h3>
            </div>
            <div class="rgt">
                <?php if(isset($thetimeD['timeSlots']['morning']) && !empty($thetimeD['timeSlots']['morning'])){ ?>
                <div class="clearfix">
                    <h4><?php echo __('Morning',true);?></h4>
                    <ul>
                        <?php foreach($thetimeD['timeSlots']['morning'] as $timeslotMVal){ ?>
                            <li data-time="<?php echo $timeslotMVal; ?>">
                                <a class="getEmpSelTime" href="javascript:void(0);">
                                    <?php
                                    if($lang == 'ara'){
                                        echo date('H:i',strtotime($timeslotMVal));
                                    }else{
                                        echo $timeslotMVal;
                                    }?>
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <?php } ?>
                <?php if(isset($thetimeD['timeSlots']['afternoon']) && !empty($thetimeD['timeSlots']['afternoon'])){ ?>
                <div class="clearfix">
                    <h4><?php echo __('Afternoon',true);?></h4>
                    <ul>
                        <?php foreach($thetimeD['timeSlots']['afternoon'] as $timeslotAVal){ ?>
                            <li data-time="<?php echo $timeslotAVal; ?>">
                                <a class="getEmpSelTime" href="javascript:void(0);"><?php
                                if($lang == 'ara'){
                                    echo date('H:i',strtotime($timeslotAVal));
                                }else{
                                    echo $timeslotAVal;
                                }?></a>
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <?php } ?>
                <?php if(isset($thetimeD['timeSlots']['evening']) && !empty($thetimeD['timeSlots']['evening'])){ ?>
                <div class="clearfix">
                    <h4><h4><?php echo __('Evening',true);?></h4></h4>
                    <ul>
                        <?php foreach($thetimeD['timeSlots']['evening'] as $timeslotEVal){ ?>
                            <li data-time="<?php echo $timeslotEVal; ?>">
                                <a class="getEmpSelTime" href="javascript:void(0);"><?php
                                if($lang == 'ara'){
                                    echo date('H:i',strtotime($timeslotEVal));
                                }else{
                                    echo $timeslotEVal;
                                }?></a>
                            </li>
                        <?php }?>
                    </ul>
                </div>    
                <?php } ?>
                
                
               
            </div>
        </div>    
    <?php
    //pr($thetimeD);
    }
}else{ ?>
    <p><?php echo __('Sorry_there_are_no_available_slots_on',true);
            echo " ";
            $day = strtolower(date('l',strtotime($dateTimestamp)));
            echo __($day,true);
            echo ", ";
            echo date('d',strtotime($dateTimestamp));
            $mnth = date('F',strtotime($dateTimestamp));
            echo __($mnth,true);
            ?></p>
    <p><?php echo __('please_select_another_day',true); ?></p>        
<?php }?>


                