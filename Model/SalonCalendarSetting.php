<?php
App::uses('AppModel', 'Model');
class SalonCalendarSetting extends AppModel {
    public $name = 'SalonCalendarSetting';
 
    /* Server Side Validations */
    
    public function getCalendarSetting() {
	$emailSms = $this->find('first');
        return $emailSms;
    }
    
    public $validate = array(
	
	'provider_max_day_limit' => array(
                'notEmpty' => array(
                       'rule' => array('notEmpty'),
                       'message' => 'Service provider limit in day view is Required',
                       'last' => true,
                ),
                'numeric'=> array(
                       'rule' => array('numeric'),
                       'message' =>'Numbers Only',
                       'last' => true,
                ),
                'number' => array(
			'rule' => array('range', 0, 26),
			'message' => 'Please enter a number between 1 and 25'
		)
	),
	'calendar_line_space' => array(
                'notEmpty' => array(
                       'rule' => array('notEmpty'),
                       'message' => 'Calendar line spacing is Required',
                       'last' => true,
                ),
                'numeric'=> array(
                       'rule' => array('numeric'),
                       'message' =>'Numbers Only',
                       'last' => true,
                ),
                'number' => array(
			'rule' => array('range', 15, 31),
			'message' => 'Please enter a number between 16 and 30'
		)
	),
    );
}