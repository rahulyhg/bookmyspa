<?php
    /*
        * co Controller class
        * Functionality -  Manage the Companies Management
        * Developer -Navdeep kaur
        * Created date - 12-Feb-2014
        * Modified date - 
    */
    class CompaniesController extends AppController {
        var $name = 'Companies';
        
        public $components = array('Paginator','Image','Common','Email');        
        
        function beforeFilter(){
            parent::beforeFilter();    
            
        }
        /*
            * admin_index function
            * Functionality -  Companies Listing
            * Developer -Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */
        function admin_index()
        {
			$this->loadModel('CompanySubscription');
                        /* Active/Inactive/Delete functionality */
			if((isset($this->data["Company"]["setStatus"])))
			{
				if(!empty($this->request->data['Company']['status'])){
					$status = $this->request->data['Company']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'index'));
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='Company';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */			
			$value ="";
			$value1= "";
			$show ="";
            $account_type ="";
			$criteria='Company.is_deleted =0'; 

			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					//OR Admin.first_name LIKE '%".$value."%' OR Admin.last_name LIKE '%".$value."%' OR Admin.email LIKE '%".$value."%'
					if($value !="") {
						$criteria .= " AND (Company.name LIKE '%".$value."%'  OR Company.address LIKE '%".$value."%' )";						
					}
					if(!empty($this->params->query['alphabet_letter'])){
						$value1 = trim($this->params->query['alphabet_letter']);	
					}
					if($value1 !="") {
						$criteria .= " AND (Company.name LIKE '".$value1."%')";						
					}
			}
			//$this->Company->Behaviors->attach('Containable');
			$this->Company->bindModel(array('hasOne'=>array('Admin'=>array('conditions'=>array('Admin.admin_role_id'=>2)))));
			//$this->CompanySubscription->bindModel(array('belongsTo'=>array('Subscription')));
                        $this->Paginator->settings = array('conditions' => array($criteria),
				'limit' =>10,
				'order' => array(
					'Company.id' => 'DESC'
				)
            );
			$alphabetArray = array();
		//	$alphabetArray['0-9'] = '0-9';		
			for($i = 65 ; $i<=90; $i++)
			{
				$alphabetArray[chr($i)] = chr($i);
			}
		
			$this->set('getData',$this->Paginator->paginate('Company'));
			$this->set('keyword', $value);
			$this->set('alphakeyword', $value1);
			$this->set('show', $show);
			$this->set('alphabetArray',$alphabetArray);
			$this->set('navusers','class = "active"');			
			$this->set('breadcrumb','Companies');			
        }
        /*
            * admin_add function
            * Functionality -  Add & edit the Companys
            * Developer -Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */
        function admin_add($id = null)
        {
			$this->loadModel('Subscription');
			$this->loadModel('Admin');
			$this->loadModel('CompanySubscription');
			$this->Company->bindModel(array('hasOne'=>array('CompanySubscription','Admin')));
            if(empty($this->request->data)){				
					$this->request->data = $this->Company->read(null, base64_decode($id));
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{ 
				$this->request->data	['Company']['id'] = base64_decode($this->request->data['Company']['id']);
				$this->request->data['Admin']['id'] = base64_decode($this->request->data['Admin']['id']);				
				$data['CompanySubscription']['id'] = base64_decode($this->request->data['CompanySubscription']['id']);
				$passwrd= $this->request->data['Admin']['password'];
				$this->request->data['Admin']['password'] = md5($this->request->data['Admin']['password']);	
//pr($this->request->data); die;
				
				// Variable declaration
					$flag_company = false;
					$flag_admin = false;
					
					$this->Company->set($this->request->data);
					if($this->Company->validates()){
						$flag_company = true;
					}
					
					$this->Admin->set($this->request->data);
					if($this->Admin->validates()){
						$flag_admin = true;
					}
				
				
				if($flag_company && $flag_admin) 				
				{
                    if($this->request->data['Company']['id'] != ""){
                        $msz = "Company Information has been updated sucessfully";
						$sendEmail =1 ;
                    }else{
                        $msz = "Company Information has been added sucessfully";
						$sendEmail = 2 ;
                    }
                /*****************image upload*****************/
                    if(!empty($this->request->data['Company']['logo']['name'])){
                        
                    
                        if(isset($this->request->data['Company']['logo']['name']) && $this->request->data['Company']['logo']['name'] != ""){
                        // Variable declaration
                            $file = $this->request->data['Company']['logo'];
                            $path = 'img/logo';					
                            $folder_name = 'original';
                            $multiple[] = array('folder_name'=>'thumb','height'=>'100','width'=>'100'); 
                            
                            // Code to upload the image
                            $response = $this->Common->upload_image($file, $path, $folder_name, true, $multiple);
                            
                            // check if filename return or error return
                            $is_image_error = $this->Common->is_image_error($response);
                            
                            if($response == 'exist_error'){
                                $this->Session->setFlash($is_image_error,'error');
                            }elseif($response == 'size_mb_error'){
                                $this->Session->setFlash($is_image_error,'error');
                            }elseif($response == 'type_error'){
                                $this->Session->setFlash($is_image_error,'error');
                            }else{							
                            
                                $flag = true;
                                $filename = $response;
                                $this->request->data['Company']['logo'] = $filename;
                            
                            }
                            //DElete Old Pic
                            $oldImg = 'logo/thumb/'.$this->request->data['Company']['old_pic'];                
                            if(file_exists(WWW_ROOT.'/img/'.$oldImg))
                            {				
                                unlink(WWW_ROOT.'/img/items/original/'.$oldImg);
                            }
                            
                        } 
                         
                    }else{
                        $this->request->data['Company']['logo'] = $this->request->data['Company']['old_pic'];
                    }
			// SEt Role for contact persom
					$this->request->data['Admin']['admin_role_id']  = 2;
					
					if($this->Company->save($this->request->data))
					{
						$companyId =  $this->Company->id;
						$this->request->data['Admin']['status']  = 1;
						$this->request->data['Admin']['company_id'] = $companyId;
						$this->Admin->save($this->request->data);
						$data['CompanySubscription']['company_id'] = $companyId;
						$data['CompanySubscription']['subscription_id'] = $this->request->data['CompanySubscription']['subscription_id'];
						$this->CompanySubscription->save($data['CompanySubscription']);
						if($sendEmail == 2){
						//Get Subscription plan Name
						$subscriptionName = $this->Subscription->find('first',array('conditions'=>array('Subscription.id'=>$this->request->data['CompanySubscription']['subscription_id']),'fields'=>array('name')));
						//Email functionality to send mail to company Owner
						App::import('Model','Emailtemplate');
						$this->Emailtemplate = new Emailtemplate;
						$SITE_URL = Configure::read('BASE_URL');
						
						$active =  '<a href = "' .$SITE_URL. '/admin/admins/login">Link </a>'; 
						$template = $this->Emailtemplate->getEmailTemplate('welcome_company');
						$to = $this->request->data['Admin']['email'];
						$data1 = $template['Emailtemplate']['template'];					
						
						$data1 = str_replace('{FirstName}',ucfirst($this->request->data['Admin']['first_name']),$data1);
						$data1 = str_replace('{Company}',ucfirst($this->request->data['Company']['name']),$data1);
						$data1 = str_replace('{Email}',$this->request->data['Admin']['email'],$data1);
						$data1 = str_replace('{Password}',$passwrd,$data1);
						$data1 = str_replace('{SubscriptionPlan}',$subscriptionName['Subscription']['name'],$data1);
						$data1 = str_replace('{Link}',$active,$data1);
						$subject = ucfirst(str_replace('_', ' ', $template['Emailtemplate']['name']));
						
						$send_mail = $this->sendEmail($to,$subject,$data1);  
						}
                        $this->Session->setFlash($msz,'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'index'));
					}
				}   else{
					$this->request->data['Company']['logo'] = "";
					} 
			}
			// Calling arrays
			$this->getSubscriptions();
			$textAction = ($id == null) ? 'Add' : 'Edit';			
			$this->set('navusers','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Companies/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';
			// Calling arrays
			$this->getCountries();
			$this->set('buttonText',$buttonText);
			
        }
		/*
            * admin_view function
            * Functionality -  company detail view
            * Developer -Navdeep kaur
            * Created date - 23-may-2014
            * Modified date - 
        */
        function admin_view($id = null)
        {
			$this->loadModel('CompanySubscription');
            $getData =  array();
            if(!empty($id))
            {
				$this->Company->Behaviors->attach('Containable');
				$this->Company->bindModel(array('hasOne'=>array('CompanySubscription','Admin')));
				$this->CompanySubscription->bindModel(array('belongsTo'=>array('Subscription')));
				
                $conditions = "Company.id = ".base64_decode($id);	
                $getData = $this->Company->find('first',array('conditions' => array($conditions),'contain' => array('Admin'=>array('fields'=>array('first_name','last_name','email','phone')),'Country','State','CompanySubscription'=>array('fields'=>array('id'),'Subscription'=>array('fields'=>array('name','frequency'))))));                
            }
            $this->set(compact('getData'));
        }
		/*
            * admin_delete function
            * Functionality -  Add & edit the Users
            * Developer -Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */       
		function admin_delete($id = null)
        {
			$this->loadModel('CompanySubscription');
			if(!empty($id))
			{
				$id = base64_decode($id);
				if($this->Company->updateAll(array('Company.is_deleted'=>'1'),array('Company.id'=>$id))){
					$this->CompanySubscription->updateAll(array('CompanySubscription.is_deleted'=>'1'),array('CompanySubscription.company_id'=>$id));
					$this->Session->setFlash("Company has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
					$this->redirect('index');
				}				
			}
		}
    }