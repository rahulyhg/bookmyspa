<?php
App::uses('AppModel', 'Model');
class Country extends AppModel {
   public $name = 'Country';
   public $hasMany = array('State');
   
   public $validate = array(
    'title' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Country Title is required',
		'last' => true,
	    ),
            'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\' ]*$|',
                    'message' =>'Please enter characters only',
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
	    'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Country title has already been used.',
		'last'=>true,
            )
         ),
    'name' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Country Name is required',
		'last' => true,
	    ),
            'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\' ]*$|',
                    'message' =>'Please enter characters only',
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
	    'unique' => array(
                'rule' => array('isUnique'),
                'message' => 'Country name has already been used.',
		'last'=>true,
            )
	    
	),
    'currency' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Currency is required',
		'last' => true,
	    )
	),
    'currency_code' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Currency Code is required',
		'last' => true,
	    ),
	    'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\' ]*$|',
                    'message' =>'Please enter characters only',
                    'last' => true,
                )
	),
    'iso_code' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Iso Code is required',
		'last' => true,
	    )
	),
    'phone_code'=> array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Country Code is required',
		'last' => true,
	    )
	)
    );

    
}