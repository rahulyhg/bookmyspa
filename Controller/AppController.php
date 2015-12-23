<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    var $components = array('RequestHandler', 'Session', 'Auth', 'Acl', 'Cookie');
    var $helpers = array('Form', 'Html','Session', 'Js', 'Common','Minify.Minify');
    
    public function beforeFilter() {
	date_default_timezone_set('Asia/Dubai');
	
	$this->_setLanguage();
        if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin'){
             Configure::write('Config.language','eng');
             $this->Session->write('Config.language','eng');
        }
	
	if($this->params['controller'] == 'Place' && ($this->params['action'] == 'salonservices' || $this->params['action'] == 'salonpackages' || $this->params['action'] == 'ajax_services' || $this->params['action'] == 'salonspaday' || (isset($this->params['requested']) && $this->params['requested'] = 1 ))){
	}else{
	   $this->Session->delete('FRONT_SESSION');    
	}
        if(!(isset($this->params['requested']) && $this->params['requested'] = 1)){
            $this->getLastReferer();
        }
        $this->_checkAuth();
        $lang = Configure::read('Config.language');
        $this->set(compact('lang')); 
    }
  
    function _setLanguage(){
        if ($this->Session->read('Config.language')){
            $sLang = $this->Session->read('Config.language');
            if(isset($this->params['named']['language']) && !empty($this->params['named']['language'])){
                $pLang = $this->params['named']['language'];
                if($sLang != $pLang){
                    $this->Session->write('Config.language', $pLang);
                    Configure::write('Config.language',$pLang);
                }
            }else{
                Configure::write('Config.language',$sLang);
            }
        }else{
            if(isset($this->params['named']['language']) && !empty($this->params['named']['language'])){
                $pLang = $this->params['named']['language'];
                Configure::write('Config.language',$pLang);
                $this->Session->write('Config.language',$pLang);
            }
            else{
                Configure::write('Config.language','eng');    
            }
        }
    }

    public function beforeRender(){
        if ($this->Auth->user()) {
	    $authUser = $this->authUser();
            $this->set('auth_user',$authUser);
        }
	$this->response->disableCache();
        $this->set('loggedIn',$this->Auth->loggedIn());
    }
    
/**********************************************************************************    
  @Function Name : _checkAuth
  @Params	 : NULL
  @Description   : Login Auth
  @Author        : Aman Gupta
  @Date          : 07-Nov-2014
***********************************************************************************/
    public function _checkAuth() {
        
        $this->Auth->authenticate = array(
            'Form' => array('fields' => array(
                    'username' => 'username',
                    'password' => 'password'
                ),
                'scope' => array('User.status' => 1),
                'userModel' => 'User'
            )
        );
        $this->Auth->loginAction = array(
            'controller' => 'homes',
            'action' => 'index',
            'admin'=>false
        );
        $this->Auth->loginRedirect = array(
            'controller' => 'homes',
            'action' => 'index',
            'admin' => false
        );
        $this->Auth->logoutRedirect = array(
            'controller' => 'homes',
            'action' => 'index',
            'admin' => false
        );
        //$this->Auth->authError = 'Invalid Request';      
        $this->Auth->authorize = array('Actions' => array('actionPath' => 'controllers'));
        $this->Auth->autoRedirect = false;
    }
    
    
    
    
/** ********************************************************************************    
    @Function Name : authUser
    @Params	    : NULL
    @Description   : For the Details of the User
    @Author        : Aman Gupta
    @Date          : 10-Nov-2014
********************************************************************************* */


    public function authUser() {
        $this->loadModel('User');
        $authUser = $this->User->findById($this->Auth->user('id'));
        if(isset($authUser['User']))
	  return $authUser;
    }
    
    /**********************************************************************************    
  @Function Name : findallCustomerList
  @Params	 : NULL
  @Description   : Returns users customer list for dropdown type 6
  @Author        : Aman Gupta
  @Date          : 04-Dec-2014
***********************************************************************************/
    public function findallCustomerList(){
        App::import('Model','User');
        $this->User = new User();
        
         $cond = array('User.type'=>Configure::read('USER_ROLE'));
        $userType = $this->Auth->user('type');
        if($userType != Configure::read('SUPERADMIN_ROLE')){
            $cond = $this->mergingCond4UserType($cond);
        }
        //$cond = $this->mergingCond4UserType($cond);
        
        $userLists = $this->User->find('all',array('fields'=>array('User.id','User.email','User.first_name','User.last_name'),'conditions'=>$cond));
        $userData = array();
        if(!empty($userLists))
            foreach($userLists as $userList){
                $userData[base64_encode($userList['User']['id'])] = ucfirst($userList['User']['first_name']).' '.ucfirst($userList['User']['last_name'])." (".$userList['User']['email'].")";
            }
        return $userData;
    }
    
    function getLastReferer(){
        if($this->request->is('ajax')){
            if($this->params['controller'] == 'Place' && ($this->params['action'] == 'salonservices' || $this->params['action'] == 'salonpackages' || $this->params['action'] == 'salonspaday' || $this->params['action'] == 'spabreaks' || $this->params['action'] == 'salondeals' || $this->params['action'] == 'salonStaff' || $this->params['action'] == 'salongallery' || $this->params['action'] == 'salongiftcertificate')){
                $urlVisisted = Router::url($this->here, true);
                $this->Session->write('lastVisited', $urlVisisted);
            }
        }else{
             $this->Session->delete('lastVisited');
        }
    }
    
    
}

   
