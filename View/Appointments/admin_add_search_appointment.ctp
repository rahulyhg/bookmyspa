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
					  <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="control-label"><b><p>Date -</p></b></label>
							<?php echo $serarray['data']['Appointment']['startdate']; 
							echo $this->Form->hidden('Appointment.user_id',array('div'=>false,'label'=>false,'value'=>$user_id)); ?>
						    </div>
						</div>
					  </div>
					 <?php for($i=0;$i<=count($serviceName);$i++)  { $j=$i+1;?>
						 <?php if(isset($serviceName['name'][$i]) && $serviceName['name'][$i]!=''){ ?>
				          <div class="row">
                                                <div class="col-sm-12">
                                                    <!--<div class="form-group">
                                                        <label class="control-label"><b><p>Date -</p></b></label>
							<?php //echo $serarray['data']['Appointment']['startdate']; ?>
						    </div>-->
						    
                                                           <?php echo $this->Form->input('Appointment.confirm',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>'confirm')); ?>
                                                    
						    <div class="col-sm-5">
						      <div class="form-group">
						          <label class="control-label"><b><p>Service -</p></b></label>	
							    <?php echo $serviceName['name'][$i]; ?>
						      </div>
						    </div>
						   
						    
                                                           <?php echo $this->Form->input('Appointment.salon_service_id_'.$j,array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$serviceName['id'][$i])); ?>
                                                    
						
						
                                                    <?php $Sdate=strtotime($serarray['data']['Appointment']['startdate'].' '.$time);
						      echo $this->Form->input('Appointment.appointment_start_date',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$startdate)); ?>
						      <div class="col-sm-4">
						      <div class="form-group">
                                                            <label class="control-label"><b><p>Provider:</b></p></label>
                                                            <?php echo $serviceProviderName; ?>
                                                      </div>
						      <?php echo $this->Form->input('Appointment.salon_staff_id_'.$j,array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$user_id)); ?>
						     <!-- <div class="form-group">
                                                            <label class="control-label"><b><p>Price:</b></p></label>
                                                            <?php  //echo $price['Appointment']['appointment_price']; ?>
                                                      </div>-->
						</div>
						<div class="col-sm-3">
                                                      <div class="form-group">
                                                            <label class="control-label"><b><p>Time -</b></p></label>
							 <?php
							    echo $time=str_replace("-",":",$time);
							    ?>
                                                      </div>
						</div>
						<?php } }?>
			      <div class="row">
                        <div class="col-sm-12">
                              <div class="form-group">
                                    <label class="control-label"><b><p>Comment:</p></b></label>
				    <?php echo $this->Form->input('appointment_comment',array('class'=>'form-control','id'=>'durationExample','div'=>false,'label'=>false,'type'=>'textarea','value'=>''));?>
			      </div>
			</div>
		  </div>
		  <div class="modal-footer pdng20">
                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitsearchAppointment','label'=>false,'div'=>false));?>
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
