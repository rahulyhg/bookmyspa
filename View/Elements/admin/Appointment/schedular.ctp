<script>
    var dubai_timezone=4*3600;
</script>
<style>
    td.top-border{
        border-top: 2px solid red;
        padding-bottom: 0px;
    }
    .k-si-close{
        display: none;
    }
</style>
<script>
    var nav='';
</script>
<?php echo $this->Form->hidden('startDate',array('value'=>strtotime($startDate),'label'=>false,'div'=>false,'id'=>'schStartDate')); ?>
<div id="scheduler"></div>
<script id="appointment-template" type="text/x-kendo-template">
    <div style="border-left:10px solid red; padding:10px;   color:white; height:1000px; background-color: #=colorVal#" class="appointment-template-box #: eventType #  #: styleclass #  #: checkoutclass # #: typeclass #" title="#: hoverTitle #">
        <!--<img src="#= repeatImg #">-->
		<p style="float:left;padding:2px 3px; margin-bottom:0px;"><i class="#: repeatclass #"></i></p>
        <p style="margin-bottom:0;background-color: #=requestColor#; float:left; margin-right:5px; font-size: 12px; padding:3px;">#: returnRequest #</p>
        <p style="margin-bottom:0;">#: title #</p>
        <p style="margin-bottom:0;">#: description #</p>
    </div>
</script>
<?php
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
    if(isset($defaultView) && $defaultView!='' && $defaultView=='day'){
        $calView=$defaultView;
    	$schedularView = '[
            {type: "day", selected: true, allDaySlot:false, majorTick:'.($defaultResoltion*2).'},
            "week",
            "month"
        ]';  
    }elseif(isset($defaultView) && $defaultView!='' && $defaultView=='week'){
        $calView=$defaultView;
        $schedularView = '[
            "day",
            {type: "week", selected: true, allDaySlot:false, majorTick:'.($defaultResoltion*2).' },
            "month"
        ]';
    }elseif(isset($defaultView) && $defaultView!='' && $defaultView=='month'){
        $calView=$defaultView;
        $schedularView = '[
            "day",
            "week",
            {type: "month", selected: true, allDaySlot:false, majorTick:'.($defaultResoltion*2).' },
        ]';
    }
    if(isset($customView) && $customView!='' && $customView=='week'){
        $calView=$customView;
        $schedularView = '[
            "day",
            {type: "week", selected: true, allDaySlot:false, majorTick:'.($defaultResoltion*2).' },
            "month"
        ]';
    }elseif(isset($customView) && $customView!='' && $customView=='day'){
         $calView=$customView;
         $schedularView = '[
            {type: "day", selected: true, allDaySlot:false, majorTick:'.($defaultResoltion*2).'},
            "week",
            "month"
        ]';  
    }elseif(isset($customView) && $customView!='' && $customView=='month'){
        $calView=$customView;
        $schedularView = '[
            "day",
            "week",
            {type: "month", selected: true, allDaySlot:false, majorTick:'.($defaultResoltion*2).' }
            
        ]';   
    }
?>
<script type="text/javascript">
    $(function() {
        $('#treatmntCheck').find('input[type=checkbox]').change(function(e){
            var checked = $.map($('#treatmntCheck').find('input[type=checkbox]:checked'), function (checkbox){
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
            var flag=1;
            if (e.event.checkoutclass) {
                alert("Can not move this appointment");
                flag=0;
                location.reload();
                return false;
            }
            if (flag==1) {
                var fromMoveDate=selectState.start;
                var UnixTimeStamp = fromMoveDate.getUnixTime();
                var Timezone = fromMoveDate.getTimezoneOffset();
                var fromMoveDate=UnixTimeStamp+(-Timezone);
                var movedate=e.start;
                var UnixTimeStamp = movedate.getUnixTime();
                var Timezone = movedate.getTimezoneOffset();  
                var moveDate=UnixTimeStamp+(-Timezone+4800);
                var moveToResource=e.resources.employeeId;
                var id=e.event.id;
                message='Do you want to notify the Customer By Email, Text or Push Notification?';
                title='Notify Customer';
                BootstrapDialog.show({
                    message: message,
                    title:title,
                    buttons: [{
                        label: 'Undo Move',
                        cssClass: 'btn-primary',
                        action: function(dialogRef){
                            var result='no-move';
                            dialogRef.close();
                            location.reload();
                        }
                    },
                        {
                        label: 'Notify Customer',
                        action: function(dialogRef) {
                            var notify='1';
                            dialogRef.close();
                            $.ajax({
                                    url: "Appointments/saveMovedEvent",
                                    method: "POST",
                                    data: { movedate : moveDate,
                                            id: id,
                                            fromMoveDate:fromMoveDate,
                                            moveToResource:moveToResource,
                                            notify:notify
                                        },
                            }).done(function(response) {
                                location.reload();
                        });
                    }},
                        {
                        label: 'Dont Notify Customer',
                        action: function(dialogRef) {
                                dialogRef.close();
                            var notify='0';
                            $.ajax({
                                    url: "Appointments/saveMovedEvent",
                                    method: "POST",
                                    data: { movedate : moveDate,
                                            id:id,
                                            fromMoveDate:fromMoveDate,
                                            moveToResource:moveToResource,
                                            notify:notify
                                        },
                                    }).done(function(response) {
                                location.reload();
                            });
                            
                        }
                    }]
                });
            }
        }
        function scheduler_resize(e) {
            var flag=1;
            if (e.event.checkoutclass) {
                alert("Can not resize this appointment");
                flag=0;
                location.reload();
            }
            if (flag==1) {
                var fromResizeDate=e.start;
                var UnixTimeStamp = fromResizeDate.getUnixTime();
                var Timezone = fromResizeDate.getTimezoneOffset()*60;
                Timezone=Timezone+dubai_timezone;
                var fromResizeDate=UnixTimeStamp+(-Timezone);
                var toResizeDate=e.end;
                var UnixTimeStamp = toResizeDate.getUnixTime();
                var Timezone = toResizeDate.getTimezoneOffset()*60;
                Timezone=Timezone+dubai_timezone;
                var toResizeDate=UnixTimeStamp+(-Timezone);
                $.ajax({
                    url: "Appointments/saveResizedEvent",
                    method: "POST",
                    data: { resizestartdate : fromResizeDate,
                            resizeenddate : toResizeDate,
                            id:e.event.id,
                        },
                    }).done(function(response) {
                        location.reload();
                });
            }
        }
	    function scheduler_navigate(e) {
            e.preventDefault();
            nav='click';
            cal_view=e.view;
            cal_start_date=e.date;
            var UnixTimeStamp = cal_start_date.getUnixTime();
            var Timezone = cal_start_date.getTimezoneOffset()*60;  
            var cal_start_date=UnixTimeStamp+(-Timezone);
		    action=e.action;
            $.ajax({
                url: "Appointments/setCalenderView",
                method: "POST",
                data: { view : cal_view,cal_start_date:cal_start_date,action:action},
            }).done(function(response) {
                $.post("<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'index','admin'=>true));?>",function(data) {
                $(document).find('#data-scheduled').html(data);
                });
            });
		}
        kendo.culture().calendar.firstDay = <?php echo $day; ?>;
        $("#scheduler").kendoScheduler({
            date: new Date("<?php echo $startDate; ?>"),
            startTime: new Date("<?php echo $startDate.' '.$opening_hours; ?>"),
            endTime: new Date("<?php echo $startDate.' '.$closing_hours; ?>"),
            views: <?php echo $schedularView; ?>,
            height: 500,
            selectable: true,
            minorTickCount: <?php echo $minTickCount; ?>,
            footer: false,
            change: function(e) {
                selectState = e;
            },
             edit: function(e) {
                e.preventDefault();
                return false;
            },
            moveEnd: scheduler_move,
            resizeEnd: scheduler_resize,
            navigate: scheduler_navigate,
            editable: {
                confirmation: false
            },
            dataBound: function (e) {
                calenderdate=e.sender._model.formattedDate;
                CalView='<?php echo $calView; ?>';
                if (nav=='') {
                    $.ajax({
                        url: "Appointments/setCalederEventDate",
                        method: "POST",
                        data: { calenderdate : calenderdate,
                                CalView:CalView},
                        }).done(function(response) {
                    });
                }
                var scheduler = this;
                var view = scheduler.view();
                view.table.find("td[role=gridcell]").each(function (e) {
                    var element = $(this);
                    $( element ).attr( "id",e );
                    var slot = scheduler.slotByElement(element);
                    var Index=slot.groupIndex;
                    var record='<?php echo $fulldata['openHours']; ?>';
                    var opening_hours = jQuery.parseJSON(record);
                    var start = slot.startDate;
                    var selectedDate = kendo.format("{0:dd-MM-yyyy}", slot.startDate);
                    var openhoursselectdate=kendo.format("{0:yyyy/MM/dd}", slot.startDate);
                    var unix_timestamp = Math.round(start.getTime() / 1000);
                    var date = new Date(unix_timestamp*1000);
                    var hours = date.getHours();
                    var day = date.getDay();
                    var minutes = "0" + date.getMinutes();
                    var seconds = "0" + date.getSeconds();
                    var gpIndex = slot.groupIndex;
                    var dNow = new Date();
                    var localdate= dNow.getFullYear() + '/' +(dNow.getMonth()+1) + '/' + dNow.getDate();
                    if (view.name!='month') {
                        if (opening_hours.openHours[gpIndex]) {
                            if (opening_hours.openHours[gpIndex][day]) {
                               var cell_date=slot.startDate;
                               var cell_date = Date.parse(cell_date)/1000;
                               var cell_start_time=cell_date+60*330;
                               var start_time=openhoursselectdate +' '+opening_hours.openHours[gpIndex][day].sTime;
                               var end_time=openhoursselectdate +' '+opening_hours.openHours[gpIndex][day].eTime;
                               var formattedTime = openhoursselectdate+' '+hours + ':' + minutes.substr(minutes.length-2);
                               var start_time = Date.parse(start_time)/1000;
                               var start_time=start_time+60*330;
                               var end_time = Date.parse(end_time)/1000;
                               var end_time=end_time+60*330;
                               if ( (cell_start_time>=start_time) && (cell_start_time < end_time)){
                                    element.removeClass("k-nonwork-hour").addClass('working-hour');
                                     element.addClass('working-hour'); 
                                    $( '#'+e ).attr( "title",start );
                                }else{
                                    element.addClass("k-nonwork-hour").removeClass('working-hour');
                                    $( '#'+e ).attr( "title",start );
                                }
                            }
                            else{
                              element.addClass("k-nonwork-hour").removeClass('working-hour');
                                $( '#'+e ).attr( "title",start );
                            }
                        }
                        else{
                            element.addClass("k-nonwork-hour").removeClass('working-hour'); 
                        }
                    }else{
                        var date = selectedDate.split('-');
                        var months = ["Jan", "Feb", "Mar","Apr", "May", "Jun","Jul", "Aug", "Sep","Oct", "Nov", "Dec"];
                        if(date[0]=='01') {
                            date[1] = date[1].replace(/^0+/, '')-1;
                            $(document).find('#'+e).html('<span class="k-link k-nav-day">01-'+months[date[1]]+'-'+date[2]+'</span>'); 
                        }
                        element.addClass('month-working-hour'); 
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
                batch: true,
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
        $(document).find('.checkout').click(function(){
            alert("Appointment is already checkedout");
            return false;
        });
        
        
        $.contextMenu({ 
            selector: '.front',
            trigger: 'left',
            build: function($trigger, e) {
                $('.context-menu-list').hide();
                $(document).find(".working-hour").removeClass("context-menu-active");
                $(document).find(".k-nonwork-hour").removeClass("context-menu-active");
                $(document).find(".the-appointment").removeClass("context-menu-active");
                return {
                    callback: function (key, options) {
                        var scheduler = $("#scheduler").data("kendoScheduler");
                        var dataSource = scheduler.dataSource;
                        var uid = $(this).parent().attr("data-uid");
                        if (key == "serviceComplete") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            if(dataItem.checkoutclass=='checkout'){
                                alert("Already checkedout");
                                return false;
                            }
                            var start=dataItem.start;
                            var UnixTimeStamp = start.getUnixTime();
                            var Timezone = start.getTimezoneOffset()*60;  
                            var StartUnixTimeStamp=UnixTimeStamp+(-Timezone);
                            TodayDate=new Date();
                            TodayUnixTimeStamp = TodayDate.getUnixTime();
                            var Timezone = TodayDate.getTimezoneOffset()*60;  
                            var todayTimestamp=TodayUnixTimeStamp+(-Timezone);
                            if (StartUnixTimeStamp>todayTimestamp) {
                                alert("You can not checkout future date Appointment");
                                return false;
                            }
                            if(dataItem.typeclass=='front'){
                                $.ajax({
                                    url: "Appointments/chnge_front_book_status",
                                    method: "POST",
                                    async: false, 
                                    data: { id : eventId,
                                    },
                                }).done(function(response) {
                                    alert("Service completed Successfully");
                                    url = "/admin/appointments";
                                    $(location).attr("href", url);
                                    return false;
                                });
                            }else{
                                
                                checkout($appModal,eventId,'appointment',key,StartUnixTimeStamp);
                            }
                        }
                    },
                    items: {
                        "serviceComplete": {name: "Service Complete (Checkout)",icon: "blank"},
                    }
                };
            }
        });
        $.contextMenu({ 
            selector: '.the-appointment',
            trigger: 'left',
            build: function($trigger, e) {
                $('.context-menu-list').hide();
                $(document).find(".working-hour").removeClass("context-menu-active");
                $(document).find(".k-nonwork-hour").removeClass("context-menu-active");
                $(document).find(".the-appointment").removeClass("context-menu-active");
                return {
                    callback: function (key, options) {
                        var scheduler = $("#scheduler").data("kendoScheduler");
                        var dataSource = scheduler.dataSource;
                        var uid = $(this).parent().attr("data-uid");
                        if (key == "edit") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            onClickedit(eventId,'appointment');
                        } else if (key == "delete" || key == "serviceInprogress" || key == "show" || key == "noShow" || key == "deny" || key == "cancel") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            start_date=dataItem.start;
                            var UnixTimeStamp = start_date.getUnixTime();
                            var Timezone = start_date.getTimezoneOffset()*60;
                            Timezone=Timezone+dubai_timezone;
                            var start_date=UnixTimeStamp+(-Timezone);
                            change_appointment_status(eventId,start_date,'appointment',key);
                        }else if (key == "serviceComplete") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            if(dataItem.checkoutclass=='checkout'){
                                alert("Already checkedout");
                                return false;
                            }
                            if(dataItem.typeclass=='front'){
                                $.ajax({
                                    url: "Appointments/chnge_front_book_status",
                                    method: "POST",
                                    async: false, 
                                    data: { id : eventId,
                                    },
                                }).done(function(response) {
                                    alert("Service completed Successfully");
                                    url = "/admin/appointments";
                                    $(location).attr("href", url);
                                    return false;
                                });
                            }else{
                                var start=dataItem.start;
                                var UnixTimeStamp = start.getUnixTime();
                                var Timezone = start.getTimezoneOffset()*60;  
                                var StartUnixTimeStamp=UnixTimeStamp+(-Timezone);
                                TodayDate=new Date();
                                TodayUnixTimeStamp = TodayDate.getUnixTime();
                                var Timezone = TodayDate.getTimezoneOffset()*60;  
                                var todayTimestamp=TodayUnixTimeStamp+(-Timezone);
                                if (StartUnixTimeStamp>todayTimestamp) {
                                    alert("You can not checkout future date Appointment");
                                    return false;
                                }
                                checkout($appModal,eventId,'appointment',key,StartUnixTimeStamp);
                            }
                        }else if (key == "moveFwd") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            moveForward($appModal,selectState,eventId,key);
                        }else if (key == "moveBwd") {
                            var dataItem = dataSource.getByUid(uid);
                            var start=dataItem.start;
                            var UnixTimeStamp = start.getUnixTime();
                            var Timezone = start.getTimezoneOffset()*60;  
                            var StartUnixTimeStamp=UnixTimeStamp+(-Timezone);
                            TodayDate=new Date();
                            TodayUnixTimeStamp = TodayDate.getUnixTime();
                            var Timezone = TodayDate.getTimezoneOffset()*60;  
                            var todayTimestamp=TodayUnixTimeStamp+(-Timezone);
                            if (StartUnixTimeStamp<todayTimestamp) {
                                alert("You can not move past date Appointment");
                                return false;
                            }
                            eventId=dataItem.id;
                            moveForward($appModal,selectState,eventId,key);
                        }else if (key == "print") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            printTicket($appModal,selectState,eventId,key);
                        }
                    },
                    items: {
                        "edit"  : {name: "Edit",icon: "edit"},
                        "delete": {name: "Delete",icon: "delete"},
                        "print": {name: "Print Ticket",icon: "print"},
                        "deny": {name: "Deny",icon: "blank"},
                        "show": {name: "Show",icon: "blank"},
                        "noShow": {name: "No Show",icon: "blank"},
                        "serviceInprogress": {name: "Service In Progress",icon: "blank"},
                        "serviceComplete": {name: "Service Complete (Checkout)",icon: "blank"},
                        "cancel": {name: "Cancel",icon: "blank"},
                        "moveFwd": {name: "Move Forward",icon: "blank"},
                        "moveBwd": {name: "Move Back",icon: "blank"}
                    }
                };
            }
        });
        
        
        
        
        
        $.contextMenu({ 
            selector: '.the-multiple-appointment',
            trigger: 'left',
            build: function($trigger, e) {
                $('.context-menu-list').hide();
                $(document).find(".working-hour").removeClass("context-menu-active");
                $(document).find(".k-nonwork-hour").removeClass("context-menu-active");
                $(document).find(".the-appointment").removeClass("context-menu-active");
                $(document).find(".the-multiple-appointment").removeClass("context-menu-active");
                return {
                    callback: function (key, options) {
                        var scheduler = $("#scheduler").data("kendoScheduler");
                        var dataSource = scheduler.dataSource;
                        var uid = $(this).parent().attr("data-uid");
                        if (key == "edit") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            onClickMultiple(eventId,'multiple');
                        } else if (key == "delete" || key == "serviceInprogress" || key == "show" || key == "noShow" || key == "deny" || key == "cancel") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            change_appointment_status(eventId,'appointment',key);
                        }else if (key == "serviceComplete") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            checkout($appModal,eventId,'appointment',key);
                        }else if (key == "moveFwd") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            moveForward($appModal,selectState,eventId,key);
                        }else if (key == "moveBwd") {
                            var dataItem = dataSource.getByUid(uid);
                            var start=dataItem.start;
                            var UnixTimeStamp = start.getUnixTime();
                            var Timezone = start.getTimezoneOffset()*60;  
                            var StartUnixTimeStamp=UnixTimeStamp+(-Timezone);
                            TodayDate=new Date();
                            TodayUnixTimeStamp = TodayDate.getUnixTime();
                            var Timezone = TodayDate.getTimezoneOffset()*60;  
                            var todayTimestamp=TodayUnixTimeStamp+(-Timezone);
                            if (StartUnixTimeStamp<todayTimestamp) {
                                alert("You can not move past date Appointment");
                                return false;
                            }
                            eventId=dataItem.id;
                            moveForward($appModal,selectState,eventId,key);
                        }else if (key == "print") {
                            var dataItem = dataSource.getByUid(uid);
                            eventId=dataItem.id;
                            printTicket($appModal,selectState,eventId,key);
                        }
                    },
                    items: {
                        "edit"  : {name: "Edit",icon: "edit"},
                        "delete": {name: "Delete",icon: "delete"},
                        "print": {name: "Print Ticket",icon: "print"},
                        "deny": {name: "Deny",icon: "blank"},
                        "show": {name: "Show",icon: "blank"},
                        "noShow": {name: "No Show",icon: "blank"},
                        "serviceInprogress": {name: "Service In Progress",icon: "blank"},
                        "serviceComplete": {name: "Service Complete (Checkout)",icon: "blank"},
                        "cancel": {name: "Cancel",icon: "blank"},
                        "moveFwd": {name: "Move Forward",icon: "blank"},
                        "moveBwd": {name: "Move Back",icon: "blank"}
                    }
                };
            }
        });
        $.contextMenu({
            selector: '.the-personal',
            trigger: 'left',
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
                    eventId=dataItem.id;
                    change_appointment_status(eventId,'appointment',key);
                   }
            },
            items: {
                "edit"  : {name: "Edit",icon: "edit"},
                "delete": {name: "Delete",icon: "delete"},
            }
        });
        $.contextMenu({
            selector: '.the-waiting',
            trigger: 'left',
            callback: function (key, options) {
                var scheduler = $("#scheduler").data("kendoScheduler");
                var dataSource = scheduler.dataSource;
                var uid = $(this).parent().attr("data-uid");
                if (key == "edit") {
                    var dataItem = dataSource.getByUid(uid);
                    eventId=dataItem.id;
                    addWaitingTask($appModal,selectState,eventId);
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
            trigger: 'left',
            build: function($trigger, e) {
                var iid = $trigger.context.id;
                $('.context-menu-list').hide();
                $(document).find(".working-hour").removeClass("context-menu-active");
                $(document).find(".k-nonwork-hour").removeClass("context-menu-active");
                $(document).find(".the-appointment").removeClass("context-menu-active");
                return {
                    callback: function (key, options) {
                        var m = "clicked: " + key;
                        if (key == "add") {
                            press=confirm("This is non working hour, would you still wants to continue?");
                            if (press==false) {
                                return false;
                            }
                            var startDate=selectState.start;
                            var UnixTimeStamp = startDate.getUnixTime();
                            var timeStamp = Math.floor(Date.now() / 1000);
                            if (UnixTimeStamp<timeStamp) {
                                past=confirm("Would you like to add past appointment?");
                                if (past==false) {
                                    return false;
                                }
                            }
                            
                            var eventId = "";
                            addAppointment($appModal,selectState,eventId,'');
                        }
                        else if (key == "multiapp") {
                            var eventId = "";
                            addMultipleAppointments($appModal,selectState,eventId);
                        }
                        else if (key == "pTask") {
                            press=confirm("This is non working hour, would you still wants to continue?");
                            if (press==false) {
                                return false;
                            }
                            var startDate=selectState.start;
                            var UnixTimeStamp = startDate.getUnixTime();
                            var timeStamp = Math.floor(Date.now() / 1000);
                            if (UnixTimeStamp<timeStamp) {
                                past=confirm("Would you like to add past appointment?");
                                if (past==false) {
                                    return false;
                                }
                            }
                            var eventId = "";
                            open_hours='<?php echo strtotime($opening_hours); ?>'; 
                            close_hours='<?php echo strtotime($closing_hours); ?>'; 
                            addPersonalTask($appModal,selectState,eventId,open_hours,close_hours);
                        }else if (key == "waiting") {
                            press=confirm("This is non working hour, would you still wants to continue?");
                            if (press==false) {
                                return false;
                            }
                            var startDate=selectState.start;
                            var UnixTimeStamp = startDate.getUnixTime();
                            var timeStamp = Math.floor(Date.now() / 1000);
                            if (UnixTimeStamp<timeStamp) {
                                past=confirm("Would you like to add past appointment?");
                                if (past==false) {
                                    return false;
                                }
                            }
                            var eventId = "";
                            addWaitingTask($appModal,selectState,eventId);
                        }else if (key == "workHours") {
                            var startDate=selectState.start;
                            var UnixTimeStamp = startDate.getUnixTime();
                            var timeStamp = Math.floor(Date.now() / 1000);
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
                };
            }
        });
        $.contextMenu({
            selector: '.working-hour',
            trigger: 'left',
            build: function($trigger, e) {
                var iid = $trigger.context.id;
                $('.context-menu-list').hide();
                $(document).find(".working-hour").removeClass("context-menu-active");
                $(document).find(".the-appointment").removeClass("context-menu-active");
                return {
                    callback: function (key, options) {
                        var m = "clicked: " + key;
                        if (key == "add") {
                            var startDate=selectState.start;
                            var UnixTimeStamp = startDate.getUnixTime();
                            var timeStamp = Math.floor(Date.now() / 1000);
                            if (UnixTimeStamp<timeStamp) {
                                past=confirm("Would you like to add past appointment?");
                                if (past==false) {
                                    return false;
                                }
                            }
                            var eventId = "";
                            addAppointment($appModal,selectState,eventId,'');
                        }else if (key == "multiapp") {
                            var eventId = "";
                            addMultipleAppointments($appModal,selectState,eventId);
                        }else if (key == "pTask") {
                            var startDate=selectState.start;
                            var UnixTimeStamp = startDate.getUnixTime();
                            var timeStamp = Math.floor(Date.now() / 1000);
                            if (UnixTimeStamp<timeStamp) {
                                past=confirm("Would you like to add past appointment?");
                                if (past==false) {
                                    return false;
                                }
                            }
                            var eventId = "";
                            open_hours='<?php echo strtotime($opening_hours); ?>'; 
                            close_hours='<?php echo strtotime($closing_hours); ?>'; 
                            addPersonalTask($appModal,selectState,eventId,open_hours,close_hours);
                        }else if (key == "waiting") {
                            var startDate=selectState.start;
                            var UnixTimeStamp = startDate.getUnixTime();
                            var timeStamp = Math.floor(Date.now() / 1000);
                            if (UnixTimeStamp<timeStamp) {
                                past=confirm("Would you like to add past appointment?");
                                if (past==false) {
                                    return false;
                                }
                            }
                            var eventId = "";
                            addWaitingTask($appModal,selectState,eventId);
                        }else if (key == "workHours") {
                            var startDate=selectState.start;
                            var UnixTimeStamp = startDate.getUnixTime();
                            var timeStamp = Math.floor(Date.now() / 1000);
                            if (UnixTimeStamp<timeStamp) {
                                past=confirm("Would you like to add past appointment?");
                                if (past==false) {
                                    return false;
                                }
                            }
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
                };
            }
        });
        $.contextMenu({
            selector: '.month-working-hour',
            trigger: 'left',
            build: function($trigger, e) {
               var iid = $trigger.context.id;
                $('.context-menu-list').hide();
                $(document).find(".month-working-hour").removeClass("context-menu-active");
                return {
                    callback: function (key, options) {
                        var m = "clicked: " + key;
                        if (key == "add") {
                            var eventId = "";
                            addAppointment($appModal,selectState,eventId,'');
                        }else if (key == "pTask") {
                            var eventId = "";
                            addPersonalTask($appModal,selectState,eventId);
                        }else if (key == "waiting") {
                            var eventId = "";
                            addWaitingTask($appModal,selectState,eventId);
                        }else if (key == "workHours") {
                            var eventId = "";
                            editWorkingHours($appModal,selectState,eventId);
                        }
                    },
                    items: {
                        "add": {name: "New Appointment",icon: "calender"},
                        "waiting": {name: "Add to Waiting List",icon: "clock"},
                        "pTask": {name: "Personal Task",icon: "ban"},
                        "workHours": {name: "Edit Working Hours",icon: "pencil"}
                    }
                };
            }
        });
        $('.k-i-calendar').remove();
        var current_duration = $('.k-nav-current a').html();
        $(document).find('.k-scheduler-navigation .k-nav-current').remove();
        $( "ul.k-scheduler-navigation" ).after('<h2 style="float: left; font-size: 15px; font-weight: bold; margin: 6px 10px; padding: 0 10px;">'+current_duration+' </h2>');
    });
    $('#scheduler').bind('click',function(e){
        e.preventDefault();
    })
</script>
    