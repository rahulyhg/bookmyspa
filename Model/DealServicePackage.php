<?php
App::uses('AppModel', 'Model');
class DealServicePackage extends AppModel {
    public $name = 'DealServicePackage';
    public $actsAs = array('Containable');
   // public $belongsTo = array('Deal');
    public $hasMany  = array('DealServicePackagePriceOption');
 /* Server Side Validations */
    public $validationDomain = 'validation';
    public $validate = array(
    'eng_name' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
    'eng_description' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
    );
     
    
}

