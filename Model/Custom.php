<?php    
    class Custom extends AppModel {
        var $name           = 'Custom';
        public $useTable    = false;
        /**
        * Overridden paginate method - group by week, away_team_id and home_team_id
        */
        public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
           $recursive = -1;
           $sql = $extra['extra']['query']." limit ".(($extra['extra']['page']-1)*($limit)).", ".$limit."";
           return $this->query($sql);
        }
       
       /**
        * Overridden paginateCount method
        */
        public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
           $sql = $extra['extra']['query'];
           $this->recursive = $recursive;
           $results = $this->query($sql);
           return count($results);
        }
               
    }
    
?>
