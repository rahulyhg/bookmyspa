<?php

App::uses('AppModel', 'Model');

class PricingLevel extends AppModel {

    public $name = 'PricingLevel';
    public $validationDomain = 'validation';
    /* Server Side Validations */
   // public $hasOne = array('SalonStaff');
    public $validate = array(
        'eng_name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'name_empty_error',
            ),
            'uniqueCheck' => array(
                'rule' => array('uniqueCheck', 'id'),
                'message' => 'This pricing level already exist.',
              )
        ),
           
            /* donot delete commented now
             *             'eng_description' => array(
              'notEmpty' => array(
              'rule' => array('notEmpty'),
              'message' => 'description_empty_error',
              ),
              ),
              'status' => array(
              'notEmpty' => array(
              'rule' => array('notEmpty'),
              'message' => 'status_empty_error',
              ),
              ), */
    );
   
    public function uniqueCheck($levelName) {
        $userId = CakeSession::read("Auth.User.id");
        
        $conditions = array('is_deleted' => 0,'eng_name' => $levelName);
        
        if($this->data[$this->alias]['id'] !=' '){
            $conditions['NOT'] = array('id'=>$this->data[$this->alias]['id']);
        }
        if($userId != 1){
            $conditions['user_id'] = array($userId,1);
        }
       
        $count = $this->find('count', array('conditions' => $conditions));
        
        if($count > 0){
             return false;
        }else{
             return true;
        }
        
    }

   
   
   

    public function getPricingLevelSetting() {
        $emailSms = $this->find('all');
        return $emailSms;
    }

//    public function beforeSave($options = array()) {
//
//        if (empty($this->data[$this->alias]['ara_name'])) {
//            $this->data[$this->alias]['ara_name'] = $this->data[$this->alias]['eng_name'];
//        }
//        if (empty($this->data[$this->alias]['ara_description'])) {
//            $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
//        }
//        return true;
//    }

}
