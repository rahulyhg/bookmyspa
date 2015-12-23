<div id="scheduler">
    
</div>
<?php if(isset($data)){
    pr($data);
    }else{
    $data = '[
                    { text: "Meeting Room 101", value: 1, color: "#6eb3fa" },
                    { text: "Meeting Room 201", value: 2, color: "#6eb3fa" }
                ]';
    }
    $updt = '[{"MeetingID":2,"RoomID":1,"Attendees":[2],"Title":"Meeting with customers.","Description":"","StartTimezone":null,"Start":"Date(1370865600000)","End":"Date(1370872800000)","EndTimezone":null,"RecurrenceRule":null,"RecurrenceID":null,"RecurrenceException":null,"IsAllDay":false}]';
    //$updt = '';
    ?>

<script>
$(function() {
    $("#scheduler").kendoScheduler({
        date: new Date("2013/6/13"),
        startTime: new Date("2013/6/13 07:00 AM"),
        height: 600,
        selectable: true,
        change: function (e) {
            $('#displayEvent').text('Change called');
                console.log(e.resources.roomId);
            var start = e.start; //selection start date
            var end = e.end; //selection end date
            var slots = e.slots; //list of selected slots
            var events = e.events; //list of selected Scheduler events
            console.log(e.slots);
            var message = "change:: selection from {0:g} till {1:g}";
    
            if (events.length) {
                message += ". The selected event is '" + events[events.length - 1].title + "'";
            }
            $('#displayEvent').text(message);
        },
        views: [
            "day",
            { type: "week", selected: true },
            "month",
            "timeline"
        ],
        timezone: "Etc/UTC",
        dataSource: {
            batch: true,
            transport: {
                read: {
                    url: "<?php echo $updt;?>",
                    dataType: "jsonp"
                },
                update: {
                    url: "http://demos.telerik.com/kendo-ui/service/meetings/update",
                    dataType: "jsonp"
                },
                create: {
                    url: "http://demos.telerik.com/kendo-ui/service/meetings/create",
                    dataType: "jsonp"
                },
                destroy: {
                    url: "http://demos.telerik.com/kendo-ui/service/meetings/destroy",
                    dataType: "jsonp"
                }
              
            },
            schema: {
                model: {
                    id: "meetingID",
                    fields: {
                        meetingID: { from: "MeetingID", type: "number" },
                        title: { from: "Title", defaultValue: "No title", validation: { required: true } },
                        start: { type: "date", from: "Start" },
                        end: { type: "date", from: "End" },
                        startTimezone: { from: "StartTimezone" },
                        endTimezone: { from: "EndTimezone" },
                        description: { from: "Description" },
                        recurrenceId: { from: "RecurrenceID" },
                        recurrenceRule: { from: "RecurrenceRule" },
                        recurrenceException: { from: "RecurrenceException" },
                        roomId: { from: "RoomID", nullable: true },
                        attendees: { from: "Attendees", nullable: true },
                        isAllDay: { type: "boolean", from: "IsAllDay" }
                    }
                }
            }
        },
        group: {
            resources: ["Rooms"]
        },
        resources: [
            {
                field: "roomId",
                name: "Rooms",
                dataSource: <?php echo $data; ?>,
                title: "Room"
            },
            {
                field: "attendees",
                name: "Attendees",
                dataSource: [
                    { text: "Alex", value: 1, color: "#f8a398" },
                    { text: "Bob", value: 2, color: "#51a0ed" },
                    { text: "Charlie", value: 3, color: "#56ca85" }
                ],
                multiple: true,
                title: "Attendees"
            }
        ]
    });
});
</script>