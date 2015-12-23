<?php
class BankDetail extends AppModel {
    public $validationDomain = 'validation';
    public $name = 'BankDetail';
    
    /* Server Side Validations */
    public $validate = array(
	'account_holder_name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'account_holder_name_isrequired',
		    'last' => true,
		),
               'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3.',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '200'),
                    'message' => 'maxlength_200'
                ),
	       'allowedCharacters'=> array(
		'rule' => '|^[A-Z,a-z\ ]*$|',
		'message' =>'letters_only_error',
		'last' => true,
	    ),
             ),
        'account_number' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last' => true,
		),
		'numeric' => array(
			 'rule' => array('alphanumeric'),
			 'message' => 'alphanumeric_error',
		       ),
                'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '20'),
                    'message' => 'maxlength_20'
                )
	    ),
        'iban' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'iban_empty_error',
		    'last' => true,
		),
	    ),
        'swift_code' => array(
                    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'swift_code_empty_error',
		    'last' => true,
		)
	    ),
	'bank_name' => array(
                    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'bank_name_empty_error',
		    'last' => true,
		)
	    ),
	'bank_address' => array(
                    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'bank_address_empty_error',
		    'last' => true,
		)
	    ),
	'postcode' => array(
                    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last' => true,
		),
		    'numeric' => array(
			 'rule' => array('alphanumeric'),
			 'message' => 'alphanumeric_error',
		       ),
	    ),
        'country' => array(
                    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'country_empty_error',
		    'last' => true,
		)
	    ),
	
    );
    
}