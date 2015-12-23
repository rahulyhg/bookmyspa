<?php
App::uses('AppModel', 'Model');
class Order extends AppModel {
    public $belongsTo = array('SalonService');
    public $hasMany = array('OrderDetail','Appointment');
    public $actsAs = array('Containable');
}