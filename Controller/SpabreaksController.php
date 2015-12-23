<?php

class SpabreaksController extends AppController {

    public $helpers = array('Session', 'Html', 'Form','js'); //An array containing the names of helpers this controller uses. 
    public $components = array('Crypto','Session', 'Email', 'Cookie','Paginator','Image','RequestHandler','Common'); //An array containing the names of components this controller uses.
    var $uses =array('User','State','City' , 'Country','SalonService','Service','Spabreak');
    
    public function beforeFilter() { 
        parent::beforeFilter();
        $this->Auth->allow('payment','book_evoucher','index','appointment','getallspabreaks','getallbreaks','getallsaloons'); 
    }
    
    /* *********************************************************************************    
        @Function Name : index
        @Params	 : NULL
        @Description   : The Function is for spa break search
        @Author        : Sonam Mittal
        @Date          : 22-Jun-2015
    ********************************************************************************** */
    public function index($location = null,$salon_type = null,$available_date = null,$service_name = null,$spabreak_name = null,$b_type=null){
        $chklang = Configure::read('Config.language');
        	
	
	
        $criteria = array();
        $criteria[] = array('Spabreak.is_deleted' => 0 , 'Spabreak.status' => 1 ,'User.status' => 1,'User.is_deleted'=>0 , 'User.is_email_verified'=>1 , 'User.is_phone_verified'=>1,'User.front_display'=>1);
        
        if(isset($_COOKIE['State'])){
            $stateCook = $_COOKIE['State'];
            if (!$this->request->is('ajax')) {
                if(empty($location)){
                    if(!empty($stateCook)){
                        $criteria[] = array('Address.state_id' => $stateCook);
                    }
                }
            }
	}else{
	    $stateCook = 'not_set';
	}
        
        $fields2 = array('User.first_name','User.last_name','User.image','Salon.id','Salon.user_id','Salon.eng_name','Salon.ara_name','Address.address','Address.address2','Address.address','Address.latitude','Address.longitude');
        // $order = 'User.is_featured_employee DESC';
	$newSpabreak_fields = array('Spabreak.eng_name','Spabreak.ara_name','Salon.eng_name','Salon.ara_name','User.id','User.first_name','User.last_name');
        $this->Spabreak->unbindModel(array('hasMany'=>array('SpabreakOption')));
                
        $order = 'Spabreak.id ASC';
        if (!$this->request->is('ajax')) {
            $this->Session->delete('spaSearch');
        }
        
        $loc1 = '';
        $city_id= '' ;
        $state_id='';
        $disableGoogle = '';
        
	if($location == ''){
	    //$this->redirect(array('controller'=>'homes','action'=>'index'));
	}
        
        $countryData = $this->Common->getCountryStates();
        $theCity = array();
        if(!empty($countryData)){
            foreach($countryData as $country){
                if(!empty($country['State'])){
                    foreach($country['State'] as $thecty){
                        $theCity[$thecty['id']] = "<span class='ctyName' data-cntyN='".$country['Country']['title']."' data-country='".$country['Country']['id']."' >{$thecty['name']}</span>";
                    }
                }
            }
        }
        
        if (!$this->request->is('ajax')) {
            if(!empty($location)){
                $disableGoogle = 'yes';
                $split_location = explode('~',$location);
                if(!empty($split_location)){
                    if(!empty($split_location[0])){
                            $country = $split_location[0];
                            $country = str_replace('-',' ',$country);
                            //GET COUNTRY ID FROM NAME
                            $country_id = $this->get_element_id('Country',$country);
                            //$this->request->data['country_id'] = $country_id;
                    }
                    if(!empty($split_location[1])){
                            $country = $split_location[1];
                            $city = str_replace('-',' ',$country);
                            //GET COUNTRY ID FROM NAME
                            $state_id = $this->get_element_id('State',$city);
                            $this->request->data['User']['country_id'] = $state_id;                       
                            if(!empty($state_id)){
                                $criteria[] = array('Address.state_id' => $state_id);
                            }
                            
                    }
                    if(!empty($split_location[2])){
                        $city = $split_location[2];
                        $loc1 = $city = str_replace('-',' ',$city);
                        //GET CITY ID FROM NAME
                        $city_id = $this->get_element_id('City',$city);                        
                        if(!empty($city_id)){
                            $criteria[] = array('Address.city_id' => $city_id);
                        }
                    }
                }
            }



            // checking service by name 
            if(isset($service_name) && $service_name!='salon_name'){
                $serviceName = str_replace("-"," ",$service_name);
                $criteria[] = array('Salon.eng_name LIKE'=>"%".$serviceName."%");                        
                
            }

            // checking service by name 
            if(isset($spabreak_name) && $spabreak_name!='spabreak_name'){
                $spaBreakName = str_replace("-"," ",$spabreak_name);
                $criteria[] = array('Spabreak.eng_name LIKE'=>"%".$spaBreakName."%");
            }
            
            if(!empty($salon_type) && $salon_type!="serviceTo" ){
                $spa_break_type = $salon_type;
                $salon_typeArr = explode('~',$spa_break_type);
                if(!empty($salon_typeArr) && ($salon_typeArr[0] == 'spabreak')){
                    if(!empty($salon_typeArr[1])) {
                        $b_type = $salon_typeArr[1];
                        switch($b_type){
                            case 'one-night':
                                $criteria[] = array("Spabreak.no_of_nights" => 1);
                            break;
                            case 'two-night':
                                $criteria[] = array("Spabreak.no_of_nights" => 2);
                            break;
                            case 'last-minute':
                                $criteria[] = array();
                            break;
                            case '50-percent-off':
                                $criteria[] = array("Spabreak.id IN (select `SpabreakOption`.`spabreak_id` from `spabreak_options` AS `SpabreakOption` inner JOIN `spabreak_option_perdays` AS `SpabreakOptionPerday` ON (`SpabreakOption`.`id` = `SpabreakOptionPerday`.`spabreak_option_id`) where (`SpabreakOptionPerday`.`sell_price`)*2 = `SpabreakOptionPerday`.`full_price`))");
                            break;
                            default:
                                $criteria[] = array();
                            break;
                        }
                        $this->request->data['break_types'] = $salon_typeArr[1];
                    }
                }else{
                    $this->request->data['salon_type'] = $salon_type;
                    $criteria[] = array('Salon.service_to' =>$salon_type);
                }

            }
            if(!empty($b_type)){
                $this->request->data['break_types'] = $b_type;

                switch($b_type){
                    case 'one-night':
                        $criteria[] = array("Spabreak.no_of_nights" => 1);
                    break;
                    case 'two-night':
                        $criteria[] = array("Spabreak.no_of_nights" => 2);
                    break;
                    case 'last-minute':
                        $criteria[] = array();
                    break;
                    case '50-percent-off':
                        $criteria[] = array("Spabreak.id IN (select `SpabreakOption`.`spabreak_id` from `spabreak_options` AS `SpabreakOption` inner JOIN `spabreak_option_perdays` AS `SpabreakOptionPerday` ON (`SpabreakOption`.`id` = `SpabreakOptionPerday`.`spabreak_option_id`) where (`SpabreakOptionPerday`.`sell_price`)*2 = `SpabreakOptionPerday`.`full_price`))");
                    break;
                    default:
                        $criteria[] = array();
                    break;
                }
                
            }
            if(!empty($available_date)){
                $this->request->data['available_date'] = date('d-m-Y',strtotime($available_date));

                $available_date_final = strtotime($available_date);
                $criteria[] = array('Spabreak.blackout_dates NOT LIKE '=> "%".$available_date_final."%");
            }
        
        }   

       
        if($this->request->is(array('ajax'))){
            if(!empty($this->request->data)){
                $this->Session->write('spaSearch',$this->request->data);
            }

            $city =  $this->Session->read('spaSearch.loc');
            $area = $this->Session->read('spaSearch.city');
            $service_to = $this->Session->read('spaSearch.service_to');
            $break_type = $this->Session->read('spaSearch.break_type');
            $serachType = $this->Session->read('spaSearch.type_of_search');
            $availability_date = $this->Session->read('spaSearch.availability_date');
            $sold_as = $this->Session->read('spaSearch.sold_as');
            $min_price = $this->Session->read('spaSearch.min_price');
            $max_price = $this->Session->read('spaSearch.max_price');
            
            if(isset($serachType) && !empty($serachType)){
                if($serachType == 2){
                    $criteria[] = array('Salon.eng_name LIKE' => "%".$this->Session->read('spaSearch.search')."%");                        
                }if($serachType == 3){
                    $criteria[] = array('Spabreak.eng_name LIKE' => "%".$this->Session->read('spaSearch.search')."%");
                }
            }
            
            // address and country check in salon
            if($this->Session->read('spaSearch.User.country_id') && $this->Session->read('spaSearch.User.country_id')!=""){
		$criteria[] = array('Address.state_id' =>$this->Session->read('spaSearch.User.country_id'));
	    }
            if($city != ''){
		$criteria[] = array('Address.city_id '=>$city);
	    }
            
            // check for service type for saloon 
            if(isset($service_to) && !empty($service_to)){
		$criteria[] = array('Salon.service_to '=>$service_to);
	    }  
            
            // criteria for spabreak night 
            if(isset($break_type) && !empty($break_type)){
                $nights = $break_type;
                switch($break_type){
                    case 'one-night':
                        $criteria[] = array("Spabreak.no_of_nights" => 1);
                        if(!empty($availability_date)){
                            $day = date("l",strtotime($availability_date));
                            $day = strtolower($day);
                            $criteria[] = array("`Spabreak`.`id` IN (select `SpabreakOption`.`spabreak_id` from `spabreak_options` AS `SpabreakOption` inner JOIN `spabreak_option_perdays` AS `SpabreakOptionPerday` ON (`SpabreakOption`.`id` = `SpabreakOptionPerday`.`spabreak_option_id`) where `SpabreakOptionPerday`.`".$day."` = 1)");
                        }
                    break;
                    case 'two-night':
                        $criteria[] = array("Spabreak.no_of_nights" => 2);
                        /*if(!empty($availability_date)){
                            $day = date("l",strtotime($availability_date));
                            $daySecond = date("l",strtotime($availability_date . "+1 days"));
                            $day = strtolower($day);
                            $daySecond = strtolower($daySecond);
                            $criteria[] = array("`Spabreak`.`id` IN (select `SpabreakOption`.`spabreak_id` from `spabreak_options` AS `SpabreakOption` inner JOIN `spabreak_option_perdays` AS `SpabreakOptionPerday` ON (`SpabreakOption`.`id` = `SpabreakOptionPerday`.`spabreak_option_id`) where `SpabreakOptionPerday`.`".$day."` = 1 and `SpabreakOptionPerday`.`".$daySecond."` = 1)");
                        }*/
                       
                    break;
                    case 'last-minute':
                        $criteria[] = array();
                    break;
                    case '50-percent-off':
                        $criteria[] = array("`Spabreak`.`id` IN (select `SpabreakOption`.`spabreak_id` from `spabreak_options` AS `SpabreakOption` inner JOIN `spabreak_option_perdays` AS `SpabreakOptionPerday` ON (`SpabreakOption`.`id` = `SpabreakOptionPerday`.`spabreak_option_id`) where (`SpabreakOptionPerday`.`sell_price`)*2 = `SpabreakOptionPerday`.`full_price`)");
                    break;
                    default:
                        $criteria[] = array("Spabreak.no_of_nights" =>$break_type);
                    break;
                }
		
	    } 
            
            if(!empty($min_price) && !empty($min_price)){    
                $criteria[] = array("`Spabreak`.`id` IN (select `SpabreakOption`.`spabreak_id` from `spabreak_options` AS `SpabreakOption` inner JOIN `spabreak_option_perdays` AS `SpabreakOptionPerday` ON (`SpabreakOption`.`id` = `SpabreakOptionPerday`.`spabreak_option_id`) where (`SpabreakOptionPerday`.`sell_price` > ".$min_price." and `SpabreakOptionPerday`.`sell_price` < ".$max_price." ) or   (`SpabreakOptionPerday`.`full_price` > ".$min_price." and `SpabreakOptionPerday`.`full_price` < ".$max_price ."  ))");
            }
            
            // checking availability dates 
            if(isset($availability_date) && !empty($availability_date)){
                $availability_date_final = strtotime($availability_date);
                $criteria[] = array('Spabreak.blackout_dates NOT LIKE '=>"%".$availability_date_final."%");
                
                $daya = date("l",strtotime($availability_date));
                $daya = strtolower($daya);
                if(empty($break_type)){
                    
                    $criteria[] = "`Spabreak`.`id` IN (select `SpabreakOption`.`spabreak_id` from `spabreak_options` AS `SpabreakOption` inner JOIN `spabreak_option_perdays` AS `SpabreakOptionPerday` ON (`SpabreakOption`.`id` = `SpabreakOptionPerday`.`spabreak_option_id`) where `SpabreakOptionPerday`.`$daya` = 1)";
                }
                
                $dayb = date("D",strtotime($availability_date));
                $dayb = strtolower($dayb);
                $criteria[] = array("`Spabreak`.`id` IN (select `Spabreak`.`id` from `spabreaks` AS `Spabreak` inner JOIN `salon_service_details` AS `SalonServiceDetail` ON (`Spabreak`.`id` = `SalonServiceDetail`.`associated_id`) WHERE `SalonServiceDetail.offer_available_weekdays` like '%s:3:\"$dayb\";s:1:\"1\";%' || `SalonServiceDetail.offer_available_weekdays` like '%%' )");
            } 
            
            if(!empty($sold_as) && $sold_as!=4){    
                $criteria[] = array("`Spabreak`.`id` IN (select `SalonServiceDetail`.`associated_id` from `salon_service_details` AS `SalonServiceDetail` inner JOIN `spabreaks` AS `Spabreak` ON (`Spabreak`.`id` = `SalonServiceDetail`.`associated_id`) where `SalonServiceDetail`.`sold_as` = $sold_as)");
	    }
            // sorting for spabreaks
            if($this->Session->read('spaSearch.sort_by') && $this->Session->read('spaSearch.sort_by')!=""){
                if($this->Session->read('spaSearch.sort_by')=='DESC'){
                    $order = 'Spabreak.id DESC';
                } if($this->Session->read('spaSearch.sort_by')=='ASC'){
                    $order = 'Spabreak.id ASC';
                }
	    }
	}
        //pr($criteria);
        $this->Paginator->settings =  array(
            'fields'=>$newSpabreak_fields,
	    'joins'=> array(
                array(
                    'table'=>'salons',
                    'type'=>'inner',
                    'alias'=>'Salon',
                    'conditions'=>array('Spabreak.user_id = Salon.user_id')
                ),
                array(
                    'table'=>'addresses',
                    'type'=>'inner',
                    'alias'=>'Address',
                    'conditions'=>array('Spabreak.user_id = Address.user_id')
                )
            ),
            'conditions'=>array(
                "AND" => $criteria,
                "OR"=> array(
                    'Spabreak.listed_online' => 0,
                    array('Spabreak.listed_online' => 1,'Spabreak.listed_online_start <= DATE(NOW())'),
                    array('Spabreak.listed_online' => 2,'Spabreak.listed_online_end >= DATE(NOW())'),
                    array('Spabreak.listed_online' => 3,
                        'OR'=>array(
                                'Spabreak.listed_online_start >= DATE(NOW())',
                                'Spabreak.listed_online_end >= DATE(NOW())'
                            )
                        )
                )
            ),
            'limit'=>10,
            'order' =>$order,
            'group' => array('Spabreak.id')
        );
	$allSpabreaks = $this->Paginator->paginate('Spabreak');
        //pr($this->Spabreak->getLastQuery());              
        $salon_data = array('M' =>"Men's Only " , 'W' => "Woman's Only" , 'B'=>"Both",'K'=>"Kid's Only","P"=>"Pets");
	
        //pr($criteria);
        /*--------------------------- map array set on frontend start ---------------------*/
	
        $userData = $this->User->find('all',array(
            'conditions'=>$criteria,
            'joins'=>array(               
                array(
                    'table'=>'spabreaks',
                    'type'=>'inner',
                    'alias'=>'Spabreak',
                    'conditions'=>array('Spabreak.user_id = User.id')
                ),
            ),
            'fields'=>$fields2,
            'group' => array('User.id')
        ));
	//pr($userData);
	$imgPath = '';
	$locations = $information =array();
	$loc = $info ='';
	if(!empty($userData)){
            foreach($userData as $val){
                $imgPath = '';
                if(!empty($val['Address']['address']) && !empty($val['Address']['latitude']) && !empty($val['Address']['longitude'])){
                    $locations[] = '["'.$val['Address']['address'].'",'.$val['Address']['latitude'].','.$val['Address']['longitude'].']';
                    if(!empty($val['User']['image'])){
                        $imgPath = "/images/".$val['User']['id']."/User/150/".$val['User']['image'];
                    }else{
                        $imgPath = '/img/admin/treat-pic.png';
                    }
                    $salName =  $val['Salon']['eng_name'];
                    if($chklang == 'ara'){
                        if($val['Salon']['ara_name'] !=''){
                            $salName =  $val['Salon']['ara_name'];
                        }
                    }
                    $stylistName=$val['User']['first_name']." ".$val['User']['last_name'];
                    $salURL = Router::url(array('controller' => 'Place', 'action' => 'index','admin'=>false,$val['User']['id']),true);
                    $stylistAddress=$val['Address']['address'].", ".$val['Address']['address2'];
                    $information[] = '["<div class=\"info-window\"><div class=\"pull-left\"><img  src=\"'.$imgPath.'\"></div><div class=\"lft-space\"><h4><a href=\"'.$salURL.'\" target=\"_blank\" title=\"'.$stylistName.'\"> '.$stylistName.'</a></h4><p>'.$stylistAddress.'</p><p>'.$salName.'</p></div></div>"]';
                }
            }
            if(!empty($locations)){
                $loc =  implode(',',$locations);
            }if(!empty($information)){
                $info = implode(',',$information);
            }  
	}
        //pr($info);
        /*--------------------------- map array set on frontend end-------------------------*/
        
	
	//$this->request->data['location'] = ;
        $this->set(compact('disableGoogle','theCity','criteria','allSpabreaks','newSpabreak','salon_data','countryData','loc','info','stateId','city_id','loc1','country_id','state_id','stateCook'));

        if($this->request->is(array('ajax'))){
           $this->layout = 'ajax'; 
           $this->viewPath = "Elements/frontend/Spabreak";
           $this->render('featured_spabreak');
        }
        
        
    }

    
    
    /* *********************************************************************************    
        @Function Name : getallspabreaks
        @Params	 : NULL
        @Description   : The Function is to return all spa break
        @Author        : Sonam Mittal
        @Date          : 24-Jun-2015
    ********************************************************************************** */
    function getallspabreaks($keyword = null , $state = null){
        $this->layout = 'ajax';
        $this->loadModel('Salon');
        $criteria_spabreak = '';
        $criteria_salon = '';
        $listSpaBreaks = $salon_list= array();
        $data='';
        if(!empty($keyword)){            
            /********** Salon Search **********/
            $criteria_salon .= 'Address.state_id = '.$state.' and Salon.status = 1 and Salon.is_deleted = 0';
            $criteria_salon .= " AND (
                        (Salon.eng_name LIKE '%".$keyword."%')
            )";
            $salon_list = $this->Salon->find('all' , 
                array(
                    'joins' => array(
                        array(
                            'table' => 'addresses',
                            'alias' => 'Address',
                            'type' => 'inner',
                            'conditions' => array(
                                'Address.user_id= Salon.user_id'
                            )
                        )
                    ),
                    'conditions' => array($criteria_salon),
                    'fields' => array('Salon.id','Salon.eng_name','Salon.ara_name'),
                    'order' => 'Salon.eng_name DESC'
                )
            );
            /********** Salon Search **********/

            /********** Spa Break Search **********/
            $criteria_spabreak .= 'Address.state_id = '.$state.' and Spabreak.status = 1 and Spabreak.is_deleted = 0';
            $criteria_spabreak .= " AND (
                        (Spabreak.eng_name LIKE '%".$keyword."%')
            )";
            $listSpaBreaks = $this->Spabreak->find('all' , 
                array(
                    'joins' => array(
                        array(
                            'table' => 'addresses',
                            'alias' => 'Address',
                            'type' => 'inner',
                            'conditions' => array(
                                'Address.user_id= Spabreak.user_id'
                            )
                        )
                    ),
                    'conditions' => array($criteria_spabreak),
                    'fields' => array('Spabreak.id','Spabreak.eng_name','Spabreak.ara_name'),
                    'order' => 'Spabreak.eng_name DESC'
                )
            );
            /********** Spabreak Search **********/


        }
        $this->set(compact('listSpaBreaks','salon_list','keyword')); 	
    }
    
    /**********************************************************************************    
	@Function Name : get_element_id
	@Params	 : name
	@Description   : Getting Id of Element
	@Date          : 29-JUN-2015
    ***********************************************************************************/
    function get_element_id($model = null , $name = null){
	$SessionLang = $this->Session->read('Config.language');
	$getId = '';
	$this->Country->unbindModel(array('hasMany' => array('State')), true);
	if($model == 'Country'){
	    $getId = $this->$model->find('first',array('conditions'=>
                array(
                    'OR' => array(
                        $model.'.'.'name LIKE' => '%'.$name.'%',
                        $model.'.'.'ara_name LIKE' => '%'.$name.'%',
                        $model.'.'.'title LIKE' => '%'.$name.'%',
                        $model.'.'.'ara_title LIKE' => '%'.$name.'%'
                )),'fields'=>array($model.'.'.'id')));
	}elseif($model == 'State'){
	    $getId = $this->$model->find('first',array('conditions'=>
                array(
                    'OR' => array(
                        $model.'.'.'name LIKE' => '%'.$name.'%',
                        $model.'.'.'ara_name LIKE' => '%'.$name.'%',
                )),'fields'=>array($model.'.'.'id')));
	}elseif($model == 'City'){
	    $getId = $this->City->find('first',array('conditions'=>array('city_name LIKE' => '%'.$name),'fields'=>array('id')));
	}elseif($model == 'BusinessType'){
	    if($SessionLang == 'eng'){
		$getId = $this->BusinessType->find('first',array('conditions'=>array('eng_name LIKE' => '%'.$name),'fields'=>array('id')));
	    }else{
		$getId = $this->BusinessType->find('first',array('conditions'=>array('ara_name LIKE' => '%'.$name),'fields'=>array('id')));
	    }
	}
	if(!empty($getId)){
	    $getId = $getId[$model]['id'];
	}
	return $getId;
    }
    
    /* *********************************************************************************    
        @Function Name : getallbreaks
        @Params	 : NULL
        @Description   : The Function is to return all spa break
        @Author        : Sonam Mittal
        @Date          : 1-July-2015
    ********************************************************************************** */
    function getallbreaks($keyword = null , $state = null){
        $this->layout = 'ajax';
        $this->loadModel('Salon');
        $criteria_spabreak = '';
        $listSpaBreaks = array();
        $data='';
        if(!empty($keyword)){ 
            /********** Spa Break Search **********/
            $criteria_spabreak .= 'Address.state_id = '.$state.' and Spabreak.status = 1 and Spabreak.is_deleted = 0';
            $criteria_spabreak .= " AND (
                        (Spabreak.eng_name LIKE '%".$keyword."%')
            )";
            $listSpaBreaks = $this->Spabreak->find('all' , 
                array(
                    'joins' => array(
                        array(
                            'table' => 'addresses',
                            'alias' => 'Address',
                            'type' => 'inner',
                            'conditions' => array(
                                'Address.user_id= Spabreak.user_id'
                            )
                        )
                    ),
                    'conditions' => array($criteria_spabreak),
                    'fields' => array('Spabreak.id','Spabreak.eng_name','Spabreak.ara_name'),
                    'order' => 'Spabreak.eng_name DESC'
                )
            );
            /********** Spabreak Search **********/


        }
        $this->set(compact('listSpaBreaks','keyword')); 	
    }
    
    /* *********************************************************************************    
        @Function Name : getallSaloons
        @Params	 : NULL
        @Description   : The Function is to return all spa break
        @Author        : Sonam Mittal
        @Date          : 24-Jun-2015
    ********************************************************************************** */
    function getallsaloons($keyword = null , $state = null){
        $this->layout = 'ajax';
        $this->loadModel('Salon');
        $criteria_salon = '';
        $salon_list= array();
        $data='';
        if(!empty($keyword)){            
            /********** Salon Search **********/
            $criteria_salon .= 'Address.state_id = '.$state.' and Salon.status = 1 and Salon.is_deleted = 0';
            $criteria_salon .= " AND (
                        (Salon.eng_name LIKE '%".$keyword."%')
            )";
            $salon_list = $this->Salon->find('all' , 
                array(
                    'joins' => array(
                        array(
                            'table' => 'addresses',
                            'alias' => 'Address',
                            'type' => 'inner',
                            'conditions' => array(
                                'Address.user_id= Salon.user_id'
                            )
                        )
                    ),
                    'conditions' => array($criteria_salon),
                    'fields' => array('Salon.id','Salon.eng_name','Salon.ara_name'),
                    'order' => 'Salon.eng_name DESC'
                )
            );
            /********** Salon Search **********/
        }
        $this->set(compact('salon_list','keyword')); 	
    }
    
    /* *********************************************************************************    
        @Function Name : appointment
        @Params	 : NULL
        @Description   : The Function is for spabreak booking
        @Author        : Sonam Mittal
        @Date          : 10-Jul-2015
    ********************************************************************************** */
    function appointment(){
        $spabreakOptions = array();
	$this->Session->delete('point_detail'); 
        $this->Session->delete('gift_detail');
        
        if($this->Session->read('appointmentData')){
            $appointmentData = $this->Session->read('appointmentData');
        }
        if($this->request->is('post') || $this->request->is('put')){
	    if(!empty($this->request->data) && isset($this->request->data['Appointment']) ){
		$appointmentData = $this->request->data;
		$this->Session->write('appointmentData',$appointmentData);
	    }
        }
        if(empty($appointmentData)){
            $this->redirect(array('controller'=>'Homes','action'=>'index'));
        }
        else{
            //pr($appointmentData);
            $id  = $this->Auth->user('id');
            if(!$id){
                $this->redirect(array('controller'=>'Homes','action'=>'index'));
            }
            $this->loadModel('Spabreak');
            $this->loadModel('PointSetting');
            $this->loadModel('TaxCheckout');
            $this->loadModel('User');
            $this->loadModel('PolicyDetail');
            $this->loadModel('UserCount');
            $this->loadModel('SpabreakOption');
            $this->SalonService->unbindModel(array('hasOne'=>array('SalonServiceDetail'),'hasMany'=>array('SalonServiceImage','SalonStaffService','PackageService')));
            //pr($appointmentData);
            $serviceId = $appointmentData['Appointment']['service_id'];
            $serviceDetails = $this->Spabreak->find('first',array('conditions'=>array('Spabreak.id'=>$serviceId)));
            //pr($serviceDetails);
            
            // get pricing option in case of spabreak appointment
            if($appointmentData['Appointment']['theBuktype']== 'appointment'){
                $spabreakDay = $appointmentData['Appointment']['breakDay'];
                $spabreakRoom = $appointmentData['Appointment']['room_id'];
                if(!empty($spabreakRoom) && !empty($spabreakDay)){
                    $spabreakOptions = $this->SpabreakOption->find('all',array(
                        'conditions'=>array(
                            'SpabreakOption.salon_room_id'=> $spabreakRoom,
                            'SpabreakOption.spabreak_id'=> $serviceId,
                            'SpabreakOptionPerday.'.$spabreakDay=> 1
                        ),
                        'joins' => array(
                            array(
                                'table' => 'spabreak_option_perdays',
                                'alias' => 'SpabreakOptionPerday',
                                'type' => 'inner',
                                'conditions' => array(
                                    'SpabreakOption.id= SpabreakOptionPerday.spabreak_option_id',
                                )
                            )
                        ),
                    ));
                } 
                //pr($spabreakOptions);
            }else{
                $optionID = $appointmentData['Appointment']['price_id'];
                $spabreakRoom = $appointmentData['Appointment']['room_id'];
                if(!empty($optionID)){
                    $spabreakOptions = $this->SpabreakOption->find('all',array(
                        'conditions'=>array(
                            'SpabreakOption.salon_room_id'=> $spabreakRoom,
                            'SpabreakOption.spabreak_id'=> $serviceId,
                            'SpabreakOptionPerday.id'=>$optionID,
                        ),
                        'joins' => array(
                            array(
                                'table' => 'spabreak_option_perdays',
                                'alias' => 'SpabreakOptionPerday',
                                'type' => 'inner',
                                'conditions' => array(
                                    'SpabreakOption.id= SpabreakOptionPerday.spabreak_option_id',
                                )
                            )
                        ),
                    ));
                } 
            }
            //pr($spabreakOptions);
            $serviceOwner = $this->User->findById($serviceDetails['Spabreak']['user_id']);
            $salon_id = $serviceDetails['Spabreak']['user_id'];
            /*************************************check for the frenchise user ************************************/
             if($serviceOwner['User']['parent_id'] !=0){
                $frechiseDetail = $this->User->findById($serviceOwner['User']['parent_id']);
                    if(count($frechiseDetail)){
                         if($frechiseDetail['User']['type']==2){
                           $salon_id =  $frechiseDetail['User']['id'];
                          } 
                     }
            }
            $totalPoints = $this->UserCount->find('all' , array('conditions'=>array('user_id'=>$this->Auth->user('id'),'salon_id'=>array($salon_id,1)),'fields'=>array('(sum(UserCount.user_count)) AS total')));                           
            $totalPoints = isset($totalPoints[0][0]['total'])?$totalPoints[0][0]['total']:0; 
            $pointsVal = $this->PointSetting->find('first' , array('conditions'=>array('user_id'=>1)));
            $taxes = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>$salon_id)));
            if(count($taxes)==0){
             $taxes = $this->TaxCheckout->find('first' , array('conditions'=>array('user_id'=>1)));  
            }
            //pr($taxes);
            $ownerPolicy = $this->PolicyDetail->find('first',array('conditions'=>array('PolicyDetail.user_id'=>$serviceDetails['Spabreak']['user_id'])));
            if(count($ownerPolicy) == 0){
              $ownerPolicy = $this->PolicyDetail->find('first' ,array('conditions'=>array('user_id'=>1)));   
            }
           
            $this->set(compact('spabreakOptions','serviceDetails','serviceOwner','ownerPolicy','userDetail','totalPoints','pointsVal','salon_id','taxes'));
        }
            $this->set('theData',$appointmentData);
    }
    
    
    
    
    /* *********************************************************************************    
        @Function Name : payment
        @Params	 : NULL
        @Description   : The Function is for spabreak payment
        @Author        : Sonam Mittal
        @Date          : 13-Jul-2015
    ********************************************************************************** */
   public function payment($package_id=NULL,$user_id=NULL ,$type=NULL){
                //pr($this->request->data);die;
		if(!$this->Session->read('appointmentData')){
		    $this->Session->setFlash('Unauthorized Access.', 'flash_success');
		    $this->redirect(array('controller'=>'homes','action'=>'index'));
		}
                $userDetail = $this->Session->read('Auth');
                $this->loadModel('GiftCertificate');
                $this->loadModel('OrderDetail');
                // pr($this->Session->read());
                $order_status_val = '';	
                $order_status="";
                $tracking_id = '';
                $amount = '';
                $gift_id ='';
                $point_given = '';
                $status_message ='';
                $point_used_status = false;
                $gift_used_status = false;
                $orignal_amount = 0;
                $point_used = 0;
		$gift_amount_used =0;
                $appointment_detail = $this->Session->read('appointmentData.Appointment');
                //pr($appointment_detail);
                if($package_id && $user_id){
                     if($type=='gift'){
                                $gift_detail  = $this->Session->read('gift_detail');
                                if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
                                    $this->GiftCertificate->recursive = -1;
                                    $giftDetail = $this->GiftCertificate->find('first' ,array('conditions'=>array('GiftCertificate.id'=>$gift_detail['point']['use_gift_id']),'fields'=>array('amount')));
                                    $gift_amount = $giftDetail['GiftCertificate']['amount'];
                                    $package_amount = $this->request->data['Points']['amnt'];
                                        //echo $package_amount; die;
                                        //if($appointment_detail['theBuktype']=='eVoucher'){
                                        //   //$package_amount  =   $package_amount*$appointment_detail['quantity'];
                                        //}
                                        $amount_left = $gift_amount - $package_amount;
                                        if($amount_left > 0){
                                            $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                            $this->GiftCertificate->saveField('amount',$amount_left);
                                         }else{
                                            $this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
                                            $this->GiftCertificate->saveField('is_used',1);
                                        }
				    $gift_amount_used = $package_amount;
                                    $amount = 0;
                                    $order_status = 'gift';
                                    $gift_id = $gift_detail['point']['use_gift_id'];
                                    $status_message = 'purchase by gift card';
                                 } 
                            }else if($type=='points'){
                                    // pr($this->request->data);
                                    $amount = $this->request->data['Appointment']['amount'];
                                    $total_points = $this->request->data['Points']['total_points'];
                                    $redeem_points =$this->Common->get_points_from_price($amount);
                                     $point_left = $total_points - $redeem_points;
                                    $point_used = $redeem_points;
                                    $amount = 0;
                                    $order_status = 'points';
                                    $status_message = 'purchase by points';
                            }else if($type=='payment'){
                                   $amount = $this->request->data['Appointment']['amount'];
                                   $status_message = 'before payment'; 
                                   $order_status = 'payment';
                            }else{

				$workingKey=Configure::read('working_key'); 	//Working Key should be provided here.
				$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
				$rcvdString=$this->Crypto->decrypt($encResponse,$workingKey);	//Crypto Decryption used as per the specified working key.			
				$order_status_val = '';	
				$order_status="";
				$tracking_id = '';
				$amount = '';
				$decryptValues=explode('&', $rcvdString);
				$dataSize=sizeof($decryptValues);
				for($i = 0; $i < $dataSize; $i++) 
				{
				    $information=explode('=',$decryptValues[$i]);
				    if($i==0)	{ $order_id = $information[1]; }
				    if($i==3)	{ $order_status=$information[1]; }
				    if($i==1)	{ $tracking_id=$information[1]; }
				    if($i==10)	{ $amount=$information[1]; }
				    if($i==8)	{ $status_message=$information[1]; }
				}
				//$order_status  ='Success';
				$gift_detail =  $this->Session->read('gift_detail');
				$point_detail  = $this->Session->read('point_detail');
				if(isset($gift_detail['point']['is_used_gift']) && $gift_detail['point']['is_used_gift']=='1'){
					$gift_amount_used = $this->Common->get_gift_amount($gift_detail['point']['use_gift_id']);
					$this->GiftCertificate->id = $gift_detail['point']['use_gift_id']; 
					$this->GiftCertificate->saveField('is_used',1);
					$gift_id = $gift_detail['point']['use_gift_id'];
					$gift_used_status = true;
				}
				if(isset($point_detail['point']['is_used_point']) && $point_detail['point']['is_used_point']=='1'){
				    $used_points = $point_detail['point']['used_point'];
				    $point_left = 0;
				    $point_used = $used_points;
				    $point_used_status = true;
				}
			}
                    if($order_status)
                    {
    /*******************************Appointment Details***********************************************************/
                        $appointment_status = ($order_status==="Success")?4:5;
                        if($order_status==="Success")
                        {
                         $appointment_status  =4;
                         $order_status_val = 1;   
                        }else if($order_status==="Aborted")
                        {
                            $order_status_val = 2;
                            $appointment_status  =5;
                        }
                        else if($order_status==="Failure")
                        {
                           $order_status_val = 3;
                           $appointment_status  =5;
                        }
                        else if($order_status==="points")
                        {
                          $order_status_val = 5;
                          $appointment_status  =4;
                        }else if($order_status==="gift")
                        {
                          $order_status_val = 6;
                          $appointment_status  =4;
                        }else if($order_status==="payment")
                        {
                          $order_status_val = 9;
                          $appointment_status  =5;
                        }else{
                          $order_status_val = 5;       
                        }
                    $this->loadModel('Spabreak');
                    $this->loadModel('SalonService'); $this->loadModel('UserCount'); $this->loadModel('UserPoint');
                    $this->loadModel('Appointment');$this->loadModel('Order');
                    $this->loadModel('User'); $this->loadModel('PolicyDetail');
                    $appointment_detail = $this->Session->read('appointmentData.Appointment');
                    $this->Spabreak->recursive = 2;
                    $serviceDetails = $this->Spabreak->findById($package_id);
                    $packageOwner = $this->User->findById($serviceDetails['Spabreak']['user_id']);
                    
                    $i  = 0;
                    //pr($serviceIds);
                    
                    //$serviceId = $service_id;
                    
                    //pr($appointment_detail);
                    //die('hererer'); 
                    if($order_status==="Success" || $order_status==="points" || $order_status==="gift" || $order_status==="payment")
                    {
                    /***********************Tax and commisons **************************/
                    //  die('in progress');
                       if($appointment_detail['theBuktype'] == 'eVoucher'){
                             $pack_price = $appointment_detail['price']*$appointment_detail['selected_quantity'];
                            }else{
                             $pack_price = $appointment_detail['price'];
                        }
                        $salon_id = $serviceDetails['Spabreak']['user_id'];
                        $tax_data  = $this->Common->get_vendor_dues($pack_price,$salon_id,$packageOwner['User']['discount_percentage'],$appointment_detail['price']);
                        //pr($tax_data);  die;
                       $vocuher_expire = $this->Common->vocher_expiry($salon_id,$serviceDetails['SalonServiceDetail']['evoucher_expire'],$serviceDetails['SalonServiceDetail']['evoucher_expire_after']);

                       
                    /********************* Save the orders details***************************************/     
                     //pr($this->request->data);//die();
		      if($order_status == 'payment' || $order_status == 'gift' || $order_status==="points"){
			    $order['Order']['first_name'] = $this->request->data['Appointment']['first_name'];     
			    $order['Order']['last_name'] = $this->request->data['Appointment']['last_name'];
			    $phone_code =  str_replace('+','',$this->request->data['Appointment']['country_code']);
			    $order['Order']['phone_number'] = $phone_code.$this->request->data['Appointment']['billing_tel'];    
			    unset($this->request->data['Appointment']['country_code']); 
		      }
                    //pr($order);
                      
                       
                    $order['Order']['transaction_id'] = $tracking_id;     
                     $order['Order']['appointment_id'] = '';
                     $order['Order']['user_id'] = $user_id;
                     $order['Order']['employee_id'] =$appointment_detail['selected_employee_id'];
                     $order['Order']['salon_id'] =$serviceDetails['Spabreak']['user_id'];
                     $order['Order']['salon_service_id'] =$package_id;
                    if($appointment_detail['theBuktype'] == 'eVoucher'){
                       $order['Order']['service_type'] = 7;
                       $order['Order']['sold_as'] = 2;
                       $order['Order']['duration'] = date('Y-m-d h:m:s').'~'.$vocuher_expire;
                       $appointment_detail['breakDateSelected'] = date('Y-m-d h:m:s');
		       $order['Order']['start_date'] = date('Y-m-d');
		       $order['Order']['order_avail_status'] = 1;
                    }else{
                        $order['Order']['service_type'] = 4;
                        $order['Order']['sold_as'] = 1;
                        $order['Order']['duration'] = date('Y-m-d h:m:s',strtotime($appointment_detail['breakDateSelected'])).'~'.date('Y-m-d h:m:s',strtotime($appointment_detail['breakDateEnd']));
                    }
                     $order['Order']['price_option_id'] = $appointment_detail['price_id'];
                     if($point_used_status || $gift_used_status){
                       $order['Order']['transaction_status'] = ($point_used_status)?8:7; 
                     }else{
                       $order['Order']['transaction_status'] = $order_status_val; 
                     }
                     $order['Order']['start_date'] = date('Y-m-d h:m:s',strtotime($appointment_detail['breakDateSelected']));
                     $order['Order']['amount'] = $amount;
		     $order['Order']['gift_amount'] = $gift_amount_used;
                     $order['Order']['points_used'] = $point_used;
                     $order['Order']['transaction_message'] = $status_message;
                     $order['Order']['eng_service_name'] = $serviceDetails['Spabreak']['eng_name'];
                     $order['Order']['ara_service_name'] = $serviceDetails['Spabreak']['ara_name'];
                     $order['Order']['used_gift_id'] = $gift_id;
                     $order['Order']['service_price_with_tax'] = $tax_data['service_price_with_tax'];
                     $order['Order']['deduction1'] =$tax_data['tax_admin']['TaxCheckout']['deduction1'];
                     $order['Order']['deduction2'] = $tax_data['tax_admin']['TaxCheckout']['deduction2'];
                     $order['Order']['sieasta_commision'] = $tax_data['sieasta_comission_price'];
                     $order['Order']['total_deductions'] = $tax_data['total_deductions'];
                     $order['Order']['vendor_dues'] = $tax_data['vendors_dues'];
                     $order['Order']['tax1'] = $tax_data['tax_vendor']['TaxCheckout']['tax1'];
                     $order['Order']['tax2'] = $tax_data['tax_vendor']['TaxCheckout']['tax2'];
                     $order['Order']['salon_id'] = $serviceDetails['Spabreak']['user_id'];
                     $order['Order']['tax_amount'] = $tax_data['tax_amount'];
                     $order['Order']['sieasta_commision_amount'] = $tax_data['sieasta_comission'];
                     $order['Order']['saloon_discount'] = $packageOwner['User']['discount_percentage'];
                     $order['Order']['is_admin_tax'] = $tax_data['is_admin_tax'];
                     $order['Order']['tax1_amount'] = $tax_data['tax1_amount'];
                     $order['Order']['check_in'] = $serviceDetails['Spabreak']['check_in'];
                     $order['Order']['check_out'] = $serviceDetails['Spabreak']['check_out'];  
                     
                    $display_order_id = $this->Common->getRandPass(10);
                    $order['Order']['display_order_id'] = $display_order_id;
                    
                    // pr($serviceDetails);
                    if(isset($serviceDetails['SpabreakOption']) && !empty($serviceDetails['SpabreakOption'])){
                        foreach($serviceDetails['SpabreakOption'] as $spaBreakOptions){
                            foreach($spaBreakOptions['SpabreakOptionPerday'] as $thePriceOpt){ 
                                if($thePriceOpt['id'] == $appointment_detail['price_id']){
                                        $order['Order']['sell_price'] = $thePriceOpt['sell_price'];
                                        $order['Order']['full_price'] = $thePriceOpt['full_price'];
                                        $orignal_amount =  ($thePriceOpt['sell_price'])? $thePriceOpt['sell_price'] :$thePriceOpt['full_price'];
                                        break;
                                }
                            }
                        }
                    }
                     //pr($order);
                     
                     $order['Order']['orignal_amount'] = $orignal_amount;
                     //die();
                     $fields = array('User.first_name','User.last_name','UserDetail.booking_incharge','UserDetail.email_reminder','User.email','Address.*','Contact.*');
                     if($order_status==="Success" || $order_status==="Aborted" || $order_status==="Aborted"){
                      $this->Order->id = $order_id;  
                     }
		if($this->Common->add_customer_to_salon($user_id,$serviceDetails['Spabreak']['user_id'])){
                     if($this->Order->save($order , false)){
                        $order_id = $this->Order->id;
             /**************************************Redeeem points*************************************************/
                        if(isset($point_used) && !empty($point_used)){
                              $user_count['UserPoint']['points_deducted'] = $point_used;
                              $user_count['UserPoint']['salon_id'] = $serviceDetails['Spabreak']['user_id']; 
                              $user_count['UserPoint']['user_id'] = $user_id;                                  
                              $user_count['UserPoint']['order_id'] = $order_id;
                              $user_count['UserPoint']['type'] = 1; 
                              $this->UserPoint->create();
                              $this->UserPoint->save($user_count , false);
			      $user_point_id = $this->UserPoint->id;
                             /*********************** total redeem points **************/
                                $salon_id =  $serviceDetails['Spabreak']['user_id']; 
                                $points  = array();
                                $points['user_id'] = $user_id;
                                $points['salon_id'] = $salon_id;
                                $points['used_points'] = $point_used;
				$points['user_point_id'] = $user_point_id;
                                $points['order_id'] = $order_id;
                                $this->redeem_points($points);
                             }
                         /****************************************************************/    

                    if($order_status !='payment'){            

                    
                   }         
                    /*********************gift card points given *******************************/
                            if($order_status==="gift" && isset($amount_left) && $amount_left > 0){
                                    $this->loadModel('GiftDetail');
                                    $giftDetail['amount_used'] = $package_amount;
                                    $giftDetail['order_id'] = $order_id;
                                    $giftDetail['gift_id'] = $gift_id;
                                    $this->GiftDetail->save($giftDetail , false);
                            }   
                                    //pr($AppointementsIds); die;
                                    $i = 0;
                            if($order_status !='Success'){
                                    //pr($serviceDetails);
                                    if(!empty($serviceDetails)){  
                                        $option_duration = '';
                                        //pr($appointment_detail);
                                        
                                        $serviceId = $serviceDetails['Spabreak']['id'];
                                        $fields= array('SalonService.ara_name','SalonService.eng_name','SalonService.id','SalonService.salon_id');
                                        $order_detail['OrderDetail']['service_id'] = $serviceId;
                                        $order_detail['OrderDetail']['order_id']= $order_id;
					
					
                                        $pricingoptions = $appointment_detail['price_id'];
					//pr($serviceDetails);  
                                            foreach($serviceDetails['SpabreakOption'] as $spaOption){
                                                foreach($spaOption['SpabreakOptionPerday']as $priceOpt){
                                                    if($priceOpt['id'] == $pricingoptions){
                                                        //$duration = $priceOpt['duration'];
                                                        $price = $appointment_detail['price'];
                                                        $price_opt_id = $priceOpt['id'];
                                                        $orignal_amount =  ($priceOpt['sell_price'])? $priceOpt['sell_price'] :$priceOpt['full_price'];
                                                        $package_service_id = $priceOpt['id'];
                                                        //$option_duration = $priceOpt['option_duration'];
                                                        //$option_price = $priceOpt['option_price'];
                                                    }
                                                }
                                            }
                                            $order_detail['OrderDetail']['price'] = $price;
                                            $order_detail['OrderDetail']['user_id']=$user_id;
                                            $order_detail['OrderDetail']['appointment_price']=$price;
                                            $order_detail['OrderDetail']['employee_id'] = trim($appointment_detail['employee_id']);
                                            
                                            if($appointment_detail['theBuktype'] == 'eVoucher'){
                    
                                                $order_detail['OrderDetail']['duration'] = $serviceDetails['SalonServiceDetail']['evoucher_expire_after'];
                                                $vocuher_expire = $this->Common->vocher_expiry($salon_id,$serviceDetails['SalonServiceDetail']['evoucher_expire'],$serviceDetails['SalonServiceDetail']['evoucher_expire_after']);
                                                $option_duration = date('Y-m-d h:m:s').'~'.$vocuher_expire;
                                                $appointment_detail['breakDateSelected'] = date('Y-m-d h:m:s');
                                            }else{
                                                $option_duration = date('Y-m-d h:m:s',strtotime($appointment_detail['breakDateSelected'])).'~'.date('Y-m-d h:m:s',strtotime($appointment_detail['breakDateEnd']));
                                            }
                                             
                                            $order_detail['OrderDetail']['appointment_created']=date('Y-m-d h:m:s');
                                            $order_detail['OrderDetail']['appointment_repeat_type'] = 0;
                                            $order_detail['OrderDetail']['start_date'] = date('Y-m-d h:m:s',strtotime($appointment_detail['breakDateSelected']));

                                            $order_detail['OrderDetail']['salon_id'] = $serviceDetails['Spabreak']['user_id'];
                                            $order_detail['OrderDetail']['price_option_id'] = $price_opt_id;
                                            $order_detail['OrderDetail']['eng_service_name']  = $serviceDetails['Spabreak']['eng_name'];
                                            $order_detail['OrderDetail']['ara_service_name'] = $serviceDetails['Spabreak']['ara_name'];
                                            $order_detail['OrderDetail']['package_service_id'] = $package_service_id;
                                            $order_detail['OrderDetail']['option_duration'] = $option_duration;
                                            $order_detail['OrderDetail']['option_price'] = $price;
					   // die();
                                            $this->OrderDetail->create();
                                            $this->OrderDetail->save($order_detail,false);
                                            $i++;
                                            //$salon_id = $serviceDetail['SalonService']['salon_id'];$number =  $getData['Contact']['cell_phone'];
                                             if($appointment_detail['theBuktype'] != 'eVoucher'){
                                                $ServiceUser = $this->User->find('first', array('conditions'=>array('User.id'=>trim($serviceDetails['Spabreak']['user_id']),'User.status'=>1)));
                                                //pr($ServiceUser); die;
                                                if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
                                                      if($ServiceUser['UserDetail']['email_reminder']==1){
                                                          $time = trim($appointment_detail['service'][$serviceId]['time']);
                                                          $date = $appointment_detail['breakDateSelected'];
                                                          $orderDat = $this->Common->get_Order($order_id); 
                                                          $display_order_id = @$orderDat ['Order']['display_order_id'];
				   
                                                          $message = "You have new  appointment for the Service  $service_name  on date : $date $time . Your Order id is $display_order_id";
                                                          $this->sendUserEmail($ServiceUser, $serviceDetail,$order_id ,$amount ,'new_appointment',$duration,'vendor');
                                                          $this->sendUserPhone($ServiceUser, $serviceDetail, $message,$order_id ,$amount ,'vendor',$duration);
                                                      }
                                                 }
                                            }

                                }
                             if($appointment_detail['theBuktype'] == 'eVoucher'){
                                          $recipient_name = $this->request->data['Appointment']['recipient_name'];
                                          $recipient_message = $this->request->data['Appointment']['recipient_message'];
                                            $this->loadModel('Evoucher');
                                            $quantity = $appointment_detail['selected_quantity'];
											$vocher_code = $this->Common->getRandPass(8);
                                            for($i =1; $i<=$quantity; $i++){
                                                $evoucher['Evoucher']['order_id'] = $order_id;
                                                $evoucher['Evoucher']['salon_id'] = $salon_id;
                                                $evoucher['Evoucher']['user_id'] = $user_id;
                                                $evoucher['Evoucher']['price'] = $tax_data['service_price_tax'];
                                                $evoucher['Evoucher']['evoucher_type'] = 5;
                                                $evoucher['Evoucher']['vocher_code'] = $vocher_code;
                                                $evoucher['Evoucher']['reciepent_name'] = $recipient_name;
                                                $evoucher['Evoucher']['expiry_date'] = $vocuher_expire;
                                                $evoucher['Evoucher']['reciepent_message'] = $recipient_message;
                                                $this->Evoucher->create();
                                                $this->Evoucher->save($evoucher);
                                            } 
                             }  
                            }

                            ob_start();
                            //$thetype = $appointment_detail['thetype'];
                            $package_name = $serviceDetails['Spabreak']['eng_name'];
                            $date = $appointment_detail['breakDateSelected'];
                            if($order_status==="Success" || $order_status==="points" || $order_status==="gift"){
                               $package_salon_id = $serviceDetails['Spabreak']['user_id'];
                               $SalonBookingIncharges = $this->User->find('all' , array('conditions'=>array('User.status'=>1,'User.type'=>array(4,5),'or'=>array('User.created_by'=>$package_salon_id,'User.id'=>$package_salon_id))));
                                    
                                    $orderDat = $this->Common->get_Order($order_id); 
                                    $display_order_id = @$orderDat ['Order']['display_order_id'];
				   
                                    foreach($SalonBookingIncharges as $incharge){
                                           if($incharge['UserDetail']['booking_incharge']==1){
                                           if($appointment_detail['theBuktype'] == 'eVoucher'){
                                               $message = " A new    $package_name Evocuher  has been sold.Your Order id is $display_order_id";
                                                $this->sendUserPackageEmail($incharge, $serviceDetails,$serviceDetails ,$order_id ,$amount ,'evocuher_package_sold','vendor');
                                                $this->sendUserPhone($incharge, $serviceDetails,$message ,$order_id ,$amount ,'vendor');
                                            }else{
                                            $message = "You have new online  appointment for the $thetype  $package_name  on date : $date . Your Order id is $display_order_id";
                                            $this->sendUserPackageEmail($incharge, $serviceDetails,$serviceDetails ,$order_id ,$amount ,'new_package','vendor');
                                            $this->sendUserPhone($incharge, $serviceDetails,$message ,$order_id ,$amount ,'vendor');
                                            }
                                    }
                                    }
                            }

                            // $this->Session->setFlash('your appointment is booked successfully.', 'flash_success');
                           // $this->redirect(array('controller'=>'homes','action'=>'index'));
                           if($order_status !='payment'){
                            $userDetail = $this->User->find('first', array('conditions'=>array('User.id'=>$this->Auth->user('id'))));

                            if($order_status==="Success" || $order_status==="gift" || $order_status==="points")
                            {
                                $orderDat = $this->Common->get_Order($order_id); 
                                $display_order_id = @$orderDat ['Order']['display_order_id'];
                               if($appointment_detail['theBuktype'] == 'eVoucher'){
                                    $message = "You have purchased  evoucher for the  $thetype  $package_name successfully.Your Order id is $display_order_id";
                                    $this->sendUserPackageEmail($userDetail, $serviceDetails, $serviceDetails , $order_id  ,$amount ,'confirmation_spaday');
                                    $this->sendUserPhone($userDetail, $serviceDetails,$message ,$order_id ,$amount);
                                }else{
                                    $message = "$thetype  $package_name  on date : $date has been successfully booked.Your Order id is $display_order_id";
                                    $this->sendUserPackageEmail($userDetail, $serviceDetails, $serviceDetails , $order_id  ,$amount ,'confirmation_package');
                                    $this->sendUserPhone($userDetail, $serviceDetails,$message ,$order_id ,$amount);
                                }
				$this->Session->delete('appointmentData');
                                $this->Session->setFlash("Your Order is booked successfully.", 'flash_success');
                                $this->redirect(array('controller'=>'homes','action'=>'index'));  
                            }else{
                                $this->Session->setFlash('Your  transaction has been declined.Please try again.', 'flash_error');
                                $this->redirect(array('controller'=>'homes','action'=>'index')); 
                            }
                           }else{
                             if($this->request->is('post') || $this->request->is('put')){
                                    //echo '<pre>';  print_r($this->request->data);  die('herere');
                                      $this->request->data['Appointment']['order_id'] = $order_id;
                                      $working_key=Configure::read('working_key');  //Shared by CCAVENUES
                                      $access_code =Configure::read('access_code');  //Shared by CCAVENUES
                                      $merchant_data =  '';
                                      foreach ($this->request->data['Appointment'] as $key => $value){
                                       $merchant_data.=$key.'='.$value.'&'; 
                                      }
                                      //echo $merchant_data; 
                                      $encrypted_data = $this->Crypto->encrypt($merchant_data,$working_key);
                                      //echo $encrypted_data;
                                      $this->set(compact('encrypted_data','access_code'));
                                      $this->render('../Bookings/payment');
                                      
                                   }
                           }  


			    }else{
					$this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
					$this->redirect(array('controller'=>'homes','action'=>'index'));  
				  }
			}else{
					$this->Session->setFlash('Some error occured.Please try again.', 'flash_error');
					$this->redirect(array('controller'=>'homes','action'=>'index'));
			}
                    }else
                    {
                        $this->Session->setFlash('Your  transaction has been declined due to Illegal access detected.', 'flash_error');
                        $this->redirect(array('controller'=>'homes','action'=>'index'));
                    }
                }else{
                        $this->Session->setFlash('Your  transaction has been declined due to Illegal access detected.', 'flash_error');
                        $this->redirect(array('controller'=>'homes','action'=>'index'));
                    }
         } 
               
    }
    
    
    function sendUserPackageEmail($userData=array() , $serviceDetails = array(),$package =array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;
        $appointment_detail = $this->Session->read('appointmentData.Appointment');
        //$thetype = $appointment_detail['thetype'];
        //$service_name = $serviceDetail['SalonService']['eng_name'];
        $service_name = array();
        //pr($serviceDetails);
	//pr($appointment_detail);
           $serviceID = $serviceDetails['Spabreak']['id'];
           $service_names[] =  $serviceDetails['Spabreak']['eng_name'];
           $date[]  =   $appointment_detail['breakDateSelected'];       
           //$time[] = trim($appointment_detail['service'][$serviceID]['time']);
           $duration[] = '';
	   

        $i = 0; 
        $serviceData  = '';
        // die;
    if($appointment_detail['theBuktype'] == 'eVoucher'){
	//echo "sonu1"
	$appointment_detail['breakDateSelected'] = date('d/m/yy');
	$vocuher_expire = $this->Common->vocher_expiry($serviceDetails['Spabreak']['user_id'],$serviceDetails['SalonServiceDetail']['evoucher_expire'],$serviceDetails['SalonServiceDetail']['evoucher_expire_after']);
	$quanityAmount = $appointment_detail['selected_quantity'];
	
	foreach($service_names as $service_name){
	   $serviceData  .= 'Service Name :' . $service_names[$i].'</br> Date :'.date('d/m/y').' </br> Expiry Date of eVoucher :'.$vocuher_expire.'</br>';
	   $i++;
        }
    }else{
	$quanityAmount = 1;
        $serviceData  .= 'Service Name :' .$serviceDetails['Spabreak']['eng_name'].'</br> Date :'.$date[$i].' </br>  Duration :'.$appointment_detail['breakDateSelected'].'-'.$appointment_detail['breakDateSelected'].'</br></br>';
    }  
        
        //echo $serviceData;
        
        $dynamicVariables = array(
                                  '{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{amount}' => $amount,
                                  '{package_name}'=> $package['Spabreak']['eng_name'],
                                  '{order_id}'=>$order_id,
                                  '{service}'=> $serviceData,
                                  '{package_date}'=>$appointment_detail['breakDateSelected'],
                                  '{package}'=>'Spabreak',
				  '{quantity}'=>$quanityAmount
				  
                                  );
        if($type=='gift'){
         $dynamicVariables['{gift_amount}'] = $points;   
        }else if($type=='points'){
          $dynamicVariables['{point}'] = $points;      
        }else if($type=='vendor'){
         $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($points);   
        }
	//die();
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
    
     function sendUserEmail($userData=array() , $serviceDetail = array(), $order_id=null ,$amount = null , $template='',$points=NULL, $type=NULL){
        $SITE_URL = Configure::read('BASE_URL');
        $toEmail = $userData['User']['email'];
        $fromEmail = Configure::read('noreplyEmail');
        $firstName = $userData['User']['first_name'];
        $lastName = $userData['User']['last_name'];
        $order_id = $order_id;
        $service_name = $serviceDetail['Spabreak']['eng_name'];
        $appointment_detail = $this->Session->read('appointmentData.Appointment');
	
        
	
	if($appointment_detail['theBuktype'] == 'eVoucher'){
	    $date = date('d/m/yy');
	}else{
	    $date = $appointment_detail['breakDateSelected'];
	}
	
        $serviceId = $serviceDetail['Spabreak']['id'];
        //$time = trim($appointment_detail['service'][$serviceId]['time']);
        $dynamicVariables = array('{FirstName}' => $firstName,
                                  '{LastName}' => $lastName,
                                  '{amount}' => $amount,
                                  //'{time}'=> $time,
                                  '{start_date}'=>$date,
                                  '{service_name}'=>$service_name,
                                  '{order_id}'=>$order_id,
                                  );
        if($type=='gift'){
         $dynamicVariables['{gift_amount}'] = $points;   
        }else if($type=='points'){
          $dynamicVariables['{point}'] = $points;      
        }else if($type=='vendor'){
         $dynamicVariables['{duration}'] = $this->Common->get_mint_hour($points);   
        }
        $this->Common->sendEmail($toEmail, $fromEmail,$template,$dynamicVariables);
        return true; 
    }
    
    function sendUserPhone($getData=array(), $serviceDetail = array(), $message = '', $order_id=null ,$amount = null , $type=null , $duration=null){
            $this->loadModel('User');
            $firstName = $getData['User']['first_name'];
            $lastName = $getData['User']['last_name'];
            $appointment_detail = $this->Session->read('appointmentData.Appointment');
            $date = $appointment_detail['breakDateSelected'];
             $order_id = $order_id;
            if($getData){
                    $number =  $getData['Contact']['cell_phone'];
                    $country_id = $getData['Address']['country_id'];
                    if($country_id){
                     $country_code  =   $this->Common->getPhoneCode($country_id);
                        if($country_code){
                           $number = str_replace("+","",$country_code).$number;    
                        }else{
                            $country_code = '+971';
                          $number = str_replace("+","",$country_code).$number;    
                        }
                    }
                    $this->Common->sendVerificationCode($message,$number);
            }
        return true;
    }
  function redeem_points($points=array()){
           $this->autoRender = false;
           $this->LoadModel('UserCount');
                //$points['user_id'] = 2;
               //$points['salon_id'] = 20;
              //$points['used_points'] = 1000; 
            $vendorCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>$points['salon_id'])));
                if(count($vendorCounts)>0){
                        $user_points = $vendorCounts['UserCount']['user_count'];
                        if($user_points > $points['used_points']){
                            $points_left = $user_points-$points['used_points'];
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,$points_left);
                            
                            $points['salon_point'] = $points['used_points'];
                            $points['sieasta_point'] = 0;
                            $this->Common->update_user_point($points);
                            return true;
                        }else if($user_points == $points['used_points']){
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,0);
                            
                            $points['salon_point'] = $points['used_points'];
                            $points['sieasta_point'] = 0;
                            $this->Common->update_user_point($points);
                            return true;   
                        }else if($user_points < $points['used_points']){
                            $points_left = $points['used_points']-$user_points;
                            $this->UserCount->id = $vendorCounts['UserCount']['id'];
                            $this->UserCount->saveField('user_count' ,0);
                            $adminCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>1)));
                                if(count($adminCounts)>0){
                                  $adminPoints = $adminCounts['UserCount']['user_count'];
                                  $admin_left = $adminPoints-$points_left;
                                  $this->UserCount->id = $adminCounts['UserCount']['id'];
                                  $this->UserCount->saveField('user_count' ,$admin_left);
                                }
                                $points['salon_point'] = $user_points;
                                $points['sieasta_point'] = $points_left;
                                $this->Common->update_user_point($points);    
                                return true;
                      }
                }else{
                    $adminCounts = $this->UserCount->find('first' ,array('conditions'=>array('user_id'=>$points['user_id'] ,'salon_id'=>1)));
                    if(count($adminCounts)>0){
                          $adminPoints = $adminCounts['UserCount']['user_count'];
                          $admin_left = $adminPoints-$points['used_points'];
                          $this->UserCount->id = $adminCounts['UserCount']['id'];
                          $this->UserCount->saveField('user_count' ,$admin_left);
                          $points['salon_point'] = 0;
                          $points['sieasta_point'] = $points['used_points'];
                          $this->Common->update_user_point($points); 
                        }
                      return true;
                    }   
           }
}
