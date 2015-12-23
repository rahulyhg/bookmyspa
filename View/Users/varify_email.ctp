<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Verify Your Email</h4>
    </div>
    <div class="modal-body clearfix">
    <?php echo $this->Form->create('User',array('novalidate'));  ?>
     <ul style="width:100%" class="login-form">
                <li>
                    <label><?php echo __('Enter the email verification code',true); ?></label>
                    <?php echo $this->Form->input('User.email_code',array('type'=>'text','label'=>false,'div'=>false,'class'=>'login-text-field'));?>
                    <?php echo $this->Html->Link(__('Resend email verification code?'),'javascript:void(0)',array('class'=>'resend_email','data-id'=>base64_encode(base64_encode($userDetail['User']['id'])),'data-secert'=>$userDetail['User']['email_token'])); ?>
                    <span class="ajax_indicator" style="display:none">
                         <?php echo $this->Html->image('loader.GIF'); ?> 
                    </span>
                </li>
                <li>
                    <?php echo $this->Form->submit('Verify',array('class'=>'action-button submitEmail','div'=>false,'label'=>false));  ?>
                </li>
     </ul>           
    <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>
