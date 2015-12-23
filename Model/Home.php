<?php
App::uses('AppModel', 'Model');
class Home extends AppModel {
    public $validationDomain = 'validation';
    public $name = 'Home';
    
    
  
    public function getHomeServices($getAllServices=NULL){
	$getFrontendServices = Array();
	$i = 0;
	foreach($getAllServices as $parentService){
	    if($parentService['Service']['frontend_display'] == 1){
		$getFrontendServices[$i]['Service'] = $parentService['Service'];
		if(!empty($parentService['children'])){
		    $j=0;
		    foreach($parentService['children'] as $parentCategory){
			$getFrontendServices[$i]['children'][$j]['Service'] = $parentCategory['Service'];
			//$getFrontendServices[$i]['children'][$j]['ServiceImage'] = $parentCategory['ServiceImage'];
		    $j++;
		    }     
		}
            $i++;
	    }else if(!empty($parentService['children'])){
		foreach($parentService['children'] as $parentCategorySub){
		    if($parentCategorySub['Service']['frontend_display'] == 1){
			$getFrontendServices[$i]['Service'] = $parentCategorySub['Service'];
			if(!empty($parentCategorySub['children'])){
			    $j=0;
			    foreach($parentCategorySub['children'] as $parentCategoryChild){
				$getFrontendServices[$i]['children'][$j]['Service'] = $parentCategoryChild['Service'];
				//$getFrontendServices[$i]['children'][$j]['ServiceImage'] = $parentCategoryChild['ServiceImage'];
			    $j++;
			    }     
			}
			$i++;	
		}
             }
	    }
	 }
	 return $getFrontendServices;
    }  
}
    ?>