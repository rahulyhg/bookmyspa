<?php

App::uses('AppModel', 'Model');

class SalonAd extends AppModel {

    public $name = 'SalonAd';
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
        'eng_description' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'description_empty_error',
                'last' => true,
            ),
        ),
        /*'ara_title' => array(
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
        'ara_description' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'description_empty_error',
                'last' => true,
            ),
        ),*/
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
                'message' => 'Only url is accepted'
            )
        ),
    );

}
