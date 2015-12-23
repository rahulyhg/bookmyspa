<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    } 
    .bigScreen {
        width: 760px;
    }
</style> 
<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                <?php echo (isset($this->data) && !empty($this->data)) ? 'Edit' : "Add"; ?> Blog </h3>
        </div>
 <?php echo $this->Form->create('Blog', array('novalidate', 'type' => 'file', 'class' => 'form-horizontal')); ?>
        <div class="modal-body">
            <div class="box">
                <div class="box-content nopadding">
                   <?php
                   if(isset($this->data) && !empty($this->data))
                   {
                   ?>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="input01">Alias : </label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->input('alias', array('readonly', 'label' => false, 'div' => false, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                   <?php
                   }
                   ?>
                
                <div class="form-group">
                    <label class="control-label col-sm-4" >Catgories *:</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('category', array('div'=>false,'label' => false, 'options' => $this->common->get_list('eng_name'), 'multiple' => true, 'class' => 'form-control', 'selected' => $cats)); ?>
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                    <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                </ul>
                    
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="clearfix"></div>
                         <div class="form-group clearfix" style="margin-top: 10px;">
                            <label class="control-label col-sm-4" >English Title *:</label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('eng_title', array('label' => false, 'div' => false, 'class' => 'form-control', 'maxlength' => '200')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" >English Description *:</label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->textarea('eng_description', array('label' => false, 'div' => false, 'class' => 'ckeditor form-control')); ?>
                            </div>
                        </div>
                      </div>
                   
                    <div class="tab-pane" id="tab2">
                         <div class="form-group clearfix" style="margin-top: 10px;">
                            <label class="control-label col-sm-4">Arabic Title *:</label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('ara_title', array('label' => false, 'div' => false, 'class' => 'form-control', 'maxlength' => '200')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" >Arabic Description *:</label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->textarea('ara_description', array('label' => false, 'div' => false, 'class' => 'ckeditor form-control')); ?>
                            </div>
                        </div>
                    </div>    
                     </div>
           
            <div class="form-group">
                <label class="control-label col-sm-4" for="input01">Image : </label>
                <div class="col-sm-8">
                    <?php echo $this->Form->input('image', array('type' => 'file', 'label' => false, 'div' => false, 'class' => 'form-control', 'onChange' => 'readURL(this)')); ?>
                    <div class="preview">
                        <?php
                        $uid = $this->Session->read('Auth.User.id');
                        if (!empty($pageDetail['Blog']['image'])) {
                            echo $this->Html->Image('../images/' . $uid . '/Blog/150/' . $pageDetail['Blog']['image']);
                        }
                        ?> 
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="input01">Status *:</label>
                <div class="col-sm-8">
                    <?php echo $this->Form->input('status', array('options' => array('1' => 'Active', '0' => 'InActive'), 'empty' => ' -- Please Select  -- ', 'label' => false, 'div' => false, 'class' => 'form-control')); ?>
                </div>
            </div>
        </div>
            </div>
    </div>   
        <div class="modal-footer pdng20">
                         <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary update', 'label' => false, 'div' => false)); ?>
                <?php
                echo $this->Form->button('Cancel', array('data-dismiss' => 'modal',
                    'type' => 'button', 'label' => false, 'div' => false,
                    'class' => 'btn',
                ));
                ?>
        </div>
        <?php echo $this->Form->end(); ?>
</div>    
</div>

<script>
    $(document).ready(function() {

        var editor = CKEDITOR.replace( 'data[Blog][eng_description]', {
            filebrowserBrowseUrl : '../../js/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl : '../../js/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl : '../../js/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
        CKFinder.setupCKEditor( editor, '../' );
        
        var editorara = CKEDITOR.replace( 'data[Blog][ara_description]', {
            filebrowserBrowseUrl : '../../js/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl : '../../js/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl : '../../js/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl : '../../js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
        CKFinder.setupCKEditor( editorara, '../' );
        //var editor = CKEDITOR.instances['data[Blog][eng_description]'];
        //if (editor) {
        //    editor.destroy(true);
        //}
        //CKEDITOR.replace('data[Blog][eng_description]');
        //CKEDITOR.instances['BlogEngDescription'].on('change', function() {
        //    var eng_val = CKEDITOR.instances['BlogEngDescription'].getData();
        //    $(document).find('textarea[id=BlogEngDescription]').html(eng_val)
        //});
        //
        //var editor = CKEDITOR.instances['data[Blog][ara_description]'];
        //if (editor) {
        //   editor.destroy(true);
        //}
        //CKEDITOR.replace('data[Blog][ara_description]');
        //CKEDITOR.instances['BlogAraDescription'].on('change', function() {
        //    var ara_val = CKEDITOR.instances['BlogAraDescription'].getData();
        //    $(document).find('textarea[id=BlogAraDescription]').html(ara_val)
        //});
        //$("#StaticPageAdminAddPageForm").validationEngine();
        //$('#BlogEngTitle').keyup(function() {
        //    var theval = $(this).val();
        //   theval = theval.replace(/\s+/g, '-').toLowerCase()
        //    $('#BlogAlias').val(theval);
        //});
        //
        
        
        
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.preview').html('<img src="' + e.target.result + '" style="width: 200px;"/>');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>