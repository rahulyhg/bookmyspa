<div class="modal-dialog vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?>Gift Certificate Image Category</h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                <?php echo $this->Form->create('GiftImageCategory',array('novalidate','class'=>'form-horizontal'));?>
                
                    <ul id='myTabnew' class="nav nav-tabs col-sm-12">
                        <li class="active"><a href="#tab3" data-toggle="tab">English</a></li>
                        <li><a href="#tab4" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab3">
                            <div class="form-group">
                                    <label class="control-label col-sm-3">	    
                                    </label>
                                    <div class="col-sm-8">                                                                    
                                    </div>
                            </div> 
                             <div class="form-group">
                                    <label class="control-label col-sm-3">	    
                                        English Name*:
                                    </label>
                                    <div class="col-sm-5">
                                    <?php                                               
                                        echo $this->Form->input('eng_title',array('label'=>false,'div'=>false,'class'=>'form-control','required', 'validationMessage'=>'Enter category title.')); 
                                    ?>                                    
                                    </div>
                                </div>
                        </div>
                        <div class="tab-pane" id="tab4">     
                            <div class="form-group">
                                    <label class="control-label col-sm-3">	    
                                    </label>
                                    <div class="col-sm-5">                                                                    
                                    </div>
                            </div> 
                            <div class="form-group">
                                    <label class="control-label col-sm-3">	    
                                        Arabic Name:
                                    </label>
                                    <div class="col-sm-5">
                                        <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                    </div>
                                </div>                               
                        </div>
                    </div>                                
                        <div class="col-sm-3">
                            <div class="form-actions">
                                &nbsp;&nbsp;
                        </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-actions">
                                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary updateCat','label'=>false,'div'=>false));?>

                               <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn closeModal')); ?>
                        </div>
                    </div>
                     <?php echo $this->Form->end(); ?>
                </div>   
            </div>
        </div>
    </div>
</div>