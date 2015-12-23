<?php    
    class Content extends AppModel {
        var $name = 'Content'; 
	public $actsAs = array('Containable');
                
      var $hasMany = array(
            'PostComment' => array(
            'className' => 'PostComment',
            'foreignKey' => 'content_id',
	),);
         public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
      
      
      
	 /*var $hasMany = array(
			'ContentList' => array(
            'className' => 'ContentList',
            'foreignKey' => 'content_id',
				
			),
			'Quiz' => array(
            'className' => 'Quiz',
            'foreignKey' => 'content_id',
			),
			'Poll' => array(
            'className' => 'Poll',
            'foreignKey' => 'content_id',
			),
			'Meme' => array(
            'className' => 'Meme',
            'foreignKey' => 'content_id',
			),
			'Photo' => array(
            'className' => 'Photo',
            'foreignKey' => 'content_id',
			),
			'Lineup' => array(
            'className' => 'Lineup',
            'foreignKey' => 'content_id',
			),
			'Video' => array(
            'className' => 'Video',
            'foreignKey' => 'content_id',
			),
			'Text' => array(
            'className' => 'Text',
            'foreignKey' => 'content_id',
			)
			
		);*/
		
    }
?>
