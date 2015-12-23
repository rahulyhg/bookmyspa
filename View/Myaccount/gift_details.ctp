
<div class="modal-dialog login">
    <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('Gift Certificate', true); ?></h4>
        </div>
        <div class="modal-body clearfix requestBookingModal">
            <?php
                //pr($giftcertificate);
                if(!empty($giftcertificate)){
                ?>
                    <div class="appt-tabs table-responsive table-hover">
                        <table width="100%" class="table-bordered table-striped points-detail-tbl">
                            <tr>
                              <th width="35%" class="first">Name</th>
                              <th width="35%" class="sec" style="text-align:center">Amount Used</th>
                              <th width="30%" class="fourth" style="text-align:center">Transaction On</th>
                            </tr>
                            <?php
                                if($giftcertificate['GiftCertificate']['is_used']==1 && (count($giftcertificate['GiftDetail'])==0)){
                                    $giftDet = $this->Common->getGiftDetails($giftcertificate['GiftCertificate']['id']);
                                ?>
                                    <tr>
                                        <td>
                                          <?php
                                          $image = '';
                                          if($giftDet['Order']['service_type'] == 1){
                                            $image = $this->Common->getsalonserviceImage($giftDet['Order']['salon_service_id']);
                                          } else if($giftDet['Order']['service_type'] == 2 || $giftDet['Order']['service_type'] == 3){
                                            $image = $this->Common->getpackageImage($giftDet['Order']['salon_service_id']);
                                          } else if($giftDet['Order']['service_type'] == 4){
                                            $image = $this->Common->getsalonserviceImage($giftDet['Order']['salon_service_id']);
                                          } else if($giftDet['Order']['service_type'] == 5){
                                            //$image = $this->Common->getsalonserviceImage($giftDet['Order']['salon_service_id']);
                                            $image = '';
                                          } else if($giftDet['Order']['service_type'] == 6){
                                            $image = $this->Common->gifcertificateImage($giftDet['Order']['id']);
                                            //$image = $this->Common->getsalonserviceImage($giftDet['Order']['salon_service_id']);
                                          } else if($giftDet['Order']['service_type'] == 7){
                                            $image = $this->Common->getsalonserviceImage($giftDet['Order']['salon_service_id']);
                                          }

                                          ?>

                                          <div class="img-box"
                                          style="width: 150px; height: 75px; float: left; margin: 0 20px 0px 0">
                                            <?php echo $this->Html->image($image,array("width"=>"150","height"=>"75",'title' => @$giftDet['Order']['eng_service_name']));?>
                                          </div>
                                          <div style="min-height: 75px;padding:20px 0; font-weight: bold;">
                                            <?php
                                            if($giftDet['Order']['service_type'] != 6){
                                              echo @$giftDet['Order']['eng_service_name'];
                                            } else {
                                              echo 'Gift Certificate';
                                            }?>
                                          </div>

                                        </td>
                                        <td style="text-align:center">
                                            <?php echo "AED ". $giftcertificate['GiftCertificate']['amount'];?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php echo date('d M,Y h:i A',strtotime($giftDet['Order']['created']));?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                
                                if($giftcertificate['GiftCertificate']['is_used']==0 && (count($giftcertificate['GiftDetail'])==0)){
                                    echo '<tr><td style="text-align:center" colspan=3> Gift Certificate is not used yet. </td></tr>';
                                }
                                if(!empty($giftcertificate['GiftDetail'])){
                                    foreach($giftcertificate['GiftDetail'] as $giftDetail){
                                        //pr($giftDetail);
                                        //echo "order";
                                        $orderDetails = $this->Common->getOrderDetails($giftDetail['order_id']);
                                        //pr($orderDetails);
                                    ?>
                                        <tr>
                                            <td>
                                              <?php
                                              $image = '';
                                              if($orderDetails['Order']['service_type'] == 1){
                                                $image = $this->Common->getsalonserviceImage($orderDetails['Order']['salon_service_id']);
                                              } else if($orderDetails['Order']['service_type'] == 2 || $orderDetails['Order']['service_type'] == 3){
                                                $image = $this->Common->getpackageImage($orderDetails['Order']['salon_service_id']);
                                              } else if($orderDetails['Order']['service_type'] == 4){
                                                $image = $this->Common->getsalonserviceImage($orderDetails['Order']['salon_service_id']);
                                              } else if($orderDetails['Order']['service_type'] == 5){
                                                //$image = $this->Common->getsalonserviceImage($orderDetails['Order']['salon_service_id']);
                                                $image = '';
                                              } else if($orderDetails['Order']['service_type'] == 6){
                                                $image = $this->Common->gifcertificateImage($orderDetails['Order']['id']);
                                                //$image = $this->Common->getsalonserviceImage($orderDetails['Order']['salon_service_id']);
                                              } else if($orderDetails['Order']['service_type'] == 7){
                                                $image = $this->Common->getsalonserviceImage($orderDetails['Order']['salon_service_id']);
                                              }

                                              ?>

                                              <div class="img-box"
                                              style="width: 150px; height: 75px; float: left; margin: 0 20px 0px 0">
                                                <?php echo $this->Html->image($image,array("width"=>"150","height"=>"75",'title' => @$orderDetails['Order']['eng_service_name']));?>
                                              </div>
                                              <div style="min-height: 75px;padding:20px 0; font-weight: bold;">
                                                <?php
                                                if($orderDetails['Order']['service_type'] != 6){
                                                  echo @$orderDetails['Order']['eng_service_name'];
                                                } else {
                                                  echo 'Gift Certificate';
                                                }?>
                                              </div>

                                            </td>
                                            <td style="text-align:center">
                                                <?php echo "AED ". $giftDetail['amount_used'];?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo date('d M,Y h:i A',strtotime($orderDetails['Order']['created']));?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                                
                                
                            ?>   
                        </table>		
                    </div>
                <?php } else { ?>
                  <div class="no-result-found"><?php echo __('No Result Found'); ?></div>
                <?php } ?>
        <div>
    </div>
</div>




