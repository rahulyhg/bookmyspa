<?php
App::uses('AppModel', 'Model');
class SalonFeaturingSubscriptionPlan extends AppModel {
    
    public $validationDomain = 'validation';
    public $name = 'SalonFeaturingSubscriptionPlan';
    public $belongsTo = array('FeaturingSubscriptionPlan');
} 
