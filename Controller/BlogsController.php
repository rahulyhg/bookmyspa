<?php
class BlogsController extends AppController {

    public $helpers = array('Session', 'Html', 'Form','js','Paginator'); //An array containing the names of helpers this controller uses. 
    public $components = array('Session', 'Email', 'Cookie','Paginator','Common','Image','RequestHandler'); //An array containing the names of components this controller uses.
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index','search','view','admin_list','category');
    }
    
    /*function admin_list(){
        $image_path = $this->Common->create_image();
        echo $image_path;
        die;
    }*/
    
    /**********************************************************************************    
      @Function Name : admin_add_category
      @Params	 : NULL
      @Description   : Add categories for blog section!!
      @Author        : Sanjeev kanungo
      @Date          : 12-Nov-2014
    ***********************************************************************************/

    public function admin_add_category($blogCatID = NULL){
        $this->layout = 'ajax';
        $this->loadModel('BlogCategory');
        if($blogCatID){
           $pageDetail = $this->BlogCategory->findById($blogCatID);
           $breadcrumb['Edit'] = 'javascript:void(0);';
        }else{
           $breadcrumb['Add'] = 'javascript:void(0);';
        }
        if($this->request->is(array('post','put'))){
            $this->request->data['BlogCategory']['created_by'] = $this->Auth->user('id');
            if($this->Auth->user('type') == 1){
                $this->request->data['BlogCategory']['created_by'] = 1;
            }
            if($blogCatID){
                $this->BlogCategory->id = $blogCatID;
            }else{
                $this->BlogCategory->create();
            }
            if($this->BlogCategory->save($this->request->data)){
                $edata['data'] = 'success' ;
                if(isset($blogCatID)) {
                    $edata['message'] = __('blog_category_update_success',true);
                } else {
                    $edata['message'] = __('blog_category_add_success',true);
                }
                echo json_encode($edata);
                die;
            } else{
                $message = __('unable_to_save', true);
                $vError = $this->BlogCategory->validationErrors;
                $edata['data'] = $vError ;
                $edata['message'] = $message;
                echo json_encode($edata);
                die;
            }
        }
        if(!$this->request->data && isset($pageDetail)){
            $this->request->data = $pageDetail;
        }
        $this->set('breadcrumb',$breadcrumb); 
    }

    public function admin_categories(){
        $this->layout = 'admin';
        $this->loadModel('BlogCategory'); 
        $breadcrumb = array(
                    'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                    'Blog Categories'=>array('controller'=>'blogs','action'=>'categories','admin'=>true),
                );
        $this->set('breadcrumb',$breadcrumb);
        $created_by = $this->Auth->user('id');
        if($this->Auth->user('type') == 1)
            $created_by = 0;
        $conditions = array('is_deleted'=>0);
        $categories  = $this->BlogCategory->find('all' , array('conditions' => $conditions, 'order'=>'id DESC'));
        $this->set(compact('categories'));
        $this->set('page_title','Blog Categories');
        $this->set('activeTMenu','blogCategories');
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Blog";
            $this->render('list_blog_categories');
        }
    }
    
    /**********************************************************************************    
      @Function Name : admin_changeStatus
      @Params	     : NULL
      @Description   : Change Status via Ajax
      @Author        : Sanjeev
      @Date          : 13-Nov-2014
    ***********************************************************************************/
    
    public function admin_changeStatus(){
        $this->loadModel('BlogCategory'); 
        $this->autoRender = false;
        if($this->request->is('post')){
            if($this->BlogCategory->updateAll(array('BlogCategory.status'=>$this->request->data['status']),array('BlogCategory.id'=>$this->request->data['id']))){
                return $this->request->data['status'];
            }
        }
    }
   
    /**********************************************************************************    
    @Function Name : admin_deletePage
    @Params	 : $blogCatID = Page Id 
    @Description   : Delete of CMS Pages
    @Author        : Sanjeev
    @Date          : 13-Nov-2014
    ***********************************************************************************/
   
    public function admin_deletePage($blogCatID=NULL){
        $this->loadModel('BlogCategory');
        $this->autoRender = "false";
        if($this->request->is('post') || $this->request->is('put')){
            $blogCatID = $this->request->data['id'];
            $page = $this->BlogCategory->findById($blogCatID);
            if(!empty($page)){
                if($this->BlogCategory->updateAll(array('BlogCategory.is_deleted'=>1),array('BlogCategory.id'=>$blogCatID))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('cat_delete_success',true);
                } else{
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unable_to_delete',true);
                }
            }else{
                $edata['data'] = 'error' ;
                $edata['message'] = __('page_not_found',true);
            }
        } else{
            $edata['data'] = 'error' ;
            $edata['message'] = __('page_not_found',true);
        }
        echo json_encode($edata);
        die;
    }
  
    /**********************************************************************************    
      @Function Name : admin_add_blog
      @Params	 : NULL
      @Description   : Add New blog !!
      @Author        : Sanjeev kanungo
      @Date          : 13-Nov-2014
    ***********************************************************************************/
    function admin_add_blog($blogID = NULL){
        $this->layout = 'ajax';
        $this->loadModel('Blog');
        $this->loadModel('BlogToCategory');
        $cats= array();
        $pageDetail =array();
        $uid = $this->Auth->user('id');
        if($blogID){
            // $blogID = base64_decode($blogID); 
            $this->Blog->bindModel(array('hasMany'=>array(
           'BlogToCategory' => array('className' => 'BlogToCategory','fields'=>array('BlogToCategory.category_id')))));  
            $pageDetail = $this->Blog->findById($blogID);
            foreach($pageDetail['BlogToCategory'] as $cat){
                $cats[] = $cat['category_id'];  
            }
            $breadcrumb['Edit'] = 'javascript:void(0);';
        } else {
            $breadcrumb['Add'] = 'javascript:void(0);';
        }
        if($this->request->is(array('post','put'))){
            $this->Blog->set($this->request->data);
            //if ($this->Blog->validates()) {
                $this->request->data['Blog']['eng_title'] = ucfirst($this->request->data['Blog']['eng_title']);
                $this->request->data['Blog']['created_by'] = $uid;
                if($this->Auth->user('type') == 1){
                    $this->request->data['Blog']['created_by'] = 1;
                }
                if(!empty($this->request->data['Blog']['image']['name'])){
                    $image = $this->request->data['Blog']['image'];
                    unset($this->request->data['Blog']['image']);
                    $model = "Blog";
                    list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);
                    if ($width >= '1000' && $height >= '400' && $height < $width) {
                        $retrun = $this->Image->upload_image($image,$model,$uid);
                        if($retrun){
                            $this->request->data['Blog']['image'] = $retrun;
                            if(isset($pageDetail['Blog']['image'])&&(!empty($pageDetail['Blog']['image']))){
                                $this->Image->delete_image($pageDetail['Blog']['image'],$model ,$uid);
                            }
                        }
                    } else{
                        //$this->request->data['image'][0] = "dd";
                        $edata['data'] = array('image'=>array('0'=>__('only_width_800_height_400_allowed', true)));
                        $edata['message'] = __('only_width_800_height_400_allowed', true);
                        echo json_encode($edata);
                        die;
                    }
                } else{
                    
                    if($blogID) {
                        $this->request->data['Blog']['image'] =  $pageDetail['Blog']['image']; 
                    } else{
                        $this->request->data['Blog']['image']='';
                    }
                }
                if($blogID){
                    $this->Blog->id = $blogID;
                }else{
                    $this->Blog->create();
                }
                if($this->Blog->save($this->request->data)){
                    $blog_id = (!empty($blogID))?$blogID:$this->Blog->getLastInsertId();
                    if($blogID){
                        $this->BlogToCategory->deleteAll(array('BlogToCategory.blog_id'=>$blogID),false);
                    } 
                    $blog_to_cat['BlogToCategory']['blog_id'] = $blog_id;   
                    $categories = $this->request->data['Blog']['category'];    
                    foreach($categories as $category){
                        $blog_to_cat['BlogToCategory']['category_id'] = $category;    
                        $this->BlogToCategory->create();                 
                        $this->BlogToCategory->save($blog_to_cat);
                    }
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('page_save_success',true);
                    echo json_encode($edata);
                    die;
                } else {
                    $message = __('unable_to_save', true);
                    $vError = $this->Blog->validationErrors;
                    $edata['data'] = $vError ;
                    $edata['message'] = $message;
                    echo json_encode($edata);
                    die;
                }
            //}else{
            //    $message = __('unable_to_save', true);
            //    $vError = $this->Blog->validationErrors;
            //    $edata['data'] = $vError ;
            //    $edata['message'] = $message;
            //    echo json_encode($edata);
            //    die;
            //}
        } 
        if(!$this->request->data && isset($pageDetail)){
            $this->request->data = $pageDetail;
        }
        $this->set(compact('breadcrumb','cats','pageDetail'));
    }

    
    /**********************************************************************************    
    @Function Name : admin_all_blogs
    @Params	 : NULL
    @Description   : dispaly all blogs!!
    @Author        : Sanjeev kanungo
    @Date          : 13-Nov-2014
    ***********************************************************************************/
    public function admin_all_blogs(){
        $this->layout = 'admin';
        $this->loadModel('Blog');
        $breadcrumb = array(
                    'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                    'Blogs'=>array('controller'=>'blogs','action'=>'all_blogs','admin'=>true),
                    );
        $this->set('breadcrumb',$breadcrumb);
        $created_by = $this->Auth->user('id');
        if($this->Auth->user('type') == 1){
            $created_by = 0;
        }else{
	    $this->redirect(array('controller'=>'homes','action'=>'index','admin'=>false));
	}
        $this->Blog->bindModel(array('hasMany'=>array(
                    'BlogToCategory'=>array(
                    'className'=>'BlogToCategory',
                    'fields'=>'category_id'
                    )  
                ))); 
        $conditions = array('is_deleted'=>0);
        $getFields = array('Blog.*');
        $allBlogs =  $this->Blog->find('all' , array('conditions' =>$conditions,'order'=>'id DESC'));
        $this->set(compact('allBlogs'));
        $this->set('page_title',' Blogs');
        $this->set('activeTMenu','blog');
        $this->set('leftMenu',true);
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
            $this->viewPath = "Elements/admin/Blog";
            $this->render('list_blog');
        }
    }
       
    /**********************************************************************************    
    @Function Name : admin_changeStatus_blog
    @Params	 : NULL
    @Description   : Add New blog !!
    @Author        : Sanjeev kanungo
    @Date          : 13-Nov-2014
    ***********************************************************************************/
    
    public function admin_changeStatus_blog(){
        $this->loadModel('Blog'); 
        $this->autoRender = false;
        if($this->request->is('post')){
            if($this->Blog->updateAll(array('Blog.status'=>$this->request->data['status']),array('Blog.id'=>$this->request->data['id']))){
                return $this->request->data['status'];
            }
        }
    }
    /**********************************************************************************    
    @Function Name : admin_deleteBlog
    @Params	 : NULL
    @Description   : Add New blog !!
    @Author        : Sanjeev kanungo
    @Date          : 13-Nov-2014
    ***********************************************************************************/
    public function admin_deleteBlog($blogID=NULL){
        $this->loadModel('Blog');
        //  $this->loadModel('BlogToCategory');
        $this->autoRender = "false";
        if($this->request->is('post') || $this->request->is('put')){
            $blogID = $this->request->data['id'];
            $blog = $this->Blog->findById($blogID);
            if(!empty($blog)){
                if($this->Blog->updateAll(array('Blog.is_deleted'=>1),array('Blog.id'=>$blogID))){
                    $edata['data'] = 'success' ;
                    $edata['message'] = __('delete_success',true);
                } else {
                    $edata['data'] = 'error' ;
                    $edata['message'] = __('unable_to_delete',true);
                }
            } else{
                $edata['data'] = 'error' ;
                $edata['message'] = __('page_not_found',true);
            }
        } else{
            $edata['data'] = 'error' ;
            $edata['message'] = __('page_not_found',true);
        }
        echo json_encode($edata);
        die;
    }
  
    public function index(){
        $this->loadModel('Blog');  
        $conditions = array();
        $getFields = array('Blog.status'=>1,'Blog.is_deleted'=>0);
        $this->Paginator->settings = array('conditions' =>$conditions,'limit'=>4,'order'=>'id DESC');
        $allBlogs = $this->Paginator->paginate('Blog');
        if($this->request->is('ajax')){
            $this->layout = 'ajax';// View, Layout
        }
        $this->set(compact('allBlogs'));
    }
    
  
    public function search(){
        $this->loadModel('Blog');
        $this->loadModel('BlogToCategory');
        $lang = Configure::read('Config.language');
        $searchTitle = $lang.'_title';
        $description = $lang.'_description';
        if($this->request->is(array('put','post'))){
            $category_id=  $this->request->data['Blog']['category'];
            $keyword = $this->request->data['Blog']['search'];
            $conditions = array(
                'Blog.is_deleted'=>0,
                'OR' => array(
                'Blog.'.$searchTitle .' LIKE' => "%$keyword%",
                'Blog.'.$description.' LIKE' => "%$keyword%"
            ));
            if($category_id){
                $this->BlogToCategory->recursive = -1;
                $blogs =  $this->BlogToCategory->find('list' , array('conditions'=>array('category_id'=>$category_id) , 'fields'=>array('blog_id')));  
                $conditions['Blog.id'] = $blogs;
                $this->set('cat_id' , $category_id);
            }
            $setvar = array();
            $setvar['keyword'] = $keyword;
            $setvar['cat_id'] = $category_id;
            $this->Session->write('setVar',$setvar);
            $this->Session->write('condition',$conditions);
        }
        //pr($conditions); die;
        if($this->Session->check('condition')){
            $conditions = $this->Session->read('condition');
        } else {
            $conditions = null;
        }
        $getFields = array('Blog.*');
        $this->Paginator->settings  =  array('conditions'=>$conditions,'order'=>'id DESC' ,'fields'=>$getFields ,'limit'=>4);
        $allBlogs = $this->Paginator->paginate('Blog');
        $this->set(compact('allBlogs'));
        $this->render('index');
        // $allBlogs =  $this->Blog->find('all' , array('conditions' =>$conditions,'order'=>'id DESC'));
    }
   
    /**********************************************************************************    
        @Function Name : view
        @Params	     : id ,alias
        @Description   : Blog View page!!.
        @Author        : Sanjeev kanungo
        @Date          : 17-Nov-2014
    ***********************************************************************************/
            
    public function view($blogID=NULL , $searchTitle=NULL){
        $this->loadModel('BlogComment');    
        if($blogID==NULL){
            throw new NotFoundException('Could not find that Blog');
        }
        $blogID = base64_decode($blogID);
        $this->Blog->recursive = -1;
        //$this->Blog->bindModel();
        $blog = $this->Blog->findById($blogID);
        if(!$blog){
            throw new NotFoundException('Could not find that Blog');
        }
        $this->BlogComment->bindModel(array('belongsTo'=>array(
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id',
                'fields'=>array('User.first_name','User.last_name','User.image','User.id')
            )
        )));
        $this->BlogComment->recursive = 1;
        $comments =  $this->BlogComment->find('all' ,array('conditions'=>array('BlogComment.blog_id'=>$blogID)));
        $totalComment = $this->BlogComment->find('count' , array('conditions'=>array('BlogComment.blog_id'=>$blogID)));
        $this->set(compact('blog' ,'totalComment','comments'));
    }
    
   
    public function add_comment(){
        $this->loadModel('BlogComment');
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $data['BlogComment']['user_id'] = $this->Auth->user('id');
            $data['BlogComment']['eng_comment'] = $this->request->data['comment'];
            $data['BlogComment']['blog_id'] = $this->request->data['blog_id'];
            $this->BlogComment->set($data);
            if ($this->BlogComment->save($data)){
                $blogID = $this->BlogComment->getLastInsertId();
                $this->BlogComment->bindModel(array('belongsTo' => array(
                        'User' => array(
                            'className' => 'User',
                            'foreignKey' => 'user_id',
                            'fields' => array('User.first_name', 'User.last_name','User.image','User.id')
                        )
                )));
                $this->BlogComment->recursive = 1;
                $comment = $this->BlogComment->findById($blogID);
                $this->set('comment', $comment);
            }
        }
    }

    public function admin_view($blogID=NULL){
        if($blogID==NULL){
            throw new NotFoundException('Could not find that Blog');
        }
        $breadcrumb = array(
                'Home'=>array('controller'=>'dashboard','action'=>'index','admin'=>true),
                'Blogs'=>array('controller'=>'Blogs','action'=>'all_blogs','admin'=>true),
            );
        $this->layout ='ajax';
        //$blogID = base64_decode($blogID);
        $this->Blog->bindModel(array('hasMany'=>array(
                    'BlogToCategory'=>array(
                    'className'=>'BlogToCategory',
                    'fields'=>'category_id'
                    )  
                ))); 
        $getFields = array('Blog.*');
        $blog = $this->Blog->findById($blogID);
        if(!$blog){
            throw new NotFoundException(__('page_not_found',true));
        }
        $page_title = "Blog";
        $this->set('activeTMenu','albums');
        $this->set(compact('blog','page_title','breadcrumb'));
    }
    
    public function blog($category_id='47'){
        $this->loadModel('BlogCategory');
        $categories =  $this->BlogCategory->find('all' , array('conditions'=>array('status'=>1) , 'fields'=>array('id','eng_name')));
        $this->set(compact('categories'));
        $this->loadModel('BlogToCategory');
        $this->BlogToCategory->recursive = -1;
        $number_records=10;
        $fields = array('blog_id');
        $order = 'BlogToCategory.blog_id DESC';
	$conditions = array('category_id'=>$category_id);
	$fields = array('blog_id','Blog.id','Blog.eng_title','Blog.eng_description','Blog.created','User.id','User.first_name','User.last_name');
	$this->Paginator->settings = array(
		 'BlogToCategory' => array(
		     'limit' => $number_records,
		     'conditions' => $conditions,
		     'fields' => $fields,
		     'order' => $order,
                     'limit'=>1,
                     'joins' => array(
                        array(
                            'table' => 'blogs',
                            'alias' => 'Blog',
                            'type' => 'left',
                            'conditions' => array(
                                'Blog.id = BlogToCategory.blog_id'
                            )
                        ),
                        array(
                            'table' => 'users',
                            'alias' => 'User',
                            'type' => 'left',
                            'conditions' => array(
                                'User.id = Blog.created_by'
                            )
                        )
                    )
		    
		 )
	     );
	$post_ids = $this->Paginator->paginate('BlogToCategory');
        $this->set(compact('post_ids'));
    }
    
    public function category($category_id = 'latest', $post_id = ''){
        $this->loadModel('BlogCategory');
        $categories =  $this->BlogCategory->find('all' , array('conditions'=>array('status'=>1) , 'fields'=>array('id','eng_name')));
        $this->set(compact('categories'));
        $this->loadModel('BlogToCategory');
        $this->BlogToCategory->recursive = -1;
        $number_records=1;
        $fields = array('blog_id');
        $order = 'BlogToCategory.blog_id DESC';
        $conditions = array();
        $similarConditions = array();
        if($category_id != 'latest'){
            $conditions['category_id'] = $category_id;
            $similarConditions['category_id'] = $category_id;
        }
        if(!empty($post_id)){
                $conditions['Blog.id'] = $post_id;
        }
	$conditions['Blog.status'] = 1;
        $conditions['Blog.is_deleted'] = 0;
        $similarConditions['Blog.status'] = 1;
        $similarConditions['Blog.is_deleted'] = 0;
	$fields = array('blog_id','Blog.id','Blog.eng_title','Blog.image','Blog.eng_description','Blog.created_by','Blog.created','User.id','User.first_name','User.last_name','BlogComment.eng_comment');
	$mainBlog = $this->BlogToCategory->find('first',array(
		'conditions' => $conditions,
		'fields' => $fields,
		'order' => $order,
                'group' =>'BlogToCategory.blog_id',
                'joins' => array(
                    array(
                        'table' => 'blogs',
                        'alias' => 'Blog',
                        'type' => 'left',
                        'conditions' => array(
                        'Blog.id = BlogToCategory.blog_id'
                        )
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'User',
                        'type' => 'left',
                        'conditions' => array(
                            'User.id = Blog.created_by'
                        )
                    ),
                    array(
                        'table' => 'blog_comments',
                        'alias' => 'BlogComment',
                        'type' => 'left',
                        'conditions' => array(
                            'Blog.id = BlogComment.blog_id'
                        )
                    )
                )
	    ));
         if(!empty($mainBlog)){
            $similarConditions['NOT']['Blog.id'] = $mainBlog['Blog']['id'];
         }
         
        $this->Paginator->settings = array(
	    'BlogToCategory' => array(
		'conditions' => $similarConditions,
		'fields' => $fields,
		'order' => $order,
                'limit'=>6,
                'status'=>0,
                'is_deleted'=>1,
                'group' =>'BlogToCategory.blog_id',
                'joins' => array(
                    array(
                        'table' => 'blogs',
                        'alias' => 'Blog',
                        'type' => 'left',
                        'conditions' => array(
                        'Blog.id = BlogToCategory.blog_id'
                        )
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'User',
                        'type' => 'left',
                        'conditions' => array(
                            'User.id = Blog.created_by'
                        )
                    ),
                    array(
                        'table' => 'blog_comments',
                        'alias' => 'BlogComment',
                        'type' => 'left',
                        'conditions' => array(
                            'Blog.id = BlogComment.blog_id'
                        )
                    )
                )
	    )
        );
	$similarPosts = $this->Paginator->paginate('BlogToCategory');
        
        $this->loadModel('SalonAd');
        
        
        $conditions= 'SalonAd.status = 1 and SalonAd.is_deleted = 0 and SalonAd.type = 1 and page=1';
	$banner_list = $this->SalonAd->find('all' , 
	    array(
		'conditions' => array($conditions),
		'fields' => array('SalonAd.id','SalonAd.user_id','SalonAd.image','SalonAd.eng_description'),
		'order' => 'rand()',
		'limit' => 10,
	    )
	);
        
        
        
        
        $this->set(compact('similarPosts','mainBlog','category_id','banner_list'));
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        }
    }
    
   
}
