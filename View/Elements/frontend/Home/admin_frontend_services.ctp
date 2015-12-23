<?php if(isset($getFrontendServices) && !empty($getFrontendServices)){
    $count = count($getFrontendServices);
    $addClass=$theme='';
    foreach($getFrontendServices as $key=>$frontendService){
	if($key == $count-1){
	    if($key%2==0){
		$_SESSION["theme"] = "even";
	    }else{
		$_SESSION["theme"] = "odd";
	    }
	}
	if($key%2==0){ ?>
	    <div class="massage-outer">
	<?php } ?>
	<div class="container">
	    <h2 class="main-heading col-sm-12">
		<?php $encrypt_main = $this->Common->encrypt_string($frontendService['Service']['id']);
		    $name = $this->Common->homeserviceName($frontendService['Service']['id']); ?>
		<span class="cap-heading"><?php echo '-'.$this->Common->homeserviceName($frontendService['Service']['id']).'-';?></span>
		<span class="view">
		    <?php echo $this->Html->link('<span class="view-all-wrap">View All '.$this->Common->homeserviceName($frontendService['Service']['id']).' Treatments </span><i class="glyphicon glyphicon-chevron-right"></i>', 'javascript:void(0)',array('onclick'=>"gethref('".$name."','".$encrypt_main."')",'escape'=>false)); ?>
		</span>
	    </h2>
	    <?php  foreach($frontendService['children'] as $childService){
		//pr($childService);
		if($childService['Service']['frontend_display']==1){  ?>
		    <div class="col-sm-3">
			<div class="massage">
			    <div class="picture-space">
				<?php //pr($childService['Service']);
				echo $this->Html->image($this->Common->getserviceImage($childService['Service']['id'],1),array('class'=>" ")); 
				?>
			    </div>
			    <div class="text-hgt"><?php
			    /*pr($childService);
				$encrypted = $this->Common->encrypt_string($childService['Service']['id']);
				pr($encrypted);
				$decrypted = $this->Common->decrypt_string($encrypted);
				pr($encrypted); //die;
				$service_name_array = $this->Common->homeserviceName($childService['Service']['id'] ,$return_array=true);
				pr($service_name_array);*/
				$lang = Configure::read('Config.language');
				$service_name  = $childService['Service'][$lang.'_name'];
				echo $this->Html->link($service_name, 'javascript:void(0)',
					array('onclick'=>'gethref("'.$childService['Service']['eng_name'].'")'));
				/*echo $this->Html->link($service_name, 'javascript:void(0)',
					array('onclick'=>'gethref("'.$service_name.'","'.$encrypted.'")'));
				
				die;*/
				?>
			    </div>
			</div>
		    </div>
		<?php }
	    }?>
	    <div class="clearfix"></div>
	    <div class="view-all">
		<?php echo $this->Html->link('<span class="view-all-wrap">View All '.$this->Common->homeserviceName($frontendService['Service']['id']).' Treatments </span>', array('controller'=>'search','action'=>'index','?'=>array('category'=>$frontendService['Service']['id'])),array('escape'=>false)); ?>
	    </div>
	</div>
	<?php if($key%2==0){ ?>
	    </div>
	<?php }
    }
} ?>
<script>
    function gethref(service,id){
	var href = '<?php echo Configure::read('BASE_URL') ; ?>';
	var country_text = $(document).find('#SearchCountryId option:selected').text();
	theHTM = $(country_text);
	country = theHTM.attr('data-cntyN')+'~'+theHTM.text();
	var date = $(document).find('#SearchDate').val();
	var from = date.split("/");
	var f = new Date(from[2], from[1], from[0]);
	var date_string = f.getFullYear() + "-" + f.getMonth() + "-" + f.getDate();
	if(service !=''){
	    if(country != ''){
		href += '/search/index/'+country+'/serviceTo/';
	    }
	    if(date_string){
		href += date_string+'/';
	    }
	    if(service != ''){
		href += service;
	    }
	    /*if(id != ''){
		href += '/'+id;
	    }*/
	    href = href.trim();
	    href = href.replace(/\s/g,"-");
	    window.location.href = href;
	}
	return false;
	
    }
 </script>