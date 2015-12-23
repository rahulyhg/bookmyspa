<?php
$this->Paginator->options(array(
        'update' => '#update_ajax',
        'evalScripts' => true,
        'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
        'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))
    ));
    ?>
<div class="wrapper">
	<div class="container">
	<?php
	  if(!empty($staffOfmonth))
	{  ?>
	<div class="saloon-stylist">
            <div class="deal-banner-outer">
                <div class="stylist-banner">
                	<div class="staff-mnth"><img src="/img/tag.png" alt="Staff of the Month" title="Staff of the Month"></div>
			 <?php
				$staff_img = '';
				if(!empty($staffOfmonth['User']['image'])){
					 $img_name = $this->Common->get_image_stylist($staffOfmonth['User']['image'],
						$staffOfmonth['User']['id'] ,
						'User','original');
					if(!empty($img_name)){
						$staff_img = substr($img_name,1);
					}
				}
				if(!empty($staff_img)){
						//echo $staff_img;
						echo $this->Html->image('/'.$staff_img,
							array('title' => ucfirst(@$staffOfmonth['User']['first_name']).' '.ucfirst(@$staffOfmonth['User']['last_name'])));
				}
			?>
                        <!--<img src="img/staff-month.png" alt="Staff of the Month" title="Staff of the Month">-->
                        <div class="detail  clearfix">
                            <div class="location-name">
                                <!--Margarita Beauty Salon --><?php echo $staffOfmonth['User']['first_name']; ?>
                                <!--<span><i class="fa fa-map-marker"></i> Karma, Outer Dubai</span>-->
                            </div>
                            <div class="rate-btn">
                                <ul class="rationg-list clearfix">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
				<?php
				
				
				if($staffOfmonth['User']['type'] == 5){
					$business_url = $this->frontCommon->getBusinessUrl($staffOfmonth['User']['parent_id']);
					$salon_id = $staffOfmonth['User']['parent_id'];
					$employee_id = $staffOfmonth['User']['id'];
				}else{
					$business_url = $staffOfmonth['Salon']['business_url'];
					$salon_id = $staffOfmonth['Salon']['user_id'];
					$employee_id = $staffOfmonth['Salon']['user_id'];
					
				}
				if(!empty($employee_id) && !empty($salon_id) && !empty($business_url)){
					$link = '/'.$business_url.'/services/'.base64_encode($employee_id);
				}else{
					$link = '#';	
				}
				echo $this->Html->link(
					'<button link-loc="" type="button" class="book-now" data-tag="'.$staffOfmonth['User']['id'].'">'.__('Book Now',true).'</button>',
					$link,
					array('escape'=>false)
				);
						
				?> <?php //echo $this->Form->button('Book Now',array('type'=>'button','class'=>'book-now staffBuk', 'id' => $staffOfmonth['User']['id'], 'data-val' => $staffOfmonth['User']['created_by']) ); ?>
                            </div>
                        </div> 
                    </div>
            </div>
        </div>
	<?php
	  }
	if(!empty($ownProfile))
	{
	?>
        <div class="saloon-stylist">
            <div class="deal-banner-outer">
                    <div class="stylist-banner">
                        <!--<img src="img/latest-stylists.jpg" alt="latest stylist" title="latest stylist">-->
                        <?php
				$staff_img = '';
				if(!empty($ownProfile['User']['image'])){
					 $img_name = $this->Common->get_image_staff($ownProfile['User']['image'],
						$ownProfile['User']['id'] ,
						'User','original');
					if(!empty($img_name)){
						$staff_img = substr($img_name,1);
					}
				}
				
				if(!empty($staff_img)){
					//echo $staff_img;
						echo $this->Html->image('/'.$staff_img,
							array('title' => ucfirst(@$ownProfile['User']['first_name']).' '.ucfirst(@$ownProfile['User']['last_name'])));
					
				}
			?>
			 <?php //echo $this->Html->image($this->Common->get_image($ownProfile['User']['image'],$ownProfile['User']['id'],'User')); ?>	
                        <div class="detail  clearfix">
                            <div class="location-name">
                              
								<?php echo $ownProfile['User']['first_name']; ?>
                                <!--<span><i class="fa fa-map-marker"></i> Karma, Outer Dubai</span>-->
                            </div>
                            <div class="rate-btn">
                                <ul class="rationg-list clearfix">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                               <?php
					if($ownProfile['User']['type'] == 5){
						 $business_url = $this->frontCommon->getBusinessUrl($ownProfile['User']['parent_id']);
						 $salon_id = $ownProfile['User']['parent_id'];
						 $employee_id = $ownProfile['User']['id'];
					 }else{
						 $business_url = $ownProfile['Salon']['business_url'];
						 $salon_id = $ownProfile['Salon']['user_id'];
						 $employee_id = $ownProfile['Salon']['user_id'];
						 
					 }
					 if(!empty($employee_id) && !empty($salon_id) && !empty($business_url)){
						 $link = '/'.$business_url.'/services/'.base64_encode($employee_id);
					 }else{
						 $link = '#';	
					 }
					 echo $this->Html->link(
						 '<button link-loc="" type="button" class="book-now" data-tag="'.$ownProfile['User']['id'].'">'.__('Book Now',true).'</button>',
						 $link,
						 array('escape'=>false)
					 );
			       
			       ?>
                            </div>
                        </div> 
                    </div>
            </div>
        </div>
	<?php
	}
	?>
    </div>
    <div class="container clearfix">
    <!--feature deals starts-->
    <div class="featured-deals-box stylist only-deals clearfix">
      <div class="deal-box-outer clearfix">
          <?php
	  if(!empty($staffs))
	  {
	  foreach($staffs as $staff){ ?>
          
          <div class="big-deal">
              <div class="photo-sec">
		<div class="para-hover">
                  <p>Lorem ipsum dolor sit amet, con
sectetur adipiscing elit. Aliquam venenatis quis velit sit amet maxi.</p>
<p>mus. Pellentesque nisi touam venenatis quis velit sit amet maxi
mus. Pellentesque nisi torrtorles.</p>
                  </div>
           <?php
				$staff_img = '';
				if(!empty($staff['User']['image'])){
					 $img_name = $this->Common->get_image_stylist($staff['User']['image'],
						$staff['User']['id'] ,
						'User','400');
					if(!empty($img_name)){
						$staff_img = substr($img_name,1);
					}
				}
				
				if(!empty($staff_img)){
					//echo $staff_img;
					if (file_exists(WWW_ROOT.$staff_img)) {
						echo $this->Html->image('/'.$staff_img,
							array('title' => ucfirst(@$staff['User']['first_name']).' '.ucfirst(@$staff['User']['last_name'])));
					}
				}
			?>
                  <!--<img src="img/stylist1.jpg" alt="Staff" title="Staff">-->
              </div>
              <div class="detail-area clearfix">
                  <div class="heading">
                    <span><?php echo ucfirst($staff['User']['first_name']).' '.$staff['User']['last_name'];  ?></span>
		   
			  <?php
				if($staff['User']['type'] == 5){
					 $business_url = $this->frontCommon->getBusinessUrl($staff['User']['parent_id']);
					 $salon_id = $staff['User']['parent_id'];
					 $employee_id = $staff['User']['id'];
				 }else{
					 $business_url = $staff['Salon']['business_url'];
					 $salon_id = $staff['Salon']['user_id'];
					 $employee_id = $staff['Salon']['user_id'];
					 
				 }
				 if(!empty($employee_id) && !empty($salon_id) && !empty($business_url)){
					 $link = '/'.$business_url.'/services/'.base64_encode($employee_id);
				 }else{
					 $link = '#';	
				 }
				 echo $this->Html->link(
					 '<button link-loc="" type="button" class="book-now" data-tag="'.$staff['User']['id'].'">'.__('Book Now',true).'</button>',
					 $link,
					 array('escape'=>false)
				 );
			       
			       ?>
		   
                      <ul class="rating">
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                      </ul>
                  </div>
            
              </div>
          </div> 
          <?php }
	 
	  }
	  else
	  {
		//echo "No data found";
	  }
	  
	  ?>
      </div>
    </div>
    <div class="pdng-lft-rgt35 clearfix">
    <nav class="pagi-nation">
            <?php if($this->Paginator->param('pageCount') > 1){
                    echo $this->element('pagination-frontend');
                    echo $this->Js->writeBuffer();
            } ?>
    </nav>
    </div>
    <!--feature deals ends-->
    </div>
</div>   
