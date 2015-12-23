<?php
class AccessLevel extends AppModel {
    
    function getAccessLevel() {
        return $this->find('all',array('fields'=> array('AccessLevel.id', 'AccessLevel.level_name',
                                                              'AccessLevel.description', 'AccessLevel.access_modify',
                                                              'AccessLevel.access_view')
                                            )
                                );
    }
    
    function getAccessLevelById($access_id=null, $field=null) {
        return $this->find('first',array('fields'=>array('AccessLevel.'.$field),
                        'conditions'=>array('AccessLevel.id'=>$access_id) ) );
    } 
}