<?php echo $this->element('frontend/StaticPages/enqnavigation'); ?>
<div class="wrapper">
	<div class="container">
    <!--main body section starts-->
    <div class="col-sm-12 business">
    	<div class="well clearfix text-left custom_well">
	 <?php echo $this->Form->create('Feedback',array('novalidate'));?>
       	<p>Please feel free to post your questions, comments and suggestions. We are eager to assist you and serve you better.</p>
        <div class="col-sm-6">
             <div class="form-group">
                <label>Your Name  *:</label>
               <?php echo $this->Form->input('Feedback.name', array('type' => 'text', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Name is required.','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.",'pattern'=>'^[A-Za-z ]+$','data-pattern-msg'=>"Please enter only alphabets.",'maxlength'=>'50')); ?>
            </div>
             <div class="form-group">
                 <label>Phone Number *:</label>
                 <?php echo $this->Form->input('Feedback.phone_number', array('type' => 'text', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Phone Number is required.')); ?>
             </div>
              
             <div class="form-group">  
                <label>Priority *:</label>
		<?php
		$priorityOptions = array('Small' => 'Small', 'Small' => 'Medium', 'Small' => 'Large');
		echo $this->Form->input('Feedback.priority', array('options' => $priorityOptions, 'class' => 'custom_option', 'label' => false,'empty' => '-- Select --','required','validationMessage'=>'Please select Priority from list.')); ?>
             </div>

              <div class="form-group">
                <label>Please verify that you are human </label>
                <div><?php 
				    $this->Captcha->render();?><!--<img src="/img/frontend/captcha.jpg" alt="captcha" title="captcha">--></div>
                <!--<dfn><a href="#" class="purple">Other words please I want audio instead</a></dfn>
                <div class="clearfix pdng-tp10">
                <label>Enter the words shown above* </label>
                <input type="text" value="" class="form-control">
                </div>-->
            </div>
            
         </div>
         <div class="col-sm-6">
             <div class="form-group">
                <label>E-mail  *:</label>
                <?php echo $this->Form->input('Feedback.email', array('type' => 'text', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Email is required.', 'data-msg-email' => 'Please enter valid email.','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.",'maxlength'=>'50')); ?>
                <dfn>Note: Please provide a valid and active e-mail ID
so that we can get in touch with you.</dfn>
            </div>
            
             <div class="form-group">
                <label>Category *:</label>
		<?php
                $categoryOptions = array('Small' => 'Small', 'Medium' => 'Medium', 'Large' => 'Large');
		echo $this->Form->input('Feedback.category', array('options' => $categoryOptions, 'class' => 'custom_option', 'label' => false,'empty' => '-- Select --','required','validationMessage'=>'Please select Category from list.')); ?>
              </div>
                
             <div class="form-group">  
                <label>Suggestions/Feedback *:</label>
                <?php echo $this->Form->input('Feedback.suggestions', array('type' => 'textarea', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Suggestions/Feedback is required.','minlength'=>'8','data-minlength-msg'=>"Minimum 8 characters.",'maxlength'=>'500','data-maxlengthcustom-msg'=>"Maximum 500 characters.")); ?>
             </div>
             
             <div class="form-group">  
                <label>Attachments</label>
		<?php echo $this->Form->input('Feedback.attached_file', array('type' => 'file', 'class' => 'form-control', 'label' => false)); ?>
                <!--<div class="attach"><a href="#">Attach file</a> or drop file here</div>-->
             </div>
             
             <div class="form-group">
             	<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'purple-btn pull-right', 'label' => false, 'div' => false)); ?>
             </div>
             
            
         </div>
        
         
        </div>
         
    </div>
    </div>
    <!--main body section ends-->
  </div>


<script type="text/javascript">
    $(document).ready(function(){
    $('.number').keyup(function(){
        var value = $(this).val();
        if(isNaN(value)){
            $(this).val('');
        }
    })
    $('.creload').on('click', function() {
	var mySrc = $(this).prev().attr('src');
	var glue = '?';
	if(mySrc.indexOf('?')!=-1)  {
	    glue = '&';
	}
	$(this).prev().attr('src', mySrc + glue + new Date().getTime());
	return false;
     });

    $(document).find(".custom_option").select2();
    
    var prodValidator = $("#FeedbackFeedbackForm").kendoValidator({
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
    errorTemplate: "<dfn class='red-txt'>#=message#</dfn>"}).data("kendoValidator");
    });
</script>

