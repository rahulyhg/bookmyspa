<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    } 
</style> 
<div class="modal-dialog vendor-setting addUserModal sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
                Enquiry Detail </h3>
        </div>
        <div class="modal-body">
            <div class="box">
                <div class="box-content">
                    <div class="tab-content">
                    <div class="tab-pane active" id="eng">
                         <div class="form-group clearfix" style="margin-top: 10px;">
                            <label class="control-label col-sm-2" >Name :</label>
                            <div class="col-sm-10">
                                <?php echo $BusinessEnquiry['BusinessEnquiry']['name']; ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-2" >Nature of Business :</label>
                            <div class="col-sm-10">
                                <?php echo $BusinessEnquiry['BusinessEnquiry']['nature_of_business']; ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-2" >E-mail :</label>
                            <div class="col-sm-10">
                                <?php echo $BusinessEnquiry['BusinessEnquiry']['email']; ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-2" >Organisation :</label>
                            <div class="col-sm-10">
                                <?php echo $BusinessEnquiry['BusinessEnquiry']['company']; ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-2" >Phone :</label>
                            <div class="col-sm-10">
                                <?php echo $BusinessEnquiry['BusinessEnquiry']['contact_phone']; ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-2" >Contact Address :</label>
                            <div class="col-sm-10">
                                <?php echo $BusinessEnquiry['BusinessEnquiry']['contact_address']; ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label col-sm-2" >Query :</label>
                            <div class="col-sm-10">
                                <?php echo $BusinessEnquiry['BusinessEnquiry']['detail_query']; ?>
                            </div>
                        </div>
                      </div>
                     </div>
        </div>
            </div>
    </div>   
        
</div>    
</div>