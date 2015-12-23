<?php
class DealsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form','js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Paginator','Image','RequestHandler','Common','Crypto'); //An array containing the names of components this controller uses.
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index','showDeal','deal_package_sess','dealCron');
    }
    
    public function index(){
	if(isset($_COOKIE['State'])){
	        $stateCook = $_COOKIE['State'];
	}else{
	    $stateCook = 'not_set';
	}
	$chklang = Configure::read('Config.language');
	$this->loadModel('Deal');
	$this->loadModel('Service');
        $criteria ='Deal.is_deleted = 0 AND Deal.status = 1 AND Deal.listed_online = 1 AND Deal.listed_online_start <= DATE(NOW()) AND Deal.max_time >= DATE(NOW()) AND (Deal.quantity_type=0 OR (Deal.quantity_type=1 AND Deal.quantity > Deal.purchased_quantity)) AND User.front_display=1';
	//$criteria ='Deal.is_deleted = 0 AND Deal.status = 1 AND Deal.listed_online = 1 AND Deal.listed_online_start <= DATE(NOW()) AND Deal.max_time >= DATE(NOW())';
        $order = 'Deal.created DESC';
	$this->loadModel('SalonAd');
	$this->loadModel('City');
	$this->loadModel('CityToAd');
	$banner_list='';
	if(isset($this->request->data) && !empty($this->request->data)){
	    //pr($this->request->data); die;
	    $loc = $this->request->data['User']['country_id'];
	    $city = $this->request->data['loc'];
	    $area = $this->request->data['city'];
	    if($loc != ''){
			$criteria .= " AND (Address.state_id = ".$loc.")";
	    }if($city != ''){
		$criteria .= " AND (Address.city_id = '".$city."')";
	    }
	    if(isset($this->request->data['search']) && $this->request->data['search'] !=""){
		$search = $this->request->data['search'];
		$search_type=$this->request->data['type_of_search'];
		if($search_type == 2){
		    /*** Outlet Search **/
			$criteria .= " AND (Salon.eng_name LIKE'%".$this->request->data['search']."%')";
		    /*** Outlet Search **/
		}if($search_type == 1){
		      /*** Categories Search ****/
		     // pr($this->params->query);exit;
		    //$criteria .= " AND (Service.eng_name LIKE'%".$this->request->data['search']."%')";
		    $salon_service_ids = $this->Common->getSalonServiceidsFname($this->request->data['search']);
		   if(!empty($salon_service_ids)){
		        $salon_service_ids = array_keys($salon_service_ids);
			$salon_service_ids_expl = implode(',',$salon_service_ids);
			$criteria .= " AND (DealServicePackage.salon_service_id IN($salon_service_ids_expl))";    
		    }else{
			$criteria .= " AND (DealServicePackage.salon_service_id =null)";
		    }
		    /*** Categories Search ****/
		}if($search_type == 4){
		    /*** Service Search ****/
		   // pr($this->params->query);exit;
		    $criteria .= " AND (Address.city_id = $area)";
		    /*** Service Search ****/
		}if($search_type == 5){
		    /*** Category Search ****/
		    
		   $cat = $this->Common->getcategory($this->request->data['category']);
		   
		   //$this->Common->getcategory($this->request->data['category']);
		   
		    if(!empty($cat)){
			$s_ids = implode(',',$cat);
			$salon_service_ids = $this->Common->getSalonServiceids($s_ids);
			
			if(!empty($salon_service_ids)){
			    $salon_service_ids = array_keys($salon_service_ids);
			    $salon_service_ids_expl = implode(',',$salon_service_ids);
			    $criteria .= " AND (DealServicePackage.salon_service_id IN($salon_service_ids_expl))";    
			}else{
			    $criteria .= " AND (DealServicePackage.salon_service_id =null)";
			}
			
		    }else{
			$criteria .= " AND (DealServicePackage.salon_service_id =null)";
		    }
		    
		    /*** Service Search ****/
		}
	    }
	    if(isset($this->request->data['select_date']) && $this->request->data['select_date'] !=""){
		
		$day =  strtolower(date('D',strtotime($this->request->data['select_date'])));
		
		$criteria .= " AND (SalonOpeningHour.is_checked_disable_$day)";
		
	    }
	     if(isset($this->request->data['select_time']) && $this->request->data['select_time'] !=""){
		
		//$date = $this->request->data['select_date'];
		//
		//if(!$date){
		//    $date = date("d-m-Y");    
		//}
		//
		//$dayTime =  strtolower(date('l',strtotime($date)));
		//
		//$time = $this->request->data['select_time'];
		//
		// $criteria .=" AND '$time' BETWEEN  (SalonOpeningHour.$dayTime"."_from) AND (SalonOpeningHour.$dayTime"."_to)";
		
		   
	    }
	    if(isset($this->request->data['service_to']) && $this->request->data['service_to'] !=""){
			$seviceTo = trim($this->request->data['service_to']);
			$criteria .= " AND (Salon.service_to LIKE '%".$seviceTo."%')";
	    }
	    if(isset($this->request->data['i_want']) && $this->request->data['i_want'] !=""){
			$iWant = $this->request->data['i_want'];
			
			if($iWant == "menu"){
				$criteria .= " AND (Deal.type LIKE 'Service')";
			}else if($iWant == "package"){
				$criteria .= " AND (Deal.type LIKE 'Package')";
			}else if($iWant == "spaday"){
				$criteria .= " AND (Deal.type LIKE 'Spaday')";
			}
	    }
	    // For treatment search
		if(isset($this->request->data['service_id']) && !empty($this->request->data['service_id'])){
		    $ids = $this->request->data['service_id'];
		   // pr($this->request->data);
		    $i = '';
		    if(is_array($ids) && !empty($ids)){
			
			$i = implode(',',$ids);
			$salon_service_ids = $this->Common->getSalonServiceids($i);
			
			if(!empty($salon_service_ids)){
			    $salon_service_ids = array_keys($salon_service_ids);
			    $salon_service_ids_expl = implode(',',$salon_service_ids);
			    $criteria .= " AND (DealServicePackage.salon_service_id IN($salon_service_ids_expl))";    
			}else{
			    $criteria .= " AND (DealServicePackage.salon_service_id =null)";
			}
			 }else{
			     $criteria .= " AND (DealServicePackage.salon_service_id =null)";
			 }
		}
		if(isset($this->request->data['sold_as']) && $this->request->data['sold_as'] !=""){
			$sold = $this->request->data['sold_as'];
			//echo $sold;exit;
			if($sold == 1){
			    $criteria .= " AND (PolicyDetail.enable_online_booking = 1)";

			}if($sold == 2){
			    $criteria .= " AND (PolicyDetail.enable_gfvocuher = 1)";

			}if($sold == 3){
			    $criteria .= " AND (SalonOutcallConfiguration.mandatory= 1)";
			}
		}
		//min price range
		if(isset($this->request->data['min_price']) && $this->request->data['min_price'] !=""){
			$minPrice = $this->request->data['min_price'];
			$maxPrice = $this->request->data['max_price'];

			// service_pricing_options
			$criteria .= " AND (DealServicePackagePriceOption.deal_price >= $minPrice AND DealServicePackagePriceOption.deal_price <= $maxPrice )";
			//die;
		}
		
	    if(isset($this->request->data['sort_by']) &&  ($this->request->data['sort_by']!='')){
                if($this->request->data['sort_by']=='DESC'){
                    $order = 'Deal.created DESC';
                } if($this->request->data['sort_by']=='ASC'){
                    $order = 'Deal.created ASC';
                }
	    }
	    // Advertisment Block
	    
	    $banner_state=$this->request->data['User']['country_id'];
	    $banner_city=$this->request->data['loc'];
	    $conditions= "SalonAd.status = 1 and SalonAd.is_deleted = 0 and SalonAd.type = 1 and page=3 ";
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
		$joins=array(
		    array(
			"table" => "city_to_ads",
			"alias" => "CityAds",
			"type" => "inner",
			"conditions" => array(
			    "CityAds.add_id= SalonAd.id and CityAds.city_id=$banner_city"
			)
		    )
		);
	    }else{
		$joins=array();
	    }
	    $banner_list = $this->SalonAd->find('all' , 
		array(
		    'joins'=>$joins,
		    'conditions' => array($conditions),
		    'fields' => array('SalonAd.id','SalonAd.user_id','SalonAd.image','SalonAd.eng_description'),
		    'order' => 'rand()',
		    'limit' => 10,
		)
	    );
	}else{
	    $conditions= 'SalonAd.status = 1 and SalonAd.is_deleted = 0 and SalonAd.type = 1 and page=3';
	    $banner_list = $this->SalonAd->find('all' , 
		array(
		    'conditions' => array($conditions),
		    'fields' => array('SalonAd.id','SalonAd.user_id','SalonAd.image','SalonAd.eng_description'),
		    'order' => 'rand()',
		    'limit' => 10,
		)
	    );
	    if(isset($stateCook) && ($stateCook !='not_set')){
		$criteria .= " AND (Address.state_id = '".$stateCook."')";
	    }
	}
	$joins = array(
		array(
		    'table'=>'users',
		    'type'=>'left',
		    'alias'=>'User',
		    'conditions'=>array('User.id = Deal.salon_id')
		),
		array(
		    'table'=>'deal_service_package_price_options',
		    'type'=>'left',
		    'alias'=>'DealServicePackagePriceOption',
		    'conditions'=>array('DealServicePackagePriceOption.deal_id = Deal.id')
		),
		array(
		    'table'=>'addresses',
		    'type'=>'left',
		    'alias'=>'Address',
		    'conditions'=>array('Address.user_id = User.id')
		),
		array(
		    'table'=>'deal_service_packages',
		    'type'=>'left',
		    'alias'=>'DealServicePackage',
		    'conditions'=>array('DealServicePackage.deal_id = Deal.id')
		),
		array(
		    'table'=>'salons',
		    'type'=>'left',
		    'alias'=>'Salon',
		    'conditions'=>array('Salon.user_id = User.id')
		),
		array(
		    'table'=>'policy_details',
		    'type'=>'left',
		    'alias'=>'PolicyDetail',
		    'conditions'=>array('PolicyDetail.user_id = User.id')
		),
		array(
		    'table'=>'salon_outcall_configurations',
		    'type'=>'left',
		    'alias'=>'SalonOutcallConfiguration',
		    'conditions'=>array('SalonOutcallConfiguration.user_id = User.id')
		),
		array(
		    'table'=>'salon_opening_hours',
		    'type'=>'left',
		    'alias'=>'SalonOpeningHour',
		    'conditions'=>array('SalonOpeningHour.user_id = User.id')
		)
	    );
	
	    $fields = array('User.id','User.username','User.image', 'Salon.eng_name','Salon.logo', 'Salon.ara_name','Salon.email','Salon.eng_description','Salon.business_url', 'Salon.ara_description',/*'VenueImages.image',*/
			   'Address.latitude','Address.po_box','Address.city_id','Address.state_id','Address.longitude','Address.address','Deal.*'/*'SalonService.id','Service.eng_name','SalonService.outcall_service','FacilityDetail.*','SalonServiceDetail.sold_as',
			   'ServicePricingOptions.full_price','ServicePricingOptions.sell_price'*/
	    );
	    //pr($criteria);
	    //pr($fields);
	    //exit;
	    $this->Paginator->settings =  array(
			'conditions'=>$criteria,
			'limit'=>15,
			'fields'=>$fields,
			'order' =>$order,
			'joins'=>$joins,
			'group'=>'Deal.id'
		);
	    $allDeals = $this->Paginator->paginate('Deal');
	    $countryData = $getTreat = $getTreatment = array();
	    $getTreatmentTypes = $this->Service->find('list',array('conditions'=> array('Service.parent_id' =>'0','Service.is_deleted'=>0)));
	    $this->Service->unbindModel(array('hasMany' => array('ServiceImage')));
	    if(!empty($getTreatmentTypes)){
	       foreach($getTreatmentTypes as $key => $service){
		   $getTreatment[$key] = $this->Service->query("SELECT Service.* FROM `services` as Service where id in (select distinct parent_id from services) AND parent_id = $service AND is_deleted=0" ) ;
	       }
	    }
	    $countryData = $this->Common->getCountries();
	    $dealData = $this->Deal->find('all',array('conditions'=>$criteria,'fields'=>$fields,'joins'=>$joins,'group'=>'Deal.id'));
	    $imgPath = '';
	    $locations = $information =array();
	    $loc = $info ='';
	    if(!empty($dealData)){
		foreach($dealData as $val){
		       if(!empty($val['Address']['address']) && !empty($val['Address']['latitude']) && !empty($val['Address']['longitude'])){
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
		       $dealName=$val['Deal']['eng_name'];
		       $salURL = Router::url(array('controller' => 'Place', 'action' => 'index','admin'=>false,$val['User']['id']),true);
		       $stylistAddress=$val['Address']['address'];
		       $information[] = '["<div class=\"info-window\"><div class=\"pull-left\"><img  src=\"'.$imgPath.'\"></div><div class=\"lft-space\"><h4><a href=\"'.$salURL.'\" target=\"_blank\" title=\"'.$dealName.'\"> '.$dealName.'</a></h4><p>'.$stylistAddress.'</p><p>'.$salName.'</p></div></div>"]';
		       }
		}
		if(!empty($locations)){
		    $loc =  implode(',',$locations);
		}if(!empty($information)){
		    $info = implode(',',$information);
		}  
	   }
	    
	    
	    
	   // $loc = $this->request->data['User']['country_id'];
	   // $city = $this->request->data['location'];
	   // $area = $this->request->data['city'];
	    
	    if(isset($this->request->data) && !empty($this->request->data)){
		//pr($this->request->data); die;
	    }
	    
	    
	    
	    //echo "hihi"; pr($banner_list); 
	    $this->set(compact('allDeals','getTreatment','loc','info','stateCook','banner_list'));
	    if($this->request->is(array('ajax'))){
	       $this->layout = 'ajax'; 
	       $this->viewPath = "Elements/frontend/Deals";
	       $this->render('middle-add');
	    }
	    
  }
    
    
    public function appointment() {
	$this->Session->delete('point_detail'); 
        $this->Session->delete('gift_detail');
        
	if($this->Session->read('appointmentData')){
            $appointmentData = $this->Session->read('appointmentData');
        }
	//pr($appointmentData); die;
        if($this->request->is('post') || $this->request->is('put')){
            $appointmentData = $this->request->data;
		//pr($appointmentData); die;
		if(isset($appointmentData['Appointment']['thetype']) && ($appointmentData['Appointment']['thetype']=='Package' || $appointmentData['Appointment']['thetype']=='Spaday')){
		  $appointmentData['Appointment']['selected_quantity'] = $appointmentData['Appointment']['quantity'];
		  $appointmentData['Appointment']['price'] = $appointmentData['Appointment']['package_price'];
		  $appointmentData['Appointment']['selected_date'] = $appointmentData['Appointment']['package_date'];
		}else{
		  $appointmentData['Appointment']['package_date'] = $appointmentData['Appointment']['selected_date'];
		  $appointmentData['Appointment']['thetype'] = 'Service';  
		}
	     //pr($this->request->data);die;
            $this->Session->write('appointmentData',$appointmentData);
        }
        if(empty($appointmentData)){
            $this->redirect(array('controller'=>'Homes','action'=>'index'));
        }else{

	    
	    $taxes = $this->Common->getTax($this->Auth->user('id'));
            $this->LoadModel('Deal');      $this->LoadModel('User');
	    $dealId = $appointmentData['Appointment']['deal_id'];
	    $DealData = $this->Deal->findById($dealId); 
            $dealOwner = $this->User->findById($DealData['Deal']['salon_id']);
            $salon_id = $DealData['Deal']['salon_id'];
            /*************************************check for the frenchise user ************************************/
             if($dealOwner['User']['parent_id'] !=0){
		    $frechiseDetail = $this->User->findById($dealOwner['User']['parent_id']);
                    if(count($frechiseDetail)){
                         if($frechiseDetail['User']['type']==2){
			   $salon_id =  $frechiseDetail['User']['id'];
                         } 
                    }
             }
	    $ownerPolicy = $this->Common->policyDetail($salon_id);
	    $total_points = $this->Common->totalPoints($salon_id);
             // total duration hours
            $totalHoursFinal = '';
            if($appointmentData['Appointment']['theBuktype']== "appointment" && ($appointmentData['Appointment']['thetype']== "Package" || $appointmentData['Appointment']['thetype']== "Spaday")){
		$durationArray = array();
                foreach($appointmentData['Appointment']['service'] as $packageService){
                    $durationArray[] = $packageService['duration'];
                }
                $totalHours =  array_sum($durationArray);
                $totalHoursFinal = $this->Common->get_mint_hour($totalHours);
            }else if($appointmentData['Appointment']['theBuktype']== "appointment" && $appointmentData['Appointment']['thetype'] == 'Service'){
		$totalHoursFinal = $this->Common->get_mint_hour($appointmentData['Appointment']['duration']);
	   
	    }
	   $pointsVal = $this->Common->pointsValue();
	    //pr($pointsVal);
	      $this->set(compact('DealData','totalHoursFinal','dealOwner','ownerPolicy','userDetail','totalPoints','pointsVal','salon_id','taxes'));
        }

        // pr($this->Session->read('appointmentData')); die;
        $this->set('theData',$appointmentData);
	    
    }
    
    
    /**********************************************************************************    
    @Function Name : showPackage
    @Params	 : NULL
    @Description   : for displaying booking on the salon package page.
    @Author        : Sanjeev
    @Date          : 
    ******************************************************************************************/
   
    public function showDeal($dealId = NULL, $empId = NULL,$salonId = NULL, $apntmntORevchrID = NULL){
	    // die('hererer');
	    $criteria ="Deal.id =$dealId AND Deal.salon_id = $salonId AND Deal.is_deleted = 0 AND Deal.status = 1 AND (Deal.listed_online = 0 OR (Deal.listed_online = 1 AND Deal.listed_online_start <= DATE(NOW())) OR (Deal.listed_online = 2 AND Deal.listed_online_end <= DATE(NOW())) OR (Deal.listed_online = 3 AND (Deal.listed_online_start <= DATE(NOW()) OR Deal.listed_online_end >= DATE(NOW()))))";
            $order = 'Deal.created DESC';    
            $dealData  = $this->Deal->find('first',array('conditions'=>$criteria));
            $this->set(compact('dealData','salonId'));
    }
    
    public function deal_package_sess(){
	$this->autoRender = false;
	$id = $this->request->data['deal_id'];
	//$this->Session->write('Deal.is_deal_book' , true);
	$this->Session->write('Deal.id' , $id);
	return true;
    }
    
    
    public function payment($deal_id=NULL,$user_id = NULL,$type=NULL){
	            if(!$this->Session->read('appointmentData')){
			$this->Session->setFlash('Unauthorized Access.', 'flash_success');
			$this->redirect(array('controller'=>'homes','action'=>'index'));
		    }
		    $this->loadModel('GiftCertificate');
                    $this->loadModel('Appointment');
                    $order_status_val = '';	
                    $order_status="";
                    $tracking_id = '';
                    $amount = '';
                    $gift_id ='';
                    $point_given = '';
                    $status_message ='';
                    $point_used_status = false;
                    $gift_used_status = false;
                    $orignal_amount = 0;
                    $point_used = 0;
                    $ser_sell_price = 0;
                    $gift_amount_used = $ser_full_price = 0; 
                    $appointment_detail = $this->Session->read('appointmentData.Appointment');   
                    //pr($appointment_detail); die;
                    if($deal_id && $user_id){
                        $user_id = $user_id;
                         if($type=='points'){
                            // pr($this->request->data);
                            $total_points = $this->request->data['Points']['total_points'];
                            $redeem_points = $this->request->data['Points']['points_redeem'];
                            //pr($total_points);
                            //die;
                            $redeem_points = $appointment_detail['selected_quantity']*$redeem_points;
                            $point_left = $total_points - $redeem_points;
                            $point_used = $redeem_points;
                            $amount = 0;
                            $order_status = 'points';
                            $status_message = 'purchase by points';
                        }else if($type=='gift'){
                                $gift_detail  = $this->Session->read('gift_detail');
                                if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                                    $this->GiftCertificate->recursive = -1;
                                    $giftDetail = $this->GiftCertificate->find('first' ,array('conditions'=>array('GiftCertificate.id'=>$gift_detail['point']['use_gift_id']),'fields'=>array('amount')));
                                    $gift_amount = $giftDetail['GiftCertificate']['amount'];
                                    $service_amount = $this->request->data['Points']['amnt'];
                                    $amount_left = $gift_amount - $service_amount;
                                    if($amount_left > 0){
                                        $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $this->GiftCertificate->saveField('amount',$amount_left);
                                    }else{
                                        $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $this->GiftCertificate->saveField('is_used',1);
                                    }
                                    $gift_amount_used = $service_amount;
				    $amount = 0;
                                    $order_status = 'gift';
                                    $gift_id = $gift_detail['point']['use_gift_id'];
                                    $status_message = 'purchase by gift card'; 
                                } 
                        }else if($type=='payment'){
                            $amount = $this->request->data['Appointment']['amount'];
                            $status_message = 'before payment'; 
                            $order_status = 'payment';
                        }else{
                                $workingKey=Configure::read('working_key'); 	//Working Key should be provided here.
                                $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
                                $rcvdString=$this->Crypto->decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.			
                                $order_status_val = '';	
                                $order_status="";
                                $tracking_id = '';
                                $amount = '';
                                $decryptValues=explode('&', $rcvdString);
                                $dataSize=sizeof($decryptValues);
                                for($i = 0; $i < $dataSize; $i++) 
                                {
                                    $information=explode('=',$decryptValues[$i]);
                                    if($i==0){ $order_id = $information[1];}
                                    if($i==3)	{ $order_status=$information[1]; }
                                    if($i==1)	{ $tracking_id=$information[1]; }
                                    if($i==10)	{ $amount=$information[1]; }
                                    if($i==8)	{ $status_message=$information[1]; }
                                }
                               //$order_status  ='Success';
                               $gift_detail =  $this->Session->read('gift_detail');
                               $point_detail  = $this->Session->read('point_detail');
                                if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                                        $gift_amount_used = $this->Common->get_gift_amount($gift_detail['point']['use_gift_id']);
					$this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                        $this->GiftCertificate->saveField('is_used',1);
                                        $gift_id = $gift_detail['point']['use_gift_id'];
                                        $gift_used_status = true;
                                }
                                if(isset($point_detail['point']['is_used_point']) && $point_detail['point']['is_used_point']=='1'){
                                        $used_points = $point_detail['point']['used_point'];
                                        $point_left = 0;
                                        $point_used = $used_points;
                                        $point_used_status = true;
                                } 
                          }
                     if($order_status)
			{     
                            $appointment_status = ($order_status==="Success")?4:5;
                            if($order_status==="Success")
                            {
                             $appointment_status  =4;
                             $order_status_val = 1;   
                            }else if($order_status==="Aborted")
                            {
                                $order_status_val = 2;
                                $appointment_status  =5;
                            }
                            else if($order_status==="Failure")
                            {
                               $order_status_val = 3;
                               $appointment_status  =5;
                            }
                            else if($order_status==="points")
                            {
                              $order_status_val = 5;
                              $appointment_status  =4;
                            }else if($order_status==="gift")
                            {
                              $order_status_val = 6;
                              $appointment_status  =4;
                            }else if($order_status==="payment")
                            {
                              $order_status_val = 9;
                              $appointment_status  =5;
                            }else{
                              $order_status_val = 5;       
                            }     
                        $this->loadModel('Deals');
			$this->loadModel('UserCount');
			$this->loadModel('UserPoint');
                        $this->loadModel('Order');
			$this->loadModel('OrderDetail');
                        $this->loadModel('User');
			$this->loadModel('PolicyDetail');
                        //$this->SalonService->unbindModel(array('hasMany'=>array('SalonServiceImage','SalonStaffService','PackageService')));
                        //$this->SalonService->recursive = 2;
		        $dealId = $appointment_detail['deal_id'];
			//pr($appointment_detail);
			$this->Deal->recursive = 2;
			$DealData = $this->Deal->findById($dealId); 
			$dealOwner = $this->User->findById($DealData['Deal']['salon_id']);
			$salon_id = $DealData['Deal']['salon_id'];
			  // pr($DealData);  
			 //die;
                        $vocuher_expire = $DealData['Deal']['avail_time'];
			
			//pr($vocuher_expire);
			//die;
			
                        if($order_status==="Success" || $order_status==="points" || $order_status==="gift" || $order_status==="payment")
                        {
                            $this->loadModel('Evoucher');
                            $pack_price = $appointment_detail['price']*$appointment_detail['selected_quantity'];
                            $tax_data  = $this->Common->get_vendor_dues($pack_price,$salon_id,$dealOwner['User']['discount_percentage'],$appointment_detail['price']);
			    if($order_status == 'payment' || $order_status == 'gift' || $order_status==="points"){
				    $order['Order']['first_name'] = $this->request->data['Appointment']['first_name'];     
				    $order['Order']['last_name'] = $this->request->data['Appointment']['last_name'];
				    $phone_code =  str_replace('+','',$this->request->data['Appointment']['country_code']);
				    $order['Order']['phone_number'] = $phone_code.$this->request->data['Appointment']['billing_tel'];    
				    unset($this->request->data['Appointment']['country_code']);
				    //pr($order);
			    }
			    $order['Order']['transaction_id'] = $tracking_id;     
			    $order['Order']['appointment_id'] = '';
			    $order['Order']['user_id'] = $user_id;
			    $order['Order']['employee_id'] ='';
			    $order['Order']['points_used'] =$point_used;
			    $order['Order']['salon_id'] =$DealData['Deal']['salon_id'];
			    $order['Order']['salon_service_id'] =$DealData['Deal']['id'];
			    $display_order_id = $this->Common->getRandPass(10);
			    $order['Order']['display_order_id'] = $display_order_id;
			    if($appointment_detail['theBuktype'] == 'eVoucher'){
			       $order['Order']['service_type'] = 7;
			       $order['Order']['start_date'] = date('Y-m-d');
			       $order['Order']['order_avail_status'] = 1;
			    }else{
                                $order['Order']['service_type'] = 5;
				$order['Order']['start_date'] = date('Y-m-d' , strtotime($appointment_detail['package_date']));
                            }
			    $order['Order']['price_option_id'] = '';
			    if($point_used_status || $gift_used_status){
			      $order['Order']['transaction_status'] = ($point_used_status)?8:7; 
			    }else{
			      $order['Order']['transaction_status'] = $order_status_val; 
			    }
			    $order['Order']['display_order_id'] = $this->Common->getRandPass(10);
			  
			    $order['Order']['amount'] = $amount;
			    $order['Order']['gift_amount'] = $gift_amount_used;
			    $order['Order']['orignal_amount'] = $appointment_detail['price'];
			    $order['Order']['transaction_message'] = $status_message;
			    $order['Order']['eng_service_name'] = $DealData['Deal']['eng_name'];
			    $order['Order']['ara_service_name'] = $DealData['Deal']['ara_name'];
			    $order['Order']['used_gift_id'] = $gift_id;
			    $order['Order']['service_price_with_tax'] = $tax_data['service_price_with_tax'];
			    $order['Order']['deduction1'] =$tax_data['tax_admin']['TaxCheckout']['deduction1'];
			    $order['Order']['deduction2'] = $tax_data['tax_admin']['TaxCheckout']['deduction2'];
			    $order['Order']['sieasta_commision'] = $tax_data['sieasta_comission_price'];
			    $order['Order']['total_deductions'] = $tax_data['total_deductions'];
			    $order['Order']['vendor_dues'] = $tax_data['vendors_dues'];
			    $order['Order']['tax1'] = $tax_data['tax_vendor']['TaxCheckout']['tax1'];
			    $order['Order']['tax2'] = $tax_data['tax_vendor']['TaxCheckout']['tax2'];
			    $order['Order']['tax_amount'] = $tax_data['tax_amount'];
			    $order['Order']['sieasta_commision_amount'] = $tax_data['sieasta_comission'];
			    $order['Order']['saloon_discount'] = $dealOwner['User']['discount_percentage'];
			    $order['Order']['is_admin_tax'] = $tax_data['is_admin_tax'];
			    $order['Order']['tax1_amount'] = $tax_data['tax1_amount'];
			    if(isset($appointment_detail['thetype']) && trim($appointment_detail['thetype']) =='Spaday'){
			      $order['Order']['check_in'] =  $DealData['Deal']['check_in'];
			      $order['Order']['check_out'] = $DealData['Deal']['check_out'];  
			    }
			    $fields = array('User.first_name','User.last_name','UserDetail.booking_incharge','UserDetail.email_reminder','User.email','Address.*','Contact.*');
			    if($order_status==="Success" || $order_status==="Aborted" || $order_status==="Aborted"){
				 $this->Order->id = $order_id;
			    }
                            
                            //pr($order);
			if($this->Common->add_customer_to_salon($user_id,$DealData['Deal']['salon_id'])){
			    if($this->Order->save($order , false)){
			         if($order_status==="Success"){
				       $this->Order->id = $order_id;
				    }else{
					$order_id =   $this->Order->id;   
				    }
				    
			     if(isset($point_used) && !empty($point_used)){
                                  $user_count['UserPoint']['points_deducted'] = $point_used;
                                  $user_count['UserPoint']['salon_id'] = $DealData['Deal']['salon_id']; 
                                  $user_count['UserPoint']['user_id'] = $user_id;                                  
                                  $user_count['UserPoint']['order_id'] = $order_id;
                                  $user_count['UserPoint']['type'] = 1; 
                                  $this->UserPoint->create();
                                  $this->UserPoint->save($user_count , false);
                                  $user_point_id = $this->UserPoint->id;
                                 /*********************** total redeem points **************/
                                    $salon_id =  $packageDetail['Package']['user_id']; 
                                    $points  = array();
                                    $points['user_id'] = $user_id;
                                    $points['salon_id'] = $salon_id;
                                    $points['used_points'] = $point_used;
                                    $points['user_point_id'] = $user_point_id;
                                    $points['order_id'] = $order_id;
                                    $this->redeem_points($points);
                                 }	    
				    
			    if($order_status==="gift" && isset($amount_left) && $amount_left > 0){
				  $this->loadModel('GiftDetail');
				  $giftDetail['amount_used'] = $pack_price;
				  $giftDetail['order_id'] = $order_id;
				  $giftDetail['gift_id'] = $gift_id;
				  $this->GiftDetail->save($giftDetail , false);
			    }
			    if($order_status !='Success'){
				    //pr($appointment_detail);
				    //pr($DealData);
				    if(isset($DealData['Deal']['type']) && ($DealData['Deal']['type']=='Package' || $DealData['Deal']['type']=='Spaday')){
				      $seletedPrice = explode('-' ,$appointment_detail['package_price_opt']);
				    }else{
				       $seletedPrice[0] = $appointment_detail['price_id']; 
				    }
				    $i = 0;
				    
				  
				   foreach($DealData['DealServicePackage'] as $priceOption){
				    foreach($priceOption['DealServicePackagePriceOption'] as $priceOpt){
					if(trim($seletedPrice[$i]) == $priceOpt['id']){
						$duration = $priceOpt['duration'];
						$price = $priceOpt['deal_price'];
						$price_opt_id = $priceOpt['id'];
						$package_service_id = $priceOpt['salon_service_id'];
						$totalDuration = isset($totalDuration) ? $totalDuration + $priceOpt['duration'] :$priceOpt['duration'];
						$totalPrice = $priceOpt['deal_price'];
					 }
				    }
				    $order_detail['OrderDetail']['price'] = $price;
				    $order_detail['OrderDetail']['order_id'] = $order_id;
				    $order_detail['OrderDetail']['user_id']=$user_id;
				    $order_detail['OrderDetail']['appointment_price']=$price;
				    $order_detail['OrderDetail']['salon_id'] = $salon_id;
				    $order_detail['OrderDetail']['price_option_id'] = $price_opt_id;
				    $serviceDetail = $this->Common->getServiceDetail($priceOption['salon_service_id']);
				    $order_detail['OrderDetail']['eng_service_name'] =  $serviceDetail['SalonService']['eng_name'];
				    $order_detail['OrderDetail']['ara_service_name'] =  $serviceDetail['SalonService']['ara_name'];
				    $order_detail['OrderDetail']['package_service_id'] = $package_service_id;
				    $order_detail['OrderDetail']['service_id'] = $package_service_id;
				    //$order_detail['OrderDetail']['option_duration'] = $totalDuration;
                                    $order_detail['OrderDetail']['option_price'] = $totalPrice;
				    $order_detail['OrderDetail']['duration'] = $duration;
				    $this->OrderDetail->create();
				    $this->OrderDetail->save($order_detail , false);
				    $i++;
				  }
				  $this->OrderDetail->updateAll(
					array('OrderDetail.option_duration' => $totalDuration), 
					array('OrderDetail.order_id' =>$order_id)
				  );
                              }
				//die('hererer');
				 if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
					if($appointment_detail['theBuktype'] == 'eVoucher'){
					 $recipient_name = $this->request->data['Appointment']['recipient_name'];
					 $recipient_message = $this->request->data['Appointment']['recipient_message'];
					 $this->loadModel('Evoucher');
					 $quantity = $appointment_detail['selected_quantity'];
					 $vocher_code = $this->Common->getRandPass(8);
					 for($i =1; $i<=$quantity; $i++){
					     $evoucher['Evoucher']['order_id'] = $order_id;
					     $evoucher['Evoucher']['salon_id'] = $salon_id;
					     $evoucher['Evoucher']['user_id'] = $user_id;
					     $evoucher['Evoucher']['price'] = $tax_data['service_price_tax'];
					     $evoucher['Evoucher']['evoucher_type'] = 4;
					     $evoucher['Evoucher']['expiry_date'] = $recipient_name;
					     $evoucher['Evoucher']['expiry_date'] = $vocuher_expire;
					     $evoucher['Evoucher']['vocher_code'] = $vocher_code;
					     $evoucher['Evoucher']['reciepent_message'] = $recipient_message;
					     $this->Evoucher->create();
					     $this->Evoucher->save($evoucher);
					 }
				     }
				if($appointment_detail['theBuktype'] != 'eVoucher'){
                                    //pr($DealData);
                                    //pr($appointment_detail);
                                    if(isset($DealData['Deal']['type']) && ($DealData['Deal']['type']=='Package' || $DealData['Deal']['type']=='Spaday')){
				      $seletedPrice = explode('-' ,$appointment_detail['package_price_opt']);
				    }else{
				       $seletedPrice[0] = $appointment_detail['price_id']; 
				    }
				    $j = 0;
				    $ret_provider_status =  $this->Common->EmailTemplateType($DealData['Deal']['salon_id']);

                                    foreach($DealData['DealServicePackage'] as $priceOption){
					//pr($priceOption['DealServicePackagePriceOption']); 
					foreach($priceOption['DealServicePackagePriceOption'] as $priceOpt){
                                            if(trim($seletedPrice[$j]) == $priceOpt['id']){
                                                    $duration = $priceOpt['duration'];
                                                    $price = $priceOpt['deal_price'];
                                                    $price_opt_id = $priceOpt['id'];
                                                    $package_service_id = $priceOpt['salon_service_id'];
                                                    $totalDuration = isset($totalDuration) ? $totalDuration + $priceOpt['duration'] :$priceOpt['duration'];
                                                    $totalPrice = $priceOpt['deal_price'];
                                             }
                                        }
					$serviceDetail = $this->Common->getServiceDetail($priceOption['salon_service_id']);
                                        $serviceId = $serviceDetail['SalonService']['id'];
                                        $this->request->data['Appointment']['order_id'] = $order_id;
                                        $this->request->data['Appointment']['salon_service_id'] = $serviceDetail['SalonService']['id'];
                                        if($appointment_detail['thetype']=='Spaday' || $appointment_detail['thetype']=='Package'){
                                            $staff_id = trim($appointment_detail['service'][$serviceId]['stylist']);
                                         }else{
					     $staff_id = trim($appointment_detail['selected_employee_id']);
					}
					 $this->request->data['Appointment']['salon_staff_id'] = $staff_id;
					 $this->request->data['Appointment']['appointment_title']=$serviceDetail['SalonService']['eng_name'];
                                        // $this->request->data['Appointment']['appointment_price'] = $appointment_detail['price'];
                                        
                                        $this->request->data['Appointment']['appointment_duration'] = $duration;
                                        $this->request->data['Appointment']['user_id']=$user_id;
                                        $this->request->data['Appointment']['appointment_price']=$price;
                                        $this->request->data['Appointment']['appointment_created']=date('Y-m-d h:i:s');
                                        $this->request->data['Appointment']['appointment_repeat_type'] = 0;
                                        if($appointment_detail['thetype']=='Spaday' || $appointment_detail['thetype']=='Package'){
                                            $this->request->data['Appointment']['package_id'] = $appointment_detail['package_id'];
                                            $this->request->data['Appointment']['startdate'] = $appointment_detail['package_date'];
                                            $selected_time = trim($appointment_detail['service'][$serviceId]['time']);
					    $this->request->data['Appointment']['appointment_start_date']= strtotime($appointment_detail['package_date'].' '.$selected_time);
                                        }else{
					    $selected_time = $appointment_detail['selected_time'];
                                            $this->request->data['Appointment']['startdate'] = $appointment_detail['selected_date'];
					    $this->request->data['Appointment']['appointment_start_date']= strtotime($appointment_detail['selected_date'].' '.trim($appointment_detail['selected_time']));
                                        }
                                        $this->request->data['Appointment']['deal_id'] = $appointment_detail['deal_id'];
                                        $this->request->data['Appointment']['type'] = 'D';
                                        $this->request->data['Appointment']['appointment_return_request'] = 'NR';
                                        $this->request->data['Appointment']['status'] = $appointment_status;
					$this->request->data['Appointment']['payment_status'] = 2;
                                        $this->request->data['Appointment']['salon_id'] = $serviceDetail['SalonService']['salon_id'];
                                        $this->Appointment->create();
                                        $this->Appointment->save($this->request->data['Appointment'],false);
                                        $AppointementsIds[] = $this->Appointment->id;
                                        $j++;
					    if($appointment_detail['theBuktype'] != 'eVoucher'){
                                                     $orderData = $this->Common->get_Order($order_id); 
                                                     $display_order_id = @$orderData ['Order']['display_order_id'];
                                                    $ServiceUser = $this->User->find('first', array('conditions'=>array('User.id'=>$staff_id,'User.status'=>1)));
                                                    //pr($ServiceUser); die;
                                                    if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
                                                                $time = $selected_time;
                                                                $date = $appointment_detail['package_date'];
                                                                $service_name = $serviceDetail['SalonService']['eng_name'];
                                                                if($ret_provider_status['SalonEmailSms']['business_sms_notify_provider']==1){
                                                                    $message = "You have new  appointment for the Service  $service_name  on date : $date $time .Your Order id is $display_order_id";
                                                                    $this->sendPhoneMessage($ServiceUser, $orderData,$message,'vendor');
                                                                 }
                                                                if($ret_provider_status['SalonEmailSms']['business_nofity_provider']==1){    
								    $this->sendUserEmail($ServiceUser, $serviceDetail,$display_order_id ,$amount ,'new_appointment',$duration,'vendor');
								    //$this->sendUserDealEmail($ServiceUser, $serviceDetail,$display_order_id ,$amount ,'new_appointment',$duration,'vendor');
                                                                }    
                                                     }
                                                }
					
                                    }
                                   }
				   $this->loadModel("Deal");
				    $quantity = $appointment_detail['selected_quantity'];
				    $this->Deal->updateAll(
                                        array('Deal.purchased_quantity' => "Deal.purchased_quantity+$quantity"),      
                                        array('Deal.id' => $dealId)
				    );
				    $orderData = $this->Common->get_Order($order_id); 
                                    $display_order_id = @$orderData ['Order']['display_order_id'];
				    $package_salon_id = $DealData['Deal']['salon_id'];
				    $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$package_salon_id,'User.id'=>$package_salon_id))));
				    if($appointment_detail['theBuktype'] == 'eVoucher'){
					$voucher_data =  $this->Common->get_voucherCode($order_id);
				    } 
				    foreach($SalonBookingIncharges as $incharge){
					if($incharge['UserDetail']['booking_incharge']==1){
					     if($appointment_detail['theBuktype'] == 'eVoucher'){
						 $deal_name = $DealData['Deal']['eng_name'];
						 $voucher_code =$voucher_data['Evoucher']['vocher_code']; 
						 $message = " A new   deal $deal_name Evocuher  has been sold.Your Order id is $display_order_id";
						 $this->sendUserDealEmail($incharge, $orderData, $DealData ,$amount ,'evocuher_package_sold','vendor');
						 $this->sendPhoneMessage($incharge, $orderData, $DealData,$message,'vendor');
						 
					     }else{
						 $deal_name = $DealData['Deal']['eng_name'];
						 $deal_date  = $appointment_detail['selected_date'];
						 $message = "You have an $deal_name Deal  appointment on $deal_date </br> Order Id is $display_order_id </br>www.Sieasta.com";
						 //$this->sendUserDealbookingEmail($incharge, $orderData, $DealData ,$amount ,'evocuher_package_sold','vendor');
						 $this->sendPhoneMessage($incharge, $orderData, $DealData,$message,'vendor');
					     }
					 }
				    }    
			 }
				if($order_status !='payment'){
				    $userDetail = $this->User->find('first', array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
				    $orderDet = $this->Common->get_Order($order_id); 
                                    if($order_status==="Success" || $order_status==="gift" || $order_status==="points")
				    {
					$salon_name = $dealOwner['Salon']['eng_name'];
					$deal_name = $DealData['Deal']['eng_name'];					
					$display_order_id = @$orderDet ['Order']['display_order_id'];
					 if($appointment_detail['theBuktype'] == 'eVoucher'){
					     $voucher_code =$voucher_data['Evoucher']['vocher_code']; 
					     $message = " Your order  for deal  $deal_name $voucher_code with Salon $salon_name has been confirmed.Your Order is $display_order_id";
						$this->sendUserDealEmail($userDetail, $orderData , $DealData ,$amount ,'confirmation_spaday');
						$this->sendPhoneMessage($userDetail, $orderData, $DealData,$message,'customer');
						$this->Session->setFlash("Your Deal is booked successfully.", 'flash_success');
						$this->redirect(array('controller'=>'Myaccount','action'=>'orders'));
					    }else{
						$deal_date  = $appointment_detail['selected_date'];
						$message = " Your order  for deal  $deal_name on $deal_date with Salon $salon_name has been confirmed.Your Order ID is $display_order_id";
						$this->sendUserDealEmail($userDetail, $orderData , $DealData ,$amount ,'confirmation_package');
						$this->sendPhoneMessage($userDetail, $orderData, $DealData,$message,'customer');
						$this->Session->delete('appointmentData');
						$this->Session->setFlash("Your order is booked successfully.", 'flash_success');
						$this->redirect(array('controller'=>'Myaccount','action'=>'appointments'));
					    }
				    }else{
					$this->Session->setFlash('Your  transaction has been declined.Please try again.', 'flash_error');
					$this->redirect(array('controller'=>'homes','action'=>'index')); 
				    }
                                }else{
				     if($this->request->is('post') || $this->request->is('put')){
                                          //echo '<pre>';  print_r($this->request->data);  die('herere');
                                          $this->request->data['Appointment']['order_id'] = $order_id;
                                          $working_key=Configure::read('working_key');  //Shared by CCAVENUES
                                          $access_code =Configure::read('access_code');  //Shared by CCAVENUES
                                          $merchant_data =  '';
                                          foreach ($this->request->data['Appointment'] as $key => $value){
                                           $merchant_data.=$key.'='.$value.'&';
                                          }
                                          $encrypted_data = $this->Crypto->encrypt($merchant_data,$working_key);
                                          $this->set(compact('encrypted_data','access_code'));
                                          $this->render('../Bookings/payment');
                                       }
                               }  
			    }else{
				    $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                                    $this->redirect(array('controller'=>'homes','action'=>'index'));  
			      }
			}else{
			    $this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
                            $this->redirect(array('controller'=>'homes','action'=>'index'));  
			}
			}else{
				 $this->Session->setFlash('Your  transaction has been declined due to Illegal access detected.', 'flash_error');
				 $this->redirect(array('controller'=>'homes','action'=>'index'));
			    }
			}else{
				$this->Session->setFlash('Some error occured. Please try again.', 'flash_error');
				 $this->redirect(array('controller'=>'homes','action'=>'index'));
			     }	
		}	
	 } 
    
    
    function sendUserDealEmail($userData=array() , $orderData=array(), $DealData =array(), $amount = null , $template='',$points=NULL, $type=NULL){
					//$ServiceUser, $serviceDetail,$display_order_id ,$amount ,'new_appointment',$duration,'vendor'
	$SITE_URL = Configure::read('BASE_URL');
        $fromEmail = Configure::read('noreplyEmail');
	$firstName = $userData['User']['first_name'];
	$lastName = $userData['User']['last_name'];
	$order_id = $orderData['Order']['display_order_id'];
	$toEmail = $userData['User']['email'];
	if($template=='confirmation_spaday'){
	    $firstName = $orderData['Order']['first_name'];
	    $lastName = $orderData['Order']['last_name'];
	}
	$appointment_detail = $this->Session->read('appointmentData.Appointment');
        $thetype = $appointment_detail['thetype'];
        $service_name = array();
	    foreach($orderData['OrderDetail'] as $serviceDetail){
		$service_names[] =  $serviceDetail['eng_service_name'];
	    }
        $i = 0; 
        $serviceData  = '';
	if($appointment_detail['theBuktype'] == 'eVoucher'){
	    if(!empty($service_names)){
		foreach($service_names as $service_name){
		   $serviceData  .= 'Service Name :' . $service_names[$i].'</br></br>';
		   $i++;
	       }
	    }
	}
	if($appointment_detail['theBuktype'] == 'appointment'){
	       $dynamicVariables['{package_date}']= date('d M,Y',strtotime($appointment_detail['selected_date']));
		 if(!empty($service_names)){
		    foreach($service_names as $service_name){
		    $serviceData  .= 'Service Name :' . $service_names[$i].'</br></br>';
		    $i++;
	       }
	    }
	}
	$dynamicVariables = array(
			      '{FirstName}' => $firstName,
			      '{LastName}' => $lastName,
			      '{amount}' => $amount,
			      '{package_name}'=> $DealData['Deal']['eng_name'],
			      '{order_id}'=>$order_id,
			      '{service}'=> $serviceData,
			      '{package}'=>$thetype,
			     );
       
        if($template =='confirmation_spaday' || $template =='confirmation_package'){
            $salonDetail   =   $this->Common->salonDetail($DealData['Deal']['salon_id']); 
            $dynamicVariables['{Salon}'] = $salonDetail['Salon']['eng_name'];
	    $contact = '';
	    if(!empty($salonDetail['Contact']['day_phone'])){
		$contact = $salonDetail['Contact']['country_code'].' '.$salonDetail['Contact']['day_phone'];    
	    }
	    
            $dynamicVariables['{salon_contact_number}'] = $contact;
            /**************Points varibale is set as duration****************/
        }
        
        if($type=='gift'){
         $dynamicVariables['{gift_amount}'] = $points;   
        }else if($type=='points'){
          $dynamicVariables['{point}'] = $points;      
        }else if($type=='vendor'){
         $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($points);   
        }
	if(isset($appointment_detail['package_date'])){
	   $dynamicVariables['{package_date}'] = $appointment_detail['package_date'];        
	}
	$template_type =  $this->Common->EmailTemplateType($DealData['Deal']['salon_id']);
        if($template_type){
          $dynamicVariables['{template_type}'] = $template_type['SalonEmailSms']['email_format'];   
        }
	
	
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
       
     function sendUserEmail($userData=array() , $serviceDetail = array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;
        $service_name = $serviceDetail['SalonService']['eng_name'];
        $appointment_detail = $this->Session->read('appointmentData.Appointment');
        $thetype = $appointment_detail['thetype'];
        $date = $appointment_detail['package_date'];
        $serviceId = $serviceDetail['SalonService']['id'];
        if(isset($appointment_detail['selected_time'])){
	    $time =  $appointment_detail['selected_time'];
	}else{
	    $time = trim($appointment_detail['service'][$serviceId]['time']);    
	}
	$vendor_msg = $this->Common->get_vendor_message(@$serviceDetail['SalonService']['salon_id']);
        $dynamicVariables = array('{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{amount}' => $amount,
                                  '{time}'=> $time,
                                  '{start_date}'=>$date,
                                  '{service_name}'=>$service_name,
                                  '{order_id}'=>$order_id,
                                  '{vendor_message}' => $vendor_msg
                                  );
        if($type=='gift'){
         $dynamicVariables['{gift_amount}'] = $points;   
        }else if($type=='points'){
          $dynamicVariables['{point}'] = $points;      
        }else if($type=='vendor'){
         $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($points);   
        }
	//pr($dynamicVariables); die;
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
  
    
    
     
    function sendPhoneMessage($userData=array() , $orderData=array(), $DealData =array(),$message=null, $type=NULL){
	  if($userData && $type =='vendor'){
                $number = (isset($getData['Contact']['cell_phone']))?$getData['Contact']['cell_phone']:'';
                $country_id = (isset($getData['Address']['country_id']))?$getData['Address']['country_id']:'';
                if($country_id){
                    $country_code  =   $this->Common->getPhoneCode($country_id);
                       if($country_code){
                          $number = str_replace("+","",$country_code).$number;    
                       }else{
                           $country_code = '+971';
                         $number = str_replace("+","",$country_code).$number;    
                       }
                 }
                    $this->Common->sendVerificationCode($message,$number);
            }else if($type=='customer'){
		$number = $orderData['Order']['phone_number'];
		$this->Common->sendVerificationCode($message,$number);
	    }
        return true;
    } 
    
    
    
    function redeem_points($points=array()){
           $this->autoRender = false;
           $this->LoadModel('UserCount');
                //$points['user_id'] = 2;
               //$points['salon_id'] = 20;
              //$points['used_points'] = 1000; 
            $vendorCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>$points['salon_id'])));
                if(count($vendorCounts)>0){
                        $user_points = $vendorCounts['UserCount']['user_count'];
                        if($user_points > $points['used_points']){
                            $points_left = $user_points-$points['used_points'];
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,$points_left);
                            
                            $points['salon_point'] = $points['used_points'];
                            $points['sieasta_point'] = 0;
                            $this->Common->update_user_point($points);
                            return true;
                        }else if($user_points == $points['used_points']){
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,0);
                            
                            $points['salon_point'] = $points['used_points'];
                            $points['sieasta_point'] = 0;
                            $this->Common->update_user_point($points);
                            return true;   
                        }else if($user_points < $points['used_points']){
                            $points_left = $points['used_points']-$user_points;
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,0);
                            $adminCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>1)));
                                if(count($adminCounts)>0){
                                  $adminPoints = $adminCounts['UserCount']['user_count'];
                                  $admin_left = $adminPoints-$points_left;
                                  $this->UserCount->id = $adminCounts['UserCount']['id'];
                                  $this->UserCount->saveField('user_count' ,$admin_left);
                                }
                                $points['salon_point'] = $user_points;
                                $points['sieasta_point'] = $points_left;
                                $this->Common->update_user_point($points);    
                           return true;
                      }
                }else{
                    $adminCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>1)));
                    if(count($adminCounts)>0){
                          $adminPoints = $adminCounts['UserCount']['user_count'];
                          $admin_left = $adminPoints-$points['used_points'];
                          $this->UserCount->id = $adminCounts['UserCount']['id'];
                          $this->UserCount->saveField('user_count' ,$admin_left);
                          $points['salon_point'] = 0;
                          $points['sieasta_point'] = $points['used_points'];
                          $this->Common->update_user_point($points); 
                        }
                      return true;
                    }   
           }
   
    
    
    /**********************************************************************************    
    @Function Name : dealCron
    @Params	   : NULL
    @Description   : for handling cron job for deals.
    @Author        : Sonam Mittal
    @Date          : 9 Sept 2015
    ******************************************************************************************/
   
    public function dealCron(){
        $this->autoRender = false;
        $today = date('Y-m-d');
        $this->loadModel('Deal');
        $deals = $this->Deal->find('all',array(
            'conditions'=> array(
                'OR' =>
		array(
		    array(
			'Deal.max_time <'=> $today,
		    ),
		     array(
			    'Deal.quantity_type'=>1,
			    'Deal.quantity <= Deal.purchased_quantity'
			)                    
		    )
		),
           
            'recursive'=>-1
        ));
       
	
	//pr($deals);
        //echo "</br>".count($deals)."</br>";
        if(!empty($deals)){
            foreach($deals as $deal){

                /*echo "<ul>";
                echo "<li>status".$deal['Deal']['status']."</br></li>";
                echo "<li>id".$deal['Deal']['id']."</br></li>";
                echo "<li>quantity".$deal['Deal']['quantity']."</br></li>";
                echo " <li>purchased quantity".$deal['Deal']['purchased_quantity']."</br><li>";
                echo "<li>time ".$deal['Deal']['max_time']."</br></li>";
                echo "</ul>";*/
                
                // deactivating deals on server
                $this->Deal->id = $deal['Deal']['id'];
                $this->Deal->saveField('status',0);

            }
        }
    }
     
 }
