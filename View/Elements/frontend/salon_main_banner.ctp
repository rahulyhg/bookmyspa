
<style>
.transi-detail-outer .bread-crms {
    float: left;
    padding: 0 0 10px;
    width: 70%;
}
</style>
<?php $userDetails = $this->requestAction('/Place/get_salon_details/'.$salonId);


if(!empty($userDetails)) {
?>
<div class="main-banner">
    <?php
	if(isset($userDetails['Salon']['cover_image']) && !empty($userDetails['Salon']['cover_image']) ){
		$filename = WWW_ROOT ."images/".$userDetails['User']['id']."/Salon/1600/".$userDetails['Salon']['cover_image'];
		if (file_exists($filename)) {
			echo $this->Html->image("/images/".$userDetails['User']['id']."/Salon/1600/".$userDetails['Salon']['cover_image'],array('data-id'=>$userDetails['User']['id']));
		}else{
			echo $this->Html->image("/img/cover-bckend.jpg");
		}
	}else{
			echo $this->Html->image("/img/cover-bckend.jpg");
	}
    ?>
    <div class="transi-detail-outer clearfix">
        <div class="transi-detail clearfix">
            <div class="left">
                <h3>
		    <?php if(!empty($userDetails['Salon'][$lang.'_name'])){
			$userDetails['Salon'][$lang.'_name'];
		    } else {
			$userDetails['Salon']['eng_name'];
		    }?>
		</h3>
                <span class="address"><i class="fa fa-map-marker"></i>
		<?php
		    $city = $this->Common->getCity($userDetails['Address']['city_id']);
		    if(!empty($city))
			echo $city.', ';
		    $state = $this->Common->getState($userDetails['Address']['state_id']);
		    if(!empty($state))
			echo $state;
		  ?>
		</span>
		<?php if($userDetails['Salon']['website_url']){?>
                <span class="email"><i class="fa fa-globe"></i><a href="<?php echo $userDetails['Salon']['website_url'];?>" target="_blank"><?php echo $userDetails['Salon']['website_url'];?></a></span>
		<?php }?>
		<span class="email"><i class="fa fa-envelope"></i><a href="mailto:<?php echo $userDetails['Salon']['email'];?>" ><?php echo $userDetails['Salon']['email'];?></a></span>
                <span class="phone"><i class="fa fa-phone"></i>
		<?php
		    $phone_code = ($userDetails['Contact']['country_code'])?$userDetails['Contact']['country_code']:'+971';
		    if(!empty($userDetails['Contact']['day_phone'])){
		       echo $phone_code.'-'.$userDetails['Contact']['day_phone'];	
		    }else{
		       echo '-';	
		    }
		?></span>
                <span class="like"><i class="fa fa-thumbs-o-up"></i> Like : +0 1</span>
            </div>
            <!--<div class="rgt">
                <ul class="book-rate">
                    <li>14.9</li>
                    <li><i style="cursor: pointer;" id="<?php echo $userDetails['Salon']['user_id']; ?>" class="fa fa-bookmark bookmark-salon"></i></li>                       
                </ul>
		 <ul class="rationg-list">
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                    <li><i class="fa fa-star"></i></li>
                </ul>
            </div>-->
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
	      }
	      
	      //echo $this->params['action'];
	      $bradCumb_var = '';
	      if($this->params['action']=='index'){
		$bradCumb_var =  'about us';
	      }elseif($this->params['action']=='salonservices'){
		$bradCumb_var =  'services';
	      }elseif($this->params['action']=='salonpackages '){
		$bradCumb_var =  'packages';
	      }elseif($this->params['action']=='salonspaday'){
		$bradCumb_var =  'spa day';
	      }elseif($this->params['action']=='spabreaks'){
		$bradCumb_var =  'spabreak';
	      }elseif($this->params['action']=='salondeals'){
		$bradCumb_var =  'deals';
	      }elseif($this->params['action']=='salonStaff'){
		$bradCumb_var =  'staff';
	      }elseif($this->params['action']=='salongallery'){
		$bradCumb_var =  'gallery';
	      }elseif($this->params['action']=='salongiftcertificate'){
		$bradCumb_var =  'giftcertificate';
	      }
	      
	      
	      ?>
	      
	      
            <li><?php echo  $this->Html->link(__('home',true) , '/'); ?></li>
            <li><i class='fa fa-angle-double-right'></i></li>
	    <li><?php echo $this->Html->link($user_type_text.'( '.$userDetails['Salon'][$lang.'_name']. ')',array('controller'=>'place','action'=>'index','admin'=>false,$userDetails['User']['id']),array('escape'=>false));?></li>
           <?php if(!empty($bradCumb_var)) {?>
	     <li><i class="fa fa-angle-double-right"></i></li>
            <li><?php echo  $this->Html->link(__($bradCumb_var,true) , 'javascript:void(0)'); ?></li>
	    <?php }?>
        </ul>
	<!--<ul class="rationg-list">-->
	    <!--<li><i class="fa fa-star"></i></li>
	    <li><i class="fa fa-star"></i></li>
	    <li><i class="fa fa-star"></i></li>
	    <li><i class="fa fa-star"></i></li>
	    <li><i class="fa fa-star"></i></li>-->
	    <?php $salon_rating=$this->common->get_rating_by_salon($salonId); ?>
	    <?php
		if(round($salon_rating[0][0]['avgRating'])!=''){ ?>
		    <ul class="rationg-list">
			<?php for($m=5;$m>=1;$m--){
			    if($m>round($salon_rating[0][0]['avgRating'])){ ?>
				<li><i class="fa fa-star-o"></i></li>
			    <?php } else{ ?>
				<li><i class="fa fa-star"></i></li> 
			    <?php }   ?>
			<?php } ?>
		    </ul>
		<?php } else{ ?>
		    <ul class="rationg-list">
			<?php for($m=5;$m>=1;$m--){ ?>
			    <li><i class="fa fa-star-o"></i></li>
			<?php } ?>
		    </ul>
		<?php } ?>
		
		<span><?php //echo $this->Form->input('', array('div'=>false,'label' => '', 'class' => 'rating','data-size'=>'','data-readonly'=>'true','data-show-clear'=>'false','data-show-caption'=>'false','glyphicon'=>false,'rating-class'=>'fa fa-star','value'=>$salon_rating[0][0]['avgRating'])); ?></span>
        <!--</ul>-->
   </div>       
</div>
<!--main banner ends-->
<?php }?>
<script>
    $(document).ready(function(){
	$('.bookmark-salon').click(function(){
	    var salonId = $(this).attr('id');
	    var getURL = "<?php echo $this->Html->url(array('controller'=>'Place','action'=>'bookmark','admin'=>false)); ?>";
	    $.ajax({
		url: getURL,	
		type: 'POST',
		data:{salonId:salonId},
		success:function(data){
		    if(data == '1'){
			alert('Salon has been bookmarked');	
		    }else if(data == '0'){
			alert('Salon could not be bookmarked');	
		    }else if(data == '2'){
			alert('Salon has already been bookmarked');	
		    }else if(data == 'unauth'){
			$(document).find('.userLoginModal').trigger('click');	
		    }    
		}
	    });
	    
	})	
	
    })
</script>
<style>
    .main-rating{
	float: right;
    }
</style>