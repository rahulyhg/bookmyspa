<? echo $this->Html->script('admin/jquery.Jcrop.min.js');
echo $this->Html->css('admin/jquery.Jcrop.min.css'); ?>

<div class="modal-dialog vendor-setting">
    <div class="modal-content">  
        <div class="modal-header" id='myModal'>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>Crop Image</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
			    <?php echo $this->Form->create('cropnsave',array("onsubmit"=>"return checkCoords();"));?>
				<div class="row">
				    <div class="col-sm-10">
					 <div class="form-group">
					    <label class="control-label" for="input01">Image *:</label>
						<?php echo $this->Html->image('/images/Service/500/'.$image,array('id'=>'cropbox')); ?>
					</div>
				    </div>
				    <div class="col-sm-2">
					    <div class="form-actions pull-right">
						<?php
						  echo $this->Form->hidden('x',array('id'=>'x','label'=>false,'div'=>false));
						  echo $this->Form->hidden('y',array('id'=>'y','label'=>false,'div'=>false));
						  echo $this->Form->hidden('w',array('id'=>'w','label'=>false,'div'=>false));
						  echo $this->Form->hidden('h',array('id'=>'h','label'=>false,'div'=>false)); ?>
						  <i>Please select the image portion which you want to crop</i>
						    <input class="btn btn-large btn-primary saveCrop" type="submit" value="Crop Image">
					    </div>
				    </div>
				</div>
			   <?php echo $this->Form->end(); ?>
			</div>
		    </div>   
		</div>
	    </div>
	</div>
    </div>
</div>

<script type="text/javascript">
  $(function(){
    $('#cropbox').Jcrop({
      onSelect : updateCoords,
	//bgColor : 'transparent', // Allows for png's to not inherit black background
	//bgOpacity : .2,
	setSelect : [ 0, 0, 100, 100 ],
	aspectRatio : 1.5,
	minSize : [200, 150],
	allowSelect : false,
	onRelease : releaseCheck 
    });
    var clickSubmit = 'yes'; 
    $(document).find('#commonMediumModal').off('click').on('click', '.saveCrop', function(e){
	if(confirm("Are you sure you want to crop this image?")){
		var options = { 
		//beforeSubmit:  showRequest,  // pre-submit callback 
		success:function(res){
		    if(res == 's'){
			callfordatarepace();
			$(document).find('#commonMediumModal').modal('toggle');
		    }
		    else{
			//alert('Unable to process Request');
		    }
		    
		}
	    }; 
	    $('#cropnsaveAdminCropnsaveForm').submit(function(){
		if(clickSubmit = 'yes')
		{
		    $(this).ajaxSubmit(options);
		    clickSubmit = 'no';
		}
		
		$(this).unbind('submit');
		$(this).bind('submit');
		return false;
	    });
	}else{
	    e.preventDefault();
	}
    
});


  });
  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };
  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a square section of the image for site-wide display purposes.');
    return false;
  };
  
  function releaseCheck() {
this.setOptions({ setSelect: [0,0,100,100] });
}; 
  
  
</script>

<?php
    //pr($image['TempImage']['image'])
?>
<style>
    .jcrop-holder{
	 background-color: #000000;
	height: 450px;
	margin: 0 auto;
	position: relative;
	width: 450px;
    }
    .img-crop-popup img {
	margin-right: 10px !important;
    }
    .img-crop-popup span {
	float: inherit !important;
    }
    .img-crop-popup input[type="submit"] {
	float: right;
    }
    
</style>
	