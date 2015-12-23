<style>
    .redtext{font: 12px;color:#A94442}
</style>
<div class="modal-dialog vendor-setting sm-wizard-info">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Payment</h3>
        </div>	
        <div class="modal-body clearfix">	
            <div class="box-content">
                <?php echo $this->Form->create('PaymentReportPaid', array('novalidate', 'class' => 'form-horizontal','id'=>'paymentCycleForm','type'=>'file')); ?> 
                <?php echo $this->Form->hidden('PaymentReportPaid.id', array('label' => false, 'div' => false)); ?>
                <?php echo $this->Form->hidden('PaymentReportPaid.salon_id', array('label' => false, 'div' => false,'value'=>$get_details['PaymentReport']['salon_id'])); ?>
                <?php echo $this->Form->hidden('PaymentReportPaid.payment_report_id', array('label' => false, 'div' => false,'value'=>$get_details['PaymentReport']['id'])); ?>
                <div class="col-sm-12">
                    <?php
                        if(isset($get_details) && !empty($get_details)){
                    ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <strong>Transactions Included : </strong> 
                                <?php if(!empty($get_details['PaymentReport']['from_date'])){ echo "From ".date("jS  F Y" , strtotime($get_details['PaymentReport']['from_date'])); }?> 
                                <?php if(!empty($get_details['PaymentReport']['to_date'])){ echo " To ".date("jS  F Y" , strtotime($get_details['PaymentReport']['to_date'])); }?>
                            </div>	       
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <strong>Credit card Commission (AED) : </strong> 
                                <?php echo $get_details['PaymentReport']['credit_card_commission'];?>
                            </div>	       
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <strong>Sieasta commission (AED) :  </strong> 
                                <?php echo $get_details['PaymentReport']['sieasta_commission'];?> 
                            </div>	       
                        </div>  
                    <div class="form-group">
                            <div class="col-sm-12">
                                <strong> Opening Amount (AED) :  </strong> 
                                <?php echo $get_details['PaymentReport']['opening_balance'];?>
                            </div>	       
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <strong> Amount Due (AED) :  </strong> 
                                <?php 
                                if($get_details['PaymentReport']['opening_balance']>0){
                                    $showOpening=" + ".$get_details['PaymentReport']['opening_balance'];
                                }else{
                                    $showOpening='';
                                }
                                echo $get_details['PaymentReport']['amount_due'].$showOpening;?> 
                            </div>	       
                        </div>
                    <div class="form-group">
                            <div class="col-sm-12">
                                <strong> Closing Amount (AED) :  </strong> 
                                <span id="closingAmt"><?php echo $get_details['PaymentReport']['closing_balance'];?> </span>
                            </div>	       
                        </div>
                    <?php
                        }
                    ?>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label><?php echo __('Amount ', true); ?></label>
                            <?php
                                $maxvalue = '';
                                if(isset($get_details['PaymentReport']['closing_balance']) && !empty($get_details['PaymentReport']['amount_due'])){
                                    $maxvalue = $get_details['PaymentReport']['closing_balance'];
                                }else{
                                    $maxvalue = 10;
                                }
                                //echo $this->Form->input('PaymentReportPaid.paid_amount', array('class' => 'required form-control inputAmount', 'label' => false, 'required', 'validationMessage'=>'Amount is required.','min'=>'1','max'=>$maxvalue,'required data-max-msg'=>'Enter value between 1 and 10'));
                                echo $this->Form->input('PaymentReportPaid.paid_amount', array('class' => 'required form-control', 'label' => false, 'required', 'validationMessage'=>'Amount is required.','value'=>$maxvalue,'type'=>'text'));
                            ?>    
                            <div id="paymentAmt" class="redtext"></div>
                        </div>	       
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label><?php echo __('Image File', true); ?></label>
                            <?php echo $this->Form->input('PaymentReportPaid.proff_file', array('type' => 'file', 'class' => 'form-control', 'label' => false, 'validationMessage'=>'File is required.','onchange'=>'validate_fileupload("image",this,this.id)')); ?> 
                             <div id="proffile" class="redtext"></div>
                        </div>                                 			  
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label><?php echo __('Comment', true); ?></label>
                            <?php echo $this->Form->input('PaymentReportPaid.comments', array('type' => 'textarea', 'class' => 'form-control', 'label' => false,'validationMessage'=>'Comment is required.','maxlength'=>200)); ?> 
                        </div>                                 			  
                    </div>	

                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php echo $this->Form->button('Pay',array('type'=>'submit','class'=>'btn btn-primary','id'=>'login'));?>
                        </div>
                    </div>

                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>   
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".inputAmount").kendoNumericTextBox();
        /*$('.inputAmount').keyup(function(){
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
        });*/

     /*var prodValidator = $("#paymentCycleForm").kendoValidator({
            rules:{
                minlength: function (input) {
                return minLegthValidation(input);
            },
            maxlength: function (input) {
                return maxLegthValidation(input);
            },
            pattern: function (input) {
                return patternValidation(input);
            }
        },
        errorTemplate: "<dfn class='red-txt'>#=message#</dfn>"}).data("kendoValidator"); 
        */
        
        $(document).find('#paymentCycleForm').on('submit', function(){
            if(checkValidation()){
                 return true;  
            }else{
              return false;  
            }
            
            
        });
        function checkValidation(){
           var flag=true;
            var amt=$("#PaymentReportPaidPaidAmount").val();
            var image=$("#PaymentReportPaidProffFile").val();
            var comments=$("#PaymentReportPaidComments").val();
            var closingAmt=$("#closingAmt").text();
            if(amt==''){
                $("#PaymentReportPaidPaidAmount").css({"border":"1px solid #A94442"});
                //$("#PaymentReportPaidPaidAmount").append("<dfn class='red-txt'>Amount is required.</dfn>");
                $("#paymentAmt").text("Amount is required.");
                var flag=false;
		return false;
            }
            else if(parseInt(amt) > parseInt(closingAmt)){
                $("#PaymentReportPaidPaidAmount").css({"border":"1px solid #A94442"});
                $("#paymentAmt").text("Amount should not exceed closing amount.");
                var flag=false;
		return false;
            }else{
                var flag=true;
                $("#PaymentReportPaidPaidAmount").css({"border":"1px solid #CCCCCC"});
                $("#paymentAmt").text("");
            }
            if(image != '' || comments!=''){
                var flag=true;
                 $("#PaymentReportPaidProffFile").css({"border":"1px solid #CCCCCC"});
                 $("#proffile").text("");
            }else{
                $("#PaymentReportPaidProffFile").css({"border":"1px solid #A94442"});
                //$("#PaymentReportPaidProffFile").append("<dfn class='red-txt'>Image file or comments is required.</dfn>");
                $("#proffile").text("Image file or comments is required.");
                var flag=false;
                return false;
            }
            if(flag){
                return true;
            }
        }
        $('#PaymentReportPaidPaidAmount').keyup(function(){
            if($(this).val().indexOf('.')!=-1){         
                if($(this).val().split(".")[1].length > 2){                
                    if( isNaN( parseFloat( this.value ) ) ) return;
                    this.value = parseFloat(this.value).toFixed(2);
                }  
            }            
            return this; 
         });
         
    });
    function validate_fileupload(file_type,fld,id) {
        var file=fld.value;
        var picRegex=/^.*\.(jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF)$/i;
        if(file_type=='image'){
            defineFileSize='100000';
        }
        if(file_type=='image'){
            if(!picRegex.test(fld.value)) {
                $("#PaymentReportPaidProffFile").css({"border":"1px solid #A94442"});
                $("#proffile").text("Please upload jpg, jpeg, png and gif file format file only.");
                $("#"+id).val('');
                $("#"+id).focus();        
                return false;
            }
        }
        if(file){
            var size = fld.files[0].size;
            if(size > defineFileSize)
            {
                if(file_type=='image'){
                    $("#PaymentReportPaidProffFile").css({"border":"1px solid #A94442"});
                    $("#proffile").text("Please upload file less than 100 KB.");
                }
                $("#"+id).val('');
                $("#"+id).focus(); 
                return false;
            }else{
                 $("#PaymentReportPaidProffFile").css({"border":"1px solid #CCCCC"});
                 $("#proffile").text("");
                return true;
            }
        }else{
                $("#PaymentReportPaidProffFile").css({"border":"1px solid #CCCCC"});
                $("#proffile").text("Invalid File.");
        }
        return true;
} 
</script>