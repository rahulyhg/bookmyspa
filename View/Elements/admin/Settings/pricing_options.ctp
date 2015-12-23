<table class="table table-hover table-nomargin dataTable table-bordered">
    <thead>
        <tr>
            <th>Level Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if(!empty($pricingLevel)){
            foreach($pricingLevel as $prclvl){ ?>
                <tr data-id="<?php echo $prclvl['PricingLevel']['id']; ?>" >
                    <td><?php echo $prclvl['PricingLevel']['eng_name']; ?></td>
                    <td><?php echo $this->Common->theStatusImage($prclvl['PricingLevel']['status']); ?></td>
                    <td>
                        <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0)' , array('data-id'=>$prclvl['PricingLevel']['id'],'title'=>'Edit','class'=>'addedit_prclvl','escape'=>false) ) ?>
                       &nbsp;&nbsp; <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0)', array('title'=>'Delete','class'=>'delete_prclvl','escape'=>false)); ?>
                    </td>
                </tr>    
            <?php }
        }?>
        
    </tbody>

   
</table>
               
             