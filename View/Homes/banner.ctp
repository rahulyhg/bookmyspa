   <div class="modal-dialog" style="width:841px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                 <h4 class="modal-title" id="memberModalLabel">Home Page Banner</h4>
            </div>
            <div class="modal-body">
               <?php if(isset($banner_list) && count($banner_list)>0){ ?>
               <?php //pr(count($banner_list)); die;?>
                <?php echo $this->Html->Image('/images/'.$banner_list[0]['SalonAd']['user_id'].'/SalonAd/800/'.$banner_list[0]['SalonAd']['image']); ?>
                <?php }else{ echo "No Banner Found"; ?>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <div class='desc'>
                    <?php if(isset($banner_list) && count($banner_list)>0){ ?>
                    <?php echo $banner_list[0]['SalonAd']['eng_description']; ?> </div>
                <?php } ?>
            </div>
        </div>
    </div>
<style>
    .desc{
        text-align: left;
    }
</style>