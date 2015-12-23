<?php
App::uses('AppModel', 'Model');
class Contact extends AppModel {
    public $name = 'Contact';
    public $actsAs = array('Containable');
    public $validationDomain = 'validation';
    var $belongsTo = array('User');
      /* Server Side Validations */
   public $validate = array(
              'cell_phone' => array(
		    'notEmpty' => array(
			'rule' => array('notEmpty'),
			'message' => 'phone_empty_error',
		    ),
		      'numeric' => array(
			 'rule' => array('numeric'),
			 'message' => 'phone_invalid_error',
		       ),
			'exists' => array(
			'rule' => array('isUnique_ValidationPhone','cell_phone'),
			'message' => 'Phone Number is already existed.',
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		    )
		      
		//   'minimum'=>array(
		//	 'rule'    => array('minLength', '8'),
		//	 'message' => 'minlength_10',
		//	 'last'=>true,
		//     ),
		),
	);

 
 function isUnique_ValidationPhone($phone = null)
    {
	$request = Router::getRequest(); 
	$parent_id = (isset($request['data']['User']['parent_id']) && !empty($request['data']['User']['parent_id']))?$request['data']['User']['parent_id']:''; 
	if($parent_id){
	    if($request['data']['User']['id']){
		$uid_array  = array($parent_id ,$request['data']['User']['id']);
	     }
	}else{
	     $uid_array =  array($request['data']['User']['id']); 
	}
	if($uid_array){
	    $cond['NOT'] =  array( 
		'User.id' => $uid_array
	    );
        }
	$cond['User.is_deleted'] = 0;
	$cond['Contact.cell_phone'] = $request['data']['Contact']['cell_phone'];
	App::import('model','User');
	$User = new User();
	$countData  = $User->find('count', array('conditions' => $cond));
	if($countData > 0)
	{
	   return false;
	} else {
	    return true;
	}
    }
    
}