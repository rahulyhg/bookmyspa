<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse col-sm-6 nav_box" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav admin">
        <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(3,4,5))){ ?>
        <!--li <?php if($activeTMenu == 'calendar'){ echo 'class="active"'; } ?> >
        <?php //echo $this->Html->link('<span>Calendar</span>',array('controller'=>'Appointments','action'=>'index','admin'=>true),array('escape'=>false)); ?>
        </li-->
        <?php } ?>
    <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1,2,3,4))){ ?>
        <li <?php if(in_array($activeTMenu,array('customerList','customerManage'))){ echo 'class="active"'; } ?>>
        <?php echo $this->Html->link('<span>Customer</span><span class="caret"></span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown' ,'escape'=>false)); ?>
            <ul class="dropdown-menu">
                <li <?php if($activeTMenu == 'customerManage'){ echo 'class="active"'; } ?> >
                <?php echo $this->Html->link('<span>Customer Management</span>',array('controller'=>'Users','action'=>'manage','admin'=>true),array('escape'=>false)); ?>
                </li>
                <li <?php if($activeTMenu == 'customerList'){ echo 'class="active"'; } ?> >
                <?php echo $this->Html->link('<span>Customer List</span>',array('controller'=>'Users','action'=>'list','admin'=>true),array('escape'=>false)); ?>
                </li>
            </ul>
        </li>
    <?php }?>
    <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1,2,3))){ ?>
        <li <?php if(in_array($activeTMenu,array('businessType','businessList'))){ echo 'class="active"'; } ?>>
            <?php echo $this->Html->link('<span>Business</span><span class="caret"></span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown' ,'escape'=>false)); ?>
            <ul class="dropdown-menu">
                <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1))){ ?>
                <li <?php if($activeTMenu == 'businessList'){ echo 'class="active"'; } ?> >
                        <?php echo $this->Html->link('<span>Business List </span>',array('controller'=>'Business','action'=>'list','admin'=>true),array('escape'=>false)); ?>
                </li>
                <li <?php if($activeTMenu == 'businessType'){ echo 'class="active"'; } ?> >
                        <?php echo $this->Html->link('<span>Business Type</span>',array('controller'=>'Business','action'=>'type','admin'=>true),array('escape'=>false)); ?>
                </li>
                <?php } ?>
                <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(2,3))){ ?>
                <li <?php if($activeTMenu == 'businessList'){ echo 'class="active"'; } ?> >
                        <?php echo $this->Html->link('<span>Business List</span>',array('controller'=>'Salons','action'=>'index','admin'=>true),array('escape'=>false)); ?>
                </li>
                <?php } ?>

            </ul>
        </li>
    <?php }?> 

        <li <?php if(in_array($activeTMenu,array('treatmentGallery','billingInfo','facilityInfo','bankInfo','smsTemplate','albums','salonPage','emailTemplate','blog','blogCategories','cmsPage','groupList','pricingLevel','emailsmsStng','apntmtStng','calConfig','treatment','productType','brand','accessList','accessManage','venueGallery','priceLevelemp'))){?>class="active" <?php } ?>>
            <?php echo $this->Html->link('<span>Settings </span><span class="caret"></span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown','escape'=>false)); ?>
            <ul class="dropdown-menu">
                <li <?php if(in_array($activeTMenu,array('emailsmsStng','apntmtStng','calConfig'))){ echo 'class="active"'; } ?> >
                    <?php echo $this->Html->link('<span>General Settings</span>',array('controller'=>'Settings','action'=>'email_setting','admin'=>true),array('escape'=>false)); ?>
                </li>
                 <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(3,4))){ ?>
                <li class="dropdown-submenu <?php if(in_array($activeTMenu,array('accessList','accessManage'))){ echo 'active'; } ?>">
                    <?php echo $this->Html->link('<span>Employees</span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown' ,'escape'=>false)); ?>
                    <ul class="dropdown-menu">
                        <li <?php if($activeTMenu == 'Employees'){ echo 'class="active"'; } ?> >
                                <?php echo $this->Html->link('<span>Employees Profile</span>',array('controller'=>'SalonStaff','action'=>'index','admin'=>true),array('escape'=>false)); ?>
                        </li>
                        <li <?php if($activeTMenu == 'accessManage'){ echo 'class="active"'; } ?> >
                                <?php echo $this->Html->link('<span>Manage Access Level</span>',array('controller'=>'Groups','action'=>'index','admin'=>true),array('escape'=>false)); ?>
                        </li>
                    </ul>
                </li>
                 <?php }elseif(isset($auth_user) && $auth_user['User']['type']==1){ ?>
                <li <?php if($activeTMenu == 'accessManage'){ echo 'class="active"'; } ?> >
                                <?php echo $this->Html->link('<span>Manage Access Level</span>',array('controller'=>'Groups','action'=>'index','admin'=>true),array('escape'=>false)); ?>
                </li>

                 <?php }?>
                <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(1,3,4))){ ?>
                <li <?php if($activeTMenu == 'treatment'){ echo 'class="active"'; } ?> >

                    <?php if($auth_user['User']['type']==1){ echo $this->Html->link('<span>Services</span>',array('controller'=>'Services','action'=>'treatment','admin'=>true),array('escape'=>false));
                    }else{
                      echo $this->Html->link('<span>Services</span>',array('controller'=>'Business','action'=>'services','admin'=>true),array('escape'=>false));  
                    } ?>
                </li>
                
                 <?php } ?>
                 <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(4))){ ?>
                <li <?php if($activeTMenu == 'pricingLevel'){ echo 'class="active"'; } ?> >
                    <?php echo $this->Html->link('<span>Pricing Level</span>',array('controller'=>'PricingLevel','action'=>'index','admin'=>true),array('escape'=>false)); ?>
                </li>
                 <?php } ?>
               <?php if(isset($auth_user) && $auth_user['User']['type'] == 1){ ?>
                <li class="dropdown-submenu <?php if(in_array($activeTMenu,array('blogCategories','blog'))){ echo 'active'; } ?> ">
                    <?php echo $this->Html->link('<span>Blogs</span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown','escape'=>false)); ?>
                    <ul class="dropdown-menu">
                        <li <?php if($activeTMenu == 'blogCategories'){ echo 'class="active"'; } ?>><?php echo $this->Html->link('<span>Categories</span>',array('controller'=>'blogs','action'=>'categories','admin'=>true),array('escape'=>false)); ?>
                        </li>
                        <li <?php if($activeTMenu == 'blog'){ echo 'class="active"'; } ?> ><?php echo $this->Html->link('<span>Blogs</span>',array('controller'=>'blogs','action'=>'all_blogs','admin'=>true),array('escape'=>false)); ?>
                        </li>
                    </ul>
                </li>
                 <?php } ?>
                <li class="dropdown-submenu <?php if(in_array($activeTMenu,array('productType','brand'))){ echo 'active'; } ?> ">
                    <?php echo $this->Html->link('<span>Inventory</span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown','escape'=>false)); ?>
                    <ul class="dropdown-menu">
                       <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(2,3,4))){ ?>
                        <li <?php if($activeTMenu == 'Inventory'){ echo 'class="active"'; } ?>><?php echo $this->Html->link('<span>Inventory</span>',array('controller'=>'products','action'=>'inventory_management','admin'=>true),array('escape'=>false)); ?>
                        </li>
                        <li <?php if($activeTMenu == 'Vendor'){ echo 'class="active"'; } ?> ><?php echo $this->Html->link('<span>Vendor</span>',array('controller'=>'products','action'=>'vendors','admin'=>true),array('escape'=>false)); ?>
                        </li>
                         <?php }else{ ?>
                        <li <?php if($activeTMenu == 'productType'){ echo 'class="active"'; } ?>><?php echo $this->Html->link('<span>Product Types</span>',array('controller'=>'products','action'=>'list_producttype','admin'=>true),array('escape'=>false)); ?>
                        </li>
                        <li <?php if($activeTMenu == 'brand'){ echo 'class="active"'; } ?> ><?php echo $this->Html->link('<span>Brands</span>',array('controller'=>'products','action'=>'list_brands','admin'=>true),array('escape'=>false)); ?>
                        </li>
                         <?php } ?>
                    </ul>
                </li>
                 <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(3,4,5))){ ?>
                <li class="dropdown-submenu <?php if(in_array($activeTMenu,array('gallery'))){ echo 'active'; } ?> ">
                    <?php echo $this->Html->link('<span>Gallery</span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown','escape'=>false)); ?>
                    <ul class="dropdown-menu">
                        <li <?php if($activeTMenu == 'albums'){ echo 'class="active"'; } ?> >
                                <?php echo $this->Html->link('<span>Gallery</span>',array('controller'=>'Albums','action'=>'index','admin'=>true),array('escape'=>false)); ?>
                        </li>
                        <li <?php if($activeTMenu == 'venueGallery'){ echo 'class="active"'; } ?> >
                                <?php echo $this->Html->link('<span>Venue Gallery</span>',array('controller'=>'Albums','action'=>'venue','admin'=>true),array('escape'=>false)); ?>
                        </li>
                        <li <?php if(($activeTMenu == 'treatmentGallery')){ echo 'class="active"'; } ?> >
                    <?php echo $this->Html->link('<span>Treatment Gallery</span>',array('controller'=>'Services','action'=>'treatment_gallery','admin'=>true),array('escape'=>false)); ?>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php if(isset($auth_user) && $auth_user['User']['type'] == 1){ ?>
                <li <?php if($activeTMenu == 'locationMgt'){ echo 'class="active"'; } ?> >
                    <?php echo $this->Html->link('<span>Country / City mgmt</span>',array('controller'=>'Countries','action'=>'index','admin'=>true),array('escape'=>false)); ?></li>
                <li>
                <?php } ?>
                    <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(4))){ ?>
                <li <?php if($activeTMenu == 'salonAds'){ echo 'class="active"'; } ?> >
                    <?php echo $this->Html->link('<span>Advertisement</span>',array('controller'=>'SalonAds','action'=>'ads','admin'=>true),array('escape'=>false)); ?>
                </li>
                <?php } ?>
                 <li class="dropdown-submenu <?php if(in_array($activeTMenu,array('giftCertificatelist','gftImageManage'))){ echo 'active'; } ?>">
                    <?php echo $this->Html->link('<span>Gift Certificates</span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown' ,'escape'=>false)); ?>
                    <ul class="dropdown-menu">
                        <li <?php if($activeTMenu == 'giftCertificatelist'){ echo 'class="active"'; } ?> >
                            <?php echo $this->Html->link('<span>Management</span>',array('controller'=>'GiftCertificates','action'=>'list','admin'=>true),array('escape'=>false)); ?>
                        </li>
                         <li <?php if($activeTMenu == 'gftImageManage'){ echo 'class="active"'; } ?> >
                            <?php echo $this->Html->link('<span>Design</span>',array('controller'=>'GiftImages','action'=>'list','admin'=>true),array('escape'=>false)); ?>
                        </li>
                    </ul>
                  </li>
                  <li class="dropdown-submenu">
                    <?php echo $this->Html->link('<span>Wizard</span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown' ,'escape'=>false)); ?>
                    <ul class="dropdown-menu">
                        <li>
                            <?php echo $this->Html->link('<span>Business Setup Wizard</span>',"javascript:void(0)",array('escape'=>false,'data-type'=>'business_setup','class'=>'wizardManual')); ?>
                        </li>
                         <li>
                            <?php echo $this->Html->link('<span>Staff Creation Wizard</span>',"javascript:void(0)",array('escape'=>false,'data-type'=>'staff_setup','class'=>'wizardManual')); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('<span>Service Selection Wizard</span>',"javascript:void(0)",array('escape'=>false,'data-type'=>'service_menu','class'=>'wizardManual')); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('<span>Photo/Video Wizard</span>',"javascript:void(0)",array('escape'=>false,'data-type'=>'media_uploader','class'=>'wizardManual')); ?>
                        </li>
                    </ul>
                  </li>
               
                
            </ul>
        </li>
        <?php if(isset($auth_user) && in_array($auth_user['User']['type'],array(3,4,5))){ ?>
         <!--li <?php if(in_array($activeTMenu,array('emailmkt'))){ echo 'class="active"'; } ?> ">
            <?php echo $this->Html->link('<span>Marketing</span><span class="caret"></span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown','escape'=>false)); ?>
            <ul class="dropdown-menu">
                <li <?php if($activeTMenu == 'emailmkt'){ echo 'class="active"'; } ?> >
                        <?php echo $this->Html->link('<span>Email Marketing</span>',array('controller'=>'Marketing','action'=>'email','admin'=>true),array('escape'=>false)); ?>
                </li>
            </ul>
         </li-->
        <?php } ?>
        <!--li <?php if($activeTMenu == 'reports'){ echo 'class="active"'; } ?> >
         <?php echo $this->Html->link('<span>Reports</span><span class="caret"></span>','javascript:void(0);',array('class'=>'dropdown-toggle','data-toggle'=>'dropdown' ,'escape'=>false)); ?>
            <ul class="dropdown-menu">
                <li <?php if($activeTMenu == 'notifications'){ echo 'class="active"'; } ?> >
                <?php echo $this->Html->link('<span>Notifications</span>',array('controller'=>'Notifications','action'=>'index','admin'=>true),array('escape'=>false)); ?>
                </li>
            </ul>
        </li-->
        <li <?php if($activeTMenu == 'dashboard'){ echo 'class="active"'; } ?> >
        <?php echo $this->Html->link('<span>Dashboard</span>',array('controller'=>'Dashboard','action'=>'index','admin'=>true),array('escape'=>false)); ?>
        </li>
        <!--li <?php if($activeTMenu == 'help'){ echo 'class="active"'; } ?> >
        <?php echo $this->Html->link('<span>Help</span>','javascript:void(0)',array('escape'=>false)); ?>
        </li-->
    </ul>
</div>
<script>
    $(document).ready(function(){
        $('.wizardManual').on('click',function(){
            var updateURL = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'wizard_manual','admin'=>false))?>';
            var wizardType = $(this).attr("data-type");
            $.ajax({url:updateURL,type:'POST',data: {update:wizardType} }).done(function(){
									window.location.reload();
								});
            
        })    
        
    })
</script>
