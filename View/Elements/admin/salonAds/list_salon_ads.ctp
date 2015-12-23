<table class="table table-hover table-nomargin dataTable table-bordered">
    <thead>
        <tr>
            <th>English Title</th>
            <th>English Description</th>
            <th>Arabic Title</th>
            <th>Arabic Description</th>
            <th>Status</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
                        <?php if(!empty($ads)){
                            $uid = $this->Session->read('Auth.User.id');
                            foreach($ads as $adsValue){ ?>
                                <tr data-id="<?php echo $adsValue['SalonAd']['id']; ?>" >
                                    <td><?php echo $adsValue['SalonAd']['eng_title']; ?></td>
                                    <td><?php echo $adsValue['SalonAd']['eng_description']; ?></td>
                                    <td><?php echo $adsValue['SalonAd']['ara_title']; ?></td>
                                    <td><?php echo $adsValue['SalonAd']['ara_description']; ?></td>
                                    
                                    <td><?php echo $this->Common->theStatusImage($adsValue['SalonAd']['status']); ?></td>
                                    <td><?php echo $this->Html->Image('/images/'.$uid.'/SalonAd/150/'.$adsValue['SalonAd']['image']); ?></td>
                                    
                                    <td>
                                                                <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>$adsValue['SalonAd']['id'],'title'=>'Edit','class'=>'addedit_salonAd','escape'=>false) ) ?>
                                        &nbsp;&nbsp;
                                                                <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','class'=>'delete_salonAd','escape'=>false)); ?>
                                    </td>
                                </tr>    
                        <?php }
                        }?>
    </tbody>
 
</table>
<script>
$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
</script>
<script>
    $(document).ready(function(){     
        $("[name='data[is_featured]']").bootstrapSwitch();

    $('.alert_show').parent('.bootstrap-switch-container').parent('.bootstrap-switch').parent('span.check_alert').on('click', function(){
               if($(this).find('input[name="data[is_featured]"]').data('plan')=='No Plan' || $(this).find('input[name="data[is_featured]"]').data('plan')==''){                             
                           alert('Please Upgrade your plan to make advertisement featured!!');                            
               }                             
           })

    $('input[name="data[is_featured]"]').on('switchChange.bootstrapSwitch', function(event, state){
                    if($(this).data('plan')=='No Plan' || $(this).data('plan') == ''){ 
                     $(this).bootstrapSwitch('state', false);
                   }else{
                   var theJ = $(this);
                   var theId = theJ.data('active-id');
                   var statusTo = state
                   $.ajax({
                       type: "POST",
                       url: "<?php echo $this->Html->url(array('controller'=>'SalonAds','action'=>'changeFeaturedStatus','admin'=>true));?>",
                       data: { id: theId, status: statusTo}
                   })  
                   }
               });
});
</script>
<style>
.extras:before {
    content: "";
    display: inline-block;
    height: 100%;
    vertical-align: middle;
}
.extras .extras-inner {
    display: inline-block;
    height: auto;
    position: relative;
    vertical-align: middle;
    width: 90%;
}
</style>