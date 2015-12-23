<table class="table table-hover table-nomargin dataTable table-bordered" style="width: 100%">
        <thead>
            <tr>
                <!--<th>Username</th>-->
                <th>Name</th>
                <th>Email</th>
                <th>Business Name</th>
                <th>Business Model</th>
                <th>Business Type</th>
                <th>Email Verified</th>
                <th>SMS Verified</th>
                <th>Phone</th>
        <th align="center" style="text-align: center;">Frontend Display</th>

                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!empty($Users)){
                foreach($Users as $user){
                    //pr($user);
                    $businessType = array();  ?>
                  
                    <tr data-id="<?php echo $user['User']['id']; ?>" >
                       <!-- <td><?php //echo $user['User']['username']; ?></td>-->
                        <td><?php echo ucfirst($user['User']['first_name'])." ".ucfirst($user['User']['last_name']); ?></td>
                        <td><?php echo $user['User']['email']; ?></td>
                        <td><?php echo $user['Salon']['eng_name']; ?></td>
                        <td><?php
                               $userType = $this->Common->businessModal();
                               $userTypeKeys = array_keys($userType);
                               $key = array_search($user['User']['type'], array_keys($userType));
                               echo  $userType[$userTypeKeys[$key]];
                               ?>
                        </td>
                        <td>
                            <?php
                            if(!empty($user['Salon']['business_type_id']))
                                $businessTypeIds = unserialize($user['Salon']['business_type_id']);
                                foreach($bTypes as $key=>$bType){
                                    if(in_array($key,$businessTypeIds)){
                                        //echo 'dsf';
                                        $businessType[$key]= $bType;
                                    }
                                }
                                //pr($businessType);
                            echo  implode(', ',$businessType); ?>
                        </td>
                        <td><?php if($user['User']['is_email_verified'] == 1){ echo "Yes";}else{ echo  "No"; } ?></td>
                        <td><?php if($user['User']['is_phone_verified'] == 1){ echo "Yes";}else{ echo  "No"; } ?></td>
                        <td><?php echo $user['Contact']['cell_phone']; ?></td>
			<td align="center"><div style="display: none;"><?php echo $user['User']['front_display']; ?></div><?php echo $this->Common->theStatusImage($user['User']['front_display'],'front_display'); ?></td>

                        <td><?php echo $this->Common->theStatusImage($user['User']['status']); ?></td>
                        <td>
                            <?php if($type_of == 2){}else{ ?>
                                &nbsp;&nbsp;
                            <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('title'=>'Edit','data-id'=>base64_encode($user['User']['id']),'data-type'=>'salon','class'=>'addedit_Business','escape'=>false) ); ?>
                            <?php echo $this->Html->link('<i class="icon-eye-open"></i>',array('controller'=>'Business','action'=>'view','admin'=>true,'bview'=>base64_encode(base64_encode($user['User']['id']).'-CODE-'.$user['User']['username'])), array('title'=>'Edit','class'=>'view_User','escape'=>false,'id'=>'view_'.$user['User']['id']) ); ?>

                            <?php } ?>
                            &nbsp;
                            <?php //echo $this->Html->link('<i class="icon-trash"></i>', 'javascript:void(0)', array('data-id'=>$user['User']['id'],'title'=>'Delete','class'=>'delete_user','escape'=>false)); ?>
                            <?php if($type_of == 2 && $user['User']['status'] == 1 &&  $user['User']['is_phone_verified'] == 1 && $user['User']['is_email_verified'] == 1){ ?>
                                &nbsp;&nbsp;
                                <?php echo $this->Html->link('<i class="fa fa-sign-in"></i>',array('controller'=>'Dashboard','action'=>'force_login','admin'=>true,  base64_encode($user['User']['id'])),array('title'=>'Login','escape'=>false)); ?>
                                &nbsp;&nbsp;
                                <?php echo $this->Html->link('<i class="fa fa-globe"></i>',array('controller'=>'Place','action'=>'index','admin'=>false,$user['User']['id']),array('title'=>'Frontend View','target'=>'_blank','escape'=>false)); ?>
                           <?php  }else{
                                 echo '&nbsp;&nbsp;'.$this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('title'=>'Edit','data-id'=>base64_encode($user['User']['id']),'data-type'=>'salon','class'=>'addedit_Business','escape'=>false) ); 
                                } ?>

                        </td>
                    </tr>    
                <?php
                    }
            }?>
            </tbody>
            <!--tfoot>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Business Name</th>
                    <th>Business Model</th>
                    <th>Business Type</th>
                <th>Email Verified</th>
                <th>SMS Verified</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot-->
</table>   
            