<?php
App::uses('AppModel', 'Model');
class SalonEmailSms extends AppModel {
    public $name = 'SalonEmailSms';
    public $validationDomain = 'validation';
    /* Server Side Validations */
    
    public $validate = array(
        'business_email' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'email_empty_error',
		'last' => true,
	    ),
            'email'=>array(
                    'rule' => array('email'),
		    'message' => 'email_invalid_error',
		    'last' => true,
            )
	),
       
    );
    
    
    public function getEmailSMSSetting() {
	$emailSms = $this->find('first');
        return $emailSms;
    }
}