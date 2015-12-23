<?php

/*
 * Payments Controller class
 * Functionality -  Manage the Publisher Payments
 * Developer - Vipul Sharma
 * Created date - 13-August-2014
 * Modified date - 
 */

App::import("Vendor", "/paypal/PPBootStrap");
App::import("Vendor", "/paypal/Common/Constants");	
class PaymentsController extends AppController {
    var $name = 'Payments';
    public $components = array('Paginator', 'Image', 'Common', 'Email', 'Cookie', 'Captcha');
    
    function beforeFilter() {
        parent::beforeFilter();
        if (!isset($_SESSION)) {
              session_start();
        }
    }

    /* Admin Functionality start */

    /*
     * admin_index function
     * Functionality -  Payments Listing
     * Developer - Vipul Sharma
     * Created date - 13-Aug-2014
     */

    function admin_index() {
        $this->loadModel('User');
        /* Active/Inactive/Delete functionality */
            if((isset($this->data["User"]["setStatus"]))) {
            if(!empty($this->request->data['Payment']['status'])) {
                $status = $this->request->data['Payment']['status'];
            } else {
                $this->Session->setFlash("Please select the action.", 'default', array('class' => 'alert alert-danger'));
                $this->redirect(array('action' => 'index'));
            }
            $CheckedList = $this->request->data['checkboxes'];
            $model = 'Payment';
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            $this->setStatus($status, $CheckedList, $model, $controller, $action);
        }
        /* Active/Inactive/Delete functionality */
        $value = "";
        $value1 = "";
        $show = "";
        $account_type = $user_type_key = "";
        $criteria = "";
       // $criteria = "Payment.is_deleted =0 ";

        if(!empty($this->params->query)){
            //echo "<pre>";print_r($this->params);die;
            if (!empty($this->params->query['keyword'])) {
                $value = trim($this->params->query['keyword']);
            }
            if ($value != "") {
                $criteria .= " AND (User.first_name LIKE '%" . $value . "%' OR User.last_name LIKE '%" . $value . "%' OR User.email LIKE '%" . $value . "%')";
            }
            if (!empty($this->params->query['alphabet_letter'])) {
                $value1 = trim($this->params->query['alphabet_letter']);
            }
            if ($value1 != "") {
                $criteria .= " AND (User.first_name LIKE '" . $value1 . "%')";
            }
            if(!empty($this->params->query['user_type']) || ($this->params->query['user_type']=='0')){
                $user_type_key = trim($this->params->query['user_type']);
                $criteria .= "AND (User.user_type = '" . $user_type_key . "')";
            }
            if (!empty($this->params->query['currentdate'])) {
                $user_type_key = trim($this->params->query['currentdate']);
                $criteria .= " AND (User.created > '" . $user_type_key . "')";
            }
        }
        $this->Paginator->settings = array('conditions' => array($criteria),
                'limit' => 10,
                'fields' => array('Payment.id',
                'Payment.user_id',
                'Payment.amount',
                'Payment.status',
                'Payment.created',
                'Payment.pay_key',
                'User.first_name',
                'User.last_name',
                'User.paypal_email'
            ),
            'order' => array(
            'Payment.id' => 'DESC'
            )
        );
        $alphabetArray = array();
        //	$alphabetArray['0-9'] = '0-9';		
        for ($i = 65; $i <= 90; $i++) {
            $alphabetArray[chr($i)] = chr($i);
        }
        $this->set('getData', $this->Paginator->paginate('Payment'));
        $this->set('keyword', $value);
        $this->set('user_type_key', $user_type_key);
        $this->set('alphakeyword', $value1);
        $this->set('show', $show);
        $this->set('alphabetArray', $alphabetArray);
        $this->set('navusers', 'class = "active"');
        $this->set('breadcrumb', 'Users');
         
    }
    
    function cron_paypal(){
		$this->autoRender = false;
		/**
		 * List of users with payment above $100
		 * Load Model
		 * */
		$dataset = $this->Payment->find('all');
                if(!empty($dataset)){
			foreach($dataset as $d){
				$receiver = array();
				if(!$d['Payment']['status'] && !empty($d['User']['paypal_email'])){
				 /*
				 * A receiver's email address 
				 */
					$receiver = new Receiver();
					$receiver->email =  $d['User']['paypal_email'];
					/*
					 *  	Amount to be credited to the receiver's account 
					 */
					$receiver->amount = $d['Payment']['amount'];
				
				        $receiverList = new ReceiverList($receiver);
				
				$returnUrl = configure::read('BASE_URL').'/admin/payments/cron_paypal_return/'.base64_encode($d['Payment']['id']);
				$cancelUrl = configure::read('BASE_URL').'/admin/payments/cron_paypal_cancel/';
				/*
				 * URL to redirect the sender's browser to after the sender has logged into PayPal and approved a payment; it is always required but only used if a payment requires explicit approval 
				 */
				$payRequest = new PayRequest(new RequestEnvelope("en_US"), 'PAY', $cancelUrl, 'USD', $receiverList, $returnUrl);

				/*
				 * 	 ## Creating service wrapper object
				Creating service wrapper object to make API call and loading
				Configuration::getAcctAndConfig() returns array that contains credential and config parameters
				 */
				$service = new AdaptivePaymentsService(Configuration::getAcctAndConfig());
				try {
					/* wrap API method calls on the service object with a try catch */
					$response = $service->Pay($payRequest);
				} catch(Exception $ex) {
					App::import("Vendor", "/paypal/Common/Error");	
					exit;
				}
				$ack = strtoupper($response->responseEnvelope->ack);
				if($ack != "SUCCESS") {
					echo "<b>Error </b>";
					echo "<pre>";
					pr($response);
					echo "</pre>";
				} else {
					
				$payKey = $response->payKey;
				$payPalURL = PAYPAL_REDIRECT_URL . '_ap-payment&paykey=' . $payKey;
				echo $payPalURL;
				$this->Payment->id = $d['Payment']['id'];
				$data['Payment']['pay_key'] = $payKey;
				$this->Payment->save($data);
				}
			}
		}
	}
	
	}

	function admin_cron_paypal_return($id){
		$this->autoRender = false;
		$this->Payment->id = base64_decode($id);
		$data['Payment']['status'] = 1;
		$this->Payment->save($data);
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_cron_paypal_cancel(){
		$this->redirect(array('action' => 'index'));
	}
        
        
     /*
     * admin_revenue_index function
     * Functionality -  revenue Listing
     * Developer - Deepika Sharma
     * Created date - 07-Oct-2014
     */

    function admin_revenue_index(){
        $this->loadModel('PageView');
        $this->loadModel('User');
        /* Active/Inactive/Delete functionality */
        $value = "";
        $value1 = "";
        $show = "";
        $account_type = $user_type_key = "";
        $criteria = "";
        $criteria = "User.id in (select uid from page_views) and User.is_deleted =0 ";

        if(!empty($this->params->query)){
            //echo "<pre>";print_r($this->params);die;
            if (!empty($this->params->query['keyword'])) {
                $value = trim($this->params->query['keyword']);
            }
            if ($value != "") {
                $criteria .= " AND (User.first_name LIKE '%" . $value . "%' OR User.last_name LIKE '%" . $value . "%')";
            }
            if (!empty($this->params->query['alphabet_letter'])) {
                $value1 = trim($this->params->query['alphabet_letter']);
            }
            if ($value1 != "") {
                $criteria .= " AND (User.first_name LIKE '" . $value1 . "%')";
            }
        }
        
        
        //$this->Paginator->settings = array('fields' => array("User.id, concat(User.first_name,' ',User.last_name) as name, PageView.uid, SUM(PageView.profit) as user_view_count, if(SUM(PageView.profit) >= 1000, ROUND((SUM(PageView.profit)/1000), 2) *2, 0) as user_revenue"),
        //                    'conditions' => array($criteria),
        //                    'joins' => array(
        //                        array('table' => 'page_views',
        //                            'alias' => 'PageView',
        //                            'type' => 'LEFT',
        //                            'conditions' => array(
        //                                'User.id = PageView.uid'
        //                            )
        //                        )
        //                    ),
        //                    'order' => array(
        //                            'User.name' => 'DESC'
        //                    ),
        //                    'group' => 'PageView.uid'
        //);

        //SELECT User.id, User.revenue_percent, concat(User.first_name,' ',User.last_name) as name, SUM(PageView.user_view_count) as user_view_count, SUM(PageView.user_revenue) as user_revenue FROM `users` AS `User` LEFT JOIN (select uid, page_name_id, rate, SUM(profit) as user_view_count, (ROUND((SUM(profit)/1000) * rate, 2)) as user_revenue from page_views where page_name_id in (select id from contents where is_deleted = 0) GROUP BY uid, page_name_id, rate) AS PageView ON (`User`.`id` = `PageView`.`uid`) WHERE `User`.`id` in (select uid from page_views) and `User`.`is_deleted` =0 Group by User.id LIMIT 20 
        
        
        $this->Paginator->settings = array('fields' => array("User.id, User.revenue_percent, concat(User.first_name,' ',User.last_name) as name, SUM(PageView.user_view_count) as user_view_count, SUM(PageView.user_revenue) as user_revenue"),
                            'conditions' => array($criteria),
                            'joins' => array(
                                array('table' => '(select uid, page_name_id, rate, SUM(profit) as user_view_count, (ROUND((SUM(profit)/1000) * rate, 2)) as user_revenue from page_views where page_name_id in (select id from contents where is_deleted = 0) GROUP BY uid, page_name_id, rate) as PageView',
                                    //'alias' => 'PageView',
                                    'type' => 'LEFT',
                                    'conditions' => array(
                                        'User.id = PageView.uid'
                                    )
                                )
                            ),
                            'order' => array(
                                    'User.name' => 'DESC'
                            ),
                            'group' => 'User.id'
        );
        $contents = $this->Paginator->paginate('User');
        
        //$main_content_arr = array();
        //foreach($contents as $content){
        //    $main_content_arr[$content['User']['id']]['User'] = $content['User'];
        //    $main_content_arr[$content['User']['id']][0]['user_view_count'] = !empty($main_content_arr[$content['User']['id']][0]['user_view_count']) ? $main_content_arr[$content['User']['id']][0]['user_view_count'] + $content[0]['user_view_count'] : $content[0]['user_view_count'];
        //    $main_content_arr[$content['User']['id']][0]['user_revenue'] = !empty($main_content_arr[$content['User']['id']][0]['user_revenue']) ? $main_content_arr[$content['User']['id']][0]['user_revenue'] + $content[0]['user_revenue'] : $content[0]['user_revenue'];
        //}
        
        //pr($contents); die;
        $this->set('getData', $contents);
        $this->set('keyword', $value);
        $this->set('user_type_key', $user_type_key);
        $this->set('alphakeyword', $value1);
        $this->set('show', $show);
        $this->set('navusers', 'class = "active"');
        $this->set('breadcrumb', 'Revenue');
         
    }
    
    
    
    
     /*
     * admin_user_posts function
     * Functionality -  revenue Listing
     * Developer - Deepika Sharma
     * Created date - 07-Oct-2014
     */

    function admin_user_posts($user_id=null) {
        $this->loadModel('PageView');
        $user_id = base64_decode($user_id);
        /* Active/Inactive/Delete functionality */
        $value = "";
        $value1 = "";
        $show = "";
        $account_type = $user_type_key = "";
        $criteria = "";
        $criteria = "PageView.uid = ".$user_id." and PageView.page_name_id in (select id from contents where is_deleted = 0)";

        if(!empty($this->params->query)){
            //echo "<pre>";print_r($this->params);die;
            if (!empty($this->params->query['keyword'])) {
                $value = trim($this->params->query['keyword']);
            }
            if ($value != "") {
                $criteria .= " AND (Content.title LIKE '%" . $value . "%')";
            }
            if (!empty($this->params->query['alphabet_letter'])) {
                $value1 = trim($this->params->query['alphabet_letter']);
            }
            if ($value1 != "") {
                $criteria .= " AND (Content.title LIKE '" . $value1 . "%')";
            }
        }
       
        $this->PageView->bindModel(array('belongsTo' => array('Content' => array('foreignKey' => 'page_name_id'))));
//        $this->Paginator->settings = array('fields' => array("Content.title, Content.id, PageView.payment_status, PageView.uid, SUM(PageView.profit) as user_view_count, if(SUM(PageView.profit) >= 1000, ROUND((SUM(PageView.profit)/1000), 2) *2, 0) as user_revenue"),
//                                'conditions' => array($criteria),
//                                'contain' => array('Content'),
//				'order' => array(
//					'Content.title' => 'DESC'
//				),
//                                'group' => 'PageView.uid, PageView.page_name_id'
//	    );


            $this->loadModel('Custom');
	    if(!isset($this->params['named']['page'])){
		$page	= 1;
	    }else{
		$page	= $this->params['named']['page'];
	    }
	    $this->set(compact('id'));
	    $this->Paginator->settings = array(
			'limit' => 20,
			'extra'	=> array('page' => $page,
			'query' => "select PageView. uid, page_name_id, SUM(PageView.user_revenue) as user_revenue, SUM(PageView.user_view_count) as user_view_count, PageView.title from (select uid, page_name_id, rate, SUM(profit) as user_view_count, (ROUND((SUM(profit)/1000) * rate, 2)) as user_revenue, contents.title from page_views left join contents on contents.id = page_views.page_name_id where page_name_id in (select id from contents where is_deleted = 0) and uid = $user_id GROUP BY page_name_id, rate) as PageView group by PageView.page_name_id"));
	   
	$contents = $this->Paginator->paginate('Custom');
//echo "++++++++++++++++++++++++++++";
//$db =ConnectionManager::getDataSource('default');
//$db->showLog();
//echo "=======================";



//        $this->Paginator->settings = array('fields' => array("User.revenue_percent, Content.title, Content.id, PageView.page_name_id, PageView.payment_status, PageView.uid, PageView.rate, SUM(PageView.profit) as user_view_count, (ROUND((SUM(PageView.profit)/1000) * PageView.rate, 2)) as user_revenue"),
//                                'conditions' => array($criteria),
//                                'joins' => array(
//                                    array('table' => 'users',
//                                        'alias' => 'User',
//                                        'type' => 'LEFT',
//                                        'conditions' => array(
//                                            'User.id = PageView.uid'
//                                        )
//                                    )
//                                ),
//                                'contain' => array('Content'),
//				'order' => array(
//					'Content.title' => 'DESC'
//				),
//                                'group' => 'PageView.uid, PageView.page_name_id, PageView.rate'
//	    );
//        
//        
//        $contents = $this->Paginator->paginate('PageView');
        //$main_content_arr = array();
        //foreach($contents as $content){
        //    $main_content_arr[$content['Content']['id']]['User'] = $content['User'];
        //    $main_content_arr[$content['Content']['id']]['Content'] = $content['Content'];
        //    $main_content_arr[$content['Content']['id']]['PageView'] = $content['PageView'];
        //    $main_content_arr[$content['Content']['id']][0]['user_view_count'] = !empty($main_content_arr[$content['Content']['id']][0]['user_view_count']) ? $main_content_arr[$content['Content']['id']][0]['user_view_count'] + $content[0]['user_view_count'] : $content[0]['user_view_count'];
        //    $main_content_arr[$content['Content']['id']][0]['user_revenue'] = !empty($main_content_arr[$content['Content']['id']][0]['user_revenue']) ? $main_content_arr[$content['Content']['id']][0]['user_revenue'] + $content[0]['user_revenue'] : $content[0]['user_revenue'];
        //}
        
        
        //pr($contents); die;
       // $alphabetArray = array();
       
        //$this->set('getData', $getData);
        $this->set('getData', $contents);
        $this->set('keyword', $value);
        $this->set('user_type_key', $user_type_key);
        $this->set('alphakeyword', $value1);
        $this->set('show', $show);
       // $this->set('alphabetArray', $alphabetArray);
        $this->set('navusers', 'class = "active"');
        $this->set('breadcrumb', 'Revenue');
         
    }
    
    function admin_settings(){
        $this->loadModel('RevenueSetting');
        $this->RevenueSetting->id = 1;
        //pr($revenue_arr); die;
        /* Active/Inactive/Delete functionality */
        if(isset($this->request->data) && !empty($this->request->data)){
            $this->RevenueSetting->saveField('revenue_percent', $this->request->data['RevenueSetting']['revenue_percent']);
            
        }
        $this->request->data = $this->RevenueSetting->findById(1);
        //pr($this->request->data); die;
          
        $this->set('breadcrumb', 'Revenue');
         
    }
    
    function admin_payment($user_id=null,$content_id=null){
        $content_id = base64_decode($content_id);
        $user_id    = base64_decode($user_id);
        $this->loadModel('PageView');
        $this->loadModel('Payment');
        
         $user_revenue_arr = $this->PageView->query("select PageView. uid, SUM(PageView.user_revenue) as user_revenue, SUM(PageView.user_view_count) as user_view_count, PageView.title from (select uid, page_name_id, rate, SUM(profit) as user_view_count, (ROUND((SUM(profit)/1000) * rate, 2)) as user_revenue, contents.title from page_views left join contents on contents.id = page_views.page_name_id where page_name_id = $content_id and uid = $user_id GROUP BY page_name_id, rate) as PageView");
        
        $user_paid_revenue_arr = $this->Payment->find("first", array('fields' => array('SUM(amount) as amount'), 'conditions' => array('user_id' => $user_id, 'content_id' => $content_id)));
        
        //pr($user_revenue_arr); 
        //pr($user_paid_revenue_arr); die;
        $total_amount   = !empty($user_revenue_arr[0][0]['user_revenue']) ? $user_revenue_arr[0][0]['user_revenue'] : 0;
        $paid_amount    = !empty($user_paid_revenue_arr[0]['amount']) ? $user_paid_revenue_arr[0]['amount'] : 0;
        $remainig_balance = $total_amount - $paid_amount;
        //pr($remainig_balance); die;
        $this->set(compact('user_id', 'content_id', 'user_revenue_arr', 'total_amount', 'paid_amount', 'remainig_balance'));
        if(isset($this->request->data) && !empty($this->request->data)){
            $this->request->data['Payment']['user_id']      = base64_decode($this->request->data['Payment']['user_id']);
            $this->request->data['Payment']['content_id']   = base64_decode($this->request->data['Payment']['content_id']);
            $this->request->data['Payment']['amount']       = $remainig_balance;
            $this->request->data['Payment']['order_id']     = time();
            $this->request->data['Payment']['status']       = 1;
            //pr($this->request->data); die;
            $this->Payment->save($this->request->data);    
        }
          
        $this->set('breadcrumb', 'Payment');
         
    }
    
}
