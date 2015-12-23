<style>
    .pac-container {
    z-index:99999;
}
</style>
<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('User', array('url' => array('controller' => 'Settings', 'action' => 'business_details','admin'=>true),'id'=>'opeaningContactForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2>Business Details</h2>
        </div>
        <div class="modal-body clearfix">
            <div class="col-sm-12 nopadding">
                <div class="box">
                    <div class="box-content form-horizontal nopadding">
                        <div class="form-group">
                            <label class="control-label col-sm-4">Business Email*:</label>
                               <?php echo $this->Form->hidden('User.id',array('label'=>false,'div'=>false));?>
                               
                               <?php $patern = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" ?>
                               
                               <?php echo $this->Form->input('Salon.email',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','validationMessage'=>"Business Email is required.",'required',"data-email-msg"=>"Email is required..",'pattern'=>$patern,'data-pattern-msg'=>"Please enter a valid email address."));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Business Website:</label>
                               <?php echo $this->Form->hidden('Salon.id',array('label'=>false,'div'=>false));?>
                               <?php echo $this->Form->hidden('Salon.user_id',array('label'=>false,'div'=>false));?>
                                <?php $pattern ='(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})';?>
                               <?php echo $this->Form->input('Salon.website_url',array('label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','pattern'=>$pattern,'data-pattern-msg'=>"Please enter a valid url."));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Business Address*:</label>
                               <?php echo $this->Form->hidden('Address.id',array('label'=>false,'div'=>false));?>
                               <?php echo $this->Form->hidden('Address.user_id',array('label'=>false,'div'=>false));?>
                               <?php echo $this->Form->input('Address.address',array('type'=>'text', 'id'=>'AddressAddressPop','label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control','validationMessage'=>"Street Address is required.",'required'));?>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Business Mobile 1:</label>
                            <?php echo $this->Form->hidden('Contact.id',array('label'=>false,'div'=>false));?>
			    <?php echo $this->Form->hidden('Contact.user_id',array('label'=>false,'div'=>false));?>
			    <div class="col-sm-8 nopadding">
			    <?php echo $this->Form->input('country_code',array('label'=>false,'div'=>array('class'=>'col-sm-3 col-xs-4'),'class'=>'form-control','value'=>$country_code,"readonly"));?>
			    <?php echo $this->Form->input('Contact.day_phone',array('label'=>false,'div'=>array('class'=>'col-sm-6 col-xs-8 lft-p-non'),'class'=>'form-control numOnly','maxlength'=>11,'data-maxlengthcustom-msg'=>"Maximum 10 characters.",'maxlengthcustom'=>'10'));?>
			    </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Business Mobile 2:</label>
			    <div class="col-sm-8 nopadding">
                                 <?php echo $this->Form->input('country_code',array('label'=>false,'div'=>array('class'=>'col-sm-3 col-xs-4'),'class'=>'form-control','value'=>$country_code,"readonly"));?>
				 
                                 <?php echo $this->Form->input('Contact.night_phone',array('label'=>false,'div'=>array('class'=>'col-sm-6 col-xs-8 lft-p-non'),'class'=>'form-control numOnly','maxlength'=>11,'data-maxlengthcustom-msg'=>"Maximum 10 characters.",'maxlengthcustom'=>'10'));?>
			    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-3 pull-right">
                <input type="submit" name="next" class="submitContactForm btn btn-primary" value="Next" />
            </div>
           <!-- <div class="col-sm-3 pull-right">
                <input type="button" name="next" class="skipContactForm btn btn-primary" value="Skip" />
            </div>-->
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
Custom.init();
$('.numOnly').keyup(function(){
    var value = $(this).val();
    if(isNaN(value)){
	$(this).val('');
    }
});
</script>

<script>
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