<?php   
if(!empty($giftImageData)){
  $i=0;
  $default_div='';
  foreach($giftImageData as $val){
    if($i==0) {
      $default_div="massage".$val['GiftImage']['id'];?>
      <input type="hidden" name="data[GiftCertificate][gift_image_id]" id="siestaManageGChdn" value="<?php echo $val['GiftImage']['id']; ?>">
    <?php } ?>
    <div class="col-sm-6">
      <div  <?php if($i=='0'){ ?> style="border: 2px solid orange;" <?php } ?> class="massage" id="massage<?php echo $val['GiftImage']['id']; ?>" onclick="SetIdinHiddenField(this,<?php echo $val['GiftImage']['id']; ?>)">
	<div class="picture-space">
	  <?php echo $this->Html->Image('/images/GiftImage/150/'.$val['GiftImage']['image'],array('onclick'=>'SetIdinHiddenField(this,'.$val['GiftImage']['id'].')')); ?>
	</div>
	<div class="text-hgt text-center"><?php echo $val['GiftImage']['eng_title']; ?></div>
      </div>
    </div>
    <?php $i++;
  }
}else{ ?>
  <div class="col-sm-11">
    <?php echo '<ul><li style="list-style:none;background:#E6EAEC; border-bottom:1px Solid #CBCBCB; color:#333; font-size:14px; width: 100%; text-align:center; padding:10px 0 10px 0px; ">No Image Found to display.</li></ul>';?>			    .
  </div>
  <div id="default"></div>
<?php }
if(empty($default_div)){
  $default_div ='default';
}?>   
<script type="text/javascript">
  //call fucntion
  var glbl='<?php echo $default_div; ?>';
  $('.massage').click(function() {
    $('#'+glbl).css('border','2px solid #fff');
    $(this).css('border','2px solid orange');
    glbl=this.id;
  });      
  function SetIdinHiddenField(obj,id){
    if(id!='undefined'){
      $("#siestaManageGChdn").val(id);
	return true;
    }else{
      alert('Issue with image Id');
      return false;
    }
  }
</script>