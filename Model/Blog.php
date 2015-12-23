<?php
App::uses('AppModel', 'Model');
    class Blog extends AppModel {
	
	public $validationDomain = 'validation';
        public $name = 'Blog';
	public $hasMany = array(
        'BlogComment' => array(
            'className' => 'BlogComment',
            'foreignKey' => 'blog_id'
         )
    );
 
    /* Server Side Validations */
   
    public $validate = array(
//	'alias' => array(
//		'notEmpty' => array(
//		    'rule' => array('notEmpty'),
//		    'message' => 'alias_empty_error',
//		    'last' => true,
//		),
//               'minimum'=>array(
//                    'rule'    => array('minLength', '3'),
//                    'message' => 'minlength_3.',
//		    'last'=>true,
//                ),
//                'maximum'=>array(
//                    'rule'    => array('maxLength', '200'),
//                    'message' => 'maxlength_200'
//                )
//             ),
        'eng_title' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'title_empty_error',
		    'last' => true,
		),
                'allowedCharacters'=> array(
                    'rule' => '|^[A-Z,a-z\ ]*$|',
                    'message' =>'letters_only_error',
                    'last' => true,
                ),
		'minimum'=>array(
                    'rule'    => array('minLength', '3'),
                    'message' => 'minlength_3',
		    'last'=>true,
                ),
                'maximum'=>array(
                    'rule'    => array('maxLength', '200'),
                    'message' => 'maxlength_200'
                )
	    ),
        'eng_description' => array(
		'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'description_empty_error',
		    'last' => true,
		),
	    ),
        'status' => array(
                    'notEmpty' => array(
		    'rule' => array('notEmpty'),
		    'message' => 'status_empty_error',
		    'last' => true,
		)
	    ),
	'category' => array(
                    'notEmpty' => array(
		    'rule' => array('multiple'),
		    'message' => 'category_empty_error',
		    'last' => true,
		)
	    ),
	'image' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'image_empty_error',
                'last' => true,
            )
        ),
    );

    public function beforeSave($options = array()){
        if (empty($this->data[$this->alias]['ara_title'])){
            $this->data[$this->alias]['ara_title'] = $this->data[$this->alias]['eng_title'];
        }
        if (empty($this->data[$this->alias]['ara_description'])){
            $this->data[$this->alias]['ara_description'] = $this->data[$this->alias]['eng_description'];
        }
        return true;
    }
     
    
}