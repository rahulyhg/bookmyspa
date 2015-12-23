<div class="row-fluid">
    <div class="col-sm-12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                 <i class="icon-edit"></i>
                  <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Product</h3>
            </div> 
            <div class="box-content">
            <?php echo $this->Form->create('Product',array('novalidate' , 'class'=>'form-horizontal','type'=>'file'));?>
             <div class="row-fluid col-sm-10">
                <div class="form-group">
                    <label class="col-sm-3">Barcode or Other ID *:</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('barcode',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'25','required','validationMessage'=>"Barcode is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlength-msg'=>"Maximum 25 characters.")); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class=" col-sm-3">Brand *:</label>
                    <div class="col-sm-5">
                        <div class="col-sm-7 list nopadding">
                            <?php echo $this->Form->input('brand_id',  array('name'=>'data[Product][brand_id]','label'=>false,'div'=>false,'options' =>$brands,'class'=>'form-control','default' =>@$product['Product']['brand_id'],'onChange'=>'product_list(this)','empty'=>'Please select','required','validationMessage'=>"Please select Brand Name."));  ?>
                        </div>
                        <div class="col-sm-5">
                            <?php echo $this->Html->link('<i class="icon-plus"></i> Add Brand','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'add_brand btn btn-primary')); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">Product Type *:</label>
                    <div class="col-sm-5">
                        <div class="products">
                            <?php if(isset($product['Product']['product_type_id'])){  ?>
                                    <script>
                                        $(document).ready(function(){
                                            product_list('#ProductBrandId' ,'<?php echo $product['Product']['product_type_id']; ?>'); });
                                    </script>  
                            <?php }  ?>
                            <?php  echo $this->Form->input('product_type_id',array('type'=>'select','label'=>false,'div'=>false,'class'=>'form-control','empty'=>'Please Select','required','validationMessage'=>"Please select Product Type.")); ?>
                        </div>
                    </div>
                </div>                               
                
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab3" data-toggle="tab">English</a></li>
                    <li><a href="#tab4" data-toggle="tab">Arabic</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab3">
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="col-sm-3">English Product Name *:</label>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('eng_product_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'3','maxlength'=>'60','maxlengthcustom'=>'55','required','pattern'=>'^[A-Za-z ]+$','validationMessage'=>"Product Name is Required.",'data-minlength-msg'=>"Minimum 3 characters.",'data-maxlengthcustom-msg'=>"Maximum 55 characters.",'data-pattern-msg'=>"Please enter only alphabets.")); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">English Description :</label>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('eng_description',array('label'=>false,'div'=>false,'class'=>'form-control','rows'=>'3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4">
                        <div class="form-group"></div>
                        <div class="form-group">
                            <label class="col-sm-3">Arabic Product Name *:</label>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('ara_product_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                            </div>
                        </div>                                           
                        <div class="form-group">
                            <label class="col-sm-3">Arabic Description :</label>
                            <div class="col-sm-5">
                                <?php echo $this->Form->input('ara_description',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>
                            </div>
                        </div>                                           
                    </div>
                </div>    
                <div class="form-group">
                    <label class="col-sm-3">Purchase Date *:</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('purchase_date',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control datepicker','required','validationMessage'=>"Purchase Date is Required.")); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">Vendor *:</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('vendor',  array('class'=>'form-control','label'=>false,'div'=>false,'options' =>$vendors,'empty' => 'Please Select','required','validationMessage'=>"Please select Vendor.")); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Cost for Business*:</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('cost_business',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>"Cost for business is Required.",'pattern'=>'^[0-9]+(\\.[0-9]+)?$','data-pattern-msg'=>"Enter correct Cost for Business.")); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Selling Price *:</label>
                    <div class="col-sm-5">
                               <?php echo $this->Form->input('selling_price',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>"Selling price is Required.",'pattern'=>'^[0-9]+(\\.[0-9]+)?$','data-pattern-msg'=>"Enter correct Selling Price.")); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Quantity *:</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('quantity',array('type'=>'text','label'=>false,'div'=>false,'maxlength'=>'6','class'=>'form-control','required','validationMessage'=>"Quantity is Required.",'pattern'=>'^[0-9]*$','data-pattern-msg'=>"Enter correct Quantity.")); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">Storage Location:</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('storage_location',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>255)); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Display Location:</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('display_location',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control')); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Low Quantity Warning:</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('low_quantity_warning',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>4,'pattern'=>'^[0-9]*$','data-pattern-msg'=>"Enter only numeric value.")); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Points Given :</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('points_given',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>4,'pattern'=>'^[0-9]*$','data-pattern-msg'=>"Enter only numeric value.")); ?> 
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Points Redeem :</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('points_Redeem',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','maxlength'=>4,'pattern'=>'^[0-9]*$','data-pattern-msg'=>"Enter only numeric value.")); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Taxation :</label>
                    <div class="col-sm-5">
                        <?php $tax = array();
                        if(@$taxes['TaxCheckout']){
                            foreach($taxes['TaxCheckout'] as $k=>$v){
                                if($v==''){ $tax[$k] = ucfirst(chunk_split($k, 3, ' ')).'(0.000 %)';}
                                else{ $tax[$k] = ucfirst(chunk_split($k, 3, ' ')).'('.$v. ' %)'; }
                            }
                        }
                        echo $this->Form->input('tax',  array('class'=>'form-control','label'=>false,'div'=>false,'options' =>$tax,'selected' => '','empty'=>'No Tax' ,'selected'=>(@$product['Product']['tax'])?$product['Product']['tax']:'')); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Deductions :</label>
                    <div class="col-sm-5">
                        <?php
                        $deduction = array();
                        if(@$deductions['TaxCheckout']){
                            foreach($deductions['TaxCheckout'] as $k=>$v){
                            if($v==''){ $deduction[$k] = ucfirst(chunk_split($k, 9, ' ')).'(0.000 %)'; }
                            else{ $deduction[$k] = ucfirst(chunk_split($k, 9, ' ')).'('.$v. ' %)'; }
                            }
                        }
                        echo $this->Form->input('deduction',  array('class'=>'form-control','label'=>false,'div'=>false,'options' =>$deduction,'selected' => '','empty'=>'No Deduction' ,'selected'=>(@$product['Product']['deduction'])?$product['Product']['deduction']:'')); ?> 
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">For Business Use Only :</label>
                    <div class="col-sm-5">
                        <?php echo $this->Form->input('business_use', array('div' => false, 'type' => 'checkbox', 'class' => 'tagchec', 'label' => array('class' => 'new-chk', 'text' => '(Product Not Displayed at Checkout, Not Sold to Customers)'), 'after' => '')); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-3">Images :</label>
                        <div class="col-sm-9 forProdImg">
                        <?php
                        $uid = $this->Session->read('Auth.User.id');
                        if(count(@$product['ProductImage'])){
                            foreach($product['ProductImage'] as $theImgno => $image){  ?>
                                <div class="col-sm-3 nopadding haveImage">
                                    <div class="addProdImg">
                                    <input type="file" name="data[Product][image][]" onchange="readURL(this)" style="display:none;" "required"=false>
                                    <div class="all-sec">
                                        <div class="outer-imageLeftSec">
                                            <div class="imageLeftSec">
                                                <?php  echo $this->Html->image('/images/'.$uid.'/ProductImage/150/'.$image['image'] , array()); ?>
                                            </div>
                                        </div>
                                        <span class="editing">
                                            <a class="editProImg" href="javascript:void(0);"><i class="fa fa-pencil"></i></a>
                                            <a onclick="del_img_server('<?php echo $image['image']; ?>','<?php echo $image['id']; ?>',this);" href="javascript:void(0);"><i class="fa  fa-trash-o"></i></a>
                                        </span>
                                        <!--<a href="javascript:void(0);">
                                            <span class="added-img caption-box"><input type="radio" value="1" name="data[Product][default][]" id="new<?php echo $theImgno; ?>">
                                            <label class="new-chk" for="new<?php echo $theImgno; ?>"> Set as default</label></span>
                                        </a>-->
                                    </div>
                                    </div>
                                </div>
                        <?php    }
                            } ?>      
                                                                
                    <!--<div class="col-sm-3 addProdImg text-center">
                        <?php //echo $this->Form->input('image.',array('type'=>'file','label'=>false,'div'=>false,'class'=>'input-fluid hide_file','onChange'=>'readURL(this)','style'=>'display:none;')); ?>
                        <div class="all-sec">
                            <a class="single-picture" href="javascript:void(0);">
                                <span style=""><i class="fa fa-plus"></i></span>
                                <span style="">Add Photo</span>
                                <span class="caption-box">1 of 4</span>
                            </a>
                        </div>    
                    </div>-->

                                                        
                            </div>
                    </div>
                                                                                   
                    <div class="form-group">
                          <label class="col-sm-3">&nbsp;</label>
                          <div class="col-sm-5">
                                <?php echo $this->Form->button('Save',array('type'=>'submit','class'=>'btn btn-primary','label'=>false,'div'=>false));?>
                                <?php //echo $this->Form->button('Cancel',array('data-dismiss'=>'modal','type'=>'button','label'=>false,'div'=>false,'class'=>'btn closeModal'));?>
                          </div>
                    </div>                                                           
                <?php echo $this->Form->end(); ?>
            </div>
        </div>   
       </div>
    </div>
</div>

<script>
    $(document).ready(function(){
       // $('.datepicker').datepicker({format: 'yyyy-mm-dd'});
         $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            onClose: function(dateText, inst) {
                  $('#ProductPurchaseDate').blur();
            }               
      });
        
        //$(".datepicker").kendoDatePicker({format: "yyyy-MM-dd",max: new Date($.now()) });
        var prodValidator = $("#ProductAdminAddProductForm").kendoValidator({
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
        errorTemplate: "<dfn class='text-danger'>#=message#</dfn>"}).data("kendoValidator");
        
        var $modal = $('#commonSmallModal');
        var $modal1 = $('#commonContainerModal');
        var itsId  = "";
        $(document).on('click','.add_brand' ,function(){
            var itsId = $(this).attr('data-id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Products','action'=>'add_brand','admin'=>true)); ?>";
            addeditURL = addeditURL+'/'+itsId
            // function in modal_common.js
            fetchModal($modal1,addeditURL,"BrandAdminAddBrandForm");
        });
   
        $modal1.on('click', '.update', function(e){
            var options = { 
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($modal1,'Brand',res)){
                        fetch_brand_list();   
                    }
                }
            }; 
            $('#BrandAdminAddBrandForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
        
        $("#ProductPurchaseDate").keypress(function (e){
            e.preventDefault();
      });
        $(document).on('click','.single-picture , .editProImg',function(){
            var theObj = $(this);
            theObj.closest('div.addProdImg').find('input').click();
        });
        check_limit();
    });
       
    function fetch_brand_list(){
        $(".list").load("<?php echo $this->Html->url(array('controller'=>'products','action'=>'brand_list')); ?>")
    }
     id=''; 
     function product_list(ref ,id){
             $uri = "<?php echo $this->Html->url(array('controller'=>'products','action'=>'brand_products','admin'=>true)); ?>"
             $uri = $uri+'/'+$(ref).val()+'/'+id;
             $(".products").load($uri);
     }
  /* function to show image before upload */
  function readURL(input){
        if (input.files && input.files[0]) {
            var imgCheck = validate_image(input.files[0]);
            if(!imgCheck){
                var reader = new FileReader();
                reader.onload = function (e){
                    var len = $(document).find('div.forProdImg').find('div.nopadding.haveImage').length;
                    var forId = parseInt(len)+1;
                    var theDiv = $(input).closest('div.nopadding');
                    theDiv.removeClass('noImageYet').addClass('haveImage');
                    theDiv.find('div.all-sec').html('<div class="outer-imageLeftSec"><div class="imageLeftSec"><img alt="" class="" src="'+e.target.result+'" ></div></div><span class="editing"><a href="javascript:void(0);" class="editProImg"><i class="fa fa-pencil"></i></a><a href="javascript:void(0);" onclick="del_img(this);"><i class="fa  fa-trash-o"></i></a></span><!--<a href="javascript:void(0);"><span class="added-img caption-box"><input id="new'+forId+'" name="data[Product][default][]" type="radio" value="'+forId+'"><label for="new'+forId+'" class="new-chk"> Set as default</label></span></a>-->');
                    check_limit(); 
                }
                reader.readAsDataURL(input.files[0]);
            }
            else{
                alert(imgCheck);
                return false;
            }
        }
         
         
    }
    
    function del_img(cnt){
        if(confirm('Are you sure you want to delete this image ?')){
            $(cnt).closest('div.haveImage').remove();
            check_limit();
        }
    }
   
   function del_img_server(image,id,ref){
        if(confirm('Are you sure you want to delete this image ?')){
            $.ajax({
                data:{image:image, id:id},
                url:'<?php echo $this->Html->url(array('controllers'=>'Products' , 'action'=>'delete_image', 'admin'=>true)); ?>',
                type:'post',
                success:function(response){
                    if(response){
                        $(ref).closest('div.haveImage').remove();
                        check_limit();
                    }else{
                        'Error While deleting the image!';
                    }
                }
            });
        }
   }
    function check_limit(){
        $(document).find('div.forProdImg').find('div.noImageYet').remove();
        var len = $(document).find('div.forProdImg').find('div.haveImage').length;
        if(len < 4 ){
        $(document).find('div.forProdImg').append('<div class="col-sm-3 nopadding noImageYet"><div class="addProdImg text-center"><input type="file" "required"="false"  style="display:none;" onchange="readURL(this)" name="data[Product][image][]"><div class="all-sec"><a href="javascript:void(0);" class="single-picture"><span style=""><i class="fa fa-plus"></i></span><span style="">Add Photo</span><span class="caption-box">'+(parseInt(len)+1)+' of 4</span></a></div></div></div>');
        }
    }
  </script>
