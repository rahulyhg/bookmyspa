<div class="modal-header" id='myModal'>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i> Treatment Image </h3>
</div>
<div class="modal-body">
    <div class="box row-fluid">
        <?php echo $this->Form->create('ServiceImage',array('id'=>'ServiceImageAdminEditTreatmentImageForm','novalidate','type' => 'file')); ?>
             <?php echo $this->Form->hidden('service_id',array('value'=>$serviceId,'div'=>false,'label'=>false)); ?>
            <?php
                if(isset($sImage) && !empty($sImage)){
                    foreach($sImage as $image){ ?>
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label" for="input01">Image :</label>
                        <?php
                                echo $this->Html->Image("../images/Service/50/".$image);
                         ?> 
                    </div>    
                </div>
                <div class="span6">
                    <div class="control-group">
                       
                        <label class="control-label" for="input01">Services :</label>
                        <?php
                        $ids = array();
                        if(!empty($imageServices)){
                            foreach($imageServices as $serImg){
                                if($serImg['ServiceImage']['image'] == $image){
                                    $ids[] =  $serImg['ServiceImage']['service_id'];    
                                }
                                
                            }
                        }
                        $image = str_replace('.','-',$image)
                        ?>
                        <?php
                        echo $this->Form->input('image.'.$image,array('class'=>'input-xlarge input-block-level','options'=>$subServices,'type'=>'select','label'=>false,'default'=>$ids,'empty'=>'Please Select' )); ?>
                    </div>    
                </div>
            </div>
            <?php }
            }?>
            <div class="row-fluid">
                <div class="span9">
                </div>
                <div class="span3">
                    <div class="utopia-from-action">
                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary span5 submitsImg','label'=>false,'div'=>false));?>
                            
                        <?php echo $this->Form->button('Cancel',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'data-dismiss'=>'modal',
                                        'class'=>'btn  span5 close')); ?>
                    </div>
                </div>
            </div>
                <?php echo $this->Form->end();?>
    </div>
</div>

<script type="text/javascript">
    $("#commonSmallModal").on('click', '.submitsImg', function(e){
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
