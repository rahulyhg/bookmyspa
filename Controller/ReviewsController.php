<?php

class ReviewsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email','RequestHandler', 'Cookie','Image','PHPMailer','Common','Acl','Paginator'); //An array containing the names of components this controller uses.

    public function beforeFilter() {
        $this->Auth->allow('salonreviews','showcomments','send_review_reminder');
        parent::beforeFilter();
    }
    
/**********************************************************************************    
  @Function Name : index
  @Params	 : NULL
  @Description   : My Account
  @Author        : Shiv Kumar
  @Date          : 23-Oct-2015
***********************************************************************************/
    public function addReview($order_id =null,$type_id =null,$salon_id =null){
        //echo $type_id; die;
        $userId = $this->Auth->user('id');
        $this->layout = false;
        $this->set('title_for_layout', 'Add Review');
        $this->loadModel('Appointment');
        if($this->request->data){
            $this->loadModel('ReviewRating');
            if($type_id=='service'){
                //pr($this->request->data); die;
                $errorArray = array();
                if($this->data['ReviewRating']['venue_rating']==0){
                    $errorArray['venue_rating'][] = "venue rating must be added";
                }
                if($this->data['ReviewRating']['staff_rating']==0){
                    $errorArray['staff_rating'][] = "staff rating must be added";
                }
                if($this->data['ReviewRating']['venue_review']==''){
                    $errorArray['venue_review'][] = "venue review must be added";
                }
            }
            if($type_id=='packages'){
                if($this->data['ReviewRating']['venue_rating']==''){
                    $errorArray['venue_rating'][] = "venue rating must be added";
                }
                if($this->data['ReviewRating']['venue_review']==''){
                    $errorArray['venue_review'][] = "venue review must be added";
                }
                for($i=1;$i<count($this->request->data['Service']);$i++){
                    if($this->request->data['Staff']['staff_rating_'.$i]==''){
                        $errorArray['staff_rating_'.$i][] = "staff rating must be added";
                    }
                }
            }   
           //pr($errorArray); die;
           if(!empty($errorArray)){
            
            $message = __('Unable to add Reviews Rating, Please try again.', true);
                    $vError = $this->ReviewRating->validationErrors;
                    $edata['data'] =$vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
            
           }
            
            //$this->request->data['ReviewRating']['salon_id']=$salon_id;
            if($type_id=='service'){
                $reviewRating['ReviewRating']['user_id']=$this->request->data['ReviewRating']['user_id'];
                $reviewRating['ReviewRating']['service_id']=$this->request->data['ReviewRating']['service_id'];
                $reviewRating['ReviewRating']['staff_id']=$this->request->data['ReviewRating']['staff_id'];
                $reviewRating['ReviewRating']['salon_id']=$this->request->data['ReviewRating']['salon_id'];
                $reviewRating['ReviewRating']['venue_rating']=$this->request->data['ReviewRating']['venue_rating'];
                $reviewRating['ReviewRating']['staff_rating']=$this->request->data['ReviewRating']['staff_rating'];
                $reviewRating['ReviewRating']['venue_review']=$this->request->data['ReviewRating']['venue_review'];
                $save_rating=$this->ReviewRating->save($reviewRating);
            }
            if($type_id=='packages'){
                
                
                for($i=1;$i<count($this->request->data['Service']);$i++){
                    
                $reviewRating['ReviewRating']['user_id']=$this->request->data['ReviewRating']['user_id'];
                $reviewRating['ReviewRating']['package_id']=$this->request->data['ReviewRating']['package_id'];
                $reviewRating['ReviewRating']['salon_id']=$this->request->data['ReviewRating']['salon_id'];
                $reviewRating['ReviewRating']['venue_rating']=$this->request->data['ReviewRating']['venue_rating'];
                $reviewRating['ReviewRating']['venue_review']=$this->request->data['ReviewRating']['venue_review'];    
                    
                $reviewRating['ReviewRating']['service_id']=$this->request->data['Service']['service_id_'.$i];
               
                
                $reviewRating['ReviewRating']['staff_id']=$this->request->data['Staff']['staff_id_'.$i];
               
                
                $reviewRating['ReviewRating']['staff_rating']=$this->request->data['Staff']['staff_rating_'.$i];
                $save_rating=$this->ReviewRating->save($reviewRating);
                }
            }
            
            
            if(isset($save_rating) && $save_rating!=''){
                
                $reviewrating_id=$this->ReviewRating->id;
                $reviewData['Review']['review_rating_id']=$reviewrating_id;
                $reviewData['Review']['order_id']=$order_id;
                $reviewData['Review']['created']=date('Y-m-d h:m:s');
                if($this->Review->save($reviewData)){
                    $review_id=$this->Review->id;
                    $data = array(
                        'Appointment.is_review' => 1,
                        'Appointment.review_id' => $review_id
                    );
                    if($this->Appointment->updateAll($data,array('Appointment.order_id'=> $order_id))){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('Review added successfully',true);
                        echo json_encode($edata);
                        die; 
                    }
                }
            }else{
                    $message = __('Unable to add Reviews Rating, Please try again.', true);
                    $vError = $this->ReviewRating->validationErrors;
                    $edata['data'] =$vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }   
        }
        if($type_id=='service'){
            $service_id = $this->Appointment->find('all',array('fields'=>array('salon_staff_id','salon_service_id'),'conditions'=>array('Appointment.order_id'=>$order_id)));
        }elseif($type_id=='packages'){
            $package_id = $this->Appointment->find('all',array('fields'=>array('salon_staff_id','salon_service_id','package_id'),'conditions'=>array('Appointment.order_id'=>$order_id)));
           // pr($package_id); die;
        }
        //pr($service_id); die;
        $this->set(compact('userId','service_id','salon_id','type_id','package_id'));
    }

    /**********************************************************************************    
      @Function Name : salonreviews
      @Params	 : NULL
      @Description   : The display salon all reviews via Ajax in frontend
      @Author        : Shiv Kumar
      @Date          : 26-Oct-2015
    ***********************************************************************************/

    public function salonreviews($salonId = NULL, $empID = NULL){
        $this->loadModel('Order');
        $this->loadModel('Appointment');
	$this->loadModel('User');
	$this->loadModel('Review');
	$this->loadModel('ReviewRating');
        $this->loadModel('ReviewComment');
	$this->User->bindModel(array('hasOne'=>array('UserDetail')));
	$this->Order->unbindModel(array('belongsTo'=>array('Appointment')));
	$this->Appointment->bindModel(array('belongsTo'=>array('Order','SalonService','Evoucher','User','Review')));
	$current_date =time();
	$this->Appointment->virtualFields['appoitment_start_date'] = 0;
        $fields = array('Appointment.salon_id','Appointment.package_id','Appointment.id','Appointment.status','Appointment.salon_service_id','Appointment.appointment_duration','SUM(Appointment.appointment_duration) as Duration,SUM(Appointment.appointment_price) as Price','MIN(Appointment.appointment_start_date) as Appointment_appoitment_start_date','Appointment.deal_id','Appointment.order_id','User.id','User.image','User.first_name','User.last_name','SalonService.eng_name','Review.id','UserDetail.id','Address.city_id','ReviewRating.id','ReviewRating.venue_rating','ReviewRating.staff_rating','ReviewRating.venue_review','ReviewRating.created','Provider.id','Provider.image','Provider.first_name','Provider.last_name','HelpfulReview.id');
	$joins= array(
        array(
            'alias' => 'UserDetail',
            'table' => 'user_details',
            'type' => 'INNER',
            'conditions' => '`User`.`id` = `UserDetail`.`user_id`'
        ),
	array(
            'alias' => 'Address',
            'table' => 'addresses',
            'type' => 'INNER',
            'conditions' => '`User`.`id` = `Address`.`user_id`'
        ),
	array(
            'alias' => 'ReviewRating',
            'table' => 'review_ratings',
            'type' => 'INNER',
            'conditions' => '`Review`.`review_rating_id` = `ReviewRating`.`id`'
        ),
        array(
            'alias' => 'HelpfulReview',
            'table' => 'helpful_reviews',
            'type' => 'LEFT',
            'conditions' => '`Review`.`id` = `HelpfulReview`.`review_id`'
        ),
	array(
            'alias' => 'Provider',
            'table' => 'users',
            'type' => 'INNER',
            'conditions' => '`Appointment`.`salon_staff_id` = `Provider`.`id`'
        )
        
    );
	$number_records = 10;
        $class = '';
	/**** Past appointments ******/
        $conditions = array("not" => array("Appointment.order_id" => null),'Appointment.is_review' => 1,'Appointment.salon_id' => $salonId);
        $class="now";
        /**** Past appointments ******/
	$this->Paginator->settings = array(
		'Appointment' => array(
		    'limit' => $number_records,
		    'conditions' => $conditions,
		    'joins'=>$joins,
		    'fields' => $fields,
		    'order' => array('Order.id' => 'desc'),
		    'group'=> 'Appointment.order_id, Appointment.evoucher_id '
		)
	);
        $orders = $this->Paginator->paginate('Appointment');
        //pr($orders); die;
	$this->set(compact('orders','class'));
	if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'default';
        }
	$this->set('salonId',$salonId);
        $this->set('loggedIn',$this->Auth->user('id'));
         
    }
    public function add_comment(){
        //pr($this->request->data);
        //die("test");
        $this->loadModel('ReviewComment');
        $reviewComment['ReviewComment']['review_id']=$this->request->data['reviewId'];
        $reviewComment['ReviewComment']['user_id']=$this->Auth->user('id');
        $reviewComment['ReviewComment']['comment_text']=$this->request->data['commentText'];
        $this->ReviewComment->save($reviewComment);
        die;
    }
    public function showcomments($salonId = NULL, $reviewId = NULL){
        $this->loadModel('Order');
        $this->loadModel('Appointment');
	$this->loadModel('User');
	$this->loadModel('Review');
	$this->loadModel('ReviewRating');
        $this->loadModel('ReviewComment');
	$this->User->bindModel(array('hasOne'=>array('UserDetail')));
	$this->Order->unbindModel(array('belongsTo'=>array('Appointment')));
	$this->Appointment->bindModel(array('belongsTo'=>array('Order','SalonService','Evoucher','User','Review')));
	$current_date =time();
	$this->Appointment->virtualFields['appoitment_start_date'] = 0;
        $fields = array('Appointment.salon_id','Appointment.package_id','Appointment.id','Appointment.status','Appointment.salon_service_id','Appointment.appointment_duration','SUM(Appointment.appointment_duration) as Duration,SUM(Appointment.appointment_price) as Price','MIN(Appointment.appointment_start_date) as Appointment__appoitment_start_date','Appointment.deal_id','Appointment.order_id','User.id','User.image','User.first_name','User.last_name','SalonService.eng_name','Review.id','UserDetail.id','Address.city_id','ReviewRating.id','ReviewRating.venue_rating','ReviewRating.staff_rating','ReviewRating.venue_review','ReviewRating.created','Provider.id','Provider.image','Provider.first_name','Provider.last_name');
	$joins= array(
        array(
            'alias' => 'UserDetail',
            'table' => 'user_details',
            'type' => 'INNER',
            'conditions' => '`User`.`id` = `UserDetail`.`user_id`'
        ),
	array(
            'alias' => 'Address',
            'table' => 'addresses',
            'type' => 'INNER',
            'conditions' => '`User`.`id` = `Address`.`user_id`'
        ),
	array(
            'alias' => 'ReviewRating',
            'table' => 'review_ratings',
            'type' => 'INNER',
            'conditions' => '`Review`.`review_rating_id` = `ReviewRating`.`id`'
        ),
	array(
            'alias' => 'Provider',
            'table' => 'users',
            'type' => 'INNER',
            'conditions' => '`Appointment`.`salon_staff_id` = `Provider`.`id`'
        )
    );
	$number_records = 10;
        $class = '';
	/**** Past appointments ******/
        $conditions = array("not" => array("Appointment.order_id" => null),'Appointment.is_review' => 1,'Appointment.salon_id' => $salonId);
        $class="now";
        /**** Past appointments ******/
	$this->Paginator->settings = array(
		'Appointment' => array(
		    'limit' => $number_records,
		    'conditions' => $conditions,
		    'joins'=>$joins,
		    'fields' => $fields,
		    'order' => array('Order.id' => 'desc'),
		    'group'=> 'Appointment.order_id, Appointment.evoucher_id '
		)
	);
        $orders = $this->Paginator->paginate('Appointment');
        //pr($orders); die;
	$this->set(compact('orders','class'));
	if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'default';
        }
	$this->set('salonId',$salonId);
    }
    function skipreview(){
        $this->loadModel('Appointment');
        $this->Appointment->updateAll(
            array('Appointment.is_review' => 2),
            array('Appointment.order_id' => $this->request->data['order_id'])
        );
        die('1');
    }
    function is_helpful(){
        //die("test");
        $this->loadModel('HelpfulReview');
        $helpfulReview['HelpfulReview']['review_id']=$this->request->data['reviewId'];
        $helpfulReview['HelpfulReview']['user_id']=$this->request->data['userId'];
        $helpfulReview['HelpfulReview']['is_helpful']=1;
        $this->HelpfulReview->save($helpfulReview);
        die('1');
    }
    
    function send_review_reminder(){
        $this->layout = 'ajax';
        App::import('Controller', 'Appointments');
        $Appointments = new AppointmentsController;
        $Appointments->constructClasses();
        $this->loadModel('Appointment');
        $app_id = $this->Appointment->find('all',array('fields'=>array('appointment_title','user_id','salon_service_id','appointment_start_date','appointment_duration'),'conditions'=>array('Appointment.review_id NOT IN(1,2)','Appointment.status'=>3)));
        foreach($app_id as  $app_id){
            $appointment_title=$app_id['Appointment']['appointment_title'];
            $user_id=$app_id['Appointment']['user_id'];
            $serviceName=$this->Common->get_salon_service_name($app_id['Appointment']['salon_service_id']);
            $startTime=$app_id['Appointment']['appointment_start_date'];
            $duration=$app_id['Appointment']['appointment_duration'];
            //pr($User_id); die;
            $Appointments->admin_notify_customer($appointment_title,$user_id,$serviceName,$startTime,$duration,'add_review','customer');
            
        //pr($User_id); die;
        }
        die;
    }
}

?>