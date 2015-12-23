<div class="row">
    <div class="col-sm-12">
       
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                </h3>
                <?php echo $this->Html->link('<i class="icon-plus"></i> Add Staff Service', 'javascript:void(0);', array('data-id' => '', 'escape'=>false, 'class' => 'addedit_vendor pull-right btn')); ?>
            </div>
            <div class="box-content">
                <?php echo $this->Form->create('Service') ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php echo $this->Form->input('chec', array('type' => 'checkbox', 'label' => false, 'class' => 'checkAll','name'=>'')); ?></th>
                            <th>Title</th>
                         </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($serviceData as $service){ ?>
                            <tr>
                                <td><?php echo $this->Form->input('chec', array('type' => 'checkbox', 'label' => false, 'class' => 'main','name'=>'')); ?></td>
                                <th><?php echo ucfirst($service['Service']['eng_name']); ?></th>
                            </tr>
                            <?php
                            if($service['children']){
                                foreach ($service['children'] as $child){ ?>
                                    <tr>
                                        <td><?php echo $this->Form->input('chec', array('type' => 'checkbox', 'label' => false, 'class' => 'main','name'=>'')); ?></td>
                                        <th>&nbsp;&nbsp;<?php echo ucfirst($child['Service']['eng_name']); ?></th>
                                    </tr>    
                                    <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table> 
                <div class="form-actions">
                    <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary submitTreatment ', 'label' => false, 'div' => false)); ?>
                    <?php
                    echo $this->Form->button('Cancel', array(
                        'type' => 'button', 'label' => false, 'div' => false,
                        'class' => 'btn cancelTreatment '));
                    ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>