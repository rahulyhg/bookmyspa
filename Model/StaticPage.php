<?php
App::uses('AppModel', 'Model');
    class StaticPage extends AppModel {
        public $name = 'StaticPage';
	public $validationDomain = 'validation';
	public $belongsTo = array(
                'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by',
            
        ) 
            );
    /* Server Side Validations */
   
    public $validate = array(
	
	'alias' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'alias_empty_error',
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
                    'message' => 'alias_isunique_error',
		    'on' => 'create',
                ) 
	    ),
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
                )
	    ),
        'eng_title' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'title_empty_error',
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
                )
	    ),
        'eng_description' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'description_empty_error',
		    'last' => true,
		),
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
        if (empty($this->data[$this->alias]['ara_title'])) {
            $this->data[$this->alias]['ara_title'] = $this->data[$this->alias]['eng_title'];
        }
        if (empty($this->data[$this->alias]['ara_name'])) {
            $this->data[$this->alias]['ara_name'] = $this->data[$this->alias]['eng_name'];
        }
        if (empty($this->data[$this->alias]['ara_description'])) {
            $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
        }
        return true;
    }
    
    
}