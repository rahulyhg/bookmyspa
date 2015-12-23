<?php

class BusinessController extends AppController {

    public $helpers = array('Session', 'Html', 'Form', 'Common'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie', 'Common', 'Image'); //An array containing the names of components this controller uses.

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('finish','signup', 'verify_email', 'verify_sms', 'business_detail', 'complete_registration', 'authentication', 'confirm_registration', 'finish', 'sendPhoneCode', 'sendEmailCode', 'getLocation');
    }

    /**********************************************************************************    
      @Function Name : admin_type
      @Params	 : NULL
      @Description   : The Function is used for list all Business Type
      @Author        : Aman Gupta
      @Date          : 27-Nov-2014
     ********************************************************************************** */

    public function admin_type(){
        $this->layout = 'admin';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Business Type' => 'javascript:void(0);'
        );
        $this->loadModel('BusinessType');
        $cond = array('BusinessType.is_deleted != ' => 1);
        $btypes = $this->BusinessType->find('all', array('conditions' => $cond));
        $this->set(compact('btypes', 'breadcrumb'));
        $this->set('activeTMenu', 'businessType');
        $this->set('page_title', 'Business Type');
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Business";
            $this->render('business_type');
        }
    }

    /*     * ********************************************************************************    
      @Function Name : admin_addbusinessType
      @Params	 : NULL
      @Description   : The Function is used for add/edit Business Type
      @Author        : Aman Gupta
      @Date          : 27-Nov-2014
     * ********************************************************************************* */

    public function admin_addbusinessType($id = NULL){
        $this->layout = 'ajax';
        $this->loadModel('BusinessType');
        $bType = array();
        if ($id) {
            $id = base64_decode($id);
            $this->BusinessType->id = $id;
            $bType = $this->BusinessType->find('first', array('conditions' => array("BusinessType.id" => $id)));
        }
        if ($this->request->is('Put') || $this->request->is('Post')) {
            if ($id) {
                $this->request->data['BusinessType']['id'] = $id;
            } else {
                $this->BusinessType->create();
            }
            if ($this->BusinessType->save($this->request->data)) {
                $user_id = $this->BusinessType->id;
                $edata['data'] = 'success';
                if (isset($bType) && !empty($bType)) {
                    $edata['message'] = __('Business Type updated successfully', true);
                } else {
                    $edata['message'] = __('Business Type created successfully', true);
                }
                echo json_encode($edata);
                die;
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->BusinessType->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        if (!$this->request->data && isset($bType)) {
            $this->request->data = $bType;
        }
    }

    /*     * ********************************************************************************    
      @Function Name : admin_btypechangeStatus
      @Params	 : NULL
      @Description   : Business Type status Change via Ajax
      @Author        : Aman Gupta
      @Date          : 27-Nov-2014
     * ******************************************************************************** */

    public function admin_btypechangeStatus(){
        $this->autoRender = false;
        $this->loadModel('BusinessType');
        if ($this->request->is('post')) {
            if ($this->BusinessType->updateAll(array('BusinessType.status' => $this->request->data['status']), array('BusinessType.id' => $this->request->data['id']))) {
                echo $this->request->data['status'];
            }
        }
        die;
    }

    /*     * ********************************************************************************    
      @Function Name : admin_businesstypeView
      @Params	 : NULL
      @Description   : Business Type View on popup via Ajax
      @Author        : Aman Gupta
      @Date          : 27-Nov-2014
     * ******************************************************************************** */

    public function admin_businesstypeView($id = NULL) {
        $this->layout = 'ajax';
        if ($id) {
            $this->loadModel('BusinessType');
            $btype = $this->BusinessType->findById($id);
            $this->set(compact('btype'));
        }
    }

    /**********************************************************************************    
      @Function Name : admin_deletebusinesstype
      @Params	 : NULL
      @Description   : To Delete Business Type
      @Author        : Aman Gupta
      @Date          : 27-Nov-2014
     * ******************************************************************************** */

    public function admin_deletebusinesstype() {
        $this->autoRender = "false";
        $this->loadModel('BusinessType');
        if ($this->request->is('post') || $this->request->is('put')) {
            $id = $this->request->data['id'];
            $page = $this->BusinessType->findById($id);
            if (!empty($page)) {
                if ($this->BusinessType->updateAll(array('BusinessType.is_deleted' => 1), array('BusinessType.id' => $id))) {
                    $edata['data'] = 'success';
                    $edata['message'] = __('Business Type Deleted Successfully', true);
                } else {
                    $edata['data'] = 'error';
                    $edata['message'] = __('unable_to_delete', true);
                }
            } else {
                $edata['data'] = 'error';
                $edata['message'] = __('page_not_found', true);
            }
        }
        echo json_encode($edata);
        die;
    }

    /*     * ********************************************************************************    
      @Function Name : admin_list
      @Params	 : NULL
      @Description   : The Function is used for list all type of Business/Salon
      @Author        : Aman Gupta
      @Date          : 27-Nov-2014
     * ********************************************************************************* */

    public function admin_list(){
        $this->layout = 'admin';
        $this->loadModel('User');
        $this->loadModel('BusinessType');
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Business List' => 'javascript:void(0);'
        );
        $typeId = $this->Auth->user('type');
        $cond = array('User.type' => array(2, 3, 4),'User.is_deleted'=>0);
        $cond['User.parent_id']  =0;
        $cond['User.first_name !=']  ='';
        $users = $this->User->find('all',
                                   array(
                                         'conditions' => $cond,
                                         'order'=>array('User.created'=>'DESC')
                                         )
                                   );
//        pr($users); die;
        $bTypes = $this->BusinessType->businessTypeList();
        $businessUsers = array('frenchise','multiLocation','individual');
        $businessTypeIds = array();
        if(!empty($users)){
            foreach ($users as $user){
                $businessType = array();
                $businessTypeIds = array();
                if (!empty($user['Salon']['business_type_id']))
                    if(!empty($user['Salon']['business_type_id'])) {
                        if(!empty($bTypes)){
                            $businessTypeIds = unserialize($user['Salon']['business_type_id']);
                            foreach ($bTypes as $key => $bType) {
                                if(!empty($businessTypeIds)){
                                    if(in_array($key, $businessTypeIds)) {
                                        $businessType[] = $bType;
                                    }
                                }
                            }
                            
                        }
                    }
                    
                    if(!empty($businessType)){
                        $user['Salon']['business_type'] = implode(', ', $businessType);
                    } else {
                        $user['Salon']['business_type'] = '';
                    }
                if ($user['User']['type'] == 2) {
                    $businessUsers['frenchise'][] = $user;
                } else if ($user['User']['type'] == 3) {
                    $businessUsers['multiLocation'][] = $user;
                } else if (($user['User']['type'] == 4) && ($user['User']['parent_id'] == 0 || $user['User']['parent_id'] == 1)) {
                    $businessUsers['individual'][] = $user;
                }
            }
        }
        
       //pr($businessUsers); die;
        
        $this->set(compact('users', 'businessUsers', 'breadcrumb', 'businessTypeCS','typeId'));
        $this->set('activeTMenu', 'businessList');
        $this->set('page_title', 'Business List');
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Business";
            $this->render('list_business');
        }
    }

    
   
    
    
    
    
    
    
    /**********************************************************************************    
      @Function Name : admin_create
      @Params	 : NULL
      @Description   : The Function is used for add/edit all type of Business/Salon
      @Author        : Shibu Kumar
      @Date          : 2-Dec-2014
     * ********************************************************************************* */

//    public function admin_create($id = NULL, $type = NULL){
//        $resize = '';
//        $this->layout = 'ajax';
//        $this->loadModel('User');
//        $this->loadModel('Salon');
//        $this->loadModel('BusinessType');
//        $this->loadModel('SalonService');
//        $userInfo = array();
//        if($id){
//            $id = base64_decode($id);
//            $this->User->id = $id;
//            $userInfo = $this->User->find('first', array('conditions' => array("User.id" => $id)));
//        }
//        if($this->request->is('post') || $this->request->is('put')){
//            //echo $id;
//            //pr($this->request->data); die;
//            $userType = $this->request->data['User']['type'];
//            if (($userType == 4) && (isset($this->request->data['User']['fortype']) && $this->request->data['User']['fortype'] == 4)) {
//                unset($this->request->data['User']['parent_id']);
//            }
//            
//            $userImage = $this->request->data['User']['image'];
//            $resize = $this->request->data['resize'];
//            unset($this->request->data['User']['image']);
//            $salonImage = $this->request->data['Salon']['cover_image'];
//            unset($this->request->data['Salon']['cover_image']);
//            if ($id) {
//                $this->request->data['User']['id'] = $id;
//            } else {
//                //$parts = explode("@", $this->request->data['User']['email']);
//                $this->request->data['User']['username'] = $this->request->data['User']['email'];
//                $this->request->data['User']['password'] = strtoupper($this->Common->getRandPass(8));
//                $this->request->data['User']['tmp_pwd']  = $this->Common->fnEncrypt($this->request->data['User']['password']);
//                $this->request->data['User']['tmp'] = 1;
//                $this->request->data['User']['group_id'] = Configure::read('group.' . $userType);
//                $this->User->create();
//            }
//            if (!empty($this->request->data['Salon']['business_type_id'])) {
//                $this->request->data['Salon']['business_type_id'] = serialize(($this->request->data['Salon']['business_type_id']));
//            }
//            // $parent_id = $this->request->data['User']['parent_id'];
//            $this->request->data['User']['parent_id'] = (isset($this->request->data['User']['parent_id']) && $this->request->data['User']['parent_id']) ? $this->request->data['User']['parent_id'] : '0';
//            $this->request->data['User']['created_by'] = (isset($this->request->data['User']['created_by']) && $this->request->data['User']['created_by']) ? $this->request->data['User']['created_by'] : $this->Auth->user('id');
//           // pr($this->request->data);exit;
//            if ($this->User->saveAll($this->request->data)) {
//                $user_id = $this->User->id;
//                if (isset($userImage['error']) && $userImage['error'] == 0) {
//                    $model = "User";
//                    $return = $this->Image->upload_image($userImage, $model, $user_id, true);
//                    if ($return) {
//                        if (isset($userInfo['User']['image']) && (!empty($userInfo['User']['image']))) {
//                            $this->Image->delete_image($userInfo['User']['image'], $model, $user_id, true);
//                        }
//                        $this->User->updateAll(array('User.image' => '"' . $return . '"'), array('User.id' => $user_id));
//                    }
//                }
//                $salon_id = $this->Salon->id;
//                if(isset($salonImage['error']) && $salonImage['error'] == 0){
//                    $modelNew = "Salon";
//                    $return = $this->Image->upload_custom_image($salonImage, $modelNew, $user_id, true);
//                    if ($return) {
//                        if (isset($userInfo['Salon']['cover_image']) && (!empty($userInfo['Salon']['cover_image']))) {
//                            $this->Image->delete_image($userInfo['Salon']['cover_image'], $modelNew, $user_id, true);
//                        }
//                        $this->Salon->updateAll(array('Salon.cover_image' => '"' . $return . '"'), array('Salon.id' => $salon_id));
//                    }
//                }
//                $this->SalonService->recursive = -1;
//                $countService = $this->SalonService->find('count',array('conditions'=>array('SalonService.salon_id'=>$user_id)));
//                if(!$id){
//                // *******Mobile & Verification********
//                        if(!empty($this->request->data['Contact']['country_code']) &&  !empty($this->request->data['Contact']['cell_phone'])){
//                            $phone_token = strtoupper($this->Common->getRandPass(5));
//                            $this->request->data['User']['id']  =  $user_id;
//                            $this->request->data['User']['phone_token'] = $phone_token;
//                            $message = "Welcome to Sieasta. Your one time (OTP) phone verification code is " . $phone_token . " Kindly verify your phone number!!";  
//                            $number =  $this->request->data['Contact']['cell_phone']; 
//                            $country_code  = $this->request->data['Contact']['country_code'];
//                                  if($country_code){
//                                     $number = str_replace("+","",$country_code).$number;    
//                                  }
//                             $this->User->saveField('phone_token', $phone_token, false);
//                             $this->Common->sendVerificationCode($message,$number);  
//                        }
//                
//                        $this->sendEmailCode($user_id);
//                        $notify_aarray = array(
//                              'notification_to'=>1,
//                               'notification_by'=>$this->Auth->user('id'),
//                               'notification_type' =>'1',
//                               'notification_event_id'=>$user_id,
//                               'associate_modal'=>'User' 
//                        );
//                    //$this->Common->send_notification($notify_aarray);
//                }
//                if(!empty($id) && $userInfo){
//                    if(($userInfo['User']['is_email_verified']==0) or ($userInfo['User']['email'] != $this->request->data['User']['email'])){
//                         $email_token = strtoupper($this->Common->getRandPass(5));
//                            $this->User->updateAll(array('User.email_token' => "'" . $email_token . "'",'User.is_email_verified'=>0), array(
//                                'User.id' => $id,
//                            ));
//                        $this->sendEmailCodeverification(base64_encode($id),$email_token); 
//                    }
//                    if(($userInfo['User']['is_phone_verified']==0) or ($userInfo['Contact']['cell_phone'] != $this->request->data['Contact']['cell_phone'])){
//                            $phone_token = strtoupper($this->Common->getRandPass(5));
//                            $this->request->data['User']['id']  =  $user_id;
//                            $this->request->data['User']['phone_token'] = $phone_token;
//                            $message = "Your one time (OTP) phone verification code is " . $phone_token . " Kindly verify your phone number!!";  
//                            $number =  $this->request->data['Contact']['cell_phone']; 
//                            $country_code  = $this->request->data['Contact']['country_code'];
//                                  if($country_code){
//                                     $number = str_replace("+","",$country_code).$number;    
//                                  }
//                            $this->User->updateAll(array('User.phone_token' => "'" . $phone_token . "'",'User.is_phone_verified'=>0), array(
//                                'User.id' => $userInfo['User']['id'],
//                            ));     
//                            $this->Common->sendVerificationCode($message,$number);     
//                    }
//                }
//                $edata['Salonservice'] = $countService;
//                $edata['uid'] = $user_id;
//                $edata['enc_uid'] = base64_encode($user_id);
//                $edata['data'] = 'success';
//                $edata['message'] = __('Business Added Successfully', true);
//                echo json_encode($edata);
//                die;
//            } else {
//                $message = __('unable_to_save', true);
//                $vError = $this->User->validationErrors;
//                $edata['data'] = $vError;
//                $edata['message'] = $message;
//                echo json_encode($edata);
//                die;
//            }
//        }
//        $businessTpe = array();
//        if (!$this->request->data && isset($userInfo)){
//            $this->request->data = $userInfo;
//            if (!empty($userInfo['Salon']['business_type_id'])) {
//                $businessTpe = unserialize($userInfo['Salon']['business_type_id']);
//            }
//        }
//        $bType = $this->BusinessType->businessTypeList();
//        $frenchList = $this->Common->getFrenchiseList();
////        pr($frenchList); die;
//        $countryData = $this->Common->getCountries();
////        pr($userInfo);
//        $this->set(compact('countryData', 'bType', 'userInfo', 'frenchList', 'businessTpe', 'type'));
//    }

    /*     * ********************************************************************************    
      @Function Name : admin_upload_image
      @Params	 : NULL
      @Description   : The Function is for uploading BUsiness User image via ajax
      @Author        : Aman Gupta
      @Date          : 26-Nov-2014
     * ********************************************************************************* */

    public function admin_upload_image($userId = NULL){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('TempImage');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($_FILES) {
                $model = "User";
                if ($userId) {
                    $retrun = $this->Image->upload_image($_FILES['image'], $model, $userId);
                    if ($retrun) {
                        $uImage = $this->User->find('first', array('fields' => array('User.id', 'User.image'), 'conditions' => array('User.id' => $userId)));
                        if (!empty($uImage)) {
                            if (!empty($uImage['User']['image']))
                                $this->Image->delete_image($uImage['User']['image'], $model, $userId);

                            $this->User->updateAll(array('User.image' => '"' . $retrun . '"'), array('User.id' => $userId));
                            echo $retrun;
                            die();
                        }
                    }else {
                        echo "f";
                    }
                } else {
                    echo "f";
                }
            } else {
                echo "f";
            }
        } else {
            echo "f";
        }

        die();
    }

    /****************************************************************************************    
      @Function Name : signup
      @Params	 : NULL
      @Description   : The Function is user for Business OR any Vendor SignUp
      @Author        : Aman Gupta
      @Date          : 04-Dec-2014
     ********************************************************************************** */

    public function signup(){
        $this->loadModel('User');
        $this->loadModel('BusinessType');
        $countryId = $stateId = $countryCode = '';
        if ($this->request->is('post') || $this->request->is('put')) {
                  //      pr($this->request->data); die;
            if ($this->request->data['User']['type'] != 4)
                unset($this->request->data['User']['parent_id']);
            if ($this->request->data['User']['typeTemp'] != -1)
                $this->request->data['User']['parent_id'] = 0;

            if ($this->request->data['User']['terms_n_condition'] == 0)
                $this->request->data['User']['terms_n_condition'] = NULL;


            if (!empty($this->request->data['Salon']['business_type_id'])) {
                $this->request->data['Salon']['business_type_id'] = serialize($this->request->data['Salon']['business_type_id']);
            }
            
            if (!empty($this->request->data['User']['email'])) {
                //$this->request->data['Salon']['email'] = $this->request->data['User']['email'];
                $ifuserExist = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['User']['email'])));
                
                if(!empty($ifuserExist) && !$ifuserExist['User']['is_email_verified'] && !$ifuserExist['User']['is_phone_verified']){
                    $this->request->data['User']['id'] = $ifuserExist['User']['id'];
                }
                
            }
                //pr($this->request->data);
                //exit;
            if ($this->User->saveAll($this->request->data)) {
                $this->Session->write('businessSetupUserId', base64_encode($this->User->id));
                $this->Session->setFlash(__('business_detail_saved', true), 'flash_success');
                $this->redirect(array('controller' => 'Business', 'action' => 'business_detail'));
            } else {
                $countryId = $this->request->data['Address']['country_id'];
                $stateId = $this->request->data['Address']['state_id'];
                $this->request->data['Salon']['business_type_id'] = unserialize($this->request->data['Salon']['business_type_id']);
                $this->Session->setFlash(__('unable_to_save', true), 'flash_error');
            }
        }
        
        if($this->Auth->loggedIn()){
            if ($this->Auth->user('type') == 6) {
                if (!$this->request->data) {
                    $usersDate = $this->User->findById($this->Auth->user('id'));
                    if (!empty($usersDate['Salon']['business_type_id']))
                        $usersDate['Salon']['business_type_id'] = unserialize($usersDate['Salon']['business_type_id']);
                    $this->request->data = $usersDate;
                    if (empty($countryId))
                        $countryId = $usersDate['Address']['country_id'];
                    if (empty($stateId))
                        $stateId = $usersDate['Address']['state_id'];
                }
            }elseif($this->Auth->user('status') == 1 && $this->Auth->user('is_email_verified') == 1 && $this->Auth->user('is_phone_verified') == 1){
                $this->redirect(array('controller' => 'Dashboard', 'action' => 'index','admin'=>true));
            }
        }
        
        if ($this->Session->read('businessSetupUserId')) {
            $sessionuserId = $this->Session->read('businessSetupUserId');
            $usersDate = $this->User->findById(base64_decode($sessionuserId));
            if ((!$this->request->data) && !empty($usersDate)) {
                if (!empty($usersDate['Salon']['business_type_id']))
                    $usersDate['Salon']['business_type_id'] = unserialize($usersDate['Salon']['business_type_id']);
                $this->request->data = $usersDate;
                if (empty($countryId))
                    $countryId = @$usersDate['Address']['country_id'];
                if (empty($stateId))
                    $stateId = @$usersDate['Address']['state_id'];
            }
        }
        
        $stateData = array();
        $cityData = array();
        if ($countryId) {
            $this->loadModel('State');
            $stateData = $this->State->find('list', array('fields' => array('id', 'name'), 'conditions' => array('State.country_id' => $countryId, 'State.status' => 1)));
            $countryCode  =   $this->Common->getPhoneCode($countryId);
        }
        if ($stateId) {
            $this->loadModel('City');
            $cityData = $this->City->find('list', array('fields' => array('id', 'city_name'), 'conditions' => array('City.state_id' => $stateId, 'City.status' => 1)));
        }
        $countryData = $this->Common->getCountries();
        $bTypes = $this->BusinessType->businessTypeList();
        $frenchList = $this->Common->getFrenchiseList();
        $menuActive = 'business';
        $this->set(compact('stateData', 'cityData', 'countryData', 'menuActive', 'bTypes', 'frenchList','countryCode'));
    }

    /**********************************************************************************    
      @Function Name : business_detail
      @Params	 : NULL
      @Description   : The Function is user for Business Login information
      @Author        : Aman Gupta
      @Date          : 04-Dec-2014
     ********************************************************************************** */

    public function business_detail(){
        $this->loadModel('User');
        if ($this->Auth->loggedIn()) {
            if($this->Auth->user('status') == 1 && $this->Auth->user('is_email_verified') == 1 && $this->Auth->user('is_phone_verified') == 1){
                $this->redirect(array('controller' => 'Dashboard', 'action' => 'index','admin'=>true));
            }
            $getData = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        } else {
            if ($this->Session->read('businessSetupUserId')) {
                $userId = $this->Session->read('businessSetupUserId');
                $getData = $this->User->find('first', array('conditions' => array('User.id' => base64_decode($userId))));
            } else {
                $this->redirect(array('controller' => 'Business', 'action' => 'signup', 'admin' => false));
            }
        }
        unset($getData['User']['password']);
        $this->User->id = $getData['User']['id'];
        if ($this->request->is('post') || $this->request->is('put')) {
            $pass =  $this->request->data['User']['password']; 
            // Check whether phone verification is required or not 

            $phone_verification = false;
            if ($getData['User']['is_phone_verified'] == 1) {
                if ($this->request->data['Contact']['cell_phone'] != $getData['Contact']['cell_phone']) {
                    $phone_verification = true;
                }
            } else {
                $phone_verification = true;
            }
            if ($phone_verification){
                $phone_token = strtoupper($this->Common->getRandPass(5));
                $this->request->data['User']['phone_token'] = $phone_token;
            }

            // Check whether email verification is required or not    

            $email_verification = false;
            if ($getData['User']['is_email_verified'] == 1) {
                if ($this->request->data['User']['email'] != $getData['User']['email']) {
                    $this->request->data['User']['is_email_verified'] = 0;
                    $email_verification = true;
                }
            } else {
                $email_verification = true;
            }
            if ($email_verification) {
                $email_token = strtoupper($this->Common->getRandPass(5));
                $this->request->data['User']['email_token'] = $email_token;
            }
            if ($this->request->data['User']['email']){
              $this->request->data['User']['username'] =  $this->request->data['User']['email'];  
            }
            if ($this->User->saveAll($this->request->data)){
                $redirect = false;
                // If $email_verification = true, Send mail to User
                 $userId = base64_encode($getData['User']['id']);
                if ($email_verification) {
                    $this->sendEmailCode($userId, $email_token);
                    $redirect = 'verify_email';
                }
                $this->Session->setFlash(__('Information Saved Successfully', true), 'flash_success');
                if ($phone_verification) {
                    $message = "Your one time (OTP) phone verification code is " .$phone_token. " Kindly verify your phone number!!";  
                    $number =  $this->request->data['Contact']['cell_phone'];
                    $country_id = $getData['Address']['country_id'];
                     if($country_id){
                     $country_code  =   $this->Common->getPhoneCode($country_id);
                    if($country_code){
                            $number = str_replace("+","",$country_code).$number;    
                        }
                    }
                    $this->Common->sendVerificationCode($message,$number);
                    $redirect = 'verify_sms';
                }
                if ($redirect) {
                    $this->redirect(array('controller' => 'Business', 'action' => $redirect, 'admin' => false));
                } else {
                    $this->redirect(array('controller' => 'Business', 'action' => 'finish', $userId,'admin' => false));
                }
            }
        }
        
        $country_code ='';
        $country_id = $getData['Address']['country_id'];
        if($country_id){
            $country_code  =   $this->Common->getPhoneCode($country_id);
        }
        $this->set(compact('getData','country_code'));
        if (!$this->request->data) {
            if (!empty($getData['Salon']['business_type_id']))
                $getData['Salon']['business_type_id'] = unserialize($getData['Salon']['business_type_id']);
            if (empty($getData['User']['email']))
                $getData['User']['email'] = $getData['Salon']['email'];
                $this->request->data = $getData;
        }
    }

      /*************************************************************************************    
      @Function Name : sendPhoneCode
      @Params	 : NULL
      @Description   : The Function is used for Sending Verification code on Mobile
      @Author        : Shibu Kumar
      @Date          : 17-Dec-2014
     * ********************************************************************************* */
    
    function sendPhoneCode($userId = null) { 
        $this->loadModel('User');
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->autoRender = false;
            $userId = $this->request->data['id'];
            $phone_token = strtoupper($this->Common->getRandPass(5));
            $this->User->updateAll(array('User.phone_token' => "'" . $phone_token . "'",'User.is_phone_verified'=>0), array(
                'User.id' => $userId,
            ));
            $getData = $this->User->findById($userId);
            if($getData){
                    $message = "Your one time (OTP) phone verification code is " .$phone_token. " Kindly verify your phone number!!";  
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
         }
        return true;
    }

    /**********************************************************************************    
      @Function Name : sendEmailCode
      @Params	 : NULL
      @Description   : The Function is used for Sending Verification Email
      @Author        : Shibu Kumar
      @Date          : 17-Dec-2014
     ********************************************************************************** */

     
     
    function sendEmailCode($Id = null, $email_token = null) {
        $userId = base64_decode($Id);
          $this->loadModel('User');
        if ($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            if(isset($this->request->data) && $this->request->data['Salon']['id']==''){
                $userId=$Id;
            }
            else{
            $userId = $this->request->data['id'];
            }
            $email_token = strtoupper($this->Common->getRandPass(5));
            $this->User->updateAll(array('User.email_token' => "'" . $email_token . "'"), array(
                'User.id' => $userId,
            ));
        }
        if ($userId){
            $userData = $this->User->findById($userId);
        }
//print_r($userData); die;
        $this->Common->sendEmailUser($email_token, $userData);
        if ($this->request->is('ajax') && $Id=='') {
            echo 's';
            die;
        }
        elseif($Id!=''){
        return true;
        }
    }

    
    function sendEmailCodeverification($Id = null, $email_token = null,$tempate='resend_verification_code') {
        $userId = base64_decode($Id);
        $this->loadModel('User');  
        if ($userId){
            $userData = $this->User->findById($userId);
        }
        $siteURL = Configure::read('BASE_URL');
                //$emailTo = $userArr['Admin']['email'];
        $userId_encode = base64_encode(base64_encode($userId));
       // $link = '<a href = "' . $siteURL . '/users/confirm_email/'.$userId_encode.'/' . $email_token . '">'.$siteURL.'/users/confirm_email/'.$userId_encode.'/'.$email_token. '</a>';
        $link = $siteURL . '/users/confirm_email/'.$userId_encode.'/' . $email_token;
        $toEmail =   $userData['User']['email'];
        $fromEmail  =   Configure::read('fromEmail');
        $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']),'{Email}'=>$userData['User']['email'],'{Link}'=>$link,'{Username}'=>$userData['User']['email']);
        if($tempate=='resend_verification_code'){
         $dynamicVariables['{Token}'] = $email_token;
        }
        $this->Common->sendEmail($userData['User']['email'],$fromEmail,$tempate,$dynamicVariables);
     }
    
    /*     * ********************************************************************************    
      @Function Name : verify_sms
      @Params	 : NULL
      @Description   : The Function is used for Verifying SMS
      @Author        : Aman Gupta
      @Date          : 04-Dec-2014
     * ********************************************************************************* */

    public function verify_sms() {
        $this->loadModel('User');
        if ($this->Auth->loggedIn()) {
            $getData = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        } else {
            if ($this->Session->read('businessSetupUserId')) {
                $userId = $this->Session->read('businessSetupUserId');
                $getData = $this->User->find('first', array('conditions' => array('User.id' => base64_decode($userId))));
            } else {
                $this->redirect(array('controller' => 'Business', 'action' => 'signup', 'admin' => false));
            }
        }
        unset($getData['User']['password']);
        $this->User->id = $getData['User']['id'];
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['User']['token_phone'])) {
                if ($getData['User']['phone_token'] == $this->request->data['User']['token_phone']) {
                    $data['User']['id'] = $getData['User']['id'];
                    $data['User']['is_phone_verified'] = 1;
                    $data['User']['phone_token'] = '';
                    $data['User']['status'] = 1;
                    if ($this->User->saveAll($data)) {
                        $this->Session->setFlash(__('Mobile Verified Successfully.', true), 'flash_success');
                        if ($getData['User']['is_email_verified'] == 0) {
                            $this->redirect(array('controller' => 'Business', 'action' => 'verify_email', 'admin' => false));
                        } else {
                            $this->redirect(array('controller' => 'Business', 'action' => 'finish',base64_encode($getData['User']['id']), 'admin' => false));
                        }
                    }
                } else {
                    $this->Session->setFlash(__('Invalid Verification Code.', true), 'flash_error');
                }
            } else {
                $this->Session->setFlash(__('Please enter Mobile Verification Code.', true), 'flash_error');
            }
        }

        $this->set(compact('getData'));

        if (!$this->request->data) {
            if (!empty($getData['Salon']['business_type_id']))
                $getData['Salon']['business_type_id'] = unserialize($getData['Salon']['business_type_id']);
            $this->request->data = $getData;
        }
    }

    /*     * ********************************************************************************    
      @Function Name : verify_email
      @Params	 : NULL
      @Description   : The Function is used for Verifying Email
      @Author        : Aman Gupta
      @Date          : 04-Dec-2014
     * ********************************************************************************* */

    public function verify_email($id = null, $token = null) {
        $this->loadModel('User');
        if (($id) && ($token)) {
            $id = base64_decode($id);
            $getData = $this->User->find('first', array('conditions' => array('User.id' => $id, 'User.email_token' => $token)));
            if ($getData) {
                $data['User']['id'] = $getData['User']['id'];
                $data['User']['is_email_verified'] = 1;
                $data['User']['email_token'] = '';
                $data['User']['status'] = 1;
                if ($this->User->saveAll($data)) {
                    $this->Session->setFlash(__('Email Verified Successfully.', true), 'flash_success');
                    $this->redirect(array('controller' => 'Homes', 'action' => 'index', base64_encode($getData['User']['id']),'admin' => false));
                }
            } else {
                $this->redirect(array('controller' => 'Business', 'action' => 'signup', 'admin' => false));
            }
        } else {
            if ($this->Auth->loggedIn()) {
                $getData = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
            } else {
                if ($this->Session->read('businessSetupUserId')) {
                    $userId = $this->Session->read('businessSetupUserId');
                    $getData = $this->User->find('first', array('conditions' => array('User.id' => base64_decode($userId))));
                } else {
                    $this->redirect(array('controller' => 'Business', 'action' => 'signup', 'admin' => false));
                }
            }
            unset($getData['User']['password']);
            $this->User->id = $getData['User']['id'];
            if ($this->request->is('post') || $this->request->is('put')) {
                if(!empty($this->request->data['User']['token_email'])) {
                    if ($getData['User']['email_token'] == $this->request->data['User']['token_email']) {
                        $data['User']['id'] = $getData['User']['id'];
                        $data['User']['is_email_verified'] = 1;
                        $data['User']['email_token'] = '';
                        $data['User']['status'] = 1;
                        if ($this->User->saveAll($data)) {
                            $this->Session->setFlash(__('Email Verified Successfully.', true), 'flash_success');
                            $this->redirect(array('controller' => 'Business', 'action' => 'finish',base64_encode($getData['User']['id']), 'admin' => false));
                        }
                    } else {
                        $this->Session->setFlash(__('Invalid Verification Code.', true), 'flash_error');
                    }
                } else {
                    $this->Session->setFlash(__('Please enter Email Verification Code.', true), 'flash_error');
                }
            }
            $this->set(compact('getData'));
            if (!$this->request->data) {
                if (!empty($getData['Salon']['business_type_id']))
                    $getData['Salon']['business_type_id'] = unserialize($getData['Salon']['business_type_id']);
                $this->request->data = $getData;
            }
        }
    }

    /*     * ********************************************************************************    
      @Function Name : finish
      @Params	 : NULL
      @Description   : The Method is the Thankyou page for the Business Registration
      @Author        : Aman Gupta
      @Date          : 04-Dec-2014
     * ********************************************************************************* */

    public function finish($id=null) {
        $this->loadModel('User');
         
        if ($this->Auth->loggedIn()) {
            $getData = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        } else {
            if ($this->Session->read('businessSetupUserId')) {
                $userId = $this->Session->read('businessSetupUserId');
                $this->Session->delete('businessSetupUserId');
                $getData = $this->User->find('first', array('conditions' => array('User.id' => base64_decode($userId))));
            } else {
                $this->redirect(array('controller' => 'Business', 'action' => 'signup', 'admin' => false));
            }
        }

        if ($getData['User']['type'] == 4) {
            // send mail and notification to
            // $getData['User']['parent_id']
        }
        if($id){
            $this->set('userId',$id);
        }
    }


    function admin_view($userId = NULL){
        //echo $this->request->data['service'];die;
        $this->loadModel('User');
        $this->loadModel('BankDetail');
        $this->loadModel('Album');
        $this->loadModel('FacilityDetail');
        $this->loadModel('BillingDetail');
        $this->loadModel('VenueImage');
        $this->loadModel('SalonAd');
        $this->loadModel('GiftCertificate');
        $this->layout = "admin";
        if ($userId) {
            $userId = base64_decode($userId);
        }
        if (isset($this->params['named']['bview']) && !empty($this->params['named']['bview'])) {
            $userId = base64_decode($this->params['named']['bview']);
            $userId = base64_decode(current(explode('-CODE-', $userId)));
        }
        if ($userId){
            $breadcrumb = array(
                'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
                'Business' => array('controller' => 'Business', 'action' => 'list', 'admin' => true),
                'View' => 'javascript:void(0);'
            );
            $typeId = $this->Auth->user('type');
            $cond = array('User.id' => $userId);
            $user = $this->User->find('first', array('conditions' => $cond));
            if (!empty($user)) {
                //GET SALON LIST FOR FRENCHISE AND MULTI LOCATION
                $salonList = array();
                if (($user['User']['type'] == 2) || ($user['User']['type'] == 3)) {
                    $salonList = $this->User->_getSalonlist($userId);
                    $this->set('checkSalonExist', count($salonList));
                } elseif (($user['User']['type'] == 4) && ($user['User']['parent_id'] != 0)) {
                    $businessOwner = $this->_getBusinessOwner($user['User']['parent_id']);
                    $lastElement = array_pop($breadcrumb);
                    $this->set('businessOwner', $businessOwner);
                    $breadcrumb[$businessOwner['Salon']['eng_name']] = array('controller' => 'Business', 'action' => 'view', 'admin' => true, 'bview' => base64_encode(base64_encode($businessOwner['User']['id']) . '-CODE-' . $businessOwner['User']['username'])
                    );
                    $breadcrumb['View'] = $lastElement;
                }
                //GET STAFF LIST
                $staffList = array();
                $staffList = $this->User->find('all', array('conditions' => array('User.created_by' => $userId, 'User.is_deleted' => 0), 'order' => array('User.id DESC')));
                $this->set('staffList', $staffList);
                //GET BANK DETAILS
                $bank_details = $this->BankDetail->find('first', array('conditions' => array('BankDetail.user_id' => $userId)));
                //GET FACILITY INFORMATION
                $facilityData = $this->FacilityDetail->find('first', array('conditions' => array('FacilityDetail.user_id' => $userId)));
                //GET BILLING INFORMATION
                $billingData = $this->BillingDetail->find('first', array('conditions' => array('BillingDetail.user_id' => $userId)));

                //GET VENUE GALLERY DETAILS
                $venueImages = $this->VenueImage->find('all', array('conditions' => array('user_id' => $userId)));

                //GET PUBLIC ALBUM DETAILS
                $this->Album->bindModel(array('hasMany' => array('AlbumFile' => array('className' => 'AlbumFile', 'foreignKey' => 'album_id'))));
                $publicAlbums = $this->Album->find('all', array('conditions' => array('user_id' => $userId)));
                if (empty($billingData)) {
                    // $user = $user['User'];
                    $billingData['BillingDetail']['contact_name'] = $user['User']['first_name'] . " " . $user['User']['last_name'];
                    $billingData['BillingDetail']['email'] = $user['User']['email'];
                    $billingData['BillingDetail']['phone'] = $user['Contact']['cell_phone'];
                    $billingData['BillingDetail']['contact_phone'] = $user['Contact']['day_phone'];
                    $billingData['BillingDetail']['company_title'] = $user['Salon']['eng_name'];
                    $billingData['BillingDetail']['address'] = $user['Address']['address'];
                    if (!empty($billingData['BillingDetail']['address'])) {
                        $billingData['BillingDetail']['address'] .= ",\n" . $user['Address']['area'];
                    }
                    $billingData['BillingDetail']['postcode'] = $user['Address']['po_box'];
                    $billingData['BillingDetail']['country_id'] = $user['Address']['country_id'];
                    $billingData['BillingDetail']['state_id'] = $user['Address']['state_id'];
                    $billingData['BillingDetail']['city_id'] = $user['Address']['city_id'];
                }
                $countryData = $this->Common->getCountries();
                $this->set(compact('user', 'bank_details', 'facilityData', 'countryData', 'billingData', 'venueImages', 'publicAlbums', 'salonList'));
                $this->set('activeTMenu', 'businessList');
                $this->set('page_title', 'Business');
                //GET ADVERTISEMENT DETAILS
                $this->set('ads', $this->SalonAd->find('all', array('conditions' => array('user_id' => $userId, 'is_deleted' => 0))));
                $this->set('uid', $userId);
                //GET the Gift Certificates
                        $giftCertificateList = $this->GiftCertificate->find('all', array('fields' => array(
                       'GiftCertificate.id', 'GiftCertificate.sender_id', 'GiftCertificate.first_name',
                       'GiftCertificate.last_name','GiftCertificate.gift_certificate_no','GiftCertificate.recipient_id',
                       'GiftCertificate.email',
                       'GiftCertificate.gift_image_id',
                       'GiftCertificate.gift_image_category_id',
                       'GiftCertificate.messagetxt',
                       'GiftCertificate.amount',
                       'GiftCertificate.image',
                   ),
                   'conditions' => array(
                       'GiftCertificate.is_deleted' => 0,
                       'GiftCertificate.payment_status' => 0,
                       'GiftCertificate.user_id'=>$userId,//'GiftCertificate.user_id <>'=>0 //added from front end               
               )));
             
                  //Get Salon Services
            $this->loadModel('SalonService');
             $this->SalonService->bindModel(array('belongsTo' => array('Service')));
        $this->SalonService->recursive = 2;
             $services = $this->SalonService->find('threaded', array('conditions' => array('SalonService.is_deleted' => 0, 'SalonService.salon_id' =>$userId), 'order' => array('SalonService.service_order')));
                        
              $this->set(compact('services'));       
             //Sender and recipient data
                foreach($giftCertificateList  as $key=>$inData){           
                    $sendeData=$this->User->find('first', array('fields' => array('id','first_name'),'conditions'=>array('User.id'=>$inData['GiftCertificate']['sender_id'])));
                     if($inData['GiftCertificate']['recipient_id'] != 0){
                     $recipientData=$this->User->find('first', array('fields' => array('id','first_name'),'conditions'=>array('User.id'=>$inData['GiftCertificate']['recipient_id'])));
                     $giftCertificateList[$key]['GiftCertificate']['recipientName']=$recipientData['User']['first_name'];
                     }else{
                      $giftCertificateList[$key]['GiftCertificate']['recipientName']=$inData['GiftCertificate']['email'];
                     }             
                    $giftCertificateList[$key]['GiftCertificate']['senderName']=$sendeData['User']['first_name'];
                }
               $this->set(compact('giftCertificateList'));
                
            } else {
                $this->Session->setFlash('Unable to find User OR you are not Authorize to view', 'flash_error');
                $this->redirect(array('controller' => 'Business', 'action' => 'list', 'admin' => true));
            }
        } else {
            $this->Session->setFlash('Unable to find User', 'flash_error');
            $this->redirect(array('controller' => 'Business', 'action' => 'list', 'admin' => true));
        }

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Business";
            $this->render('business_view');
        }
    }

    /*     * ********************************************************************************    
      @Function Name : _getBusinessOwner
      @Params	 : NULL
      @Description   : This function is used to get the Business Owner Name
      @Author        : Shibu
      @Date          : 18-Dec-2014
     * ********************************************************************************* */

    function _getBusinessOwner($userId = null) {
        $this->loadModel('User');
        return $this->User->find('first', array('fields' => array('Salon.eng_name', 'User.id', 'User.username'), 'conditions' => array('User.id' => $userId)));
    }

    public function home() {
        echo "Welcome to connect home page";
        exit;
    }

    /*     * ********************************************************************************    
      @Function Name : admin_changeStatus
      @Params	 : NULL
      @Description   : User status Change via Ajax
      @Author        : Aman Gupta
      @Date          : 19-Nov-2014
     * ******************************************************************************** */

    public function admin_changeStatus() {
        $this->loadmodel('User');
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $field = (isset($this->request->data['type']))?$this->request->data['type']:'status';
            if ($this->User->updateAll(array('User.'.$field => $this->request->data['status']), array('User.id' => $this->request->data['id']))) {
                echo $this->request->data['status'];
            }
        }
        die;
    }

    /*
     * This function is used to send email with template  
     * @author        Shibu Kumar
     * @method        sendEmail
     * @param         $to, $subject, $messages, $from, $reply,$path,$file_name
     * @return        void 
     */

    function getSerializeResult($theData = array()) {
        if ($theData) {
            $theData = array_filter($theData);
            if (!empty($theData)) {
                return serialize(array_keys($theData));
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    /**********************************************************************************    
      @Function Name : admin_services
      @Params	 : NULL
      @Description   : view the Services of the Vendor
      @Author        : Aman Gupta
      @Date          : 28-Jan-2015
     * ********************************************************************************* */

    public function admin_services($focus_class=null){
        $deal = $deals =  array();
        $this->layout = 'admin';
        $activeTMenu = 'treatment';
        $navActive = 'service';
        $leftMenu = true;
        $page_title = 'Services & Treatments';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Services & Treatments' => 'javascript:void(0);'
        );
        $this->deleteUnsavedService($this->Auth->User('id'));
        $this->loadModel('SalonService');
        $this->SalonService->bindModel(array('belongsTo' => array('Service')));
        $this->SalonService->recursive = 2;
       
        $services = $this->SalonService->find('threaded', array('conditions' => array('SalonService.is_deleted' => 0, 'SalonService.salon_id' => $this->Auth->user('id')), 'order' => array('SalonService.service_order')));
        $dealCount = $this->Common->getActiveDealCount($this->Auth->user('id'));
        if(count($services)){
            $serviceList = $this->SalonService->find('list', array('conditions' => array('SalonService.is_deleted' => 0, 'SalonService.salon_id' => $this->Auth->user('id'))));
            $this->LoadModel('DealServicePackage');
            $this->DealServicePackage->unBindModel(array('hasMany'=>'DealServicePackagePriceOption'));
            $this->DealServicePackage->bindModel(array('belongsTo'=>array('Deal')));
            $fields = array('Deal.status' ,'Deal.max_time','DealServicePackage.salon_service_id');
            $deals =   $this->DealServicePackage->find('all',array('conditions'=>array('DealServicePackage.package_id'=>'', 'salon_service_id'=>$serviceList),'fields'=>$fields));
            $deal = array();
            foreach($deals as $dealData){
               //$deal['status'][] = $dealData['Deal']['status'];
              //$deal['max_time'][] = $dealData['Deal']['max_time'];
              $deal['salon_service_id'][] = $dealData['DealServicePackage']['salon_service_id'];
            }
        }
        $this->set(compact('activeTMenu','navActive' ,'leftMenu', 'page_title', 'breadcrumb', 'services','focus_class','deal','deals','dealCount'));
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Business";
            $this->render('list_service');
        }
    }
    
    function deleteUnsavedService($userId=null){
        $this->loadModel('SalonService');
        $this->SalonService->deleteAll(array('SalonService.status'=>2,'SalonService.salon_id'=>$userId));
        return true;
    }
    
    function deleteUnsavedPackage($userId = null){
        $this->loadModel('Package');
        $this->Package->deleteAll(array('Package.status'=>2,'Package.user_id'=>$userId));
        return true;
    }
    /*     * ********************************************************************************    
      @Function Name : admin_service_order
      @Params	 : NULL
      @Description   : for ordering the Services
      @Author        : Aman Gupta
      @Date          : 28-Jan-2015
     * ********************************************************************************* */

    public function admin_service_order() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        if ($this->request->is('ajax')) {
            $stringObject = json_decode(stripslashes($this->request->data['serviceOrder']), true);
            $this->recursor($stringObject);
            die;
        }
    }

    /*     * ********************************************************************************    
      @Function Name  : recursor
      @Params	    : NULL
      @Description    : The Function is for save threaded multiple services request.
      @Author         : Aman Gupta
      @Date           : 28-Jan-2015
     * ********************************************************************************* */

    public function recursor(&$complexArray = null) {
        if (is_array($complexArray) && count($complexArray) > 0) {
            foreach ($complexArray as $n => $v) {
                $this->loadModel('SalonService');
                $dataT = array();
                $dataT['SalonService']['id'] = $v;
                $dataT['SalonService']['service_order'] = $n;
                $this->SalonService->updateAll($dataT['SalonService'], array('SalonService.id' => $v));
            }
        }
    }

    /**********************************************************************************    
      @Function Name : admin_set_logout_time
      @Params	 : NULL
      @Description   : set user/salon logout time via Ajax
      @Author        : Surjit
      @Date          : 03-Dec-2014
     ********************************************************************************** */

    public function admin_set_logout_time() {
         //pr($_POST);
        //die;
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ($this->Salon->update(array('Salon.logout_time1' => "'" . $this->request->data['logout_time'] . "'"), array('User.id' => $this->Auth->user('id')))) {
                exit;
            } else {
                exit;
            }
        }
    }

    /**********************************************************************************    
      @Function Name : getLocation
      @Params	 : NULL
      @Description   : Get User Location by opassing Latitude and Longitude
      @Author        : Shibu Kumar
      @Date          : 03-Dec-2014
     * ********************************************************************************* */

    public function getLocation() {
        $this->loadModel('City');
        $lat = $this->request->data('lat');
        $lng = $this->request->data('lng');
        $getData = $this->City->query("SELECT cities.id,cities.city_name,countries.name,states.name,states.id,countries.id,countries.iso_code,  SQRT(
    POW(69.1 * (cities.latitude - $lat), 2) +
    POW(69.1 * ($lng - cities.longitude) * COS(cities.latitude / 57.3), 2)) AS distance
FROM cities join states on cities.state_id=states.id join countries on cities.country_id =countries.id where countries.status=1 and countries.is_deleted=0 HAVING distance < 100  ORDER BY distance limit 1;");
        if(isset($getData[0]['states']['id'])){
            setcookie('State',$getData[0]['states']['id'],time() + (86400 * 30));
           // pr($_COOKIE);
        }
        echo json_encode($getData);
        die;
    }

    
     public function getIsoCode($id=null){
        $this->autoRender = false;
        if($id){
            $this->loadModel('Country');
            $countryData = $this->Country->find('first',array('conditions'=>array('id'=>$id)));
            if(!empty($countryData)){
               return $countryData ['Country']['iso_code'];
            }
        }
        return false;
     }
    
    
    /********************************************************************************************    
      @Function Name  : admin_staffservices
      @Params	    : NULL
      @Description    : Get Staff Services
      @Author         : Shibu Kumar
      @Date           : 14-Jan-2015
    ************************************************************************************************/

    function admin_staffservices($staffId = NULL) {
        $staffId = base64_decode($staffId);
        $this->layout = 'admin';
        $this->loadModel('SalonStaffService');
        $this->loadModel('SalonService');
        $this->loadModel('ServicePricingOption');
        $this->SalonService->bindModel(array('belongsTo' => array('Service')));
        $serviceData = $this->SalonService->find('threaded', array('conditions' => array('SalonService.salon_id' => $this->Auth->user('id'),'SalonService.is_deleted'=>0,'SalonService.status'=>1)));
        if ($this->request->is(array('put', 'post'))) {
           
            $this->request->data['SalonStaffService']['salon_service_id'] = array_filter($this->request->data['SalonStaffService']['salon_service_id']);
            if (!empty($this->request->data['SalonStaffService']['salon_service_id'])) {
                foreach ($this->request->data['SalonStaffService']['salon_service_id'] as $serviceId) {
                    $ServiceExist = array();
                    $sdata = array();
                    $ServiceExist = $this->SalonStaffService->find('first', array('fields' => array('SalonStaffService.id'), 'conditions' => array('SalonStaffService.staff_id' => $staffId, 'SalonStaffService.salon_service_id' => $serviceId)));
                    if (empty($ServiceExist)) {
                        $sdata['SalonStaffService']['staff_id'] = $staffId;
                        $sdata['SalonStaffService']['salon_service_id'] = $serviceId;
                        $sdata['SalonStaffService']['status'] = 1;
                        //$this->SalonStaffService->create();
                        $this->SalonStaffService->saveAll($sdata);
                    }else{
                        $sdata['SalonStaffService']['id']   =   $ServiceExist['SalonStaffService']['id'];
                        $sdata['SalonStaffService']['staff_id'] = $staffId;
                        $sdata['SalonStaffService']['status'] = 1;
                        $sdata['SalonStaffService']['salon_service_id'] = $serviceId;
                        $this->SalonStaffService->save($sdata);
                    }
                }
                //$this->SalonStaffService->deleteAll(array('SalonStaffService.staff_id' => $staffId, 'NOT' => array('SalonStaffService.salon_service_id' => $this->request->data['SalonStaffService']['salon_service_id'])));
                $this->SalonStaffService->updateAll(array('SalonStaffService.status'=>0),array('SalonStaffService.staff_id' => $staffId, 'NOT' => array('SalonStaffService.salon_service_id' => $this->request->data['SalonStaffService']['salon_service_id'])));
               $this->redirect(array('controller' => 'SalonStaff', 'action' => 'index'));
            }
            else{
                //$this->Session->setFlash(__('Please select at least one service.', true), 'flash_error');
                //$this->SalonStaffService->deleteAll(array('SalonStaffService.staff_id' => $staffId));
               $this->SalonStaffService->updateAll(array('SalonStaffService.status'=>0),array('SalonStaffService.staff_id' => $staffId));
                $this->redirect(array('controller' => 'SalonStaff', 'action' => 'index'));
            }
        }
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Staff' => array('controller' => 'SalonStaff', 'action' => 'index', 'admin' => true),
            'Add Staff Services' => 'javascript:void(0);'
        );
        $pricingLlevelid = $this->Common->get_price_level_id($staffId);
        $pricingLevelServices = $this->ServicePricingOption->find('list',array('fields'=>array('id','salon_service_id'),'conditions'=>array('ServicePricingOption.pricing_level_id'=>$pricingLlevelid,'ServicePricingOption.user_id'=> $this->Auth->User('id')),'group'=>'salon_service_id'));
        $allStaffServices = $this->ServicePricingOption->find('list',array('fields'=>array('id','salon_service_id'),'conditions'=>array('ServicePricingOption.pricing_level_id'=>0,'ServicePricingOption.user_id'=> $this->Auth->User('id')),'group'=>'salon_service_id'));
       
        $this->set(compact('pricingLevelServices','allStaffServices','breadcrumb', 'serviceData', 'staffId','pricingLlevelid'));
        $this->set('activeTMenu', 'treatment');
        $this->set('page_title', 'Add Staff Services');
        $this->set('leftMenu', true);
    }
    
    
    

    function admin_changeStatus_user() {
        $this->loadModel('User');
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ($this->User->updateAll(array('User.status' => $this->request->data['status']), array('User.id' => $this->request->data['id']))) {
                return $this->request->data['status'];
            }
        }
        die;
    }

    
    function admin_staff_profile($id) {
        $this->loadModel('User');
        $user = $this->User->findById($id);
        $this->set(compact('user'));
    }

    function admin_editStaff($id, $uid){
        $this->loadModel('User');
        if ($id != NULL) {
            $user = $this->User->findById($id);
            $this->set(compact('user'));
        }
        if ($this->request->is(array('put', 'post'))) {
            $this->request->data['User']['status'] = 1;
            $this->request->data['User']['type'] = 5;
            $this->request->data['User']['created_by'] = $uid;
            $this->User->set($this->request->data);
            if ($id) {
                $this->User->id = $id;
            } else {
                $this->User->create();
            }
            if ($this->User->saveAll($this->request->data)) {
                $edata['data'] = 'success';
                $edata['message'] = __('User Updated Successfully', true);
                echo json_encode($edata);
                die;
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->User->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                exit();
            }
        }
        if (!($this->request->data) && count($user)) {
            $this->request->data = $user;
        }
    }

    function admin_delete_user() {
        $this->loadModel('User');
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ($this->User->updateAll(array('User.is_deleted' => 1), array('User.id' => $this->request->data['id']))) {
                return $this->request->data['id'];
            }
        }
        die;
    }

    /**
     * Edit Advertisement for superadmin
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_editAds
     * @param         $id
     * @since         version 0.0.1
     */
    
    public function admin_addeditAds($id = NULL){
        $this->layout = 'ajax';
        $this->loadModel('SalonAd');
        if (isset($_GET['userViewId'])){
            $userViewId = $_GET['userViewId'];
        }
        if ($id){
            $adDetail = $this->SalonAd->findById($id);
        }
        $uid = !empty($userViewId) ? $userViewId : $this->Auth->user('id');
        if ($this->request->is('post') || $this->request->is('put')){
            //Advertisement image upload
            if (!empty($this->request->data['SalonAd']['image']['name'])){
                $image = $this->request->data['SalonAd']['image'];
                unset($this->request->data['SalonAd']['image']);
                $model = "SalonAd";
                list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);
                if ($width == '520' && $height == '144') {
                    $retrun = $this->Image->upload_image($image, $model, $uid);
                    if ($retrun) {
                        $this->request->data['SalonAd']['image'] = $retrun;
                        if (@$adDetail['SalonAd']['image']) {
                            $this->Image->delete_image($adDetail['SalonAd']['image'], $model, $uid);
                        }
                    }
                } else {
                    $edata['data'] = 'Fail';
                    $edata['message'] = __('only_width_540_height_140_allowed', true);
                    echo json_encode($edata);
                    die;
                }
            } else {
                $this->request->data['SalonAd']['image'] = @$adDetail['SalonAd']['image'];
            }
            $data = $this->request->data;
            if (!empty($data['SalonAd']['id'])) {
                $this->SalonAd->id = $data['SalonAd']['id'];
            } else {
                $data['SalonAd']['created_by'] = $this->Auth->user('id');
                $data['SalonAd']['user_id'] = $uid;
                $data['SalonAd']['createdDate'] = date('d-m-y');
                $this->SalonAd->create();
            }
            if ($this->SalonAd->save($data)) {
                $edata['data'] = 'success';
                $edata['message'] = __('Advertisment_save_success', true);
                echo json_encode($edata);
                die;
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->SalonAd->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        if(!$this->request->data && isset($adDetail)){
            $this->request->data = $adDetail;
            $this->set('adDetail', $adDetail);
        }
        $this->set('uid', $uid);
    }


//     function sendVerificationCode($message=NUll,$number=NULL){
//        $user="sieasta"; //your username
//        $password="ham@123"; //your password
//        $mobilenumbers=$number; //enter Mobile numbers comma seperated
//        $message = $message; //enter Your Message
//        $senderid="SMSCountry"; //Your senderid
//        $messagetype="N"; //Type Of Your Message
//        $DReports="Y"; //Delivery Reports
//        $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
//        $message = urlencode($message);
//        $ch = curl_init();
//        if (!$ch){die("Couldn't initialize a cURL handle");}
//        $ret = curl_setopt($ch, CURLOPT_URL,$url);
//        curl_setopt ($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//        curl_setopt ($ch, CURLOPT_POSTFIELDS,
//        "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
//        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
//        // $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
//        $curlresponse = curl_exec($ch); // execute
//        if(curl_errno($ch))
//        //echo 'curl error : '. curl_error($ch);
//            return;
//        if (empty($ret)){
//        // some kind of an error happened
//        //        die(curl_error($ch));
//             curl_close($ch); 
//            return;
//       // close cURL handler
//        } else {
//        $info = curl_getinfo($ch);
//        curl_close($ch); // close cURL handler
////        echo $curlresponse; //echo "Message Sent Succesfully";
//        return FALSE;
//        }
//    }
//    
    
    /**********************************************************************************    
      @Function Name    : admin_packages
      @Params	        : NULL
      @Description      : for the Packages of Salon
      @Author           : Shibu Kumar
      @Date             : 23-Feb-2015
    ********************************************************************************** */
    public function admin_packages() {
        $deal  = $deals = array();
        $this->layout = 'admin';
        $activeTMenu = 'treatment';
        $navActive = 'package';
        $leftMenu = true;
        $page_title = 'Packages';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Packages' => 'javascript:void(0);'
        );
        $this->deleteUnsavedPackage($this->Auth->User('id'));
        $this->loadModel('Package');
        $dealCount = $this->Common->getActiveDealCount($this->Auth->user('id'));
        $packages = $this->Package->find('all', array('contain'=>array('PackageService'),'conditions' => array('Package.is_deleted' => 0, 'Package.type' =>'Package', 'Package.user_id' => $this->Auth->user('id')),'order'=>'Package.modified desc '));
        if(count($packages)){
            $packageList = $this->Package->find('list', array('conditions' => array('Package.is_deleted' => 0, 'Package.type' =>'Package', 'Package.user_id' => $this->Auth->user('id'))));
            $this->LoadModel('DealServicePackage');
            $this->DealServicePackage->unBindModel(array('hasMany'=>'DealServicePackagePriceOption'));
            $this->DealServicePackage->bindModel(array('belongsTo'=>array('Deal')));
            $fields = array('Deal.status' ,'Deal.max_time','DealServicePackage.package_id');
            $deals =   $this->DealServicePackage->find('all',array('conditions'=>array('DealServicePackage.package_id'=>$packageList),'fields'=>$fields,'group' => array('DealServicePackage.deal_id'),));
            //pr($deals); die;
            $deal = array();
            foreach($deals as $dealData){
              $deal['package_id'][] = $dealData['DealServicePackage']['package_id'];
            }
        }
        $this->set(compact('activeTMenu','navActive','leftMenu', 'page_title', 'breadcrumb', 'packages','deal','deals','dealCount'));
        //$this->set(compact('activeTMenu','navActive' ,'leftMenu', 'page_title', 'breadcrumb', 'services'));
         if ($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Business";
            $this->render('list_packages');
        }
              
    }
     
   /**********************************************************************************    
      @Function Name    : admin_spaday
      @Params	        : NULL
      @Description      : for the SPA day of Salon
      @Author           : Shibu Kumar
      @Date             : 2-march-2015
    ********************************************************************************** */
    public function admin_spaday() {
        $this->layout = 'admin';
        $activeTMenu = 'treatment';
        $navActive = 'spaday';
        $leftMenu = true;
        $page_title = 'Services & Treatments';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Services & Treatments' => 'javascript:void(0);'
        );
        $dealCount = $this->Common->getActiveDealCount($this->Auth->user('id'));
        $this->deleteUnsavedPackage($this->Auth->User('id'));
        $this->loadModel('Package');
        $packages = $this->Package->find('all', array('contain'=>array('PackageService'),'conditions' => array('Package.is_deleted' => 0, 'Package.type' =>'Spaday','Package.user_id' => $this->Auth->user('id'))));
         if(count($packages)){
            $packageList = $this->Package->find('list', array('conditions' => array('Package.is_deleted' => 0, 'Package.type' =>'Spaday', 'Package.user_id' => $this->Auth->user('id'))));
            $this->LoadModel('DealServicePackage');
            $this->DealServicePackage->unBindModel(array('hasMany'=>'DealServicePackagePriceOption'));
            $this->DealServicePackage->bindModel(array('belongsTo'=>array('Deal')));
            $fields = array('Deal.status' ,'Deal.max_time','DealServicePackage.package_id');
            $deals =   $this->DealServicePackage->find('all',array('conditions'=>array('DealServicePackage.package_id'=>$packageList),'fields'=>$fields,'group' => array('DealServicePackage.deal_id'),));
            //pr($deals); die;
            $deal = array();
            foreach($deals as $dealData){
              $deal['package_id'][] = $dealData['DealServicePackage']['package_id'];
            }
         }
         $this->set(compact('activeTMenu','navActive','leftMenu', 'page_title', 'breadcrumb', 'packages','dealCount','deal','deals'));
        //$this->set(compact('activeTMenu','navActive' ,'leftMenu', 'page_title', 'breadcrumb', 'services'));
         if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Business";
            $this->render('list_packages');
        }
    }
    
    
     /**********************************************************************************    
      @Function Name    : admin_spaday
      @Params	        : NULL
      @Description      : for the SPA day of Salon
      @Author           : Shibu Kumar
      @Date             : 13-march-2015
    ********************************************************************************** */
     
    public function admin_spabreak(){
        $this->layout = 'admin';
        $activeTMenu = 'treatment';
        $navActive = 'spabreak';
        $leftMenu = true;
        $page_title = 'Spa Break';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Services & Treatments' => 'javascript:void(0);'
        );
        $this->Common->deleteUnsavedSpabreak($this->Auth->User('id'));
        $this->loadModel('Spabreak');
        $this->Spabreak->recursive=2;
        $spabreaks = $this->Spabreak->find('all', array('conditions' => array('Spabreak.is_deleted' => 0, 'Spabreak.user_id' => $this->Auth->user('id'))));
        $this->set(compact('activeTMenu','navActive' ,'leftMenu', 'page_title', 'breadcrumb', 'spabreaks'));
         if ($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Business";
            $this->render('list_spabreak');
         }
    }
    
    /**********************************************************************************    
      @Function Name    : admin_deals
      @Params	        : NULL
      @Description      : for the Deals of the Salon
      @Author           : Aman Gupta
      @Date             : 07-march-2015
    ***********************************************************************************/    
   
    public function admin_deals(){
        $this->layout = 'admin';
        $activeTMenu = 'treatment';
        $navActive = 'deals';
        $leftMenu = true;
        $page_title = 'Services & Treatments';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Services & Treatments' => 'javascript:void(0);'
        );
        $this->loadModel('Deal');
        $this->admin_delete_unusedrow();
        $dealCount = $this->Common->getActiveDealCount($this->Auth->user('id'));
        $pkgDeals = array();
        $srvcDeals = array();
        $this->Deal->recursive = 2;
        $salonId = $this->Auth->user('id');
        $srvcDeals = $this->Deal->find('all',array('conditions'=>array('Deal.type'=>'Service','Deal.is_deleted'=>0,'Deal.salon_id'=>$salonId)));
        $pkgDeals = $this->Deal->find('all',array('conditions'=>array('Deal.type'=>'Package','Deal.is_deleted'=>0,'Deal.salon_id'=>$salonId)));
        $spadayDeals = $this->Deal->find('all',array('conditions'=>array('Deal.type'=>'Spaday','Deal.is_deleted'=>0,'Deal.salon_id'=>$salonId)));
        $this->set(compact('activeTMenu','navActive' ,'leftMenu', 'page_title', 'breadcrumb','srvcDeals','pkgDeals','spadayDeals','dealCount'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Business";
            $this->render('list_deals');
        }
    }
    
    public function admin_delete_unusedrow(){
        $this->loadModel('Deal');
        $this->Deal->deleteAll(array('Deal.status' => 2,'Deal.salon_id'=>$this->Auth->User('id')));
    }
    
    
     
     public function admin_create($id = NULL, $type = NULL){
        $resize = '';
        $this->layout = 'ajax';
        $this->loadModel('User');
        $this->loadModel('Salon');
        $this->loadModel('BusinessType');
        $this->loadModel('SalonService');
        $userInfo = array();
        if($id){
            $id = base64_decode($id);
            $this->User->id = $id;
            $userInfo = $this->User->find('first', array('conditions' => array("User.id" => $id)));
        }
        if($this->request->is('post') || $this->request->is('put')){
            $userType = $this->request->data['User']['type'];
            if (($userType == 4) && (isset($this->request->data['User']['fortype']) && $this->request->data['User']['fortype'] == 4)) {
                unset($this->request->data['User']['parent_id']);
            }
            $userImage = $this->request->data['User']['image'];
            $resize = $this->request->data['resize'];
            unset($this->request->data['User']['image']);
            $salonImage = $this->request->data['Salon']['cover_image'];
            unset($this->request->data['Salon']['cover_image']);
            if ($id) {
                $this->request->data['User']['id'] = $id;
            } else {
                //$parts = explode("@", $this->request->data['User']['email']);
                $this->request->data['User']['username'] = $this->request->data['User']['email'];
                $this->request->data['User']['password'] = strtoupper($this->Common->getRandPass(8));
                $this->request->data['User']['tmp_pwd']  = $this->Common->fnEncrypt($this->request->data['User']['password']);
                $this->request->data['User']['tmp'] = 1;
                $this->request->data['User']['group_id'] = Configure::read('group.' . $userType);
                $this->User->create();
            }
            if (!empty($this->request->data['Salon']['business_type_id'])){
                $this->request->data['Salon']['business_type_id'] = serialize(($this->request->data['Salon']['business_type_id']));
            }
            $this->request->data['User']['parent_id'] = (isset($this->request->data['User']['parent_id']) && $this->request->data['User']['parent_id']) ? $this->request->data['User']['parent_id'] : '0';
            $this->request->data['User']['created_by'] = (isset($this->request->data['User']['created_by']) && $this->request->data['User']['created_by']) ? $this->request->data['User']['created_by'] : $this->Auth->user('id');
          
            if($this->User->saveAll($this->request->data)){
                $user_id = $this->User->id;
                if (isset($userImage['error']) && $userImage['error'] == 0) {
                    $model = "User";
                    $return = $this->Image->upload_image($userImage, $model, $user_id, true);
                    if ($return) {
                        if (isset($userInfo['User']['image']) && (!empty($userInfo['User']['image']))) {
                            $this->Image->delete_image($userInfo['User']['image'], $model, $user_id, true);
                        }
                        $this->User->saveField('image' ,$return);
                    }
                }
                 $salon_id = $this->Salon->id;  
                if(isset($salonImage['error']) && $salonImage['error'] == 0){
                    $modelNew = "Salon";
                    $return = $this->Image->upload_custom_image($salonImage, $modelNew, $user_id, true);
                    if ($return) {
                        if (isset($userInfo['Salon']['cover_image']) && (!empty($userInfo['Salon']['cover_image']))) {
                            $this->Image->delete_image($userInfo['Salon']['cover_image'], $modelNew, $user_id, true);
                        }
                        $this->Salon->saveField('cover_image',$return);
                    }
                }
                $this->SalonService->recursive = -1;
                $countService = $this->SalonService->find('count',array('conditions'=>array('SalonService.salon_id'=>$user_id)));
                
                /***********Mobile & email Verification************************/
                   if(!$id){
                        if(!empty($this->request->data['Contact']['country_code']) &&  !empty($this->request->data['Contact']['cell_phone'])){
                            $phone_token = strtoupper($this->Common->getRandPass(5));
                            $this->request->data['User']['id']  =  $user_id;
                            $this->request->data['User']['phone_token'] = $phone_token;
                            $message = "Welcome to Sieasta. Your one time (OTP) phone verification code is " . $phone_token . " Kindly verify your phone number!!";  
                            $number =  $this->request->data['Contact']['cell_phone']; 
                            $country_code  = $this->request->data['Contact']['country_code'];
                                  if($country_code){
                                     $number = str_replace("+","",$country_code).$number;    
                                  }
                             $this->User->saveField('phone_token', $phone_token, false);
                             $this->Common->sendVerificationCode($message,$number);  
                        }
                        $this->sendEmailCode($user_id);
                        $notify_aarray = array(
                              'notification_to'=>1,
                               'notification_by'=>$this->Auth->user('id'),
                               'notification_type' =>'1',
                               'notification_event_id'=>$user_id,
                               'associate_modal'=>'User' 
                        );
                        $this->Common->send_notification($notify_aarray);
                 }
                /*********************************Admin Re-verification for  Mobile and email if changes*******************************************************/          
                            if(!empty($id) && $userInfo){
                                if(($userInfo['User']['is_email_verified']==0) or ($userInfo['User']['email'] != $this->request->data['User']['email'])){
                                     $email_token = strtoupper($this->Common->getRandPass(5));
                                        $this->User->updateAll(array('User.email_token' => "'" . $email_token . "'",'User.is_email_verified'=>0), array(
                                            'User.id' => $id,
                                        ));
                                    $this->sendEmailCodeverification(base64_encode($id),$email_token); 
                                }
                                if(($userInfo['User']['is_phone_verified']==0) or ($userInfo['Contact']['cell_phone'] != $this->request->data['Contact']['cell_phone'])){
                                        $phone_token = strtoupper($this->Common->getRandPass(5));
                                        $this->request->data['User']['id']  =  $user_id;
                                        $this->request->data['User']['phone_token'] = $phone_token;
                                        $message = "Your one time (OTP) phone verification code is " . $phone_token . " Kindly verify your phone number!!";  
                                        $number =  $this->request->data['Contact']['cell_phone']; 
                                        $country_code  = $this->request->data['Contact']['country_code'];
                                              if($country_code){
                                                 $number = str_replace("+","",$country_code).$number;    
                                              }
                                        $this->User->updateAll(array('User.phone_token' => "'" . $phone_token . "'",'User.is_phone_verified'=>0), array(
                                            'User.id' => $userInfo['User']['id'],
                                        ));     
                                        $this->Common->sendVerificationCode($message,$number);     
                                }
                            }
                /***********************************************************************/
                $edata['Salonservice'] = $countService;
                $edata['uid'] = $user_id;
                $edata['enc_uid'] = base64_encode($user_id);
                $edata['data'] = 'success';
                $edata['message'] = __('Business Added Successfully', true);
                echo json_encode($edata);
                die;
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->User->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        $businessTpe = array();
        if (!$this->request->data && isset($userInfo)){
            $this->request->data = $userInfo;
            if (!empty($userInfo['Salon']['business_type_id'])) {
                $businessTpe = unserialize($userInfo['Salon']['business_type_id']);
            }
        }
        $bType = $this->BusinessType->businessTypeList();
        $frenchList = $this->Common->getFrenchiseList();
//        pr($frenchList); die;
        $countryData = $this->Common->getCountries();
//        pr($userInfo);
        $this->set(compact('countryData', 'bType', 'userInfo', 'frenchList', 'businessTpe', 'type'));
    }
  
}
 
