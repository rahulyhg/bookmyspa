<?php    
    class Spabreak extends AppModel {
        var $name = 'Spabreak';
	public $validationDomain = 'validation';
        public $hasMany = array('SpabreakOption','SalonSpabreakImage');
        public $hasOne  = array('SalonServiceDetail'=>array(
            'className' => 'SalonServiceDetail',
            'conditions' => array('SalonServiceDetail.associated_type'=>3),
            'foreignKey' =>'associated_id',
        )); 
        

        public $belongsTo = array(
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id'
            )
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
?>