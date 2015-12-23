<style>
.voucher-box {
    border: 1px solid #cbcbcb;
    float: left;
    margin: 80px 2% 80px 0;
    padding: 50px 30px;
    text-align: center;
    width: 32% !important;
}.voucher-box:hover{background:#f5f5f5;}
.voucher-box .infograpic-box{width:103px; height:103px; border-radius:50%; border:2px solid #5b3671; margin:0 auto;}
/*.modal-dialog.login {
    width: 55%;
}*/
.voucher-box .infograpic-box .beauty{width:100px; height:100px; background:url("../../img/admin/voucher-page-icons.png") no-repeat; background-position: 2px -97px;}
.voucher-box:hover .infograpic-box .beauty{background:url("../../img/admin/voucher-page-icons.png") no-repeat; background-position: 2px 13px;}
.voucher-box .infograpic-box .inspiration{width:100px; height:100px; background:url("../../img/admin/voucher-page-icons.png") no-repeat; background-position: 2px -198px;}
.voucher-box:hover .infograpic-box .inspiration{background:url("../../img/admin/voucher-page-icons.png") no-repeat; background-position: 2px -296px;}
.voucher-box h2 {
    color: #5b3671;
    font-size: 24px;
    margin: 25px 0;
}
.voucher-box {
    text-align: center;
}
.modal-dialog.login.marketing .voucher-box .infograpic-box .beauty{ background: url("../../img/admin/marketing-icons.png") no-repeat scroll -121px 18px rgba(0, 0, 0, 0);}
.modal-dialog.login.marketing .voucher-box:hover .infograpic-box .beauty{ background: url("../../img/admin/marketing-icons.png") no-repeat scroll -121px -118px rgba(0, 0, 0, 0);}

.modal-dialog.login.marketing .voucher-box .infograpic-box .inspiration{ background: url("../../img/admin/marketing-icons.png") no-repeat scroll 8px 19px rgba(0, 0, 0, 0);}
.modal-dialog.login.marketing .voucher-box:hover .infograpic-box .inspiration{ background: url("../../img/admin/marketing-icons.png") no-repeat scroll 8px -119px rgba(0, 0, 0, 0);}

.special-header{background: none repeat scroll 0 0 #f1f4f6;
    border-bottom: 1px solid #dfe2e4;
    border-radius: 3px 3px 0 0;
    padding: 10px 20px;
    text-align: center;}
.voucher-box:hover {
    background: none repeat scroll 0 0 #f5f5f5;
}
.voucher-box:hover .infograpic-box {
    background: none repeat scroll 0 0 #5b3671;
}
.modal.fade .modal-dialog{border-radius:6px;}
</style>

    <?php echo $this->Html->script('bootbox.js'); ?>

     <div class="modal-dialog login marketing vendor-setting">
        <div class="modal-content">
          <div class="modal-header special-header">
            <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Make Deal Using</h4>
          </div>
          <div class="modal-body clearfix pdng6">
            <div class="voucher-box mrgn-rgt0">
                <div class="infograpic-box">
                        <div class="beauty"></div>
                </div>
                <h2> Services</h2>
				 <?php echo $this->Html->link('Click Here ','javascript:void(0)',array('class'=>'purple-btn ButtonColor forService ')); ?>
                 <?php // echo $this->Form->button('Add New',array('class'=>'purple-btn addService','label'=>false,'div'=>false));?>
             </div>
            <div class="voucher-box mrgn-rgt0">
                <div class="infograpic-box">
                        <div class="inspiration"></div>
                </div>
                <h2>Package</h2>
				 <?php echo $this->Html->link('Click Here ','javascript:void(0)',array('class'=>'purple-btn ButtonColor forPackage ')); ?>
              
            </div>
			<div class="voucher-box mrgn-rgt0">
                <div class="infograpic-box">
                        <div class="inspiration"></div>
                </div>
                <h2>Spa Day</h2>
				 <?php echo $this->Html->link('Click Here ','javascript:void(0)',array('class'=>'purple-btn ButtonColor forSpaDay ')); ?>
              
            </div>
          </div>
        </div>
      </div>

















