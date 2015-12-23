<?php

App::uses('AppModel', 'Model');

class Payroll extends AppModel {

    public $validationDomain = 'validation';
    public $name = 'Payroll';
    public $validate = array(
        'overtime_start' => array(
            'notEmpty' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'message' => 'numeric_error',
            ),
            'overtime_start' => array(
                'rule' => array('range', 0, 23),
                'message' => 'overtime_maximum_upto_23',
                'required' => false,
            )
        ),
        'overtime_start' => array(
            'rule' => 'notEmpty',
            'message' => 'overtime_nonempty'
        ),
        
        'overtime_cost_hourly' => array(
            'notEmpty' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'message' => 'numeric_error',
            ),
        ),
        'overtime_cost_hourly' => array(
            'rule' => 'notEmpty',
            'message' => 'overtime_cost_hourly_nonempty'
        ),
    );

}
