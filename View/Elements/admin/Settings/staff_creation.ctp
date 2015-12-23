<?php
    $readOnly = false;
    if(isset($this->data['User']['id']) == $auth_user['User']['id'] && in_array($auth_user['User']['type'],array(2,3,4)) ){
        $readOnly = true;
    }
 ?>
<?php

echo $this->Form->create('User', array('url' => array('controller' => 'Settings', 'action' => 'submitStaff','admin'=>true),'id'=>'staffCreationForm','novalidate'));?>  
<div class="col-sm-6">
    <div class="form-group clearfix">
        <label class="control-label col-sm-4 lft-p-non" >First Name<span style="color:red">*</span>:</label>
        <div class="col-sm-8  nopadding">
        <?php echo $this->Form->hidden('User.id',array('label'=>false,'div'=>false)); ?>
        <?php if(!$readOnly){ 
            echo $this->Form->hidden('User.parent_id',array('value'=>$auth_user['User']['id'],'label'=>false,'div'=>false));
            echo $this->Form->hidden('User.created_by',array('value'=>$auth_user['User']['id'],'label'=>false,'div'=>false));
            echo $this->Form->hidden('User.type',array('value'=>5,'label'=>false,'div'=>false));
            echo $this->Form->hidden('User.status',array('value'=>1,'label'=>false,'div'=>false)); 
        }?>
        <?php echo $this->Form->input('User.first_name',array('label'=>false,'div'=>false,'class'=>'form-control','required','minlength'=>'3','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"First Name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-pattern-msg'=>"Please enter only alphabets.",'maxlengthcustom'=>'50','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-4 lft-p-non" >Last Name<span style="color:red">*</span>:</label>
        <div class="col-sm-8  nopadding">
        <?php echo $this->Form->input('User.last_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Last Name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-pattern-msg'=>"Please enter only alphabets.",'maxlengthcustom'=>'50','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-4 lft-p-non" >Email<span style="color:red">*</span>:</label>
        <div class="col-sm-8 nopadding">
        <?php $patern = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$"; ?>
        <?php echo $this->Form->input('User.email',array('readonly'=>$readOnly,'label'=>false,'div'=>false,'class'=>'form-control','pattern'=>$patern,'data-pattern-msg'=>"Please enter a valid email address.",'required','validationMessage' => 'Business E-mail is required.','data-email-msg' => 'Please enter valid email address.',)); ?>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-4 lft-p-non" >Mobile<span style="color:red">*</span>:</label>
        <div class="col-sm-8 nopadding">
        <div class="col-sm-4 col-xs-4 nopadding">
        <?php
        $code = '';
        if(isset($auth_user['Address']['country_id']) && !empty($auth_user['Address']['country_id'])){
            $code = $this->Common->getPhoneCode($auth_user['Address']['country_id']);
        }
        echo $this->Form->input('Contact.country_code',array('type'=>'text','label'=>false,'value'=>$code,'div'=>false,'class'=>'form-control','readonly')); ?>
        </div>
        <div class="col-sm-8 col-xs-8 rgt-p-non">
        <?php echo $this->Form->hidden('Contact.id',array('label'=>false,'div'=>false)); ?>
        <?php echo $this->Form->input('Contact.cell_phone',array('label'=>false,'div'=>false,'class'=>'form-control numOnly','validationMessage' => 'Mobile phone is required.',)); ?>
        </div>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-4 lft-p-non" >Gender<span style="color:red">*</span>:</label>
        <div class="col-sm-8 nopadding">
        <?php echo $this->Form->hidden('UserDetail.id',array('label'=>false,'div'=>false)); ?>
        <?php
            $options = array('male' => 'Male', 'female' => 'Female');
            echo $this->Form->input('UserDetail.gender',array('options'=>$options,'div'=>false,'label'=>false,'class'=>'form-control','empty'=>'Please Select','validationMessage' => 'Gender is required.')); ?>
            <?php
            if(isset($validationErrors['UserDetail']['gender'][0]) && !empty($validationErrors['UserDetail']['gender'][0])){
                 echo '<div class="error-message">'.$validationErrors['UserDetail']['gender'][0].'</div>';
            }
            ?>
        </div>
    </div>
    <div class="form-group clearfix">
        <label class="col-sm-4 control-label lft-p-non"><?php echo __('Employee Type', true); ?><span style="color:red">*</span>:</label>
        <div class="col-sm-6 nopadding" >
            <?php echo $this->Form->input('UserDetail.employee_type', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_employee_type(), 'empty' => 'Select employee type','validationMessage' => 'Employee Type is required.',)); ?>
        </div>
        <div class="col-sm-2 pdng-tp7">
          <?php
             $text = "Role of the Employee for eg service provider,Booking incharge etc.";
             echo $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false,'class'=>'popover-test')); ?>
        </div> 
    </div>
    <?php if(!$readOnly){ ?>
    <div class="form-group clearfix">
        <label class="col-sm-4 control-label lft-p-non"><?php echo __('Access Level', true); ?><span style="color:red">*</span>:</label>
        <div  class="col-sm-6 nopadding">
            <?php echo $this->Form->input('group_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_employee_access_level(), 'empty' => 'Select employee Access Level','required','validationMessage' => 'Access Level is required.')); ?>
        </div>
        <div class="col-sm-2 pdng-tp7">
            <?php
               $text = "Manage Level of access to the Sieasta software which assigned to the staff.";
            echo $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false,'class'=>'popover-test')); ?>
         </div> 
    </div>
    
    <?php } ?>
    <div class="form-group clearfix pricelevelD">
        <label class="control-label col-sm-4 lft-p-non">Pricing Level<span style="color:red">*</span>:</label>
        <div class="col-sm-6 nopadding price_level_drop_down">
            <?php echo $this->Form->input('pricing_level_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_price_level(), 'empty' => 'Please Select','required'=>false,'validationMessage' => 'Pricing Level is required.')); ?>
            <input type="hidden" id="UserPricingLevelIdC" name="UserPricingLevelIdC" required  validationmessage="Pricing level is required." >
            <dfn class="text-danger k-invalid-msg" data-for="UserPricingLevelIdC" role="alert" style="display: none;">Pricing level is required.</dfn>
        </div>
         <div class="col-sm-2 pdng-tp7">
        <?php
           $text = "Assign different levels to staff to manage different pricing option to a service.";
        echo $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false,'class'=>'popover-test')); ?>
        </div> 
        <!--<div class="col-sm-4 lft-p-non pdng-tp4">
             <?php //echo $this->Form->button('<i class="fa fa-plus"> Pricing Level</i>',array('type'=>'button','escape'=>false,'title'=>'Add Pricing Level','label'=>false,'div'=>false,'class'=>'btn btn-primary add_pricing_level',)); ?>
        </div>-->
    </div>
    
</div>
<div class="col-sm-6">
    <div class="form-group clearfix">
        <label class="control-label col-sm-12  nopadding">Image:</label>
        <div class="col-sm-12 nopadding ">
            <?php echo $this->Form->input('User.image',array('label'=>false,'div'=>false,'type'=>'file','class'=>'form-control nopadding')); ?>
        </div>
    </div>
    <div class="form-group clearfix" style="text-align: center;">
        <?php
        if(isset($this->data['User']['image']) && !empty($this->data['User']['image'])){
            echo $this->Html->image('/images/'.$this->data['User']['id'].'/User/150/'.$this->data['User']['image'],array());
        } ?>
        
    </div>
    <div class="form-group clearfix">
        <label class="control-label col-sm-12 nopadding ">Bio:</label>
        <div class="col-sm-12 nopadding ">
            <?php echo $this->Form->input('UserDetail.bio',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="form-actions clearfix pull-right">
        <?php echo $this->Form->input('Save',array('type'=>'button','class'=>'saveStaff btn btn-primary','div'=>false,'label'=>false)); ?>
        <?php echo $this->Form->input('Cancel',array('type'=>'button','class'=>'cancelStaff btn ','div'=>false,'label'=>false)); ?>
    </div>
    
</div>
<?php echo $this->Form->end();?>
<script>
    var validatable = $("#staffCreationForm").kendoValidator({ rules:{
					  minlength: function (input) {
						  return minLegthValidation(input);
					  },
					  maxlengthcustom: function (input) {
						  return maxLegthCustomValidation(input);
					  },
					  pattern: function (input) {
						  return patternValidation(input);
					  },
					  matchfullprice: function (input){
						  return comparefullsellprice(input,"SalonService");
					  },
					  greaterdate: function (input){
					      if (input.is("[data-greaterdate-msg]") && input.val() != "") {                                    
						      var date = kendo.parseDate(input.val()),
							  otherDate = kendo.parseDate($("[name='" + input.data("greaterdateField") + "']").val());
						      return otherDate == null || otherDate.getTime() <= date.getTime();
						  }
						      return true;
					  }
				  },
				  errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
    
$(document).on('keyup','.numOnly' ,function(){
            var value = $(this).val();
            /*** Validation for mobile number first character never be zero ***/
            //if (value.length == 1 && value == 0 ){
              //  $(this).val('');
            //}
            
            if(isNaN(value)){
                $(this).val('');
            }
    });
    
    $(document).ready(function(){
        
        $(document).on('change','#UserDetailEmployeeType',function(){
            if($(this).val()==1){
                $(".pricelevelD").hide();
                 $('#UserPricingLevelIdC').val('1');
                $(document).find('dfn[data-for=UserPricingLevelIdC]').css('display','none');
                
            }else if($(this).val()==2){
                $(".pricelevelD").show();
                   $('#UserPricingLevelIdC').val('');
                $("#UserPricingLevelId").prop("required", true);;
            }else{
                   $('#UserPricingLevelIdC').val('');
                $(".pricelevelD").show();
                
            }
        });
        
         $(document).on('change','#UserPricingLevelId',function(){
            if($(this).val()=='')
            {
                 $('#UserPricingLevelIdC').val('');
                $(document).find('dfn[data-for=UserPricingLevelIdC]').css('display','inline');
            }else{
                $('#UserPricingLevelIdC').val('1');
                $(document).find('dfn[data-for=UserPricingLevelIdC]').css('display','none');
            }
         });
        $(document).on('change','#UserImage',function(){
           
                var theLimg = $(this);
                file = this.files[0];
                var obj = $(this);
                var valReturn = validate_image(file);
                if(valReturn){
                    obj.val('');
                    //alert(valReturn);
                }
                else{
                    var reader = new FileReader();
                    var image = new Image();
                    reader.readAsDataURL(file);
                    reader.onload = function(_file) {
                        image.src    = _file.target.result;              // url.createObjectURL(file);
                        image.onload = function() {
                            var w = this.width,
                                h = this.height,
                                t = file.type,                           // ext only: // file.type.split('/')[1],
                                n = file.name,
                                s = ~~(file.size/1024) +'KB';
                                var kbs = ~~(file.size/1024);
                                var status = checkstaffimage(parseInt(w) , parseInt(h) , kbs);
                                if(status == 'limit-error'){
                                    alert('Minimum height and width of file should be 275 * 550 . In case you would like us to resize and compress image please send it support@sieasta.com');
                                    $('#UserImage').val('');
                                }else if(status == 'size-error'){
                                    alert('Image should be upto 350kb . In case you would like us to resize and compress image please send it support@sieasta.com');
                                    $('#UserImage').val('');
                                }else if(status == 'resize-error'){
                                    alert('Image should be in the ratio of 2:1 . In case you would like us to resize and compress image please send it support@sieasta.com');
                                    $('#UserImage').val('');
                                }else if(status == 'success'){
                                    theLimg.closest('div').find('img').attr('src',image.src);
                                }
                            };
                        image.onerror= function() {
                            alert('Invalid file type: '+ file.type);
                        };      
                    };
                }   
            });    
    });
    
$(function () {
  $('.popover-test').popover();
})
    
</script> 