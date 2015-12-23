<?php    
    class PostComment extends AppModel {
			var $name = 'PostComment';
       var $belongTo = array('Content',
           'Content' => array('counterCache' => true)
           );
		  var $hasMany = array('PostCommentLike'); 
	}