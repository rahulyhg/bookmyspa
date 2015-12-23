<?php
//echo $from; die;
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');
$timestamp= $time;
$startdate=gmdate("m/d/Y", $timestamp);
$starttime=gmdate("h:i A", $timestamp);
$FromTime=gmdate("h:i A", $from);
$ToTime=gmdate("h:i A", $to);

?>

<script>
    var from='<?php echo $FromTime; ?>';
    var to='<?php echo $ToTime; ?>';
   var startdate='<?php echo $startdate; ?>';
var starttime='<?php echo $starttime; ?>';
$(function() {
    $('.time').timepicker({'timeFormat': 'h:i A'});
    $('.time').timepicker('setTime', from,
        'minTime', '2:00pm',
        'maxTime', '11:30pm',
        'showDuration', false
    );
    $('.endtime').timepicker({'timeFormat': 'h:i A'});
    $('.endtime').timepicker('setTime', to,
        'minTime', '2:00pm',
        'maxTime', '11:30pm',
        'showDuration', false
    );
    $("#AppointmentStartdate").datepicker('setDate',  (new Date(startdate)));
    $("#AppointmentRepeatEndDate").datepicker();
    $("#repeat_weekly_datepicker").datepicker();
    $("#repeat_monthly_datepicker").datepicker();
    $("#repeat_yearly_datepicker").datepicker();
});
</script>
<div class="modal-dialog vendor-setting sm-vendor-setting addUserModal">
      <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  <h3 id="myModalLabel"><i class="icon-edit"></i>
                        Edit Working Hours
                  </h3>
            </div>
            <div class="modal-body">
                  <div class="row">
                        <div class="col-sm-12">
                              <div class="box">
                                    <div class="box-content">
                                          <?php echo $this->Form->create('SalonOpeningHour',array('novalidate','type' => 'file')); ?>
                                          <?php echo $this->Form->hidden('SalonOpeningHour.id',array('div'=>false,'label'=>false));?>
                                          <?php echo $this->Form->hidden('SalonOpeningHour.id',array('div'=>false,'label'=>false));?>
                                          <div class="row">
                                               <div class="col-sm-12">
                                                  <div class="form-group clearfix">
                                                     <div class='col-sm-4'>
                                                        <?php
                                                        $strtotime_optiondate=strtotime($startdate);
                                                        $optiondate=date('D,M-d-Y',$strtotime_optiondate);
                                                        $day=date('l',$strtotime_optiondate);
                                                        $bydate=date('Y-m-d',$strtotime_optiondate);
                                                        $AllDays='All '.date('l',$strtotime_optiondate).'s';
                                                        //$gender='';
                                                          //  if(!empty($user['UserDetail']['gender'])){
                                                            //     $gender=$user['UserDetail']['gender'];
                                                            //}
                                                            $options=array('only'=>$optiondate,'all'=>$AllDays);
                                                            $attributes=array('label'=>array('class'=>'new-chk'),'legend'=>false ,'default'=>'only','separator'=> '</div><div class="col-sm-4">');
                                                            echo $this->Form->radio('SalonOpeningHour.days_type',$options,$attributes);
                                                            ?>
                                                         </div>
                                                               
                                                            
                                                    </div>
                                                    <div class="form-group clearfix">
                                                           <?php echo $this->Form->input('SalonOpeningHour.salon_staff_id',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$employeeId)); ?>
                                                           <?php echo $this->Form->input('SalonOpeningHour.day',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$day)); ?>
                                                           <?php echo $this->Form->input('SalonOpeningHour.date',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$bydate)); ?>
                                                    </div>
                                                    <div class="form-group clearfix">
                                                        <label class="control-label col-sm-3 pdng0">Service Provider-</label>
                                                        <div class="col-sm-6 lft-p-non"><?php echo $username; ?></div>
                                                    </div>
                                                    <div class="form-group clearfix">
                                                        <label class="control-label col-sm-3 pdng0">Date-</label>
                                                            <div class="col-sm-6 lft-p-non"><?php echo $optiondate; ?></div>
                                                    </div>
                                                      <div class="form-group clearfix">
                                                            <label class="control-label col-sm-3 pdng0">Start Time*:</label>
                                                            <div class="col-sm-4 lft-p-non">
                                                            <?php echo $this->Form->input('SalonOpeningHour.from',array('class'=>'form-control time','div'=>false,'label'=>false));?>
                                                            </div>
                                                      </div>
                                                      <div class="form-group clearfix">
                                                            <label class="control-label  col-sm-3 pdng0">End Time*:</label>
                                                            <div class="col-sm-4 lft-p-non">
                                                            <?php echo $this->Form->input('SalonOpeningHour.to',array('class'=>'form-control endtime','div'=>false,'label'=>false));?>
                                                            </div>
                                                      </div>
                                                      
                                                      
                                                </div>
                                               
                                                
                                          
                                                
                                                      </div>
                                                      <div class="modal-footer pdng20">
                                                            
                                                                  <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary  submitWorkingHours','label'=>false,'div'=>false));?>
                                                                  <?php echo $this->Form->button('Cancel',array(
                                                                        'type'=>'button','label'=>false,'div'=>false,
                                                                        'data-dismiss'=>'modal',
                                                                        'class'=>'btn')); ?>
                                                            
                                                     
                                               
                                          <?php echo $this->Form->end();?>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>
<script>
    $("#SalonOpeningHourFrom").keypress(function (e){
            e.preventDefault();
      });
    $("#SalonOpeningHourTo").keypress(function (e){
            e.preventDefault();
      });
</script>