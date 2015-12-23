<?php

App::uses('AppModel', 'Model');

class BillingDetail extends AppModel {

    public $validationDomain = 'validation';
    public $name = 'BillingDetail';
   /* public $validate = array(
         'licence_no' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Letters and numbers only'
            )
        ),
        
    );*/

}
