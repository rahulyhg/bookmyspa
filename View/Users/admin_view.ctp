<section class="fancy_container">    
    <div class="fancy_contain">
        <h4 class="poph2backgrnd"><?php echo "User Details";?></h4>
    </div>
    <section class="fancy_contain">
        <label>Name</label>
        <span><?php echo $getData['User']['first_name'].' '.$getData['User']['last_name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Email</label>
        <span><?php echo $getData['User']['email']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>DOB</label>
        <span><?php echo ($getData['User']['dob'] != '0000-00-00 00:00:00') ? date('M j, Y',strtotime($getData['User']['dob'])):'N/A'; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Country</label>
        <span><?php echo $getData['Country']['name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Avatar Image</label>
        <span><?php echo (!empty($getData['User']['avatar_image'])) ?
        $this->Html->image('avatar/'.$getData['User']['avatar_image'], array('alt' => '', 'width'=>'90', 'height'=>'90')):'N/A'; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Cover Image</label>
        <span><?php echo (!empty($getData['User']['cover_image'])) ?
        $this->Html->image('cover/'.$getData['User']['cover_image'], array('alt' => '', 'width'=>'90', 'height'=>'90')):'N/A'; ?></span>
    </section>
</section>
<script type="text/javascript">
$(document).ready(function(){
$(".fancy_container section:even").css("background-color", "#dedede");
$(".fancy_container section:odd").css("background-color", "#ffffff");
 

});
</script>
