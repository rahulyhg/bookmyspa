        <?php echo $this->Form->create('User',array('novalidate','type' => 'file','class'=>'form-vertical'));?>
        <div class="step-forms clearfix col-sm-9">
                <div class="col-sm-6">
                
                <div class="form-group">
                    <label class="control-label"><?php echo __('Zip /Postal Code' , true); ?>*</label>
                    <div>
                            <?php echo $this->Form->input('Address.po_box',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control numOnly','maxlength'=>'10','required','validationMessage'=>"Postal Code is required.",'data-maxlength-msg'=>"Maximum 10 characters.")); ?>
                    </div>
                </div>
                <div class="form-group">
                        <label for="anotherelem" class="control-label"><?php echo __('Country' , true); ?>*</label>
                        <div>
                            <?php echo $this->Form->input('Address.country_id',array('class'=>'form-control','options'=>$countryData,'div'=>false,'empty'=>'Please Select','label'=>false,'required','validationMessage'=>"Please select country."));?>
                        </div>
                </div>
                <div class="form-group dynamicstate">
                        <label for="additionalfield" class="control-label"><?php echo __('City' , true); ?>*</label>
                        <div>
                           <?php echo $this->Form->input('Address.state_id',array('class'=>'form-control','empty'=>'Please Select','div'=>false,'label'=>false,'options'=>@$stateLists,'required','validationMessage'=>"Please select state."));?>
                </div>
                </div>
                <div class="form-group dynamiccity">
                        <label for="additionalfield" class="control-label"><?php echo __('Location/Area' , true); ?>*</label>
                        <div>
                            <?php echo $this->Form->input('Address.city_id',array('class'=>'form-control','empty'=>'Please Select','div'=>false,'label'=>false ,'options'=>@$cities,'required','validationMessage'=>"Please select Location/Area."));?>
                        </div>
                </div>
                <div class="form-group">
                        <label for="additionalfield" class=" control-label"><?php echo __('Address' , true); ?>*</label>
                        <div >
                                <?php echo $this->Form->input('Address.address',array('type'=>'text','id'=>'AddressAddress','label'=>false,'div'=>false,'class'=>'form-control')); ?>
                        </div>
                </div>
                <div class="form-group">
                <label for="additionalfield" class="control-label col-sm-12 nopadding"><?php echo __('Mobile 1' , true); ?>*</label>
                    <div class="col-sm-3 nopadding">
                       <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','class'=>'form-control cPHcd numOnly','div'=>false,'label'=>false, 'value'=>"" ,'maxlength'=>5));?>
                   </div>
                    <div class="col-sm-9">
                         <?php echo $this->Form->input('Contact.cell_phone', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control numOnly', 'maxlength'=>'10','required','validationMessage'=>"Mobile 1 is required.",'data-maxlength-msg'=>"Maximum 100 characters.",'required')); ?>
                    </div>
                </div>
           </div>
                <div class='col-sm-6'>
                    <div class="form-group">
                        <label for="additionalfield" class="control-label col-sm-12 nopadding"><?php echo __('Mobile 2', true); ?> </label>
                          <div class="col-sm-3 nopadding">
                            <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','class'=>'form-control cPHcd numOnly','div'=>false,'label'=>false, 'value'=>"" ,'maxlength'=>5));?>
                         </div>
                        <div class="col-sm-9">
                              <?php echo $this->Form->input('Contact.day_phone',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control numOnly','maxlength'=>'10')); ?>
                        </div>
                    </div> 
                    <div class="clearfix"></div>
                    <div class="form-group mrgn-tp10">
                        <label for="additionalfield" class="control-label col-sm-12 nopadding"><?php echo __('Mobile 3', true); ?> </label>
                        <div class="col-sm-3 nopadding">
                            <?php echo $this->Form->input('Contact.country_code',array('type'=>'text','class'=>'form-control cPHcd numOnly','div'=>false,'label'=>false, 'value'=>"" ,'maxlength'=>5));?>
                        </div>
                        <div class="col-sm-9">
                             <?php echo $this->Form->input('Contact.night_phone', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control numOnly', 'maxlength' => '10')); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 lft-p-non mrgn-tp10">
                            <?php echo $this->Form->input('UserDetail.booking_incharge', array('div' => false, 'type' => 'checkbox', 'class' => 'tagchec', 'label' => array('class' => 'new-chk', 'text' => 'Booking Incharge'), 'after' => '')); ?>
                    </div>
                    <div class="form-group col-sm-12 lft-p-non">
                            <?php echo $this->Form->input('Contact.checkout_appointments', array('div' => false, 'type' => 'checkbox', 'class' => 'tagchec', 'label' => array('class' => 'new-chk', 'text' => 'checkout of future appointments'), 'after' => '')); ?>
                    </div>
                    <div class="form-group ">
                        <strong>Appointment Reminders By</strong>     
                    </div>    
                    <div class="form-group col-sm-12 lft-p-non">
                            <?php echo $this->Form->input('Contact.reminder_email', array('type' => 'checkbox', 'label' => array('class' => 'new-chk', 'text' => 'email'), 'div' => false, 'class' => '', 'after' => '')); ?>
                    </div>
                    <div class="form-group col-sm-12 lft-p-non">
                        <?php echo $this->Form->input('Contact.reminder_sms_text', array('type' => 'checkbox', 'label' => array('class' => 'new-chk', 'text' => 'SMS/Text '), 'div' => false, 'class' => '', 'after' => '')); ?>
                    </div>
                    <div class="form-group">
                        <strong>Special Announcement Email </strong>     
                    </div>  
                    <div class="form-group col-sm-12 lft-p-non">
                        <?php echo $this->Form->input('Contact.special_announcement_email', array('type' => 'checkbox', 'label' => array('class' => 'new-chk', 'text' => 'Allow business that I have used to send special announcement emails'), 'div' => false, 'class' => 'H', 'after' => '')); ?>
                    </div>
                </div>
            </div>
                                <?php
                                echo $this->Form->input('id',array('type'=>'hidden')); 
                                echo $this->Form->input('UserDetail.id',array('type'=>'hidden'));
                                echo $this->Form->input('Contact.id',array('type'=>'hidden'));
                                echo $this->Form->input('Address.id',array('type'=>'hidden')); 
//                                echo $this->Form->input('User.status',array('type'=>'hidden','value'=>1)); 
                                ?>
                        <div class="clearfix"></div>
                        <div class="form-actions col-sm-9 text-right">
                        <?php 
                        echo $this->Form->button('Back',array(
                                        'type'=>'reset','label'=>false,'div'=>false,
                                        'class'=>'btn back_btn')); ?>
                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitUsercontact','label'=>false,'div'=>false));?>
                        </div>
                      <?php   $this->Form->end(); ?>

<script>
             Custom.init();
             var getStateURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getStates','admin'=>false)); ?>";
             $('body').on('change','#AddressCountryId',function() {
                var id = $(this).val();
                var country = $(this).children("option").filter(":selected").text();
                $('.dynamicstate').load(getStateURL+'/'+id,function(){
                    $('#AddressStateId').addClass('form-control');
                    setphoneCode(id);
                });
             });     
         
           var getCityURL = "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getCities','admin'=>false)); ?>";
            $('body').on('change','#AddressStateId',function() {
              var id = $(this).val();
              var country = $(this).children("option").filter(":selected").text();
               $('.dynamiccity').load(getCityURL+'/'+id,function(){
                $('#AddressCityId').addClass('form-control');
                });
            });     
   
        $(document).on('click','.back_btn', function(e){
           e.preventDefault();  
           back_url   = "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'staff_login','admin'=>TRUE));?>"; 
           chnage_wizard_page(back_url,".wizard-steps li.second",".wizard-steps li.third");
        })
   
        $(document).ready(function(){
            var validator = $("#UserAdminContactForm").kendoValidator({
                rules:{
                    minlength: function (input) {
                        return minLegthValidation(input);
                    },
                    maxlength: function (input) {
                        return maxLegthValidation(input);
                    },
                    pattern: function (input) {
                        return patternValidation(input);
                    },
                    equal: function (input) {
                        return equalFieldValidation(input);
                    }
                },
                errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
            
            <?php
            if(!empty($this->data['Address']['country_id'])){  ?>
                     setphoneCode("<?php echo $this->data['Address']['country_id']; ?>");
            <?php }?>
         });
  
        $(document).on('keyup','.numOnly' ,function(){
                var value = $(this).val();
                   if(isNaN(value)){
                       $(this).val('');
                   }
         }); 
         
   function setphoneCode(id){
            $.ajax({
                  url: "<?php echo $this->Html->url(array('controller'=>'Homes','action'=>'getPhoneCode','admin'=>false))?>"+'/'+id,
                  success: function(res) {
                      $(document).find('.cPHcd').val(res);
                  }
            });
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