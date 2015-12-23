<link href="/css/kendo/kendo.common.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.rtl.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.default.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.dataviz.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.dataviz.default.min.css" rel="stylesheet">
<!--script src="/js/jquery.min.js"></script-->
<!--<script src="/js/angular.min.js"></script>-->
<script src="/js/kendo/kendo.all.min.js"></script>
<script src="/js/kendo/console.js"></script>
<script src="/js/kendo/kendo.timezones.js"></script>
<script src="/js/contextmenu/jquery.ui.position.js" type="text/javascript"></script>
<!--<script src="/js/kendo/console.js"></script>-->
<script src="/js/contextmenu/jquery.ui.position.js" type="text/javascript"></script>
<script src="/js/contextmenu/jquery.contextMenu.js" type="text/javascript"></script>
<link href="/css/contextmenu/jquery.contextMenu.css" rel="stylesheet" type="text/css" />

<link href="/css/timepicker/jquery.timepicker.css" rel="stylesheet">
<script src="/js/timepicker/jquery.timepicker.js"></script>
<script src="http://momentjs.com/downloads/moment.js"></script>
<script src="https://rniemeyer.github.io/knockout-kendo/js/knockout-3.2.0.js"></script>





   



<?php echo $employee; ?>
<br>
    
<?php //echo $appointments; ?>   
<br>
<?php echo $treatments; ?>
<?php //pr($openingHours); ?>
<?php
$openHour = array('openHours'=>array(
                '0'=>
                    array(
                        '0'=>array('sTime'=>'08:00 AM','eTime'=>'08:00 PM'),
                        '1'=>array('sTime'=>'08:00 AM','eTime'=>'05:00 PM'),
                        '3'=>array('sTime'=>'08:00 AM','eTime'=>'03:00 PM'),
                        '5'=>array('sTime'=>'08:00 AM','eTime'=>'01:00 PM'),
                        '6'=>array('sTime'=>'08:00 AM','eTime'=>'07:00 PM')
                    ),
                '1'=>
                    array(
                        '0'=>array('sTime'=>'08:00 AM','eTime'=>'08:00 PM'),
                        '1'=>array('sTime'=>'08:00 AM','eTime'=>'12:00 PM'),
                        '3'=>array('sTime'=>'08:00 AM','eTime'=>'08:00 PM'),
                        '5'=>array('sTime'=>'08:00 AM','eTime'=>'08:00 PM'),
                    ),
                    )
                );
                $openHourJSON = json_encode($openHour);
                pr($openHourJSON);
    ?>
    <div id="team-schedule">
        <div id="people">
            <input checked type="checkbox" id="Facial" value="1">
            <label for="Facial">&nbsp;</label>
            <input checked type="checkbox" id="Massage" value="2">
            <label for="Massage">&nbsp;</label>
            <input checked type="checkbox" id="Beat" value="3">
            <label for="Beat">&nbsp;</label>
        </div>
    </div>
    
    <div id="scheduler" data-bind="kendoScheduler: startDate"></div>
    <ul id="contextMenu"></ul>
    <div class="box">
        <h4>Console log</h4>
        <div class="console"></div>
    </div>
    <script id="appointment-template" type="text/x-kendo-template">
        <div class="appointment-template-box #: styleclass #" style="border-left:10px solid black;">
            <p>#: title #</p>
            <p>#: description #</p>
        </div>
    </script>
    <script>
    function calendar_onChange(e)
     {
        $.ajax({
            url: "",
            type: "post",
            data: e.sender,
            success: function(){
                alert("success");
                //$("#schduler").html('Submitted successfully');
            }
        });
    }
    </script>
    <script>
    Date.prototype.getUnixTime = function() { return this.getTime()/1000|0 };
        if(!Date.now) Date.now = function() { return new Date(); }
        Date.time = function() { return Date.now().getUnixTime(); }
    </script>
    <script>
    $(function() {
        $("#people :checkbox").change(function(e) {
            var checked = $.map($("#people :checked"), function(checkbox) {
                return parseInt($(checkbox).val());
            });
            var scheduler = $("#scheduler").data("kendoScheduler");
            scheduler.dataSource.filter({
            operator: function(task) {
                return $.inArray(task.treatmentId, checked) >= 0;
            }
        });
    });
    var selectState = null;
    kendo.culture().calendar.firstDay = 3;
    var scheduler = $("#scheduler").kendoScheduler({
        date: new Date("2015/2/05 07:00 AM"),
        startTime: new Date("2015/2/05 07:00 AM"),
        endTime: new Date("2015/2/20 08:00 PM"),
        minorTickCount: 1,
        views: [
            "day",
            { type: "week", selected: true, majorTick: 10},
            "month"
        ],
        group: {
            resources: ["Employee"]
        },
        timezone: "UTC",
        footer: false,
        currentTimeMarker: {
            useLocalTimezone: true
        },
        //selectable: true,
        selectable: true,
        change: function(e) {
        selectState = e;
        //console.log(e);
      },
      //change: scheduler_change,
      //navigate: schedulerNavigate,
      /*change: function(e) {
            selectState = e;
        },*/
        eventTemplate: $("#appointment-template").html(),
        dataBound: function (e) {
            var scheduler = this;
            var view = scheduler.view();
            
            view.table.find("td[role=gridcell]").each(function () {
               //console.log(e);
                var element = $(this);
                var slot = scheduler.slotByElement(element);
                var record='<?php echo $openHourJSON; ?>';
                var opening_hours = jQuery.parseJSON(record);
                //console.log(slot.endDate);
                //console.log(slot.groupIndex);
                var start=slot.startDate;
                var unix_timestamp = Math.round(start.getTime() / 1000);
                var date = new Date(unix_timestamp*1000);
                var hours = date.getHours();
                var day = date.getDay();
                var minutes = "0" + date.getMinutes();
                var seconds = "0" + date.getSeconds();
                var gpIndex = slot.groupIndex;
                var dNow = new Date();
                var localdate= dNow.getFullYear() + '/' +(dNow.getMonth()+1) + '/' + dNow.getDate();
               // var unixformattedTime = Date.parse(formattedTime).getTime()/1000
               // var unixformattedTime = Math.round(formattedTime).getTime() / 1000;
                
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
                
                if (element.hasClass('k-today')) {
                    element.css('border-top','2px solid red');
                }
                /*if (true) {
                    element.addClass("working-hour");
                    element.attr("data-start_end",slot.startDate+','+slot.endDate);
                }*/
            })
        },
        dataSource: {
            dataColorField: "color",
            data:[{
                id: 1,
                start: new Date("2015/2/13 08:00 AM"),
                end: new Date("2015/2/13 09:00 AM"),
                title: "Interview",
                description:"kjashjkasdjkasd",
                styleclass :"app-complete",
                employeeId: 1,
                treatmentId:2
            },
            {
                id: 2,
                start: new Date("2015/2/14 10:00 AM"),
                end: new Date("2015/2/14 11:00 AM"),
                title: "Meeting",
                description:"sdaf32sadfsadf22121",
                styleclass :"app-complete",
                employeeId: 2 ,
                treatmentId:1
            },
            {
                id: 3,
                start: new Date("2015/2/15 11:00 AM"),
                end: new Date("2015/2/15 12:00 PM"),
                title: "Hello",
                description:"1234123123213",
                styleclass :"app-complete",
                employeeId: 1,
                treatmentId:3
            }],
            filter: {
                logic: "or",
                filters: [
                    { field: "treatmentId", operator: "eq", value: 1 },
                    { field: "treatmentId", operator: "eq", value: 2 },
                    { field: "treatmentId", operator: "eq", value: 3 }
                ]
            }
        },
        resources: [
            {
                field: "treatmentId",
                name: "Treatment",
                dataColorField: "color",
                dataSource: [
                      { text: "Facial", value: 1, color: "red" },
                      { text: "Massage", value: 2, color: "blue" },
                      { text: "Test", value: 1, color: "#aabbcc" }
                ]
            },
            {
                field: "employeeId",
                name: "Employee",
                dataColorField: "key",
                dataSource: [
                      { text: "Aman Gupta", value: 1 },
                      { text: "Shibu Kumar", value: 2 }
                ]
            },
        ]
    }).data("kendoScheduler");
    $("#calendar").kendoCalendar({
                    change: calendar_onChange,
                    //navigate: onNavigate
                });
    
    $.contextMenu({
        selector: '.k-event',
        trigger: 'leftright',
        callback: function (key, options) {
        var scheduler = $("#scheduler").data("kendoScheduler");
        var dataSource = scheduler.dataSource;
        var uid = $(this).attr("data-uid");
        if (key == "edit") {
            var dataItem = dataSource.getByUid(uid);
            scheduler.editEvent(dataItem);
        } else if (key == "delete") {
            var dataItem = dataSource.getByUid(uid);
            scheduler.removeEvent(dataItem);
        }
    },
    items: {
        "edit": {
            name: "Edit",
            icon: "edit"
        },
        "delete": {
            name: "Delete",
            icon: "delete"
        }
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
            var dataItem = dataSource.getByUid(uid);
            scheduler.addEvent(dataItem);
        }
    },
    items: {
        "add": {
            name: "Add",
            icon: "add"
        }
    }
   
    });
    
    var $modal = $('#commonContainerModal');
     $.contextMenu({
        selector: '.working-hour',
        trigger: 'leftright',
        callback: function (key, options) {
        if (key == "add") {
            Date.prototype.getUnixTime = function() { return this.getTime()/1000|0 };
            if(!Date.now) Date.now = function() { return new Date(); }
            Date.time = function() { return Date.now().getUnixTime(); }
            var employeeId = selectState.resources.employeeId;
            startDate=selectState.start;
            var startDate = startDate.getUnixTime();
                var addUserURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addAppointment','admin'=>true)); ?>";
                addUserURL  = addUserURL +'/'+startDate+'/'+employeeId; 
                fetchModal($modal,addUserURL);
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
    
    $modal.on('click', '.submitAppointment', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($modal,'Appointment',res)){
                         
                    }
                }
            }; 
            $('#AppointmentAdminAddUserForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
    
});
</script>
    


<style scoped>

.k-nav-current > .k-link span + span {
    max-width: 200px;
    display: inline-block;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    vertical-align: top;
}

#team-schedule {
    background: url('/img/kendo/team-schedule.png') transparent no-repeat;
    height: 115px;
    position: relative;
}

#people {
    background: url('/img/kendo/scheduler-people.png') no-repeat;
    width: 345px;
    height: 115px;
    position: absolute;
    right: 0;
}
#alex {
    position: absolute;
    left: 4px;
    top: 81px;
}
#bob {
    position: absolute;
    left: 119px;
    top: 81px;
}
#charlie {
    position: absolute;
    left: 234px;
    top: 81px;
}
.k-middle-row tr {
    border-bottom-style: none;
}


.formlayout1 .col1 {
padding-right: 1%;
width: 29%;
float: left;
font-weight: bold;
text-align: right;
}

.NewDesignChange .bookAppfont .popupInputLeftSide dd {
margin-bottom: 3px!important;
}
.formlayout1 dd {
position: relative;
line-height: 18px;
}

.customerimgBox {
float: left;
border-radius: 4px 4px 4px 4px;
height: 110px;
margin-bottom: 15px;
margin-right: 15px;
width: 102px!important;
float: none!important;
text-align: center;
display: table-cell;
vertical-align: middle;
width: 102px !important;
}
.NewDesignChange .bookAppfont .popupInputLeftSide dd {
margin-bottom: 3px!important;
}
.button-type-flatsmall, .orangeButtonPlain {
color: #FFFFFF!important;
background: #F15F24!important;
}
.formlayout1 dd {
position: relative;
line-height: 18px;
}

.popupInputLeftSide dd {
float: left;
margin-bottom: 8px;
width: 100%;
}


</style>
