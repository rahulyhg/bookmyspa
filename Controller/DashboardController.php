<?php
class DashboardController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie'); //An array containing the names of components this controller uses.

    
/**********************************************************************************    
  @Function Name : index
  @Params	 : NULL
  @Description   : Dashboard Index for Saloon Staff
  @Author        : Aman Gupta
  @Date          : 10-Nov-2014
***********************************************************************************/
    public function index() {
        pr($this->Auth->User());
        die;
    }

/**********************************************************************************    
  @Function Name : admin_index
  @Params	 : NULL
  @Description   : Dashboard Index for SuperAdmin
  @Author        : Aman Gupta
  @Date          : 10-Nov-2014
***********************************************************************************/
    public function admin_index(){
	$this->loadModel('User');
        $this->layout = 'admin';
        $this->set('User',$this->Auth->user());
        /*** Fetch Salons for Franchise Owner ***********/
        $user = $this->Auth->user();
        $type = $user['type'];
        $salons = array();
        $getSalonData = array();
        if($type == 2){
	$this->User->unbindModel(array('belongsTo'=>array('Group'), 
				    'hasOne'=>array('UserDetail','Address','Contact'), 
				    'hasMany'=>array('PricingLevelAssigntoStaff')) 
			      );
           $salons = $this->User->find('all',array(
                'conditions' => array('User.parent_id' => $user['id'] , 'User.status' =>'1' , 'User.is_email_verified' => '1' , 'User.is_phone_verified' =>'1','User.is_deleted' =>'0'), //array of conditions
                'fields' => array('User.id', 'User.first_name', 'User.last_name'),
                 'order' => array(
		    'User.id' => 'DESC'
                    )
                )
            );

           if(!empty($salons)){
                $getSalonData = $this->salondata($salons);
           }
        }
                   //pr($getSalonData);exit;

        /*** Fetch Salons for Franchise Owner ***********/
        $breadcrumb = array('Dashboard'=>array('controller'=>'dashboard','action'=>'index','admin'=>true));
        $this->set('breadcrumb',$breadcrumb);
        $this->set('activeTMenu','dashboard');
        $this->set('page_title','Dashboard');
        $this->set(compact('getSalonData','check_is_held'));
    }
    
    public function admin_force_login($user_id = null){
        $this->loadModel('User');
	$logged_in_userId = $this->Session->read('Auth.User.id');
	$logged_in_userType = $this->Session->read('Auth.User.type');
	$from_user_id = $this->Session->read('Auth.from_user');
	$from_fo_id = $this->Session->read('Auth.from_fo_id');
        if(isset($user_id) && !empty($user_id)){
            $user_id=  base64_decode($user_id);
        }
        $session_auth = $this->Session->read('Auth');
	if(!empty($logged_in_userType)) {
	    if($logged_in_userType == 2 || $logged_in_userType == 3){
		if(!empty($user_id) || !empty($from_user_id)){
		    if(!empty($user_id)) {
			$user = $this->User->find('first', array(
				'conditions'=>array(
				    'User.id'=>$user_id,
				    'User.parent_id' => $logged_in_userId
				)
			));
			$branch_user = $this->User->read(null, $user_id);
		    } else {
			$user = $this->User->find('first', array(
				'conditions'=>array(
				    'User.id'=>$from_user_id,
				)
			));
			$branch_user = $this->User->read(null, $from_user_id);
		    }
		    if(!empty($branch_user)){
			$this->Session->write('Auth', $branch_user);
			if(!empty($user_id)) {
			    $this->Session->write('Auth.from_fo_id', $logged_in_userId);
			    if(!empty($from_user_id)){
				$this->Session->write('Auth.from_user', $from_user_id);
			    }
			}
			$this->redirect(array('controller'=>'dashboard','action'=>'index'));
		    } else {
		       $this->redirect(array('controller'=>'dashboard','action'=>'index'));
		    }
		} else {
		    $this->redirect(array('controller'=>'dashboard','action'=>'index'));
		}
	    } elseif($logged_in_userType == 1){
		if(!empty($user_id)){
		    $user = $this->User->find('first', array('conditions'=>array('User.id'=>$user_id)));
		    $branch_user = $this->User->read(null, $user_id);
		    if(!empty($branch_user)){
			$this->Session->write('Auth', $branch_user);
			$this->Session->write('Auth.from_user', $logged_in_userId);
			$this->redirect(array('controller'=>'dashboard','action'=>'index'));
		    } else {
		       $this->redirect(array('controller'=>'dashboard','action'=>'index'));
		    }
		} else {
		    $this->redirect(array('controller'=>'dashboard','action'=>'index'));
		}
	    } else if(empty($user_id)){
		if(!empty($from_fo_id)){
		    $user = $this->User->find('first', array('conditions'=>array('User.id'=>$from_fo_id)));
		    $this->Session->delete('Auth.from_fo_id');
		    if(!empty($user)) {
			$this->Session->write('Auth', $user);
			if(!empty($from_user_id)){
			    $this->Session->write('Auth.from_user', $from_user_id);
			}
			$this->redirect(array('controller'=>'dashboard','action'=>'index'));
		    } else {
			$this->redirect(array('controller'=>'dashboard','action'=>'index'));
		    }
		}else if(!empty($from_user_id)){
		    $user = $this->User->find('first', array('conditions'=>array('User.id'=>$from_user_id)));
		    $this->Session->delete('Auth.from_user');
		    if(!empty($user)) {
			$this->Session->write('Auth', $user);
			$this->redirect(array('controller'=>'dashboard','action'=>'index'));
		    } else {
			$this->redirect(array('controller'=>'dashboard','action'=>'index'));
		    }
		} else {
		    $this->redirect(array('controller'=>'dashboard','action'=>'index'));
		}
	    } else {
		$this->redirect(array('controller'=>'dashboard','action'=>'index'));
	    }
	} else {
            $this->redirect(array('controller'=>'dashboard','action'=>'index'));
        }
    }
    
    
    function salondata($users){
        $this->loadModel('Salon');
	$this->Salon->unbindModel(array('belongsTo'=>array('User')) );
        $data = array();
        if(!empty($users)){
            foreach($users as $salons){
                $salons_data = $this->Salon->find('first',array('conditions' => array('Salon.user_id' => $salons['User']['id'] , 'Salon.is_deleted' =>'0','Salon.status' =>'1'),'fields' => array('Salon.eng_name', 'Salon.logo','Salon.id','Salon.user_id','Salon.cover_image'), 'order'=>'Salon.id DESC')); 
                $data[$salons['User']['id']] = $salons_data;
            }
        }
        return $data;
    } 
    
}