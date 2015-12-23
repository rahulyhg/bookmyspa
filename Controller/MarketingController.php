<?php<?php
class MarketingController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Image','Crypto'); //An array containing the names of components this controller uses.

/**********************************************************************************    
    @Function Name  : admin_email
    @Params	    : NULL
    @Description    : For marketing email
    @Author         : Aman Gupta
    @Date           : 10-Mar-2015
***********************************************************************************/
    public function admin_email() {
        $this->layout = 'admin';
        $activeTMenu = 'emailmkt';
        $leftMenu = true;$page_title = 'Email Marketing';
        $this->set(compact('activeTMenu','leftMenu','page_title'));
    }
    
    function admin_plans(){
       $this->loadModel('SmsSubscriptionPlan');
       $plans = $this->SmsSubscriptionPlan->find('all' , array('conditions'=>array('is_deleted'=>0,'status'=>1)));
       $this->layout  =   'admin_paginator';
       $activeTMenu = 'smsplan';
       $leftMenu = true;$page_title = 'Sms Plan';
       $this->set(compact('activeTMenu','leftMenu','page_title','plans'));
    }
    
    function admin_email_plans(){
       $this->loadModel('EmailSubscriptionPlan');
       $plans = $this->EmailSubscriptionPlan->find('all' , array('conditions'=>array('is_deleted'=>0,'status'=>1)));
       $this->layout  =   'admin_paginator';
       $activeTMenu = 'emailplan';
       $leftMenu = true;$page_title = 'Email Plan';
       $this->set(compact('activeTMenu','leftMenu','page_title','plans'));
    }
    
    function admin_paymentDetails($id,$type){
      $this->loadModel('EmailSubscriptionPlan');
      $id = base64_decode($id);
      $model = 'EmailSubscriptionPlan';
      $Plan = $this->EmailSubscriptionPlan->findById($id);
      if(!count($Plan)){
        throw new NotFoundException('Could not found plan');
        die;
      }
      if($Plan[$model]['discount'] > 0){
         $amount =  $Plan[$model]['price'];
       //echo $Plan[$model]['discount'];
        $discounted_amount = round(($amount * $Plan[$model]['discount'])/100 , 2);
        //echo $discounted_amount;
        $amount = $Plan[$model]['price']- $discounted_amount;
      }
      $activeTMenu = 'detail';
      $leftMenu = true;$page_title = 'Payment Detail';
      $this->set(compact('activeTMenu','leftMenu','page_title','Plan','amount'));
    }
    
    public function admin_payment() {
        $this->LoadModel('MarketingOrder');
            pr($this->request->data);
            if(isset($this->request->data['MarketingOrder']) && !empty($this->request->data['MarketingOrder'])){
              $reqData = $this->request->data['MarketingOrder'];
              $plan_id = $reqData['plan_id']; 
              $this->loadMOdel('EmailSubscriptionPlan');
              $plan =$this->EmailSubscriptionPlan->findById($plan_id);
              $reqData['title'] = $plan['EmailSubscriptionPlan']['title'];
              $reqData['discount'] = $plan['EmailSubscriptionPlan']['discount'];
              $reqData['customer_type'] = $plan['EmailSubscriptionPlan']['customer_type'];
              $reqData['orignal_price   '] = $plan['EmailSubscriptionPlan']['price'];
              $reqData['plan_type'] = $plan['EmailSubscriptionPlan']['plan_type'];
              $reqData['display_id'] = $reqData['order_id'];
              $reqData['display_id'] = $reqData['order_id'];
              if($this->MarketingOrder->save($reqData)){
                 if($this->request->is('post') || $this->request->is('put')){
                        //echo '<pre>';  print_r($this->request->data);  die('herere');
                        $working_key=Configure::read('working_key');  //Shared by CCAVENUES
                        $access_code =Configure::read('access_code');  //Shared by CCAVENUES
                        $merchant_data =  '';
                        foreach ($this->request->data['MarketingOrder'] as $key => $value){
                         $merchant_data.=$key.'='.$value.'&';
                        }
                        //echo $merchant_data; 
                        $encrypted_data = $this->Crypto->encrypt($merchant_data,$working_key);
                        //echo $encrypted_data;
                        $this->set(compact('encrypted_data','access_code'));
                        $this->render('../Bookings/payment');
                  }
              }else{
                            $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                            $this->redirect(array('controller'=>'homes','action'=>'index'));  
              }
            }else{
                            $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                            $this->redirect(array('controller'=>'homes','action'=>'index'));  
                
            }
 }
    
        public function admin_payment_return() {
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
            if($order_status){
                $orderData['MarketingOrder']['transaction_id'] = $tracking_id;
                $orderData['MarketingOrder']['amount'] =$amount;
                $orderData['MarketingOrder']['transaction_status'] = $status_message;
                $orderData['MarketingOrder']['status'] = $order_status;
                if($this->MarketingOrder->save($orderData)){
                    if($order_status=='Success'){
                    
                    }else{
                        
                    }
                }else{
                    
                }
                
               
             }else{
                $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                $this->redirect(array('controller'=>'homes','action'=>'index'));     
            }
     }
    
    
    
}
class MarketingController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Image'); //An array containing the names of components this controller uses.

/**********************************************************************************    
    @Function Name  : admin_email
    @Params	    : NULL
    @Description    : For marketing email
    @Author         : Aman Gupta
    @Date           : 10-Mar-2015
***********************************************************************************/
    public function admin_email() {
        $this->layout = 'admin';
        $activeTMenu = 'emailmkt';
        $leftMenu = true;$page_title = 'Email Marketing';
        $this->set(compact('activeTMenu','leftMenu','page_title'));
    }
    
    function admin_plans(){
       $this->loadModel('SmsSubscriptionPlan');
       $plans = $this->SmsSubscriptionPlan->find('all' , array('conditions'=>array('is_deleted'=>0,'status'=>1)));
       $this->layout  =   'admin_paginator';
       $activeTMenu = 'smsplan';
       $leftMenu = true;$page_title = 'Sms Plan';
       $this->set(compact('activeTMenu','leftMenu','page_title','plans'));
    }
    
    function admin_email_plans(){
       $this->loadModel('EmailSubscriptionPlan');
       $plans = $this->EmailSubscriptionPlan->find('all' , array('conditions'=>array('is_deleted'=>0,'status'=>1)));
       $this->layout  =   'admin_paginator';
       $activeTMenu = 'emailplan';
       $leftMenu = true;$page_title = 'Email Plan';
       $this->set(compact('activeTMenu','leftMenu','page_title','plans'));
    }
    
    function admin_paymentDetails($id,$type){
      $this->loadModel('SmsSubscriptionPlan');
      //$this->User 
      
    }
    
    
    
    
}