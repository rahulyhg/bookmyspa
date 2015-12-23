<?php
App::uses('AppModel', 'Model');
class SmsSubscriptionPlan extends AppModel {
    public $name = 'SmsSubscriptionPlan';
    public $validationDomain = 'validation';
    /* Server Side Validations */
   
    public $validate = array(
	
	'title' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'title_empty_error',
		    'last' => true,
		),
                'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\ ]*$|',
                    'message' =>'letters_only_error',
                    'last' => true,
                ),
		'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '200'),
                    'message' => 'maxlength_3'
                ),
                'isUnique' => array(
                    'rule' => 'isUnique',
                    'message' => 'title_empty_error',
		    'on' => 'create',
                ) 
	    ),
	'sub_title' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'subtitle_empty_error',
		    'last' => true,
		),
                'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\ ]*$|',
                    'message' =>'letters_only_error',
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
	    ),
        'no_of_sms' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'sms_number_empty_error',
		    'last' => true,
		),
                'numeric' => array(
                    'rule' => 'numeric',
                    'message' => 'sms_number_numeric_error'
                )
	    ),
        'price' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'price_empty_error',
		    'last' => true,
		),
                'numeric' => array(
                    'rule' => 'numeric',
                    'message' => 'price_numeric_error'
                )
	    ),
        'plan_type' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'type_empty_error',
		    'last' => true,
		),
	    ),
        'status' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'status_empty_error',
		    'last' => true,
		)
	    ),
    );

    
}