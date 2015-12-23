<?php    
    class Poll extends AppModel {
        var $name = 'Poll';        
        public $useTable = 'polls';        
      
           public $hasOne = array(
                'PollQuestion' => array(
                'className' => 'PollQuestion',
                'foreignKey'=>'polls_id',
            )
        );
        
        
    }
?>