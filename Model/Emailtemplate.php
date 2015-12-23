<?php    
    class Emailtemplate extends AppModel {
        var $name = 'Emailtemplate';
	public $validationDomain = 'validation';
        public $validate = array(
        'name' => array(
            'rule'    => 'notEmpty',
            'message' => 'name_empty_error'
        )
        );        
    /*
	 * to get the email template content by passing the unique code
	 * 
	 * @author        Deepak Dhyani
	 * @copyright     smartData Enterprise Inc.
	 * @method        getEmailTemplate
	 * @param         $code 
	 * @return        Email tempalte data 
	 * @since         version 0.0.1
	 * @version       0.0.1 
	 */
    function getEmailTemplate($code = null) {
        if(!empty($code)){
            $result = $this->find('first', array('conditions' => array('Emailtemplate.template_code LIKE' => "$code")));
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
