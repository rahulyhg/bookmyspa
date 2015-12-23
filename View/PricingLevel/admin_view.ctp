<div class="modal-dialog vendor-setting addUserModal">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-eye-open"></i>
    View Pricing Level</h3>
</div>
<div class="modal-body">
    <div class="box">
        <div class="row-fluid">
            <div class="span6">
                <div class="box">
                    <div class="box-title" style="margin-top:0;">
                            <h3>
                                <i class="icon-th-large"></i>
                                English
                            </h3>
                    </div>
                    <div class="box-content">
                         <dl>
                                     <dt>Name</dt>
                                    <dd><?php echo $page['PricingLevel']['eng_name']; ?></dd>
                                    <dt>Description</dt>
                                    <dd><?php echo $page['PricingLevel']['eng_description']; ?></dd>
                                </dl>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="box">
                    <div class="box-title" style="margin-top:0;">
                            <h3>
                                <i class="icon-th-large"></i>
                                Arabic
                            </h3>
                    </div>
                    <div class="box-content">
                            <dl>
                                     <dt>Name</dt>
                                    <dd><?php echo $page['PricingLevel']['ara_name']; ?></dd>
                                    <dt>Description</dt>
                                    <dd><?php echo $page['PricingLevel']['ara_description']; ?></dd>
                                </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>