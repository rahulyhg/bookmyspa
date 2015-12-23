        <table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                        
                           <th>English Name</th>
                            <th>Arabic Name</th>
                            <th>Created</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($categories)){
                                    $i=1;
                            foreach($categories as $category){ ?>
                                <tr data-id="<?php echo $category['BlogCategory']['id']; ?>" >
                                    <td><?php echo $category['BlogCategory']['eng_name']; ?></td>
                                    <td><?php echo $category['BlogCategory']['ara_name']; ?></td>
                                    <td class="text-center"><?php  echo date(DATE_FORMAT,strtotime($category['BlogCategory']['created'])); ?></td>
                                    <td class="text-center"><?php echo $this->Common->theStatusImage($category['BlogCategory']['status']); ?></td>
                                    <td class="text-center">
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>$category['BlogCategory']['id'],'title'=>'Edit','class'=>'addedit_blogCat','escape'=>false) ) ?>
                                        &nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','class'=>'delete_blogCat','escape'=>false)) ?>
                                    </td>
                                </tr>    
                            <?php $i++; }
                        }?>
                    </tbody>
                  
                </table>
        