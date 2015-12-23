<?php
App::uses('AppModel', 'Model');
class ServicePricingOption extends AppModel {
    
    public $validationDomain = 'validation';
    public $name = 'ServicePricingOption';
    //public $actsAs = array('Containable');

    public $validate = array(
//    'pricing_level_id' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
//    'duration' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
    'sell_price' => array(
		'comparePrice' => array(
		    'rule' => array('comparePrice','full_price'),
		    'message' => 'Sell Price should be less than Full price.',
		    //'on' => 'create', // Limit validation to 'create' or 'update' operations
		
	    )
	),
    'full_price' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
//      'points_given' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
//      'points_redeem' => array(
//	    'notEmpty' => array(
//		'rule' => array('notEmpty'),
//		'message' => 'empty_error',
//		'last' => true,
//	    )
//	),
      'custom_title' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'empty_error',
		'last' => true,
	    )
	),
    );
    
    function comparePrice($check,$full)
    {
	if(!empty($check['sell_price'])&&!empty($this->data[$this->name][$full])){
	    if($this->data[$this->name][$full] < $check['sell_price']){
	      return false;
	    }    
	}
	return true;
    }
      public function beforeSave($options = array()) {
        if (empty($this->data[$this->alias]['custom_title_eng']) && isset($this->data[$this->alias]['custom_title_eng'])) {
            $this->data[$this->alias]['custom_title_eng'] = $this->data[$this->alias]['custom_title_eng'];
        }
        
        return true;
    }
}