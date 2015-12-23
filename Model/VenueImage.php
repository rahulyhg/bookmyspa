<?php
App::uses('AppModel', 'Model');
    class VenueImage extends AppModel{
	public $validationDomain = 'validation';
        public $name = 'VenueImage';
	
	public $validate = array(
	
	'image' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'image_empty_error',
		    'last' => true,
		)
	    ),
	
	 );
	

    }
?>    