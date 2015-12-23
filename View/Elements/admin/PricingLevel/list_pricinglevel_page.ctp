          <table class="table table-hover table-nomargin dataTable table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th width="45%"> Name</th>
                            <th width="45%">Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($pages)){
                            foreach($pages as $page){ ?>
                                <tr data-id="<?php echo $page['PricingLevel']['id']; ?>" data-count="<?php echo count($this->Common->get_pricingLevel_staff($page['PricingLevel']['id'])); ?>">
                                    <td><?php echo $page['PricingLevel']['eng_name']; ?></td>
                                    <td><?php echo $this->Common->theStatusImage($page['PricingLevel']['status']); ?></td>
                                    <td>
                                        <?php //echo $this->Html->link('<i class="icon-eye-open"></i>','javascript:void(0);' , array('title'=>'View','class'=>'view_pricingLevel','escape'=>false) ) ?>
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0);', array('data-id'=>$page['PricingLevel']['id'],'title'=>'Edit','class'=>'addedit_pricingLevel','escape'=>false) ) ?>&nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>', 'javascript:void(0);' , array('title'=>'Delete','class'=>'delete_pricingLevel','escape'=>false)) ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                    </tbody>
                 
                </table>
     