<?php
class HomesController extends AppController {
    
    public $helpers = array('Session', 'Html', 'Form','Minify.Minify'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Common','Image'); //An array containing the names of components this controller uses.

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('autosearchsalon','coming_soon','getBusinessTypes','index','getPhoneCode','getStates','getCities','getIsoCode','getServicePrice','autosearch','autosearchservice','getServices_tree','navigation','index1','banner');
    }
    
/**********************************************************************************    
	@Function Name : index
	@Params	 : NULL
	@Description   : Home page of the Site
	@Author        : Shibu Kumar
	@Date          : 03-Feb-2015
***********************************************************************************/
    public function index($secure=null,$url=null) {
        if(isset($_COOKIE['State'])){
	        $stateCook = $_COOKIE['State'];
	}else{
	    $stateCook = 'not_set';
	}
	
	$SessionLang = $this->Session->read('Config.language');
	$this->loadModel('Service');
	/******** Load Countries *********/
	$countryData = $this->Common->getCountryStates();
	$theCity = array();
	foreach($countryData as $country){
	    if(!empty($country['State'])){
		foreach($country['State'] as $thecty){
		    $theCity[$thecty['id']] = "<span class='ctyName' data-cntyN='".$country['Country']['title']."' data-country='".$country['Country']['id']."' >{$thecty['name']}</span>";
		}
	    }
	}
	
	/******** Load Countries *********/
	/******** Load Business Types *********/
	$businessTypes = $this->Common->getBusinessTypes(); 
	/******** Load Business Types *********/
	$this->Service->unbindModel(array('hasMany'=>array('ServiceImage')));
	$getFrontendServices = $this->getServices_home_tree();
	$this->set(compact('getFrontendServices','SessionLang','theCity','countryData','businessTypes','stateCook')); 
        $this->set('showSearch',true);
        $this->set('menuActive','home');
	// for Reset Password
	if($secure && $url){
	    $this->loadModel('User');
	    $data = $this->User->find('first',array('recursive'=>-1,'conditions'=>array('User.email_token'=>$url)));
            if(!empty($data)){
                   $this->set(compact('secure','url'));
            }else{
		   $this->redirect(array('controller'=>'Homes','action'=>'index'));
	    }
	}
	$this->layout = 'home_page';
	
    }
    
    
    public function index1($secure=null,$url=null) {
	die("testing");
        /*if(isset($_COOKIE['State'])){
	        $stateCook = $_COOKIE['State'];
	}else{
	    $stateCook = 'not_set';
	}
	
	$SessionLang = $this->Session->read('Config.language');
	$this->loadModel('Service');*/
	/******** Load Countries *********/
	/*$countryData = $this->Common->getCountryStates();
	$theCity = array();
	foreach($countryData as $country){
	    if(!empty($country['State'])){
		foreach($country['State'] as $thecty){
		    $theCity[$thecty['id']] = "<span class='ctyName' data-cntyN='".$country['Country']['title']."' data-country='".$country['Country']['id']."' >{$thecty['name']}</span>";
		}
	    }
	}
	*/
	/******** Load Countries *********/
	/******** Load Business Types *********/
	//$businessTypes = $this->Common->getBusinessTypes(); 
	/******** Load Business Types *********/
	/*$this->Service->unbindModel(array('hasMany'=>array('ServiceImage')));
	$getFrontendServices = $this->getServices_home_tree();
	$this->set(compact('getFrontendServices','SessionLang','theCity','countryData','businessTypes','stateCook')); 
        $this->set('showSearch',true);
        $this->set('menuActive','home');
	// for Reset Password
	if($secure && $url){
	    $this->loadModel('User');
	    $data = $this->User->find('first',array('recursive'=>-1,'conditions'=>array('User.email_token'=>$url)));
            if(!empty($data)){
                   $this->set(compact('secure','url'));
            }else{
		   $this->redirect(array('controller'=>'Homes','action'=>'index'));
	    }
	}
	$this->layout = 'home_page';*/
	
    }
    
    
    
    
    /**********************************************************************************    
	    @Function Name : getServices_tree
	    @Params	 : NULL
	    @Description   : Home page of the Site
	    @Author        : Ramanpreet Pal on 22 May, 2015
    ***********************************************************************************/    
    function getServices_home_tree(){
        $newgetData = $this->Service->find('all',
	    array('fields' => array('Service.id',
				    'Service.eng_name',
				    'Service.ara_name',
				    'Service.parent_id',
				    'Service.status',
				    'Service.service_order',
				    'Service.frontend_display'
				),
		  'conditions' => array( 'Service.is_deleted' => 0,'Service.parent_id' => 0,'Service.frontend_display' => 1),
		  'order' => array('Service.service_order')));
	if(!empty($newgetData)){
	    $this->Service->unbindModel(array('hasMany'=>'ServiceImage'));
            foreach($newgetData as $thk=>$serviceIs){
                $newchild = $this->Service->find('all', array(
							'fields' => array('Service.id',
									  'Service.eng_name',
									  'Service.ara_name',
									  'Service.parent_id', 'Service.status',
									  'Service.service_order',
									  'Service.frontend_display'
									),
							'conditions' => array(
									'Service.is_deleted' => 0,
									'Service.parent_id' => $serviceIs['Service']['id'],
									'Service.frontend_display' => 1
							),
							'order' => array('Service.service_order'))
						 );
		
		
                $newgetData[$thk]['children'] = $newchild;
                if(!empty($newchild)){
                    foreach($newchild as $inthk=>$childserviceIs){
                        $newchildinside = $this->Service->find('all',
						    array('fields' =>
							  array('Service.id',
								'Service.eng_name AS name',
								'Service.parent_id',
								'Service.status',
								'Service.service_order',
								'Service.frontend_display'
							    ),
							'conditions' => array(
							    'Service.is_deleted' => 0,
							    'Service.parent_id' => $childserviceIs['Service']['id']
							),
							'order' => array('Service.service_order')));
                        $newgetData[$thk]['children'][$inthk]['children'] = $newchildinside;
                    }
                }
            }
        }
	return $newgetData;
    }
    
   
/**********************************************************************************    
	@Function Name : getServices_tree
	@Params	 : NULL
	@Description   : Home page of the Site
	@Author        : Aman Gupta
	@Date          : 06-April-2015
***********************************************************************************/    
    function getServices_tree(){
        $newgetData = $this->Service->find('all',
	    array('fields' => array('Service.id',
				    'Service.eng_name AS name',
				    'Service.parent_id',
				    'Service.status',
				    'Service.service_order',
				    'Service.frontend_display'
				),
		  'conditions' => array( 'Service.is_deleted' => 0,'Service.parent_id' => 0),
		  'order' => array('Service.service_order')));
	//pr($newgetData);
        if(!empty($newgetData)){
            foreach($newgetData as $thk=>$serviceIs){
                $newchild = $this->Service->find('all', array(
							'fields' => array('Service.id',
									  'Service.eng_name AS name',
									  'Service.parent_id', 'Service.status',
									  'Service.service_order',
									  'Service.frontend_display'
									),
							'conditions' => array(
									'Service.is_deleted' => 0,
									'Service.parent_id' => $serviceIs['Service']['id']
							),
							'order' => array('Service.service_order'))
						 );
                $newgetData[$thk]['children'] = $newchild;
                if(!empty($newchild)){
                    foreach($newchild as $inthk=>$childserviceIs){
                        $newchildinside = $this->Service->find('all',
						    array('fields' =>
							  array('Service.id',
								'Service.eng_name AS name',
								'Service.parent_id',
								'Service.status',
								'Service.service_order',
								'Service.frontend_display'
							    ),
							'conditions' => array(
							    'Service.is_deleted' => 0,
							    'Service.parent_id' => $childserviceIs['Service']['id']
							),
							'order' => array('Service.service_order')));
                        $newgetData[$thk]['children'][$inthk]['children'] = $newchildinside;
                    }
                }
            }
        }
        return $newgetData;
    }
 
/**********************************************************************************    
	@Function Name : getStates
	@Params	 : NULL
	@Description   : Returns Ajax list of States
	@Author        : Shibu Kumar
	@Date          : 01- Dec-2014
***********************************************************************************/     
    function getStates($id=null, $addClass = null){
        $this->layout ='ajax';
        $this->loadModel('State');
        $stateList = $this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$id,'State.status'=>1),'order'=>array('State.name ASC')));
        $this->set('selectbox',$stateList);
	$this->set(compact('addClass'));
    }
/**********************************************************************************    
	@Function Name : getCities
	@Params	 : NULL
	@Description   : Returns Ajax list of City
	@Author        : Shibu Kumar
	@Date          : 01- Dec-2014
***********************************************************************************/     
    function getCities($id=null, $addClass = null){
	$this->layout ='ajax';
        $this->loadModel('City');
        $cityList = $this->City->find('list',array('fields'=>array('id','city_name'),'conditions'=>array('City.state_id'=>$id,'City.status'=>1),'order'=>array('City.city_name ASC')));
	$this->set('cities',$cityList);
	$this->set(compact('addClass'));
    }

/**********************************************************************************    
	@Function Name 	: getPhoneCode
	@Params	 		: NULL
	@Description   	: Returns Phone Code for CountryId
	@Author        	: Aman Gupta
	@Date          	: 04-Dec-2014
***********************************************************************************/     
    public function getPhoneCode($id=null) {
		if($id){
			$this->loadModel('Country');
			$phCode = $this->Country->find('first',array('fields'=>array('Country.phone_code'),'conditions'=>array('Country.id'=>$id)));
			echo $phCode['Country']['phone_code'];
		}
		die;
    }
       
       
     public function getIsoCode($id = null) {
        $this->loadModel('Country');
	 $this->autoRender = false;
        $countryData = $this->Country->find('first', array('fields' => array('Country.iso_code'), 'conditions' => array('Country.id' => $id)));
        
	return $countryData['Country']['iso_code'];
    }
    
    //Get the service amount
    public function getServicePrice($id=NULL){      
	//$this->layout ='ajax';
        $this->loadModel('ServicePricingOption');
	$serviceListCount = $this->ServicePricingOption->find('count',array('fields'=>array('id','full_price'),'conditions'=>array('ServicePricingOption.salon_service_id'=>$id)));
       	$serviceDetail = $this->ServicePricingOption->find('all',array('conditions'=>array('ServicePricingOption.salon_service_id'=>$id)));
      	$array = array();
	$hiddenarray = array();
	if(!empty($serviceDetail)){
	 //pr($serviceDetail);exit;
	     foreach($serviceDetail as $key=>$service_s){
		 $array[$service_s['ServicePricingOption']['full_price']] = '<span id="'.$service_s['ServicePricingOption']['duration'].'" class="getduration">'.$service_s['ServicePricingOption']['duration'].'</span> minutes - <strong>ADE '.$service_s['ServicePricingOption']['full_price'].'</strong><div class="pricing-option" style="hidden" id="'.$service_s['ServicePricingOption']['id'].'"></div>';
 
	     }
	}
       // pr($array);exit;
	if($serviceListCount >1){
	$serviceList = $this->ServicePricingOption->find('list',array('fields'=>array('id','full_price'),'conditions'=>array('ServicePricingOption.salon_service_id'=>$id)));
	$this->set('selectboxPrice',$serviceList);
	$this->set('array',$array);

	}else{
	 $inputBoxPrice = $this->ServicePricingOption->find('first',array('fields'=>array('id','full_price'),'conditions'=>array('ServicePricingOption.salon_service_id'=>$id)));
	 $this->set('inputBoxPrice',$inputBoxPrice);
	$this->set('array',$array);

	}        
	$this->set('serviceListCount',$serviceListCount);
	$this->set('serviceDetail',$serviceDetail);
	$this->set('array',$array);
	$this->set('hiddenarray',$hiddenarray);
    }
    
    /**********************************************************************************    
	@Function Name : autosearch
	@Params	 : keyword , country_id
	@Description   : Autocomplete Search
	@Author        : Niharika Sachdeva
	@Date          : 18-Feb-2015
***********************************************************************************/
    
    public function autosearch($keyword = null,$state_id=null,$is_spa= null){
	$this->loadModel('City');
	$this->loadModel('State');
	$list = array();
	if(!empty($keyword)){
		/********** Location Search **********/ 
		
		$list = $this->City->find('all', array(
		    'conditions' => array('City.status = 1','City.state_id'=>$state_id,'City.city_name LIKE "%'.$keyword.'%"'),
		    'fields' => array('City.city_name','City.id'),
		    'order' => 'City.city_name asc'
		));
	    /********** Location Search **********/
	}
	$this->set('list',$list);
	$this->set('is_spa',$is_spa);
    }
    
    /**********************************************************************************    
	@Function Name : autosearchservice
	@Params	 : keyword 
	@Description   :Autocomplete Search
	@Author        : Niharika Sachdeva
	@Date          : 18-Feb-2015
***********************************************************************************/
    
    public function autosearchservice($keyword = null) {
	$SessionLang = $this->Session->read('Config.language');
	// ADDED BY NAVDEEP
	if($SessionLang == ""){
	    $SessionLang = 'eng';
	}
	$this->loadModel('Service');
	$this->autoRender = false;
	
	$this->Service->unBindModel(array('hasMany' => array('ServiceImage')),false);
	
	$criteria = $output = $name = $cat='';
	$subcatArray = array();
	if($keyword != ''){
	    if($SessionLang == 'eng') {
		$conditions = array('Service.status' => 1,'Service.is_deleted'=>0,'Service.parent_id'=>'0');
		$fields = array('Service.id','Service.parent_id','Service.eng_name','Service.ara_name');
		$order = 'Service.id ASC';
		$name =  'eng_name';
	    } elseif($SessionLang == 'ara') {
		$conditions = array('Service.status' => 1,'Service.is_deleted'=>0,'Service.parent_id'=>'0'/*,'Service.ara_name LIKE "%'.$keyword.'%"'*/);
		$fields = array('Service.id','Service.parent_id','Service.eng_name','Service.ara_name');
		$order = 'Service.id ASC';
		$name =  'ara_name';
	    }
	    
	    $list = $this->Service->find('list', array(
		'conditions' => $conditions,
		'fields' => array('id','id'),
		'order' => array('Service.id ASC')
	    ));
	    
	    $search_str = '';
	    if(!empty($keyword)){
		$keyword_arr = explode(' ', $keyword);
		foreach($keyword_arr as $keyword_str){
		    if(empty($search_str)){
			$search_str = '(Service.eng_name LIKE "%'.$keyword_str.'%")';
		    } else {
			$search_str = $search_str.' OR (Service.eng_name LIKE "%'.$keyword_str.'%")';
		    }
		}
		$search_str = $search_str.' OR (Service.eng_name LIKE "%'.$keyword.'%")';
	    }
	    if(!empty($search_str)){
		$search_str = '('.$search_str.')';
	    }
	    
	    $data = $this->Service->find('all',array(
			    'conditions'=>array(
				'Service.status' => 1,
				'Service.is_deleted'=>0,
				'Service.parent_id != '=> '0',
				$search_str
			    ),
			    'fields' => $fields,
			    'order' => $order
			) );
	    
	    if(!empty($data)){
		foreach($data as $index => $cats){
		    if(!empty($list) && is_array($list)){
			if(!empty($categories)) {
			    //pr($categories);
			    if(array_key_exists($cats['Service']['parent_id'],$categories)){
				$sub_cats[$cats['Service']['parent_id']] =  $cats;
				$categories[$cats['Service']['parent_id']]['Children'][$cats['Service']['id']]['eng_name'] = $cats['Service']['eng_name'];
				$categories[$cats['Service']['parent_id']]['Children'][$cats['Service']['id']]['ara_name'] = $cats['Service']['ara_name'];
			    } else {
				$categories[$cats['Service']['id']]['eng_name'] = $cats['Service']['eng_name'];
				$categories[$cats['Service']['id']]['ara_name'] = $cats['Service']['ara_name'];
			    $categories[$cats['Service']['id']]['parent_id'] = $cats['Service']['parent_id'];
			    }
			} else {
			    $categories[$cats['Service']['id']]['eng_name'] = $cats['Service']['eng_name'];
			    $categories[$cats['Service']['id']]['ara_name'] = $cats['Service']['ara_name'];
			    $categories[$cats['Service']['id']]['parent_id'] = $cats['Service']['parent_id'];
			}
		    }
		}
	    }
	    
	    if(!empty($categories)){
		foreach($categories as $cate_id => $cate_details){
		    if(empty($cate_details['Children'])){
			$all_children = $this->Service->find('all',array(
				'conditions'=>array(
				    'Service.status' => 1,
				    'Service.is_deleted'=>0,
				    'parent_id'=> $cate_id),
				'fields' => $fields,
				'order' => $order
			    ) );
			if(empty($all_children)){
			    $parent = $this->Service->find('first',array(
				'conditions'=>array(
				    'parent_id'=> $cate_details['parent_id']),
				'fields' => $fields,
				'order' => $order
			    ) );
			    if(!empty($parent)){
				$categories[$parent['Service']['id']]['eng_name'] = $parent['Service']['eng_name'];
				$categories[$parent['Service']['id']]['ara_name'] = $parent['Service']['ara_name'];
				
				$categories[$parent['Service']['id']]['Children'][$cate_id]['ara_name'] = $cate_details['ara_name'];
				$categories[$parent['Service']['id']]['Children'][$cate_id]['eng_name'] = $cate_details['eng_name'];
				
				unset($categories[$cate_id]);
				
			    }
			} else{
			    foreach($all_children as $child){
				$categories[$cate_id]['Children'][$child['Service']['id']]['eng_name'] = $child['Service']['eng_name'];
				$categories[$cate_id]['Children'][$child['Service']['id']]['ara_name'] = $child['Service']['ara_name'];
			    }
			}
		    }
		}
	    }
	    
	    
	   // pr($categories);
	    //pr($sub_cats);
	    
	    
	    
	    if(!empty($categories)){
		foreach($categories as $service){
		    if($SessionLang == 'eng'){
			$output .= '<li><strong>'.@$service['eng_name'].'</strong></li>'; 
		    } else {
			$output .= '<li><strong>'.@$service['ara_name'].'</strong></li>';
		    }
		    
		    if(!empty($service['Children']) && is_array($service['Children'])){
			foreach($service['Children'] as $child_id => $child){
			    if($SessionLang == 'eng'){
				$output .= '<li onclick="set_userservice(\''.str_replace("'", "\'", @$child_id.','.@$child['eng_name']).'\')">'.@$child['eng_name'].'</li>';
			    } else {
				$output .= '<li onclick="set_userservice(\''.str_replace("'", "\'", @$child_id.','.@$child['ara_name']).'\')">'.@$child['ara_name'].'</li>';
			    }
			}
		    }
		    
		}
	    }
	    echo $output;
	} else{
            echo '<li style="list-style:none">No Records Found</li>';
        }
	//$this->viewPath = 'Elements';
	//$this->render('sql_dump');
    }

    function autosearchsalon($state=null,$keyword=null,$cityID = null){
	    $this->autoRender = false;
	    $this->loadModel('Salon'); 
	    $criteria_salon = '';
	    $criteria_salon .= ' Salon.status = 1 and Salon.is_deleted = 0 and User.type IN (3,4) and User.status = 1 and User.front_display = 1 and User.is_deleted =0 and User.is_email_verified = 1  and User.is_phone_verified = 1';
	    if($state != 'null'){
		 $criteria_salon .= ' and Address.state_id = '.$state;
	    }
	    if(!empty($cityID)){
		$criteria_salon .= ' and Address.city_id = '.$cityID;
	    }
	  
	    $criteria_salon .= " AND (
			(Salon.eng_name LIKE '%".$keyword."%')
	    )";
	    $salon_lists = $this->Salon->find('all' , 
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
		    'fields' => array('Salon.id','Salon.eng_name','Salon.ara_name'),
		    'order' => 'Salon.eng_name DESC'
		)
	    );
	    $output = '';
	    
	    if(!empty($salon_lists)){
		foreach($salon_lists as $salon_list){
		    $lang = Configure::read('Config.language');
		    $output .= '<li class="auto_salon" data-id='.urlencode($salon_list['Salon']['id']).'><strong>'.@$salon_list['Salon'][$lang.'_name'].'</strong></li>';
		    echo $output;
		    $output ='';
		}
	    }
	    //pr($salon_list);
	    
    }
    
    
    function navigation(){
	//echo $current_month = date('F Y');
	/*echo $current_month = 'February, 2017';
	echo '<br>';
	echo $calendate_start_date = date('Y-m-01', strtotime($current_month));
	echo '<br>';
	echo $calendate_end_date =  date('Y-m-t', strtotime($current_month));
	echo '<br>';
	echo date('d-m-Y',(strtotime($calendate_start_date) - 60*60*24*7));
	echo '<br>';
	echo date('d-m-Y',(strtotime($calendate_end_date) + 60*60*24*7));
	die;*/
        if($this->request->is(array('ajax'))){
            $this->layout = 'ajax';
            $this->viewPath = 'Elements';
            $this->render('header_navigation');
        } 
    }

    public function coming_soon($page_for = null){
	$this->layout = 'myaccount';
	$title_for_layout = 'Coming Soon';
	$this->set(compact('title_for_layout','page_for'));
    }
    public function banner(){
	$this->layout = 'ajax';
	$this->loadModel('SalonAd');
	$this->loadModel('CityToAd');
	$conditions= 'SalonAd.status = 1 and SalonAd.is_deleted = 0 and SalonAd.type = 0 and SalonAd.page = 0';
	
	 $banner_list = $this->SalonAd->find('all' , 
		array(
		    'conditions' => array($conditions),
		    'fields' => array('SalonAd.id','SalonAd.user_id','SalonAd.image','SalonAd.eng_description'),
		    'order' => 'rand()',
		    'limit' => 1,
		)
	    );
	
	//print_r($banner_list);  die;
	$this->set('banner_list',$banner_list);
	//$this->layout = 'myaccount';
	//$title_for_layout = 'Coming Soon';
	//$this->set(compact('title_for_layout','page_for'));
    }
    
}