<?php
class PaymentsController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie'); //An array containing the names of components this controller uses.

/**********************************************************************************    
  @Function Name : admin_plans
  @Params	 : $planType => Plan type (SMS , EMAIL , FEATURING)
  @Description   : For listing all the type of plan
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/
    public function admin_plans($planType = NULL) {
        $this->layout = 'admin';
        if($planType){
            $this->set(compact('planType'));
            $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                    );
            if($planType == 'sms'){
                $breadcrumb['SMS Plan'] ='javascript:void(0);';
                $this->loadModel('SmsSubscriptionPlan');    
                $plans = $this->SmsSubscriptionPlan->find('all',array('conditions'=>array('SmsSubscriptionPlan.is_deleted'=>0),'order'=>array('SmsSubscriptionPlan.id'=>'DESC')));
                $this->set(compact('plans','breadcrumb'));
                $this->set('page_title','SMS Payment Plan');
                $this->set('activeTMenu','smsPlan');
                 if($this->request->is('ajax')){
                    $this->layout = 'ajax';
                    $this->viewPath = "Elements/admin/Payment";
                    $this->render('sms_table');
                    
                }
            }
            elseif($planType == 'email'){
                $breadcrumb['Email plan'] ='javascript:void(0);';
                $this->loadModel('EmailSubscriptionPlan');    
                $plans = $this->EmailSubscriptionPlan->find('all',array('conditions'=>array('EmailSubscriptionPlan.is_deleted'=>0),'order'=>array('EmailSubscriptionPlan.id'=>'DESC')));
                $this->set(compact('plans','breadcrumb'));
                $this->set('page_title','Email Payment Plan');
                $this->set('activeTMenu','emailPlan');
                 if($this->request->is('ajax')){
                    $this->layout = 'ajax';
                    $this->viewPath = "Elements/admin/Payment";
                    $this->render('email_table');
                    
                }
            }
            elseif($planType == 'featuring'){
                $breadcrumb['Featuring Plan'] ='javascript:void(0);';
                $this->loadModel('FeaturingSubscriptionPlan');    
                $plans = $this->FeaturingSubscriptionPlan->find('all',array('conditions'=>array('FeaturingSubscriptionPlan.is_deleted'=>0),'order'=>array('FeaturingSubscriptionPlan.id'=>'DESC')));
                $this->set(compact('plans','breadcrumb'));
                $this->set('page_title','Featured Payment Plan');
                $this->set('activeTMenu','featuredPlan');
                 if($this->request->is('ajax')){
                    $this->layout = 'ajax';
                    $this->viewPath = "Elements/admin/Payment";
                    $this->render('featuring_table');
                    
                }
            }else{
                $this->Session->setFlash(__('unknown_request',true),'flash_error');
                $this->redirect(array('controller'=>'dashboard','action'=>'index','admin'=>true));
            }
            $this->set('leftMenu',true);
        }else{
            $this->Session->setFlash(__('unknown_request',true),'flash_error');
            $this->redirect(array('controller'=>'dashboard','action'=>'index','admin'=>true));
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_smsPlan
  @Params	 : $id = smsPlanId , $title = SMS Plan title
  @Description   : For Add/Edit SMS plan
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/

    public function admin_smsPlan($id=NULL,$title=NULL) {
        $this->layout = "ajax";
        $this->loadModel('SmsSubscriptionPlan');
        $breadcrumb = array(
                'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                'SMS Payment Plans'=>array('controller'=>'Payments','action'=>'plans','admin'=>true,'sms'),
            );
        if($id){
            //$id = base64_decode($id);
            $smsplan = $this->SmsSubscriptionPlan->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        }else{
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        
        if($this->request->is('post') || $this->request->is('put')){
            if($id){
                $this->SmsSubscriptionPlan->id = $id;
            }else{
                $this->SmsSubscriptionPlan->create();
            }
            if($this->SmsSubscriptionPlan->save($this->request->data)){
                $edata['data'] = 'success' ;
                $edata['message'] = __('paymentplan_save_success',true);
                echo json_encode($edata);
                die;
            }else{
                $message = __('unable_to_save', true);
                $vError = $this->SmsSubscriptionPlan->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        $this->set(compact('breadcrumb'));
        if(!$this->request->data && isset($smsplan)){
            $this->request->data = $smsplan;
        }
    }


/**********************************************************************************    
  @Function Name : admin_emailPlan
  @Params	 : $id = emailPlanId , $title = Email Plan title
  @Description   : For Add/Edit Email plan
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/    
    public function admin_emailPlan($id=NULL,$title=NULL) {
        $this->layout = "ajax";
        $this->loadModel('EmailSubscriptionPlan');
        $breadcrumb = array(
                'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                'Email Payment Plans'=>array('controller'=>'Payments','action'=>'plans','admin'=>true,'email'),
            );
        if($id){
           // $id = base64_decode($id);
            $emailplan = $this->EmailSubscriptionPlan->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        }else{
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        
        if($this->request->is('post') || $this->request->is('put')){
            if($id){
                $this->EmailSubscriptionPlan->id = $id;
            }else{
                $this->EmailSubscriptionPlan->create();
            }
	    $fieldsetaray = array('title','price','plan_type','stataus');
	    if($this->request->data['EmailSubscriptionPlan']['customer_type'] == 0){
		$this->request->data['EmailSubscriptionPlan']['no_of_emails'] = 0;
		$fieldsetaray[] = 'no_of_customers';
	    }elseif($this->request->data['EmailSubscriptionPlan']['customer_type'] == 1){
		$this->request->data['EmailSubscriptionPlan']['no_of_customers'] = 0;
		$fieldsetaray[] = 'no_of_emails';
	    }
	   if($this->EmailSubscriptionPlan->validates(array('fieldList' => $fieldsetaray))){
		if($this->EmailSubscriptionPlan->save($this->request->data)){
		   $edata['data'] = 'success' ;
		   $edata['message'] = __('paymentplan_save_success',true);
		   echo json_encode($edata);
		   die;
	       }else{
		   $message = __('unable_to_save', true);
		   $vError = $this->EmailSubscriptionPlan->validationErrors;
		   $edata['data'] = $vError ;
		   $edata['message'] = $message;
		   echo json_encode($edata);
		   die;
	       }
	       
	   }else{
		   $message = __('unable_to_save', true);
		   $vError = $this->EmailSubscriptionPlan->validationErrors;
		   $edata['data'] = $vError ;
		   $edata['message'] = $message;
		   echo json_encode($edata);
		   die;
	    
	   }
          
        }
        $this->set(compact('breadcrumb'));
        if(!$this->request->data && isset($emailplan)){
            $this->request->data = $emailplan;
        }
    }


/**********************************************************************************    
  @Function Name : admin_featuringPlan
  @Params	 : $id = emailPlanId , $title = Email Plan title
  @Description   : For Add/Edit featuring plan
  @Author        : Aman Gupta
  @Date          : 11-Nov-2014
***********************************************************************************/
    public function admin_featuringPlan($id=NULL,$title=NULL) {
        $this->layout = "ajax";
        $this->loadModel('FeaturingSubscriptionPlan');
        $breadcrumb = array(
                'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                'Featuring Payment Plans'=>array('controller'=>'Payments','action'=>'plans','admin'=>true,'featuring'),
            );
        if($id){
            //$id = base64_decode($id);
            $featuringplan = $this->FeaturingSubscriptionPlan->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        }else{
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        
        if($this->request->is('post') || $this->request->is('put')){
            if($id){
                $this->FeaturingSubscriptionPlan->id = $id;
            }else{
                $this->FeaturingSubscriptionPlan->create();
            }
            if($this->FeaturingSubscriptionPlan->save($this->request->data)){
                $edata['data'] = 'success' ;
                $edata['message'] = __('paymentplan_save_success',true);
                echo json_encode($edata);
                die;
            }else{
               $message = __('unable_to_save', true);
                $vError = $this->FeaturingSubscriptionPlan->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        $this->set(compact('breadcrumb'));
        if(!$this->request->data && isset($featuringplan)){
            $this->request->data = $featuringplan;
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_deletePlan
  @Params	 : $id = ID , $title = title , $type = sms/email/featuring
  @Description   : For Deleting all type of Plans
  @Author        : Aman Gupta
  @Date          : 12-Nov-2014
***********************************************************************************/    
    public function admin_deletePlan($type=NULL) {
        $this->autoRender = false;
         if($this->request->is('post') || $this->request->is('put')){
            $id = $this->request->data['id'];
            //$id = base64_decode($id);
            if($type == 'sms'){
                $this->loadModel('SmsSubscriptionPlan');
                if($this->SmsSubscriptionPlan->updateAll(array('SmsSubscriptionPlan.is_deleted'=>1),array('SmsSubscriptionPlan.id'=>$id))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('plan_delete_success',true);
                }
                else{
                     $edata['data'] = 'error' ;
                    $edata['message'] = __('unable_to_delete',true);
                }
            }
            elseif($type == 'email'){
                $this->loadModel('EmailSubscriptionPlan');    
                if($this->EmailSubscriptionPlan->updateAll(array('EmailSubscriptionPlan.is_deleted'=>1),array('EmailSubscriptionPlan.id'=>$id))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('plan_delete_success',true);
                }
                else{
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unable_to_delete',true);
                }
            }
            elseif($type == 'featuring'){
                $this->loadModel('FeaturingSubscriptionPlan');    
                if($this->FeaturingSubscriptionPlan->updateAll(array('FeaturingSubscriptionPlan.is_deleted'=>1),array('FeaturingSubscriptionPlan.id'=>$id))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('plan_delete_success',true);
                }
                else{
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unable_to_delete',true);
                }
            }else{
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unknown_request',true);
            }
            
           // $this->redirect(array('controller'=>'Payments','action'=>'plans','admin'=>true,$type));
        }
        else{
            if($type){
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unknown_request',true);
            }
            else{
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unknown_request',true);    
            }
        }
        echo json_encode($edata);
        die;
    }
    
    
/**********************************************************************************    
  @Function Name : admin_changeStatus
  @Params	 : $type = sms/email/featuring
  @Description   : For Changing status of all type of Plans via Ajax
  @Author        : Aman Gupta
  @Date          : 12-Nov-2014
***********************************************************************************/ 
    public function admin_changeStatus($type) {
        $this->autoRender = false;
        if($this->request->is('post') || $this->request->is('put')){
            if($type){
                if($type == 'sms'){
                    $this->loadModel('SmsSubscriptionPlan');    
                    if($this->SmsSubscriptionPlan->updateAll(array('SmsSubscriptionPlan.status'=>$this->request->data['status']),array('SmsSubscriptionPlan.id'=>$this->request->data['id']))){
                        return $this->request->data['status'];
                    }
                }
                elseif($type == 'email'){
                    $this->loadModel('EmailSubscriptionPlan');    
                    if($this->EmailSubscriptionPlan->updateAll(array('EmailSubscriptionPlan.status'=>$this->request->data['status']),array('EmailSubscriptionPlan.id'=>$this->request->data['id']))){
                        return $this->request->data['status'];
                    }
                }
                elseif($type == 'featuring'){
                    $this->loadModel('FeaturingSubscriptionPlan');    
                    if($this->FeaturingSubscriptionPlan->updateAll(array('FeaturingSubscriptionPlan.status'=>$this->request->data['status']),array('FeaturingSubscriptionPlan.id'=>$this->request->data['id']))){
                        return $this->request->data['status'];
                    }
                }
            }
        }
    }    
}
