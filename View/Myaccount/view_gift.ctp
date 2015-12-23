<div class="modal-dialog login">
    <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('View GiftCertificate', true); ?></h4>
        </div>
        <div class="modal-body clearfix">
          <?php if(!empty($detail)) { 
            	 echo $this->Html->image($this->Common->giftImage($detail['GiftCertificate']['image'],'original'),array('class'=>"")); 

           } ?>
        </div>
    </div>
</div>
<style>
    .modal-body{
        padding: 4px !important;
    }
</style>