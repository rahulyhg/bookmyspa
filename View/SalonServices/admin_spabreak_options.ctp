<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h2 id="myModalLabel">
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> New Pricing Option</h2>
        </div>
        <?php echo $this->Form->create('SpabreakOption',array('id'=>'SpabreakOptions','novalidate','class'=>'form-horizontal'));
                  ?>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                
                   
    <div class="form-group pdngtop10">
            <section>
               <div class="col-sm-6">
                    <label class="">Hotel Rooms*:</label>
                    <?php  echo $this->Form->input('SpabreakOption.salon_room_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control full-w', 'options' => $this->common->get_room_options($auth_user['User']['id'],$spabreak_id))); ?>
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
            <div class="col-sm-9">
             <label class="">Weeksdays*:</label>
                <div id="weekDays" class="week-days col-sm-8 nopadding">
                    <div class="col-sm-1">
                            <?php
                             echo $this->Form->input('SpabreakOptionPerday.sunday', array('id'=>'sundayPriceOption','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'S'), 'div' => false, 'class' => 'form-control days','checked'=>true));
                            ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php
                            
                            echo $this->Form->input('SpabreakOptionPerday.monday', array('id'=>'mondayPriceOption','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'M'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php
                            
                            echo $this->Form->input('SpabreakOptionPerday.tuesday', array('id'=>'tuesdayPriceOption','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'T'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php
                           
                            echo $this->Form->input('SpabreakOptionPerday.wednesday', array('id'=>'wednesdayPriceOption','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'W'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php
                            
                            echo $this->Form->input('SpabreakOptionPerday.thursday', array('id'=>'thursdayPriceOption','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'T'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1">
                            <?php
                           
                            echo $this->Form->input('SpabreakOptionPerday.friday', array('id'=>'fridayPriceOption','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'F'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    <div class="col-sm-1 ">
                            <?php
                            
                            echo $this->Form->input('SpabreakOptionPerday.saturday', array('id'=>'saturdayPriceOption','type' => 'checkbox', 'label' => array('class'=>'new-chk ','text'=>'S'), 'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                     <?php
                             echo $this->Form->input('dayDynamic', array('id'=>'dayDynamic','type' => 'hidden',  'div' => false, 'class' => 'form-control days','checked'=>true)); ?>
                    </div>
                    
                </div>
            </div>
            
        </section>
        <section>
            <div class="col-sm-5 pdngtop35 addDayLink" style="display:none" >
                <div class="col-sm-12">
                 <?php echo $this->Html->Link(' <i class="fa fa-plus">Add New</i>','javascript:void(0)',array('title'=>'Edit Pricing Option for days ','data-id'=>'','class'=>'add_pricing_day','escape'=>false)) ?></php>
                </div>
            </div>
        </section>
         
    </div>
    <div class="form-group">
        <section>
               <div class="col-sm-6">
                  <label class="">Full Price(AED)*:</label>
                  <div class="col-sm-12 lft-p-non">
                      <?php echo $this->Form->hidden('SpabreakOptionPerday.id',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                      <?php echo $this->Form->hidden('SpabreakOptionPerday.spabreak_option_id',array('label'=>false,'div'=>false,'class'=>'salon_service_id form-control')); ?>
                      <?php echo $this->Form->input('SpabreakOptionPerday.full_price',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required'=>true,'validationMessage'=>"Full price is required.",'class'=>'form-control','required'=>true,'pattern'=>"^\d{0,5}(\.\d{0,2})?$" ,'data-pattern-msg'=>'Please enter the valid price.')); ?>
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
            
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update','label'=>false,'div'=>false));?>
            <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
              'type'=>'button','label'=>false,'div'=>false,
              'class'=>'btn closeModal')); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#SpabreakOptions").find("#weekDays input[type=checkbox]").on('change',function(){
	
                    var length = $("#SpabreakOptions").find(".days:checked").length;
		    
					
                    if(length==1){
                        $("#SpabreakOptions").find(".days:checked").attr('disabled','disabled');
					var newName = $("#SpabreakOptions").find(".days:checked").attr('name');
                                        
						$("#SpabreakOptions").find("#dayDynamic").attr('name',newName).val('1');
                    }else if(length==2){
                        $("#SpabreakOptions").find(".days:checked").removeAttr('disabled');
						$("#SpabreakOptions").find("#dayDynamic").removeAttr('name');
                    }
                    if($(this).is(':disabled')){
                        alert('Atleast One weekday must be selected');
                    }
            })
    
    
})
     
</script>