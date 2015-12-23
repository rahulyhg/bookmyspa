        <?php $this->Paginator->options(array(
            'update' => '#list-types',
            'evalScripts' => true,
            'url' => array(base64_encode($countryId),base64_encode($stateId),
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
        <?php $ord_dir="desc"; $order_field= "";
        if(!empty($locations)){ 
            if(!empty($this->Paginator->request->paging['City']['options']['order'])){
                foreach($this->Paginator->request->paging['City']['options']['order'] as $field => $direction){
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
                        if($order_field != 'City.city_name'){
                            $sort_class_eng = 'sorting';
                        } else {
                            $sort_class_eng = $sort_class;
                        }
                        ?>
                        <th class="<?php echo $sort_class_eng;?>"><?php echo $this->Paginator->sort('City.city_name', 'City Name');?></th>
                       
                       
                        <?php
                        if($order_field != 'City.status'){
                            $sort_class_sta = 'sorting';
                        }else {
                            $sort_class_sta = $sort_class;
                        }
                        ?>
                       <!-- <th class="<?php echo $sort_class_sta;?>" style ="text-align:center"><?php echo $this->Paginator->sort('City.status','Status');?></th>-->
                        <th style ="text-align:center">Status</th> 
                        <th style ="text-align:center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($locations as $loc){ ?>
                        <tr data-id = "<?php echo $loc['City']['id'];?>">
                            <td>
                            <?php
                                if(strlen($loc['City']['city_name']) > 30){
                                    echo substr($loc['City']['city_name'] , '0', '30').'...';
                                }else{
                                    echo $loc['City']['city_name'];
                                }
                            ?>
                            </td>
                            <td style ="text-align:center">
                                <?php echo $this->Common->theStatusImage($loc['City']['status']);?>
                            </td>
                            <td style ="text-align:center">
                                <?php echo $this->Html->link('<i class="icon-pencil"></i>', 'javascript:void(0);', array('data-id'=>$loc['City']['id'],'title'=>'Edit','class'=>'addedit_location','escape'=>false) ) ?>&nbsp;&nbsp;
                                <?php echo $this->Html->link('<i class=" icon-trash"></i>', 'javascript:void(0);' , array('data-id'=>$loc['City']['id'],'title'=>'Delete','class'=>'delete_location','escape'=>false)) ?>
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
        
        
        
        
        
        //echo $this->Html->script('admin/products/list_types');
        echo $this->Js->writeBuffer();?>
        <script>
            (function ($) {
            // Behind the scenes method deals with browser
            // idiosyncrasies and such
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
        
            // The following methods are queued under fx for more
            // flexibility when combining with $.fn.delay() and
            // jQuery effects.
        
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
        
        var Main_url = '<?php echo $this->Html->url(array('controller'=>'Locations','action'=>'index','admin'=>true,base64_encode($countryId),base64_encode($stateId))); ?>';
        $('#search_keyword').keyup(function(){
                $.post(Main_url,
                         {
                            search_keyword: $('#search_keyword').val(),
                            number_records: $('#number_records').val(),
                            },
                            function(data,status){
                                $('#list-types').html(data);
                                $('#search_keyword').focus();
                                $('#search_keyword').caretToEnd();
                                //alert($('#search_keyword').val());
                                //$('#search_keyword').val($('#search_keyword').val());
                            }
                  );
        });
        $('#number_records').change(function(){
               
                 
                  $.post( Main_url,
                            {
                                      search_keyword: $('#search_keyword').val(),
                                      number_records: $('#number_records').val(),
                            },
                            function(data,status){
                                      $('#list-types').html(data);
                            }
                  );
        });
        </script>