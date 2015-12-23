<div class="modal-dialog vendor-setting overwrite">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> <?php echo ucfirst($type); ?></h3>
        </div>
        <?php echo $this->Form->create('SalonRoom',array('novalidate','class'=>'form-horizontal ServicePopForm'));?>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <div class="col-sm-9">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                            <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                                <?php   echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group">
                                    <label class="col-sm-2  control-label">	    
                                    </label>
                                    <div class="col-sm-8">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5  control-label">	    
                                        <?php echo ucfirst($type); ?> name(English)*:
                                    </label>
                                    <div class="col-sm-8">
                                            <?php echo $this->Form->input('eng_room_type',array('label'=>false,'div'=>false,'class'=>'form-control-static','minlength'=>'3','maxlengthcustom'=>'30','maxlength'=>'35','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>ucfirst($type)." name is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 30 characters.",'data-pattern-msg'=>"Please enter only alphabets.")); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">	    
                                        Description(English)*:
                                    </label>
                                    <div class="col-sm-8">
                                            <?php echo $this->Form->textarea('eng_description',array('label'=>false,'div'=>false,'class'=>'form-control-static','minlength'=>'3','maxlength'=>'500','required','validationMessage'=>"Description is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 500 characters.")); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="form-group">
                                    <label class="control-label col-sm-5">	    
                                    </label>
                                    <div class="col-sm-8">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">	    
                                        <?php echo ucfirst($type); ?> name(Arabic)*:
                                    </label>
                                    <div class="col-sm-8">
                                            <?php echo $this->Form->input('ara_room_type',array('label'=>false,'div'=>false,'class'=>'form-control-static')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">	    
                                        Description(Arabic)*:
                                    </label>
                                    <div class="col-sm-8">
                                            <?php echo $this->Form->textarea('ara_description',array('label'=>false,'div'=>false,'class'=>'form-control-static')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                        	<div class="col-sm-3">
				<div class="box image-box">
					<div class="box-title">
						<h3>Image</h3>
					</div>
					<div class="box-content">
					<ul class="tiles tiles-center nomargin">
					<?php
$count = 2;
$displayaddMore = "";
if(isset($rooms['SalonRoomImage']) && !empty($rooms['SalonRoomImage'])){
                    $imageCount = $rooms['SalonRoomImage'];
                     $count = (count($imageCount) > $count) ? count($imageCount) : $count;
                     if($count>=5){
                        $displayaddMore ="display:none";
                     }
                foreach($rooms['SalonRoomImage'] as $thelimage){
                      if($count>0){?>
                        <li class="lightgrey theImgH ">
                        <?php ?>
                        <img alt="" class="" src="/images/Service/150/<?php echo $thelimage['image']; ?>" data-img="<?php echo $thelimage['image']; ?>">
                        <div class="extras">
                                <div class="extras-inner">
                                        <a class="del-cat-pic" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                </div>
                        </div>
                        <?php echo $this->Form->hidden('serviceimage.',array('class'=>'serviceImg','label'=>false,'div'=>false,'value'=>$thelimage['image']));?>
                        </li>
                <?php
                 $count = $count - 1;
                        }
                }
        }
for($itra = 0 ; $itra < $count ; $itra++ ){ ?>
        <li class="lightgrey empty">
                <a href="javascript:void(0);" class="addImage"><span><i class="fa fa-plus"></i></span></a>
                <?php echo $this->Form->hidden('serviceimage.',array('class'=>'serviceImg','label'=>false,'div'=>false));?>
        </li>	
<?php }
?></ul>
					</div>
				</div>
                                <a href="javascript:void(0)" style="<?php echo $displayaddMore ;?> " class="rt-text addMore"><i class="fa fa-plus"></i> Add More</a>
</div>
                   
                </div>
                
            </div>
        </div>
        <div class="modal-footer">
            
            <?php
                    echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update ','label'=>false,'div'=>false));?>

            <?php   echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                'type'=>'button','label'=>false,'div'=>false,
                'class'=>'btn closeModal')); ?>
                    
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script>


function check_num(ref){
 if(Math.floor($(ref).val()) == $(ref).val() && $.isNumeric($(ref).val()) && $(ref).val()>0){ 
       
 }else{
  $(ref).val('');   
 }    
}

$(document).ready(function(){
            
            $(document).find('input').focus(function(){
                    $(this).addClass('purple-bod');
            });
            $(document).find('input').focusout(function(){
                    $(this).removeClass('purple-bod');
            });
            
            $(document).find('textarea').focus(function(){
                    $(this).addClass('purple-bod');
            });
            $(document).find('textarea').focusout(function(){
                    $(this).removeClass('purple-bod');
            });

      });
</script>