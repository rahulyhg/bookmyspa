<?php
App::uses('AppModel', 'Model');
    class BlogCategory extends AppModel {
	
	public $validationDomain = 'validation';
        public $name = 'BlogCategory';
 
    /* Server Side Validations */
   
    public $validate = array(
	'eng_name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'name_empty_error',
		    'last' => true,
		),
                'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\ ]*$|',
                    'message' =>'letters_only_error',
                    'last' => true,
                ),
		'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '200'),
                    'message' => 'maxlength_200'
                ),
		'isUnique' => array(
                    'rule' => 'isUnique',
                    'message' => 'eng_name_isunique_error',
               ) 
	    ),
        'status' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'status_empty_error',
		    'last' => true,
		)
	    ),
    );

    
    public function beforeSave($options = array()) {
        
        if (empty($this->data['BlogCategory']['ara_name'])) {
            $this->data['BlogCategory']['ara_name'] = $this->data[$this->alias]['eng_name'];
        }
        
        return true;
    }
    
    
}