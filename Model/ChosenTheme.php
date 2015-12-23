<?php
App::uses('AppModel', 'Model');
class ChosenTheme extends AppModel {
    public $name = 'ChosenTheme';
    public $actsAs = array('Containable');
}