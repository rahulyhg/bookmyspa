<?php 
$this->Paginator->options(array(
    'update' => '#list-types',
    'evalScripts' => true,
    'url' => array(
        'search_keyword' => @$this->request->data['search_keyword'],
        'number_records' => @$this->request->data['number_records'],
        'startDate' => @$this->request->data['startDate'],
        'endDate' => @$this->request->data['endDate'],
        'serviceType' => @$this->request->data['serviceType']
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

<style>
    #s2id_staffId,#s2id_customerId{width: 20%}
    .largeTextBox{width: 70%!important}
    .smallTextBox{width:30%!important}
</style>
<?php echo $this->element('admin/AdminReports/payment_dues');?>
<div class="search-class">
    <div class="pull-left col-sm-4 nopadding">
        <div class="col-sm-3 nopadding">
            <?php echo $this->Form->select('number_records',
            array('5'=>'5','10'=>'10','25'=>'25','50'=>'50','100'=>'100'),
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
<div id="update_table">
<?php echo $this->element('admin/AdminReports/payment_table');?>
</div>

<script>
	$(document).ready(function(){
            // enable datepicker
            $("#startDate").datepicker({
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 1,
                minDate: 0,
                onSelect: function (selected) {
                    //var dt = new Date(selected);
                    //dt.setDate(dt.getDate() + 1);
                    //$("#endDate").datepicker("option", "minDate", dt);
                }
            });
            $("#endDate").datepicker({
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 1,
                minDate: 0,
                onSelect: function (selected) {
                    //var dt = new Date(selected);
                    //dt.setDate(dt.getDate() - 1);
                    //$("#startDate").datepicker("option", "maxDate", dt);
                }
            });
        });
        $(document).find('#submitpayment').click(function(){
            var salon_id = $('#salon').val();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            submit(startDate ,endDate,salon_id);
        })
        
        function submit(startDate ,endDate,salon ){
             $(".loader-container").show();
                    $.ajax({
                            url: "<?php echo $this->Html->url(array('controller'=>'AdminReports','action'=>'paymentreports' , 'admin'=>true)) ; ?>",
                            type: "POST",
                            data: {startDate:startDate,endDate:endDate,salon:salon},
                            success: function(res) {
                                $('#update_table').html(res);
                                $(".loader-container").hide();
                            }
                    });
            
        }
        
        
         
          $("#reset").click(function(){
                $('#startDate').val('');
                $('#endDate').val('');
		$('#serviceType').val('');
                $(".loader-container").show();
                $.ajax({
			url: "<?php echo $this->Html->url(array('controller'=>'reports','action'=>'transactionReport' , 'admin'=>true)) ; ?>",
			type: "POST",
			data: {startDate:'',endDate:'',serviceType:''},
			success: function(res) {
				$('#list-types').html(res);
                                $(".loader-container").hide();
			}
		});
          });
          
</script>
<?php echo $this->Js->writeBuffer();?>