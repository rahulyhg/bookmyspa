<div id="left" style="height:548px" >

<?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(2,3,4))){ ?>
    <div class="subnav">
        <div class="subnav-title">
		<?php echo $this->Html->link('<img src="/img/admin/blog.png" alt="" title="" /><span>Business</span>','javascript:void(0);',array('class'=>'toggle-subnav','escape'=>false)); ?>
        </div>
	
    <ul class="subnav-menu">
            <li <?php if($activeTMenu == 'bsnsProfile'){ echo 'class="active"'; } ?> >
					 <?php echo $this->Html->link('<span>Business Profile</span>',array('controller'=>'Users','action'=>'businessProfile','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'facilityInfo'){ echo 'class="active"'; } ?> >
					<?php echo $this->Html->link('<span>Facility Information</span>',array('controller'=>'Settings','action'=>'facilityDetails','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'bankInfo'){ echo 'class="active"'; } ?> >
					<?php echo $this->Html->link('<span>Bank Details</span>',array('controller'=>'Settings','action'=>'bankDetails','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'billingInfo'){ echo 'class="active"'; } ?> >
					<?php echo $this->Html->link('<span>Billing Details</span>',array('controller'=>'Settings','action'=>'billingDetails','admin'=>true),array('escape'=>false)); ?>
            </li>
			<?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(3,4))){ ?>
            <li <?php if($activeTMenu == 'openHours'){ echo 'class="active"'; } ?> >
					<?php echo $this->Html->link('<span>Opening Hours</span>',array('controller'=>'Settings','action'=>'open_hours','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'room'){ echo 'class="active"'; } ?> >
					<?php echo $this->Html->link('<span>Hotel Rooms</span>',array('controller'=>'Settings','action'=>'room','admin'=>true),array('escape'=>false)); ?>
            </li>
			<?php } ?>
	    <li <?php if($activeTMenu == 'resource'){ echo 'class="active"'; } ?> >
					<?php echo $this->Html->link('<span>Treatment Rooms</span>',array('controller'=>'Settings','action'=>'room','resource','admin'=>true),array('escape'=>false)); ?>
            </li>
    </ul>
    
    </div>
<?php } ?>

<?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1,2,3,4))){ ?>
    <div class="subnav">
        <div class="subnav-title">
                <?php echo $this->Html->link('<img src="/img/admin/gen-settting.png" alt="" title="" /><span>General Settings</span>','javascript:void(0);',array('class'=>'toggle-subnav','escape'=>false)); ?>
        </div>
        <ul class="subnav-menu">
	  <?php if($auth_user['User']['type'] == 1){ ?>
            <li <?php if($activeTMenu == 'salonDiscounts'){ echo 'class="active"'; } ?> >
                             <?php echo $this->Html->link('<span>Salon Discount</span>',array('controller'=>'Salons','action'=>'discounts','admin'=>true),array('escape'=>false)); ?>
            </li>
	    <?php } ?>
	    <li <?php if($activeTMenu == 'emailsmsStng'){ echo 'class="active"'; } ?> >
                             <?php echo $this->Html->link('<span>Email and SMS Settings</span>',array('controller'=>'Settings','action'=>'email_setting','admin'=>true),array('escape'=>false)); ?>
            </li>
		
			<?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1,3,4))){ ?>
            <li <?php if($activeTMenu == 'apntmtStng'){ echo 'class="active"'; } ?> >
                            <?php echo $this->Html->link('<span>Appointment Settings</span>',array('controller'=>'Settings','action'=>'appointment_rule','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'policySettings' && $auth_user['User']['type'] != 1){ echo 'class="active"'; } ?> >
					<?php echo $this->Html->link('<span>Policy</span>',array('controller'=>'Settings','action'=>'policy_details','admin'=>true),array('escape'=>false)); ?>
            </li>
	    <li <?php if($activeTMenu == 'calConfig'){ echo 'class="active"'; } ?> >
                            <?php echo $this->Html->link('<span>Calendar Configuration</span>',array('controller'=>'Settings','action'=>'calendar_setting','admin'=>true),array('escape'=>false)); ?>
            </li>
			<li <?php if($activeTMenu == 'calcolor'){ echo 'class="active"'; } ?> >
                            <?php echo $this->Html->link('<span>Calendar Status</span>',array('controller'=>'statuses','action'=>'set_status','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'outcallConfig'){ echo 'class="active"'; } ?> >
                            <?php echo $this->Html->link('<span>OutCall Configuration</span>',array('controller'=>'Settings','action'=>'outcall_setting','admin'=>true),array('escape'=>false)); ?>
            </li>
			<?php } ?>
        </ul>
    </div>
<?php } ?>
<?php if(isset($auth_user) && $auth_user['User']['type'] == 1){ ?>
    <div class="subnav">
        <div class="subnav-title">
                <?php echo $this->Html->link('<img src="/img/admin/payment-plans.png" alt="" title="" /><span>Payment Plans</span>','javascript:void(0);',array('class'=>'toggle-subnav','escape'=>false)); ?>
        </div>
        <ul class="subnav-menu">
            <li <?php if($activeTMenu == 'emailPlan'){ echo 'class="active"'; } ?> >
                    <?php echo $this->Html->link('<span>Email Plans</span>',array('controller'=>'Payments','action'=>'plans','admin'=>true,'email'),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'smsPlan'){ echo 'class="active"'; } ?> >
                    <?php echo $this->Html->link('<span>SMS Plans</span>',array('controller'=>'Payments','action'=>'plans','admin'=>true,'sms'),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'featuredPlan'){ echo 'class="active"'; } ?>>
                    <?php echo $this->Html->link('<span>Featuring Plans</span>',array('controller'=>'Payments','action'=>'plans','admin'=>true,'featuring'),array('escape'=>false)); ?>
            </li>
	    <li <?php if($activeTMenu == 'pointSetting'){ echo 'class="active"'; } ?> >
		     <?php echo $this->Html->link('<span>Points Setting</span>',array('controller'=>'Settings','action'=>'point_setting','admin'=>true),array('escape'=>false)); ?>
            </li>
        </ul>
    </div>
<?php } ?>

  <?php if(isset($auth_user) && $auth_user['User']['type'] == 1){ ?>
    <div class="subnav">
        <div class="subnav-title">
                <?php echo $this->Html->link('
<img src="/img/admin/blog.png" alt="" title="" /><span>Blogs</span>','javascript:void(0);',array('class'=>'toggle-subnav','escape'=>false)); ?>
        </div>
        <ul class="subnav-menu">
            <li <?php if($activeTMenu == 'blogCategories'){ echo 'class="active"'; } ?>>
                            <?php echo $this->Html->link('<span>Categories</span>',array('controller'=>'blogs','action'=>'categories','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'blog'){ echo 'class="active"'; } ?>><?php echo $this->Html->link('<span>Blogs</span>',array('controller'=>'blogs','action'=>'all_blogs','admin'=>true),array('escape'=>false)); ?>
            </li>
        </ul>
    </div>

    <div class="subnav">
        <div class="subnav-title">
	<?php echo $this->Html->link('<img src="/img/admin/templates.png" alt="" title="" /><span>Templates</span>','javascript:void(0);',array('class'=>'toggle-subnav','escape'=>false)); ?>
        </div>
        <ul class="subnav-menu">
	
            <li <?php if($activeTMenu == 'cmsPage'){ echo 'class="active"'; } ?> >
			<?php echo $this->Html->link('<span>CMS Pages</span>',array('controller'=>'StaticPages','action'=>'pages','admin'=>true),array('escape'=>false)); ?>
            </li>
	   
		<?php if(isset($auth_user) && $auth_user['User']['type'] == 1){ ?>
            <!--<li <?php //if($activeTMenu == 'salonPage'){ echo ' class="active"'; } ?>>
            <?php // echo $this->Html->link('<span>Salon CMS Pages</span>',array('controller'=>'StaticPages','action'=>'salonPages','admin'=>true),array('escape'=>false)); ?>
            </li>-->
	    <li <?php if($activeTMenu == 'emailTemplate'){ echo ' class="active"'; } ?> >
            <?php echo $this->Html->link('<span>Email Templates</span>',array('controller'=>'Emailtemplates','action'=>'index','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li <?php if($activeTMenu == 'smsTemplate'){ echo ' class="active"'; } ?> >
            <?php echo $this->Html->link('<span>SMS Templates</span>',array('controller'=>'Smstemplates','action'=>'index','admin'=>true),array('escape'=>false)); ?>
            </li>
	    <?php } ?>
        </ul>
    </div>
    <?php } ?>
     <?php if(isset($auth_user) && $auth_user['User']['type'] != 2){ ?>
    <div class="subnav">
        <div class="subnav-title">
	<?php echo $this->Html->link('<img src="/img/admin/profile.png" alt="" title="" /><span>Employees</span>','javascript:void(0);',array('class'=>'toggle-subnav','escape'=>false)); ?>
        </div>
        <ul class="subnav-menu">
	<?php //if(isset($auth_user) && in_array($auth_user['User']['type'],array(2,3,4))){ ?>
	
            <li <?php if($activeTMenu == 'payroll'){ echo 'class="active"'; } ?> >
		     <?php echo $this->Html->link('<span>Payroll</span>',array('controller'=>'Settings','action'=>'payroll','admin'=>true),array('escape'=>false)); ?>
            </li>
	     <li <?php if($activeTMenu == 'displayorder'){ echo 'class="active"'; } ?> >
		     <?php echo $this->Html->link('<span>Website Employee Lineup</span>',array('controller'=>'Settings','action'=>'display_order','admin'=>true),array('escape'=>false)); ?>
            </li>
	
		<?php //} ?>
	    <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1))){ ?>
		<li <?php if($activeTMenu == 'priceLevelemp'){ echo 'class="active"'; } ?> >
			 <?php echo $this->Html->link('<span>Pricing Level</span>',array('controller'=>'Settings','action'=>'pricing_level','admin'=>true),array('escape'=>false)); ?>
		</li>
	    <?php } ?>
        </ul>
    </div>
	<?php } ?>
    <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1,2,3,4))){ ?>
    <div class="subnav">
        <div class="subnav-title">
	<?php echo $this->Html->link('<img src="/img/admin/others.png" alt="" title="" /><span>Others</span>','javascript:void(0);',array('class'=>'toggle-subnav','escape'=>false)); ?>
        </div>
        <ul class="subnav-menu">
	<?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1,2,3,4))){ ?>
            <li <?php if($activeTMenu == 'taxSettings'){ echo 'class="active"'; } ?> >
		     <?php echo $this->Html->link('<span>Taxes and Checkout</span>',array('controller'=>'Products','action'=>'tax_setting','admin'=>true),array('escape'=>false)); ?>
            </li>
	     <li <?php if($activeTMenu == 'seoSetting'){ echo 'class="active"'; } ?> >
		     <?php echo $this->Html->link('<span>Seo Tags</span>',array('controller'=>'Settings','action'=>'seo','admin'=>true),array('escape'=>false)); ?>
            </li>
		<?php } ?>	    
        </ul>
    </div>
    <?php } ?>
    
    <?php if(isset($auth_user) && $auth_user['User']['type'] == 1){ ?>
    <div class="subnav">
        <div class="subnav-title">
	<?php echo $this->Html->link('<img src="/img/admin/others.png" alt="" title="" /><span>Inventory</span>','javascript:void(0);',array('class'=>'toggle-subnav','escape'=>false)); ?>
        </div>
        <ul class="subnav-menu">
	    <li <?php if($activeTMenu == 'productType'){ echo 'class="active"'; } ?>>
		<?php echo $this->Html->link('<span>Product Types</span>',array('controller'=>'products','action'=>'list_producttype','admin'=>true),array('escape'=>false)); ?>
	    </li>
	    <li <?php if($activeTMenu == 'brand'){ echo 'class="active"'; } ?> ><?php echo $this->Html->link('<span>Brands</span>',array('controller'=>'products','action'=>'list_brands','admin'=>true),array('escape'=>false)); ?>
	    </li>
	</ul>
    </div>
    <?php } ?>

</div>




