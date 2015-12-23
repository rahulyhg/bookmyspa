<?php
App::uses('AppModel', 'Model');
class SalonOnlineBookingRule extends AppModel {
    public $name = 'SalonOnlineBookingRule';
 
    /* Server Side Validations */
   
    public $validate = array(
	'cancel_time' =>
	    array(
		'nunber'=>array(	
		    'rule' => 'numeric',
		    'allowEmpty' => true,
		    'message' => 'Should be number'
		    ),
		'between' => array(
		    'rule' => array('range', -1, 49),
		    'message' => 'Between 0 to 48 hrs'
		)
	    )
    );

    public function getAppointmentRule() {
	$appointmentRule = $this->find('first');
        return $appointmentRule;
    }
}