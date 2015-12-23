<?php
App::uses('AppModel', 'Model');
class Deal extends AppModel {
    public $name = 'Deal';
    public $actsAs = array('Containable');
    public $hasMany = array('DealServicePackage');
    //public $hasOne  = array('ServiceDealDetail');
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

