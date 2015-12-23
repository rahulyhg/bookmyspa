<div id="servicedetailtbl">
    <h1>Charges Detail</h1>
    <table  class="table table-hover table-nomargin dataTable table-bordered checkoutDetails" width="100%">
        <thead>
              <tr> 
     ?>
                    <th></th>
                    <th>Code1</th>
                    <th>Service, Product, IOU or Package</th>
                    <th>Service Provider</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th> <?php echo $this->Form->radio('type', array('P' => '%','A' => '$'), array('class'=>'radio','legend'=>false,'label'=>false)); ?></th>
                    <th>price after Disc.</th>
                    <th>Pts needed</th>
                    <th>Use Pts</th>
    
              </tr>
        </thead>
        <?php if(!empty($appointmentData)){
                $appointmemtType = "Srvc";
            ?>
        <tbody>
            <?php foreach($appointmentData as $apptData){ echo  "tetete"; die;?>
            <tr>
                <td></td>
                <td><?php echo $appointmemtType; ?></td>
                <td class="aTitle"><?php echo $apptData['Appointment']['appointment_title']; ?></td>
                <td class="aName"><?php echo $apptData['User']['first_name'].' '.$apptData['User']['last_name']; ?></td>
                <td></td>
                <td><?php echo $this->Form->input('price',array('value'=>$apptData['Appointment']['appointment_price'],'class' => 'aPrice','div'=>false,'label'=>false)); ?></td>
                <td class="aDiscount"><?php echo 0; ?></td>
                <td class="aDisPrice"><?php echo 0; ?></td>
                <td class="aPtsN"><?php echo 0; ?></td>
                <td class="aPts"><?php echo 0; ?></td>
            </tr>
            <?php } ?>
        </tbody>
       <?php }?>
    </table>
</div>
