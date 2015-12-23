<?php

App::uses('AppModel', 'Model');

class GiftImage extends AppModel {

    public $name = 'GiftImage';
    public $validationDomain = 'validation';

    /* Server Side Validations */
    public $validate = array(
        'eng_title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'title_empty_error',
                'last' => true,
            ),
            'minimum' => array(
                'rule' => array('minLength', '3'),
                'message' => 'minlength_3',
                'last' => true,
            ),
            'maximum' => array(
                'rule' => array('maxLength', '200'),
                'message' => 'maxlength_200'
            )
        ), 
        'image' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'image_empty_error',
                'last' => true,
            )
        ),        
    );
}
