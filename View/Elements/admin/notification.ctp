<?php                       
    $notifications =array();
    $notifications =  $this->Common->notifications(); 
?>                                
<a href="javascript:void(0);" class='dropdown-toggle' data-toggle="dropdown">
    <?php echo $this->Html->image('notification.png',array('title'=>'Notifications')); ?>
				</a>
					<ul class="dropdown-menu pull-right">
                                        <li>
                                            <span class="heading">You have <?php echo $notifications['total'];  ?> new notifications</span>
                                        </li> 
					<?php foreach($notifications['notifications'] as $notification){
                                            $label = $this->Common->notification_type($notification['UserNotification']['notification_type']);
                                            ?>
                                        <li>
					    <a href="javascript:void(0)">
						<span class="notification-icon">
						&nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;&nbsp;
						</span>
                                                <span class="m-left-xs"><?php echo ucfirst($notification['NotificationBy']['first_name']).' '.$notification['NotificationBy']['last_name']  .' has '. $label;  ?> to saloon <b><?php echo $this->Common->get_salon_name($notification['NotificationBy']['id']); ?></b> </span>
                                                <span class="time text-muted">
                                                    <?php echo $this->Common->getTimeDifference($notification['UserNotification']['created']); ?>
                                                </span>
					    </a>
					</li>
                                        <?php } ?>
                                        <?php if($notifications['total']>5){ ?>
					<li>
                                            <?php echo $this->Html->link('View all notifications',array('controller'=>'Notifications','action'=>'index','admin'=>TRUE) , array('class'=>'btn btn-primary')); ?>
                                        </li>
					
                                        <?php } ?>
                                        </ul>