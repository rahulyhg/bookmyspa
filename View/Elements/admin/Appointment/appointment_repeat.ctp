<?php
 //echo $startdate; die;
    if(isset($edit_personal_appointment) && $edit_personal_appointment['Appointment']['appointment_repeat_type']!=''){
            $selected=$edit_personal_appointment['Appointment']['appointment_repeat_type'];
    }
    else{
        $selected='';
    }
    $arrRepeatoff=array(0=>"Repeat Off",1=>"Repeat Daily",2=>"Repeat Weekly",3=>"Repeat Monthly",4=>"Repeat Yearly");
    ?>
    <div class="col-sm-12 nopadding mrgn-btm10">
    <?php echo $this->Form->input('Appointment.appointment_repeat_type', 
array('options'=>$arrRepeatoff, 'label'=>false,'class'=>'form-control','div'=>false,'selected'=>$selected));?>
    </div>
    
    <div class="col-sm-12 nopadding">
        <div id="repeat-daily" style="display: none;" class="form-group col-sm-4 lft-p-non">
                <label class="control-label">End Date*:</label>
                <?php echo $this->Form->input('appointment_repeat_end_date',array('type'=>'text','class'=>'form-control theDatePick','required'=>false,'div'=>false,'label'=>false,'ValidationMessage'=>'Appointment repeat end date is required.'));?>
        </div>
        <div id="repeat-weekly" style="display: none;" class="form-group col-sm-8 nopadding">
            <div class="form-group col-sm-6  lft-p-non">
                <label for="spinner">Weeks:</label>
                <input type="text" name="data[Appointment][appointment_repeat_weeks]" id="textfield" value="" class="spinner form-control numOnly" maxlength="2">
            </div>
            <div class="form-group col-sm-6 nopadding">
                <label class="control-label">Day:</label>
                <select id="day" class="form-control" name="data[Appointment][appointment_repeat_day]">
                    <option value="1">Sunday</option>
                    <option value="2">Monday</option>
                    <option value="3">Tuesday</option>
                    <option value="4">Wednesday</option>
                    <option value="5">Thrusday</option>
                    <option value="6">Friday</option>
                    <option value="7">Satuarday</option>
                </select>
            </div>
        </div>
        <div id="repeat-monthly" style="display: none;" class="form-group col-sm-4 lft-p-non">
                <label for="spinner">Day:</label>
                <input type="text" name="data[Appointment][appointment_repeat_month_date]" id="textfield" value=""  class="spinner form-control numOnly" maxlength="2">
        </div>
        <div id="repeat-yearly" style="display: none;" class="form-group col-sm-8 nopadding">
            <div class="form-group col-sm-6  lft-p-non" id="yearly-day">
                <label for="spinner">Day:</label>
                <input type="text" name="data[Appointment][appointment_yearly_repeat_month_date]"  value=""  class="spinner form-control">
            </div>
            <div class="form-group  col-sm-6 nopadding">
                <label class="control-label">Month:</label>
                <select id="month" class="form-control" name="data[Appointment][appointment_repeat_month]">
                    <option value="1">Janurary</option>
                    <option value="2">Feburary</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            
        </div>
    </div>
    <script>
    $(document).ready(function(){
        $('.spinner').spinner({ min: 1,max:31 }).val(1);
    });
    function spinner(val)
    {
        if (val=='1' || val=='3' || val=='5' || val=='7' || val=='8' || val=='10' || val=='12') {
            MaxDay='31';
        }
        else if(val=='2'){
           MaxDay='28'; 
        }
        else{
             MaxDay='30'; 
        }
        $(document).ready(function(){
            $('#yearly-day').html('<label for="spinner">Day:</label><input type="text" name="data[Appointment][appointment_yearly_repeat_month_date]"  value="" class="spinner input-mini">');
            $('.spinner').spinner({ min: 1,max:MaxDay}).val(1);
        });
    }
    $(document).ready(function(){
        $(document).find("#AppointmentAppointmentRepeatType").on("change",function() {
            var selected_val=this.value;
            if($('#AppointmentStartdate').length) {
                var d=$("#AppointmentStartdate").val();
            }
            else{
                var d=startdate;
            }
            var dataSplit = d.split('/');
            var myDate = new Date(dataSplit[1]+' '+dataSplit[0]+', '+dataSplit[2]);
            var select_day=myDate.getDay();
            document.getElementById("day").value = select_day+1;
            if (selected_val=='0') {
                  $("#repeat-yearly").hide();
                  $("#repeat-monthly").hide();
                  $("#repeat-weekly").hide();
                  $("#repeat-daily").hide().find('input').attr('required',false).removeClass('k-invalid');
                  $("#repeat-daily").find('dfn').remove();
            }
            if (selected_val=='1') {
                  $("#repeat-yearly").hide();
                  $("#repeat-monthly").hide();
                  $("#repeat-weekly").hide();
                  $("#repeat-daily").show().find('input').attr('required','required');
            }
            if (selected_val=='2') {
                  $("#repeat-yearly").hide();
                  $("#repeat-monthly").hide();
                  $("#repeat-weekly").show();
                  $("#repeat-daily").show().find('input').attr('required','required');
            }
            if (selected_val=='3') {
                  $("#repeat-yearly").hide();
                  $("#repeat-monthly").show();
                  $("#repeat-weekly").hide();
                  $("#repeat-daily").show().find('input').attr('required','required');
            }
            if (selected_val=='4') {
                  $("#repeat-yearly").show();
                  $("#repeat-monthly").hide();
                  $("#repeat-weekly").hide();
                  $("#repeat-daily").show().find('input').attr('required','required');
            }
      });
    
    <?php if(isset($edit_personal_appointment)) { ?>
            var edit_type="<?php echo $selected; ?>";
            var repeat_date="<?php echo $edit_personal_appointment['Appointment']['appointment_repeat_end_date']; ?>";
            if (edit_type=='1') {
                 $("#repeat-daily").show();
                $('#AppointmentAppointmentRepeatEndDate').datepicker({ dateFormat: 'dd/mm/yy' });
                $('#AppointmentAppointmentRepeatEndDate').datepicker('setDate', new Date(repeat_date));
            }
            if (edit_type=='2') {
                var repeat_weeks="<?php echo $edit_personal_appointment['Appointment']['appointment_repeat_weeks'] ?>";
                var repeat_day="<?php echo $edit_personal_appointment['Appointment']['appointment_repeat_day'] ?>";
                $("#repeat-weekly").show();
                $("#repeat-daily").show();
                $('#AppointmentRepeatEndDate').datepicker({ dateFormat: 'mm/dd/yy' });
                $('#AppointmentRepeatEndDate').datepicker('setDate', new Date(repeat_date));
                $('.spinner').spinner('value', repeat_weeks);
                $('#day').val(repeat_day).change(); 
            }
            if (edit_type=='3') {
                var repeat_month_day="<?php echo $edit_personal_appointment['Appointment']['appointment_repeat_month_date'] ?>";
                $("#repeat-daily").show();
                $("#repeat-monthly").show();
                $('#AppointmentRepeatEndDate').datepicker({ dateFormat: 'mm/dd/yy' });
                $('#AppointmentRepeatEndDate').datepicker('setDate', new Date(repeat_date));
                $('.spinner').spinner('value', repeat_month_day);
            }
            if (edit_type=='4') {
                var repeat_month="<?php echo $edit_personal_appointment['Appointment']['appointment_repeat_month'] ?>";
                var repeat_month_date="<?php echo $edit_personal_appointment['Appointment']['appointment_yearly_repeat_month_date'] ?>";
                $("#repeat-daily").show();
                $("#repeat-yearly").show();
                $('#AppointmentRepeatEndDate').datepicker({ dateFormat: 'mm/dd/yy' });
                $('#AppointmentRepeatEndDate').datepicker('setDate', new Date(repeat_date));
                $('#month').val(repeat_month).change(); 
                $('.spinner').spinner('value', repeat_month_date);
            }
  <?php } ?>
});
</script>
