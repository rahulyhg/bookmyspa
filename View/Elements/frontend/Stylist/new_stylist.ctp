<?php if(!empty($newStylists)){?>
		<div class="new-stylists">
				<?php foreach($newStylists as $user){
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
						<div class="deal-box">
								<?php
										$staff_img = '';
										if(!empty($user['User']['image'])){
											$img_name = $this->Common->get_image_stylist($user['User']['image'],
												$user['User']['id'] ,
												'User','400');
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
								
								?>  
								<section class="sec clearfix">
										<span><?php echo ucfirst($user['User']['first_name']).' '.$user['User']['last_name']; ?></span>
										<span class="location-name">
												<?php echo $user['Salon'][$lang.'_name']; ?>
												<span><i class="fa fa-map-marker"></i>  &nbsp;<?php echo $this->Common->get_SalonAddress($user['User']['id']);?></span>                    
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
				<?php } ?>
		</div>
<?php }?>