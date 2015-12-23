<!--main banner starts-->
<?php //echo $this->Html->script('frontend/widget'); ?>
<?php //echo $this->Html->script('frontend/date'); ?>
<?php //echo $this->Html->script('frontend/jquery.weekcalendar'); ?>
<?php //echo $this->Html->css('lightslider/lightGallery'); ?>
<?php //echo $this->Html->script('lightslider/lightGallery'); ?>
<?php //echo $this->Html->script('admin/plugins/imagesLoaded/jquery.imagesloaded.min'); ?>
<?php //echo $this->Html->script('admin/plugins/masonry/jquery.masonry.min'); ?>
<?php $lang =  Configure::read('Config.language'); ?>
<div class="main-banner">
    <?php
	if(isset($userDetails['Salon']['cover_image']) && !empty($userDetails['Salon']['cover_image'])) {
	    echo $this->Html->image("/images/".$userDetails['User']['id']."/Salon/800/".$userDetails['Salon']['cover_image'],array('data-id'=>$userDetails['User']['id']));
	} else {
	    echo $this->Html->image('cover-bckend.jpg',array('alt'=>"",'title'=>""));
	}
    ?>
    <div class="transi-detail-outer clearfix">
        <div class="transi-detail clearfix">
            <div class="left">
                <h3>
		    <?php echo $userDetails['Salon'][$lang.'_name']; ?>
		</h3>
                <span class="address"><i class="fa fa-map-marker"></i>
		<?php		
		  $addressNew=explode(',',$userDetails['Address']['address']);
		  echo !empty($addressNew[0]) ? $addressNew[0].',' :'';
		  echo !empty($addressNew[1]) ? $addressNew[1].',' :'';
		  echo !empty($addressNew[2]) ? $addressNew[2].',' :'';
		  echo !empty($addressNew[3]) ? $addressNew[3].' ' :' '.$userDetails['Address']['po_box'];
		?>
		<!--1660 W Lake Houston Parkway, Suite 102, KINGWOOD, Texas 77339-->
		</span>
                <span class="email">
		    <i class="fa fa-globe"></i>
		    <?php echo $this->Html->link($userDetails['Salon']['website_url'],$userDetails['Salon']['website_url'],array('target'=>'_blank','escape'=>false));?>
		</span>
		<span class="email">
		    <i class="fa fa-envelope"></i>
		    <?php echo $this->Html->link($userDetails['Salon']['email'],'mailto:'.$userDetails['Salon']['email'],array('target'=>'_blank','escape'=>false));?>
		</span>
                <span class="phone">
		    <i class="fa fa-phone"></i>
		    <?php echo $userDetails['Contact']['cell_phone'];?>
		</span>
                <span class="like">
		    <i class="fa fa-thumbs-o-up"></i> Like : +0 1
		</span>
            </div>
            <div class="rgt">
                <ul class="book-rate">
                    <li>14.9</li>
                    <li><i class="fa fa-bookmark"></i></li>                       
                </ul>
                <ul class="rationg-list">
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                </ul>
            </div>
        </div>
        <ul class="bread-crms clearfix">
            <?php
              $user_type=$userDetails['User']['type'];
	      $user_type_text='';
              if($user_type == 4){
                  $user_type_text.= __("individual_salon",true);
              }else if($user_type == 2){
                  $user_type_text.=__("frenchise",true);
              }else if($user_type == 3){
                  $user_type_text.=__("multiple_location",true);
              }else if($user_type == 5){
		 $user_type_text.=__("user",true);
	      }  ?>
            <li>
		<?php echo  $this->Html->link(__('home',true) , '/'); ?>
	    </li>
            <li>
		<i class="fa fa-angle-double-right"></i>
	    </li>
            <li>
		<?php echo $this->Html->link($user_type_text.'( '.$userDetails['Salon'][$lang.'_name']. ')',array('controller'=>'place','action'=>'index','admin'=>false,$userDetails['User']['id']),array('escape'=>false));?>
	    </li>
            <li><i class="fa fa-angle-double-right"></i></li>
            <li><?php echo  $this->Html->link(__('view',true) , 'javascript:void(0)'); ?></li>
        </ul>
   </div>       
</div>
<!--main banner ends-->

<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php echo $this->element('frontend/Place/all_tabs'); ?>
    </div>
	<?php echo $this->element('frontend/Place/all_detail'); ?>
</div>
<!--tabs main navigation ends-->
<?php echo $this->Js->writeBuffer();?>
