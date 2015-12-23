    <div class="add-heading"><?php echo __('ADVERTISEMENTS',true);?></div>
    <?php if(count($banner_list)>0){ ?>
        <?php foreach($banner_list as $banner_list){ ?>
            <div class="advertisement"><?php echo $this->Html->Image('/images/'.$banner_list['SalonAd']['user_id'].'/SalonAd/800/'.$banner_list['SalonAd']['image']); ?></div>
        <?php }
    }else{
        echo "No Add found";
    } ?>
    