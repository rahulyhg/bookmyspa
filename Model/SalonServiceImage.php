<?php
App::uses('AppModel', 'Model');
    class SalonServiceImage extends AppModel {
        public $name = 'SalonServiceImage';
	public $validationDomain = 'validation';
	//var $virtualFields = array(
	//    'brand_count' => 'COUNT(SalonServiceImage.salon_service_id)'
	//);
    }