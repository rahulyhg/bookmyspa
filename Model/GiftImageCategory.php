<?php

App::uses('AppModel', 'Model');

class GiftImageCategory extends AppModel {

    public $name = 'GiftImageCategory';
    public $validationDomain = 'validation';
    public $hasMany = array('GiftImage');

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
    );

}
