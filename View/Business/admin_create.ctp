<style>
      .pac-container{
            z-index:9999999 !important; 
      }
      .error{
          border-color: red !important;
      }
      
</style>
 <?php echo $this->Html->script('bootbox.js'); ?>
<div class="modal-dialog vendor-setting">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php
    echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Business Information</h3>
</div>
     <?php echo $this->Form->create('User',array('id'=>'BusinessCreateForm','novalidate','type' => 'file','class'=>'')); ?>
     <input type="hidden" name="resize" value="" id="resize">
<div class="modal-body clearfix SalonEditpop">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-content">
                           <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Business Type* :</label>
                        <?php
                            echo $this->Form->input('Salon.business_type_id',array('options'=>$bType,'class'=>'chosen-select form-control','div'=>false,'label'=>false,'multiple'=>true,'selected'=>$businessTpe,'validationMessage'=>"Business Type is required.",'required'));?>
                            <dfn class="text-danger k-invalid-msg" data-for="data[Salon][business_type_id][]" role="alert" style="display: none;">Business Type is required.</dfn>
                        </div>
                        <?php if($type=='salon'){
                                echo  $this->Form->input('User.parent_id',array('type'=>'hidden','value'=>$auth_user['User']['id']));
                                echo  $this->Form->input('User.type',array('type'=>'hidden','value'=>4));
                             }else{ ?>
                        <div class="form-group">
                            <label class="control-label">Business Model* :</label>
                                <?php $userType = $this->Common->businessModal(); ?>
                                 <?php
                            $tmpitsval = "";
                            if(isset($this->data['User']['fortype']) && !empty($this->data['User']['fortype'])){
                                $tmpitsval = $this->data['User']['fortype'];
                            }
                            elseif(isset($this->data) && !empty($this->data)){
                                $tmpitsval = $this->data['User']['type'];
                                if(isset($this->data['User']['type']) && isset($this->data['User']['parent_id']) && $this->data['User']['type'] == 4 && $this->data['User']['parent_id']>0){
                                    $tmpitsval = '-1';
                                }
                            }
                            ?>
                            <?php echo $this->Form->input('fortype',array('empty'=>'Please Select','options'=>$userType,'class'=>'form-control full-w','div'=>false,'value'=>$tmpitsval,'label'=>false,'validationMessage'=>"Business Modal is required.",'required'));?>
                            <?php echo $this->Form->hidden('type',array('label'=>false,'div'=>false));?>
                        </div>
                        <?php
                        $parentStyle = "display:none";
                        if((isset($this->request->data['User']['parent_id']) && !empty($this->request->data['User']['parent_id']) && ($this->request->data['User']['parent_id'] != 0))||(isset($this->request->data['User']['fortype']) && ($this->request->data['User']['fortype']=='-1'))){
                            $parentStyle = "display:block";
                        }
                        ?>
                        <div class="form-group selFrenchise" style="<?php echo $parentStyle; ?>">
                            <label class="control-label">Franchise* :</label>
                            <?php echo $this->Form->input('parent_id',array('empty'=>'Please Select','options'=>$frenchList,'class'=>'form-control full-w','div'=>false,'label'=>false,'required'=>false));?>
                        </div>
                        
                        <?php } ?>
                        <div class="form-group">
                                <label class="control-label">Service Provided To* :</label>
                                 <?php $serviceTo = $this->Common->serviceprovidedTo(); ?>
                                <?php echo $this->Form->input('Salon.service_to',array('empty'=>'Please Select','options'=>$serviceTo,'class'=>'form-control full-w','div'=>false,'label'=>false,'validationMessage'=>"Service Provided To is required.",'required'));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">First Name* :</label>
                                 <?php 
                                 $patern = "^[A-Za-z.'\-\s]+$";
                                 echo $this->Form->input('first_name',array('class'=>'form-control','div'=>false,'label'=>false,'validationMessage'=>"First Name is required.",'required','minlength'=>'3','pattern'=>$patern,'data-pattern-msg'=>"Please enter only alphabets and ( . , ' and - ).",'data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'maxlength'=>105));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name* :</label>
                                <?php echo $this->Form->input('last_name',array('class'=>'form-control','div'=>false,'label'=>false,'validationMessage'=>"Last Name is required.",'required','minlength'=>'3','pattern'=>$patern,'data-pattern-msg'=>"Please enter only alphabets and ( . , ' and - ).",'data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'maxlength'=>105));?>
                        </div>
                    </div>
                
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Login Email* :</label>
                                        <?php $patern = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" ?>
                                        <?php echo $this->Form->input('email',array('class'=>'form-control','div'=>false,'label'=>false,'validationMessage'=>"Business Email is required.",'required',"data-email-msg"=>"Please enter valid Email address.",'pattern'=>$patern,'data-pattern-msg'=>"Please enter a valid email address."));?>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label">Business Email :</label>
                                        <?php $pattern2 = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" ?>
                                        <?php echo $this->Form->input('Salon.email',array('class'=>'form-control','div'=>false,'pattern'=>$pattern2,'data-pattern-msg'=>"Please enter a valid email address.",'label'=>false));?>
                                 </div>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                                </ul>
                                <div class="tab-content bod-tp-non">
                                    <div class="tab-pane active" id="tab1">
                                        <div class="sample-form form-horizontal">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="control-label" >Business Name* :</label>
                                                      <?php echo $this->Form->hidden('Salon.id',array());?>
                                                        <?php
                                                        $readonly=false;
                                                        if(isset($userInfo['User']['type']) &&($userInfo['User']['type']==4) && $userInfo['User']['parent_id'] != 0){
                                                            $readonly=true;
                                                        }
                                                        
                                                        echo $this->Form->input('Salon.eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>'200','maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>'Maximum 100 characters are allowed.','readonly'=>$readonly,'validationMessage'=>"Business Name is required.",'required')); ?>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="control-label" >Description* :</label>
                                                     <?php echo $this->Form->textarea('Salon.eng_description',array('label'=>false,'div'=>false,'class'=>'form-control','validationMessage'=>"Description is required.",'required','minlength'=>'20','maxlengthcustom'=>'500','required','data-minlength-msg'=>"Minimum 20 characters.",'data-maxlengthcustom-msg'=>"Maximum 500 characters.",'maxlength'=>501)); ?>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <div class="sample-form form-horizontal">
                                            <fieldset class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label">Name :</label>
                                                        <?php echo $this->Form->input('Salon.ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>'200')); ?>
                                                </div>
                                            </fieldset>
                                            <fieldset class="col-sm-12 nopadding">
                                                <div class="control-group">
                                                    <label class="control-label" >Description :</label>
                                                        <?php echo $this->Form->textarea('Salon.ara_description',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                                </div>
                                            </fieldset>
                                        </div>    
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        
                       <div class="form-group">
                              <label class="control-label nopadding col-sm-12">Business Mobile 1* :</label>
                              <div class="col-sm-4 col-xs-4 nopadding">
                                  <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','class'=>'form-control cPHcd','div'=>false,'label'=>false, 'value'=>"+971" ,'maxlength'=>5 ));?>
                              </div>
                              <div class="col-sm-8 col-xs-8 rgt-p-non">
                                     <?php echo $this->Form->hidden('Contact.id',array());?>
                                <?php echo $this->Form->hidden('UserDetail.id',array());?>
                                <?php echo $this->Form->input('Contact.cell_phone',array('type'=>'text','class'=>'form-control numOnly','div'=>false,'label'=>false,'validationMessage'=>"Business Mobile 1 is required.",'required','maxlength'=>10));?>
                              </div>
                        </div>
                    <div class="form-group">
                          <label class="control-label nopadding col-sm-12">Business Mobile 2:</label>
                          <div class="col-sm-4 col-xs-4 nopadding">
                              <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','class'=>'form-control cPHcd','div'=>false,'label'=>false, 'value'=>"+971" ,'maxlength'=>5 ));?>
                          </div>
                          <div class="col-sm-8 col-xs-8 rgt-p-non">
                                 <?php echo $this->Form->input('Contact.day_phone',array('type'=>'text','class'=>'form-control numOnly','div'=>false,'label'=>false ,'maxlength'=>10));?>
                          </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="input01">Image :</label>
                            <div class="preview preview1 prev-chng">
                            <?php
                                if(isset($userInfo['User']['image']) && !empty($userInfo['User']['image'])){
                                    echo $this->Html->Image("../images/".$userInfo['User']['id']."/User/150/".$userInfo['User']['image']);
                                    echo $this->Html->link(__('Change Image'),'javascript:void(0);',array('class'=>'showFile'));
                                    $hideFile = 1;
                                }?> 
                            </div>
                            <div class="previewInput" <?php if(isset($hideFile)){ echo 'style="display:none"'; } ?> >
                                <span style="position:relative;" class="browse_but">
                                <section><?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control','onchange'=>'validate_images(this)')); ?></section>
                                </span>
                                <?php
                                if(isset($hideFile)){
                                   // echo $this->Html->link(__('Cancel'),'javascript:void(0);',array('class'=>'hideFile'));
                                }
                                ?>
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="control-label" for="input01">Cover Image :</label>
                                <div class="preview preview2 prev-chng">
                                <?php
                                
                                    if(isset($userInfo['Salon']['cover_image']) && !empty($userInfo['Salon']['cover_image'])){
                                        echo $this->Html->Image("../images/".$userInfo['User']['id']."/Salon/150/".$userInfo['Salon']['cover_image']);
                                        echo $this->Html->link(__('Change Image'),'javascript:void(0);',array('class'=>'showFilec'));
                                        $hideFilec = 1;
                                    }?> 
                                </div>
                                <div class="previewInput" <?php if(isset($hideFilec)){ echo 'style="display:none"'; } ?> >
                                <span style="position:relative;" class="browse_but">
                                    <section>
                                <?php echo $this->Form->input('Salon.cover_image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control','onchange'=>'validate_images(this)')); ?>
                                    </section>  
                                  <?php
                                    if(isset($hideFilec)){
                                        //echo $this->Html->link(__('Cancel'),'javascript:void(0);',array('class'=>'hideFilec'));
                                    }
                                    ?>
                                </div>
                        </div>
                    </div>
                </div>
                <hr style="margin: 0px;">    
                <div class="row">
                    <div class="col-sm-3">
                           <div class="form-group">
                            <label class="control-label">Country* :</label>
                                <?php //echo $this->Form->hidden('Address.country_id',array('value'=>252,'div'=>false,'label'=>false));?>
                                <?php echo $this->Form->input('Address.country_id',array('class'=>'form-control full-w','options'=>$countryData,'empty'=>'Please Select','div'=>false,'label'=>false,'validationMessage'=>"Country is required.",'required'));?>
                         </div>
                         <div class="form-group dynamicstate">
                                <label class="control-label">City* :</label>
                               <?php
                                $stateList=array();
                                if(isset($userInfo['Address']['country_id']) && !empty($userInfo['Address']['country_id'])){
                                   $stateList =  $this->Common->getStatesbyCid($userInfo['Address']['country_id']);
                                }

                                echo $this->Form->input('Address.state_id',array('class'=>'form-control full-w','empty'=>'Please Select','div'=>false,'label'=>false,'options'=>$stateList,'validationMessage'=>"State is required.",'required'));?>
                         </div>
                        
                              <div class="form-group dynamiccity">
                            <label class="control-label">Location/Area* :</label>
                                <?php
                                $cityList=array();
                                if(isset($userInfo['Address']['state_id']) && !empty($userInfo['Address']['state_id'])){
                                   $cityList =  $this->Common->getCitiesbySid($userInfo['Address']['state_id']);
                                }
                                echo $this->Form->input('Address.city_id',array('class'=>'form-control full-w','empty'=>'Please Select','div'=>false,'label'=>false,'options'=>$cityList,'validationMessage'=>"Location/Area is required.",'required'));?>
                          </div>
                    </div>
                    <div class="col-sm-3">
                      
                        
                        <div class="form-group">
                            <label class="control-label">Address*</label>
                                <?php echo $this->Form->hidden('Address.id',array());?>
                                <?php echo $this->Form->input('Address.address',array('type'=>'text','class'=>'form-control','div'=>false,'label'=>false,'onBlur'=>'changeMap()','validationMessage'=>"Address is required.",'required','maxlength'=>100));?>
                                <?php
                                $latitude    = 24.4667;
                                $longitude   = 54.3667;
                                if(isset($this->data['Address']['latitude']) && !empty($this->data['Address']['latitude'])){
                                    $latitude    = $this->data['Address']['latitude'];
                                    }
                                if(isset($this->data['Address']['longitude']) && !empty($this->data['Address']['latitude'])){
                                    $longitude    = $this->data['Address']['longitude'];
                                }?>
                                <?php echo $this->Form->hidden('Address.latitude',array('value'=>$latitude,'id'=>'AddressLatitude','div'=>false,'label'=>false));?>
                                <?php echo $this->Form->hidden('Address.longitude',array('value'=>$longitude,'id'=>'AddressLongitude','div'=>false,'label'=>false));
                                ?>
                        </div>
                         <div class="form-group">
                            <label class="control-label">PO Box* :</label>
                            <?php echo $this->Form->input('Address.po_box',array('class'=>'form-control numOnly','div'=>false,'label'=>false,'onBlur'=>'changeMap()','validationMessage'=>"PO Box is required.",'required' ,'maxlength'=>10));?>
                           <?php echo $this->Form->hidden('Address.longitude',array('value'=>$longitude,'id'=>'AddressLongitude','div'=>false,'label'=>false)); ?>
                          
                           <?php echo $this->Form->hidden('Address.id',array('div'=>false,'label'=>false));?>
                           <?php echo $this->Form->hidden('Salon.id',array('div'=>false,'label'=>false));?>
                           <?php echo $this->Form->hidden('Contact.id',array('div'=>false,'label'=>false));?>
                           <?php echo $this->Form->hidden('User.id',array('div'=>false,'label'=>false));?>
                           <?php echo $this->Form->hidden('UserDetail.id',array('div'=>false,'label'=>false));?>
                         </div>
                            
                     </div>
                    <div class="col-sm-6">
                        <div class="control-group">
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
    <div class="from-action">
         <div class="col-sm-2 pull-right">
        <?php echo $this->Form->button('Cancel',array(
                        'type'=>'button','label'=>false,'div'=>false,
                        'data-dismiss'=>'modal',
                        'class'=>'btn full-w')); ?>
         </div>
        <div class="col-sm-2 pull-right">
        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitBusiness full-w','label'=>false,'div'=>false));?>
        </div>
        
       
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
function initialize(iso){
    
    autocomplete = new google.maps.places.Autocomplete(
	 /** @type {HTMLInputElement} */(document.getElementById('AddressAddress')),
	 {types:  ['geocode'],componentRestrictions: {country:iso} });
	 google.maps.event.addListener(autocomplete, 'place_changed', function() {
	
     });
	// console.log(autocomplete);
}
    function changeMap(){
        var showAddress='';
        var country = $("#AddressCountryId").children("option").filter(":selected").text();
        var state = $("#AddressStateId").children("option").filter(":selected").text();
        var address = document.getElementById('AddressAddress').value;
        var poBox =  document.getElementById('AddressPoBox').value;
       
            if(address !=''){
                  showAddress+= ','+address;
            }
            
            if(poBox !=''){
                  showAddress+= ','+poBox;
            }
            if(state !='Please Select'){
                  showAddress+= ','+state;
            }
            if(country !='Please Select'){
                  showAddress+= ','+country;
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
        
    }
    function updateMarker(marker){
        var latLng = marker.getPosition();
        document.getElementById('AddressLatitude').value = latLng.lat();
        document.getElementById('AddressLongitude').value = latLng.lng();
    }
    
    

    $(document).ready(function(){
      
        var zoomlevel = 4;
        <?php if(isset($this->data['Address']['area']) && !empty($this->data['Address']['area'])){ ?>
                zoomlevel = 14;
        <?php }?>
            var  lat = '<?php echo $latitude; ?>';
            var long  = '<?php echo $longitude;?>';
       
                setTimeout(function() {
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
    
        
        $(document).on('change','#UserFortype',function(){
            $(document).find('#UserType').val($(this).val());
            if($(this).val() == -1 ){
                $(document).find('.selFrenchise').show();
                $(document).find('#UserType').val(4);
                //$(document).find('#SalonEngName').attr('readonly' ,'readonly');
//                $(document).find('#UserParentId').attr('required','required');
            }else{
              //  $(document).find('#SalonEngName').removeAttr('readonly' ,'readonly');
                $(document).find('.selFrenchise').hide();
//                $(document).find('#UserParentId').attr('required','');
            }
        });
        
        $(document).on('click','.showFile',function(){
            console.log('hererer1');  
         $(this).closest('div.form-group').find('.previewInput').show();
             $(document).find(this).hide();
        });
        $(document).on('click','.hideFile',function(){
            $(this).closest('div.form-group').find('.previewInput').hide();
            $(document).find('.showFile').show();
            $(document).find(this).hide();
        });
        $(document).on('click','.showFilec',function(){
            $(this).closest('div.form-group').find('.previewInput').show();
            $(document).find(this).hide();
            //$(this).closest('div.form-group').find('.preview').hide();
        });
        $(document).on('click','.hideFilec',function(){
//            $(this).closest('div.form-group').find('.previewInput').hide();
            $(this).closest('div.form-group').find('.preview').show();
             $(document).find('.showFilec').show();
             $(document).find(this).hide();
        });
   
      var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
            $(document).on('change','#BusinessCreateForm #AddressCountryId',function() {
            var id = $(this).val();
             setphoneCode(id);
            $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
                        success: function(res) {
                            $(document).find('.cPHcd').val(res);
                        }
                    });
            $('#BusinessCreateForm .dynamicstate').load(getStateURL+'/'+id,function(){
               $('.dynamicstate select').addClass('form-control full-w');     
            changeMap();
             });
         });
       
       var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
         $(document).on('change','#BusinessCreateForm #AddressStateId',function() {
           var id = $(this).val();
           $('#BusinessCreateForm .dynamiccity').load(getCityURL+'/'+id,function(){
                 $('.dynamiccity select').addClass('form-control full-w'); 
                changeMap();
             });
         });

    $(document).on('change','#UserParentId',function(){
            if($(this).val() != '' ){
                 var text = $(this).children("option").filter(":selected").text();
                $("#SalonEngName").val(text);
                $("#SalonAraName").val(text);  
            }
        });
   $(document).on('change','#UserType',function(){
            if($(this).val() == 4){
                 $("#SalonEngName").attr('readonly',true);
                $("#SalonAraName").attr('readonly',true);  
            }else{
                 $("#SalonEngName").attr('readonly',false);
                $("#SalonAraName").attr('readonly',false);
            }
        });
   if($('.chosen-select').length > 0)
	{
		$('.chosen-select').each(function(){
			var $el = $(this);
			var search = ($el.attr("data-nosearch") === "true") ? true : false,
			opt = {};
			if(search) opt.disable_search_threshold = 9999999;
			$el.chosen(opt);
		});
	}

        
        $(document).on('change' ,'#AddressCityId',function(){
            fortype_val = $(document).find('#UserFortype').val();
            if(fortype_val=='-1'){
              franchise_name = $(document).find('#UserParentId option:selected').text();
              location_text = $(document).find('#AddressCityId option:selected').text();
              $(document).find('#SalonEngName').val(franchise_name +' '+location_text);    
            }
         });
         
      var edit_user_id = '';
      var edit_user_id = "<?php echo @$this->request->data['User']['id'];?>";
      if (edit_user_id !== '') {
            $('#BusinessCreateForm input').attr('readonly', 'readonly');
            $('#BusinessCreateForm select').attr('readonly', 'readonly');
            $('#BusinessCreateForm textarea').attr('readonly', 'readonly');
            $('#BusinessCreateForm textarea').attr('readonly', 'readonly');
            $('#SalonEngDescription').parent().html('');
            $('#map1').parent().parent().parent().html('');
            $('hr').remove();
            
            $('.prev-chng a').hide();
            $('.search-choice-close').hide();
            //$('.search-field').hide();
            $('#SalonBusinessTypeId ').attr('readonly', 'readonly');
            $('#UserEmail').removeAttr('readonly');
            $('#ContactCellPhone').removeAttr('readonly');
      }
    });
$(function(){
      initialize('are');
   });

function setphoneCode(id){
        $.ajax({
              url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
              success: function(res) {
                  $(document).find('.cPHcd').val(res);
              }
        });
}

$('.numOnly').keyup(function(){
    var value = $(this).val();
    if(isNaN(value)){
        $(this).val('');
    }
});

function readURL(input , clas){
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e){
              $(document).find('.'+clas).html('<img src="'+e.target.result+'" style="width: 200px;"/>');
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
  
  
   function validate_images(file){
    fileInput = '#'+$(file).attr('id');
 if (file.files && file.files[0]) {
               var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = new Image;
                        img.onload = function() {
                        var imageheight = img.height;
                        var imageWidth = img.width;
                        var s = ~~(file.files[0].size/1024) +'KB';
                        var kbs = ~~(file.files[0].size/1024);
			//for cover image
                        if(fileInput == '#SalonCoverImage'){
                            var thecheckimage = checkbannerimagedata(parseInt(imageWidth),parseInt(imageheight),kbs);
			    if(thecheckimage == 'resize'){
                                $('#resize').val('1');
				thecheckimage = 'success';
			    }if(thecheckimage == 'success'){  
                                $(document).find(fileInput).closest('.previewInput').prev('.preview').html('<img src='+e.target.result+' width="200" height="150" />');
                            }else{
                                $('#resize').val('0');
                                if(thecheckimage == 'size-error'){
                                    $(document).find(fileInput).val('');  
                                    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
                                    var msg = 'Images should be upto 350 KB in size';
                                    bootbox.alert(msg);
                                    return msg;

				}else if(thecheckimage == 'limit-error'){
                                    $(document).find(fileInput).val('');  
                                    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
                                    var msg = 'Images should be landscape (wide, not tall) and minimum width of 1700 pixels and height of 800 pixels are required.';
                                    bootbox.alert(msg);
                                    return msg;
				}else if(thecheckimage == 'resize-error'){
				    alert('Images should be in the ratio of 2:1.');

				}
                            }
                        }if(fileInput == '#UserImage'){
                            if(imageWidth < 554 && imageheight < 310)
                            //if(imageheight != 476 || imageWidth != 1423)
                            {
                                    $(document).find(fileInput).val('');  
                                    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
				var msg = 'Minimum height and width of file should be 310 * 554.'
                                    bootbox.alert(msg);
                                    return msg;
                            }
			    else{ 
				 $(document).find(fileInput).closest('.previewInput').prev('.preview').html('<img src='+e.target.result+' width="200" height="150" />');
			     }
			 }
			
                        
                      };
                      img.src = reader.result;
                       
                    };
                    reader.readAsDataURL(file.files[0]);
        }
   }
</script>
