<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h2 class="no-mrgn">Select Image</h2>
        </div>
        <div class="modal-body clearfix SalonEditpop">
            <div class="row">
                <div class="col-sm-12">
                    <div class="scrollError" style="height: 545px; overflow: auto;">
                        <div class="box">
                            <div class="box-content no-mrgn">
                                <?php if(isset($noService)){ ?>
                                    <h4>Please select services.</h4>    
                                <?php }elseif(empty($serImages)){?>
                                    <h4>There are no images in selected services.</h4>    
                                <?php }else{ ?>
                                    <?php //pr($serImages); ?>
                                    <ul class="gallery item-pictures imgFor-thePkg">
                                        <?php foreach($serImages as $theImages){ ?>
                                        <li>
                                            <?php echo $this->Html->image('/images/Service/150/'.$theImages,array('class'=>" ", 'data-img'=>$theImages)); ?>
                                            <div class="extras">
                                                <div class="extras-inner">
                                                    <a class="addImage-to-sub" href="javascript:void(0);"><i class="icon-plus"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


            
