<div class="col-sm-8">
<?php echo $this->Form->create('SalonOpeningHour',array('id'=>'saveForm','class'=>'form-horizontal'));?>
<div class="row"> 
    <div id="errorDiv">
    </div>
    <div class="col-sm-12">
        
        <div class="box">
          <div class="box-content">
                <?php echo $this->element('admin/Settings/open_hours');  ?>
                <!--<div class="col-sm-12">
                        <div  class='col-sm-6  col-xs-6'><?php echo __('Time Zone');?></div>
			    <?php echo $this->Form->input('SalonOpeningHour.timezone',array('options'=>$timezones,'label'=>false,'div'=>array('class'=>'col-sm-6 col-xs-6 pdng-bottom'),'class'=>'form-control pull-right')); ?>
		</div>-->
                <div class="col-sm-12">
                    <fieldset>
                        <div class="form-actions col-sm-12 text-right">
                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update  save_open_hours','label'=>false,'div'=>false));?>                           
                        </div>
                    </fieldset> 
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        //$(document).find('ul.week').removeClass('col-sm-7').addClass('col-sm-5');
        $('#saveForm').submit(function() {
            var formData = $(this).serialize();
            var dNow = new Date();
            var localdate= dNow.getFullYear() + '/' +(dNow.getMonth()+1) + '/' + dNow.getDate();
            $("#message").hide();
            if($('#Mon').is(':checked'))
                {
                    var MondayStartTime=localdate +' '+$("#SalonOpeningHourMondayFrom").val();
                    var MondayEndTime=localdate +' '+$("#SalonOpeningHourMondayTo").val();
                    var monday_from_unix_timestamp = new Date(Date.parse(MondayStartTime));
                    var monday_to_unix_timestamp = new Date(Date.parse(MondayEndTime));
                    if ( (monday_from_unix_timestamp > monday_to_unix_timestamp) || (monday_from_unix_timestamp == monday_to_unix_timestamp)) {
                         $("#SalonOpeningHourMondayFrom").css("border-color", "red");
                         $("#SalonOpeningHourMondayFrom").focus();
                         $("#message").show();
                        return false;
                    }
                    else{
                        $("#SalonOpeningHourMondayFrom").css("border-color", "");
                    }
                }
            if($('#Tue').is(':checked'))
                {
                    var TuesdayStartTime=localdate +' '+$("#SalonOpeningHourTuesdayFrom").val();
                    var TuesdayEndTime=localdate +' '+$("#SalonOpeningHourTuesdayTo").val();
                    var tuesday_from_unix_timestamp = new Date(Date.parse(TuesdayStartTime));
                    var tuesday_to_unix_timestamp = new Date(Date.parse(TuesdayEndTime));
                    if ( (tuesday_from_unix_timestamp > tuesday_to_unix_timestamp) || (tuesday_from_unix_timestamp == tuesday_to_unix_timestamp)) {
                        $("#SalonOpeningHourTuesdayFrom").focus();
                        $("#SalonOpeningHourTuesdayFrom").css("border-color", "red");
                        $("#message").show();
                        return false;
                    }
                    else{
                        $("#SalonOpeningHourMondayFrom").css("border-color", "");
                    }
                }
            if($('#Wed').is(':checked'))
                {
                    var WednesdayStartTime=localdate +' '+$("#SalonOpeningHourWednesdayFrom").val();
                    var WednesdayEndTime=localdate +' '+$("#SalonOpeningHourWednesdayTo").val();
                    var wednesday_from_unix_timestamp = new Date(Date.parse(WednesdayStartTime));
                    var wednesday_to_unix_timestamp = new Date(Date.parse(WednesdayEndTime));
                    if ( (wednesday_from_unix_timestamp > wednesday_to_unix_timestamp) || (wednesday_from_unix_timestamp == wednesday_to_unix_timestamp)) {
                        $("#SalonOpeningHourWednesdayFrom").focus();
                        $("#SalonOpeningHourWednesdayFrom").css("border-color", "red");
                        $("#message").show();
                        return false;
                    }
                    else{
                        $("#SalonOpeningHourMondayFrom").css("border-color", "");
                    }
                }
            if($('#Thu').is(':checked'))
                {
                    var ThursdayStartTime=localdate +' '+$("#SalonOpeningHourThursdayFrom").val();
                    var ThursdayEndTime=localdate +' '+$("#SalonOpeningHourThursdayTo").val();
                    var thursday_from_unix_timestamp = new Date(Date.parse(ThursdayStartTime));
                    var thursday_to_unix_timestamp = new Date(Date.parse(ThursdayEndTime));
                    if ( (thursday_from_unix_timestamp > thursday_to_unix_timestamp) || (thursday_from_unix_timestamp == thursday_to_unix_timestamp)) {
                        $("#SalonOpeningHourThursdayFrom").focus();
                        $("#SalonOpeningHourThursdayFrom").css("border-color", "red");
                        $("#message").show();
                        return false;
                    }
                    else{
                        $("#SalonOpeningHourMondayFrom").css("border-color", "");
                    }
                }
            if($('#Fri').is(':checked'))
                {
                    var FridayStartTime=localdate +' '+$("#SalonOpeningHourFridayFrom").val();
                    var FridayEndTime=localdate +' '+$("#SalonOpeningHourFridayTo").val();
                    var friday_from_unix_timestamp = new Date(Date.parse(FridayStartTime));
                    var friday_to_unix_timestamp = new Date(Date.parse(FridayEndTime));
                    if ( (friday_from_unix_timestamp > friday_to_unix_timestamp) || (friday_from_unix_timestamp == friday_to_unix_timestamp)) {
                        $("#SalonOpeningHourFridayFrom").focus();
                        $("#SalonOpeningHourFridayFrom").css("border-color", "red");
                        $("#message").show();
                        return false;
                    }
                    else{
                        $("#SalonOpeningHourMondayFrom").css("border-color", "");
                    }
                }
            if($('#Sat').is(':checked'))
                {
                    var SaturdayStartTime=localdate +' '+$("#SalonOpeningHourSaturdayFrom").val();
                    var SaturdayEndTime=localdate +' '+$("#SalonOpeningHourSaturdayTo").val();
                    var saturday_from_unix_timestamp = new Date(Date.parse(SaturdayStartTime));
                    var saturday_to_unix_timestamp = new Date(Date.parse(SaturdayEndTime));
                    if ( (saturday_from_unix_timestamp > saturday_to_unix_timestamp) || (saturday_from_unix_timestamp == saturday_to_unix_timestamp)) {
                        $("#SalonOpeningHourSaturdayFrom").focus();
                        $("#SalonOpeningHourSaturdayFrom").css("border-color", "red");
                        $("#message").show();
                        return false;
                    }
                    else{
                        $("#SalonOpeningHourMondayFrom").css("border-color", "");
                    }
                }
            if($('#Sun').is(':checked'))
                {
                    var SundayStartTime=localdate +' '+$("#SalonOpeningHourSundayFrom").val();
                    var SundayEndTime=localdate +' '+$("#SalonOpeningHourSundayTo").val();
                    var sunday_from_unix_timestamp = new Date(Date.parse(SundayStartTime));
                    var sunday_to_unix_timestamp = new Date(Date.parse(SundayEndTime));
                    if ( (sunday_from_unix_timestamp > sunday_to_unix_timestamp) || (sunday_from_unix_timestamp == sunday_to_unix_timestamp)) {
                        $("#SalonOpeningHourSundayFrom").focus();
                        $("#SalonOpeningHourSundayFrom").css("border-color", "red");
                        $("#message").show();
                        return false;
                    }
                    else{
                        $("#SalonOpeningHourMondayFrom").css("border-color", "");
                    }
                }
            
            var formUrl = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: formUrl,
                data: formData,
                success: function(data) {
                    response = JSON.parse(data);
                    if(response.data == 'service'){
                        <?php if($typeoff != 'saloon'){ ?>
                            window.location = '<?php echo $this->html->url(array('controller' => 'Business', 'action' => 'staffservices', 'admin' => true)); ?>'+'/'+response.staffID;
                        <?php }?>
                    }
                    if (response.data == 'success') {
                        <?php if($typeoff != 'saloon'){ ?>
                            window.location = '<?php echo $this->html->url(array('controller' => 'SalonStaff', 'action' => 'index', 'admin' => true)); ?>';
                        <?php }?>
                    }
                    onResponseBoby(data);
                    
                    
                    
                },
            });
            return false;
        });
    });
</script>
<?php echo $this->Form->end(); ?>
</div>
<style>
    .pdng-bottom{
        padding-bottom: 20px;
    }
</style>