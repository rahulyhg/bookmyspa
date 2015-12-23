<?php
    $content_order_arr  = array();
    $indexvalue         = array();
    if(!empty($content['Content']['content_order'])){
        $content_order_arr = json_decode($content['Content']['content_order'],true); //debug($CCC);
        if(!empty($content_order_arr)){
            foreach ($content_order_arr as $content_order){
                 foreach ($content_order as $key => $val){
                    $indexvalue[] =ucfirst($key);
                 }
            }
        }
    }
    $content_name = isset($content['Content']['title']) ? $content['Content']['title']: "";
$html = "";
$html .= "<input type='hidden' name='hidden_content_name' id='hidden_content_id' value='".$content_name."'>";
$html .= "<div id='hidden_tag' style='display:none;'>";

foreach($content['Tag'] as $tag){
    $html .='<span class="tag editPosttag">
<span>'.$tag.'</span>
<a href="#" title="Removing tag">x</a>
</span>';
}
$html .="</div>";

//pr($content_order_arr); die;

foreach($content_order_arr as $key => $orderModel){
    $fliporderModel = array_flip($orderModel);
    
    if((ucwords(current($fliporderModel)) == 'Photo') && isset($content['Photo']) && !empty($content['Photo'])){  
        foreach($content['Photo'] as $photo){
            if($photo['id'] == current($orderModel)){
               
                $url = ($photo['image_type'] == 'url') ? $photo['image'] : "/img/photos/thumb/".$photo['image'];
                
                $html .= '<section class="postthumb panel1">
                    <div class="panel-heading1">
                    <section class="post-cat">
                    <i class="fa fa-photo ph-col mrgrtnone"></i> Photo
                    </section>
                    <section class="postmiddle" id="image_'.$photo['id'].'">
                    <img src="'.$url.'" alt="" style="max-width:30px; max-height:30px">
                    </section>
                    <input type="hidden" name="data[Content][content_order][][photo]" class="image_thumb" value="'.$photo['id'].'">
                    <section class="postaction">
                    <a href="javascript:void(0);" data-id="'.$photo['id'].'" data-type="photo" class="editVideo">
                    <i class="fa fa-editicon"><img src="/img/home/icons/edit.png" alt=""></i>
                    </a>
                    <a href="javascript:void(0);" data-id="'.$photo['id'].'" data-type="photo" class="deleteContent"><i class="fa fa-trash-o red-col"></i>
                    </a>
                    </section>
                    </div>
                    </section>'; 
            }
        }
    }
    
    if((ucwords(current($fliporderModel)) == 'Text') && isset($content['Text']) && !empty($content['Text'])){  
        foreach($content['Text'] as $text){
            if($text['id'] == current($orderModel)){
                $html .= '<section class="postthumb panel1">
                <div class="panel-heading1">
                <section class="post-cat">
                <i class="fa fa-th-text mrgrtnone bl-col">
                <img src="/img/home/icons/text-icon.png" alt=""></i> Text
                </section>
                <section class="postmiddle" id="text_'.$text['id'].'"><p>'.substr($text['text'], 0, 20).'</p>
                </section>
                <input type="hidden" name="data[Content][content_order][][text]" value="'.$text['id'].'">
                <section class="postaction">
                <a href="javascript:void(0);" data-id="'.$text['id'].'" data-type="text" class="editContent">
                <i class="fa fa-editicon">
                <img src="/img/home/icons/edit.png" alt=""></i></a>
                <a href="javascript:void(0);" data-id="'.$text['id'].'" data-type="text" class="deleteContent">
                <i class="fa fa-trash-o red-col"></i></a>
                </section>
                </div>
                </section>';
            }
        }
    }
    
    if((ucwords(current($fliporderModel)) == 'Slide') && isset($content['Slide']) && !empty($content['Slide'])){
        foreach($content['Slide'] as $slide){
            if($slide['id'] == current($orderModel)){
                $html .= '<section class="postthumb panel1">
                    <div class="panel-heading1">
                      <section class="post-cat">
                      <i class="fa fa-sliders mrgrtnone">
                        </i> Slide</section>
                        <section id="slide_'.$slide['id'].'" class="postmiddle">'.$slide['SlideItem']['title'].'</section>
                        <input value="'.$slide['id'].'" type="hidden" name="data[Content][content_order][][Slide]" />
                        <section class="postaction">
                        <a class="editContent" data-type="slide" data-id="'.$slide['id'].'" href="javascript:void(0);">
                        <i class="fa fa-editicon"><img alt="" src="/img/home/icons/edit.png"></i></a>
                        <a class="deleteContent"  data-type="slide" data-id="'.$slide['id'].'"><i class="fa fa-trash-o red-col"></i></a>
                        </section>
                    </div>
                  </section>';
            }  
        }
    }
    
    if((ucwords(current($fliporderModel)) == 'Meme') && isset($content['Meme']) && !empty($content['Meme'])){
        foreach($content['Meme'] as $meme){
            if($meme['id'] == current($orderModel)){
                $html .= '<section class="postthumb panel1">
                    <div class="panel-heading1">
                      <section class="post-cat">
                      <i class="fa fa-meme mrgrtnone"><img alt="" src="/img/home/icons/meme.png"></i>Meme</section>
                        <section id="meme_'.$meme['id'].'" class="postmiddle"></section>
                        <input value="'.$meme['id'].'" type="hidden" name="data[Content][content_order][][meme]" />
                        <section class="postaction">
                        <a class="editContent" data-type="meme" data-id="'.$meme['id'].'" href="javascript:void(0);"><i class="fa fa-editicon"><img alt="" src="/img/home/icons/edit.png"></i></a>
                        <a class="deleteContent"  data-type="meme" data-id="'.$meme['id'].'"><i class="fa fa-trash-o red-col"></i></a>
                        </section>
                    </div>
                  </section>';
            }
        }
    }
    
    if((ucwords(current($fliporderModel)) == 'ContentList') && isset($content['ContentList']) && !empty($content['ContentList'])){  
        foreach($content['ContentList'] as $contentlist){
            if($contentlist['id'] == current($orderModel)){
                $html .= '<section class="postthumb panel1">
                <div class="panel-heading1">
                <section class="post-cat">
                <i class="fa fa-th-list mrgrtnone bl-col"></i> List
                </section>
                <section class="postmiddle" id="list_'.$contentlist['id'].'">'.$contentlist['ListsItem']['title'].'
                </section>
                <input type="hidden" name="data[Content][content_order][][ContentList]" value="'.$contentlist['id'].'">
                <section class="postaction">
                <a href="javascript:void(0);" data-id="'.$contentlist['id'].'" data-type="lists" class="editContent">
                <i class="fa fa-editicon"><img src="/img/home/icons/edit.png" alt=""></i>
                </a>
                <a href="javascript:void(0);" data-id="'.$contentlist['id'].'" data-type="lists" class="deleteContent">
                <i class="fa fa-trash-o red-col"></i>
                </a>
                </section>
                </div>
                </section>';
            }
        }
    }
    
    if((ucwords(current($fliporderModel)) == 'Lineup') && isset($content['Lineup']) && !empty($content['Lineup'])){  
        foreach($content['Lineup'] as $lineup){
            if($lineup['id'] == current($orderModel)){
                $line_title = isset($lineup['LineupItem']['lineup_class']) ? (($lineup['LineupItem']['lineup_class'] == 'lineup1') ? "4-4-2": "3-4-3" ) : "";
                $html .= '<section class="postthumb panel1">
                <div class="panel-heading1">
                <section class="post-cat">
                <i class="fa fa-lineup mrgrtnone">
                <img src="/img/home/icons/lineup.png" alt=""></i> Lineup
                </section>
                <section class="postmiddle" id="lineup_'.$lineup['id'].'">'.$line_title.'
                </section>
                <input type="hidden" name="data[Content][content_order][][lineup]" value="'.$lineup['id'].'">
                <section class="postaction">
                <a href="javascript:void(0);" data-id="'.$lineup['id'].'" data-type="lineup" class="editContent">
                <i class="fa fa-editicon">
                <img src="/img/home/icons/edit.png" alt=""></i>
                </a>
                <a href="javascript:void(0);" data-id="'.$lineup['id'].'" data-type="lineup" class="deleteContent">
                <i class="fa fa-trash-o red-col"></i>
                </a>
                </section>
                </div>
                </section>';
            }
        }
    }
     
    if((ucwords(current($fliporderModel)) == 'Quiz') && isset($content['Quiz']) && !empty($content['Quiz'])){  
        foreach($content['Quiz'] as $quiz){
             if($quiz['id'] == current($orderModel)){
                $html .= '<section class="postthumb panel1">
                <div class="panel-heading1">
                <section class="post-cat">
                <i class="fa fa-question-circle orng-col mrgrtnone"></i> Quiz
                </section>
                <section class="postmiddle" id="quiz_'.$quiz['id'].'">'.$quiz['title'].'</section>
                <input type="hidden" name="data[Content][content_order][][quiz]" value="'.$quiz['id'].'">
                <section class="postaction">
                <a href="javascript:void(0);" data-id="'.$quiz['id'].'" data-type="quiz" class="editContent">
                <i class="fa fa-editicon">
                <img src="/img/home/icons/edit.png" alt=""></i>
                </a>
                <a href="javascript:void(0);" data-id="'.$quiz['id'].'" data-type="quiz" class="deleteContent">
                <i class="fa fa-trash-o red-col"></i></a>
                </section>
                </div>
                </section>';
             }
        }
    }
    if((ucwords(current($fliporderModel)) == 'Poll') && isset($content['Poll']) && !empty($content['Poll'])){  
        foreach($content['Poll'] as $poll){
            if($poll['id'] == current($orderModel)){
                $html .= '<section class="postthumb panel1">
                <div class="panel-heading1">
                <section class="post-cat">
                <i class="fa fa-bar-chart-o grn-col mrgrtnone"></i> Poll
                </section>
                <section class="postmiddle" id="poll_'.$poll['id'].'">'.substr($poll['PollQuestion']['question'], 0, 50).'</section>
                <input type="hidden" name="data[Content][content_order][][poll]" value="'.$poll['id'].'">
                <section class="postaction">
                <a href="javascript:void(0);" data-id="'.$poll['id'].'" data-type="polls" data-modalpopup="listModal" class="editContent">
                <i class="fa fa-editicon">
                <img src="/img/home/icons/edit.png" alt=""></i></a><a data-id="'.$poll['id'].'" data-type="polls" class="deleteContent">
                <i class="fa fa-trash-o red-col"></i></a>
                </section>
                </div>
                </section>';
            }
        }
    }
    
    
    if((ucwords(current($fliporderModel)) == 'Video') && isset($content['Video']) && !empty($content['Video'])){  
        foreach($content['Video'] as $video){
            if($video['id'] == current($orderModel)){
                $html .= '<section class="postthumb panel1">
                <div class="panel-heading1">
                <section class="post-cat">
                <i class="fa fa-video-camera gr-col mrgrtnone"></i> Video
                </section>
                <section class="postmiddle" id="video_'.$video['id'].'">
                <img src="'.$video['thumb'].'" alt="" style="max-width:30px; max-height:30px">
                <input type="hidden" value="153" class="image_thumb" name="">
                </section>
                <input type="hidden" name="data[Content][content_order][][video]" value="'.$video['id'].'">
                <section class="postaction">
                <a href="javascript:void(0);" data-id="'.$video['id'].'" data-type="video" class="editVideo">
                <i class="fa fa-editicon">
                <img src="/img/home/icons/edit.png" alt="">
                </i></a>
                <a href="javascript:void(0);" data-id="'.$video['id'].'" data-type="video" class="deleteContent">
                <i class="fa fa-trash-o red-col"></i>
                </a>
                </section>
                </div>
                </section>';
            }
        }
    }
    
}
echo $html; die;
?>
    