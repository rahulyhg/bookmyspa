<?php
App::uses('AppModel', 'Model');
class Brand extends AppModel {
    public $name = 'Brand';
    public $validationDomain = 'validation';
     public $actsAs = array('Containable');
         public $hasMany = array('BrandtoProductType');
        
    /* Server Side Validations */
     public $validate = array(
                'eng_name' => array(
                         'notEmpty' => array(
                             'rule' => array('notEmpty'),
                             'message' => 'name_empty_error',
                         ),
                         'isUnique' => array(
                            'rule' => array('isUnique'),
                            'message' => 'Enter Unique Brand name'
                        )
                ),
                
           );
   
     public function beforeSave($options = array()) {

        if (empty($this->data[$this->alias]['ara_name'])) {
            $this->data[$this->alias]['ara_name'] = $this->data[$this->alias]['eng_name'];
        }
        return true;
    }
     
}