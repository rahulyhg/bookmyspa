<table class="table table-hover table-nomargin dataTable table-bordered">
    <thead>
        <tr>
            <th>English Name</th>
            <th>English Description</th>
            <th>Arabic Name</th>
            <th>Arabic Description</th>
            <th align="center" style="text-align: center;">Status</th>
            <th align="center" style="text-align: center; width:90px !important;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($btypes)){
//            pr($btypes);
            foreach($btypes as $key=>$btype){
                $eng_description = $btype['BusinessType']['eng_description'];
                $ara_description = $btype['BusinessType']['ara_description'];
                if(strlen($eng_description) > 50)
                {
                    $eng_description = substr($btype['BusinessType']['eng_description'], 0, 50).'..';
                }
                if(strlen($ara_description) > 50)
                {
                    $ara_description = substr($btype['BusinessType']['ara_description'], 0, 50).'..';
                }
                ?>
                <tr data-id="<?php echo $btype['BusinessType']['id']; ?>" >
                    <td><?php echo $btype['BusinessType']['eng_name']; ?></td>
                    <td><?php echo $eng_description; ?></td>
                    <td><?php echo $btype['BusinessType']['ara_name']; ?></td>
                    <td><?php echo $ara_description; ?></td>
                    <td align="center" style="text-align: center;"><?php echo $this->Common->theStatusImage($btype['BusinessType']['status']); ?></td>
                    <td align="center" style="text-align: center;">
                        <?php echo $this->Html->link('<i class="icon-eye-open"></i>', 'javascript:void(0);' , array('title'=>'View','class'=>'view_bType','escape'=>false) ); ?>
                        &nbsp;&nbsp;
                        <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>base64_encode($btype['BusinessType']['id']),'title'=>'Edit','class'=>'addedit_bType','escape'=>false) ) ?>
                        &nbsp;&nbsp;
                        <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','class'=>'delete_bType','escape'=>false)); ?>
                    </td>
                </tr>    
            <?php }
        }?>
        
    </tbody>

  
</table>
