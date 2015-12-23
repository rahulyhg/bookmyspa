<?php

class GiftImagesController extends AppController {

    public $helpers = array('Session', 'Html', 'Form'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Common', 'Email', 'Cookie', 'Paginator', 'Image',); //An array containing the names of components this controller uses.

    /**
     * List gift images
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_ads     
     * @since         version 0.0.1
     */

    public function admin_list() {
        $this->layout = 'admin';
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Gift Certificates' => array('controller' => 'GiftImages', 'action' => 'list', 'admin' => true),
        );
        $this->set('breadcrumb', $breadcrumb);
        $userId = $this->Auth->user('id');
        
        $conditions = array('GiftImage.is_deleted'=>"0",
                               'GiftImage.user_id'=>$userId,);
	if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	}
	
	if(!empty($src_keywrd)){
	   $conditions = array('GiftImage.is_deleted'=>"0",
                               'GiftImage.user_id'=>$userId,
			       'OR'=>array(
				    'GiftImage.eng_title LIKE "%'.$src_keywrd.'%"',
				    'GiftImage.ara_title LIKE "%'.$src_keywrd.'%"'
				));
	}
	
	/************** Set page limit ************/
	$number_records = 10;
	if(!empty($this->request->data['number_records']) || !empty($this->request->named['number_records'])){
	    if(!empty($this->request->data['number_records'])) {
		$number_records = $this->request->data['number_records'];
	    }
	    if(!empty($this->request->named['number_records'])){
		$number_records = $this->request->named['number_records'];
	    }
	    $this->request->data['number_records'] = $number_records;
	}
	
	
	
	/**************** End of set page limit *******************/
	
	$this->params->data['number_records'] = $number_records;
    
        $this->layout   =   'admin_paginator';
        
        $this->loadModel('GiftImage');
        
        $this->GiftImage->bindModel(array('belongsTo'=>array('GiftImageCategory')));
	$fields = array('GiftImage.id',
                        'GiftImage.image',
                'GiftImage.eng_title',
                'GiftImage.ara_title',
                'GiftImage.text_align',
                'GiftImage.font_color',
                'GiftImage.gift_image_category_id',
                'GiftImage.status',
                'GiftImageCategory.id',
                'GiftImageCategory.eng_title',
		);
	
	$this->Paginator->settings = array(
		'GiftImage' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('GiftImage.id' => 'desc')
		)
	    );
	$imageList = $this->Paginator->paginate('GiftImage');
        //pr($imageList);
	
       
        $this->set(compact('activeTMenu','page_title','breadcrumb'));
	
	
        $this->set(compact('imageList'));
        $this->set('page_title', 'Gift Certificate Images');
        $this->set('activeTMenu', 'gftImageManage');
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/GiftImages";
            $this->render('list_gift_images');
        }
    }

    /**
     * Save Gift Images
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_addImage
     * @param         $id
     * @since         version 0.0.1
     */
    public function admin_addImage($id = NULL) {
        $this->layout = 'ajax';
        $this->loadModel('GiftImageCategory');
        $user_id = $this->Auth->user('id');
	$catList = $this->GiftImageCategory->find('list', array('conditions' => array('is_deleted' => 0,'user_id'=>array(1,$user_id)), 'fields' => array('id', 'eng_title')));
        $this->set('catList', $catList);
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Gift Certificates' => array('controller' => 'GiftImages', 'action' => 'list', 'admin' => true),
        );
        if ($id) {
            $giftImageDetail = $this->GiftImage->findById($id);
            $breadcrumb['Edit'] = 'javascript:void(0);';
        } else {
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //Gift image upload
            if (!empty($this->request->data['GiftImage']['image']['name'])) {
                $image = $this->request->data['GiftImage']['image'];
                unset($this->request->data['GiftImage']['image']);
                $model = "GiftImage";
                list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);
                if ($width == '940' && $height == '560') {
                    $retrun = $this->Image->upload_image($image, $model, $this->Auth->user('id'), false);
                    if ($retrun) {
                        $this->request->data['GiftImage']['image'] = $retrun;
                        if (@$giftImageDetail['GiftImage']['image']) {
                            $this->Image->delete_image($giftImageDetail['GiftImage']['image'], $model, $this->Auth->user('id'));
                        }
                    }
                } else {
                    $edata['data'] = 'Fail';
                    $edata['message'] = 'Upload an image of 940px width and 560px height';
                    echo json_encode($edata);
                    die;
                }
            } else {
                $this->request->data['GiftImage']['image'] = @$giftImageDetail['GiftImage']['image'];
            }
            $data = $this->request->data;
            if (!empty($data['GiftImage']['id'])) {
                $this->GiftImage->id = $data['GiftImage']['id'];
            } else {
                $data['GiftImage']['user_id'] = $this->Auth->user('id');
                $data['GiftImage']['createdDate'] = date('d-m-y');
                $data['GiftImage']['status'] = 1;
                if ($this->Auth->user('type') == 1) {
                    $data['GiftImage']['created_by'] = 0;
                }
                $this->GiftImage->create();
            }
            if ($this->GiftImage->save($data)) {
                $edata['data'] = 'success';
                $edata['message'] = 'GiftImage has been saved successfully.';
                echo json_encode($edata);
                die;
            } else {
                $message = 'Please try again.';
                $vError = $this->GiftImage->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }

        if (!$this->request->data && isset($giftImageDetail)) {
            $this->request->data = $giftImageDetail;
            $this->set('giftImageDetail', $giftImageDetail);
        }
    }

    /**
     * delete Record
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_deleteRow
     * @param         $id
     * @since         version 0.0.1
     */
    public function admin_deleteRow() {
        $this->autoRender = "false";
        if ($this->request->is('post') || $this->request->is('put')) {
            $id = $this->request->data['id'];
            $ads = $this->GiftImage->findById($id);
            if (!empty($ads)) {
                if ($this->GiftImage->updateAll(array('GiftImage.is_deleted' => 1), array('GiftImage.id' => $id))) {
                    $edata['data'] = 'success';
                    $edata['message'] = __('GiftImage deleted successfully.', true);
                } else {
                    $edata['data'] = 'error';
                    $edata['message'] = __('Some error occured.', true);
                }
            } else {
                $edata['data'] = 'error';
                $edata['message'] = __('Some error occured.', true);
            }
        }
        echo json_encode($edata);
        die;
    }

    /**
     * Change Stattus Gift Images
     * @author        Rajnish 
     * @copyright     smartData Enterprise Inc.
     * @method        admin_changeStatus
     * @param         id as a post
     * @since         version 0.0.1
     */
    
    
    public function admin_changeStatus() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ((int) $this->request->data['id']) {
                $this->GiftImage->updateAll(array('GiftImage.status' => $this->request->data['status']), array('GiftImage.id' => $this->request->data['id']));
                echo $this->request->data['status'];
            } else {
                return 'Some error occured.';
            }
        } else {
            return 'Some error occured.';
        }
        die;
    }

    public function admin_add_category($id = NULL) {
        $this->layout = 'ajax';
        $this->loadModel('GiftImageCategory');
        if ($this->request->is(array('put', 'post'))) {
            $userId = $this->Auth->user('id');
            $this->request->data['GiftImageCategory']['user_id'] = $userId;
            $this->request->data['GiftImageCategory']['createdDate'] = date("Y-m-d");
            if($id==''){
              $this->GiftImageCategory->create();
            }
            if ($this->GiftImageCategory->save($this->request->data)) {
                $edata['data'] = 'success';
                $edata['message'] = 'Category has been saved successfully';
                echo json_encode($edata);
                die;
            } else {
                $message = __('unable_to_save', true);
                $vError = $this->GiftImageCategory->validationErrors;
                $edata['data'] = $vError;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
    }

    //On click of add new category
    function admin_category_list(){
        $this->autoRender = false;
        $this->loadModel('GiftImageCategory');
        $this->GiftImageCategory->recursive = -1;
        $user_id = $this->Auth->user('id');
	$catListNew = $this->GiftImageCategory->find('list', array('conditions' => array('is_deleted' =>0,'user_id'=>array(1,$user_id)), 'fields' => array('id', 'eng_title')));
        $view = new View($this);
        $this->Form = $view->loadHelper('Form');
        $list = $this->Form->input('gift_image_category_id', array('name' => 'data[GiftImage][gift_image_category_id]', 'label' => false, 'options' => $catListNew, 'selected' => '', 'empty' => 'Please select','class'=>'form-control','div'=>false,'required', 'validationMessage'=>'Select image category.'));
        echo $list;
    }

    function admin_category_management(){
        $breadcrumb = array(
            'Home' => array('controller' => 'dashboard', 'action' => 'index', 'admin' => true),
            'Categories' => array('controller' => 'GiftImages', 'action' => 'category_management', 'admin' => true),
        );
        $this->set('breadcrumb', $breadcrumb);
	$this->layout = 'admin';
        $this->loadModel('GiftImageCategory');
        $this->set('page_title','Categories');
        $this->set('activeTMenu','gftImageCategory');
        $this->set('leftMenu',false);
	$this->GiftImageCategory->recursive = -1;
        $user_id = $this->Auth->user('id');
	$catLists = $this->GiftImageCategory->find('all', array('conditions' => array('is_deleted' => 0,'user_id'=>$user_id), 'fields' => array('id', 'eng_title','ara_title')));
	$this->set(compact('catLists'));
	 if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/GiftImages";
            $this->render('list_categories');
         }
    }
    
    function admin_delete_category(){
	  $id = $this->request->data['id'];
	  if($id){
	  $this->loadModel('GiftImageCategory');
	  $this->loadModel('GiftImage');
	    $user_id = $this->Auth->user('id');
	    $all_images =  $this->GiftImage->find('all', array('conditions'=>array('gift_image_category_id'=>$id,'is_deleted'=>0,'user_id'=>$user_id)));
	    if(count($all_images)){
	        $edata['data'] = 'success';
		$edata['data_done'] = 'before';
                $edata['messages_before'] = 'You need to delete all images associated with this category first, then you can delete this category.';
                echo json_encode($edata);
                die;
	    }
	    $this->GiftImage->updateAll(array('GiftImage.is_deleted' => 1), array('GiftImage.gift_image_category_id' => $id));
	    $this->GiftImageCategory->id = $id;
	    if($this->GiftImageCategory->SaveField('is_deleted', 1)){
	        $edata['data'] = 'success';
		$edata['data_done'] = 'success';
                $edata['message'] = 'Category deleted successfully';
                echo json_encode($edata);
                die;
             } else {
                $edata['data'] = 'error';
		$edata['message'] = 'Some error occured.';
                echo json_encode($edata);
                die;
            }
	  }else{
		$edata['data'] = 'error';
                $edata['message'] = 'Some error occured.';
                echo json_encode($edata);
                die;
	  }
    }
}
