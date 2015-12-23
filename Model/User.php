<?php
App::uses('AppModel', 'Model');
class User extends AppModel {
    
    public $validationDomain = 'validation';
    public $name = 'User';
    
    //public $actsAs = array('Containable', 'Acl' => array('type' => 'requester'));
    public $actsAs = array('Containable','Acl' => array('type' => 'requester','enabled' => false));
    public $belongsTo = array('Group');
    public $hasOne = array('Salon','Address','UserDetail','Contact');
    public $hasMany = array('PricingLevelAssigntoStaff');
    
    
    
    /* Server Side Validations */
    public $validate = array(
	'first_name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'firstname_empty_error',
		    'last' => true,
		),
                'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\' ]*$|',
                    'message' =>'allowed_char_error',
                    'last' => true,
                ),
		'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '55'),
                    'message' => 'maxlength_55'
                )
	    ),
	'last_name' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'lastname_empty_error',
		    'last' => true,
		),
                'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\ ]*$|',
                    'message' =>'allowed_char_error',
                    'last' => true,
                ),
		'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '55'),
                    'message' => 'maxlength_55'
                )
	    ),
	
        'email' => array(
	    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'email_empty_error',
		    'last' => true,
	    ),
	    'email'=>array(
		'rule' => array('email'),
		'message' => 'email_invalid_error',
		'last' => true,
	    ),
	    'maximum'=>array(
		'rule'    => array('maxLength', '100'),
		'message' => 'maxlength_100.',
		'last' => true,
	    ),
	    'isUnique_Validation' => array(
		'rule' => array('isUnique_Validation','email'),
		'message' => 'email_isunique_error',
	    )
	    /*'isUnique' => array(
		'rule' => 'isUnique_Validation',
		'message' => 'email_isunique_error',
	   ) */
	),
	'username' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'username_empty_error',
		    'last' => true,
		),
                'maximum'=>array(
                    'rule'    => array('maxLength', '55'),
                    'message' => 'maxlength_55',
                    'last' => true,
                ),
                'exists' => array(
		    'rule' => array('isUniqueUsername_Validation','username'),
		    'message' => 'Username already existed.',
		)
	 ),
	'parent_id' => array(
	    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'parentid_empty_error',
		    'last' => true,
		)
	    ),
	'site_url' => array(
	    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'siteurl_empty_error',
		    'last' => true,
		),
                'maximum'=>array(
                    'rule'    => array('maxLength', '30'),
                    'message' => 'maxlength_30.',
                    'last' => true,
                ),
                'isUnique' => array(
                    'rule' => 'isUnique',
                    'message' => 'siteurl_isunique_error',
		    'on' => 'create',
               ) 
	    ),
        'password' => array(
            'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'password_empty_error',
		    'last' => true,
		    'on'   => 'create',
		),
	    'minimum'=>array(
                    'rule'    => array('minLength', '8'),
                    'message' => 'minlength_8',
                    'last' => true,
                ),
        ),
        'forget_email'=>array(
	     'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'email_empty_error',
		    'last' => true,
		),
	 'email'=>array(
                    'rule' => array('email',true),
		    'message' => 'email_invalid_error',
		    'last' => true,
                ),
			      ),
	 'confirm_password' => array(
            'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'con_password_empty_error',
		    'last' => true,
		    'on'   => 'create',
		),
	    'minimum'=>array(
                    'rule'    => array('minLength', '8'),
                    'message' => 'minlength_8',
                    'last' => true,
                ),
	     'equaltofield' => array(
		'rule' => array('equaltofield','password'),
		'message' => 'password_unmatch_error.',
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
	),
	 'old_password' => array(
            'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'oldpassword_empty_error',
		    'last' => true,
		),
	    'minimum'=>array(
                    'rule'    => array('minLength', '8'),
                    'message' => 'minlength_8',
                    'last' => true,
                ),
	),
	 
	'old_pass' => array(
            
	   'minimum'=>array(
                    'allowEmpty' => true,
		   'rule'    => array('minLength', '8'),
		   'message' => 'minlength_8',
                    'last' => true,
	       ),
            'checkOldPass' => array(
		'rule' => array('checkOldPass','old_pass'),
		'message' => 'old_password in not correct!!',
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
            
	   ),
        'password1' => array(
	   'minimum'=>array(
                   'allowEmpty' => true,
		   'rule'    => array('minLength', '8'),
		   'message' => 'minlength_8',
	       ),
	   ),
	'con_password'=> array(
	    'minimum'=>array(
                    'allowEmpty' => true,
                    'rule'    => array('minLength', '8'),
                    'message' => 'minlength_8',
                    'last' => true,
                ),
	     'equaltofield' => array(
		'rule' => array('equaltofield','password1'),
		'message' => 'password_unmatch_error.',
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
	),
	 'type' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'usertype_empty_error',
		    'last' => true,
		),
	    ),
//	'terms_n_condition' => array(
//		'notEmpty' => array(
//		    'rule' => array('comparison', '!=', 0),
//                    'message' => 'terms_n_condition_empty_error',
//		    'last' => true,
//		),
//	    ),
    );
   
    function equaltofield($check,$otherfield)
    {
        //get name of field
        $fname = '';
        foreach ($check as $key => $value){
            $fname = $key;
            break;
        }
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname];
    }
    
    function checkOldPass($check,$otherfield)
    {
        $this->recursive = -1;
        $pass = $this->find('first', array('conditions'=>array('User.id'=>$this->data[$this->name]['id']),'fields'=>array('User.password')));
        return AuthComponent::password($this->data[$this->name][$otherfield]) === $pass['User']['password'];
        // echo $this->data[$this->alias]['id']; die('herer'); 
    }
    
    public function beforeSave($options = array()) {
	
        if (!empty($this->data[$this->alias]['password'])) {
	   $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	}
	if (!empty($this->data[$this->alias]['type']) && ( !isset($this->data[$this->alias]['group_id']) && empty($this->data[$this->alias]['group_id']))) {
            if($this->data[$this->alias]['type'] != 5){
		$this->data[$this->alias]['group_id'] = $this->data[$this->alias]['type'];
	    }
        }
        return true;
    }
    
    public function bindNode($user){
        $data = AuthComponent::user();
        return array('model' => 'Group', 'foreign_key' =>$user['User']['group_id']);
    }
    
    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }
    
    function _getSalonlist($userId = null) {
        return $this->find('all', array('conditions' => array('User.parent_id' => $userId)));
    }
    
    
    function _getBusinessOwner($userId = null) {
        return $this->find('first', array('fields' => array('Salon.eng_name', 'User.id', 'User.username'), 'conditions' => array('User.id' => $userId)));
    }
    
    function isUnique_Validation($email = null)
    {
	
	
	if(isset($this->data[$this->name]['id']) && !empty($this->data[$this->name]['id'])){
	    $cond['NOT'] =  array( 
                'User.id' => $this->data[$this->name]['id']
            );
        }
	$cond['User.is_deleted'] = 0;
	$cond['User.email'] = $email;
	$countData  = $this->find('count', array('conditions' => $cond));
	if($countData > 0)
	{
	    return false;
	} else {
	    return true;
	}
    }
   
     function isUniqueUsername_Validation($username = null)
    {
	 if(isset($this->data[$this->name]['id']) && !empty($this->data[$this->name]['id'])){
          $cond['NOT'] =  array( 
                    'User.id' => $this->data[$this->name]['id']
                );
        }
	$cond['User.is_deleted'] = 0;
	$cond['User.username'] = $username;
	$countData  = $this->find('count', array('conditions' => $cond));
	if($countData > 0)
	{
	    return false;
	}
	else
	{
	    return true;
	}
    }
   
   
   
}
