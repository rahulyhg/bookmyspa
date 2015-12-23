<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');

$timestamp = $appointment['Appointment']['appointment_start_date'];
$startdate=gmdate("d/m/Y", $timestamp);
$starttime=gmdate("h:ia", $timestamp);
?>

<script>
var startdate='<?php echo $startdate; ?>';
var starttime='<?php echo $starttime; ?>';
$(function() {
    $('#AppointmentTime').timepicker();
    $('#AppointmentTime').timepicker('setTime', starttime,
        'minTime', '2:00pm',
        'maxTime', '11:30pm',
        'showDuration', false
    );
    $('.theDatePick').datepicker({
            dateFormat: "dd/mm/yy",
            onClose: function(dateText, inst) {
                  $('#AppointmentAppointmentRepeatEndDate').blur();
            }               
      });
    });
</script>
<div class="modal-dialog vendor_setting addUserModal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3 id="myModalLabel"><i class="icon-edit"></i>
                    <?php echo  "Cancel Appointment"; ?>
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
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Customer:</label>
                                                    <?php echo $appointment['User']['first_name'].' '.$appointment['User']['last_name']; ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Date:</label>
                                                <?php echo date('d/m/Y',strtotime($appointment['Appointment']['appointment_start_date'])); ?>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Price:</label>
                                                <?php echo $appointment['Appointment']['appointment_price']; ?>
                                            </div>
					    <div class="form-group">
                                                <label class="control-label">Service:</label>
                                                <?php echo $appointment['SalonService']['eng_name']; ?>
                                            </div>
					    
                                        </div>
					<div class="col-sm-6">
					    <div class="form-group">
						<label class="control-label">Provider:</label>
						<?php echo $appointment['User']['first_name'].' '.$appointment['User']['last_name']; ?>
					    </div>
				            <div class="form-group">
						<label class="control-label">Time:</label>
						<?php echo date('H:i A',strtotime($appointment['Appointment']['appointment_start_date'])); ?>
					    </div>
                                        </div>
                                        
                                    </div>
				    <div class="row">
                                        <div class="col-sm-12">
					    <div class="form-group">
						<label class="control-label">Comment:</label>
						<?php echo $this->Form->input('appointment_comment',array('class'=>'form-control','id'=>'durationExample','div'=>false,'label'=>false,'type'=>'textarea'));?>
					    </div>
					    <div class="form-group">
						<label class="control-label">Message to customer:</label>
						<?php echo $this->Form->input('appointment_comment',array('class'=>'form-control','id'=>'durationExample','div'=>false,'label'=>false,'type'=>'textarea'));?>
					    </div>
					</div>
				    </div>
				    <div class="modal-footer pdng20">
					    <?php echo $this->Form->button('Notify Customer',array('type'=>'submit','class'=>'btn btn-primary submitAppointment','label'=>false,'div'=>false));?>
					    <?php echo $this->Form->button('Dont Notify Customer',array(
                                                                    'type'=>'button',
                                                                    'label'=>false,'div'=>false,
                                                                    'data-dismiss'=>'modal',
                                                                    'class'=>'btn')); ?>
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
