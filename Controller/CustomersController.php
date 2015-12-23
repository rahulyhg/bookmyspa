<?php
class CustomersController extends AppController {

    public $helpers = array('Session', 'Html', 'Form','Common'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Image','Paginator'); //An array containing the names of components this controller uses.
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }
   
   public function admin_appointment_history($type =null,$id = null){
        $this->layout = 'ajax';
        $this->loadModel('AppointmentHistory');
        $history = '';
        if(!empty($id)){
              $id = base64_decode($id);
        
            if($type == 'Order'){
                $conditions = array('AppointmentHistory.order_id' => $id);
            }else{
                $conditions = array('AppointmentHistory.appointment_id' => $id);
            }
            //pr($conditions);
            //exit;
            $group = 'AppointmentHistory.modified_date , AppointmentHistory.order_id';
            
            $this->AppointmentHistory->bindModel(array('belongsTo'=>array('User'=>array('foreignKey'=>'modified_by'))));
            //$history = $this->AppointmentHistory->find('all',array('conditions'=>array('AppointmentHistory.appointment_id' =>$id),'fields'=>array('AppointmentHistory.*','User.first_name','User.last_name')));
            $this->Paginator->settings = array(
		    'AppointmentHistory' => array(
			 //'recursive'=>2,
			'limit' => 5,
			'conditions' => $conditions,
			'fields' => array('AppointmentHistory.*','GROUP_CONCAT(service_name) as package_services','GROUP_CONCAT(staff_id) as package_staffs','SUM(duration) as duration','MAX(appointment_date) as appointment_time','User.first_name','User.last_name'),
			'order' => array('AppointmentHistory.appointment_id' => 'desc'),
			'group'=> $group
		    )
	    );
            $history = $this->Paginator->paginate('AppointmentHistory');
      
        }
        $this->set(compact('history'));
    }
    
    public function admin_evoucher_verify(){
    
        if($this->request->is('ajax')){
            $voucher_code = $this->request->data['voucher_code'];
            $salon_id = $this->Auth->User('id');
            if($voucher_code){
                $this->loadModel('Evoucher');
                $isExist = $this->Evoucher->find('first',array('conditions'=>array('Evoucher.vocher_code'=>$voucher_code,'Evoucher.salon_id'=>$salon_id,'Evoucher.used'=>0)));
                
                if(!empty($isExist)){
                    if(strtotime($isExist['Evoucher']['expiry_date']) >= strtotime(date('Y-m-d'))){
                         $this->Evoucher->id = $isExist['Evoucher']['id'];
                         $this->Evoucher->saveField('used',1);
                         echo 'success';
                         exit;
                    }else{
                        echo 'expired';
                        exit;
                    }
                   
                }else{
                    echo 'used';
                    exit;
                }
            }else{
                echo 'error';
                exit;
            }
        }
      
    }
    public function admin_evoucher_redeem($customer_id = null){
        $this->loadModel('Order');
        $this->loadModel('Evoucher');
        $userId = $customer_id;
        if($customer_id){
            $this->Evoucher->virtualFields['evoucherused'] = 0;
            $this->Evoucher->virtualFields['quantity'] = 0;
            $this->Order->unbindModel(array('belongsTo'=>array('Appointment','SalonService')));
            $this->Evoucher->bindModel(array('belongsTo'=>array('Order')));
            $number_records = 3;
            $salon_id = $this->Auth->User('id');
            if($salon_id != 1){
               $conditions['Evoucher.salon_id'] = $salon_id;
            }
            $conditions['Evoucher.user_id'] =$userId;
            
        if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	    
	}
	if(!empty($src_keywrd)){
	   $conditions['OR']= array(
                                    'Evoucher.vocher_code LIKE "%'.$src_keywrd.'%"',
				    );
	}
        
        
           $number_records = 10;
	if(!empty($this->request->data['number_records']) || !empty($this->request->named['number_records'])){
	    if(!empty($this->request->data['number_records'])) {
		$number_records = $this->request->data['number_records'];
	    }
	    if(!empty($this->request->named['number_records'])){
		$number_records = $this->request->named['number_records'];
	    }
	    $this->request->data['number_records'] = $number_records;
	}
        
            $this->Paginator->settings = array(
                'Evoucher' => array(
                    'fields' => array('Evoucher.salon_id','Evoucher.expiry_date','Evoucher.evoucher_type','Evoucher.vocher_code','SUM(Evoucher.used) as Evoucher__evoucherused','COUNT(Evoucher.id) as Evoucher__quantity','Order.salon_service_id'),
                    'limit' => $number_records,
                    'conditions' => $conditions,
                    'order' => array('created' => 'desc'),
                    'group' =>'order_id'
                )
            ); 
         
            //$this->Appointment->virtualFields['Price'] = 0;
            $evouchers = $this->Paginator->paginate('Evoucher');
              
            $this->set(compact('evouchers','customer_id'));
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
                $this->viewPath = "Elements/admin/Customer";
                $this->render('list_evoucher');
              
            }
            else {
            
            }  
        }
       
        
    }
    
}

