<style>
    .form-horizontal .col-sm-2.control-label {
        text-align: right;
    }
</style>  
<div class="modal-dialog vendor-setting addUserModal sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Access Level</h3>
        </div>
        <?php echo $this->Form->create('Group',array('novalidate','class'=>'form-horizontal'));?>
        <div class="modal-body">
            <div class="box">
                <div class="box-content"> 
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            
                            <div class="form-group">
                                <label class="control-label col-sm-4">	    
                                    Name *:
                                </label>
                                <div class="col-sm-8">
                                                <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
                                                <?php echo $this->Form->input('name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">	    
                                    Description:
                                </label>
                                <div class="col-sm-8">
                                                <?php echo $this->Form->input('description',array('cols'=>'25', 'rows'=>'4', 'label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
                        <div class="form-actions">
                           <?php
                                                  echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update ','label'=>false,'div'=>false));?>
                                            <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                                    'type'=>'button','label'=>false,'div'=>false,
                                                    'class'=>'btn',
                                                    )); ?>
                        </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>