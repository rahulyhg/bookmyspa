<div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>Report Filter</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
        <?php echo $this->Form->create('report',array('id'=>'reportsId'));?>
      <tr>
          <td><span><strong>Customer Since</strong></span>
              <br/>
              From : <?php echo $this->Form->input('startDate',array('class'=>'datepicker largeTextBox','label'=>false));?>
              &nbsp; To : <?php echo $this->Form->input('endDate',array('class'=>'datepicker largeTextBox','label'=>false));?>
          </td>
          <td><span><strong>Last Visit</strong></span>
              <br/>
              <?php echo $this->Form->input('lastVisitStartDate',array('class'=>'datepicker largeTextBox','label'=>false));?>
              &nbsp; <?php echo $this->Form->input('lastVisitEndDate',array('class'=>'datepicker largeTextBox','label'=>false));?></td>
      <td><span><strong>Bookings</strong></span>
              <br/>
          <?php echo $this->Form->input('bookingStart',array('class'=>'smallTextBox','label'=>false));?>
          &nbsp;<?php echo $this->Form->input('bookingEnd',array('class'=>'smallTextBox','label'=>false));?>
      </td>
      <td><span><strong>Amt Paid</strong></span>
              <br/>
          <?php echo $this->Form->input('amtPaidStart',array('class'=>'smallTextBox','label'=>false));?>
          &nbsp;<?php echo $this->Form->input('amtPaidEnd',array('class'=>'smallTextBox','label'=>false));?>
      </td>
      <td><span><strong>No Show/Cancel</strong></span>
              <br/>
          <?php echo $this->Form->input('showStart',array('class'=>'smallTextBox','label'=>false));?>
          &nbsp;<?php echo $this->Form->input('showEnd',array('class'=>'smallTextBox','label'=>false));?>
      </td>
      <td><span><strong>Age</strong></span>
              <br/>
          <?php echo $this->Form->input('ageStart',array('class'=>'smallTextBox','label'=>false));?>
          &nbsp;<?php echo $this->Form->input('ageEnd',array('class'=>'smallTextBox','label'=>false));?>
      </td>
      </tr>
      <tr>
        <td><span><strong>Name/Email/Address/Cell/Referred by/General Tag</strong></span>
              <br/><?php echo $this->Form->input('searchText',array('class'=>'largeTextBox','label'=>false));?></td>
        <td><span><strong>B-Day</strong></span>
              <br/>
        <?php echo $this->Form->select('bday',array($bdayMonths),array('empty'=>'month'));?>
        </td>
        <td>
            <?php echo $this->Form->submit('Search',array());?>&nbsp;
            <?php echo $this->Form->reset('Clear',array());?>
            <?php echo $this->Form->end();?>
        </td>
      </tr>
      
    </tbody>
  </table>
  </div>