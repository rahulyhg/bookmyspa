<?php

class NotificationsController extends AppController {

    public $helpers = array('Session', 'Html', 'Form', 'js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie', 'Paginator', 'Image', 'RequestHandler'); //An array containing the names of components this controller uses.

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    function admin_index(){
         $this->loadModel('UserNotification');
            $this->paginate  = array('conditions'=>array('notification_to'=>$this->Auth->user('id')),
            'limit'=>'10',
            'order'=>array('UserNotification.status'=>'ASC'),
            );
        $this->Paginator->settings = $this->paginate;
        $notifications = $this->Paginator->paginate('UserNotification');
         $this->UserNotification->getLastQuery(); 
//        die;
        $this->set(compact('notifications'));
        $this->set('page_title','Notifications');
        $this->set('activeTMenu','notifications');
        $this->set('leftMenu',TRUE);
        if($this->request->is('ajax')){
           $this->layout = 'ajax';
           $this->render('/Elements/admin/Notification/all_notifications');
        }else{
            $this->layout = 'admin'; 
        }
    }
    
    function admin_changeStatus(){
        $this->loadModel('UserNotification');
        if($this->request->is('post') && $this->request->data['id']){
        $this->autoRender = false;
        if($this->request->is('post')){
            $this->UserNotification->id = $this->request->data['id'];
            $status = ($this->request->data['status'])?'0':'1';
            if($this->UserNotification->saveField('status',$status)){
               return $this->request->data['id'];
           }
        }
      }
    }
    
    
    
}
