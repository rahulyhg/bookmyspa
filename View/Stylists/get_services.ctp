<?php 
if(!empty($treatments)){
    $i=$startId;
    foreach($treatments as $key=>$val){
        $value = $this->frontCommon->servicename($val);
        ?>
        <li class=""><a href="javascript:void(0)"><span><input value="<?php echo $val['Service']['id'];?>" name="service_parent"  type="radio" class="treatment" id="services_<?php echo $i; ?>" /><label class="new-chk" for="services_<?php echo $i; ?>">
                                                           <?php echo $value; ?>
                                                   </label></span></a>
                                                   </li>
<?php 
    $i++;
    }
}
exit;
?>