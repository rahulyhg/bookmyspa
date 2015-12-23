<?php $this->Paginator->options(array(
    'update' => '#list-types',
    'evalScripts' => true,
    'url' => array(
        'search_keyword' => @$this->request->data['search_keyword'],
        'number_records' => @$this->request->data['number_records'],
    ),
    'before' => $this->Js->get('.loader-container')->effect(
        'fadeIn',
        array('buffer' => false)
    ),
    'complete' => $this->Js->get('.loader-container')->effect(
        'fadeOut',
        array('buffer' => false)
    ),
));?>
<div class="search-class">
    <div class="pull-left col-sm-4 nopadding">
        <div class="col-sm-3 nopadding">
            <?php echo $this->Form->select('number_records',
            array('10'=>'10','25'=>'25','50'=>'50','100'=>'100'),
            array('empty'=>false,'class'=>'form-control'));?>
        </div>
        <label class="col-sm-9 pdng-tp7" >
            Entries per page
        </label>
    </div>
    <div class="pull-right">
        <label>
            <div class="search">
              <?php echo $this->Form->input('search_keyword',array('label'=>false,'div'=>false,'placeholder'=>'Search here...','type'=>'text'));?>
              <i><?php echo $this->Html->image('admin/search-icon.png', array('title'=>"",'alt'=>""));?></i>
            </div>
        </label>
    </div>
</div>
<?php if(!empty($productTypes)){
    if(!empty($this->Paginator->request->paging['ProductType']['options']['order'])){
        foreach($this->Paginator->request->paging['ProductType']['options']['order'] as $field => $direction){
            $order_field = $field;
            $ord_dir = $direction;
        }
    }
    $sort_class = 'sorting';
    if($ord_dir == 'desc'){
              $sort_class = 'sorting_desc';
    } else if($ord_dir == 'asc') {
              $sort_class = 'sorting_asc';
    }
    ?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
        <thead>
            <tr>
                <?php
                if($order_field != 'ProductType.eng_name'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
                <th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('ProductType.eng_name', 'English Name');?></th>
                <?php
                if($order_field != 'ProductType.ara_name'){
                    $sort_class_ara = 'sorting';
                } else {
                    $sort_class_ara = $sort_class;
                }
                ?>
                <th class="<?php echo $sort_class_ara;?>"><?php echo $this->Paginator->sort('ProductType.ara_name', 'Arabic Name');?></th>
                <?php
                if($order_field != 'ProductType.created'){
                    $sort_class_cre = 'sorting';
                } else {
                    $sort_class_cre = $sort_class;
                }
                ?>
                <th class="<?php echo $sort_class_cre;?>" style ="text-align:center"><?php echo $this->Paginator->sort('ProductType.created','Created On');?></th>
                <?php
                if($order_field != 'ProductType.status'){
                    $sort_class_sta = 'sorting';
                }else {
                    $sort_class_sta = $sort_class;
                }
                ?>
               <!-- <th class="<?php echo $sort_class_sta;?>" style ="text-align:center"><?php echo $this->Paginator->sort('ProductType.status','Status');?></th>-->
                <th style ="text-align:center">Status</th> 
                <th style ="text-align:center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productTypes as $productType){ ?>
                <tr data-id = "<?php echo $productType['ProductType']['id'];?>">
                    <td>
                    <?php
                        if(strlen($productType['ProductType']['eng_name']) > 30){
                            echo substr($productType['ProductType']['eng_name'] , '0', '30').'...';
                        }else{
                            echo $productType['ProductType']['eng_name'];
                        }
                    ?>
                    </td>
                    <td><?php
                    if(strlen($productType['ProductType']['ara_name']) > 30){
                            echo substr($productType['ProductType']['ara_name'] , '0', '30').'...';
                        }else{
                            echo $productType['ProductType']['ara_name'];
                        }
                    ?></td>
                    <td style ="text-align:center"><?php
                    echo date(DATE_FORMAT,strtotime($productType['ProductType']['created'])); ?></td>
                    
                    <td style ="text-align:center">
                        <?php echo $this->Common->theStatusImage($productType['ProductType']['status']);?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0);', array('data-id'=>$productType['ProductType']['id'],'title'=>'Edit','class'=>'addedit_producttype','escape'=>false) ) ?>&nbsp;&nbsp;
                        <?php echo $this->Html->link('<i class=" icon-trash"></i>', 'javascript:void(0);' , array('data-id'=>$productType['ProductType']['id'],'title'=>'Delete','class'=>'delete_producttype','escape'=>false)) ?>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <div>
        <div class="result_pages">
            <?php $pagingArr = $this->Paginator->params();
            //pr($pagingArr);
            $start_records = $pagingArr['page'];
            if(!empty($pagingArr['pageCount'])){
                if (!empty($pagingArr['page']) && !empty($pagingArr['limit'])) {
                    $start_records = $pagingArr['limit'] * ($pagingArr['page'] - 1) + 1;
                }
            }
            $end_records = $start_records + $pagingArr['limit'] - 1;
            if($end_records > $pagingArr['count']){
                $end_records = $pagingArr['count'];
            }
            $total_entries = $pagingArr['count'];
            //echo $this->Paginator->counter();
            echo 'Showing '.$start_records.' to '.$end_records.' of '.$total_entries.' entries'; ?>
        </div>
        <div class ="ck-paging">
            <?php
            echo $this->Paginator->first('First');
            echo $this->Paginator->prev(
                      'Previous',
                      array(),
                      null,
                      array('class' => 'prev disabled')
            );
            echo $this->Paginator->numbers(array('separator'=>' '));
            echo $this->Paginator->next(
                      'Next',
                      array(),
                      null,
                      array('class' => 'next disabled')
            );
            echo $this->Paginator->last('Last');?>
        </div>
    </div>
<?php } else {?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
        <tr>
            <td>No record found.</td>
        </tr>
    </table>
<?php }
echo $this->Html->script('admin/products/list_types');
echo $this->Js->writeBuffer();?>