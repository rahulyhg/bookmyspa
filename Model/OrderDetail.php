<?php
App::uses('AppModel', 'Model');
class OrderDetail extends AppModel {
    public $belongsTo = array('Order');
    public $actsAs = array('Containable');
}