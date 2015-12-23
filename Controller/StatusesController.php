<?php

/*
 * Statuses Controller class
 * Functionality -  Manage the admin login,listing,add 
 * Developer - Navdeep
 * Created date - 11-Feb-2014
 * Modified date - 
 */
    App::uses('Sanitize', 'Utility');

class StatusesController extends AppController {

    var $name = 'Statuses';
    var $components = array('Email', 'Cookie', 'Common', 'Paginator', 'Paypal','Captcha','Paginator');
    var $helper = array('Paginator');

    function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow();
    }
    
    public function admin_set_status() {
        //$group_id = $this->Auth->user('group_id');
        $user_id = $this->Auth->user('id');
        $this->loadModel('Color');
       
        $this->layout = 'admin';
       
        $page_title = 'Calander Status Color';
        $activeTMenu = 'calcolor';
        $leftMenu = true;
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Calendar Status' => 'javascript:void(0)',
        );
        $this->set('breadcrumb', $breadcrumb);
        
        $colrData = $this->Color->find('first', array('conditions' => array('user_id' => $user_id)));
        if(empty($colrData)){
            $colrData = $this->Color->find('first', array('conditions' => array('user_id' => 1)));
        }
        $this->set('colrData', $colrData);
        if ($this->request->is(array('put', 'post'))) {
            if($this->request->data['Color']['user_id'] == $user_id){
                $this->request->data['Color']['id'] = $this->request->data['Color']['id'];
            }else{
                $this->request->data['Color']['id'] = "";
            }
          
            $this->request->data['Color']['requested'] = '#'. $this->request->data['Color']['requested'];
            $this->request->data['Color']['accepted'] = '#'. $this->request->data['Color']['accepted'];
            $this->request->data['Color']['awaiting_confirmation'] = '#'. $this->request->data['Color']['awaiting_confirmation'];
            $this->request->data['Color']['confirmed'] = '#'. $this->request->data['Color']['confirmed'];
            $this->request->data['Color']['show'] = '#'. $this->request->data['Color']['show'];
            $this->request->data['Color']['no_show'] = '#'. $this->request->data['Color']['no_show'];
            $this->request->data['Color']['in_progress'] = '#'.$this->request->data['Color']['in_progress'];
            $this->request->data['Color']['complete'] = '#'. $this->request->data['Color']['complete'];
            $this->request->data['Color']['personal_task_block'] = '#'. $this->request->data['Color']['personal_task_block'];
            $this->request->data['Color']['personal_task_unblock'] = '#'. $this->request->data['Color']['personal_task_unblock'];
            $this->request->data['Color']['on_waiting_list'] = '#'. $this->request->data['Color']['on_waiting_list'];
            
            $this->request->data['Color']['user_id'] = $user_id;
            if ($this->Color->save($this->request->data)) {
                $this->Session->setFlash(__('status_color_save_success', true), 'flash_success');
            } else {
                $this->Session->setFlash(__('status_color_save_error', true), 'flash_success');
            }
        }
        if (!$this->request->data && isset($colrData)) {
            $this->request->data = $colrData;
        }
        $this->set(compact('page_title', 'activeTMenu', 'leftMenu', 'breadcrumb'));
    }
    
    
    

    
}

?>