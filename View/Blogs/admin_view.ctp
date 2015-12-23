<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    } 
</style> 
<div class="modal-dialog vendor-setting addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                View Blog </h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#eng" data-toggle="tab">English</a></li>
                    <li><a href="#arb" data-toggle="tab">Arabic</a></li>
                    </ul>
                    
                <div class="tab-content">
                    <div class="tab-pane active" id="eng">
                        <div class="clearfix"></div>
                         <div class="form-group clearfix" style="margin-top: 10px;">
                            <label class="control-label col-sm-2" >English Title :</label>
                            <div class="col-sm-10">
                                <?php echo $blog['Blog']['eng_title']; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" >English Description :</label>
                            <div class="col-sm-10">
                                <?php echo $blog['Blog']['eng_description']; ?>
                            </div>
                        </div>
                      </div>
                   
                    <div class="tab-pane" id="arb">
                         <div class="form-group clearfix" style="margin-top: 10px;">
                            <label class="control-label col-sm-2">Arabic Title :</label>
                            <div class="col-sm-10">
                                <?php echo $blog['Blog']['ara_title']; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" >Arabic Description :</label>
                            <div class="col-sm-10">
                                <?php echo $blog['Blog']['ara_description']; ?>
                            </div>
                        </div>
                    </div>    
                     </div>
           <?php
            if (!empty($blog['Blog']['image'])) {
           ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="input01">Image : </label>
                <div class="col-sm-10">
                    <div class="preview">
                        <?php
                        $uid = $this->Session->read('Auth.User.id');
                            echo $this->Html->Image('../images/' . $uid . '/Blog/350/' . $blog['Blog']['image']);
                        ?> 
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
            </div>
    </div>   
        
</div>    
</div>