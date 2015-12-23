<table class="table table-hover table-nomargin dataTable table-bordered">
<thead>
    <tr>
       
        <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile 1</th>
        <th>Created</th>
        <th>Created By</th>
        <th align="center" style="text-align: center;">Status</th>
        <th align="center" style="text-align: center;">Action</th>
    </tr>
</thead>
<tbody>
    <?php if(!empty($users)){
        $i=1;
        //pr($users); die;
        foreach($users as $user){ ?>
            <tr data-id="<?php echo $user['User']['id']; ?>" >
              
                <td><?php echo $user['User']['username']; ?></td>
                <td><?php echo ucfirst($user['User']['first_name'])." ".ucfirst($user['User']['last_name']); ?></td>
                <td><?php echo $user['User']['email']; ?></td>
                <td>
                <?php
                    $code='+971';
                    if(isset($user['Contact']['country_code']) && !empty($user['Contact']['country_code'])){
                     $code =  $user['Contact']['country_code'];
                    }
                    
                     if(isset($user['Address']['country_id']) && !empty($user['Address']['country_id'])){
                         $code = $this->Common->getPhoneCode($user['Address']['country_id']);
                         $code  = ($code)?$code:'';
                     }
                     if(isset($user['Contact']['cell_phone']) && !empty($user['Contact']['cell_phone'])){
                        echo  $code.'-'.$user['Contact']['cell_phone'];
                     }else{
                         echo '';
                     }
                ?>
                </td>
                <td> <?php echo $this->common->getDateFormat($user['User']['created']); ?></td>
                <td><?php echo $this->common->getParentName($user['User']['created_by']); ?></td>
                <?php if($parentID==1){?>
                     <td align="center"><span style="display: none"><?php echo $user['User']['status']; ?></span><?php echo $this->Common->theStatusImage($user['User']['status']); ?></td>
                 <?php }else{
                    if($user['User']['status'] == 1){ ?>
                        <td align="center"><span style="display: none"><?php echo $user['User']['status']; ?></span><a class="noPermission" title="You dont't have permissions to Deactivate this customer." href="javascript:void(0);"><i class="fa fa-check grey"></i></a></td>
                    <?php }else{ ?>
                        <td align="center"><span style="display: none"><?php echo $user['User']['status']; ?></span><a class="noPermission" title="You dont't have permissions to Activate this customer." href="javascript:void(0);"><i class="icon-remove grey"></i></a></td>
                    <?php }
                } ?>
                <td  align="center">
                    <?php echo $this->Html->link('<i class="icon-eye-open"></i>',array('controller'=>'Users','action'=>'manage','admin'=>true,'enc'=>base64_encode(base64_encode($user['User']['id']).'-CODE-'.$user['User']['username'])) , array('title'=>'View','class'=>'view_User','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php if($user['User']['created_by']==$parentID or  $parentID==1){?>
                    <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('title'=>'Edit','data-id'=>base64_encode($user['User']['id']),'class'=>'addedit_User','escape'=>false) ); ?>
                    <?php }else{ ?>
                    <a class="noPermission" title="You dont't have permission to edit this customer." href="javascript:void(0);"><i class="icon-remove grey"></i></a>
                    <?php } ?>
                    &nbsp;&nbsp;
                   <!-- this functionality is commented for now ----->
                    <?php echo $this->Html->link('<i class="icon-trash"></i>', 'javascript:void(0)' , array('data-salon_id'=>$_SESSION['Auth']['User']['id'],'data-uid'=>$user['User']['id'],'title'=>'Delete','class'=>'delete del_user','escape'=>false)); ?>
                 <!-- this functionality is commented for now ----->
        
                </td>
            </tr>    
        <?php $i++; }
    }?>
</tbody>

</table>