<div class="row">
    <div class="">
<?php if(isset($auth_user) && $auth_user['User']['type'] == 1){ ?>
        <ul class="tiles">
            <li class="orange high long">
                <?php echo $this->Html->link('<span class="count"><i class="glyphicon-table"></i> </span><span class="name">Payment Plans</span>',array('controller'=>'Payments','action'=>'plans','admin'=>true,'email'),array('escape'=>false)); ?>
            </li>
            <li class="blue">
                <?php echo $this->Html->link('<span><i class="glyphicon-blog"></i></span><span class="name">Blog</span>',array('controller'=>'blogs','action'=>'all_blogs','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li class="red">
                <?php echo $this->Html->link('<span class="count"><i class="icon-user"></i> </span><span class="name">Customers</span>',array('controller'=>'Users','action'=>'list','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li class="lime">
                <?php echo $this->Html->link('<span class="count"><i class="icon-cogs"></i> </span><span class="name">General Settings</span>',array('controller'=>'Settings','action'=>'email_setting','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li class="blue">
               <?php echo $this->Html->link('<span class="count"><i class="icon-user"></i></span><span class="name">My Profile</span>',array('controller'=>'users','action'=>'editProfile','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li class="blue long">
                <?php echo $this->Html->link('<span class="count"><i class="glyphicon-book_open"></i><span class="name">CMS Pages</span>',array('controller'=>'StaticPages','action'=>'pages','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li class="green long">
                <?php echo $this->Html->link('<span class="count"><i class="glyphicon-e-mail"></i><span class="name">Email Templates</span>',array('controller'=>'Emailtemplates','action'=>'index','admin'=>true),array('escape'=>false)); ?>
            </li>
            <li class="brown">
                <?php echo $this->Html->link('<span class="count"><i class="icon-group"></i><span class="name">Access Levels</span>',array('controller'=>'groups','action'=>'index','admin'=>true),array('escape'=>false)); ?>
            </li>
          </ul>   
    <?php } else if(isset($auth_user) && $auth_user['User']['type'] == 2){ ?>
        <div class="col-sm-12">
            <?php if(!empty($getSalonData)){ 
?>
                <?php foreach($getSalonData as $salon_data) { ?>

                        <div class="col-sm-3">							
                            <div class="saloon-dash-box">
                        <div class="saloon-logo">
                        <?php
			//pr($salon_data);
			if($salon_data['Salon']['cover_image'] != '') { ?>
                        <?php echo $this->Html->image('/images/'.$salon_data['Salon']['user_id'].'/Salon/150/'.$salon_data['Salon']['cover_image']); ?>
                        <?php }else{
                                echo $this->Html->image('/img/noimage.jpeg' ,array('style'=>'width:195px;height:132px'));
                        ?>
                        <?php } ?>
                        </div>
                    <div class="saloon-bottom">
			<div class="info">
			    <span><?php
				    echo strtoupper($salon_data['Salon']['eng_name']);
				?>
			    </span>
			</div>
			<div class="enter-btn">
			    <?php echo $this->Html->link('<button type="button" class="primary-btn">Login</button>',array('controller'=>'Dashboard','action'=>'force_login','admin'=>true,base64_encode($salon_data['Salon']['user_id'])),array('escape'=>false)); ?>
			</div>
                    </div>
                                    </div></div>

            <?php } ?>
            
          <?php  } ?>
          </div>
       <?php } ?>
   </div> 
   </div>
  