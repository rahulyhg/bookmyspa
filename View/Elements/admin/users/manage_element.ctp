            <div class="cover hgt-auto clearfix customer-sec">
                 <?php echo $this->element('admin/users/customer_view'); ?>
            </div>
        
	    <div id="user_elements" role="tabpanel" class="vendor-deal-sec business-list">
	    <!-- Nav tabs -->
		<?php echo $this->element('admin/users/list_appointments');
		
		?>
	    </div>
	    <?php    echo $this->Js->writeBuffer();?>