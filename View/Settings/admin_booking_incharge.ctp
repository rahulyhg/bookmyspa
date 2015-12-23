<div class="modal-dialog vendor-setting overwrite">
    <?php echo $this->Form->create('User', array('url' => array('controller' => 'Settings', 'action' => 'bookingIncharge','admin'=>true),'id'=>'submitbookingInchargeForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2>Booking Incharge</h2>
        </div>
        <div class="modal-body clearfix">
            <div class="col-sm-12 nopadding">
                <div class="box">
                    <div class="box-content bookInchg  form-horizontal nopadding">
                        <div class="form-group">
                            <label class="control-label col-sm-4"><?php echo ucfirst($auth_user['User']['first_name'])." ".ucfirst($auth_user['User']['last_name'])?> :</label>
                            <div class="col-sm-8">
                               <?php
                               $checked = 'checked';
                               ?>
                               <?php echo $this->Form->input('UserDetail.booking_incharge.',array('id'=>'user-'.$auth_user['User']['id'],'checked'=>$checked,'value'=>$auth_user['User']['id'],'div'=>false,'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Yes'))); ?>
                            </div>
                        </div>
                        <?php if(!empty($staffList)){
                            foreach($staffList as $stafmember){ ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-4"><?php echo ucfirst($stafmember['User']['first_name'])." ".ucfirst($stafmember['User']['last_name'])?> :</label>
                                    <div class="col-sm-8">
                                       <?php
                                        $checked = false;
                                        if($stafmember['UserDetail']['booking_incharge']){$checked = 'checked';}
                                        ?>
                                       <?php echo $this->Form->input('UserDetail.booking_incharge.',array('id'=>'user-'.$stafmember['User']['id'],'checked'=>$checked,'value'=>$stafmember['User']['id'],'div'=>false,'class'=>'','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'Yes'))); ?>
                                    </div>
                                </div>
                            <?php 
                            }
                        }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-3 pull-right">
                <input type="submit" name="next" class="submitbookingInchargeForm btn btn-primary" value="Next" />
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<script>
    Custom.init();
    $(document).ready(function(){
        $(document).find('input[type=checkbox]').on('change',function(){
            var itsObj = $(this);
            if(!itsObj.is(':checked')){
                var countchked = 0;
                $(document).find('input[type=checkbox]').each(function(){
                    if($(this).is(':checked')){
                        countchked = countchked +1 ;
                    }
                });
                if(countchked == 0){
                    itsObj.prop('checked','checked');
                    alert('There must be atleast one Booking Incharge');
                }
            }
        });
    });
</script>
