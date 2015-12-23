<div class="wrapper">
	<div class="container my-orders">
		
        <div class="clearfix bod-btm">
        <!--sort by-->
        <?php echo $this->Form->create('Gifts', array('url' => array('controller' => 'myaccount', 'action' => 'gifts') ,'type' =>'post','id'=>"UserForm")) ?>
        <div class="top-recmnded pull-left">
		<label>Sort By</label>
		<select id="filter_date" name="filter_date" class="custom_option">
		    <option>Expiration date</option>
			<option value="1"> Ascending </option>
			<option value="0"> Descending </option>
		</select>
        </div>
        <!--sort by ends-->
        
        <!--sort by-->
        <div class="top-recmnded pull-right">
		
        </div>
        
        <!--sort by ends-->
       </div>
		<!--inner content starts-->
        <div class="appt-tabs">

          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active ajax-render" id="my_appointments">
		<?php echo $this->element('frontend/Myaccount/giftstable'); ?>
	        
            </div>
          </div>
        
        </div>
        <!--inner content ends-->

    </div>
    
</div>
<script>
	$(".custom_option").each(function(){
        $(this).wrap("<span class='option_wrapper'></span>");
        $(this).after("<span class='holder'></span>");
        });
	
        $(".custom_option").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
	
	$('#filter_date').change(function(){
		 var selectedOption = $(this).find(":selected").val();
		 submit_form();
	});
</script>
<?php //echo $this->Js->writeBuffer();?>
<style>
    .inner-loader{
	display: none;
    }
</style>
 