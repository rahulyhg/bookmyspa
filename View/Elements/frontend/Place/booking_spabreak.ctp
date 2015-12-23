<?php echo $this->Html->script('jquery.bxslider');?>
<?php $lang = Configure::read('Config.language'); ?>

<?php
    $lastVisited =  $this->Session->read('lastVisited');
    if( !empty($lastVisited)){
        echo $this->Js->link(__('Back >>',true),$lastVisited,array('update' => '#update_ajax','class'=>'backLink'));
    }else{
?>
    <a class="backLink" href="<?php echo $this->request->referer();?>">Back >></a>
<?php
    }
?>

<div class="big-lft">
    <div class="timer-details clearfix">
        <ul class="clearfix">
            <li>
                <span class="text-main">
                    <?php  
                        if(!empty($spaBreakDetails['Spabreak'][$lang.'_name'])){
                            echo $spaBreakDetails['Spabreak'][$lang.'_name'];
                        }elseif(!empty($spaBreakDetails['Spabreak'][$lang.'_name'])){
                            echo $spaBreakDetails['Spabreak'][$lang.'_name'];
                        }else{
                            echo $spaBreakDetails['Spabreak']['eng_name'];
                        }
                    ?>
                </span>
            </li>
        </ul>
    </div>

    <div class="deal-box-outer">
        <?php if(!empty($spaBreakDetails['SalonSpabreakImage'])){ ?>
            <div class="gallery">                    
                <?php if(!empty($spaBreakDetails['SalonSpabreakImage'])){ ?>
                <ul class="bxslider">
                    <?php foreach($spaBreakDetails['SalonSpabreakImage'] as $image) {  ?>
                    <li><?php echo $this->Html->image('/images/Service/800/'.$image['image']); ?></li>
                    <?php } ?>
                </ul>

                <div id="bx-pager">
                    <?php
                    $i = 0;
                    foreach($spaBreakDetails['SalonSpabreakImage'] as $image) {  ?>
                    <a data-slide-index="<?php echo $i;?>" href="javascript:void(0);"><?php echo $this->Html->image('/images/Service/150/'.$image['image']); ?></a>
                    <?php $i++; } ?>
                </div>
                <?php } ?>

            </div>
            <!--<div class="thumbnail clearfix"></div>-->
        <?php } ?>
        <div class="share-specific-deal clearfix">
            <ul class="share-icon-set">
                <li>Share this service</li>
                <li><a href="#" class="msz"></a></li>
                <li><a href="#" class="fb"></a></li>
                <li><a href="#" class="tweet"></a></li>
                <li><a href="#" class="google"></a></li>
            </ul>
        </div>
    </div>

    <div class="specific-service-details">
        <h2 class="share-head"><?php echo __('in_nutshell');?></h2>
        <p><?php  if(!empty($spaBreakDetails['Spabreak'][$lang.'_description'])){
                                        echo $spaBreakDetails['Spabreak'][$lang.'_description'];
                            }else{
                                        echo $spaBreakDetails['Spabreak']['eng_description'];
                            }?></p>
        <h2 class="share-head"><?php echo __('choose_following');?></h2>
        <?php if(!empty($spaBreakOption)){?>
            <ul class="specific-description">
                <?php foreach($spaBreakOption as $thePriceOpt){ ?>
                    <li>
                        <i class="fa fa-caret-right"></i>
                        <span>
                            <?php echo __('AED',true);?>
                            <?php echo ($thePriceOpt['SpabreakOptionPerday']['0']['sell_price'])? $thePriceOpt['SpabreakOptionPerday']['0']['sell_price'] :$thePriceOpt['SpabreakOptionPerday']['0']['full_price']; ?> 
                            <?php echo __('for',true);?> 
                            <?php  
                                if(!empty($thePriceOpt['SalonRoom'][$lang.'_room_type'])){
                                    echo $thePriceOpt['SalonRoom'][$lang.'_room_type'];
                                }else{
                                    echo $thePriceOpt['SalonRoom']['eng_room_type'];
                                }
                            ?>
                        </span>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>

    <div class="specific-service-details">
            <h2 class="share-head"><?php echo __('The_fine_print',true);?></h2>
            <?php if($spaBreakDetails['Spabreak']['listed_online'] && $spaBreakDetails['Spabreak']['listed_online'] > 1){?>
                <p>
                    <span>
                        <?php echo __('Validity',true);?>:
                    </span>
                    Sieasta <?php echo __('valid_until',true);?>
                    <?php echo date('d.m.Y',strtotime($spaBreakDetails['Spabreak']['listed_online_end'])); ?>.
                </p>
            <?php } ?>
            
            <?php  if(!empty($spaBreakDetails['Spabreak'][$lang.'_restrictions'])){?>
                <p>
                    <span>
                        <?php echo __('Restrictions',true);?>:
                    </span>            
                    <?php echo $spaBreakDetails['Spabreak'][$lang.'_restrictions'];?>
                </p>
            <?php
            }else{?>
                <p>
                    <span>
                        <?php echo __('Restrictions',true);?>:
                    </span>            
                    <?php echo $spaBreakDetails['Spabreak']['eng_restrictions'];?>
                </p>
            <?php
            }?>
                
            <?php  if(!empty($spaBreakDetails['Spabreak'][$lang.'_good_to_know'])){?>
                <p>
                    <span>
                        <?php echo __('Good to Know',true);?>:
                    </span>            
                    <?php echo $spaBreakDetails['Spabreak'][$lang.'_good_to_know'];?>
                </p>
            <?php
            }else{?>
                <p>
                    <span>
                        <?php echo __('Good to Know',true);?>:
                    </span>            
                    <?php echo $spaBreakDetails['Spabreak']['eng_good_to_know'];?>
                </p>
            <?php
            }?>
            
            <?php  if(!empty($spaBreakDetails['Spabreak']['check_in'])){?>
                <p>
                    <span>
                        <?php echo __('Check In Time',true);?>:
                    </span>            
                    <?php echo date('g:i A',strtotime($spaBreakDetails['Spabreak']['check_in']));?>
                </p>
            <?php
            }
            ?>
            
            <?php  if(!empty($spaBreakDetails['Spabreak']['check_out'])){?>
                <p>
                    <span>
                        <?php echo __('Check Out Time',true);?>:
                    </span>            
                    <?php echo date('g:i A',strtotime($spaBreakDetails['Spabreak']['check_out']));?>
                </p>
            <?php
            }
            ?>   
                
            <?php  
                if(!empty($policyDetails)){
                    ?>
                    <p>
                        <span>
                            <?php echo __('cancel_policy',true);?>:
                        </span>  
                    <?php 
                        if(!empty($policyDetails['PolicyDetail'][$lang.'_cancellation_policy_text'])){
                            echo $policyDetails['PolicyDetail'][$lang.'_cancellation_policy_text'];
                        }else{
                            echo $policyDetails['PolicyDetail']['eng_cancellation_policy_text'];
                        }
                    ?>    
                    </p>
                    <p>
                        <span>
                            <?php echo __('reschedule_policy',true);?>:
                        </span>            
                        <?php 
                        if(!empty($policyDetails['PolicyDetail'][$lang.'_reschedule_policy_text'])){
                            echo $policyDetails['PolicyDetail'][$lang.'_reschedule_policy_text'];
                        }else{
                            echo $policyDetails['PolicyDetail']['eng_reschedule_policy_text'];
                        }
                    ?>   
                    </p>
            <?php
                }
            ?>

    </div>
</div>

<div class="fixed-rgt soldOptions"> 
    <?php //echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Bookings','action'=>'spaBreaks','id'=>'AppointmentShowSpaBreakForm')));?>
    <div role="tabpanel" class="tabs">
        <ul class="nav nav-tabs ulopts" role="tablist">
            <?php
                $giftCheck = $buyCheck = true;
                if($spaBreakDetails['SalonServiceDetail']['sold_as'] == 1){ $giftCheck = false;}
                if($spaBreakDetails['SalonServiceDetail']['sold_as'] == 2){ $buyCheck = false;}?>
            <?php 
            if($reschedule == 'true'){
                $giftCheck = $buyCheck = false;
                ?>
                <li role="presentation">
                <a   href="#reschedule" aria-expanded="true" href="javascript:void(0);" aria-controls="reschedule" role="tab" data-toggle="tab"><?php echo __('resch_appntmnt',true); ?></a>
                </li>
            <?php }else if($buyCheck){ ?>
            <li role="presentation">
                <a href="#bookSpaBreak" aria-expanded="true" href="javascript:void(0);" aria-controls="bookSpaBreak" role="tab" data-toggle="tab"><?php echo __('buk_app',true); ?></a>
            </li>
            <?php } ?>

            <?php if($giftCheck){ ?>
                <li role="presentation">
                    <a  href="#buygift" aria-controls="buygift" role="tab" data-toggle="tab"><?php echo __('buy_gift_ev',true); ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="tab-content min-hgt360 clearfix">
         <?php if($reschedule){ ?>
            <div role="tabpanel" class="tab-pane " id="reschedule">
                <span class="offerOn" style="display:none">
                    <?php 
                        // get array of all available days.
                        $availableDays = array();
                        $allOffer = array('0'=>'sun','1'=>'mon','2'=>'tues','3'=>'wed','4'=>'thu','5'=>'fri','6'=>'sat');
                        if($spaBreakDetails['SalonServiceDetail']['offer_available']){  
                            $offerDay = array_filter(unserialize($spaBreakDetails['SalonServiceDetail']['offer_available_weekdays']));
                            if(!empty($offerDay)){
                                if(!isset($offerDay['sun'])){
                                    $offerDay['sun'] = '0';
                                }
                                if(!isset($offerDay['mon'])){
                                    $offerDay['mon'] = '0';
                                }
                                if(!isset($offerDay['tue'])){
                                    $offerDay['tue'] = '0';
                                }
                                if(!isset($offerDay['wed'])){
                                    $offerDay['wed'] = '0';
                                }
                                if(!isset($offerDay['thu'])){
                                    $offerDay['thu'] = '0';
                                }
                                if(!isset($offerDay['fri'])){
                                    $offerDay['fri'] = '0';
                                }
                                if(!isset($offerDay['sat'])){
                                    $offerDay['sat'] = '0';
                                }
                                echo json_encode($offerDay);
                            } 
                        }
                    ?>
                </span>
                
                <span class="disabledDays" style="display:none;">
                    <?php 
                        // get array of all blackout days.
                        $disabledDays = $dDays = array();
                        if(!empty($spaBreakDetails['Spabreak']['blackout_dates'])){  
                            $disabledDay = array_filter(unserialize($spaBreakDetails['Spabreak']['blackout_dates']));
                            if(!empty($disabledDay)){
                                foreach($disabledDay as $keyd=>$valued){
                                    $dDays[] = date('n-j-Y',$valued);
                                }
                            }
                        }
                        
                        // checking lead time for booking to disable current day
                        if(!empty($leadTime)){
                            $lead_time = $leadTime['SalonOnlineBookingRule']['lead_time'];                           
                        }else{
                            $lead_time = 30;
                        }
                        $todayDate = date('H:i:s');
                        $checkInTime = $spaBreakDetails['Spabreak']['check_in'];
                        $interval = round(strtotime($checkInTime) - strtotime($todayDate))/60;
                        if($interval <= $lead_time || $interval <= 0 ){
                            $dDays[] = date('n-j-Y'); 
                        }
                        echo json_encode($dDays);
                    ?>
                </span>
                <span class="priceSpaBreak" style="display:none;"></span>
                
                <div class="list-group pricing-list allPriceOpt spaBreakLabel" >
                    <a href="javascript:void(0);" class="list-group-item no-hover" onclick="return showDiv('selectRoom');">
                        <h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('Select room type & arrival date',true); ?></h4>
                    </a>
                    <div class="col-sm-12 lft-p-non" id="selectRoom">
                        <label class="col-sm-12 lft-p-non"><?php echo __('Select Room Type');?> *:</label>
                        
                        <?php
                            if(!empty($spaBreakOption)){
                                $sallonRoom = '';
                                echo "<select data-id='".$spaBreakDetails['Spabreak']['id']."' name='saloonRoom' id='saloonRoomID' class='spaSaloonRoom form-control full-w' onchange='return changeRoom();' >";
                                //echo "<option value=''>Select Room </option>";
                                foreach($spaBreakOption as $spaBreakOptions){
                                    foreach($spaBreakOptions['SpabreakOptionPerday'] as $thePriceOpt){ 
                                        if($thePriceOpt['id'] == $pricingoption){
                                            if(!empty($spaBreakOptions['SalonRoom'][$lang.'_room_type'])){
                                                $sallonRoom = $spaBreakOptions['SalonRoom'][$lang.'_room_type'];
                                            }else{
                                                $sallonRoom =  $spaBreakOptions['SalonRoom']['eng_room_type'];
                                            }
                                            ?>
                                                <option value="<?php echo $spaBreakOptions['SalonRoom']['id'];?>"><?php echo $sallonRoom;?></option>
                                            <?php
                                        }
                                    }
                                }
                                echo "</select>";
                                echo "<p class='saloonRoomCheck'></p>";
                            }

                        ?>
                        
                        <div id="spabreakCalendar" class='cal-sec spabreakCalendar <?php echo (isset($priceotion))?'disabled':''; ?>'></div>
                        <div class="startDateCheck"></div>
                    </div>
                </div>
               
                
                <div class='spaBreakListData  buk-emp-list list-group pricing-list' >     
                    <div style="display: none; position: relative;" class="loader-container" id="ajax_modal">
                        <div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
                    </div>
                    <div class="orderSpaBreakConfirmation" style="display:none;">
                        <a href="javascript:void(0);" class="list-group-item no-hover pdng-lft0 pdng-rgt0 bod-lft-non bod-rgt-non" onclick="return showDiv('orderDetails');">
                            <h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('Order overview',true); ?></h4>
                        </a>
                        <div class="spaBreakOrder" id="orderDetails">
                            <div class="duration">
                                <h5>Room Type</h5>
                                <div class="time checkInRoom">

                                </div>
                            </div>
                            <div class="duration">
                                <h5>Check In</h5>
                                <div class="time checkInTime">

                                </div>
                            </div>
                            <div class="duration">
                                <h5>Check Out</h5>
                                <div class="time checkOutTime">

                                </div>
                            </div>
                            <div class="duration">
                                <h5>Price <span class="personPrice"></span></h5>
                                <div class="time priceSpa">
                                </div>
                            </div>
                            
                            <div class="duration">
                                <h5>Total</h5>
                                <div class="time totalSpaPrice">
                                </div>
                            </div>
                        </div><!-- spaBreakOrder -->
                    </div>
                </div>
                <div class="serviceBukctnt">
                    <div class="centering-wrapper">
                        <div class="pay tp-space">
                            <span><?php echo __('Total',true); ?></span>
                            <strong>
                                    <span class="enabled"><?php echo __('AED',true); ?></span>
                            </strong>
                        </div>
                        <div class="discount-type spaPrice"></div>
                        <div class="book-coupons">Coupons are applied after clicking on book now and before making payments online</div>

                    </div>
                    <a href="javascript:void(0);" class="action" data-type="appointment">
                        <span class="appointment bookSpaBreaks"><?php echo __('Book',true); ?></span>
                    </a>
                </div>
            </div>
        <?php } ?>
        <?php if($buyCheck){ ?>
            <div role="tabpanel" class="tab-pane " id="bookSpaBreak">
                <span class="offerOn" style="display:none">
                    <?php 
                        // get array of all available days.
                        $availableDays = array();
                        $allOffer = array('0'=>'sun','1'=>'mon','2'=>'tues','3'=>'wed','4'=>'thu','5'=>'fri','6'=>'sat');
                        if($spaBreakDetails['SalonServiceDetail']['offer_available']){  
                            $offerDay = array_filter(unserialize($spaBreakDetails['SalonServiceDetail']['offer_available_weekdays']));
                            if(!empty($offerDay)){
                                if(!isset($offerDay['sun'])){
                                    $offerDay['sun'] = '0';
                                }
                                if(!isset($offerDay['mon'])){
                                    $offerDay['mon'] = '0';
                                }
                                if(!isset($offerDay['tue'])){
                                    $offerDay['tue'] = '0';
                                }
                                if(!isset($offerDay['wed'])){
                                    $offerDay['wed'] = '0';
                                }
                                if(!isset($offerDay['thu'])){
                                    $offerDay['thu'] = '0';
                                }
                                if(!isset($offerDay['fri'])){
                                    $offerDay['fri'] = '0';
                                }
                                if(!isset($offerDay['sat'])){
                                    $offerDay['sat'] = '0';
                                }
                                echo json_encode($offerDay);
                            } 
                        }
                    ?>
                </span>
                
                <span class="disabledDays" style="display:none;">
                    <?php 
                        // get array of all blackout days.
                        $disabledDays = $dDays = array();
                        if(!empty($spaBreakDetails['Spabreak']['blackout_dates'])){  
                            $disabledDay = array_filter(unserialize($spaBreakDetails['Spabreak']['blackout_dates']));
                            if(!empty($disabledDay)){
                                foreach($disabledDay as $keyd=>$valued){
                                    $dDays[] = date('n-j-Y',$valued);
                                }
                            }
                        }
                        
                        // checking lead time for booking to disable current day
                        if(!empty($leadTime)){
                            $lead_time = $leadTime['SalonOnlineBookingRule']['lead_time'];                           
                        }else{
                            $lead_time = 30;
                        }
                        $todayDate = date('H:i:s');
                        $checkInTime = $spaBreakDetails['Spabreak']['check_in'];
                        $interval = round(strtotime($checkInTime) - strtotime($todayDate))/60;
                        if($interval <= $lead_time || $interval <= 0 ){
                            $dDays[] = date('n-j-Y'); 
                        }
                        echo json_encode($dDays);
                    ?>
                </span>
                <span class="priceSpaBreak" style="display:none;"></span>
                
                <div class="list-group pricing-list allPriceOpt spaBreakLabel" >
                    <a href="javascript:void(0);" class="list-group-item no-hover" onclick="return showDiv('selectRoom');">
                        <h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('Select room type & arrival date',true); ?></h4>
                    </a>
                    <div class="col-sm-12 lft-p-non" id="selectRoom">
                        <label class="col-sm-12 lft-p-non"><?php echo __('Select Room Type');?> *:</label>
                        
                        <?php
                            if(!empty($spaBreakOption)){
                                $sallonRoom = '';
                                echo "<select data-id='".$spaBreakDetails['Spabreak']['id']."' name='saloonRoom' id='saloonRoomID' class='spaSaloonRoom form-control full-w' onchange='return changeRoom();' >";
                                //echo "<option value=''>Select Room </option>";
                                foreach($spaBreakOption as $spaBreakOptions){
                                    if(!empty($spaBreakOptions['SalonRoom'][$lang.'_room_type'])){
                                        $sallonRoom = $spaBreakOptions['SalonRoom'][$lang.'_room_type'];
                                    }else{
                                        $sallonRoom =  $spaBreakOptions['SalonRoom']['eng_room_type'];
                                    }
                                ?>
                                    <option value="<?php echo $spaBreakOptions['SalonRoom']['id'];?>"><?php echo $sallonRoom;?></option>
                                <?php
                                }
                                echo "</select>";
                                echo "<p class='saloonRoomCheck'></p>";
                            }

                        ?>
                        
                        <div id="spabreakCalendar" class='cal-sec spabreakCalendar <?php echo (isset($priceotion))?'disabled':''; ?>'></div>
                        <div class="startDateCheck"></div>
                    </div>
                </div>
               
                
                <div class='spaBreakListData  buk-emp-list list-group pricing-list' >     
                    <div style="display: none; position: relative;" class="loader-container" id="ajax_modal">
                        <div class="inner-loader"><img src="/img/gif-load.GIF" alt="" title=""></div>
                    </div>
                    <div class="orderSpaBreakConfirmation" style="display:none;">
                        <a href="javascript:void(0);" class="list-group-item no-hover pdng-lft0 pdng-rgt0 bod-lft-non bod-rgt-non" onclick="return showDiv('orderDetails');">
                            <h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('Order overview',true); ?></h4>
                        </a>
                        <div class="spaBreakOrder" id="orderDetails">
                            <div class="duration">
                                <h5>Room Type</h5>
                                <div class="time checkInRoom">

                                </div>
                            </div>
                            <div class="duration">
                                <h5>Check In</h5>
                                <div class="time checkInTime">

                                </div>
                            </div>
                            <div class="duration">
                                <h5>Check Out</h5>
                                <div class="time checkOutTime">

                                </div>
                            </div>
                            <div class="duration">
                                <h5>Price <span class="personPrice"></span></h5>
                                <div class="time priceSpa">
                                </div>
                            </div>
                            
                            <div class="duration">
                                <h5>Total</h5>
                                <div class="time totalSpaPrice">
                                </div>
                            </div>
                        </div><!-- spaBreakOrder -->
                    </div>
                </div>
                <div class="serviceBukctnt">
                    <div class="centering-wrapper">
                        <div class="pay tp-space">
                            <span><?php echo __('Total',true); ?></span>
                            <strong>
                                    <span class="enabled"><?php echo __('AED',true); ?></span>
                            </strong>
                        </div>
                        <div class="discount-type spaPrice"></div>
                        <div class="book-coupons">Coupons are applied after clicking on book now and before making payments online</div>

                    </div>
                    <a href="javascript:void(0);" class="action" data-type="appointment" data-login_val="spabreak">
                        <span class="appointment bookSpaBreaks"><?php echo __('Book',true); ?></span>
                    </a>
                </div>
            </div>
        <?php } ?>
        <?php if($giftCheck){ ?>
        <div role="tabpanel" class="tab-pane" id="buygift">
            
            <div class="list-group pricing-list allPriceOpt">
                <?php
                $durationArray = $this->common->get_duration();
                if(!empty($spaBreakOption)){
                    $priceotion = true;
                ?>
                    <a href="javascript:void(0);" class="spaBreakLi no-hover">
                            <h4 class="list-group-item-heading"><i class="fa  fa-chevron-circle-down"></i><?php echo __('select_opt',true); ?></h4>
                    </a>
                    <?php
                        foreach($spaBreakOption as $spaBreakOptions){
                            foreach($spaBreakOptions['SpabreakOptionPerday'] as $thePriceOpt){ ?>
                        <?php
                                $SPrice = $thePriceOpt['full_price']; $SDPrice ="";
                                if($thePriceOpt['sell_price']){
                                        $SPrice = $thePriceOpt['sell_price'];
                                        $SDPrice = $thePriceOpt['full_price'] - $thePriceOpt['sell_price'];
                                }
                        ?>
                        <a href="javascript:void(0);" class="spaBreakLi " data-priceID="<?php echo $thePriceOpt['id']?>" data-price="<?php echo $SPrice; ?>" data-disprice="<?php echo $SDPrice; ?>" data-maxbooking="<?php echo $spaBreakOptions['SpabreakOption']['max_booking_perday'];?>" data-roomID="<?php echo $spaBreakOptions['SpabreakOption']['salon_room_id'];?>">
                                <span class="badge"><?php echo __('AED',true);?> <?php echo ($thePriceOpt['sell_price'])? $thePriceOpt['sell_price'] :$thePriceOpt['full_price']; ?>
                                        <?php if(!empty($thePriceOpt['sell_price'])){ ?>
                                        <span class="save"><?php echo __('Save',true); ?> <?php echo (($thePriceOpt['full_price']-$thePriceOpt['sell_price'])/$thePriceOpt['full_price'])*100; ?>%</span>
                                        <?php } ?>
                                </span>
                                <h4 class="list-group-item-heading">
                                <?php  if(!empty($spaBreakOptions['SalonRoom'][$lang.'_room_type'])){
                                                echo ucfirst($spaBreakOptions['SalonRoom'][$lang.'_room_type']);
                                        }else{
                                                echo ucfirst($spaBreakOptions['SalonRoom']['eng_room_type']);
                                        }?>
                                </h4>                               
                        </a>
                        <?php } } ?>

                    <?php
                }
                ?>

            </div>
        <div class="list-group pricing-list ">
            <a href="javascript:void(0);" class="list-group-item no-hover evoucher clearfix bod-btm-non">
                    <h4 class="list-group-item-heading"><i class="fa fa-ticket"></i> <?php echo __('eVoucher_details',true);?></h4>
            </a>
            <div class="cal-sec only-info">
                <ul class="clearfix">
                    <?php $dayArray = array('sun','mon','tue','wed','thu','fri','sat' );?>
                    <?php if($spaBreakDetails['SalonServiceDetail']['offer_available']){
                            $offerOn = unserialize($spaBreakDetails['SalonServiceDetail']['offer_available_weekdays']);
                            foreach($dayArray  as $theDfortick){ ?>
                                    <li><a href="javascript:void(0);"><?php echo __(ucfirst($theDfortick),true);?><span class="fa <?php echo ($offerOn[$theDfortick])? 'fa-check' : 'fa-minus' ;?>"></span></a></li>
                            <?php }	
                    }else{
                            foreach($dayArray  as $theDfortick){?>
                            <li><a href="javascript:void(0);"><?php echo __(ucfirst($theDfortick),true);?><span class="fa fa-check"></span></a></li>
                    <?php }
                    }?>
                </ul>
            </div>
        </div>
        <div class="buk-emp-list">
        <p><?php echo __('You_need_contact_venue_directly_book_appointment_once_received_order_confirmation',true); ?></p>
        <div class="clearfix pos-rgt expiry-box">
                <h4 class="pos-rgt"><?php echo __('eVoucher_expires',true);?>:</h4>
                <div class="">
                <?php if($spaBreakDetails['SalonServiceDetail']['evoucher_expire']){

                        }
                        else{
                                $theexpDate = date('Y-m-d');
                                echo date('d', strtotime("+1 month", strtotime($theexpDate) ));
                                echo " ";
                                echo __(date('F', strtotime("+1 month", strtotime($theexpDate))),true);
                                echo " ";
                                echo date('Y', strtotime("+1 month", strtotime($theexpDate) ));
                        }?>
                </div>
        </div>
        <div class="clearfix pos-rgt expiry-box">
                <h4 class="pos-rgt tp-p-10"><?php echo __('Quantity',true);?>:</h4>
                <div class="">
                <?php echo $this->Form->input('quantity',array('id'=>'selQty','class'=>'w100','label'=>false,'options'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'))); ?>  
                </div>
        </div>
        </div>
        <div class="serviceBukctnt">
                <div class="centering-wrapper">
                        <div class="save" style="display: none">
                                <span><?php echo __('you_save',true); ?></span>
                                <strong><?php echo __('AED',true); ?><span class="DSPrice" style="display: none;">0</span></strong>
                        </div>
                        <div class="pay tp-space">
                                <span><?php echo __('Total',true); ?></span>
                                <strong>
                                        <span class="enabled"><?php echo __('AED',true); ?><span class="Sprice"  style="display: none;"></span></span>
                                </strong>
                        </div>
                    <div class="discount-type spaEvoucher" style="display: none"><?php echo __('sale_price',true); ?><span></span></div>
                    <div class="book-coupons">Coupons are applied after clicking on book now and before making payments online</div>

                </div>
                <a href="javascript:void(0);" class="action disabled"  data-type="eVoucher" data-login_val="spabreak">
                        <span class="appointment"><?php echo __('Buy',true); ?></span>
                </a>
        </div>
        
        </div>
        <?php } ?> 
    </div> 
    
    <?php
        if($reschedule == 'true'){
            echo $this->Form->create('Appointment',array('url'=>array('controller'=>'users','action'=>'reschedule','id'=>'AppointmentShowSpaBreakForm')));  
            echo $this->Form->hidden('Order.id',array('value'=>$order['Order']['id']));	
            echo $this->Form->hidden('OrderDetail.id',array('value'=>$order['OrderDetail'][0]['id']));	
            echo $this->Form->hidden('Order.salon_id',array('value'=>$order['Order']['salon_id']));
            echo $this->Form->hidden('Order.salon_service_id',array('value'=>$order['Order']['salon_service_id']));
            echo $this->Form->hidden('Order.eng_service_name',array('value'=>isset($order['Order']['eng_service_name']) ? $order['Order']['eng_service_name']:''));
        }else{
    ?>
    <?php echo $this->Form->create('Appointment',array('url'=>array('controller'=>'Spabreaks','action'=>'appointment','id'=>'AppointmentShowSpaBreakForm')));?>
    <?php } ?>
        
    <?php echo $this->Form->hidden('employee_id',array('id'=>'employeeId','value'=>$spaBreakDetails['Spabreak']['user_id']));?>
    <?php echo $this->Form->hidden('theBuktype',array('id'=>'serviceSpaType','value'=>''));?>
    <?php 
        echo $this->Form->hidden('price_id',array('id'=>'priceOptId'));
        echo $this->Form->hidden('price_level_id',array('id'=>'priceLvlId'));
        echo $this->Form->hidden('price',array('id'=>'priceVal'));
        echo $this->Form->hidden('discount_price',array('id'=>'priceDisVal'));
    ?>
    
    <?php echo $this->Form->hidden('service_id',array('id'=>'serviceID','value'=>$spaBreakDetails['Spabreak']['id']));?>
    <?php echo $this->Form->hidden('room_id',array('id'=>'roomID'));?>
    
    <?php echo $this->Form->hidden('number_of_person',array('id'=>'numberPerson','value'=>$spaBreakDetails['Spabreak']['no_of_guest']));?>
    <?php echo $this->Form->hidden('number_of_night',array('id'=>'numberNight','value'=>$spaBreakDetails['Spabreak']['no_of_nights']));?>
    <?php echo $this->Form->hidden('breakDateSelected',array('id'=>'startSpaBreak'));?>
    <?php echo $this->Form->hidden('breakDateEnd',array('id'=>'endSpaBreak'));?>
    <?php echo $this->Form->hidden('checkoutDate',array('id'=>'checkoutDate'));?>
    <?php echo $this->Form->hidden('breakDay',array('id'=>'breakDay'));?>
    
    <?php echo $this->Form->hidden('advancebookinglimit',array('id'=>'maxBookingLimit','value'=>''));?>
    <?php echo $this->Form->hidden('selected_employee_id',array('id'=>'selEmpId','value'=>$salonId));?>
    <?php
        $userLoginID = '' ;
        if(isset($_SESSION['Auth']['User'])){
            $userLoginID = $_SESSION['Auth']['User']['id'];
        }
    ?>
    <?php echo $this->Form->hidden('selected_customer',array('id'=>'selCustomer','value'=>$userLoginID));?>
    <?php echo $this->Form->hidden('selected_quantity',array('value'=>1,'id'=>'selQuantity'));?>
    <?php echo $this->Form->end(); ?>
    
    
</div>
    
<script>
$(document).ready(function(){
    
    /*-------------------------- evoucher li click start ------------------------------*/
    $(document).off('click','a.spaBreakLi').on('click','a.spaBreakLi',function(){
        var thepObj = $(this);
        var thepriceId = thepObj.attr('data-priceid');

        if(thepObj.hasClass('selectedPrice')){
            $(document).find('#priceOptId').val('');
            $(document).find('#priceLvlId').val('');
            $(document).find('div.allPriceOpt').find('a').show();
            var mainPriceOpt = $(document).find('div.allPriceOpt').find('a[data-priceid='+thepriceId+']');
            mainPriceOpt.removeClass('selectedPrice').show();
            mainPriceOpt.find('h4 .fa').remove();
            $(document).find('input#selDate').val('');
            $(document).find('.bukingService #bookappointment .stylistListData .allStylistHere').html('');
            toRemovePrice();
        }else{
            if(thepriceId){
                $(document).find('#priceOptId').val(thepriceId);
                $(document).find('#priceLvlId').val(thepObj.attr('data-pricelevel'));
                $(document).find('div.allPriceOpt').find('a.spaBreakLi').hide();
                var mainPriceOpt = $(document).find('div.allPriceOpt').find('a[data-priceid='+thepriceId+']');
                mainPriceOpt.addClass('selectedPrice').show();
                mainPriceOpt.find('h4').prepend('<i class="fa  fa-chevron-circle-down"></i>');

                $(document).find('#priceVal').val(mainPriceOpt.attr('data-price'));
                $(document).find('#priceDisVal').val(mainPriceOpt.attr('data-disprice'));
                $(document).find('#maxBookingLimit').val(mainPriceOpt.attr('data-maxbooking'));
                $(document).find('.spaEvoucher span').text(mainPriceOpt.attr('data-disprice'));
                $(document).find('#roomID').val(mainPriceOpt.attr('data-roomID'));
                var theQty = $('#selQuantity').val();
                $(document).find('#selQuantity').val(theQty);
                
                toAddPrice(); 
                
            }
        }
        enableSubmit();
   
    
    });
        
    /*--------------------------------- evoucher li click end --------------------------*/
    
    
    /*----------------------------- form submit start here -----------------------------*/
    $(document).on('click','.serviceBukctnt a.action',function(e){
        var theAppType = $(this).attr('data-type');
        if(!$(this).hasClass('disabled')){
            user_data = "<?php if(isset($_SESSION['Auth']['User']['id'])){ echo $_SESSION['Auth']['User']['id']; }?>";
            if(user_data){
                $(document).find('#serviceSpaType').val(theAppType);
                $(document).find("#selCustomer").val("<?php if(isset($_SESSION['Auth']['User']['id'])){ echo $_SESSION['Auth']['User']['id']; }?>");
                
                $(".loader-container").css("display","block");
                window.setTimeout(function() {
                    $(document).find('#AppointmentShowSpaBreakForm').submit(); 
                }, 4000);              
            }else{
                $(document).find('.userLoginModal').click();
                e.preventDefault();
            }
        }
    }); 
    /*------------------------------- form submit end here -----------------------------*/
    
    
    $(document).find('div.soldOptions').find('ul.ulopts li:first').addClass('active');
    var tabID = $(document).find('div.soldOptions').find('ul.ulopts li:first a').attr('aria-controls');
    $(document).find('div.soldOptions').find('#'+tabID).addClass('active');
    if($(document).find('div.soldOptions').find('ul.ulopts li').length == 1){
        $(document).find('div.soldOptions').find('ul.ulopts li').addClass('full-w');
        if(tabID == 'buygift'){
                toAddPrice();
        }
    }

    $(document).find("#selQty").select2({}).on('open', function(){
        $(document).find('.salon-typ .input.select').addClass('purple-bod');
        }).on('close',function(){
            $(document).find('.salon-typ .input.select').removeClass('purple-bod');
    });
    
    
    // validation check for spa break booking form and then submit
    $(document).on("click",".bookSpaBreaks",function(){
        if($(document).find("#saloonRoomID").val()==''){
            $(document).find("#saloonRoomID").css({"border":"1px solid #A94442"});
            $(document).find(".saloonRoomCheck").text("Select Saloon Room Type.");
            return false;
        }else{
            $(document).find("#saloonRoomID").css({"border":"1px solid #CBCBCB"});
            $(document).find(".saloonRoomCheck").text("");
        }
        if($(document).find("#startSpaBreak").val()==''){
            $("#selectRoom").show();
            $(document).find(".startDateCheck").text("Choose Date for booking.");
            return false;
        }else{
            $(document).find(".startDateCheck").text("");
        }
        var roomType = $(document).find('#saloonRoomID option:selected').text();
        var startDate = $(document).find('#startSpaBreak').val();
        var endDate = $(document).find('#checkoutDate').val();
        var numberPerson = $(document).find('#numberPerson').val();
        var numberNight = $(document).find('#numberNight').val();
        
        $(document).find(".checkInTime").html(startDate);
        $(document).find(".checkOutTime").html(endDate);
        $(document).find(".checkInRoom").html(roomType);
        
        // show price on order
        var breakDay = $(document).find('#breakDay').val();
        var priceSpaBreak = $(document).find('.priceSpaBreak').text();
        priceSpaBreak = jQuery.trim( priceSpaBreak );
        var priceSpaBreakFinal = new Array();
        if(priceSpaBreak!=''){
            priceSpaBreakFinal = jQuery.parseJSON(priceSpaBreak); 
            $(document).find(".priceSpa").html("AED "+priceSpaBreakFinal[breakDay]);
            $(document).find(".totalSpaPrice").html("AED "+priceSpaBreakFinal[breakDay]);
            $(document).find(".spaPrice").show();
            $(document).find(".spaPrice").html(priceSpaBreakFinal[breakDay]);
            $(document).find('#priceVal').val(priceSpaBreakFinal[breakDay]);
        }
        
        $("#selectRoom").hide();
        $(".orderSpaBreakConfirmation").show();
        
    });  
       
    // for room auto select    
    changeRoom();      
});

// on change event of saloon room type will update datepicker
function changeRoom(){
    
    var roomValue = $(document).find("#saloonRoomID").val();
    $(document).find('#roomID').val(roomValue);
    var spaBreakIDD = $(document).find("#saloonRoomID").attr("data-id");
    
    if(roomValue!=''){
        $(document).find(".saloonRoomCheck").text("");
        $(document).find("#saloonRoomID").css({"border":"1px solid #CBCBCB"});
        var reSchdule = "<?php echo $pricingoption;?>";
        $.post( "<?php echo Router::url(array('controller'=>'place','action'=>'spaBreakDates'));?>/"+spaBreakIDD+'/'+roomValue+'/'+reSchdule, function( data ) {
            $(document).find(".priceSpaBreak").text(data);
        }).success(function() {
        
        }).done(function() {
           // alert("enter2");
           datepickerIntialize(roomValue);
        });
        
    }else{
        $(document).find("#saloonRoomID").css({"border":"1px solid #A94442"});
        $(document).find(".saloonRoomCheck").text("Select Saloon Room Type.");
    }
}


function datepickerIntialize(roomValue){
    $(document).find(".spabreakCalendar").addClass("spabreakCalendar-"+roomValue);
    $(document).find(".spabreakCalendar-"+roomValue).datepicker({
        constrainInput: true,
        minDate:0,
        beforeShowDay:function(date) {

            var offerOn = $(document).find('.offerOn').text();
            offerOn = jQuery.trim( offerOn );
            var offerDaysFinal = disableFinalDates = new Array();
            if(offerOn!=''){
                offerDaysFinal = jQuery.parseJSON(offerOn);  
            }

            // spa break prices
            var priceSpaBreak = $(document).find('.priceSpaBreak').text();
            priceSpaBreak = jQuery.trim( priceSpaBreak );
            var priceSpaBreakFinal = new Array();
            if(priceSpaBreak!=''){
                priceSpaBreakFinal = jQuery.parseJSON(priceSpaBreak);  
            }

            /* create an array of dates which need to be disabled */
            var disabledDays = $(document).find('.disabledDays').text();
            disabledDays =  jQuery.trim( disabledDays );
            if(disabledDays!=''){
                disableFinalDates = jQuery.parseJSON(disabledDays); 
            }

            var day = date.getDay();

            var currentDate = $(document).find("#startSpaBreak").val();
            var endDate = $(document).find("#endSpaBreak").val();
            var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
            var checkDate = (m+1) + '/' + d + '/' + y;

            // disabled weekdays as per offer available week days
            if(offerDaysFinal!=''){
                if(offerDaysFinal['sun']==0 || priceSpaBreakFinal['sunday'] <= 0){
                    if (day==0) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(offerDaysFinal['mon']==0 || priceSpaBreakFinal['monday'] <= 0 ){
                    if (day==1) {
                        //return [false, "disabledDays"]
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(offerDaysFinal['tue']==0 || priceSpaBreakFinal['tuesday'] <= 0){
                    if (day==2) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(offerDaysFinal['wed']==0 || priceSpaBreakFinal['wednesday']<=0){
                    if (day==3) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(offerDaysFinal['thu']==0 || priceSpaBreakFinal['thursday']<=0){
                    if (day==4) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(offerDaysFinal['fri']==0 || priceSpaBreakFinal['friday'] <= 0){
                    if (day==5) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(offerDaysFinal['sat']==0 || priceSpaBreakFinal['saturday'] <= 0){
                    if (day==6) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                        
                    }
                }
                return disableSpaDates(date); 
            }else{
                if(priceSpaBreakFinal['sunday'] <= 0){
                    if (day==0) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(priceSpaBreakFinal['monday'] <= 0 ){
                    if (day==1) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(priceSpaBreakFinal['tuesday'] <= 0){
                    if (day==2) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(priceSpaBreakFinal['wednesday'] <= 0){
                    if (day==3) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(priceSpaBreakFinal['thursday'] <= 0){
                    if (day==4) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(priceSpaBreakFinal['friday'] <= 0){
                    if (day==5) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                if(priceSpaBreakFinal['saturday'] <= 0){
                    if (day==6) {
                        if(dateCheck(currentDate,endDate,checkDate)){
                            return [false, "disabledDays highLight"]
                        }else{
                            return [false, "disabledDays"]
                        }
                    }
                }
                return disableSpaDates(date);    
            }            
        },
        onSelect: function(date) {
            // insert weekdays and date in input field
            var date = new Date(date);
            var weekdays = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
            var weekday = weekdays[date.getDay()];
            var month = date.getMonth() + 1;
            var year = date.getFullYear();			
            var datedd = date.getDate();
            
            // chnage date format for selected date 
            var datefinal = month+'/'+datedd+'/'+year;
            $(document).find('#startSpaBreak').val(datefinal);
            $(document).find("#breakDay").val(weekday);
            var numberNight = parseInt($(document).find('#numberNight').val());
            numberNightFinal = numberNight-1;
            var selectUp = new Date(date);
            
            selectUp.setDate(selectUp.getDate() + numberNightFinal); 
            //console.log(selectUp);
            
            // chnage date format for next dates
            var selectUpDate = new Date(selectUp);
            var selectUpMonth = selectUpDate.getMonth() + 1;
            var selectUpYear = selectUpDate.getFullYear();			
            var selectUpDated = selectUpDate.getDate();
            
            // chnage date format for selected date 
            var endDate = selectUpMonth+'/'+selectUpDated+'/'+selectUpYear;
            $('#endSpaBreak').val(endDate);
            
            
            // checkout date 
            var checkout = new Date(date);
            checkout.setDate(checkout.getDate() + numberNight); 
            var checkoutDate = new Date(checkout);
            var checkoutMonth = checkoutDate.getMonth() + 1;
            var checkoutYear = checkoutDate.getFullYear();			
            var checkoutDated = checkoutDate.getDate(); 
            
            // chnage date format for selected date 
            var checkoutDates = checkoutMonth+'/'+checkoutDated+'/'+checkoutYear;
            
            $('#checkoutDate').val(checkoutDates);
            
            // on select to update the order div
            var roomType = $(document).find('#saloonRoomID option:selected').text();
            var startDate = $(document).find('#startSpaBreak').val(); 
            var endDate = $(document).find('#checkoutDate').val();
            var numberPerson = $(document).find('#numberPerson').val();
            var numberNight = $(document).find('#numberNight').val();

            $(document).find(".checkInTime").html(startDate);
            $(document).find(".checkOutTime").html(endDate);
            $(document).find(".checkInRoom").html(roomType);

            // show price on order
            var breakDay = $(document).find('#breakDay').val();
            var priceSpaBreak = $(document).find('.priceSpaBreak').text();
            priceSpaBreak = jQuery.trim( priceSpaBreak );
            var priceSpaBreakFinal = new Array();
            if(priceSpaBreak!=''){
                priceSpaBreakFinal = jQuery.parseJSON(priceSpaBreak); 
                $(document).find(".priceSpa").html("AED "+priceSpaBreakFinal[breakDay]);
                $(document).find(".totalSpaPrice").html("AED "+priceSpaBreakFinal[breakDay]);
                $(document).find(".spaPrice").html(priceSpaBreakFinal[breakDay]);
                $(document).find('#priceVal').val(priceSpaBreakFinal[breakDay]);
            }
        
        }
    }).on('mouseenter', '.ui-datepicker-calendar tbody tr td:not(.disabledDat, .ui-state-disabled)', function (e) { 
        var contentPrice = '';
        var dateIndex = $(this).index();
        
        // spa break prices
        var priceSpaBreak = $(document).find('.priceSpaBreak').text();
        priceSpaBreak = jQuery.trim( priceSpaBreak );
        var priceSpaBreakFinal = new Array();
        if(priceSpaBreak!=''){
            priceSpaBreakFinal = jQuery.parseJSON(priceSpaBreak);  
            switch(dateIndex) {
                case 0:
                    contentPrice = priceSpaBreakFinal['sunday'];
                    break;
                case 1:
                    contentPrice = priceSpaBreakFinal['monday'];
                    break;
                case 2:
                    contentPrice = priceSpaBreakFinal['tuesday'];
                    break;
                case 3:
                    contentPrice = priceSpaBreakFinal['wednesday'];
                    break;
                case 4:
                    contentPrice = priceSpaBreakFinal['thursday'];
                    break;
                case 5:
                    contentPrice = priceSpaBreakFinal['friday'];
                    break;
                case 6:
                    contentPrice = priceSpaBreakFinal['saturday'];
                    break;
                default:
                    contentPrice = '';
            } 
        }
        
        var nightPerson = '';
        var nights = $('#numberPerson').val();
        if(nights==1){
            nightPerson = '</br> Per Person';
        }else{
            nightPerson = '</br> Per '+nights+' Person';
        }
        
        $(this).find('a').addClass('popoverShow');       
        $(this).find('a').attr({
            "data-trigger":"hover",
            "data-placement":"bottom",
            "rel":"popover",
            "data-content": "AED "+contentPrice+nightPerson
        });
    
        $(this).find('.popoverShow').popover({
            placement : 'top',
            trigger: 'hover',
            container : 'body',
            html : true,
            delay: { "show": 200, "hide": 100 },
            content: function() {
            }
        });
	return false;        
    }).on('mouseleave', '.ui-datepicker-calendar tbody tr td:not(.disabledDat, .ui-state-disabled)', function (e) { 
        $('.popover').hide();
    });
    //auto trigger only once to update datepicker
    $(document).find(".ui-datepicker-calendar tbody tr td:not(.disabledDat, .ui-state-disabled)").trigger('click');
    
}

// check dates in range then return highlight
function dateCheck(from,to,check) {
    var fDate,lDate,cDate;
    fDate = Date.parse(from);
    lDate = Date.parse(to);
    cDate = Date.parse(check);

    if((cDate <= lDate && cDate >= fDate)) {
        return true;
    }
    return false;
}


// disable spa breaks
function disableSpaDates(date) {
    var currentDate =  $(document).find("#startSpaBreak").val();
    var endDate =  $(document).find("#endSpaBreak").val();
    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
    var checkDate = (m+1) + '/' + d + '/' + y;
    if(disableFinalDates!=''){
        for (i = 0; i < disableFinalDates.length; i++) {
            if($.inArray((m+1) + '-' + d + '-' + y,disableFinalDates) != -1) {
                //return [false , "disable"];
                if(dateCheck(currentDate,endDate,checkDate)){
                    return [false, "disabledDays highLight"];
                }else{
                    return [false, "disabledDays"];
                }
            }
        }
    }
    
    if(currentDate!=''){	        
        //console.log(checkDate);
        if(dateCheck(currentDate,endDate,checkDate))
            return [true, "highLight"]
        else
            return [true, ""]
    }
	
    return [true];
}


// toggle div 
function showDiv(div){
    $("#"+div).slideToggle();
}
</script>
<?php echo $this->Js->writeBuffer();?>
