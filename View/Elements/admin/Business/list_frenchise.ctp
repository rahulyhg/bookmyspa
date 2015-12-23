<table class="table table-hover table-nomargin dataTable table-bordered" style="width: 100%">
<thead>
    <tr>
        <th style="width: 13%">Name</th>
        <th style="width: 15%">Email</th>
        <th style="width: 15%">Business Name</th>
        <!--<th style="width: 10%">Business Model</th>-->
        <th style="width: 10%">Business Type</th>
        <th style="width: 10%">Mobile 1</th>
        <th>Mobile Token</th>
        <th>Email Token</th>
        <th style="width: 7%; text-align: center;" align="center" >Frontend Display</th>
        <th style="width: 7%; text-align: center;" align="center" >Status</th>
        <th style="width: 7%; text-align: center;" align="center" >Action</th>
    </tr>
</thead>
<tbody>
    <?php
     if(!empty($businessUsers['frenchise'])){
        foreach($businessUsers['frenchise'] as $key=>$user){
            ?>
            <tr data-id="<?php echo $user['User']['id']; ?>" >
                
                <td><?php echo ucfirst($user['User']['first_name'])." ".ucfirst($user['User']['last_name']); ?></td>
                <td><?php echo $user['User']['email']; ?></td>
                <td><?php echo wordwrap($user['Salon']['eng_name'], 20,"<br>\n",TRUE); ?></td>
               <!-- <td><?php
                        //$userType = $this->Common->businessModal();
                        //$userTypeKeys = array_keys($userType);
                        //$key = array_search($user['User']['type'], array_keys($userType));
                        //echo  $userType[$userTypeKeys[$key]];
                        ?>
                </td>  -->
                <td><?php echo $user['Salon']['business_type']; ?></td>
                
                 <td>
                  <?php
                   $code='';
                    if($user['Address']['country_id']){
                        $code = $this->Common->getPhoneCode($user['Address']['country_id']);
                    }
                    if($user['Contact']['cell_phone']){
                       echo  $code.'-'.$user['Contact']['cell_phone'];
                    }else{
                        echo '-';
                    }
                ?>
                </td>
                <td>
                 <?php
                   $code='';
                    if(!empty($user['User']['is_phone_verified'])){
                        echo 'Verified';
                    } else{
                        if(!empty($user['User']['phone_token'])){
                            echo $user['User']['phone_token'];
                        } else {
                            echo '-';
                        }
                    }
                ?>
                </td>
                <td>
                 <?php
                   $code='';
                    if(!empty($user['User']['is_email_verified'])){
                        echo 'Verified';
                    } else{
                        if(!empty($user['User']['email_token'])){
                            echo $user['User']['email_token'];
                        } else {
                            echo '-';
                        }
                    }
                ?>
                </td>
               <td align="center"><div style="display: none;"><?php echo $user['User']['front_display']; ?></div><?php echo $this->Common->theStatusImage($user['User']['front_display'],'front_display'); ?></td>

                <td align="center"><div style="display: none;"><?php echo $user['User']['status']; ?></div><?php echo $this->Common->theStatusImage($user['User']['status']); ?></td>
                <td align="center">
                    <?php echo $this->Html->link('<i class="fa fa-globe"></i>',array('controller'=>'Place','action'=>'index','admin'=>false,$user['User']['id']),array('title'=>'Frontend View','target'=>'_blank','escape'=>false)); ?>
                    <?php //echo $this->Html->link('<i class="icon-eye-open"></i>',array('controller'=>'Business','action'=>'view','admin'=>true,'bview'=>base64_encode(base64_encode($user['User']['id']).'-CODE-'.$user['User']['username'])), array('title'=>'View','class'=>'view_User','escape'=>false) ); ?>
                    
                    <?php // ?>
                    &nbsp;&nbsp;
                    <?php echo $this->Html->link('<i class="icon-trash"></i>', "javascript:void(0)", array('title'=>'Delete','data-id'=>base64_encode($user['User']['id']),'data-salon_type'=>'frenchise','class'=>'delete','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php 
                    if($typeId==1 && $user['User']['status'] == 1 &&  $user['User']['is_phone_verified'] == 1 && $user['User']['is_email_verified'] == 1){
                        echo $this->Html->link('<i class="fa fa-sign-in"></i>',array('controller'=>'Dashboard','action'=>'force_login','admin'=>true,  base64_encode($user['User']['id'])),array('title'=>'Login','escape'=>false));
                    } else {
                        echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('title'=>'Edit','data-id'=>base64_encode($user['User']['id']),'class'=>'addedit_Business','escape'=>false) );
                    }
                    
                    ?>
                </td>
            </tr>    
        <?php
            }
    }?>
</tbody>

</table>