    <?php
    class CommonComponent extends Component {
        public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
        public $components = array('Session', 'Email', 'Cookie','Auth'); //An array containing the names of components this controller uses.
        public $Pass = '123456';
        public $return_str;
    
    /*
     * @author        Shibu Kumar
     * @method        getRandPass
     * @param         Function to generate the random password
     * @return        void 
     * 
     */
    
        public function getRandPass($len = 8){
            // Array Declaration
            $pass = array();
            // Variable declaration
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < $len; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }
    
    /*
     * @author        Shibu Kumar
     * @method        getCountries 
     * @param         Function to get List of Countries
     * @return        void 
     * 
     */
    
        public function getCountries() {
            App::import('Model', 'Country');
            $this->Country = new Country();
            $countryData = $this->Country->find('list', array('fields' => array('Country.id', 'Country.name'), 'conditions' => array('Country.status' => 1,'Country.is_deleted' => 0)));
            return $countryData;
        }
        
        public function getCountryStates(){
            App::import('Model', 'Country');
            $this->Country = new Country();
            $countryData = $this->Country->find('all', array(
                    'fields' => array('Country.id','Country.title', 'Country.name'),
                    'conditions' => array('Country.status' => 1,'Country.is_deleted' => 0)));
            return $countryData;
        }
        /*
         * @author        Niharika Sachdeva
         * @method        getBusinessTypes 
         * @param         Function to get List of Business Types
         * @return        void 
         * 
        */
    
        public function getBusinessTypes() {
            $data = array();
            $SessionLang = $this->Session->read('Config.language');
            //Added by navdeep
            if($SessionLang == ""){
                $SessionLang = 'eng';
            }
            App::import('Model', 'BusinessType');
            $this->BusinessType = new BusinessType();
            if($SessionLang == 'eng'){
                $data = $this->BusinessType->find('list', array('fields' => array('BusinessType.id', 'BusinessType.eng_name'), 'conditions' => array('BusinessType.status' => 1,'BusinessType.is_deleted' => 0)));
            }elseif($SessionLang == 'ara'){
                $data = $this->BusinessType->find('list', array('fields' => array('BusinessType.id', 'BusinessType.ara_name'), 'conditions' => array('BusinessType.status' => 1,'BusinessType.is_deleted' => 0)));
            }
            return $data;
        }
    
    /*
     * @author        Shibu Kumar
     * @method        getCountries 
     * @param         Function to get List of Countries
     * @return        void 
     * 
     */
    
        function friendlyURL($inputString) {
            $url = strtolower($inputString);
            $patterns = $replacements = array();
            $patterns[0] = '/(&amp;|&)/i';
            $replacements[0] = '-and-';
            $patterns[1] = '/[^a-zA-Z01-9]/i';
            $replacements[1] = '-';
            $patterns[2] = '/(-+)/i';
            $replacements[2] = '-';
            $patterns[3] = '/(-$|^-)/i';
            $replacements[3] = '';
            $url = preg_replace($patterns, $replacements, $url);
            return $url;
        }
    
    /*     * ********************************************************************************    
      @Function Name : getFrenchiseList
      @Params	 : NULL
      @Description   : Returns frenchises list
      @Author        : Aman Gupta
      @Date          : 04-Dec-2014
     * ********************************************************************************* */

        public function getFrenchiseList(){
            App::import('Model', 'User');
            $this->User = new User();
            $franchiseList = $this->User->find('all', array('fields' => array('User.id', 'Salon.eng_name'), 'conditions' => array('User.type' => 2, 'User.status' => 1, 'User.parent_id' => 0, 'User.is_deleted' => 0),'order'=>'Salon.eng_name ASC'));
            $frenchList = array();
            if (!empty($franchiseList))
                foreach ($franchiseList as $franchises) {
                    $frenchList[$franchises['User']['id']] = $franchises['Salon']['eng_name'];
                }
               return $frenchList;
        }
    
        /*     * ********************************************************************************    
          @Function Name : fnEncrypt
          @Params	 : $sValue => value
          @Description   : For Encryption
          @Author        : Aman Gupta
          @Date          : 08-Dec-2014
         * ********************************************************************************* */
    
        function fnEncrypt($sValue) {
            return base64_encode(base64_encode($sValue) . Configure::read('Security.salt'));
        }
    
        /**********************************************************************************    
          @Function Name : fnDecrypt
          @Params	 : $sValue => value
          @Description   : For Decryption
          @Author        : Aman Gupta
          @Date          : 08-Dec-2014
        ********************************************************************************** */
    
        function fnDecrypt($sValue) {
            return base64_decode(current(explode(Configure::read('Security.salt'), base64_decode($sValue))));
        }
    
        
        function sendPhoneCode($userId = null) {
            App::import('Model', 'User');
            $this->User = new User();
            if ($this->request->is('ajax')) {
                $this->layout = 'ajax';
                $this->autoRender = false;
                $userId = $this->request->data['id'];
                //$phone_token = strtoupper($this->Common->getRandPass(8));
                $phone_token = "XSD23DEH";
                $this->User->updateAll(array('User.phone_token' => "'" . $phone_token . "'"), array(
                    'User.id' => $userId,
                ));
            }
            //Send SMS Code will come here
            return true;
        }
        
        
    
        function get_salon_service_name($id=NULL){
            App::import("Model", "SalonService");
            $model = new SalonService();
            $salonService = $model->find('first', array('conditions' => array('SalonService.id' =>$id)));
            if(count($salonService)){
                if(empty($salonService['SalonService']['eng_name'])){
                    return $this->get_service_name($salonService['SalonService']['service_id']);
                }else{
                    return $salonService['SalonService']['eng_name'];       
                }
                
            }else{
            return;  
            }
        }
        
         function get_service_name($id=NULL){
            App::import("Model", "Service");
            $model = new Service();
            $Service = $model->find('first', array('conditions' => array('Service.id' =>$id)));
            if(count($Service)){
             return $Service['Service']['eng_name'];   
            }else{
            return;  
            }
        }
        /*
         * This function is used to send email with template  
         * @author        Shibu Kumar
         * @method        sendEmail
         * @param         $to, $subject, $messages, $from, $reply,$path,$file_name
         * @return        void 
         */
    
        
        function sendEmailUser($email_token = null,$userData = array(), $typ = 'email_verify'){
            $SITE_URL = Configure::read('BASE_URL');
            $toEmail = $userData['User']['email'];
            $fromEmail = Configure::read('noreplyEmail');
            $firstName = $userData['User']['first_name'];
            $lastName = $userData['User']['last_name'];
            $password=$this->fnDecrypt($userData['User']['tmp_pwd']);
            $userId = base64_encode($userData['User']['id']);
            //$verifyLink = '<a href = "' . $SITE_URL . '/business/verify_email/' . $userId . '/' . $email_token . '">Link </a>';
            $verifyLink = $SITE_URL . '/business/verify_email/' . $userId . '/' . $email_token;
            $dynamicVariables = array('{FirstName}' => $firstName, '{LastName}' => $lastName, '{Code}' => $email_token,'{Username}'=>$toEmail,'{Password}'=>$password, '{Link}' => $verifyLink);
            $this->sendEmail($toEmail, $fromEmail,$typ,$dynamicVariables);
            return true;  
        }
       
        public function sendEmail($to = null, $from = null, $templateID = null, $dynamicFields = null, $reply = null, $path = null, $file_name = null) {
            App::import('Model', 'Emailtemplate');
            $this->Emailtemplate = new Emailtemplate();
            $template = $this->Emailtemplate->find('first', array('conditions' => array('Emailtemplate.template_code' => $templateID)));
            if(isset($dynamicFields['{template_type}']) && $dynamicFields['{template_type}']==1){
                $messages = (!empty($template['Emailtemplate']['text_template']))?$template['Emailtemplate']['text_template']:$template['Emailtemplate']['template'];   
            }else{
                $messages = $template['Emailtemplate']['template'];
            }
            $subject = $template['Emailtemplate']['name'];
            foreach ($dynamicFields as $key => $value) {
                $messages = str_replace($key, $value, $messages);
                $subject = str_replace($key, $value, $subject); 
            }
            $this->Email->smtpOptions = array(
                'host' => Configure::read('host'),
                'username' => Configure::read('username'),
                'password' => Configure::read('password'),
                'timeout' => Configure::read('timeout')
            );
    
            $this->Email->delivery = 'mail'; //possible values smtp or mail 
            $admin_name = Configure::read('ADMIN_NAME');
            if (empty($reply)) {
                $reply = $admin_name . '<' . Configure::read('replytoEmail') . '>';
            }
            if (empty($from)) {
                $from = $admin_name . '<' . Configure::read('fromEmail') . '>';
            }
            $this->Email->from = $from;
            $this->Email->replyTo = $reply;
            if ($to == 'admin') {
                $this->Email->to = $from;
            } else {
                $this->Email->to = $to;
            }
            if (!empty($path) && !empty($file_name))
                $this->Email->attachments = array($file_name, $path . $file_name);
    
            if (empty($subject)) {
                $subject = 'Admin';
            }
            $this->Email->subject = $subject;
            $this->Email->sendAs = 'both';
            $headers  = array(
                    "From"=> $from,
                    "Reply-To"=>$this->Email->replyTo,
                    "Return-Path"=>$this->Email->replyTo,
                    'MIME-Version'=>"1.0",
                    'Content-type'=>'text/html; charset=iso-8859-1',
                    'X-Mailer'=>'PHP". phpversion() ."\n',
                );
            $this->Email->headers = $headers;
            if ($this->Email->send($messages)) {
                $message = $messages;
 		$path = "INBOX" . (isset($folderPath) && !is_null($folderPath) ? ".".$folderPath : ""); // Location to save the email
		$imapStream = imap_open("{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail", "donoteply@sieasta.com", "sieasta@2015");
                $list = imap_list($imapStream, "{imap.gmail.com:993/imap/ssl}", "*");
                //$imapStream = imap_open("{" . "imap.gmail.com:993/imap/ssl" . "}" . $path , "join.vaibhav007@gmail.com", "pramila007");
		$dmy=date("d-M-Y H:i:s"); 
                $boundary = "------=".md5(uniqid(rand())); 
                $msg = ("From: $from\r\n" 
                    . "To: $to\r\n" 
                    . "Date: $dmy\r\n" 
                    . "Subject: $subject\r\n" 
                    . "MIME-Version: 1.0\r\n" 
                    . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n" 
                    . "\r\n\r\n" 
                    . "--$boundary\r\n" 
                    . "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n" 
                    . "Content-Transfer-Encoding: 8bit \r\n" 
                    . "\r\n\r\n" 
                    . "$message\r\n" 
                    . "\r\n\r\n");
                    imap_append($imapStream, "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail", $msg);
                    imap_close($imapStream);
                return true;
            } else {
                return false;
            }
        }
        /******************************/
         public function sendEmailAttach($to = null, $from = null,$subject,$message,$path = null, $file_name = null,$templateID = null,$dynamicFields = array()){
            App::import('Model', 'Emailtemplate');
            $this->Emailtemplate = new Emailtemplate();
            $template = $this->Emailtemplate->find('first', array('conditions' => array('Emailtemplate.template_code' => $templateID)));
            if(isset($dynamicFields['{template_type}']) && $dynamicFields['{template_type}']==1){
                $message = $template['Emailtemplate']['text_template'];   
            }else{
                $message = $template['Emailtemplate']['template'];
            }
            $subject = $template['Emailtemplate']['name'];
            foreach ($dynamicFields as $key => $value) {
                $message = str_replace($key, $value, $message);
                $subject = str_replace($key, $value, $subject); 
            }
            $this->Email->smtpOptions = array(
                'host' => Configure::read('host'),
                'username' => Configure::read('username'),
                'password' => Configure::read('password'),
                'timeout' => Configure::read('timeout')
            );
            $this->Email->delivery = 'mail'; //possible values smtp or mail 
            $admin_name = Configure::read('ADMIN_NAME');
            if (empty($reply)) {
                $reply = $admin_name . '<' . Configure::read('replytoEmail') . '>';
            }
            if (empty($from)) {
                $from = $admin_name . '<' . Configure::read('fromEmail') . '>';
            }
            $this->Email->from = $from;
            if ($to == 'admin') {
                $this->Email->to = $from;
            } else {
                $this->Email->to = $to;
            }
    
            if (!empty($path) && !empty($file_name))
                $this->Email->attachments = array($file_name, $path . $file_name);
    
            if (empty($subject)) {
                $subject = 'Admin';
            }
            $this->Email->subject = $subject;
            $this->Email->sendAs = 'both';
            $this->Email->message =$message;
            if ($this->Email->send($message)) {
                return true;
            } else {
                return false;
            }
        }
        /**************************** Common function to send Notifications *********************/
         function send_notification($notification_array = array()) {
            App::import('Model', 'UserNotification');
            $this->UserNotification = new UserNotification();
            $notification['UserNotification'] = $notification_array;
            $this->UserNotification->save($notification);
        }
        
        
        function getSalonServiceList($userId = NULL,$type = 'LIST'){
            $salonService = array();
            if($userId){
                App::import('Model','SalonService');
                $this->SalonService = new SalonService();
                $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
                $this->SalonService->recursive =2;
                if($type && $type == 'LIST'){
                    $this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('SalonServiceImage','ServicePricingOption','SalonStaffService')));
                }
                $salonService = $this->SalonService->find('threaded', array('conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1, 'SalonService.salon_id' => $userId ), 'order' => array('SalonService.service_order')));
                if($type && $type == 'LIST'){
                    $salonS = array();
                    if(!empty($salonService)){
                        foreach($salonService as $salService){
                            if(!empty($salService['children'])){
                                $serName = (!empty($salService['SalonService']['eng_display_name']))? $salService['SalonService']['eng_display_name'] : ($salService['SalonService']['eng_name'])? $salService['SalonService']['eng_name'] : $salService['Service']['eng_name'] ;
                                foreach($salService['children'] as $childService){
                                    $salonS[$serName][$childService['SalonService']['id']] = (!empty($childService['SalonService']['eng_display_name']))? $childService['SalonService']['eng_display_name'] : ($childService['SalonService']['eng_name'])? $childService['SalonService']['eng_name'] : $childService['Service']['eng_name'] ;
                                }
                            }
                        }
                    }
                    if(!empty($salonS)){
                      return $salonS;
                    }else{
                        $salonService = array();
                    }
                }
            }
            return $salonService;
        }
        
        function getAllSalonServiceList($type){
                $salonService = array();
                App::import('Model','SalonService');
                $this->SalonService = new SalonService();
                $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
                $this->SalonService->recursive =2;
                if($type && $type == 'LIST'){
                    $this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('SalonServiceImage','ServicePricingOption','SalonStaffService')));
                }
                $salonService = $this->SalonService->find('threaded', array('conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1), 'order' => array('SalonService.service_order')));
                if($type && $type == 'LIST'){
                    $salonS = array();
                    if(!empty($salonService)){
                        foreach($salonService as $salService){
                            if(!empty($salService['children'])){
                                $serName = (!empty($salService['SalonService']['eng_display_name']))? $salService['SalonService']['eng_display_name'] : ($salService['SalonService']['eng_name'])? $salService['SalonService']['eng_name'] : $salService['Service']['eng_name'] ;
                                foreach($salService['children'] as $childService){
                                    $salonS[$serName][$childService['SalonService']['id']] = (!empty($childService['SalonService']['eng_display_name']))? $childService['SalonService']['eng_display_name'] : ($childService['SalonService']['eng_name'])? $childService['SalonService']['eng_name'] : $childService['Service']['eng_name'] ;
                                }
                            }
                        }
                    }
                    if(!empty($salonS)){
                        return $salonS;
                    }
                }
            return $salonService;
        }
        
        function getStaffServiceList($empId , $userId){
            $salonService = $this->getSalonServiceList($userId);
            App::import('Model','SalonStaffService');
            $this->SalonStaffService = new SalonStaffService();
            $serviceList = $this->SalonStaffService->find('list',array('fields'=>array('SalonStaffService.salon_service_id'),'conditions'=>array('SalonStaffService.staff_id'=>$empId,'SalonStaffService.status'=>1)));
            foreach($salonService as $thek=>$staffSer){
                foreach($staffSer as $theSerId=>$theSer){
                    if(!in_array($theSerId,$serviceList)){
                        unset($salonService[$thek][$theSerId]);
                    }
                }
            }
            $salonService = array_filter($salonService);
            return $salonService;
        }
        
        function getAllStaffServiceList(){
            $salonService = $this->getAllSalonServiceList($type='LIST');
            App::import('Model','SalonStaffService');
            $this->SalonStaffService = new SalonStaffService();
            $serviceList = $this->SalonStaffService->find('list',array('fields'=>array('SalonStaffService.salon_service_id'),'conditions'=>array('SalonStaffService.status'=>1)));
            foreach($salonService as $thek=>$staffSer){
                foreach($staffSer as $theSerId=>$theSer){
                    if(!in_array($theSerId,$serviceList)){
                      unset($salonService[$thek][$theSerId]);
                    }
                }
            }
            $salonService = array_filter($salonService);
            return $salonService;
        }
    
        function get_salon_staff($uid=NULL){
            App::import("Model", "User");
            $model = new User(); 
            $total  = $model->find('all',array('fields'=>array('id','first_name','last_name' ),'conditions'=>array('OR' => array(array('User.parent_id'=>$uid,'User.type'=>5,'User.is_deleted'=>0,'UserDetail.employee_type'=>2), array('User.id'=>$uid))),'group'=>array("User.id")));
            return $total;
        }
        
        function get_pricingoption_staff(){
            App::import("Model", "SalonStaffService");
            $model = new User(); 
            //$total  = $model->find('all',array('fields'=>array('id','first_name','last_name' ),'conditions'=>array('User.parent_id'=>$uid,'User.type'=>5,'User.is_deleted'=>0,'UserDetail.employee_type'=>2)));
            return true;
        }
        
        public function check_pricing($serviceID = null,$user_id=null){
            App::import("Model", "ServicePricingOption");
            $this->ServicePricingOption = new ServicePricingOption();
            $pricing  = $this->ServicePricingOption->find('count',array('conditions'=>array('ServicePricingOption.is_deleted'=>0,'ServicePricingOption.salon_service_id'=>$serviceID,'ServicePricingOption.user_id'=>$user_id)));
            if($pricing){
                return true;
            }else{
                return false;
            }
        }
        public function check_service_detail($serviceID = null){
            App::import("Model", "SalonServiceDetail");
            $this->SalonServiceDetail = new SalonServiceDetail();
            $serviceDetail  = $this->SalonServiceDetail->find('count',array('conditions'=>array('SalonServiceDetail.associated_id'=>$serviceID,'SalonServiceDetail.associated_type'=>1)));
            if($serviceDetail){
                return true;
            }else{
                return false;
            }
        }
        
        public function get_service_pricing_levels($serviceID = null,$user_id=null,$pricingOptionID = null){
            App::import("Model", "ServicePricingOption");
            $this->ServicePricingOption = new ServicePricingOption();
            if($pricingOptionID){
               $condition =  array('id !='=>$pricingOptionID);
            }else{
              $condition = '';
            }
            $pricing  = $this->ServicePricingOption->find('all',array('fields'=>array('pricing_level_id'),'conditions'=>array('ServicePricingOption.is_deleted'=>0,'ServicePricingOption.salon_service_id'=>$serviceID,'ServicePricingOption.user_id'=>$user_id, $condition)));
            if($pricing){
                return $pricing;
            }else{
                return false;
            }
        }
        
        function deleteUnsavedSpabreak($userId=null){
            App::import("Model", "Spabreak");
            $this->Spabreak = new Spabreak();
            $this->Spabreak->deleteAll(array('Spabreak.status'=>2,'Spabreak.user_id'=>$userId));
            return true;
        }
        
        public function checkDeletePermission($serviceID = null,$user_id=null){
            App::import("Model", "Appointment");
            $this->Appointment = new Appointment();
            App::import("Model", "PackageService");
            $this->PackageService = new PackageService();
            App::import("Model", "DealServicePackage");
            $this->DealServicePackage = new DealServicePackage();
            $current_date = time();
            $this->Appointment->recursive = -1;
            $appointmentExist = $this->Appointment->find('count',array('conditions'=>array('Appointment.salon_service_id'=>$serviceID, "NOT" => array( "Appointment.status" => array(5,9,3)),'Appointment.is_deleted'=>0,'Appointment.appointment_start_date >= ' => $current_date)));
            $this->PackageService->bindModel(array('belongsTo'=>array('Package')));
            $packageExist  = $this->PackageService->find('count',array('conditions'=>array('Package.is_deleted'=>0,'Package.type'=>'Package','PackageService.salon_service_id'=>$serviceID)));
            $this->PackageService->bindModel(array('belongsTo'=>array('Package')));
            $spadayExist  =  $this->PackageService->find('count',array('conditions'=>array('Package.is_deleted'=>0,'Package.type'=>'Spaday','PackageService.salon_service_id'=>$serviceID)));
            $this->DealServicePackage->bindModel(array('belongsTo'=>array('Deal')));
            $dealExist  = $this->DealServicePackage->find('count',array('conditions'=>array('Deal.is_deleted'=>0,'DealServicePackage.salon_service_id'=>$serviceID)));
            if($appointmentExist){
                 return 'appointment_exist';
            }else if($packageExist){
                return 'package_exist';
            }else if($spadayExist){
                // die('spaday');
                 return 'spaday_exist';
            }else if($dealExist['DealServicePackage']){
                 // die('spaday');
                 return 'deal_exist';
            }else{
                return 'true';
            }
        }
        
        public function openHours($userId){
            $openingHours = array();
            if($userId){
                App::import("Model", "SalonOpeningHour");
                $this->SalonOpeningHour = new SalonOpeningHour();
                $openingHours = $this->SalonOpeningHour->find('first' , array('conditions'=>array('user_id'=>$userId)));
            }
            return $openingHours;
        }
        
        public function openHoursSchedular($userId){
            $scheRefined = array();
            if($userId){
                $openHour = $this->openHours($userId);
                if(!empty($openHour)){
                    if($openHour['SalonOpeningHour']['is_checked_disable_sun']){
                        $scheRefined[0]['sTime'] = $openHour['SalonOpeningHour']['sunday_from'];
                        $scheRefined[0]['eTime'] = $openHour['SalonOpeningHour']['sunday_to'];
                    }
                    if($openHour['SalonOpeningHour']['is_checked_disable_mon']){
                        $scheRefined[1]['sTime'] = $openHour['SalonOpeningHour']['monday_from'];
                        $scheRefined[1]['eTime'] = $openHour['SalonOpeningHour']['monday_to'];
                    }
                    if($openHour['SalonOpeningHour']['is_checked_disable_tue']){
                        $scheRefined[2]['sTime'] = $openHour['SalonOpeningHour']['tuesday_from'];
                        $scheRefined[2]['eTime'] = $openHour['SalonOpeningHour']['tuesday_to'];
                    }
                    if($openHour['SalonOpeningHour']['is_checked_disable_wed']){
                        $scheRefined[3]['sTime'] = $openHour['SalonOpeningHour']['wednesday_from'];
                        $scheRefined[3]['eTime'] = $openHour['SalonOpeningHour']['wednesday_to'];
                    }
                    if($openHour['SalonOpeningHour']['is_checked_disable_thu']){
                        $scheRefined[4]['sTime'] = $openHour['SalonOpeningHour']['thursday_from'];
                        $scheRefined[4]['eTime'] = $openHour['SalonOpeningHour']['thursday_to'];
                    }
                    if($openHour['SalonOpeningHour']['is_checked_disable_fri']){
                        $scheRefined[5]['sTime'] = $openHour['SalonOpeningHour']['friday_from'];
                        $scheRefined[5]['eTime'] = $openHour['SalonOpeningHour']['friday_to'];
                    }
                    if($openHour['SalonOpeningHour']['is_checked_disable_sat']){
                        $scheRefined[6]['sTime'] = $openHour['SalonOpeningHour']['saturday_from'];
                        $scheRefined[6]['eTime'] = $openHour['SalonOpeningHour']['saturday_to'];
                    }
                }
            }
            return $scheRefined;
        }
        
        function staffSortbySorder($staff = array(), $sorder = array()){
            $sortedStaff = array();
            if(!empty($staff) && !empty($sorder)){
                foreach($sorder as $theUser){
                    foreach($staff as $theStaff){
                        if($theUser == $theStaff['User']['id']){
                            $sortedStaff[] = $theStaff;
                        }
                    }
                }
                foreach($staff as $theStaff){
                    if(!in_array($theStaff['User']['id'],$sorder)){
                        $sortedStaff[] = $theStaff;
                    }
                }
            }
            return $sortedStaff;
        }
        
        function sendVerificationCode($message=NUll,$number=NULL){
            $user="sieasta"; //your username
            $password="ham@123"; //your password
            $mobilenumbers=$number; //enter Mobile numbers comma seperated
            $message = $message; //enter Your Message
            $senderid="SMSCountry"; //Your senderid
            $messagetype="N"; //Type Of Your Message
            $DReports="Y"; //Delivery Reports
            $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
            $message = urlencode($message);
            $ch = curl_init();
            if (!$ch){die("Couldn't initialize a cURL handle");}
            $ret = curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt ($ch, CURLOPT_POSTFIELDS,
            "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
            $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $curlresponse = curl_exec($ch); // execute
            if(curl_errno($ch))
                return;
            if (empty($ret)){
            // some kind of an error happened
                 curl_close($ch); 
                return;
           // close cURL handler
            } else {
            $info = curl_getinfo($ch);
            curl_close($ch); // close cURL handler
            return FALSE;
            }
        }
        
         public function getPhoneCode($id=null){
                    if($id){
                            App::import("Model", "Country");
                            $this->Country = new Country();
                            $phCode = $this->Country->find('first',array('fields'=>array('Country.phone_code'),'conditions'=>array('Country.id'=>$id)));
                            return $phCode['Country']['phone_code'];
                    }
                    return;
        }
        
        function encrypt_string($input){
            $inputlen = strlen($input);// Counts number characters in string $input
            $randkey = rand(1, 9); // Gets a random number between 1 and 9
            $i = 0;
                while ($i < $inputlen){
                    $inputchr[$i] = (ord($input[$i]) - $randkey);//encrpytion
                    $i++; // For the loop to function
                }
            $encrypted = implode('-', $inputchr) . '-' . (ord($randkey)+50);
            return $encrypted;
        }
        
        function decrypt_string($input){
            $input_count = strlen($input);
            $real = '';
            $dec = explode("-", $input);// splits up the string to any array
            $x = count($dec);
            $y = $x-1;// To get the key of the last bit in the array
            $calc = $dec[$y]-50;
            $randkey = chr($calc);// works out the randkey number
            $i = 0;
           while ($i < $y){
              $array[$i] = $dec[$i]+$randkey; // Works out the ascii characters actual numbers
              $real .= chr($array[$i]); //The actual decryption
              $i++;
            };
            $input = $real;
            return $input;
        }
        
        public function countAlbumFiles($id, $type) {
            App::import('Model', 'AlbumFile');
            $this->AlbumFile = new AlbumFile();
            $total_images = $this->AlbumFile->find('count', array('conditions' => array('AlbumFile.album_id' => $id, 'type' => $type)));
            return $total_images;
        }
        
        public function salonServiceImage($serviceid,$userid){
            App::import('Model', 'SalonServiceImage');
            $this->SalonServiceImage = new SalonServiceImage();
            $total_images = $this->SalonServiceImage->find('count', array('conditions' => array('SalonServiceImage.salon_Service_id' => $serviceid, 'SalonServiceImage.created_by' => $userid)));
            if($total_images >0){
                return true;
            }else{
                return false;
            }
        }
        
        public function get_timezones(){
            App::import('Model', 'Timezone');
            $this->Timezone = new Timezone();
            $timezones = $this->Timezone->find('list', array('fields' => array('Timezone.id', 'Timezone.timezone'), 'conditions' => array('Timezone.status' => 1)));
            if(!empty($timezones)){
                return $timezones;
            }else{
                return '';
            }
        }
        
        public function get_pricingLevel_staff($pricingLevelid = null){
            App::import('Model', 'PricingLevelAssigntoStaff');
            $this->PricingLevelAssigntoStaff = new PricingLevelAssigntoStaff();
            $PricingLevelAssigntoStaff = $this->PricingLevelAssigntoStaff->find('list', array('fields' => array('PricingLevelAssigntoStaff.id', 'PricingLevelAssigntoStaff.user_id'), 'conditions' => array('PricingLevelAssigntoStaff.pricing_level_id' =>$pricingLevelid)));
            return $PricingLevelAssigntoStaff;
        }
        
        function get_price_level_id($id = NULL){
            $lang = Configure::read('Config.language'); 
            $data = array();
            App::import("Model", "PricingLevelAssigntoStaff");
            $model = new PricingLevelAssigntoStaff();
            $priceLevel = $model->find('first',array('conditions'=>array('user_id'=>$id)));
            if(isset($priceLevel['PricingLevelAssigntoStaff']['pricing_level_id']) && $priceLevel['PricingLevelAssigntoStaff']['pricing_level_id']!=0){
                App::import("Model", "PricingLevel");
                $model = new PricingLevel();   
                $model->recursive = -1;
                $data = $model->find('first', array('fields' => array('id', 'eng_name','ara_name'), 'conditions' => array('PricingLevel.id' =>$priceLevel['PricingLevelAssigntoStaff']['pricing_level_id'], 'status' => '1','is_deleted'=>0)));
            }
            if(count($data)){
                return $data['PricingLevel']['id'];   
            }else{
                return '';   
            }
        }
        
        function get_mint_hour($duration_val = null){
            $format = '%02d '.__('hrs',true).' %02d '.__('mins',true);
            if($duration_val < 60){
             $format = '%02d '.__('mins',true);
            }
             $time = $duration_val;
             settype($time, 'integer');
            if ($time < 1) {
                return;
            }
            $hours = floor($time / 60);
            $minutes = ($time % 60);
            if($time < 60){
                return sprintf($format, $minutes);
            }else{
                return sprintf($format, $hours, $minutes);    
            }
        }
      
        function get_gift_certificate_image($giftCertificate){
            $time = time();
            $salonData =  $this->employeeName($giftCertificate['GiftCertificate']['salon_id']);
            $price = "AED ".$giftCertificate['GiftCertificate']['amount'] . "\n";
            $gc_code = @$giftCertificate['GiftCertificate']['gift_certificate_no'];
            $time = time();
            $price = "AED ".@$giftCertificate['GiftCertificate']['amount'] . "\n";
            $fronEmail = @$salonData['User']['email'];
            $recipient = ucfirst(@$giftCertificate['GiftCertificate']['first_name']).' '.ucfirst(@$giftCertificate['GiftCertificate']['last_name']);
            $email = $giftCertificate['GiftCertificate']['email'] . "";
            $senderName = ucfirst(@$salonData['User']['first_name']).' '.ucfirst(@$salonData['User']['last_name']);
            $expire = ($giftCertificate['GiftCertificate']['expire_on']=='0000-00-00')?'Never expire':$giftCertificate['GiftCertificate']['expire_on'];
            $gc_msg = $giftCertificate['GiftCertificate']['messagetxt'];
            $salonName = '';
            if(@$giftCertificate['GiftCertificate']['salon_id'] > 1){
                $salonDetail = $this->salonDetail($giftCertificate['GiftCertificate']['salon_id']);
                $salonName  = $salonDetail['Salon']['eng_name']."\n";
                $salonName .= $salonDetail['Address']['address']."\n";
                if($salonDetail['Contact']['day_phone']){
                    $salonName .= "+971 ".$salonDetail['Contact']['day_phone']."\n";
                }
            }
            $message = "To: $recipient\n\n";
            $message .= "From: $senderName\n\n";
            $message .= "Gift Certificate code: $gc_code\n\n";
            $message .= "Gift Certificate of $price\n\n";
            $message .= $gc_msg;
            $message .= "\n\nExipre On: $expire\n\n";
            $message .= "\n\n-----------\nRegards,\n";
            $message .= "$senderName\n\n";
            if($salonName){
                $message .= "$salonName\n\n";
            }
            $text_write_image = $message;
            if ($text_write_image) {
                $textNew =  $text_write_image;
            } else {
                $textNew = 'This is dummy text';
            }
            $extension = substr($giftCertificate['GiftImage']['image'], strrpos($giftCertificate['GiftImage']['image'], '.') + 1);
            $font  = 15;
            $x = 126;
            $y = 22;
            if ($extension == 'jpeg' || $extension == 'jpg') {
                header('Content-type: image/jpeg');
                $jpg_image = imagecreatefromjpeg(WWW_ROOT.'images/GiftImage/original/' . $giftCertificate['GiftImage']['image']);
                $white = imagecolorallocate($jpg_image, 255, 255, 255);
                $hex = str_replace("#", "", "008000");
                if(strlen($hex) == 3) {
                    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                } else {
                    $r = hexdec(substr($hex,0,2));
                    $g = hexdec(substr($hex,2,2));
                    $b = hexdec(substr($hex,4,2));
                }
                $white = imagecolorallocate($jpg_image, $r, $g, $b);
                $font_path = WWW_ROOT . 'images/font.ttf';
                $image = $jpg_image;
                $string =  $textNew;
                $color  = $white;
                $font_height = imagefontheight($font);
                $font_width = imagefontwidth($font);
                $image_height = imagesy($image);
                $image_width = imagesx($image);
                $max_characters = (int) ($image_width - $x) / $font_width ;
                $next_offset_y = $y;
                for($i = 0, $exploded_string = explode("\n", $string), $i_count = count($exploded_string); $i < $i_count; $i++) {
                    $exploded_wrapped_string = explode("\n", wordwrap(str_replace("\t", "    ", $exploded_string[$i]), $max_characters, "\n"));
                    for($j = 0, $j_count = count($exploded_wrapped_string); $j < $j_count; $j++) {
                        imagestring($image, $font, $x, $next_offset_y, $exploded_wrapped_string[$j], $color);
                        $next_offset_y += $font_height;
                        if($next_offset_y >= $image_height - $y) {
                            return;
                        }
                    }
                }
                imagejpeg($image, WWW_ROOT . 'images/GiftImage/original/'.$giftCertificate['GiftCertificate']['id'].'_'.$giftCertificate['GiftCertificate']['gift_image_id'].'.jpg');
                imagedestroy($jpg_image);
            } elseif ($extension == 'png') {
                header('Content-type: image/png');
                $png_image = imagecreatefrompng(WWW_ROOT . 'images/GiftImage/original/' . $giftCertificate['GiftImage']['image']);
                $white = imagecolorallocate($png_image, 255, 255, 255);
                $hex = str_replace("#", "", "008000");
                if(strlen($hex) == 3) {
                    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                } else {
                    $r = hexdec(substr($hex,0,2));
                    $g = hexdec(substr($hex,2,2));
                    $b = hexdec(substr($hex,4,2));
                }
                $white = imagecolorallocate($png_image, $r, $g, $b);
                $font_path = WWW_ROOT . 'images/font.ttf';
                $string =  $textNew;
                $image = $png_image;
                $color  = $white;
                $font_height = imagefontheight($font);
                $font_width = imagefontwidth($font);
                $image_height = imagesy($image);
                $image_width = imagesx($image);
                $max_characters = (int) ($image_width - $x) / $font_width ;
                $next_offset_y = $y;
                for($i = 0, $exploded_string = explode("\n", $string), $i_count = count($exploded_string); $i < $i_count; $i++) {
                    $exploded_wrapped_string = explode("\n", wordwrap(str_replace("\t", "    ", $exploded_string[$i]), $max_characters, "\n"));
                    for($j = 0, $j_count = count($exploded_wrapped_string); $j < $j_count; $j++) {
                        imagestring($image, $font, $x, $next_offset_y, $exploded_wrapped_string[$j], $color);
                        $next_offset_y += $font_height;
                        if($next_offset_y >= $image_height - $y) {
                            return;
                        }
                    }
                }
                imagepng($image, WWW_ROOT.'images/GiftImage/original/'.$giftCertificate['GiftCertificate']['id'].'_'.$giftCertificate['GiftCertificate']['gift_image_id'].'.png');
                imagedestroy($png_image);
            } elseif ($extension == 'gif') {
                header('Content-type: image/gif');
                $gif_image = imagecreatefromgif(WWW_ROOT.'images/GiftImage/original/' . $giftCertificate['GiftImage']['image']);
                $white = imagecolorallocate($gif_image, 255, 255, 255);
                $hex = str_replace("#", "", "008000");
                if(strlen($hex) == 3) {
                   $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                   $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                   $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                } else {
                   $r = hexdec(substr($hex,0,2));
                   $g = hexdec(substr($hex,2,2));
                   $b = hexdec(substr($hex,4,2));
                }
                $white = imagecolorallocate($gif_image, $r, $g, $b);
                $font_path = WWW_ROOT.'images/font.ttf';
                $image = $gif_image;
                $string =  $textNew;
                $color  = $white;
                $font_height = imagefontheight($font);
                $font_width = imagefontwidth($font);
                $image_height = imagesy($image);
                $image_width = imagesx($image);
                $max_characters = (int) ($image_width - $x) / $font_width ;
                $next_offset_y = $y;
                for($i = 0, $exploded_string = explode("\n", $string), $i_count = count($exploded_string); $i < $i_count; $i++) {
                    $exploded_wrapped_string = explode("\n", wordwrap(str_replace("\t", "    ", $exploded_string[$i]), $max_characters, "\n"));
                    for($j = 0, $j_count = count($exploded_wrapped_string); $j < $j_count; $j++) {
                        imagestring($image, $font, $x, $next_offset_y, $exploded_wrapped_string[$j], $color);
                        $next_offset_y += $font_height;
                        if($next_offset_y >= $image_height - $y) {
                            return;
                        }
                    }
                }
                imagegif($image, WWW_ROOT.'images/GiftImage/original/'.$giftCertificate['GiftCertificate']['id'].'_'.$giftCertificate['GiftCertificate']['gift_image_id'].'.gif');
                imagedestroy($gif_image);
            }
            return true;
        }
      
      public function checkStaff_online($staffID){
        if($staffID){
            App::import("Model", "User");
            $model = new User();
            $onlineStaff = $model->find('first',array('conditions'=>array('User.booking_status' => 1,  'User.image !=' => "",'User.id'=>$staffID)));
            if($onlineStaff){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
      }
      
      public function getservice($service_id = null){
            App::import("Model", "Service");
            $model = new Service();
            $model->unbindModel(array('hasMany' => array('ServiceImage')));
            $decrypted = $this->decrypt_string($service_id);
            $service_ids = array();
            $child_service=array();
            $chk_service = $model->find('first', array(
                'conditions' => array('Service.id' => $decrypted),
                'fields' => 'parent_id'
            ));
    
            if(!empty($chk_service)){
                $parent = $chk_service['Service']['parent_id'];
                if($parent != 0){
                     $model->unbindModel(array('hasMany' => array('ServiceImage')));
                     $service = $model->find('all', array(
                        'conditions' => array('Service.parent_id' => $decrypted),
                        'fields' => 'id'
                    ));
                    if(!empty($service)){
                        foreach($service as $s){
                           $service_ids[] = $s['Service']['id']; 
                        }
                    }
                }else{
                    $model->unbindModel(array('hasMany' => array('ServiceImage')));
                    $service = $model->find('all', array(
                        'conditions' => array('Service.parent_id' => $decrypted),
                        'fields' => 'id'
                    ));
                    //pr($service);exit;
                    if(!empty($service)){
                        foreach($service as $s){
                            $model->unbindModel(array('hasMany' => array('ServiceImage')));
                            $child_service[] = $model->find('all', array(
                                'conditions' => array('Service.parent_id' => $s['Service']['id']),
                                'fields' => 'id'
                            ));
                        }
                        if(!empty($child_service)){
                            foreach($child_service as $child){
                                if(!empty($child)){
                                    foreach($child as $c){
                                        $service_ids[] = $c['Service']['id'];
                                    }
                                }
                                
                            }
                        }
                       
                    }
                
                }
            }
            return $service_ids;
      }
      public function getcategory($category = null){
            App::import("Model", "Service");
            $model = new Service();
            $model->unbindModel(array('hasMany' => array('ServiceImage')));
            $service_ids = array();
            $child_service=array();
            $chk_service = $model->find('first', array(
                'conditions' => array('Service.id' => $category),
                'fields' => 'parent_id'
            ));
    
            if(!empty($chk_service)){
                $parent = $chk_service['Service']['parent_id'];
                if($parent != 0){
                     $model->unbindModel(array('hasMany' => array('ServiceImage')));
                     $service = $model->find('all', array(
                        'conditions' => array('Service.parent_id' => $category),
                        'fields' => 'id'
                    ));
                    if(!empty($service)){
                        foreach($service as $s){
                           $service_ids[] = $s['Service']['id']; 
                        }
                    }
                }
            }
            return $service_ids;
      }
      
      public function get_service_category($service_id = null){
            App::import("Model", "Service");
            $model = new Service();
            $model->unbindModel(array('hasMany' => array('ServiceImage')));
            $service_ids = array();
            $child_service=array();
            $chk_service = $model->find('first', array(
                'conditions' => array('Service.id' => $service_id),
                'fields' => 'parent_id'
            ));
            if($chk_service){
                return $chk_service['Service']['parent_id'];    
            }else{
                return false;
            }
            
      }
      
      
        public function getServiceids($service_name){
            //pr($service_name); exit;
            App::import("Model", "Service");
            $model = new Service();
            $salon_ids = $model->find('list',array('conditions'=>"Service.eng_name LIKE'%".$service_name."%' AND Service.parent_id NOT IN(select id from services where parent_id = 0)" ));
            return implode('-',$salon_ids);
           
        }
        
        public function getServiceidsNew($service_name){
            //pr($service_name); exit;
            App::import("Model", "Service");
            $model = new Service();
            $salon_ids = $model->find('list',array('conditions'=>"Service.eng_name LIKE'%".$service_name."%' AND Service.parent_id NOT IN(select id from services where parent_id = 0) and Service.status=1 and Service.is_deleted = 0" ));
           
            return implode(',',$salon_ids);
           
        }
        
       public function getServiceFromId($parent_ids){
            //pr($service_name); exit;
            App::import("Model", "Service");
            $model = new Service();
            $salon_ids = $model->find('list',array('conditions'=>"Service.parent_id  IN($parent_ids) and Service.status=1 and Service.is_deleted = 0" ));
            return implode(',',$salon_ids);
        }
      
        public function getSalonServiceids($service_ids){
          App::import("Model", "SalonService");
          $model = new SalonService();
          $salon_service_ids = $model->find('list',array('fields'=>array('id','service_id'),'conditions'=>array('SalonService.service_id'=>$service_ids,'SalonService.status'=>1,'SalonService.is_deleted'=>0)));
          return $salon_service_ids;
        }
        
        
        public function getSalonServiceidsFname($service_name){
         App::import("Model", "Service");
         $model = new Service();
         $salon_ids = $model->find('list',array('conditions'=>"Service.eng_name LIKE'%".$service_name."%'"));
         $salon_service_ids = $this->getSalonServiceids($salon_ids);
         return $salon_service_ids;
        }
      
        public function getTax($salon_id=1){
          App::import("Model", "TaxCheckout");
          $model = new TaxCheckout();
          $tax_fields = array('tax1','tax2','deduction1','deduction2','user_id');
          $taxes = $model->find('first',array('conditions'=>array('user_id'=>$salon_id),'fields'=>$tax_fields));
          if(!count($taxes)){
           $taxes = $model->find('first',array('conditions'=>array('user_id'=>1),'fields'=>$tax_fields));    
          }
          return $taxes;
        }
      
        function getPrice($userId=NULL ,$salonId =NULL){
              $amount_redeemed = '';
              App::import("Model", "PointSetting");
              $model = new PointSetting();
              $get_total_points = $model->find('first',array('conditions'=>array('id'=>1),'fields' => array('aed_unit')));
              $total_points = $get_total_points['PointSetting']['aed_unit'];
              App::import("Model", "UserCount");
              $model2 = new UserCount();
              $points = $model2->find('first',array(
                      'conditions' => array('UserCount.salon_id'=>$salonId, 'UserCount.user_id'=>$userId),
                      'fields' => array('user_count')
              ));
              if(!empty($points)){
                  $user_count = $points['UserCount']['user_count'];
                  if(($user_count != '') && ($total_points != '')){
                      //echo 'here';exit;
                      $amount_redeemed =  $user_count/$total_points;
                      $amount_redeemed = round($amount_redeemed,2);
                  }
              }
             return $amount_redeemed; 
        }   
      
        function get_points_from_price($amount=NULL){
            App::import("Model", "PointSetting");
            $model = new PointSetting();
            $get_total_points = $model->find('first',array('conditions'=>array('id'=>1),'fields' => array('aed_unit')));
            $total_points = $get_total_points['PointSetting']['aed_unit'];
            return round($total_points*$amount);
        }
      
        function get_price_from_point($point=NULL){
            App::import("Model", "PointSetting");
            $model = new PointSetting();
            $get_total_points = $model->find('first',array('conditions'=>array('id'=>1),'fields' => array('aed_unit')));
            $total_points = $get_total_points['PointSetting']['aed_unit'];
            return round($point/$total_points,2);
        }
      
        
        function get_roundTime($addTime){
                    $current_time  = date("h:i A");
                    $a  = strtotime($addTime, strtotime($current_time));
                    $from =   date("h:i A", $a);
                    $rounded_time = $this->roundToQuarterHour($from);
                    $new_date = date('d-m-Y',$a);
                    return array('new_date'=>$new_date ,'from'=>$rounded_time);
        }
      
        function roundToQuarterHour($timestring) {
            $timeStapmp = strtotime($timestring);
            $minutes = date('i', $timeStapmp);
            $addMinute = 15-($minutes % 15);
            $from   =  date('h:i A', strtotime("+$addMinute minutes",$timeStapmp));
            return $from;
        }
      
      
      
      
      
            function vocher_expiry($salon_id = NUll,$expiry=NULL,$expire_after=NULL){
                if($expiry==0 or $expiry==NULL){
                    App::import("Model", "PolicyDetail");
                    $model = new PolicyDetail();  
                    $fields = array('ev_validity');
                    $data = $model->find('first', array('conditions'=>array('user_id'=>$salon_id),'fields'=>$fields));
                        if(count($data)==0){
                           $data = $model->find('first', array('conditions'=>array('user_id'=>1),'fields'=>$fields));   
                        }
                        if(isset($data['PolicyDetail']['ev_validity'])){
                            $expiry  = $data['PolicyDetail']['ev_validity'];
                            $datetime = new DateTime();
                            $datetime->modify("+ $expiry  months");
                            return $datetime->format('Y-m-d');
                        }
                    }else{
                            $datetime = new DateTime();
                            $datetime->modify("+ $expire_after  months");
                            return $datetime->format('Y-m-d');  
                    }
            }
            
            
        function getDefaultLeadTime($salon_id = null,$type = null,$fields = array()){
            App::import("Model", "SalonOnlineBookingRule");
            $this->SalonOnlineBookingRule = new SalonOnlineBookingRule();  
            $salonSetting = $this->SalonOnlineBookingRule->find("first",array('fields'=>$fields,'conditions'=>array('SalonOnlineBookingRule.user_id'=>$salon_id)));
                if(empty($salonSetting)){
                    $salonSetting = $this->SalonOnlineBookingRule->find("first",array('fields'=>$fields,'conditions'=>array('SalonOnlineBookingRule.user_id'=>1)));
                }
                if($type == 'service'){
                    return $salonSetting['SalonOnlineBookingRule']['lead_time'];    
                }else if($type == 'Spaday'){
                    return $salonSetting['SalonOnlineBookingRule']['spa_day_leadtime'];    
                }else if($type == 'spabreak'){
                    return $salonSetting['SalonOnlineBookingRule']['overnight_leadtime'];    
                }else if($type == 'Package'){
                    return $salonSetting['SalonOnlineBookingRule']['package_leadtime'];    
                }else if($type == 'maxLimit'){
                    return $salonSetting['SalonOnlineBookingRule']['booking_limit'];    
                } 
            return $salonSetting;
        }
    
        public function create_image($gc_details = array(),$giftCertificate = array()){
            
            /*$gc_details = array('GiftCertificate' => array(
                        'id' => 0,
                        'duration' => 0,
                        'pricing_option' => 0,
                        'gift_certificate_no' => 'SANDHU_PREET',
                        'amount' => 100,
                        'sender_id' => 33,
                        'recipient_first_name' => 'raman',
                        'recipient_last_name' => 'preet',
                        'recipient_email' => 'manpreet.sdei@gmail.com',
                        'messagetxt' => 'sdsdsd sdsd ds ssdsdsd sdsd ds ssdsdsd sdsd ds ssdsdsd sdsd ds ssdsdsd sdsd ds ssdsdsd sdsd ds ssdsdsd sdsd ds ssdsdsd sdsd ds ssdsdsd sdsd ds s',
                        'expire_on' => '2015-08-08',
                        'print_certificate_status' => 0,
                        'send_email_status' => 1,
                        'gift_image_category_id' => 1,
                        'gift_image_id' => 1,
                        'no_of_visit' => 0,
                        'user_id' => 1,
                    ),
                    'Sender' => array
                        (
                            'User' => array
                                (
                                    'first_name' => 'Anshul ',
                                    'last_name' => 'Testing',
                                    'email' => 'anshulv@smartdatainc.net'
                                )
                
                        )
                   );
            
            $giftCertificate = array('GiftImage' => array
            (
                'id' => 1,
                'user_id' => 1,
                'gift_image_category_id' => 1,
                'eng_title' => 'Default',
                'ara_title' => 'Default',
                'image' => '534595573_1426507348_1.jpg',
                'font_color' => 'ffffff',
                'status' => 1,
                'createdDate' => '2016-03-15',
                'modifyDate' => '2015-03-19 12:50:09',
                'is_deleted' => 0
            ));*/
            $gc_code = @$gc_details['GiftCertificate']['gift_certificate_no'];
            $time = time();
            $price = "AED ".@$gc_details['GiftCertificate']['amount'] . "\n";
            $fronEmail = @$gc_details['GiftCertificate']['Sender']['email'];
            $recipient = ucfirst(@$gc_details['GiftCertificate']['recipient_first_name']).' '.ucfirst(@$gc_details['GiftCertificate']['recipient_last_name']);
            
            $email = $gc_details['GiftCertificate']['recipient_email'] . "";
            $senderName = ucfirst(@$gc_details['GiftCertificate']['Sender']['first_name']).' '.ucfirst(@$gc_details['GiftCertificate']['Sender']['last_name']);
            //$gc_msg = chunk_split(trim($gc_details['GiftCertificate']['messagetxt']), 20, "\n");
            $expire = ($gc_details['GiftCertificate']['expire_on']=='0000-00-00')?'Never expire':$gc_details['GiftCertificate']['expire_on'];
            $gc_msg = $gc_details['GiftCertificate']['messagetxt'];
            $salonName = '';
            if(@$gc_details['GiftCertificate']['salon_id'] > 1){
              $salonDetail = $this->salonDetail($gc_details['GiftCertificate']['salon_id']);
              $salonName  = $salonDetail['Salon']['eng_name']."\n";
              $salonName .= $salonDetail['Address']['address']."\n";
              if($salonDetail['Contact']['day_phone']){
               $salonName .= "+971 ".$salonDetail['Contact']['day_phone']."\n";
              }
            }
           //get_salonName
            
            $message = "To: $recipient\n\n";
            $message .= "From: $senderName\n\n";
            $message .= "Gift Certificate code: $gc_code\n\n";
            $message .= "Gift Certificate of $price\n\n";
            $message .= $gc_msg;
            $message .= "\n\nExipre On: $expire\n\n";
            $message .= "\n\n-----------\nRegards,\n";
            $message .= "$senderName\n\n";
            if($salonName){
             $message .= "$salonName\n\n";
            }
            $text_write_image = $message;
            
            if ($text_write_image) {
                $textNew =  $text_write_image;
            } else {
                $textNew = 'This is dummy text';
            }
            
            $extension = substr($giftCertificate['GiftImage']['image'], strrpos($giftCertificate['GiftImage']['image'], '.') + 1);
            $font  = 15;
            
            if($giftCertificate['GiftImage']['text_align'] == "Right"){
                $x = 500;
            } else {
                $x = 20;
            }
            
            
            $y = 50;
            
            if ($extension == 'jpeg' || $extension == 'jpg') {
                header('Content-type: image/jpeg');
                $jpg_image = imagecreatefromjpeg(WWW_ROOT . '/images/GiftImage/original/' . $giftCertificate['GiftImage']['image']);
                $white = imagecolorallocate($jpg_image, 255, 255, 255);
                
                
                if(!empty($giftCertificate['GiftImage']['font_color'])){
                    
                    $hex = str_replace("#", "", $giftCertificate['GiftImage']['font_color']);
                   
                    if(strlen($hex) == 3) {
                       $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                       $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                       $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                    } else {
                       $r = hexdec(substr($hex,0,2));
                       $g = hexdec(substr($hex,2,2));
                       $b = hexdec(substr($hex,4,2));
                    }
                    $white = imagecolorallocate($jpg_image, $r, $g, $b);
                }
                 
                $font_path = WWW_ROOT . '/images/font.ttf';
                $image = $jpg_image;
                $string =  $textNew;
                $font_height = imagefontheight($font);
                $font_width = imagefontwidth($font);
                $image_height = imagesy($image);
                $image_width = imagesx($image);
                $max_characters = (int) ($image_width - $x) / $font_width ;
                $next_offset_y = $y;
                for($i = 0, $exploded_string = explode("\n", $string), $i_count = count($exploded_string); $i < $i_count; $i++) {
                    $exploded_wrapped_string = explode("\n", wordwrap(str_replace("\t", "    ", $exploded_string[$i]), $max_characters, "\n"));
                    for($j = 0, $j_count = count($exploded_wrapped_string); $j < $j_count; $j++) {
                        imagestring($image, $font, $x, $next_offset_y, $exploded_wrapped_string[$j], $white);
                        $next_offset_y += $font_height;
                        if($next_offset_y >= $image_height - $y) {
                            return;
                        }
                    }
                }
                $new_image_name = $gc_code.'_'.$giftCertificate['GiftImage']['id'].'_'.date('dmYHis').'.jpg';
                $return_file_path = 'images/GiftImage/original/'.$new_image_name;
                imagejpeg($image,WWW_ROOT . 'images/GiftImage/original/'.$new_image_name);
                imagedestroy($jpg_image);
                return $return_file_path;
            } elseif ($extension == 'png') {
                header('Content-type: image/png');
                $png_image = imagecreatefrompng(WWW_ROOT . '/images/GiftImage/original/' . $giftCertificate['GiftImage']['image']);
                $white = imagecolorallocate($png_image, 255, 255, 255);
                
                if(!empty($giftCertificate['GiftImage']['font_color'])){
                    
                    $hex = str_replace("#", "", $giftCertificate['GiftImage']['font_color']);
                    if(strlen($hex) == 3) {
                       $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                       $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                       $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                    } else {
                       $r = hexdec(substr($hex,0,2));
                       $g = hexdec(substr($hex,2,2));
                       $b = hexdec(substr($hex,4,2));
                    }
                    $white = imagecolorallocate($jpg_image, $r, $g, $b);
                }
                
                $font_path = WWW_ROOT . '/images/font.ttf';
                $string =  $textNew;
                $image = $png_image;
                $font_height = imagefontheight($font);
                $font_width = imagefontwidth($font);
                $image_height = imagesy($image);
                $image_width = imagesx($image);
                $max_characters = (int) ($image_width - $x) / $font_width ;
                $next_offset_y = $y;
                for($i = 0, $exploded_string = explode("\n", $string), $i_count = count($exploded_string); $i < $i_count; $i++) {
                    $exploded_wrapped_string = explode("\n", wordwrap(str_replace("\t", "    ", $exploded_string[$i]), $max_characters, "\n"));
                    for($j = 0, $j_count = count($exploded_wrapped_string); $j < $j_count; $j++) {
                        imagestring($image, $font, $x, $next_offset_y, $exploded_wrapped_string[$j], $white);
                        $next_offset_y += $font_height;
                        if($next_offset_y >= $image_height - $y) {
                            return;
                        }
                    }
                }
                $new_image_name = $gc_code.'_'.$giftCertificate['GiftImage']['id'].'_'.date('dmYHis').'.png';
                $return_file_path = 'images/GiftImage/original/'.$new_image_name;
                imagepng($image,WWW_ROOT . 'images/GiftImage/original/'.$new_image_name);
                imagedestroy($png_image);
                return $return_file_path;
            } elseif ($extension == 'gif') {
                header('Content-type: image/gif');
                $gif_image = imagecreatefromgif(WWW_ROOT . '/images/GiftImage/original/' . $giftCertificate['GiftImage']['image']);
                $white = imagecolorallocate($gif_image, 255, 255, 255);
                
                if(!empty($giftCertificate['GiftImage']['font_color'])){
                    
                    $hex = str_replace("#", "", $giftCertificate['GiftImage']['font_color']);
                   
                    if(strlen($hex) == 3) {
                       $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                       $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                       $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                    } else {
                       $r = hexdec(substr($hex,0,2));
                       $g = hexdec(substr($hex,2,2));
                       $b = hexdec(substr($hex,4,2));
                    }
                    $white = imagecolorallocate($jpg_image, $r, $g, $b);
                }
                $font_path = WWW_ROOT . '/images/font.ttf';
                $image = $gif_image;
                $string =  $textNew;
            
                $font_height = imagefontheight($font);
                $font_width = imagefontwidth($font);
                $image_height = imagesy($image);
                $image_width = imagesx($image);
                $max_characters = (int) ($image_width - $x) / $font_width ;
                $next_offset_y = $y;
                for($i = 0, $exploded_string = explode("\n", $string), $i_count = count($exploded_string); $i < $i_count; $i++) {
                    $exploded_wrapped_string = explode("\n", wordwrap(str_replace("\t", "    ", $exploded_string[$i]), $max_characters, "\n"));
                    for($j = 0, $j_count = count($exploded_wrapped_string); $j < $j_count; $j++) {
                        imagestring($image, $font, $x, $next_offset_y, $exploded_wrapped_string[$j], $white);
                        $next_offset_y += $font_height;
                        if($next_offset_y >= $image_height - $y) {
                            return;
                        }
                    }
                }
                $new_image_name = $gc_code.'_'.$giftCertificate['GiftImage']['id'].'_'.date('dmYHis').'.gif';
                $return_file_path = 'images/GiftImage/original/'.$new_image_name;
                imagegif($image, WWW_ROOT . 'images/GiftImage/original/'.$new_image_name);
                imagedestroy($gif_image);
                return $return_file_path;
            }
        }
      
       
       
        
        public function getActiveDealCount($salon_id=NULL){
            App::import("Model", "Deal");
            $Deal = new Deal();     
            $criteria ="Deal.salon_id = $salon_id AND Deal.is_deleted = 0 AND Deal.status = 1 AND Deal.listed_online = 1 AND Deal.listed_online_start <= DATE(NOW()) AND Deal.max_time >= DATE(NOW()) AND (Deal.quantity_type=0 OR (Deal.quantity_type=1 AND Deal.quantity > Deal.purchased_quantity))";
            $dealCount = $Deal->find('count' , array('conditions'=>array($criteria)));
            return $dealCount;  
        }
      
        public function employeeName($empId=NULL , $full=null){
            App::import("Model", "User");
            $model = new User(); 
            $model->recursive  = -1;
            $fields = array('first_name','last_name', 'email');
            $data = $model->find('first' , array('conditions'=>array('User.id'=>$empId) ,'fields'=>$fields));
            if($full){
               return $data['User']['first_name'].' '.$data['User']['last_name'];  
            }else{
             return $data; 
            }
            
        } 
      
         public function salonDetail($empId=NULL){
             App::import("Model", "User");
             $model = new User(); 
             $model->recursive  = 1;
             $fields = array('Salon.eng_name','Contact.country_code','Contact.cell_phone','Contact.day_phone','Address.address','Salon.business_url');
             $data = $model->find('first' , array('conditions'=>array('User.id'=>$empId) ,'fields'=>$fields));
             return $data;   
         } 
      
        public function EmailTemplateType($salonId=NULL){
            App::import("Model", "SalonEmailSms");
            $model = new SalonEmailSms(); 
            $model->recursive  = -1;
            $fields = array('email_format','business_nofity_provider','business_sms_notify_provider'); 
            $email_format  = $model->find('first',array('conditions'=>array('user_id'=>$salonId),'fields'=>$fields));
            if(count($email_format)==0){
              $email_format  = $model->find('first',array('conditions'=>array('user_id'=>1),'fields'=>$fields));
            }
            return $email_format;
        }
      
       function policyDetail($salon_id = NUll){
                    App::import("Model", "PolicyDetail");
                    $model = new PolicyDetail();  
                    $data = $model->find('first', array('conditions'=>array('user_id'=>$salon_id)));
                    if(count($data)==0){
                       $data = $model->find('first', array('conditions'=>array('user_id'=>1)));   
                    }
          return $data;       
        }
      
       function totalPoints($salon_id=NULL){
            App::import("Model", "UserCount");
            $model = new UserCount(); 
            $totalPoints = $model->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'),'salon_id'=>array($salon_id,1)),'fields'=>array('(sum(UserCount.user_count)) AS total')));                           
            $totalPoints = isset($totalPoints[0][0]['total'])?$totalPoints[0][0]['total']:0; 
            return $totalPoints;
       }
      
      function pointsValue(){
            App::import("Model", "PointSetting");
            $model = new PointSetting(); 
            $pointsVal = $model->find('first' , array('conditions'=>array('user_id'=>1)));
            return $pointsVal;  
      }
      
        function getServiceDetail($service_id=NULL){
          App::import("Model", "SalonService");
          $model = new SalonService(); 
          $model->recursive = -1;
          $serviceDetail = $model->findById($service_id);
          return $serviceDetail;
        }
      
        function get_Order($order_id=NULL){
            App::import("Model","Order");
            $model = new Order(); 
            $model->recursive = 1;
            $fields = array('Order.first_name' , 'Order.last_name','Order.phone_number','Order.display_order_id');
            $data = $model->find('first' , array('conditions'=>array('Order.id'=>$order_id), 'fields'=>$fields,'order' => array('Order.id DESC')));
            return $data;  
        }
      
        function get_voucherCode($order_id=NULL){
            App::import("Model", "Evoucher");
            $model = new Evoucher(); 
            $model->recursive  = -1;
            $fields = array('vocher_code');
            $data = $model->find('first' , array('conditions'=>array('order_id'=>$order_id), 'fields'=>$fields));
            return $data;  
        }
      
        public function email_sms_settings($salonId=NULL){
            App::import("Model", "SalonEmailSms");
            $model = new SalonEmailSms(); 
            $model->recursive  = -1;
            $fields = array('email_format'); 
            $email_format  = $model->find('first',array('conditions'=>array('user_id'=>$salonId),'fields'=>$fields));
            if(count($email_format)==0){
              $email_format  = $model->find('first',array('conditions'=>array('user_id'=>1),'fields'=>$fields));
            }
            return $email_format;
        }
      
        public function get_salonName($uid=NULL ){
            App::import("Model", "Salon");
            $model = new Salon(); 
            $model->recursive  = -1;
            $fields = array('eng_name');  
            $data = $model->find('first',array('conditions'=>array('user_id'=>$uid),'fields'=>$fields));
            return $data['Salon']['eng_name'];
        }
        
        
        
        function sendUserPhone($userData=array(), $orderData = array(), $message = '', $type=null){
             if($userData && $type =='vendor'){
                    $number = (isset($getData['Contact']['cell_phone']))?$getData['Contact']['cell_phone']:'';
                    $country_id = (isset($getData['Address']['country_id']))?$getData['Address']['country_id']:'';
                    if($country_id){
                           $country_code  =   $this->getPhoneCode($country_id);
                           if($country_code){
                              $number = str_replace("+","",$country_code).$number;    
                           }else{
                               $country_code = '+971';
                             $number = str_replace("+","",$country_code).$number;    
                           }
                     }
                        $this->sendVerificationCode($message,$number);
                }else if($type=='customer'){
                    $number = $orderData['Order']['phone_number'];
                    $this->sendVerificationCode($message,$number);
                }
            return true;
        }
        
        public function get_vendor_message($user_id = null){
            $vendor_msg = null;
            if(!empty($user_id)){
                App::import("Model", "SalonEmailSms");
                $this->SalonEmailSms = new SalonEmailSms();
                $vendor_msg_details = $this->SalonEmailSms->find('first',array(
                                        'conditions' => array('SalonEmailSms.user_id' => $user_id),
                                        'fields' => array('SalonEmailSms.client_email_content')
                                    ));
                if(!empty($vendor_msg_details)){
                    $vendor_msg = $vendor_msg_details['SalonEmailSms']['client_email_content'];
                } /*else {
                    $superadmin_msg_details = $this->SalonEmailSms->find('first',array(
                                        'conditions' => array('SalonEmailSms.user_id' => 1),
                                        'fields' => array('SalonEmailSms.client_email_content')
                                    ));
                    if(!empty($vendor_msg_details)){
                        $vendor_msg = $superadmin_msg_details['SalonEmailSms']['client_email_content'];
                    }
                }*/
            }
            return $vendor_msg;
        }
        
        function find_deal_services($serviceList = NULL,$type=NULL){
                App::import("Model", "DealServicePackage");
                $this->DealServicePackage = new DealServicePackage();
                $this->DealServicePackage->unBindModel(array('hasMany'=>'DealServicePackagePriceOption'));
                $this->DealServicePackage->bindModel(array('belongsTo'=>array('Deal')));
                $fields = array('DealServicePackage.salon_service_id');
                $deals =   $this->DealServicePackage->find('all',array('conditions'=>array('DealServicePackage.package_id'=>'', 'salon_service_id'=>$serviceList),'fields'=>$fields));
                //pr($deals); die;
                $deal = array();
                foreach($deals as $dealData){
                   $deal[] = $dealData['DealServicePackage']['salon_service_id'];
                } 
            return $deal;
        }
        
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
        
        function add_customer_to_salon($user_id,$salon_id){
            App::import("Model", "User");
            $this->User = new User();
            $userSalonCreated = $this->User->find('first',array('fields'=>'id','conditions'=>array('User.id'=>$user_id,'User.created_by'=>$salon_id)));
            
            if(empty($userSalonCreated)){
                App::import("Model", "UserToSalon");
                $this->UserToSalon = new UserToSalon();
                $isThereUser = $this->UserToSalon->find('first',array('conditions'=>array('UserToSalon.user_id' => $user_id, 'UserToSalon.salon_id' =>$salon_id)));
              
                if(empty($isThereUser)){
                    $usertosalon = array();
                    $usertosalon['UserToSalon']['user_id']  = $user_id;
                    $usertosalon['UserToSalon']['salon_id'] = $salon_id;
                    if($this->UserToSalon->save($usertosalon)){
                            App::import("Model", "Salon");
                            $this->Salon = new Salon();
                            $salonData = $this->Salon->find('first', array('fields' => array('Salon.eng_name'), 'conditions' => array('Salon.user_id' => $salon_id)));
                           // $toUserId = $this->request->data['User']['id'];
                            $user_info = $this->User->find('first', array('fields' => array('User.email','User.first_name','User.last_name','User.is_phone_verified','Contact.*'), 'conditions' => array('User.id' => $user_id)));
                            
                            if(!empty($user_info) && !empty($salonData))
                            {
                                $salonName = $salonData['Salon']['eng_name'];
                                $userName = $user_info['User']['first_name'];
                                $lastName = $user_info['User']['last_name'];
                                $mbNumber =  $user_info['Contact']['cell_phone']; 
                                $country_code  = $user_info['Contact']['country_code'];
                                if(!empty($mbNumber))
                                {
                                      $welcomeMessage = 'Hi '.$userName.', You have been successfully added in '.$salonName.'.';
                                      if($country_code){
                                         $mbNumber = str_replace("+","",$country_code).$mbNumber;    
                                      }
                                      //$this->sendVerificationCode($welcomeMessage,$mbNumber);
                                }
                                $toEmail    =   $user_info['User']['email'];
                                $fromEmail  =   Configure::read('fromEmail');
                                $dynamicVariables = array('{FirstName}'=>ucfirst($userName),'{LastName}'=>ucfirst($lastName), '{SN}' => ucfirst($salonName));
                               // $this->sendEmail($toEmail,$fromEmail,'customer_welcome_user',$dynamicVariables);
                                return true;
                            }
                    }else{
                        return false;
                    }
                }else{
                    return true;
                }
                
            }else{
                return true;
            }
         }
        
        
        function get_vendor_dues($orignal_amount=NULL ,$salon_id = NULL , $salon_percentage = NULL ,$servic_price=NULL){
                    $ret_data = array();
                    $ret_data['is_admin_tax']  =2; 
                    $tax_vendor = $this->getTax($salon_id);
                    if($tax_vendor['TaxCheckout']['user_id']  ==1){
                       $ret_data['is_admin_tax']  =1; 
                    }
                    $tax_admin = $this->getTax();
                    $tax = $tax_vendor['TaxCheckout']['tax1']+ $tax_vendor['TaxCheckout']['tax2'];
                            if($servic_price){
                             $ret_data['service_tax'] =  ($servic_price*$tax)/100;
                             $ret_data['service_price_tax'] = $ret_data['service_tax']+$servic_price;
                            }
                            $ret_data['tax_amount'] = ($orignal_amount*$tax)/100;
                            $tax_vendor['TaxCheckout']['tax1'] = ($tax_vendor['TaxCheckout']['tax1'])?$tax_vendor['TaxCheckout']['tax1']:0;
                            $ret_data['tax1_amount']  = ($orignal_amount*$tax_vendor['TaxCheckout']['tax1'])/100;
                            $ret_data['service_price_with_tax'] = $ret_data['tax_amount'] + $orignal_amount;
                    
                    App::import("Model", "PointSetting");
                    $model = new PointSetting();
                    $pointssetting = $model->find('first',array('conditions'=>array('id'=>1),'fields' => array('siesta_commision')));
                    $ret_data['sieasta_comission_price'] = $pointssetting['PointSetting']['siesta_commision'];
                    if($salon_percentage){
                        $ret_data['sieasta_comission_price'] = $ret_data['sieasta_comission_price']-$salon_percentage;
                    }
                    $ret_data['saloon_discount'] =  $ret_data['sieasta_comission_price'];
                    $ret_data['sieasta_comission']  =  ($orignal_amount*$ret_data['sieasta_comission_price'])/100;
                    $ret_data['total_deductions'] = $tax_admin['TaxCheckout']['deduction1'] + ($ret_data['service_price_with_tax']*$tax_admin['TaxCheckout']['deduction2'])/100;
                    $ret_data['vendors_dues'] = $orignal_amount - ($ret_data['sieasta_comission'] +  $ret_data['total_deductions']) +  $ret_data['tax1_amount'];
                    $ret_data['tax_admin'] = $tax_admin;
                    $ret_data['tax_vendor'] = $tax_vendor;
                    return $ret_data;
        }
        
        
        
        public function update_user_point($dataary=array()){
              // pr($dataary);
              $Order =array();
              App::import("Model","Order");
              $model = new Order();
              $model->recursive = -1;
              $orderData = $model->find('first' , array('conditions'=>array('id'=>$dataary['order_id']),'fields'=>array('vendor_dues','transaction_status','service_price_with_tax')));
              if(count($orderData)){
                    if($dataary['salon_point']){
                        $Order['salon_point_price'] = $this->get_price_from_point($dataary['salon_point']);
                        $Order['vendor_dues'] =  $orderData['Order']['vendor_dues']-$Order['salon_point_price'];
                    }
                    if($dataary['sieasta_point']){
                        $Order['sieasta_point_price'] = $this->get_price_from_point($dataary['sieasta_point']);
                    }
                     
                    if($orderData['Order']['transaction_status']==5){
                        $Order['vendor_dues'] = $orderData['Order']['vendor_dues'] - $orderData['Order']['service_price_with_tax'];
                        if((isset( $Order['sieasta_point_price']) && !empty($Order['sieasta_point_price'])) &&(empty($Order['salon_point_price']))){
                             $Order['vendor_dues'] = $orderData['Order']['vendor_dues'];
                        }else if(isset( $Order['sieasta_point_price']) && !empty($Order['sieasta_point_price'])){
                          $Order['vendor_dues'] = $Order['vendor_dues'] + $Order['sieasta_point_price'];
                        }
                    }
                  
                    if($dataary['order_id']){
                      $model->id = $dataary['order_id'];
                      $model->save($Order,false);
                    }
               }
             return true;  
        }
        
        function get_gift_amount($gift_id){
              App::import("Model","GiftCertificate");
              $model = new GiftCertificate();
              $model->recursive = -1;
              $fields = array('amount');
              $giftAmount = $model->find('first' , array('conditions'=>array('id'=>$gift_id),'fields'=>$fields));
              return $giftAmount['GiftCertificate']['amount'];
        } 
        
        function check_services($salon_id = NULL){
              App::import("Model","SalonService");
              $model = new SalonService();
              $model->recursive = -1; 
              $count = $model->find('count',array(
                                            'conditions'=>array(
                                                'SalonService.salon_id'=>$salon_id,
                                                'SalonService.is_deleted'=>0,
                                                'SalonService.status'=>1,
                                                'SalonService.parent_id !='=> 0
                                                )
                                            )
                                    );
             if($count){
               return 'Please deactivate or delete all Service associated with this salon.';
             }else{
                return $this->check_deals($salon_id);
             }
        }
        
        function check_deals($salon_id = NULL){
              App::import("Model","Deal");
              $model = new Deal();
              $model->recursive = -1; 
              $count = $model->find('count',array(
                                            'conditions'=>array(
                                                'Deal.salon_id'=>$salon_id,
                                                'Deal.is_deleted'=>0,
                                                'Deal.status'=>1)
                                            )
                                    );
             if($count){
               return 'Please deactivate or delete all Deals associated with this salon.';
             }else{
                return $this->check_packages($salon_id);
             }
        }
        
        function check_packages($salon_id = NULL){
              App::import("Model","Package");
              $model = new Package();
              $model->recursive = -1; 
              $count = $model->find('count',array(
                                            'conditions'=>array(
                                                'Package.user_id'=>$salon_id,
                                                'Package.is_deleted'=>0,
                                                'Package.status'=>1)
                                            )
                                    );
             if($count){
               return "Please deactivate or delete all Package/Spadays associated with this salon.";
             }else{
                return $this->check_spabreaks($salon_id);
             }
        }
        
        function check_spabreaks($salon_id = NULL){
              App::import("Model","Spabreak");
              $model = new Spabreak();
              $model->recursive = -1; 
              $count = $model->find('count',array(
                                            'conditions'=>array(
                                                'Spabreak.user_id'=>$salon_id,
                                                'Spabreak.is_deleted'=>0,
                                                'Spabreak.status'=>1)
                                            )
                                    );
             if($count){
               return "Please deactivate or delete all Spabreaks associated with this salon.";
             }else{
                return $count;
             }
        }
        
       function check_appointments($salon_id){
              App::import("Model","Appointment");
              $model = new Appointment();
              $model->recursive = -1; 
              $count = $model->find('count',array(
                                            'conditions'=>array(
                                                'Appointment.user_id'=>$salon_id,
                                                'Appointment.is_deleted'=>0,
                                                'Appointment.status'=>1)
                                            )
                                    );
             if($count){
               return "Please deactivate or delete all Spabreaks associated with this salon.";
             }else{
                return $count;
             }
       }
       
     function check_frenchises($salon_id){
        App::import("Model","User");
        $model = new User();
        $model->recursive = -1; 
        $count  = $model->find('count', array('conditions'=>array('User.id'=>$salon_id,'User.type'=>2)));
        if($count){
            //$vendors = $model->find('count',array('conditions'=>array()));
         }else{
          return $count;  
        }
     }  
     
     function check_customer($salon_id,$user_id){
       App::import("Model","Appointment");
       $model = new Appointment();
       $model->recursive = -1; 
       $current_date =time();
       $conditions =array('by_vendor'=>0,'user_id'=>$user_id,'appointment_start_date >= ' => $current_date,'status'=>4,'payment_status'=>2); 
        if($salon_id != 1){
         $conditions['salon_id'] =  $salon_id;
        }
        $count = $model->find('count',array('conditions'=>$conditions));
        if($count){
           return 'Customer have some future appointments with us, Please complete all appointments first.';
         }else{
           return $this->check_voucher($salon_id,$user_id);
        } 
     }
     
     function check_voucher($salon_id,$user_id){
       App::import("Model","Evoucher");
       $model = new Evoucher();
       $model->recursive = -1; 
       $current_date = date(y-m-d);
       $conditions = array('user_id'=>$user_id,'expire >= ' => $current_date,'used'=>0);
       if($salon_id != 1){
         $conditions['salon_id'] =  $salon_id;
       }
       $count = $model->find('count',array('conditions'=>array($conditions)));
        if($count){
             return 'Customer have valid evochers,Untill he used, you can not delete cutomer.';
         }else{
           return $this->check_spabreakUser($salon_id,$user_id);
        } 
     }
     
    function check_spabreakUser($salon_id,$user_id){
              App::import("Model","Order");
              $model = new Order();
              $model->recursive = -1; 
              $conditions = array(
                                    'service_type'=>4,
                                    'start_date > ' => $current_date,
                                    'transaction_status'=>array(1,5,6,7,8),
                                    'user_id'=>$user_id,
                                 ); 
              if($salon_id != 1){
                $conditions['salon_id'] =  $salon_id;
              }
              $count = $model->find('count',array(
                                            'conditions'=>$conditions
                                            )
                                    );
            if($count){
              return "You can not delete customer beacuse he has future booking for the Spabreak.";
            }else{
               return $this->check_iou($salon_id,$user_id);
            }
    }
    
    function check_iou($salon_id,$user_id){
        App::import("Model","Iou");
        $model = new Iou();
        $model->bindModel(array('belongsTo'=>array('Order')));
        $conditions = array('Iou.status'=>0,'Iou.user_id'=>$user_id,'Iou.is_deleted'=>0);
        if($salon_id != 1){
                $conditions['Order.salon_id'] = $salon_id;
        }
        $count = $model->find('count',array('conditions'=>$conditions));
        if($count){
            return "You can not delete customer beacuse he has not paid all iou balance.";
        }else{
           return $count;
        } 
    }
    
    
    function check_stylist($salon_id,$stylist_id){
       App::import("Model","Appointment");
       $model = new Appointment();
       $model->recursive = -1; 
       $current_date =time();
       $conditions =array('salon_id'=>$salon_id,'by_vendor'=>0,'salon_staff_id'=>$stylist_id,'appointment_start_date >= ' => $current_date,'status'=>4,'payment_status'=>2); 
        $count = $model->find('count',array('conditions'=>array($conditions)));
        if($count){
             return 'You can not delete this stylist , As this stylist has some future appointments.';
         }else{
           return $count;
        } 
    }
   
 }
