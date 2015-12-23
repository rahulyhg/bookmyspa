<?php

if(!isset($package['PackagePricingOption']) || ( isset($package['PackagePricingOption']) && ( empty($package['PackagePricingOption']) || count($package['PackagePricingOption']) == 1) )){ ?>
    <?php
    $forthisdata = array('id'=>'','package_id' =>isset($package['Package']['id']) ? $package['Package']['id'] :'' ,'user_id' =>$auth_user['User']['id'],'pricing_level_id'=>'','duration'=>30,'full_price'=>'','sell_price'=>'','custom_title'=>'','points_given'=>'','points_redeem'=>'','quantity'=>'');
    if(!empty($package['PackagePricingOption'])){
        $forthisdata = $package['PackagePricingOption'][0];
        
    }
    
    ?> 
    <div class="form-group">
        
        <label class="control-label">Pricing Options :</label>
        <section>
             <div class="">
                  <?php echo $this->Form->input('PackagePricingOption.pricing_level_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'options' => $this->common->get_price_level(), 'empty' => 'Same Price for All Staff','default'=>$forthisdata['pricing_level_id'],'required'=>false)); ?>
             </div>
             <div class="">
              <?php echo $this->Form->button('Add Pricing Level',array('type'=>'button','label'=>false,'div'=>false,'class'=>'btn btn-primary add_pricing_level')); ?>
             </div>
        </section>
       </div>
    <div class="form-group">
        
            <label class="control-label col-sm-8 lft-p-non">Duration :</label>
            <section>
                <?php echo $this->Form->input('PackagePricingOption.duration', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control', 'default'=>$forthisdata['duration'],'options' => $this->common->get_duration())); ?>
            </section>
        
    </div>
    
        
         <div class="form-group">
         <section>
                <div class="col-sm-6 lft-p-non">
                   <label class="">Full Price :</label>
                   <div class="col-sm-12 lft-p-non">
                       <?php echo $this->Form->hidden('PackagePricingOption.id',array('value'=>$forthisdata['id'],'label'=>false,'div'=>false,'class'=>'form-control')); ?>
                       <?php echo $this->Form->hidden('PackagePricingOption.package_id',array('value'=>$forthisdata['package_id'],'label'=>false,'div'=>false,'class'=>'package_id form-control')); ?>
                       <?php echo $this->Form->input('PackagePricingOption.full_price',array('value'=>$forthisdata['full_price'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>true)); ?>
                   </div>
                </div>
                <div class="col-sm-6 lft-p-non">
                   <label class="">Sell Price :</label>
                   <div class="col-sm-12 lft-p-non">
                       <?php echo $this->Form->input('PackagePricingOption.sell_price',array('value'=>$forthisdata['sell_price'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>false)); ?>
                   </div>
                </div>
        </section>
        </div>
        
        <div class="form-group">
        <section>
            <div class="col-sm-6 lft-p-non">
               <label class="">Points Given :</label>
               <div class="col-sm-12 lft-p-non">
                   <?php echo $this->Form->input('PackagePricingOption.points_given',array('value'=>$forthisdata['points_given'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>false)); ?>
               </div>
            </div>
            <div class="col-sm-6 lft-p-non">
               <label class="">Points Redeemed:</label>
               <div class="col-sm-12 lft-p-non">
                   <?php echo $this->Form->input('PackagePricingOption.points_redeem',array('value'=>$forthisdata['points_redeem'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>false)); ?>
               </div>
            </div>
        </section>
        </div>
        <div class="form-group">
            <section>
                <div class="col-sm-6 lft-p-non">
                    <label class="">Custom Title:</label>
                    <div class="col-sm-12 lft-p-non">
                       <?php echo $this->Form->input('PackagePricingOption.custom_title',array('value'=>$forthisdata['custom_title'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control col-sm-9')); ?>              </div>
                </div>
                <div class="col-sm-6 lft-p-non stockQuantity" id="stockQuantity" style="<?php echo ((isset($package['Package']['inventory']))&&($package['Package']['inventory']==1)) ? '' :'display:none;';?> ">
                   <label class="col-sm-12 lft-p-non">Inventory :</label>
                   <div class="col-sm-12 lft-p-non">
                       <?php echo $this->Form->input('PackagePricingOption.quantity',array('value'=>$forthisdata['quantity'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control')); ?>
                   </div>
                </div>
            </section>
        </div>
       
       
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
                    if(isset($package['PackagePricingOption']) && (!empty($package['PackagePricingOption']))){
                        foreach($package['PackagePricingOption'] as $pricingOption){
                                echo '<tr data-id="'.$pricingOption['id'].'" class="pricingOptiontr" >';
                                echo 	'<td>'.(!empty($pricingOption["custom_title"]) ? $pricingOption["custom_title"] :$this->Common->get_pricing_option_name($pricingOption["pricing_level_id"])).'</td>';
                                echo 	'<td>'.date('H:i', mktime(0,$pricingOption["duration"])).'</td>';
                                //echo 	'<th>'.'$'.$pricingOption["full_price"].'</th>';
                                echo 	'<td>'.'AED'.$pricingOption["sell_price"].'</td>';
                                $display='';
                                if($package['Package']['inventory']!=1){
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


