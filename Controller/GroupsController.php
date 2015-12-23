<?php
class GroupsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie'); //An array containing the names of components this controller uses.

    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('update_AcoAro','test','test_admin','defaultVendor','defaultstaff');
    }
    
    
    public function defaultVendor(){
        $theVal = array();
        $theVal['Dashboard'][] = 'admin_index';
        $theVal['Settings'][] = 'admin_wizard_type';
        $theVal['Settings'][] = 'admin_remind_later';
        $theVal['Settings'][] = 'admin_wizard_info';
        $theVal['Business'][] = 'admin_services';
        $theVal['SalonServices'][] = 'admin_edit_treatment';
        $theVal['Groups'][] = 'admin_index';
        $theVal['Settings'][] = 'admin_calendar_setting';
        
        $serialVal = serialize($theVal);
        return $serialVal;
    }
    public function defaultstaff(){
        $theVal = array();
        $theVal['Dashboard'][] = '';
        $serialVal = serialize($theVal);
        return $serialVal;
    }
    
    public function defaultUser(){
        $theVal = array();
        $theVal['Dashboard'][] = 'admin_index';
        $serialVal = serialize($theVal);
        return $serialVal;
    }
    
    
    public function test(){
        $theVal = array();
        $theVal['Dashboard'][] = 'admin_index';
        pr($theVal);
        echo serialize($theVal);
        die;
    }
    
    public function test_admin(){
        $theVal['Dashboard'][] = 'admin_index';
        $theVal['Groups'][] = 'admin_index';
        $theVal['Groups'][] = 'admin_add';
        $theVal['Groups'][] = 'admin_delete';
        $theVal['Groups'][] = 'admin_assign_access_level';
        $theVal['Groups'][] = 'admin_changeStatus';
        $theVal['Groups'][] = 'admin_set_logout_time';
        $theVal['Users'][] = 'admin_manage';
        $theVal['Users'][] = 'admin_list';
        $theVal['Users'][] = 'admin_addUser';
        $theVal['Users'][] = 'admin_reset';
        $theVal['Users'][] = 'admin_manage';
        $theVal['Users'][] = 'admin_manage';
        $theVal['Users'][] = 'admin_resend_logindetails';
        $theVal['Users'][] = 'admin_verifyPhone';
        $theVal['Users'][] = 'admin_editProfile';
        
        $theVal['Settings'][] = 'admin_email_setting';
        //$theVal['Settings'][] = 'admin_wizard_info';
        $this->loadModel('User');
        $this->User->bindModel(array('belongsTo'=>array('Group')));
        $group = $this->User->Group;
        $group->id = 1;
        if(is_array($theVal) && count($theVal)>0) {
            $this->Acl->deny($group, 'controllers');
            foreach($theVal AS $keyView=>$valView) {
                foreach($valView AS $key=>$val) {
                    $this->Acl->allow($group, 'controllers/'.$keyView.'/'.$val);
                }
            }
        }
        die('done');
    }
    
/**********************************************************************************    
  @Function Name : admin_index
  @Params	 : NULL
  @Description   : For Displaying the Groups
  @Author        : Surjit
  @Date          : 25-Nov-2014
***********************************************************************************/
    public function admin_index(){
        $this->layout = 'admin';
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Access Levels'=>array('controller'=>'Groups','action'=>'index','admin'=>true),
                        );
        $this->set('breadcrumb',$breadcrumb);
        $conditions = array();
        if($this->Auth->user('type') == Configure::read('SUPERADMIN_ROLE')) {
            //$created_by = '';
            $created_by = '';
        }else{
           $created_by  = array('Group.status != "2"','Group.id NOT IN ( Select GP.parent_id FROM groups as GP WHERE GP.created_by = '.$this->Auth->user('id').' AND GP.parent_id != 0 )','Group.created_by'=>array($this->Auth->user('id'),'1'));
        }
        
        $groups = $this->Group->find('all',array('fields'=>array('Group.id','Group.created_by','Group.name','Group.description','Group.created','Group.modified', 'Group.status',"CONCAT(User.first_name, ' ',User.last_name) AS full_name"),
                                                 'joins' => array(
                                                        array(
                                                            'alias' => 'User',
                                                            'table' => 'users',
                                                            'type' => 'LEFT',
                                                            'conditions' => '`Group`.`created_by` = `User`.`id`'
                                                        )
                                                    ),
                                                
                                                 'conditions'=> array('Group.created_by != "0"', $created_by),
                                                 'order'=> array('Group.id ASC')));
        
        $this->set(compact('groups'));
        $this->set('page_title', 'Access Levels');
        $this->set('activeTMenu', 'accessList');
        $this->set('userType', $this->Auth->user('type'));
        //GET SALON LOGOUT TIME
        $this->loadModel('Salon');
        $this->Salon->unBindModel(array('hasMany'=>array('SalonStaff')));
        $salon_logout = $this->Salon->find('first',array('fields'=>array('Salon.logout_time') ,
                                                 'conditions'=> array('Salon.user_id' => $this->Auth->user('id'))
                                                 )
                                     );
        $this->set(compact('salon_logout'));
         $this->set('leftMenu', true);
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Group";
            $this->render('list_group');
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_add
  @Params	 : $id = Group Id 
  @Description   : For Adding/Editing Group
  @Author        : Surjit
  @Date          : 25-Nov-2014
***********************************************************************************/    
    public function admin_add($id = NULL){
        $this->layout = 'ajax';
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Groups'=>array('controller'=>'Groups','action'=>'index','admin'=>true),
                        );
        if($id){
            $groupDetail = $this->Group->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        }else{
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        
        if($this->request->is('post') || $this->request->is('put')){
            $data = $this->request->data;
            if(!empty($data['Group']['id'])){
                $thegroup = $this->Group->find('first',array('conditions'=>array('Group.id'=>$data['Group']['id'])));   
                if($thegroup['Group']['created_by'] != $this->Auth->user('id')){
                    $data = $thegroup;
                    unset($data['Group']['id']);
                    $data['Group']['parent_id'] = $thegroup['Group']['id'];
                    $data['Group']['created_by'] = $this->Auth->user('id');
                    $data['Group']['group_permissions'] = $thegroup['Group']['group_permissions'];
                    $this->Group->create();
                }else{
                    $this->Group->id = $data['Group']['id'];
                }
            }else{
                $data['Group']['created_by'] = $this->Auth->user('id');
                $data['Group']['status'] = '1';
                $this->Group->create();
            }
            if($this->Group->save($data)){
                $edata['data'] = 'success' ;
                if(isset($id))
                {
                    $edata['message'] = __('accesslevel_update_success',true);
                }
                else
                {
                    $edata['message'] = __('accesslevel_add_success',true);
                }
                echo json_encode($edata);
                die;
            }else{
                $message = __('unable_to_save', true);
                $vError = $this->Group->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
                //$this->Session->setFlash(__('unable_to_save',true),'flash_error');
            }
        }
        if(!$this->request->data && isset($groupDetail)){
            $this->request->data = $groupDetail;
        }
    }
    

/**********************************************************************************    
  @Function Name : admin_delete
  @Params	 : NULL
  @Description   : Delete group
  @Author        : Surjit
  @Date          : 25-Nov-2014
***********************************************************************************/
    public function admin_delete() {
        $this->autoRender = "false";
        if($this->request->is('post') || $this->request->is('put')){
            $id = $this->request->data['id'];
            $group = $this->Group->findById($id);
            if(!empty($group)){
                if($this->Group->delete(array('Group.id'=>$id))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('delete_success',true);
                }
                else{
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unable_to_delete',true);
                    
                }
            }else{
                $edata['data'] = 'error' ;
                $edata['message'] = __('page_not_found',true);
            }
        }
        echo json_encode($edata);
        die;
    }
    
/**********************************************************************************    
  @Function Name : admin_changeStatus
  @Params	 : NULL
  @Description   : Change Status via Ajax
  @Author        : Surjit
  @Date          : 27-Nov-2014
***********************************************************************************/    
    public function admin_changeStatus() {
        $this->autoRender = false;
        if($this->request->is('post')){
            if($this->Group->updateAll(array('Group.status'=>"'".$this->request->data['status']."'"),array('Group.id'=>$this->request->data['id']))){
                return $this->request->data['status'];
            }
        }
        
    }
    
/**********************************************************************************    
  @Function Name : admin_view
  @Params	 : $id = Page Id
  @Description   : View of Group
  @Author        : Surjit
  @Date          : 27-Nov-2014
***********************************************************************************/    
    public function admin_view($id=NULL) {
        $this->layout = "ajax";
        if($id){
            $group = $this->Group->findById($id);
            $this->set(compact('group'));
            
        }
        else{
            $this->Session->setFlash(__('group_not_found',true),'flash_error');
            $this->redirect(array('controller'=>'Groups','action'=>'index','admin'=>true));
        }
    }
    
/**********************************************************************************    
  @Function Name : admin_assign_access_level
  @Params	 : $id = Page Id 
  @Description   : For Adding/Editing Static Pages
  @Author        : Surjit Kaur
  @Date          : 28-Nov-2014
***********************************************************************************/    
    public function admin_assign_access_level($group_id = NULL){
        $this->layout = 'ajax';
        $this->loadModel('AccessLevel');
        
        if($group_id){
            $accessDetail = $this->AccessLevel->getAccessLevel(); //get access levels
            $groupPermissions = $this->Group->getGroupPermissions($group_id); //get group permissions
            $breadcrumb['Edit'] = 'javascript:void(0);';
        }else{
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        if($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            $data['AccessLevel']['created_by'] = $this->Auth->user('id');
            
            //if($this->Auth->user('type') == 1){
            //    $data['AccessLevel']['created_by'] = 0;
            //}
            $arr_permissions = array();
            foreach($data AS $key_access=>$val_access) {
                //pr($val_access);
                if($key_access == 'modify') {
                    foreach($val_access AS $key_modify=>$val_modify) {
                        $accessInfo_modify = $this->AccessLevel->getAccessLevelById($key_modify, 'access_modify');
                        $arr_permissions['modify'][$key_modify] = $accessInfo_modify['AccessLevel']['access_modify'];
                    }
                } 
                if($key_access == 'view') {
                    foreach($val_access AS $key_view=>$val_view) {
                        $accessInfo_view = $this->AccessLevel->getAccessLevelById($key_view, 'access_view');
                        $arr_permissions['view'][$key_view] = $accessInfo_view['AccessLevel']['access_view'];
                    }
                }
            }
            
            $arr_permissions_temp = $arr_permissions;
            
            $permissions = serialize($arr_permissions);
            
            $thegroup = $this->Group->find('first',array('conditions'=>array('Group.id'=>$this->request->data['Group']['id'])));
            
            if($thegroup['Group']['created_by'] != $this->Auth->user('id')){
                $groupData = $thegroup;
                unset($groupData['Group']['id']);
                $groupData['Group']['parent_id'] = $thegroup['Group']['id'];
                $groupData['Group']['created_by'] = $this->Auth->user('id');
                $groupData['Group']['group_permissions'] = $permissions;
                $this->Group->create();
                if($this->Group->save($groupData)){
                    $this->update_AcoAro($this->Group->id, $arr_permissions_temp);
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('group_save_success',true);
                    echo json_encode($edata);
                    die;    
                }else{
                    $message = __('unable_to_save', true);
                    $vError = $this->Group->validationErrors;
                    $edata['data'] = $vError ;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;    
                }
            }
            
            
            
            unset($data['view']);
            unset($data['modify']);
            unset($data['AccessLevel']);
            if($this->Group->updateAll(array('Group.group_permissions'=> "'".$permissions."'"), array('Group.id' => $data['Group']['id']))){
                //Update aro_aco based on selected permissions
                $this->update_AcoAro($data['Group']['id'], $arr_permissions_temp);
                $edata['data'] = 'success' ;
                $edata['message'] = __('group_save_success',true);
                echo json_encode($edata);
                die;
            }else{
                $message = __('unable_to_save', true);
                $vError = $this->Group->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        if(!$this->request->data && isset($accessDetail)){
            $this->set('group_id', $group_id);
            $this->set('accessDetail', $accessDetail);
            //To mark selected roles permission checked 
            $permissions = $groupPermissions['Group']['group_permissions'];
            $groupPermission = unserialize($permissions);
            $permissionView = $permissionModify = array();
            if(is_array($groupPermission) && count($groupPermission)>0) {
                if(isset($groupPermission['view']) && count($groupPermission['view'])>0) {
                    foreach($groupPermission['view'] AS $key=>$valPermission) {
                        $permissionView[] = $key;
                    }
                }
                if(isset($groupPermission['modify']) && count($groupPermission['modify'])>0) {
                    foreach($groupPermission['modify'] AS $key=>$valPermission) {
                        $permissionModify[] = $key;
                    }
                }
            }
            
            $this->set('permissionView', $permissionView);
            $this->set('permissionModify', $permissionModify);
        }
    }

/**********************************************************************************    
  @Function Name : update_AcoAro
  @Params	 : $id = Group Id , $permissions = role permissions
  @Description   : For allow/disallow permissions based on access level
  @Author        : Surjit Kaur
  @Date          : 02-Dec-2014
***********************************************************************************/    

    public function update_AcoAro($group_id = null, $permissions = null) {
        $this->loadModel('User');
        $this->User->bindModel(array('belongsTo'=>array('Group')));
        $group = $this->User->Group;
        if(isset($group_id) && !empty($group_id) && !empty($permissions)) {
            $group->id = $group_id;
            if(is_array($permissions) && count($permissions)>0) {
                $this->Acl->deny($group, 'controllers');
                if(isset($permissions['view']) && count($permissions['view'])>0) {
                    foreach($permissions['view'] AS $key=>$valPermission) {
                        $groupPermission = unserialize($valPermission);
                        foreach($groupPermission AS $keyView=>$valView) {
                            foreach($valView AS $key=>$val) {
                                $this->Acl->allow($group, 'controllers/'.$keyView.'/'.$val);
                            }
                        }
                    }
                }
                if(isset($permissions['modify']) && count($permissions['modify'])>0) {
                    foreach($permissions['modify'] AS $key=>$valPermission) {
                        $groupPermission = unserialize($valPermission);
                        foreach($groupPermission AS $keyView=>$valView) {
                            foreach($valView AS $key=>$val) {
                                $this->Acl->allow($group, 'controllers/'.$keyView.'/'.$val);
                            }
                        }
                    }
                }   
            }
            
            if(in_array($group_id,array('2','3','4'))){
                $vData = $this->defaultVendor();
                $gpPerms = unserialize($vData);
            }
            if(in_array($group_id,array('5'))){
                $staffData = $this->defaultstaff();
                $gpPerms = unserialize($staffData);
            }
            if(in_array($group_id,array('6'))){
                $userData = $this->defaultUser();
                $gpPerms = unserialize($userData);
            }
            
            if(!empty($gpPerms) && isset($gpPerms)){
                foreach($gpPerms AS $keyView=>$valView) {
                    foreach($valView AS $key=>$val) {
                        $this->Acl->allow($group, 'controllers/'.$keyView.'/'.$val);
                    }
                }    
            }
            
        }
    }
    
    
/**********************************************************************************    
  @Function Name : admin_set_logout_time
  @Params	 : NULL
  @Description   : set user/salon logout time via Ajax
  @Author        : Surjit
  @Date          : 03-Dec-2014
***********************************************************************************/    
    public function admin_set_logout_time() {
        $this->loadModel('Salon');
        $this->autoRender = false;
        if($this->request->is('post')){
            $this->Salon->updateAll(array('Salon.logout_time'=>$this->request->data['logout_time']),array('User.id'=>$this->Auth->user('id')));
            exit;
        }
    }
}