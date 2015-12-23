<?php
App::import('Controller', 'Users');
class GiftCertificatesController extends AppController {

    public $helpers = array('Session', 'Html', 'Form','Paginator'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'RequestHandler', 'Cookie', 'Image','Paginator', 'Common', 'PHPMailer', 'Acl','Crypto'); //An array containing the names of components this controller uses.
    public $uses = array('GiftCertificate');
    
    public function beforeFilter() {
        $this->Auth->allow('index', 'image_category', 'show_preview','save_image','gift_cart','save_send_email');
    }

    public function admin_addCertificate(){
        $logged_in_user = $this->Session->read('Auth.User.id');
         $logged_in_user_type = $this->Session->read('Auth.User.type');
       /*  Set Sender Array *****/
        if(!empty($logged_in_user) && !empty($logged_in_user_type)){
            
            $this->loadModel('User');
            $cond['User.type'] = Configure::read('USER_ROLE');
            $userType = $this->Auth->user('type');
            $parentID = $this->Auth->user('id');
            if($userType != Configure::read('SUPERADMIN_ROLE')){
                $cond = $this->mergingCond4UserType($cond);
            }
            //$this->User->unbindModel(array(
            //                        'hasMany'=>array('PricingLevelAssigntoStaff'),
            //                        'belongsTo' =>array('Group'),
            //                        'hasOne'=>array('Salon','Address','UserDetail','Contact')
            //                        ));
            //
            //if($logged_in_user == 1 && $logged_in_user_type == 1){
            //   $sender_condition = array('User.is_deleted'=>0,
            //            'User.is_email_verified' => 1,
            //            'User.is_phone_verified' => 1,
            //            'User.status' => 1,
            //        );
            //   
            //    $sender = $this->User->find('all',array(
            //        'conditions'=>$sender_condition,
            //        'fields' => array('User.id','User.first_name','User.last_name','User.email'),
            //        'order' => array('User.first_name ASC','User.last_name ASC','User.email ASC')
            //    ));
            //} else if($logged_in_user_type == 4 || $logged_in_user_type == 5){
            //    $this->loadModel('User');
            //    $parent_id = $this->Session->read('Auth.User.parent_id');
            //    
            //    if($parent_id){
            //        $ownerArr[] = $parent_id;    
            //    }
            //    $ownerArr[] = $logged_in_user;
            //    
            //    $this->getSalonUsers($ownerArr);
            //    $sender_condition = array('User.is_deleted'=>0,
            //            'User.is_email_verified' => 1,
            //            //'User.is_phone_verified' => 1,
            //            'User.status' => 1,
            //            'User.type' => 6,
            //            'OR'=>array(
            //                'User.created_by' =>$ownerArr,
            //                'User.id' =>$this->getSalonUsers($ownerArr)
            //            )
            //        );
                
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
        /******* End Set Sender Array *****/
        
        $this->layout = 'ajax';
        $user = $this->Auth->user('id');
        if ($this->request->is('post') || $this->request->is('put')) {
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
        }
        $this->set(compact('senderArr'));
        $this->set('user_id',$this->Auth->user('id'));
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
        
         
        //$typeId = $this->Auth->user('type');
        //if(($typeId == 4 )) //for Individual Salon OR Under Any Frenchise
        //{
        //    
        //    $cond = array('OR'=>
        //                array(
        //                    'User.id'=>$InUserList ,
        //                    array_merge( $cond , array( 'User.created_by'=>$this->Auth->user('id')))
        //                    )
        //                );
        //}
        //if($typeId == 2 ) //for Frenchise
        //{
        //    
        //    $cond = array('OR'=>
        //                array(
        //                    'User.id'=>$InUserList ,
        //                    array_merge( $cond , array( 'User.created_by'=>$this->Auth->user('id')))
        //                    )
        //                );
        //}
        //if($typeId == 3 ) //for MultiStore
        //{
        //    //$cond = array_merge($cond,array('User.created_by'=>array()));    
        //}
        return $cond;
    }
    
    
    
    public function getSalonUsers($salon_id = array()){
        //$this->UserToSalon->bindModel(array('belongsTo'=>array('User')));
                $this->loadModel('UserToSalon');
                 $sender = $this->UserToSalon->find('list',array(
                    'conditions'=>array('UserToSalon.salon_id'=>$salon_id,'UserToSalon.status'=>1),
                    'fields' => array('UserToSalon.user_id')));
                return $sender;    
    }
    
    
    public function admin_list() {
        App::import('Controller', 'GiftCertificate');
        $logged_in_user = $this->Session->read('Auth.User.id');
        $conditions = array('GiftCertificate.is_deleted'=>"0","GiftCertificate.created_by" => $logged_in_user);
	if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	}
	if(!empty($src_keywrd)){
	   $conditions = array('GiftCertificate.is_deleted'=>"0","GiftCertificate.created_by" => $logged_in_user,
			       'OR'=>array(
				    'GiftCertificate.first_name LIKE "%'.$src_keywrd.'%"',
				    'GiftCertificate.last_name LIKE "%'.$src_keywrd.'%"',
				    'GiftCertificate.email LIKE "%'.$src_keywrd.'%"',
				    'Sender.first_name LIKE "%'.$src_keywrd.'%"',
				    'Sender.last_name LIKE "%'.$src_keywrd.'%"',
				    'Sender.email LIKE "%'.$src_keywrd.'%"',
				    'Recepient.first_name LIKE "%'.$src_keywrd.'%"',
				    'Recepient.last_name LIKE "%'.$src_keywrd.'%"',
				    'Recepient.email LIKE "%'.$src_keywrd.'%"',
				));
	}
	
	/************** Set page limit ************/
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
	
	/**************** End of set page limit *******************/
	
	$this->params->data['number_records'] = $number_records;
    
        $this->layout   =   'admin_paginator';
        //$this->loadModel('GiftCertificate');
	$fields = array('GiftCertificate.id',
                        'GiftCertificate.user_id',
                        'GiftCertificate.sender_id',
                        'GiftCertificate.recipient_id',
                        'GiftCertificate.first_name',
                        'GiftCertificate.last_name',
                        'GiftCertificate.gift_certificate_no',
                        'GiftCertificate.expire_on',
                        'GiftCertificate.email',
                        'GiftCertificate.gift_image_id',
                        'GiftCertificate.gift_image_category_id',
                        'GiftCertificate.messagetxt',
                        'GiftCertificate.amount',
						'GiftCertificate.total_amount',
                        'GiftCertificate.image',
                        'GiftCertificate.created',
                        'Sender.id',
                        'Sender.first_name',
                        'Sender.last_name',
                        'Sender.email ',
                        'Recepient.id',
                        'Recepient.first_name',
                        'Recepient.last_name',
                        'Recepient.email ',
                        'Created.id',
                        'Created.first_name',
                        'Created.last_name',
                        'Created.email ',
		);
	
        $this->loadModel('GiftCertificate');
        
	$this->Paginator->settings = array(
		'GiftCertificate' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('GiftCertificate.created' => 'desc')
		)
	    );
	
        $this->GiftCertificate->bindModel(array(
                    'belongsTo'=>array(
                        'Sender'=>array(
                            'foreignKey'=>'sender_id',
                            'className' => 'User'
                        ),
                        'Recepient'=>array(
                            'foreignKey'=>'recipient_id',
                            'className' => 'User'
                        ),
                        'Created'=>array(
                            'foreignKey'=>'user_id',
                            'className' => 'User'
                        )
                    )
                ));
        
	$giftcertificates = $this->Paginator->paginate('GiftCertificate');
        
        //pr($giftcertificates); die;
        
        
	$breadcrumb = array(
		'Home'=>array('controller'=>'GiftCertificates','action'=>'list','admin'=>true),
		'Gift Certificates'=>'javascript:void(0);'
	    );
        $activeTMenu = '';
        $page_title = 'Gift Certificates';
        
        $this->set(compact('giftcertificates','activeTMenu','page_title','breadcrumb'));
	$this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->viewPath = "GiftCertificates";
            $this->render('admin_list');
        }
        
    }
    
    
    public function admin_delete_gift_certificate() {
        $this->loadModel('GiftCertificate');
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ($this->GiftCertificate->updateAll(array('GiftCertificate.is_deleted' => 1), array('GiftCertificate.id' => $this->request->data['id']))) {
                return 'success';
            }
        }
        die;
    }

    public function admin_generateString($length = 8) {
        $this->autoRender = false;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    /**
     * Show Images preview Admin
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_show_by_preview
     * @param         $id
     * @since         version 0.0.1
     */
    public function admin_show_by_preview($id = null){
        $this->loadModel('GiftImage');
        $this->loadModel('User');
        $this->loadModel('SalonService');
        $this->loadModel('Service');
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
                        'User.id' => $gc_details['GiftCertificate']['sender_id']),
                    'fields' => array('User.first_name','User.last_name','User.email')
                )
            );
            
            //$getData['GiftCertificate']['gift_image_id'] = 1;
            $gc_details['GiftCertificate']['Sender'] = $senderDetails['User'];
           
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
        
        $this->loadModel('GiftImage');
        $this->loadModel('User');
        
        $senderDetails = array();
        $this->User->unbindModel(array('hasMany'=>array('PricingLevelAssigntoStaff')));
        $senderDetails = $this->User->find('first',
                array('conditions' => array(
                    'User.id' => $gc_details['GiftCertificate']['sender_id']),
                'fields' => array('User.first_name','User.last_name','User.email')
            )
        );
        //echo "sonam";
        //pr($senderDetails);
        $gc_details['GiftCertificate']['Sender'] = $senderDetails['User'];
        $giftCertificate = $this->GiftImage->find('first', array('conditions' => array('GiftImage.id' => @$gc_details['GiftCertificate']['gift_image_id'])));
        
//        pr($gc_details);
//        pr($giftCertificate);
//        
        
        $image_path = $this->Common->create_image($gc_details,$giftCertificate);
        
        $image_name_arr = explode('/',$image_path);
        $image_arr_size = count($image_name_arr);
        $image_file_name = $image_name_arr[$image_arr_size-1];
//        die();
        $this->Session->write('GiftCertificateData.GiftCertificate.image_path',$image_file_name);
        $this->Session->write('GiftCertificateData.GiftCertificate.full_image_path',$image_path);
        
        
    }
    
    
    
    
    public function save_send_email(){
        $gc_details = $this->Session->read('GiftCertificateData');
        $this->generate_image($gc_details);
        
        $image_name = $this->Session->read('GiftCertificateData.GiftCertificate.image_path');
        $this->save_image(0,0,1,1);
        $this->Session->setFlash('Giftcertificate has been created successfully.', 'flash_success');
        echo 'success'; die;
        //$this->send_emails($gc_details);
    }
    
    
    public function send_emails($getData = array(),$gc_id = null){
        if(!empty($getData)){
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
                //Send Email to recicpient User Email
                //$recipientName = $this->User->find('first', array('conditions' => array('User.id' => $getData['GiftCertificate']['recipient_id'])));
                
                $path = WWW_ROOT . '/images/GiftImage/original/';
                
                $file_name = $getData['GiftCertificate']['image'];
                
                $dynamicVariables = array('{FromName}'=>ucfirst(@$getData['GiftCertificate']['first_name']).' '.ucfirst(@$getData['GiftCertificate']['last_name']),
                                        '{ToName}'=>$senderName['User']['first_name'],'{Message}'=>$message);
                $this->Common->sendEmail($to, $from,'gift_certificate', $dynamicVariables, $from, $path ,$file_name);
            }
            
            /************** Send email to Sender for success fully order placed ***********/
            //$sender_message = 'Order placed successfully';
            //$sender_dynamicVariables = array('{Message}'=>$sender_message);
            
            $sender_dynamicVariables = array('{FromName}'=>ucfirst(@$getData['GiftCertificate']['first_name']).' '.ucfirst(@$getData['GiftCertificate']['last_name']),
                                        '{GiftcertificateAmount}'=>$getData['GiftCertificate']['amount'],
                                        '{ToName}'=>ucfirst(@$getData['GiftCertificate']['first_name']).' '.ucfirst(@$getData['GiftCertificate']['last_name']),
                                        '{ToEmail}'=>$to);
             
            $this->Common->sendEmail($senderName['User']['email'],
                                    $from,
                                    'gift_certificate_-_offline_order', $sender_dynamicVariables);
            
            
            
            /********* Send Email *************/
        } else {
            echo 'here';
        }
    }
    
    
    
    public function save_image($imageid=NULL,$extension=NULL,$from_back_end = 0,$from_controller = null){
        $this->autoRender = false;
        $this->loadModel('GiftCertificate');
        
        $getData = array();
        $getData = $this->Session->read('GiftCertificateData');
        
        
        $created_by = $this->Session->read('Auth.User.id');
        $created_user_type = $this->Session->read('Auth.User.type');
        
        $getData['GiftCertificate']['created_by'] = $created_by;
        
        if(($created_user_type == 1 || $created_user_type == 4 || $created_user_type == 5) && $from_back_end == 1) {
            $getData['GiftCertificate']['payment_by'] = 3;
            $getData['GiftCertificate']['payment_status'] = 4;
            
            $getData['GiftCertificate']['image'] = $getData['GiftCertificate']['image_path'];
            
            /*if($getData['GiftCertificate']['id'] == ''){
                $getData['GiftCertificate']['image'] =$getData['GiftCertificate']['gift_certificate_no'].'_'.$getData['GiftCertificate']['gift_image_id'].'.'.$extension;
            }else{
                $getData['GiftCertificate']['image'] =$getData['GiftCertificate']['id'].'_'.$getData['GiftCertificate']['gift_image_id'].'.'.$extension;
            }*/
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

       // pr($getData);
        
        $this->GiftCertificate->id = $getData['GiftCertificate']['id'];
        //$getData['GiftCertificate']['salon_id'] = $salon_id;
        
        /***** Recipient Details ****/
        $getData['GiftCertificate']['email'] = $getData['GiftCertificate']['recipient_email'];
        $getData['GiftCertificate']['first_name'] = $getData['GiftCertificate']['recipient_first_name'];
        $getData['GiftCertificate']['last_name'] = $getData['GiftCertificate']['recipient_last_name'];
        /***** Recipient Details ****/
        
        //pr($getData); die;
        
        $this->GiftCertificate->set($getData);
        if ($this->GiftCertificate->save($getData)){
            $this->Session->delete('GiftCertificateData');
            if(empty($from_controller)){
                echo    'success';
            }
            $this->send_emails($getData);
        }
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

    /**
     * List gift images front end for particular design category
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        index     
     * @since         version 0.0.1
     */
    public function index($redeem_gift = NULL) {
        $user_count = $total_points = $amount= '';
	if($redeem_gift != ''){
	    $get_flag = base64_decode($redeem_gift);
	    if($get_flag == 'redeemed'){
		//$taxes = $this->components->getTax(1);
                $userId  = $this->Auth->user('id');
                $amount_redeemed =  $this->Common->getPrice($userId ,1);
                $this->set(compact('amount_redeemed'));
             }
	}
        $this->set('salonId' , '1');
    }

    /**
     * Show gift certificate images in div correspond to design category selected
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        image_category
     * @param         $id
     * @since         version 0.0.1
     */
    public function image_category($id = null,$salon_id = null) {
        $this->request->is('ajax');
        $this->loadModel('GiftImage');
        $giftImageData = $this->GiftImage->find('all', array('fields' => array('GiftImage.id', 'GiftImage.eng_title', 'GiftImage.image'), 'conditions' => array('GiftImage.status' => 1, 'GiftImage.gift_image_category_id' => $id)));
        if(!empty($salon_id)){
            $giftImageData = $this->GiftImage->find('all',
                        array(
                              'fields' => array('GiftImage.id',
                                                'GiftImage.eng_title',
                                                'GiftImage.ara_title',
                                                'GiftImage.image'),
                            'conditions' => array(
                                        'OR' => array(
                                                array('AND' =>array(
                                                    'GiftImage.status' => 1,
                                                    'GiftImage.gift_image_category_id' => $id,
                                                    'GiftImage.user_id' => $salon_id,
                                                )),
                                                array('AND' =>array(
                                                    'GiftImage.status' => 1,
                                                    'GiftImage.gift_image_category_id' => $id,
                                                    'GiftImage.user_id' => 1,
                                                )),
                                        ),
                            )
                        ));
        } else {
            $giftImageData = $this->GiftImage->find('all',
                    array(
                          'fields' => array('GiftImage.id',
                                            'GiftImage.eng_title',
                                            'GiftImage.ara_title',
                                            'GiftImage.image'),
                        'conditions' => array(
                                                'GiftImage.status' => 1,
                                                'GiftImage.gift_image_category_id' => $id,
                                                'GiftImage.user_id' => 1,
                        )
                    ));
        }
       
        //pr($giftImageData); exit;
        $this->set('giftImageData', $giftImageData);
        $this->layout = 'ajax';
        $this->viewPath = "Elements/frontend/GiftCertificates";
        $this->render('image_category');
    }

    /**
     * Show gift certificate images preview at front end
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        show_preview
     * @param         $id
     * @since         version 0.0.1
     */
    public function show_preview($id = null){
        $userId = $this->Auth->user('id');
        if(empty($userId)){
           echo 'unauthorized';
           exit;
        }
        $this->loadModel('GiftImage');
        $this->loadModel('User');
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['GiftCertificate']['user_id'] = $userId;
            $this->request->data['GiftCertificate']['sender_id'] = $userId;
	    $this->request->data['GiftCertificate']['created_by'] = $userId;
            $this->request->data['GiftCertificate']['gift_certificate_no'] = strtoupper($this->Common->getRandPass(8));
            
    /******************************************** Sender Details ******************************************/
                //$this->request->data['GiftCertificate']['first_name'] = $this->Session->read('Auth.User.first_name');
               // $this->request->data['GiftCertificate']['last_name'] = $this->Session->read('Auth.User.last_name');
              // $this->request->data['GiftCertificate']['email'] = $this->Session->read('Auth.User.email');
    /********************************************** End of Sender Details *********************************/
            
            if (!empty($this->request->data['GiftCertificate']['id'])){
                $this->GiftCertificate->id = $this->request->data['GiftCertificate']['id'];
            }
            if (!isset($this->request->data['GiftCertificate']['service_id'])){
                $this->GiftCertificate->service_id = 0;
            }
            
	    $this->request->data['GiftCertificate']['is_deleted'] = 1;
            $this->GiftCertificate->set($this->request->data);
            if ($this->GiftCertificate->save($this->request->data)) {
                if (!empty($this->request->data['GiftCertificate']['id'])) {
                    $id = $this->request->data['GiftCertificate']['id'];
                    $type = "Old";
                } else {
                    $id = $this->GiftCertificate->getLastInsertId();
                    $type = "New";
                }
                $giftCertificateImage = $this->GiftImage->find('first', array('conditions' => array('GiftImage.id' => @$this->request->data['GiftCertificate']['gift_image_id'])));
                //pr($this->data); die;
                $this->request->data['GiftCertificate']['recipient_first_name'] = $this->request->data['GiftCertificate']['first_name'];
                $this->request->data['GiftCertificate']['recipient_last_name'] = $this->request->data['GiftCertificate']['last_name'];
                //this->request->data['GiftCertificate']['email'] = $this->request->data['GiftCertificate']['email'];
                $this->request->data['GiftCertificate']['recipient_email'] = $this->request->data['GiftCertificate']['email'];
                
                $sender = $this->User->find('first', array(
                                'conditions'=> array('User.id' => $this->request->data['GiftCertificate']['sender_id']),
                                'fields' => array('User.id','User.first_name','User.last_name','User.email')
                            ));
                
                $this->request->data['GiftCertificate']['Sender'] = $sender['User'];
                
                //pr($this->request->data);
                
                $image_path = $this->Common->create_image($this->request->data,$giftCertificateImage);
                $image_name_arr = explode('/',$image_path);
                $image_arr_size = count($image_name_arr);
                $image_file_name = $image_name_arr[$image_arr_size-1];
                $save_image_name['GiftCertificate']['id'] = $id;
                $save_image_name['GiftCertificate']['image'] = $image_file_name;
                $this->GiftCertificate->set($save_image_name);
                $this->GiftCertificate->save($save_image_name);
                $gc_id = $id;
                $this->set(compact('image_path','gc_id'));
                $getData = $this->GiftCertificate->findById($id);
                if(isset($this->request->data['GiftCertificate']['redeemed_gift']) && !empty($this->request->data['GiftCertificate']['redeemed_gift'])){
                   $getData['GiftCertificate']['redeemed_gift'] = $this->request->data['GiftCertificate']['redeemed_gift'];
                }
                $this->Session->write('GiftCertificateData', $getData);
                //pr($this->Session->read('GiftCertificateData'));
                //$edata['data'] = 'success';
                //$edata['message'] = __('page_save_success', true);
                   //$edata['id'] = $id;
                  //$edata['New'] = $type;
                  // echo json_encode($edata);
                 //echo 'preview';
                //die;
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->GiftCertificate->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
    }

    function gift_cart($id=NULL){
        if($id==NULL){
            throw new NotFoundException;  
        }
        $id  = base64_decode($id);
        $this->loadModel('GiftCertificate');
        $gift_detail = $this->GiftCertificate->findById($id);
        $taxes = array();
        $this->loadModel('TaxCheckout');
        if($gift_detail['GiftCertificate']['salon_id'] !=0){
            $taxes = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$id)));   
        }
        if(count($taxes)==0){
           $taxes = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>1)));  
        }
        $this->set(compact('gift_detail','taxes'));
          //pr($gift_detail);
         //die('herer');
    }
    
    
    public function payment($gift_id=NULL,$user_id=NULL){
       // pr($this->Auth->user()); die;
        if($gift_id && $user_id){
            //die('hererer');
            $workingKey=Configure::read('working_key'); 	//Working Key should be provided here.
            $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
            $rcvdString=$this->Crypto->decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.			
            $order_status_val = '';	
            $order_status="";
            $tracking_id = '';
            $amount = '';
            $user['User']['discount_percentage'] = '0';
            $status_message = "purchase gift certificate";
            $decryptValues=explode('&', $rcvdString);
            $dataSize=sizeof($decryptValues);
            //echo "<center>";
            for($i = 0; $i < $dataSize; $i++) {
                $information=explode('=',$decryptValues[$i]);
                if($i==3)	{ $order_status=$information[1]; }
                if($i==1)	{ $tracking_id=$information[1]; }
                if($i==10)	{ $amount=$information[1]; }
                if($i==8)	{ $status_message=$information[1]; }
            }
            //$order_status = 'Success';
            if($order_status){
                $certificate_status = ($order_status==="Success")?1:3;
                $data['GiftCertificate']['id']  = $gift_id;
                //$allData   =$this->GiftCertificate->findById(base64_decode($gift_id));
                //pr($allData);
                $giftCertificate = $this->GiftCertificate->find('first', array('conditions' => array('GiftCertificate.id' =>$gift_id )));
                $data['GiftCertificate']['payment_by']  = 0;
                $data['GiftCertificate']['payment_status']  = $certificate_status;
                $this->GiftCertificate->id =$giftCertificate['GiftCertificate']['id']; 
                if($this->GiftCertificate->save($data ,false)){
                    $orignal_amount = $giftCertificate['GiftCertificate']['amount'];
                    $this->loadModel('TaxCheckout');
                    $tax_fields = array('tax1','tax2','deduction1','deduction2');
                    $tax_vendor = array();
                    if($giftCertificate['GiftCertificate']['salon_id'] !=0){
                        $tax_vendor = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$giftCertificate['GiftCertificate']['salon_id']),'fields'=>$tax_fields));
                    }
                    $tax_admin  = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>1),'fields'=>$tax_fields));  
                    $is_admin_tax  =2;
                    if(count($tax_vendor)==0){
                        $is_admin_tax  =1;
                        $tax_vendor =  $tax_admin;  
                    }
                    $tax = $tax_vendor['TaxCheckout']['tax1']+ $tax_vendor['TaxCheckout']['tax2'];
                    if($tax > 0){
                        $tax_amount = ($orignal_amount*$tax)/100;
                        $gift_price_with_tax =  $tax_amount + $amount;
                    } 
                    $this->loadModel('PointSetting');
                    $pointssetting = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
                    // $saloon_discount ;
                  /*  $sieasta_comission_price = $pointssetting['PointSetting']['siesta_commision'];
                    if($giftCertificate['GiftCertificate']['salon_id'] != 0){
                        $this->loadModel("User");
                        $this->User->recursive = -1;
                        $user = $this->User->find('first' , array('conditions'=>array('User.id'=>$giftCertificate['GiftCertificate']['salon_id']),'fields'=>array('User.discount_percentage')));
                        if(count($user)){
                          $sieasta_comission_price = $sieasta_comission_price-$user['User']['discount_percentage']; 
                        }
                    }
                    //$saloon_discount = $sieasta_comission_price
                    $sieasta_comission  = ($orignal_amount * $sieasta_comission_price)/100;
                    $total_deductions = $tax_admin['TaxCheckout']['deduction1'] + ($orignal_amount*$tax_admin['TaxCheckout']['deduction1'])/100;
                    $vendors_dues = $orignal_amount - ($sieasta_comission + $total_deductions);  */
                    /****************************************************/
                    if($order_status==="Success") {
                        $order_status_val = 1;   
                    } else if($order_status==="Aborted") {
                        $order_status_val = 2;
                        $appointment_status  =5;
                    } else if($order_status==="Failure") {
                       $order_status_val = 3;
                    } else{
                      $order_status_val = 5;
                    }
                    $this->loadModel('Order');
                    $order['Order']['transaction_status'] = $order_status_val; 
                    $order['Order']['transaction_id'] = $tracking_id;     
                    $order['Order']['gift_id'] = $gift_id;
                    $order['Order']['user_id'] = $user_id;
                    $order['Order']['display_order_id'] = $this->Common->getRandPass(10);
                    $order['Order']['service_type'] = 6;
                    $order['Order']['amount'] = $amount;
                    $order['Order']['orignal_amount'] = $amount;
                    $order['Order']['transaction_message'] = $status_message;
                    $order['Order']['start_date'] = date('Y-m-d');
                    //$order['Order']['service_price_with_tax'] = $gift_price_with_tax;
                    //$order['Order']['deduction1'] =$tax_admin['TaxCheckout']['deduction1'];
                    //$order['Order']['deduction2'] = $tax_admin['TaxCheckout']['deduction2'];
                    //$order['Order']['sieasta_commision'] =$sieasta_comission_price;
                    //$order['Order']['total_deductions'] = $total_deductions;
                    //$order['Order']['vendor_dues'] = $vendors_dues;
                    //$order['Order']['tax1'] = $tax_vendor['TaxCheckout']['tax1'];
                    //$order['Order']['tax2'] = $tax_vendor['TaxCheckout']['tax2'];
                    $order['Order']['salon_id'] = $giftCertificate['GiftCertificate']['salon_id'];
                    //$order['Order']['tax_amount'] = $tax_amount;
                    //$order['Order']['sieasta_commision_amount'] = $sieasta_comission;
                    //$order['Order']['saloon_discount'] = $user['User']['discount_percentage'];
                    //$order['Order']['is_admin_tax'] = $is_admin_tax;
                    if(in_array($giftCertificate['GiftCertificate']['salon_id'] , $admin_user)){
                      $this->Order->save($order , false);  
                    }else{
                        if($this->Common->add_customer_to_salon($user_id,$giftCertificate['GiftCertificate']['salon_id'])){
                            $this->Order->save($order , false);
                         }else{
                            $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                            $this->redirect(array('controller'=>'homes','action'=>'index')); 
                         }
                    }
                } 
                if($order_status==="Success"){
                    #Send Email to Purchaser
                    $save_gc_details['GiftCertificate']['order_id'] = $this->Order->id;
                    $save_gc_details['GiftCertificate']['is_deleted'] = 0;
                    $save_gc_details['GiftCertificate']['payment_by']  = 0;
                    $save_gc_details['GiftCertificate']['payment_status']  = 1;
                    $save_gc_details['GiftCertificate']['is_online']  = 1;
                    $this->GiftCertificate->id = $giftCertificate['GiftCertificate']['id'];
                    $this->GiftCertificate->save($save_gc_details);
                    $purchaserEmail = $this->Auth->user('email');
                    $to = $purchaserEmail;
                    $from = Configure::read('noreplyEmail');
                    $message = $giftCertificate['GiftCertificate']['messagetxt'];
                    $path = WWW_ROOT . 'images/GiftImage/original/';
                    $image = $giftCertificate['GiftImage']['image'];
                    // $file_name = $image;         
                    //$this->PHPMailer->sendmail($to, $from, $senderName['User']['first_name'], 'test', $message, $file_name);
                    $extension = substr($giftCertificate['GiftImage']['image'], strrpos($giftCertificate['GiftImage']['image'], '.') + 1);
                    $file_name = $giftCertificate['GiftCertificate']['id'].'_'.$giftCertificate['GiftCertificate']['gift_image_id'].'.'.$extension;
                    #Send Email to Recipient 
                    $this->loadModel('User');
                    //$giftCertificate = $this->GiftCertificate->find('first', array('conditions' => array('GiftCertificate.id' =>base64_decode($gift_id) )));
                    $senderName = $this->User->find('first', array('conditions' => array('User.id' => $giftCertificate['GiftCertificate']['sender_id'])));
                    /**** Order Confirmation Email to sender **********/
                    $sender_dynamicVariables = array('{FromName}'=>ucfirst(@$senderName['User']['first_name']).' '.ucfirst(@$senderName['User']['last_name']),
                                        '{GiftcertificateAmount}'=>$giftCertificate['GiftCertificate']['amount'],
                                        '{ToName}'=>ucfirst(@$giftCertificate['GiftCertificate']['first_name']).' '.ucfirst(@$giftCertificate['GiftCertificate']['last_name']),
                                        '{ToEmail}'=>$giftCertificate['GiftCertificate']['email']);
                     $this->Common->sendEmail($to,
                                    $from,
                                    'gift_certificate_-_order_placed', $sender_dynamicVariables);
                    $amount = $giftCertificate['GiftCertificate']['amount'];
                    $message = "your order for giftcertificate amount $amount has been placed successfully.";
                    $logged_in_user = $this->Auth->user();
                    $cell_no =  $logged_in_user['Contact']['cell_phone'];
                    $phone_code = $logged_in_user['Contact']['country_code'];
                    if($phone_code){
                     $phone_code = str_replace('+','',$phone_code);    
                    }else{
                        $phone_code = '971';
                    }
                    if($cell_no){
                     $cell_no =$phone_code.$cell_no;
                     $this->Common->sendVerificationCode($message ,$cell_no);   
                    }
                    
                    /**** End of Order Confirmation Email to sender **********/
                    
                   if($giftCertificate['GiftCertificate']['send_email_status'] == 1){
                        //Send Email to recicpient User Email                
                        $to = $giftCertificate['GiftCertificate']['email'];
                        $from = $senderName['User']['email'];
                        $message = $giftCertificate['GiftCertificate']['messagetxt'];
                        $path = WWW_ROOT . 'images/GiftImage/original/';
                        $image = $giftCertificate['GiftImage']['image'];
                        // $file_name = $image;         
                        //$this->PHPMailer->sendmail($to, $from, $senderName['User']['first_name'], 'test', $message, $file_name);
                        $extension = substr($giftCertificate['GiftImage']['image'], strrpos($giftCertificate['GiftImage']['image'], '.') + 1);
                        $file_name = $giftCertificate['GiftCertificate']['id'].'_'.$giftCertificate['GiftCertificate']['gift_image_id'].'.'.$extension;
                        //$this->PHPMailer->sendmail($to, $from, $salon_first_name, 'test', $message, $file_name);
                        $template_type =  $this->Common->EmailTemplateType($giftCertificate['GiftCertificate']['salon_id']);
                        $dynamicVariables = array();
                        /*if($template_type){
                           $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
                         }*/
                        $path = WWW_ROOT . '/images/GiftImage/original/';
                        $file_name = $giftCertificate['GiftCertificate']['image'];
                        
                        $Salon_id = $giftCertificate['GiftCertificate']['salon_id'];
                        if($Salon_id==0){
                          $Salon_id = 1;  
                        }
                        $salonDetail = $this->Common->salonDetail($giftCertificate['GiftCertificate']['salon_id']);
                        $site_url = Configure::read('BASE_URL');
                        $link = ($salonDetail['Salon']['business_url'])?$site_url.'/'.$salonDetail['Salon']['business_url']:$site_url;
                        $phone = ($salonDetail['Contact']['day_phone'])?'+971 '.$salonDetail['Contact']['day_phone']:'';
                        $address  = $salonDetail['Address']['address'];
                        $salon_name = ($salonDetail['Salon']['eng_name'])?$salonDetail['Salon']['eng_name']:'Sieasta';
                        $dynamicVariables = array('{ToName}'=>ucfirst(@$giftCertificate['GiftCertificate']['first_name']).' '.ucfirst(@$giftCertificate['GiftCertificate']['last_name']),
                                        '{FromName}'=>ucfirst($senderName['User']['first_name'].' '.$senderName['User']['last_name']),'{Message}'=>$message,'{amount}'=>@$giftCertificate['GiftCertificate']['amount'],'{Link}'=>$link,'{phone}'=>$phone,'{address}'=>$address,'{salon_name}'=>$salon_name); 
                        $this->Common->sendEmail($to, $from,'gift_certificate', $dynamicVariables, $from, $path ,$file_name);
                        //$this->Common->sendEmailAttach($to, $from,'gift_certificate',$message,$path, $file_name,'gift_certificate',$dynamicVariables);
                    }
                    $this->Session->setFlash('Your order for giftcertificate has been created successfully.', 'flash_success');
                    $this->redirect(array('controller'=>'Myaccount','action'=>'orders'));
                } else{
                    $this->Session->setFlash('Your transaction has been declined.Please try again to book appointment.', 'flash_error');
                    $this->redirect(array('controller'=>'homes','action'=>'index'));  
                }
            } else{
                $this->Session->setFlash('Your  transaction has been declined.Please try again to book appointment.', 'flash_error');
                $this->redirect(array('controller'=>'homes','action'=>'index'));  
            }
        }         
	if($this->request->is('post') || $this->request->is('put')){
            //echo '<pre>';  print_r($this->request->data);  die('herere');
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
    
    function redeem_gift($id=NULL){
        $userDetail  = $this->Auth->User();
            $giftCertificate  =    $giftDeatail  =$this->Session->read('GiftCertificateData');
        if($giftDeatail['GiftCertificate']['salon_id']==0){
            $salonId = 1;
        }else{
            $salonId = $giftDeatail['GiftCertificate']['salon_id'];
        }
        $userId = $this->Auth->user('id');
        $this->LoadModel('UserPoint');
        $this->LoadModel('UserCount');
        $points = $this->UserCount->find('first',array(
                'conditions' => array('UserCount.salon_id'=>$salonId, 'UserCount.user_id'=>$userId),
                'fields' => array('user_count','id')
        ));
       $redeem_point_total = $this->Common->get_points_from_price($giftDeatail['GiftCertificate']['amount']);
        if(!empty($points)){
          $UserPoint['UserPoint']['points_deducted'] = $redeem_point_total;
          $UserPoint['UserPoint']['user_id'] = $userId;
          $UserPoint['UserPoint']['salon_id'] = $salonId;
          $UserPoint['UserPoint']['type'] = 1;
          $UserPoint['UserPoint']['redeem_gift_id'] = $giftDeatail['GiftCertificate']['id'];
          if($this->UserPoint->save($UserPoint , false)){
                    $User_point_id = $this->UserPoint->id;
                    $total_point = $points['UserCount']['user_count'];
                    $point['UserCount']['user_count'] = $total_point-$redeem_point_total;
                    $this->UserCount->id = $points['UserCount']['id'];
                    if($this->UserCount->save($point , false)){
                       $this->loadModel('Order');
                                     $status_message = 'Redeem giftcard with points';
                                     $order['Order']['transaction_status'] = 5;
                                     $order['Order']['service_type'] = 6;
                                     $order['Order']['gift_id'] = $giftDeatail['GiftCertificate']['id'];
                                     $order['Order']['user_id'] = $userId;
                                     $order['Order']['orignal_amount'] = $giftDeatail['GiftCertificate']['amount'];
                                     $order['Order']['transaction_message'] = $status_message;
                                     $order['Order']['salon_id'] = $salonId;
                                     if($this->Order->save($order , false)){
                                        $order_id = $this->Order->id;
                                        /************************************/
                                        $this->UserPoint->id = $User_point_id;
                                        $this->UserPoint->saveField('order_id' ,$order_id);
                                        /************************************/
                                        $data['GiftCertificate']['payment_by']  = 0;
                                        $data['GiftCertificate']['order_id']  = $order_id;
                                        $data['GiftCertificate']['payment_status']  = 1;
                                        $data['GiftCertificate']['is_online']  = 1;
                                        $this->GiftCertificate->id =$giftDeatail['GiftCertificate']['id']; 
                                        if($this->GiftCertificate->save($data ,false)){
                                         $this->loadModel('User');
                                         $purchaserEmail = $this->Auth->user('email');
                                            $to = $purchaserEmail;
                                            $from = Configure::read('noreplyEmail');
                                            $message = $giftCertificate['GiftCertificate']['messagetxt'];
                                            $path = WWW_ROOT . 'images/GiftImage/original/';
                                            $image = $giftCertificate['GiftImage']['image'];
                                            // $file_name = $image;         
                                            //$this->PHPMailer->sendmail($to, $from, $senderName['User']['first_name'], 'test', $message, $file_name);
                                            $extension = substr($giftCertificate['GiftImage']['image'], strrpos($giftCertificate['GiftImage']['image'], '.') + 1);
                                            $file_name = $giftCertificate['GiftCertificate']['id'].'_'.$giftCertificate['GiftCertificate']['gift_image_id'].'.'.$extension;
                                            #Send Email to Recipient 
                                            $this->loadModel('User');
                                            //$giftCertificate = $this->GiftCertificate->find('first', array('conditions' => array('GiftCertificate.id' =>base64_decode($gift_id) )));
                                            $senderName = $this->User->find('first', array('conditions' => array('User.id' => $giftCertificate['GiftCertificate']['sender_id'])));
                                            /**** Order Confirmation Email to sender **********/
                                            $sender_dynamicVariables = array('{FromName}'=>ucfirst(@$senderName['User']['first_name']).' '.ucfirst(@$senderName['User']['last_name']),
                                                                '{GiftcertificateAmount}'=>$giftCertificate['GiftCertificate']['amount'],
                                                                '{ToName}'=>ucfirst(@$giftCertificate['GiftCertificate']['first_name']).' '.ucfirst(@$giftCertificate['GiftCertificate']['last_name']),
                                                                '{ToEmail}'=>$to);
                                     
                                             $this->Common->sendEmail($to,
                                                            $from,
                                                            'gift_certificate_-_order_placed', $sender_dynamicVariables);
                                            /**** End of Order Confirmation Email to sender **********/
                                            
                                           if($giftCertificate['GiftCertificate']['send_email_status'] == 1){
                                                //Send Email to recicpient User Email                
                                                $to = $giftCertificate['GiftCertificate']['email'];
                                                $from = $senderName['User']['email'];
                                                $message = $giftCertificate['GiftCertificate']['messagetxt'];
                                                $path = WWW_ROOT . 'images/GiftImage/original/';
                                                $image = $giftCertificate['GiftImage']['image'];
                                                // $file_name = $image;         
                                                //$this->PHPMailer->sendmail($to, $from, $senderName['User']['first_name'], 'test', $message, $file_name);
                                                $extension = substr($giftCertificate['GiftImage']['image'], strrpos($giftCertificate['GiftImage']['image'], '.') + 1);
                                                $file_name = $giftCertificate['GiftCertificate']['id'].'_'.$giftCertificate['GiftCertificate']['gift_image_id'].'.'.$extension;
                                                //$this->PHPMailer->sendmail($to, $from, $salon_first_name, 'test', $message, $file_name);
                                                $template_type =  $this->Common->EmailTemplateType($giftCertificate['GiftCertificate']['salon_id']);
                                                $dynamicVariables = array();
                                                /*if($template_type){
                                                   $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
                                                 }*/
                                                $path = WWW_ROOT . '/images/GiftImage/original/';
                                                $file_name = $giftCertificate['GiftCertificate']['image'];
                                                $dynamicVariables = array('{ToName}'=>ucfirst(@$giftCertificate['GiftCertificate']['first_name']).' '.ucfirst(@$giftCertificate['GiftCertificate']['last_name']),
                                                                '{FromName}'=>ucfirst($senderName['User']['first_name'].' '.$senderName['User']['last_name']),'{Message}'=>$message); 
                                                $this->Common->sendEmail($to, $from,'gift_certificate', $dynamicVariables, $from, $path ,$file_name);
                                                //$this->Common->sendEmailAttach($to, $from,'gift_certificate',$message,$path, $file_name,'gift_certificate',$dynamicVariables);
                                            }
                                          
                                        //$giftCertificate = $this->GiftCertificate->find('first', array('conditions' => array('GiftCertificate.id' =>base64_decode($gift_id) )));
                                        //$senderName = $this->User->find('first', array('conditions' => array('User.id' => $giftDeatail['GiftCertificate']['sender_id'])));
                                        //if($giftDeatail['GiftCertificate']['send_email_status'] == 1){
                                        //    //Send Email to recicpient User Email                
                                        //    $to = $giftDeatail['GiftCertificate']['email'];
                                        //    $from = $senderName['User']['email'];
                                        //    $message = $giftDeatail['GiftCertificate']['messagetxt'];
                                        //    $path = WWW_ROOT . 'images/GiftImage/original/';
                                        //    $image = $giftDeatail['GiftImage']['image'];
                                        //    // $file_name = $image;         
                                        //    //$this->PHPMailer->sendmail($to, $from, $senderName['User']['first_name'], 'test', $message, $file_name);
                                        //    $extension = substr($giftDeatail['GiftImage']['image'], strrpos($giftDeatail['GiftImage']['image'], '.') + 1);
                                        //    $file_name = $giftDeatail['GiftCertificate']['id'].'_'.$giftDeatail['GiftCertificate']['gift_image_id'].'.'.$extension;
                                        //    //$this->PHPMailer->sendmail($to, $from, $salon_first_name, 'test', $message, $file_name);
                                        //    $template_type =  $this->Common->EmailTemplateType($salonId);
                                        //    $dynamicVariables = array();
                                        //    if($template_type){
                                        //       $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
                                        //     }
                                        //    $this->Common->sendEmailAttach($to, $from,'test',$message,$path, $file_name,'gift_certificate',$dynamicVariables);
                                        //}    
                                        $this->Session->setFlash('The giftcertificate has been created successfully.', 'flash_success');
                                        $this->redirect(array('controller'=>'Myaccount','action'=>'orders'));
                                    }else{
                                        $this->Session->setFlash('Some error occured.', 'flash_error');
                                        $this->redirect(array('controller'=>'homes','action'=>'index')); 
                                    }
                                        
                            }else{
                              $this->Session->setFlash('Some error occured.', 'flash_error');
                             $this->redirect(array('controller'=>'homes','action'=>'index'));    
                            }
                                         
                      }else{
                             $this->Session->setFlash('Some error occured.', 'flash_error');
                             $this->redirect(array('controller'=>'homes','action'=>'index')); 
                      }
            }else{
                             $this->Session->setFlash('Some error occured.', 'flash_error');
                             $this->redirect(array('controller'=>'homes','action'=>'index')); 
                      }
        }else{
                            $this->Session->setFlash('Some error occured.', 'flash_error');
                             $this->redirect(array('controller'=>'homes','action'=>'index'));  
        }
     }
    
}