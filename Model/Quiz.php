<?php    
    class Quiz extends AppModel {
        var $name = 'Quiz';        
        public $useTable = 'quiz';        
      
           public $hasMany = array(
                'QuizQuestion' => array(
                'className' => 'QuizQuestion',
                'foreignKey'=>'quiz_id',
            )
        );
        
        
    }
?>