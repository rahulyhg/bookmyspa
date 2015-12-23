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
<?php if(!empty($salonDis)){
    
    if(!empty($this->Paginator->request->paging['User']['options']['order'])){
        foreach($this->Paginator->request->paging['User']['options']['order'] as $field => $direction){
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
                if($order_field != 'Salon.eng_name'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
                <th width="20%" class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('Salon.eng_name', 'Salon Name');?></th>
                <?php
                if($order_field != 'User.email'){
                    $sort_class_ara = 'sorting';
                } else {
                    $sort_class_ara = $sort_class;
                }
                ?>
                <th width="20%" class="<?php echo $sort_class_ara;?>"><?php echo $this->Paginator->sort('User.email', 'Email');?></th>
                
                <?php
                if($order_field != 'User.parent_id'){
                    $sort_class_ara = 'sorting';
                } else {
                    $sort_class_ara = $sort_class;
                }
                ?>
                <th width="15%" class="<?php echo $sort_class_ara;?>"><?php echo $this->Paginator->sort('User.parent_id', 'Salon Type');?></th>
                <!--th>Salon Type</th-->
                <th width="20%">Franchise Owner</th>
                
                <?php
                if($order_field != 'User.created'){
                    $sort_class_cre = 'sorting';
                } else {
                    $sort_class_cre = $sort_class;
                }
                ?>
                <th width="8%" class="<?php echo $sort_class_cre;?>" style ="text-align:center"><?php echo $this->Paginator->sort('User.created','Created On');?></th>
                <?php
                if($order_field != 'User.status'){
                    $sort_class_sta = 'sorting';
                }else {
                    $sort_class_sta = $sort_class;
                }
                ?>
                <th style ="text-align:center">Discount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($salonDis as $salon_discount){ ?>
                <tr data-id = "<?php echo $salon_discount['User']['id'];?>">
                    <td id = "salon_name_<?php echo $salon_discount['User']['id'];?>">
                    <?php
                        if(strlen($salon_discount['Salon']['eng_name']) > 30){
                            echo substr($salon_discount['Salon']['eng_name'] , '0', '30').'...';
                        }else{
                            echo $salon_discount['Salon']['eng_name'];
                        }
                    ?>
                    </td>
                    <td><?php
                    if(strlen($salon_discount['User']['email']) > 30){
                            echo substr($salon_discount['User']['email'] , '0', '30').'...';
                        }else{
                            echo $salon_discount['User']['email'];
                        }
                    ?></td>
                    <td><?php
                   // pr($salon_discount['User']['parent_id']);
                    if(($salon_discount['User']['type'] == 4) && ($salon_discount['User']['parent_id'] == 0)){
                        echo 'Individual Salon';
                    } else {
                        echo 'Salon Under Franchise';
                    }
                    ?></td>
                    <td><?php echo @$parent_salons[@$salon_discount['User']['parent_id']];?></td>
                    <td style ="text-align:center"><?php
                    if(!empty($salon_discount['User']['created']) && ($salon_discount['User']['created'] != '0000-00-00')){
                        echo date(DATE_FORMAT,strtotime($salon_discount['User']['created']));
                    } else {
                        echo '-';
                    }?></td>
                    
                    <td style ="text-align:center">
                        <div class="col-sm-12">
                        <?php if(!empty($salon_discount['User']['discount_percentage'])){
                            $discount_val = $salon_discount['User']['discount_percentage'];
                        } else{
                            $discount_val = 0;
                        }
                        echo $this->Form->input('User.discount.'.$salon_discount['User']['id'],array('id'=>'user_discount_'.$salon_discount['User']['id'],'class'=>'form-control user_discount','type'=>'text','label'=>false,'div'=>false,'value'=>$discount_val));
                        echo $this->Form->hidden('User.previous_discount.'.$salon_discount['User']['id'],array('id'=>'previous_discount_'.$salon_discount['User']['id'],'type'=>'text','label'=>false,'div'=>false,'value'=>$discount_val));
                        ?>
                        </div>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <div>
        <div class="result_pages">
            <?php $pagingArr = $this->Paginator->params();
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
echo $this->Html->script('admin/list_discounts');?>
<script type="text/javascript">
    var sieasta_commission = parseFloat('<?php echo $sieasta_commission[1];?>');
$('.user_discount').blur(function(){
    var user_id = this.id;
    var update_id = user_id.split('user_discount_');
    var id = update_id[1];
    var discount_val = $('#'+user_id).val();
    //alert(sieasta_commission);
    var salon_name = $('#salon_name_'+id).html();
    if (sieasta_commission < discount_val) {
        alert("Currently sieasta commission is "+sieasta_commission+"%, so you can't add "+discount_val+"% discount for "+salon_name+" salon.");
        $('#user_discount_'+id).val($('#previous_discount_'+id).val());
    } else {
        $.post("/admin/salons/save_discounts",
            {
                id: update_id[1],
                discount_percentage: discount_val,
            }
        );
    }
});
    
</script>

<?php
echo $this->Js->writeBuffer();?>