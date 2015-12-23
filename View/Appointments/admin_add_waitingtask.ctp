<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');
$timestamp= $time;
$startdate=gmdate("m/d/Y", $timestamp);
$starttime=gmdate("h:ia", $timestamp);
?>
<script>
var startdate='<?php echo $startdate; ?>';
var starttime='<?php echo $starttime; ?>';
var st='<?php echo date('h:i A',$open_close_hours[0]); ?>';
var en='<?php echo date('h:i A',$open_close_hours[1]); ?>';
$(function() {
    $('.timepick').timepicker({'minTime': st,
                                'maxTime': en,
                                'showDuration': false,
                                'timeFormat': 'h:iA'
    });
    $('#AppointmentTime').timepicker('setTime', st);
    $('.thedate').datepicker({
            dateFormat: "dd/mm/yy",
            minDate: new Date(),
    });
    $("#startdate1").datepicker('setDate',  (new Date(startdate)));
});
</script>
<div class="modal-dialog modal-lg vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel"><i class="icon-edit"></i>
                    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Waiting Appointment
                </h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
                            <?php echo $this->Form->create('Appointment',array('novalidate','type' => 'file')); ?>
                            <?php echo $this->Form->hidden('Appointment.id',array('div'=>false,'label'=>false));?>
                            <?php echo $this->Form->hidden('Appointment.id',array('div'=>false,'label'=>false));?>
                            <div class="row">
                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!=''){
                                    $startDate = unserialize($edit_appointment['Appointment']['waiting_appointments']);
                                  }?>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label"><b>Provider:*:</b></label>
                                        <?php echo $username; ?>
                                        <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['salon_service_id']!=''){
                                                    $selected=$edit_appointment['Appointment']['salon_service_id'];
                                            }
                                            else{
                                                $selected='';
                                            }    ?>
                                        <?php echo $this->Form->input('Appointment.salon_service_id',array('options'=>$staffServices,'label'=>false,'empty'=>'Please Select', 'class'=>'form-control','required','ValidationMessage'=>'Please select treament.','div'=>false,'selected'=>$selected)); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $this->Form->input('Appointment.salon_staff_id',array( 'class'=>'form-control','type'=>'hidden','label'=>false,'value'=>$employeeId)); ?>
                                    </div>
                                    <div class="form-group clearfix">
                                        <?php echo $this->element('admin/Appointment/appointment_pricingoptions'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label class="control-label">Appointment Comment:</label>
                                        <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['appointment_comment']!=''){
                                            $comments=$edit_appointment['Appointment']['appointment_comment'];
                                        }else{
                                            $comments='';
                                        } ?>
                                        <?php echo $this->Form->input('appointment_comment',array('class'=>'form-control','id'=>'durationExample','div'=>false,'label'=>false,'type'=>'textarea','value'=>$comments));?>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-12 pdng0">Requested Dates:</label>
                                        <div class="form-group pdng0 mrgn-btm10">
                                            <div class="col-xs-6  lft-p-non">
                                                    <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[0]) && $startDate[0]!=''){
                                                        $start_date=date('d/m/Y',$startDate[0]);
                                                    }else{
                                                        $start_date='';
                                                    } ?>
                                                    <?php echo $this->Form->input('startdate',array('class'=>'form-control thedate ','id'=>'startdate1','div'=>false,'label'=>false,'required','value'=>$start_date));?>
                                            </div>
                                            <div class="col-xs-6 rgt-p-non">
                                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[0]) && $startDate[0]!=''){
                                                        $start_time=date('h:mA',$startDate[0]);
                                                    }else{
                                                        $start_time='';
                                                    } ?>
                                                <?php echo $this->Form->input('time',array('class'=>'form-control timepick','div'=>false,'label'=>false,'required','ValidationMessage'=>'Please enter time.','value'=>$start_time));?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group pdng0 mrgn-btm10">
                                            <div class="col-xs-6  lft-p-non">
                                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[1]) && $startDate[1]!=''){
                                                        $start_date=date('d/m/Y',$startDate[1]);
                                                    }else{
                                                        $start_date='';
                                                    } ?>
                                                <?php echo $this->Form->input('startdate1',array('class'=>'form-control thedate','id'=>'startdate2','div'=>false,'label'=>false,'required'=>false,'value'=>$start_date));?>
                                            </div>
                                            <div class="col-xs-6 rgt-p-non">
                                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && $startDate[1]!=''){
                                                            $start_time=date('h:mA',$startDate[1]);
                                                        }else{
                                                            $start_time='';
                                                        } ?>
                                                <?php echo $this->Form->input('time1',array('class'=>'form-control timepick','div'=>false,'label'=>false,'required'=>false,'value'=>$start_time));?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group pdng0 mrgn-btm10">
                                            <div class="col-xs-6  lft-p-non">
                                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[2]) && $startDate[2]!=''){
                                                        $start_date=date('d/m/Y',$startDate[2]);
                                                    }else{
                                                        $start_date='';
                                                    } ?>
                                                <?php echo $this->Form->input('startdate2',array('class'=>'form-control thedate','id'=>'startdate3','div'=>false,'label'=>false,'required'=>false,'value'=>$start_date));?>
                                            </div>
                                            <div class="col-xs-6 rgt-p-non">
                                                    <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[2]) && $startDate[2]!=''){
                                                        $start_time=date('h:mA',$startDate[2]);
                                                    }else{
                                                        $start_time='';
                                                    } ?>
                                                    <?php echo $this->Form->input('time2',array('class'=>'form-control timepick','div'=>false,'label'=>false,'required'=>false,'value'=>$start_time));?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group pdng0 mrgn-btm10">
                                            <div class="col-xs-6  lft-p-non">
                                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[3]) && $startDate[3]!=''){
                                                        $start_date=date('d/m/Y',$startDate[3]);
                                                    }else{
                                                        $start_date='';
                                                    } ?>
                                                <?php echo $this->Form->input('startdate3',array('class'=>'form-control thedate','id'=>'startdate4','div'=>false,'label'=>false,'required'=>false,'value'=>$start_date));?>
                                            </div>
                                            <div class="col-xs-6 rgt-p-non">
                                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[3]) && $startDate[3]!=''){
                                                    
                                            $start_time=date('h:mA',$startDate[3]);
                                        }else{
                                            $start_time='';
                                        } ?>
                                                <?php echo $this->Form->input('time3',array('class'=>'form-control timepick','div'=>false,'label'=>false,'required'=>false,'value'=>$start_time));?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group pdng0 mrgn-btm10">
                                            <div class="col-xs-6 lft-p-non">
                                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[4]) && $startDate[4]!=''){
                                                        $start_date=date('d/m/Y',$startDate[4]);
                                                    }else{
                                                        $start_date='';
                                                } ?>
                                                <?php echo $this->Form->input('startdate4',array('class'=>'form-control thedate','id'=>'startdate5','div'=>false,'label'=>false,'required'=>false,'value'=>$start_date));?>
                                            </div>
                                            <div class="col-xs-6 rgt-p-non">
                                                <?php if(isset($edit_appointment) && $edit_appointment['Appointment']['waiting_appointments']!='' && isset($startDate[4]) && $startDate[4]!=''){
                                                    
                                            $start_time=date('h:mA',$startDate[4]);
                                        }else{
                                            $start_time='';
                                        } ?>
                                                <?php echo $this->Form->input('time4',array('class'=>'form-control timepick','div'=>false,'label'=>false,'required'=>false,'value'=>$start_time));?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                      <?php echo $this->element('admin/Appointment/appointment_customer_detail'); ?>
                                </div></div>
                                <div class="modal-footer pdng20">
                                    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitWaitingTask','label'=>false,'div'=>false));?>
                                    <?php echo $this->Form->button('Cancel',array(
                                                                   'type'=>'button',
                                                                   'label'=>false,
                                                                   'div'=>false,
                                                                   'data-dismiss'=>'modal',
                                                                   'class'=>'btn ')); ?>
                                </div>
                                <?php echo $this->Form->end();?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
   
 
$(document).ready(function(){
      var $modal = $('#commonContainerModal');
      $modal.on('click', '.submitAppointment', function(e){
            var options = { 
                  //beforeSubmit:  showRequest,  // pre-submit callback 
                  success:function(res){
                        // onResponse function in modal_common.js
                        if(onResponse($modal,'User',res)){
                              var data = jQuery.parseJSON(res);
                              if(data.id){
                                    $('body').modalmanager('loading');
                                    var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'manage')); ?>";
                                    userDetailURL = userDetailURL+'/'+data.id
                                    $(document).find(".userdetails").load(userDetailURL, function() {
                                          $('body').modalmanager('loading'); 
                                          onSelectChange(data.id);
                                    });
                              }
                        }
                  }
            }; 
            $('#UserAdminAddUserForm').submit(function(){
                  $(this).ajaxSubmit(options);
                  $(this).unbind('submit');
                  $(this).bind('submit');
                  return false;
            });
      });
      
      $modal.on('blur','#UserEmail',function(){
            var userEmail = $(this).val();
            $.ajax({
                  url: "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'findUserViaEmail','admin'=>true))?>",
                  type: "POST",
                  data: {email:userEmail},
                  success: function(res) {
                        var data = jQuery.parseJSON(res);
                        if(data.data == 'success'){
                              $('body').modalmanager('loading');    
                              var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'addUser')); ?>";
                              addeditURL = addeditURL+'/'+data.id; 
                              $modal.load(addeditURL, '', function(){
                                  $('body').modalmanager('loading');    
                              });    
                        }
                  }
            });
      });
    
      $(document).find("#AppointmentUserId").select2().on("change", function(e) {
            onSelectChange(e.val);
      });
    
      $(document).find("#AppointmentSalonServiceId").on("change", function() {
            service_id=this.value;
            onServiceChange(service_id);
      });
    
      
//      var counter = 1;
//        $("#addButton").click(function () {
//            if(counter>5){
//                alert("Only 5 textboxes allow");
//                return false;
//            }   
// 
//            var newTextBoxDiv = $(document.createElement('div'))
//                .attr("id", 'DateDiv' + counter);
//            newTextBoxDiv.after().html('<label class="control-label">Date*: </label>' +
//	      '<input type="text" id="AppointmentStartdate' + counter + '" name="data[Appointment][startdate' + counter +']",required="required",ValidationMessage="Please select treatment.",class="form-control AppointmentStartdate" value="" >');
//            var newTextBoxDiv1 = $(document.createElement('div'))
//	     .attr("id", 'TimeDiv' + counter);
//            newTextBoxDiv1.after().html('<label class="control-label">Time*: </label>' +
//	      '<input type="text" name="data[Appointment][time' + counter +']"  class="form-control" id="AppointmentTime' + counter + '" value="" >');
//            newTextBoxDiv.appendTo("#TextBoxesGroup");
//            newTextBoxDiv1.appendTo("#TextBoxesGroup");
//            $("#AppointmentStartdate" + counter).datepicker();
//            $("#AppointmentTime" + counter).timepicker();
//            $("#counter").html('<input type="hidden" value="' + counter +' " name="data[Appointment][count]">');
//            counter++;
//        });
 
//        $("#removeButton").click(function () {
//            alert("hi");
//            if(counter==1){
//              alert("No more textbox to remove");
//              return false;
//         }   
// 
//	counter=counter-1;
//        alert(counter);
//        $("#DateDiv" + counter).remove();
//        $("#TimeDiv" + counter).remove();
// 
//     });
 
     //$("#AppointmentStartdate").keypress(function (e){
     //       e.preventDefault();
     // });
     // $("#AppointmentTime").keypress(function (e){
     //       e.preventDefault();
     // });
     // 
});
</script>
        