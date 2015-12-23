<?php echo $this->element('frontend/StaticPages/enqnavigation'); ?>
<div class="wrapper">
	<div class="container">
    <!--main body section starts-->
    <div class="col-sm-12 business">
    	<div class="well clearfix text-left custom_well">
           <?php echo $this->Form->create('BusinessEnquiry',array('novalidate'));?>
         <div class="col-sm-6">
             <div class="form-group">
                <label>Your Name *:</label>
		<?php echo $this->Form->input('BusinessEnquiry.name', array('type' => 'text', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Name is required.','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.",'pattern'=>'^[A-Za-z ]+$','data-pattern-msg'=>"Please enter only alphabets.",'maxlength'=>'50')); ?>
                <!--<input type="text" value="" class="form-control">-->
            </div>
            
             <div class="form-group">
                 <label>Nature of Business *:</label>
                 <?php echo $this->Form->input('BusinessEnquiry.nature_of_business', array('type' => 'text', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Nature of Business is required.','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.",'maxlength'=>'50')); ?>
             </div>
              
             <div class="form-group">  
                <label>E-mail *:</label>
                <?php echo $this->Form->input('BusinessEnquiry.email', array('type' => 'text', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Email is required.', 'data-msg-email' => 'Please enter valid email.','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.",'maxlength'=>'50')); ?>
             </div>
                
             <div class="form-group">  
                <label>Contact Address *:</label>
                <?php echo $this->Form->input('BusinessEnquiry.contact_address', array('type' => 'textarea', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Contact Address is required.','minlength'=>'8','data-minlength-msg'=>"Minimum 8 characters.",'maxlength'=>'500','data-maxlengthcustom-msg'=>"Maximum 500 characters.")); ?>
             </div>
         </div>
         <div class="col-sm-6">
             <div class="form-group">
                <label>Organisation / Company *:</label>
                <?php echo $this->Form->input('BusinessEnquiry.company', array('type' => 'text', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Organisation / Company is required.','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.",'maxlength'=>'50')); ?>
             </div>
            
             <div class="form-group">
                 <label>Contact Phone *:</label>
                 <?php echo $this->Form->input('BusinessEnquiry.contact_phone', array('type' => 'text', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Contact Phone is required.')); ?>
             </div>
                
             <div class="form-group">  
                <label>Details / Query *:</label>
                <?php echo $this->Form->input('BusinessEnquiry.detail_query', array('type' => 'textarea', 'class' => 'form-control', 'label' => false,'required','validationMessage'=>'Details / Query is required.','minlength'=>'8','data-minlength-msg'=>"Minimum 8 characters.",'maxlength'=>'500','data-maxlengthcustom-msg'=>"Maximum 500 characters.")); ?>
             </div>
             
             <div class="form-group">
		<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'purple-btn pull-right', 'label' => false, 'div' => false)); ?>
             </div>
         </div>
        <?php echo $this->Form->end(); ?>
         <div class="col-sm-12">
         	<h5>FOR MORE DETAILS, CONTACT</h5>
            <p><span class="purple">E-mail:</span> <a href="#" class="purple">biz@sieasta.com</a></p>
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
    
    
    var prodValidator = $("#BusinessEnquiryBusinessEnquiryForm").kendoValidator({
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
