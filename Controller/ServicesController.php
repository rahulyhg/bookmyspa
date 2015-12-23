<?php

class ServicesController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Cookie', 'Image','Common'); //An array containing the names of components this controller uses.

    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('update');
    }
    
    /**********************************************************************************    
      @Function Name : treatment
      @Params	 : NULL
      @Description   : The Function is for admin treatments and services
      @Author        : Surjit Kaur
      @Date          : 10-Nov-2014
     * **********************************************************************************/

    public function admin_treatment(){
        $this->layout = 'admin';
        $this->set('User', $this->Auth->user());
        $breadcrumb = array(
                    'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
                    'Service & Treatment'=>'javascript:void(0);'
                );
        $this->set('breadcrumb', $breadcrumb);
        $getData = $this->getServices_tree();
        $this->set(compact('getData'));
        $this->set('page_title', 'Service & Treatment');
        $this->set('activeTMenu', 'treatment');
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = 'Elements/admin/Service';
            $this->render('nestable_list');
        }
    }
    
    public function admin_designtreatment(){
        $this->layout = 'admin';
        $this->set('page_title', 'Treatments');
        $this->set('activeTMenu', 'treatment');
    }

    /**********************************************************************************    
      @Function Name : getServices_tree
      @Params	 : $createdBy
      @Description   : Returns tree structure for the Tages and Service -> subService
      @Author        : Aman Gupta
      @Date          : 15-Dec-2014
     ********************************************************************************** */

    function getServices_tree(){
        $newgetData = $this->Service->find('all', array('fields' => array('Service.id', 'Service.eng_name AS name', 'Service.parent_id', 'Service.status', 'Service.service_order', 'Service.frontend_display'), 'conditions' => array( 'Service.is_deleted' => 0,'Service.parent_id' => 0), 'order' => array('Service.service_order')));
        if(!empty($newgetData)){
            foreach($newgetData as $thk=>$serviceIs){
                $newchild = $this->Service->find('all', array('fields' => array('Service.id', 'Service.eng_name AS name', 'Service.parent_id', 'Service.status', 'Service.service_order', 'Service.frontend_display'), 'conditions' => array( 'Service.is_deleted' => 0,'Service.parent_id' => $serviceIs['Service']['id']), 'order' => array('Service.service_order')));
                $newgetData[$thk]['children'] = $newchild;
                if(!empty($newchild)){
                    foreach($newchild as $inthk=>$childserviceIs){
                        $newchildinside = $this->Service->find('all', array('fields' => array('Service.id', 'Service.eng_name AS name', 'Service.parent_id', 'Service.status', 'Service.service_order', 'Service.frontend_display'), 'conditions' => array( 'Service.is_deleted' => 0,'Service.parent_id' => $childserviceIs['Service']['id']), 'order' => array('Service.service_order')));
                        $newgetData[$thk]['children'][$inthk]['children'] = $newchildinside;
                    }
                }
            }
        }
        return $newgetData;
    }

    /**********************************************************************************    
      @Function Name : getParent_tag
      @Params	 : $createdBy
      @Description   : Returns tree structure for the Tages and Service -> subService
      @Author        : Aman Gupta
      @Date          : 15-Dec-2014
    ********************************************************************************** */
    function getParent_tag() {
        $lang = Configure::read('Config.language');
        $getData = $this->Service->find('list', array('fields' => array('Service.id'), 'conditions' => array( 'Service.parent_id' => 0, 'Service.status' => 1, 'Service.is_deleted' => 0), 'order' => array('Service.service_order')));
        return $getData;
    }

    /**********************************************************************************    
      @Function Name : admin_addedit_category
      @Params	     : NULL
      @Description   : For adding Category
      @Author        : Aman Gupta
      @Date          : 14-Nov-2014
    ********************************************************************************** */
    public function admin_addedit_category($serviceId = NULL , $parentId = NULL,$typ = NULL) {
        if($this->request->is('post') || $this->request->is('put')){
            $this->request->data['Service']['status'] = 1;
            $serviceimage = array_filter($this->request->data['Service']['serviceimage']);
           
            unset($this->request->data['Service']['serviceimage']);
            if(empty($serviceimage)){
                $this->Service->set($this->request->data);
                $this->Service->validates();
                $errorD = $this->Service->validationErrors;
                $edata['data'] = $errorD;
                $edata['message'] = __('Please select at least one image', true);
                echo json_encode($edata);
                die;    
            }
            elseif($this->Service->save($this->request->data)){
                $serviceId = $this->Service->id;
                if(!empty($serviceimage)){
                    $this->loadModel('ServiceImage');
                    $imageList = $this->ServiceImage->find('list',array('conditions'=>array('ServiceImage.service_id' => $serviceId,'ServiceImage.created_by'=>$this->Auth->user('id')),'fields'=>array('ServiceImage.image')));
                   
                    
                    $this->ServiceImage->deleteAll(array('ServiceImage.service_id' => $serviceId,'ServiceImage.created_by'=>$this->Auth->user('id')));
                    foreach($serviceimage as $key=>$theImage){
                        $imgData = array();
                        $imgData['ServiceImage']['service_id'] = $serviceId;
                        $imgData['ServiceImage']['image'] = $theImage;
                        $imgData['ServiceImage']['order'] = $key;
                        $imgData['ServiceImage']['created_by'] = $this->Auth->user('id');
                        $this->ServiceImage->create();
                        $this->ServiceImage->save($imgData);
                    }
                    if(!empty($imageList)){
                        $nonImg = array_diff($imageList, $serviceimage);
                        if(!empty($nonImg)){
                            foreach($nonImg as $thedImage){
                                $count = $this->ServiceImage->find('count',array('conditions'=>array('ServiceImage.image'=>$thedImage)));
                                if($count == 0){
                                     //$this->Image->delete_image($thedImage, 'Service', $this->Auth->user('id'), false);     
                                }
                            }
                        }
                    }
                    $this->deleteImageTemp();
                    //$this->loadModel('TempImage');
                    //
                    //$this->TempImage->deleteAll(array('TempImage.path' => 'Service','TempImage.user_id' => $this->Auth->user('id'),'TempImage.parent_id' => $this->request->data['Service']['parent_id']));
                }
                $edata['data'] = 'success';
                $edata['message'] = __('Details have been saved successfully.', true);
                $edata['id'] = $serviceId;
                echo json_encode($edata);
                die;    
            }else{
                $errorD = $this->Service->validationErrors;
                $edata['data'] = $errorD;
                $edata['message'] = __('Some error occurred.', true);
                echo json_encode($edata);
                die;
            }
        }
        if ($serviceId) {
            $serviceData = $this->Service->findById($serviceId);
            $this->request->data = $serviceData;
        }
        $this->set(compact('parentId','typ'));
    }

    /**********************************************************************************    
      @Function Name : admin_edit_treatment
      @Params	     : NULL
      @Description   : For creating Tag via Ajax
      @Author        : Aman Gupta
      @Date          : 14-Nov-2014
      @modified      : 16-Jan-2015
    ********************************************************************************** */
    //public function admin_edit_treatment($uid = NULL) {
    //    if ($uid) {
    //        $serviceData = $this->Service->findById($uid);
    //        $this->request->data = $serviceData;
    //    }
    //    
    //    //$this->viewPath = 'Elements/admin/Service';
    //    //$this->render('nestable_form');
    //}

    /**********************************************************************************    
      @Function Name : admin_change_frontview
      @Params	     : NULL
      @Description   : For changing the frontView status
      @Author        : Aman Gupta
      @Date          : 14-Nov-2014
    ******************************************************************************** */
    public function admin_change_frontview() {
        if($this->request->is('post') || $this->request->is('put')){
            if(isset($this->request->data['id']) && !empty($this->request->data['id'])){
                $this->Service->updateAll(array('Service.frontend_display' => $this->request->data['status']), array('Service.id' => $this->request->data['id']));
                echo "s";
            }
        }
        die;
    }
    /**********************************************************************************    
      @Function Name : admin_change_status
      @Params	     : NULL
      @Description   : For changing the status
      @Author        : Aman Gupta
      @Date          : 14-Nov-2014
    ******************************************************************************** */
    public function admin_change_status() {
        if($this->request->is('post') || $this->request->is('put')){
            if(isset($this->request->data['id']) && !empty($this->request->data['id'])){
                $this->Service->updateAll(array('Service.status' => $this->request->data['status']), array('Service.id' => $this->request->data['id']));
                echo "s";
            }
        }
        die;
    }
    /**********************************************************************************    
      @Function Name : admin_addedit_tag
      @Params	     : NULL
      @Description   : For creating Tag via Ajax
      @Author        : Aman Gupta
      @Date          : 14-Nov-2014
      @modified      : 16-Jan-2015
    ********************************************************************************** */
    public function admin_addedit_tag($tagid = NULL) {
        if($this->request->is('post') || $this->request->is('put')){
            $this->request->data['Service']['status'] = 1;
            if($this->Service->save($this->request->data)){
                $edata['data'] = 'success';
                $edata['message'] = __('Tag has been saved successfully.', true);
                $edata['id'] = $this->Service->getLastInsertId();
                echo json_encode($edata);
                die;    
            }else{
                $errorD = $this->Service->validationErrors;
                $edata['data'] = $errorD;
                $edata['message'] = __('Unable to save data', true);
                echo json_encode($edata);
                die;
            }
        }
        if ($tagid) {
            $serviceData = $this->Service->findById($tagid);
            $this->request->data = $serviceData;
        }
    }
    
    /**********************************************************************************    
      @Function Name : service_order
      @Params	 : NULL
      @Description   : The Function is for sorting treatments and services
      @Author        : Surjit Kaur
      @Date          : 10-Nov-2014
    ***********************************************************************************/
    public function admin_service_order(){
        $this->autoRender = false;
        $this->layout = 'ajax';
        if($this->request->is('ajax')){
            $stringObject = json_decode(stripslashes($this->request->data['serviceOrder']), true);
            $this->recursor($stringObject);
            die;
        }
    }

    /**********************************************************************************    
      @Function Name : recursor
      @Params	 : NULL
      @Description   : The Function is for save threaded multiple services request.
      @Author        : Surjit Kaur
      @Date          : 10-Nov-2014
    ***********************************************************************************/
    public function recursor(&$complexArray = null) {
        if (is_array($complexArray) && count($complexArray) > 0) {
            foreach ($complexArray as $n => $v) {
                $dataT = array();
                $dataT['Service']['id'] = $v;
                $dataT['Service']['service_order'] = $n;
                $this->Service->updateAll($dataT['Service'], array('Service.id' => $v));
            }
        }
    }

    /*     * ********************************************************************************    
      @Function Name : admin_upload_image
      @Params	 : NULL
      @Description   : The Function is for uploading service image via ajax to temp_image table
      @Author        : Aman Gupta
      @Date          : 14-Nov-2014
     * ********************************************************************************* */

    public function admin_upload_image($serviceId = NULL, $parentId = NULL) {
        $this->autoRender = false;
        $this->loadModel('TempImage');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($_FILES) {
                $userId = $this->Auth->user('id');
                $model = "Service";
                $retrun = $this->Image->upload_image($_FILES['image'], $model, $userId, false);
                if ($retrun) {

                    if ($parentId) {
                        
                    } else {
                        $listTmpImages = $this->TempImage->find('all', array('fields' => array('TempImage.image'), 'conditions' => array('TempImage.user_id' => $this->Auth->user('id'), 'TempImage.path' => $model, 'TempImage.parent_id' => 0)));
                        if (!empty($listTmpImages))
                            foreach ($listTmpImages as $listTmpImage) {
                                $this->Image->delete_image($listTmpImage['TempImage']['image'], $model, $userId, false);
                            }
                        $this->TempImage->deleteAll(array('TempImage.user_id' => $this->Auth->user('id'), 'TempImage.path' => $model));
                    }

                    if ($serviceId) {
                        $this->loadModel('ServiceDetail');
                        $this->loadModel('ServiceImage');
                        if ($parentId) {
                            $srvD['ServiceImage']['service_id'] = $serviceId;
                            $srvD['ServiceImage']['image'] = $retrun;
                            $srvD['ServiceImage']['created_by'] = $this->Auth->user('id');
                            $this->ServiceImage->create();
                            $this->ServiceImage->save($srvD);
                        } else {
                            $sImage = $this->ServiceImage->find('first', array('conditions' => array('ServiceImage.service_id' => $serviceId)));
                            if (!empty($sImage) && isset($sImage['ServiceImage']['image']) && !empty($sImage['ServiceImage']['image'])) {
                                $sImage = $sImage['ServiceImage']['image'];
                                //$this->Image->delete_image($sImage, $model, $userId, false);
                                $this->ServiceImage->updateAll(array('ServiceImage.image' => "'" . $retrun . "'"), array('ServiceImage.service_id' => $serviceId, 'ServiceImage.created_by' => $this->Auth->user('id')));
                            } else {
                                $srvD['ServiceImage']['service_id'] = $serviceId;
                                $srvD['ServiceImage']['image'] = $retrun;
                                $srvD['ServiceImage']['created_by'] = $this->Auth->user('id');
                                $this->ServiceImage->create();
                                $this->ServiceImage->save($srvD);
                            }
                        }
                    } else {
                        $tempD['TempImage']['user_id'] = $userId;
                        $tempD['TempImage']['image'] = $retrun;
                        $tempD['TempImage']['path'] = $model;
                        $tempD['TempImage']['parent_id'] = $parentId;
                        $this->TempImage->create();
                        $this->TempImage->save($tempD);
                    }
                    echo $retrun;
                    die();
                } else {
                    echo "f";
                }
            } else {
                echo "f";
            }
        }
        die();
    }

    /*     * ********************************************************************************    
      @Function Name : admin_delete_image
      @Params	 : NULL
      @Description   : The Function is for delete Image from Service Via Ajax
      @Author        : Aman Gupta
      @Date          : 14-Nov-2014
     * ********************************************************************************* */

    public function admin_delete_image() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $model = "Service";
            if ($this->request->data['id'] == 0) {
                $this->loadModel('TempImage');
                $delete = false;
                if (isset($this->request->data['imageName']) && !empty($this->request->data['imageName'])) {
                    $findImage = $this->ServiceImage->find('all', array('conditions' => array('ServiceImage.image' => $this->request->data['imageName'])));
                    if (empty($findImage)) {
                        $delete = true;
                    }
                } else {
                    $delete = true;
                }

                if ($delete) {
                    $listTmpImages = $this->TempImage->find('all', array('fields' => array('TempImage.image'), 'conditions' => array('TempImage.user_id' => $this->Auth->user('id'), 'TempImage.path' => $model)));

                    if (!empty($listTmpImages))
                        foreach ($listTmpImages as $listTmpImage) {
                            $this->Image->delete_image($listTmpImage['TempImage']['image'], $model, $this->Auth->user('id'), false);
                        }
                    $this->TempImage->deleteAll(array('TempImage.user_id' => $this->Auth->user('id'), 'TempImage.path' => $model));
                }

                echo 's';
            } else {
                $this->loadModel('ServiceImage');
                $cond = array('ServiceImage.service_id' => $this->request->data['id']);
                if (isset($this->request->data['imageName']) && !empty($this->request->data['imageName'])) {
                    $cond = array_merge($cond, array('ServiceImage.image' => $this->request->data['imageName']));
                }
                $sImage = $this->ServiceImage->find('first', array('fields' => array('ServiceImage.image'), 'conditions' => $cond));
                if (!empty($sImage)) {
                    $this->ServiceImage->deleteAll(array('ServiceImage.service_id' => $this->request->data['id'], 'ServiceImage.image' => $sImage['ServiceImage']['image']));
                    $findImage = $this->ServiceImage->find('all', array('conditions' => array('ServiceImage.image' => $sImage['ServiceImage']['image'])));
                    //if (empty($findImage))
                        //$this->Image->delete_image($sImage['ServiceImage']['image'], $model, $this->Auth->user('id'), false);
                }
                echo "s";
            }
        }
        die;
    }

    /*     * ********************************************************************************    
      @Function Name : admin_delete_service
      @Params	 : NULL
      @Description   : The Function is for delete Service from Service Via Ajax
      @Author        : Aman Gupta
      @Date          : 14-Nov-2014
     * ********************************************************************************* */

    function admin_delete_service($uid = NULL) {
        $this->autoRender = false;
        if ($uid) {
            if($this->Service->updateAll(array('Service.is_deleted' => '1'), array('Service.id' => $uid))){
                echo 's';
                die;
            }else{
                echo 'f';
            }
        }
        die;
    }

    /*     * ********************************************************************************    
      @Function Name : admin_service_gallery
      @Params	 : NULL
      @Description   : The Function will show the Service gallery for 2nd Level
      @Author        : Aman Gupta
      @Date          : 10-Dec-2014
         for SAlon Service
         $sParentId---> Service(id)
         $serviceId--->'SalonService (id)'
         $path---->'SalonService'
      @
     * ********************************************************************************* */
   
    public function admin_service_gallery($sParentId = NULL,$serviceId = NULL,$path="Service" , $resize = null,$SalonServiceparent = null) {
        $this->layout = 'ajax';
        $this->loadModel('ServiceImage');
        $salonservice=array();
        if ($this->request->is('post') || $this->request->is('put')) {
            $userId = $this->Auth->user('id');
            $model = "Service";

            if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                $userId = $this->Auth->user('id');
                $model = "Service";
                if($resize == '1'){
                    $retrun = $this->Image->upload_service_image($_FILES['image'], $model, $userId, false);
                }else{
                    $retrun = $this->Image->upload_image($_FILES['image'], $model, $userId, false);
                }
                if ($retrun) {
                    if ($this->request->data['serviceId']) {
                        $this->loadModel('ServiceImage');
                        $srvD['ServiceImage']['service_id'] = $this->request->data['serviceId'];
                        $srvD['ServiceImage']['image'] = $retrun;
                        $srvD['ServiceImage']['created_by'] = $userId;
                        $this->ServiceImage->create();
                        if ($this->ServiceImage->save($srvD)) {
                            $edata['data'] = 'success';
                            $edata['id'] = $this->request->data['serviceId'];
                            $edata['image'] = $retrun;
                            echo json_encode($edata);
                            die;
                        } else {
                            //$this->Image->delete_image($retrun, $model, $userId, false);
                            echo 'f';
                        }
                    } else {
                        $this->loadModel('TempImage');
                        $tempD['TempImage']['user_id'] = $this->Auth->user('id');
                        $tempD['TempImage']['image'] = $retrun;
                        $tempD['TempImage']['path'] = $path;
                        $tempD['TempImage']['parent_id'] = $this->request->data['parent_id'];
                        $this->TempImage->create();
                        if ($this->TempImage->save($tempD)) {
                            $edata['data'] = $path;
                            $edata['id'] = '';
                            $edata['image'] = $retrun;
                            echo json_encode($edata);
                            die;
                        } else {
                            //$this->Image->delete_image($retrun, $model, $userId, false);
                            echo 'f';
                            die;
                        }
                    }
                } else {
                    echo 'f';
                }
            } else {
                echo 'f';
            }
            die;
        }

        $service = array();
        
        if ($sParentId && $path=='Service') {
            $service = $this->Service->find('all', array('contain'=>array('ServiceImage'=>array('conditions'=>array('ServiceImage.created_by'=>1))),'conditions' => array('Service.id' => $sParentId)));
            
        }elseif(($path=='SalonService') && ($this->Auth->User('type') !=1) ){
            $this->loadMOdel('SalonService');
            if($sParentId){
                
                $service = $this->Service->find('all', array('contain'=>array('ServiceImage'=>array('conditions'=>array('ServiceImage.created_by'=>1))),'conditions' => array('Service.id' => array($sParentId,$SalonServiceparent))));
               // pr($service);
            }
           $salonservice =  $this->SalonService->find('first', array('contain'=>array('SalonServiceImage'=>array('conditions'=>array('SalonServiceImage.created_by'=>$this->Auth->User('id')))),'conditions' => array('SalonService.id' => $serviceId)));
        }
        
        $this->set(compact('service','serviceId','salonservice','path'));
    }

    /*     * ********************************************************************************    
      @Function Name : admin_service_gallery
      @Params	 : NULL
      @Description   : The Function will add image to 3rd level category
      @Author        : Aman Gupta
      @Date          : 11-Dec-2014
     * ********************************************************************************* */

    public function admin_add_image_sub($path='Service') {
        $this->autoRender = false;
        $userId = $this->Auth->user('id');
         if($userId==1){
            $model="Service";
            $serviceid = "service_id";
            $imageModel = "ServiceImage";
            $ordering = "checklastServiceOrder";
        }else{
            $model="SalonService";
            $serviceid = "salon_service_id";
            $imageModel = "SalonServiceImage";
            $ordering = "checklastSalonServiceOrder";
        }

        if ($this->request->is('post') || $this->request->is('put')) {
           
            if ($this->request->data['id']) {
                $this->loadModel($imageModel);
                $srvD[$imageModel][$serviceid] = $this->request->data['id'];
                $srvD[$imageModel]['image'] = $this->request->data['imageName'];
                $srvD[$imageModel]['created_by'] = $this->Auth->user('id');
                $this->$imageModel->create();
                if ($this->$imageModel->save($srvD)) {
                    echo $this->request->data['imageName'];
                    die;
                } else {
                    echo 'f';
                    die ;
                }
            } else { 
                $this->loadModel('TempImage');
                $tempD['TempImage']['user_id'] = $this->Auth->user('id');
                $tempD['TempImage']['image'] = $this->request->data['imageName'];
                $tempD['TempImage']['path'] = $path;
                $tempD['TempImage']['parent_id'] = $this->request->data['parent_id'];
                $this->TempImage->create();
                if ($this->TempImage->save($tempD)) {
                    echo $this->request->data['imageName'];
                    die;
                } else {
                    echo 'f';
                    die;
                }
            }
        }
        die;
    }

    /*     * ********************************************************************************    
      @Function Name : deleteImageTemp
      @Params	 : NULL
      @Description   : Delete Image From Temp Image tablr
      @Author        : Aman Gupta
      @Date          : 11-Dec-2014
     * ********************************************************************************* */

    public function deleteImageTemp() {
        $this->loadModel('TempImage');
        $dataList = $this->TempImage->find('all', array('conditions' => array('TempImage.user_id' => $this->Auth->user('id'))));
        if (!empty($dataList)) {
            foreach ($dataList as $dataItm) {
                $this->loadModel('ServiceImage');
                $itsThere = $this->ServiceImage->find('all', array('fields' => array('ServiceImage.id'), 'conditions' => array('ServiceImage.image' => $dataItm['TempImage']['image'])));
                if (empty($itsThere)) {
                    $this->Image->delete_image($dataItm['TempImage']['image'], 'Service', $this->Auth->user('id'), false);
                }
                $this->TempImage->deleteAll(array('TempImage.id' => $dataItm['TempImage']['id']));
            }
        }
    }

    /*     * ********************************************************************************    
      @Function Name : deleteImageTemp
      @Params	 : NULL
      @Description   : Delete Image From Temp Image tablr
      @Author        : Aman Gupta
      @Date          : 11-Dec-2014
     * ********************************************************************************* */

    public function admin_treatment_gallery() {
        $this->layout = 'admin';
        $activeTMenu = 'treatmentGallery';
        $page_title = 'Treatment Gallery';
        $leftMenu = true;
        $breadcrumb = array(
                    'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
                    'Treatment Gallery'=>'javascript:void(0)'
                );
        $this->set(compact('services', 'activeTMenu', 'page_title','leftMenu','breadcrumb'));
        $type= '';
        if($this->Auth->user('type')==1){
            $type='admin';
            $data = $this->getParent_tag();
            $services = $this->Service->find('all', array('conditions' => array('Service.parent_id'=>$data, 'Service.status' => 1, 'Service.is_deleted' => 0)));
            if (!empty($services)) {
                 foreach ($services as $ke => $service) {
                     $childServices = $this->Service->find('all', array('conditions' => array('Service.parent_id' => $service['Service']['id'], 'Service.status' => 1, 'Service.is_deleted' => 0)));
                     $services[$ke]['children'] = $childServices;
                 }
             }
             $this->set(compact('services'));
        }
        else{
            $type='salon';
            $this->loadModel('SalonService');
            $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
             $this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('ServicePricingOption','SalonStaffService')));
            //$this->SalonService->recursive = 2;
            $services = $this->SalonService->find('threaded',array('conditions' => array('SalonService.salon_id'=>$this->Auth->user('id'),'SalonService.is_deleted' =>0),'order' => array('SalonService.service_order')));
           // pr($services);exit;
            $this->set(compact('services'));
           $this->render('salon_treatment_gallery');
        }
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = 'Elements/admin/Service';
            if($type=='admin'){
                $this->render('treatment_gallery');    
            }else{
                $this->render('salon_treatment_gallery');
            }
            
        }
    }

    
    
    public function getnestedServiceImage($service_id = null){
        
        $this->loadModel('ServiceImage');
       return $this->ServiceImage->find('all',array('conditions'=>array('ServiceImage.created_by'=>$this->Auth->User('id'),'ServiceImage.service_id'=>$service_id),'order' => array('ServiceImage.order')));
       
    }
    
    
    
    /*     * ********************************************************************************    
      @Function Name : admin_deleteTreatmentImage
      @Params	 : NULL
      @Description   : To delete Image From Services
      @Author        : Aman Gupta
      @Date          : 18-Dec-2014
     * ********************************************************************************* */

    public function admin_deleteTreatmentImage($serviceId = NULL, $image = NULL) {
        if($this->Auth->user('id')==1){
            $imageModel = 'ServiceImage';
            $model = 'Service';
            $serviceid = 'service_id';
            $order = 'checklastServiceOrder';
        }else{
            $imageModel = 'SalonServiceImage';
            $model = 'SalonService';
            $serviceid='salon_service_id';
            $order = 'checklastSalonServiceOrder';
        }
        if ($serviceId && $image) {
            $this->loadModel($imageModel);
            $this->loadModel($model);
            
            $this->$model->unbindModel(array('hasMany' => $imageModel));
            $subServices = $this->$model->find('list', array('fields' => array($model.'.id'), 'conditions' => array($model.'.parent_id' => $serviceId, $model.'.is_deleted' => 0)));
            
            $getCount = $this->getserviceDeleteCount($subServices,$image);
            $errCount = array();
            if(!empty($getCount)){
                foreach($getCount as $serviceCount){
                    if($serviceCount['SalonServiceImage']['count']==1){
                         $errCount[]= $this->Common->get_salon_service_name($serviceCount['SalonServiceImage']['salon_service_id']);
                    }
                }
            }
            
            $eData = '';
            if(!empty($errCount)){
                $eData['data'] = implode(',',$errCount);
                $eData['msg'] = 'e';
                echo json_encode($eData);
                exit;
            }
                  
            $subServices[] = $serviceId;
            //$this->Image->delete_image($image, 'Service', $this->Auth->user('id'), false);
            if ($this->$imageModel->deleteAll(array($imageModel.'.'.$serviceid => $subServices, $imageModel.'.image' => $image))) {
                $eData['data'] = '';
                $eData['msg'] = 's';
                echo json_encode($eData);
            } else {
                $eData['data'] = '';
                $eData['msg'] = 'e';
                echo json_encode($eData);
            }
        } else {
                $eData['data'] = '';
                $eData['msg'] = 'e';
                echo json_encode($eData);
        }
        die;
    }

     /**********************************************************************************    
      @Function Name : admin_editTreatmentImage
      @Params	 : NULL
      @Description   : To Edit Image
      @Author        : Shibu Kumar
      @Date          : 29-Dec-2014
     * ********************************************************************************* */

    public function admin_editTreatmentImage($serviceId = NULL, $sImage = array()) {
        
        if($this->Auth->user('id')==1){
            $imageModel = 'ServiceImage';
            $model = 'Service';
            $serviceid = 'service_id';
            $order = 'checklastServiceOrder';
        }else{
            $imageModel = 'SalonServiceImage';
            $model = 'SalonService';
            $serviceid='salon_service_id';
            $order = 'checklastSalonServiceOrder';
        }
        
        $this->loadModel($model);
        $this->loadModel($imageModel);
        $this->layout = 'ajax';
         $serviceId = isset($this->request->data[$imageModel][$serviceid]) ? $this->request->data[$imageModel][$serviceid] : $serviceId;
        
        $imageServices = array();
        if ($serviceId) {
            if($model == "SalonService"){
                $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
                $this->SalonService->recursive = 1;
                $subServicesTemp = $this->$model->find('all', array('fields' => array($model.'.id', $model.'.eng_name','Service.eng_name'), 'conditions' => array($model.'.parent_id' => $serviceId, $model.'.is_deleted' => 0)));
               foreach($subServicesTemp as $key=>$subserviceId){
				$subservicename = empty($subserviceId['SalonService']['eng_name']) ? $subserviceId['Service']['eng_name'] : $subserviceId['SalonService']['eng_name'];
				$subServices[$subserviceId['SalonService']['id']] = $subservicename;
               }
            }else{
                $subServices = $this->$model->find('list', array('fields' => array($model.'.id', $model.'.eng_name'), 'conditions' => array($model.'.parent_id' => $serviceId, $model.'.is_deleted' => 0)));    
            }
//pr($subServices);
          //  $serviceImageCount = $this->getserviceImageCount($subServices);
  
            if (!($this->request->data($imageModel))) {
                $sImage = $this->request->data['image'];
                $imageServices = $this->$imageModel->find('all', array('conditions' => array($imageModel.'.image' => $sImage)));
                $this->Service->unbindModel(array('hasMany' => 'ServiceImage'));
                $this->set(compact('serviceId','serviceImageCount', 'subServices', 'imageServices', 'sImage','serviceid','model','imageModel'));
            }
        }
         

        if ($this->request->is('post') && $this->request->data($imageModel)) {
             
             //pr($this->request->data['image']);
             //exit;  
            $countErr = false;
            $errService = array();
            foreach ($this->request->data['image'] as $key => $images) {
                $allService = array();
                $imageServices = array();
                $imagesService = str_replace('-', '.', $key);
                $imageServices = $this->$imageModel->find('all', array('conditions' => array($imageModel.'.image' => $imagesService)));
                if (!empty($subServices))
                    foreach ($imageServices as $key => $serviceIdd) {
                        $allService[] = $serviceIdd[$imageModel][$serviceid];
                    }
                $images[] = $serviceId;
                $a = array_filter($allService);
                $b = array_filter($images);
                $result = array_diff($b, $a);
                $difference = array_diff($a, $b);
                
                    if (!empty($result)) {
                            foreach ($result as $val) {
                                $newC = $this->getserviceImage($val,$imagesService);
                                if($newC<1){
                                    $arrDD = array();
                                    $arrDD[$imageModel][$serviceid] = $val;
                                    $LastOrder = $this->$order($val,$this->Auth->user('id'));
                                    $arrDD[$imageModel]['order'] = $LastOrder+1;
                                    $arrDD[$imageModel]['image'] = $imagesService;
                                    $arrDD[$imageModel]['created_by'] = $this->Auth->user('id');
                                    $this->$imageModel->create();
                                    $this->$imageModel->save($arrDD);
                                }
                              
                            }
                    }
                    
                    if (!empty($difference)) {
                       
                       foreach($difference as $newDiff){
                            $count =  $this->getserviceImageCount($newDiff);
                            if($count > 1){
                                $this->$imageModel->deleteall(array($imageModel.'.'.$serviceid => $newDiff, $imageModel.'.image' => $imagesService));    
                            }else if($count==0){
                                $arrDD = array();
                                $arrDD[$imageModel][$serviceid] = $newDiff;
                                $LastOrder = $this->$order($newDiff,$this->Auth->user('id'));
                                $arrDD[$imageModel]['order'] = $LastOrder+1;
                                $arrDD[$imageModel]['image'] = $imagesService;
                                $arrDD[$imageModel]['created_by'] = $this->Auth->user('id');
                                //$this->loadModel($imageModel);
                                $this->$imageModel->create();
                                $this->$imageModel->save($arrDD);
                                $countErr = true;
                                $errService[]= $this->Common->get_salon_service_name($newDiff);
                            }else{
                                $countErr = true;
                                $errService[]= $this->Common->get_salon_service_name($newDiff);
                             }
                            
                       }
                    }    
                
                
            }
            
            $sendData = array();
            if($countErr == true){
                $sendData['data'] = implode(',',$errService);
                $sendData['msg'] = 'e';
                echo json_encode($sendData);
                
            }else{
                $sendData['data'] = '';
                $sendData['msg'] = 's';
                echo json_encode($sendData);
            }
            exit;
        }
    }

    function getserviceImage($services = null, $image = null){
        
        $this->loadModel('SalonServiceImage');
        $conditions = array('SalonServiceImage.salon_service_id'=>$services,'SalonServiceImage.image'=>$image,'SalonServiceImage.created_by'=>$this->Auth->user('id'));
        $fields = array('SalonServiceImage.salon_service_id','SalonServiceImage.count');
        $serviceImage_data = $this->SalonServiceImage->find('count',array(
       'conditions'=>$conditions,
      ));
    return $serviceImage_data;
    }
    
    
    function getserviceImageCount($services = null){
        
                $this->loadModel('SalonServiceImage');
                $conditions = array('SalonServiceImage.salon_service_id'=>$services,'SalonServiceImage.created_by'=>$this->Auth->user('id'));
               
                $fields = array('SalonServiceImage.salon_service_id','SalonServiceImage.count');
                $this->SalonServiceImage->virtualFields['count'] = 'COUNT(`SalonServiceImage`.`salon_service_id`)';
            $serviceImage_data = $this->SalonServiceImage->find('first',array(
                'fields'=>$fields,
                'conditions'=>$conditions,
                'recursive'=>0,
                'group' => 'SalonServiceImage.salon_service_id'
            ));
            if(!empty($serviceImage_data['SalonServiceImage'])){
                return $serviceImage_data['SalonServiceImage']['count'];
            }
              return false;
    }
    
     function getserviceDeleteCount($services = null,$serviceImage = null){
        
                $this->loadModel('SalonServiceImage');
                $servicesIds = $this->SalonServiceImage->find('list',array('fields'=>array('id','salon_service_id'),'conditions'=>array('SalonServiceImage.image'=>$serviceImage,'SalonServiceImage.salon_service_id'=>$services)));
                if(empty($servicesIds)){
                    return false;
                }
                $conditions = array('SalonServiceImage.salon_service_id'=>$servicesIds,'SalonServiceImage.created_by'=>$this->Auth->user('id'));
               
                $fields = array('SalonServiceImage.salon_service_id','SalonServiceImage.count');
                $this->SalonServiceImage->virtualFields['count'] = 'COUNT(`SalonServiceImage`.`salon_service_id`)';
            $serviceImage_data = $this->SalonServiceImage->find('all',array(
                'fields'=>$fields,
                'conditions'=>$conditions,
                'recursive'=>0,
                'group' => 'SalonServiceImage.salon_service_id'
            ));
                return $serviceImage_data;
    }
    
     /**********************************************************************************    
      @Function Name : admin_select_service
      @Params	     : NULL
      @Description   : For the FrontEnd First Login Wizard for selecting the Services
      @Author        : Aman Gupta
      @Date          : 10-Jan-2015
    ********************************************************************************** */
    public function admin_select_service($addNew = null,$uid=NULL){
            $this->layout = 'ajax';
            
            if($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Service']['service_id'] = array_filter($this->request->data['Service']['service_id']);
            if(!empty($this->request->data['Service']['service_id'])){
               
                $uid =($uid)?base64_decode($uid):$this->Auth->user('id');
                foreach($this->request->data['Service']['service_id'] as $serviceId){
                    
                    $this->Service->unbindModel(array('hasMany'=>array('ServiceImage')));
                    $parentID = $this->Service->find('first',array('fields'=>array('Service.parent_id'),'conditions'=>array('Service.id'=>$serviceId)));
                    
                    $this->loadModel('SalonService');
                    
                    $this->SalonService->unbindModel(array('hasMany'=>array('ServicePricingOption','SalonServiceImage','SalonStaffService')));
                    
                    $foundSService = $this->SalonService->find('first',array('fields'=>array('SalonService.id','SalonService.parent_id'), 'conditions'=>array('SalonService.salon_id'=>$uid ,'SalonService.service_id' => $serviceId )));
                    //pr($this->request->data);die;
                    if($foundSService){
                        $this->SalonService->updateAll(array('SalonService.is_deleted' => 0 ), array('SalonService.id' => $foundSService['SalonService']['id'] ));
                        $this->SalonService->updateAll(array('SalonService.is_deleted' => 0 ), array('SalonService.id' => $foundSService['SalonService']['parent_id'] ));
                    }
                    else{
                        
                        $foundParent = $this->SalonService->find('first',array('fields'=>array('SalonService.id','SalonService.parent_id'), 'conditions'=>array('SalonService.salon_id'=>$uid ,'SalonService.service_id' => $parentID['Service']['parent_id'] )));
                        if(!empty($foundParent)){
                            $this->SalonService->updateAll(array('SalonService.status' => 1,'SalonService.is_deleted' => 0 ), array('SalonService.id' => $foundParent['SalonService']['id'] ));
                            $parentForother = $foundParent['SalonService']['id'];
                        }else{
                            $sdata['SalonService']['salon_id'] = $uid;
                            $sdata['SalonService']['service_id'] = $parentID['Service']['parent_id'];
                            $sdata['SalonService']['parent_id'] = 0;
                            $sdata['SalonService']['status'] = 1;
                            $this->SalonService->create();
                            $this->SalonService->save($sdata);
                            $parentForother  = $this->SalonService->getLastInsertId();
                        }
                        
                        if($parentForother){
                            $sdata['SalonService']['salon_id'] = $uid;
                            $sdata['SalonService']['service_id'] = $serviceId;
                            $sdata['SalonService']['parent_id'] = $parentForother;
                            $sdata['SalonService']['status'] = 0;
                            $this->SalonService->create();
                            $this->SalonService->save($sdata);
                        }
                        
                    }
                }
                $this->loadModel('User');
                $edata['data'] = 'success';
                $edata['message'] = __('Service has been saved successfully.', true);
                echo json_encode($edata);
                die;
            }
            else{
                $edata['data'] = 'error';
                $edata['message'] = __('Please select service.', true);
                echo json_encode($edata);
                die;
            }
            
            die;
        }
        $getData = $this->getServices_tree();
       
        if($addNew){
            $getSelected = 
            $this->set(compact('addNew'));
        }
        $this->set(compact('getData','uid'));
    }
    
    public function admin_selectdeal_service(){
         $this->loadModel('SalonService');
        $Salonservices = $this->SalonService->find('threaded', array('conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' =>1, 'SalonService.salon_id' => $this->Auth->user('id')), 'order' => array('SalonService.service_order')));
       // pr($Salonservices);
        $this->set(compact('Salonservices'));
    }
    
    public function admin_selectdeal_package($type= null){
       
        $this->layout = 'ajax';
        $this->loadModel('Package');
        $salonPackage = $this->Package->find('threaded', array('conditions' => array('Package.type' => $type,'Package.is_deleted' => 0,'Package.status' =>1, 'Package.user_id' => $this->Auth->user('id')), 'order' => array('Package.id'),'recursive'=>-1));
        //pr($salonPackage);
        $this->set(compact('salonPackage','type'));
    }
    
    
   
    public function admin_selectpackage_service($ID=null,$selectFor='PackageService'){
        $this->loadModel('SalonService');
        $this->loadModel($selectFor);
        $parent_id = 'package_id';
        if($selectFor=='SpadayService'){
            $parent_id = 'spaday_id';
        }
       
        $this->SalonService->recursive =-1;
        $sdata  =   array();
        if($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['SalonService']['salon_service_id'] = array_filter($this->request->data['SalonService']['salon_service_id']);
              if(!empty($this->request->data['SalonService']['salon_service_id'])){
              
                if(count($this->request->data['SalonService']['salon_service_id']) >= 2){
                  $serviceExist = $this->checkPackageService($ID,$selectFor);
                  $flipedArray = array_flip($serviceExist);
                foreach($this->request->data['SalonService']['salon_service_id'] as $serviceId){
                    if(!empty($serviceExist)&&in_array($serviceId,$serviceExist)){
                        unset($flipedArray[$serviceId]);
                    }else{
                        
                        $sdata[$selectFor][$parent_id] = $ID;
                        $sdata[$selectFor]['salon_service_id'] = $serviceId;
                        $this->$selectFor->saveAll($sdata);
                    }
               }
               $serviceExist = array_flip($flipedArray);
               $this->$selectFor->deleteAll(array($selectFor.'.salon_service_id'=>$serviceExist));
               $edata['data'] = 'success';
               $edata['message'] = __('Treatments have been added successfully.', true);
               echo json_encode($edata);
               die;
               
        }else{
                $edata['message'] = __('Please select atleast two service', true);
                echo json_encode($edata);
                die;
              }
        }else{
           
                $edata['message'] = __('Please select a service', true);
                echo json_encode($edata);
                die;
        }
              
        }
        $Salonservices = $this->SalonService->find('threaded', array('conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' =>1, 'SalonService.salon_id' => $this->Auth->user('id')), 'order' => array('SalonService.service_order')));
        $this->set(compact('Salonservices','ID'));
    }
    
   public function checkPackageService($ID =null,$selectFor=null){
    
       $this->loadModel($selectFor);
       $parent_id = 'package_id';
        if($selectFor=='SpadayService'){
            $parent_id = 'spaday_id';
        }
      return $this->$selectFor->find('list',array('fields'=>array($selectFor.'.salon_service_id'),'conditions'=>array($selectFor.'.'.$parent_id=>$ID)));
       
   }
    
    /**********************************************************************************    
      @Function Name : admin_set_priceduration
      @Params	     : NULL
      @Description   : Set price and duration for the Service
      @Author        : Aman Gupta   
      @Date          : 07-Feb-2015
    ***********************************************************************************/
    
    public function admin_set_priceduration() {
        $this->layout = 'ajax';
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->loadModel('SalonServiceDetail');
            $this->loadModel('ServicePricingOption');
            $this->loadModel('SalonStaffService');
            
             
            if($this->request->data){
                //pr($this->request->data);
                //exit;
            foreach($this->request->data['SalonServiceDetail']['onlinebooking'] as $key=>$val){
                $slnSvrDtl = array();
                $slnSvrDtl['SalonServiceDetail']['associated_id'] = $key;
                $slnSvrDtl['SalonServiceDetail']['associated_type'] = 1;
                $slnSvrDtl['SalonServiceDetail']['sold_as'] = 0;    
                if( $val && !$this->request->data['SalonServiceDetail']['evoucher'][$key] ){
                    $slnSvrDtl['SalonServiceDetail']['sold_as'] = 1;    
                }
                if( !$val && $this->request->data['SalonServiceDetail']['evoucher'][$key] ){
                    $slnSvrDtl['SalonServiceDetail']['sold_as'] = 2;    
                }
                $this->SalonServiceDetail->create();
                $this->SalonServiceDetail->save($slnSvrDtl);
            }
            
            foreach($this->request->data['ServicePricingOption']['duration'] as $sKey=>$tVal){
                $thePrOpt = array();
                $thePrOpt['ServicePricingOption']['salon_service_id'] = $sKey;
                $thePrOpt['ServicePricingOption']['user_id']        = $this->Auth->user('id');
                $thePrOpt['ServicePricingOption']['pricing_level_id'] = 0;
                $thePrOpt['ServicePricingOption']['duration'] = $tVal;
                $thePrOpt['ServicePricingOption']['full_price'] = $this->request->data['ServicePricingOption']['full_price'][$sKey];
                $this->ServicePricingOption->create();
                $this->ServicePricingOption->save($thePrOpt);
            }
            
            foreach($this->request->data['SalonStaffService'] as $serKey=>$uData){
                $uData = array_filter($uData);
                if(!empty($uData)){
                    $slnstfsrvic = array();
                    foreach($uData as $userId){
                        $slnstfsrvic['SalonStaffService']['salon_service_id'] = $serKey;
                        $slnstfsrvic['SalonStaffService']['staff_id'] = $userId;
                        $slnstfsrvic['SalonStaffService']['status'] = 1;
                        $this->SalonStaffService->create();
                        $this->SalonStaffService->save($slnstfsrvic);
                    }
                }
            }
            }
            
            $edata['data'] = 'success';
            $edata['message'] = __(' Treatment settings have been saved successfully.',true);
            echo json_encode($edata);
            die;
            
        }
        
        $this->loadModel('SalonService');
        $this->loadModel('Service');$this->loadModel('User');
        $this->Service->unbindModel(array('hasMany'=>array('ServiceImage')));
        $this->SalonService->bindModel(array('belongsTo' => array('Service')));
        //$this->SalonService->recursive = 2;
        $services = $this->SalonService->find('threaded', array('conditions' => array('SalonService.is_deleted' => 0, 'SalonService.salon_id' => $this->Auth->user('id')), 'order' => array('SalonService.service_order')));
        
        $this->User->unbindModel(array('hasOne'=>array('Contact','PricingLevelAssigntoStaff','Address','Salon'),'belongsTo'=>array('Group')));
        $staffList = $this->User->find('all',array('conditions'=>array('User.parent_id'=>$this->Auth->user('id'),'User.is_deleted'=>0,'User.type'=>5,'UserDetail.employee_type'=>2),'order' => array('User.id DESC')));
        $this->set(compact('services','staffList'));
        
    }

    /*     * ********************************************************************************    
      @Function Name : admin_newupload
      @Params	 : NULL
      @Description   : Multiple Image uploads
      @Author        : Shibu Kumar
      @Date          : 23-Dec-2014
     * ********************************************************************************* */

    public function admin_newupload($uid = NULL) {

        $this->layout = 'ajax';
        $this->loadModel('SalonService');
        if ($this->request->is('ajax') && $this->request->is('post')) {
            if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                list($width, $height, $type, $attr) = getimagesize($_FILES['image']["tmp_name"]);
                
            if($width >= 800 && $height >= 400){
                
                    $userId = $this->Auth->user('id');
                    if($width == 800 && $height == 400) {
                         $retrun = $this->Image->upload_image($_FILES['image'], 'Service', $userId, false);
                    }else if($width >= 800 && $height >= 400){
                         $ratio = ($width / $height);
                       if($ratio == 2){
                             $retrun = $this->Image->upload_service_image($_FILES['image'], 'Service', $userId, false);               }else{
                            echo 'resize-error';
                            exit;
                       }
                    }
                   
                    if($userId==1){
                        $model="Service";
                        $serviceid = "service_id";
                        $imageModel = "ServiceImage";
                        $ordering = "checklastServiceOrder";
                    }else{
                        $model="SalonService";
                        $serviceid = "salon_service_id";
                        $imageModel = "SalonServiceImage";
                        $ordering = "checklastSalonServiceOrder";
                    }

                    
                    if ($retrun) {
                        $this->loadModel('ServiceImage');
                         $this->loadModel('SalonServiceImage');
                        $srvD[0][$model.'Image'][$serviceid] = $this->request->data['serviceId'];
                        $srvD[0][$model.'Image']['image'] = $retrun;
                        $srvD[0][$model.'Image']['created_by'] = $userId;
                        $LastOrder = '';
                        $LastOrder = $this->$ordering($this->request->data['serviceId'],$userId);
                        $srvD[0][$model.'Image']['order'] = $LastOrder+1;
                        $i = 1;
                        $LastOrder='';
                        if (!empty($this->request->data['associatedImg'])) {
                            foreach ($this->request->data['associatedImg'] as $associatedImagesId) {
                                $srvD[$i][$model.'Image'][$serviceid] = $associatedImagesId;
                                $srvD[$i][$model.'Image']['image'] = $retrun;
                                $srvD[$i][$model.'Image']['created_by'] = $userId;
                                $LastOrder = $this->$ordering($associatedImagesId,$userId);
                                $srvD[$i][$model.'Image']['order'] = $LastOrder+1;
                                $i++;
                            }
                        }
                        
                        $this->$imageModel->create();
                        if ($this->$imageModel->saveAll($srvD)) {
                            $edata['msg'] = 'success';
                            $edata['iDs'] = $this->request->data['associatedImg'];
                            $edata['image'] = $retrun;
                            echo json_encode($edata);
                            die;
                        }
                    }
                
            }else{
                echo 'dimension_error_800_400';
                die;
            }
            }
        }
        

    
        if($this->Auth->user('type')==1){
            $subServices = $this->Service->find('list', array('fields' => array('Service.id', 'Service.eng_name'), 'conditions' => array('Service.parent_id' => $uid, 'Service.status' => 1, 'Service.is_deleted' => 0)));
        }else{
             $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
             $this->SalonService->recursive = 1;
             $subServices = $this->SalonService->find('all', array('fields' => array('SalonService.id', 'SalonService.eng_name','Service.eng_name'), 'conditions' => array('SalonService.parent_id' => $uid,  'SalonService.is_deleted' => 0,'SalonService.status !='=>2)));
             }
       
        $this->set(compact('subServices'));
        $this->set('serviceID', $uid);
    }

    /*     * ********************************************************************************    
      @Function Name : admin_makeFeatured
      @Params	 : NULL
      @Description   : Make Featured image for Service
      @Author        : Shibu Kumar
      @Date          : 24-Dec-2014
     * ********************************************************************************* */

    public function admin_makeFeatured($serviceId = NULL){
        $this->layout = 'ajax';
        if($this->Auth->user('id')==1){
            $imageModel = 'ServiceImage';
            $model = 'Service';
            $serviceid = 'service_id';
            $order = 'checklastServiceOrder';
        }else{
            $imageModel = 'SalonServiceImage';
            $model = 'SalonService';
            $serviceid='salon_service_id';
            $order = 'checklastSalonServiceOrder';
        }
        $this->loadModel($imageModel);
        $this->loadModel($model);
        $sImage = isset($this->request->data['image']) ? $this->request->data['image'] : '';
        if (($serviceId) && (!empty($sImage))) {
            if($model == "SalonService"){
                $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
                $this->SalonService->recursive = 1;
                $subServicesTemp = $this->$model->find('all', array('fields' => array($model.'.id', $model.'.eng_name','Service.eng_name'), 'conditions' => array($model.'.parent_id' => $serviceId, $model.'.is_deleted' => 0)));
               foreach($subServicesTemp as $key=>$subserviceId){
				$subservicename = empty($subserviceId['SalonService']['eng_name']) ? $subserviceId['Service']['eng_name'] : $subserviceId['SalonService']['eng_name'];
				$subServices[$subserviceId['SalonService']['id']] = $subservicename;
               }
            }else{
                $subServices = $this->$model->find('list', array('fields' => array($model.'.id', $model.'.eng_name'), 'conditions' => array($model.'.parent_id' => $serviceId, $model.'.is_deleted' => 0)));    
            }
            
            $imageServices = $this->$imageModel->find('all', array('conditions' => array($imageModel.'.image' => $sImage)));
            $this->set(compact('serviceId', 'imageServices', 'subServices', 'sImage','serviceid','imageModel'));
        }
        
        
        if ($this->request->is('post') && $this->request->data($imageModel)) {
            $serviceId = $this->request->data[$imageModel][$serviceid];
            $imageId = str_replace('-', '.', $this->request->data[$imageModel]['image_id']);
            $subServiceId = $this->request->data[$imageModel]['subService'];
            if(!empty($subServiceId)){
                foreach($subServiceId as $serviceId){
                    if($serviceId !=''){
                         $imageServiceOrder = $this->$imageModel->find('first', array('fields'=>array('order'),'conditions' => array($imageModel.'.image' => $imageId, $imageModel.'.'.$serviceid => $serviceId, $imageModel.'.created_by' =>$this->Auth->user('id'))));
                   
                    $imageFeaturedServiceOrder = $this->$imageModel->updateAll(array($imageModel.'.order' => $imageServiceOrder[$imageModel]['order'],$imageModel.'.created_by' =>$this->Auth->user('id')),array($imageModel.'.order' => 0,$imageModel.'.'.$serviceid => $serviceId));
                   
                    $this->$imageModel->updateAll(array($imageModel.'.order' => 0), array($imageModel.'.image' => $imageId, $imageModel.'.'.$serviceid => $serviceId));
                    }else{
                        echo 'e';
                        exit;
                    }
                }
                echo 's';
                exit;
            }
        }
    }

/**********************************************************************************    
 @Function Name : admin_cropnsave
 @Params	 : NULL
 @Description   : function use for crop image
 @Author        : Shibu Kumar
 @Date          : 24-Dec-2014
********************************************************************************** */
    
    public function admin_cropnsave($treatment = null, $image = null) {
        $this->layout = 'ajax';
        if ($this->request->data) {
            if ($this->request->is('post') || $this->request->is('put')) {
                $jpeg_quality = Configure::read('Config.jpegQuality');
                 $x = $this->data['cropnsave']['x'];
                 $y = $this->data['cropnsave']['y'];
                 $width = $this->data['cropnsave']['w'];
                 $height = $this->data['cropnsave']['h'];
                 $x1 = $this->data['cropnsave']['w'];
                 $y1 = $this->data['cropnsave']['h'];
                //$name = $user['UserPublisherDetail']['image'];
                $destinationPath = WWW_ROOT . "images/Service/150/";
                //$r1 = $destinationPath.$user['UserPublisherDetail']['image'];
                $r1 = WWW_ROOT . "images/Service/500/" . $image;
                $ext = trim($this->returnExtentsion($r1));
                $name = $image;
                if ($ext == "png" || $ext == "PNG") {
                    $src = imagecreatefrompng($r1);
                } else if ($ext == "GIF" || $ext == "gif") {
                    $src = imagecreatefromgif($r1);
                } else {
                    $src = imagecreatefromjpeg($r1);
                }
               
                if($width != '' && $height != ''){
                    $src1 = imagecreatetruecolor($width, $height);
                    imagecopy($src1, $src, 0, 0, $x, $y, $width, $height);
                    if ($ext == "png" || $ext == "PNG") {
                        imagepng($src1, $destinationPath . $name, 9);
                    } else if ($ext == "GIF" || $ext == "gif") {
                        imagegif($src1, $destinationPath . $name);
                    } else {
                        imagejpeg($src1, $destinationPath . $name, 75);
                    }
                    echo 's';
                    exit;
                }else{
                    echo 'n';
                    exit;
                }
            }
        }
        $this->set(compact('image'));
    }

    
    /*     * ********************************************************************************    
      @Function Name : returnExtentsion
      @Params	 : NULL
      @Description   : function use for return extension
      @Author        : Shibu Kumar
      @Date          : 24-Dec-2014
     * ********************************************************************************* */
    
    
    public function returnExtentsion($str) {
        $pos = strrpos($str, ".");
        if (!$pos) {
            return "";
        }
        $l = strlen($str) - $pos;
        $ext = substr($str, $pos + 1, $l);
        return $ext;
    }
    
    public function checklastServiceOrder($serviceId = null,$userId = null){
         $this->loadModel('ServiceImage');
         $imageServices = $this->ServiceImage->find('first', array('fields'=>array('MAX(ServiceImage.order) AS maxorder'),'conditions' => array('ServiceImage.service_id' => $serviceId,'ServiceImage.created_by' =>$userId)));
        
    return $imageServices[0]['maxorder'];

    }
    
     public function checklastSalonServiceOrder($serviceId = null,$userId = null){
         $this->loadModel('SalonServiceImage');
         $imageServices = $this->SalonServiceImage->find('first', array('fields'=>array('MAX(SalonServiceImage.order) AS maxorder'),'conditions' => array('SalonServiceImage.salon_service_id' => $serviceId,'SalonServiceImage.created_by' =>$userId)));
        
    return $imageServices[0]['maxorder'];

    }
    
    public function admin_chk_status($id) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->loadModel('Service');
            if ($this->request->is('ajax')) {
                $service = $this->Service->find('first',array(
                    'fields' =>array(
                        'Service.id , Service.status'                 
                    ),
                    'conditions' => array(
                        'Service.id' => $id
                        
                    )                                       
                ));
                echo $service['Service']['status'];
                exit;
            }
    }
    
    
    public function update(){
        $this->loadModel('SalonService');
        //$this->Service->recursive = -1;
        /*$services = $this->Service->find('all',array(
                        'conditions'=>array('Service.parent_id'=>0),
                        'fields'=>array('Service.id','Service.eng_name','Service.parent_id')
                        ));
        
        if(!empty($services)){
            foreach($services as $service){
                $slug = '';
                $savetag['Service']['id'] = $service['Service']['id'];
                $tag_name = str_replace(' ','-',trim($service['Service']['eng_name']));
                $slug = $tag_name.'-'.$service['Service']['id'];
                $savetag['Service']['slug'] = $slug;
                
                
                $this->Service->set($savetag);
                $this->Service->save($savetag);
                
                $cat_services = $this->Service->find('all',array(
                        'conditions'=>array('Service.parent_id'=>$service['Service']['id']),
                        'fields'=>array('Service.id','Service.eng_name','Service.parent_id')
                        ));
                
                if(!empty($cat_services)){
                    foreach($cat_services as $cat_service){
                        
                        $cat_slug = '';
                        $save_cat['Service']['id'] = $cat_service['Service']['id'];
                        
                        $cat_name = str_replace(' ','-',trim($cat_service['Service']['eng_name']));
                        $cat_slug = $cat_name.'-'.$cat_service['Service']['id'];
                        
                        $save_cat['Service']['slug'] = $cat_slug;
                      
                        $this->Service->set($save_cat);
                        $this->Service->save($save_cat);
                        
                        $trt_services = $this->Service->find('all',array(
                                'conditions'=>array('Service.parent_id'=>$cat_service['Service']['id']),
                                'fields'=>array('Service.id','Service.eng_name','Service.parent_id')
                                ));
                        
                        if(!empty($trt_services)){
                            foreach($trt_services as $trt_service){
                                $trt_slug = '';
                                $save_trt['Service']['id'] = $trt_service['Service']['id'];
                                
                                $trt_name = str_replace(' ','-',trim($trt_service['Service']['eng_name']));
                                $trt_slug = $cat_name.'-'.$trt_name.'-'.$trt_service['Service']['id'];
                                
                                $save_trt['Service']['slug'] = $trt_slug;
                                
                                $this->Service->set($save_trt);
                                $this->Service->save($save_trt);
                            }
                        }
                        
                    }
                }
            }
        }
        */
        //pr($services); echo '<hr>';
        
        
        //$this->SalonService->recursive = -1;
        
        $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
        $salon_services = $this->SalonService->find('all',array('fields'=>array('SalonService.id','SalonService.status','SalonService.service_id','SalonService.eng_name','Service.id','Service.slug'),
                                                                'conditions'=>array('SalonService.parent_id!=0')
                                                                ));
        pr($salon_services);
        die;
    }
    
}
