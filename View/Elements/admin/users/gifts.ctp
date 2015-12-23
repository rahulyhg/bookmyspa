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
   if(!empty($gifts)){ ?>
    <table class="table table-hover table-nomargin table-bordered">
        <thead>
            <tr>
                <th style="text-align:center">GiftCertificate Code</th>
                <th style="text-align:center">Image</th>
                <th style="text-align:center">Expire On</th>
                <th style="text-align:center">Amount Left(AED) </th>
		<th style="text-align:center">Total Amount(AED) </th>
                <th style="text-align:center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i=1;
            foreach($gifts as $gift){ ?>
		<tr>
                    <td><?php echo $gift['GiftCertificate']['gift_certificate_no'];?></td>
                    <td style="text-align:center">
			<?php
			   $image =  $this->Html->Image('/images/GiftImage/original/'.$gift['GiftCertificate']['image'],array('width'=>40));
			   $viewimage =  $this->Html->Image('/images/GiftImage/original/'.$gift['GiftCertificate']['image'],array('width'=>570));
			   $image2 =  $this->Html->Image('/images/GiftImage/500/'.$gift['GiftCertificate']['image'],array('width'=>90));
			   $img = WWW_ROOT . '/images/GiftImage/original/'.$gift['GiftCertificate']['image'];
			   $img2 = WWW_ROOT . '/images/GiftImage/500/'.$gift['GiftCertificate']['image'];
			   if(file_exists($img)){
				echo $image;
			   }
			?>
		    </td>
                    <td style="text-align:center"><?php

		        if(!empty($gift['GiftCertificate']['expire_on'])){
                            echo date('d M,Y',strtotime($gift['GiftCertificate']['expire_on']));
                        } else {
                            echo '-';
                        }?></td>
                    
                    <td style="text-align:center"><?php echo ($gift['GiftCertificate']['is_used']==0)?$gift['GiftCertificate']['amount']:'0'; ?></td>
		    <td style="text-align:center"><?php echo $gift['GiftCertificate']['total_amount']; ?></td>
                    <td style="text-align:center">
		    <?php 
                        if($gift['GiftCertificate']['is_used']==1) {
                            echo "Used";
                        }else if($gift['GiftCertificate']['amount']==$gift['GiftCertificate']['total_amount']){
                            echo "Unused";
                        }else{
			    echo "Partially used";
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