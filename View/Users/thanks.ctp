 	<div class="radio_tabs">
   
        <form id="msform">
	<!-- progressbar -->
	<ul id="progressbar" class="mrgn-btm-non">
		<li class="active"><?php echo __('Details',true)?></li>
		<li class="active"><?php echo __('Information',true)?></li>
		<li class="active"><?php echo __('Verification',true)?></li>
                <li class="active"><?php echo __('Finish',true)?></li>
	</ul>
	<!-- fieldsets -->
    
	<fieldset>
		<div class="col-sm-12">
	<p class="thankyou-text  text-center"><?php echo __('Please check your inbox for verification from Sieasta and follow the instructions in that. If you have not received the verification email, please check your spam folder. Still no luck? '.$this->Html->link(__('Resend verification email'),'javascript:void(0);',array('class'=>'sendMsgAgain', 'data-id'=>$userId,'escape'=>false)),true); ?> </p>
    	<div class="thankyou-photo"><?php echo $this->Html->image('frontend/thankyou.png'); ?></div>
        <div class="well custom_well">
        	<h3 class="thankyou-heading"><?php echo __('Thank you for Signing up!',true)?></h3>
            
            <h2 class="getting-started-heading"><?php echo __('BOOK YOUR APPOINTMENTS',true)?></h2>
         
            <input type="button" class="action-button thanks-btn" value="Login Now">
        </div>
    </div>
    
        
	</fieldset>
	
    
    <div class="clearfix"></div>
</form>
        
    </div>
 
 <script>
    $(document).ready(function(){
        
        $(document).on('click','.thanks-btn',function(){
              $(".userLoginModal").trigger('click');    
            })
        })
    
   $(document).ready(function(){
	$(document).on('click','.sendMsgAgain',function(){
	    var userId = $(this).attr('data-id');
	    if(userId){
		 $.ajax({
			type:'post',
                        url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'sendEmailCode','admin'=>false))?>"+'/'+userId,
			data:{'id':userId},
                        beforeSend: function () {
                         $('.ajax_indicator').fadeIn('fast');
                        },
                        success: function(res) {
			 if(res=='s'){
				alert('Email sent successfully');
			 }
                        }
                    });
	    }
	});
    });
 </script>
 
