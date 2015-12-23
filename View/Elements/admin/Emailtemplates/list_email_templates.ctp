         <table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th style="width:20% !important">Template Name</th>
                            <!--th>Template Description</th-->
                            <th style="text-align: center">Created</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(!empty($getData)){
                            foreach($getData as $getData){ ?>
                                <tr data-id="<?php echo $getData['Emailtemplate']['id']; ?>" >
                                    <td><?php echo $getData['Emailtemplate']['name']; ?></td>
                                    <!--td><?php //echo $getData['Emailtemplate']['template']; ?></td-->
                                    <td style="text-align:center"><?php if(!empty($getData['Emailtemplate']['created'])){
                                            $newDate = date("jS F,Y", strtotime($getData['Emailtemplate']['created']));
                                            echo $newDate; 
                                    } else { echo '-'; }
                                    ?></td>
                                    <td style="text-align: center;">
                                        <?php //echo $this->Html->link($this->Html->image('admin/icons/eye.png',array('alt'=>'View')), array('controller'=>'emailtemplates','action'=>'viewPage','admin'=>true,base64_encode($getData['Emailtemplate']['id'])) , array('title'=>'View','class'=>'view','escape'=>false) ) ?>
                                        <?php echo $this->Html->link('<i class="icon-edit"></i> ','javascript:void(0)' , array('data-id'=>$getData['Emailtemplate']['id'],'title'=>'Edit','class'=>'addedit_emailTemplate','escape'=>false) ) ?>
                                        <?php //echo $this->Html->link($this->Html->image('admin/icons/trash_can.png',array('alt'=>'Delete')), array('controller'=>'Emailtemplate','action'=>'deletePage','admin'=>true,base64_encode($getData['Emailtemplate']['id'])) , array('title'=>'Delete','class'=>'delete','escape'=>false),' Are you sure, you want to delete this CMS Page ? ' ) ?>
                                    </td>
                                </tr>    
                            <?php }
                        }?>
                        
                    </tbody>

                   
                </table>
     
        