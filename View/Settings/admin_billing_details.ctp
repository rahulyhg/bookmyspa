<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="col-sm-6 box-content">  
                <?php echo $this->Form->create('BillingDetail',array('id'=>'BillingForm','novalidate','class'=>'form-horizontal'));?>
                <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>  
                <?php echo $this->Form->hidden('user_id',array('label'=>false,'div'=>false)); ?>  
                <div class="form-group">
                    <label class="control-label col-sm-4">Company Title*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('company_title',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'30','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Company title is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-pattern-msg'=>"Please enter only alphabets."));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Company Number:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('company_number',array('label'=>false,'div'=>false,'class'=>'form-control numOnly','maxlength'=>'50','minlength'=>'3'));?>
                    </div>
                </div>
		<div class="form-group">
                    <label class="control-label col-sm-4">License Number:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('licence_no',array('label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>'25'));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Address*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('address',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>'500','required','ValidationMessage'=>'Address is required.','id'=>'AddressAddress'));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Postcode*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('postcode',array('label'=>false,'div'=>false,'class'=>'form-control numOnly','required','ValidationMessage'=>'Postcode is required.'));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Country*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('country_id',array('empty'=>'Please Select','options'=>$countryData,'label'=>false,'div'=>false,'class'=>'form-control','required','ValidationMessage'=>'Please select Country.'));?>
                    </div>
                </div>
		<div class="form-group dynamicstate">
                    <label class="control-label col-sm-4">City*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('state_id',array('options'=>$states,'label'=>false,'div'=>false,'class'=>'form-control','required','ValidationMessage'=>'Please select City.'));?>
                    </div>
                </div>
                <div class="form-group dynamiccity">
                    <label class="control-label col-sm-4">Location/Area*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('city_id',array('options'=>$cities,'label'=>false,'div'=>false,'class'=>'form-control','required','ValidationMessage'=>'Please select Location.'));?>
                    </div>
                </div>
		<hr>
                <div class="form-group">
                    <label class="control-label col-sm-4">Operating Country*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('operating_country',array('options'=>$countryData,'label'=>false,'div'=>false,'class'=>'form-control','required','ValidationMessage'=>'Please select operating country.'));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Operation Currency</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('operation_currency',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'1','maxlengthcustom'=>'30','maxlength'=>'30','pattern'=>'^[A-Za-z ]+$','data-minlength-msg'=>"Minimum 1 characters.",'data-maxlengthcustom-msg'=>"Maximum 30 characters.",'data-pattern-msg'=>"Please enter only alphabets."));?>
                    </div>
                </div>
		<hr>
		<h3>Billing Contact Person</h3>
                <div class="form-group">
                    <label class="control-label col-sm-4">Contact Name*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('contact_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlengthcustom'=>'30','maxlength'=>'35','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Contact name is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 30 characters.",'data-pattern-msg'=>"Please enter only alphabets."));?>
                    </div>
                </div>
		<div class="form-group">
                    <label class="control-label col-sm-4">Email*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('email',array('label'=>false,'div'=>false,'class'=>'form-control','empty'=>'Please Select','required','ValidationMessage'=>'Please enter valid email.'));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Phone*:</label>
		    <div class=" col-sm-8 nopadding">
			<div style="padding-left:15px !important;" class="col-sm-3 col-xs-3 nopadding ">
			    <?php echo $this->Form->input('code',array('type'=>'text','value'=>'','class'=>'form-control numOnly', 'div'=>false,'label'=>false,'value'=>$country_code));?>
			</div>
			<div class="col-sm-9 col-xs-9 ">
			    <?php echo $this->Form->input('phone',array('label'=>false,'div'=>false,'class'=>'form-control numOnly phone_err','empty'=>'Please Select','required','ValidationMessage'=>'Please select phone.'));?>
			</div>
                    </div>
                </div>
		<div class="form-group">
                    <label class="control-label col-sm-4">Contact Phone*:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('contact_phone',array('label'=>false,'div'=>false,'class'=>'form-control numOnly phone_err','empty'=>'Please Select','required','ValidationMessage'=>'Please select contact phone.'));?>
                    </div>
                </div>
		<div class="form-group">
                    <label class="control-label col-sm-4">&nbsp;</label>
                    <div class="col-sm-8">
                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary ','label'=>false,'div'=>false));?>
                            <?php //echo $this->Html->link('Cancel',array('controller'=>'dashboard','action'=>'index','admin'=>true),array('escape'=>false,'class'=>'btn ')); ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
     $(document).ready(function(){
		var regValidator = $("#BillingForm").kendoValidator({
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
    var phoneCode = '';
	var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
        $(document).on('change','#BillingForm #BillingDetailCountryId',function() {
            var id = $(this).val();
            $(document).find('#BillingForm .dynamicstate').load(getStateURL+'/'+id,function(){
		var thisSOBJ  = $(document).find('#BillingForm .dynamicstate');
		thisSOBJ.find('select').attr({'id':'BillingDetailStateId','name':'data[BillingDetail][state_id]'}).addClass('form-control');
		thisSOBJ.find('div').addClass('col-sm-8');thisSOBJ.find('label').addClass('col-sm-4');
		$.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
                        success: function(res) {
                            phoneCode = res;
			    $('#BillingDetailCode').val(res);
                        }
                    });
	    });
        });
       
	var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
        $(document).on('change','#BillingForm #BillingDetailStateId',function() {
           var id = $(this).val();
	    $('#BillingForm .dynamiccity').load(getCityURL+'/'+id,function(){
		var thisCOBJ = $(document).find('#BillingForm .dynamiccity')
		thisCOBJ.find('select').attr({'id':'BillingDetailCityId','name':'data[BillingDetail][city_id]'}).addClass('form-control');
		thisCOBJ.find('div').addClass('col-sm-8');thisCOBJ.find('label').addClass('col-sm-4');
	    });
        });
	$('#BillingDetailPhone').focus(function(){
	   if(phoneCode){
		$(this).val(phoneCode);
	    }
	});

    });
    
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