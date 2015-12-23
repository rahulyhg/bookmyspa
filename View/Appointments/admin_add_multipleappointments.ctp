<div class="modal-dialog modal-lg vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Multiple Appointment
            </h3>
        </div>
        <div class="modal-body">
            <div class="clearfix">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
                            <?php echo $this->Form->create('Appointment',array('novalidate','id'=>'AddMultiForm','type' => 'file')); ?>
                            <?php echo $this->Form->hidden('Appointment.id',array('div'=>false,'label'=>false));?>
                            <?php echo $this->Form->hidden('Appointment.starttime',array('div'=>false,'label'=>false,'value'=>$time));?>
                            <?php echo $this->Form->input('Appointment.salon_staff_id',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$employeeId)); ?>
                            <div class="MailBlock">
                                <div id="block_1" class="block">
                                    <div class="clearfix">
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <div id="remove_1" class="removeLink" data-removeId="1"><i class="icon-trash"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"><b>Treatments*:</b></label>
                                                    <?php echo $this->Form->select('Appointment.salon_service_id_1',$staffServices,array('empty'=>'Please Select', 'class'=>'form-control multi_treatment','id'=>'AppointmentSalonServiceId_1','data-attr'=>'1','data-user-id'=>$employeeId,'required','ValidationMessage'=>'Please enter treatment.')); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div id="clone-ser">
                                                    <div class="form-group">
                                                        <label class="control-label"><b>Service Provider*:</b></label>
                                                        <?php echo $this->Form->select('Appointment.salon_staff_id_1',$staff_list,array('empty'=>'Please Select', 'class'=>'form-control','id'=>'AppointmentSalonStaffId_1','required','ValidationMessage'=>'Please enter service provider.')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-10">
                                            <div id="clone-pro">
                                                <div class="form-group clearfix">
                                                    <div id="p_dur">
                                                        <?php echo $this->element('admin/Appointment/appointment_multipricingoptions'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer pdng20">
                                <div id="add" value="1" class="btn  pull-left mrgn-btm10"><i class="icon-plus"></i> Add New Treatment</div>
                                <?php echo $this->Form->button('Next',array('type'=>'submit','class'=>'btn btn-primary submitMultiAppointment','label'=>false,'div'=>false));?>
                                <?php echo $this->Form->button( 'Cancel',array(
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
</div>
<script>
$(document).ready(function(){
    $(document).find("#add").hide();
    $(document).find(".removeLink").hide();
    $(document).find("#add").on("click", function(e) {
        var j=$(document).find('.block').size();
        if (j>=5) {
            alert("Only 5 services are allowed" );
            return false;
        }
        var i = $(document).find('.block').size() + 1;
        for(var m=1;m<=5;m++){
            if ($(document).find('#block_'+m).length<1) {
                i=m;
                break;
            }
        }
        $('<div class="block" id="block_'+i+'"'+'><hr><div class="clearfix"><div class="col-sm-1"><div class="form-group"><div  class="removeLink" ><i class="icon-trash" id="remove_'+i+'"'+' data-removeId="'+i+'"'+'></i></div></div></div><div class="col-sm-10"><div class="col-sm-6"><div id="clone-pro"><div class="form-group"><label class="control-label"><b>Treatments*:</b></label><div class="treatment"></div></div></div></div><div class="col-sm-6"><div id="clone-ser"><div class="form-group"><label class="control-label"><b>Service Provider*:</b></label><div class="ser_prov"></div></div></div></div></div></div><div class="clearfix"><div class="col-sm-1"></div><div class="col-sm-10"><div id="clone-pro"><div class="form-group clearfix"><div id="p_dur"><div class="price"></div></div></div></div></div></div>').appendTo(".MailBlock:last");
        var CloneSalonService=$('#AppointmentSalonServiceId_1').clone().attr('id', 'AppointmentSalonServiceId_' + i).appendTo('.treatment:last');
        CloneSalonService.attr({ 'data-attr': i,'name':'data[Appointment][salon_service_id_'+i+']' });
        var CloneSalonStaff=$('#AppointmentSalonStaffId_1').clone().attr('id', 'AppointmentSalonStaffId_' + i).appendTo('.ser_prov:last');
        CloneSalonStaff.attr({ 'data-attr': i,'name':'data[Appointment][salon_staff_id_'+i+']' });
        
        $("<div id='PriceDurationId_"+i+"'"+"><div id='PriceDurationBlock' class='col-sm-6 clearfix'><div class='form-group col-sm-6 lft-p-non col-xs-6'><label class='control-label'>Price*:</label><input type='text' id='AppointmentPrice"+i+"'"+ "pattern='^[1-9]\d*(\.\d+)?$' onkeypress='return validateFloatKeyPress(this,event);' maxlength='8' validationmessage='Please enter price.' required='required' class='form-control remove' name='data[Appointment][price_1]'></div><div class='form-group col-sm-6 col-xs-6 rgt-p-non'><label class='control-label'>Dur<dfn>(mins)</dfn>*:</label><input type='text' id='AppointmentDuration"+i+"'"+ " maxlength='3' validationmessage='Please enter duration.' required='required' class='form-control numOnly' name='data[Appointment][duration_1]'></div></div></div>").appendTo(".price:last");
    }); 
    
    $(document).on('change','.multi_treatment',function(event){
        $(document).find("#add").show();
        id=event.target.id;
        var uid = $('#'+id).attr("data-attr");
        service_id=this.value;
        onMultiServiceChange(service_id,uid);
    });
    
    $(document).on('click','.removeLink',function(event){
        remid=event.target.id;
        removeid=$('#'+remid).attr("data-removeid");
        $('#block_'+removeid).remove();
    });
});
</script>
<style>
    .modal-body {
        max-height: 600px;
        overflow-y: auto;
    }
    .removeLink{
        cursor: pointer;
    }
</style>
     
     
        