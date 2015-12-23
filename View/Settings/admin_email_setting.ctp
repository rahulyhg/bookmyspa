<div class="row-fluid">
    <form action="/admin/settings/email_setting" method="post" class="form-horizontal" id="EmailSettingsForm">
        <div class="col-sm-6 nopadding">
            <div class="box">
                <div class="box-content">
                <div style="padding-right:15px; border-right:1px solid #ccc">
                    <h3>Client Settings</h3>
                    <div class="form-group clearfix">
                        <label class="control-label col-sm-5"> </label>
                        <div class="col-sm-12">
                            <?php echo $this->Form->input('SalonEmailSms.is_reminder',
                                array(!empty($this->request->data['SalonEmailSms']['is_reminder'])? "checked":'',
                                    'div'=>false,'class'=>'validate[required]','type'=>'checkbox',
                                    'label'=>array('class'=>'new-chk black-txt','text'=>'Appointment reminder',
                                    'onclick'=>'myfunc();'))); ?>
                        </div>
                    </div>
                    <div id="reminders">
                        <div class="form-group col-sm-12">
                            <label class="control-label col-sm-5 pdng-tp7 lft-p-non">	    
                                Send Email reminder*:
                            </label>
                            <div class="col-sm-2 lft-p-non">
                                <?php if($this->request->data['SalonEmailSms']['id'] == ''){
                                    $selected = '24';
                                }else{
                                    $selected = $this->request->data['SalonEmailSms']['client_email_reminder_hrs'];
                                }
                                echo $this->Form->input('SalonEmailSms.client_email_reminder_hrs',
                                    array('value'=>$selected,'type'=>'text',
                                          'label'=>false,'div'=>false,
                                          'class'=>'form-control number',
                                          'minlength'=>'1','maxlength'=>'2','required',
                                          'validationMessage'=>"Send email reminder hours required.",
                                          'data-minlength-msg'=>"Minimum 1 characters.",
                                          'data-maxlength-msg'=>"Maximum 2 characters."
                                    )); ?>
                            </div>
                            <dfn class="col-sm-5 lft-p-non pdng-tp7 non-italic  black-txt" style="padding-right:0px">hour(s) before appointment</dfn>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-12">	    
                           Include message in appointment email
                        </label>
                        <div class="col-sm-12">
                                <?php echo $this->Form->input('SalonEmailSms.client_email_content',array('rows'=>'2', 'cols'=>'20' ,'label'=>false,'div'=>false,'class'=>'form-control')); ?>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <div class="col-sm-12 ">
                            <?php /*if($this->request->data['SalonEmailSms']['id'] == ''){
                                echo $this->Form->input('SalonEmailSms.client_email_confirm',array(!empty($this->request->data['SalonEmailSms']['client_email_confirm'])? "checked":'','div'=>false,'checked'=>true,'type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send email confirmations to clients about confirmed, reschuduled or cancelled appointment.')));
                            }else if($this->request->data['SalonEmailSms']['client_email_confirm'] == '1') {
                               echo $this->Form->input('SalonEmailSms.client_email_confirm',array(!empty($this->request->data['SalonEmailSms']['client_email_confirm'])? "checked":'','div'=>false,'checked'=>true,'type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send email confirmations to clients about confirmed, reschuduled or cancelled appointment.')));
                            }else{
                               echo $this->Form->input('SalonEmailSms.client_email_confirm',array(!empty($this->request->data['SalonEmailSms']['client_email_confirm'])? "checked":'','div'=>false,'type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send email confirmations to clients about confirmed, reschuduled or cancelled appointment.')));
                            } 
                               
                            */?>
                         </div>
                    </div-->
                    <h6><strong>SMS Settings</strong></h6>  
                    <div class="clearfix">
                        <label class="control-label col-sm-4 pdng-tp7 lft-p-non">	    
                            Send Sms reminder*:
                        </label>
                        <div class="col-sm-2 lft-p-non">
                        <?php
                            if($this->request->data['SalonEmailSms']['id'] == ''){
                                $selected2 = '24';
                            }else{
                                $selected2 = $this->request->data['SalonEmailSms']['client_sms_reminder_hrs'];
                            }
                            echo $this->Form->input('SalonEmailSms.client_sms_reminder_hrs',array('value'=>$selected2,'type'=>'text', 'label'=>false,'div'=>false,'class'=>'form-control number', 'minlength'=>'1','maxlength'=>'2','required','validationMessage'=>"Send sms reminder hours required.",'data-minlength-msg'=>"Minimum 1 characters.",'data-maxlength-msg'=>"Maximum 2 characters.")); ?>
                        </div>
                        <dfn class="col-sm-6 lft-p-non pdng-tp7 non-italic black-txt">hour(s) before appointment</dfn>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12 ">
                         <?php if($this->request->data['SalonEmailSms']['id'] == ''){
                                echo $this->Form->input('SalonEmailSms.client_email_promotion',array(!empty($this->request->data['SalonEmailSms']['client_email_promotion'])? "checked":'','div'=>false,'class'=>'','type'=>'checkbox','checked'=>true,'label'=>array('class'=>'new-chk black-txt','text'=>'Send emails encouraging website reviews')));
                            }else if($this->request->data['SalonEmailSms']['client_email_promotion'] == '1') {
                                echo $this->Form->input('SalonEmailSms.client_email_promotion',array(!empty($this->request->data['SalonEmailSms']['client_email_promotion'])? "checked":'','div'=>false,'class'=>'','type'=>'checkbox','checked'=>true,'label'=>array('class'=>'new-chk black-txt','text'=>'Send emails encouraging website reviews')));
                            }else{
                                echo $this->Form->input('SalonEmailSms.client_email_promotion',array(!empty($this->request->data['SalonEmailSms']['client_email_promotion'])? "checked":'','div'=>false,'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send emails encouraging website reviews')));
                            } ?>
                        </div>
                    </div>
                    </div>
                </div>                    
            </div>
        </div>   
        <div class="col-sm-6 nopadding">
            <div class="box">
                <div class="box-content">
                    <h3>Business Settings</h3>
                    <!--div class="form-group">
                        <label class="control-label col-sm-5 pdng-tp7">	    
                            Email*:
                        </label>
                        <div class="col-sm-7  rgt-p-non">
                             <?php //echo $this->Form->input('SalonEmailSms.business_email',array('label'=>false,'class'=>'form-control','id'=>'email','type'=>'email', 'minlength'=>'1','maxlength'=>'52','required','validationMessage'=>"Email is required.",'data-minlength-msg'=>"Minimum 1 characters.",'data-maxlength-msg'=>"Maximum 55 characters." ,'data-email-msg'=>'Please enter valid Email address.')); ?>
                        </div>
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-5 pdng-tp7">	    
                            Email format
                        </label>
                        <div class="col-sm-7 rgt-p-non">
                            <?php echo $this->Form->select('SalonEmailSms.email_format',array('HTML', 'TEXT'), array('label'=>false,'div'=>false,'class'=>'form-control', 'minlength'=>'1','maxlength'=>'18','required','validationMessage'=>"Email format is required.",'data-minlength-msg'=>"Minimum 1 characters.",'data-maxlength-msg'=>"Maximum 18 characters." ,!empty($this->request->data['SalonOnlineBookingRule']['email_format'])?"selected": '')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">	    
                        </label>
                        <div class="col-sm-8 setNewMarginEmail">
                            
                                    <?php echo $this->Form->input('SalonEmailSms.business_nofity_provider',array(!empty($this->request->data['SalonEmailSms']['business_nofity_provider'])? "checked":'','div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send email to service provider'))); ?>                                              
                        </div>
                    </div>
                
                    <!--h6><strong>SMS Settings</strong> (Appointment book or change notification)</h6-->
                    
                    <!--div class="form-group pdng-tp7">
                        <label class="control-label col-sm-5">	    
                        </label>
                        <div class="col-sm-12 setNewMarginEmail">
                            <?php /*if($this->request->data['SalonEmailSms']['id'] == '') {
                                echo $this->Form->input('SalonEmailSms.business_sms_new_booking',array(!empty($this->request->data['SalonEmailSms']['business_sms_new_booking'])? "checked":'','div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send text(SMS) new order confirmation for booking')));                                              
                            }else if($this->request->data['SalonEmailSms']['business_sms_new_booking'] == '1') {
                                echo $this->Form->input('SalonEmailSms.business_sms_new_booking',array(!empty($this->request->data['SalonEmailSms']['business_sms_new_booking'])? "checked":'','div'=>false,'class'=>'validate[required]','type'=>'checkbox','checked'=>true,'label'=>array('class'=>'new-chk black-txt','text'=>'Send text(SMS) new order confirmation for booking')));
                            }else{
                             echo $this->Form->input('SalonEmailSms.business_sms_new_booking',array(!empty($this->request->data['SalonEmailSms']['business_sms_new_booking'])? "checked":'','div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send text(SMS) new order confirmation for booking')));
                            } */?>
                                
                        </div>
                    </div-->
                    <!--div class="form-group">
                        <label class="control-label col-sm-5">Phone number to send appointment confirmation*:</label>
                        <div class=" col-sm-7 nopadding">
                                    <div style="padding-left:15px !important;" class="col-sm-3 col-xs-3 nopadding ">
                                         <?php //echo $this->Form->hidden('Contact.id',array());?>
                                                <?php //echo $this->Form->input('SalonEmailSms.country_code',array('type'=>'text','value'=>$country_code,'class'=>'form-control', 'div'=>false,'label'=>false));?>
                                    </div>
                                    <div class="col-sm-9 col-xs-9 rgt-p-non">
                                        <?php //echo $this->Form->input('SalonEmailSms.business_phone',array('label'=>false,'class'=>'form-control number', 'minlength'=>'9','maxlength'=>'12','required','validationMessage'=>"Phone is required.",'data-minlength-msg'=>"Please fill Valid Phone Number.",'data-maxlength-msg'=>"Maximum 12 characters.")); ?>
                                    </div>
                            </div>
                        
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-5">	    
                        </label>
                        <div class="col-sm-8 setNewMarginEmail">
                            <?php
                            if($this->request->data['SalonEmailSms']['id']== ''){
                                echo $this->Form->input('SalonEmailSms.business_sms_notify_provider',array('checked'=>true,'div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send SMS to service provider')));                                          
                            }else if($this->request->data['SalonEmailSms']['business_sms_notify_provider'] == '1'){
                                echo $this->Form->input('SalonEmailSms.business_sms_notify_provider',array('checked'=>true,'div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send SMS to service provider')));                                          
                            }else{
                                echo $this->Form->input('SalonEmailSms.business_sms_notify_provider',array('div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk black-txt','text'=>'Send SMS to service provider')));                                          

                            }?>
                        </div>
                    </div>                                        
                </div>
            </div>
        </div>
        <div class="col-sm-12 text-right">
            <div class="utopia-from-action">
                <?php
                echo $this->Form->hidden('SalonEmailSms.id',array('value'=>isset($this->request->data['SalonEmailSms']['id'])?$this->request->data['SalonEmailSms']['id']:'1'));
                echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary','label'=>false,'div'=>false));?>
            </div>
        </div>
    <?php echo $this->Form->end(); ?> 
</div>
<script type="text/javascript">
    
    $('.number').keyup(function(){
        var value = $(this).val();
        if(isNaN(value)){
            $(this).val('');
        }
    })
    
    var prodValidator = $("#EmailSettingsForm").kendoValidator({
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

    
        
        $('SalonEmailSmsIsReminder').click( function(){
            
        });
    
    $(document).ready(function() {
        var is_reminders = jQuery('#SalonEmailSmsIsReminder').prop('checked');
        disable_reminderinputs(is_reminders);
    });
    
    
        function myfunc(){
            var is_reminders = jQuery('#SalonEmailSmsIsReminder').prop('checked');
            if(is_reminders == true){
                $('#SalonEmailSmsClientEmailReminderHrs').attr('disabled',true);
                $('#SalonEmailSmsClientSmsReminderHrs').attr('disabled',true);
                $('#SalonEmailSmsClientEmailContent').attr('disabled',true);
            } else {
                $('#SalonEmailSmsClientEmailReminderHrs').attr('disabled',false);
                $('#SalonEmailSmsClientSmsReminderHrs').attr('disabled',false);
                $('#SalonEmailSmsClientEmailContent').attr('disabled',false);
            }
        }
        
        function disable_reminderinputs(isReminders){
            if(isReminders == false){
                $('#SalonEmailSmsClientEmailReminderHrs').attr('disabled',true);
                $('#SalonEmailSmsClientSmsReminderHrs').attr('disabled',true);
                $('#SalonEmailSmsClientEmailContent').attr('disabled',true);
            }
        }
        
</script>