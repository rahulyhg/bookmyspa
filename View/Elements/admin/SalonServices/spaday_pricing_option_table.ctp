<?php

if(!isset($spaday['SpadayPricingOption']) || ( isset($spaday['SpadayPricingOption']) && ( empty($spaday['SpadayPricingOption']) || count($spaday['SpadayPricingOption']) == 1) )){ ?>
    <?php
    $forthisdata = array('id'=>'','spaday_id' =>isset($spaday['Spaday']['id']) ? $spaday['Spaday']['id'] :'' ,'user_id' =>$auth_user['User']['id'],'pricing_level_id'=>'','duration'=>30,'full_price'=>'','sell_price'=>'','custom_title'=>'','points_given'=>'','points_redeem'=>'','quantity'=>'');
    if(!empty($package['SpadayPricingOption'])){
        $forthisdata = $package['SpadayPricingOption'][0];
        
    }
    
    ?> 
    <div class="form-group">
       <section>
            <div class="col-sm-7 lft-p-non">
             <label class="">Weekdays :</label>
                <div id="weekDays" class="week-days col-sm-8 lft-p-non">
                    <div class="col-sm-1">
                            <?php echo $this->Form->input('SpadayPricingOption.sun', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control')); ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php echo $this->Form->input('SpadayPricingOption.mon', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'M'), 'div' => false, 'class' => 'form-control')); ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php echo $this->Form->input('SpadayPricingOption.tue', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'T'), 'div' => false, 'class' => 'form-control')); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php echo $this->Form->input('SpadayPricingOption.wed', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'W'), 'div' => false, 'class' => 'form-control')); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php echo $this->Form->input('SpadayPricingOption.thr', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'T'), 'div' => false, 'class' => 'form-control')); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php echo $this->Form->input('SpadayPricingOption.fri', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'F'), 'div' => false, 'class' => 'form-control')); ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php echo $this->Form->input('SpadayPricingOption.sat', array('type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control')); ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
 
         <div class="form-group">
         <section>
                <div class="col-sm-6 lft-p-non">
                   <label class="">Full Price :</label>
                   <div class="col-sm-12 lft-p-non">
                       <?php echo $this->Form->hidden('SpadayPricingOption.id',array('value'=>$forthisdata['id'],'label'=>false,'div'=>false,'class'=>'form-control')); ?>
                       <?php echo $this->Form->hidden('SpadayPricingOption.spaday_id',array('value'=>$forthisdata['spaday_id'],'label'=>false,'div'=>false,'class'=>'spaday_id form-control')); ?>
                       <?php echo $this->Form->input('SpadayPricingOption.full_price',array('value'=>$forthisdata['full_price'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>true)); ?>
                   </div>
                </div>
                <div class="col-sm-6 lft-p-non">
                   <label class="">Sell Price :</label>
                   <div class="col-sm-12 lft-p-non">
                       <?php echo $this->Form->input('SpadayPricingOption.sell_price',array('value'=>$forthisdata['sell_price'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>false)); ?>
                   </div>
                </div>
        </section>
        </div>
        
       <!-- <div class="form-group">
        <section>
            <div class="col-sm-6 lft-p-non">
               <label class="">Points Given :</label>
               <div class="col-sm-12 lft-p-non">
                   <?php echo $this->Form->input('ServicePricingOption.points_given',array('value'=>$forthisdata['points_given'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>false)); ?>
               </div>
            </div>
            <div class="col-sm-6 lft-p-non">
               <label class="">Points Redeemed:</label>
               <div class="col-sm-12 lft-p-non">
                   <?php echo $this->Form->input('ServicePricingOption.points_redeem',array('value'=>$forthisdata['points_redeem'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>false)); ?>
               </div>
            </div>
        </section>
        </div>
        <div class="form-group">
            <section>
                <div class="col-sm-6 lft-p-non">
                    <label class="">Custom Title:</label>
                    <div class="col-sm-12 lft-p-non">
                       <?php echo $this->Form->input('ServicePricingOption.custom_title',array('value'=>$forthisdata['custom_title'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control col-sm-9')); ?>              </div>
                </div>
                <div class="col-sm-6 lft-p-non stockQuantity" id="stockQuantity" style="<?php echo ((isset($salonservice['SalonService']['inventory']))&&($salonservice['SalonService']['inventory']==1)) ? '' :'display:none;';?> ">
                   <label class="col-sm-12 lft-p-non">Inventory :</label>
                   <div class="col-sm-12 lft-p-non">
                       <?php echo $this->Form->input('ServicePricingOption.quantity',array('value'=>$forthisdata['quantity'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control')); ?>
                   </div>
                </div>
            </section>
        </div>-->
       
       
<?php
}
else{ ?>

<div class="col-sm-12 lft-p-non rgt-p-non">
<table class="table tbl-bod">
                <thead>	
                        <tr>
                                <th colspan="4">Price</th>
                                <!--<th>Duration</th>
                                <th>Full Price</th>
                                <th>Sell Price</th>
                                <th>Points Given</th>
                                <th>Points Redeem</th>
                                <th>Remove</th>-->
                        </tr>
                </thead>
                <tbody>
                <?php
                    if(isset($salonservice['SpadayPricingOption']) && (!empty($salonservice['SpadayPricingOption']))){
                        foreach($salonservice['SpadayPricingOption'] as $pricingOption){
                                echo '<tr data-id="'.$pricingOption['id'].'" class="pricingOptiontr" >';
                                echo 	'<td>'.(!empty($pricingOption["custom_title"]) ? $pricingOption["custom_title"] :$this->Common->get_pricing_option_name($pricingOption["pricing_level_id"])).'</td>';
                                echo 	'<td>'.date('H:i', mktime(0,$pricingOption["duration"])).'</td>';
                                //echo 	'<th>'.'$'.$pricingOption["full_price"].'</th>';
                                echo 	'<td>'.'AED'.$pricingOption["full_price"].'</td>';
                                $display='';
                                if($salonservice['SalonService']['inventory']!=1){
                                    $display = "display:none";
                                }
                                echo 	'<td class="stockQuantity" style="'.$display.'">'.$pricingOption["quantity"].' available</td>';
                                
                                //echo 	'<th>'.$pricingOption["points_given"].'</th>';
                                //echo 	'<th>'.$pricingOption["points_redeem"].'</th>';
                               // echo 	'<th>'.$this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','data-id'=>$pricingOption["id"],'class'=>'savedpricingOption','escape'=>false)).'</th>';
                                echo '</tr>';
                        }
                }
                ?>
                </tbody>
</table>
</div>
<?php
}
?>


