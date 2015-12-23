<?php
echo $this->Html->script('admin/tinycolor-0.9.15.min.js');
echo $this->Html->script('admin/pick-a-color-1.2.3.min.js');
echo $this->Html->css('admin/pick-a-color-1.2.3.min.css');
?>
 <style type="text/css">
		       .container {
				margin: 0px 5px;
				width: 50%;
		       }
		       #GiftImageImage{
					      padding:0px
		       }
</style>
<script type="text/javascript">
                $(document).ready(function () {
		      $(".pick-a-color").pickAColor({
					     showSpectrum : true,
					     showSavedColors : true,
					     saveColorsPerElement : true,
					     fadeMenuToggle : true,
					     showAdvanced: true,
					     showBasicColors: true,
					     showHexInput : true,
					     allowBlank : true,
					     inlineDropdown : true
		      });
			
		});
</script>
<div class="modal-dialog vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">
                <i class="icon-edit"></i>
                <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?>Gift Certificate Image
            </h3>
	</div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <?php echo $this->Form->create('GiftImage',array('novalidate','class'=>'form-horizontal'));?> 
                    <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false));?>
                    <div class="form-group">
		       <label class="col-sm-2" ></label>
                       <div class="col-sm-6"></div>
                    </div>  
                    <div class="form-group">
                       <label class=" col-sm-3">Image category *: </label>
                       <div class="col-sm-6 list">
                            <?php echo $this->Form->input('gift_image_category_id',  array('name'=>'data[GiftImage][gift_image_category_id]','label'=>false,'div'=>false,'options' =>$catList,'class'=>'form-control','empty'=>'-Please Select-','required', 'validationMessage'=>'Select image category.'));  ?>
                       </div>
		       <div class="col-sm-3">
		           <?php echo $this->Html->link('<i class="icon-plus"></i> Add Category','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'add_category btn btn-primary')); ?>
		       </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                        <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="form-group">
                                <label class="col-sm-2" ></label>
                                <div class="col-sm-6">
                                </div>
                        </div>                                            
                        <div class="tab-pane active" id="tab1">
                            <div class="form-group">
                                <label class="col-sm-3" >English Title*:</label>
                                <div class="col-sm-6">
                                        <?php echo $this->Form->input('eng_title',array('label'=>false,'div'=>false,'class'=>'form-control','required', 'validationMessage'=>'Enter title.')); ?>
                                </div>
                            </div>                                                                                  
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="form-group">
                                <label class="col-sm-2" ></label>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3">Arabic Title:</label>
                                <div class="col-sm-6">
					      <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>false,'class'=>'form-control','required'=>false)); ?>
                                </div>
                            </div>                                                       
                        </div> 
		      <div class="form-group">
			 <label class=" col-sm-3">Text Align*: </label>
			 <div class="col-sm-6">
			      <?php echo $this->Form->input('text_align',  array('label'=>false,'div'=>false,'options' =>array('Left'=>'Left On Image','Right'=>'Right On Image'),'class'=>'form-control','validationMessage'=>'Upload an image.'));  ?>
			 </div>
		      </div>
                        <div class="form-group">
                            <label class="col-sm-3" >Gift Certificate Image*:</label>
                            <div class="col-sm-6"> 
                                        <?php
					$image = '';
					if(!empty($giftImageDetail['GiftImage']['image'])){
					    $image = 1;
					}
					echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control','onChange'=>'readURL(this)' ,'required'=>false));
		                        echo $this->Form->hidden('imageValid',array('id'=>'imageValid','label'=>false,'div'=>false,'required'=>true,'validationMessage'=>'Please upload image of size 940x560. In case you would like us to resize and compress image please send it support@sieasta.com','value'=>$image));
					?>
					<dfn class="text-danger k-invalid-msg" data-for="data[GiftImage][image]" role="alert" style="display: none;">Please upload image of size 940x560. In case you would like us to resize and compress image please send it support@sieasta.com</dfn>
                                        <span class="">
					        <br>
                                        <?php   $text = "<i style=\"font-size:11px\">Please upload image of size 940x560. In case you would like us to resize and compress image please send it support@sieasta.com</i><br>";
                                                echo "<b><i>Note</i> : </b>&nbsp;".$text ?>
                                        </span>                                  
                                        <div class="preview">                                        
					      <?php
					      $uid = $this->Session->read('Auth.User.id');
					     
					      if(!empty($giftImageDetail['GiftImage']['image'])){
								     echo $this->Html->Image('/images/GiftImage/150/'.$giftImageDetail['GiftImage']['image']); 
					      } else {
								    
					      }
					      ?>                                     
                                        </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <label class="col-sm-3">Font Color </label>
                                <div class="col-sm-6">
					      <?php if(!empty($giftImageDetail['GiftImage']['font_color'])){
								     $fnt_color = $giftImageDetail['GiftImage']['font_color'];
					      } else {
								     $fnt_color = '000000';
					      }?>
                                        <?php echo $this->Form->input('font_color',array('label'=>false,'div'=>false,'value'=>$fnt_color,'class'=>'pick-a-color form-control')); ?>
                                </div>
                            </div> 
                    </div>
		    
                    <div class="">
                            <div class="form-group">
                                <label class="col-sm-3"></label>
                                <div class="col-sm-6">
                                        <?php
                                echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update ','label'=>false,'div'=>false));?>
                                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn closeModal')); ?>
                                </div>
                            </div> 
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>   
            </div>
        </div>     
    </div>
</div>

<script type="text/javascript">

function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
		      var image = new Image();
		    image.src    = e.target.result;              // url.createObjectURL(file);
                    image.onload = function() {
                        var w = this.width,
                            h = this.height,
                            t = input.files[0].type,                           // ext only: // file.type.split('/')[1],
                            n = input.files[0].name,
                            s = ~~(input.files[0].size/1024) +'KB';
                            if(parseInt(w)==940  && parseInt(h)==560){
                                //alert(w);alert(h);alert(n);
				$("#imageValid").val(1);
				//$(".update").trigger('click');
				$(document).find("dfn").css('display','none');
                            }else{
				$("#imageValid").val('');
				//$(".update").trigger('click');
				$(document).find("dfn").css('display','inline');
                            }
                        };
                    image.onerror= function() {
                        alert('Invalid file type: '+ file.type);
			$("#imageValid").val('');
			//$(".update").trigger('click');
			$(document).find("dfn").css('display','inline');
                    };  
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
/*********Add Category *********************/
var $modal1 = $('#commonContainerModal');
        var itsId  = "";
	 var catModal = 'false';
        $(document).off('click' ,'.add_category').on('click','.add_category',function(){
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'GiftImages','action'=>'add_category','admin'=>true)); ?>";
            addeditURL = addeditURL+'/'+itsId
            // function in modal_common.js
	  fetchModal($modal1,addeditURL);
	    
            return false;
        });
   
        $modal1.off('click' ,'.updateCat').on('click', '.updateCat', function(e){
            var catModal = 'false';
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($modal1,'GiftImageCategory',res)){
                     fetch_cat_list();   
                    }
                }
            }; 
            $('#GiftImageCategoryAdminAddCategoryForm').submit(function(){
		$(this).ajaxSubmit(options);
		$(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
             
        });
	     
        function fetch_cat_list(){
                $(".list").load("<?php echo $this->Html->url(array('controller'=>'GiftImages','action'=>'category_list')); ?>")
        }        
</script>
