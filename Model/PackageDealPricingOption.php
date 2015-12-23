<?php
App::uses('AppModel', 'Model');
class PackageDealPricingOption extends AppModel {
    
    public $validationDomain = 'validation';
    public $name = 'PackageDealPricingOption';
    //public $actsAs = array('Containable');

    public $validate = array(

    'deal_price' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),

    );
    
    
}