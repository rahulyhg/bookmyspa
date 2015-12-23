<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('User', array('url' => array('controller' => 'Settings', 'action' => 'set_userphotos','admin'=>true),'type'=>'file','id'=>'submitImgeForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2>Profile Photos</h2>
        </div>
        <div class="modal-body clearfix">
            <div class="col-sm-12 nopadding">
                <div class="box">
                    <div class="box-content nopadding">
                        <div class="cover" style=" border:1px solid #cbcbcb; text-align:center">
                          <?php if($auth_user['Salon']['cover_image']){
                            
                              echo $this->Html->image("/images/".$auth_user['User']['id']."/Salon/original/".$auth_user['Salon']['cover_image'],array("class"=>"imageView" ,'title'=>"change Image" ,'alt'=>"Image"));
                           
                           }else{ ?>
                                <img style="width:50%" src="/img/imgo.jpg" alt="" title="">
                            <?php } ?>    
                            
                            <?php  echo $this->Form->input('cover_image',array('label'=>false,'div'=>false,'type'=>"file",'style'=>"display:none;",'class'=>"coverImage",'id'=>"coverImage")); ?>
                            <div class="profile-sec" >
                                <div class="profile-img">
                                    <?php if($auth_user['Salon']['logo']){
                            
                                        echo $this->Html->image("/images/".$auth_user['User']['id']."/User/150/".$auth_user['Salon']['logo'],array("class"=>"imageView" ,'title'=>"change Image" ,'alt'=>"Image"));
                                     
                                     }else{ ?>
                                      
                                          <img  src="/img/imgo.jpg" alt="" title="">
                                      
                                      <?php } ?>
                                      
                                    <?php  echo $this->Form->input('image',array('label'=>false,'div'=>false,'type'=>"file",'style'=>"display:none;",'class'=>"logoImage",'id'=>"logoImage"));?>
                                        <div class="extras">
                                            <div class="pull-right">
                                                <button class="btn btn-primary logoImg">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="extras">
                                <div class="pull-right">
                                    <button class="btn btn-primary coverImg">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20 ">
            <div class="col-sm-5 pull-left">
                <i>Note:Only jpg,png or gif extension is allowed </i>
            </div>
            <div class="col-sm-3 pull-right">
                <input type="submit" name="next" class="submitImgeForm btn btn-primary" value="Next" />
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click','.coverImg',function(e){
            e.preventDefault();
            $(document).find('.coverImage').click();
        });
        $(document).on('click','.logoImg',function(e){
            e.preventDefault();
            $(document).find('.logoImage').click();
        });
        
        $(document).on('change','.logoImage',function(){
            var theLimg = $(this);
            file = this.files[0];
            var obj = $(this);
            var valReturn = validate_image(file);
            if(valReturn){
                obj.val('');
                alert(valReturn);
            }
            else{
                var reader = new FileReader();
                var image = new Image();
                reader.readAsDataURL(file);
                reader.onload = function(_file) {
                    image.src    = _file.target.result;              // url.createObjectURL(file);
                    image.onload = function() {
                        var w = this.width,
                            h = this.height,
                            t = file.type,                           // ext only: // file.type.split('/')[1],
                            n = file.name,
                            s = ~~(file.size/1024) +'KB';
                            var kbs = ~~(file.size/1024);
			    var resize = '';
			    var thecheckimage = checklogoimage(parseInt(w),parseInt(h),kbs);
                            if(thecheckimage == 'size-error'){
                                alert('Image should be upto 100 Kb.In case you would like us to resize and compress image please send it support@sieasta.com ');
                                return false;
                            }else if(thecheckimage == 'resize-error'){
                                alert('Image should be in the ratio of 2:1.In case you would like us to resize and compress image please send it support@sieasta.com ');
                               return false;
                            }else if(thecheckimage == 'limit-error'){
                                alert('Image should be minimum of 800*400. In case you would like us to resize and compress image please send it support@sieasta.com ');
                                return false;
                            }else{
                                theLimg.closest('div').find('img').attr('src',image.src);
                            }
                        };
                    image.onerror= function() {
                        alert('Invalid file type: '+ file.type);
                    };      
                };
            }   
        });
        
        $(document).on('change','.coverImage',function(){
            var theLimg = $(this);
            file = this.files[0];
            var obj = $(this);
            var valReturn = validate_image(file);
            if(valReturn){
                obj.val('');
                alert(valReturn);
            }
            else{
                var reader = new FileReader();
                var image = new Image();
                reader.readAsDataURL(file);
                reader.onload = function(_file) {
                    image.src    = _file.target.result;              // url.createObjectURL(file);
                    image.onload = function() {
                        var w = this.width,
                            h = this.height,
                            t = file.type,                           // ext only: // file.type.split('/')[1],
                            n = file.name,
                            s = ~~(file.size/1024) +'KB';
                            var kbs = ~~(file.size/1024);
			    var resize = '';
			    var thecheckimage = checkbannerimagedata(parseInt(w),parseInt(h),kbs);
                            if(thecheckimage == 'size-error'){
                                alert('Image should be upto 350 Kb.In case you would like us to resize and compress image please send it support@sieasta.com ');
                               return false;
                            }else if(thecheckimage == 'resize-error'){
                                alert('Image should be in the ratio of 2:1.In case you would like us to resize and compress image please send it support@sieasta.com ');
                                return false;
                            }else if(thecheckimage == 'limit-error'){
                                alert('Image should be minimum of 1600*800. In case you would like us to resize and compress image please send it support@sieasta.com ');
                                return false;
                            }else{
                                 theLimg.closest('div').find('img:first').attr('src',image.src).css('width','100%');
                            }
                           
                        };
                    image.onerror= function() {
                        alert('Invalid file type: '+ file.type);
                    };      
                };
            }   
        });
        
    });
</script>
