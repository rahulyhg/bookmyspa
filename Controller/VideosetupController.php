<?php
class VideosetupController extends AppController {
    public $helpers = array('Session', 'Html', 'Form','PhpExcel.PhpExcel','Form','Js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session','Paginator','Common','RequestHandler','Image'); //An array containing the names of components this controller uses.
    public $paginate = array('VideoSetup' => array('limit' => 5));
    public $uses = array('VideoSetup');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index','getVideoTitles');
    }
    /**********************************************************************************
    @Function Name : admin_index
    @Params	 : NULL
    @Description   : For saving Site theme for the Admin Side
    @Author        : Anshul Verma
    @Modified By:  
    @Modified On:  
    @Date          : 10-july-2015
    ***********************************************************************************/
    public function admin_index(){
        //Configure::write("debug",2);
        //echo "rtae";die;
	$conditions = array('VideoSetup.is_deleted'=>"0");
	if(!empty($this->request->data['search_keyword']) || !empty($this->request->named['search_keyword'])){
	    if(!empty($this->request->data['search_keyword'])){
		$src_keywrd = trim($this->request->data['search_keyword']);
	    } else if(!empty($this->request->named['search_keyword'])){
		$src_keywrd = trim($this->request->named['search_keyword']);
		$this->request->data['search_keyword'] = $this->request->named['search_keyword'];
	    }
	    
	}
	if(!empty($src_keywrd)){
	   $conditions = array('VideoSetup.is_deleted'=>"0",
			       'OR'=>array(
				    'VideoSetup.eng_title LIKE "%'.$src_keywrd.'%"',
				    'VideoSetup.ara_title LIKE "%'.$src_keywrd.'%"'
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
	if(!empty($src_keywrd)){
	   $conditions = array('VideoSetup.is_deleted'=>"0",
			       'OR'=>array(
				    'VideoSetup.eng_title LIKE "%'.$src_keywrd.'%"',
				    'VideoSetup.ara_title LIKE "%'.$src_keywrd.'%"'
				));
	}
       /**************** End of set page limit *******************/
	$this->params->data['number_records'] = $number_records;
        $this->layout   =   'admin_paginator';
        $fields = array('VideoSetup.id',
			'VideoSetup.eng_title',
                        'VideoSetup.ara_title',
                        'VideoSetup.eng_description',
                        'VideoSetup.ara_description',
                        'VideoSetup.youtube_link',
                        'VideoSetup.order_sequence',
                        'VideoSetup.status',
                        'VideoSetup.created'
		);
	$this->Paginator->settings = array(
		'VideoSetup' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('created' => 'desc')
		)
	    );
	$breadcrumb = array(
		'Home'=>array('controller'=>'Videosetup','action'=>'index','admin'=>true),
		'Video Setup'=>'javascript:void(0);'
	    );
        $activeTMenu = 'videoSetup';
        $page_title = 'Video Setup';
        $this->set(compact('activeTMenu','page_title','breadcrumb'));
	$videoSetup = $this->Paginator->paginate('VideoSetup');
        $this->set(compact('videoSetup'));
        $this->set('activeTMenu',$activeTMenu);
        $this->set('page_title',$page_title);
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Videosetup";
            $this->render('video_listing');
        }
    } 
    
    
      /**********************************************************************************    
        @Function Name : admin_deleteVideoSetup
        @Description   : Delete of Video Setup
        @Author        : Anshul Verma
        @Date          : 14-July-2015
      ***********************************************************************************/
    
    public function admin_deleteVideoSetup() {
        $this->autoRender = "false";
        if($this->request->is('post') || $this->request->is('put')){
	    $id = $this->request->data['id']; 
	    $page = $this->VideoSetup->findById($id);
	   if(!empty($page)){
                if($this->VideoSetup->updateAll(array('VideoSetup.is_deleted'=>1),array('VideoSetup.id'=>$id))){
		    $edata['data'] = 'success' ;
                    $edata['message'] = __('delete_success',true);
                }
                else{
                     $edata['data'] = 'error' ;
                     $edata['message'] = __('unable_to_delete',true);
                }
            }else{
                $edata['data'] = 'error' ;
                $edata['message'] = __('page_not_found',true);
            }
        }
	    echo json_encode($edata);
	    die;
    }
     /**********************************************************************************    
        @Function Name : admin_add_vendor
        @Description   : add video Setup
        @Author        : Anshul Verma
        @Date          : 13-July-2014
      ***********************************************************************************/
      
      function admin_add_videosetup($id=NULL){
          	if(!$this->request->is(array('ajax'))){
                    $this->redirect('/');   
		}
		$this->layout = 'ajax';
		    if($id){
			$VideoSetup = $this->VideoSetup->find('first',array("conditions"=>array('VideoSetup.id'=>$id ,'VideoSetup.is_deleted'=>0)));
		    }
		    if($this->request->is(array('put','post'))){
			$userId = $this->Auth->user('id');
			 
			($id)? $this->VideoSetup->id=$id:$this->VideoSetup->create();
                         if(isset($this->request->data['VideoSetup']['featured']) && !empty($this->request->data['VideoSetup']['featured'])){
                            $this->VideoSetup->updateAll(array('VideoSetup.featured'=>0));
                         }
			 if($this->VideoSetup->save($this->request->data)){
				 $edata['data'] = 'success';
				 $edata['message'] = __('page_save_success',true);
				 echo json_encode($edata);
				 die; 
			  }else{
				 $message = __('unable_to_save', true);
				 $vError = $this->VideoSetup->validationErrors;
				 $edata['data'] = $vError;
				 $edata['message'] = $message;
				 echo json_encode($edata);
				 die;
			 }
		    }
		  if(!$this->request->data && isset($VideoSetup)){
	               $this->request->data = $VideoSetup;
                   $this->set(compact('VideoSetup'));
               }
	}
      
   /**********************************************************************************    
      @Function Name : admin_videoSetupChangeStatus
      @Params	 : NULL
      @Description   : Change Status via Ajax
      @Author        : Anshul Verma
      @Date          : 14-July-2015
    ***********************************************************************************/    
        public function admin_videoSetupChangeStatus() {
            $this->autoRender = false;
            if($this->request->is('post')){
                if($this->VideoSetup->updateAll(array('VideoSetup.status'=>$this->request->data['status']),array('VideoSetup.id'=>$this->request->data['id']))){
                    return $this->request->data['status'];
                }
            }
            
        }
        
        public function index(){
            $this->layout='myaccount';
            $conditions[] = array('VideoSetup.status'=>1,'VideoSetup.is_deleted'=>0,'VideoSetup.featured'=>0);
            if(!empty($this->request->data['search_title']) || !empty($this->request->named['search_title'])){
                if(!empty($this->request->data['search_title'])){
                    $search_title = trim($this->request->data['search_title']);
                } else if(!empty($this->request->named['search_title'])){
                    $search_title = trim($this->request->named['search_title']);
                    $this->request->data['search_title'] = $this->request->named['search_title'];
                }

            }
            $cond=array();
            if(!empty($search_title)){
                $expValue=explode(" ",$search_title);
                $totalExpVal=count($expValue);
                $ct=0;
                if($totalExpVal>1){
                    while($ct<$totalExpVal){
                        $cond[]=' VideoSetup.eng_title LIKE "%'.$expValue[$ct].'%"';
                        $cond[]=' VideoSetup.ara_title LIKE "%'.$expValue[$ct].'%"';
                        $ct++;
                    }
                }
            }
            $number_records=12;
            if(!empty($search_title)){
                $cond[]='VideoSetup.eng_title LIKE "%'.$search_title.'%"';
                $cond[]='VideoSetup.ara_title LIKE "%'.$search_title.'%"';
            }
            $conditions[] = array('OR'=>$cond);
            $this->params->data['number_records'] = $number_records;
            $this->layout   =   'default';
            $fields=array('VideoSetup.id',
                          'VideoSetup.eng_title',
                          'VideoSetup.ara_title',
                          'VideoSetup.eng_description',
                          'VideoSetup.ara_description',
                          'VideoSetup.youtube_link');
            $this->Paginator->settings = array(
		'VideoSetup' => array(
		    'limit' => $number_records,
		    'fields' => $fields,
		    'conditions' => $conditions,
		    'order' => array('VideoSetup.order_sequence' => 'desc')
		)
	    );
            $allVideos = $this->Paginator->paginate('VideoSetup');
            $featured=$this->VideoSetup->find('first',array('conditions'=>array('VideoSetup.status'=>1,'VideoSetup.is_deleted'=>0,'VideoSetup.featured'=>1),'fields'=>$fields));
            $lang =  Configure::read('Config.language');
            $titleField='VideoSetup.'.$lang.'_title';
            $titles=$this->VideoSetup->find('list',array('conditions'=>array('VideoSetup.status'=>1,'VideoSetup.is_deleted'=>0,'VideoSetup.featured'=>0),'fields'=>array('VideoSetup.id',$titleField)));
            foreach($titles as $key=>$val)
            {
                $dataValue[] = array('id' => $key, 'name' => $val);
            }
            $finalTitles= json_encode($dataValue);
            $this->set(compact('featured','allVideos','finalTitles'));
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
            } 
        }
        public function getVideoTitles($searchText=null){
            $data = array();
	    $videoTitles='';
            $lang =  Configure::read('Config.language');
            if(!empty($searchText)){
                $fieldName=$lang.'_title';
                $videoTitles = $this->VideoSetup->find('all',
                                                         array('fields' => array('VideoSetup.id',$fieldName),
                                                               'conditions' => array('VideoSetup.status'=>1,'VideoSetup.is_deleted'=>0,'VideoSetup.featured'=>0,'OR'=>array(
                                                                    'VideoSetup.eng_title LIKE "%'.$searchText.'%"',
                                                                    'VideoSetup.ara_title LIKE "%'.$searchText.'%"'
                                                                )),
                                                               'limit' => '10'
                                                               )
                                                         );
           
            }
            $this->set('list',$videoTitles);
                
        }
}