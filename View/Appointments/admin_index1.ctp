<link href="/css/kendo/kendo.common.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.rtl.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.default.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.dataviz.min.css" rel="stylesheet">
<link href="/css/kendo/kendo.dataviz.default.min.css" rel="stylesheet">

<script src="http://cdn.kendostatic.com/2013.2.716/js/kendo.all.min.js"></script>

  <div id="scheduler"></div>
 <!-- CUSTOM EDITOR TEMPLATE -->
  <script type="text/x-kendo-template" id="schedulerTemplate">
    Provider: Surjit
    <br>
    <select name="services">
        <option selected="selected" value="">Select a Service</option>
        <option value="21">Gold Facial</option>
        <option value="20">Diamond Facial</option>
    </select> 
    <br>
    Start Date: <input name="start" type="text" required  data-type="date" data-role="datetimepicker" data-bind="value: start,invisible: isAllDay" />
    <input name="start" type="text" required  data-type="date" data-role="datepicker" data-bind="value: start,visible: isAllDay" />   
    <br />
    
    End Date: <input name="end" type="text" required data-type="date" data-role="datetimepicker" data-bind="value: end ,invisible:isAllDay" />    
    <input name="end" type="text" required data-type="date" data-role="datepicker" data-bind="value: end ,visible:isAllDay" />
    <br />
    
    <!--input type="checkbox" name="isAllDay" data-type="boolean" data-bind="checked:isAllDay"-->
    Duration: <input type="text" name="duration" data-type="decimal" data-bind="value: duration">
    <br />
    
    Price: <input type="text" name="price" data-type="decimal" data-bind="value: price">
    <br />
    
    <div id="resourcesContainer">
        Generated resouces editors for each resource: <br />
    </div>
    <script>
       jQuery(function() {
            var container = jQuery("\#resourcesContainer");
            var resources = jQuery("\#scheduler").data("kendoScheduler").resources;
            
            for( resource = 0; resource<resources.length; resource++) 
            { 
                if(resources[resource].multiple)
                {
                   jQuery(kendo.format('<select data-bind="value: {0}" name="{0}" style="width:200px;">', resources[resource].field))
                     .appendTo(container)
                     .kendoMultiSelect({
                         dataTextField: resources[resource].dataTextField,
                         dataValueField: resources[resource].dataValueField,
                         dataSource: resources[resource].dataSource,
                         valuePrimitive: resources[resource].valuePrimitive,
                         itemTemplate: kendo.format('<span class="k-scheduler-mark" style="background-color:\#= data.{0}?{0}:"none" \#"></span>\#={1}\#', resources[resource].dataColorField, resources[resource].dataTextField),
                         tagTemplate: kendo.format('<span class="k-scheduler-mark" style="background-color:\#= data.{0}?{0}:"none" \#"></span>\#={1}\#', resources[resource].dataColorField, resources[resource].dataTextField)
                     });
            
                } else {
                   jQuery(kendo.format('<select data-bind="value: {0}" name="{0}" style="width:200px;">', resources[resource].field))
                    .appendTo(container)
                    .kendoDropDownList({
                        dataTextField: resources[resource].dataTextField,
                        dataValueField: resources[resource].dataValueField,
                        dataSource: resources[resource].dataSource,
                        valuePrimitive: resources[resource].valuePrimitive,
                        optionLabel: "None",
                        template: kendo.format('<span class="k-scheduler-mark" style="background-color:\#= data.{0}?{0}:"none" \#"></span>\#={1}\#', resources[resource].dataColorField, resources[resource].dataTextField)
                     }); 
                }
            }     
        })        

   <\/script>
  </script>
    
    <script>
    $(function () {
        $("#scheduler").kendoScheduler({
            date: new Date("2015/01/15"),
            startTime: new Date("2015/01/15 07:00 AM"),
            height: 600,
            views: [
                "day", {
                    type: "week",
                    selected: true
                },
                "month",
                "agenda"
            ],
            timezone: "Etc/UTC",
            editable: {
                template: kendo.template($("#schedulerTemplate").html())
            },
            resources: /*[
                {
                  field: "attendees",
                  dataSource: [
                   { value: 1, text: "Alex" },
                   { value: 2, text: "Bob" }
                  ],
                  multiple: true
                }
            ]*/
                
            [
            {
                field: "userId",
                title: "User",
                dataTextField: "displayName",
                dataValueField: "userId",
                dataSource: userDataSource
            }/*,
            {
                field: "scheduledTaskId",
                title: "Task",
                dataTextField: "taskName",
                dataValueField: "scheduledTaskId",
                dataSource: taskDataSource
            }*/],       
            dataSource: {
                batch: true,
                transport: {
                    read: function(options) {
                        $.ajax( {
                            url: "/admin/Appointments/read",
                            dataType: "json",
                            success: function(result) {
                                options.success(result);
                            }
                        });
                    },
                    update: function(options) {
                       
                        $.ajax( {
                            url: "/admin/Appointments/update",
                            dataType: "json",
                            type: "POST",
                            data: kendo.stringify(options.data),
                            success: function(result) { 
                              // notify the data source that the request succeeded
                              options.success(result);
                            },
                            error: function(result) {alert(kendo.stringify(result))
                              // notify the data source that the request failed
                              options.error(result);
                            }
                        });
                    },
                    create: {
                        url: "http://demos.telerik.com/kendo-ui/service/tasks/create",
                        dataType: "jsonp"
                    },
                    destroy: {
                        url: "http://demos.telerik.com/kendo-ui/service/tasks/destroy",
                        dataType: "jsonp"
                    },
                    parameterMap: function(options, operation) {
                        if (operation !== "read" && options.models) {
                          //return {models: kendo.stringify(options.models)};
                          return Json(ModelState.IsValid ? new object(): ModelState.ToDataSourceResult());
                        }
                    }
                },
                schema: {
                    model: {
                        id: "taskId",
                        fields: {
                            taskId: {
                                from: "TaskID",
                                type: "number"
                            },
                            title: {
                                from: "Title",
                                defaultValue: "No title",
                                validation: {
                                    required: true
                                }
                            },
                            start: {
                                type: "date",
                                from: "Start"
                            },
                            end: {
                                type: "date",
                                from: "End"
                            },
                            startTimezone: {
                                from: "StartTimezone"
                            },
                            endTimezone: {
                                from: "EndTimezone"
                            },
                            description: {
                                from: "Description"
                            },
                            duration: {
                                from: "Duration"
                            },
                            price: {
                                from: "Price"
                            },
                            recurrenceId: {
                                from: "RecurrenceID"
                            },
                            recurrenceRule: {
                                from: "RecurrenceRule"
                            },
                            recurrenceException: {
                                from: "RecurrenceException"
                            },
                            userId: {
                                from: "userId",
                                defaultValue: 1
                            },
                            isAllDay: {
                                type: "boolean",
                                from: "IsAllDay"
                            }
                        }
                    }
                },
                filter: {
                    logic: "or",
                    filters: [{
                        field: "ownerId",
                        operator: "eq",
                        value: 1
                    }, {
                        field: "ownerId",
                        operator: "eq",
                        value: 2
                    }]
                }
            },
            edit: function (e) {
            }
            
        });
        
        var userDataSource = new kendo.data.DataSource({
            transport: {
                read: {
                    //This should be a customized list of users, or all users fetched from the datastore
                    url: "/admin/Appointments/resources",
                    dataType: "json"
                }
            },
            requestEnd: function(e) {
                //Start Fetching Task Data Source
                //taskDataSource.fetch();
            },
            schema: {
                model: {
                    id: "userId",
                    fields: {
                        userId: {
                            from: "UserId",
                            type: "number"
                        },
                        displayName: {
                            from: "DisplayName"
                        }
                    }
                }
            }
        });
        //userDataSource.fetch();
        /*var taskDataSource = new kendo.data.DataSource({

            transport: {
                read: {
                    //This should be the entire list of tasks fetched from the datastore
                    //url: "ServiceURI/ScheduledTask/Get?companyId=1",
                    //dataType: "json"
                }
            },
            requestEnd: function(e) {
                //Once Task and User DataSource have been fetched, create the Scheduler
                //createScheduler(e);
            },
            schema: {
                model: {
                    id: "scheduledTaskId",
                    fields: {
                        scheduledTaskId: {
                            from: "ScheduledTaskId",
                            type: "number"
                        },
                        taskName: {
                            from: "TaskName"
                        }
                    }
                }
            }
        
        });*/
        
    
        $("#people :checkbox").change(function (e) {
            var checked = $.map($("#people :checked"), function (checkbox) {
                return parseInt($(checkbox).val());
            });
    
            var filter = {
                logic: "or",
                filters: $.map(checked, function (value) {
                    return {
                        operator: "eq",
                        field: "ownerId",
                        value: value
                    };
                })
            };
    
            var scheduler = $("#scheduler").data("kendoScheduler");
    
            scheduler.dataSource.filter(filter);
        });
    });
    
  </script>