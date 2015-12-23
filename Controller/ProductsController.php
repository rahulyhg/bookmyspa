<?php
class ProductsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form','PhpExcel.PhpExcel','Form','Js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session','Paginator','Common','RequestHandler','Image'); //An array containing the names of components this controller uses.
    public $paginate = array('ProductType' => array('limit' => 5));
    
    /**********************************************************************************    
    @Function Name : admin_index
    @Params	 : NULL
    @Description   : For saving Site theme for the Admin Side
    @Author        : Shibu Kumar
    @Date          : 27-Nov-2014
    ***********************************************************************************/
    public function admin_addProducttype($id=null){
        $this->layout= 'ajax';
         //$id = base64_decode($id);
         $this->loadModel('ProductType');
            $user_id = $this->Auth->user('id');
            if(empty($this->request->data)){
                $this->request->data = $this->ProductType->find('first',array('conditions'=>array('ProductType.id'=>$id)));
            } else if(isset($this->request->data)) {
                $this->ProductType->set($this->request->data);
		if($this->ProductType->validates()){
		    if($id) {
                        $this->ProductType->id  = $id;
			$message = 'Product type has been updated successfully.';
                    } else {
                        $this->ProductType->create();
			$message = 'Product type has been saved successfully.';
                    }
                    if($this->ProductType->save($this->request->data,array('validates'=>false))) {
			$edata['data'] = 'success' ;
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
                    } else {
			$message = 'Product type has not been saved, please try again.';
			$vError = $this->ProductType->validationErrors;
			$edata['data'] = $vError ;
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
		    }
                } else {
		    $message = __('unable_to_save', true);
		    $vError = $this->ProductType->validationErrors;
		    $edata['data'] = $vError ;
		    $edata['message'] = $message;
		    echo json_encode($edata);
		    die;
		}
            }
        $this->set('activeTMenu','productType');
        $this->set('page_title','Product Types');
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
    public function admin_list_producttype(){
	$conditions = array('ProductType.is_deleted'=>"0");
	if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	    
	}
	if(!empty($src_keywrd)){
	   $conditions = array('ProductType.is_deleted'=>"0",
			       'OR'=>array(
				    'ProductType.eng_name LIKE "%'.$src_keywrd.'%"',
				    'ProductType.ara_name LIKE "%'.$src_keywrd.'%"'
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
	
	if(!empty($src_keywrd)){
	   $conditions = array('ProductType.is_deleted'=>"0",
			       'OR'=>array(
				    'ProductType.eng_name LIKE "%'.$src_keywrd.'%"',
				    'ProductType.ara_name LIKE "%'.$src_keywrd.'%"'
				));
	}
	
	/**************** End of set page limit *******************/
	
	$this->params->data['number_records'] = $number_records;
    
        $this->layout   =   'admin_paginator';
        $this->loadModel('ProductType');
	$fields = array('ProductType.id',
			'ProductType.eng_name',
			'ProductType.ara_name',
			'ProductType.status',
			'ProductType.created',
			'ProductType.modified'
		);
	
	$this->Paginator->settings = array(
		'ProductType' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('created' => 'desc')
		)
	    );
	
	$breadcrumb = array(
		'Home'=>array('controller'=>'Products','action'=>'list_producttype','admin'=>true),
		'Product Types'=>'javascript:void(0);'
	    );
        $activeTMenu = 'productType';
        $page_title = 'Product Types';
        
        $this->set(compact('activeTMenu','page_title','breadcrumb'));
	
	
	$productTypes = $this->Paginator->paginate('ProductType');
        $this->set(compact('productTypes'));
        $this->set('activeTMenu','productType');
        $this->set('page_title','Product Types');
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Products";
            $this->render('list_product_types');
            
        }
        
    } 
    
    /**********************************************************************************    
    @Function Name : admin_index
    @Params	 : NULL
    @Description   : For saving Site theme for the Admin Side
    @Author        : Shibu Kumar
    @Date          : 28-Nov-2014
    ***********************************************************************************/
        public function admin_list_brands(){
	    $this->layout   =   'admin';
            $this->loadModel('Brand');
            $brands = $this->Brand->find('all',array('conditions'=>array('is_deleted'=>0)));
            $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Brands'=>'javascript:void(0);',
                        );
	    $this->set(compact('brands','breadcrumb'));
            $this->set('activeTMenu','brand');
            $this->set('page_title','Brand');
            $this->set('leftMenu',true);
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
                $this->viewPath = "Elements/admin/Products";
                $this->render('list_brands');
            }
            
          } 
    
  
  
   /**********************************************************************************    
    @Function Name : admin_index
    @Params	 : NULL
    @Description   : For saving Site theme for the Admin Side
    @Author        : Shibu Kumar
    @Date          : 28-Nov-2014
    ***********************************************************************************/
    
      public function admin_add_brand($id=null){
	    $this->layout= 'ajax';
            $this->loadModel('Brand');
            $this->loadModel('BrandtoProductType');
            $this->loadModel('ProductType');
            $user_id = $this->Auth->user('id');
            if(empty($this->request->data)){
                $this->request->data = $this->Brand->find('first',array('conditions'=>array('Brand.id'=>$id)));
                $getProductTypes = $this->request->data;
                $getProductType =array();
                if(!empty($getProductTypes)){
                    foreach($getProductTypes['BrandtoProductType'] as $productType){
                        $getProductType[$productType['id']] = $productType['product_type_id'];
                    }
                 }
                $this->set(compact('getProductType'));
		}else if(isset($this->request->data)) {
		   // echo '<pre>'; print_r($this->request->data); die;
		    $this->request->data['Brand']['user_id'] = $user_id;
		    $this->request->data['Brand']['group_id'] = $this->Auth->user('group_id');
		    $this->Brand->set($this->request->data);
		 
                 if($this->Brand->validates()){
                        if($id){
                            $this->request->data['Brand']['id']  = $id;
                            $this->BrandtoProductType->deleteAll(array('BrandtoProductType.brand_id' => $id), false);
                        }else{
                            $this->Brand->create();
                        }
                    if($this->Brand->saveAll($this->request->data,array('validates'=>false))){
			$edata['data'] = 'success' ;
			$edata['message'] = __('page_save_success',true);
			echo json_encode($edata);
			die;
                     }else{
			$message = __('unable_to_save', true);
			$vError = $this->Brand->validationErrors;
			
			$edata['data'] = $vError ;
			
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
		    }
                 }else{
		        $message = __('unable_to_save', true);
			$vError = $this->Brand->validationErrors;
			//$vError['BrandtoProductType'][1]['product_type_id']=array('enter');
			//echo '<pre>'; print_r($vError); die;
			$edata['data'] = $vError ;
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
		 }
            }
        $productTypes = $this->ProductType->find('list',array('fields'=>array('id','eng_name'),'conditions'=>array('ProductType.status'=>1,'ProductType.is_deleted'=>0)));
        $this->set(compact('productTypes'));
        $this->set('activeTMenu','Brand');
        $this->set('page_title','Brand');
        $this->set('leftMenu',true);
      }
  
  
    /**********************************************************************************    
      @Function Name : admin_producttypechangeStatus
      @Params	 : NULL
      @Description   : Change Status via Ajax
      @Author        : Shibu Kumar
      @Date          : 27-Nov-2014
    ***********************************************************************************/    
        public function admin_producttypechangeStatus() {
            $this->autoRender = false;
            $this->loadModel('ProductType');
            if($this->request->is('post')){
                if($this->ProductType->updateAll(array('ProductType.status'=>$this->request->data['status']),array('ProductType.id'=>$this->request->data['id']))){
                    return $this->request->data['status'];
                }
            }
            
        }
        
        /**********************************************************************************    
      @Function Name : admin_brandchangeStatus
      @Params	 : NULL
      @Description   : Change Status via Ajax
      @Author        : Shibu Kumar
      @Date          : 27-Nov-2014
    ***********************************************************************************/    
        public function admin_brandchangeStatus() {
            $this->autoRender = false;
            $this->loadModel('Brand');
            
            if($this->request->is('post')){
                if($this->Brand->updateAll(array('Brand.status'=>$this->request->data['status']),array('Brand.id'=>$this->request->data['id']))){
                    return $this->request->data['status'];
                }
            }
            
        }
        
          /**********************************************************************************    
            @Function Name : admin_viewProducttype
            @Params	 : $id = Prodyt Type Id
            @Description   : View of Product Type
            @Author        : Shibu Kumar
            @Date          : 28-Nov-2014
          ***********************************************************************************/    
              public function admin_viewProducttype($id=null) {
                  $this->layout = "ajax";
                  $this->loadModel('ProductType');
                  if($id){
                     $page = $this->ProductType->findById($id);
                     $this->set(compact('page'));
                  }
                  else{
                      $this->Session->setFlash(__('page_not_found',true),'flash_error');
                      $this->redirect(array('controller'=>'Products','action'=>'list_producttype','admin'=>true));
                  }
              }
           /**********************************************************************************    
        @Function Name : admin_deleteProducttype
        @Description   : Delete of Product Type
        @Author        : Shibu Kumar
        @Date          : 27-Nov-2014
      ***********************************************************************************/
    
    public function admin_deleteProducttype() {
        $this->autoRender = "false";
        $this->loadModel('ProductType');
	$this->loadModel('BrandtoProductType');
	if($this->request->is('post') || $this->request->is('put')){
	    $id = $this->request->data['id']; 
	    $page = $this->ProductType->findById($id);
	    
	   if(!empty($page)){
                if($this->ProductType->updateAll(array('ProductType.is_deleted'=>1),array('ProductType.id'=>$id))){
		    $this->BrandtoProductType->deleteAll(array('BrandtoProductType.product_type_id' => $id), false);
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
    
      /**********************************************************************************    
        @Function Name : admin_deleteBrand
        @Description   : Delete of Brands
        @Author        : Shibu Kumar
        @Date          : 28-Nov-2014
      ***********************************************************************************/
    
    public function admin_deleteBrand(){
        $this->autoRender = "false";
        $this->loadModel('Brand');
	  if($this->request->is('post') || $this->request->is('put')){
	    $id = $this->request->data['id']; 
	    $page = $this->Brand->findById($id);
            if(!empty($page)){
                if($this->Brand->updateAll(array('Brand.is_deleted'=>1),array('Brand.id'=>$id))){
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
      public function test() {
        
        //Please Enter Your Details
            //$user="sieasta"; //your username
            //$password="ham@123"; //your password
            $user="smartyTest"; //your username
            $password="37566849"; //your password
            $mobilenumbers="919988956060"; //enter Mobile numbers comma seperated
            $message = "hello man"; //enter Your Message
            $senderid="SMSCntry"; //Your senderid
            $messagetype="N"; //Type Of Your Message
            $DReports="Y"; //Delivery Reports
            $url="https://www.smscountry.com/SMSCwebservice_Bulk.aspx";
            $message = urlencode($message);
            $ch = curl_init();
            //echo $url = "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports";
            if (!$ch){die("Couldn't initialize a cURL handle");}
            $ret = curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt ($ch, CURLOPT_POSTFIELDS,
            "User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
            $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //If you are behind proxy then please uncomment below line and provide your proxy ip with port.
            //$ret = curl_setopt($ch, CURLOPT_PROXY, "http://192.155.246.146:8155");
            $curlresponse = curl_exec($ch); // execute
            if(curl_errno($ch))
            echo 'curl error : '. curl_error($ch);
            if (empty($ret)) {
            // some kind of an error happened
            die(curl_error($ch));
            curl_close($ch); // close cURL handler
            } else {
            $info = curl_getinfo($ch);
            curl_close($ch); // close cURL handler
            //echo " ";
            echo $curlresponse; //echo "Message Sent Succesfully" ;
            exit;
      }
      }
      
     
      
      
        /**********************************************************************************    
        @Function Name : admin_add_vendor
        @Description   : add vendor
        @Author        : Sanjeev kanungo
        @Date          : 4-dec-2014
      ***********************************************************************************/
      
      function admin_add_vendor($id=NULL){
		if(!$this->request->is(array('ajax'))){
		    $this->redirect('/');   
		}
		$this->layout = 'ajax';
		$this->loadModel('Vendor');
			if($id){
			$vendor = $this->Vendor->find('first',array(
				'conditions' => array(
					'Vendor.id'=>$id ,
					'Vendor.is_deleted'=>0
				))
			);
			}
		    if($this->request->is(array('put','post'))){
			 $userId = $this->Auth->user('id');
			 $this->request->data['Vendor']['user_id']  =$userId;
			 if(!empty($id)){
				$this->Vendor->id = $id;
			 }
			//!empty($id)?$this->Vendor->id=$id:$this->Vendor->create();
			
			 if($this->Vendor->save($this->request->data)){
				 $edata['data'] = 'success';
				 $edata['message'] = __('page_save_success',true);
				 echo json_encode($edata);
				 die; 
			  }else{
				 $message = __('unable_to_save', true);
				 $vError = $this->Vendor->validationErrors;
				 $edata['data'] = $vError;
				 $edata['message'] = $message;
				 echo json_encode($edata);
				 die;
			 }
		    }
		  if(!$this->request->data && isset($vendor)){
		   //echo '<pre>'; print_r($vendor); //die;
                   $this->request->data = $vendor;
                   $this->set(compact('vendor'));
               }
	    $countryData =  $this->Common->getCountries();
	    $this->set(compact('countryData'));
      }
       /**********************************************************************************    
        @Function Name : admin_vendors
        @Description   : Vendors listings
        @Author        : Sanjeev kanungo
        @Date          : 5-dec-2014
      ***********************************************************************************/
      
      
      function admin_vendors(){
	    $this->loadModel('Vendor');
	     $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Vendors'=>array('controller'=>'Products','action'=>'vendors','admin'=>true),
                        );
	    $this->set('breadcrumb',$breadcrumb);
	    
	    $group_id = $this->Auth->user('group_id');
	    if(!$this->is_vendor($group_id)){
		$this->redirect(array('action'=>'index','controller'=>'dashboard'));
	    }
	    $userId = $this->Auth->user('id');
	    $all_vendors = $this->Vendor->find('all',array('conditions'=>array('Vendor.user_id'=>$userId ,'Vendor.is_deleted'=>0)));
	    //pr($all_vendors); die;
	    $this->set('all_vendors' ,$all_vendors);
	    if($this->request->is('ajax')){
		 $this->layout = 'ajax';
		  $view = new View($this, false);
                 echo  $content = $view->element('admin/Products/vendors', $all_vendors);
		 die;
	    }
	    $this->set('activeTMenu','productType');
	    $this->set('page_title','Manage Vendor');
	    $this->set('leftMenu',true);
	    $this->layout = 'admin';
      }
      
       /**********************************************************************************    
        @Function Name : is_vendor
        @Description   : Check for user type 
        @Author        : Sanjeev kanungo
        @Date          : 5-dec-2014
      ***********************************************************************************/
      
      function is_vendor($group_id = null){
	if(in_array($group_id , array('2','3','4'))){
	  return true;  
	}else{
	 return false;   
	}
      }
      
       /**********************************************************************************    
        @Function Name : admin_delete_vendor
        @Description   : delete vendor
        @Author        : Sanjeev kanungo
        @Date          : 5-dec-2014
      ***********************************************************************************/
      
      function admin_delete_vendor($id=NULL){
	if(!$this->request->is(array('ajax'))){
	    $this->redirect('/');   
	}
	$this->autoRender = false;
	$this->loadModel('Vendor');
	    if($this->Vendor->updateAll(array('Vendor.is_deleted'=>1), array('Vendor.id'=>$id))){
		return true;
	     }else{
		$this->redirect(array('controller'=>'dashboard','action'=>'index','admin'=>true));
	     }
	}
	
	 /**********************************************************************************    
        @Function Name : admin_export_vendor
        @Description   : export xls file
        @Author        : Sanjeev kanungo
        @Date          : 5-dec-2014
      ***********************************************************************************/
	function admin_export_vendor(){
	    $this->layout  =false;
	    $this->loadModel('Vendor');
	    $userId = $this->Auth->user('id');
	    $all_vendors = $this->Vendor->find('all',array('conditions'=>array('Vendor.user_id'=>$userId ,'Vendor.is_deleted'=>0)));
	    $this->set('all_vendors',$all_vendors);
	}
	
       /**********************************************************************************    
        @Function Name : admin_print_vendor
        @Description   : print the vendors list
        @Author        : Sanjeev kanungo
        @Date          : 5-dec-2014
      ***********************************************************************************/
	
	function admin_print_vendor(){
	    $this->layout  =false;
	    $this->loadModel('Vendor');
	    $userId = $this->Auth->user('id');
	    $all_vendors = $this->Vendor->find('all',array('conditions'=>array('Vendor.user_id'=>$userId ,'Vendor.is_deleted'=>0)));
	    $this->set('all_vendors',$all_vendors);   
	}
	
	
	function admin_brand_list(){
	 $this->autoRender = false;
	 $this->loadModel('Brand');
	 $this->Brand->recursive  = -1;
	 $brands = $this->Brand->find('list' , array('conditions'=>array('status'=>1,'is_deleted'=>0,'or'=>array('group_id'=>1,'user_id'=>$this->Auth->user('id'))),'fields'=>array('id','eng_name')));
	 $view = new View($this);
         $this->Form = $view->loadHelper('Form');
	 $list = $this->Form->input('brand_id',  array('name'=>'data[Product][brand_id]','label'=>false,'div'=>false,'options' =>$brands,'class'=>'form-control','onChange'=>'product_list(this)','empty'=>'Please select','required','validationMessage'=>"Please select Brand Name."));
	 
	 //$this->Form->input('brand_id',  array('name'=>'data[Product][brand_id]','label'=>false,'options' =>$brands,'selected' => '','onChange'=>'product_list(this)','empty'=>array(0=>'please select')));
	 echo $list;
	}
	
	function admin_brand_products($id=NULL,$product_type_id=null ){
	 $this->layout = 'false';
	 $this->autoRender = false;
	 $this->loadModel('BrandtoProductType');
	 $this->loadModel('ProductType');
	 $products = $this->BrandtoProductType->find('list',array('conditions'=>array('brand_id'=>$id),'fields'=>array('product_type_id')));
	 $product_types = $this->ProductType->find('list' , array('conditions'=>array('ProductType.id'=>$products ,'ProductType.status'=>1 ,'ProductType.is_deleted'=>0), 'fields'=>array('ProductType.id','ProductType.eng_name')));
	 $view = new View($this);
         $this->Form = $view->loadHelper('Form');
	 $list =  $this->Form->input('product_type_id',  array('name'=>'data[Product][product_type_id]','class'=>'form-control','label'=>false,'div'=>false,'options' =>$product_types,'selected' =>$product_type_id,'required','validationMessage'=>"Please select Product Type.",'empty'=>'Please Select') );  
	 echo $list;
	}
	
	function admin_tax_setting(){
	 $group_id = $this->Auth->user('group_id');
	 $user_id = $this->Auth->user('id');
	 $this->is_vendor($group_id);
	 $this->layout = 'admin';
	 $this->loadModel('TaxCheckout');
	 $this->set('activeTMenu','taxSettings');
	 $this->set('page_title','Taxes & Checkout');
	 $this->set('leftMenu',true);
         $breadcrumb = array(
                            'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                            'Taxes & Checkouts'=>'javascript:void(0)',
                            );
         $this->set('breadcrumb',$breadcrumb);
	 $taxDetail = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$user_id)));
	 $this->set('taxDetail',$taxDetail);
	 if($this->request->is(array('put','post'))){
	    $this->request->data['TaxCheckout']['user_id'] = $user_id;
	    if(@$taxDetail['TaxCheckout']['id']){
		$this->TaxCheckout->id = $taxDetail['TaxCheckout']['id'];
	    }else{
		$this->TaxCheckout->create();
	    }
	    if($this->TaxCheckout->save($this->request->data)){
		$this->Session->setFlash('Tax & Checkout settings saved successfully!!','flash_success');
	    }else{
		$this->Session->setFlash('Error in saving the Tax & Checkout settings!!','flash_error');
	    }
	 }
	 if(!$this->request->data && isset($taxDetail)){
                    $this->request->data = $taxDetail;
                }
	}
	
    
	/**********************************************************************************    
	@Function Name : admin_add_product
	@Description   : Vendor add product
	@Author        : Sanjeev kanungo
	@Date          : 5-dec-2014
       ***********************************************************************************/
      
      function admin_add_product($id=null){
	$product = array();
	$this->layout ='admin';
	$this->set('activeTMenu','productType');
        $this->set('page_title',(($id)?'Edit':'Add').'&nbsp;Product');
	$this->loadModel('Product');
	$this->loadModel('Vendor');
	$this->loadModel('TaxCheckout');
	$this->loadModel('Brand');
	$user_id = $this->Auth->user('id');
	$this->Brand->recursive  = -1;
	$brands = $this->Brand->find('list' , array('conditions'=>array('status'=>1,'is_deleted'=>0,'or'=>array('group_id'=>1,'user_id'=>$this->Auth->user('id'))),'fields'=>array('id','eng_name')));
	$vendors = $this->Vendor->find('list' , array('conditions'=>array('Vendor.user_id'=>$this->Auth->user('id'),'Vendor.is_deleted'=>0),'fields'=>array('id','eng_business_name')));
	$taxes = $this->TaxCheckout->find('first', array('conditions'=>array('user_id' , $user_id),'fields'=>array('tax1','tax2')));
	$deductions = $this->TaxCheckout->find('first', array('conditions'=>array('user_id' , $user_id),'fields'=>array('deduction1','deduction2')));
	$this->set(compact('vendors' ,'taxes','brands','deductions'));
	$product = array();
	if($id){
	    $id = base64_decode($id);
	    $validator = $this->Product->validator();
		unset($validator['barcode']['isUnique']);
		$product = $this->Product->findById($id);
	    $this->set(compact('product'));
	}
	if($this->request->is(array('put','post'))){
	    //echo '<pre>'; print_r($this->request->data);  die;
	    $this->Product->set($this->request->data);
		if ($this->Product->validates()){
			$this->request->data['Product']['user_id'] = $user_id;
		    if($id){
		     $this->Product->id = $id;
		    }else{
		     $this->Product->create();
		    }
		        $this->Product->save($this->request->data);
		        $product_id = ($id)?$id:$this->Product->getLastInsertID();
			if(count(@$this->request->data['Product']['image'])){
			    $this->loadModel('ProductImage');
			    $image_data = array();
			    foreach($this->request->data['Product']['image'] as $image){
				if(!empty($image['name'])){
				    $model = "ProductImage";
				    $retrun = $this->Image->upload_image($image,$model,$user_id);
				    $image_data['ProductImage']['image'] =  $retrun;
				    $image_data['ProductImage']['product_id'] =  $product_id;
				    if($retrun){
				     $this->ProductImage->create();
				     $this->ProductImage->save($image_data);  
				    }
				}
			    }
			}
			    $this->Session->setFlash('Product has been saved successfully','flash_success');
			    $this->redirect(array('controller'=>'Products','action'=>'inventory_management','admin'=>true));
				    
	    } else {
		$this->Session->setFlash('Some Error occurred!','flash_error');
	    }
	}
	$breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Products'=>array('controller'=>'Products','action'=>'inventory_management','admin'=>true),
                        'Add Product'=>array('javascript:void(0)')
			);
	$this->set('breadcrumb',$breadcrumb);
	if($product and (!$this->request->data)){
	    $this->request->data = $product;
	}
      }
	
	 /**********************************************************************************    
        @Function Name : admin_inventory_management
        @Description   : Manage inventory products
        @Author        : Sanjeev kanungo
        @Date          : 3-dec-2014
      ***********************************************************************************/
      
      function admin_inventory_management($type=NULL){
	 $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Products'=>array('controller'=>'Products','action'=>'inventory_management','admin'=>true),
                        );
	$this->set('breadcrumb',$breadcrumb);
	$this->set('activeTMenu','productType');
        $this->set('page_title','All Products');
	$userId = $this->Auth->user('id');
	$this->loadModel('TaxCheckout');
	$this->Product->recursive = 1;
	$this->Product->bindModel(array('belongsTo'=>array(
		'Brand'=>array(
			    'className'=>'Brand',
			    'foreignKey'=>'brand_id',
			    'recursive'=>3
			    ),
		'ProductType'=>array(
			     'className'=>'ProductType',
			     'foreignKey'=>'product_type_id',
			     )
		    ),
		)				
	);
        $allProducts  = $this->Product->find('all',array('conditions'=>array('Product.user_id'=>$userId,'Product.is_deleted'=>0),'fields'=>array('Product.*', 'Brand.eng_name','Brand.ara_name','ProductType.eng_name','ProductType.ara_name'),'order'=>'Product.id DESC'));
	$tax = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$userId)));
	$this->set(compact('allProducts','tax'));
	if($this->request->is(array('ajax'))){
	    $this->layout ='ajax';
	    $this->render('/Elements/admin/Products/inventory_management');
	    }else if($type=='print'){
		$this->layout = false;
		$this->render('/Products/admin_print_product');
	    }else if($type=='excel'){
		$this->autoRender = false;
		$this->render('/Products/admin_export_product');
	    }else{
		$this->layout ='admin';
	    }
      }
	
	/**********************************************************************************    
        @Function Name : admin_add_qty
        @Description   : Add product qty
        @Author        : Sanjeev kanungo
        @Date          : 16-dec-2014
      ***********************************************************************************/
	
	
	function admin_add_qty($id=NULL){
	   $this->layout = 'ajax';
	   $this->loadModel('Product');
	   $this->loadModel('ProductHistory');
	   $this->loadModel('TaxCheckout');
	   $this->loadModel('Vendor');
	   $userId = $this->Auth->user('id');
	   $tax_rate='';
	   $this->Product->recursive = -1;
	   $product  = $this->Product->find('first', array('conditions'=>array('Product.id'=>$id)));
	   if($this->request->is(array('put','post'))){
		$tax = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$userId)));
		if($product['Product']['tax']){
			foreach($tax['TaxCheckout'] as $k=>$v){
			  if($k==$product['Product']['tax']){
			      $tax_rate = ($v)?$v.'%':'0.000%';	
			  }	
			}
		}else{
		     $tax_rate = 'No Tax';
		}
	        $vendor = $this->Vendor->find('first' , array('conditions'=>array('Vendor.id'=>$product['Product']['vendor']),'fields'=>array('eng_business_name')));
		

	    $qty = $this->request->data['Product']['quantity'];
	    if($qty){
		    $quantity = intval($qty)+ intval($product['Product']['quantity']);
		    $data['Product']['quantity'] = $quantity; 
		    $this->Product->id = $product['Product']['id'];
		    if($this->Product->saveField('quantity' , $quantity)){
			$product_history['ProductHistory']['cost'] = $product['Product']['cost_business'];
			$product_history['ProductHistory']['selling_price'] = $product['Product']['selling_price'];
			$product_history['ProductHistory']['points_given'] = $product['Product']['points_given'];
			$product_history['ProductHistory']['points_Redeem'] = $product['Product']['points_Redeem'];
			$product_history['ProductHistory']['vendor'] = $vendor['Vendor']['eng_business_name'];
			$product_history['ProductHistory']['tax'] = $tax_rate;
			$product_history['ProductHistory']['type'] = 'Quantity Added';
			$product_history['ProductHistory']['date'] = date('Y-m-d');
			$product_history['ProductHistory']['qty'] = $qty;
			$product_history['ProductHistory']['reason'] = '---';
			$product_history['ProductHistory']['product_id'] =$product['Product']['id'];
			if($this->ProductHistory->save($product_history)){
			    $edata['data'] = 'success' ;
			    $edata['message'] = __('page_save_success',true);
			    echo json_encode($edata);
			    die;
			}
		    }else{
			$message = __('unable_to_save', true);
			$vError = $this->Product->validationErrors;
			$edata['data'] = $vError ;
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
		    }
	    }else{
		$message = __('Quantity cannot be empty', true);
		$vError['Product']['quantity'][] = 'Quantity is required';
		$edata['data'] = $vError ;
		$edata['message'] = $message;
		echo json_encode($edata);
		die;
	    }
	   }
	   $this->set(compact('product')); 
	}
	
	/**********************************************************************************    
        @Function Name : admin_subtract_qty
        @Description   : subtract product qty
        @Author        : Sanjeev kanungo
        @Date          : 16-dec-2014
	***********************************************************************************/
	
	
	function admin_subtract_qty($id=NULL){
	   $this->layout = 'ajax';
	   $this->loadModel('Product');
	   $this->loadModel('ProductHistory');
	   $this->loadModel('TaxCheckout');
	   $userId = $this->Auth->user('id');
	   $tax_rate='';
	   $this->Product->recursive = -1;
	   $product  = $this->Product->find('first', array('conditions'=>array('Product.id'=>$id)));
	   
	   if($this->request->is(array('put','post'))){
		    $product  = $this->Product->find('first', array('conditions'=>array('Product.id'=>$this->request->data['Product']['id'])));
		    
		    if($product['Product']['tax']){
		        $tax = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$userId)));
			foreach($tax['TaxCheckout'] as $k=>$v){
			  if($k==$product['Product']['tax']){
			      $tax_rate = ($v)?$v.'%':'0.000%';	
			  }	
			}
		    }else{
			 $tax_rate = 'No Tax';
		    }
		    $subtract_qty = $this->request->data['Product']['sub_quantity'];
		    $quantity = intval($product['Product']['quantity'])-intval($subtract_qty);
		    $data['Product']['quantity'] = $quantity; 
		    $this->Product->id = $product['Product']['id'];
		    if($this->Product->saveField('quantity' , $quantity)){
			$this->request->data['ProductHistory']['cost'] = $product['Product']['cost_business'];
			$this->request->data['ProductHistory']['selling_price'] = $product['Product']['selling_price'];
			$this->request->data['ProductHistory']['points_given'] = $product['Product']['points_given'];
			$this->request->data['ProductHistory']['points_Redeem'] = $product['Product']['points_Redeem'];
			$this->request->data['ProductHistory']['tax'] = $tax_rate;
			$this->request->data['ProductHistory']['qty'] = $subtract_qty;
			$this->request->data['ProductHistory']['product_id'] = $product['Product']['id'];
			if($this->ProductHistory->save($this->request->data)){
			    $edata['data'] = 'success';
			    $edata['message'] = __('page_save_success',true);
			    echo json_encode($edata);
			    die;
			}else{
			    $message = __('unable_to_save', true);
			    $vError = $this->ProductHistory->validationErrors;
			    $edata['data'] = $vError ;
			    $edata['message'] = $message;
			    echo json_encode($edata);
			    die;  
			}
		    }else{
			$message = __('unable_to_save', true);
			$vError = $this->Product->validationErrors;
			$edata['data'] = $vError ;
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
		    }
	   }
	   $this->set(compact('product'));
	   if(!$this->request->data){
		$this->request->data = $product;
	   }
	}
	
	public function admin_product_delete($id=null){
	    if(!$this->request->is(array('ajax'))){
		$this->redirect('/');   
	    }
	    $this->autoRender = false;
	    $this->loadModel('Product');
		if($this->Product->updateAll(array('Product.is_deleted'=>1), array('Product.id'=>$id))){
		    return true;
		 }else{
		    return false;
		 }
	}
	/**********************************************************************************    
        @Function Name : admin_delete_image
        @Description   : delete product images
        @Author        : Sanjeev kanungo
        @Date          : 18-dec-2014
	***********************************************************************************/
	
	
	function admin_delete_image(){
	  $this->autoRender =false;
	  $this->loadModel('ProductImage');
	  $modal = 'ProductImage';
	  if($this->ProductImage->delete($this->request->data['id'])){
		$this->Image->delete_image($this->request->data['image'],$modal,$this->Auth->user('id'));
		return true;
	    }else{
		return false;   
	    }
	}
	
	/**********************************************************************************    
        @Function Name : admin_product_history
        @Description   : product history 
        @Author        : Sanjeev kanungo
        @Date          : 19-dec-2014
	***********************************************************************************/
	
	function admin_product_history($id=NULL ,$type=NULL){
            $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Products' => array('controller' => 'Products', 'action' => 'inventory_management', 'admin' => true),
            'Product History' => array('javascript:void(0)'),
        );
        $this->set('breadcrumb', $breadcrumb);
        $this->set('activeTMenu', 'productType');
        $this->set('page_title', 'Product History');
        $this->Product->unbindModel(array("hasMany" => array('ProductImage')), false);
        $this->Product->bindModel(array(
            'hasMany' => array(
                'ProductHistory' => array(
                    'className' => 'ProductHistory'
                )
            )
        ));
        $data = $this->Product->findById(base64_decode($id));
        $this->set('products', $data);
        if ($type == 'excel') {
            $this->render('/Products/admin_excel_product_history');
            $this->layout = false;
        } else if ($type == 'print') {
            $this->layout = 'ajax';
            $this->render('/Products/admin_print_product_history');
        } else {
            $this->layout = 'admin';
        }
    }
    
    public function admin_getProduct() {
	$product['message'] = 'Unable to find the Product';
	$product['data'] = array();
	if($this->request->is('post') || $this->request->is('put')){
	    $productData = $this->Product->find('first',array('conditions'=>array('Product.user_id'=>$this->Auth->user('id'),'Product.barcode'=>$this->request->data['barcode'])));
	    if(!empty($productData)){
		$product['message'] = 'success';
	    }
	    $product['data'] = $productData;
	}
	echo json_encode($product);
	die;
    }
    
    /**********************************************************************************    
    @Function Name : admin_view_brand
    @Description   : for view of brand in popup
    @Author        : Aman Gupta
    @Date          : 28-March-2014
    ***********************************************************************************/
    public function admin_view_brand($id=NULL) {
	$this->layout   =   'ajax';
        $this->loadModel('Brand');
	$brand = array();
	if($id){
	    $this->Brand->recursive = 2;
	    $brand  = $this->Brand->findById($id);
	}
	$this->set(compact('brand'));
    }

}