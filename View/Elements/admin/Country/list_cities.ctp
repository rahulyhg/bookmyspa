<table class="table table-hover table-nomargin dataTable table-bordered">
<thead>
    <tr>
        <th>S. No.</th>
        <th>Location/Area Name</th>
        <th>Location/Area Code</th>
        <th>Longitude</th>
        <th>Latitude</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
    <?php if(!empty($cities)){
       $i=1;
       foreach($cities as $city){ ?>
            <tr data-state="<?php echo $stateId;?>" data-id="<?php echo $city['City']['id']; ?>" >
                <td><?php echo $i; ?></td>
                <td><?php echo ucfirst($city['City']['city_name']); ?></td>
                <td><?php echo $city['City']['county']; ?></td>
                <td><?php echo $city['City']['latitude']; ?></td>
                <td><?php echo $city['City']['longitude']; ?></td>
                <td><?php echo $this->Common->theStatusImage($city['City']['status']); ?></td>
                <td>
                    <?php //echo $this->Html->link('<i class="icon-eye-open"></i>',array('controller'=>'Countries','action'=>'open_cities','admin'=>true,base64_encode($id),base64_encode($city['id']),ucfirst($city['name'])) , array('title'=>'Edit','class'=>'open_Cities','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('title'=>'Edit','data-state' =>base64_encode($stateId),'data-id'=>base64_encode($city['City']['id']),'class'=>'addedit_City','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php //echo $this->Html->link('<i class="icon-trash"></i>', array('controller'=>'Country','action'=>'deleteCountry','admin'=>true,base64_encode($city['Country']['id']),ucfirst($city['Country']['title'])) , array('title'=>'Delete','class'=>'delete','escape'=>false),' Are you sure, you want to delete this Country ? ' ); ?>
                </td>
            </tr>    
        <?php $i++; }
    }?>
</tbody>

<tfoot>
    <tr>
        <th>S. No.</th>
        <th>Location/Area Name</th>
        <th>Location/Area Code</th>
        <th>Longitude</th>
        <th>Latitude</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
</tfoot>
</table>

<?php //pr($cities);?>