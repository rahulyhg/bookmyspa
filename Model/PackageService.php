<?php
App::uses('AppModel', 'Model');
class PackageService extends AppModel {
    public $name = 'PackageService';
    public $actsAs = array('Containable');
    
    public $hasMany = array('PackagePricingOption');
    /* Server Side Validations */
    public $validationDomain = 'validation';
    
}