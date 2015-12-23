<?php    
    class SpabreakOption extends AppModel {
        var $name = 'SpabreakOption';
	public $validationDomain = 'validation';
        public $hasMany = array('SpabreakOptionPerday');      
       
        public $belongsTo = array(
            'SalonRoom' => array(
                'className' => 'SalonRoom',
                'foreignKey' => 'salon_room_id'
            )
        );

    }
?>