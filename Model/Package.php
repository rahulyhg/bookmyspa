<?php
App::uses('AppModel', 'Model');
class Package extends AppModel {
    public $name = 'Package';
    public $actsAs = array('Containable');
    public $hasMany = array('PackageService','SalonStaffPackage');
    public $hasOne  = array('SalonServiceDetail'=>array(
	    'className' => 'SalonServiceDetail',
	    'conditions' => array('SalonServiceDetail.associated_type'=>2),
	    'foreignKey' =>'associated_id',
	));
    
    /* Server Side Validations */
    public $validationDomain = 'validation';
    
    public $validate = array(
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