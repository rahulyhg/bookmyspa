<h2>Billing Details</h2>
<ul class="profile">
    <li>
        <label>Account Holder Name: </label>
        <section>
            <?php
                      if(isset($bank_details)){
                        echo (isset($bank_details['BankDetail']['account_holder_name']) && !empty($bank_details['BankDetail']['account_holder_name']))? $bank_details['BankDetail']['account_holder_name'] : '--' ;
                      }
                      else{
                        echo '&nbsp;';
                      }?>
        </section>
    </li>
    <li>
        <label>Account Number: </label>
        <section>
            <?php
                      if(isset($bank_details)){
                        echo (isset($bank_details['BankDetail']['account_number']) && !empty($bank_details['BankDetail']['account_number']))? $bank_details['BankDetail']['account_number'] : '--' ;
                      }
                      else{
                        echo '&nbsp;';
                      }?>
        </section>
    </li>
    <li>
        <label>IBAN:</label>
        <section>
            <?php
                      if(isset($bank_details)){
                        echo (isset($bank_details['BankDetail']['iban']) && !empty($bank_details['BankDetail']['iban']))? $bank_details['BankDetail']['iban'] : '--' ;
                      }
                      else{
                        echo '&nbsp;';
                      }?>
        </section>
    </li>
    <li>
        <label>Swift Code:</label>
        <section>
            <?php
                      if(isset($bank_details)){
                        echo (isset($bank_details['BankDetail']['swift_code']) && !empty($bank_details['BankDetail']['swift_code']))? $bank_details['BankDetail']['swift_code'] : '--' ;
                      }
                      else{
                        echo '&nbsp;';
                      }?>
        </section>
    </li>
    <li>
        <label>Bank Name:</label>
        <section>
             <?php
                      if(isset($bank_details)){
                        echo (isset($bank_details['BankDetail']['bank_name']) && !empty($bank_details['BankDetail']['bank_name']))? $bank_details['BankDetail']['bank_name'] : '--' ;
                      }
                      else{
                        echo '&nbsp;';
                      }?>
        </section>
    </li>
    <li>
        <label>Bank Address:</label>
        <section>
            <?php
                      if(isset($bank_details)){
                        echo (isset($bank_details['BankDetail']['bank_address']) && !empty($bank_details['BankDetail']['bank_address']))? $bank_details['BankDetail']['bank_address'] : '--' ;
                      }
                      else{
                        echo '&nbsp;';
                      }?>
        </section>
    </li>
    <li>
        <label>Post Code:</label>
        <section>
             <?php
                      if(isset($bank_details)){
                        echo (isset($bank_details['BankDetail']['postcode']) && !empty($bank_details['BankDetail']['postcode']))? $bank_details['BankDetail']['postcode'] : '--' ;
                      }
                      else{
                        echo '&nbsp;';
                      }?>
        </section>
    </li>
    <li>
        <label>Country: </label>
        <section>
             <?php
                      if(isset($bank_details)){
                        echo (isset($bank_details['BankDetail']['country']) && !empty($bank_details['BankDetail']['country']))? $countryData[$bank_details['BankDetail']['country']] : '--' ;
                      }
                      else{
                        echo '&nbsp;';
                      }?>
        </section>
    </li>
</ul>