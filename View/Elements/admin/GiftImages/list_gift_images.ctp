<?php $this->Paginator->options(array(
    'update' => '.giftImagesdataView',
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
<?php if(!empty($imageList)){
    //pr($this->Paginator->request);
    if(!empty($this->Paginator->request->paging['GiftImage']['options']['order']) || !empty($this->Paginator->request->paging['GiftImage']['order'])){
        if(!empty($this->Paginator->request->paging['GiftImage']['options']['order'])){
	    foreach($this->Paginator->request->paging['GiftImage']['options']['order'] as $field => $direction){
		$order_field = $field;
		$ord_dir = $direction;
	    }
	} else if(!empty($this->Paginator->request->paging['GiftImage']['order'])){
	    foreach($this->Paginator->request->paging['GiftImage']['order'] as $field => $direction){
		$order_field = $field;
		$ord_dir = $direction;
	    }
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
	   <th>Image</th>
	    <?php
                if($order_field != 'GiftImage.eng_title'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
            <th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftImage.eng_title', 'English Title');?> </th>
            
	    <?php
                if($order_field != 'GiftImageCategory.eng_title'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
            <th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftImageCategory.eng_title', 'Category');?></th>
            
	    <?php
                if($order_field != 'GiftImage.text_align'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
            <th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftImage.text_align', 'Text Align');?></th>
            
	    <th>Font Color</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $uid = $this->Session->read('Auth.User.id');
	foreach($imageList as $val){ ?>
	    <tr data-id="<?php echo $val['GiftImage']['id']; ?>" >
		<td><?php echo $this->Html->Image('/images/GiftImage/150/'.$val['GiftImage']['image']); ?></td>         
		<td><?php echo $val['GiftImage']['eng_title']; ?></td>
		<td><?php echo $val['GiftImageCategory']['eng_title']; ?></td>
		<td><?php echo $val['GiftImage']['text_align']; ?></td>                          
		<td>
		    <?php
		    if(!empty($val['GiftImage']['font_color']))
		    {
			echo '<div style="width:100px;height:20px;margin:0 auto;border:solid 1px #893E13;background-color:#'.$val['GiftImage']['font_color'].'"></div>';
		    }
		    ?>
		</td>
		<td>
		    <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>$val['GiftImage']['id'],'title'=>'Edit','class'=>'addedit_giftImage','escape'=>false) ); ?>&nbsp;
		    <?php echo $this->Html->link('<i class="fa icon-trash"></i>','javascript:void(0);', array('data-id'=>$val['GiftImage']['id'],'title'=>'Delete','class'=>'delete_giftImage','escape'=>false) ); ?>
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
<?php } ?>
<script type="text/javascript">
    
(function ($) {
    $.caretTo = function (el, index) {
        if (el.createTextRange) { 
            var range = el.createTextRange(); 
            range.move("character", index); 
            range.select(); 
        } else if (el.selectionStart != null) { 
            el.focus(); 
            el.setSelectionRange(index, index); 
        }
    };

    // Set caret to a particular index
    $.fn.caretTo = function (index, offset) {
        return this.queue(function (next) {
            if (isNaN(index)) {
                var i = $(this).val().indexOf(index);
                
                if (offset === true) {
                    i += index.length;
                } else if (offset) {
                    i += offset;
                }
                
                $.caretTo(this, i);
            } else {
                $.caretTo(this, index);
            }
            
            next();
        });
    };

    // Set caret to beginning of an element
    $.fn.caretToStart = function () {
        return this.caretTo(0);
    };

    // Set caret to the end of an element
    $.fn.caretToEnd = function () {
        return this.queue(function (next) {
            $.caretTo(this, $(this).val().length);
            next();
        });
    };
}(jQuery));


$('#search_keyword').keyup(function(){
        $.post("/admin/GiftImages/list",
                 {
                    search_keyword: $('#search_keyword').val(),
                    number_records: $('#number_records').val(),
                    },
                    function(data,status){
                        $('.giftImagesdataView').html(data);
                        $('#search_keyword').focus();
                        $('#search_keyword').caretToEnd();
                        //alert($('#search_keyword').val());
                        //$('#search_keyword').val($('#search_keyword').val());
                    }
          );
});
$('#number_records').change(function(){
          $.post("/admin/GiftImages/list",
			{
			    search_keyword: $('#search_keyword').val(),
			    number_records: $('#number_records').val(),
			},
			function(data,status){
				  $('.giftImagesdataView').html(data);
			}
          );
});
    
</script>

<?php echo $this->Js->writeBuffer();?>