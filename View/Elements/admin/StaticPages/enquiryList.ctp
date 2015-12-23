<table class="table table-hover table-nomargin dataTable table-bordered">
             <thead>
                 <tr>
                      <th>Name</th>
                      <th>Nature of Business</th>
                      <th>E-mail</th>
                      <th>Organisation</th>
                      <th>Phone</th>
                      <th>Contact Address</th>
                      <th>Query</th>
                      <th align="center" style="text-align: center;">Action</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                 $uid = $this->Session->read('Auth.User.id');
                 if(!empty($allEnquiries)){
                     foreach($allEnquiries as $enquiry){
                          
                          $contact_address = strip_tags($enquiry['BusinessEnquiry']['contact_address']);
                          $detail_query = strip_tags($enquiry['BusinessEnquiry']['detail_query']);
                          if(strlen($contact_address) > 50)
                          {
                                      $contact_address = substr($contact_address,0,50); 
                          }
                          if(strlen($detail_query) > 50)
                          {
                                       $detail_query = substr($detail_query,0,50);
                          }
                          ?>
                             <tr data-id="<?php echo $enquiry['BusinessEnquiry']['id']; ?>" >
                             <td><?php echo $enquiry['BusinessEnquiry']['name']; ?></td>
                             <td><?php echo $enquiry['BusinessEnquiry']['nature_of_business']; ?></td>
                             <td><?php echo $enquiry['BusinessEnquiry']['email']; ?></td>
                             <td><?php echo $enquiry['BusinessEnquiry']['company']; ?></td>
                             <td><?php echo $enquiry['BusinessEnquiry']['contact_phone']; ?></td>
                             <td><?php echo $contact_address; ?></td>
                             <td><?php echo $detail_query; ?></td>
                             
                             <td align="center">
                              <?php echo $this->Html->link('<i class="icon-eye-open"></i>', 'javascript:void(0);' , array('title'=>'View','class'=>'view_enquiry','escape'=>false) ); ?>
                             &nbsp;&nbsp;
                                 <?php echo $this->Html->link('<i class=" icon-trash"></i>&nbsp;', 'javascript:void(0);', array('title'=>'Delete','class'=>'delete_enquiry','escape'=>false) ) ?>
                             </td>
                         </tr>    
                     <?php }
                 }?>
             </tbody>
           
         </table>
         