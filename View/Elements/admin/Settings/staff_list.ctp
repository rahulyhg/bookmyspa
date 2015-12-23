<?php if(!isset($emptyUser)){?>
<table class="table table-hover table-nomargin dataTable table-bordered">
<thead>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Emp Type</th>
        <th>Pricing Level</th>
    </tr>
</thead>
<tbody>
    <?php if(!empty($auth_user)){ ?>
        <tr data-id="<?php echo $auth_user['User']['id']; ?>" >
            <td>
                <?php if(isset($auth_user['User']['image']) && !empty($auth_user['User']['image'])){
                        echo $this->Html->image('/images/'.$auth_user['User']['id'].'/User/50/'.$auth_user['User']['image'],array());
                }else{
                    echo "NA";
                } ?>
            </td>
            <td><?php echo ucfirst($auth_user['User']['first_name'])." ".ucfirst($auth_user['User']['last_name']); ?></td>
            <td><?php echo $auth_user['User']['email']; ?></td>
            <td><?php
                $code='+971';
                if(isset($auth_user['Contact']['country_code']) && !empty($auth_user['Contact']['country_code'])){
                 $code =  $auth_user['Contact']['country_code'];
                }
                
                 if(isset($auth_user['Address']['country_id']) && !empty($auth_user['Address']['country_id'])){
                     $code = $this->Common->getPhoneCode($auth_user['Address']['country_id']);
                     $code  = ($code)?$code:'';
                 }
                 if(isset($auth_user['Contact']['cell_phone']) && !empty($auth_user['Contact']['cell_phone'])){
                    echo  $code.'-'.$auth_user['Contact']['cell_phone'];
                 }else{
                     echo '';
                 }
            ?></td>
            <td><?php echo ucfirst($auth_user['UserDetail']['gender']); ?></td>
            <td><?php echo $this->Common->get_access_level_name($auth_user['User']['group_id']); ?> </td>
            <td><?php echo $this->Common->get_price_level_name($auth_user['User']['id']); ?> </td>
        </tr>   
    <?php }?>
    <?php if(!empty($staffList)){
        foreach($staffList as $staffListdata){ ?>
            <tr data-id="<?php echo $staffListdata['User']['id']; ?>">
            <td>
                <?php if(isset($staffListdata['User']['image']) && !empty($staffListdata['User']['image'])){
                        echo $this->Html->image('/images/'.$staffListdata['User']['id'].'/User/50/'.$staffListdata['User']['image'],array());
                }else{
                    echo "NA";
                } ?>
            </td>
            <td><?php echo ucfirst($staffListdata['User']['first_name'])." ".ucfirst($staffListdata['User']['last_name']); ?></td>
            <td><?php echo $staffListdata['User']['email']; ?></td>
            <td><?php
                $code='+971';
                if(isset($staffListdata['Contact']['country_code']) && !empty($staffListdata['Contact']['country_code'])){
                 $code =  $staffListdata['Contact']['country_code'];
                }
                
                 if(isset($staffListdata['Address']['country_id']) && !empty($staffListdata['Address']['country_id'])){
                     $code = $this->Common->getPhoneCode($staffListdata['Address']['country_id']);
                     $code  = ($code)?$code:'';
                 }
                 if(isset($staffListdata['Contact']['cell_phone']) && !empty($staffListdata['Contact']['cell_phone'])){
                    echo  $code.'-'.$staffListdata['Contact']['cell_phone'];
                 }else{
                     echo '';
                 }
            ?>
           </td>
            <td><?php echo ucfirst($staffListdata['UserDetail']['gender']); ?></td>
            <td><?php echo $this->Common->get_access_level_name($staffListdata['User']['group_id']); ?> </td>
            <td><?php echo $this->Common->get_price_level_name($staffListdata['User']['id']); ?> </td>
            </tr>    
        <?php }
    }?>
</tbody>
<tfoot>
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Gender</th>
    <th>Emp Type</th>
    <th>Pricing Level</th>
</tr>
</tfoot>
</table>
<?php }?>