<?php
	echo $this->Html->css('admin/colorpicker.css');
	echo $this->Html->script('admin/bootstrap-colorpicker.js');
?>
<div class="modal-dialog vendor-setting sm-vendor-setting">
	<div class="modal-content">
	<?php echo $this->Form->create('SalonService',array('admin'=>true,'novalidate','id'=>'SalonServiceNameForm','class'=>'form-horizontal'));?>
	    <div class="modal-header">
		<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h2 class="no-mrgn"><?php echo $Type; ?> Category</h2>
	    </div>
	    <div class="modal-body clearfix">
            <div class="row">
            <div class="col-sm-12">
                <div class="box">
                <div class="box-content">
                
                    <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
                    <?php echo $this->Form->hidden('service_id',array('label'=>false,'div'=>false));?>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class='active'>
                                    <a href="#first11" data-toggle='tab'>English</a>
                                </li>
                                <li>
                                    <a href="#second22" data-toggle='tab'>Arabic</a>
                                </li>
                            </ul>
                            <div class="tab-content padding tab-content-inline tab-content-bottom ">
                                <div class="tab-pane active" id="first11">
				<?php if($serviceType == "Service") {?>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Sieasta Name:</label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->input('Service.eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','readonly'=>true)); ?>
                                        </div>
                                    </div>
				    <?php } ?>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Display Name *:</label>
                                        <div class="col-sm-7">
                                            <?php
					    	if(isset($parentService) && empty($parentService['SalonService']['eng_name']) && !empty($parentService['Service']['eng_name'])){
								$this->request->data['SalonService']['eng_name'] = $parentService['Service']['eng_name'];		
							}
						?>
                                            <?php echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','required','minlength'=>'3','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Display name is required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'data-pattern-msg'=>"Please enter only alphabets.",'maxlengthcustom'=>'50','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="second22">
				<?php if($serviceType == "Service") {?>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5">Sieasta Name :</label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->input('Service.ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','readonly'=>true)); ?>
                                        </div>
                                    </div>
				     <?php } ?>
                                    <div class="form-group">
                                        <?php
							if(isset($parentService) && empty($parentService['SalonService']['ara_name']) && !empty($parentService['Service']['ara_name'])){
								$this->request->data['SalonService']['ara_name'] = $parentService['Service']['ara_name'];		
							}
						?>
                                        <label class="control-label col-sm-5">Display Name :</label>
                                        <div class="col-sm-7">
                                            <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','validationMessage'=>"Display name is Required.",'data-minlength-msg'=>"Minimum 3 characters are allowed.",'maxlengthcustom'=>'50','data-maxlengthcustom-msg'=>"Maximum 50 characters are allowed.")); ?>
                                        </div>
                                    </div>
				    
                                </div>
				
					<div class="form-group">
						<label class="control-label col-sm-5">Color:</label>
						<?php echo $this->Form->input('SalonService.color',array('label'=>false,'div'=>array('class'=>'col-sm-7'),'class'=>'form-control colorp')); ?>
					</div>
				   
                            </div>
                        
                        </div>
                   <!-- <div class="row sample-form form-horizontal">
                        <div class="form-actions">
                          
                        </div>
                    </div>-->
                    </div>    
            
                </div>
                </div>
            </div>
            </div>
        </div>
             <div class="modal-footer pdng20">
	       <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitThe ','label'=>false,'div'=>false));?>
                            <?php echo $this->Form->button('Cancel',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'data-dismiss'=>"modal",'class'=>'btn cancelTreatment ')); ?>
	    </div>
	</div>
	    <?php echo $this->Form->end(); ?>
</div>

<script>
	$(document).ready(function(){
		 $('.colorp').each(function(){
			$(this).colorpicker();	
		})
	})
	
</script>	
