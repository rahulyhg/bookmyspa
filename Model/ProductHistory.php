<?php
App::uses('AppModel', 'Model');
    class ProductHistory extends AppModel {
	
	public $validationDomain = 'validation';
        public $name = 'ProductHistory';
        
	 public $validate = array(
	    'date' => array('notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'required'=>true,
		    'message' => 'empty_error',
		    'last'=>true,
		),
            'date' => array(
                'rule' => 'date',
                'message' => 'invald_date_error',
		)
            ),
       'reason' => array(
                'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last'=>true,
		)
             ),
       'type' => array(
                'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'empty_error',
		    'last'=>true,
		)
             )
       );
    }