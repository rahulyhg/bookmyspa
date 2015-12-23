			    <?php
                               $cdnimg =  Configure::read('CDNIMG');
				$cdnimages =  Configure::read('CDNIMAGES');
				echo  $this->Paginator->options(array(
				    'update' => '#update_ajax',
				    'evalScripts' => true
				));
			    ?>
			    
			    <?php $lang =  Configure::read('Config.language');
			    //pr($service_category_id); //exit;
			    ?>
			    <script type="text/javascript">
				    $(document).ready(function(){
					    $('.deals_data').on('click',function() {
						    var service_type = $("#searchType").val();
						    var type_id = $("#typeId").val();
						    var service_id = $("#serviceId").val();
						    var user_id = $(this).attr('user-id');
						    var search_type = $(this).attr('data-value');
						    var cont_val = $('#'+user_id+search_type+'_cnt').val();
						    url = "<?php echo $this->webroot ?>Search/getAjaxContent";
						    $.ajax({
							    type : "POST",
							    url : url,
							    data: {service_type : service_type, type_id : type_id, user_id: user_id,search_type: search_type, service_id: service_id,cont_val:cont_val},
							    success: function(data) {
								 $('#menu_'+user_id).html(data).fadeIn('slow');
							    }
						    });
					    });
				     });
			    </script>
			    <div style="display: none" class="modal theAllMapModal fade bs-example-modal-sm" id="mapSalon" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog">
					    <div class="modal-content" >
						    <div class="modal-header">
							    <button data-dismiss="modal" class="close" type="button"><span>x</span><span class="sr-only">Close</span></button>
							    <h4 id="myModalLabel" class="modal-title">MAP</h4>
						    </div>
						    <div class="modal-body clearfix" style="height: 500px;width: 100%;">
							    <div  id="mapAllSalon" style="height: 100%;"></div>
						    </div>
					    </div>
				</div>
			    </div>
			    <div class="v-middle-side dealMiddlePanel">
				<!------------Display Salons------------------------->
				<?php $recordExits = false;
				    
				if(isset($getData) && !empty($getData)){
				   $recordExits = true;            
				}
				if($recordExits) { 
				    if(isset($search_type) && !empty($search_type)){ ?>
					<input id="searchType" type="hidden" name="searchType" value="<?php echo $search_type; ?>">
				    <?php }
				    if(isset($type_id) && !empty($type_id)){ ?>
					<input id="typeId" type="hidden" name="typeId" value="<?php echo $type_id; ?>">
				    <?php }
				    foreach($getData as $key => $user) { ?>
					<div class="mBS-<?php echo $user['User']['id']; ?> mainBookSection booking-section mrgn-btm15 clearfix ">
					    <!--bod-btm-non-->
					    <div class="booking-sec-left">
						<div class="books-sec-img">
 
						    <?php 
						    if($user['Salon']['cover_image'] != '') {
							//echo WWW_ROOT.'images/'.$user['User']['id'].'/Salon/1600/'.$user['Salon']['cover_image'];
							if (file_exists(WWW_ROOT.'images/'.$user['User']['id'].'/Salon/350/'.$user['Salon']['cover_image'])) {
							    if(!empty($user['Salon']['business_url'])){ 
								//echo $this->Html->link($this->Html->image('/images/'.$user['User']['id'].'/Salon/350/'.$user['Salon']['cover_image']),array('controller'=>'Place','action'=>'index',$user['User']['id']),array('escape'=>false));
?>
                                                     <a href="Place/index/<?php echo $user['User']['id']; ?>"><img src ="<?php echo $cdnimages.'/'.$user['User']['id'].'/Salon/1600/'.$user['Salon']['cover_image'] ?>"></a>
							  <?php
  } else {
								echo $this->Html->image('/images/'.$user['User']['id'].'/Salon/150/'.$user['Salon']['cover_image']);
							    }
							} else {
							    if(!empty($user['Salon']['business_url'])){
								echo $this->Html->link($this->Html->image('frontend/search-page-img.jpg'),array('controller'=>'Place','action'=>'index',$user['User']['id']),array('escape'=>false));
							    } else {
								echo $this->Html->image('frontend/search-page-img.jpg');
							    }
							    ?>
							    <!--img src="/img/frontend/search-page-img.jpg" alt="" title=""-->
							<?php }
						    }else{
							if(!empty($user['Salon']['business_url'])){
							   //echo  $this->Html->image('frontend/search-page-img.jpg',array('url'=>array($user['Salon']['business_url']));
							    echo $this->Html->link($this->Html->image('frontend/search-page-img.jpg'),array('controller'=>'Place','action'=>'index',$user['User']['id']),array('escape'=>false));
							} else {
							    echo $this->Html->image('frontend/search-page-img.jpg');
							}
						    } ?>
						</div>
						<div class="booking-cap" style="min-height:97px">
						    <?php
							$salon_name =  $user['Salon']['eng_name'];
							if($lang != 'eng'){
								if($user['Salon']['ara_name'] !=''){
									$salon_name =  $user['Salon']['ara_name'];
								}
							}
							//$salon_name = $this->frontCommon->thesalonName($user);
							
						    ?>
						    <label>
							<?php echo $this->Html->link('<b>'.$salon_name.'</b>','/'.$user['Salon']['business_url'],array('escape'=>false)); ?>
						    </label>
						    <span><i class="fa fa-map-marker"></i>
							<?php
							$city = $user['City']['city_name'];
							//$city = $this->Common->getCity($user['Address']['city_id']);
							if(!empty($city))
							    echo $city.', ';
							    $state = $user['State']['name'];
							    //$state = $this->Common->getState($user['Address']['state_id']);
							if(!empty($state))
							    echo $state; ?>
						    </span>
						</div>
					    </div>
					    <div class="booking-sec-right">
						<div class="booking-details clearfix">
						    <div class="booking-description">
							<?php
							$salon_description = '';
							if($lang != 'eng'){
								if($user['Salon']['ara_description'] !=''){
									$salon_description =  $user['Salon']['ara_description'];
								}
							}else{
								if($user['Salon']['eng_description'] !=''){
									$salon_description =  $user['Salon']['eng_description'];
								}
							}
							if($salon_description != ''){
								if(strlen($salon_description) > 180) {
										echo $salon_description =  substr(($salon_description) ,0,180).'...';
								}else{
									 echo $salon_description;
								}	
							}
							
							//return $DisplayDesc;
							//echo $salon_description = $this->frontCommon->thesalonDescription($user); ?>
						    </div>
						    <div class="booking-nav">
							<ul data-id="<?php echo $user['User']['id']; ?>" class="clearfix">
							    <?php $salon_rating=$this->common->get_rating_by_salon($user['User']['id']); 
							    if(round($salon_rating[0][0]['avgRating'])!=''){ ?>
								<li>
								    <a href="#" class="clearfix">
									<?php for($m=1;$m<=5;$m++){
									    if($m>round($salon_rating[0][0]['avgRating'])){ ?>
										<?php if($m==3){ ?>
										<span class="rating-star"><i class="fa fa-star-o full-w"></i></span>
										<?php 	}else{ ?>
										    <span class="rating-star"><i class="fa fa-star-o"></i></span>
										<?php } ?>
									    <?php } else{ ?>
									    
									    <?php if($m==3){ ?>
									    
										<span class="rating-star full-w"><i class="fa fa-star"></i></span>
										<?php } else{ ?>
										<span class="rating-star"><i class="fa fa-star"></i></span>
									    <?php }}   ?>
									<?php } ?>
								    </a>
								</li>
							    <?php } else{ ?>
								<li>
								    <a href="#" class="clearfix">
									<?php for($m=1;$m<=5;$m++){ ?>
									<?php if($m==3){ ?>
									    <span class="rating-star full-w"><i class="fa fa-star-o full-w"></i></span>
									  <?php  } else{?>
									    <span class="rating-star"><i class="fa fa-star-o"></i></span>
									<?php }} ?>
								    </a>
								</li>
							    <?php } ?>
							    <!--<li>
								<a href="#" class="clearfix">
								<span class="rating-star"><i class="fa fa-star"></i></span>
								<span class="rating-star"><i class="fa fa-star"></i></span>
								<span class="rating-star full-w"><i class="fa fa-star"></i></span>
								<span class="rating-star"><i class="fa fa-star"></i></span>
								<span class="rating-star"><i class="fa fa-star"></i></span>
								</a>
							    </li>-->
							    <?php 
							    if(isset($user['User']['id']) && !empty($user['User']['id'])){ ?>
								<input id="userId" type="hidden" name="userId" value="<?php echo $user['User']['id']; ?>">
							    <?php }
							    $srvcid = ''; 
							    if(isset($service_id) && !empty($service_id)){
								    $srvcid = $service_id;
							    }?>
							    <input id="serviceId" type="hidden" name="serviceId" value="<?php echo $srvcid; ?>">
							    <?php 
							    //if(isset($service_category_id) && !empty($service_category_id)){ ?>
							    <?php //} ?>
							    <li class=" bod-rgt-non">
								<?php echo $this->Js->link(
								    '<i id="'.$user['User']['id'].'" class="fa fa-info-circle toggleAll info"></i>',
								    array('controller'=>'search','action'=>'getAjaxContent', $user['User']['id'],'info'),
								    array(
									    'success'=>$this->Js->get("#menu_".$user['User']['id'])->effect('fadeIn'),
									    'class'=>"pdng-tp-11",'update'=>'#menu_'.$user['User']['id'],
									    'escape'=>false
								    )
								); ?>
							    </li>
							    <li class=" bod-btm-non">
								<?php echo $this->Js->link('<i id="'.$user['User']['id'].'" class="fa fa-map-marker toggleAll map"></i>',array('controller'=>'search','action'=>'getAjaxContent',$user['User']['id'],'map'),array('success'=>$this->Js->get("#menu_".$user['User']['id'])->effect('fadeIn'),'class'=>"pdng-tp-11",'update'=>'#menu_'.$user['User']['id'],'escape'=>false));?>
							    </li>
							    <li class=" bod-btm-non bod-rgt-non">
								<!--<a href="javascript:void(0);" class="pdng-tp-11"><i id="<?php echo $user['User']['id']; ?>" class="fa fa-camera toggleAll gallery gallery_<?php echo $user['User']['id']; ?>"></i></a>-->
								<?php echo $this->Js->link('<i id="'.$user['User']['id'].'" class="fa fa-camera toggleAll gallery"></i>',array('controller'=>'search','action'=>'getAjaxContent',$user['User']['id'],'gallery'),array('success'=>$this->Js->get("#menu_".$user['User']['id'])->effect('fadeIn'),'class'=>"pdng-tp-11",'update'=>'#menu_'.$user['User']['id'],'escape'=>false));?>	
							    </li>
							</ul>
						    </div>
						</div>
						<div class="tab-outer">
						    <ul class="tab-lines" data-id="<?php echo $user['User']['id']; ?>">
							<li>
							    <?php #Code to find the count of menu and lowest price
							    $servicePrice = array();
							    $from = '';
							    $lowestPrice = array();
							    if(!isset($type_id)){
								$type_id = null;
							    }
							    if(!isset($search_type)){
								$search_type = null;
							    }
							    if(!isset($service_id)){
								$service_id = null;
							    }
							    $servicesAll = $this->frontCommon->SalonServiceList($user['User']['id'], $type_id, $search_type, $service_id);
							    $services = $servicesAll['salonservices'];
							    $services_cnt = $servicesAll['salonservicescount'];
							//    if(count($services) > 0){
							//	  $services_cnt = $this->frontCommon->SalonServiceCount($user['User']['id'], $type_id, $search_type, $service_id);
							//	 // $services_cnt = count($services);
							//    } else {
							//	$services_cnt = 0;
							//    }
							   //exit;
							    if(!empty($services)){
								$i = 1;
								$lowestPrice = array('NULL');
								foreach($services as $service){
								    if(!empty($service)){
									$servicePrice = $this->frontCommon->getServicePrice($service['SalonService']['id']);
									$lowestPrice[] = $servicePrice['full'];
									$i++;
								    }
								}	
							    }
							    $price='';
							    if(isset($lowestPrice) && !empty($lowestPrice)){
								$price = 'AED '.min($lowestPrice);
							    }
							    $check = $services_cnt;
							    //$check = count($services);
							    //$check =  $this->requestAction(array('controller' =>'search', 'action' => 'getCountMenuServices',$user['User']['id']));
							    //$lowestPrice =  $this->frontCommon->SalonServiceList();
							    if($check > 0) {
								$countMenu =  'See all '.$check.' offers';
								if(!empty($price))
								    $from = ' from';
								else {
								    $from = '';
								}
							    }else{
								$countMenu =  __('No offers available');
								$from = '';
							    }
							    echo $this->Form->hidden('menu_cnt.'.$user['User']['id'],array('id'=>$user['User']['id'].'menu_cnt','div'=>false,'label'=>false,'value'=>$check));
							    echo $this->Html->link(
								    '<label>'.__('menu').'</label>
								    <section id="'.$user['User']['id'].'" class="all-offers menueffect">'.$countMenu.
								    '<i  class="fa fa-angle-down"></i></section> <section class="rate">'.$from.
								    ' <span id="rate_'.$user['User']['id'].'">'.$price.
								    '</span></section>',
								    array('#'),
								    array('onclick' => 'return false;','class'=>"toggleAll deals_data deals clearfix",'escape'=>false,'data-value' => "menu",'user-id' => $user['User']['id'])
								    ); ?>
							</li>
							<li>
							    <?php	//echo 'HERE';
							    $dealsAll = $this->frontCommon->getmydeals($user['User']['id'], $type_id, $search_type,$service_id);
							    $deals = $dealsAll['deals'];
							    $dealPrice = array();
							    $from_text_deal = '';
							     //echo 'VIEW';
							    //pr($deals);
							    if(!empty($deals)){
								$i = 1;
								$lowestPrice = array('NULL');
								foreach($deals as $deal){
								    if(!empty($deal)){
									$dealPrice = $this->frontCommon->getDealPrice($deal['Deal']['id']);
									//pr($dealPrice); exit;
									$dealPrice = $dealPrice['deal_price'];
									$i++;
								    }
								}
								//pr($dealPrice); exit;
							    }
							     $check_deals = count($deals);
							    //pr($check_deals);
							    if($check_deals > 0){
								  $check_deals = $dealsAll['dealscount'];
								 //$check_deals = $this->frontCommon->getmydeals_count($user['User']['id'], $type_id, $search_type, $service_id);
							    }
							    //pr($check_deals);
							    //$check_deals =  $this->requestAction(array('controller' => 'search', 'action' => 'getCountDeals',$user['User']['id']));
							    if($check_deals > 0) { 
								$countDeals =  " See all " . $check_deals . " deals <i class='fa fa-angle-down'></i> ";
							    }else {
								$countDeals =  __('No deals available');
							    }
							    if(!empty($dealPrice)){
								$from_text_deal = $from.'<span id="rate_'.$user['User']['id'].'"> AED '.$dealPrice.'</span>';
							    } else {
								$from_text_deal = '';
							    }
							    echo $this->Form->hidden('deal_cnt.'.$user['User']['id'],array('id'=>$user['User']['id'].'deal_cnt','div'=>false,'label'=>false,'value'=>$check_deals));
							    echo $this->Html->link(
							    '<label>DEALS <i class="fa fa-clock-o"></i></label>
							    <section id="'.$user['User']['id'].'" class="all-offers dealeffect">'.$countDeals.
							    '</section> <section class="rate">'.$from_text_deal.'
							    </section>',array('#'),array('onclick' => 'return false;','class'=>"toggleAll deals_data deals clearfix",'escape'=>false,'data-value' => "deal",'user-id' => $user['User']['id']));
							    ?>
							</li>
							<li>
							    <?php $type = 'package';
							    $from_text = '';
							    $lowestPrice = array();
							    $packagePrice = array();
							    $packagesAll = $this->requestAction(array('controller' => 'search', 'action' => 'getSalonPackages',$user['User']['id'], $type, $type_id, $search_type, $service_id));
							    $packages = $packagesAll['packages'];
							    $count = count($packages);	
							    if($count > 0){
								$count = $packagesAll['packagescount'];
								//$count = $this->requestAction(array('controller' => 'search', 'action' => 'getSalonPackages_count',$user['User']['id'], $type, $type_id, $search_type, $service_id));
							    }
							    if(!empty($packages)){
								$i = 1;
								$lowestPrice = array('NULL');
								foreach($packages as $package){
								    if(!empty($package)){
									$packagePrice = $this->Common->getLowestSalonPackage($package['Package']['user_id']);
									$lowestPrice[]= $packagePrice['lowestprice'];
									$i++;
								    }
								}	
							    }
							    if($count > 0) {
								//$count =  $countPackages['packagecount'];
								$PackagesCount =  " See  ". $count ." packages <i class='fa fa-angle-down'></i> ";
								$from = 'from';
							    }else {
								$PackagesCount =  __('No Package available');
								$from = '';
								$from_text = '';
							    }
							    if(!empty($packagePrice['lowestprice'])){
								$from_text = $from.'<span id="rate_'.$user['User']['id'].'"> AED '.min($lowestPrice).'</span>';
							    } else {
								$from_text = '';
							    }
							    //echo "ddd";
							    //pr($from_text);
							    //exit;
							    echo $this->Form->hidden('package_cnt.'.$user['User']['id'],array('id'=>$user['User']['id'].'package_cnt','div'=>false,'label'=>false,'value'=>$count));
							    echo $this->Html->link('<label>PACKAGES</label><section id="'.$user['User']['id'].'" class="all-offers ">'.$PackagesCount.'</section>
							    <section class="rate">'.$from_text.'</section>',array('#'),array('onclick' => 'return false;','class'=>"toggleAll deals_data deals clearfix",'escape'=>false,'data-value' => "package",'user-id' => $user['User']['id']));?>
							</li>
							<li>
							    <?php $type = 'spaday';
							    $spadayPrice = array();
							    $from_text = '';
							    $lowestPrice = array();
							    $spadaysAll = $this->requestAction(array('controller' => 'search', 'action' => 'getSalonPackages',$user['User']['id'], $type, $type_id, $search_type,$service_id));
							    $spadays = $spadaysAll['packages'];
							    $count = count($spadays);	
							    if($count > 0){
								$count = $spadaysAll['packagescount'];
								//$count = $this->requestAction(array('controller' => 'search', 'action' => 'getSalonPackages_count',$user['User']['id'], $type, $type_id, $search_type,$service_id));
							    }
							    if(!empty($spadays)){
								$i = 1;
								$lowestPrice = array('NULL');
								foreach($spadays as $spaday){
								    if(!empty($spaday)){
									$spadayPrice = $this->Common->getLowestSalonSpadays($spaday['Package']['user_id']);
									//pr($spadayPrice); exit;
									$lowestPrice = $spadayPrice['lowestprice'];
									//pr($lowestPrice); exit;
									$i++;
								    }
								}
							    }
							    if(!empty($spadayPrice['lowestprice'])){
								$from_text =__('AED').' '.$spadayPrice['lowestprice'];
							    } else {
								$from_text = '';
							    }
							    if($count > 0) {
								$SpadayCount =  __('See').' '.$count.' '.__('Spadays')." <i class='fa 	fa-angle-down'></i>";
								$from = 'from';
							    } else {
								$SpadayCount =  __('No_spaday_available');
								$from = '';
							    } 
							    echo $this->Form->hidden('spaday_cnt.'.$user['User']['id'],array('id'=>$user['User']['id'].'spaday_cnt','div'=>false,'label'=>false,'value'=>$count));
							    echo $this->Html->link('<label>'.__('Spaday').'</label><section id="'.$user['User']['id'].'" class="all-offers ">'.$SpadayCount.'</section> <section class="rate">'.$from.'<span id="rate_'.$user['User']['id'].'"> '.$from_text.'</span></section>',array('#'),array('onclick' => 'return false;','class'=>"toggleAll deals_data deals clearfix",'escape'=>false,'data-value' => "spaday",'user-id' => $user['User']['id']));?>
							</li>
						    </ul>
						</div>
					    </div>
					</div>
					<div rel="info" style="display:none" id="info_<?php echo $user['User']['id'] ; ?>" style="display: none;" class="booking-section clearfix infodiv allInfo_<?php echo $user['User']['id'] ; ?>">
					<!------- Section For Info -------------->
					</div>
					<!------- Section For Info -------------->
					<!----------- Google Map -------------------------->
					<div rel="map" style="display:none"  id="mapData_<?php echo $user['User']['id'] ; ?>" class="booking-section clearfix map-view  allInfo_<?php echo $user['User']['id'] ; ?>">
					</div>
					<!----------- Google Map -------------------------->
					<!--------- Gallery Area -------------------------->
					<div rel="gallery" id="gallery_<?php echo $user['User']['id'] ; ?>" style="display:none;" class="booking-section   gallery-user allInfo_<?php echo $user['User']['id'] ; ?> ">
					</div>
					<!--------- Gallery Area -------------------------->
					<!---------------- Menu Area ---------------------->
					<div rel="menu" style="display:none" id="menu_<?php echo $user['User']['id'] ; ?>" class="booking-section clearfix infodiv allInfo_<?php echo $user['User']['id'];?> ">
					</div>
					<!----------------- Deals Area --------------------->
					<?php //$deals = $this->frontCommon->getmydeals($user['User']['id']); ?>
					<div rel="deals" style="display:none" id="deals_<?php echo $user['User']['id'] ; ?>" class="booking-section clearfix infodiv allInfo_<?php echo $user['User']['id'];?> ">
					</div>
					<!----------------- Deals Area --------------------->
				    <?php }
				} else{ ?>
				    <div class="v-middle-side">
					<div class="no-result-found-box">
					    <h4><i class="fa fa- fa-exclamation-triangle"></i> No result found
						<span>your keyword/filter does not match any result</span>
					    </h4>
					    <h5>Suggestion:</h5>
					    <ul>
						<li>Please try another filter or another keywords to get appropriate results</li>
						<li>Please make sure all words are spelled correctly</li>
					    </ul>
					</div>
				    </div>
				<?php } ?>
				<!------------ Display Salons ------------------------->
				<nav class="pagi-nation">
				<?php if($this->Paginator->param('pageCount') > 1){
				    $this->Paginator->options(array('url' => $this->passedArgs));
					echo $this->element('pagination-frontend');
				} ?>
				</nav>
			    </div>
			    <!--- Jquery Starts ------------------>
