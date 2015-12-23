<?php
$data='';
    if(!empty($categories)){
	$data =  '<li style="list-style:none;cursor:pointer;"><span>Popular Categories</span></li>';
	    foreach($categories as $li){
                $data .='<li style="list-style:none;cursor:pointer;" onclick="set_searchitemcat(\''.str_replace("'", "\'", $li['Service']['eng_name'].'_'.$li['Service']['id']).'__'.'5'.'\')"><span class="toptext_search">'.ucfirst(str_ireplace($keyword,'<b>'.$keyword.'</b>',$li['Service']['eng_name'])).'</span><div class="typo_search">&nbsp;Categories</div></li>';
	    }
	}
    if(!empty($salon_list)){
	$data .=  '<li style="list-style:none;cursor:pointer;"><span>Popular Outlets</span></li>';
	    foreach($salon_list as $li){
                $data .='<li style="list-style:none" style="cursor:pointer;" onclick="set_searchitemNew(\''.str_replace("'", "\'", $li['Salon']['eng_name']).'__'.'2'.'\')"><span class="toptext_search">'.ucfirst(str_ireplace($keyword,'<b>'.$keyword.'</b>',$li['Salon']['eng_name'])).'</span><div class="typo_search">&nbsp;Outlets</div></li>';
            }
    }if(!empty($list)){
	$data .=  '<li style="list-style:none;cursor:pointer;"><span>Popular Locations</span></li>';
	    foreach($list as $li){
                $data .='<li style="list-style:none;cursor:pointer;" onclick="set_searchitemlocation(\''.str_replace("'", "\'", $li['City']['city_name'].'_'.$li['City']['id']).'__'.'4'.'\')"><span class="toptext_search">'.ucfirst(str_ireplace($keyword,'<b>'.$keyword.'</b>',$li['City']['city_name'])).'</span><div class="typo_search">&nbsp;Locations</div></li>';
	    }
    }
    if(!empty($service_list)){
	$data .=  '<li style="list-style:none;cursor:pointer;"><span>Popular Services</span></li>';
	    foreach($service_list as $li){
                $data .='<li style="list-style:none;cursor:pointer;" onclick="set_searchitem(\''.str_replace("'", "\'", $li['Service']['eng_name']).'_'.$li['Service']['id'].'-'.$li['Service']['parent_id'].'\')"><span class="toptext_search">'.ucfirst(str_ireplace($keyword,'<b>'.$keyword.'</b>',$li['Service']['eng_name'])).'</span><div class="typo_search">&nbsp;Services</div></li>';
	    }
    }
    if($data == ''){
	echo $data = '<li style="list-style:none">No Records Found</li>';
    }else{
        echo $data;
    }
			   
?>

			    
			    