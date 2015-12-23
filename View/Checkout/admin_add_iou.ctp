<?php echo $this->Html->script('checkout/checkout'); ?>
<?php  //pr($postData); exit; ?>
<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
		<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
				Add IOU
            </h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
                            <?php echo $this->Form->create('Iou',array('novalidate','type' => 'file','id'=>'addIouForm')); ?>
                                    <div class="row">
										<div class="col-sm-12">
                                             <h5><center>Remaining Amount is <?php //echo 'AED '.$postData['data']['cart']['change_due']; ?>.</br>Would you like to add an IOU?
    IOU = Customer Owes Business


    IOU will automatically be added to client's next checkout or they can be paid anytime by going to the IOU page under "Reports".

    Note: Commission employees' payroll includes all services and products paid by IOU</center></h5>
										
										</div>
										<div class="col-sm-12">
                                            <div class="form-group">
                                                 <label class="control-label">Comment</label>
                                                    <?php echo $this->Form->textarea('Iou.iou_comment',array('label'=>false,'class'=>'form-control','rows'=> 3,'required','ValidationMessage'=>'Please Enter Comment.','div'=>false)); ?>
                                                            
											</div>
                                        </div>
										
                                      
									</div>
                                        <div class="modal-footer pdng20">
                                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitIou','label'=>false,'div'=>false));?>
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


<style>
      .ui-icon {
    background-repeat: no-repeat;
    display: block;
    overflow: hidden;
    text-indent: 0;
}
</style>