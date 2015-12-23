<?php
App::uses('AppModel', 'Model');
class Salon extends AppModel {
    public $name = 'Salon';
    public $actsAs = array('Containable');
  
    public $validationDomain = 'validation';
        // public $hasMany = array('SalonStaff');
        // public $belongsTo = array('BusinessType');
    public $belongsTo = array('User');
   
    /* Server Side Validations */
    public $validate = array(
	
	'business' => array(
                'notEmpty' => array(
                       'rule' => array('notEmpty'),
                       'message' => 'name_empty_error',
                       'last' => true,
                ),
                'allowedCharacters'=> array(
                       'rule' => '|^[A-Z,a-z,0-9_\-\' ]*$|',
                       'message' =>'allowed_char_error',
                       'last' => true,
                ),
                'minimum'=>array(
                       'rule'    => array('minLength', '3'),
                       'message' => 'minlength_3',
                       'last'=>true,
                ),
                'maximum'=>array(
                       'rule'    => array('maxLength', '30'),
                       'message' => 'maxlength_30'
                ),
	 ),

        'eng_description' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'description_empty_error',
		    'last' => true,
		),
            ),
	 'eng_name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'name_empty_error',
		    'last' => true,
		),
		'isUnique' => array(
		    'rule' => 'isUnique',
		    'message' => 'Business Name should be unique.'
		)
            ),
	 'business_type_id' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'business_type_empty_error',
		    'last' => true,
		),
            ),
	
	'website_url' => array(
		    'Url'=>array(
			'rule' =>'url',
			'allowEmpty' => true,
			'message' => 'enter_correct_url',
		    )
		),
	'business_url' => array(
			'notEmpty' => array(
			    'rule' => array('notEmpty'),
			    'message' => 'businessurl_empty_error',
			    'last' => true,
			),
			'isUnique' => array(
			    'rule' => 'isUnique',
			    'message' => 'Business URL should be unique.'
			)
		),
	'service_to' => array(
				    'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => 'service_to_empty_error',
					'last' => true,
				    ),
			    ),
    );
    
    

    
 public function beforeSave($options = array()) {
        if (!empty($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
	
        if (empty($this->data[$this->alias]['ara_name']) && isset($this->data[$this->alias]['eng_name'])) {
            $this->data[$this->alias]['ara_name'] = $this->data[$this->alias]['eng_name'];
        }
        if (empty($this->data[$this->alias]['ara_description']) && isset($this->data[$this->alias]['eng_description'])) {
            $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
        }
        return true;
    }
    

    
}