<?php

/*
 * Homes Controller class
 * Functionality -  Manage the Home Page
 * Developer - Gurpreet Singh Ahhluwalia
 * Created date - 20-Feb-2014
 * Modified date - 
 */

class PollsController extends AppController{
    var $name = 'Homes';
    public $components = array('Paginator', 'Common');
    var $helpers = array('Common');
    public $uses = array('Content');

    function beforeFilter(){
        parent::beforeFilter();
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    function __checkContentId($content_id = NULL) {
        if (empty($content_id)) {
            $new_content['Content']['status'] = 0;
            $this->Content->create();
            $this->Content->save($new_content);
            $content_id = $this->Content->getLastInsertId();
        } else {
            $content_id = $content_id;
        }
        return $content_id;
    }

    /*
     * index function
     * Functionality -  Home Page
     * Developer - Gurpreet Singh Ahhluwalia
     * Created date - 20-Feb-2014
     * Modified date - 
     */

    function index(){
        $this->layout = 'index';
        $this->set('title_for_layout', 'Footybase');
    }

    /*
     * index function
     * Functionality -  Ajax Form save 
     * Developer - Sanjeev kanungo
     * Created date - 29 Aug,2014
     * Modified date - 
     */

    function insertPoll(){
        $this->autoRender = FALSE;
        $this->loadModel('Poll');
        $this->loadModel('PollAnswer');
        $this->loadModel('PollQuestion');
        if ($this->request->is(array('put', 'post'))) { //echo '<pre>'; print_r($this->request->data); die();
            $content_id = $this->__checkContentId($this->request->data['content_id']);
            $data = $this->request->data['Poll'];
            $posted_poll_id = $data['poll_id'];
            if(!empty($posted_poll_id)) {
                if (isset($data)) {
                    if (is_array($data['question']['image'])){
                        $field = "image";
                        $location = "img/Cat_Poll_Question";
                        $folder_name = 'original';
                        $multiple[] = array('folder_name' => 'thumb', 'height' => '100', 'width' => '100');
                        // Code to upload the image
                        $poll_image = $this->Common->upload_image($data['question']['image'], $location, $folder_name, true, $multiple);
                    } else {
                        $poll_image = 'default';
                    }
                     $edit_poll_question_id = $data['question']['id'];
                     $data['id'] = $edit_poll_question_id;   
                     $data['question'] = $data['question']['title'];
                     $data['image'] = $poll_image;   
                    $result = $this->PollQuestion->save($data);
                     if($result){
                            $poll_answer = $data['answers'];
                            $location = "img/Cat_Poll_Answer";
                            foreach ($poll_answer as $poll_key  => $poll_value){
                                if(is_array($poll_value['image'])){
                                   $poll_image = $this->Common->upload_image($poll_value['image'], $location, $folder_name, true, $multiple);
                                   
                                }else{
                                $poll_image = 'default';  
                                }
                                $poll_data['PollAnswer']['id'] = $poll_value['id'];
                                $poll_data['PollAnswer']['answer'] = $poll_value['title'];
                                $poll_data['PollAnswer']['image'] =  $poll_image;
                               
                                $this->PollAnswer->save($poll_data);
                                
                            } 
                            $return_array = array(
                             'content_id' => $content_id,
                            'poll_id' => $posted_poll_id,
                            );     
                            echo json_encode($return_array);
                        }else{
                            $return_array = array(
                            'error' =>'problem in saving the data'
                        
                        );
                             echo json_encode($return_array);
                        }
                        
                    
                    
                }
            }else {
                if (is_array($data['question']['image'])){
                        $field = "image";
                        $location = "img/Cat_Poll_Question";
                        $folder_name = 'original';
                        $multiple[] = array('folder_name' => 'thumb', 'height' => '100', 'width' => '100');
                        // Code to upload the image
                        $poll_image = $this->Common->upload_image($data['question']['image'], $location, $folder_name, true, $multiple);
                    } else {
                        $poll_image = 'default';
                    }
                    $data['content_id'] = $content_id;
                    $this->Poll->save($data);
                    $poll_id = $this->Poll->getLastInsertId();
                    if($poll_id) {
                        $data['polls_id'] = $poll_id;
                        $data['question'] = $data['question']['title'];
                        $data['image'] = $poll_image;
                        
                        $this->PollQuestion->save($data);
                        $poll_question_id = $this->PollQuestion->getLastInsertId();
                        if($poll_question_id){
                            $poll_answer = $data['answers'];
                            $location = "img/Cat_Poll_Answer";
                            foreach ($poll_answer as $poll_key  => $poll_value){
                                if(is_array($poll_value['image'])){
                                   $poll_image = $this->Common->upload_image($poll_value['image'], $location, $folder_name, true, $multiple);   
                                }else{
                                $poll_image = 'default';  
                                }
                                $poll_data['PollAnswer']['poll_questions_id'] = $poll_question_id;
                                $poll_data['PollAnswer']['answer'] = $poll_value['title'];
                                $poll_data['PollAnswer']['image'] =  $poll_image;
                                $this->PollAnswer->create();
                                $this->PollAnswer->save($poll_data);
                                
                            } 
                            $return_array = array(
                             'content_id' => $content_id,
                            'poll_id' => $poll_id,
                            );     
                            echo json_encode($return_array);
                        }else{
                            $return_array = array(
                            'error' =>'problem in saving the data'
                        
                        );
                             echo json_encode($return_array);
                        }
                        
                    }
                    
                }
            
            }
        }
    
    public function fetch_polls(){
        $this->autoRender = FALSE;
         $this->loadModel('Poll');
        //$params = $this->request->data;
        $datasets = array();
        $params['id'] = 15;
        if(isset($params['id']) && !empty($params['id'])){
            $id = $params['id'];
            $this->Poll->Behaviors->load('Containable');
            $conditions = array('Poll.id' => $id);
            $contain = array(
                    'PollQuestion' => array('fields' => array('id', 'question', 'image'),
                    'PollAnswer' => array('fields' => array('id', 'answer','image')),
                )
            );
            $datasets = $this->Poll->find('first', array(
                'contain' => $contain,
                'conditions' => $conditions,
            ));
           //pr($datasets); die;
        }
        $view = new View($this, false);
        
        $content = $view->element('poll_modal', array('datasets' => $datasets, 'id' => $id));
        echo $content;
        die;
    }
    
    function insertMeme(){
        $this->autoRender = FALSE;
        $this->loadModel('Meme');
        $this->loadModel('MemeImage'); 
        if ($this->request->is(array('put', 'post'))) { 
            $content_id = $this->__checkContentId($this->request->data['content_id']);
           $data['content_id'] = $content_id;
            $this->Meme->save($data);
            $meme_id = $this->Meme->getLastInsertId();
            if (is_array($_FILES['file'])){
                    $field = "image";
                    $location = "img/meme";
                    $folder_name = 'original';
                    $multiple[] = array('folder_name' => 'thumb', 'height' => '100', 'width' => '100');
                    // Code to upload the image
                    $meme_image = $this->Common->upload_image($_FILES['file'], $location, $folder_name, true, $multiple);
                     $data['image'] = $meme_image;
                    $data['author'] = 'user';
                    $data['user_id'] = $this->Session->read('UserInfo.id');
                    
                    $this->MemeImage->save($data);
                     $meme_image_id = $this->MemeImage->getLastInsertId();
                     
                     $return_array = array(
                        'content_id' => $content_id,
                        'meme_id' => $meme_id,
                        'meme_image_id' => $meme_image_id,
                        'image' => $meme_image,
                    );
                    echo json_encode($return_array);
                }else {
                        $return_array = array(
                            'error' => 'problem in saving the data'
                        );
                        echo json_encode($return_array);
                    } 
                
                }
                
                
            }
        
    public function fetch_meme(){
         $this->autoRender = FALSE;
         $this->loadModel('MemeImage');
         
         $id = '';
        //$params = $this->request->data;
        $datasets = array();
        $user_id = $this->Session->read('UserInfo.id');
        $user_conditions = array('MemeImage.author' => 'user', 'MemeImage.user_id' => $user_id);
        $user_meme = $this->MemeImage->find('all', array(
           
            'conditions' => $user_conditions
        ));
       
       $datasets['user'] =$user_meme; 
        $admin_conditions = array('MemeImage.author' => 'admin');
        $admin_meme = $this->MemeImage->find('all', array(
            'conditions' => $admin_conditions
        )); 
       
       $datasets['admin'] = $admin_meme; 
        
      //pr($datasets); die;
       
        $view = new View($this, false);
        
        $content = $view->element('meme_modal', array('datasets' => $datasets, 'id' => $id));
        echo $content;
        die;
    }
    
    function save_image_text(){
         $this->loadModel('Meme');
         $this->autoRender = FALSE;
         debug($_POST);
         $data['meme_image_ID'] = $this->request->data['meme_image_ID'];
         $data['header_text'] = $this->request->data['upper_text'];
         $data['footer_text'] = $this->request->data['lower_text'];
        
         $this->Meme->save($data);
         exit;
    }
    
    function test_text(){
      $this->layout='index';  
        
    }
}
