<?php    
    class Publisher extends AppModel {
        var $name = 'Publisher';      
        
        /*
        * Defining Relationships
        */
        public $belongsTo = array(
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id',
                'fields'    => array('id')
            )
        );
    }
    
?>
