          <table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>English Name</th>
                            <th>Arabic Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($productTypes)){
                              $i=1;
                            foreach($productTypes as $productType){ ?>
                                    <tr data-id="<?php echo $productType['ProductType']['id']; ?>" >
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $productType['ProductType']['eng_name']; ?></td>
                                    <td><?php echo $productType['ProductType']['ara_name']; ?></td>
                                    <td><?php echo $this->Common->theStatusImage($productType['ProductType']['status']); ?></td>
                                    <td>
                                        <?php //echo $this->Html->link('<i class="icon-eye-open"></i>','javascript:void(0);' , array('title'=>'View','class'=>'view_producttype','escape'=>false) ) ?>&nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0);', array('data-id'=>$productType['ProductType']['id'],'title'=>'Edit','class'=>'addedit_producttype','escape'=>false) ) ?>&nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>', 'javascript:void(0);' , array('title'=>'Delete','class'=>'delete_producttype','escape'=>false)) ?>
                                    </td>
                                </tr>    
                            <?php $i++; }
                        }?>
                    </tbody>
                    <tfoot>
                    <tr>
                            <th>English Name</th>
                            <th>Arabic Name</th>
                            <th>Status</th>
                            <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
     