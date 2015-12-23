<div class="modal-dialog vendor-setting sm-vendor-setting">
	<div class="modal-content">
	    <?php echo $this->Form->create('Service',array('admin'=>true,'novalidate','id'=>'ServiceTagForm','class'=>'form-horizontal'));?>
		<div class="modal-header">
		    <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    <h2><?php echo (isset($this->data) && !empty($this->data))?'Edit':"Create"; ?> Tag</h2>
		</div>
		<div class="modal-body clearfix ServicePopForm">
			<div class="row">
				<div class="col-sm-12">
					<div class="box">
						<div class="box-content">
							<?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
							<?php echo $this->Form->hidden('parent_id',array('value'=>0,'label'=>false,'div'=>false));?>
							<div class="row">
								<div class="col-sm-12">
									<ul class="nav nav-tabs">
									    <li class='active'>
										<a href="#first11" data-toggle='tab'>English</a>
									    </li>
									    <li>
										<a href="#second22" data-toggle='tab'>Arabic</a>
									    </li>
									    <!--<li class="pull-right extFrntDply">
										<div class="controls">
										    <label class="">
											<?php //echo $this->Form->input('frontend_display',array('type'=>'checkbox','label'=>false,'div'=>false,'class'=>'styled')); ?> 
										    </label>
										</div>
									    </li>-->
									</ul>
									<div class="tab-content padding tab-content-inline tab-content-bottom ">
										<div class="tab-pane active" id="first11">
										    <div class="form-group">
											<label class="control-label col-sm-4">Name *:</label>
											<div class="col-sm-8">
<!--                                                                                            /^[ A-Za-z0-9_@./#&+-]*$/-->
											    <?php
                                                                                             $patern = "^[A-Za-z.'\-\s]+$";
                                                                                            echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control valid_name','minlength'=>'3','pattern'=>$patern ,'data-pattern-msg'=>"Please enter only alphabets  and ( . , ' and - ).",'required','validationMessage'=>"Tag name is required.",'data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'maxlength'=>105)); ?>
											</div>
										    </div>
										</div>
										<div class="tab-pane" id="second22">
										    <div class="form-group">
											<label class="control-label col-sm-4">Name:</label>
											<div class="col-sm-8">
											    <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control valid_name','required'=>false,'minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'maxlength'=>105)); ?>
											</div>
										    </div>
										</div>
									</div>
								</div>
							</div>    
                
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer pdng20">
			<div class="col-sm-12 ">
				<div class="col-sm-3 pull-right">
				<?php echo $this->Form->button('Cancel',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'class'=>'btn full-w' , 'data-dismiss'=>"modal")); ?>
				</div>
				<div class="col-sm-3 pull-right">
				<?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitTag full-w','label'=>false,'div'=>false));?>
				</div>
			</div>
		</div>
	    <?php echo $this->Form->end(); ?>
	</div>
</div>
<script>
    $(document).ready(function(){
        Custom.init();
    });
</script>
        
            
