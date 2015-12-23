<?php
if(!empty($customer_id)) {
$this->Paginator->options(
    array(
	    'update' => '#user_elements',
	    'evalScripts' => true,
	    'url' => array('controller' => 'users', 'action' =>'admin_iou_details',@$customer_id),
	    'before' => $this->Js->get('.loader-container')->effect(
		'fadeIn',
		array('buffer' => false)
	    ),
	    'complete' => $this->Js->get('.loader-container')->effect(
		'fadeOut',
		array('buffer' => false)
	    ),
	)
    ); ?>

<?php  echo $this->element('admin/users/nav'); ?>


<div class="tab-content">
    <?php
   if(!empty($ious)){ ?>
   <?php //pr($ious); die; ?>
    <table class="table table-hover table-nomargin table-bordered">
        <thead>
            <tr>
                <th style="text-align:center">Created Date</th>
                <th style="text-align:center">Comment</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Amount(AED)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach($ious as $iou){ ?>
		<tr>
                    <td style="text-align:center"><?php echo date('d M,y',strtotime($iou['Iou']['created']));?></td>
                    <td style="text-align:center"><?php echo $iou['Iou']['iou_comment']?></td>
                    <td style="text-align:center">
                        <?php

		        if($iou['Iou']['status']==1){
                           
			    echo 'Paid';
                        } else {
                            echo 'Unpaid';
                        }?>
                    </td>
                    
                    <td style="text-align:center"><?php echo $iou['Iou']['total_iou_price']; ?></td>                    
            </tr>    
            <?php $i++; } ?>
        </tbody>
    </table>
        <div class ="ck-paging">
            <?php
            echo $this->Paginator->first('First');
            echo $this->Paginator->prev(
                      'Previous',
                      array(),
                      null,
                      array('class' => 'prev disabled')
            );
            echo $this->Paginator->numbers(array('separator'=>' '));
            echo $this->Paginator->next(
                      'Next',
                      array(),
                      null,
                      array('class' => 'next disabled')
            );
            echo $this->Paginator->last('Last');?>
        </div>
    <?php }else{
	    echo 'No record found.';	
	} ?>
</div>
<div class="clearfix"></div>
<?php }
echo $this->Js->writeBuffer();?>