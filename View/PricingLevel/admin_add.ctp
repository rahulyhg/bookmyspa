<style>
.tag {
    background: none repeat scroll 0 0 #DDDED7;
    border-radius: 3px 3px 3px 3px;
    color: #666666;
    font-size: 11px;
    font-weight: normal;
    line-height: normal;
    margin-left: 5px;
    padding: 1px 4px 0;
    vertical-align: middle;
}

</style>
<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Pricing Level</h3>
        </div>
        <?php echo $this->Form->create('PricingLevel',array('novalidate','class'=>'form-horizontal'));?>
            <div class="modal-body">
                <div class="box">
                    <div class="box-content">
                        <div class="form-group">
                            <label class="control-label col-sm-5">	    
                            </label>
                            <div class="col-sm-8">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5">	    
                                Pricing Level *:
                            </label>
                            <div class="col-sm-8">
                                    <?php
                                    echo $this->Form->input('id',array('type'=>'hidden')); 
                                    echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required','minlength'=>'3','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Pricing level is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-pattern-msg'=>"Please enter only alphabets.",'maxlengthcustom'=>'50','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
                                    </br>
                                    <dfn>The level of employee e.g. Senior, Junior etc.</dfn>
                            </div>
                        </div>
                        
                        <?php if(!empty($teamList)) { ?>
                        <div class="form-group">
                            <label class="control-label col-sm-5">	    
                                Assigned team members:
                            </label>
                            <div class="col-sm-8">
                                <?php
                                
                               
                                    foreach($teamList as $val){
                                        
                                        if($val['UserDetail']['employee_type']==2){
                                        
                                    ?>
                                        <div class="col-lg-8 form-box">
                                                <?php
                                                //$checked = (in_array($val['User']['id'],$selectedTeamList))?TRUE:FALSE;
                                                //$label  = $val['User']['username'];
                                                //$plevel =  (!empty($val['User']['userPriceLevelName']))?'<span class="tag">'.$val['User']['userPriceLevelName'].'</span>':'';
                                                //echo $label." ".$plevel;
                                                //echo $this->Form->input('User.',array('checked'=>$checked,'value'=>$val['User']['id'],'id'=>$val['User']['id'],'div'=>false,'type'=>'checkbox','class'=>'checkTeam','label'=>array('class'=>'new-chk','text'=>$label." ".$plevel))); 
                                                 ?> 
    
                                                <?php                                 
                                                    $disabled = '';
                                                    //echo $this->Common->checkStaffServiceAssociation($val['User']['id']);
                                                    if($this->Common->checkStaffServiceAssociation($val['User']['id']) > 0){
                                                      $disabled = "disabled=disabled";  
                                                    }
                                                    
                                                   if(in_array($val['User']['id'],$selectedTeamList)){
                                                         
                                                    ?>
                                                        <input type="checkbox" class="" checked="checked" value="<?php echo $val['User']['id']; ?>" name="User[]" id="<?php echo $val['User']['id']; ?>" <?php echo $disabled; ?> >
                                                       <label for="<?php echo $val['User']['id']; ?>" class="new-chk">
                                                       <?php
                                                        if($disabled != ''){ ?>
                                                            <input type="hidden"  value="<?php echo $val['User']['id']; ?>" name="User[]" id="<?php echo $val['User']['id']; ?>" style="display:none" >
                                                     <?php  }?>
                                                <?php  }                                                           
                                                else{ 
                                                ?>
                                                        <input type="checkbox" class=""  value="<?php echo $val['User']['id']; ?>" name="User[]" id="<?php echo $val['User']['id']; ?>" <?php echo $disabled; ?> >
                                                        <label for="<?php echo $val['User']['id']; ?>" class="new-chk">
                                                <?php }                                                 
                                                echo $val['User']['email'];
                                                if(!empty($val['User']['userPriceLevelName'])){
                                                    echo '<span class="tag">'.$val['User']['userPriceLevelName'].'</span>';
                                                }else{
                                                    echo ''; 
                                                }
                                                ?>
                                        </div>
                                    <?php
                                        }} ?>
    
                            </div>
                        </div>   
                        <?php } ?>
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
	
	/*******Validate Service Form*********/
	
	var validator = $("#PricingLevelAdminAddForm").kendoValidator({
		rules:{
			minlength: function (input) {
				return minLegthValidation(input);
			},
			maxlengthcustom: function (input) {
				return maxLegthCustomValidation(input);
			},
			pattern: function (input) {
				return patternValidation(input);
			},
			matchfullprice: function (input){
				return comparefullsellprice(input);
			}
		},
		errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
	
	/***************End****************/
	
    });
</script>
