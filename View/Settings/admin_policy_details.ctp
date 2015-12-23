<?php
echo $this->Html->script('admin/userincr'); 
echo $this->Html->script('admin/jquery.timepicker');
echo $this->Html->css('admin/jquery.timepicker'); 
?>
<style>
    .ui-timepicker-list li{
        width:33.3%;
        float:left;
    }
    .ui-timepicker-wrapper{
        width:21.5em;
    }
</style>

<script type="text/javascript">
    $(function() {
        $(".ui-timepicker-wrapper").css("width", "215px");
        $('#PolicyDetailArrivalTime').timepicker();
        $('#PolicyDetailDepartureTime').timepicker();
        $('#PolicyDetailSpaBreakArrivalTime').timepicker();
        $('#PolicyDetailSpaBreakDeptTime').timepicker();
        
        if($(".evoucherCheckBox").is(":checked")==false){
            //$(".evoucherCheckBox").prop('checked', true);
            setTimeout(function(){
                if ($('.evoucherCheckBox').is(":checked")== true) {
                    $(document).find('.evoucherFieldsDiv').show();
                    $(document).find('.evoucherFieldsDiv').removeClass("hidden");
            
                } else {
                    $(document).find('.evoucherFieldsDiv').hide();
                }
            },1000);
        }
        $('.evoucherCheckBox').click(function() {
            if ($(this).is(":checked")== true) {
                $(document).find('.evoucherFieldsDiv').show();
                $(document).find('.evoucherFieldsDiv').removeClass("hidden");
        
            } else {
                $(document).find('.evoucherFieldsDiv').hide();
            }
        });
        
        $('.cancelPeriodRadioPolicy').click(function() {
            if ($(this).val() == '1') {
                $(document).find('.cancelPeriodDivPolicy').show();
                $(document).find('.cancelPeriodDivPolicy').removeClass("hidden");

            } else {
                $(document).find('.cancelPeriodDivPolicy').hide();
            }
        });
        if($( ".cancelPeriodRadioSpa:checked" ).val() == 1){
            setTimeout(function(){
                if ($(".cancelPeriodRadioSpa:checked" ).val()==1) {
                    $(document).find('.cancelPeriodDivSpa').show();
                    $(document).find('.cancelPeriodDivSpa').removeClass("hidden");
                } else {
                    $(document).find('.cancelPeriodDivSpa').hide();
                }
            },1000);
        }
        $('.cancelPeriodRadioSpa').click(function() {
            if ($(this).val() == '1') {
                $(document).find('.cancelPeriodDivSpa').show();
                $(document).find('.cancelPeriodDivSpa').removeClass("hidden");
            } else {
                $(document).find('.cancelPeriodDivSpa').hide();
            }
        });
        if($( ".cancelPeriodRadioSpaBreak:checked" ).val() == 1){
            setTimeout(function(){
                if ($(".cancelPeriodRadioSpaBreak:checked" ).val()==1) {
                    $(document).find('.cancelPeriodDivSpaBreak').show();
                    $(document).find('.cancelPeriodDivSpaBreak').removeClass("hidden");
                } else {
                    $(document).find('.cancelPeriodDivSpaBreak').hide();
                }
            },1000);
        }
        $('.cancelPeriodRadioSpaBreak').click(function() {
            if ($(this).val() == '1') {
                $(document).find('.cancelPeriodDivSpaBreak').show();
                $(document).find('.cancelPeriodDivSpaBreak').removeClass("hidden");
            } else {
                $(document).find('.cancelPeriodDivSpaBreak').hide();
            }
        });
        if($( ".reScheduleRadioSpaBreak:checked" ).val() == 1){
            setTimeout(function(){
                if ($(".reScheduleRadioSpaBreak:checked" ).val()==1) {
                    $(document).find('.reScheduleDivSpaBreak').show();
                    $(document).find('.reScheduleDivSpaBreak').removeClass("hidden");
                } else {
                    $(document).find('.reScheduleDivSpaBreak').hide();
                }
            },1000);
        }
        $('.reScheduleRadioSpaBreak').click(function() {
            if ($(this).val() == '1') {
                $(document).find('.reScheduleDivSpaBreak').show();
                $(document).find('.reScheduleDivSpaBreak').removeClass("hidden");
            } else {
                $(document).find('.reScheduleDivSpaBreak').hide();
            }
        });
        
    });

</script>
<?php echo $this->Form->create('PolicyDetail',array('novalidate','class'=>'form-horizontal'));
echo $this->Form->hidden('id',array('div'=>false,'type'=>'text','label'=>false));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-title"><h3>Appointment polices</h3></div>
            <div class="box-content lft-p-non rgt-p-non">
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="new-chk col-sm-1"> </label>
                        <?php echo $this->Form->input('enable_online_booking',array('div'=>false,'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'<b>Online Booking</b>'))); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="new-chk col-sm-12"><b>Cancellation policy</b></label>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(English)</i></label>
                        <div class="col-sm-10">
                            <span>
                                <?php echo $this->Form->input('eng_cancel_appointment_policy',
                                                array('type'=>'textarea',
                                                      'label'=>false,
                                                      'div'=>false,
                                                      'class'=>'form-control',
                                                      'placeholder'=>'Cancellation policy',
                                                      'cols'=>30,
                                                      'rows'=>3,
                                                      'readonly'=>true)); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(Arabic)</i></label>
                        <div class="col-sm-10">
                            <span>
                                <?php echo $this->Form->input('ara_cancel_appointment_policy',
                                                array('type'=>'textarea',
                                                    'label'=>false,
                                                    'div'=>false,
                                                    'class'=>'form-control',
                                                    'placeholder'=>'Cancellation policy',
                                                    'cols'=>30,
                                                    'rows'=>3,
                                                    'readonly'=>true
                                )); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <hr>
                        <label class="new-chk col-sm-12"><b>Reschedule policy</b></label>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(English)</i></label>
                            <div class="col-sm-10">
                                <span>
                                    <?php echo $this->Form->input('eng_reschedule_appointment_policy',
                                        array('type'=>'textarea',
                                              'label'=>false,
                                              'div'=>false,
                                              'class'=>'form-control',
                                              'placeholder'=>'Cancellation policy',
                                              'cols'=>30,
                                              'rows'=>2,
                                              'readonly'=>true)); ?>
                                </span>
                            </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(Arabic)</i></label>
                        <div class="col-sm-10"><span>
                                <?php echo $this->Form->input('ara_reschedule_appointment_policy',
                                                array('type'=>'textarea',
                                                    'label'=>false,
                                                    'div'=>false,
                                                    'class'=>'form-control',
                                                    'placeholder'=>'Cancellation policy',
                                                    'cols'=>30,
                                                    'rows'=>2,
                                                    'readonly'=>true
                                )); ?>
                        </span></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--div class="col-sm-6 brdr-lft"-->
       
        <div class="box">
            <div class="box-title"><h3>eVoucher polices</h3></div>
            <div class="box-content lft-p-non">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <?php echo $this->Form->input('enable_sieasta_voucher',array('div'=>false,'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Accept the Sieasta gift Vouchers'))); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <?php echo $this->Form->input('enable_gfvocuher',array('div'=>false,'class'=>'evoucherCheckBox','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Accept the Gift Vouchers'))); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="evoucherFieldsDiv <?php if(@$this->request->data['PolicyDetail']['enable_gfvocuher'] == 0) echo 'hidden'; else echo '';?>"">
                        <div class="form-group">
                            <label class="new-chk col-sm-4">eVoucher validity:</label>
                            <div class="col-sm-4">
                                <?php 
                                $selVal='';
                                $userInfo=$this->Session->read('Auth.User');
                               
                                echo $this->Form->input('ev_validity', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_expireafter_options())); ?>
                                <dfn>months</dfn>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label class="new-chk col-sm-12"><b>Cancellation policy</b></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(English)</i></label>
                        <div class="col-sm-10"><span>
                                <?php echo $this->Form->input('eng_evocher_cancel_policy',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'','value'=>ENG_CANCEL_GC_EV,'readonly'=>'readonly','cols'=>30,'rows'=>2)); ?>
                        </span></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(Arabic)</i></label>
                        <div class="col-sm-10"><span>
                                <?php echo $this->Form->input('ara_evocher_cancel_policy',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','placeholder'=>'','value'=>ARA_CANCEL_GC_EV,'readonly'=>'readonly','cols'=>30,'rows'=>2)); ?>
                        </span></div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="box">
            <div class="box-title"><h3>Spa day polices</h3></div>
            <div class="box-content lft-p-non rgt-p-non">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-4">Arrival time</label>
                        <div class="col-sm-8">
                                <?php 
                                if(isset($this->request->data['PolicyDetail']['arrival_time']) && $this->request->data['PolicyDetail']['arrival_time']){
                                    $selVal=$this->request->data['PolicyDetail']['arrival_time'];
                                }else{
                                    $selVal='12:00 AM';
                                }   
                                echo $this->Form->input('arrival_time',array(
                                                'type'=>'text',
                                                'label'=>false,
                                                'div'=>false,                                                    
                                                'class'=>'form-control',
                                                'maxlength'=>5,
                                                'placeholder'=>'0','value'=>$selVal)); 
                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-4">Departure time</label>
                        <div class="col-sm-8">
                                <?php 
                                if(isset($this->request->data['PolicyDetail']['departure_time']) && $this->request->data['PolicyDetail']['departure_time']){
                                    $selVal=$this->request->data['PolicyDetail']['departure_time'];
                                }else{
                                    $selVal='05:00 PM';
                                } 
                                echo $this->Form->input('departure_time',array(
                                                'type'=>'text',
                                                'label'=>false,
                                                'div'=>false,                                                    
                                                'class'=>'form-control',
                                                'maxlength'=>5,
                                                'placeholder'=>'0','value'=>$selVal)); 
                                ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-12">
                        <hr>
                        <label class="new-chk col-sm-12"><b>Cancellation policy</b></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(English)</i></label>
                            <div class="col-sm-10">
                                <span>
                                    <?php echo $this->Form->input('eng_cancel_appointment_policy',
                                                    array('type'=>'textarea',
                                                          'label'=>false,
                                                          'div'=>false,
                                                          'class'=>'form-control',
                                                          'placeholder'=>'Cancellation policy',
                                                          'cols'=>30,
                                                          'rows'=>3,
                                                          'readonly'=>true)); ?>
                                </span>
                            </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(Arabic)</i></label>
                        <div class="col-sm-10"><span>
                                <?php echo $this->Form->input('ara_cancel_appointment_policy',
                                                array('type'=>'textarea',
                                                    'label'=>false,
                                                    'div'=>false,
                                                    'class'=>'form-control',
                                                    'placeholder'=>'Cancellation policy',
                                                    'cols'=>30,
                                                    'rows'=>3,
                                                    'readonly'=>true
                                )); ?>
                        </span></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-12">
                        <hr>
                        <label class="new-chk col-sm-12"><b>Reschedule policy</b></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(English)</i></label>
                            <div class="col-sm-10">
                                <span>
                                    <?php echo $this->Form->input('eng_reschedule_appointment_policy',
                                                    array('type'=>'textarea',
                                                          'label'=>false,
                                                          'div'=>false,
                                                          'class'=>'form-control',
                                                          'placeholder'=>'Cancellation policy',
                                                          'cols'=>30,
                                                          'rows'=>3,
                                                          'readonly'=>true)); ?>
                                </span>
                            </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(Arabic)</i></label>
                        <div class="col-sm-10"><span>
                                <?php echo $this->Form->input('ara_reschedule_appointment_policy',
                                                array('type'=>'textarea',
                                                    'label'=>false,
                                                    'div'=>false,
                                                    'class'=>'form-control',
                                                    'placeholder'=>'Cancellation policy',
                                                    'cols'=>30,
                                                    'rows'=>3,
                                                    'readonly'=>true
                                )); ?>
                        </span></div>
                    </div>
                </div>
                
            </div>
    
        </div>
        <div class="box">
            <div class="box-title"><h3>Spa Break polices</h3></div>
            <div class="box-content">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-4">Arrival time</label>
                        <div class="col-sm-8">
                                <?php 
                                if(isset($this->request->data['PolicyDetail']['spa_break_arrival_time']) && $this->request->data['PolicyDetail']['spa_break_arrival_time']){
                                    $selVal=$this->request->data['PolicyDetail']['spa_break_arrival_time'];
                                }else{
                                    $selVal='02:00 PM';
                                }
                                echo $this->Form->input('spa_break_arrival_time',array(
                                                'type'=>'text',
                                                'label'=>false,
                                                'div'=>false,                                                    
                                                'class'=>'form-control',
                                                'maxlength'=>5,
                                                'placeholder'=>'0','value'=>$selVal)); 
                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-4">Departure time</label>
                        <div class="col-sm-8">
                                <?php 
                                if(isset($this->request->data['PolicyDetail']['spa_break_dept_time']) && $this->request->data['PolicyDetail']['spa_break_dept_time']){
                                    $selVal=$this->request->data['PolicyDetail']['spa_break_dept_time'];
                                }else{
                                    $selVal='2:00 PM';
                                }
                                echo $this->Form->input('spa_break_dept_time',array(
                                                'type'=>'text',
                                                'label'=>false,
                                                'div'=>false,                                                    
                                                'class'=>'form-control',
                                                'maxlength'=>5,
                                                'placeholder'=>'0','value'=>$selVal)); 
                                ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="new-chk col-sm-4">Allow Cancellations?</label>
                        <div class="clearfix col-sm-8">
                            <div class="col-sm-5 col-xs-5 lft-p-non">                                    
                                <?php  $options = array('1' => 'Yes','0' => 'No');
                                    $attributes = array('legend' => false,'class'=>'radio-inline cancelPeriodRadioSpaBreak','label'=>array('class'=>'new-chk'),'separator'=>'</div><div class="col-sm-5"> ');               
                                    echo $this->Form->radio('isAllow_cancel_spa_break', $options, $attributes);  ?>
                            </div>
                        </div>
                    </div>
                    <?php if(@$this->request->data['PolicyDetail']['isAllow_cancel_spa_break'] == 0)
                        $dis = 'hidden';
                    else $dis = '';?>
                    <div class="form-group cancelPeriodDivSpaBreak <?php echo $dis;?>">
                        <label class="new-chk col-sm-4">Cancellation period</label>
                        <div class="col-sm-2"> 
                                <?php 
                                if(isset($this->request->data['PolicyDetail']['cancel_period_spabreak']) && !empty($this->request->data['PolicyDetail']['cancel_period_spabreak'])){
                                  $selValue=$this->request->data['PolicyDetail']['cancel_period_spabreak'];  
                                } else {
                                  $selValue='';  
                                }
                                echo $this->Form->input('cancel_period_spabreak',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,
                                            'class'=>'form-control',
                                            'maxlength'=>3,
                                            'placeholder'=>'','value'=>$selValue)); 
                                ?>
                            days
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <hr>
                            <label class="new-chk col-sm-12"><b>Cancellation policy</b></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(English)</i></label>
                        <div class="col-sm-10"> 
                                <?php echo $this->Form->input('eng_cancellation_policy_text',array('type'=>'textarea','label'=>false,
                                                                                                   'div'=>false,'class'=>'form-control',
                                                                                                   'cols'=>30,'rows'=>3,
                                                                                                   'readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(Arabic)</i></label>
                        <div class="col-sm-10"> 
                                <?php echo $this->Form->input('ara_cancellation_policy_text',array('type'=>'textarea','label'=>false,
                                                                                                   'div'=>false,'class'=>'form-control',
                                                                                                   'cols'=>30,'rows'=>3,
                                                                                                   'readonly'=>true)); ?>
                        </div>
                    </div>
                
                </div>
                <div class="col-sm-6">
                    
                    <div class="form-group">
                        <label class="new-chk col-sm-4">Allow Re-schedule?</label>
                        <div class="clearfix col-sm-8">
                            <div class="col-sm-5 col-xs-5 lft-p-non">                                    
                                <?php
                                //pr($this->request->data);
                                    $options = array('1' => 'Yes','0' => 'No');
                                    $attributes = array('legend' => false,'class'=>'radio-inline reScheduleRadioSpaBreak','label'=>array('class'=>'new-chk'),'separator'=>'</div><div class="col-sm-5"> ');               
                                    echo $this->Form->radio('isAllow_reschedule_spabreak', $options, $attributes);               
                                ?>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group reScheduleDivSpaBreak  <?php if(@$this->request->data['PolicyDetail']['isAllow_reschedule_spabreak'] == 0) echo 'hidden'; else echo '';?>">
                        <label class="new-chk col-sm-4">Reschedule period</label>
                        <div class="col-sm-2"> 
                                <?php 
                                if(isset($this->request->data['PolicyDetail']['reschedule_period']) && !empty($this->request->data['PolicyDetail']['reschedule_period'])){
                                  $selValue=$this->request->data['PolicyDetail']['reschedule_period'];  
                                }else{
                                  $selValue='1';  
                                }
                                echo $this->Form->input('reschedule_period',array(
                                            'type'=>'text',
                                            'label'=>false,
                                            'div'=>false,
                                            'class'=>'form-control',
                                            'maxlength'=>3,
                                            'placeholder'=>'','value'=>$selValue));  ?> days
                        </div>
                    </div>
                
                    <div class="form-group">
                        <div class="col-sm-12">
                            <hr>
                            <label class="new-chk col-sm-12"><b>Reschedule policy</b></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(English)</i></label>
                        <div class="col-sm-10"> 
                                <?php echo $this->Form->input('eng_reschedule_policy_text',array('type'=>'textarea',
                                                                                        'label'=>false,'div'=>false,
                                                                                        'class'=>'form-control',
                                                                                        'cols'=>30,'rows'=>2, 'readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="new-chk col-sm-2"><i>(Arabic)</i></label>
                        <div class="col-sm-10"> 
                                <?php echo $this->Form->input('ara_reschedule_policy_text',array('type'=>'textarea','label'=>false,
                                                                                                 'div'=>false,'class'=>'form-control',
                                                                                                 'cols'=>30,'rows'=>2,
                                                                                                 'readonly'=>true)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="new-chk col-sm-4">&nbsp;</label>
                <div class="col-sm-8 form-actions">
                    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update span3','label'=>false,'div'=>false));?>                           
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>