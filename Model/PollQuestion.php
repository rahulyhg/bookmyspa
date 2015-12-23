<?php    
    class PollQuestion extends AppModel {
        var $name = 'PollQuestion';        
            
            public $hasMany = array(
                    'PollAnswer' => array(
                    'className' => 'PollAnswer',
                    'foreignKey'=>'poll_questions_id',
                )
        );       
       
    }
?>