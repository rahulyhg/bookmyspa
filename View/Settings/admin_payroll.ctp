<?php
    echo $this->Html->script('admin/userincr'); 
?>
<style>
   .setNewMarginPayroll{
        margin-left:15px;
    }
</style>
<div class="row">    
    <div class="col-sm-12">
        <div class="box">

            <div class="box-content">
                <div class="col-sm-12">
                   <?php echo $this->Form->create('Payroll',array('novalidate','class'=>'form-horizontal'));?>
                    <div class="col-sm-6 lft-p-non">
                        <div class="form-group">
                            <label class="control-label col-sm-5 pdng-tp7">Payroll Frequency</label>
                            <div class="col-sm-7">
                                 <?php echo $this->Form->input('payroll_frequency',array(
                                                        'options'=>array(
                                                                        '1'=>'Weekly',
                                                                        '2'=>'Monthly',
                                                                        '3'=>'Bi weekly',                                                                    
                                                                        ),
                                                        'label'=>false,
                                                        'div'=>false,
                                                        'class'=>'form-control payroll_frequency',
                                                        'maxlength'=>10,
                                                        'placeholder'=>'0')); 
                                            ?>
                            </div>
                        </div>
                        <div class="form-group payroll_close_day">
                            <label class="control-label col-sm-5 pdng-tp7">Payroll Closing Day</label>
                            <div class="col-sm-7">
                                   <?php echo $this->Form->input('payroll_close_day',array(
                                                        'options'=>array(
                                                                        '1'=>'Monday',
                                                                        '2'=>'Tuesday',
                                                                        '3'=>'Wednesday',                                                                    
                                                                        '4'=>'Thursday',                                                                    
                                                                        '5'=>'Friday',                                                                    
                                                                        '6'=>'Saturday',                                                                    
                                                                        '0'=>'Sunday',                                                                    
                                                                        ),
                                                        'label'=>false,
                                                        'div'=>false,
                                                        'class'=>'form-control',
                                                        'maxlength'=>10,
                                                        'placeholder'=>'0')); 
                                            ?> 
                            </div>
                        </div>

                        <div class="form-group payroll_end_day">
                            <label class="control-label col-sm-5 pdng-tp7">Payroll Ending Day</label>
                            <div class="col-sm-7">
                                    <?php echo $this->Form->input('payroll_end_day',array(
                                                        'type'=>'text',
                                                        'id'=>'datepicker',
                                                        'label'=>false,
                                                        'div'=>false,
                                                        'class'=>'datepicker form-control',
                                                        'maxlength'=>10,
                                                        'placeholder'=>'Payroll Ending Day')); 
                                            ?>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5">Commission Rolling Average</label>
                            <div class="col-sm-2 rgt-p-non">
                                  <?php echo $this->Form->input('commision_rolling_avg',array(
                                                        'options'=>array(
                                                                        '1'=>'Avg',
                                                                        '2'=>'2',
                                                                        '3'=>'3',
                                                                        '4'=>'4',
                                                                        '5'=>'5',
                                                                        '6'=>'6',
                                                                        '7'=>'7',
                                                                        '8'=>'8',
                                                                        '9'=>'9',
                                                                        '10'=>'10',
                                                                        '11'=>'11',
                                                                        '12'=>'12',
                                                                        ),
                                                        'label'=>false,
                                                        'div'=>false,
                                                        'class'=>'form-control',
                                                        'after'=>'</div><div class="col-sm-5 rgt-p-non pdng-tp7">(Default: No Rolling Average) &nbsp;&nbsp;&nbsp;',
                                                        'maxlength'=>10,
                                                        'placeholder'=>'0')); 
                                            ?>  
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-6 rgt-p-non">  
                        
                        <div class="form-group">
                            <label class="control-label col-sm-5 pdng-tp7">OverTime starts after</label>
                            <div class="col-sm-7 rgt-p-non">
                                      <?php echo $this->Form->input('overtime_start',array(
                                                                'type'=>'text',
                                                                'label'=>false,
                                                                'div'=>false,
                                                                'after'=>'<div class="pdng-tp7 pull-left"> Hrs</div>',
                                                                'class'=>'form-control w-auto pull-left mrgn-rgt10',
                                                                'maxlength'=>3,
                                                                'placeholder'=>'0')); 
                                       ?>                                                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5 pdng-tp7">Overtime Hourly Multiplier</label>
                            <div class="col-sm-7">
                                    <?php echo $this->Form->input('overtime_cost_hourly',array(
                                                            'type'=>'text',
                                                            'label'=>false,
                                                            'div'=>false,
                                                            'class'=>'form-control',
                                                            'maxlength'=>3,
                                                            'placeholder'=>'0')); 
                                      ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5">&nbsp;</label>
                            <div class="col-sm-7">
                            <?php echo $this->Form->input('include_tips',array(!empty($this->request->data['Payroll']['include_tips'])? "checked":'','div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Include Tips'))); ?>                                              			                                    
                            <?php //echo $this->Form->input('include_tips',array('type'=>'checkbox','label'=>false,'div'=>false,'class'=>'','maxlength'=>25)); ?>                                                                                                             
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5">&nbsp;</label>
                            <div class="col-sm-7">
			    <?php echo $this->Form->input('deduct_service_cost',array(!empty($this->request->data['Payroll']['deduct_service_cost'])? "checked":'','div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Deduct Business Service Cost'))); ?>                                              			                                    
                            <?php //echo $this->Form->input('deduct_service_cost',array('type'=>'checkbox','label'=>false,'div'=>false,'class'=>'','maxlength'=>25)); ?>                                                                                                             
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5">&nbsp;</label>
                            <div class="col-sm-7">
                            <?php echo $this->Form->input('deduct_discount_commision',array(!empty($this->request->data['Payroll']['deduct_discount_commision'])? "checked":'','div'=>false,'class'=>'validate[required]','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>"Don't Subtract Discount From Commision"))); ?>                                              			                                    
                            <?php //echo $this->Form->input('deduct_discount_commision',array('type'=>'checkbox','label'=>false,'div'=>false,'class'=>'','maxlength'=>25)); ?>                                                                                                             
                            </div>                            
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-sm-5">&nbsp;</label>
                            <div class="col-sm-7">                                               
                        
                                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update col-sm-3','label'=>false,'div'=>false));?>                           
                            </div>
                        </div>
                    </div>

            <?php echo $this->Form->end(); ?>
                </div>   
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).find('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        weekStart: '0'
    });
    $(document).find('.payroll_frequency').change(function() {
        if ($(this).val() == '1') {
            $(document).find('.payroll_close_day').show();
        } else {
            $(document).find('.payroll_close_day').hide();
        }
    });

    $(document).find('.payroll_frequency').change(function() {
        if ($(this).val() == '3') {
            $(document).find('.payroll_end_day').show();
            $(document).find('.payroll_close_day').show();

        } else {
            $(document).find('.payroll_end_day').hide();
        }
    });
</script>
