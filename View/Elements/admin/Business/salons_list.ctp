<table class="table table-hover table-nomargin dataTable table-bordered" style="width: 100%">
<thead>
    <tr>
        <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>Business Name</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
    <?php
    if(!empty($salonList)){
        foreach($salonList as $user){ ?>
            <tr data-id="<?php echo $user['User']['id']; ?>">
                <td><?php echo $user['User']['username']; ?></td>
                <td><?php echo ucfirst($user['User']['first_name'])." ".ucfirst($user['User']['last_name']); ?></td>
                <td><?php echo $user['User']['email']; ?></td>
                <td><?php echo $user['Salon']['eng_name']; ?></td>
                <td>
                  <?php echo $user['Contact']['cell_phone']; ?>
                </td>
                <td><?php echo $this->Common->theStatusImage($user['User']['status']); ?></td>
                <td>
                    <?php echo $this->Html->link('<i class="icon-eye-open"></i>',array('controller'=>'Business','action'=>'view','admin'=>true,'bview'=>base64_encode(base64_encode($user['User']['id']).'-CODE-'.$user['User']['username'])) , array('title'=>'View','class'=>'view_User','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('title'=>'Edit','data-id'=>base64_encode($user['User']['id']),'class'=>'addedit_Business','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php echo $this->Html->link('<i class="icon-trash"></i>', array('controller'=>'Users','action'=>'deleteUser','admin'=>true,base64_encode($user['User']['id']),ucfirst($user['User']['username'])) , array('title'=>'Delete','class'=>'delete','escape'=>false),' Are you sure, you want to delete this User ? ' ); ?>
                </td>
            </tr>    
        <?php
            }
    }?>
</tbody>

<tfoot>
<tr>
        <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>Business Name</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Action</th>
</tr>
</tfoot>
</table>