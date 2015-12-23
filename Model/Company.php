<?php    
    class Company extends AppModel {
        var $name = 'Company';      
        
        public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => 'notEmpty',                
                'message'    => 'Please enter company name.'                
            ),
            'rule2' => array(
                'rule' => 'checkUnique',                
                'message'    => 'Company Name already exists.'
            )
        ),
        'address' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter valid address.'
        ),       
        'phone_no' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter phone no.'
        ),
        
    );
        
        public function checkUnique(){
            if(!empty($this->data['Company']['id'])){
                $data = $this->find('first',array('conditions'=>array('Company.name'=>$this->data['Company']['name'],'Company.id !='=>$this->data['Company']['id'])));
            }else{
                $data = $this->find('first',array('conditions'=>array('Company.name'=>$this->data['Company']['name'])));    
            }
            
            if(!empty($data) && count($data) > 0){
                return false;
            }else{
                return true;
            }
        }
        
         /*
        * Defining Relationships
        */
        /*public $belongsTo = array(
            'Country' => array(
                'className' => 'Country',
                'fields'    => array('id','name')
            ),
            'State' => array(
                'className' => 'State',
                'fields'    => array('id','name')
            )
        );*/
       
    }
    
?>
