<?php echo $this->Html->script('bootbox'); ?>
<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    }
</style> 
<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
               Add/Change Image</h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <?php echo $this->Form->create('User', array('novalidate' , 'class'=>'form-horizontal','type'=>'file')); ?>
		    <input type="hidden" name="resize" value="" id="resize">
                            <div class="form-group">
                                <label for="additionalfield" class="col-sm-2 control-label"><?php echo __('Image', true); ?></label>
                                <div class="col-sm-5">
                                    <?php echo $this->Form->input('image', array('type' => 'file', 'label' => false, 'div' => false, 'class' => 'input-xlarge input-block-level', 'onChange' => 'readURL(this)')); ?>
                                    <div class="preview">
                                        <?php
                                        if (!empty($user['User']['image'])) {
                                            echo $this->Html->Image('/images/' . $user['User']['id'] . '/User/200/' . $user['User']['image']);
                                        }
                                        ?> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions col-sm-8 text-center">
                                <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary update_image', 'label' => false, 'div' => false)); ?>
                                <?php
                                echo $this->Form->button('Cancel', array('data-dismiss' => 'modal',
                                    'type' => 'button', 'label' => false, 'div' => false,
                                    'class' => 'btn closeModal'))
                                ?>
                            </div>
                            <?php echo $this->Form->end(); ?>         
                </div> 
            </div>   
        </div>
    </div> 

</div>
</div>
<script>
  /* Image preview fuction */
  function readURL(input){
    fileInput = '#'+$(input).attr('id');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                        var img = new Image;
                        img.onload = function() {
			    var imageheight = img.height;
			    var imageWidth = img.width;
			    var imageSize = input.files[0].size / 1024;
			    if(imageSize > 350){
				$(document).find(fileInput).val('');
				$(document).find(fileInput).after($(fileInput).clone(true)).remove();
				$(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
				var msg = 'Image should be upto 350 kb';
				bootbox.alert(msg);
				return msg;
				
			    }else if(imageheight >=  imageWidth){
				$(document).find(fileInput).val('');
				$(document).find(fileInput).after($(fileInput).clone(true)).remove();
				$(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
  //                            $fileInput.replaceWith( $fileInput = $fileInput.clone( true ) );
				var msg = 'Image should be landscape.'
				bootbox.alert(msg);
				return msg;
			    }else if(imageheight < 300 || imageWidth < 600){
				$(document).find(fileInput).val('');  
				$(document).find(fileInput).after($(fileInput).clone(true)).remove();
				$(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
    //obj.prev().val('');
    //                             $(fileInput).replaceWith( $(fileInput) = $(fileInput).clone( true ) );
				var msg = 'Minimum height and width of file should be 300 * 600';
				bootbox.alert(msg);
				return msg;
			    }else if(imageheight > 300 && imageWidth > 600){
				var ratio = (imageWidth / imageheight);
				if(ratio == 2){
				    $('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
				    $('#resize').val('1');
				}else{
				    $(document).find(fileInput).val('');
				    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
				    $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
				    var msg = 'Image should be in the ratio of 2:1';
				    bootbox.alert(msg);
				    return msg;
				}
			    }else{
				$('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
				$('#resize').val('');
			    }
                        };
                      img.src = reader.result;
                        };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>