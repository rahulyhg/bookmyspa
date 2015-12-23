<?php
class CustomercheckoutsController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Image'); //An array containing the names of components this controller uses.
    
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    function admin_index(){
        $this->layout ='admin';
        $this->set('activeTMenu','customerCheckout');
	$this->set('page_title','Checkouts');
    }
    
    
    
    
    
}

