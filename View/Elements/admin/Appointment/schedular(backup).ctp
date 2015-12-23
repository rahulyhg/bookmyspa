<script src="http://www.jqueryscript.net/demo/jQuery-Modal-Dialog-Plugin-For-Bootstrap-3-Bootstrap-3-Dialog/examples/assets/bootstrap-dialog/js/bootstrap-dialog.js"></script>
<link href="http://www.jqueryscript.net/demo/jQuery-Modal-Dialog-Plugin-For-Bootstrap-3-Bootstrap-3-Dialog/examples/assets/bootstrap-dialog/css/bootstrap-dialog.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<?php //echo $this->Html->script('admin/bootstrap-dialog.js'); ?>
			<?php //echo $this->Html->css('admin/bootstrap-dialog.css'); ?>

<style>
    td.top-border{
        border-top: 2px solid red;
        padding-bottom: 0px;
    }
    
    .k-si-close{
        display: none;
    }
</style>
<br>
<?php
    //echo $startDate;
    echo $this->Form->hidden('startDate',array('value'=>strtotime($startDate),'label'=>false,'div'=>false,'id'=>'schStartDate')); ?>
<br>
<div id="scheduler"></div>
<script id="appointment-template" type="text/x-kendo-template">
    <div style="border-left:10px solid red; padding:10px 20px;   color:white; height:1000px; background-color: #=colorVal#" class="appointment-template-box #: eventType #  #: styleclass # #: repeatclass #">
        <!--<img src="#= repeatImg #">-->
        <p style="margin-bottom:0;background-color: #=requestColor#">#: returnRequest #</p>
        <p style="margin-bottom:0;">#: title #</p>
        <p style="margin-bottom:0;">#: description #</p>
    </div>
</script>


<?php
    //pr($open_close_hours); die;
    $opening_hours=date('h:i A',$open_close_hours[0]);
  $closing_hours=date('h:i A',$open_close_hours[1]); 
    $minTickCount = 2;
    if(isset($calsettings['SalonCalendarSetting']['label_lines']) && $calsettings['SalonCalendarSetting']['label_lines']){
        $minTickCount = 1;    
    }
    $startDay = array('1'=>'monday','2'=>'tuesday','3'=>'wednesday','4'=>'thursday','5'=>'friday','6'=>'saturday','0'=>'sunday');   
    $day = 0;
    if(!empty($calsettings['SalonCalendarSetting']['week_start_day'])){
        if($calsettings['SalonCalendarSetting']['week_start_day'] == 'today'){
            $day = date('w');
        }else{
            $day = array_search($calsettings['SalonCalendarSetting']['week_start_day'], $startDay);
        }
    }
    $defaultView = 'week';
    if(!empty($calsettings['SalonCalendarSetting']['default_view'])){
        $defaultView = $calsettings['SalonCalendarSetting']['default_view'];
    }
    $defaultResoltion = '15';
    if(!empty($calsettings['SalonCalendarSetting']['calendar_resolution'])){
        $defaultResoltion = $calsettings['SalonCalendarSetting']['calendar_resolution'];
    }
    $schedularView = '[
            "day",
            {type: "week", selected: true, allDaySlot:false, majorTick:'.($defaultResoltion*2).' },
            "month"
        ]';
    if($defaultView == 'month'){
        $schedularView = '[
            "day",
            "week",
            {type: "month", selected: true, allDaySlot:false}
        ]';    
    }elseif($defaultView == 'day'){
        $schedularView = '[
            {type: "day", selected: true, allDaySlot:false, majorTick:'.($defaultResoltion*2).'},
            "week",
            "month"
        ]';    
    }
?>
<script>
$(function() {
    $('#treatmntCheck').find('input[type=checkbox]').change(function(e){
        var checked = $.map($('#treatmntCheck').find('input[type=checkbox]:checked'), function (checkbox) {
            return parseInt($(checkbox).val());
        });
        if($.isEmptyObject(checked)){
            checked = $.map($('#treatmntCheck').find('input[type=checkbox]'), function (checkbox) {
                return parseInt($(checkbox).val());
            });
        }
        var scheduler = $("#scheduler").data("kendoScheduler");
        scheduler.dataSource.filter({
            operator: function (task) {
                return $.inArray(task.treatmentId, checked) >= 0;
            }
        });
    });
    
     function scheduler_move(e) {
      
       var movedate=e.start;
       //console.log(e);
        var UnixTimeStamp = movedate.getUnixTime();
        var Timezone = movedate.getTimezoneOffset()*60;  
        var moveDate=UnixTimeStamp+(-Timezone);
        // console.log(moveDate);
         $.ajax({
                url: "Appointments/saveMovedEvent",
                method: "POST",
                data: { movedate : moveDate,id: e.event.id},
                        }).done(function(response) {
                      
       });
     }
    
    
    
    kendo.culture().calendar.firstDay = <?php echo $day; ?>;
    $("#scheduler").kendoScheduler({
        date: new Date("<?php echo $startDate; ?>"),
        startTime: new Date("<?php echo $startDate.' '.$opening_hours; ?>"),
        //startTime: new Date("2013/6/13 08:00 AM"),
       endTime: new Date("<?php echo $startDate.' '.$closing_hours; ?>"),
        views: <?php echo $schedularView; ?>,
        //timezone: "IST",
        //timezone: "Etc/UTC",
        selectable: true,
        minorTickCount: <?php echo $minTickCount; ?>,
        footer: false,
        change: function(e) {
           selectState = e;
        },
        moveEnd: scheduler_move,
        dataBound: function (e) {
            var scheduler = this;
            var view = scheduler.view();
            
            view.table.find("td[role=gridcell]").each(function () {
                var element = $(this);
                var slot = scheduler.slotByElement(element);
               
                var Index=slot.groupIndex;
                var record='<?php echo $fulldata['openHours']; ?>';
                var opening_hours = jQuery.parseJSON(record);
                var start = slot.startDate;
                //console.log(kendo.format("{dd-MM-yyyy}", slot.startDate));
                
                var selectedDate = kendo.format("{0:dd-MM-yyyy}", slot.startDate);
                //console.log(slot.groupIndex);
                var nonworkinghours='<?php echo $fulldata['non_working_days']; ?>';
                
               //console.log(record);
                //console.log(nonworkinghours);
                 var nonworkinghours = jQuery.parseJSON(nonworkinghours);
                //console.log(nonworkinghours);
                //view.table.find("td[role=gridcell]").each(function () {
                 //var nonworkinghours = jQuery.parseJSON(nonworkinghours);
               // alert(selectedDate);
                //}
                  //$.each(nonworkinghours, function() {
                var unix_timestamp = Math.round(start.getTime() / 1000);
                var date = new Date(unix_timestamp*1000);
                var hours = date.getHours();
                var day = date.getDay();
                var minutes = "0" + date.getMinutes();
                var seconds = "0" + date.getSeconds();
                var gpIndex = slot.groupIndex;
                var dNow = new Date();
                var localdate= dNow.getFullYear() + '/' +(dNow.getMonth()+1) + '/' + dNow.getDate();
               if (opening_hours.openHours[gpIndex]) {
                    if (opening_hours.openHours[gpIndex][day]) {
                        var start_time=localdate +' '+opening_hours.openHours[gpIndex][day].sTime;
                        var end_time=localdate +' '+opening_hours.openHours[gpIndex][day].eTime;
                        var formattedTime = localdate+' '+hours + ':' + minutes.substr(minutes.length-2);
                        var unixstartTime = Date.parse(start_time)/1000;
                        var unixendTime = Date.parse(end_time)/1000;
                        var unixformattedTime=Date.parse(formattedTime)/1000;
                        if (unixformattedTime>=unixstartTime && unixformattedTime < unixendTime ) {
                            element.removeClass("k-nonwork-hour").addClass('working-hour'); 
                        }else{
                            element.addClass("k-nonwork-hour").removeClass('working-hour'); 
                        }
                    }
                    else{
                       element.addClass("k-nonwork-hour").removeClass('working-hour'); 
                    }
                }
                else{
                    element.addClass("k-nonwork-hour").removeClass('working-hour'); 
                }
                
                
                
               if (typeof(nonworkinghours) != "undefined" && nonworkinghours !== null) {
                    $.each(nonworkinghours, function(i, val) {
                        if (nonworkinghours[i].date==selectedDate && Index==nonworkinghours[i].groupindex) {
                          // console.log(nonworkinghours[i].date);
                           console.log(Index);
                            element.addClass("k-nonwork-hour").removeClass('working-hour');
                    }
                });
            }
                
                
                if(element.hasClass('k-today')){
                    element.removeClass('k-today');
                    <?php if($calsettings['SalonCalendarSetting']['mark_current_time']){?>
                    var currentTime = new Date(Date.now());
                    var currentHour = currentTime.getHours();
                    if(currentHour == hours){
                        var thetime = '<?php echo ($defaultResoltion); ?>';
                        var currentMin = currentTime.getMinutes();
                        var gapMin = parseInt(currentMin)+parseInt(thetime);
                        minutes = parseInt(minutes);
                        if( minutes >= currentMin &&  minutes < gapMin){
                            element.addClass('top-border');
                        }
                    }
                    <?php } ?>
                    
                }
                
            })
        },
        
        group: {
            resources: ["Employee"]
        },
        eventTemplate: $("#appointment-template").html(),
        dataSource: {
            data:<?php echo $fulldata['appointments']; ?>,
            filter: {
                logic: "or",
                filters: <?php echo $fulldata['treatfilter']; ?>
            }
        },
        
        resources:[
            {
                field: "employeeId",
                name: "Employee",
                dataSource: <?php echo $fulldata['employee']; ?> 
            }
        ]
    });
    
 
    $.contextMenu({
        selector: '.the-appointment',
        trigger: 'leftright',
        callback: function (key, options) {
            var scheduler = $("#scheduler").data("kendoScheduler");
            var dataSource = scheduler.dataSource;
            //var uid = $(this).attr("data-uid");
            var uid = $(this).parent().attr("data-uid");
            if (key == "edit") {
                //alert(key);
                //var dataItem = dataSource.getByUid(uid);
                //scheduler.editEvent(dataItem);
                
                
                //var dataItem = dataSource.getByUid(uid);
                //eventId=dataItem.id;
                //addPersonalTask($appModal,selectState,eventId);
                
                var dataItem = dataSource.getByUid(uid);
                eventId=dataItem.id;
                var EditType='';
                       //alert(eventId);
                        
                        $.ajax({
                            url: "Appointments/checkRepeatAppointment",
                            method: "POST",
                            data: { id : eventId },
                        }).done(function(response) {
                                //alert(response);
                                
                                if (response>0) {
                   
                
                var message='<div><input id="AppointmentOccurOnly" class="radio-inline cancelPeriodRadioPolicy" type="radio" value="only" checked name="data[Appointment][occur]"><label class="new-chk" for="AppointmentOccurOnly">Edit only this occurrence</label><input id="AppointmentSeries" class="radio-inline cancelPeriodRadioPolicy" type="radio" value="series" name="data[Appointment][occur]"><label class="new-chk" for="AppointmentSeries">Edit Series</label></div>';
               
        BootstrapDialog.show({
            message: message,
            buttons: [{
                label: 'Edit Appointment(s)',
                cssClass: 'btn-primary',
                action: function(dialogRef){
                    if ($('#AppointmentOccurOnly').is(":checked"))
                        {
                          var EditType='only';
                        }
                    if ($('#AppointmentSeries').is(":checked"))
                        {
                          var EditType='series';
                        }
                        dialogRef.close();
                        
                        addAppointment($appModal,selectState,eventId,EditType);
                        }
                     },
                    {
                        label: 'Do Not Edit',
                        action: function(dialogRef) {
                            typeof dialogRef.getData('callback') === 'function' && dialogRef.getData('callback')(true);
                            dialogRef.close();
                        }
                    }
            ]
        });
    
                }
                else{
                    addAppointment($appModal,selectState,eventId,EditType);  
                }
        });
                
                
                
                
                
                //var dataItem = dataSource.getByUid(uid);
                //eventId=dataItem.id;
                //addAppointment($appModal,selectState,eventId);
                
            } else if (key == "delete") {
                var dataItem = dataSource.getByUid(uid);
                scheduler.removeEvent(dataItem);
            }
            
        },
        items: {
            "edit"  : {name: "Edit",icon: "edit"},
            "note": {name: "Note",icon: "note"},
            "custHistory": {name: "Customer History",icon: "history"},
            "delete": {name: "Delete",icon: "delete"},
            "print": {name: "Print Ticket",icon: "print"},
            "accepted": {name: "Accepted",icon: "accepted"},
            "deny": {name: "Deny",icon: "blank"},
            "confirm": {name: "Confirm",icon: "blank"},
            "show": {name: "Show",icon: "blank"},
            "noShow": {name: "No Show",icon: "blank"},
            "serviceInprogress": {name: "Service In Progress",icon: "blank"},
            "serviceComplete": {name: "Service Complete (Checkout)",icon: "blank"},
            "cancel": {name: "Cancel",icon: "blank"},
            "moveFwd": {name: "Move Forward",icon: "blank"},
            "moveBwd": {name: "Move Backward",icon: "blank"}
        }
    });

    
    
    $.contextMenu({
        selector: '.the-personal',
        trigger: 'leftright',
        callback: function (key, options) {
            var scheduler = $("#scheduler").data("kendoScheduler");
            var dataSource = scheduler.dataSource;
            var uid = $(this).parent().attr("data-uid");
            if (key == "edit") {
                var dataItem = dataSource.getByUid(uid);
                eventId=dataItem.id;
                addPersonalTask($appModal,selectState,eventId);
               } else if (key == "delete") {
                var dataItem = dataSource.getByUid(uid);
                scheduler.removeEvent(dataItem);
            }
        },
        items: {
            "edit"  : {name: "Edit",icon: "edit"},
            "delete": {name: "Delete",icon: "delete"},
        }
    });
    
    $.contextMenu({
        selector: '.k-nonwork-hour',
        trigger: 'leftright',
        callback: function (key, options) {
            var scheduler = $("#scheduler").data("kendoScheduler");
            var dataSource = scheduler.dataSource;
            var uid = $(this).attr("data-uid");
            var AddConfirm = confirm("You are trying to add nonworking hours Appointment!");
            if (AddConfirm == false) {
                return false;
            } 
            if (key == "add") {
               var eventId = "";
                //var eventId = "";
                addAppointment($appModal,selectState,eventId,'');
            }
            else if (key == "pTask") {
                var eventId = "";
                addPersonalTask($appModal,selectState,eventId);
            }
            else if (key == "waiting") {
                var eventId = "";
                addWaitingTask($appModal,selectState,eventId);
            }
            else if (key == "multiapp") {
                var eventId = "";
                addMultipleAppointments($appModal,selectState,eventId);
            }
             else if (key == "workHours") {
                var eventId = "";
                editWorkingHours($appModal,selectState,eventId);
            }
        },
        items: {
            "add": {name: "New Appointment",icon: "calender"},
            "multiapp": {name: "New Multiple Appointment",icon: "table"},
            "waiting": {name: "Add to Waiting List",icon: "clock"},
            "pTask": {name: "Personal Task",icon: "ban"},
            "workHours": {name: "Edit Working Hours",icon: "pencil"}
        }
   
    });
    
    
    $.contextMenu({
        selector: '.working-hour',
        trigger: 'leftright',
        callback: function (key, options) {
            if (key == "add") {
                var eventId = "";
                addAppointment($appModal,selectState,eventId,'');
            }
            else if (key == "pTask") {
                var eventId = "";
                addPersonalTask($appModal,selectState,eventId);
            }
        },
        items: {
            "add": {name: "New Appointment",icon: "calender"},
            "multiapp": {name: "New Multiple Appointment",icon: "table"},
            "waiting": {name: "Add to Waiting List",icon: "clock"},
            "pTask": {name: "Personal Task",icon: "ban"},
            "workHours": {name: "Edit Working Hours",icon: "pencil"}
        }
    });
});


    function addAppointment($appModal,selectState,eventId,editType){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var addUserURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addAppointment','admin'=>true)); ?>";
        addUserURL  = addUserURL +'/'+startDate+'/'+employeeId+'/'+eventId+'/'+editType; 
        fetchModal($appModal,addUserURL);
    }
    
    function addPersonalTask($appModal,selectState,eventId){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var addPersonalTaskURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addPersonaltask','admin'=>true)); ?>";
        addPersonalTaskURL  = addPersonalTaskURL +'/'+startDate+'/'+employeeId+'/'+eventId; 
        fetchModal($appModal,addPersonalTaskURL);
    }
    
    function addWaitingTask($appModal,selectState,eventId){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var addPersonalTaskURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addWaitingtask','admin'=>true)); ?>";
        addPersonalTaskURL  = addPersonalTaskURL +'/'+startDate+'/'+employeeId+'/'+eventId; 
        fetchModal($appModal,addPersonalTaskURL);
    }
    
    function addMultipleAppointments($appModal,selectState,eventId){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var addMultipleAppointmentsURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addMultipleappointments','admin'=>true)); ?>";
        addMultipleAppointmentsURL  = addMultipleAppointmentsURL +'/'+startDate+'/'+employeeId+'/'+eventId; 
        fetchModal($appModal,addMultipleAppointmentsURL);
    }
    
    function editWorkingHours($appModal,selectState,eventId){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var editWorkinghoursURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'editWorkinghours','admin'=>true)); ?>";
        editWorkinghoursURL  = editWorkinghoursURL +'/'+startDate+'/'+employeeId+'/'+eventId; 
        fetchModal($appModal,editWorkinghoursURL);
    }
    function checkrecursive($appModal,selectState){
    alert("test");    
    }
</script>
