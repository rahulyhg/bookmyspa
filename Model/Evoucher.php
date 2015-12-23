<?php
App::uses('AppModel', 'Model');
class Evoucher extends AppModel {
    public $belongsTo = array('Order');
    public $actsAs = array('Containable');
}