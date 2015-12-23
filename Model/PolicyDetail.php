<?php

App::uses('AppModel', 'Model');

class PolicyDetail extends AppModel {

    public $validationDomain = 'validation';
    public $name = 'PolicyDetail';
    public $validate = array(
        'ev_validity' => array(
            'notEmpty' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'message' => 'numeric_error',
            ),
            'ev_validity' => array(
                'rule' => array('range', 0, 26),
                'message' => 'maximum_upto_26',
                'required' => false,
            )
        ),
        'cancel_period_appointment' => array(
            'notEmpty' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'message' => 'numeric_error',
            ),
        ),
        'cancel_period_spa' => array(
            'notEmpty' => array(
                'rule' => array('numeric'),
                'allowEmpty' => true,
                'message' => 'numeric_error',
            ),
        ),
    );

}
