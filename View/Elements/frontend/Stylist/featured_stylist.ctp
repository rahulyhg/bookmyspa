<?php echo $this->Html->script('frontend/star-rating.js?v=1'); ?>
<?php echo $this->Html->css('frontend/star-rating.css?v=1'); ?>
<style>
.deal-box .sec span {
    display: block !important;
    float: left !important;
    margin-bottom: 2px !important;
}
.rationg-list {
    display: block !important;
    float: right !important;
    margin: 0 !important;
    padding: 0 !important;
    width:auto !important;
}
.rationg-list li {
    color: #ffb702 !important;
    float: right !important;
    font-size: 13px !important;
    list-style-type: none !important;
    margin: 0 0 0 5px !important;
}
</style>
<?php echo  $this->Paginator->options(array(
	'update' => '#ajax',
        'evalScripts' => true,
	'before' => $this->Js->get('#ajax_modal1')->effect('fadeIn', array('buffer' => false)),
        'success' => $this->Js->get('#ajax_modal1')->effect('fadeOut', array('buffer' => false))
	));
?>
<div class="booking-section clearfix">
        <h2 class="share-head">
		<?php echo __('Stylists' , TRUE); ?>
        </h2>
        <div class="deal-box-outer clearfix stylist-outer">
            	<?php if(count($allUsers)){
			$i=1;
			//pr($allUsers); die;
			foreach($allUsers as $user){
				if($user['User']['type'] == 5){
					$business_url = $this->frontCommon->getBusinessUrl($user['User']['parent_id']);
					$salon_id = $user['User']['parent_id'];
					$employee_id = $user['User']['id'];
				}else{
					$business_url = $user['Salon']['business_url'];
					$salon_id = $user['Salon']['user_id'];
					$employee_id = $user['Salon']['user_id'];
					
				}
				
				?> 
				<div class="deal-box <?php echo ($i%3==0)?'mrgn-rgt0':'';?>">
					<div class="stylist-fix-hgt">
						<?php
						$staff_img = '';
						if(!empty($user['User']['image'])){
							$img_name = $this->Common->get_image_stylist($user['User']['image'],
								$user['User']['id'] ,
								'User',200);
							if(!empty($img_name)){
								$staff_img = substr($img_name,1);
							}
						}
						if(!empty($staff_img)){
							//echo $staff_img;
							if (file_exists(WWW_ROOT.$staff_img)) {
								echo $this->Html->image('/'.$staff_img,
									array('title' => ucfirst(@$user['User']['first_name']).' '.ucfirst(@$user['User']['last_name'])));
							}
						}
						
				?>&nbsp;
					</div>
					<?php if($user['User']['is_featured_employee']=='1'){ ?>
						<div class="featured">Featured</div>
					<?php } ?>
					<section class="sec clearfix">
						<span>
							<?php echo ucfirst($user['User']['first_name']); ?>
						</span>
						<?php $user_rating=$this->common->get_rating_by_user($user['User']['id']); ?>
						<!--<ul class="rationg-list clearfix">
							<li><i class="fa fa-star"></i></li>
							<li><i class="fa fa-star"></i></li>
							<li><i class="fa fa-star"></i></li>
							<li><i class="fa fa-star"></i></li>
							<li><i class="fa fa-star"></i></li>
						</ul>-->
						
						
						
					<?php
					if(round($user_rating[0][0]['avgRating'])>0){ ?>
					    <ul class="rationg-list clearfix">
						<?php for($m=5;$m>=1;$m--){
						    if($m>round($user_rating[0][0]['avgRating'])){ ?>
							<li><i class="fa fa-star-o"></i></li>
						    <?php } else{ ?>
							<li><i class="fa fa-star"></i></li> 
						    <?php }   ?>
						<?php } ?>
					    </ul>
					<?php } else{ ?>
					    <ul class="rationg-list clearfix">
					        <?php for($m=1;$m<=5;$m++){ ?>
						    <li><i class="fa fa-star-o"></i></li>
						<?php } ?>
					    </ul>
					<?php } ?>
				    
						
						
						
						
						
						
						
						
						<span><?php //echo $this->Form->input('', array('div'=>false,'label' => '', 'class' => 'rating','data-size'=>'','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','glyphicon'=>false,'rating-class'=>'fa-star','value'=>$user_rating[0][0]['avgRating'])); ?></span>
						
						
						<?php //pr($user_rating); die; ?>
						<span class="location-name ">
							<?php
								$salon_name = $this->Common->get_my_salon_name($salon_id); 
								if(strlen($salon_name) > 20)
									echo substr($salon_name , 0 , 20)."...";
								else
									echo $salon_name;
								?>
							</br>	
							<span class="add_ress">
								<i class="fa fa-map-marker"></i> &nbsp;<?php echo $this->Common->get_SalonAddress($user['User']['id']);?>
							</span>
						</span>
						<?php 
							
							if(!empty($employee_id) && !empty($salon_id) && !empty($business_url)){
								$link = '/'.$business_url.'/services/'.base64_encode($employee_id);
							}else{
								$link = '#';	
							}
							echo $this->Html->link(
							'<button link-loc="" type="button" class="book-now" data-tag="'.$user['User']['id'].'">'.__('Book Now',true).'</button>',
							$link,
							array('escape'=>false)
						);
						?>
					</section>
				</div>
				<?php $i++;
			}
		}else { ?>
			<div><?php echo __('No Results Found'); ?></div>
                <?php } ?>
        </div>
</div>
<nav class="pagi-nation">
	<?php if($this->Paginator->param('pageCount') > 1){
		
		$this->Paginator->options(array('url' => $this->passedArgs));
		echo $this->element('pagination-frontend');
	} ?>
</nav>
<?php echo $this->Js->writeBuffer();?>