<div class="box-title">
    <h3>
        <i class="icon-table"></i>
        <?php echo $stateName; ?> - Location/Area List 
    </h3>
    <?php 
     echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New Location/Area</button>','javascript:void(0);',array('data-id'=>'','data-state'=>base64_encode($stateId) ,'escape'=>false,'class'=>'addedit_City pull-right'));?>
</div>
<div class="box-content">
    <div class="citiesdataView forCheck row-fluid">
        <?php echo $this->element('admin/Country/list_cities'); ?>
    </div>
</div>