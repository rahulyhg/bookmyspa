<?php
App::uses('AppModel', 'Model');
class AppointmentHistory extends AppModel {
    public $name = 'AppointmentHistory';
    Public $belongsTo = array(
        'Appointment' => array(
            'className'     => 'Appointment',
            'foreignKey'    => 'appointment_id'
        )
    );
}