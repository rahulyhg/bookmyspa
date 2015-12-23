<style>
    .pull-right.btn {
        margin-right: 4px;
    }
</style>
<script>
    $(document).ready(function(){
         $(document).on('click','.price_ratio',function() {
                if ($('.input_price').val()) {
                    $.each('.common_price').function(){
                        alert($(this).val())
                    }
                } else {
                    alert('Value required!!');
                }
            });
        });

    
    
    function is_numeric_decimal(num){
     if(/^[1-9]\d*(\.\d+)?$/.test($(num).val())){
     }else{
         $(num).val('');
     }   
    }

</script>
<div class="row">
    <div class="col-md-2"> <label>Price Ratio</label>
        <?php echo $this->Form->input('price',array('div'=>FALSE ,'label'=>FALSE,'class'=>'input_price','onchange'=>'is_numeric_decimal(this)')); ?> 
        <span class="price_ratio" style="cursor: pointer;">Apply All</span>
    </div>
     <div class="col-md-2"> 
         advanced = double booking (Gap) duration of service. 
    <span class="price_ratio" style="cursor: pointer;">Apply All</span>
    </div>
    <div class="col-md-2"> 
        <label>
            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>P</label>
        <label>  <input type="radio" name="optionsRadios" id="optionsRadios1" value="option2" checked>%
        </label>
        <input class="" type="text" placeholder="">
        <span class="price_ratio" style="cursor: pointer;">Apply All</span>
    </div>
    <div class="col-md-2"> 
        <label>
            <input type="radio" name="options" id="optionsRadios1" value="opt1" checked>P</label>
            <label><input type="radio" name="options" id="optionsRadios1" value="opt2" checked>%</label>
            <input class="" type="text" placeholder="">
            <span class="price_ratio" style="cursor: pointer;">Apply All</span>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
       
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    <?php //echo __('Service Pricing Configuration'); ?>
                </h3>

                
                <?php echo $this->Html->link('<i class="icon-plus"></i> Add Service', 'javascript:void(0);', array('data-id' => '', 'escape'=>false, 'class' => 'addedit_vendor pull-right btn')); ?>
            </div>
            <div class="box-content">
                <?php echo $this->Form->create('ServiceDetail') ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php echo $this->Form->input('chec', array('type' => 'checkbox', 'label' => false, 'class' => 'checkAll','name'=>'')); ?></th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Points Given</th>
                            <th>Points Redeem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service){ ?>
                            <tr>
                                <td><?php echo $this->Form->input('chec', array('type' => 'checkbox', 'label' => false, 'class' => 'main','name'=>'')); ?></td>
                                <th><?php echo ucfirst($service['Service']['name']); ?></th>
                            </tr>
                            <?php
                            if($service['children']){
                                foreach ($service['children'] as $child){ ?>
                                    <tr>
                                        <td><?php echo $this->Form->input('chec', array('type' => 'checkbox', 'label' => false, 'class' => 'main','name'=>'')); ?></td>
                                        <th>&nbsp;&nbsp;<?php echo ucfirst($child['Service']['name']); ?></th>
                                    </tr>    
                                    <?php
                                    if($child['children']){
                                        foreach ($child['children'] as $child_sub){
                                           $ChildId = $child_sub['Service']['id'];
                                           $ServicePrice['ServiceDetail']['price'] = $ServicePrice['ServiceDetail']['duration'] =$ServicePrice['ServiceDetail']['points_given'] =$ServicePrice['ServiceDetail']['points_redeem'] = $ServicePrice['ServiceDetail']['id'] ='';
                                           $ServicePrice = $this->Common->ServicesPrice($ChildId ,$uid);
                                           ?>
                                            <tr>
                                                <td><?php //echo $this->Form->input('chec', array('type' => 'checkbox', 'label' => false, 'class' => 'main','name'=>'')); ?></td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ucfirst($child_sub['Service']['name']); ?></td>
                                                <td><?php echo $this->Form->input('price', array('div' => false, 'label' => FALSE, 'class' => 'input-small common_price','name'=>'data[ServiceDetail]['.$ChildId.'][price]','value'=>$ServicePrice['ServiceDetail']['price'])); ?></td>
                                                <td><?php echo $this->Form->input('duration', array('div' => false, 'label' => FALSE, 'class' => 'input-small','name'=>'data[ServiceDetail]['.$ChildId.'][duration]','value'=>$ServicePrice['ServiceDetail']['duration'])); ?></td>
                                                <td><?php echo $this->Form->input('points_given', array('div' => false, 'label' => FALSE, 'class' => 'input-small','name'=>'data[ServiceDetail]['.$ChildId.'][points_given]','value'=>$ServicePrice['ServiceDetail']['points_given'])); ?></td>
                                                <td><?php echo $this->Form->input('points_redeem', array('div' => false, 'label' => FALSE, 'class' => 'input-small','name'=>'data[ServiceDetail]['.$ChildId.'][points_redeem]','value'=>$ServicePrice['ServiceDetail']['points_redeem'])); ?></td>  
                                                <?php echo $this->Form->input('service_id',array('type'=>'hidden','name'=>'data[ServiceDetail]['.$ChildId.'][service_id]','value'=>$ServicePrice['ServiceDetail']['service_id'])); ?>
                                            </tr>
                                        <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table> 
                <div class="form-actions">
                    <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary submitTreatment ', 'label' => false, 'div' => false)); ?>
                    <?php
                    echo $this->Form->button('Cancel', array(
                        'type' => 'button', 'label' => false, 'div' => false,
                        'class' => 'btn cancelTreatment '));
                    ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>