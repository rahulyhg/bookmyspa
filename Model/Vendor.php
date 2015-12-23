<?php
App::uses('AppModel', 'Model');
    class Vendor extends AppModel {
	
	public $validationDomain = 'validation';
        public $name = 'Vendor';
        
         public $validate = array(
	'eng_business_name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'business_name_empty_error',
		    'last' => true,
		),
               'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3.',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '200'),
                    'message' => 'maxlength_70'
                )
             ),
        'eng_address' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'address_empty_error',
		    'last' => true,
		)
	    ),
        'website' => array(
		'notEmpty' => array(
		    'rule' => 'url',
                    'allowEmpty' => false,
		    'message' => 'website_invalid_error',
		    'last' => true,
		),
	    ),
	'email' => array(
	        'email'=>array(
                    'rule' => array('email'),
		    'message' => 'email_invalid_error',
		    'last' => true,
                ),
            ),
        'phone' => array(
                    'numeric' =>array(
			'rule' => 'numeric',
			'allowEmpty' => false, //validate only if not empty
			'message'=>'phone_numeric_error'
		    ),
		    )
                );
        
      
       public function beforeSave($options = array()){
        if (empty($this->data[$this->alias]['ara_business_name'])){
            $this->data[$this->alias]['ara_business_name'] = $this->data[$this->alias]['eng_business_name'];
        }
        if (empty($this->data[$this->alias]['ara_address'])){
            $this->data[$this->alias]['ara_address'] = $this->data[$this->alias]['eng_address'];
        }
        return true;
        }
        
    }
 