<?php    
    class UserAddress extends AppModel {
        var $name = 'UserAddress';
        
        public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',            
            'dependent' => true
        )
        );
        
         
    }
?>
