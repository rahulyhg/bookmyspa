<div class="row-fluid">
    <div class="span12">
                <?php
                    if($planType == 'sms'){
                        echo $this->element('admin/Payment/sms_table');
                    }
                    elseif($planType == 'email'){
                        echo $this->element('admin/Payment/email_table');
                    }
                    elseif($planType == 'featuring'){
                        echo $this->element('admin/Payment/featuring_table');    
                    } ?>
    </div>
</div>