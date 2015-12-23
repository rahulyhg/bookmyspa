<?php 
$this->Paginator->options(array(
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
));
?>
<?php echo $this->Html->script('datepicker/datepicker-js'); ?>
<?php echo $this->Html->css('datepicker/datepicker-css'); ?>
<style>
    #s2id_staffId,#s2id_customerId{width: 20%}
    .largeTextBox{width: 70%!important}
    .smallTextBox{width:30%!important}
</style>
<?php echo $this->element('admin/Reports/search_filter');?>
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
              <?php //echo $this->Form->input('search_keyword',array('label'=>false,'div'=>false,'placeholder'=>'Search here...','type'=>'text'));?>
              <i><?php //echo $this->Html->image('admin/search-icon.png', array('title'=>"",'alt'=>""));?></i>
            </div>
        </label>
    </div>
</div>
<?php if(!empty($allCustomers)){
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
                if($order_field != 'User.created'){
                    $sort_class_cre = 'sorting';
                }else{
                    $sort_class_cre = $sort_class;
                }
                ?>
               <th class="<?php echo $sort_class_cre;?>" style ="text-align:center"><?php echo $this->Paginator->sort('User.created','Cust Since');?></th>
               <?php
                if($order_field != 'User.last_visited'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
               <th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('User.last_visited', 'Last Visited');?></th>
               <th style ="text-align:center">First Name</th>
               <th style ="text-align:center">Last Name</th>
               <th style ="text-align:center">Email address</th>
               <th style ="text-align:center">Address</th>
               <th style ="text-align:center">Cell</th>
               <th style ="text-align:center">Referred By</th>
               <th style ="text-align:center">Tags</th>
               <th style ="text-align:center">Booking</th>
               <th style ="text-align:center">Amt Paid</th>
               <th style ="text-align:center">No Show/Cancel</th>
               <th style ="text-align:center">Staff</th> 
               <th style ="text-align:center">Action</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach($allCustomers as $customer){ 
                //pr($orders);
            
                ?>
                <tr data-id = "<?php echo $customer['User']['id'];?>">
                    <td>
                    <?php
                        echo date(DATE_FORMAT,strtotime($customer['User']['created'])); ?>
                    </td>
                    <td style ="text-align:center"><?php
                        echo date(DATE_FORMAT,strtotime($customer['User']['last_visited'])); ?></td>
                    <td style ="text-align:center">
                        <?php
                          echo $customer['User']['first_name'];
                        ?>
                    </td>
                    <td style ="text-align:center">
                        <?php
                          echo $customer['User']['last_name'];
                        ?>
                    </td>
                    <td style ="text-align:center">
                        <?php
                          echo $customer['User']['email'];
                        ?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $customer['Address']['address'];?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $customer['Contact']['cell_phone'];?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $customer['UserDetail']['refered_by'];?>
                    </td>
                    <td style ="text-align:center">
                        <?php echo $customer['UserDetail']['tags'];?>
                    </td>
                    <td style ="text-align:center">
                        Booking
                    </td>
                    <td style ="text-align:center">
                       
                        Amt paid
                        
                    </td>
                    <td style ="text-align:center">
                       
                        Amt paid
                        
                    </td>
                    <td style ="text-align:center">
                        <?php echo $this->Html->link('<i class="icon-eye-open"></i>', 'javascript:void(0);', array('data-id'=>$customer['User']['id'],'title'=>'View','class'=>'addedit_producttype','escape'=>false) ) ?>&nbsp;&nbsp;
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <div>
        <div class="result_pages">
            <?php 
            $pagingArr = $this->Paginator->params();
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
<?php  } else {?>
    <table class="table table-hover table-nomargin dataTable table-bordered">
        <tr>
            <td>No record found.</td>
        </tr>
    </table>
<?php }
echo $this->Html->script('admin/reports/search_list');
echo $this->Js->writeBuffer();?>
<script>
	$(document).ready(function(){
            $('#customerId').select2()
                .on("open", function(e) {
                    $(document).find('.select2-drop-active').addClass('purple-bod');
                    $(document).find('a.select2-choice').addClass('purple-bod');
                }).on('close', function(){
                    $(document).find('.select2-drop-active').removeClass('purple-bod');
                    $(document).find('#s2id_customerId').removeClass('purple-bod');
                    $(document).find('.select2-choice').removeClass('purple-bod');
            });
            $('#staffId').select2()
                .on("open", function(e) {
                    $(document).find('.select2-drop-active').addClass('purple-bod');
                    $(document).find('a.select2-choice').addClass('purple-bod');
                }).on('close', function(){
                    $(document).find('.select2-drop-active').removeClass('purple-bod');
                    $(document).find('#s2id_staffId').removeClass('purple-bod');
                    $(document).find('.select2-choice').removeClass('purple-bod');
            });
            // enable datepicker
            $(".datepicker").datepicker({
                //dateFormat: 'yy-mm-dd',
                //minDate: 0,
               // showOn: "button",
                //buttonImage: "/img/calendar.png",
                //buttonImageOnly: true,
            });
        })
</script>