<?php echo $this->Html->css('admin/bundle'); ?>
<style>
    .setNewMarginC{
            /*margin-left:-7px;*/
            margin-left: 0px;
        }
    .form-actions{
        width:150px;
    }
	.FieldContainer{
		border: 1px solid #D7D7D7;
		border-radius:5px;
		min-height:200px;
	}
	.rlbList {
		height: 100%;
		margin 0;
		padding 0;
		position: relative;
	}
	.rlbList .rlbItem {
		cursor: default;
		padding: 2px 5px;
		white-space: nowrap;
	}
	.rlbList .rlbItem:hover {
		background: #DFDFDF; 
	}
	.rlbList .rlbItem.rlbItemActive{
		background: #555555;
		color: #fff;
	}
    </style>
<div class="row">
    <div class="col-sm-12">
        <div class="box">

	    <div class="box-content">
	    <form id="calander_setting" action="/admin/settings/calendar_setting" method="post" class="form-horizontal">
            <div class="col-sm-12">
                <?php
		//echo $this->Form->create(null, array('url' => array('controller' => 'settings', 'action' => 'admin_appointment_rule'),'id'=>'emailTemplateId','novalidate'));
		
		echo $this->Form->hidden('SalonCalendarSetting.id'); ?>
		<div class="row">
		    <div class="col-sm-6">
			<div class="form-group">
			    <label class="control-label col-sm-6 pdng-tp7">Week view starting day</label>
				<?php
				echo $this->Form->input('SalonCalendarSetting.week_start_day', array('options' => array('today'=>'Today','monday'=>'Monday','tuesday'=>'Tuesday','wednesday'=>'Wednesday','thursday'=>'Thursday','friday'=>'Friday','saturday'=>'Saturday','sunday'=>'Sunday'),'label'=>false,'div'=>array('class'=>'col-sm-6'),'class'=>'form-control'), array('label'=>false,'div'=>false,'class'=>'input-small input-block-level', !empty($this->request->data['SalonCalendarSetting']['week_start_day'])?"selected": ''));?>
			</div>
			<div class="form-group">
			    <label class="control-label col-sm-6 pdng-tp7">Default View at login</label>
			    <?php echo $this->Form->input('SalonCalendarSetting.default_view',array('options' => array('day'=>'Day', 'week'=>'Week', 'month'=> 'Month'),'label'=>false,'div'=>array('class'=>'col-sm-6'),'class'=>'form-control'),array('div'=>false,'class'=>'',!empty($this->request->data['SalonCalendarSetting']['default_view'])?"selected": '')); ?>
			</div>
			<div class="form-group">
			    <label class="control-label col-sm-6 pdng-tp7">Service provider max limit in day view*:  </label>
			    <?php echo $this->Form->input('SalonCalendarSetting.provider_max_day_limit',array('type'=>'text','label'=>false,'div'=>array('class'=>'col-sm-6'),'class'=>'form-control numOnly', 'maxlength'=>'2','validationmessage'=>'Service provider max limit in day view is required.','required')); ?>
			</div>
			
		     <div class="form-group">
				<label class="control-label col-sm-6 pdng-tp7">Calendar resolution </label>
				<?php
				echo $this->Form->input('SalonCalendarSetting.calendar_resolution', array('options' => array('5'=>'5','10'=>'10','15'=>'15'),'label'=>false,'div'=>array('class'=>'col-sm-4'),'class'=>'form-control'), array('label'=>false,'div'=>false,'class'=>'input-small input-block-level', !empty($this->request->data['SalonCalendarSetting']['calendar_resolution'])?"selected": ''));
				?>
				<div class="pdng-tp7">(mins.)</div>
		      </div>
			 <div class="form-group">
			      <label class="control-label col-sm-6 pdng-tp7">Calendar line spacing*:</label>
			      <?php echo $this->Form->input('SalonCalendarSetting.calendar_line_space',array('type'=>'text','label'=>false,'div'=>array('class'=>'col-sm-6'),'class'=>'form-control numOnly','maxlength'=>'3','validationmessage'=>'Calendar line spacing is required.','required')); ?>
			</div>
			 <div class="form-group">
                               <?php echo $this->Form->input('SalonCalendarSetting.retention',array(($this->request->data['SalonCalendarSetting']['retention']==1)? "checked":'','div'=>array('class'=>'col-sm-6 setNewMarginC'),'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk control-label','text'=>'Track customer retention'))); ?>
			
			 <?php $disabled=isset($this->request->data['SalonCalendarSetting']['retention']) && $this->request->data['SalonCalendarSetting']['retention']==0?'disabled':'';?>
				<?php
				echo $this->Form->input('SalonCalendarSetting.display_badges', array('options' => array('1'=>'Display badge for new customers only','2'=>'Display badge for all customers'),'label'=>false,$disabled,'div'=>array('class'=>'col-sm-6'),'class'=>'form-control  pdng6'), array('label'=>false,'div'=>false,'class'=>'input-small input-block-level', !empty($this->request->data['SalonCalendarSetting']['display_badges'])?"selected": '','disabled'));
				?>
			    </div>
				<div class="form-group">
				    <div class='col-sm-6'>
					<img src="/img/admin/nnr-left-img.png">
				    </div>
				    <div class='col-sm-6'>
					These badges will show up on your calendar with each appointment. They will indicate what kind of appointments your clients are making, and you can keep a record of new and returning clients. It will also keep track whether or not they are requesting specific service providers.
				    </div>
				</div>
			    </div>
			<?php if(isset($staff)){ ?>
		    <div class="col-sm-6 form-vertical">
				<div class="form-group">
					<div class="col-sm-12">
						<h4 class="mrgn-tp0">Service provider order on calendar</h4>
					</div>
					
					<div class="col-sm-12">
						<div class="col-sm-10 nopadding">
							<div class="FieldContainer">
									<ul class="rlbList">
										
                                                                            
                                                                            <?php
//                                                                            pr($staff);
                                                                            foreach($staff as $theStaff){ ?>
										<li class="rlbItem" data-id="<?php echo $theStaff['User']['id']; ?>">
											<?php echo ucfirst($theStaff['User']['first_name'])." ".ucfirst($theStaff['User']['last_name']); 
                                                                                         echo   $this->Form->input('order.' ,array('type'=>'hidden','value'=>$theStaff['User']['id']));
                                                                                        ?>
                                                                                </li>
										<?php } ?>
									</ul>
							</div>
							<?php echo $this->Form->hidden('SalonCalendarSetting.service_provider_order',array('id'=>'providerOrder','label'=>false,'div'=>false,'class'=>'form-control')); ?>
						</div>
						<div class="col-sm-2">
							<span>
							<?php
								echo $this->Html->link('<i class="fa fa-arrow-up fa-2"></i>','javascript:void(0);',array('escape'=>false,'class'=>'moveUp'));
							?>	
							</span>
							<span>
							<?php
								echo $this->Html->link('<i class="fa fa-arrow-down fa-2"></i>','javascript:void(0);',array('escape'=>false,'class'=>'moveDown'));
							?>	
							</span>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			
		</div>
		    	<div class="form-group">
                                <label class="col-sm-6 pdng-tp7"> </label>
				   <?php echo $this->Form->input('SalonCalendarSetting.mark_current_time',array(!empty($this->request->data['SalonCalendarSetting']['mark_current_time'])? "checked":'','div'=>array('class'=>'col-sm-6 setNewMarginC'),'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Mark the current time'))); ?>
				</div>
                <div class="form-group">
				  <label class="col-sm-6 pdng-tp7"> </label>
				   <?php echo $this->Form->input('SalonCalendarSetting.label_lines',array(!empty($this->request->data['SalonCalendarSetting']['label_lines'])? "checked":'','div'=>array('class'=>'col-sm-6 setNewMarginC'),'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Label all calendar lines'))); ?>
				</div>
		
		
				<label class=" pdng-tp7 col-sm-6"></label>
				<div class="col-sm-12 required text-right">
					<?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary','label'=>false,'div'=>false));?>
					<?php //echo $this->Html->link('Cancel',
					    //array('controller'=>'dashboard','action'=>'index','admin'=>true),
					    //array('escape'=>false,'class'=>'btn')); ?>	
				</div>
			    
		
		
		<!--<div class="sample-form form-horizontal">
		  
			<div class="form-actions">
			    <?php //echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary col-sm-5','label'=>false,'div'=>false));?>
			    <?php //echo $this->Html->link('Cancel',array('controller'=>'dashboard','action'=>'index','admin'=>true),array('escape'=>false,'class'=>'btn col-sm-5')); ?>		
			</div>
		  
		</div>-->
	    </div>
	    <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
</div>
   
<script type="text/javascript">
//Function to allow only numbers to textbox
$('input.numOnly').keypress(function(e) {
    //getting key code of pressed key
    var keycode = (e.which) ? e.which : e.keyCode;
    //comparing pressed keycodes
    if (!(keycode==8 || keycode==46)&&(keycode < 48 || keycode > 57)) {
        return false;
    } else {
        return true;
    }
});




var prodValidator = $("#calander_setting").kendoValidator({
        rules:{
            minlength: function (input) {
                return minLegthValidation(input);
            },
            maxlength: function (input) {
                return maxLegthValidation(input);
            },
            pattern: function (input) {
                return patternValidation(input);
            }
        },
    errorTemplate: "<dfn class='red-txt'>#=message#</dfn>"}).data("kendoValidator");


$(document).ready(function(e){
        $("form").keypress(function(e) {
         if (e.which == 13) {
              $(this).submit();
            }
          });
        
        function setOrder(){
		var staffOrder = $.map($('ul.rlbList').find('li'), function (checkbox) {
			return parseInt($(checkbox).attr('data-id'));
		});
		$(document).find('#providerOrder').val(staffOrder);
	}
	
	function moveUp(item) {
		var prev = item.prev();
		if (prev.length == 0)
			return;
		prev.css('z-index', 999).css('position','relative').animate({ top: item.height() }, 250);
		item.css('z-index', 1000).css('position', 'relative').animate({ top: '-' + prev.height() }, 300, function () {
			prev.css('z-index', '').css('top', '').css('position', '');
			item.css('z-index', '').css('top', '').css('position', '');
			item.insertBefore(prev);
		});
		setOrder();
	}
	function moveDown(item) {
		var next = item.next();
		if (next.length == 0)
			return;
		next.css('z-index', 999).css('position', 'relative').animate({ top: '-' + item.height() }, 250);
		item.css('z-index', 1000).css('position', 'relative').animate({ top: next.height() }, 300, function () {
			next.css('z-index', '').css('top', '').css('position', '');
			item.css('z-index', '').css('top', '').css('position', '');
			item.insertAfter(next);
		});
		setOrder();
	}
	
	//$(".FieldContainer").sortable({ items: ".OrderingField", distance: 10 });
	$(document).on('click','.rlbItem',function(){
		var theJ = $(this);
		$(this).closest('ul.rlbList').find('li').each(function(){
			$(this).removeClass('rlbItemActive')
		});
		theJ.addClass('rlbItemActive');
	});
	$(document).on('click','.moveUp',function(){
		if($(document).find('ul.rlbList').find('li.rlbItemActive').length > 0 ){
			var item = $(document).find('ul.rlbList').find('li.rlbItemActive');
			moveUp(item);
		}
	});
	$(document).on('click','.moveDown',function(){
		if($(document).find('ul.rlbList').find('li.rlbItemActive').length > 0 ){
			var item = $(document).find('ul.rlbList').find('li.rlbItemActive');
			moveDown(item);
		}
	});
	$(document).on('click','#SalonCalendarSettingRetention',function(){
	    if ($(this).is(":checked")) {
		$("#SalonCalendarSettingDisplayBadges").prop("disabled", false);
	    } else {
		$("#SalonCalendarSettingDisplayBadges").prop("disabled", true);  
	    }
	});
    });
</script>