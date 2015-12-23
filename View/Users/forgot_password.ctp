    <?php echo $this->Html->script('admin/admin_forgotpassword');?>
    <div class="panel-body">
    <div class="forgotform">
    <div class="radioLogin">
    <?php echo $this->Session->flash(); ?>
    </div>
        <div class="forgotpwdclass">
            <fieldset>
                <h6 class='addbutton'>Forgot Password</h6>
            <?php echo $this->Form->create('User', array('id'=>'forgotPasswordId')); ?>
              
                 <div class="form-group form_margin">                                        
                    <?php echo $this->Form->input('email',array('label' => false,'div' => false, 'placeholder' => 'E-mail','class' =>'uname form-control','maxlength' => 55));?>
                </div> 
				<div class="form-group">
					<div class="subbtns">
					<?php echo $this->Form->submit('Submit',array('class'=>'btn btn-default formSubmit ch-login btn btn-primary','type'=>"submit"));?> 
					</div>
				</div> 
            </fieldset>
            <?php echo $this->Form->end(); ?>
        </div>
        </div>
    </div>