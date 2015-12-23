<?php
class Group extends AppModel {
    public $actsAs = array('Acl' => array('type' => 'requester'));
    /*public $belongsTo = array('User'=> array(
        'className' => 'User',
        'foreignKey' => 'created_by'
        )
    );*/
    public function parentNode() {
        return null;
    }
    public $validationDomain = 'validation';
    /* Server Side Validations */
   
    public $validate = array(
	'name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'group_name_empty_error',
		    'last' => true,
		),
                'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '100'),
                    'message' => 'maxlength_100'
                ),
                'checkName' => array(
                   'rule' => array('checkName','name'),
                   'message' => 'unique_title',
                   //'on' => 'create', // Limit validation to 'create' or 'update' operations
               )
	    )
    );
    
    function getGroupPermissions($group_id=null) {
        //get permissions
        return $this->find('first',array('fields'=>array('Group.group_permissions'),'conditions'=>array('Group.id'=> $group_id)));
    } 
    
     function checkName($check,$otherfield)
    {
        $this->recursive = -1;
        $cond = array();
        $cond['Group.name']  =  $this->data[$this->name]['name'];
        $userId = AuthComponent::user('id');
        $cond['Group.created_by']  = $userId;
        if(isset($this->data[$this->name]['id']) && !empty($this->data[$this->name]['id'])){
         $cond['NOT'] =  array( 
                        'Group.id' => $this->data[$this->name]['id']
                );
        }
        $title = $this->find('first' ,array('conditions'=>$cond));
        if(count($title)){
            return false;   
        }else{
            return true;
        }
    }

    
    
}