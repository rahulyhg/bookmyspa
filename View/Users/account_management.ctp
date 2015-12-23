<style>
    .select2-container .select2-choice span {
            display: inline;
    }
</style>
<?php echo $this->element('frontend/User/all_tabs'); ?>
<!--tabs main navigation ends-->
<div class="wrapper">
	<div class="container my-orders">
        <div class="profile-top clearfix">
        	<div class="photo">
                    <?php
		      $img_name = $this->Common->get_image_stylist($UserDetail['User']['image'],
								$UserDetail['User']['id'],
								'User',150);
		     echo $this->Html->image($img_name ,array('width'=>'100','height'=>'100','data-id'=>$UserDetail['User']['id'],'class'=>'imageView'));
		      /* if(isset($UserDetail['User']['image']) && !empty($UserDetail['User']['image'])){
                         
			  echo $this->Html->image("/images/".$UserDetail['User']['id']."/User/150/".$UserDetail['User']['image'],array('width'=>'100','height'=>'100','data-id'=>$UserDetail['User']['id'],'class'=>'imageView'));
                      }else{
                          echo $this->Html->image("admin/upload2.png",array('width'=>'100','height'=>'100','class'=>'upUImg imageView','data-id'=>$UserDetail['User']['id']));
                      }  */
		      ?>
                      <?php
                      echo $this->Form->input('image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'class'=>'theImage'));
                      ?>
                    <div class="edit-icon">
                        <a  href="javascript:void(0);" escape="false" class="editUImg" data-id="<?php echo $UserDetail['User']['id']; ?>" >
                            <i class="fa fa-pencil"></i>
                        </a>                  
                        <a  href="javascript:void(0);" escape="false" class="deleteUImg" data-id="<?php echo $UserDetail['User']['id']; ?>" >
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </div>
                </div>
            <div class="photo-detail">
            	<h1><?php echo __('Welcome to your Profile',true); ?></h1>
                <h2><?php echo ucfirst($UserDetail['User']['first_name']).' '. $UserDetail['User']['last_name']; ?></h2> 
            </div>
        </div>
       
             <?php echo $this->Form->create('User',array('type' => 'file','class'=>'form-vertical','id'=>'accountManagement'));?>
            	<h3>Profile</h3>
         <div class="clearfix">
            <div class="profile-form-box">
            
                <h4>General info</h4>
            	<ul>
                    <li>
                    	<label><?php echo __('First  name',true); ?> *</label>
                        <section>
                            <?php echo $this->Form->input('first_name',array('label'=>false,'div'=>false,'class'=>'form-control','validationMessage'=>"First Name is required.",'required','maxlength'=>55,'data-maxlengthcustom-msg'=>"Maximum 55 characters.",'maxlengthcustom'=>'55')); ?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Last  name',true); ?> *</label>
                        <section>
                            <?php echo $this->Form->input('last_name',array('label'=>false,'div'=>false,'class'=>'form-control','validationMessage'=>"Last Name is required.",'required','maxlength'=>55,'data-maxlengthcustom-msg'=>"Maximum 55 characters.",'maxlengthcustom'=>'55')); ?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Login Email',true); ?> *</label>
                        <section>
			    <?php
				$patern = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$";
				echo $this->Form->input('email',array('label'=>false,'div'=>false,'class'=>'form-control','pattern'=>$patern,'data-pattern-msg'=>"Please enter a valid email address.",'required','validationMessage' => 'E-mail is required.','data-email-msg' => 'Please enter valid email address.','maxlength'=>100)); 
				if(empty($UserDetail['User']['is_email_verified'])){
                                   echo  $this->Html->link(__('Verify your email') , 'javascript:void(0)' , array('class'=>'verify_email','readonl;u'));
                                }
                            ?>			    
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('User name',true); ?></label>
                        <section>
                            <?php echo $this->Form->input('username',array('label'=>false,'div'=>false,'class'=>'','maxlength'=>'200','readonly'=>'readonly')); ?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Birthdate',true); ?> *</label>
                        <section>  
                            <section class="mm-b">
                                <?php echo $this->Form->month('UserDetail.dob',array('empty'=>'Month','type'=>'date','label'=>false,'div'=>FALSE,'class'=>'custom_option','validationMessage'=>'Month is required.','required'=>'required')); ?>
                            </section>
                            <section class="date-b">
                                  <?php echo $this->Form->day('UserDetail.dob',array('empty'=>'Day','type'=>'date','label'=>false,'div'=>FALSE,'class'=>'custom_option','validationMessage'=>'Date is required.','required'=>'required')); ?>
                            </section>
                            <section class="year-b">
                                <?php echo $this->Form->year('UserDetail.dob', 1900, date('Y'),array('empty'=>'Year','class'=>'custom_option','validationMessage'=>'Year is required.','required'=>'required')); ?>
                            </section>
                        </section>
                    </li>
                     <li>
                    	<label><?php echo __('Gender');?> *</label>
                        <section>
                          <section class="gender-input">
			  <?php
                            $gender = '';
                            if(!empty($UserDetail['UserDetail']['gender'])){
                                 $gender=$UserDetail['UserDetail']['gender'];
                            }
                            $options=array('male'=>'Male','female'=>'Female');
                            $attributes=array('legend'=>false,'separator'=>'</section><section class="gender-input">' ,'value'=>$gender,'label'=>array('class'=>'new-chk'),'validationMessage'=>'Gender is required.','required'=>'required');
                            echo $this->Form->radio('UserDetail.gender',$options,$attributes);
                            ?>
			  </section>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Maritial Status',true); ?> *</label>
                        <section class="col-sm-4" style="padding-left:0px">
                           <?php 
                           echo $this->Form->input('UserDetail.marital_status',array('options'=>array('S'=>'Single','M'=>'Married'),'class'=>'marital_status','div'=>false,'label'=>false,'empty'=>'Please Select','validationMessage'=>'Marital Status is required.','required'=>'required'));?>
                        </section>
                    </li>
                    <?php $display = ($UserDetail['UserDetail']['marital_status']=='M')?"block":"none"; ?>
                    <div class="martial" style="display: <?php echo $display; ?>"> 
                    <li>
                    	<label><?php echo __('Spouse DOB',true); ?> </label>
                        <section>  
                            <section class="mm-b">
                             <?php echo $this->Form->month('UserDetail.spouse_dob',array('empty'=>'Month','type'=>'date','label'=>false,'div'=>FALSE,'class'=>'custom_option')); ?>
                            </section>
                            <section class="date-b">
                                  <?php echo $this->Form->day('UserDetail.spouse_dob',array('empty'=>'Day','type'=>'date','label'=>false,'div'=>FALSE,'class'=>'custom_option')); ?>
                            </section>
                            <section class="year-b">
                                <?php echo $this->Form->year('UserDetail.spouse_dob', 1900, date('Y'),array('empty'=>'Year','class'=>'custom_option')); ?>
                            </section>
                        </section>
                    </li> 
                     <li>
                    	<label><?php echo __('Anniversary',true); ?> </label>
			 <section>  
			    <section class="mm-b">
				<?php echo $this->Form->month('UserDetail.anniversary',array('empty'=>'Month','type'=>'date','label'=>false,'div'=>FALSE,'class'=>'custom_option')); ?>
			    </section>
			    <section class="date-b">
				  <?php echo $this->Form->day('UserDetail.anniversary',array('empty'=>'Day','type'=>'date','label'=>false,'div'=>FALSE,'class'=>'custom_option')); ?>
			    </section>
			    <section class="year-b">
				<?php echo $this->Form->year('UserDetail.anniversary', 1900, date('Y'),array('empty'=>'Year','class'=>'custom_option')); ?>
			    </section>
			 </section>
                    </li>
                    </div>   
                </ul>
                <h4>Password info</h4>
                <ul class="bod-btm-non">
                    <li>
                    	<label><?php echo __('Current password',true); ?></label>
                        <section>
                             <?php echo $this->Form->input('old_pass', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control', 'maxlength' => '36','autocomplete'=>'off','data-maxlengthcustom-msg'=>"Maximum 36 characters.",'maxlengthcustom'=>'36','minlength'=>'8','data-minlength-msg'=>__("Minimum 8 characters.",true))); ?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('New password',true); ?></label>
                        <section>
                             <?php echo $this->Form->input('password1', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control', 'maxlength' => '36','autocomplete'=>'off','data-maxlengthcustom-msg'=>"Maximum 36 characters.",'maxlengthcustom'=>'36','minlength'=>'8','data-minlength-msg'=>__("Minimum 8 characters.",true))); ?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Confirm password',true); ?></label>
                        <section>
                          <?php echo $this->Form->input('con_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control',  'maxlength' => '36','autocomplete'=>'off','data-maxlengthcustom-msg'=>"Maximum 36 characters.",'maxlengthcustom'=>'36','minlength'=>'8','data-minlength-msg'=>__("Minimum 8 characters.",true))); ?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Select question',true); ?></label>
                        <section>
                            <?php echo $this->Form->input('security_question_id', array('label' => false,'div'=>false, 'options' => $this->common->get_security_question(), 'class' => '', 'empty' => 'Select question')); ?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Secret answer',true); ?></label>
                        <section>
                           <?php echo $this->Form->input('security_question_answer', array('type' => 'text', 'label' => false, 'div' => false, 'class' => '', 'maxlength' => '255')); ?>
                        </section>
                    </li>
                </ul>
            </div>
            
            <div class="profile-form-box mrgn-rgt0">
                <h4><?php echo __('Contact info',true); ?></h4>
		<?php $phonePatern = '\d{9}';?>
                <ul class="bod-btm-non">
                    <li>
                    	<label><?php echo __('Address',true); ?></label>
                        <section>
                              <?php echo $this->Form->input('Address.address',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>'3','cols'=>32)); ?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Country',true); ?> *</label>
                        <section>
                          <?php 
                          echo $this->Form->input('Address.country_id',array('class'=>'custom_optionCountry','options'=>$countryData,'div'=>false,'empty'=>'Please Select','label'=>false,'validationMessage'=>'Country is required.','required'=>'required'));?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Zip /Postal Code',true); ?> *</label>
                        <section>
                           <?php echo $this->Form->input('Address.po_box',array('type'=>'text','label'=>false,'div'=>false,'class'=>'number','maxlength'=>'10','data-maxlengthcustom-msg'=>"Maximum 10 digits." ,'maxlengthcustom'=>10,'validationMessage'=>'Zip /Postal Code is required.','required'=>'required')); ?>  
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('City',true); ?> *</label>
                        <section class="dynamicstate">
                            <?php echo $this->Form->input('Address.state_id',array('class'=>'','empty'=>'Please Select','div'=>false,'label'=>false,'options'=>$stateList ,'validationMessage'=>'City is required.','required'=>'required'));?>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Location / Area',true); ?> *</label>
                        <section class="dynamiccity" >
                         <?php echo $this->Form->input('Address.city_id',array('class'=>'','empty'=>'Please Select','div'=>false,'label'=>false ,'options'=>$cityList,'validationMessage'=>'Location / Area is required.','required'=>'required'));?>    
                        </section>
                    </li>
		    <li>
                    	<label><?php echo __('Mobile 1',true); ?> *</label> 
                        <section>
                            <section class="country-code">
				<?php echo $this->Form->input('phone_code', array('value'=>$phoneCode,'type' => 'text', 'label' => false, 'div' => false, 'class' => 'cPHcd', 'maxlength' => '10', 'required' => FALSE)); ?>
			    </section>
                            <section>
                                <?php echo $this->Form->input('Contact.cell_phone', array('type' => 'tel', 'label' => false, 'div' => false,'class'=>'form-control','pattern'=>$phonePatern,'data-pattern-msg'=>'Please enter atleast 9 digit number.','validationMessage' => 'Phone number is required.','maxlength'=>10,'id'=>'ContactCellPhone')); 
                                if((empty($UserDetail['User']['is_phone_verified'])) && (!empty($UserDetail['Contact']['cell_phone']))){
                                   echo $this->Html->link(__('Verify your number') , 'javascript:void(0)' , array('class'=>'verify_phone'));
                                } ?>
                            </section>
                        </section>
                    </li>
                    <li>
                        <label><?php echo __('Mobile 2', true); ?></label>
			<section> 
			     <section class="country-code">
				<?php echo $this->Form->input('phone_code', array('value'=>$phoneCode,'type' => 'text', 'label' => false, 'div' => false, 'class' => 'cPHcd', 'maxlength' => '10', 'required' => FALSE)); ?>
			     </section>
			    <section>
				<?php echo $this->Form->input('Contact.day_phone',array('type' => 'tel', 'label' => false, 'div' => false,'class'=>'form-control','pattern'=>$phonePatern,'data-pattern-msg'=>'Please enter atleast 9 digit number.','required' => 'false','maxlength'=>10)); ?>
			     </section>
			</section>
                    </li>
                    <li>
                    	<label><?php echo __('Mobile 3',true); ?></label>
                        <section>  
                                <section class="country-code">
				    <?php echo $this->Form->input('phone_code', array('value'=>$phoneCode,'type' => 'text', 'label' => false, 'div' => false, 'class' => 'cPHcd', 'maxlength' => '10', 'required' => FALSE)); ?>
                                </section>
				<section>
				       <?php echo $this->Form->input('Contact.night_phone',array('type' => 'tel', 'label' => false, 'div' => false,'class'=>'form-control','pattern'=>$phonePatern,'data-pattern-msg'=>'Please enter atleast 9 digit number.','required' => 'false','maxlength'=>10)); ?>
				</section>
                        </section>
                    </li>
                    <li>
                    	<label><?php echo __('Appointment Reminders By',true); ?> </label>
                        <section>
				<section class="chk-container">
				    <?php
				    echo $this->Form->input('Contact.reminder_email', array('type' => 'checkbox', 'default'=>1, 'label' => array('class' => 'new-chk', 'text' => 'email'), 'div' => false, 'class' => '', 'after' => ''));
				    ?>
				</section>
				<section class="chk-container">
				  <?php
				    echo $this->Form->input('Contact.reminder_sms_text', array('type' => 'checkbox',  'default'=>1, 'label' => array('class' => 'new-chk', 'text' => 'SMS/Text '), 'div' => false, 'class' => '', 'after' => ''));
				    ?>
				</section>
			</section>
                    </li>
                    <li>
                    	<label><?php echo __('Special Announcement Email',true); ?> </label>
                        <section>
                            <section class="chk-container">
                               <?php echo $this->Form->input('Contact.special_announcement_email', array('type' => 'checkbox', 'label' => array('class' => 'new-chk', 'text' => 'Allow business that I have used to send special announcement emails'), 'div' => false, 'class' => 'H', 'after' => '')); ?>
                            </section>
                        </section>
                    </li>
                </ul>
            </div>
                          <?php echo $this->Form->input('id',array('type'=>'hidden')); 
                                echo $this->Form->input('UserDetail.id',array('type'=>'hidden'));
                                echo $this->Form->input('Contact.id',array('type'=>'hidden'));
                                echo $this->Form->input('Address.id',array('type'=>'hidden')); 
//                                echo $this->Form->input('User.status',array('type'=>'hidden','value'=>1)); 
                          ?>
             </div>	
                <div class="profile-btns">
             <!--<button type="submit" class="purple-btn">Save</button>-->
	      <?php echo $this->Form->button(__('Save'), array('label' => false, 'div' => false, 'class'=>"purple-btn")); ?>
        </div>
            <?php $this->Form->end(); ?>
    </div>
</div> 
<script>
$(document).ready(function(){
 
    $(document).on('change' ,'#UserDetailMaritalStatus',function(){
       if($(this).val()=='M'){
          $('.martial').show();
        }else{
           $('.martial').hide();
       }
    });
    
    
      $('#UserAccountManagementForm select').not('.custom_optionCountry').select2();
      var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
             $(document).on('change','#AddressCountryId',function() {
                var id = $(this).val();
                var country = $(this).children("option").filter(":selected").text();
                $('.dynamicstate').load(getStateURL+'/'+id,function(){
                            $(document).find('.dynamicstate label').remove();
                             $(document).find('.dynamicstate select').removeClass('form-control').select2();
                    });
             });     
         
           var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
            $(document).on('change','#AddressStateId',function() {
              var id = $(this).val();
              var country = $(this).children("option").filter(":selected").text();
              $('.dynamiccity').load(getCityURL+'/'+id,function(){
                $(document).find('.dynamiccity label').remove();
                 $(document).find('.dynamiccity select').removeClass('form-control').select2();
                });
            }); 
                
            $(document).on('click', '.editUImg , .upUImg', function() {
                 userId = $(this).attr('data-id');
                 $(this).parent().prev().click();
             });   
                
             $(document).on('change', ".theImage", function(e) {
                    e.preventDefault();
                    file = this.files[0];
                    var obj = $(this);
                    if (file == undefined) {
                        var msg = 'Please select an image.'
                    }
                    else {
                        name = file.name;
                        size = file.size;
                        type = file.type;
                        if (file.name.length < 1) {
                            var msg = 'Please select an image.'
                            alert(msg);
                        }
                        else if (file.size > 1500000) {
                            obj.prev().val('');
                            var msg = 'File is toobig.'
                            alert(msg);
                        }
                        else if (file.type != 'image/png' && file.type != 'image/jpg' && !file.type != 'image/gif' && file.type != 'image/jpeg') {
                            obj.prev().val('');
                            var msg = 'File doesnt match png, jpg or gif extension.'
                            alert(msg);
                        } else {
                            var formdata = new FormData();
                            formdata.append('image', file);
                            obj.prev().val('');
                            $.ajax({
                                url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'upload_image'))?>"+"/"+userId,
                                type: "POST",
                                data: formdata,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    if (res != 'f') {
                                        $(document).find('.imageView').attr('src', '/images/' + userId + '/User/150/' + res).removeClass('upUImg');
                                    } else {
                                        alert('Error in Uploading Image. Please try again!');
                                    }
                                }
                            });

                        }
                    }
                });     

    $(document).find('.deleteUImg').click(function(){
                    userId = $(this).attr('data-id');
                    $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'deleteImage'))?>",
                        type: "POST",
                        data: {id: userId},
                        success: function(res) {
                            if (res != 'f') {
                                 $(document).find('.imageView').attr('src', '/img/admin/upload2.png');
                            } else {
                                alert('Error in Deleting Image. Please try again!');
                            }
                        }
                    });
                });
                
  /**********************************phone varification*************************************************************/              
  
        var $sModal = $(document).find('#mySmallModal');
        $(document).on('click','.verify_email',function(e){
	    e.preventDefault();
	    $sModal.modal('hide');
            $url = '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'varify_email','admin'=>FALSE)); ?>';
	    $sModal.load($url,function(){
		$sModal.modal('show');
	    });
	});         
                
          $(document).on('click','.verify_phone',function(e){
	    e.preventDefault();
	    $sModal.modal('hide');
            $url = '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'varify_phone','admin'=>FALSE)); ?>';
	    $sModal.load($url,function(){
		$sModal.modal('show');
	    });
	});
	  
	$(document).on('click' ,'.checkPhoneCode', function(e){
	    e.preventDefault();
	    var userID = '<?php echo $this->Session->read('Auth.User.id');?>';
	    phone_code = $('#UserPhoneCode').val();
	    if(!phone_code){
		 alert('Kindly enter the phone OTP !!!');
		 return;
	    }
	    $.ajax({
		url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'varify_phone'))?>",
		type: "POST",
		data: {phone_token:phone_code,id:userID},
		success: function(res) {
		    if ($.trim(res) =='s') {
			alert('Your mobile no. is verified!!');
			$('.verify_phone').remove();
			$sModal.modal('toggle');
		    } else {
			alert('OTP not match!!!');
		    }
		}
	    });
	});
        
       
        $(document).on('submit' ,'#UserVarifyEmailForm', function(e){
                e.preventDefault();
                 email_code = $('#UserEmailCode').val();
                 if(!email_code){
                     alert('Kindly enter the email verfication code!!!');
                     return;
                 }
                 $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'varify_email','admin'=>false))?>",
                        type: "POST",
                        data: {email_code:email_code},
                        success: function(res) {
                            if ($.trim(res) =='d') {
                            alert('Your email is verified!!');
                            $('.verify_email').remove();
                            $sModal.modal('toggle');
                            } else {
                                alert('Email verification code is not match!!');
                            }
                        }
                });
        })
        
        $(document).on('click','.resend_phone',function(){
        userId = $(this).data('id');             
        $url = '<?php echo $this->Html->url(array('controller'=>'Business','action'=>'sendPhoneCode','admin'=>false))?>';
        $url = $url+'/'+userId;
                    $.ajax({
                           url: $url,
                           type: "POST",
                           data:{id:userId},
                           beforeSend: function (xhr) {
                               $('.ajax_indicator').show();
                            },
                           success: function(res) {
                                $('.ajax_indicator').hide();
                                if(res=='1'){
                                    alert('Otp sent successfully!!');
                                }else{
                                    alert('Some error occured!!'); 
                                }
                           }
                   });
           });
           
        $(document).on('click','.resend_email',function(){
        $Id = $(this).data('id'); 
        $email_token = $(this).data('secert');
        $calledFrom ='ctpFile'
	$tmp = null;
        $tempate='resend_verification_code'
        $url = '<?php echo $this->Html->url(array('controller'=>'Users','action'=>'sendEmailCode','admin'=>false))?>';
        $url = $url+'/'+$Id+'/'+$email_token+'/'+$calledFrom+'/'+$tmp+'/'+$tempate;
                    $.ajax({
                           url: $url,
                           type: "POST",
                           beforeSend: function (xhr) {
                               $('.ajax_indicator').show();
                            },
                           success: function(res) {
                                $('.ajax_indicator').hide();
                                if(res=='s'){
                                    alert('Verification code sent successfully.');
                                }else{
                                    alert('Some error occured!!'); 
                                }
                           }
                   });
           })
           
           /**************************************************country*****************************************/
           
             $(document).find(".custom_optionCountry").select2({
		
		formatResult    : formatFlags,
		formatSelection : formatFlags,
		escapeMarkup: function(m) { return m; }
                }).on("change", function(e){
                      
		       var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
                        if(e.val){
                            setphoneCode(e.val);
			    getIsoCode(e.val);
                }
        });
	     
	
	
	/************************************************ enable number in phone field ***********************/
	$('.number').keyup(function(){
	    console.log('hello');
	    var value = $(this).val();
	    if(isNaN(value)){
		$(this).val('');
	    }
	    
	});
	
	/***************************************************** form validation *******************************/
	var prodValidator ;

	prodValidator = $("#accountManagement").kendoValidator({
	rules:{
	    minlength: function (input) {
		return minLegthValidation(input);
	    },
	    maxlength: function (input) {
		return maxLegthValidation(input);
	    },
	    pattern: function (input) {
		return patternValidation(input);
	    },maxlengthcustom: function (input) {
		return maxLegthCustomValidation(input);
	    },
	},
	errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
        $("#accountManagement select").select2();
        
        $(document).on('change','#UserDetailDobMonth ,#UserDetailDobDay ,#UserDetailDobYear' ,function(e){
            custom_error($(this)); 
        });
        
        $("#ContactCellPhone").keypress(function(){
            $(".verify_phone").hide();            
        });
        
});


 function formatFlags(state){
	   
		if (!state.id) return state.text; 
		return "<img style='padding-right:10px;' class='pos-rgt flag' src='/img/flags/" + state.id.toLowerCase() + ".gif'/><span class='state-name' >" + state.text + "</span>";
	}
	
 function getIsoCode(id){
     $.ajax({
		url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getIsoCode','admin'=>false))?>"+'/'+id,
		success: function(res) {
		    //console.log(res);
		}
            });
}

    function setphoneCode(id){
            $.ajax({
                  url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
                  success: function(res) {
                      $(document).find('.cPHcd').val(res);
                  }
            });
    }
    
    
    // custom error on form field change
    function custom_error(ref){
       if(ref.val()){
            ref.next('.text-danger.k-invalid-msg').css({
                'display':'none'
            });
            ref.prev('div').removeClass('k-invalid');
        }else{
            if(ref.next('.text-danger.k-invalid-msg').length == 0) {
             ref.after('<dfn class="text-danger k-invalid-msg" data-for="data[Address][address]" role="alert" style="display: inline;">'+ref.attr('validationmessage')+'</dfn>');  
            }else{
                 ref.next('.text-danger.k-invalid-msg').css({'display':'inline'});
             }
             ref.prev('div').addClass('k-invalid');
	     //console.log(ref.prev('div'));
	     //ref.prev('div').addClass('k-invalid'); 
        }
   }     
</script>