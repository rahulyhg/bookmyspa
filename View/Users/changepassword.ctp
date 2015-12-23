<?php echo $this->Form->create('User',array('novalidate'));  ?>
<?php echo $this->Form->input('User.email',array('type'=>'text','class'=>'validate[required]'));?>
<?php echo $this->Form->input('User.password',array('type'=>'password','class'=>'span8 validate[required]'));?>
<?php echo $this->Form->submit('Signin',array('class'=>'btn span4','div'=>false,'label'=>false));  ?>
<label class="choice" for="remember">
	<?php echo $this->Form->checkbox('rememberme',array()); echo ' Remember Me'; ?>
</label>
<label class="forgotsmthng">
   Forgot <?php echo $this->Html->link('Password ',array('controller'=>'users','action'=>'forgotpassword','password')); ?> ?
</label>

<?php echo $this->Form->end(); ?>


