<script>
    $(document).ready(function() {
        var $modal = $('#commonContainerModal');
        var $modal2 = $('#commonSmallModal');
        var itsId = "";
         var flag = 'true';
        //Open new pop up
        $(document).off('click', '.addedit_giftCertificate').on('click', '.addedit_giftCertificate', function() {
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'addCertificate', 'admin' => true)); ?>";
            addeditURL = addeditURL + '/' + itsId
            var getGiftImageURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'admin_image_by_category', 'admin' => true)); ?>";
            // function in modal_common.js
            $('#GiftCertificateAdminAddCertificateForm .dynamicImageFront').load(getGiftImageURL + '/' + 1, function() {
            });
           fetchModal($modal, addeditURL);
           flag = 'true';
        });
        
          $modal.off('click', '.siestaGCbutton, .savesendgift').on('click', '.siestaGCbutton, .savesendgift', function() {
          var obj = $(this);
          
            var options = {
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success: function(res) {
                   flag = 'true';
                    
                   if($.trim(res) == 'Preview'){
                        if (obj.hasClass('savesendgift')) {
                            var imageSaveURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'save_send_email', 'admin' => false)); ?>";
                            var redirectURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'list', 'admin' => true)); ?>";
                            //fetchModal($modal2, addeditURL);
                           // window.location.href = redirectURL;
                            $.ajax({
                                url: imageSaveURL,
                                type: 'POST',
                                success: function(response) {
                                    if($.trim(response) == 'success'){
                                        //$('#loader-container').css('z-index','999');
                                       // $('#sending-emails').remove();
                                       $modal.modal('toggle');
                                       $('#update_ctp').load(redirectURL, function() {
            });
                                       
                                    }
                                }
                            });
                            
                        }else{
                           
                             var addeditURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'show_by_preview', 'admin' => true)); ?>";
                             fetchModal($modal2, addeditURL);
                        }
                    }else{
                        
                    // onResponse function in modal_common.js
                        if (onResponse($modal, 'GiftCertificate', res, true)) {
                            var data2 = jQuery.parseJSON(res);
                            $("#GiftCertificateId").val(data2.id);
                            var addeditURL = "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'show_by_preview', 'admin' => true)); ?>";
                            fetchModal($modal2, addeditURL);
                        }
                    }
                }
            };
            //Submit Form
            $('#GiftCertificateAdminAddCertificateForm').submit(function() {
                if(flag == 'true'){
                    $(this).ajaxSubmit(options);
                    flag ='false';
                }
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
    
    $(document).on('click','.delete_giftCertificate' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        $this =  $(this); 
        if(confirm(' Are you sure, you want to delete this certificate ? ')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'GiftCertificates','action'=>'delete_gift_certificate')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
               // alert(response);
               // var data = jQuery.parseJSON(response);
                if(response == 'success'){
                    location.reload();
                }
                onResponseBoby(response);
            });
        }
    });
        //var list = [6];
        //datetableReInt($(document).find('.dataTable'), list);
    });
</script>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Gift Certificates Listing
                </h3>
                <?php echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> New Gift Certificate</button>', 'javascript:void(0);', array('data-id' => '', 'escape' => false, 'class' => 'addedit_giftCertificate pull-right')); ?>
            </div>
            <div class="box-content">
                <div class="giftCertificatesdataView" id="list_certificates">
                    <?php echo $this->element('admin/GiftCertificates/list_gift_certificates'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.changeStatus', function() {
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');

            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller' => 'GiftCertificates', 'action' => 'changeStatus', 'admin' => true)); ?>",
                data: {id: theId, status: statusTo}
            })
                    .done(function(msg) {
                        if (msg == 0) {
                            theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                        }
                        else {
                            theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                        }
                    });
        });
    });
</script>
<?php echo $this->Js->writeBuffer();?>