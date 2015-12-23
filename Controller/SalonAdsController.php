<?php

class SalonAdsController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Common', 'Email', 'Cookie', 'Paginator', 'Image',); //An array containing the names of components this controller uses.

    /**
     * List Advertisements
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_ads     
     * @since         version 0.0.1
     */

    public function admin_ads() {
        $this->layout = 'admin';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Advertisement' => array('controller' => 'SalonAds', 'action' => 'ads', 'admin' => true),
        );
        $this->set('breadcrumb', $breadcrumb);
        $created_by = $this->Auth->user('id');
        if ($this->Auth->user('type') == 1)
            $created_by = 0;
        $ads = $this->SalonAd->find('all', array('fields' => array(
                'SalonAd.id', 'SalonAd.image',
                'SalonAd.eng_title',
                'SalonAd.ara_title',
                'SalonAd.eng_description',
                'SalonAd.ara_description',
                //'SalonAd.no_of_click',
                'SalonAd.url',
                //'SalonAd.eng_location',
                //'SalonAd.ara_location',
                //'SalonAd.is_featured',
                'SalonAd.status',
            ),
            'conditions' => array(
                'SalonAd.created_by' => $created_by, 'SalonAd.is_deleted' => 0
        )));
        $this->set(compact('ads'));
        $this->set('page_title', 'Advertisement');
        $this->set('activeTMenu', 'salonAds');
        $this->set('plan', $this->checkPlan($this->Auth->user('id')));
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/salonAds";
            $this->render('list_salon_ads');
        }
    }

    /**
     * Save Advertisement
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_addAds
     * @param         $id
     * @since         version 0.0.1
     */
    public function admin_addAds($id = NULL) {
        $this->layout = 'ajax';
        $this->loadModel('State');
         $this->loadModel('City');
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Advertisement' => array('controller' => 'SalonAds', 'action' => 'ads', 'admin' => true),
        );
        if ($id) {
            $adDetail = $this->SalonAd->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        } else {
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //print_r($this->request->data); die;
            
            //Advertisement image upload
            if (!empty($this->request->data['SalonAd']['image']['name'])) {
                $image = $this->request->data['SalonAd']['image'];
                unset($this->request->data['SalonAd']['image']);
                $model = "SalonAd";
                list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);
                if ($width > '5' && $height >'1') {
                    $retrun = $this->Image->upload_image($image, $model, $this->Auth->user('id'));
                    if ($retrun) {
                        $this->request->data['SalonAd']['image'] = $retrun;
                        if (@$adDetail['SalonAd']['image']) {
                            $this->Image->delete_image($adDetail['SalonAd']['image'], $model, $this->Auth->user('id'));
                        }
                    }
                } else {
                    $edata['data'] = 'Fail';
                    $edata['message'] = __('only_width_540_height_140_allowed', true);
                    echo json_encode($edata);
                    die;
                }
            } else {
                $this->request->data['SalonAd']['image'] = @$adDetail['SalonAd']['image'];
            }
            $data = $this->request->data;
            if (!empty($data['SalonAd']['id'])) {
                $this->SalonAd->id = $data['SalonAd']['id'];
            } else {
                $data['SalonAd']['created_by'] = $this->Auth->user('id');
                $data['SalonAd']['user_id'] = $this->Auth->user('id');
                $data['SalonAd']['createdDate'] = date('d-m-y');
                if ($this->Auth->user('type') == 1) {
                    $data['SalonAd']['created_by'] = 0;
                }
                $data['SalonAd']['status'] = 1;
                $this->SalonAd->create();
            }
            if ($this->SalonAd->save($data)) {
                $record_id=$this->SalonAd->id;
                $this->loadModel('cityToAd');
                //print_r($this->request->data); die;
                if(isset($this->request->data['Address']['city_id']) && $this->request->data['Address']['city_id']!=''){
                foreach($this->request->data['Address']['city_id'] as $city){
                    $CityData['cityToAd']['add_id']=$record_id;
                    $CityData['cityToAd']['city_id']=$city;
                    //pr($CityData); die;
                    $this->cityToAd->create();
                    $this->cityToAd->save($CityData);
                }
                }
                $edata['data'] = 'success';
                $edata['message'] = __('Advertisment_save_success', true);
                echo json_encode($edata);
                die;
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->SalonAd->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }

        if (!$this->request->data && isset($adDetail)) {
            $this->request->data = $adDetail;
            $this->set('adDetail', $adDetail);
        }
        
        
        //if($countryId){
	  //  $stateData = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$countryId,'State.status'=>1)));
        //}else{
          //  $countryId  = $this->Auth->user('Address.country_id');
            //$stateData = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.status'=>1)));
        //}
        
        //$countryId  = $this->Auth->user('Address.country_id');
            //$stateData = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$countryId,'State.status'=>1)));
        
        //if($stateId){
          //  $cityData = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$stateId,'City.status'=>1)));
        //}else{
          //  $stateId = $this->Auth->user('Address.state_id');  
            //$cityData = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$stateId,'City.status'=>1)));
        //}
        
       // $stateId = $this->Auth->user('Address.state_id');  
           // $cityData = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$stateId,'City.status'=>1)));
        
        
        
       // $countryData =  $this->Common->getCountries();
        //$type = isset($this->request->data['User']['type']) ? $this->request->data['User']['type'] : 6 ;
        //$cc_list = $this->listforCC();
        
        
        
        $stateData = array();
        $cityData = array();
        $this->loadModel('State');
         $this->loadModel('City');
         $countryId  = $this->Auth->user('Address.country_id');
         $stateId  = $this->Auth->user('Address.state_id');
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
        
        
        
      $this->set(compact('countryData','stateData','cityData','userInfo','cc_list','frenchList','type'));
  
        
    }

    /**
     * Save Advertisement
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_addAds
     * @param         $id
     * @since         version 0.0.1
     */
    public function admin_deleteAd() {
        $this->autoRender = "false";
        if ($this->request->is('post') || $this->request->is('put')) {
            $id = $this->request->data['id'];
            $ads = $this->SalonAd->findById($id);
            if (!empty($ads)) {
                if ($this->SalonAd->updateAll(array('SalonAd.is_deleted' => 1), array('SalonAd.id' => $id))) {
                    $edata['data'] = 'success';
                    $edata['message'] = __('delete_success_ad', true);
                } else {
                    $edata['data'] = 'error';
                    $edata['message'] = __('unable_to_delete_ad', true);
                }
            } else {
                $edata['data'] = 'error';
                $edata['message'] = __('ad_not_found', true);
            }
        }
        echo json_encode($edata);
        die;
    }

    /**
     * Change Stattus Advertisement
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_changeStatus
     * @param         id as a post
     * @since         version 0.0.1
     */
    public function admin_changeStatus() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ((int) $this->request->data['id']) {
                $this->SalonAd->updateAll(array('SalonAd.status' => $this->request->data['status']), array('SalonAd.id' => $this->request->data['id']));
                echo $this->request->data['status'];
            } else {
                return 'Technical issue';
            }
        } else {
            return 'Technical Issue.';
        }
        die;
    }

    function checkPlan($uid = NULL) {
        $this->loadModel('SalonFeaturingSubscriptionPlan');
        $this->SalonFeaturingSubscriptionPlan->recursive = 2;
        $package = $this->SalonFeaturingSubscriptionPlan->find('first', array('conditions' => array('user_id' => $uid)));
        if (is_array($package) && count($package)) {
            return $package['SalonFeaturingSubscriptionPlan']['id'];
        } else {
            return false;
        }
    }

    function validPlan($package_id = NULL) {
        return TRUE;
    }

    /**
     * Chaange advertisement featured status
     * @author        Rajnish
     * @copyright     smartData Enterprise Inc.
     * @method        admin_changeFeaturedStatus
     * @param         
     * @since         version 0.0.1
     */
    public function admin_changeFeaturedStatus(){
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ((int) $this->request->data['id']) {
                $uid = $this->Auth->user('id');
                $pakage_id = $this->checkPlan($uid);
                if (count($pakage_id) >= 0) {
                    $validPlan = $this->validPlan($pakage_id);
                    if ($validPlan) {
                        $this->SalonAd->updateAll(
                                array('SalonAd.is_featured' => $this->request->data['status']), array('SalonAd.id' => $this->request->data['id']));
                        echo $this->request->data['status'];
                    } else {
                        return "Technical Plan issue.";
                    }
                } else {
                    return "Technical Package issue.";
                }
            } else {
                return "Technical id issue.";
            }
        } else {
            return "Technical post issue.";
        }
        die;
    }

}
