<?php
    echo $this->Html->css('admin/plugins/select2/select2');
    echo $this->Html->script('admin/plugins/select2/select2.min.js');
    $timestamp= $time;
    $startdate=gmdate("d/m/Y", $timestamp);
    $starttime=gmdate("h:ia", $timestamp);
    if(!isset($edit_personal_appointment) && empty($edit_personal_appointment)){
        $timestamp = strtotime($starttime) + 60*60;
        $endtime = date('h:ia', $timestamp);
    }
    else{
        $duration=$edit_personal_appointment['Appointment']['appointment_duration']; 
        $endtime = date("h:ia",strtotime("+".$duration." minutes", strtotime($starttime)));
    }
    
?>
    <script>
        var startdate='<?php echo $startdate; ?>';
        var starttime='<?php echo $starttime; ?>';
        var endtime='<?php echo $endtime; ?>';
        
        var st='<?php echo date('h:iA',$open_close_hours[0]); ?>';
        var en='<?php echo date('h:iA',$open_close_hours[1]); ?>';
        
        
        $(function() {
            $('#AppointmentTime').timepicker({'setTime': st,
                                             'minTime': st,
                                             'maxTime': en,
                                             'showDuration': false,
                                             'timeFormat': 'h:iA'
            });
            $('#AppointmentEndtime').timepicker({'setTime': st,
                                                'minTime': st,
                                                'maxTime': en,
                                                'showDuration': false,
                                                'timeFormat': 'h:iA'
            });
            $('#AppointmentTime').timepicker('setTime', st);
            $('#AppointmentEndtime').timepicker('setTime', en);
            $('.theDatePick').datepicker({
                dateFormat: "dd/mm/yy",
                minDate: startdate,
                onClose: function(dateText, inst) {
                    $('.theDatePick').blur();
            }               
      });
            
        });
    </script>
    <div class="modal-dialog modal-lg vendor-setting addUserModal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3 id="myModalLabel"><i class="icon-edit"></i>
                        <?php echo (isset($edit_personal_appointment) && !empty($edit_personal_appointment))?'Edit':"Add"; ?> Personal Task
                    </h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <div class="box-content">
                                <?php echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
                                <?php echo $this->Form->hidden('Appointment.id',array('div'=>false,'label'=>false));?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?php if(isset($edit_personal_appointment) && $edit_personal_appointment['Appointment']['appointment_repeat_type']!='0'){ ?>
                                        <div class="form-group">
                                            <label class="control-label"><b>Edit:</b></label> 
                                            <?php $options=array('only'=>'Edit only this occurrence','series'=>'Edit the Series');
                                                $attributes=array('label'=>array('class'=>'new-chk'),'legend'=>false ,'class'=>'radio-inline cancelPeriodRadioPolicy','separator'=> '</div><div class="form-group">','value'=>'','value'=>'series');
                                                echo $this->Form->radio('Appointment.occur',$options,$attributes); ?>
                                        </div>
                              <?php } ?>
                                        <div class="form-group">
                                            <label class="control-label"><b>Provider:</b></label>
                                            <?php echo $staffname; ?>
                                        </div>
                                        <div class="form-group">
                                            <?php echo $this->Form->input('Appointment.salon_staff_id',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$employeeId)); ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><b>Date:</b></label>
                                            <?php echo $startdate; ?>
                                            <?php echo $this->Form->hidden('Appointment.date',array('div'=>false,'label'=>false,'value'=>$startdate));?>
                                        </div>
                                        <div class="form-group">
                                            <?php if(isset($edit_personal_appointment) && $edit_personal_appointment['Appointment']['appointment_title']!=''){
                                                    $selected=$edit_personal_appointment['Appointment']['appointment_title'];
                                            }
                                            else{
                                                $selected='';
                                            }
                                            $arrTypeAppointment=array("Sick Day"=>"Sick Day","Vacation"=>"Vacation","Holiday"=>"Holiday","Lunch Break"=>"Lunch Break","Meeting"=>"Meeting","Task"=>"Task","Note"=>"Note");
                                            echo $this->Form->input('Appointment.appointment_title', array('options'=>$arrTypeAppointment, 'label'=>false,
                                  'class'=>'form-control','div'=>false,'selected'=>$selected)); 
?>
                                        </div>
                                        <div class="form-group clearfix">
                                                <?php if(isset($edit_personal_appointment) && $edit_personal_appointment['Appointment']['block_booking']!='' && $edit_personal_appointment['Appointment']['block_booking']==1){
                                                $checked='checked';
                                            }else{
                                                $checked='';
                                            } ?>
                                            <div class="col-sm-12">
                                                <?php echo $this->Form->input('Appointment.block_booking',array('div'=>false,'class'=>'validate[required]','type'=>'checkbox',$checked,'label'=>array('class'=>'new-chk','text'=>'Block Online Booking'))); ?>                                              
                                            </div>
                                        </div>
                
                                        <div class="form-group">
                                            <?php if(isset($edit_personal_appointment) && $edit_personal_appointment['Appointment']['whole_day_off']!='' && $edit_personal_appointment['Appointment']['whole_day_off']==1){
                                    $checked='checked';
                                }
                                else{
                                    $checked='';
                                } ?>
                                            <div class="col-sm-12 ">
                                            <?php echo $this->Form->input('Appointment.whole_day_off',array('div'=>false,'class'=>'validate[required]','type'=>'checkbox',$checked,'label'=>array('class'=>'new-chk','text'=>'Whole Day Off'))); ?>              </div></div>
                                        
                                        
                                        <div class="form-group ifwholeDay clearfix" <?php echo ($checked == 'checked')?'style="display:none"':'';?> >
                                            <div class="col-sm-6 lft-p-non">
                                                <label class="control-label">From*:</label>
                                                <?php echo $this->Form->input('time',array('class'=>'form-control','div'=>false,'label'=>false,'required','ValidationMessage'=>'Please enter start time.'));?>
                                            </div>
                                            <div class="col-sm-6 lft-p-non">
                                                <label class="control-label">To*:</label>
                                                <?php echo $this->Form->input('endtime',array('class'=>'form-control','div'=>false,'label'=>false,'value'=>$endtime,'required','ValidationMessage'=>'Please enter end time.'));?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <?php if(isset($edit_personal_appointment) && $edit_personal_appointment['Appointment']['appointment_comment']!=''){
                                                    $comments=$edit_personal_appointment['Appointment']['appointment_comment'];
                                        }else{
                                            $comments='';
                                    } ?>
                                        <label class="control-label">Appointment Comment:</label>
                                        <?php echo $this->Form->input('appointment_comment',array('class'=>'form-control','id'=>'durationExample','div'=>false,'cols'=>40,'label'=>false,'type'=>'textarea','value'=>$comments));?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php if(isset($edit_personal_appointment['Appointment']['appointment_repeat_type']) && $edit_personal_appointment['Appointment']['appointment_repeat_type']!=0) { ?>
                                        <div class="form-group" id="repeat">
                                            <?php echo $this->element('admin/Appointment/appointment_repeat'); ?>
                                        </div>
                                        <?php } elseif(!isset($edit_personal_appointment['Appointment']['appointment_repeat_type'])){ ?>
                                        <div class="form-group" id="repeat">                                            <?php echo $this->element('admin/Appointment/appointment_repeat'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div> 
                                <div class="modal-footer pdng20">
                                    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitPersonalTask','label'=>false,'div'=>false));?>
                                    <?php echo $this->Form->button('Cancel',array(
                                                                    'type'=>'button',
                                                                    'label'=>false,'div'=>false,
                                                                    'data-dismiss'=>'modal',
                                                                    'class'=>'btn')); ?>
                                </div>
                                <?php echo $this->Form->end();?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                var $modal = $('#commonContainerModal');
                $modal.on('click', '.submitPersonalTask', function(e){
                var options = { 
                  //beforeSubmit:  showRequest,  // pre-submit callback 
                  success:function(res){
                        // onResponse function in modal_common.js
                        if(onResponse($modal,'User',res)){
                              var data = jQuery.parseJSON(res);
                              if(data.id){
                                    $('body').modalmanager('loading');
                                    var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'manage')); ?>";
                                    userDetailURL = userDetailURL+'/'+data.id
                                    $(document).find(".userdetails").load(userDetailURL, function() {
                                          $('body').modalmanager('loading'); 
                                          onSelectChange(data.id);
                                    });
                              }
                        }
                  }
            }; 
            $('#UserAdminAddUserForm').submit(function(){
                  $(this).ajaxSubmit(options);
                  $(this).unbind('submit');
                  $(this).bind('submit');
                  return false;
            });
      });
      
      $modal.on('blur','#UserEmail',function(){
            var userEmail = $(this).val();
            $.ajax({
                  url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'findUserViaEmail','admin'=>true))?>",
                  type: "POST",
                  data: {email:userEmail},
                  success: function(res) {
                        var data = jQuery.parseJSON(res);
                        if(data.data == 'success'){
                              $('body').modalmanager('loading');    
                              var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'addUser')); ?>";
                              addeditURL = addeditURL+'/'+data.id; 
                              $modal.load(addeditURL, '', function(){
                                  $('body').modalmanager('loading');    
                              });    
                        }
                  }
            });
      });
    
      $(document).find("#AppointmentUserId").select2().on("change", function(e) {
            onSelectChange(e.val);
      });
    
      $(document).find("#AppointmentSalonServiceId").on("change", function() {
            service_id=this.value;
            onServiceChange(service_id);
      });
    
      $(document).find("#AppointmentRepeatId").on("change",function() {
            var selected_val=this.value;
            if (selected_val=='0') {
                  $("#repeat-yearly").hide();
                  $("#repeat-monthly").hide();
                  $("#repeat-weekly").hide();
                  $("#repeat-daily").hide();
            }
            if (selected_val=='1') {
                  $("#repeat-yearly").hide();
                  $("#repeat-monthly").hide();
                  $("#repeat-weekly").hide();
                  $("#repeat-daily").show();
            }
            if (selected_val=='2') {
                  $("#repeat-yearly").hide();
                  $("#repeat-monthly").hide();
                  $("#repeat-weekly").show();
                  $("#repeat-daily").show();
            }
            if (selected_val=='3') {
                  $("#repeat-yearly").hide();
                  $("#repeat-monthly").show();
                  $("#repeat-weekly").hide();
                  $("#repeat-daily").show();
            }
            if (selected_val=='4') {
                  $("#repeat-yearly").show();
                  $("#repeat-monthly").hide();
                  $("#repeat-weekly").hide();
                  $("#repeat-daily").show();
            }
      });
      
      
       $("#AppointmentOccurOnly" ).change(function() {
            $("#repeat").hide();
        });
        $("#AppointmentOccurSeries" ).change(function() {
            $("#repeat").show();
        });
        $("#AppointmentTime").keypress(function (e){
            e.preventDefault();
        });
        $("#AppointmentEndtime").keypress(function (e){
            e.preventDefault();
        });
        
        $('#AppointmentWholeDayOff').on('click',function(){
            if($(this).is(':checked')){
                $('.ifwholeDay').hide();
            }else{
                $('.ifwholeDay').show();
            }
        });
        
       
});
</script>
     <style>
      .ui-icon {
    background-repeat: no-repeat;
    display: block;
    overflow: hidden;
    text-indent: 0;
}
</style>   