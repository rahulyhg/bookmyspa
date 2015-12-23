<?php    
    class PostCommentLike extends AppModel {
			var $name = 'PostCommentLike';
       var $belongsTo = array('PostComment');
		  
	}