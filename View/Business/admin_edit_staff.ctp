<style>
    .form-horizontal .control-label {
        text-align: right;
    }
</style> 
<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
           <?php echo (isset($this->data) && !empty($this->data)) ? 'Edit' : "Add"; ?> Staff 
            </h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                  <?php echo $this->Form->create('User', array('novalidate', 'class' => 'form-horizontal')); ?>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="input01">First Name : </label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->input('first_name', array('label' => false, 'div' => false, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" >Last Name *:</label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->input('last_name', array('type'=>'text','div'=>false,'label' => false,  'class' => 'form-control')); ?>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label col-sm-2" >Login Email *:</label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->input('email', array('type'=>'text','div'=>false,'label' => false,  'class' => 'form-control')); ?>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label for="additionalfield" class="col-sm-2 control-label"><?php echo 'Employee Type'; ?> *:</label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->input('UserDetail.employee_type', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_employee_type(), 'empty' => 'Select employee type')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="additionalfield" class="col-sm-2 control-label"><?php echo __('Access Level', true); ?> *:</label>
                        <div class="col-sm-6">
                            <?php echo $this->Form->input('group_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_employee_access_level(), 'empty' => 'Select employee Access Level')); ?>
                        </div>
                    </div>
                     <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
                     <?php echo $this->Form->input('UserDetail.id', array('type' => 'hidden')); ?>

                    <div class="form-actions text-center">
                        <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary update_staff', 'label' => false, 'div' => false)); ?>
                        <?php
                        echo $this->Form->button('Cancel', array('data-dismiss' => 'modal',
                            'type' => 'button', 'label' => false, 'div' => false,
                            'class' => 'btn',
                        ));
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>        