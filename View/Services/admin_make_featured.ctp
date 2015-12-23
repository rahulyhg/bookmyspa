<div class="modal-dialog vendor-setting">
    <div class="modal-content">  
        <div class="modal-header" id='myModal'>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>Make Featured </h3>
        </div>
        <?php echo $this->Form->create($imageModel,array('id'=>'ServiceImageAdminEditTreatmentImageForm','novalidate','type' => 'file')); ?>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-content">
                            
                            <?php echo $this->Form->hidden($serviceid,array('value'=>$serviceId,'div'=>false,'label'=>false)); ?>
                            <?php echo $this->Form->hidden('image_id',array('value'=>$sImage,'div'=>false,'label'=>false)); ?>
                            <div class="row">
                                 <div class="col-sm-6">
                                    <?php
                                    if(isset($sImage) && !empty($sImage)){
                                    ?>
                                        <div class="form-group">
                                            <label class="control-label" for="input01">Image :</label>
                                            <?php
                                                    echo $this->Html->Image("../images/Service/150/".$sImage,array('width'=>'180','height'=>'130'));
                                             ?> 
                                        </div>
                                          <?php 
                                }?>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                        <label class="control-label" for="input01">Services :</label>
                                        <?php
                                        $ids = array();
                                       
                                        $newSubServices = array();
                                        if(!empty($imageServices)){
                                            foreach($imageServices as $serImg){
                                                if($serImg[$imageModel]['order'] == 0){
                                                    $ids[]=  $serImg[$imageModel][$serviceid];    
                                                }
                                                if(in_array($serImg[$imageModel][$serviceid],array_flip(array_filter($subServices)))){
                                                    $newSubServices[$serImg[$imageModel][$serviceid]]= $subServices[$serImg[$imageModel][$serviceid]];
                                                }
                                                
                                            }
                                        }
                                        $image = str_replace('.','-',$sImage);
                                       // pr(array_flip($image));
                                        ?>
                                        <?php
                                        echo $this->Form->input('subService',array('class'=>'form-control','multiple'=>true,'options'=>$newSubServices,'type'=>'select','div'=>false,'label'=>false,'default'=>$ids,'empty'=>'Please Select' )); ?>
                                    </div>    
                                </div>
                            </div>
          
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pdng20">
                
                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary','id'=>'submitsImg','label'=>false,'div'=>false));?>
                            
                        <?php echo $this->Form->button('Cancel',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'data-dismiss'=>'modal',
                                        'class'=>'btn')); ?>
                    
            </div>
           <?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#commonSmallModal").off("click").on('click', '#submitsImg', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    if(res == 's'){
                        callfordatarepace();
                        $("#commonSmallModal").modal('toggle');
                        
                    }
                    else{
                        alert('Unable to process Request');
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
        
    
</script>
