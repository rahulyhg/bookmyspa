<style>
.gallery > li {
    cursor: pointer !important;
    float: left !important;
    margin: 1px 0 0 1px !important;
    position: relative !important;
}
</style>
<div class="row-fluid">
    <div class="span12">
        <ul class="gallery">
            <?php
            //$uid = $this->Session->read('Auth.User.id');
            if(count($venueImages)>0){
            foreach($venueImages as $venueImage){
            $uid = $venueImage['VenueImage']['user_id'];
            ?>
                <li style="position: relative !important">
                        <a href="#">
                                <?php echo $this->Html->Image('/images/'.$uid.'/VenueImage/150/'.$venueImage['VenueImage']['image']); ?>
                        </a>
                        <div class="extras">
                                <div class="extras-inner">
                                <a href="<?php echo $this->Html->url('/images/'.$uid.'/VenueImage/800/'.$venueImage['VenueImage']['image']); ?>" title="<?php echo $venueImage['VenueImage']['eng_title']; ?>" class='colorbox-image cboxElement' rel="group-1"><i class="icon-search"></i></a>
                                            <?php //echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0)',array('data-type'=>'image','data-id'=>base64_encode($venueImage['VenueImage']['id']),'class'=>'addeditImage','escape'=>false)); ?>
                                            <a href="javascript:void(0)" onclick="return confirm('Are you sure?');" data-id="<?php echo  base64_encode($venueImage['VenueImage']['id']); ?>" class='del-gallery-pic delete'><i class="icon-trash"></i></a>
                            
                                </div>
                        </div>
                </li>
            <?php   }
            
            }else{
            echo "No Images Found";
            }?>
        </ul>
    </div>
</div>

<script>
$(document).ready(function(){
          /*********************Ajax code to delete image/video **********************************/  
    $(document).on('click','.del-gallery-pic.delete', function(){
      $this =  $(this);  
     itsId = $(this).data('id');
     deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Albums','action'=>'deletevenueImage','admin'=>true)); ?>";
     deleteUrl = deleteUrl+'/'+itsId;
     $.ajax({
        url:deleteUrl,
        success:function(result){
        $this.closest("li").remove();
        },
     });
     
    });
})
</script>