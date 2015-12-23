<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min');
?>
<div class="modal-dialog vendor_setting addUserModal">
    <div class="modal-content">
	<div class="modal-header">
            <button type="button" class="close group" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
		Select Group Customers
            </h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
                            <?php echo $this->Form->create('User',array('novalidate','type' => 'file','id'=>'grpCusForm')); ?>
                                <div class="row">
				    <div class="col-sm-6">
					<h5><b>Select Customers </b></h5>
					<div class="subnav cal-left clearfix">
					    <ul class="subnav-menu employeeCheck">
						<?php foreach($userList as $key => $user) { ?>
							<li class="col-sm-12" >
							    <span>
								<?php
								    $userId = $key;								       echo $this->Form->input('user.' .$userId,array('value' => $userId,'div'=>false,'class'=>'service_prov','data-text'=>$user,'label'=>array('class'=>'new-chk ','text'=>$user), 'name' => 'grp_user_id','id'=>rand()."_user", 'type' => 'checkbox')); ?>
							    </span>
							</li>
						<?php } ?>
					    </ul>
					</div>
				    </div>
				    <div class="col-sm-6">
                                        <h5><b>Who will pay?</b></h5>
					<div class="form-group">
                                            <?php echo $this->Form->input('user_id',array('div'=>false,'options'=>'','empty'=>'Select Payee','label'=>false,'class'=>'select2-me userSelect nopadding form-control bod-non payeeUser','required','validationMessage'=>'Please Select Customer'));?>            
					</div>
                                    </div>
				</div>
                                <div class="modal-footer pdng20">
                                    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary grpcus','label'=>false,'div'=>false));?>
				    <?php echo $this->Form->button('Cancel',array('type'=>'button',
										  'label'=>false,
										  'div'=>false,
										  'data-dismiss'=>'modal',
										  'class'=>'btn group')); ?>
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
	$("#UserUserId").select2();
</script>

<style>
      .ui-icon {
    background-repeat: no-repeat;
    display: block;
    overflow: hidden;
    text-indent: 0;
}
.subnav.cal-left.clearfix{padding: 16px 0; border: 1px solid #ddd;}
#grpCusForm .modal-footer{margin-top: 15px;}
</style>
<script>
   
</script>