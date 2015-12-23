<?php
/**
 * Subscription Model.
 *
 * This is used to deal with the table subscriptions
 *  
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Navdeep Kaur
 * @copyright     smartData Enterprise Inc.
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         version 0.0.1
 * @version       0.0.1
 */
class Subscription extends AppModel{
    var $name='Subscription';
    
    //validation rules for the fields
    public $validate = array(
            'name'=>array(                 
                'rule1' => array(
                    'required' => true,
                    'rule' => array('notEmpty'),
                    'message' => 'Please enter name.'
                ),
                'unique' => array(
                    'rule' => 'isUnique',
                    'required' => 'create',
                    'message'=>'Name should be unique'
                )
            ),    
            'description' => array(
                'required' => true,
                'rule' => array('notEmpty'),
                'message' => 'Please enter description.'
            ), 
            'frequency' => array(
                'required' => true,
                'rule' => array('notEmpty'),
                'message' => 'Please select frequency.'
            ), 
            'amount' => array(
                'required' => true,
                'rule' => array('notEmpty'),
                'message' => 'Please enter amount.'
            )
            
            
    );

}
?>