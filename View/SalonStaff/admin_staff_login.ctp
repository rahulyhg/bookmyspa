    <?php echo $this->Form->create('User', array('novalidate', 'type' => 'file', 'class' => 'form-vertical')); ?>
    <div class="step-forms col-sm-9 clearfix">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="additionalfield" class="control-label"><?php echo __('User Name', true); ?>*:</label>
                <div>
                    <?php echo $this->Form->input('username', array('label' => false, 'div' => false, 'class' => 'form-control','minlength'=>'3','maxlength'=>'55','required','validationMessage'=>"Username is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlength-msg'=>"Maximum 55 characters.")); ?>
                </div>
            </div>
            <div class="form-group">
                <?php $pass = $user['User']['password']; ?>    
                <label for="firstname" class="control-label"><?php echo __('Password', true); ?>*:</label>
                <div>
                <?php
                $loop_star = '';
                    if(!empty($count_pwd)){
                        for($i = 1;$i<=$count_pwd;$i++){
                            $loop_star .= '*';
                        }
                    }
                ?>
                    <?php echo $this->Form->input('password1', array('value' => ($pass) ? $loop_star : '', 'type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control', 'minlength'=>'8','maxlength'=>'58','required','validationMessage'=>"Password is Required.",'data-minlength-msg'=>"Minimum 8 characters.",'data-maxlengthcustom-msg'=>"Maximum 55 characters." ,"maxlengthcustom"=>'55')); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="anotherelem" class="control-label"><?php echo __('Confirm Password', true); ?>*:</label>
                <div>
                    <?php echo $this->Form->input('confirmPassword', array('value' => ($pass) ? $loop_star : '', 'type' => 'password', 'label' => false, 'required' => FALSE, 'div' => false, 'class' => 'form-control', 'minlength'=>'8','maxlength'=>'100','required','validationMessage'=>"Confirm password is Required.",'data-minlength-msg'=>"Minimum 8 characters.",'data-maxlengthcustom-msg'=>"Maximun 55 characters.",'data-equal-field'=>"data[User][password1]",'data-equal-msg'=>'Confirm password should match password',"maxlengthcustom"=>'55')); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="additionalfield" class=" control-label"><?php echo __('Card Id', true); ?> </label>
                <div>
                    <?php 
                    $patern = "^[A-Za-z0-9]+$";
                    echo $this->Form->input('UserDetail.card_id', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control', 'maxlength' => '55','pattern'=>$patern ,'data-pattern-msg'=>"Only alphanumeric characters are allowed.")); ?>
                </div>
            </div>
        </div>
        <div class='col-sm-6'>
            <div class="form-group">
                <label for="additionalfield" class=" control-label"><?php echo __('Security Question', true); ?></label>
                <div >
                    <?php echo $this->Form->input('security_question_id', array('label' => false,'div'=>false, 'options' => $this->common->get_security_question(), 'class' => 'form-control', 'empty' => 'Select question')); ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <label for="additionalfield" class="control-label"><?php echo __('Security Question Answer', true); ?></label>
                <div >
                    <?php echo $this->Form->input('security_question_answer', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="additionalfield" class=" control-label"><?php echo __('Employee Type', true); ?>*</label>
                <div >
                    <?php $readEmpType = false;
                        if(isset($this->data['UserDetail']['employee_type']) && !empty($this->data['UserDetail']['employee_type'])){
                            $readEmpType = 'disabled';
                        }?>
                    <?php echo $this->Form->input('UserDetail.employee_type', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_employee_type(), 'empty' => 'Select employee type','disabled'=>$readEmpType,'required','validationMessage'=>"Employee type is Required.")); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="additionalfield" class=" control-label"><?php echo __('Access Level', true); ?>*</label>
                <div class="<?php echo ($user['User']['id'] == $this->Session->read('Auth.User.id'))?'emp-access-level':''; ?>">
                    <?php 
                    $disable = false;
                    if($user['User']['id'] == $this->Session->read('Auth.User.id')){
                      echo  '<strong style="font-size:18px;">Account Owner</strong>';
                    }else{
                      echo $this->Form->input('User.group_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control','options' => $this->common->get_employee_access_level(), 'empty' => 'Select employee Access Level','required','validationMessage'=>"Access Level is Required."));
                    }                    
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo $this->Form->input('id',array('type'=>'hidden')); 
    echo $this->Form->input('UserDetail.id',array('type'=>'hidden'));
    echo $this->Form->input('Contact.id',array('type'=>'hidden'));
    echo $this->Form->input('Address.id',array('type'=>'hidden')); 
    ?>
    <div class="clearfix"></div>
    <div class="form-actions col-sm-9 text-right">
    <?php
        echo $this->Form->button('Back', array(
            'type' => 'reset', 'label' => false, 'div' => false,
            'class' => 'btn', 'onClick' => 'window.location.reload()'));
        ?>
    <?php echo $this->Form->button('Next', array('type' => 'submit', 'class' => 'btn btn-primary submitUserlogin', 'label' => false, 'div' => false)); ?>
    </div>
    <?php $this->Form->end(); ?>
    <script>
        $(document).ready(function(){
            var validator = $("#UserAdminStaffLoginForm").kendoValidator({
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