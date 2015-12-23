    <?php  //echo $this->Html->script('user/login'); ?>
    <div class="panel-body">
    <div class="loginform">
    <div class="radioLogin">
    
    </div>
    <div class="formclass">
        <?php echo $this->Session->flash();  
      echo $this->Form->create('User', array('id'=>'login','action'=>'paypal_credential','controller'=>'users'));
    ?>
            <fieldset>
                <h6>Paypal Credential</h6>
                <div class="form-group form_margin">                                        
                    <?php echo $this->Form->input('paypal_email',array('label' => false,'div' => false, 'placeholder' => 'Paypal E-mail','class' => 'uname','maxlength' => 55,'required'=>false));?>
                </div>
             <?php echo $this->Form->submit('Submit',array('class' => 'btn btn-default'));?>                
            </fieldset>
            <?php echo $this->Form->end(); ?>

    </div>
    </div>
    </div>