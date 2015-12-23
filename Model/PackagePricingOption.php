<?php
App::uses('AppModel', 'Model');
class PackagePricingOption extends AppModel {
    
    public $validationDomain = 'validation';
    public $name = 'PackagePricingOption';
    //public $actsAs = array('Containable');

    public $validate = array(
//    'pricing_level_id' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
//    'duration' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
//    'full_price' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
    'sell_price' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
//      'points_given' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
//      'points_redeem' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
      'custom_title' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
    );
    
    
}