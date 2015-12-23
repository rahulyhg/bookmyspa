<?php
    class Slide extends AppModel {
        public $hasMany= array(
            'SlideItem' => array(
                'className' =>'SlideItem',
                'foreignKey'=>'slide_id',
            )
        );
       
       
    }
?>