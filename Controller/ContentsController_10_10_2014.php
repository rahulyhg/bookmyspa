<?php

/*
 * Contents Controller class
 * Functionality -  Manage the Content Management
 * Developer - Kirpal
 * Created date - 8-July-2014
 * Modified date - 
 */

class ContentsController extends AppController {
    var $name = 'Contents';
    public $components = array('Paginator', 'Common');
    var $helpers = array('Common');
    public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Contents.title' => 'asc'
        )
    );

    function beforeFilter() {
        parent::beforeFilter();
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    function index(){
        $this->layout = 'index';
        $this->loadModel('Category');
        /* Active/Inactive/Delete functionality */
        if ((isset($this->request->data["content"]["setStatus"]))) {
            if (!empty($this->request->data['content']['status'])) {
                $status = $this->request->data['content']['status'];
            } else {
                $this->Session->setFlash("Please select the action.", 'default', array('class' => 'alert alert-danger'));
                $this->redirect(array('action' => 'index'));
            }
            $CheckedList = $this->request->data['checkboxes'];
            $model = 'Content';
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            $this->setStatus($status, $CheckedList, $model, $controller, $action);
        }
        $value ="";
        $show = "";
        //$criteria="is_deleted = 0 AND Staticpage.company_id = $companyId"; 
        $criteria = "";
        if (!empty($this->params)){
            if (!empty($this->params->query['keyword'])){
                $value = trim($this->params->query['keyword']);
            }
                if ($value != "") {
                $criteria .= "Content.title LIKE '%" . $value . "%'";
                }
        }
        $this->Paginator->settings = array('conditions' => array($criteria),
               'joins' => array(
                array(
                    'alias' => 'Category',
                    'table' => 'categories',
                    'type' => 'INNER',
                    'conditions' => array('Category.id = Content.categories')
                )
             ),
        'fields' => array('Content.id,Content.title,Content.status,Content.created,Category.Category'),
        'limit' => 10, 'order' => 'id DESC');
        $this->set('getData', $this->Paginator->paginate('Content'));
        $this->set('keyword', $value);
        $this->set('show', $show);
        $this->set('navstaticpages', 'class = "active"');
        $this->set('breadcrumb', 'Content');
    }

    function delete($id = Null) {
        $id = base64_decode($id);
        if ($this->Content->delete($id)) {
            $this->Session->setFlash("Content has been deleted sucessfully.", 'default', array('class' => 'alert alert-success'));
            $this->redirect('index');
        }
    }

    /*
     * name: admin_index
     * Functionality -  Contents Listing
     * Developer - Kirpal
     * Created date - 8-Jul-2014   
     * @param none
     * @return none
     */

    function admin_index(){
        $this->loadModel('Category');
        /* Active/Inactive/Delete functionality */
        if ((isset($this->request->data["content"]["setStatus"]))) {
            if (!empty($this->request->data['content']['status'])) {
                $status = $this->request->data['content']['status'];
            } else {
                $this->Session->setFlash("Please select the action.", 'default', array('class' => 'alert alert-danger'));
                $this->redirect(array('action' => 'index'));
            }
            $CheckedList = $this->request->data['checkboxes'];
            $model = 'Content';
            $controller = $this->params['controller'];
            $action = $this->params['action'];
            $this->setStatus($status, $CheckedList, $model, $controller, $action);
        }
        $value = "";
        $show = "";
        //$criteria="is_deleted = 0 AND Staticpage.company_id = $companyId"; 
        $criteria = "";
        if (!empty($this->params)) {
            if (!empty($this->params->query['keyword'])) {
                $value = trim($this->params->query['keyword']);
            }
            if ($value != "") {
                $criteria .= "Content.title LIKE '%" . $value . "%'";
            }
        }
       $this->Paginator->settings = array('conditions' => array($criteria),
            /* 'joins' => array(
                array(
                    'alias' => 'Category',
                    'table' => 'categories',
                    'type' => 'INNER',
                    'conditions' => array('Category.id = Content.categories')
                )
            ),
            'fields' => array('Content.id,Content.title,Content.status,Content.created,Category.Category'),
            'limit' => 10, 'order' => 'id DESC');*/
	'fields' => array('Content.id,Content.title,Content.status,Content.created'),
        'limit' => 10,'order' => 'id DESC');
        $this->set('getData', $this->Paginator->paginate('Content'));
        $this->set('keyword', $value);
        $this->set('show', $show);
        $this->set('navstaticpages', 'class = "active"');
        $this->set('breadcrumb', 'Content');
    }

    /*
     * name: admin_delete
     * Functionality - Delete Content
     * Developer - Kirpal
     * Created date - 8-Jul-2014   
     * @param id
     * @return none
     */

    function admin_delete($id = Null) {
        $id = base64_decode($id);
        if ($this->Content->delete($id)) {
            $this->Session->setFlash("Content has been deleted sucessfully.", 'default', array('class' => 'alert alert-success'));
            $this->redirect('index');
        }
    }

    /*
     * name: admin_view
     * Functionality - View Content
     * Developer - Kirpal
     * Created date - 8-Jul-2014   
     * @param id
     * @return none
     */

    function admin_view($id = null) {
        $getData = array();
        if (!empty($id)) {
            $conditions = "Content.id = " . base64_decode($id);
            $getData = $this->Content->find('first', array(
                'conditions' => array($conditions),
                /*'joins' => array(
                    array(
                        'alias' => 'Category',
                        'table' => 'categories',
                        'type' => 'INNER',
                        'conditions' => array('Category.id = Content.categories')
                    )
                ),
                'fields' => array('Content.id,Content.title,Content.status,Content.created,Category.Category')*/
				 'fields' => array('Content.id,Content.title,Content.status,Content.created')
            ));
        }
        $this->set(compact('getData'));
    }

    /*
     * name: upload_image
     * Functionality - Upload image
     * Developer - Kirpal
     * Created date - 10-Jul-2014   
     * @param data,model,field,location
     * @return images
     */

    function upload_image($data, $model, $field, $location) {
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

    /*
     * name: save_answers
     * Functionality - Save Answers
     * Developer - Kirpal
     * Created date - 15-Jul-2014   
     * @param question_id,answer_text,answer_image,type,rightans
     * @return answer_id
     */

    function save_answers($question_id, $ans_txt = Null, $ans_img = Null, $type, $rightAns) {
        $this->loadModel('Answer');
        if ($type == 'I') {
            $data['Answer']['answer_image'] = $ans_img;
        } else {
            $data['Answer']['answer_text'] = $ans_txt;
        }
        $data['Answer']['question_id'] = $question_id;
        $data['Answer']['question_id'] = $question_id;
        $data['Answer']['type'] = $type;

        if ($rightAns == 1) {
            $data['Answer']['right_answer'] = 1;
        }
        $this->Answer->create();
        if (!$this->Answer->saveAll($data)) {
            return $this->Session->setFlash('Error while saving data', 'error');
        } else {
            $ids = $this->Answer->getLastInsertId();
        }
        return $ids;
    }

    /*
     * name: save_question
     * Functionality - Save Question
     * Developer - Kirpal
     * Created date - 15-Jul-2014   
     * @param val, model, images
     * @return question_id
     */

    function save_question($val, $model, $img_data) {
        $this->loadModel('Question');

        $i = 0;
        if (count($img_data)) {
            foreach ($val['Question']['question_text'] as $question) {
                $data['Question']['question_text'] = $question;
                if ($img_data[$i] != 'exist_error' && $img_data[$i] != 'size_mb_error' && $img_data[$i] != 'type_error') {
                    $data['Question']['question_image'] = $img_data[$i];
                }
                if (isset($val['Question']['id'][$i + 1])) {
                    $data['Question']['id'] = $val['Question']['id'][$i + 1];
                } else {
                    $this->Question->create();
                }
                if (!$this->Question->saveAll($data)) {
                    return $this->Session->setFlash('Error while saving data', 'error');
                } else {
                    if ($this->Question->getLastInsertId()) {
                        $ids[] = $this->Question->getLastInsertId();
                    } else {
                        $ids[] = $data['Question']['id'];
                    }
                }
                $i++;
            }
            return $ids;
        } else {
            return false;
        }
    }

    function delete_image() {
        //for delete images
        //delete_image($imagename = null, $path = null, $folder_name = null, $thumb = false, $multiple = array());
    }

    function removeanswer($id = null) {
        //don't forget to remove image from directory
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
        }
        $this->loadModel('CatQuiz');
        $this->loadModel('Answer');

        $data = $this->CatQuiz->find('all', array('conditions' => array('FIND_IN_SET(\'' . $id . '\',CatQuiz.answers_id)')));

        $query_a = "UPDATE db_buzzfeed.cat_quizzes SET answers_id = REPLACE('" . $data[0]['CatQuiz']['answers_id'] . "','" . $id . ",', '') WHERE cat_quizzes.id = '" . $data[0]['CatQuiz']['id'] . "'";
        $this->CatQuiz->query($query_a);
        $this->Answer->delete($id);
        exit;
    }

    /*
     * name: admin_removequiz
     * Functionality - Remove Quiz type content
     * Developer - Kirpal
     * Created date - 23-Jul-2014   
     * @param id
     * @return none
     */

    function removequiz($id = Null) {
        //don't forget to remove image from directory
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
        }
        $this->loadModel('Question');
        $this->loadModel('CatQuiz');
        $data = $this->CatQuiz->find('all', array('conditions' => array('FIND_IN_SET(\'' . $id . '\',CatQuiz.question_id)')));

        $query_q = "UPDATE db_buzzfeed.cat_quizzes SET question_id = REPLACE('" . $data[0]['CatQuiz']['question_id'] . "','" . $id . ",', '') WHERE cat_quizzes.id = '" . $data[0]['CatQuiz']['id'] . "'";
        $this->CatQuiz->query($query_q);



        $this->Question->delete($id);
        exit;
    }

    function removepoll($id = Null) {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
        }
        $this->loadModel('PollAnswer');
        $this->PollAnswer->delete($id);
        exit;
    }

    /*
     * name: addeditmeme
     * Functionality -Add/Edit Meme type content
     * Developer - Kirpal
     * Created date - 31-Jul-2014   
     * @param id
     * @return none
     */

    function addeditmeme($id = null) {
        $this->loadModel('Category');
        $this->loadModel('CatMeme');
        $param = array('fields' => array('Category.id', 'Category.category'));
        $category = $this->Category->find('list', $param);
        $this->set(compact('category'));
        if (empty($this->request->data)) {
            $this->request->data = $this->Content->read(null, base64_decode($id));
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->Content->set($this->request->data);
            if ($this->Content->validates()) {
                $this->request->data['Content']['id'] = base64_decode($this->request->data['Content']['id']);
                $this->request->data['Content']['title'] = trim($this->request->data['Content']['title']);

                $location = "img/Cat_Meme";
                $folder_name = 'original';
                $meme_img = $this->Common->upload_image($this->request->data['CatMeme']['image'], $location, $folder_name, false);
                if ($this->Content->save($this->request->data)) {
                    if ($this->Content->getLastInsertId()) {
                        $id = $this->Content->getLastInsertId();
                    } else {
                        $id = $this->request->data['Content']['id'];
                    }
                    $this->request->data['CatMeme']['content_id'] = $id;
                    $this->request->data['CatMeme']['image'] = $meme_img;
                    $this->CatMeme->save($this->request->data);
                    if ($this->CatMeme->getLastInsertId()) {
                        $meme_id = $this->CatMeme->getLastInsertId();
                    } else {
                        $meme_id = $this->CatMeme->data['CatMeme']['id'];
                    }
                    echo base64_decode($meme_id);
                    exit;
                }
            }
        }

        $textAction = ($id == null) ? 'Add' : 'Edit';
        $buttonText = ($id == null) ? 'Submit' : 'Update';
        $this->set('navstaticpages', 'class = "active"');
        $this->set('action', $textAction);
        $this->set('breadcrumb', 'Contents/' . $textAction);
        $this->set('buttonText', $buttonText);
    }

    /*
     * name: addeditpoll
     * Functionality -Add/Edit Quiz type content
     * Developer - Kirpal
     * Created date - 25-Jul-2014   
     * @param id
     * @return none
     */

    function addeditpoll($id = null) {

        $this->loadModel('Category');
        $this->loadModel('CatPoll');
        $this->loadModel('PollAnswer');
        $param = array('fields' => array('Category.id', 'Category.category'));
        $category = $this->Category->find('list', $param);
        $this->set(compact('category'));
        if (empty($this->request->data)) {
            $this->request->data = $this->Content->read(null, base64_decode($id));
            $answerdata = $this->PollAnswer->find('all', array('conditions' => array('PollAnswer.question' => $this->request->data['cat_polls'][0]['id'])));
            $this->set('answerdata', $answerdata);
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->Content->set($this->request->data);
            if ($this->Content->validates()) {
                $this->request->data['Content']['id'] = base64_decode($this->request->data['Content']['id']);
                $this->request->data['Content']['title'] = trim($this->request->data['Content']['title']);
                if ($this->Content->save($this->request->data)) {
                    if ($this->Content->getLastInsertId()) {
                        $id = $this->Content->getLastInsertId();
                    } else {
                        $id = $this->request->data['Content']['id'];
                    }

                    $this->request->data['CatPoll']['content_id'] = $id;
                    $this->CatPoll->saveAll($this->request->data);

                    if (isset($this->request->data['CatPoll']['id'])) {
                        $q_id = $this->request->data['CatPoll']['id'];
                    } else {
                        $q_id = $this->CatPoll->getLastInsertId();
                    }

                    $i = 0;

                    foreach ($this->request->data['PollAnswer']['answer_text'] as $answer) {
                        if (isset($this->request->data['PollAnswer']['id'][$i])) {
                            $data['PollAnswer']['id'] = $this->request->data['PollAnswer']['id'][$i];
                        } else {
                            $this->PollAnswer->create();
                        }
                        $data['PollAnswer']['answer_text'] = $answer;
                        $data['PollAnswer']['question'] = $q_id;
                        if (!$this->PollAnswer->saveAll($data)) {
                            //die('Error');
                        }
                        $i++;
                    }
                }
            }
            exit;
        }

        $textAction = ($id == null) ? 'Add' : 'Edit';
        $buttonText = ($id == null) ? 'Submit' : 'Update';
        $this->set('navstaticpages', 'class = "active"');
        $this->set('action', $textAction);
        $this->set('breadcrumb', 'Contents/' . $textAction);
        $this->set('buttonText', $buttonText);
    }

    /*
     * name: addeditquiz
     * Functionality -Add/Edit Quiz type content
     * Developer - Kirpal
     * Created date - 22-Jul-2014   
     * @param id
     * @return none
     */

    function addeditquiz($id = null) {

        $this->loadModel('Category');
        $this->loadModel('CatQuiz');
        $this->loadModel('Question');
        $param = array('fields' => array('Category.id', 'Category.category'));
        $category = $this->Category->find('list', $param);
        $this->set(compact('category'));
        if (empty($this->request->data)) {
            $this->request->data = $this->Content->read(null, base64_decode($id));
            if (isset($this->request->data['cat_quizzes'][0]['question_id'])) {
                $questions = explode(',', $this->request->data['cat_quizzes'][0]['question_id']);
                foreach ($questions as $question) {
                    $quiz_data[] = $this->Question->read(null, $question);
                }
                $this->set('quiz_data', $quiz_data);
            }
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->Content->set($this->request->data);
            if ($this->Content->validates()) {
                $this->request->data['Content']['id'] = base64_decode($this->request->data['Content']['id']);
                $this->request->data['Content']['title'] = trim($this->request->data['Content']['title']);
                $data = true;
                //save question and images
                $model = "Question";
                $field = "question_image";
                $location = "img/Cat_Quiz";

                $data_img = $this->upload_image($this->request->data, $model, $field, $location);
                $question_ids = $this->save_question($this->request->data, $model, $data_img);


                //save answer and images
                $q = 0;
                if (count($question_ids)) {
                    foreach ($this->request->data['Question']['question_text'] as $ind_key => $question) {
                        $i = $ind_key;
                        $k = 0;
                        if (isset($this->request->data['Answer']['type'][$i]) && is_array($this->request->data['Answer']['type'][$i])) {
                            foreach ($this->request->data['Answer']['type'][$i] as $key => $val) {
                                if (isset($this->request->data['Answer']['type'][$i][$k]) && is_array($this->request->data['Answer']['type'][$i]) && $this->request->data['Answer']['type'][$i][$k] == 'I') {

                                    $model = "Answer";
                                    $field = "answer_image";
                                    $location = "img/Cat_Quiz_Answer";
                                    $error = false;
                                    $folder_name = 'original';
                                    $multiple[] = array('folder_name' => 'thumb', 'height' => '100', 'width' => '100');
                                    $ans_img = $this->Common->upload_image($this->request->data['Answer']['answer_image'][$i][$k], $location, $folder_name, true, $multiple);
                                    // check if filename return or error return
                                    $is_image_error = $this->Common->is_image_error($ans_img);
                                    if ($ans_img == 'exist_error') {
                                        $this->Session->setFlash($is_image_error, 'error');
                                        //$error = true;
                                    } elseif ($ans_img == 'size_mb_error') {
                                        $this->Session->setFlash($is_image_error, 'error');
                                        $error = true;
                                    } elseif ($ans_img == 'type_error') {
                                        $this->Session->setFlash($is_image_error, 'error');
                                        $error = true;
                                    }
                                    if (!$error) {
                                        if (isset($this->request->data['Answer']['right_answer'][$i][$k])) {
                                            $right = $this->request->data['Answer']['right_answer'][$i][$k];
                                        } else {
                                            $right = 0;
                                        }
                                        $answer_ids[] = $this->save_answers($question_ids[$q], $ans_txt = Null, $ans_img, $this->request->data['Answer']['type'][$i][$k], $right);
                                    }
                                } else {
                                    if (isset($this->request->data['Answer']['right_answer'][$i][$k])) {
                                        $right = $this->request->data['Answer']['right_answer'][$i][$k];
                                    } else {
                                        $right = 0;
                                    }

                                    $answer_ids[] = $this->save_answers($question_ids[$q], $this->request->data['Answer']['answer_text'][$i][$k], $ans_img = Null, $this->request->data['Answer']['type'][$i][$k], $right);
                                }
                                $k++;
                            }
                        }
                        $q++;
                    }
                }
                if ($this->Content->save($this->request->data)) {
                    $id = $this->Content->getLastInsertId();
                    $question = implode(",", $question_ids);
                    $answer = implode(",", $answer_ids);
                    $error = false;
                    $this->CatQuiz->create();
                    $this->CatQuiz->saveAll(array('content_id' => $id, 'question_id' => $question, 'answers_id' => $answer));

                    echo base64_encode($id);
                    //$this->Session->setFlash("Page has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
                    //$this->redirect(array('action' => 'index'));
                    exit;
                }
            }
        }
        $textAction = ($id == null) ? 'Add' : 'Edit';
        $buttonText = ($id == null) ? 'Submit' : 'Update';
        $this->set('navstaticpages', 'class = "active"');
        $this->set('action', $textAction);
        $this->set('breadcrumb', 'Contents/' . $textAction);
        $this->set('buttonText', $buttonText);
    }

    /*
     * name: admin_removelist
     * Functionality - Remove List type content
     * Developer - Kirpal
     * Created date - 21-Jul-2014   
     * @param id
     * @return none
     */

    function removelist($id = null) {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
        }
        $this->loadModel('CatList');
        $this->CatList->delete($id);

        //Don't forget to remove image
    }

    /*
     * name: admin_addeditlist
     * Functionality -Add/Edit List type content
     * Developer - Kirpal
     * Created date - 21-Jul-2014   
     * @param id
     * @return none
     */

    function addeditlist($id = null) {
        $this->loadModel('Category');
        $this->loadModel('CatList');
        $param = array('fields' => array('Category.id', 'Category.category'));
        $category = $this->Category->find('list', $param);
        $this->set(compact('category'));
        if (empty($this->request->data)) {
            $this->request->data = $this->Content->read(null, base64_decode($id));
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->Content->set($this->request->data);
            if ($this->Content->validates()) {
                $this->request->data['Content']['id'] = base64_decode($this->request->data['Content']['id']);
                $this->request->data['Content']['title'] = trim($this->request->data['Content']['title']);
                $model = "CatList";
                $field = "image";
                $location = "img/Cat_List";
                $data = $this->upload_image($this->request->data, $model, $field, $location);
                if ($this->Content->save($this->request->data)) {
                    if ($this->Content->getLastInsertId()) {
                        $id = $this->Content->getLastInsertId();
                    } else {
                        $id = $this->request->data['Content']['id'];
                    }
                    $i = 0;
                    foreach ($data as $img) {

                        $data['CatList']['img_title'] = $this->request->data['CatList']['img_title'][$i];

                        if ($img != 'exist_error' && $img != 'size_mb_error' && $img != 'type_error') {
                            $data['CatList']['image'] = $img;
                        }
                        $data['CatList']['content_id'] = $id;
                        if (isset($this->request->data['CatList']['id'][$i])) {
                            $data['CatList']['id'] = $this->request->data['CatList']['id'][$i];
                        } else {
                            $this->CatList->create();
                        }
                        if (!$this->CatList->saveAll($data)) {
                            $this->Session->setFlash('Error while saving data', 'error');
                        }
                        $i++;
                    }

                    echo base64_encode($id);
                    //$this->Session->setFlash("Page has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
                    //$this->redirect(array('action' => 'index'));
                    exit;
                }
            }
        }
        $textAction = ($id == null) ? 'Add' : 'Edit';
        $buttonText = ($id == null) ? 'Submit' : 'Update';
        $this->set('navstaticpages', 'class = "active"');
        $this->set('action', $textAction);
        $this->set('breadcrumb', 'Contents/' . $textAction);
        $this->set('buttonText', $buttonText);
    }

    /*
     * name: admin_removeimg
     * Functionality -Remove Slider images
     * Developer - Kirpal
     * Created date - 21-Jul-2014   
     * @param id
     * @return none
     */

    function removeimg($id = null) {

        //don't forget to remove image from directory

        if ($this->request->is('ajax')) {
            $this->autoRender = false;
        }
        $this->loadModel('CatSlide');
        $this->CatSlide->delete($id);
    }

    /*
     * name: admin_addeditslider
     * Functionality -Add/Edit Slider type content
     * Developer - Kirpal
     * Created date - 21-Jul-2014   
     * @param id
     * @return none
     */

    function addeditslider($id = null) {
        $this->loadModel('CatSlide');
        $this->loadModel('Category');
        $param = array('fields' => array('Category.id', 'Category.category'));
        $category = $this->Category->find('list', $param);
        $this->set(compact('category'));
        if (empty($this->request->data)) {
            $this->request->data = $this->Content->read(null, base64_decode($id));
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->Content->set($this->request->data);
            if ($this->Content->validates()) {
                $this->request->data['Content']['id'] = base64_decode($this->request->data['Content']['id']);
                $this->request->data['Content']['title'] = trim($this->request->data['Content']['title']);
                $model = "CatSlide";
                $field = "slide_img";
                $location = "img/Cat_Sliders";

                $data = $this->upload_image($this->request->data, $model, $field, $location);

                if ($this->Content->save($this->request->data)) {
                    if ($this->Content->getLastInsertId()) {
                        $id = $this->Content->getLastInsertId();
                    } else {
                        $id = $this->request->data['Content']['id'];
                    }
                    foreach ($data as $img) {
                        if ($img != 'exist_error' && $img != 'size_mb_error' && $img != 'type_error') {
                            $this->request->data['CatSlide']['slide_img'] = $img;
                            $this->request->data['CatSlide']['content_id'] = $id;
                            $this->CatSlide->create();
                            if (!$this->CatSlide->saveAll($this->request->data)) {
                                $this->Session->setFlash('Error while saving data', 'error');
                            }
                        }
                    }
                    echo base64_encode($id);
                    exit;
                    //$this->Session->setFlash("Page has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
                    //$this->redirect(array('action' => 'index'));
                }
            }
        }

        $textAction = ($id == null) ? 'Add' : 'Edit';
        $buttonText = ($id == null) ? 'Submit' : 'Update';
        $this->set('navstaticpages', 'class = "active"');
        $this->set('action', $textAction);
        $this->set('breadcrumb', 'Contents/' . $textAction);
        $this->set('buttonText', $buttonText);
    }

    /*
     * name: addedit
     * Functionality -Add/Edit Content
     * Developer - Kirpal
     * Created date - 9-Jul-2014   
     * Modified date - 21-Jul-2014   
     * @param id
     * @return none
     */

    function addedit($id = null) {
        $this->layout = 'index';
        $this->loadModel('Category');
        $param = array('fields' => array('Category.id', 'Category.category'));
        $category = $this->Category->find('list', $param);
        $this->set(compact('category'));
        if (empty($this->request->data)) {
            $this->request->data = $this->Content->read(null, base64_decode($id));
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->Content->set($this->request->data);

            if ($this->Content->validates()) {
                $this->request->data['Content']['id'] = base64_decode($this->request->data['Content']['id']);
                $this->request->data['Content']['title'] = trim($this->request->data['Content']['title']);
                if ($this->Content->save($this->request->data)) {
                    //$this->Session->setFlash("Content has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
                    //echo $this->redirect(array('action' => 'index'));
                    //success message
                    if ($this->Content->getLastInsertId()) {
                        echo base64_encode($this->Content->getLastInsertId());
                    } else {
                        echo "update";
                    }
                    exit;
                }
            }
        }
        $textAction = ($id == null) ? 'Add' : 'Edit';
        $buttonText = ($id == null) ? 'Submit' : 'Update';
        $this->set('navstaticpages', 'class = "active"');
        $this->set('action', $textAction);
        $this->set('breadcrumb', 'Contents/' . $textAction);
        $this->set('buttonText', $buttonText);
    }

    function admin_addedit_backup($id = null) {
        $this->loadModel('Category');
        $this->loadModel('CatSlide');
        $this->loadModel('CatList');
        $this->loadModel('CatQuiz');
        $param = array('fields' => array('Category.id', 'Category.category'));
        $category = $this->Category->find('list', $param);
        $this->set(compact('category'));

        if (empty($this->request->data)) {
            $this->request->data = $this->Content->read(null, base64_decode($id));
            /* if($this->request->data['Content']['categories']==10){
              $cat_data = $this->CatSlide->find('all',array('conditions' => array('CatSlide.content_id' => $this->request->data['Content']['id'])));
              $this->set(compact('cat_data'));
              } */
            //$this->request->data['Content']['id'];			 		
        } else if (isset($this->request->data) && !empty($this->request->data)) {
            $this->Content->set($this->request->data);
            if ($this->Content->validates()) {
                $error = false;
                $this->request->data['Content']['id'] = base64_decode($this->request->data['Content']['id']);
                $this->request->data['Content']['title'] = trim($this->request->data['Content']['title']);
                switch ($this->request->data['Content']['categories']) {
                    case '10': //Add slider
                        $model = "CatSlide";
                        $field = "slide_img";
                        $location = "img/Cat_Sliders";
                        $data = $this->upload_image($this->request->data, $model, $field, $location);
                        break;
                    case '17' : //Add list
                        $model = "CatList";
                        $field = "image";
                        $location = "img/Cat_List";
                        $data = $this->upload_image($this->request->data, $model, $field, $location);

                        break;
                    case '13' : //Add list	
                        $data = true;
                        break;
                    case '16' : //Add list	
                        $data = true;
                        //save question and images
                        $model = "Question";
                        $field = "question_image";
                        $location = "img/Cat_Quiz";
                        $data_img = $this->upload_image($this->request->data, $model, $field, $location);
                        $question_ids = $this->save_question($this->request->data, $model, $data_img);

                        //save answer and images
                        $q = 0;
                        if (count($question_ids)) {
                            foreach ($this->request->data['Question']['question_text'] as $ind_key => $question) {
                                $i = $ind_key;
                                $k = 0;

                                if (isset($this->request->data['Answer']['type'][$i]) && is_array($this->request->data['Answer']['type'][$i])) {
                                    foreach ($this->request->data['Answer']['type'][$i] as $key => $val) {
                                        if (isset($this->request->data['Answer']['type'][$i][$k]) && is_array($this->request->data['Answer']['type'][$i]) && $this->request->data['Answer']['type'][$i][$k] == 'I') {

                                            $model = "Answer";
                                            $field = "answer_image";
                                            $location = "img/Cat_Quiz_Answer";
                                            $error = false;
                                            $folder_name = 'original';
                                            $multiple[] = array('folder_name' => 'thumb', 'height' => '100', 'width' => '100');
                                            $ans_img = $this->Common->upload_image($this->request->data['Answer']['answer_image'][$i][$k], $location, $folder_name, true, $multiple);
                                            echo "<br/>";
                                            echo $ans_img;
                                            echo "<br/>";
                                            pr($this->request->data['Answer']['answer_image'][$i][$k]);
                                            echo "<br/>";

                                            // check if filename return or error return
                                            $is_image_error = $this->Common->is_image_error($ans_img);
                                            if ($ans_img == 'exist_error') {
                                                $this->Session->setFlash($is_image_error, 'error');
                                                //$error = true;
                                            } elseif ($ans_img == 'size_mb_error') {
                                                $this->Session->setFlash($is_image_error, 'error');
                                                $error = true;
                                            } elseif ($ans_img == 'type_error') {
                                                $this->Session->setFlash($is_image_error, 'error');
                                                $error = true;
                                            }
                                            if (!$error) {
                                                $answer_ids[] = $this->save_answers($question_ids[$q], $ans_txt = Null, $ans_img, $this->request->data['Answer']['type'][$i][$k]);
                                            } else {
                                                die('Error:' . $ans_img);
                                            }
                                        } else {

                                            $answer_ids[] = $this->save_answers($question_ids[$q], $this->request->data['Answer']['answer_text'][$i][$k], $ans_img = Null, $this->request->data['Answer']['type'][$i][$k]);
                                        }
                                        $k++;
                                    }
                                }
                                $q++;
                            }
                        }
                        break;
                }

                if ($data != false && $this->Content->save($this->request->data)) {
                    $id = $this->Content->getLastInsertId();
                    switch ($this->request->data['Content']['categories']) {
                        case '10': //Add slider
                            $error = $this->save_CatSlide($data, $id);
                            break;
                        case '12' : //Add list		
                            $error = $this->save_CatList($this->request->data, $data, $id);
                            break;
                        case '13' : //Add list		
                            $error = false;
                            break;
                        case '16' : //Add question		
                            $question = implode(",", $question_ids);
                            $answer = implode(",", $answer_ids);
                            $error = false;
                            $this->CatQuiz->create();
                            $this->CatQuiz->saveAll(array('content_id' => $id, 'question_id' => $question, 'answers_id' => $answer));

                            break;
                    }
                    if (!$error) {
                        $this->Session->setFlash("Page has been saved sucessfully.", 'default', array('class' => 'alert alert-success'));
                        $this->redirect(array('action' => 'index'));
                    }
                }
            }
        }
        $textAction = ($id == null) ? 'Add' : 'Edit';
        $buttonText = ($id == null) ? 'Submit' : 'Update';
        $this->set('navstaticpages', 'class = "active"');
        $this->set('action', $textAction);
        $this->set('breadcrumb', 'Contents/' . $textAction);
        $this->set('buttonText', $buttonText);
    }

    /**
     * Functionality -Remove Slider images
     * Developer - Vipul Sharma
     * Created date - 14-August-2014 
     */
     function save_the_content() {
        // pr($this->request->data); die;
        $this->loadModel('Content');
        $this->autoRender = FALSE;
        if($this->request->is(array('put','post'))){
        if($this->request->data['Content']['id']){
        $data =$this->request->data; 
        $order = json_encode($data['Content']['content_order']);
        $data['Content']['content_order'] =$order; 
        $this->Content->id = $data['Content']['id'];              
        if($this->Content->save($data)){
           return TRUE;
        }else{
         return FALSE;
        }
        
        }else{
         return FALSE;
        }
        
        }
        
    }

    /**
     * @author Sanjeev 
     * @since 1 Sept 2014
     */
    public function fetch_lists() {
        $this->loadModel('ContentList');
        $this->autoRender = false;
        $params = $this->request->data;
        $datasets = array();
        $id = '';
        //$params['id'] = 20;
        if (isset($params['id']) && !empty($params['id'])) {
            $id = $params['id'];
            $datasets = $this->ContentList->find('all', array('conditions' => array('ContentList.id' => $params['id'])));
        }
       
        $view = new View($this, false);
        $content = $view->element('list_modal', array('datasets' => $datasets, 'id' => $id));
        echo $content;
    }

    /* DATE : 19-AUG
     * author : Sanjeeev */
        
    
     public function fetch_slide(){
        $this->loadModel('Slide');
        $this->autoRender = false;
        $params = $this->request->data;
        $datasets = array();
        $id = '';
        //$params['id'] = 20;
        if (isset($params['id']) && !empty($params['id'])){
            $id = $params['id'];
            $datasets = $this->Slide->find('all', array('conditions' => array('Slide.id' => $params['id'])));
            //pr($datasets); 
        }
        //pr($datasets);die;
        $view = new View($this, false);
        $content = $view->element('slide_modal', array('datasets' =>$datasets, 'id' => $id));
        echo $content;
    }
    
    
    
    
    function fetch_text() {
        $this->loadModel('Text');
        $this->autoRender = false;
        $params = $this->request->data;
        $datasets = array();
        $id = '';
        //$params['id'] = 20;
        if (isset($params['id']) && !empty($params['id'])) {
            $id = $params['id'];
            $datasets = $this->Text->find('first', array('conditions' => array('Text.id' => $params['id'])));
        }
        //pr($datasets);die;
        $view = new View($this, false);
        $content = $view->element('text_modal', array('datasets' => $datasets, 'id' => $id));
        echo $content;
    }

    /**
     * @author Sanjeev
     * @since 3 Sept 2014
     */
    public function fetch_quiz() {
        $this->loadModel('Quiz');
        $params = $this->request->data;
        $datasets = array();
        $id = '';
        //$params['id'] = 69;
        if (isset($params['id']) && !empty($params['id'])) {
            $id = $params['id'];
            $this->Quiz->Behaviors->load('Containable');
            $conditions = array('Quiz.id' => $id);
            $contain = array(
                    'QuizQuestion' => array('fields' => array('id', 'title', 'image'),
                    'QuizAnswer' => array('fields' => array('id', 'answer', 'image','right_answer')),
                )
            );
            $datasets = $this->Quiz->find('first', array(
                'contain' => $contain,
                'conditions' => $conditions,
            ));
            //pr($datasets); die;
        }
        $view = new View($this, false);
        $content = $view->element('quiz_modal', array('datasets' => $datasets, 'id' => $id));
        echo $content;
        die;
    }

    /**
     * @author Vipul Sharma
     * @since 1 Sept 2014
     */
    public function fetch_polls() {
        $this->autoRender = FALSE;
        $this->loadModel('Poll');
        $params = $this->request->data;
        $datasets = array();
        $id = '';
        if (isset($params['id']) && !empty($params['id'])) {
            $id = $params['id'];
            $this->Poll->Behaviors->load('Containable');
            $conditions = array('Poll.id' => $id);
            $contain = array(
                'PollQuestion' => array('fields' => array('id', 'question', 'image'),
                    'PollAnswer' => array('fields' => array('id', 'answer', 'image')),
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

    /**
     * @author Vipul Sharma
     * @since 1 Sept 2014
     */
    public function fetch_meme(){
        $this->autoRender = FALSE;
        $this->loadModel('MemeImage');
        $this->loadModel('Meme');
        $params = $this->request->data;
        $datasets = array();
        $id = '';
       //$params['id'] = 27;
        if(isset($params['id']) && !empty($params['id'])) {
            $id = $params['id'];
            $this->Meme->recursive = 2;

//            $datasets = $this->Meme->bindModel(
//                    array('hasMany' => array(
//                            'MemeImage' => array(
//                                'className' => 'MemeImage',
//                                'foreignKey' => 'meme_image_id'
//                            )
//                        )
//                    )
//            );
            $fields= array('Meme.* ,MemeImage.image ');
            $datasets = $this->Meme->find('first', array('fields'=>$fields,'conditions' => array('Meme.id' => $params['id'])));
//            pr($datasets);
//            die('heree');
            $this->request->data = $datasets;
        }
        $user_id = $this->Session->read('UserInfo.id');
        $this->MemeImage->recursive = -1;
        $user_conditions = array('MemeImage.author' => 'user', 'MemeImage.user_id' => $user_id);
        $user_meme = $this->MemeImage->find('all', array(
            'conditions' => $user_conditions
        ));
        $datasets['user'] = $user_meme;
        $admin_conditions = array('MemeImage.author' => 'admin');
        $admin_meme = $this->MemeImage->find('all', array(
            'conditions' => $admin_conditions
        ));
        $datasets['admin'] = $admin_meme;
//        pr($datasets);
//        die;
        $view = new View($this, false);
        $content = $view->element('meme_modal', array('datasets' => $datasets, 'id' => $id));
        echo $content;
        die;
    }

    /**
     * @author Vipul Sharma
     * @since 1 Sept 2014
     */
    
    public function fetch_lineup() {
        $this->loadModel('Lineup');
        $this->autoRender = false;
        $params = $this->request->data;
        $datasets = array();
        $lineup_select = array(
            'lineup1' => '4-4-2',
            'lineup2' => '3-4-3'
        );
        $id = '';
        //$params['id'] = 1;
        if (isset($params['id']) && !empty($params['id'])) {
            $id = $params['id'];
            $datasets = $this->Lineup->find('all', array('conditions' => array('Lineup.id' => $params['id'])));
        }
        //pr($datasets);die;
        $view = new View($this, false);
        $content = $view->element('lineup_modal', array('datasets' => $datasets, 'id' => $id, 'lineup_select' => $lineup_select));
        echo $content;
    }

    /**
     * @author Vipul Sharma
     */
    public function deleteRecord() {
        pr($this->request->data);
        die;
    }

    /**
     * @author Vipul Sharma
     */
    public function upload_files(){
        $this->autoRender = FALSE;
        //pr($_REQUEST);die;
        //move_uploaded_file($_FILES["file"]["tmp_name"], 'upload_dir/' . $_FILES["file"]["name"]);
        if($this->is_valid_type($_FILES['file']['tmp_name'])){
        list($width, $height, $type, $attr) = getimagesize($_FILES["file"]['tmp_name']);    
        $field = "image";
        $location = "img/".$this->request->data['type'];
        $folder_name = 'original';
        $multiple[] = array('folder_name' => 'thumb', 'height' => '140', 'width' => '155');
        $response = $this->Common->upload_image($_FILES['file'], $location, $folder_name, true, $multiple);
        echo json_encode(array('image' => $response,'width'=>$width));
        }else{
        $return_array = array(
                        'error' => 'Only image type "jpg|gif|png|jpeg"  are allowed!'
                        );
                        echo json_encode($return_array);  
        }
      die;
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
    
    
    
    function __checkContentId($content_id = NULL){
        $this->loadModel('Content');
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

    /**
     * @author Vipul Sharma
     * @since 8 Sept 2014
     */
    public function lineup(){
        $this->autoRender = FALSE;
        $this->loadModel('Lineup');
        $this->loadModel('LineupItem');
        if ($this->request->is(array('put', 'post'))){
            $content_id = $this->__checkContentId($this->request->data['content_id']);
            if (empty($this->request->data['Lineup']['lineup_id'])) {
                $new_list['Lineup']['content_id'] = $content_id;
                /* Assocaite list with Content */
                $this->Lineup->create();
                $this->Lineup->save($new_list);
                $lineup_id = $this->Lineup->getLastInsertId();
                $query_type = 'insert';
            } else {
                $lineup_id = $this->request->data['Lineup']['lineup_id'];
                $this->LineupItem->deleteAll(array('lineup_id' => $lineup_id), false);
                $query_type = 'update';
            }
            $player = $this->request->data['Lineup']['players'];
            $lineup['LineupItem']['lineup_id'] = $lineup_id;
            $lineup['LineupItem']['lineup_class'] = $this->request->data['Lineup']['lineup_class'];
            $lineup['LineupItem']['players'] = json_encode($player);
            $this->LineupItem->create();
            $this->LineupItem->save($lineup);
        }
        $return_array = array(
            'content_id' => $content_id,
            'lineup_id' => $lineup_id,
            'query_type' => $query_type,
            'box_text' => $this->request->data['Lineup']['lineup_text'],
        );
        // pr($return_array); die;
        return json_encode($return_array);
        die;
    }

    function home(){
                  $this->layout = 'index';
                  $this->set('title_for_layout', 'Footybase');
		  $this->loadModel('PostComment'); 
		  $this->loadModel('PostCommentLike');
		  $this->Content->bindModel(array('hasMany'=>array('Photo')));
		  $this->Content->unBindModel(array('hasMany'=>array('PostComment')));
        $popular_posts = $this->Content->find('all', array('conditions' => array('Content.status' => 1),'order'=>array('Content.views DESC'),'limit' => 5));
			
	$this->Content->bindModel(array('hasMany'=>array('Photo')));
        $contents = $this->Content->find('all', array('conditions' => array('Content.status' => 1),'order'=>array('Content.id DESC'),'limit' => 9));
        $allcontents = $this->Content->find('count', array('conditions' => array('Content.status' => 1)));
        //print_r($contents);
        $this->set(compact('contents', 'allcontents','popular_posts'));
    }

    function ajaxhome($limit,$tagid='') {
        $this->layout = 'ajax';
        $this->loadModel('Photo');
        $this->loadModel('User');
			$this->loadModel('TagSum');
			$this->Content->bindModel(array('hasMany'=>array('Photo')));
			if(!empty($tagid)){
				$tagsumcontentids=$this->TagSum->find('all',array('conditions'=>array('TagSum.tag_id'=>$tagid),'fields'=>array('TagSum.content_id'))); 
				$contentIds=array();
				foreach($tagsumcontentids as $tagsumcontentid){$contentIds[]=$tagsumcontentid['TagSum']['content_id'];}
				$contentIds =array_unique($contentIds); 
				$contents = $this->Content->find('all', array('conditions' => array('Content.status' =>1,'Content.id'=>$contentIds),'order'=>array('Content.id DESC'), 'limit' => $limit));
			}else{
				$contents = $this->Content->find('all', array('conditions' => array('Content.status' => 1),'order'=>array('Content.id DESC'), 'limit' => $limit));
			}
        $message = array();
        foreach($contents as $content) { //pr($content);
				$postid = $content['Content']['id'];
            if (!empty($content['Content']['title'])) {
                $title = substr($content['Content']['title'], 0, 40) . '...';
            } else {
                $title = '';
            }
            $usrid = $content['Content']['user_id'];
            $user = $this->User->find('first', array('conditions' => array('User.id' => $usrid)));
            $firstname = $user['User']['first_name'];

            if (!empty($user['User']['avatar_image'])) {
                $primage = '<img src="/img/avatar/' . $user['User']['avatar_image'] . '" style="max-width:10%" />';
            } else {
                $primage = '<img src="/img/avatar/no_image.png" style="max-width:10%" />';
            }

            if (!empty($content['Photo'])) {
                if ($content['Photo'][0]['image_type'] == 'file') {
                    $photoimage = '<a href=/contents/post_details/'.$postid.'><img src="/timthumb.php?src=/img/photos/thumb/'.$content['Photo'][0]['image'].'&h=191&w=236&zc=1"></a>';
                } else {
                    $photoimage = '<a href=/contents/post_details/'.$postid.'><img src="/timthumb.php?src='.$content['Photo'][0]['image'].'&h=191&w=236&zc=1"></a>';
                }
            } else {
                $photoimage = '<a href=/contents/post_details/'.$postid.'><img src="/timthumb.php?src=/img/photos/thumb/soccer-ball-128.png&h=191&w=236&zc=1"></a>';
            }
            $creatd = $content['Content']['created'];
            $new_date = date('Y-m-d h:i:s');
            $date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
            $date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
            $num_day = $date1->diff($date2)->days;
            if ($num_day == '0') {
                $dayss = '- Today';
            } else if ($num_day == '1') {
                $dayss = ' -' . $num_day . ' day ago';
            } else {
                $dayss = ' -' . $num_day . ' days ago';
            }

            echo '<section class="col-sm-4 product">
                <p class="productpic m-productpic">' . $photoimage . '</p>
                <h4>' . $title . '</h4>
                <section class="user-sec">
                    <span class="userpic">' . $primage . '</span>
                    <span class="post-time"><strong>' . $firstname . '</strong>' . $dayss . '</span>
                </section>
            </section>';
        }
        exit;
    }
	 function post_details($Pid=NULL){
		$this->layout = 'index';
		$this->set('title_for_layout', 'Footybase');
		$this->loadModel('User');
		$this->loadModel('PostComment'); 
		$this->loadModel('TagSum');
		$this->loadModel('PageView');
		$this->loadModel('PostCommentLike'); 
		$this->loadModel('PollPreviewResult');
                /* adding page views count */
                 $checkvalue=$this->PageView->find('first',array('conditions'=>array('PageView.page_name_id'=>$Pid,'PageView.IP_address'=>$_SERVER['REMOTE_ADDR'])));
                 //pr($checkvalue); die;
                 $ip = $_SERVER['REMOTE_ADDR'];
                 $page_view['page_name_id']=$Pid;
		 $page_view['IP_address']=$_SERVER['REMOTE_ADDR']; 
                 if(empty($checkvalue)){
                 $page_count = 1; $profit = '1';
                 if(@$_GET['uid']){
		 $profit = '.5'; /* 50 % for sub owner  */
                 $page_view['uid']=  base64_decode($_GET['uid']);
                 $page_view['page_count']=$page_count;
                 $page_view['profit']=$profit;
		 $this->PageView->create();
		 $this->PageView->save($page_view);
                 $page_count = 0;
                 } 
                $this->Content->recursive = -1;
                $user_id = $this->Content->find('first' , array('conditions'=>array('Content.id'=>$Pid), 'fields'=>array('Content.user_id')));
                //pr($user_id);die;
                $page_view['page_count']=$page_count;
                $page_view['profit']=$profit;
		$page_view['uid']=$user_id['Content']['user_id'];
		$this->PageView->create();
		$this->PageView->save($page_view);
		$this->Content->id=$Pid;
		$view_data=$this->Content->read();
                $this->Content->saveField("views",$view_data['Content']['views']+1);
                }
		$count_page_view = $this->PageView->find('count',array('conditions'=>array('PageView.page_name_id'=>$Pid))); 
		$contentfirst = $this->Content->find('first',array('conditions'=>array('Content.id'=>$Pid,'Content.status'=>1),'fields'=>array('Content.content_order'))); 
		$indexvalue = array();
		$CCC = json_decode($contentfirst['Content']['content_order'],true); //debug($CCC);
		if(!empty($CCC)){
         foreach ($CCC as $c){
			  foreach ($c as $key=>$val){
				 $indexvalue[] =ucfirst($key);
			  }
		   }
		}
		//debug($indexvalue);
		$this->Content->bindModel(array('hasMany'=>$indexvalue));
		$content = $this->Content->find('first',array('conditions'=>array('Content.id'=>$Pid,'Content.status'=>1),'contain'=> $indexvalue)); 
		$userid = $content['Content']['user_id'];
		$users = $this->User->find('first',array('conditions'=>array('User.id'=>$userid)));
		$allpostcomments = $this->PostCommentLike->PostComment->find('all',array('conditions'=>array('PostComment.content_id'=>$Pid)));
		$allpostcounts = $this->PostComment->find('count',array('conditions'=>array('PostComment.content_id'=>$Pid)));
		if(!empty($allpostcounts)){$allpostcounts = $allpostcounts;}else{$allpostcounts=0;}
		$tagsumarray=array();
		$alltagsums=$this->TagSum->find('all',array('conditions'=>array('TagSum.content_id'=>$Pid)));
		foreach($alltagsums as $alltagsum){$tagsumarray[]=$alltagsum['TagSum']['tag_id'];}
		$tagIDs = array_unique($tagsumarray);
		$lastcommentids=$this->PostComment->find('first', array('order' => array('PostComment.id' =>'desc'),'fields'=>array('PostComment.id'))); $lastcommentid = $lastcommentids['PostComment']['id'];
		
      $this->set(compact('content','users','allpostcomments','allpostcounts','tagIDs','count_page_view','lastcommentid','indexvalue'));
	}
	
	function ajaxpostcomment(){ 
		$this->layout = 'ajax';
                $this->loadModel('PostComment'); 
                $this->loadModel('User'); 
                $this->loadModel('PostCommentLike'); 
		$user_id = $this->Session->read('UserInfo.id'); 
		$contentId = $this->request->data['PostComment']['content_id'];
		if(!empty($this->request->data['PostComment']['comment_image'])){
		$commentImage = $this->request->data['PostComment']['comment_image'];
		}else{$commentImage='';}	
		$data['comments'] = $this->request->data['PostComment']['comment'];
		$data['comment_image'] = $commentImage;
		$data['content_id'] = $contentId;
		$data['image_type'] = $this->request->data['PostComment']['image_type'];
		$data['parent_id'] = $this->request->data['PostComment']['parent_id'];
		$data['user_id'] = $user_id;
		//$data['comments'] = $_POST['PostComment']['comment'];
		$this->PostComment->create();
		$this->PostComment->save($data);
		$allpostcomments = $this->PostComment->find('all',array('conditions'=>array('PostComment.content_id'=>$contentId)));
		$lastcommentids=$this->PostComment->find('first', array('order' => array('PostComment.id' =>'desc'),'fields'=>array('PostComment.id'))); $lastcommentid = $lastcommentids['PostComment']['id'];
		if(!empty($allpostcomments)){
			foreach($allpostcomments as $allpostcomment){
				$parentids = $allpostcomment['PostComment']['id'];
				$postid = $allpostcomment['PostComment']['content_id'];
				$like_data = $this->PostCommentLike->find('count', array('conditions' => array('PostCommentLike.post_comment_id' =>$parentids,'PostCommentLike.post_like'=>'1')));
				$dislike_data = $this->PostCommentLike->find('count', array('conditions' => array('PostCommentLike.post_comment_id' =>$parentids,'PostCommentLike.post_dislike'=>'1')));
				if(!empty($like_data)){$like=$like_data;}else{$like='0';}
				if(!empty($dislike_data)){$dislike=$dislike_data;}else{$dislike='0';}
				$creatd = $allpostcomment['PostComment']['created']; $new_date = date('Y-m-d h:i:s');
				 $date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
				  $date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
				  $num_day=$date1->diff($date2)->days; 
				  if($num_day == '0'){ $ndays = 'Today';}
				  else if($num_day == '1'){ $ndays = $num_day.' day ago';}
				  else{$ndays = $num_day.' days ago';}
			
				if(!empty($allpostcomment['PostComment']['comments'])){
					$postcommnt = $allpostcomment['PostComment']['comments'];
				}else{$postcommnt = '';}
				if (!empty($allpostcomment['PostComment']['comment_image']) && ($allpostcomment['PostComment']['image_type']=='File')){
					$imagetype = '<img src="/img/comments/thumb/'.$allpostcomment['PostComment']['comment_image'].'"/>';
				}else if (!empty($allpostcomment['PostComment']['comment_image']) && ($allpostcomment['PostComment']['image_type']=='Gallery')){
					$imagetype = '<img src="'.$allpostcomment['PostComment']['comment_image'].'"/>';
				}else{$imagetype = '';}
				$usrid = $allpostcomment['PostComment']['user_id'];
                                $user = $this->User->find('first', array('conditions' => array('User.id' => $usrid)));
				$username = $user['User']['username'];
                                if (!empty($user['User']['avatar_image'])) {
                                $primage = '<img src="/img/avatar/' . $user['User']['avatar_image'].'"/>';
                                } else {
                                    $primage = '<img src="/img/avatar/no_image.png" />';
                                }
                                           echo '<li id="licomment'.$parentids.'">
					   <section class="user-comment-head clearfix">';
					   if(empty($allpostcomment['PostComment']['parent_id'])){
										echo '<section class="col-sm-9 postrow">
											<span class="userpic">'.$primage.'</span>
											<span class="post-time"><a href="#"><strong>'.$username.'</strong></a></span>
										</section>
										<section class="col-sm-3 postrow">
											<section class="comment-date">'.$ndays.'</section>
										</section>
									
									</section>
									<section class="user-comment-box">
									<section class="user-comment-txt" >'.$imagetype.'<p>'.$postcommnt.'</p>
										</section>
										<section class="user-reply">
											<span class="reply-text">
												<a href="javascript:void(0)" onclick="addcommentbox('.$postid.','.$parentids.','.$parentids.','.$lastcommentid.')">Reply</a>
											</span>
											<span class="reply-icon">
												<a class="like-icn" href="javascript:void(0)" onclick="likedislikecomment(1,0,'.$parentids.','.$postid.')"></a><span id="likecomment'.$parentids.'">'.$like.'</span>&nbsp;&nbsp;&nbsp;&nbsp;
												<a class="dislike-icn" href="javascript:void(0)" onclick="likedislikecomment(0,1,'.$parentids.','.$postid.')"></a><span id="dislikecomment'.$parentids.'">'.$dislike.'</span>
											</span>
										<section class="removereplybox replybox'.$parentids.'"></section>	
										</section>';
											} 
									$childpost=$this->PostComment->find('all', array('conditions' => array('PostComment.parent_id' =>$allpostcomment['PostComment']['id'])));
									if(!empty($childpost)){ 
									foreach($childpost as $child){
									$usrid = $child['PostComment']['user_id'];
									$parentid = $child['PostComment']['id'];
									$postid = $child['PostComment']['content_id'];
									$like_data = $this->PostCommentLike->find('count', array('conditions' => array('PostCommentLike.post_comment_id' =>$parentid,'PostCommentLike.post_like'=>'1')));
									$dislike_data = $this->PostCommentLike->find('count', array('conditions' => array('PostCommentLike.post_comment_id' =>$parentid,'PostCommentLike.post_dislike'=>'1')));
									if(!empty($like_data)){$like=$like_data;}else{$like='0';}
									if(!empty($dislike_data)){$dislike=$dislike_data;}else{$dislike='0';}
									
									$creatd = $child['PostComment']['created']; $new_date = date('Y-m-d h:i:s');
									 $date1 = new DateTime(date('Y-m-d', strtotime($creatd)));
									  $date2 = new DateTime(date('Y-m-d', strtotime($new_date)));
									  $num_day=$date1->diff($date2)->days; 
									  if($num_day == '0'){ $ndays = 'Today';}
									  else if($num_day == '1'){ $ndays = $num_day.' day ago';}
									  else{$ndays = $num_day.' days ago';}
								
										if(!empty($child['PostComment']['comments'])){
											$postcommnt = $child['PostComment']['comments'];
										}else{$postcommnt = '';}
										if (!empty($child['PostComment']['comment_image']) && ($child['PostComment']['image_type']=='File')){
											$imagetype = '<img src="/img/comments/thumb/'.$child['PostComment']['comment_image'].'"/>';
										}else if (!empty($child['PostComment']['comment_image']) && ($child['PostComment']['image_type']=='Gallery')){
											$imagetype = '<img src="'.$child['PostComment']['comment_image'].'"/>';
										}else{$imagetype = '';}
										$usrid = $child['PostComment']['user_id'];
									$user = $this->User->find('first', array('conditions' => array('User.id' => $usrid)));
										$username = $user['User']['username'];
									if (!empty($user['User']['avatar_image'])) {
											$primage = '<img src="/img/avatar/' . $user['User']['avatar_image'].'"/>';
									} else {
										$primage = '<img src="/img/avatar/no_image.png" />';
									}
										
										echo '<section class="user-comment-box2">
											<section class="user-comment-head clearfix">
											<section class="col-lg-9 postrow">
												<span class="userpic">'.$primage.'</span>
												<span class="post-time"><a href="javascript:void(0)"><strong>'.$username.'</strong></a></span>
											</section>
											<section class="col-lg-3 postrow">
												<section class="comment-date">'.$ndays.'</section>
											</section>
										</section>
											<section class="user-comment-txt" id="commnet'.$parentid.'">'.$imagetype.'<p>'.$postcommnt.'</p>
										</section>
											<section class="user-reply">
											<span class="reply-text">
											</span>
											<span class="reply-icon">
												<a class="like-icn" href="javascript:void(0)" onclick="likedislikecomment(1,0,'.$parentid.','.$postid.')"></a><span id="likecomment'.$parentid.'">'.$like.'</span>&nbsp;&nbsp;&nbsp;&nbsp;
												<a class="dislike-icn" href="javascript:void(0)" onclick="likedislikecomment(0,1,'.$parentid.','.$postid.')"></a><span id="dislikecomment'.$parentid.'">'.$dislike.'</span>
											</span>
										<section class="removereplybox replybox'.$parentid.'"></section>	
										</section>
										</section>';
										} }
									echo '<section class="clear-both"></section>
									</section>
				</li>';
			}
		}
		exit;
	}
	 /*
     * name: upload_image
     * Functionality - Upload image
     * Developer - Kirpal
     * Created date - 10-Jul-2014   
     * @param data,model,field,location
     * @return images
     */

    function insertCommentPhoto() {
        $this->autoRender = FALSE;
        $field = "image";
        $location = "img/comments";
        $folder_name = 'original';
        $multiple[] = array('folder_name' => 'thumb', 'height' => '100', 'width' => '100');
        $response = $this->Common->upload_image($_FILES['file'], $location, $folder_name, true, $multiple);
	echo $response;
        exit;
    }

        function insertCommentPhotoUrl(){
                $image = $this->request->data['content_url'];
                echo $image;
                exit;
        }
	function tag_contents($tagid=NULL){
		$this->layout = 'index';
		$this->set('title_for_layout', 'Footybase');
		$this->loadModel('TagSum');
		$this->loadModel('Tag');
		if(!(is_numeric($tagid))){
			$tagNameId=$this->Tag->find('first',array('conditions'=>array('Tag.tag_name'=>$tagid),'fields'=>array('Tag.id'))); 
			if(!empty($tagNameId)){$tagid = $tagNameId['Tag']['id'];}else{$tagid = '';}
		}
		$tagsumcontentids=$this->TagSum->find('all',array('conditions'=>array('TagSum.tag_id'=>$tagid),'fields'=>array('TagSum.content_id'))); 
		$contentIds=array();
		foreach($tagsumcontentids as $tagsumcontentid){$contentIds[]=$tagsumcontentid['TagSum']['content_id'];}
		$contentIds =array_unique($contentIds); 
		$this->Content->bindModel(array('hasMany'=>array('Photo')));
		$contents = $this->Content->find('all', array('conditions' => array('Content.status' =>1,'Content.id'=>$contentIds),'order'=>array('Content.id DESC'),'limit' =>9));
		$allcontents = count($contentIds);
		$this->set(compact('contents', 'allcontents'));
	}
	function ajaxcommentlikedislike(){
		$this->layout = 'ajax';
                $this->loadModel('PostCommentLike');
		$checkvalue=$this->PostCommentLike->find('first',array('conditions'=>array('PostCommentLike.post_comment_id'=>$_POST['comment_id'],'PostCommentLike.IP_address'=>$_SERVER['REMOTE_ADDR'])));
		if(empty($checkvalue)){
			$page_view['content_id']=$_POST['post_comment_id'];
			$page_view['post_comment_id']=$_POST['comment_id'];
			$page_view['post_like']=$_POST['like'];
			$page_view['post_dislike']=$_POST['dislike']; 
			$page_view['IP_address']=$_SERVER['REMOTE_ADDR'];
			$this->PostCommentLike->create();
			$this->PostCommentLike->save($page_view);
			$message = 'Your Like for this Comment Saved Successfully';
                        }else{
                        $commentlikeid=$this->PostCommentLike->find('first',array('conditions'=>array('PostCommentLike.IP_address'=>$_SERVER['REMOTE_ADDR'],'PostCommentLike.post_comment_id'=>$_POST['comment_id']),'fields'=>array('PostCommentLike.id')));
			$page_view['content_id']=$_POST['post_comment_id'];
			$page_view['post_comment_id']=$_POST['comment_id'];
			$page_view['post_like']=$_POST['like'];
			$page_view['post_dislike']=$_POST['dislike'];
			$page_view['IP_address']=$_SERVER['REMOTE_ADDR'];
			$this->PostCommentLike->id=$commentlikeid['PostCommentLike']['id'];
			$this->PostCommentLike->save($page_view);
			$message = 'Your Dislike for this Comment Saved Successfully';
		}
		$likecountpost = $this->PostCommentLike->find('count',array('conditions'=>array('PostCommentLike.post_comment_id'=>$_POST['comment_id'],'PostCommentLike.post_like'=>'1')));
		$dislikecountpost = $this->PostCommentLike->find('count',array('conditions'=>array('PostCommentLike.post_comment_id'=>$_POST['comment_id'],'PostCommentLike.post_dislike'=>'1'))); 
		$return=array($message,$likecountpost,$dislikecountpost); 
                echo  json_encode($return); 
		exit;
	}
	function quizpreview($Pid=NULL){
		$this->layout = 'index';
		$this->set('title_for_layout', 'Footybase');
		$this->loadModel('User');
		$this->loadModel('PostComment'); 
		$this->loadModel('TagSum');
		$this->loadModel('PostCommentLike');
		$this->loadModel('QuizQuestion');
               
		$contentfirst = $this->Content->find('first',array('conditions'=>array('Content.id'=>$Pid,'Content.status'=>1),'fields'=>array('Content.content_order'))); 
		$indexvalue = array();
		$CCC = json_decode($contentfirst['Content']['content_order'],true); //debug($CCC);
		if(!empty($CCC)){
         foreach ($CCC as $c){
			  foreach ($c as $key=>$val){
				 $indexvalue[] =ucfirst($key);
			  }
		   }
		}
		//debug($indexvalue);
		$this->Content->bindModel(array('hasMany'=>$indexvalue));
		$content = $this->Content->find('first',array('conditions'=>array('Content.id'=>$Pid,'Content.status'=>1),'contain'=> $indexvalue)); 
		$userid = $content['Content']['user_id'];
		$users = $this->User->find('first',array('conditions'=>array('User.id'=>$userid)));
		
		$tagsumarray=array();
		$alltagsums=$this->TagSum->find('all',array('conditions'=>array('TagSum.content_id'=>$Pid)));
		foreach($alltagsums as $alltagsum){$tagsumarray[]=$alltagsum['TagSum']['tag_id'];}
		$tagIDs = array_unique($tagsumarray);
		$quiz_id = $content['Quiz'][0]['id'];
		$quiz_qstns = $this->QuizQuestion->find('all', array('conditions' => array('QuizQuestion.quiz_id' =>$quiz_id)));
		$quiz_qstn_count = $this->QuizQuestion->find('count', array('conditions' => array('QuizQuestion.quiz_id' =>$quiz_id)));
      $this->set(compact('content','users','tagIDs','count_page_view','quiz_qstns','quiz_qstn_count'));
	}
	
	function ajaxquizpreviewresult(){
		$this->layout = 'ajax';
		$this->loadModel('QuizQuestion');
      $this->loadModel('QuizPreviewResult');
	   $this->loadModel('QuizAnswer');
	   $this->loadModel('Quiz');
	  $qtn_id=$_POST['quiz_questions_id'];
	  $quiz_id=$_POST['quiz_id'];
	  
		$quiz_qstn = $this->QuizQuestion->find('first', array('conditions' => array('QuizQuestion.id' =>$qtn_id)));
		$quiz_qstn_count = $this->QuizQuestion->find('count', array('conditions' => array('QuizQuestion.quiz_id' =>$quiz_id)));
		$allqtnIDs=array();
		$quiz_qstns = $this->QuizQuestion->find('all', array('conditions' => array('QuizQuestion.quiz_id' =>$quiz_id)));
		foreach($quiz_qstns as $quiz_qstnss){$allqtnIDs[]=$quiz_qstnss['QuizQuestion']['id'];} 
		
			if (!empty($quiz_qstn['QuizQuestion']['image'])){
				$image_name = $quiz_qstn['QuizQuestion']['image'];
				$qtnImage='<img src=/img/quiz/original/'.$image_name.'>';
			} else {
				$qtnImage='';
			}
			
			if($qtn_id !='Result'){$qtn_title=$quiz_qstn['QuizQuestion']['title'];}
			
			$quiz =$this->Quiz->find('first',array('conditions'=>array('Quiz.id'=>$quiz_id)));
			if (!empty($quiz['Quiz']['image'])){
				$quiz_image_name = $quiz['Quiz']['image'];
				$quiz_image='<img src=/img/quiz/original/'.$quiz_image_name.'>';
			} else {
				$quiz_image='';
			}
			
	  $preview_results=$this->QuizPreviewResult->find('all',array('conditions'=>array('QuizPreviewResult.quiz_id'=>$quiz_id,'QuizPreviewResult.IP_address'=>$_SERVER['REMOTE_ADDR']),'fields'=>array('QuizPreviewResult.quiz_answer_id'))); 
		$quiz_answer_ids=array();
		foreach($preview_results as $preview_result){
			$quiz_answer_ids[]=$preview_result['QuizPreviewResult']['quiz_answer_id'];
		}
		$total_attempt=count($quiz_answer_ids);
		$total_quiz_answers=$this->QuizAnswer->find('count', array('conditions' => array('QuizAnswer.id' =>$quiz_answer_ids,'QuizAnswer.right_answer'=>1)));
		$your_correct_answer = $total_quiz_answers.'/'.$quiz_qstn_count;
		$you_scored= ($total_quiz_answers/$quiz_qstn_count)*100;		
			if($qtn_id=='Result'){
			 echo '<section class="col-lg-12">
                                <section class="quiz-middle">
                                	<p>'.$quiz_image.'</p>
                                </section>
                                <section class="quiz-correct-ans">
                                	<p>You answered '.$your_correct_answer.' correct answers</p>
									<h5>Your score: '.round($you_scored,2).'%</h5>
                                </section>
                            </section>';
			}else{				
			echo '<section class="col-lg-12">
					<section class="quiz-page">
						<a class="pre-slide" href="#"><i class="fa fa-angle-left"></i></a>
						<a class="nxt-slide" href="#"><i class="fa fa-angle-right "></i></a>
						<ul class="pagination page-diff">'; $cntnmb=1;
						   for($i=0;$i < $quiz_qstn_count; $i++,$cntnmb++){ 
						   if($qtn_id==$allqtnIDs[$i]){
							 echo '<li><a href=javascript:void(0) onclick=showquizpreview('.$allqtnIDs[$i].','.$quiz_id.') style="background:#559ebf; color:#fff;">'.$cntnmb.'</a></li>';
						   }else{
							 echo '<li><a href=javascript:void(0) onclick=showquizpreview('.$allqtnIDs[$i].','.$quiz_id.')>'.$cntnmb.'</a></li>';
						   }
							
							 } 
						echo '</ul>
					</section>
					 <section class="quiz-middle">
					 <div class="quiz-pic-mn-rw">
						<div class="quiz-pic-mn">
						<p>'.$qtnImage.'</p>
						</div>';
						
						$lastqtn=end($allqtnIDs);
							if($lastqtn == $qtn_id){
						echo '<div class="get-answers-box"><p class="m-btm0"><a class="btn btn-blue bl-element" href="javascript:void(0)" onclick=showquizpreview('."'Result'".','.$quiz_id.')>Get Your Result></a></p></div>';
						}
					echo '</div><p class="quiz-qus quiz-qus-full">'.$qtn_title.'</p>';
					echo '</section>
					<section class="quiz-ans quizans-custom quiz-ans-border">';
						if(!empty($quiz_qstn['QuizAnswer'])){ foreach($quiz_qstn['QuizAnswer'] as $quiz_answer){
						$quizanswer=$quiz_answer['answer'];
						echo '<section class="quizans transition" id="quizanswer'.$quiz_answer['id'].'" onclick="savepreviewresult('.$quiz_id.','.$quiz_answer['quiz_questions_id'].','.$quiz_answer['id'].')">
							<div class="media">
								  <a href="javascript:void(0)" class="pull-left quiz-img">';
								 if (!empty($quiz_answer['image'])){
									$image_name = $quiz_answer['image'];
									echo '<img src=/img/quiz/thumb/'.$image_name.' class="media-object">';
								} else {
									echo '';
								}			 
							echo '</a>
								  <div class="media-body">
								   <div class="quiz-cont">
								   <p>'.$quizanswer.'</p>
								   </div>
								  </div>
								</div>
						</section>';
						} } 
					echo '</section>
				</section>';
			}	
		exit;
	 }
	 function ajaxquizpreviewanswer(){
		$this->layout = 'ajax';
      $this->loadModel('QuizPreviewResult');
		$this->loadModel('QuizAnswer');
		
		$checkvalue=$this->QuizPreviewResult->find('first',array('conditions'=>array('QuizPreviewResult.quiz_id'=>$_POST['quiz_id'],'QuizPreviewResult.quiz_question_id'=>$_POST['quiz_questions_id'],'QuizPreviewResult.IP_address'=>$_SERVER['REMOTE_ADDR'])));
		if(empty($checkvalue)){
			$quiz_preview_result['quiz_id']=$_POST['quiz_id'];
			$quiz_preview_result['quiz_question_id']=$_POST['quiz_questions_id'];
			$quiz_preview_result['quiz_answer_id']=$_POST['quiz_answer_id'];
			$quiz_preview_result['IP_address']=$_SERVER['REMOTE_ADDR'];
			$this->QuizPreviewResult->create();
			$this->QuizPreviewResult->save($quiz_preview_result);
			$message = 'Your Answer Saved Successfully';
			}else{
			$update_result['quiz_id']=$_POST['quiz_id'];
			$update_result['quiz_question_id']=$_POST['quiz_questions_id'];
			$update_result['quiz_answer_id']=$_POST['quiz_answer_id'];
			$update_result['IP_address']=$_SERVER['REMOTE_ADDR'];
			//$this->QuizPreviewResult->id=$checkvalue['QuizPreviewResult']['id'];
			//$this->QuizPreviewResult->save($update_result);
			$message = 'Your Answer Updated Successfully';
		}
		$quiz_answers=$this->QuizAnswer->find('first', array('conditions' => array('QuizAnswer.quiz_questions_id' =>$_POST['quiz_questions_id'],'QuizAnswer.right_answer'=>1)));
		if($quiz_answers['QuizAnswer']['id']==$_POST['quiz_answer_id']){
		  $right_answer = $_POST['quiz_answer_id'];
		  $your_answer = $_POST['quiz_answer_id'];
		}else{
			$right_answer = $quiz_answers['QuizAnswer']['id'];
			$your_answer = $_POST['quiz_answer_id'];
		}
		 $return=array($right_answer,$your_answer); 
        echo json_encode($return);
		//echo $message;
		exit;
	 }
	function quizpreviewresult($Pid=NULL){
		$this->layout = 'index';
		$this->set('title_for_layout', 'Footybase');
		$this->loadModel('User');
		$this->loadModel('PostComment'); 
		$this->loadModel('TagSum');
		$this->loadModel('QuizQuestion');
		$this->loadModel('QuizAnswer');
		$this->loadModel('QuizPreviewResult');
               
		$contentfirst = $this->Content->find('first',array('conditions'=>array('Content.id'=>$Pid,'Content.status'=>1),'fields'=>array('Content.content_order'))); 
		$indexvalue = array();
		$CCC = json_decode($contentfirst['Content']['content_order'],true); //debug($CCC);
		if(!empty($CCC)){
         foreach ($CCC as $c){
			  foreach ($c as $key=>$val){
				 $indexvalue[] =ucfirst($key);
			  }
		   }
		}
		//debug($indexvalue);
		$this->Content->bindModel(array('hasMany'=>$indexvalue));
		$content = $this->Content->find('first',array('conditions'=>array('Content.id'=>$Pid,'Content.status'=>1),'contain'=> $indexvalue)); 
		$userid = $content['Content']['user_id'];
		$users = $this->User->find('first',array('conditions'=>array('User.id'=>$userid)));
		
		$tagsumarray=array();
		$alltagsums=$this->TagSum->find('all',array('conditions'=>array('TagSum.content_id'=>$Pid)));
		foreach($alltagsums as $alltagsum){$tagsumarray[]=$alltagsum['TagSum']['tag_id'];}
		$tagIDs = array_unique($tagsumarray);
		
		$quiz_id = $content['Quiz'][0]['id'];
		$quiz_qstn_count = $this->QuizQuestion->find('count', array('conditions' => array('QuizQuestion.quiz_id' =>$quiz_id)));
		$preview_results=$this->QuizPreviewResult->find('all',array('conditions'=>array('QuizPreviewResult.quiz_id'=>$quiz_id,'QuizPreviewResult.IP_address'=>$_SERVER['REMOTE_ADDR']),'fields'=>array('QuizPreviewResult.quiz_answer_id'))); 
		$quiz_answer_ids=array();
		foreach($preview_results as $preview_result){
			$quiz_answer_ids[]=$preview_result['QuizPreviewResult']['quiz_answer_id'];
		}
		$total_attempt=count($quiz_answer_ids);
		$total_quiz_answers=$this->QuizAnswer->find('count', array('conditions' => array('QuizAnswer.id' =>$quiz_answer_ids,'QuizAnswer.right_answer'=>1)));
		$your_correct_answer = $total_quiz_answers.'/'.$quiz_qstn_count;
		$you_scored= ($total_quiz_answers/$quiz_qstn_count)*100;
      $this->set(compact('content','users','tagIDs','count_page_view','your_correct_answer','you_scored'));
	}
	function ajaxpollpreviewresult(){
		$this->layout = 'ajax';
      $this->loadModel('PollPreviewResult');
		
		$checkvalue=$this->PollPreviewResult->find('first',array('conditions'=>array('PollPreviewResult.poll_id'=>$_POST['poll_id'],'PollPreviewResult.poll_question_id'=>$_POST['poll_questions_id'],'PollPreviewResult.poll_answer_id'=>$_POST['poll_answer_id'],'PollPreviewResult.IP_address'=>$_SERVER['REMOTE_ADDR'])));
		if(empty($checkvalue)){
			$poll_preview_result['poll_id']=$_POST['poll_id'];
			$poll_preview_result['poll_question_id']=$_POST['poll_questions_id'];
			$poll_preview_result['poll_answer_id']=$_POST['poll_answer_id'];
			$poll_preview_result['IP_address']=$_SERVER['REMOTE_ADDR'];
			$this->PollPreviewResult->create();
			$this->PollPreviewResult->save($poll_preview_result);
			
			$countpoll=$this->PollPreviewResult->find('count',array('conditions'=>array('PollPreviewResult.poll_id'=>$_POST['poll_id'],'PollPreviewResult.poll_question_id'=>$_POST['poll_questions_id'],'PollPreviewResult.poll_answer_id'=>$_POST['poll_answer_id'])));
			
			}else{
			$countpoll=$this->PollPreviewResult->find('count',array('conditions'=>array('PollPreviewResult.poll_id'=>$_POST['poll_id'],'PollPreviewResult.poll_question_id'=>$_POST['poll_questions_id'],'PollPreviewResult.poll_answer_id'=>$_POST['poll_answer_id'])));
			  
		}
		echo $countpoll;
		exit;
	 }
         

    function fetch_preview($Pid){
                $this->layout = 'ajax';        
                //$Pid =  $this->request->data['id'];
		$this->set('title_for_layout', 'Footybase');
		$this->loadModel('User');
		$this->loadModel('PostComment'); 
		$this->loadModel('TagSum');
		$this->loadModel('PageView');
		$this->loadModel('PostCommentLike');
		$contentfirst = $this->Content->find('first',array('conditions'=>array('Content.id'=>$Pid),'fields'=>array('Content.content_order'))); 
		//pr($contentfirst); die;
                $indexvalue = array();
		$CCC = json_decode($contentfirst['Content']['content_order'],true); //debug($CCC);
		if(!empty($CCC)){
                foreach ($CCC as $c){
                                 foreach ($c as $key=>$val){
				 $indexvalue[] =ucfirst($key);
			  }
		   }
		}
		//debug($indexvalue);
		$this->Content->bindModel(array('hasMany'=>$indexvalue));
		$content = $this->Content->find('first',array('conditions'=>array('Content.id'=>$Pid),'contain'=> $indexvalue)); 
		$userid = $content['Content']['user_id'];
		$users = $this->User->find('first',array('conditions'=>array('User.id'=>$userid)));
		$allpostcomments = $this->PostCommentLike->PostComment->find('all',array('conditions'=>array('PostComment.content_id'=>$Pid)));
		$allpostcounts = $this->PostComment->find('count',array('conditions'=>array('PostComment.content_id'=>$Pid)));
		if(!empty($allpostcounts)){$allpostcounts = $allpostcounts;}else{$allpostcounts=0;}
		$tagsumarray=array();
		$alltagsums=$this->TagSum->find('all',array('conditions'=>array('TagSum.content_id'=>$Pid)));
		foreach($alltagsums as $alltagsum){$tagsumarray[]=$alltagsum['TagSum']['tag_id'];}
		$tagIDs = array_unique($tagsumarray);
		$lastcommentids=$this->PostComment->find('first', array('order' => array('PostComment.id' =>'desc'),'fields'=>array('PostComment.id'))); $lastcommentid = $lastcommentids['PostComment']['id'];
                $this->set(compact('content','users','allpostcomments','allpostcounts','tagIDs','count_page_view','lastcommentid','indexvalue'));
 }

         
         
         
}

?>