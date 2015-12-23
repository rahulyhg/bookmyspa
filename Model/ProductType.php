<?php
App::uses('AppModel', 'Model');
class ProductType extends AppModel {
    public $name = 'ProductType';
    public $validationDomain = 'validation';
    /* Server Side Validations */
     public $validate = array(
                'eng_name' => array(
                         'notEmpty' => array(
                             'rule' => array('notEmpty'),
                             'message' => 'name_empty_error',
                         ),
                         'isUnique' => array(
                            'rule' => array('isUnique'),
                            'message' => 'Enter Unique Product type'
                        )
                )
                
           );
   
     public function beforeSave($options = array()) {
       
        if (empty($this->data[$this->alias]['ara_name'])) {
            $this->data[$this->alias]['ara_name'] = $this->data[$this->alias]['eng_name'];
        }
        
        return true;
    }
     
}