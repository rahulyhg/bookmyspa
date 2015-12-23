<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <?php echo $this->Form->create('ProductType',array('novalidate'));?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
            <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Product Types</h3>
        </div>
        <div class="modal-body clearfix ServicePopForm">
            <div class="row">
            <div class="col-sm-12">
            <div class="box">
              <div class="box-content">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                    <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                </ul>
                <div class="tab-content pdng-btm-non padding tab-content-inline tab-content-bottom ">
                    <div class="tab-pane active" id="tab1">
                        <div class="form-group clearfix mrgn-btm0">
                            <label class="control-label col-sm-3" >Name *:</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','required','validationMessage'=>"English product type name is required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 100 characters.")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-3" >Name:</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'100','data-minlength-msg'=>"Minimum 3 characters.",'data-maxlength-msg'=>"Maximum 100 characters.")); ?>
                            </div>
                        </div>
                    </div>    
                </div>
              <!--  <div class="clearfix pdng20 pdng-tp-non pdng-btm-non">
                <div class="form-group">
                    <label class="control-label  col-sm-3">Status *:</label>
                    <div class="controls  col-sm-9">
                        <?php //echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'InActive'),'empty'=>'Please Select','label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>"Please select status.")); ?>
                    </div>
                </div>
                </div>-->
               </div>   
            </div>
            </div>
            </div>
            </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-12 ">
                <div class="col-sm-3 pull-right">
                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal','type'=>'button','label'=>false,'div'=>false,'class'=>'btn closeModal full-w')); ?>
                </div>
                <div class="col-sm-3 pull-right">
                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary full-w update','label'=>false,'div'=>false));?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>