<?php
    class ContentList extends AppModel {
         var $name   = 'ContentList';
         var $useTable = 'lists';
			public $hasMany= array(
            'ListsItem' => array(
                'className' => 'ListsItem',
                'foreignKey'=>'lists_id',
            )
        );
       
       
    }
?>