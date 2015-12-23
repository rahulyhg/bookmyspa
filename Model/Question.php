<?php    
    class Question extends AppModel {
        var $name = 'Question';        
                
       /* public $validate = array(
        'title' => array(
            'notEmpty'=>array(
                'required'=>true,
                'rule' => array('notEmpty'),
                'message' => 'Title name can not be blank.'
            )
        )
        );
        * 
        */
         var $hasMany = array(
			'answers' => array(
			  'className' => 'Answer',
				'foreignKey' => 'question_id',
				'dependent' => false
			)
		);
       
  /*  public function checkUnique(){
        App::uses('CakeSession', 'Model/Datasource');
        
        if(!empty($this->data['Content']['id'])){
            $data = $this->find('first',array('conditions'=>array('Content.title'=>$this->data['Content']['title'],'Content.id !='=>$this->data['Content']['id'])));
        }else{
            $data = $this->find('first',array('conditions'=>array('Content.title'=>$this->data['Content']['title'])));    
        }
        
        if(!empty($data) && count($data) > 0){
            return false;
        }else{
            return true;
        }
    }
    
    */   
        
    }
?>
