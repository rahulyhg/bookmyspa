<style>
    .image_width{
        width: auto !important;
    }
</style>
<div class="row">
<div class="col-sm-12">
        <div class="box">
            <?php  $check_user = $this->Session->read('User.employee_id');?>
                <div class="box-content">
                   <div class="form-wizard">
                        <div class="step" id="firstStep">
                                <ul class="wizard-steps steps-4">
                                        <li class='active first'>
                                          <?php if($check_user){ ?>
                                            <a href="javascript:void(0)" onclick='window.location.reload()'>   
                                        <?php } ?> 
                                            <div class="single-step">
                                                        <span class="title">
                                                                1</span>
                                                        <span class="circle">
                                                          <span class="active"></span>
                                                        </span>
                                                        <span class="description">
                                                                Profile
                                                        </span>
                                            </div>
                                           <?php if($check_user){ ?>
                                            </a>
                                       <?php } ?>       
                                        </li>
                                        <li class="second">
                                            <?php if($check_user){ 
                                                $login_url = $this->Html->url(array('controller'=>'SalonStaff','action'=>'staff_login','admin'=>true,$check_user));
                                                ?>
                                            <a href="javascript:void(0)" onclick="chnage_wizard_page('<?php echo $login_url;?>','.wizard-steps li.second','.wizard-steps li.third ,.wizard-steps li.first')">   
                                       <?php  } ?> 
                                                <div class="single-step">
                                                        <span class="title">
                                                                2</span>
                                                        <span class="circle">
                                                        </span>
                                                        <span class="description">
                                                                Login
                                                        </span>
                                                </div>
                                                <?php if($check_user){ ?>
                                            </a> 
                                       <?php } ?> 
                                        </li>
                                        <li class="third">
                                              <?php if($check_user){ 
                                                $login_url = $this->Html->url(array('controller'=>'SalonStaff','action'=>'contact','admin'=>true,$check_user));
                                                ?>
                                            <a href="javascript:void(0)" onclick="chnage_wizard_page('<?php echo $login_url;?>','.wizard-steps li.third','.wizard-steps li.first ,.wizard-steps li.second')">   
                                       <?php    } ?> 
                                                <div class="single-step">
                                                        <span class="title">
                                                                3</span>
                                                        <span class="circle">
                                                        </span>
                                                        <span class="description">
                                                                Contact
                                                        </span>
                                                </div>
                                                 <?php if($check_user){ ?>
                                            </a> 
                                        <?php    } ?> 
                                        </li>
                                </ul>
                                <div class="formChange">
                                <?php echo $this->Form->create('User',array('novalidate','type' => 'file','class'=>'form-vertical'));?>
                                <?php echo $this->Form->input('typechk',array('div'=>false,'label'=>false,'id'=>'typechk','value'=>0,'style'=>'display:none;')); ?>
                                <?php echo $this->Form->input('typename',array('div'=>false,'label'=>false,'id'=>'typename','value'=>0,'style'=>'display:none;')); ?>
                               
                                <div class="step-forms clearfix col-sm-9">
                                        <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="firstname" class="control-label"><?php echo __('First name' , true); ?> *:</label>
                                                <div >
                                                        <?php echo $this->Form->input('first_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'58','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"First name is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 55 characters.",'data-pattern-msg'=>"Please enter only alphabets.",'maxlengthcustom'=>'55')); ?>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label for="anotherelem" class=" control-label"><?php echo __('Last name' , true); ?> *:</label>
                                                <div >
                                                        <?php echo $this->Form->input('last_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'58','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Last name is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 55 characters.",'data-pattern-msg'=>"Please enter only alphabets.","maxlengthcustom"=>'55')); ?>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label for="additionalfield" class="control-label"><?php echo __('Email' , true); ?> *:</label>
                                                <div>
                                                        <?php echo $this->Form->input('email',array('type'=>'email','label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>"Email is required.",'data-email-msg'=>"Please enter valid email address.","maxlength"=>"55")); ?>
                                                </div>
                                                <?php  $userCheck_id = (isset($this->request->data['User']['id']) && !empty($this->request->data['User']['id'])) ?$this->request->data['User']['id']:''; ?>
                                                <div id='UseremailCheck' style='display: none'><?php echo $userCheck_id; ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="additionalfield" class="control-label"><?php echo __('Price Level', true); ?> *:</label>
                                            <div>
                                            <div>
                                                <?php echo $this->Form->input('pricing_level_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_price_level(), 'empty' => 'Select employee Access Level','required','validationMessage'=>"Pricing level is required.",'value'=>@$priceLevel['PricingLevelAssigntoStaff']['pricing_level_id'])); ?>
                                            </div>
<!--                                            <div class="col-sm-6 rgt-p-non">
                                            <?php //echo $this->Form->button('Add Pricing Level',array('type'=>'button','label'=>false,'div'=>false,'class'=>'btn btn-primary add_pricing_level')); ?>
                                            </div>-->
                                            </div>
                                        </div>
                                        <div class="form-group pad">
                                            <label for="additionalfield" class=" control-label"><?php echo __('Birth Date' , true); ?>:</label>
                                            <div class="col-sm-12 nopadding">
                                            <div class="col-sm-4 " style="padding-left:0;">
                                              <?php echo $this->Form->day('UserDetail.dob',array('empty'=>'Date','type'=>'date','label'=>false,'div'=>FALSE,'class'=>'form-control','required'=>false)); ?>
                                            </div>
                                            <div class="col-sm-4 nopadding">
                                              <?php echo $this->Form->month('UserDetail.dob',array('empty'=>'Month','type'=>'date','label'=>false,'div'=>FALSE,'class'=>'form-control','required'=>false)); ?>
                                            </div>
                                            <div class="col-sm-4" style="padding-right:0;">
                                              <?php echo $this->Form->year('UserDetail.dob', 1900, date('Y'),array('empty'=>'Year','class'=>'form-control','required'=>false)); ?>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class='col-sm-6'>
                                            <div class='col-sm-12 nopadding emp-gender-radio'>
                                                <div class='col-sm-4 lft-p-non'>
                                                    <div class="form-group">
                                                            <label for="additionalfield" class="lft-p-non col-sm-12 control-label"><?php echo __('Gender' , true); ?> :</label>
                                                            <div class='col-sm-12  nopadding'>
                                                            <div class='col-sm-12 mrgn-btm10 nopadding'>
                                                                <?php
                                                                $gender = 'female';
                                                                if(!empty($user['UserDetail']['gender'])){
                                                                     $gender=$user['UserDetail']['gender'];
                                                                }
                                                                $options=array('male'=>'Male','female'=>'Female');
                                                                $attributes=array('label'=>array('class'=>'new-chk'),'legend'=>false ,'separator'=> '</div><div class="col-sm-12  nopadding">','value'=>$gender);
                                                                echo $this->Form->radio('UserDetail.gender',$options,$attributes);
                                                                ?>
                                                            </div>
                                                            <div class="radio_error"></div>    
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-8 rgt-p-non'>
                                                    <div class="form-group stfImg">
                                                        <label for="additionalfield" class="control-label"><?php echo __('Image' , true); ?> :</label>
                                                         <div class="clearfix emp-blank-img emp-detail-box text-center emp-unique-img">
                                                            <?php
                                                            //pr($user);exit;
                                                                //$user  = $this->Session->read('Auth'); 
                                                                if(!empty($user['User']['id'])){ ?>
                                                                    <div class="emp-photo added ">
                                                                        <?php $image_exist = (empty($user['User']['image']))?'none':''; ?>
                                                                        <div class="img-change-option" style="display:<?php echo $image_exist; ?> ">
                                                                            <?php echo $this->Html->link('change','javascript:void(0)',array('data-id'=>$user['User']['id'],'class'=>'editUImg')) ?>
                                                                            <?php echo $this->Html->link('delete','javascript:void(0)',array('data-id'=>$user['User']['id'], 'data-image_name'=>$user['User']['image'],'class'=>'deleteUImg')) ?>
                                                                        </div>
                                                                        <div class="middle-img-box">
                                                                        <?php if($user['User']['image']){ 
                                                                                    echo $this->Html->Image('/images/' . $user['User']['id'] . '/User/200/' . $user['User']['image'],array('alt'=>'Image','title'=>'change Image' ,'class'=>'imageView'));
                                                                                }else{
                                                                                    echo $this->Html->Image('/img/admin/add-usephoto.png',array('class'=>'imageView upUImg image_width'));
                                                                                    echo '<span>ADD PHOTO</span>';
                                                                                } ?>
                                                                        </div>
                                                                    <?php
                                                                          echo $this->Form->input('image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'class'=>'theImage'));
                                                                      ?>
                                                                    </div> 
                                                                    
                                                                <?php }else{ ?>
                                                                <input type="hidden" name="resize" value="" id="resize">
                                                                        <a class="emp-photo add_image" href="javascript:void(0)">
                                                                            <?php echo $this->Html->image('add-usephoto.png') ?>
                                                                            <span>ADD PHOTO</span>
                                                                        </a>
                                                                          <div class="empImg" style="display: none">                                  
                                                                            <?php echo $this->Form->input('image',array('id'=>'fileChooser','type'=>'file','label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level','onChange'=>'return ValidateFileUpload(this)')); ?>
                                                                         </div>
                                                              <?php } ?>
                                                            
                                                         </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="form-group">
                                                <label for="additionalfield" class="control-label">My Bio</label>
                                                <div>
                                                        <?php echo $this->Form->textarea('UserDetail.bio',array('label'=>false,'div'=>false,'class'=>'form-control','rows'=>3,'col'=>20,'maxlength'=>'1000','data-maxlength-msg'=>"Maximum 1000 characters.")); ?>
                                                </div>
                                                <div id="incorrect-word-list"></div>
                                                <dfn ><span ><a href="javascript:void(0);" class="spellCheck" >Spell Check</a></span><span class="pull-right"><span class="biocnt">1000</span> characters</span></dfn>
                                        </div>
                                        </div>
                                    </div>
                       <div class="clearfix"></div>
                        <div class="form-actions text-right col-sm-9 clearfix">
                     
                            <?php
                            if(isset($user) && (!empty($user))){
                                echo $this->Form->button('Save and Continue',array(
                                'type'=>'submit','label'=>false,'div'=>false,
                                'class'=>'btn btn-primary submitUser'));
                            }else{
                                echo $this->Form->button('Cancel',array(
                                'type'=>'reset','label'=>false,'div'=>false,
                                'class'=>'btn mrgn-rgt10','onClick'=>'staffPage()'));
                                
                                echo $this->Form->button('Next',array('type'=>'submit','class'=>'btn btn-primary submitUser','label'=>false,'div'=>false));
                            }
                            ?>
                        </div>
                      <?php 
                        echo $this->Form->input('id',array('type'=>'hidden')); 
                        echo $this->Form->input('UserDetail.id',array('type'=>'hidden'));
                        echo $this->Form->input('Contact.id',array('type'=>'hidden'));
                        echo $this->Form->input('Address.id',array('type'=>'hidden'));
                      ?>
                    <?php echo $this->Form->end();?>
                         </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript' src='/../JavaScriptSpellCheck/include.js' ></script>
<script type='text/javascript'> $Spelling.SpellCheckAsYouType('UserDetailBio')</script>
<script>

    function UserDetailBiocnt(){
        var theCnt = $(document).find('#UserDetailBio').val();
        var bioLen = parseInt(theCnt.length);
        $(document).find('.biocnt').html(1000 - bioLen);
    }
    $(document).ready(function(){
        $(document).on('click','.emp-photo.add_image', function(){
            $('#fileChooser').click(); 
        });
        
        $(document).on('click','.spellCheck',function(){
            $Spelling.SpellCheckInWindow('UserDetailBio');
        });
        $(document).on('keyup','#UserDetailBio',function(){
            UserDetailBiocnt();
        });
        UserDetailBiocnt();
        
        $(document).on('blur' , '.livespell_textarea',function(e){
            $(this).removeClass('purple-bod');
        });
         $(document).on('click' , '.livespell_textarea',function(e){
           $(this).addClass('purple-bod');
        });
        
        /****************pricing level *********************/
        var $bigmodal = $('#commonContainerModal');
        $(document).on('click','.add_pricing_level' ,function(){
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'add','admin'=>TRUE)); ?>";
            fetchModal($bigmodal,addeditURL);
        });
        $bigmodal.on('click', '.update', function(e){
            var options = {
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success: function(res){
                    if (onResponse($bigmodal, 'PricingLevel', res)){
                        var res = jQuery.parseJSON(res);
                        itsId = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'priceDropDown' ,'admin'=>TRUE)); ?>"; 
                        itsId = itsId+'/'+res.price_id;
                        $(".price_level_drop_down").load(itsId,function(){
                            
                        });
                    }
                }
            };
            $('#PricingLevelAdminAddForm').submit(function() {
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        $('.datepicker').datepicker({
           format: 'yyyy-mm-dd',
        });
        
            var validator = $("#UserAdminAddForm").kendoValidator({
                rules:{
                    minlength: function (input) {
                        return minLegthValidation(input);
                    },
                    maxlengthcustom: function (input) {
                        return maxLegthCustomValidation(input);
                    },
                    pattern: function (input) {
                        return patternValidation(input);
                    }
                },
                errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
        
            $modal = $(document);
            var staffSubmit = 'yes';
            $(document).on('click', '.submitUser', function(){
                var options = { 
                        success:function(res){
                         // onResponse function in modal_common.js
                        if(onResponse($modal,'User',res,true)){
                            login_url = '<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'staff_login','admin'=>true)); ?>';
                            $('.formChange').load(login_url,function(){
                            $('.wizard-steps li.second').addClass('active');
                            $('.wizard-steps li.first').removeClass('active');
                            callRequired();
                        }); 
                        }else{
                            staffSubmit = 'yes';
                        }
                    }
                }; 
                $('#UserAdminAddForm').submit(function(){
                    if(validator.validate()){
                        var val = $(document).find('#typechk').val();
                        var name = $(document).find('#typename').val();
                        if(val == 6){
                            var msg = 'Our record indicates that the entered email address belongs to a Sieasta user by the name of "'+name+'". Is this the same person? By clicking OK Sieasta will use the same profile that already exists for "'+name+'". If you press CANCEL you will need to enter a different email address.';
                            if(!confirm(msg)){
                               $(this).unbind('submit');
                               $(this).bind('submit');
                               return false;
                            }
                        }
                        if(val != 5 && val != 6 && val != 0){
                            var msg = "The email address you have selected is belongs Account/Business Owner who is associated with the other Salon. Please chose different email address.";
                            alert(msg);
                            $(this).unbind('submit');
                            $(this).bind('submit');
                            return false;
                        }
                        if(staffSubmit == 'yes'){
                            $(this).ajaxSubmit(options);
                            staffSubmit = 'no';
                        }
                    }
                    $(this).unbind('submit');
                    $(this).bind('submit');
                    return false;
                });
            }); 
    /******************************** login Wizard *******************/
    var staffLogin = 'yes';
        $(document).on('click', '.submitUserlogin', function(){
            var options = { 
                success:function(res){
                    if(onResponse($modal,'User',res,true)){
                        login_url = '<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'contact','admin'=>true)); ?>';
                        $('.formChange').load(login_url,function(){
                        $('.wizard-steps li.third').addClass('active');
                        $('.wizard-steps li.second').removeClass('active');
                        callRequired();
                    }) 
                    }else{
                      staffLogin = 'yes';  
                    }
                }
            };
            
            $('#UserAdminStaffLoginForm').submit(function(){
                if($('#UserAdminStaffLoginForm').valid()){
		  if(staffLogin == 'yes'){
                    $(this).ajaxSubmit(options);
                    staffLogin = 'no';
                  }
                  
		}
                $(this).bind('submit');
                return false;
            });
        });
        
          var staffcontact = 'yes';
        
 /********************************contact******************************/ 
        $(document).on('click', '.submitUsercontact', function(){
        var options = { 
                success:function(res){
                    if(onResponse($modal,'User',res,true)){
                        var emp_data = jQuery.parseJSON(res);
                        login_url = '<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'index','admin'=>true)); ?>';
                        working_hours = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'open_hours','admin'=>true)); ?>/'+emp_data.uid+'/'+'staff';
                        open_url = (emp_data.emp_type=="2")?working_hours:login_url;
                        window.location.href=open_url;
                    }else{
                       staffcontact = 'yes';  
                    }
                }
            }; 
            $('#UserAdminContactForm').submit(function(){
                     if($('#UserAdminContactForm').valid()){
                        if(staffcontact=='yes'){
                            $(this).ajaxSubmit(options);
                            staffcontact = 'no';
                        }
                    }
                    $(this).unbind('submit');
                    $(this).bind('submit');
                    return false;
                });
        });
        
        
        $(document).on('blur','#UserEmail',function(){
            var userEmail = $(this).val();
            var userchckId = $.trim($('#UseremailCheck').text());
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'findUserViaEmail','admin'=>true))?>",
                type: "POST",
                data: {email:userEmail , user_id:userchckId},
                success: function(res) {
                    var data = jQuery.parseJSON(res);
                    if(data.data == 'success'){
                        $(document).find('#typechk').val(data.type);
                        $(document).find('#typename').val(data.name);
                    }
                    else{
                        $(document).find('#typechk').val(0);
                        $(document).find('#typename').val(''); 
                    }
                }
            });
        });
        
        /********************************Image Upload Code***************************************************/
         $(document).on('click', '.editUImg', function() {
                  userId = $(this).attr('data-id');
                  $('#UserImage').click();
             });   
         $(document).on('click', '.upUImg', function() {
                  userId = $('.editUImg').attr('data-id');
                  $('#UserImage').click();
             });  
        
        
        $(document).on('change', ".theImage", function(e){
                e.preventDefault();
                    
                file = this.files[0];
                var obj = $(this);
                var valReturn = validate_image(file);
                if(valReturn){
                    obj.val('');
                    alert(valReturn);
                    return false;
                }
                else{
                    var formdata = new FormData();
                    var fileInput = '#UserImage';
                    formdata.append('image', file);
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
			    var resize = '';
			    var thecheckimage = checkstaffimage(parseInt(w),parseInt(h),kbs);
			    if(thecheckimage == 'resize'){
				resize = '1';
				thecheckimage = 'success';
			    }
			    if(thecheckimage == 'success'){
                                $.ajax({
                                    url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'upload_staff_image'))?>"+"/"+userId,
                                    type: "POST",
                                    data: formdata,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {
                                        if (res != 'f') {
                                            $(document).find('.imageView').attr('src', '/images/' + userId + '/User/200/' + res).removeClass('upUImg image_width');
                                            $(document).find('.middle-img-box span').remove();
                                            $('#UserImage').val('');
                                            $('.img-change-option').attr('style','');
                                        } else {
                                            alert('Error in Uploading Image. Please try again!');
                                        }
                                    }
                                });
                                //img.src = reader.result;
                                reader.readAsDataURL(this.files[0]);    
                            }else{
				if(thecheckimage == 'size-error'){
                                    $(document).find(fileInput).val('');
				    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
				    $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
				    alert('Images should be upto 350 KB in size');

				}else if(thecheckimage == 'limit-error'){
                                    $(document).find(fileInput).val('');
				    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
				    $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
				    alert('Images should be landscape (wide, not tall) and minimum width of 600 pixels and height of 300 pixels are required.');

				}else if(thecheckimage == 'resize-error'){
                                    $(document).find(fileInput).val('');
				    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
				    $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
				    alert('Images should be in the ratio of 2:1.');

				}
                            }
                            
                        };
                        image.onerror= function() {
                            alert('Invalid file type: '+ file.type);
                        };      
                    };
                }
                

                });     
                
            $(document).find('.deleteUImg').click(function(){
                userId = $(this).attr('data-id');
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'deleteImage','admin'=>false))?>",
                    type: "POST",
                    data: {id: userId},
                    success: function(res) {
                        $('#UserImage').val('');
                        if (res != 'f') {
                          $(document).find('.imageView').attr('src', '/img/admin/add-usephoto.png');
                          $('.middle-img-box img').addClass('upUImg image_width');
                          $('.middle-img-box img').after('<span>ADD PHOTO</span>');
                          $('.img-change-option').attr('style',"display:none;");
                        } else {
                            alert('Error in Deleting Image. Please try again!');
                        }
                    }
                });
        });
});

 /* Image preview fuction */
function readURL(input){
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e){
              $('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
 function staffPage(){
    window.location.href="<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'index','admin'=>true));?>";
 }
 
 function chnage_wizard_page(wizard_url,add,remove){
        $('.formChange').load(wizard_url,function(){
            $(add).addClass('active');
            $(remove).removeClass('active');
            callRequired();
        })  
 }
 
 function ValidateFileUpload(input) {
        var fuData = document.getElementById('fileChooser');
        var FileUploadPath = fuData.value;
        var fileInput = '#fileChooser';
//To check if user upload any file
        if (FileUploadPath == '') {
            alert("Please upload an image");

        } else {
            var Extension = FileUploadPath.substring(
            FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

    //The file uploaded is an image
    if (Extension == "gif" || Extension == "png"  || Extension == "jpeg" || Extension == "jpg") {
                // To Display
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        var img = new Image;
                        img.onload = function() {
			    var imageheight = img.height;
			    var imageWidth = img.width;
			    var imageSize = input.files[0].size;
			    if(imageheight >=  imageWidth)
			    {
				$(document).find(fileInput).val('');
				var msg = 'Image should be landscape.'
				alert(msg);
				return false;
                            
			    }else if(imageheight < 275 || imageWidth < 550){
				$(document).find(fileInput).val('');  
				var msg = 'Minimum height and width of file should be 275 * 550'
				alert(msg);
				return false;
			    }else if(imageheight > 275 && imageWidth > 550){
				var ratio = (imageWidth / imageheight);
				if(ratio == 2){
				    $('.emp-blank-img.emp-detail-box a').css({"padding":"0"});
                                    $('.emp-photo.add_image').html('<img width="" height="" src="" alt="image" />');
                                    $('.emp-photo.add_image img').attr('src', e.target.result);
				    $('#resize').val('1');
				}else{
				    $(document).find(fileInput).val('');
				    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
				    $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
				    var msg = 'Image should be in the ratio of 2:1';
				    alert(msg);
                                    return false;
				}
			    }else{
				$('.emp-blank-img.emp-detail-box a').css({"padding":"0"});
                                $('.emp-photo.add_image').html('<img width="" height="" src="" alt="image" />');
                                $('.emp-photo.add_image img').attr('src', e.target.result);
				$('#resize').val('');
			    }
                        };
                             img.src = reader.result;
                        };
                  
                    reader.readAsDataURL(fuData.files[0]);
                }
            } 

//The file upload is NOT an image
            else {
                //                reset_form_element (fuData);
                $("#fileChooser").val('');
                alert("File doesnt match png, jpg or gif extension.");

            }
        }
    }
 
  

 
 
</script>
		