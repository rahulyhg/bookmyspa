<?php
class SalonServicesController extends AppController {

    public $helpers = array('Session', 'Html', 'Form','Common'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Image'); //An array containing the names of components this controller uses.
  var $uses = array('SalonService','SalonStaffService','SalonServiceImage','ServicePricingOption','Package');
    /**********************************************************************************    
      @Function Name    : admin_change_status
      @Params	        : NULL
      @Description      : The Function is for changing the Status of Salon Service
      @Author           : Aman Gupta
      @Date             : 29-Jan-2015
    ***********************************************************************************/
    public function admin_change_status() {
        $this->autoRender = false;
        if($this->request->is('post') || $this->request->is('put')){
            if($this->request->data['status']==0){
                $this->SalonService->updateAll(array('SalonService.status'=>$this->request->data['status']),array('SalonService.id'=>$this->request->data['id']));
                echo $this->request->data['status'];
            }else{
                if($this->Common->check_pricing($this->request->data['id'],$this->Auth->user('id'))){
                    if($this->Common->salonServiceImage($this->request->data['id'],$this->Auth->user('id'))){
                         if($this->Common->check_service_detail($this->request->data['id'])){
                             if($this->SalonService->updateAll(array('SalonService.status'=>$this->request->data['status']),array('SalonService.id'=>$this->request->data['id']))){
                                 echo  $this->request->data['status'];
                             }
                         }else{
                            echo "detail_not_set";
                         }
                    }else{
                      echo "image_not_set";
                }
            }else{
                echo "price_not_set";
            }
                
            }
           
        }
        die;
    }
    
   public function admin_change_spabreak_status() {
        $this->autoRender = false;
        $this->loadModel('Spabreak');
        if($this->request->is('post') || $this->request->is('put')){
           
                if($this->Spabreak->updateAll(array('Spabreak.status'=>$this->request->data['status']),array('Spabreak.id'=>$this->request->data['id']))){
                    echo  $this->request->data['status'];
                }else{
                echo "";
            }
        }
        die;
    }
    
    
    
    /**********************************************************************************    
      @Function Name    : admin_isdelete
      @Params	        : NULL
      @Description      : The Function is for make deleted the Salon Service
      @Author           : Aman Gupta
      @Date             : 29-Jan-2015
    ***********************************************************************************/
    public function admin_isdelete() {
        $this->autoRender = false;
        if($this->request->is('post') || $this->request->is('put')){
           echo $this->admin_deleteAssociated_records($this->request->data['id']);
        }
        die;
    }
    
    public function admin_deleteAssociated_records($serviceId = null){
        $getRecords = $this->SalonService->find('list',array('conditions'=>array('SalonService.parent_id'=>$serviceId,'SalonService.is_deleted'=>0)));
        array_push($getRecords,$serviceId);
        foreach($getRecords as $service){
            $hasPermission = $this->Common->checkDeletePermission($service);
            if($hasPermission != 'true'){
                return $hasPermission;
            }
        }
        //die('herere');
        if($hasPermission == 'true'){
           if($this->SalonService->updateAll(array('SalonService.is_deleted'=>1),array('SalonService.id'=>$getRecords))){
               //'SalonStaffService','SalonServiceImage','ServicePricingOption'
               $this->SalonStaffService->deleteAll(array('SalonStaffService.salon_service_id'=>$getRecords));
               $this->SalonServiceImage->deleteAll(array('SalonServiceImage.salon_service_id'=>$getRecords));
               $this->ServicePricingOption->deleteAll(array('ServicePricingOption.salon_service_id'=>$getRecords));
               $this->loadModel('SalonServiceDetail');
               $this->SalonServiceDetail->unbindModel(array('belongsTo'=>'SalonService'));
               $getid = $this->SalonServiceDetail->find('first',array('conditions'=>array('SalonServiceDetail.associated_id'=>$getRecords,'SalonServiceDetail.associated_type'=>1)));
               if($getid){
                    $this->SalonServiceDetail->delete($getid['SalonServiceDetail']['id']); 
               }
               return 'success';
            }else{
                return 'unable_to_delete';
            }
        }
    }
    
      /**********************************************************************************    
      @Function Name    : admin_delete_pricingoption
      @Params	        : NULL
      @Description      : The Function is for Deleting the Pricing Option
      @Author           : Aman Gupta
      @Date             : 29-Jan-2015
    ***********************************************************************************/
    public function admin_delete_pricingoption($model='ServicePricingOption'){
        $this->autoRender = false;
        $this->loadModel($model);
        if($this->request->is('post') || $this->request->is('put')){
           
            if($this->$model->updateAll(array($model.'.is_deleted'=>1),array($model.'.id'=>$this->request->data['id']))){
                $edata['data'] = 'success';
                $edata['message'] = __('Pricing option has been deleted successfully.', true);
                echo json_encode($edata);
                die;
            }else{
                $edata['data'] = 'error';
                $edata['message'] = __('unable_to_save', true);
                echo json_encode($edata);
                die;
            }
        }
        die;
    }
    
   
    /**********************************************************************************    
      @Function Name    : admin_edit_service
      @Params	        : NULL
      @Description      : The Edit Service Dispaly Name
      @Author           : Aman Gupta
      @Date             : 29-Jan-2015
    ***********************************************************************************/
    public function admin_edit_service($id = NULL) {
        $this->layout = 'ajax';
        $this->set('Type','Add');
        if($this->request->is('post') || $this->request->is('put')){
            if(empty($this->request->data['SalonService']['id'])){
                $this->SalonService->create();
                 $this->request->data['SalonService']['status'] = 1;
            }
            if(!$id){
                $this->request->data['SalonService']['service_id'] = 0;
                $this->request->data['SalonService']['salon_id'] = $this->Auth->User('id');
            }
            
            if($this->SalonService->save($this->request->data)){
                $edata['data'] = 'success';
                $edata['message'] = "Category has been saved successfully.";
                echo json_encode($edata);
                die;
            }
            else{
                $errorD = $this->SalonService->validationErrors;
                $edata['data'] = $errorD;
                $edata['message'] = __('unable_to_save', true);
                echo json_encode($edata);
                die;
            }
        }
        
        $this->set('serviceType','SalonService');
        if($id){
            $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
            $data = $this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$id)));
            if(!$this->request->data){
                $this->request->data = $data;
                $this->set('parentService',$data);
            }
            if(isset($data['Service']['eng_name']) && !empty($data['Service']['eng_name']) ){
                $this->set('serviceType','Service');
            }
            $this->set('Type','Edit');
        }

    }
    
    /**********************************************************************************    
      @Function Name    : admin_services
      @Params	        : NULL
      @Description      : The list the Vendors Services via AJAX
      @Author           : Aman Gupta
      @Date             : 29-Jan-2015
    ***********************************************************************************/
    public function admin_services() {
        $this->layout = 'ajax';
        $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
        $this->SalonService->recursive = 2;
        $services = $this->SalonService->find('threaded',array('conditions'=>array('SalonService.is_deleted'=>0,'SalonService.salon_id'=>$this->Auth->user('id')),'order'=>array('SalonService.service_order')));
        $this->set(compact('services'));
        $this->viewPath = 'Elements/admin/Business';
        $this->render('list_service');
    }
    
    /**********************************************************************************    
      @Function Name    : admin_edit_treatment
      @Params	        : NULL
      @Description      : The editing and adding Vendors the treatment
      @Author           : Aman Gupta
      @Date             : 30-Jan-2015
    ***********************************************************************************/
    public function admin_edit_treatment($parent_id = null,$id=null,$cat_parent_id=null) {
            $this->layout = 'ajax';
            $this->set('treatmentType','Edit'); 
            if($this->request->data){
                $serviceimage = array_filter($this->request->data['SalonService']['serviceimage']);
                unset($this->request->data['SalonService']['serviceimage']);
                //pr($this->request->data);
                //exit;
                $this->request->data['SalonServiceDetail']['offer_available_weekdays'] = serialize($this->request->data['SalonServiceDetail']['offer_available_weekdays']);
                $this->request->data['SalonServiceDetail']['associated_id'] = $this->request->data['SalonService']['id'];
                $this->request->data['SalonServiceDetail']['associated_type'] = 1; 
                if(isset($this->request->data['ServicePricingOption'])){
                     $PricingOptionData = $this->request->data['ServicePricingOption'];
                     unset($this->request->data['ServicePricingOption']);
                     $this->request->data['ServicePricingOption'][0] = $PricingOptionData;
                     $this->request->data['ServicePricingOption'][0]['user_id'] = $this->Auth->User('id');
                 }
                 
                 //pr( $this->request->data['SalonServiceDetail']);
                 // IF image is not set for Service Set Status -> Deactivate otherwise Activate
                 
                  if($this->Common->salonServiceImage($this->request->data['SalonService']['id'],$this->Auth->User('id')) || !empty($serviceimage)){
                        $this->request->data['SalonService']['status'] = 1;       
                    }else{
                        $this->request->data['SalonService']['status'] = 0;       
                    }
                  // pr($this->request->data);
                  // exit;
                  unset($this->request->data['Service']);
                  $this->SalonService->unbindModel(array('belongsTo'=>'Service'));
                 if ($this->SalonService->saveAll($this->request->data)) {
                    $serviceId = $this->SalonService->id;
                    $resourceArr=array();
                    // For Adding Resource
                    if(!empty($this->request->data['SalonService']['salon_room_id'])){
                        $this->loadModel('SalonServiceResource');
                        foreach($this->request->data['SalonService']['salon_room_id'] as $resourceKey=>$resource){
                             $resourceList = $this->SalonServiceResource->find('first',array('conditions'=>array('SalonServiceResource.salon_service_id' => $serviceId,'SalonServiceResource.salon_room_id'=>$resource)));
                             if(!$resourceList){
                                $resourceArr['SalonServiceResource']['salon_service_id'] = $serviceId;
                                $resourceArr['SalonServiceResource']['salon_room_id'] = $resource;
                                $this->SalonServiceResource->create();
                                $this->SalonServiceResource->save($resourceArr);
                             }
                        }
                        $this->SalonServiceResource->deleteAll(array('SalonServiceResource.salon_service_id' => $serviceId,'NOT'=>array('SalonServiceResource.salon_room_id'=>$this->request->data['SalonService']['salon_room_id'])));
                    }
                    // For Adding Images
                    if(!empty($serviceimage)){
                        $this->loadModel('SalonServiceImage');
                        $imageList = $this->SalonServiceImage->find('list',array('conditions'=>array('SalonServiceImage.salon_service_id' => $serviceId,'SalonServiceImage.created_by'=>$this->Auth->user('id')),'fields'=>array('SalonServiceImage.image')));
                        $this->SalonServiceImage->deleteAll(array('SalonServiceImage.salon_service_id' => $serviceId,'SalonServiceImage.created_by'=>$this->Auth->user('id')));
                        foreach($serviceimage as $key=>$theImage){
                            $imgData = array();
                            $imgData['SalonServiceImage']['salon_service_id'] = $serviceId;
                            $imgData['SalonServiceImage']['image'] = $theImage;
                            $imgData['SalonServiceImage']['order'] = $key;
                            $imgData['SalonServiceImage']['created_by'] = $this->Auth->user('id');
                            $this->SalonServiceImage->create();
                            $this->SalonServiceImage->save($imgData);
                        }
                        if(!empty($imageList)){
                            $nonImg = array_diff($imageList, $serviceimage);
                            if(!empty($nonImg)){
                                foreach($nonImg as $thedImage){
                                    //$this->Image->delete_image($thedImage, 'Service', $this->Auth->user('id'), false);
                                }
                            }
                        }
                       // $this->deleteImageTemp();
                        $this->loadModel('TempImage');
                         $this->TempImage->deleteAll(array('TempImage.path' => 'SalonService','TempImage.user_id' => $this->Auth->user('id'),'TempImage.parent_id' => $this->request->data['SalonService']['parent_id']));
                }
                     $edata['data'] = 'success';
                     $edata['message'] = __('Treatment has been added successfully.', true);
                    echo json_encode($edata);
                    die;
                }else{
                    $errorD = $this->SalonService->validationErrors;
                    $edata['data'] = $errorD;
                    $edata['message'] = __('unable_to_save', true);
                    echo json_encode($edata);
                    die;
                    //pr($this->SalonService->validationErrors);
                   // exit;
            }
         }
         
            if((!$id)||($id =='null')){
                   //$this->request->data['SalonService']['parent_id'] = $parent_id;
                   $dataService['SalonService']['salon_id'] = $this->Auth->User('id');
                   $dataService['SalonService']['parent_id'] = $cat_parent_id;
                   $dataService['SalonService']['status'] = 2;
                   $this->SalonService->saveAll($dataService,array('fieldset'=>array('salon_id','parent_id','status')));
                   $this->SalonService->bindModel(array('belongsTo'=>array('Service'),'hasMany'=>array('ServicePricingOption'=>array('conditions'=>array('ServicePricingOption.is_deleted'=>0)))));
                   $data = $this->SalonService->find('first',array('contain'=>array('Service','SalonServiceDetail','SalonStaffService','SalonServiceResource','ServicePricingOption','SalonServiceImage'=>array('conditions'=>array('SalonServiceImage.created_by'=>$this->Auth->user('id')))),'conditions'=>array('SalonService.id'=> $this->SalonService->id)));
                   $this->set('serviceId',$this->SalonService->id);
                   $this->set('treatmentType','Add'); 

            }else{
                $this->SalonService->bindModel(array('belongsTo'=>array('Service'),'hasMany'=>array('ServicePricingOption'=>array('conditions'=>array('ServicePricingOption.is_deleted'=>0)))));
                $data = $this->SalonService->find('first',array('contain'=>array('Service','SalonServiceDetail','SalonStaffService','SalonServiceResource','ServicePricingOption','SalonServiceImage'=>array('conditions'=>array('SalonServiceImage.created_by'=>$this->Auth->user('id')))),'conditions'=>array('SalonService.id'=>$id),'group'=>'SalonService.id'));
                $data['SalonServiceDetail']['offer_available_weekdays'] = unserialize($data['SalonServiceDetail']['offer_available_weekdays']);
                $this->set('serviceId',$id);
             }
            
          
            if(!$this->request->data){
                $this->request->data = $data;
            }
            
            $pricing_ids = $this->Common->get_service_pricing_levels($id,$this->Auth->User('id'));
            $pricingIds = array();
            if(!empty($pricing_ids)){
                foreach($pricing_ids as $pricingID){
                   $pricingIds[]=  $pricingID["ServicePricingOption"]["pricing_level_id"];
                }
            }
            
            $this->set('salonservice',$data);
            $SalonStaff = $this->Common->get_salon_staff($this->Auth->user('id'));
       
            $levelStaffIds = array();
            // check if a new staff is added in database for  pricing level associated with service
            if(!empty($SalonStaff) && !empty($pricingIds)){
                foreach($SalonStaff as $SalonStaffiD){
                    if(!empty($SalonStaffiD["PricingLevelAssigntoStaff"])){
                            if(in_array($SalonStaffiD["PricingLevelAssigntoStaff"][0]["pricing_level_id"],$pricingIds) || in_array(0,$pricingIds)){
                          $levelStaffIds[] = $SalonStaffiD["User"]["id"];
                       }
                    }
                   
                }
            }
            $defaultLeadtime = $this->Common->getDefaultLeadTime($this->Auth->user('id'),'service',array("lead_time"));
            $this->set(compact('levelStaffIds','defaultLeadtime'));
            $this->set(compact('SalonStaff'));
            $this->set('parent_id',$parent_id);
        
    }
    
    /**********************************************************************************    
      @Function Name    : admin_addeEdit_package
      @Params	        : NULL
      @Description      : The editing and adding Packages
      @Author           : Shibu Kumar
      @Date             : 25-Feb-2015
    ***********************************************************************************/
   function admin_addedit_package($id=null,$pkgType = 'package'){
        $this->loadModel('Package');
        $this->set('Type','Add');
        $this->set(compact('pkgType'));
        if($this->request->data){
            $this->request->data['SalonServiceDetail']['offer_available_weekdays'] = serialize($this->request->data['SalonServiceDetail']['offer_available_weekdays']);
            $this->request->data['SalonServiceDetail']['associated_id'] = $this->request->data['Package']['id'];
            $this->request->data['SalonServiceDetail']['associated_type'] = 2; 
            $this->request->data['Package']['status'] = 1;
            if($this->request->data['SalonServiceDetail']['listed_online']== 1){
                $this->request->data['SalonServiceDetail']['listed_online_end'] = '';
            }else if($this->request->data['SalonServiceDetail']['listed_online']== 2){
                 $this->request->data['SalonServiceDetail']['listed_online_start'] = '';
            }else if($this->request->data['SalonServiceDetail']['listed_online']== 0){
                 $this->request->data['SalonServiceDetail']['listed_online_start'] = '';
                 $this->request->data['SalonServiceDetail']['listed_online_end'] = '';
            }
            //pr($this->request->data);
           if ($this->Package->saveAll($this->request->data,array('deep' => true))) {
                $edata['data'] = 'success';
                $edata['message'] = __('Package has been saved successfully.', true);
                echo json_encode($edata);
                die;
             }else{
                $errorD = $this->Package->validationErrors;
                $edata['data'] = $errorD;
                $edata['message'] = __('unable_to_save', true);
                echo json_encode($edata);
                die;
             }
        }
            $SalonStaff = $this->Common->get_salon_staff($this->Auth->user('id'));
            $this->set(compact('SalonStaff'));
            $this->Package->recursive= 2;
            if($id){
                $data = $this->Package->find('first',array('conditions'=>array('Package.id'=> $id)));
                //pr($data);
                //exit;
                $data['SalonServiceDetail']['offer_available_weekdays'] = unserialize($data['SalonServiceDetail']['offer_available_weekdays']);
                if(!$this->request->data){
                    $this->request->data =  $data;
                    $this->set('package',$data);      
                }
                $this->set('Type','Edit');
            }else{
                $dataService['Package']['user_id'] = $this->Auth->User('id');
                $dataService['Package']['status'] = 2;
                $this->Package->saveAll($dataService,array('fieldset'=>array('user_id','status')));
                $data = $this->Package->find('first',array('conditions'=>array('Package.id'=>$this->Package->id)));
                $this->request->data =  $data;
               
                $this->set('package',$data);    
            }
         $defaultLeadtime = $this->Common->getDefaultLeadTime($this->Auth->user('id'),$pkgType,array('lead_time','spa_day_leadtime','package_leadtime'));
         $this->set(compact('defaultLeadtime'));
        
    }
     /**********************************************************************************    
      @Function Name    : admin_ajax_packageoption
      @Params	        : NULL
      @Description      : for the Package pricing option of Salon
      @Author           : Shibu Kumar
      @Date             : 2-April-2015
    ********************************************************************************** */
    function admin_ajax_packageoption($packageId=null, $optionCount=null,$type ='newoption'){
        $this->loadModel('Package');
         $this->loadModel('PackageService');
        $this->loadModel('PackagePricingOption');
        $params = array();
        
        
        if($packageId){
            $this->Package->recursive =2;
            $dataOption = $this->Package->find('first',array('conditions'=>array('Package.id'=>$packageId)));
             if(isset($this->request->data['NewData'])){
               parse_str($this->request->data['NewData'], $params);
               unset($params['data']['SalonServiceDetail']);
               if($this->Package->saveAll($params['data'],array('deep' => true,'validate'=>false))){
                
               }else{
                pr( $this->Package->validationErrors);
                exit;
                
               }
               $optionCount = $this->request->data['countOpt'];
            }
             if($type == 'newoption'){
                if(isset($dataOption['PackageService']) && !empty($dataOption['PackageService'])){
                    foreach($dataOption['PackageService'] as $packageService){
                        $imgData['PackagePricingOption']['package_service_id'] = $packageService['id'];
                        $imgData['PackagePricingOption']['is_deleted'] = 0;
                        $imgData['PackagePricingOption']['option_id'] = $optionCount;
                        $this->PackagePricingOption->create();
                        $this->PackagePricingOption->save($imgData);
                    }
                }
             }
            $data = $this->Package->find('first',array('conditions'=>array('Package.id'=>$packageId)));
            //pr($data);
           // exit;
            $this->request->data =  $data;
            $this->set('package',$data);
            if($optionCount && $optionCount !='null' ){
                $this->set(compact('optionCount'));
            }
           if ($this->request->is('ajax')) {
               $this->layout = 'ajax';
               $this->viewPath = "Elements/admin/SalonServices";
               $this->render('package_pricing_option_table');
           }
        }
        
    }
    
    /**********************************************************************************    
      @Function Name    : admin_service_images
      @Params	        : NULL
      @Description      : The editing and adding spaday
      @Author           : Aman Gupta
      @Date             : 15-May-2015
    ***********************************************************************************/   
    public function admin_service_images($packageId=null, $type ='newoption'){
        $this->layout = 'ajax';
        if($packageId){
            if($type == 'forDeal'){
                $this->loadModel('SalonServiceImage');
                $serImages = $this->SalonServiceImage->find('list',array('fields'=>array('SalonServiceImage.image'),'conditions'=>array('SalonServiceImage.salon_service_id'=>$packageId)));
                $this->set(compact('serImages'));
            }else{
                $this->loadModel('Package');
                $pkgData = $this->Package->find('first',array('conditions'=>array('Package.id'=>$packageId)));
                if(!empty($pkgData['PackageService'])){
                    $serIds = array();
                    foreach($pkgData['PackageService'] as $pkgSer){
                        $serIds[] = $pkgSer['salon_service_id'];
                    }
                    $serImages = array();
                    if(!empty($serIds)){
                        $this->loadModel('SalonServiceImage');
                        $serImages = $this->SalonServiceImage->find('list',array('fields'=>array('SalonServiceImage.image'),'conditions'=>array('SalonServiceImage.salon_service_id'=>$serIds)));
                    }
                    $this->set(compact('serImages'));
                }else{
                    $this->set('noService',true);    
                }
            }
        }
        else{
            $this->set('noService',true);   
        }
    }
    
    function admin_ajax_customtitle($id = null){
        $this->set('uniqId',$id);
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/SalonServices";
            $this->render('package_custom_title');
        }
    }
  /**********************************************************************************    
      @Function Name    : admin_addeEdit_spaday
      @Params	        : NULL
      @Description      : The editing and adding spaday
      @Author           : Shibu Kumar
      @Date             : 2-March-2015
    ***********************************************************************************/   
    
    function admin_addedit_spaday($id=null){
        $this->loadModel('Spaday');
        $dataService['Spaday']['user_id'] = $this->Auth->User('id');
        $dataService['Spaday']['status'] = 2;
        $this->Spaday->saveAll($dataService,array('fieldset'=>array('user_id','status')));
        $this->Spaday->bindModel(array('hasMany'=>array('SpadayPricingOption'=>array('conditions'=>array('SpadayPricingOption.is_deleted'=>0)))));
        $data = $this->Spaday->find('first',array('contain'=>array('SpadayPricingOption'),'conditions'=>array('Spaday.id'=> $this->Spaday->id)));
        $this->set('spaday',$data);
    }
    
    /**********************************************************************************    
      @Function Name    : admin_delete_packagepricingoption
      @Params	        : NULL
      @Description      : Function for deleting package pricing option
      @Author           : Shibu Kumar
      @Date             : 10-April-2015
    ***********************************************************************************/
    
    public function admin_delete_packagepricingoption($packageId = null){
        if($packageId){
            $this->loadModel('PackageService');
            $this->loadModel('PackagePricingOption');
            $packageServices = $this->PackageService->find('list',array('conditions'=>array('PackageService.package_id')));
            if(!empty($packageServices)){
                $this->PackagePricingOption->deleteAll(array('package_service_id'=>$packageServices,'option_id'=>$this->request->data['option_id']));
                echo "success";
                exit;
            }
            
        }
        echo 'f';
        exit;
        
    }
    /**********************************************************************************    
      @Function Name    : admin_addeEdit_spabreak
      @Params	        : NULL
      @Description      : The editing and adding spabreak
      @Author           : Shibu Kumar
      @Date             : 13-March-2015
    ***********************************************************************************/   
    
    function admin_addedit_spabreak($id=null){
        $this->loadModel('Spabreak');
        if($this->request->data){
            $serviceimage = array_filter($this->request->data['Spabreak']['serviceimage']); 
            if(!empty($this->request->data['SalonServiceDetail']['offer_available_weekdays'])){
                $this->request->data['SalonServiceDetail']['offer_available_weekdays'] = serialize($this->request->data['SalonServiceDetail']['offer_available_weekdays']);
            }
            $blackout_dates = array_filter($this->request->data['Spabreak']['blackout_dates']);
            if(!empty($blackout_dates)){
                foreach($blackout_dates as $bkKy=>$blkdates){
                    $blackout_dates[$bkKy] = strtotime($blkdates);
                }
                $this->request->data['Spabreak']['blackout_dates'] = serialize($blackout_dates);
            }else{
                unset($this->request->data['Spabreak']['blackout_dates']);
            }
            
            if(isset($this->request->data['SpabreakOption'])){
                $SpabreakOption = $this->request->data['SpabreakOption'];
                unset($this->request->data['SpabreakOption']);
                $this->request->data['SpabreakOption'][0] = $SpabreakOption;
            }
            if(!empty($this->request->data['Spabreak']['check_in'])){
                $this->request->data['Spabreak']['check_in'] = date('H:i:s',strtotime($this->request->data['Spabreak']['check_in']));
            }
            if(!empty($this->request->data['Spabreak']['check_out'])){
                $this->request->data['Spabreak']['check_out'] = date('H:i:s',strtotime($this->request->data['Spabreak']['check_out']));
            }
            if(isset($this->request->data['SpabreakOptionPerday'])){
                $SpabreakOptionPerday = $this->request->data['SpabreakOptionPerday'];
                unset($this->request->data['SpabreakOptionPerday']);
                $this->request->data['SpabreakOption'][0]['SpabreakOptionPerday'][0] = $SpabreakOptionPerday;
            }
            $this->request->data['SalonServiceDetail']['associated_type'] = 3;
            $this->request->data['Spabreak']['status'] = 1;
            if ($this->Spabreak->saveAll($this->request->data,array('deep' => true))) {
                    $spabreakId = $this->Spabreak->id;
                    if(!empty($serviceimage)){
                        $this->loadModel('SalonSpabreakImage');
                        $imageList = $this->SalonSpabreakImage->find('list',array('conditions'=>array('SalonSpabreakImage.spabreak_id' => $spabreakId,'SalonSpabreakImage.created_by'=>$this->Auth->user('id')),'fields'=>array('SalonSpabreakImage.image')));
                        $this->SalonSpabreakImage->deleteAll(array('SalonSpabreakImage.spabreak_id' => $spabreakId,'SalonSpabreakImage.created_by'=>$this->Auth->user('id')));
                        foreach($serviceimage as $key=>$theImage){
                            $imgData = array();
                            $imgData['SalonSpabreakImage']['spabreak_id'] = $spabreakId;
                            $imgData['SalonSpabreakImage']['image'] = $theImage;
                            $imgData['SalonSpabreakImage']['order'] = $key;
                            $imgData['SalonSpabreakImage']['created_by'] = $this->Auth->user('id');
                            $this->SalonSpabreakImage->create();
                            $this->SalonSpabreakImage->save($imgData);
                        }
                        if(!empty($imageList)){
                            $nonImg = array_diff($imageList, $serviceimage);
                            if(!empty($nonImg)){
                                foreach($nonImg as $thedImage){
                                    $this->Image->delete_image($thedImage, 'Service', $this->Auth->user('id'), false);
                                }
                            }
                        }
                         $this->loadModel('TempImage');
                        $this->TempImage->deleteAll(array('TempImage.path' => 'Spabreak','TempImage.user_id' => $this->Auth->user('id')));
                
                       
                }
                    if(!$id){
                        $edata['message'] = __('Spa break has been saved successfully.', true);
                    }else{
                        $edata['message'] = __('Spa break has been updated successfully.', true);
                    }
                        $edata['data'] = 'success';
                        echo json_encode($edata);
                        die;
                }else{
                        $errorD = $this->Spabreak->validationErrors;
                        $edata['data'] = $errorD;
                        $edata['message'] = __('unable_to_save', true);
                        echo json_encode($edata);
                        die;
            }
            
        }
        
            $this->loadModel('Spabreak');
            $this->set('type','Edit');
        if(!$id){
            $dataService['Spabreak']['user_id'] = $this->Auth->User('id');
            $dataService['Spabreak']['status'] = 2;
            $this->Spabreak->saveAll($dataService,array('fieldset'=>array('user_id','status')));
            $id = $this->Spabreak->id;
            $this->set('type','Add');
        }
        $this->Spabreak->recursive=2;
        $this->Spabreak->bindModel(array('hasMany'=>array('SpabreakOption'=>array('conditions'=>array('SpabreakOption.is_deleted'=>0)))));
        $data = $this->Spabreak->find('first',array('conditions'=>array('Spabreak.id'=>$id)));
        $data['SalonServiceDetail']['offer_available_weekdays'] = unserialize($data['SalonServiceDetail']['offer_available_weekdays']);
        
        if(!empty($data['Spabreak']['blackout_dates'])){
            $blkDate = unserialize($data['Spabreak']['blackout_dates']);
            foreach($blkDate as $theBk=>$bkdat){
                $blkDate[$theBk] = date('Y-m-d',$bkdat);
            }
            $data['Spabreak']['blackout_dates'] = $blkDate; 
        }
        //pr($data);
        $this->request->data = $data;
        $this->set('Spabreak',$data);
        $defaultLeadtime = $this->Common->getDefaultLeadTime($this->Auth->user('id'),'spabreak',array('overnight_leadtime'));
        $this->set('SpabreakId',$id);
        $this->set(compact('defaultLeadtime'));
    }
    
    function admin_spabreakajax($id=null){
           $this->loadModel('Spabreak');
           $this->Spabreak->recursive=2;
           $data = $this->Spabreak->find('first',array('conditions'=>array('Spabreak.id'=>$id)));
           $this->set('Spabreak',$data);
           $this->layout = 'ajax';
           $this->viewPath = 'Elements/admin/SalonServices';
           $this->render('spabreak_pricing_option');
        
    }
    function admin_spabreak_days($id=null,$optionid=null){
        
      $this->loadModel('SpabreakOptionPerday');
      $this->loadModel('SpabreakOption');
      if($this->request->is('post') || $this->request->is('put')){
         
            if ($this->SpabreakOptionPerday->saveAll($this->request->data)) {
               $edata['data'] = 'success';
               $edata['message'] = 'Pricing option for selected days has been saved successfully. ';
               echo json_encode($edata);
               die;
           }else{
               $errorD = $this->SpabreakOptionPerday->validationErrors;
               $edata['data'] = $errorD;
               $edata['message'] = __('unable_to_save', true);
               echo json_encode($edata);
               die;
           }
       }
       $this->set('typeDay','Add');
        if($id && $id !='null'){
            
            $this->loadModel('SpabreakOptionPerday');
            $getRow = $this->SpabreakOptionPerday->find('first',array('conditions'=>array('SpabreakOptionPerday.id'=>$id)));
            if(!$this->request->data){
                $this->request->data = $getRow;    
            }
            $this->set(compact('getRow'));
            $this->set('typeDay','Edit');
        }
        if($optionid){
            $this->set(compact('optionid'));
        }
        
       
        
    }
    
     function admin_spabreak_options($id=null){
        $this->loadModel('SpabreakOptionPerday');
          $this->loadModel('SpabreakOption');
         if($this->request->is('post') || $this->request->is('put')){
            if(isset($this->request->data['SpabreakOption'])&& !empty($this->request->data['SpabreakOption']) && isset($this->request->data['SpabreakOptionPerday']) && !empty($this->request->data['SpabreakOptionPerday'])){
               $this->request->data['SpabreakOption']['spabreak_id'] = $id;
               $spabreakperday = $this->request->data['SpabreakOptionPerday'];
               unset($this->request->data['SpabreakOptionPerday']);
                $this->request->data['SpabreakOptionPerday'][0]= $spabreakperday;
            }else{
               $params = array();
               parse_str($this->request->data['checkdays'],$params);
               if(isset($params['data']['SpabreakOptionPerday'])&&!empty($params['data']['SpabreakOptionPerday'])){
                    if(isset($params['data']['SpabreakOptionPerday']['sunday'])){
                        $this->request->data['SpabreakOptionPerday'][0]['sunday']  = $params['data']['SpabreakOptionPerday']['sunday'];   
                    }
                    if(isset($params['data']['SpabreakOptionPerday']['monday'])){
                        $this->request->data['SpabreakOptionPerday'][0]['monday']  = $params['data']['SpabreakOptionPerday']['monday'];   
                    }
                    if(isset($params['data']['SpabreakOptionPerday']['tuesday'])){
                        $this->request->data['SpabreakOptionPerday'][0]['tuesday']  = $params['data']['SpabreakOptionPerday']['tuesday'];   
                    }
                    if(isset($params['data']['SpabreakOptionPerday']['wednesday'])){
                        $this->request->data['SpabreakOptionPerday'][0]['wednesday']  = $params['data']['SpabreakOptionPerday']['wednesday'];   
                    }
                    if(isset($params['data']['SpabreakOptionPerday']['thursday'])){
                        $this->request->data['SpabreakOptionPerday'][0]['thursday']  = $params['data']['SpabreakOptionPerday']['thursday'];   
                    }
                    if(isset($params['data']['SpabreakOptionPerday']['friday'])){
                        $this->request->data['SpabreakOptionPerday'][0]['friday']  = $params['data']['SpabreakOptionPerday']['friday'];   
                    }
                    if(isset($params['data']['SpabreakOptionPerday']['saturday'])){
                        $this->request->data['SpabreakOptionPerday'][0]['saturday']  = $params['data']['SpabreakOptionPerday']['saturday'];   
                    }
                }
            
                $this->request->data['SpabreakOption']['id'] =  $this->request->data['spabreak_option_id'];
                $this->request->data['SpabreakOption']['spabreak_id'] = $this->request->data['spabreak_id'];
                $this->request->data['SpabreakOption']['salon_room_id'] =  $this->request->data['salon_room_id'];
                $this->request->data['SpabreakOption']['max_booking_perday'] =  $this->request->data['max_booking_perday'];
                $this->request->data['SpabreakOptionPerday'][0]['id'] =  $this->request->data['spabreak_option_perday_id'];
                $this->request->data['SpabreakOptionPerday'][0]['full_price'] =  $this->request->data['full_price'];
                $this->request->data['SpabreakOptionPerday'][0]['sell_price'] =  $this->request->data['sell_price'];
                $this->request->data['SpabreakOptionPerday'][0]['spabreak_option_id'] =  $this->request->data['spabreak_option_id'];
             
            }
            
              if($this->SpabreakOption->saveAll($this->request->data)){
                       $edata['id'] = $this->SpabreakOption->id;
                       $edata['data'] = 'success';
                       $edata['message'] = __('Pricing option has been saved successfully.', true);
                       echo json_encode($edata);
                       die;
              }else{
                       $errorD = $this->SpabreakOption->validationErrors;
                       $edata['data'] = $errorD;
                       $edata['message'] = __('unable_to_save', true);
                       echo json_encode($edata);
                       die;
              }
          }
     
             $this->set('spabreak_id',$id);
      }
      
     function admin_deleteSpaBreak($model=null){
        $this->loadModel('Order');
        $current_date =date('Y-m-d');
        $conditions = array("not" => array('transaction_status'=>array(2,3,4,9)),'Order.salon_service_id'=>$this->request->id, 'Order.service_type' => 4,'Order.start_date > ' => $current_date);
        $this->Order->recursive = -1;
        $count = $this->Order->find('count', array('conditions'=>$conditions));
        if(!$count){
                    $this->loadModel('Spabreak');
                    $this->Spabreak->updateAll(array('Spabreak.is_deleted'=>1),array('Spabreak.id'=>$this->request->data['id']));
                    $edata['data'] = 'success';
                    $edata['message'] = __('Deleted successfully.', true);
                    echo json_encode($edata);
                    die;
        }else{
                    $edata['data'] = 'error';
                    $edata['message'] = __('Please complete/cancel the appointments for this spabreak.', true);
                    echo json_encode($edata);
                    die;
        }
     } 
      
    function admin_delete($model=null,$del_type="NULL"){
        $this->autoRender = false;
        $this->loadModel($model);
        if($this->request->is('post') || $this->request->is('put')){
          
           if($this->request->data['type']=='permanent'){
            
                if($this->$model->deleteAll(array($model.'.id'=>$this->request->data['id']))){
                    $edata['data'] = 'success';
                    $edata['message'] = __('Deleted successfully.', true);
                    echo json_encode($edata);
                    die;
                }else{
                    $edata['data'] = 'error';
                    $edata['message'] = __('unable_to_save', true);
                    echo json_encode($edata);
                    die;
                }  
            }else{
              $del_type = ($del_type=='Spaday')?$del_type:'Package';
              $this->loadModel('DealServicePackage'); 
              $this->DealServicePackage->unbindModel(array('hasMany'=>array('DealServicePackagePriceOption')));
              $this->DealServicePackage->bindModel(array('belongsTo'=>array('Deal')));
              $current_date = time();
              $this->loadModel('Appointment');
              $this->Appointment->recursive = -1;
              $appointmentExist = $this->Appointment->find('count',array('conditions'=>array('Appointment.package_id'=>$this->request->data['id'], "NOT" => array( "Appointment.status" => array(5,9,3)),'Appointment.is_deleted'=>0,'Appointment.appointment_start_date >= ' => $current_date)));
              if($appointmentExist){
                    $edata['data'] = 'error';
                    $edata['message'] = __("Please complete/cancel the appointment for this $del_type.", true);
                    echo json_encode($edata);
                    die;
              }
              $deal = $this->DealServicePackage->find('count' , array('conditions'=>
                                                                    array(
                                                                          'Deal.is_deleted'=>0,
                                                                          'Deal.salon_id'=>$this->Auth->user('id'),
                                                                          'Deal.type'=>$del_type,
                                                                          'DealServicePackage.package_id'=>$this->request->data['id']
                                                                          ),
                                                                    ));
             if(!$deal){
                if($this->$model->updateAll(array($model.'.is_deleted'=>1),array($model.'.id'=>$this->request->data['id']))){
                    $edata['data'] = 'success';
                    $edata['message'] = __('Deleted successfully.', true);
                    echo json_encode($edata);
                    die;
                }else{
                    $edata['data'] = 'error';
                    $edata['message'] = __('Some error occured.', true);
                    echo json_encode($edata);
                    die;
                }
             }else{
                    $edata['data'] = 'error';
                    $edata['message'] = __("Please remove all deals associated with this $del_type first.", true);
                    echo json_encode($edata);
                    die;
             }
            }
        }
        die;
        
    }
    function admin_select_service_type($parent_id = null,$id=null,$cat_parent_id=null){
        $this->layout = 'ajax';
        
        if ($this->request->is('post') || $this->request->is('put')) {
                
        }
        $this->set(compact('parent_id','id','cat_parent_id'));
    }
    
    
    
    
    public function getnestedServiceImage($service_id = null){
        
        $this->loadModel('ServiceImage');
       return $this->ServiceImage->find('all',array('conditions'=>array('ServiceImage.created_by'=>$this->Auth->User('id'),'ServiceImage.service_id'=>$service_id),'order' => array('ServiceImage.order')));
       
    }
    
     /**********************************************************************************    
      @Function Name    : admin_add_pricingoption
      @Params	        : NULL
      @Description      : Add Pricing Option for Service
      @Author           : Shibu Kumar 
      @Date             : 05-jan-2015
    ***********************************************************************************/
    public function admin_add_pricingoption($id = NULL,$actId = NULL) {
        $this->layout = 'ajax';
        $this->loadModel('SalonService');
        $this->loadModel('ServicePricingOption');
        $this->set('Type','ADD');
        if($this->request->is('post') || $this->request->is('put')){
            
            if(!isset($this->request->data['ServicePricingOption'])){
                $this->request->data['ServicePricingOption'] = $this->request->data;
            }
            if(empty($this->request->data['ServicePricingOption']['pricing_level_id'])){
                $this->request->data['ServicePricingOption']['pricing_level_id'] = 0;
            }
            $staffs = $this->Common->get_salon_staff($this->Auth->User('id'));
            if($this->request->data['ServicePricingOption']['pricing_level_id'] != 0){
                if(!empty($staffs)){
                    foreach($staffs as $key=>$staff){
                        //pr($staff);
                       // exit;
                        if($staff['PricingLevelAssigntoStaff'][0]['pricing_level_id'] == $this->request->data['ServicePricingOption']['pricing_level_id']){
                            unset($staffs[$key]);
                        }
                    }
                }    
            }
            
           //pr($this->request->data);
           //exit;
           $this->request->data['ServicePricingOption']['user_id'] = $this->Auth->User('id');
           if($this->ServicePricingOption->save($this->request->data)){
                
                if(!empty($staffs)){
                    $this->loadModel('SalonStaffService');
                    foreach($staffs as $staff){
                       $staffPresent =  $this->SalonStaffService->find('list',array('conditions'=>array('SalonStaffService.salon_service_id'=> $this->request->data['ServicePricingOption']['salon_service_id'],'SalonStaffService.staff_id'=>$staff['User']['id'])));
                    if(empty($staffPresent)){
                        $salonStaff['SalonStaffService']['salon_service_id'] = $this->request->data['ServicePricingOption']['salon_service_id'];
                       $salonStaff['SalonStaffService']['staff_id'] = $staff['User']['id'];
                       $this->SalonStaffService->create();
                       $this->SalonStaffService->save($salonStaff);
                      }
                    }
                }
                
                $edata['id'] = $this->ServicePricingOption->id;
                $edata['data'] = 'success';
                $edata['message'] = __('pricingoption_save_success', true);
                echo json_encode($edata);
                die;
            }
            else{
                $errorD = $this->ServicePricingOption->validationErrors;
                $edata['data'] = $errorD;
                $edata['message'] = __('unable_to_save', true);
                echo json_encode($edata);
                die;
            }
         
        }
        if($actId){
            $actdata = $this->ServicePricingOption->findById($actId);
            $this->set('Type','EDIT');
        }
        
        $this->request->data['ServicePricingOption']['salon_service_id'] = $id;
        $data = $this->SalonService->find('first',array('conditions'=>array('SalonService.id'=>$id)));
        $data['ServicePricingOption'] = array();
        if(isset($actdata)){
            $data['ServicePricingOption'][] = $actdata['ServicePricingOption'];
        }
        $this->set('salonservice',$data);
        
    }
    
        /**********************************************************************************    
      @Function Name    : admin_add_pricingoption
      @Params	        : NULL
      @Description      : Add Pricing Option for Package
      @Author           : Shibu Kumar 
      @Date             : 05-jan-2015
    ***********************************************************************************/
    public function admin_add_packagepricingoption($id = NULL,$actId = NULL) {
        $this->layout = 'ajax';
        $this->loadModel('Package');
        $this->loadModel('PackagePricingOption');
        if($this->request->is('post') || $this->request->is('put')){
          
            if(!isset($this->request->data['PackagePricingOption'])){
                $this->request->data['PackagePricingOption'] = $this->request->data;
            }
            if(empty($this->request->data['PackagePricingOption']['pricing_level_id'])){
                $this->request->data['PackagePricingOption']['pricing_level_id'] = 0;
            }
           $this->request->data['PackagePricingOption']['user_id'] = $this->Auth->User('id');
           
           if($this->PackagePricingOption->save($this->request->data)){
                $edata['id'] = $this->PackagePricingOption->id;
                $edata['data'] = 'success';
                $edata['message'] = __('page_save_success', true);
                echo json_encode($edata);
                die;
            }
            else{
                $errorD = $this->PackagePricingOption->validationErrors;
                $edata['data'] = $errorD;
                $edata['message'] = __('unable_to_save', true);
                echo json_encode($edata);
                die;
            }
         
        }
        if($actId){
            $actdata = $this->PackagePricingOption->findById($actId);
        }
        
        $this->request->data['PackagePricingOption']['salon_service_id'] = $id;
        $data = $this->Package->find('first',array('conditions'=>array('Package.id'=>$id)));
        $data['PackagePricingOption'] = array();
        if(isset($actdata)){
            $data['PackagePricingOption'][] = $actdata['PackagePricingOption'];
        }
        $this->set('package',$data);
        
    }
     /**********************************************************************************    
      @Function Name    : get_pricingTable
      @Params	        : NULL
      @Description      : 
      @Author           : Shibu Kumar 
      @Date             : 10-jan-2015
    ***********************************************************************************/
    public function get_pricingTable($id=null){
         if ($this->request->is('ajax')) {
             $this->loadModel('SalonService');
             $this->SalonService->bindModel(array('hasMany'=>array('ServicePricingOption'=>array('conditions'=>array('ServicePricingOption.is_deleted'=>0)))));
             $data = $this->request->data = $this->SalonService->find('first',array('contain'=>array('ServicePricingOption'),'conditions'=>array('SalonService.id'=>$id)));
              $this->set('salonservice',$data);
                $this->layout = 'ajax';
                $this->viewPath = "Elements/admin/SalonServices";
                $this->render('pricing_option_table');
        }
    }
    
    public function get_packagePricingTable($id=null){
         if ($this->request->is('ajax')) {
             $this->loadModel('Package');
             $this->Package->bindModel(array('hasMany'=>array('PackagePricingOption'=>array('conditions'=>array('PackagePricingOption.is_deleted'=>0)))));
             $data = $this->request->data = $this->Package->find('first',array('contain'=>array('PackagePricingOption'),'conditions'=>array('Package.id'=>$id)));
              $this->set('package',$data);
                $this->layout = 'ajax';
                $this->viewPath = "Elements/admin/SalonServices";
                $this->render('package_pricing_option_table');
        }
    }
     /**********************************************************************************    
      @Function Name    : admin_saveinventory
      @Params	        : NULL
      @Description      : 
      @Author           : Shibu Kumar 
      @Date             :15-jan-2015
    ***********************************************************************************/
    public function admin_saveinventory(){
          $this->loadModel('SalonService'); 
          if($this->request->is('post') || $this->request->is('put')){
           $this->request->data['SalonService']['user_id'] = $this->Auth->User('id');
           $this->request->data['SalonService']['id'] = $this->request->data['salonServiceID'];
           $this->request->data['SalonService']['inventory'] = $this->request->data['inventoryLimit'];
           if($this->SalonService->save($this->request->data)){
               echo 'success';
               exit;
            }
            else{
                echo 'error';
                exit;
            }
         
        }
    }
     /**********************************************************************************    
      @Function Name    : admin_savepackageinventory
      @Params	        : NULL
      @Description      : 
      @Author           : Shibu Kumar 
      @Date             : 28-jan-2015
    ***********************************************************************************/
    public function admin_savepackageinventory(){
          $this->loadModel('Package'); 
          if($this->request->is('post') || $this->request->is('put')){
           $this->request->data['Package']['user_id'] = $this->Auth->User('id');
           $this->request->data['Package']['id'] = $this->request->data['packageID'];
           $this->request->data['Package']['inventory'] = $this->request->data['inventoryLimit'];
           if($this->Package->save($this->request->data)){
               echo 'success';
               exit;
            }
            else{
                echo 'error';
                exit;
            }
         
        }
    }
     /**********************************************************************************    
      @Function Name    : admin_staff_pricing_level_count
      @Params	        : NULL
      @Description      : 
      @Author           : Shibu Kumar 
      @Date             : 06-march-2015
    ***********************************************************************************/
       public function admin_staff_pricing_level_count($pricingLevelId = null){
        $this->autoRender = false;
        $staffs = $this->Common->get_salon_staff($this->Auth->User('id'));
         if(!empty($staffs)){
                     foreach($staffs as $key=>$staff){
                         if($staff['PricingLevelAssigntoStaff'][0]['pricing_level_id'] == $pricingLevelId){
                            echo  't';
                            exit;
                         }else{
                            
                         }
                     }
                     echo  'f';
                  exit;
                }else{
                  echo  'f';
                  exit;
                } 
       }
       
        /**********************************************************************************    
      @Function Name    : admin_changepackage_status
      @Params	        : NULL
      @Description      : The Function is for changing the Status of Package
      @Author           : Shibu Kumar
      @Date             : 14-April-2015
    ***********************************************************************************/
    public function admin_change_package_status() {
        $this->autoRender = false;
        if($this->request->is('post') || $this->request->is('put')){
            $this->Package->updateAll(array('Package.status'=>$this->request->data['status']),array('Package.id'=>$this->request->data['id']));
                echo $this->request->data['status'];
        }
        die;
    }
     /**********************************************************************************    
      @Function Name    : admin_ajax_staff_list
      @Params	        : NULL
      @Description      : 
      @Author           : Shibu Kumar 
      @Date             : 06-march-2015
    ***********************************************************************************/
    public function admin_ajax_staff_list($serviceId = null,$pricingLevelId = null,$pricingOptionID = null){
        
        if($serviceId){
            $pricing_level_array = $this->Common->get_service_pricing_levels($serviceId,$this->Auth->User('id'),$pricingOptionID);
           // pr($pricing_level_array);
            $pricing_level_id = array();
            if(!empty($pricing_level_array)){
                foreach($pricing_level_array as $ids){
                    $pricing_level_id[] = $ids['ServicePricingOption']['pricing_level_id'];
                }
            }
            if($pricingLevelId !=''){
                $pricing_level_id[] = $pricingLevelId;
            }
            
            //$allUserPricingLevel = $this->Common->get_pricingLevel_staff($pricing_level_id);
            $staffs = $this->Common->get_salon_staff($this->Auth->User('id'));
            
            // if pricing level is "Same for all" the show all staffs
            if(!in_array(0,$pricing_level_id)){
                if(!empty($staffs)){
                     foreach($staffs as $key=>$staff){
                         if(!in_array($staff['PricingLevelAssigntoStaff'][0]['pricing_level_id'],$pricing_level_id)){
                             unset($staffs[$key]);
                         }
                     }
                } 
            }
           // pr($staffs);
            $this->loadModel('SalonStaffService');
            $staffIds = array();
            //$staffLIsts =  $this->SalonStaffService->deleteAll(array('SalonStaffService.salon_service_id'=> $serviceId,'SalonStaffService.status'=>0));
            if(!empty($staffs)){
                  //$staffs = array_unique($staffs);
                 foreach($staffs as $staff){
                        $staffIds[] = $staff['User']['id'];
                        $StaffSeleted = $this->SalonStaffService->find('first',array('conditions'=>array('SalonStaffService.salon_Service_id'=>$serviceId,'SalonStaffService.staff_id'=>$staff['User']['id'])));
                        //pr($StaffSeleted);
                        if($StaffSeleted){
                           //$salonStaff['SalonStaffService']['id'] = $StaffSeleted['SalonStaffService']['id'];
                          // $salonStaff['SalonStaffService']['status'] = 1;
                        }else{
                            $salonStaff['SalonStaffService']['salon_service_id'] = $serviceId;
                            $salonStaff['SalonStaffService']['staff_id'] = $staff['User']['id'];
                            $salonStaff['SalonStaffService']['status'] =0;
                            $this->SalonStaffService->create();
                             $this->SalonStaffService->save($salonStaff);
                        }
                       // pr($salonStaff);
                    }
            }
            if(!empty($staffIds)){
             $this->SalonStaffService->deleteAll(array('SalonStaffService.salon_service_id'=> $serviceId,'NOT'=>array('SalonStaffService.staff_id'=>$staffIds)));    
            }
            
            
            $this->SalonService->bindModel(array('hasMany'=>array('ServicePricingOption'=>array('conditions'=>array('ServicePricingOption.is_deleted'=>0)))));
            $salonservice = $this->SalonService->find('first',array('contain'=>array('SalonServiceDetail','SalonStaffService','ServicePricingOption',),'conditions'=>array('SalonService.id'=>$serviceId)));
            $this->set(compact('salonservice'));
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/SalonServices";
            $this->render('salon_service_provider');
          
        }
    
    }
   
   /**********************************************************************************    
      @Function Name    : admin_create_servicedeal
      @Params	        : NULL
      @Description      : 
      @Author           : Shibu Kumar
      @Modified         : Aman Gupta
      @Date             : 15-april-2015
    ***********************************************************************************/
   
    public function admin_create_servicedeal($ID = null,$type=NULL,$dealId = NULL){
        $this->loadModel('Deal');
         $this->loadModel('DealServicePackage');
         $this->loadModel('DealServicePackagePriceOption');
        if($this->request->is('post') || $this->request->is('put')){
                $this->request->data['Deal']['offer_available_weekdays'] = serialize($this->request->data['Deal']['offer_available_weekdays']);
                $blackout_dates = array_filter($this->request->data['Deal']['blackout_dates']);
                if(!empty($blackout_dates)){
                    foreach($blackout_dates as $bkKy=>$blkdates){
                        $blackout_dates[$bkKy] = strtotime($blkdates);
                    }
                    $this->request->data['Deal']['blackout_dates'] = serialize($blackout_dates);
                }else{
                    $this->request->data['Deal']['blackout_dates'] = '';
                }
                
                if($type == 'Package' || $type == 'Spaday'){
                    foreach($this->request->data['DealServicePackage'] as $pky=>$pkgPd){
                    foreach($pkgPd['DealServicePackagePriceOption'] as $prk=>$prcDeal){
                        
                        $ky = 'dealprice_'.$prcDeal['option_id'];
                        if (array_key_exists($ky,$this->request->data['Dealprice'])){
                            $this->request->data['DealServicePackage'][$pky]['DealServicePackagePriceOption'][$prk]['deal_price'] = $this->request->data['Dealprice'][$ky];
                        }
                        
                    }
                }
                }
                $this->request->data['Deal']['salon_id'] = $this->Auth->user('id');
                $this->request->data['Deal']['status'] = 1;
                
              if ($this->Deal->saveAll($this->request->data,array('deep'=>true))) {
                    $dealId = $this->Deal->id;
                    $edata['data'] = 'success';
                    $edata['message'] = __('Deal has been added successfully.', true);
                    echo json_encode($edata);
                    die;
                }else{
                    $errorD = $this->Deal->validationErrors;
                    $edata['data'] = $errorD;
                    $edata['message'] = __('unable_to_save', true);
                    echo json_encode($edata);
                    die;
            }
        }else{
            $this->admin_delete_unusedrow();
        }
        
        if($ID){
            if($type=='Service'){
                $serviceData = $this->SalonService->find('first',array('fields'=>array('SalonService.eng_name'),'contain'=>array('ServicePricingOption'),'conditions'=>array('SalonService.id'=>$ID)));
                $this->set(compact('serviceData'));
                $this->set('service_id',$ID);
            }else if($type=='Package' || $type=='Spaday'){
                $this->Package->recursive= 2;
                $data = $this->Package->find('first',array('conditions'=>array('Package.id'=> $ID)));
                $data['SalonServiceDetail']['offer_available_weekdays'] = unserialize($data['SalonServiceDetail']['offer_available_weekdays']);
                $this->set('pkgData',$data);      
                $this->set('pkgID',$ID);
                $this->set('type',$type);
            }
        }
        
        if($dealId){
            //$this->DealServicePackage->unbindModel(array('Deal'));
            $this->Deal->recursive = 2;
            $deal = $this->Deal->findById($dealId);
            if(!empty($deal)){
                $deal['Deal']['offer_available_weekdays'] = unserialize($deal['Deal']['offer_available_weekdays']);
                if(!empty($deal['Deal']['blackout_dates'])){
                    $blkDate = unserialize($deal['Deal']['blackout_dates']);
                    foreach($blkDate as $theBk=>$bkdat){
                        $blkDate[$theBk] = date('Y-m-d',$bkdat);
                    }
                    $deal['Deal']['blackout_dates'] = $blkDate;
                }
            }
            
            $this->set(compact('deal'));
            if(!$this->request->data){
                $this->request->data = $deal;
            }
            
        }else{
            $dataService['Deal']['salon_id'] = $this->Auth->user('id');
            $dataService['Deal']['status'] = 2;
            if($type == 'Service'){
                $dataService['Deal']['type'] = 'Service';    
            }else if($type=='Package'){
                $dataService['Deal']['type'] = 'Package';    
            }else if($type=='Spaday'){
                $dataService['Deal']['type'] = 'Spaday';    
            }
            
            $this->Deal->saveAll($dataService,array('fieldset'=>array('salon_id','status')));
            $data = $this->Deal->find('first',array('conditions'=>array('Deal.id'=>$this->Deal->id)));
            $this->request->data =  $data;
            $this->set('deal',$data);
        }
         $this->set('Type',$type);
        if($type== 'Package' || $type== 'Spaday'){
            $this->render('admin_create_pkgdeal');
        }
       
       // exit;
        
    }
   
   
    public function admin_delete_unusedrow(){
        $this->loadModel('Deal');
        $this->Deal->deleteAll(array('Deal.status' => 2,'Deal.salon_id'=>$this->Auth->User('id')));
    }
   
    /**********************************************************************************    
      @Function Name    : admin_create_pkgdeal
      @Params	        : NULL
      @Description      : for deleting deal
      @Author           : Aman Gupta
      @Date             : 1-June-2015
    ***********************************************************************************/
    public function admin_create_pkgdeal($pkgID = NULL,$pkgdealId = NULL){
        
        $this->loadModel('Package');
        $this->loadModel('PackageDeal');
        if($this->request->is('post') || $this->request->is('put')){
               
                $this->request->data['PackageDeal']['offer_available_weekdays'] = serialize($this->request->data['PackageDeal']['offer_available_weekdays']);
                $blackout_dates = array_filter($this->request->data['PackageDeal']['blackout_dates']);
                if(!empty($blackout_dates)){
                    foreach($blackout_dates as $bkKy=>$blkdates){
                        $blackout_dates[$bkKy] = strtotime($blkdates);
                    }
                    $this->request->data['PackageDeal']['blackout_dates'] = serialize($blackout_dates);
                }else{
                    $this->request->data['PackageDeal']['blackout_dates'] = '';
                }
                
                foreach($this->request->data['PackageDealService'] as $pky=>$pkgPd){
                    foreach($pkgPd['PackageDealPricingOption'] as $prk=>$prcDeal){
                        
                        $ky = 'dealprice_'.$prcDeal['option_id'];
                        if (array_key_exists($ky,$this->request->data['Dealprice'])){
                            $this->request->data['PackageDealService'][$pky]['PackageDealPricingOption'][$prk]['deal_price'] = $this->request->data['Dealprice'][$ky];
                        }
                        
                    }
                }
                
                $this->request->data['PackageDeal']['user_id'] = $this->Auth->user('id');
                $this->request->data['PackageDeal']['status'] = 1;
                if ($this->PackageDeal->saveAll($this->request->data,array('deep'=>true))) {
                    $pkgdealId = $this->PackageDeal->id;
                    $edata['data'] = 'success';
                    $edata['message'] = __('Deal has been added successfully.', true);
                    echo json_encode($edata);
                    die;
                }else{
                    $errorD = $this->PackageDeal->validationErrors;
                    $edata['data'] = $errorD;
                    $edata['message'] = __('unable_to_save', true);
                    echo json_encode($edata);
                    die;
            }
        }
        
        if($pkgID){
            $this->Package->recursive= 2;
            $data = $this->Package->find('first',array('conditions'=>array('Package.id'=> $pkgID)));
            $data['SalonServiceDetail']['offer_available_weekdays'] = unserialize($data['SalonServiceDetail']['offer_available_weekdays']);
            $this->set('pkgData',$data);      
            $this->set('pkgID',$pkgID);
        }
        
        if($pkgdealId){
            $pkgdeal = $this->PackageDeal->findById($pkgdealId);
            if(!empty($pkgdeal)){
                $pkgdeal['PackageDeal']['offer_available_weekdays'] = unserialize($pkgdeal['PackageDeal']['offer_available_weekdays']);
                if(!empty($pkgdeal['PackageDeal']['blackout_dates'])){
                    $blkDate = unserialize($pkgdeal['PackageDeal']['blackout_dates']);
                    foreach($blkDate as $theBk=>$bkdat){
                        $blkDate[$theBk] = date('Y-m-d',$bkdat);
                    }
                    $pkgdeal['PackageDeal']['blackout_dates'] = $blkDate;
                }
            }
            $this->set(compact('pkgdeal'));
            if(!$this->request->data){
                $this->request->data = $pkgdeal;
            }
            
        }else{
            $dataService['PackageDeal']['package_id'] = $pkgID;
            $dataService['PackageDeal']['user_id'] = $this->Auth->user('id');
            $dataService['PackageDeal']['status'] = 2;
            $data = $this->PackageDeal->find('first',array('conditions'=>array('PackageDeal.package_id'=>$pkgID,'PackageDeal.user_id'=>$this->Auth->user('id'),'PackageDeal.status'=>2)));
            if(empty($data)){
                $this->PackageDeal->saveAll($dataService,array('fieldset'=>array('user_id','status')));
                $data = $this->PackageDeal->find('first',array('conditions'=>array('PackageDeal.id'=>$this->PackageDeal->id)));
            }
            $this->request->data =  $data;
            $this->set('pkgdeal',$data);
        }
    }


    /**********************************************************************************    
      @Function Name    : admin_deletedeal
      @Params	        : NULL
      @Description      : for deleting deal
      @Author           : Aman Gupta
      @Date             : 15-april-2015
    ***********************************************************************************/
    public function admin_deletedeal() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->loadModel('Deal');   
            $current_date = time();
            $this->loadModel('Appointment');
            $this->Appointment->recursive = -1;
            $appointmentExist = $this->Appointment->find('count',array('conditions'=>array('Appointment.deal_id'=>$this->request->data['id'], "NOT" => array( "Appointment.status" => array(5,9,3)),'Appointment.is_deleted'=>0,'Appointment.appointment_start_date >= ' => $current_date)));
            if($appointmentExist){
                  echo__("Please complete/cancel the appointment for this Deal.", true);
                  die;
            }
            if($this->request->data['id']){
                if($this->Deal->updateAll(array('Deal.is_deleted'=>1),array('Deal.id'=>$this->request->data['id']))){
                    echo 'success';
                    die;
                }
            }
        }
        echo 'Some error occured.';
        die;
    }
    /**********************************************************************************    
      @Function Name    : admin_deal_images
      @Params	        : NULL
      @Description      : for uploading deal image
      @Author           : Aman Gupta
      @Date             : 15-april-2015
    ***********************************************************************************/
    public function admin_deal_images() {
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $userId = $this->Auth->user('id');
            $path = $model = "Deal";
            
            if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                $userId = $this->Auth->user('id');
                $model = "Deal";
                $retrun = $this->Image->upload_image($_FILES['image'], $model, $userId, false);
                
                if ($retrun) {
                    if ($this->request->data['dealId']) {
                        $this->loadModel('DealImage');
                        $srvD['DealImage']['service_deal_id'] = $this->request->data['dealId'];
                        $srvD['DealImage']['image'] = $retrun;
                        $srvD['DealImage']['created_by'] = $userId;
                        $this->DealImage->create();
                        if ($this->DealImage->save($srvD)) {
                            $edata['data'] = 'success';
                            $edata['id'] = $this->request->data['dealId'];
                            $edata['image'] = $retrun;
                            echo json_encode($edata);
                            die;
                        } else {
                            $this->Image->delete_image($retrun, $model, $userId, false);
                            echo 'f';
                        }
                    } else {
                        $this->loadModel('TempImage');
                        $tempD['TempImage']['user_id'] = $this->Auth->user('id');
                        $tempD['TempImage']['image'] = $retrun;
                        $tempD['TempImage']['path'] = $path;
                        $tempD['TempImage']['parent_id'] = $this->request->data['dealId'];
                        $this->TempImage->create();
                        if ($this->TempImage->save($tempD)) {
                            $edata['data'] = $path;
                            $edata['id'] = '';
                            $edata['image'] = $retrun;
                            echo json_encode($edata);
                            die;
                        } else {
                            $this->Image->delete_image($retrun, $model, $userId, false);
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

        die;
    }
   
   /**********************************************************************************    
      @Function Name    : admin_change_deal_status
      @Params	        : NULL
      @Description      : for changing status of deal
      @Author           : Aman Gupta
      @Date             : 15-april-2015
    ***********************************************************************************/
    public function admin_change_deal_status() {
        $this->autoRender = false;
        $this->loadModel('Deal');
        if($this->request->is('post') || $this->request->is('put')){
            $id = $this->request->data['id'];
            $this->Deal->recursive = -1;
            $delaData = $this->Deal->find('first',array('conditions'=>array('id'=>$id)));
            $today = date('Y-m-d');
            if($this->request->data['status']==1){
                if($delaData['Deal']['max_time'] < $today){
                   echo 'Deal start date can not be in past.Please first change the deal start date';
                   die;
                }
                if($delaData['Deal']['quantity_type'] == 1 && ($delaData['Deal']['purchased_quantity'] >= $delaData['Deal']['quantity']) ){
                   echo 'Please increase the deal quantity';
                   die;
                }
            }  
            //Deal.quantity_type=1 AND Deal.quantity > Deal.purchased_quantity
            if($this->Deal->updateAll(array('Deal.status'=>$this->request->data['status']),array('Deal.id'=>$this->request->data['id']))){
                echo  $this->request->data['status'];
            }
            else{
                echo  $this->request->data['status'];
            }
        }
        die;
    }
   
   
   
   public function admin_checkStaffPricingLevel(){
        $this->autoRender=false;
        if($this->request->data){
            $staffs = $this->Common->get_salon_staff($this->Auth->User('id'));
            
           $newstaff=array();
                 if(!empty($staffs)){
                    foreach($staffs as $key=>$staff){
                         if($this->request->data['type']=='all'){
                            $newstaff[$key]    =   $staff['User']['id'];
                         }else{
                            if($staff['PricingLevelAssigntoStaff'][0]['pricing_level_id']==$this->request->data['pricing_level_id']){
                            $newstaff[$key]    =   $staff['User']['id'];    
                            }
                            
                         }
                    }
                 }
            
            
            if(!empty($newstaff)){
               echo  $this->SalonStaffService->find('count',array('conditions'=>array('SalonStaffService.salon_service_id'=>$this->request->data['service_id'],'SalonStaffService.staff_id'=>$newstaff,'SalonStaffService.status'=>1)));
               exit;
            }
                
            
            
        }
      
       echo '2';
       exit; 
    }
    
    function admin_add_deal(){
        
    }
    
    function loadAjaxlistedOnline($value = null ,$type= null){
        $this->layout = 'ajax';
        
        $this->set(compact('value','type'));
    }
    

    
}