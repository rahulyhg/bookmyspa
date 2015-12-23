<footer>
	<div class="container">
    	<div class="col-sm-2  col-xs-2">
            <h3><?php echo __('Follow_Us',true); ?></h3>
            <?php echo $this->Html->link($this->Html->image('frontend/fb.png'),'#',array('escape'=>false,'class'=>"margin_rt10 socialIcon"));?>
	    <?php echo $this->Html->link($this->Html->image('frontend/gplus.png'),'#',array('escape'=>false,'class'=>"socialIcon"));?>
        </div>
        <div class="col-sm-2  col-xs-2">
        	<h3><?php echo __('Discover',true); ?> </h3>
		<ul>
			<li>
				<?php echo $this->Html->link(__('Download ',true).'<span class="sm-iphn-hide">'.__(' our ',true).'</span>'. __(' App',true),
					'#',
					array('escape'=> false));?>
			</li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'support')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('support',true),
					'/support',
					array('class'=>$act_class, 'escape'=>false,'title'=>__('support',true)
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Gift_Voucher',true),
					array('controller'=>'GiftCertificates','action'=>'index','admin'=>false),
					array('escape'=>false)); ?>
			</li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'beauty-blog')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Beauty_Blog',true),
					'/beauty-blog',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'blog-support')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Blog_Support',true),
					'/blog-support',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li class="sm-iphn-hide" >
				<?php
				if(!empty($page_for) && ($page_for == 'treatments')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Treatments_A_Z',true),
					'/treatments',
					array('class' => $act_class,'escape'=> false));?>
			</li>	
		</ul>
        </div>
        
         <div class="col-sm-4  col-xs-4 text-center sm-iphn-hide">
			<?php echo $this->Html->link($this->Html->image('frontend/logo.png'),
					'#',
					array('escape'=> false,"class"=>"footer_logo"));?>
         </div>
         <div class="col-sm-2  col-xs-2">
        	<h3><?php echo __('services',true); ?></h3>
		<ul>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'verify-evoucher')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Verify_a_Voucher',true),
					'/verify-evoucher',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li>
				<?php
				echo $this->Html->link(__('Business Enquiries',true),
					array('controller'=>'StaticPages','action'=>'business_enquiry','admin'=>false),
					array('escape'=>false)); ?>
			</li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'business-blog')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Business_Blog',true),
					'/business-blog',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li class="sm-iphn-hide">
				<?php
				echo $this->Html->link(__('Feedback',true),array('controller'=>'StaticPages','action'=>'feedback','admin'=>false),array()); ?></li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'advertise')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Advertise_with_Us',true),
					'/advertise',
					array('class' => $act_class,'escape'=> false));?>
			</li>
		</ul>
        </div>
        
        <div class="col-sm-2  col-xs-2">
        	<h3><?php echo __('company',true); ?></h3>
		<ul>
			<li><?php 
				$label = 'Contact';
				$label .= '<span class="sm-iphn-hide"> Us</span>';
				echo $this->Html->link(__($label,true),
					array('controller'=>'StaticPages','action'=>'contact_us','admin'=>false),
					array('escape' => FALSE)); ?>
			</li>
			<li class="sm-iphn-hide">
				<?php
				if(!empty($page_for) && ($page_for == 'about-us')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('About ',true).'<span class="sm-iphn-hide">'.__(' Us',true).'</span>',
					'/about-us',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li class="sm-iphn-hide">
				<?php
				echo $this->Html->link(__('Sitemap',true),
					'/sitemap',
					array('escape'=>false,'title'=>'Sitemap')); ?>
			</li>
			<li class="sm-iphn-hide">
				<?php
				if(!empty($page_for) && ($page_for == 'hiring')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('We_are_Hiring',true),
					'/hiring',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li>
				<?php
				echo $this->Html->link(__('Legal',true),
					array('controller'=>'StaticPages','action'=>'legal','admin'=>false,10),
					array('class' => $act_class,'escape'=>false)); ?>
			</li>
		</ul>
        </div>
    </div>
</footer>
<footer class="arabic-footer">
	<div class="container">
    	<div class="col-sm-2  col-xs-2">
        	<h3><?php echo __('company',true); ?></h3>
		<ul>
			<li>
			    <?php 
				$label = __('Contact', true);
				$label .= '<span class="sm-iphn-hide"> '.__('Us', true).'</span>';
				
				echo $this->Html->link(__($label,true),
					array('controller'=>'StaticPages','action'=>'contact_us','admin'=>false),
					array('escape' => false)); ?>
			</li>
			<li class="sm-iphn-hide">
				<?php
				if(!empty($page_for) && ($page_for == 'about-us')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('About',true).'<span class="sm-iphn-hide">'.__('Us',true).'</span>',
					'/about-us',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li class="sm-iphn-hide">
				<?php echo $this->Html->link(__('Sitemap',true),'/sitemap',array('escape'=>false,'title'=>'Sitemap')); ?></li>
			<li class="sm-iphn-hide">
				<?php
				if(!empty($page_for) && ($page_for == 'hiring')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('We_are_Hiring',true),
					'/hiring',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Legal', true),
					array('controller'=>'StaticPages',
					      'action'=>'legal','admin'=>false,10),array()); ?></li>
		     
		</ul>
        </div>
        <div class="col-sm-2  col-xs-2">
        	<h3><?php echo __('services',true); ?></h3>
		<ul>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'verify-evoucher')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Verify_a_Voucher',true),
					'verify-voucher',
					array('class' => $act_class,'escape'=> false));?>
			</li>
			<li>
				<?php
				echo $this->Html->link(__('Business_Enquiries',true),
					array('controller'=>'StaticPages','action'=>'business_enquiry','admin'=>false),
					array('escape'=>false)); ?>
			</li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'business-blog')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Business_Blog',true),
					'business-blog',
					array('escape'=> false));?>
			</li>
			<li class="sm-iphn-hide">
				<?php echo $this->Html->link(__('Feedback',true),
					array('controller'=>'StaticPages','action'=>'feedback','admin'=>false),
					array('escape'=>false)); ?>
			</li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'advertise')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Advertise_with_Us',true),
					'/advertise',
					array('class' => $act_class,'escape'=> false));?>
			</li>
		</ul>
        </div>
	<div class="col-sm-4  col-xs-4 text-center sm-iphn-hide">
	       <a href="#" class="footer_logo"><?php echo $this->Html->image('frontend/logo.png');?></a>
	</div>
                
        <div class="col-sm-2  col-xs-2">
        	<h3> </h3>
		<ul>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'download')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Download',true).'<span class="sm-iphn-hide">'.__('our',true).'</span>'.__('App',true),
					'#',
					array('escape'=> false));?>
			</li>
			<li>
				<?php echo $this->Html->link(__('support',true),
					'/support',
					array('escape'=>false,'title'=>__('support',true)
				)); ?>
			</li>
			<li>
				<?php echo $this->Html->link(__('Gift_Voucher',true),
				array('controller'=>'GiftCertificates','action'=>'index','admin'=>false),
				array('escape'=>false)); ?>
			</li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'beauty-blog')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Beauty_Blog',true),
					'/beauty-blog',
					array('escape'=> false));?>
			</li>
			<li>
				<?php
				if(!empty($page_for) && ($page_for == 'blog-support')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Blog_Support',true),
					'blog-support',
					array('escape'=> false));?>
			</li>
			<li class="sm-iphn-hide" >
				<?php
				if(!empty($page_for) && ($page_for == 'treatments')){
					$act_class = 'active';
				} else {
					$act_class = '';
				}
				echo $this->Html->link(__('Treatments_A_Z',true),
					'/treatments',
					array('escape'=> false));?>
			</li>
		</ul>
        </div>
        
        
        <div class="col-sm-2  col-xs-2">
	<h3><?php echo __('Follow_Us',true); ?></h3>
            <?php echo $this->Html->link($this->Html->image('frontend/fb.png'),
		'#',
		array('escape'=>false,'class'=>"margin_rt10 socialIcon"));
		$this->Html->link($this->Html->image('frontend/gplus.png'),
		'#',
		array('escape'=>false,'class'=>"socialIcon"));?>
	    
        </div>
    </div>
    	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68949263-1', 'auto');
  ga('send', 'pageview');

</script>
</footer>

<div class="copy_box">
	<div class="container"><p><?php echo __('copyright');  ?> <?php echo date('Y'); ?> - <?php echo __('rights');  ?></p></div>
</div>