<?php

class MyaccountController extends AppController {
    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email','RequestHandler', 'Cookie','Image','PHPMailer','Common','Acl','Paginator'); //An array containing the names of components this controller uses.

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('gift_details','request_booking','index','gifts','view_voucher','points','view_points','view_gift','cancel','salon_updates','reviews','products','bookmarks','reschedule','view_voucher_detail');
    }
    
/**********************************************************************************    
  @Function Name : index
  @Params	 : NULL
  @Description   : My Account
  @Author        : Niharika Arora
  @Date          : 21-May-2015
***********************************************************************************/
    public function index(){
        $this->layout = 'myaccount';
        $this->set('title_for_layout', 'My Account');
        
    }
    
/**********************************************************************************    
  @Function Name : appointments
  @Params	 : NULL
  @Description   : Display appointments in users account profile
  @Author        : Niharika Arora
  @Date          : 25-May-2015
***********************************************************************************/    
    public function appointments($is_past = null){
        $this->loadModel('Order');
        $this->loadModel('Appointment');
	$this->Order->unbindModel(array('belongsTo'=>array('Appointment')));
	$this->Appointment->bindModel(array('belongsTo'=>array('Order','SalonService','Evoucher')));
        $userId = $this->Auth->user('id');
	
        $current_date =time();
	$this->Appointment->virtualFields['appoitment_start_date'] = 0;
        $fields = array('Order.id','Order.service_type','Order.display_order_id','Order.appointment_id' ,'Appointment.evoucher_id','Evoucher.price','Order.check_in','Order.check_out','Order.salon_service_id','Order.duration','Order.amount','Order.orignal_amount','Order.salon_service_id','Order.salon_id','Order.eng_service_name','Order.ara_service_name','Appointment.salon_id','Appointment.package_id','Appointment.id','Appointment.status','Appointment.salon_service_id','Appointment.appointment_duration','SUM(Appointment.appointment_duration) as Duration,SUM(Appointment.appointment_price) as Price','MIN(Appointment.appointment_start_date) as Appointment__appoitment_start_date','Appointment.deal_id','SalonService.*');
        $number_records = 10;
        $class = '';
	//echo $is_past;
        /**** Past appointments ******/
        if(!empty($is_past)){
            $conditions = array("not" => array("Appointment.order_id" => null),'Appointment.user_id'=>$userId, 'Appointment.appointment_start_date <=' => $current_date);
            $class="past";
        }else{
            $conditions = array("not" => array("Appointment.order_id" => null),'Appointment.user_id'=>$userId, 'Appointment.appointment_start_date >= ' => $current_date,'Appointment.is_review NOT IN(1,2)');
            $class="now";
        }
        /**** Past appointments ******/
	
	    $this->Paginator->settings = array(
		    'Appointment' => array(
			 //'recursive'=>2,
			'limit' => $number_records,
			'conditions' => $conditions,
			'fields' => $fields,
			'order' => array('Order.id' => 'desc'),
			'group'=> 'Appointment.order_id, Appointment.evoucher_id '
		    )
	    );
        $orders = $this->Paginator->paginate('Appointment');
	//pr($orders);
	//exit;
        $this->set(compact('orders','class'));
	
	if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'default';
        }
    }
    
/**********************************************************************************    
  @Function Name : orders
  @Params	 : NULL
  @Description   : Display orders in users account profile
  @Author        : Niharika Arora
  @Date          : 21-May-2015
***********************************************************************************/    
    public function orders(){
        $this->loadModel('Order');
        $this->loadModel('Evoucher');
        $userId = $this->Auth->user('id');
	$this->Order->unbindModel(array('belongsTo'=>array('Appointment','SalonService')));
	$this->Order->bindModel(array('hasMany'=>array('Evoucher'),'hasOne'=>array('GiftCertificate')));
        $number_records = 10;
        $class = '';
	$conditions = array('Order.user_id' => $userId, 'Order.service_type' => array(6,7),'Order.transaction_status !=' => 9,'Order.from_cancelled !=' => 1);
	$this->Paginator->settings = array(
			'Order' => array(
				'limit' => $number_records,
				'conditions' => $conditions,
				'order' => array('Order.id' =>'desc')
			)
	);
		
        $orders = $this->Paginator->paginate('Order');
	$this->set(compact('orders','class'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {

        }
    }
    
    /**********************************************************************************    
  @Function Name : gifts
  @Params	 : NULL
  @Description   : Display gifts in users account profile
  @Author        : Niharika Arora
  @Date          : 25-May-2015
***********************************************************************************/    
    public function gifts(){
        $this->loadModel('GiftCertificate');
        /****** Get list of evouchers of the user ****/
        $userId = $this->Auth->user('id');
        $userEmail = $this->Auth->user('email');
       
        /****** Get list of gifts of the user ****/
        $current_date = date('Y-m-d');
        $fields = array('GiftCertificate.id','GiftCertificate.expire_on','GiftCertificate.image','GiftCertificate.amount','GiftCertificate.gift_certificate_no','GiftCertificate.is_used');
        $order = 'GiftCertificate.id desc';
        /************** Set page limit ************/
	$number_records = 10;
        $conditions = array('GiftCertificate.recipient_id'=>$userId, 'GiftCertificate.type'=>1,'GiftCertificate.is_deleted'=>0);
        //pr ($conditions);exit;
       if($this->request->isAjax()){
            if(!empty($this->request->data)){
                if(isset($this->request->data['filter_date'])){
                    $filter = $this->request->data['filter_date'];
                    if($filter == 1){
                        $order = 'GiftCertificate.expire_on asc';
                    }elseif($filter == 0){
                        $order = 'GiftCertificate.expire_on desc';
                    }else{
                        $order = 'GiftCertificate.id desc';
                    }
                }
            }
       }
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
        $this->set(compact('gifts'));
        /****** Get list of evouchers of the user ****/
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {

        }
        if(isset($this->request->data['filter_date']) &&  $this->request->data['filter_date'] !='' ){
            $this->viewPath = "Elements/frontend/Myaccount";
	    $this->render('giftstable');
        }else{
	    $this->render('gifts');
        }
    }
    
    /**********************************************************************************    
  @Function Name : view_voucher
  @Params	 : id
  @Description   : View Voucher
  @Author        : Niharika Arora
  @Date          : 26-May-2015
***********************************************************************************/    
    public function view_voucher($id){
        $this->layout = 'ajax';
        $this->loadModel('GiftCertificate');
        $gifts = $this->GiftCertificate->find('first' , array('conditions'=>array('GiftCertificate.id'=>$id,'GiftCertificate.type'=>2)));
        $this->set('gifts',$gifts);
        
    }
    
    
    /**********************************************************************************    
  @Function Name : points
  @Params	 : id
  @Description   : View POints
  @Author        : Niharika Arora
  @Date          : 26-May-2015
***********************************************************************************/    
    public function points(){
	$userId = $this->Auth->user('id');
	$this->loadModel('UserCount');
	$this->UserCount->belongsTo = array('User' => array('className' => 'User','foreignKey' => 'salon_id'));
	$number_records = 10;
	$reset='0';
	$order = 'UserCount.user_count DESC';
	$conditions = array('UserCount.user_id'=>$userId,'User.type !='=>1,'UserCount.salon_id !='=>1);
	if($this->request->isAjax()){
	    if(!empty($this->request->data)){
		if(isset($this->request->data['filter_list'])){
		    $filter = $this->request->data['filter_list'];
		    $reset = '1';
		    if($filter == 1){
			$order = 'UserCount.user_count DESC';
		    }else{
			$order = 'UserCount.user_count ASC';
		    }
		}
	    } 
	}
	$fields = array(
	    'User.id',
	    'User.type',
	    'UserCount.user_count',
	    'UserCount.salon_id',
	    'UserCount.user_id',
	    'Salon.cover_image');
	//pr($conditions);exit;
	$this->Paginator->settings = array(
		 'UserCount' => array(
		     'limit' => $number_records,
		     'conditions' => $conditions,
		     'fields' => $fields,
		     'order' => $order,
		     'joins' => array(
				    array(
					'table' => 'salons',
					'alias' => 'Salon',
					'type' => 'left',
					'conditions' => array(
					    'Salon.user_id = UserCount.salon_id'
					)
				))
		 )
	     );
	$getpoints = $this->Paginator->paginate('UserCount');
	
	$sieasta_points = $this->UserCount->find('first',array(
				'conditions'=>array('UserCount.user_id'=>$userId,'User.type'=>1,'UserCount.salon_id'=>1),
				'fields' => $fields,
				 'joins' => array(
				    array(
					'table' => 'salons',
					'alias' => 'Salon',
					'type' => 'Left',
					'conditions' => array(
					    'Salon.user_id = UserCount.salon_id'
					)
				))
				));
	//pr($sieasta_points);
	//exit;
	//pr($getpoints);
	
	$this->set(compact('getpoints','reset','sieasta_points'));
	//$this->layout = 'ajax';
       
       
	$this->layout = 'myaccount';
	
	
	if($this->request->is('ajax')){
            $this->layout = 'ajax';
	   
        } else {
            $this->layout = 'myaccount';
        }
	
	/*
        if(isset($this->request->data['filter_list']) &&  $this->request->data['filter_list'] !='' ) {
            $this->viewPath = "Elements/frontend/Myaccount";
	    $this->render('pointstable');
        }else{
	    $this->render('points');

        }*/
    }
    
    /**********************************************************************************    
  @Function Name : view_points
  @Params	 : id
  @Description   : View Points
  @Author        : Niharika Arora
  @Date          : 26-May-2015
***********************************************************************************/    
    public function view_points($salon_id = null , $salon_type= null){
        $userId = $this->Auth->user('id');
        $this->layout = 'myaccount';
        $this->loadModel('User'); 
        $this->loadModel('UserPoint');
        $this->loadModel('Salon');
        $this->loadModel('Order');
	$this->UserPoint->unbindModel(array(
			    'belongsTo' => array('User')
			));
	$this->UserPoint->bindModel(array(
			    'belongsTo' => array('Order')
			));
	
	$fields = array(
		    'UserPoint.*',
		    'Order.id',
		    'Order.eng_service_name',
		    'Order.ara_service_name',
		    'Order.created',
		    'Order.orignal_amount',
		    'Order.service_type',
		    'Order.salon_service_id'
		);
	
        $children_id = array();
        $salon_data = array();
        $number_records = 10;
        if($salon_type != ''){
            if($salon_type == 2){
            /******** Franchise Case *******/
            $children = $this->User->find('all',array('conditions' => array('User.parent_id'=>$salon_id) , 'fields'=>array('User.id')));
                if(!empty($children)){
                    foreach($children as $child){
                        $children_id[] = $child['User']['id'];
                    }
                }
            /******** Franchise Case *******/
                if(!empty($children_id)){
                    $conditions = array('UserPoint.salon_id' =>$children_id , 'UserPoint.user_id'=>$userId, 'UserPoint.order_id != ""');  
                }
            } else {
                $conditions =  array('UserPoint.salon_id' =>$salon_id , 'UserPoint.user_id'=>$userId, 'UserPoint.order_id != ""');  
            }
        
	    $this->Paginator->settings = array(
		    'UserPoint' => array(
			'limit' => $number_records,
			'conditions' => $conditions,
			'fields' => $fields,
			'order' => array('UserPoint.id' => 'desc')
		    )
		);
	    $salon_data = $this->Paginator->paginate('UserPoint');
	    
	    $this->Salon->unbindModel(array(
				    'belongsTo'=>array('User')
			    ));
	    if($salon_id != 1) {
		$salon_details = $this->Salon->find('first',array(
				'conditions'=> array('Salon.user_id'=>$salon_id),
				'fields'=> array('Salon.id','Salon.eng_name','Salon.ara_name'),
				));
	    } else {
		$salon_details['Salon']['id'] = $salon_id;
		$salon_details['Salon']['eng_name'] = 'Sieasta';
		$salon_details['Salon']['ara_name'] = 'Sieasta';
	    }
	    //pr($salon_details);
	} else {
	    $salon_data = array();
	}
        $this->set(compact('salon_data','salon_details'));
	$this->layout ='ajax';
    }
    
    
    
/**********************************************************************************    
  @Function Name : cancel
  @Params	 : NULL
  @Description   : cancel appointments in users account profile
  @Author        : Shibu Kumar
  @Date          : 9-june-2015
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
	   //$this->Order->recursive = 2;
	   $this->Order->unbindModel(array('belongsTo'=>array('SalonService')));
	   $this->Order->bindModel(array('hasOne'=>array('Appointment')));
	   $appointment = $this->Order->find("first",array('fields'=>array('Appointment.id','Appointment.salon_id','Appointment.appointment_start_date','Order.*'),'conditions'=>array('Appointment.order_id'=>$order_id)));
	   $cancelPossibility =$this->check_cancellation($appointment['Appointment']['salon_id'],$appointment['Appointment']['appointment_start_date']);
	    
	    if($this->request->data['chck_setting']=='true' && $cancelPossibility['msg']=='true'){
		 echo json_encode($cancelPossibility);
		 exit;
	    }
	    if($cancelPossibility['msg']=='true'){
			    $salon_id = $appointment['Appointment']['salon_id'];
			    $salon_org_id = $appointment['Appointment']['salon_id'];
			    $this->Appointment->updateAll(
				array('Appointment.status' =>5), 
				array('Appointment.order_id' => $order_id)
			    );
			    
			    // create history
			    $historyData = '';
			    $historyData['appointment_id'] = $appointment['Appointment']['id'];
			    $historyData['appointment_date'] = $appointment['Appointment']['appointment_start_date'];
			    $historyData['duration'] = '-';
			    $historyData['service_name'] = $appointment['Order']['eng_service_name'];
			    $historyData['staff_id'] = '-';
			    $historyData['modified_by'] = $this->Auth->User('id');
			    $historyData['modified_date'] = strtotime(date('Y-m-d h:i:s'));
			    $historyData['order_id'] = $order_id; 
			    $historyData['status'] = 'Cancelled';
			    $historyData['action'] = 'Appointment Cancelled';
			    $this->create_appointment_history($historyData);
			    
			    
			    $serviceOwner = $this->User->findById($appointment['Appointment']['salon_id']);
			    $salon_email =  $serviceOwner['User']['email'];
			    $salon_first_name =  $serviceOwner['User']['first_name'].' '.$serviceOwner['User']['last_name'];
			    if($type == 'service'){
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
			   if($type == 'service'){
				    $salon_points_to_be_deducted = $appointment['Order']['points_given'];
				    $admin_points_to_be_deducted = 0;
				    $sieastaPoints = $this->UserPoint->find('first',array('fields'=>array('point_given','points_deducted'),'conditions'=>array('UserPoint.order_id'=>$order_id,'UserPoint.salon_id'=>1)));
				    if($sieastaPoints){
					$admin_points_to_be_deducted = $sieastaPoints['UserPoint']['point_given'];
				    }
			    
			   }
			    $amount_to_be_credited = $appointment['Order']['service_price_with_tax'];
			    
			    
			    
			}else if($appointment['Order']['transaction_status'] == 5){ // Payment through Points
			     if($type == 'service'){
				    $salon_points_to_be_deducted = $appointment['Order']['points_given'];
				    $admin_points_to_be_deducted = 0;
				    $sieastaPoints = $this->UserPoint->find('first',array('fields'=>array('point_given','points_deducted'),'conditions'=>array('UserPoint.order_id'=>$order_id,'UserPoint.salon_id'=>1)));
				    if($sieastaPoints){
					$admin_points_to_be_deducted = $sieastaPoints['UserPoint']['point_given'];
				    }
				$points_to_be_credited = $appointment['Order']['points_used'];
				$pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
			     }
			    
			    //$amount_to_be_credited =   $points_to_be_credited/$pointsVal['PointSetting']['aed_unit'];
			     $amount_to_be_credited = $appointment['Order']['service_price_with_tax'];
	////		    
			}else if($appointment['Order']['transaction_status'] == 6 || $appointment['Order']['transaction_status'] == 7 ){ // Payment through Gifts and Payment through Gifts + Gateway
			     if($type == 'service'){
				    $salon_points_to_be_deducted = $appointment['Order']['points_given'];
				    $admin_points_to_be_deducted = 0;
				    $sieastaPoints = $this->UserPoint->find('first',array('fields'=>array('point_given','points_deducted'),'conditions'=>array('UserPoint.appointment_id'=>$appointment_id,'UserPoint.salon_id'=>1)));
				    if($sieastaPoints){
					$admin_points_to_be_deducted = $sieastaPoints['UserPoint']['point_given'];
				    }
			     }
			    $amount_to_be_credited = $appointment['Order']['service_price_with_tax'];
			    
			}else if($appointment['Order']['transaction_status'] == 8){ // Payment through Points + Gateway
			     if($type == 'service'){
				    $salon_points_to_be_deducted = $appointment['Order']['points_given'];
				    $admin_points_to_be_deducted = 0;
				    $sieastaPoints = $this->UserPoint->find('first',array('fields'=>array('point_given','points_deducted'),'conditions'=>array('UserPoint.appointment_id'=>$appointment_id,'UserPoint.salon_id'=>1)));
				    if($sieastaPoints){
					$admin_points_to_be_deducted = $sieastaPoints['UserPoint']['point_given'];
				    }
				$points_to_be_credited = $appointment['Order']['points_used'];
				$pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
			     }
			    
			    //$amount_to_be_credited =  ($points_to_be_credited/$pointsVal['PointSetting']['aed_unit']);
			    //$amount_to_be_credited =  $amount_to_be_credited + $appointment['Order']['amount'];
			     $amount_to_be_credited = $appointment['Order']['service_price_with_tax'];
			}else{
			    
				$cancelPossibility['msg'] = 'Can\'t cancel this appointment';
				echo json_encode($cancelPossibility);
				exit;
			}
		    
		        /**************Send gift certificates***********/
		        $status_message = 'Gift Certificate issued against cancellation.';
			// Update Service order
			$this->Order->id = $order_id;
			$this->Order->saveField('order_avail_status',2);
			// create new Order for Gift Certificate
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
			    $gift_certificate['GiftCertificate']['messagetxt'] = "Hi , Gift Certificate issued against cancellation.";
			    $gift_certificate['GiftCertificate']['send_email_status'] = 1;
			    $gift_certificate['GiftCertificate']['gift_image_category_id'] = 5;
			    $gift_certificate['GiftCertificate']['gift_image_id'] = 12;
			    $gift_certificate['GiftCertificate']['type'] = 1;
			    $gift_certificate['GiftCertificate']['expire_on'] = $this->Common->vocher_expiry($salon_id);
			    $gift_certificate['GiftCertificate']['payment_status'] = 1;
			    $gift_certificate['GiftCertificate']['gift_certificate_no'] = strtoupper($this->Common->getRandPass(8));   
			    if($this->GiftCertificate->save($gift_certificate , false)){
				
				    $gift_certificate['GiftCertificate']['id'] =  $this->GiftCertificate->getLastInsertId();
				    $image = $this->GiftImage->find('first',array('fields'=>array('image'),'conditions'=>array('GiftImage.user_id'=>0)));
				    $gift_certificate['GiftImage']= $image['GiftImage'];
				    $extension = substr($gift_certificate['GiftImage']['image'], strrpos($gift_certificate['GiftImage']['image'], '.') + 1);
				    $file_name = $gift_certificate['GiftCertificate']['id'].'_'.$gift_certificate['GiftCertificate']['gift_image_id'].'.'.$extension;
				    $this->GiftCertificate->id = $gift_certificate['GiftCertificate']['id'];
				    $this->GiftCertificate->saveField('image',$file_name);
				    $this->Common->get_gift_certificate_image($gift_certificate);
				    $to = $email;//$giftCertificate['GiftCertificate']['email'];
				    $from = $salon_email;
				    $messageTxt = $gift_certificate['GiftCertificate']['messagetxt'];
				    $path = WWW_ROOT . 'images/GiftImage/original/';
				    $image = $gift_certificate['GiftImage']['image'];
				    //$this->PHPMailer->sendmail($to, $from, $salon_first_name, 'test', $message, $file_name);
				    if($type == 'service'){
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
				    $dynamicVariables = array('{FirstName}'=>ucfirst($first_name),'{GiftcertificateAmount}'=>$amount_to_be_credited);
				    $template_type =  $this->Common->EmailTemplateType($salon_id);
				    if($template_type){
				      $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
				    }
				    
				    $message = "Your appointment for the Service".  $appointment['Order']['eng_service_name'] .". has been cancelled . Order id is ". $appointment['Order']['display_order_id']."";
				    $appointment_detail['selected_date'] = $appointment['Order']['start_date'];
				    $appointment_detail['selected_time'] = $appointment['Order']['time'];
				    $ServiceUser = $this->User->find('first', array('conditions'=>array('User.id'=>$user_id,'User.status'=>1)));
				    $this->sendUserPhone($ServiceUser, $appointment['Order']['eng_service_name'],$appointment_detail,$message);
				    
				    
				    $this->cancel_email_sms($order_id);
				    
				    $this->Common->sendEmailAttach($to, $from,'Gift certificate for cancellation',$messageTxt,$path, $file_name,'cancel_gift',$dynamicVariables);
				    
				   
				    
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
   
   public function reschedule(){
        $this->autoRender =false;
	$this->layout = 'myaccount';
	$this->loadModel("Appointment");
	$this->loadModel("Order");
	$this->loadModel("User");
	$this->loadModel("SalonService");
	if($this->request->data){
		$appointmentData = array();
		if(isset($this->request->data['Appointment'])){
		    $appointment_detail = array();
		    $serviceDetails = array();
		    $serviceDetails = array();
		    $modifiedDate = strtotime(date('Y-m-d h:i:s'));
		    if(isset($this->request->data['Appointment']['thetype']) && (($this->request->data['Appointment']['thetype'] == 'Package')||($this->request->data['Appointment']['thetype'] == 'Spaday'))){
			if($this->request->data['Appointment']['service']){
			    $appointments = $this->request->data['Appointment'];
			    $thetype = $this->request->data['Appointment']['thetype'];
			    $salon_id = $this->request->data['Order']['salon_id'];
			    $package_name = $this->request->data['Order']['eng_service_name'];
			    $order_id = $this->request->data['Order']['id'];
			    $date = $this->request->data['Appointment']['package_date'];
			    $package_price = $this->request->data['Appointment']['package_price'];
			    $orderData = $this->Common->get_Order($order_id);
			    $display_order_id = $orderData['Order']['display_order_id'];
			   
			    foreach($appointments['service'] as $key => $appointment){
				
				$appointmentData['Appointment']['id'] = $appointment['appointment_id'];
				$appointmentData['Appointment']['appointment_start_date'] = strtotime($date.' '.trim($appointment['time']));
				$appointmentData['Appointment']['salon_staff_id'] = trim($appointment['stylist']);
				$this->Appointment->save($appointmentData,false);
				
				// create history
				$historyData = '';
				
				$historyData['appointment_id'] = $appointmentData['Appointment']['id'];
				$historyData['appointment_date'] = strtotime($date.' '.trim($appointment['time']));
				$historyData['order_id'] = $order_id; 
				$historyData['duration'] = $appointment['duration'];
				$historyData['service_name'] = $this->Common->get_salon_service_name($key);
				$historyData['package_name'] = $package_name;
				
				$historyData['staff_id'] = trim($appointment['stylist']);
				$historyData['modified_by'] = $this->Auth->User('id');
				$historyData['modified_date'] = $modifiedDate;
				$historyData['status'] = 'Paid';
				$historyData['type'] = 'package';
				$historyData['action'] = 'Rescheduled';
				$this->create_appointment_history($historyData);
				
				// Send Appointment email to Staff
				$appointment_detail['selected_date']= $date;
				$appointment_detail['selected_time']= trim($appointment['time']);
				$appointment_detail['duration']= trim($appointment['duration']);
				$appointment_detail['staff_id'] = trim($appointment['stylist']);
				$appointment_detail['id'] = $appointment['appointment_id'];
				$appointment_detail['service_name'] = $this->Common->get_salon_service_name($key);
				$appointment_detail['salon_id'] = $salon_id;
				
				//prepare package  services with name
				$serviceDetails[$key]['SalonService']['id'] = $key;
				$serviceDetails[$key]['SalonService']['eng_name'] = $this->Common->get_salon_service_name($key);
				$serviceDetails[$key]['SalonService']['salon_id'] = $this->Common->get_salon_service_name($key);
				$this->sendStaffEmailPhone($appointment_detail,$serviceDetails[$key],$display_order_id);
			    }
			    $this->Order->id = $order_id; 
			    $this->Order->saveField('start_date',date('Y-m-d',strtotime($date)));
			     // Send email to Booking Incharge
			    $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'UserDetail.booking_incharge'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$salon_id,'User.id'=>$salon_id))));
			   
			    foreach($SalonBookingIncharges as $incharge){
				$message = "Appointment for the $thetype  $package_name has been rescheduled on date : $date .Order id is $display_order_id";
				$this->sendUserPackageEmail($incharge, $serviceDetails,$appointments,$package_name ,$order_id ,$package_price ,'new_package','vendor');
				$details['selected_date']= $date = $appointments['package_date'];
				$details['selected_time']=  '';
				$this->sendUserPhone($incharge, $serviceDetails,$details,$message,'vendor');
			    }
			    // Send email to User
			        $details['selected_date']= $date;
				$details['selected_time']=  '';
			       // $package_price = $appointment_detail['package_date'];
				$userDetail = $this->Session->read('Auth');
				
				$message = "$thetype  $package_name  on date : $date has been successfully rescheduled. Your Order id is $display_order_id";
				$this->sendUserPackageEmail($userDetail, $serviceDetails, $appointments,$package_name, $order_id,$package_price ,'confirmation_package');
				$this->sendUserPhone($userDetail, $serviceDetails,$details ,$message);
				$this->Session->setFlash('Your Package has been rescheduled successfully.', 'flash_success');
			        $this->redirect(array('controller'=>'Myaccount','action'=>'appointments'));
			
			}else{
			    $this->Session->setFlash('Some error occurred!!!.', 'flash_error');
			    $this->redirect(array('controller'=>'users','action'=>'AccountManagement')); 
			}
			$this->Session->delete('APPOINTMENT.RESCHEDULE');
		    }else{
			//Service Appointment Reschedule
			//For saving Resheduled data 
		        $appointmentData['Appointment']['id'] = $this->request->data['Appointment']['id'];
		        $appointmentData['Appointment']['appointment_start_date'] = strtotime($this->request->data['Appointment']['selected_date'].' '.$this->request->data['Appointment']['selected_time']);
			$appointmentData['Appointment']['salon_staff_id'] =$this->request->data['Appointment']['selected_employee_id'];
			$appointment_detail['selected_date']= $this->request->data['Appointment']['selected_date'];
		        $appointment_detail['selected_time']= $this->request->data['Appointment']['selected_time'];
			$appointment_detail['staff_id']= $this->request->data['Appointment']['selected_employee_id'];
			//pr($appointmentData);
			//echo "<pre>";
			//print_r($this->request->data);
			//exit;
			if($this->Appointment->save($appointmentData,false)){
			   $this->Appointment->recursive = -1;
			    $AppointmentData = $this->Appointment->find('first' ,array('conditions'=>array('Appointment.id'=>$appointmentData['Appointment']['id']),'fields'=>array('id','order_id','appointment_start_date','appointment_duration','appointment_title','salon_staff_id')));
			     $order_id = $AppointmentData['Appointment']['order_id'];
			    // create history
			    $historyData = '';
			    $historyData['appointment_id'] = $AppointmentData['Appointment']['id'];
			    $historyData['appointment_date'] = $AppointmentData['Appointment']['appointment_start_date'];
			    $historyData['duration'] = $AppointmentData['Appointment']['appointment_duration'];
			    $historyData['service_name'] = $AppointmentData['Appointment']['appointment_title'];
			    $historyData['staff_id'] = $AppointmentData['Appointment']['salon_staff_id'];
			    $historyData['modified_by'] = $this->Auth->User('id');
			    $historyData['modified_date'] = strtotime(date('Y-m-d h:i:s'));
			    $historyData['order_id'] = $order_id; 
			    $historyData['status'] = 'Paid';
			    $historyData['type'] = 'service';
			    $historyData['action'] = 'Rescheduled';
			    $this->create_appointment_history($historyData);
			    
			   
			    $orderData = $this->Common->get_Order($order_id);
			    $display_order_id = $orderData['Order']['display_order_id'];
			    
			    // update ORder
			    $this->Order->id = $order_id; 
			    $this->Order->saveField('start_date',date('Y-m-d',strtotime($this->request->data['Appointment']['selected_date'])));
			    //echo strtotime('Y-m-d',$this->request->data['Appointment']['selected_date']);
			    //exit;
			    $this->Session->delete('APPOINTMENT.RESCHEDULE');
			    $this->sendAppointmentMail($appointmentData['Appointment']['id'],$appointment_detail,'rAppointment',$display_order_id);
			    $this->Session->setFlash('Your appointment has been rescheduled successfully.', 'flash_success');
			    $this->redirect(array('controller'=>'Myaccount','action'=>'appointments'));
			}else{
				$this->Session->setFlash('Some error occurred!!!.', 'flash_error');
				$this->redirect(array('controller'=>'users','action'=>'AccountManagement'));
			}
		    }
		}else{
		    // for checking Rescheduling possibility 
		    $order_id =  $this->request->data['order_id'];
		    $this->Order->unbindModel(array('belongsTo'=>array('SalonService')));
		    $this->Order->bindModel(array('hasOne'=>array('Appointment')));
		    $appointment = $this->Order->find("first",array('fields'=>array('Appointment.salon_id','Appointment.appointment_start_date'),'conditions'=>array('Order.id'=>$order_id)));
		    $reschedulePossibility =$this->check_reschedule_criteria($appointment['Appointment']['salon_id'],$appointment['Appointment']['appointment_start_date']);
		    //pr($appointment);
		    //exit;
		    if($reschedulePossibility['msg'] == 'true'){
			 if($this->request->data['chck_setting'] !='true'){
			   $this->Session->write('APPOINTMENT.RESCHEDULE',true);
			 }
			 echo json_encode($reschedulePossibility);
			 exit;
		    }else{
			 echo json_encode($reschedulePossibility);
			 exit;
		    }
	    }
	    
	}
     
   }
   
   
   public function sendAppointmentMail($appointmentID = null,$appointment_detail =null, $type = null, $display_order_id=NULL){
	    $this->loadModel('User');
	    $this->loadModel('SalonService');
	    $appointmentData =   $this->Appointment->find('first',array('fields'=>array('salon_id','salon_staff_id','appointment_duration','id','salon_service_id'),'conditions'=>(array("Appointment.id"=>$appointmentID))));
	    
	    $appointment_detail['duration'] = $appointmentData['Appointment']['appointment_duration'];
	    $appointment_detail['id'] = $appointmentData['Appointment']['id'];
	    
	    $serviceStaff = $this->User->findById($appointmentData['Appointment']['salon_staff_id']);
	    $salonID = $appointmentData['Appointment']['salon_id'];
	    //$serviceDetails = $this->SalonService->find('first',array('fields'=>array('SalonService.eng_name'),'conditions'=>array('SalonService.id'=>$appointmentData['Appointment']['salon_service_id'])));
	    $salonService_name = $this->Common->get_salon_service_name($appointmentData['Appointment']['salon_service_id']);
	    $salonDetail['SalonService']['salon_id']= $salonID;
	    $salonDetail['SalonService']['eng_name']= $salonService_name;
	    $date = $appointment_detail['selected_date'];
	    if($type == 'eAppointment'){
		$template = 'new_appointment';
		$confirmtemplate = 'confirmation_appointment';
		$message = "New Appointment for the Service $salonService_name has been scheduled on date : $date . Order id is $display_order_id";
	    }else{
		$template = 'reschedule_appointment';
		$confirmtemplate = 'reschedule_confirmation';
		$message = "Appointment for the Service $salonService_name has been rescheduled on date : $date .Order id is $display_order_id";
	    }
	    
	    $ret_provider_status =  $this->Common->EmailTemplateType($salonDetail['SalonService']['salon_id']);
                                               
	    if($ret_provider_status['SalonEmailSms']['business_sms_notify_provider']==1){
		 $this->sendUserPhone($serviceStaff, $salonService_name,$appointment_detail,$message,'vendor');
	    }
	    if($ret_provider_status['SalonEmailSms']['business_nofity_provider']==1){
		 $this->sendUserEmail($serviceStaff, $salonDetail,$appointment_detail,$template,'vendor',$display_order_id);
	    }
	   
	   
	    // Send email to Booking Incharge
	    $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'UserDetail.booking_incharge'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$salonID,'User.id'=>$salonID))));
	    foreach($SalonBookingIncharges as $incharge){
		  
		$this->sendUserEmail($incharge, $salonDetail,$appointment_detail,$template,'vendor',$display_order_id);
		$this->sendUserPhone($incharge, $salonService_name,$appointment_detail,$message);
		    
	    }
	    $userDetail = $this->User->find('first' , array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
	    $this->sendUserEmail($userDetail, $salonDetail,$appointment_detail,$confirmtemplate,'NULL',$display_order_id);
	    $this->sendUserPhone($userDetail, $salonService_name,$appointment_detail,$message);
    
   }
   
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
   
   public function points_deduction($variable){
	
	$this->loadModel("UserPoint");
	$this->loadModel("UserCount");
	
	$user_counts['UserPoint']['salon_id'] = $variable['salon_id'];
	$user_counts['UserPoint']['user_id'] = $variable['user_id'];
	$user_counts['UserPoint']['points_deducted'] = $variable['points_deducted'];
	$user_counts['UserPoint']['type'] = $variable['points_deducted'];
	$user_counts['UserPoint']['appointment_id'] = $variable['appointment_id'];
	$this->UserPoint->create();
	$this->UserPoint->save($user_counts,false);
	
	$this->UserCount->updateAll(array('UserCount.user_count' =>'UserCount.user_count -'.$variable['points_deducted']), array('UserCount.salon_id' => $variable['salon_id'],'UserCount.user_id' =>  $variable['user_id']));
    
   }
   
   /**********************************************************************************    
  @Function Name : bookmarks
  @Params	 : NULL
  @Description   : Bookmarks orders in users account profile
  @Author        : Niharika Arora
  @Date          : 21-June-2015
***********************************************************************************/    
    public function bookmarks(){
        $this->loadModel('Bookmark');
        $this->layout = 'ajax';
        $user = $this->Auth->user('id');
        $number_records = 10;
        $order = 'Bookmark.created desc';
        if($this->request->isAjax()){
            if(!empty($this->request->data)){
                if(isset($this->request->data['filter_list'])){
                    $filter = $this->request->data['filter_list'];
                    $reset = '1';
                    if($filter == 1){
                        $order = 'Bookmark.created desc';
                    }elseif($filter == 0){
                        $order = 'Bookmark.created asc';
                    }else{
                        $order = 'Bookmark.created asc';
                    }
                }
            }
       }
        $this->Paginator->settings = array(
		'Bookmark' => array(
		    'recursive'=>1,
                    'conditions'=>array('Bookmark.user_id'=>$user),
                    'joins'=>array(
                        array(
                            'table'=>'salons',
                            'type'=>'inner',
                            'alias'=>'Salon',
                            'conditions'=>array('Bookmark.salon_id = Salon.user_id')
                        ),array(
                            'table'=>'users',
                            'type'=>'left',
                            'alias'=>'User',
                            'conditions'=>array('User.id = Salon.user_id')
                        ),
                    ),
                    'fields'=> array('Bookmark.id','Salon.*','User.id','User.first_name','User.last_name'),
                    'order' => $order
		)
	    );
        $getSalon = $this->Paginator->paginate('Bookmark');
        $this->set(compact('getSalon'));
        if(isset($this->request->data['filter_list']) &&  $this->request->data['filter_list'] !='' ) {
            $this->viewPath = "Elements/frontend/Myaccount";
	    $this->render('bookmarktable');
        }else{
	    $this->render('bookmarks');

        }
    }
    
    /**********************************************************************************    
  @Function Name : reviews
  @Params	 : NULL
  @Description   : Reviews in users account profile
  @Author        : Niharika Arora
  @Date          : 21-June-2015
***********************************************************************************/    
    //public function reviews(){
    //    $this->viewPath = "Elements/frontend/Myaccount";
    //    $this->render('coming_soon');
    //}
    
    /**********************************************************************************    
  @Function Name : products
  @Params	 : NULL
  @Description   : Products in users account profile
  @Author        : Niharika Arora
  @Date          : 21-June-2015
***********************************************************************************/    
    public function products(){
        $this->viewPath = "Elements/frontend/Myaccount";
        $this->render('coming_soon');
        
    }
    
    /**********************************************************************************    
  @Function Name : salon_updates
  @Params	 : NULL
  @Description   : Salon Updates orders in users account profile
  @Author        : Niharika Arora
  @Date          : 21-June-2015
***********************************************************************************/    
    public function salon_updates(){
        $this->viewPath = "Elements/frontend/Myaccount";
        $this->render('coming_soon');
        
    }
    
     /**********************************************************************************    
  @Function Name : view_gift
  @Params	 : NULL
  @Description   : Salon Updates orders in users account profile
  @Author        : Niharika Arora
  @Date          : 21-June-2015
***********************************************************************************/    
    public function view_gift($id = null){
        $this->loadModel('GiftCertificate');
        $view_detail = $this->GiftCertificate->find('first',array('conditions'=>array('GiftCertificate.id'=>$id),'fields'=>'GiftCertificate.image'));
        $this->set('detail',$view_detail);
        
    }
    
   function sendUserEmail($userData=array() , $serviceDetail = array(),$appointment_detail=array(), $template='',$type =NULL, $display_order_id=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $service_name = $serviceDetail['SalonService']['eng_name'];
        $date = $appointment_detail['selected_date'];
        $time = $appointment_detail['selected_time'];
	$duration = $appointment_detail['duration'];
	$id = $appointment_detail['id'];
	$vendor_msg = $this->Common->get_vendor_message(@$serviceDetail['SalonService']['salon_id']);
        $dynamicVariables = array('{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{time}'=> $time,
                                  '{start_date}'=>$date,
                                  '{service_name}'=>$service_name,
                                  '{appointment_id}'=>$id,
				  '{duration}'=> $this->Common->get_mint_hour($duration),
				  '{id}'=>$id,
				  '{vendor_message}' => $vendor_msg,
				  '{order_id}'=>$display_order_id,
                                  );
	 if($template =='confirmation_appointment'){
	    $employee_id   =   $appointment_detail['staff_id'];
	    $employee_name =   $this->Common->employeeName($employee_id);
	    $salonDetail   =   $this->Common->salonDetail($serviceDetail['SalonService']['salon_id']); 
	    $dynamicVariables['{service_provider}'] = $employee_name['User']['first_name'].' '.$employee_name['User']['last_name'];
	    $dynamicVariables['{Salon}'] = $salonDetail['Salon']['eng_name'];
	    $contact = '';
	    if(!empty($salonDetail['Contact']['day_phone'])){
		$contact = $salonDetail['Contact']['country_code'].' '.$salonDetail['Contact']['day_phone'];
	    }
	    $dynamicVariables['{salon_contact_number}'] = $contact;
	    /**************Points varibale is set as duration****************/
	    $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($duration);
	 }  
	$template_type =  $this->Common->EmailTemplateType($serviceDetail['SalonService']['salon_id']);
        if($template_type){
          $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
        }
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
      function sendUserPhone($getData=array(), $serviceName = array(), $appointment_detail=array(),$message = null, $type=null){
            $this->loadModel('User');
	    $firstName = $getData['User']['first_name'];
            $lastName = $getData['User']['last_name'];
            $date = @$appointment_detail['selected_date'];
            $time = @$appointment_detail['selected_time'];
           
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
	
	
    function bookeVoucherAppnmnt(){
	$this->autoRender = false;
	if($this->request->data){
	    $this->loadModel('Evoucher');
	    $this->loadModel('SalonService');
	    $this->loadModel('Appointment'); 
	    $this->loadModel('User');
	    $this->Evoucher->bindModel(array('belongsTo'=>array('Order')));
	    if(isset($this->request->data['Appointment'])){
		    //pr($this->request->data['Appointment']);
		    //exit;
		    $modifiedDate = strtotime(date('Y-m-d h:i:s'));
		    $eVoucherDetail = $this->Evoucher->find('first',array('fields'=>array('Evoucher.used','Order.salon_service_id','Order.price_option_id','Evoucher.price','Evoucher.user_id','Evoucher.salon_id'),'conditions'=>array('Evoucher.id'=>$this->request->data['Evoucher']['id'])));
if(isset($this->request->data['Appointment']['thetype']) && ($this->request->data['Appointment']['thetype'] == 'Package'||$this->request->data['Appointment']['thetype'] == 'Spaday')){
			    $serviceIds  = array();
			    if(!empty($this->request->data['Appointment']['service'])){
				foreach($this->request->data['Appointment']['service'] as $key => $Packageservice){
				    $serviceIds[] = $key;    
				}
			    }
			    $orderID = $this->request->data['Order']['id'];
			    $orderData = $this->Common->get_Order($orderID);
			    $display_order_id = $orderData['Order']['display_order_id'];
			    
			    $package_name = $this->request->data['Order']['eng_service_name'];
			    $appointment_detail =  $this->request->data['Appointment'];
			    $salon_id =  $this->request->data['Evoucher']['salon_id'];
			    $thetype =  $appointment_detail['thetype'];
			    $date = $appointment_detail['package_date'];
			    $package_price = $appointment_detail['package_price'];
			    unset($this->request->data['Appointment']); 
			    $this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('SalonServiceImage','SalonStaffService','PackageService')));
                            $serviceDetails = $this->SalonService->find('all',array('conditions'=>array('SalonService.id'=>$serviceIds)));
			    if(!empty($serviceDetails)){
				 foreach($serviceDetails as $serviceDetail){
				   // pr($serviceDetail);
				    $serviceId = $serviceDetail['SalonService']['id'];
				    $duration = $appointment_detail['service'][$serviceId]['duration'];
				    $this->request->data['Appointment']['salon_service_id'] = $serviceDetail['SalonService']['id'];
				    $this->request->data['Appointment']['salon_staff_id'] = trim($appointment_detail['service'][$serviceId]['stylist']);
				    $this->request->data['Appointment']['appointment_title']=$serviceDetail['SalonService']['eng_name'];
				    $pricingoptions = explode('-' ,$appointment_detail['package_price_opt']);  
				    $this->request->data['Appointment']['appointment_duration'] = $duration;
				    $this->request->data['Appointment']['user_id']=$this->Auth->user('id');
				    $this->request->data['Appointment']['appointment_price']=$appointment_detail['package_price'];
				    $this->request->data['Appointment']['package_id'] = $appointment_detail['package_id'];
				    if($appointment_detail['thetype'] == 'Spaday'){
					
					$this->request->data['Appointment']['type'] = 'S';
					
				    }else{
					$this->request->data['Appointment']['type'] = 'PAC';
				    }
				    if(isset($this->request->data['Deal']['id']) && !empty($this->request->data['Deal']['id'])){
					$appointmentData['Appointment']['deal_id'] = $this->request->data['Deal']['id'];
					 $this->request->data['Appointment']['type'] = 'D';
				    }
				    $this->request->data['Appointment']['appointment_created']=date('Y-m-d h:i:s');
				    $this->request->data['Appointment']['appointment_repeat_type'] = 0;
				    $this->request->data['Appointment']['order_id'] = $orderID;
				    $this->request->data['Appointment']['evoucher_id'] = $this->request->data['Evoucher']['id'];
				    $this->request->data['Appointment']['startdate'] = $appointment_detail['package_date'];
				    $this->request->data['Appointment']['appointment_start_date']= strtotime($appointment_detail['package_date'].' '.trim($appointment_detail['service'][$serviceId]['time']));
				   
				    $this->request->data['Appointment']['appointment_return_request'] = 'NR';
				    $this->request->data['Appointment']['status'] = 1;
				    $this->request->data['Appointment']['salon_id'] = $serviceDetail['SalonService']['salon_id'];
				    $this->Appointment->create();
				    
				    $this->Appointment->save($this->request->data['Appointment'],false);
				    
				    $appointmentID =  $this->Appointment->getLastInsertId();
				    // create history
				    $historyData = '';
				    $historyData['appointment_id'] = $appointmentID;
				    $historyData['appointment_date'] = strtotime($appointment_detail['package_date'].' '.trim($appointment_detail['service'][$serviceId]['time']));
				    $historyData['duration'] = $duration;
				    $historyData['service_name'] = $serviceDetail['SalonService']['eng_name'];
				    $historyData['staff_id'] = '-';
				    $historyData['modified_by'] = $this->Auth->User('id');
				    $historyData['modified_date'] = $modifiedDate;
				    $historyData['order_id'] = $orderID; 
				    $historyData['status'] = 'Paid';
				    $historyData['type'] = 'package';
				    $historyData['action'] = 'Appointment Booked from eVoucher';
				    $this->create_appointment_history($historyData);
				     
				 
				    $ServiceUser = $this->User->find('first', array('conditions'=>array('User.id'=>trim($appointment_detail['service'][$serviceId]['stylist']),'User.status'=>1)));
				    // Send email to Staff
				    if(isset($ServiceUser['UserDetail']['email_reminder']) && ($ServiceUser['UserDetail']['email_reminder']==1)){
                                         $details['selected_time']= $time = trim($appointment_detail['service'][$serviceId]['time']);
					 $details['selected_date']= $date;
					 $details['duration'] = $duration;
					 $details['staff_id'] = trim($appointment_detail['service'][$serviceId]['stylist']);
                                         $date = $appointment_detail['package_date'];
                                         $message = "You have new  appointment for the Service".  $serviceDetail['SalonService']['eng_name'] ." on date : $date $time . Order id is $display_order_id";
					 
					 $ret_provider_status =  $this->Common->EmailTemplateType($serviceDetail['SalonService']['salon_id']);
                                        
					if($ret_provider_status['SalonEmailSms']['business_sms_notify_provider']==1){
					     $this->sendUserPhone($ServiceUser, $serviceDetail, $details ,$message,'vendor');
					}
					if($ret_provider_status['SalonEmailSms']['business_nofity_provider']==1){
					     $this->sendUserEmail($ServiceUser, $serviceDetail ,$details ,'new_appointment','vendor');
					}
					
                                    }
				}
				
				$this->Evoucher->id = $this->request->data['Evoucher']['id']; 
				$this->Evoucher->saveField('used',1);
				   // Send email to Booking INcahrge
				
				    $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'UserDetail.booking_incharge'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$salon_id,'User.id'=>$salon_id))));
				    foreach($SalonBookingIncharges as $incharge){
					  
					    $message = "You have new online  appointment for the $thetype  $package_name  on date : $date. Order id is $display_order_id ";
					    $this->sendUserPackageEmail($incharge, $serviceDetails,$appointment_detail,$package_name ,$orderID ,$package_price ,'new_package','vendor');
					    $details['selected_date']= $date = $appointment_detail['package_date'];
					    $details['selected_time']=  '';
					    $this->sendUserPhone($incharge, $serviceDetails,$details,$message,'vendor');
					    
				    }
				    
				    //Send email to User
				    
				    $date = $appointment_detail['package_date'];
				    $details['selected_date']= $date;
				    $details['selected_time']=  '';
				    $package_price = $appointment_detail['package_date'];
				    $userDetail = $this->Session->read('Auth');
				    $message = "$thetype  $package_name  on date : $date has been successfully booked. Order id is $display_order_id";
                                    $this->sendUserPackageEmail($userDetail, $serviceDetails, $appointment_detail,$package_name, $orderID,$package_price ,'confirmation_package');
                                    $this->sendUserPhone($userDetail, $serviceDetails,$details ,$message);
				    $this->Session->delete('EVOUCHER.BOOKAPPOINTMENT');
				    $this->Session->delete('EVOUCHER.ISDEAL');
				    $this->Session->setFlash('Your appointment has been booked successfully.', 'flash_success');
				    $this->redirect(array('controller'=>'Myaccount','action'=>'appointments'));
				   
			    }else{
				$this->Session->setFlash('Your Package couldn\'t be booked.', 'flash_error');
				$this->redirect(array('controller'=>'users','action'=>'AccountManagement'));
			    }
			    
			    
			}else{
			    //pr($this->request->data);
			    //exit;
			    $orderID = $this->request->data['Order']['id'];
			    // $appointmentData['Appointment']['time'] = $this->request->data['Appointment']['selected_time'];
			    $appointmentData['Appointment']['time'] = $this->request->data['Appointment']['selected_time']; 
			    $appointmentData['Appointment']['salon_service_id'] = $this->request->data['Appointment']['service_id'];     
			    $appointmentData['Appointment']['salon_staff_id'] = $this->request->data['Appointment']['selected_employee_id'];
			    $appointmentData['Appointment']['appointment_price'] = $eVoucherDetail['Evoucher']['price'];
			    $appointmentData['Appointment']['appointment_duration'] = $this->request->data['Appointment']['duration'];
			    $appointmentData['Appointment']['user_id']= $eVoucherDetail['Evoucher']['user_id'];
			    $appointmentData['Appointment']['order_id']= $orderID;
			    $appointmentData['Appointment']['evoucher_id'] = $this->request->data['Evoucher']['id'];
			    $appointmentData['Appointment']['appointment_created']=date('Y-m-d h:m:s');
			    $appointmentData['Appointment']['appointment_repeat_type'] = 0;
			    $appointmentData['Appointment']['startdate'] = $this->request->data['Appointment']['selected_date'];
			    $appointmentData['Appointment']['appointment_start_date']= strtotime($this->request->data['Appointment']['selected_date'].' '.$this->request->data['Appointment']['selected_time']);
			    $appointmentData['Appointment']['type'] = 'A';
			    $appointmentData['Appointment']['appointment_return_request'] = 'NR';
			    $appointmentData['Appointment']['status'] = 4;
			    $appointmentData['Appointment']['salon_id'] = $eVoucherDetail['Evoucher']['salon_id'];
			//    if($this->Session->check('EVOUCHER.ISDEAL')){
			//	 $appointmentData['Appointment']['deal_id'] = $this->request->data['Deal']['id']; 
			//    }
			    if(isset($this->request->data['Deal']['id']) && !empty($this->request->data['Deal']['id'])){
				$appointmentData['Appointment']['deal_id'] = $this->request->data['Deal']['id'];
				$appointmentData['Appointment']['type'] = 'D';
			    }
			    //pr($appointmentData);
			    //exit;
			    if($this->Appointment->save($appointmentData,false)){
				 $appointmentID =  $this->Appointment->getLastInsertId();
				
				// create history
				$historyData = '';
				$historyData['appointment_id'] = $appointmentID;
				$historyData['appointment_date'] = strtotime($this->request->data['Appointment']['selected_date'].' '.$this->request->data['Appointment']['selected_time']);
				$historyData['duration'] = '-';
				$historyData['service_name'] = '-';
				$historyData['staff_id'] = '-';
				$historyData['modified_by'] = $this->Auth->User('id');
				$historyData['modified_date'] = strtotime(date('Y-m-d h:i:s'));
				$historyData['order_id'] = $orderID; 
				$historyData['status'] = 'paid';
				$historyData['type'] = 'service';
				$historyData['action'] = 'Appointment Booked from eVoucher';
				$this->create_appointment_history($historyData);
				 
				 $appointment_detail['selected_date'] = $this->request->data['Appointment']['selected_date'];
				 $appointment_detail['selected_time'] = $this->request->data['Appointment']['selected_time'];
				 $appointment_detail['staff_id'] = $this->request->data['Appointment']['selected_employee_id'];
				 $this->Evoucher->id = $this->request->data['Evoucher']['id']; 
				 $this->Evoucher->saveField('used',1);
				 $this->Session->delete('EVOUCHER.BOOKAPPOINTMENT');
				 $this->Session->delete('EVOUCHER.ISDEAL');
				 
				 $orderData = $this->Common->get_Order($orderID);
			         $display_order_id = $orderData['Order']['display_order_id'];
				 
				 $this->sendAppointmentMail($appointmentID,$appointment_detail,'eAppointment',$display_order_id);
				 $this->Session->setFlash('Your appointment has been booked successfully.', 'flash_success');
				 $this->redirect(array('controller'=>'Myaccount','action'=>'appointments'));
			    }else{
				 $this->Session->setFlash('Your appointment couldn\'t be booked.', 'flash_error');
				 $this->redirect(array('controller'=>'users','action'=>'AccountManagement'));
			    }
			}
		}else{
		   
		        $orderID = $this->request->data['order_id'];
			$isDeal = $this->request->data['deal'];
			$evoucherId = $this->request->data['evoucher_id'];
			$eVoucherDetail = $this->Evoucher->find('first',array('fields'=>array('Evoucher.used','Order.salon_service_id','Order.price_option_id','Evoucher.price'),'conditions'=>array('Evoucher.id'=>$evoucherId,'Evoucher.order_id'=>$orderID)));
			
			if($eVoucherDetail){
			    if($eVoucherDetail['Evoucher']['used']==0){
				$this->Session->delete('EVOUCHER');
				$this->Session->write('EVOUCHER.BOOKAPPOINTMENT',true);
				//if($isDeal){
				//    $this->Session->write('EVOUCHER.ISDEAL',true);
				//}
				$this->Session->delete('APPOINTMENT.RESCHEDULE');
				$this->Session->delete('Deal');
				echo "true";
				exit;
				
			    }else{
				echo "used";
				exit;
			    }
			}else{
				echo "invalid";
				exit;
			}
		}
	}
    }
   
    function sendStaffEmailPhone($appointment_detail = array(),$serviceDetail = array() , $display_order_id = NULL){
	$ServiceUser = $this->User->find('first', array('conditions'=>array('User.id'=>trim($appointment_detail['staff_id']),'User.status'=>1)));
	// Send email to Staff
	if($ServiceUser['UserDetail']['email_reminder']==1){
	     $time = $appointment_detail['selected_time'];
	     $date = $appointment_detail['selected_date'];
	     $duration = $appointment_detail['duration'];
	    // $date = $appointment_detail['package_date'];
	      $message = "You have new  appointment for the Service".  $appointment_detail['service_name'] ." on date : $date $time . Order id is $display_order_id";
	      $ret_provider_status =  $this->Common->EmailTemplateType($serviceDetail['SalonService']['salon_id']);
	      if($ret_provider_status['SalonEmailSms']['business_sms_notify_provider']==1){
		    $this->sendUserPhone($ServiceUser, $appointment_detail['service_name'], $appointment_detail ,$message,'vendor');
	       }
	       if($ret_provider_status['SalonEmailSms']['business_nofity_provider']==1){
		    $this->sendUserEmail($ServiceUser, $serviceDetail,$appointment_detail ,'new_appointment','vendor');
	       }

	    
	}
	return true;
    }
 
    function sendUserPackageEmail($userData=array() , $serviceDetails = array(),$appointment_detail,$package =array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;
        $thetype = $appointment_detail['thetype'];
        //$service_name = $serviceDetail['SalonService']['eng_name'];
        $service_name = array();
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
	$vendor_msg = $this->Common->get_vendor_message(@$serviceDetail['SalonService']['salon_id']);
	$dynamicVariables = array(
                                  '{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{amount}' => $amount,
                                  '{package_name}'=> $package,
                                  '{order_id}'=>$order_id,
                                  '{service}'=> $serviceData,
                                  '{package_date}'=>$appointment_detail['package_date'],
                                  '{package}'=>$thetype,
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
    
    
    function cancel_email_sms($order_id = null){
	
	if($order_id){
	    $this->Order->bindModel(array('hasMany'=>array('Appointment')));
	    $this->loadModel('Order');
	    $appointment = $this->Order->find("first",array('contain'=>array('Appointment'=>array('fields'=>array('Appointment.id','Appointment.salon_staff_id','Appointment.appointment_title','Appointment.salon_id','Appointment.appointment_duration','Appointment.appointment_start_date'))),'fields'=>array('Order.id','Order.service_type','Order.eng_service_name','Order.display_order_id','Order.salon_id'),'conditions'=>array('Order.id'=>$order_id)));
	   
	    $fromEmail = Configure::read('noreplyEmail');
	    if(!empty($appointment)){
		$type = $appointment['Order']['service_type'];
		$salon_id = $appointment['Order']['salon_id'];
		
		switch($type){
		    case 1:
			$sType = "Service";
			break;
		    case 2:
			$sType = "Package";
			break;
		    case 3:
			$sType = "Spa Day";
			break;
		    case 5:
			$sType = "Deal";
			break;
		}
	   
	    $serviceData = '';
	    if(!empty($appointment['Appointment'])){
		foreach($appointment['Appointment'] as $singleAppointment){
		    $this->loadModel('User');
		    $ServiceUser = $this->User->find('first', array('conditions'=>array('User.id'=>trim($singleAppointment['salon_staff_id']),'User.status'=>1)));
		    // Send email to Staff
		    $dateTime = date('Y-m-d h:i A',$singleAppointment['appointment_start_date']);
			 $duration = $this->Common->get_mint_hour($singleAppointment['appointment_duration']);
			 $appointment_detail['selected_date']  = date('Y-m-d ',$singleAppointment['appointment_start_date']);
			 $appointment_detail['selected_time']  = date('h:i A',$singleAppointment['appointment_start_date']);
		   
			 
			// $date = $appointment_detail['package_date'];
			  $message = "Appointment for the Service".  $singleAppointment['appointment_title'] ." on date : $dateTime. has been cancelled . Order id is". $appointment['Order']['display_order_id']."";
			  $ret_provider_status =  $this->Common->EmailTemplateType($singleAppointment['salon_id']);
			if($ServiceUser['UserDetail']['sms_reminder']==1){
			    if($ret_provider_status['SalonEmailSms']['business_sms_notify_provider']==1){
				  $this->sendUserPhone($ServiceUser, $singleAppointment['appointment_title'], $appointment_detail ,$message,'vendor');
			     }
			}
		    if($ServiceUser['UserDetail']['email_reminder']==1){
			   if($ret_provider_status['SalonEmailSms']['business_nofity_provider']==1){
				$toEmail = $ServiceUser['User']['email'];
				$template = 'cancel_backend_appointment';
				$dynamicVariables = array('{order_id}'=>$appointment['Order']['display_order_id'],'{FirstName}'=>$ServiceUser['User']['first_name'],'{LastName}' =>$ServiceUser['User']['last_name'],'{service_name}'=>$singleAppointment['appointment_title'],'{start_date}'=>$appointment_detail['selected_date'],'{time}'=>$appointment_detail['selected_time'],'{duration}'=>$duration);
				$this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
			   }
		    }
		    
		    $serviceData  .= '<tr><td style="text-align:center">-</td></tr><tr><td style="text-align:center"> Service Name :' . $singleAppointment['appointment_title'].'</td></tr><tr><td style="text-align:center"> Date :'. $appointment_detail['selected_date'] .' </td> </tr> <tr><td style="text-align:center">Time :'.$appointment_detail['selected_time'].' </td></tr><tr><td style="text-align:center">Duration :'.$duration.'</td></tr>';
		}
	    }
	  // pr($serviceData);
	   //exit;
	    // Send email to Booking Incharge
	    
		$SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'UserDetail.booking_incharge'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$salon_id,'User.id'=>$salon_id))));
		foreach($SalonBookingIncharges as $incharge){
		    $message = "Appointment for the". $sType." ".  $appointment['Order']['eng_service_name'] ." on date : $dateTime. has been cancelled . Order id is". $appointment['Order']['display_order_id']."";  
		    $toEmail = $incharge['User']['email'];
		    $template = 'cancel__appointment';
		    $dynamicVariables = array('{type}'=>$sType,'{service_name}'=>$appointment['Order']['eng_service_name'],'{order_id}'=>$singleAppointment['display_order_id'],'{FirstName}'=>$incharge['User']['first_name'],'{LastName}' =>$incharge['User']['last_name'],'{service_details}'=>$serviceData);
		    $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
		    $this->sendUserPhone($incharge, $appointment['Order']['eng_service_name'],$appointment_detail,$message);
			
		}
		return true;
	     }
	}else{
	    return false;
	}
   }
    
    
    /**********************************************************************************    
    @Function Name : giftDetails
    @Params	 : NULL
    @Description   : gift details in users account profile
    @Author        : Sonam Mittal
    @Date          : 5-Aug-2015
  ***********************************************************************************/
   
    public function gift_details($id=null){
        $this->loadModel('GiftCertificate');
        $this->GiftCertificate->bindModel(array(
            'hasMany' => array(
                'GiftDetail' => array(
                    'className' => 'GiftDetail',
                    'foreignKey' => 'gift_id'
                )
            )
        ));
        $giftcertificate = $this->GiftCertificate->find('first',array(
            'conditions'=>array(
                'GiftCertificate.id'=>$id
            )
        ));
        $this->set(compact('giftcertificate'));
    }
    
    
    
    
     public function reviews($is_out = null){
	$this->loadModel('Order');
        $this->loadModel('Appointment');
	$this->Order->unbindModel(array('belongsTo'=>array('Appointment')));
	$this->Appointment->bindModel(array('belongsTo'=>array('Order','SalonService','Review')));
	//$this->Order->bindModel(array('belongsTo'=>array('Review')));
        $userId = $this->Auth->user('id');
	$current_date =time();
        $fields = array('Order.id','Order.appointment_id','Order.salon_service_id','Order.duration','Order.amount','Order.orignal_amount','Order.salon_service_id','Order.salon_id','Order.eng_service_name','Order.ara_service_name','Appointment.salon_id','Appointment.package_id','Appointment.id','Appointment.status','Appointment.salon_service_id','SUM(Appointment.appointment_duration) as Duration,SUM(Appointment.appointment_price) as Price','Appointment.appointment_start_date','Appointment.deal_id','SalonService.*','Review.*');
        $number_records = 10;
        $class='';
	//echo $is_past;
        /**** Past appointments ******/
        if(!empty($is_out)){
            $conditions = array("not" => array("Appointment.order_id" => null),'Appointment.user_id'=>$userId, 'Appointment.type'=>'A','Appointment.is_review' =>1);
            $class="past";
        }else{
            $conditions = array("not" => array("Appointment.order_id" => null,"Appointment.status" =>5),'Appointment.user_id'=>$userId, 'Appointment.type'=>'A','Appointment.is_review' =>0 ,'Appointment.status' => 3);
	    // $conditions = array("not" => array("Appointment.order_id" => null),'Appointment.user_id'=>$userId, 'Appointment.type'=>'A','Appointment.is_review' =>0,'Appointment.appointment_start_date > ' => $current_date);
            $class="now";
        }
        /**** Past appointments ******/ 
	$this->Paginator->settings = array(
		'Appointment' => array(
		     //'recursive'=>2,
		    'limit' => $number_records,
		    'conditions' => $conditions,
		    'fields' => $fields,
		    'order' => array('created' => 'desc'),
		    'group'=> 'Appointment.order_id, Appointment.evoucher_id'
		)
	);
        $orders = $this->Paginator->paginate('Appointment');
	//pr($orders);
	//exit;
        $this->set(compact('orders','class'));
	
	if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'default';
        }
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

    
/**********************************************************************************    
  @Function Name : view_voucher_detail
  @Params	 : NULL
  @Description   : Display voucher details  in users account profile
  @Author        : Sonam Mittal
  @Date          : 25-May-2015
***********************************************************************************/    
    public function view_voucher_detail($order_id = null){
        $this->loadModel('Order');
        $this->Order->unbindModel(array('belongsTo'=>array('Appointment','SalonService')));
	$this->Order->bindModel(array('hasMany'=>array('Evoucher'),'hasOne'=>array('GiftCertificate')));
        $order = $this->Order->findById($order_id);
        //pr($order); exit;
		$this->set(compact('order'));
    }
    
    
    
    
}
