<div class="container">
<div class="radio_tabs">
    <?php echo $this->Form->create('User',array('novalidate','id'=>"msform"));  ?>
        <!-- progressbar -->
	<ul id="progressbar">
            <li class="active"><?php echo __('Details',true); ?></li>
            <li class="active"><?php echo __('Information',true);?></li>
            <li class="active"><?php echo __('Verification',true);?></li>
            <li><?php echo __('Finish',true);?></li>
	</ul>
	<!-- fieldsets -->
	<fieldset>
            <div class="col-sm-6 pos-rgt">
                <div class="steps-lft-container step3-1left">
        	<div class="photo"><?php echo $this->Html->image('frontend/step3-1new.png'); ?></div>
            <div class="foot">
            	<h3>LAST MINUTE DEALS</h3>
                <p>Maximize your profit by even utilizing the off
peak hours at low prices under our concept of
last minute deals.                
                </p>
            </div>
        </div>
        
                <div class="clearfix"></div>
            </div>
    
            <div class="col-sm-6 pos-lft step3form">
                <div class="well text-left custom_well">
                    <h2 class="fs-title"><?php echo __('Mobile Verification ',true); ?></h2>
                    <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
                    <div class="form-group">  
                        <label><?php echo __('Enter the verification code that was sent to your mobile number',true); ?></label>
                        <?php echo $this->Form->input('token_phone',array('label'=>false,'type'=>'text','class'=>'form-control','maxlength'=>8));?>
			<em class="MoreInfoSieasta"><?php echo __('Didn\'t get your Code.',true);?> <?php echo $this->Html->link(__('Try Again.',true),'javascript:void(0);',array('class'=>'sendMsgAgain','escape'=>false)); ?>
                        <span class="ajax_indicator" style="display:none">
                           <?php echo $this->Html->image('loader.GIF'); ?> 
                        </span>
                        </em>
                        
                    </div>
                    <?php echo $this->Form->button(__('Back',true),array('type'=>'button','class'=>'black_btn action-button margin_rt20 pos-rgt mrgn-rgt0','div'=>false,'label'=>false,'onclick'=>"location.href = '".$this->Html->url(array('controller'=>'Business','action'=>'business_detail','admin'=>false))."';"));  ?>
                    <?php echo $this->Form->submit(__('Next',true),array('class'=>'pos-lft  action-button','div'=>false,'label'=>false));  ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </fieldset>
    <div class="clearfix"></div>
<?php echo $this->Form->end(); ?>
    </div>
<script>
    $(document).ready(function(){
	$(document).on('click','.sendMsgAgain',function(){
	    var userId = $(document).find('#UserId').val();
	    if(userId){
		 $.ajax({
			type:'post',
                        url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'sendPhoneCode','admin'=>false))?>",
			data:{'id':userId},
                        beforeSend: function () {
                        $('.ajax_indicator').fadeIn('fast');
                        },
                        success: function(res) {
                            $('.ajax_indicator').fadeOut();
                        },
                                
                    });
	    }
	});
    });
</script>
</div>

