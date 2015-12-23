<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <?php echo $this->Form->create('VideoSetup',array('novalidate'));?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
            <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Video Setups</h3>
        </div>
        <div class="modal-body clearfix ServicePopForm">
            <div class="row">
            <div class="col-sm-12">
            <div class="box">
              <div class="box-content">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                    <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                </ul>
                <div class="tab-content pdng-btm-non padding tab-content-inline tab-content-bottom ">
                    <div class="tab-pane active" id="tab1">
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-3" >Title *:</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('eng_title',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','required','validationMessage'=>"English Title is required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 100 characters.")); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-3" >Description *:</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('eng_description',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','required','validationMessage'=>"English Description is required.",'data-minlength-msg'=>"Minimum 3 characters.")); ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-3" >Title :</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('ara_title',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 100 characters.")); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-3" >Description :</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('ara_description',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','data-minlength-msg'=>"Minimum 3 characters.")); ?>
                            </div>
                        </div>
                     </div>    
                </div>
                <div class="clearfix pdng20 pdng-tp-non pdng-btm-non">
                <div class="form-group clearfix">
                            <label class="control-label col-sm-3" >Youtube *:</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('youtube_link',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','required','validationMessage'=>"Youtube link is required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 100 characters.")); ?>
                            </div>
                 </div>
                    <div class="form-group clearfix ">
                            <label class="control-label col-sm-3" >Sequence Order(In Numbers) *:</label>
                            <div class="controls col-sm-9">
                                <?php echo $this->Form->input('order_sequence',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'101','maxlengthcustom'=>'100','required','validationMessage'=>"Order is required.")); ?>
                            </div>
                 </div>
               <div class="form-group clearfix">
                    <label class="control-label  col-sm-3">Status *:</label>
                    <div class="controls  col-sm-9">
                        <?php echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'InActive'),'empty'=>'Please Select','label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>"Please select status.")); ?>
                    </div>
                </div>
                    <div class="form-group clearfix ">
                            <label class="control-label col-sm-3" >Featured:</label>
                            <div class="controls col-sm-9">
                                 <?php 
                                 if(isset($this->request->data['VideoSetup']['featured']) && !empty($this->request->data['VideoSetup']['featured'])){
                                     $checked=true;
                                 }else{
                                     $checked=false;
                                 }
                                 echo $this->Form->input('featured',array('div'=>false,'type'=>'checkbox','disabled' => $checked,'class'=>' ','label'=>array('class'=>'new-chk','text'=>'Banner video'))); ?>
                            </div>
                 </div>
                    
                </div>
               </div>   
            </div>
            </div>
            </div>
            </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-12 ">
                <div class="col-sm-3 pull-right">
                <?php echo $this->Form->button('Cancel',array('data-dismiss'=>'modal','type'=>'button','label'=>false,'div'=>false,'class'=>'btn closeModal full-w')); ?>
                </div>
                <div class="col-sm-3 pull-right">
                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary full-w update','label'=>false,'div'=>false));?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script>
$(document).ready(function () {
  //called when key is pressed in textbox
   $("#VideoSetupOrderSequence").keypress(function (e){
     //if the letter is not digit then display error and don't type anything
     if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
        return false;
     }
   });
});
</script>