<?php
App::uses('AppModel', 'Model');
class Service extends AppModel {
    public $name = 'Service';
    public $actsAs = array('Containable');
    
    
    public $hasMany = array(
	    'ServiceImage' => array(
		//'conditions' => array('ServiceImage.created_by'=>1),
		'className' => 'ServiceImage',
		'foreignKey' => 'service_id',
	      ));
    /* Server Side Validations */
    public $validationDomain = 'validation';
    
    public $validate = array(
	
	'eng_name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'name_empty_error',
		    'last' => true,
		),
                //'allowedCharacters'=> array(
                //    'rule' => '|^[A-Z,a-z\ ]*$|',
                //    'message' =>'letters_only_error',
                //    'last' => true,
                //),
		'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '200'),
                    'message' => 'maxlength_200'
                ),
                'checkTitle' => array(
                   'rule' => array('checkTitle','title'),
                   'message' => 'unique_title',
                   //'on' => 'create', // Limit validation to 'create' or 'update' operations
               )
	    ),
        'eng_description' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'description_empty_error',
		    'last' => true,
		),
	    ),
//	'ara_name' => array(
//		'notEmpty' => array(
//		    'rule' => array('notEmpty'),
//		    'message' => 'name_empty_error',
//		    'last' => true,
//		)
//	    ),
//        'ara_description' => array(
//		'notEmpty' => array(
//		    'rule' => array('notEmpty'),
//		    'message' => 'description_empty_error',
//		    'last' => true,
//		),
//	    ),
        'status' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'status_empty_error',
		    'last' => true,
		)
	    ),
    );

    function checkTitle($check,$otherfield)
    {
        $this->recursive = -1;
        $cond = array();
        $cond['Service.eng_name']  =  $this->data[$this->name]['eng_name'];
        if(isset($this->data[$this->name]['parent_id'])){
          $cond['Service.parent_id']  =  $this->data[$this->name]['parent_id'];
          $cond['Service.is_deleted']  =  '= 0';
        }
        if(isset($this->data[$this->name]['id']) && !empty($this->data[$this->name]['id'])){
         $cond['NOT'] =  array( 
                        'Service.id' => $this->data[$this->name]['id']
                );
        }
        $title = $this->find('first' ,array('conditions'=>$cond));
        if(count($title)){
            return false;   
        }else{
            return true;
        }
    }
    
    
   public function beforeSave($options = array()) {
        if (empty($this->data[$this->alias]['ara_name']) && isset($this->data[$this->alias]['eng_name'])) {
            $this->data[$this->alias]['ara_name'] = $this->data[$this->alias]['eng_name'];
        }
        if (empty($this->data[$this->alias]['ara_description']) && isset($this->data[$this->alias]['eng_description'])) {
            $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
        }
        return true;
    }
    
    public function get_services($tagIds,$offset=0){
        $services = $this->find('all',array('conditions'=> array('parent_id <>' => 0,'parent_id'=>$tagIds),'offset'=>$offset, 'limit'=>10));
	return $services;    
    }
    public function count_services($tagIds){
        $countServices = $this->find('count',array('conditions'=> array('parent_id <>' => 0,'parent_id'=>$tagIds)));
	return $countServices;    
    }
}