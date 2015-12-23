<?php
class LocationsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form','Js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session','Paginator','Common','RequestHandler','Image'); //An array containing the names of components this controller uses.
    public $paginate = array('City' => array('limit' => 5));
    public $uses = array();
    
    /**********************************************************************************    
    @Function Name : admin_index
    @Params	 : NULL
    @Description   : For saving Site theme for the Admin Side
    @Author        : Shibu Kumar
    @Date          : 27-Nov-2014
    ***********************************************************************************/
    public function admin_add($countryId,$stateId,$id=null){
        $this->layout= 'ajax';
         //$id = base64_decode($id);
         $this->loadModel('City');
            $user_id = $this->Auth->user('id');
            if(empty($this->request->data)){
                $this->request->data = $this->City->find('first',array('conditions'=>array('City.id'=>$id)));
            } else if(isset($this->request->data)) {
                $this->City->set($this->request->data);
		if($this->City->validates()){
		    if($id) {
                        $this->City->id  = $id;
			$message = 'Location has been updated successfully.';
                    } else {
                        $this->City->create();
			$message = 'Location has been saved successfully.';
                    }
                    $this->request->data['City']['country_id'] = $countryId;
                    $this->request->data['City']['state_id'] = $stateId;
                    if($this->City->save($this->request->data,array('validates'=>false))) {
			$edata['data'] = 'success' ;
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
                    } else {
			$message = 'Location has not been saved, please try again.';
			$vError = $this->City->validationErrors;
			$edata['data'] = $vError ;
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
		    }
                } else {
		    $message = __('unable_to_save', true);
		    $vError = $this->City->validationErrors;
		    $edata['data'] = $vError ;
		    $edata['message'] = $message;
		    echo json_encode($edata);
		    die;
		}
            }
        $this->set('activeTMenu','locations');
        $this->set('page_title','Locations');
        $this->set('leftMenu',true);
    }

    
    /**********************************************************************************
    @Function Name : admin_index
    @Params	 : NULL
    @Description   : For saving Site theme for the Admin Side
    @Author        : Shibu Kumar
    @Modified By:  Ramanpreet Pal Kaur
    @Modified On:  03/04/2015
    @Date          : 27-Nov-2014
    ***********************************************************************************/
    public function admin_index($countryId,$stateId){
        $countryId = base64_decode($countryId);
        $stateId = base64_decode($stateId);
     
	$this->loadModel('City');
    $conditions= array('country_id'=>$countryId,'state_id'=>$stateId);
	if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	    
	}
	if(!empty($src_keywrd)){
	   $conditions = array('country_id'=>$countryId,'state_id'=>$stateId,
				    'City.city_name LIKE "%'.$src_keywrd.'%"'
				);
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
	
	if(!empty($src_keywrd)){
	   $conditions = array('country_id'=>$countryId,'state_id'=>$stateId,
				    'City.city_name LIKE "%'.$src_keywrd.'%"'
				);
	}
	
	/**************** End of set page limit *******************/
	
	$this->params->data['number_records'] = $number_records;
    
        $this->layout   =   'admin_paginator';
        $this->loadModel('City');
	$fields = array('City.id',
			'City.city_name',
            'City.status'
		);
	
	$this->Paginator->settings = array(
		'City' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => 'city_name DESC'
		)
	    );
	
	$breadcrumb = array(
		'Home'=>array('controller'=>'Locations','action'=>'index','admin'=>true),
		'Locations'=>'javascript:void(0);'
	    );
        $activeTMenu = 'locations';
        $page_title = 'Locations';
        
        $this->set(compact('activeTMenu','page_title','breadcrumb','countryId','stateId'));
	
	
	$locations = $this->Paginator->paginate('City');
        $this->set(compact('locations'));
        $this->set('activeTMenu',$activeTMenu);
        $this->set('page_title',$page_title);
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin";
            $this->render('list_locations');
            
        }
        
    } 
 
  
    /**********************************************************************************    
      @Function Name : admin_producttypechangeStatus
      @Params	 : NULL
      @Description   : Change Status via Ajax
      @Author        : Shibu Kumar
      @Date          : 27-Nov-2014
    ***********************************************************************************/    
        public function admin_locationchangeStatus() {
            $this->autoRender = false;
            $this->loadModel('City');
            if($this->request->is('post')){
                if($this->City->updateAll(array('City.status'=>$this->request->data['status']),array('City.id'=>$this->request->data['id']))){
                    return $this->request->data['status'];
                }
            }
            
        }
        

        

           /**********************************************************************************    
        @Function Name : admin_deleteProducttype
        @Description   : Delete of Product Type
        @Author        : Shibu Kumar
        @Date          : 27-Nov-2014
      ***********************************************************************************/
    
    public function admin_delete() { 
        $this->autoRender = false;
        $this->loadModel('City');
	if($this->request->is('post') || $this->request->is('put')){ //pr($this->request->is()); exit();
	    $id = $this->request->data['id']; 
	   
	    
	   if(!empty($id)){
        $this->City->id = $id;
                if($this->City->delete()){
		  
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


}