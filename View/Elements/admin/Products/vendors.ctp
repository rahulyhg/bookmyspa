<table class="table table-hover table-nomargin table-bordered" width="100%">
    <thead>
    <tr>
        <th width="20%">English Business Name</th>
        <th width="20%">Arabic Business Name</th>
        <th width="20%">Primary Phone</th>
        <th width="20%">Primary Email</th>
        <th width="10%">created</th>
        <th width="10%">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($all_vendors)){
    foreach($all_vendors as $vendor){  ?>                                      
    <tr>
       <td><?php echo $vendor['Vendor']['eng_business_name']; ?></td>
       <td><?php echo $vendor['Vendor']['ara_business_name']; ?></td> 
       <td><?php echo $vendor['Vendor']['phone']; ?></td> 
       <td><?php echo $vendor['Vendor']['email']; ?></td>
       <td><?php echo $this->Common->getDateFormat($vendor['Vendor']['created']); ?></td> 
       <td>
        <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0);', array('data-id'=>$vendor['Vendor']['id'],'title'=>'Edit','class'=>'addedit_vendor','escape'=>false) ) ?>&nbsp;&nbsp;
        <?php echo $this->Html->link('<i class=" icon-trash"></i>', 'javascript:void(0);' , array('data-id'=>$vendor['Vendor']['id'],'title'=>'Delete','class'=>'delete_vendor','escape'=>false)) ?>
       </td>        
    </tr>                
    
    <?php }} ?>
    </tbody>
</table>