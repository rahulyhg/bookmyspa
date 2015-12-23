<?php    
    class QuizQuestion extends AppModel {
        var $name = 'QuizQuestion';        
            
            public $hasMany = array(
                    'QuizAnswer' => array(
                    'className' => 'QuizAnswer',
                    'foreignKey'=>'quiz_questions_id',
                )
        );       
       
    }
?>