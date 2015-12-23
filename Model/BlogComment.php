<?php 

class BlogComment extends AppModel {
	var $name = 'BlogComment';
	public function beforeSave($options = array()){
	if (empty($this->data[$this->alias]['ara_comment'])){
            $this->data[$this->alias]['ara_comment'] = $this->data[$this->alias]['eng_comment'];
        }
        return true;
    }
     
        
}

?>