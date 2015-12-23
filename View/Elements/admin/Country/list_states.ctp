<table class="table table-hover table-nomargin dataTable table-bordered">
<thead>
    <tr>
        <!--<th>S. No.</th>-->
        <th>City Name</th>
        <th>Code</th>
        <th align="center" style="text-align: center">Status</th>
        <th align="center" style="text-align: center">Action</th>
    </tr>
</thead>

<tbody>
    <?php if(!empty($country['State'])){
         $i=1;
       foreach($country['State'] as $state){ ?>
            <tr data-id="<?php echo $state['id']; ?>" >
               <!-- <td><?php echo $i; ?></td>-->
                <td><?php echo ucfirst($state['name']); ?></td>
                <td><?php echo $state['code']; ?></td>
                <td align="center"><?php echo $this->Common->theStatusImage($state['status']); ?></td>
                <td align="center">
                    <?php echo $this->Html->link('<i class="icon-eye-open"></i>',array('controller'=>'locations','action'=>'index','admin'=>true,base64_encode($id),base64_encode($state['id'])) , array('title'=>'View City List','class'=>'view_locations','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('title'=>'Edit','data-id'=>base64_encode($state['id']),'class'=>'addedit_State','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php //echo $this->Html->link('<i class="icon-trash"></i>', array('controller'=>'Country','action'=>'deleteCountry','admin'=>true,base64_encode($state['Country']['id']),ucfirst($state['Country']['title'])) , array('title'=>'Delete','class'=>'delete','escape'=>false),' Are you sure, you want to delete this Country ? ' ); ?>
                </td>
            </tr>    
        <?php $i++; }
    }?>
</tbody>

</table>
