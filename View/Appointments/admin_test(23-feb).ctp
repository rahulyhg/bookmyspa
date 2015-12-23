    <link href="/css/kendo/kendo.common.min.css" rel="stylesheet">
    <link href="/css/kendo/kendo.rtl.min.css" rel="stylesheet">
    <link href="/css/kendo/kendo.default.min.css" rel="stylesheet">
    <link href="/css/kendo/kendo.dataviz.min.css" rel="stylesheet">
    <link href="/css/kendo/kendo.dataviz.default.min.css" rel="stylesheet">
    <!--script src="/js/jquery.min.js"></script-->
    <!--<script src="/js/angular.min.js"></script>-->
    <script src="/js/kendo/kendo.all.min.js"></script>
    <script src="/js/kendo/console.js"></script>
    <!--<script src="/js/kendo/kendo.timezones.js"></script>
    <script src="/js/kendo/console.js"></script>-->
    <noscript src="http://medialize.github.io/jQuery-contextMenu/src/jquery.ui.position.js" type="text/javascript"></noscript>
<noscript src="https://raw.githubusercontent.com/VanFanelia/jQuery-contextMenu/970012afbc01dedae7f939e572a2798a93337351/src/jquery.contextMenu.js" type="text/javascript"></noscript>

<link href="http://medialize.github.io/jQuery-contextMenu/src/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
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
    <div id="scheduler"></div>
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
        function scheduler_change(e) {
            var start = e.start; //selection start date
            var end = e.end; //selection end date
            var slots = e.slots; //list of selected slots
            var events = e.events; //list of selected Scheduler events
            var message = "change:: selection from {0:g} till {1:g}";
            if (events.length) {
                message += ". The selected event is '" + events[events.length - 1].title + "'";
            }
            kendoConsole.log(start);
        }
        
        function schedulerNavigate(e) {
            alert("Nav");
        }
        
    </script>
    <ul class ="k-column-menu" id="contextmenu" style=" display:none; position: absolute; background-color:white;           border-style:solid; border-width:1px;" >
        <li onclick="scheduler_change();">Add Appointment</li>
        <li>Menu1</li>
        <li>Menu2</li>
    </ul>
    
    <noscript>
        $(document).ready(function () {
        $(document).bind('contextmenu', function (event){
            $("#contextmenu").css({ "top": (event.pageY-60) + "px", "left": event.pageX + "px" }).kendoMenu({orientation: "vertical"}).show();
                event.preventDefault();
            });
            $('html').click(function() {
                $("#contextmenu").hide();
            });
        });
    </noscript>
    
    <ul id="context-menu">
    <li>Item 1</li>
    <li>Item 2</li>
</ul>
<noscript>
    $("#context-menu").kendoContextMenu({
        animation: {
            open: { effects: "fadeIn" },
            duration: 500
        },
        showOn: "click"
    });
</noscript>
    
    
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
    var scheduler = $("#scheduler").kendoScheduler({
        date: new Date("2015/2/13"),
        //startTime: new Date("2015/2/13 08:00 AM"),
        //endTime: new Date("2015/2/20 2:00 PM"),
        views: [
            "day",
            { type: "week", selected: true },
            "month"
        ],
        group: {
            resources: ["Employee"]
        },
        //selectable: true,
        selectable: true,
        change: function(e) {
          
        selectState = e;
      },
      //  change: scheduler_change,
        //navigate: schedulerNavigate,
        
         /*change: function(e) {
            selectState = e;
          },*/
        eventTemplate: $("#appointment-template").html(),
        
        dataBound: function (e) {
            var scheduler = this;
            var view = scheduler.view();
         
            view.table.find("td[role=gridcell]").each(function () {
                var element = $(this);
                var slot = scheduler.slotByElement(element);
                //your custom logic based on the slot object
                if (true) {
                    element.addClass("working-hour");
                    element.attr("data-start_end",slot.startDate+','+slot.endDate);
                }
                //based on above logic if needed add custom CSS class to the unavailable slots
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


/*$("#contextMenu").kendoContextMenu({
             
            filter: ".k-event, .k-scheduler-table",
            showOn: "click",
            select: function() {
                
              if (selectState.events.length) {
                scheduler.editEvent(selectState.events[0]);
              } else {
                scheduler.addEvent({
                  start: selectState.start,
                  end: selectState.end
                });
              }
            },
            open: function(e) {
              var menu = e.sender;
              var text = $(e.target).hasClass("k-event") ? "Edit event" : "Add Event";
            $("#contextmenu").hide();
              menu.remove(".myClass");
              menu.append([{text: text, cssClass: "myClass" }]);
            }
        });

*/

       /* scheduler.on("click", "td.k-nonwork-hour", function(e) {
            var parentOffset = $(this).parent().offset(); 
            var relX = e.pageX - parentOffset.left;
            var relY = e.pageY - parentOffset.top;
            alert("Non working day!");
            console.log(e);
            var start = e.start; //selection start date
            var end = e.end; //selection end date
            var slots = e.slots; //list of selected slots
            var events = e.events; //list of selected Scheduler events
            var message = "change:: selection from {0:g} till {1:g}";
            if (e.length) {
                message += ". The selected event is '" + e[e.length - 1].title + "'";
            }
        }); */
    });
</script>
    <script>
      
       
     $("#contextMenu").kendoContextMenu({
        filter: ".k-event, .k-scheduler-table",
        showOn: "click",
        select: function() {
          if (selectState.events.length) {
            scheduler.editEvent(selectState.events[0]);
          } else {
            scheduler.addEvent({
              start: selectState.start,
              end: selectState.end
            });
          }
        },
        open: function(e) {
          var menu = e.sender;
          var text = $(e.target).hasClass("k-event") ? "Edit event" : "Add Event";

          menu.remove(".myClass");
          menu.append([{text: text, cssClass: "myClass" }]);
        }
    });
      
      
      
        
/*$.contextMenu({
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
        }else if (key == "add") {
            var dataItem = dataSource.getByUid(uid);
            scheduler.addEvent(dataItem);
        }
    },
    items: {
        "add": {
            name: "Add",
            icon: "add"
        },
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
        //console.log(event);
        
        var scheduler = $("#scheduler").data("kendoScheduler");
        var dataSource = scheduler.dataSource;
        var uid = $(this).attr("data-uid");
        //console.log(options); 
        var AddConfirm = confirm("You are trying to add nonworking hours Appointment!");
        if (AddConfirm == false) {
            return false;
        } 
        if (key == "add") {
            
            //scheduler.bind("add", scheduler_add);
            
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


$.contextMenu({
    selector: '.working-hour',
    trigger: 'leftright',
    callback: function (key, options) {
        console.log(options);
         var scheduler = $("#scheduler").data("kendoScheduler");
        var dataSource = scheduler.dataSource;
        
       // var scheduler = $("#scheduler").data("kendoScheduler");
//scheduler.bind("add", scheduler_add);
       // console.log(dataSource);
        var uid = $(this).attr("data-uid");
        if (key == "add") {
            var dataItem = dataSource.getByUid(uid);
            scheduler.addEvent(dataItem);
            //var scheduler = $("#scheduler").data("kendoScheduler");
            //scheduler.bind("add", scheduler_add);

        }
    },
    items: {
        "add": {
            name: "Add",
            icon: "add"
           
        }
    }
});
/*$(document).on("click", "li .icon-add", function (e) {
          alert("test");
      });*/
 /*var scheduler = $("#scheduler").kendoScheduler();
                    
          	scheduler.wrapper.on("mousedown", "li.icon-add", function(e) {
              var slot = scheduler.slotByElement(e.currentTarget);
              debugger;
              scheduler.addEvent({
                start: slot.startDate,
                end: slot.endDate
              })
            });
*/

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

</style>
