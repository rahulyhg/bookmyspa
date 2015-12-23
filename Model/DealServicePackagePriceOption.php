<?php
App::uses('AppModel', 'Model');
class DealServicePackagePriceOption extends AppModel {
    public $name = 'DealServicePackagePriceOption';
   // public $actsAs = array('Containable');
    public $belongsTo = array('DealServicePackage');
   
 /* Server Side Validations */
    public $validationDomain = 'validation';
   
    
}

