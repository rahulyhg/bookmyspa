<h2>Facility Information</h2>
<ul class="profile">
    <li>
        <label>Kid Friendly: </label>
        <section>
        <?php
			if(isset($facilityData['FacilityDetail']['kids'])){
			    $kidsFriendly = $this->Common->kidsfrnd();
			    echo (!empty($facilityData['FacilityDetail']['kids']))? $kidsFriendly[$facilityData['FacilityDetail']['kids']] : '--';
			}else{
			    echo "--";
			}
                    ?>
        </section>
    </li>
   
    <li>
        <label>Payment Method:</label>
        <section>
        <?php if(isset($facilityData['FacilityDetail']['payment_method']) && !empty($facilityData['FacilityDetail']['payment_method'])){
			$paymentType = $this->Common->paymentTypes();
			if($paymentType){
			    echo '<ul class="unstyled">';
			    foreach($paymentType as $pT=>$pTypeVal){ 
				$checked = false;
				if(!empty($facilityData['FacilityDetail']['payment_method'])){
				    if(in_array($pT,unserialize($facilityData['FacilityDetail']['payment_method']))){
					 echo "<li>".$pTypeVal."</li>"; 
				    }
				}
			    }
			     echo '</ul>';
			}
			else{
			    echo '--'; 
			}
		    }else{
			echo '--';
		    } ?>
        </section>
    </li>
    <li>
        <label>Parking Fees:</label>
        <section>
         <?php if(isset($facilityData['FacilityDetail']['parking_fee']) && !empty($facilityData['FacilityDetail']['parking_fee'])){
			    $parkingFee = $this->Common->parkingFee();
			    if($parkingFee){
				echo '<ul class="unstyled">';
				foreach($parkingFee as $pFe=>$pFee){ 
				    if(!empty($facilityData['FacilityDetail']['parking_fee'])){
					if(in_array($pFe,unserialize($facilityData['FacilityDetail']['parking_fee']))){
					     echo "<li>".$pFee."</li>"; 
					}
				    }
				}
				 echo '</ul>';
			    }
			    else{
				echo '--'; 
			    }
			}else{
			    echo '--';
			} ?>
        </section>
    </li>
     <li>
        <label>Accept Walk-in: </label>
        <section>
        <?php
			if(isset($facilityData['FacilityDetail']['walk_in'])){
			    $kidsFriendly = $this->Common->kidsfrnd();
			    echo ($facilityData['FacilityDetail']['walk_in'])? 'Yes' : 'No';
			}else{
			    echo "--";
			}
                    ?>
        </section>
    </li>
    <li>
        <label>WIFI Access: </label>
        <section> 
        <?php
			if(isset($facilityData['FacilityDetail']['wifi'])){
			    echo ($facilityData['FacilityDetail']['wifi'])? 'Yes' : 'No';
			}else{
			    echo "--";
			}
                    ?>
        </section>
    </li>
    <li>
        <label>Snack Bar: </label>
        <section>
        <?php
			if(isset($facilityData['FacilityDetail']['snack_bar'])){
			    echo ($facilityData['FacilityDetail']['snack_bar'])? 'Yes' : 'No';
			}else{
			    echo "--";
			}
                    ?>
        </section>
    </li>
    <li>
        <label>Beer and Wine Bar:</label>
        <section>
         <?php
			if(isset($facilityData['FacilityDetail']['beer_wine_bar'])){
			    echo ($facilityData['FacilityDetail']['beer_wine_bar'])? 'Yes' : 'No';
			}else{
			    echo "--";
			}
                    ?>
        </section>
    </li>
    <li>
        <label>TV: </label>
        <section>
         <?php
			if(isset($facilityData['FacilityDetail']['tv'])){
			    echo ($facilityData['FacilityDetail']['tv'])? 'Yes' : 'No';
			}else{
			    echo "--";
			}
                    ?>
        </section>
    </li>
    <li>
        <label>Handicap Access: </label>
        <section>
         <?php
			if(isset($facilityData['FacilityDetail']['hadicap_acces'])){
			    echo ($facilityData['FacilityDetail']['hadicap_acces'])? 'Yes' : 'No';
			}else{
			    echo "--";
			}
                    ?>
        </section>
    </li>
    <li>
        <label>Spoken Languages:</label>
        <section>
        <?php if(isset($facilityData['FacilityDetail']['spoken_language']) && !empty($facilityData['FacilityDetail']['spoken_language'])){
			    $spokenLang = $this->Common->spokenLang();
			    if($spokenLang){
				echo '<ul class="unstyled">';
				foreach($spokenLang as $sL=>$sLang){ 
				    if(!empty($facilityData['FacilityDetail']['spoken_language'])){
					if(in_array($sL,unserialize($facilityData['FacilityDetail']['spoken_language']))){
					     echo "<li>".$sLang."</li>"; 
					}
				    }
				}
				 echo '</ul>';
			    }
			    else{
				echo '--'; 
			    }
			}else{
			    echo '--';
			} ?>
        </section>
    </li>
    <li>
        <label>Other Languages: </label>
        <section><?php echo (isset($facilityData['FacilityDetail']['other_lang']) && !empty($facilityData['FacilityDetail']['other_lang']) )? $facilityData['FacilityDetail']['other_lang'] :'--';?></section>
    </li>
    <li>
        <label>Cancellation Policy<dfn>(English)</dfn>:</label>
        <section><?php echo (isset($facilityData['FacilityDetail']['eng_cancel_policy']) && !empty($facilityData['FacilityDetail']['eng_cancel_policy']) )? $facilityData['FacilityDetail']['eng_cancel_policy'] :'--';?></section>
    </li>
    <li>
        <label>Cancellation Policy<dfn>(Arabic)</dfn>:</label>
        <section><?php echo (isset($facilityData['FacilityDetail']['ara_cancel_policy']) && !empty($facilityData['FacilityDetail']['ara_cancel_policy']) )? $facilityData['FacilityDetail']['ara_cancel_policy'] :'--';?></section>
    </li>
    <li>
        <label>Special Instruction<dfn>(English)</dfn>: </label>
        <section>
        <?php echo (isset($facilityData['FacilityDetail']['eng_special_instruction']) && !empty($facilityData['FacilityDetail']['eng_special_instruction']) )? $facilityData['FacilityDetail']['eng_special_instruction'] :'--';?>
        </section>    
    </li>
    <li>
        <label>Special Instruction<dfn>(Arabic)</dfn>: </label>
        <section>
        <?php echo (isset($facilityData['FacilityDetail']['ara_special_instruction']) && !empty($facilityData['FacilityDetail']['ara_special_instruction']) )? $facilityData['FacilityDetail']['ara_special_instruction'] :'--';?>
        </section>    
    </li>
</ul>