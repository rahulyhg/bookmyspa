<!----------- Created by Ramanpreet -------------->
<?php
//echo '<hr>';
//pr($this->params);
//exit;

$policy_details = $this->requestAction('/Place/salon_isgiftcertificate/'.$salonId);
?>
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-salonPage-navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
</button>
<ul class="mob_new_nav">
     <?php
      $stylistId = $this->Session->read('FRONT_SESSION.salon_stylist_id');
                $addLink = '';
                if($stylistId){
                  $addLink = '/'.base64_encode($stylistId);
                }
            $li_class = '';
            if($this->params['controller'] == 'Place' && $this->params['action'] == 'salongallery'){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?> sp_m_4' role="presentation">
                <?php echo $this->Js->link(__('gallery',true),'/Place/salongallery/'.$salonId,array('update' => '#update_ajax'));?>
            </li>
      <?php
            $li_class = '';
            if($this->params['controller'] == 'SalonStaff' && $this->params['action'] == 'salonStaff'){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?> sp_m_3' role="presentation">
                <?php echo $this->Js->link(__('our_staff',true),'/SalonStaff/salonStaff/'.$salonId,array('update' => '#update_ajax'));?>
            </li> 
     <?php
            $li_class = '';
            if(($this->params['controller'] == 'Place' && $this->params['action'] == 'spabreaks') || ($this->params['controller'] == 'Place' && $this->params['action'] == 'showSpaBreak')){
                  $li_class = 'active';
            }?>
             <li class = '<?php echo $li_class;?> sp_m_3' role="presentation">
                <?php echo $this->Js->link(__('spa break',true),'/Place/spabreaks/'.$salonId,array('update' => '#update_ajax'));?>
            </li>
      <?php
            $li_class = '';
            if((($this->params['controller'] == 'Place' && $this->params['action'] == 'salonspaday')|| ($this->params['controller'] == 'packagebooking' && $this->params['action'] == 'showPackage' && isset($this->params['type']) && $this->params['type']=='Spaday')) && $this->params['deal'] != true){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?> sp_m_2' role="presentation">
                <?php echo $this->Js->link(__('spa day',true),'/Place/salonspaday/'.$salonId.$addLink,array('update' => '#update_ajax'));?>
            </li>
    <?php
            $li_class = '';
            if((($this->params['controller'] == 'Place' && $this->params['action'] == 'salonpackages') || ($this->params['controller'] == 'packagebooking' && $this->params['action'] == 'showPackage' && isset($this->params['type']) && $this->params['type']=='Package')) && $this->params['deal'] != true){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?> sp_m_1' role="presentation">
                <?php echo $this->Js->link(__('package',true),'/Place/salonpackages/'.$salonId.$addLink,array('update' => '#update_ajax'));?>
            </li>
        <?php
            $li_class = '';
            
            if(($this->params['controller'] == 'Place' && $this->params['action'] == 'salondeals') || $this->params['deal'] == true){
                  $li_class = 'active';
            }?>
              <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('deals',true).' <i class="fa fa-clock-o"></i>','/Place/salondeals/'.$salonId.$addLink,array('escape'=>false,'update' => '#update_ajax'));?>
            </li>
      <?php
            $li_class = '';
            if((($this->params['controller'] == 'Place' && $this->params['action'] == 'salonservices') ||
               ($this->params['controller'] == 'Bookings' && $this->params['action'] == 'showService')
               ) && $this->params['deal'] != true){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?>' role="presentation">
                <?php
               
                echo $this->Js->link(__('services',true),'/Place/salonservices/'.$salonId.$addLink,array('update' => '#update_ajax'));?>
            </li>
      <?php
            // echo $this->params['deal']."hello";
            $li_class = '';
            if($this->params['controller'] == 'Place' && $this->params['action'] == 'index'){
                  $li_class = 'active';
            } ?>
            <li role="presentation" class="<?php echo $li_class;?>">
            <?php echo $this->Js->link(__('about',true),'/Place/index/'.$salonId,array('update' => '#update_ajax'));?>
            </li>
</ul> 

<nav class="collapse" id="bs-salonPage-navbar">
      <ul class="nav navbar" role="tablist">
            <?php
            // echo $this->params['deal']."hello";
            $li_class = '';
            if($this->params['controller'] == 'Place' && $this->params['action'] == 'index'){
                  $li_class = 'active';
            } ?>
            <li role="presentation" class="<?php echo $li_class;?>">
            <?php echo $this->Js->link(__('about',true),'/Place/index/'.$salonId,array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if((($this->params['controller'] == 'Place' && $this->params['action'] == 'salonservices') ||
               ($this->params['controller'] == 'Bookings' && $this->params['action'] == 'showService')
               ) && $this->params['deal'] != true){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?>' role="presentation">
                <?php
                $stylistId = $this->Session->read('FRONT_SESSION.salon_stylist_id');
                $addLink = '';
                if($stylistId){
                  $addLink = '/'.base64_encode($stylistId);
                }
                echo $this->Js->link(__('services',true),'/Place/salonservices/'.$salonId.$addLink,array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            
            if(($this->params['controller'] == 'Place' && $this->params['action'] == 'salondeals') || $this->params['deal'] == true){
                  $li_class = 'active';
            }?>
              <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('deals',true).' <i class="fa fa-clock-o"></i>','/Place/salondeals/'.$salonId.$addLink,array('escape'=>false,'update' => '#update_ajax'));?>
            </li>
            
            <?php
            $li_class = '';
            if((($this->params['controller'] == 'Place' && $this->params['action'] == 'salonpackages') || ($this->params['controller'] == 'packagebooking' && $this->params['action'] == 'showPackage' && isset($this->params['type']) && $this->params['type']=='Package')) && $this->params['deal'] != true){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('package',true),'/Place/salonpackages/'.$salonId.$addLink,array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if((($this->params['controller'] == 'Place' && $this->params['action'] == 'salonspaday')|| ($this->params['controller'] == 'packagebooking' && $this->params['action'] == 'showPackage' && isset($this->params['type']) && $this->params['type']=='Spaday')) && $this->params['deal'] != true){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('spa day',true),'/Place/salonspaday/'.$salonId.$addLink,array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if(($this->params['controller'] == 'Place' && $this->params['action'] == 'spabreaks') || ($this->params['controller'] == 'Place' && $this->params['action'] == 'showSpaBreak')){
                  $li_class = 'active';
            }?>
             <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('spa break',true),'/Place/spabreaks/'.$salonId,array('update' => '#update_ajax'));?>
            </li>
            <?php
            $li_class = '';
            if($this->params['controller'] == 'SalonStaff' && $this->params['action'] == 'salonStaff'){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('our_staff',true),'/SalonStaff/salonStaff/'.$salonId,array('update' => '#update_ajax'));?>
            </li> 
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Place' && $this->params['action'] == 'salongallery'){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('gallery',true),'/Place/salongallery/'.$salonId,array('update' => '#update_ajax'));?>
            </li>
            <?php if(!empty($policy_details) && ($policy_details['PolicyDetail']['enable_gfvocuher']==1)){
            $li_class = '';
            if($this->params['controller'] == 'Place' && $this->params['action'] == 'salongiftcertificate'){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('gift_certificate',true),'/Place/salongiftcertificate/'.$salonId,array('update' => '#update_ajax'));?>
            </li>
            <?php } ?>
            
            
            <?php
            $li_class = '';
            if($this->params['controller'] == 'Reviews' && $this->params['action'] == 'salonreviews'){
                  $li_class = 'active';
            }?>
            <li class = '<?php echo $li_class;?>' role="presentation">
                <?php echo $this->Js->link(__('Review',true),'/Reviews/salonreviews/'.$salonId,array('update' => '#update_ajax','class'=>'ReviewClass'));?>
            </li> 
            
            
            
      </ul>
</nav>