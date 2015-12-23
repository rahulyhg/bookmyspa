<?php

/*
 * Homes Controller class
 * Functionality -  Manage the Home Page
 * Developer - Gurpreet Singh Ahhluwalia
 * Created date - 20-Feb-2014
 * Modified date - 
 */

App::uses('File', 'Utility');

  class HomesController extends AppController {

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

    
        function __checkContentId($content_id = NULL){
           if (empty($content_id)) {
            $new_content['Content']['status'] = 0;
            $new_content['Content']['user_id'] = $this->Session->read('UserInfo.id');
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

        function slide(){
        //pr($this->request->data); die;
        $this->autoRender = FALSE;
        //$this->loadModel('Content');
        $query_type ='';
        $box_text = '';
        $this->loadModel('Slide');
        $this->loadModel('SlideItem');
        if ($this->request->is(array('put', 'post'))) {
                /* check for Content is created or need to create */
                $content_id = $this->__checkContentId($this->request->data['content_id']);
                /* check for List  is created or need to create */
                if (empty($this->request->data['Slide']['slide_id'])) {
                $new_list['Slide']['content_id'] = $content_id;
                /* Assocaite list with Content */
                $this->Slide->create();
                $this->Slide->save($new_list);
                $slide_id = $this->Slide->getLastInsertId();
                $query_type = 'insert';
                } else {
                $slide_id = $this->request->data['Slide']['slide_id'];
                $this->SlideItem->deleteAll(array('slide_id' => $slide_id), false);
                $query_type = 'update';
                }
            /* Save the slide items */
            $data = $this->request->data;
            $i = 0;
            foreach ($data['Slide']['title'] as $title){
                if ($i == 0) {
                    $box_text = @$title;
                }
                $newdata['slide_id'] = $slide_id;
                $newdata['title'] = $title;
                $newdata['image'] = $data['Slide']['image'][$i];
                $newdata['caption'] = $data['Slide']['caption'][$i];
                $newary[] = $newdata;
                $i++;
            }
            foreach ($newary as $slidedata){
                $slideitem['SlideItem'] = $slidedata;
                $this->SlideItem->create();
                $this->SlideItem->save($slideitem);
            }
            $return_array = array(
                'content_id' => $content_id,
                'slide_id' => $slide_id,
                'query_type' => $query_type,
                'box_text' => $box_text,
                 );
            // pr($return_array); die;
          return json_encode($return_array);
        }
    }

    /*
     * List insert Update function
     * Functionality -  Ajax Form save 
     * Developer - Sanjeev kanungo
     * Created date - 29 Aug,2014
     * Modified date - 
     */

    function lists(){
        //pr($this->request->data); die;
        $this->autoRender = FALSE;
        //$this->loadModel('Content');
        $query_type = '';
        $box_text = '';
        $this->loadModel('List');
        $this->loadModel('ListsItem');
        if ($this->request->is(array('put', 'post'))) {
            /* check for Content is created or need to create */
            $content_id = $this->__checkContentId($this->request->data['content_id']);
            /* check for List  is created or need to create */
            if (empty($this->request->data['List']['lists_id'])){
                $new_list['List']['content_id'] = $content_id;
                /* Assocaite list with Content */
                $this->List->create();
                $this->List->save($new_list);
                $list_id = $this->List->getLastInsertId();
                $query_type = 'insert';
                } else {
                $list_id = $this->request->data['List']['lists_id'];
                $this->ListsItem->deleteAll(array('lists_id' => $list_id), false);
                $query_type = 'update';
            }
            /* Save the list items */
            $data = $this->request->data;
            $i = 0;
            /* Save the Listem items   * */
            foreach ($data['List']['title'] as $title){
                if ($i == 0){
                    $box_text = @$title;
                }
                $newdata['lists_id'] = $list_id;
                $newdata['title'] = $title;
                $newdata['image'] = $data['List']['image'][$i];
                $newdata['caption'] = $data['List']['caption'][$i];
                $newary[] = $newdata;
                $i++;
            }
            foreach ($newary as $listdata){
                $listitem['ListsItem'] = $listdata;
                $this->ListsItem->create();
                $this->ListsItem->save($listitem);
            }
            $return_array = array(
                'content_id' => $content_id,
                'list_id' => $list_id,
                'query_type' => $query_type,
                'box_text' => $box_text,
            );
            // pr($return_array); die;
            return json_encode($return_array);
        }
    }

    /*
     * Quiz insert  function
     * Functionality -  Ajax Form save 
     * Developer - Sanjeev kanungo
     * Created date - 3 Sep,2014
     * Modified date - 
     */

    function insertQuiz(){
        //pr($this->request->data);die;
        $box_text = $query_type = "";
        $this->autoRender = FALSE;
        $this->loadModel('Quiz');
        $this->loadModel('QuizAnswer');
        $this->loadModel('QuizQuestion');
        if ($this->request->is(array('put', 'post'))) {
            $content_id = $this->__checkContentId($this->request->data['content_id']);
            /* storing the quiz data */
            if(empty($this->request->data['Quiz']['quiz_id'])) {
                $this->request->data['Quiz']['dataset']['content_id'] = $content_id;
                $box_text = $this->request->data['Quiz']['dataset']['title'];
                $new_quiz['Quiz'] = $this->request->data['Quiz']['dataset'];
                /* Assocaite list with Content */
                $this->Quiz->create();
                $this->Quiz->save($new_quiz);
                $quiz_id = $this->Quiz->getLastInsertId();
                $query_type = 'insert';
            } else {
                $box_text = $this->request->data['Quiz']['dataset']['title'];
                $new_quiz['Quiz'] = $this->request->data['Quiz']['dataset'];
                /* Assocaite list with Content */
                $quiz_id = $this->request->data['Quiz']['quiz_id'];
                $this->Quiz->id = $quiz_id;
                $this->Quiz->save($new_quiz);
                $this->QuizQuestion->deleteAll(array('quiz_id' => $quiz_id), false);
                $query_type = 'update';
            }
            if ($quiz_id) {
                $quiz_questions = $this->request->data['Quiz']['QuizQuestions'];
                if (is_array($quiz_questions)){
                        foreach ($quiz_questions as $que_ans){
                        $quizQuestion['QuizQuestion'] = $que_ans['question'];
                        $quizQuestion['QuizQuestion']['quiz_id'] = $quiz_id;
                        $this->QuizQuestion->create();
                        $this->QuizQuestion->save($quizQuestion);
                        $quiz_question_id = $this->QuizQuestion->getLastInsertId();
                        /*  Save the answers */
                        foreach ($que_ans['answers'] as $quiz_answer) {
                            $quiz_answer['QuizAnswer']['image'] = $quiz_answer['image'];
                            $quiz_answer['QuizAnswer']['answer'] = $quiz_answer['title'];
                            $quiz_answer['QuizAnswer']['right_answer'] = (isset($quiz_answer['right_answer']))?$quiz_answer['right_answer']:'0';
                            $quiz_answer['QuizAnswer']['quiz_questions_id'] = $quiz_question_id;
                            $this->QuizAnswer->create();
                            $this->QuizAnswer->save($quiz_answer);
                        }
                    }
                }
                $return_array = array(
                    'content_id' => $content_id,
                    'quiz_id' => $quiz_id,
                    'query_type' => $query_type,
                    'box_text' => $box_text,
                    );
                echo json_encode($return_array);
            } else {
                $return_array = array(
                    'error' => 'problem in saving the data'
                );
                echo json_encode($return_array);
            }
        }
        // $this->request->data;
    }

    /*
     * Quiz update function
     * Functionality -  Ajax Form update 
     * Developer - Sanjeev kanungo
     * Created date - 03 Sep,2014
     * Modified date - 
     */

    function insertPoll() {
        $box_text = $query_type = "";
        $this->autoRender = FALSE;
        $this->loadModel('Poll');
        $this->loadModel('PollAnswer');
        $this->loadModel('PollQuestion');
        //pr($this->request->data); die;
        if ($this->request->is(array('put', 'post'))) {
            $content_id = $this->__checkContentId($this->request->data['content_id']);
            if (empty($this->request->data['Poll']['poll_id'])) {
                $this->request->data['Poll']['content_id'] = $content_id;
                $new_poll['Poll'] = $this->request->data['Poll'];
                /* Assocaite list with Content */
                $this->Poll->create();
                $this->Poll->save($new_poll);
                $poll_id = $this->Poll->getLastInsertId();
                $query_type = 'insert';
            } else {
                $poll_id = $this->request->data['Poll']['poll_id'];
                $this->PollQuestion->deleteAll(array('polls_id' => $poll_id), false);
                $query_type = 'update';
            }
            /* saveing the poll questions */
            if (!empty($poll_id)) {
                $pollquestion['PollQuestion'] = $this->request->data['Poll']['question'];
                $pollquestion['PollQuestion']['polls_id'] = $poll_id;
                $pollquestion['PollQuestion']['question'] = $this->request->data['Poll']['question']['title'];
                $box_text = $this->request->data['Poll']['question']['title'];
//pr($pollquestion);
                $this->PollQuestion->create();
                $this->PollQuestion->save($pollquestion);
                $poll_question_id = $this->PollQuestion->getLastInsertId();
                if (!empty($poll_question_id)) {
                    $poll_answer = $this->request->data['Poll']['answers'];
                    if (is_array($poll_answer)) {
                        foreach ($poll_answer as $ans) {
                            $data['PollAnswer'] = $ans;
                            $data['PollAnswer']['poll_questions_id'] = $poll_question_id;
                            $data['PollAnswer']['answer'] = $ans['title'];
                            $this->PollAnswer->create();
                            $this->PollAnswer->save($data);
                        } 
                    }
                }
                $return_array = array(
                    'content_id' => $content_id,
                    'poll_id' => $poll_id,
                    'query_type' => $query_type,
                    'box_text' => $box_text,
                );
                // pr($return_array); die;
                return json_encode($return_array);
            } else {
                $return_array = array(
                    'error' => 'problem in saving the data'
                );
                echo json_encode($return_array);
            }
        }
    }

    function upload_image($data, $model, $field, $location){
            $this->request->data = $data;
            if (isset($this->request->data[$model][$field]) && count($this->request->data[$model][$field])) {
            foreach ($this->request->data[$model][$field] as $img) {
// Variable declaration
                $folder_name = 'original';
                $multiple[] = array('folder_name' => 'thumb', 'height' => '100', 'width' => '100');
// Code to upload the image
                $response = $this->Common->upload_image($img, $location, $folder_name, true, $multiple);
// check if filename return or error return
                $is_image_error = $this->Common->is_image_error($response);
                if ($response == 'exist_error') {
                    $this->Session->setFlash($is_image_error, 'error');
//return false;
                } elseif ($response == 'size_mb_error') {
                    $this->Session->setFlash($is_image_error, 'error');
//return false;
                } elseif ($response == 'type_error') {
                    $this->Session->setFlash($is_image_error, 'error');
//return false;	
                }
                $images[] = $response;
            }
        }
        return $images;
    }

    function text(){
        $text_id = $box_text = $query_type = "";
        $this->autoRender = false;
        $this->loadModel('Text');
        if ($this->request->is(array('put', 'post'))) {
            $content_id = $this->__checkContentId($this->request->data['content_id']);
            //$data['content_id'] = $content_id;
            if($this->request->data['Text']['text_id'] != '') {
                $text_id = $this->request->data['Text']['text_id'];
                $this->Text->id = $text_id;
            }
            $this->request->data['Text']['content_id'] = $content_id;
            $this->Text->save($this->request->data);
            $text_id = ($text_id != '') ? $text_id : $this->Text->getLastInsertId();

            $box_text = substr($this->request->data['Text']['text'], 0, 20);
            $query_type = ($this->request->data['Text']['text_id'] != '') ? 'update' : 'insert';
            $return_array = array(
                'content_id' => $content_id,
                'text_id' => $text_id,
                'query_type' => $query_type,
                'box_text' => $box_text,
            );
            // pr($return_array); die;
            return json_encode($return_array);
        } else {
            $return_array = array(
                'error' => 'problem in saving the data'
            );
            echo json_encode($return_array);
        }
        die;
    }

    /* Developer Sajeev  
     * Date :9,sep-2014
     */

    function insertPhoto(){
        $this->autoRender = FALSE;
        $field = "image";
        $location = "img/photos";
        $folder_name = 'original';
         if($this->is_valid_type($_FILES['file']['tmp_name'])){
        $multiple[] = array('folder_name' => 'thumb', 'height' => '191', 'width' => '236');
        $response = $this->Common->upload_image($_FILES['file'], $location, $folder_name, true, $multiple);
        $this->loadModel('Photo');
        $content_id = $this->__checkContentId($this->request->data['content_id']);
        //$data['content_id'] = $content_id;
        $image = $response;
        $photo['Photo']['image'] = $image;
        $photo['Photo']['image_type'] = 'file';
        $photo['Photo']['content_id'] = $content_id;
        $this->loadModel('Photo');
        $this->Photo->create();
        $image_id = $this->Photo->getLastInsertId();
        echo json_encode(array('image_id' => $image_id, 'image' => $image, 'content_id' => $content_id));
         }else{
            $return_array = array(
                        'error' => 'Only image type "jpg|gif|png|jpeg"  are allowed!'
                        );
                        echo json_encode($return_array);  
         }
        die;
    }

    function insertPhotoUrl() {
        //pr($this->request->data); die;
        $content_id = $this->__checkContentId($this->request->data['content_id']);
        //$data['content_id'] = $content_id;
        $image = $photo['Photo']['image'] = $this->request->data['content_url'];
        $photo['Photo']['image_type'] = 'url';
        $photo['Photo']['content_id'] = $content_id;
        $this->loadModel('Photo');
        $this->Photo->create();
        if ($this->Photo->save($photo)) {
            $image_id = $this->Photo->getLastInsertId();
            echo json_encode(array('image_id' => $image_id, 'content_id' => $content_id));
        }
        die;
    }

    function insertVideo(){
        $video_id = $box_text = $query_type = "";        
        //pr($this->request->data); die;
        $this->loadModel('Video');
        $this->autoRender = false;
        $content_id = $this->__checkContentId($this->request->data['content_id']);
        if($this->request->data['video_id'] != '') {
                $video_id = $this->request->data['video_id'];
                $this->Video->id = $video_id;
        } 
        $video['Video']['video_url'] = $this->request->data['content_url'];
        $title = $this->request->data['title'];
        $video['Video']['title'] = $title;
        $video['Video']['content_id'] = $content_id;
        $string = (strlen($title) > 30) ? substr($title,0,27).'...' : $title;
        $query_type = (!empty($video_id)) ? 'update' : 'insert';
        //$this->Video->create();
        if($this->Video->save($video)){
            $thumb_url = $this->check_thumb($this->request->data['content_url']);
            $video_id = (!empty($video_id))?$video_id:$this->Video->getLastInsertId();
            return json_encode(array('video_id' => $video_id, 'content_id' => $content_id,'thumb'=>$thumb_url,'title'=>$string,'query_type' => $query_type));
            die;
        }
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
           if($this->is_valid_type($_FILES['file']['tmp_name'])){
           if($this->is_valid_dimensions($_FILES['file']['tmp_name'])){
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
                        }else{
                        $return_array = array(
                            'error' => 'Image height should be greater than 450px and width should be greater than 325px'
                        );
                        echo json_encode($return_array); 
                        }}else {
                        $return_array = array(
                            'error' => 'Only image type "jpg|gif|png|jpeg"  are allowed!'
                        );
                        echo json_encode($return_array);
                    } 
                
                }
            }

    
    function is_valid_type($file)
    {
    $this->autoRender  = false;    
    $size = @getimagesize($file);
    if(!$size) {
        return 0;
    }
    $valid_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
    if(in_array($size[2],  $valid_types)) {
        return 1;
    } else {
        return 0;
    }
    }
    
    function is_valid_dimensions($file)
    {
    $reqwidth="325";
    $reqHeight="450";
    list($imageWidth, $imageHeight, $type, $attr) = getimagesize($file);
    if($imageWidth >= $reqwidth && $imageHeight >= $reqHeight) {
       return TRUE;  
    }else{
      return FALSE;  
    }
    }
    
    
//    function insertMeme(){
//        $this->autoRender = FALSE;
//        $this->loadModel('Meme');
//        $this->loadModel('MemeImage');
//        if ($this->request->is(array('put', 'post'))) {
//            $content_id = $this->__checkContentId($this->request->data['content_id']);
//            $data['content_id'] = $content_id;
//            $this->Meme->save($data);
//            $meme_id = $this->Meme->getLastInsertId();
//            if (is_array($_FILES['file'])) {
//                $field = "image";
//                $location = "img/meme";
//                $folder_name = 'original';
//                $multiple[] = array('folder_name' => 'thumb', 'height' => '100', 'width' => '100');
//                // Code to upload the image
//                $meme_image = $this->Common->upload_image($_FILES['file'], $location, $folder_name, true, $multiple);
//                $data['image'] = $meme_image;
//                $data['author'] = 'user';
//                $data['user_id'] = $this->Session->read('UserInfo.id');
//                $this->MemeImage->save($data);
//            }
//        }
//        echo json_encode(array('image' => $meme_image));
//    }

    function meme(){
        $box_text = $query_type = "";
        $this->autoRender = FALSE;
        $this->loadModel('Meme');
        if ($this->request->is(array('put', 'post'))) {
            $content_id = $this->__checkContentId($this->request->data['content_id']);
            $data = $this->request->data;
            $query_type = "insert";
            if (!empty($data['Meme']['meme_id'])) {
                $query_type = "update";
                $this->Meme->id = $data['Meme']['meme_id'];
            }
            $data['Meme']['content_id'] = $content_id;
            if ($this->Meme->save($data)) {
                $meme_id = $this->Meme->getLastInsertId();
            }
            if ($data['Meme']['meme_id']) {
                $meme_id = $data['Meme']['meme_id'];
            }
            return json_encode(array('meme_id' => $meme_id, 'content_id' => $content_id, 'query_type' => $query_type));
        } else {
            return json_encode(array('error' => TRUE));
            exit;
        }
    }

    function deleteMeme($id) {
        $this->loadModel('Meme');
        //$text = $this->Text->findById($id);
        $this->Meme->delete($id);
        return json_encode(array('status' => 'deleted'));
    }

    function deleteRecord() {
        $id = $this->request->data['id'];
        $type = $this->request->data['type'];
        $val = 'delete' . ucfirst($type);
        echo $this->$val($id);
        die;
    }

    function deleteText($id) {
        $this->loadModel('Text');
        //$text = $this->Text->findById($id);
        $this->Text->delete($id);
        return json_encode(array('status' => 'deleted'));
    }

    function deleteVideo($id) {
        $this->loadModel('Video');
        //$text = $this->Text->findById($id);
        $this->Video->delete($id);
        return json_encode(array('status' => 'deleted'));
    }

    function deletePhoto($id) {
        $this->loadModel('Photo');
        $photo = $this->Photo->findById($id);
        $file1 = new File(WWW_ROOT . 'img/photos/thumb/' . $photo['Photo']['image'], false, 0777);
        $file2 = new File(WWW_ROOT . 'img/photos/original/' . $photo['Photo']['image'], false, 0777);

        $file1->delete();
        $file2->delete();

        $this->Photo->delete($id);
        return json_encode(array('status' => 'deleted'));
        die;
    }

    function deleteQuiz($id) {
        $this->loadModel('Quiz');
        $this->loadModel('QuizQuestion');
        $this->loadModel('QuizAnswer');
        $quiz = $this->Quiz->findById($id);
        $this->Quiz->Behaviors->load('Containable');
        $conditions = array('Quiz.id' => $id);
        $contain = array(
            'QuizQuestion' => array('fields' => array('id', 'image'),
                'QuizAnswer' => array('fields' => array('id', 'image')),
            )
        );
        $datasets = $this->Quiz->find('first', array(
            'contain' => $contain,
            'conditions' => $conditions,
        ));
        //        pr($datasets);

        if(is_array($datasets['QuizQuestion'])) {
            foreach ($datasets['QuizQuestion'] as $items) {
                $file = new File(WWW_ROOT . 'img/quiz/original/' . $items['image'], false, 0777);
                $file2 = new File(WWW_ROOT . 'img/quiz/thumb/' . $items['image'], false, 0777);
                $file2->delete();
                $file->delete();
                if (is_array($items['QuizAnswer'])) {
                    foreach ($items['QuizAnswer'] as $ans) {
                        $file = new File(WWW_ROOT . 'img/quiz/original/' . $ans['image'], false, 0777);
                        $file2 = new File(WWW_ROOT . 'img/quiz/thumb/' . $ans['image'], false, 0777);
                        $file2->delete();
                        $file->delete();
                    }
                }
            }
        }

        $this->Quiz->delete($datasets['Quiz']['id']);
        return json_encode(array('status' => 'deleted'));
    }

    function deleteLists($id) {
        $this->loadModel('ContentList');
        $this->loadModel('ListsItem');
        $list = $this->ContentList->findById($id);
        if (is_array($list['ListItem'])) {
            foreach ($list['ListItem'] as $items) {
                $file = new File(WWW_ROOT . 'img/list/original/' . $items['image'], false, 0777);
                $file2 = new File(WWW_ROOT . 'img/list/thumb/' . $items['image'], false, 0777);
                $file2->delete();
                $file->delete();
            }
            $this->ListsItem->id = $items['id'];
            $this->ListsItem->delete();
        }
        $this->ContentList->delete($list['ContentList']['id']);
        return json_encode(array('status' => 'deleted'));
        die;
    }

    function deleteSlide($id) {
        $this->loadModel('Slide');
        $this->loadModel('SlideItem');
        $list = $this->Slide->findById($id);
        if (is_array($list['SlideItem'])) {
            foreach ($list['SlideItem'] as $items) {
                $file = new File(WWW_ROOT . 'img/slide/original/' . $items['image'], false, 0777);
                $file2 = new File(WWW_ROOT . 'img/slide/thumb/' . $items['image'], false, 0777);
                $file2->delete();
                $file->delete();
            }
        }
        $this->Slide->delete($id);
        return json_encode(array('status' => 'deleted'));
        die;
    }

    function deletePolls($id) {
        $this->loadModel('Poll');
        $this->Poll->Behaviors->load('Containable');
        $conditions = array('Poll.id' => $id);
        $contain = array(
            'PollQuestion' => array('fields' => array('id', 'image'),
                'PollAnswer' => array('fields' => array('id', 'image')),
            )
        );
        $datasets = $this->Poll->find('first', array(
            'contain' => $contain,
            'conditions' => $conditions,
        ));
    }

    function tags_json() {
        if (@$_GET['term']) {
            $term = $_GET['term'];
        } else {
            $term = '';
        }
        $this->autoRender = false;
        $this->loadModel('Tag');
        $this->Tag->recursive = -1;
        $tags = $this->Tag->find('all', array('conditions' => array('Tag.tag_name LIKE' => "$term%"), 'fields' => array('id', 'tag_name', 'auto_label')));
        $singleArray = array();
        $newdata = array();
        foreach ($tags as $tag) {
            $newdata['id'] = $tag['Tag']['id'];
            $newdata['label'] = $tag['Tag']['tag_name'];
            $newdata['value'] = $tag['Tag']['tag_name'];
            $singleArray[] = $newdata;
        }
        $json_tag = json_encode($singleArray);
        return $json_tag;
    }

     function save_the_content(){
        //echo json_encode(json_encode(array('status'=>TRUE,'post_type'=>'preview'))); die;
        $this->loadModel('Content');
        $this->autoRender = FALSE;
        if($this->request->is(array('put', 'post'))) {
            if ($this->request->data['Content']['id']) {
                if (@$this->request->data['Content']['tag']) {
                    $tags = explode(',', $this->request->data['Content']['tag']);
                    $this->loadModel('Tag');
                    $this->loadModel('TagSum');
                    $this->TagSum->deleteAll(array('content_id' =>$this->request->data['Content']['id']), false);
                    $this->Tag->recursive = -1;
                    foreach ($tags as $tag){
                        $tag_table = $this->Tag->findByTagName($tag);
                        if(count($tag_table)) {
                            $tas_sum['TagSum']['content_id'] = $this->request->data['Content']['id'];
                            $tas_sum['TagSum']['tag_id'] = $tag_table['Tag']['id'];
                            $this->TagSum->create();
                            $this->TagSum->save($tas_sum);
                            }else {
                            $tags['Tag']['tag_name'] = ucfirst($tag);
                            $this->Tag->create();
                            $this->Tag->save($tags);
                            $lastInsertTag = $this->Tag->getLastInsertId();
                            $tas_sum['TagSum']['content_id'] = $this->request->data['Content']['id'];
                            $tas_sum['TagSum']['tag_id'] = $lastInsertTag;
                            $this->TagSum->create();
                            $this->TagSum->save($tas_sum);
                            }
                    }
                }
                $data = $this->request->data;
                $order = json_encode($data['Content']['content_order']);
                $data['Content']['content_order'] = $order;
                $this->Content->id = $data['Content']['id'];
                if ($this->Content->save($data)) {
                    $retarray  = array('post_type'=>$this->request->data['Content']['post_type'],
                    'status'=> TRUE);
                    return json_encode($retarray);
                } else {
                     return json_encode(array('status'=>FALSE));
                }
                } else {
                 return json_encode(array('status'=>FALSE));
                }
        }
    }

       public function check_thumb($url=''){
                    //$url = 'https://www.youtube.com/watch?v=znK652H6yQM';
                    //$url = 'https://www.facebook.com/video.php?v=415516785211182';
                   //$url = basename("http://www.dailymotion.com/video/x27c3lj_nail-biter-election-throws-brazil-s-rousseff-into-a-runoff-vote_news");
                $this->autoRender = false;
                //$url = '//www.youtube.com/embed/nnqBJnYGObU';
                $domain = $this->url_to_domain($url);
                if ($domain == 'youtube.com' or $domain == 'www.youtube.com') {
                /* Get the thumb from youtube */
                if($querystring=parse_url($url,PHP_URL_QUERY))
                {  
                 parse_str($querystring);
                 if(!empty($v)) return  "http://img.youtube.com/vi/$v/0.jpg"; 
                 else return false;
                 }
                 else return false;
                 }
                 elseif ($domain == 'facebook.com' || $domain == 'www.facebook.com'){
                 if($querystring=parse_url($url,PHP_URL_QUERY))
                 {  
                 parse_str($querystring);
                 if(!empty($v)) return  "https://graph.facebook.com/$v/picture"; 
                 else return false;
                 }
                 else return false;
                   }elseif($domain == 'dailymotion.com' || $domain == 'www.dailymotion.com'){
                   $tokens = explode('/', $url);
                   $v =  $tokens[sizeof($tokens)-1];
                   if(!empty($v)){
                   return  "http://www.dailymotion.com/thumbnail/video/$v";    
                   }else{
                    return false;   
                   }  
                  }elseif($domain == 'vine.co' || $domain == 'www.vine.co'){
                     	$vine = file_get_contents($url);
                        preg_match('/property="og:image" content="(.*?)"/', $vine, $matches);
                        return ($matches[1]) ? $matches[1] : false;
                 }else{
                 return false;  
        }
        die;
    }

    function url_to_domain($url){
        $host = @parse_url($url, PHP_URL_HOST);
        if (!$host)
            $host = $url;
        if (substr($host, 0, 4) == "www.")
            $host = substr($host, 4);
        // You might also want to limit the length if screen space is limited
        if (strlen($host) > 50)
            $host = substr($host, 0, 47) . '...';
            return $host;
            exit;
    }
  
    
    function fetch_video(){
         
        $this->loadModel('Video');
        $this->autoRender = false;
        $params = $this->request->data;
        $datasets = array();
        $id = '';
        //$params['id'] = 20;
        if (isset($params['id']) && !empty($params['id'])) {
            $id = $params['id'];
            $datasets = $this->Video->find('first', array('conditions' => array('Video.id' => $params['id'])));
        }
        //pr($datasets);die;
        $view = new View($this, false);
        $content = $view->element('video_modal', array('datasets' => $datasets, 'id' => $id));
        echo $content;
    }
    
    
}
