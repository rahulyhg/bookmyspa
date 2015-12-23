<table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <?php $display_view = ($activeTMenu=='resource')?'Treatment Room':'Hotel Room'; ?>
                            <th width="5%">Sr. No</th>
                            <th width="15%">English <?php echo ucfirst($display_view);?> Type </th>
                            <th width="15%">Arabic <?php echo ucfirst($display_view);?> Type</th>
                            <th width="30%">English Description</th>
                            <th width="30%">Arabic Description</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($rooms)){
                            foreach($rooms as $key=>$room){ ?>
                           
                                <tr data-id="<?php echo $room['SalonRoom']['id']; ?>" >
                                 <td><?php echo $key+1; ?></td>
                                    <td><?php echo $room['SalonRoom']['eng_room_type']; ?></td>
                                    <td><?php echo $room['SalonRoom']['ara_room_type']; ?></td>
                                    <td><?php echo $room['SalonRoom']['eng_description']; ?></td>
                                    <td><?php echo $room['SalonRoom']['ara_description']; ?></td>
                                    <td>
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>$room['SalonRoom']['id'],'data-type'=>$activeTMenu,'title'=>'Edit','class'=>'addedit_room','escape'=>false) ) ?>
                                        &nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','class'=>'delete_room','escape'=>false)); ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                    </tbody>
</table>