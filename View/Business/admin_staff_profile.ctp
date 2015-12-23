<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    }
h2
{    
    border-bottom: 1px solid #CBCBCB;
    font-size: 20px;
    font-weight: bold;
    margin: 0 0 10px;
    padding: 10px 0;
    text-transform: uppercase;
    color: #8CBF26;
}
.profile > li:after {
    clear: both;
    content: ".";
    display: block;
    font-size: 0;
    line-height: 0;
    visibility: hidden;
}
.profile, .cover.customer-sec .description .customer-info {
    margin: 0;
    padding: 0;
}
.profile > li, .cover.customer-sec .description .customer-info > li {
    display: block;
    margin: 0 10px 0 0;
}
.profile > li > section, .cover.customer-sec .description .customer-info > li > section {
    color: #666666;
    float: right;
    font-size: 14px;
    width: 75%;
}
.profile > li > label, .cover.customer-sec .description .customer-info > li > label {
    color: #333333;
    float: left;
    font-size: 14px;
    width: 25%;
}
</style> 
<div class="modal-dialog vendor-setting sm-vendor-setting">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel"><i class="icon-edit"></i>
             <?php echo ($user['User']['type']==5)?'Employee':'User'; ?> Info!
            </h3> 
        </div>
        <div class="modal-body">
          <div class="col-sm-12">
              <h2>
                    <?php echo ($user['User']['type']==5)?'Employee':'User'; ?> Info
                </h2>
                <ul class="profile">
                    <li>
                            <label>Username</label>
                            <section><?php echo $user['User']['username'];?></section>
                    </li>
                    <li>
                            <label>First Name</label>
                            <section><?php echo ucfirst($user['User']['first_name']);?></section>
                    </li>
                    <li>
                            <label>Last Name</label>
                            <section><?php echo ucfirst($user['User']['last_name']);?></section>
                    </li>
                    <li>
                            <label>Email</label>
                            <section><?php echo $user['User']['email'];?></section>
                    </li>
                    <li>
                            <label>Address</label>
                            <section>
                                 <?php echo $user['Address']['address'];?><br>
                                <?php echo ucfirst($user['Address']['area']);?>
                            </section>
                    </li>
                    <li>
                            <label>Birthdate</label>
                            <section>
                                <?php
                                    if($user['UserDetail']['dob']){
                                            echo $user['UserDetail']['dob'];
                                    }else{
                                            echo '-';
                                    }
                                ?>
                            </section>
                    </li>
                    <li>
                            <label>Mobile 1</label>
                            <section>
                                <?php
                                    if($user['Contact']['cell_phone']){
                                            echo $user['Contact']['cell_phone'];
                                    }else{
                                            echo '-';
                                    }
                                ?>
                            </section>
                    </li>
                    <li>
                            <label>Mobile 2</label>
                            <section>
                                <?php
                                    if($user['Contact']['day_phone']){
                                            echo $user['Contact']['day_phone'];
                                    }else{
                                            echo '-';
                                    }
                                ?>
                            </section>
                    </li>
                    <li>
                            <label>Mobile 3</label>
                            <section>
                               <?php
                                    if($user['Contact']['night_phone']){
                                            echo $user['Contact']['night_phone'];
                                    }else{
                                            echo '-';
                                    }
                                ?>
                            </section>
                    </li>
                </ul>                
            </div>
        <div class="modal-footer">
          <div class="text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        </div>
    </div> 
</div>

