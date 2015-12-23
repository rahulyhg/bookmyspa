<style>
      .pac-container{
            z-index:9999999 !important; 
      }
</style>
 <?php echo $this->Html->script('bootbox.js'); ?>
<div class="modal-dialog vendor-setting addUserModal">
<div class="modal-content">
      <?php echo $this->Form->create('User',array('novalidate','type' => 'file')); ?>
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h3 id="myModalLabel"><i class="icon-edit"></i>
          <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Customer Information</h3>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col-sm-12" >
            <div class="box">
            <div class="box-content" style="height: 450px; overflow: auto;">
            <?php echo $this->Form->hidden('User.id',array('div'=>false,'label'=>false));?>
            <?php if(empty($this->data)){ ?>
            <?php echo $this->Form->hidden('User.type',array('value'=>6,'div'=>false,'label'=>false));?>
            <?php } ?>
            <?php
                  $readonly = false ;
                  $country_code = '+971';
            ?>
            <?php
            if(isset($this->data) && !empty($this->data)){
                
                  //echo $this->Form->hidden('User.addtoSalon',array('value'=>1,'div'=>false,'label'=>false));
                  
                  if($auth_user['User']['type'] == 1){
                        $readonly = false;
                  }
                  elseif($auth_user['User']['type'] == 2){
                        if($this->data['User']['created_by'] == $auth_user['User']['id'] || $this->data['User']['parent_id'] == $auth_user['User']['id']){
                              $readonly = false;
                              if($this->data['User']['is_email_verified'] == 1 || $this->data['User']['is_phone_verified'] == 1){
                                   $phone_email = true; $readonly = true;
                              }
                        }
                        else{
                              echo $this->Form->hidden('User.addtoSalon',array('value'=>1,'div'=>false,'label'=>false));
                              $readonly = true;
                        }
                  }
                  elseif($auth_user['User']['type'] == 3 || $auth_user['User']['type'] == 4){
                        if($this->data['User']['created_by'] == $auth_user['User']['id']){
                              $readonly = false;
                              if($this->data['User']['is_email_verified'] == 1 || $this->data['User']['is_phone_verified'] == 1){
                                   $phone_email = true; $readonly = true;
                              }
                        }else{
                              echo $this->Form->hidden('User.addtoSalon',array('value'=>1,'div'=>false,'label'=>false));
                              $readonly = true;
                        }
                        
                  }
                  
                  //else{
                  //      if($auth_user['User']['parent_id'] == 0 && $this->data['User']['parent_id'] == $auth_user['User']['parent_id'] ){
                  //            $readonly = false;
                  //            if($this->data['User']['is_email_verified'] == 1 && $this->data['User']['is_phone_verified'] == 1){
                  //                  $readonly = true;
                  //                  if($this->data['User']['created_by'] == $auth_user['User']['id']){
                  //                        $phone_email = true;
                  //                  }
                  //            }
                  //      }
                  //      
                  //
                  //      
                  //}
                
                if($this->data['Contact']['country_code']){
                  $country_code = $this->data['Contact']['country_code'];
                }
                
            }
           
            if($readonly){
                
            }
            ?>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Login Email*:</label>
                        <?php echo $this->Form->input('email',array('class'=>'form-control','div'=>false,'label'=>false,'readonly'=>$readonly,'required','ValidationMessage'=>'Please enter valid email address.','data-required-msg'=>"Email is required.",'maxlength'=>'101','maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters."));?>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label">First Name*:</label>
                        <?php echo $this->Form->input('first_name',array('class'=>'form-control','div'=>false,'label'=>false,'readonly'=>$readonly,'minlength'=>'3','maxlengthcustom'=>'30','maxlength'=>'35','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"First name is required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 30 characters.",'data-pattern-msg'=>"Please enter only alphabets."));?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name*:</label>
                            <?php echo $this->Form->input('last_name',array('class'=>'form-control','div'=>false,'label'=>false,'readonly'=>$readonly,'minlength'=>'3','maxlength'=>'35','maxlengthcustom'=>'30','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Last name is required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 30 characters.",'data-pattern-msg'=>"Please enter only alphabets."));?>
                    </div>
                    <div class="form-group">
                        <label class="control-label ">Mobile 1*:</label>
                              <div class=" col-sm-12 nopadding">
                              <div class="col-sm-3 col-xs-3 nopadding ">
                                   <?php echo $this->Form->hidden('Contact.id',array());
                                   
                                   ?>
                                   
                                <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','value'=>$country_code,'class'=>'form-control cPHcd numOnly', 'div'=>false,'label'=>false,'maxlength'=>5,'required'=>true,'ValidationMessage'=>'Required.'));?>
                              </div>
                              <div class="col-sm-9 col-xs-9 rgt-p-non">
                                     <?php echo $this->Form->input('Contact.cell_phone',array('type'=>'text','class'=>'form-control numOnly','div'=>false,'label'=>false,'readonly'=>$readonly,'required','ValidationMessage'=>'Mobile number is required.','maxlength'=>15));?>
                              </div>
                              </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                    
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Date Of Birth</label>
                                <?php echo $this->Form->hidden('UserDetail.id',array());?>
                                <?php
                                    echo $this->Form->input('UserDetail.dob', array('type'=>'text','class'=>'form-control datepicker ','id'=>'datepicker','label' => false,'readonly'=>$readonly,'required'=>'false'));
                                ?>
                            </div>
                    </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Gender*:</label>
                                 <?php
                                    $options = array('male' => 'Male', 'female' => 'Female');
                                    echo $this->Form->input('UserDetail.gender',array('options'=>$options,'div'=>false,'label'=>false,'class'=>'form-control','readonly'=>$readonly,'empty'=>'Please Select','required','ValidationMessage'=>'Please select gender.')); ?>
                                    <?php
                                    if(isset($validationErrors['UserDetail']['gender'][0]) && !empty($validationErrors['UserDetail']['gender'][0])){
                                          echo '<div class="error-message">'.$validationErrors['UserDetail']['gender'][0].'</div>';
                                    }
                                    ?>
                                 
                            </div>
                        </div>
                    
                  <div class="form-group col-sm-6 mrgn-btm0">
                        <div class="form-group nopadding clearfix">
                              <label class="control-label nopadding col-sm-12">Mobile 2</label>
                              <div class="col-sm-12 nopadding">
                              <div class="col-sm-3 col-xs-3 nopadding">
                                  <?php echo $this->Form->input('Contact.country_code1',array('type'=>'text','class'=>'form-control cPHcd ','div'=>false,'label'=>false, 'value'=>$country_code ,'maxlength'=>5));?>
                              </div>
                              <div class="col-sm-9 col-xs-9  rgt-p-non">
                                     <?php echo $this->Form->input('Contact.day_phone',array('type'=>'text','class'=>'form-control numOnly','div'=>false,'label'=>false,'readonly'=>$readonly,'required'=>'false','maxlength'=>15));?>
                              </div>
                              </div>
                        </div>
                  </div>
                  <div class="form-group col-sm-6 mrgn-btm0">
                     <div class="form-group rgt-p-non">
                     <label class="control-label col-sm-12 nopadding">Mobile 3</label>
                     	<div class="col-sm-12 nopadding clearfix">
                        <div class="col-sm-3 col-xs-3 nopadding">
                             <?php echo $this->Form->input('Contact.country_code2',array('type'=>'text','class'=>'form-control cPHcd ','value'=>$country_code,'div'=>false,'label'=>false,'maxlength'=>5));?>
                        </div>
                        <div class="col-sm-9 col-xs-9 rgt-p-non">
                              <?php echo $this->Form->input('Contact.night_phone',array('type'=>'text','class'=>'form-control numOnly','div'=>false,'label'=>false,'readonly'=>$readonly,'required'=>'false','maxlength'=>15));?>
                        </div>
                        </div>
                    </div>
                  </div>
                  </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Marital Status </label>
                                    <?php echo $this->Form->input('UserDetail.marital_status',array('options'=>array('S'=>'Single','M'=>'Married'),'class'=>'marital_status form-control','div'=>false,'label'=>false,'readonly'=>$readonly,'empty'=>'Please Select','required'=>'false'));?>
                            </div>
                        </div>
                        <?php
                        $dispN = 1;
                        if(isset($this->data['UserDetail']['marital_status']) &&  $this->data['UserDetail']['marital_status'] == 'M'){
                            $dispN = 0;
                        }
                         
                            ?>
                        <div class="col-sm-4">
                            <div class="form-group  mared"<?php if($dispN){ echo 'style="display:none"';} ?> >
                                <label class="control-label">Spouse DOB :</label>
                                    <?php echo $this->Form->input('UserDetail.spouse_dob',array('type'=>'text','class'=>'form-control datepicker','id'=>'spouseDOB','div'=>false,'label'=>false,'readonly'=>$readonly,'required'=>'false'));?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mared" <?php if($dispN){ echo 'style="display:none"';} ?> >
                                <label class="control-label">Anniversary </label>
                                    <?php echo $this->Form->input('UserDetail.anniversary',array('type'=>'text','class'=>'datepicker form-control','id'=>'anvrsyDOB','div'=>false,'label'=>false,'readonly'=>$readonly,'required'=>'false'));?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group clearfix">
                        <label class="control-label">Appointment Reminder By </label>
                        <div class="col-sm-10 lft-p-non">
                              <div class="clearfix mrgn-btm10">
                                    <?php echo $this->Form->input('Contact.email_reminder',array('readonly'=>$readonly,'div'=>false,'type'=>'checkbox','default'=>1,'class'=>' ','label'=>array('class'=>'new-chk','text'=>'Email'))); ?> 
                              </div>
                              <div class="clearfix ">
                                    <?php echo $this->Form->input('Contact.sms_reminder',array('readonly'=>$readonly,'div'=>false,'type'=>'checkbox','default'=>1,'class'=>' ','label'=>array('class'=>'new-chk','text'=>'SMS/Text'))); ?>
                              </div>
                        </div>
                    </div>
                    <div class="test-focus">
                        <div class="form-group clearfix">
                              <label class="control-label">CC Appointment email to </label>
                              <?php
                              echo $this->Form->input('UserDetail.cc_to', array('div'=>false,'empty'=>'Select','options'=>$cc_list,'id'=>'selectCcId','class'=>'form-control select2-me nopadding bod-non','label' => false,'readonly'=>$readonly));
                               ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Referred By:</label>
                        <?php
                            $patern = "^[A-Za-z0-9@_/-/._-]+$";
                            echo $this->Form->input('UserDetail.refered_by', array('type'=>'text','class'=>'form-control','label' => false,'readonly'=>$readonly,'minlength'=>'3','maxlength'=>'35','maxlengthcustom'=>'30','data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 30 characters.",'pattern'=>$patern,'data-pattern-msg'=>"Only alphanumeric or (@_-.) characters or valid email are allowed." ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="row pdng-tp20">
                  
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="input01">Image </label>
                            <div class="preview prev-chng">
                            <?php
                                if(isset($userInfo['User']['image']) && !empty($userInfo['User']['image'])){
                                    echo $this->Html->Image("../images/".$userInfo['User']['id']."/User/150/".$userInfo['User']['image']);
                                   if($readonly){
                                   }else{
                                          echo $this->Html->link(__('Change Image'),'javascript:void(0);',array('class'=>'showFile'));
                                   }
                                    $hideFile = 1;
                                } ?> 
                            </div>
                            <div class="previewInput" <?php if(isset($hideFile)){ echo 'style="display:none"'; } ?> >
                              <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control','readonly'=>$readonly,'accept'=>".jpg,.png,.gif",'onchange'=>'validate_images(this)')); ?>
                                <?php
                                if(isset($hideFile)){
                                    //echo $this->Html->link(__('Cancel'),'javascript:void(0);',array('class'=>'hideFile'));
                                }
                                ?>
                            </div>
                        
                    </div>    
                </div>
                <div class="col-sm-9">
                    <div class="form-group">
                        <label class="control-label">General Tags</label>
                            <?php echo $this->Form->input('UserDetail.tags',array('class'=>'tagsinput  form-control ','div'=>false,'label'=>false,'readonly'=>$readonly));?>
                    </div>   
                </div>
                 
            </div>
            <hr>    
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Country</label>
                            <?php
                            $val = isset($this->data['Address']['country_id'])?$this->data['Address']['country_id']:$auth_user['Address']['country_id'];
                            echo $this->Form->input('Address.country_id',array('class'=>'form-control','options'=>$countryData,'div'=>false,'empty'=>'Please Select','label'=>false,'readonly'=>$readonly,'required'=>'false','value'=>$val));?>
                      </div>
                      <div class="form-group dynamicstate">
                        <label class="control-label">City</label>
                            <?php
                              $state = isset($this->data['Address']['state_id'])?$this->data['Address']['state_id']:$auth_user['Address']['state_id'];

                            echo $this->Form->input('Address.state_id',array('class'=>'form-control','empty'=>'Please Select','options'=>$stateData,'div'=>false,'label'=>false,'readonly'=>$readonly,'required'=>'false','value'=>$state));?>
                    </div>
                    <div class="form-group dynamiccity">
                        <label class="control-label">Location/Area</label>
                            <?php echo $this->Form->input('Address.city_id',array('class'=>'form-control','empty'=>'Please Select','div'=>false,'options'=>$cityData,'label'=>false,'readonly'=>$readonly,'required'=>'false'));?>
                    </div>
                </div>
                
                <div class="col-sm-3">
                   <div class="form-group">
                        <label class="control-label">Address:</label>
                            <?php echo $this->Form->hidden('Address.id',array());?>
                            <?php
                            
                            echo $this->Form->input('Address.address',array('type'=>'text','class'=>'form-control','div'=>false,'label'=>false,'onBlur'=>'changeMap()','readonly'=>$readonly,'required'=>'false'));?>
                            <?php
                            $latitude    = '';
                            $longitude   = '';
                            if($auth_user['Address']['latitude']){
                               $latitude    = $auth_user['Address']['latitude'];
                            }
                            if($auth_user['Address']['longitude']){
                               $longitude   = $auth_user['Address']['longitude'];
                            }
                            if(isset($this->data['Address']['latitude']) && !empty($this->data['Address']['latitude'])){
                                $latitude    = $this->data['Address']['latitude'];
                                }
                            if(isset($this->data['Address']['longitude']) && !empty($this->data['Address']['longitude'])){
                                $longitude    = $this->data['Address']['longitude'];
                            }?>
                            <?php echo $this->Form->hidden('Address.latitude',array('value'=>$latitude,'id'=>'AddressLatitude','div'=>false,'label'=>false,'readonly'=>$readonly));?>
                            <?php echo $this->Form->hidden('Address.longitude',array('value'=>$longitude,'id'=>'AddressLongitude','div'=>false,'label'=>false,'readonly'=>$readonly));
                            ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">PO Box</label>
                            <?php echo $this->Form->input('Address.po_box',array('class'=>'form-control numOnly','div'=>false,'label'=>false,'onBlur'=>'changeMap()','readonly'=>$readonly,'required'=>'false'));?>
                    </div>
                    
                  
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div id="map1" style="height: 150px"></div>
                    </div>    
                </div>
            </div>
            
                
            </div>
            </div>
            </div>
        
    </div>
</div>
      
      <div class="modal-footer pdng20">
            <div class="col-sm-12 ">
                  
                  <div class="col-sm-2 pull-right">
                    <?php echo $this->Form->button('Cancel',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'data-dismiss'=>'modal',
                                        'class'=>'btn  full-w')); ?>
                  </div>
                  <div class="col-sm-2 pull-right">
                    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary  mrgn-rgt10 submitUser  full-w','label'=>false,'div'=>false));?></div>
                  
                    
            </div>
      </div>
      <?php echo $this->Form->end();?>
</div>
</div>
<script type="text/javascript">
var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

    //var iSoId = $(document).find("#AddressCountryId").val();
    
    //getIsoCode(iSoId);

function initialize(iso){
    
    autocomplete = new google.maps.places.Autocomplete(
	 /** @type {HTMLInputElement} */(document.getElementById('AddressAddress')),
	 {types:  ['geocode'],componentRestrictions: {country:iso} });
	 google.maps.event.addListener(autocomplete, 'place_changed', function() {
	
     });
	// console.log(autocomplete);
}

    function changeMap(){
        var country = $("#AddressCountryId").children("option").filter(":selected").text();
        var state = $("#AddressStateId").children("option").filter(":selected").text();
        var address = document.getElementById('AddressAddress').value;
       // console.log(country);
        var poBox =  document.getElementById('AddressPoBox').value;
       // if(address){
            showAddress = address;
             if(country !='Please Select'){
                  showAddress+= ','+country;
            }
            if(poBox !=''){
                  showAddress+= ','+poBox;
            }
            if(state !='Please Select'){
                  showAddress+= ','+state;
            }
           
            $('#map1').gmap3('destroy');
            $("#map1").gmap3({
                marker:{
                  address: showAddress,
                  options:{draggable:true},
                  events:{
                        dragend: function(marker){
                            updateMarker(marker);
                        },
                    },
                    callback: function(marker){
                        updateMarker(marker);
                    }
                },
                map:{
                  options:{
                    zoom: 14
                  }
                }
            });
       // }
    }
    function updateMarker(marker){
        var latLng = marker.getPosition();
        document.getElementById('AddressLatitude').value = latLng.lat();
        document.getElementById('AddressLongitude').value = latLng.lng();
    }
    
    function setphoneCode(id){
      if(id){
            $.ajax({
                  url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
                  success: function(res) {
                      $(document).find('.cPHcd').val(res);
                  }
            });
      }
    }
    
    $(document).ready(function(){
      
        <?php if($readonly){ ?>
            $(document).find('.modal-body').find('input,select,textarea').prop( "disabled", true );
            $(document).find('.modal-body').find('input#UserAddtoSalon , input#UserId').prop( "disabled", false);
            $(document).find('.modal-body').find('#AppointmentAdminAddAppointmentForm').find(':input').prop( "disabled", false);
        <?php
            if(isset($phone_email)){
                  if($this->data['User']['is_email_verified'] != 1){ ?>
                        $(document).find('.modal-body').find('input#UserEmail').prop( "disabled", false ).attr('readonly',false);
                  <?php                         
                  }
                  if($this->data['User']['is_phone_verified'] != 1){
                  ?>
                        $(document).find('.modal-body').find('input#ContactDayPhone').prop( "disabled", false ).attr('readonly',false);
                  <?php                         
                  }
            }
        } ?>
            <?php if(isset($this->data) && empty($this->data)){ ?>
            
            $(document).find('#UserDetailEmailReminder,#UserDetailSmsReminder').prop('checked','checked');
                  <?php if($auth_user['Address']['country_id']){ ?>
                        setphoneCode('<?php echo $auth_user['Address']['country_id'];?>');
                  <?php } ?>
            <?php }else{ ?>
                  setphoneCode('<?php echo $this->data['Address']['country_id'];?>');
            <?php } ?>
            
            
            
        
        var zoomlevel = 4;
        <?php if(isset($this->data['Address']['address']) && !empty($this->data['Address']['address'])){ ?>
            zoomlevel = 14;
        <?php }?>
        var lat     = '<?php echo $latitude; ?>';
        var long    = '<?php echo $longitude;?>';
        if(lat && long){
        setTimeout(function(){
    if($("#map1").length > 0){
            $("#map1").gmap3({
                map:{
                    options:{
                        center:[lat,long],
                        zoom:zoomlevel
                    }
                },
                autofit:{},
                marker:{
                    options:{draggable:true},
                    values:[
                        {latLng:[lat,long], data:" "},
                    ],
                    events:{
                        dragend: function(marker){
                            updateMarker(marker);
                        },
                    }
                }
            });
        }
        }, 500);
      }else{
     
      setTimeout(function(){
      changeMap();},500);
      }
                  
        $(document).find('#datepicker').datepicker({dateFormat: 'dd-mm-yy', changeMonth: true,
changeYear: true,maxDate: new Date(),yearRange:'-50:+0'});
        $(document).find('#spouseDOB').datepicker({dateFormat: 'dd-mm-yy', changeMonth: true,
changeYear: true,maxDate: new Date(),yearRange:'-50:+0'});
        $(document).find('#anvrsyDOB').datepicker({dateFormat: 'dd-mm-yy', changeMonth: true,
changeYear: true,maxDate: new Date(),yearRange:'-50:+0'});
      $(document).find('.box-content').scroll(function() {
	    $(document).find('#datepicker,#anvrsyDOB,#spouseDOB').datepicker('hide');
            $(document).find('.pac-container').hide();
      });
        
        $(document).find(".select2-me").select2();
        $(document).find('.marital_status').change(function(){
            if($(this).val() == 'M'){
                $(document).find('.mared').show();    
            }else{
                $(document).find('.mared').hide();
            }
        });
        
        $(document).on('click','.showFile',function(){
            $(this).parent('div').next('.previewInput').show();
            //$(this).parent('.preview').hide();
        });
        $(document).on('click','.hideFile',function(){
           // $(this).closest('div.form-group').find('.previewInput').hide();
            //$(this).closest('div.form-group').find('.preview').show();
        });
        
        <?php if($readonly){ ?>
            $(document).find('.tagsinput').tagsInput({width:'auto', height:'auto',maxTags:4});  
        <?php }else{ ?>
            $(document).find('.tagsinput').tagsInput({width:'auto', height:'auto'});  
        <?php } ?> 
        
        
        
         var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
         $(document).on('change','#UserAdminAddUserForm #AddressCountryId',function() {
            var id = $(this).val();
             $.ajax({
                  url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'getIsoCode','admin'=>false))?>"+'/'+id,
                  success: function(res) {
                      initialize(res);
                  }
            });
             
            var country = $(this).children("option").filter(":selected").text();
             setphoneCode(id);
            $('#UserAdminAddUserForm .dynamicstate').load(getStateURL+'/'+id,function(){
                  $(document).find('#UserAdminAddUserForm .dynamicstate').find('select').addClass('form-control').attr('required',false);
                  $(document).find('#UserAdminAddUserForm .dynamicstate').find('label').html('City');
                  changeMap();
                  $(this).unbind();
             });
            $(this).unbind();
         });
       
       var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
         $('body').off().on('change','#UserAdminAddUserForm #AddressStateId',function() {
           var id = $(this).val();
           var country = $(this).children("option").filter(":selected").text();
           $('#UserAdminAddUserForm .dynamiccity').load(getCityURL+'/'+id,function(){
                  $(document).find('#UserAdminAddUserForm .dynamiccity').find('select').addClass('form-control').attr('required',false);
                  $(document).find('#UserAdminAddUserForm .dynamiccity').find('label').html('Location/Area');
                  changeMap();
                  $(this).unbind();
             });
           $(this).unbind();
         });
    });
</script>
<script>
   
    $(document).ready(function(){
            
            $('#UserDetailTags_tag').focus(function(){
                    $(this).closest(".tagsinput").addClass('purple-bod');
            });
            $('#UserDetailTags_tag').focusout(function(){
                    $(this).closest(".tagsinput").removeClass('purple-bod');
            });

      });
     
     
     $(document).ready(function(){
            $('#selectCcId').select2()
                .on("open", function(e) {
                    $(document).find('.select2-drop-active').addClass('purple-bod');
                    $(document).find('a.select2-choice').addClass('purple-bod');
                    
                }).on('close', function(){
                    $(document).find('.select2-drop-active').removeClass('purple-bod');
                    $(document).find('#s2id_selectUserId').removeClass('purple-bod');
                    $(document).find('.select2-choice').removeClass('purple-bod');
            });
        })
     
     
   $(function(){
      initialize('are');
   });
   function validate_images(file){
//    console.log('herere');
    fileInput = '#'+$(file).attr('id');
//    console.log($fileInput);
 if (file.files && file.files[0]) {
               var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = new Image;
                        img.onload = function() {
                        var imageheight = img.height;
                        var imageWidth = img.width;
                        if(imageheight >=  imageWidth)
                        {
                              $(document).find(fileInput).val('');
                              $(document).find(fileInput).after($(fileInput).clone(true)).remove();
                              $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
//                            $fileInput.replaceWith( $fileInput = $fileInput.clone( true ) );
                            var msg = 'Image should be landscape.'
                            bootbox.alert(msg);
                            return msg;
                        }
                        else if(imageheight < 310 || imageWidth < 554)
                        {
                             $(document).find(fileInput).val('');  
                            $(document).find(fileInput).after($(fileInput).clone(true)).remove();
                            $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
//obj.prev().val('');
//                             $(fileInput).replaceWith( $(fileInput) = $(fileInput).clone( true ) );
                            var msg = 'Minimum height and width of file should be 310 * 554.'
                            bootbox.alert(msg);
                            return msg;
                        }else{
                            $(document).find(fileInput).closest('.previewInput').prev('.preview').html('<img src='+e.target.result+' width="200" height="150" />');
                        }
                      };
                      img.src = reader.result;
                    };
                    reader.readAsDataURL(file.files[0]);
        }
}
   
 </script>