<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
		<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
				<?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Note
            </h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
			    <?php //pr($edit_note); die; ?>
							<?php echo $this->Form->create('Note',array('novalidate','type' => 'file','id' =>'add_note_form')); 
								
							?>
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-2 control-label">Note category *:</label>
										<div class="col-sm-2">
						<?php if(isset($edit_note) && $edit_note!=''){
							
							$default=$edit_note[0]['Note']['category']; 
							}else{
							    $default=1;
							} ?>
										<?php
											$options = array('1' => 'Allergy', '2' => 'Formula','3' => 'General', '4' => 'Popup Notes');
											$attributes = array('legend' => false,'label'=>array('class'=>'new-chk'),'separator'=> '</div><div class="col-sm-2">','required'=>true,'validationMessage'=>"Please select category.",'default'=>$default);
											echo $this->Form->radio('Note.category', $options, $attributes);
										?>
									</div>
								</div>
							</div>
							
							<div class='col-sm-6'>
								<div class="form-group">
								    <?php if(isset($edit_note) && $edit_note!=''){
							
							$value=$edit_note[0]['Note']['description'];
							}else{
							    $value='';
							} ?>
							
								    
								    
									<?php echo $this->Form->textarea('Note.description',array('class'=>'form-control required','div'=>false,'label'=>false,'maxlength'=>'100','value'=>$value)); ?>
								</div>
							</div>
							<?php if(isset($edit_note) && $edit_note!=''){ ?>
							<?php echo $this->Form->input('Note.edit',array('class'=>'form-control','type'=>'hidden','div'=>false,'label'=>false,'value'=>'edit')); ?>
							<?php echo $this->Form->input('Note.id',array('class'=>'form-control','type'=>'hidden','div'=>false,'label'=>false,'value'=>$edit_note[0]['Note']['id'])); ?>
							<?php } ?>
							<div class='col-sm-12'>
								<div class="form-group">
									<?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitNote','label'=>false,'div'=>false));?>
									<?php echo $this->Form->button('Cancel',array(
										'type'=>'button',
										'label'=>false,'div'=>false,
										'data-dismiss'=>'modal',
										'class'=>'btn'));
									?>
								</div>
							</div>
							<?php echo $this->Form->end();?>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<script>

</script>
<style>
	.ui-icon {
		background-repeat: no-repeat;
		display: block;
		overflow: hidden;
		text-indent: 0;
	}
</style>