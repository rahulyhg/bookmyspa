<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
        <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Sms Template
            </h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <div class="tabbable">
            <?php echo $this->Form->create('Smstemplate', array('url' => array('controller' => 'smstemplates', 'action' => 'addedit'),'id'=>'smsTemplateForm','novalidate','class'=>'form-horizontal'));              
                    echo $this->Form->hidden('Smstemplate.id',array('label'=>false,'div'=>false)); 
                ?>  
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group">
                                    <label class="control-label col-sm-5">	    
                                        Name*:
                                    </label>
                                    <div class="col-sm-8">
                                        <?php echo $this->Form->input('name',array('label' => false,'div' => false, 'placeholder' => 'Name','class' => 'form-control validate[required]','maxlength' => 55));?>
                                        <?php echo $this->Form->input('template_code',array('id'=>'template_code','type'=>'hidden','label' => false,'div' => false, 'placeholder' => 'Name','class' => 'form-control','maxlength' => 55));?>                                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">	    
                                        Dynamic Fields *:
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $fields = array('{FirstName}'=>'First Name','{LastName}'=>'Last Name','{Sms}'=>'Sms Address'); ?>               
                                        <?php echo $this->Form->input('dynamic_text',array('type'=>'select','options'=>$fields,'label' => false,'div' => false, 'empty' => 'Select Field','class' => 'form-control','onchange'=>'SetDynamicText()'));?>                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">	    
                                        Template Description *:
                                    </label>
                                    <div class="col-sm-8">
                                        <?php echo $this->Form->textarea('template',array('id'=>'Smstemplatetemplate','label'=>false,'div'=>false,'class'=>'ckeditor form-control')); ?>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5">	    
                            </label>
                            <div class="col-sm-8">
                                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update','label'=>false,'div'=>false));?>
                                        <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn',
                                        )); ?>                                        
                            </div>
                        </div>     
                        <div class="form-group">
                            <label class="control-label col-sm-5">	    
                            </label>
                            <div class="col-sm-8">
                                <i>{FirstName} for First Name,{LastName} for Last Name,{EMail} for Sms</i>
                            </div>
                        </div>                             
                <?php echo $this->Form->end(); ?>
                    </div>   
                </div>
            </div>
        </div>  
    </div>
</div>
<script type= "text/javascript">
    $(document).ready(function() {
        //$("#StaticPageAdminAddPageForm").validationEngine();
        $('#SmstemplateName').keyup(function() {
            var theval = $(this).val();
            theval = theval.replace(/\s+/g, '_').toLowerCase()
            $('#template_code').val(theval);
        });

    });
    function SetDynamicText() {
        var DynamicText = document.getElementById('SmstemplateDynamicText').value;
        if (DynamicText == "") {
            return false;
        }
        var smsVal = $(document).find('#Smstemplatetemplate').val();
        smsVal = smsVal + DynamicText;
        $(document).find('#Smstemplatetemplate').val(smsVal);
    }
</script>