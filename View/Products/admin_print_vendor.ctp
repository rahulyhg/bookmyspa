<div id='print'>
<table class="table table-hover table-nomargin dataTable table-bordered">
                    <thead>
                        <tr style="color:#fff; background-color:purple; ">
                             <th>English Business Name</th>
                             <th>Arabic Business Name</th>
                              <th>Primary Website</th>
                             <th>Primary Phone</th>
                             <th>Primary Email</th>
                             <th>Secondary Phone</th>
                             <th>Secondary Email</th>
                             <th>fax</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($all_vendors)){
                    foreach($all_vendors as $vendor){  ?>                                      
                        <tr>
                           <td><?php echo $vendor['Vendor']['eng_business_name']; ?></td>
                           <td><?php echo $vendor['Vendor']['ara_business_name']; ?></td>
                            <td><?php echo $vendor['Vendor']['website']; ?></td>
                           <td><?php echo $vendor['Vendor']['phone']; ?></td> 
                           <td><?php echo $vendor['Vendor']['email']; ?></td>
                           <td><?php echo $vendor['Vendor']['secondary_phone']; ?></td>
                            <td><?php echo $vendor['Vendor']['secondary_email']; ?></td>
                           <td><?php echo $vendor['Vendor']['fax']; ?></td> 
                           <td></td>        
                        </tr>                
                    <?php }} ?>
                    </tbody>
                   
                </table>
</div>
<script>

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

printDiv('print');
</script>