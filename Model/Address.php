<?php
App::uses('AppModel', 'Model');
class Address extends AppModel {
    
    public $validationDomain = 'validation';
    public $name = 'Address';
    public $actsAs = array('Containable');
    public $belongsTo = array('Country','State','City');
    
    public $validate = array(
    /*'address' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Address is Required',
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
	),*/
    'country_id' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'country_empty_error',
		'last' => true,
	    )
	),
    'state_id' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'state_empty_error',
		'last' => true,
	    )
	),
    'city_id' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'city_empty_error',
		'last' => true,
	    )
	),
      'po_box' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'po_empty_error',
		'last' => true,
	    )
	),
    );
    
    
}