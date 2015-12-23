<?php
Class UserNotification extends AppModel{
       public $name = 'UserNotification';
       public $belongsTo = array('NotificationTO' => array(
                                'className' => 'User',
                                'foreignKey' => 'notification_to',
                                'fields'=>array('NotificationTO.first_name','NotificationTO.last_name'),
                            ),
                               'NotificationBy' => array(
                                'className' => 'User',
                                'foreignKey' => 'notification_by',
                                //'fields'=>array('first_name','last_name','Salon.eng_name')
                            )
           );
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

