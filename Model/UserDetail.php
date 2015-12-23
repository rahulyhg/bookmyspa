<?php
App::uses('AppModel', 'Model');
class UserDetail extends AppModel {
    public $name = 'UserDetail';
    public $actsAs = array('Containable');
    public $validationDomain = 'validation';
   
    /* Server Side Validations */
   
    public $validate = array(
	
	'dob' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'dob_empty_error',
		    'last' => true,
		)
	    ),
	'gender' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'gender_empty_error',
		)
	    ),
	'employee_type' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Employee type Connot be empty',
		    'last' => true,
		)
	    ),
	
    );
    
    public function beforeSave($options = array()) {
        if (!empty($this->data[$this->alias]['dob'])) {
	    $dob = $this->beforeSavechangeDateFormat($this->data[$this->alias]['dob']);
            $this->data[$this->alias]['dob'] = $dob;
        }
	if (!empty($this->data[$this->alias]['spouse_dob'])) {
	    $dob = $this->beforeSavechangeDateFormat($this->data[$this->alias]['spouse_dob']);
            $this->data[$this->alias]['spouse_dob'] = $dob;
        }
	if (!empty($this->data[$this->alias]['anniversary'])) {
	    $dob = $this->beforeSavechangeDateFormat($this->data[$this->alias]['anniversary']);
            $this->data[$this->alias]['anniversary'] = $dob;
        }
        return true;
    }
    
    public function afterFind($results, $primary = false) {
	foreach ($results as $key => $val) {
	    if (isset($val['UserDetail']['dob'])) {
		if(!empty($val['UserDetail']['dob']))
		{
		    $results[$key]['UserDetail']['dob'] = $this->afterFindchangeDateFormat($val['UserDetail']['dob']);
		}
		if(!empty($val['UserDetail']['spouse_dob']))
		{
		    $results[$key]['UserDetail']['spouse_dob'] = $this->afterFindchangeDateFormat($val['UserDetail']['spouse_dob']);
		}
		if(!empty($val['UserDetail']['anniversary']))
		{
		    $results[$key]['UserDetail']['anniversary'] = $this->afterFindchangeDateFormat($val['UserDetail']['anniversary']);
		}
	    }
	}
	return $results;
    }
    
}