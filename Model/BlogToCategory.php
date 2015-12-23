<?php
App::uses('AppModel', 'Model');
    class BlogToCategory extends AppModel {
        public $name = 'BlogToCategory';
 
     public $belongsTo = array(
        'BlogCategory' => array(
            'className' => 'BlogCategory',
            'foreignKey' => 'category_id'
        ),
        'Blog' => array(
            'className' => 'Blog',
            'foreignKey' => 'blog_id'
        )
);
     
    
    
}