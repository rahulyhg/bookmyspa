<?php    
    class Admin extends AppModel {
        var $name = 'Admin';
        var $captcha = ''; //intializing captcha var

        public $validate = array(
        'first_name' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter the first name.'
        ), 
        'captcha'=>array(
				'rule' => array('matchCaptcha'),
				'message'=>'Failed validating human check please try again.'
			),       
        'email' => array(
            'email' => array(
                'rule' => 'email',                
                'message'    => 'Please enter a valid email address.'                
            ),
            'rule1' => array(
                'rule' => 'checkUnique',                
                'message'    => 'Email already exists.'
            )
        ),  
        'password' => array(
            'rule'    => array('minLength', '6'),
            'message' => 'Please enter at least 6 characters password.'
        ),
        'phone' => array(
           'rule' => 'numeric',
           'allowEmpty' => true,
           'message' => 'Please enter the valid phone number.'
        )
        
    );
		
	/*
	 * name: getCaptcha
	 * Developer - Kirpal
	* Created date - 07-07-2014
	 * @param : None
	 * @return : getting captcha value
	*/
	function getCaptcha()	{
		return $this->captcha; 
	}
	
	/*
	 * name: matchCaptcha
	 * Developer - Kirpal
     * Created date - 07-07-2014
	 * @param : inputcaptcha value
	 * @return : return true or false after comparing submitted value with set value of captcha
	*/
	
		function matchCaptcha($inputValue)	{
		return $inputValue['captcha']==$this->getCaptcha(); 
	}
	
	/*
	 * name: setCaptcha
	 * Developer - Kirpal
     * Created date - 07-07-2014
	 * @param : None
	 * @return : none
	*/
	
	function setCaptcha($value)	{
		$this->captcha = $value; 
	}
	
	
    
       
         /**************************************************/   
    public function checkUnique(){
        if(!empty($this->data['Admin']['id'])){
            $data = $this->find('first',array('conditions'=>array('Admin.email'=>$this->data['Admin']['email'],'Admin.id !='=>$this->data['Admin']['id'],'Admin.is_deleted'=>0)));
        }else{
            $data = $this->find('first',array('conditions'=>array('Admin.email'=>$this->data['Admin']['email'])));    
        }
        
        if(!empty($data) && count($data) > 0){
            return false;
        }else{
            return true;
        }
    }
    }

?>
