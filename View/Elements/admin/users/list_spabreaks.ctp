<?php
if(!empty($customer_id)) {
$this->Paginator->options(
    array(
	    'update' => '#user_elements',
	    'evalScripts' => true,
	    'url' => array('controller' => 'users', 'action' =>'admin_giftcertificates',@$customer_id),
	    'before' => $this->Js->get('.loader-container')->effect(
		'fadeIn',
		array('buffer' => false)
	    ),
	    'complete' => $this->Js->get('.loader-container')->effect(
		'fadeOut',
		array('buffer' => false)
	    ),
	)
    );?>

<?php  echo $this->element('admin/users/nav'); ?>


<div class="tab-content">
    <?php
   if(!empty($orders)){ ?>
    <table class="table table-hover table-nomargin table-bordered">
        <thead>
            <tr>
                <th style="text-align:center">Spa Break</th>
				<th style="text-align:center">Salon Name</th>
				<th style="text-align:center">Image</th>
                <th style="text-align:center">Amount(AED)</th>
				<th style="text-align:center">Validity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach($orders as $order){ ?>
			<tr>
                <td style="text-align:center"><?php echo $order['Order']['ara_service_name']; ?></td>
				<td style="text-align:center"><?php echo $this->Common->get_my_salon_name($order['Order']['salon_id']); ?></td>
                <td style="text-align:center">
				<?php
					$image = $this->Common->getspabreakImage($order['SalonSpabreakImage']['spabreak_id'],$order['SalonSpabreakImage']['created_by'],150);
					echo $this->Html->image($image,array('class'=> "",'width'=>70));
				?>
				</td>
                <td style="text-align:center">
					AED <?php echo $order['OrderDetail'][0]['price'];?>
				</td>
                <td style="text-align:center">
					Valid From
					<?php 
						$duration = $order['OrderDetail'][0]['option_duration'];
						$spaDuration = explode('~',$duration);
						if(isset($spaDuration[0])){
							echo date('d M Y',strtotime($spaDuration[0]));
							echo " to ";
						}
						if(isset($spaDuration[1])){
							echo date('d M Y',strtotime($spaDuration[1]));                                                            
						}
					?>
				</td>
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