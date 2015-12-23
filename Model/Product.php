<?php
App::uses('AppModel', 'Model');
    class Product extends AppModel {
	
	public $validationDomain = 'validation';
        public $name = 'Product';
	public $hasMany = array(
        'ProductImage' => array(
            'className' => 'ProductImage',
        )
    );
    /* Server Side Validations */
   
     public $validate = array(
	'barcode' => array(
	    'notEmpty'=>array(
	      'rule'=>array('notEmpty'),
	      'message'=>'empty_error'
	    ),
	    'isUnique' => array(
                            'rule' => array('isUnique'),
                            'message' => 'Enter Unique Barcode'
                        )
	),
       'brand_id' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'required'=>true,
		    'message' => 'empty_error',
		    'last'=>true,
		),
	    ),
        'product_type_id' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'required'=>true,
		    'message' => 'empty_error',
		    'last'=>true,
		),
	    ),
        'eng_product_name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last'=>true,
		),
                'maximum'=>array(
                    'rule'    => array('maxLength', '55'),
                    'message' => 'maxlength_55'
                )
		/*,
		'isUnique' => array(
                            'rule' => array('isUnique'),
                            'message' => 'Enter Product name'
                        )*/
	    ),
        'purchase_date' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last'=>true,
		)
	    ),
	'vendor' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last'=>true,		    
		)
	    ),
	'cost_business'=>array(
		'notEmpty' => array(
		    'rule' => array('numeric'),
                    'allowEmpty' => false,
		    'message' => 'numeric_error',
		 ),'maximum'=>array(
                    'rule'    => array('maxLength', '7'),
                    'message' => 'maxlength_7'
                )
	    ),
	'selling_price'=>array(
		'notEmpty' => array(
		    'rule' => array('numeric'),
                    'allowEmpty' => false,
		    'message' => 'numeric_error',
		 ),
		'maximum'=>array(
                    'rule'    => array('maxLength', '6'),
                    'message' => 'maxlength_6',
		    'last' => true,
                )
	    ),
	'quantity'=>array(
		'notEmpty' => array(
		    'rule' => array('numeric'),
                    'required' => true,
		    'message' => 'numeric_error',
		 ),
		'maximum'=>array(
                    'rule'    => array('maxLength', '6'),
                    'message' => 'maxlength_6'
                )
	    )/*,
	'points_given'=>array(
		'notEmpty' => array(
		    'rule' => array('numeric'),
                    'required' => true,
		    'message' => 'numeric_error',
		 ),
		'maximum'=>array(
                    'rule'    => array('maxLength', '4'),
                    'message' => 'maxlength_4'
                )
	    ),
	'points_Redeem'=>array(
		'notEmpty' => array(
		    'rule' => array('numeric'),
                    'required' => true,
		    'message' => 'numeric_error',
		 ),
		'maximum'=>array(
                    'rule'    => array('maxLength', '4'),
                    'message' => 'maxlength_4'
                )
	    ),*/
    );
     
     public function beforeSave($options = array()){
        if (empty($this->data[$this->alias]['ara_description'])){
	    if(isset($this->data[$this->alias]['eng_description'])){
              $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
	    }
        }
	if (empty($this->data[$this->alias]['ara_product_name'])){
            if(isset($this->data[$this->alias]['eng_product_name'])){
	      $this->data[$this->alias]['ara_product_name'] = $this->data[$this->alias]['eng_product_name'];
	    }
        }
        return true;
    }    
	
	
      
    }