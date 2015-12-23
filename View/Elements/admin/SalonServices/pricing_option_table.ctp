<style>
    .linethr{
        text-decoration: line-through;
    }
</style>
<?php

if(!isset($salonservice['ServicePricingOption']) || ( isset($salonservice['ServicePricingOption']) && ( empty($salonservice['ServicePricingOption']) || count($salonservice['ServicePricingOption']) == 1) )){ ?>
    <?php
    $forthisdata = array('id'=>'','salon_service_id' =>isset($salonservice['SalonService']['id']) ? $salonservice['SalonService']['id'] :'' ,'user_id' =>$auth_user['User']['id'],'pricing_level_id'=>'','duration'=>0,'full_price'=>'','sell_price'=>'','custom_title_eng'=>'','custom_title_ara'=>'','points_given'=>'','points_redeem'=>'','quantity'=>'');
    if(!empty($salonservice['ServicePricingOption'])){
        $forthisdata = $salonservice['ServicePricingOption'][0];
    }
    
    ?> 
    <div class="form-group clearfix">
        <section>
             <div class="col-sm-6 lft-p-non price_level_drop_down">
                <label class="control-label col-sm-12 nopadding">Pricing Level :</label>
                  <?php
                  $priceOpts = $this->common->get_price_level();
                  $priceOpts[0] = 'Same Price for All Staff';
                  $default =0;
                  if(isset($forthisdata['pricing_level_id']) && $forthisdata['pricing_level_id']){
                    $default = $forthisdata['pricing_level_id'];
                  }
                  echo $this->Form->input('ServicePricingOption.pricing_level_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control full-w pricingLevelStaff', 'options' => $priceOpts, 'default'=>$default,'required'=>false)); ?>
                  <input name="pricelevel" id="level" type="hidden" validationmessage="There is no staff associated with this pricing level." required="true" value="1">
                  <dfn class="text-danger k-invalid-msg" data-for="pricelevel" role="alert" style="display: none;">There is no staff associated with this pricing level.</dfn>
             </div>
             
      
        <div class="col-sm-6 nopadding">
          <label class="control-label col-sm-12 nopadding">Duration :</label>
                  <?php echo $this->Form->input('ServicePricingOption.duration', array('type' => 'select', 'label' => false, 'div' => array('class'=>'col-sm-12 nopadding'),'empty'=>'Please select', 'class' => 'form-control full-w', 'default'=>$forthisdata['duration'],'options' => $this->common->get_validduration(),'required'=>true,'validationMessage'=>'Please select duration.')); ?>
            
        </div>
          </section>
    </div>
    
        
         <div class="form-group clearfix">
         <section>
                <div class="col-sm-6 lft-p-non">
                   <label class="">Full Price *:</label>
                   <div class="col-sm-12 nopadding ">
                       <?php echo $this->Form->hidden('ServicePricingOption.id',array('value'=>$forthisdata['id'],'label'=>false,'div'=>false,'class'=>'form-control')); ?>
                       <?php echo $this->Form->hidden('ServicePricingOption.salon_service_id',array('value'=>$forthisdata['salon_service_id'],'label'=>false,'div'=>false,'class'=>'salon_service_id form-control')); ?>
                       <?php echo $this->Form->input('ServicePricingOption.full_price',array('value'=>$forthisdata['full_price'],'type'=>'text','label'=>false,'div'=>false,'validationMessage'=>"Full price is required.",'class'=>'form-control','required'=>true,'maxlengthcustom'=>'10','data-maxlengthcustom-msg'=>"Maximum 10 numbers are allowed.",'pattern'=>"^[0-9]+(\\.[0-9]+)?$" ,'data-pattern-msg'=>'Please enter the valid price.')); ?>
                   </div>
                </div>
                <div class="col-sm-6 nopadding">
                   <label class="">Sale Price :</label>
                   <div class="col-sm-12 nopadding">
                       <?php echo $this->Form->input('ServicePricingOption.sell_price',array('value'=>$forthisdata['sell_price'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','maxlengthcustom'=>'10','data-maxlengthcustom-msg'=>"Maximum 10 numbers are allowed.",'required'=>false,'matchfullprice','data-compare-field'=>'data[ServicePricingOption][full_price]','pattern'=>"^[0-9]+(\\.[0-9]+)?$" ,'data-pattern-msg'=>'Please enter the valid price.','data-matchfullprice-msg'=>'Sale price should be less than full price.')); ?>
                   </div>
                </div>
        </section>
        </div>
        
        <div class="form-group clearfix">
        <section>
            <div class="col-sm-6 lft-p-non">
               <label class="">Points Given :</label>
               <div class="col-sm-12 nopadding">
                   <?php echo $this->Form->input('ServicePricingOption.points_given',array('value'=>$forthisdata['points_given'],'type'=>'text','label'=>false,'div'=>false,'maxlengthcustom'=>'5','data-maxlengthcustom-msg'=>"Maximum 5 numbers are allowed.",'pattern'=>"^[0-9]+(\\.[0-9]+)?$" ,'data-pattern-msg'=>'Please enter the valid numeric value.','class'=>'form-control','required'=>false)); ?>
               </div>
            </div>
            <div class="col-sm-6 nopadding">
               <label class="">Points Redeemed:</label>
               <div class="col-sm-12 nopadding ">
                   <?php echo $this->Form->input('ServicePricingOption.points_redeem',array('value'=>$forthisdata['points_redeem'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','pattern'=>"^[0-9]+(\\.[0-9]+)?$" ,'data-pattern-msg'=>'Please enter the valid numeric value.','maxlengthcustom'=>'5','data-maxlengthcustom-msg'=>"Maximum 5 numbers are allowed.",'required'=>false)); ?>
               </div>
            </div>
        </section>
        </div>
        <div class="form-group clearfix">
            <section>
                <div class="col-sm-6 lft-p-non">
                    <label class="">Custom Title <i>(English) </i>*:</label>
                    <div class="col-sm-12 nopadding">
                       <?php echo $this->Form->input('ServicePricingOption.custom_title_eng',array('value'=>$forthisdata['custom_title_eng'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control col-sm-9','minlength'=>'3','maxlengthcustom'=>'100','validationMessage'=>"Custom title is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'required'=>true)); ?></div>
                </div>
                 <div class="col-sm-6 nopadding">
                    <label class="">Custom Title <i>(Arabic) </i> </label>
                    <div class="col-sm-12 nopadding">
                       <?php echo $this->Form->input('ServicePricingOption.custom_title_ara',array('value'=>$forthisdata['custom_title_ara'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control col-sm-9','minlength'=>'3','maxlengthcustom'=>'100','data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.")); ?></div>
                </div>
                
            </section>
        </div>
        <div class="form-group">
            <div class="col-sm-6 lft-p-non stockQuantity" id="stockQuantity" style="<?php echo ((isset($salonservice['SalonService']['inventory']))&&($salonservice['SalonService']['inventory']==1)) ? '' :'display:none;';?> ">
                
                   <label class="col-sm-12 lft-p-non">Inventory :</label>
                   <div class="col-sm-12 nopadding">
                       <?php echo $this->Form->input('ServicePricingOption.quantity',array('value'=>$forthisdata['quantity'],'type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','maxlengthcustom'=>'5','data-maxlengthcustom-msg'=>"Maximum 5 numbers are allowed.",'required'=>false,'pattern'=>"\d+",'data-pattern-msg'=>'Please enter the valid numeric value.')); ?>
                   </div>
                </div>
        </div>
        <?php echo $this->Form->input('total_pricing_ids',array('id'=>'SalonServiceTotalPricingIds','type'=>'hidden','data-id'=>$default)); ?>
<?php
}
else{ ?>

<div class="col-sm-12 lft-p-non rgt-p-non">
<table class="table tbl-bod">
                <thead>	
                        <tr>
                               
                                <th colspan="4" >Price</th>
                                <!--<th>Duration</th>
                                <th colspan="2">Price</th>-->
                        </tr>
                </thead>
                <tbody>
                <?php
                  $pricing_ids = array();
                    if(isset($salonservice['ServicePricingOption']) && (!empty($salonservice['ServicePricingOption']))){
                        foreach($salonservice['ServicePricingOption'] as $pricingOption){
                                echo '<tr data-id="'.$pricingOption['id'].'" class="pricingOptiontr" >';
                                echo 	'<td>'.(!empty($pricingOption["custom_title_eng"]) ? $pricingOption["custom_title_eng"] :'').'(<i>'.$this->Common->get_pricing_option_name($pricingOption["pricing_level_id"]).'</i>)</td>';
                                echo 	'<td>'.date('H:i', mktime(0,$pricingOption["duration"])).'</td>';
                                $Price = ($pricingOption["sell_price"]==' ' || $pricingOption["sell_price"]==0) ? 'AED '.$pricingOption["full_price"] : '<span class="linethr">'.'AED '.$pricingOption["full_price"].'</span>  AED '.$pricingOption["sell_price"];
                                echo 	'<td>'.$Price.'</td>';
                                $display='';
                                if($salonservice['SalonService']['inventory']!=1){
                                    $display = "display:none";
                                }
                                $availability = ($pricingOption["quantity"]==' ' || $pricingOption["quantity"]==0) ? '0 available' : $pricingOption["quantity"].' available'; 
                                echo 	'<td class="stockQuantity" style="'.$display.'">'.$availability.'</td>';

                                echo '</tr>';
                                $pricing_ids[]= $pricingOption["pricing_level_id"];
                        }
                }
                
                ?>
                <?php
                   
                echo $this->Form->input('total_pricing_ids',array('id'=>'SalonServiceTotalPricingIds','type'=>'hidden','data-id'=>implode(',',$pricing_ids))); ?> 
                </tbody>
</table>
</div>
<?php
}
?>


