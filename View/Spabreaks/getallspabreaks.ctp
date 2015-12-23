<?php
$data='';
    
    if(!empty($salon_list)){
	$data .=  '<li style="list-style:none;cursor:pointer;"><span>Popular Outlets</span></li>';
	    foreach($salon_list as $li){
                $data .='<li style="list-style:none" style="cursor:pointer;" onclick="set_searchitem(\''.str_replace("'", "\'", $li['Salon']['eng_name']).'__'.'2'.'\')"><span class="toptext_search">'.ucfirst(str_ireplace($keyword,'<b>'.$keyword.'</b>',$li['Salon']['eng_name'])).'</span><div class="typo_search">&nbsp;Outlets</div></li>';
            }
    }
    if(!empty($listSpaBreaks)){
	$data .=  '<li style="list-style:none;cursor:pointer;"><span>Spabreaks</span></li>';
	    foreach($listSpaBreaks as $break){
                $data .='<li style="list-style:none" style="cursor:pointer;" onclick="set_searchitem(\''.str_replace("'", "\'", $break['Spabreak']['eng_name']).'__'.'3'.'\')"><span class="toptext_search">'.ucfirst(str_ireplace($keyword,'<b>'.$keyword.'</b>',$break['Spabreak']['eng_name'])).'</span><div class="typo_search">&nbsp;Outlets</div></li>';
            }
    }
    
    if($data == ''){
	echo $data = '<li style="list-style:none">No Records Found</li>';
    }else{
        echo $data;
    }
			   
?>

			    
			    