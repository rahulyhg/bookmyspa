<?php
    echo $this->Html->script('admin/userincr'); 
    echo $this->Html->script('admin/jquery.timepicker');
    echo $this->Html->css('admin/jquery.timepicker'); 
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click','.checkday',function(){
            var theObj = $(this);
            if(theObj.is(':checked')){
                theObj.closest('li').addClass('on').removeClass('off');
                theObj.closest('li').find('input[type=text]').removeAttr('disabled');
            }
            else{
                theObj.closest('li').addClass('off').removeClass('on');
                theObj.closest('li').find('input[type=text]').attr('disabled', 'disabled');
            }
        });
        
        $(document).on('click','.copyall',function(){
            if($(document).find('.week').find('input[type=checkbox]:checked:first').length > 0){
                var startTime = $(document).find('.week').find('input[type=checkbox]:checked:first').closest('li').find('.timeStart').val();
                var endTime = $(document).find('.week').find('input[type=checkbox]:checked:first').closest('li').find('.timeEnd').val();
                $(document).find('.week li').each(function(){
                    if($(this).find('input[type=checkbox]').length > 0){
                        $(this).addClass('on').removeClass('off');
                        $(this).find('input[type=checkbox]').prop('checked','checked');
                        $(this).find('input[type=text]').removeAttr('disabled');
                        $(this).find('.timeStart').val(startTime);
                        $(this).find('.timeEnd').val(endTime);
                    }
                });
            }
        });
        $('.timePKr').timepicker();
    });
</script>

<style>
    ol, ul {
        list-style: none outside none;
    }
    ul.week li{min-height: 47px;}
    .setmargn{margin-top: 8px;text-align: center;}
    .open-txt-lft.setmargn{text-align: left !important;}
</style>
<div class="row"> 
    <div class="col-sm-12">
        <div class="box">
          <div class="box-content nopadding">
<div class="row mrgn-btm10">
    <div class="form-group no-mrgn horiz-scroll">
        
    <div class="col-sm-12 nopadding w500">
        <div id="message" style="color:red;display: none;color: red;font-size: 13px;
                                padding-bottom: 20px;padding-left: 68px;">
            From Time should be greater the To time
        </div>
        <ul class="week <?php echo ($ajaxVar) ? "col-sm-12" : "col-sm-7";?>  nopadding">
            <li class="bod-tp ">
                <section class="col-sm-12 nopadding">
                    <section class="col-sm-1 col-xs-1 setmargn open-txt-lft">
                        <strong>Open</strong>
                    </section>
                    <section class="col-sm-3 col-xs-3 setmargn">
                        <strong>Working Days</strong>
                    </section>
                    <section class="col-sm-2 col-xs-2 setmargn">
                        <strong>Open</strong>
                    </section>
                    <section class="col-sm-1 col-xs-1 ">  </section>
                    <section class="col-sm-2 col-xs-2 setmargn">
                        <strong>Close</strong>
                    </section>
                    <section class="col-sm-3">
                        <?php echo $this->Form->button('Copy All',array('type'=>'button','class'=>'btn btn-primary full-w copyall','label'=>false,'div'=>false));?>                           
                        
                    </section>
                </section>
            </li>
            <li class="<?php echo ($checked)?'on':'off';?>">
                <section class="col-sm-12 nopadding">
                    <section class="col-sm-1 col-xs-1 setmargn">
                        <?php echo $this->Form->input('is_checked_disable_mon',array('checked'=>$checked,'id'=>'Mon','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp'),'div'=>false,'class'=>'checkday')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 setmargn">
                        Monday
                    </section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                    <?php $monday_from = (isset($this->data['SalonOpeningHour']['monday_from']) && $this->data['SalonOpeningHour']['monday_from'])?$this->data['SalonOpeningHour']['monday_from']:'9:00am'; ?>
                            <?php echo $this->Form->input('monday_from',array('value'=>$monday_from,'label'=>false,'div'=>false,'disabled'=>$disabled,'class'=>'form-control timeStart timePKr')); ?>
                    </section>
                    <section class="col-sm-1 col-xs-1 setmargn"> - </section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $monday_to = (isset($this->data['SalonOpeningHour']['monday_to']) && $this->data['SalonOpeningHour']['monday_to'])?$this->data['SalonOpeningHour']['monday_to']:'6:00pm'; ?>
                        <?php echo $this->Form->input('monday_to',array('value'=>$monday_to,'label'=>false,'div'=>false,'disabled'=>$disabled,'class'=>'form-control timeEnd timePKr')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 text-center"><i class="fa fa-angle-down fa-3"></i></section>
                </section>
            </li>
            <li class=" <?php echo ($checkedTue)?'on':'off';?>">
                <section class="col-sm-12 nopadding">
                    <section class="col-sm-1 col-xs-1 setmargn">
                        <?php echo $this->Form->input('is_checked_disable_tue',array('checked'=>$checkedTue,'div'=>false,'id'=>'Tue','type'=>'checkbox','class'=>'checkday','label'=>array('class'=>'new-chk','text'=>'&nbsp'))); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 setmargn">
                        Tuesday
                    </section>
                    
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $tuesday_from = (isset($this->data['SalonOpeningHour']['tuesday_from']) && $this->data['SalonOpeningHour']['tuesday_from'])?$this->data['SalonOpeningHour']['tuesday_from']:'9:00am'; ?>
                        <?php echo $this->Form->input('tuesday_from',array('value'=>$tuesday_from,'label'=>false,'div'=>false,'disabled'=>$disabledTue,'class'=>'form-control timeStart timePKr')); ?>
                    </section>
                    <section class="col-sm-1 col-xs-1 setmargn"> - </section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $tuesday_to = (isset($this->data['SalonOpeningHour']['tuesday_to']) && $this->data['SalonOpeningHour']['tuesday_to'])?$this->data['SalonOpeningHour']['tuesday_to']:'6:00pm'; ?>
                        <?php echo $this->Form->input('tuesday_to',array('value'=>$tuesday_to,'label'=>false,'div'=>false,'disabled'=>$disabledTue,'class'=>'form-control timeEnd timePKr')); ?>
                    </section>
                    <section class="col-sm-3 text-center"><i class="fa fa-angle-down fa-3"></i></section>
                </section>
            </li>
        
            <li class=" <?php echo ($checkedWed)?'on':'off';?>">
                <section class="col-sm-12 nopadding">
                    <section class="col-sm-1 col-xs-1 setmargn">
                        <?php echo $this->Form->input('is_checked_disable_wed',array('checked'=>$checkedWed,'id'=>'Wed','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp;'),'div'=>false,'class'=>'checkday')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 setmargn">
                        Wednesday
                    </section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                    <?php $wednesday_from = (isset($this->data['SalonOpeningHour']['wednesday_from']) && $this->data['SalonOpeningHour']['wednesday_from'])?$this->data['SalonOpeningHour']['wednesday_from']:'6:00am'; ?>
                        <?php echo $this->Form->input('wednesday_from',array('value'=>$wednesday_from,'label'=>false,'div'=>false,'disabled'=>$disabledWed,'class'=>'form-control timeStart timePKr')); ?>
                    </section>
                    <section class="col-sm-1 col-xs-1 setmargn"> - </section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $wednesday_to = (isset($this->data['SalonOpeningHour']['wednesday_to']) && $this->data['SalonOpeningHour']['wednesday_to'])?$this->data['SalonOpeningHour']['wednesday_to']:'6:00pm'; ?>
                        <?php echo $this->Form->input('wednesday_to',array('value'=>$wednesday_to,'label'=>false,'div'=>false,'disabled'=>$disabledWed,'class'=>'form-control timeEnd timePKr')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 text-center"><i class="fa fa-angle-down fa-3"></i></section>
                </section>
            </li>
            <li class=" <?php echo ($checkedThu)?'on':'off';?>">
                <section class="col-sm-12 nopadding">
                    <section class="col-sm-1 col-xs-1 setmargn ">
                        <?php echo $this->Form->input('is_checked_disable_thu',array('checked'=>$checkedThu,'id'=>'Thu','type'=>'checkbox','label'=>array('class'=>'new-chk','text'=>'&nbsp'),'div'=>false,'class'=>'checkday')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 setmargn">
                        Thursday
                    </section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $thursday_from = (isset($this->data['SalonOpeningHour']['thursday_from']) && $this->data['SalonOpeningHour']['thursday_from'])?$this->data['SalonOpeningHour']['thursday_from']:'9:00am'; ?>
                        <?php echo $this->Form->input('thursday_from',array('value'=>$thursday_from,'label'=>false,'div'=>false,'disabled'=>$disabledThu,'class'=>'form-control timeStart timePKr')); ?>
                    </section>
                    <section class="col-sm-1 col-xs-1 setmargn"> - </section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $thursday_to = (isset($this->data['SalonOpeningHour']['thursday_to']) && $this->data['SalonOpeningHour']['thursday_to'])?$this->data['SalonOpeningHour']['thursday_to']:'6:00pm'; ?>
                        <?php echo $this->Form->input('thursday_to',array('value'=>$thursday_to,'label'=>false,'div'=>false,'disabled'=>$disabledThu,'class'=>'form-control timeEnd timePKr')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 text-center"><i class="fa fa-angle-down fa-3"></i></section>
                </section>
            </li>
            <li class=" <?php echo ($checkedFri)?'on':'off';?>">
                <section class="col-sm-12 nopadding">
                    <section class="col-sm-1 col-xs-1 setmargn">
                        <?php echo $this->Form->input('is_checked_disable_fri',array('checked'=>$checkedFri,'id'=>'Fri','type'=>'checkbox','label'=>array('text'=>'&nbsp;','class'=>'new-chk'),'div'=>false,'class'=>'checkday')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 setmargn">
                        Friday
                    </section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $friday_from = (isset($this->data['SalonOpeningHour']['friday_from']) && $this->data['SalonOpeningHour']['friday_from'])?$this->data['SalonOpeningHour']['friday_from']:'9:00am'; ?>
                        <?php echo $this->Form->input('friday_from',array('value'=>$friday_from,'label'=>false,'div'=>false,'disabled'=>$disabledFri,'class'=>'form-control timeStart timePKr')); ?>
                    </section>
                    <section class="col-sm-1 col-xs-1 setmargn">-</section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $friday_to = (isset($this->data['SalonOpeningHour']['friday_to']) && $this->data['SalonOpeningHour']['friday_to'])?$this->data['SalonOpeningHour']['friday_to']:'6:00pm'; ?>
                        <?php echo $this->Form->input('friday_to',array('value'=>$friday_to,'label'=>false,'div'=>false,'disabled'=>$disabledFri,'class'=>'form-control timeEnd timePKr')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 text-center"><i class="fa fa-angle-down fa-3"></i></section>
                </section>
            </li>
            <li class=" <?php echo ($checkedSat)?'on':'off';?>">
                <section class="col-sm-12 nopadding">
                    <section class="col-sm-1 col-xs-1 setmargn">
                        <?php echo $this->Form->input('is_checked_disable_sat',array('checked'=>$checkedSat,'id'=>'Sat','type'=>'checkbox','label'=>array('text'=>'&nbsp;','class'=>'new-chk'),'div'=>false,'class'=>'checkday')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 setmargn">Saturday</section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $saturday_from = (isset($this->data['SalonOpeningHour']['saturday_from']) && $this->data['SalonOpeningHour']['saturday_from'])?$this->data['SalonOpeningHour']['saturday_from']:'9:00am'; ?>
                        <?php echo $this->Form->input('saturday_from',array('value'=>$saturday_from,'label'=>false,'div'=>false,'disabled'=>$disabledSat,'class'=>'form-control timeStart timePKr')); ?>
                    </section>
                    <section class="col-sm-1 col-xs-1 setmargn">-</section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $saturday_to = (isset($this->data['SalonOpeningHour']['saturday_to']) && $this->data['SalonOpeningHour']['saturday_to'])?$this->data['SalonOpeningHour']['saturday_to']:'6:00pm'; ?>
                        <?php echo $this->Form->input('saturday_to',array('value'=>$saturday_to,'label'=>false,'div'=>false,'disabled'=>$disabledSat,'class'=>'form-control timeEnd timePKr')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 text-center"><i class="fa fa-angle-down fa-3"></i></section>
                </section>
            </li>
            <li class=" <?php echo ($checkedSun)?'on':'off';?>">
                <section class="col-sm-12 nopadding">
                    <section class="col-sm-1 col-xs-1 setmargn">
                    <?php echo $this->Form->input('is_checked_disable_sun',array('checked'=>$checkedSun,'id'=>'Sun','type'=>'checkbox','label'=>array('text'=>'&nbsp;','class'=>'new-chk'),'div'=>false,'class'=>'checkday')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 setmargn">Sunday</section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $sunday_from = (isset($this->data['SalonOpeningHour']['sunday_from']) && $this->data['SalonOpeningHour']['sunday_from'])?$this->data['SalonOpeningHour']['sunday_from']:'9:00am'; ?>
                        <?php echo $this->Form->input('sunday_from',array('value'=>$sunday_from,'label'=>false,'div'=>false,'disabled'=>$disabledSun,'class'=>'form-control timeStart timePKr')); ?>
                    </section>
                    <section class="col-sm-1 col-xs-1 setmargn">-</section>
                    <section class="col-sm-2 col-xs-2 nopadding">
                        <?php $sunday_to = (isset($this->data['SalonOpeningHour']['sunday_to']) && $this->data['SalonOpeningHour']['sunday_to'])?$this->data['SalonOpeningHour']['sunday_to']:'6:00pm'; ?>
                        <?php echo $this->Form->input('sunday_to',array('value'=>$sunday_to,'label'=>false,'div'=>false,'disabled'=>$disabledSun,'class'=>'form-control timeEnd timePKr')); ?>
                    </section>
                    <section class="col-sm-3 col-xs-3 text-center"><i class="fa fa-angle-down fa-3"></i></section>
                </section>
            </li>
        </ul>
    </div>
    </div>
</div>
          </div>
        </div>
    </div>
</div>