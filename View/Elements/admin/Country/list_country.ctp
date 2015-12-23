<table class="table table-hover table-nomargin dataTable table-bordered">
<thead>
    <tr>
        <!--<th>Sr.No.</th>-->
        <th>Flag</th>
        <th>Country Title</th>
        <th>Country Name</th>
        <th>Capital </th>
        <th>Currency</th>
        <th>CurrencyCode</th>
        <th>Country Code</th>
        <th>ISO Code</th>
        <th align="center">Status</th>
        <th align="center">Action</th>
    </tr>
</thead>

<tbody>
    <?php if(!empty($countries)){
        $i=1;
        foreach($countries as $country){ ?>
            <tr data-id="<?php echo $country['Country']['id']; ?>" >
                <!--<td><?php echo $i; ?></td>-->
                <td><?php
                        if(!empty($country['Country']['flag_icon'])){
                            echo $this->Html->Image("flags/".$country['Country']['flag_icon']);
                    }else{
                        echo "-";     
                    }?>
                </td>
                <td><?php echo $country['Country']['title']; ?></td>
                <td><?php echo ucfirst($country['Country']['name']); ?></td>
                <td><?php echo $country['Country']['capital']; ?></td>
                <td><?php echo $country['Country']['currency']; ?></td>
                <td><?php echo $country['Country']['currency_code']; ?></td>
                <td><?php echo $country['Country']['iso_code']; ?></td>
                <td><?php echo $country['Country']['phone_code']; ?></td>
                <td align="center"><?php echo $this->Common->theStatusImage($country['Country']['status']); ?></td>
                <td align="center">
                    <?php echo $this->Html->link('<i class="icon-eye-open"></i>',array('controller'=>'Countries','action'=>'view','admin'=>true,base64_encode($country['Country']['id']),ucfirst($country['Country']['title'])) , array('title'=>'View State List','class'=>'view_Country','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('title'=>'Edit','data-id'=>base64_encode($country['Country']['id']),'class'=>'addedit_Country','escape'=>false) ); ?>
                    &nbsp;&nbsp;
                    <?php //echo $this->Html->link('<i class="icon-trash"></i>', array('controller'=>'Country','action'=>'deleteCountry','admin'=>true,base64_encode($country['Country']['id']),ucfirst($country['Country']['title'])) , array('title'=>'Delete','class'=>'delete','escape'=>false),' Are you sure, you want to delete this Country ? ' ); ?>
                </td>
            </tr>    
        <?php $i++; }
    }?>
</tbody>


</table>
