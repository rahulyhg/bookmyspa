<?php
class SalonsController extends AppController {

    public $helpers = array('Session', 'Html', 'Form','Common'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session','Paginator', 'Email', 'Cookie','Common','Image'); //An array containing the names of components this controller uses.
    
    function beforeFilter() {
        parent::beforeFilter();
	$this->Auth->allow('admin_discounts','admin_save_discounts');
    }
    
    public function admin_index(){
        $user_logged = $this->Auth->user();
        $type_of = $user_logged['type'];
        $this->layout = 'admin';
        $activeTMenu = 'saloon';
        $this->set('page_title', 'Salons');
        $this->loadModel('User');
	$this->User->unbindModel(array('belongsTo'=>array('Group'), 
				    'hasOne'=>array('UserDetail','Address'), 
				    'hasMany'=>array('PricingLevelAssigntoStaff')) 
			      );
        $Users = $this->User->find('all',array(
		    'conditions'=>array(
			'OR' => array(
			    array('AND' => array(
				'User.type'=>'4',
				'User.parent_id'=>$this->Auth->user('id'),
				'User.is_deleted'=>0
			    )),
			    array('AND' => array(
				'User.type'=>'4',
				'User.created_by'=>$this->Auth->user('id'),
				'User.is_deleted'=>0
			    ))
			)
		    ),
		    'order'=>array('User.id DESC')
		));
	$bTypes = array();
        $bTypes = $this->businessTypeList();
        $businessTypeIds=array();
        $this->set(compact('activeTMenu','Users','bTypes','businessTypeIds','type_of')); 
        $this->set('page_title', 'Salons');
        //pr($businessUsers); die;
         if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Salon";
            $this->render('salon_list');
        }
    }
    
    function businessTypeList(){
        $this->loadModel('BusinessType');
        $list = $this->BusinessType->find('list',array('fields'=>array('BusinessType.eng_name'),'conditions'=> array('BusinessType.status'=>1,'BusinessType.is_deleted'=>0)));
        return $list;
    }  
    
    function admin_deleteUser(){
        $this->loadModel('User');
        $uid = $this->request->data['id'];   
        $this->User->id = $uid;
        //echo 0;
        if($this->User->saveField('is_deleted',1)){
           echo 1; 
        }else{
           echo 0;
        }
        die;
    }
    
    
    function admin_discounts(){
	$this->loadModel('User');
        $this->User->unbindModel(array('belongsTo'=>array('Group'),
	    'hasOne'=>array('Address','Contact','UserDetail','FacilityDetail','PolicyDetail'),
	    'hasMany'=>array('PricingLevelAssigntoStaff')
	    )
	);
	
	$this->loadModel('PointSetting');
	
	$sieasta_commission = $this->PointSetting->find('list',array(
				    'fields'=>array('id','siesta_commision'),
				    'conditions'=>array('user_id'=>1)
				    ));
	//pr($sieasta_commission);
	
	$conditions = array('User.type'=>"4",'User.is_deleted'=>"0");
	if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	}
	if(!empty($src_keywrd)){
	   $conditions = array('User.type'=>"4",'User.is_deleted'=>"0",
			       'OR'=>array(
				    'Salon.eng_name LIKE "%'.$src_keywrd.'%"',
				    'User.email LIKE "%'.$src_keywrd.'%"'
				));
	}
	/************** Set page limit ************/
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
	/**************** End of set page limit *******************/
	$this->params->data['number_records'] = $number_records;
        $this->layout   =   'admin_paginator';
        $this->loadModel('User');
	$fields = array('User.id',
			'User.email',
			'User.parent_id',
			'User.last_name',
			'User.type',
			'User.discount_percentage',
			'User.created',
			'User.modified',
			'Salon.id',
			'Salon.user_id',
			'Salon.eng_name'
		);
	//$number_records = 3;
	$this->Paginator->settings = array(
		'User' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('created' => 'desc')
		)
	    );
	$parent_salons_arr = array();
	$parent_salons = array();
	
	$parent_salons_arr = $this->User->find('all',
			    array('fields'=>array('User.id','Salon.user_id','Salon.eng_name'),
				'conditions'=>array(
				    'OR'=>array(
					'User.type'=>2,
					'User.type'=>3
				    )
				)
			    )
			);
	if(!empty($parent_salons_arr)){
	    foreach($parent_salons_arr as $parent_salon){
		$parent_salons[$parent_salon['Salon']['user_id']] = $parent_salon['Salon']['eng_name'];
	    }
	}
	
	
	
	$breadcrumb = array(
		'Home'=>array('controller'=>'Salons','action'=>'discounts','admin'=>true),
		'Salon Discounts'=>'javascript:void(0);'
	    );
	
	
        $activeTMenu = 'salonDiscounts';
        $page_title = 'Salon Discounts';
	$salonDis = $this->Paginator->paginate('User');
        $this->set(compact('activeTMenu','page_title','breadcrumb','parent_salons','salonDis','sieasta_commission'));
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Salon";
            $this->render('discounts');
        }
    }
    
    function admin_save_discounts(){
	$this->loadModel('User');
        $this->User->unbindModel(array('belongsTo'=>array('Group'),
	    'hasOne'=>array('Salon','Address','Contact','UserDetail','FacilityDetail','PolicyDetail'),
	    'hasMany'=>array('PricingLevelAssigntoStaff')
	    )
	);
	$savedata['User']['discount_percentage'] = $this->request->data['discount_percentage'];
	$savedata['User']['id'] = $this->request->data['id'];
	unset($this->request->data);
	$this->User->set($savedata);
	$this->User->save($savedata);
	die;
    }
}