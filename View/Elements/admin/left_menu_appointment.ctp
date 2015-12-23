 <script>
 $(document).ready(function(){
     $("#checkAll").click(function () {
        $('.employeeCheck input:checkbox').not(this).prop('checked', this.checked);
    });
});
</script>

<div id="left" class="appnt-menu" style="height:548px;" >
    <div  class="subnav clearfix">
	<div class="subnav-title"><span>Accept Appointment </span></div>
	<div class="pdng20 clearfix">
	    <div id="calendar" data-bind="kendoCalendar: formattedDate" class="k-widget k-calendar" data-value=""></div>
	</div>
    </div>
    <div  class="subnav clearfix">
	<div class="subnav-title"><span>Jump by week</span></div>
	<dd class="weekbox clearfix">
            <ul>
		    <li><a href="#" id="" tabindex="0" >+1</a></li>
		    <li><a href="#" id="" tabindex="0" >+2</a></li>
		    <li><a href="#" id="" tabindex="0" >+3</a></li>
		    <li><a href="#" id="" tabindex="0" >+4</a></li>
		    <li><a href="#" id="" tabindex="0" >+5</a></li>
		    <li><a href="#" id="" tabindex="0" >+6</a></li>
		    <li><a href="#" id="" tabindex="0" >+7</a></li>
		    <li><a href="#" id="" tabindex="0" >+8</a></li>
                </ul>
		<ul>
		    <li><a href="#" id="" tabindex="0" >-1</a></li>
		    <li><a href="#" id="" tabindex="0" >-2</a></li>
		    <li><a href="#" id="" tabindex="0" >-3</a></li>
		    <li><a href="#" id="" tabindex="0" >-4</a></li>
		    <li><a href="#" id="" tabindex="0" >-5</a></li>
		    <li><a href="#" id="" tabindex="0" >-6</a></li>
		    <li><a href="#" id="" tabindex="0" >-7</a></li>
		    <li><a href="#" id="" tabindex="0" >-8</a></li>
		    
                </ul>
        </dd>
    </div>
    <div class="subnav cal-left clearfix">
        
	<form action="/admin/Appointments" method="post" class="form-horizontal" id="checkbox_form">
	<div class="subnav-title">
	    <span>
	    <?php echo $this->Form->input('CheckAll',array("checked"=>'','div'=>false,'class'=>'validate[required] ','checked'=>'','type'=>'checkbox','id'=>'checkAll','class'=>'service_prov','label'=>array('class'=>'new-chk checkbox_heading','text'=>'Service Provider'))); ?>
	    </span>
	</div>
	<ul class="subnav-menu employeeCheck">
		<?php foreach($staff as $staffData) { ?>
		    <li class="col-sm-12" >
			<span>
			<?php
			    $staffId = $staffData['User']['id'];
			    $checked = false;
			    if(in_array($staffId,$checkedEmpList)){
				$checked = true;
			    }
			    
			    echo $this->Form->input('user.' .$staffId,array('value' => $staffId,'div'=>false,'checked'=> $checked,'class'=>'service_prov','label'=>array('class'=>'new-chk ','text'=>$staffData['User']['first_name'].' '.$staffData['User']['last_name']), 'type' => 'checkbox')); ?>
			</span>
		    </li>
		<?php } ?>
		<li>
		    <span class=" col-sm-6 col-xs-6 nopadding">
		    <?php echo $this->Form->button('Checked <i class="fa fa-angle-double-right"></i> ',array('type'=>'button','class'=>'btn btn-primary ','id'=>'check_id','label'=>false,'div'=>false));?>
		    </span>
		    <span class=" col-sm-6 col-xs-6 nopadding">
		    <?php echo $this->Form->button('In Today <i class="fa fa-angle-double-right"></i>',array('type'=>'button','class'=>'btn mrgn-lft0 dark-btn','label'=>false,'div'=>false,'id'=>'in_today'));?>
		    </span>
		</li>
	    </ul>
	</form>
    </div>
    <div  class="subnav cal-left clearfix">
	<div class="subnav-title">
	    <span>Service Category</span>
	</div>
	<ul class="subnav-menu" id="treatmntCheck">
	<?php if(!empty($services)){
	    foreach($services as $forTreatment){
		if(!empty($forTreatment)){
		    foreach($forTreatment as $treatId =>$theTreatment){ ?>
			<li class="col-sm-12" ><span>
			<?php echo $this->Form->input('treatment.'.$treatId,array('value' => $treatId,'div'=>false, 'label'=>array('class'=>'new-chk','text'=>$theTreatment), 'type' => 'checkbox'));  ?>
			</span></li>
			<?php 
		    }
		}
	    }
	    
	}?>
	</ul>
    </div>
    <div  class="subnav cal-left clearfix">
	<div class="subnav-title">
	    <span>Appointment Status Colors</span>
	</div>
	<ul class="app-color subnav-menu">
	    <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #D1C8E3;"></section>
                </section>
		<section class="divAppStatusText">
		    Requested
                </section>
            </li>
            <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #719AD2;"></section>
		</section>
                <section class="divAppStatusText">
		    Accepted
                </section>
            </li>
            <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #FFE083;"></section>
		</section>
                <section class="divAppStatusText">
		    Awaiting Confirmation
                </section>
            </li>
            <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #F15F24;"></section>
                </section>
                <section class="divAppStatusText">
		    Confirmed
                </section>
            </li>
            <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #52CD64;"></section>
		</section>
                <section class="divAppStatusText">
		    Show
                </section>
            </li>
            <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #E73434;"></section>
                </section>
                <section class="divAppStatusText">
		    No Show
                </section>
            </li>
            <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #31A843;"></section>
                </section>
                <section class="divAppStatusText">
		    In Progress
                </section>
            </li>
	    <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #B4B4B4;"></section>
		</section>
		<section class="divAppStatusText">
		    Complete
		</section>
	    </li>
	    <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #9A8579;"></section>
		</section>
		<section class="divAppStatusText">
		    Personal Task Block
		</section>
	    </li>
	    <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #D7CAC1;"></section>
		</section>
		<section class="divAppStatusText">
		    Personal Task Unblock
		</section>
	    </li>
	    <li class="liAppStatusColor">
		<section class="divAppStatusBorder">
		    <section class="divAppStatusFillColor" style="background-color: #FF82AB;"></section>
		</section>
		<section class="divAppStatusText">
		    On Waiting List
		</section>
	    </li>
	</ul>
    </div>

</div>
<script type="text/javascript" language="javascript">
  Date.prototype.getUnixTime = function() { return this.getTime()/1000|0 };
  function calendar_onChange(e)
    {
	var date = e.sender._value.getUnixTime();
	$.post("<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'index','admin'=>true));?>",{date:date},function(data) {
	    $(document).find('#data-scheduled').html(data);
	});
    }

    $(document).ready(function() {
      $(document).on('click','.weekbox a',function(e){
	    e.preventDefault();
	    var week = $(this).text();
	    var date = $(document).find('#schStartDate').val();
	    $.post("<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'index','admin'=>true));?>",{date:date,week:week},function(data) {
		$(document).find('#data-scheduled').html(data);
	    });
	})
      $(document).on('click',"#check_id",function(event){
        $.post("<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'index','admin'=>true));?>",$("#checkbox_form").serialize(),function(data) {
		$(document).find('#data-scheduled').html(data);
	   });
      });
      $(document).on('click',"#in_today",function(event){
        $('.service_prov').prop('checked', true);
        $.post("<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'index','admin'=>true));?>",$("#checkbox_form").serialize()+ '&button=today',function(data) {
		$(document).find('#data-scheduled').html(data);
	   });
      });
	$("#calendar").kendoCalendar({
	    change: calendar_onChange,
            value: new Date(),
	});
   });
   </script>
<style>
    .checkbox_heading{
        margin-left: 10px;
        font-size: 14px;
        white-space: nowrap;
        font-weight:bold;
    }
</style>
