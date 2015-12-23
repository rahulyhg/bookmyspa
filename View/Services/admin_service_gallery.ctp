<div class="modal-dialog vendor-setting overwrite">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>Select Image</h3>
        </div>
        <div class="modal-body slct-img-pop">
            <div class="box">
                <div class=''>
                    <div class="col-sm-12">
                    
                        <div class="box-title">
                        <h3>Choose Image From Sieasta Gallery</h3>
                        </div>
                            <div class="box-content">
                        <?php if(!empty($service)){ ?>
                                <ul class="gallery item-pictures" style="">
                            <?php foreach($service as $singleService){ ?>
                                <?php if($singleService['Service']['parent_id'] != 0){ ?>
                                 <?php if(isset($singleService['ServiceImage']) && !empty($singleService['ServiceImage'])){ ?>
                                     <?php foreach($singleService['ServiceImage'] as $theImages){ ?>
                                    <li class="single-picture">
                                        <?php echo $this->Html->image('/images/Service/150/'.$theImages['image'],array('class'=>" ", 'data-img'=>$theImages['image'])); ?>
                                        <div class="extras">
                                            <div class="extras-inner">
                                                <a class="addImage-to-sub" href="javascript:void(0);"><i class="icon-plus"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                        <?php }else{
                            
                            echo "No Sieasta Image found.";
                            
                        }?>
                            </div>
                            
                        <?php if(isset($salonservice['SalonServiceImage']) && !empty($salonservice['SalonServiceImage'])){ ?>
                        <div class="box-title">
                        <h3>Choose Image From Your Gallery</h3>
                        </div>
                        <?php //if($salonservice['Service']['parent_id'] != 0){
                            if(isset($salonservice['SalonServiceImage']) && !empty($salonservice['SalonServiceImage'])){
                                $class = "";
                                $style = "";
                                if(count($salonservice['SalonServiceImage']) > 6){
                                    $class = "scroll";
                                    $style = "height:210px";
                                }
                                ?>
                        <div class="box-content <?php echo $class; ?>" style="<?php echo $style; ?>" >
                        
                        
                                <ul class="gallery item-pictures">
                                    <?php foreach($salonservice['SalonServiceImage'] as $theImages){ ?>
                                    <li class="single-picture">
                                        <?php echo $this->Html->image('/images/Service/150/'.$theImages['image'],array('class'=>" ", 'data-img'=>$theImages['image'])); ?>
                                        <div class="extras">
                                            <div class="extras-inner">
                                                <a class="addImage-to-sub" href="javascript:void(0);"><i class="icon-plus"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            
                        </div>
                        <?php }
                           
                        // }?>
                     <?php }?>
                    </div>
                </div>    
        
                <hr style="margin: 0px;">
                <div class='row'>
                    <div class="box  col-sm-12">
                        <div class="box-content">
                            <div class="col-sm-8">
                            <dl>
                                <dt>Upload image from your computer</dt>
                                <dd>
                                    Images should be landscape (wide, not tall) a minimum width of 800 pixels & height of 400 pixels, and should let customers know what your venue is like. Always use photos taken at your own salon/spa if possible.
                                </dd>
                            </dl>
                            </div>
                            <div class="col-sm-4 text-center" style="padding-top:30px;">
                                <button class="btn btn-primary toUploadImage">
                                    <i class="icon-upload-alt"></i> Upload
                                </button>
                                <div style="display: none">
                                <?php echo $this->Form->create('Service',array('novalidate','type'=>'file','id'=>'guploadImageForm')); ?>
                                <?php $theClass = ($path == 'Deal')?'Deal':''; ?>
                                
                                <?php echo $this->Form->input('upimage',array('id'=>'ServiceUpimage'.$theClass,'type'=>'file','div'=>false,'label'=>false)); ?>
                                <?php echo $this->Form->hidden('id',array('value'=>$serviceId,'div'=>false,'label'=>false)); ?>
                                <?php echo $this->Form->hidden('parent_id',array('value'=>(isset($service['Service']['id']))?$service['Service']['id']:0,'div'=>false,'label'=>false)); ?>
                                <?php echo $this->Form->submit(); ?>
                                <?php echo $this->Form->end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>   
        </div>
    </div>
</div>

<script>
    $(document).find(".scroll").mCustomScrollbar({
	    advanced:{updateOnContentResize: true}
    });
</script>