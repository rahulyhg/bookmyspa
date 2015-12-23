<?php
App::uses('AppModel', 'Model');
class EmailSubscriptionPlan extends AppModel {
    public $name = 'EmailSubscriptionPlan';
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
                    'message' => 'maxlength_200'
                ),
                'isUnique' => array(
                    'rule' => 'isUnique',
                    'message' => 'title_isunique_error',
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
        'customer_type' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'email_number_empty_error',
		    'last' => true,
		),
                'numeric' => array(
                    'rule' => 'numeric',
                    'message' => 'email_number_numeric_error'
                )
	    ),
 	'no_of_emails' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'email_number_empty_error',
		    'last' => true,
		),
                'numeric' => array(
                    'rule' => 'numeric',
                    'message' => 'email_number_numeric_error'
                )
	    ),
	 'no_of_customers' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'No of customers is required',
		    'last' => true,
		),
                'numeric' => array(
                    'rule' => 'numeric',
                    'message' => 'No of customers is required'
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
