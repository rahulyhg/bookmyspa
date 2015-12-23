<?php
$theme = '';
$theme = $_SESSION['theme'];
if($theme == 'odd'){
	$_SESSION['theme']= 'even'; ?>
	<div class="massage-outer">
<?php }else{ 
	$_SESSION['theme']= 'odd';
} ?>
<div class="container ">
    	<h2 class="main-heading col-sm-12">- <?php echo __('spa_days');?> / <?php echo __('spa_breaks');?> -
        	<span class="view">
			<?php echo $this->Html->link(__('view_all').' / '.__('spa_breaks').' <i class="glyphicon glyphicon-chevron-right"></i>',array('controller' => 'spabreaks', 'action' => 'index'),array('escape'=>false,'title'=>'View All Spa Breaks Treatments '));?>
		</span>
        </h2>
	
    	<div class="col-sm-3">
            <div class="massage">
                <div class="picture-space">
			<?php echo $this->Html->image('spadays_breaks/5_Star_SPA_Days.jpg',array('title'=>"All SPA Days"));?>
                </div>
                <div class="text-hgt">
		<?php echo $this->Html->link(__('all_spa_days'),
			'javascript:void(0);',
			array('escape'=>false,__('all_spa_days'),'id'=>'spaday','class'=>'search-spaday'));?>
		</div>
            </div>
        </div>
    	<div class="col-sm-3">
            <div class="massage">
                <div class="picture-space">
			<?php echo $this->Html->image('spadays_breaks/One_Night_SPA_break.jpg',array('title'=>"One Night SPA break"));?>
                </div>
                <div class="text-hgt">                    
                    <?php echo $this->Html->link(__('One Night SPA break'),
                        'javascript:void(0);',
                        array('escape'=>false,__('One Night SPA break'),'data-id'=>'spabreak~one-night','class'=>'searchSpabreaks'));
                    ?>
                </div>                
            </div>
        </div>
        <div class="col-sm-3">
            <div class="massage">
                <div class="picture-space">
			<?php echo $this->Html->image('spadays_breaks/Two_Nights_SPA_Break.jpg',array('title'=>"Two Nights SPA Break"));?>
                </div>
                <div class="text-hgt">                    
                    <?php echo $this->Html->link(__('Two Nights SPA Break'),
                        'javascript:void(0);',
                        array('escape'=>false,__('Two Nights SPA Break'),'data-id'=>'spabreak~two-night','class'=>'searchSpabreaks'));
                    ?>
                </div>                
	    </div>
        </div>
        
        <div class="col-sm-3">
            <div class="massage">
                <div class="picture-space">
			<?php echo $this->Html->image('spadays_breaks/Last_minute_SPA_Break.jpg',array('title'=>"All SPA Breaks"));?>
                </div>
                <div class="text-hgt">                    
                    <?php echo $this->Html->link(__('all_spa_breaks'),
                        '/spabreaks',
                        array('escape'=>false,__('all_spa_breaks'),'data-id'=>'all-spa-breaks','class'=>'searchSpabreaks'));
                    ?>
                </div>
	    </div>
        </div>
</div>
<?php if($theme == 'odd'){ ?>
	</div>
<?php } ?>



<script type="text/javascript">
	$('.search-spaday').click(function(){
		var srch_for = this.id;
		var city_cntry = $('#treatment .state-name').text();
		var city_cntryArr = city_cntry.split(', ');
		var new_city_cntry = city_cntryArr[1]+'~'+city_cntryArr[0];
		
		var go_to = '/search/index/'+new_city_cntry+'/'+srch_for;
		window.location.href = go_to;
	});
	
        
        $('.searchSpabreaks').click(function(){
		var srch_for_break = $(this).attr("data-id");
		var city_cntry = $('#spadaystab .state-name').text();
		var city_cntryArr = city_cntry.split(', ');
		var new_city_cntry = city_cntryArr[1]+'~'+city_cntryArr[0];
		
		var go_to = '/spabreaks/index/'+new_city_cntry+'/'+srch_for_break;
		window.location.href = go_to;
	});
</script> 

