<?php
class VendorsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form','js','Js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Paginator','Image','RequestHandler','Common'); //An array containing the names of components this controller uses.
    
    public function beforeFilter() {
        $this->Auth->allow('index','salonservices','get_policy_details','get_salon_image_details');
        parent::beforeFilter();
    }
    
    /**********************************************************************************    
      @Function Name : index
      @Params	 : NULL
      @Description   : The display salon in frontend
      @Author        : Ramanpreet Pal Kaur
      @Date          : 22-Apr-2014
    ***********************************************************************************/
    public function index($salon_user_name = NULL){
        $this->loadModel('User');
        $user_details = $this->User->find('first',array('conditions'=>array('User.username'=>$salon_user_name)));
        $salonId = $user_details['User']['id'];
        
        $this->Session->write('view_salon',$salonId);
       
        $this->loadModel('SalonService');
        $this->loadModel('SalonOpeningHour');
        $this->loadModel('Package');
        $this->User->bindModel(array('hasOne'=>array('FacilityDetail','PolicyDetail')));
        $userDetails =$this->User->find('first',array('conditions'=>array('User.id'=>$salonId)));
        $salonOpeningHours =  $this->SalonOpeningHour->find('first' , array('conditions'=>array('user_id'=>$salonId,'status'=>1))); 
        $this->set(compact('userDetails','salonOpeningHours'));
        if($this->RequestHandler->isAjax()){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'salon';
        }
        
    }
    
    function get_salon_image_details($salonId = null){
        $this->loadModel('User');
        $this->User->unbindModel( array('hasMany' => array('PricingLevelAssigntoStaff')));
        $user_details = $this->User->find('first',
                    array('conditions'=>array('User.id'=>"$salonId"),
                        'fields'=> array(
                            'User.id', 'User.type',
                            'Salon.cover_image', 'Salon.eng_name', 'Salon.ara_name', 'Salon.website_url', 'Salon.email', 
                            'Address.address', 'Address.po_box',
                            'Contact.cell_phone'
                        )
                    ));
        return $user_details;
    }
    
    function get_policy_details($salonId = null){
        $this->loadModel('PolicyDetail');
        $policy_details = $this->PolicyDetail->find('first',array('conditions'=>array('PolicyDetail.user_id'=>"$salonId"),
                                'fields' => array('PolicyDetail.enable_gfvocuher')
                            ));
        return $policy_details;
    }
    
    
    public function salonservices($salonId = NULL){
        if($salonId){
            $this->Session->write('view_salon',$salonId);
            $services = $this->getserviceDisplay($salonId);
            $this->set(compact('services'));
            if($this->RequestHandler->isAjax()){
                $this->layout = 'ajax';
            } else {
                $this->layout = 'salon';
            }
        }
    }

    
    /**********************************************************************************    
  @Function Name : getserviceDisplay
  @Params	 : $salonId
  @Description   : The fetching list of services
  @Author        : Aman Gupta
  @Date          : 09-Apr-2014
***********************************************************************************/   
    public function getserviceDisplay($salonId = NULL){
        $this->loadModel('SalonService');
        $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
        $salonService = $this->SalonService->find('all', array('conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1, 'SalonService.salon_id' => $salonId,'SalonService.parent_id'=>0), 'order' => array('SalonService.service_order')));
        //pr($services);
        foreach($salonService as $salserkey=>$theService){
            $subService = $this->SalonService->find('all', array('conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1, 'SalonService.salon_id' => $salonId,'SalonService.parent_id'=>$theService['SalonService']['id']), 'order' => array('SalonService.service_order')));
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
                
                //if($theTreat['SalonServiceDetail']['offer_available']){
                //    $weekdays = array_filter(unserialize($theTreat['SalonServiceDetail']['offer_available_weekdays']));
                //    $day = date("D");
                //    if(!empty($weekdays)){
                //        if (!array_key_exists(strtolower($day), $weekdays)) {
                //            unset($subService[$suKey]);
                //        }
                //    }
                //    
                //}
            }
            
            if(empty($subService)){
                unset($salonService[$salserkey]);
            }else{
                $salonService[$salserkey]['children'] = $subService;
            }
        }
        
        return $salonService;
    }
    
    
    public function admin_salon_payment(){
        $this->loadModel('Order');
        
        $orders = $this->Order->find('all');
    }
    
}