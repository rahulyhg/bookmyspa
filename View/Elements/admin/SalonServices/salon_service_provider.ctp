<table class="table table-hover table-nomargin dataTable table-bordered">
        <thead>
                <tr>
                        <th>Powered By</th>
                        <th>Status</th>
                </tr>
        </thead>
        <tbody>
        <?php
        $flippedids= array();
        if(!empty($levelStaffIds)){
                $flippedids = array_flip($levelStaffIds);
        }
        if(isset($salonservice['SalonStaffService']) && !empty($salonservice['SalonStaffService'])){
               foreach($salonservice['SalonStaffService'] as $key=>$serviceStaff){
                        echo '<tr data-pl="'.$this->Common->get_price_level_id($serviceStaff['staff_id']).'">';
                        echo '<td>'.$this->Common->get_user_name($serviceStaff['staff_id']).'<dfn>('.$this->Common->get_price_level_name($serviceStaff['staff_id']).')</dfn>'.'</td>';
                        echo $this->Form->hidden('SalonStaffService.'.$serviceStaff['staff_id'].'.id',array('class'=>'','label'=>false,'div'=>false,'value'=>$serviceStaff['id']));
                        echo $this->Form->hidden('SalonStaffService.'.$serviceStaff['staff_id'].'.staff_id',array('class'=>'','label'=>false,'div'=>false,'value'=>$serviceStaff['staff_id']));
                        echo $this->Form->hidden('SalonStaffService.'.$serviceStaff['staff_id'].'.salon_service_id',array('class'=>'','label'=>false,'div'=>false,'value'=>$serviceStaff['salon_service_id']));
                        $active_status = false;
			if($serviceStaff['status']){
				$active_status = true;
                        }
			
                        echo '<td>'. $this->Form->input('SalonStaffService.'.$serviceStaff['staff_id'].'.status' , array('checked'=>$active_status,'data-active-id'=>$serviceStaff['staff_id'],'class'=>'custom_switch serviceStaffStatus','hiddenField'=>true,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')).'</td>';
                        echo '</tr>';
                        
                        if(!empty($flippedids)){
                                unset($flippedids[$serviceStaff['staff_id']]);
                        }
                        
               }
          }else if(isset($salonservice['ServicePricingOption']) && empty($salonservice['ServicePricingOption'])){
		if(isset($SalonStaff) && !empty($SalonStaff)){
		foreach($SalonStaff as $key=>$Staff){
                         echo '<tr data-pl="'.$this->Common->get_price_level_id($Staff['User']['id']).'">';
                        echo '<td>'.$this->Common->get_user_name($Staff['User']['id']).'<dfn>('.$this->Common->get_price_level_name($Staff['User']['id']).')</dfn>'.'</td>';
                       
                        echo $this->Form->hidden('SalonStaffService.'.$Staff['User']['id'].'.staff_id',array('class'=>'','label'=>false,'div'=>false,'value'=>$Staff['User']['id']));
                        echo $this->Form->hidden('SalonStaffService.'.$Staff['User']['id'].'.salon_service_id',array('class'=>'','label'=>false,'div'=>false,'value'=>$serviceId));
                        $active_status = false;
                        echo '<td>'. $this->Form->input('SalonStaffService.'.$Staff['User']['id'].'.status' , array('checked'=>$active_status,'data-active-id'=>$Staff['User']['id'],'class'=>'custom_switch serviceStaffStatus','hiddenField'=>true,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')).'</td>';
                        echo '</tr>';
                 }
                }else{
                        if(empty($flippedids)){
                                echo '<tr><td colspan="2">No service provider found.</td></tr>';
                                echo $this->Form->hidden('service_provider',array('required','validationmessage'=>'At least one service provider is required.'));        
                        }
                        
                }
          }else{
                if(empty($flippedids)){
                        echo '<tr><td colspan="2">No service provider found.</td></tr>';
                        echo $this->Form->hidden('service_provider',array('required','validationmessage'=>'At least one service provider is required.'));
                 }
          }
          
          // if new staff added into the database
          
        if(!empty($flippedids)){
		$newStaffs = array_flip($flippedids);
                foreach($newStaffs as $k=>$staff){
			echo '<tr data-pl="'.$this->Common->get_price_level_id($staff).'">';
                        echo '<td>'.$this->Common->get_user_name($staff).'<dfn>('.$this->Common->get_price_level_name($staff).')</dfn>'.'</td>';
                        echo $this->Form->hidden('SalonStaffService.'.$staff.'.staff_id',array('class'=>'','label'=>false,'div'=>false,'value'=>$staff));
                        echo $this->Form->hidden('SalonStaffService.'.$staff.'.salon_service_id',array('class'=>'','label'=>false,'div'=>false,'value'=>$serviceId));
                        $active_status = false;
                        echo '<td>'. $this->Form->input('SalonStaffService.'.$staff.'.status' , array('checked'=>$active_status,'data-active-id'=>$staff,'class'=>'custom_switch serviceStaffStatus','hiddenField'=>true,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')).'</td>';
                        echo '</tr>';
                }
                
        }
         ?>
        </tbody>
</table>
<input type="hidden" id="employeeCheckRequired" name="employeeCheckRequired"  required=true value="1"  validationmessage="Please activate employee for the respective pricing option." >
								<dfn class="text-danger k-invalid-msg" data-for="employeeCheckRequired" role="alert" style="display: none;">Please activate employee for the respective pricing option.</dfn>
  <script>
  $(document).ready(function(){
        $(".serviceStaffStatus").bootstrapSwitch();      
  })
  </script>
