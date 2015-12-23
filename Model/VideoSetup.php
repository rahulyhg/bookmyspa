<?php
App::uses('AppModel', 'Model');
class VideoSetup extends AppModel {
    public $name = 'VideoSetup';
    public $validationDomain = 'validation';
    /* Server Side Validations */
     public $validate = array(
                'eng_title' => array(
                         'notEmpty' => array(
                             'rule' => array('notEmpty'),
                             'message' => 'name_empty_error',
                         ),
                         'isUnique' => array(
                            'rule' => array('isUnique'),
                            'message' => 'Enter Unique Product type'
                        )
                ),
                'eng_description' => array(
                         'notEmpty' => array(
                             'rule' => array('notEmpty'),
                             'message' => 'name_empty_error',
                         )
                ),
                'youtube_link' => array(
                         'notEmpty' => array(
                             'rule' => array('notEmpty'),
                             'message' => 'name_empty_error',
                         ),
                         'isUnique' => array(
                            'rule' => array('isUnique'),
                            'message' => 'Youtube link already exists'
                        ),
                        'youtube_link' => array(
                            'rule' => '/^https:\/\/(?:www\.)?(?:youtube.com|youtu.be)\/(?:watch\?(?=.*v=([\w\-]+))(?:\S+)?|([\w\-]+))$/',
                            'message' => 'Please check Youtube link format.'
                        ),
                )
                
           );
}     