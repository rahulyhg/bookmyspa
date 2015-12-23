    <?php  echo $this->Html->script('user/login'); ?>
    <div class="panel-body">
        <script type='text/javascript' src='http://yoursite.com/content_embed.js?content_id=1234'></script>
        <h2>Transaction Details</h2>
    <div class="loginform">
 <?php if(count($transactions) && !empty($transactions)){   ?>
     <table style="width:300px">
    <tr>
    <th>Transaction Id</th>
    <th>Amount</th>
    <th>Date</th></tr>
    <?php foreach($transactions as $transactions){ ?>
    <tr><td><?php echo $transactions['Transaction']['transaction_id']; ?></td>
    <td><?php echo $transactions['Transaction']['amount']; ?></td>
    <td><?php echo $transactions['Transaction']['created']; ?></td>
    </tr>
<?php } ?>
     </table>
            <div class="row"> <?php
                        if($this->Paginator->param('pageCount') > 1)
                        {
                            echo $this->element('admin/pagination');                 
                        }
                        ?>
            </div>

 <?php } ?>
    
    </div>
    </div>