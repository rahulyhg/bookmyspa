<?php
			       if(!empty($history)){ ?>
				<table class="table table-hover table-nomargin table-bordered">
				    <thead>
					<tr>
					    <th>Appointment Date</th>
					    <th style="text-align:center">Appointment Name</th>
                                            <th style="text-align:center">Services Included</th>
					    <th style="text-align:center">Service Provider</th>
					    <th style="text-align:center">Duration</th>
					    <th style="text-align:center">Modified By</th>
					    <th style="text-align:center">Modified Date</th>
					    <th style="text-align:center">Status</th>
					    <th style="text-align:center">Action</th>
					</tr>
				    </thead>
				    <tbody>
					<?php
					$i=1;
					foreach($history as $singleRecord){ ?>
					    <tr>
						<td><?php
                                                    if(isset($singleRecord[0]['appointment_time']) && !empty($singleRecord[0]['appointment_time'])){
                                                        echo date('F d, Y h:i A', $singleRecord[0]['appointment_time']);
                                                    } else {
							echo '--';
						    }
						    
						?></td>
						<td style="text-align:center"><?php
                                                    if($singleRecord['AppointmentHistory']['type'] == 'package'){
                                                        if(!empty($singleRecord['AppointmentHistory']['package_name'])){
                                                            echo $singleRecord['AppointmentHistory']['package_name'];
                                                         } else {
                                                            echo '--';
                                                        }
                                                    }else{
                                                        if(!empty($singleRecord['AppointmentHistory']['service_name'])){
                                                            echo $singleRecord['AppointmentHistory']['service_name'];
                                                         } else {
                                                            echo '--';
                                                        }
                                                    }
                                                ?></td>
                                                <td style="text-align:center"><?php
                                                    if(isset($singleRecord[0]['package_services']) && !empty($singleRecord[0]['package_services'])){
                                                        echo $singleRecord[0]['package_services'];
                                                    } else {
							echo '--';
						    }
						?></td>
						<td style="text-align:center">
						    <?php  if(isset($singleRecord[0]['package_staffs']) && !empty($singleRecord[0]['package_staffs'])){
                                                          $staffs = explode(',',$singleRecord[0]['package_staffs']);
                                                          $namestaff = array();
                                                          foreach(array_unique($staffs) as $staff){
                                                            if($staff != 0){
                                                                $namestaff[] = $this->Common->get_user_name($staff);    
                                                            }
                                                            
                                                          }
                                                          if(!empty($namestaff)){
                                                            echo implode(',',$namestaff);  
                                                          }else{
                                                            echo '--';
                                                          }
                                                          
                                                    } else {
							echo '--';
						    } ?>
						</td>
						<td style="text-align:center"><?php
                                                 if(isset($singleRecord[0]['duration']) && !empty($singleRecord[0]['duration'])){
                                                        echo $singleRecord[0]['duration'];
                                                    } else {
							echo '--';
						    } ?></td>
						<td style="text-align:center"><?php if(!empty($singleRecord['AppointmentHistory']['modified_by'])) {
                                                   echo $this->Common->get_user_name($singleRecord['AppointmentHistory']['modified_by']);
						} else {
						    echo '-';
						}?></td>
						<td style="text-align:center"><?php if(!empty($singleRecord['AppointmentHistory']['modified_date'])) {
						   echo date('F d, Y h:i A',@$singleRecord['AppointmentHistory']['modified_date']);
						} else {
						    echo '-';
						}?></td>
						<td style="text-align:center">
						<?php if(!empty($singleRecord['AppointmentHistory']['status'])){
							echo $singleRecord['AppointmentHistory']['status'];
						    } else {
							echo '--';
						    } ?>
					    </td>
					     <td style="text-align:center">
						<?php if(!empty($singleRecord['AppointmentHistory']['action'])){
							echo $singleRecord['AppointmentHistory']['action'];
						    } else {
							echo '--';
						    } ?>
					     </td>
					</tr>    
					<?php $i++; } ?>
				    </tbody>
				</table>
				    <div class ="ck-paging">
					<?php
					echo $this->Paginator->first('First');
					echo $this->Paginator->prev(
						  'Previous',
						  array(),
						  null,
						  array('class' => 'prev disabled')
					);
					echo $this->Paginator->numbers(array('separator'=>' '));
					echo $this->Paginator->next(
						  'Next',
						  array(),
						  null,
						  array('class' => 'next disabled')
					);
					echo $this->Paginator->last('Last');?>
				    </div>
				<?php }else{
					echo 'No record found.';	
				    } ?>