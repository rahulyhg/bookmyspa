<?php
class CountriesController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Image'); //An array containing the names of components this controller uses.

    
/**********************************************************************************    
  @Function Name : admin_index
  @Params	 : NULL
  @Description   : The Function list all the Countries
  @Author        : Aman Gupta
  @Date          : 01-Dec-2014
***********************************************************************************/
    public function admin_index() {
        $this->layout = 'admin';
        $this->set('leftMenu', true);
        $countries = $this->Country->find('all',array('conditions'=>array('Country.is_deleted'=>0)));
        $breadcrumb = array(
                'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                'Country'=>array('controller'=>'Countries','action'=>'index','admin'=>true),
                //'List'=>'javascript:void(0);'
                );
        $activeTMenu = 'locationMgt';
        $page_title = 'Country';
       
        $this->set(compact('countries','activeTMenu','breadcrumb','page_title'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Country";
            $this->render('list_country');
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_addedit_Country
  @Params	 : NULL
  @Description   : Add Edit Country via Ajax
  @Author        : Aman Gupta
  @Date          : 01-Dec-2014
**********************************************************************************/
    public function admin_addedit_Country($id = NULL) {
        $this->layout = 'ajax';
        $countryData = array();
        if($id){
            $id = base64_decode($id);
            $countryData = $this->Country->findById($id);
        }
        if($this->request->is('post') || $this->request->is('put')){
            if($id){
                $this->request->data['Country']['id'] = $id;
            }else{
                $this->Country->create();
            }
            $countryFlag = $this->request->data['Country']['flag_icon'];
            unset($this->request->data['Country']['flag_icon']);
            $this->Country->set($this->request->data);
            if($this->Country->save($this->request->data)){
                $country_id = $this->Country->id;
                if(isset($countryFlag['error']) && $countryFlag['error'] == 0){
                    $model = "Country";
                    $ext = substr(strtolower(strrchr($countryFlag['name'], '.')), 1); //get the extension
                    $arr_ext = array('gif'); //set allowed extensions
                    $name = time().'_'.$countryFlag['name'];
                    if(in_array($ext, $arr_ext))
                    {
                      move_uploaded_file($countryFlag['tmp_name'], WWW_ROOT . 'img/flags/'.$country_id.'.'.$ext);
                      $return =$country_id.'.'.$ext;
                      $edata['data']['flag_icon']='';
                    }else{
                        $edata['data']['flag_icon']=   'Only gif is allowed';
                    }

                    if($return){
                        if(isset($countryData['Country']['flag_icon'])&&(!empty($countryData['Country']['flag_icon']))){
                             $path = WWW_ROOT . "img/flags/".$countryData['Country']['flag_icon'];    
                            // unlink($path);
                        }
                        $this->Country->updateAll(array('Country.flag_icon'=>'"'.$return.'"'),array('Country.id'=>$country_id));
                    }
                }
                $edata['data'] = 'success' ;
                if(isset($bType) && !empty($bType)){
                    $edata['message'] = __('Country updated successfully',true);
                }else{
                    $edata['message'] = __('Country created successfully',true);
                }
                echo json_encode($edata);
                die;
            }else{
                $message = __('unable_to_save', true);
                $vError = $this->Country->validationErrors;
                if(!empty( $edata['data']['flag_icon']))
                $edata['data'] = array_merge($edata['data'],$vError);
                else
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
            
        }
        
        if(!$this->request->data){
            $this->request->data = $countryData;
        }
        if(isset($countryData['Country']['flag_icon'])){
            $this->set('flagIcon',$countryData['Country']['flag_icon']);    
        }
        
    }
    
/**********************************************************************************    
  @Function Name : admin_changeStatus
  @Params	 : NULL
  @Description   : Country status Change via Ajax
  @Author        : Aman Gupta
  @Date          : 01-Dec-2014
**********************************************************************************/
    public function admin_changeStatus() {
        $this->autoRender = false;
        if($this->request->is('post')){
            if($this->Country->updateAll(array('Country.status'=>$this->request->data['status']),array('Country.id'=>$this->request->data['id']))){
                echo  $this->request->data['status'];
            }
        }
        die;
    }
    

/**********************************************************************************    
  @Function Name : admin_statechangeStatus
  @Params	 : NULL
  @Description   : State status Change via Ajax
  @Author        : Aman Gupta
  @Date          : 01-Dec-2014
**********************************************************************************/
    public function admin_statechangeStatus() {
        $this->autoRender = false;
        $this->loadModel('State');  
        if($this->request->is('post')){
            if($this->State->updateAll(array('State.status'=>$this->request->data['status']),array('State.id'=>$this->request->data['id']))){
                echo  $this->request->data['status'];
            }
        }
        die;
    }
    
/**********************************************************************************    
  @Function Name : admin_view
  @Params	 : NULL
  @Description   : List all states in Country
  @Author        : Aman Gupta
  @Date          : 01-Dec-2014
**********************************************************************************/    
    public function admin_view($id = NULL , $title = NULL) {
        $this->layout = 'admin';
        $this->set('leftMenu', true);
        if($id){
            $id = base64_decode($id);
            $country = $this->Country->findById($id);
            if(!empty($country)){
                $countryTitle = ucfirst($country['Country']['title']);
                $breadcrumb = array(
                'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                'Country'=>array('controller'=>'Countries','action'=>'index','admin'=>true),
                //'State List'=>'javascript:void(0);'
                'City List'=>'javascript:void(0);'
                );
                $activeTMenu = 'locationMgt';
                //$page_title = 'Country - '.$countryTitle;
                $page_title = 'City List';
                $this->set(compact('id','title','country','activeTMenu','breadcrumb','page_title'));
                if($this->request->is('ajax')){
                    $this->layout = 'ajax';
                    $this->viewPath = "Elements/admin/Country";
                    $this->render('list_states');
                }
            }
            else{
                $this->Session->setFlash(__('Unable to find Country',true),'flash_error');
                $this->redirect(array('controller'=>'Countries','action'=>'index','admin'=>true));
            }
        }else{
            $this->Session->setFlash(__('Unable to find Country',true),'flash_error');
            $this->redirect(array('controller'=>'Countries','action'=>'index','admin'=>true));
        }

    }
    
/**********************************************************************************    
  @Function Name : admin_addedit_State
  @Params	 : NULL
  @Description   : Add Edit states in Country
  @Author        : Aman Gupta
  @Date          : 01-Dec-2014
**********************************************************************************/
    public function admin_addedit_State($countryId = NULL , $id = NULL) {
        $this->layout = 'ajax';
        $this->loadModel('State');  
        $stateData = array();
        if($id){
            $id = base64_decode($id);
            $stateData = $this->State->findById($id);
        }
        if($this->request->is('post') || $this->request->is('put')){
            if($id){
                $this->request->data['State']['id'] = $id;
            }else{
                $this->State->create();
            }
            if($this->State->save($this->request->data)){
                $edata['data'] = 'success' ;
                //if(isset($bType) && !empty($bType)){
                //    $edata['message'] = __('State updated successfully',true);
                //}else{
                //    $edata['message'] = __('State have been saved successfully',true);
                //}
                $edata['message'] = __('City have been saved successfully',true);
                echo json_encode($edata);
                die;
            }else{
                $message = __('unable_to_save', true);
                $vError = $this->State->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
            
        }
        
        if(!$this->request->data){
            $this->request->data = $stateData;
        }
        $this->set('countryId',base64_decode($countryId));
    }
    
/**********************************************************************************    
  @Function Name : admin_view_cities
  @Params	 : NULL
  @Description   : List All Cities via Ajax
  @Author        : Aman Gupta
  @Date          : 01-Dec-2014
**********************************************************************************/
    public function admin_view_cities($countryId = NULL , $stateId = NULL) {
        $this->layout = 'ajax';
        if($countryId && $stateId){
            $countryId = base64_decode($countryId);
            $stateId = base64_decode($stateId);
            $this->loadModel('City');
            $this->loadModel('State');
            $cities = $this->City->find('all',array('conditions'=>array('City.state_id'=>$stateId,'City.country_id'=>$countryId)));
            $stateName = $this->State->find('first',array('fields'=>array('State.name'),'conditions'=>array('State.id'=>$stateId)));
            $stateName = $stateName['State']['name'];
            $this->set(compact('cities','countryId','stateId','stateName'));
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_addedit_City
  @Params	 : NULL
  @Description   : Add/Edit All Cities via Ajax
  @Author        : Aman Gupta
  @Date          : 01-Dec-2014
**********************************************************************************/    
    public function admin_addedit_City($countryId = NULL,$stateId = NULL , $id = NULL) {
        $this->layout = 'ajax';
        $this->loadModel('City');  
        $cityData = array();
        if($id){
            $id = base64_decode($id);
            $cityData = $this->City->findById($id);
        }
        if($this->request->is('post') || $this->request->is('put')){
            if($id){
                $this->request->data['City']['id'] = $id;
            }else{
                $this->City->create();
            }
            if($this->City->save($this->request->data)){
                $edata['data'] = 'success' ;
                //if(isset($bType) && !empty($bType)){
                //    $edata['message'] = __('State updated successfully',true);
                //}else{
                //    $edata['message'] = __('State created successfully',true);
                //}
                $edata['message'] = __('Location/Area have been saved successfully',true);
                echo json_encode($edata);
                die;
            }else{
                $message = __('unable_to_save', true);
                $vError = $this->City->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
            
        }
        
        if(!$this->request->data){
            $this->request->data = $cityData;
        }
        $this->set('countryId',base64_decode($countryId));
        $this->set('stateId',base64_decode($stateId));

    }
    
/**********************************************************************************    
  @Function Name : admin_citychangeStatus
  @Params	 : NULL
  @Description   : Change status of the City
  @Author        : Aman Gupta
  @Date          : 02-Dec-2014
**********************************************************************************/     
    public function admin_citychangeStatus() {
        $this->autoRender = false;
        $this->loadModel('City');  
        if($this->request->is('post')){
            if($this->City->updateAll(array('City.status'=>$this->request->data['status']),array('City.id'=>$this->request->data['id']))){
                echo  $this->request->data['status'];
            }
        }
        die;
    }
}