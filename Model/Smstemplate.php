<?php    
    class Smstemplate extends AppModel {
        var $name = 'Smstemplate';
	public $validationDomain = 'validation';
        public $validate = array(
	    'name' => array(
		'rule'    => 'notEmpty',
		'message' => 'name_empty_error'
	    )
        );        
    
	
/**********************************************************************************    
  @Function Name : getSmsTemplate
  @Params	 : $code
  @Description   : Returns SMS Template
  @Author        : Aman Gupta
  @Date          : 02-Dec-2014
**********************************************************************************/ 	
	function getSmsTemplate($code = null) {
	    if(!empty($code)){
		$result = $this->find('first', array('conditions' => array('Smstemplate.template_code LIKE' => "$code")));
		if(is_array($result) && !empty($result)) { 
		    return ($result);
		}else {
		    return false;
		}
	    } else {
		return false;
	    }
	}
    }
?>
