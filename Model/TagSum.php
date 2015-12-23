<?php    
    class TagSum extends AppModel{
        var $name = 'TagSum'; 
        public $belongsTo = array('Tag',
            //'counterCache' => true,
            );
    }
    
?>
