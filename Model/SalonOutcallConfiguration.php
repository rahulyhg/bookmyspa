<?php
App::uses('AppModel', 'Model');
class SalonOutcallConfiguration extends AppModel {
    public $name = 'SalonOutcallConfiguration';
 public $validationDomain = 'validation';
    /* Server Side Validations */
   
    public $validate = array(
       'driving_time' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'time_empty_error',
		'last' => true,
	    ),
	),
      'additional_cost' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'cost_empty_error',
		'last' => true,
	    ),
	),
       'additional_point_redeem' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'cost_empty_error',
		'last' => true,
	    ),
	)
        );

//    public function getconfigurationSetting() {
//	$configurationSetting = $this->find('first');
//        return $configurationSetting;
//    }
  
}