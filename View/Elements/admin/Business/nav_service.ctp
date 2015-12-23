<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" <?php echo (isset($navActive) &&  $navActive == 'service')? 'class="active"':''; ?> >
        <?php echo $this->Html->link('SERVICES (<span class="service_count">'.$this->Common->getCount($auth_user['User']['id'],'SalonService').'</span>)', array('controller'=>'Business','action'=>'services','admin'=>true),array('escape'=>false)); ?>
    </li>
    <li role="presentation"  <?php echo (isset($navActive) &&  $navActive == 'package')? 'class="active"':''; ?> >
	<?php echo $this->Html->link('Packages (<span class="package_count">'.$this->Common->getCount($auth_user['User']['id'],'Package').'</span>)', array('controller'=>'Business','action'=>'packages','admin'=>true),array('escape'=>false)); ?>
    </li>
    <li role="presentation"  <?php echo (isset($navActive) &&  $navActive == 'spaday')? 'class="active"':''; ?> >
        <?php echo $this->Html->link('SPA Day <span>(<span class="package_count">'.$this->Common->getCount($auth_user['User']['id'],'Package','spaday').'</span>)</span>', array('controller'=>'Business','action'=>'spaday','admin'=>true),array('escape'=>false)); ?>
    </li>
    <li role="presentation"  <?php echo (isset($navActive) &&  $navActive == 'spabreak')? 'class="active"':''; ?> >
        <?php echo $this->Html->link('SPA Break (<span class="spabreak_count">'.$this->Common->getCount($auth_user['User']['id'],'Spabreak').'</span>)', array('controller'=>'Business','action'=>'spabreak','admin'=>true),array('escape'=>false)); ?>
    </li>
    <li role="presentation" <?php echo (isset($navActive) &&  $navActive == 'deals')? 'class="active"':''; ?> >
	<?php echo $this->Html->link('DEALS (<span class="service_count">'.$dealCount.'</span>)', array('controller'=>'Business','action'=>'deals','admin'=>true),array('escape'=>false)); ?>
    </li>
</ul>
