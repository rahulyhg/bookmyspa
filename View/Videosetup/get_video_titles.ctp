<?php
//pr($list);die;
if(!empty($list)){
    foreach($list as $li){
        if(isset($li['VideoSetup']['eng_title'])){
            echo '<li onclick="set_useritem(\''.str_replace("'", "\'", $li['VideoSetup']['id'].','.$li['VideoSetup']['eng_title']).'\')">'.$li['VideoSetup']['eng_title'].'</li>';
        }else{
            echo '<li onclick="set_useritem(\''.str_replace("'", "\'", $li['VideoSetup']['id'].','.$li['VideoSetup']['ara_title']).'\')">'.$li['VideoSetup']['ara_title'].'</li>';
        }
    }
}
if(empty($list)){
    echo '<li style="list-style:none">No Records Found</li>';    
}

?>