<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('VenueVideo', array('url' => array('controller' => 'Settings', 'action' => 'set_venue_video','admin'=>true),'type'=>'file','id'=>'submitVideoForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
             <?php if(isset($type) &&($type=="gallery")){?>
	    <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    <?php } ?>
            <h2><?php echo (isset($vdotype))?'Public':'Venue';?> Video</h2>
        </div>
        <div class="modal-body clearfix">
            <div class="col-sm-12 nopadding">
                <div class="box">
                    <div class="box-content form-horizontal nopadding">
                        <div class="col-sm-8">
                            <div class="frm-grp" >
                            <div class="form-group clearfix">
                                <label class="col-sm-2 lft-p-non">Link :</label>
                                <div class="col-sm-5 nopadding">
                                    <?php echo $this->Form->input('VenueVideo.link',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                                <div class="col-sm-5 addremove">
                                    <a href="javascript:void(0);" class="addthatURL">
										<input type="button" name="Save" class="btn btn-primary" value="Save" />
										<!--<i class="fa fa-plus"></i>-->
									</a>   
                                </div>
                             </div>
                            </div>
                           <!-- <div class="form-group clearfix">
                                <label class="col-sm-2 lft-p-non"></label>
                                <div class="col-sm-6 nopadding">
                                    <input type="button" name="Add More" class="addMore btn btn-primary" value="Add More" />
                                </div>
                            </div>-->
                            
                        </div>
                        <div class="col-sm-6 youtubeall">
                            <ul class="gallery">
			    </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
             
	    <div class="col-sm-3 pull-right">
	      
            <?php if(isset($type) &&($type=="gallery")){ ?>
                <input type="submit" name="next" class="submitVideoForm btn btn-primary " value="Close" />
            <?php }else{
                    if(isset($vdotype)){ ?>
                        <input type="submit" name="next" class="submitAlbVdoForm btn btn-primary " value="Next" />
                    <?php }else{ ?>
                        <input type="submit" name="next" class="submitVideoForm btn btn-primary " value="Next/Skip" />
                    <?php } ?>
            <?php } ?>
            </div>
	    
	    <div class="col-sm-3 pull-right">
		    <div class="form-group clearfix">
			    <input type="button" name="Add More" class="addMore btn btn-primary" value="Add More" />
		 </div>
	     </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    Custom.init();
</script>
