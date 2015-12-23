<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content"> 
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Album</h3>
        </div>
        <?php echo $this->Form->create('Album',array('novalidate','type' => 'file','class'=>'form-horizontal'));?>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                        <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="form-group">
                                <label class="control-label col-sm-4">
                                </label>
                                <div class="col-sm-8"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">
                                    Name *:
                                </label>
                                <div class="col-sm-8"> 
                                    <?php echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'20','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Name is required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlength-msg'=>"Maximum 20 characters.",'data-pattern-msg'=>"Please enter only alphabets.")); ?>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-sm-4">
                                    Description *:
                                </label>
                                <div class="col-sm-8"> 
                                    <?php echo $this->Form->textarea('eng_description',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'20','maxlength'=>'200','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Description is required.",'data-minlength-msg'=>"Minimum 20 characters.",'data-maxlength-msg'=>"Maximum 200 characters.")); ?>
                                </div>
                            </div>                             
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="form-group">
                                <label class="control-label col-sm-4">
                                </label>
                                <div class="col-sm-8"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">
                                    Arabic Name *:
                                </label>
                                <div class="col-sm-8"> 
                                    <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control-static','maxlength'=>'200')); ?>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-sm-4">
                                    Arabic Description *:
                                </label>
                                <div class="col-sm-8"> 
                                    <?php echo $this->Form->textarea('ara_description',array('label'=>false,'div'=>false,'class'=>'form-control-static')); ?>
                                </div>
                            </div>                                
                        </div>
                    </div>
                  <!--  <div class="form-group">
                        <label class="control-label col-sm-5">
                            Status *:
                        </label>
                        <div class="col-sm-8"> 
                                    <?php //echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'InActive'),'empty'=>' -- Please Select  -- ','label'=>false,'div'=>false,'class'=>'input-sm')); ?>
                        </div>
                    </div> -->
                   
                </div>   
            </div>
        </div>     
        <div class="modal-footer pdng20">
             <div class="form-group">
                <label class="control-label col-sm-5">
                </label>
                <div class="col-sm-8 pull-right"> 
                        <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary create','label'=>false,'div'=>false));?>
                    <button  data-dismiss="modal" class="btn">Close</button>                                
                </div>
            </div>                     
        </div>
    <?php echo $this->Form->end(); ?>
    </div>
</div>
<script>
$(document).ready(function(){
    var validator = $("#AlbumAdminAddAlbumForm").kendoValidator({
                rules:{
                    minlength: function (input) {
                        return minLegthValidation(input);
                    },
                    maxlength: function (input) {
                        return maxLegthValidation(input);
                    },
                    pattern: function (input) {
                        return patternValidation(input);
                    }
                },
                errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");    
})
</script>