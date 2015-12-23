<?php

App::uses('AppModel', 'Model');

class GiftCertificate extends AppModel {

    public $name = 'GiftCertificate';
    public $validationDomain = 'validation';
    public $belongsTo = array('GiftImageCategory','GiftImage');
    
    /* Server Side Validations */
    public $validate = array(
        'first_name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'First name cannot be empty',
                'last' => true,
            ),
            'allowedCharacters' => array(
                'rule' => '|^[A-Z,a-z\' ]*$|',
                'message' => 'allowed_char_error',
                'last' => true,
            ),
            'minimum' => array(
                'rule' => array('minLength', '3'),
                'message' => 'Minimum 3 characters',
                'last' => true,
            ),
            'maximum' => array(
                'rule' => array('maxLength', '30'),
                'message' => 'Maximum 30 characters'
            )
        ),
        'last_name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Last name cannot be empty',
                'last' => true,
            ),
            'allowedCharacters' => array(
                'rule' => '|^[A-Z,a-z\ ]*$|',
                'message' => 'allowed_char_error',
                'last' => true,
            ),
            'minimum' => array(
                'rule' => array('minLength', '3'),
                'message' => 'Minimum 3 characters',
                'last' => true,
            ),
            'maximum' => array(
                'rule' => array('maxLength', '30'),
                'message' => 'Maximum 30 characters'
            )
        ),
        'sender_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Sender cannot be empty',
                'last' => true,
            ),
        ),
         'recipient_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Recepient cannot be empty',
                'last' => true,
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Email cannot be empty',
                'last' => true,
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Invalid email',
                'last' => true,
            ),
            'maximum' => array(
                'rule' => array('maxLength', '100'),
                'message' => 'Maximum 100 characters.',
                'last' => true,
            ),
            //'isUnique' => array(
            //    'rule' => 'isUnique',
            //    'message' => 'email_isunique_error',
            //)
        ),
        'gift_certificate_no' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'No cannot be empty',
                'last' => true,
            ),                        
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'No is not unique',
            )
        ),
        'messagetxt' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Message cannot be empty',
                'last' => true,
            ),
        ),
        'amount' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Amount cannot be empty',
                'last' => true,
            ),
        ),

    );

    public function beforeSave($options = array()) {
         //pr($this->data);
        //exit;
        if (isset($this->data[$this->alias]['amount']) && empty($this->data[$this->alias]['total_amount'])) {
            if($this->data[$this->alias]['id']){
              $giftData = $this->findById($this->data[$this->alias]['id']);   
                if($giftData['GiftCertificate']['payment_status']==0 || $giftData['GiftCertificate']['payment_status']==2){
                   $this->data[$this->alias]['total_amount'] = $this->data[$this->alias]['amount'];
                }
            }else{
              $this->data[$this->alias]['total_amount'] = $this->data[$this->alias]['amount'];  
            }
         }
        return true;
    }
    
    
}
