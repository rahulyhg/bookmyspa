<?php
App::uses('AppModel', 'Model');
class PackageDealService extends AppModel {
    public $name = 'PackageDealService';
    public $actsAs = array('Containable');
    
    public $hasMany = array('PackageDealPricingOption');
    /* Server Side Validations */
    public $validationDomain = 'validation';
    
}