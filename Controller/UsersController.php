<?php
App::import("Vendor", "/Facebook/facebook");
App::import('Controller', 'AppController');
App::uses('Sanitize', 'Utility');

class UsersController extends AppController {
    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email','RequestHandler', 'Cookie','Image','Common','Acl','Google.Google','Paginator'); //An array containing the names of components this controller uses.

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('admin_appointments','verfiyemail','request_booking','mergingCond4UserType','thanks','login','admin_lock', 'register', 'facebook_login','forgetPassword','secure_check', 'initDB','confirm_email',  'sendEmailCode','logout', 'dashboard','upload_image','deleteImage','varify_phone','googleAuth');
    }
    
/**********************************************************************************    
  @Function Name : login
  @Params	 : NULL
  @Description   : Login Users/Staff/SuperAdmin
  @Author        : Aman Gupta
  @Date          : 07-Nov-2014
***********************************************************************************/
    
    public function login(){
        $this->layout = 'ajax';
        $this->set('title_for_layout', 'User Login');
        if (AuthComponent::User('id')) {
            if($this->request->is(array('ajax'))){
                echo '<script>window.location = "/"; </script>';die;
            }else{
                $this->redirect(array('controller'=>'homes','admin'=>false));
            }
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $username = $this->request->data['User']['username'];
            $password = $this->request->data['User']['password'];
            if(empty($username) || $username == null || $username == '')
                {
                    $edata['message'] = __('Please enter username.', true);
                    echo json_encode($edata);
                    die;
                }
            if(empty($password) || $password == null || $password == '')
                {
                    $edata['message'] = __('Please enter password.', true);
                    echo json_encode($edata);
                    die;
                }
                $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
                if (preg_match($regex, $username)){
                    $fuser = $this->User->find('first',array('conditions'=>array('OR'=>array('User.username'=>$this->request->data['User']['username'],'User.email'=>$this->request->data['User']['username']))));
                    if(empty($fuser)){
                        $edata['data'] = 'error' ;
                        $edata['message'] = __('Email not registered. Please signup.', true);
                        echo json_encode($edata);
                        die;
                    }
                    $this->request->data['User']['username'] = $fuser['User']['username'];
                }
                $foundUser = $this->User->find('first',array('conditions'=>array('User.username'=>$this->request->data['User']['username'])));
                if(empty($foundUser)){
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('User not registered. Please signup.', true);
                    echo json_encode($edata);
                    die;
                }
                if(($foundUser['User']['password'] != AuthComponent::password($this->request->data['User']['password']) ) && $foundUser['User']['facebook_id'] ){
                        $edata['data'] = 'error' ;
                        $edata['id'] = $foundUser['User']['id'] ;
                        $edata['message'] = __('Sorry, Username or password is invalid.', true);
                        echo json_encode($edata);
                        die;
                }
                if((!$foundUser['User']['status'] && !$foundUser['User']['is_email_verified']) || ($foundUser['User']['status'] && !$foundUser['User']['is_email_verified'])){
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('Email not verified. Please verify and try again.', true);
                    if($foundUser['User']['password'] == AuthComponent::password($this->request->data['User']['password']) ){
                        $edata['data'] = 'verify_email' ;
                        $edata['id'] = $foundUser['User']['id'] ;
                        $edata['message'] = __('Email not Verified.', true);
                    }
                    echo json_encode($edata);
                    die;
                }
                if($foundUser['User']['status'] && !$foundUser['User']['is_phone_verified'] && $foundUser['User']['type'] == 5){
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('Phone not verified. Please verify and try again.', true);
                    $edata['data'] = 'varify_phone' ;
                    $edata['id'] = $foundUser['User']['id'] ;
                    echo json_encode($edata);
                    die;
                }
                if($foundUser['User']['status']==0){
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('Your account is inactivated, please contact to administrator for help.', true);
                    $edata['id'] = $foundUser['User']['id'] ;
                    echo json_encode($edata);
                    die;
                }
                if($this->Auth->login()){
                    $redirectUR = '';
                    if($this->Session->read('lock_user')){
                         //if($this->Session->check('redirectUrl')){
                           $redirectUR = $this->Session->read('redirectUrl'); 
                         //}else{
                         //   $redirectURl = array('controller' => 'Dashboard', 'action' => 'index','admin'=>true);
                         //}
                    }
                    $this->Session->delete('lock_user');
                    $this->Session->delete('redirectUrl');
                    if(isset($this->data['User']['rememberme'])){
                        if ($this->data['User']['rememberme']) {
                            $cookie = array();
                            $cookie['email'] = base64_encode(base64_encode($this->data['User']['username']) . Configure::read('Security.salt'));
                            $cookie['password'] = base64_encode(base64_encode($this->data['User']['password']) . Configure::read('Security.salt'));
                            setcookie("app_email", $cookie['email'], time()+1209600);
                            setcookie("app_password", $cookie['password'], time()+1209600);
                        } else {
                            setcookie('app_email', '', time()-3600);
                            setcookie('app_password', '', time()-3600);
                        }
                    }
                    $this->User->updateAll(array('User.last_visited'=>'"'.date('Y-m-d H:i:s').'"'),array('User.id'=>$this->Auth->user('id')));
                       $edata['redirectUrl']  = '';
                        if(!empty($redirectUR)){
                           $edata['redirectUrl'] = $redirectUR;
                        }
                        $edata['data'] = 'success' ;
                        if(in_array($this->Auth->user('type'),array(1,2,3,4,5))){
                            if($this->Auth->user('is_email_verified') && $this->Auth->user('is_phone_verified')){
                                $edata['data'] = 'admin' ;
                            }
                            if($this->Auth->user('is_email_verified') && !$this->Auth->user('is_phone_verified')){
                                $edata['data'] = 'verify_phone' ;
                            }
                            if(!$this->Auth->user('is_email_verified')){
                                $edata['data'] = 'verify_email' ;
                            }
                        }
                        $edata['message'] = __('Logged In Successfully', true);
                        echo json_encode($edata);
                        die;
                }else{
                     if(!$this->request->is(array('ajax'))){
                           $this->Session->setFlash(__('Invalid username or password'), 'flash_error');
                           $this->redirect(array('controller' => 'homes', 'action' => 'index'));
                        }
                        
                    $message = __('Invalid username or password, try again', true);
                    if(!($this->request->data['User']['username']) && !($this->request->data['User']['password'])){
                            
                            $message = __('Please enter email id/username and password', true);
                    }elseif(!$this->request->data['User']['username']){
                            
                           $message = __('Please enter username', true);
                    }elseif(!$this->request->data['User']['password']){
                        
                           $message = __('Please enter password', true);
                    }
                    $vError = $this->User->validationErrors;
                    $edata['data'] = $vError ;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
        } else {
            if(isset($_COOKIE['app_email'])){
                $this->request->data['User']['username'] = base64_decode(current(explode(Configure::read('Security.salt'), base64_decode($_COOKIE['app_email']))));
                $this->request->data['User']['password'] = base64_decode(current(explode(Configure::read('Security.salt'), base64_decode($_COOKIE['app_password']))));
                $this->request->data['User']['rememberme'] = 1;
            }
        }
    }
    
    public function verfiyemail($userId = null) {
        $this->set('userId',$userId);
    }
        
    public function admin_lock() {
        $this->layout = "admin_lock";
        if($this->Auth->user()){
            $from_fo_id = $this->Session->read('Auth.from_fo_id');
            $userId = $this->Auth->user('id');
            if($from_fo_id){
                $userId = $from_fo_id; 
            }
            $this->Session->destroy();
            $this->Session->write('lock_user',$userId);
            $this->Session->write('redirectUrl',array('controller' => 'Dashboard', 'action' => 'index','admin'=>true));
            if($this->referer() && $this->referer() !='/' && !$from_fo_id){
               
                $this->Session->write('redirectUrl',$this->referer());
               
            }
        }elseif($this->Session->read('lock_user')){
            $userId = $this->Session->read('lock_user');
            $this->Session->write('redirectUrl',array('controller' => 'Dashboard', 'action' => 'index','admin'=>true));
            if($this->referer() && $this->referer() !='/'){
                $this->Session->write('redirectUrl',$this->referer());
            }
        }else{
            $this->redirect(array('controller'=>'homes','action'=>'index','admin'=>false));
        }
        $user = $this->User->findById($userId);
        $this->set(compact('user'));
    }
    
  /**********************************************************************************    
  Function Name : register
  @Params	 : NULL
  @Description   : For Registration
  @Author        : Sanjeev 
  @Date          : 11-Nov-2014
***********************************************************************************/    
    public function register(){
        $this->set('title_for_layout', 'User Registeration');
        if($this->request->is('post') || $this->request->is('put')){
            $this->request->data['User']['first_name']  =   ucfirst($this->request->data['User']['first_name']);  
            $this->request->data['User']['last_name'] =   ucfirst($this->request->data['User']['last_name']);
             if ($this->request->data['User']['email']){
                $this->request->data['User']['username'] = $this->request->data['User']['email'];
             }
             $this->User->set($this->request->data);
                if($this->request->data['User']['facebook_merge'] !=1){
                    $this->request->data['User']['type']=  6;
                    $this->request->data['User']['group_id']=  6;
                    $fieldsetaray = array('email', 'password','first_name','last_name','terms_n_condition');
                    $this->User->create();
                }else{
                    $this->User->data['User']['is_email_verified'] = 0;
                    $fieldsetaray = array('password','first_name','last_name','terms_n_condition');   
                }
                $this->User->set($this->request->data);
            if($this->User->validates(array('fieldList' => $fieldsetaray))){
                $this->request->data['User']['tmp_pwd']  = $this->Common->fnEncrypt($this->request->data['User']['password']);
                $this->User->save($this->request->data,array('validate'=>false));
                $userIdsimple = $this->User->getLastInsertId();
                $hashCode = strtoupper($this->Common->getRandPass(5));
                $this->User->id = $userIdsimple;
                $this->User->saveField('email_token', $hashCode, false);
                $userId = base64_encode(base64_encode($userIdsimple));
                if($this->sendEmailCode($userId, $hashCode,'sameFile',null,'welcome_user_front')){
                   $message = __('User registered successfully.', true);
                   $edata['Id'] = base64_encode(base64_encode($userIdsimple));
                   $edata['data'] = 'success';
                   $edata['message'] = $message;
                   echo json_encode($edata);
                   die; 
                } else {
                    $message = __('Unable to register User, try again', true);
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
            } else {
                $message = __('Unable to register User, try again', true);
                $vError = $this->User->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        $this->layout = 'ajax';
    }
    
      /*********************************************************************************    
      @Function Name : sendEmailCode
      @Params	 : NULL
      @Description   : The Function is used for Sending Verification Email
      @Author        : Shibu Kumar
      @Date          : 17-Dec-2014
     ********************************************************************************** */

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
                $userId_encode = base64_encode(base64_encode($userId));
                $link = $siteURL . '/users/confirm_email/'.$userId_encode.'/' . $email_token;
                $toEmail =   $userData['User']['email'];
                $fromEmail  =   Configure::read('fromEmail');
                $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']),'{Email}'=>$userData['User']['email'],'{password}'=>$tmpPwd,'{Link}'=>$link,'{Username}'=>$userData['User']['email']);
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
  
 /**********************************************************************************    
  @Function Name : thanks
  @Params	 : NULL
  @Description   : comes when user is Registered
  @Author        : Aman Gupta
  @Date          : 13-Dec-2014
***********************************************************************************/    
    public function thanks($id = NULL) {
        if($id){
            $this->set('userId',$id);
        }else{
        }

    }
 /**********************************************************************************    
  @Function Name : Confirm_email
  @Params	 : NULL
  @Description   : For user email verification.
  @Author        : Sanjeev 
  @Date          : 11-Nov-2014
***********************************************************************************/
 
    function confirm_email($userId = null, $uniqueKey = null){
        $userId = base64_decode(base64_decode($userId));
        $this->layout = 'index';
        $this->set('title', 'Confirm Account');
        $this->set('title_for_layout', 'Confirm Account');
        $this->set('uniqueKey', $uniqueKey);
        $data = $this->User->find('first', array('fields' => array('id'), 'conditions' => array('User.email_token' => $uniqueKey)));
        if (!empty($data) && $data['User']['id'] == $userId) {
            $user['User']['id'] = $userId;
            $user['User']['email_token'] = "";
            $user['User']['status'] = 1;
            $user['User']['is_email_verified'] = '1';
            $this->User->set($user);
            $this->User->save();
            $this->Session->setFlash('Your email has been confirmed successfully.', 'flash_success');
            $this->redirect(array('controller' => 'homes', 'action' => 'index'));
        } else {
            $this->Session->setFlash('The link is not valid anymore. Please register again', 'default', array('class' => 'alert alert-danger'));
            $this->redirect(array('controller' => 'homes', 'action' => 'index'));   
        }
    }
    
 
/**********************************************************************************    
  @Function Name : Forget password
  @Params	 : NULL
  @Description   : Forget Password functionality for all Users
  @Author        : Shibu Kumar
  @Date          : 10-Nov-2014
***********************************************************************************/

    public function forgetPassword(){
        if($this->request->is('Post')||$this->request->is('Put')){
          $this->User->set($this->request->data);
          if($this->User->Validates()){
                $email = $this->request->data['User']['forget_email'];
                $userArr=$this->User->find('first',array('conditions'=>array('User.email'=>$email,'User.is_deleted'=>0),'fields'=>array('User.id','User.first_name','User.last_name','User.email')));
                if(count($userArr) > 0){
                    $this->User->id   = $userArr['User']['id'];
                    $hashCode  =  strtoupper($this->Common->getRandPass(5));
                    $this->User->saveField('email_token',$hashCode, false);
                    App::import('Model','Emailtemplate');
                    $this->Emailtemplate = new Emailtemplate;
                    $siteURL = Configure::read('BASE_URL');
                    $fromEmail      =   Configure::read('fromEmail');
                    $link  = $siteURL. '/homes/index/secure_check/'.$hashCode;
                    $dynamicVariables = array('{FirstName}'=>ucfirst($userArr['User']['first_name']),'{LastName}'=>ucfirst($userArr['User']['last_name']),'{Email}'=>$userArr['User']['email'],'{Link}'=>$link);
                    $toEmail 	= $userArr['User']['email'];
                    $this->Common->sendEmail($toEmail,$fromEmail,'forgot_password',$dynamicVariables);
                    $message = __('Please check your email to reset your password!!', true);
                    $edata['data'] = 'success' ;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }else{
                    $message = __('Email does not exist !', true);
                    $vError = $this->User->validationErrors;
                    $edata['data'] = $vError ;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
            }else{
                $message = __('Error! Please try again', true);
                $vError = $this->User->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
          }
        }
    }
  
  
/**********************************************************************************    
  @Function Name : Secure check
  @Params	 : NULL
  @Description   : This function is for Setting New Password
  @Author        : Shibu Kumar
  @Date          : 14-Nov-2014
***********************************************************************************/

  public function secure_check($email_token=false){
        $this->set('uniqueKey',$email_token);
        if($email_token){
            $data = $this->User->find('first',array('recursive'=>-1,'conditions'=>array('User.email_token'=>$email_token)));
            if(empty($data)){
               $message = __('Invalid token found!', true);
               //$vError = $this->User->validationErrors;
               $edata['data'] = 'error' ;
               $edata['message'] = $message;
               echo json_encode($edata);
               die;
            }
            if(!empty($this->request->data)){
                $this->User->set($this->request->data);
                if($this->User->validates(array('fieldList' => array('password','confirm_password')))){
                    $userId = $data['User']['id'];
                    $this->request->data['User']['id'] = $userId;
                    $this->request->data['User']['tmp_pwd']  = $this->Common->fnEncrypt($this->request->data['User']['password']);
                    $this->request->data['User']['status'] = 1;
                    $this->request->data['User']['email_token'] = "";
                    $this->User->save($this->request->data);
                    $edata['data'] = 'success' ;
                    $edata['message'] = "Password reset successfully";
                    echo json_encode($edata);
                    die;
                }else{
                        $vError = $this->User->validationErrors;
                        $edata['data'] = $vError ;
                        $edata['message'] = 'Error Occurred';
                        echo json_encode($edata);
                        die;
                }
            }
        }else{
               $message = __('Missing token ', true);
               $edata['data'] = 'error' ;
               $edata['message'] = $message;
               echo json_encode($edata);
               die;
        }
    }
    
/**********************************************************************************    
  @Function Name : logout
  @Params	 : NULL
  @Description   : For User Logout
  @Author        : Aman Gupta
  @Date          : 10-Nov-2014
***********************************************************************************/

    public function logout(){
        $baseUrl = Configure::read('BASE_URL');
        $this->Session->destroy();
        $this->Session->setFlash('Successfully Logout', 'flash_success');
        $this->redirect($this->Auth->logout());    
    }
    
/**********************************************************************************    
  @Function Name : logout
  @Params	 : NULL
  @Description   : For User Logout
  @Author        : Aman Gupta
  @Date          : 10-Nov-2014
***********************************************************************************/

        function facebook_login(){
        $userProfile = $this->request->data['User'];
        $this->loadModel('User');
        $this->loadModel('UserDetail');
        $this->autoRender = false;
        $email_status = false;
                    if (is_array($userProfile) and count($userProfile)){
                        $existingUser = $this->User->find('first', array('conditions' => array('User.facebook_id' =>trim($userProfile['id']))));
                        if (isset($existingUser['User']) and ($existingUser['User'])) {
                            if($existingUser['User']['email'] && $existingUser['User']['email']==0){
                               $this->User->id = $existingUser['User']['id'];
                               $this->User->saveField('is_email_verified',1); 
                            }
                            if($existingUser['User']['status']!=1){
                                $this->Session->setFlash(__('Your account is inactivated, please contact to administrator for help.'), 'flash_error');
                            }else{
                                $this->Auth->login($existingUser['User']);
                                echo "success";
                            }
                            exit;
                        } else {
                            
                                if (isset($userProfile['email']) and !empty($userProfile['email'])){
                                    $userExistByEmail = $this->User->find('first', array('conditions' => array('User.email' => $userProfile['email'],'User.is_deleted'=>0)));
                                }  
                                if($userExistByEmail['User']['status']!=1){
                                        $this->Session->setFlash(__('Your account is inactivated, please contact to administrator for help.'), 'flash_error');
                                        exit;
                                }
                                $UserData['User']['facebook_id'] = $userProfile['id'];
                                    if(!isset($userExistByEmail['User']['id']) and empty($userExistByEmail['User']['id'])){
                                        $UserData['User']['profile_name'] = $userProfile['first_name'];
                                        $UserData['User']['status'] = 1; 
                                        if (empty($userProfile['email'])){
                                            $UserData['User']['email'] = "";
                                        }
                                        $UserData['User']['type'] = 6;
                                        $UserData['User']['group_id'] = 6;
                                        $UserData['User']['first_name'] = $userProfile['first_name'];
                                        $UserData['User']['last_name'] = $userProfile['last_name'];
                                        $UserData['User']['email'] = $userProfile['email'];
                                        if($userProfile['email']){
                                          $UserData['User']['is_email_verified'] = 1;
                                        }
                                        $hashCode = strtoupper($this->Common->getRandPass(8));
                                        $UserData['User']['password'] = $hashCode;
                                        $UserData['User']['username'] = $userProfile['email'];
                                        $UserData['User']['image'] = "https://graph.facebook.com/".$UserData['User']['facebook_id']."/picture?width=150&height=150";
                                        $email_status = true;
                                     }
                                     if (isset($userExistByEmail['User']['id']) and !empty($userExistByEmail['User']['id'])){
                                      $UserData['User']['first_name'] = $userProfile['first_name'];
                                      $UserData['User']['last_name'] = $userProfile['last_name'];
                                      if(!$userExistByEmail['User']['image']){
                                           $UserData['User']['image'] = "https://graph.facebook.com/".$UserData['User']['facebook_id']."/picture?width=150&height=150";
                                      }
                                        $this->UserDetail->id = $userExistByEmail['UserDetail']['id'];
                                        $this->User->id = $userExistByEmail['User']['id'];
                                     }
                                    $this->User->save($UserData, array('validate' => false));
                                    if(isset($userExistByEmail['User']['id']) and !empty($userExistByEmail['User']['id'])){
                                      $lastInserId =   $userExistByEmail['User']['id'];
                                    }else{
                                       $lastInserId =  $this->User->getLastInsertId(); 
                                    }
                                    $userdetail['UserDetail']['user_id'] = $lastInserId;
                                    $userdetail['UserDetail']['gender'] = $userProfile['gender'];
                                    $this->UserDetail->save($userdetail);
                                    $User = $this->User->find('first', array('conditions' => array('User.id' => $lastInserId)));
                                     if($email_status){
                                        $this->User->id = $lastInserId;
                                        $siteURL = Configure::read('BASE_URL');
                                        $userId_encode = base64_encode(base64_encode($userId));
                                        $tempate = 'welcome_user_facebook';
                                        $toEmail =   $User['User']['email'];
                                        $fromEmail  =   Configure::read('fromEmail');
                                        $dynamicVariables = array('{FirstName}'=>ucfirst($User['User']['first_name']),'{LastName}'=>ucfirst($User['User']['last_name']),'{Email}'=>$User['User']['email'],'{Password}'=>$hashCode,'{Link}'=>$siteURL);
                                        $this->Common->sendEmail($User['User']['email'],$fromEmail,$tempate,$dynamicVariables);
                                     }
                                    $this->Auth->login($User['User']);
                                    echo "success";
                                    die;
                            }
                       
                    }else{
                            echo "failed";
                            die;  
                    }
    }    
  
/**********************************************************************************    
  @Function Name : index
  @Params	 : NULL
  @Description   : Change Password
  @Author        : Shibu Kumar
  @Date          : 10-Nov-2014
***********************************************************************************/

    function admin_changePassword(){
        $this->layout='admin'; 
        $this->loadModel('User');
        if(isset($this->request->data) && !empty($this->request->data))
        {	
            $userId = $this->Auth->user('id');        
            $userInfo = $this->User->find('first',array('fields'=>array('id','password','email','first_name','last_name'),'conditions'=>array("User.id" => $userId)));
            $this->User->set($this->request->data);
            if($this->User->validates())
            {
                if($userInfo['User']['password']==AuthComponent::password($this->request->data['User']['old_password']))
                {
                    //$this->User->id = $userId;
                    $this->request->data['User']['id'] = $userId;
                    $this->request->data['User']['tmp_pwd']  = $this->Common->fnEncrypt($this->request->data['User']['password']);
                    if($this->User->save($this->request->data)){ 						
                        App::import('Model','Emailtemplate');
                        $this->Emailtemplate = new Emailtemplate;
                        $siteURL = Configure::read('BASE_URL');
                        $template = $this->Emailtemplate->getEmailTemplate('change_password');
                        $emailTo = $userInfo['User']['email'];
                        $data1 = $template['Emailtemplate']['template'];					
                        $data1 = str_replace('{FirstName}',ucfirst($userInfo['User']['first_name']),$data1);
                        $data1 = str_replace('{LastName}',ucfirst($userInfo['User']['last_name']),$data1);
                        $data1 = str_replace('{Email}',$userInfo['User']['email'],$data1);			
                        $emailSubject = ucfirst(str_replace('_', ' ', $template['Emailtemplate']['name']));
                        $this->Session->setFlash("Password has been updated successfully.",'flash_success');
                        $this->redirect(array('controller'=>'dashboard','action'=>'index','admin'=>true));
                   }else{
                        $this->Session->setFlash("Entered password does not match.Please try again.",'flash_error');
                   }
                }else{
                    $this->Session->setFlash("Old Password is Incorrect",'flash_error');			
                }
            }
        }
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Change Password'=>'javascript:void(0);',
                        );
        $this->set('breadcrumb',$breadcrumb);
        $this->set('page_title','Change Password');
        $this->set('activeTMenu','chnagePwd');
    }
        
/**********************************************************************************    
  @Function Name    : admin_editProfile
  @Params	    : NULL
  @Description      : This function is for editing profile information 
  @Author           : Shibu Kumar
  @Date             : 14-Nov-2014
***********************************************************************************/

    function admin_editProfile(){
        $this->layout='admin';
        $this->loadModel('User');
        $userId = $this->Auth->user('id');
        $userInfo = $this->User->find('first',array('conditions'=>array("User.id" => $userId)));
        if(!$this->request->data){
            $this->request->data = $userInfo;
        }
        $this->User->set($this->request->data);
        $this->set(compact('userInfo'));
       
        if(!empty($this->request->data['User']['image']['name'])){
            $model = "User";
            $return = $this->Image->upload_image($this->request->data['User']['image'],$model,$userId);
            if($return){
               $this->request->data['User']['image'] = $return;
               if($userInfo['User']['image']){
                $this->User->saveField('image', $return);
                $this->Image->delete_image($userInfo['User']['image'],$model,$userId);
               }
            }
        }else{
            $this->request->data['User']['image'] =  $userInfo['User']['image']; 
        }
        if($this->request->is('Put')||$this->request->is('Post')){
            $this->request->data['User']['id'] = $userId;
            if($this->User->saveAll($this->request->data)){
                $this->Session->setFlash("Profile edited successfully",'flash_success');
                $this->redirect(array('controller'=>'users','action'=>'editProfile','admin'=>true));    
            }else{
               $this->Session->setFlash("Oops!!! there was some error",'flash_error');
            }
        }
       
        $countryData =  $this->Common->getCountries();
        $this->set(compact('countryData'));
        $breadcrumb = array(
                    'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                    'Edit Profile'=>'javascript:void(0);',
                    );
        $this->set('breadcrumb',$breadcrumb);
        $this->set('page_title','Edit Profile');
        $this->set('activeTMenu','apntmtStng');
    }
        
/**********************************************************************************    
  @Function Name : admin_addUser
  @Params	 : NULL
  @Description   : This function is for adding/editing users from admin 
  @Author        : Aman Gupta
  @Date          : 17-Nov-2014
**********************************************************************************/

    function admin_addUser($userId=null){
        $notification  = false;
        $this->loadModel('Contact');
        $this->loadModel('UserDetail');
        $this->loadModel('Salon');
        $this->layout = 'ajax';
        $userInfo = array();
        if($userId){
            $userId = base64_decode($userId);
            $this->User->id = $userId;
            $userInfo = $this->User->find('first',array('conditions'=>array("User.id" => $userId)));
            if(!empty($userInfo['UserDetail']['tags']))
               $userInfo['UserDetail']['tags'] = implode(',',unserialize($userInfo['UserDetail']['tags']));
        }
        if($this->request->is('Put')||$this->request->is('Post')){
            
            $this->request->data['User']['parent_id'] = $this->Auth->user('id');
            if($this->Auth->user('type') == 4 && $this->Auth->user('parent_id') != 0 ){
                $this->request->data['User']['parent_id'] = $this->Auth->user('parent_id');
            }
            
            // pr($this->request);exit;
            if(isset($this->request->data['User']['addtoSalon'])){
                //die();
                $this->loadModel('UserToSalon');
                $usertosalon = array();
                $usertosalon['UserToSalon']['user_id'] = $this->request->data['User']['id'];
                $usertosalon['UserToSalon']['salon_id'] = $this->request->data['User']['parent_id'];
                $isThereUser = $this->UserToSalon->find('first',array('conditions'=>array('UserToSalon.user_id' => $this->request->data['User']['id'], 'UserToSalon.salon_id' => $this->Auth->user('id') )));
                
                if(empty($isThereUser)){
                    if($this->UserToSalon->save($usertosalon)){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('User added successfully',true);
                        $edata['id'] = base64_encode($this->request->data['User']['id']);
                        echo json_encode($edata);
                        $notify_aarray = array(
                               'notification_to'=>1,
                               'notification_by'=>$this->Auth->user('id'),
                               'notification_type' =>'1',
                               'notification_event_id'=>$this->request->data['User']['id'],
                               'associate_modal'=>'User' 
                        );
                        $this->Common->send_notification($notify_aarray);
                        
                        /*********************Code for send welcome email and sms to new added user in salon*************/
                        $salonId = $this->request->data['User']['parent_id'];
                        $salonData = $this->Salon->find('first', array('fields' => array('Salon.eng_name'), 'conditions' => array('Salon.user_id' => $salonId)));
                        $toUserId = $this->request->data['User']['id'];
                        $user_info = $this->User->find('first', array('fields' => array('User.email','User.first_name','User.is_phone_verified','Contact.*'), 'conditions' => array('User.id' => $toUserId)));
                        
                        if(!empty($user_info) && !empty($salonData))
                        {
                            
                            $salonName = $salonData['Salon']['eng_name'];
                            $userName = $user_info['User']['first_name'];
                            $userEmail = $user_info['User']['email'];
                            $mbNumber =  $user_info['Contact']['cell_phone']; 
                            $country_code  = $user_info['Contact']['country_code'];
                            if(!empty($mbNumber))
                            {
                                  $welcomeMessage = 'Hi '.$userName.', You have been successfully added in '.$salonName.'.';
                                  if($country_code){
                                     $mbNumber = str_replace("+","",$country_code).$mbNumber;    
                                  }
                                  $this->Common->sendVerificationCode($welcomeMessage,$mbNumber);
                            }
                            $this->sendWelcomeEmail($userId, $salonId,'customer_welcome_user');
                        }
                        /******************End of welcome email and sms******************/
                        die;    
                    }
                    else{
                      
                        $message = __('Unable to add User', true);
                        $vError = $this->UserToSalon->validationErrors;
                        $edata['data'] = $vError ;
                        $edata['message'] = $message;
                        echo json_encode($edata);
                        die;
                    }
                }
                else{
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('User already added',true);
                    $edata['id'] = base64_encode($this->request->data['User']['id']);
                    echo json_encode($edata);
                    die;
                }
                
                die;    
            }
            if(isset($userInfo['User']['created_by']) && !$userInfo['User']['created_by'])
                $this->request->data['User']['created_by'] = $this->Auth->user('id');
                
                
            if(isset($this->request->data['User']['image'])){
                $userImage = $this->request->data['User']['image'];
                unset($this->request->data['User']['image']);
            }
            $this->User->set($this->request->data);
            
            if($userId){
                $this->request->data['User']['id'] = $userId;
                $notify = FALSE;
            }else{
                if ($this->request->data['User']['email']){
                    //$parts = explode("@", $this->request->data['User']['email']);
                    $this->request->data['User']['username'] = $this->request->data['User']['email'];
                    $npwd = strtoupper($this->Common->getRandPass(8));
                    $this->request->data['User']['password']  = $npwd;
                    $this->request->data['User']['tmp_pwd']  = $this->Common->fnEncrypt($npwd);
                    $this->request->data['User']['tmp'] = 1;
                }
                $this->User->create();
                $notify = TRUE;
            }
            
            if(!empty($this->request->data['UserDetail']['tags'])){
                $tags = explode(',',$this->request->data['UserDetail']['tags']);
                $this->request->data['UserDetail']['tags'] = serialize($tags);
            }
            $this->request->data['User']['created_by'] = $this->Auth->user('id');
            if($this->Auth->user('type') == 1){
                $this->request->data['User']['created_by'] = '0';
            }
            $this->User->set($this->request->data);
            if($this->User->saveAll($this->request->data, array('validate' => 'only','fieldList'=>array('first_name','last_name','email','cell_phone','gender','marital_status')))){
                if($this->User->saveAll($this->request->data,array( 'validate' => false))){
                    $userId = $this->User->id;
                    if(isset($userImage['error']) && $userImage['error'] == 0){
                        $model = "User";
                        $return = $this->Image->upload_image($userImage,$model,$userId,true);
                        if($return){
                            if(isset($userInfo['User']['image'])&&(!empty($userInfo['User']['image']))){
                                $this->Image->delete_image($userInfo['User']['image'],$model,$userId,true);
                            }
                            $this->User->updateAll(array('User.image'=>'"'.$return.'"'),array('User.id'=>$userId));
                        }
                    }
                    if($notify){
                        $this->User->id = $userId;
                        // *******Mobile & Verification********
                        if(!empty($this->request->data['Contact']['country_code']) &&  !empty($this->request->data['Contact']['cell_phone'])){
                            $phone_token = strtoupper($this->Common->getRandPass(5));
                            $this->request->data['User']['id']  =  $userId;
                            $this->request->data['User']['phone_token'] = $phone_token;
                            $message = "Welcome to Sieasta.Your one time (OTP) phone verification code is " . $phone_token . " Kindly verify your phone number!!";  
                            $number =  $this->request->data['Contact']['cell_phone']; 
                            $country_code  = $this->request->data['Contact']['country_code'];
                                  if($country_code){
                                     $number = str_replace("+","",$country_code).$number;    
                                  }
                             $this->User->saveField('phone_token', $phone_token, false);
                             $this->Common->sendVerificationCode($message,$number);  
                        }
                        $hashCode = strtoupper($this->Common->getRandPass(5));
                        $this->User->saveField('email_token', $hashCode, false);
                       
                        $userIdencoded = base64_encode(base64_encode($userId));
                        $this->sendEmailCode($userIdencoded, $hashCode,'sameFile',$npwd);
                        $notify_aarray = array(
                              'notification_to'=>1,
                               'notification_by'=>$this->Auth->user('id'),
                               'notification_type' =>'1',
                               'notification_event_id'=>$userId,
                               'associate_modal'=>'User' 
                        );
                        $this->Common->send_notification($notify_aarray);
                    }
                    $edata['data'] = 'success' ;
                    if(isset($userInfo) && !empty($userInfo)){
                        $edata['message'] = __('User profile updated successfully',true);
                    }else{
                        $edata['message'] = __('User profile created successfully',true);
                    }
                    $edata['id'] = base64_encode($userId);
                    echo json_encode($edata);
                    die;
                }
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->User->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        if(!$this->request->data && isset($userInfo)){
            $this->request->data = $userInfo;
                if(empty($countryId))
                    $countryId    =   isset($userInfo['Address']['country_id']) ? $userInfo['Address']['country_id']:'';
                if(empty($stateId))
                    $stateId     =   isset($userInfo['Address']['state_id']) ? $userInfo['Address']['state_id'] :'' ; 
        }
        $franchiseList = $this->User->find('all',array('fields'=>array('User.id','Salon.eng_name'),'conditions'=>array('User.type'=>3 , 'User.status'=>1,'User.parent_id'=>0)));
        $frenchList = array();
        if(!empty($franchiseList))
            foreach($franchiseList as $franchises){
                $frenchList[$franchises['User']['id']] = $franchises['Salon']['eng_name'];
            }
        $stateData = array();
        $cityData = array();
        $this->loadModel('State');
         $this->loadModel('City');
        if($countryId){
	    $stateData = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$countryId,'State.status'=>1)));
        }else{
            $countryId  = $this->Auth->user('Address.country_id');
            $stateData = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$countryId,'State.status'=>1)));
        }
        if($stateId){
            $cityData = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$stateId,'City.status'=>1)));
        }else{
            $stateId = $this->Auth->user('Address.state_id');  
            $cityData = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$stateId,'City.status'=>1)));
        }
        $countryData =  $this->Common->getCountries();
        $type = isset($this->request->data['User']['type']) ? $this->request->data['User']['type'] : 6 ;
        $cc_list = $this->listforCC();
        $this->set(compact('countryData','stateData','cityData','userInfo','cc_list','frenchList','type'));
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
            if(isset($this->request->data['email']) && !empty($this->request->data['email'])){
                $user = $this->User->find('first',array('fields'=>array('User.id'),'conditions'=>array('User.email'=>$this->request->data['email'],'User.is_deleted'=>0)));
                if(!empty($user)){
                    $edata['data'] = 'success' ;
                    $edata['id'] = base64_encode($user['User']['id']);
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
  @Function Name : admin_listforCC
  @Params	 : NULL
  @Description   : returns list of users for the User CC mail
  @Author        : Aman Gupta
  @Date          : 25-Nov-2014
**********************************************************************************/

    public function listforCC() {
        $cond = array('User.status'=>1,'User.type'=>array(2,3,4,5));
        $users = $this->User->find('all',array('fields'=>array('User.id','User.first_name','User.last_name','User.email'),'conditions'=>$cond));
        if(!empty($users)){
            $data = array();
            foreach($users as $user){
                $data[$user['User']['id']] =  ucfirst($user['User']['first_name'])." ".ucfirst($user['User']['last_name']).' ('.$user['User']['email'].')';
            }
            return $data;
        }else{
            return array();
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
/**********************************************************************************    
  @Function Name : admin_salonsunderFrenchise
  @Params	 : NULL
  @Description   : This function returns list of Salons for a Frenchise
  @Author        : Shibu Kumar
  @Date          : 17-Dec-2014
**********************************************************************************/

function salonsunderFrenchise(){
   $salonUfrenchise =  $this->User->find('list',array('fields'=>array('User.id'),'conditions'=>array('OR'=>array('User.id'=>$this->Auth->user('id'),'User.parent_id'=>$this->Auth->user('id')))));
  return $salonUfrenchise;
   
}

/**********************************************************************************    
  @Function Name : admin_list
  @Params	 : NULL
  @Description   : This function is for list users from All type
  @Author        : Aman Gupta
  @Date          : 19-Nov-2014
**********************************************************************************/

    public function admin_list(){
        $this->layout = "admin";
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Customer List'=>'javascript:void(0);'
                        );
        
        $cond['User.type'] = Configure::read('USER_ROLE');
        $cond['User.is_deleted'] = 0;
        $userType = $this->Auth->user('type');
        $parentID = $this->Auth->user('id');
        if($userType != Configure::read('SUPERADMIN_ROLE')){
            $cond = $this->mergingCond4UserType($cond);
        }
        $this->User->unbindModel(array('hasOne'=>array('Salon','Group')));
        $users = $this->User->find('all',array('fields'=>array('User.*','Contact.cell_phone','Contact.country_code','Address.country_id'),'conditions'=>$cond, 'order'=>array('User.created'=>'DESC')));
        $this->set(compact('users','breadcrumb','parentID'));
        $this->set('activeTMenu','customerList');
        $this->set('page_title','Customer List');
        
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/users";
            $this->render('list_customers');
        }
        
    }

/**********************************************************************************    
  @Function Name : admin_saloons
  @Params	 : NULL
  @Description   : Listing Saloons/Frenchises
  @Author        : Aman Gupta
  @Date          : 19-Nov-2014
**********************************************************************************/

    public function admin_salons() {
        $this->layout = "admin";
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Salons & Frenchises'=>array('controller'=>'Users','action'=>'salons','admin'=>true),
                        'List'=>'javascript:void(0);'
                        );
        $typeId = $this->Auth->user('type');
        $cond = array('User.type != '=>array(1,5,6));
        if($typeId == 3 ) //for Salon Frenchise Owner
        {
        }
        $this->User->unbindModel(array('hasOne'=>array('Salon')));
        $users = $this->User->find('all',array('fields'=>array('User.*','Group.*'),'conditions'=>$cond));
        $this->set(compact('users','breadcrumb'));
        
    }
    
/**********************************************************************************    
  @Function Name : admin_changeStatus
  @Params	 : NULL
  @Description   : User status Change via Ajax
  @Author        : Aman Gupta
  @Date          : 19-Nov-2014
**********************************************************************************/

    public function admin_changeStatus(){
        $this->autoRender = false;
        if($this->request->is('post')){
            if($this->User->updateAll(array('User.status'=>$this->request->data['status']),array('User.id'=>$this->request->data['id']))){
                echo  $this->request->data['status'];
            }
        }
        die;
    }

/**********************************************************************************    
  @Function Name : admin_view
  @Params	 : $userId = User id , $userName = Username
  @Description   : User View 
  @Author        : Aman Gupta
  @Date          : 19-Nov-2014
**********************************************************************************/

    public function admin_manage($userId = NULL,$page=NULL,$editAppointment=NULL){
        $this->layout = "admin";
        $user = array();
        $totalPoints = '0';
        $salonID = $this->Auth->user('id');
        if($userId && $userId!='null'){
            $userId = base64_decode($userId);
        }
        $this->loadModel('Appointment');
        $this->Appointment->unbindModel(array('belongsTo'=>array('User','SalonService')));
        
       $totalsimplebooking = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.package_id'=>0,'Appointment.deal_id IS NULL','Appointment.evoucher_id IS NULL')));
        
        $totalpackagebooking = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.package_id !='=>0,'Appointment.evoucher_id IS NULL'),'group'=>array('Appointment.package_id','Appointment.order_id')));
        
        $totaldealpackagebooking = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.deal_id IS NOT NULL','Appointment.package_id !='=>0,'Appointment.evoucher_id IS NULL'),'group'=>array('Appointment.deal_id','Appointment.package_id')));
        
        $totaldealevoucherbooking = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.deal_id IS NOT NULL','Appointment.package_id !='=>0,'Appointment.evoucher_id IS NOT NULL'),'group'=>array('Appointment.deal_id','Appointment.package_id','Appointment.evoucher_id')));
        
        $totalevoucherbooking = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.evoucher_id IS NOT NULL','Appointment.package_id'=>0),'group'=>array('Appointment.evoucher_id','Appointment.order_id')));
        
        $totalbooking= $totalsimplebooking+$totalpackagebooking+$totaldealpackagebooking+$totaldealevoucherbooking+$totalevoucherbooking;
        $this->set('totalbooking',$totalbooking); 
       
       $this->loadModel('OrderDetail');
       $totalamount = $this->OrderDetail->find('all' , array('conditions'=>array('OrderDetail.user_id'=>$userId),'fields'=>array('(sum(OrderDetail.price)) AS total')));
       $totalsinglebookingamount = $this->Appointment->find('all' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.package_id'=>0,'Appointment.deal_id IS NULL','Appointment.evoucher_id IS NULL'),'fields'=>array('(sum(Appointment.appointment_price)) AS totalamount')));
       $this->set('totalbookingamount',$totalamount[0][0]['total']+$totalsinglebookingamount[0][0]['totalamount']); 
        
        $totalappcancellation = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.status'=>5,'Appointment.package_id'=>0)));
        $totalpackagecancellation = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.status'=>5,'Appointment.package_id !='=>0),'group' => array('Appointment.package_id')));
        $totalcancellation=$totalappcancellation+$totalpackagecancellation;
        $totalnoShow = $this->Appointment->find('count' , array('conditions'=>array('Appointment.user_id'=>$userId,'Appointment.status'=>8)));
         $this->set(compact('totalcancellation','totalnoShow'));
         if(isset($this->params['named']['enc']) && !empty($this->params['named']['enc'])){
            $userId = base64_decode($this->params['named']['enc']);
            $userId  = base64_decode(current(explode('-CODE-',$userId)));
         }
        if($userId && $userId!='null'){
            $cond = array('User.id'=>$userId);
            $user = $this->User->find('first',array('conditions'=>$cond));
            if($editAppointment=='edit'){
                return $user;   
            }
            if(empty($user)){
                 if($this->request->is('ajax')){
                    $message = __('Unable to find User', true);
                    $vError = __('Unable to find User');
                    $edata['data'] = 'error' ;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
                else{
                    $this->Session->setFlash('Unable to find User OR you are not Authorize to view','flash_error');
                    $this->redirect(array('controller'=>'Users','action'=>'list','admin'=>true));
                }
            }else{
                $this->loadModel('UserCount');
                $totalPoints = $this->UserCount->find('all' , array('conditions'=>array('user_id'=>$user['User']['id'],'salon_id'=>array($salonID)),'fields'=>array('(sum(UserCount.user_count)) AS total')));                           
                $totalPoints = isset($totalPoints[0][0]['total'])?$totalPoints[0][0]['total']:0;
                $this->set('totalPoints',$totalPoints);
                if(!empty($user['User']['tmp_pwd'])){
                    $user['User']['tmp_pwd'] =  $this->Common->fnDecrypt($user['User']['tmp_pwd']);
                }
            }
        }
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Customer Management'=>'javascript:void(0);'
                    );
        $activeTMenu = 'customerManage';
        $page_title = 'Customer Management';
        
        $userList = $this->findallCustomerList();
        $this->set(compact('activeTMenu','page_title','breadcrumb','user','userList'));
        if(!empty($userId)){
            $this->admin_appointments($userId , $element =false);
        }
        
        if($this->request->is('ajax')){
            if($page!='NULL' && $page=='checkout'){
                $this->set('userId',$userId);
                $this->layout = 'ajax';
                $this->viewPath = "Elements/checkout";
                $this->render('appointment_customer_detail');
            }
            if($page!='NULL' && $page=='appointment'){
                $this->layout = 'ajax';
                $this->viewPath = "Elements/admin/Appointment";
                $this->render('appointment_customer_detail');
            } else if($page!='NULL' && $page=='SearchAppointment'){
                $this->layout = 'ajax';
                $this->viewPath = "Elements/admin/Appointment";
                $this->render('appointment_customer_search_detail');
            }else if($page!='NULL' && $page=='checkout'){
                $this->set('userId',$userId);
                $this->layout = 'ajax';
                $this->viewPath = "Elements/checkout";
                $this->render('appointment_customer_detail');
            }else{
            }
        }
    }

/**********************************************************************************    
  @Function Name : admin_verifyPhone
  @Params	 : NULL
  @Description   : verify user phone by Admins
  @Author        : Aman Gupta
  @Date          : 08-Dec-2014
***********************************************************************************/

    public function admin_verifyPhone() {
        $this->autoRender = false;
        if($this->request->is('post') || $this->request->is('put')){
            $userId = base64_decode($this->request->data['id']);
            $phToken = $this->User->find('first',array('fields'=>array('User.phone_token'),'conditions'=>array('User.id'=>$userId)));
            if($phToken['User']['phone_token'] ==  $this->request->data['token']){
                $this->User->updateAll(array('User.phone_token' =>NULL,'User.is_phone_verified' => 1 ),array('User.id'=>$userId));
                $edata['data'] = 'success' ;
                $edata['message'] = __('Phone Verified',true);
                $edata['id'] = base64_encode($userId);
                echo json_encode($edata);
                die;
            }
            else{
                $edata['data'] = 'error' ;
                $edata['message'] = __('Token mismatch',true);
                $edata['id'] = base64_encode($userId);
                echo json_encode($edata);
                die;
            }
        }
        die;
    }
    
/**********************************************************************************    
  @Function Name : admin_reset
  @Params	 : NULL
  @Description   : verify user phone by Admins
  @Author        : Aman Gupta
  @Date          : 08-Dec-2014
***********************************************************************************/

    public function admin_reset($userId = NULL) {
        $this->layout = 'ajax';
        
        if($this->request->is('post') || $this->request->is('put')){
            $this->User->id = $this->request->data['User']['id'];
            if(!empty($this->request->data['User']['password']))
                $this->request->data['User']['tmp_pwd'] = $this->Common->fnEncrypt($this->request->data['User']['password']);
            
            if($this->User->save($this->request->data)){
                $edata['data'] = 'success' ;
                $edata['message'] = __('User profile updated successfully',true);
                $edata['id'] = base64_encode($this->User->id);
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
        if($userId){
            $user = $this->User->find('first',array('conditions'=>array('User.id'=>base64_decode($userId))));
            if(!empty($user['User']['tmp_pwd'])){
                $user['User']['password'] = $this->Common->fnDecrypt($user['User']['tmp_pwd']);
            }
            else{
                $user['User']['password'] = '';
            }
        }
        if(!$this->request->data){
            $this->request->data = $user;
        }
        
    }
    
/**********************************************************************************    
  @Function Name : findallCustomerList
  @Params	 : NULL
  @Description   : Returns users customer list for dropdown type 6
  @Author        : Aman Gupta
  @Date          : 04-Dec-2014
***********************************************************************************/

    public function findallCustomerList(){
        App::import('Model','User');
        $this->Auth = $this->Components->load('Auth');
        $this->User = new User();
        $cond = array();
        $cond['User.type'] = Configure::read('USER_ROLE');
        $cond['User.is_deleted'] = 0;
        $userType = $this->Auth->user('type');
        if($userType != Configure::read('SUPERADMIN_ROLE')){
            $cond = $this->mergingCond4UserType($cond);
        }
        //$cond = $this->mergingCond4UserType($cond);
        $userLists = $this->User->find('all',array('fields'=>array('User.id','User.email','User.first_name','User.last_name'),'conditions'=>$cond,  'order' => array('User.first_name ASC')));
        $userData = array();
        if(!empty($userLists))
            foreach($userLists as $userList){
                $userData[base64_encode($userList['User']['id'])] = ucfirst($userList['User']['first_name']).' '.ucfirst($userList['User']['last_name'])." (".$userList['User']['email'].")";
            }
        return $userData;
    }

/**********************************************************************************    
  @Function Name : admin_upload_image
  @Params	 : NULL
  @Description   : The Function is for uploading user image via ajax 
  @Author        : Aman Gupta
  @Date          : 26-Nov-2014
***********************************************************************************/

    public function admin_upload_image($userId = NULL , $resize = NULL){
        $this->autoRender = false;
        $this->loadModel('TempImage');
        if($this->request->is('post') || $this->request->is('put')){
            if($_FILES){
                $model = "User";
                if($userId){
                    if($resize == '1'){
                        $retrun = $this->Image->upload_service_image($_FILES['image'], $model, $userId);
                    }else{
                        $retrun = $this->Image->upload_service_image($_FILES['image'],$model,$userId);
                    }
                    if($retrun){
                        $uImage = $this->User->find('first',array('fields'=>array('User.id','User.image'),'conditions'=>array('User.id'=>$userId)));
                        if(!empty($uImage)){
                            if(!empty($uImage['User']['image']))
                                $this->Image->delete_image($uImage['User']['image'],$model,$userId);
                                
                                $this->User->updateAll(array('User.image'=>'"'.$retrun.'"'),array('User.id'=>$userId));
                                echo $retrun;
                                die();
                        }
                    }else{
                        echo "f";
                    }
                }
                else{
                    echo "f";
                }
            }
            else{
                    echo "f";
            }
        }else{
            echo "f";
        }
        die();
    }
    
/**********************************************************************************    
  @Function Name : admin_delete_image
  @Params	 : NULL
  @Description   : The Function is for delete Image from User Via Ajax
  @Author        : Aman Gupta
  @Date          : 26-Nov-2014
***********************************************************************************/

    public function admin_delete_image(){
        if($this->request->is('post') || $this->request->is('put')){
            $model = "User";
            if($this->request->data['id'] > 0){
                $uImage = $this->User->find('first',array('fields'=>array('User.image'),'conditions'=>array('User.id'=>$this->request->data['id'])));
                if(!empty($uImage)){
                    if($this->User->updateAll(array('User.image'=>NULL),array('User.id'=>$this->request->data['id'])))
                        $this->Image->delete_image($uImage['User']['image'],$model,$this->request->data['id']);    
                }
                echo "s";
            }else{
                echo 'f';    
            }
        }
        die;
    }
    
 /**********************************************************************************    
  @Function Name : admin_resend_logindetails()
  @Params	 : NULL
  @Description   : The Function is for Sending Login details to Customer 
  @Author        : Shibu Kumar
  @Date          : 16-Dec-2014
***********************************************************************************/
   public function admin_resend_logindetails(){
        $this->layout = 'ajax';
        $this->autoRender = false;
        if($this->request->is('post')){                     
            $userID  = base64_decode($this->request->data('id'));
            $getData = $this->User->findById($userID);
            if($getData){
                if($this->request->data('type') == 'otp'){
                    $phone_token = strtoupper($this->Common->getRandPass(5));
                    $this->request->data['User']['id']  =  $userID;
                    $this->request->data['User']['phone_token'] = $phone_token;
                    $message = $phone_token;
                    if($this->User->save($this->request->data)){
                        $message = "Your one time (OTP) phone verification code is " . $phone_token . " Kindly verify your phone number!!";  
                        $number =  $getData['Contact']['cell_phone']; 
                        $country_id = $getData['Address']['country_id'];
                          if($country_id){
                           $country_code  =   $this->Common->getPhoneCode($country_id);
                              if($country_code){
                                 $number = str_replace("+","",$country_code).$number;    
                              }
                          }
                          $this->Common->sendVerificationCode($message,$number);   
                         //SMS Sending Code will be placed here
                         echo 'T';
                         exit;
                    }
                    
                }elseif($this->request->data('type') == 'loginDetail'){
                    // send Email Starts
                    $siteURL = Configure::read('BASE_URL');
                    $toEmail        =   $getData['User']['email'];
                    $fromEmail      =   Configure::read('fromEmail');
                    if(!empty($getData['User']['tmp_pwd'])){
                        $getData['User']['password'] =  $this->Common->fnDecrypt($getData['User']['tmp_pwd']);
                    }
                   
                    $dynamicVariables = array('{FirstName}'=>ucfirst($getData['User']['first_name']),'{LastName}'=>ucfirst($getData['User']['last_name']),'{email}'=>$getData['User']['email'],'{password}'=>$getData['User']['password']);
                    $this->Common->sendEmail($toEmail,$fromEmail,'login_credential',$dynamicVariables);
                    echo "L";
                    exit;
                    // send Email Ends
                }
                    
            }else{
                echo "F";
                exit;
            }
        }
   }
    
    public function initDB(){
        $this->User->bindModel(array('belongsTo'=>array('Group')));
        $group = $this->User->Group;
        $group->id = 1;
        $this->Acl->allow($group, 'controllers');
        echo "all done";
        exit;
    }
    
     /**********************************************************************************    
      @Function Name : admin_import
      @Params	 : NULL
      @Description   : import customers by csv file
      @Author        : Sanjeev kanungo
      @Date          : 2-dec-2014
    ***********************************************************************************/
     
    function admin_import(){
    $modelClass = $this->modelClass;
    $this->layout = 'admin';
    if ($this->request->is('POST')){
        $recordsCount = $this->$modelClass->find('count');
        $breadcrumb = array(
                            'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                            'Import Customers'=>array('controller'=>'Users','action'=>'import','admin'=>true),
                            );
        $this->set('breadcrumb',$breadcrumb);
        $users = $this->csv_to_array($this->request->data[$modelClass]['CsvFile']['tmp_name']);
        foreach($users as $key=>$val){
            if(is_array($val)){
                foreach($val as $k=>$v){
                    if($k =='address'){
                            $data['User']['Address'][$k] = $v;
                       }else if($k =='night_phone'){
                            $data['User']['Contact'][$k] = $v; 
                       }else if($k =='day_phone'){
                             $data['User']['Contact'][$k] = $v; 
                       }else if($k =='cell_phone'){
                              $data['User']['Contact'][$k] = $v; 
                       }else{
                              $data['User'][$k] = $v; 
                       }
                }
                 $data['User']['tmp']  = 1; 
                 $data['User']['created_by']  = $this->Auth->user('id');  
            }
                
        }
    }
        $this->set('page_title',' Import Customers');
        $this->set('activeTMenu','Customers'); 
        $this->set('modelClass', $modelClass);
    }
    
    /**********************************************************************************    
      @Function Name : csv_to_array
      @Params	 : filename
      @Description   : return csv content array
      @Author        : Sanjeev kanungo
      @Date          : 2-dec-2014
    ***********************************************************************************/
    
    function csv_to_array($filename=''){
      if(!file_exists($filename) || !is_readable($filename))
        return FALSE;
        $file = file_get_contents($filename);
        $data = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $file));
        pr($data);
    
        $file = fopen($filename,"r");
        $data   = array();
        $header = NULL;
        while(!feof($file))
        {
           if(!$header){
              $header = fgetcsv($file ,1024, ',');
            }else{
              $data[] = @array_combine($header ,fgetcsv($file ,1024, ','));
           }
        }
        fclose($file);
        //pr($data); die;
       return $data;
    }
   
   /**********************************************************************************    
      @Function Name : admin_sendFile
      @Params	 : filename
      @Description   :return sample csv to download
      @Author        : Sanjeev kanungo
      @Date          : 2-dec-2014
    ***********************************************************************************/
   
    public function admin_sendFile($filename) {
        $this->response->file('webroot/files/customers/'.$filename);
        return $this->response;
    }
    /**********************************************************************************    
      @Function Name : admin_businessProfile
      @Params	 : filename
      @Description   :Function to Save Business profile
      @Author        :Shibu Kumar
      @Date          : 4-dec-2014
    ***********************************************************************************/
   
    public function admin_businessProfile(){
        $this->layout ='admin';$this->loadModel('Salon');
        $userid = $this->Auth->user('id');
        $businessUrl = '';
        $states='';
        $phone_code = $cities='';
        $businessData = $this->User->find('first',array('fields'=>array('User.email','User.id','Salon.*','Address.*','Contact.*'),'conditions'=>array('User.id'=>$userid)));
        if($this->request->is('post') || $this->request->is('put')){
            if(!empty($this->request->data['Salon']['business_url'])){
                $this->request->data['Salon']['business_url'] = $this->Common->friendlyURL($this->request->data['Salon']['business_url']);
            }
            
            $userImage = array();
            if(!empty($this->request->data['Salon']['logo'])){
		if (isset($this->request->data['Salon']['logo']['error']) && $this->request->data['Salon']['logo']['error'] == 0) {
                    $userImage = $this->request->data['Salon']['logo'];
                }
	    }
            unset($this->request->data['Salon']['logo']);
            
            $coverImage = array();
            if(!empty($this->request->data['Salon']['cover_image'])){
		if (isset($this->request->data['Salon']['cover_image']['error']) && $this->request->data['Salon']['cover_image']['error'] == 0) {
                    $coverImage = $this->request->data['Salon']['cover_image'];
                }
	    }
            unset($this->request->data['Salon']['cover_image']);
            if($this->User->saveAll($this->request->data)){
		if(!empty($userImage)){
                    $model = "User";
                    $return = $this->Image->check_custom_image($userImage, $model, $this->Auth->user('id'), true,'logo');
                    
                    if($return === 'size'){
                        $this->Session->setFlash(__('Your image should be upto 100 KB.',true),'flash_error');
                        $this->redirect($this->referer());
                    }else if($return === 'ratio'){
                        $this->Session->setFlash(__('Your image should be in 2:1 ratio </br> You can send this image to Sieasta.We will help you compress it & return it to you.',true),'flash_error');
                        $this->redirect($this->referer());
                    }else if($return === 'limit'){
                        $this->Session->setFlash(__('Your image should be minimum of 400*200.',true),'flash_error');
                        $this->redirect($this->referer());
                    }
                        $this->Image->delete_image($businessData['Salon']['logo'], $model, $this->Auth->user('id'), true);
                        $this->Salon->updateAll(array('Salon.logo' => '"' . $return . '"'), array('Salon.user_id' => $this->Auth->user('id')));
                }
                if(!empty($coverImage)){
                    $model = "Salon";
                    $return = $this->Image->check_custom_image($coverImage, $model, $this->Auth->user('id'), true ,'salon_cover_image');
                    $status = 0;
                   // echo $return;exit;
                   if($return === 'size'){
                        $status = 1;
                        $this->Session->setFlash(__('Your image should be upto 350 KB.',true),'flash_error');
                        $this->redirect($this->referer());
                    }else if($return === 'ratio'){
                        $status = 1;
                        $this->Session->setFlash(__('Your image should be in 2:1 ratio </br> You can send this image to Sieasta.We will help you compress it & return it to you.',true),'flash_error');
                        $this->redirect($this->referer());
                    }else if($return === 'limit'){
                        $status = 1;
                        $this->Session->setFlash(__('Your image should be minimum of 1600*800.',true),'flash_error');
                        $this->redirect($this->referer());
                    }
                        $this->Image->delete_image($businessData['Salon']['cover_image'], $model, $this->Auth->user('id'), true);
                        $this->Salon->updateAll(array('Salon.cover_image' => '"' . $return . '"'), array('Salon.user_id' => $this->Auth->user('id')));
                }
                $this->Session->setFlash(__('Business profile has been saved successfully.',true),'flash_success');
                $this->redirect($this->referer());
	    }
	    else{
                if(!empty($this->request->data['Address']['country_id'])){
                    $businessData['Address']['country_id'] = $this->request->data['Address']['country_id'];
                }
                if(!empty($this->request->data['Address']['state_id'])){
                    $businessData['Address']['state_id'] = $this->request->data['Address']['state_id'];
                }
                if(!empty($this->request->data['Salon']['business_url'])){
                    $businessUrl= $this->request->data['Salon']['business_url'];
                }
                
                $this->request->data['Salon']['logo'] = $businessData['Salon']['logo'];
              $this->Session->setFlash(__('Some error occurred.',true),'flash_error');	
	    }
	    
	}
        
         if(!empty($businessData['Address']['country_id'])){
		    $this->loadModel('State');
		    $states = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$businessData['Address']['country_id'],'State.status'=>1)));
                    $phone_code = $this->Common->getPhoneCode($businessData['Address']['country_id']); 
         }
	
        if(!empty($businessData['Address']['state_id'])){
		$this->loadModel('City');
		$cities = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$businessData['Address']['state_id'],'City.status'=>1)));
	}
        
        if(!$this->request->data){
	    
            $this->request->data = $businessData;
            $businessUrl = $businessData['Salon']['business_url'];
        }
        $breadcrumb = array(
                            'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                            'Business Profile'=>array('controller'=>'Users','action'=>'businessProfile','admin'=>true),
                            );
        $activeTMenu = 'bsnsProfile';
	$page_title = 'Business Profile';
        $this->set('leftMenu',true);
        $countryData =  $this->Common->getCountries();
	$this->set(compact('countryData','breadcrumb','activeTMenu','page_title','states','cities','businessUrl','phone_code'));
	$this->set('title_for_layout', 'User business profile');
    }
    
    public function profile(){

    }
        
    public function admin_deleteUser(){
          $this->autoRender = false;
	  if($this->request->is('Ajax')){
	     $id = trim(base64_decode($this->request->data['id']));
             $salon_type = trim($this->request->data['salon_type']);
             if($salon_type=='frenchise'){
               //$this->User->
                    $this->User->recursive = -1;
                    $salons = $this->User->find('all',array(
                     'conditions' => array('User.parent_id' => $id ,'User.is_deleted' =>'0'), //array of conditions
                     'fields' => array('User.id'))
                    );
                    if(count($salons)){
                         foreach($salons as $salon){
                            $this->changeToCustomer($salon['User']['id']);
                            $this->del_staff($salon['User']['id']);
                         }
                    }
                     $this->User->id = $id;
                    if($this->User->saveField('is_deleted',1)){
                         echo '1';
                         exit;
                    }else{
                         echo 'Some error occured.';
                         exit;
                    }
             }else if($salon_type=='ind'){
                $this->del_staff($id);
                $this->User->id = $id;
                if($this->User->saveField('is_deleted',1)){
                     echo '1';
                     exit;
                }else{
                     echo 'Some error occured.';
                     exit;
                }
             }else{
                $this->User->id = $id;
                if($this->User->saveField('is_deleted',1)){
                     echo '1';
                     exit;
                }else{
                     echo 'Some error occured.';
                     exit;
                }
             }
         }
	die;   
    }
    
    function del_staff($salon_id){
      $this->User->recursive = -1;
        $staffs = $this->User->find('all' , array('conditions'=>array('User.created_by'=>$salon_id,'User.is_deleted'=>0),'fields'=>array('User.id')));
        if(count($staffs)){
         foreach($staffs as $staff){
           $this->changeToCustomer($staff['User']['id']);
          }
         }
       return true;  
    }
    
    function changeToCustomer($user_id){
          $user['User']['group_id'] = 6;
          $user['User']['parent_id'] = 0;
          $user['User']['type'] = 6;
          $user['User']['created_by'] = 0;
          $this->User->id = $user_id;
          $this->User->save($user , false);
          return true;
    }
    
    public function admin_vendorDeleteCustomer(){
          $this->autoRender = false;
	  if($this->request->is('Ajax')){
	     $id = trim($this->request->data['id']);
             $salon_id = trim($this->request->data['salon_id']);
             //$this->loadModel("SalonService");
             $count  = $this->Common->check_iou($salon_id,$id);
             if($count==0){
                     $fields  = array('id','created_by','type');
                     $this->User->recursive = -1;
                     $this->loadModel('UserToSalon');
                     $customer = $this->User->find('first', array('conditions'=>array('id'=>$id),'fields'=>$fields));
                     if($salon_id != "1"){
                          if($customer['User']['created_by'] == $salon_id){
                          $this->User->id = $customer['User']['id'];
                          $this->User->SaveField('created_by',0);
                          echo "1";
                          exit;
                        }else{
                         if($this->UserToSalon->deleteAll(array('UserToSalon.salon_id' => $salon_id,'UserToSalon.user_id' => $id), false)){
                            echo "1";
                            exit;
                         }else{
                            echo 'Some error occured.';
                         }
                       }
                    }else{
                         if($customer['User']['type']==6){
                          $this->User->id = $customer['User']['id'];
                            if($this->User->saveField('is_deleted', 1)){
                             $this->UserToSalon->deleteAll(array('UserToSalon.user_id' => $customer['User']['id']), false);
                             echo "1";
                             exit;
                            }else{
                              echo 'Some error occured.';  
                            }
                         }else{
                             echo 'Some error occured.';  
                         }
                   }
             }else{ 
                echo $count;
                exit;
             }
        }
	die;   
    }
    
    
    function AccountManagement(){
        $this->loadModel('UserDetail');
        $this->loadModel('Contact');
        $this->loadModel('Address');
        $UserDetail = $this->User->findById($this->Auth->user('id'));
        if($this->request->is(array('put','post'))){
           $this->User->set($this->request->data);
           $this->UserDetail->set($this->request->data);
           $this->Contact->set($this->request->data);
           $this->Address->set($this->request->data);
           
           if($this->User->saveAll($this->request->data)){
               if($UserDetail['User']['email'] != $this->request->data['User']['email']){
                   $this->sendEmailCode(base64_encode(base64_encode($UserDetail['User']['id'])), $email_token = null, $calledFrom ='controller',NULL,$tempate='resend_verification_code');
                }
                if($UserDetail['Contact']['cell_phone'] != $this->request->data['Contact']['cell_phone']){
                        $this->User->recursive =1;
                        $getData = $this->User->findById($UserDetail['User']['id']);
                        $phone_token = strtoupper($this->Common->getRandPass(5));
                        $this->User->updateAll(array('User.phone_token' => "'" . $phone_token . "'",'User.is_phone_verified'=>0), array(
                            'User.id' =>$UserDetail['User']['id'],
                        ));
                        if($getData){
                                $message = "Your one time (OTP) phone verification code is " .$phone_token. " Kindly verify your phone number!!";  
                                $number =  $getData['Contact']['cell_phone'];
                                $country_id = $getData['Address']['country_id'];
                                if($country_id){
                                 $country_code  =   $this->Common->getPhoneCode($country_id);
                                    if($country_code){
                                       $number = str_replace("+","",$country_code).$number;    
                                    }
                                }
                                $this->Common->sendVerificationCode($message,$number);
                        }   
                }
                $this->Session->setFlash(__('Details Successfully Saved!!!',true),'flash_success'); 
                if($this->request->data['User']['old_pass'] && $this->request->data['User']['password1'] && $this->request->data['User']['con_password']){
                    $old_password = AuthComponent::password($this->request->data['User']['old_pass']);
                    if($old_password === $UserDetail['User']['password']){
                        $this->User->id = $UserDetail['User']['id'];
                        $user['User']['password']  = $this->request->data['User']['password1'];
                        $user['User']['tmp_pwd']  = $this->Common->fnEncrypt($user['User']['password']);
                        if($this->User->save($user ,array('validates'=>array('fieldList' => array('password'))))){
                           $this->Session->setFlash(__('Details Successfully Saved',true),'flash_success'); 
                        }else{
                          $this->Session->setFlash(__('Some Error Occured in password fields!!!',true),'flash_error');
                        }
                    }else{
                        $this->Session->setFlash(__('Old Password is not correct!!',true),'flash_error');
                        
                    }
                }
                $this->redirect(array('action'=>'AccountManagement'));
            }else{
                 $this->Session->setFlash(__('Some Error Occured!!',true),'flash_error'); 
            }
        }
        if(!$this->request->data && isset($UserDetail)){
            $this->request->data = $UserDetail;
        }
        //pr($UserDetail);
        //exit;   
        $countryData =  $this->Common->getCountries();
        $phoneCode =  $cityList = $stateList ='';
        if($UserDetail['Address']['country_id']){
               $this->loadModel('State');
               $stateList = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$UserDetail['Address']['country_id'],'State.status'=>1)));
               $phoneCode = $this->Common->getPhoneCode($UserDetail['Address']['country_id']);
               }
       if($UserDetail['Address']['state_id']){
               $this->loadModel('City');
               $cityList = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$UserDetail['Address']['state_id'],'City.status'=>1)));
       }
       $this->set(compact('UserDetail','countryData','stateList','cityList','phoneCode'));
    }
    
     public function upload_image($userId = NULL){
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
    
    public function admin_upload_staff_image($userId = NULL){
        $this->autoRender = false;
        $this->loadModel('User');
        $this->loadModel('TempImage');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($_FILES) {
                $model = "User";
                if ($userId) {
                    $retrun = $this->Image->upload_service_image($_FILES['image'], $model, $userId);
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
    
    function deleteImage(){
      $this->autoRender = false;
      $this->loadModel('User');
        if (($this->request->data['id'])) {
            $model = 'User';
            $uid = $this->request->data['id'];
            $this->User->recursive = -1;
            $User =$this->User->findById($uid);
            $this->Image->delete_image($User['User']['image'], $model, $uid);
            $image = '';
            $this->User->id = $uid;
            $data['User']['image'] = $image;
            if($this->User->save($data)){
                echo $this->request->data['id'];
            }else{
               echo 'f'; 
            }
        }
        die;  
    }
    
    function varify_email(){
        if($this->request->is(array('put','post'))){
            $id = $this->Auth->user('id');
            $this->User->recursive   = -1;
            $userDetail = $this->User->findById($id);
            if(empty($userDetail['User']['is_email_verified']) && !empty($userDetail['User']['email_token'])){
                if($this->request->data['email_code']==$userDetail['User']['email_token']){
                    $data['User']['is_email_verified'] = 1;
                    $data['User']['email_token'] = '';
                    $this->User->id = $userDetail['User']['id'];
                    if ($this->User->save($data)){
                        echo 'd';
                        die;  
                    }
                }
               die;
            }
            die;
        }  
        $this->User->recursive = -1;
        $this->set('userDetail',$this->User->findById($this->Auth->user('id')));
     }
     
     /* please don not change response of this function . It use with many views */
    function varify_phone($id = NULL){
        if($this->request->is(array('put','post'))){
            $this->User->recursive   = -1;
            $userDetail = $this->User->findById($this->request->data['id']);
                //pr($this->request->data);die;
                if($this->request->data['phone_token']==$userDetail['User']['phone_token']){
                    $data['User']['is_phone_verified'] = 1;
                    $data['User']['phone_token'] = '';
                    $this->User->id = $userDetail['User']['id'];
                    if ($this->User->save($data)){
                        echo 's';
                        die;  
                    }
                }
               die;
        }
        $this->set('userId',$id);
    }
    
    function removeImage(){
        $this->loadMOdel("Salon");
        $data['Salon']['id'] = $this->request->data['id'];
        $data['Salon'][$this->request->data['type']] ='';
        $this->Salon->save($data);
        echo "success";
        exit;
    }
    

    /**********************************************************************************    
      @Function Name : sendWelcomeEmail
      @Params	 : NULL
      @Description   : The Function is used for Sending welcome Email
      @Author        : Navish
      @Date          : 13-May-2015
     ********************************************************************************** */

    function sendWelcomeEmail($userId=null,$salonId=null,$tempate='customer_welcome_user') {
        $this->autoRender = false;
        $this->loadModel('Salon');
        $this->loadModel('User');
        $salonData = $this->Salon->find('first', array('fields' => array('Salon.eng_name'), 'conditions' => array('Salon.user_id' => $salonId)));
        if ($userId != null && $salonId != null) {
            $userData = $this->User->findById($userId);
            if(!empty($userData) && !empty($salonData)){
                $salonName = $salonData['Salon']['eng_name'];
                $toEmail =   $userData['User']['email'];
                $fromEmail  =   Configure::read('fromEmail');
                $dynamicVariables = array('{FirstName}'=>ucfirst($userData['User']['first_name']),'{LastName}'=>ucfirst($userData['User']['last_name']), '{SN}' => ucfirst($salonName));
                $this->Common->sendEmail($toEmail,$fromEmail,$tempate,$dynamicVariables);
            }
        }
    }
    
     function googleAuth(){
        $google_user = $this->request->data['User'];
        $this->loadModel('User');
        $this->loadModel('UserDetail');
        $this->autoRender = false;
        $email_status = false;
        if (is_array($google_user) and count($google_user)){
                       //print_r($google_user); die;
                        $email = $google_user['email'] = $google_user['po'];           
                        $google_user['id'] = $google_user['wc']; 
                        $google_user['given_name'] = $google_user['Ph'];
                        $google_user['family_name'] = $google_user['hg'];
                        $google_user['picture'] = $google_user['Ei'];
                        $existingUser = $this->User->find('first', array('conditions' => array('User.google_id' => $google_user['id'])));
                        if (isset($existingUser['User']) and ($existingUser['User'])) {
                             if($existingUser['User']['status']!=1){
                                $this->Session->setFlash(__('Your account is inactivated, please contact to administrator for help.'), 'flash_error');
                                $this->redirect(array('controller'=>'homes','admin'=>false));
                               }else{
                                    $this->Auth->login($existingUser['User']);
                               }
                        } else {
                            //check if gmail already exists then save gmail data to same record
                            if (isset($google_user['email']) and !empty($email)){
                                    $userExistByEmail = $this->User->find('first', array('conditions' => array('User.email' => $email)));
                            }
                             if($userExistByEmail['User']['status']!=1){
                                    $this->Session->setFlash(__('Your account is inactivated, please contact to administrator for help.'), 'flash_error');
                                    //$this->redirect(array('controller'=>'homes','admin'=>false));
                                    exit;
                             }
                            if (isset($userExistByEmail['User']['id']) and !empty($userExistByEmail['User']['id'])) {
                                    /*********update info ***********/
                                    $UserData['User']['first_name'] = $google_user['given_name'];
                                    $UserData['User']['last_name'] = $google_user['family_name'];
                                    $UserData['User']['google_id'] = $google_user['id'];
                                    $this->User->id = $userExistByEmail['User']['id'];
                                    $this->User->save($UserData , false);
                                    $userRecord=$this->User->findById($userExistByEmail['User']['id']);
                                    $this->Auth->login($userRecord['User']);
                                    echo 'success';
                             }else{///user not found in database so insert new user record
                                $UserData['User']['google_id'] = $google_user['id'];
                                $UserData['User']['status'] = 1; 
                                if (empty($email)){
                                        $email = "";
                                }
                                $UserData['User']['type'] = 6;
                                $UserData['User']['group_id'] = 6;
                                $UserData['User']['first_name'] = $google_user['given_name'];
                                $UserData['User']['last_name'] = $google_user['family_name'];
                                $UserData['User']['email'] = $email;
                                $UserData['User']['username'] = $email;
                                $UserData['User']['is_email_verified'] = 1;
                                $UserData['User']['image'] = $google_user['picture'];
                                $hashCode = strtoupper($this->Common->getRandPass(8));
                                $UserData['User']['password'] = $hashCode;
                                $this->User->save($UserData, array('validate' => false));
                                $lastInserId = $this->User->getLastInsertId();
                                $userdetail['UserDetail']['user_id'] = $lastInserId;
                                if(isset($google_user['gender'])){
                                        $userdetail['UserDetail']['gender'] = $google_user['gender'];
                                }
                                $this->UserDetail->create();
                                $this->UserDetail->save($userdetail);
                                $User = $this->User->find('first', array('conditions' => array('User.id' => $lastInserId)));
                                $userId = $User['User']['id'];
                                $this->User->id = $lastInserId;
                                $siteURL = Configure::read('BASE_URL');
                                $userId_encode = base64_encode(base64_encode($userId));
                                $template = 'welcome_user_google';
                                $toEmail =   $User['User']['email'];
                                $fromEmail  =  Configure::read('fromEmail');
                                $dynamicVariables = array('{FirstName}'=>ucfirst($User['User']['first_name']),'{LastName}'=>ucfirst($User['User']['last_name']),'{Email}'=>$User['User']['email'],'{Password}'=>$hashCode,'{Link}'=>$siteURL);
                                $this->Common->sendEmail($User['User']['email'],$fromEmail,$template,$dynamicVariables);
                                $this->Auth->login($User['User']);
                                echo 'success';
                            } 
                     }  
         }else{
             echo "failed";
             die;    
        }      
    }
    
    /**********************************************************************************    
        @Function Name : spabreaks
        @Params	 : id
        @Description   : Listing of spabreaks
        @Author        : Sonam Mittal
        @Date          : 15-Jul-2015
      ***********************************************************************************/    
    public function spabreaks($is_past = null){
        $this->loadModel('Order');
        $this->loadModel('Evoucher');
        $userId = $this->Auth->user('id');
	$this->Order->unbindModel(array('belongsTo'=>array('Appointment','SalonService')));
        $number_records = 10;
        $class = '';
        
        $current_date =date('Y-m-d');
	//echo $is_past;
        /**** Past appointments ******/
        if(!empty($is_past)){
            $conditions = array("not" => array("Order.id" => null),'Order.user_id'=>$userId, 'Order.service_type' => 4,'Order.start_date < ' => $current_date);
            $class="past";
        }else{
            $conditions = array("not" => array("Order.id" => null),'Order.user_id'=>$userId, 'Order.service_type' => 4,'Order.start_date > ' => $current_date);
            $class="now";
        }
	$this->Paginator->settings = array(
            'Order' => array(
                    'fields' => array('SalonSpabreakImage.*','Order.*'),
                    'limit' => $number_records,
                    'conditions' => $conditions,
                    'joins'=>array(
                        
                        array(
                            'table'=>'salon_spabreak_images',
                            'type'=>'left',
                            'alias'=>'SalonSpabreakImage',
                            'conditions'=>array('Order.salon_service_id = SalonSpabreakImage.spabreak_id')
                        )
                    ),
                    'order' => array('created' => 'desc')
            )
	); 
        $orders = $this->Paginator->paginate('Order');
        //pr($orders); exit;
	$this->set(compact('orders','class'));
        $this->viewPath = "Myaccount";
        $this->render('spabreaks');
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'myaccount';
        }        
    }

  
    /**********************************************************************************    
    @Function Name : cancel
    @Params	 : NULL
    @Description   : cancel appointments for spa break in users account profile
    @Author        : Sonam Mittal
    @Date          : 20-July-2015
  ***********************************************************************************/


    public function cancel(){
	$this->autoRender =false;
	$this->layout = 'myaccount';
	$this->loadModel("Appointment");
	$this->loadModel("Order");
	$this->loadModel("User");
	$this->loadModel("UserPoint");
	$this->loadModel("UserCount");
	$this->loadModel("PointSetting");
	$user_id = $this->Auth->user("id");
	$first_name = $this->Auth->user("first_name");
	$last_name = $this->Auth->user("last_name");
	$email = $this->Auth->user("email");
        
	if($this->request->data){
	   $order_id =  $this->request->data['order_id'];
	   $type =  $this->request->data['type'];
           
	   $this->Order->unbindModel(array('belongsTo'=>array('SalonService')));
	   $appointment = $this->Order->find("first",array('fields'=>array('Order.*'),'conditions'=>array('Order.id'=>$order_id)));
           $cancelPossibility =$this->check_cancellation($appointment['Order']['salon_id'],$appointment['Order']['start_date']);

	   if($cancelPossibility['msg']=='true'){
		    $salon_id = $appointment['Order']['salon_id'];
		    $salon_org_id = $appointment['Order']['salon_id'];
			    $this->Order->updateAll(
				array('Order.spabreak_status' =>1), 
				array('Order.id' => $order_id)
			    );
			     
			    $serviceOwner = $this->User->findById($appointment['Order']['salon_id']);
			    $salon_email =  $serviceOwner['User']['email'];
			    $salon_first_name =  $serviceOwner['User']['first_name'].' '.$serviceOwner['User']['last_name'];
			    if($type == 'spabreak'){
				if($serviceOwner['User']['parent_id'] !=0){
				$frechiseDetail = $this->User->findById($serviceOwner['User']['parent_id']);
				    if(count($frechiseDetail)){
					 if($frechiseDetail['User']['type']==2){
						$salon_id =  $frechiseDetail['User']['id'];
					  } 
				     }
				}
			    }
			    
			if($appointment['Order']['transaction_status'] == 1){ // Payment through Gateway
			   if($type == 'spabreak'){
				    $salon_points_to_be_deducted = $appointment['Order']['points_given'];
				    $admin_points_to_be_deducted = 0;
				    $sieastaPoints = $this->UserPoint->find('first',array('fields'=>array('point_given','points_deducted'),'conditions'=>array('UserPoint.order_id'=>$order_id,'UserPoint.salon_id'=>1)));
				    if($sieastaPoints){
					$admin_points_to_be_deducted = $sieastaPoints['UserPoint']['point_given'];
				    }
			    
			   }
			    $amount_to_be_credited = $appointment['Order']['orignal_amount'];
			    
			    
			    
			}else if($appointment['Order']['transaction_status'] == 5){ // Payment through Points
			     if($type == 'spabreak'){
				    $salon_points_to_be_deducted = $appointment['Order']['points_given'];
				    $admin_points_to_be_deducted = 0;
				    $sieastaPoints = $this->UserPoint->find('first',array('fields'=>array('point_given','points_deducted'),'conditions'=>array('UserPoint.order_id'=>$order_id,'UserPoint.salon_id'=>1)));
				    if($sieastaPoints){
					$admin_points_to_be_deducted = $sieastaPoints['UserPoint']['point_given'];
				    }
				$points_to_be_credited = $appointment['Order']['points_used'];
				$pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
			     }
			    
			     $amount_to_be_credited = $appointment['Order']['orignal_amount'];
	////		    
			}else if($appointment['Order']['transaction_status'] == 6 || $appointment['Order']['transaction_status'] == 7 ){ // Payment through Gifts and Payment through Gifts + Gateway
			     if($type == 'spabreak'){
				    $salon_points_to_be_deducted = $appointment['Order']['points_given'];
				    $admin_points_to_be_deducted = 0;
				    $sieastaPoints = $this->UserPoint->find('first',array('fields'=>array('point_given','points_deducted'),'conditions'=>array('UserPoint.order_id'=>$order_id,'UserPoint.salon_id'=>1)));
				    if($sieastaPoints){
					$admin_points_to_be_deducted = $sieastaPoints['UserPoint']['point_given'];
				    }
			     }
			    $amount_to_be_credited = $appointment['Order']['orignal_amount'];
			    
			}else if($appointment['Order']['transaction_status'] == 8){ // Payment through Points + Gateway
			     if($type == 'spabreak'){
				    $salon_points_to_be_deducted = $appointment['Order']['points_given'];
				    $admin_points_to_be_deducted = 0;
				    $sieastaPoints = $this->UserPoint->find('first',array('fields'=>array('point_given','points_deducted'),'conditions'=>array('UserPoint.order_id'=>$order_id,'UserPoint.salon_id'=>1)));
				    if($sieastaPoints){
					$admin_points_to_be_deducted = $sieastaPoints['UserPoint']['point_given'];
				    }
				$points_to_be_credited = $appointment['Order']['points_used'];
				$pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
			     }
			    
			    	$amount_to_be_credited = $appointment['Order']['orignal_amount'];
			}else{
			    
				$cancelPossibility['msg'] = 'Can\'t cancel this appointment';
				echo json_encode($cancelPossibility);
				exit;
			}
		    /**************Send gift certificates***********/
		        $status_message = 'Gift Certificate issued against cancellation.';
			$this->loadModel("Order");
			$order['Order']['transaction_status'] = 1;
			$order['Order']['service_type'] = 6;
			$order['Order']['user_id'] = $user_id;
			$order['Order']['orignal_amount'] = $amount_to_be_credited;
			$order['Order']['transaction_message'] = $status_message;
			$order['Order']['salon_id'] = $salon_id;
			$order['Order']['from_cancelled'] = 1;
			$this->Order->create();
			if($this->Order->save($order)){
			    $this->loadModel('GiftCertificate');
			    $this->loadModel('GiftImage');
			    $gift_certificate['GiftCertificate']['order_id'] =  $this->Order->getLastInsertId();
			    $gift_certificate['GiftCertificate']['salon_id'] = $salon_id;
			    $gift_certificate['GiftCertificate']['sender_id'] = $salon_id;
			    $gift_certificate['GiftCertificate']['user_id'] = $salon_id;
			    $gift_certificate['GiftCertificate']['recipient_id'] = $user_id;
			    $gift_certificate['GiftCertificate']['amount'] = $amount_to_be_credited;
			    $gift_certificate['GiftCertificate']['email'] = $email;
			    $gift_certificate['GiftCertificate']['first_name'] = $first_name;
			    $gift_certificate['GiftCertificate']['last_name'] = $last_name;
			    $gift_certificate['GiftCertificate']['from_cancelled'] = 1;
			    $gift_certificate['GiftCertificate']['messagetxt'] = "Hi , You can use this Gift certificate for any service taken";
			    $gift_certificate['GiftCertificate']['send_email_status'] = 1;
			    $gift_certificate['GiftCertificate']['gift_image_category_id'] = 1;
			    $gift_certificate['GiftCertificate']['gift_image_id'] = 1;
			    $gift_certificate['GiftCertificate']['type'] = 1;
			    $gift_certificate['GiftCertificate']['expire_on'] = $this->Common->vocher_expiry($salon_id);
			    $gift_certificate['GiftCertificate']['payment_status'] = 1;
			    $gift_certificate['GiftCertificate']['gift_certificate_no'] = strtoupper($this->Common->getRandPass(8));   
			    if($this->GiftCertificate->save($gift_certificate , false)){
				
				$gift_certificate['GiftCertificate']['id'] =  $this->GiftCertificate->getLastInsertId();
				
				   $image = $this->GiftImage->find('first',array('fields'=>array('image'),'conditions'=>array('GiftImage.id'=>1)));
				    $gift_certificate['GiftImage']= $image['GiftImage'];
				    $extension = substr($gift_certificate['GiftImage']['image'], strrpos($gift_certificate['GiftImage']['image'], '.') + 1);
				    $file_name = $gift_certificate['GiftCertificate']['id'].'_'.$gift_certificate['GiftCertificate']['gift_image_id'].'.'.$extension;
				    $this->GiftCertificate->id = $gift_certificate['GiftCertificate']['id'];
				    $this->GiftCertificate->saveField('image',$file_name);
				    $this->Common->get_gift_certificate_image($gift_certificate);
				    $to = $email;//$giftCertificate['GiftCertificate']['email'];
				    $from = $salon_email;
				    $message = $gift_certificate['GiftCertificate']['messagetxt'];
				    $path = WWW_ROOT . 'images/GiftImage/original/';
				    $image = $gift_certificate['GiftImage']['image'];
				   
				    
				    //$this->PHPMailer->sendmail($to, $from, $salon_first_name, 'test', $message, $file_name);
				    if($type == 'spabreak'){
					if($salon_points_to_be_deducted){
						   $variable['salon_id'] = $salon_id; 
						   $variable['user_id'] = $user_id;
						   $variable['points_deducted'] = $salon_points_to_be_deducted;
						   $variable['type'] = 1;
						   $variable['appointment_id'] = $appointment_id;
						   $this->points_deduction($variable);
					   }
					   if($admin_points_to_be_deducted){
						   $variable['salon_id'] = 1; 
						   $variable['user_id'] = $user_id;
						   $variable['points_deducted'] = $admin_points_to_be_deducted;
						   $variable['type'] = 1;
						   $variable['appointment_id'] = $appointment_id;
						   $this->points_deduction($variable);
						   
					   }
				    }
				    $this->Common->sendEmailAttach($to, $from,'Gift certificate for cancellation',$message,$path, $file_name);
				      
			      }
			 
			}else{
			    $cancelPossibility['msg'] = 'not_allowed';
			    echo json_encode($cancelPossibility);
			    exit;
			}
			
		/***********************End*********************/
		echo json_encode($cancelPossibility);
		exit;
	   }else{
		echo json_encode($cancelPossibility);
		exit;
	   }
	}
    }
    
    
     /**********************************************************************************    
    @Function Name : check_cancellation
    @Params	 :  salon_id  appointmetStartDate
    @Description   : cancellation of  appointments for spa break in users account profile
    @Author        : Sonam Mittal
    @Date          : 20-July-2015
  ***********************************************************************************/
     
    public function check_cancellation($salon_id, $appointmetStartDate){
	$this->loadModel("SalonOnlineBookingRule");
	$data = array();
	$SalonSetting = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>$salon_id)));
	if(!$SalonSetting){
	   $SalonSetting =  $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>1)));
	}
	if($SalonSetting['SalonOnlineBookingRule']['allow_cancel'] == 0){
	    $data['cancel_time'] = $SalonSetting['SalonOnlineBookingRule']['cancel_time'];
	    $data['msg'] = 'not_allowed';
	    return $data;
	}else if($SalonSetting['SalonOnlineBookingRule']['allow_cancel'] == 1){
	    $current_date  = time();
            $appointmetStartDate = strtotime($appointmetStartDate);
	    if($appointmetStartDate > $current_date){
		$appointmentTimeLeft = (($appointmetStartDate - $current_date)/60)/60;
		if($appointmentTimeLeft > $SalonSetting['SalonOnlineBookingRule']['cancel_time']){
		    $data['cancel_time'] = $SalonSetting['SalonOnlineBookingRule']['cancel_time'];
		    $data['msg'] = 'true';
		    return $data;
		}else{
		    $data['cancel_time'] = $SalonSetting['SalonOnlineBookingRule']['cancel_time'];
		    $data['msg'] = 'less_time';
		    return $data;
		}
		
	    }else{
		$data['cancel_time'] = $SalonSetting['SalonOnlineBookingRule']['cancel_time'];
		$data['msg'] = 'date_passed';
		return $data;
	    }
	}
   }
   
   
    /**********************************************************************************    
    @Function Name : reschedule
    @Params	 : NULL
    @Description   : reschedule appointments for spa break in users account profile
    @Author        : Sonam Mittal
    @Date          : 20-July-2015
  ***********************************************************************************/
    public function reschedule(){
        $this->autoRender =false;
	$this->layout = 'myaccount';
	$this->loadModel("Order");
        $this->loadModel("OrderDetail");
	$this->loadModel("User");
	$this->loadModel("SalonService");
	if($this->request->data){
            $appointmentData = array();
            if(isset($this->request->data['Appointment'])){
                $this->Order->bindModel(array('hasMany'=>array('OrderDetail')));
                $appointment_detail = array();
                $appointmentData['Order']['id'] = $this->request->data['Order']['id'];
                $appointmentData['Order']['start_date'] = date('Y-m-d h:m:s',strtotime($this->request->data['Appointment']['breakDateSelected']));
                $appointmentData['Order']['duration'] = date('Y-m-d',strtotime($this->request->data['Appointment']['breakDateSelected'])).'~'.date('Y-m-d h:m:s',strtotime($this->request->data['Appointment']['breakDateEnd']));
                $appointmentData['OrderDetail']['id'] = $this->request->data['OrderDetail']['id'];
                $appointmentData['OrderDetail']['option_duration'] = date('Y-m-d',strtotime($this->request->data['Appointment']['breakDateSelected'])).'~'.date('Y-m-d h:m:s',strtotime($this->request->data['Appointment']['breakDateEnd']));
                $appointmentData['OrderDetail']['start_date'] = date('Y-m-d',strtotime($this->request->data['Appointment']['breakDateSelected']));

                if($this->Order->save($appointmentData,false)){
                    $this->OrderDetail->save($appointmentData,false);
                    $this->Session->delete('APPOINTMENT.RESCHEDULE');
                    $this->sendAppointmentMail($this->request->data['Order']['id'],$appointmentData,'rAppointment');
                    $this->Session->setFlash('Your appointment has been rescheduled successfully.', 'flash_success');
                    $this->redirect(array('controller'=>'users','action'=>'spabreaks'));
                }else{
                        $this->Session->setFlash('Some error occurred!!!.', 'flash_error');
                        $this->redirect(array('controller'=>'users','action'=>'spabreaks'));
                }
            }else{
                $order_id =  $this->request->data['order_id'];
                $this->Order->unbindModel(array('belongsTo'=>array('SalonService')));
                $appointment = $this->Order->find("first",array('fields'=>array('Order.salon_id','Order.start_date'),'conditions'=>array('Order.id'=>$order_id)));
                $reschedulePossibility =$this->check_reschedule_criteria($appointment['Order']['salon_id'],$appointment['Order']['start_date']);

                if($reschedulePossibility['msg'] == 'true'){
                     $this->Session->write('APPOINTMENT.RESCHEDULE',true);
                     echo json_encode($reschedulePossibility);
                     exit;
                }else{
                     echo json_encode($reschedulePossibility);
                     exit;
                }

            }
        }
     
   }
   
   /**********************************************************************************    
    @Function Name : check_reschedule_criteria
    @Params	 :  salon_id  appointmetStartDate
    @Description   : check reschedule criteria for spa break in users account profile
    @Author        : Sonam Mittal
    @Date          : 21-July-2015
  ***********************************************************************************/
   
   public function check_reschedule_criteria($salon_id, $appointmetStartDate){
	$this->loadModel("SalonOnlineBookingRule");
	$data = array();
	$SalonSetting = $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>$salon_id)));
	if(!$SalonSetting){
	   $SalonSetting =  $this->SalonOnlineBookingRule->find('first',array('conditions'=>array('SalonOnlineBookingRule.user_id'=>1)));
	}
	if($SalonSetting['SalonOnlineBookingRule']['allow_reschedule'] == 0){
	    $data['reschedule_time'] = $SalonSetting['SalonOnlineBookingRule']['reschedule_time'];
	    $data['msg'] = 'not_allowed';
	    return $data;
	}else if($SalonSetting['SalonOnlineBookingRule']['allow_reschedule'] == 1){
	    $current_date  = time();
            $appointmetStartDate = strtotime($appointmetStartDate);
	    if($appointmetStartDate > $current_date){
		$appointmentTimeLeft = (($appointmetStartDate - $current_date)/60)/60;
		if($appointmentTimeLeft > $SalonSetting['SalonOnlineBookingRule']['reschedule_time']){
		    $data['reschedule_time'] = $SalonSetting['SalonOnlineBookingRule']['reschedule_time'];
		    $data['msg'] = 'true';
		    return $data;
		}else{
		    $data['reschedule_time'] = $SalonSetting['SalonOnlineBookingRule']['reschedule_time'];
		    $data['msg'] = 'less_time';
		    return $data;
		}
	    }else{
		$data['reschedule_time'] = $SalonSetting['SalonOnlineBookingRule']['reschedule_time'];
		$data['msg'] = 'date_passed';
		return $data;
	    }
	}
   }
   
   
    /**********************************************************************************    
    @Function Name : sendAppointmentMail
    @Params	 :  $appointmentID, $appointment_detail,, $type
    @Description   : send mail in case of spabreak reschedule
    @Author        : Sonam Mittal
    @Date          : 23-July-2015
  ***********************************************************************************/
    public function sendAppointmentMail($appointmentID = null,$appointment_detail =null, $type = null){
        $this->loadModel('User');
        $this->loadModel('Order');
        $this->loadModel('Salon');
        $appointmentData =   $this->Order->find('first',array('fields'=>array('Order.salon_id','Order.duration','Order.id','Order.salon_service_id'),'conditions'=>(array("Order.id"=>$appointmentID))));
        $appointment_detail['duration'] = $appointmentData['Order']['duration'];
        $appointment_detail['id'] = $appointmentData['Order']['id'];
        $serviceStaff = array();
        $salonID = $appointmentData['Order']['salon_id'];
        //$salonService_name = $appointmentData['OrderDetail'][0]['eng_service_name'];
        $date = '';
        if(!empty($appointmentData['OrderDetail'][0]['option_duration'])){
            $duration = $appointmentData['OrderDetail'][0]['option_duration'];
            $spaDuration = explode('~',$duration);
            if(isset($spaDuration[0])){
                $date .= date('d M Y',strtotime($spaDuration[0]));
                $date .= " to ";
            }
            if(isset($spaDuration[1])){
                $date .= date('d M Y',strtotime($spaDuration[1]));                                                            
            }
        }
        
        $salonName = '';
        // getting saloon details
        if(!empty($salonID)){
            $salonService_name = $this->User->find('first' , array('conditions'=>array('User.id'=>$salonID)));
            if(!empty($salonService_name)){
                $salonName = $salonService_name['Salon']['eng_name'];
            }
        }
        
        if($type == 'eAppointment'){
            $template = 'new_appointment';
            $confirmtemplate = 'confirmation_appointment';
            $message = "New Appointment for the Service $salonName has been scheduled on date : $date";
        }else{
            $template = 'reschedule_appointment';
            $confirmtemplate = 'reschedule_confirmation';
            $message = "Appointment for the Service $salonName has been rescheduled on date : $date";
        }
        
        
        // Send email to Booking Incharge
        $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'UserDetail.booking_incharge'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$salonID,'User.id'=>$salonID))));
        foreach($SalonBookingIncharges as $incharge){

            $this->sendUserEmail($incharge, $salonService_name,$appointment_detail,$template,'vendor');
            $this->sendUserPhone($incharge, $salonService_name,$appointment_detail,$message);

        }
        $userDetail = $this->User->find('first' , array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
        
        $this->sendUserEmail($userDetail, $salonService_name,$appointment_detail,$confirmtemplate);
        $this->sendUserPhone($userDetail, $salonService_name,$appointment_detail,$message);

    }
    
     /**********************************************************************************    
    @Function Name : sendUserEmail
    @Params	 :  $userData, $serviceDetail,$appointment_detail,$template,$type
    @Description   : send mail in case of spabreak reschedule to user
    @Author        : Sonam Mittal
    @Date          : 23-July-2015
  ***********************************************************************************/
    function sendUserEmail($userData=array() , $serviceDetail = array(),$appointment_detail=array(), $template='', $type=NULL){
       // pr($serviceDetail);
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $service_name = $serviceDetail['Salon']['eng_name'];
        $date = $appointment_detail['Order']['start_date'];
        //$time = $appointment_detail['selected_time'];
	$duration = $appointment_detail['Order']['duration'];
	$id = $appointment_detail['Order']['id'];
        $dynamicVariables = array('{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{time}'=> '',
                                  '{start_date}'=>$date,
                                  '{service_name}'=>$service_name,
                                  '{appointment_id}'=>$id,
				  '{duration}'=>$duration,
				  '{id}'=>$id
                                  );
	 if($template =='confirmation_appointment'){
	    //$employee_id   =   $appointment_detail['staff_id'];
	    //$employee_name =   $this->Common->employeeName($employee_id);
	    $salonDetail   =   $this->Common->salonDetail($serviceDetail['SalonService']['salon_id']); 
	    //$dynamicVariables['{service_provider}'] = $employee_name['User']['first_name'].' '.$employee_name['User']['last_name'];
	    $dynamicVariables['{Salon}'] = $salonDetail['Salon']['eng_name'];
	    $dynamicVariables['{salon_contact_number}'] = $salonDetail['Contact']['country_code'].' '.$salonDetail['Contact']['cell_phone'];
	    /**************Points varibale is set as duration****************/
	    $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($duration);
	 }  
	$template_type =  $this->Common->EmailTemplateType($serviceDetail['Salon']['id']);
        if($template_type){
          $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
        }
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
    
     /**********************************************************************************    
    @Function Name : sendUserPhone
    @Params	 :  $getData, $serviceName,$appointment_detail,$message,$type
    @Description   : send user notifcation on phone in case of spabreak reschedule
    @Author        : Sonam Mittal
    @Date          : 23-July-2015
  ***********************************************************************************/
    function sendUserPhone($getData=array(), $serviceName = array(), $appointment_detail=array(),$message = null, $type=null){
            $this->loadModel('User');
	    $firstName = $getData['User']['first_name'];
            $lastName = $getData['User']['last_name'];
            $date = $appointment_detail['Order']['start_date'];
            //$time = $appointment_detail['selected_time']; 
           
            if($getData){
                  $number =  @$getData['Contact']['cell_phone'];
                    $country_id = @$getData['Address']['country_id'];
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
    
    
    /**********************************************************************************    
    @Function Name : request_booking
    @Params	 :  $orderID, $evoucherID
    @Description   : Request Booking for evoucher
    @Author        : Sonam Mittal
    @Date          : 6-August-2015
  ***********************************************************************************/
    public function request_booking($orderID=null,$evoucherID=null){
        $this->layout='ajax'; 
        $this->loadModel('Order');
        $this->loadModel('Evoucher');
        $this->loadModel('User');
        $this->loadModel('Appointment');
        $this->loadModel('SpabreakAppointment');
        $this->Order->unbindModel(array('belongsTo'=>array('Appointment','SalonService')));
	$this->Order->bindModel(array('hasMany'=>array('Evoucher'),'hasOne'=>array('GiftCertificate')));
        
        $fieldsArray = array('User.id','User.first_name','User.last_name');
              
        $data = $serviceDetails = $staffList =  array();
        $order = $this->Order->find('first',array(
            'conditions'=>array(
                'Order.id' => $orderID,
            )
        ));
        
        //listing of staff as per salon order id
        if(!empty($order)){
            $staffList = $this->User->find('all',array('fields'=>$fieldsArray,
                'recursive'=>-1,
                'conditions'=>array('User.created_by'=>$order['Order']['salon_id'],'User.is_deleted'=>0,'User.type'=>5),
                'group'=>array('User.id'),
                'order' => array('User.created DESC')
            ));
        }
        
        $evouchers = $this->Evoucher->find('first',array(
            'conditions'=>array(
                'Evoucher.order_id' => $orderID,
                'Evoucher.used' => 0
            )
        ));
        $this->set(compact('order','evouchers','staffList'));
        
        if ($this->request->is(array('post')) && !empty($this->request->data)) {
            
            if($evouchers['Evoucher']['evoucher_type']!= 5 && $evouchers['Evoucher']['evoucher_type']!= 1  ){
                $dateTimestamp = date('d-m-Y',strtotime($this->request->data['Appointment']['start_date']));
                if(isset($order['OrderDetail']) && !empty($order['OrderDetail'])){
                    $o = 0;
                    foreach($order['OrderDetail'] as $ord){
                        $name = $this->Common->employeeName($ord['user_id']);
                        $dateSend = date('y-m-d',strtotime($this->request->data['Appointment']['start_date'])).date(' h:i:s',strtotime($this->request->data['Appointment']['time']));
                        $actualTime  = strtotime($dateSend);
                        $data[$o]['appointment_title'] = @$name['User']['first_name'].' '.@$name['User']['last_name'].'-'.$ord['eng_service_name'];
                        $data[$o]['salon_id'] = $ord['salon_id'];
                        
                        $data[$o]['salon_staff_id'] = $this->request->data['Appointment']['salon_staff_id'];
                        $data[$o]['user_id'] = $ord['user_id'];
                        $data[$o]['package_id'] = $ord['package_service_id'];
                        $data[$o]['deal_id'] = $ord['service_id'];
                        $data[$o]['salon_service_id'] = $ord['service_id'];
                        $data[$o]['order_id'] = $ord['order_id'];
                        $data[$o]['evoucher_id'] = $evouchers['Evoucher']['id'];
                        $data[$o]['status'] = 0;
                        $data[$o]['payment_status'] = 2;
                        $data[$o]['type'] = 'V';
                        $data[$o]['appointment_price'] = $ord['option_price'];
                        $data[$o]['appointment_duration'] = $ord['option_duration'];
                        $data[$o]['appointment_start_date'] = $actualTime;
                        $data[$o]['discount_value'] = $ord['option_price']-$ord['price'];
                        $data[$o]['price_after_discount'] = $ord['price'];
                        $data[$o]['discount_type'] = '1';                        
                        $o++;                        
                    }
                       
                }
                
                //pr($data);
                if(!empty($data)){
                    if($this->Appointment->saveAll($data)){
                        $this->Evoucher->id = $evouchers['Evoucher']['id'];
                        $this->Evoucher->saveField('used',1);                          
                    }
                }
                //pr($staff);
            }else{
                $name = $this->Common->employeeName($order['Order']['user_id']);
                $dateSend = date('y-m-d',strtotime($this->request->data['Appointment']['start_date'])).date(' h:i:s',strtotime($this->request->data['Appointment']['time']));
                $actualTime  = strtotime($dateSend);
                $data[0]['appointment_title'] = @$name['User']['first_name'].' '.@$name['User']['last_name'].'-'.$order['Order']['eng_service_name'];
                $data[0]['salon_id'] = $order['Order']['salon_id'];

                $data[0]['salon_staff_id'] = $this->request->data['Appointment']['salon_staff_id'];
                $data[0]['user_id'] = $order['Order']['user_id'];                
                $data[0]['salon_service_id'] = $order['Order']['salon_service_id'];
                $data[0]['order_id'] = $order['Order']['display_order_id'];
                $data[0]['evoucher_id'] = $evouchers['Evoucher']['id'];
                $data[0]['status'] = 0;
                $data[0]['payment_status'] = 2;
                $data[0]['type'] = 'V';
                $data[0]['appointment_price'] = $order['Order']['sell_price'];
                $data[0]['appointment_duration'] = $order['Order']['duration'];
                $data[0]['appointment_start_date'] = $actualTime;
                $data[0]['discount_value'] = $order['Order']['full_price']-$order['Order']['sell_price'];
                $data[0]['price_after_discount'] = $order['Order']['sell_price'];
                $data[0]['discount_type'] = '1'; 
                if($evouchers['Evoucher']['evoucher_type']==1){
                    if(!empty($data)){
                        if($this->Appointment->saveAll($data)){
                            $this->Evoucher->id = $evouchers['Evoucher']['id'];
                            $this->Evoucher->saveField('used',1);                              
                        }
                    }
                }
                if($evouchers['Evoucher']['evoucher_type']==5){
                    if(!empty($data)){
                        if($this->SpabreakAppointment->saveAll($data)){
                            $this->Evoucher->id = $evouchers['Evoucher']['id'];
                            $this->Evoucher->saveField('used',1);                              
                        }
                    }
                }
            }   
            //pr($data);
            $package_salon_id = $order['Order']['user_id'];  
            $SalonBookingIncharges = $this->User->find('all' , array(
                'conditions'=>array(
                    'User.status'=>1,'User.type'=>array(4,5),
                    'or'=>array('User.created_by'=>$package_salon_id,'User.id'=>$package_salon_id)
                )
            )); 
            $package_name = $order['Order']['eng_service_name'];
            $order_id = $order['Order']['display_order_id'];
            $amount = $order['Order']['amount'];
            $serviceDetails['evoucher_type']= $evouchers['Evoucher']['evoucher_type'];
            $serviceDetails['evoucher_id']= $evouchers['Evoucher']['id'];
            $serviceDetails['order_id']=$order['Order']['id'];
            $serviceDetails['service_id']=$order['Order']['salon_service_id'];
            $serviceDetails['name']=$order['Order']['eng_service_name'];
            $serviceDetails['date']= $this->request->data['Appointment']['start_date'];
            $serviceDetails['time']= $this->request->data['Appointment']['time'];
            $serviceDetails['salon_name']= $this->Common->get_salonName($order['Order']['salon_id']);  

            $package_type = '';
            switch($serviceDetails['evoucher_type']){ 
                case 1:
                    $package_type = 'Service';
                    break;
                case 2:
                    $package_type = 'Package';
                    break;
                case 3:
                    $package_type = 'SpaDay';
                    break;
                case 4:
                    $package_type = 'Deal';
                    break;
                case 5:
                    $package_type = 'Spabreak';
                    break;
            }
            $serviceDetails['package_type']= $package_type; 
            // send mail to booking incharge
            if(!empty($SalonBookingIncharges)){
                foreach($SalonBookingIncharges as $incharge){
                    if($incharge['UserDetail']['booking_incharge']==1){
                        $message = " A new    $package_name Evoucher  has been sold."; 
                        $this->sendUserPackageEmailRequest($incharge, $serviceDetails,$data ,$order_id ,$amount ,'evoucher_booking_confirmation','vendor');
                        $this->sendUserPhoneRequest($incharge, $serviceDetails,$message ,$order_id ,$amount ,'vendor');

                    } 
                } 
                $this->redirect(array('controller'=>'Myaccount','action'=>'orders'));
            }
               
        }
        
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Myaccount";
            $this->render('request_booking');
        }else{
            $this->viewPath = "Myaccount";
            $this->render('request_booking');
        }
   } 
    
    function sendUserPackageEmailRequest($userData=array() , $serviceDetails = array(),$data =array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL){
        //pr($userData);
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;

        $service_name = $serviceDetails['name'];
        $serviceID = $serviceDetails['service_id'];
        $service_names[] =  $serviceDetails['name'];
        $date  =   $serviceDetails['date'];       
        $time = $serviceDetails['time'];
        $duration[] = '';
	$salonName =  $serviceDetails['salon_name'];  

        $i = 0; 
        $serviceData  = '';
        $titleService = '' ;
      
	$quanityAmount = 1;
        if(!empty($data)){
            foreach($data as $dat){
                $title = $dat['appointment_title'];
                $finalTitle = explode('-',$title);
                if(isset($finalTitle[1])){
                    $titleService = $finalTitle[1];
                }else{
                    $titleService = $title;
                }
                $serviceData  .= 'Service Name :' .$titleService.'</br> Date :'.$date.' </br>  Time :'.$serviceDetails['time'].'</br></br>';
            }
        }
        $dynamicVariables = array(
                                  '{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{amount}' => $amount,
                                  '{package_name}'=> $service_name,
                                  '{order_id}'=>$order_id,
                                  '{service}'=> $serviceData,
                                  '{package_date}'=>$serviceDetails['date'],
				  '{package_time}'=>$serviceDetails['time'],
                                  '{package}'=>$serviceDetails['package_type'],
				  '{quantity}'=>$quanityAmount,
				  '{salon_contact_number}'=> $userData['Contact']['cell_phone'],
				  '{Salon}'=> $salonName
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
    
       
    function sendUserPhoneRequest($getData=array(), $serviceDetail = array(), $message = '', $order_id=null ,$amount = null , $type=null , $duration=null){
            $this->loadModel('User');
            $firstName = $getData['User']['first_name'];
            $lastName = $getData['User']['last_name'];
            $date = $serviceDetail['date'];
            $order_id = $order_id;
            if($getData){
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
    
    function admin_appointments($customer_id = null , $element=true){
        if(!empty($customer_id)){
            $this->loadModel('Order');
            $this->loadModel('Appointment');
            $this->Order->unbindModel(array('belongsTo' => array('Appointment')));
            $this->Appointment->bindModel(array('belongsTo' => array('Order','Deal')));
            
            $userType = $this->Auth->user('type');
            $userId = $this->Auth->user('id');
            $parentId = $this->Auth->user('parent_id');
            $current_date = time();
            $fields = array(
                            'Appointment.id',
                            'Appointment.order_id',
                            'Appointment.by_vendor',
                            'Appointment.salon_id',
                            'Appointment.package_id',
                            'Appointment.deal_id',
                            'Appointment.status',
                            'Appointment.salon_service_id',
                            'Appointment.appointment_duration',
                            'Appointment.appointment_price',
                            'Appointment.evoucher_id',
                            'Order.points_given',
                            'Order.points_used',
                            'SUM(Appointment.appointment_duration) as Appointment__Duration',
                            'SUM(Appointment.appointment_price) as Appointment__Price',
                            'Appointment.appointment_start_date',
                            'Order.id',
                            'Order.appointment_id',
                            'Order.service_price_with_tax',
                            'Order.duration',
                            'Order.amount',
                            'Order.orignal_amount',
                            'Order.salon_service_id',
                            'Order.display_order_id',
                            'Order.salon_id',
                            'Order.eng_service_name',
                            'Order.ara_service_name',
                            'Deal.id',
                            'Deal.type',
                            'Deal.avail_time',
                            'Deal.max_time',
                            'Deal.blackout_dates',
                            'Deal.limit_per_customer'
                            
                            /*'SalonService.*'*/);
            
            $class='';
            $this->Appointment->virtualFields['Duration'] = 0;
            $this->Appointment->virtualFields['Price'] = 0;
           
             if($userType == 4){
                $conditions = array(
                            "not" => array(
                                "Appointment.order_id" => null
                            ),
                            'Appointment.user_id' => $customer_id,
                            'Appointment.salon_id' => $userId,
                            'Appointment.type'=>array('A','S','D','PAC')
                        );
            } else if($userType == 1){
                $conditions = array(
                            "not" => array(
                                "Appointment.order_id" => null
                            ),
                            'Appointment.user_id' => $customer_id,
                            'Appointment.type'=>array('A','S','D','PAC')
                        );
            } else{
                $conditions = array(
                        "not" => array(
                            "Appointment.order_id" => null
                        ),
                        'Appointment.salon_id' => $parentId,
                        'Appointment.type'=>array('A','S','D','PAC'),
                        'Appointment.user_id' => $customer_id,
                );
            }
           
            if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	    
	}
	if(!empty($src_keywrd)){
	   $conditions['OR']= array(
                                    'Order.eng_service_name LIKE "%'.$src_keywrd.'%"',
				    'Order.ara_service_name LIKE "%'.$src_keywrd.'%"'
				);
	}
        
        
           $number_records = 10;
	if(!empty($this->request->data['number_records']) || !empty($this->request->named['number_records'])){
	    if(!empty($this->request->data['number_records'])) {
		$number_records = $this->request->data['number_records'];
	    }
	    if(!empty($this->request->named['number_records'])){
		$number_records = $this->request->named['number_records'];
	    }
	    $this->request->data['number_records'] = $number_records;
	}
            /**** Past appointments ******/ 
            $this->Paginator->settings = array(
                    'Appointment' => array(
                        'limit' => $number_records,
                        'conditions' => $conditions,
                        'fields' => $fields,
                        'order' => array('created' => 'desc'),
                        'group' => array('Appointment.order_id,
                                    Appointment.evoucher_id ')
                    )
                );
            $orders = $this->Paginator->paginate('Appointment');
            
            
            
            $this->set(compact('orders','customer_id'));
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
                if($element){
                    $this->viewPath = "Elements/admin/users";
                    $this->render('list_appointments');
                }
            }
        } else {
            
        }
    }
    
    
    
    public function admin_giftcertificates($customer_id = null){
         $this->loadModel('GiftCertificate');
        /****** Get list of evouchers of the user ****/
        $userId = $customer_id;
        $salonID = $this->Auth->user('id');
        /****** Get list of gifts of the user ****/
        $current_date = date('Y-m-d');
        $fields = array('GiftCertificate.id','GiftCertificate.expire_on','GiftCertificate.image','GiftCertificate.amount','GiftCertificate.gift_certificate_no','GiftCertificate.is_used','GiftCertificate.total_amount');
        $order = 'GiftCertificate.id desc';
        /************** Set page limit ************/
	$number_records = 10;
        $userType = $this->Auth->user('type');
        if($userType == 1){
            $conditions = array('GiftCertificate.recipient_id'=>$userId, 'GiftCertificate.type'=>1,'GiftCertificate.is_deleted'=>0);
        }else{
            $conditions = array('GiftCertificate.recipient_id'=>$userId, 'GiftCertificate.type'=>1,'GiftCertificate.is_deleted'=>0,'GiftCertificate.salon_id'=>$salonID);
        }
        
        $order = 'GiftCertificate.id desc';
       
        $this->Paginator->settings = array(
                    'GiftCertificate' => array(
                        'limit' => $number_records,
                        'conditions' => $conditions,
                        'fields' => $fields,
                        'order' => $order
                    )
	    );
        $gifts = $this->Paginator->paginate('GiftCertificate');
      //  pr($gifts);exit;
        $this->set(compact('gifts','customer_id'));
        /****** Get list of evouchers of the user ****/
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/users";
            $this->render('gifts');  
    }
    
     
    public function admin_iou_details($customer_id = null) {
         $this->loadModel('Iou');
        /****** Get list of evouchers of the user ****/
        $userId = $customer_id;
        //$userEmail = $this->Auth->user('email');
        /****** Get list of gifts of the user ****/
        $current_date = date('Y-m-d');
        $fields = array('Iou.id','Iou.order_id','Iou.user_id','Iou.iou_comment','Iou.total_iou_price','Iou.status','Iou.created','Order.*');
        $order = 'Iou.id desc';
        /************** Set page limit ************/
	$number_records = 10;
        $salonID = $this->Auth->user('id');
        $userType = $this->Auth->user('type');
        if($userType == 1){
             $conditions = array('Iou.user_id'=>$userId);
        }else{
             $conditions = array('Iou.user_id'=>$userId,'Order.salon_id'=>$salonID);
        }
                
       
        $this->Paginator->settings = array(
		'Iou' => array(
		    'limit' => $number_records,
		    'conditions' => $conditions,
                    'joins'=>array(               
                        array(
                            'table'=>'orders',
                            'type'=>'inner',
                            'alias'=>'Order',
                            'conditions'=>array('Order.id = Iou.order_id')
                        ),
                    ),
                    'fields' => $fields,
		    'order' => $order
		)
	    );
        $ious = $this->Paginator->paginate('Iou');
        $this->set(compact('ious','customer_id'));
        /****** Get list of evouchers of the user ****/
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/users";
            $this->render('list_iou');  
     }
     
     
     
     function admin_spabreaks($customer_id = null){
        $this->loadModel('Order');
        $this->loadModel('Evoucher');
        $userId = $customer_id;
        $this->Order->unbindModel(array('belongsTo'=>array('Appointment','SalonService')));
	$number_records = 10;
        $conditions = array("not" => array("Order.id" => null),'Order.user_id'=>$userId, 'Order.service_type' => 4);
        $this->Paginator->settings = array(
            'Order' => array(
                'fields' => array('SalonSpabreakImage.*','Order.*'),
                'limit' => $number_records,
                'conditions' => $conditions,
                'joins'=>array(
                    
                    array(
                        'table'=>'salon_spabreak_images',
                        'type'=>'left',
                        'alias'=>'SalonSpabreakImage',
                        'conditions'=>array('Order.salon_service_id = SalonSpabreakImage.spabreak_id')
                    )
                ),
                'order' => array('created' => 'desc')
            )
        ); 
		
        $orders = $this->Paginator->paginate('Order');
        $this->set(compact('orders','customer_id'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/users";
            $this->render('list_spabreaks');
          
        }
        else {
        
        }
    }
}