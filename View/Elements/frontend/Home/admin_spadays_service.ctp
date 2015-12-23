<?php
$theme = '';
$theme = $_SESSION['theme'];
if($theme == 'odd'){ ?>
	<div class="massage-outer">
<?php } ?>
<div class="container">
    	<h2 class="main-heading col-sm-12">- <?php echo __('Spadays');?> -
        	<span class="view">
			<?php echo $this->Html->link('View All Spa Day Treatments <i class="glyphicon glyphicon-chevron-right"></i>','#',array('escape'=>false,'title'=>'View All Spa Day Treatments','id'=>'spaday'));?>
		</span>
        </h2>
    	<div class="col-sm-3">
            <div class="massage">
                <div class="picture-space">
			<?php echo $this->Html->image('spadays_breaks/5_Star_SPA_Days.jpg',array('title'=>"5 Star SPA Days"));?>
                </div>
                <div class="text-hgt">
		<?php echo $this->Html->link(__('5Star_spa_day'),
			'javascript:void(0);',
			array('escape'=>false,__('5Star_spa_day'),'id'=>'spaday-5star','class'=>'search-spaday'));?>
		</div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="massage">
                <div class="picture-space">
			<?php echo $this->Html->image('spadays_breaks/SPA_Party-.jpg',array('title'=>"SPA Party"));?>
                </div>
                <div class="text-hgt">
			<?php echo $this->Html->link(__('Spa_party'),
				'javascript:void(0);',
				array('escape'=>false,__('Spa_party'),'id'=>'spaday-spaparty','class'=>'search-spaday'));?>
		</div>
	    </div>
        </div>
        
        <div class="col-sm-3">
            <div class="massage">
                <div class="picture-space">
			<?php echo $this->Html->image('spadays_breaks/Last_minute_SPA_days.jpg',array('title'=>"Last minute SPA days"));?>
                </div>
                <div class="text-hgt">
			<?php echo $this->Html->link(__('Last_minute_spa_day'),
				'javascript:void(0);',
				array('escape'=>false,__('Last_minute_spa_day'),'id'=>'spaday-lastminute','class'=>'search-spaday'));?>
		</div>
	    </div>
        </div>
        
        <div class="col-sm-3">
            <div class="massage">
                <div class="picture-space">
			<?php echo $this->Html->image('spadays_breaks/SPA_Days_From_AED100.jpg',array('title'=>"SPA Days From AED100"));?>
                </div>
                <div class="text-hgt">
			<?php echo $this->Html->link(__('Spaday_from_Aed_100'),
				'javascript:void(0);',
				array('escape'=>false,__('Spaday_from_Aed_100'),'id'=>'spaday-frm_aed_100','class'=>'search-spaday'));?>
		</div>
	    </div>
        </div>
</div>
<?php if($theme == 'odd'){ ?>
	</div>
<?php }
/*if(!empty($this->request->data['i_want'])){
	if($this->request->data['i_want'] == 'spaday'){
		
	}
}*/

?>
<script type="text/javascript">
	$('.search-spaday').click(function(){
		var srch_for = this.id;
		var city_cntry = $('#treatment .state-name').text();
		var city_cntryArr = city_cntry.split(', ');
		var new_city_cntry = city_cntryArr[1]+'~'+city_cntryArr[0];
		
		var go_to = '/search/index/'+new_city_cntry+'/'+srch_for;
		window.location.href = go_to;
	});
	$('#spaday').click(function(){
		var city_cntry = $('#treatment .state-name').text();
		var city_cntryArr = city_cntry.split(', ');
		var new_city_cntry = city_cntryArr[1]+'~'+city_cntryArr[0];
		var go_to = '/search/index/'+new_city_cntry+'/spaday';
		window.location.href = go_to;
	});
        
        $('.searchSpabreaks').click(function(){
		var srch_for_break = $(this).attr("data-id");
		var city_cntry = $('#treatment .state-name').text();
		var city_cntryArr = city_cntry.split(', ');
		var new_city_cntry = city_cntryArr[1]+'~'+city_cntryArr[0];
		
		var go_to = '/spabreaks/index/'+new_city_cntry+'/'+srch_for_break;
		window.location.href = go_to;
	});
</script>