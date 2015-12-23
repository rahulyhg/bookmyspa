<?php    
    class Tag extends AppModel{
       
       public $hasMany = array(
        'TagSum' => array(
            'className' => 'TagSum',
        )
    );
		
    }
    
?>
