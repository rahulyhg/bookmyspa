
                                    <div class="modal-dialog vendor-setting">
                                        <div class="modal-content">  
                                            <div class="modal-header" id='myModal'>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                                <h3 id="myModalLabel"><i class="icon-edit"></i> Associate Treatment Images </h3>
                                            </div>
                                            <?php echo $this->Form->create($imageModel,array('id'=>'ServiceImageAdminEditTreatmentImageForm','novalidate','type' => 'file')); ?>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="box">
                                                            <div class="box-content">
                                                                
                                                                <?php echo $this->Form->hidden($serviceid,array('value'=>$serviceId,'div'=>false,'label'=>false)); ?>
                                                           
                                                               <?php
                                                                   if(isset($sImage) && !empty($sImage)){
                                                                       foreach($sImage as $image){ ?>
                                                                         <div class="row">
                                                                   <div class="col-sm-6">
                                                                       <div class="form-group">
                                                                           <label class="control-label" for="input01">Image :</label>
                                                                           <span>
                                                                           <?php
                                                                                   echo $this->Html->Image("../images/Service/150/".$image,array('width'=>'180','height'=>'130'));
                                                                            ?>
                                                                            </span>
                                                                       </div>    
                                                                   </div>
                                                                   <div class="col-sm-6">
                                                                       <div class="form-group">
                                                                           <label class="control-label" for="input01">Services :</label>
                                                                           <?php
                                                                           $ids = array();
                                                                           if(!empty($imageServices)){
                                                                               foreach($imageServices as $serImg){
                                                                                   if($serImg[$imageModel]['image'] == $image){
                                                                                       $ids[] =  $serImg[$imageModel][$serviceid];    
                                                                                   }
                                                                                   
                                                                               }
                                                                           }
                                                                           $image = str_replace('.','-',$image)
                                                                           ?>
                                                                           <?php
                                                                           echo $this->Form->input('image.'.$image,array('class'=>'form-control','id'=>'serviceImage','multiple'=>true,'div'=>false,'options'=>$subServices,'type'=>'select','label'=>false,'default'=>$ids,'empty'=>'Please Select' )); ?>
                                                                       </div>    
                                                                   </div>
                                                                </div>
                                                <?php }
                                                }?>
                                                                
                                                
                                                            </div>    
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer pdng20 ">
                                                
                                                            <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary','id'=>'submitsImg','label'=>false,'div'=>false));?>
                                                                
                                                            <?php echo $this->Form->button('Cancel',array(
                                                                            'type'=>'button','label'=>false,'div'=>false,
                                                                            'data-dismiss'=>'modal',
                                                                            'class'=>'btn')); ?>
                                                    
                                            </div>
                                             <?php echo $this->Form->end();?>
                                        </div>
                                    </div>
                                    
                                    <script type="text/javascript">
                                        $("#commonSmallModal").off("click").on('click', '#submitsImg', function(e){
                                                var options = { 
                                                    //beforeSubmit:  showRequest,  // pre-submit callback 
                                                    success:function(res){
                                                         var res = jQuery.parseJSON(res);
                                                        if(res.msg == 's'){
                                                            callfordatarepace();
                                                            $("#commonSmallModal").modal('toggle');
                                                         }
                                                        else if(res.msg == 'e'){
                                                            $("#commonSmallModal").modal('toggle');
                                                            alert('You cannot deselect "'+res.data+'".At least one image should be associated with each treatment.');
                                                            callfordatarepace();
                                                        }
                                                        
                                                    }
                                                }; 
                                                $('#ServiceImageAdminEditTreatmentImageForm').submit(function(){
                                                    $(this).ajaxSubmit(options);
                                                    $(this).unbind('submit');
                                                    $(this).bind('submit');
                                                    return false;
                                                });
                                            });
                                           //$(document).ready(function(){
                                           //     $("#commonSmallModal").on('change',"#serviceImage",function(){
                                           //         var serviceId = $(this).val();
                                           //         $(serviceId).each(function(key,valu) {
                                           //            var countservice = parseInt($("#countServiceImage").find("select").val(valu).children("option").filter(":selected").text());
                                           //            if(countservice==1){
                                           //              bootbox.alert("At least one image will be associated with service.");
                                           //            }
                                           //         });
                                           //         
                                           //     
                                           //     });  
                                           // }); 
                                          
                                    </script>
