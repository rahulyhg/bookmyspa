<?php
$timestamp = $time;
$startdate = gmdate("d/m/Y", $timestamp);
$starttime = gmdate("h:ia", $timestamp);
?>
<script>
    var startdate='<?php echo $startdate; ?>';
    var starttime='<?php echo $starttime; ?>';
    var st='12:00 AM'; var en='12:00 AM';
    $(function() {
        $('#AppointmentTime').timepicker({
			'minTime':st,
			'maxTime':en,
			'showDuration':false,
			'timeFormat': 'h:iA'
		});
        $('#AppointmentTime').timepicker('setTime', starttime);
    });
</script>
<?php   echo $this->Html->script('checkout/checkout'); ?>
<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Appointment
            </h3>
        </div>
        <div class="modal-body">
            <div class="row">
				<div class="col-sm-12">
					<div class="box">
						<div class="box-content">
							<?php echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
							<?php echo $this->Form->hidden('Appointment.user_id',array('div'=>false,'label'=>false,'value'=>$userId));?>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label"><b>Service Provider*:</b></label>
											<?php echo $this->Form->select('Appointment.salon_staff_id',$staff_list,array('empty'=>'Please Select', 'class'=>'form-control','required','ValidationMessage'=>'Please enter service provider.')); ?>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label">Time*:</label>
										        <?php echo $this->Form->input('time',array('class'=>'form-control','div'=>false,'label'=>false,'required','ValidationMessage'=>'Please enter start time.'));?>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="control-label"><b>Treatments*:</b></label>
											<?php if(isset($edit_appointment) && $edit_appointment['Appointment']['salon_service_id']!=''){
												$selected=$edit_appointment['Appointment']['salon_service_id'];
										        }else{
										                $selected='';
										        } ?>
											<?php echo $this->Form->input('Appointment.salon_service_id',array('options'=>$staffServices,'label'=>false,'empty'=>'Please Select Treatment', 'class'=>'form-control','required','ValidationMessage'=>'Please select treatment.','div'=>false,'selected'=>$selected)); ?>
										</div>
										<div class="form-group clearfix">
										<?php echo $this->element('admin/Appointment/appointment_pricingoptions'); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer pdng20">
								<?php if(isset($edit_appointment['Appointment']['id']) && $edit_appointment['Appointment']['id']!=''){ ?>
                                        <?php echo $this->Form->button('Appointment History',array('type'=>'button','class'=>'btn btn-primary AppointmentHistory pull-left','label'=>false,'div'=>false,'value'=>$edit_appointment['Appointment']['id']));?>
								<?php } ?>
								<?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary saveAppointment','label'=>false,'div'=>false));?>
                                <?php echo $this->Form->button(
															'Cancel',array( 'type'=>'button',
                                                                            'label'=>false,
																			'div'=>false,
                                                                            'data-dismiss'=>'modal',
                                                                            'class'=>'btn')); ?>
							</div>
						<?php echo $this->Form->end();?>
	                                </div></div></div>
                                </div>
                        </div>
                  </div>
            </div>
      </div>
</div>

<script>
    function add_validation(val){
        $('.remove').removeAttr('required');
        $('.remove').removeAttr('validationmessage');
        $('#AppointmentPrice'+val).attr('required', 'required');
        $('#AppointmentPrice'+val).attr('validationmessage', 'Please enter price');
        $('#AppointmentDuration'+val).attr('required', 'required');
        $('#AppointmentDuration'+val).attr('validationmessage', 'Please enter price');
    }


    $("#AppointmentAdminAddAppointmentForm").on("submit",function(e){ 
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            success:function(data, textStatus, jqXHR)
            {
              var data1 = JSON.parse(data);
               if (data1.data == 'success') {

                    $('#commonSmallModal').modal('toggle');

                      var userId = $('#AppointmentUserId').select2("val"); 
                      var apptmentTime = $('#aptmntTime').val();
                      //onSelectChange(userId,apptmentTime);
		      location.reload();
               }

               return false;

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            }
        });
        e.preventDefault();     //STOP default action
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