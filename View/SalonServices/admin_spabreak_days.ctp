<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h2 id="myModalLabel">
    <?php echo $typeDay; ?> pricing option for days</h2>
        </div>
         <?php echo $this->Form->create('SpabreakOptionPerday',array('id'=>'SpabreakOptionsprice','novalidate','class'=>'form-horizontal'));?>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <div class="mrgn-btm10 clearfix">
                          <section>
                               <div class="col-sm-9 lft-p-non">
                                <label class="">Weeksdays*:</label>
                                   <div id="weekDaysTop" class="week-days col-sm-8 nopadding">
                                       <div class="col-sm-1 complete-grey">
                                               <?php
                                               $isdisbledSun = '';
                                               $isCheckedSun = false;
                                               $addClassSun = '';
                                               
                                               if(isset($getRow) && !empty($getRow)){
                                                    if($this->Common->checkdayDisabled('sunday',$getRow['SpabreakOptionPerday']['spabreak_option_id'])&& $getRow['SpabreakOptionPerday']['sunday'] ==0){
                                                           $isdisbledSun = 'disabled';
                                                           $isCheckedSun = true;
                                                   }elseif($getRow['SpabreakOptionPerday']['sunday'] ==1){
                                                           $isCheckedSun = true;
                                                           $addClassSun  = 'toBeSelected';
                                                   }     
                                               }elseif($optionid){
                                                   if($this->Common->checkdayDisabled('sunday',$optionid)){
                                                  
                                                              $isdisbledSun = 'disabled';
                                                              $isCheckedSun = true;
                                                   }else{
                                                        $isCheckedSun = true;
                                                        $addClassSun  = 'toBeSelected';
                                                   }
                                               }
                                             
                                              if($isdisbledSun == ''){
                                               echo $this->Form->input('SpabreakOptionPerday.sunday', array('id'=>'sundayPrice','type' => 'checkbox', 'label' => array('class'=>'new-chk','text'=>'S'), 'div' => false, 'class' => 'form-control days'.' '.$addClassSun,'disabled'=>$isdisbledSun,'checked'=>$isCheckedSun));
                                              }else{
                                                echo "<i class='fa fa-check'></i><span>S</span>";
                                              }
                                              
                                               ?>
                                              
                       
              
                                       </div>
                                       <div class="col-sm-1 ">
                                               <?php
                                               $isdisbledMon = '';
                                               $isCheckedMon = false;
                                               $addClassMon = '';
                                               if(isset($getRow) && !empty($getRow)){
                                                    if($this->Common->checkdayDisabled('monday',$getRow['SpabreakOptionPerday']['spabreak_option_id'])&& $getRow['SpabreakOptionPerday']['monday'] ==0){
                                                           $isdisbledMon = 'disabled';
                                                           $isCheckedMon = true;
                                                   }elseif($getRow['SpabreakOptionPerday']['monday'] ==1){
                                                           $isCheckedMon = true;
                                                           $addClassMon  = 'toBeSelected';
                                                   } 
                                               }elseif($optionid){
                                                   if($this->Common->checkdayDisabled('monday',$optionid)){
                                                  
                                                              $isdisbledMon = 'disabled';
                                                              $isCheckedMon = true;
                                                   }else{
                                                        $isCheckedMon = true;
                                                        $addClassMon  = 'toBeSelected';
                                                   }
                                               }
                                        if($isdisbledMon == ''){
                                               echo $this->Form->input('SpabreakOptionPerday.monday', array('id'=>'mondayPrice','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'M'), 'div' => false, 'class' => 'form-control days','disabled'=>$isdisbledMon,'checked'=>$isCheckedMon)); 
                                                }else{
                                                echo "<i class='fa fa-check'></i><span>M</span>";
                                              }
                                              ?>
                                       </div>
                                       <div class="col-sm-1 ">
                                               <?php
                                               $isdisbledTue = '';
                                               $isCheckedTue = false;
                                               $addClassTue = '';
                                               if(isset($getRow) && !empty($getRow)){
                                                    if($this->Common->checkdayDisabled('tuesday',$getRow['SpabreakOptionPerday']['spabreak_option_id'])&& $getRow['SpabreakOptionPerday']['tuesday'] ==0){
                                                           $isdisbledTue = 'disabled';
                                                           $isCheckedTue = true;
                                                   }elseif($getRow['SpabreakOptionPerday']['tuesday'] ==1){
                                                           $isCheckedTue = true;
                                                           $addClassTue  = 'toBeSelected';
                                                   }      
                                               }elseif($optionid){
                                                   if($this->Common->checkdayDisabled('tuesday',$optionid)){
                                                  
                                                              $isdisbledTue = 'disabled';
                                                              $isCheckedTue = true;
                                                   }else{
                                                        $isCheckedTue = true;
                                                        $addClassTue  = 'toBeSelected';
                                                   }
                                               }
                                               if($isdisbledTue == ''){
                                               echo $this->Form->input('SpabreakOptionPerday.tuesday', array('id'=>'tuesdayPrice','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'T'), 'div' => false, 'class' => 'form-control days','disabled'=>$isdisbledTue,'checked'=>$isCheckedTue));
                                               }else{
                                                echo "<i class='fa fa-check'></i><span>T</span>";
                                              }
                                              ?>
                                       </div>
                                       <div class="col-sm-1">
                                               <?php
                                               $isdisbledWed = '';
                                               $isCheckedWed = false;
                                               $addClassWed = '';
                                               if(isset($getRow) && !empty($getRow)){
                                                    if($this->Common->checkdayDisabled('wednesday',$getRow['SpabreakOptionPerday']['spabreak_option_id']) && $getRow['SpabreakOptionPerday']['wednesday'] ==0){
                                                           $isdisbledWed = 'disabled';
                                                           $isCheckedWed = true;
                                                   }elseif($getRow['SpabreakOptionPerday']['wednesday'] ==1){
                                                           $isCheckedWed = true;
                                                           $addClassWed  = 'toBeSelected';
                                                   }     
                                               }elseif($optionid){
                                                   if($this->Common->checkdayDisabled('wednesday',$optionid)){
                                                  
                                                              $isdisbledWed = 'disabled';
                                                              $isCheckedWed = true;
                                                   }else{
                                                        $isCheckedWed = true;
                                                        $addClassWed  = 'toBeSelected';
                                                   }
                                               }
                                               if($isdisbledWed == ''){
                                               echo $this->Form->input('SpabreakOptionPerday.wednesday', array('id'=>'wednesdayPrice','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'W'), 'div' => false, 'class' => 'form-control days','disabled'=>$isdisbledWed,'checked'=>$isCheckedWed));
                                                }else{
                                                echo "<i class='fa fa-check'></i><span>W</span>";
                                              }
                                               ?>
                                       </div>
                                       <div class="col-sm-1">
                                               <?php
                                               $isdisbledThu = '';
                                               $isCheckedThu = false;
                                               $addClassThu = '';
                                               if(isset($getRow) && !empty($getRow)){
                                                    if($this->Common->checkdayDisabled('thursday',$getRow['SpabreakOptionPerday']['spabreak_option_id'])&& $getRow['SpabreakOptionPerday']['thursday'] ==0){
                                                           $isdisbledThu = 'disabled';
                                                           $isCheckedThu = true;
                                                   }elseif($getRow['SpabreakOptionPerday']['thursday'] ==1){
                                                           $isCheckedThu = true;
                                                           $addClassThu  = 'toBeSelected';
                                                   }     
                                               }elseif($optionid){
                                                   if($this->Common->checkdayDisabled('thursday',$optionid)){
                                                  
                                                              $isdisbledThu = 'disabled';
                                                              $isCheckedThu = true;
                                                   }else{
                                                        $isCheckedThu = true;
                                                        $addClassThu  = 'toBeSelected';
                                                   }
                                               }
                                               if($isdisbledThu == ''){
                                               echo $this->Form->input('SpabreakOptionPerday.thursday', array('id'=>'thursdayPrice','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'T'), 'div' => false, 'class' => 'form-control days','disabled'=>$isdisbledThu,'checked'=>$isCheckedThu));
                                                }else{
                                                echo "<i class='fa fa-check'></i><span>T</span>";
                                              }
                                              ?>
                                       </div>
                                       <div class="col-sm-1">
                                               <?php
                                               $isdisbledFri = '';
                                               $isCheckedFri = false;
                                               $addClassFri = '';
                                               if(isset($getRow) && !empty($getRow)){
                                                    if($this->Common->checkdayDisabled('friday',$getRow['SpabreakOptionPerday']['spabreak_option_id'])&& $getRow['SpabreakOptionPerday']['friday'] ==0){
                                                           $isdisbledFri = 'disabled';
                                                           $isCheckedFri = true;
                                                   }elseif($getRow['SpabreakOptionPerday']['friday'] ==1){
                                                           $isCheckedFri = true;
                                                           $addClassFri  = 'toBeSelected';
                                                   }     
                                               }elseif($optionid){
                                                   if($this->Common->checkdayDisabled('friday',$optionid)){
                                                  
                                                              $isdisbledFri = 'disabled';
                                                              $isCheckedFri = true;
                                                   }else{
                                                        $isCheckedFri = true;
                                                        $addClassFri  = 'toBeSelected';
                                                   }
                                               }
                                         if($isdisbledFri == ''){
                                               echo $this->Form->input('SpabreakOptionPerday.friday', array('id'=>'fridayPrice','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'F'), 'div' => false, 'class' => 'form-control days','disabled'=>$isdisbledFri,'checked'=>$isCheckedFri));
                                                }else{
                                                echo "<i class='fa fa-check'></i><span>F</span>";
                                              }
                                              ?>
                                       </div>
                                       <div class="col-sm-1 ">
                                               <?php
                                               $isdisbledSat = '';
                                               $isCheckedSat = false;
                                               $addClassSat = '';
                                               if(isset($getRow) && !empty($getRow)){
                                                    if($this->Common->checkdayDisabled('saturday',$getRow['SpabreakOptionPerday']['spabreak_option_id'])&& $getRow['SpabreakOptionPerday']['saturday'] ==0){
                                                           $isdisbledSat = 'disabled';
                                                            $isCheckedSat = true;
                                                   }elseif($getRow['SpabreakOptionPerday']['saturday'] ==1){
                                                           $isCheckedSat = true;
                                                           $addClassSat  = 'toBeSelected';
                                                   }     
                                               }elseif($optionid){
                                                   $this->request->data['SpabreakOptionPerday']['spabreak_option_id'] =$optionid ;
                                                   if($this->Common->checkdayDisabled('saturday',$optionid)){
                                                  
                                                              $isdisbledSat = 'disabled';
                                                              $isCheckedSat = true;
                                                   }else{
                                                        $isCheckedSat = true;
                                                        $addClassSat  = 'toBeSelected';
                                                   }
                                               }
                                               if($isdisbledSat == ''){
                                               echo $this->Form->input('SpabreakOptionPerday.saturday', array('id'=>'saturdayPrice','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'S'), 'div' => false, 'class' => 'form-control days','disabled'=>$isdisbledSat,'checked'=>$isCheckedSat));
                                                }else{
                                                echo "<i class='fa fa-check'></i><span>S</span>";
                                              }?>
                                       </div>
                                   </div>
                               </div>
                               
                           </section>
                            
                       </div>
                       <div class="clearfix">
                           <section>
                                  <div class="col-sm-6 lft-p-non">
                                     <label class="">Full Price(AED)*:</label>
                                     <div class="col-sm-12 lft-p-non">
                                         <?php echo $this->Form->hidden('SpabreakOptionPerday.id',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                         <?php echo $this->Form->hidden('SpabreakOptionPerday.spabreak_option_id',array('label'=>false,'div'=>false,'class'=>'salon_service_id form-control')); ?>
                                         <?php echo $this->Form->input('SpabreakOptionPerday.full_price',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>true,'validationMessage'=>"Full price is required.",'pattern'=>"^\d{0,5}(\.\d{0,2})?$" ,'data-pattern-msg'=>'Please enter the valid price.')); ?>
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
                                        
                                       
                </div>   
            </div>
        </div>
        <div class="modal-footer pdng20">
               <?php
		 if(isset($getRow) && !empty($getRow)){
                   if($this->Common->get_spabreakPerdayCount($getRow['SpabreakOptionPerday']['spabreak_option_id']) > 1){
                
                        echo $this->Form->button('Delete',array('type'=>'button','data-id'=>'','class'=>'btn btn-danger del-option pull-left','label'=>false,'div'=>false));  
                   }
                }
	       ?>         
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update','label'=>false,'div'=>false));?>
            <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
              'type'=>'button','label'=>false,'div'=>false,
              'class'=>'btn closeModal')); ?>
      </div>
      <?php echo $this->Form->end(); ?>
</div>

<script>
$(document).ready(function(){
    $("#SpabreakOptions").find("#weekDays input[type=checkbox]").on('change',function(){
	
                    var length = $("#SpabreakOptions").find(".days:checked").length;
		    
					
                    if(length==1){
                        $("#SpabreakOptions").find(".days:checked").attr('disabled','disabled');
					var newName = $("#SpabreakOptions").find(".days:checked").attr('name');
                                        alert(newName);
						$("#SpabreakOptions").find("#dayDynamic").attr('name',newName).val('1');
                    }else if(length==2){
                        $("#SpabreakOptions").find(".days:checked").removeAttr('disabled');
						$("#SpabreakOptions").find("#dayDynamic").removeAttr('name');
                    }
                    if($(this).is(':disabled')){
                        alert('Atleast One weekday must be selected');
                    }
            });
    
    
});

</script>
