<?php
class CheckoutController extends AppController {
    var $name = 'Checkout';
    public $helpers    = array('Session','Html','Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session','Common','Auth'); //An array containing the names of components this controller uses.
    
    function admin_appointment($appointmentId = 'null',$customerType = 'null', $appointment_date='null'){
        date_default_timezone_set('Asia/Dubai');
        $ID=$this->Session->read('selected_user_id');
        $this->Session->delete('userList');
        $appointmentTop=base64_decode($appointmentId);
        if($appointmentTop!='top'){
            $this->Session->delete('selected_user_id');
        }
        if($appointmentTop=='top' && empty($ID)){
            $this->loadModel('Appointment');
            $date=date('Y-m-d');
            $salon_id=$this->Auth->user('id');
            $this->Appointment->unbindModel(array('belongsTo' => array('SalonService')), true);
            $this->Appointment->bindModel(array(
                'belongsTo' => array(
                    'User' => 
                     array('foreignKey' => 'user_id')
                    )
                )
            );
            $conditions = array('fields'=>array('Appointment.id','Appointment.user_id','User.id','User.first_name'),
                'conditions' => array(
                    'OR'=>array(
                        'AND'=>array(
                            array('Appointment.appointment_repeat_end_date >='=>strtotime($date.' '.'00:00')),
                            array('Appointment.appointment_start_date <='=>strtotime($date.' '.'23:59'))),
                        array(
                        'AND'=>array(
                            array('Appointment.appointment_start_date >='=>strtotime($date.' '.'00:00')),
                            array('Appointment.appointment_start_date <='=>strtotime($date.' '.'23:59'))
                            )
                        )),
                    'AND'=>array(
                        array('Appointment.is_deleted'=>0),
                            array('Appointment.salon_id'=>$salon_id),
                                array('Appointment.status NOT IN(5,9,3,4)'))
                            )
            );
            $appointments=$this->Appointment->find('all',$conditions);
            $appointmentId=base64_encode($appointments[0]['Appointment']['id']);
            $todayTopCustomerlist=array();
            foreach($appointments as $appointment){
                $todayTopCustomerlist[base64_encode($appointment['User']['id'])]=$appointment['User']['first_name']; 
            }
        }elseif($appointmentTop=='top' && !empty($ID)){
            $this->loadModel('Appointment');
            $date=date('Y-m-d');
            $salon_id=$this->Auth->user('id');
            $this->Appointment->unbindModel(array('belongsTo' => array('SalonService')), true);
            $this->Appointment->bindModel(array(
                'belongsTo' => array(
                    'User' => 
                        array('foreignKey' => 'user_id')
                    )
                )
            );
            $conditions = array('fields'=>array('Appointment.id','Appointment.user_id','User.id','User.first_name'),
                'conditions' => array(
                    'OR'=>array(
                        'AND'=>array(
                            array('Appointment.appointment_repeat_end_date >='=>strtotime($date.' '.'00:00')),
                            array('Appointment.appointment_start_date <='=>strtotime($date.' '.'23:59'))),
                                'AND'=>array(
                                    array('Appointment.appointment_start_date >='=>strtotime($date.' '.'00:00')),
                                    array('Appointment.appointment_start_date <='=>strtotime($date.' '.'23:59'))
                            )
                    ),
                    'AND'=>array(
                        array('Appointment.is_deleted'=>0),
                        array('Appointment.salon_id'=>$salon_id),
                       // array('Appointment.user_id'=>$ID),
                        array('Appointment.status NOT IN(5,9,3,4)'))
                )
            );
            $appointments=$this->Appointment->find('all',$conditions);
            $appointmentId=base64_encode($appointments[0]['Appointment']['id']);
            $todayTopCustomerlist=array();
            foreach($appointments as $appointment){
                $todayTopCustomerlist[base64_encode($appointment['User']['id'])]=$appointment['User']['first_name']; 
            }
        }elseif($appointmentTop!='top' && !empty($appointmentId)){
            $this->loadModel('Appointment');
            $date=date('Y-m-d'); 
            $salon_id=$this->Auth->user('id');
            $conditions = array('fields'=>array('Appointment.id','Appointment.user_id','User.id','User.first_name','Appointment.appointment_start_date'),'conditions' => array('Appointment.id'=>base64_decode($appointmentId)));  
            $appointments=$this->Appointment->find('all',$conditions);
            //$appointment_date=$appointments[0]['Appointment']['appointment_start_date'];
            $date=date('Y-m-d',$appointments[0]['Appointment']['appointment_start_date']); 
            $this->Appointment->unbindModel(array('belongsTo' => array('SalonService')), true);
            $this->Appointment->bindModel(array(
                'belongsTo' => array(
                    'User' => 
                        array('foreignKey' => 'user_id')
                )
            ));
            $conditions = array('fields'=>array('Appointment.id','Appointment.user_id','User.id','User.first_name','User.last_name','User.email'),
                     'conditions' => array(
                    'OR'=>array(
                        'AND'=>array(
                            array('Appointment.appointment_repeat_end_date >='=>strtotime($date.' '.'00:00:00')),
                            array('Appointment.appointment_start_date <='=>strtotime($date.' '.'23:59:59')),
                            array('Appointment.appointment_repeat_end_date !='=>''),
                            array('Appointment.appointment_start_date >='=>strtotime($date.' '.'00:00:00'))),
                        array(
                            'AND'=>array(
                                array('Appointment.appointment_start_date >='=>strtotime($date.' '.'00:00:00')),
                                array('Appointment.appointment_start_date <='=>strtotime($date.' '.'23:59:59'))
                            )
                        )),
                    'AND'=>array(
                        array('Appointment.is_deleted'=>0),
                            array('Appointment.salon_id'=>$salon_id),
                                array('Appointment.status NOT IN(5,9,3,4)'))
                            )
                        );
            $appointments=$this->Appointment->find('all',$conditions);
            $appointmentId=base64_encode($appointments[0]['Appointment']['id']);
            $todayTopCustomerlist=array();
            foreach($appointments as $appointment){
                $todayTopCustomerlist[base64_encode($appointment['User']['id'])]=ucfirst($appointment['User']['first_name']).' '.ucfirst($appointment['User']['last_name']).' '.'('.$appointment['User']['email'].')'; 
            }
            
            $totalappcancellation = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$appointment['User']['id'],'Appointment.status'=>5,'Appointment.package_id'=>0)));
            $totalpackagecancellation = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$appointment['User']['id'],'Appointment.status'=>5,'Appointment.package_id !='=>0),'group' => array('Appointment.package_id')));
            $totalcancellation=$totalappcancellation+$totalpackagecancellation;
            $totalnoShow = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$appointment['User']['id'],'Appointment.status'=>8)));
            $this->set(compact('totalcancellation','totalnoShow'));
         
            
        }
        $appointment_date= base64_decode($appointment_date); 
        $giftCertificateData = $this->Session->read('giftCertificateData');
        if(!empty($giftCertificateData) && $giftCertificateData != ''){
            $allGiftCertificate = $this->Session->read('allGiftCertificate');
            $count=0;
            if(isset($allGiftCertificate) && !empty($allGiftCertificate)){
                $count=count($allGiftCertificate);
                $allGiftCertificate[$count-1] = $giftCertificateData;
                $this->Session->write('allGiftCertificate',$allGiftCertificate);
            }else{
                $giftCertificateData[] = $this->Session->read('giftCertificateData');
                $this->Session->write('allGiftCertificate',$giftCertificateData);
                $allGiftCertificate = $this->Session->read('allGiftCertificate');
            }
            if(isset($allGiftCertificate)){
                unset($allGiftCertificate['GiftCertificate']);
            }
            $this->Session->delete('giftCertificateData');
            $this->set('allGiftCertificate', $allGiftCertificate);
        }else{
            $allGiftCertificate=$this->Session->read('allGiftCertificate');
            if(isset($allGiftCertificate)){
                unset($allGiftCertificate['GiftCertificate']);
            }
            $this->set('allGiftCertificate', $allGiftCertificate);
            $this->Session->delete('giftCertificateData');
        }
        $productData = $this->Session->read('productData');
        if(!empty($productData) && $productData != ''){
            $allproductData = $this->Session->read('allproductData');
            $count=0;
            if(isset($allproductData) && !empty($allproductData)){
                $allproductDataId=array();
                $productDataId=array();
                for($k=0;$k<count($allproductData);$k++){
                    $allproductDataId[$k]=$allproductData[$k]['Product']['id'];    
                }
                for($j=0;$j<count($productData);$j++){
                    $productDataId[]=$productData[$j]['Product']['id'];
                }
                $s=0;
                $repeat='';
                for($i=0;$i<count($allproductData);$i++){
                    if (in_array($allproductData[$i]['Product']['id'], $productDataId)) {
                        $repeat=1;
                        if(isset($allproductData[$i]['count'])){
                            $allproductData[$i]['count']=$allproductData[$i]['count']+1;
                            if(isset($productData[$s])){
                                unset($productData[$s]);
                           }
                        }else{
                            $allproductData[$s]['count']=1;
                            unset($productData[$s]);
                        }
                        $s++;
                    }
                }
                if($repeat==''){
                    $productData[0]['count']=1;
                }else{
                    $repeat='';
                }
                $count=count($allproductData);
                foreach($productData as $productData){
                    $allproductData[$count] = $productData;
                    $count++;
                }
                $this->Session->write('allproductData',$allproductData);
            }else{
                $productDataSes = $this->Session->read('productData');
                for($t=0;$t<count($productDataSes);$t++){
                    $productDataSes[$t]['count']=1;
                }
                $this->Session->write('allproductData',$productDataSes);
                $allproductData = $this->Session->read('allproductData');
            }
            $this->Session->delete('productData');
            $this->set('allproductData', $allproductData);
        }else{
            $allproductData=$this->Session->read('allproductData');
            $this->set('allproductData', $allproductData);
            $this->Session->delete('productData');
        }
        $delete=$this->Session->read('delete');
        $serviceData=$this->Session->read('serviceData');
        if(empty($giftCertificateData) && $giftCertificateData == '' && empty($productData) && $productData == '' && empty($serviceData) && $serviceData == '' && empty($delete) && $delete == ''){
            $allGiftCertificate='';
            $allproductData='';
            $this->set('allGiftCertificate', $allGiftCertificate);
            $this->set('allproductData', $allproductData);
            $this->Session->delete('allGiftCertificate');
            $this->Session->delete('allproductData');
            $this->Session->delete('serviceData');
            $this->Session->delete('selected_user_id');
        }
        if(isset($serviceData) && $serviceData!=''){
            $this->Session->delete('serviceData');
        }
        $this->Session->delete('delete');
        $this->layout = "admin";
        $this->set('activeTMenu','');
        $this->set('page_title','Checkout');
        $appointmentData = $this->common_appointment_details($appointmentId);
        if($appointmentData) {
            $employeeId = $appointmentData['Appointment']['salon_staff_id'];
            $appointmentTime = date('Y-m-d',$appointmentData['Appointment']['appointment_start_date']);
            $appointmentTime_str = $appointmentData['Appointment']['appointment_start_date'];
            $salonUserId = $this->Auth->user('id');
            $apptnmentStrStart = strtotime($appointmentTime.' '.'00:00'); //die();
            $apptnmentStrEnd = strtotime($appointmentTime.' '.'23:59');
            $selected_user_id = $this->Session->read('selected_user_id');
	    if(!empty($selected_user_id) && (!empty($allproductData) || !empty($allGiftCertificate) || !empty($serviceData))){
		$userId = base64_decode($selected_user_id);
	    }else{
                $userId = $appointmentData['Appointment']['user_id']; 
            }
            // Find the details of user
            if(!empty($userId)){
                $this->loadModel('User');
                $cond = array('User.id'=>$userId);
                $user = $this->User->find('first',array('conditions'=>$cond));
                $this->set(compact('user'));
                $this->loadModel('UserCount');
                $totalPoints = $this->UserCount->find('all' , array('conditions'=>array('user_id'=>$user['User']['id'],'salon_id'=>array($salon_id,1)),'fields'=>array('(sum(UserCount.user_count)) AS total')));                $totalPoints = isset($totalPoints[0][0]['total'])?$totalPoints[0][0]['total']:0;
                $this->set('totalPoints',$totalPoints);
            }
            $TopTodaydate=date('Y-m-d');
            $TopStartdate = strtotime($TopTodaydate.' '.'00:00'); //die();
            $TopEnddate = strtotime($TopTodaydate.' '.'23:59');
            if($appointmentTop=='top' && empty($ID)){
                $userId='';
                $this->set('userId',$userId);
                $user='';
                $this->set('user',$user);
                $this->loadModel('Appointment');
                $totalappcancellation = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.status'=>5)));
                $totalpackagecancellation = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.status'=>5,'Appointment.package_id !='=>0),'group' => array('Appointment.package_id')));
                $totalcancellation=$totalappcancellation+$totalpackagecancellation;
                $totalnoShow = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.status'=>8)));
                $this->set(compact('totalcancellation','totalnoShow'));
                //$conditions = array("Appointment.salon_id"=>$salonUserId,'Appointment.status NOT IN(5,9,3,4,13)',"Appointment.is_deleted"=>0,"appointment_start_date >="=>$TopStartdate,"appointment_start_date <="=> $TopEnddate);
                $conditions = 
                    array(
                        'OR'=>array(
                            'AND'=>array(
                                array('Appointment.appointment_repeat_end_date >='=>strtotime($TopTodaydate.' '.'00:00')),
                                array('Appointment.appointment_start_date <='=>strtotime($TopTodaydate.' '.'23:59'))),
                            array(
                                'AND'=>array(
                                    array('Appointment.appointment_start_date >='=>strtotime($TopTodaydate.' '.'00:00')),
                                    array('Appointment.appointment_start_date <='=>strtotime($TopTodaydate.' '.'23:59'))
                                )
                            )
                        ),
                        'AND'=>array(
                                array('Appointment.is_deleted'=>0),
                                array('Appointment.salon_id'=>$salon_id),
                                array('Appointment.status NOT IN(5,9,3,4)'))
                    );
            }elseif($appointmentTop=='top' && !empty($ID)){
                $userId=$ID;
                $conditions = array("Appointment.salon_id"=>$salonUserId,"Appointment.user_id"=>$userId,'Appointment.status NOT IN(5,9,3,4)',"Appointment.is_deleted"=>0,"appointment_start_date >="=>$apptnmentStrStart,"appointment_start_date <="=> $apptnmentStrEnd);  
            }elseif($appointmentTop!='top' && !empty($appointmentId)){
                $conditions = array("Appointment.salon_id"=>$salonUserId,"Appointment.user_id"=>$userId,'Appointment.status NOT IN(5,9,3,4)',"Appointment.is_deleted"=>0,"appointment_start_date >="=>$apptnmentStrStart,"appointment_start_date <="=> $apptnmentStrEnd);
            }
            $userServices = $this->serviceData($conditions);
            if($userServices){
                $this->set('userAppointments',$userServices);
                //GET CURRENT USER'S ALL SERVICES FOR THE DAY (ENDS HERE)
                #Find all the IOU's of the selected user.
                $finalUserList = '';
                if($userServices){
                    $this->loadModel('Iou');
                    $all_iou = $this->Iou->find('all', array(
                        'conditions' => array(
                        'Iou.user_id' => $userId,
                        'Iou.is_deleted' => 0,
                        'Iou.status' => 0
                    ),
                        'order' =>array('Iou.total_iou_price DESC')
                    ));
                    $this->set(compact('all_iou'));
                    $this->Session->write('userServices',$userServices);
                    $this->Session->write('all_iou',$all_iou);
                }
                // get today customers
                $salonUserId= $this->Auth->user('id');
                $this->loadModel('User');
                App::import('Controller', 'Users');
                $this->Users = new UsersController;
                $userList = $this->Users->findallCustomerList();
                $this->set('userId',$userId);
                $todaycustList = $this->Appointment->find('list', array(
                    'fields' => array('User.id','User.first_name'),
                    'conditions' => array("Appointment.salon_id"=>$salonUserId,"Appointment.status NOT IN(5,9,3,4)","appointment_start_date >="=>$apptnmentStrStart,"appointment_start_date <="=> $apptnmentStrEnd),
                    'recursive' => 1
                ));
                if(isset($todayTopCustomerlist)){
                    $todaycustList=$todayTopCustomerlist;
                }
                if($todaycustList){
                    foreach($todaycustList as $key => $todayList){
                        $encodedKey = base64_encode($key);
                        $encodedCustList[$encodedKey] = $todayList;
                    }
                    $finalUserList = array_intersect_key($userList,$encodedCustList);
                    if($this->request->is('ajax')){
                        $this->layout = 'ajax';
                        if($customerType == 2){
                            $this->layout = 'ajax';
                            $finalUserList = $userList;
                            $this->set('userList',$finalUserList);
                            $this->viewPath = "Elements/checkout/";
                            $this->render('appointment_customer_detail');
                        }
                        elseif($customerType == 1){
                            $todaycustList = $this->Appointment->find('list', array(
                                'fields' => array('User.id','User.first_name'),
                                'conditions' => array("Appointment.salon_id"=>$salonUserId,"Appointment.status NOT IN(5,9,3,4)","appointment_start_date >="=>$apptnmentStrStart,"appointment_start_date <="=> $apptnmentStrEnd),
                                'recursive' => 1
                            ));
                            foreach($todaycustList as $key => $todayList){
                                $encodedKey = base64_encode($key);
                                $encodedCustList[$encodedKey] = $todayList;
                            }
                            $finalUserList = array_intersect_key($userList,$encodedCustList);
                            if(!$userServices){
                                $finalUserList = '';
                            }
                            $this->set('userList',$finalUserList);
                            $this->viewPath = "Elements/checkout/";
                            $this->render('appointment_customer_detail');
                        }
                    }elseif(isset($todayTopCustomerlist) && !empty($todaycustList)){
                        //$todaycustList = $this->Appointment->find('list', array(
                        //'fields' => array('User.id','User.first_name'),
                        // 'conditions' => array("Appointment.salon_id"=>$salonUserId,'payment_status'=> 0,"appointment_start_date >="=>$apptnmentStrStart,"appointment_start_date <="=> $apptnmentStrEnd),
                        // 'recursive' => 1
                        //));
                        //foreach($todaycustList as $key => $todayList){
                        //   $encodedKey = base64_encode($key);
                        //  $encodedCustList[$encodedKey] = $todayList;
                        // }
                        // $finalUserList = array_intersect_key($userList,$encodedCustList);
                        //}else{
                        $finalUserList = $todaycustList;
                    }elseif($userServices){
                        $todaycustList = $this->Appointment->find('list', array(
                            'fields' => array('User.id','User.first_name'),
                            'conditions' => array("Appointment.salon_id"=>$salonUserId,"Appointment.status NOT IN(5,9,3,4)","appointment_start_date >="=>$apptnmentStrStart,"appointment_start_date <="=> $apptnmentStrEnd),
                            'recursive' => 1
                        ));
                        foreach($todaycustList as $key => $todayList){
                            $encodedKey = base64_encode($key);
                            $encodedCustList[$encodedKey] = $todayList;
                        }
                        $finalUserList = array_intersect_key($userList,$encodedCustList);
                    }else{
                        $finalUserList = '';
                    }
                }else{
                    if(($customerType == 1 || $customerType== 2) && $userServices){
                        $this->layout = 'ajax';
                        $this->set('userList',$finalUserList);
                        $this->viewPath = "Elements/checkout/";
                        $this->render('appointment_customer_detail');    
                    }
                    else{
                        $finalUserList = '';
                    }
                }
                $this->loadModel('TaxCheckout');
                $tax_amount = $this->TaxCheckout->find('all', array(
                            'fields' => array('TaxCheckout.id','TaxCheckout.user_id','TaxCheckout.tax1','TaxCheckout.tax2'),
                            'conditions' => array("TaxCheckout.id"=>$salonUserId
                        )));
                if(count($tax_amount)>0){
                    if(isset($tax_amount[0]['TaxCheckout']['tax1']) && !empty($tax_amount[0]['TaxCheckout']['tax1'])){
                        $tax1_amount=$tax_amount[0]['TaxCheckout']['tax1'];
                    }else{
                        $tax1_amount=0;
                    }
                    if(isset($tax_amount[0]['TaxCheckout']['tax2']) && !empty($tax_amount[0]['TaxCheckout']['tax2'])){
                        $tax2_amount=$tax_amount[0]['TaxCheckout']['tax2'];
                    }else{
                        $tax2_amount=0;
                    }
                }else{
                    $tax_amount_admin = $this->TaxCheckout->find('all', array(
                            'fields' => array('TaxCheckout.id','TaxCheckout.user_id','TaxCheckout.tax1','TaxCheckout.tax2'),
                            'conditions' => array("TaxCheckout.id"=>1
                        ))); 
                    if(count($tax_amount_admin)>0){
                        if(isset($tax_amount_admin[0]['TaxCheckout']['tax1']) && !empty($tax_amount_admin[0]['TaxCheckout']['tax1'])){
                            $tax1_amount=$tax_amount_admin[0]['TaxCheckout']['tax1'];
                        }else{
                            $tax1_amount=0;
                        }
                        if(isset($tax_amount_admin[0]['TaxCheckout']['tax2']) && !empty($tax_amount_admin[0]['TaxCheckout']['tax2'])){
                            $tax2_amount=$tax_amount_admin[0]['TaxCheckout']['tax2'];
                            $tax2_amount=0;
                        }
                    }
                }
                $this->set(compact('appointmentData','custList','employeeId','userId','appointment_date','tax1_amount','tax2_amount'));
                $this->Session->write('userList',$finalUserList);
                $this->set('userList',$finalUserList);
                $this->set('appointmentTime',$appointmentTime_str);
                if(isset($this->request->data)  && !empty($this->request->data)){
                    $this->loadModel('Cart');
                    $this->Cart->save($this->request->data);
                }
            }else{
                $this->Session->setFlash('Already Checkout or Something is not right', 'flash_error');
                $this->redirect(array('controller' => 'appointments', 'action' => 'index', 'admin' => true                ));
            }
        }else{
            $this->Session->setFlash('You cannot access this Appointment.', 'flash_error');
            $this->redirect(array('controller' => 'appointments', 'action' => 'index', 'admin' => true));
        }
    }
    
    function common_appointment_details($appointmentId = null){
        $appointmentId = base64_decode($appointmentId);
        $this->loadModel('Appointment');
        $todayStart = strtotime(date('Y-m-d 00:00'));
        $todayEnd = strtotime(date('Y-m-d 11:59'));
        $fields = array(
                    "Appointment.appointment_title",
                    "Appointment.id",
                    "Appointment.appointment_price",
                    "Appointment.appointment_start_date",
                    "Appointment.salon_staff_id",
                    "Appointment.salon_id",
                    "Appointment.user_id",
                    "Appointment.payment_status ",
                    "Appointment.status",
                    "User.first_name",
                    "User.last_name",
                    "ServiceProvider.first_name",
                    "ServiceProvider.last_name"
                );
        $this->Appointment->bindModel(array('belongsTo' => array(
            'User'=>array(
                'className' => 'User',
                'foreignKey' => 'user_id'
            ),
            'ServiceProvider'=>array(
                'className' => 'User',
                'foreignKey' => 'salon_staff_id'
                )
            )
        ),false);
        $appointmentData = $this->Appointment->find('first',array('conditions'=>array("Appointment.id"=>$appointmentId),'fields'=>$fields));
        return $appointmentData;
    }
    
    function admin_getUserServices($user_id=null, $appointmentTime=null, $payeeUserId=null){
        $user_id=base64_decode($user_id);
        $this->Session->delete('userServices');
        $this->Session->delete('all_iou');
        $this->Session->delete('allproductData');
        $this->Session->delete('allGiftCertificate');
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            if(!empty($user_id)){
                $this->Session->write('selected_user_id', $user_id);
            }
            $this->Session->delete('productData');
            $this->loadModel('Appointment');
            $userId=$user_id;
            $salonUserId= $this->Auth->user('id');
            $apptmentDateStart = date('Y-m-d 00:00',$appointmentTime);
            $apptmentDateEnd = date('Y-m-d 23:59',$appointmentTime);
            $apptnmentStrStart = strtotime($apptmentDateStart);
            $apptnmentStrEnd = strtotime($apptmentDateEnd);
            $conditions = array("Appointment.salon_id"=>$salonUserId,"Appointment.user_id"=>$userId,"Appointment.status NOT IN(5,9,3,4)","Appointment.is_deleted"=>0, "Appointment.appointment_start_date >="=>$apptnmentStrStart,"Appointment.appointment_start_date <= $apptnmentStrEnd");
            /*$conditions = array(
                    'OR'=>array(
                        'AND'=>array(
                            array('Appointment.appointment_repeat_end_date >='=>$apptmentDateStart),
                            array('Appointment.appointment_start_date <='=>$apptmentDateEnd)),
                        array(
                        'AND'=>array(
                            array('Appointment.appointment_start_date >='=>$apptmentDateStart),
                            array('Appointment.appointment_start_date <='=>$apptmentDateEnd)
                            )
                        )),
                    'AND'=>array(
                        array('Appointment.is_deleted'=>0),
                            array('Appointment.salon_id'=>$salonUserId),
                            array("Appointment.user_id"=>$userId),
                                array('Appointment.status NOT IN(5,9,3,4)'))
                            
            );*/
            $userServices = $this->serviceData($conditions);
            $this->set('userAppointments',$userServices);
            #Find all the IOU's of the selected user.
            if($userServices){
                $this->loadModel('Iou');
                $all_iou = $this->Iou->find('all', array(
                    'conditions' => array(
                        'Iou.user_id' => $userId,
                        'Iou.status' => 0,
                        'Iou.is_deleted' => 0
                    ),
                ));
                $this->set(compact('all_iou'));
                $this->Session->write('userServices',$userServices);
                $this->Session->write('all_iou',$all_iou);
            }
            $this->set('payeeUserId',$payeeUserId);
            $this->viewPath = "Elements/checkout/";
            $this->render('appointment_details');
        }
    }
    
    function admin_getCheckoutDetail($userId,$appointmentTime){
        $this->loadModel('Appointment');
        $userId = base64_decode($userId);
        $salonUserId= $this->Auth->user('id');
        $apptmentDateStart = date('Y-m-d 00:00',$appointmentTime);
        $apptmentDateEnd = date('Y-m-d 11:59',$appointmentTime);
        $apptnmentStrStart = strtotime($apptmentDateStart);
        $apptnmentStrEnd = strtotime($apptmentDateEnd);
        $conditions = array("Appointment.salon_id"=>$salonUserId,"Appointment.user_id"=>$userId,'payment_status'=> 0,"Appointment.is_deleted"=>0,"appointment_start_date >="=>$apptnmentStrStart,"appointment_start_date <= $apptnmentStrEnd");
        $userServices = $this->serviceData($conditions);
        $this->set('userAppointments',$userServices);
        if($userServices){
            #Find all the IOU's of the selected user.
            $this->loadModel('Iou');
            $all_iou = $this->Iou->find('all', array(
                'conditions' => array(
                    'Iou.user_id' => $userId,
                    'Iou.is_deleted' => 0,
                    'Iou.status' => 0
                ),
            ));
            $this->set(compact('all_iou'));
        }
        $this->loadModel('TaxCheckout');
        $tax_amount = $this->TaxCheckout->find('all', array(
                        'fields' => array('TaxCheckout.id','TaxCheckout.user_id','TaxCheckout.tax1','TaxCheckout.tax2'),
                        'conditions' => array("TaxCheckout.id"=>$salonUserId
                    )));
        if(count($tax_amount)>0){
            if(isset($tax_amount[0]['TaxCheckout']['tax1']) && !empty($tax_amount[0]['TaxCheckout']['tax1'])){
                $tax1_amount=$tax_amount[0]['TaxCheckout']['tax1'];
            }else{
                $tax1_amount=0;
            }
            if(isset($tax_amount[0]['TaxCheckout']['tax2']) && !empty($tax_amount[0]['TaxCheckout']['tax2'])){
                $tax2_amount=$tax_amount[0]['TaxCheckout']['tax2'];
            }else{
                $tax2_amount=0;
            }
        }else{
            $tax_amount_admin = $this->TaxCheckout->find('all', array(
                    'fields' => array('TaxCheckout.id','TaxCheckout.user_id','TaxCheckout.tax1','TaxCheckout.tax2'),
                    'conditions' => array("TaxCheckout.id"=>1
            ))); 
            if(count($tax_amount_admin)>0){
                if(isset($tax_amount_admin[0]['TaxCheckout']['tax1']) && !empty($tax_amount_admin[0]['TaxCheckout']['tax1'])){
                    $tax1_amount=$tax_amount_admin[0]['TaxCheckout']['tax1'];
                }else{
                    $tax1_amount=0;
                }
                if(isset($tax_amount_admin[0]['TaxCheckout']['tax2']) && !empty($tax_amount_admin[0]['TaxCheckout']['tax2'])){
                    $tax2_amount=$tax_amount_admin[0]['TaxCheckout']['tax2'];
                    $tax2_amount=0;
                }
            }
        }
        $this->set(compact('tax1_amount','tax2_amount'));
        $this->layout = "ajax";
        $this->viewPath = "Elements/checkout/";
        $this->render('checkout_detail');
    }
    
    function serviceData($conditions){
        //Bind models
        $this->Appointment->unbindModel(array('belongsTo' => array('User','SalonService')));
        $this->Appointment->bindModel(array('belongsTo' => array(
            'User'=>array(
                'className' => 'User',
                'foreignKey' => 'user_id'
            ),
            'ServiceProvider'=>array(
                'className' => 'User',
                'foreignKey' => 'salon_staff_id'
                )
            )
        ));
        //get TOdays's services of a user
        $fields = array(
            "Appointment.appointment_title",
            "Appointment.id",
            "Appointment.appointment_price",
            "Appointment.salon_staff_id",
            'Appointment.salon_service_id',
            "Appointment.user_id",
            "Appointment.salon_id",
            "Appointment.appointment_price",
            "Appointment.payment_status",
            "Appointment.discount_value",
            "Appointment.appointment_start_date",
            "Appointment.price_after_discount",
            "Appointment.discount_type",
            "Appointment.points_redeem",
            "User.first_name",
            "User.last_name",
            "ServiceProvider.first_name",
            "ServiceProvider.last_name"
        );
        $data = $this->Appointment->find('all', array(
            'fields' => $fields,
            'conditions' =>$conditions,
            'recursive' => 1
        ));
        return $data;
    }
    
    function admin_success(){
        
    }
    
    function admin_addAppointment($appointmentDate=NULL,$time=NULL,$employeeId = NULL,$userId=null,$editType=null){
        $this->loadModel('Appointment');
        $salonUserId= $this->Auth->user('id');
        if(!empty($this->request->data)){
            $this->request->data['Appointment']['startdate']=date('Y/m/d',$appointmentDate);
            $this->request->data['Appointment']['salon_id'] = $salonUserId;
            $errors=array();
            $field=array();
            $field=array('fieldList'=>array('salon_service_id','startdate','time','user_id','appointment_price','appointment_duration'));
            $this->request->data['Appointment']['appointment_price'] = $this->request->data['Appointment']['price_'.$this->data['Appointment']['check']];
            $this->request->data['Appointment']['appointment_duration'] = $this->request->data['Appointment']['duration_'.$this->data['Appointment']['check']];
            $this->Appointment->set($this->request->data);
            if($this->Appointment->validates($field)){   
                $this->loadModel('SalonService');
                $userId=base64_decode($this->request->data['Appointment']['user_id']);
                $this->loadmodel('User');
                $salon_service_id=$this->data['Appointment']['salon_service_id'];
                $service_name=$this->SalonService->find('first',array('fields'=>array('eng_display_name','eng_name','service_id'),'conditions'=>array('SalonService.id'=>$salon_service_id)));
                if($service_name['SalonService']['eng_name']!=''){
                    $salon_service_name=$service_name['SalonService']['eng_name'];
                }
                else{
                    $this->loadModel('Service');
                    $salon_service_name_by_service_id=$this->Service->find('first',array('fields'=>array('eng_display_name','eng_name'),'conditions'=>array('Service.id'=>$service_name['SalonService']['service_id'])));
                    $salon_service_name = $salon_service_name_by_service_id['Service']['eng_name'];
                }
                $customeName=$this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
                $theCustomerName = $customeName['User']['first_name'].' '.$customeName['User']['last_name'];
                $checked=$this->request->data['Appointment']['check'];
                $appointment_title = $theCustomerName.'-'.$salon_service_name;
                $this->request->data['Appointment']['appointment_title']=$appointment_title;
                $this->request->data['Appointment']['user_id']=$userId;
                $this->request->data['Appointment']['appointment_price']=$this->request->data['Appointment']['price_'.$checked];
                $this->request->data['Appointment']['appointment_duration']=$this->request->data['Appointment']['duration_'.$checked];
                if(isset($editType) && $editType!='series'){
                    $this->request->data['Appointment']['startdate'] = str_replace('/', '-', $this->request->data['Appointment']['startdate']);
                    $this->request->data['Appointment']['appointment_start_date']= strtotime($this->request->data['Appointment']['startdate'].' '.$this->request->data['Appointment']['time']);
                }
               $this->request->data['Appointment']['startdate'] = str_replace('/', '-', $this->request->data['Appointment']['startdate']);
                    $this->request->data['Appointment']['appointment_start_date']= strtotime($this->request->data['Appointment']['startdate'].' '.$this->request->data['Appointment']['time']);
                $this->request->data['Appointment']['appointment_created']=date('Y-m-d h:m:s');
                $this->request->data['Appointment']['status']=1;
                if($this->Appointment->save($this->request->data['Appointment'],false)){
                    $this->Session->write('serviceData',$this->request->data['Appointment']);
                    $record_id=$this->Appointment->id;
                    $this->loadModel('AppointmentHistory');
                    $appointment_history['AppointmentHistory']['appointment_id']=$record_id;
                    $appointment_history['AppointmentHistory']['action']='Created';
                    $this->AppointmentHistory->save($appointment_history['AppointmentHistory'],false);
                    $edata['data'] = 'success' ;
                    $edata['user_id'] = base64_encode($this->request->data['Appointment']['user_id']);
                    $edata['message'] = __('Appointment added successfully',true);
                    echo json_encode($edata);
                    die;    
                }else{
                    $message = __('Unable to add appointment, Please try again.', true);
                    $vError = $this->Appointment->validationErrors;
                    if(!empty($vError['appointment_price']) && isset($vError['appointment_price'])){
                        $vError['price_'.$this->data['Appointment']['check']] = $vError['appointment_price'];
                    }
                    if(!empty($vError['appointment_duration']) && isset($vError['appointment_duration'])){
                        $vError['duration_'.$this->data['Appointment']['check']] = $vError['appointment_duration'];
                    }
                    $edata['data'] =$vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
            }
        else{
            $message = __('Unable to add appointment, Please try again.', true);
            $vError = $this->Appointment->validationErrors;
            if(!empty($vError['appointment_price']) && isset($vError['appointment_price'])){
                $vError['price_'.$this->data['Appointment']['check']] = $vError['appointment_price'];
            }
            if(!empty($vError['appointment_duration']) && isset($vError['appointment_duration'])){
                $vError['duration_'.$this->data['Appointment']['check']] = $vError['appointment_duration'];
            }
            $edata['data'] =$vError;
            $edata['message'] = $message;
            echo json_encode($edata);
            die;
            }
        }
        $staffServices = $this->Common->getStaffServiceList($employeeId, $this->Auth->user('id'));
        $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
        if(isset($calsettings['SalonCalendarSetting']['service_provider_order']) && !empty($calsettings['SalonCalendarSetting']['service_provider_order'])){
            $staffOrder = explode(',',$calsettings['SalonCalendarSetting']['service_provider_order']);
            $staff = $this->Common->staffSortbySorder($staff,$staffOrder);
        }
        $staff_list=array();
        foreach($staff as $staff){
            $staff_list[$staff['User']['id']]=$staff['User']['first_name'].' '.$staff['User']['last_name'];
        }
        $editType= "";
        $this->set(compact('staffServices','employeeId','staff','staff_list','time','editType','userId'));
    }
    
    function admin_serviceCheckout($appointmentId = null){
        if($this->request->is('post') || $this->request->is('ajax')){
            $checkoutData = $this->request->data;
            //print_r($this->request->data); die;
            //if(isset($checkoutData['cart']['email']) && $checkoutData['cart']['email']==1){
              //  $emailReceipt='true';
            //}else{
             //   $emailReceipt='false';
            //}
            //if(isset($checkoutData['cart']['print']) && $checkoutData['cart']['print']==1){
             //   $printReceipt='true';
            //}else{
             //   $printReceipt='false';
           // }
            $product_details = array();
            if(isset($checkoutData['product_discount_price']) && $checkoutData['product_discount_price'] != ''){
                $i = 0;
                foreach($checkoutData['product_discount_price'] as $key => $product){
                    $product_details[$i]['id'] = $key;
                    $product_details[$i]['price'] = $product;
                    $i++;
                }    
            }
            $gc_details = array();
            if(isset($checkoutData['gc_discount_price']) && $checkoutData['gc_discount_price'] != ''){
                $j = 0;
                foreach($checkoutData['gc_discount_price'] as $key => $gc){
                    $gc_details[$j]['id'] = $key;
                    $gc_details[$j]['price'] = $gc;
                    $j++;
                }
            }
            $appointmentId = explode(',', $appointmentId);
            $this->autoRender = false;
            $this->loadModel('Order');
            $this->loadModel('Appointment');
            // Find the total deducted points of the services to insert in order table
            $services_deducted_points = 0;
            foreach($checkoutData['service_points'] as $key => $service_points){
                $services_deducted_points = $services_deducted_points + $service_points;
            }
            // Find the total given points of the services
            $appointmentsDetails = $this->Appointment->find('all', array(
                'conditions' => array('Appointment.id' => $appointmentId),
                'fields' => array('id', 'points_given'),
                'recursive' => false
            ));
            $services_given_points = 0;
            foreach($appointmentsDetails as $key => $appointment){
                $services_given_points = $services_given_points + $appointment['Appointment']['points_given'];    
            }
            $appointmentData = $this->Appointment->find('first', array('conditions' => array('Appointment.id' => $appointmentId)));
            if(isset($appointmentData) && $appointmentData != ""){
               if(isset($checkoutData['service_charges'])){
                $checkoutData['cart']['service_charges']=$checkoutData['service_charges'];
                $checkoutData['cart']['product_charges']=$checkoutData['product_charges'];
                $checkoutData['cart']['gift_charges']=$checkoutData['gift_charges'];
                $checkoutData['cart']['ttl_discount']=$checkoutData['ttl_discount'];
                $checkoutData['cart']['tax']=$checkoutData['tax'];
                $checkoutData['cart']['tip']=$checkoutData['tip'];
                $checkoutData['cart']['cash_amt']=$checkoutData['cash_amt'];
                $checkoutData['cart']['chk_amt']=$checkoutData['chk_amt'];
                $checkoutData['cart']['gc_amt']=$checkoutData['gc_amt'];
                $checkoutData['cart']['credit_card_type']=$checkoutData['credit_card_type'];
                $checkoutData['cart']['credit_card_number']=$checkoutData['credit_card_number'];
                $checkoutData['cart']['amount_paid']=$checkoutData['amount_paid'];
               }
               
                $data = array(
                    'user_id' => $appointmentData['Appointment']['user_id'],
                    'display_order_id' => $this->Common->getRandPass(10),
                    'employee_id' => $appointmentData['Appointment']['salon_staff_id'],
                    'salon_id' => $appointmentData['Appointment']['salon_id'],
                    'salon_service_id' => $appointmentData['Appointment']['salon_service_id'],
                    'from_cancelled' => 0,
                    'transaction_status' => 1,
                    'is_checkout' => 1,
                    'transaction_message' => "Total Checkout",
                    'amount' => $checkoutData['cart']['service_charges'],
                    'product_charges' => $checkoutData['cart']['product_charges'],
                    'gift_charges' => $checkoutData['cart']['gift_charges'],
                    'ttl_discount' => $checkoutData['cart']['ttl_discount'],
                    'tax' => $checkoutData['cart']['tax'],
                    'tip' => $checkoutData['cart']['tip'],
                    'cash_amt' => $checkoutData['cart']['cash_amt'],
                    'chk_amt' => $checkoutData['cart']['chk_amt'],
                    'gc_amt' => $checkoutData['cart']['gc_amt'],
                    'points_redeem' => $services_deducted_points,
                    'points_given' => $services_given_points,
                    'credit_card_type' => $checkoutData['cart']['credit_card_type'],
                    'credit_card_number' => $checkoutData['cart']['credit_card_number'],
                    'product_ids' => serialize($product_details),
                    'giftcertificate_ids' =>  serialize($gc_details)
                );
            } 
            $field = array('fieldList' => array('user_id','employee_id','salon_id','salon_service_id','from_cancelled','transaction_status','is_checkout','transaction_message','amount','product_charges','gift_charges','ttl_discount','tax','tip','cash_amt','chk_amt','gc_amt'));
            if($this->Order->validates($field)){
                if($this->Order->save($data,false)){
                    $this->loadModel('OrderDetail');
                    $date = date('Y-m-d',  $appointmentData['Appointment']['appointment_start_date']);
                    $time = date('H:i',  $appointmentData['Appointment']['appointment_start_date']);
                    foreach($appointmentId as $key => $id ){
                        $data = array(
                            'order_id' =>  $this->Order->getLastInsertId(),
                            'user_id' => $appointmentData['Appointment']['user_id'],
                            'salon_id' => $appointmentData['Appointment']['salon_id'],
                            'employee_id' => $appointmentData['Appointment']['salon_staff_id'],
                            'service_id' => $appointmentData['Appointment']['salon_service_id'],
                            'appointment_id' => $id,
                            'duration' => $appointmentData['Appointment']['appointment_duration'],
                            'start_date' => $date,
                            'time' => $time,
                            'price' => $appointmentData['Appointment']['appointment_price'],
                            'eng_service_name' => $appointmentData['SalonService']['eng_name'],
                            'ara_service_name' => $appointmentData['SalonService']['ara_name']
                        );
                        $orderDetailField = array('fieldList' => array('user_id','order_id','salon_id','employee_id','service_id','appointment_id','price_option_id','duration','start_date','time','price','eng_service_name','ara_service_name'));
                        $this->OrderDetail->create();
                        if($this->OrderDetail->save($data,false)){
                            foreach($checkoutData['service_points'] as $key => $checkoutPrice1){
                                if(isset($checkoutData['service_price'][$key])){
                                    $checkoutPrice = $checkoutData['service_price'][$key];
                                    /**** Change Status of repeating appointments***/
                                    if($appointmentData['Appointment']['appointment_repeat_type']>0){
                                        if($appointmentData['Appointment']['changed_status']!=''){
                                            $checkdate=date('Y-m-d',$checkoutData['cart']['appointment_date']);
                                            $checktime=date('H:i',$checkoutData['cart']['appointment_time']);
                                            $checkDateTime=strtotime($checkdate.' '.$checktime); 
                                            $status_array=unserialize(base64_decode($appointmentData['Appointment']['changed_status']));
                                            $status_array1=$status_array;
                                            $count= count($status_array1);
                                            if($status_array[$count-1]['date']==$checkDateTime){
                                                $status_array1[$count-1]['date']=$checkDateTime;
                                                $status_array1[$count-1]['status']=3;
                                                $status_array1[$count-1]['payment_status']=1;
                                            }else{
                                                $status_array1[$count]['date']=$checkDateTime;
                                                $status_array1[$count]['status']=3;
                                                $status_array1[$count-1]['payment_status']=1;
                                            }
                                        }else{
                                            $checkdate=date('Y-m-d',$checkoutData['cart']['appointment_date']);
                                            $checktime=date('H:i',$checkoutData['cart']['appointment_time']);
                                            $checkDateTime=strtotime($checkdate.' '.$checktime); 
                                            $status_array1[0]['date']=$checkDateTime;
                                            $status_array1[0]['status']=3;
                                            $status_array1[0]['payment_status']=1;
                                        }
                                        $data = array(
                                                'Appointment.order_id' =>  $this->Order->getLastInsertId(),
                                                'Appointment.changed_status' => "'".base64_encode(serialize($status_array1))."'",
                                                'Appointment.appointment_price' => $checkoutPrice,
                                            ); 
                                    }else{
                                        $data = array(
                                            'Appointment.order_id' =>  $this->Order->getLastInsertId(),
                                            'Appointment.payment_status' => 1,
                                            'Appointment.status' => 3,
                                            'Appointment.appointment_price' => $checkoutPrice,
                                        );
                                    }
                                    $this->Appointment->id = $key;
                                    if($this->Appointment->updateAll($data, array('Appointment.id' => $key))){
                                    }else{
                                        $message = __('Something Went wrong while updating Appointments, Please try again.', true);
                                        $vError = $this->Appointment->validationErrors;
                                        $edata['data'] = $vError;
                                        $edata['message'] = $message;
                                        echo json_encode($edata);
                                        die;
                                    }
                                }
                            }
                        }else{
                            $message = __('Something Went wrong while saving order details, Please try again.', true);
                            $vError = $this->Order->validationErrors;
                            $edata['data'] = $vError;
                            $edata['message'] = $message;
                            echo json_encode($edata);
                            die;
                        }
                    }
                    $allGiftCertificate=$this->Session->read('allGiftCertificate');
                   // pr($allGiftCertificate); die;   
                    $newgiftarray=array();
                    for($i=0;$i<count($allGiftCertificate)-1;$i++){
                        $this->loadModel('GiftCertificate');
                        $newgiftarray[$i]['GiftCertificate']['id']='';
                        $newgiftarray[$i]['GiftCertificate']['gift_certificate_no']=$allGiftCertificate[$i]['GiftCertificate']['gift_certificate_no'];
                        $newgiftarray[$i]['GiftCertificate']['image']=$allGiftCertificate[$i]['GiftCertificate']['image'];
                        $newgiftarray[$i]['GiftCertificate']['amount']=$allGiftCertificate[$i]['GiftCertificate']['amount'];
                        $newgiftarray[$i]['GiftCertificate']['total_amount']=$allGiftCertificate[$i]['GiftCertificate']['amount'];
                        $newgiftarray[$i]['GiftCertificate']['first_name']=$allGiftCertificate[$i]['GiftCertificate']['recipient_first_name'];
                        $newgiftarray[$i]['GiftCertificate']['last_name']=$allGiftCertificate[$i]['GiftCertificate']['recipient_last_name'];
                        $newgiftarray[$i]['GiftCertificate']['email']=$allGiftCertificate[$i]['GiftCertificate']['recipient_email'];
                        $newgiftarray[$i]['GiftCertificate']['messagetxt']=$allGiftCertificate[$i]['GiftCertificate']['messagetxt'];
                        $newgiftarray[$i]['GiftCertificate']['expire_on']=$allGiftCertificate[$i]['GiftCertificate']['expire_on'];
                        $newgiftarray[$i]['GiftCertificate']['print_certificate_status']=$allGiftCertificate[$i]['GiftCertificate']['print_certificate_status'];
                        $newgiftarray[$i]['GiftCertificate']['send_email_status']=$allGiftCertificate[$i]['GiftCertificate']['send_email_status'];
                        $newgiftarray[$i]['GiftCertificate']['gift_image_category_id']=$allGiftCertificate[$i]['GiftCertificate']['gift_image_category_id'];
                        $newgiftarray[$i]['GiftCertificate']['gift_image_id']=$allGiftCertificate[$i]['GiftCertificate']['gift_image_id'];
                        $newgiftarray[$i]['GiftCertificate']['sender_id']=$allGiftCertificate[$i]['GiftCertificate']['sender_id'];
                        $this->GiftCertificate->save($newgiftarray[$i],false);
                        $this->send_emails($newgiftarray[$i]);
                    }
                    $sesallproductData=$this->Session->read('allproductData');
                    if(isset($sesallproductData) && count($sesallproductData)>0){
                        $this->loadModel('ProductHistory');
                        $this->loadModel('Product');
                        foreach($sesallproductData as $sesallproductData){
                            //Deduct product quantity
                           // $change_qua_array = array(
                             //   'Checkout' => array(
                               // 'id'=>$sesallproductData['Product']['id'],
                               // 'quantity'=>$sesallproductData['Product']['quantity']-$sesallproductData['count'],
                               // )
                            //);
                            //$this->Product->save($change_qua_array, false, array('quantity'));
                            
                            
                            
                            
                            $change_qua_array = array(
                                            'quantity'=>$sesallproductData['Product']['quantity']-$sesallproductData['count']
                                        );
                                        $this->Product->updateAll($change_qua_array, array('id'=>$sesallproductData['Product']['id']));
                             
                            $data['ProductHistory']['product_id']=$sesallproductData['Product']['id'];
                            $data['ProductHistory']['qty']=$sesallproductData['count'];
                            $data['ProductHistory']['date']=date('Y-m-d');
                            $data['ProductHistory']['cost']=$sesallproductData['Product']['selling_price'];
                            $data['ProductHistory']['created']=date('Y-m-d h:m:s');
                            $this->ProductHistory->create();
                            $this->ProductHistory->save($data);
                        }
                    }
                    // Count Points
                    $cash_amount = 0;
                    $total_deducted_points = 0;
                    $total_given_points = 0;
                    foreach($checkoutData['service_points'] as $key => $service_points){
                        if($service_points > 0){
                            $total_deducted_points = $total_deducted_points + $service_points;
                            $this->loadModel('UserCount');
                            $user_points = $this->UserCount->find('all', array(
                                'conditions' => array(
                                    'UserCount.user_id' => base64_decode($checkoutData['Appointment']['user_id']),
                                    'UserCount.salon_id' => $checkoutData['Appointment']['salon_id']
                            )));
                            $admin_points = $this->UserCount->find('all', array(
                                'conditions' => array(
                                    'UserCount.user_id' => base64_decode($checkoutData['Appointment']['user_id']),
                                    'UserCount.salon_id' => $checkoutData['Appointment']['salon_id'],
                                    'UserCount.salon_type' => 'admin'
                                )
                            ));
                            if(count($user_points) > 0 or count($admin_points)>0){
                                $user_point = 0;
                                $admin_point = 0;
                                if(isset($user_points) && $user_points != ''){
                                    $user_point = $user_points[0]['UserCount']['user_count'];    
                                }
                                if(count($admin_points) > 0 && $admin_points != ''){
                                    $admin_point = $admin_points[0]['UserCount']['user_count'];
                                }
                                $appointment_points = $this->Appointment->find('first', array(
                                        'conditions' => array('Appointment.id' => $key),
                                        'fields' => array('id','points_redeem','points_given')
                                ));
                                $total_given_points = $total_given_points + $appointment_points['Appointment']['points_given'];
                                if($user_point > $service_points){
                                    if(isset($appointment_points) && $appointment_points != ''){
                                        $user_point = $user_point + $appointment_points['Appointment']['points_given'];
                                        $add_points = array(
                                            'user_count' => $user_point
                                        );
                                        $this->UserCount->updateAll($add_points, array('UserCount.user_id' => base64_decode($checkoutData['Appointment']['user_id']),'UserCount.salon_id' => $checkoutData['Appointment']['salon_id'],'UserCount.salon_type' =>'individual'));
                                    }
                                    $remaning_pts = $user_point - $service_points;
                                    if($remaning_pts < 0){
                                        $remaning_pts = 0;
                                    }
                                    $data = array(
                                        'user_count' => $remaning_pts
                                    );
                                    $this->UserCount->updateAll($data, array('UserCount.user_id' => base64_decode($checkoutData['Appointment']['user_id']),'UserCount.salon_id' => $checkoutData['Appointment']['salon_id'],'UserCount.salon_type' =>'individual'));
                                }elseif($user_point < $service_points && $admin_point > 0){
                                    #update user counts
                                    #update admin points
                                    $pending_points = $service_points - $user_point;
                                    $data = array(
                                        'user_count' => '0'
                                    );
                                    if($this->UserCount->updateAll($data, array('UserCount.user_id' => base64_decode($checkoutData['Appointment']['user_id']),'UserCount.salon_id' => $checkoutData['Appointment']['salon_id'],'UserCount.salon_type' =>'individual'))){
                                        $remaning_pts = $admin_point - $pending_points;
                                        if($remaning_pts < 0){
                                            $remaning_pts = 0;
                                        }
                                        $admin_data = array(
                                            'user_count' => $remaning_pts
                                        );    
                                        $this->UserCount->updateAll($admin_data, array('UserCount.user_id' => base64_decode($checkoutData['Appointment']['user_id']),'UserCount.salon_id' => $checkoutData['Appointment']['salon_id'],'UserCount.salon_type' =>'admin'));   
                                    }
                                }elseif($user_point < $service_points && $admin_point<=0){
                                    $pending_points = $service_points - $user_point;
                                    $this->loadModel('PointSetting');
                                    $point_setting = $this->PointSetting->find('all');
                                    //cash amount for IOU
                                    $cash_amount = $pending_points/$point_setting[0]['PointSetting']['aed_unit'];
                                }
                            }
                        }
                    }
                    $this->loadModel('UserPoint');
                    $order_id = $this->Order->getLastInsertId();
                    if(isset($user_points) && $user_points!='') {
                        $salon_type=$user_points[0]['UserCount']['salon_type'];
                        if($salon_type=='frenchise'){
                            $this->loadModel('User');
                            $salon_user = $this->User->find('first', array(
                                            'conditions' => array('User.id' => base64_decode($checkoutData['Appointment']['user_id'])),
                                            'fields' => array('id','parent_id')
                            ));
                            $checkoutData['Appointment']['user_id']=base64_encode($salon_user['User']['parent_id']);
                        } 
                        if($user_point > $service_points){
                            $data = array(
                                'user_id' => base64_decode($checkoutData['Appointment']['user_id']),
                                'salon_id' => $checkoutData['Appointment']['salon_id'],
                                'points_deducted' =>  $total_deducted_points,
                                'order_id' => $order_id,
                                'type' => '1'
                            
                            );
                            $this->UserPoint->create();
                            if($this->UserPoint->save($data,false)){
                                $data1 = array(
                                    'user_id' => base64_decode($checkoutData['Appointment']['user_id']),
                                    'salon_id' => $checkoutData['Appointment']['salon_id'],
                                    'point_given' => $total_given_points,
                                    'order_id' => $order_id,
                                    'type' => '0'
                                );
                                $this->UserPoint->create();
                                if($this->UserPoint->save($data1,false)){
                                    
                                }
                            }
                        }elseif($user_point < $service_points && $admin_point>0){
                            $data = array(
                                'user_id' => base64_decode($checkoutData['Appointment']['user_id']),
                                'salon_id' => $checkoutData['Appointment']['salon_id'],
                                'points_deducted' =>  $total_deducted_points,
                                'order_id' => $this->Order->getLastInsertId(),
                                'points_given_by' => 'admin',
                                'type' => '1'
                            );
                            $this->UserPoint->create();
                            if($this->UserPoint->save($data,false)){
                                  $data1 = array(
                                    'user_id' => base64_decode($checkoutData['Appointment']['user_id']),
                                    'salon_id' => $checkoutData['Appointment']['salon_id'],
                                    'point_given' => $total_given_points,
                                    'order_id' => $this->Order->getLastInsertId(),
                                    'points_given_by' => 'admin',
                                    'type' => '0'
                                );
                                $this->UserPoint->create();
                                if($this->UserPoint->save($data1,false)){
                                        
                                }   
                            }
                        }elseif($user_point < $service_points && $admin_point<=0){
                            $data = array(
                                'user_id' => base64_decode($checkoutData['Appointment']['user_id']),
                                'salon_id' => $checkoutData['Appointment']['salon_id'],
                                'points_deducted' =>  $total_deducted_points,
                                'order_id' => $order_id,
                                'points_given_by' => 'admin',
                                'type' => '1'
                            );
                            $this->UserPoint->create();
                            if($this->UserPoint->save($data,false)){
                                  $data1 = array(
                                    'user_id' => base64_decode($checkoutData['Appointment']['user_id']),
                                    'salon_id' => $checkoutData['Appointment']['salon_id'],
                                    'point_given' => $total_given_points,
                                    'order_id' => $order_id,
                                    'points_given_by' => 'admin',
                                    'type' => '0'
                                );
                                $this->UserPoint->create();
                                if($this->UserPoint->save($data1,false)){
                                    
                                }   
                            }
                        }
                    }
                    #Adding and Updating IOU
                    if(isset($checkoutData['payeeUserId']) && $checkoutData['payeeUserId'] != '') {
                        $user_id = $checkoutData['payeeUserId'];
                    }else{
                        $user_id = $appointmentData['Appointment']['user_id'];
                    }
                    $this->loadModel('Iou');
                    $all_iou = $this->Iou->find('all', array(
                        'conditions' => array(
                            'Iou.user_id' => $user_id,
                            'Iou.is_deleted' => 0,
                            'Iou.status' => 0
                        ),
                        'order' =>array('Iou.total_iou_price ASC')
                    ));
                    $total_payment_amount = $checkoutData['cart']['amount_paid'] + $cash_amount;
                    $total_service_amount = 0;
                    if(isset($checkoutData['service_discount_price']) && $checkoutData['service_discount_price'] !=''){
                        foreach($checkoutData['service_discount_price'] as $key => $discount_price){
                            $total_service_amount = $total_service_amount + $discount_price;
                        }    
                    }
                    if(isset($checkoutData['gc_discount_price']) && $checkoutData['gc_discount_price'] !=''){
                        foreach($checkoutData['gc_discount_price'] as $key => $discount_price){
                            $total_service_amount = $total_service_amount + $discount_price;
                        }    
                    }
                    if(isset($checkoutData['product_discount_price']) && $checkoutData['product_discount_price'] !=''){
                        foreach($checkoutData['product_discount_price'] as $key => $discount_price){
                            $total_service_amount = $total_service_amount + $discount_price;
                        }    
                    }
                    $final_service_amount =  $total_payment_amount - $total_service_amount;
                    
                    
                    if($final_service_amount < 0){
                        if($total_payment_amount > $total_service_amount){
                            
                            $data = array(
                                'total_iou_price' =>  $final_service_amount
                            );
                            if($this->Iou->updateAll($data, array('Iou.id' => $iou['Iou']['id']))){
                                $final_service_amount = $final_service_amount - $iou_amount;
                                $this->create_pdf($checkoutData);
                                $edata['data'] = 'success';
                                $edata['print'] = $printReceipt;
                                $edata['email']=$emailReceipt;
                                $edata['checkout']=$checkoutData;
                                $edata['message'] = __('Successfully Checkout and Update related Table and IOU',true);
                                $this->Session->delete('selected_user_id');
                                echo json_encode($edata);
                                die;
                            }else{
                                $message = __('Something Went wrong while saving IOU.', true);
                                $vError = $this->Order->validationErrors;
                                $edata['data'] = $vError;
                                $edata['message'] = $message;
                                echo json_encode($edata);
                                die;
                            }
                        }else{
                            #First change the amount in positive
                            $final_service_amount = abs($final_service_amount);
                            $this->loadModel('Iou');
                            $iou_data = array(
                                'order_id' => $this->Order->getLastInsertId(),
                                'user_id' => $appointmentData['Appointment']['user_id'],
                                'iou_comment' => $checkoutData['Iou']['iou_comment'],
                                'total_iou_price' => $final_service_amount
                            );
                            if($this->Iou->save($iou_data,false)){
                                $this->create_pdf($checkoutData);
                                $edata['data'] = 'success';
                                $edata['print'] = $printReceipt;
                                $edata['email']=$emailReceipt;
                                $edata['checkout']=$checkoutData;
                                $edata['message'] = __('Successfully Checkout and Update related Table and IOU',true);
                                $this->Session->delete('selected_user_id');
                                echo json_encode($edata);
                                die;
                            }else{
                                $message = __('Something Went wrong while saving IOU.', true);
                                $vError = $this->Order->validationErrors;
                                $edata['data'] = $vError;
                                $edata['message'] = $message;
                                echo json_encode($edata);
                                die;
                            }
                        }
                    }elseif($final_service_amount == 0){
                        die("in Equal");
                        #change only the status of all services
                    }elseif($final_service_amount > 0){
                        $iou_amount = 0;
                        foreach($all_iou as $key => $iou){
                            $iou_amount = $iou['Iou']['total_iou_price'];
                            #change the staus on the basic of current iou id
                            if($final_service_amount>0){
                            if($final_service_amount == $iou_amount){
                                $data = array(
                                    'status' => 1,
                                    'is_deleted' => 1
                                );
                                $this->Iou->updateAll($data, array('Iou.id' => $iou['Iou']['id']));
                                /*if($this->Iou->updateAll($data, array('Iou.id' => $iou['Iou']['id']))){
                                    $edata['data'] = 'success' ;
                                    $edata['print'] = $printReceipt;
                                    $edata['email']=$emailReceipt;
                                    $edata['checkout']=$checkoutData;
                                    $edata['message'] = __('Successfully Checkout and Update related Table and IOU',true);
                                    $this->Session->delete('selected_user_id');
                                    echo json_encode($edata);
                                    die;
                                }else{
                                    $message = __('Something Went wrong while saving IOU.', true);
                                    $vError = $this->Order->validationErrors;
                                    $edata['data'] = $vError;
                                    $edata['message'] = $message;
                                    echo json_encode($edata);
                                    die;
                                }*/
                                break;
                            }elseif($final_service_amount > $iou_amount){
                                #Change the status to deleted
                                $data = array(
                                    'status' => 1,
                                    'is_deleted' => 1
                                );
                                $this->Iou->updateAll($data, array('Iou.id' => $iou['Iou']['id']));
                                $final_service_amount = $final_service_amount - $iou_amount;
                                /*if($this->Iou->updateAll($data, array('Iou.id' => $iou['Iou']['id']))){
                                    $final_service_amount = $final_service_amount - $iou_amount;
                                    $edata['data'] = 'success' ;
                                    $edata['print'] = $printReceipt;
                                    $edata['email']=$emailReceipt;
                                    $edata['checkout']=$checkoutData;
                                    $edata['message'] = __('Successfully Checkout and Update related Table and IOU',true);
                                     $this->Session->delete('selected_user_id');
                                    echo json_encode($edata);
                                    die;
                                }else{
                                    $message = __('Something Went wrong while saving IOU.', true);
                                    $vError = $this->Order->validationErrors;
                                    $edata['data'] = $vError;
                                    $edata['message'] = $message;
                                    echo json_encode($edata);
                                    die;
                                }*/
                            }elseif($final_service_amount < $iou_amount){
                                
                                $pending_amount = $iou_amount - $final_service_amount;
                                $data = array(
                                    'total_iou_price' =>  $pending_amount
                                );
                                #update query to change the amount
                                if($this->Iou->updateAll($data, array('Iou.id' => $iou['Iou']['id']))){
                                    if($iou_amount > $final_service_amount){
                                        $final_service_amount=0;
                                    }
                                    $edata['data'] = 'success' ;
                                    $edata['print'] = $printReceipt;
                                    $edata['email']=$emailReceipt;
                                    $edata['checkout']=$checkoutData;
                                    $edata['message'] = __('Successfully Checkout and Update related Table and IOU',true);
                                     $this->Session->delete('selected_user_id');
                                    echo json_encode($edata);
                                    die;
                                }else{
                                    $message = __('Something Went wrong while saving IOU.', true);
                                    $vError = $this->Order->validationErrors;
                                    $edata['data'] = $vError;
                                    $edata['message'] = $message;
                                    echo json_encode($edata);
                                    die;
                                }
                                break;
                            }
                            
                           $this->create_pdf($checkoutData);
                           
                          
                           
                           //public function sendEmail($to = null, $from = null, $templateID = null, $dynamicFields = null, $reply = null, $path = null, $file_name = null) 
                            if($checkoutData['cart']['email']==1){
                                $this->Common->sendEmail($checkoutData);
                            }
                            
                            $edata['data'] = 'success' ;
                                    $edata['print'] = $printReceipt;
                                    $edata['email']=$emailReceipt;
                                    $edata['checkout']=$checkoutData;
                                    $edata['message'] = __('Successfully Checkout and Update related Table and IOU',true);
                            }  
                            
                        }
                    }
                    //IOU Code Ends Here     
                }else{
                    $message = __('Something Went wrong while saving Order, Please try again.', true);
                    $vError = $this->Order->validationErrors;
                    $edata['data'] = $vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
            }else{
                $message = __('Something Went wrong , Please try again.', true);
                $vError = $this->Appointment->validationErrors;
                $edata['data'] =$vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
    }
    function customerList($customerType = null){
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $userList = $this->Users->findallCustomerList();
        
    }
    
    function admin_add_iou(){
        if($this->request->is('ajax') || $this->request->is('post')){
            $postDataArray = $this->request->data;
            $this->set('postData',$postDataArray);
        }
    }
    
    function admin_manage_group_customers($appointmentId = null){
        $appointmentData = $this->common_appointment_details($appointmentId);
        $employeeId = $appointmentData['Appointment']['salon_staff_id'];
        $appointmentTime = $appointmentData['Appointment']['appointment_start_date'];
        $userId = $appointmentData['Appointment']['user_id'];
        $salonUserId = $this->Auth->user('id');
        $apptmentDateStart = date('Y-m-d 00:00',$appointmentTime);
        $apptmentDateEnd = date('Y-m-d 23:59',$appointmentTime);
        $apptnmentStrStart = strtotime($apptmentDateStart); //die();
        $apptnmentStrEnd = strtotime($apptmentDateEnd);
        $this->loadModel('User');
        App::import('Controller', 'Users');
        $this->Users = new UsersController;
        $userList = $this->Users->findallCustomerList();
        $todaycustList = $this->Appointment->find('list', array(
            'fields' => array('User.id','User.first_name'),
            'conditions' => array("Appointment.salon_id"=>$salonUserId,'payment_status'=> 0,"appointment_start_date >="=>$apptnmentStrStart,"appointment_start_date <="=> $apptnmentStrEnd),
            'recursive' => 1
        ));
        foreach($todaycustList as $key => $todayList){
            $encodedKey = base64_encode($key);
            $encodedCustList[$encodedKey] = $todayList;
         }
        $finalUserList = array_intersect_key($encodedCustList,$userList);
        //pr($finalUserList); exit;
        $this->set('userList',$finalUserList);
    }
    
    // Calculation for final checkout
    function admin_getCalculations($userId,$appointmentTime){
        pr($this->request->data); exit;
    }
    function admin_updateall(){
       pr($this->request->data); exit;
    }
    
    function admin_add_product($user_id,$searchText='NULL'){
        //$user_id=base64_decode($user_id);
       $user_id = $this->Auth->user('id');
        $this->loadModel('Product');
        $fields = array(
                        "Product.barcode",
                        "Brand.eng_name",
                        "ProductType.eng_name",
                        "Product.eng_product_name",
                        "Product.cost_business",
                        "Product.selling_price",
                        "Product.quantity",
                    );
        $this->Product->bindModel(array('belongsTo' => array(
                'Brand'=>array(
                    'className' => 'brand',
                    'foreignKey' => 'brand_id'
                ),
                'ProductType'=>array(
                    'className' => 'productType',
                    'foreignKey' => 'product_type_id'
                    )
                )
        ),false);
        if(!empty($this->request->data)){
            $count=count($this->request->data['Product']); 
            for($i=1;$i<=$count;$i++){
                $products[]=$this->request->data['Product']['id'.$i];
            }
            $productData = $this->Product->find('all',array('conditions'=>array("Product.id"=>$products),'fields'=>$fields));
            $this->Session->write('productData',$productData);
            $this->set('productData',$productData);
            $edata['data'] = 'success' ;
            $edata['message'] = __('Inventory added successfully',true);
            echo json_encode($edata);
            die;    
        }
        if($searchText!='NULL'){
            $productData = $this->Product->find('all',array('conditions'=>array("Product.user_id"=>$user_id,"Product.is_deleted"=>0,"Product.eng_product_name"=>$searchText,"business_use"=>0),'fields'=>$fields));
            $this->set(compact('productData','user_id','searchText'));
        }else{
            $productData = $this->Product->find('all',array('conditions'=>array("Product.user_id"=>$user_id,"Product.is_deleted"=>0,"business_use"=>0),'fields'=>$fields));
            //pr($productData); die;
            $this->set(compact('productData','user_id'));
        }
    }
    
    public function admin_get_services($salon_service_id=null,$provider_id=null, $appointment_id = null,$user_id=null){
        if($this->request->is('ajax')){
           $this->layout = 'ajax';
           
           $staffServices = $this->Common->getStaffServiceList($provider_id, $this->Auth->user('id'));
           $this->set(compact('staffServices','salon_service_id','provider_id','appointment_id','user_id'));
        }
    }
    
    public function admin_edit_service($salon_service_id= null,$provider_id=null,$appointment_id = null,$user_id=null,$type = null){
        if($this->request->is('ajax')){
            $postData = $this->request->data;
            $this->Components->load('Auth');
            $this->layout = 'ajax';
            $price_duration = $this->admin_checkout_fetch_price_and_duration($salon_service_id,$provider_id,$type);
            $this->loadModel('SalonService');
            $salon_service_name_by_service_id = $this->SalonService->find('first',array('fields'=>array('eng_display_name','eng_name'),'conditions'=>array('SalonService.id'=>$postData['Appointment']['service_id'])));
            $salon_service_name = $salon_service_name_by_service_id['SalonService']['eng_name'];
            $customeName=$this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
            $theCustomerName = $customeName['User']['first_name'].' '.$customeName['User']['last_name'];
            $appointment_title = $theCustomerName.'-'.$salon_service_name;
            $this->loadModel('Appointment');
            $data = array(
                'Appointment.appointment_title' => "'".$appointment_title."'",
                'Appointment.user_id' => $user_id,
                'Appointment.salon_service_id' => $postData['Appointment']['service_id'],
                'Appointment.appointment_price' => $price_duration[0]['ServicePricingOption']['full_price'],
                'Appointment.appointment_duration' => $price_duration[0]['ServicePricingOption']['duration'],
            );
            if($this->Appointment->updateAll($data,array('Appointment.id'=> $appointment_id))){
                $edata['data'] = 'success' ;
                $edata['message'] = __('Successfully Updated Appointment Data',true);
                echo json_encode($edata);
                die;
            }
            else{
                $edata['data'] = 'error' ;
                $edata['message'] = __('Something Went Wrong',true);
                echo json_encode($edata);
                die;
            }
        }
    }
    
    public function admin_checkout_fetch_price_and_duration($service_id='NULL',$staff_id='NULL',$type='NULL'){
        $this->Components->load('Auth');
        $this->loadmodel('User'); 	
        $this->loadModel('PricingLevelAssigntoStaff');
        $this->loadModel('ServicePricingOption');
        $user_id=$this->Auth->user('id');
        $PricingLevels=$this->PricingLevelAssigntoStaff->find('all',array(
                                                            'fields'=>array('pricing_level_id'),
                                                            'conditions'=>array('user_id'=>$staff_id)));
        $PricingLevelsIds=array();
        foreach($PricingLevels as $PricingLevels)
            {
               $PricingLevelsIds[]= $PricingLevels['PricingLevelAssigntoStaff']['pricing_level_id'];
            }
        $PricingLevelsIds[]='0';
        $ServicePricingOptions=$this->ServicePricingOption->find('all', array(
                        'fields'=>array('full_price','sell_price','duration','salon_service_id'),
                        'conditions' => array('ServicePricingOption.pricing_level_id' => $PricingLevelsIds,                            'ServicePricingOption.salon_service_id' => $service_id,                                              'ServicePricingOption.is_deleted' => 0)
                                    ));
        if($type == 'edit_service'){
            return $ServicePricingOptions;
        }
        $this->layout='ajax';
        $this->set(compact('ServicePricingOptions'));
        $this->viewPath = "Elements/checkout";
        $this->render('checkout_pricingoptions');
    }
    
    public function admin_addCertificate($customer_id = null){
        $customer_id = base64_decode($customer_id);
        $logged_in_user = $this->Session->read('Auth.User.id');
        $logged_in_user_type = $this->Session->read('Auth.User.type');
        if(!empty($logged_in_user) && !empty($logged_in_user_type)){
            $this->loadModel('User');
            $cond['User.type'] = Configure::read('USER_ROLE');
            $userType = $this->Auth->user('type');
            $parentID = $this->Auth->user('id');
            if($userType != Configure::read('SUPERADMIN_ROLE')){
                $cond = $this->mergingCond4UserType($cond);
            }
            $sender = $this->User->find('all',array(
                'conditions'=>$cond,
                'fields' => array('User.id','User.first_name','User.last_name','User.email'),
                'order' => array('User.first_name ASC','User.last_name ASC','User.email ASC')
            ));
        }
        $senderArr = array();
        if(!empty($sender)){
            foreach($sender as $sender_det){
                $senderArr[$sender_det['User']['id']] = $sender_det['User']['first_name'].' '.$sender_det['User']['last_name'].' - '.$sender_det['User']['email'];
            }
        }
        if ($this->request->is('post') || $this->request->is('put')) {
           // pr($this->request->data); die;
            $this->request->data['GiftCertificate']['sender_id']=$customer_id;
            if (!empty($this->request->data['GiftCertificate']['id'])) {
                $this->GiftCertificate->id = $this->request->data['GiftCertificate']['id'];
            }
            $created_by = $this->Auth->user('id');
            $this->request->data['GiftCertificate']['user_id'] = $created_by;
            
            $this->loadModel('GiftCertificate');
            
            $this->GiftCertificate->set($this->request->data);
            if ($this->GiftCertificate->validates()){
                /*** New Code *****/
                $this->Session->delete('GiftCertificateData');
                $this->Session->write('GiftCertificateData', $this->request->data);
                $this->Session->write('giftCertificateData',$this->request->data);
                $getData = $this->Session->read('GiftCertificateData');
                if(!empty($getData)){
                    echo 'Preview';
                    exit;
                }else{
                    /*** New Code *****/
                    //pr($this->request->data); die;
                    if ($this->GiftCertificate->save($this->request->data)) {
                        if (!empty($this->request->data['GiftCertificate']['id'])) {
                            $id = $this->request->data['GiftCertificate']['id'];
                            $type = "Old";
                        } else {
                            $id = $this->GiftCertificate->getLastInsertId();
                            $type = "New";
                        }
                        $edata['data'] = 'success';
                        $edata['message'] = __('page_save_success', true);
                        $edata['id'] = $id;
                        $edata['New'] = $type;
                        echo json_encode($edata);
                        die;
                    } else {
                        $message = __('unable_to_save', true);
                        $vError = $this->GiftCertificate->validationErrors;
                        $edata['data'] = $vError;
                        $edata['message'] = $message;
                        echo json_encode($edata);
                        die;
                    }
                    }
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->GiftCertificate->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
            
            
            
            /*$giftCertificateData = $this->request->data;
            $this->Session->write('giftCertificateData',$giftCertificateData);
            $edata['data'] = 'success';
            $edata['message'] = __('page_save_success', true);
            echo json_encode($edata);
            die;*/
        }
        $this->set(compact('customer_id'));
        $this->set(compact('senderArr'));
        $this->set('user_id',$this->Auth->user('id'));
    }
    
     /**
     * Show Images By Category design Admin
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_image_by_category
     * @param         $id
     * @since         version 0.0.1
     */
    public function admin_image_by_category($id = null) {
        $this->loadModel('GiftImage');
        $logged_in_user = $this->Session->read('Auth.User.id');
        $logged_in_user_parent = $this->Session->read('Auth.User.parent_id');
        $giftImageData = $this->GiftImage->find('all',
                    array(
                          'fields' => array('GiftImage.id',
                                            'GiftImage.eng_title',
                                            'GiftImage.image'),
                        'conditions' => array(
                                    'OR' => array(
                                            array('AND' =>array(
                                                'GiftImage.status' => 1,
                                                'GiftImage.gift_image_category_id' => $id,
                                                'GiftImage.user_id' => 1,
                                            )),
                                            array('AND' =>array(
                                                'GiftImage.status' => 1,
                                                'GiftImage.gift_image_category_id' => $id,
                                                'GiftImage.user_id' => $logged_in_user,
                                            )),
                                            array('AND' =>array(
                                                'GiftImage.status' => 1,
                                                'GiftImage.gift_image_category_id' => $id,
                                                'GiftImage.user_id' => $logged_in_user_parent,
                                            )),
                                    ),
                        )
                    ));
        $this->set('giftImageData', $giftImageData);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/GiftCertificates";
            $this->render('admin_image_by_category');
        }
    }
    
    public function mergingCond4UserType($cond){
        if(!$cond){
            $cond = array();
        }
        $this->loadModel('UserToSalon');
        $userslist  =   array();
        $typeId = $this->Auth->user('type');
        if(($typeId == Configure::read('FRANCHISE_ROLE')) || ($typeId == Configure::read('MULTILOCTION_ROLE'))){ //For Frenchise and MultiStore get Users created by both parent and child
            $userslist= $this->salonsunderFrenchise();
        }elseif($typeId==Configure::read('SALON_ROLE')){ // For individual and Salon Under Frenchise get users created by that Salon
            $userslist = $this->Auth->user('id');
        }
        $InUserList = $this->UserToSalon->find('list',array('fields'=>array('UserToSalon.user_id'),'conditions'=>array('UserToSalon.salon_id'=>$userslist)));
         /** Franchise Case **/
        if($typeId == 4){
            $cond = array('OR'=>array(
                                'User.id'=>$InUserList,
                                'OR'=>array(
                                        array(
                                            'OR'=>
                                            array(
                                                'User.parent_id'=>$this->Auth->user('id'),
                                                'User.created_by'=>$this->Auth->user('id')
                                            ),
                                            $cond
                                        )
                                        
                                    )
                                    
                            ),
                            'User.is_deleted'=>0,
                        );
        }else{
        /** Franchise Case **/ 
         
         $cond = array('OR'=>
                        array(
                            'User.id'=>$InUserList ,
                            array_merge( $cond , array( 'User.created_by'=>$userslist))
                            )
                        );
        }
        return $cond;
    }
    
    function admin_pointsRedeem(){
        $this->loadModel('UserCount');
        $points = $this->UserCount->find('first', array('conditions' => array('UserCount.salon_id' => $this->request->data['salon_id'],'UserCount.user_id' => $this->request->data['user_id'],'UserCount.salon_type' => 'individual')));
        if(count($points)<0){
            $userPoints=0;
        }else{
            $userPoints=$points['UserCount']['user_count'];
        }
        $admin_points = $this->UserCount->find('first', array('conditions' => array('UserCount.salon_id' => $this->request->data['salon_id'],'UserCount.user_id' => $this->request->data['user_id'],'UserCount.salon_type' => 'admin')));
        if(count($admin_points)<0){
            $adminPoints=0;
        }else{
            $adminPoints=$admin_points['UserCount']['user_count'];
        }
        $total_points=$userPoints+$adminPoints;
        if($total_points<$this->request->data['points_redeem']){
            die("0");    
        }else{
            die("1");
        }
        
    }
    
    function admin_delete(){
        if($this->request->is('ajax')){
            $id=$this->request->data['id'];
            $type=$this->request->data['type'];
            $data= array(
                'is_deleted' => 1
            );
            if($type=="IOU"){
                $this->Session->write("delete","delete");
                $this->loadModel('Iou');
                if($this->Iou->updateAll($data, array('Iou.id' => $id))){
                    die("1");
                }else{
                    die("0");
                }
            }elseif($type=="Appointment"){
                $this->Session->write("delete","delete");
                $this->loadModel('Appointment');
                if($this->Appointment->updateAll($data, array('Appointment.id' => $id))){
                    die("1");
                }else{
                    die("0");
                } 
            }elseif($type=="Product"){
                $this->Session->write("delete","delete");
                $allproductData = $this->Session->read("allproductData");
                $newproductdata = array();
                if (!empty($allproductData)) {
                    $count=count($allproductData);
                    for ($i=0; $i<$count; $i++) {
                        if ($allproductData[$i]["Product"]["id"] == $id) {
                            unset($allproductData[$i]);
                        }else{
                            $newproductdata[] = $allproductData[$i];
                        }
                    }
                    $this->Session->write("allproductData",$newproductdata);
                }
                die("1");
            }elseif($type=="GiftCertificate"){
                $this->Session->write("delete","delete");
                $allgiftCertificateData = $this->Session->read("allGiftCertificate");
                $newgiftCertificateData=array();
                if (!empty($allgiftCertificateData)) {
                    $count=count($allgiftCertificateData);
                    for ($i=0; $i<$count-1; $i++) {
                        if ($allgiftCertificateData[$i]["GiftCertificate"]["gift_certificate_no"] == $id) {
                            unset($allgiftCertificateData[$i]);
                        }else{
                            $newgiftCertificateData[]=$allgiftCertificateData[$i];
                        }
                    }
                    $this->Session->write("allGiftCertificate",$newgiftCertificateData);
                }
                die("1");
            }
        }
    }
    
    function delete_product_session($product_id = null){
        $this->layout = false;
        $this->render(false);
        $allproductData = $this->Session->read("allproductData");
        if (!empty($allproductData)) {
            for ($i=0; $i<count($allproductData); $i++) {
                if ($allproductData[$i]["id"] == $product_id) {
                    unset($allproductData[$i]);
                }
            }
            $this->Session->write("cart", serialize($tempCart));
        }
        echo "removed";
    }
    
    public function save_send_email(){
        $gc_details = $this->Session->read('GiftCertificateData');
        $this->generate_image($gc_details);
        $image_name = $this->Session->read('GiftCertificateData.GiftCertificate.image_path');
        $this->save_image(0,0,1,1);
        $this->Session->setFlash('Giftcertificate has been created successfully.', 'flash_success');
        //echo 'success'; die;
        die('success');
    }
    
    public function admin_show_by_preview($id = null){
        $this->layout = 'ajax';
        $this->loadModel('GiftImage');
        $this->loadModel('User');
        $this->loadModel('SalonService');
        $this->loadModel('Service');
        $this->loadModel('GiftCertificate');
        /********* Changes by Raman *************/
        $gc_details = $this->Session->read('GiftCertificateData');
         /********* Changes by Raman *************/
        if ($this->request->is('ajax') && $id) {
            $giftCertificate = $this->GiftCertificate->find('first', array('conditions' => array('GiftCertificate.id' => $id)));
            $senderName = $this->User->find('first', array('conditions' => array('User.id' => $giftCertificate['GiftCertificate']['sender_id'])));
            $recipientName = $this->User->find('first', array('conditions' => array('User.id' => $giftCertificate['GiftCertificate']['recipient_id'])));
            if ($giftCertificate['GiftCertificate']['send_email_status'] == 1){
                //Send Email to recicpient User Email                
                $to = $recipientName['User']['email'];
                $from = $senderName['User']['email'];
                $message = $giftCertificate['GiftCertificate']['messagetxt'];
                $path = WWW_ROOT . '/images/GiftImage/500/';
                $file_name = 'new'.$giftCertificate['GiftCertificate']['gift_image_id'].'.jpg';          
                $this->PHPMailer->sendmail($to, $from, $recipientName['User']['first_name'], 'test', $message, $path . $file_name);
            }
            $this->set('senderName', $senderName);
            $this->set('recipientName', $recipientName);
            $this->set('giftCertificate', $giftCertificate);
        } else{
            $service_name='';
            $getData = $this->Session->read('GiftCertificateData');
            $gc_details = $this->Session->read('GiftCertificateData');
            $senderDetails = array();
            $this->User->unbindModel(array('hasMany'=>array('PricingLevelAssigntoStaff')));
            $senderDetails = $this->User->find('first',
                    array('conditions' => array(
                        'User.id' => $gc_details['GiftCertificate']['user_id']),
                    'fields' => array('User.first_name','User.last_name','User.email')
                )
            );
            $gc_details['GiftCertificate']['Sender'] = $senderDetails['User'];
            //$this->Session->write('GiftCertificateData',$gc_details);
            $giftCertificate = $this->GiftImage->find('first', array('conditions' => array('GiftImage.id' => @$getData['GiftCertificate']['gift_image_id'])));
            $image_path = $this->Common->create_image($gc_details,$giftCertificate);
            $image_name_arr = explode('/',$image_path);
            $image_arr_size = count($image_name_arr);
            $image_file_name = $image_name_arr[$image_arr_size-1];
            $this->Session->write('GiftCertificateData.GiftCertificate.image_path',$image_file_name);
            $this->set(compact('gc_details','giftCertificate','image_path'));
        }
    }
    
    function generate_image($gc_details = array()){
        //pr($gc_details); die;
        $this->loadModel('GiftImage');
        $this->loadModel('User');
        $senderDetails = array();
        $this->User->unbindModel(array('hasMany'=>array('PricingLevelAssigntoStaff')));
        $senderDetails = $this->User->find('first',
                array('conditions' => array(
                    'User.id' => $gc_details['GiftCertificate']['user_id']),
                'fields' => array('User.first_name','User.last_name','User.email')
            )
        );
       //echo "test"; pr($senderDetails); die;
        $gc_details['GiftCertificate']['Sender'] = $senderDetails['User'];
        $giftCertificate = $this->GiftImage->find('first', array('conditions' => array('GiftImage.id' => @$gc_details['GiftCertificate']['gift_image_id'])));
        $image_path = $this->Common->create_image($gc_details,$giftCertificate);
        $image_name_arr = explode('/',$image_path);
        $image_arr_size = count($image_name_arr);
        $image_file_name = $image_name_arr[$image_arr_size-1];
        $this->Session->write('GiftCertificateData.GiftCertificate.image_path',$image_file_name);
        $this->Session->write('GiftCertificateData.GiftCertificate.full_image_path',$image_path);
    }

    public function save_image($imageid=NULL,$extension=NULL,$from_back_end = 0,$from_controller = null){
        $this->autoRender = false;
        $this->loadModel('GiftCertificate');
        
        $getData = array();
        $getData = $this->Session->read('GiftCertificateData');
        //pr($getData); die;
        
        $created_by = $this->Session->read('Auth.User.id');
        $created_user_type = $this->Session->read('Auth.User.type');
        
        $getData['GiftCertificate']['created_by'] = $created_by;
        
        if(($created_user_type == 1 || $created_user_type == 4 || $created_user_type == 5) && $from_back_end == 1) {
            $getData['GiftCertificate']['payment_by'] = 3;
            $getData['GiftCertificate']['payment_status'] = 4;
            
            $getData['GiftCertificate']['image'] = $getData['GiftCertificate']['image_path'];
            
           
        }else {
            $id = $this->admin_generateString();
            if($getData['GiftCertificate']['id'] == ''){
                $getData['GiftCertificate']['image'] =$getData['GiftCertificate']['gift_certificate_no'].'_'.$getData['GiftCertificate']['gift_image_id'].'.'.$extension;
            }else{
                $getData['GiftCertificate']['image'] =$getData['GiftCertificate']['id'].'_'.$getData['GiftCertificate']['gift_image_id'].'.'.$extension;
            }
        }
       
       
        $recipientEmail = '';  
        /*********** New Implementation ***************/

        if(isset($getData['GiftCertificate']['service_id']) && (!empty($getData['GiftCertificate']['service_id']))){
            $salon_id = $getData['GiftCertificate']['user_id'];
            $getData['GiftCertificate']['type'] = 2;
            if($getData['GiftCertificate']['no_of_visit'] !='' && $getData['GiftCertificate']['service_amount'] !='' ){
                $getData['GiftCertificate']['amount'] = ($getData['GiftCertificate']['service_amount'] * $getData['GiftCertificate']['no_of_visit']);
            }
            $recipientData = $this->User->find('first', array('conditions' => array('User.id' => $getData['GiftCertificate']['recipient_id'])));
            if(!empty($recipientData)){
               $recipientEmail =  $recipientData['User']['email'];
            }
        } else{
            $getData['GiftCertificate']['type'] = 1;
            $user_id = $getData['GiftCertificate']['user_id'];
            $salon_id = $this->get_my_id($user_id);
            $getData['GiftCertificate']['salon_id'] = $salon_id;
        }
        
        //pr($getData); die;
        /*********** New Implementation ***************/

        //pr($getData); die;
        
        $this->GiftCertificate->id = $getData['GiftCertificate']['id'];
        //$getData['GiftCertificate']['salon_id'] = $salon_id;
        
        /***** Recipient Details ****/
        $getData['GiftCertificate']['email'] = $getData['GiftCertificate']['recipient_email'];
        $getData['GiftCertificate']['first_name'] = $getData['GiftCertificate']['recipient_first_name'];
        $getData['GiftCertificate']['last_name'] = $getData['GiftCertificate']['recipient_last_name'];
        /***** Recipient Details ****/
        
        //pr($getData); die;
        
        $this->GiftCertificate->set($getData);
        
        $this->Session->write('giftCertificateData',$getData);
        echo    'success'; die;
        //pr($getData); die;
        /*if ($this->GiftCertificate->save($getData)){
            $this->Session->delete('GiftCertificateData');
            if(empty($from_controller)){
                echo    'success';
            }
            $this->send_emails($getData);
        }*/
        if(empty($from_controller)){
            die;
        }
    }
    
    function get_my_id($user_id = null){
        $salon_id = '';
        $this->loadModel('User');
         $this->User->unbindModel(array(
                                    'hasMany'=>array('PricingLevelAssigntoStaff'),
                                    'belongsTo' =>array('Group'),
                                    'hasOne'=>array('Salon','Address','UserDetail','Contact')
                                    ));
        $get_parent_id = $this->User->find('first', array('fields' => array('id','parent_id'), 'conditions' => array('User.id' => $user_id)));
        if(!empty($get_parent_id)){
            if($get_parent_id['User']['parent_id'] == 0){
              $salon_id = $get_parent_id['User']['id'];
            }else{
                $salon_id = $get_parent_id['User']['parent_id'];
            }
        }
        return $salon_id;
    }
    
    public function send_emails($getData = array(),$gc_id = null){
        if(!empty($getData)){
            //pr($getData); die;
            $this->loadModel('User');
            /********* Send Email *************/
            $senderName = $this->User->find('first',
                        array('conditions' => array(
                            'User.id' => $getData['GiftCertificate']['sender_id']
                        ),
                              'fields'=>array('User.id','User.email','User.first_name','User.last_name')
                ));
            $to = $getData['GiftCertificate']['email'];
            $from = $senderName['User']['email'];
            $message = $getData['GiftCertificate']['messagetxt'];
            if ($getData['GiftCertificate']['send_email_status'] == 1) {
                //die("test");
                //Send Email to recicpient User Email
                $path = WWW_ROOT . '/images/GiftImage/original/';
                $file_name = $getData['GiftCertificate']['image'];
                $dynamicVariables = array('{FromName}'=>ucfirst(@$getData['GiftCertificate']['first_name']).' '.ucfirst(@$getData['GiftCertificate']['last_name']),
                                        '{ToName}'=>$senderName['User']['first_name'],'{Message}'=>$message);
                //pr($dynamicVariables); die;
                $this->Common->sendEmail($to, $from,'gift_certificate_checkout', $dynamicVariables, $from, $path ,$file_name);
            }
            /************** Send email to Sender for success fully order placed ***********/
            $sender_dynamicVariables = array('{FromName}'=>ucfirst(@$getData['GiftCertificate']['first_name']).' '.ucfirst(@$getData['GiftCertificate']['last_name']),
                                        '{GiftcertificateAmount}'=>$getData['GiftCertificate']['amount'],
                                        '{ToName}'=>ucfirst(@$getData['GiftCertificate']['first_name']).' '.ucfirst(@$getData['GiftCertificate']['last_name']),
                                        '{ToEmail}'=>$to);
            $this->Common->sendEmail($senderName['User']['email'],$from,'gift_certificate_-_offline_order', $sender_dynamicVariables);
            /********* Send Email *************/
        } else {
            echo 'here';
        }
    }
    
    public function admin_searchInventory($user_id = null){
        if($this->request->is('ajax')){
            $product_name = $this->request->data['searchValue'];
            $this->layout="ajax";
            $this->loadModel('Product');
            $fields = array(
                        "Product.barcode",
                        "Brand.eng_name",
                        "ProductType.eng_name",
                        "Product.eng_product_name",
                        "Product.cost_business",
                        "Product.selling_price",
                        "Product.quantity",
                    );
            $this->Product->bindModel(array('belongsTo' => array(
                        'Brand'=>array(
                        'className' => 'brand',
                        'foreignKey' => 'brand_id'
                    ),
                    'ProductType'=>array(
                    'className' => 'productType',
                    'foreignKey' => 'product_type_id'
                    )
                )
            ),false);
            $productData = $this->Product->find('all',array(
                'conditions'=>array(
                    'OR' => array(
                        array("Product.eng_product_name"=>$product_name),
                        array("Product.barcode"=>$product_name),
                        array("Brand.eng_name"=>$product_name),
                        array("ProductType.eng_name"=>$product_name),
                    ),
                    'AND' => array("Product.user_id"=>$user_id)
                ),
                'fields'=>$fields
            ));
            $this->set(compact('productData'));
            $this->viewPath = "Elements/checkout";
            $this->render('search_product');
        }
    }
    
    function admin_printReceipt($data){
        $this->layout = false;
        $data=json_decode(base64_decode($data));
        $user_id=base64_decode($data->Appointment->user_id);
        $this->loadModel('User');
        $user_detail = $this->User->find('first', array(
                                         'fields' => array('User.id','User.first_name','User.last_name','Address.address','Contact.cell_phone'),
                                         'conditions' => array("User.id"=>$user_id),
                                        ));
        $this->set('cart',$data);
        $this->set(compact('user_detail'));
    }
    
    function admin_search_giftcertificate($user_id='NULL',$salon_id='NULL',$searchText='NULL'){
        $user_id=base64_decode($user_id);
        $this->loadModel('GiftCertificate');
        $fields = array(
                        "GiftCertificate.id",
                        "GiftCertificate.user_id",
                        "GiftCertificate.gift_certificate_no",
                        "GiftCertificate.amount",
                        "GiftCertificate.is_online"
                    );
        if(!empty($this->request->data)){
            $amount=$this->request->data['Checkout']['amount_'.$this->request->data['Checkout']['check']];
            $gift_id=$this->request->data['Checkout']['id_'.$this->request->data['Checkout']['check']];
            
            $data = array(
                'GiftCertificate.is_used' => 1,
                'GiftCertificate.recipient_id' => $user_id,
                
            );
            if($this->GiftCertificate->updateAll($data,array('GiftCertificate.id'=> $gift_id))){
                $edata['data'] = 'success' ;
                $edata['amt'] = $amount ;
                $edata['message'] = __('Gift Certificate added successfully',true);
                echo json_encode($edata);
                die;    
            }
        }
        if($searchText!='null'){
            $this->layout="ajax";
            $this->loadModel('PolicyDetail');
            $policyDetail = $this->PolicyDetail->find('first', array('fields' => array('id','enable_sieasta_voucher'), 'conditions' => array('PolicyDetail.user_id' => $salon_id)));
            if(count($policyDetail)>0){
                if($policyDetail['PolicyDetail']['enable_sieasta_voucher']==1){
                    $salon_id_array=array('0','1',$salon_id);
                }else{
                    $salon_id_array=array($salon_id);
                }
            }else{
                $policyDetail = $this->PolicyDetail->find('first', array('fields' => array('id','enable_sieasta_voucher'), 'conditions' => array('PolicyDetail.user_id' => 1)));
                    if($policyDetail['PolicyDetail']['enable_sieasta_voucher']==1){
                    $salon_id_array=array('0','1',$salon_id);
                }else{
                    $salon_id_array=array($salon_id);
                }
            }
            $giftData = $this->GiftCertificate->find('all',
                                                     array('conditions'=>array('AND'=>array( 'OR'=>array(
                                                                                                  array(                 "GiftCertificate.recipient_id"=>$user_id),
                                                                                                  array(                 "GiftCertificate.recipient_id"=>0))),
                                                                                     "GiftCertificate.is_deleted"=>'0', "GiftCertificate.gift_certificate_no"=>$searchText,"GiftCertificate.salon_id"=>$salon_id_array,"GiftCertificate.is_online"=>1,
                                                                                     "GiftCertificate.expire_on >"=>Date('Y-m-d')
                                            
    ),'fields'=>$fields));
            $this->set(compact('giftData','user_id','searchText'));
            $this->set(compact('giftData'));
            $this->viewPath = "Elements/checkout";
            $this->render('giftcertificate_list');
        }else{
        }
        $this->set(compact('user_id','salon_id'));
    }
    
    function admin_emailReceipt($data){
        die("testing1");
        $this->layout = false;
        $data=json_decode(base64_decode($data));
        $user_id=base64_decode($data->Appointment->user_id);
        $this->loadModel('User');
        $user_detail = $this->User->find('first', array(
                                         'fields' => array('User.id','User.first_name','User.last_name','Address.address','Contact.cell_phone'),
                                         'conditions' => array("User.id"=>$user_id),
                                        ));
        //$this->set('cart',$data);
        //$this->set(compact('user_detail'));
        $this->admin_notify_customer($data,$user_detail,'checkout_receipt');
    }
    
    public function admin_notify_customer($checkout_data=NULL,$user_data=NULL,$tempate=NULL){
        die("tetetetetet");
        pr($checkout_data); die;
       $this->loadModel('User');
       $userData = $this->User->findById($user_id);
       $toEmail =   $userData['User']['email'];
       $fromEmail  =   Configure::read('fromEmail');
        $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']), '{service_name}' => ucfirst($service_name),'{start_date}' => date('Y-m-d',$start_date),'{time}' => date('h:i A',$start_date),'{duration}' => $duration);
        $userName = $userData['User']['first_name'];
        $userEmail = $userData['User']['email'];
        $mbNumber =  $userData['Contact']['cell_phone']; 
        $country_code  = $userData['Contact']['country_code'];
        if(!empty($mbNumber)){
            $welcomeMessage = 'Hi '.$userName.', Your Appointment '.$service_name.' has been successfully added in ';
            if($country_code){
                $mbNumber = str_replace("+","",$country_code).$mbNumber;    
            }
            $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
        }
        $this->Common->sendEmail($toEmail,$fromEmail,$tempate,$dynamicVariables);
    }
    
    public function admin_calculate_product_price(){
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $product_quantity = $this->request->data['product_quantity'];
            $product_id = $this->request->data['product_id'];
            $total_qty = $this->request->data['total_quantity'];
            $allProduct = $this->Session->read('allproductData');
            for($i = 0; $i< count($allProduct); $i++){
                if($allProduct[$i]['Product']['id'] == $product_id){
                    if($total_qty-$product_quantity<1){
                      echo "0"; die;  
                    }else{
                        $allProduct[$i]['count'] = $product_quantity;
                        $newProductPrice = $product_quantity * $allProduct[$i]['Product']['selling_price'];
                    }
                }
            }
            $this->Session->write('allproductData',$allProduct);
            echo $newProductPrice;
            exit;
        }
    }
    
    public function admin_check_quantity(){
        if($this->request->is('ajax')){
            $this->layout = false;
            $this->render(false);
            $total_qty=$this->request->data['total_qty'];
            $product_id=$this->request->data['product_id'];
            $addedProducts=$this->Session->read('allproductData');
            if(count($addedProducts)>0){
                foreach($addedProducts as $addedProducts){
                    if($addedProducts['Product']['id']==$product_id){
                        if($total_qty-$addedProducts['count']<1){
                             echo '0'; die;
                        }else{
                           echo '1'; die;  
                        }
                    }
                }
            }else{
                echo '1'; die;
            }
        }
    }
    public function create_pdf($checkoutData){
        //pr($checkoutData); die;
        //$users = $this->User->find('all');
       // $this->set(compact('users'));
       $this->loadModel('User');
       $user_id=base64_decode($checkoutData['Appointment']['user_id']);
       $cond = array('User.id'=>$user_id);
        $user_detail = $this->User->find('first',array('conditions'=>$cond));
       //pr($user_detail); die;
       $this->set('checkoutData',$checkoutData);
       $this->set('user_detail',$user_detail);
      //  $this->layout = 'ajax';
        //$this->viewPath = "Elements/checkout/";
        //$this->render('checkout_receipt');
        //$this->render('/checkout/checkout_receipt');
        
        
        header("Content-type: application/pdf"); 
        $base_path=$_SERVER['DOCUMENT_ROOT'];
        App::import('Vendor','xtcpdf');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetMargins('10', '0', '10');
        $pdf->AddPage();
        $html= "<div id='main'><div class='container-fluid'><div class='contact'><div class='col-sm-12'>".$user_detail['Address']['address']."</div><div class='col-sm-12'>".$user_detail['Contact']['cell_phone']."</div><div class='col-sm-12'><b>Date:</b>".Date('Y-m-d')."</div><div class='col-sm-12'><b>Time:</b>   ".Date('h:i A')."</div><div class='col-sm-12'><b>Cashier:</b>".Date('h:i A')."</div><div class='col-sm-12'><b>Customer:</b>".$user_detail['User']['first_name'].' '.$user_detail['User']['last_name']."</div></div>";

        $total_amt=$checkoutData['cart']['service_charges']+$checkoutData['cart']['product_charges']+$checkoutData['cart']['gift_charges']-$checkoutData['cart']['ttl_discount'];

        $html.="<div class='detail'><table class='table-responsive full-w   table-condensed '><tbody><tr><td><b>Total Service Price : </b>".$checkoutData['cart']['service_charges']."</td></tr><tr><td><b>Total Product Price : </b>".$checkoutData['cart']['product_charges']."</td></tr><tr><td><b>Total Gift Certificate Price : </b>". $checkoutData['cart']['gift_charges']."</td></tr><tr><td><b>Total Discount Price : </b>".$checkoutData['cart']['ttl_discount']."</td></tr><tr><td>---------------------------------</td></tr><tr><td><b>Total Amount Due :  </b>".$total_amt."</td></tr><tr><td><b>Cash Amount :  </b>".$checkoutData['cart']['cash_amt']."</td></tr><tr><td><b>Check Amount :  </b>".$checkoutData['cart']['chk_amt']."</td></tr><tr><td><b>Amount Paid :  </b>".$checkoutData['cart']['amount_paid']."</td></tr><tr><td><b>IOU Outstanding :  </b>".$checkoutData['cart']['change_due']."</td></tr><tr><td><b>Thank you</b></td></tr></tbody></table></div></div></div>";
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
        echo $pdf->Output(WWW_ROOT . 'files/pdf' . DS . 'invoice-'.base64_decode($checkoutData['Appointment']['user_id']).'.pdf', 'F');
        
        //send Mail
        App::import("Model", "User");
        $this->User = new User();
        //pr($checkoutData); die;
        $userData = $this->User->findById(base64_decode($checkoutData['Appointment']['user_id']));
        //pr($userData); die;
        $toEmail =   $userData['User']['email'];
        $fromEmail  =   Configure::read('fromEmail');
        $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']));
        //$path= $_SERVER['SERVER_NAME'];
$path=WWW_ROOT;        
$file_name='files/pdf/invoice-'.$user_id.'.pdf';
        
        $templateID='mail_order_pdf';
        App::import('Model', 'Emailtemplate');
            $this->Emailtemplate = new Emailtemplate();
            $template = $this->Emailtemplate->find('first', array('conditions' => array('Emailtemplate.template_code' => $templateID)));
//print_r($templateID); die;
           
            if(isset($dynamicFields['{template_type}']) && $dynamicFields['{template_type}']==1){
                $messages = (!empty($template['Emailtemplate']['text_template']))?$template['Emailtemplate']['text_template']:$template['Emailtemplate']['template'];   
            }else{
                 
                $messages = $template['Emailtemplate']['template'];
            }
            $subject = $template['Emailtemplate']['name'];
//pr($dynamicVariables); die;
  //      echo $toEmail; echo "==="; echo $fromEmail; echo "==="; echo $subject; echo "==="; echo $messages; echo "==="; echo $path; echo "==="; echo $file_name; echo "==="; echo $templateID; echo "===";echo $dynamicVariables;
 //die;        
        $this->Common->sendEmailAttach($toEmail,$fromEmail,$subject,$messages,$path,$file_name,$templateID,$dynamicVariables);
        //die;
        
        
    }
    
   /* public function admin_mail_pdf($appointment_title=NULL,$user_id=NULL,$service_name=NULL,$start_date=NULL,$duration=NULL,$tempate=NULL,$smsTo=NULL){
        die(":test");
        $this->loadModel('User');
        $userData = $this->User->findById($user_id);
        $toEmail =   $userData['User']['email'];
        $fromEmail  =   Configure::read('fromEmail');
        $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']));
        $path=APP . 'files/pdf';
        $file_name='invoice-'.base64_decode($checkoutData['Appointment']['user_id']).'.pdf';
        echo $path; echo "====="; echo $file_name; die;
        //$userName = $userData['User']['first_name'];
        //$userEmail = $userData['User']['email'];
        //$mbNumber =  $userData['Contact']['cell_phone']; 
        //$country_code  = $userData['Contact']['country_code'];
        $this->Common->sendEmail($toEmail,$fromEmail,$tempate,$dynamicVariables);
        
        //public function sendEmail($to = null, $from = null, $templateID = null, $dynamicFields = null, $reply = null, $path = null, $file_name = null) {
    }*/
}
