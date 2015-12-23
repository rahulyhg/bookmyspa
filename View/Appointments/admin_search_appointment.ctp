<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min');
?>
<script>
$(function() {
    $('.theDatePick').datepicker({
        dateFormat: "yy-mm-dd",
        minDate: new Date(),
        onClose: function(dateText, inst) {
            $('#AppointmentStartdate').blur();
        }               
    });
});
</script>
<div class="modal-dialog modal-lg vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i><?php echo "Search An Appointment";  ?></h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
                            <?php echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <?php echo $this->element('admin/Appointment/appointment_customer_search_detail'); ?>
                                </div>
                            </div>
                            <div id="block_1" class="block">
                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <div class="form-group"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label"><b><p>Service:*</p></b></label>
                                                <?php if(isset($service_id) && $service_id!=''){ 
                                                        $selected=$service_id;
                                                    }else{
                                                        $selected='';
                                                } ?>
                                                <?php echo $this->Form->input('Appointment.salon_service_id_1',array('options'=>$staffServices,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control search_treatment','required','ValidationMessage'=>'Please select treament.','div'=>false,'selected'=>$selected)); ?>
                                            </div>
                                            <div class="form-group"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label"><b><p>Service Provider:*</p></b></label>
                                                <?php if(isset($employeeId) && $employeeId!=''){ 
                                                        $selected=$employeeId;
                                                    }else{
                                                        $selected='';
                                                } ?>
                                                <?php echo $this->Form->input('Appointment.salon_staff_id_1',array('options'=>$staff_list,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control','required','ValidationMessage'=>'Please select provider.','div'=>false,'selected'=>$selected)); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label"><b><p>Date</p></b></label>
                                                <?php echo $this->Form->input('startdate',array('class'=>'form-control theDatePick','div'=>false,'label'=>false));?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="block_2" class="block">
                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <i class="icon-remove-sign removeLink"  id="2"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label"><b><p>Service:*</p></b></label>
                                                <?php if(isset($service_id) && $service_id!=''){ 
                                                        $selected=$service_id;
                                                    }else{
                                                        $selected='';
                                                } ?>
                                                <?php echo $this->Form->input('Appointment.salon_service_id_2',array('options'=>$staffServices,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control search_treatment','','ValidationMessage'=>'Please select treament.','div'=>false,'selected'=>$selected)); ?>
                                            </div>
                                            <div class="form-group"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label"><b><p>Service Provider</p></b></label>
                                                <?php if(isset($employeeId) && $employeeId!=''){ 
                                                        $selected=$employeeId;
                                                    }else{
                                                        $selected='';
                                                } ?>
                                                <?php echo $this->Form->input('Appointment.salon_staff_id_2',array('options'=>$staff_list,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control','div'=>false,'selected'=>$selected)); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="block_3" class="block">
                                <div class="clearfix">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <i class="icon-remove-sign removeLink"  id="3"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label"><b><p>Service:*</p></b></label>
                                                <?php if(isset($service_id) && $service_id!=''){ 
                                                        $selected=$service_id;
                                                    }else{
                                                        $selected='';
                                                } ?>
                                                <?php echo $this->Form->input('Appointment.salon_service_id_3',array('options'=>$staffServices,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control search_treatment','','ValidationMessage'=>'Please select treament.','div'=>false,'selected'=>$selected)); ?>
                                            </div>
                                            <div class="form-group"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label"><b><p>Service Provider</p></b></label>
                                                <?php if(isset($employeeId) && $employeeId!=''){ 
                                                        $selected=$employeeId;
                                                    }else{
                                                        $selected='';
                                                } ?>
                                                <?php echo $this->Form->input('Appointment.salon_staff_id_3',array('options'=>$staff_list,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control','div'=>false,'selected'=>$selected)); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div id="add" value="1" class="btn  pull-left mrgn-btm10"><i class="icon-plus"></i> Add New Treatment</div>
                                <div class="form-group">
                                    <label class="control-label"></label>
                                    <?php echo $this->Form->button('Search',array('type'=>'submit','class'=>'btn btn-primary searchAppointments','label'=>false,'div'=>false));?>
                                </div>
                            </div>
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>
                </div>
            </div>
            <?php  echo $this->element('admin/Appointment/appointment_search_timeslots');  ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    var select = $('#AppointmentUserId').select2();
    $(document).find("#AppointmentUserId").select2().on("change", function(e) {
        //alert("tetetet");
            onSelectSearchChange(e.val);
      });
    $('#AppointmentStartdate').removeAttr('required');
       
    $(document).find("#block_2").hide();
    $(document).find("#block_3").hide();
    $(document).find("#add").hide();
    $(document).find("#add").on("click", function(e) {
        if($(document).find('#block_3').is(":visible")==true){
            alert("Only 3 services are allowed" );
        }
        for(var m=1;m<=3;m++){
            if ($(document).find('#block_'+m).is(":visible")==false) {
                $(document).find("#block_"+m).show();
                $('#AppointmentSalonServiceId'+m).attr('required', 'required');
                $('#AppointmentSalonServiceId'+m).attr('ValidationMessage', 'Please select treament.');
                $('#AppointmentSalonStaffId'+m).attr('required', 'required');
                $('#AppointmentSalonStaffId'+m).attr('ValidationMessage', 'Please select provider.');
                break;
            }
        }
    }); 
    
    $(document).on('change','.search_treatment',function(event){
        $(document).find("#add").show();
        id=event.target.id;
        var uid = $('#'+id).attr("data-attr");
        service_id=this.value;
        onMultiServiceChange(service_id,uid);
    });
    
    $(document).on('click','.removeLink',function(event){
        remid=event.target.id;
        $('#AppointmentSalonServiceId'+remid).removeAttr('required');
        $('#AppointmentSalonServiceId'+remid).removeAttr('ValidationMessage');
        $('#AppointmentSalonStaffId'+remid).removeAttr('required');
        $('#AppointmentSalonStaffId'+remid).removeAttr('ValidationMessage');
        $('#block_'+remid).hide();
    });
});
</script>
<style>
    .modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
</style>