<?php
App::uses('Helper', 'View');
class frontCommonHelper extends AppHelper {
	var $components = array('RequestHandler', 'Session', 'Acl', 'Auth', 'Cookie');
	var $helpers = array('Form', 'Html', 'Session', 'Js');

	public function getServicePrice($serviceId = NULL){
		$priceOpt = array('sell'=>0,'full'=>0,'from'=>0);
		if($serviceId){
			App::import("Model", "ServicePricingOption");
			$model = new ServicePricingOption();
			$priceOption = $model->find('all',array('conditions'=>array('ServicePricingOption.salon_service_id'=>$serviceId,'ServicePricingOption.is_deleted'=>0)));
			if(!empty($priceOption)) {
				$count = count($priceOption);	
				if($count!= '' && $count === 1) {
					if($priceOption[0]['ServicePricingOption']['sell_price'] == ''){
						$priceOpt['full'] =  $priceOption[0]['ServicePricingOption']['full_price'];
					}else{
						$priceOpt['full'] = $priceOption[0]['ServicePricingOption']['full_price'];
						$priceOpt['sell'] = $priceOption[0]['ServicePricingOption']['sell_price'];
					}
				}else if($count >=1){
					$theFprive = array();
					foreach($priceOption as $theMinSellPrice){
						
						if(($theMinSellPrice['ServicePricingOption']['sell_price'] < $theMinSellPrice['ServicePricingOption']['full_price']) && !empty($theMinSellPrice['ServicePricingOption']['sell_price'])){
							$theFprive[] = $theMinSellPrice['ServicePricingOption']['sell_price'];	
						}else{
							$theFprive[] = $theMinSellPrice['ServicePricingOption']['full_price'];	
						}
						
					}
					$priceOpt['full'] = min(array_filter($theFprive));
					$priceOpt['from'] = 1;
				}
			}
		}
		return $priceOpt;
		
	}
	
	public function getDealPrice($dealId = NULL , $from_page=NULL){
		App::import("Model", "DealServicePackagePriceOption");
		$model = new DealServicePackagePriceOption();
		$dealOPtion = $model->find('all',array('conditions'=>array('DealServicePackagePriceOption.deal_id'=>$dealId),'group'=>array('DealServicePackagePriceOption.option_id')));
		$originalPrice  = array();
		$dealPrice = array();
		$duration = array();
		$dealPriceArr= array();
		$lowprice = $thePrice = $pcount = 0;
		if(!empty($dealOPtion)){
			$pcount = count($dealOPtion);
			foreach($dealOPtion as $dealPrice){
				if(isset($dealPrice['DealServicePackagePriceOption']) && !empty($dealPrice['DealServicePackagePriceOption'])){
					if(!empty($dealPrice['DealServicePackagePriceOption']['sell_price'])){
						$originalPrice[] = $dealPrice['DealServicePackagePriceOption']['sell_price'];
					}
					else{
						if(!empty($dealPrice['DealServicePackagePriceOption']['full_price'])){
						$originalPrice[]  = $dealPrice['DealServicePackagePriceOption']['full_price'];
					   }
				        }
					$dealPriceArr[] = $dealPrice['DealServicePackagePriceOption']['deal_price'];
					$duration[] = $dealPrice['DealServicePackagePriceOption']['duration'];
				}
			}
		}
		if($from_page){
			$ret['orignal_price'] = $originalPrice;
			$ret['dealPriceArr'] = $dealPriceArr;
			$ret['duration'] = $duration;
			return $ret;	
		}else{
		$priceArr = array('sale_price'=>!empty($originalPrice) ? min($originalPrice) :'','deal_price'=>!empty($dealPriceArr) ? min($dealPriceArr) : '','from'=>$pcount,'min_duration'=>!empty($duration) ? min($duration) : '' ,'max_duration'=>!empty($duration) ? max($duration) : '');
		return $priceArr;
		}
	}
	
	
	public function getDealPriceoption($dealId = NULL ){
		App::import("Model", "DealServicePackagePriceOption");
		$model = new DealServicePackagePriceOption();
		$dealOPtion = $model->find('all',array('conditions'=>array('DealServicePackagePriceOption.deal_id'=>$dealId),'group'=>array('DealServicePackagePriceOption.option_id')));
		return $dealOPtion;
	}
	
	
	function theserviceName($theService=array()){
		$DisplayName = '';
		$lang = Configure::read('Config.language'); 
		if($lang != 'eng'){
			if($theService['SalonService']['ara_name'] != '') {
				$DisplayName = $theService['SalonService']['ara_name'];
			}else{
				$DisplayName = $theService['Service']['ara_name'];	
			}
		}else{
			if($theService['SalonService']['eng_name'] != '') {
				$DisplayName = $theService['SalonService']['eng_name'];
			}else{
				$DisplayName = $theService['Service']['eng_name'];	
			}
		}
		
		return $DisplayName;
    }
    
    function thedealName($theService=array()){
		$DisplayName = '';
		$lang = Configure::read('Config.language'); 
		if($lang != 'eng'){
			if($theService['Deal']['ara_name'] != '') {
				$DisplayName = $theService['Deal']['ara_name'];
			}
		}else{
			if($theService['Deal']['eng_name'] != '') {
				$DisplayName = $theService['Deal']['eng_name'];
			}
		}
		return $DisplayName;
	}
	
	function thesalonName($user=array()){
		$DisplayName = '';
		$lang = Configure::read('Config.language'); 
		$DisplayName =  $user['Salon']['eng_name'];
		if($lang != 'eng'){
			if($user['Salon']['ara_name'] !=''){
				$DisplayName =  $user['Salon']['ara_name'];
			}
		}
		return $DisplayName;
    }
	
	function thesalonDescription($user=array()){
		$DisplayDesc = '';
		$lang = Configure::read('Config.language'); 
		if($lang != 'eng'){
			if($user['Salon']['ara_description'] !=''){
				$DisplayDesc =  $user['Salon']['ara_description'];
			}
		}else{
			if($user['Salon']['eng_description'] !=''){
				$DisplayDesc =  $user['Salon']['eng_description'];
			}
		}
		if($DisplayDesc != ''){
			if(strlen($DisplayDesc) > 180) {
					$DisplayDesc =  substr(($DisplayDesc) ,0,180).'...';
			}else{
				echo $DisplayDesc;
			}	
		}
		
		return $DisplayDesc;
    }
	
	function servicename($theService=array()){
		$DisplayName = '';
		$lang = Configure::read('Config.language'); 
		if($lang != 'eng'){
			if($theService['Service']['ara_display_name'] != '') {
				$DisplayName = $theService['Service']['ara_display_name'];
			}elseif($theService['Service']['ara_name'] != '') { 
				$DisplayName = $theService['Service']['ara_name'];
			}else{
				$DisplayName = $theService['Service']['ara_name'];	
			}
		}else{
			if($theService['Service']['eng_display_name'] != '') {
				$DisplayName = $theService['Service']['eng_display_name'];
			}elseif($theService['Service']['eng_name'] != '') {
				$DisplayName = $theService['Service']['eng_name'];
			}else{
				$DisplayName = $theService['Service']['eng_name'];	
			}
		}
		return $DisplayName;
    }
	function SalonServiceList($salonId = null, $type_id = null, $service_type = null, $service_id = array()){
		$this->autoRender = false;
		$salonServices = array();
		$salonServices_cnt = 0;
		$defaultLayout = false;
		App::import("Model", "SalonService");
		
		$salonService = new SalonService();
		$salonService->unbindModel(array(
				'hasMany' => array('SalonStaffService','ServicePricingOption','PackageService','SalonServiceResource')
		));
		//$salonService->unbindModel(array(
		//		'hasOne' => array('SalonServiceDetail')
		//));
		$salonService->bindModel(array('belongsTo'=>array('Service')));
        if(isset($salonId) && isset($type_id) && $service_type == 5 ){
			$deals = array();
			$service_ids = $this->get_service_ids($type_id);
			if(!empty($service_id)){
				$service_id = explode(',', $service_id);
				$service_ids = $service_id;
				
			}
			$salonServices = $this->get_salon_services($service_ids, $salonId);
		}
		
		elseif(isset($salonId) && isset($type_id) && $service_type == 1 ){
			$service_ids = explode('-',$type_id);
			if(!empty($service_id)){
				$service_ids = $service_id;
			}
			$salonServices = $this->get_salon_services($service_ids, $salonId);
		}elseif($salonId){
			$salonService->recursive = 2;
			$salonServices = $salonService->find('all', array('fields'=>array('SalonService.id','SalonService.eng_name','SalonService.ara_name','Service.eng_name','SalonService.ara_name','SalonServiceDetail.sold_as'),'contain' =>array('Service','SalonServiceDetail','SalonServiceImage'=>array('fields'=>array('SalonServiceImage.image'))),
				'conditions' => array('SalonService.salon_id' => $salonId,'SalonService.is_deleted' => 0,
						      'SalonService.parent_id !=' => 0, 'SalonService.status' => 1),
				'limit' => 5,
				'order' => array('SalonService.id DESC')
				)
			);
			
		}
		
		//pr($salonServices);
		
		
		$salonServices_cnt = $salonService->find('count', array(
			'conditions' => array('SalonService.salon_id' => $salonId,'SalonService.is_deleted' => 0, 'SalonService.parent_id !=' => 0, 'SalonService.status' => 1),
			)
		);
		//pr($salonServices_cnt);
		
	       return array('salonservices'=>$salonServices,'salonservicescount'=>$salonServices_cnt);
	}
	
	
	function SalonServiceCount($salonId = null, $type_id = null, $service_type = null, $service_id = array()){
		$this->autoRender = false;
		$defaultLayout = false;
		App::import("Model", "SalonService");
		$salonService = new SalonService();
		$salonService->unbindModel(array(
			'hasMany' => array('SalonStaffService','ServicePricingOption','PackageService','SalonServiceResource')
		));
		$salonService->unbindModel(array(
			'hasOne' => array('SalonServiceDetail')
		));
		$salonServices_cnt = $salonService->find('count', array(
			'conditions' => array('SalonService.salon_id' => $salonId,'SalonService.is_deleted' => 0, 'SalonService.parent_id !=' => 0, 'SalonService.status' => 1),
			)
		);
		//pr($salonServices_cnt);
		return $salonServices_cnt;
	}
	
	
    
	public function get_salon_services($service_ids = null, $salonId = null){
		App::import("Model", "SalonService");
		$salonService = new SalonService();
		$salonServices = $salonService->find('all', array(
			'fields'=>array('SalonService.id','SalonService.eng_name','SalonService.ara_name','Service.eng_name','SalonService.ara_name','SalonServiceDetail.sold_as'),'contain' =>array('Service','SalonServiceDetail','SalonServiceImage'=>array('fields'=>array('SalonServiceImage.image'))),
			'conditions' => array('SalonService.service_id' => $service_ids, 'SalonService.salon_id' => $salonId,
					      'SalonService.parent_id !=' => 0,'SalonService.is_deleted' => 0, 'SalonService.status' => 1),
			'limit' => 5,
			'order' => array('SalonService.id DESC')
			)
		);
		return $salonServices;
	}
	
	
	
	public function getmydeals($salonId = null, $type_id = null, $service_type = null, $service_id = null){
		$this->autoRender = false;
		$deals = array();
		$defaultLayout = false;
		App::import("Model", "Deal");
			$dealModel = new Deal();
		$condition = '(Deal.salon_id = '.$salonId.')
					AND ( Deal.is_deleted = 0 AND
					Deal.status = 1 AND Deal.listed_online = 1 AND Deal.listed_online_start <= DATE(NOW()) AND Deal.max_time >= DATE(NOW()) AND (Deal.quantity_type=0 OR (Deal.quantity_type=1 AND Deal.quantity > Deal.purchased_quantity))
					)';
		//echo '---'.$salonId.'-55-'.$type_id.'-66-'.$service_type;
		if(isset($salonId) && isset($type_id) && $service_type == 5 ){
			//echo '<hr>1';
				$service_ids = $this->get_service_ids($type_id);
				if(!empty($service_id)){
					$service_id	= explode(',', $service_id);
					$service_ids = $service_id;
				}
				$deals = $this->get_salon_deals($service_ids, $salonId);
				
				
		} elseif(isset($salonId) && isset($type_id) && $service_type == 1 ){
			//echo '<hr>gggg';
			$service_ids = explode('-',$type_id);
			if(!empty($service_id)){
				$service_id	= explode(',', $service_id);
				$service_ids = $service_id;
			}
			$deals = $this->get_salon_deals($service_ids, $salonId);
		} elseif(isset($salonId) && empty($type_id) && (empty($service_type) || $service_type == 'home_page')){
			//echo '<hr>fff';
			//App::import("Model", "Deal");
			//$dealModel = new Deal();
			
			$deals = $dealModel->find('all',array(
					'fields' => array('Deal.eng_name','Deal.ara_name','Deal.image','Deal.type'),
					'conditions' => $condition,
					'order' => array('Deal.id DESC'),
					'limit'=>'5'
				)	      
			);
			//pr($deals);
		} else {
			//echo 'else....'.$salonId.'------'.$type_id.'+++++'.$service_type;
		}
		$deals_count = $dealModel->find('count',array(
			'fields' => array('Deal.id'),
			'conditions' => $condition
			));
		return array('deals'=>$deals,'dealscount'=>$deals_count);
	}
    
	public function getmydeals_count($salonId = null, $type_id = null, $service_type = null, $service_id = null){
		App::import("Model", "Deal");
		$dealModel = new Deal();
		$condition = '(Deal.salon_id = '.$salonId.')
				AND (
					Deal.is_deleted = 0 AND
					Deal.status = 1 
					AND Deal.listed_online = 1 AND Deal.listed_online_start <= DATE(NOW()) AND Deal.max_time >= DATE(NOW()) AND Deal.quantity > Deal.purchased_quantity
				)';
		$deals_count = $dealModel->find('count',array(
			'fields' => array('Deal.id'),
			'conditions' => $condition
			)	      
		);
		
		return $deals_count;
	}
    
	public function get_service_ids($type_id = null){
			App::import("Model", "Service");
			$model = new Service();
			$model->unbindModel(array('hasMany' => array('ServiceImage')));
			$service_ids = array();
			$chk_service = $model->find('first', array(
				'conditions' => array('Service.id' => $type_id),
				'fields' => 'parent_id'
			));
			if(!empty($chk_service)){
				$parent = $chk_service['Service']['parent_id'];
				if($parent != 0){
					$model->unbindModel(array('hasMany' => array('ServiceImage')));
					$service = $model->find('all', array(
						'conditions' => array('Service.parent_id' => $type_id),
						'fields' => 'id'
					));
					if(!empty($service)){
						foreach($service as $s){
							$service_ids[] = $s['Service']['id']; 
						}
					}
				}	
			}
			return $service_ids;
		
	}
	
	public function get_salon_deals($service_ids = null, $salonId = null){
		App::import("Model", "SalonService");
		App::import("Model", "DealServicePackage");
		$salonService = new SalonService();
		$dealServicePackageModel = new DealServicePackage();
		
		$dealServicePackageModel->unbindModel(array(
			'hasMany' => array('DealServicePackagePriceOption')
		));
		$dealServicePackageModel->bindModel(array(
			'belongsTo' => array('Deal')
		));
		$salonServices = $salonService->find('list', array('conditions' => array('SalonService.service_id' => $service_ids, 'SalonService.salon_id' => $salonId,'SalonService.is_deleted' => 0, 'SalonService.status' => 1)));
		//pr($salonServices); exit;
		
		
		if(!empty($salonServices)){
			$salonServices_str = implode(',',$salonServices);
		}
		if(!empty($salonServices_str)) {
			$condition = '(Deal.salon_id = '.$salonId.')
				AND (DealServicePackage.salon_service_id IN ('.$salonServices_str.'))
					AND (
						Deal.is_deleted = 0 AND
						Deal.status = 1 AND Deal.listed_online = 1 AND Deal.listed_online_start <= DATE(NOW()) AND Deal.max_time >= DATE(NOW()) AND (Deal.quantity_type=0 OR (Deal.quantity_type=1 AND Deal.quantity > Deal.purchased_quantity))
					)';
		} else {
			$condition = '(Deal.salon_id = '.$salonId.')
					AND (
						Deal.is_deleted = 0 AND
						Deal.status = 1 AND
						(Deal.listed_online = 0
							OR (Deal.listed_online = 1 AND Deal.listed_online_start <= DATE(NOW()))
							OR (Deal.listed_online = 2 AND Deal.listed_online_end <= DATE(NOW()))
							OR (Deal.listed_online = 3 AND
								(Deal.listed_online_start <= DATE(NOW())
									OR Deal.listed_online_end >= DATE(NOW())
								)
							)
						)
					)';
		}
		
		$deals = $dealServicePackageModel->find('all',array(
			'fields' => array('Deal.id','Deal.eng_name','Deal.ara_name','Deal.image'),
			'conditions' => $condition,
			'group' => array('DealServicePackage.deal_id'),
			'order' => array('DealServicePackage.id DESC'),
			'limit'=>5
			)	      
		);
		return $deals;
	}
	
	
	
	
    public function getBusinessUrl($user_id = null){
	$salon_url = array();
	if(!empty($user_id)){
		
		App::import('Model','Salon');
		$this->Salon = new Salon();
		$this->Salon->unbindModel(array(
			'belongsTo' => array('User')
		));
		$salon_url = $this->Salon->find('first', array('fields'=>array('business_url'),'conditions'=>array('user_id'=>$user_id)));
	}
	
	if(!empty($salon_url['Salon']['business_url'])){
		return $salon_url['Salon']['business_url'];
	} else {
		return 0;
	}
	
    }
	public function getMetatags($user_id = 1){
		App::import('Model','MetaTag');
		$this->MetaTag = new MetaTag();
	        $metaData = $this->MetaTag->find('first',array('user_id'=>$user_id));
		return $metaData;
	}
    
}
