<?php
class StylistsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form','js','Minify.Minify'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session','Paginator','Image','RequestHandler','Common'); //An array containing the names of components this controller uses.
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index','get_services','getStaffAvailability');
    }
    
    public function index(){
	
	if(isset($_COOKIE['State'])){
	        $stateCook = $_COOKIE['State'];
	}else{
	    $stateCook = 'not_set';
	}
	$this->loadModel('SalonAd');
	$this->loadModel('City');
	$this->loadModel('CityToAd');
        $chklang = Configure::read('Config.language');
        $this->loadModel('User');
        $this->loadModel('Service');
	$this->loadModel('SalonService');
        $this->loadModel('Country');
        $this->loadModel('State');
        $this->loadModel('City');
	$this->User->unbindModel(array(
		    'belongsTo'=>array('Group'),
		    'hasOne'=>array('Contact','FacilityDetail','PolicyDetail'),
		    'hasMany'=>array('PricingLevelAssigntoStaff')
		));
	
        $criteria ='((User.type = 4 and User.front_display = 1)  or (User.type = 5 and User.parent_id IN(Select User.id  from users as User where User.type = 4 and User.front_display = 1 and User.is_deleted = 0  ))) and User.booking_status = 1 and User.image != "" and  UserDetail.employee_type = 2';
		
        $order = 'User.is_featured_employee DESC';
	
	$fields = array('User.id',
			'User.first_name',
			'User.last_name',
			'User.image',
			'User.type',
			'User.parent_id',
			'User.is_featured_employee',
			'UserDetail.gender',
			'Salon.id',
			'Salon.user_id',
			'Salon.eng_name',
			'Salon.business_url',
			'Address.address',
			'Address.address2',
			'Address.address',
			'Address.latitude',
			'Address.longitude');
	
	/*$fields2 = array(
		    'User.first_name',
		    'User.last_name',
		    'User.image',
		    'Salon.id',
		    'Salon.user_id',
		    'Salon.eng_name',
		    'Salon.ara_name',
		    'Address.address',
		    'Address.address2',
		    'Address.address',
		    'Address.latitude',
		    'Address.longitude'
	);*/
	$usetIdsArray = array();
	$finalIds = array();
	
	if (empty($this->request->data) && (isset($this->passedArgs['search'])) ){
	    $this->request->data = $this->passedArgs['search'];
	}
	//pr($this->request->data);
	//exit;
	if($this->request->data){
	    //pr($this->request->data); die;
	    
	    
	    $banner_state=$this->request->data['User']['country_id'];
	    $banner_city=$this->request->data['loc'];
	    $conditions= "SalonAd.status = 1 and SalonAd.is_deleted = 0 and SalonAd.type = 1 and page=5 ";
	    if(isset($this->request->data['User']['country_id']) && $this->request->data['User']['country_id']!='' && isset($this->request->data['loc']) && $this->request->data['loc']!=''){
		$conditions.= "and SalonAd.state_id = $banner_state ";
	    }elseif(isset($this->request->data['User']['country_id']) && $this->request->data['User']['country_id']!='' && isset($this->request->data['loc']) && $this->request->data['loc']==''){
		$conditions.= "and SalonAd.state_id = $banner_state";
	    }elseif(isset($this->request->data['User']['country_id']) && $this->request->data['User']['country_id']=='' && isset($this->request->data['loc']) && $this->request->data['loc']!=''){
		$conditions.= "and SalonAd.state_id = $banner_state";
	    }elseif(isset($this->request->data['User']['country_id']) && $this->request->data['User']['country_id']=='' && isset($this->request->data['loc']) && $this->request->data['loc']==''){
		$conditions.= "SalonAd.state_id = $banner_state";
	    }
	    
	    if(isset($this->request->data['loc']) && $this->request->data['loc']!=''){
		$joins='array(
			
			array(
			    "table" => "city_to_ads",
			    "alias" => "CityAds",
			    "type" => "inner",
			    "conditions" => array(
				"CityAds.add_id= SalonAd.id and CityAds.city_id=$banner_city"
			    )
			)
			
		    )';
	    }else{
		$joins='array()';
	    }
	    
	    
	    
	   // $conditions= 'SalonAd.status = 1 and SalonAd.is_deleted = 0 and SalonAd.type = 1 and page=3';
	    $banner_list = $this->SalonAd->find('all' , 
		array(
		    'joins'=>$joins,
		    'conditions' => array($conditions),
		    'fields' => array('SalonAd.id','SalonAd.user_id','SalonAd.image','SalonAd.eng_description'),
		    'order' => 'rand()',
		    'limit' => 10,
		)
	    );
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    if ( empty($this->passedArgs['search']) ){
	    $this->passedArgs['search'] = $this->request->data ;
	}
	    $criteria1 = $criteria; 
	    $query  = $this->request->data ;
	    
	    $city =  $this->request->data['loc'];
	    $area = $this->request->data['city'];
            if(isset($query['type_of_search']) && !empty($query['type_of_search'])){
		$search_type=  $query['type_of_search'];
		if($search_type == 2){
		    /*** Outlet Search **/
		    $criteria1 .= " AND (Salon.eng_name LIKE'%".$this->request->data['search']."%')";
		    /*** Outlet Search **/
		}
		if($search_type == 1){
		    
		    //pr($this->request->data);
		    //exit;
		    /*** Categories Search ****/
		    // pr($this->params->query);exit;
		    $service_id = $this->Common->getServiceids($this->request->data['search']);
		    if($this->request->data['newservice']){
			    $service_id = $this->request->data['newservice'];
		    }
		    $service_category_id = $this->Common->get_service_category($service_id);
		    $criteria1 .= " AND (SalonService.service_id = $service_id AND SalonService.status = 1)";
		    /*** Categories Search ****/
		}
		if($search_type == 4){
		    /*** Service Search ****/
		    // pr($this->params->query);exit;
		    $criteria1 .= " AND (Address.city_id = $area)";
		    /*** Service Search ****/
		}
		
		if($search_type == 5 || (isset($this->request->data['service_id']) && is_array($this->request->data['service_id']))){
		    /*** Category Search ****/
		    $cat = $this->Common->getcategory($this->request->data['category']);
		    if(!empty($cat)){
			
			if(isset($this->request->data['service_id']) && !empty($this->request->data['service_id'])){
			    $cat = array_merge($cat,$this->request->data['service_id']);
			}
			$s_ids = implode(',',$cat);
			
			$criteria1 .= " AND (SalonService.service_id IN($s_ids))";
		    } else{
			$criteria1 .= "AND (SalonService.service_id =null)";
		    }
		    /*** Service Search ****/
		}
            }
	    
            if(isset($query['User']['country_id']) && ($query['User']['country_id'] !='')){
		$criteria1 .= " AND (Address.state_id = '".$query['User']['country_id']."')";
	    }
	    
	    if($city != ''){
		$criteria1 .= " AND (Address.city_id = '".$city."')";
	    }
	    
	//    if(isset($query['service_to']) && ($query['service_to'] !='')){
	//	$criteria .= " AND (Salon.service_to = '".$query['service_to']."')";
	//    }
	//    
	    if(isset($query['service_to']) && ($query['service_to'] !='')){
		$criteria1 .= " AND (Salon.service_to = '".$query['service_to']."')";
	    }
	    
	    
	    
	    if(isset($query['salon_name']) && ($query['salon_name']!='')){
		$criteria1 .= " AND (Salon.eng_name LIKE '%".$query['salon_name']."%')";
	    }
	    
	    if(isset($query['service']) &&  (!empty($query['service']))){
                $criteria1 .= " AND (Service.eng_name = '".$query['service']."')";
	    }
	    
	    if(isset($query['sort_by']) &&  ($query['sort_by']!='')){
                if($query['sort_by']=='DESC_featured'){
                    $criteria1 .= " AND (User.is_featured_employee = 1)"; 
                }
		if($query['sort_by']=='ASC_featured'){
                    $order = 'User.is_featured_employee ASC';     
                    $criteria1 .= " AND (User.is_featured_employee = 1)"; 
                }
		if($query['sort_by']=='DESC'){
                    $order = 'User.id DESC';
                }
		if($query['sort_by']=='ASC'){
                    $order = 'User.id ASC';
                }
	    }
	 
	    $usetIdsArray =  $this->User->query(
		"SELECT User.id from users as User
		    INNER JOIN addresses as Address ON (CASE WHEN User.type = 5 THEN Address.user_id = User.parent_id ELSE Address.user_id = User.id END)
		    INNER JOIN user_details as UserDetail ON UserDetail.user_id = User.id
		    INNER JOIN salons as Salon ON ( User.parent_id = Salon.user_id OR User.id = Salon.user_id)
		    INNER JOIN salon_services as SalonService on (SalonService.salon_id = User.id OR SalonService.salon_id = User.parent_id)
		    LEFT JOIN services as Service ON Service.id = SalonService.service_id
		    INNER JOIN salon_staff_services as SalonStaffService on (SalonService.id = SalonStaffService.salon_service_id and User.id = SalonStaffService.staff_id)
		    where SalonStaffService.status = 1 and $criteria1"
	    );
	   if(!empty($usetIdsArray)){
		foreach($usetIdsArray as $usersId){
		    $finalIds[] = $usersId['User']['id'];
		}
	    }
	    $finalIds = array_unique($finalIds);
	    if(isset($query['select_date']) && !empty($query['select_date']) && isset($query['select_time']) && !empty($query['select_time'])){
		/** Check Staff Availability */
		$finalIds = $this->getStaffAvailability($query['select_date'],$finalIds,$query['select_time']);
		//pr($availability);
		/** Check Staff Availability */
	    }else if(isset($query['select_date']) && !empty($query['select_date'])){
		$finalIds = $this->getStaffAvailability($query['select_date'],$finalIds);
	    }
	    unset($this->request->data);
	    $staffIds  = array();
	    if(!empty($staffSalon)){
		foreach($staffSalon as $user){
		    $finalIds[] = $user['User']['id'];
		}
	    }
	  $pageConditions = array('User.id'=>$finalIds);
	  $joins = '';
	} else {
	  
	    if(isset($stateCook) && ($stateCook !='not_set')){
		$criteria .= " AND (Address.state_id = '".$stateCook."')";
	    }
	    $this->User->unbindModel(array('hasOne' => array('Address')));
	    $pageConditions = $criteria;
	    $joins = 
	    array(
		array(
		    'alias' => 'SalonStaffService',
		    'table' => 'salon_staff_services',
		    'type' => 'INNER',
		    'conditions' => '`User`.`id` = `SalonStaffService`.`staff_id`'
		),
		array(
		    'alias' => 'Address',
		    'table' => 'addresses',
		    'type' => 'INNER',
		    'conditions' => '(CASE WHEN User.type = 5 THEN Address.user_id = User.parent_id ELSE Address.user_id = User.id END)'
		)
	     );
	    
	    
	    $conditions= 'SalonAd.status = 1 and SalonAd.is_deleted = 0 and SalonAd.type = 1 and page=5';
	    $banner_list = $this->SalonAd->find('all' , 
		array(
		    
		    'conditions' => array($conditions),
		    'fields' => array('SalonAd.id','SalonAd.user_id','SalonAd.image','SalonAd.eng_description'),
		    'order' => 'rand()',
		    'limit' => 10,
		)
	    );
	    
	    
	    
	    
	}
	//pr($pageConditions);
	$this->Paginator->settings =  array(
	    'conditions'=>$pageConditions,
	    'limit'=>15,
	    'joins' => $joins,
	    'order' =>$order,
	    'fields'=>$fields,
	    'group' => array('User.id'));
	
	$allUsers = $this->Paginator->paginate('User'); 
	//echo $criteria;
	$newStylists = $this->User->find('all',
			    array(
				'conditions'=>$criteria,
				'limit'=>2,
				'fields'=>$fields,
				'order'=>'User.id DESC'
			    ));
	//pr($newStylists);exit;
	
        $salon_data = array('M' =>"Men's Only ",
			    'W' => "Woman's Only",
			    'B'=>"Both",
			    'K'=>"Kid's Only",
			    "P"=>"Pets");
	
	$countryData = $getTreat = $getTreatment = array();
	
	$countryData = $this->Common->getCountries();
	
	$getTreatmentTypes = $this->Service->find( 'list', array(
				    'conditions'=> array('Service.parent_id' =>'0','Service.is_deleted'=>0)
				));
	
	$countTreatment = $this->Service->count_services($getTreatmentTypes);
	
	$this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
	
	if(!empty($getTreatmentTypes)){
	    foreach($getTreatmentTypes as $key => $service){
		$getTreatment[$key] = $this->Service->query(
			"SELECT Service.* FROM `services` as Service where id in (select distinct parent_id from services) AND parent_id = $service AND is_deleted=0"
		    ) ;
	    }
	}
	
        $countryData = $this->Common->getCountries();
	
        //$userData = $this->User->find('all', array('conditions'=>$pageConditions,'fields'=>$fields2));
	
	$imgPath = '';
	$locations = $information =array();
	$loc = $info ='';
	
	if(!empty($allUsers)){
	    foreach($allUsers as $val){
		if(!empty($val['Address']['address'])
		    && !empty($val['Address']['latitude'])
		    && !empty($val['Address']['longitude'])){
			$locations[] = '["'.$val['Address']['address'].'",'.$val['Address']['latitude'].','.$val['Address']['longitude'].']';
			if(!empty($val['User']['image'])){
			    $imgPath = "/images/".$val['User']['id']."/User/150/".$val['User']['image'];
			}
		    $salName =  $val['Salon']['eng_name'];
		    
		    if($chklang == 'ara'){
			if($val['Salon']['ara_name'] !=''){
			    $salName =  $val['Salon']['ara_name'];
			}
		    }
		    
		    $stylistName=$val['User']['first_name']." ".$val['User']['last_name'];
		    $salURL = Router::url(array('controller' => 'Place', 'action' => 'index','admin'=>false,$val['User']['id']),true);
		    $stylistAddress=$val['Address']['address'].", ".$val['Address']['address2'];
		    $information[] = '["<div class=\"info-window\"><div class=\"pull-left\"><img  src=\"'.$imgPath.'\"></div><div class=\"lft-space\"><h4><a href=\"'.$salURL.'\" target=\"_blank\" title=\"'.$stylistName.'\"> '.$stylistName.'</a></h4><p>'.$stylistAddress.'</p><p>'.$salName.'</p></div></div>"]';
		}
	    }
	    if(!empty($locations)){
		$loc =  implode(',',$locations);
	    }
	    if(!empty($information)){
		$info = implode(',',$information);
	    }  
	}
	
        $this->set(compact('allUsers','newStylists','salon_data',
			   'getTreatment','countryData','loc','info',
			   'countTreatment','stateId','stateCook','banner_list'));
	
	/****get count and all category*******/
        if($this->request->is(array('ajax'))){
           $this->layout = 'ajax'; 
           $this->viewPath = "Elements/frontend/Stylist";
           $this->render('middle-add');
        } else {
	    $this->layout = 'stylist';
	}
    }
    
    public function get_stylist($ids=array()){
	$this->loadModel('User');
	$this->User->bindModel(array(
		   'hasOne'=>array('UserDetail')
		));
	return $this->User->find('all',array('fields'=>array('User.id'),'conditions'=>array('User.type'=>5,'User.parent_id'=>$ids,'User.image !=' =>'','User.is_deleted'=>0,'User.booking_status'=>1,'UserDetail.employee_type'=>2)));
    }								
    
    public function get_services($offset){
        $this->loadModel('Service');
        if ($this->request->is('ajax')) { 
            $getTreatmentTypes = $this->Service->find('list',array('conditions'=> array('parent_id' => '0')));
            $this->set('treatments', $this->Service->get_services($getTreatmentTypes,$offset));
            $this->set('startId',$offset);
        }
    }
    
    public function getStaffAvailability($date = null , $staffIds = null, $time = null){
	 $day_today = strtolower(date('D',strtotime($date)));
	//exit;
	$dayTime =  strtolower(date('l',strtotime($date)));
	$openHrsStaff = $opendHours = $app_ids = array();
	$this->loadModel('User');
	$this->loadModel('SalonOpeningHour');
	$this->loadModel('Appointment');
	
	// $criteria1 = '';
	//if(!empty($time)){
	//   $criteria1 =" AND '$time' BETWEEN  (SalonOpeningHour.$dayTime"."_from) AND (SalonOpeningHour.$dayTime"."_to)"; 
	//}
	
	if(!empty($staffIds)){
	    foreach($staffIds as $staff_open){
		//echo $staff_open;
		//echo $day_today;
		$criteria = 'SalonOpeningHour.user_id ='.$staff_open.' and SalonOpeningHour.is_checked_disable_'.$day_today.' =1';
		
		$openHrsS = $this->SalonOpeningHour->find('first',array(
		    'conditions'=>array($criteria),
		    'fields'=>'*',
		    'order'=>'SalonOpeningHour.id DESC'
		    
		));
		
		if(!empty($openHrsS) && !empty($time)){
		    
		     if(strtotime($time) > strtotime($openHrsS['SalonOpeningHour'][$dayTime."_from"]) && strtotime($time) < strtotime($openHrsS['SalonOpeningHour'][$dayTime."_to"])){
			$openHrsStaff[] = $openHrsS;
		     }
		    
		}else if(!empty($openHrsS)){
		    $openHrsStaff[] = $openHrsS;
		}
		
	    }
	}
	
	if(!empty($openHrsStaff)){
	    foreach($openHrsStaff as $salon_open_hours){
		if(isset($salon_open_hours['SalonOpeningHour'])){
		   $opendHours[] = $salon_open_hours['SalonOpeningHour']['user_id'];
		}
	    }
	}
	
	return $opendHours;

    }
    
} 