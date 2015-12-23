<?php $lang =  Configure::read('Config.language'); ?>
<style type="text/css">
    a .book-now{
	padding: 0;
	margin: 0;
    }
</style>
<!--tabs main navigation starts-->
<div class="salonData clearfix">
    <div class="main-nav clearfix">
	<?php  echo $this->element('frontend/Myaccount/my_tabs'); ?>
    </div>
    <div class="container bukingService">
	<?php //echo $this->element('frontend/Myaccount/points'); ?>
	<!--tabs main navigation ends-->
	<div class="wrapper">
	    <div class="container points my-orders">
		<!--inner content starts-->
		<?php
		
		
		if(!empty($getpoints) || !empty($sieasta_points)){ ?>
		    <div class="appt-tabs table-responsive table-hover">
			<div class="tab-content">
			    <div class="tab-pane active ajax-render" id="my_appointments">
			        
				<!--<tr>
				    <th width="35%" class="first">Name</th>
				    <th width="35%" class="sec">Balance</th>
				    <th width="30%" class="fourth">&nbsp;</th>
				</tr>-->
				
				<?php if(!empty($sieasta_points)){ //pr($sieasta_points);?>
				     <div  class="info-box sieasta clearfix">
					<div class="img-box sieasta-line purple">
					    <img src="/img/sieasta-name.png" alt="Sieasta" title="Sieasta"><?php echo __('Sieasta'); ?>
					</div>
					<div class="txt-box">
					<h2><?php echo __('Sieasta'); ?> </h2>
					</div>
					 <div class="timer-sec sieasta-line">
						 <div class="time-box">
							 
							 <span><strong>Balance: </strong><?php echo $sieasta_points['UserCount']['user_count'] ;?> Points</span>
						
						 </div>
						 <!--Need Acceptance <i class="fa fa-check-circle"></i-->
					 </div>
					 <div class="btn-box sieasta-line">
						<?php $gift_type = 'admin';
					    //$businessUrl = $this->Common->getSalon($sieasta_points['UserCount']['salon_id']);
					    $businessUrl ='';
					    if(!$businessUrl){
						$businessUrl = 'Place/salongiftcertificate/'.$sieasta_points['UserCount']['salon_id'];
					    } ?>
					    <a data-amount="<?php echo $this->Common->get_price_from_point($sieasta_points['UserCount']['user_count']);?>" href="javascript:void(0);" data-point = "<?php echo $sieasta_points['UserCount']['user_count']; ?>" data-type ="<?php echo $gift_type; ?>" class="book-now gift-button redeem_certificate" id="<?php echo $businessUrl ; ?>" type="button" class="book-now gift-button redeem_certificate">Redeem a gift certificate</a>
					    <?php $url = $this->Html->url(
						array('controller'=>'myaccount','action'=>'view_points',
						    $sieasta_points['User']['id'],
						    $sieasta_points['User']['type'],
						    'admin'=>false));
					    
					     $url = $this->Html->url(array('controller'=>'myaccount','action'=>'view_points',$sieasta_points['User']['id'],$sieasta_points['User']['type'],'admin'=>false));
					    echo $this->Html->link(__('View Details',true),
						'javascript:void(0);',
						array('style'=>'text-align:center;text-decoration:none;',
						    'data-href' => $url,
						    'class'=>'book-now redcert gift-button','escape'=>false
						 )
					    ); 
					     ?>
					 </div>
				      </div>
				    
				<?php }?>
				 <?php if(!empty($getpoints)) {
				    
				    
				    ?>
				<?php foreach($getpoints as $key=>$points) {
				    
				    ?>
				    <div  class="info-box salonpoint clearfix">
					<div class="img-box  purple">
					<?php
					//pr($salon_data);
					if($points['Salon']['cover_image'] != '') { ?>
					<?php echo $this->Html->image('/images/'.$points['UserCount']['salon_id'].'/Salon/150/'.$points['Salon']['cover_image']); ?>
					<?php }else{
						echo $this->Html->image('/img/noimage.jpeg' ,array('style'=>'width:195px;height:132px'));
					?>
					<?php } ?>
					    <?php //echo $this->Common->get_my_salon_name($points['User']['id']);?>
					</div>
					<div class="txt-box">
					 <h2><?php echo $this->Common->get_my_salon_name($points['User']['id']);?></h2>
					</div>
					 <div class="timer-sec purple">
						 <div class="time-box">
							 
							 <span><strong>Balance: </strong><?php echo $points['UserCount']['user_count'] ;?> Points</span>
						
						 </div>
						 <!--Need Acceptance <i class="fa fa-check-circle"></i-->
					 </div>
					 <div class="btn-box">
					  <?php
					    $gift_type = 'salon';
					    //$businessUrl = $this->Common->getSalon($points['UserCount']['salon_id']);
					    $businessUrl = '';
					    if(!$businessUrl){
						$businessUrl = 'Place/salongiftcertificate/'.$points['UserCount']['salon_id'];
					    } ?>
					    <a data-amount="<?php echo $this->Common->get_price_from_point($points['UserCount']['user_count']);?>" href="javascript:void(0);" data-point = "<?php echo $points['UserCount']['user_count']; ?>" data-type ="<?php echo $gift_type; ?>" class="book-now gift-button redeem_certificate" id="<?php echo $businessUrl ; ?>" type="button" class="book-now">Redeem a gift certificate</a>
					    <?php $url = $this->Html->url(array('controller'=>'myaccount','action'=>'view_points',$points['User']['id'],$points['User']['type'],'admin'=>false));
					    echo $this->Html->link(__('View Details',true),
						'javascript:void(0);',
						array('style'=>'text-align:center;text-decoration:none;',
						    'data-href' => $url,
						    'class'=>'book-now redcert gift-button','escape'=>false
						)
					    ); ?>
					 </div>
				    </div>
				  
				<?php } ?>
			    <?php } else if(empty($sieasta_points)){ ?>
				<div class="no-result-found"><?php echo __('No Result Found'); ?></div>
			    <?php } ?>
			<!--</table>-->
			</div>
		        </div>
			<div class="pdng-tp-11"></div>
			<!--inner content ends-->
		    </div>
		    <?php if(count($getpoints) >= 10){ ?>	
			<div class ="ck-paging">
			    <?php
			    echo $this->Paginator->first('First');
			    echo $this->Paginator->prev(
				      'Previous',
				      array(),
				      null,
				      array('class' => 'prev disabled')
			    );
			    echo $this->Paginator->numbers(array('separator'=>' '));
			    echo $this->Paginator->next(
				      'Next',
				      array(),
				      null,
				      array('class' => 'next disabled')
			    );
			    echo $this->Paginator->last('Last');?>
			</div>
		    <?php }
		} ?>
	    </div>
	</div>
    </div>
</div>
<style>
    .inner-loader{
	display: none;
    }
</style>
<script>
	$(".custom_option").each(function(){
        $(this).wrap("<span class='option_wrapper'></span>");
        $(this).after("<span class='holder'></span>");
        });
	
        $(".custom_option").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
	
	$('#filter_points').change(function(){
		 var selectedOption = $(this).find(":selected").val();
		 submit_form();
	});
</script>	

	
	
	
	
     </div>
    
    
</div>
<!--tabs main navigation ends-->
<script>
$(document).ready(function(){
    $(document).off('click','.redeem_certificate').on('click','.redeem_certificate', function (){
	alert("ff");
	var id = $(this).attr('id');
	    gift_type = $(this).data('type');
	    point = parseInt($(this).data('point'));
	    var certificatePoint = parseInt($(this).data('amount'));
	if(point >= certificatePoint){
		var flag = '<?php echo base64_encode('redeemed');?>';
		var href = '<?php echo Configure::read('BASE_URL') ; ?>';
		if(gift_type=='salon'){
		    href += '/'+id+'/'+flag;
		}else{
		    href += '/GiftCertificates/index/'+flag;   
		}
		location.href = href;
	}else{
	    alert('Minimum '+certificatePoint+' points need to redeem giftcertificate.');
	    return false;
	}
    });
    var $sModal = $(document).find('#mySmallModal');
	$(document).off('click','.redcert').on('click','.redcert',function(e){
	    $('.voucher').css('display','block');
	    e.preventDefault();
	    $sModal.load($(this).data('href'),function(){
		$sModal.modal('show');
	    });
    });
});

function submit_form(){ 
		var options = {
			beforeSend: function() {
                                show_ajax();
			},
			success:function(res){
				$('.bukingService .appt-tabs').html('');
				$('.bukingService .appt-tabs').html(res);
				$("html, body").animate({
					scrollTop: 0
				}, 1500);  
                        hide_ajax();
			}
		};
		$('#UserForm').ajaxSubmit(options);
		$(this).unbind('submit');
		$(this).bind('submit');
		return false;
	}
</script>
<?php echo $this->Js->writeBuffer();?>