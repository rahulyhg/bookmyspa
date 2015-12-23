<?php
App::uses('AppModel', 'Model');
class City extends AppModel {
   public $name = 'City';
   public $belongsTo = array('Country');
       
   
   public $validate = array(
    'city_name' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'City Name is Required',
		'last' => true,
	    ),
            'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\' ]*$|',
                    'message' =>'allowed_char_error',
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
    'county' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'City code is Required',
		'last' => true,
	    )
	),
    'latitude' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'City latitude is Required',
		'last' => true,
	    ),
            'numeric' => array(
		'rule' => array('numeric'),
		'message' => 'Enter only numeric value',
		'last' => true,
	    )
            
	),
    'longitude' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'City longitude is Required',
		'last' => true,
	    ),
            'numeric' => array(
		'rule' => array('numeric'),
		'message' => 'Enter only numeric value',
		'last' => true,
	    )
	)
    );
    
}