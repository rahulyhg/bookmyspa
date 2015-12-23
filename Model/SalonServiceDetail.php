<?php

App::uses('AppModel', 'Model');

class SalonServiceDetail extends AppModel {

    public $name = 'SalonServiceDetail';
    public $validationDomain = 'validation';
    //public $actsAs = array('Containable');
    //public $belongsTo = array('SalonService'); 

//
// public function beforeSave($options = array()) {
//        if (!empty($this->data[$this->alias]['listed_online_start'])) {
//	    $dob = $this->beforeSavechangeDateFormat($this->data[$this->alias]['listed_online_start']);
//            $this->data[$this->alias]['listed_online_start'] = $dob;
//        }
//	if (!empty($this->data[$this->alias]['listed_online_end'])) {
//	    $dob = $this->beforeSavechangeDateFormat($this->data[$this->alias]['listed_online_end']);
//            $this->data[$this->alias]['listed_online_end'] = $dob;
//        }
//     
//	return true;
//    }
//    
//    public function afterFind($results, $primary = false) {
//	foreach ($results as $key => $val) {
//	    if (isset($val['SalonServiceDetail']['listed_online_start'])) {
//		if(!empty($val['SalonServiceDetail']['listed_online_start']))
//		{
//		    $results[$key]['SalonServiceDetail']['listed_online_start'] = $this->afterFindchangeDateFormat($val['SalonServiceDetail']['listed_online_start']);
//		}
//		if(!empty($val['SalonServiceDetail']['listed_online_end']))
//		{
//		    $results[$key]['SalonServiceDetail']['listed_online_end'] = $this->afterFindchangeDateFormat($val['SalonServiceDetail']['listed_online_end']);
//		}
//		
//	    }
//	}
//	return $results;
//    }
    }