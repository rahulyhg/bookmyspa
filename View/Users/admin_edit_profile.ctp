 
 <?php echo $this->Html->script('bootbox');  ?>
<style>
 .text-danger{
      float: left;
 }
  
</style>
<div class="row">

    <div class="col-sm-12">
        <div class="box box-color box-bordered">
           <div class="box-title">
                <h3>
                    <i class="icon-edit"></i>
                    Edit Profile
                </h3>
            </div>
            <?php //pr($this->request->data); die; ?>
             <div class="box-content">
                    <div class="row">
                 <?php echo $this->Form->create('User',array('novalidate','type' => 'file','class'=>'form-horizontal')); ?>
                       <div class="col-sm-6">
                    <div class="form-group">
                                <!--<label class="col-sm-2 control-label"></label>-->
                                <div class="col-sm-5">
                                     <h3><i class="icon-user"></i>  Profile</h3>
                                </div>
                            </div>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">First Name *:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('first_name',array('class'=>'form-control','label'=>false,'required','validationMessage'=>"Please enter first name."));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Last Name *:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('last_name',array('class'=>'form-control','label'=>false,'required','validationMessage'=>"Please enter last name."));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email*:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('email',array('class'=>'form-control','label'=>false,'required','validationMessage'=>"Please enter email.", 'data-email-msg' => 'Please enter valid email.'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Username *:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('username',array('class'=>'form-control','label'=>false,'required','validationMessage'=>"Username is required.",'minlength'=>'3','maxlength'=>'56','required','validationMessage'=>"Username is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 55 characters." ,"maxlengthcustom"=>'55'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date Of Birth *:</label>
                                <div class="col-sm-5">
                                <?php echo $this->Form->hidden('UserDetail.id',array());?>
                                    <?php
                                        echo $this->Form->input('UserDetail.dob', array('type'=>'text','class'=>'datepicker form-control','label' => false,'required','validationMessage'=>"Please enter date of birth."));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Gender *:</label>
                                <div class="col-sm-2">
                                 <?php
                                    $options = array('male' => 'Male', 'female' => 'Female');
                                    $attributes = array('legend' => false,'label'=>array('class'=>'new-chk'),'separator'=> '</div><div class="col-sm-3">','required'=>true,'validationMessage'=>"Please select gender.",'default'=>'male');
                                    echo $this->Form->radio('UserDetail.gender', $options, $attributes);
                                 ?>
                                </div>
                            </div>
                         
                           <div class="form-group">
                                    <label class="col-sm-3 control-label" for="input01">Image : </label>
                                        <div class="col-sm-5">
                                            <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'input-fluid','onchange'=>'readURL(this)')); ?>
                                         <div class="preview">
                                          <?php   if(!empty($this->request->data['User']['image'])){
                                          echo $this->Html->Image('/images/'.$auth_user['User']['id'].'/User/150/'.$this->request->data['User']['image']);
                                       }
                                       ?> 
                                        </div>
                                    </div>
                            </div>
                        </fieldset>
                     </div>
                     <div class="col-sm-6">
             <div class="form-group">
                               <!-- <label class="col-sm-2 control-label"></label>-->
                                <div class="col-sm-7">
                                     <h3> <i class="icon-phone"></i> Contact Information</h3>
                                </div>
                            </div>
                        <fieldset>
                            <div class="form-group">
                                 <label class="col-sm-3 control-label"><?php echo __('Mobile 1',true); ?>*:</label>
                                 <div class="col-sm-7">
                                    <div class="col-sm-3 col-xs-4 nopadding">
                                        <input type="text" value="+971" class="cPHcd form-control" maxlength="11" >
                                    </div>
                                    <div class="col-sm-9 col-xs-8 rgt-p-non">
                                        <?php echo $this->Form->hidden('Contact.id',array());?>
                                        <?php echo $this->Form->input('Contact.cell_phone',array('type'=>'text','label'=>false,'class'=>'form-control  number','required','validationMessage'=>"Please enter Mobile 1.",'autocomplete'=>'off','maxlength'=>'11','minlength'=>9,'data-minlength-msg'=>"Minimum 9 characters.",'data-maxlengthcustom-msg'=>"Maximum 10 characters." ,"maxlengthcustom"=>'10'));  ?>
                                    </div>
                                  </div>
                            </div>
                            <div class="form-group">
                                 <label class="col-sm-3 control-label"><?php echo __('Mobile 2',true); ?>:</label>
                                 <div class="col-sm-7">
                                    <div class="col-sm-3 col-xs-4 nopadding">
                                        <input type="text" value="+971" class="cPHcd form-control" maxlength="11">
                                    </div>
                                    <div class="col-sm-9 col-xs-8 rgt-p-non">
                                        <?php echo $this->Form->input('Contact.night_phone',array('type'=>'text','label'=>false,'class'=>'form-control number','autocomplete'=>'off','maxlength'=>'11','minlength'=>9,'data-minlength-msg'=>"Minimum 9 characters.",'data-maxlengthcustom-msg'=>"Maximum 10 characters." ,"maxlengthcustom"=>'10'));  ?>
                                    </div>
                                   </div>
                            </div>
                            <div class="form-group">
                                 <label class="col-sm-3 control-label"><?php echo __('Mobile 3',true); ?>:</label>
                                 <div class="col-sm-7">
                                    <div class="col-sm-3 col-xs-4 nopadding">
                                        <input type="text" value="+971" class="cPHcd form-control" maxlength="11">
                                    </div>
                                    <div class="col-sm-9 col-xs-8 rgt-p-non">
                                        <?php echo $this->Form->input('Contact.day_phone',array('type'=>'text','label'=>false,'class'=>'form-control number','autocomplete'=>'off','maxlength'=>'11','minlength'=>9,'data-minlength-msg'=>"Minimum 9 characters.",'data-maxlengthcustom-msg'=>"Maximum 10 characters." ,"maxlengthcustom"=>'10'));  ?>
                                    </div>
                                   </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Address:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('Address.address',array('type'=>'text','class'=>'form-control','label'=>false,'div'=>false,'required'=>false,'id'=>'AddressAddress'));?>
                                      <?php echo $this->Form->hidden('Address.id',array());?>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-sm-3 control-label">Country *:</label>
                                <div class="col-sm-7">
                                    <?php echo $this->Form->input('Address.country_id',array('div'=>false,'class'=>'form-control','options'=>$countryData,'label'=>false));?>
                                </div>
                            </div>
                            <div class="form-group dynamicstate">
                                <label class="col-sm-3 control-label">City *:</label>
                                <div class="col-sm-7">
                                    <?php
                                       $stateList=array();
                                          if(isset($userInfo['Address']['country_id']) && !empty($userInfo['Address']['country_id'])){
                                             $stateList =  $this->Common->getStatesbyCid($userInfo['Address']['country_id']);
                                          }
                                          
                                          echo $this->Form->input('Address.state_id',array('div'=>false,'class'=>'form-control','empty'=>'Please Select','label'=>false,'options'=>$stateList,'required','validationMessage'=>"Please select city."));
                                    ?>
                                </div>
                            </div>
                              <div class="form-group dynamiccity">
                                <label class="col-sm-3 control-label">Location/Area *:</label>
                                <div class="col-sm-7">
                                    <?php
                                $cityList=array();
                                if(isset($userInfo['Address']['state_id']) && !empty($userInfo['Address']['state_id'])){
                                  $cityList =  $this->Common->getCitiesbySid($userInfo['Address']['state_id']);
                                 
                                }
                                echo $this->Form->input('Address.city_id',array('div'=>false,'class'=>'form-control','empty'=>'Please Select','label'=>false,'options'=>$cityList,'required','validationMessage'=>"Please select Location/Area."));?>
                                </div>
                            </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-7 text-right">
                                   <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary ','label'=>false,'div'=>false));?>
                                
                            <?php echo $this->Form->button('Cancel',array(
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn',
                                            'onclick'=>"location.href = '".$this->Html->url(array('controller'=>'Dashboard','action'=>'index','admin'=>true))."';")); ?>
                                </div>
                            </div>
                        </fieldset>
                   
                    </div>
              
                <!--<div class="row">
                    <div class="col-sm-6 text-center">
                         </br><?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary ','label'=>false,'div'=>false));?>
                                
                            <?php echo $this->Form->button('Cancel',array(
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn',
                                            'onclick'=>"location.href = '".$this->Html->url(array('controller'=>'Dashboard','action'=>'index','admin'=>true))."';")); ?>
                      
                    </div>
                     
                </div>-->
                <?php echo $this->Form->end();?>
               
               
            </div>
          
           
           </div>
      </div>
       
    </div>
</div>
<?php $dob= date('Y-m-d',strtotime($this->request->data['UserDetail']['dob']));  ?>
<script type="text/javascript">
var dob='<?php echo date('Y-m-d',strtotime($this->request->data['UserDetail']['dob']));  ?>';
      $('.number').keyup(function(){
            var val = $(this).val();
            if(isNaN($.trim(val))){
                  $(this).val('');
            }
      })
$(".datepicker" ).datepicker({
	dateFormat: 'yy-mm-dd',
        maxDate: new Date(),
	showOn: "button",
	buttonImage: "/img/calendar.png",
	buttonImageOnly: true
	
   });

    $(document).ready(function(){
            $('#UserDetailDob').parent('div').addClass('date');
            $('.datepicker').datepicker('setDate', dob);
            var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
         $(document).on('change','#UserAdminEditProfileForm #AddressCountryId',function() {
            var id = $(this).val();
            $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
                        success: function(res) {
                            $(document).find('.cPHcd').val(res);
                        }
                    });
            $('#UserAdminEditProfileForm .dynamicstate').load(getStateURL+'/'+id+'/addClass',function(){
                  
             });
         });
       
        var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
         $(document).on('change','#UserAdminEditProfileForm #AddressStateId',function() {
           var id = $(this).val();
           if (id=='') { id='null'; }
          $('#UserAdminEditProfileForm .dynamiccity').load(getCityURL+'/'+id+'/addClass',function(){
                  
             });
         });
      //input validation code on all fields
      
      var prodValidator = $("#UserAdminEditProfileForm").kendoValidator({
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
      
      //end
      });
      
      /* Image preview fuction */
function readURL(fuData){
        //var fuData = document.getElementById('fileChooser');
        var fileInput  = '#'+$(fuData).attr('id');
        var FileUploadPath = fuData.value;

        //To check if user upload any file
        if (FileUploadPath == '') {
            alert("Please upload an image");

        } else {
            var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();

    //The file uploaded is an image
    if (Extension == "gif" || Extension == "png"  || Extension == "jpeg" || Extension == "jpg") {
                // To Display
                if (fuData.files && fuData.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                                             var img = new Image;
                        img.onload = function() {
                        var imageheight = img.height;
                        var imageWidth = img.width;
                        if(imageheight >=  imageWidth)
                        {
                              $(document).find(fileInput).val('');
                              $(document).find(fileInput).after($(fileInput).clone(true)).remove();
                             // $(document).find('.preview').html('');
//                            $fileInput.replaceWith( $fileInput = $fileInput.clone( true ) );
                              var msg = 'Image should be landscape.'
                              bootbox.alert(msg);
                              return msg;
                        }
                        else if(imageheight < 310 || imageWidth < 554)
                        {
                                $(document).find(fileInput).val('');  
                                $(document).find(fileInput).after($(fileInput).clone(true)).remove();
                                //$(document).find('.preview').html('');
//obj.prev().val('');
//                             $(fileInput).replaceWith( $(fileInput) = $(fileInput).clone( true ) );
                            var msg = 'Minimum height and width of file should be 310 * 554.'
                            bootbox.alert(msg);
                           
                        }else{
                            $(document).find('.preview').html('<img src='+e.target.result+' width="200" height="150" />');
                        }
                      };
                      img.src = reader.result;   
                       // $('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
                    }
                    reader.readAsDataURL(fuData.files[0]);
                }
            } 

            //The file upload is NOT an image
            else {
                //                reset_form_element (fuData);
                $("#UserImage").val('');
                bootbox.alert("File doesnt match png, jpg or gif extension.");
             }
        }
  }
  
  $(function(){
      initialize('are');
   });
    
    function initialize(iso){
	autocomplete = new google.maps.places.Autocomplete(
	     /** @type {HTMLInputElement} */(document.getElementById('AddressAddress')),
	     {types:  ['geocode'],componentRestrictions: {country:iso} });
	      google.maps.event.addListener(autocomplete, 'place_changed', function() {
	  });
	// console.log(autocomplete);
     }
  
</script>
