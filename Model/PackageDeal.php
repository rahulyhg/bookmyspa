<?php
App::uses('AppModel', 'Model');
class PackageDeal extends AppModel {
    public $name = 'PackageDeal';
    public $actsAs = array('Containable');
    public $hasMany = array('PackageDealService','PackageDealPricingOption');
//    public $hasOne  = array('SalonServiceDetail'=>array(
//	    'className' => 'SalonServiceDetail',
//	    'conditions' => array('SalonServiceDetail.associated_type'=>2),
//	    'foreignKey' =>'associated_id',
//	));
    
    /* Server Side Validations */
    public $validationDomain = 'validation';
    
    public $validate = array(
        'package_id' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
        'eng_name' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
        'eng_description' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
        'image' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
        'limit_per_customer' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
        'max_time' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
        
    );
  
    public function beforeSave($options = array()) {
        if (empty($this->data[$this->alias]['ara_name']) && isset($this->data[$this->alias]['eng_name'])) {
            $this->data[$this->alias]['ara_name'] = $this->data[$this->alias]['eng_name'];
        }
        if (empty($this->data[$this->alias]['ara_description']) && isset($this->data[$this->alias]['eng_description'])) {
            $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
        }
        return true;
    }
}