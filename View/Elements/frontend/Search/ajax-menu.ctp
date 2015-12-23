<?php
if(!empty($user_id)){
	if(!isset($ser_cat_type)){
        $ser_cat_type  = null;
    }
    if(!isset($service_type)){
        $service_type = null;
    }
	if(!isset($service_id)){
        $service_id = null;
    }
	//pr($service_id); exit;
    //echo  $service_type;
    //echo  $ser_cat_type ; exit;
    //$deals = $this->frontCommon->getmydeals($user_id, $ser_cat_type, $service_type);
    $services = $this->frontCommon->SalonServiceList($user_id, $ser_cat_type, $service_type, $service_id);
   
    $services = $services['salonservices'];
    $business_url = $this->frontCommon->getBusinessUrl($user_id);
	//pr($services); exit;
	?>	
	<h2 class="share-head">Menu
			<a href="javascript:void(0)" id ="<?php echo $user_id;?>" class="cross close-this">
				<img  src="/img/cross.png" alt="" title="">
			</a>
		
	</h2>
	<div class="deal-box-outer clearfix col-sm-12">
		<?php
		if(!empty($services)){
			$i = 1;
			$lowestPrice = array('NULL');
			foreach($services as $service){
				if(!empty($service)){
					//foreach($service['children'] as $key => $child){
						$service_name = '';
						$count = '';
						$price = '';
						$append_class='';
						if($i%3==0){
							$append_class = 'mrgn-rgt0';
						}
						if($i < 6){ ?>
						<div class="deal-box col-sm-3 col-xs-12 mrgn0 <?php echo $append_class;?>">
							<?php if(!empty($service['SalonServiceImage']) &&
								($service['SalonServiceImage'][0]['image'] !='')) {
								echo $this->Html->image('/images/Service/150/'.$service['SalonServiceImage'][0]['image']);
							}else{ ?>
								<img src="/img/admin/treat-pic.jpg" alt="" title="">
							<?php } ?>
							<section class="sec">
								<span>
									<?php $service_name = $this->frontCommon->theserviceName($service);
									if(isset($service_name) && $service_name != ''){
										$service_name = $service_name;	
									}
									else{
										$service_name = "";
									}
									echo substr($service_name,0,23);
									?> 
								</span>
								<span id="<?php echo $user_id?>" class="show-menu-price">
									<?php
									$servicePrice = $this->frontCommon->getServicePrice($service['SalonService']['id']);
									if(!empty($servicePrice['from'])){
										echo '<span><b>from AED '.$servicePrice['full'].'</b><span>';
									} elseif($servicePrice['sell']){
										echo '<span class="cut-line">AED'.$servicePrice['full'].' </span><b> AED '.$servicePrice['sell'].'</b>';
									} else{
										echo 'AED '. $servicePrice['full'];
									}
									$lowestPrice[] = $servicePrice['full']; ?>				
								</span>
								<?php
								if(!empty($business_url) && !empty($service['SalonService']['id'])){
									if(!empty($service_name))
										$service_name_book = str_replace(' ','-',trim($service_name));
									else
										$service_name_book = '';
									$link_book = '/'.$business_url.'-service/'.@$service_name_book.'-'.base64_encode($service['SalonService']['id']);
								} else {
									$link_book = '/#';
								}
								
								 $book = ($service['SalonServiceDetail']['sold_as'] == 2)? __('buy_voucher',true) : __('book_now',true); 
								echo $this->Html->link('<button class="book-now" type="button">'.$book.'</button>',
									$link_book,
									array('escape'=>false,'class'=>'salon-book-now')
								);?>
							</section>
						</div>
						<?php }
						$i++;
					//}
				}
			}
			if($service_cnt > 5){ ?>
				<div style="height: 215px; padding: 80px 10px;" class="deal-box col-sm-3 col-xs-12 mrgn-rgt0"> 
					<?php echo $this->Html->link($this->Html->image('view_more1.gif',array('style'=>"height: 60px;")),
								     '/'.$user['Salon']['business_url'],
								     array('escape'=>false)
								    );?>
				</div>
			<?php } ?>
			<script type="text/javascript">
				$(document).ready(function(){
					var getId = '<?php echo $user_id;?>';
					var lp = '<?php echo min($lowestPrice); ?>';
					$("#rate_"+getId).html('AED '+lp);
				});
			</script>
			<?php
		}else{
			echo 'No offers there !!';
		} ?>
	</div>
	
	<!--script type="text/javascript">
		$('.salon-book-now').click(function(){
			var ser_id = this.id;
			var book_detls = ser_id.split('-');
			var book_type = book_detls[0];
			var book_id = book_detls[1];
			$.ajax({
				url: "/search/setsession/"+book_id+"/"+book_type,
				context: document.body
			}).done(function() {
				window.location.href = $('#'+ser_id).attr('link-loc');
				//$( this ).addClass( "done" );
			});
		});
	</script-->
<?php }?>