<div class="modal-dialog vendor-setting">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i>
    <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> CMS Pages</h3>
</div>
<div class="modal-body clearfix SalonEditpop">
        <div class="box">
            <div class="box-content">
                    <?php echo $this->Form->create('StaticPage',array('novalidate','class'=>'form-horizontal'));?>
                        <div class="form-group">
                                    <label class="col-sm-3" for="input01">Alias : </label>
                                    <div class="col-sm-6">
                                        <?php echo $this->Form->input('alias',array('readonly','label'=>false,'div'=>false,'class'=>'form-control'));
                                        echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
                                    </div>
                                </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                            <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                        </ul>
                        <div class="tab-content bod-tp-non">
                            <div class="tab-pane active" id="tab1">
                                <div class="form-group"></div>
                                <div class="form-group">
                                    <label class="col-sm-3" >Title *:</label>
                                    <div class="col-sm-6">
                                        <?php echo $this->Form->input('eng_title',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3" >Name *:</label>
                                    <div class="col-sm-6">
                                        <?php echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3" >Description *:</label>
                                    <div class="col-sm-9">
                                        <?php echo $this->Form->textarea('eng_description',array('label'=>false,'div'=>false,'class'=>'ckeditor form-control')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                        <div class="form-group">
                                            <label class="col-sm-3" ></label>
                                            <div class="col-sm-6">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3">Title *:</label>
                                            <div class="col-sm-6">
                                                <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3" >Name *:</label>
                                            <div class="col-sm-6">
                                                <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3" >Description *:</label>
                                            <div class="col-sm-9">
                                                <?php echo $this->Form->textarea('ara_description',array('label'=>false,'div'=>false,'class'=>'ckeditor form-control')); ?>
                                            </div>
                                        </div>
                            </div>
                        <div class="">
                        
                            <div class="form-group">
                                <label class="col-sm-3" for="input01">Status *:</label>
                                <div class="col-sm-6">
                                    <?php echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'InActive'),'empty'=>' -- Please Select  -- ','label'=>false,'div'=>false,'class'=>'form-control')); ?>
                                </div>
                            </div>
                            <div class="modal-footer pdng20">
                                <div class="col-sm-12 pull-right">
                                        <?php
                                        echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary update ','label'=>false,'div'=>false));?>
                                        <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal',
                                                    'type'=>'button','label'=>false,'div'=>false,
                                                    'class'=>'btn closeModal')); ?>
                                </div>
                            </div>
                         
                        </div>
            </div>
                        
                    <?php echo $this->Form->end(); ?>
                </div>   
            </div>
</div>     
</div>
</div>
<script>
    $(document).ready(function(){
        var editor = CKEDITOR.instances['data[StaticPage][eng_description]'];
        if (editor) {
           editor.destroy(true);
        }
        CKEDITOR.replace('data[StaticPage][eng_description]');
        CKEDITOR.instances['StaticPageEngDescription'].on('change', function() {
            var eng_val = CKEDITOR.instances['StaticPageEngDescription'].getData();
            $(document).find('textarea[id=StaticPageEngDescription]').html(eng_val)
        });
        
        var editor = CKEDITOR.instances['data[StaticPage][ara_description]'];
        if (editor) {
           editor.destroy(true);
        }
        CKEDITOR.replace('data[StaticPage][ara_description]');
        CKEDITOR.instances['StaticPageAraDescription'].on('change', function() {
            var ara_val = CKEDITOR.instances['StaticPageAraDescription'].getData();
            $(document).find('textarea[id=StaticPageAraDescription]').html(ara_val)
        });
        
        $('#StaticPageEngTitle').keyup(function(){
            var theval = $(this).val();
            theval = theval.replace(/\s+/g, '-').toLowerCase()
            $('#StaticPageAlias').val(theval);
        });
        
        
    });
</script>