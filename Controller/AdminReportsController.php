<?php
class AdminReportsController extends AppController {
    
    public $helpers = array('Session', 'Html','Form','Js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Paginator','Image','RequestHandler'); //An array containing the names of components this controller uses.
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('auto_report_generate','onetime_report_generate','getsalon','getsalonname','getBalancesByOptionalStatus','admin_vendor_payments');
    }
    function admin_customer_reports(){
      $this->layout='admin';
      $this->set('activeTMenu','reports');
      $this->set('page_title' ,'Customer Reports');
    }
   
    /**********************************************************************************    
    @Function Name : admin_paymentreports
    @Params	    :     NULL
    @Description   : The Function to the payment reports
    @Author        : Niharika Sachdeva
    @Date          : 29-June-2015
    ***********************************************************************************/
    public function admin_paymentreports(){
        $this->layout   =   'admin';
        $this->loadModel('Order');
	$this->loadModel('PaymentReport');
        $conditions= $start = $end = '';
	$salon_list = $this->getsalon();
	$orders = $reports = array();
	$sum = 0;
	//pr($list_salons);
        if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
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
        $fields = array('Order.id','Order.transaction_id','Order.service_type','Order.start_date','Order.orignal_amount','Order.start_date','Order.tax_amount','Order.sieasta_commision','Order.sieasta_commision_amount','Order.service_price_with_tax','Order.total_deductions','Order.vendor_dues','Order.created');
	if(!empty($this->request->data) && $this->request->isAjax()){
	   $salon_id = 	$this->request->data('salon');
	   $current_date = date('Y-m-d');
	   $explode = explode('-', $current_date);
	   $date = $explode[2];
	   $calculate_days_in_month = date("t");
	   if($date <= $calculate_days_in_month){
			$start = $explode[0].'-'.$explode[1].'-01';
			$end = $explode[0].'-'.$explode[1].'-15';
			}if($date >= $calculate_days_in_month){
			$start = $explode[0].'-'.$explode[1].'-16';
			$end = $explode[0].'-'.$explode[1].'-'.$calculate_days_in_month;
	    }  
           $conditions[]="Order.created between '".$start." 00:00:00' and '".$end." 23:59:59'";
	   //pr($conditions);exit;
	$this->Paginator->settings = array(
		'Order' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('created' => 'desc')
		)
	    );
	$orders = $this->Paginator->paginate('Order');
	    if(!empty($orders)){
		$reports['start'] = $start;
		$reports['end'] = $end;
		$reports['salon_name'] = $this->getsalonname($salon_id);
		foreach($orders as $key=>$value){
			$sum+= $value['Order']['vendor_dues'];
		}
		$reports['amount_due'] = $sum;
		$reports['opening_balance'] = $this->get_opening_balance($salon_id , $start , $end);
	    }
	}
	$breadcrumb = array('Home'=>array('controller'=>'reports','action'=>'list','admin'=>true),'Reports'=>'javascript:void(0);');
        $activeTMenu = 'Order';
        $page_title = 'Reports';
        $this->set(compact('activeTMenu','page_title','breadcrumb','searchFor','orders','salon_list','reports'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/AdminReports";
            $this->render('payment_table');

        }
    }
    
    public function getsalon(){
	$this->loadModel('User');
	$this->User->unbindModel(array('hasOne' => array('Address','UserDetail','Contact')), true);
	$this->User->unbindModel(array('hasMany' => array('PricingLevelAssigntoStaff')), true);
	$getsalons = $this->User->find('list',array('conditions' => array(
			'User.is_deleted' => 0,
			'User.is_phone_verified' =>1,
			'User.is_email_verified' =>1,
			'User.status' =>1,
			'User.type IN(2,3,4)'
		    ),
		    'fields'=>array('User.id','Salon.eng_name'),
			'order' => array('Salon.eng_name ASC'),
		    'recursive'=>1
	    )
	);
	return $getsalons;
    }
    
    public function getsalonname($salon_id = null){
	$this->loadModel('Salon');
	$name = $this->Salon->find('first',array('conditions'=>array('Salon.user_id'=>$salon_id),'fields'=>array('Salon.eng_name'),'order'=>array('Salon.end_name ASC')));
	if(!empty($name)){
	    return $name['Salon']['eng_name'];
	}
	
    }
    /**********************************************************************************    
        @Function Name : getBalancesByOptionalStatus
        @Params	       :     NULL
        @Description   : The Function to get opening balance on the basis of salondi,dates and status optional
        @Author        : Anshul Verma
        @Date          : 7-July-2015
    ***********************************************************************************/
    public function getBalancesByOptionalStatus($salon_id = null, $start =null, $end = null,$balanceType=null/*,$status=null*/){
	$this->loadModel('PaymentReport');
        /*if($balanceType=="opening"){
            $fields=array('PaymentReport.opening_balance','PaymentReport.id');
        } elseif($balanceType=="closing"){
            $fields=array('PaymentReport.closing_balance','PaymentReport.id');
        }*/
        $conditions[]=array('PaymentReport.salon_id' => $salon_id , 'PaymentReport.from_date'=> $start,'PaymentReport.to_date'=>$end);
        $get_details = $this->PaymentReport->find('first',array(
			'conditions' => $conditions,						      
			//'fields'=>$fields					      
		));
        return $get_details;
    }
    
	
	
    public function admin_payment(){
        $this->layout  = 'admin_paginator';
	$this->loadModel('Order'); 
        $this->loadModel('PaymentReport'); 
        /***Check against vendor******/
        $sessionData=$this->Session->read('Auth.User');
        $salonId='';
        //pr($sessionData);die;
        if($sessionData['type'] == 4){
            $salonId=$sessionData['id'];
        }
        if(!empty($salonId) && $salonId>0){
             $conditions[]="Order.salon_id ='".$salonId."'";  
        }
//        $current_date = date('Y-m-d');
//        //$current_date = '2016-03-16';
//	$current_day = date('d',strtotime($current_date));
//        $current_month = date('m',strtotime($current_date));
//        $current_year = date('Y',strtotime($current_date));
	$salon_list = $this->getsalon();
        $payment_type = 'bi-monthly';
	if($payment_type == 'bi-monthly'){
//            $datestring = $current_date.' -15 day';
//            $dt = date_create($datestring);
//	    $last_month = $dt->format('m');
//            $rpt_year = $current_year;
//            if($last_month == 12){
//		$rpt_year = $rpt_year-1;
//	    }
//            $days_inlast_number = cal_days_in_month(CAL_GREGORIAN, $last_month, $rpt_year);
//	    
//            $days_inlast_number = floor($days_inlast_number/2);
//	    if(($current_day <= 15)){
//		$starting_date = $rpt_year.'-'.$last_month.'-1';
//                if($last_month == '02'){
//                    $ending_date = date("Y-m-d",strtotime($starting_date.'+ '.($days_inlast_number).' days'));
//                } else {
//                    $ending_date = date("Y-m-d",strtotime($starting_date.'+ '.($days_inlast_number-1).' days'));
//                }
//            } else {
//		 $starting_date = $current_year.'-'.$last_month.'-16';
//                $ending_date = date("Y-m-t",strtotime($starting_date));
//	    }
//            $rpt_start_date=$starting_date;
//            $rpt_end_date=$ending_date;
//            $prev_start_date=date("Y-m-d",strtotime($rpt_start_date.'-15 days'));
//            $prev_end_date=date("Y-m-d",strtotime($rpt_end_date.'-16 days'));

	    $current_date = date('Y-m-d');
	    $current_day = date('d',strtotime($current_date));
	    $first_day = date('Y-m-01');
	    $middle_date =  date('Y-m-d', strtotime($first_day.'+14 days'));
	    $month_ini = new DateTime("first day of last month");
	    $last_month = $month_ini->format('Y-m-d');
	    $last_month_last_day = date('Y-m-t' , strtotime($last_month));
	    $lastmonth_mid = date('Y-m-d' , strtotime($last_month.'+14 days'));
	if($current_day > 15){
	   $starting_date = $first_day;
	   $ending_date = $middle_date;
	}else{
	    $starting_date = $lastmonth_mid;
	    $ending_date = $last_month_last_day;
	    //$ending_date = $middle_date;
	}
	    $rpt_start_date=$starting_date;
            $rpt_end_date=$ending_date;
	
	} else if($payment_type == 'weekly'){
	} else {
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
	//pr($this->request->data);// die;
	$this->Order->virtualFields['orignal_amount'] = 0;
        $this->Order->virtualFields['tax1'] = 0;
        $this->Order->virtualFields['tax2'] = 0;
        $this->Order->virtualFields['tax_amount'] = 0;
        $this->Order->virtualFields['sieasta_commision'] = 0;
        $this->Order->virtualFields['sieasta_commision_amount'] = 0;
        $this->Order->virtualFields['service_price_with_tax'] = 0;
        $this->Order->virtualFields['total_deductions'] = 0;
        $this->Order->virtualFields['vendor_dues'] = 0;
	$this->Order->virtualFields['gift_amount'] = 0;
	$this->Order->virtualFields['amount'] = 0;
	$this->Order->virtualFields['sieasta_point_price'] = 0;
	$this->Order->virtualFields['salon_point_price'] = 0;
       
        $fields = array('Order.id',
		'Order.salon_id',
		'Order.user_id',
		'Order.transaction_id',
		'Order.service_type',
		'Order.start_date',
		'SUM(Order.orignal_amount) As Order__orignal_amount',
		'Order.start_date',
		'SUM(Order.tax1) As Order__tax1',
		'SUM(Order.tax2) As Order__tax2',
		'SUM(Order.tax_amount) As Order__tax_amount',
		'SUM(Order.sieasta_commision) As Order__sieasta_commision',
		'SUM(Order.sieasta_commision_amount) As Order__sieasta_commision_amount',
		'SUM(Order.service_price_with_tax) As Order__service_price_with_tax',
		'SUM(Order.total_deductions) As Order__total_deductions',
		'SUM(Order.vendor_dues) As Order__vendor_dues',
		'SUM(Order.gift_amount) As Order__gift_amount',
		'SUM(Order.amount) As Order__amount',
		'SUM(Order.gift_amount) As Order__gift_amount',
		'SUM(Order.sieasta_point_price) As Order__sieasta_point_price',
		'SUM(Order.salon_point_price) As Order__salon_point_price',
		'Order.created');
	
	$orders = array();
	$conditions = array();
	$conditions[] = "Order.order_avail_status = 1";
	//$rpt_start_date = '2015-09-16';
	//$rpt_end_date = '2015-09-30';
	
	if(!empty($rpt_start_date) && !empty($rpt_end_date)){
	    $conditions[] = "Order.start_date between '".$rpt_start_date." 00:00:00' and '".$rpt_end_date." 23:59:59'";
	}
	if(!empty($this->request->data['Order']['salon'])){
            $conditions[] = "Order.salon_id = ".$this->request->data['Order']['salon'];
        }elseif(!empty($salonId)){
            $conditions[] = "Order.salon_id = ".$salonId;
        }
	$this->Order->unbindModel(array(
	    'belongsTo'=> array('Appointment','SalonService'),
	));
	//pr($conditions);
	//die;
	
	
	$this->Paginator->settings = array(
	    'Order' => array(
		'fields' => $fields,
		'conditions' => $conditions,
                'group'=>array('Order.service_type'),
		'order' => array('created' => 'desc')
	    )
	);
	$orders = $this->Paginator->paginate('Order');
	$breadcrumb = array('Home'=>array('controller'=>'reports','action'=>'list','admin'=>true),'Reports'=>'javascript:void(0);');
        $activeTMenu = 'Order';
        $page_title = 'Reports';
        
	$reports = array();
	
	if(!empty($this->request->data['Order']['salon']) || !empty($salonId)){
            if(!empty($orders)){
		
		if(isset($salonId) && !empty($salonId)){
                    $this->request->data['Order']['salon']=$salonId;
                }
		$this->Session->delete('prevClosingBal');
		$reports['From'] = $rpt_start_date;
		$reports['To'] = $rpt_end_date;
		$reports['salon_user_id'] = $this->request->data['Order']['salon'];
		$reports['Salon'] = @$salon_list[$this->request->data['Order']['salon']];
		
		//echo $this->request->data['Order']['salon'].'----'.$rpt_start_date.'====='.$rpt_end_date.'````'."opening";
		
		/*
		$get_details = $this->getBalancesByOptionalStatus($this->request->data['Order']['salon'],
							$rpt_start_date, $rpt_end_date,"opening");
		pr($get_details); die;
		
                $getPrevDetails=$this->getBalancesByOptionalStatus(
					    $this->request->data['Order']['salon'],
					    $prev_start_date,
					    $prev_end_date,"closing");
		
                if(!empty($getPrevDetails)){
                    $prevClosingBal= $getPrevDetails['PaymentReport']['closing_balance'];
                    if($prevClosingBal>0){
			$this->Session->write('prevClosingBal',$prevClosingBal);
                    }
                    $this->PaymentReport->id=$getPrevDetails['PaymentReport']['id'];
                    $this->PaymentReport->saveField('status','1');
                }*/
		
                $reports['opening_balance']=0;
                /*if(!empty($get_details)){
                    $reports['opening_balance']= $get_details['PaymentReport']['opening_balance'];
                }*/
		
                /*$lastCloseBal=$this->Session->read('prevClosingBal');
                if(isset($lastCloseBal)){
                    $reports['opening_balance']= $reports['opening_balance']+$lastCloseBal;
                }*/
                /*if($reports['opening_balance']==0){
                    $reports['opening_balance']="NIL";
                }*/
                $existingPayment = $this->PaymentReport->find('first',array(
                    'conditions'=>array(
                        'salon_id'=>$this->request->data['Order']['salon'],
                        'from_date'=>$rpt_start_date,
                        'to_date'=>$rpt_end_date)
                    ));
                if(!empty($existingPayment)){
		    $reports['commision'] = $existingPayment['PaymentReport']['sieasta_commission'];
		    $reports['amount_due'] = $existingPayment['PaymentReport']['amount_due'];
		    $reports['closing_amt'] = $existingPayment['PaymentReport']['closing_balance'];
		    $reports['credit_card_commision'] = $existingPayment['PaymentReport']['credit_card_commission'];
		    $reports['opening_balance'] = $existingPayment['PaymentReport']['opening_balance'];
		    $sumDetails=$this->getOrderSum($this->request->data['Order']['salon'], $rpt_start_date, $rpt_end_date);
		    if(!empty($sumDetails)){
                        $reports['gift_amount'] = $sumDetails[0]['gift_amount'];
			$reports['sieasta_point_price'] = $sumDetails[0]['sieasta_point_price'];
			$reports['salon_point_price'] = $sumDetails[0]['salon_point_price'];
			$reports['amount'] = $sumDetails[0]['amount'];
		    }
		    $reports['flag'] = true;
                } else{
		    $sumDetails=$this->getOrderSum($this->request->data['Order']['salon'], $rpt_start_date, $rpt_end_date);
                    if(!empty($sumDetails)){
                        $reports['commision'] = $sumDetails[0]['commision'];
                        $reports['amount_due'] = $sumDetails[0]['vendorDue'];
                        $reports['closing_amt'] = $sumDetails[0]['vendorDue'];
                        $reports['credit_card_commision'] = $sumDetails[0]['credit_card_commision'];
			$reports['gift_amount'] = $sumDetails[0]['gift_amount'];
			$reports['sieasta_point_price'] = $sumDetails[0]['sieasta_point_price'];
			$reports['salon_point_price'] = $sumDetails[0]['salon_point_price'];
			$reports['amount'] = $sumDetails[0]['amount'];
		    }
		    /*if any previous report ***/
		    $prevPayment = $this->PaymentReport->find('first',array(
			'conditions'=>array(
			    'salon_id' => $this->request->data['Order']['salon'],
			    'to_date < ' => $rpt_start_date)
			));
		    if(!empty($prevPayment)){
			$reports['opening_balance'] = $prevPayment['PaymentReport']['closing_balance'];
		    } else {
			$reports['opening_balance'] = 0;
		    }
		    //$reports['opening_balance'] = $existingPayment['PaymentReport']['opening_balance'];
                }
	    }
	}
        $this->set(compact('activeTMenu','page_title','breadcrumb','searchFor','orders','salon_list','reports'));
	if($this->request->is('ajax')){
            $this->layout = 'ajax';
	    $this->viewPath = "Elements/admin/AdminReports";
            $this->render('payment');
        }
    }

    
    /**********************************************************************************    
        @Function Name : admin_paymentCycle
        @Params	    :     NULL
        @Description   : The Function to the pay to reports
        @Author        : Anshul Verma
        @Date          : 2-July-2015
    ***********************************************************************************/
    function admin_paymentCycle(){
        $this->loadModel('PaymentReportPaid');
        $this->loadModel('PaymentReport');
        if($this->request->is('ajax')){
            $savedata = array();
	    $savedata['PaymentReport']['salon_id'] = $this->request->data['user_id'];
            $savedata['PaymentReport']['from_date'] = $this->request->data['from_date'];
            $savedata['PaymentReport']['to_date'] = $this->request->data['to_date'];
            $savedata['PaymentReport']['opening_balance'] = $this->request->data['opening_balance'];
            $savedata['PaymentReport']['amount_due'] = $this->request->data['amount_due'];
            if($this->request->data['opening_balance'] != "NIL") {
                $savedata['PaymentReport']['closing_balance'] = $this->request->data['closing_balance']+$this->request->data['opening_balance'];
		//$savedata['PaymentReport']['amount_due'] = $this->request->data['amount_due']+$this->request->data['opening_balance'];
            } else{
                $savedata['PaymentReport']['closing_balance'] = $this->request->data['closing_balance'];
            }
            $savedata['PaymentReport']['credit_card_commission']=$this->request->data['credit_card_commision'];
            $savedata['PaymentReport']['sieasta_commission']=$this->request->data['sieasta_commission'];
            $this->loadModel('PaymentReport');
            $get_details = $this->PaymentReport->find('first',array(
                'conditions' => array(
                    'PaymentReport.salon_id' => $this->request->data['user_id'],
                    'PaymentReport.from_date'=> $this->request->data['from_date'],
                    'PaymentReport.to_date'=>$this->request->data['to_date']
                ),
            ));
            if($get_details){

            }else{
                $this->PaymentReport->set($savedata);
                $this->PaymentReport->save();
                $lastid= $this->PaymentReport->getLastInsertID();
                $get_details = $this->PaymentReport->find('first',array(
                    'conditions' => array('PaymentReport.id' => $lastid),
                ));
                $this->Session->delete('prevClosingBal');
            }
            $this->set(compact('get_details'));
        }
        if(!$this->request->is('ajax')){
            if ($this->request->is(array('post', 'put'))) {
                if(!empty($this->request->data['PaymentReportPaid']['proff_file']['name'])){
                    $userId = $this->Auth->user('id');
                    $model = "PaymentReport";
                    $return = $this->Image->upload_image($this->request->data['PaymentReportPaid']['proff_file'], $model, $userId);
                }
                if(!empty($return)){
                    $this->request->data['PaymentReportPaid']['proff_file']=$return;
                }else{
                    $this->request->data['PaymentReportPaid']['proff_file']=null;
                }
                $this->PaymentReportPaid->set($this->request->data);
                $payReportDetails=$this->PaymentReport->find('first',array('conditions'=>array('id'=>$this->request->data['PaymentReportPaid']['payment_report_id']),'fields'=>array('PaymentReport.closing_balance','PaymentReport.id')));
                $finalClosingBalance=$payReportDetails['PaymentReport']['closing_balance']-$this->request->data['PaymentReportPaid']['paid_amount'];
                if($this->PaymentReportPaid->save($this->request->data)){
                    $this->PaymentReport->id = $payReportDetails['PaymentReport']['id'];
                    $this->PaymentReport->saveField('closing_balance', $finalClosingBalance);
                    if($finalClosingBalance==0){
                        // Commented by Shibu on 1 Oct 
			//$this->PaymentReport->saveField('status', '1');
                        //$this->PaymentReport->saveField('opening_balance', '0');
                    }
                    $this->Session->setFlash(__('Payment Report Added Successfully'), 'flash_success');
                    $this->redirect(array('controller'=>'adminReports','action'=>'admin_payment'));
                } else{
                    $this->Session->setFlash(__('Not able to add Payment Report'), 'flash_error');
                    $this->redirect(array('controller'=>'adminReports','action'=>'admin_payment'));
                }
            }
        }
        
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
	    $this->viewPath = "Elements/admin/AdminReports";
            $this->render('payment_cycle');
        } else{
            $this->layout = 'ajax';
	    $this->viewPath = "Elements/admin/AdminReports";
            $this->render('payment_cycle');
        }
    }
    
    /**********************************************************************************    
        @Function Name : getOrderSum
        @Params	    :     NULL
        @Description   : The Function to get the order sum
        @Author        : Anshul Verma
        @Date          : 2-July-2015
    ***********************************************************************************/
    function getOrderSum($salonId=null, $startDate=null, $endDate=null){
        $this->loadModel('Order');
	$return_val = array();
	if(!empty($salonId) && !empty($startDate) && !empty($endDate) ){
	    $conditions = array(
		    "Order.salon_id" => $salonId,
		    "Order.start_date between '".$startDate." 00:00:00' and '".$endDate." 23:59:59'",
		    "Order.order_avail_status" => 1
		);
	
	    $fields = array(
		    'sum(Order.sieasta_commision_amount) as commision',
		    'sum(Order.vendor_dues) as vendorDue' ,
		    'sum(Order.total_deductions) as credit_card_commision',
		    'sum(Order.gift_amount) as gift_amount',
		    'sum(Order.sieasta_point_price) as sieasta_point_price',
		    'sum(Order.salon_point_price) as salon_point_price',
		    'sum(Order.amount) as amount',
		);
	    //$this->Order->unbind(array('hasMany'=>'OrderDetail'));
	    $return_val = $this->Order->find('first',array('conditions' => $conditions,'fields'=>$fields));
	}
	return $return_val;
    }
    
    
    public function admin_vendor_payments(){
        App::import('Controller', 'AdminReports');
        $this->AdminReports = new AdminReportsController;
        $salon_list = $this->AdminReports->getsalon();
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
    
	if(!empty($this->request->data['PaymentReport']['salon']) || !empty($this->request->named['salon'])){
	    if(!empty($this->request->data['PaymentReport']['salon'])){
			$salon_id = $this->request->data['PaymentReport']['salon'];
		}
		else{
			$salon_id = $this->request->named['salon'];
		}
	}

	$logged_in_user_type = $this->Session->read('Auth.User.type');
	$logged_in_user_parent = $this->Session->read('Auth.User.parent_id');
	if($logged_in_user_type == 4 || $logged_in_user_type == 5){
	    if($logged_in_user_type == 4){$salon_id = $this->Session->read('Auth.User.id');}
	    else if($logged_in_user_type == 5){$salon_id = $logged_in_user_parent;}
	}
	/*
	if((!empty($this->request->data['PaymentReport']['startDate']) && !empty($this->request->data['PaymentReport']['endDate1']))
	   ||
	   (!empty($this->request->named['startDate']) && !empty($this->request->named['endDate']))
	   ){
	    if((!empty($this->request->data['PaymentReport']['startDate']) && !empty($this->request->data['PaymentReport']['endDate1']))){
		$start_date = date('Y-m-d', strtotime($this->request->data['PaymentReport']['startDate']));
		$e_d = trim($this->request->data['PaymentReport']['endDate1']);
		echo '------'.$d = DateTime::createFromFormat('Y-m-d',$e_d);
		$end_date = date('Y-m-d', strtotime($e_d));
	    }else if((!empty($this->request->named['startDate']) && !empty($this->request->named['endDate']))){
		$start_date = date('Y-m-d', strtotime($this->request->named['startDate']));
		$end_date = date('Y-m-d', strtotime($this->request->named['endDate']));
	    }
	    
	}
	*/
	$this->loadModel('PaymentReport');
	$this->params->data['number_records'] = $number_records;
	$fields = array('PaymentReport.id',
		'PaymentReport.salon_id',
		'PaymentReport.from_date',
		'PaymentReport.to_date',
		'PaymentReport.opening_balance',
		'PaymentReport.closing_balance',
		'PaymentReport.amount_due',
		'PaymentReport.report_title',
		'PaymentReport.created',
		'Salon.user_id',
		'Salon.eng_name',
	    );
	$joins = array(
	    array('table' => 'salons',
		'alias' => 'Salon',
		'type' => 'INNER',
		'conditions' => array('Salon.user_id = PaymentReport.salon_id')
	    )
	);
	$conditions = array();
	if(!empty($salon_id)){
	    $conditions = array("PaymentReport.salon_id" => $salon_id);
	}
	
	//pr($this->request->named);
	//pr($salon_id);
	//pr($conditions);
	/*
	if(!empty($start_date) && !empty($end_date)){
	    $conditions = array("PaymentReport.created >= '".$start_date."' and PaymentReport.created <= '".$end_date."'");
	}
		pr($this->request->data);
	pr($conditions);*/
    
	$this->Paginator->settings = array(
		'PaymentReport' => array(
		    'limit'=>$number_records,
			'fields' => $fields,
			'conditions' => $conditions,
		    'joins' => $joins,
		    'order' => array('PaymentReport.created' => 'desc')
		)
	    );
	$payment_rpts = $this->Paginator->paginate('PaymentReport');
	//pr($payment_rpts); //exit;
	
	$breadcrumb = array('Home'=>array('controller'=>'reports','action'=>'list','admin'=>true),'Reports'=>'javascript:void(0);');
        $activeTMenu = 'PaymentReports';
        $page_title = 'Salon Payment Reports';
	$sum = 0;
	$reports = array();
        $this->set(compact('activeTMenu','page_title','breadcrumb','payment_rpts','salon_list','salon_id'));
	if($this->request->is('ajax')){
        $this->layout = 'ajax';
	    $this->viewPath = "Elements/admin/AdminReports";
            $this->render('vendor_payment');
        } else {
            $this->layout = 'admin_paginator';
            //$this->viewPath = "AdminReports";
            //$this->render('admin_vendor_payments');
        }
    }

    
    public function auto_report_generate(){
	$this->loadModel('Order'); 
        $this->loadModel('PaymentReport');
	$current_date = date('Y-m-d');
	$current_day = date('d',strtotime($current_date));
	if(in_array($current_day,array(1,16))){
	    $current_month = date('m',strtotime($current_date));
	    $current_year = date('Y',strtotime($current_date));
	    $datestring = $current_date.'-15 days';
	    $date_lastm = date('Y-m-d',strtotime($datestring));
	    $dt = date_create($datestring);
	    //get previous cycle dates 
	    $auto_report_date = date('Y-m-d',strtotime('-15 days',strtotime($date_lastm)));
	    $auto_report_month = date('m',strtotime($auto_report_date));
	    $auto_report_day = date('d',strtotime($auto_report_date));
	    
	    if(($auto_report_month == 2)){
		$maxDays = date('t',strtotime($auto_report_date));
		if($maxDays == 29){
		    $auto_report_date = date('Y-m-d',strtotime('+1 days',strtotime($auto_report_date)));
		} else if($maxDays == 28){
		    $auto_report_date = date('Y-m-d',strtotime('+2 days',strtotime($auto_report_date)));
		}
		if($auto_report_day == 01 || $auto_report_day == 1){
		    $auto_report_enddate = date('Y-m-d',strtotime('+14 days',strtotime($auto_report_date)));
		} else {
		    $auto_report_enddate = date('Y-m-t', strtotime($auto_report_date));
		}
	    } else if(in_array($auto_report_month,array(1,3,5,7,8,10,12))){
		$auto_report_date = date('Y-m-d',strtotime('-1 days',strtotime($auto_report_date)));
		if($auto_report_day == 01 || $auto_report_day == 1){
		    $auto_report_enddate = date('Y-m-d',strtotime('+14 days',strtotime($auto_report_date)));
		} else {
		    $auto_report_enddate = date('Y-m-t', strtotime($auto_report_date));
		}
		
	    } else {
		if($auto_report_day == 01 || $auto_report_day == 1){
		    $auto_report_enddate = date('Y-m-d',strtotime('+14 days',strtotime($auto_report_date)));
		} else {
		    $auto_report_enddate = date('Y-m-t', strtotime($auto_report_date));
		}
	       
	    }
	    
	    $salon_list = $this->getsalon();

	    if(!empty($salon_list)) {
		foreach($salon_list as $key => $salon_id){
		    $this->loadModel('PaymentReport');
		    
		    $is_report = $this->PaymentReport->find('first', array(
			    'conditions' => array(
				'PaymentReport.salon_id' => $key,
				'PaymentReport.to_date' => $auto_report_enddate
			    )
			));
		    
		    
		    if(!empty($is_report)){
			if($is_report['PaymentReport']['status'] == 0){
			    $updateReport['PaymentReport']['id'] = $is_report['PaymentReport']['id'];
			    $updateReport['PaymentReport']['status'] = 1;
			    $this->PaymentReport->set($updateReport);
			    $this->PaymentReport->save($updateReport);
			}
		    } else {
			$sumDetails = $this->getOrderSum($key, $auto_report_date, $auto_report_enddate);
			$newReport['PaymentReport']['id'] = 0;
			$newReport['PaymentReport']['salon_id'] = $key;
			$newReport['PaymentReport']['from_date'] = $auto_report_date;
			$newReport['PaymentReport']['to_date'] = $auto_report_enddate;
			
			$is_previousReport = $this->PaymentReport->find('first', array(
			    'conditions' => array(
				'PaymentReport.salon_id' => $key,
				'PaymentReport.to_date < ' => $auto_report_date
			    )
			));
			
			if(!empty($is_previousReport)){
			    $updatePrevRpt['PaymentReport']['id'] = $is_previousReport['PaymentReport']['id'];
			    if($is_previousReport['PaymentReport']['status'] == 0){
				$updatePrevRpt['PaymentReport']['status'] = 1;
				$this->PaymentReport->set($updatePrevRpt);
				$this->PaymentReport->save($updatePrevRpt);
			    }
			    $newReport['PaymentReport']['opening_balance'] = $is_previousReport['PaymentReport']['closing_balance'];
			} else {
			    $newReport['PaymentReport']['opening_balance'] = 0;
			}
			$newReport['PaymentReport']['closing_balance'] = $newReport['PaymentReport']['opening_balance'] + $sumDetails[0]['vendorDue'];
			$newReport['PaymentReport']['amount_due'] = $sumDetails[0]['vendorDue'];
			$newReport['PaymentReport']['report_title'] = '';
			$newReport['PaymentReport']['sieasta_commission'] = $sumDetails[0]['commision'];
			$newReport['PaymentReport']['credit_card_commission'] = $sumDetails[0]['credit_card_commision'];	
			$newReport['PaymentReport']['status'] = 1;
			if(!empty($newReport['PaymentReport']['amount_due'])){
			    $this->PaymentReport->set($newReport);
			    $this->PaymentReport->save($newReport);
			}
		    }
		    
		}
	    }
	    die;
	}
	die;
    }

    /*public function admin_auto_report_generate(){
	$this->layout   =   'admin_paginator';
	$this->loadModel('Order'); 
        $this->loadModel('PaymentReport');
	$this->autoRender = false;
	$sessionData = $this->Session->read('Auth.User');
        $salonId = '';
        if($sessionData['type'] == 4){
            $salonId = $sessionData['id'];
        }
        if(!empty($salonId) && $salonId>0){
            $conditions[] = "Order.salon_id ='".$salonId."'";  
        }
        $current_date = date('Y-m-d');
	$current_day = date('d',strtotime($current_date));
	$current_month = date('m',strtotime($current_date));
        $current_year = date('Y',strtotime($current_date));
        $payment_type = 'bi-monthly';
	if($payment_type == 'bi-monthly'){
            $datestring = $current_date.' last month';
            $dt = date_create($datestring);
	    $last_month = $dt->format('m');
            $rpt_year = $current_year;
            if($last_month == 12){
		$rpt_year = $rpt_year-1;
	    }
	    $days_inlast_number = cal_days_in_month(CAL_GREGORIAN, $last_month, $rpt_year);
            $days_inlast_number = floor($days_inlast_number/2);
	    if(($current_day <= 15)){
		$starting_date = $rpt_year.'-'.$last_month.'-1';
                if($last_month == '02'){
                    $ending_date = date("Y-m-d",strtotime($starting_date.'+ '.($days_inlast_number).' days'));
                } else {
                    $ending_date = date("Y-m-d",strtotime($starting_date.'+ '.($days_inlast_number-1).' days'));
                }
            } else {
		$starting_date = $current_year.'-'.$last_month.'-16';
                $ending_date = date("Y-m-t",strtotime($starting_date));
	    }
	    $rpt_start_date = $starting_date;
	    $rpt_end_date = $ending_date;
	    //Previous Start date and End Date
	    $prev_start_date = date("Y-m-d",strtotime($rpt_start_date.'-15 days'));
	    $prev_end_date = date("Y-m-d",strtotime($rpt_end_date.'-16 days'));
	    $salon_list = $this->getsalon();
	    if(!empty($salon_list)) {
		foreach($salon_list as $key => $salon_id){
		    $this->loadModel('PaymentReport');
		    // Find the records of previous date for each salon in payment_report table 
		    $is_report = $this->PaymentReport->find('all', array(
			    'conditions' => array(
				'PaymentReport.salon_id' => $key,
				'PaymentReport.from_date' => $prev_start_date,
				'PaymentReport.to_date' => $prev_end_date
			    )
			));
		    // Find the previous date details
		    $getPrevDetails = $this->get_salon_prev_details($key);
		    $totalCloseAmount = 0;
		    if(!empty($getPrevDetails)){
			foreach($getPrevDetails as $key1 => $prevDetails){
			    $totalCloseAmount  = $totalCloseAmount + $prevDetails['PaymentReport']['closing_balance']; 		
			}
		    }
		    
		    $i = 0;
		    if(isset($is_report) && count($is_report) > 0){
			$is_current_report = $this->PaymentReport->find('first', array(
				'conditions' => array(
					'PaymentReport.salon_id' => $key,
				),
				'order' => array('PaymentReport.created' => 'DESC')
			    ));
			// If current date record is found then update the previous due_amount in new opening_balance
			if(isset($is_current_report) && count($is_current_report) > 0){
			    $opening_balance = 0;
			    foreach($is_report as $key => $report){
				$opening_balance = $opening_balance + $report['PaymentReport']['amount_due'];					
			    }
			    $updateBalance = array(
				    'opening_balance' => $opening_balance
			    );
			    if($this->PaymentReport->updateAll($updateBalance, array('PaymentReport.id' => $is_current_report['PaymentReport']['id']))){
				    $i++;
			    }
			}
			//Update the status only when the payment report status is not 1
			foreach($is_report as $key => $report){
			    if($report['PaymentReport']['status'] == 0){
				$updateData = array(
					'PaymentReport.status' => '1'
				    );
				if($this->PaymentReport->updateAll($updateData, array('PaymentReport.salon_id' => $key))){
				    $i++;
				}	
			    }	
			}
		    } // If payment report is not found then insert a new entry of previous date for each salon  
		    else{
			// Calculate all the amount for each salon from orders table
			$sumDetails = $this->getOrderSum($key , $prev_start_date , $prev_end_date);
			if(isset($totalCloseAmount) && $totalCloseAmount != ''){
			    $reports['opening_balance'] = $totalCloseAmount;
			} else{
			    $reports['opening_balance'] = 0;
			}
			if(!empty($sumDetails)){
			    $reports['sieasta_commission'] = $sumDetails[0]['commision'];
			    $reports['amount_due'] = $sumDetails[0]['vendorDue'];
			    $reports['closing_balance'] = $sumDetails[0]['vendorDue'] + $reports['opening_balance'];
			    $reports['credit_card_commission'] = $sumDetails[0]['credit_card_commision'];
			}
			$reports['salon_id'] = $key;
			$reports['from_date'] = $prev_start_date;
			$reports['to_date'] = $prev_end_date;
			$reports['status'] = '1';
			$this->PaymentReport->create();
			if($this->PaymentReport->save($reports, false)){
			    $i++;
			}
		    }
		}
	    }
	    if($i > 0){
		$result['status'] = 1;
		$result['msg'] = 'New payment report of previous date is generated';
		echo json_encode($result);
	    } else{
		    $result['status'] = 0;
		    $result['msg'] = 'All Report of previous date is already there';
		    echo json_encode($result);
	    }
	}
    }
	*/
    
    
    public function get_salon_prev_details($salon_id = null){
	$get_details = array();
	if(!empty($salon_id)) {
	    $this->loadModel('PaymentReport');
	    $fields=array('PaymentReport.closing_balance','PaymentReport.id','PaymentReport.salon_id');
	    $conditions=array('PaymentReport.salon_id' => $salon_id);
	    $get_details = $this->PaymentReport->find('all',array(
		    'conditions' => $conditions,
		    //'fields'=>$fields
		));
	}
	return $get_details;
    }
    
    
    public function onetime_report_generate(){
		$this->autoRender = false;
		$this->loadModel('Order'); 
        $this->loadModel('PaymentReport');
	
        
	$prev_start_date = '2015-04-01';
    $prev_end_date = '2015-07-15';
	$salon_list = $this->getsalon();
	if(!empty($salon_list)) {
	    foreach($salon_list as $key => $salon_id){
		$this->loadModel('PaymentReport');
		$totalCloseAmount = 0;
		// Calculate all the amount for each salon from orders table
		$sumDetails = $this->getOrderSum($key , $prev_start_date , $prev_end_date);
		//echo '<pre>';
		//print_r($sumDetails);
		$reports['opening_balance'] = 0;
		
		if(!empty($sumDetails)){
		    $reports['sieasta_commission'] = $sumDetails[0]['commision'];
		    $reports['amount_due'] = $sumDetails[0]['vendorDue'];
		    $reports['closing_balance'] = $sumDetails[0]['vendorDue'] + $reports['opening_balance'];
		    $reports['credit_card_commission'] = $sumDetails[0]['credit_card_commision'];
		    $reports['salon_id'] = $key;
		    $reports['from_date'] = $prev_start_date;
		    $reports['to_date'] = $prev_end_date;
		    $reports['status'] = '1';
		    if(!empty($reports['closing_balance'])){
			$reports['id'] = 0;
			$this->PaymentReport->set($reports);
			$this->PaymentReport->save($reports, false);
		    }
		}
	    }
	}
    }
	
	
	public function admin_paid_amount_details($salon_id= null, $payment_report_id= null){
		$this->layout = 'admin';
		$this->autoRender = false;
		$this->loadModel('PaymentReportPaid');
		if($this->request->is('ajax') && !empty($payment_report_id) && !empty($salon_id)){
		    //$this->PaymentReportPaid->bindModel(array('belongsTo' => array('Salon')), true);
		    $conditions = array(
			    'PaymentReportPaid.payment_report_id'=> $payment_report_id,
			    'PaymentReportPaid.salon_id' => $salon_id
		    );
		    $this->Paginator->settings = array(
			    'PaymentReportPaid' => array(
				    'conditions' => $conditions,
			    )
		    );
		    $paid_amount_details = $this->Paginator->paginate('PaymentReportPaid');
		    //pr($paid_amount_details); exit;
		    $this->layout = 'ajax';
		    $this->viewPath = "Elements/admin/AdminReports";
		    $this->set(compact('paid_amount_details'));
		    $this->render('admin_paid_amount_details');
		}
		else{
			
		}
	}
	
	
}
?>