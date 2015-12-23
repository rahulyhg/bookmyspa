<?php
//echo $this->Html->script('frontend/jquery.validate');
//echo $this->Html->script('admin/admin_changepassword');
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Change Password
                </h3>
            </div>
            <div class="box-content">
                <div class="tabbable">
                    <?php echo $this->Form->create('User', array('id' => 'changePasswordId', 'noValidate' => true, 'class' => 'form-horizontal')); ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >Old Password*:</label>
                        <div class="col-sm-5">
                            <?php echo $this->Form->input('User.old_password', array('label' => false, 'type' => 'password', 'class' => 'form-control', 'minlength'=>'8','maxlength'=>'58','required','validationMessage'=>"Old Password is Required.",'data-minlength-msg'=>"Minimum 8 characters.",'data-maxlengthcustom-msg'=>"Maximum 55 characters." ,"maxlengthcustom"=>'55')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >New Password*:</label>
                        <div class="col-sm-5">
                            <?php echo $this->Form->input('User.password', array('label' => false, 'type' => 'password', 'class' => 'form-control', 'minlength'=>'8','maxlength'=>'12','required','validationMessage'=>"New Password is Required.",'data-minlength-msg'=>"Minimum 8 characters.",'data-maxlengthcustom-msg'=>"Maximum 12 characters." ,"maxlengthcustom"=>'12')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" >Confirm Password*:</label>
                        <div class="col-sm-5">
                            <?php echo $this->Form->input('User.confirm_password', array('label' => false, 'type' => 'password', 'class' => 'form-control', 'minlength'=>'8','maxlength'=>'12','required','validationMessage'=>"Confirm password is Required.",'data-minlength-msg'=>"Minimum 8 characters.",'data-maxlengthcustom-msg'=>"Maximun 12 characters.",'data-equal-field'=>"data[User][password]",'data-equal-msg'=>'Confirm password should match password',"maxlengthcustom"=>'12')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" ></label>
                        <div class="col-sm-5">
                            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-primary', 'label' => false, 'div' => false)); ?>
                            <?php
                                 echo $this->Form->button('Cancel', array(
                                'type' => 'button', 'label' => false, 'div' => false,
                                'class' => 'btn',
                                'onclick' => "location.href = '" . $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index', 'admin' => true)) . "';"));
                            ?>
                        </div>
                        <!--<div class="forms-action col-sm-8 text-center">
                            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-primary', 'label' => false, 'div' => false)); ?>
                            <?php
                            echo $this->Form->button('Cancel', array(
                                'type' => 'button', 'label' => false, 'div' => false,
                                'class' => 'btn',
                                'onclick' => "location.href = '" . $this->Html->url(array('controller' => 'Dashboard', 'action' => 'index', 'admin' => true)) . "';"));
                            ?>
                        </div>-->
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>   
            </div>
        </div>
    </div>
</div>

<div class="utopia-widget-content">
</div>
</section>
</div>
</div>

    <script>
        $(document).ready(function(){
            var validator = $("#changePasswordId").kendoValidator({
                rules:{
                    minlength: function (input) {
                        return minLegthValidation(input);
                    },
                    maxlengthcustom: function (input) {
                        return maxLegthCustomValidation(input);
                    },
                    pattern: function (input) {
                        return patternValidation(input);
                    },
                    equal: function (input) {
                        return equalFieldValidation(input);
                    }
                },
                errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
        });
    </script>