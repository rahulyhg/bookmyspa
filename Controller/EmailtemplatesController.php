<?php
class EmailtemplatesController extends AppController {        
        var $name = 'Emailtemplates';                
	public $helpers = array('Session', 'Html', 'Form');	//An array containing the names of helpers this controller uses. 
	public $components = array('Session','Email','Cookie');
        function beforeFilter(){
            parent::beforeFilter();    
            
        }     
	/*
            * admin_index function
            * Functionality -  Emailtemplates Listing
	    * Developer - Shibu Kumar
	    * Created date - 11-November-2014
            * Modified date - 
        */
        function admin_index()
        {
	    $this->layout = 'admin';
	    $breadcrumb = array(
			    'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
			    'Email Templates'=>array('controller'=>'emailtemplates','action'=>'index','admin'=>true),
				);
	    $this->set('breadcrumb',$breadcrumb);
	    $created_by = $this->Auth->user('id');
	    if($this->Auth->user('type') == 1)
		$created_by = 0;
		$templates = $this->Emailtemplate->find('all',array('order'=>'id DESC'));
	    $this->set('getData',$templates);
	    $this->set('page_title','Email Templates');
	    $this->set('activeTMenu','emailTemplate');
	    $this->set('leftMenu',true);
	    if($this->request->is('ajax')){
		$this->layout = 'ajax';
		$this->viewPath = "Elements/admin/Emailtemplates";
		$this->render('list_email_templates');
	    }
	}
			    
		/*
		* admin_addedit function
            * Functionality -  Add & edit the Emailtemplates
	    * Developer - Shibu Kumar
	    * Created date - 12-November-2014
            * Modified date - 
        */
        function admin_addedit($id = null)
        {
	   $this->layout = 'ajax';
	   $breadcrumb = array( 
			    'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
			    'Email Templates'=>array('controller'=>'emailtemplates','action'=>'index','admin'=>true),
			    'Add'=>'javascript:void(0)'
				);
	    $this->set('breadcrumb',$breadcrumb);
	    if(empty($this->request->data)){
		    $this->request->data = $this->Emailtemplate->read(null,$id);			
	    }else
	    if(isset($this->request->data) && !empty($this->request->data))
	    {
		$this->request->data['Emailtemplate']['id'] = $this->request->data['Emailtemplate']['id'];
		
		    if(!empty($this->request->data['Emailtemplate']['id']))
		    {
			unset($this->request->data['Emailtemplate']['template_code']);
		    }
		$this->Emailtemplate->set($this->request->data);
		
		if(empty($this->request->data['Emailtemplate']['text_template'])) {
			$text_template = strip_tags(str_replace('&nbsp;',' ',$this->request->data['Emailtemplate']['template']));
			$this->request->data['Emailtemplate']['text_template'] = $text_template;
		}
		$this->request->data['Emailtemplate']['text_template'] = trim($this->request->data['Emailtemplate']['text_template']);
		//pr($this->request->data); die;
		$this->Emailtemplate->set($this->data);
		
		if($this->Emailtemplate->validates()) 				
		{					
		    $this->request->data['Emailtemplate']['name'] = trim($this->request->data['Emailtemplate']['name']);
		    if($this->Emailtemplate->save($this->request->data,false))
		    { 	
			$edata['data'] = 'success' ;
			$edata['message'] = __('page_save_success',true);
			echo json_encode($edata);
			die;
		    }else{
			$message = __('unable_to_save', true);
			$vError = $this->Emailtemplate->validationErrors;
			$edata['data'] = $vError ;
			$edata['message'] = $message;
			echo json_encode($edata);
			die;
		    }
		}else{
		    $message = __('unable_to_save', true);
		    $vError = $this->Emailtemplate->validationErrors;
		    $edata['data'] = $vError ;
		    $edata['message'] = $message;
		    echo json_encode($edata);
		    die;
		}    
	    }
	    
        }
    }
?>