<?php
class StaticPagesController extends AppController {
    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Captcha'=>array('Model'=>'Feedback', 
'field'=>'captcha')); //An array containing the names of components this controller uses.

    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('legal','pages','contact_us','feedback','business_enquiry','dropzone','captcha','sitemap');
    }
    
/**********************************************************************************    
  @Function Name : admin_pages
  @Params	 : NULL
  @Description   : For Displaying the Static pages of the Admin
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/
    public function admin_pages() {
        $this->layout = 'admin';
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'CMS Pages'=>array('controller'=>'StaticPages','action'=>'pages','admin'=>true),
                        );
        $this->set('breadcrumb',$breadcrumb);
        $created_by = $this->Auth->user('id');
        $pages = $this->StaticPage->find('all',array('fields'=>array('StaticPage.id','StaticPage.alias','StaticPage.eng_name','StaticPage.eng_title','StaticPage.ara_name','StaticPage.ara_title','StaticPage.status'),'conditions'=>array('StaticPage.created_by'=>$created_by,'StaticPage.is_deleted'=>0)));
        $this->set(compact('pages'));
        $this->set('page_title','CMS Pages');
        $this->set('activeTMenu','cmsPage');
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/cmsPages";
            $this->render('list_cms_page');
            
        }
    }
    
    /**********************************************************************************    
      @Function Name : legal
      @Params	 : NULL
      @Description   : For Showing Legal for the Sieasta
      @Author        : Aman Gupta
      @Date          : 02-Feb-2014
    ***********************************************************************************/   
    public function legal($id=NULL) {
        if($id){
            $pageDetail = $this->StaticPage->findById($id);
            $this->set('title_for_layout', $pageDetail['StaticPage']['eng_title']);
            $this->set(compact('pageDetail'));
        }
        else{
            $this->redirect(array('controller'=>'homes','action'=>'index','admin'=>false));
        }

    }
/**********************************************************************************    
  @Function Name : admin_addPage
  @Params	 : $id = Page Id 
  @Description   : For Adding/Editing Static Pages
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/    
    public function admin_addPage($id = NULL){
        $this->layout = 'ajax';
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'CMS Pages'=>array('controller'=>'StaticPages','action'=>'pages','admin'=>true),
                        );
        if($id){
            $pageDetail = $this->StaticPage->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        }else{
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        
        if($this->request->is('post') || $this->request->is('put')){
            //parse_str($this->request->data,$data);
            $data = $this->request->data;
            if(!empty($data['StaticPage']['id'])){
                $this->StaticPage->id = $data['StaticPage']['id'];
                //unset($this->request->data['StaticPage']['created_by']);
            }else{
                $data['StaticPage']['created_by'] = $this->Auth->user('id');
                $this->StaticPage->create();
            }
            if($this->StaticPage->save($data)){
                $edata['data'] = 'success' ;
                $edata['message'] = __('page_save_success',true);
                echo json_encode($edata);
                die;
                //$this->redirect(array('controller'=>'StaticPages','action'=>'pages','admin'=>true));
            }else{
                $message = __('unable_to_save', true);
                $vError = $this->StaticPage->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
                //$this->Session->setFlash(__('unable_to_save',true),'flash_error');
            }
        }
        
        if(!$this->request->data && isset($pageDetail)){
            $this->request->data = $pageDetail;
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_changeStatus
  @Params	 : NULL
  @Description   : Change Status via Ajax
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/    
    public function admin_changeStatus() {
        $this->autoRender = false;
        if($this->request->is('post')){
            if($this->StaticPage->updateAll(array('StaticPage.status'=>$this->request->data['status']),array('StaticPage.id'=>$this->request->data['id']))){
                return $this->request->data['status'];
            }
        }
        
    }
    
/**********************************************************************************    
  @Function Name : admin_viewPage
  @Params	 : $id = Page Id ,$alias=page alias
  @Description   : View of CMS Pages
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/    
    public function admin_viewPage($id=NULL) {
        $this->layout = "ajax";
        if($id){
            $page = $this->StaticPage->findById($id);
            $this->set(compact('page'));
        }
        else{
            $this->Session->setFlash(__('page_not_found',true),'flash_error');
            $this->redirect(array('controller'=>'StaticPages','action'=>'pages','admin'=>true));
        }
    }
    

/**********************************************************************************    
  @Function Name : admin_deletePage
  @Params	 : NULL
  @Description   : Delete of CMS Pages
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/
    public function admin_deletePage() {
        $this->autoRender = "false";
        if($this->request->is('post') || $this->request->is('put')){
            $id = $this->request->data['id'];
            $page = $this->StaticPage->findById($id);
            if(!empty($page)){
                if($this->StaticPage->updateAll(array('StaticPage.is_deleted'=>1),array('StaticPage.id'=>$id))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('delete_success',true);
                }
                else{
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unable_to_delete',true);
                    
                }
            }else{
                $edata['data'] = 'error' ;
                $edata['message'] = __('page_not_found',true);
            }
        }
        echo json_encode($edata);
        die;
        
    }
    
    
  
/**********************************************************************************    
  @Function Name : admin_salonPages
  @Params	 : $id = Page Id ,$alias=page alias
  @Description   : This function is for  Displaying the Static pages of the Salons
  @Author        : Shibu Kumar Bhat
  @Date          : 14-Nov-2014
***********************************************************************************/
    public function admin_salonPages() {
        $this->layout = 'admin';
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Salon CMS Pages'=>array('controller'=>'StaticPages','action'=>'salonPages','admin'=>true),
                        );
        $this->set('breadcrumb',$breadcrumb);
        $created_by = $this->Auth->user('id');
        $condition = array('StaticPage.created_by '=>$created_by);
        if($this->Auth->user('type') == 1){
           $condition = array('StaticPage.created_by !='=>$this->Auth->user('id'));
        }
        $pages = $this->StaticPage->find('all',array('recursive'=>2,'conditions'=>$condition));
        $this->set(compact('pages'));
        $this->set('page_title','Salon CMS Pages');
        $this->set('activeTMenu','salonPage');
        $this->set('leftMenu',true);
         if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/cmsPages";
            $this->render('list_salon_cms_pages');
            
        }
    }
    
    
     
    /*     * ********************************************************************************    
      @Function Name : admin_room
      @Params        : NULL
      @Description   : function to show list of rooms per Salon
      @Author        : Shibu
      @Date          : 8-Jan-2015
     * ********************************************************************************* */

     function admin_room(){
	$this->layout = 'admin';
         $this->loadModel('SalonRoom');
             $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Settings'=>array('controller'=>'Settings','action'=>'email_setting','admin'=>true),
                        'Rooms'=>'javascript:void(0)',
                        );
        $this->set('breadcrumb',$breadcrumb);
        $created_by = $this->Auth->user('id');
        $condition = array('SalonRoom.user_id '=>$created_by,'SalonRoom.is_deleted '=>0);
        $rooms = $this->SalonRoom->find('all',array('recursive'=>2,'conditions'=>$condition));
        $this->set(compact('rooms'));
        $this->set('page_title','Rooms Listing');
        $this->set('activeTMenu','room');
         if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Settings";
            $this->render('list_admin_rooms');
            
        }
	
     }
     
     
    /**********************************************************************************    
      @Function Name : admin_room
      @Params        : NULL
      @Description   : function to add rooms
      @Author        : Shibu
      @Date          : 8-Jan-2015
    ********************************************************************************** */

     function admin_add_room($id=null){
	$this->layout   =   'ajax';
        $this->loadModel('SalonRoom');
        
         if($id){
            $pageDetail = $this->SalonRoom->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        }else{
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        
        if($this->request->is('post') || $this->request->is('put')){
            //parse_str($this->request->data,$data);
            $data = $this->request->data;
            if(!empty($data['SalonRoom']['id'])){
                $this->StaticPage->id = $data['SalonRoom']['id'];
            }else{
                $data['SalonRoom']['user_id'] = $this->Auth->user('id');
                $this->SalonRoom->create();
            }
            if($this->SalonRoom->save($data)){
                $edata['data'] = 'success' ;
                $edata['message'] = __('page_save_success',true);
                echo json_encode($edata);
                die;
            }else{
                $message = __('unable_to_save', true);
                $vError = $this->SalonRoom->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
	if(!$this->request->data && isset($pageDetail)){
            $this->request->data = $pageDetail;
        }
     }
     
     
     
     /**********************************************************************************    
  @Function Name : admin_deleteRoom
  @Params	 : NULL
  @Description   : Delete of Room
  @Author        : Shibu Kumar
  @Date          : 8-jan-2014
***********************************************************************************/
    public function admin_delete_room() {
        $this->autoRender = "false";
        $this->loadModel('SalonRoom');
        if($this->request->is('post') || $this->request->is('put')){
            $id = $this->request->data['id'];
            $page = $this->SalonRoom->findById($id);
            if(!empty($page)){
                if($this->SalonRoom->updateAll(array('SalonRoom.is_deleted'=>1),array('SalonRoom.id'=>$id))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('delete_success',true);
                }
                else{
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unable_to_delete',true);
                    
                }
            }else{
                $edata['data'] = 'error' ;
                $edata['message'] = __('page_not_found',true);
            }
        }
        echo json_encode($edata);
        die;
        
    }
    
    
    
    public function pages($id = null){
         if($id){
            $pageDetail = $this->StaticPage->findById($id);
            $this->set(compact('pageDetail'));
        }
        else{
            $this->redirect(array('controller'=>'homes','action'=>'index','admin'=>false));
        }
       
    }
    
    
    public function contact_us() {

    }
    public function feedback() {
        $this->loadModel('Feedback');
        $this->Feedback->set($this->request->data);
        if($this->request->is('Put')||$this->request->is('Post')){
            
            $this->Feedback->setCaptcha('captcha', $this->Captcha->getCode('Feedback.captcha')); 
            if($this->Feedback->saveAll($this->request->data)){
                $feedbackId = $this->Feedback->id;
                $this->sendFeedbackEmail($feedbackId);
                $this->Session->setFlash("Feeback submit successfully.",'flash_success');
                $this->redirect(array('controller'=>'static_pages','action'=>'feedback','admin'=>false));    
            }
            else{
               $this->Session->setFlash("Oops!!! there was some error",'flash_error');
            }
        }
    }
    
    
     /*     * ********************************************************************************    
      @Function Name : sendFeedbackEmail
      @Params	 : NULL
      @Description   : The Function is used for Sending Email
      @Author        : Navish
      @Date          : 15-May-2015
     ********************************************************************************** */

    function sendFeedbackEmail($feedbackId=null,$tempate='feedback_email') {
        $this->autoRender = false;
        $this->loadModel('Feedback');
        if ($feedbackId != null) {
        $FeedbackData = $this->Feedback->find('first', array('conditions' => array('Feedback.id' => $feedbackId)));
                if(!empty($FeedbackData)){
                $name = $FeedbackData['Feedback']['name'];
                $phone_number =   $FeedbackData['Feedback']['phone_number'];
                $category =   $FeedbackData['Feedback']['category'];
                $priority =   $FeedbackData['Feedback']['priority'];
                $email =   $FeedbackData['Feedback']['email'];
                $suggestions =   $FeedbackData['Feedback']['suggestions'];
                $attached_file =   $FeedbackData['Feedback']['attached_file'];
                $fromEmail  =   Configure::read('fromEmail');
                $toEmail  =   'support@sieasta.com';
                $dynamicVariables = array('{Name}'=>ucfirst($name),'{Category}'=>ucfirst($category), '{Priority}' => ucfirst($priority), '{Phone}' => ucfirst($phone_number), '{Email}' => ucfirst($email), '{Suggestions}' => ucfirst($suggestions), '{AttachedFile}' => ucfirst($attached_file));
                $this->Common->sendEmail($toEmail,$fromEmail,$tempate,$dynamicVariables);
            }
        }
    }
    
    public function business_enquiry() {
        $this->loadModel('BusinessEnquiry');
        $this->BusinessEnquiry->set($this->request->data);
        if($this->request->is('Put')||$this->request->is('Post')){
            if($this->BusinessEnquiry->saveAll($this->request->data)){
                $b_enquiryId = $this->BusinessEnquiry->id;
                $this->sendBusinessEmail($b_enquiryId);
                $this->Session->setFlash("Business enquety submit successfully.",'flash_success');
                $this->redirect(array('controller'=>'static_pages','action'=>'business_enquiry','admin'=>false));    
            }
            else{
               $this->Session->setFlash("Oops!!! there was some error",'flash_error');
            }
        }
    }
    
     /*     * ********************************************************************************    
      @Function Name : sendBusinessEmail
      @Params	 : NULL
      @Description   : The Function is used for Sending Email
      @Author        : Navish
      @Date          : 15-May-2015
     ********************************************************************************** */

    function sendBusinessEmail($b_enquiryId=null,$tempate='business_enqury_email'){
        $this->autoRender = false;
        $this->loadModel('BusinessEnquiry');
        if ($b_enquiryId != null) {
        $BusinessEnquiryData = $this->BusinessEnquiry->find('first', array('conditions' => array('BusinessEnquiry.id' => $b_enquiryId)));
                if(!empty($BusinessEnquiryData)){
                $name = $BusinessEnquiryData['BusinessEnquiry']['name'];
                $company =   $BusinessEnquiryData['BusinessEnquiry']['company'];
                $nature_of_business =   $BusinessEnquiryData['BusinessEnquiry']['nature_of_business'];
                $contact_phone =   $BusinessEnquiryData['BusinessEnquiry']['contact_phone'];
                $email =   $BusinessEnquiryData['BusinessEnquiry']['email'];
                $detail_query  =   $BusinessEnquiryData['BusinessEnquiry']['detail_query'];
                $contact_address  =   $BusinessEnquiryData['BusinessEnquiry']['contact_address'];
                $fromEmail  =   Configure::read('fromEmail');
                $toEmail  = 'business@sieasta.com';
                $dynamicVariables = array('{Name}'=>ucfirst($name),'{Company}'=>ucfirst($company), '{Nature}' => ucfirst($nature_of_business), '{Phone}' => ucfirst($contact_phone), '{Email}' => ucfirst($email), '{Query}' => ucfirst($detail_query), '{Contact_Address}' => ucfirst($contact_address));
                $this->Common->sendEmail($toEmail,$fromEmail,$tempate,$dynamicVariables);
            }
        }
    }
    
    public function admin_enquiryDetail()
    {
        $this->layout = 'admin';
        $this->loadModel('BusinessEnquiry');
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Business Enquiries'=>array('controller'=>'StaticPages','action'=>'enquiryDetail','admin'=>true),
                       );
        $conditions = array('is_deleted'=>0);
        $getFields = array('BusinessEnquiry.*');
        $allEnquiries =  $this->BusinessEnquiry->find('all' , array('conditions' =>$conditions,'order'=>'id DESC'));
        $this->set(compact('allEnquiries'));
        $this->set('page_title',' Business Enquiries');
         $this->set('activeTMenu','blog');
         $this->set('leftMenu',true);
         if($this->request->is('ajax')){
             $this->layout = 'ajax';
             $this->viewPath = "Elements/admin/StaticPages";
             $this->render('enquiryList');
         }
    }
    
    public function admin_viewEnqueryDetail($enquiryID=NULL){
        $this->loadModel('BusinessEnquiry');
    if($enquiryID==NULL){
     throw new NotFoundException('Could not find that Enquiry');
    }
    $this->layout ='ajax';
    $BusinessEnquiry = $this->BusinessEnquiry->findById($enquiryID);
    if(!$BusinessEnquiry){
     throw new NotFoundException(__('page_not_found',true));
    }
    $page_title = "Enquiry Detail";
    $this->set(compact('page_title','BusinessEnquiry'));
    }
    
    function dropzone()
    {
        $this->layout = '';
        if($this->params){
            $file = $this->params->form['file'];
        }
    }
    
    
    function captcha(){
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if you didn't load in the header
		    $this->Captcha = $this->Components->load('Captcha'); //load it
		}
		$this->Captcha->create();
    }
    
    
    
    public function sitemap(){
        $this->layout = 'basic';
        
        $this->loadModel('User');
        $this->User->unbindModel(
            array('belongsTo' => array('Group'),
                'hasOne' => array('Address','UserDetail','Contact'),
                'hasMany' => array('PricingLevelAssigntoStaff')
            )
        );
        
        $salons = $this->User->find('all',array(
                'conditions' => array(
                        'User.type' => 4,
                        'User.is_deleted' => 0,
                        'User.is_email_verified' => 1,
                        'User.is_phone_verified' => 1,
			'User.front_display' =>1,
                ),
                'fields' => array('User.id','Salon.eng_name','Salon.ara_name','Salon.business_url')
            )
        );
        
        
        $today = date('Y-m-d');
        
        $deals_salon = array();
        $packages_salon = array();
        $services_salon = array();
        $spadays_salon = array();
        $gcs_salon = array();
        $staff_salon = array();
        
        if(!empty($salons)){
            $this->loadModel('ServiceDeal');
            $this->loadModel('Package');
            $this->loadModel('SalonService');
            $this->loadModel('GiftCertificate');
            foreach($salons as $salon_index => $salon){
                /************ SALON WITH DEALS ************/
                $this->ServiceDeal->unbindModel(
                    array(
                        'hasMany' => array('DealPricingOption','DealImage' )
                    )
                );
                $salon_deals[$salon['User']['id']] = $this->ServiceDeal->find('first',
                                                    array(
                                                        'conditions' => array(
                                                            'ServiceDeal.is_deleted' => 0,
                                                            'ServiceDealDetail.is_deleted' => 0,
                                                            'ServiceDeal.salon_id' => $salon['User']['id'],
                                                            //"ServiceDeal.max_date <= '".$today."'"
                                                        ),
                                                        'fields' => array('ServiceDeal.id','ServiceDealDetail.id')
                                                    )
                                                );
                
                if(!empty($salon_deals[$salon['User']['id']])){
                    $deals_salon[] = $salons[$salon_index];
                }
                /************ END OF SALON WITH DEALS ************/
                
                
                /************ SALON WITH Packages ************/
                $this->Package->unbindModel(
                    array(
                        'hasMany' => array('PackageService','SalonStaffPackage')
                    )
                );
                $salon_packages[$salon['User']['id']] = $this->Package->find('first',
                                                    array(
                                                        'conditions' => array(
                                                            'Package.is_deleted' => 0,
                                                            'Package.type' => 'Package',
                                                            'Package.status' => 1,
                                                            'Package.user_id' => $salon['User']['id'],
                                                        ),
                                                        'fields' => array('Package.id',)
                                                    )
                                                );
                
                if(!empty($salon_packages[$salon['User']['id']])){
                    $packages_salon[] = $salons[$salon_index];
                }
                /************ END OF SALON WITH Packages ************/
                
                
                
                
                /************ SALON WITH Spaday ************/
                $this->Package->unbindModel(
                    array(
                        'hasMany' => array('PackageService','SalonStaffPackage')
                    )
                );
                $salon_spadays[$salon['User']['id']] = $this->Package->find('first',
                                                    array(
                                                        'conditions' => array(
                                                            'Package.is_deleted' => 0,
                                                            'Package.type' => 'Spaday',
                                                            'Package.status' => 1,
                                                            'Package.user_id' => $salon['User']['id'],
                                                        ),
                                                        'fields' => array('Package.id',)
                                                    )
                                                );
                
                if(!empty($salon_spadays[$salon['User']['id']])){
                    $spadays_salon[] = $salons[$salon_index];
                }
                /************ END OF SALON WITH Spaday ************/
                
                /************ SALON WITH SERVICES ************/
                $this->SalonService->unbindModel(
                    array(
                        'hasMany' => array('ServicePricingOption',
                                           'SalonStaffService','SalonServiceResource',
                                           'PackageService','SalonServiceImage'),
                        'hasOne' => array('SalonServiceDetail')
                    )
                );
                $salon_services[$salon['User']['id']] = $this->SalonService->find('first',
                                                    array(
                                                        'conditions' => array(
                                                            'SalonService.is_deleted' => 0,
                                                            'SalonService.status' => 1,
                                                            'SalonService.salon_id' => $salon['User']['id'],
                                                        ),
                                                        'fields' => array('SalonService.id',)
                                                    )
                                                );
                
                if(!empty($salon_services[$salon['User']['id']])){
                    $services_salon[] = $salons[$salon_index];
                }
                /************ END OF SALON WITH SERVICES ************/
                
                /************ SALON WITH GIFT CERTIFICATES ***********
                $this->GiftCertificate->unbindModel(
                    array(
                        'hasMany' => array('ServicePricingOption',
                                           'SalonStaffService','SalonServiceResource',
                                           'PackageService','SalonServiceImage'),
                        'hasOne' => array('SalonServiceDetail')
                    )
                );*/
                $salon_gcs[$salon['User']['id']] = $this->GiftCertificate->find('first',
                                                    array(
                                                        'conditions' => array(
                                                            'GiftCertificate.is_deleted' => 0,
                                                            'GiftCertificate.salon_id' => $salon['User']['id'],
                                                            "GiftCertificate.expire_on <= '".$today."'"
                                                        ),
                                                        'fields' => array('GiftCertificate.id',)
                                                    )
                                                );
                
                if(!empty($salon_gcs[$salon['User']['id']])){
                    $gcs_salon[] = $salons[$salon_index];
                }
                /************ END OF SALON WITH GIFT CERTIFICATES ************/
                
                
                
                /************ SALON WITH STAFF ************/
                $this->User->unbindModel(
                    array(
                        'hasMany' => array('PricingLevelAssigntoStaff'),
                    )
                );
                $salon_staff[$salon['User']['id']] = $this->User->find('all',
                                                    array(
                                                        'conditions' => array(
                                                            'User.is_deleted' => 0,
                                                            'User.parent_id' => $salon['User']['id'],
                                                            "User.type" => 5,
                                                            'User.status' => 1,
                                                            'User.is_email_verified' => 1,
                                                            'User.is_phone_verified' => 1
                                                        ),
                                                        'fields' => array('User.id',)
                                                    )
                                                );
                
                if(!empty($salon_staff[$salon['User']['id']])){
                    $staff_salon[] = $salons[$salon_index];
                }
                /************ END OF SALON WITH STAFF ************/
                
                
            }
        }
        
        $this->set(compact('deals_salon','packages_salon','services_salon','gcs_salon','staff_salon','spadays_salon'));
       // pr($salon_services);
        
    }
    
    
}
