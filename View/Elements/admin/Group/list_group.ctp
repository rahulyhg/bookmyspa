<table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <?php if($auth_user['User']['type'] == 1){ ?>
                            <th>Created By</th>
                            <th>Created On</th>
                            <th>Modified On</th>
                            <?php } ?>
                            <th align="center" style="text-align: center;">Status</th>
                            <th align="center" style="text-align: center;" class="w117">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($groups)){
                            foreach($groups as $group){ ?>
                                <tr data-id="<?php echo $group['Group']['id']; ?>" >
                                <td>
                                    <?php
                                        if(strlen($group['Group']['name']) >20){
                                                 echo substr($group['Group']['name'],'0','20').'...';           
                                        }else{
                                                 echo $group['Group']['name'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if(strlen($group['Group']['description']) >20){
                                                 echo substr($group['Group']['description'],'0','20').'...';           
                                        }else{
                                                 echo $group['Group']['description'];
                                        }
                                    ?>
                                </td>
                                    <?php if($auth_user['User']['type'] == 1){ ?>
                                    <td><?php echo $group['0']['full_name']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($group['Group']['created'])); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($group['Group']['modified'])); ?></td>
                                    <?php } ?>
                                    <td align="center"><span style="display: none;"><?php echo $group['Group']['status']; ?></span>
                                    <?php if($group['Group']['created_by'] != $auth_user['User']['id']){ ?>
                                        <i class="icon-remove grey"></i>
                                    <?php }else{ 
                                    echo $this->Common->theStatusImage($group['Group']['status']); } ?>
                                    </td>
                                    <td align="center">
                                        <?php //echo $this->Html->link('<i class="icon-eye-open"></i>', 'javascript:void(0);' , array('title'=>'View','class'=>'view_group','escape'=>false) ); ?>
                                        &nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>$group['Group']['id'],'title'=>'Edit','class'=>'addedit_group','escape'=>false) ) ?>
                                        <?php if($group['Group']['id'] != '1'){ ?>
                                        <?php if(!in_array($group['Group']['id'],array('1','2','3','4','5','6'))){ ?>
                                        <?php if($group['Group']['created_by'] == $auth_user['User']['id']){ ?>
                                        &nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','class'=>'delete_group','escape'=>false)); ?>
                                        <?php }
                                        } ?>
                                        &nbsp;&nbsp;
                                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-edit"></i>','javascript:void(0);', array('data-id'=>$group['Group']['id'],'title'=>'Assign Sections','class'=>'edit_accessLevel','escape'=>false) ) ?>
                                        <?php } ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                    </tbody>
                    
                </table>