<?php 
    echo $this->element('frontend/Search/search-bar'); 
    echo $this->Html->script('datepicker/datepicker-js'); 
    echo $this->Html->css('datepicker/datepicker-css');
    echo $this->Html->script('admin/jquery.timepicker');
    echo $this->Html->css('admin/jquery.timepicker'); 
?>
<div class="wrapper">
<div class="container">
	<!--bread-crms-->
    <div class="bread-crms-drop-down clearfix">
        <!--<ul class="bread-crms clearfix">
            <li>
                <a class="brad_country"  href="javascript:void(0)" >United Arab Emirates</a>
            </li>
           
            <li><i class="fa fa-angle-right"></i></li>
             <div class="brad_location" style="display: none">
                <li>
                    <a  class="" href="javascript:void(0)">Discovery Garden</a>
                </li>
                <li><i class="fa fa-angle-right"></i></li></div>
                 <div class="brad_salon_type" style="display: none">
                <li>
                    <a class="" href="javascript:void(0)">Both</a>
                </li>
               <li>
                    <i class="fa fa-angle-right"></i></li> 
             </div>
             <div class="brad_treatment" style="display: none">
                <li>
                    <a class="" href="javascript:void(0)" >Face</a>
                </li>
                <li>
                    <i class="fa fa-angle-right"></i>
                </li>
             </div>
            <div class="brad_treatment_type" style="display: none">
                <li>
                    <a class="" href="javascript:void(0)" >Face</a>
                </li>
             </div>
        </ul>-->
    <!--bread crms-->
    
    <!--sort by-->
    <div class="top-recmnded">
        <label>Sort By</label>
        <select name="sort_by" class="custom_option">
             <!--<option>Recommended</option>
             <option value="DESC_featured"> Newest Featured </option>
             <option value="DESC_featured"> Oldest Featured </option>-->
             <option value="DESC"> <?php echo __('Newest',true);?> </option>
             <option value="ASC">  <?php echo __('Oldest',true);?></option>
        </select>
    </div>
    </div>
    <!--sort by ends-->
    <!--main body section-->
    <div class="v-left-side collapse" id="bs-example-navbar-collapse-2">
    	<?php echo $this->element('frontend/Spabreak/left_search'); ?>
    </div>
    <div class="big-rgt">
    <div class="v-middle-side">
        <?php echo $this->element('frontend/Spabreak/featured_spabreak'); ?>
        <?php echo $this->element('frontend/Search/common_search_spabreak');  ?>
    </div>
        <div class="v-right-side">
            <!--<div class="new-stylists">
                <?php //echo $this->element('frontend/Spabreak/new_spabreak'); ?>
                
            </div>-->
            <?php echo $this->element('frontend/Spabreak/advertisement'); ?>
        </div>
    </div>
    <!--main body section-->
</div>
</div>
<?php echo $this->Form->end(); ?>   

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script> 
<script type="text/javascript">
  $(document).ready(function(){
	$(document).on('click','.showservices' , function(e){
            $(this).html('Hide Services');
            $(this).addClass('moveUp');
            $('.showhidden').removeClass('hidden');	
		
	})
	
	$(document).on('click','.moveUp' , function(e){
            var html = $(document).find('.showservices').html();
            $(this).html('Show more');
            $(this).removeClass('moveUp');
            $('.showhidden').addClass('hidden');	
	});
	
	//$('#pac-input').val($('.select2-choice span .state-name').text());
	
	//brad_country
	$('#submit_top').click(function(){
	    var loc_area_cntry = $('.select2-choice span .state-name').text();
	    $('#pac-input').val(loc_area_cntry);
	});
	
	
   /**************************************** bradcrumb actions ***********************/
        $(document).on('click','.brad_country', function(){
            $("input[name*='loc'] ,input[name*='location']").val('');
            $(".top-recmnded .custom_option option:selected").prop("selected", false);
            $('.top-recmnded select').select2();
            $('.service_to').prop('checked', false);
            $('.treatment').prop('checked', false);
            $('.service-child').prop('checked', false);
            $('.brad_location,.brad_salon_type,.brad_treatment,.brad_treatment_type').hide();
            submit_form();
        });   
        
        $(document).on('click','.brad_location', function(){
            $(".top-recmnded .custom_option option:selected").prop("selected", false);
            $('.top-recmnded select').select2();
            $('.service_to').prop('checked', false);
            $('.treatment').prop('checked', false);
            $('.service-child').prop('checked', false);
            $('.brad_salon_type,.brad_treatment').hide();
            submit_form();
        });   
   
        $(document).on('click','.brad_salon_type', function(){
            $(".top-recmnded .custom_option option:selected").prop("selected", false);
            $('.top-recmnded select').select2();
            $('.treatment').prop('checked', false);
            $('.service-child').prop('checked', false);
            if($(".brad_treatment").is(":visible")){
               submit_form();
            }
            $('.brad_treatment,.brad_treatment_type').hide();
        });
        $(document).on('click','.brad_treatment', function(){
            $(".top-recmnded .custom_option option:selected").prop("selected", false);
            $('.top-recmnded select').select2();
            $('.treatment').prop('checked', false);
            $('.service-child').prop('checked', false);
            if($(".brad_treatment_type").is(":visible")){
               submit_form();
            }
            $('.brad_treatment_type').hide();
        });
    
    
    $(".reset").click(function(){
        location.reload(true);
    });
    
    var d=new Date();
	var todayDate = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
        $('.select_date').datepicker({
		dateFormat: 'dd-mm-yy',
		minDate:todayDate
	});
	
	//$('.select_date').val(todayDate);
        $('.timePKr').timepicker();
})  
    
    function submit_form(){
        var options = {
            beforeSend: function(){
               show_ajax();
            },
            success:function(res){
                $('.v-middle-side').html('');
                $('.v-middle-side').html(res);
                $("html, body").animate({
                    scrollTop: 0
                }, 1500);  
                hide_ajax(true);
            }
        };
        $('#UserIndexForm').ajaxSubmit(options);
        $(this).unbind('submit');
        $(this).bind('submit');
        return false;
    } 
  $(document).ready(function(){
	$('.main-search .navbar-toggle').on('click',function(){
       
		if(!$("#bs-example-navbar-collapse-2").hasClass('in')){
			
		   $('.big-rgt,.v-middle-side').css('margin-top','550px');
			$('#ajax_modal').show();
		   setTimeout(function(){
			$('#ajax_modal').hide();
			$('.big-rgt,.v-middle-side').css('margin-top','0px');
		   },5500);   
		}else{
		    $('#ajax_modal').hide();
		   $('.big-rgt,.v-middle-side').css('margin-top','0px');
		}
		
	});
  });		
</script>