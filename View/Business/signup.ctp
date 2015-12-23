<div class="container">
<style>
.select2-container .select2-choice span {
    display: inline !important;
}
</style>
<?php //echo $this->Html->script('admin/jquery.geocomplete.js');?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script> 
<div class="radio_tabs" onload="">
    <?php echo $this->Form->create('User',array('novalidate','id'=>"msform"));  ?>
        <!-- progressbar -->
	<ul id="progressbar">
            <li class="active"><?php echo __('Details',true); ?></li>
            <li><?php echo __('Information',true);?></li>
            <li><?php echo __('Verification',true);?></li>
            <li><?php echo __('Finish',true);?></li>
	</ul>
	<!-- fieldsets -->
	<fieldset>
	    <div class="col-sm-6 pos-rgt">
		<div class="steps-lft-container">
                    <div class="photo"><?php echo $this->Html->image('frontend/girl.png'); ?></div>
		    <div class="foot">
			 <h3><?php echo __('booking_24_7',true); ?></h3>
			 <p><?php echo __('booking_24_7_txt',true); ?></p>
		    </div>
		</div>
		<div class="steps-lft-container">
			<div class="photo"><?php echo $this->Html->image('frontend/girl-msz-found.png'); ?></div>
		    <div class="foot">
			<h3>REMINDER TO YOUR CUSTOMERS</h3>
			<p>Our salon software allows you to send email and
                            SMS text notifications to your clients.                 
                                            </p>
                                            <p>Remind them to confirm their appointments, so you
                            won't have to pick up a phone &amp; minimize no show.
			</p>
		    </div>
		</div>
		<div class="clearfix"></div>
	    </div>
            <div class="col-sm-6 pos-lft">
                <div class="well text-left custom_well">
                    <h2 class="fs-title"><?php echo __('Details',true); ?></h2>
                    <div class="form-group">
                        <label><?php echo __('Business Type',true); ?>*:</label>
                        <?php echo $this->Form->input('Salon.business_type_id',array('id'=>'customSelect','options'=>$bTypes,'label'=>false,'div'=>true,'multiple'=>true,'required','validationMessage'=>"Please select Business Type.")); ?>
                    </div>
                     <?php echo $this->Form->hidden('type');?>
		    <div class="form-group">
		      <?php
		      $typeError =false;
		      $errorclass='';
		      $formErrorclass = '';
		      if(isset($this->request->data['User']['type']) && empty($this->request->data['User']['type'])){    
			    $typeError = true;
			    $errorclass = 'error';
			    $formErrorclass = 'form-error';
		        }
		       ?>
		        <label><?php echo __('Business Model',true); ?>*:</label>
                        <?php $userType = $this->Common->businessModal(); ?>
                        <?php
                        $tmpitsval = "";
                        if(isset($this->data['User']['typeTemp']) && !empty($this->data['User']['typeTemp'])){
                            $tmpitsval = $this->data['User']['typeTemp'];
                        }
                        elseif(isset($this->data) && !empty($this->data)){
                            $tmpitsval = $this->data['User']['type'];
                            if(isset($this->data['User']['type']) && isset($this->data['User']['parent_id']) && $this->data['User']['type'] == 4 && $this->data['User']['parent_id']>0){
                                
                                $tmpitsval = '-1';
                            }
                        }
		     ?>
		   <?php echo $this->Form->input('typeTemp',array('empty'=>'Please Select','options'=>$userType,'class'=>'typeTemp_option '.$formErrorclass.'','value'=>$tmpitsval,'div'=>array('class'=>''.$errorclass.''),'label'=>false,'required','validationMessage'=>"Please select Business Model."));?>
		   <?php if($typeError){?>
		    <div class="error-message">Business Model is required</div>
		    <?php } ?>
		    </div>
		    <?php
		    $parentStyle = "display:none;";
		    if((isset($this->request->data['User']['parent_id']) && !empty($this->request->data['User']['parent_id']) && ($this->request->data['User']['parent_id'] != 0))||(isset($this->request->data['User']['typeTemp']) && ($this->request->data['User']['typeTemp']=='-1'))){
			$parentStyle = "display:block;";
		    }
		    ?>
                    <div class="form-group selFrenchise" style="<?php echo $parentStyle;?>">
                        <label><?php echo __('Franchise',true); ?>*:</label>
                        <?php echo $this->Form->input('parent_id',array('empty'=>'Please Select','options'=>$frenchList,'class'=>'parentcustom_option','label'=>false,'required'=>'false','validationMessage'=>"Please select Franchise."));?>
                    </div>
                    <div class="form-group">  
                        <label><?php echo __('Business Name',true); ?>*:</label>
                        <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
                        <?php echo $this->Form->hidden('Salon.id',array('label'=>false,'div'=>false));?>
                        <?php echo $this->Form->input('Salon.eng_name',array('label'=>false,'type'=>'text','class'=>'form-control','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters are allowed.",'validationMessage'=>"Business Name is required." ,'maxlength'=>204,'data-maxlengthcustom-msg'=>"Maximum 200 characters.",'maxlengthcustom'=>'200'));?>
                    </div>
                    <div class="form-group">  
                        <label><?php echo __('Service Provided to',true); ?>*:</label>
                        <?php $serviceTo = $this->Common->serviceprovidedTo(); ?>
                        <?php echo $this->Form->input('Salon.service_to',array('empty'=>'Please Select','options'=>$serviceTo,'class'=>'custom_option','label'=>false,'required','validationMessage'=>"Please select Service Provided to."));?>
                        <?php echo $this->Form->hidden('Address.id',array('label'=>false,'div'=>false));?>
                    </div>
                    <div class="form-group">  
                        <div class="row">
                            <div class="col-sm-5 padding_rt_zero flag pos-rgt">
                                <label><?php echo __('Country',true); ?>*:</label>
				<div class="dynamiccountry">
                                <?php
				  echo $this->Form->input('Address.country_id',array('class'=>'custom_optionCountry','options'=>$countryData,'empty'=>'Please Select','label'=>false,'required','validationMessage'=>"Please select Country."));
                                  ?>
				</div>
                            </div>
                            <div class="col-sm-7 pos-lft">
                                <label><?php echo __('City',true); ?>*:</label>
                                <div class="dynamicstate">
                                    <?php
                                    echo $this->Form->input('Address.state_id',array('class'=>'custom_option','options'=>$stateData,'empty'=>'Please Select','label'=>false,'required','validationMessage'=>"Please select City.")); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group location">  
                        <label><?php echo __('Location / Area',true); ?>*:</label>
                        <div class="dynamiccity">
                            <?php echo $this->Form->input('Address.city_id',array('class'=>'custom_option','options'=>$cityData,'empty'=>'Please Select','label'=>false,'required','validationMessage'=>"Please select Location / Area."));?>
                        </div>
                    </div>
                    <div class="form-group">  
                        <label><?php echo __('Street Address',true); ?>*:</label>
                        <?php echo $this->Form->input('Address.address',array('label'=>false,'type'=>'text','class'=>'form-control','validationMessage'=>"Street Address is required.",'required','maxlength'=>102,'data-maxlengthcustom-msg'=>"Maximum 100 characters.",'maxlengthcustom'=>'100'));?>
                    </div>
                    <div class="form-group">  
                        <label><?php echo __('PO Box',true); ?>*:</label>
                        <?php echo $this->Form->input('Address.po_box',array('label'=>false,'type'=>'text','class'=>'form-control number','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters are allowed.",'required','validationMessage'=>"PO Box is required.",'maxlength'=>11,'data-maxlengthcustom-msg'=>"Maximum 10 characters.",'maxlengthcustom'=>'10'));?>
                    </div>
                    <div class="form-group">  
                        <label><?php echo __('Business E-mail',true); ?>*:</label>
			<?php $patern = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" ?>
                        <?php echo $this->Form->input('Salon.email',array('type'=>'email','div'=>false,'label'=>false,'class'=>'form-control','pattern'=>$patern,'data-pattern-msg'=>"Please enter a valid email address.",'required','validationMessage' => 'Business E-mail is required.','data-email-msg' => 'Please enter valid email address.','maxlength'=>55));  ?>
                    </div>
                    <div class="form-group">  
                        <label><?php echo __('Business Phone',true); ?></label>
                        <div class="row">
                            <div class="col-sm-3 col-xs-3 padding_rt_zero">
                                <input type="text" value="<?php echo $countryCode; ?>" class="cPHcd form-control" maxlength="4" readonly >
                            </div>
                            <div class="col-sm-9 col-xs-9">
                                <?php echo $this->Form->hidden('Contact.id',array('label'=>false,'div'=>false));?>
                                <?php echo $this->Form->input('Contact.day_phone',array('type'=>'text','div'=>false,'label'=>false,'class'=>'form-control number','maxlength'=>11,'data-maxlengthcustom-msg'=>"Maximum 10 characters.",'maxlengthcustom'=>'10'));  ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">  
                        <label><?php echo __('Business Mobile ',true); ?></label>
                        <div class="row">
                            <div class="col-sm-3 col-xs-3 padding_rt_zero">
                                <input type="text" value="<?php echo $countryCode; ?>" class="cPHcd form-control" maxlength="4" readonly >
                            </div>
                            <div class="col-sm-9 col-xs-9">
                                <?php echo $this->Form->input('Contact.night_phone',array('type'=>'text','div'=>false,'label'=>false,'class'=>'form-control number','maxlength'=>16,'data-maxlengthcustom-msg'=>"Maximum 15 characters.",'maxlengthcustom'=>'15'));  ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
			<?php $pattern = '(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})';?>
                        <label><?php echo __('Your Current Business Website',true); ?></label>
                        <?php echo $this->Form->input('Salon.website_url',array('type'=>'text','div'=>false,'pattern'=>$pattern,'data-pattern-msg'=>"Please enter a valid url.",'label'=>false,'class'=>'form-control','placeholder'=>__('http://www.xyz.com',true)));  ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo __('Personal Sieasta URL',true); ?>*:</label>
			<?php $paternurl = "^[A-Za-z'\-]+$"; ?>
			 <div class="row">
			    <div class="col-sm-4 pdng-top-7">
		     <em class="MoreInfoSieasta"><?php echo __('www.sieasta.com/',true); ?></em>
			    </div>
			    <div class="col-sm-8">
                           <?php echo $this->Form->input('Salon.business_url',array('type'=>'text','div'=>false,'label'=>false,'class'=>'form-control','pattern'=>$paternurl,'data-pattern-msg'=>"Please enter only alphabets and (-).",'required','validationMessage'=>"Personal Sieasta URL is required."));  ?>
			</div>
			 </div>
                        <?php //echo $this->Form->input('Salon.business_url',array('type'=>'text','div'=>false,'label'=>false,'class'=>'form-control','pattern'=>$paternurl,'data-pattern-msg'=>"Please enter only alphabets and (-).",'required','validationMessage'=>"Personal Sieasta URL is required."));  ?>
                    </div>
                    <div class="form-group pos-rel clearfix">  
                        <?php 
                        $label = __('I agree to',true).'&nbsp;';
                        $label .=  $this->Html->link(__('terms and conditions.',true),array('controller'=>'StaticPages','action'=>'legal',14),array('escape'=>false,'target'=>'_blank' ));
                        echo $this->Form->input('terms_n_condition',array('type'=>'checkbox','div'=>false,'label'=>array('class'=>'new-chk','text'=>$label),'required','validationMessage'=>__("Terms and conditions are required.",true)));  
                        ?>   
                        <dfn class="text-danger k-invalid-msg" data-for="data[User][terms_n_condition]" role="alert" style="display: none;"><?php echo __("Terms and Conditions are required.",true); ?></dfn>
                        <?php if(isset($this->validationErrors['User']['terms_n_condition']['0'])){ ?>
                        <div class="error-message"><?php echo $this->validationErrors['User']['terms_n_condition']['0'];  ?></div>
                       <?php } ?>
                    </div>
                    <!--<input type="button" name="next" class="next black_btn action-button margin_rt20" value="Cancel" />-->
                    <?php echo $this->Form->submit(__('Next',true),array('class'=>'pull-right  pos-lft action-button','div'=>false,'label'=>false));  ?>
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
        var geocoder;
	var Country;
	var State;
	var City;
    setTimeout(function(){callRequiredForm();},2000); 
    
    
    
    $('#customSelect').parent('.input.select.required').on('keypress, click',function(e){
          var keyCode = e.keyCode || e.which; 
            if (keyCode == 9) { 
                 custom_error($('#customSelect')); 
             } 
     });

    $(document).on('change','#customSelect ,#UserTypeTemp ,#SalonServiceTo ,#AddressCountryId ,#AddressStateId , #AddressCityId ,#UserParentId',function(e){
	custom_error($(this)); 
    });
  
    /************************VALIDATIONS ***************************************/
  
	
	// if(prodValidator.validate() == false){
	   
	//   
	// }
	$('#customSelect').multipleSelect({
            width: '100%',
	    selectedText:'Please Select',
            placeholder:'Please Select'
        });
        
//	$(document).find(".parentcustom_option , .custom_option").select2().on("open",function(e){
//	log("select2:open", e); 
//       
//        });
        $(document).find('#SalonServiceTo').select2().on("close",function(){
            $('#s2id_SalonServiceTo').removeClass('purple-bod');        
        custom_error($('#SalonServiceTo'));  
        }).on("open" , function(){
             $('#s2id_SalonServiceTo').addClass('purple-bod');   
        });
        $(document).find('#AddressStateId').select2().on("close",function(){
            $('#s2id_AddressStateId').removeClass('purple-bod');     
            custom_error($('#AddressStateId'));  
        }).on('open' , function(){
          $('#s2id_AddressStateId').addClass('purple-bod');  
        });
        
        $(document).find('#AddressCityId').select2().on("close",function(){
	    $('#s2id_AddressCityId').removeClass('purple-bod'); 
            custom_error($('#AddressCityId'));
	    
        }).on('open' , function(){
            $('#s2id_AddressCityId').addClass('purple-bod');  
        });
        
//        $(document).find('#UserParentId').select2().on("close",function(){
//	    $('#s2id_UserParentId').removeClass('purple-bod'); 
//            custom_error($('#AddressCityId'));  
//        }).on('open' , function(){
//            $('#s2id_UserParentId').addClass('purple-bod');  
//        });
        
        $(document).find(".typeTemp_option").select2().on("change", function(e) {
            $(document).find('#SalonEngName').val('');
	    if(e.val == -1 ){
                $("#UserType").val(4);
                $(document).find('.selFrenchise').show();
		//$(document).find('#SalonEngName').attr('readonly' , 'readonly');
                $(document).find('.parentcustom_option').attr('required','required').select2();
                
            }else{
                if(e.val !=''){
                     $("#UserType").val($(this).find(":selected").val());
		     
                }else{
                    $(this).val(e.val);
                }
		//$(document).find('#SalonEngName').removeAttr('readonly');
                $(document).find('.selFrenchise').hide();
                $(document).find('.parentcustom_option').removeAttr('required').removeClass('k-invalid').select2("val", "");
            }   
        }).on("close",function(){
            $('#s2id_UserTypeTemp').removeClass('purple-bod'); 
            custom_error($('#UserTypeTemp'));  
        }).on("open" , function(){
           $('#s2id_UserTypeTemp').addClass('purple-bod'); 
        });
	
	
	$(document).find(".parentcustom_option").select2().on("change", function(e) {
            $(document).find('#SalonEngName').val($(document).find('#UserParentId option[value='+e.val+']').html()).change();
	    //$(document).find('#SalonEngName').attr('readonly', 'readonly');
        }).on("close",function(){
            $('#s2id_UserParentId').removeClass('purple-bod'); 
            custom_error($('#UserParentId'));  
        }).on("open" , function(){
           $('#s2id_UserParentId').addClass('purple-bod'); 
        });
	
        
        
        function formatFlags(state){
	   
		if (!state.id) return state.text; 
		return "<img style='padding-right:10px;' class='pos-rgt flag' src='/img/flags/" + state.id.toLowerCase() + ".gif'/><span class='state-name' >" + state.text + "</span>";
	}
	
        $(document).find(".custom_optionCountry").select2({
		formatResult    : formatFlags,
		formatSelection : formatFlags,
		escapeMarkup: function(m) { return m; }
                
	}).on("change", function(e){
	       var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
                if(e.val){
		    getIsoCode(e.val);
		    $('#msform .dynamicstate').load(getStateURL+'/'+e.val,function(){
                        var forDynState = $(document).find('#msform .dynamicstate');
                        forDynState.find('label').remove();
                        forDynState.find('select').select2().on("close",function(){
				$('#s2id_AddressStateId').removeClass('purple-bod');     
			    	custom_error($('#AddressStateId'));  
			    }).on('open' , function(){
				$('#s2id_AddressStateId').addClass('purple-bod');  
			    }).on("change",function(eal){
				var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
				if(eal.val){
				    $('#msform .dynamiccity').load(getCityURL+'/'+eal.val,function(){
					var forDynCity = $(document).find('#msform .dynamiccity');
					forDynCity.find('label').remove();
					forDynCity.find('select').select2().on("close",function(){
                                                $('#s2id_AddressCityId').removeClass('purple-bod'); 
                                                custom_error($('#AddressCityId'));
						close_city();
                                             }).on('open' , function(){
                                                $('#s2id_AddressCityId').addClass('purple-bod');  
                                        });;
				    });
			       }
			    });
                    });
                    $.ajax({
			    url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+e.val,
			    success: function(res) {
				$(document).find('.cPHcd').val(res);
			    }
			});
                }
                var forDynCity = $(document).find('#msform .dynamiccity select').html('').select2();
                
        }).on("open",function(){
	    $('#s2id_AddressCountryId').addClass('purple-bod');
        }).on("close", function(){
            $('#s2id_AddressCountryId').removeClass('purple-bod'); 
            custom_error($('#AddressCountryId'));  
        });
        
        $(document).find("#AddressStateId").on("change",function(eal){
            var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
            if($(this).find(":selected").val()){
                $('#msform .dynamiccity').load(getCityURL+'/'+eal.val,function(){
                    var forDynCity = $(document).find('#msform .dynamiccity');
                    forDynCity.find('label').remove();
                    forDynCity.find('select').select2();
                });
            }
        });
	
	//$(document).find('#AddressCityId').on('change' , function(){
	//    console.log('changesss');
	//});
	
	
    });
    
    function close_city(){
	 //$(document).find('#SalonEngName').attr('readonly', 'readonly');
	 var location  = $(document).find('#AddressCityId option:selected').text();
	 user_type = $(document).find('#UserTypeTemp').val();
	// console.log(user_type);
	    if(user_type =='-1'){
	     prev_val =  $(document).find('#SalonEngName').val();  
	     $(document).find('#SalonEngName').val(prev_val +' '+location).change();  
	    }
	 
    }
 function getIsoCode(id){
     $.ajax({
		url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getIsoCode','admin'=>false))?>"+'/'+id,
		success: function(res) {
		    //disableGoogleAutocomplete();
		    initialize(res);
		}
            });
}
    
var autocomplete;
var autocompleteListener;
function disableGoogleAutocomplete() {
    if (autocomplete !== undefined) {
            google.maps.event.removeListener(autocompleteListener);
            google.maps.event.clearInstanceListeners(autocomplete);
	    google.maps.event.clearListeners(autocomplete, "focus");
	    google.maps.event.clearListeners(autocomplete, "blur");
	    google.maps.event.clearListeners(autocomplete, "keydown");
            $(".pac-container").remove();

            console.log('disable autocomplete to GOOGLE');
     }
}
    
</script>


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
	fillInAddress();
     });
	// console.log(autocomplete);
}

function fillInAddress() {
    // Get the postal_code from the autocomplete object.
    var place = autocomplete.getPlace();
   // alert(place);
    for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType] && addressType=='postal_code') {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById("AddressPoBox").value = val;
    }
  }
}


//Autofill Country State and Location/Area
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
} 
//Get the latitude and the longitude;
function successFunction(position) {
    var lat1 = position.coords.latitude;
    var lng1= position.coords.longitude;
   
	$.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'getLocation'))?>",
            type: "POST",
            data: {lat:lat1,lng:lng1},
            success: function(res) {
                var data 	= jQuery.parseJSON(res);
		if(data !=''){
                    Country     = data[0].countries.id;
		    State       = data[0].states.id;
		    City        = data[0].cities.id;
		    IsoCode     = data[0].countries.iso_code;
		    
		    if ($("#AddressCountryId").val() === "") {
			    initialize(IsoCode);
			    $("#AddressCountryId option[value="+Country+"]").attr("selected","selected") ;
			    var test = $(document).find('#msform .dynamiccountry');
			    test.find('label').remove();
			    test.find('select').select2(
				{
				    formatResult    : functionMy,
				    formatSelection : functionMy,
				    escapeMarkup: function(m) { return m; }
				 }	      
			    );
			   //----
		    }
		    
		     if ($("#AddressStateId").val() === "") {
			    var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
		    
			$('#msform .dynamicstate').load(getStateURL+'/'+Country,function(){
			    var forDynState = $(document).find('#msform .dynamicstate');
			     $("#AddressStateId option[value="+State+"]").attr("selected","selected") ;
			    forDynState.find('label').remove();
			     forDynState.find('select').select2();
			});
		     }
		     
		     if ($("#AddressCityId").val() === "") {
                            var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
			  $('#msform .dynamiccity').load(getCityURL+'/'+State,function(){
			      var forDynCity = $(document).find('#msform .dynamiccity');
			       $("#AddressCityId option[value="+City+"]").attr("selected","selected") ;
			      forDynCity.find('label').remove();
			      forDynCity.find('select').select2();
			  });
		     }
		  
		if($(document).find('.cPHcd').val() === ''){
		  $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+Country,
                        success: function(res) {
                            $(document).find('.cPHcd').val(res);
                        }
                    });
		}
		}else{
		       console.log('Detail not found');//----
		}
	    }
        });

   // codeLatLng(lat, lng)
}

function errorFunction(){
 console.log("Geocoder failed");
}

 // function initialize() {
 geocoder = new google.maps.Geocoder();

 function functionMy(state){
		if (!state.id) return state.text; 
		return "<img style='padding-right:10px;' class='pos-rgt flag' src='/img/flags/" + state.id.toLowerCase() + ".gif'/><span class='state-name' >" + state.text + "</span>";
	}

 // }
// 
  
 var prodValidator ;
$(function(){
        prodValidator = $("#msform").kendoValidator({
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
    	
    $(".action-button").on("click",function(e){
	
	if(prodValidator.validate() == false){
	   if($("#customSelect").hasClass("k-invalid")){
		$("#customSelect").prev("div").addClass("k-invalid");
	    }
	    if($("#UserTypeTemp").hasClass("k-invalid")){
		e.preventDefault();
		$("#s2id_UserTypeTemp").addClass("k-invalid");
	    } 
	  
	 }
		
    })
    
    //initialize();
    //$("#AddressAddress").geocomplete();
  });

$(document).on('keyup change','#SalonEngName',function(){
    var theval = $(this).val();
        theval = theval.replace(/\s+/g, '-').toLowerCase()
           $('#SalonBusinessUrl').val(theval);
	   $('#bnsnUrl').html(theval);
        });
$('#SalonBusinessUrl').keyup(function(){
    var theval = $(this).val();
        theval = theval.replace(/\s+/g, '-').toLowerCase()
        $('#bnsnUrl').html(theval);
        });  
        
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
        
//        function log (name, evt) {
//            if (!evt) {
//            var args = "{}";
//            } else {
//            var args = JSON.stringify(evt.params, function (key, value) {
//            if (value && value.nodeName) return "[DOM node]";
//            if (value instanceof $.Event) return "[$.Event]";
//            return value;
//            });
//            }
//            var $e = $("<li>" + name + " -> " + args + "</li>");
//            console.log($e);
////            $eventLog.append($e);
////            $e.animate({ opacity: 1 }, 10000, 'linear', function () {
////            $e.animate({ opacity: 0 }, 2000, 'linear', function () {
////            $e.remove();
////            });
////            });
//        }
    
    
        
</script>
</div>
