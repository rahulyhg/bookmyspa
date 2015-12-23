<?php
//echo $this->Html->script('checkout/checkout'); 
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min');
?>
<div class="modal-dialog vendor_setting addUserModal">
    <div class="modal-content">
	<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
				Edit Services
            </h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
                            <?php echo $this->Form->create('Appointment',array('novalidate','type' => 'file','id'=>'edit_service_form')); ?>
                            <div class="row">
								<div class="col-sm-8">
									<h5><b>Select Service</b></h5>
									<div class="form-group">
										<?php echo $this->Form->input('service_id',array('div'=>false,'options' =>$staffServices,'empty'=>'Select Service','label'=>false,'class'=>'select2-me userSelect nopadding form-control bod-non payeeUser','required','validationMessage'=>'Please Select Service'));?>            
									</div>
								</div>
							</div>
                                <div class="modal-footer pdng20">
                                    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitEditService', 'provider_id' => $provider_id, 'salon_service_id'=>$salon_service_id,'appointment_id'=>$appointment_id,'user_id'=>$user_id,'label'=>false,'div'=>false));?>
				    <?php echo $this->Form->button('Cancel',array('type'=>'button',
										  'label'=>false,
										  'div'=>false,
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
	$("#AppointmentServiceId").select2();
</script>

<style>
      .ui-icon {
    background-repeat: no-repeat;
    display: block;
    overflow: hidden;
    text-indent: 0;
}
</style>
<script>
   
</script>