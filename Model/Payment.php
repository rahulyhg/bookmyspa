<?php    
    class Payment extends AppModel {
        var $name = 'Payment';      
        
        /*
        * Defining Relationships
        */
        public $belongsTo = array(
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id',
                'fields'    => array('id','paypal_email')
            )
        );
    }
    
?>
