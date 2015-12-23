<?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>  
<?php echo $this->Form->hidden('user_id',array('label'=>false,'div'=>false)); ?>  
<div class="form-group">
    <label class="control-label col-sm-4">Kid Friendly:</label>
    <div class="col-sm-8">
        <?php echo $this->Form->input('kids',array('options'=>$this->Common->kidsfrnd(),'label'=>false,'div'=>'false','class'=>'form-control'));?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">Business Type:</label>
    <div class="col-sm-8">
    <?php if($bType)
        foreach($bType as $kB=>$bTypeVal){ ?>
            <?php
                $checked = false;
                if(!empty($facilityData['Salon']['business_type_id'])){
                    if(in_array($kB,unserialize($facilityData['Salon']['business_type_id']))){
                        $checked = 'checked';
                    }
                } ?>
           <div class="clearfix mrgn-btm10 col-sm-6 lft-p-non">
                    <?php echo $this->Form->input('Salon.business_type_id.'.$kB,array('value'=>$kB,'div'=>false,'type'=>'checkbox','checked'=>$checked,'class'=>' ','label'=>array('class'=>'new-chk','text'=>$bTypeVal))); ?>
            </div>
        <?php }?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">Payment methods:</label>
    <div class="col-sm-8">
       <?php
        $paymentType = $this->Common->paymentTypes();
        if($paymentType)
        foreach($paymentType as $pT=>$pTypeVal){ ?>
            <?php
                $checked = false;
                if(!empty($facilityData['FacilityDetail']['payment_method'])){
                    if(in_array($pT,unserialize($facilityData['FacilityDetail']['payment_method']))){
                        $checked = 'checked';
                    }
                }
                ?>
            <div class="clearfix mrgn-btm10 col-sm-6 lft-p-non">
                    <?php echo $this->Form->input('FacilityDetail.payment_method.'.$pT,array('val'=>$pT,'div'=>false,'type'=>'checkbox','checked'=>$checked,'class'=>' ','label'=>array('class'=>'new-chk','text'=>$pTypeVal))); ?>
            </div>
        <?php }?>
    </div>
 </div>
<div class="form-group">
    <label class="control-label col-sm-4">Parking fees:</label>
    <div class='col-sm-8'>
       <?php
        $parkingType = $this->Common->parkingFee();
        if($parkingType)
        foreach($parkingType as $parT=>$parkingTypeVal){ ?>
            <?php
            $checked = false;
                if(!empty($facilityData['FacilityDetail']['parking_fee'])){
                    if(in_array($parT,unserialize($facilityData['FacilityDetail']['parking_fee']))){
                        $checked = 'checked';
                    }
                }?>
                <div class="clearfix mrgn-btm10 col-sm-6 lft-p-non"> 
                    <?php echo $this->Form->input('FacilityDetail.parking_fee.'.$parT,array('val'=>$parT,'div'=>false,'type'=>'checkbox','checked'=>$checked,'class'=>' ','label'=>array('class'=>'new-chk','text'=>$parkingTypeVal))); ?>
                </div>
                
        <?php }?>
    </div>
</div>
<div class="form-group"> 
    <label class="control-label col-sm-4">Accept Walk-in:</label>
    <div class="col-sm-8">
        <?php echo $this->Form->input('walk_in',array('div'=>false,'type'=>'checkbox','class'=>' ','label'=>array('class'=>'new-chk','text'=>'Available'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-4">WIFI access:</label>
    <div class="col-sm-8">
        <?php echo $this->Form->input('wifi',array('div'=>false,'type'=>'checkbox','class'=>' ','label'=>array('class'=>'new-chk','text'=>'Available'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-4">Snack bar:</label>
    <div class="col-sm-8">
        <?php echo $this->Form->input('snack_bar',array('div'=>false,'type'=>'checkbox','class'=>' ','label'=>array('class'=>'new-chk','text'=>'Available'))); ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-4">Beer and wine bar:</label>
    <div class="col-sm-8">
        <?php echo $this->Form->input('beer_wine_bar',array('div'=>false,'type'=>'checkbox','class'=>' ','label'=>array('class'=>'new-chk','text'=>'Available'))); ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">TV:</label>
    <div class="col-sm-8">
        <?php echo $this->Form->input('tv',array('div'=>false,'type'=>'checkbox','class'=>' ','label'=>array('class'=>'new-chk','text'=>'Available'))); ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">Handicap Access:</label>
    <div class="col-sm-8">        
        <?php echo $this->Form->input('hadicap_acces',array('div'=>false,'type'=>'checkbox','class'=>' ','label'=>array('class'=>'new-chk','text'=>'Available'))); ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">Other Languages:</label>
    <div class="col-sm-8">
    <?php echo $this->Form->input('other_lang',array('label'=>false,'div'=>false,'class'=>'form-control'));?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">Spoken languages: </label>
    <div class="col-sm-8">
        <?php
        $spokenLang = $this->Common->spokenLang();
        if($spokenLang)
        foreach($spokenLang as $sL=>$sLang){ ?>
        <?php
            $checked = false;
            if(!empty($facilityData['FacilityDetail']['spoken_language'])){
                if(in_array($sL,unserialize($facilityData['FacilityDetail']['spoken_language']))){
                    $checked = 'checked';
                }
            }?>
            <div class="clearfix mrgn-btm10 col-sm-6 lft-p-non">
                <?php echo $this->Form->input('FacilityDetail.spoken_language.'.$sL,array('val'=>$sL,'div'=>false,'type'=>'checkbox','checked'=>$checked,'class'=>' ','label'=>array('class'=>'new-chk','text'=>$sLang))); ?>
            </div>
        <?php }?>
    </div>
</div>
<?php if(!isset($rmvcancel)){ ?>
<div class="form-group">
    <label class="control-label col-sm-4">Cancellation policy <dfn>(English)</dfn>:</label>
    <?php echo $this->Form->input('eng_cancel_policy',array('type'=>'textarea','label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control'));?>
</div>
<div class="form-group">
    <label class="control-label col-sm-4">Cancellation policy <dfn>(Arabic)</dfn>:</label>
    <?php echo $this->Form->input('ara_cancel_policy',array('type'=>'textarea','label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control'));?>
</div>
<?php } ?>
<div class="form-group">
    <label class="control-label col-sm-4"> Special Instruction <dfn>(English)</dfn>:</label>
         <?php echo $this->Form->input('eng_special_instruction',array('type'=>'textarea','label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control'));?>
 </div>
<div class="form-group">
    <label class="control-label col-sm-4"> Special Instruction <dfn>(Arabic)</dfn>:</label>
         <?php echo $this->Form->input('ara_special_instruction',array('type'=>'textarea','label'=>false,'div'=>array('class'=>'col-sm-8'),'class'=>'form-control'));?>
 </div>
                