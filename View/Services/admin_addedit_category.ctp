<div class="modal-dialog vendor-setting  sm-vendor-setting">
	<div class="modal-content">
		<?php echo $this->Form->create('Service',array('admin'=>true,'novalidate','id'=>'ServiceCatForm','class'=>'form-horizontal ServicePopForm'));?>
		<div class="modal-header">
			<button type="button" class="close pos-lft" data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
				<span class="sr-only">Close</span>
			</button>
			<h2 class="no-mrgn"><?php echo (isset($this->data) && !empty($this->data))?'Edit':'Add';?> <?php echo ($typ)?$typ:'Details'; ?> </h2>
		</div>
		<div class="modal-body clearfix">
			<div class="row">
				<div class="col-sm-8 col-xs-8">
					<div class="box">
						<div class="box-content">
							<?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
							<?php echo $this->Form->hidden('parent_id',array('value'=>$parentId,'label'=>false,'div'=>false));?>
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
											    <?php //echo $this->Form->input('frontend_display',array('type'=>'checkbox','label'=>false,'div'=>false,'class'=>'styled')); ?> View On Front-End
											</label>
										    </div>
										</li>-->
									</ul>
									<div class="tab-content padding tab-content-inline tab-content-bottom ">
										<div class="tab-pane active" id="first11">
											<div class="form-group">
												<label class="control-label col-sm-12 nopadding">Name *:</label>
												<div class="col-sm-12">
												    <?php 
                                                                                                    $patern = "^[A-Za-z.'\-\s]+$";
                                                                                                    echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','pattern'=>$patern,'required','validationMessage'=>"English name is required.",'data-pattern-msg'=>"Please enter only alphabets and ( . , ' and - ).",'data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'maxlength'=>105)); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-12 nopadding">Description *:</label>
												<div class="col-sm-12">
												    <?php echo $this->Form->input('eng_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>12,'minlength'=>'20','maxlengthcustom'=>'500','required','validationMessage'=>"English description name is required.",'data-minlength-msg'=>"Minimum 20 characters.",'data-maxlengthcustom-msg'=>"Maximum 500 characters.",'maxlength'=>501)); ?>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="second22">
											<div class="form-group">
												<label class="control-label col-sm-12 nopadding">Name:</label>
												<div class="col-sm-12">
												    <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters are allowed.",'maxlength'=>105)); ?>
												</div>
											</div>
											<div class="form-group">
											    <label class="control-label col-sm-12 nopadding">Description:</label>
											    <div class="col-sm-12">
												<?php echo $this->Form->input('ara_description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'form-control','rows'=>12,'minlength'=>'20','maxlengthcustom'=>'500','data-minlength-msg'=>"Minimum 20 characters.",'data-maxlengthcustom-msg'=>"Maximum 500 characters.",'maxlength'=>501)); ?>
											    </div>
											</div>
										</div>
									</div>
								</div>
							</div>    
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-xs-4">
					<div class="box image-box">
						<div class="box-title">
							<h3>Image <span style="color:red;">*</span></h3>
						</div>
						<div class="box-content">
							<ul class="tiles imagesList tiles-center nomargin">
								<?php $count = 5;
								if(isset($this->data['ServiceImage']) && !empty($this->data['ServiceImage'])){
									foreach($this->data['ServiceImage'] as $thelimage){ ?>
										<li class="lightgrey theImgH ">
										<?php ?>
										<img alt="" class="" src="/images/Service/150/<?php echo $thelimage['image']; ?>" data-img="<?php echo $thelimage['image']; ?>">
										<div class="extras">
											<div class="extras-inner">
												<a class="del-cat-pic" href="javascript:void(0);"><i class="fa fa-times"></i></a>
											</div>
										</div>
										<?php echo $this->Form->hidden('serviceimage.',array('class'=>'serviceImg','label'=>false,'div'=>false,'required'=>false,'value'=>$thelimage['image']));?>
										</li>
									<?php
									$count = $count - 1;
									}
								}
								for($itra = 0 ; $itra < $count ; $itra++ ){ ?>
									<li class="lightgrey empty">
										<a href="javascript:void(0);" class="addImage"><span><i class="fa fa-plus"></i></span></a>
										<?php echo $this->Form->hidden('serviceimage.',array('class'=>'serviceImg','label'=>false,'div'=>false,'required'=>false)); ?>
									</li>	
								<?php }
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer pdng20">
			<div class="col-sm-12 pull-right">
				<?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitCategory','label'=>false,'div'=>false));?>
				<?php echo $this->Form->button('Cancel',array(
					'type'=>'button','label'=>false,'div'=>false,
					'class'=>'btn' , 'data-dismiss'=>"modal")); ?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script>
$(document).ready(function(){
    Custom.init();
	
	$(document).find(".imagesList").sortable({
		placeholder:    'placeholder',
		cancel: ".empty"
	});
	
});
</script>
