<div class="modal-dialog vendor-setting sm-vendor-setting">
        <div class="modal-content">
            <?php echo $this->Form->create('Vendor', array('novalidate', 'class'=>'form-horizontal')); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel"><i class="icon-edit"></i>
                    <?php echo (isset($this->data) && !empty($this->data)) ? 'Edit' : "Add"; ?> Vendor</h3>
            </div>
            <div class="modal-body">
                <div class="box">
                    <div class="box-content">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                            <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group"></div>
                                <div class="form-group">
                                    <div class="control-group">
                                        <label class="col-sm-3 control-label " >English Business Name *:</label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->input('eng_business_name', array('label' => false, 'div' => false, 'class' => 'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Business Name is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 100 characters.",'data-pattern-msg'=>"Please enter only alphabets.")); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="control-group">
                                        <label class="col-sm-3 control-label " >English Business Address *:</label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->input('eng_address', array('label' => false, 'div' => false, 'class' => 'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters.",'required','validationMessage'=>"Business Address is Required.",'data-minlength-msg'=>"Minimum 3 characters.")); ?>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form-group"></div>
                                <div class="form-group">
                                    <div class="control-group">
                                        <label class="col-sm-3 control-label " >Arabic Business Name:</label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->input('ara_business_name', array('label' => false, 'div' => false, 'class' => 'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlength-msg'=>"Maximum 100 characters.",'pattern'=>'^[A-Za-z ]+$','data-pattern-msg'=>"Please enter only alphabets.")); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="control-group">
                                        <label class="col-sm-3 control-label " >Arabic Business Address:</label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->input('ara_address', array('label' => false, 'div' => false, 'class' => 'form-control','minlength'=>'3','maxlength'=>'101','data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters.")); ?>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-group">
                                <label class="col-sm-3 control-label " >Country *:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('country', array('options' => $countryData, 'label' => false, 'div' => false, 'class' => 'form-control','empty'=>'Please Select Country','required','validationMessage'=>"Please Select Country.")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-group">
                                <label class="col-sm-3 control-label " >Website URL*:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('website', array('type' => 'url', 'label' => false, 'div' => false, 'class' => 'form-control','required','validationMessage'=>"Webiste URL is Required.",'data-url-msg'=>"Please enter correct URL.")); ?>
                                </div>
                            </div>
                        </div> 
                        <h3><strong>Primary Contact</strong></h3>
                        <div class="form-group">
                            <div class="control-group">
                                <label class="col-sm-3 control-label " >Phone *:</label>
                                <div class="col-sm-7">
                                    <div class="col-sm-3 nopadding">
                                        <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','class'=>'form-control cPHcd code','value'=>"+971",'readonly'=>'readonly','div'=>false,'label'=>false,'maxlength'=>"5",'minlength'=>"2",'data-minlength-msg'=>"Minimum 2 characters.",'required','validationMessage'=>"Country code is Required."));?>
                                    </div>
                                    <div class="col-sm-9 rgt-p-non">
                                        <?php echo $this->Form->input('phone', array('label' => false, 'div' => false, 'class' => 'form-control numOnly','maxlength'=>'10','required','validationMessage'=>"Phone number is Required.",'data-maxlength-msg'=>"Maximum 100 characters.")); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-group">
                                <label class="col-sm-3 control-label " >Email*:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('email', array('type'=>'email','label' => false, 'div' => false, 'class' => 'form-control','required','validationMessage'=>"Email is Required.",'data-email-msg'=>"Please enter correct Email.")); ?>
                                </div>
                            </div>
                        </div>
                        <h3><strong>Secondary Contact</strong></h3>
                        <div class="form-group">
                            <div class="control-group">
                                <label class="col-sm-3 control-label " >Phone:</label>
                                <div class="col-sm-7">
                                    <div class="col-sm-3 nopadding">
                                        <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','class'=>'form-control cPHcd code','value'=>"+971",'div'=>false,'label'=>false,'maxlength'=>'5','minlength'=>"2",'data-minlength-msg'=>"Minimum 2 characters."));?>
                                    </div>
                                    <div class="col-sm-9 rgt-p-non">
                                    <?php echo $this->Form->input('secondary_phone', array('label' => false, 'div' => false, 'class' => 'form-control numOnly')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-group">
                                <label class="col-sm-3 control-label " >Email:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('secondary_email', array('label' => false, 'div' => false, 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-group">
                                <label class="col-sm-3 control-label ">Fax:</label>
                                <div class="col-sm-7">
                                    <div class="col-sm-3 nopadding">
                                        <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','class'=>'form-control cPHcd','value'=>"+971",'div'=>false,'label'=>false));?>
                                    </div>
                                    <div class="col-sm-9 rgt-p-non">
                                        <?php echo $this->Form->input('fax', array('label' => false, 'div' => false, 'class' => 'form-control')); ?>
                                    </div>
                                </div>
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
                    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary full-w add_update','label'=>false,'div'=>false));?>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>         
        </div>
    </div>
<script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        specialKeys.push(43); //Plus

        $(function () {
            $(".code").bind("keypress", function (e) {
                var keyCode = e.which ? e.which : e.keyCode
                var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
                $(".error").css("display", ret ? "none" : "inline");
                return ret;
            });
            $(".numeric").bind("paste", function (e) {
                return false;
            });
            $(".numeric").bind("drop", function (e) {
                return false;
            });
        });
    </script>