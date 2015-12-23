<?php


App::uses('Sanitize', 'Utility');

class AdvertisementsController extends AppController {

    var $name = 'Admins';
    var $components = array('Email','Cookie', 'Common', 'Paginator');

    function beforeFilter() {
        parent::beforeFilter();
    }
    
    function admin_addEdit($id=NULL){
        
        
    }
    
    function admin_index(){
        
    }
    
    function admin_delete(){
        
    }
     
}