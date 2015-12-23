<?php echo $this->Html->script('admin/userincr'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
           
            <div class="box-content">
                <?php echo $this->Form->create('TaxCheckout', array('novalidate' ,'class'=>'form-horizontal')); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="firstname" class="col-sm-4 control-label pdng-tp7">Tax1 * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <div class="col-sm-4">
                                    <?php $text = "Enter your state's sales tax on products and siesta.com will include this tax
when your customers purchase products from your business"; ?>
                                    <?php
                                    echo $this->Form->input('tax1', array(
                                        'type' => 'text',
                                        'label' => false,
                                        'div' => false,
                                        'after' => '</div><div class="col-sm-4 pdng-tp7">%   E.g. 8.75 &nbsp;&nbsp;&nbsp;' . $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false)),
                                        'class' => 'form-control inputAmount',
                                        'maxlength' => 5,
                                        'placeholder' => '0.00'));
                                    ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="col-sm-4 control-label pdng-tp7">Tax2 * </label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('tax2', array('type' => 'text', 'label' => false, 'div' => false, 'after' => '</div><div class="col-sm-4 pdng-tp7">%   E.g. 8.75 &nbsp;&nbsp;&nbsp;', 'class' => 'form-control inputAmount', 'maxlength' => 5, 'placeholder' => '0.00')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <span>
                                    <?php echo $this->Form->input('appointments', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'tagchec')); ?>
                                    <label class="new-chk" for="TaxCheckoutAppointments">Allow checkout of future appointments</label>
                                    <?php
                                    $text = "By checking it, it will allow to checkout of future appointments.";
                                    echo $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false));
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-12" style="margin-left:-15px">
                                <div class="col-md-8 rgt-p-non pdng-tp7">
                                    <?php echo $this->Form->input('is_expiration', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'input-small input-block-level tagchec', 'onChange' => 'check_expire()')); ?>
                                    <label class="new-chk" for="TaxCheckoutIsExpiration">Default expiration period for online gift certificates</label>
                                </div>
                                <div class="col-md-2">
                                    <?php
                                    $val = (@$taxDetail['TaxCheckout']['expiration']) ? $taxDetail['TaxCheckout']['expiration'] : 0;
                                    echo $this->Form->input('expiration', array('value' => $val, 'type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control', 'maxlength' => '3'));
                                    ?>
                                </div>
                                <div class="col-md-2 rgt-p-non pdng-tp7">
                                    Month(s)
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                    <span><?php echo $this->Form->input('show_cost_checkout', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'input-small input-block-level tagchec')); ?>
                                    <label class="new-chk" for="TaxCheckoutShowCostCheckout">Show Product Cost at Checkout</label>
<?php
$text = "By checking it, it will show product cost at Checkout";
echo $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false));
?>
                                    </span>
                              </div>
                        </div>
                        <div class="form-group">
                                <div class="col-xs-12">
                                    <span><?php echo $this->Form->input('enable_signature', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => 'tagchec', 'maxlength' => 25)); ?>
                                        <label class="new-chk" for="TaxCheckoutEnableSignature">    Enable receipt signature on screen</label>
<?php $text = "By checking it, it will enable receipt signature on screen at the time of checkout.";
echo $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false));
?>
                                    </span>
                                </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">              
                        <?php if(isset($auth_user) && $auth_user['User']['type']==1){ ?>
                            <div class="form-group">
                                <label for="firstname" class="col-sm-4 control-label pdng-tp7">Deduction1 * &nbsp;</label>
                                <div class="col-sm-4">
                                    <?php echo $this->Form->input('deduction1', array('type' => 'text', 'label' => false, 'div' => false, 'after' => '</div><div class="col-sm-4 pdng-tp7"> AED', 'class' => 'form-control inputAmount', 'maxlength' => 5, 'placeholder' => '0.00')); ?>
                                </div>
                            </div>                        
                            <div class="form-group">
                                <label for="firstname" class="col-sm-4 control-label pdng-tp7">Deduction2 * &nbsp;</label>
                                <div class="col-sm-4">
                                        <?php echo $this->Form->input('deduction2', array('type' => 'text', 'label' => false, 'div' => false, 'after' => '</div><div class="col-sm-4 pdng-tp7">%   E.g. 8.75 &nbsp;&nbsp;&nbsp;', 'class' => 'form-control inputAmount', 'maxlength' => 5, 'placeholder' => '0.00')); ?>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-3 lft-p-non">
                                    <?php echo $this->Form->input('reward_points', array('type' => 'text', 'maxlength' => '3', 'label' => false, 'div' => false, 'class' => 'form-control', 'maxlength' => 4, 'placeholder' => '0')); ?>
                                </div>
                                <div class="col-sm-9 pdng-tp7">
                                    <?php echo __('Reward points per review (for services completed)'); ?>
                                    <?php
                                    $text = "Enter the number of reward points your customers will receive when they
  post a review for your business on your vagaro.com webpage.
  Make sure to create services with redeemable points.";
                                    echo $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label><?php echo $this->Form->input('start_balance', array('type' => 'checkbox', 'label' => false, 'div' => false, 'class' => '')); ?>
                                        Require starting balance for cash drawer</label>
                                    <?php
                                    $text = "By checking it, it will maintain daily cash drawer balance which can be seen from Transaction List Report. Make sure to create services with redeemable points.";
                                    echo $this->Html->link('<i class="glyphicon-circle_info"></i>', 'javascript:void(0)', array('rel' => 'popover', 'data-trigger' => 'hover', 'data-content' => $text, 'escape' => false));
                                    ?>
                                </div>
                          </div>    
                        </div>
                        
                        
                        
                        <div class="form-group">
                            <label class="col-sm-12 control-label">English Footer Text</label>
                                <div class="col-xs-12">
                                   <?php echo $this->Form->input('eng_footer_text', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => 'English Footer Text', 'rows' => 2)); ?>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Arabic Footer Text</label>
                                <div class="col-xs-12">
                                    <?php echo $this->Form->input('ara_footer_text', array('type' => 'textarea', 'label' =>false, 'div' => false, 'class' => 'form-control', 'placeholder' => 'Arabic Footer Text', 'rows' => 2)); ?>
                                </div>
                        </div>  
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-actions text-center">
                    	<div class="col-sm-12 text-right">
                        <?php echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary update', 'label' => false, 'div' => false)); ?>
                        </div>
                    </div>
                </div>
            <?php echo $this->Form->end(); ?>
            </div>   
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.inputAmount').keyup(function(){
            var chk = $(this).val();
            if(isNaN(chk)){
                $(this).val('');
            }else{
                if ((new Number(chk)) < 0){
                    $(this).val('');
                }
            }
            if($(this).val().indexOf('.')!=-1){
                if($(this).val().split(".")[1].length > 2){
                    if( isNaN( parseFloat( this.value ) ) ) return;
                    this.value = parseFloat(this.value).toFixed(2);
                    return this;
                }
            }
        });

        setTimeout(function() {
            check_expire();
        }, 1000);
        check_expire();

        $("#TaxCheckoutExpirationn").data({'min': 0, 'max': 120, 'step': 1}).userincr();
    });
    function check_expire() {
        var chck = $('#TaxCheckoutIsExpiration').is(':checked') ? 1 : 0;
        if (chck) {
            $('#TaxCheckoutExpiration').removeAttr('disabled');
            $('.userincr-btn-inc , .userincr-btn-dec').css('visibility', 'visible');
        } else {
            $('#TaxCheckoutExpiration').attr('disabled', 'disabled');
            $('.userincr-btn-inc , .userincr-btn-dec').css('visibility', 'hidden');
        }
    }
</script>