<div class="container">
<div class="radio_tabs">
    <?php echo $this->Form->create('User',array('novalidate','id'=>"msform"));
    // pr($this->data);
    ?>
        <!-- progressbar -->
	<ul id="progressbar">
            <li class="active"><?php echo __('Details',true); ?></li>
            <li class="active"><?php echo __('Information',true);?></li>
            <li><?php echo __('Verification',true);?></li>
            <li><?php echo __('Finish',true);?></li>
	</ul>
	<!-- fieldsets -->
	<fieldset>
            <div class="col-sm-6 pos-rgt">
               <!-- <span class="girl_img">
                    <?php echo $this->Html->image('frontend/girl.png'); ?>
                </span>
                <div id="map1" style="height: 150px"></div>-->
		<div class="steps-lft-container">
		    <div class="photo"><?php echo $this->Html->image('frontend/girl.png'); ?></div>
			<div class="foot">
			    <h3>CUSTOMER HISTORY</h3>
			    <p>Use our salon software to track all of your customer
                                contact information, service and retail history, IOUs,
                                formulas, allergies, general notes, attendance and
                                rewards points. Instantly view customer's feedback
                                posted on your Sieasta page.                 
			    </p>
			</div>
		</div>
                <div class="clearfix"></div>
            </div>
    
            <div class="col-sm-6 pos-lft">
                <div class="well text-left custom_well">
                    <h2 class="fs-title"><?php echo __('Login_Information',true); ?></h2>
                    <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
                    <?php echo $this->Form->hidden('Contact.id',array('label'=>false,'div'=>false));?>
                    <div class="form-group">  
                        <label><?php echo __('First Name',true); ?><span class="red">*</span></label>
                        <?php echo $this->Form->input('first_name',array('label'=>false,'type'=>'text','class'=>'form-control','required','validationMessage'=>"First Name is required.",'maxlength'=>100));?>
                    </div>
                    <div class="form-group">  
                        <label><?php echo __('Last Name',true); ?><span class="red">*</span></label>
                        <?php echo $this->Form->input('last_name',array('label'=>false,'type'=>'text','class'=>'form-control','autocomplete'=>'off','required','validationMessage'=>"Last Name is required.",'maxlength'=>100,'autocomplete'=>'off'));?>
                    </div>
                  
                    <div class="form-group">
			<?php $patern = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" ?>
                        <label><?php echo __('Login_Email',true); ?><span class="red">*</span></label>
                        <?php echo $this->Form->input('email',array('label'=>false,'type'=>'text','class'=>'form-control','pattern'=>$patern,'data-pattern-msg'=>"Please enter a valid email address.",'required','validationMessage'=>"Email is required.",'data-email-msg'=>"Please enter valid email address.",'autocomplete'=>'off'));?>
                    </div>
		      <?php if(!isset($auth_user)){?>
                    <div class="form-group">  
                        <label><?php echo __('Password',true); ?><span class="red">*</span></label>
                        <?php echo $this->Form->input('password',array('label'=>false,'type'=>'password','class'=>'form-control','autocomplete'=>'off','required','validationMessage'=>"Password is required.",'autocomplete'=>'off'));?>
                    </div>
                    <?php } ?>
		    
                    <div class="form-group">  
                        <label><?php echo __('Mobile 1',true); ?><span class="red">*</span></label>
                        <div class="row">
                            <div class="col-sm-3 col-xs-3 padding_rt_zero">
                                <input type="text" value="<?php echo $country_code; ?>" class="cPHcd form-control">
                            </div>
                            <div class="col-sm-9 col-xs-9">
                                <?php echo $this->Form->input('Contact.cell_phone',array('type'=>'text','div'=>false,'label'=>false,'class'=>'form-control number','maxlength'=>10,'required','validationMessage'=>"Mobile Number is required."));  ?>
                                <?php  echo $this->Form->hidden('User.parent_id');  ?>
			    </div>
                        </div>
                    </div>
                    <div class="form-group pos-rel clearfix">  
                        <?php 
                        $label = __('Send me occasional e-mail updates.',true);
                             echo $this->Form->input('send_email_updates',array('type'=>'checkbox','div'=>false,'label'=>array('class'=>'new-chk','text'=>$label))); 
                        ?>
                    </div>
                    <?php //echo $this->Html->link('Back',array('controller'=>'Business','action'=>'signup','admin'=>false),array('escape'=>false,'class'=>'black_btn action-button margin_rt20')); ?>
                    <?php echo $this->Form->button(__('Back',true),array('type'=>'button','class'=>'black_btn action-button margin_rt20 pos-rgt mrgn-rgt0','div'=>false,'label'=>false,'onclick'=>"location.href = '".$this->Html->url(array('controller'=>'Business','action'=>'signup','admin'=>false))."';"));  ?>
                    <?php echo $this->Form->submit(__('Next',true),array('class'=>'pos-lft  action-button','div'=>false,'label'=>false));  ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </fieldset>
    <div class="clearfix"></div>
<?php echo $this->Form->end(); ?>
    </div>
<script>
$('.number').keyup(function(){
    var value = $(this).val();
    if(isNaN(value)){
	$(this).val('');
    }
    
})
    $(document).ready(function(){
        setTimeout(function(){callRequiredForm();},2000); 
        var prodValidator = $("#msform").kendoValidator({
        rules:{
            minlength: function (input) {
                return minLegthValidation(input);
            },
            maxlength: function (input) {
                return maxLegthValidation(input);
            },
            pattern: function (input) {
                return patternValidation(input);
            }
        },
        errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");  
    });
</script>
</div>
