<script>
$(document).ready(function(){
    
});

</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Customer Reports
                </h3>
                <?php 
                 //echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_producttype pull-right'));?>
            </div>
            <div class="box-content">
                <div class="productTypedataView" id="list-types">
		    
                    <?php echo $this->element('admin/Reports/search_list'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //echo $this->element('sql_dump'); ?>