<ul class="nav nav-tabs" role="tablist">
    <?php
        $li_class = '';
        if($this->params['controller'] == 'users' && $this->params['action'] == 'admin_appointments'){
            $li_class = 'active';
        }else if($this->params['controller'] == 'Users' && $this->params['action'] == 'admin_manage' ){
            $li_class = 'active';
        }else{
            $li_class = '';
        }
    ?>
    <li role="presentation" class="<?php echo $li_class; ?>">
        <?php echo $this->Js->link('Appointment',array('controller'=>'users','action'=>'appointments','admin'=>true , $customer_id),array('update' => '#user_elements'));?>
    </li>
    <?php
        $li_class = '';
        if($this->params['controller'] == 'users' && $this->params['action'] == 'admin_iou_details'){
              $li_class = 'active';
        }
    ?>
    <li role="presentation" class="<?php echo $li_class;?>">
        <?php echo $this->Js->link('IOU',array('controller'=>'users','action'=>'iou_details','admin'=>true , $customer_id),array('update' => '#user_elements'));?>
    </li>
    <?php
        $li_class = '';
        if($this->params['controller'] == 'users' && $this->params['action'] == 'admin_giftcertificates'){
              $li_class = 'active';
        }
    ?>
    <li role="presentation" class="<?php echo $li_class;?>">
        <?php echo $this->Js->link('GIFT CERTIFICATE',array('controller'=>'users','action'=>'giftcertificates','admin'=>true , $customer_id),array('update' => '#user_elements'));?>
    </li>
    
    
    <?php
        $li_class = '';
        if($this->params['controller'] == 'users' && $this->params['action'] == 'admin_spabreaks'){
              $li_class = 'active';
        }
    ?>
    <li role="presentation" class="<?php echo $li_class;?>">
        <?php echo $this->Js->link('SPA BREAK',array('controller'=>'users','action'=>'spabreaks','admin'=>true , $customer_id),array('update' => '#user_elements'));?>
    </li>
    <?php
        $li_class = '';
        if($this->params['controller'] == 'Customers' && $this->params['action'] == 'admin_evoucher_redeem'){
              $li_class = 'active';
        }
    ?>
    <li role="presentation" class="<?php echo $li_class;?>" id="eVoucherTab">
        <?php echo $this->Js->link('Evoucher',array('controller'=>'Customers','action'=>'admin_evoucher_redeem','admin'=>true , $customer_id),array('update' => '#user_elements'));?>
    </li>
    
</ul>