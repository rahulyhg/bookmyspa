<?php
    class Lineup extends AppModel {
         var $name   = 'Lineup';
         var $useTable = 'lineups';
        /*
        * Defining Relationships
        */
       
        public $hasMany = array(
            'lineup_items' => array(
                'className' => 'LineupItems',
                'foreignKey'=>'lineup_id',
            )
        );
    }
?>