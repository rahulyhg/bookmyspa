<?php
App::uses('AppModel', 'Model');
class FeaturingSubscriptionPlan extends AppModel {
    public $name = 'FeaturingSubscriptionPlan';
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
	'no_of_deals' => array(
		'custom' => array(
		    'rule' => array('checkifdeal'),
		    'message' => 'deal_number_empty_error'
		)
	    ),
	'no_of_package' => array(
		'custom' => array(
		    'rule' => array('checkifpackage'),
		    'message' => 'package_number_empty_error'
		)
	    ),
	'no_of staff' => array(
		'custom' => array(
		    'rule' => array('checkifstaff'),
		    'message' => 'staff_number_empty_error'
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

    public function checkifdeal($options = array()) {
	if($this->data[$this->alias]['deal_featuring']){
	    if(!empty($this->data[$this->alias]['no_of_deals'])){
		return true;
	    }
	    else{
		return false;
	    }
	}
	return true;
    }
    public function checkifpackage($options = array()) {
	if($this->data[$this->alias]['package_featuring']){
	    if(!empty($this->data[$this->alias]['no_of_package'])){
		return true;
	    }
	    else{
		return false;
	    }
	}
	return true;
    }
    public function checkifstaff($options = array()) {
	if($this->data[$this->alias]['staff_featuring']){
	    if(!empty($this->data[$this->alias]['no_of staff'])){
		return true;
	    }
	    else{
		return false;
	    }
	}
	return true;
    }
    
}