  
      <?php        
        echo $this->Html->script('admin/admin_changepassword');
    ?>  
    <style>
    .form_margin{
		height:84px;
	}
    </style>  
    <div class="row">            
            <div class="col-lg-12">                        
               <?php echo $this->Session->flash();?>   
            </div>             
    </div>
      <div class="panel-heading">
        <h3 class="panel-title">Reset Password</h3>
     </div>
   <div class="panel-body">   
		<?php echo $this->Form->create(null, array('url' => array('controller' => 'admins', 'action' => 'secure_check',$uniqueKey),'id'=>'changePasswordId'));?>
		<fieldset>
			 <div class="form-group form_margin">
                <label>New Password<span class="required"> * </span></label>
                <?php echo $this->Form->input('password',array('label' => false,'div' => false, 'placeholder' => 'New Password','class' => 'form-control required','maxlength' => 30,'type' => 'password'));?>                
            </div>
            <div class="form-group form_margin">
                <label>Confirm Password<span class="required"> * </span></label>
                <?php echo $this->Form->input('confirm_password',array('label' => false,'div' => false, 'placeholder' => 'Confirm Password','class' => 'form-control required','maxlength' => 30,'type' => 'password'));?>
              
            </div> 
           
		</fieldset>
		  <?php echo $this->Form->button('Update', array('type' => 'submit','class' => 'btn btn-default'));?>
         <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>
              
    </div>
    
    <div class="row">
        <div class="col-lg-6">
         
            
                  
            
           
        </div>
        
    </div><!-- /.row -->

