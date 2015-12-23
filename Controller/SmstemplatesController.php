<?php
class SmstemplatesController extends AppController {        
    var $name = 'Smstemplates';                
    public $helpers = array('Session', 'Html', 'Form');	//An array containing the names of helpers this controller uses. 
    public $components = array('Session','Email','Cookie');

	
/**********************************************************************************    
  @Function Name : admin_index
  @Params	 : NULL
  @Description   : List all the Sms Templates
  @Author        : Aman Gupta
  @Date          : 02-Dec-2014
**********************************************************************************/ 
    function admin_index(){
        $this->layout = 'admin';
        $breadcrumb = array(
                    'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                    'SMS Templates'=>array('controller'=>'Smstemplates','action'=>'index','admin'=>true),
                );
        $this->set('breadcrumb',$breadcrumb);
        
        $created_by = $this->Auth->user('id');
        if($this->Auth->user('type') == 1)
            $created_by = 0;
        $templates = $this->Smstemplate->find('all',array('order'=>'id DESC'));
        
        $this->set('getData',$templates);
        $this->set('page_title','SMS Templates');
        $this->set('activeTMenu','smsTemplate');
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Smstemplates";
            $this->render('list_sms_templates');
        }
    }
			    
/**********************************************************************************    
  @Function Name : admin_addedit
  @Params	 : $id = NULL , for smstemplate ID for Edit
  @Description   : Add new OR edit SMS Templates 
  @Author        : Aman Gupta
  @Date          : 02-Dec-2014
**********************************************************************************/
    function admin_addedit($id = null){
        $this->layout = 'ajax';
        $breadcrumb = array(
                    'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                    'SMS Templates'=>array('controller'=>'Smstemplates','action'=>'index','admin'=>true),
                );
        if($id){
            $breadcrumb['Add'] = 'javascript:void(0)';
        }else{
            $breadcrumb['Edit'] = 'javascript:void(0)';
        }
        $this->set('breadcrumb',$breadcrumb);
        if(empty($this->request->data)){
            $this->request->data = $this->Smstemplate->read(null,$id);    
        }
        else{
            if(isset($this->request->data) && !empty($this->request->data)){
                
                $this->request->data['Smstemplate']['id'] = $this->request->data['Smstemplate']['id'];
                if(!empty($this->request->data['Smstemplate']['id'])){
                    unset($this->request->data['Smstemplate']['template_code']);
                }
                
                $this->Smstemplate->set($this->request->data);	
                if($this->Smstemplate->validates()) 				
                {					
                    $this->request->data['Smstemplate']['name'] = trim($this->request->data['Smstemplate']['name']);
                    if($this->Smstemplate->save($this->request->data,false))
                    { 	
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('page_save_success',true);
                        echo json_encode($edata);
                        die;
                    }else{
                        $message = __('unable_to_save', true);
                        $vError = $this->Smstemplate->validationErrors;
                        $edata['data'] = $vError ;
                        $edata['message'] = $message;
                        echo json_encode($edata);
                        die;
                    }
                }else{
                    $message = __('unable_to_save', true);
                    $vError = $this->Smstemplate->validationErrors;
                    $edata['data'] = $vError ;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }    
            }
        }
        
    }
    
}
?>