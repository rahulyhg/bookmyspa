<div class="modal-dialog vendor-setting sm-vendor-setting">
<div class="modal-content">   
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel" class=""><i class="icon-eye-open"></i>
    View Business Type</h3>
</div>
<div class="modal-body">
    <div class="box">
        <div class="row">
            <div class="col-sm-6">
                <div class="box">
                    <div class="box-title" style="margin-top:0;">
                            <h3 class="">
                                <i class="icon-th-large"></i>
                                English
                            </h3>
                    </div>
                    <div class="box-content">
                        <dl>
                            <dt>Name</dt>
                            <dd><?php echo $btype['BusinessType']['eng_name']; ?></dd>
                            <dt>Description</dt>
                            <dd><?php echo $btype['BusinessType']['eng_description']; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box">
                    <div class="box-title" style="margin-top:0;">
                            <h3 class="">
                                <i class="icon-th-large"></i>
                                Arabic
                            </h3>
                    </div>
                    <div class="box-content">
                        <dl>
                            <dt>Name</dt>
                            <dd><?php echo $btype['BusinessType']['ara_name']; ?></dd>
                            <dt>Description</dt>
                            <dd><?php echo $btype['BusinessType']['ara_description']; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>