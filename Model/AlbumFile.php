<?php
App::uses('AppModel', 'Model');
    class AlbumFile extends AppModel{
	public $validationDomain = 'validation';
        public $name = 'AlbumFile';
	
	public $validate = array(
	    'image' => array(
		    'notEmpty' => array(
			'rule' => array('notEmpty'),
			'message' => 'image_empty_error',
			'last' => true,
		    )
		),
	    'url' => array(
		    'notEmpty' => array(
			'rule' => array('notEmpty'),
			'message' => 'empty_error',
			'last' => true,
		    ),
		    'url' => array(
			'rule' => 'url',
			'message'=>'Only url is accepted'
		    )
		),
	);
    }
?>    