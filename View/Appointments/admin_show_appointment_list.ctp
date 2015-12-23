<div class="modal-dialog vendor-setting addUserModal">
      <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <h3 id="myModalLabel"><i class="icon-edit"></i>
                        <?php echo  "All Appointment(s) for".' '.date('M-d-Y',$date); ?>
                  </h3>
            </div>
            <div class="modal-body clearfix">
                  <div class="row">
                        <div class="col-sm-12">
                              <div class="box">
				    <?php  echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
                                    <div class="box-content">
					 
					  <table class="table table-hover table-nomargin  table-bordered">
						<thead>
						      <tr>
							    <th>
								  <?php echo $this->Form->input('Appointment.checkBox',array('div'=>array('class'=>'applist-chk clearfix pos-rel'),'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk control-label','text'=>''))); ?>
							    </th>
							    <th>Service</th>
							    <th>Service Provider</th>
							    <th>Time</th>
							    <th>Price</th>
							    <th align="center" style="text-align: center;">Status</th>
						      </tr>
						</thead>
						<tbody>
						    <?php if(!empty($appointments)){
						      //pr($appointments); die;
							    $i=1;
						            foreach($appointments as $appointment){ ?>
							      <?php  if($appointment['Appointment']['status']==0){
									$status='Awaiting Confirmation';
		  							  }
									  if($appointment['Appointment']['status']==4){
									$status='Paid';
		  							  }
									  
				    					 if($appointment['Appointment']['status']==1){
									      $status='Confirmed';
									 }
									if($appointment['Appointment']['status']==6){
									      $status='In Progress';
									}
									if($appointment['Appointment']['status']==7){
									      $status='Show';
									 }
									 if($appointment['Appointment']['status']==8){
									      $status='No Show';
									 }
	?>
							      <?php $time=date('H:i A',$appointment['Appointment']['appointment_start_date'])?>
						                  <tr data-id="<?php echo $appointment['Appointment']['id']; ?>" >
									<td><?php echo $this->Form->input('Appointment.id'.$i,array('div'=>array('class'=>'col-sm-1 setNewMarginC'),'class'=>'chk','value'=>$appointment['Appointment']['id'],'type'=>'checkbox','label'=>array('class'=>'new-chk control-label','text'=>''))); ?></td>
									<td><?php echo $appointment['SalonService']['eng_name']; ?></td>
									<td><?php echo $appointment['User']['first_name']; ?></td>
									<td><?php echo $time; ?></td>
									<td> <?php echo $appointment['Appointment']['appointment_price']; ?></td>
									<td><?php echo $status; ?></td>
								  </tr>    
						<?php $i++; } ?>
						 
						<?php } ?>
						
						
						</tbody>
					  </table>
					 
                                    </div>
				    <div class="modal-footer pdng20">
                                                                  
                              <?php echo $this->Form->button('Ok',array('type'=>'submit','class'=>'btn btn-primary submitShowAppointment','label'=>false,'div'=>false));?>
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
