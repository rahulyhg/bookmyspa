<div class="container">
 	<div class="radio_tabs">
   
        <form id="msform">
	<!-- progressbar -->
	<ul id="progressbar" class="mrgn-btm-non">
		<li class="active"><?php echo __('Details',true)?></li>
		<li class="active"><?php echo __('Information',true)?></li>
		<li class="active"><?php echo __('Varification',true)?></li>
                <li class="active"><?php echo __('Finish',true)?></li>
	</ul>
	<!-- fieldsets -->
    
	<fieldset>
	<div class="col-sm-12">
    	<div class="thankyou-photo"><?php echo $this->Html->image('frontend/thankyou-img.png'); ?></div>
        <div class="well custom_well clearfix">
        	<h3 class="thankyou-heading"><?php echo __('Thankyou !',true)?></h3>
            <p class="thankyou-text"><?php echo __('Business_Thankyou_message',true); ?> </p>
            <h2 class="getting-started-heading"><?php echo __('GETTING STARTED IS EASY',true)?></h2>
            <ul id="progressbar" class="getting-started">
                <li class="active"><span class="circle-no">1</span><?php echo __('Sign up and tell us about your venue',true)?></li>
                <li><span class="circle-no">2</span><?php echo __('Create your Staff  Profile and services menu',true)?></li>
                <li><span class="circle-no">3</span><?php echo __('Upload photos and videos for Salon',true)?></li>
                <li><span class="circle-no">4</span><?php echo __('Create Promotional deals.',true)?></li>
            </ul>
            
            <?php if(!isset($auth_user)){ ?>
	    <input type="button" class="action-button thanks-btn" value="Login Now">
	    <?php } ?>
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
    
 </script>
</div>