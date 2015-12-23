<?php
App::uses('AppModel', 'Model');
class Appointment extends AppModel {
    public $name = 'Appointment';
    public $belongsTo = array(
        'SalonService' => array(
            'className'     => 'SalonService',
            'foreignKey'    => 'salon_service_id'
        ),
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'salon_staff_id'
        ),
	'Review' => array(
            'className'     => 'Review',
            'foreignKey'    => 'review_id'
        )
    );
   // public $hasOne = array("Order");
    public $validationDomain = 'validation';
    public $validate = array(
	'salon_service_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please select service',
                
            )
        ),    
	'startdate' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Please select service date',
		    'last' => true,
		)
	    ),
	'time' => array(
	    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Please select time',
		    'last' => true,
		),
            'pattern'=>array(
             'rule'      => '/^(0[0-9]|1[0-2]):(0[0-9]|[0-5][0-9])(AM|PM|pm|am)$/',
             'message'   => 'Please Enter Valid Start Time',
            ),
            'check_closing_hours' => array(
                'rule' => 'check_closing_hours', 
                'message' => 'Appointment hours are more than closing hours'
            )),
        'endtime' => array(
	    'notEmpty' => array(
		'rule' => array('notEmpty'),
		'message' => 'Please select end time',
		'last' => true,
	    ),
            'pattern'=>array(
                'rule'      => '/^([0-1][0-2]|0?[1-9]):([0-5]?[0-9])(AM|PM|pm|am)$/',
                'message'   => 'Please Enter Valid End Time',
            ),
            'time_diff' => array(
                'rule' => 'time_diff', 
                'message' => 'Start time must be smaller than End time'
            )
            ),
	'user_id' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Please select customer',
		    'last' => true,
		)),
        'appointment_return_request' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Please appointment type',
		    'last' => true,
		)),
        'check' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Please check checkbox',
		    'last' => true,
		)),
        'appointment_repeat_end_date' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Please select end date',
		    'last' => true,
		),
                'date_diff' => array(
                    'rule' => 'date_diff', 
                    'message' => 'The repeat end date must be later than start date'
                ),
                'end_date_limit' => array(
                    'rule' => 'end_date_limit', 
                    'message' => 'You can not add daily repeating appointment more than 6 month and Weekly, Monthly and Yearly repeating appointment more than 2 years')
                
                ),
         'appointment_price' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Please enter price',
		    'last' => true,
		)),
        'appointment_duration' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'Please Enter Duration',
		    'last' => true,
		)),
        );
    public function beforeSave($options = array()) {
        if (!empty($this->data[$this->alias]['appointment_repeat_end_date'])) {
            $this->data[$this->alias]['appointment_repeat_end_date'] = strtotime($this->data[$this->alias]['appointment_repeat_end_date']);
           
        }
        return true;
    }
    
    public function afterFind($results, $primary = false) {
	foreach ($results as $key => $val) {
	    if (isset($val['Appointment']['appointment_repeat_end_date']) && !empty($val['Appointment']['appointment_repeat_end_date']))
            {
		$results[$key]['Appointment']['appointment_repeat_end_date'] = date('Y-m-d',$val['Appointment']['appointment_repeat_end_date']);
            }
	   
        }
	return $results;
    }
   
    public function date_diff(){
        if(!isset($this->data['Appointment']['startdate'])){
            $this->data['Appointment']['startdate']=$this->data['Appointment']['startdateHid'];
        }
        //pr($this->data); die;
        $this->data['Appointment']['startdate'] = str_replace('/', '-', $this->data['Appointment']['startdate']);
        $this->data['Appointment']['appointment_repeat_end_date'] = str_replace('/', '-', $this->data['Appointment']['appointment_repeat_end_date']);
        if(isset($this->data['Appointment']['startdate']) && strtotime($this->data['Appointment']['startdate'])>strtotime($this->data['Appointment']['appointment_repeat_end_date'])){
            return false;
        }else{
            return true;
        }
        
        
    }
    
    public function end_date_limit(){
        if(isset($this->data['Appointment']['appointment_repeat_end_date']) && $this->data['Appointment']['appointment_repeat_type']==1){
            $date=strtotime(Date('Y-m-d')); 
            $repeat_days = (strtotime($this->data['Appointment']['appointment_repeat_end_date']) - $date)  / (60 * 60 * 24); 
            if($repeat_days>180){
                return false;
            }else{
                return true;
            }
        }
        if(isset($this->data['Appointment']['appointment_repeat_end_date']) && $this->data['Appointment']['appointment_repeat_type']>1){
            $date=strtotime(Date('Y-m-d')); 
            $repeat_days = (strtotime($this->data['Appointment']['appointment_repeat_end_date']) - $date)  / (60 * 60 * 24); 
            if($repeat_days>730){
                return false;
            }else{
                return true;
            }
        }
    }
    
    public function time_diff(){
        if(strtotime($this->data['Appointment']['time'])>=strtotime($this->data['Appointment']['endtime'])){
            return false;
        }else{
            return true;
        }
        
    }
    public function check_closing_hours(){
        if(isset($this->data['Appointment']['closing_hours']) && $this->data['Appointment']['closing_hours']){
            $time=strtotime($this->data['Appointment']['time']);
            $duration=$this->data['Appointment']['duration_'.$this->data['Appointment']['check']];
            $endTime = strtotime('+'.$duration.' minutes', $time); 
            $closing_hours=$this->data['Appointment']['closing_hours'];
            if($endTime>$closing_hours){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
}