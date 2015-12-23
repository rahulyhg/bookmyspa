<section class="fancy_container">    
    <div class="fancy_contain">
        <h4 class="poph2backgrnd"><?php echo "Gallery Image Details";?></h4>
    </div>
    <section class="fancy_contain">
        <label>Image Name</label>
        <span><?php echo $getData['GalleryPhoto']['image_name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Status</label>
        <?php $status = ($getData['GalleryPhoto']['status'] == 1) ? 'Active' : 'Inactive'; ?>
        <span><?php echo $status; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Created</label>
        <span><?php echo $getData['GalleryPhoto']['created']; ?></span>
    </section>
	<section class="fancy_contain">
        <label>Image</label>
        <span><?php 
			$imgC = 0;
			 if(!empty($getData['GalleryPhoto']['gallery_image'])) {
			   $imageName = 'comments/thumb/'.$getData['GalleryPhoto']['gallery_image'];                
			   if(file_exists(WWW_ROOT.'/img/'.$imageName) && !empty($getData['GalleryPhoto']['gallery_image']))
			   {
				  echo "<div class='col-lg-3 padding_btm_20' >". $this->Html->image($imageName, array('class'=>'deldivimg'))."</div>";
			   }
			 }
		
		?></span>
    </section>
</section>
<script type="text/javascript">
$(document).ready(function(){
$(".fancy_container section:even").css("background-color", "#dedede");
$(".fancy_container section:odd").css("background-color", "#ffffff");
 
});
</script>
