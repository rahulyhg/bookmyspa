<style type="text/css">
    .modal-dialog.gift_certificate_width{
	width: 80% !important
    }
</style>
<div class="modal-dialog gift_certificate_width">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                Gift Certificate Preview
            </h3>
        </div>
        <div class="modal-body clearfix">
            <div class="box">
                <div class="box-content" id="printingDiv">
                    <div class="col-sm-12">
                        <?php echo $this->Html->image('/'.@$image_path , array('id'=>'image_down'));?>
                    </div>
                </div>   
            </div>
        </div>  
        <div class="modal-footer">
            <div class="form-actions text-center">                               
                <?php
                echo $this->Form->button('Edit', array('data-dismiss' => 'modal',
                    'type' => 'button', 'label' => false, 'div' => false,
                    'class' => 'btn btn-primary closeModal'));
                ?>
                <?php
                //$sessData  = $this->Session->read('GiftCertificateData');
                //pr($this->request->data['GiftCertificate']);
                if(isset($this->request->data['GiftCertificate']['redeemed_gift']) && $this->request->data['GiftCertificate']['redeemed_gift']==1){
                    echo $this->Html->link('Save', array('controller' => 'GiftCertificates', 'action'=>'redeem_gift', 'admin'=>false,  base64_encode($this->request->data['GiftCertificate']['id'])) ,array('class' => 'btn btn-primary', 'label' => false, 'div' => false));
                }else{ 
                    echo $this->Html->link('Pay',
                        array('controller' => 'GiftCertificates', 'action'=>'gift_cart', 'admin'=>false,  base64_encode($gc_id)),
                        array('class' => 'btn btn-primary', 'label' => false, 'div' => false));
                } ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var gc_id = '<?php echo $gc_id;?>';
        window.parent.$("#GiftCertificateId").val(gc_id);
    });
 /*var giftCertificateId="<?php //echo $giftCertificate['GiftCertificate']['id']; ?>";
 var giftCertificateImageId="<?php //echo $giftCertificate['GiftCertificate']['gift_image_id']; ?>";
 var extension="<?php //echo $extension; ?>";
 if(extension == "jpeg"){
    extension="jpg";
 }
 /*
 var imageSaveURL = "<?php //echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'save_image', 'admin' => false)); ?>";
        $.ajax({
            url: imageSaveURL + '/' + giftCertificateId + '/'+extension,
            type: 'POST',
            success: function(response) {                
            }
        });
    function PrintDiv() {
        location.reload();
        var printingDiv = document.getElementById('printingDiv');
        var popupWin = window.open('', '_blank', 'width=300,height=300');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + printingDiv.innerHTML + '</html>');
        popupWin.document.close();
    }*/
</script>