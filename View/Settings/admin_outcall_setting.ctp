<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-content col-sm-8">
	      <?php echo $this->Form->create('SalonOutcallConfiguration',array('novalidate','class'=>'form-horizontal'));?>
                   <?php
	    //echo $this->Form->create(null, array('url' => array('controller' => 'settings', 'action' => 'admin_appointment_rule'),'id'=>'emailTemplateId','novalidate'));              
	    echo $this->Form->hidden('SalonOutcallConfiguration.id');
            $readOnly  = ($this->data['SalonOutcallConfiguration']['driving_time']=='0')?true:false;
            ?>  
		    
                <div class="form-group">
                           <label class="control-label col-sm-6">One way driving time for outcall services *:</label>
			  
                           <?php $leadOptions = $this->Common->get_duration(); ?>
			   <?php echo $this->Form->input('SalonOutcallConfiguration.driving_time',array('options'=>$leadOptions,'label'=>false,'empty'=>'Please select' , 'div'=>array('class'=>'col-sm-5'),'class'=>'form-control pull-right','required','validationMessage'=>'One way driving time for outcall services is required.')); ?>
		    </div>
		    <div class="form-group">
                        <?php  if(empty($this->request->data['SalonOutcallConfiguration']['additional_cost'])){
                            $selected = '0.00';
                        }else{
                            $selected = $this->request->data['SalonOutcallConfiguration']['additional_cost']; 
                        }
                        ?>
                            <label class='control-label col-sm-6'>Outcall additional cost *:</label>
                            <?php echo $this->Form->input('SalonOutcallConfiguration.additional_cost',array('value'=>$selected,'type'=>'text', 'label'=>false,'div'=>array('class'=>'col-sm-5'),'class'=>'form-control pull-right numOnly', 'maxlength'=>'10','required','validationmessage'=>'Outcall additional cost is required.','readonly'=>$readOnly)); ?>
		    </div>
		    <div class="form-group">
			<label class='col-sm-6'>Outcall additional point redeem*:</label>
			<?php echo $this->Form->input('SalonOutcallConfiguration.additional_point_redeem',array('type'=>'text', 'label'=>false,'div'=>array('class'=>'col-sm-5'),'class'=>'form-control pull-right numOnly', 'maxlength'=>'10','required','validationmessage'=>'Outcall additional point redeem is required.','readonly'=>$readOnly)); ?>
		    </div>
		    <div class="form-group">
                            <label class='col-sm-6'> Outcall is mandatory</label>
			    <div class="col-sm-4 setNewMarginOut">
			    <?php echo $this->Form->input('SalonOutcallConfiguration.mandatory',array(!empty($this->request->data['SalonOutcallConfiguration']['mandatory'])? "checked":'','div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>''))); ?>
			   </div>
                    </div>
                   
                   <!--<div class="sample-form form-horizontal">
                        <div class="form-actions">-->
			<label class=" pdng-tp7 col-sm-6"></label>
                            <div class="col-sm-12 required text-right">
                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary span5 ','label'=>false,'div'=>false));?>
                            <?php //echo $this->Html->link('Cancel',
                                    //        array('controller'=>'dashboard','action'=>'index','admin'=>true),
                                      //      array('escape'=>false,'class'=>'btn span5')); ?>
                        <!--</div>
		   </div>-->
				</div>
		  <?php echo $this->Form->end(); ?>
          </div>
           
    </div>
</div>
    <script type="text/javascript">

var prodValidator = $("#SalonOutcallConfigurationAdminOutcallSettingForm").kendoValidator({
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
    errorTemplate: "<dfn class='red-txt'>#=message#</dfn>"}).data("kendoValidator");
    $(document).ready(function(){
     $(document).on('keyup','.numOnly' ,function(){
             var value = $(this).val();
                if(isNaN(value)){
                    $(this).val('');
                }
        }); 
        
     $('#SalonOutcallConfigurationDrivingTime').on('change' , function(e){
        if($(this).val()==0){
            $('.numOnly').val('0');
            $('.numOnly').attr('readonly','readonly');
//            $('#SalonOutcallConfigurationAdditionalCost').addAttr('readonly');
        }else{
            $('.numOnly').val('');
            $('.numOnly').removeAttr('readonly'); 
        }    
     
     })   
        
        
});
</script>