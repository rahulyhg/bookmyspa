<?php
     $is_test = Configure::read('is_test_payment');
     $urlVar = ($is_test)?'test':'secure';
?>
<form method="post" name="redirect" action="https://<?php echo $urlVar; ?>.ccavenue.ae/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
<script language='javascript'>document.redirect.submit();</script>