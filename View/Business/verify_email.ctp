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
                <div class="steps-lft-container step3">
        	<div class="photo"><?php echo $this->Html->image('frontend/step3-1.png'); ?></div>
            <div class="foot">
            	<h3>MARKET YOUR SALON</h3>
                <p> Take advantage of our SMS / e-mail marketing tools to
                    send promotions / deals or announcement emails to your
                    customers and employees. Wish them happy birthday,
                    invite them to Like your Facebook page, or remind the
                    that you accept appointments 24/7.                 
                </p>
            </div>
        </div>
                <div class="clearfix"></div>
            </div>
    
            <div class="col-sm-6 pos-lft step3form step3-1">
                <div class="well text-left custom_well">
                    <h2 class="fs-title"><?php echo __('E-mail Verification ',true); ?></h2>
                    <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
                    <div class="form-group">  
                        <label><?php echo __('Check your inbox for verification Email from Sieasta. Please follow the instructions in that email or enter your verfication code below.',true); ?></label>
                        <?php echo $this->Form->input('token_email',array('label'=>false,'type'=>'text','class'=>'form-control'));?>
			
                    
			<em class="MoreInfoSieasta">
			    <?php echo __('If you have not recieved the verification email. please check your spam folder',true);?></em>
			    <em class="MoreInfoSieasta">
                            <?php echo __('Still no luck?',true);?>
                            <?php echo $this->Html->link(__('Resend Verification email',true),'javascript:void(0);',array('class'=>'sendMsgAgain','escape'=>false)); ?>
                            <span class="ajax_indicator" style="display:none">
                            <?php echo $this->Html->image('loader.GIF'); ?> 
                            </span>
                            </em>
                    </div>
                    <?php //echo $this->Html->link('Back',array('controller'=>'Business','action'=>'signup','admin'=>false),array('escape'=>false,'class'=>'black_btn action-button margin_rt20')); ?>
           
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
                        url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'sendEmailCode','admin'=>false))?>",
			data:{'id':userId},
                        beforeSend: function () {
                         $('.ajax_indicator').fadeIn('fast');
                        },
                        success: function(res) {
                         $('.ajax_indicator').fadeOut();
                        }
                    });
	    }
	});
    });
</script>
</div>
