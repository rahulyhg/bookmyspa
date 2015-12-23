<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php //echo (isset($accessDetail) && !empty($accessDetail))?'Edit':"Add"; ?> Assign Sections</h3>
        </div>
        <div class="modal-body">
    <?php echo $this->Form->create('Group',array('novalidate'));?>
    <?php echo $this->Form->hidden('id',array('value'=> $group_id,'label'=>false,'div'=>false)); ?>
            <div class="box row-fluid">
                <table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>View</th>
                            <th>Modify</th>
                        </tr>
                    </thead>
                    <?php  if(!empty($accessDetail)){ ?>
                    <?php foreach($accessDetail as $access){  ?>
                    <tbody>
                        <tr data-id="<?php echo $access['AccessLevel']['id']; ?>" >
                            <td><?php echo $access['AccessLevel']['level_name']; ?></td>
                            <td><?php echo $access['AccessLevel']['description']; ?></td>
                            <?php
                            $viewcheck = $modifycheck = '';
                            if(isset($permissionView) && count($permissionView)>0 ) {
                                if(in_array($access['AccessLevel']['id'],$permissionView)) {
                                        $viewcheck = 'checked';
                                }
                            }
                            if(isset($permissionModify) && count($permissionModify)>0 ) {
                                if(in_array($access['AccessLevel']['id'],$permissionModify)) {
                                        $modifycheck = 'checked';
                                }
                            }
                            ?>
                            <td align="center"><?php 
                            
                            echo $this->Form->input('view.'.$access['AccessLevel']['id'], array('type' => 'checkbox','label' => array('class' => 'new-chk','text' =>''),'checked'=>$viewcheck, 'hiddenField' => false));?></td>
                            <td align="center"><?php echo $this->Form->input('modify.'.$access['AccessLevel']['id'], array('type' => 'checkbox','label' => array('class' => 'new-chk', 'text' =>''), 'checked'=>$modifycheck, 'hiddenField' => false));?></td>
                        </tr>
                    </tbody>
                    <?php }
                    } ?>
                </table>
            </div>

            <div class="box">
                <div class="box-content">
                    <div class="sample-form form-horizontal">
                        <div class="modal-footer pdng20">
                            <div class="form-actions">
                    <?php
                    echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary access_update ','label'=>false,'div'=>false));?>

                    <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                'type'=>'button','label'=>false,'div'=>false,
                                'class'=>'btn',
                                )); ?>

                            </div>
                        </div>
                    </div>
                </div>   
            </div>
    <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>