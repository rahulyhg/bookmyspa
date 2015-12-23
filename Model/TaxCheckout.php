<?php
App::uses('AppModel', 'Model');
class TaxCheckout extends AppModel {
    
    public $validationDomain = 'validation';
    public $name = 'TaxCheckout';
    
        public $validate = array(
	'tax1' =>array(
                'notEmpty' => array(
		    'rule' => array('numeric'),
                    'allowEmpty' => true,
		    'message' => 'numeric_error',
		),
                'tax1'=>array(
                'rule'    => array('range', -1, 100),
                'message' => 'maximum_100',
                 'required' => false,
	    )),
        'tax2' =>array(
                'notEmpty' => array(
		    'rule' => array('numeric'),
                     'allowEmpty' => true,
		    'message' => 'numeric_error',
		),
                'tax2'=>array(
                'rule'    => array('range', -1, 100),
                'message' => 'maximum_100',
	    ),),
         'deduction1' =>array(
                'notEmpty' => array(
		    'rule' => array('numeric'),
                    'allowEmpty' => true,
		    'message' => 'numeric_error',
		),
                'tax3'=>array(
                'rule'    => array('range', -1, 100),
                'message' => 'maximum_100',
                 'required' => false,
	    ),),
        'deduction2' =>array(
                'notEmpty' => array(
		    'rule' => array('numeric'),
                    'allowEmpty' => true,
		    'message' => 'numeric_error',
		),
                'tax4'=>array(
                'rule'    => array('range', -1, 100),
                'message' => 'maximum_100',
	    ),),
         'reward_points' =>array(
                'notEmpty' => array(
		    'rule' => array('numeric'),
                    'allowEmpty' => true,
		    'message' => 'numeric_error',
		 ),
                ),
        'expiration' =>array(
                'notEmpty' => array(
		    'rule' => array('numeric'),
                    'allowEmpty' => true,
		    'message' => 'numeric_error',
		 ),
                ),
     	
    );
    
        public function beforeSave($options = array()){
        if (empty($this->data[$this->alias]['ara_footer_text'])){
            $this->data[$this->alias]['ara_footer_text'] = $this->data[$this->alias]['eng_footer_text'];
        }
        return true;
    }
     
    
}
