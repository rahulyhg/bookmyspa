          <table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>English Name</th>
                            <th>Arabic Name</th>
                            <th align="center" style="text-align: center;">Status</th>
                            <th align="center" style="text-align: center;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        
                        if(!empty($brands)){
                              $i=1;
                            foreach($brands as $brand){ ?>
                                <tr data-id="<?php echo $brand['Brand']['id']; ?>" >
                                    <td><?php echo $brand['Brand']['eng_name']; ?></td>
                                    <td><?php echo $brand['Brand']['ara_name']; ?></td>
                                    <td align="center"><?php echo $this->Common->theStatusImage($brand['Brand']['status']); ?></td>
                                    <td align="center">
                                        <?php echo $this->Html->link('<i class="icon-eye-open"></i>','javascript:void(0);' , array('title'=>'View','class'=>'view_brand','escape'=>false) ) ?>&nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0);', array('data-id'=>$brand['Brand']['id'],'title'=>'Edit','class'=>'addedit_brand','escape'=>false) ) ?>&nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>', 'javascript:void(0);' , array('title'=>'Delete','class'=>'delete_brand','escape'=>false)) ?>
                                    </td>
                                </tr>    
                            <?php $i++; }
                        }?>
                        
                    </tbody>

                   
                </table>
     