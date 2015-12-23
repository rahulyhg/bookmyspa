<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    }
</style> 
<div class="modal-dialog vendor-setting addUserModal sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                <?php echo (isset($this->data) && !empty($this->data)) ? 'Edit' : "Add"; ?> Blog Category</h3>
        </div>
          <?php echo $this->Form->create('BlogCategory', array('novalidate' , 'class'=>'form-horizontal')); ?>
        <div class="modal-body">
            <div class="box">
                <div class="box-content nopadding">
                    <div class="tab-content">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                            <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                        </ul>
                        <div class="tab-pane active" id="tab1">
                            <div class="form-group clearfix" style="margin-top: 10px;">
                                <label class="col-sm-4 control-label" >Category Name*:</label>
                                <div class="col-sm-8">
                                    <?php echo $this->Form->input('eng_name', array('label' => false, 'div' => false, 'class' => 'form-control', 'maxlength'=>'100','validationMessage'=>'Category name is required.','maxlength'=>100,'data-minlength-msg'=>"Minimum 3 characters.",'minlength'=>'3','required')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="form-group" style="margin-top: 10px;">
                                <label class="col-sm-4 control-label" >Category Name:</label>
                                <div class="col-sm-8">
                                    <?php echo $this->Form->input('ara_name', array('label' => false, 'div' => false, 'class' => 'form-control','maxlength'=>'100')); ?>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="input01">Status*:</label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->input('status', array('options' => array('1' => 'Active', '0' => 'InActive'), 'empty' => ' -- Please Select  -- ', 'label' => false, 'div' => false, 'class' => 'form-control','required','validationMessage'=>'Status is required.')); ?>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="modal-footer pdng20">
                        <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary update', 'label' => false, 'div' => false)); ?>
                        <?php
                        echo $this->Form->button('Cancel', array('data-dismiss' => 'modal',
                            'type' => 'button', 'label' => false, 'div' => false,
                            'class' => 'btn closeModal'))
                        ?>
                </div>
          <?php echo $this->Form->end(); ?>         
    </div> 
</div>

