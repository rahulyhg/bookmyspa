<div class="wrapper">
    <div class="container">
        <div class="abt-gift-voucher clearfix terms-condition">
            <?php if($pageDetail['StaticPage']['alias'] == 'about-us') {
		$class = "";
	    }else{
		$class = "big-lft";
	    } ?>
            <?php if(!empty($class)) { ?>
		<div class="fixed-rgt" <?php //echo (!in_array($pageDetail['StaticPage']['id'],array(10,11,12,13)))?'style="display:none"':''; ?> >
		    <h3>Legal documents</h3>
		    <ul>
			
			<li><?php echo $this->Html->link('<span>'.__('Sieasta - Terms and Conditions').'</span><i class="fa fa-angle-double-right"></i>',array('controller'=>'StaticPages','action'=>'legal','admin'=>false,10),array('escape'=>false,'class'=>($pageDetail['StaticPage']['id']==10)?'active':'')); ?></li>
			<li><?php echo $this->Html->link('<span>'.__('Booking Terms and Conditions').'</span><i class="fa fa-angle-double-right"></i>',array('controller'=>'StaticPages','action'=>'legal','admin'=>false,11),array('escape'=>false,'class'=>($pageDetail['StaticPage']['id']==11)?'active':'')); ?></li>
			<li><?php echo $this->Html->link('<span>'.__('Privacy and cookie policy').'</span><i class="fa fa-angle-double-right"></i>',array('controller'=>'StaticPages','action'=>'legal','admin'=>false,12),array('escape'=>false,'class'=>($pageDetail['StaticPage']['id']==12)?'active':'')); ?></li>
			<li><?php echo $this->Html->link('<span>'.__('Vendor terms and conditions Sieasta').'</span><i class="fa fa-angle-double-right"></i>',array('controller'=>'StaticPages','action'=>'legal','admin'=>false,15),array('escape'=>false,'class'=>($pageDetail['StaticPage']['id']==15)?'active':'')); ?></li>
			<li><?php echo $this->Html->link('<span>'.__('Sieasta refund and cancellation policy').'</span><i class="fa fa-angle-double-right"></i>',array('controller'=>'StaticPages','action'=>'legal','admin'=>false,14),array('escape'=>false,'class'=>($pageDetail['StaticPage']['id']==14)?'active':'')); ?></li>
			<li><?php echo $this->Html->link('<span>'.__('User generated content policy').'</span><i class="fa fa-angle-double-right"></i>',array('controller'=>'StaticPages','action'=>'legal','admin'=>false,13),array('escape'=>false,'class'=>($pageDetail['StaticPage']['id']==13)?'active':'')); ?></li>
			
		    </ul>
		</div>
           <?php } ?>
            <div class="<?php echo $class; ?>">
	    <?php
		$lang = Configure::read('Config.language'); 
	    ?>
                <h2><?php
		    
		    if($lang != 'eng'){
			if(!empty($pageDetail['StaticPage']['ara_title'])){
			   echo $pageDetail['StaticPage']['ara_title'];
			}
			else{
			    echo $pageDetail['StaticPage']['eng_title'];
			}
		    }else{
			echo $pageDetail['StaticPage']['eng_title'];
		    }
	 ?></h2>
                <h5>Last updated <?php echo $newDate = date("M Y", strtotime($pageDetail['StaticPage']['modified']));?></h5>
                <div class="sec-txt p-editor">
		    <?php
		    
		    if($lang != 'eng'){
			if(!empty($pageDetail['StaticPage']['ara_description'])){
			   echo $pageDetail['StaticPage']['ara_description'];
			}
			else{
			    echo $pageDetail['StaticPage']['eng_description'];
			}
		    }else{
			echo $pageDetail['StaticPage']['eng_description'];
		    }
	 ?>
                  
                </div>
            </div>

        </div>
    </div>
</div>
<?php
//pr($pageDetail);
?>