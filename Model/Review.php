<?php    
    class Review extends AppModel {
        public $name = 'Review';
        public $belongsTo = array('ReviewRating');
    }
?>