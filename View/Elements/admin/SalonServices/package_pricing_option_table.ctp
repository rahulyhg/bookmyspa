<style>
    .duration select{
        min-width:83px !important;
    }
</style>
<?php
    $no_of_options=1;
    if(isset($package['PackageService'][0]['PackagePricingOption']) && !(empty($package['PackageService'][0]['PackagePricingOption']))){
        $no_of_options = count($package['PackageService'][0]['PackagePricingOption']);
    }
 if(isset($package['PackageService']) && !empty($package['PackageService'])){
   
        if(isset($optionCount)){
             $no_of_options = $optionCount;
        }
    
    ?>
<div class="col-sm-12 nopadding text-right">

<?php
    if($no_of_options < 5){
        echo $this->Html->Link('Add Option','javascript:void(0)',array('title'=>'Add another pricing option','data-id'=>$no_of_options,'class'=>'add_packagepricing btn btn-primary','escape'=>false));    
    }
?>
   
</div>
<div class="col-sm-12 nopadding table-responsive mrgn-tp10">
    <table class="table table-bordered pckg-prcing-opt">
        <tbody>
            <tr>
                <th>Services</th>
                <th>&nbsp;</th>
                <?php
                  for($i=0; $i<$no_of_options;$i++){
                        $j = $i+1;
                        $title='';
                        if(isset($package["PackageService"][0]["PackagePricingOption"][$i]) && !empty($package["PackageService"][0]["PackagePricingOption"][$i])){
                            $title = $package["PackageService"][0]["PackagePricingOption"][$i]["custom_title_eng"];
                        }
                        if(empty($title)){
                            $title = 'Edit title';
                        }
                        echo '<th><a  id="'.$j.'" data-toggle="modal" title="Edit custom title" class="customTitle" data-target="#myModal" >'.$title.'</a></th>';
                    }
                ?>
            </tr>
                <?php
                    $i=0;
                    $priceCount = array();
                    $default = array();
                    foreach($package['PackageService'] as $key=>$packageService){ 
                       echo '<tr>';
                       echo '<td rowspan=2 style="vertical-align: middle;">'.$this->Common->get_salon_service_name($packageService["salon_service_id"]).'</td>';
                       echo '<td>Duration</td>';
                       echo $this->Form->hidden('PackageService.'.$key.'.id');
                       echo $this->Form->hidden('PackageService.'.$key.'.package_id');
                       echo $this->Form->hidden('PackageService.'.$key.'.salon_service_id');
                       for($i=0; $i<$no_of_options;$i++){
                            $j = $i+1;
                            $default[$i] = isset($packageService['PackagePricingOption'][$i]['duration'])?$packageService['PackagePricingOption'][$i]['duration'] :'';
                            echo $this->Form->hidden('PackageService.'.$key.'.PackagePricingOption.'.$i.'.id');
                            echo $this->Form->hidden('PackageService.'.$key.'.PackagePricingOption.'.$i.'.package_id',array('value'=>$package['Package']['id']));
                            echo $this->Form->hidden('PackageService.'.$key.'.PackagePricingOption.'.$i.'.package_service_id');
                            echo $this->Form->hidden('PackageService.'.$key.'.PackagePricingOption.'.$i.'.option_id',array('value'=>$j));
                            echo $this->Form->hidden('PackageService.'.$key.'.PackagePricingOption.'.$i.'.option_price',array('class'=>'_'.$i.'_optionprice'));
                            echo $this->Form->hidden('PackageService.'.$key.'.PackagePricingOption.'.$i.'.option_duration',array('class'=>'_'.$i.'_optionduration'));
                            echo $this->Form->hidden('PackageService.'.$key.'.PackagePricingOption.'.$i.'.custom_title_ara',array('class'=>'customTitleAra'.$j));
                            echo $this->Form->hidden('PackageService.'.$key.'.PackagePricingOption.'.$i.'.custom_title_eng',array('class'=>'customTitleEng'.$j));
                            echo '<td class="duration">'.$this->Form->input('PackageService.'.$key.'.PackagePricingOption.'.$i.'.duration',array('id'=>$key.'_'.$i,'type'=>'select','options'=>$this->Common->get_duration(),'class'=>'form-control full-w optionDuration','div'=>false,'label'=>false,'default'=>$default[$i])).'</td>';
                            
                       }
                       echo '</tr>';
                       echo '<tr>';
                       echo '<td>Price</td>';
                       
                       for($i=0; $i<$no_of_options;$i++){
                            if($default[$i]==0){
                                $property = "readonly";
                            }else{
                                $property = " ";
                            }
                            echo '<td>'.$this->Form->input('PackageService.'.$key.'.PackagePricingOption.'.$i.'.price',array('id'=>$key.'_'.$i.'_price','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control optionPrce','pattern'=>"^\d{0,5}(\.\d{0,2})?$" ,'data-pattern-msg'=>'Please enter the valid price.','required'=>true,'validationmessage'=>'Price is required.',$property)).'</td>';
                            $priceCount[$i][]= isset($package['PackageService'][$key]['PackagePricingOption'][$i]['price']) ? $package['PackageService'][$key]['PackagePricingOption'][$i]['price'] : 0;
                            
                           //echo ' <input name="data[PackageService]['.$key.'][PackagePricingOption]['.$i.'][price]" type="hidden" required="required" value=''>';
                        }
                       echo '</tr>';
                    }
                   echo "<tr>". $this->Form->hidden('totalrow',array('id'=>'totalrow','value'=>$key+1))."</tr>";
                ?>
                <tr><td></td><td><b>Total:</b></td>
                <?php
                    for($i=0; $i<$no_of_options;$i++){
                            $j = $i+1;
                            $val ='';
                            if(array_sum($priceCount[$i]) > 0){
                                $val = 1;
                            }
                            echo "<td id='total_".$i."'><p>AED ".array_sum($priceCount[$i])."</p>";
                            if($j>1){
                                echo "<a class='delete-package-option del pull-right' data-id='".$j."' title='Delete pricing option' href='javascript:void(0)'><i class='fa  fa-trash-o'></i></a>";
                            }
                            
                            echo $this->Form->hidden('totalSelcount_'.$i,array('id'=>'totalSelcount_'.$i,'required'=>true,'validationmessage'=>'Package must contain at least two services.','value'=>$val));
                            //echo $this->Form->hidden('totalcount_'.$i,array('id'=>'totalcount_'.$i,'value'=>$val/*,'required'=>true,'validationmessage'=>'Package must contain at least one service.'*/));
                            echo "</td>";    
                        
                    }
                ?>
                </tr>
        </tbody>
    </table>
</div>
<?php } else{ ?>
    
<div class="box-content showServicesList">
    <div class="col-sm-12 nopadding">
           No option found.
    </div>
</div>
    
  <?php  } ?>