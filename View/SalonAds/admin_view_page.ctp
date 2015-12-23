<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel"><i class="icon-eye-open"></i>
    View CMS Pages</h3>
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
                            <dt>Title</dt>
                            <dd><?php echo $page['StaticPage']['eng_title']; ?></dd>
                            <dt>Name</dt>
                            <dd><?php echo $page['StaticPage']['eng_name']; ?></dd>
                            <dt>Description</dt>
                            <dd><?php echo $page['StaticPage']['eng_description']; ?></dd>
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
                            <dt>Title</dt>
                            <dd><?php echo $page['StaticPage']['ara_title']; ?></dd>
                            <dt>Name</dt>
                            <dd><?php echo $page['StaticPage']['ara_name']; ?></dd>
                            <dt>Description</dt>
                            <dd><?php echo $page['StaticPage']['ara_description']; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
