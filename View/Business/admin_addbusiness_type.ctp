<div class="modal-dialog vendor-setting overwrite sm-vendor-setting">
    <div class="modal-content">        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
            <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Business Type</h3>
        </div>
          <?php echo $this->Form->create('BusinessType',array('novalidate','class'=>'form-horizontal'));?>
    <div class="modal-body">
    <div class="box">        
        <div class="box-content">
                  
                    <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="form-group">
                                <label class="control-label col-sm-5">	    
                                </label>
                                <div class="col-sm-8">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-4">Name*:</label>
                                <div class="col-sm-8">
                                    <?php 
                                      $patern = "^[A-Za-z.'\-\s]+$";
                                    echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required','minlength'=>'3','pattern'=>$patern,'required','validationMessage'=>"Name is required.",'data-pattern-msg'=>"Please enter only alphabets and ( . , ' and - ).",'data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'maxlength'=>105)); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Description*:</label>
                                <div class="col-sm-8">
                                    <?php echo $this->Form->input('eng_description',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','required','validationMessage'=>"Description is required.",'data-minlength-msg'=>"Minimum 20 characters.",'maxlengthcustom'=>'500','data-maxlengthcustom-msg'=>"Maximum 500 characters are allowed.",'maxlength'=>500,'minlength'=>'20')); ?>
                                </div>
                            </div>                        
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="form-group">
                                <label class="control-label col-sm-5">	    
                                </label>
                                <div class="col-sm-8">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Name</label>
                                <div class="col-sm-8">
                                    <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','pattern'=>$patern,'validationMessage'=>"Name is required.",'data-pattern-msg'=>"Please enter only alphabets and ( . , ' and - ).",'data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'maxlength'=>105)); ?>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-sm-4">Description</label>
                                <div class="col-sm-8">
                                    <?php echo $this->Form->input('ara_description',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','validationMessage'=>"Description is required.",'data-minlength-msg'=>"Minimum 20 characters.",'maxlengthcustom'=>'500','data-maxlengthcustom-msg'=>"Maximum 500 characters are allowed.",'maxlength'=>500,'minlength'=>'20')); ?>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Status*:</label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'InActive'),'empty'=>' -- Please Select  -- ','label'=>false,'div'=>false,'class'=>'form-control','validationMessage'=>"Please select status.",'required')); ?>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
         <div class="modal-footer pdng20">
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitBType','label'=>false,'div'=>false));?>                            
            <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                        'type'=>'button','label'=>false,'div'=>false,
                        'class'=>'btn closeModal')); ?>
            </div> 
        <?php echo $this->Form->end(); ?>
    </div>
</div>