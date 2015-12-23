<style>
    .modal-body{
        padding: 4px !important;
    }
    .modal-dialog{
	width: 63% !important;
    }
</style>

<?php if(!empty($gifts)) { 
		foreach($gifts as $gift) { 

//pr($gift);exit;?>
		<div id="ShowCertificate_<?php echo $gift['GiftCertificate']['id']; ?>"	  style="display:none">
			<div class="modal-dialog login">
				<div class="modal-content">
				    <div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					    <h4 class="modal-title" id="myModalLabel"><?php echo __('View GiftCertificate', true); ?></h4>
				    </div>
				    <div class="modal-body clearfix PrintImage">
				      <?php echo $this->Html->image($this->Common->giftImage($gift['GiftCertificate']['image'],'original'),array('class'=>"gift-image")); ?>
				    </div>
				    <div class="modal-footer">
					<?php echo $this->Html->link('Print','javascript:void(0)',array('type'=>'button','escape'=>false,'class'=>'gray-btn printCertificate')); ?>
				    </div>
				</div>
			</div>
		</div>
		
		<div class="info-box clearfix">
                	<div class="img-box">
			 <?php echo $this->Html->image($this->Common->giftImage($gift['GiftCertificate']['image'],'original'),array('class'=>" ")); ?>
			</div>
                <div class="txt-box">
		    <h2 class="price">AED <?php echo $gift['GiftCertificate']['amount'];?></h2>
		     <h2 class="price">Certificate No: <?php echo $gift['GiftCertificate']['gift_certificate_no'];?></h2>
		</div>
               
		<div class="timer-sec">
			<div class="time-box">
				<i class="fa fa-clock-o"></i>
				<span><strong>Expires On</strong></span>
			<?php  if($gift['GiftCertificate']['expire_on']!= '' && $gift['GiftCertificate']['expire_on'] !='0000-00-00') {
				//pr($gift['GiftCertificate']['expire_on']);
				//exit;
				echo date('m-d-Y',strtotime($gift['GiftCertificate']['expire_on']));
			}else{
				echo 'N.A';	
			} ?>
			</div>
			<!--Need Acceptance <i class="fa fa-check-circle"></i-->
		</div>
		
		<div class="btn-box">
		    <a class="book-now giftCertificateModal gift-button" href="javascript:void(0)" id = "<?php echo $gift['GiftCertificate']['id']?>" type="button">View Gift Certificate</a>
                    <a class="book-now giftDetailModal gift-button" href="javascript:void(0)" type="button" data-giftId="<?php echo $gift['GiftCertificate']['id'];?>">View Details</a>		    
                </div>
		
                    
		<!--div class="btn-box single">
		    <button type="button" class="book-now">View Gift CErtificate</button>
		</div-->
                </div>
	   <?php   } ?>
	   
      
	   <?php } else{ ?>
		<div class="no-result-found"><?php echo __('No Result Found'); ?></div>
	   <?php } ?>
	        <div class="pdng-lft-rgt35 clearfix">
				    <nav class="pagi-nation">
					    <?php if($this->Paginator->param('pageCount') > 1){
						    echo $this->element('pagination-frontend');
						   // echo $this->Js->writeBuffer();
					    } ?>
				    </nav>
				</div>
	   
            	
<script>

	var $sModal = $(document).find('#myModal');
	$(document).off('click','.giftCertificateModal').on('click','.giftCertificateModal', function(){
	giftID = $(this).attr("id");
	   $("#myModal").html($("#ShowCertificate_"+giftID).html()).modal();
	   //fetchModal($sModal,$(this).data('href'));
	    
	});
        
        // view gift details
        $(document).off('click','.giftDetailModal').on('click','.giftDetailModal', function(){
	  $sModal.html('');
	   // e.preventDefault();
            var giftCertificateID = $(this).attr('data-giftId');
            $.ajax({
                 url: "<?php echo $this->Html->url(array('controller'=>'Myaccount','action'=>'gift_details','admin'=>false))?>"+'/'+giftCertificateID,
                 type: "POST",
                 //data: {'order_id':orderRequestID,'evoucher_id':orderEvoucherId},
                 success: function(res) {
                     $sModal.html(res);
                     $sModal.modal('show');
                 }
             });
  
	});
        
	$(document).on('click','.printCertificate',function(){
	    Popup($('.PrintImage').html());
	});
	 

    function Popup(data) 
    {
        var mywindow = window.open('', 'Sieasta.com', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Sieasta.com</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>            
               
                
            