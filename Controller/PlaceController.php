<?php
class PlaceController extends AppController {
    public $helpers = array('Session', 'Html', 'Form','js','Js' => array('Jquery')); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Paginator','Image','RequestHandler','Common'); //An array containing the names of components this controller uses.
    
    public function beforeFilter() {
        $this->Auth->allow('index','get_salon_details','spaBreakDates','salon_isgiftcertificate','showSpaBreak','spabreaks','salonservices','salonpackages','getserviceDisplay','salongallery','salongiftcertificate','salondeals','salonspaday','book_stylist','bookmark','ajax_services');
        parent::beforeFilter();
    }
    
/**********************************************************************************    
  @Function Name : index
  @Params	 : NULL
  @Description   : The display salon in frontend
  @Author        : Aman Gupta
  @Date          : 09-Apr-2014
***********************************************************************************/
    public function index($salonId = NULL){
        $this->loadModel('User');
        $this->loadModel('SalonOpeningHour');
        
        $this->User->unbindModel(array('belongsTo'=>array('Group'),
				    'hasOne'=>array('UserDetail'),
				    'hasMany'=>array('PricingLevelAssigntoStaff'))
			      );
        
        $this->User->bindModel(array('hasOne'=>array('FacilityDetail','PolicyDetail')));
        $userDetails = $this->User->find('first',
                        array(
                            'conditions'=>array('User.id'=>$salonId ,'User.status'=>1,'User.front_display'=>1),
                            'fields'=>array(
                                'User.id', 'User.site_url', 'User.booking_status', 'User.front_display',
                                'Salon.id', 'Salon.business_type_id','Salon.user_id', 'Salon.email', 'Salon.eng_name', 'Salon.eng_description', 'Salon.ara_name', 'Salon.ara_description', 'Salon.logo', 'Salon.cover_image', 'Salon.website_url', 'Salon.business_url',
                                'Address.id', 'Address.user_id', 'Address.located_at', 'Address.address', 'Address.address2', 'Address.po_box', 'Address.area', 'Address.country_id', 'Address.state_id', 'Address.city_id', 'Address.latitude', 'Address.longitude',
                                'Contact.id', 'Contact.user_id', 'Contact.country_code', 'Contact.cell_phone', 'Contact.night_phone', 'Contact.day_phone',
                                'FacilityDetail.id',
                                'FacilityDetail.user_id',
                                'FacilityDetail.kids',
                                'FacilityDetail.walk_in',
                                'FacilityDetail.payment_method',
                                'FacilityDetail.parking_fee',
                                'FacilityDetail.wifi',
                                'FacilityDetail.snack_bar',
                                'FacilityDetail.beer_wine_bar',
                                'FacilityDetail.tv',
                                'FacilityDetail.hadicap_acces',
                                'FacilityDetail.other_lang',
                                'FacilityDetail.spoken_language',
                                'FacilityDetail.eng_cancel_policy',
                                'FacilityDetail.ara_cancel_policy',
                                'FacilityDetail.eng_special_instruction',
                                'FacilityDetail.ara_special_instruction',
                                'PolicyDetail.id','PolicyDetail.user_id', 'PolicyDetail.enable_gfvocuher', 'PolicyDetail.enable_sieasta_voucher', 'PolicyDetail.enable_online_booking',
                            )
                        ));
        //if(empty($userDetails)){
        //    throw new NotFoundException('Page not found our server!');
            
        //}
	$this->set('salonId',$salonId);
        $salonOpeningHours =  $this->SalonOpeningHour->find('first' , array('conditions'=>array('user_id'=>$salonId,'status'=>1))); 
        $this->loadModel('BusinessType');
        $bType = $this->BusinessType->find('list', array('fields' => array('BusinessType.eng_name'), 'conditions' => array('BusinessType.status' => 1, 'BusinessType.is_deleted' => 0)));
        $this->set(compact('salonId','userDetails','salonOpeningHours','bType'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
           $this->layout = 'salon';
        }
    }

    function get_salon_details($salonId = null){
        $this->loadModel('User');
        
        $this->User->unbindModel(array('belongsTo'=>array('Group'),
				    'hasOne'=>array('UserDetail','FacilityDetail','PolicyDetail'),
				    'hasMany'=>array('PricingLevelAssigntoStaff'))
			      );
        $userDetails = array();
        $userDetails = $this->User->find('first',
                array(
                    'conditions'=>array('User.id'=>$salonId ,'User.status'=>1,'User.front_display'=>1),
                    
                    'fields'=>array(
                        'User.id', 'User.type',
                        'Salon.id','Salon.user_id', 'Salon.email',
                        'Salon.eng_name','Salon.ara_name',
                        'Salon.cover_image', 'Salon.website_url', 'Salon.business_url',
                        'Address.id', 'Address.user_id', 'Address.country_id', 'Address.state_id', 'Address.city_id',
                        'Contact.id', 'Contact.user_id', 'Contact.country_code', 'Contact.cell_phone','Contact.day_phone')
                ));
        return $userDetails;
    }
    
    function salon_isgiftcertificate($salonId = null){
        $this->loadModel('PolicyDetail');
        $policyDetails = array();
        $policyDetails =$this->PolicyDetail->find('first',array('fields'=>array('enable_gfvocuher'),'conditions'=>array('PolicyDetail.user_id'=>$salonId)));
        if(count($policyDetails)==0){
            $policyDetails =$this->PolicyDetail->find('first',array('fields'=>array('enable_gfvocuher'),'conditions'=>array('PolicyDetail.user_id'=>1)));
        }
        return $policyDetails;
    }
    
    
    public function get_staff_services($check_session){
	$staff_service_ids =array();
	$this->loadModel('SalonStaffService');
	$get_service_ids = $this->SalonStaffService->find('all',array(
	      'conditions'=>array('SalonStaffService.staff_id'=>$check_session , 'SalonStaffService.status'=>'1'),
	      'fields'=>'SalonStaffService.salon_service_id'
	  ));
	 // pr($get_service_ids);exit;
	if(!empty($get_service_ids)){
	    foreach($get_service_ids as $ids){
		$staff_service_ids[] = $ids['SalonStaffService']['salon_service_id'];
	    }
	}
	return $staff_service_ids;
    }
    
    /**********************************************************************************    
      @Function Name : salonservices
      @Params	 : NULL
      @Description   : The display salon all services via Ajax in frontend
      @Author        : Aman Gupta
      @Date          : 09-Apr-2014
    ***********************************************************************************/    
    public function salonservices($salonId = NULL,$emp_id = null){
        $services = array();
        $userDetails = array();
        $salonOpeningHours = array();
	$staff_service_ids = array();
	$check_session = '';
        $this->Session->delete('Deal'); 
        //$check_session = $this->Session->read('Stylist');
        if(!empty($emp_id)){
            $emp_id = base64_decode($emp_id);
            if(is_numeric($emp_id)){
                $check_session = $emp_id;
                $salon_id = base64_decode($salonId);
                if(is_numeric($salon_id)){
                    $salonId = $salon_id;
                }
                $this->Session->write('FRONT_SESSION.salon_stylist_id',$check_session);
            } else {
                $this->redirect('/Stylist');
            }
         }
        if(!empty($check_session)){
	    $this->loadModel('User');
	    $details = $this->User->findById($check_session);
	    if(!empty($details)){
		$name = $details['User']['first_name'].' '.$details['User']['last_name'];
	    }
	   $staff_service_ids =  $this->get_staff_services($check_session);
	}
        if($salonId){
            $services = $this->getserviceDisplay($salonId);
            if(!empty($staff_service_ids)){
                $j=0;
                foreach($services as $key=>$serviceChild){
                    $i=0;
		    if(isset($serviceChild['children']) && !empty($serviceChild['children'])){
			foreach($serviceChild['children']  as $key1=>$service){
                          if(!in_array($service['SalonService']['id'],$staff_service_ids)){
                            unset($services[$key]['children'][$key1]);
                          }
                          if(empty($serviceChild['children'])){
                            unset($services[$key]);
                          }
			$i++;     
		     }
		    }
                    
                $j++;
                }    
            }  
        }
	
	
        $this->set(compact('salonId','services','staff_service_ids','name'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            //$this->viewPath = "Elements/frontend/Place";
            /// $this->render('services');
        } else {
            $this->layout = 'salon';
        }
    }
    
/**********************************************************************************    
  @Function Name : salonservices
  @Params	 : NULL
  @Description   : The display salon all services via Ajax in frontend
  @Author        : Aman Gupta
  @Date          : 09-Apr-2014
***********************************************************************************/    
   
    public function salongiftcertificate($salonId = NULL , $redeem_gift = NULL){
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'default';
        }
	$user_count = $total_points = $amount= '';
	if($redeem_gift != ''){
	    $get_flag = base64_decode($redeem_gift);
	    if($get_flag == 'redeemed'){
                $userId  = $this->Auth->user('id');
                $amount_redeemed =  $this->Common->getPrice($userId,$salonId);
                $this->set(compact('amount_redeemed')); 
	    }
	 }
	   $this->set(compact('salonId'));
    }
  
/**********************************************************************************    
  @Function Name : salongallery
  @Params	 : NULL
  @Description   : The display salon gallery in frontend
  @Author        : Aman Gupta
  @Date          : 09-Apr-2014
***********************************************************************************/
    public function salongallery($salonId = NULL){
        $venuImages = array();
        $files = array();
        $videos = array();
        $venuVideos = array();
        
        if($salonId){
            $files = $videos = array();
            $this->loadModel('AlbumFile');
            $this->loadModel('Album');
            $this->loadModel('VenueImage');
            $this->loadModel('VenueVideo');
        
            $albums = $this->Album->find('list' , array('conditions'=>array('user_id'=>$salonId)));
            $this->AlbumFile->bindModel(array('belongsTo'=>array('Album'=>array(
                'fields'=>array('user_id')
            ))));
            if($albums){
                $files = $this->AlbumFile->find('all' ,
                        array(
                            'conditions'=>array('AlbumFile.album_id IN ('.implode(',',$albums).')','AlbumFile.type'=>'image'),
                            'order' => array('AlbumFile.id DESC')
                            )
                           
                        ); 
                $videos =$this->AlbumFile->find('all' ,
                        array('conditions'=>array('AlbumFile.album_id IN ('.implode(',',$albums).')','AlbumFile.type'=>'video'),
                        'order' => array('AlbumFile.id DESC')     
                        )
                    ); 
            }
            
            $venuImages =  $this->VenueImage->find('all' ,
                            array(
                                'conditions'=>array('user_id'=>$salonId),
                                'order' => array('VenueImage.id DESC')
                            )
                            );
            $venuVideos =  $this->VenueVideo->find('all' ,
                                array('conditions'=> array('user_id'=>$salonId),
                                'order' => array('VenueVideo.id DESC')    
                                )
                            );
           
            //$this->viewPath = "Elements/frontend/Place";
           // $this->render('gallery');
            
        }
            $this->set(compact('salonId','venuImages','files','videos','venuVideos'));
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
            } else {
                $this->layout = 'salon';
            }
    }

/**********************************************************************************    
  @Function Name : salonpackages
  @Params	 : NULL
  @Description   : The display salon all packages via Ajax in frontend
  @Author        : Aman Gupta
  @Date          : 09-Apr-2014
***********************************************************************************/    
    public function salonpackages($salonId = NULL, $empID = NULL){
        if($salonId){
            //$services = $this->Common->getSalonServiceList($salonId,'full');
            //$packages = $this->getpackageDisplay($salonId,'Package');
            $check_session = '';
	    $staff_service_ids = array();
	    $this->loadModel('Package');
            //$this->Session->delete('Deal');
	      if(!empty($empID)){
		$empID = base64_decode($empID);
		if(is_numeric($empID)){
		    $check_session = $empID;
		    $salon_id = base64_decode($salonId);
		    if(is_numeric($salon_id)){
			$salonId = $salon_id;
		    }
		    $this->Session->write('FRONT_SESSION.salon_stylist_id',$check_session);
		} else {
		    $this->redirect('/Stylist');
		}
	     }
            $this->paginate=array(
                'limit'=> 6,
                'order' => 'Package.created DESC',
		'group' => 'Package.id',
		'fields' => array('Package.id','Package.eng_name','Package.ara_name','Package.image','SalonServiceDetail.sold_as',),
		'joins' => array(
			array(
			    'alias' => 'PackageService',
			    'table' => 'package_services',
			    'type' => 'INNER',
			    'conditions' => '`PackageService`.`package_id` = `Package`.`id`'
			)
		    ),
            );
	   
	    $name = '';
	    if(!empty($check_session)){
		$this->loadModel('User');
		$details = $this->User->findById($check_session);
		if(!empty($details)){
		    $name = $details['User']['first_name'].' '.$details['User']['last_name'];
		}
		 $staff_service_ids =  $this->get_staff_services($check_session);
	    }
            $fullcriteria =  array(
                                'Package.is_deleted' => 0,
                                'Package.status' => 1,
                                'Package.user_id' => $salonId,
                                'Package.type'=> 'Package',
				 'OR'=>array(
                                        'SalonServiceDetail.listed_online' => 0,
                                        array('SalonServiceDetail.listed_online' => 1,'SalonServiceDetail.listed_online_start <= DATE(NOW())'),
                                        array('SalonServiceDetail.listed_online' => 2,'SalonServiceDetail.listed_online_end >= DATE(NOW())'),
                                        array('SalonServiceDetail.listed_online' => 3,
                                            'AND'=>array(
                                                    'SalonServiceDetail.listed_online_start <= DATE(NOW())',
                                                    'SalonServiceDetail.listed_online_end >= DATE(NOW())'
                                                )
                                            )
                                        )
                        );
	    
	    if(!empty($staff_service_ids)){
		$fullcriteria['PackageService.salon_service_id'] = $staff_service_ids;
	    }
            
            $packages = $this->paginate('Package', $fullcriteria);
	    
            $this->set(compact('packages','salonId','staff_service_ids','name'));
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
            } else {
                $this->layout = 'salon';
            }
            //$this->viewPath = "Elements/frontend/Place";
           // $this->render('packages');
            
            
        }
    }

/**********************************************************************************    
  @Function Name : salonspaday
  @Params	 : NULL
  @Description   : The display salon all spaday via Ajax in frontend
  @Author        : Aman Gupta
  @Date          : 09-Apr-2014
***********************************************************************************/      
    public function salonspaday($salonId = NULL,  $empID = NULL){
        $theType = 'spaday';
        $packages = array();
	$check_session = '';
	$staff_service_ids = array();
        if($salonId){
            $this->loadModel('Package');
            $this->paginate=array(
                'limit'=> 6,
                'order' => 'Package.created DESC',
		'group' => 'Package.id',
		'joins' => array(
			array(
			    'alias' => 'PackageService',
			    'table' => 'package_services',
			    'type' => 'INNER',
			    'conditions' => '`PackageService`.`package_id` = `Package`.`id`'
			)
		    ),
            );
             if(!empty($empID)){
		$empID = base64_decode($empID);
		if(is_numeric($empID)){
		    $check_session = $empID;
		    $salon_id = base64_decode($salonId);
		    if(is_numeric($salon_id)){
			$salonId = $salon_id;
		    }
		    $this->Session->write('FRONT_SESSION.salon_stylist_id',$check_session);
		} else {
		    $this->redirect('/Stylist');
		}
	     }
	     
	    $name = '';
	    if(!empty($check_session)){
		$this->loadModel('User');
		$details = $this->User->findById($check_session);
		if(!empty($details)){
		    $name = $details['User']['first_name'].' '.$details['User']['last_name'];
		}
		$staff_service_ids =  $this->get_staff_services($check_session);
	    }
            $fullcriteria =  array(
                                'Package.is_deleted' => 0,
                                'Package.status' => 1,
                                'Package.user_id' => $salonId,
                                'Package.type'=> 'Spaday',
                                'OR'=>array(
                                        'SalonServiceDetail.listed_online' => 0,
                                        array('SalonServiceDetail.listed_online' => 1,'SalonServiceDetail.listed_online_start <= DATE(NOW())'),
                                        array('SalonServiceDetail.listed_online' => 2,'SalonServiceDetail.listed_online_end >= DATE(NOW())'),
                                        array('SalonServiceDetail.listed_online' => 3,
                                            'AND'=>array(
                                                    'SalonServiceDetail.listed_online_start <= DATE(NOW())',
                                                    'SalonServiceDetail.listed_online_end >= DATE(NOW())'
                                                )
                                            )
                                        )
                        );
	    if(!empty($staff_service_ids)){
		$fullcriteria['PackageService.salon_service_id'] = $staff_service_ids;
	    }
            $packages = $this->paginate('Package', $fullcriteria);
         
            
        }
            $this->set(compact('packages','salonId','theType','staff_service_ids','name'));
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
            } else {
                $this->layout = 'salon';
            }
           // $this->viewPath = "Elements/frontend/Place";
            //$this->render('packages');
            
           
            
        
    }
    
    /***************************************************************************************    
    @Function Name : spabreaks
    @Params	 : $salonId
    @Description   : The display all spa breaks via Ajax in frontend
    @Author        : Sonam Mittal
    @Date          : 26-May-2015
    ******************************************************************************************/
    
    public function spabreaks($salonId = NULL){
        $breaks = array();
        if($salonId){
            $this->loadModel('Spabreak');
            $this->Spabreak->unbindModel(array('hasMany'=>'SpabreakOption'));
            $this->paginate=array(
                'limit'=> 2,
                'fields'=>array(
                    'Spabreak.id','Spabreak.ara_name','Spabreak.eng_name','SalonServiceDetail.sold_as',
                )                
            );
            $fullcriteria =  array(
                'Spabreak.is_deleted' => 0,
                'Spabreak.status' => 1,
                'Spabreak.user_id' => $salonId,
                'OR'=>array(
                    'Spabreak.listed_online' => 0,
                    array('Spabreak.listed_online' => 1,'Spabreak.listed_online_start <= DATE(NOW())'),
                    array('Spabreak.listed_online' => 2,'Spabreak.listed_online_end >= DATE(NOW())'),
                    array('Spabreak.listed_online' => 3,
                        'OR'=>array(
                                'Spabreak.listed_online_start >= DATE(NOW())',
                                'Spabreak.listed_online_end >= DATE(NOW())'
                            )
                        )
                )
            );
            $breaks = $this->paginate('Spabreak', $fullcriteria);
        }
        $this->set(compact('breaks','salonId'));
        
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'salon'; 
        }     
    }
    
    
/**********************************************************************************    
  @Function Name : packages
  @Params	 : NULL
  @Description   : The display salon all packages via Ajax in frontend
  @Author        : Aman Gupta
  @Date          : 09-Apr-2014
***********************************************************************************/      
  
    public function salondeals($salonId = NULL, $empID = NULL){
        $deals = array();
        $defaultLayout = false;
        $pkgDeals = array();
	$check_session = '';
	$staff_service_ids = array();
        $srvcDeals = array();
        $this->loadModel('Deal');
        $this->loadModel('Service');
        $this->Deal->recursive = 2;
	 if(!empty($empID)){
		$empID = base64_decode($empID);
		if(is_numeric($empID)){
		    $check_session = $empID;
		    $salon_id = base64_decode($salonId);
		    if(is_numeric($salon_id)){
			$salonId = $salon_id;
		    }
		    $this->Session->write('FRONT_SESSION.salon_stylist_id',$check_session);
		} else {
		    $this->redirect('/Stylist');
		}
	     }
	    
	    $name = '';
	    if(!empty($check_session)){
		$this->loadModel('User');
		$details = $this->User->findById($check_session);
		if(!empty($details)){
		    $name = $details['User']['first_name'].' '.$details['User']['last_name'];
		}
		 $staff_service_ids =  $this->get_staff_services($check_session);
	    }
        if($salonId){
            $deals = array();
            $criteria ="Deal.salon_id = $salonId AND Deal.is_deleted = 0 AND Deal.status = 1 AND Deal.listed_online_start <= DATE(NOW()) AND Deal.max_time >= DATE(NOW()) AND (Deal.quantity_type=0 OR (Deal.quantity_type=1 AND Deal.quantity > Deal.purchased_quantity)) AND User.front_display=1";
            $order = 'Deal.created DESC';    
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
		    'type'=>'INNER',
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
	     if(!empty($staff_service_ids)){
		$criteria .="AND DealServicePackage.salon_Service_id IN (". implode(',',$staff_service_ids).")";
	    }
		     // pr($criteria);
            $this->Paginator->settings =  array(
                'conditions'=>$criteria,
                'limit'=>6,
                'fields'=>$fields,
                'order' =>$order,
                'joins'=>$joins,
                'group'=>'Deal.id'
            );
            $allDeals = $this->Paginator->paginate('Deal');
            $this->set(compact('allDeals','salonId','staff_service_ids','name'));
         }
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        } else {
            $this->layout = 'salon';
        }
    }
    /**********************************************************************************    
      @Function Name : getserviceDisplay
      @Params	 : $salonId
      @Description   : The fetching list of services
      @Author        : Aman Gupta
      @Date          : 09-Apr-2014
    ***********************************************************************************/
  
    public function getserviceDisplay($salonId = NULL){
        $this->loadModel('SalonService');
        $this->SalonService->bindModel(array('belongsTo'=>array('Service')));
	$serviceList = $this->SalonService->find('list', array('conditions' => array('SalonService.is_deleted' => 0, 'SalonService.salon_id' => $salonId)));
        //$ids  = $this->Common->find_deal_services($serviceList,'Service');
	
	//pr($ids); die;
       //die;
        $this->SalonService->unbindModel(array('hasMany'=>array('ServicePricingOption','SalonStaffService','SalonServiceResource','PackageService')));
	$salonService = $this->SalonService->find('all', array('fields'=>array('SalonService.id','SalonService.eng_name','SalonService.ara_name','Service.eng_name','Service.ara_name','SalonServiceDetail.listed_online','SalonServiceDetail.sold_as','SalonServiceDetail.listed_online_start','SalonServiceDetail.listed_online_end'),'conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1, 'SalonService.salon_id' => $salonId,'SalonService.parent_id'=>0), 'order' => array('SalonService.service_order')));
      
	foreach($salonService as $salserkey=>$theService){
	     $this->SalonService->unbindModel(array('hasMany'=>array('ServicePricingOption','SalonStaffService','SalonServiceResource','PackageService'),'hasOne'=>array('Service')));
           $subService = $this->SalonService->find('all', array('fields'=>array('SalonService.id','SalonService.eng_name','SalonService.ara_name','SalonServiceDetail.listed_online','SalonServiceDetail.listed_online_start','SalonServiceDetail.sold_as','SalonServiceDetail.listed_online_end'),'conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1, 'SalonService.salon_id' => $salonId,'SalonService.parent_id'=>$theService['SalonService']['id'],'OR'=>array(
                                        'SalonServiceDetail.listed_online' => 0,
                                        array('SalonServiceDetail.listed_online' => 1,'SalonServiceDetail.listed_online_start <= DATE(NOW())'),
                                        array('SalonServiceDetail.listed_online' => 2,'SalonServiceDetail.listed_online_end >= DATE(NOW())'),
                                        array('SalonServiceDetail.listed_online' => 3,
                                            'AND'=>array(
                                                    'SalonServiceDetail.listed_online_start <= DATE(NOW())',
                                                    'SalonServiceDetail.listed_online_end >= DATE(NOW())'
                                                )
                                            )
                                        )), 'order' => array('SalonService.service_order')));
          
           if(empty($subService)){
               unset($salonService[$salserkey]);
           }else{
               $salonService[$salserkey]['children'] = $subService;
           }
       }
        return $salonService;
    }
    
    /**********************************************************************************    
    @Function Name : showSpaBreak
    @Params	 : $spabreakId
    @Description   : for displaying booking on the spa break page.
    @Author        : Sonam Mittal
    @Date          : 29-May-2015
    ******************************************************************************************/
    public function showSpaBreak($spabreakId = NULL , $apntmntORevchrID = NULL) {
        $salonId = '';
        $pricingoption = ''; 
        $spaBreakOption = array();
        $this->loadModel('Spabreak');
        $this->loadModel('SpabreakOption');
        $this->loadModel('SpabreakOptionPerday');
        $this->loadModel('PolicyDetail');
        $this->loadModel('SalonOnlineBookingRule');
        
        if(!empty($spabreakId)){
            $break_details = explode('-',$spabreakId);
            $cnt_ser_details = count($break_details);
            $encoded_service_id = $break_details[$cnt_ser_details-1];
            $service_id = base64_decode($encoded_service_id);
            if(is_numeric($service_id)){
                $spabreakId = $service_id;
            }
        }
        
        /*---------------------------------- reschedule start here -------------------------*/
        $reschedule = '';
        if(!empty($apntmntORevchrID)){
            $apntmntORevchrID = base64_decode($apntmntORevchrID);
            if($this->Session->read('APPOINTMENT.RESCHEDULE')){
                $appointmentID = $apntmntORevchrID;
                if($this->Session->read('APPOINTMENT.RESCHEDULE')==true){
                    $this->loadModel("Order");
                    $order = $this->Order->find("first",array(
                        'fields'=>array("Order.price_option_id","Order.salon_service_id","Order.salon_id"),
                        "conditions"=>array("Order.id"=>$appointmentID)
                    ));
                    if($order){
                        $pricingoption = $order['Order']['price_option_id'];
                        if(!empty($pricingoption)){
                            $spaBreakOption = $this->SpabreakOption->find('all',array(
                                'fields'=>array(
                                    'SpabreakOption.salon_room_id',
                                    'SpabreakOption.max_booking_perday',
                                    'SalonRoom.id',
                                    'SalonRoom.eng_room_type',
                                    'SalonRoom.ara_room_type',
                                    'SalonRoom.ara_description',
                                    'SalonRoom.eng_description'
                                ),
                                'conditions'=>array(
                                    'SpabreakOption.spabreak_id'=>$order['Order']['salon_service_id'],
                                    'SpabreakOption.is_deleted <>'=>1
                                )
                            ));
                            //pr($spaBreakOption);
                        }
                        $this->set(compact("appointmentID","pricingoption","order","spaBreakOption"));
                    }
                    $reschedule = 'true';
                    $this->set(compact("appointmentID"));                   
                }
            }
            else if($this->Session->read('EVOUCHER.BOOKAPPOINTMENT')){
                 $this->loadModel("Evoucher");
                 $this->loadModel("Order");
                 $evoucherID = $apntmntORevchrID;
                 $this->Order->unbindModel(array('belongsTo'=>array("Appointment","SalonService")));
                 $this->Evoucher->recursive = 2;
                 $eVoucherDetail = $this->Evoucher->find('first',array('contain'=>array('Order'=>array('OrderDetail'=>array('fields'=>array('OrderDetail.id','service_id','option_duration','option_price','eng_service_name','ara_service_name','price_option_id','service_id','duration')))),'fields'=>array('Evoucher.id','Order.id','Evoucher.used','Order.salon_service_id','Order.price_option_id','Order.eng_service_name','Order.ara_service_name','Evoucher.price','Evoucher.salon_id'),'conditions'=>array('Evoucher.id'=>$evoucherID)));
                 if($eVoucherDetail){
                    $this->set(compact("eVoucherDetail"));
                    $eVoucher = 'true';
                 }
                 //pr($eVoucherDetail);
                 //exit;
                
            }
        }
        
        /*---------------------------------- reschedule end here -------------------------*/
        
        
        if($spabreakId){
            $policyDetails = $leadTime = array();            
            $spaBreakDetails = $this->Spabreak->findById($spabreakId);
            if(!empty($spaBreakDetails)){
                $userID = $spaBreakDetails['Spabreak']['user_id'];
                $salonId = @$userID;
                if($userID){
                    $policyDetails = $this->PolicyDetail->find('first',array(
                        'fields'=>array('PolicyDetail.eng_cancellation_policy_text','PolicyDetail.ara_cancellation_policy_text','PolicyDetail.eng_reschedule_policy_text','PolicyDetail.eng_reschedule_policy_text'),
                        'conditions'=>array(
                            'PolicyDetail.user_id'=> $userID
                        )
                    ));
                    if(empty($policyDetails)){
                        $policyDetails = $this->PolicyDetail->find('first',array(
                            'fields'=>array('PolicyDetail.eng_cancellation_policy_text','PolicyDetail.ara_cancellation_policy_text','PolicyDetail.eng_reschedule_policy_text','PolicyDetail.eng_reschedule_policy_text'),
                            'conditions'=>array(
                                'PolicyDetail.user_id'=> 1
                            )
                        ));
                    }
                    $leadTime = $this->SalonOnlineBookingRule->find('first',array(
                        'fields'=>array('SalonOnlineBookingRule.lead_time'),
                        'conditions'=>array(
                            'SalonOnlineBookingRule.user_id'=> $userID
                        )
                    ));
                }
            }
            if($reschedule!= 'true'){
                $spaBreakOption = $this->SpabreakOption->find('all',array(
                    'fields'=>array(
                        'SpabreakOption.salon_room_id',
                        'SpabreakOption.max_booking_perday',
                        'SalonRoom.id',
                        'SalonRoom.eng_room_type',
                        'SalonRoom.ara_room_type',
                        'SalonRoom.ara_description',
                        'SalonRoom.eng_description'
                    ),
                    'conditions'=>array(
                        'SpabreakOption.spabreak_id'=>$spabreakId,
                        'SpabreakOption.is_deleted <>'=>1
                    )
                ));
            }
            $this->set(compact('salonId','reschedule','pricingoption','spaBreakDetails','spaBreakOption','policyDetails','leadTime'));
        }
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = 'Elements/frontend/Place';
            $this->render('booking_spabreak');
        }else{
            $this->layout = 'salon';
            $this->viewPath = 'Spabreaks';
            $this->render('show_spa_breaks');
        } 
    }
    
    
    function ajax_services($serviceId = null){
	    $this->layout = 'ajax';
            $this->viewPath = 'Elements/frontend/Place';
	    $this->loadModel('SalonService');
	    $check_session = $this->Session->read('FRONT_SESSION.salon_stylist_id');
	    if(!empty($check_session)){
		$this->loadModel('User');
		$details = $this->User->findById($check_session);
		if(!empty($details)){
		    $name = $details['User']['first_name'].' '.$details['User']['last_name'];
		}
	       $staff_service_ids =  $this->get_staff_services($check_session);
	    }
      
           $this->SalonService->unbindModel(array('hasMany'=>array('ServicePricingOption','SalonStaffService','SalonServiceResource','PackageService'),'hasOne'=>array('Service')));
	    $subService = $this->SalonService->find('all', array('fields'=>array('SalonService.id','SalonService.eng_name','SalonService.ara_name','SalonServiceDetail.listed_online','SalonServiceDetail.listed_online_start','SalonServiceDetail.sold_as','SalonServiceDetail.listed_online_end'),'conditions' => array('SalonService.is_deleted' => 0,'SalonService.status' => 1,'SalonService.parent_id'=>$serviceId,'OR'=>array(
                                        'SalonServiceDetail.listed_online' => 0,
                                        array('SalonServiceDetail.listed_online' => 1,'SalonServiceDetail.listed_online_start <= DATE(NOW())'),
                                        array('SalonServiceDetail.listed_online' => 2,'SalonServiceDetail.listed_online_end >= DATE(NOW())'),
                                        array('SalonServiceDetail.listed_online' => 3,
                                            'AND'=>array(
                                                    'SalonServiceDetail.listed_online_start <= DATE(NOW())',
                                                    'SalonServiceDetail.listed_online_end >= DATE(NOW())'
                                                )
                                            )
                                        )), 'order' => array('SalonService.service_order')));
       if(!empty($staff_service_ids)){
               
                    $i=0;
                    foreach($subService  as $key1=>$service){
                          if(!in_array($service['SalonService']['id'],$staff_service_ids)){
                            unset($subService[$key1]);
                          }
                    $i++;     
                    }
                 
            }  
        
	    $this->set(compact('subService'));
	     
            $this->render('ajax_services_main_page');
    }
    
    /**********************************************************************************    
    @Function Name : spaBreakDates
    @Params	 : $spaBreakId , $roomId
    @Description   : This function is for returning spa break price options
    @Author        : Sonam Mittal
    @Date          : 04-June-2015
  ***********************************************************************************/
    public function spaBreakDates($spaBreakId = NULL,$roomId = NULL,$pricingId=NULL){
        $this->autoRender = false;
        $breakPrice = array();
        $this->loadModel('SpabreakOption');
        $spaBreakOptions = $this->SpabreakOption->find('all',array(
            'fields'=>array('SpabreakOption.*'),
            'conditions'=>array(
                'SpabreakOption.spabreak_id'=> $spaBreakId,
                'SpabreakOption.salon_room_id'=> $roomId
            )
        ));
        if(!empty($spaBreakOptions)){
            foreach($spaBreakOptions as $spaBreakOption){
                if(!empty($spaBreakOption['SpabreakOptionPerday'])){
                    foreach($spaBreakOption['SpabreakOptionPerday'] as $options){
                        if(!empty($pricingId)){
                            if($options['id']==$pricingId){
                                    if($options['sunday']==1){
                                    if(!empty($options['sell_price'])){
                                        $breakPrice['sunday'] = $options['sell_price'];
                                    }else{
                                        $breakPrice['sunday'] = $options['full_price'];
                                    }
                                }
                                if($options['monday']==1){
                                    if(!empty($options['sell_price'])){
                                        $breakPrice['monday'] = $options['sell_price'];
                                    }else{
                                        $breakPrice['monday'] = $options['full_price'];
                                    }
                                }
                                if($options['tuesday']==1){
                                    if(!empty($options['sell_price'])){
                                        $breakPrice['tuesday'] = $options['sell_price'];
                                    }else{
                                        $breakPrice['tuesday'] = $options['full_price'];
                                    }
                                }
                                if($options['wednesday']==1){
                                    if(!empty($options['sell_price'])){
                                        $breakPrice['wednesday'] = $options['sell_price'];
                                    }else{
                                        $breakPrice['wednesday'] = $options['full_price'];
                                    }
                                }
                                if($options['thursday']==1){
                                    if(!empty($options['sell_price'])){
                                        $breakPrice['thursday'] = $options['sell_price'];
                                    }else{
                                        $breakPrice['thursday'] = $options['full_price'];
                                    }
                                }
                                if($options['friday']==1){
                                    if(!empty($options['sell_price'])){
                                        $breakPrice['friday'] = $options['sell_price'];
                                    }else{
                                        $breakPrice['friday'] = $options['full_price'];
                                    }
                                }
                                if($options['saturday']==1){
                                    if(!empty($options['sell_price'])){
                                        $breakPrice['saturday'] = $options['sell_price'];
                                    }else{
                                        $breakPrice['saturday'] = $options['full_price'];
                                    }
                                }
                                break;
                            }
                        }else{
                            if($options['sunday']==1){
                                if(!empty($options['sell_price'])){
                                    $breakPrice['sunday'] = $options['sell_price'];
                                }else{
                                    $breakPrice['sunday'] = $options['full_price'];
                                }
                            }
                            if($options['monday']==1){
                                if(!empty($options['sell_price'])){
                                    $breakPrice['monday'] = $options['sell_price'];
                                }else{
                                    $breakPrice['monday'] = $options['full_price'];
                                }
                            }
                            if($options['tuesday']==1){
                                if(!empty($options['sell_price'])){
                                    $breakPrice['tuesday'] = $options['sell_price'];
                                }else{
                                    $breakPrice['tuesday'] = $options['full_price'];
                                }
                            }
                            if($options['wednesday']==1){
                                if(!empty($options['sell_price'])){
                                    $breakPrice['wednesday'] = $options['sell_price'];
                                }else{
                                    $breakPrice['wednesday'] = $options['full_price'];
                                }
                            }
                            if($options['thursday']==1){
                                if(!empty($options['sell_price'])){
                                    $breakPrice['thursday'] = $options['sell_price'];
                                }else{
                                    $breakPrice['thursday'] = $options['full_price'];
                                }
                            }
                            if($options['friday']==1){
                                if(!empty($options['sell_price'])){
                                    $breakPrice['friday'] = $options['sell_price'];
                                }else{
                                    $breakPrice['friday'] = $options['full_price'];
                                }
                            }
                            if($options['saturday']==1){
                                if(!empty($options['sell_price'])){
                                    $breakPrice['saturday'] = $options['sell_price'];
                                }else{
                                    $breakPrice['saturday'] = $options['full_price'];
                                }
                            }
                        }
                    }
                }
                
            }
            if(!isset($breakPrice['sunday'])){
                $breakPrice['sunday'] = 0;
            }
            if(!isset($breakPrice['monday'])){
                $breakPrice['monday'] = 0;
            }
            if(!isset($breakPrice['tuesday'])){
                $breakPrice['tuesday'] = 0;
            }
            if(!isset($breakPrice['wednesday'])){
                $breakPrice['wednesday'] = 0;
            }
            if(!isset($breakPrice['thursday'])){
                $breakPrice['thursday'] = 0;
            }
            if(!isset($breakPrice['friday'])){
                $breakPrice['friday'] = 0;
            }
            if(!isset($breakPrice['saturday'])){
                $breakPrice['saturday'] = 0;
            }
            echo json_encode($breakPrice);
        }
        
    }
    
    public function book_stylist(){
	if(!empty($this->request->data['id'])){
	    $id = $this->request->data['id'];
	    $userid = $this->request->data['userid'];
	    $this->Session->write('Stylist', $userid);
	    $this->Session->write('Salon', $id);
	    echo '1';
	    exit;
	}
    }
    
    /**********************************************************************************    
  @Function Name : bookmark
  @Params	 : NULL
  @Description   : Bookmark salon via Ajax in frontend
  @Author        : Niharika Sachdeva
  @Date          : 16-July-2015
***********************************************************************************/
    public function bookmark(){
	$this->loadModel('Bookmark');
	$user = $this->Auth->user('id');
	if(empty($user)){
	    echo 'unauth';
	}else{
	    $salonId = $this->request->data['salonId'];
	    $saveArray = array();
	    $getData = $this->Bookmark->find('all' , array('conditions'=> array('Bookmark.user_id'=>$user , 'Bookmark.salon_id'=>$salonId),'fields'=>'id'));
	    if(empty($getData)){
		$saveArray['salon_id'] = $salonId;
		$saveArray['user_id'] = $user;
		$saveArray['created'] = date('Y-m-d h:i:s');
		if($this->Bookmark->save($saveArray)){
		    echo '1';
		}else{
		    echo '0';
		}
	    }else{
		echo '2';
	    }
	}
	exit;
    }
    
}