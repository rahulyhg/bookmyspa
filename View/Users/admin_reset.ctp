<div class="modal-dialog vendor-setting overwrite">
<div class="modal-content">
<?php echo $this->Form->create('User',array('novalidate'));?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-edit"></i> Reset Username/Password</h3>
</div>
<div class="modal-body">
    <div class="box">
        <div class="box-content">
                <div class="sample-form form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Username *:</label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->hidden('id',array('label'=>false,'div'=>false)); ?>
                            <?php echo $this->Form->input('username',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'35','maxlengthcustom'=>'30','required','pattern'=>'^[A-Za-z0-9@_/-/._-]+$','validationMessage'=>"Username is required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 30 characters.",'data-pattern-msg'=>"Only alphanumeric or (@_-.) characters or valid email are allowed.")); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Password *:</label>
                        <div class="col-sm-8">
                            <?php echo $this->Form->input('password',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'8','maxlength'=>'102','maxlengthcustom'=>'100','required','validationMessage'=>"Password is required.",'data-minlength-msg'=>"Minimum 8 characters.",'data-maxlengthcustom-msg'=>"Maximum 100 characters.")); ?>
                        </div>
                    </div>
                </div>
        </div>   
    </div>
</div>     

<div class="modal-footer pdng20">
            <div class="col-sm-12 ">
                    <div class="col-sm-2 pull-right">
                    <?php echo $this->Form->button('Cancel',array(
                                        'type'=>'button','label'=>false,'div'=>false,
                                        'data-dismiss'=>'modal',
                                        'class'=>'btn  full-w')); ?>
                  </div>
                    <div class="col-sm-2 pull-right">
                    <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary  mrgn-rgt10 restUserPwd full-w','label'=>false,'div'=>false));?></div>
            </div>
      </div>
<?php echo $this->Form->end(); ?>

</div>
</div>