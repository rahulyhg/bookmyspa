<?php
class SearchController extends AppController {
    
    public $helpers = array('Session', 'Html', 'Form','frontCommon','Minify.Minify'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Image','Paginator','RequestHandler'); //An array containing the names of components this controller uses.
    var $uses =array('User','State','City' , 'Country','Salon','Service','BusinessType','SalonServiceDetail');
   
    public function beforeFilter() {
	
        parent::beforeFilter();
	
        $this->Auth->allow('getPolicyDetail','setsession','index','testLayout','indexnew','getSalonPackages_count','getvenueimages','getCountryName','getBusinessName','getsalonOpeningHours','getCountMenuServices','getMenuServices','searchlocation','getservice','getallsearch','search_outer','get_element_id','getCountDeals','getAjaxContent','getFacilityDetail','getSalonPackages');
    }
    
    /**********************************************************************************    
	    @Function Name : index
	    @Params	 : NULL
	    @Description   : Search Results Page
	    @Date          : 19-Feb-2015
    ***********************************************************************************/

    public function index($location = null,$salon_type = null,$available_date = null,$treatment = null , $service_type_id = null) {
	$i_want_spaday = null;
	$i_want_val = null;
	$service = '';
	$service_to = '';
	$salon = '';
	if($location == ''){
	    $this->redirect(array('controller'=>'homes','action'=>'index'));
	}
	$this->layout = "search";
	
	if(!empty($salon_type) &&($salon_type == 'spaday') && empty($this->request->data)){
	    $spay_day_type = $salon_type;
	    $salon_type = 'serviceTo';
	    
	    if(!empty($spay_day_type) && ($spay_day_type == 'spaday')){
		$this->request->data['i_want'] = $spay_day_type;
		$split_location = explode('~',$location);
		$i_want_val = @$this->request->data['i_want'];
		if(!empty($split_location)){
		    if(!empty($split_location[0])){
			$country = $split_location[0];
			$country = str_replace('-',' ',$country);
			//GET COUNTRY ID FROM NAME
			$country_id = $this->get_element_id('Country',$country);
			$this->request->data['country_id'] = $country_id;
		    }
		    if(!empty($split_location[1])){
			$country = $split_location[1];
			$city = str_replace('-',' ',$country);
			//GET COUNTRY ID FROM NAME
			$state_id = $this->get_element_id('State',$city);
			$this->request->data['state_id'] = $state_id;
		    }
		}
	    }
	}
	
	$this->set('i_want_val',$i_want_val);
	$SessionLang = $this->Session->read('Config.language');
	if($SessionLang == ""){
	    $SessionLang = 'eng';
	}
	$post = $countryId = $info = $countryData = $loc = '';
	$locations = $information = $getTreatment = $getTreat = array();
	$loc1 = "";
	$serviceData = array(); $finalIds= array();
	$userIdFrmTreatmentServices= "";
	$userIdServices = array(); $userIdFrmtreatment = array();
	
	// Common criteria
	$criteria = 'User.type IN (3,4) and User.status = 1 and User.front_display = 1 and User.is_deleted =0 and User.is_email_verified = 1  and User.is_phone_verified = 1';
	$criteriaCommon ='User.type IN (3,4) and User.status = 1 and User.front_display = 1 and User.is_deleted =0 and User.is_email_verified = 1 and User.is_phone_verified = 1';
	$criteria1="";
	$service_type = '';
	
	// LOCATION CHECK STARTS HERE
	$country_id = $state_id = $city_id = $service_category_id = '';
	$s_ids = '';
	$order= 'User.created DESC';
	$this->loadModel('SalonService');
	
	if(!empty($service_type_id)){
	    if(!empty($service_type)){
		$s_ids = implode(',',$service_type);
	    }
	}
	//echo $location;
	
	if(($location != '') && (empty($this->request->data))){
	    $split_location = explode('~',$location);
	   // pr($split_location);
	    if(!empty($split_location)){
		if(!empty($split_location[0])){
		    $country = $split_location[0];
		    $country = str_replace('-',' ',$country);
		    //GET COUNTRY ID FROM NAME
		    $country_id = $this->get_element_id('Country',$country);
		}
		if(!empty($split_location[1]) && ($split_location[1] != "All-Cities")){
		    $state = $split_location[1];
		    $state = str_replace('-',' ',$state);
		    //GET STATE ID FROM NAME
		    $state_id = $this->get_element_id('State',$state);
		}
		if(!empty($split_location[2])){
		      $city = $split_location[2];
		     $loc1 = $city = str_replace('-',' ',$city);
		    //GET CITY ID FROM NAME
		     $city_id = $this->get_element_id('City',$city);
		   
		}
	    }
	       //pr($country_id);
	      // pr($state_id);
	     //pr($city_id);
	    // CRITERIA FOR COUNTRY STATE AND CITY
	    if(!empty($country_id)){
		$criteria .= " AND (Address.country_id = '".$country_id."')";
	    }
	    if(!empty($state_id)){
		$criteria .= " AND (Address.state_id = '".$state_id."')";
		$this->set(compact('state_id'));
	    }
	    if(!empty($city_id)){
		$criteria .= " AND (Address.city_id = '".$city_id."')";
		
	    }
	}
	
	// LOCATION CHECK ENDS HERE
	
	
	// DATE CHECK TO GET AVIALABLITY OF SALOON
	if($available_date !='' && (empty($this->request->data))){
	    $day = date('D', strtotime($available_date));
	    $day = strtolower($day);
	    $fieldName = "is_checked_disable_".$day;
	}
	// DATE CHECK TO GET AVIALABLITY OF SALOON(ENDS HERE)
	
	//SALON TYPE CHECK (business type)
	if($salon_type != '' && $salon_type != 'serviceTo' && (empty($this->request->data))){
	    $service_to = $salon_type;
	} 
	//SALON TYPE CHECK (business type) ENDS HERE
	
	//SERVICES CHECK and saloon name check (for eg: serices ~ saloon)
	
	if(empty($this->request->data['search']) && !empty($this->request->data['hm_search'])){
	    $treatment = $this->request->data['search'] = $this->request->data['hm_search'];
	}
	
	
	if($treatment != '' && (empty($this->request->data))){
	    $treatment_explode = explode('~',$treatment);
	    if(!empty($treatment_explode)){
		$service = $treatment_explode[0];
	    }
	    if($service !=''){
		$service = str_replace('-',' ',$service);
		    $criteria1 .= "( (Service.eng_name LIKE '%$service%' OR Service.ara_name LIKE '%$service%' ) AND parent_id is NOT NULL)";
		if($criteria1 !=""){
		    // Get userids from 
		    $serviceData  = $this->Service->find('list',array('conditions'=>array($criteria1),'fields'=>array('id')));
		}
		
		$serviceData = '';
		if(!empty($serviceData)){
		    // to do yet
		    $serviceIDs = $this->Common->getServiceFromId($serviceData);
		    
		    $this->loadModel('SalonService');
		    $userIdFrmServices = $this->SalonService->find('all',array('conditions'=>array('service_id'=>$serviceData),'fields'=>array('salon_id'),'recursive'=>-1));
		    foreach($userIdFrmServices as $usersId){
			$userIdServices[] = $usersId['SalonService']['salon_id'];
		    }
		}else{
		    
		    //pr($this->Common->getServiceidsNew($service));
		    //exit;
		    
		}
	    }
	    
	    if(isset($treatment_explode[1])){
		$salonName = $treatment_explode[1];
		$salon = str_replace('-',' ',$salonName);
		$criteria .= " AND (Salon.eng_name LIKE '%$salon%' OR Salon.ara_name LIKE '%$salon%')";
	
	    }
	   	 
	}elseif(isset($this->request->data['salon_name']) && !empty($this->request->data['salon_name'])){
//die("2");
	     $salon = $this->request->data['salon_name'];
	     $salon = str_replace('-',' ',$salon);
	     $salon=trim($salon);
	     $criteria .= " AND (Salon.eng_name LIKE '%$salon%' OR Salon.ara_name LIKE '%$salon%')";
   	     $this->request->data['salon_name'] = '';
	}

	//echo $criteria;
	//print_r($this->request->data);
	if(empty($this->request->data)) {
	    
	    $this->request->data['country_id'] = $country_id;
	    $this->request->data['User']['country_id'] = $this->request->data['state_id'] = $state_id;
	    $this->request->data['loc'] = $this->request->data['city_id'] = $city_id;
	    $this->set(compact('loc1'));
	    $this->request->data['search'] = $service;
	    $this->request->data['hm_search'] = $service;
	    $this->request->data['service_to'] = $service_to;
	    $this->request->data['salon'] = $salon;
	    $this->request->data['type_of_search'] = 'home_page';
	    $this->request->data['newservice'] = '';
	}
	
	if(isset($salonName) && !empty($salonName)){
	    $this->request->data['salon_name'] = $salonName;
	}
//pr( $this->request->data);
	if(isset($city_id) && !empty($city_id)){
	     $this->request->data['locationCity'] = $city_id;
	}
    
	if ((isset($this->passedArgs['search'])) ){
	    $this->request->data = $this->passedArgs['search'];
	}
	if(isset($this->request->data) && !empty($this->request->data)){
	   
	    $loc = @$this->request->data['User']['country_id'];
	    $city = @$this->request->data['loc'];
	    $area = @$this->request->data['city'];
	    $service_id = '';
	    $type_id ='';
		//echo 'ff'.$city.'dd';
	    if($loc != ''){
		$criteria .= " AND (Address.state_id = ".$loc.")";
	    }
	    if(!empty($city)){
		$criteria .= " AND (Address.city_id = '".$city."')";
		$this->request->data['locationCity'] = $city;
	    }
	    
	    if(isset($this->request->data['search'])){
		//pr($this->request->data);
		 //exit;
	    
		$search = $this->request->data['search'];
		$search_type=$this->request->data['type_of_search'];
		
		if($search_type == 2){
		    $criteria .= " AND (Salon.eng_name LIKE'%".TRIM($this->request->data['search'])."%')";
		}
		if($search_type == 1){
		    $service_id = $this->Common->getServiceids($this->request->data['search']);
		    if($this->request->data['newservice']){
			    $service_id = $this->request->data['newservice'];
		    }
		    $service_category_id = $this->Common->get_service_category($service_id);
		    $criteria .= " AND (SalonService.service_id = $service_id AND SalonService.status = 1)";
		    /*** Categories Search ****/
		}
		if($search_type == 4){
		    /*** Service Search ****/
		    $criteria .= " AND (Address.city_id = $area)";
		    /*** Service Search ****/
		}
		if($search_type == 5){
		    
		    /*** Category Search ****/
			$type_id = $this->request->data['category'];
			$cat = $this->Common->getcategory($this->request->data['category']);
			
			$allunset = 'false';
			if(!empty($this->request->data['service_parent'])){
			    if(!isset($this->request->data['service_id'])){
				$allunset = 'true';
			    }
			}
			// For treatment search left Side
			if(isset($this->request->data['service_id']) && !empty($this->request->data['service_id'])){
			    $cat = $this->request->data['service_id'];
			    $service_id = implode(",", $cat);
			    //$search_type = 1;
			    unset($this->request->data['service_id']);
			}
		    if(!empty($cat)){
			$s_ids = implode(',',$cat);
			$criteria .= " AND (SalonService.service_id IN($s_ids) AND SalonService.status = 1)";
		    }else{
			$criteria .= " AND (SalonService.service_id =null)";
		    }
		} else if($search_type == 'home_page'){
		    
		    if(!empty($this->request->data['hm_search'])){
			$service = $this->request->data['hm_search'];
		    }
		    //echo $service_name_arr = explode(' ',$service);
		    
		    //    $ser_criteria = '';
		    //    if(!empty($service_name_arr)){
		    //	foreach($service_name_arr as $service_name){
		    //	    if(empty($ser_criteria)){
		    //		$ser_criteria = 'Service.eng_name LIKE "%'.$service_name.'%"';
		    //	    } else {
		    //		$ser_criteria = $ser_criteria.' OR Service.eng_name LIKE "%'.$service_name.'%"';
		    //	    }
		    //	}
		    //    }
		    //echo $service;
		     $ser_criteria = "( (Service.eng_name LIKE '$service') AND parent_id is NOT NULL and parent_id != 0 and parent_id NOT IN(select id from services where parent_id  = 0) and Service.status = 1 and Service.is_Deleted = 0)";
		    
		    $cat_criteria = "( (Service.eng_name LIKE '$service') AND parent_id IN(select id from services where parent_id  = 0 and status = 1 and is_deleted = 0) and Service.status = 1 and Service.is_deleted = 0)";
		    
		   // $ser_criteria = 'Service.eng_name LIKE "%'.$service.'%"';
		    
		   // echo $ser_criteria;
		    
		    $cat_list = $this->Service->find('first', array(
				'fields'=> array('id','parent_id'),
				'conditions' => array(
				    $cat_criteria   
				)
		    ));
		   
		   
		   
		    //pr($services_list);
		    //exit;
		    $services_list_str = '';
		    
		    if(!empty($cat_list)){
			 $services_list_str = $cat_list['Service']['id'];
			
				$this->request->data['category'] = $type_id = $services_list_str;
				//$this->request->data['typeId'] = 10;
				$this->request->data['type_of_search'] = $search_type = 5;
				$this->request->data['search'] = $service;
			
		    }else{
			//echo "hhh";
			//exit;
			 $ser_list = $this->Service->find('first', array(
				'fields'=> array('id','parent_id'),
				'conditions' => array(
				    $ser_criteria   
				)
			));
			if(!empty($ser_list)){
			    $services_list_str = $ser_list['Service']['id'];
			    $parent_id = $ser_list['Service']['parent_id'];
			    $this->request->data['serviceCategoryId'] = $type_id = $parent_id;
			    $this->request->data['newservice'] = $services_list_str;
			    $this->request->data['type_of_search'] = $search_type = 1;
			    $this->request->data['search'] = $service;
			   
			}
			
		    }
		   
		    if(empty($cat_list) && empty($ser_list)){
			
			 $catSer_criteria = "( (Service.eng_name LIKE '$service') AND parent_id != 0 and Service.status = 1 and Service.is_deleted = 0)";
			   $cat_ser_list = $this->Service->find('first', array(
				'fields'=> array('id'),
				'conditions' => array(
				    $catSer_criteria   
				)
		    ));
			   if(!empty($cat_ser_list)){
			    $services_list_str = implode($cat_ser_list);
			   }
		    }
		   
		    if(!empty($services_list_str)) {
			$criteria .= " AND (SalonService.service_id IN($services_list_str))";
		    }
		}
	    }
	     
	   //echo $criteria;
	 //   exit;
	   // pr($this->request->data);
	   // exit;
	    $this->set(compact('service_id'));
	    $this->set(compact('type_id'));
	    $this->set(compact('search_type'));
	    if(isset($this->request->data['sold_as']) && $this->request->data['sold_as'] !=""){
		$sold = $this->request->data['sold_as'];
		if($sold == 1){
		    $criteria .= " AND (PolicyDetails.enable_online_booking = 1)";
		}if($sold == 2){
		    $criteria .= " AND (PolicyDetails.enable_gfvocuher = 1)";
		}if($sold == 3){
		    $criteria .= " AND (SalonOutcallConfiguration.mandatory= 1)";
		}
	    }
	   
	    //max price range
	    if(isset($this->request->data['i_want']) && $this->request->data['i_want'] !=""){
		$iWant = $this->request->data['i_want'];
		if($iWant == "package"){
		    $this->loadModel('Package');
		    $getuserIdPkgService = $this->Package->find('list',array('conditions'=>array('type'=>'package','status'=>1,'is_deleted'=>0),'fields'=>array('user_id'),'group'=>'user_id'));
		}
		if($iWant == "spaday"){
		    $this->loadModel('Package');
		    $spa_conditions =  array('type'=>'Spaday',
			'status'=>1,
			'is_deleted'=>0);
			$getuserIdPkgService = $this->Package->find('list',
			array(
			    'conditions'=>$spa_conditions,
			    'fields'=>array('user_id'),
			    'group'=>'user_id')
			);
		    $is_salon_spaday = 1;
		}
		if($iWant == "deal"){
		    $this->loadModel('Deal');
		    $getuserIdDealService = $this->Deal->find('list',array('conditions'=>array('status'=>1,'is_deleted'=>0),'fields'=>array('salon_id'),'group'=>'salon_id'));
		}
	    }
	    //min price range
	    /*if(isset($this->request->data['min_price']) && $this->request->data['min_price'] !=""){
		$minPrice = $this->request->data['min_price'];
		$maxPrice = $this->request->data['max_price'];
		$criteria .= " AND (
				    (CASE
					WHEN ServicePricingOptions.sell_price is not null
					THEN
					    (ServicePricingOptions.sell_price >= $minPrice
						OR ServicePricingOptions.sell_price <= $maxPrice )
					ELSE (ServicePricingOptions.full_price >= $minPrice
					    OR ServicePricingOptions.full_price <= $maxPrice) END)
				OR (
				    DealServicePackagePriceOption.deal_price >= $minPrice AND
				    DealServicePackagePriceOption.deal_price <= $maxPrice
				)
				OR (
				    PackagePricingOption.price >= $minPrice AND
				    PackagePricingOption.price <= $maxPrice
				)
				
			    )";
	    }*/
	    //service to (salon type)
	    if(isset($this->request->data['service_to']) && $this->request->data['service_to'] !=""){
		    $seviceTo = trim($this->request->data['service_to']);
		    $criteria .= " AND (Salon.service_to LIKE '%".$seviceTo."%')";
	    }
	    
	    if(isset($this->request->data['sort_by']) &&  ($this->request->data['sort_by']!='')){
		if($this->request->data['sort_by']=='DESC'){
		    $order = 'User.created DESC';
		} if($this->request->data['sort_by']=='ASC'){
		    $order = 'User.created ASC';
		}/*if($this->request->data['sort_by']=='RatingASC'){
		    $order = 'ReviewRating.venue_rating ASC';
		}if($this->request->data['sort_by']=='RatingDESC'){
		    $order = 'ReviewRating.venue_rating DESC';
		}*/
	    }
	    
	    if(isset($this->request->data['select_date']) && $this->request->data['select_date'] !=""){
		$day =  strtolower(date('D',strtotime($this->request->data['select_date'])));
		$criteria .= " AND (SalonOpeningHour.is_checked_disable_$day)";
	    }
	    if(isset($this->request->data['select_time']) && $this->request->data['select_time'] !=""){
		$date = $this->request->data['select_date'];
		if(!$date){
		    $date = date("d-m-Y");
		}
		$dayTime =  strtolower(date('l',strtotime($date)));
		$time = $this->request->data['select_time'];
		$criteria .=" AND '$time' BETWEEN  (SalonOpeningHour.$dayTime"."_from) AND (SalonOpeningHour.$dayTime"."_to)";
	    }
	    // if ( empty($this->passedArgs['search']) ){
		$this->passedArgs['search'] = $this->request->data;
	   // }
	    //pr($this->passedArgs['search']);
	    //exit;
	}
	$this->set(compact('service_category_id'));
	
	//SERVICES CHECK ENDS HERE
	//echo $criteria;exit;
	// Get userids from location, country,sallon name,business type checks
	//echo $criteria;
	//exit;
	 //echo $criteria;
	// exit;
	    $usetIdsArray = $this->User->query(
		"SELECT Address.user_id from addresses as Address
		    INNER JOIN users as User ON Address.user_id = User.id
		    INNER JOIN salons as Salon ON Address.user_id = Salon.user_id
		    INNER JOIN salon_services as SalonService ON SalonService.salon_id = User.id
		    INNER JOIN services as Service ON Service.id = SalonService.service_id
		    LEFT JOIN policy_details as PolicyDetails ON PolicyDetails.user_id = User.id
		    LEFT JOIN salon_outcall_configurations as SalonOutcallConfiguration ON SalonOutcallConfiguration.user_id = User.id
		    LEFT JOIN salon_opening_hours as SalonOpeningHour ON Address.user_id = SalonOpeningHour.user_id WHERE $criteria group by Address.user_id");
	   
	//pr($usetIdsArray); 
	if(!empty($usetIdsArray)){
	    foreach($usetIdsArray as $usersId){
		    $finalIds[] = $usersId['Address']['user_id'];
	    }
	}
	
	
	//GET COMMON FROM $usetIdsArray AND $userIdFrmServices
	if(isset($userIdServices) && !empty($userIdServices)){
	    if(!empty($finalIds)){
		$finalIds = array_unique($finalIds);
	    }
	    if(!empty($userIdServices)){
		$userIdServices = array_unique($userIdServices);
	    }
	    if(!empty($finalIds) && !empty($userIdServices))
		$finalResult = array_intersect($finalIds, $userIdServices);
	    else if(!empty($finalIds) && empty($userIdServices))
		$finalResult = $finalIds;
	    else if(empty($finalIds) && !empty($userIdServices))
		$finalResult = $userIdServices;
	    else
		$finalResult = array();
	}else{
	    if(!empty($finalIds))
		$finalIds = array_unique($finalIds);
	    if(!empty($finalIds))
		$finalResult = $finalIds;
	    else
		$finalResult = array();
	}
	//
	//
	if(isset($userIdFrmtreatment) && !empty($userIdFrmtreatment)){
	    $finalResult = array_unique($finalResult);
	    $userIdFrmtreatment = array_unique($userIdFrmtreatment);
	    $finalResult = array_intersect($finalResult, $userIdFrmtreatment);
	}else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	
	if((isset($getuserIdPkgService) && !empty($getuserIdPkgService))){
	    $finalResult = array_unique($finalResult);
	    $getuserIdPkgService = array_unique($getuserIdPkgService);
	    $finalResult = array_intersect($finalResult, $getuserIdPkgService);
	} /*else if(($is_salon_spaday == 1 && empty($getuserIdPkgService))){
	    $finalResult = array();
	}*/else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	
	
	if(isset($getuserIdDealService) && !empty($getuserIdDealService)){
	    $finalResult = array_unique($finalResult);
	    $getuserIdDealService = array_unique($getuserIdDealService);
	    $finalResult = array_intersect($finalResult, $getuserIdDealService);
	}else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	if(isset($datamin) && !empty($datamin)){
	    $finalResult = array_unique($finalResult);
	    $datamin = array_unique($datamin);
	    $finalResult = array_intersect($finalResult, $datamin);
	}else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	if(isset($datamax) && !empty($datamax)){
	    $finalResult = array_unique($finalResult);
	    $datamax = array_unique($datamax);
		$finalResult = array_intersect($finalResult, $datamax);
	}else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	
	
	$fields = array('User.id','User.username', 'Salon.eng_name','Salon.cover_image', 'Salon.ara_name','Salon.email','Salon.eng_description','Salon.business_url', 'Salon.ara_description',/*'VenueImages.image',*/
			'Address.latitude','Address.city_id','Address.state_id','Address.longitude','Address.address','City.city_name','State.name'/*'SalonService.id','Service.eng_name','SalonService.outcall_service','FacilityDetail.*','SalonServiceDetail.sold_as',
			'ServicePricingOptions.full_price','ServicePricingOptions.sell_price'*/
	    );
	
	$pageConditions = array('User.id'=>$finalResult,'User.front_display' => 1 , 'User.status' => 1 , 'User.front_display' => 1 ,'User.is_deleted' =>0 , 'User.is_email_verified'=>1 ,'User.is_phone_verified' => 1);
	 
	//pr($pageConditions);
	$this->Paginator->settings = array('conditions' => $pageConditions,
	    'limit' =>10,
	    'recursive'=>1, // should be used with joins
	    'fields' => $fields,
	    'joins' => array(
			    array(
				'table' => 'cities',
				'alias' => 'City',
				'type' => 'left',
				'conditions' => array(
				    'Address.city_id= City.id'
				)
			    ),
			    array(
				'table' => 'states',
				'alias' => 'State',
				'type' => 'left',
				'conditions' => array(
				    'Address.state_id= State.id'
				)
			    )
			     
			    ),
	    'order' => $order,
	    'group' =>array(
		    'User.id'
	    )
        );
	
	
	//echo $criteriaCommon; exit;
    $this->User->unbindModel(array('hasMany'=>array('PricingLevelAssigntoStaff')));
	$userdata = $this->User->find('all', array('fields'=>array('User.id','Address.latitude','Address.longitude','Address.address','Salon.eng_name','Salon.ara_name','Salon.eng_description','Salon.ara_description','Salon.logo'),'conditions' => $pageConditions));
	//pr($userdata);
	//exit;
	
	if(!empty($userdata)){
	    $chklang = Configure::read('Config.language');
	    foreach($userdata as $val){
		if(!empty($val['Address']['latitude']) && !empty($val['Address']['longitude'])){
		    $locations[] = '["'.$val['Address']['address'].'",'.$val['Address']['latitude'].','.$val['Address']['longitude'].']';
		    $imgPath = "/images/".$val['User']['id']."/User/150/".$val['Salon']['logo'];
		    $salName =  $val['Salon']['eng_name'];
		    if($chklang == 'ara'){
			    if($val['Salon']['ara_name'] !=''){
				    $salName =  $val['Salon']['ara_name'];
			    }
		    }
		    
		    $salDesp =  $val['Salon']['eng_description'];
		    if($chklang == 'ara'){
			    if($val['Salon']['ara_description'] !=''){
				    $salDesp =  $val['Salon']['ara_description'];
			    }
		    }
		    if(strlen($salDesp) > 45){
			$salDesp = substr($salDesp, 0, 45)."...."; 
		    }
		    
		    $salURL = Router::url(array('controller' => 'Place', 'action' => 'index','admin'=>false,$val['User']['id']),true);
		    $information[] = '["<div class=\"info-window\"><div class=\"pull-left\"><img alt=\" \" src=\"'.$imgPath.'\"></div><div class=\"lft-space\"><h4><a href=\"'.$salURL.'\" target=\"_blank\" title=\"'.$salName.'\"> '.$salName.'</a></h4><p>'.$salDesp.'</p><a href=\"'.$salURL.'\" target=\"_blank\" title=\"'.$salName.'\">'.__("more_info",true).' </a></div></div>"]';
		}
	    }
	}
	//pr($locations);pr($information);
	if(!empty($locations)){
	   $loc =  implode(',',$locations);
	   $info = implode(',',$information);
	}
	
	//Get user data
	$this->set('getData',$this->Paginator->paginate('User'));
	$getTreatmentTypes = array();
	//$getTreatmentTypes = $this->Service->find('list',array('conditions'=> array('Service.parent_id' =>'0','Service.is_deleted'=>0)));
	
	$this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
	$getTreatment = array();
	if(!empty($getTreatmentTypes)){
	    foreach($getTreatmentTypes as $key => $service){
			
		$getTreatment[$key] = 	$this->Service->query("SELECT Service.* FROM `services` as Service where parent_id = $service AND is_deleted=0" ) ;
               //$getTreatment[$key] = $this->Service->find('all',array('conditions'=> array('Service.parent_id' => $service,'Service.is_deleted'=>0)));
	    }
	}

$treat = $this->Service->query("SELECT `Service`.`id`, `Service`.`parent_id`,`Service`.`eng_name`,`Service`.`eng_display_name` FROM `services` AS `Service` where parent_id IN(select id from services where parent_id  = 0 and status = 1 and is_deleted = 0) and `Service`.`status` = 1 and `Service`.`is_deleted` = 0 ");
//   LIMIT 1

//$getTreatment = array();


	
	//$log = $this->Service->getDataSource()->getLog(false, false);
		  //  pr($log);
		  //  exit;
		    
	$countryData = $this->Common->getCountryStates();
	$theCity = array();
	
	foreach($countryData as $country){
	    if(!empty($country['State'])){
		foreach($country['State'] as $thecty){
		    $theCity[$thecty['id']] = "<span class='ctyName' data-cntyN='".$country['Country']['title']."' data-country='".$country['Country']['id']."' >{$thecty['name']}</span>";
		}
	    }
	}
	$this->set('menuActive','home');
	$this->set('showSmallSearch',true);
	$this->set(compact('theCity','loc','info','getTreatment','countryId','loc1','location','city_id','treat'));
	
	
	$services_html = '';
	//pr($this->request->data);
	//exit;

	if(!empty($this->request->data['service_parent'])){
	   
	    if(!empty($cat)){
		if(!empty($this->request->data['select_all']))
		    $services_html = $this->getservice($this->request->data['service_parent'],$cat,$this->request->data['select_all'],$allunset);
		else
		    $services_html = $this->getservice($this->request->data['service_parent'],$cat,'',$allunset);
	    } else {
		$services_html = $this->getservice($this->request->data['service_parent'],'','',$allunset);
	    }
	}
	$this->set(compact('services_html','allunset'));
	
	if($this->RequestHandler->isAjax()){
	    $this->layout='ajax';	    
	    $this->viewPath = "Search";
	    $this->render('index');
	}
    }
    

	
  
  
   public function indexnew($location = null,$salon_type = null,$available_date = null,$treatment = null , $service_type_id = null) {
	
	$i_want_spaday = null;
	$i_want_val = null;
	$service = '';
	$service_to = '';
	$salon = '';
	if($location == ''){
	    $this->redirect(array('controller'=>'homes','action'=>'index'));
	}
	$this->layout = "search";
	
	if(!empty($salon_type) &&($salon_type == 'spaday') && empty($this->request->data)){
	    $spay_day_type = $salon_type;
	    $salon_type = 'serviceTo';
	    
	    if(!empty($spay_day_type) && ($spay_day_type == 'spaday')){
		$this->request->data['i_want'] = $spay_day_type;
		$split_location = explode('~',$location);
		$i_want_val = @$this->request->data['i_want'];
		if(!empty($split_location)){
		    if(!empty($split_location[0])){
			$country = $split_location[0];
			$country = str_replace('-',' ',$country);
			//GET COUNTRY ID FROM NAME
			$country_id = $this->get_element_id('Country',$country);
			$this->request->data['country_id'] = $country_id;
		    }
		    if(!empty($split_location[1])){
			$country = $split_location[1];
			$city = str_replace('-',' ',$country);
			//GET COUNTRY ID FROM NAME
			$state_id = $this->get_element_id('State',$city);
			$this->request->data['state_id'] = $state_id;
		    }
		}
	    }
	}
	
	$this->set('i_want_val',$i_want_val);
	$SessionLang = $this->Session->read('Config.language');
	if($SessionLang == ""){
	    $SessionLang = 'eng';
	}
	$post = $countryId = $info = $countryData = $loc = '';
	$locations = $information = $getTreatment = $getTreat = array();
	$loc1 = "";
	$serviceData = array(); $finalIds= array();
	$userIdFrmTreatmentServices= "";
	$userIdServices = array(); $userIdFrmtreatment = array();
	
	// Common criteria
	$criteria = 'User.type IN (3,4) and User.status = 1 and User.front_display = 1 and User.is_deleted =0 and User.is_email_verified = 1  and User.is_phone_verified = 1';
	$criteriaCommon ='User.type IN (3,4) and User.status = 1 and User.front_display = 1 and User.is_deleted =0 and User.is_email_verified = 1 and User.is_phone_verified = 1';
	$criteria1="";
	$service_type = '';
	
	// LOCATION CHECK STARTS HERE
	$country_id = $state_id = $city_id = $service_category_id = '';
	$s_ids = '';
	$order= 'User.created DESC';
	$this->loadModel('SalonService');
	
	if(!empty($service_type_id)){
	    if(!empty($service_type)){
		$s_ids = implode(',',$service_type);
	    }
	}
	//echo $location;
	
	if(($location != '') && (empty($this->request->data))){
	    $split_location = explode('~',$location);
	   // pr($split_location);
	    if(!empty($split_location)){
		if(!empty($split_location[0])){
		    $country = $split_location[0];
		    $country = str_replace('-',' ',$country);
		    //GET COUNTRY ID FROM NAME
		    $country_id = $this->get_element_id('Country',$country);
		}
		if(!empty($split_location[1]) && ($split_location[1] != "All-Cities")){
		    $state = $split_location[1];
		    $state = str_replace('-',' ',$state);
		    //GET STATE ID FROM NAME
		    $state_id = $this->get_element_id('State',$state);
		}
		if(!empty($split_location[2])){
		      $city = $split_location[2];
		     $loc1 = $city = str_replace('-',' ',$city);
		    //GET CITY ID FROM NAME
		     $city_id = $this->get_element_id('City',$city);
		   
		}
	    }
	    //pr($country_id);
	   // pr($state_id);
	    //pr($city_id);
	    // CRITERIA FOR COUNTRY STATE AND CITY
	    if(!empty($country_id)){
		$criteria .= " AND (Address.country_id = '".$country_id."')";
	    }
	    if(!empty($state_id)){
		$criteria .= " AND (Address.state_id = '".$state_id."')";
		$this->set(compact('state_id'));
	    }
	    if(!empty($city_id)){
		$criteria .= " AND (Address.city_id = '".$city_id."')";
		
	    }
	}
	
	// LOCATION CHECK ENDS HERE
	
	
	// DATE CHECK TO GET AVIALABLITY OF SALOON
	if($available_date !='' && (empty($this->request->data))){
	    $day = date('D', strtotime($available_date));
	    $day = strtolower($day);
	    $fieldName = "is_checked_disable_".$day;
	}
	// DATE CHECK TO GET AVIALABLITY OF SALOON(ENDS HERE)
	
	//SALON TYPE CHECK (business type)
	if($salon_type != '' && $salon_type != 'serviceTo' && (empty($this->request->data))){
	    $service_to = $salon_type;
	} 
	//SALON TYPE CHECK (business type) ENDS HERE
	
	//SERVICES CHECK and saloon name check (for eg: serices ~ saloon)
	
	if(empty($this->request->data['search']) && !empty($this->request->data['hm_search'])){
	    $treatment = $this->request->data['search'] = $this->request->data['hm_search'];
	}
	
	
	if($treatment != '' && (empty($this->request->data))){
	    $treatment_explode = explode('~',$treatment);
	    if(!empty($treatment_explode)){
		$service = $treatment_explode[0];
	    }
	    if($service !=''){
		$service = str_replace('-',' ',$service);
		    $criteria1 .= "( (Service.eng_name LIKE '%$service%' OR Service.ara_name LIKE '%$service%' ) AND parent_id is NOT NULL)";
		if($criteria1 !=""){
		    // Get userids from 
		    $serviceData  = $this->Service->find('list',array('conditions'=>array($criteria1),'fields'=>array('id')));
		}
		
		$serviceData = '';
		if(!empty($serviceData)){
		    // to do yet
		    $serviceIDs = $this->Common->getServiceFromId($serviceData);
		    
		    $this->loadModel('SalonService');
		    $userIdFrmServices = $this->SalonService->find('all',array('conditions'=>array('service_id'=>$serviceData),'fields'=>array('salon_id'),'recursive'=>-1));
		    foreach($userIdFrmServices as $usersId){
			$userIdServices[] = $usersId['SalonService']['salon_id'];
		    }
		}else{
		    
		    //pr($this->Common->getServiceidsNew($service));
		    //exit;
		    
		}
	    }
	    
	    if(isset($treatment_explode[1])){
		$salonName = $treatment_explode[1];
		$salon = str_replace('-',' ',$salonName);
		$criteria .= " AND (Salon.eng_name LIKE '%$salon%' OR Salon.ara_name LIKE '%$salon%')";
	
	    }
	   	 
	}elseif(isset($this->request->data['salon_name']) && !empty($this->request->data['salon_name'])){
//die("2");
	     $salon = $this->request->data['salon_name'];
	     $salon = str_replace('-',' ',$salon);
	     $salon=trim($salon);
	     $criteria .= " AND (Salon.eng_name LIKE '%$salon%' OR Salon.ara_name LIKE '%$salon%')";
   	     $this->request->data['salon_name'] = '';
	}

	//echo $criteria;
	//print_r($this->request->data);
	if(empty($this->request->data)) {
	    
	    $this->request->data['country_id'] = $country_id;
	    $this->request->data['User']['country_id'] = $this->request->data['state_id'] = $state_id;
	    $this->request->data['loc'] = $this->request->data['city_id'] = $city_id;
	    $this->set(compact('loc1'));
	    $this->request->data['search'] = $service;
	    $this->request->data['hm_search'] = $service;
	    $this->request->data['service_to'] = $service_to;
	    $this->request->data['salon'] = $salon;
	    $this->request->data['type_of_search'] = 'home_page';
	    $this->request->data['newservice'] = '';
	}
	
	if(isset($salonName) && !empty($salonName)){
	    $this->request->data['salon_name'] = $salonName;
	}
//pr( $this->request->data);
	if(isset($city_id) && !empty($city_id)){
	     $this->request->data['locationCity'] = $city_id;
	}
    
	if ((isset($this->passedArgs['search'])) ){
	    $this->request->data = $this->passedArgs['search'];
	}
	if(isset($this->request->data) && !empty($this->request->data)){
	   
	    $loc = @$this->request->data['User']['country_id'];
	    $city = @$this->request->data['loc'];
	    $area = @$this->request->data['city'];
	    $service_id = '';
	    $type_id ='';
		//echo 'ff'.$city.'dd';
	    if($loc != ''){
		$criteria .= " AND (Address.state_id = ".$loc.")";
	    }
	    if(!empty($city)){
		$criteria .= " AND (Address.city_id = '".$city."')";
		$this->request->data['locationCity'] = $city;
	    }
	    
	    if(isset($this->request->data['search'])){
		//pr($this->request->data);
		 //exit;
	    
		$search = $this->request->data['search'];
		$search_type=$this->request->data['type_of_search'];
		
		if($search_type == 2){
		    $criteria .= " AND (Salon.eng_name LIKE'%".TRIM($this->request->data['search'])."%')";
		}
		if($search_type == 1){
		    $service_id = $this->Common->getServiceids($this->request->data['search']);
		    if($this->request->data['newservice']){
			    $service_id = $this->request->data['newservice'];
		    }
		    $service_category_id = $this->Common->get_service_category($service_id);
		    $criteria .= " AND (SalonService.service_id = $service_id AND SalonService.status = 1)";
		    /*** Categories Search ****/
		}
		if($search_type == 4){
		    /*** Service Search ****/
		    $criteria .= " AND (Address.city_id = $area)";
		    /*** Service Search ****/
		}
		if($search_type == 5){
		    
		    /*** Category Search ****/
			$type_id = $this->request->data['category'];
			$cat = $this->Common->getcategory($this->request->data['category']);
			
			$allunset = 'false';
			if(!empty($this->request->data['service_parent'])){
			    if(!isset($this->request->data['service_id'])){
				$allunset = 'true';
			    }
			}
			// For treatment search left Side
			if(isset($this->request->data['service_id']) && !empty($this->request->data['service_id'])){
			    $cat = $this->request->data['service_id'];
			    $service_id = implode(",", $cat);
			    //$search_type = 1;
			    unset($this->request->data['service_id']);
			}
		    if(!empty($cat)){
			$s_ids = implode(',',$cat);
			$criteria .= " AND (SalonService.service_id IN($s_ids) AND SalonService.status = 1)";
		    }else{
			$criteria .= " AND (SalonService.service_id =null)";
		    }
		} else if($search_type == 'home_page'){
		    
		    if(!empty($this->request->data['hm_search'])){
			$service = $this->request->data['hm_search'];
		    }
		    //echo $service_name_arr = explode(' ',$service);
		    
		    //    $ser_criteria = '';
		    //    if(!empty($service_name_arr)){
		    //	foreach($service_name_arr as $service_name){
		    //	    if(empty($ser_criteria)){
		    //		$ser_criteria = 'Service.eng_name LIKE "%'.$service_name.'%"';
		    //	    } else {
		    //		$ser_criteria = $ser_criteria.' OR Service.eng_name LIKE "%'.$service_name.'%"';
		    //	    }
		    //	}
		    //    }
		    //echo $service;
		     $ser_criteria = "( (Service.eng_name LIKE '$service') AND parent_id is NOT NULL and parent_id != 0 and parent_id NOT IN(select id from services where parent_id  = 0) and Service.status = 1 and Service.is_Deleted = 0)";
		    
		    $cat_criteria = "( (Service.eng_name LIKE '$service') AND parent_id IN(select id from services where parent_id  = 0 and status = 1 and is_deleted = 0) and Service.status = 1 and Service.is_deleted = 0)";
		    
		   // $ser_criteria = 'Service.eng_name LIKE "%'.$service.'%"';
		    
		   // echo $ser_criteria;
		    
		    $cat_list = $this->Service->find('first', array(
				'fields'=> array('id','parent_id'),
				'conditions' => array(
				    $cat_criteria   
				)
		    ));
		   
		   
		   
		    //pr($services_list);
		    //exit;
		    $services_list_str = '';
		    
		    if(!empty($cat_list)){
			 $services_list_str = $cat_list['Service']['id'];
			
				$this->request->data['category'] = $type_id = $services_list_str;
				//$this->request->data['typeId'] = 10;
				$this->request->data['type_of_search'] = $search_type = 5;
				$this->request->data['search'] = $service;
			
		    }else{
			//echo "hhh";
			//exit;
			 $ser_list = $this->Service->find('first', array(
				'fields'=> array('id','parent_id'),
				'conditions' => array(
				    $ser_criteria   
				)
			));
			if(!empty($ser_list)){
			    $services_list_str = $ser_list['Service']['id'];
			    $parent_id = $ser_list['Service']['parent_id'];
			    $this->request->data['serviceCategoryId'] = $type_id = $parent_id;
			    $this->request->data['newservice'] = $services_list_str;
			    $this->request->data['type_of_search'] = $search_type = 1;
			    $this->request->data['search'] = $service;
			   
			}
			
		    }
		   
		    if(empty($cat_list) && empty($ser_list)){
			
			 $catSer_criteria = "( (Service.eng_name LIKE '$service') AND parent_id != 0 and Service.status = 1 and Service.is_deleted = 0)";
			   $cat_ser_list = $this->Service->find('first', array(
				'fields'=> array('id'),
				'conditions' => array(
				    $catSer_criteria   
				)
		    ));
			   if(!empty($cat_ser_list)){
			    $services_list_str = implode($cat_ser_list);
			   }
		    }
		   
		    if(!empty($services_list_str)) {
			$criteria .= " AND (SalonService.service_id IN($services_list_str))";
		    }
		}
	    }
	     
	   //echo $criteria;
	 //   exit;
	   // pr($this->request->data);
	   // exit;
	    $this->set(compact('service_id'));
	    $this->set(compact('type_id'));
	    $this->set(compact('search_type'));
	    if(isset($this->request->data['sold_as']) && $this->request->data['sold_as'] !=""){
		$sold = $this->request->data['sold_as'];
		if($sold == 1){
		    $criteria .= " AND (PolicyDetails.enable_online_booking = 1)";
		}if($sold == 2){
		    $criteria .= " AND (PolicyDetails.enable_gfvocuher = 1)";
		}if($sold == 3){
		    $criteria .= " AND (SalonOutcallConfiguration.mandatory= 1)";
		}
	    }
	   
	    //max price range
	    if(isset($this->request->data['i_want']) && $this->request->data['i_want'] !=""){
		$iWant = $this->request->data['i_want'];
		if($iWant == "package"){
		    $this->loadModel('Package');
		    $getuserIdPkgService = $this->Package->find('list',array('conditions'=>array('type'=>'package','status'=>1,'is_deleted'=>0),'fields'=>array('user_id'),'group'=>'user_id'));
		}
		if($iWant == "spaday"){
		    $this->loadModel('Package');
		    $spa_conditions =  array('type'=>'Spaday',
			'status'=>1,
			'is_deleted'=>0);
			$getuserIdPkgService = $this->Package->find('list',
			array(
			    'conditions'=>$spa_conditions,
			    'fields'=>array('user_id'),
			    'group'=>'user_id')
			);
		    $is_salon_spaday = 1;
		}
		if($iWant == "deal"){
		    $this->loadModel('Deal');
		    $getuserIdDealService = $this->Deal->find('list',array('conditions'=>array('status'=>1,'is_deleted'=>0),'fields'=>array('salon_id'),'group'=>'salon_id'));
		}
	    }
	    //min price range
	    /*if(isset($this->request->data['min_price']) && $this->request->data['min_price'] !=""){
		$minPrice = $this->request->data['min_price'];
		$maxPrice = $this->request->data['max_price'];
		$criteria .= " AND (
				    (CASE
					WHEN ServicePricingOptions.sell_price is not null
					THEN
					    (ServicePricingOptions.sell_price >= $minPrice
						OR ServicePricingOptions.sell_price <= $maxPrice )
					ELSE (ServicePricingOptions.full_price >= $minPrice
					    OR ServicePricingOptions.full_price <= $maxPrice) END)
				OR (
				    DealServicePackagePriceOption.deal_price >= $minPrice AND
				    DealServicePackagePriceOption.deal_price <= $maxPrice
				)
				OR (
				    PackagePricingOption.price >= $minPrice AND
				    PackagePricingOption.price <= $maxPrice
				)
				
			    )";
	    }*/
	    //service to (salon type)
	    if(isset($this->request->data['service_to']) && $this->request->data['service_to'] !=""){
		    $seviceTo = trim($this->request->data['service_to']);
		    $criteria .= " AND (Salon.service_to LIKE '%".$seviceTo."%')";
	    }
	    
	    if(isset($this->request->data['sort_by']) &&  ($this->request->data['sort_by']!='')){
		if($this->request->data['sort_by']=='DESC'){
		    $order = 'User.created DESC';
		} if($this->request->data['sort_by']=='ASC'){
		    $order = 'User.created ASC';
		}/*if($this->request->data['sort_by']=='RatingASC'){
		    $order = 'ReviewRating.venue_rating ASC';
		}if($this->request->data['sort_by']=='RatingDESC'){
		    $order = 'ReviewRating.venue_rating DESC';
		}*/
	    }
	    
	    if(isset($this->request->data['select_date']) && $this->request->data['select_date'] !=""){
		$day =  strtolower(date('D',strtotime($this->request->data['select_date'])));
		$criteria .= " AND (SalonOpeningHour.is_checked_disable_$day)";
	    }
	    if(isset($this->request->data['select_time']) && $this->request->data['select_time'] !=""){
		$date = $this->request->data['select_date'];
		if(!$date){
		    $date = date("d-m-Y");
		}
		$dayTime =  strtolower(date('l',strtotime($date)));
		$time = $this->request->data['select_time'];
		$criteria .=" AND '$time' BETWEEN  (SalonOpeningHour.$dayTime"."_from) AND (SalonOpeningHour.$dayTime"."_to)";
	    }
	    // if ( empty($this->passedArgs['search']) ){
		$this->passedArgs['search'] = $this->request->data;
	   // }
	    //pr($this->passedArgs['search']);
	    //exit;
	}
	$this->set(compact('service_category_id'));
	
	//SERVICES CHECK ENDS HERE
	//echo $criteria;exit;
	// Get userids from location, country,sallon name,business type checks
	//echo $criteria;
	//exit;
	 //echo $criteria;
	// exit;
	    $usetIdsArray = $this->User->query(
		"SELECT Address.user_id from addresses as Address
		    INNER JOIN users as User ON Address.user_id = User.id
		    INNER JOIN salons as Salon ON Address.user_id = Salon.user_id
		    INNER JOIN salon_services as SalonService ON SalonService.salon_id = User.id
		    INNER JOIN services as Service ON Service.id = SalonService.service_id
		    LEFT JOIN policy_details as PolicyDetails ON PolicyDetails.user_id = User.id
		    LEFT JOIN salon_outcall_configurations as SalonOutcallConfiguration ON SalonOutcallConfiguration.user_id = User.id
		    LEFT JOIN salon_opening_hours as SalonOpeningHour ON Address.user_id = SalonOpeningHour.user_id WHERE $criteria group by Address.user_id");
	   
	//pr($usetIdsArray); 
	if(!empty($usetIdsArray)){
	    foreach($usetIdsArray as $usersId){
		    $finalIds[] = $usersId['Address']['user_id'];
	    }
	}
	
	
	//GET COMMON FROM $usetIdsArray AND $userIdFrmServices
	if(isset($userIdServices) && !empty($userIdServices)){
	    if(!empty($finalIds)){
		$finalIds = array_unique($finalIds);
	    }
	    if(!empty($userIdServices)){
		$userIdServices = array_unique($userIdServices);
	    }
	    if(!empty($finalIds) && !empty($userIdServices))
		$finalResult = array_intersect($finalIds, $userIdServices);
	    else if(!empty($finalIds) && empty($userIdServices))
		$finalResult = $finalIds;
	    else if(empty($finalIds) && !empty($userIdServices))
		$finalResult = $userIdServices;
	    else
		$finalResult = array();
	}else{
	    if(!empty($finalIds))
		$finalIds = array_unique($finalIds);
	    if(!empty($finalIds))
		$finalResult = $finalIds;
	    else
		$finalResult = array();
	}
	//
	//
	if(isset($userIdFrmtreatment) && !empty($userIdFrmtreatment)){
	    $finalResult = array_unique($finalResult);
	    $userIdFrmtreatment = array_unique($userIdFrmtreatment);
	    $finalResult = array_intersect($finalResult, $userIdFrmtreatment);
	}else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	
	if((isset($getuserIdPkgService) && !empty($getuserIdPkgService))){
	    $finalResult = array_unique($finalResult);
	    $getuserIdPkgService = array_unique($getuserIdPkgService);
	    $finalResult = array_intersect($finalResult, $getuserIdPkgService);
	} /*else if(($is_salon_spaday == 1 && empty($getuserIdPkgService))){
	    $finalResult = array();
	}*/else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	
	
	if(isset($getuserIdDealService) && !empty($getuserIdDealService)){
	    $finalResult = array_unique($finalResult);
	    $getuserIdDealService = array_unique($getuserIdDealService);
	    $finalResult = array_intersect($finalResult, $getuserIdDealService);
	}else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	if(isset($datamin) && !empty($datamin)){
	    $finalResult = array_unique($finalResult);
	    $datamin = array_unique($datamin);
	    $finalResult = array_intersect($finalResult, $datamin);
	}else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	if(isset($datamax) && !empty($datamax)){
	    $finalResult = array_unique($finalResult);
	    $datamax = array_unique($datamax);
		$finalResult = array_intersect($finalResult, $datamax);
	}else{
	    $finalResult = array_unique($finalResult);
	    $finalResult = $finalResult;
	}
	
	
	$fields = array('User.id','User.username', 'Salon.eng_name','Salon.cover_image', 'Salon.ara_name','Salon.email','Salon.eng_description','Salon.business_url', 'Salon.ara_description',/*'VenueImages.image',*/
			'Address.latitude','Address.city_id','Address.state_id','Address.longitude','Address.address','City.city_name','State.name'/*'SalonService.id','Service.eng_name','SalonService.outcall_service','FacilityDetail.*','SalonServiceDetail.sold_as',
			'ServicePricingOptions.full_price','ServicePricingOptions.sell_price'*/
	    );
	
	$pageConditions = array('User.id'=>$finalResult,'User.front_display' => 1 , 'User.status' => 1 , 'User.front_display' => 1 ,'User.is_deleted' =>0 , 'User.is_email_verified'=>1 ,'User.is_phone_verified' => 1);
	 
	//pr($pageConditions);
	$this->Paginator->settings = array('conditions' => $pageConditions,
	    'limit' =>3,
	    'recursive'=>1, // should be used with joins
	    'fields' => $fields,
	    'joins' => array(
			    array(
				'table' => 'cities',
				'alias' => 'City',
				'type' => 'left',
				'conditions' => array(
				    'Address.city_id= City.id'
				)
			    ),
			    array(
				'table' => 'states',
				'alias' => 'State',
				'type' => 'left',
				'conditions' => array(
				    'Address.state_id= State.id'
				)
			    )
			     
			    ),
	    'order' => $order,
	    'group' =>array(
		    'User.id'
	    )
        );
	
	
	//echo $criteriaCommon; exit;
    $this->User->unbindModel(array('hasMany'=>array('PricingLevelAssigntoStaff')));
	$userdata = $this->User->find('all', array('fields'=>array('User.id','Address.latitude','Address.longitude','Address.address','Salon.eng_name','Salon.ara_name','Salon.eng_description','Salon.ara_description','Salon.logo'),'conditions' => $pageConditions));
	//pr($userdata);
	//exit;
	
	if(!empty($userdata)){
	    $chklang = Configure::read('Config.language');
	    foreach($userdata as $val){
		if(!empty($val['Address']['latitude']) && !empty($val['Address']['longitude'])){
		    $locations[] = '["'.$val['Address']['address'].'",'.$val['Address']['latitude'].','.$val['Address']['longitude'].']';
		    $imgPath = "/images/".$val['User']['id']."/User/150/".$val['Salon']['logo'];
		    $salName =  $val['Salon']['eng_name'];
		    if($chklang == 'ara'){
			    if($val['Salon']['ara_name'] !=''){
				    $salName =  $val['Salon']['ara_name'];
			    }
		    }
		    
		    $salDesp =  $val['Salon']['eng_description'];
		    if($chklang == 'ara'){
			    if($val['Salon']['ara_description'] !=''){
				    $salDesp =  $val['Salon']['ara_description'];
			    }
		    }
		    if(strlen($salDesp) > 45){
			$salDesp = substr($salDesp, 0, 45)."...."; 
		    }
		    
		    $salURL = Router::url(array('controller' => 'Place', 'action' => 'index','admin'=>false,$val['User']['id']),true);
		    $information[] = '["<div class=\"info-window\"><div class=\"pull-left\"><img alt=\" \" src=\"'.$imgPath.'\"></div><div class=\"lft-space\"><h4><a href=\"'.$salURL.'\" target=\"_blank\" title=\"'.$salName.'\"> '.$salName.'</a></h4><p>'.$salDesp.'</p><a href=\"'.$salURL.'\" target=\"_blank\" title=\"'.$salName.'\">'.__("more_info",true).' </a></div></div>"]';
		}
	    }
	}
	//pr($locations);pr($information);
	if(!empty($locations)){
	   $loc =  implode(',',$locations);
	   $info = implode(',',$information);
	}
	
	//Get user data
	$this->set('getData',$this->Paginator->paginate('User'));
	$getTreatmentTypes = array();
	//$getTreatmentTypes = $this->Service->find('list',array('conditions'=> array('Service.parent_id' =>'0','Service.is_deleted'=>0)));
	
	$this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
	$getTreatment = array();
	if(!empty($getTreatmentTypes)){
	    foreach($getTreatmentTypes as $key => $service){
			
		$getTreatment[$key] = 	$this->Service->query("SELECT Service.* FROM `services` as Service where parent_id = $service AND is_deleted=0" ) ;
               //$getTreatment[$key] = $this->Service->find('all',array('conditions'=> array('Service.parent_id' => $service,'Service.is_deleted'=>0)));
	    }
	}

$treat = $this->Service->query("SELECT `Service`.`id`, `Service`.`parent_id`,`Service`.`eng_name`,`Service`.`eng_display_name` FROM `services` AS `Service` where parent_id IN(select id from services where parent_id  = 0 and status = 1 and is_deleted = 0) and `Service`.`status` = 1 and `Service`.`is_deleted` = 0 ");
//   LIMIT 1

//$getTreatment = array();


	
	//$log = $this->Service->getDataSource()->getLog(false, false);
		  //  pr($log);
		  //  exit;
		    
	$countryData = $this->Common->getCountryStates();
	$theCity = array();
	
	foreach($countryData as $country){
	    if(!empty($country['State'])){
		foreach($country['State'] as $thecty){
		    $theCity[$thecty['id']] = "<span class='ctyName' data-cntyN='".$country['Country']['title']."' data-country='".$country['Country']['id']."' >{$thecty['name']}</span>";
		}
	    }
	}
	$this->set('menuActive','home');
	$this->set('showSmallSearch',true);
	$this->set(compact('theCity','loc','info','getTreatment','countryId','loc1','location','city_id','treat'));
	
	
	$services_html = '';
	//pr($this->request->data);
	//exit;

	if(!empty($this->request->data['service_parent'])){
	   
	    if(!empty($cat)){
		if(!empty($this->request->data['select_all']))
		    $services_html = $this->getservice($this->request->data['service_parent'],$cat,$this->request->data['select_all'],$allunset);
		else
		    $services_html = $this->getservice($this->request->data['service_parent'],$cat,'',$allunset);
	    } else {
		$services_html = $this->getservice($this->request->data['service_parent'],'','',$allunset);
	    }
	}
	$this->set(compact('services_html','allunset'));
	/*
	if($this->RequestHandler->isAjax()){
	    $this->layout='ajax';	    
	    $this->viewPath = "Search";
	    $this->render('index');
	}*/
    
	/*if($this->RequestHandler->isAjax()){
	    $this->layout='ajax';	    
	    $this->viewPath = "Search";
	    $this->render('index1');
	} else {*/
		$this->layout='search1';
    		$this->render('index1');
	//}
    }
    

    function testlayout($location = null,$salon_type = null,$available_date = null,$treatment = null){
         Configure::write('debug',2);
         $split_location = $state_id =  '';
	 $criteria = '';
	 $country_id = 252 ;
	 if($location == ''){
	    $this->redirect(array('controller'=>'homes','action'=>'index'));
	 }else{
	   $split_location =  split('~',$location);
	 } 
	 
	 if(!empty($split_location)){
	   
		    if(!empty($split_location[0])){
			$country = $split_location[0];
			$country = str_replace('-',' ',$country);
			//GET COUNTRY ID FROM NAME
			$country_id = 252;
			$criteria .= 'Address.country_id = 252';
			
		    }
		    if(!empty($split_location[1]) && ($split_location[1] != "All-Cities")){
			$country = $split_location[1];
			$city = str_replace('-',' ',$country);
			//GET COUNTRY ID FROM NAME
			$state_id = $this->get_element_id('State',$city);
		    
			$criteria .= ' and Address.state_id = '.$state_id;
		    }
		    if(!empty($split_location[2])){
		      $city = $split_location[2];
		      $loc1 = $city = str_replace('-',' ',$city);
		     //GET CITY ID FROM NAME
		      $city_id = $this->get_element_id('City',$city);
		      $criteria .= ' and Address.city_id = '.$city_id;
		    }
		}
		if(!empty($salon_type) && $salon_type !='serviceTo'){
		    
		    $criteria .= " and Salon.service_to ='$salon_type' ";
		    
		}
		if(!empty($available_date)){
		    $day = date('D', strtotime($available_date));
		    $day = strtolower($day);
		    $criteria .= " and SalonOpeningHour.is_checked_disable_".$day." = 1";
		}
		
		if(!empty($treatment)){
		    $treatment_explode = explode('~',$treatment);
		    if(!empty($treatment_explode)){
			$service = $treatment_explode[0];
			if(isset($treatment_explode[1]) && !empty($treatment_explode[1])){
			    $salon = $treatment_explode[1];
			    if(!empty($salon)){
				$salon = str_replace('-',' ',$salon);
				$criteria .= " and (Salon.eng_name LIKE '%$salon%' OR Salon.ara_name LIKE '%$salon%')";
			    }
			}
			if(!empty($service)){
			    $service = str_replace('-',' ',$service);
			    $criteria .= " and SalonService.service_id IN(select id from services as Service where (Service.eng_name LIKE '$service' or Service.ara_name LIKE '$service') AND Service.parent_id is NOT NULL and Service.parent_id != 0 and  Service.status = 1 and Service.is_deleted = 0 ) and SalonService.status = 1 and SalonService.is_deleted = 0";
			    
			}
			
		    }
		}
	
	$getData = $this->User->query(
		"SELECT User.id,User.username,Salon.id,Salon.eng_name,SalonService.id,Service.id,Service.eng_name,Salon.cover_image,Salon.ara_name,Salon.email,Salon.eng_description,Salon.business_url,Salon.ara_description, Address.latitude,Address.city_id,Address.state_id,Address.longitude,Address.address,City.city_name,State.name from addresses as Address
		    INNER JOIN users as User ON Address.user_id = User.id
		    LEFT JOIN cities as City ON Address.city_id = City.id
		    LEFT JOIN states as State ON Address.state_id = State.id
		    INNER JOIN salons as Salon ON Address.user_id = Salon.user_id
		    INNER JOIN salon_services as SalonService ON SalonService.salon_id = User.id
		    INNER JOIN services as Service ON Service.id = SalonService.service_id
		    LEFT JOIN policy_details as PolicyDetails ON PolicyDetails.user_id = User.id
		    LEFT JOIN salon_outcall_configurations as SalonOutcallConfiguration ON SalonOutcallConfiguration.user_id = User.id
		    INNER JOIN salon_opening_hours as SalonOpeningHour ON SalonOpeningHour.user_id = Address.user_id where ".$criteria." group by Address.user_id limit 10");
        
	if(!empty($getData)){
		foreach($getData as $key=>$saloon){
		  $getData[$key]['count']  = $this->SalonServiceList($saloon['User']['id']);
		}
	}
	
	
    


	//pr($getData);
	//exit;
        $this->layout = "search1";
	$this->set(compact('getData'));
	$this->layout = "search";
	$this->render('index1');
	
  }
    
function SalonServiceList($salonId = null, $type_id = null, $service_type = null, $service_id = array()){
		$salonServices = array();
		$salonServices_cnt = 0;
		$defaultLayout = false;
		$this->loadModel('ServicePricingOption');
		$this->loadModel('SalonService');
		
		$minfullprice = $this->ServicePricingOption->find('first', array('fields'=>array('ServicePricingOption.user_id','ServicePricingOption.salon_service_id','ServicePricingOption.full_price'),'conditions'=>array('user_id'=>$salonId),'order'=>'full_price ASC'));
		
		$minselprice = $this->ServicePricingOption->find('first', array('fields'=>array('ServicePricingOption.user_id','ServicePricingOption.salon_service_id','ServicePricingOption.sell_price'),'conditions'=>array('user_id'=>$salonId),'order'=>'sell_price ASC'));
	        $minprice = 0;
		if(empty($minselprice['ServicePricingOption']['sell_price']) || is_null($minselprice['ServicePricingOption']['sell_price']) ){ 
		   $minprice =  $minfullprice['ServicePricingOption']['full_price'];
		}else{
		   
		     $minfullprice =  $minfullprice['ServicePricingOption']['full_price'];
		     $minselprice =  $minselprice['ServicePricingOption']['sell_price'];
		    if($minfullprice<$minselprice){
			$minprice =  $minfullprice['ServicePricingOption']['full_price'];
		    }else{
			 $minprice =  $minselprice['ServicePricingOption']['sell_price'];
		    }
		}

		$salonServices_cnt = $this->SalonService->find('count', array(
		        'recursive' => -1,
			'conditions' => array('SalonService.salon_id' => $salonId,'SalonService.is_deleted' => 0, 'SalonService.parent_id !=' => 0, 'SalonService.status' => 1),
			)
		);
		//pr($salonServices_cnt);
		
	       return array('minprice'=>$minprice,'salonservicescount'=>$salonServices_cnt);
	}





 

    /**********************************************************************************    
	@Function Name : get_element_id
	@Params	 : name
	@Description   : Getting Id of Element
	@Date          : 4-May-2015
    ***********************************************************************************/
    function get_element_id($model = null , $name = null){
	
	$SessionLang = $this->Session->read('Config.language');
	$getId = '';
	$this->Country->unbindModel(array('hasMany' => array('State')), true);
	if($model == 'Country'){
	   $getId = $this->$model->find('first',array('conditions'=>
				    array(
					'OR' => array(
					    $model.'.'.'name LIKE' => '%'.$name.'%',
					    $model.'.'.'ara_name LIKE' => '%'.$name.'%',
					    $model.'.'.'title LIKE' => '%'.$name.'%',
					    $model.'.'.'ara_title LIKE' => '%'.$name.'%'
				    )),'fields'=>array($model.'.'.'id')));
	   
	}elseif($model == 'State'){
	    $getId = $this->$model->find('first',array('conditions'=>
				    array(
					'OR' => array(
					    $model.'.'.'name LIKE' => '%'.$name.'%',
					    $model.'.'.'ara_name LIKE' => '%'.$name.'%',
				    )),'fields'=>array($model.'.'.'id')));
	}elseif($model == 'City'){
	    $getId = $this->City->find('first',array('conditions'=>array('city_name LIKE' => '%'.$name),'fields'=>array('id')));
	}elseif($model == 'BusinessType'){
	    if($SessionLang == 'eng'){
		$getId = $this->BusinessType->find('first',array('conditions'=>array('eng_name LIKE' => '%'.$name),'fields'=>array('id')));
	    }else{
		$getId = $this->BusinessType->find('first',array('conditions'=>array('ara_name LIKE' => '%'.$name),'fields'=>array('id')));
	    }
	}
	if(!empty($getId)){
	    $getId = $getId[$model]['id'];
	}
	return $getId;
    }
    
    
    /**********************************************************************************    
	@Function Name : getvenueimages
	@Params	 : NULL
	@Description   : Getting Venue Images
	@Author        : Niharika Sachdeva
	@Date          : 23-Feb-2015
***********************************************************************************/
    
    public function getvenueimages($user_id = null){
	$this->autoRender = false;
	$this->loadModel('VenueImage');
	$images  = $this->VenueImage->findAllByUserId($user_id);
	return $images;
	
    }
    
    public function getsalonOpeningHours($user_id = null){
	$this->autoRender = false;
	$this->loadModel('SalonOpeningHour');
	
     $salonOpeningHours =  $this->SalonOpeningHour->find('first' , array('conditions'=>array('user_id'=>$user_id,'status'=>1))); 
	return $salonOpeningHours;
    }


      /**********************************************************************************    
	@Function Name : getallsearch
	@Params	 : keyword
	@Description   : Autocomplete Search
	@Date          : 14-March-2015
***********************************************************************************/

	public function getallsearch($keyword = null , $state = null){
		$this->layout = 'ajax';
		$this->loadModel('Country');
		$this->loadModel('City');
		$this->loadModel('Service');
		$this->loadModel('Salon');
		$this->loadModel('User');
		$this->loadModel('Address');
		$criteria = '';
		$criteria_salon = '';
		$criteria_service = '';
                $salon_list='';
		$data='';
		$category = '';
		$this->City->bindModel(array('belongsTo' => array('State')));
		 if(!empty($keyword)){
			$criteria .= "City.city_name LIKE '%".$keyword."%'";
			if(!empty($state)){
			    $criteria .= " and City.state_id = $state";
			}
//			echo $criteria;exit;
			/********** Location Search **********/ 
			$list = $this->City->find('all', array(
			    'conditions' => array($criteria),
			    'fields' => array('City.id,City.city_name'),
			    'order' => 'City.city_name DESC'
			));
			//pr($list);exit;
			/********** Location Search **********/
                            /********** Salon Search **********/
			    $criteria_salon .= 'Salon.status = 1 and Salon.is_deleted = 0 and User.type IN (3,4) and User.status = 1 and User.front_display = 1 and User.is_deleted =0 and User.is_email_verified = 1  and User.is_phone_verified = 1';
			    if(!empty($state)){
				$criteria_salon .= ' and Address.state_id = '.$state;
			    }
			    $criteria_salon .= " AND (
					(Salon.eng_name LIKE '%".$keyword."%')
			    )";
			    $salon_list = $this->Salon->find('all' , 
                                array(
				    'joins' => array(
					array(
					    'table' => 'addresses',
					    'alias' => 'Address',
					    'type' => 'inner',
					    'conditions' => array(
						'Address.user_id= Salon.user_id'
					    )
					)
				    ),
                                    'conditions' => array($criteria_salon),
                                    'fields' => array('Salon.id','Salon.eng_name'),
                                    'order' => 'Salon.eng_name DESC'
                                )
                            );
			   // pr($salon_list);
                        /********** Salon Search **********/
			/********** Category Search ********/
			$this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
			$categories = $this->Service->find('all', array(
				    'fields' => array('Service.id', 'Service.eng_name'),
				    'conditions' => array('Service.parent_id IN (SELECT id FROM services as Service WHERE Service.parent_id = 0 and Service.created_by=0 and Service.is_deleted =0 and Service.status =1)','Service.eng_name LIKE "%'.$keyword.'%"'),
				    'order' => 'Service.eng_name'
			    )
			);
			//pr($categories);exit;
			/********** Category Search ********/
			
			/********** Service Search **********/

			    $service_list = $this->Service->find('all' , array(
				'conditions' => array('Service.parent_id IN (SELECT id FROM services Service WHERE Service.parent_id IN (SELECT id from services as Service WHERE Service.parent_id = 0 and Service.status = 1 and Service.is_deleted = 0) and Service.created_by=0 and Service.is_deleted =0 and Service.status =1)','Service.eng_name LIKE "%'.$keyword.'%"'),
				'fields' => array('Service.id','Service.eng_name','Service.parent_id'),
				'order' => 'Service.eng_name DESC'
									   
			    ));
			    
			/********** Salon Search **********/
		
		}
		 $this->set(compact('service_list','user_list','salon_list','keyword','categories','list')); 
	}
    
    /**********************************************************************************    
	@Function Name : getCountryName
	@Params	 : NULL
	@Description   : Getting Country Name
	@Date          : 24-Feb-2015
***********************************************************************************/
    
    public function getCountryName($country_id = null){
	$this->autoRender = false;
	$this->loadModel('Country');
	$name  = $this->Country->findById($country_id);
	return $name;
	
    }
    
    /**********************************************************************************    
	@Function Name : getCountryName
	@Params	 : NULL
	@Description   : Getting Country Name
	@Date          : 24-Feb-2015
***********************************************************************************/
    
    public function getBusinessName($id = null){
	$this->autoRender = false;
	$this->loadModel('BusinessType');
	$getid = explode('"' ,$id );
	if(!empty($getid[1])){
	   $name  = $this->BusinessType->findById($getid[1]); 
	}else{
	    $name = '';
	}
	return $name;
	
    }
    
     public function getFacilityDetail($id = null){
	$this->autoRender = false;
	$this->loadModel('FacilityDetail');
	$facilityDetail = $this->FacilityDetail->find('first',array('fields'=>'FacilityDetail.*','conditions'=>array('FacilityDetail.user_id'=>$id))); 
	
	return $facilityDetail;
	
    }
    
    
    /**********************************************************************************    
	@Function Name : getCountMenuServices
	@Params	 : NULL
	@Description   : Getting Count of Services for Menu
	@Date          : 24-Feb-2015
    ***********************************************************************************/
   
    public function getCountMenuServices($user_id = null){
	$this->autoRender = false;
	$this->loadModel('SalonService');
	$count = $this->SalonService->find('all', array('conditions' => array('salon_id'=>$user_id , 'parent_id !=' => '0' , 'is_deleted'=>'0','service_id !='=>'0', 'status'=>'1')));
	return count($count);
	
    }
    
    
    function setsession($book_id = null,$book_ser_type = null){
	if(!empty($book_id) && !empty($book_ser_type)){
	    $session_variable = 'salon_'.$book_ser_type.'_id';
	    $this->Session->write('FRONT_SESSION.'.$session_variable,$book_id);
	}
	die;
    }
    
    
    
    /**********************************************************************************    
	@Function Name : getCountDeals
	@Params	 : NULL
	@Description   : Getting Count of Deals
	@Date          : 11-June-2015
    ***********************************************************************************/
    
    
    public function getCountDeals($salonId = null, $category = null){
	$this->autoRender = false;
	$deals = array();
        $defaultLayout = false;
        if($salonId){
	    $category = 10;
            $deals = array();
            $service_ids = array();
			$child_service=array();
			$chk_service = $this->Service->find('first', array(
				'conditions' => array('Service.id' => $category),
				'fields' => 'parent_id'
			));
			if(!empty($chk_service)){
				$parent = $chk_service['Service']['parent_id'];
				if($parent != 0){
					$this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
					$service = $this->Service->find('all', array(
						'conditions' => array('Service.parent_id' => $category),
						'fields' => 'id'
					));
					if(!empty($service)){
						foreach($service as $s){
							$service_ids[] = $s['Service']['id']; 
						}
					}
				}	
			}
			$this->loadModel('SalonService');
			$salonServices = $this->SalonService->find('list', array('conditions' => array('SalonService.service_id' => $service_ids, 'SalonService.salon_id' => $salonId,'SalonService.is_deleted' => 0, 'SalonService.status' => 1)));
			//pr($salonServices); exit;
			$this->loadModel('DealServicePackage');
			$this->DealServicePackage->bindModel(array(
				'belongsTo' => array('Deal')
			));
			$this->DealServicePackage->unbindModel(array(
				'hasMany' => array('DealServicePackagePriceOption')
			));
			$deals = $this->DealServicePackage->find('all',array(
				'fields' => array('Deal.eng_name','Deal.ara_name','Deal.image'),
				'conditions' => array('DealServicePackage.salon_service_id' => $salonServices),
				'group' => array('DealServicePackage.deal_id'),
				'order' => array('DealServicePackage.id DESC'),
				'limit'=>'6'
				)	      
			);
	    return count($deals);
           
	}
        $this->set(compact('deals'));
    }
    
    
    
     /**********************************************************************************    
	@Function Name : getservice
	@Params	 : NULL
	@Description   : Getting Service
	@Author        : Niharika Sachdeva
	@Date          : 4-March-2015
***********************************************************************************/
    public function getservice($service_id = null, $cat = array(),$select_all = null,$allunset = null){
	$data = '';
	$this->autoRender = false;
	$this->loadModel('Service');
	$this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
	$service = $this->Service->find('all',array('conditions'=>array('parent_id'=>$service_id)));
	$cked_all = "";
	if(!empty($service)){
	    if(!empty($select_all)){
		$cked_all = "checked = 'checked'";
	    }
	    
	     $data .= '<li><a href="javascript:void(0)"><span>'
            . '<input '.$cked_all.' id="all" name="select_all" class="service-child-selectall " type="checkbox" /><label class="new-chk" for="all">Select All</label></span></a></li>';
            foreach($service as $ser){
		//pr($ser['Service']['id']);
		 $cked = '';
		if(!empty($cat)){
			
			if(in_array($ser['Service']['id'],$cat)){
			    $cked = "checked = 'checked'";
			} else {
			    $cked = '';
			}
		}
		if($allunset == 'true'){
		    $cked = '';
		}
		$data .= '<li><a href="javascript:void(0)"><span>'
                        . '<input '.$cked.' name="service_id[]" value="'.$ser['Service']['id'].'" class="service-child" type="checkbox" id="service_'.$ser['Service']['id'].'" />
			<label class="new-chk" for="service_'.$ser['Service']['id'].'">'.$ser['Service']['eng_name'].'</label>
			</span></a></li>';
	    }
	}
	return $data; 
	$this->set(compact('service_id'));
    }
    
     /**********************************************************************************    
	@Function Name : searchlocation
	@Params	 : keyword
	@Description   : Autocomplete Search
	@Date          : 25-Feb-2015
***********************************************************************************/
    
    public function searchlocation($keyword = null){
	$this->loadModel('Country');
	$this->autoRender = false;
	$criteria = 'Country.status = 1';
	    if($keyword != ''){
		$criteria .= " AND (( State.name LIKE '%".$keyword."%') OR (Country.name LIKE '%".$keyword."%'  ))";
		$list = $this->Country->find('all', array(
		    'joins' => array(
			array(
			    'table' => 'states',
			    'alias' => 'State',
			    'type' => 'Left',
			    'conditions' => array(
				'Country.id= State.country_id'
			    )
			)
		    ),
		    'conditions' => array($criteria),
		    'fields' => array('State.name','Country.name'),
		    'order' => 'Country.name DESC'
		));
		if(!empty($list)){
		    $data =  '<li><a href="#" class="active"><span>Popular Location</span></a></li>';
		   foreach($list as $li){
			$data .=  '<li style="cursor:pointer;" onclick="set_useritem(\''.str_replace("'", "\'", $li['State']['name'].','.$li['Country']['name']).'\')">'.$li['State']['name'].','.$li['Country']['name'].'</li>';
		    }
		    echo $data;
		}else{
		    echo 'No Records Found';
		}
	      
	    }else{
		echo  'No Records Found';
	    }
    }
    
    public function getAjaxContent($user_id = null, $type = null){
		$this->autoRender = false;
		if($this->request->is('post') || $this->request->is('ajax')){
		//pr($this->request->data); exit;
			//$user_id = 	$this->request->data['user_id'];
			if(isset($this->request->data['user_id']) && $this->request->data['user_id'] != ''){
				$user_id = $this->request->data['user_id'];
			}
			if(isset($this->request->data['service_type']) && $this->request->data['service_type'] != ''){
				$service_type = $this->request->data['service_type'];
			}
			if(isset($this->request->data['search_type']) && $this->request->data['search_type'] != ''){
				$type = $this->request->data['search_type'];
			}
			if(isset($this->request->data['type_id']) && $this->request->data['type_id'] != ''){
				$ser_cat_type = $this->request->data['type_id'];
			}
			if(isset($this->request->data['service_id']) && $this->request->data['service_id'] != ''){
				$service_id = $this->request->data['service_id'];
			}
			if(isset($this->request->data['cont_val']) && $this->request->data['cont_val'] != ''){
			    $service_cnt = $this->request->data['cont_val'];
			}
			//pr($this->request->data); exit;
			$this->set(compact('user_id','service_type','ser_cat_type','type','service_id'));
			$this->loadModel('User');
			$this->loadModel('FacilityDetail');
			$user = $this->User->find('first',array('fields'=>array('Address.city_id','Address.state_id','Address.longitude','Address.latitude',
								'Salon.ara_name','Salon.email','Salon.eng_name','Salon.business_url','Contact.country_code','Contact.cell_phone','User.username','Contact.day_phone'),'conditions'=>array('User.id'=>$user_id)));
			$this->set(compact('user','service_cnt'));
			if($this->RequestHandler->isAjax()){
				$this->layout='ajax';	    
				$this->viewPath = "Elements/frontend/Search";
				if($type == 'menu'){
				    $this->render('ajax-menu');
				}
				if($type == 'deal'){
				    $this->render('ajax-deals');
				}
				if($type == 'map'){
				    $this->render('ajax-map');
				}
				if($type == 'info'){
				    $this->render('ajax-info');
				}
				if($type == 'gallery'){
				    $this->render('ajax-gallery');
				}
				if($type == 'package'){
				    $this->render('ajax-packages');
				}
				if($type == 'spaday'){
				    $this->render('ajax-spadays');
				}
			}
		}
    }
    
    
    public function getSalonPackages($salonId = null, $type = null, $type_id = null, $service_type = null, $service_id = null){
		$this->autoRender = false;
		$packages = array();
        $defaultLayout = false;
		if($type == 'package') {
			$type = "Package";
		}
		elseif($type == 'spaday'){
			$type = "Spaday";
		}
		
		$this->loadModel('Package');
		$this->Package->unbindModel(array(
				'hasMany' => array('SalonStaffPackage')
		));
		//echo $type; exit;
		if(isset($salonId) && isset($type_id) && $service_type == 5 ){
			//echo "in first if"; exit;
			$service_ids = $this->get_service_ids($type_id);
			if(!empty($service_id)){
				$service_id	= explode(',', $service_id);
				$service_ids = $service_id;
			}
			$packages = $this->get_salon_packages($service_ids, $salonId , $type);
			
        }
		elseif(isset($salonId) && isset($type_id) && $service_type == 1 ){
			$service_ids = explode('-',$type_id);
			if(!empty($service_id)){
				$service_id	= explode(',', $service_id);
				$service_ids = $service_id;
			}
			$packages = $this->get_salon_packages($service_ids, $salonId , $type);
			
		}
		elseif(isset($salonId)){
			$this->Package->unbindModel(array(
				'hasMany' => array('PackageService')
			));
			$packages = $this->Package->find('all', array(
				'fields'=>array('Package.id','Package.eng_name','Package.ara_name','Package.image','Package.type','Package.user_id','SalonServiceDetail.sold_as'),
				'conditions' => array('Package.is_deleted' => 0,'Package.status' => 1, 'Package.type'  => $type, 'Package.user_id' => $salonId),
				'limit' => 5,
				'order' => array('Package.id DESC')
				)
			);
			//pr($packages);
			//exit;
		}
		$this->loadModel('Package');
		$this->Package->unbindModel(array(
				'hasMany' => array('SalonStaffPackage','PackageService')
		));
		$packages_cnt = $this->Package->find('count', array(
			'fields'=>array('Package.id'),
			'conditions' => array('Package.is_deleted' => 0,'Package.status' => 1,
					      'Package.type'  => $type, 'Package.user_id' => $salonId)
			)
		);
		return array('packages'=>$packages,'packagescount'=>$packages_cnt);
    }
	
    public function getSalonPackages_count($salonId = null, $type = null){
	if($type == 'package') {
	    $type = "Package";
	}
	elseif($type == 'spaday'){
	    $type = "Spaday";
	}
	$this->loadModel('Package');
	$this->Package->unbindModel(array(
			'hasMany' => array('SalonStaffPackage','PackageService')
	));
	$packages_cnt = $this->Package->find('count', array(
		'fields'=>array('Package.id'),
		'conditions' => array('Package.is_deleted' => 0,'Package.status' => 1,
				      'Package.type'  => $type, 'Package.user_id' => $salonId)
		)
	);
	//pr($packages_cnt);
	return $packages_cnt;
    }
	
	
	public function get_service_ids($type_id = null){
		$this->loadModel('Service');
		$this->loadModel('SalonService');
		$this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
		$service_ids = array();
		$chk_service = $this->Service->find('first', array(
			'conditions' => array('Service.id' => $type_id),
			'fields' => 'parent_id'
		));
		if(!empty($chk_service)){
			$parent = $chk_service['Service']['parent_id'];
			if($parent != 0){
				$this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
				$service = $this->Service->find('all', array(
					'conditions' => array('Service.parent_id' => $type_id),
					'fields' => 'id'
				));
				if(!empty($service)){
					foreach($service as $s){
						$service_ids[] = $s['Service']['id']; 
					}
				}
			}	
		}
		return $service_ids;
	}
	
	
	public function get_salon_packages($service_ids = null, $salonId = null, $type = null){
		$this->loadModel('SalonService');
		$this->loadModel('PackageService');
		$this->PackageService->bindModel(array(
				'belongsTo' => array('Package')
			));
		$this->PackageService->unbindModel(array(
				'hasMany' => array('PackagePricingOption')
		));
		$salonServices = $this->SalonService->find('list', array('conditions' => array('SalonService.service_id' => $service_ids, 'SalonService.salon_id' => $salonId,'SalonService.is_deleted' => 0, 'SalonService.status' => 1)));
		$packages = $this->PackageService->find('all',array(
			'fields' => array('Package.id','Package.eng_name','Package.ara_name','Package.image', 'Package.type','Package.user_id'),
			'conditions' => array('PackageService.salon_service_id' => $salonServices,'Package.is_deleted' => 0,'Package.status' => 1, 'Package.type' => $type),
			'group' => array('PackageService.package_id'),
			'order' => array('PackageService.id DESC'),
			'limit'=>5
			)	      
		);
		return $packages;
	}
	
	public function getPolicyDetail($salon_id){
	   $this->loadModel('SalonOnlineBookingRule');
	   $fields = array('allow_cancel','allow_reschedule');
	   $Details  = array();
	   $Details = $this->SalonOnlineBookingRule->find('first', array('conditions'=>array('user_id'=>$salon_id),'fields'=>$fields));
	   if(!count($Details)){
	    $Details = $this->SalonOnlineBookingRule->find('first', array('conditions'=>array('user_id'=>1),'fields'=>$fields));
	   }
	   return $Details;
	}
	
}
