
<div class="modal-dialog login">
    <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('Request Booking', true); ?></h4>
        </div>
        <div class="modal-body clearfix requestBookingModal">
            <?php
                $usedEvoucher = 0;
                $unusedEvoucher = 0;
                $voucherToRedeem = '';
                if(!empty($order['Evoucher']) && !empty($order)){
                    foreach($order['Evoucher'] as $key=>$eVoucher){
                        if($eVoucher['used'] == 0){
                            if(empty($voucherToRedeem)){
                                $voucherToRedeem = $key;    
                            }
                            $unusedEvoucher++;
                        }else{
                            $usedEvoucher++;
                        }
                    }
                    $voucherToRedeem = ($voucherToRedeem != '' ) ? $voucherToRedeem : 0; 
                    $evoucherType =  $order['Evoucher'][$voucherToRedeem]['evoucher_type'];
                    $evoucherPrice =  $order['Evoucher'][$voucherToRedeem]['price'];
                    $typeName = 'service';
                    $image = '';
                    switch ($evoucherType) {
                        case 1:
                            //servicename
                            $salon_service_name = $this->Common->get_salon_service_name($order['Order']['salon_service_id']);
                            //serviceimage
                            $image = $this->Common->getsalonserviceImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
                            //echo $evoucherType;
                            $type  = 1;
                            $typeName = 'service';

                            break;
                        case 2:
                            //packagename
                            $salon_service_name = $this->Common->get_salon_package_name($order['Order']['salon_service_id']);
                            //packageimage
                            $image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
                            //echo $evoucherType;
                            //code for package evoucher
                            $type  = 2;
                            $typeName = 'packages';
                            break;
                        case 3:
                            //packagename
                            $salon_service_name = $this->Common->get_salon_package_name($order['Order']['salon_service_id']);
                            //packageimage
                            $image = $this->Common->getpackageImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);
                            //echo $evoucherType;
                            //code for package evoucher
                            $type  = 2;
                            $typeName = 'packages'; 
                            break;
                        case 4:
                            //code for deal evoucher
                            // DEal name
                            $salon_service_name = $this->Common->get_salon_deal_name($order['Order']['salon_service_id']);
                            //deal image
                            $image = $this->Common->getDealImage($order['Order']['salon_service_id'],$order['Order']['salon_id']);

                            $dealType = $this->Common->getDealType($order['Order']['salon_service_id']);


                            if(isset($dealType['Deal']) && !empty($dealType['Deal']) && isset($dealType['DealServicePackage']) && !empty($dealType['DealServicePackage'])){

                                $dealtype = $dealType['Deal']['type'];
                                if($dealtype == 'Service'){
                                    $type  = 1;
                                    $typeName = 'service';
                                    $deal = true;
                                }else{
                                    $type  = 2;
                                    $typeName = 'packages';
                                    $deal = true;
                                }
                            }
                            break;
                        case 5:
                            //code for spabreak evoucher
                            //servicename
                            $salon_service_name = $this->Common->get_spabreak_name($order['Order']['salon_service_id']);
                            //serviceimage
                            //pr($order);

                            $image = $this->Common->getspabreakImage($order['Order']['salon_service_id'],null,350);
                            //echo $evoucherType;
                            $type  = 5;
                            $typeName = 'spabreak';
                            break;
                    } ?>
            <ul class="login-form">                
                
                <li><h2><?php echo $salon_service_name; ?></h2></li>
                <li><p class="purple"><?php echo $this->Common->get_my_salon_name($order['Order']['salon_id']); ?></p></li>
                <li><h2 class="price">AED <?php echo $evoucherPrice; ?></h2></li>
                <li><h2 class="">Type : eVoucher</h2></li>
                <li>
                    <b>Qty  : </b><?php echo $unusedEvoucher; ?>  <b>Used : </b><?php echo $usedEvoucher; ?>
                </li>
                <li>
                    <?php
                        echo $this->Html->image($image,array('class'=> ""));
                    ?>
                </li>
            </ul> 
            <ul class="login-form social">
                <li>
                    <h2><?php echo __('Request Booking',true); ?></h2>                    
                </li>
                <?php echo $this->Form->create('Appointment', array('novalidate','url' => array('controller' => 'users', 'action' => 'request_booking'.'/'.$order['Order']['id'].'/'.$evouchers['Evoucher']['id']),'id'=>'requestBookingForm')); ?>
                <?php echo $this->Form->hidden('Appointment.order_id',array('value'=>$order['Order']['id']));?>
                <?php echo $this->Form->hidden('Appointment.evoucher_id',array('value'=>$evouchers['Evoucher']['id']));?>
                    <li>
                        <label><?php echo __('Select Staff',true); ?>*</label>
                        <?php
                            $option = array();
                            if(!empty($staffList)){
                                foreach($staffList as $staff){
                                    $useridd =  $staff['User']['id'];
                                    $option[$useridd] = ucwords($staff['User']['first_name']).' '.ucwords($staff['User']['last_name']);
                                }
                            }
                        ?>
                        <?php echo $this->Form->input('Appointment.salon_staff_id',array('type'=>'select','options'=>$option,'empty'=>'Select Staff','label'=>false,'div'=>false,'class'=>'select2','required','validationMessage'=>__("Salon Staff is required.",true)));?>
                    </li>
                    <li>
                        <label><?php echo __('Date',true); ?>*</label>
                        <?php echo $this->Form->input('Appointment.start_date',array('type'=>'text','label'=>false,'div'=>false,'class'=>'login-text-field datepicker','required','validationMessage'=>__("Booking Date is required.",true)));?>
                    </li>
                    <li>
                        <label><?php echo __('Time',true); ?>*</label>
                        <?php echo $this->Form->input('Appointment.time',array('type'=>'text','label'=>false,'div'=>false,'class'=>'login-text-field timepicker','required','validationMessage'=>__("Booking time is required",true)));?> 
                    </li>
                    <li>
                       <?php echo $this->Form->submit(__('Send Request'),array('class'=>'action-button submitBooking','div'=>false,'label'=>false));  ?>
                    </li>
                <?php echo $this->Form->end(); ?>
            </ul> 
            <?php
                    }
            ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $(document).find('.select2').select2();
        $(document).find('.timepicker').timepicker();
        $(document).find( ".datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
        });
        var validator = $(document).find("#requestBookingForm").kendoValidator({
            rules:{
                minlength: function (input) {
                    return minLegthValidation(input);
                },
                maxlength: function (input) {
                    return maxLegthValidation(input);
                },
                pattern: function (input) {
                    return patternValidation(input);
                }
            },
            errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"
        }).data("kendoValidator");    
    });
</script>  


