<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-eye-open"></i>
    Brand <?php echo (!empty($brand))?'- '.ucfirst($brand['Brand']['eng_name']):'';?></h3>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-content">
                    <h3>Product Type</h3>
                    <ul>
                    <?php
                    if(!empty($brand['BrandtoProductType'])){
                        foreach($brand['BrandtoProductType'] as $prodType){
                            echo '<ol class="col-sm-12">'.$prodType['ProductType']['eng_name'].'</ol>';
                        }
                    }else{
                        echo '<li class="col-sm-12">No product type selected</li>';
                    }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
