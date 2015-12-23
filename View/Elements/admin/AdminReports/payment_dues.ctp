
<div class="box-title">
  <h3>Salon Transactions</h3>
</div>
<div class="box-content pdng-btm-non mrgn-btm20">
  <div class="col-sm-2">
      <div class="form-group pdng-tp7 ">
        <strong>Salon: </strong>
      </div>
  </div>
  <div class="col-sm-2">
      <div class="form-group">
        <?php echo $this->Form->select('salon',array($salon_list),array('empty'=>'- Select Salon -','value'=>'','class'=>'form-control full-w')); ?>
      </div>
  </div>
  <div class="col-sm-3">
    <div class="col-sm-6">
      <div class="form-group">
        <?php echo $this->Form->button('Search',array('id'=>'submitpayment','class'=>'btn full-w '));?>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <?php echo $this->Form->button('Clear', array('type'=>'reset','id'=>'reset','class'=>'btn full-w')); ?>
      </div>
    </div>
  </div>
</div>