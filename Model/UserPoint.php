<?php
App::uses('AppModel', 'Model');
class UserPoint extends AppModel {
    public $name = 'UserPoint';
    var $belongsTo = array('User');
    
}
