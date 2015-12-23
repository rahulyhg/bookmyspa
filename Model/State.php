<?php
App::uses('AppModel', 'Model');
class State extends AppModel {
   public $name = 'State';
   public $hasMany = array('City');
   public $belongsTo = array('Country');
   
   public $validate = array(
    'name' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'State Name is Required',
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
	    ),
	    'unique'=>array(
		'rule'    => array('isUnique'),
		'message' => 'Enter unique state only.'
	    )
	),
    'code' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'State Code is Required',
		'last' => true,
	    ),
	    'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z,0-9\' ]*$|',
                    'message' =>'Enter alphanumeric value only',
                    'last' => true,
                )
	),
    );

    
}