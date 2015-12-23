<?php
    if(isset($Spabreak['SpabreakOption']) && !empty($Spabreak['SpabreakOption'])){
        foreach($Spabreak['SpabreakOption'] as $key=>$options){
    ?>
    <div class="box-title">
        <h3>Option <?php echo $key+1; ?></h3>
        <?php echo $this->Html->Link('<i class="fa  fa-trash-o pull-right pdng-tp13"></i>','javascript:void(0)',array('title'=>'Delete pricing option.','data-id'=>$options['id'],'class'=>'deleteSpabreak-Option','escape'=>false)) ?>
        
    </div>
    <div class="form-group pdngtop10">
            <section>
               <div class="col-sm-6 lft-p-non">
                    <label class="">Hotel Rooms:</label>
                    <?php  echo $this->Common->get_room_name($options['salon_room_id']);?>
               </div>
            </section>
       
            <section>
               <div class="col-sm-6 lft-p-non">
                    <label class="">Max.booking per day:</label>
                    <?php  echo $options['max_booking_perday'];?>
               </div>
            </section>
    </div>
    <div class="form-group">
   
<?php
  
  $dayCount = 7;  
 foreach($options['SpabreakOptionPerday'] as $daykey=>$optionsPerDay){
   
?> 
    
<section>
    <div class="col-sm-10 lft-p-non ">
    
        <div id="weekDays" class="week-days col-sm-8 lft-p-non ">
           <?php if(($optionsPerDay['sunday']== 0)){?>
                <div class="col-sm-1">
                    <i class="fa fa-ban"></i><span>S</span>   
               </div>
            <?php }else{
                $dayCount--;
                ?>
                 <div class="col-sm-1 green-on">
                    <i class="fa fa-check"></i><span>S</span>   
                 </div>
            <?php } ?>
            <?php if(($optionsPerDay['monday']== 0)){?>
                <div class="col-sm-1">
                    <i class="fa fa-ban"></i><span>M</span>   
               </div>
            <?php }else{
                $dayCount--;
                ?>
                 <div class="col-sm-1 green-on">
                    <i class="fa fa-check"></i><span>M</span>   
                 </div>
            <?php } ?>
            <?php if(($optionsPerDay['tuesday']== 0)){?>
                <div class="col-sm-1">
                    <i class="fa fa-ban"></i><span>T</span>   
               </div>
            <?php }else{
                $dayCount--;
                ?>
                 <div class="col-sm-1 green-on">
                    <i class="fa fa-check"></i><span>T</span>   
                 </div>
            <?php } ?>
            <?php if(($optionsPerDay['wednesday']== 0)){?>
                <div class="col-sm-1">
                    <i class="fa fa-ban"></i><span>W</span>   
               </div>
            <?php }else{
                $dayCount--;
                ?>
                 <div class="col-sm-1 green-on">
                    <i class="fa fa-check"></i><span>W</span>   
                 </div>
            <?php } ?>
            <?php if(($optionsPerDay['thursday']== 0)){?>
                <div class="col-sm-1">
                    <i class="fa fa-ban"></i><span>T</span>   
               </div>
            <?php }else{
                $dayCount--;
                ?>
                 <div class="col-sm-1 green-on">
                    <i class="fa fa-check"></i><span>T</span>   
                 </div>
            <?php } ?>
            <?php if(($optionsPerDay['friday']== 0)){
                
                ?>
                <div class="col-sm-1">
                    <i class="fa fa-ban"></i><span>F</span>   
               </div>
            <?php }else{
                $dayCount--;
                ?>
                 <div class="col-sm-1 green-on">
                    <i class="fa fa-check"></i><span>F</span>   
                 </div>
            <?php } ?>
            <?php if(($optionsPerDay['saturday']== 0)){?>
                <div class="col-sm-1">
                    <i class="fa fa-ban"></i><span>S</span>   
               </div>
            <?php }else{
                $dayCount--;
                ?>
                 <div class="col-sm-1 green-on">
                    <i class="fa fa-check"></i><span>S</span>   
                 </div>
            <?php } ?>
           
        </div>
       
    </div>
    <div class="col-sm-2 lft-p-non rgt-p-non pdngtop8">
              <?php
              echo 'AED '. empty($optionsPerDay['sell_price']) ? $optionsPerDay['sell_price'] : $optionsPerDay['full_price'] ?><?php echo $this->Html->Link('<i class="fa fa-pencil pull-right"></i>','javascript:void(0)',array('title'=>'Edit Pricing Option for days ','data-id'=>$optionsPerDay['id'],'class'=>'add_pricing_day','escape'=>false));
              ?>
    </div>
</section>
<!--<section>
    <div class="col-sm-1 pdngtop18">
             <?php echo $this->Html->Link('(edit)','javascript:void(0)',array('title'=>'Edit Pricing Option for days ','data-id'=>$optionsPerDay['id'],'class'=>'add_pricing_day','escape'=>false)) ?></php>
    </div>
<section>-->
<section>
    
</section>

<?php }?>
      <section>
      <?php
      $style ='';
      if($dayCount<=0){
        $style="display:none";
        }?>
            <div class="col-sm-5 pdngtop35" style="<?php echo $style;?>" >
                <div class="col-sm-12">
                 <?php echo $this->Html->Link(' <i class="fa fa-plus">Add New</i>','javascript:void(0)',array('title'=>'Edit Pricing Option for days ','data-id'=>'notset','data-option-id'=>$options['id'],'class'=>'add_pricing_day','escape'=>false)) ?></php>
                </div>
            </div>
        </section>
    </div>
   
    <?php }}else{ ?>
        
    <div class="form-group pdngtop10">
            <section>
               <div class="col-sm-6 lft-p-non">
                    <label class="">Select Room*:</label>
                    <?php
                    
                    echo $this->Form->hidden('SpabreakOption.spabreak_id',array('label'=>false,'div'=>false,'class'=>'form-control'));
                    echo $this->Form->input('SpabreakOption.salon_room_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control full-w', 'options' => $this->common->get_room_options($auth_user['User']['id']))); ?>
               </div>
            </section>
       
            <section>
               <div class="col-sm-6 lft-p-non">
                    <label class="">Max.booking per day*:</label>
                    <?php  echo $this->Form->input('SpabreakOption.max_booking_perday', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control full-w', 'options' => $this->common->getNumberRange($auth_user['User']['id']))); ?>
               </div>
            </section>
    </div>
                             <div class="form-group">
       <section>
            <div class="col-sm-12 lft-p-non">
             <label class="col-sm-12 nopadding">Weeksdays*:</label>
             <div class="col-sm-9 nopadding">
                <div id="weekDays" class="week-days">
                    <div class="col-sm-1">
                            <?php
                             echo $this->Form->input('SpabreakOptionPerday.sunday', array('type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'S'), 'div' => false, 'class' => 'form-control days','checked'=>true));
                            ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php
                            
                            echo $this->Form->input('SpabreakOptionPerday.monday', array('type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'M'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php
                            
                            echo $this->Form->input('SpabreakOptionPerday.tuesday', array('type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'T'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php
                           
                            echo $this->Form->input('SpabreakOptionPerday.wednesday', array('type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'W'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php
                            
                            echo $this->Form->input('SpabreakOptionPerday.thursday', array('type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'T'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php
                           
                            echo $this->Form->input('SpabreakOptionPerday.friday', array('type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'F'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php
                            
                            echo $this->Form->input('SpabreakOptionPerday.saturday', array('type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'S'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                            <?php
                             echo $this->Form->input('dayDynamic', array('id'=>'dayDynamic','type' => 'hidden',  'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    
                </div>
             </div>
                <div class="col-sm-3 add-day pdng0 addDayLink" style="display:none">
                   <?php echo $this->Html->Link(' <i class="fa fa-plus">Add New</i>','javascript:void(0)',array('title'=>'Edit Pricing Option for days ','data-id'=>'','class'=>'add_pricing_day','escape'=>false)) ?></php>
                </div>
                
            </div>
            
        </section>
       
         
    </div>
    <div class="form-group">
        <section>
               <div class="col-sm-6 lft-p-non">
                  <label class="">Full Price(AED)*:</label>
                  <div class="col-sm-12 lft-p-non">
                      <?php echo $this->Form->hidden('SpabreakOptionPerday.id',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                      <?php echo $this->Form->hidden('SpabreakOptionPerday.spabreak_option_id',array('label'=>false,'div'=>false,'class'=>'salon_service_id form-control')); ?>
                      <?php echo $this->Form->input('SpabreakOptionPerday.full_price',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','validationMessage'=>"Full price is required.",'class'=>'form-control','required'=>true,'pattern'=>"^\d{0,5}(\.\d{0,2})?$" ,'data-pattern-msg'=>'Please enter the valid price.')); ?>
                  </div>
               </div>
               <div class="col-sm-6 lft-p-non">
                  <label class="">Sell Price(AED)*:</label>
                  <div class="col-sm-12 lft-p-non">
                      <?php echo $this->Form->input('SpabreakOptionPerday.sell_price',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>false,'matchfullprice','data-compare-field'=>'data[SpabreakOptionPerday][full_price]','pattern'=>"^[0-9]+(\.\d{0,2})?$" ,'data-pattern-msg'=>'Please enter the valid price.','data-matchfullprice-msg'=>'Sale price should be less than full price.')); ?>
                  </div>
               </div>
       </section>
   </div>    
        
<?php
}

    ?>
<div class="box-content">
    <div class="form-group">
            <div class="row ">
                    <div class="col-sm-12">
                            <?php
                                if(count($this->common->get_room_options($auth_user['User']['id'],$Spabreak['Spabreak']['id']))>0){
                                    echo $this->Html->Link('Another Pricing Option','javascript:void(0)',array('title'=>'Add Another Pricing Level','data-id'=>'another_option','class'=>'add_anotherpricing','escape'=>false));
                                }
                            ?>   
                    </div>
            </div>
    </div>
</div>    






