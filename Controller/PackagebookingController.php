<?php
class PackagebookingController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie', 'Common','Image','Crypto'); //An array containing the names of components this controller uses.

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('showPackage','appointment');
        //$this->Auth->allow('*');
    }

    /**********************************************************************************    
    @Function Name : showPackage
    @Params	 : NULL
    @Description   : for displaying booking on the salon package page.
    @Author        : Shibu Kumar 
    @Date          : 11-May-2015
    ******************************************************************************************/
   public function showPackage($packageId = NULL, $dealID = NULL,$salonId = NULL, $apntmntORevchrID = NULL){
        $blkDate = array();
        $deal = false;
        $deal_id = '';
        $dealAvailtime = '';
        //in case of deal $packageId is dealid
        if(!empty($packageId)){
            $package_details = explode('-',$packageId);
            $cnt_ser_details = count($package_details);
            $encoded_service_id = $package_details[$cnt_ser_details-1];
            if($encoded_service_id == 'deal'){
                $encoded_service_id = $package_details[$cnt_ser_details-2];
                $deal = true;
                $deal_id = base64_decode($dealID);
            }
            $service_id = base64_decode($encoded_service_id);
            if(is_numeric($service_id)){
                $packageId = $service_id;
            }
        }
        $packageId;
        $reschedule = '';
        $eVoucher = '';
        if(!empty($apntmntORevchrID)){
            $apntmntORevchrID = base64_decode($apntmntORevchrID);
            if($this->Session->read('APPOINTMENT.RESCHEDULE')){
                $this->loadModel("Appointment");
                $appointmentID = $apntmntORevchrID;
                $count = $this->Appointment->find("count",array("conditions"=>array("Appointment.order_id"=>$appointmentID)));
                if($count >=1 && $this->Session->read('APPOINTMENT.RESCHEDULE')==true){
                    $this->loadModel("Order");
                    //$this->Order->unbindModel(array('hasMany'=>array('OrderDetail')));
                    $appointmentDetail = $this->Order->find("first",array('contain'=>array('OrderDetail'=>array('fields'=>array('OrderDetail.id','service_id','option_duration','option_price','eng_service_name','ara_service_name','price_option_id','service_id','duration')),'Appointment'=>array('fields'=>array('Appointment.id','Appointment.salon_service_id','Appointment.salon_id'))),'fields'=>array('Order.eng_service_name','Order.id','Order.salon_id'),'conditions'=>array("Order.id"=>$appointmentID)));
                        //pr($appointmentDetail);
                       //exit;
                    if($appointmentDetail){
                        $this->set(compact("appointmentDetail"));
                        $reschedule = 'true';
                    }
                }
            }else if($this->Session->read('EVOUCHER.BOOKAPPOINTMENT')){
                 $this->loadModel("Evoucher");
                 $this->loadModel("Order");
                 $evoucherID = $apntmntORevchrID;
                 $this->Order->unbindModel(array('belongsTo'=>array("Appointment","SalonService")));
                 $this->Evoucher->recursive = 2;
                 $eVoucherDetail = $this->Evoucher->find('first',array('contain'=>array('Order'=>array('OrderDetail'=>array('fields'=>array('OrderDetail.id','service_id','option_duration','option_price','eng_service_name','ara_service_name','price_option_id','service_id','duration','package_service_id')))),'fields'=>array('Evoucher.id','Order.id','Evoucher.used','Order.salon_service_id','Order.price_option_id','Order.eng_service_name','Order.ara_service_name','Evoucher.price','Evoucher.salon_id','Evoucher.expiry_date'),'conditions'=>array('Evoucher.id'=>$evoucherID,'Evoucher.used'=>0)));
                
                 if($eVoucherDetail){
                    $eVoucher = 'true';
                 }else{
                        $this->Session->setFlash('Invalid url.', 'flash_error');
                        $this->redirect(array('controller'=>'homes','action'=>'index'));
                 }
            }
            
        }
      
        if($deal==true){
        
           $this->loadModel('Deal');
           $this->params['deal'] = true;
           $deal_id = $deal_id ? $deal_id : $packageId;
           //$this->Session->delete('Deal.is_deal_book');
           // $this->Deal->recursive = 2;
           //$this->Deal->bindModel(array('hasMany'=>array('DealServicePackagePriceOption')));
           $dealData  = $this->Deal->find('first',
                                          array('contain'=>array('DealServicePackage'=>array('DealServicePackagePriceOption'=>array('fields'=>array('DealServicePackagePriceOption.*')))),
                                                'conditions'=>array('Deal.id'=>$deal_id),
                                                 'fields'=>array('Deal.*')));
             if(!empty($dealData)){
                $blkDate = unserialize($dealData['Deal']['blackout_dates']);
                foreach($blkDate as $theBk=>$bkdat){
                    $blkDate[$theBk] = date('Y-m-d',$bkdat);
                }
                $dealAvailtime =  $dealData['Deal']['avail_time'];
           }else{
                $this->Session->setFlash('Invalid url.', 'flash_error');
                $this->redirect(array('controller'=>'Homes','action'=>'index'));
           }
            if(isset($dealData['DealServicePackage'][0]['package_id'])){
                  $packageId =  $dealData['DealServicePackage'][0]['package_id'];
            }
           //pr($dealData); die;
           //$this->set(compact('dealData','salonId'));
           $deal = true;
           $this->set(compact('deal','dealData'));
        }
       
        if($packageId){
            $this->loadModel('Package');
            $this->Package->recursive = 2;
            $packageDetails = $this->Package->find('first',array('conditions'=>array('Package.id'=>$packageId)));
            if($packageDetails){
                $userID = $packageDetails['Package']['user_id'];
                $salonId = @$userID;
                $this->params['type'] = $packageDetails['Package']['type'];
            }else{
                  $this->Session->setFlash('Invalid url.', 'flash_error');
                   $this->redirect(array('controller'=>'homes','action'=>'index'));
            }
        }
        
        $this->loadModel('PolicyDetail');
        $this->loadModel('PolicyDetail');
        $policyDetail = $this->PolicyDetail->find('first', array('fields'=>array('eng_cancel_appointment_policy','eng_reschedule_appointment_policy','ara_reschedule_appointment_policy','ara_cancel_appointment_policy'),'conditions' => array('user_id' => $salonId)));
        if (empty($policyDetail)) {
             $policyDetail = $this->PolicyDetail->find('first', array('fields'=>array('eng_cancel_appointment_policy','eng_reschedule_appointment_policy','ara_reschedule_appointment_policy','ara_cancel_appointment_policy'),'conditions' => array('user_id' => 1)));
        }
        $this->set('policyDetail', $policyDetail);
       // $this->set(compact('packageDetails','salonId'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'salon';
        }
        if($eVoucher){
             $newDate = $eVoucherDetail['Evoucher']['expiry_date'];
            $maxBookingLimit =  date('D M d Y H:i:s', strtotime($newDate));
            $this->set(compact("eVoucherDetail"));
        }else{
            $advanceBookingLimit = $this->Common->getDefaultLeadTime($salonId,'maxLimit',array('booking_limit'));
            //$newDate = strtotime('+'.$advanceBookingLimit.' days');
            if($deal == true && !empty($dealAvailtime)){
                $newDate =  strtotime($dealAvailtime);
            }else{
                $newDate = strtotime('+'.$advanceBookingLimit.' days');    
            }
            $maxBookingLimit =  date('D M d Y H:i:s', $newDate);
        }
        $this->set(compact('packageDetails','salonId','maxBookingLimit','eVoucher','reschedule','blkDate'));
     }

    /******************************************************************************************************    
    @Function Name : showPackage
    @Params	 : NULL
    @Description   : for displaying booking on the salon package page.
    @Author        : Shibu Kumar
    @Date          : 11-May-2015
    ******************************************************************************************/
    
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
        if(empty($appointmentData)){
            $this->redirect(array('controller'=>'Homes','action'=>'index'));
        }
        else{
            $id  = $this->Auth->user('id');
            if(!$id){
                $this->redirect(array('controller'=>'Homes','action'=>'index'));
            }
            $this->loadModel('Package');$this->loadModel('PointSetting'); $this->loadModel('TaxCheckout');
            $this->loadModel('User');$this->loadModel('PolicyDetail'); $this->loadModel('UserCount');
            //$this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('SalonServiceImage','SalonStaffService','PackageService')));
            //foreach($appointmentData['Appointment']['service'] as $key=>$val){
            //    $servicIds[] = $key;
            //}
            $packageId = $appointmentData['Appointment']['package_id'];
            $this->Package->recursive = 2;
            $packageDetails = $this->Package->find('first',array('conditions'=>array('Package.id'=>$packageId)));
            $totalHoursFinal = '';
            if($appointmentData['Appointment']['theBuktype']== "appointment"){
                $durationArray = array();
                foreach($appointmentData['Appointment']['service'] as $packageService){
                    $durationArray[] = $packageService['duration'];
                }
                $totalHours =  array_sum($durationArray);
                $totalHoursFinal = $this->Common->get_mint_hour($totalHours);
            }

            $packageOwner = $this->User->findById($packageDetails['Package']['user_id']);
            $salon_id = $packageDetails['Package']['user_id'];
            if($packageOwner['User']['parent_id'] !=0){
                $frechiseDetail = $this->User->findById($packageOwner['User']['parent_id']);
                    if(count($frechiseDetail)){
                        if($frechiseDetail['User']['type']==2){
                            $salon_id =  $frechiseDetail['User']['id'];
                          } 
                     }
            }
            $totalPoints = $this->UserCount->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'),'salon_id'=>array($salon_id,1)),'fields'=>array('(sum(UserCount.user_count)) AS total')));                           
            $totalPoints = isset($totalPoints[0][0]['total'])?$totalPoints[0][0]['total']:0; 
            $pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
            $ownerPolicy = $this->PolicyDetail->find('first',array('conditions'=>array('PolicyDetail.user_id'=>$salon_id)));
            if(count($ownerPolicy) == 0){
              $ownerPolicy = $this->PolicyDetail->find('first' ,array('conditions'=>array('user_id'=>1)));
            }
            $taxes = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$salon_id)));
            if(count($taxes)==0){
             $taxes = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>1)));  
            }
           $this->set(compact('packageDetails','totalHoursFinal','packageOwner','ownerPolicy','salon_id','taxes','totalPoints','pointsVal'));
        }
         $this->set('theData',$appointmentData);   
    }
    
    
    public function payment($package_id=NULL,$user_id=NULL ,$type=NULL){
                    //pr($this->request->data);die;
                     if(!$this->Session->read('appointmentData')){
			$this->Session->setFlash('Unauthorized Access.', 'flash_success');
			$this->redirect(array('controller'=>'homes','action'=>'index'));
		    }
                    $userDetail = $this->Session->read('Auth');
                    $this->loadModel('GiftCertificate');
                    $this->loadModel('OrderDetail');
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
                    $gift_amount_used =0;
                    $point_used = 0;
                    $appointment_detail = $this->Session->read('appointmentData.Appointment');
                    if($package_id && $user_id){
                         if($type=='gift'){
                                    $gift_detail  = $this->Session->read('gift_detail');
                                    if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                                        $this->GiftCertificate->recursive = -1;
                                        $giftDetail = $this->GiftCertificate->find('first' ,array('conditions'=>array('GiftCertificate.id'=>$gift_detail['point']['use_gift_id']),'fields'=>array('amount')));
                                        $gift_amount = $giftDetail['GiftCertificate']['amount'];
                                        $package_amount = $this->request->data['Points']['amnt'];
                                            $amount_left = $gift_amount - $package_amount;
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
                                        $gift_amount_used = $package_amount;
                                        $amount = 0;
                                        $order_status = 'gift';
                                        $gift_id = $gift_detail['point']['use_gift_id'];
                                        $status_message = 'purchase by gift card';
                                     } 
                                }else if($type=='points'){
                                        // pr($this->request->data);
                                        $amount = $this->request->data['Appointment']['amount'];
                                        $total_points = $this->request->data['Points']['total_points'];
                                        $redeem_points =$this->Common->get_points_from_price($amount);
                                        $point_left = $total_points - $redeem_points;
                                        $point_used = $redeem_points;
                                        $amount = 0;
                                        $order_status = 'points';
                                        $status_message = 'purchase by points';
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
                              $appointment_status  =4;
                            }else if($order_status==="payment")
                            {
                              $order_status_val = 9;
                              $appointment_status  =5;
                            }else{
                              $order_status_val = 5;       
                            }
                        $this->loadModel('Package');
                        $this->loadModel('SalonService'); $this->loadModel('UserCount'); $this->loadModel('UserPoint');
                        $this->loadModel('Appointment');$this->loadModel('Order');
                        $this->loadModel('User'); $this->loadModel('PolicyDetail');
                        $appointment_detail = $this->Session->read('appointmentData.Appointment');
                        $this->Package->recursive = 2;
                        $packageDetail = $this->Package->findById($package_id);
                        $packageOwner = $this->User->findById($packageDetail['Package']['user_id']);
                        foreach($packageDetail['PackageService'] as $packageData){
                            $serviceIds[] = $packageData['salon_service_id']; 
                        }
                        $i  = 0;
                        //pr($serviceIds);
                        $this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('SalonServiceImage','SalonStaffService','PackageService')));
                        //$serviceId = $service_id;
                        $serviceDetails = $this->SalonService->find('all',array('conditions'=>array('SalonService.id'=>$serviceIds)));
                        // pr($serviceDetails); die;
                        
                        //die('hererer'); 
                        if($order_status==="Success" || $order_status==="points" || $order_status==="gift" || $order_status==="payment")
                        {
                        /***********************Tax and commisons **************************/
                        //  die('in progress');
                           if($appointment_detail['theBuktype'] == 'eVoucher'){
                                 $pack_price = $appointment_detail['package_price']*$appointment_detail['quantity'];
                                }else{
                                 $pack_price = $appointment_detail['package_price'];
                            }
                            $salon_id = $packageDetail['Package']['user_id'];
                            $tax_data  = $this->Common->get_vendor_dues($pack_price,$salon_id,$packageOwner['User']['discount_percentage'],$appointment_detail['package_price']);
                            $vocuher_expire = $this->Common->vocher_expiry($salon_id,$packageDetail['SalonServiceDetail']['evoucher_expire'] ,$packageDetail['SalonServiceDetail']['evoucher_expire_after']);
                     
                        /********************* Save the orders details***************************************/     
                         
                         if($order_status == 'payment' || $order_status == 'gift' || $order_status==="points"){
                           $order['Order']['first_name'] = $this->request->data['Appointment']['first_name'];     
                           $order['Order']['last_name'] = $this->request->data['Appointment']['last_name'];
                           $phone_code =  str_replace('+','',$this->request->data['Appointment']['country_code']);
                           $order['Order']['phone_number'] = $phone_code.$this->request->data['Appointment']['billing_tel'];    
                           unset($this->request->data['Appointment']['country_code']);
                           //pr($order);
                         }
                         $order['Order']['transaction_id'] = $tracking_id;     
                         $order['Order']['appointment_id'] = '';
                         $order['Order']['user_id'] = $user_id;
                         $order['Order']['employee_id'] ='';
                         $order['Order']['points_used'] =$point_used;
                         $order['Order']['salon_id'] =$packageDetail['Package']['user_id'];
                         $order['Order']['salon_service_id'] =$package_id;
                         $display_order_id = $this->Common->getRandPass(10);
                         $order['Order']['display_order_id'] = $display_order_id;
                        if($appointment_detail['theBuktype'] == 'eVoucher'){
                            $order['Order']['service_type'] = 7;
                            $order['Order']['start_date'] = date('Y-m-d');
                            $order['Order']['order_avail_status'] =1;
                        }else{
                            $order['Order']['service_type'] = (trim($appointment_detail['thetype'])=='Spaday')?3:2;
                            $order['Order']['start_date'] = date('Y-m-d',strtotime($appointment_detail['package_date']));
                        }
                         $order['Order']['price_option_id'] = '';
                        if($point_used_status || $gift_used_status){
                          $order['Order']['transaction_status'] = ($point_used_status)?8:7; 
                        }else{
                          $order['Order']['transaction_status'] = $order_status_val; 
                        }
                         $order['Order']['display_order_id'] = $this->Common->getRandPass(10);
                         $order['Order']['amount'] = $amount;
                         $order['Order']['gift_amount'] = $gift_amount_used;
                         $order['Order']['orignal_amount'] = $appointment_detail['package_price'];
                         $order['Order']['transaction_message'] = $status_message;
                         $order['Order']['eng_service_name'] = $packageDetail['Package']['eng_name'];
                         $order['Order']['ara_service_name'] = $packageDetail['Package']['ara_name'];
                         $order['Order']['used_gift_id'] = $gift_id;
                         $order['Order']['service_price_with_tax'] = $tax_data['service_price_with_tax'];
                         $order['Order']['deduction1'] =$tax_data['tax_admin']['TaxCheckout']['deduction1'];
                         $order['Order']['deduction2'] = $tax_data['tax_admin']['TaxCheckout']['deduction2'];
                         $order['Order']['sieasta_commision'] = $tax_data['sieasta_comission_price'];
                         $order['Order']['total_deductions'] = $tax_data['total_deductions'];
                         $order['Order']['vendor_dues'] = $tax_data['vendors_dues'];
                         $order['Order']['tax1'] = $tax_data['tax_vendor']['TaxCheckout']['tax1'];
                         $order['Order']['tax2'] = $tax_data['tax_vendor']['TaxCheckout']['tax2'];
                         $order['Order']['salon_id'] = $packageDetail['Package']['user_id'];
                         $order['Order']['tax_amount'] = $tax_data['tax_amount'];
                         $order['Order']['sieasta_commision_amount'] = $tax_data['sieasta_comission'];
                         $order['Order']['saloon_discount'] = $packageOwner['User']['discount_percentage'];
                         $order['Order']['is_admin_tax'] = $tax_data['is_admin_tax'];
                         $order['Order']['tax1_amount'] = $tax_data['tax1_amount'];
                         if(trim($appointment_detail['thetype']) =='Spaday'){
                           $order['Order']['check_in'] = $packageDetail['Package']['check_in'];
                           $order['Order']['check_out'] = $packageDetail['Package']['check_out'];  
                         }
                         $fields = array('User.first_name','User.last_name','UserDetail.booking_incharge','UserDetail.email_reminder','User.email','Address.*','Contact.*');
                         if($order_status==="Success" || $order_status==="Aborted" || $order_status==="Aborted"){
                          $this->Order->id = $order_id;  
                         }
                    if($this->Common->add_customer_to_salon($user_id,$packageDetail['Package']['user_id'])){
                         if($this->Order->save($order , false)){
                                 $order_id = $this->Order->id;
                 /*******************************Redeeem points*************************************************/
                            if(isset($point_used) && !empty($point_used)){
                                  $user_count['UserPoint']['points_deducted'] = $point_used;
                                  $user_count['UserPoint']['salon_id'] = $packageDetail['Package']['user_id']; 
                                  $user_count['UserPoint']['user_id'] = $user_id;                                  
                                  $user_count['UserPoint']['order_id'] = $order_id;
                                  $user_count['UserPoint']['type'] = 1; 
                                  $this->UserPoint->create();
                                  $this->UserPoint->save($user_count , false);
                                  $user_point_id = $this->UserPoint->id;
                                 /*********************** total redeem points **************/
                                    $salon_id =  $packageDetail['Package']['user_id']; 
                                    $points  = array();
                                    $points['user_id'] = $user_id;
                                    $points['salon_id'] = $salon_id;
                                    $points['used_points'] = $point_used;
                                    $points['user_point_id'] = $user_point_id;
                                    $points['order_id'] = $order_id;
                                    $this->redeem_points($points);
                                 }
                             /****************************************************************/    
                      if($order_status !='payment'){            
                        if($appointment_detail['theBuktype'] != 'eVoucher'){
                            $modifiedDate = strtotime(date('Y-m-d h:m:s'));
                            foreach($serviceDetails as $serviceDetail){
                                $serviceId = $serviceDetail['SalonService']['id'];
                                $this->request->data['Appointment']['order_id'] = $order_id;
                                $this->request->data['Appointment']['salon_service_id'] = $serviceDetail['SalonService']['id'];
                                $this->request->data['Appointment']['salon_staff_id'] = trim($appointment_detail['service'][$serviceId]['stylist']);
                                $this->request->data['Appointment']['appointment_title']=$serviceDetail['SalonService']['eng_name'];
                                    // $this->request->data['Appointment']['appointment_price'] = $appointment_detail['price'];
                                    $pricingoptions = explode('-' ,$appointment_detail['package_price_opt']);
                                    //echo $i;
                                    foreach($packageDetail['PackageService'][$i]['PackagePricingOption'] as $priceOpt){
                                         if($priceOpt['id'] == $pricingoptions[$i]){
                                                $duration = $priceOpt['duration'];
                                                $price = $priceOpt['price'];
                                         }
                                    }
                                    $this->request->data['Appointment']['appointment_duration'] = $appointment_detail['service'][$serviceId]['duration'];
                                    $this->request->data['Appointment']['user_id']=$user_id;
                                    $this->request->data['Appointment']['appointment_price']=$price;
                                    $this->request->data['Appointment']['package_id'] = $packageDetail['Package']['id'];
                                    $this->request->data['Appointment']['appointment_created']=date('Y-m-d h:i:s');
                                    $this->request->data['Appointment']['appointment_repeat_type'] = 0;
                                    $this->request->data['Appointment']['startdate'] = $appointment_detail['package_date'];
                                    $this->request->data['Appointment']['appointment_start_date']= strtotime($appointment_detail['package_date'].' '.trim($appointment_detail['service'][$serviceId]['time']));
                                    if(trim($appointment_detail['thetype']) =='Spaday'){
                                        $service_type = 'S';
                                    }else{
                                        $service_type = 'PAC'; 
                                    }
                                    $this->request->data['Appointment']['type'] = $service_type;
                                    $this->request->data['Appointment']['appointment_return_request'] = 'NR';
                                    $this->request->data['Appointment']['status'] = $appointment_status;
                                    $this->request->data['Appointment']['payment_status'] = 2;
                                    $this->request->data['Appointment']['salon_id'] = $serviceDetail['SalonService']['salon_id'];
                                    $this->Appointment->create();
                                    $this->Appointment->save($this->request->data['Appointment'],false);
                                    $AppointementsIds[] = $this->Appointment->id;
                                    //create history
                                    $historyData = '';
				    $historyData['appointment_id'] = $this->Appointment->id;
				    $historyData['appointment_date'] = strtotime($appointment_detail['package_date'].' '.trim($appointment_detail['service'][$serviceId]['time']));
				    $historyData['duration'] = $appointment_detail['service'][$serviceId]['duration'];
				    $historyData['service_name'] = $serviceDetail['SalonService']['eng_name'];
                                    $historyData['package_name'] = $packageDetail['Package']['eng_name'];
				    $historyData['staff_id'] = trim($appointment_detail['service'][$serviceId]['stylist']);
				    $historyData['modified_by'] = $this->Auth->User('id');
				    $historyData['modified_date'] = $modifiedDate;
				    $historyData['order_id'] = $order_id; 
				    $historyData['status'] = 'Paid';
                                    $historyData['type'] = 'package';
				    $historyData['action'] = 'Appointment Booked for Package';
				    $this->create_appointment_history($historyData);
                                    $i++;
                              }
                        }
                       }         
                        /*********************gift card points given *******************************/
                                if($order_status==="gift" && isset($amount_left) && $amount_left > 0){
                                        $this->loadModel('GiftDetail');
                                        $giftDetail['amount_used'] = $package_amount;
                                        $giftDetail['order_id'] = $order_id;
                                        $giftDetail['gift_id'] = $gift_id;
                                        $this->GiftDetail->save($giftDetail , false);
                                }   
                                        //pr($AppointementsIds); die;
                                        $i = 0;
                                if($order_status !='Success'){
                                        $ret_provider_status =  $this->Common->EmailTemplateType($packageDetail['Package']['user_id']);
                                        foreach($serviceDetails as $serviceDetail){  
                                            $serviceId = $serviceDetail['SalonService']['id'];
                                            $fields= array('SalonService.ara_name','SalonService.eng_name','SalonService.id','SalonService.salon_id');
                                            $order_detail['OrderDetail']['service_id'] = $serviceId;
                                            $order_detail['OrderDetail']['order_id']= $order_id;
                                            $pricingoptions = explode('-' ,$appointment_detail['package_price_opt']);
                                                foreach($packageDetail['PackageService'][$i]['PackagePricingOption'] as $priceOpt){
                                                     if($priceOpt['id'] == $pricingoptions[$i]){
                                                        $duration = $priceOpt['duration'];
                                                        $price = $priceOpt['price'];
                                                        $price_opt_id = $priceOpt['id'];
                                                        //$orignal_amount =  ($priceOpt['sell_price'])? $priceOpt['sell_price'] :$priceOpt['full_price'];
                                                        $package_service_id = $priceOpt['package_service_id'];
                                                        $option_duration = $priceOpt['option_duration'];
                                                        $option_price = $priceOpt['option_price'];
                                                      }
                                                }
                                                $order_detail['OrderDetail']['price'] = $price;
                                                $order_detail['OrderDetail']['user_id']=$user_id;
                                                $order_detail['OrderDetail']['appointment_price']=$price;
                                                if($appointment_detail['theBuktype'] != 'eVoucher'){
                                                   //$order_detail['OrderDetail']['appointment_id'] = $AppointementsIds[$i];
                                                   $order_detail['OrderDetail']['employee_id'] = trim($appointment_detail['service'][$serviceId]['stylist']);
                                                   $order_detail['OrderDetail']['duration'] = $appointment_detail['service'][$serviceId]['duration'];
                                                   $order_detail['OrderDetail']['time'] = trim($appointment_detail['service'][$serviceId]['time']);
                                                }
                                                $order_detail['OrderDetail']['appointment_created']=date('Y-m-d h:m:s');
                                                $order_detail['OrderDetail']['appointment_repeat_type'] = 0;
                                                $order_detail['OrderDetail']['start_date'] = date('Y-m-d' , strtotime($appointment_detail['package_date']));
                                                if($appointment_detail['theBuktype'] != 'eVoucher'){
                                                }
                                                $order_detail['OrderDetail']['salon_id'] = $serviceDetail['SalonService']['salon_id'];
                                                $order_detail['OrderDetail']['price_option_id'] = $price_opt_id;
                                                $order_detail['OrderDetail']['eng_service_name']  = $serviceDetail['SalonService']['eng_name'];
                                                $order_detail['OrderDetail']['ara_service_name'] = $serviceDetail['SalonService']['ara_name'];
                                                $order_detail['OrderDetail']['package_service_id'] = $package_service_id;
                                                $order_detail['OrderDetail']['option_duration'] = $option_duration;
                                                $order_detail['OrderDetail']['option_price'] = $option_price;
                                                $this->OrderDetail->create();
                                                $this->OrderDetail->save($order_detail,false);
                                                $i++;
                                                //$salon_id = $serviceDetail['SalonService']['salon_id'];$number =  $getData['Contact']['cell_phone'];
                                                 if($appointment_detail['theBuktype'] != 'eVoucher'){
                                                     $orderData = $this->Common->get_Order($order_id); 
                                                     $display_order_id = @$orderData ['Order']['display_order_id'];
                                                    $ServiceUser = $this->User->find('first', array('conditions'=>array('User.id'=>trim($appointment_detail['service'][$serviceId]['stylist']),'User.status'=>1)));
                                                    //pr($ServiceUser); die;
                                                    if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
                                                                $time = trim($appointment_detail['service'][$serviceId]['time']);
                                                                $date = $appointment_detail['package_date'];
                                                                $service_name = $serviceDetail['SalonService']['eng_name'];
                                                                if($ret_provider_status['SalonEmailSms']['business_sms_notify_provider']==1){
                                                                    $message = "You have new  appointment for the Service  $service_name  on date : $date $time .Your Order id is $display_order_id";
                                                                    $this->sendUserPhone($ServiceUser, $orderData,$message,'vendor');
                                                                 }
                                                                if($ret_provider_status['SalonEmailSms']['business_nofity_provider']==1){    
                                                                    $this->sendUserEmail($ServiceUser, $serviceDetail,$display_order_id ,$amount ,'new_appointment',$duration,'vendor');
                                                                }    
                                                     }
                                                }
                                    }
                                 if($appointment_detail['theBuktype'] == 'eVoucher'){
                                                $recipient_name = $this->request->data['Appointment']['recipient_name'];
                                                $recipient_message = $this->request->data['Appointment']['recipient_message'];
                                                $this->loadModel('Evoucher');
                                                $quantity = $appointment_detail['quantity'];
                                                $voucher_code = $this->Common->getRandPass(8);
                                                for($i =1; $i<=$quantity; $i++){
                                                    $evoucher['Evoucher']['order_id'] = $order_id;
                                                    $evoucher['Evoucher']['salon_id'] = $salon_id;
                                                    $evoucher['Evoucher']['user_id'] = $user_id;
                                                    $evoucher['Evoucher']['price'] = $tax_data['service_price_tax'];
                                                    $evoucher['Evoucher']['evoucher_type'] = ($appointment_detail['thetype']=='Package')?2:3;
                                                    $evoucher['Evoucher']['expiry_date'] = $recipient_name;
                                                    $evoucher['Evoucher']['expiry_date'] = $vocuher_expire;
                                                    $evoucher['Evoucher']['vocher_code'] = $voucher_code;
                                                    $evoucher['Evoucher']['reciepent_message'] = $recipient_message;
                                                    $this->Evoucher->create();
                                                    $this->Evoucher->save($evoucher);
                                                } 
                                 }  
                                }
                                ob_start();
                                $thetype = $appointment_detail['thetype'];
                                $package_name = $packageDetail['Package']['eng_name'];
                                $date = $appointment_detail['package_date'];
                                if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
                                   $orderData = $this->Common->get_Order($order_id); 
                                   $display_order_id = @$orderData ['Order']['display_order_id'];
                                   $package_salon_id = $packageDetail['Package']['user_id'];
                                    $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$package_salon_id,'User.id'=>$package_salon_id))));
                                        foreach($SalonBookingIncharges as $incharge){
                                               if($incharge['UserDetail']['booking_incharge']==1){
                                               if($appointment_detail['theBuktype'] == 'eVoucher'){
                                                   $message = " A new   $thetype $package_name Evocuher  has been sold. Your order id is $display_order_id";
                                                    $this->sendUserPackageEmail($incharge, $serviceDetails,$packageDetail ,$display_order_id ,$amount ,'evocuher_package_sold','vendor');
                                                    $this->sendUserPhone($incharge, $orderData,$message,'vendor');
                                                }else{
                                                $message = "You have new online  appointment for the $thetype  $package_name  on date : $date . Your order id is $display_order_id";
                                                $this->sendUserPackageEmail($incharge, $serviceDetails,$packageDetail ,$display_order_id ,$amount ,'new_package','vendor');
                                                $this->sendUserPhone($incharge, $orderData,$message,'vendor');
                                                }
                                          }
                                        }
                                }
                                // $this->Session->setFlash('your appointment is booked successfully.', 'flash_success');
                               // $this->redirect(array('controller'=>'homes','action'=>'index'));
                               if($order_status !='payment'){
                                $userDetail = $this->User->find('first', array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
                                if($order_status==="Success" || $order_status==="gift" || $order_status==="points")
                                 {
                                   $salon_name = $packageOwner['Salon']['eng_name'];
                                   $country_code = ($packageOwner['Contact']['country_code'])?$packageOwner['Contact']['country_code']:'+971';
                                   $Contact_no = '';
                                   if(!empty($packageOwner['Contact']['day_phone'])){
                                    $Contact_no  = $packageOwner['Contact']['country_code'].' '.$packageOwner['Contact']['day_phone']; 
                                   }
                                   
                                   
                                   $orderDat = $this->Common->get_Order($order_id); 
                                   $display_order_id = @$orderDat ['Order']['display_order_id'];
                                   
                                   if($appointment_detail['theBuktype'] == 'eVoucher'){
                                       $message = "You have purchased  evoucher for the  $thetype  $package_name successfully from salon $salon_name $Contact_no . Your order id is $display_order_id";
                                        $this->sendUserPackageEmail($userDetail, $serviceDetails, $packageDetail , $display_order_id  ,$amount ,'confirmation_spaday');
                                        $this->sendUserPhone($userDetail, $orderData,$message,'customer');
                                    }else{
                                        $message = "Your appointment for $thetype  $package_name  on date : $date with Salon $salon_name. See you soon.  $Contact_no . Your order id is $display_order_id";
                                        $this->sendUserPackageEmail($userDetail, $serviceDetails, $packageDetail , $display_order_id  ,$amount ,'confirmation_package');
                                        $this->sendUserPhone($userDetail, $orderData,$message,'customer');
                                    }
                                    $this->Session->delete('appointmentData');
                                    $this->Session->setFlash("Your Order is booked successfully.", 'flash_success');
                                            if($appointment_detail['theBuktype'] == 'eVoucher'){
                                                $this->redirect(array('controller'=>'Myaccount','action'=>'orders'));
                                            }else{
                                                $this->redirect(array('controller'=>'Myaccount','action'=>'appointments'));
                                            }
                                }else{
                                    $this->Session->setFlash('Your  transaction has been declined.Please try again.', 'flash_error');
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
                                             $this->render('../Bookings/payment');
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
                        }else
                        {
                            $this->Session->setFlash('Your  transaction has been declined due to Illegal access detected.', 'flash_error');
                            $this->redirect(array('controller'=>'homes','action'=>'index'));
                        }
                    }else{
                            $this->Session->setFlash('Your  transaction has been declined due to Illegal access detected.', 'flash_error');
                            $this->redirect(array('controller'=>'homes','action'=>'index'));
                        }
             } 
    }
    
    function sendUserPackageEmail($userData=array() , $serviceDetails = array(),$package =array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;
        $appointment_detail = $this->Session->read('appointmentData.Appointment');
        $thetype = $appointment_detail['thetype'];
        //$service_name = $serviceDetail['SalonService']['eng_name'];
        $service_name = array();
        
        $vendor_msg = $this->Common->get_vendor_message(@$serviceDetail['SalonService']['salon_id']);
        //pr($serviceDetails);
        foreach($serviceDetails as $serviceDetail){
           $serviceID = $serviceDetail['SalonService']['id'];
           $service_names[] =  $serviceDetail['SalonService']['eng_name'];
           $date[]  =   $appointment_detail['package_date'];       
           $time[] = trim($appointment_detail['service'][$serviceID]['time']);
           $duration[] = $this->Common->get_mint_hour($appointment_detail['service'][$serviceID]['duration']);
        }
        $i = 0; 
        $serviceData  = '';
        // die;
        if($appointment_detail['theBuktype'] == 'eVoucher'){
             foreach($service_names as $service_name){
                $serviceData  .= 'Service Name :' . $service_names[$i].'</br></br>';
                $i++;
            }
        }else{
            foreach($service_names as $service_name){
                $serviceData  .= 'Service Name :' . $service_names[$i].'</br> Date :'.$date[$i].' </br>  Time :'.$time[$i].' </br> Duration :'.$duration[$i].'</br></br>';
                $i++;
            }
        }
        $dynamicVariables = array(
                                  '{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{amount}' => $amount,
                                  '{package_name}'=> $package['Package']['eng_name'],
                                  '{order_id}'=>$order_id,
                                  '{service}'=> $serviceData,
                                  '{package_date}'=>$appointment_detail['package_date'],
                                  '{package}'=>$thetype,
                                  '{vendor_message}' => $vendor_msg
                                );
        if($template =='confirmation_package'){
            $salonDetail   =   $this->Common->salonDetail($package['Package']['user_id']); 
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
        $template_type =  $this->Common->EmailTemplateType($package['Package']['user_id']);
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
    
     function sendUserEmail($userData=array() , $serviceDetail = array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;
        $service_name = $serviceDetail['SalonService']['eng_name'];
        $appointment_detail = $this->Session->read('appointmentData.Appointment');
        $thetype = $appointment_detail['thetype'];
        $date = $appointment_detail['package_date'];
        $serviceId = $serviceDetail['SalonService']['id'];
        $time = trim($appointment_detail['service'][$serviceId]['time']);
         $vendor_msg = $this->Common->get_vendor_message(@$serviceDetail['SalonService']['salon_id']);
        $dynamicVariables = array('{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{amount}' => $amount,
                                  '{time}'=> $time,
                                  '{start_date}'=>$date,
                                  '{service_name}'=>$service_name,
                                  '{order_id}'=>$order_id,
                                     '{vendor_message}' => $vendor_msg
                                  );
        if($type=='gift'){
         $dynamicVariables['{gift_amount}'] = $points;   
        }else if($type=='points'){
          $dynamicVariables['{point}'] = $points;      
        }else if($type=='vendor'){
         $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($points);   
        }
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
    function sendUserPhone($userData=array(), $orderData = array(), $message = '', $type=null){
         if($userData && $type =='vendor'){
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
            }else if($type=='customer'){
		$number = $orderData['Order']['phone_number'];
		$this->Common->sendVerificationCode($message,$number);
	    }
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
  
}