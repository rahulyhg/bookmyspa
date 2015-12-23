<table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Alias</th>
                            <th>English Title</th>
                            <th>English Name</th>
                            <th>Arabic Title</th>
                            <th>Arabic Name</th>
                            <!--<th>Status</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($pages)){
                            foreach($pages as $page){ ?>
                                <tr data-id="<?php echo $page['StaticPage']['id']; ?>" >
                                    <td class="data-limit"><?php echo substr($page['StaticPage']['alias'],'0','15'); ?></td>
                                    <td class="data-limit"><?php echo substr($page['StaticPage']['eng_title'],'0','15'); ?></td>
                                    <td class="data-limit"><?php echo substr($page['StaticPage']['eng_name'],'0','15'); ?></td>
                                    <td class="data-limit"><?php echo substr($page['StaticPage']['ara_title'],'0','15'); ?></td>
                                    <td class="data-limit"><?php echo substr($page['StaticPage']['ara_name'],'0','15'); ?></td>
                                    <!--<td><?php //echo $this->Common->theStatusImage($page['StaticPage']['status']); ?></td>-->
                                    <td style="text-align: center;">
                                        <?php echo $this->Html->link('<i class="icon-eye-open"></i>', 'javascript:void(0);' , array('title'=>'View','class'=>'view_cmsPage','escape'=>false) ); ?>
                                        &nbsp;&nbsp;
                                        <?php //echo $this->Html->link('<i class="icon-pencil"></i>', array('controller'=>'StaticPages','action'=>'addPage','admin'=>true,base64_encode($page['StaticPage']['id']),$page['StaticPage']['alias']) , array('title'=>'Edit','class'=>'edit','escape'=>false) ) ?>
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>$page['StaticPage']['id'],'title'=>'Edit','class'=>'addedit_cmsPage','escape'=>false) ) ?>
                                        &nbsp;&nbsp;
                                        <?php //echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','class'=>'delete_cmsPage','escape'=>false)); ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                        
                    </tbody>

                   
                </table>
