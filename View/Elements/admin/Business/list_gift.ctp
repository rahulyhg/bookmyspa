<div class="box-content">
<div class="box-title">
                <h2>
                    <i class="icon-table"></i>
                    Gifts Certificates
                </h2>
</div>
  <div class="table-responsive">

    <table class="table datatable table-striped table-bordered">
        <thead>
            <tr>
                    <th>Gift Certificate No</th>
                    <th>Sender Name</th>
                    <th>Recipient Id</th>                    
                    <th>Message</th>
                    <th>Amount</th>           
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($giftCertificateList)){
               foreach($giftCertificateList as $giftsValue){ ?>
                   <tr data-id="<?php echo $giftsValue['GiftCertificate']['id']; ?>" >
                       <td><?php echo $giftsValue['GiftCertificate']['gift_certificate_no']; ?></td>
                       <td><?php echo $giftsValue['GiftCertificate']['senderName']; ?></td>
                       <td><?php echo $giftsValue['GiftCertificate']['recipientName']; ?></td>
                       <td><?php echo $giftsValue['GiftCertificate']['messagetxt']; ?></td>
                       <td><?php echo $giftsValue['GiftCertificate']['amount']; ?></td>                                                                   
                   </tr>    
           <?php }
           }?>
        </tbody>
        <tfoot>
            <tr>
                    <th>Gift Certificate No</th>
                    <th>Sender Name</th>
                    <th>Recipient Id</th>                    
                    <th>Message</th>
                    <th>Amount</th>    
            </tr>
        </tfoot>
    </table>

  </div>
</div>