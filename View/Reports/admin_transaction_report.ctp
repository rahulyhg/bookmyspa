<?php
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Transaction Reports
                </h3>
               <?php 
                 //echo $this->Html->link('<i class="icon-list-alt"></i> Export',array(),array('data-id'=>'','escape'=>false,'id'=>'exportTransaction','class'=>'pull-right btn'));
                 ?>
                <?php echo $this->Form->button('Export',array('id'=>'exportTransaction','class'=>'pull-right btn'));?>&nbsp;
            </div>
            <div class="box-content">
                <div class="productTypedataView" id="list-types">
		    <?php echo $this->element('admin/Reports/transaction_list'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //echo $this->element('sql_dump'); ?>