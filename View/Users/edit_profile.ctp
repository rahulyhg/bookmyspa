<?php
echo $this->Html->css('calendar/jquery-ui');
echo $this->Html->css('calendar/demos');
echo $this->Html->script('user/edit_user');
echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js');
echo $this->Html->script('calendar/jquery.ui.datepicker');
?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<style>
    span.error {
        float: none;

        padding-left: 126px;
    }

</style>
<script>
    $(document).ready(function() {
        $(function() {
            $("#dob").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "c-60:c+5",
                dateFormat: 'M d, yy',
            });
        });

    });
    /* image preview code  */

</script>
<div class="panel-body">  
    <div class="loginform">
        <div class="rowsession">
            <?php echo $this->Session->flash(); ?>   
            <div class="clearfix"></div>

            <div class="addbutton text-center">                
                Edit Details
            </div>
        </div>
        <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'edit_profile'), 'id' => 'editUser', 'type' => 'file'));
        ?>
        <div class="team_registerform">
            <div class="form-group">
                <div class="formlabel"><label>First Name<span class="required"> * </span></label> </div>              
                <div class="forminput"><?php echo $this->Form->input('first_name', array('label' => false, 'div' => false, 'placeholder' => 'First Name', 'class' => 'form-control', 'maxlength' => 30)); ?></div>
            </div>
            <div class="form-group">
                <div class="formlabel"><label>Last Name<span class="required"> * </span></label></div>                 
                <div class="forminput"><?php echo $this->Form->input('last_name', array('label' => false, 'div' => false, 'placeholder' => 'Last Name', 'class' => 'form-control', 'maxlength' => 20)); ?></div>
            </div>
            <div class="form-group">
                <div class="formlabel"><label>Email<span class="required"> * </span></label></div>                 
                <div class="forminput"><?php echo $this->Form->input('email', array('label' => false, 'div' => false, 'placeholder' => 'Email', 'class' => 'form-control', 'maxlength' => 55)); ?></div>
            </div>
            <div class="form-group">
                <div class="formlabel"><label>Date of Birth<span class="required"> * </span></label></div>   
                <div class="forminput"><?php echo $this->Form->input('dob', array('type' => 'text', 'id' => 'dob', 'label' => false, 'div' => false, 'placeholder' => 'DOB', 'class' => 'form-control', 'maxlength' => 15, 'readonly' => 'readonly')); ?></div>
            </div>
			<?php if($this->request->data['User']['user_type']== 1){?>
			<div class="form-group">
                <div class="formlabel"><label>Paypal Credential</label></div> 
                <div class="forminput">
                    <?php echo $this->Form->input('paypal_email', array('placeholder' => "Paypal E-mail", 'label' => false,'div' => false,'class' => 'form-control','maxlength' =>55)); ?>
                    
                </div>
            </div>
			<?php } ?>
			<div class="form-group">
                <div class="formlabel"><label>Country</label></div> 
                <div class="forminput">
                    <?php echo $this->Form->input('country_id', array('options' => $country, 'empty' => "Select Country", 'label' => false, 'div' => false, 'class' => 'form-control', 'style' => 'width:255px;')); ?>
                    <section id="stateloader" class="loader_img_state" style="display:none;"><?php echo $this->Html->image('ajax-loader.gif'); ?></section>
                </div>
            </div>
            <div class="form-group">
                <div class="formlabel"><label>Avatar Image</label></div> 
                <div class="forminput">
                    <?php echo $this->Form->input('avt_img', array("data-jid" => "avatarPreview", 'type' => 'file', 'label' => false, 'div' => false, 'class' => 'PreviewImage', 'maxlength' => 200, 'onchange' => 'preview(this, "avatarPreview")')); ?>   

                </div>
            </div>
            <div id="avatarPreview">
                <?php
                if ($this->request->data['User']['avatar_image'] != '' and ! filter_var($this->request->data['User']['avatar_image'], FILTER_VALIDATE_URL)) {
                    echo $this->Html->image('avatar/' . $this->request->data['User']['avatar_image'], array('width' => '150', 'height' => '150'));
                }
                ?>
            </div>
            <div class="form-group">
                <div class="formlabel"><label>Cover Image</label></div> 
                <div class="forminput">
<?php echo $this->Form->input('cov_img', array("data-jid" => "avatarPreview", 'type' => 'file', 'label' => false, 'div' => false, 'class' => 'PreviewImage', 'maxlength' => 200, 'onchange' => 'preview(this , "coverpreview")')); ?>    </div>
            </div>
            <div id="coverpreview">
                <?php if ($this->request->data['User']['cover_image'] != '' && $this->request->data['User']['cover_image'] !== 'type_error') {
                    echo $this->Html->image('cover/' . $this->request->data['User']['cover_image'], array('width' => '150', 'height' => '150'));
                }
                ?>
            </div>
            <div class="form-group">
                <div class="formlabel"><label>Bio</label></div> 
                <div class="forminput">
<?php echo $this->Form->input('bio', array('type' => 'textarea', 'label' => false, 'div' => false, 'placeholder' => 'Bio', 'class' => 'form-control', 'maxlength' => 55, 'readonly' => '', 'required' => false)); ?>
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <div class="subbtns"><?php echo $this->Form->button('Update', array('type' => 'submit', 'class' => 'btn btn-default')); ?>
        <?php echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('Cancel', "/users/dashboard", array('escape' => false, 'class' => 'btn btn-default')); ?>
            </div>
        </div>
<?php echo $this->Form->end(); ?>
    </div><!-- /.row -->
</div>