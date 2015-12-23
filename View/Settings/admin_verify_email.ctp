
<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('User', array('url' => array('controller' => 'Settings', 'action' => 'verify_email','admin'=>true),'id'=>'vEmailForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2 class="">Verify Email</h2>
        </div>

        <div class="modal-body clearfix">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-content">
                        <div class="form-group form-horizontal">
                            <label class="control-label col-sm-2">Email Token:</label>
                            <div class="col-sm-8">
                            <?php echo $this->Form->input('User.email_token',array('label'=>false,'div'=>false,'class'=>'form-control'));?>
                            <span class="help-block">
                                <em class="MoreInfoSieasta">
                                    <?php echo $this->Html->link(__('Resend Verification email',true),'javascript:void(0);',array('class'=>'sendMsgAgain','escape'=>false)); ?></em>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer pdng20">
	    <div class="col-sm-3 pull-right">
		<input type="submit" name="next" class="vEmailForm btn btn-primary" value="Next" />
	    </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    Custom.init();

    $(document).ready(function(){
	$(document).on('click','.sendMsgAgain',function(){
	    var userId = '<?php echo $auth_user['User']['id'];?>';
	    if(userId){
		 $.ajax({
			type:'post',
                        url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'sendEmailCode','admin'=>false))?>",
			data:{'id':userId},
                        success: function(res) {
                            if(res == 's'){
                                alert('Mail Send Successfully');    
                            }
                            
                        }
                    });
	    }
	});
    });
</script>
