<?php

class PricingLevelController extends AppController {

    public $helpers = array('Session', 'Html', 'Form', 'js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie', 'Paginator', 'Image', 'RequestHandler'); //An array containing the names of components this controller uses.

    public function beforeFilter(){
        parent::beforeFilter();
        //$this->Auth->allow('index','search','view');
    }


    public function admin_add($id = null){
        $this->layout = 'ajax';
        //$id = base64_decode($id);
        $this->loadModel('PricingLevel');
        $this->loadModel('PricingLevelAssigntoStaff');
        //Team/staff List to assign pricing level
        $this->loadModel('User');
        //$this->User->recursive = 2;
        $teamList = $this->User->find("all", array("fields" => array("id", "email","UserDetail.*"),"conditions" => array("User.type" => 5,'User.parent_id'=>$this->Auth->user('id') ,"User.status" => 1, "User.is_deleted" => 0)));
        for ($i = 0; $i < count($teamList); $i++){
            $nameList = $this->PricingLevel->find("all", array("fields" => array("id", "eng_name"), "conditions" => array("PricingLevel.is_deleted"=>0,"PricingLevel.id" => @$teamList[$i]['PricingLevelAssigntoStaff'][0]['pricing_level_id'])));
            $teamList[$i]['User']['userPriceLevelName'] = @$nameList[0]['PricingLevel']['eng_name'];
        }
        //Get the assigned pricing level to staff/employee/team
        $this->set('selectedTeamList', $this->User->PricingLevelAssigntoStaff->find('list', array('fields' => array('user_id'), "conditions" => array("pricing_level_id" => $id))));
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'PricingLevel' => array('controller' => 'PricingLevel', 'action' => 'index', 'admin' => true),
            'List Pricing' => 'javascript:void(0);',
        );
        $this->set('breadcrumb', $breadcrumb);
        $user_id = $this->Auth->user('id');
        if ($this->Auth->user('type') == 1)
            $user_id = 0;
        if (empty($this->request->data)) {
            $this->request->data = $this->PricingLevel->find('first', array('conditions' => array('PricingLevel.id' => $id)));
        } else if (isset($this->request->data)) {
            
            $this->PricingLevel->set($this->request->data);
            if ($this->PricingLevel->validates()){
                if ($id){
                    $this->PricingLevel->id = $id;
                } else {
                    $this->request->data['PricingLevel']['user_id'] = $user_id;
                    $this->PricingLevel->create();
                }
                if ($this->PricingLevel->save($this->request->data, false)){
                    $lastinsertid = $this->PricingLevel->getLastInsertId();
                    if($id != null){
                        $this->User->PricingLevelAssigntoStaff->deleteAll(array("pricing_level_id" => $id));
                        $lastinsertid = $id;
                    }   
                    if(isset($this->request->data['User'])){
                        $teamCheckVar = $this->request->data['User'];
                        foreach ($teamCheckVar as $key=>$teamids){
                            $checkLevel = $this->PricingLevelAssigntoStaff->find('first',array('conditions'=>array('user_id'=>$teamids),'fields'=>array('id')));
                            if(count($checkLevel)){
                              $this->PricingLevelAssigntoStaff->id = $checkLevel['PricingLevelAssigntoStaff']['id'];
                            }else{
                              $this->PricingLevelAssigntoStaff->create();  
                            }
                            $this->request->data['PricingLevelAssigntoStaff']['pricing_level_id'] = $lastinsertid;
                            $this->request->data['PricingLevelAssigntoStaff']['user_id'] = $teamids;
                            $this->PricingLevelAssigntoStaff->save($this->request->data);
                        }
                    }
                    $edata['data'] = 'success';
                    $edata['price_id'] = $lastinsertid;
                    $edata['message'] = __('pricinglevel_save_success', true);
                    echo json_encode($edata);
                    die;
                } else {
                    $message = __('unable_to_save', true);
                    $vError = $this->PricingLevel->validationErrors;
                    $edata['data'] = $vError;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->PricingLevel->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        $this->set('activeTMenu', 'pricingLevel');
        $this->set('teamList', $teamList);
    }

    /*     * ********************************************************************************    
      @Function Name : admin_pricing_level
      @Params	 : NULL
      @Description   : For saving Admin general settings for Adding Pricing level
      @Author        : Shibu
      @Date          : 18-Nov-2014
     * * */
    public function admin_index($id = null){
        $this->layout = 'admin';
        $this->loadModel('PricingLevel');
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Pricing level' => array('controller' => 'PricingLevel', 'action' => 'index', 'admin' => true),
        );
        $this->set('breadcrumb', $breadcrumb);
        $created_by = $this->Auth->user('id');
        if ($this->Auth->user('type') == 1){
            //$created_by = 0;
            $conditions =  array(
                                   'PricingLevel.user_id' => 0,
                                    'PricingLevel.is_deleted' => 0
                            );
        } else {
            $conditions =  array(
                            'OR' => array( array('AND' => array('PricingLevel.user_id' => $created_by,
                                    'PricingLevel.is_deleted' => 0
                                    )),
                                   array('AND' => array('PricingLevel.user_id' => 0,
                                    'PricingLevel.is_deleted' => 0
                                    ))
                                   )
                            );
        }
        $pages = $this->PricingLevel->find('all', array('conditions' => $conditions,'order'=>array('PricingLevel.modified DESC')));
        $this->set(compact('pages'));
        $this->set('page_title', 'Pricing Levels');
        $this->set('activeTMenu', 'pricingLevel');
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/PricingLevel";
            $this->render('list_pricinglevel_page');
        }
    }

    /*     * ********************************************************************************    
      @Function Name : admin_viewPricingLevel
      @Params	 : $id = Pricing Level Id
      @Description   : View of Pricing LEvel
      @Author        : Shibu Kumar
      @Date          : 18-Nov-2014
     * ********************************************************************************* */

    public function admin_view($id = null) {
        $this->layout = "ajax";
        if ($id) {
            $page = $this->PricingLevel->findById($id);
            $this->set(compact('page'));
        } else {
            $this->Session->setFlash(__('page_not_found', true), 'flash_error');
            $this->redirect(array('controller' => 'PricingLevel', 'action' => 'index', 'admin' => true));
        }
    }

    /*     * ********************************************************************************    
      @Function Name : admin_changePricingStatus
      @Params	 : NULL
      @Description   : Change Pricing Status via Ajax
      @Author        : Status
      @Date          : 18-Nov-2014
     * ********************************************************************************* */

    public function admin_changePricingStatus() {
        $this->autoRender = false;
        $this->loadModel('PricingLevel');
        if ($this->request->is('post')) {

            if ($this->PricingLevel->updateAll(array('PricingLevel.status' => $this->request->data['status']), array('PricingLevel.id' => $this->request->data['id']))) {
                return $this->request->data['status'];
            }
        }
    }

    /*     * ********************************************************************************    
      @Function Name : admin_deletePricing
      @Params	 : $id = Pricing Level Id
      @Description   : Delete of PRicing Level
      @Author        : Shibu Kumar
      @Date          : 18-Nov-2014
     * ********************************************************************************* */

    public function admin_deletePricing(){
        $this->autoRender = "false";
        if ($this->request->is('post') || $this->request->is('put')){
            $id = $this->request->data['id'];
            $page = $this->PricingLevel->findById($id);
            if (!empty($page)){
                if ($this->PricingLevel->updateAll(array('PricingLevel.is_deleted' => 1), array('PricingLevel.id' => $id))) {
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

     /*     * ********************************************************************************    
      @Function Name : admin_priceDropDown
      @Params	 : $id = Pricing Level Id
      @Description   : 
      @Author        : Sanjeev 
      @Date          : 19-jan-1015
     * ********************************************************************************* */
    
    function admin_priceDropDown($id=NULL){
         $this->autoRender = FALSE;
         $this->loadModel('PricingLevel');
	 $this->PricingLevel->recursive  = -1;
	 $price_levels = $this->PricingLevel->find('list' , array('conditions'=>array('status'=>1,'is_deleted'=>0,'or'=>array('user_id'=>$this->Auth->user('id'))),'fields'=>array('id','eng_name')));
	 $view = new View($this);
         $this->Form = $view->loadHelper('Form');
	 $list = $this->Form->input('pricing_level_id',array('id'=>'ServicePricingOptionPricingLevelId','name'=>'data[User][pricing_level_id]','label'=>false,'options' =>$price_levels,'selected' => '','class'=>'form-control pricingLevelStaff','div'=>false,'empty'=>array(0=>'Same for all staff'),'value'=>$id));
	 echo $list;
    }
}
