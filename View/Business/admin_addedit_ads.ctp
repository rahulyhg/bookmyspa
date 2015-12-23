<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    } 
</style>    
<div class="modal-dialog vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Salon Advertisement</h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <?php echo $this->Form->create('SalonAd',array('novalidate','class'=>'form-horizontal'));?> 
                    <?php 
                    echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); 
                    ?>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                        <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="form-group">
                                <label class="col-sm-2" ></label>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2" >English Title *:</label>
                                <div class="col-sm-6">
                                        <?php echo $this->Form->input('eng_title',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-sm-2" >English Description *:</label>
                                <div class="col-sm-6">
                                        <?php echo $this->Form->textarea('eng_description',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2">Specific Location :</label>
                                <div class="col-sm-6">
                                                <?php echo $this->Form->input('eng_location',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
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
                                <label class="col-sm-2">Arabic Title *:</label>
                                <div class="col-sm-6">
                                                <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-sm-2" >Arabic Description *:</label>
                                <div class="col-sm-6">
                                                <?php echo $this->Form->textarea('ara_description',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2">Specific Location :</label>
                                <div class="col-sm-6">
                                                <?php echo $this->Form->input('ara_location',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>
                        </div>                         
                            <div class="form-group">
                                <label class="col-sm-2" >Image *:</label>
                                <div class="col-sm-6"> 
                                        <?php echo $this->Form->input('image',array('type'=>'file','label'=>false,'div'=>false,'class'=>'form-control' ,'onChange'=>'readURL(this)')); ?>
                                        <span class="">
                                        <br>
                                        <?php   $text = "<i style=\"font-size:11px\">You can upload image of width and height 520 x 144 only</i><br>";
                                                echo "<b><i>Note</i> : </b>&nbsp;".$text ?>
                                        </span><br/>                                         
                                        <div class="preview">                                        
                                       <?php
                                            if(!empty($adDetail['SalonAd']['image'])){
                                             echo $this->Html->Image('/images/'.$uid.'/SalonAd/original/'.$adDetail['SalonAd']['image']); 
                                            }
                                         ?>                                     
                                    </div>
                                </div>                                  
                            </div>

                        <div class="form-group">
                               <label class="control-label col-sm-2">Youtube Link:</label>
                                <?php echo $this->Form->input('url',array('required'=>true,'type'=>'url','label'=>false,'div'=>array('class'=>'col-sm-6'),'class'=>'form-control')); ?>
                                <span class="col-sm-10 pull-right"></br><i style="font-size:11px">Only youtube video url are accepted</i><br>
                               <i style="font-size:11px">ex: https://www.youtube.com/watch?v=h2Nq0qv0K8M </i>
                       </span><br/>
                       </div>                       
                    </div>
                    <div class="">                      
                        <div class="form-actions col-sm-8 text-center">
                                <?php
                                echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update ','label'=>false,'div'=>false));?>
                                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                            'type'=>'button','label'=>false,'div'=>false,
                                            'class'=>'btn closeModal')); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>   
            </div>
        </div>     
    </div>
</div>
<script>
 /* function to show image before upload */
 function readURL(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.preview').html('<img src="'+e.target.result+'" style="width: 200px;"/>');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
