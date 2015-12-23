
<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('User', array('url' => array('controller' => 'Settings', 'action' => 'verify_phone','admin'=>true),'id'=>'vPhoneForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2 class="">Verify Phone</h2>
        </div>

        <div class="modal-body clearfix">
            <div class="col-sm-12">
                <div class="box">
                    <div class="box-content">
                        <div class="form-group form-horizontal">
                            <label class="control-label col-sm-2">Phone Token:</label>
                            <div class="col-sm-8">
                            <?php echo $this->Form->input('User.phone_token',array('label'=>false,'div'=>false,'class'=>'form-control'));?>
                            <span class="help-block">
                                <em class="MoreInfoSieasta">
                                    <?php echo $this->Html->link(__('Resend Verification Code',true),'javascript:void(0);',array('class'=>'sendMsgAgain','escape'=>false)); ?></em>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer pdng20">
	    <div class="col-sm-3 pull-right">
		<input type="submit" name="next" class="vPhonebtn btn btn-primary" value="Next" />
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
                        url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'sendPhoneCode','admin'=>false))?>",
			data:{'id':userId},
                        success: function(res) {
                            if(res){
                                alert('Code Send Successfully');    
                            }
                            
                        }
                    });
	    }
	});
    });
</script>
