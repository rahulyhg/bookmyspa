<script src="/js/kendo/console.js"></script>
<script src="/js/kendo/kendo.timezones.js"></script>
<script src="/js/contextmenu/jquery.ui.position.js" type="text/javascript"></script>
<script src="/js/contextmenu/jquery.contextMenu.js" type="text/javascript"></script>
<link href="/css/contextmenu/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<?php echo $this->Html->script('admin/bootstrap-dialog.js'); ?>
<?php echo $this->Html->css('admin/bootstrap-dialog.css'); ?>
<link href="/css/timepicker/jquery.timepicker.css" rel="stylesheet">
<script src="/js/timepicker/jquery.timepicker.js"></script>

<?php
echo $this->Html->css('admin/plugins/tagsinput/jquery.tagsinput.css');
echo $this->Html->script('admin/plugins/tagsinput/jquery.tagsinput.min.js');
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');
echo $this->Html->script('admin/jquery.geocomplete.js'); ?>
<!-- gmap -->
<?php echo $this->Html->css('admin/plugins/gmap/gmap3-menu'); ?>
<!-- gmap -->
<?php
echo $this->Html->script('admin/plugins/gmap/gmap3.min.js');
echo $this->Html->script('admin/plugins/gmap/gmap3-menu.js');
?>
<script>
    var $appModal = $(document).find('#commonMediumModal');
    var $forwardModal = $(document).find('#commonSmallModal');
    var $multiModal = $(document).find('#commonMediumModal');
    var $historyModal = $(document).find('#commonContainerModal');
   
</script>

<div id="data-scheduled" class="k-content">
    <?php echo $this->element('admin/Appointment/schedular'); ?>
</div>

<script>
    function onSelectChange(userId){
        //alert("test");
        if (userId=='') {
            userId='null';
        }
        
    var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'manage')); ?>";
        var page='appointment';
        userDetailURL = userDetailURL+'/'+userId+'/'+page;
        $appModal.find("#customer-detail").load(userDetailURL, function() {
            $appModal.find("#AppointmentUserId").select2().on("change", function(e) {
                onSelectChange(e.val);
            });
        });    
    }
    function onSelectSearchChange(userId){
        //alert("test");
        if (userId=='') {
            userId='null';
        }
        
    var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Users','action'=>'manage')); ?>";
        var page='SearchAppointment';
        userDetailURL = userDetailURL+'/'+userId+'/'+page;
        $forwardModal.find("#customer-detail").load(userDetailURL, function() {
            $appModal.find("#AppointmentUserId").select2().on("change", function(e) {
                onSelectSearchChange(e.val);
            });
        });    
    }
    function onServiceChange(serviceId){
        var staffId = $("#AppointmentSalonServiceId").attr('data-user-id');
        var serviceDetailURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'admin_fetch_price_and_duration')); ?>";
        serviceDetailURL = serviceDetailURL+'/'+serviceId+'/'+staffId;
        $appModal.find("#PriceDurationId").load(serviceDetailURL, function() {
            $appModal.find("#AppointmentSalonServiceId").on("change", function() {
                //onServiceChange(serviceId);
            });
        });    
    }
    
    function onMultiServiceChange(serviceId,uid){
        var staffId = $("#AppointmentSalonServiceId_"+uid).attr('data-user-id');
        var serviceDetailURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'admin_fetch_multiprice_and_multiduration')); ?>";
        serviceDetailURL = serviceDetailURL+'/'+serviceId+'/'+uid+'/'+staffId;
        $appModal.find("#PriceDurationId_"+uid).load(serviceDetailURL, function() {
            $appModal.find("#AppointmentSalonServiceId").on("change", function() {
                //onServiceChange(serviceId);
            });
        });    
    }

    var addApp = false;
    function addAppointment($appModal,selectState,eventId,editType){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var addUserURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addAppointment','admin'=>true)); ?>";
        addUserURL  = addUserURL +'/'+startDate+'/'+employeeId+'/'+eventId+'/'+editType; 
        fetchModal($appModal,addUserURL,'AppointmentAdminAddAppointmentForm');
        addApp = true;
    }
    
    function onClickedit(eventId,type){
    var EditType='';
        $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'checkRepeatAppointment','admin'=>true)); ?>',
            method: "POST",
            data: { id : eventId },
        }).done(function(response) {
            if (response>0) {
                var message='<div class="col-sm-12"><input id="AppointmentOccurOnly" class="radio-inline cancelPeriodRadioPolicy" type="radio" value="only" checked name="data[Appointment][occur]"><label class="new-chk" for="AppointmentOccurOnly">Edit only this occurrence</label></div><div class="col-sm-12"><input id="AppointmentSeries" class="radio-inline cancelPeriodRadioPolicy" type="radio" value="series" name="data[Appointment][occur]"><label class="new-chk" for="AppointmentSeries">Edit Series</label></div>';
               title='testst';
                BootstrapDialog.show({
                    message: message,
                    title:title,
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
    }
    
    function onClickMultiple(eventId,type){
        var EditType='';
        var messageEdit='<div class="col-sm-12"><input id="AppointmentOccurOnly" class="radio-inline cancelPeriodRadioPolicy" type="radio" value="only" checked name="data[Appointment][occur]"><label class="new-chk" for="AppointmentOccurOnly">Edit only this occurrence</label></div><div class="col-sm-12"><input id="AppointmentSeries" class="radio-inline cancelPeriodRadioPolicy" type="radio" value="series" name="data[Appointment][occur]"><label class="new-chk" for="AppointmentSeries">Edit Series</label></div>';
        $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'checkMultipleAppointment','admin'=>true)); ?>',
            method: "POST",
            data: { id : eventId },
        }).done(function(response) {
            if (response!='') {
                BootstrapDialog.show({
                    message: response,
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
    }
    
    function addPersonalTask($appModal,selectState,eventId,openhours,closehours){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var addPersonalTaskURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addPersonaltask','admin'=>true)); ?>";
        addPersonalTaskURL  = addPersonalTaskURL +'/'+startDate+'/'+openhours+'/'+closehours+'/'+employeeId+'/'+eventId; 
        fetchModal($appModal,addPersonalTaskURL,'AppointmentAdminAddPersonaltaskForm');
    }
    
    function addWaitingTask($appModal,selectState,eventId){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var addWaitingTaskURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addWaitingtask','admin'=>true)); ?>";
        addWaitingTaskURL  = addWaitingTaskURL +'/'+startDate+'/'+employeeId+'/'+eventId; 
        fetchModal($appModal,addWaitingTaskURL,'AppointmentAdminAddWaitingtaskForm');
    }
    
    function addMultipleAppointments($multiModal,selectState,eventId){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var addMultipleAppointmentsURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'addMultipleappointments','admin'=>true)); ?>";
        addMultipleAppointmentsURL  = addMultipleAppointmentsURL +'/'+startDate+'/'+employeeId+'/'+eventId; 
        fetchModal($multiModal,addMultipleAppointmentsURL,'AddMultiForm');
    }
    
    function saveMultipleAppointments(ser){
        var saveMultipleAppointmentsURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'saveMultipleAppointment','admin'=>true)); ?>";
        saveMultipleAppointmentsURL  = saveMultipleAppointmentsURL+'/'+ser; 
        fetchModal($forwardModal,saveMultipleAppointmentsURL,'AppointmentAdminSaveMultipleAppointmentForm');
        return false;
    }
    
    function editWorkingHours($appModal,selectState,eventId){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
         //alert(startDate);
         var selectedDay = startDate.getDay();
        //alert(n);
        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
       
       
        $.ajax({
                url: '<?php echo $this->Html->url(array("controller"=>"Appointments","action"=>"check_working_hours","admin"=>true)); ?>',
                method: "POST",
                data: {
                        EmpId : employeeId,
                        selectedDay:selectedDay
                        
                    },
                }).done(function(response) {
            
            var obj = jQuery.parseJSON(response);
                    //console.log(obj.from);
                   // location.reload();
                   
                   var editWorkinghoursURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'editWorkinghours','admin'=>true)); ?>";
        editWorkinghoursURL  = editWorkinghoursURL +'/'+startDate+'/'+employeeId+'/'+obj.from+'/'+obj.to+'/'+eventId; 
        fetchModal($appModal,editWorkinghoursURL);
                   
            }); 
        
        
    }
    
    function addMultipleAppointment(){
        
    }
    
    function checkout($appModal,eventId,editType,selectState,appoint_time){
        //alert(eventId);
        var enceventId = window.btoa(eventId);
        var appoint_time = window.btoa(appoint_time);
        //alert(appoint_time);
        var CheckoutURL = "<?php echo $this->Html->url(array('controller'=>'Checkout','action'=>'/appointment','admin'=>true)); ?>";
        window.location = CheckoutURL+'/'+enceventId+'/'+'null'+'/'+appoint_time;
        //addUserURL  = addUserURL +'/'+startDate+'/'+employeeId+'/'+eventId+'/'+editType; 
        //fetchModal($appModal,CheckoutURL);
        //addApp = true;
    }
    
    function moveForward($appModal,selectState,enceventId,editType){
        var employeeId = selectState.resources.employeeId;
        var startDate=selectState.start;
             //console.log(startDate);   

        var UnixTimeStamp = startDate.getUnixTime();
        var Timezone = startDate.getTimezoneOffset()*60;  
        var startDate=UnixTimeStamp+(-Timezone);
        var MoveForwardURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'move_forward_appointment','admin'=>true)); ?>";
        MoveForwardURL  = MoveForwardURL +'/'+startDate+'/'+employeeId+'/'+eventId+'/'+editType; 
        fetchModal($appModal,MoveForwardURL);
    }
    
    function getAppointmentHistory($historyModal,eventId){
        var GetAppointmentHistoryURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'getAppointmentHistory','admin'=>true)); ?>";
        GetAppointmentHistoryURL  = GetAppointmentHistoryURL +'/'+eventId; 
        fetchModal($historyModal,GetAppointmentHistoryURL);
    }
    
    function getCustomerHistory($historyModal,eventId){
        var GetCustomerHistoryURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'getCustomerHistory','admin'=>true)); ?>";
        GetCustomerHistoryURL  = GetCustomerHistoryURL +'/'+eventId; 
        fetchModal($historyModal,GetCustomerHistoryURL);
    }
    
    function AddNote($forwardModal,eventId){
        var AddNoteURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'add_notes','admin'=>true)); ?>";
        AddNoteURL  = AddNoteURL +'/'+eventId;
        //alert(AddNoteURL);
        fetchModal($forwardModal,AddNoteURL);
    }
    
    
    function showAppointment($appModal,eventId,type,date,key){
        if (type=='series') {
            var showAppointmentURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'show_appointment_list','admin'=>true)); ?>";
            showAppointmentURL  = showAppointmentURL +'/'+eventId+'/'+date+'/'+key; 
            fetchModal($appModal,showAppointmentURL);
            
        }else{
            $.ajax({
                url: '<?php echo $this->Html->url(array("controller"=>"Appointments","action"=>"change_appointment_status","admin"=>true)); ?>',
                method: "POST",
                data: {
                        id : eventId,
                        key:key,
                        startDate:date
                    },
                }).done(function(response) {
                    location.reload(); 
            });   
        }
    }
    
    function cancelAppointment($appModal,eventId,type,date,key){
       if (type=='series') {
            var showAppointmentURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'show_appointment_list','admin'=>true)); ?>";
            showAppointmentURL  = showAppointmentURL +'/'+eventId+'/'+date+'/'+key; 
            fetchModal($appModal,showAppointmentURL);
            
        }else{
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'change_appointment_status','admin'=>true)); ?>',
                method: "POST",
                data: {
                        id : eventId,
                        key:key
                    },
                }).done(function(response) {
                    notify(eventId);
            });   
        }
    }
    
    function printTicket($appModal,selectState,eventId,key){
        var PrintURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'/printticket','admin'=>true)); ?>";
        window.open(PrintURL+'/'+eventId);
        window.onfocus=function(){ window.close();}
    }
    function toTimestamp(strDate){
        var datum = Date.parse(strDate);
        return datum/1000;
        }

    function notify(eventId){
        var notifyCustomerURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'notify_customer','admin'=>true)); ?>";
        //notifyCustomerURL  = notifyCustomerURL +'/'+startDate+'/'+employeeId+'/'+eventId+'/'+editType; 
        notifyCustomerURL  = notifyCustomerURL+'/'+eventId;
        fetchModal($appModal,notifyCustomerURL);
    }
    function notify_customer(){
        message='Do you want to notify the Customer By Email, Text or Push Notification?';
        BootstrapDialog.show({
                    message: message,
                    buttons: [{
                        label: 'Undo Move',
                        cssClass: 'btn-primary',
                        action: function(dialogRef){
                            var result='no-move';
                            return result;
                            
                        }},
                        {
                        label: 'Notify Customer',
                        action: function(dialogRef) {
                            var result='notify-customer';
                            //dialogRef.close();
                        }},
                        {
                        label: 'Dont Notify Customer',
                        action: function(dialogRef) {
                            var result='dont-notify-customer';
                            //dialogRef.close();
                        }}
                        ]
                });
        
    }
    function change_appointment_status(id,start_date,type,key){
        //alert("tete");
        if (key=="delete") {
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'change_appointment_status','admin'=>true)); ?>',
                method: "POST",
                data: {
                        id : id,
                        key:key
                    },
                }).done(function(response) {
                location.reload(); 
            });
        }
        if (key=="cancel") {
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'change_appointment_status','admin'=>true)); ?>',
                method: "POST",
                data: {
                        id : id,
                        key:key
                    },
                }).done(function(response) {
                location.reload(); 
            });
        }
        else if (key=="serviceInprogress") {
            var startDate=selectState.start;
            var UnixTimeStamp = startDate.getUnixTime();
            var Timezone = startDate.getTimezoneOffset()*60;
            Timezone=Timezone+dubai_timezone;
            var startDate=UnixTimeStamp+(-Timezone);
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'change_appointment_status','admin'=>true)); ?>',
                method: "POST",
                data: {
                        id : id,
                        startDate:startDate,
                        key:key
                    },
                }).done(function(response) {
                    if (response=='repeat') {
                        alert('You can not change the status of future appointments to in progress');
                        return false;
                    }
                location.reload(); 
            });
        }
        else if (key=="deny") {
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'change_appointment_status','admin'=>true)); ?>',
                method: "POST",
                data: {
                        id : id,
                        key:key
                    },
                }).done(function(response) {
                location.reload(); 
            });
        }
        else if (key=="show" || key=="noShow") {
           //alert(key);
           var title='';
            var startDate=selectState.start;
            var UnixTimeStamp = startDate.getUnixTime();
            var Timezone = startDate.getTimezoneOffset()*60;
            Timezone=Timezone+dubai_timezone;
            var startDate=UnixTimeStamp+(-Timezone);
            var EditType='';
            //alert("hihihihii");
        $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'show_appointment','admin'=>true)); ?>',
            method: "POST",
            data: { id : id,
                    date:startDate,
                    key:key},
        }).done(function(response) {
            if (response>=1) {
                
                //if (key=='noShow') {
                  //  alert("n");
                  <?php   //$options = array('only' => 'No Show only this occurrencex','series' => 'No Show multiple Appointments'); ?>
                //}
                 if (key=='show' || key=='noShow') {
                <?php
                $options = array('only' => 'only this occurrence','series' => 'multiple Appointments'); ?>
                }
                <?php
                $attributes = array('legend' => false,'label'=>array('class'=>'new-chk'),'class'=>'radio-inline cancelPeriodRadioPolicy','separator'=>'</div><div class="col-sm-12">','default'=>'only');?>                var message='<div class="col-sm-12"><?php echo $this->Form->radio('showonly', $options, $attributes);?></div>';
                if (key=='show') {
                    title='Show Appointments';
                }
                if (key=='noShow') {
                    title='No Show Appointments';
                }
                BootstrapDialog.show({
                    message: message,
                    title:title,
                    buttons: [{
                        label: title,
                        cssClass: 'btn-primary',
                        action: function(dialogRef){
                            if ($('#showonlyOnly').is(":checked")){ var EditType='only'; }
                            if ($('#showonlySeries').is(":checked")) { var EditType='series'; }
                                dialogRef.close();
                                if (key=='cancel') {
                                    cancelAppointment($appModal,id,EditType,startDate,key)
                                }else{
                                    showAppointment($appModal,id,EditType,startDate,key)
                                }
                                
                            }
                        },
                        {
                        label: 'Do Not Edit',
                        action: function(dialogRef) {
                            typeof dialogRef.getData('callback') === 'function' && dialogRef.getData('callback')(true);
                            dialogRef.close();
                        }
                        }]
                });
            }
            else{
               $.ajax({
            url: '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'change_appointment_status','admin'=>true)); ?>',
            method: "POST",
            data: { id : id,
                    key:key,
                    startDate:startDate},
        }).done(function(response) {
                location.reload(); 
                                });
            }
        });
    }
}
    
    $(document).ready(function(){
        $usermodal = $(document).find('#commonContainerModal');
        $(document).on('click','.addeditUser',function(){
            var addUserURL = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'addUser','admin'=>true)); ?>";
            var itsId = $(this).attr('data-id');
            fetchModal($usermodal,addUserURL+'/'+itsId);
            $usermodal.find('.submitUser').unbind( "click" );
        });
        
        $usermodal.on('click', '.submitUser', function(e){
            var options = { 
                success:function(res){
                    if(onResponse($usermodal,'User',res)){
                        var data = jQuery.parseJSON(res);
                        onSelectChange(data.id)
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
        
        $appModal.on('click', '.submitAppointment', function(e){
            var theBtn = $(this);
            buttonLoading(theBtn);
            var options = { 
                success:function(res){
                    buttonSave(theBtn);
                    if(onResponse($appModal,'Appointment',res)){
                            var data = jQuery.parseJSON(res);
                             location.reload();
                              //$("#scheduler").load("<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'index','admin'=>true));?>");
                    }else{
                        addApp = true;
                    }
                }
            }; 
            $('#AppointmentAdminAddAppointmentForm').submit(function(){
                if(addApp == true){
                    theBtn.addClass('rqt_already_sent');
                    $(this).ajaxSubmit(options);
                    addApp = false;
                }
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
            
            //setTimeout(function(){
            //    if($appModal.find('dfn.text-danger').length > 0){
            //        buttonSave(theBtn);
            //    }
            //},1000);
        });
        
        $(document).on('click', '.AppointmentHistory', function(e){
            var appointment_id=$(this).attr("value");
            getAppointmentHistory($historyModal,appointment_id);
        });
         
        $(document).on('click', '.CustomerHistory', function(e){
            var customerHistoryURL = "<?php echo $this->Html->url(array('controller'=>'appointments','action'=>'getCustomerHistory','admin'=>true)); ?>";
            var itsId = $(this).attr('user-id');
            var note_tab_active = $(this).attr('note_tab_active');
            fetchModal($historyModal,customerHistoryURL+'/'+itsId+'/'+note_tab_active);
            //$usermodal.find('.submitUser').unbind( "click" );
        
        });
        
        $(document).on('click', '.AddNote', function(e){
            var AddNoteURL = "<?php echo $this->Html->url(array('controller'=>'appointments','action'=>'add_notes','admin'=>true)); ?>";
            var itsId = $(this).attr('user-id');
            fetchModal($forwardModal,AddNoteURL+'/'+itsId);
        });
        
        $multiModal.on('click', '.submitMultiAppointment', function(e){
            var ser=$('#AddMultiForm').serialize();
            $('#AddMultiForm').submit(function(){
                    saveMultipleAppointments(ser);
                    return false;
            });
        });
        
        
        
        
        $forwardModal.on('click', '.saveMultipleAppointment', function(e){
             var options = { 
                success:function(res){
                   // console.log(res);
                    if(onResponse($forwardModal,'Appointment',res)){
                        var data = jQuery.parseJSON(res);
                        location.reload();
                        onSelectChange(data.id)
                    }
                }
            }; 
            $('#AppointmentAdminSaveMultipleAppointmentForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        
        
        $forwardModal.on('click', '.submitforwardAppointment', function(e){
            var options = { 
                success:function(res){
                  if(onResponse($forwardModal,'Appointment',res)){
                        var data = jQuery.parseJSON(res);
                        onSelectChange(data.id);
                        location.reload(); 
                    }
                }
            }; 
            $('#AppointmentAdminAddForwardAppointmentForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        $forwardModal.on('click', '.submitsearchAppointment', function(e){
            var options = { 
                success:function(res){
                  if(onResponse($forwardModal,'Appointment',res)){
                        var data = jQuery.parseJSON(res);
                        onSelectChange(data.id);
                        location.reload(); 
                    }
                }
            }; 
            $('#AppointmentAdminAddSearchAppointmentForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        
        
        $appModal.on('click', '.submitWaitingTask', function(e){
            var options = { 
                success:function(res){
                    if(onResponse($appModal,'Appointment',res)){
                            var data = jQuery.parseJSON(res);
                            location.reload(); 
                            //onSelectChange(data.id)
                    }
                }
            }; 
            $('#AppointmentAdminAddWaitingtaskForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        $appModal.on('click', '.submitPersonalTask', function(e){
            var options = { 
                success:function(res){
                    if(onResponse($appModal,'Appointment',res)){
                            var data = jQuery.parseJSON(res);
                            //onSelectChange(data.id)
                            location.reload(); 
                    }
                }
            }; 
            $('#AppointmentAdminAddPersonaltaskForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        
        $appModal.on('click', '.submitWorkingHours', function(e){
            var options = { 
                success:function(res){
                    if(onResponse($appModal,'SalonOpeningHour',res)){
                            var data = jQuery.parseJSON(res);
                            location.reload(); 
                    }
                }
            }; 
            $('#SalonOpeningHourAdminEditWorkinghoursForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        $(document).click(function(){
            $('.context-menu-list').hide();
        });
        
        
        $appModal.on('click', '.submitShowAppointment', function(e){
        
            var options = { 
                success:function(res){
                    if(onResponse($appModal,'SalonOpeningHour',res)){
                            var data = jQuery.parseJSON(res);
                            //onSelectChange(data.id)
                            location.reload();
                    }
                }
            }; 
            $('#AppointmentAdminShowAppointmentListForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        $(document).find('#AppointmentCheckBox').on('click', function() { 
            $('.chk').attr('checked', true);
        });
        
       
        $appModal.on('click', '.forwardAppointment', function(e){
            var ser=$('#AppointmentAdminMoveForwardAppointmentForm').serialize();
            time=$(this).val();
            var fromTime = $(this).attr("data-time");
            appId=$('#AppointmentId').val();
            
            /****Convert time to 24 hour format *****/
            
            var hours = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);
            var AMPM = time.match(/\s(.*)$/)[1];
            if(AMPM == "PM" && hours<12) hours = hours+12;
            if(AMPM == "AM" && hours==12) hours = hours-12;
            var sHours = hours.toString();
            var sMinutes = minutes.toString();
            if(hours<10) sHours = "0" + sHours;
            if(minutes<10) sMinutes = "0" + sMinutes;
                var time=sHours + "-" + sMinutes
                var addForwardAppointmentURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'add_forward_appointment','admin'=>true)); ?>";
        addForwardAppointmentURL  = addForwardAppointmentURL+'/'+appId+'/'+ser+'/'+time+'/'+fromTime;
        fetchModal($forwardModal,addForwardAppointmentURL);
        });
        
        
        $forwardModal.on('click', '.searchAppointmentSlots', function(e){
            var ser=$('#AppointmentAdminSearchAppointmentForm').serialize();
            //console.log(ser);
            time=$(this).val();
            //alert(time);
            var fromTime = $(this).attr("data-slot-time");
            var user_id=$(this).attr("data-slot-user-id");
            
            //appId=$('#AppointmentId').val();
            //alert(appId);
            
            /****Convert time to 24 hour format *****/
            
            var hours = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);
            var AMPM = time.match(/\s(.*)$/)[1];
            if(AMPM == "PM" && hours<12) hours = hours+12;
            if(AMPM == "AM" && hours==12) hours = hours-12;
            var sHours = hours.toString();
            var sMinutes = minutes.toString();
            if(hours<10) sHours = "0" + sHours;
            if(minutes<10) sMinutes = "0" + sMinutes;
                var time=sHours + "-" + sMinutes
                var addSearchAppointmentURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'add_search_appointment','admin'=>true)); ?>";
        addSearchAppointmentURL  = addSearchAppointmentURL+'/'+user_id+'/'+ser+'/'+time+'/'+fromTime;
        fetchModal($multiModal,addSearchAppointmentURL);
        });
        
        
        
        $appModal.on('click', '.searchTimeslots', function(e){
            $("#timeSlots").show();
            var options = { 
                success:function(res){
                    if(res){
                            $appModal.find("#timeSlots").html(res);
                    }
                }
            }; 
            $('#AppointmentAdminMoveForwardAppointmentForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        
        $forwardModal.on('click', '.searchAppointments', function(e){
            
            $("#timeSlots").show();
            var options = { 
                success:function(res){
                    if(res){
                            $forwardModal.find("#timeSlots").html(res);
                    }
                }
            }; 
            $('#AppointmentAdminSearchAppointmentForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        
        
        
        $appModal.on('change', '#AppointmentSalonForwardServiceId', function(e){
            $("#timeSlots").hide();
        });
        
        
        $forwardModal.on('click', '.submitNote', function(e){
            //alert("testtststst");
            addApp = true;
            $('#commonSmallModal').modal('toggle');
            var theBtn = $(this);
            buttonLoading(theBtn);
            var options = { 
                success:function(res){
                    buttonSave(theBtn);
                    $("#sectionD").html(res);
                    //if(onResponse($forwardModal,'Note',res)){
                      //  alert("test");
                            //var data = jQuery.parseJSON(res);
                    //}else{
                      //  addApp = true;
                    //}
                }
            }; 
            $('#add_note_form').submit(function(){
                if(addApp == true){
                    theBtn.addClass('rqt_already_sent');
                    $(this).ajaxSubmit(options);
                    addApp = false;
                }
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
            
            setTimeout(function(){
                if($forwardModal.find('dfn.text-danger').length > 0){
                    buttonSave(theBtn);
                }
            },500);
        });
        
        
        $('.search').click(function(){
            var searchAppointmentURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'search_appointment','admin'=>true)); ?>";
        fetchModal($forwardModal,searchAppointmentURL,'AppointmentAdminSearchAppointmentForm');
            
        });
        
        $('.addProduct').click(function(){
      
            var addProductURL = "<?php echo $this->Html->url(array('controller'=>'Checkout','action'=>'add_product','admin'=>true)); ?>";
        fetchModal($appModal,addProductURL);
            
        });
        
         
        
        
        
    });
</script>