
<h2>Billing Details</h2>
<ul class="profile">
    <div class="text-right">
    <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0)',array('class'=>'btn addedit_Business','escape' => false,'data-id'=>base64_encode($user['User']['id']))); ?>
    </div>
    <li>
        <label>Company Title:</label>
        <span><?php echo ($billingData['BillingDetail']['company_title'])? $billingData['BillingDetail']['company_title']:'--'; ?></span>
    </li>
    <li>
        <label>Company Number:</label>
        <span>
             <?php
                   if(isset($billingData['BillingDetail']['company_number'])&&!empty($billingData['BillingDetail']['company_number'])){
                     echo $billingData['BillingDetail']['company_number'];
                   }else{
                    echo '--';
                   }
                ?>
        </span>
    </li>
    <li>
        <label>Address:</label>
        <span>
             <?php
                   if(isset($billingData['BillingDetail']['address'])&&!empty($billingData['BillingDetail']['address'])){
                     echo $billingData['BillingDetail']['address'];
                   }else{
                    echo '--';
                   }
                ?>
        </span>
    </li>
    <li>
        <label>Post Code:</label>
        <span>
            <?php
                   if(isset($billingData['BillingDetail']['postcode'])&&!empty($billingData['BillingDetail']['postcode'])){
                     echo $billingData['BillingDetail']['postcode'];
                   }else{
                    echo '--';
                   }
                ?>
        </span>
    </li>
    <li>
        <label>Country: </label>
        <span>
            <?php
                   if(isset($countryData[$billingData['BillingDetail']['country_id']])&&!empty($countryData[$billingData['BillingDetail']['country_id']])){
                     echo $countryData[$billingData['BillingDetail']['country_id']];
                   }else{
                    echo '--';
                   }
                ?>
        </span>
    </li>
    <li>
        <label>City: </label>
        <span>
             <?php
                    $stateList = $this->Common->getStatesbyCid($billingData['BillingDetail']['country_id']);
                    if(isset($billingData['BillingDetail']['state_id'])&&!empty($billingData['BillingDetail']['state_id'])){
                        echo $stateList[$billingData['BillingDetail']['state_id']];
                    }else{
                        echo '--';
                    }
                ?>
        </span>
    </li>
    <li>
        <label>Location/Area:</label>
        <span>
             <?php
                    $cityList = $this->Common->getCitiesbySid($billingData['BillingDetail']['state_id']);
                    if(isset($billingData['BillingDetail']['city_id'])&&!empty($billingData['BillingDetail']['city_id'])){
                        echo $cityList[$billingData['BillingDetail']['city_id']];
                    }else{
                        echo '--';
                    }
                ?>
        </span>
    </li>
    <li>
        <label>Operating Country: </label>
        <span>
            <?php
                    if(isset($billingData['BillingDetail']['operating_country'])&& !empty($billingData['BillingDetail']['operating_country'])){
                        echo $countryData[$billingData['BillingDetail']['operating_country']];
                    }else{
                        echo '--';
                    }
                ?>
        </span>
    </li>
    <li>
        <label>Contact Name: </label>
        <span>
            <?php
                   if(isset($billingData['BillingDetail']['contact_name'])&&!empty($billingData['BillingDetail']['contact_name'])){
                     echo $billingData['BillingDetail']['contact_name'];
                   }else{
                    echo '--';
                   }
                ?>
        </span>
    </li>
    <li>
        <label>Email: </label>
        <span>
             <?php
                   if(isset($billingData['BillingDetail']['email'])&&!empty($billingData['BillingDetail']['email'])){
                     echo $billingData['BillingDetail']['email'];
                   }else{
                    echo '--';
                   }
                ?>
        </span>
    </li>
    <li>
        <label>Phone:</label>
        <span>
             <?php
                   if(isset($billingData['BillingDetail']['phone'])&&!empty($billingData['BillingDetail']['phone'])){
                     echo $billingData['BillingDetail']['phone'];
                   }else{
                    echo '--';
                   }
                ?>
        </span>
    </li>
    <li>
        <label>Contact Phone:</label>
        <span>
             <?php
                   if($billingData['BillingDetail']['contact_phone']){
                     echo $billingData['BillingDetail']['contact_phone'];
                   }else{
                    echo '--';
                   }
                ?>
        </span>
    </li>
</ul>