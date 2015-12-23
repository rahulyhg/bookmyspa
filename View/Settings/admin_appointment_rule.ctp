<div class="row-fluid">
    <div class="col-sm-12">
        <div class="box">
           <div class="box-content">
                <div class="row-fluid">
                    <div class="col-sm-10">    
                       <!--<form action="/admin/settings/appointment_rule" method="post" class="form-horizontal">-->
		       <?php echo $this->Form->create('SalonOnlineBookingRule',array('type'=>'file','novalidate','class'=>'form-horizontal form-stripped'));?>
	     <?php
	    //echo $this->Form->create(null, array('url' => array('controller' => 'settings', 'action' => 'admin_appointment_rule'),'id'=>'emailTemplateId','novalidate'));              
	    echo $this->Form->hidden('SalonOnlineBookingRule.id',array('value'=>$this->request->data['SalonOnlineBookingRule']['id'])); ?>  
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-5">	    
                                        <?php    echo $this->Form->input('SalonOnlineBookingRule.allow_cancel',array('type'=>'checkbox', 'label'=>array('class'=>'new-chk','text'=>'Allow Customers to cancel their appointments'),'tabindex'=>'0','div'=>false,'class'=>'', !empty($this->request->data['SalonOnlineBookingRule']['allow_cancel'])?"checked": '')); ?>
                                    </label>
                                    <div class="col-sm-2">
                                       <?php     echo $this->Form->input('SalonOnlineBookingRule.cancel_time',array('type'=>'text','label'=>false,'class'=>'form-control numOnly','maxlength'=>'3','default'=>24)); ?>
                                    </div>
                                    <div class="col-sm-5">
                                        Hours prior to appointment
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5">	    
                                        <?php    echo $this->Form->input('SalonOnlineBookingRule.allow_reschedule',array('type'=>'checkbox', 'label'=>array('class'=>'new-chk','text'=>'Allow Customers to reschedule their appointments'),'div'=>false,'class'=>'', !empty($this->request->data['SalonOnlineBookingRule']['allow_reschedule'])? "checked":'')); ?>
                                    </label>
                                    <div class="col-sm-2">
                                        <?php    echo $this->Form->input('SalonOnlineBookingRule.reschedule_time',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control numOnly','maxlength'=>'3','default'=>4)); ?>
                                    </div>
                                    <div class="col-sm-5">
                                        Hours prior to appointment		
                                    </div>
                                </div>
                                <div class="form-group">                                    
                                    <div class="col-sm-7"> 
                                    <?php   $text = "Option is useful when you have one calendar shared by service provider due to limitations of room or equipment.Once checked customers booking online will be asked for service provider’s gender preference.Useful for services like Hair Removal, Spray Tanning and Massage.";?>
				    <?php   echo $this->Form->input('SalonOnlineBookingRule.gender_required',array('type'=>'checkbox', 'label'=>array('class'=>'new-chk','text'=>'Require gender information during the online appointment  '),'div'=>false,'class'=>'', !empty($this->request->data['SalonOnlineBookingRule']['gender_required'])? "checked":'')); ?>
				    </div>
				    <div class="col-sm-1"> 
				    <?php  echo $this->Html->link('<i class="glyphicon-circle_info"></i>' , 'javascript:void(0)', array('rel'=>'popover','data-trigger'=>'hover','data-content'=>$text,'escape'=>false)); ?>
				    </div>
				</div>
                                <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                       Online appointments lead time for Services
                                    </label>
                                    <div class="col-sm-2">
                                     <?php echo $this->Form->input('SalonOnlineBookingRule.lead_time', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control numOnly', 'options' => $this->common->get_leadtime_options())); ?>
				    <?php //echo $this->Form->input('SalonOnlineBookingRule.lead_time',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control numOnly','maxlength'=>'3')); ?>
                                    </div>
                                    <div class="col-sm-2">
					<?php   // echo $this->Html->image('admin/help.gif',array('class'=>'utopia-widget-icon', 'title'=>'Online appointments lead time'));?>
                                        
                                        <?php   $text = "Limits how soon your customer can make an appointment with you online,giving you time to react to the request properly.";
                                                echo $this->Html->link('<i class="glyphicon-circle_info"></i>' , 'javascript:void(0)', array('rel'=>'popover','data-trigger'=>'hover','data-content'=>$text,'escape'=>false)); ?>                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                        Appointment search limit
                                    </label>
                                    <div class="col-sm-2">
                                        <?php   echo $this->Form->input('SalonOnlineBookingRule.search_limit',array('type'=>'text','min'=>'1','max'=>'60','step'=>'1','label'=>false,'class'=>'form-control numOnly','validationMessage'=>'Enter Value Between 1 and 60','default'=>15)); ?>
                                        <?php   // echo $this->Html->image('admin/help.gif',array('class'=>'utopia-widget-icon', 'title'=>'Number of Appointment search limit'));?>             
                                    </div>
                                    <div class="col-sm-1">
				     <?php   $text = "Specify the number of available appointments your customers will see when they are booking an appointment online with your business.";
                                                echo $this->Html->link('<i class="glyphicon-circle_info"></i>' , 'javascript:void(0)', array('rel'=>'popover','data-trigger'=>'hover','data-content'=>$text,'escape'=>false)); ?>                                                                                                
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                        Search appointments interval
                                    </label>
                                    <div class="new-chk col-sm-2">
					<?php $interval = $this->Common->search_interval();?>
                                        <?php echo $this->Form->input('SalonOnlineBookingRule.search_interval',array('options'=>$interval, 'label'=>false,'div'=>false,'class'=>'form-control','default'=>30)); ?>
                                    </div>
                                    <div class="new-chk col-sm-1">
					       <?php   //echo $this->Html->image('admin/help.gif',array('class'=>'utopia-widget-icon', 'title'=>'Search appointments interval'));?>
                                        <?php   $text = "Use this variable to set at the intervals between the available online appoinement options that will be presented to your customers.";
                                                echo $this->Html->link('<i class="glyphicon-circle_info"></i>' , 'javascript:void(0)', array('rel'=>'popover','data-trigger'=>'hover','data-content'=>$text,'escape'=>false)); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                        Online booking limit
                                    </label>
                                    <div class="col-sm-2">
                                       	    <?php echo $this->Form->input('SalonOnlineBookingRule.booking_limit',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control numOnly','maxlength'=>'3','default'=>90)); ?>
                                    </div>
                                    <div class="new-chk col-sm-3">
                                        days in advance
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                        Booking lead time for Pacakge
                                    </label>
                                    <div class="col-sm-2">
					<?php $leadOptions = $this->Common->get_duration(); ?>
					<?php $daysOptions = $this->Common->get_leadtime_options(); ?>
                                     <?php  echo $this->Form->input('SalonOnlineBookingRule.package_leadtime',array('options'=>$daysOptions, 'label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                    </div>
				    <div class="new-chk col-sm-3">
                                        days
                                    </div>
                                </div>
				 <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                        Booking lead time for Spa days
                                    </label>
                                    <div class="new-chk col-sm-2">
					<?php $leadOptions = $this->Common->get_duration(); ?>
					<?php $daysOptions = $this->Common->get_days(); ?>
                                     <?php  echo $this->Form->input('SalonOnlineBookingRule.spa_day_leadtime',array('options'=>$daysOptions, 'label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                    </div>
				    <div class="new-chk col-sm-3">
                                        days
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                        Booking lead time for overnight stays
                                    </label>
                                    <div class="col-sm-2">
                            	    <?php echo $this->Form->input('SalonOnlineBookingRule.overnight_leadtime',array('options'=>$daysOptions, 'label'=>false,'div'=>false,'class'=>'form-control','selected'=>0)); ?>
                                    </div>
				    <div class="col-sm-3">
                                        days
                                    </div>
                                </div>
                                <div class="selectTheme utopia-feature">
                                   <!-- <b>Off-peak discounting settings</b>-->
                                </div> 
                                <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                        Afternoon starts at
                                    </label>
                                    <div class="col-sm-2">
                                        <?php 
//                                    pr($openHours);                                        
//echo $this->Form->input('SalonOnlineBookingRule.afternoon_starts_at',array( 'label'=>false,'div'=>false,'class'=>'input-sm')); ?>
				    <?php echo $this->Form->input('SalonOnlineBookingRule.afternoon_starts_at',array('options'=>$afternoons,'label'=>false,'div'=>false,'class'=>'form-control', 'default'=>'14:00')); ?>
				    </div>
                                    <div class="col-sm-3"></div>
                                </div>
                                <div class="form-group">
                                    <label class="new-chk col-sm-5">	    
                                        Evening starts at
                                    </label>
                                    <div class="col-sm-2">
                                    <?php //echo $this->Form->input('SalonOnlineBookingRule.evening_starts_at',array('label'=>false,'div'=>false,'class'=>'input-sm')); ?>
				    <?php echo $this->Form->input('SalonOnlineBookingRule.evening_starts_at',array('options'=>$evngs,'label'=>false,'div'=>false,'class'=>'form-control','default'=>'17:00')); ?>
                                    </div>
                                    <div class="col-sm-3"></div>
                                </div>                                
                                <div class="form-group">
                                    <div class="col-sm-7 pull-right">
		    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary col-sm-4','label'=>false,'div'=>false));?>
                                    </div>
                                </div>
                            </div>
	   <?php echo $this->Form->end(); ?> 
                    </div>     
                </div>
            </div>
        </div>
    </div>
</div>

<noscript type="text/javascript">
//Function to allow only numbers to textbox
    $('input').keypress(function(e) {
        //getting key code of pressed key
        var keycode = (e.which) ? e.which : e.keyCode;

        //comparing pressed keycodes
        if (!(keycode == 8 || keycode == 46) && (keycode < 48 || keycode > 57)) {
            return false;
        } else {
            return true;
        }
    });
</noscript>
<script>
    $(document).ready(function(){
	   $(document).on('keyup','.numOnly' ,function(){
                var value = $(this).val();
                if(isNaN(value)){
                    $(this).val('');
                }
            });  
        
	//$("#SalonOnlineBookingRuleSearchLimit").kendoNumericTextBox();
	var regValidator = $("#SalonOnlineBookingRuleAdminAppointmentRuleForm").kendoValidator({
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
	
	
    });
    
</script>