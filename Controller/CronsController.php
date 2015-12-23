<?php
class CronsController extends AppController {
     public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
     public $components = array('Session','Common'); //An array containing the names of components this controller uses.
     
     public function beforeFilter() {
          parent::beforeFilter();
          $this->Auth->allow('send_reminder_appointment','appointment_status','password','logging','appointment_availed');
     }
     
     function password(){
          $pass = 'VEVWRk1UUlZRVVE9RFloRzkzYjBxeUpmc2FkZjM0NTZzZGZnSXhmczJndVZvVXViV3d2bmlSMkcwRmdhQzltaQ==';
          echo $depass = $this->Common->fnDecrypt($pass); die;
     }
     
     /**********************************************************************************    
       @Function Name : admin_send_appointment_notification
       @Params	 : NULL
       @Description   : The Function to mail user acording to vendor settings before start of appointment
       @Author        : Shiv
       @Updated By    : Anshul 
       @Date          : 3-July-2015
       @Updated By: Ramanpreet Pal
     ***********************************************************************************/
 
     public function send_reminder_appointment(){
          $this->autoRender=false;
          $this->loadModel('SalonEmailSms');
          $this->loadModel('User');
          $salons_without_reminders = $this->SalonEmailSms->find('list',array(
                                   'conditions' => array('is_reminder'=>0),
                                   'fields'=>array('id','user_id')
                              ));
          if(!empty($salons_without_reminders)){
               $salons_without_reminders_str = implode(',',$salons_without_reminders);
          }
          $this->User->unbindModel(array(
                              'hasOne'=> array('Address','UserDetail','Contact',),
                              'belongsTo'=> array('Group'),
                              'hasMany' => array('PricingLevelAssigntoStaff')
                              ));
          $this->User->bindModel(array('hasOne'=> array('SalonEmailSms')));
          if(!empty($salons_without_reminders_str)) {
               $all_salon_reminders = $this->User->find('all',
                    array(
                         'conditions'=> 
                              array('User.id NOT IN ('.$salons_without_reminders_str.')',
                              'User.type' => 4),
                         'fields'=>array('User.id','Salon.eng_name','SalonEmailSms.*')
                    )
               );
          } else {
               $all_salon_reminders = $this->User->find('all',
                         array(
                              'conditions' => array('User.type' => 4),
                              'fields'=>array('User.id','Salon.eng_name','SalonEmailSms.*')
                         )
                    ); 
          }
          if(!empty($all_salon_reminders)){
               $superReminderDetails = $this->SalonEmailSms->find('first', array(
                                   'conditions'=>array('SalonEmailSms.user_id'=>1),
                              ));
               if(!empty($superReminderDetails)) {
                    $defaultEmailReminderHours = $superReminderDetails['SalonEmailSms']['client_email_reminder_hrs'];
               } else {
                    $defaultEmailReminderHours = 24;
               }
               if(!empty($superReminderDetails)) {
                    $defaultSmsReminderHours = $superReminderDetails['SalonEmailSms']['client_sms_reminder_hrs'];
               } else {
                    $defaultSmsReminderHours = 24;
               }
               
               foreach($all_salon_reminders as $salon_reminder) {
                    $salon_name = '';
                    $salon_name = $salon_reminder['Salon']['eng_name'];
                    if(!empty($salon_reminder['SalonEmailSms']['client_email_content'])){
                         $vendor_msg = $salon_reminder['SalonEmailSms']['client_email_content'];
                    }else if(empty($salon_reminder['SalonEmailSms']['client_email_content']) && !empty($salon_reminder['SalonEmailSms']['id'])) {
                         $vendor_msg = '';
                    }  else {
                         $vendor_msg = $superReminderDetails['SalonEmailSms']['client_email_content'];
                    }
                    $appointment_notifications = array();
                    $repeated_appointment_notifications = array();
                    /*********** Email HOURS *******/
                    if(!empty($salon_reminder['SalonEmailSms']['client_email_reminder_hrs'] )){
                         $reminderemailHours = $salon_reminder['SalonEmailSms']['client_email_reminder_hrs'];
                    } else {
                        $reminderemailHours = $defaultEmailReminderHours;
                    }
                    $end_reminderemailHours = $reminderemailHours;
                    $start_date_time = strtotime(date('d-m-Y H:i',strtotime('+'.$reminderemailHours.' hour')));
                    $end_date_time = strtotime(date('d-m-Y H:i',strtotime('+'.$end_reminderemailHours.' hour +10 minutes')));
                    /*********** Email HOURS *******/
                    $this->send_reminder_emails($salon_reminder['User']['id'],$start_date_time,$end_date_time,$salon_name,$vendor_msg,'email');
                    /*********** SMS HOURS *******/
                    if(!empty($salon_reminder['SalonEmailSms']['client_email_reminder_hrs'] )){
                         $remindersmsHours = $salon_reminder['SalonEmailSms']['client_email_reminder_hrs'];
                    } else {
                        $remindersmsHours = $defaultEmailReminderHours;
                    }
                    $end_remindersmsHours = $remindersmsHours;
                    $sms_start_date_time = strtotime(date('d-m-Y H:i',strtotime('+'.$remindersmsHours.' hour')));
                    $sms_end_date_time = strtotime(date('d-m-Y H:i',strtotime('+'.$end_remindersmsHours.' hour +10 minutes')));
                    //echo 'start '.$sms_start_date_time.' endTime'.$sms_end_date_time;
                    /*********** SMS HOURS *******/
                    $this->send_reminder_emails($salon_reminder['User']['id'],$sms_start_date_time,$sms_end_date_time,$salon_name,$vendor_msg,'sms');
               }
          }
     }
     
     public function send_reminder_emails($salon_id = null,$start_time = null, $end_time = null,$salon_name = null,$vendor_msg = null,$reminder_type = 'email'){
          $this->loadModel('Appointment');
          $this->loadModel('AppointmentSlot');
           $conditions = array(
                    'Appointment.salon_id' => $salon_id,
                    'Appointment.appointment_start_date >=' => $start_time,
                    'Appointment.appointment_start_date < ' => $end_time,
                    'Appointment.appointment_repeat_type' => 0,
                    'Appointment.email_reminder' => 1,
                    'Appointment.status' => array(1,4)
           );
          if($reminder_type == 'email'){
             $conditions['Appointment.email_reminder']  = 1;   
          }else if($reminder_type == 'sms'){
             $conditions['Appointment.sms_reminder']  = 1;     
          }else{
            $conditions['Appointment.email_reminder']  = 1;
            $conditions['Appointment.sms_reminder']  = 1;
          }
          
          $single_appointment_notifications = $this->Appointment->find('all',array(
               'fields'=>array(
                    'Appointment.id',
                    'Appointment.salon_staff_id',
                    'Appointment.user_id',
                    'Appointment.appointment_start_date',
                    'Appointment.salon_id',
                    'Appointment.type',
                    'Appointment.status',
                    'Appointment.appointment_price',
                    'Appointment.appointment_comment',
                    'Appointment.appointment_title',
                    'Appointment.appointment_duration',
                    'SalonService.eng_name'
               ),
               'conditions' => $conditions
          ));
          $this->Appointment->unbindModel(array( 'belongsTo'=> array('User')));
          $this->AppointmentSlot->bindModel(array(
                         'belongsTo'=> array(
                              'Appointment' =>array(
                                   'fields' => array(
                                        'Appointment.id',
                                        'Appointment.salon_staff_id',
                                        'Appointment.user_id',
                                        'Appointment.type',
                                        'Appointment.status',
                                        'Appointment.salon_id',
                                        'Appointment.appointment_price',
                                        'Appointment.appointment_comment',
                                        'Appointment.appointment_title',
                                        'Appointment.appointment_duration',
                                        'Appointment.salon_service_id',
                                   )
                              )
                         )
                    ));
          $this->AppointmentSlot->Appointment->bindModel(array(
                                             'belongsTo'=> array(
                                                  'SalonService'=>array(
                                                       'fields'=>array(
                                                            'SalonService.id',
                                                            'SalonService.eng_name')
                                                  )
                                             )
                                        ));
          $this->AppointmentSlot->recursive = 2;
          $repeated_appointment_notifications = $this->AppointmentSlot->find('all',array(
               'fields'=>array(
                    'AppointmentSlot.id',
                    'AppointmentSlot.salon_id',
                    'AppointmentSlot.startdate',
                    'AppointmentSlot.appointment_id',
               ),
               'conditions'=>array(
                    'Appointment.salon_id' => $salon_id,
                    'AppointmentSlot.startdate >=' => $start_time,
                    'AppointmentSlot.startdate < ' => $end_time,
               )
          ));
          if(!empty($single_appointment_notifications)){
               foreach($single_appointment_notifications as $appointment_notification){
                    //pr($appointment_notification); echo '<hr>';
                    $this->admin_notify_customer($appointment_notification['Appointment']['id'],
                              $appointment_notification['Appointment']['appointment_title'],
                              $appointment_notification['Appointment']['salon_staff_id'],
                              $appointment_notification['Appointment']['user_id'],
                              $appointment_notification['SalonService']['eng_name'],
                              $appointment_notification['Appointment']['appointment_start_date'],
                              $appointment_notification['Appointment']['appointment_duration'],
                              'appointment_notification',
                              $salon_name,
                              $vendor_msg,
                              $appointment_notification['Appointment']['salon_id'],
                              $reminder_type);
               }
          }
          if(!empty($repeated_appointment_notifications)){
               foreach($repeated_appointment_notifications as $repeated_appointment_notification){
                    $this->admin_notify_customer($repeated_appointment_notification['Appointment']['id'],
                              $repeated_appointment_notification['Appointment']['appointment_title'],
                              $repeated_appointment_notification['Appointment']['salon_staff_id'],
                              $repeated_appointment_notification['Appointment']['user_id'],
                              $repeated_appointment_notification['Appointment']['SalonService']['eng_name'],
                              $repeated_appointment_notification['AppointmentSlot']['startdate'],
                              $repeated_appointment_notification['Appointment']['appointment_duration'],
                              'appointment_notification',
                              $salon_name,
                              $vendor_msg,
                              $repeated_appointment_notification['Appointment']['salon_id'],
                              $reminder_type);
               }
          }
     }
     
     /**********************************************************************************    
     @Function Name : admin_notify_customer
     @Params	 : NULL
     @Description   : The Function to notify customer after creating appointment
     @Author        : Shiv
     @Date          : 16-Mar-2015
     ***********************************************************************************/
     
     public function admin_notify_customer($appointmentId,$appointment_title=NULL,$staff_id = null,$user_id=NULL,$service_name=NULL,$start_date=NULL,$duration=NULL,$tempate=NULL,$salon_name = null,$vendor_msg = null,$salon_id = null, $reminder_type = 'email'){
          $this->loadModel('User');
          $this->loadModel('Appointment');
          $this->User->unbindModel(array(
                              'hasOne'=> array('Address','UserDetail'),
                              'belongsTo'=> array('Group'),
                              'hasMany' => array('PricingLevelAssigntoStaff')
                              ));
          if(!empty($staff_id)){
               $staff_data = $this->Common->employeeName($staff_id);
               if(!empty($staff_data)){
                    $staff_name = ucfirst(@$staff_data['User']['first_name']).' '.ucfirst(@$staff_data['User']['last_name']);
               } else {
                    $staff_name = '';
               }
          }
          $userData = $this->User->find('first', array(
                              'fields' => array(
                                   'User.id',
                                   'User.first_name',
                                   'User.last_name',
                                   'User.email',
                                   'Contact.cell_phone',
                                   'Contact.country_code',
                              ),
                              'conditions' => array(
                                   'User.id' => $user_id
                              )
                         ));
          $toEmail = $userData['User']['email'];
          $fromEmail = Configure::read('fromEmail');
          if($reminder_type == 'email') {
               $dynamicVariables = array(
                                   '{FirstName}'=>ucfirst($userData['User']['first_name']),
                                   '{LastName}'=>ucfirst($userData['User']['last_name']),
                                   '{service_name}' => ucfirst($service_name),
                                   '{start_date}' => date('d F, Y',$start_date),
                                   '{time}' => date('h:i A',$start_date),
                                   '{duration}' => $this->Common->get_mint_hour($duration),
                                   '{service_provider}' => $staff_name,
                                   '{MESSAGE}' => $vendor_msg,
                                   '{Salon_name}' => $salon_name
                              );
               $template_type =  $this->Common->EmailTemplateType($salon_id);
               if($template_type){
                 $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
               }
               $this->Common->sendEmail($toEmail,
                                   $fromEmail,
                                   $tempate,
                                   $dynamicVariables
                              );
               //$this->Appointment->id = $appointmentId;
              // $this->Appointment->saveField('email_reminder',1);
          } else if($reminder_type == 'sms'){
               $mbNumber =  $userData['Contact']['cell_phone'];
 	       if($userData['User']['id'] == 1) {
                    $mbNumber  = '919814077178';
	       }
               $country_code  = $userData['Contact']['country_code'];
               $sms_msg = $toEmail.' (Reminder) Your appointment is on '.date('D d F, Y',$start_date).', '.date('h:i A',$start_date).' with '.$staff_name.'. See you at '.$salon_name;
               if(!empty($mbNumber)){
                    if($country_code){
                        $sms_on = $country_code.''.$mbNumber; 
                    }else{
                      $country_code = 971;
                      $sms_on = $country_code.''.$mbNumber;    
                    }
                    $this->Common->sendVerificationCode($sms_msg,$sms_on);
                   
                    //$this->Appointment->id = $appointmentId;
                    //echo $appointmentId;
                    //$this->Appointment->saveField('sms_reminder',1);
                      
               }
          } else { }
     }
     
     public function appointment_status(){
          
          echo $ven_msg = $this->Common->get_vendor_message(2);
          die;
          echo $date = date('d-m-Y');
          $all_appointments = $this->Appointment->find('all',array(
                                   'conditions' => array(
                                        'by_vendor' => 1,
                                    )
                              ));
     }
     
     public function logging(){
           $this->autoRender = false;
           CakeLog::write('device_activity', "Tetsa logg file");
     }
    
    
    public function appointment_availed(){
          $this->loadModel('Appointment');
          $this->loadModel('Order');
           $this->autoRender = false;
          $yesterday = date('Y-m-d' , strtotime('-1 day'));
          $this->Order->recursive = -1;
          $all_orders  = $this->Order->find('list',array('conditions'=>array('Order.start_date'=>$yesterday,'Order.is_checkout'=>0,'Order.service_type'=>array(1,2,3,5) ,'Order.transaction_status'=>array(1,5,6,7,8),'Order.order_avail_status'=>0),'fields'=>array('id')));
               if(count($all_orders)){
                     $this->Appointment->updateAll(array('Appointment.status' =>3), array('Appointment.order_id' =>$all_orders));
                     $this->Order->updateAll(array('Order.order_avail_status' =>1), array('Order.id' =>$all_orders));
               }
               echo "hi";
               exit;
       
    }
     
     
}