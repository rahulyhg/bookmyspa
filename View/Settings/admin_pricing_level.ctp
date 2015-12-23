<div class="box row-fluid">
    <div class="box-content ">
        <div class="col-sm-6 nopadding">
            <div class="box">
                <div class="box-title">
                    <h3>
                        <i class="icon-reorder"></i>
                            <span>Pricing Options </span>
                    </h3>
                </div>
            
                <div class="box-content thepricelvltbl">
                    <?php
                        echo $this->element('admin/Settings/pricing_options');
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-title">
                    <h3>
                        <i class="icon-edit"></i>
                            <span>Add/Edit Pricing Options </span>
                    </h3>
                </div>
            
                <div class="box-content thepricelvledit">
                    <?php
                        echo $this->element('admin/Settings/addedit_priceopts');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var list = [2];
        $(document).on('click', '.submitpricingOpt', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($(document),'PricingLevel',res)){
                        var plvlList = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'pricing_level','admin'=>true)); ?>';
                        $(".thepricelvltbl").load(plvlList, function() {
                            datetableReInt($(document).find('.thepricelvltbl').find('table'),list);
                        });
                        var plvlempty = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'pricing_level','admin'=>true)); ?>'+'/0/empty';
                        $(".thepricelvledit").load(plvlempty, function() {});
                    }
                    onResponseBoby(res);
                   
                }
            }; 
            $('#pricingLevelForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        $(document).on('click','.addedit_prclvl',function(){
            var theedit = $(this);
            var lvlId = theedit.attr('data-id');
            var plvledit = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'pricing_level','admin'=>true)); ?>'+'/'+lvlId+'/edit';
            $(".thepricelvledit").load(plvledit, function() {
                
            });
        });
        
        $(document).on('click','.delete_prclvl',function(){
            var theedit = $(this);
            var lvlId = theedit.closest('tr').attr('data-id');
            var plvledit = '<?php echo $this->Html->url(array('controller'=>'Settings','action'=>'pricing_level','admin'=>true)); ?>'+'/'+lvlId+'/delete';
            $(".thepricelvltbl").load(plvledit, function() {
                datetableReInt($(document).find('.thepricelvltbl').find('table'),list);
            });
        });
        
        
        datetableReInt($(document).find('.thepricelvltbl').find('table'),list);
        
    });
</script>