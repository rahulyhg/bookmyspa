   <?php
    echo $this->Html->script('frontend/jquery.validate');
    echo $this->Html->script('admin/admin_changepassword');
?> 

   <div class="row-fluid">
    <div class="span12">
        <section class="utopia-widget">
            <div class="utopia-widget-title">
                <?php echo $this->Html->image('admin/icons/window.png',array('class'=>'utopia-widget-icon')); ?>
                <span>Change Password</span>
            </div>

            <div class="utopia-widget-content">
                <div class="tabbable">
                    
                     <?php echo $this->Form->create('User',array('id'=>'changePasswordId', 'noValidate' => true));  ?>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="sample-form form-horizontal">
                                    <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" >Old Password*:</label>
                                            <div class="controls">
                                    <?php echo $this->Form->input('User.old_password',array('label'=>false,'type'=>'password','class'=>'input-xlarge input-block-level'));?>
                                            </div>
                                        </div>
                                    </fieldset>
                                   <fieldset>
                                        <div class="control-group">
                                            <label class="control-label" >New Password*:</label>
                                            <div class="controls">
                                  <?php echo $this->Form->input('User.password',array('label'=>false,'type'=>'password','class'=>'input-xlarge input-block-level'));?>
                                 </div>
                                        </div>
                                    </fieldset><fieldset>
                                        <div class="control-group">
                                            <label class="control-label" >Confirm Password*:</label>
                                            <div class="controls">
                               <?php echo $this->Form->input('User.confirm_password',array('label'=>false,'type'=>'password','class'=>'input-xlarge input-block-level'));?>
           
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                          
                        </div>
                  <div class="sample-form form-horizontal">
                        <fieldset>
                            
                            <div class="utopia-from-action">
     

                                <?php echo $this->Form->button('Submit',array('type'=>'submit','class'=>'btn btn-primary span5','label'=>false,'div'=>false));?>
                                
                                <?php echo $this->Form->button('Cancel',array(
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn  span5',
                                            'onclick'=>"location.href = '".$this->Html->url(array('controller'=>'Dashboard','action'=>'index','admin'=>true))."';")); ?>
                                
                            </div>
                        </fieldset> 
                        </div>
                        
                        
                    <?php echo $this->Form->end(); ?>
                </div>   
            </div>
        </section>
    </div>
</div>

       