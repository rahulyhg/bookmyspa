<div class="modal-dialog card-preview">
                        <div class="modal-content">
                                                <div class="modal-header">
                                                                        <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                                                                        <span class="sr-only">Close</span></button>
                                                                        <h4 class="modal-title" id="myModalLabel">Gift Certificate Preview</h4>
                                                </div>
                                                <div class="modal-body clearfix">
                                                                        <div class="preview-box" id="printingDiv">
                                                                                                <?php echo $this->Html->image('/'.@$image_path , array('id'=>'image_down'));?>
                                                                        </div>
                                                </div>
                                                <div class="modal-footer">                               
                                                                        <?php
                                                                        echo $this->Form->button('Cancel', array('data-dismiss' => 'modal',
                                                                            'type' => 'button', 'label' => false, 'div' => false,
                                                                            'class' => 'purple-btn closeModal'));
                                                                        echo $this->Form->button('Save', array(
                                                                            'type' => 'button', 'label' => false, 'div' => false,
                                                                            'class' => 'purple-btn save-gift savePreviewAfter'));
                                                                        ?>
                                                </div>
                        </div>
</div>
<script type="text/javascript">
var image_gc = '<?php echo '/'.@$image_path;?>';
var extension = '';
if(image_gc != ''){
    $('.preview-box').css({"backgroundImage": ""});
    $('.preview-box').css({"padding": "0px"});
    
    var imgArr = image_gc.split('.');
    var imgArrLength = imgArr.length;
    var extension = imgArr[imgArrLength-1];
}

var giftCertificateImageId="<?php echo $giftCertificate['GiftImage']['id'] ; ?>";

if(extension == "jpeg"){
    extension="jpg";
}
$('.save-gift').click(function(){
                        $('.loader-container').show();
                        $('.loader-container').css('z-index','9991');
                       // $('.inner-loader').css('text-align','center');
                        //$('.inner-loader').append('<div id="sending-emails" style="color:#fff;font-weight:bold"><br>Sending Emails.....</div>');
                        var imageSaveURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'save_image', 'admin' => false)); ?>";
                        var redirectURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'list', 'admin' => true)); ?>";
                        $.ajax({
                                                url: imageSaveURL + '/'+ giftCertificateImageId + '/' + extension+'/1',
                                                type: 'POST',
                                                success: function(response) {
                                                                        if(response == 'success'){
                                                                                                $('#loader-container').css('z-index','999');
                                                                                                $('#sending-emails').remove();
                                                                           window.location.href = redirectURL; 
                                                                        }
                                                }
                        });
                        
});
$('.closeModal').click(function(){
    //var redirectURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'list', 'admin' => true)); ?>";  
});

$('.close').click(function(){
    //var redirectURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'list', 'admin' => true)); ?>";
});
function PrintDiv() {
    location.reload();
    var printingDiv = document.getElementById('printingDiv');
    var popupWin = window.open('', '_blank', 'width=300,height=300');
    popupWin.document.open();
    popupWin.document.write('<html><body onload="window.print()">' + printingDiv.innerHTML + '</html>');
    popupWin.document.close();
}
</script>