<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <?php echo $this->Form->create('Brand',array('novalidate','class'=>'form-horizontal'));?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
            <?php echo (isset($this->data) && !empty($this->data))?'Edit':"Add"; ?> Brand</h3>
        </div>
        <div class="modal-body">
            <div class="row">
            <div class="col-sm-12">
            <div class="box">
                <div class="box-content">
                
                    <ul id='myTab' class="nav nav-tabs col-sm-12">
                        <li class="active"><a href="#tab1" data-toggle="tab">English</a></li>
                        <li><a href="#tab2" data-toggle="tab">Arabic</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="form-group">
                            </div> 
                             <div class="form-group">
                                    <label class="control-label col-sm-3">	    
                                        English Name *:
                                    </label>
                                    <div class="col-sm-5">
                                    <?php                                               
                                         echo $this->Form->input('eng_name',array('label'=>false,'div'=>false,'class'=>'form-control','minlength'=>'2','maxlength'=>'101','required','validationMessage'=>"Brand Name is Required.",'data-minlength-msg'=>"Minimum 2 characters.",'data-maxlength-msg'=>"Maximum 100 characters.","required",'validationMessage'=>"Brand Name is Required.",'data-minlength-msg'=>"Minimum 2 characters.",'maxlengthcustom'=>'100','data-maxlengthcustom-msg'=>"Maximum 100 characters.")); 
                                    ?>                                    
                                    </div>
                                </div>                                                                                                                    
                        </div>
                        <div class="tab-pane" id="tab2">     
                            <div class="form-group"></div> 
                            <div class="form-group">
                                    <label class="control-label col-sm-3">	    
                                        Arabic Name:
                                    </label>
                                    <div class="col-sm-5">
                                        <?php echo $this->Form->input('ara_name',array('label'=>false,'div'=>false,'class'=>'form-control')); ?>                                   
                                    </div>
                                </div>                               
                        </div>
                    </div>

                     <div class="form-group">
                                    <label class="control-label col-sm-3">	    
                                        Status*:
                                    </label>
                                    <div class="col-sm-5">
                                        <?php echo $this->Form->input('status',array('options'=>array('1'=>'Active','0'=>'InActive'),'empty'=>' -- Please Select  -- ','label'=>false,'div'=>false,'class'=>'form-control','required','validationMessage'=>"Please select status.")); ?>
                                    </div>
                                </div> 
                     <div class="form-group">
                        <label class="control-label col-sm-12">	    
                            <h3>Product Types*:</h3>
                        </label>
                        <?php //echo $this->Form->input('BrandtoProductVal.product_type',array('label'=>false,'div'=>false,'class'=>'form-control','type'=>'hidden')); ?>  
                        <div class="col-sm-12">
                            
                                    <?php
                                        $i=0;
                                        foreach($productTypes as $key=>$productType){
                                           if(in_array($key,$getProductType)){
                                              $selected = true;
                                           }else{
                                               $selected = false;
                                           }
                                           echo "<div class='col-sm-6'>";
                                                   echo $this->Form->input('BrandtoProductType.'.$i.'.product_type_id', array('type' => 'checkbox','value'=>$key,'div'=>false,'hiddenField'=>false,'label'=>array('class'=>'new-chk','text'=>$productType),'checked'=>$selected));
                                            echo "</div>";
                                            $i++;

                                        }                                 
                                        ?>
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
