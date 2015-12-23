
  <div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="no-mrgn">Custom  Title</h2>
        </div>
        <div class="modal-body SalonEditpop">
           <div class="box">
                <div class="box-content">
                <ul class="tabs tabs-inline tabs-top">
                        <li class='active'>
                                <a href="#first" data-toggle='tab'>English</a>
                        </li>
                        <li>
                                <a href="#second" data-toggle='tab'>Arabic</a>
                        </li>
                </ul>
                <div class="tab-content  tab-content-inline tab-content-bottom ">
                <div class="tab-pane active" id="first">
                    <div class="">
                        <label class="control-label col-sm-3" for="input01">Custom Title: </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->hidden('customId',array('id'=>'customId','value'=>$uniqId)); ?>
                            <?php echo $this->Form->input('custom_title_eng', array('label' => false, 'div' => false, 'class' => 'form-control', 'id'=>'editTitleEng')); ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="second">
                     <div class="">
                        <label class="control-label col-sm-3" for="input01">Custom Title: </label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('custom_title_ara', array('label' => false, 'div' => false, 'class' => 'form-control', 'id'=>'editTitleAra')); ?>
                        </div>
                    </div>
                </div>
                     
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
          <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary submitCustomTitle','label'=>false,'div'=>false));?>
          <?php echo $this->Form->button('Cancel',array(
                                          'type'=>'button','label'=>false,'div'=>false,
                                          'class'=>'btn' , 'data-dismiss'=>"modal")); ?>
        </div>
      </div>
    </div>

    <script>
    $(document).ready(function(){
        var id = '<?php echo $uniqId; ?>';
        var engTitle =  $('#Package').find('.customTitleEng'+id).val();
        var araTitle =  $('#Package').find('.customTitleAra'+id).val();
         $("#editTitleEng").val(engTitle);
         $("#editTitleAra").val(araTitle);
         
    })
    </script>