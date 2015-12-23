<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Verify Your Phone</h4>
    </div>
    <div class="modal-body clearfix">
    <?php echo $this->Form->create('User',array('novalidate'));  ?>
     <ul style="width:100%" class="login-form">
                <li>
                    <label><?php echo __('Enter the OTP password',true); ?></label>
                    <?php echo $this->Form->input('User.phone_code',array('type'=>'text','label'=>false,'div'=>false,'class'=>'login-text-field'));?>
                    <?php echo $this->Form->hidden('User.id',array('label'=>false,'div'=>false,'class'=>'userId','value'=>$userId));?>
                    <?php echo $this->Html->Link(__('Resend OTP ?'),'javascript:void(0)',array('class'=>'resend_phone','data-id'=>$this->Session->read('Auth.User.id'))); ?>
                      <span class="ajax_indicator" style="display:none">
                           <?php echo $this->Html->image('loader.GIF'); ?> 
                        </span>
                </li>
                <li>
                    <?php echo $this->Form->button(__('Verify',true),array('type'=>'button','class'=>'action-button checkPhoneCode','div'=>false,'label'=>false));  ?>
                </li>
     </ul>           
    <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>
