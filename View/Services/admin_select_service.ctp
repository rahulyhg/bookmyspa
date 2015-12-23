<?php echo $this->Html->script('bootbox.js');?>
<div class="modal-dialog vendor-setting">
    <?php if(isset($uid)){ 
        echo $this->Form->create('Service', array('id'=>'serviceSelectForm','novalidate'));
    }else{
        echo $this->Form->create('Service', array('url' => array('controller' => 'Services', 'action' => 'select_service','admin'=>true),'id'=>'serviceSelectForm','novalidate'));
    } ?>  
    <div class="modal-content">
        <div class="modal-header">
	    <?php if(isset($addNew) && ($addNew=='addnew')){?>
		<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    <?php } ?>
            <h2>What services does <?php echo ucfirst($auth_user['Salon']['eng_name']);?> provide?</h2>
        </div>
	<div class="modal-body clearfix nopadding">
            <div class="v-setting-left">
                <div class="blank">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="scroll scrl_services" style="height:450px">
			<?php
			$arrayDisp = array();
			if(!empty($getData)){
			    foreach($getData as $mke=>$mainService){
				$mainId = $mainService['Service']['id'];
				if(!empty($mainService['children'])){
				    $forTreatChk = 0;
				    foreach($mainService['children'] as $subTreatofCat){
					if(!empty($subTreatofCat['children'])){
					    $forTreatChk = 1;
					    break;
					}
				    }
				    if($forTreatChk == 0){
					continue;
				    } ?>
				    <li>
					<a class="serviceSelc <?php echo ($mke == 0 )? 'active':' ';?>" href="javascript:void(0);" data-tab="#tab-<?php echo $mainId; ?>">
					<?php echo ucfirst($mainService['Service']['name']);?>
					<?php $arrayDisp[] = $mainId; ?>
					</a>
				    </li>
				<?php }
			    }
			}
			else{ ?>
			    <li><a href="javascript:void(0);" >No Services</a></li>
			<?php } ?>
                    </ul>
                </div>
            </div>
            <div class="v-setting-right">
                <div class="top-bar">
                    <div class="search">
                        <input type="search" id="filter" placeholder="Search">
                        <i><img src="/img/admin/search-icon.png" alt="" title=""></i>
                    </div>
                </div>
                <div class="scroll theAllTreat" style="height:450px">
		    <?php if(!empty($getData)){
			$kkey = 0; 
			foreach($getData as $mainCat){
			    if(!in_array($mainCat['Service']['id'],$arrayDisp)){
				continue;
			    }
			    $mID = $mainCat['Service']['id']; ?>
			    <div class="serviceListV" id="tab-<?php echo $mID; ?>" style="<?php echo ($kkey == 0 )? 'display:block;':'display:none;';?>" >
				<div class="emptyResult "></div>
				<div class="panel-group" id="accordion-<?php echo $mID; ?>" role="tablist" aria-multiselectable="true">
				    <?php if(!empty($mainCat['children'])){
					foreach($mainCat['children'] as $kkk=> $theChildren){
					    $theChId = $theChildren['Service']['id'];
					    if(!empty($theChildren['children'])){ ?>
						<div class="panel panel-default" id="service_<?php echo $theChId; ?>">
						    <div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
							    <a class=" <?php echo ($kkk>0)?'collapsed':'';?> " data-toggle="collapse" data-parent="#accordion-<?php echo $mID; ?>" href="#collapse-<?php echo $theChId ?>" aria-expanded="true" aria-controls="collapseOne">
								<?php echo '<span class="add_seista_new">'.ucfirst($theChildren['Service']['name']) .'</span>' ;?> <span>View all<i class="fa fa-angle-down"></i></span>
							    </a>
							    <?php echo $this->Form->checkbox('service_id.',array('value'=>$theChId,'label'=>false,'div'=>false,'class'=>'rootservice','style'=>'display:none;')); ?>
							</h4>
						    </div>
						    <div id="collapse-<?php echo $theChId ?>" class="panel-collapse collapse <?php echo ($kkk < 1)?'in':'';?>" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
							    <ul class="treatment clearfix " id="root_tree">
								<?php if(!empty($theChildren['children'])){
								    foreach($theChildren['children'] as $finalChild){
									echo "<li id='child_".$finalChild['Service']['id']."'>";
									echo $this->Form->input('service_id.',array('type'=>'checkbox','id'=>'serviceId_'.$finalChild['Service']['id'],'value'=>$finalChild['Service']['id'],'label'=>array('class'=>'new-chk','text'=>ucfirst($finalChild['Service']['name']),'id'=>'serviceId_'.$finalChild['Service']['id']),'div'=>false,'checked'=>$this->Common->checkServiceSelected($finalChild['Service']['id']),'class'=>'subCheck'));
									echo "</li>";
								    }
								}
								else{
								    echo "No Service";
								}?>
							    </ul>
							</div>
						    </div>
						</div>
					    <?php }
					} 
				    }else{ ?>
					<div class="accordion-group pdng20">
					    <div class="accordion-heading">
						<a href="javascript:void(0);" data-parent="#accordion-<?php echo $mID; ?>" data-toggle="collapse" class="accordion-toggle">
						    No Service
						</a>
					    </div>
					</div>
				    <?php }?>
				</div>
			    </div>	
			<?php $kkey++;
			}
		    }?>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
	    <?php if(isset($addNew) && ($addNew=='addnew')){
		echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitSelectForm','label'=>false,'div'=>false));
                echo $this->Form->button('Cancel',array(
                        'type'=>'button','label'=>false,'div'=>false,
                        'class'=>'btn' , 'data-dismiss'=>"modal"));
	    }else{ 
		echo $this->Form->button('Next',array('type'=>'submit','class'=>'btn btn-primary submitSelectForm','label'=>false,'div'=>false));
	    }?>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    $(document).on('keyup','#filter',function(e) {
        var code = e.keyCode || e.which;
	if(code==13){
             e.preventDefault();
             return false;   
        }else{
            filter(this);
        }
    });

    function filter(element) {
        var value = $(element).val().toLowerCase();
	var count = 0;
        var totalShow = 0;
        var totalhidden = 0;
        $(document).find(".theAllTreat .treatment li").each(function() {
            var text = $(this).text();
	    if (text.toLowerCase().indexOf(value) >= 0) {
                totalShow++;
                $(this).show();
		$(this).closest('.panel-default').show();
		$(this).closest('div.serviceListV').find(".emptyResult").html('').removeClass('pdng20').hide();
            } else {
                totalhidden++;
                $(this).hide();
		if($(this).parent().children().filter(':visible').length == 0){
		    $(this).closest('.panel-default').hide();
		    
		}
            }
            count++;
	    if(totalShow == 0){
		$(this).closest('div.serviceListV').find(".emptyResult").html('No result found').addClass('pdng20').show();
	    }
        });
	var cntr = 0;
        lisizes = new Array();
        $(".panel-default").each(function() {
            var maindiv = $(this).attr('id');
            lisizes[maindiv] = $("#" + maindiv + " .treatment > li").size();
            var newcuntr = 0;
            newcuntr = new Array();
            newcuntr[maindiv] = 0;
            $("#" + maindiv + " .treatment > li").each(function() {
		if (document.getElementById(this.id).style.display == 'none') {
                    newcuntr[maindiv]++;
                }
            });
 	    if (newcuntr[maindiv] == lisizes[maindiv]) {
                $('#' + maindiv).hide();
            }
            else
            {
                $('#' + maindiv).show();
            }
        });
    }
</script> 
<script>
    Custom.init();
    $(document).ready(function() {
        $(document).on('click', '.serviceSelc', function() {
            var theObj = $(this);
            if (!theObj.hasClass('active')) {
                var theId = theObj.attr('data-tab');
                $(document).find('.serviceSelc').removeClass('active');
                theObj.addClass('active');
                $(document).find('.serviceListV').hide();
                $(document).find(theId).show();
            }
        });
	
	$(document).find(".grey-block, .scroll").mCustomScrollbar({
		advanced:{updateOnContentResize: true}
		//advanced:{autoExpandHorizontalScroll:true}
	});
	
	$(document).find('.serviceSelc:first').addClass('active').trigger('click');
        
        $(document).on('blur , focus' ,'#filter', function(e){
           if(e.type=='focusin'){
               $(this).parent().addClass('purple-bod');
           }else{
               $(this).parent().removeClass('purple-bod');
           }
        })	
   
     
    });

</script>
