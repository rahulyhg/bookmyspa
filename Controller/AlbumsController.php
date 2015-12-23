<?php
class AlbumsController extends AppController {
    public $helpers = array('Session', 'Html', 'Form','js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Paginator','Image','RequestHandler','Common'); //An array containing the names of components this controller uses.
    public function beforeFilter() {
        parent::beforeFilter();
    }
    //var $uses = array('Album');
    
/**********************************************************************************    
  @Function Name : admin_albums
  @Params	 : NULL
  @Description   : Albums!!
  @Author        : Sanjeev kanungo
  @Date          : 19-Nov-2014
***********************************************************************************/
    public function admin_index(){
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Gallery'=>array('controller'=>'Albums','action'=>'index','admin'=>true),
                       );
        $this->layout='admin';
        $total = $this->Album->find('count' , array('conditions'=>array('user_id'=>$this->Auth->user('id'))));
        $this->Album->bindModel(array('hasMany' =>array('AlbumFile'=>array('className'=>'AlbumFile','foreignKey' => 'album_id'))));
        $albums = $this->Album->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'))));
        
        $this->set(compact('breadcrumb','total', 'albums'));
        $this->set('activeTMenu','albums');
        $this->set('page_title','Gallery');
        $this->set('leftMenu',true);
     }
     
/**********************************************************************************    
  @Function Name : admin_add_album
  @Params	 : $id
  @Description   : add/edit album
  @Author        : Sanjeev kanungo
  @Date          : 19-Nov-2014
***********************************************************************************/
    public function admin_add_album($id=NULL){
        $this->layout='ajax';
        $albumdata = array();
        if($id){
            $id = base64_decode($id);
            $albumdata = $this->Album->findById($id);   
        }
        if($this->request->is(array('put','post'))){
             $this->Album->set($this->request->data);
             $this->request->data['Album']['user_id'] = $this->Auth->user('id');
            if($id){
               $this->Album->id = $id;
            }else{
                $this->Album->create();  
            }
             if($this->Album->save($this->request->data)){
                $edata['data'] = 'success' ;
                $edata['message'] = __('Album has been saved successfully.',true);
                $id = ($id)?$id:$this->Album->getLastInsertId();
                $edata['o_id'] =  $id;
                $edata['id'] =  base64_encode($id);
                echo json_encode($edata);
                die;
             }else{
                $message = __('unable_to_save', true);
                $vError = $this->Album->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
             }
        }
        if(!$this->request->data && isset($albumdata)){
            $this->request->data = $albumdata; 
        }
    }
    
    /**********************************************************************************    
    @Function Name : admin_album_data
    @Params	 : $id
    @Description   : show Album images/videos
    @Author        : Sanjeev kanungo
    @Date          : 19-Nov-2014
   ***********************************************************************************/
    
   function admin_album_data($id=NULL){
        $this->loadModel('AlbumFile');
        $this->set('page_title' , 'Album Images/Videos');
        $this->layout='admin';
        if($id==NULL){
           throw new NotFoundException('Album not found in our database!!');  
        }
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Albums'=>array('controller'=>'Albums','action'=>'index','admin'=>true),
                         'List'=>'javascript:void(0);'
                        );
        $id = base64_decode($id);
        $total_images = $this->AlbumFile->find('count' , array('conditions'=>array('AlbumFile.album_id'=>$id, 'type'=>'image')));
        $total_videos = $this->AlbumFile->find('count' , array('conditions'=>array('album_id'=>$id, 'type'=>'video')));
        $this->Album->bindModel(array('hasMany' =>array('AlbumFile'=>array('className'=>'AlbumFile','foreignKey' => 'album_id'))));
        $album_datas = $this->Album->find('first' , array('conditions'=>array('Album.id'=>$id)));
        $this->set(compact('breadcrumb','album_datas','total_videos','total_images'));
        $this->set('activeTMenu','albums');
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Album";
            $this->render('public_gallery_images');
        }
    }
 
    /**********************************************************************************    
    @Function Name : admin_add_image
    @Params	 : $album_id , $type , image/video_id
    @Description   : add/edit images/videos of ablum
    @Author        : Sanjeev kanungo
    @Date          : 19-Nov-2014
   ***********************************************************************************/
 
    function admin_add_image($album_id=NULL,$type=NULL){
            if($this->request->is('ajax')){
                $this->layout="ajax";    
                $imageData = array();
                $this->loadModel('AlbumFile');
                if($album_id==NULL && $type==NULL){
                    throw new NotFoundException('Album not found in our database!!');      
                }    
                if($this->request->is(array('post','put'))){
                  if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']) && $type=='image'){
                    list($width, $height, $type, $attr) = getimagesize($_FILES['image']["tmp_name"]);
                    if($this->Common->countAlbumFiles(base64_decode($album_id),'image')<20){
                        if($width >= 300 && $height >= 200){
                                $model = "AlbumFile";
                                $retrun = $this->Image->upload_image($_FILES['image'],$model,$this->Auth->user('id'));
                                 if($retrun){
                                     $this->request->data['AlbumFile']['image'] = $retrun;
                                     $this->request->data['AlbumFile']['type'] = 'image';
                                 }
                                   $validate = array('fieldList' => array(''));    
                           
                        }else{
                            echo 'dimension_error_300_200';
                            die;
                        }
                    }else{
                            echo 'maxLimit';
                            exit;
                    }
                 }elseif($type=='video'){
                        $validate = array('fieldList' => array('url'));
                        $this->request->data['AlbumFile']['type'] = 'video';
                        $check = $this->admin_album_video($this->request->data['AlbumFile']['url']);
                        //echo $check;exit;
                        //die;
                        if($check == 1){
                            $message = __('Video already exist.', true);
                            $vError = $this->AlbumFile->validationErrors;
                            $edata['data'] = $vError ;
                            $edata['message'] = $message;
                            echo json_encode($edata);
                            die;
                        }
                }
                $this->AlbumFile->create();
                $this->request->data['AlbumFile']['album_id'] = base64_decode($album_id);
                $this->AlbumFile->set($this->request->data);
                if($this->AlbumFile->save($this->request->data ,array('validates'=>$validate))){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('Record has been saved successfully.',true);
                        $edata['id'] =  $album_id;
                        echo json_encode($edata);
                        die;
                     }else{
                        $message = __('unable_to_save', true);
                        $vError = $this->AlbumFile->validationErrors;
                        $edata['data'] = $vError ;
                        $edata['message'] = $message;
                        echo json_encode($edata);
                        die;
                     }
               }
             $this->set('type' , $type);
             $this->set('page_title' ,"Add ".$type);
             }else{
              $this->redirect(array('action'=>'index'));   
            }
    } 
   
    /**********************************************************************************    
    @Function Name : admin_deleteAlbum
    @Params	   : $album_id ,
    @Description   : add/edit images/videos of ablum
    @Author        : Sanjeev kanungo
    @Date          : 19-Nov-2014
    ***********************************************************************************/
    function admin_deleteAlbum($album_id=NULL){
        ob_start();
        $this->loadModel('AlbumFile');
        $this->autoRender=FALSE;
        if($album_id==NULL){
           throw new NotFoundException('Album not found in our database!!');  
        }
        $album_id = base64_decode($album_id);
        $this->Album->bindModel(array('hasMany' =>array('AlbumFile'=>array('className'=>'AlbumFile','foreignKey' => 'album_id','fields'=>array('id','image')))));
        $album_datas = $this->Album->find('first',array('conditions'=>array('Album.id'=>$album_id),'fields'=>'id'));
        $modal = 'AlbumFile';
        foreach($album_datas['AlbumFile'] as $imageData){
            if($imageData['image']){
               $this->Image->delete_image($imageData['image'],$modal,$this->Auth->user('id'));
            }   
        }
        if($this->Album->delete($album_id)){
            $this->redirect(array('action'=>'index')); 
        }else{
            $this->redirect(array('action'=>'index'));
        }
    }  
   
     /**********************************************************************************    
    @Function Name : admin_deleteImage
    @Params	   : $id ,
    @Description   : delete image/video
    @Author        : Sanjeev kanungo
    @Date          : 25-Nov-2014
    ***********************************************************************************/
    
    function admin_deleteImage($id=NULL,$album=null){
        $this->autoRender = false;
        $this->loadModel('AlbumFile');
        $this->AlbumFile->bindModel(array('belongsTo' =>array('Album'=>array('className'=>'Album','foreignKey' => 'album_id','fields'=>array('Album.user_id')))));
        $filedata = $this->AlbumFile->find('first' ,array('conditions'=>array('AlbumFile.id'=>base64_decode($id))));
        $modal = 'AlbumFile';
        if(count($filedata)){
          if($filedata['AlbumFile']['image']){
            $this->Image->delete_image($filedata['AlbumFile']['image'],$modal,$filedata['Album']['user_id']);
            }
          $this->AlbumFile->delete($filedata['AlbumFile']['id']);
          echo base64_encode($album);
          exit;
        }
    }
    
     /**********************************************************************************    
    @Function Name : album_element
    @Params	   : $id ,
    @Description   : load ajax content
    @Author        : Sanjeev kanungo
    @Date          : 25-Nov-2014
    ***********************************************************************************/
    function admin_album_element($id = null){
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('AlbumFile');
        $this->autoRender=false;
        if($id){
            $id = base64_decode($id);
            $sel_id = $id;
        }
        $this->Album->bindModel(array('hasMany' =>array('AlbumFile'=>array('className'=>'AlbumFile','foreignKey' => 'album_id'))));
        $albums = $this->Album->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'))));
        $total = $this->Album->find('count' , array('conditions'=>array('user_id'=>$this->Auth->user('id'))));
        $this->set(compact('albums','total','sel_id'));
        $view = new View($this, false);
        echo  $content = $view->element('admin/Album/album_data', $albums);
    }

    /**********************************************************************************    
      @Function Name : admin_venue
      @Params	 : NULL
      @Description   : Venue Images
      @Author        : Shibu Kumar 
      @Date          : 11-Dec-2014
      ***********************************************************************************/
    
    function admin_venue(){
        $this->layout='admin';
        $this->loadModel('VenueImage');
        $this->loadModel('VenueVideo');
        $breadcrumb = array(
                        'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                        'Venue Gallery'=>array('controller'=>'Albums','action'=>'venue','admin'=>true),
                       );
        $venueImages = $this->VenueImage->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'))));
        $venueVideos = $this->VenueVideo->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'))));
        $this->set(compact('breadcrumb','venueImages','venueVideos'));
        $this->set('page_title','Venue Gallery');
        $this->set('activeTMenu','venueGallery');
        $this->set('leftMenu',true);
    }
    
     /**********************************************************************************    
      @Function Name : admin_add_venueimage
      @Params	 : NULL
      @Description   : Function to add Venue Images
      @Author        : Shibu Kumar 
      @Date          : 11-Dec-2014
      ***********************************************************************************/
    
    function admin_add_venueimage($id=NULL){
            $type='image';
            if($this->request->is('ajax')){
                $this->layout="ajax";    
                $imageData = array();
                $this->loadModel('VenueImage');
                $this->set("title_for_layout",'Venue Image');
                if($id){
                        $id = base64_decode($id);
                        $imageData = $this->VenueImage->findById($id);
                }
            if($this->request->is(array('post','put'))){
                $this->request->data['VenueImage']['user_id'] = $this->Auth->user('id');
                if($id){
                    $this->VenueImage->id = $id;
                }else{
                    $this->VenueImage->create();
                }
                $validate = array('fieldList' => array('image', 'eng_title','eng_description','status'));
                if(!empty($this->request->data['VenueImage']['image']['name'])){
                   $model = "VenueImage";
                   $retrun = $this->Image->upload_image($this->request->data['VenueImage']['image'],$model,$this->Auth->user('id'));
                        if($retrun){
                            $this->request->data['VenueImage']['image'] = $retrun;
                            if(@$imageData['VenueImage']['image']){
                              $this->Image->delete_image($imageData['VenueImage']['image'],$model,$this->Auth->user('id'));
                            }
                        }
                }else{
                $this->request->data['VenueImage']['image'] = @$imageData['VenueImage']['image'];
                }
                $this->VenueImage->set($this->request->data);
               
                if($this->VenueImage->save($this->request->data ,array('validates'=>$validate))){
                        $edata['data'] = 'success' ;
                        $edata['message'] = __('Image saved successfully',true);
                         $id = ($id)?$id:$this->VenueImage->getLastInsertId();
                        $edata['id'] =  base64_encode($id);
                         echo json_encode($edata);
                        die;
                     }else{
                        $message = __('unable_to_save', true);
                        $vError = $this->VenueImage->validationErrors;
                        $edata['data'] = $vError ;
                        $edata['message'] = $message;
                        echo json_encode($edata);
                        die;
                     }
               }
             $this->set('type' , $type);
             $this->set('page_title' ,"Add ".$type);
            if(!$this->request->data && isset($imageData)){
                $this->request->data = $imageData;
                $this->set(compact('imageData'));
            }}else{
              $this->redirect(array('action'=>'index'));   
            }
    }
    
    /**********************************************************************************    
            @Function Name : admin_venue_element
            @Params	   : $id ,
            @Description   : load ajax content
            @Author        : Shibu Kumar
            @Date          : 11-Dec-2014
    ***********************************************************************************/
    function admin_venue_element(){
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('VenueImage');
         $this->loadModel('VenueVideo');
        $venueImages = $this->VenueImage->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'))));
        $venueVideos = $this->VenueVideo->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'))));
        $this->set(compact('venueImages','venueVideos'));
        $view = new View($this, false);
        echo  $content = $view->element('admin/Album/venue_data', $venueImages);
    }
  /**********************************************************************************    
    @Function Name : admin_deletevenueImage
    @Params	   : $id ,
    @Description   : delete Venue Video
    @Author        : Shibu Kumar
    @Date          : 11-Dec-2014
    ***********************************************************************************/
    
    function admin_deletevenueImage($id=NULL){
        $this->autoRender = false;
        $this->loadModel('VenueImage');
        $filedata = $this->VenueImage->find('first' ,array('conditions'=>array('VenueImage.id'=>base64_decode($id))));
        $modal = 'VenueImage';
        if(count($filedata)){
          if($filedata['VenueImage']['image']){
            $this->Image->delete_image($filedata['VenueImage']['image'],$modal,$filedata['VenueImage']['user_id']);
            }
        $this->VenueImage->delete($filedata['VenueImage']['id']);  
        }
       return true; 
    }
    
        /**********************************************************************************    
    @Function Name : admin_deletevenueVideo
    @Params	   : $id ,
    @Description   : delete Venue Video
    @Author        : Shibu Kumar
    @Date          : 21-March-2014
    ***********************************************************************************/
    
     function admin_deletevenueVideo($id=NULL){
        $this->autoRender = false;
        $this->loadModel('VenueVideo');
        $filedata = $this->VenueVideo->find('first' ,array('conditions'=>array('VenueVideo.id'=>base64_decode($id))));
        $modal = 'VenueVideo';
        if(count($filedata)){
          $this->VenueVideo->delete($filedata['VenueVideo']['id']);
           return true; 
        }else{
            return false;
        }
      
    }
    
       /**********************************************************************************    
    @Function Name : admin_album_video
    @Params	   : $id ,
    @Description   : delete Venue Video
    @Author        : Shibu Kumar
    @Date          : 21-March-2014
    ***********************************************************************************/
    
     function admin_album_video($url = null){
        $this->loadModel('AlbumFile');
        $this->layout = false;
        $this->autoRender = false;
        $this->Album->bindModel(array('hasMany' =>array('AlbumFile'=>array('className'=>'AlbumFile','foreignKey' => 'album_id','fields'=>array('id','url')))));
        $albums = $this->Album->find('all',array('conditions'=>array('Album.user_id'=>$this->Auth->user('id')),'fields'=>'id'));
        $check = 0;
        if(!empty($albums)){
            foreach($albums as $files){
                if(!empty($files['AlbumFile'])){
                foreach($files['AlbumFile'] as $falbums){
                        if($falbums['url'] == $url){
                          $check = 1;  
                        }
                    }
                }
            }
        }
       return $check;
    }

     public function admin_venue_video(){
         $this->layout = 'ajax';
         $this->loadModel('VenueVideo');
	if ($this->request->is('post') || $this->request->is('put')) {
            $edata['data'] = '';
            $edata['message'] = '';
	    if(!empty($this->request->data)){
                $youtube_regexp = "/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/";
                $valid = preg_match($youtube_regexp, $this->request->data['VenueVideo']['url']);
                    if($valid){
                        $value = $this->VenueVideo->find('first',array('conditions'=>array('VenueVideo.user_id'=>$this->Auth->user('id'),'VenueVideo.video'=>$this->request->data['VenueVideo']['url'])));
                        //pr($value);exit;
                        if(empty($value)){
                            $data = array();
                            $data['VenueVideo']['user_id'] = $this->Auth->user('id');
                            $data['VenueVideo']['video'] = $this->request->data['VenueVideo']['url'];
                            $this->VenueVideo->create();
                            $this->VenueVideo->save($data);
                                $edata['data'] = 'success' ;
                                $edata['message'] = __('Video has been uploaded successfully',true);
                                echo json_encode($edata);
                                die;
                        }
                        else{
                                $message = __('Video already exists.', true);
                                $vError = $this->VenueVideo->validationErrors;
                                $edata['data'] = $vError ;
                                $edata['message'] = $message;
                                echo json_encode($edata);
                                die;  
                            }
                    }else{
                        $message = __('Please enter a valid youtube url.', true);
                        $vError = $this->VenueVideo->validationErrors;
                        $edata['data'] = $vError ;
                        $edata['message'] = $message;
                        echo json_encode($edata);
                        die;  
                    }
            }else{
                $message = __('Video is required.', true);
                $vError = $this->VenueVideo->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;  
            }
	}
    }
    
  
     
     
}

?>