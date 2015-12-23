<?php
class SalonStaffController extends AppController {
    public $helpers = array('Session', 'Html', 'Form',); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Image','Common'); //An array containing the names of components this controller uses.

    //need to delete beforeFilter method;
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('design_staff','salonStaff','get_salonDetail');
    }
    
    public function admin_index(){
         $this->layout='admin';
         $this->loadModel('User');
         $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Employees'=>array('controller'=>'SalonStaff','action'=>'index','admin'=>true),
                        );
         $this->Session->delete('User.employee_id');
         if($this->Auth->user()){
            $id = $this->Auth->user('id');
           // $this->User->recursive = 2;
           
            $this->User->unbindModel(array('belongsTo'=>array('Group'),'hasOne'=>array('Salon','Address'),
				    'hasMany'=>array('PricingLevelAssigntoStaff'))
			      );
            $fields = array('User.id','User.first_name','User.password','User.last_name','User.email','User.image','User.group_id','User.is_featured_employee','User.booking_status','User.status',
                            'UserDetail.id','UserDetail.user_id','UserDetail.employee_type',
                            'Contact.id','Contact.user_id','Contact.country_code','Contact.cell_phone'
                            );
            $staffList = $this->User->find('all',array('fields'=>$fields,
                                        'conditions'=>array('User.created_by'=>$id,'User.is_deleted'=>0,'User.type'=>5),
                                        'group'=>array('User.id'),
                                        'order' => array('User.created DESC')));
            //pr($staffList);
           // die;
            $this->set('users',$staffList);
            $admin_user = $this->User->findById($id);
            $this->set('admin_user',$admin_user);
         }
        $this->set('activeTMenu','Employees');
        $this->set('leftMenu',false);
        $this->set('page_title' , 'Employees');
        $this->set('breadcrumb',$breadcrumb);
        $this->set('plan',$this->checkPlan($this->Auth->user('id')));
    }
    
    function checkPlan($uid = NULL){
        $this->loadModel('SalonFeaturingSubscriptionPlan');
        $this->SalonFeaturingSubscriptionPlan->recursive = 2;
        $package = $this->SalonFeaturingSubscriptionPlan->find('first', array('conditions' => array('user_id'=>$uid),'fields'=>array('SalonFeaturingSubscriptionPlan.id')));
        if(is_array($package) && count($package)){
            return $package['SalonFeaturingSubscriptionPlan']['id'];
        } else {
            return false;
        }
    }

    
/**********************************************************************************    
  @Function Name : admin_findUserViaEmail
  @Params	 : NULL
  @Description   : This function is for find User via email ID 
  @Author        : Aman Gupta
  @Date          : 08-Dec-2014
**********************************************************************************/
    public function admin_findUserViaEmail(){
        if($this->request->is('post') || $this->request->is('put')){
            $this->loadModel('User');
	    
            if(isset($this->request->data['email']) && !empty($this->request->data['email'])){
                    $user_id = $this->request->data['user_id'];
		    $cond['User.email'] = $this->request->data['email'];
		    $cond['User.is_deleted'] = 0;
		    if($user_id){
			   $cond['NOT'] =  array( 
				'User.id' => $user_id
			);
		    }
		$user = $this->User->find('first',array('fields'=>array('User.id','User.first_name','User.last_name','User.type'),
							'conditions'=>$cond));
                if(!empty($user)){
                        $edata['data'] = 'success' ;
                        $edata['id'] = $user['User']['id'];
                        $edata['name'] = ucfirst($user['User']['first_name']).' '.ucfirst($user['User']['last_name']);
                        if($user['User']['type'] == 6){
                            $edata['type'] = $user['User']['type'];
                        }else{
                            $edata['type'] = 1;
                        }
                }
                else{
                    $edata['data'] = 'error';
                    $edata['id'] = ''; 
                }
            }
            else{
                $edata['data'] = 'error';
                $edata['id'] = ''; 
            }
        }else{
            $edata['data'] = 'error';
            $edata['id'] = ''; 
        }
        echo json_encode($edata);
        die();
    }
    
    
    /**********************************************************************************    
     @Function Name : admin_add
     @Params	 : NULL
     @Description   : Add Staff
     @Author        : Shibu Kumar
     @Date          : 18-Dec-2014
    **********************************************************************************/
    
    function admin_add($uid = NULL){
        $resize='0';
        $notify = false;
        $this->layout = 'admin';
        $this->loadModel('User');
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Staff' => 'javascript:void(0);',
        );
        if ($uid){
            $uid = base64_decode($uid);
            $this->Session->write('User.employee_id', $uid);
         } else {
            $uid = $this->Session->read('User.employee_id');
        }
        if($uid){
            $User = $this->User->findById($uid);
            $this->set('user', $User);
        }
        $priceLevel= array();
        $this->loadModel('PricingLevelAssigntoStaff');
        $priceLevel = $this->PricingLevelAssigntoStaff->find('first', array('conditions' => array('PricingLevelAssigntoStaff.user_id' => $uid), 'fields' => array('id','pricing_level_id')));
        $this->set(compact('priceLevel'));
        if ($this->request->is(array('put', 'post'))){
           // pr($this->data); die;
            if($uid != $this->Auth->user('id')){
                $this->request->data['User']['type'] = 5;
                $this->request->data['User']['created_by'] = $this->Auth->user('id');
                if((!isset($this->request->data['User']['parent_id'])) || (isset($this->request->data['User']['parent_id']) && empty($this->request->data['User']['parent_id']) ))
                $this->request->data['User']['parent_id'] = $this->Auth->user('id');
            }
            $this->request->data['User']['id'] = $uid;
            if(isset($this->request->data['resize'])){
                $resize = $this->request->data['resize'];
            }
            $image = $this->request->data['User']['image'];
            unset($this->request->data['User']['image']);
            if ($uid) {
                $this->User->id = $uid;
            }else {
                $this->request->data['User']['tmp'] = 1;
                $this->User->create();
                $notify = true;
            }
            if(!empty($this->request->data['User']['email'])){
                $emailfindUser = $this->User->find('first',array('fields'=>array('User.id','User.first_name','User.last_name','User.type'),'conditions'=>array('User.email'=>$this->request->data['User']['email'],'User.is_deleted'=>0)));
                if(!empty($emailfindUser)){
                    $uid = $this->User->id = $this->request->data['User']['id'] = $emailfindUser['User']['id'];
                }else{
                  $this->request->data['User']['username'] = $this->request->data['User']['email']; 
                }
            }
            
            $this->User->set($this->request->data);
            if($this->User->validates(array('fieldList' => array('email', 'first_name','last_name','pricing_level_id')))){
                
                //pr($this->request->data);
            if ($this->User->saveAll($this->request->data,array('validate'=>false))){
                $uid = (!empty($uid)) ? $uid : $this->User->getLastInsertId();
                $this->Session->write('User.employee_id', $uid);
                if($notify){
                    $this->Session->write('User.newUser', TRUE);  
                }
                if (!empty($image['name'])){
                    $model = "User";
                    if($resize == '1'){
                        $retrun = $this->Image->upload_service_image($image, $model, $uid);
                    }else{
                        $retrun = $this->Image->upload_service_image($image, $model, $uid);
                    }
                    if ($retrun) {
                        $data['User']['image'] = $retrun;
                        if (isset($User['User']['image']) && (!empty($User['User']['image']))){
                            $this->Image->delete_image($User['User']['image'], $model, $uid);
                        }
                   }
                } else {
                    if (isset($User)) {
                        $data['User']['image'] = $User['User']['image'];
                    } else {
                        $data['User']['image'] = '';
                    }
                }
                    $this->User->id = $uid;
                    $this->User->saveField('image', $data['User']['image']);
                    $this->request->data['PricingLevelAssigntoStaff']['user_id'] = $uid;
                    if(isset($priceLevel['PricingLevelAssigntoStaff']['id']) && $priceLevel['PricingLevelAssigntoStaff']['id'] != 0) {
                        $this->PricingLevelAssigntoStaff->id = $priceLevel['PricingLevelAssigntoStaff']['id'];
                    } else {
                        $this->PricingLevelAssigntoStaff->create();
                    }
                    $price['PricingLevelAssigntoStaff']['user_id'] = $uid;
                    $price['PricingLevelAssigntoStaff']['pricing_level_id'] = $this->request->data['User']['pricing_level_id'];
                    $this->PricingLevelAssigntoStaff->save($price);
                   /********************notification to admin******************/
                   if($notify){
                        $notifyArray = array(
                               'notification_to'=>1,
                               'notification_by'=>$this->Auth->user('id'),
                               'notification_type' =>'2',
                               'notification_event_id'=>$uid,
                               'associate_modal'=>'User' 
                            );
                        $this->Common->send_notification($notifyArray);
                   }
                $edata['data'] = 'success';
                $edata['message'] = __('User Added Successfully', true);
                echo json_encode($edata);
                die;
             }else{
                $message = __('unable_to_save', true);
                $vError = $this->User->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
          }else{
                $message = __('unable_to_save', true);
                $vError = $this->User->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Staff' => array('controller' => 'SalonStaff', 'action' => 'index', 'admin' => true),
            'Add' => 'javascript:void(0);'
        );
        $activeTMenu = 'addStaff';
        $page_title = 'Add Staff';
        $leftMenu = true;
        $this->set(compact('leftMenu', 'activeTMenu', 'breadcrumb', 'page_title'));
        if (!empty($User) && empty($this->request->data)){
            $this->request->data = $User;
        }
    }

/**********************************************************************************    
  @Function Name : admin_changeStatus
  @Params	 : NULL
  @Description   : User status Change via Ajax
  @Author        : Shibu Kumar
  @Date          : 19-Nov-2014
**********************************************************************************/
    public function admin_changeStatus(){
        $this->autoRender = false;
        $this->loadModel('User');
         if ($this->request->is('post')){
            $this->User->id = $this->request->data['id'];
            $status = ($this->request->data['status']=='true')?1:0;
            if ($this->User->saveField('status', $status)) {
                echo $this->request->data['status'];
            }
        }
        exit();
    }
    
  /**********************************************************************************    
  @Function Name : admin_changeStatus
  @Params	 : NULL
  @Description   : User status Change via Ajax
  @Author        : Shibu Kumar
  @Date          : 19-Nov-2014
**********************************************************************************/
    public function admin_changeBookingStatus(){
        $this->autoRender = false;
        $this->loadModel('User');
        if ($this->request->is('post')){
            $this->User->id = $this->request->data['id'];
            $status = ($this->request->data['status']=='true')?1:0;
            if ($this->User->saveField('booking_status', $status)) {
                echo $this->request->data['status'];
            }
        }
        die;
    }

    /**********************************************************************************    
  @Function Name : admin_deleteStaff
  @Params	 : $id = Page Id ,$alias=page alias
  @Description   : Delete of Salon Staff
  @Author        : Shibu Kumar
  @Date          : 19-Nov-2014
***********************************************************************************/
    public function admin_deleteStaff($id=NULL,$alias=NULL){
        $this->autoRender = "false";
        if($id){
            $id = base64_decode($id);
            $page = $this->SalonStaff->findById($id);
            if(!empty($page)){
                if($this->SalonStaff->delete(array('SalonStaff.id'=>$id))){
                    $this->Session->setFlash(__('delete_success',true),'flash_success');
                }
                else{
                    $this->Session->setFlash(__('unable_to_delete',true),'flash_error');
                }
            }else{
                $this->Session->setFlash(__('page_not_found',true),'flash_error');
            }
        }
        else{
            $this->Session->setFlash(__('page_not_found',true),'flash_error');
        }
        $this->redirect(array('controller'=>'SalonStaff','action'=>'index','admin'=>true));
    }
    
       
 /**********************************************************************************    
  @Function Name : admin_staff_login
  @Params	 : 
  @Description   : employee login detail
  @Author        : Sanjeev kanungo
  @Date          : 6 jan
***********************************************************************************/
    
    function admin_staff_login($uid=NULL){
     $this->layout = 'ajax';
     $this->loadModel('User');
     if(!$uid){
       $uid = $this->Session->read('User.employee_id');   
     }

     if($uid){
        $User = $this->User->findById($uid);
        $count_pwd = '';
        $tmpPwd     = $this->Common->fnDecrypt($User['User']['tmp_pwd']);
        if($tmpPwd != ''){
            //$count_pwd = strlen($tmpPwd);
	    $count_pwd = 9;
        }else if(!empty($User['User']['password'])){
	     $count_pwd = 9;	
        }
        $this->set('user' , $User);
        $this->set('count_pwd' , $count_pwd);
     }
       
    if($this->request->is(array('put','post'))){
                if($this->request->data['User']['password1'] &&($this->request->data['User']['password1']!='*********')){
                  $this->request->data['User']['password'] = $this->request->data['User']['password1'];
                  if(!empty($User) && $User['User']['tmp'] == 1)
                        $this->request->data['User']['tmp_pwd'] = $this->Common->fnEncrypt($this->request->data['User']['password']);
                }
                
                //pr($this->request->data);
                $this->User->unbindModel(array('belongsTo'=>array('Group'),'hasOne'=>array('Salon','Address','Contact'),
				    'hasMany'=>array('PricingLevelAssigntoStaff'))
			      );
                
                if($this->User->saveAll($this->request->data)){
                    $uid = (!empty($uid))?$uid:$this->User->getLastInsertId();
                            $this->Session->write('User.employee_id',$uid);
                            $edata['data'] = 'success';
                            $edata['message'] = __('User Added Successfully',true);
                            echo json_encode($edata);
                            die;
                }
                else{
                        $message = __('unable_to_save', true);
                        $vError = $this->User->validationErrors;
                        $edata['data'] = $vError ;
                        $edata['message'] = $message;
                        echo json_encode($edata);
                        die;
                }
	}
	if(!empty($User) && empty($this->request->data)){
            $this->request->data = $User;
            if(empty($User['User']['username'])){
               $this->request->data['User']['username'] = $User['User']['email'];
            }
        }
     }  
     
 /**********************************************************************************    
  @Function Name : admin_contact
  @Params	 : 
  @Description   : employee Contact detail
  @Author        : Sanjeev kanungo
  @Date          : 6 jan
***********************************************************************************/
     function admin_contact($uid=NULL){
        $this->layout = 'ajax';
        $this->loadModel('User');
        if(!$uid){
            $uid = $this->Session->read('User.employee_id');
        }
//        echo $this->Session->read('User.newUser');
        
        $countryData =  $this->Common->getCountries();
        $this->set(compact('countryData'));
        if($uid){
          $User = $this->User->findById($uid);
          //pr($User);
          $this->set('user' , $User);
          if($User['Address']['country_id']){
            $this->loadModel('State');
            $stateList = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$User['Address']['country_id'],'State.status'=>1),'order'=>array('State.name ASC')));
            $this->set('stateLists',$stateList);    
          }
          if($User['Address']['state_id']){
            $this->loadModel('City');
            $cityList = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$User['Address']['state_id'],'City.status'=>1),'order'=>array('City.city_name ASC')));
            $this->set('cities',$cityList);    
          }
        }
        if ($this->request->is(array('put', 'post'))){
            if ($this->User->saveAll($this->request->data)){
                $uid = (!empty($uid)) ? $uid : $this->User->getLastInsertId();
                $this->Session->write('User.employee_id', $uid);
                $edata['data'] = 'success';
                $edata['emp_type'] = @$User['UserDetail']['employee_type'];
                $edata['uid'] = base64_encode($uid);
                $edata['message'] = __('User Added Successfully', true);
                //send email if !empty(tmp_pwd)
                    if(!empty($User) && $User['User']['is_email_verified']==0){
                     if(empty($User['User']['email_token'])){
                        $email_token = strtoupper($this->Common->getRandPass(5));
                        $this->User->updateAll(array('User.email_token' => "'" . $email_token . "'",'User.is_email_verified'=>0), array(
                            'User.id' => $uid,
                        ));
                    }else{
                         $email_token =  $User['User']['email_token'];
                    }
                    $siteURL = Configure::read('BASE_URL');
                     //$emailTo = $userArr['Admin']['email'];
                    $userId_encode = base64_encode(base64_encode($uid));
                     //$link = '<a href = "' . $siteURL . '/users/confirm_email/'.$userId_encode.'/' . $email_token . '">'.$siteURL.'/users/confirm_email/'.$userId_encode.'/'.$email_token. '</a>';
                    $link = $siteURL.'/users/confirm_email/'.$userId_encode.'/'.$email_token;
                    $toEmail    = $User['User']['email'];
                    $fromEmail  = Configure::read('fromEmail');
                    $tmpPwd     = $this->Common->fnDecrypt($User['User']['tmp_pwd']);
                    $dynamicVariables = array('{FirstName}'=>ucfirst($User['User']['first_name']),'{LastName}'=>ucfirst($User['User']['last_name']),'{email}'=>$User['User']['email'],'{password}'=>$tmpPwd,'{Link}'=>$link);
                    $this->Common->sendEmail($toEmail,$fromEmail,'login_credential',$dynamicVariables);
                    }  
                    /******************************************/
                    if(!empty($User) && $User['User']['is_phone_verified']==0){
                        $UserPhone = $this->User->findById($uid);
                        if(empty($UserPhone['User']['phone_token'])){
                                $phone_token = strtoupper($this->Common->getRandPass(5));
                                $this->User->updateAll(array('User.phone_token' => "'" . $phone_token . "'",'User.is_phone_verified'=>0), array(
                                    'User.id' => $uid,
                                ));
                        }else{
                                $phone_token = $UserPhone['User']['phone_token'];
                        }
                        $message = "Welcome to Sieasta. Your account has been creates and  one time (OTP) phone verification code is " .$phone_token. " Kindly login and  verify your phone number!!";  
                        $number =  $UserPhone['Contact']['cell_phone'];
                        $country_id = $UserPhone['Address']['country_id'];
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
        if(!empty($User) && empty($this->request->data)){
         $this->request->data = $User;
         if(!$this->request->data['Contact']['reminder_email'])
            $this->request->data['Contact']['reminder_email'] = 1;
         if(!$User['Contact']['reminder_sms_text'])
            $this->request->data['Contact']['reminder_sms_text'] = 1;
        }
     }

     function sendEmailCode($Id = null, $email_token = null, $calledFrom ='ctpFile',$tmpPwd=null,$tempate='welcome_user') {
        $this->layout = 'ajax';
        $this->autoRender = false;
        $userId = base64_decode(base64_decode($Id));
        $this->loadModel('User');
        if ($userId) {
            $userData = $this->User->findById($userId);
            if(!empty($userData)){
                if(empty($userData['User']['email_token'])){
                    $email_token = strtoupper($this->Common->getRandPass(5));
                    $this->User->updateAll(array('User.email_token' => "'" . $email_token . "'",'User.is_email_verified'=>0), array(
                        'User.id' => $userId,
                    ));
                }
                if(!$email_token){
                    $email_token = $userData['User']['email_token'];
                }
                $siteURL = Configure::read('BASE_URL');
                //$emailTo = $userArr['Admin']['email'];
                $userId_encode = base64_encode(base64_encode($userId));
                //$link = '<a href = "' . $siteURL . '/users/confirm_email/'.$userId_encode.'/' . $email_token . '">'.$siteURL.'/users/confirm_email/'.$userId_encode.'/'.$email_token. '</a>';
                $link = $siteURL.'/users/confirm_email/'.$userId_encode.'/'.$email_token;
                $toEmail =   $userData['User']['email'];
                $fromEmail  =   Configure::read('fromEmail');
                $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']),'{Email}'=>$userData['User']['email'],'{password}'=>$tmpPwd,'{Link}'=>$link);
                if($tempate=='resend_verification_code'){
                 $dynamicVariables['{Token}'] = $email_token;
                }
                $this->Common->sendEmail($userData['User']['email'],$fromEmail,$tempate,$dynamicVariables);
                if ($this->request->is('ajax') && $calledFrom == 'ctpFile') {
                    echo 's';
                    die;
                }
                  return true;
            }
        }
        if ($this->request->is('ajax') && $calledFrom == 'ctpFile') {
            echo 'f';
            die;
        }
        return false;
    }

     
     
     public function admin_serviceConfig($uid = NULL){
        $this->loadModel('Service');
        $this->loadModel('ServiceDetail');
        $this->layout = 'admin';
        if($uid){
            $uid = base64_decode($uid);
        }
        if($this->request->is(array('put', 'post'))){
            $dataArray = $this->request->data;
            foreach ($dataArray as $subArray){
                foreach ($subArray as $data){
                    $serviceDetail = $this->ServiceDetail->find('first', array('conditions'=>array('user_id' => $uid, 'service_id' => $data['service_id'])));
                    if ($serviceDetail){
                        $this->ServiceDetail->id =$serviceDetail['ServiceDetail']['id']; 
                    }else{
                       $this->ServiceDetail->create();
                    } 
                    $requestData = array();
                    $requestData['ServiceDetail'] = $data;
                    $requestData['ServiceDetail']['user_id'] = $uid;
                    if($this->ServiceDetail->save($requestData)){
                        echo 'save';
                    }else{
                        echo 'not save';
                        $errors = $this->ServiceDetail->validationErrors;
                    }
                }
            }
        }
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Employees'=>array('controller'=>'SalonStaff','action'=>'index','admin'=>true),
                        );
        $this->set('activeTMenu','Employees');
        $this->set('leftMenu',false);
        $this->set('page_title','Service Pricing Configuration');
        $this->set('breadcrumb',$breadcrumb);
        $this->Service->recursive = -1;
        $getData = $this->Service->find('threaded',array('fields'=>array('Service.id', 'Service.eng_name AS name', 'Service.parent_id', 'Service.service_order'),'conditions'=>array('Service.status'=>1,'Service.is_deleted'=>0),'order'=>array('Service.service_order')));
        $this->set('services' , $getData);
        $this->set('uid' , $uid);
     }
     
     public function design_staff(){
       $this->layout='admin';
       $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Employees'=>'#',
                        );
        $this->set('activeTMenu','Employees');
        $this->set('leftMenu',TRUE);
        $this->set('page_title','Employees');
        $this->set('breadcrumb',$breadcrumb);   
     }
     
    function admin_addImage($uid=NULL){
        $resize='';
        $User = array();
        $this->loadModel('User');
        if ($uid){
            $User = $this->User->findById($uid);
            $this->set('user', $User);
        }
        if ($this->request->is(array('put', 'post'))) {
            $this->request->data['User']['id'] = $uid;
            $image = $this->request->data['User']['image'];
            $resize = $this->request->data['resize'];
            $this->Session->write('User.employee_id', $uid);
            if (!empty($image['name'])){
                $model = "User";
                if($resize == '1'){
                    $retrun = $this->Image->upload_service_image($image, $model, $uid);
                }else{
                    $retrun = $this->Image->upload_service_image($image, $model, $uid);
                }
                //echo $retrun;exit;
                if ($retrun){
                    $data['User']['image'] = $retrun;
                    if (isset($User['User']['image']) && (!empty($User['User']['image']))) {
                        $this->Image->delete_image($User['User']['image'], $model, $uid);
                    }
                }else{
                    $data['User']['image']='';   
                }
            } else {
                if ($User) {
                    $data['User']['image'] = $User['User']['image'];
                } else {
                    $data['User']['image'] = '';
                }
            }
            $this->User->id = $uid;
            if ($this->User->saveField('image', $data['User']['image'])) {
                $edata['data'] = 'success';
                $edata['message'] = __('Profile Image Successfully', true);
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
        if (!empty($User) && empty($this->request->data)) {
            $this->request->data = $User;
        }
    }
    
    function admin_deleteImage(){
      $this->autoRender = false;
      $this->loadModel('User');
        if (($this->request->data['id']) && (isset($this->request->data['image']) && (!empty($this->request->data['image'])))) {
            $model = 'User';
            $uid = $this->request->data['id'];
            $this->Image->delete_image($this->request->data['image'], $model, $uid);
            $image = '';
            $this->User->id = $uid;
            $data['User']['image'] = $image;
            $data['User']['is_featured_employee'] = 0;
            if($this->User->save($data)){
                echo $this->request->data['id'];
            }
        }
        die;  
    }
    
    public function admin_changeFeaturedStatus(){
        $this->autoRender = false;
        $this->loadModel('User');
        if ($this->request->is('post')) {
            $uid = $this->Auth->user('id');
            $pakage_id = $this->checkPlan($uid);
            if (is_array($pakage) && count($pakage)) {
                $validPlan = $this->validPlan($pakage_id);
                if ($validPlan){
                    $this->User->id = $this->request->data['id'];
                    $status = ($this->request->data['status'] == 'true')?1:0;
                    if($this->User->saveField('is_featured_employee', $status)){
                        echo $this->request->data['status'];
                    }
                }else{
                    return FALSE;
                }
            }else{
                return FALSE;
            }
        }
        die;
    }

    function validPlan($package_id=NULL){
       return TRUE; 
    } 
    
    function admin_deleteUser(){
        $this->autoRender = false;
        $this->loadModel('User');
        $stylist_id = trim($this->request->data['id']);
	$salon_id = trim($this->request->data['salon_id']);
	$count = $this->Common->check_stylist($salon_id,$stylist_id);
	if($count){
	   echo $count;
	   exit;
	}else{
		$this->loadModel('User');
		$this->User->id = $stylist_id;
		$user['User']['parent_id'] =0;
		$user['User']['created_by'] =0;
		$user['User']['type'] =6;
		$user['User']['group_id'] =6;
	        $this->User->save($user , false);
		echo $stylist_id;
		exit;
	}
	exit;
    }
    
/**********************************************************************************    
  @Function Name : salonStaff
  @Params	 : NULL
  @Description   : The display all staff on Salon Page
  @Author        : Aman Gupta
  @Date          : 22-Apr-2014
***********************************************************************************/      
    function salonStaff($salonId = NULL){
        $staffs = array();
        $latestUser = array();
        $staffOfmonth = array();
        $ownProfile = array();
        
        if($salonId){
            $this->layout = 'ajax';
            $this->loadModel('User');
            
            $orderConditions = 'User.first_name ASC';
            
            $criteria =  array('User.created_by'=>$salonId,'User.is_deleted'=>0,'User.type'=>5,'User.booking_status'=>1,'UserDetail.employee_type'=>2,'User.image !=' =>'');
            $latestUser= $this->User->find('first', array('conditions' => $criteria, 'order' => array('User.id DESC'), 'limit' => 1));
            $staffOfmonth= $this->User->find('first', array('conditions' => $criteria, 'order' => array('User.id DESC'), 'limit' => 1));
            $ownProfile =  $this->User->find('first', array('conditions' => array('User.id' => $salonId,'User.image !=' =>'')));
            
            $latestUserId = (isset($latestUser['User']['id']))?$latestUser['User']['id']:0;
            $fullcriteria =  array('User.created_by'=>$salonId,'User.is_deleted'=>0,'User.type'=>5,'User.booking_status'=>1,'UserDetail.employee_type'=>2,'User.image !=' =>'','User.id !=' => $latestUserId);
            
            $this->paginate=array(
	    'limit'=> 6,
	    'order' => $orderConditions
            );//, 'max(Bid.bid_amount) as lastbid'
	
	    $staffs = $this->paginate('User', $fullcriteria);
           
        
        }
        
        
        $this->set(compact('staffs','salonId','latestUser','staffOfmonth','ownProfile'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'salon';
        }
        
            //$this->viewPath = "Elements/frontend/Place";
            //$this->render('staff');
    }
    
    
    
    
    function get_salonDetail($staffId = null, $salonId = null)
    {
        $this->layout = 'ajax';
        
        if($salonId && $staffId){
            $getSalonServices = $this->getserviceDisplayUser($salonId, $staffId);
            $this->set(compact('getSalonServices'));
        }
        
    }
    
    
  
    public function getserviceDisplayUser($salonId = NULL, $staffId = NULL){
        $this->loadModel('SalonService');
        $this->loadModel('SalonStaffService');
        $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
        
        $servicesval = array();
        $salon_service_ids = $this->SalonStaffService->find('all', array('fields' => array('SalonStaffService.salon_service_id'), 'conditions' => array('SalonStaffService.staff_id' => $staffId, 'SalonStaffService.status' => 1)));
        
        if(!empty($salon_service_ids))
        {
            foreach($salon_service_ids as $salon_service_idsVal)
            {
                $servicesval[] = $salon_service_idsVal['SalonStaffService']['salon_service_id'];
            }
        }
        
        $salonService = $this->SalonService->find('all', array('conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1, 'SalonService.salon_id' => $salonId,'SalonService.parent_id'=>0), 'order' => array('SalonService.service_order')));
        
        foreach($salonService as $salserkey=>$theService){
            $subService = $this->SalonService->find('all', array('conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1, 'SalonService.salon_id' => $salonId,'SalonService.parent_id'=>$theService['SalonService']['id'], 'SalonService.id' => $servicesval), 'order' => array('SalonService.service_order')));
            $todayDate = date('Y-m-d');
            foreach($subService as $suKey=>$theTreat){
                
                if($theTreat['SalonServiceDetail']['listed_online']){
                    if($theTreat['SalonServiceDetail']['listed_online'] == 1){
                        if($todayDate < $theTreat['SalonServiceDetail']['listed_online_start']){
                            unset($subService[$suKey]);
                        }
                    }
                    if($theTreat['SalonServiceDetail']['listed_online'] == 2){
                        if($todayDate > $theTreat['SalonServiceDetail']['listed_online_end']){
                            unset($subService[$suKey]);
                        }
                    }
                    if($theTreat['SalonServiceDetail']['listed_online'] == 3){
                        if($todayDate < $theTreat['SalonServiceDetail']['listed_online_start'] || $todayDate > $theTreat['SalonServiceDetail']['listed_online_end']){
                            unset($subService[$suKey]);
                        }
                    }
                }
                
            }
            
            if(empty($subService)){
                unset($salonService[$salserkey]);
            }else{
                $salonService[$salserkey]['children'] = $subService;
            }
        }
        
        return $salonService;
    }
    
}

?>