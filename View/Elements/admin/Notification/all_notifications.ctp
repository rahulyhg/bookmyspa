<table class="table table-hover table-nomargin table-bordered">
<thead>
    <tr>
        <th>Date</th>
        <th>Type</th>
        <th>Notification From</th>
        <th>Notification</th>
        <th>Action</th>
    </tr>
</thead>

    <?php
    if (count($notifications)){ ?>
    <tbody>
<?php 
        foreach ($notifications as $notification){
            $label = ucfirst($this->Common->notification_type($notification['UserNotification']['notification_type']));
            ?>
            <tr data-id="<?php echo $notification['UserNotification']['id'];?>">
                <td><?php echo $this->Common->getDateFormat($notification['UserNotification']['created']); ?></td>
                <td><?php echo $label; ?></td>
                <td><?php 
                $name = ucfirst($notification['NotificationBy']['first_name']) . ' ' . $notification['NotificationBy']['last_name'];
                echo $this->html->link($name ,array('controller'=>'Business','action'=>'view','admin'=>true,'bview'=>base64_encode(base64_encode($notification['NotificationBy']['id']).'-CODE-'.$notification['NotificationBy']['username'])),array('target'=>'_blank') ); ?>
                </td>
                <td>
                    <span class="notification-icon">
                        &nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;&nbsp;
                        </span>
                        <span class="m-left-xs"><?php echo ucfirst($notification['NotificationBy']['first_name']).' '.$notification['NotificationBy']['last_name']  .' has '. $label;  ?> 
                        <?php 
                        $eventDetail = $this->Common->get_nofication_event($notification['UserNotification']['notification_event_id'],$notification['UserNotification']['associate_modal']); 
//                        pr($eventDetail);
                        if($notification['UserNotification']['associate_modal']=='User' && count($eventDetail)){
                         $name =  '<b>'.ucfirst($eventDetail['User']['first_name'].' '.$eventDetail['User']['last_name']).'</b>';
                         echo $this->Html->link($name ,'javascript:void(0)',array('data-id'=>$eventDetail['User']['id'],'title' => 'View', 'class' => 'view_user', 'escape' => false));
                        }
                        ?>
                        to saloon  <b><?php echo $this->Common->get_salon_name($notification['NotificationBy']['id']); ?></b> </span>
                        <span class="time text-muted">
                            <?php echo $this->Common->getTimeDifference($notification['UserNotification']['created']); ?>
                        </span>
                </td>
                <td>
                <?php 
                $mark = ($notification['UserNotification']['status'])?'Mark as Unread':'Mark as read';
                echo $this->Html->link($mark,'javascript:void(0)', array('class'=>'mark_as','data-status'=>$notification['UserNotification']['status'])); ?>
                </td>
            </tr>
    <?php } ?> </tbody>
                      
                        
    <?php }else { ?>
    <tbody>
    	<tr><td>No data available</td></tr>
        </tbody>
    <?php } ?>
   
   
                    </table> 

<script>
    $(document).ready(function() {
        $(document).on('click', '.view_user', function(){
            var itsId = $(this).data('id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'staff_profile','admin'=>true)); ?>";
            var $bigmodal = $('#commonContainerModal');
            addeditURL = addeditURL + '/' + itsId;
            fetchModal($bigmodal, addeditURL);
        });
        });

</script>