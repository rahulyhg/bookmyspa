<div class="row">    
    <div class="col-sm-12">
        <div class="box">
            <div class="box-content">
                <div class="col-sm-8">
                   <?php echo $this->Form->create('MetaTag',array('novalidate','class'=>'form-horizontal'));?>
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-sm-4 pdng-tp7">Title</label>
                            <div class="col-sm-8">
                                    <?php echo $this->Form->input('title',array(
                                                                'type'=>'text',
                                                                'label'=>false,
                                                                'div'=>false,
                                                                'class'=>'form-control',
                                                                'maxlength'=>100,
                                                                'placeholder'=>'Author','required'
                                                    )); 
                                       ?>
                                     
                            </div>                                                         
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-sm-4 pdng-tp7"> Description </label>
                            <div class="col-sm-8">
				      <?php echo $this->Form->input('description',array(
                                                                'type'=>'text',
                                                                'label'=>false,
                                                                'div'=>false,
                                                                'class'=>'form-control',
                                                                'maxlength'=>255,
                                                                'placeholder'=>'description','required'
                                                    )); 
                                       ?>
                            </div>
                        </div>
			<div class="form-group">
                            <label class="control-label col-sm-4 pdng-tp7">My Website/Webpage Keywords </label>
                            <div class="col-sm-8">
					<?php echo $this->Form->input('keywords',array(
								  'type'=>'textarea',
								  'label'=>false,
								  'div'=>false,
								  'class'=>'form-control',
								  'placeholder'=>'Keywords',
                                                                  'required'							  )); 
					 ?>
                            <div class="col-sm-8 pdng-tp7 lft-p-non">Please use "," seprated keywords</div>             
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-8">&nbsp </label>
                            <div class="col-sm-8 pull-right">
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
