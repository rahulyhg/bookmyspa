<?php
if(!empty($is_spa)){
    if(!empty($list)){
        foreach($list as $li){
            echo '<li onclick="set_useritem_spa(\''.str_replace("'", "\'", $li['City']['id'].','.$li['City']['city_name']).'\')">'.$li['City']['city_name'].'</li>';
        }
    }
}else{
    if(!empty($list)){
        foreach($list as $li){
            echo '<li onclick="set_useritem(\''.str_replace("'", "\'", $li['City']['id'].','.$li['City']['city_name']).'\')">'.$li['City']['city_name'].'</li>';
        }
    }
}


if(empty($list)){
    echo '<li style="list-style:none">No Records Found</li>';    
}

?>