<?php
		    if(isset($spabreaks)&& !empty($spabreaks)){
		      foreach($spabreaks as $spabreak){
		      ?>
		      
		         <div class="v-deal">
                    <div class="v-deal-box">
                        <div class="upper">
			 <?php
			  echo $this->Html->image($this->Common->getspabreakImage($spabreak['Spabreak']['id'],$auth_user['User']['id'],350),array('class'=>" ")); 
			 ?>
			 
                        </div>
                    
                        <div class="bottom <?php if(!$spabreak['Spabreak']['status']){ echo 'dull'; } ?>">
                            <p class="p1"><?php echo $spabreak['Spabreak']['eng_name'];?></p>
                            <p class="p2">
                            <?php
                                $spaBreakPrice = $this->Common->get_spabreakPrice($spabreak['Spabreak']['id']);
                            
                            if($spaBreakPrice['from']){
                                        echo 'from AED '.$spaBreakPrice['full'].'';
                                    }
                                    elseif($spaBreakPrice['sell']){
                                        echo '<span>AED'.$spaBreakPrice['full'].' </span><b> AED '.$spaBreakPrice['sell'].'</b>';
                                    }
                                    else{
                                        echo 'AED '. $spaBreakPrice['full']; 
                                    }
                            
                            ?>
                            
                            
                            <p class="p3">
                                <button class="active-deactive <?php echo ($spabreak['Spabreak']['status'])?'active':'';?>" data-id="<?php echo $spabreak['Spabreak']['id']?>" type="button">
                                    <?php echo ($spabreak['Spabreak']['status'])? 'Deactivate':'Activate'; ?></button>
                                <a href="javascript:void(0)" class="deleteSpabreak" data-id="<?php echo $spabreak['Spabreak']['id'];?>" ><i class="fa  fa-trash-o"></i></a>
                                <a href="javascript:void(0);" data-id="<?php echo $spabreak['Spabreak']['id'];?>" class="addSpaBreak" ><i class="fa fa-pencil"></i></a>		
                            </p>
                        </div>
                    </div>
                </div>
		    <?php  }}else{
		      echo "Please add Spabreak";  
		    }
		?>
	
		<div class="clear"></div>
		
                    