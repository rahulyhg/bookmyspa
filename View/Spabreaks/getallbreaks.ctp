<?php
    $data='';
    if(!empty($listSpaBreaks)){
	$data .=  '<li style="list-style:none;cursor:pointer;"><span>Spabreaks</span></li>';
	    foreach($listSpaBreaks as $break){
                $data .='<li style="list-style:none" style="cursor:pointer;" onclick="set_searchitem_break(\''.str_replace("'", "\'", $break['Spabreak']['eng_name']).'__'.'3'.'\')"><span class="toptext_search">'.ucfirst(str_ireplace($keyword,'<b>'.$keyword.'</b>',$break['Spabreak']['eng_name'])).'</span><div class="typo_search">&nbsp;Outlets</div></li>';
            }
    }
    
    if($data == ''){
	echo $data = '<li style="list-style:none">No Records Found</li>';
    }else{
        echo $data;
    }
			   
?>

			    
			    