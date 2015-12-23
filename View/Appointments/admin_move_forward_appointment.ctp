<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');
$timestamp = $time;
$startdate=gmdate("d-m-Y", $timestamp); 
$starttime=gmdate("h:ia", $timestamp);
?>
<script>
      var startdate='<?php echo $startdate; ?>';
      var starttime='<?php echo $starttime; ?>';
      
      <?php if ($editType=='moveBwd') { ?>
            
      $(function() {
            //alert(startdate);
            str=startdate.split("-");
            //console.log(str[0]);
            str[1]=str[1]-1;
            $('.theDatePick').datepicker({
            dateFormat: "yy-mm-dd",
            minDate: new Date(),
            maxDate: new Date(str[2], str[1], str[0]),
            onClose: function(dateText, inst) {
                  $('#AppointmentStartdate').blur();
            }               
         });
      });
      <?php } else{?>
      
      $(function() {
          $('.theDatePick').datepicker({
            dateFormat: "yy-mm-dd",
            minDate:'<?php echo $startdate;?>',
            onClose: function(dateText, inst) {
                  $('#AppointmentStartdate').blur();
            }               
         });
      });
      <?php } ?>
      
      
</script>
<div class="modal-dialog modal-lg vendor-setting addUserModal">
      <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <h3 id="myModalLabel"><i class="icon-edit"></i>
                        
                        <?php if(isset($editType) && $editType=='moveBwd'){
                            echo "Move Backward An Appointment";  
                        } else{ ?>
                        <?php echo "Move Forward An Appointment"; } ?>
                  </h3>
            </div>
            <div class="modal-body">
                  <div class="row">
                        <div class="col-sm-12">
                              <div class="box">
                                    <div class="box-content">
                                          <?php echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
                                          <?php echo $this->Form->hidden('Appointment.id',array('div'=>false,'label'=>false,'value'=>$appointmentId));?>
                                          <div class="row">
                                                <div class="col-sm-4">
                                                      <div class="form-group">
                                                            <label class="control-label"><b><p>Customer</p></b></label>
                                                            <?php if(isset($user_id) && $user_id!=''){
                                                                        $selected=$user_id;
                                                                  }else{
                                                                        $selected='';
                                                                  } ?>
                                                            <?php echo $this->Form->input('Appointment.user_id',array('options'=>$userList,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control','required','ValidationMessage'=>'Please select treament.','div'=>false,'selected'=>$selected)); ?>
                                                      </div>
                                                      <div class="form-group">
                                                            <label class="control-label"><b><p>Service</p></b></label>
                                                            <?php if(isset($service_id) && $service_id!=''){ 
                                                                  $selected=$service_id;
                                                            }else{
                                                                  $selected='';
                                                            } ?>
                                                            <?php echo $this->Form->input('Appointment.salon_service_id',array('options'=>$staffServices,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control','id'=>'AppointmentSalonForwardServiceId','required','ValidationMessage'=>'Please select treament.','div'=>false,'selected'=>$selected)); ?>
                                                      </div>
                                                      <div class="form-group">
                                                           <?php echo $this->Form->input('Appointment.salon_staff_id',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$employeeId)); ?>
                                                      </div>
                                                </div>
                                                <div class="col-sm-4">
                                                      <div class="form-group">
                                                            <label class="control-label"><b><p>Service Provider</p></b></label>
                                                            <?php if(isset($employeeId) && $employeeId!=''){ 
                                                                  $selected=$employeeId;
                                                            }else{
                                                                  $selected='';
                                                            } ?>
                                                            <?php echo $this->Form->input('Appointment.salon_staff_id',array('options'=>$staff_list,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control','required','ValidationMessage'=>'Please select treament.','div'=>false,'selected'=>$selected)); ?>
                                                      </div>
                                                </div>
                                                <div class="col-sm-2">
                                                     <div class="form-group">
                                                            <label class="control-label"><b><p>Date*:</p></b></label>
                                                            <?php echo $this->Form->input('startdate',array('class'=>'form-control theDatePick','div'=>false,'label'=>false,'value'=>$startdate,'required','ValidationMessage'=>'Please enter startdate.'));?>
                                                      </div>
                                                </div>
                                                <div class="col-sm-2">
                                                      <div class="form-group">
                                                            <label class="control-label"></label>
                                                            <?php echo $this->Form->button('Search',array('type'=>'submit','class'=>'btn btn-primary searchTimeslots','label'=>false,'div'=>false));?>
                                                      </div>
                                                </div>
                                                <?php echo $this->Form->end();?>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <?php
                              echo $this->element('admin/Appointment/forward_appointment_timeslots'); 
			 ?>
                  </div>
            </div>
      </div>
