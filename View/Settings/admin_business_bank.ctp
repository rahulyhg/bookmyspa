<style>
    .pac-container {
    z-index:99999;
}
</style>
<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('BankDetail', array('url' => array('controller' => 'Settings', 'action' => 'business_bank','admin'=>true),'id'=>'bankDForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2 class="no-mrgn"><?php echo ucfirst($auth_user['Salon']['eng_name']); ?> Details ?</h2>
        </div>
        <div class="modal-body clearfix">
            <div class="col-sm-12 nopadding">
                <div class="box">
                    <div class="box-title">
                        <h3><i class="glyphicon-settings"></i>Business Description</h3>
                    </div>
                    <div class="box-content  pdng-lft-rgt-non">
                        <div class="form-group form-horizontal">
                            <label class="control-label col-sm-4  pdng-lft-rgt-non">Description*:</label>
                            <?php echo $this->Form->input('Salon.eng_description',array('type'=>'textarea','label'=>false,'div'=>array('class'=>'col-sm-8  pdng-lft-rgt-non'),'class'=>'form-control','validationMessage'=>'Description is required.','required'=>true));?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 nopadding">
                <div class="box ">
                    <div class="box-title">
                        <h3>
                            <i class="glyphicon-settings"></i>
                            Bank Details
                        </h3>
                    </div>
                    <div class="box-content form-horizontal pdng-lft-rgt-non">
                        <?php echo $this->Form->hidden('BankDetail.id',array('label'=>false,'div'=>false)); ?>  
<?php echo $this->Form->hidden('BankDetail.user_id',array('label'=>false,'div'=>false)); ?> 
<div class="form-group">
    <label class="control-label col-sm-4">Account Holder Name*:</label>
       <?php echo $this->Form->input('BankDetail.account_holder_name',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','minlength'=>'3','maxlength'=>'30','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Account holder name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-pattern-msg'=>"Please enter only alphabets."));?>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">Account Number*:</label>
         <?php echo $this->Form->input('BankDetail.account_number',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control numOnly','minlength'=>'8','data-minlength-msg'=>"Minimum 8 characters are allowed.",'maxlengthcustom'=>'30','maxlength'=>'31','required','validationMessage'=>"Account number is required.",'data-maxlengthcustom-msg'=>"Maximum 30 characters are allowed."));?>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">IBAN*:</label>
        <?php echo $this->Form->input('BankDetail.iban',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','required','minlength'=>'3','maxlength'=>'31','data-minlength-msg'=>"Minimum 3 characters are allowed.",'maxlengthcustom'=>'30','pattern'=>'^[A-Za-z0-9]*$','data-pattern-msg'=>"Please enter only alphanumeric values.",'data-maxlengthcustom-msg'=>"Maximum 30 characters are allowed.",'ValidationMessage'=>'IBAN number is required.'));?>
 </div>
<div class="form-group">
    <label class="control-label col-sm-4">Swift Code*:</label>
    <?php echo $this->Form->input('BankDetail.swift_code',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters are allowed.",'required','ValidationMessage'=>'Swift code is required.'));?>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">Bank Name*:</label>
        <?php echo $this->Form->input('BankDetail.bank_name',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','required','ValidationMessage'=>'Bank name is required.','pattern'=>'^[A-Za-z ]+$','data-pattern-msg'=>"Please enter only alphabets.",'minlength'=>'3','maxlength'=>'31','data-minlength-msg'=>"Minimum 3 characters are allowed.",'maxlengthcustom'=>'30','data-maxlengthcustom-msg'=>"Maximum 30 characters are allowed."));?>
 </div>
<div class="form-group">
    <label class="control-label col-sm-4">Bank Address*:</label>
        <?php
	
	
	echo $this->Form->input('BankDetail.bank_address',array('type'=>'text','label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','required','ValidationMessage'=>'Bank address is required.','maxlength'=>'250','id'=>'AddressAddressPop'));?>
</div>
<div class="form-group">
    <label class="control-label  col-sm-4">Postcode*:</label>
        <?php echo $this->Form->input('BankDetail.postcode',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control numOnly','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters are allowed.",'required','ValidationMessage'=>'Postcode is required.'));?>
</div>
<div class="form-group">
    <label class="control-label  col-sm-4">Country*:</label>
    <div class="col-sm-8">
        <?php echo $this->Form->input('BankDetail.country',array('options'=>$countryData,'label'=>false,'div'=>false,'class'=>'form-control BankDetailCountry','empty'=>'Please Select','required','ValidationMessage'=>'Country is required.'));?>
    </div>
</div>
<div class="form-group">
    <label class="control-label  col-sm-4">City*:</label>
        <?php echo $this->Form->input('BankDetail.state',array('options'=>$stateData,'label'=>false,'div'=>array('class'=>'col-sm-8 dynaimic_state'),'class'=>'form-control  BankDetailState','empty'=>'Please Select','required','ValidationMessage'=>'City is required.'));?>
</div>
<div class="form-group	">
    <label class="control-label  col-sm-4">Location/Area:</label>
        <?php echo $this->Form->input('BankDetail.city',array('options'=>$cityData,'label'=>false,'div'=>array('class'=>'col-sm-8 dynaimic_city'),'class'=>'form-control BankDetailCity','empty'=>'Please Select'));?>
</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-3 pull-right">
                <input type="submit" name="next" class="submitbankForm btn btn-primary" value="Next" />
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    $(document).ready(function(){
	var regValidator = $("#BankDetailAdminBankDetailsForm").kendoValidator({
	rules:{
	    minlength: function (input) {
                return minLegthValidation(input);
	    },
	    maxlength: function (input) {
		return maxLegthValidation(input);
	    },
	    maxlengthcustom: function (input) {
                    return maxLegthCustomValidation(input);
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
        
        
    });
    $(document).on('change' ,'.BankDetailCountry', function(){
        var state_url = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>"+'/'+$(this).val();
        $(document).find('.dynaimic_state').load(state_url , function(){
            var forDynCity = $(document).find('.dynaimic_state');
            forDynCity.find('label').remove();
            forDynCity.find('select').attr('name','data[BankDetail][state]').addClass('form-control  BankDetailState');
        });
    });
    $(document).on('change' ,'.BankDetailState', function(){
        var state_url = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>"+'/'+$(this).val();
        $(document).find('.dynaimic_city').load(state_url , function(){
            var forDynCity = $(document).find('.dynaimic_city');
            forDynCity.find('label').remove();
            forDynCity.find('select').attr('name','data[BankDetail][city]').addClass('form-control BankDetailCity');
        });
    });

$(function(){
      initialize('are');
   });
    
    function initialize(iso){
	autocomplete = new google.maps.places.Autocomplete(
	    
	     /** @type {HTMLInputElement} */(document.getElementById('AddressAddressPop')),
	     {types:  ['geocode'],componentRestrictions: {country:iso} });
	      google.maps.event.addListener(autocomplete, 'place_changed', function() {
	  });
	// console.log(autocomplete);
     }
</script>