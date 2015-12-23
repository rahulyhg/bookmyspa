<?php //echo $startdate; die; ?>
<div class="modal-dialog modal-lg vendor_setting addUserModal">
      <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <h3 id="myModalLabel"><i class="icon-edit"></i>
                        <?php echo "Confirm Appointment";  ?>
                  </h3>
            </div>
            <div class="modal-body">
                  <div class="row">
                        <div class="col-sm-12">
                              <div class="box">
                                    <div class="box-content">
                                          <?php echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
					  <?php echo $this->Form->hidden('Appointment.id',array('div'=>false,'label'=>false,'value'=>$appId));?>
				          <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label class="control-label"><b><p>Date -</p></b></label>
							<?php echo $serarray['data']['Appointment']['startdate']; ?>
						    </div>
						    <div class="form-group">
                                                           <?php echo $this->Form->input('Appointment.confirm',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>'confirm')); ?>
                                                    </div>
						    <div class="form-group">
                                                        <label class="control-label"><b><p>Service -</p></b></label>
							<?php echo $serviceName; ?>
						    </div>
						    <div class="form-group">
                                                           <?php echo $this->Form->input('Appointment.salon_service_id',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$serarray['data']['Appointment']['salon_service_id'])); ?>
                                                    </div>
						</div>
						<div class="col-sm-4">
                                                    <?php $Sdate=strtotime($serarray['data']['Appointment']['startdate'].' '.$time);
						      echo $this->Form->input('Appointment.appointment_start_date',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$startdate)); ?>
						      <div class="form-group">
                                                            <label class="control-label"><b><p>Provider:</b></p></label>
                                                            <?php echo $serviceProviderName; ?>
                                                      </div>
						      <?php echo $this->Form->input('Appointment.salon_staff_id',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$serarray['data']['Appointment']['salon_staff_id'])); ?>
						      <div class="form-group">
                                                            <label class="control-label"><b><p>Price:</b></p></label>
                                                            <?php  echo $price['Appointment']['appointment_price']; ?>
                                                      </div>
						</div>
						<div class="col-sm-3">
                                                      <div class="form-group">
                                                            <label class="control-label"><b><p>Time -</b></p></label>
							 <?php
							    echo $time=str_replace("-",":",$time);
							    ?>
                                                      </div>
						</div>
			      <div class="row">
                        <div class="col-sm-12">
                              <div class="form-group">
                                    <label class="control-label"><b><p>Comment:</p></b></label>
				    <?php echo $this->Form->input('appointment_comment',array('class'=>'form-control','id'=>'durationExample','div'=>false,'label'=>false,'type'=>'textarea','value'=>''));?>
			      </div>
			</div>
		  </div>
		  <div class="modal-footer pdng20">
                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitforwardAppointment','label'=>false,'div'=>false));?>
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
      </div>
</div>
