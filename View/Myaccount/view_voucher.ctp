<div style="width:740px;" class="modal-dialog voucher">
<div class="modal-content">
    <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo __('View Voucher', true); ?></h4>
    </div>
    <div class="modal-body clearfix">
	    <?php echo $this->Html->image($this->Common->giftImage($gifts['GiftCertificate']['gift_certificate_no'].$gifts['GiftCertificate']['image'],'original'),array('class'=>" ")); ?>
    </div>
    </div>
  </div>

