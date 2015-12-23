<?php
App::uses('AppModel', 'Model');
class DealPricingOption extends AppModel {
    
    public $validationDomain = 'validation';
    public $name = 'DealPricingOption';
    //public $actsAs = array('Containable');

    public $validate = array(
        'price' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Deal price is required.',
		'last' => true,
	    )
	),
        'eng_dealname' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Deal pricing option name is required.',
		'last' => true,
	    )
	)
    );
    
    
}