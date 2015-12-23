<div class="modal-dialog">
    <div class="modal-content">
        <section class="popup">
            <section class="modal-dialog">
                <section class="modal-content">
                    <section class="modal-header">
                        <button type="button" class="close close-btn" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h2 class="modal-title" id="myModalLabel"><?php echo (isset($this->data['id']) ? 'Edit' : 'Write'); ?> Text</h2>
                    </section>
                    <?php echo $this->Form->create('Content', array('url' => array('controller' => 'homes', 'action' => 'text'), 'id' => 'textContent', 'type' => 'file')); ?>
                    <input id="text_id" value="<?php echo $id; ?>" name="data[Text][text_id]" type="hidden" />
                    <input class="content_type" value="text" type="hidden"/>
                    <section class="modal-body">
                        <section class="addlistbottom">
                            <textarea required="required" name="data[Text][text]" id="editor1" rows="10" cols="80"><?php echo @$datasets['Text']['text']; ?></textarea>   </section>  
                            <input type='hidden' name='content_id' id="contentId"   value="" />                   
                            
 </section>
                    

 <section class="modal-footer">
                        <button id="insertList" data-loading-text="<?php echo (isset($this->data['id']) ? 'Updating...' : 'Inserting...'); ?>" type="submit" class="btn button"><i class="fa fa-upload font16"></i>  <span><?php echo (isset($this->data['id']) ? 'Update' : 'Insert'); ?></span>
                        </button>
                    </section>
                    <?php echo $this->Form->end(); ?>
                </section>
            </section>
        </section>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

<script>
    $(document).ready(function(){
CKEDITOR.replace('editor1');

$.fn.modal.Constructor.prototype.enforceFocus = function () {
    modal_this = this
    $(document).on('focusin.modal', function (e) {
        if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
        // add whatever conditions you need here:
        &&
        !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
            modal_this.$element.focus()
        }
    })
};});

</script>