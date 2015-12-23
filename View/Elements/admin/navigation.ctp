<div class="collapse navbar-collapse navbar-ex1-collapse">    
    <ul class="nav navbar-nav side-nav">
        
        <?php  $links = $this -> requestAction(array('controller' => 'admins','action' => 'getAllLinks'));   ?>
        <?php // print_r($links); ?>
        <?php foreach($links as $linkData){ 
			/*
				echo $this->params['controller'].'--'.$this->params['action'];
				echo $linkData['Controller'].'||||||'.$linkData['Action'];
			*/
              //  print_r($linkData);die;
                if(($linkData['Controller'] == $this->params['controller']) && ($linkData['Action'] == $this->params['action'])){
                    $activeStatus ="active";
                }else{
                    $activeStatus =""; 
                }
                $action =str_replace("admin_","",$linkData['Action']);
                $name =str_replace("Manage","",$linkData['Name']);
        ?>
		<li class= "<?php echo $activeStatus; ?>">
			<?php echo $this->Html->link($this->Html->image("admin/table.png").' '.$name,array('controller'=> $linkData['Controller'],'action'=>$action),array('escape' =>false,$linkData['Name']));?>        
        </li>
        <?php } ?>
        
    
        
    </ul>
    <ul class="nav navbar-nav navbar-right navbar-user">        
      <li class="dropdown user-dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $loggedUserInfo['first_name'].' '.$loggedUserInfo['last_name'];?> <b class="caret"></b></a>              
        <ul class="dropdown-menu">
            
            <!--
            <li>
				<?php //echo $this->Html->link($this->Html->image("admin/user.png", array("alt" => "Profile","title" => "Profile")).'  Profile','/admin/admins/addedit/me',array('escape' =>false,'title' => 'Profile'));?>  
            </li>
            -->
            <li>
            
             <?php echo $this->Html->link($this->Html->image("admin/change-password.png", array("alt" => "Change Password","title" => "Change Password")).'  Change Password','/admin/admins/changepassword/',array('escape' =>false,'title' => 'Change Password'));?>
             
             
           </li>
            
            
            
            <li class="divider"></li>
            <li>
            
            <?php echo $this->Html->link($this->Html->image("admin/sign-out.png", array("alt" => "Logout","title" => "Logout")).'  Logout','/admin/admins/logout/',array('escape' =>false,'title' => 'Logout'));?>  
            </li>                
        </ul>
      </li>
    </ul>
</div><!-- /.navbar-collapse -->