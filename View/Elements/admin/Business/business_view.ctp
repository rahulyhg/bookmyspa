<div class="row">
        <div class="col-sm-2">
            <?php echo  $this->Html->link(__('Edit'),'javascript:void(0);',array('data-id'=>$user['User']['id'],'class'=>'editUImg','style'=>'float:left;width:50%')); ?>
            <?php echo  $this->Html->link(__('Delete'),'javascript:void(0);',array('data-id'=>$user['User']['id'],'class'=>'deleteUImg','style'=>'float:left;width:50%')); ?>
       
              <?php if(isset($user['User']['image']) && !empty($user['User']['image']) ){
                    echo $this->Html->image("/images/".$user['User']['id']."/User/150/".$user['User']['image'],array('data-id'=>$user['User']['id']));
                }else{
                    echo $this->Html->image("admin/upload2.png",array('class'=>'upUImg','data-id'=>$user['User']['id']));
                }?>
                <?php
                echo $this->Form->input('image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'class'=>'theImage'));
                ?>
        </div>
        <div class="span10 cover">
             <?php if(isset($user['Salon']['cover_image']) && !empty($user['Salon']['cover_image']) ){
                echo $this->Html->image("/images/".$user['User']['id']."/Salon/800/".$user['Salon']['cover_image'],array('data-id'=>$user['User']['id']));
            }else{
                //echo $this->Html->image("admin/upload2.png",array('class'=>'upUImg','data-id'=>$user['User']['id']));
            }?>
            <?php
            echo $this->Form->input('Salon.cover_image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'class'=>'theImage'));
            ?>
        </div>
</div>
<div class="col-sm-2"></div>
<div class="col-sm-3">
    <h4>
       Personal Info
    </h4>
    <dl class="dl-horizontal">
        <dt>Username</dt>
        <dd><?php echo $user['User']['username'];?></dd>
        <dt>First Name</dt>
        <dd><?php echo ucfirst($user['User']['first_name']);?></dd>
        <dt>Last Name</dt>
        <dd><?php echo ucfirst($user['User']['last_name']);?></dd>
        <dt>Email</dt>
        <dd><?php echo $user['User']['email'];?></dd>
        <dt>Address</dt>
        <dd>
            <?php echo $user['Address']['address'];?><br>
            <?php echo ucfirst($user['Address']['area']);?>
        </dd>
        <dt>Birthdate</dt>
        <dd><?php
                if($user['UserDetail']['dob']){
                        echo $user['UserDetail']['dob'];
                }else{
                        echo '-';
                }
            ?>
        </dd>
        <dt>Mobile 1</dt>
        <dd>
           <?php
                if($user['Contact']['cell_phone']){
                        echo $user['Contact']['cell_phone'];
                }else{
                        echo '-';
                }
            ?>
        </dd>
        <dt>Mobile 2</dt>
        <dd><?php
                if($user['Contact']['day_phone']){
                        echo $user['Contact']['day_phone'];
                }else{
                        echo '-';
                }
            ?>
        </dd>
        <dt>Mobile 3</dt>
        <dd><?php
                if($user['Contact']['night_phone']){
                        echo $user['Contact']['night_phone'];
                }else{
                        echo '-';
                }
            ?>
        </dd>
    </dl>
</div>
<div class="col-sm-3">
    <h4>
        Business Profile
    </h4>
    <dl class="dl-horizontal">
        <dt>Business Name</dt>
        <dd><?php echo $user['Salon']['eng_name'];?></dd>
        <dt>Business Description</dt>
        <dd><?php echo $user['Salon']['eng_description'];?></dd>
        <dt>Current Website </dt>
        <dd><?php echo $user['Salon']['website_url'];?></dd>
        <dt>Sieasta URL</dt>
        <dd>
          <?php   $business_url =  ($user['Salon']['business_url'] !='')?$user['Salon']['business_url']:$user['User']['username'];
                            echo Configure::read('BASE_URL').'/'.$business_url; ?>
           </dd>
    </dl>
</div>
