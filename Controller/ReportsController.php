<?php
App::import("Vendor", "/smsCountry/Client");
class ReportsController extends AppController {
    
    public $helpers = array('Session', 'Html','PhpExcel.PhpExcel','Form','js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Paginator','Image','RequestHandler'); //An array containing the names of components this controller uses.
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('contacts','test','admin_customerReport');
    }
    function admin_customer_reports(){
      $this->layout='admin';
      $this->set('activeTMenu','reports');
      $this->set('page_title' ,'Customer Reports');
    }
   
    public function contacts(){
             $this->requestAction('/invites/AppInvites/index');
             die;
             $client_id = '1051239664563-j7eoc3drgbdh0jd5qeif47h0am89gdnv.apps.googleusercontent.com';
             $client_secret = '2aW1v_gkL2eLipBBrCe5xnjw';
             $redirect_uri = 'http://172.24.2.222:8079/reports/contacts';
             $max_results = 25;
             $auth_code = $_GET["code"];
        
             $fields=array(
                'code'=>  urlencode($auth_code),
                'client_id'=>  urlencode($client_id),
                'client_secret'=>  urlencode($client_secret),
                'redirect_uri'=>  urlencode($redirect_uri),
                'grant_type'=>  urlencode('authorization_code')
             );
            $post = '';
            foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
            $post = rtrim($post,'&');
            
            $curl = curl_init();
            curl_setopt($curl,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');
            curl_setopt($curl,CURLOPT_POST,5);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
            $result = curl_exec($curl);
            curl_close($curl);
            $response =  json_decode($result);
            $accesstoken = $response->access_token;
            $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&oauth_token='.$accesstoken;
            $xmlresponse =  $this->curl_file_get_contents($url);
            if((strlen(stristr($xmlresponse,'Authorization required'))>0) && (strlen(stristr($xmlresponse,'Error '))>0))
            {
                    echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
                    exit();
            }
            echo "<h3>Email Addresses:</h3>";
            $xml =  new SimpleXMLElement($xmlresponse);
            $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
            $result = $xml->xpath('//gd:email');
            
            foreach ($result as $title) {
              echo $title->attributes()->address . "<br>";
        }
      
      
      
      $this->layout = false;
      $this->autoRender = false;
    } 
   
    function curl_file_get_contents($url)
    {
     $curl = curl_init();
     $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
     
     curl_setopt($curl,CURLOPT_URL,$url);	//The URL to fetch. This can also be set when initializing a session with curl_init().
     curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);	//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
     curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);	//The number of seconds to wait while trying to connect.	
     curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);	//The contents of the "User-Agent: " header to be used in a HTTP request.
     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);	//To follow any "Location: " header that the server sends as part of the HTTP header.
     curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);	//To automatically set the Referer: field in requests where it follows a Location: redirect.
     curl_setopt($curl, CURLOPT_TIMEOUT, 10);	//The maximum number of seconds to allow cURL functions to execute.
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);	//To stop cURL from verifying the peer's certificate.
     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
     
     $contents = curl_exec($curl);
     curl_close($curl);
     return $contents;
    }
   
    public function test(){
//       $username = '';
//       $password='';
//       $senderId='';
//       $soapService='';
//       $smsClient = new Client($username, $password, $senderId, $soapService);
//       $smsClient->sendSms($phoneNumber, $body);   
        $user="sieasta"; //your username
        $password="ham@123"; //your password
        $mobilenumbers="918054323079"; //enter Mobile numbers comma seperated
        $message = "test messgae TO CHECK"; //enter Your Message
        $senderid="SMSCountry"; //Your senderid
        $messagetype="N"; //Type Of Your Message
        $DReports="Y"; //Delivery Reports
        $url="http://www.smscountry.com/SMSCwebservice_Bulk.aspx";
        $message = urlencode($message);
        $ch = curl_init();
        if (!$ch){die("Couldn't initialize a cURL handle");}
        $ret = curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt ($ch, CURLOPT_POSTFIELDS,
        "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
        $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
        // $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
        $curlresponse = curl_exec($ch); // execute
        pr($curlresponse); die;
        if(curl_errno($ch))
        echo 'curl error : '. curl_error($ch);
        if (empty($ret)){
        // some kind of an error happened
        die(curl_error($ch));
        curl_close($ch); // close cURL handler
        } else {
            $info = curl_getinfo($ch);
            curl_close($ch); // close cURL handler
            echo $curlresponse; //echo "Message Sent Succesfully";
        }
        die;
    }
    
    public function admin_customerReport(){
        $this->layout   =   'admin';
        $this->loadModel('User');
        $this->loadModel('Contact');
        $this->loadModel('Address');
        $this->loadModel('UserPoint');
        $this->loadModel('Order');
        $conditions='';
       // $conditions = array('ProductType.is_deleted'=>"0");
	if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	    
	}
	if(!empty($src_keywrd)){
	   $conditions = array('Order.eng_service_name LIKE "%'.$src_keywrd.'%"',
                               'Order.ara_service_name LIKE "%'.$src_keywrd.'%"'
                         );
	}
	if(isset($this->request->data['reports']) && !empty($this->request->data['reports'])){
            pr($this->request->data);die;
	}
	/************** Set page limit ************/
	$number_records = 100;
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
        $this->User->bindModel(array('hasMany'=>array('UserPoint','Order')));
        $this->User->unbindModel(array('hasMany'=>array('PricingLevelAssigntoStaff')));
        $this->layout   =   'admin_paginator';
        $fields = array('User.id',
			'User.first_name',
			'User.last_name',
			'User.email',
                        'User.last_visited',
                        'User.created',
                        'UserDetail.refered_by',
                        'UserDetail.tags',
                        'Contact.cell_phone',
			'Contact.day_phone',
			'Address.address',
                        'SELECT count(o.id) as booking_count  FROM orders as o INNER JOIN users as u ON o.user_id = u.id'
                        //'UserPoint.point_given',
                        //'UserPoint.points_deducted'
		);
	$this->Paginator->settings = array(
		'User' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('Order.id DESC')
		)
	    );
	$breadcrumb = array(
		'Home'=>array('controller'=>'reports','action'=>'customerReport','admin'=>true),
		'Reports'=>'javascript:void(0);'
	    );
        $activeTMenu = 'Report';
        $page_title = 'Reports';
        $this->set(compact('activeTMenu','page_title','breadcrumb','searchFor','staffs','customers','allOrders'));
        
        $allCustomers = $this->Paginator->paginate('User');
        
        
        pr($allCustomers);die;
        $bdayMonths=array(1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'June',7=>'July',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
        //pr($allOrders);die;
        $this->set(compact('allCustomers'));
        $this->set('activeTMenu',$activeTMenu);
        $this->set('page_title',$page_title);
        $this->set('bdayMonths',$bdayMonths);
        //$this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Reports";
            $this->render('search_list');
        }
    }
    
    public function admin_order_details($orderID = null){
         $this->layout   =   'admin';
         $this->loadModel('Order');
         $this->Order->unbindModel(array('belongsTo'=>array('SalonService')));
         if($this->request->is('ajax') && !empty($orderID)){
             $fields = array('Order.id',
			'Order.transaction_id',
                        'Order.display_order_id',
			'Order.service_type',
			'Order.start_date',
                        'Order.orignal_amount',
                        'Order.start_date',
                        'Order.tax_amount',
                        'Order.sieasta_commision',
			'Order.sieasta_commision_amount',
			'Order.service_price_with_tax',
                        'Order.total_deductions',
                        'Order.vendor_dues',
                        'Order.created',
                        'Order.employee_id',
                        'Order.eng_service_name',
                        'User.first_name',
                        'User.last_name',
                );
            $this->Order->bindModel(array('belongsTo'=>array('User'),'hasMany'=>array('Evoucher','Appointment','OrderDetail'=>array('fields'=>array('OrderDetail.eng_service_name','OrderDetail.employee_id','OrderDetail.start_date','OrderDetail.time')))));
            $Order=$this->Order->find('first',array('conditions'=>array('Order.display_order_id'=>$orderID))); 
            //pr($Order);
            //exit;
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Reports";
            $this->set(compact('Order'));
            $this->render('admin_order_details');
        }else{
            
        }
    }
    
    public function admin_transactionReport(){
        $this->layout   =   'admin';
        $this->loadModel('Order');
        $conditions='';
        /***Check for salon owner****/
        $sessionData=$this->Session->read('Auth.User');
        $salonId='';
        if($sessionData['type'] == 4){
            $salonId=$sessionData['id'];
        } else if($sessionData['type'] == 4 || $sessionData['type'] == 5){
            $salonId = $sessionData['parent_id'];
        }
        if(!empty($salonId) && $salonId>0){
             $conditions[]="Order.salon_id ='".$salonId."'";  
        }
        $allOrders=$this->Order->find('all',array('order'=>array('Order.created DESC')));
        if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	}
        if(!empty($this->params->query['startDate']) && !empty($this->params->query['endDate'])){
            $this->request->data['startDate']=$this->params->query['startDate'];
            $this->request->data['endDate']=$this->params->query['endDate'];
        }
        if(!empty($this->params->query['serviceType'])){
            $this->request->data['serviceType']=$serviceType;
        }
        if((isset($this->request->data) && !empty($this->request->data)) || (isset($this->request->named) && !empty($this->request->named))){
            if(!empty($this->request->data['startDate'])){
               // $start_date = $this->request->data['startDate'];
                $new_start_date = date("Y-m-d",  strtotime($this->request->data['startDate']));
            }elseif(!empty($this->request->named['startDate'])){
                $new_start_date = date("Y-m-d",  strtotime($this->request->named['startDate']));
            }
            if(!empty($this->request->data['endDate'])){
                //$end_date = $this->request->data['endDate'];
                 $new_end_date = date("Y-m-d",  strtotime($this->request->data['endDate']));
            }elseif(!empty($this->request->named['endDate'])){
                 $new_end_date = date("Y-m-d",  strtotime($this->request->named['endDate']));
            }
            if(isset($new_start_date) && !empty($new_start_date) && isset($new_end_date) && !empty($new_end_date)){
                //$conditions[]="DATE_FORMAT(Order.created,'%y-%m-%d') between '".$new_start_date."' and '".$new_end_date."'";
                $conditions[]="DATE_FORMAT(Order.created,'%Y-%m-%d') >= '".$new_start_date."' AND DATE_FORMAT(Order.created,'%Y-%m-%d') <= '".$new_end_date."'";
            }elseif(!empty($this->request->named['startDate']) && !empty($this->request->named['endDate'])){
               // $conditions[]="DATE_FORMAT(Order.created,'%y-%m-%d') between '".$this->request->named['startDate']."' and '".$this->request->named['endDate']."'";
                $conditions[]="DATE_FORMAT(Order.created,'%Y-%m-%d') <= '".$this->request->named['startDate']."' AND DATE_FORMAT(Order.created,'%Y-%m-%d') >= '".$this->request->named['endDate']."'";
            }
            if(isset($this->request->data['serviceType']) && !empty($this->request->data['serviceType'])){
                $conditions[]="service_type ='".$this->request->data['serviceType']."'";
            }elseif(!empty($this->request->named['serviceType'])){
                $conditions[]="service_type ='".$this->request->named['serviceType']."'";  
            }
            if(isset($this->request->data['saloon']) && !empty($this->request->data['saloon'])){
                $conditions[]="Order.salon_id ='".$this->request->data['saloon']."'";
            }elseif(!empty($this->request->named['saloon'])){
                //$conditions[]="Order.salon_id ='".$this->request->named['saloon']."'";  
            }
            if(isset($this->request->data['sieasta_order_id']) && !empty($this->request->data['sieasta_order_id'])){
                $display_order_id = $this->request->data['sieasta_order_id'];
                $conditions[]="Order.display_order_id ='".$this->request->data['sieasta_order_id']."'";
            }elseif(!empty($this->request->named['sieasta_order_id'])){
                $display_order_id = $this->request->data['sieasta_order_id'];
                $conditions[]="Order.display_order_id ='".$this->request->named['sieasta_order_id']."'";  
            }
	}
        
         $conditions['Order.is_checkout'] = 0;
         $conditions['Order.from_cancelled'] = 2;
        //pr($conditions);die;
	/************** Set page limit ************/
         if(isset($this->params->named['type']) && $this->params->named['type'] == 'export'){
            $number_records = 100000;
         }else{
            $number_records = 10;
         }
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
    
        $this->layout = 'admin_paginator';
        $fields = array(
            'Order.id',
	    'Order.transaction_id',
            'Order.transaction_status',
            'Order.display_order_id',
	    'Order.service_type',
	    'Order.start_date',
            'Order.orignal_amount',
            'Order.start_date',
            'Order.tax_amount',
            'Order.sieasta_commision',
            'Order.sieasta_commision_amount',
	    'Order.service_price_with_tax',
            'Order.gift_amount',
            'Order.total_deductions',
            'Order.vendor_dues',
            'Order.created',
            'Order.amount',
            'Order.eng_service_name',
            'Order.order_avail_status',
            'Order.sieasta_point_price',
            'Order.salon_point_price',
            'Order.used_gift_id',
        );
	
        //pr($conditions);echo 'hererere'; die;
	$this->Paginator->settings = array(
		'Order' => array(
                    'recursive'=>-1,
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('Order.id' => 'desc','Order.created' => 'desc')
		)
	    );
	//echo "HI".$this->Order->getLastQuery();
	$breadcrumb = array(
		'Home'=>array('controller'=>'reports','action'=>'list','admin'=>true),
		'Reports'=>'javascript:void(0);'
	    );
        $activeTMenu = 'Order';
        $page_title = 'Reports';
        $this->set(compact('activeTMenu','page_title','breadcrumb','searchFor','allOrders'));
        $allOrders = $this->Paginator->paginate('Order');
        
        // echo "HI".$this->Order->getLastQuery();
        // exit;
        //pr($allOrders); exit;
        /***Get all salons***/
        App::import('Controller', 'AdminReports');
        $this->AdminReports = new AdminReportsController;
        
        $allSaloons = $this->AdminReports->getsalon();
       // pr($allOrders);
        $this->set(compact('allOrders','allSaloons','display_order_id'));
        $this->set('activeTMenu',$activeTMenu);
        $this->set('page_title',$page_title);
        if(isset($this->params->named['type']) && $this->params->named['type'] == 'export'){
                $this->viewPath = "Elements/admin/Reports";
                $this->render('transaction_export');
        }else{
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
                $this->viewPath = "Elements/admin/Reports";
                $this->render('transaction_list');
            }
        }
    }
}
?>