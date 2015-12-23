<?php
    /*
        * Categories Controller class
        * Functionality -  Manage the Categories Management
        * Developer - Navdeep kaur
        * Created date - 16-Apr-2014
        * Modified date - 
    */
    class CategoriesController extends AppController {        
        var $name = 'Categories';                
		public $components = array('Paginator','Common');
		var $helpers = array('Common');
		
		
        function beforeFilter(){
            parent::beforeFilter();    
        }
		
		/*
            * admin_index function
            * Functionality -  Categories Listing
            * Developer - Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */
        function admin_index($pCategoryId =null)
        {           //  pr($this->params);
			
		/* Active/Inactive/Delete functionality */
			if((isset($this->request->data["Category"]["setStatus"])))
			{
				if(!empty($this->request->data['Category']['status'])){
					$status = $this->request->data['Category']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'index'));
					
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='Category';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */	
			$value ="";
			if($pCategoryId != ""){ 
				$criteria = array("is_deleted" => 0 ,"parent_id" => base64_decode($pCategoryId));
			}else{				
				$criteria = array("is_deleted" => 0 ,"parent_id" => NULL);
			}
			
			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria = array("is_deleted" => 0 );
						$criteria["Category.category LIKE"] = "%".$value."%";
					}
			}
			//if(!empty($this->request->data['Search'])){
			//	if(isset($this->request->data['Search']['keyword']) && !empty($this->request->data['Search']['keyword'])){		   
			//		$value = $this->request->data['Search']['keyword'];				  
			//	}	
			//	if($value !="") {
			//			$criteria .= " AND Category.category LIKE '%".$value."%'";						
			//	}						
			//}			
			$this->Paginator->settings = array('conditions' => array($criteria),
				'limit' => 10,
				'fields' => array('Category.id',
								  'Category.category',	  
								  'Category.status',
								  'Category.parent_id',
								  'Category.created'								  
								  ),
				'order' => array(
					'Category.id' => 'DESC'
				)
			);
			
			$this->set('getData',$this->Paginator->paginate('Category'));
			$this->set('keyword', $value);
			$this->set('navcategory','class = "active"');			
			$this->set('breadcrumb','Categories');			
			
        }
		
        /*
            * admin_addedit function
            * Functionality -  Add & edit the Categories
            * Developer - Navdeep kaur
            * Created date - 16-Apr-2014
            * Modified date - 
        */
        function admin_addedit($id = null,$parentId=null)
        {
			if($parentId !=""){
				$parentId = base64_decode($parentId);
			}else{
				$parentId = 0;
			}
			$categories = $this->Category->find('list',array('conditions'=>array('Category.parent_id'=>NULL,'Category.status'=>1,'Category.is_deleted'=>0),'fields'=>array('id','category'),'order'=>'category ASC'));
			$this->set('categories',$categories);
			if(empty($this->request->data)){
				$this->request->data = $this->Category->read(null, base64_decode($id));			
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{  $this->request->data['Category']['id'] = base64_decode($this->request->data['Category']['id']);
				$this->Category->set($this->request->data);	
				if($this->Category->validates()) 				
				{ 
					$this->request->data['Category']['category'] = trim($this->request->data['Category']['category']);					
					
					if($this->Category->save($this->request->data))
					{ 	
						$this->Session->setFlash("Category has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'index'));
					}
				}    
			}
			$textAction = ($id == null) ? 'Add' : 'Edit';			
			$this->set('navcategory','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Categories/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
			$this->set('parentId',$parentId);
        }
		/*
            * admin_delete function
            * Functionality - delete Categories
            * Developer - Navdeep kaur
            * Created date - 16-Apr-2014
            * Modified date - 
        */
		function admin_delete($id = null)
                {				
			$id = base64_decode($id);
			if($this->Category->updateAll(array('Category.is_deleted'=>'1'),array('Category.id'=>$id))){
				$this->Session->setFlash("Category has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
				$this->redirect('index');
			}
		}
		function admin_subcategories($parentCategoryId = null){
			$this->set('parentCategoryId',$parentCategoryId);
			$parentCategoryId = base64_decode($parentCategoryId);
			
		/* Active/Inactive/Delete functionality */
			if((isset($this->request->data["Category"]["setStatus"])))
			{
				if(!empty($this->request->data['Category']['status'])){
					$status = $this->request->data['Category']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'index'));
					
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='Category';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */	
			$value ="";
			$criteria="is_deleted = 0 AND parent_id = $parentCategoryId";
			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria .= " AND Category.category LIKE '%".$value."%'";						
					}
			}
			//if(!empty($this->request->data['Search'])){
			//	if(isset($this->request->data['Search']['keyword']) && !empty($this->request->data['Search']['keyword'])){		   
			//		$value = $this->request->data['Search']['keyword'];				  
			//	}	
			//	if($value !="") {
			//			$criteria .= " AND Category.category LIKE '%".$value."%'";						
			//	}						
			//}			
			$this->Paginator->settings = array('conditions' => array($criteria),
				'limit' => 10,
				'fields' => array('Category.id',
								  'Category.category',								  
								  'Category.status',
								  'Category.created'								  
								  ),
				'order' => array(
					'Category.id' => 'DESC'
				)
			);
			$this->set('getData',$this->Paginator->paginate('Category'));
			$this->set('keyword', $value);
			$this->set('navcategory','class = "active"');			
			$this->set('breadcrumb','Categories/Subcategories');			
			
        }
		 function admin_add_subcategory($parentCatId = null, $id = null)
        {
			echo base64_decode($parentCatId);
			echo base64_decode($id);
                        $this->set('parentCatId',$parentCatId);		
			if(empty($this->request->data)){
				$this->request->data = $this->Category->read(null, base64_decode($id));			
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{  $this->request->data['Category']['id'] = base64_decode($this->request->data['Category']['id']);
				$this->Category->set($this->request->data);	
				if($this->Category->validates()) 				
				{ 
										
					$this->request->data['Category']['category'] = trim($this->request->data['Category']['category']);					
					$this->request->data['Category']['parent_id'] = base64_decode($parentCatId);
					if($this->Category->save($this->request->data))
					{ 	
						$this->Session->setFlash("Sub Category has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'subcategories',$parentCatId));
					}
				}    
			}
			$textAction = ($id == null) ? 'Add' : 'Edit';			
			$this->set('navcategory','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Categories/Subcategories'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
			
        }
        
		function admin_delete_subcategory($id = null)
        {				
			$id = base64_decode($id);
			if($this->Category->updateAll(array('Category.is_deleted'=>'1'),array('Category.id'=>$id))){
				$this->Session->setFlash("Sub Category has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
				$this->redirect(array('action' => 'subcategories',$id));
			}
		}
    }

?>