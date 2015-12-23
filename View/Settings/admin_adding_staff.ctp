<div class="loader-container" style="display: none;">
	<div class="inner-loader"><img title="" alt="" src="/img/gif-load.GIF"></div>
</div>
<div class="modal-dialog vendor-setting overwrite">
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2>Manage Staff</h2>
        </div>
        <?php
	$noUser = false;
	if(empty($staffList) && empty($auth_user['UserDetail']['employee_type'])){
	    $noUser = true;
	    $readOnly = false;
	    if(isset($this->data) && $this->data['User']['id'] == $auth_user['User']['id']  && in_array($auth_user['User']['type'],array(2,3,4)))
		$readOnly = true;
	    }
	?>
	<div class="modal-body clearfix">
            <div class="col-sm-12 nopadding">
                <div class="box">
		    <div class="box-content  nopadding">
			<div class="clearfix addStaffBox form-vertical" style="<?php echo ($noUser)?'':'display:none;'; ?>">
			    <?php echo $this->element('admin/Settings/staff_creation');?>
			</div>
			<div class="staffListBox" style="<?php echo ($noUser)? 'display:none;':'' ?>" >
			    <?php echo $this->element('admin/Settings/staff_list');?>
			</div>
		    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
	    <div class="col-sm-3 pull-right nopadding mrgn-lft">
		<input type="submit" name="next" class="submitStaffForm btn btn-primary" value="Next" />
	    </div>
	    <div class="col-sm-3  col-xs-3  pull-right ">
		<a  name="next" class=" addStaffForm  btn btn-primary pull-right"><?php echo $this->Html->image('add-emp.png').'Add employee'; ?></a>
	    </div>
        </div>
    </div>
    
</div>

<script>
    Custom.init();
  
    $(document).ready(function(){
	var list = [0];
	if($(document).find('.staffListBox').find('table').length > 0){
	    datetableReInt($(document).find('.staffListBox').find('table'),list);
	}
	
	$(document).on('click','.addStaffForm',function(){
	    var listTxt = $(document).find('.staffListBox').find('div').length;
	    if(listTxt > 0){
		var loadforn = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'submitStaff','admin'=>true)); ?>';
		$(document).find(".addStaffBox").load(loadforn, function() {
		    $(document).find(".addStaffBox").show('slow');
		    $(document).find('.staffListBox').hide('slow');
		});
	    }else{
		alert('Please Save Staff');
	    }
	});
	
	var $bigmodal = $('#commonContainerModal');
	$(document).on('click','.add_pricing_level' ,function(){
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'add','admin'=>TRUE)); ?>";
            fetchModal($bigmodal,addeditURL);
        });
	
	$bigmodal.on('click', '.update', function(e){
            var options = {
                success: function(res){
                    if (onResponse($bigmodal, 'PricingLevel', res)){
                        var res = jQuery.parseJSON(res);
                        itsId = "<?php echo $this->Html->url(array('controller'=>'PricingLevel','action'=>'priceDropDown' ,'admin'=>TRUE)); ?>"; 
                        itsId = itsId+'/'+res.price_id;
                        $(".price_level_drop_down").load(itsId,function(){
                            
                        });
                    }
                }
            };
            $('#PricingLevelAdminAddForm').submit(function() {
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
    
    $(document).on('click','.cancelStaff',function(e){
	e.preventDefault();
	var listTxt = $(document).find('.staffListBox').find('div').length;
	if(listTxt > 0){
	   $(document).find(".addStaffBox").hide('slow');
	   $(document).find(".staffListBox").show('slow');
	}
	else{
	   alert('Please Save the Staff');
	}
    });
    var staffList = "<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'addingStaff','admin'=>true,'content')); ?>";
    
    
    $(document).on('click','.saveStaff',function(){
	
	    
	       if(validatable.validate()==true){
		    var thePage = $(document).find('#staffCreationForm');
		    var options = { 
			success:function(res){
			    if(onResponse(thePage,'User',res,'1')){
				$(document).find(".staffListBox").load(staffList, function() {
				    $(document).find(".addStaffBox").hide('slow');
				    $(this).show('slow');
				    datetableReInt($(document).find('.staffListBox').find('table'),list);
				});    
			    }
			}
		    }; 
		    thePage.submit(function(){
			$(this).ajaxSubmit(options);
			$(this).unbind('submit');
			$(this).bind('submit');
			return false;
		    });
	       }
	});
    });
</script>
