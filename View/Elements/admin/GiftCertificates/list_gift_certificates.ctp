<?php $this->Paginator->options(
    array(
	'update' => '#update_ctp',
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
<?php echo $this->Session->flash(); ?>
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
<?php if(!empty($giftcertificates)){
    if(!empty($this->Paginator->request->paging['GiftCertificate']['options']['order']) || !empty($this->Paginator->request->paging['GiftCertificate']['order'])){
        if(!empty($this->Paginator->request->paging['GiftCertificate']['options']['order'])){
	    foreach($this->Paginator->request->paging['GiftCertificate']['options']['order'] as $field => $direction){
		$order_field = $field;
		$ord_dir = $direction;
	    }
	} else if(!empty($this->Paginator->request->paging['GiftCertificate']['order'])){
	    foreach($this->Paginator->request->paging['GiftCertificate']['order'] as $field => $direction){
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
    <table class="table table-hover table-nomargin dataTable table-bordered table-responsive" style="width: 100%">
	<thead>
	    <tr>
		<th>Image</th>
		<?php
                if($order_field != 'GiftCertificate.eng_title'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
		<th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftCertificate.gift_certificate_no', 'GC Code');?> </th>
		<?php
                if($order_field != 'Sender.first_name'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
		<th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('Sender.first_name', 'Sender');?></th>
		<?php
                if($order_field != 'GiftCertificate.first_name'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
		<th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftCertificate.first_name', 'Recipient');?></th>
		<?php
                /*if($order_field != 'Recepient.first_name ASC, Recepient.last_name ASC'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }*/
                ?>
		<!--th class="<?php //echo $sort_class_eng;?>"><?php //echo $this->Paginator->sort('Recepient.first_name', 'Used By');?></th-->
		
		
		
		
		<?php
                if($order_field != 'GiftCertificate.total_amount'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
		<th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftCertificate.total_amount', 'Gift Amount');?><br>AED</th>
		
		
		<?php
                if($order_field != 'GiftCertificate.amount'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
		<th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftCertificate.amount', 'Balance Amount');?><br>AED</th>
		
		
		<?php
                if($order_field != 'GiftCertificate.expire_on'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
		<th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftCertificate.expire_on', 'Expires On');?></th>
		
		<?php
                if($order_field != 'GiftCertificate.created'){
                    $sort_class_eng = 'sorting';
                } else {
                    $sort_class_eng = $sort_class;
                }
                ?>
		<th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('GiftCertificate.created', 'Created On');?></th>
		<th>Action</th>
	    </tr>
	</thead>
	<tbody>
	    <?php foreach($giftcertificates as $val){?>
		<tr data-id="<?php echo $val['GiftCertificate']['id']; ?>" >
		    <td>
			<?php
			   $image =  $this->Html->Image('/images/GiftImage/original/'.$val['GiftCertificate']['image'],array('width'=>40));
			   $viewimage =  $this->Html->Image('/images/GiftImage/original/'.$val['GiftCertificate']['image'],array('width'=>570));
			   $image2 =  $this->Html->Image('/images/GiftImage/500/'.$val['GiftCertificate']['image'],array('width'=>90));
			   $img = WWW_ROOT . '/images/GiftImage/original/'.$val['GiftCertificate']['image'];
			   $img2 = WWW_ROOT . '/images/GiftImage/500/'.$val['GiftCertificate']['image'];
			   if(file_exists($img)){
				echo $image;
			   }
			?>
			<div id="ShowCertificate_<?php echo $val['GiftCertificate']['id']; ?>"  style="display:none">
			    <div class="modal-dialog login">
				    <div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel"><?php echo __('View GiftCertificate', true); ?></h4>
					</div>
					<div class="modal-body clearfix PrintImage">
					  <?php echo $viewimage;//echo $this->Html->image($this->Common->giftImage($gift['GiftCertificate']['image'],'original'),array('class'=>" ")); ?>
					</div>
					<div class="modal-footer">
					    <?php echo $this->Html->link('Print','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'gray-btn printCertificate')); ?>
					</div>
				    </div>
			    </div>
		        </div>
		    </td>
		    <td><?php echo $val['GiftCertificate']['gift_certificate_no'] ?></td>
		    <td><?php echo $val['Sender']['first_name'].' '.$val['Sender']['last_name'].' '.$val['Sender']['email']; ?></td>
		    <td><?php echo $val['GiftCertificate']['first_name'].' '.$val['GiftCertificate']['last_name'].' '.$val['GiftCertificate']['email']; ?></td>
		    <!--td><?php //echo @$val['Recepient']['first_name'].' '.@$val['Recepient']['last_name'].' '.@$val['Recepient']['email']; ?></td-->
			 <td><?php echo $val['GiftCertificate']['total_amount']; ?> </td>
		    <td><?php echo $val['GiftCertificate']['amount']; ?> </td>
		    
		    <td><?php echo date('d/m/Y',strtotime($val['GiftCertificate']['expire_on'])); ?></td>
		    <td><?php echo date('d/m/Y',strtotime($val['GiftCertificate']['created'])); ?></td>
		    <td>
			<?php echo $this->Html->link('View','javascript:void(0);', array('data-id'=>$val['GiftCertificate']['id'],'title'=>'View Gift Certificate','class'=>'view_giftCertificate','escape'=>false)); ?>
		    </td
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
    $(document).on('click','.view_giftCertificate', function(){
	   // e.preventDefault();
	      var id = $(this).data("id");
	   //alert("#ShowCertificate_"+id);
	
	   $("#commonMediumModal").html($("#ShowCertificate_"+id).html()).modal();
	   //fetchModal($sModal,$(this).data('href'));
	    
	});
	$(document).on('click','.printCertificate',function(){
	    Popup($('.PrintImage').html());
	});
	
}(jQuery));


$('#search_keyword').keyup(function(){
        $.post("/admin/GiftCertificates/list",
                 {
                    search_keyword: $('#search_keyword').val(),
                    number_records: $('#number_records').val(),
                    },
                    function(data,status){
                        $('#update_ctp').html(data);
                        $('#search_keyword').focus();
                        $('#search_keyword').caretToEnd();
                        //alert($('#search_keyword').val());
                        //$('#search_keyword').val($('#search_keyword').val());
                    }
          );
});
$('#number_records').change(function(){
          $.post("/admin/GiftCertificates/list",
			{
			    search_keyword: $('#search_keyword').val(),
			    number_records: $('#number_records').val(),
			},
			function(data,status){
				  $('#update_ctp').html(data);
			}
          );
});
function Popup(data) 
    {
        var mywindow = window.open('', 'Sieasta.com', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Sieasta.com</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    } 
</script>