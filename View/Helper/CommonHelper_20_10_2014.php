<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
*/

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
*/
class CommonHelper extends Helper
{
    function getItemPic($imageName = null)
    {
        if ($imageName != '') {
            if(file_exists(WWW_ROOT . "img/items/thumb/" . $imageName)) {
                return "items/thumb/" . $imageName;
            } else {
            return "items/thumb/" . "no_image.png";
            }
        } else {
            return "items/thumb/" . "no_image.png";
        }
    }
    function getItemPicThumb($imageName = null)
    {
        if ($imageName != '') {
            if(file_exists(WWW_ROOT . "img/items/thumb_small/" . $imageName)) {
                return "items/thumb_small/" . $imageName;
            } else {
            return "items/thumb_small/" . "no_image.png";
            }
        } else {
            return "items/thumb_small/" . "no_image.png";
        }
    }
    function getUserPicThumb($imageName = null,$thumb_folder =null)
    {
        if ($imageName != '') {
            if(file_exists(WWW_ROOT . "img/users/".$thumb_folder."/" . $imageName)) {
                return "users/".$thumb_folder."/" . $imageName;
            } else {
            return "users/".$thumb_folder."/" . "no_image.png";
            }
        } else {
            return "users/".$thumb_folder."/" ."no_image.png";
        }
    }
    function getCompanyLogoThumb($imageName = null,$thumb_folder =null)
    {
        if ($imageName != '') {
            if(file_exists(WWW_ROOT . "img/logo/".$thumb_folder."/" . $imageName)) {
                return "logo/".$thumb_folder."/" . $imageName;
            } else {
            return "logo/".$thumb_folder."/" . "no_pic.png";
            }
        } else {
            return "logo/".$thumb_folder."/" ."no_pic.png";
        }
    }
    function getShowroomPicThumb($imageName = null,$thumb_folder =null)
    {
        if ($imageName != '') {
            if(file_exists(WWW_ROOT . "img/showrooms/".$thumb_folder."/" . $imageName)) {
                return "showrooms/".$thumb_folder."/" . $imageName;
            } else {
            return "showrooms/".$thumb_folder."/" . "no_image.png";
            }
        } else {
            return "showrooms/".$thumb_folder."/" ."no_image.png";
        }
    }
    function getSize($sizeId , $sizeArr){
        foreach($sizeArr as $key =>$val){
            if($key == $sizeId){
                return $key;
            }
        }        
    }
    
    function stringConvertSpaceToUscore($getName = null)
    {
        $getName = strtolower(str_replace(' ','_',$getName));
        return $getName;
    }
    /*
     show humanTiming
     measure time difference between current time and offer time in FORMAT ()
     //10Days: 14 hours 37 minutes 21 seconds
    */
   function getCategoryCount($parentCategoryID){
        App::import("Model", "Category");  
        $model = new Category();  
        $count  = $model->find("count",array('conditions'=>array('Category.parent_id'=>$parentCategoryID)));
        return $count;
   }
   function getCategory($parentCategoryID){
        App::import("Model", "Category");  
        $model = new Category(); 
        $count  = $model->find("list",array('conditions'=>array('Category.parent_id'=>$parentCategoryID),'fields'=>array('id','category')));
       
        return $count;
   }
   function getCategoryName($categoryId){
        App::import("Model", "Category");  
        $model = new Category();
        $cat = $model->find('first',array('conditions'=>array('Category.id'=>$categoryId),'fields'=>array('category')));
        return $cat['Category']['category'];
   }
	function humanTiming ($postingDate){
		$time = strtotime($postingDate);
		$time = time() - $time; // to get the time since that moment

		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s ago':' ago');
		}
	}
	function getauser($uID=NULL){
		App::import("Model","User");  
		$model = new User();
		$data = $model->find('first',array('conditions'=>array('User.id'=>$uID)));
		return $data;
	}
	function getRightmenuTags(){
		App::import("Model","TagSum");  
		$model = new TagSum();
		App::import("Model","Tag");  
		$model1 = new Tag();
		$data = $model->find('all',array('conditions'=>array(),'fields'=>array('TagSum.tag_id','COUNT(`TagSum`.`tag_id`) as `entity_count`','Tag.tag_name','TagSum.content_id'),'group'=>array('TagSum.tag_id'),'order'=>array('entity_count DESC'),'limit' => 5));
		return $data;
	}
	function getAllContents(){
		App::import("Model","Content");  
		$model = new Content();
		$data = $model->find('all', array('conditions' => array('Content.status' =>1)));
		return $data;
	}
	function getAllContentsByUser($userID=NULL){
		App::import("Model","Content");  
		$model = new Content();
		App::import("Model","Photo");  
		$this->Photo = new Photo();
		$model->bindModel(array('hasMany'=>array('Photo')));
		$data = $model->find('all', array('conditions'=>array('Content.status' =>1,'Content.user_id' =>$userID)));
		return $data;
	}
	function getListsItem($lid=null){
		App::import("Model","ListsItem");  
		$model = new ListsItem();
		$data = $model->find('all', array('conditions' => array('ListsItem.lists_id' =>$lid)));
		return $data;
	}
	function getMemeImages($mid=null){
		App::import("Model","MemeImage");  
		$model = new MemeImage();
		$data = $model->find('first', array('conditions' => array('MemeImage.id' =>$mid)));
		return $data;
	}
	function getALineupItem($lineupID=null){
		App::import("Model","LineupItem");  
		$model = new LineupItem();
		$data = $model->find('first', array('conditions' => array('LineupItem.lineup_id' =>$lineupID)));
		return $data;
	}
	function getTagByPost($tagID=null){
		App::import("Model","Tag");  
		$model = new Tag();
		App::import("Model","TagSum");  
		$this->TagSum = new TagSum();
		$model->unBindModel(array('hasMany'=>array('TagSum')));
		$data = $model->find('all', array('conditions' => array('Tag.id' =>$tagID),'fields'=>array('Tag.id','Tag.tag_name')));
		return $data;
	}
	function getTagIdByName($tag_name=null){
		App::import("Model","Tag");  
		$model = new Tag();
		$data = $model->find('first', array('conditions' => array('Tag.tag_name' =>$tag_name),'fields'=>array('Tag.id')));
		return $data;
	}
	function getAllSlideItemBySlide($content_id=null){
		App::import("Model","Slide");  
		$this->Slide = new Slide();
		App::import("Model","SlideItem");  
		$this->SlideItem = new SlideItem();
		$slideItemid = $this->Slide->find('first', array('conditions' => array('Slide.content_id' =>$content_id),'fields'=>array('Slide.id')));
		if(!empty($slideItemid)){
			$data = $this->SlideItem->find('all', array('conditions' => array('SlideItem.slide_id' =>$slideItemid['Slide']['id'])));
		}else{
			$data=$this->SlideItem->find('all', array('conditions' => array()));
		}
		return $data;
	}
	function getAllVideoByContentId($tagIDs=null){
		App::import("Model","Video");  
		$model = new Video();
		App::import("Model","Content");  
		$contentModel = new Content();
                $contentModel->unbindModel(array('belongsTo'=>array('User'),'hasMany'=>array('PostComment')));
                $contentModel->bindModel(array('hasOne'=>array('Video')));
                $tagIDs = array();
		if(!empty($tagIDs)){
                    App::import("Model","TagSum");  
                    $tagSumModel = new TagSum();
                    $tagSumModel->unbindModel(array('belongsTo'=>array('Tag')));
		    $cntIds = $tagSumModel->find('list',array('fields'=>array('TagSum.content_id'),'conditions'=>array('TagSum.tag_id'=>$tagIDs),'order'=>'TagSum.created DESC','limit'=>10));
                    $data = $model->find('all', array('conditions' => array('Video.content_id' =>$cntIds),'limit'=>'5'));
                    if(empty($data)){
                        $data = $contentModel->find('all',array('fields'=>array('Video.video_url,Video.content_id'),'conditions'=>array("Content.created > current_date()-7 " ,"Video.video_url != '' " ),'order'=>'Content.id','limit'=>5 ));
                    }
		}else{
		    $data = $contentModel->find('all',array('fields'=>array('Video.video_url,Video.content_id'),'conditions'=>array("Content.created > current_date()-7 " ,"Video.video_url != '' " ),'order'=>'Content.id','limit'=>5 ));
                    //$data = $model->find('all', array('conditions' => array(),'order'=>array('Video.id DESC'),'limit'=>'3'));
		}
		return $data;
	}
	function getAllChildPost($postID=null){
		App::import("Model","PostComment");  
		$this->PostComment = new PostComment();
		App::import("Model","PostCommentLike");  
		$this->PostCommentLike = new PostCommentLike();
		$data = $this->PostComment->find('all', array('conditions' => array('PostComment.parent_id' =>$postID)));
		
		return $data;
	}
        function getAllPopularPost(){
		App::import("Model","Content");  
		$model = new  Content();
                $model->unBindModel(array('hasMany'=>array('PostComment')));
                $model->BindModel(array('hasMany'=>array('Photo')));
                $data = $model->find('all', array('conditions' => array('Content.status' =>'1'),'limit'=>'5','order'=>array('Content.id DESC'),));
		return $data;
	}

        function getNoImage($path)
         {
            return "no_image/".$path."/". "no_image.jpg";
            
    } 
	function getAlllikeDislikecomment($postID=null){
		App::import("Model","PostCommentLike");  
		$model = new PostCommentLike();
		$like_data = $model->find('count', array('conditions' => array('PostCommentLike.post_comment_id' =>$postID,'PostCommentLike.post_like'=>'1')));
		$dislike_data = $model->find('count', array('conditions' => array('PostCommentLike.post_comment_id' =>$postID,'PostCommentLike.post_dislike'=>'1')));
		
		$array = array($like_data,$dislike_data);
		$data = implode(",", $array);
		return $data;
	}
	function getAQuizQuestion($quizID=NULL){
		App::import("Model","QuizQuestion");  
		$this->QuizQuestion = new QuizQuestion();
		$data = $this->QuizQuestion->find('first', array('conditions' => array('QuizQuestion.quiz_id' =>$quizID)));
		
		return $data;
	}
	function getAllPollQuestion($pollID=NULL){
		App::import("Model","PollQuestion");  
		$this->PollQuestion = new PollQuestion();
		$data = $this->PollQuestion->find('all', array('conditions' => array('PollQuestion.polls_id' =>$pollID)));
		
		return $data;
	}
	function getTotallAnswersPoll($pollID=NULL,$pollqtnID=NULL,$pollansID=NULL){
		App::import("Model","PollPreviewResult");  
		$this->PollPreviewResult = new PollPreviewResult();
		$totalp=$this->PollPreviewResult->find('count',array('conditions'=>array('PollPreviewResult.poll_answer_id'=>$pollansID)));
		
		$totalA=$this->PollPreviewResult->find('count',array('conditions'=>array('PollPreviewResult.poll_id'=>$pollID)));
		if(!empty($totalA)){
		$pollpercnt=round((($totalp/$totalA)*100),2).'%';
		}else{
			$pollpercnt='';
		}
		$totalp = '('.$totalp.' votes)';
		$array=array($pollpercnt,$totalp);
		$data = implode(',',$array);
		return $data;
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
			if (substr($url, 0, 7) == "<iframe"){
			  preg_match('/src="([^"]+)"/',$url, $match); 
			  $parse = parse_url($match[1]);
			  return $host = $parse['host'];
			}else{
        $host = @parse_url($url, PHP_URL_HOST);
        if (!$host)
            $host = $url;
        if (substr($host, 0, 4) == "www.")
            $host = substr($host, 4);
        // You might also want to limit the length if screen space is limited
        if (strlen($host) > 50)
            $host = substr($host, 0, 47) . '...';
            return $host;
			}
            exit;
    }
    
    
    
    public function getTimeDifference($time) {
        //Let's set the current time
        $currentTime = date('Y-m-d H:i:s');
        $toTime = strtotime($currentTime);
    
        //And the time the notification was set
        $fromTime = strtotime($time);
    
        //Now calc the difference between the two
        $timeDiff = floor(abs($toTime - $fromTime) / 60);
    
        //Now we need find out whether or not the time difference needs to be in
        //minutes, hours, or days
        if ($timeDiff < 2) {
            $timeDiff = "Just now";
        } elseif ($timeDiff > 2 && $timeDiff < 60) {
            $timeDiff = floor(abs($timeDiff)) . " minutes ago";
        } elseif ($timeDiff > 60 && $timeDiff < 120) {
            $timeDiff = floor(abs($timeDiff / 60)) . " hour ago";
        } elseif ($timeDiff < 1440) {
            $timeDiff = floor(abs($timeDiff / 60)) . " hours ago";
        } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
            $timeDiff = floor(abs($timeDiff / 1440)) . " day ago";
        } elseif ($timeDiff > 2880) {
            $timeDiff = floor(abs($timeDiff / 1440)) . " days ago";
        }
    
        return $timeDiff;
    }
    
  
    function get_post_content($post_model=null, $post_id=null){
        $post_model = ucfirst($post_model);
        $post_id    = base64_decode($post_id);
        $this->loadModel($post_model);
        $content = $this->$post_model->find('first', array('conditions' => array('id' => $post_id)));
        $slideItem_arr = array();
        $pollItem_arr = array();
        
        if($post_model == 'Slide'){
            $this->loadModel('SlideItem');
            $slideItem_arr = $this->SlideItem->find('all', array('conditions' => array('slide_id' => $post_id)));   
            $content['Slide']['SlideItem']   = $slideItem_arr;  
        }
        if($post_model == 'Poll'){
            $this->loadModel('PollQuestion');
            $pollItem_arr = $this->PollQuestion->find('all', array('conditions' => array('polls_id' => $post_id)));   
            $content['Poll']['PollQuestion']   = $pollItem_arr;
        }
        if($post_model == 'ContentList'){
            $this->loadModel('ListsItem');
            $listitem_arr = $this->ListsItem->find('all', array('conditions' => array('lists_id' => $post_id)));   
            $content['ContentList']['ListsItem']   = $listitem_arr;
        }
        if($post_model == 'Lineup'){
            $this->loadModel('LineupItem');
            $lineupitem_arr = $this->LineupItem->find('all', array('conditions' => array('lineup_id' => $post_id)));   
            $content['Lineup']['LineupItem']   = $lineupitem_arr;
        }
        $this->request->data        = $content;
        $this->set(compact('content'));
    }
    


    
    
    
    
}