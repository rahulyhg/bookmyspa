<?php
    echo $this->Html->script('admin/userincr'); 
?>
<div class="row">    
    <div class="col-sm-12">
        <div class="box">
            <div class="box-content">
                <div class="col-sm-6">
                   <?php echo $this->Form->create('PointSetting',array('novalidate','class'=>'form-horizontal'));?>
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-sm-6 pdng-tp7">  AED 1 equals to </label>
                            <div class="col-sm-6">
                                      <div class="col-sm-8 lft-p-non"><?php echo $this->Form->input('aed_unit',array(
                                                                'type'=>'text',
                                                                'label'=>false,
                                                                'div'=>false,
                                                                'class'=>'form-control inputAmount numOnly',
                                                                'maxlength'=>6,
                                                                'placeholder'=>'0','required'
                                                    )); 
                                       ?>  </div>
                              <div class="col-sm-4 pdng-tp7 lft-p-non">Points</div>                                                             
                            </div>
                        </div>
                           <div class="form-group">
                            <label class="control-label col-sm-6 pdng-tp7">Sieasta points given on AED 1</label>
                            <div class="col-sm-6">
                                     <div class="col-sm-8 lft-p-non">
				      <?php echo $this->Form->input('siesta_point_given',array(
                                                                'type'=>'text',
                                                                'label'=>false,
                                                                'div'=>false,
                                                                'class'=>'form-control inputAmount numOnly',
                                                                'maxlength'=>6,
                                                                'placeholder'=>'0','required'
                                                    )); 
                                       ?>
				      </div>
                              <div class="col-sm-4 pdng-tp7 lft-p-non">Points</div>                                                             
                            </div>
                        </div>
			<div class="form-group">
                            <label class="control-label col-sm-6 pdng-tp7">Sieasta Commission on per Booking</label>
                            <div class="col-sm-6">
                                      <div class="col-sm-8 lft-p-non">
					<?php echo $this->Form->input('siesta_commision',array(
								  'type'=>'text',
								  'label'=>false,
								  'div'=>false,
								  'class'=>'form-control inputAmount numOnly',
								  'maxlength'=>6,
								  'placeholder'=>'0','required'							  )); 
					 ?>
				       </div>
                              <div class="col-sm-4 pdng-tp7 lft-p-non">% E.g. 8.75</div>                                                             
                            </div>
                        </div>
			
                        <div class="form-group">
                            <label class="col-sm-2">&nbsp </label>
                            <div class="col-sm-8">
                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update col-sm-3','label'=>false,'div'=>false));?> 
                            </div>
                        </div>
		</div>

            <?php echo $this->Form->end(); ?>
                </div>   
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.inputAmount').keyup(function(){
        var chk = $(this).val();
        if(isNaN(chk)){
            $(this).val('');
        }else{
            if ((new Number(chk)) < 0){
                $(this).val('');
            }
        }
        if($(this).val().indexOf('.')!=-1){
            if($(this).val().split(".")[1].length > 2){
                if( isNaN( parseFloat( this.value ) ) ) return;
                this.value = parseFloat(this.value).toFixed(2);
                return this;
            }
        }
    });
    /*$(document).on('keyup','.numOnly' ,function(){
       var value = $(this).val();
          if(isNaN(value)){
              $(this).val('');
          }
    });*/  
    
});
    
</script>
