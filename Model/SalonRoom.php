<?php
App::uses('AppModel', 'Model');
    class SalonRoom extends AppModel {
        public $name = 'SalonRoom';
	public $validationDomain = 'validation';
	public $hasMany = array('SalonRoomImage');
	
    /* Server Side Validations */
   
    public $validate = array(
	
	'eng_room_type' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
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
         'room_class' => array(
            'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last' => true,
		)
	    ),
        'min_guest' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last' => true,
		),
                'numeric'=> array(
                    'rule' => 'numeric',
                    'message' =>'Numbers only',
                    'allowEmpty' => true 
                ),
	    ),
        'max_guest' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last' => true,
		),
               'numeric'=> array(
                    'rule' => 'numeric',
                    'message' =>'Numbers only',
                    'allowEmpty' => true 
                 ),
	    ),
    
    );

    
    public function beforeSave($options = array()) {
        if (empty($this->data[$this->alias]['ara_room_type'])) {
            $this->data[$this->alias]['ara_room_type'] = $this->data[$this->alias]['eng_room_type'];
        }
        if (empty($this->data[$this->alias]['ara_description'])) {
            $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
        }
        return true;
    }
    
    
}