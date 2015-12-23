<?php
class BookingsController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie', 'Common','Image','Crypto'); //An array containing the names of components this controller uses.

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('showService','getStaff','getAvailableTimeslots','getAdminTimeslots','removeTimeSlot','appointment','payment','check_phone');
        //$this->Auth->allow('*');
    }

/**********************************************************************************    
  @Function Name : showService
  @Params	 : NULL
  @Description   : for displaying booking on the salon service page.
  @Author        : Aman Gupta
  @Date          : 10-April-2015
******************************************************************************************/

    public function showService($serviceId = NULL, $dealID = NULL, $apntmntORevchrID = NULL){
        $salonId = 0;
        $resources = array();
        $serviceDetails = array();
        $blkDate = array();
        $deal = false;
        $dealAvailtime = '';
        $deal_id = '';
        // in case of deal $serviceId is dealid
        /*****************Don't remove**********/
        if(!empty($serviceId)){
            //pr($this->params);
            //exit;
            $service_details = explode('-',$serviceId);
            $cnt_ser_details = count($service_details);
            $encoded_service_id = $service_details[$cnt_ser_details-1];
            //echo $encoded_service_id;
            if($encoded_service_id == 'deal'){
                $encoded_service_id = $service_details[$cnt_ser_details-2];
                $deal = true;
                $deal_id = base64_decode($dealID);
            }
            $service_id = base64_decode($encoded_service_id);
           
            if(is_numeric($service_id)){
                $serviceId = $service_id;
            }
        }
        $reschedule = '';
        $eVoucher = '';
        if(!empty($apntmntORevchrID)){
            $apntmntORevchrID = base64_decode($apntmntORevchrID);
            if($this->Session->read('APPOINTMENT.RESCHEDULE')){
                $this->loadModel("Appointment");
                $appointmentID = $apntmntORevchrID;
                $count = $this->Appointment->find("count",array("conditions"=>array("Appointment.order_id"=>$appointmentID)));
                if($count == 1 && $this->Session->read('APPOINTMENT.RESCHEDULE')==true){
                    $this->loadModel("Order");
                    $this->Order->unbindModel(array('belongsTo'=>array('SalonService')));
                    $this->Order->bindModel(array('hasOne'=>array('Appointment')));
                    $order = $this->Order->find("first",array('fields'=>array("Order.price_option_id","Appointment.id"),"conditions"=>array("Order.id"=>$appointmentID)));
                    if($order){
                        $appointmentID = $order['Appointment']['id'];
                        $pricingoption = $order['Order']['price_option_id'];
                        $this->set(compact("appointmentID","pricingoption"));
                        $reschedule = 'true';
                    }
                }
            } else if($this->Session->read('EVOUCHER.BOOKAPPOINTMENT')){
                 $this->loadModel("Evoucher");
                 $evoucherID = $apntmntORevchrID;
                 $this->Evoucher->bindModel(array('belongsTo'=>array('Order')));
                 $eVoucherDetail = $this->Evoucher->find('first',array('fields'=>array('Evoucher.used','Order.salon_service_id','Order.price_option_id','Order.id','Evoucher.price','Evoucher.expiry_date'),'conditions'=>array('Evoucher.id'=>$evoucherID)));
                 
                if($eVoucherDetail){
                    $pricingoption = $eVoucherDetail['Order']['price_option_id'];
                    $orderID = $eVoucherDetail['Order']['id'];
                    $this->set(compact("evoucherID","pricingoption","orderID"));
                    $eVoucher = 'true';
                }
            }
        }
           if($deal==true){
         
            $this->loadModel('Deal');
            $deal_id = !empty($deal_id) ? $deal_id : $serviceId;
          
          //$this->Session->delete('Deal.is_deal_book');
           $this->params['deal'] = true;
         
          // $this->Deal->recursive = 2;
           //$this->Deal->bindModel(array('hasMany'=>array('DealServicePackagePriceOption')));
           $dealData  = $this->Deal->find('first',
                                          array('contain'=>array('DealServicePackage'=>array('DealServicePackagePriceOption'=>array('fields'=>array('DealServicePackagePriceOption.*')))),
                                                'conditions'=>array('Deal.id'=>$deal_id),
                                                'fields'=>array('Deal.*')));
           if(!empty($dealData)){
                $blkDate = unserialize($dealData['Deal']['blackout_dates']);
                if(!empty($blkDate)){
                    foreach($blkDate as $theBk=>$bkdat){
                    $blkDate[$theBk] = date('Y-m-d',$bkdat);
                }
                }
                $dealAvailtime =  $dealData['Deal']['avail_time'];
           }else{
                $this->Session->setFlash('Invalid url.', 'flash_error');
                $this->redirect(array('controller'=>'Homes','action'=>'index'));
           }
            // pr($blkDate); die;
            //$this->set(compact('dealData','salonId'));
            if(isset($dealData['DealServicePackage'][0]['salon_service_id'])){
                  $serviceId =  $dealData['DealServicePackage'][0]['salon_service_id'];
            }
            $deal = true;
           $this->set(compact('deal','dealData'));
        }else{
            //$this->Session->delete('Deal');
        }
   
        /*if(($serviceId == NULL) || (($serviceId != NULL) && !is_numeric($serviceId))){
            $session_service_id = $this->Session->read('FRONT_SESSION.salon_service_id');
            $serviceId = $session_service_id;
            $this->Session->delete('FRONT_SESSION');
        }
        /*****************Don't remove**********/
        
        if($serviceId){
           
            $this->loadModel('SalonService');
            $serviceDetails = $this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$serviceId)));
            
            $salonId = @$serviceDetails['SalonService']['salon_id'];
           if(!empty($serviceDetails)){
                if(isset($serviceDetails['SalonServiceResource']) && count($serviceDetails['SalonServiceResource'])){
                  foreach($serviceDetails['SalonServiceResource'] as $room_id){
                   $roomId[] =  $room_id['salon_room_id'];
                  }
                  //pr($roomId);
                  //pr($serviceDetails['SalonServiceResource']);
                   
                 $this->LoadModel('SalonRoom');
                 $resources =  $this->SalonRoom->find('list' , array('conditions'=>array('SalonRoom.id'=>$roomId),'fields'=>array('SalonRoom.id','SalonRoom.eng_room_type')));
                 $this->SalonRoom->recursive = 2;
                 $resource_images =  $this->SalonRoom->find('all' , array('conditions'=>array('SalonRoom.id'=>$roomId)));
                 //pr($resource_images);
            }
             // get Advance Online Booking  limit - Date
                if($eVoucher){
                     $newDate = $eVoucherDetail['Evoucher']['expiry_date'];
                    $maxBookingLimit =  date('D M d Y H:i:s', strtotime($newDate));
                    $this->set(compact("eVoucherDetail"));
                }else{
                    $advanceBookingLimit = $this->Common->getDefaultLeadTime($salonId,'maxLimit',array('booking_limit'));
                    if($deal == true && !empty($dealAvailtime)){
                        $newDate =  strtotime($dealAvailtime);
                    }else{
                        $newDate = strtotime('+'.$advanceBookingLimit.' days');    
                    }
                    $maxBookingLimit =  date('D M d Y H:i:s', $newDate);
                }
           }else{
                $this->Session->setFlash('Invalid url.', 'flash_error');
                $this->redirect(array('controller'=>'Homes','action'=>'index'));
           }
        }else{
            $this->Session->setFlash('Invalid url.', 'flash_serror');
            $this->redirect(array('controller'=>'Homes','action'=>'index'));
        }
        $this->loadModel('PolicyDetail');
        $policyDetail = $this->PolicyDetail->find('first', array('fields'=>array('eng_cancel_appointment_policy','eng_reschedule_appointment_policy','ara_reschedule_appointment_policy','ara_cancel_appointment_policy'),'conditions' => array('user_id' => $salonId)));
        if (empty($policyDetail)) {
             $policyDetail = $this->PolicyDetail->find('first', array('fields'=>array('eng_cancel_appointment_policy','eng_reschedule_appointment_policy','ara_reschedule_appointment_policy','ara_cancel_appointment_policy'),'conditions' => array('user_id' => 1)));
        }
        $this->set('policyDetail', $policyDetail);
       
        $this->set(compact('salonId','serviceDetails','resources','reschedule','eVoucher','maxBookingLimit','blkDate'));
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
           if($deal==true){
                $this->render('show_service');
            }else{
                $this->viewPath = 'Elements/frontend/Place';
                $this->render('booking_service');    
            }
        } else {
            $this->layout = 'salon';
        }
    }

/**********************************************************************************    
  @Function Name : getStaff
  @Params	 : NULL
  @Description   : for displaying all staff available
  @Author        : Aman Gupta
  @Date          : 17-April-2015
***********************************************************************************/    
    public function getStaff($dateTimestamp = NULL ,$serviceId = NULL, $empId = NULL,$pricingLvl=NULL,$packageID = NULL){
        $this->layout = 'ajax';
        $this->loadModel('SalonService');
        $this->loadModel('User');
        $this->loadModel('PricingLevelAssigntoStaff');
        $this->SalonService->unbindModel(array('hasMany'=>array('SalonServiceImage')));
        $staffData = array();
        if($dateTimestamp){
            $serviceDetails = $this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$serviceId)));
            $staffids = array();
            $check_ses = $this->Session->read('Stylist');
            
            /************** Stylist ************/
            $searched_stylist_details = $this->Session->read('FRONT_SESSION');
            if(!empty($searched_stylist_details)){
                $searched_stylist_id = $searched_stylist_details['salon_stylist_id'];
                $this->Session->delete('FRONT_SESSION.salon_stylist_id');
                $check_ses = $searched_stylist_id;
            }
            /************** Stylist ************/
             if($check_ses){
                $empId = $check_ses;
            }
            if($empId){
                if($this->Common->checkStaff_online($empId)){
                    $staffids[] = $empId;    
                }
            }else{
                if(!empty($serviceDetails['SalonStaffService'])){
                    foreach($serviceDetails['SalonStaffService'] as $staffId){
                        if($staffId['status']){
                            if($this->Common->checkStaff_online($staffId['staff_id'])){
                                 $staffids[] = $staffId['staff_id'];
                            }
                         }
                    }
                }
            }
            
            if($pricingLvl){
                foreach($staffids as $stfkey=>$stafId){
                    $plevel = $this->PricingLevelAssigntoStaff->find('first',array('conditions'=>array('PricingLevelAssigntoStaff.user_id'=>$stafId)));
                    if($plevel['PricingLevelAssigntoStaff']['pricing_level_id'] != $pricingLvl){
                        unset($staffids[$stfkey]);
                    }
                }
            }
            $staffTimeSlots = array();
            if(!empty($staffids)){
                $this->loadModel('SalonOnlineBookingRule');
                $rules = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>$serviceDetails['SalonService']['salon_id'])));
                
                if(empty($rules)){
                    $rules = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>1)));
                }
                foreach($staffids as $staffId){
                    $staffTimeSlots[$staffId]['timeSlots'] = $this->getAvailableTimeslots($staffId,$dateTimestamp, $serviceId,$serviceDetails['SalonService']['salon_id'],$rules,$packageID);
                }
                
            }
            foreach($staffTimeSlots as $keyStaf=>$timeStaff){
                if(empty($timeStaff['timeSlots'])){
                    unset($staffTimeSlots[$keyStaf]);
                }
            }
            //pr($staffTimeSlots);
            if(!empty($staffTimeSlots)){
                foreach($staffTimeSlots as $Stfk=>$StfD){
                    $staffData[$Stfk]['timeSlots'] = $StfD['timeSlots'];
                    $this->User->unbindModel(array('hasOne'=>array('Salon','Address','Contact'),'hasMany'=>array('PricingLevelAssigntoStaff')));
                    $staffData[$Stfk]['staff'] = $this->User->find('first',array('conditions'=>array('User.id'=>$Stfk)));
                }    
            }
        }
        $this->set(compact('staffData','dateTimestamp'));
    }
    
    function getAdminTimeslots($appointmentId = NULL,$vendorID=NULL,$staffId = NULL,$dateTimestamp=NULL,$serviceId = NULL,$search='NULL'){
        $this->loadModel('Appointment');
        $appointments = $this->Appointment->find('first',array('conditions'=>array('Appointment.id'=>$appointmentId)));
        if($search!='true'){
            
            $staffId=$appointments['Appointment']['salon_staff_id'];
            $dateTimestamp= $appointments['Appointment']['appointment_start_date'];
            $dateTimestamp = date('Y-m-d' ,$dateTimestamp);
            $serviceId=$appointments['Appointment']['salon_service_id'];
        }
        $this->loadModel('SalonOnlineBookingRule');
                $rules = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>$appointments['User']['id'])));
                if(empty($rules)){
                    $rules = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>1)));
                }
                $staffTimeSlots['timeSlots'] = $this->getAvailableTimeslots($staffId,$dateTimestamp, $serviceId,$vendorID,$rules);
        return $staffTimeSlots;
    }
    
    function getSearchTimeslots($user_id=NULL,$vendorID=NULL,$staffId = NULL,$dateTimestamp=NULL,$serviceId = NULL){
        //echo $dateTimestamp; die;
        /*$this->loadModel('Appointment');
        $appointments = $this->Appointment->find('first',array('conditions'=>array('Appointment.id'=>$appointmentId)));
        if($search!='true'){
            
            $staffId=$appointments['Appointment']['salon_staff_id'];
            $dateTimestamp= $appointments['Appointment']['appointment_start_date'];
            $dateTimestamp = date('Y-m-d' ,$dateTimestamp);
            $serviceId=$appointments['Appointment']['salon_service_id'];
        }*/
        //echo $staffId; die;
                $this->loadModel('SalonOnlineBookingRule');
                $rules = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>$staffId)));
          
                if(empty($rules)){
                    $rules = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>$vendorID)));
                }
                if(empty($rules)){
                    $rules = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>1)));
                }
                      //pr($rules); die;
                $staffTimeSlots['timeSlots'] = $this->getAvailableTimeslots($staffId,$dateTimestamp, $serviceId,$vendorID,$rules);
               // pr($staffTimeSlots); die;
         return $staffTimeSlots;
    }
    
    function getAvailableTimeslots($staffId = NULL, $dateTimestamp = NULL , $serviceId = NULL,$vendorID = NULL, $rules = array(), $packageID = null){
        $this->loadModel('Appointment');
        $this->loadModel('SalonOnlineBookingRule');
        $this->loadModel('SalonOpeningHour');
        $appointmentSlots = array();
        //echo $dateTimestamp; die;
        if($dateTimestamp!='' && $serviceId!='' && $vendorID!=''){
                                $appointments = $this->Appointment->find('all',array('conditions'=>array(
                                'NOT'=>array(
                                             'Appointment.status'=>array(5,9)
                                             ),
                                'OR' => array(
                                            array(
                                                    'Appointment.salon_staff_id'=>$staffId,
                                                    //'Appointment.salon_service_id'=>$serviceId,
                                                    'Appointment.type'=>array('A','S','PAC','D'),
                                                    'Appointment.appointment_repeat_type'=>0,
                                                    'Appointment.appointment_start_date >'=>strtotime($dateTimestamp.' 00:00'),
                                                    'Appointment.appointment_start_date <= '=>strtotime($dateTimestamp.' 23:59'),
                                                ),
                                            array(
                                                    'Appointment.salon_staff_id'=>$staffId,
                                                    //'Appointment.salon_service_id'=>$serviceId,
                                                    'Appointment.type'=>array('A','S','PAC','D'),
                                                    'Appointment.appointment_repeat_type'=>array(1,2,3,4),
                                                    'Appointment.appointment_start_date <'=>strtotime($dateTimestamp.' 00:00'),
                                                    'Appointment.appointment_repeat_end_date >= '=>strtotime($dateTimestamp.' 23:59'),
                                                    
                                                ),
                                            array(
                                                    'Appointment.salon_staff_id'=>$staffId,
                                                    'Appointment.type'=>'P',
                                                    'Appointment.appointment_repeat_type'=>0,
                                                    'Appointment.appointment_start_date >'=>strtotime($dateTimestamp.' 00:00'),
                                                    'Appointment.appointment_start_date <= '=>strtotime($dateTimestamp.' 23:59'),
                                                ),
                                            array(
                                                    'Appointment.salon_staff_id'=>$staffId,
                                                    'Appointment.type'=>'P',
                                                    'Appointment.appointment_repeat_type'=>array(1,2,3,4),
                                                    'Appointment.appointment_start_date <'=>strtotime($dateTimestamp.' 00:00'),
                                                    'Appointment.appointment_repeat_end_date >= '=>strtotime($dateTimestamp.' 23:59'),
                                                    
                                                )
                                            )
                                       )));
                //pr($appointments); die;
                $openHrsStaff = $this->SalonOpeningHour->find('first',array('conditions'=>array('SalonOpeningHour.user_id'=>$staffId)));
                $from = '09:00 AM';
               $closing_time =  $to = '06:30 PM';
                if(!empty($openHrsStaff)){
                    if($openHrsStaff['SalonOpeningHour']['is_checked_disable_'.strtolower(date('D',strtotime($dateTimestamp)))]){
                        $from = $openHrsStaff['SalonOpeningHour'][strtolower(date('l',strtotime($dateTimestamp))).'_from'];
                       $closing_time =  $to = $openHrsStaff['SalonOpeningHour'][strtolower(date('l',strtotime($dateTimestamp))).'_to'];
                    }
                    else{
                        return array();
                    }
                }
                else{
                    return array();
                }
                $this->loadModel('SalonServiceDetail');
                $detailID = $serviceId;
                $type = 1;
                $packageSpaDay = array();
                if($packageID){
                    $detailID = $packageID;
                    $type = 2;
                    $this->loadModel('Package');
                    $this->Package->recursive = -1;
                    $fieldspa = array('check_in','check_out');
                    $packageSpaDay =  $this->Package->find('first', array('conditions'=>array('id'=>$packageID,'type'=>'Spaday'),'fields'=>$fieldspa));
                    //echo 'from  '.$from.'-----------to'.$to;  
                }
                $fields = array('SalonServiceDetail.appointment_lead_time');
                $leadTimeArr =  $this->SalonServiceDetail->find('first' ,array('conditions'=>array('SalonServiceDetail.associated_id'=>$detailID,'SalonServiceDetail.associated_type'=>$type),'fields'=>$fields));
                $current = date("d-m-Y");
                $leadTime = 0;
                if(isset($leadTimeArr['SalonServiceDetail']['appointment_lead_time'])){
                    $leadTime = $leadTimeArr['SalonServiceDetail']['appointment_lead_time'];
                }
                $beforelead = strtotime($from);
                 //$currentime  = strtotime('11:59 PM');
                $currentime  = strtotime(date('g:i A'));
                if($current == $dateTimestamp){
                        if($currentime <= $beforelead){
                         $from = $from;
                        }else{
                            $addTime = "+$leadTime hour";
                            $afte_lead  = $this->Common->get_roundTime($addTime);
                             //$afte_lead['new_date'];
                            if($dateTimestamp == $afte_lead['new_date']){
                                 $from = $afte_lead['from'];
                                 $newData = explode(':',$from);
                                    if(count($newData['0'])){
                                      $newData['0'] =  str_replace('00','0', $newData['0']);
                                      $from = $newData['0'].':'.$newData['1'];
                                    }
                                 $aftead = strtotime($from);
                            }else{
                               return;
                            }
                       }       
                }
               // $from = '11:45 PM';
                //$from = '005:00 PM';
                // die($from);
                $afternoon = isset($rules['SalonOnlineBookingRule']['afternoon_starts_at']) ? $rules['SalonOnlineBookingRule']['afternoon_starts_at'] : '12:00 PM';
                $evening = isset($rules['SalonOnlineBookingRule']['evening_starts_at']) ? $rules['SalonOnlineBookingRule']['evening_starts_at'] : '04:00 PM';
                
                $appointmentSlots = array();
                $timePlus = $from; $i=1;
                $morningStart = strtotime('12:00 AM');
                $morningEndAfternoonStart = strtotime($afternoon);
                $afternoonEndEveStart = strtotime($evening);
                $eveningEnd = strtotime('11:59 PM');
                 //echo $timePlus;
               // $timePlus ="12:00 PM";
               
       if(strtotime($timePlus) < strtotime($to)){
                $count = 0;
                $searchLimit = 10;
                if(!empty($rules)){
                    $searchLimit = $rules['SalonOnlineBookingRule']['search_limit'];    
                }
                if($count < $searchLimit){
                     while(strtotime($timePlus) < strtotime($to)){
                        $interval = 30;
                        if(!empty($rules)){
                            $interval = $rules['SalonOnlineBookingRule']['search_interval'];
                        }
                        //pr($rules); die;
                        $interval = $interval*$i;
                        //echo $timePlus; die;
                       // if($count < $searchLimit)
                        if(!empty($timePlus)){
                            if(strtotime($timePlus) >= $morningStart && strtotime($timePlus) < $morningEndAfternoonStart){
                               // die("tetetetete");
                                $appointmentSlots['morning'][] = $timePlus;
                                $count++;
                                //pr($appointmentSlots); die;
                          }elseif(strtotime($timePlus) < $afternoonEndEveStart && strtotime($timePlus) >= $morningEndAfternoonStart){
                                $appointmentSlots['afternoon'][] = $timePlus;
                                $count++;
                            }elseif(strtotime($timePlus) >= $afternoonEndEveStart && strtotime($timePlus) < $eveningEnd){
                                $appointmentSlots['evening'][] = $timePlus;
                                $count++;
                            }
                        }
                         //echo $from.' + '.$interval.' minutes';
                       // exit;
                        $timePlus = date('h:i A', strtotime($from.' + '.$interval.' minutes'));
                        $i++;
                    }
                }
	}
               //echo "tete";  pr($appointmentSlots); die;
            //pr($rules);
        
            if(!empty($appointments)){
                //echo "<br>:"; echo date('d-m-Y H:i:s',time());
                foreach($appointments as $appointment){
                    if($appointment['Appointment']['appointment_repeat_type'] == 0){
                        $sTime = $appointment['Appointment']['appointment_start_date'];
                        $eTime = $appointment['Appointment']['appointment_start_date']+($appointment['Appointment']['appointment_duration']*60);
                        $appointmentSlots = $this->removeTimeSlot($sTime,$eTime,$appointmentSlots,$dateTimestamp);
                    }
                    if($appointment['Appointment']['appointment_repeat_type'] == 1){
                        $sTime = $appointment['Appointment']['appointment_start_date'];
                        $eTime = $appointment['Appointment']['appointment_start_date']+($appointment['Appointment']['appointment_duration']*60);
                        $excludeDates = $appointment['Appointment']['exclude_dates'];
                        // if for excluded dates via drag drop
                        if(!empty($excludeDates)){
                            $excludeDates = array_filter(unserialize($excludeDates));
                            if(!empty($excludeDates)){
                                foreach($excludeDates as $theDateExc){
                                    if(strtotime($dateTimestamp." 00:00") < $theDateExc && $theDateExc < strtotime($dateTimestamp." 23:59")){
                                        continue;
                                    }
                                }
                            }
                        }
                        $oversTime = strtotime($dateTimestamp." ".date('H:i',$sTime));
                        $overeTime = strtotime($dateTimestamp." ".date('H:i',$eTime));
                        $appointmentSlots = $this->removeTimeSlot($oversTime,$overeTime,$appointmentSlots,$dateTimestamp);
                    }
                    if($appointment['Appointment']['appointment_repeat_type'] == 2){
                        //        week
                        //        appointment_repeat_end_date
                        //        start(15A) 17Ap end(25A)
                        //        appointment_repeat_weeks - repeat after week
                        //        appointment_repeat_day - day of week
                    }
                    if($appointment['Appointment']['appointment_repeat_type'] == 3){
                        //        mnth
                        //        appointment_repeat_end_date
                        //        appointment_repeat_month_date - date no of month
                    }
                    if($appointment['Appointment']['appointment_repeat_type'] == 4){
                        //        yr
                        //        appointment_repeat_end_date
                        //        appointment_yearly_repeat_month_date - date no for yearly
                        //        appointment_repeat_month - month to repeat yearly
                    }
                    
                }
            }
        }
        if(!empty($appointmentSlots)){
            $appointmentSlots['closing_time'] = $closing_time;
        }
        //pr($appointmentSlots); die;
        return $appointmentSlots;
    }
    
    public function removeTimeSlot($sTime = NULL,$eTime = NULL,$appointmentSlot = array(),$dateTimeStamp = NULL){
        $date = date('d-m-Y',$sTime);
        if($sTime >= strtotime($date.' 00:01') && $sTime < strtotime($date.' 12:00')){
            if(isset($appointmentSlot['morning']) && !empty($appointmentSlot['morning'])){
                foreach($appointmentSlot['morning'] as $mKey=>$mtime){
                    if($sTime <= strtotime($date.' '.$mtime) && $eTime > strtotime($date.' '.$mtime)){
                        unset($appointmentSlot['morning'][$mKey]);
                    }
                }
            }
        }
        elseif($sTime < strtotime($date.' 16:00') && $sTime >= strtotime($date.' 12:00')){
            if(isset($appointmentSlot['afternoon']) && !empty($appointmentSlot['afternoon'])){
                foreach($appointmentSlot['afternoon'] as $aKey=>$atime){
                    if($sTime <= strtotime($date.' '.$atime) && $eTime > strtotime($date.' '.$atime)){
                        unset($appointmentSlot['afternoon'][$aKey]);
                    }
                }
            }
        }elseif($sTime >= strtotime($date.' 16:00') && $sTime < strtotime($date.' 23:59')){
            if(isset($appointmentSlot['evening']) && !empty($appointmentSlot['evening'])){
                foreach($appointmentSlot['evening'] as $eKey=>$evtime){
                    if($sTime <= strtotime($date.' '.$evtime) && $eTime > strtotime($date.' '.$evtime)){
                        unset($appointmentSlot['evening'][$eKey]);
                    }
                }
            }
        }
        return $appointmentSlot;
    }
    
    
    public function appointment(){
        $this->Session->delete('point_detail'); 
        $this->Session->delete('gift_detail');
        
        if($this->Session->read('appointmentData')){
            $appointmentData = $this->Session->read('appointmentData');
        }
        if($this->request->is('post') || $this->request->is('put')){
            $appointmentData = $this->request->data;
            $this->Session->write('appointmentData',$appointmentData);
        }
        if(empty($appointmentData) && $this->Auth->user('id')){
            $this->redirect(array('controller'=>'Homes','action'=>'index'));
        }
        else{
            $id  = $this->Auth->user('id');
            if(!$id){
                $this->redirect(array('controller'=>'Homes','action'=>'index'));
            }
            $this->loadModel('SalonService');$this->loadModel('PointSetting');
            $this->loadModel('TaxCheckout');
            $this->loadModel('User');$this->loadModel('PolicyDetail');$this->loadModel('UserCount');
            $this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('SalonServiceImage','SalonStaffService','PackageService')));
            $serviceId = $appointmentData['Appointment']['service_id'];
            $serviceDetails = $this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$serviceId)));
            $serviceOwner = $this->User->findById($serviceDetails['SalonService']['salon_id']);
            $salon_id = $serviceDetails['SalonService']['salon_id'];
            /*************************************check for the frenchise user ************************************/
                if($serviceOwner['User']['parent_id'] !=0){
                   $frechiseDetail = $this->User->findById($serviceOwner['User']['parent_id']);
                       if(count($frechiseDetail)){
                            if($frechiseDetail['User']['type']==2){
                              $salon_id =  $frechiseDetail['User']['id'];
                             } 
                        }
                }  
            //$policy_detail = $this->PolicyDetail->find('first' ,array('conditions'=>array('user_id'=>$serviceDetails['SalonService']['salon_id'])));   
            $totalPoints = $this->UserCount->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'),'salon_id'=>array($salon_id,1)),'fields'=>array('(sum(UserCount.user_count)) AS total')));                           
            $totalPoints = isset($totalPoints[0][0]['total'])?$totalPoints[0][0]['total']:0; 
            $pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
            //pr($taxes);
            $ownerPolicy = $this->PolicyDetail->find('first',array('conditions'=>array('PolicyDetail.user_id'=>$serviceDetails['SalonService']['salon_id'])));
            if(count($ownerPolicy) == 0){
              $ownerPolicy = $this->PolicyDetail->find('first' ,array('conditions'=>array('user_id'=>1)));   
            }
             $taxes = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$salon_id)));
            if(count($taxes)==0){
             $taxes = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>1)));  
            }
            $this->set(compact('serviceDetails','serviceOwner','ownerPolicy','userDetail','totalPoints','pointsVal','salon_id','taxes'));
        } 
            //pr($appointmentData);
            $this->set('theData',$appointmentData);
    }
    
    public function payment($service_id=NULL,$user_id=NULL ,$type=NULL){
                   //pr(this->Session->read('appointmentData')); die;
                    if(!$this->Session->read('appointmentData')){
			$this->Session->setFlash('Unauthorized Access.', 'flash_success');
			$this->redirect(array('controller'=>'homes','action'=>'index'));
		    }
                    $order_status_val = '';	
                    $order_status="";
                    $tracking_id = '';
                    $amount = '';
                    $gift_id ='';
                    $point_given = '';
                    $status_message ='';
                    $point_used_status = false;
                    $gift_used_status = false;
                    $orignal_amount = 0;
                    $point_used = 0;
                    $ser_sell_price = 0;
                    $gift_amount_used = $ser_full_price = 0;
                    $this->loadModel('GiftCertificate');
                    $this->loadModel('OrderDetail');
                     if($service_id && $user_id){
                        $service_id = $service_id;
                        $user_id = $user_id;
                        //		 	$gift_detail  = $this->Session->read('gift_detail');
                        //                        if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                        //                           //pr($this->request->data); 
                        //                            $this->GiftCertificate->recursive = -1;
                        //                            $gift_amount  = $this->GiftCertificate->findById($gift_detail['point']['use_gift_id']);               
                        //                            //$amount =   
                        //                        }
                        if($type=='points'){
                            $total_points = $this->request->data['Points']['total_points'];
                            $redeem_points = $this->request->data['Points']['points_redeem'];
                            $point_left = $total_points - $redeem_points;
                            $point_used = $redeem_points;
                            $amount = 0;
                            $order_status = 'points';
                            $status_message = 'purchase by points';
                            }else if($type=='payment'){
                                       $amount = $this->request->data['Appointment']['amount'];
                                       $status_message = 'before payment'; 
                                       $order_status = 'payment';
                            }else if($type=='gift'){
                                 $gift_detail  = $this->Session->read('gift_detail');
                                 if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                                    $this->GiftCertificate->recursive = -1;
                                    $giftDetail = $this->GiftCertificate->find('first' ,array('conditions'=>array('GiftCertificate.id'=>$gift_detail['point']['use_gift_id']),'fields'=>array('amount')));
                                    $gift_amount = $giftDetail['GiftCertificate']['amount'];
                                    $service_amount = $this->request->data['Points']['amnt'];
                                    $amount_left = $gift_amount - $service_amount;
                                    if($amount_left > 0){
                                        $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $gift_recipient['GiftCertificate']['amount']  = $amount_left;
                                        $gift_recipient['GiftCertificate']['recipient_id'] = $this->Auth->user('id');
                                        $this->GiftCertificate->save($gift_recipient , false);
                                    }else{
                                        $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $gift_recipient['GiftCertificate']['is_used']  = 1;
                                        $gift_recipient['GiftCertificate']['recipient_id'] = $this->Auth->user('id');
                                        $this->GiftCertificate->save($gift_recipient , false);
                                    }
                                    $amount = 0;
                                    $order_status = 'gift';
                                    $gift_amount_used = $service_amount;
                                    $gift_id = $gift_detail['point']['use_gift_id'];
                                    $status_message = 'purchase by gift card';
                                 } 
                            }else{
                                $workingKey=Configure::read('working_key'); 	//Working Key should be provided here.
                                $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
                                $rcvdString=$this->Crypto->decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.			
                                $order_status_val = '';	
                                $order_status="";
                                $tracking_id = '';
                                $amount = '';
                                $decryptValues=explode('&', $rcvdString);
                                $dataSize=sizeof($decryptValues);
                                for($i = 0; $i < $dataSize; $i++) 
                                {
                                    $information=explode('=',$decryptValues[$i]);
                                    if($i==0)	{ $order_id = $information[1]; }
                                    if($i==3)	{ $order_status=$information[1]; }
                                    if($i==1)	{ $tracking_id=$information[1]; }
                                    if($i==10)	{ $amount=$information[1]; }
                                    if($i==8)	{ $status_message=$information[1]; }
                                }
                                //$order_status  ='Success';
                                $gift_detail =  $this->Session->read('gift_detail');
                                $point_detail  = $this->Session->read('point_detail');
                                if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                                        $gift_amount_used = $this->Common->get_gift_amount($gift_detail['point']['use_gift_id']);
                                        $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $gift_recipient['GiftCertificate']['is_used']  = 1;
                                        $gift_recipient['GiftCertificate']['recipient_id'] = $this->Auth->user('id');
                                        $this->GiftCertificate->save($gift_recipient , false);
                                        $gift_id = $gift_detail['point']['use_gift_id'];
                                        $gift_used_status = true;
                                } 
                                if(isset($point_detail['point']['is_used_point']) && $point_detail['point']['is_used_point']=='1'){
                                    $used_points = $point_detail['point']['used_point'];
                                    $point_left = 0;
                                    $point_used = $used_points;
                                    $point_used_status = true;
                                }
                        }
    			if($order_status)
			{
	/*******************************Appointment Details***********************************************************/
                         $appointment_status = ($order_status==="Success")?4:5;
                            if($order_status==="Success")
                            {
                             $appointment_status  =4;
                             $order_status_val = 1;   
                            }else if($order_status==="Aborted")
                            {
                                $order_status_val = 2;
                                $appointment_status  =5;
                            }
                            else if($order_status==="Failure")
                            {
                               $order_status_val = 3;
                               $appointment_status  =5;
                            }
                            else if($order_status==="points")
                            {
                              $order_status_val = 5;
                              $appointment_status  =4;
                            }else if($order_status==="gift")
                            {
                              $order_status_val = 6;
                              $appointment_status  = 4;
                            }else if($order_status==="payment")
                            {
                              $order_status_val = 9;
                              $appointment_status  = 5;
                            }else{
                              $order_status_val = 5;       
                            } 
                        $this->loadModel('SalonService'); $this->loadModel('UserCount'); $this->loadModel('UserPoint');
                        $this->loadModel('Appointment');$this->loadModel('Order');
                        $this->loadModel('User');$this->loadModel('PolicyDetail');
                        $this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('SalonServiceImage','SalonStaffService','PackageService')));
                        $serviceId = $service_id;
                        $serviceDetails = $this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$serviceId)));
                        $serviceOwner = $this->User->findById($serviceDetails['SalonService']['salon_id']);
                        //$salon_id = 
                       // pr($serviceDetails);
                        $appointment_detail = $this->Session->read('appointmentData.Appointment');
                        //pr($appointment_detail);
                        foreach($serviceDetails['ServicePricingOption'] as $priceOpt){
                              if($priceOpt['id'] == $appointment_detail['price_id']){
                                 $duration = $priceOpt['duration'];
                                 $point_given = $priceOpt['points_given'];
                                 $point_redeem = $priceOpt['points_redeem'];
                                 $orignal_amount =  ($priceOpt['sell_price'])? $priceOpt['sell_price'] :$priceOpt['full_price'];
                                 $ser_sell_price = $priceOpt['sell_price'];
                                 $ser_full_price = $priceOpt['full_price'];
                               }
                         }
                         $tax_data  = $this->Common->get_vendor_dues($orignal_amount,$serviceDetails['SalonService']['salon_id'],$serviceOwner['User']['discount_percentage']);
                        /*************************************************************************************/
                        //echo $order_status;
                         if($order_status == 'payment' || $order_status == 'gift' || $order_status==="points"){
                              $order['Order']['first_name'] = $this->request->data['Appointment']['first_name'];     
                              $order['Order']['last_name'] = $this->request->data['Appointment']['last_name'];
                              $phone_code =  str_replace('+','',$this->request->data['Appointment']['country_code']);
                              $order['Order']['phone_number'] = $phone_code.$this->request->data['Appointment']['billing_tel'];    
                              unset($this->request->data['Appointment']['country_code']);
                              //pr($order);
                          }
                         $order['Order']['transaction_id'] = $tracking_id;     
                         $order['Order']['user_id'] = $user_id;
                         $order['Order']['employee_id'] =$appointment_detail['selected_employee_id'];
                         $order['Order']['salon_service_id'] = $serviceId;
                         $order['Order']['price_option_id'] =$appointment_detail['price_id'];
                         $order['Order']['points_used'] =$point_used;
                          //$point_used_status = false;
                         //$gift_used_status = false;
                         if($point_used_status || $gift_used_status){
                          $order['Order']['transaction_status'] = ($point_used_status)?8:7; 
                         }else{
                           $order['Order']['transaction_status'] = $order_status_val; 
                         }
                         $order['Order']['duration'] = $duration;
                         $order['Order']['start_date'] = date('Y-m-d',strtotime($appointment_detail['selected_date']));
                         $order['Order']['time'] =$appointment_detail['selected_time'];
                         $display_order_id = $this->Common->getRandPass(10);
                         $order['Order']['display_order_id'] = $display_order_id;
                         $order['Order']['amount'] = $amount;
                         $order['Order']['orignal_amount'] = $orignal_amount;
                         $order['Order']['transaction_message'] = $status_message;
                         $order['Order']['eng_service_name'] = $serviceDetails['SalonService']['eng_name'];
                         $order['Order']['ara_service_name'] = $serviceDetails['SalonService']['ara_name'];
                         $order['Order']['gift_amount'] = $gift_amount_used;
                         $order['Order']['points_given'] = $point_given;
                         $order['Order']['points_redeem'] = $point_redeem;
                         $order['Order']['used_gift_id'] = $gift_id;
                         $order['Order']['sell_price'] = $ser_sell_price;
                         $order['Order']['full_price'] = $ser_full_price;
                         $order['Order']['service_price_with_tax'] = $tax_data['service_price_with_tax'];
                         $order['Order']['deduction1'] =$tax_data['tax_admin']['TaxCheckout']['deduction1'];
                         $order['Order']['deduction2'] = $tax_data['tax_admin']['TaxCheckout']['deduction2'];
                         $order['Order']['sieasta_commision'] = $tax_data['sieasta_comission_price'];
                         $order['Order']['total_deductions'] = $tax_data['total_deductions'];
                         $order['Order']['vendor_dues'] = $tax_data['vendors_dues'];
                         $order['Order']['tax1'] = $tax_data['tax_vendor']['TaxCheckout']['tax1'];
                         $order['Order']['tax2'] = $tax_data['tax_vendor']['TaxCheckout']['tax2'];
                         $order['Order']['salon_id'] = $serviceDetails['SalonService']['salon_id'];
                         $order['Order']['tax_amount'] = $tax_data['tax_amount'];
                         $order['Order']['sieasta_commision_amount'] = $tax_data['sieasta_comission'];
                         $order['Order']['saloon_discount'] = $serviceOwner['User']['discount_percentage'];
                         $order['Order']['is_admin_tax'] = $tax_data['is_admin_tax'];
                         $order['Order']['tax1_amount'] = $tax_data['tax1_amount'];
                         if($order_status=='Success'|| $order_status==="Aborted" || $order_status==="Aborted"){
                          $this->Order->id = $order_id;  
                         }
                    if($this->Common->add_customer_to_salon($user_id,$serviceDetails['SalonService']['salon_id'])){
                    if($this->Order->save($order , false)){
                                   //$this->Common->add_customer_to_salon($user_id,$serviceDetails['SalonService']['salon_id']);
                                   if($order_status=='Success'){
                                        $this->Order->id = $order_id;  
                                   }else{
                                        $order_id = $this->Order->id;
                                   }
                                if($order_status !="payment"){
                                   // $this->request->data['Appointment']['time'] = $appointment_detail['selected_time'];
                                    $this->request->data['Appointment']['order_id'] = $order_id;
                                    $this->request->data['Appointment']['salon_service_id'] = $serviceDetails['SalonService']['id'];
                                    $this->request->data['Appointment']['salon_staff_id'] =$appointment_detail['selected_employee_id'];
                                    $this->request->data['Appointment']['appointment_title']=$serviceDetails['SalonService']['eng_name'];
                                    $this->request->data['Appointment']['appointment_price'] = $appointment_detail['price'];
                                    $this->request->data['Appointment']['appointment_duration'] = $duration;
                                    $this->request->data['Appointment']['user_id']=$user_id;
                                    $this->request->data['Appointment']['appointment_price']=$orignal_amount;
                                    $this->request->data['Appointment']['appointment_created']=date('Y-m-d h:i:s');
                                    $this->request->data['Appointment']['appointment_repeat_type'] = 0;
                                    $this->request->data['Appointment']['startdate'] = $appointment_detail['selected_date'];
                                    $this->request->data['Appointment']['appointment_start_date']= strtotime($appointment_detail['selected_date'].' '.$appointment_detail['selected_time']);
                                    $this->request->data['Appointment']['type'] = 'A';
                                    $this->request->data['Appointment']['appointment_return_request'] = 'NR';
                                    $this->request->data['Appointment']['status'] = $appointment_status;
                                    $this->request->data['Appointment']['payment_status'] = 2;
                                    $this->request->data['Appointment']['salon_id'] = $serviceDetails['SalonService']['salon_id'];
                                    $this->Appointment->save($this->request->data['Appointment'],false);
                                    $apppintment_id = $this->Appointment->id;
                                    $historyData = '';
				    $historyData['appointment_id'] = $apppintment_id;
				    $historyData['appointment_date'] = strtotime($appointment_detail['selected_date'].' '.$appointment_detail['selected_time']);
				    $historyData['duration'] = $duration;
				    $historyData['service_name'] = $serviceDetails['SalonService']['eng_name'];
				    $historyData['staff_id'] = $appointment_detail['selected_employee_id'];
				    $historyData['modified_by'] = $this->Auth->User('id');
				    $historyData['modified_date'] = strtotime(date('Y-m-d h:m:s'));
				    $historyData['order_id'] = $order_id; 
				    $historyData['status'] = 'Paid';
                                    $historyData['type'] = 'service';
				    $historyData['action'] = 'Appointment Booked for Service';
				    $this->create_appointment_history($historyData);
                                    
                                }
                      /********************* points add to user_counts table && user table ********/
                        if($order_status==="Success" || $order_status==="points" || $order_status==="gift")
                        {
                                foreach($serviceDetails['ServicePricingOption'] as $priceOpt){
                                    if($priceOpt['id'] == $appointment_detail['price_id']){
                                       $point_given = $priceOpt['points_given'];
                                       $point_redeem = $priceOpt['points_redeem'];
                                       $orignal_amount =  ($priceOpt['sell_price'])? $priceOpt['sell_price'] :$priceOpt['full_price'];
                                       $ser_sell_price = $priceOpt['sell_price'];
                                       $ser_full_price = $priceOpt['full_price'];
                                       $duration = $priceOpt['duration'];
                                    }
                                } 
                                 $salon_id = $serviceDetails['SalonService']['salon_id'];
                       /**************************redeem points********************************************/         
                               
                                 if(isset($point_used) && !empty($point_used)){
                                    $user_count['UserPoint']['points_deducted'] = $point_used;
                                    $user_count['UserPoint']['salon_id'] = $serviceDetails['SalonService']['salon_id']; 
                                    $user_count['UserPoint']['user_id'] = $user_id;                                  
                                    $user_count['UserPoint']['order_id'] = $order_id;
                                    $user_count['UserPoint']['type'] = 1; 
                                    $this->UserPoint->create();
                                    $this->UserPoint->save($user_count , false);
                                    $user_point_id = $this->UserPoint->id;
                                 /*********************** total redeem points **************/
                                      $salon_id = $serviceDetails['SalonService']['salon_id'];
                                      $points  = array();
                                      $points['user_id'] = $user_id;
                                      $points['salon_id'] = $salon_id;
                                      $points['used_points'] = $point_used;
                                      $points['user_point_id'] = $user_point_id;
                                      $points['order_id'] = $order_id;
                                      $this->redeem_points($points);
                                 }
                             // pr($this->request->data); die;    
                        /***************************************************************************/        
                            if(!empty($point_given)){
                                  $user_counts['UserPoint']['point_given'] = $point_given;
                                  $user_counts['UserPoint']['salon_id'] = $serviceDetails['SalonService']['salon_id']; 
                                  $user_counts['UserPoint']['user_id'] = $user_id;                                  
                                  $user_counts['UserPoint']['order_id'] = $order_id;
                                  $this->UserPoint->create();
                                   if($this->UserPoint->save($user_counts , false)){
                                     $salon_id = $serviceDetails['SalonService']['salon_id'];
                                     $salon_type  ='individual';
                                      if($serviceOwner['User']['parent_id'] !=0){
                                        $this->User->recursive = -1;
                                        $frechiseDetail = $this->User->findById($serviceOwner['User']['parent_id']);
                                            if(count($frechiseDetail)){
                                                 if($frechiseDetail['User']['type']==2){
                                                    $frenchise_id =  $frechiseDetail['User']['id'];
                                                    $salon_type  ='frenchise';
                                                  } 
                                             }
                                       }
                                      $salonOrfrnchisId = (isset($frenchise_id))?$frenchise_id:$salon_id;
                                      $userCount = $this->UserCount->find('first' , array('conditions'=>array('user_id'=>$user_id , 'salon_id'=>$salonOrfrnchisId),'fields'=>array('id','user_count')));
                                        if(count($userCount)){
                                         $userTotalCount  = $userCount['UserCount']['user_count']+$point_given; 
                                         $totalPoints['UserCount']['user_count'] = $userTotalCount;
                                         $this->UserCount->id = $userCount['UserCount']['id'];
                                        }else{
                                         $totalPoints['UserCount']['user_count'] = $point_given;
                                         $this->UserCount->create();
                                        }
                                        $totalPoints['UserCount']['salon_id'] = $salonOrfrnchisId;
                                        $totalPoints['UserCount']['user_id'] = $user_id;
                                        $totalPoints['UserCount']['salon_type'] = $salon_type;
                                        $this->UserCount->save($totalPoints , false);
                                    }
                            }
                                /***************************sieasta points*******************************/
                                $Detail = array();
                                $Detail['amount'] = $orignal_amount;
                                $Detail['user_id'] = $user_id;
                                $Detail['order_id'] = $order_id;
                                $this->siesta_points($Detail);
                                /************gift card points given ******************/
                          }
                          /************Tax and Deductions sadd in order ******************/
                                if($order_status==="gift" && isset($amount_left) && $amount_left > 0){
                                    $this->loadModel('GiftDetail');
                                    $giftDetail['amount_used'] = $service_amount;
                                    $giftDetail['order_id'] = $order_id;
                                    $giftDetail['gift_id'] = $gift_id;
                                    $this->GiftDetail->save($giftDetail , false);
                                }   
                                $this->User->recursive = 2;
                                $userDetail = $this->User->find('first' , array('conditions'=>array('User.id'=>$user_id)));
                                if($order_status !='payment'){ 
                                 if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
                                    if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
                                                $ret_provider_status =  $this->Common->EmailTemplateType($serviceDetails['SalonService']['salon_id']);
                                                $this->User->recursive = 2;
                                                $employeeDetail = $this->User->findById($appointment_detail['selected_employee_id']);
                                                if($ret_provider_status['SalonEmailSms']['business_sms_notify_provider']==1){
                                                    $this->sendUserPhone($employeeDetail, $serviceDetails,$display_order_id ,$amount ,'vendor',$duration);
                                                }
                                                if($ret_provider_status['SalonEmailSms']['business_nofity_provider']==1){
                                                   $this->sendUserEmail($employeeDetail, $serviceDetails,$display_order_id ,$amount ,'new_appointment',$duration,'vendor');
                                                }   
                                        $service_salon_id = $serviceDetails['SalonService']['salon_id'];
                                        $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$service_salon_id,'User.id'=>$service_salon_id))));
                                            foreach($SalonBookingIncharges as $incharge){
                                                   if($incharge['UserDetail']['booking_incharge']==1){
                                                        $this->sendUserEmail($incharge, $serviceDetails,$display_order_id ,$amount ,'new_appointment',$duration,'vendor','incharge');
                                                        $this->sendUserPhone($incharge, $serviceDetails,$display_order_id ,$amount ,'vendor',$duration);
                                                    }
                                            }
                                      }  
                                }
                                 if($order_status==="Success" || $order_status==="points" || $order_status==="gift")
                                {
                                    $this->sendUserEmail($userDetail, $serviceDetails,$display_order_id ,$amount ,'confirmation_appointment',$duration);
                                            $appointment_detail = $this->Session->read('appointmentData.Appointment');
                                            $date = $appointment_detail['selected_date'];
                                            $time = $appointment_detail['selected_time'];
                                            $service_name = $serviceDetails['SalonService']['eng_name'];
                                            $salonName = $serviceOwner['Salon']['eng_name'];
                                            $country_code = ($serviceOwner['Contact']['country_code'])?$serviceOwner['Contact']['country_code']:'+971';
                                             $Contact_no = '';
                                             if(!empty($serviceOwner['Contact']['day_phone'])){
                                                    $Contact_no  = $serviceOwner['Contact']['country_code'].' '.$serviceOwner['Contact']['day_phone'];    
                                                }
                                           
                                            $empName = $this->Common->employeeName($appointment_detail['selected_employee_id'] ,1);
                                            
                                            $orderData = $this->Common->get_Order($order_id); 
                                            $display_order_id = @$orderData ['Order']['display_order_id'];
                                            $message = "Your appointment is on $date  $time $service_name with $empName is confirmed. See you soon $salonName --$Contact_no . Your order id is $display_order_id"; 
                                        $this->Common->sendUserPhone($userDetail, $orderData , $message ,'customer');
                                        $this->Session->delete('appointmentData');
                                        $this->Session->setFlash('Your appointment has been booked successfully.', 'flash_success');
                                        $this->redirect(array('controller'=>'Myaccount','action'=>'appointments'));
                                }else{
                                    $this->sendUserEmail($userDetail, $serviceDetails,$order_id ,$amount ,'declined_appointment');
                                    $this->Session->setFlash('Your  transaction has been declined.Please try again to book appointment.', 'flash_error');
                                    $this->redirect(array('controller'=>'homes','action'=>'index')); 
                                }
                             }else{
                                if($this->request->is('post') || $this->request->is('put')){
                                    //echo '<pre>';  print_r($this->request->data);  die('herere');
                                    $this->request->data['Appointment']['order_id'] = $order_id;
                                    $working_key=Configure::read('working_key');  //Shared by CCAVENUES
                                    $access_code =Configure::read('access_code');  //Shared by CCAVENUES
                                    $merchant_data =  '';
                                    foreach ($this->request->data['Appointment'] as $key => $value){
                                     $merchant_data.=$key.'='.$value.'&';
                                    }
                                    //echo $merchant_data; 
                                    $encrypted_data = $this->Crypto->encrypt($merchant_data,$working_key);
                                    //echo $encrypted_data;
                                    $this->set(compact('encrypted_data','access_code'));
                                }
                            } 
                        }else{
                                    $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                                    $this->redirect(array('controller'=>'homes','action'=>'index'));  
                              }
                        }else{
                                $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                                $this->redirect(array('controller'=>'homes','action'=>'index'));  
                            }
                        }
                         }else{
                           $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                           $this->redirect(array('controller'=>'homes','action'=>'index'));  
                         }
    }
		   
      
    function sendUserEmail($userData=array() , $serviceDetail = array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL ,$provider_type=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;
        $service_name = $serviceDetail['SalonService']['eng_name'];
        $appointment_detail = $this->Session->read('appointmentData.Appointment');
        $date = $appointment_detail['selected_date'];
        $time = $appointment_detail['selected_time'];
        $employee_id   =   $appointment_detail['selected_employee_id'];
        
        $vendor_msg = $this->Common->get_vendor_message(@$serviceDetail['SalonService']['salon_id']);
        
        $dynamicVariables = array(
                    '{FirstName}'=> $firstName,
                    '{LastName}' => $lastName,
                    '{amount}' => $amount,
                    '{time}'=> $time,
                    '{start_date}'=>$date,
                    '{service_name}'=>$service_name,
                    '{order_id}'=>$order_id,
                    '{vendor_message}' => $vendor_msg
                 );
        if($template =='confirmation_appointment'){
            
            $employee_name =   $this->Common->employeeName($employee_id);
            $salonDetail   =   $this->Common->salonDetail($serviceDetail['SalonService']['salon_id']); 
            $dynamicVariables['{service_provider}'] = $employee_name['User']['first_name'].' '.$employee_name['User']['last_name'];
            $dynamicVariables['{Salon}'] = $salonDetail['Salon']['eng_name'];
            $contact = '';
            if(!empty($salonDetail['Contact']['day_phone'])){
              $contact =  $salonDetail['Contact']['country_code'].' '.$salonDetail['Contact']['day_phone'];    
            }
            
            $dynamicVariables['{salon_contact_number}'] = $contact;
            /**************Points varibale is set as duration****************/
            $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($points); 
        }
        if($type=='gift'){
         $dynamicVariables['{gift_amount}'] = $points;   
        }else if($type=='points'){
          $dynamicVariables['{point}'] = $points;      
        }else if($type=='vendor'){
          $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($points);   
        }
        if($provider_type=='incharge'){
         $employee_name =   $this->Common->employeeName($employee_id,1);
         $dynamicVariables['{service_name}']= $service_name .' with service provider '.$employee_name; 
        }
        $template_type =  $this->Common->EmailTemplateType($serviceDetail['SalonService']['salon_id']);
        if($template_type){
          $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
        }
        //pr($dynamicVariables);
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
    function sendUserPhone($getData=array(), $serviceDetail = array(), $order_id=null ,$amount = null , $type=null , $duration=null){
            $this->loadModel('User');
            $firstName = $getData['User']['first_name'];
            $lastName = $getData['User']['last_name'];
            $appointment_detail = $this->Session->read('appointmentData.Appointment');
            $date = $appointment_detail['selected_date'];
            $time = $appointment_detail['selected_time'];
            $order_id = $order_id;
            $service_name = $serviceDetail['SalonService']['eng_name'];
            if($getData){
                   if($type=='vendor'){
                          $message = "You have new  appointment for the Service  $service_name  on date : $date $time";  
                        }else{
                         
                          $message = "Your appointment for the Service  $service_name has been confirmed with us on date : $date $time";  
                    }
                    $number =  $getData['Contact']['cell_phone'];
                    $country_id = $getData['Address']['country_id'];
                    if($country_id){
                     $country_code  =   $this->Common->getPhoneCode($country_id);
                        if($country_code){
                           $number = str_replace("+","",$country_code).$number;    
                        }else{
                          $country_code = '+971';
                          $number = str_replace("+","",$country_code).$number;    
                        }
                    }
                    $this->Common->sendVerificationCode($message,$number);
            }
        return true;
    }
    
     function cancel_booking($service_id,$user_id){
	     		  if($service_id && $user_id){
			 	$workingKey=Configure::read('working_key'); 	//Working Key should be provided here.
				$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
				$rcvdString=$this->Crypto->decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.
				$order_status="";
				$decryptValues=explode('&', $rcvdString);
				$dataSize=sizeof($decryptValues);
				echo "<center>";
				for($i = 0; $i < $dataSize; $i++) 
				{
					$information=explode('=',$decryptValues[$i]);
					if($i==3)	echo $order_status=$information[1];
				}
                                for($i = 0; $i < $dataSize; $i++) 
				{
					$information=explode('=',$decryptValues[$i]);
				    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
				}
				print_r($decryptValues);
				 die; 
			}         
		die;  
    }
    
   public function response_booking($service_id,$user_id){
        $workingKey=Configure::read('working_key'); 	          //Working Key should be provided here.
	$encResponse=$_POST["encResp"];			         //This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";
	for($i = 0; $i < $dataSize; $i++) 
	{
            $information=explode('=',$decryptValues[$i]);
            if($i==3)	$order_status=$information[1];
	}
        pr($decryptValues);
        die; 
    } 
    
    function check_phone(){
       $phone = $this->request->data['phone'];
       $user_id  = $this->request->data['id'];
        if(empty($phone)){
            echo 'blank';
            die;
        }else{
            $this->loadModel('User');
            $this->loadModel('Contact');
            $getData  = $this->User->findById($user_id);
            if(!empty($phone)){
                $phone_token = strtoupper($this->Common->getRandPass(5));
                    if($getData['Contact']['id']){
                      $this->Contact->id =  $getData['Contact']['id']; 
                    }else{
                       $this->Contact->create(); 
                    }
                    $data['Contact']['user_id']  =$user_id;
                    $data['Contact']['cell_phone']  =$phone;
                    $this->Contact->save($data ,false);
                    $this->User->updateAll(array('User.phone_token' => "'" . $phone_token . "'",'User.is_phone_verified'=>0), array(
                           'User.id' => $user_id,
                       ));
                    $message = "Your one time (OTP) phone verification code is " .$phone_token. " Kindly verify your phone number!!";  
                        $number =  $phone;
                        $country_id = $getData['Address']['country_id'];
                        if($country_id){
                         $country_code  =   $this->Common->getPhoneCode($country_id);
                         }else{
                           $country_code = '+971'; 
                         }
                        if($country_code){
                           $number = str_replace("+","",$country_code).$number;    
                        }
                $this->Common->sendVerificationCode($message,$number);
                echo 'verification_sent';
                die;
           }
       }
       die;
     }
    
    function set_point(){
      if($this->request->data['type']=='gift'){
          $data['point']['is_used_gift'] = $this->request->data['is_usedpoint'];
          $data['point']['use_gift_id'] = $this->request->data['use_gift_id'];
          $this->Session->write('gift_detail',$data);
      }else{
          $data['point']['is_used_point'] = $this->request->data['is_usedpoint'];
          $data['point']['used_point'] = $this->request->data['use_point'];
          $this->Session->write('point_detail',$data);
      }
      die;
    }
    
    function check_giftcard(){
      $this->autoRender = false;
      $email  =$this->Auth->user('email');
      $gift_code = $this->request->data('gift_code');
      $this->loadModel('GiftCertificate');
      $today = date('y-m-d');
      //pr($this->request->data); die;
      $salon_id = $this->request->data['owner_salon_id'];
      $conditions = array('gift_certificate_no'=>$gift_code ,'is_used'=>0,'payment_status'=>array(1,4));
      //if($this->request->data['is_accept_siesta']=='1'){
      $conditions['salon_id'] = array(0,1, $salon_id);
        //$con['or'] = array('salon_id'=>$id , 'fdsf');
      //}else{
         //$conditions['salon_id'] = $salon_id;
      //}
      $conditions['recipient_id'] = array(0,$this->Auth->user('id'));
      $this->GiftCertificate->recursive  =-1;
      $data  = $this->GiftCertificate->find('first',array('conditions'=>$conditions));
     if(count($data)>0){
      if($this->request->data['is_accept_siesta'] !='1'){
            if($data['GiftCertificate']['salon_id']==0 || $data['GiftCertificate']['salon_id']==1){
               echo 'not_accept_sieasta';
               die;
            }
         }
        if($data['GiftCertificate']['is_online'] == 0){
            echo 'offline';
            die;
        }
        if($data['GiftCertificate']['expire_on'] !='0000-00-00'){
            if($today > $data['GiftCertificate']['expire_on']){
              echo 'expired';
              die;
            }
        }
        
         echo json_encode($data['GiftCertificate']); 
      }else{
        echo 'invalid';
      }
    }
    
    function clear_cart(){
        $this->Session->delete('point_detail'); 
        $this->Session->delete('gift_detail');
        die;
    }
    
    function siesta_points($Detail=array()){
        $this->autoRender = false;
        $this->loadModel('PointSetting');
        $this->loadModel('UserCount');
        $pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
        $per_aed =   $pointsVal['PointSetting']['siesta_point_given'];   
        $siesta_point =  $per_aed*$Detail['amount'];
        $this->loadModel('UserPoint');
        $user_detail['UserPoint']['user_id']  =    $Detail['user_id'];
        $user_detail['UserPoint']['point_given']  = $siesta_point;
        $user_detail['UserPoint']['order_id']  =$Detail['order_id'];
        $user_detail['UserPoint']['salon_id']  =   1;
        $user_detail['UserPoint']['points_given_by']  =   'admin';
        $this->UserPoint->create();
        $this->UserPoint->save($user_detail , false);
        $sieasta_points = $this->UserCount->find('first' , array('conditions'=>array('user_id'=> $Detail['user_id'] ,'salon_id'=>1)));
        if(count($sieasta_points) > 0){
            $old = $sieasta_points['UserCount']['user_count'];
            $user_count['UserCount']['user_count'] = $old+$siesta_point;
            $user_count['UserCount']['id'] = $sieasta_points['UserCount']['id'];
         }else{
           $user_count['UserCount']['user_count'] = $siesta_point; 
           $this->UserCount->create(); 
        }
        $user_count['UserCount']['user_id']  = $Detail['user_id'];
        $user_count['UserCount']['salon_id']  = 1;
        $user_count['UserCount']['salon_type']  = 'admin';
        $this->UserCount->save($user_count , false);
        return true;
     }
    
    function redeem_points($points=array()){
           $this->autoRender = false;
           $this->LoadModel('UserCount');
                //$points['user_id'] = 2;
               //$points['salon_id'] = 20;
              //$points['used_points'] = 1000; 
            $vendorCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>$points['salon_id'])));
                if(count($vendorCounts)>0){
                        $user_points = $vendorCounts['UserCount']['user_count'];
                        if($user_points > $points['used_points']){
                            $points_left = $user_points-$points['used_points'];
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,$points_left);
                            
                            $points['salon_point'] = $points['used_points'];
                            $points['sieasta_point'] = 0;
                            $this->Common->update_user_point($points);
                            return true;
                        }else if($user_points == $points['used_points']){
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,0);
                            
                            $points['salon_point'] = $points['used_points'];
                            $points['sieasta_point'] = 0;
                            $this->Common->update_user_point($points);
                            return true;   
                        }else if($user_points < $points['used_points']){
                            $points_left = $points['used_points']-$user_points;
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,0);
                            $adminCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>1)));
                                if(count($adminCounts)>0){
                                  $adminPoints = $adminCounts['UserCount']['user_count'];
                                  $admin_left = $adminPoints-$points_left;
                                  $this->UserCount->id = $adminCounts['UserCount']['id'];
                                  $this->UserCount->saveField('user_count' ,$admin_left);
                                }
                                $points['salon_point'] = $user_points;
                                $points['sieasta_point'] = $points_left;
                                $this->Common->update_user_point($points);    
                           return true;
                      }
                }else{
                    $adminCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>1)));
                    if(count($adminCounts)>0){
                          $adminPoints = $adminCounts['UserCount']['user_count'];
                          $admin_left = $adminPoints-$points['used_points'];
                          $this->UserCount->id = $adminCounts['UserCount']['id'];
                          $this->UserCount->saveField('user_count' ,$admin_left);
                          $points['salon_point'] = 0;
                          $points['sieasta_point'] = $points['used_points'];
                          $this->Common->update_user_point($points); 
                        }
                      return true;
                    }   
           }
           
        function addGiftPoints($giftDetail=array()){
            $amount = $giftDetail['amount'];
            $user_id = $giftDetail['user_id'];
            $slaon_id = $giftDetail['salon_id'];
            $frenchiseOrsalon_id = $giftDetail['frenchise_id'];
            $appointment_id = $giftDetail['appointment_id'];
            $salon_type = $giftDetail['salon_type'];
            $this->loadModel('PointSetting');  $this->loadModel('PointSetting'); $this->loadModel('PointSetting');
            $pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
            $point_given =   $pointsVal['PointSetting']['aed_unit']*$amount;
                $userPoint['UserPoint']['salon_id'] = $slaon_id;
                $userPoint['UserPoint']['user_id'] = $user_id;
                $userPoint['UserPoint']['appointment_id'] = $appointment_id;
                $userPoint['UserPoint']['point_given'] = $point_given;   
                $userPoint['UserPoint']['points_given_by'] = 'gift';
                $this->UserPoint->create();
                $this->UserPoint->save($userPoint , false);
                /*****************************************************************************/
                //check frnchise
                /*****************************************************************************/
                $users_points = $this->UserCount->find('first' , array('conditions'=>array('user_id'=>$user_id,'salon_id'=>$frenchiseOrsalon_id)));
                if(count($users_points)>0){
                   $points = $users_points['UserCount']['user_count'];
                   $total_point = $points+$point_given; 
                   $this->UserCount->id = $users_points['UserCount']['id'];
                   $this->UserCount->saveField('user_count' ,$total_point);
                }else{
                    $user_count['UserCount']['user_count']  =   $point_given; 
                    $user_count['UserCount']['user_id']     =   $user_id;
                    $user_count['UserCount']['salon_id']    =   $frenchiseOrsalon_id;
                    $user_count['UserCount']['salon_type']  =   $salon_type;
                    $this->UserCount->create(); 
                    $this->UserCount->save($user_count , false);
                 }
                return true; 
        }
 
     public function book_evoucher($service_id=NULL,$user_id=NULL ,$type=NULL){
                    if(!$this->Session->read('appointmentData')){
			$this->Session->setFlash('Unauthorized Access.', 'flash_success');
			$this->redirect(array('controller'=>'homes','action'=>'index'));
		    }
                    $this->loadModel('GiftCertificate');
                     // pr($this->Session->read());
                    $order_status_val = '';	
                    $order_status="";
                    $tracking_id = '';
                    $amount = '';
                    $gift_id ='';
                    $point_given = '';
                    $status_message ='';
                    $point_used_status = false;
                    $gift_used_status = false;
                    $orignal_amount = 0;
                    $point_used = 0;
                    $gift_amount_used = $ser_full_price = 0; 
                    $ser_full_price = 0;
                    $appointment_detail = $this->Session->read('appointmentData.Appointment');   
                    //pr($appointment_detail); 
                    if($service_id && $user_id){
                        $service_id = $service_id;
                        $user_id = $user_id;
                         if($type=='points'){
                            // pr($this->request->data);
                            $total_points = $this->request->data['Points']['total_points'];
                            $redeem_points = $this->request->data['Points']['points_redeem'];
                            //pr($total_points);
                            //die;
                            $redeem_points = $appointment_detail['selected_quantity']*$redeem_points;
                            $point_left = $total_points - $redeem_points;
                            $point_used = $redeem_points;
                            $amount = 0;
                            $order_status = 'points';
                            $status_message = 'purchase by points';
                        }else if($type=='gift'){
                                $gift_detail  = $this->Session->read('gift_detail');
                                if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                                    $this->GiftCertificate->recursive = -1;
                                    $giftDetail = $this->GiftCertificate->find('first' ,array('conditions'=>array('GiftCertificate.id'=>$gift_detail['point']['use_gift_id']),'fields'=>array('amount')));
                                    $gift_amount = $giftDetail['GiftCertificate']['amount'];
                                    $service_amount = $this->request->data['Points']['amnt'];
                                    $amount_left = $gift_amount - $service_amount;
                                    if($amount_left > 0){
                                        $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $gift_recipient['GiftCertificate']['amount']  = $amount_left;
                                        $gift_recipient['GiftCertificate']['recipient_id'] = $this->Auth->user('id');
                                        $this->GiftCertificate->save($gift_recipient , false);
                                    }else{
                                        $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $gift_recipient['GiftCertificate']['is_used']  = 1;
                                        $gift_recipient['GiftCertificate']['recipient_id'] = $this->Auth->user('id');
                                        $this->GiftCertificate->save($gift_recipient , false);
                                    }
                                    $amount = 0;
                                    $order_status = 'gift';
                                    $gift_id = $gift_detail['point']['use_gift_id'];
                                    $status_message = 'purchase by gift card';
                                    $gift_amount_used = $service_amount;
                                } 
                                }else if($type=='payment'){
                                   $amount = $this->request->data['Appointment']['amount'];
                                   $status_message = 'before payment'; 
                                   $order_status = 'payment';
                             }else{
                                $workingKey=Configure::read('working_key'); 	//Working Key should be provided here.
                                $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
                                $rcvdString=$this->Crypto->decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.			
                                $order_status_val = '';	
                                $order_status="";
                                $tracking_id = '';
                                $amount = '';
                                $decryptValues=explode('&', $rcvdString);
                                $dataSize=sizeof($decryptValues);
                                for($i = 0; $i < $dataSize; $i++) 
                                {
                                    $information=explode('=',$decryptValues[$i]);
                                    if($i==0)   { $order_id = $information[1];}
                                    if($i==3)	{ $order_status=$information[1]; }
                                    if($i==1)	{ $tracking_id=$information[1]; }
                                    if($i==10)	{ $amount=$information[1]; }
                                    if($i==8)	{ $status_message=$information[1]; }
                                }
                               //$order_status  ='Success';
                               $gift_detail =  $this->Session->read('gift_detail');
                               $point_detail  = $this->Session->read('point_detail');
                                if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                                        $gift_amount_used = $this->Common->get_gift_amount($gift_detail['point']['use_gift_id']);
                                        $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $gift_recipient['GiftCertificate']['is_used']  = 1;
                                        $gift_recipient['GiftCertificate']['recipient_id'] = $this->Auth->user('id');
                                        $this->GiftCertificate->save($gift_recipient , false);
                                        $gift_id = $gift_detail['point']['use_gift_id'];
                                        $gift_used_status = true;
                                }
                                if(isset($point_detail['point']['is_used_point']) && $point_detail['point']['is_used_point']=='1'){
                                        $used_points = $point_detail['point']['used_point'];
                                        $point_left = 0;
                                        $point_used = $used_points;
                                        $point_used_status = true;
                                } 
                          }
                     if($order_status)
			{     
                            $appointment_status = ($order_status==="Success")?4:5;
                            if($order_status==="Success")
                            {
                             $appointment_status  =4;
                             $order_status_val = 1;   
                            }else if($order_status==="Aborted")
                            {
                                $order_status_val = 2;
                                $appointment_status  =5;
                            }
                            else if($order_status==="Failure")
                            {
                               $order_status_val = 3;
                               $appointment_status  =5;
                            }
                            else if($order_status==="points")
                            {
                              $order_status_val = 5;
                              $appointment_status  =4;
                            }else if($order_status==="gift")
                            {
                              $order_status_val = 6;
                              $appointment_status  =4;
                            }else if($order_status==="payment")
                            {
                              $order_status_val = 9;
                              $appointment_status  =5;
                            }else{
                              $order_status_val = 5;       
                            }     
                        $this->loadModel('SalonService'); $this->loadModel('UserCount'); $this->loadModel('UserPoint');
                        $this->loadModel('Appointment');$this->loadModel('Order');
                        $this->loadModel('User');$this->loadModel('PolicyDetail');
                        $this->SalonService->unbindModel(array('hasMany'=>array('SalonServiceImage','SalonStaffService','PackageService')));
                        $serviceId = $service_id;
                        $this->SalonService->recursive = 2;
                        $serviceDetails = $this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$serviceId)));
                        $serviceOwner = $this->User->findById($serviceDetails['SalonService']['salon_id']);
                        $vocuher_expire = $this->Common->vocher_expiry($serviceDetails['SalonService']['salon_id'],$serviceDetails['SalonServiceDetail']['evoucher_expire'],$serviceDetails['SalonServiceDetail']['evoucher_expire_after']);
                        if($order_status==="Success" || $order_status==="points" || $order_status==="gift" || $order_status==="payment")
                        {
                            $this->loadModel('Evoucher');
                            // $this->loadModel('EvoucherDetail');
                            foreach($serviceDetails['ServicePricingOption'] as $priceOpt){
                                    if($priceOpt['id'] == $appointment_detail['price_id']){
                                       $orignal_amount =  ($priceOpt['sell_price'])? $priceOpt['sell_price'] :$priceOpt['full_price'];
                                       $servic_price = $orignal_amount;
                                       $orignal_amount =  $orignal_amount*$appointment_detail['selected_quantity']; 
                                       $ser_sell_price = $priceOpt['sell_price'];
                                       $ser_full_price = $priceOpt['full_price'];
                                       $point_redeem = $priceOpt['points_redeem'];
                                       $duration = $priceOpt['duration'];
                                       $point_given = $priceOpt['points_given'];
                                    }
                            }
                          $salon_id = $serviceDetails['SalonService']['salon_id'];
                          /*************************************TAX***********************************************/
                         $tax_data  = $this->Common->get_vendor_dues($orignal_amount,$salon_id,$serviceOwner['User']['discount_percentage'],$servic_price);
                         /********************************************************/
                         $order['Order']['transaction_id'] = $tracking_id;     
                         $order['Order']['user_id'] = $user_id;
                            if($order_status == 'payment' || $order_status == 'gift' || $order_status==="points"){
                                  $order['Order']['first_name'] = $this->request->data['Appointment']['first_name'];     
                                  $order['Order']['last_name'] = $this->request->data['Appointment']['last_name'];
                                  $phone_code =  str_replace('+','',$this->request->data['Appointment']['country_code']);
                                  $order['Order']['phone_number'] = $phone_code.$this->request->data['Appointment']['billing_tel'];    
                                  unset($this->request->data['Appointment']['country_code']);
                                  //pr($order);
                              }
                        
                        // $order['Order']['employee_id'] =$appointment_detail['selected_employee_id'];
                         $order['Order']['salon_service_id'] = $serviceId;
                         $order['Order']['price_option_id'] =$appointment_detail['price_id'];
                         $order['Order']['points_used'] =$point_used;
                        //$point_used_status = false;
                        //$gift_used_status = false;
                        if($point_used_status || $gift_used_status){
                        $order['Order']['transaction_status'] = ($point_used_status)?8:7; 
                        }else{
                         $order['Order']['transaction_status'] = $order_status_val; 
                        }
                         $order['Order']['duration'] = $duration;
                         // $order['Order']['start_date'] = $appointment_detail['selected_date'];
                         $order['Order']['amount'] = $amount;
                         $order['Order']['service_type'] = 7;
                         $order['Order']['orignal_amount'] = $orignal_amount;
                         $order['Order']['transaction_message'] = $status_message;
                         $display_order_id = $this->Common->getRandPass(10);
                         $order['Order']['display_order_id'] = $display_order_id;
                         $order['Order']['eng_service_name'] = $serviceDetails['SalonService']['eng_name'];
                         $order['Order']['ara_service_name'] = $serviceDetails['SalonService']['ara_name'];
                         $order['Order']['sold_as'] = $serviceDetails['SalonServiceDetail']['sold_as'];
                         $order['Order']['gift_amount'] = $gift_amount_used;
                         $order['Order']['points_given'] = $point_given;
                         $order['Order']['start_date'] = date('Y-m-d');
                         $order['Order']['points_redeem'] = $point_redeem;
                         $order['Order']['used_gift_id'] = $gift_id;
                         $order['Order']['sell_price'] = $ser_sell_price;
                         $order['Order']['full_price'] = $ser_full_price;
                         $order['Order']['service_price_with_tax'] = $tax_data['service_price_with_tax'];
                         $order['Order']['deduction1'] =$tax_data['tax_admin']['TaxCheckout']['deduction1'];
                         $order['Order']['deduction2'] = $tax_data['tax_admin']['TaxCheckout']['deduction2'];
                         $order['Order']['sieasta_commision'] = $tax_data['sieasta_comission_price'];
                         $order['Order']['total_deductions'] = $tax_data['total_deductions'];
                         $order['Order']['vendor_dues'] = $tax_data['vendors_dues'];
                         $order['Order']['tax1'] = $tax_data['tax_vendor']['TaxCheckout']['tax1'];
                         $order['Order']['tax2'] = $tax_data['tax_vendor']['TaxCheckout']['tax2'];
                         $order['Order']['salon_id'] = $serviceDetails['SalonService']['salon_id'];
                         $order['Order']['tax_amount'] = $tax_data['tax_amount'];
                         $order['Order']['sieasta_commision_amount'] = $tax_data['sieasta_comission'];
                         $order['Order']['saloon_discount'] = $serviceOwner['User']['discount_percentage'];
                         $order['Order']['is_admin_tax'] = $tax_data['is_admin_tax'];
                         $order['Order']['tax1_amount'] = $tax_data['tax1_amount'];
                         if($order_status==="Success" || $order_status==="Aborted" || $order_status==="Aborted"){
                            $this->Order->id = $order_id;  
                         }
                        if($this->Common->add_customer_to_salon($user_id,$serviceDetails['SalonService']['salon_id'])){
                         if($this->Order->save($order , false)){
                                 $order_id = $this->Order->id;  
                                 $salon_id = $serviceDetails['SalonService']['salon_id'];
                       /**************************redeem points********************************************/         
                                 if(isset($point_used) && !empty($point_used)){
                                  $user_count['UserPoint']['points_deducted'] = $point_used;
                                  $user_count['UserPoint']['salon_id'] = $serviceDetails['SalonService']['salon_id']; 
                                  $user_count['UserPoint']['user_id'] = $user_id;                                  
                                  $user_count['UserPoint']['order_id'] = $order_id;
                                  $user_count['UserPoint']['type'] = 1; 
                                  $this->UserPoint->create();
                                  $this->UserPoint->save($user_count , false);
                                  $user_point_id = $this->UserPoint->id;
                                 /*********************** total redeem points **************/
                                    $salon_id = $serviceDetails['SalonService']['salon_id'];
                                    $points  = array();
                                    $points['user_id'] = $user_id;
                                    $points['salon_id'] = $salon_id;
                                    $points['used_points'] = $point_used;
                                    $points['user_point_id'] = $user_point_id;
                                    $points['order_id'] = $order_id;
                                    $this->redeem_points($points);
                             }
                          if($order_status !='payment'){ 
                            if(!empty($point_given)){
                                  $user_counts['UserPoint']['point_given'] = $point_given;
                                  $user_counts['UserPoint']['salon_id'] = $serviceDetails['SalonService']['salon_id']; 
                                  $user_counts['UserPoint']['user_id'] = $user_id;                                  
                                  $user_counts['UserPoint']['order_id'] = $order_id;;
                                  $this->UserPoint->create();
                                   if($this->UserPoint->save($user_counts , false)){
                                     $salon_id = $serviceDetails['SalonService']['salon_id'];
                                     $salon_type  ='individual';
                                      if($serviceOwner['User']['parent_id'] !=0){
                                        $this->User->recursive = -1;
                                        $frechiseDetail = $this->User->findById($serviceOwner['User']['parent_id']);
                                            if(count($frechiseDetail)){
                                                 if($frechiseDetail['User']['type']==2){
                                                    $frenchise_id =  $frechiseDetail['User']['id'];
                                                    $salon_type  ='frenchise';
                                                  } 
                                             }
                                       }
                                      $salonOrfrnchisId = (isset($frenchise_id))?$frenchise_id:$salon_id;
                                      $userCount = $this->UserCount->find('first' , array('conditions'=>array('user_id'=>$user_id , 'salon_id'=>$salonOrfrnchisId),'fields'=>array('id','user_count')));
                                       if(count($userCount)){
                                            $userTotalCount  = $userCount['UserCount']['user_count']+$point_given; 
                                            $totalPoints['UserCount']['user_count'] = $userTotalCount;
                                            $this->UserCount->id = $userCount['UserCount']['id'];
                                        }else{
                                            $totalPoints['UserCount']['user_count'] = $point_given;
                                            $this->UserCount->create();
                                        }
                                        $totalPoints['UserCount']['salon_id'] = $salonOrfrnchisId;
                                        $totalPoints['UserCount']['user_id'] = $user_id;
                                        $totalPoints['UserCount']['salon_type'] = $salon_type;
                                        $this->UserCount->save($totalPoints , false);
                                    }
                                }
                                /***************************sieasta points*******************************/
                                $Detail = array();
                                $Detail['amount'] = $orignal_amount;
                                $Detail['user_id'] = $user_id;
                                $Detail['order_id'] = $order_id;
                                $this->siesta_points($Detail);
                           
                             if($order_status==="gift" && isset($amount_left) && $amount_left > 0){
                                    $this->loadModel('GiftDetail');
                                    $giftDetail['amount_used'] = $service_amount;
                                    $giftDetail['order_id'] = $order_id;
                                    $giftDetail['gift_id'] = $gift_id;
                                    $this->GiftDetail->save($giftDetail , false);
                                }
                             }    
                            // echo $appointment_detail['selected_quantity'];
                            
                            if($order_status !='Success'){
                                $voucher_code = $this->Common->getRandPass(8);
                                for($i =1; $i<=$appointment_detail['selected_quantity']; $i++){ 
                                     $recipient_name = $this->request->data['Appointment']['recipient_name'];
                                     $recipient_message = $this->request->data['Appointment']['recipient_message'];
                                     $evoucher['Evoucher']['order_id'] = $order_id;
                                     $evoucher['Evoucher']['salon_id'] = $serviceDetails['SalonService']['salon_id'];
                                     $evoucher['Evoucher']['user_id'] = $user_id;
                                     $evoucher['Evoucher']['service_id'] = 1;
                                     $evoucher['Evoucher']['price'] = $tax_data['service_price_tax'];
                                     $evoucher['Evoucher']['evoucher_type'] = 1;
                                     $evoucher['Evoucher']['expiry_date'] = $vocuher_expire;
                                     //$evoucher['Evoucher']['expiry_date'] = $vocuher_expire;
                                     $evoucher['Evoucher']['vocher_code'] = $voucher_code;
                                     $evoucher['Evoucher']['reciepent_message'] = $recipient_message;
                                     $this->Evoucher->create();
                                     $this->Evoucher->save($evoucher);
                                 }
                            }
                        if($order_status =='payment'){
                              if($this->request->is('post') || $this->request->is('put')){
                                        //echo '<pre>';  print_r($this->request->data);  die('herere');
                                       $working_key=Configure::read('working_key');  //Shared by CCAVENUES
                                       $access_code =Configure::read('access_code');  //Shared by CCAVENUES
                                       $merchant_data =  '';
                                       $this->request->data['Appointment']['order_id'] = $order_id;
                                       foreach ($this->request->data['Appointment'] as $key => $value){
                                        $merchant_data.=$key.'='.$value.'&';
                                       }
                                       //echo $merchant_data; 
                                       $encrypted_data = $this->Crypto->encrypt($merchant_data,$working_key);
                                       //echo $encrypted_data;
                                       $this->set(compact('encrypted_data','access_code'));
                                       $this->render('payment');
                                    }
                            }else{
                               $this->User->recursive = 2;
                               if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
                                       //Update Order Avail Status
                                       $this->Order->id = $order_id;
                                       $this->Order->saveField('order_avail_status',1);
                                       $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$salon_id,'User.id'=>$salon_id))));
                                       $quantity =  $appointment_detail['selected_quantity'];
                                       $service_name = $serviceDetails['SalonService']['eng_name'];
                                       
                                       $orderDat = $this->Common->get_Order($order_id); 
                                       $display_order_ID = @$orderDat ['Order']['display_order_id'];
                                   
                                        foreach($SalonBookingIncharges as $incharge){
                                                $employeeDetail = $this->User->findById($appointment_detail['selected_employee_id']);
                                                //$time = trim($appointment_detail['service'][$serviceId]['time']);
                                                $message = "$quantity $service_name  evoucher has been sold from your Salon . Your order id is $display_order_ID " ;
                                                $this->sendUserEmailEvoucher($incharge, $serviceDetails ,$display_order_id ,$amount ,'evoucher_sold',$duration,'vendor');
                                                $this->sendUserPhoneEvoucher($incharge, $serviceDetails,$message ,$order_id ,$amount ,'vendor');
                                        }
                                        $userDetail = $this->User->findById($this->Auth->user('id'));      
                                        $orderData = $this->Common->get_Order($order_id);
                                        $service_name = $serviceDetails['SalonService']['eng_name'];
                                        $salonName = $serviceOwner['Salon']['eng_name'];
                                        $country_code = ($serviceOwner['Contact']['country_code'])?$serviceOwner['Contact']['country_code']:'+971';
                                        $Contact_no = '';
                                        if(!empty($serviceOwner['Contact']['day_phone'])){
                                            $Contact_no  = $serviceOwner['Contact']['country_code'].' '.$serviceOwner['Contact']['day_phone'];    
                                        }
                                        
                                        $message ="Your order for  $quantity $service_name evoucher with Salon $salonName is confirmed. See you soon. $Contact_no . Your order id is $display_order_ID "; 
                                    $this->sendUserEmailEvoucher($userDetail, $serviceDetails,$display_order_id ,$amount ,'confirmation_evoucher',$duration);
                                    $this->Common->sendUserPhone($userDetail, $orderData,$message ,'customer');
                                    $this->Session->delete('appointmentData');
                                    $this->Session->setFlash('You have bought evoucher successfully.', 'flash_success');
                                    $this->redirect(array('controller'=>'Myaccount','action'=>'orders'));     
                                 }else{
                                   $this->Session->setFlash('Some Error occured.', 'flash_error');
                                   $this->redirect(array('controller'=>'homes','action'=>'index'));    
                                 }
                            }
                              }else{
                                $this->Session->setFlash('Some Error occured.', 'flash_error');
                                $this->redirect(array('controller'=>'homes','action'=>'index'));  
                             }
                        }else{
                            $this->Session->setFlash('Some Error occured.', 'flash_error');
                                $this->redirect(array('controller'=>'homes','action'=>'index'));  
                            }
                        }else{
                                $this->Session->setFlash('Some Error occured.', 'flash_error');
                                $this->redirect(array('controller'=>'homes','action'=>'index'));  
                            }
                    }    
                          
         }
            //if($this->request->is('post') || $this->request->is('put')){
            //     //echo '<pre>';  print_r($this->request->data);  die('herere');
            //    $working_key=Configure::read('working_key');  //Shared by CCAVENUES
            //    $access_code =Configure::read('access_code');  //Shared by CCAVENUES
            //    $merchant_data =  '';
            //    foreach ($this->request->data['Appointment'] as $key => $value){
            //     $merchant_data.=$key.'='.$value.'&';
            //    }
            //    //echo $merchant_data; 
            //    $encrypted_data = $this->Crypto->encrypt($merchant_data,$working_key);
            //    //echo $encrypted_data;
            //    $this->set(compact('encrypted_data','access_code'));
            // }      
             
        }
 
     function sendUserEmailEvoucher($userData=array() , $serviceDetail = array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;
        $service_name = $serviceDetail['SalonService']['eng_name'];
        $appointment_detail = $this->Session->read('appointmentData.Appointment');
        $quantity = $appointment_detail['selected_quantity'];
        $dynamicVariables = array('{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{amount}' => $amount,
                                  '{service_name}'=>$service_name,
                                  '{order_id}'=>$order_id,
                                  '{quantity}'=>$quantity,
                                  '{duration}'=>$this->Common->get_mint_hour($points),
                                  );
        if($type=='gift'){
         $dynamicVariables['{gift_amount}'] = $points;   
        }else if($type=='points'){
          $dynamicVariables['{point}'] = $points;      
        }else if($type=='vendor'){
         $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($points);   
        }
         
        $template_type =  $this->Common->EmailTemplateType($serviceDetail['SalonService']['salon_id']);
        if($template_type){
          $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
        }
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
    public function create_appointment_history($historyData = null){
        $this->loadModel('AppointmentHistory');
        if(!empty($historyData)){
            if($this->AppointmentHistory->saveAll($historyData)){
                return true;
            }else{
                return false;
            }	
        }
    }
    
    
    function sendUserPhoneEvoucher($getData=array(), $serviceDetail = array(), $message = '', $order_id=null ,$amount = null , $type=null , $duration=null){
            $this->loadModel('User');
            $firstName = $getData['User']['first_name'];
            $lastName = $getData['User']['last_name'];
            $appointment_detail = $this->Session->read('appointmentData.Appointment');
            $order_id = $order_id;
            $service_name = $serviceDetail['SalonService']['eng_name'];
            if($getData){
                $number = (isset($getData['Contact']['cell_phone']))?$getData['Contact']['cell_phone']:'';
                $country_id = (isset($getData['Address']['country_id']))?$getData['Address']['country_id']:'';
                if($country_id){
                    $country_code  =   $this->Common->getPhoneCode($country_id);
                       if($country_code){
                          $number = str_replace("+","",$country_code).$number;    
                       }else{
                         $country_code = '+971';
                         $number = str_replace("+","",$country_code).$number;    
                       }
                 }
                    $this->Common->sendVerificationCode($message,$number);
            }
        return true;
    }
       
}