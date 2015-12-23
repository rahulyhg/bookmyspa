<?php  echo $this->Html->script('user/change_password'); ?>
<div class="panel-body">        
        <?php echo $this->Session->flash();   echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'change_password'),'id'=>'changePassword')); 
        ?>
        <div class="team_registerform">
            <?php if($password){ ?>
            <div class="form-group">
                <div class="formlabel"><label>Old Password<span class="required"> * </span></label> </div>              
                 <div class="forminput"><?php echo $this->Form->input('old_password',array('type'=>'password','label' => false,'div' => false, 'placeholder' => 'Old Password','class' => 'form-control','maxlength' => 30));?></div>
</div>
<?php } ?>
<div class="form-group">
                <div class="formlabel"><label>New Password<span class="required"> * </span></label> </div>              
                 <div class="forminput"><?php echo $this->Form->input('password',array('label' => false,'div' => false, 'placeholder' => 'New Password','class' => 'form-control','maxlength' => 30));?></div>
 </div>
	    <div class="form-group">
            <div class="subbtns">
	    <?php echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-default'));?>
            <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>
            <?php echo $this->Html->link('Cancel',"/users/profile",array('escape' =>false,'class' => 'btn btn-default')); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>