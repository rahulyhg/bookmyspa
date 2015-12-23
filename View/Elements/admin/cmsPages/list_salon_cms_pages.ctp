<table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Alias</th>
                            <th>Salon Name</th>
                            <th>English Title</th>
                            <th>English Name</th>
                            <th>Arabic Title</th>
                            <th>Arabic Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($pages)){
                            foreach($pages as $page){ ?>
                                <tr data-id="<?php echo $page['StaticPage']['id']; ?>" >
                                    <td><?php echo $page['StaticPage']['alias']; ?></td>
                                    <td><?php echo $page['User']['Salon']['eng_name']; ?></td>
                                    <td><?php echo $page['StaticPage']['eng_title']; ?></td>
                                    <td><?php echo $page['StaticPage']['eng_name']; ?></td>
                                    <td><?php echo $page['StaticPage']['ara_title']; ?></td>
                                    <td><?php echo $page['StaticPage']['ara_name']; ?></td>
                                    <td><?php echo $this->Common->theStatusImage($page['StaticPage']['status']); ?></td>
                                    <td>
                                        <?php echo $this->Html->link('<i class="icon-eye-open"></i>', 'javascript:void(0);' , array('title'=>'View','class'=>'view_cmsPage','escape'=>false) ); ?>
                                        &nbsp;&nbsp;
                                        <?php //echo $this->Html->link('<i class="icon-pencil"></i>', array('controller'=>'StaticPages','action'=>'addPage','admin'=>true,base64_encode($page['StaticPage']['id']),$page['StaticPage']['alias']) , array('title'=>'Edit','class'=>'edit','escape'=>false) ) ?>
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>$page['StaticPage']['id'],'title'=>'Edit','class'=>'addedit_cmsPage','escape'=>false) ) ?>
                                        &nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','class'=>'delete_cmsPage','escape'=>false)); ?>
                                     </td>
                                </tr>    
                            <?php }
                        }?>
                        
                    </tbody>

                   
                </table>