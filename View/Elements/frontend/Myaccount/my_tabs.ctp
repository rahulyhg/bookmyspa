<div class="main-nav clearfix inner-appt">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3">
	    <span class="sr-only">Toggle navigation</span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	</button>
    <nav class="collapse" id="bs-example-navbar-collapse-3">
        <ul class="nav navbar">
        <?php
            $li_class = '';
            //pr($this->params['controller']);exit;
            if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'appointments'){
                  $li_class = 'active';
            }
            ?>
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Appointment',true),'/Myaccount/appointments/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'orders'){
                  $li_class = 'active';
            }?>
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('My Orders',true),'/Myaccount/orders/',array('update' => '#update_ajax'));?>
            </li>
            <?php $li_class = '';
            if($this->params['controller'] == 'users'  && $this->params['action'] == 'spabreaks'){
                  $li_class = 'active';
            }?>
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Spa Breaks',true),'/users/spabreaks/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'bookmarks'){
                  $li_class = 'active';
            }?>
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Bookmarks',true),'/Myaccount/bookmarks/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'reviews'){
                  $li_class = 'active';
            }?>
            
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Reviews',true),'/Myaccount/reviews/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'points'){
                  $li_class = 'active';
            }
            ?>
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Points',true),'/Myaccount/points/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'gifts'){
                  $li_class = 'active';
            }?>
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Gift Certificates',true),'/Myaccount/gifts/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'products'){
                  $li_class = 'active';
            }?>
	     <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Products',true),'/Myaccount/products/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'salon_updates'){
                  $li_class = 'active';
            }?>
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Salon Updates',true),'/Myaccount/salon_updates/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'users'  && $this->params['action'] == 'AccountManagement'){
                  $li_class = 'active';
            }
            ?>
             <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__('Profile',true),'/Users/AccountManagement/',array('update' => '#update_ajax'));?>
            </li>
        </ul>
    </nav>
</div>

