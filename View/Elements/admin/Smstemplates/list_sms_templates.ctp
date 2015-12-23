<table class="table table-hover table-nomargin dataTable table-bordered">
<thead>
    <tr>
        <th>Template Name</th>
        <th>Template Description</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
    <?php if(!empty($getData)){
        foreach($getData as $getData){ ?>
            <tr data-id="<?php echo $getData['Smstemplate']['id']; ?>" >
                <td><?php echo $getData['Smstemplate']['name']; ?></td>
                <td><?php echo $getData['Smstemplate']['template']; ?></td>
                <td><?php  $newDate = date("d/m/Y", strtotime($getData['Smstemplate']['created']));
                echo $newDate; ?></td>
                <td>
                    <?php echo $this->Html->link('<i class="icon-edit"></i> ','javascript:void(0)' , array('data-id'=>$getData['Smstemplate']['id'],'title'=>'Edit','class'=>'addedit_smsTemplate','escape'=>false) ) ?>
                </td>
            </tr>    
        <?php }
    }?>
    
</tbody>

<tfoot>
    <tr>
        <th>Template Name</th>
        <th>Template Description</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
</tfoot>
</table>
     
        