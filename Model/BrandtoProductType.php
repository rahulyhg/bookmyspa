<?php
 
App::uses('AppModel', 'Model');
    class BrandtoProductType extends AppModel {
        public $name = 'BrandtoProductType';
        public $actsAs = array('Containable');
 
     public $belongsTo = array(
        'ProductType' => array(
            'className' => 'ProductType',
            'foreignKey' => 'product_type_id'
        ),
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brand_id'
        )
);
    public $validate = array(
                'product_type_id' => array(
                         'notEmpty' => array(
                             'rule'     => array('comparison', '!=', 0),
                             'required' => true,
                             'message' => 'name_empty_error',
                         )
                         
                )
                
           ); 
   
    
}