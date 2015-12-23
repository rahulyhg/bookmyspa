<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('Service', array('url' => array('controller' => 'Services', 'action' => 'select_service','admin'=>true),'id'=>'serviceSelectForm','novalidate'));?>  
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h2>Create Tag</h2>
	    </div>
	    
	    <div class="modal-body clearfix">
            <?php echo $this->Form->create('Service',array('url'=>array('controller'=>'Services','action'=>'treatment','admin'=>true),'novalidate','id'=>'ServiceTreatmentForm'));?>
                <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
                <?php echo $this->Form->hidden('parent_id',array('label'=>false,'div'=>false));?>
                <div class="row-fluid">
                    <div class="span3 imageLeftSec" <?php echo (isset($this->data) && isset($this->data['Service']['parent_id']) && $this->data['Service']['parent_id'] > 0 )? 'style="display:none"':''; ?> >
                        <section class="utopia-widget menu-item-pictures forImage" style="text-align: center; position: relative;">
                            <div class="linkhideshow" >
                                <?php echo $this->Html->link('EDIT','javascript:void(0)',array('class'=>'editSImg')) ?>
                                <?php echo $this->Html->link('DELETE','javascript:void(0)',array('class'=>'deleteSImg')) ?>
                            </div>
                            <?php
                            if(isset($this->data['ServiceImage']) && !empty($this->data['ServiceImage'])){
                                $listImg = $this->data['ServiceImage'][0]['image'];
                                ?>
                                <div class="single-picture  ">
                                <?php echo $this->Html->image('/images/Service/150/'.$listImg,array('data-img'=>$listImg,'class'=>"hasSImage itsImage"));?>
                                </div>
                            <?php }else{ ?>
                                <div class="single-picture empty">
                                    <div class="single-picture-wrapper" style="position: relative;">
                                    <div class="theSImage itsImage vertically-centered" style="">
                                        <i class="icon-plus"></i>
                                        Add Image
                                    </div>
                                    </div>
                                </div>    
                            <?php } ?>
                            <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'style'=>'display:none','class'=>'serviceImg')); ?>
                        </section>
                    </div>
                    <div class="span8">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                            <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                            <li class="pull-right extFrntDply">
                                <div class="controls">
                                    <label class="checkbox">
                                     <?php echo $this->Form->input('frontend_display',array('type'=>'checkbox','label'=>false,'div'=>false,'class'=>'')); ?> View On Front-End
                                    </label>
                                </div>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >Name *:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >Display Name *:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('eng_display_name',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row-fluid">
                                    <div class="control-group">
                                            <label class="control-label" >Description *:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('eng_description',array('label'=>false,'div'=>false,"rows"=>"3" ,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane araContent " id="tab2">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >Name *:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" >Display Name *:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('ara_display_name',array('label'=>false,'div'=>false,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row-fluid">
                                    <div class="control-group">
                                            <label class="control-label" >Description *:</label>
                                            <div class="controls">
                                                <?php echo $this->Form->input('ara_description',array('label'=>false,'div'=>false,"rows"=>"3" ,'class'=>'input-xlarge input-block-level')); ?>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid sample-form form-horizontal extDetailSec" style="display: none;">
                        
                            <div class="control-group">
                                <label class="control-label">Price($) :</label>
                                <div class="controls">
                                    <?php echo $this->Form->hidden('ServiceDetail.id',array('label'=>false,'div'=>false,'class'=>'')); ?>
                                    <?php echo $this->Form->input('ServiceDetail.price',array('type'=>'text','label'=>false,'div'=>false,'class'=>'input-medium  input-block-level')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Duration(min) :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('ServiceDetail.duration',array('type'=>'text','label'=>false,'div'=>false,'class'=>'input-medium  input-block-level')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Points Given :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('ServiceDetail.points_given',array('type'=>'text','label'=>false,'div'=>false,'class'=>'input-medium input-block-level')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Points Redeem :</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('ServiceDetail.points_redeem',array('type'=>'text','label'=>false,'div'=>false,'class'=>'input-medium input-block-level')); ?>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                
                    <div class="span3 imageRigthSec"  <?php echo (isset($this->data) && isset($this->data['Service']['parent_id']) && $this->data['Service']['parent_id'] > 0 )? '':'style="display:none"'; ?> >
                        <div class="forMultiImage" style="text-align: center;">
                            <h4>Menu Item Image</h4>
                            <ul class="gallery menu-item-pictures">
                                <?php
                                $countIImg = 5;
                                if(isset($this->data['ServiceImage']) && !empty($this->data['ServiceImage'])){
                                    foreach($this->data['ServiceImage'] as $theImages){ ?>
                                        <li class="single-picture">
                                            <?php echo $this->Html->image('/images/Service/150/'.$theImages['image'],array('class'=>" ", 'data-img'=>$theImages['image'])); ?>
                                            <div class="extras">
                                                <div class="extras-inner">
                                                    <a rel="group-1" class="colorbox-image cboxElement" href="javascript:void(0);">
                                                    <i class="icon-search"></i>
                                                    </a>
                                                    <a class="del-cat-pic" href="javascript:void(0);"><i class="icon-trash"></i></a>
                                                </div>
                                            </div>
                                        </li>   
                                    <?php
                                    $countIImg = $countIImg -1;
                                    }
                                }?>
                                <?php
                                if($countIImg > 0 ){
                                    for($lup = 1 ; $lup <= $countIImg ; $lup++){ ?>
                                        <li class="single-picture empty">
                                            <div class="single-picture-wrapper" style="position: relative;">
                                            <div class="add-picture vertically-centered" style="">
                                                <i class="icon-plus"></i>
                                                Add Image
                                            </div>
                                            </div>
                                        </li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </div>
                   </div>
                   
</div>    
<div class="row-fluid sample-form form-horizontal">
    <div class="form-actions">
        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitTreatment ','label'=>false,'div'=>false));?>
        <?php echo $this->Form->button('Cancel',array(
                    'type'=>'button','label'=>false,'div'=>false,
                    'class'=>'btn cancelTreatment ')); ?>
        
    </div>

</div>

<?php echo $this->Form->end(); ?>

            </div>
          </div>
          
          <div class="modal-footer">
          	<input type="submit" name="next" class="submitSelectForm purple-btn" value="Next" />
          </div>
        </div>
    <?php echo $this->Form->end(); ?>
    </div>
