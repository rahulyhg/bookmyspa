<?php

class Feedback extends AppModel {
	
    var $name = 'Feedback';

   
    
    var $validate = array(
		
		'captcha' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter captcha',
				'last' => true,
			)
		)
    );
    
    public $actsAs = array(
        'Captcha' => array(
            'field' => array('captcha'),
            'error' => 'Incorrect captcha code value'
        )
    );
    
    
   
    
  
    
    
    
    
}