<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');
$timestamp = $time;
$startdate=gmdate("d/m/Y", $timestamp);
$starttime=gmdate("h:ia", $timestamp);
?>
<script>
	var startdate='<?php echo $startdate; ?>';
	var starttime='<?php echo $starttime; ?>';
	var st='<?php echo date('h:i A',$open_close_hours[0]); ?>';
	var en='<?php echo date('h:i A',$open_close_hours[1]); ?>';
	$(function() {
	    $('#AppointmentStartdate').datepicker({
	        dateFormat: "dd/mm/yy",
	        minDate: new Date(),
	        onClose: function(dateText, inst) {
	            $('#AppointmentAppointmentRepeatEndDate').blur();
	        }               
		});
		$('#AppointmentTime').timepicker({
					'minTime':st,
					'maxTime':en,
					'showDuration':false,
					'timeFormat': 'h:iA'
		});
		$('#AppointmentTime').timepicker('setTime', starttime);
		$('.theDatePick').datepicker({
		        dateFormat: "dd/mm/yy",
		        minDate: startdate,
		        onClose: function(dateText, inst) {
		            $('#AppointmentAppointmentRepeatEndDate').blur();
            }               
		});
    });
</script>
<?php if($editType=='series'){ ?>
        <script>
			$("#AppointmentStartdate").datepicker().datepicker('disable');
        </script>
<?php } ?>
<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Multiple Appointment
            </h3>
        </div>
        <div class="modal-body">
			<div class="row">
				<div class="col-sm-12">
                    <div class="form-group">
						<div id="multiple_services"  data-removeId="1" class="btn  pull-left multiple"><i class="icon-plus"></i> Add Multiple Services</div>
					</div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
                            <?php echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
                                <?php echo $this->Form->hidden('Appointment.id',array('div'=>false,'label'=>false));?>
                                <div class="row">
                                    <div class="col-sm-3">
										<div class="form-group">
											<label class="control-label">Date*:</label>
											<?php echo $this->Form->input('startdate',array('class'=>'form-control theDatePick','div'=>false,'label'=>false,'value'=>$startdate,'required','ValidationMessage'=>'Please enter startdate.'));?>
                                            <?php echo $this->Form->input('startdateHid',array('class'=>'form-control theDatePick','type'=>'hidden','div'=>false,'label'=>false,'value'=>$startdate,'required','ValidationMessage'=>'Please enter startdate.'));?>      
                                        </div>
										<div class="form-group">
											<label class="control-label">Time*:</label>
											<?php echo $this->Form->input('time',array('class'=>'form-control','div'=>false,'label'=>false,'required','ValidationMessage'=>'Please enter start time.'));?>
										</div>
										<div class="form-group clearfix">
											<div id='PriceDurationBlock col-sm-12 nopadding'>
												<div class='form-group col-sm-5 rgt-p-non'>
													<label class='control-label'>Price*:</label>
													<?php echo $this->Form->input('price',array('class'=>'form-control remove','div'=>false,'value'=>$total_price,'label'=>false,'required','ValidationMessage'=>'Please enter price.','disabled'=>'disabled','maxlength'=>'8','onkeypress'=>'return validateFloatKeyPress(this,event);','pattern'=>'^[1-9]\d*(\.\d+)?$')); ?>
												</div>
												<div class='form-group col-sm-5 rgt-p-non'>
													<label class='control-label'>Duration<dfn>(mins)</dfn>*:</label>
													<?php echo $this->Form->input('duration',array('class'=>'form-control numOnly','div'=>false,'value'=>$total_duration,'label'=>false,'disabled'=>'disabled','required','ValidationMessage'=>'Please enter duration.','maxlength'=>'3')); ?>
												</div>
											</div>
										</div>
										<?php if($calendorsettings['SalonCalendarSetting']['retention']==1 && $calendorsettings['SalonCalendarSetting']['display_badges']==2) { ?>
                                            <div class="form-group">
                                                <label class="control-label">Appointment Type</label>
                                                <?php echo $this->Form->input('Appointment.appointment_return_request',array('options' => array('NR'=>'NR', 'NNR'=>'NNR', 'RR'=> 'RR','RNR'=>'RNR'),'label'=>false,'required','ValidationMessage'=>'Appointment type is required.','empty'=>'select','div'=>array('class'=>'col-sm-12 pdng0'),'class'=>'form-control'),array('div'=>false,'class'=>'',!empty($this->request->data['Appointment']['appointment_return_request'])?"selected": '')); ?>
											</div>
                                        <?php } ?>
                                    </div>
									<div class="col-sm-5 pdng0">
										<div class="form-group">
										    <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['appointment_comment']!=''){
									        $comments=$edit_appointment['Appointment']['appointment_comment'];
									    }else{
									        $comments='';
									    } ?>
									    <label class="control-label">Appointment Comment:</label>
									    <?php echo $this->Form->input('appointment_comment',array('class'=>'form-control','id'=>'durationExample','div'=>false,'label'=>false,'type'=>'textarea','value'=>$comments));?>
										</div>
										<?php if(isset($edit_appointment) && isset($editType) && $editType=='series'){   ?>
										    <div class="form-group">
										        <?php echo $this->element('admin/Appointment/appointment_repeat'); ?>
										    </div>
										<?php } elseif(isset($editType) && $editType=='' && isset($edit_appointment) && $edit_appointment['Appointment']['appointment_repeat_type']!=0){ ?>
											<div class="form-group">
											<?php echo $this->element('admin/Appointment/appointment_repeat'); ?>
												</div>
										<?php } elseif(!isset($edit_appointment)){ ?>
											<div class="form-group">
												<?php echo $this->element('admin/Appointment/appointment_repeat'); ?>
											</div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?php echo $this->element('admin/Appointment/appointment_customer_detail'); ?>
                                    </div>
									</div>
                                    <div class="modal-footer pdng20">
			                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary saveMultipleAppointment','label'=>false,'div'=>false));?>
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
      
      $(document).on('click','.multiple',function(event){
		$('#commonSmallModal').modal('hide');
	});
      
      $(document).find("#AppointmentUserId").select2().on("change", function(e) {
            onSelectChange(e.val);
      });
      $(document).find("#AppointmentSalonServiceId").on("change", function() {
            service_id=this.value;
            onServiceChange(service_id);
      });
      $("#AppointmentStartdate").keypress(function (e){
            e.preventDefault();
      });
      $("#AppointmentTime").keypress(function (e){
            e.preventDefault();
      });
      $("#AppointmentAppointmentRepeatEndDate").keypress(function (e){
            e.preventDefault();
      });
      $('.remove').keypress(function(event) {
            if(event.which == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46){
                  return true;
            }else if((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)){
                  event.preventDefault();
            }
      });
      $('#selectAppointmentUserId').select2()
            .on("open", function(e) {
                  $(document).find('.select2-drop-active').addClass('purple-bod');
                  $(document).find('a.select2-choice').addClass('purple-bod');
            }).on('close', function(){
                  $(document).find('.select2-drop-active').removeClass('purple-bod');
                  $(document).find('#s2id_selectUserId').removeClass('purple-bod');
                  $(document).find('.select2-choice').removeClass('purple-bod');
      });
      /*$('#AppointmentSalonServiceId').on('focus', function() {
           $(this).closest('select').addClass('purple-bod');
      }).on('blur change', function() {
       $(this).closest('select').removeClass('purple-bod');
      });*/
});
function add_validation(val){
      $('.remove').removeAttr('required');
      $('.remove').removeAttr('validationmessage');
      $('#AppointmentPrice'+val).attr('required', 'required');
      $('#AppointmentPrice'+val).attr('validationmessage', 'Please enter price');
      $('#AppointmentDuration'+val).attr('required', 'required');
      $('#AppointmentDuration'+val).attr('validationmessage', 'Please enter price');
}
</script>