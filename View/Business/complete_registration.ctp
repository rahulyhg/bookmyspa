<?php echo $this->Form->create('User',array('novalidate'));  ?>
<div class="input text required">
<label for="AddressZipcode">Business Email</label>
 <?php echo $getData['User']['email'];?>
</div>
<?php echo $this->Form->input('password',array('type'=>'password','class'=>'validate[required]'));?>
<?php echo $this->Form->input('confirm_password',array('type'=>'password','class'=>'validate[required]'));?>
<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false));  ?>
<?php echo $this->Form->end(); ?>


