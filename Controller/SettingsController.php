<?php
class SettingsController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie', 'Common','Image'); //An array containing the names of components this controller uses.
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('feedback');
    }
    
    
    
    /*************************************************************************************    
      @Function Name : admin_siteTheme
      @Params	 : NULL
      @Description   : For saving Site theme for the Admin Side
      @Author        : Aman Gupta
      @Date          : 10-Nov-2014
     * ********************************************************************************* */
    public function admin_siteTheme(){
        $this->autoRender = false;
        $this->loadModel('ChosenTheme');
        $cond = array('ChosenTheme.user_id' => $this->Auth->user('id'));
        if ($this->Auth->user('type') == 1){
            $cond = array('ChosenTheme.user_id' => 0);
        }
        $themeId = $this->ChosenTheme->find('first', array('conditions' => $cond, 'fields' => array('ChosenTheme.theme', 'ChosenTheme.id')));
        if ($this->request->is('ajax')) {
            if ($this->request->data['theme']) {
                if (!empty($themeId)) {
                    $this->ChosenTheme->updateAll(array('ChosenTheme.theme' => '"' . $this->request->data['theme'] . '"'), array('ChosenTheme.id' => $themeId['ChosenTheme']['id']));
                    die('s');
                } else {
                    $savetheme['ChosenTheme']['theme'] = $this->request->data['theme'];
                    $savetheme['ChosenTheme']['user_id'] = $this->Auth->user('id');
                    if ($this->Auth->user('type') == 1) {
                        $savetheme['ChosenTheme']['user_id'] = 0;
                    }
                    $this->ChosenTheme->create();
                    $this->ChosenTheme->save($savetheme);
                    die('s');
                }
            }
        }
    }

    /**********************************************************************************    
      @Function Name : admin_appointment_rule
      @Params	 : NULL
      @Description   : For saving Admin general settings for the Online appointment booking rules
      @Author        : Surjit
      @Date          : 13-Nov-2014
     ********************************************************************************** */

    public function admin_appointment_rule() {
        $this->layout = 'admin';
        $this->loadModel('SalonOnlineBookingRule');
        $this->loadModel('SalonOpeningHour');
        //if ($this->Auth->user('type') == 1) {
        //    $userid = 0;
        //} else {
            $userid = $this->Auth->user('id');
        //}
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Appointment Settings' => 'javascript:void(0);',
        );
        $this->set('breadcrumb', $breadcrumb);
        #pr($this->request->data);die;
        if (empty($this->request->data)) {
            $this->request->data = $this->SalonOnlineBookingRule->find('first', array('conditions' => array('SalonOnlineBookingRule.user_id' => $userid)));
            if (empty($this->request->data)) {
                $this->request->data = $this->SalonOnlineBookingRule->find('first', array('conditions' => array('SalonOnlineBookingRule.user_id' => 1)));
                $this->request->data['SalonOnlineBookingRule']['id'] = '';
            }
            //pr($this->request->data); die;
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->request->data['SalonOnlineBookingRule']['user_id'] = $userid;
            if ($this->SalonOnlineBookingRule->save($this->request->data)) {
                $this->loadModel('PolicyDetail');
                $policyDetail = $this->PolicyDetail->find('first',
                            array(
                                'fields' => array('id','user_id'),
                                'conditions' => array('user_id' => $userid)
                            )
                        );
                
                if(empty($policyDetail)){
                    $policyDetail = $this->PolicyDetail->find('first',
                            array(
                                'conditions' => array('user_id' => 1)
                            )
                        );
                    $policyDetail['PolicyDetail']['user_id'] = $userid;
                    $policyDetail['PolicyDetail']['id'] = '';
                }
                
                
                 if($this->request->data['SalonOnlineBookingRule']['allow_cancel'] == 1){
                        //english cancel
                        $appointment_cancel1 = str_replace('{cancellation_period}',$this->request->data['SalonOnlineBookingRule']['cancel_time'],ENG_APPOINTMENT_CANCEL_POLICY1);
                        $appointment_cancel2 = str_replace('{cancellation_period}',$this->request->data['SalonOnlineBookingRule']['cancel_time'],ENG_APPOINTMENT_CANCEL_POLICY2);
                       
                        $policyDetail['PolicyDetail']['eng_cancel_appointment_policy'] = $appointment_cancel1.' '.$appointment_cancel2;
                        
                         
                        // for arabic cancel
                        $ara_appointment_cancel1 = str_replace('{cancellation_period}',$this->request->data['SalonOnlineBookingRule']['cancel_time'],ARA_APPOINTMENT_CANCEL_POLICY1);
                        $ara_appointment_cancel2 = str_replace('{cancellation_period}',$this->request->data['SalonOnlineBookingRule']['cancel_time'],ARA_APPOINTMENT_CANCEL_POLICY2);
                       $policyDetail['PolicyDetail']['ara_cancel_appointment_policy'] = $ara_appointment_cancel1.' '.$ara_appointment_cancel2;
                     
                 }else{
                     $policyDetail['PolicyDetail']['eng_cancel_appointment_policy'] = "Cancellation is not allowed";
                     $policyDetail['PolicyDetail']['ara_cancel_appointment_policy'] = "إلغاء غير مسموح";
                 }
                
                
                if($this->request->data['SalonOnlineBookingRule']['allow_reschedule'] == 1){  
               // english reschedule
                $appointment_reschedule = str_replace('{hours}',$this->request->data['SalonOnlineBookingRule']['reschedule_time'],ENG_APPOINTMENT_RESCHEDULE_POLICY);
                $policyDetail['PolicyDetail']['eng_reschedule_appointment_policy'] = $appointment_reschedule;
               // arabic reschedule 
                 $ara_appointment_reschedule = str_replace('{hours}',$this->request->data['SalonOnlineBookingRule']['reschedule_time'],ARA_APPOINTMENT_RESCHEDULE_POLICY);
                $policyDetail['PolicyDetail']['ara_reschedule_appointment_policy'] = $ara_appointment_reschedule;
                }else{
                    $policyDetail['PolicyDetail']['eng_reschedule_appointment_policy'] = "Reschedule is not allowed";
                    $policyDetail['PolicyDetail']['ara_reschedule_appointment_policy'] = "إلغاء غير مسموح";
                }
                if(!empty($policyDetail)){
                    $this->PolicyDetail->set($policyDetail);
                    $this->PolicyDetail->save();
                }
                $this->Session->setFlash(__('onlinebookingrule_save_success', true), 'flash_success');
                $this->redirect($this->referer());
            } else{
                $this->Session->setFlash(__('Error in saving details', true), 'flash_error');
            }
        }
        
        $userid = $this->Auth->user('id');
        $days=array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
        $opening_hours=$this->SalonOpeningHour->find('first',array('conditions'=>array('user_id'=>$userid)));
        if(empty($opening_hours)){
            $opening_hours=$this->SalonOpeningHour->find('first',array('conditions'=>array('user_id'=>1)));    
        }
        for($i=0;$i<7;$i++){
            if($i==0)  {
                $fromTime=strtotime($opening_hours['SalonOpeningHour'][$days[$i].'_from']);
                //echo $fromTime; echo"=====";
                $toTime=strtotime($opening_hours['SalonOpeningHour'][$days[$i].'_to']);
                //echo "====="; echo $fromTime;  echo "===="; echo date("H:i", $fromTime); die;
            } else{
                if(strtotime($fromTime)<strtotime($opening_hours['SalonOpeningHour'][$days[$i].'_from'])) {
                  $fromTime=strtotime($opening_hours['SalonOpeningHour'][$days[$i].'_from']);
                }
                if(strtotime($toTime)<strtotime($opening_hours['SalonOpeningHour'][$days[$i].'_to'])) {
                  $toTime=strtotime($opening_hours['SalonOpeningHour'][$days[$i].'_to']);
                }
            }
        }
        $format=date("G:i", $fromTime);
        $openHours[$format]=date("G:i A", $fromTime);
        $openHour=$fromTime;
        //pr($openHour);
        //die;
        //pr($openHours);
        $evngs = $afternoons  =array();
        $afternoon = strtotime('12:00 PM'); 
        $afternoon_end  = strtotime('03:30 PM');
        $evng_strt  = strtotime('04:00 PM');
        while($openHour < $toTime){
            $addHalfHour = strtotime('+30mins', $openHour); // add 30 mins
            $time = date('G:i', $addHalfHour); // format the next time
            $chng_time = strtotime($time);
            if($chng_time >=$afternoon && $chng_time <=$afternoon_end){
               $afternoons[$time]=date('G:i A',$addHalfHour);   
            }
            if($chng_time >= $evng_strt){
              $evngs[$time]=date('G:i A',$addHalfHour);  
            }
           
            
            $openHours[$time]=date('G:i A',$addHalfHour);
            $openHour=strtotime($time);
        }
        //pr($openHours); die;
        $this->set(compact('openHours','afternoons','evngs'));
        $this->set('page_title', 'Appointment Settings');
        $this->set('activeTMenu', 'apntmtStng');
        $this->set('leftMenu', true);
    }

    /**********************************************************************************    
      @Function Name : admin_email_setting
      @Params	 : NULL
      @Description   : For saving Admin general settings for Email/SMS Client and business
      @Author        : Surjit
      @Date          : 17-Nov-2014
     * ********************************************************************************* */

    public function admin_email_setting(){
        $this->layout = 'admin';
        $this->loadModel('SalonEmailSms');
        $userid = $this->Auth->user('id');
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Email/SMS Settings' => 'javascript:void(0);',
        );
        
        /* $country_id = '';
        $this->loadModel('Address');
        $userDetail = $this->Address->find('first',array('conditions' => array('Address.user_id' => $userid)));
        $country_id = $userDetail['Address']['country_id'];
        $country_code ='';
        if($country_id != ''){
            $this->loadModel('Country');
	    $phCode = $this->Country->find('first',array('fields'=>array('Country.phone_code'),'conditions'=>array('Country.id'=>$country_id)));
	    $country_code = $phCode['Country']['phone_code'];
        }
        $this->set('country_code', $country_code);
        */
        
        $this->set('breadcrumb', $breadcrumb);
        if (empty($this->request->data)) {
            $this->request->data = $this->SalonEmailSms->find('first',
                                array('conditions' => array('SalonEmailSms.user_id' => $userid))
                            );
            if (empty($this->request->data)) {
                $this->request->data = $this->SalonEmailSms->find('first', array('conditions' => array('SalonEmailSms.user_id' => 1)));
                $this->request->data['SalonEmailSms']['id'] = '';
            }
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->request->data['SalonEmailSms']['user_id'] = $userid;
            // pr($this->request->data);exit;
            $this->SalonEmailSms->set($this->request->data);
            if($this->SalonEmailSms->validates()){
                $this->SalonEmailSms->save($this->request->data);
                $this->request->data['SalonEmailSms']['user_id'] = $userid;
                $this->Session->setFlash(__('emailsmssetting_save_success', true), 'flash_success');
                $this->redirect($this->referer());
            } else {
                $errors = $this->SalonEmailSms->validationErrors;
                $validate = '';
                foreach ($errors AS $key => $val) {
                    foreach ($val AS $valValidate) {
                        $validate .= $valValidate . '<br/>';
                    }
                }
                $this->Session->setFlash($validate, 'flash_error');
            }
        }

        $this->set('page_title', 'Email and SMS Settings');
        $this->set('activeTMenu', 'emailsmsStng');
        $this->set('leftMenu', true);
        
    }

    /*     * ********************************************************************************    
      @Function Name : admin_calendar_setting
      @Params	 : NULL
      @Description   : For saving Admin general settings for Calendar
      @Author        : Surjit
      @Date          : 19-Nov-2014
     * ********************************************************************************* */

    public function admin_calendar_setting() {
        $this->layout = 'admin';
        $this->loadModel('SalonCalendarSetting');
        //if ($this->Auth->user('type') == 1) {
        //    $userid = 0;
        //} else {
            $userid = $this->Auth->user('id');
	//}
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Calendar Settings' => 'javascript:void(0);',
        );
        $this->set('breadcrumb', $breadcrumb);
        #pr($this->request->data);die;
        if (empty($this->request->data)) {
            $this->request->data = $this->SalonCalendarSetting->find('first', array('conditions' => array('SalonCalendarSetting.user_id' => $userid)));
            //For vendors saving setting first time
            if (empty($this->request->data)) {
                $this->request->data = $this->SalonCalendarSetting->find('first', array('conditions' => array('SalonCalendarSetting.user_id' => 1)));
                $this->request->data['SalonCalendarSetting']['id'] = '';
            }

            //die('sdfdsf');
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->request->data['SalonCalendarSetting']['user_id'] = $userid;
            $this->request->data['SalonCalendarSetting']['service_provider_order'] = implode(',',$this->request->data['order']);
            if ($this->SalonCalendarSetting->save($this->request->data)) {
                $this->Session->setFlash(__('calsetting_save_success', true), 'flash_success');
            } else {
                $this->Session->setFlash(__('unable_to_save', true), 'flash_error');
            }
        }
        if ($this->Auth->user('type') != 1) {
            $staff = $this->Common->get_salon_staff($this->Auth->user('id'));
            $staffCount = count($staff);
//            $staff[$staffCount]['User']['id']=$this->Auth->user('id');
//            $staff[$staffCount]['User']['first_name']=$this->Auth->user('first_name');
//            $staff[$staffCount]['User']['last_name']=$this->Auth->user('last_name');
            if(isset($this->request->data['SalonCalendarSetting']['service_provider_order']) && !empty($this->request->data['SalonCalendarSetting']['service_provider_order'])){
		$staffOrder = explode(',',$this->request->data['SalonCalendarSetting']['service_provider_order']);
                $staff = $this->Common->staffSortbySorder($staff,$staffOrder);
                 //	    die('herere');
            }
            $this->set(compact('staff'));
        }
        $this->set('page_title', 'Calendar Configuration');
        $this->set('activeTMenu', 'calConfig');
        $this->set('leftMenu', true);
    }

    /*     * ********************************************************************************    
      @Function Name : admin_bankDetails
      @Params	 : NULL
      @Description   : For saving Bank Details of Individual , Frenchise & Multi Salon
      @Author        : Aman Gupta
      @Date          : 03-Dec-2014
     * ********************************************************************************* */

    public function admin_bankDetails() {
        $this->layout = 'admin';
        $this->loadModel('BankDetail');
        $stateData = $cityData = array();
        $bankData = $this->BankDetail->find('first', array('conditions' => array('BankDetail.user_id' => $this->Auth->user('id'))));
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['BankDetail']['id']) && !empty($this->request->data['BankDetail']['id'])) {
                $this->BankDetail->id = $this->request->data['BankDetail']['id'];
            } else {
                $this->BankDetail->create();
            }
            if (empty($this->request->data['BankDetail']['user_id']))
                $this->request->data['BankDetail']['user_id'] = $this->Auth->user('id');
            if ($this->BankDetail->save($this->request->data)) {
                $this->Session->setFlash(__('Bank Details Saved Successfully', true), 'flash_success');
            } else {
                $this->Session->setFlash(__('Unable to Save Bank Details.', true), 'flash_error');
            }
        }
        if (!$this->request->data) {
            $this->request->data = $bankData;
           // pr($bankData);exit;
        }
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Bank Details' => 'javascript:void(0);'
        );
        $activeTMenu = 'bankInfo';
        $page_title = 'Bank Details';
        $this->set('leftMenu', true);
        $countryData = $this->Common->getCountries();
        if (!empty($bankData['BankDetail']['country'])) {
            $this->loadModel('State');
            $stateData = $this->State->find('list', array('fields' => array('id', 'name'), 'conditions' => array('State.country_id' => $bankData['BankDetail']['country'], 'State.status' => 1)));
        }
        if (!empty($bankData['BankDetail']['state'])) {
            $this->loadModel('City');
            $cityData = $this->City->find('list', array('fields' => array('id', 'city_name'), 'conditions' => array('City.state_id' => $bankData['BankDetail']['state'], 'City.status' => 1)));
        }
        $this->set(compact('countryData', 'breadcrumb', 'activeTMenu', 'page_title','stateData','cityData'));
    }

    public function admin_facilityDetails() {
        $this->layout = 'admin';
        $this->loadModel('FacilityDetail');
        $this->loadModel('Salon');
        $facilityData = $this->FacilityDetail->find('first', array('conditions' => array('FacilityDetail.user_id' => $this->Auth->user('id'))));
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['FacilityDetail']['id']) && !empty($this->request->data['FacilityDetail']['id'])) {
                $this->FacilityDetail->id = $this->request->data['FacilityDetail']['id'];
            } else {
                $this->FacilityDetail->create();
            }
            if (empty($this->request->data['FacilityDetail']['user_id']))
                $this->request->data['FacilityDetail']['user_id'] = $this->Auth->user('id');

            if (!empty($this->request->data['FacilityDetail']['payment_method'])) {
                $this->request->data['FacilityDetail']['payment_method'] = $this->getSerializeResult($this->request->data['FacilityDetail']['payment_method']);
            }

            if (!empty($this->request->data['FacilityDetail']['parking_fee'])) {
                $this->request->data['FacilityDetail']['parking_fee'] = $this->getSerializeResult($this->request->data['FacilityDetail']['parking_fee']);
            }

            if (!empty($this->request->data['FacilityDetail']['spoken_language'])) {
                $this->request->data['FacilityDetail']['spoken_language'] = $this->getSerializeResult($this->request->data['FacilityDetail']['spoken_language']);
            }
            if (!empty($this->request->data['Salon']['business_type_id'])) {
                $bTypeIdall = array_filter($this->request->data['Salon']['business_type_id']);
                if(!empty($bTypeIdall)){
                    $this->request->data['Salon']['business_type_id'] = serialize($bTypeIdall);    
                }
            }
            if ($this->FacilityDetail->save($this->request->data)) {
                $facilityData['FacilityDetail']['payment_method'] = $this->request->data['FacilityDetail']['payment_method'];
                $facilityData['FacilityDetail']['parking_fee'] = $this->request->data['FacilityDetail']['parking_fee'];
                $facilityData['FacilityDetail']['spoken_language'] = $this->request->data['FacilityDetail']['spoken_language'];
                $businessId = NULL;
                if ($this->request->data['Salon']['business_type_id'])
                    $businessId = $this->request->data['Salon']['business_type_id'];
                $this->Salon->updateAll(array('Salon.business_type_id' => "'" . $businessId . "'"), array('Salon.user_id' => $this->Auth->user('id')));
		if($this->request->is('ajax')){
		    $dataJason['data'] = 'success';
                    $dataJason['message'] = __('Facility details have been saved successfully.', true);
                    echo json_encode($dataJason);
                    die;    
		}else{
		    $this->Session->setFlash(__('Facility details have been saved successfully.', true), 'flash_success');
		}
            }
            else {
		if($this->request->is('ajax')){
		    $message = __('Some error occurred.', true);
                    $vError = $this->FacilityDetail->validationErrors;
                    $dataJason['data'] = $vError;
                    $dataJason['message'] = $message;
                    echo json_encode($dataJason);
                    die;    
		}else{
		    $this->Session->setFlash(__('Some error occurred.', true), 'flash_error');
		}
            }
        }
        if (!$this->request->data) {
            $this->request->data = $facilityData;
        }
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Facitlity Details' => 'javascript:void(0);'
        );
        $activeTMenu = 'facilityInfo';
        $page_title = 'Facility Information';
        $this->set('leftMenu', true);
        $countryData = $this->Common->getCountries();
        $this->loadModel('BusinessType');
        $bType = $this->BusinessType->find('list', array('fields' => array('BusinessType.eng_name'), 'conditions' => array('BusinessType.status' => 1, 'BusinessType.is_deleted' => 0)));
        $bTypeIds = $this->Salon->find('first', array('fields' => array('Salon.business_type_id'), 'conditions' => array('Salon.user_id' => $this->Auth->user('id'))));
        $facilityData['Salon']['business_type_id'] = $bTypeIds['Salon']['business_type_id'];
        $countryData = $this->Common->getCountries();
        $this->set(compact('facilityData', 'bType', 'countryData', 'breadcrumb', 'activeTMenu', 'page_title'));
	if($this->request->is('ajax')){
	    $this->layout = 'ajax';
	    $this->set('rmvcancel',true);
            $this->render('ajax_facility_details');
	}
    }

    function getSerializeResult($theData = array()) {
        if ($theData) {
            $theData = array_filter($theData);
            if (!empty($theData)) {
                return serialize(array_keys($theData));
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    /*     * ********************************************************************************    
      @Function Name : admin_billingDetails
      @Params	 : NULL
      @Description   : For saving Billing Details of Individual , Frenchise & Multi Salon
      @Author        : Aman Gupta
      @Date          : 03-Dec-2014
     * ********************************************************************************* */

    public function admin_billingDetails() {
        $this->layout = 'admin';
        $this->loadModel('BillingDetail');
        $this->loadModel('User');
        $this->loadModel('Address');
        $states = $cities = array();
        $uData = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        if($uData['Address']['country_id']){
           $country_code = $this->Common->getPhoneCode($uData['Address']['country_id']); 
           $this->set(compact('country_code'));
        }
        $billingData = $this->BillingDetail->find('first', array('conditions' => array('BillingDetail.user_id' => $this->Auth->user('id'))));
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['BillingDetail']['id']) && !empty($this->request->data['BillingDetail']['id'])) {
                $this->BillingDetail->id = $this->request->data['BillingDetail']['id'];
            } else {
                $this->BillingDetail->create();
            }
            if (empty($this->request->data['BillingDetail']['user_id']))
                $this->request->data['BillingDetail']['user_id'] = $this->Auth->user('id');
            
            if (!empty($this->request->data['BillingDetail']['country_id'])) {
                $this->loadModel('State');
                $states = $this->State->find('list', array('fields' => array('id', 'name'), 'conditions' => array('State.country_id' => $this->request->data['BillingDetail']['country_id'], 'State.status' => 1)));
                //pr($states);exit;
            }
            if (!empty($this->request->data['BillingDetail']['state_id'])) {
                $this->loadModel('City');
                $cities = $this->City->find('list', array('fields' => array('id', 'city_name'), 'conditions' => array('City.state_id' => $this->request->data['BillingDetail']['state_id'], 'City.status' => 1)));
            }
            
            if ($this->BillingDetail->save($this->request->data)) {
                $this->Session->setFlash(__('Billing Details Saved Successfully', true), 'flash_success');
            } else {
                $this->Session->setFlash(__('Unable to Save Billing Details.', true), 'flash_error');
            }
        }
        if (!$this->request->data) {
            if (empty($billingData)) {
                $user = $this->Auth->user();
                $billingData['BillingDetail']['contact_name'] = $user['first_name'] . " " . $user['last_name'];
                $billingData['BillingDetail']['email'] = $user['email'];
                $billingData['BillingDetail']['phone'] = $user['Contact']['cell_phone'];
                $billingData['BillingDetail']['contact_phone'] = $user['Contact']['day_phone'];
                $billingData['BillingDetail']['company_title'] = $user['Salon']['eng_name'];
                $billingData['BillingDetail']['address'] = $user['Address']['address'] . ",\n" . $user['Address']['area'];
                $billingData['BillingDetail']['postcode'] = $user['Address']['po_box'];
                $billingData['BillingDetail']['country_id'] = $user['Address']['country_id'];
                $billingData['BillingDetail']['state_id'] = $user['Address']['state_id'];
                $billingData['BillingDetail']['city_id'] = $user['Address']['city_id'];
            }

            if (!empty($billingData['BillingDetail']['country_id'])) {
                $this->loadModel('State');
                $states = $this->State->find('list', array('fields' => array('id', 'name'), 'conditions' => array('State.country_id' => $billingData['BillingDetail']['country_id'], 'State.status' => 1)));
                //pr($states);exit;
            }
            if (!empty($billingData['BillingDetail']['state_id'])) {
                $this->loadModel('City');
                $cities = $this->City->find('list', array('fields' => array('id', 'city_name'), 'conditions' => array('City.state_id' => $billingData['BillingDetail']['state_id'], 'City.status' => 1)));
            }


            $this->request->data = $billingData;
        }

        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Billing Details' => 'javascript:void(0);'
        );
        $activeTMenu = 'billingInfo';
        $page_title = 'Billing Details';
        $this->set('leftMenu', true);
        $countryData = $this->Common->getCountries();
        $this->set(compact('states', 'cities', 'countryData', 'breadcrumb', 'activeTMenu', 'page_title'));
    }

    /*     * ********************************************************************************    
      @Function Name : admin_outcall_setting
      @Params	 : NULL
      @Description   : For saving Admin general settings for OutCall
      @Author        : 
      @Date          : 04-Dec-2014
     * ********************************************************************************* */

    public function admin_outcall_setting() {

        $this->layout = 'admin';
        $this->loadModel('SalonOutcallConfiguration');
       
        
        //if ($this->Auth->user('type') == 1) {
        //    $userid = 0;
        //} else {
            $userid = $this->Auth->user('id');
       // }
        if (empty($this->request->data)) {
            $this->request->data = $this->SalonOutcallConfiguration->find('first', array('conditions' => array('SalonOutcallConfiguration.user_id' => $userid)));
            //For vendors saving setting first time 
            if (empty($this->request->data)) {
                $this->request->data = $this->SalonOutcallConfiguration->find('first', array('conditions' => array('SalonOutcallConfiguration.user_id' =>1)));
                $this->request->data['SalonOutcallConfiguration']['id'] = '';
            }
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->request->data['SalonOutcallConfiguration']['user_id'] = $userid;
	    $this->SalonOutcallConfiguration->set($this->request->data);
            if ($this->SalonOutcallConfiguration->validates()) {
                if ($this->SalonOutcallConfiguration->save($this->request->data, false)) {
                    $this->Session->setFlash(__('outcall_save_success', true), 'flash_success');
                    $this->redirect($this->referer());
                }
            }
        }
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Outcall Configuration' => 'javascript:void(0);'
        );
        
        
        $page_title = 'Outcall Configuration';
        $activeTMenu = 'outcallConfig';
        $leftMenu = true;
        $this->set(compact('page_title', 'activeTMenu', 'leftMenu', 'breadcrumb'));
    }

    /*     * ********************************************************************************    
      @Function Name : admin_policy_Detials
      @Params        : NULL
      @Description   : For saving privacy settings details for the Admin Side
      @Author        : Rajnish
      @Date          : 5-Jan-2015
     * ********************************************************************************* */

    public function admin_policy_details() {
        $group_id = $this->Auth->user('group_id');
        $user_id = $this->Auth->user('id');
        $this->layout = 'admin';
        $this->loadModel('PolicyDetail');
        $this->loadModel('SalonOnlineBookingRule');
        $page_title = 'Policy';
        $activeTMenu = 'policySettings';
        $leftMenu = true;
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Policy' => 'javascript:void(0)',
        );
        $this->set('breadcrumb', $breadcrumb);
        
     
        
        if ($this->request->data) {
            //pr($this->request->data); exit;
            //isAllow_cancel_spa_break //isAllow_reschedule_spabreak
            $this->request->data['PolicyDetail']['user_id'] = $user_id;
            $this->request->data['PolicyDetail']['enable_gfvocuher'] = $this->request->data['PolicyDetail']['enable_gfvocuher'];
            if(empty($this->request->data['PolicyDetail']['enable_gfvocuher'])){
               // $this->request->data['PolicyDetail']['ev_validity'] = 0;
                $this->request->data['PolicyDetail']['isAllow_cancel_appointment'] = 0;
                $this->request->data['PolicyDetail']['cancel_appointmenttxt'] = '';    
                $this->request->data['PolicyDetail']['cancel_period_appointment'] = 0; 
            }
            
            if($this->request->data['PolicyDetail']['isAllow_cancel_spa_break'] == 0){
                $this->request->data['PolicyDetail']['isAllow_cancel_spa_break'] = 0;
                $this->request->data['PolicyDetail']['eng_cancellation_policy_text'] = 'Cancellation of Spabreak is not allowed.';
     $this->request->data['PolicyDetail']['ara_cancellation_policy_text'] = "لا يسمح إلغاء Spabreak.";
            }else{
                 //english spabreak cancel
                $spabreak_cancel1 = str_replace('{days}',$this->request->data['PolicyDetail']['cancel_period_spabreak'],ENG_SPABREAK_POLICY1);
                $spabreak_cancel2 = str_replace('{days}',$this->request->data['PolicyDetail']['cancel_period_spabreak'],ENG_SPABREAK_POLICY2);
                
                 $this->request->data['PolicyDetail']['eng_cancellation_policy_text'] = $spabreak_cancel1.' '.$spabreak_cancel2;
                 
                   // for arabic spabreak cancel
            $ara_spabreak_cancel1 = str_replace('{days}',$this->request->data['PolicyDetail']['cancel_period_spabreak'],ARA_SPABREAK_POLICY1);
            $ara_spabreak_cancel2 = str_replace('{days}',$this->request->data['PolicyDetail']['cancel_period_spabreak'],ARA_SPABREAK_POLICY2);
            
            $this->request->data['PolicyDetail']['ara_cancellation_policy_text'] = $ara_spabreak_cancel1.' '.$ara_spabreak_cancel2;
            
            
            }
            if($this->request->data['PolicyDetail']['isAllow_reschedule_spabreak'] == 0){
                $this->request->data['PolicyDetail']['eng_reschedule_policy_text'] = "Reschedule of Spabreak is not allowed.";
        $this->request->data['PolicyDetail']['ara_reschedule_policy_text'] = "لا يسمح إلغاء Spabreak.";
                
            }else{
                 //english spabreak reschedule
            $spabreak_reschedule = str_replace('{days}',$this->request->data['PolicyDetail']['reschedule_period'],ENG_SPABREAK_RESCHEDULE_POLICY);
           
            $this->request->data['PolicyDetail']['eng_reschedule_policy_text'] = $spabreak_reschedule;
            
         
            // for arabic spabreak reschedule
            $ara_spabreak_reschedule = str_replace('{days}',$this->request->data['PolicyDetail']['reschedule_period'],ARA_SPABREAK_RESCHEDULE_POLICY);
            
            $this->request->data['PolicyDetail']['ara_reschedule_policy_text'] = $ara_spabreak_reschedule;
            
            }
           
           
            $this->PolicyDetail->set($this->request->data);
            if ($this->PolicyDetail->save()) {
                $this->Session->setFlash(__('policy_settings_save_success', true), 'flash_success');
            } else {
                $this->Session->setFlash(__('policy_settings_save_error', true), 'flash_success');
            }
        } else {
            $policyDetail = $this->PolicyDetail->find('first', array('conditions' => array('user_id' => $user_id)));
           
            if (empty($policyDetail)) {
                $policyDetail = $this->PolicyDetail->find('first', array('conditions' => array('user_id' => 1)));
                $if_super_admin_settings = 1;
            } else {
                $if_super_admin_settings = 0;
            }
            $this->set('policyDetail', $policyDetail);
            
            $appointmentSetting = $this->SalonOnlineBookingRule->find('first', array('conditions' => array('user_id' => $user_id)));
            if (empty($appointmentSetting)){
                $appointmentSetting = $this->SalonOnlineBookingRule->find('first', array('conditions' => array('user_id' => 1)));
            }
            
            if(!empty($appointmentSetting) && ($if_super_admin_settings==1)){
                // for eng appoint
                $appointment_cancel1 = str_replace('{cancellation_period}',$appointmentSetting['SalonOnlineBookingRule']['cancel_time'],ENG_APPOINTMENT_CANCEL_POLICY1);
                $appointment_cancel2 = str_replace('{cancellation_period}',$appointmentSetting['SalonOnlineBookingRule']['cancel_time'],ENG_APPOINTMENT_CANCEL_POLICY2);
                $appointment_reschedule = str_replace('{hours}',$appointmentSetting['SalonOnlineBookingRule']['reschedule_time'],ENG_APPOINTMENT_RESCHEDULE_POLICY);
                $policyDetail['PolicyDetail']['eng_cancel_appointment_policy'] = $appointment_cancel1.' '.$appointment_cancel2;
                $policyDetail['PolicyDetail']['eng_reschedule_appointment_policy'] = $appointment_reschedule;
                
                // for arabic appoint
                $ara_appointment_cancel1 = str_replace('{cancellation_period}',$appointmentSetting['SalonOnlineBookingRule']['cancel_time'],ARA_APPOINTMENT_CANCEL_POLICY1);
                $ara_appointment_cancel2 = str_replace('{cancellation_period}',$appointmentSetting['SalonOnlineBookingRule']['cancel_time'],ARA_APPOINTMENT_CANCEL_POLICY2);
                $ara_appointment_reschedule = str_replace('{hours}',$appointmentSetting['SalonOnlineBookingRule']['reschedule_time'],ARA_APPOINTMENT_RESCHEDULE_POLICY);
                $policyDetail['PolicyDetail']['ara_cancel_appointment_policy'] = $ara_appointment_cancel1.' '.$ara_appointment_cancel2;
                $policyDetail['PolicyDetail']['ara_reschedule_appointment_policy'] = $ara_appointment_reschedule;
            }
        }
        
        //pr($policyDetail);
        //echo '<hr>';
        //pr($this->request->data);
       // die;
        
        if (!$this->request->data && isset($policyDetail)) {
            $this->request->data = $policyDetail;
            
            if(!empty($if_super_admin_settings)){
                $this->request->data['PolicyDetail']['id'] = '';
                $this->request->data['PolicyDetail']['user_id'] = $user_id;
            }
            
            //pr($this->request->data); die;
        }
        
        
        $this->set(compact('page_title', 'activeTMenu', 'leftMenu', 'breadcrumb'));
    }

    /*     * ********************************************************************************    
      @Function Name : admin_payrolls
      @Params        : NULL
      @Description   : Create and Save the payroll configuaration
      @Author        : Rajnish
      @Date          : 6-Jan-2015
     * ********************************************************************************* */

    public function admin_payroll() {
        $group_id = $this->Auth->user('group_id');
        $user_id = $this->Auth->user('id');
        $this->layout = 'admin';
        $this->loadModel('Payroll');
        $page_title = 'Payroll Configuration';
        $activeTMenu = 'payroll';
        $leftMenu = true;
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Payroll' => 'javascript:void(0)',
        );
        $this->set('breadcrumb', $breadcrumb);
        $payrollDetail = $this->Payroll->find('first', array('conditions' => array('user_id' => $user_id)));
        $this->set('payrollDetail', $payrollDetail);
        if ($this->request->is(array('put', 'post'))) {
            $this->request->data['Payroll']['user_id'] = $user_id;
            if (@$payrollDetail['Payroll']['id']) {
                $this->Payroll->id = $payrollDetail['Payroll']['id'];
            } else {
                $this->Payroll->create();
            }
            if ($this->Payroll->save($this->request->data)) {
                $this->Session->setFlash(__('payroll_config_save_success', true), 'flash_success');
            } else {
                $this->Session->setFlash(__('payroll_config_save_error', true), 'flash_success');
            }
        }
        if (!$this->request->data && isset($payrollDetail)) {
            $this->request->data = $payrollDetail;
        }
        $this->set(compact('page_title', 'activeTMenu', 'leftMenu', 'breadcrumb'));
    }

    /*     * ********************************************************************************    
      @Function Name : admin_open_hours
      @Params        : NULL
      @Description   : Save the salon open hours settings
      @Author        : Rajnish
      @Date          : 6-Jan-2015
     * ********************************************************************************* */

    public function admin_open_hours($uid=NULL,$type=NULL){
        $group_id = $this->Auth->user('group_id');
        $timezones = $this->Common->get_timezones();
        if(empty($timezones)){
            $timezones = array();
        }
        $type = ($type)?$type:'saloon';
        $this->loadModel('SalonOpeningHour');
        $page_title = 'Opening Hours';
        $activeTMenu = 'Opening Hours';
        $leftMenu = true;
	$this->layout = 'admin';
	$this->set('typeoff',$type);
	$user_id = $this->Auth->user('id');
	$breadcrumb = array(
		'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
		'Open Hours' => 'javascript:void(0)',
	    );
	if($type == 'staff'){
            $this->set('uidGet',$uid);
            $this->set('typeS',$type);
	    $user_id = base64_decode($uid); //user Session id of employee
	    $page_title = 'Working Hours';
            $breadcrumb = array(
		'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
		'Staff' => array('controller' => 'SalonStaff', 'action' => 'index', 'admin' => true),
		'Working Hours' => 'javascript:void(0)'
	    );
         /*  $this->loadModel('User');
           $this->User->recursive = -1;
           $Salon_id = $this->User->find('first',array('conditions'=>array('id'=>$user_id),'fields'=>array('parent_id'))); 
            if($Salon_id['User']['parent_id']){
             $Salon_opening_hour  = $this->SalonOpeningHour->find('first',array('conditions'=>array('id'=>$Salon_id['User']['parent_id']))); 
            }
           pr($Salon_opening_hour); die;  */
        }
	
        $openingHoursDetail = $this->SalonOpeningHour->find('first', array('conditions' => array('user_id' => $user_id)));
       
        
        if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_mon'] == 1) {
            $disabled = '';$checked = 'checked';
        } else if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_mon'] == 0) {
            $checked = '';
            $disabled = 'disabled';
        }
        //Tuesday
        if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_tue'] == 1) {
            $disabledTue = '';$checkedTue = 'checked';
        } else if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_tue'] == 0) {
            $disabledTue = 'disabled';
            $checkedTue = '';
        }
        //Wednesday
        if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_wed'] == 1) {
            $disabledWed = '';
            $checkedWed = 'checked';
        } else if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_wed'] == 0) {
            $disabledWed = 'disabled';
            $checkedWed = '';
        }
        //Thursday
        if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_thu'] == 1) {
            $disabledThu = '';
            $checkedThu = 'checked';
        } else if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_thu'] == 0) {
            $disabledThu = 'disabled';
            $checkedThu = '';
        }
        //Friday
        if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_fri'] == 1) {
            $disabledFri = '';
            $checkedFri = 'checked';
        } else if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_fri'] == 0) {
            $disabledFri = 'disabled';
            $checkedFri = '';
        }
        //Saturday
        if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_sat'] == 1) {
            $disabledSat = '';
            $checkedSat = 'checked';
        } else if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_sat'] == 0) {
            $disabledSat = 'disabled';
            $checkedSat = '';
        }
        //Sunday
        if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_sun'] == 1) {
            $disabledSun = '';
            $checkedSun = 'checked';
        } else if (@$openingHoursDetail['SalonOpeningHour']['is_checked_disable_sun'] == 0) {
            $disabledSun = 'disabled';
            $checkedSun = '';
        }
        $this->set('disabled', $disabled);
        $this->set('checked', $checked);
        $this->set('disabledTue', $disabledTue);
        $this->set('checkedTue', $checkedTue);
        $this->set('disabledWed', $disabledWed);
        $this->set('checkedWed', $checkedWed);
        $this->set('disabledThu', $disabledThu);
        $this->set('checkedThu', $checkedThu);
        $this->set('disabledFri', $disabledFri);
        $this->set('checkedFri', $checkedFri);
        $this->set('disabledSat', $disabledSat);
        $this->set('checkedSat', $checkedSat);
        $this->set('disabledSun', $disabledSun);
        $this->set('checkedSun', $checkedSun);
        $this->set('openingHoursDetail', $openingHoursDetail);
	
        if($this->request->is('post') || $this->request->is('put')){
                $checkDayOpen = 0;
                if (@$this->request->data['SalonOpeningHour']['is_checked_disable_mon'] == 1) {
                    $checkDayOpen = 1;
                }
                //Tuesday
                if (@$this->request->data['SalonOpeningHour']['is_checked_disable_tue'] == 1) {
                    $checkDayOpen = 1;
                }
                //Wednesday
                if (@$this->request->data['SalonOpeningHour']['is_checked_disable_wed'] == 1) {
                    $checkDayOpen = 1;
                }
                //Thursday
                if (@$this->request->data['SalonOpeningHour']['is_checked_disable_thu'] == 1) {
                    $checkDayOpen = 1;
                }
                //Friday
                if (@$this->request->data['SalonOpeningHour']['is_checked_disable_fri'] == 1) {
                    $checkDayOpen = 1;
                }
                //Saturday
                if (@$this->request->data['SalonOpeningHour']['is_checked_disable_sat'] == 1) {
                    $checkDayOpen = 1;
                }
                //Sunday
                if (@$this->request->data['SalonOpeningHour']['is_checked_disable_sun'] == 1) {
                    $checkDayOpen = 1;
                }
                
                $this->request->data['SalonOpeningHour']['type'] = $type;
                $this->request->data['SalonOpeningHour']['user_id'] = $user_id;
                //echo $type;
                //echo $user_id;
               // pr($this->request->data); die;
                if (isset($openingHoursDetail['SalonOpeningHour']['id']) && !empty($openingHoursDetail['SalonOpeningHour']['id'])){
                    $this->SalonOpeningHour->id = $openingHoursDetail['SalonOpeningHour']['id'];
                } else {
                    $this->SalonOpeningHour->create();
                }
                if($checkDayOpen == 0){
                    $message = __('Please select at least one option.', true);
                    $vError = $this->SalonOpeningHour->validationErrors;
                    $dataJason['data'] = 'Option Required';
                    $dataJason['message'] = $message;
                    echo json_encode($dataJason);
                    die;
                }else{
                    if ($this->SalonOpeningHour->save($this->request->data)) {
                        $dataJason['data'] = 'success';
                        if($type != 'saloon'){
                            $this->Session->setFlash(__('Opening hours saved successfully', true),'flash_success');
                            $this->loadModel('SalonStaffService');
                            $ServiceExist = $this->SalonStaffService->find('all', array('fields' => array('SalonStaffService.id'), 'conditions' => array('SalonStaffService.staff_id' => $user_id)));
                            if(empty($ServiceExist)){
                                $dataJason['data'] = 'service';
                            }
                        }
                        
                        $dataJason['staffID'] = base64_encode($user_id);
                        $dataJason['message'] = __('Opening hours saved successfully', true);
                        echo json_encode($dataJason);
                        die;
                        
                    } else {
                        $message = __('Unable to save details', true);
                        $vError = $this->SalonOpeningHour->validationErrors;
                        $dataJason['data'] = $vError;
                        $dataJason['message'] = $message;
                        echo json_encode($dataJason);
                        die;
                    }
                }
            
           
        } 
	
        if (!$this->request->data && isset($openingHoursDetail)) {
            $this->request->data = $openingHoursDetail;
        }
        if($this->request->is('ajax')){
	    $this->layout = 'ajax';
            $this->set('ajaxVar',true);
	    $this->render('admin_opeaning_hours');
	}else{
             $this->set('ajaxVar',false);
        }
	$this->set('breadcrumb', $breadcrumb);
        $this->set('timezones', $timezones);
        $this->set(compact('page_title', 'activeTMenu', 'leftMenu', 'breadcrumb'));
    }

    /**********************************************************************************    
      @Function Name : admin_room
      @Params        : NULL
      @Description   : function to show list of rooms per Salon
      @Author        : Shibu
      @Date          : 8-Jan-2015
     * ********************************************************************************* */

    function admin_room($type = "room") {
        $this->layout = 'admin';
        $this->loadModel('SalonRoom');
        $display_name = ($type=='room')?'Hotel Rooms':'Treatment Rooms';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Settings' => array('controller' => 'Settings', 'action' => 'email_setting', 'admin' => true),
             ucfirst($display_name) => 'javascript:void(0)',
        );
        $this->set('breadcrumb', $breadcrumb);
        $created_by = $this->Auth->user('id');
        $condition = array('SalonRoom.user_id ' => $created_by, 'SalonRoom.is_deleted' => 0,'SalonRoom.type'=>$type);
        $rooms = $this->SalonRoom->find('all', array('recursive' => 2, 'conditions' => $condition));
        $this->set(compact('rooms','type'));
        $page_title =  ucfirst($display_name);
        //$page_title = ucfirst($type).' Listing';
        $this->set('page_title', $page_title);
        $this->set('activeTMenu', $type);
        $this->set('leftMenu',true);
	if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Settings";
            $this->render('list_admin_rooms');
        }
    }

    /*     * ********************************************************************************    
      @Function Name : admin_room
      @Params        : NULL
      @Description   : function to add rooms
      @Author        : Shibu
      @Date          : 8-Jan-2015
     * ********************************************************************************* */

    function admin_add_room($id = null,$type="room") {
        $this->layout = 'ajax';
        $this->loadModel('SalonRoom');
        if ($id) {
            $pageDetail = $this->SalonRoom->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        } else {
            $breadcrumb['Add'] = 'javascript:void(0);';
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            //parse_str($this->request->data,$data);
            $data = $this->request->data;
            $roomimage = array_filter($this->request->data['SalonRoom']['serviceimage']);
            if (!empty($data['SalonRoom']['id'])) {
                $this->SalonRoom->id = $data['SalonRoom']['id'];
            } else {
                $data['SalonRoom']['user_id'] = $this->Auth->user('id');
                $data['SalonRoom']['type'] = $type;
                $this->SalonRoom->create();
            }
            if ($this->SalonRoom->save($data)) {
                  $roomId = $this->SalonRoom->id;
                    if(!empty($roomimage)){
                        $this->loadModel('SalonRoomImage');
                        $imageList = $this->SalonRoomImage->find('list',array('conditions'=>array('SalonRoomImage.salon_room_id' => $roomId,'SalonRoomImage.created_by'=>$this->Auth->user('id')),'fields'=>array('SalonRoomImage.image')));
                        $this->SalonRoomImage->deleteAll(array('SalonRoomImage.salon_room_id' => $roomId,'SalonRoomImage.created_by'=>$this->Auth->user('id')));
                        foreach($roomimage as $key=>$theImage){
                            $imgData = array();
                            $imgData['SalonRoomImage']['salon_room_id'] = $roomId;
                            $imgData['SalonRoomImage']['image'] = $theImage;
                            $imgData['SalonRoomImage']['order'] = $key;
                            $imgData['SalonRoomImage']['created_by'] = $this->Auth->user('id');
                            $this->SalonRoomImage->create();
                            $this->SalonRoomImage->save($imgData);
                        }
                        if(!empty($imageList)){
                            $nonImg = array_diff($imageList, $roomimage);
                            if(!empty($nonImg)){
                                foreach($nonImg as $thedImage){
                                    $this->Image->delete_image($thedImage, 'Service', $this->Auth->user('id'), false);
                                }
                            }
                        }
                       $this->loadModel('TempImage');
                         $this->TempImage->deleteAll(array('TempImage.path' => 'Room','TempImage.user_id' => $this->Auth->user('id')));
                }
                $edata['data'] = 'success';
                $edata['message'] = __('page_save_success', true);
                echo json_encode($edata);
                die;
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->SalonRoom->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        if (!$this->request->data && isset($pageDetail)) {
            $this->request->data = $pageDetail;
            $this->set('rooms',$pageDetail);
        }
        $this->set('type',$type);
    }

    /**********************************************************************************    
      @Function Name : admin_deleteRoom
      @Params	 : NULL
      @Description   : Delete of Room
      @Author        : Shibu Kumar
      @Date          : 8-jan-2014
    ********************************************************************************** */
    public function admin_delete_room() {
        $this->autoRender = "false";
        $this->loadModel('SalonRoom');
        if ($this->request->is('post') || $this->request->is('put')) {
            $id = $this->request->data['id'];
            $page = $this->SalonRoom->findById($id);
            if (!empty($page)) {
                if ($this->SalonRoom->updateAll(array('SalonRoom.is_deleted' => 1), array('SalonRoom.id' => $id))) {
                    $edata['data'] = 'success';
                    $edata['message'] = __('delete_success', true);
                } else {
                    $edata['data'] = 'error';
                    $edata['message'] = __('unable_to_delete', true);
                }
            } else {
                $edata['data'] = 'error';
                $edata['message'] = __('page_not_found', true);
            }
        }
        echo json_encode($edata);
        die;
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_update_popup
      @Params	 	: Update first login popup condition
      @Description   	: Delete of Room
      @Author        	: Aman Gupta
      @Date          	: 4-Feb-2015
    ***********************************************************************************/
    public function admin_update_popup() {
	$this->autoRender = false;
	if ($this->request->is('post') || $this->request->is('put')) {
	    $this->loadModel('User');
	    if ($this->User->updateAll(array('User.is_popup' => "'".$this->request->data['update']."'"), array('User.id' => $this->Auth->user('id')))) {
		echo 's'; 
	    }
	    
	}
	die;
    }
    /**********************************************************************************    
      @Function Name 	: admin_business_bank
      @Params	 	: Update bank Details for the User popup
      @Description   	: Delete of Room
      @Author        	: Aman Gupta
      @Date          	: 4-Feb-2015
    ***********************************************************************************/
    public function admin_business_bank() {
	$this->layout = 'ajax';
	$this->loadModel('BankDetail');
        $bankData = $this->BankDetail->find('first', array('conditions' => array('BankDetail.user_id' => $this->Auth->user('id'))));
	if ($this->request->is('post') || $this->request->is('put')) {
	    if(!empty($this->request->data['Salon']['eng_description'])){
		if (isset($this->request->data['BankDetail']['id']) && !empty($this->request->data['BankDetail']['id'])) {
		    $this->BankDetail->id = $this->request->data['BankDetail']['id'];
		} else {
		    $this->BankDetail->create();
		}
		if (empty($this->request->data['BankDetail']['user_id']))
		    $this->request->data['BankDetail']['user_id'] = $this->Auth->user('id');
		if ($this->BankDetail->save($this->request->data)) {
		    $this->loadModel('Salon');
		    $this->Salon->updateAll(array('Salon.eng_description' => '"' . $this->request->data['Salon']['eng_description'] . '"'), array('Salon.user_id' => $this->Auth->user('id')));
		    $edata['data'] = 'success';
		    $edata['message'] = __('Bank Details Saved Successfully.', true);
		    echo json_encode($edata);
		    die;
		} else {
		    $message = __('Unable to Save Bank Details.', true);
                    $vError = $this->BankDetail->validationErrors;
                    $dataJason['data'] = $vError;
                    $dataJason['message'] = $message;
                    echo json_encode($dataJason);
                    die;
		}
	    }else{
		$this->BankDetail->set($this->request->data['BankDetail']);
		$this->BankDetail->validates();
		$errors = $this->BankDetail->validationErrors;
		$errors['Salon']['eng_description'][0] = __('Description cannot be empty.', true);
		$message = __('Unable to Save Bank Details.', true);
		$dataJason['data'] = $errors;
		$dataJason['message'] = $message;
		echo json_encode($dataJason);
		die;
	    }
	}
	if(!$this->request->data){
	    $this->request->data = $bankData;
            $stateData = $cityData =array();
            
            if(isset($bankData['BankDetail']['state']) && !empty($bankData['BankDetail']['state'])){
                $this->loadModel('State');
                $stateData = $this->State->find('list', array('fields' => array('id', 'name'), 'conditions' => array('State.country_id' => $bankData['BankDetail']['country'], 'State.status' => 1)));
            }
            if(isset($bankData['BankDetail']['city']) && !empty($bankData['BankDetail']['city'])){
                $this->loadModel('City');
                $cityData = $this->City->find('list', array('fields' => array('id', 'city_name'), 'conditions' => array('City.state_id' => $bankData['BankDetail']['state'], 'City.status' => 1)));
            }
            
            $this->loadModel('Salon');
	    $salonData = $this->Salon->find('first', array('conditions' => array('Salon.user_id' => $this->Auth->user('id'))));
	    if(!empty($salonData)){
		$this->request->data['Salon']['eng_description'] = $salonData['Salon']['eng_description'];
	    }
	}
	$countryData = $this->Common->getCountries();
        $ajaxSub = 'true';
	$this->set(compact('countryData','cityData','stateData','ajaxSub'));
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_business_details
      @Params	 	: Update Business Details for the User popup
      @Description   	: Delete of Room
      @Author        	: Aman Gupta
      @Date          	: 4-Feb-2015
    ***********************************************************************************/
    public function admin_business_details(){
	$this->layout = 'ajax';
	$this->loadModel('User');
	$uData = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id'))));
        if($uData['Address']['country_id']){
           $country_code = $this->Common->getPhoneCode($uData['Address']['country_id']); 
           $this->set(compact('country_code'));
        }
        if ($this->request->is('post') || $this->request->is('put')){
            
	    if($this->User->saveAll($this->request->data,array('deep'=>true))){
		$uerpoptoken = 'verify';
//		if($uData['User']['email'] != $this->request->data['User']['email']){
//		    $uerpoptoken .= '_e';
//		    
//		    $email_token = strtoupper($this->Common->getRandPass(15));
//		    $userId = base64_encode($this->Auth->user('id'));
//                    $userData = $this->User->findById($this->Auth->user('id'));
//		    $this->Common->sendEmailUser($email_token,$userData);
//		    $this->User->updateAll(array('User.email_token' => '"' . $email_token . '"'), array('User.id' => $this->Auth->user('id')));
//		}
//		if($uData['Contact']['cell_phone'] != $this->request->data['Contact']['cell_phone']){
//		    $uerpoptoken .= '_p';
//		    //$phone_token = strtoupper($this->Common->getRandPass(8));
//		    $phone_token = "XSD23DEH";
//		    $this->User->updateAll(array('User.phone_token' => "'" . $phone_token . "'"), array('User.id' => $this->Auth->user('id')));
//		    // send PHone verificcation code HERE
//		}
		if($uerpoptoken == 'verify'){
		   $uerpoptoken .= '_done'; 
		}else{
		    $this->Session->setFlash(__('Please Enter verification Code.', true), 'flash_info');
		}
		if($this->Auth->user('type') == 2){
		    $uerpoptoken = 'done'; 
		}
		$this->User->updateAll(array('User.is_popup' => '"' . $uerpoptoken . '"'), array('User.id' => $this->Auth->user('id')));
		
		$edata['data'] = 'success';
		$edata['message'] = __('Bank Details Saved Successfully.', true);
		echo json_encode($edata);
		die;
	    }else{
		$message = __('Unable to save Contact Details.', true);
		$vError = $this->User->validationErrors;
		$dataJason['data'] = $vError;
		$dataJason['message'] = $message;
		echo json_encode($dataJason);
		die;
	    }
	}
	if(!$this->request->data){
	    $this->request->data = $uData;
	}
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_get_popup_status
      @Params	 	: NULL
      @Description   	: get User popup state
      @Author        	: Aman Gupta
      @Date          	: 4-Feb-2015
    ***********************************************************************************/
    public function admin_get_popup_status() {
	//pr($_SESSION);
        //pr($this->Auth->user());
        if($this->Auth->user()){
	    $this->loadModel('User');
            $this->Auth->user('id');
            $satate = $this->User->find('first',array('fields'=>array('User.is_popup'),'conditions'=>array('User.id'=>$this->Auth->user('id'))));
	    echo $satate['User']['is_popup'];
	}
	die;
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_verify_email
      @Params	 	: NULL
      @Description   	: function for verifying Email
      @Author        	: Aman Gupta
      @Date          	: 4-Feb-2015
    ***********************************************************************************/
    public function admin_verify_email() {
	$this->layout = 'ajax';
	$this->loadModel('User');
	$userToken = $this->User->find('first',array('fields'=>array('User.is_popup','User.email_token'),'conditions'=>array('User.id'=>$this->Auth->user('id'))));
	if ($this->request->is('post') || $this->request->is('put')) {
	    
	    if($userToken['User']['email_token'] == $this->request->data['User']['email_token']){
		$verifyToken = 'verify_done';
		if($userToken['User']['is_popup'] == 'verify_e_p'){
		    $verifyToken = 'verify_p';
		    $this->Session->setFlash(__('Please Enter verification Code.', true), 'flash_info');
		}
		
		if($this->User->updateAll(array('User.email_token'=>NULL,'User.is_popup' => '"' . $verifyToken . '"'), array('User.id' => $this->Auth->user('id')))){
		    $message = __('Verification Done Successfully.', true);
		    $dataJason['data'] = 'success';
		    $dataJason['message'] = $message;
		    echo json_encode($dataJason);
		    die;

		}
		else{
		    $message = __('Verification Code Mismatch.', true);
		    $dataJason['data'] = 'error';
		    $dataJason['message'] = $message;
		    echo json_encode($dataJason);
		    die;
 
		}
	    }
	    else{
		$message = __('Verification Code Mismatch.', true);
		$dataJason['data'] = 'error';
		$dataJason['message'] = $message;
		echo json_encode($dataJason);
		die;
	    }
	    
	}
    }

    /**********************************************************************************    
      @Function Name 	: admin_verify_phone
      @Params	 	: NULL
      @Description   	: function for verifying Phone
      @Author        	: Aman Gupta
      @Date          	: 4-Feb-2015
    ***********************************************************************************/
    public function admin_verify_phone() {
	$this->layout = 'ajax';
	$this->loadModel('User');
	$userToken = $this->User->find('first',array('fields'=>array('User.is_popup','User.phone_token'),'conditions'=>array('User.id'=>$this->Auth->user('id'))));
	if ($this->request->is('post') || $this->request->is('put')) {
	    
	    if($userToken['User']['phone_token'] == $this->request->data['User']['phone_token']){
		$verifyToken = 'verify_done';
		
		if($this->User->updateAll(array('User.phone_token'=>NULL,'User.is_popup' => '"' . $verifyToken . '"'), array('User.id' => $this->Auth->user('id')))){
		    $message = __('Verification Done Successfully.', true);
		    $dataJason['data'] = 'success';
		    $dataJason['message'] = $message;
		    echo json_encode($dataJason);
		    die;

		}
		else{
		    $message = __('Verification Code Mismatch.', true);
		    $dataJason['data'] = 'error';
		    $dataJason['message'] = $message;
		    echo json_encode($dataJason);
		    die;
 
		}
	    }
	    else{
		$message = __('Verification Code Mismatch.', true);
		$dataJason['data'] = 'error';
		$dataJason['message'] = $message;
		echo json_encode($dataJason);
		die;
	    }
	    
	}
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_business_map
      @Params	 	: NULL
      @Description   	: for saving longitude and latitude of the Address
      @Author        	: Aman Gupta
      @Date          	: 5-Feb-2015
    ***********************************************************************************/
    public function admin_business_map() {
	$this->layout = 'ajax';
	$this->loadModel('Address');
	$addressD = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$this->Auth->user('id'))));
	if ($this->request->is('post') || $this->request->is('put')) {
	    
	    parse_str($this->request->data, $params);
	    foreach($params['data']['Address'] as $kk=>$vall){
		$params['data']['Address'][$kk] == str_replace('"', '', trim($vall));
	    }
	    
	    
	    if($this->Address->save($params['data']['Address'])){
		$edata['data'] = 'success';
		$edata['message'] = __('Location saved Successfully.', true);
		echo json_encode($edata);
		die;
	    }
	    else{
		$message = __('Unable to save Location .', true);
		$vError = $this->Address->validationErrors;
		$dataJason['data'] = $vError;
		$dataJason['message'] = $message;
		echo json_encode($dataJason);
		die;
	    }
	}
	if(!$this->request->data){
	    $this->request->data = $addressD;
	}
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_addingStaff
      @Params	 	: NULL
      @Description   	: for saving longitude and latitude of the Address
      @Author        	: Aman Gupta
      @Date          	: 5-Feb-2015
    ***********************************************************************************/
    public function admin_addingStaff($type = NULL) {
	$this->layout = 'ajax';
	$this->loadModel('User');
        
	if($this->Auth->user()){
            $id = $this->Auth->user('id');
            $this->User->recursive = -2;
            $staffList = $this->User->find('all',array('conditions'=>array('User.parent_id'=>$id,'User.is_deleted'=>0,'User.type'=>5),'order' => array('User.id DESC')));
            $this->set('staffList',$staffList);
	    $userData = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
	    if(empty($staffList) && empty($userData['UserDetail']['employee_type']) ){
		$this->set('emptyUser',true);
		if(!$this->request->data){
		    $this->loadModel('PricingLevelAssigntoStaff');
		    $priceLevel = $this->PricingLevelAssigntoStaff->find('first', array('conditions' => array('PricingLevelAssigntoStaff.user_id' => $id), 'fields' => array('id','pricing_level_id')));
		    $userData['User']['pricing_level_id'] = '';
		    if(!empty($priceLevel))
			$userData['User']['pricing_level_id'] = $priceLevel['PricingLevelAssigntoStaff']['pricing_level_id'];
		    $this->request->data = $userData;
		}
	    }
        }
	
	if($type == 'content'){
	    $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Settings";
            $this->render('staff_list');
	}
	
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_addingStaff
      @Params	 	: NULL
      @Description   	: for saving staff in the wizard
      @Author        	: Aman Gupta
      @Date          	: 5-Feb-2015
    ***********************************************************************************/
    public function admin_submitStaff() {
	$this->layout = 'ajax';
	$this->loadModel('User');
	$this->loadModel('PricingLevelAssigntoStaff');
        $this->loadModel('SalonOpeningHour');
	if ($this->request->is('post') || $this->request->is('put')) {
           
	    if(empty($this->request->data['User']['pricing_level_id']) && ($this->request->data['UserDetail']['employee_type']== 2)){
		$this->User->set($this->request->data);
		$this->User->saveAll($this->request->data, array('validate' => 'only'));
		//$this->User->validates();
		$message = __('Unable to Save Staff Details.', true);
		$vError = $this->User->validationErrors;
                $vError['pricing_level_id'][0] = 'Please Select Pricing Level';
		$dataJason['data'] = $vError;
		$dataJason['message'] = $message;
		echo json_encode($dataJason);
		die;
	    }
	    else{
                
		if(isset($this->request->data['User']['image']['name']) && !empty($this->request->data['User']['image']['name'])){
		    $image = $this->request->data['User']['image'];
		    unset($this->request->data['User']['image']);
		}
		if(isset($this->request->data['User']['id']) && empty($this->request->data['User']['id'])){
		    $this->request->data['User']['password'] = $this->request->data['User']['username'] = strtolower($this->request->data['User']['first_name'] . '_' . $this->request->data['User']['last_name']) . '_' . rand(0, 999);
                    $tmp_pwd = $this->Common->fnEncrypt($this->request->data['User']['password']);
                    $this->request->data['User']['tmp_pwd'] = $tmp_pwd;
                    $email_token = strtoupper($this->Common->getRandPass(5));
                    $this->request->data['User']['email_token'] = $email_token;
                    $phone_token = strtoupper($this->Common->getRandPass(5));
                    $this->request->data['User']['phone_token'] = $phone_token;
		}
		
		if($this->User->saveAll($this->request->data)){
		    $userId = $this->User->id;
                    $User = $this->User->findById($userId);
		    $priceLevel = $this->PricingLevelAssigntoStaff->find('first', array('conditions' => array('PricingLevelAssigntoStaff.user_id' => $userId), 'fields' => array('id','pricing_level_id')));
		    $this->request->data['PricingLevelAssigntoStaff']['user_id'] = $userId;
                    
                    if(!empty($this->request->data['User']['pricing_level_id'])){
                        
                    if(isset($priceLevel['PricingLevelAssigntoStaff']['id']) && $priceLevel['PricingLevelAssigntoStaff']['id'] != 0) {
                        $this->PricingLevelAssigntoStaff->id = $priceLevel['PricingLevelAssigntoStaff']['id'];
                    } else {
                        $this->PricingLevelAssigntoStaff->create();
                    }
                    $price['PricingLevelAssigntoStaff']['user_id'] = $userId;
                    $price['PricingLevelAssigntoStaff']['pricing_level_id'] = $this->request->data['User']['pricing_level_id'];
                    $this->PricingLevelAssigntoStaff->save($price);
                    }
                    /****************Copy salon opening hours to staff*************/
                    
                    $salonId = $this->Auth->user('id');
                    $staff_opening_hours=$this->SalonOpeningHour->find('first',array('conditions'=>array('user_id'=>$userId)));
                    
                    if(!$staff_opening_hours){
                        $salon_opening_hours=$this->SalonOpeningHour->find('first',array('conditions'=>array('user_id'=>$salonId)));
                        unset($salon_opening_hours['SalonOpeningHour']['id']);
                        $salon_opening_hours['SalonOpeningHour']['type'] = 'staff';
                        $salon_opening_hours['SalonOpeningHour']['user_id'] = $userId;
                        $this->SalonOpeningHour->save($salon_opening_hours);
                    }
                    
                    /*********************End*****************/
                    
                    if(isset($image) && !empty($image)){
			$model = "User";
			$return = $this->Image->upload_service_image($image,$model,$userId);
                        if($return){
			   $this->request->data['User']['image'] = $return;
			   $userInfo = $this->User->findById($userId);
			    if($userInfo['User']['image']){
				$this->User->saveField('image', $return);
				$this->Image->delete_image($userInfo['User']['image'],$model,$userId);
			    }
			    $this->User->updateAll(array('User.image' => '"' . $return . '"'), array('User.id' => $userId));
			}
		     }
		     /*************verification***************/
                  if(!empty($User) && $User['User']['is_email_verified']==0){   
                    $siteURL = Configure::read('BASE_URL');
                     //$emailTo = $userArr['Admin']['email'];
                    $userId_encode = base64_encode(base64_encode($userId));
                     //$link = '<a href = "' . $siteURL . '/users/confirm_email/'.$userId_encode.'/' . $email_token . '">'.$siteURL.'/users/confirm_email/'.$userId_encode.'/'.$email_token. '</a>';
                    $link = $siteURL.'/users/confirm_email/'.$userId_encode.'/'.$email_token;
                    $toEmail    = $User['User']['email'];
                    $fromEmail  = Configure::read('fromEmail');
                    $tmpPwd     = $this->Common->fnDecrypt($tmp_pwd);
                    $dynamicVariables = array('{FirstName}'=>ucfirst($User['User']['first_name']),'{LastName}'=>ucfirst($User['User']['last_name']),'{email}'=>$User['User']['email'],'{password}'=>$tmpPwd,'{Link}'=>$link);
                    $this->Common->sendEmail($toEmail,$fromEmail,'login_credential',$dynamicVariables);
                    }  
               
                    if(!empty($User) && $User['User']['is_phone_verified']==0){
                        $message = "Your one time (OTP) phone verification code is " .$phone_token. " Kindly verify your phone number!!";  
                        $number =  $User['Contact']['cell_phone'];
                        $country_id = $User['Address']['country_id'];
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
                     /******************End******************/
		    $dataJason['data'] = 'success';
                    $dataJason['message'] = __('Staff Saved Successfully', true);
                    echo json_encode($dataJason);
                    die;
		    
		}else{
		    $message = __('Unable to Save Staff Details.', true);
		    $vError = $this->User->validationErrors;
                    
		    $dataJason['data'] = $vError;
		    $dataJason['message'] = $message;
		    echo json_encode($dataJason);
		    die;    
		}
	    }
	}
	$this->viewPath = "Elements/admin/Settings";
        $this->render('staff_creation');
	
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_bookingIncharge
      @Params	 	: NULL
      @Description   	: for saving longitude and latitude of the Address
      @Author        	: Aman Gupta
      @Date          	: 5-Feb-2015
    ***********************************************************************************/
    public function admin_bookingIncharge() {
	$this->layout = 'ajax';
	$this->loadModel('User');
	$this->User->unbindModel(array('hasOne'=>array('Contact','Address','Salon'),'belongsTo'=>array('Group')));
	if ($this->request->is('post') || $this->request->is('put')) {
	    $bookingIncharge = array_filter($this->request->data['UserDetail']['booking_incharge']);
	    if(!empty($bookingIncharge)){
		$this->loadModel('UserDetail');
		foreach($bookingIncharge as $bookId){
		    $this->UserDetail->updateAll(array('UserDetail.booking_incharge' =>1), array('UserDetail.user_id' => $bookId));
		}
		    $dataJason['data'] = 'success';
                    $dataJason['message'] = __('Staff Saved Successfully', true);
                    echo json_encode($dataJason);
                    die;
	    }else{
		$message = __('Unable to Save Booking Incharge.', true);
		$dataJason['data'] = 'error';
		$dataJason['message'] = $message;
		echo json_encode($dataJason);
		die;
	    }
	    die;
	    
	}
	
	if($this->Auth->user()){
            $id = $this->Auth->user('id');
            $this->User->recursive = -2;
            $staffList = $this->User->find('all',array('conditions'=>array('User.parent_id'=>$id,'User.is_deleted'=>0,'User.type'=>5),'order' => array('User.id DESC')));
            $this->set('staffList',$staffList);
        }
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_set_userphotos
      @Params	 	: NULL
      @Description   	: for set User Cover Photo and LOGO
      @Author        	: Aman Gupta
      @Date          	: 9-Feb-2015
    ***********************************************************************************/
    public function admin_set_userphotos() {
	$this->layout = 'ajax';
	$this->loadModel('User');
	$this->loadModel('Salon');
        $return = '';
	if ($this->request->is('post') || $this->request->is('put')) {
	    $user_id = $this->Auth->user('id');
	    $userInfo = $this->User->findById($user_id);
            if(!empty($this->request->data['User']['cover_image'])){
		$salonImage = $this->request->data['User']['cover_image'];
		if (isset($salonImage['error']) && $salonImage['error'] == 0) {
                    $modelNew = "Salon";
                    $return = $this->Image->upload_custom_image($salonImage, $modelNew, $this->Auth->user('id'), true ,'salon_cover_image');
                    if($return) {
                        $this->Image->delete_image($userInfo['Salon']['cover_image'], $modelNew, $user_id, true);
                        $this->Salon->updateAll(array('Salon.cover_image' => '"' . $return . '"'), array('Salon.user_id' => $user_id));
                    }
                }
	    }
	    if(!empty($this->request->data['User']['image'])){
		$userImage = $this->request->data['User']['image'];
		if (isset($userImage['error']) && $userImage['error'] == 0) {
                    $model = "User";
                    $return = $this->Image->upload_custom_image($userImage, $model, $user_id, true);
                    if ($return) {
                        if (isset($userInfo['Salon']['logo']) && (!empty($userInfo['Salon']['logo']))) {
                            $this->Image->delete_image($userInfo['Salon']['logo'], $model, $user_id, true);
                        }
                       $this->Salon->updateAll(array('Salon.logo' => '"' . $return . '"'), array('Salon.user_id' => $user_id));
                    }
                }
	    }
                $edata['data'] = 'success';
                $edata['message'] = __('Image Uploaded Successfully.',true);
                echo json_encode($edata);
                die;
	}
	
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_venue_imges
      @Params	 	: NULL
      @Description   	: for uploading Venu Photos
      @Author        	: Aman Gupta
      @Date          	: 9-Feb-2015
    ***********************************************************************************/
    public function admin_venue_images($type='wizzard') {
	$this->layout = 'ajax';
	if ($this->request->is('post') || $this->request->is('put')) {
	    $this->loadModel('VenueImage');
	    if(isset($_FILES) && !empty($_FILES)){
		$vImage = $_FILES;
		if(!empty($vImage['image']['name'])){
                    list($width, $height, $type, $attr) = getimagesize($_FILES['image']["tmp_name"]);
                        if($width >= 300 && $height >= 200){
                                $model = "VenueImage";
                                $retrun = $this->Image->upload_image($vImage['image'],$model,$this->Auth->user('id'));
                                if($retrun){
                                    $vData['VenueImage']['image'] = $retrun;
                                    $vData['VenueImage']['user_id'] = $this->Auth->user('id');
                                    $this->VenueImage->create();
                                    $this->VenueImage->save($vData);
                                }
                                else{
                                    $edata['data'] = 'error';
                                    $edata['message'] = __('Error.',true);
                                    echo json_encode($edata);
                                    die;    
                                }
                        }else{
                                echo 'dimension_error_300_200';
                                die;
                        }
		}
	    }
            
	    $edata['data'] = 'success';
//            $edata['message'] = __('Image Uploaded Successfully.',true);
//            echo json_encode($edata);
//            die;
	}
        $this->set(compact('type'));
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_venue_video
      @Params	 	: NULL
      @Description   	: for uploading Venu Video
      @Author        	: Aman Gupta
      @Date          	: 9-Feb-2015
    ***********************************************************************************/
    public function admin_venue_video($type='wizzard') {
	$this->layout = 'ajax';
	if ($this->request->is('post') || $this->request->is('put')) {
	    if(!empty($this->request->data['URL'])){
		$this->loadModel('VenueVideo');
		$value = $this->VenueVideo->find('first',array('conditions'=>array('VenueVideo.user_id'=>$this->Auth->user('id'),'VenueVideo.video'=>$this->request->data['URL'])));
		if(empty($value)){
		    $data = array();
		    $data['VenueVideo']['user_id'] = $this->Auth->user('id');
		    $data['VenueVideo']['video'] = $this->request->data['URL'];
		    $this->VenueVideo->create();
		    $this->VenueVideo->save($data);
		    $host = @parse_url($this->request->data['URL']);
		    if (@$host['host'] == "www.youtube.com" or @$host['host'] == "youtube.com") {
			parse_str(@$host['query']);
			if (!empty($v)) {
			    echo  "http://img.youtube.com/vi/$v/3.jpg";
			    die;
			} 
		    }
		    echo 's';
		    die;
		}
		else{
		    echo 'e';
		    die;
		}
	    }
	    echo 'f';
	    die;
	}
             $this->set(compact('type'));
    }
    
    /**********************************************************************************    
      @Function Name 	: admin_public_photo
      @Params	 	: NULL
      @Description   	: for uploading Album Photo
      @Author        	: Aman Gupta
      @Date          	: 9-Feb-2015
    ***********************************************************************************/
    public function admin_public_photo() {
	$this->layout = 'ajax';
	if ($this->request->is('post') || $this->request->is('put')) {
	    $this->loadModel('Album');
	    $this->loadModel('AlbumFile');
	    if(isset($_FILES) && !empty($_FILES)){
		$vImage = $_FILES;
		$album = $this->Album->find('first',array('conditions'=>array('Album.user_id'=>$this->Auth->user('id'))));
		if(empty($album)){
		    $albm = array();
		    $albm['Album']['user_id'] = $this->Auth->user('id');
		    $albm['Album']['eng_name'] = $albm['Album']['eng_description'] = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
		    $albm['Album']['status'] = 1;
		    $this->Album->create();
		    $this->Album->save($albm);
		    $id = $this->Album->getLastInsertId();
		}
		else{
		    $id = $album['Album']['id'];
		}
		if($id){
		    if (isset($vImage['image']['name']) && !empty($vImage['image']['name'])) {
		    	$model = "AlbumFile";
		    	$retrun = $this->Image->upload_image($_FILES['image'],$model,$this->Auth->user('id'));
		    	if($retrun){
			    $albmImg['AlbumFile']['image'] = $retrun;
		    	    $albmImg['AlbumFile']['type'] = 'image';
			    $this->AlbumFile->create();
			    $albmImg['AlbumFile']['album_id'] = $id;
			    if($this->AlbumFile->save($albmImg)){
				$edata['data'] = 'success' ;
				$edata['message'] = __('page_save_success',true);
				echo json_encode($edata);
				die;
			    }else{
			       $message = __('unable_to_save', true);
			       $vError = $this->AlbumFile->validationErrors;
			       $edata['data'] = $vError ;
			       $edata['message'] = $message;
			       echo json_encode($edata);
			       die;
			    }
			   }
		    }
		}
		else{
		    echo "No Album Found";   
		}
	    }
	    else{
		echo "No File Found";   
	    }

	}
	$this->set('img_type','vImage');
	$this->render('admin_venue_images');
	
    }
    
    
    public function admin_public_video() {
	$this->layout = 'ajax';
	if ($this->request->is('post') || $this->request->is('put')) {
	    if(!empty($this->request->data['URL'])){
		$this->loadModel('Album');
		$this->loadModel('AlbumFile');
		$album = $this->Album->find('first',array('conditions'=>array('Album.user_id'=>$this->Auth->user('id'))));
		if(empty($album)){
		    $albm = array();
		    $albm['Album']['user_id'] = $this->Auth->user('id');
		    $albm['Album']['eng_name'] = $albm['Album']['eng_description'] = $this->Auth->user('first_name').' '.$this->Auth->user('last_name');
		    $albm['Album']['status'] = 1;
		    $this->Album->create();
		    $this->Album->save($albm);
		    $id = $this->Album->getLastInsertId();
		}
		else{
		    $id = $album['Album']['id'];
		}
		$value = $this->AlbumFile->find('first',array('conditions'=>array('AlbumFile.type'=>'video','AlbumFile.album_id'=>$id,'AlbumFile.url'=>$this->request->data['URL'])));
		if(empty($value)){
		    $data = array();
		    $data['AlbumFile']['album_id'] = $id;
		    $data['AlbumFile']['type'] = 'video';
		    $data['AlbumFile']['url'] = $this->request->data['URL'];
		    $this->AlbumFile->create();
		    $this->AlbumFile->save($data);
		    $host = @parse_url($this->request->data['URL']);
		    if (@$host['host'] == "www.youtube.com" or @$host['host'] == "youtube.com") {
			parse_str(@$host['query']);
			if (!empty($v)) {
			    echo  "http://img.youtube.com/vi/$v/3.jpg";
			    die;
			} 
		    }
		    echo 's';
		    die;
		}
		else{
		    echo 'e';
		    die;
		}
	    }
	    echo 'f';
	    die;
	}
	$this->set('vdotype','pubvdo');
	$this->render('admin_venue_video');
    }
    
     /*     * ********************************************************************************    
      @Function Name : admin_point_setting
      @Params        : NULL
      @Description   : Create and Save the point AED Settings
      @Author        : Rajnish
      @Date          : 6-Jan-2015
     * ********************************************************************************* */

    public function admin_point_setting() {
        $group_id = $this->Auth->user('group_id');
        $user_id = $this->Auth->user('id');
        $this->layout = 'admin';
        $this->loadModel('PointSetting');
        $page_title = 'Point Settings';
        $activeTMenu = 'pointSetting';
        $leftMenu = true;
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Point Setting' => 'javascript:void(0)',
        );
        $this->set('breadcrumb', $breadcrumb);
        $pointSettingDetail = $this->PointSetting->find('first', array('conditions' => array('user_id' => $user_id)));
        $this->set('pointSettingDetail', $pointSettingDetail);
        if ($this->request->is(array('put', 'post'))) {
            $this->request->data['PointSetting']['user_id'] = $user_id;
            $this->request->data['PointSetting']['createdDate'] = date('Y-m-d');
            if (@$pointSettingDetail['PointSetting']['id']) {
                $this->PointSetting->id = $pointSettingDetail['PointSetting']['id'];
            } else {
                $this->PointSetting->create();
            }
            if ($this->PointSetting->save($this->request->data)) {
                $this->Session->setFlash(__('Points have been saved successfully.', true), 'flash_success');
            } else {
                $this->Session->setFlash(__('Some error Occured while saving points.', true), 'flash_error');
            }
        }
        if (!$this->request->data && isset($pointSettingDetail)) {
            $this->request->data = $pointSettingDetail;
        }
        $this->set(compact('page_title', 'activeTMenu', 'leftMenu', 'breadcrumb'));
    }
    
     /**********************************************************************************    
      @Function Name : admin_pricing_level
      @Params        : NULL
      @Description   : Create and Save the pricing level
      @Author        : Aman Gupta
      @Date          : 16-March-2015
    ***********************************************************************************/
    public function admin_pricing_level($id = NULL,$type = null) {
        $this->layout= 'admin';
        $this->loadModel('PricingLevel');
        if(!$id && $type == 'empty'){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Settings";
            echo $this->render('addedit_priceopts');
            die;
        }
        if($this->request->is('post') || $this->request->is('put')){
            $this->request->data['PricingLevel']['user_id'] = $this->Auth->user('id');
            if($this->PricingLevel->save($this->request->data)){
                $dataJason['data'] = 'success';
                $dataJason['message'] = __('Pricing level saved successfully', true);
                echo json_encode($dataJason);
                die;    
            }
            else{
                $vError = $this->PricingLevel->validationErrors;
                $dataJason['data'] = $vError;
                $dataJason['message'] = __('Unable to save pricing Level.', true);
                echo json_encode($dataJason);
                die;  
            }
        }
        
        if($id && $type == 'edit'){
            $prcLvl = $this->PricingLevel->find('first',array('conditions'=>array('PricingLevel.id'=>$id,'PricingLevel.user_id' => $this->Auth->user('id') , 'PricingLevel.is_deleted' => 0)));
            if(!$this->request->data){
                $this->request->data = $prcLvl;
            }
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Settings";
            echo $this->render('addedit_priceopts');
            die;
        }
        
        if($id && $type == 'delete'){
            $this->PricingLevel->updateAll(array('PricingLevel.is_deleted' => 1), array('PricingLevel.id' => $id));
            
        }
        
        $pricingLevel = $this->PricingLevel->find('all',array('conditions'=>array('PricingLevel.user_id' => $this->Auth->user('id') , 'PricingLevel.is_deleted' => 0)));
        $activeTMenu = 'priceLevelemp';
        $leftMenu =  true;
        $page_title = 'Pricing Level';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Pricing Level' => 'javascript:void(0);',
        );
        
        $this->set(compact('activeTMenu','leftMenu','page_title','breadcrumb','pricingLevel'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Settings";
            $this->render('pricing_options');
        }
    }
    
     public function feedback() {
          $this->render('/StaticPages/feedback');
        
    }
    
    
    
            /**********************************************************************************    
      @Function Name : admin_wizard_info
      @Params        : NULL
      @Description   : Basic information about the number of wizards
      @Author        : Shibu Kumar
      @Date          : 21-April-2015
    ***********************************************************************************/
    function admin_wizard_info(){
        
    }
    
    /**********************************************************************************    
      @Function Name : admin_wizard_type
      @Params        : NULL
      @Description   : Basic information about the number of wizards
      @Author        : Shibu Kumar
      @Date          : 21-April-2015
    ***********************************************************************************/
    function admin_wizard_type($type=''){
        
        $this->layout = 'ajax';
        $this->viewPath = "Elements/admin/Settings";
        if($type == 'business_setup'){
            $this->render('business_setup_info');    
        }elseif($type == 'staff_setup'){
            $this->render('staff_setup_info');    
        }elseif($type == 'service_menu'){
            $this->render('service_menu_info');    
        }elseif($type == 'media_uploader'){
            $this->render('media_uploader_info');    
        }
        
        $userId = $this->Auth->user('id');
        $loginUser = $this->authUser();
        if($type){
           $remindlater = explode(',',$loginUser['User']['remind_later']);    
         }
         
         if(!empty($remindlater)){
             if(($key = array_search($type, $remindlater)) !== false) {
                    unset($remindlater[$key]);
                }
             
         }
         
        if($type){
            $data['User']['id'] = $userId;
            $data['User']['remind_later'] = implode(',',$remindlater);
            $this->User->Save($data);
        }
        
    }
    

    function admin_remind_later(){
        
        $this->loadModel('User');
        $this->autoRender = false;
        $userId = $this->Auth->user('id');
        $loginUser = $this->authUser();
        $remindlater  = array();
        
        if($loginUser['User']['remind_later']){
            $remindlater= explode(',',$loginUser['User']['remind_later']);    
        }
       
        $remindlater[]= $this->request->data['update'];
        
        if($this->request->data){
            $data['User']['id'] = $userId;
            $data['User']['remind_later'] = implode(',',$remindlater);
            $data['User']['is_popup'] ='';
            $this->User->Save($data);
            $this->Session->write('Remindlater.'.$this->request->data['update'], true);
            exit;
        }
        
    }
    
    function admin_completed_popup(){ 
        $this->loadModel('User');
        $this->autoRender = false;
        $userId = $this->Auth->user('id');
        $loginUser = $this->authUser();
        $completedPopup  = array();
        if($loginUser['User']['completed_popup']){
            $completedPopup = explode(',',$loginUser['User']['completed_popup']);    
        }
        
        $completedPopup[]= $this->request->data['update'];
        $result = array_unique($completedPopup);
        if($this->Session->read("Wizard.manual")){
            $this->Session->delete('Wizard.manual');
            $data['User']['id'] = $userId;
            $data['User']['is_popup'] ='';
            $this->User->Save($data);
            exit;
        }else if($this->request->data){
            $data['User']['id'] = $userId;
            $data['User']['completed_popup'] = implode(',',$result);
            $data['User']['is_popup'] ='';
            $this->User->Save($data);
            exit;
        }
        
    }
    
    function wizard_manual(){
        $this->autoRender = false;
        $this->loadModel("User");
        $userId = $this->Auth->user('id');
        $data['User']['id'] = $userId;
        $data['User']['is_popup'] ='';
        $this->User->Save($data);
        $this->Session->write("Wizard.manual",$this->request->data['update']);
        exit;
    }
    
    //function admin_completed_popup(){ 
    //    $this->loadModel('User');
    //    $this->autoRender = false;
    //    $userId = $this->Auth->user('id');
    //    $loginUser = $this->authUser();
    //    $completedPopup  = array();
    //    $remindlater  = array();
    //    
    //    if($loginUser['User']['completed_popup']){
    //        $completedPopup = explode(',',$loginUser['User']['completed_popup']);    
    //    }
    //    if($loginUser['User']['remind_later']){
    //        $remindlater = explode(',',$loginUser['User']['remind_later']);    
    //    }
    //    if(!empty($remindlater)){
    //        $pos = array_search($loginUser['User']['remind_later'], $remindlater);
    //        if($pos){
    //            unset($remindlater[$pos]);
    //        }
    //    }
    //    
    //    $completedPopup[]= $this->request->data['update'];
    //    
    //    if($this->request->data){
    //        $data['User']['id'] = $userId;
    //        $data['User']['completed_popup'] = implode(',',$completedPopup);
    //        $data['User']['remind_later'] = implode(',',$remindlater);
    //        $this->User->Save($data);
    //        exit;
    //    }
    //    
    //}
    
    
    /**********************************************************************************    
      @Function Name : display_order
      @Params        : NULL
      @Description   : Listing the display order of the employees 
      @Author        : Niharika Arora
      @Date          : 18-May-2015
    ***********************************************************************************/
    public function admin_display_order(){
        $this->layout = 'admin';
        $userid = $this->Auth->user('id');
        $page_title = 'Website Employee Lineup';
        $activeTMenu = 'displayorder';
        $leftMenu = true;
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Website Employee Lineup' => 'javascript:void(0)',
        );
        $this->loadModel('User');
        $this->User->recursive = 2;
        $users = $this->User->find('all',array('conditions'=>array('User.created_by'=>$userid,'User.is_deleted'=>0,'User.type'=>5),'order' => array('User.id DESC')));
        $admin_user = $this->User->findById($userid);
        $this->set(compact('page_title', 'activeTMenu', 'leftMenu', 'breadcrumb','users','admin_user'));
    }
    
        public function admin_seo() {
        $group_id = $this->Auth->user('group_id');
        $user_id = $this->Auth->user('id');
        $this->layout = 'admin';
        $this->loadModel('MetaTag');
        $page_title = 'Seo Tags';
        $activeTMenu = 'seoSetting';
        $leftMenu = true;
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Seo Setting' => 'javascript:void(0)',
        );
        $this->set('breadcrumb', $breadcrumb);
        $metaSettingDetail = $this->MetaTag->find('first', array('conditions' => array('user_id' => $user_id)));
        $this->set('MetaTag', $metaSettingDetail);
         if ($this->request->is(array('put', 'post'))) {
            $this->request->data['MetaTag']['user_id'] = $user_id;
            if (@$metaSettingDetail['MetaTag']['id']) {
                $this->MetaTag->id = $metaSettingDetail['MetaTag']['id'];
            } else {
                $this->MetaTag->create();
            }
            if ($this->MetaTag->save($this->request->data)) {
                $this->Session->setFlash(__('Seo settings have been saved successfully.', true), 'flash_success');
            } else {
                $this->Session->setFlash(__('Some error Occured while saving points.', true), 'flash_error');
            }
        }
        if (!$this->request->data && isset($metaSettingDetail)) {
            $this->request->data = $metaSettingDetail;
        }
        $this->set(compact('page_title', 'activeTMenu', 'leftMenu', 'breadcrumb'));
    }
    
    

}
