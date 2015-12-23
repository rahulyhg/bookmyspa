<?php
App::uses('AppModel', 'Model');
class BusinessType extends AppModel {
    
    public $validationDomain = 'validation';
    
    public $name = 'BusinessType';
    
    public $validate = array(
    'eng_name' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'name_empty_error',
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
    'eng_description' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'description_empty_error',
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
          
    public function beforeSave($options = array()) {
       if (empty($this->data[$this->alias]['ara_name'])) {
            $this->data[$this->alias]['ara_name'] = $this->data[$this->alias]['eng_name'];
        }
        if (empty($this->data[$this->alias]['ara_description'])) {
            $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
        }
        return true;
    }
    
     function businessTypeList(){
        $list = $this->find('list',array('fields'=>array('BusinessType.eng_name'),'conditions'=> array('BusinessType.status'=>1,'BusinessType.is_deleted'=>0),'order'=>'eng_name ASC'));
        return $list;
    }  
    
}