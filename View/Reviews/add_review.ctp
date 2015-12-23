<!--<script src="../js/star-rating.js" type="text/javascript"></script>
-->
<?php echo $this->Html->script('frontend/star-rating.js?v=1'); ?>
<?php echo $this->Html->css('frontend/star-rating.css?v=1'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i> Appointment review </h3>
    
        </div>
        <?php
	//pr($service_id); die;
	    echo $this->Form->create('ReviewRating',array('novalidate','class'=>'form-shorizontal'));
	    echo $this->Form->hidden('user_id',array('label'=>false,'div'=>false,'value'=>$userId));
	    
	    if($type_id=='service'){
		echo $this->Form->hidden('service_id',array('label'=>false,'div'=>false,'value'=>$service_id[0]['Appointment']['salon_service_id']));
		echo $this->Form->hidden('staff_id',array('label'=>false,'div'=>false,'value'=>$service_id[0]['Appointment']['salon_staff_id']));
	    }elseif($type_id=='packages'){
		//pr($package_id); die;
		for($i=1;$i<count($package_id);$i++){
		  //  pr($package_id); die;
		    echo $this->Form->hidden('Service.service_id_'.$i,array('label'=>false,'div'=>false,'value'=>$package_id[$i]['Appointment']['salon_service_id']));
		echo $this->Form->hidden('Staff.staff_id_'.$i,array('label'=>false,'div'=>false,'value'=>$package_id[$i]['Appointment']['salon_staff_id']));
		}
		echo $this->Form->hidden('package_id',array('label'=>false,'div'=>false,'value'=>$package_id[0]['Appointment']['package_id']));
	    }
	    echo $this->Form->hidden('salon_id',array('label'=>false,'div'=>false,'value'=>$salon_id));
	?>
        <div class="modal-body SalonEditpop">
            <div class="box">
                <div class="box-content sell_service edit-pricing-option">
                <div class="form-group">
                    <label class="control-label col-sm-4" >Venue:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('venue_rating', array('type'=>'text','div'=>false,'label' => false, 'class' => 'form-control rating-input')); ?>
                    </div>
                </div>
		<?php //echo $type_id; die; ?>
		<?php if($type_id=='service'){ ?>
                <div class="form-group">
                    <label class="control-label col-sm-4" >Staff:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('staff_rating', array('type'=>'text','div'=>false,'label' => false, 'class' => 'form-control rating-input')); ?>
                    </div>
                </div>
		<?php }elseif($type_id=='packages'){ ?>
		
		
			<?php //die("test"); ?>
			<?php for($i=1;$i<count($package_id);$i++){ ?>
		 
			<div class="form-group">
                    <label class="control-label col-sm-4" >Staff-<?php echo $i; ?>:</label>
                    <div class="col-sm-8">
			
                        <?php echo $this->Form->input('Staff.staff_rating_'.$i, array('type'=>'text','div'=>false,'label' => false, 'class' => 'form-control rating-input')); ?>
			 </div>
                </div>
			<?php } ?>
                   
		<?php } ?>
		
		
		
                <!--<div class="form-group">
                    <label class="control-label col-sm-4" >Service:</label>
                    <div class="col-sm-8">
                        <?php //echo $this->Form->input('service_rating', array('type'=>'text','div'=>false,'label' => false, 'class' => 'form-control rating-input')); ?>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="control-label col-sm-4" >Venue Review</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('venue_review', array('type'=>'textarea','div'=>false,'label' => false, 'class' => 'form-control','placeholder'=>'')); ?>
                    </div>
                </div>
                <!--<div class="form-group">
                   <label class="control-label col-sm-4" > Service Provider Review </label>
                       <div class="col-sm-8">
                           <?php //echo $this->Form->input('staff_review', array('type'=>'textarea','div'=>false,'label' => false, 'class' => 'form-control','placeholder'=>'')); ?>
                       </div>
                </div>-->
                    <!-- <label>Font Awesome Stars</label>
                    <input id="input-2c" class="rating" min="0" max="5" value='' step="1" data-size="sm"
                          data-symbol="&#xf005;" data-glyphicon="false" data-rating-class="rating-fa">
                     <input id="input-2c" class="rating" min="0" max="5" value='' step="1" data-size="sm"
                          data-symbol="&#xf005;" data-glyphicon="false" data-rating-class="rating-fa">    -->  
               </div>
            </div>
         </div>
       
        <div class="modal-footer">
	   
            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitPricingOption','label'=>false,'div'=>false));?>
            <?php echo $this->Form->button('Cancel',array( 'type'=>'button','label'=>false,'div'=>false, 'class'=>'btn' , 'data-dismiss'=>"modal")); ?>
        </div>
        <?php echo $this->Form->end();?>
    </div>
</div>
<script>
    
    $('.rating-input').rating({
              min: 0,
              max: 5,
              step: 0.5,
              size: 'xs',
              showClear: false
           });
    
    
</script>