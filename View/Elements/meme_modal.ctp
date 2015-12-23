<script>
    $(document).ready(function() {
        var type = 'meme';
        $(".meme_input").ajaxUpload({
            url: "/homes/insertMeme/",
            name: "file",
            responseType: 'JSON',
            onSubmit: function() {
                this.setData({
                    content_id: ''
                });
            },
            onComplete: function(result) {
                var jsonData = eval('(' + result + ')');
                if(jsonData.error){
                   alert(jsonData.error);
                }else{
                ////this.closest('.UploadButton').next('.hiddenFileUpload').val(jsonData.image);
                $('#user_meme_container').prepend('<li><span class="hidden_span hidden_image">' + jsonData.image + '</span><span class="hidden_span hidden_meme_ID">' + jsonData.meme_id + '</span><span class="hidden_span hidden_image_ID">' + jsonData.meme_image_id + '</span><span class="hidden_span hidden_header_text">Click to add text</span><span class="hidden_span hidden_footer_text">Click to add text</span><a href="javascript:void(0);"  class="meme_image_link"><img src="img/' + type + '/thumb/' + jsonData.image + '" /></a></li>');
            }}
        });

    });
</script>
<style>
    .memecon  {
        padding:8px 3px;
    }
    .hidden_span{
        display: none;
    }

    .edit_icon{
        float:right;
        display: none;

    }
    #insertMeme{
   background-color:  #357b99;

    }
</style>
<div class="modal-dialog">
    <div class="modal-content">
        <section class="popup">
            <section class="modal-dialog meme-dialog">
                <section class="modal-content">
                    <section class="modal-header">
                        <button data-dismiss="modal" class="close close-btn" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h2 id="myModalLabel" class="modal-title">Meme<?php //debug($datasets); ?></h2>
                    </section>
                    <section class="modal-body p-btm0">
                        <!--Add List Start-->
                        <section class="addlist-widget meme-content clearfix">
                            <section class="meme-left">

                                <section class="topbtns clearfix">
                                    <a href="javascript:void(0);"  class="meme_input">Upload</a>
                                    <a href="javascript:void(0)" id="insertMeme" data-loading-text="<?php echo (!empty($id) ? 'Updating...' : 'Inserting...'); ?>"><?php echo (!empty($id) ? 'Update' : 'Insert'); ?></a>
                                </section>
<style>
       #content_1{
            width: 100%;
            height: 400px;  /* Got to be set so the jScrollpane can function */
            overflow: auto;
        }
</style>
   <section  class="" id="content_1">
   <div style="position:relative; height:100%; overflow:hidden; max-width:100%;" id="mCSB_1" class="mCustomScrollBox mCS-light"><div style="position: relative; top: 0px;" class="mCSB_container">
                                            <section class="memecon">
                                                <!--My Photos Start-->
                                                <section class="mypics">
                                                    <h4>My Photos</h4>
                                                    <ul class="meme-pics clearfix liststyle-none" id="user_meme_container">
                                                        <?php
                                                        if (!empty($datasets['user'])) {
                                                            foreach ($datasets['user'] as $key => $user_meme) {
                                                                if (!empty($user_meme['Meme']['footer_text'])) {

                                                                    $footer_text = $user_meme['Meme']['footer_text'];
                                                                } else {
                                                                    $footer_text = '';
                                                                }
                                                                if (!empty($user_meme['Meme']['header_text'])) {

                                                                    $header_text = $user_meme['Meme']['header_text'];
                                                                } else {
                                                                    $header_text = '';
                                                                }
                                                                ?>
                                                                <li>
    <span class="hidden_span hidden_image"><?php echo $user_meme['MemeImage']['image']; ?></span>
                                                                    <span class="hidden_span hidden_meme_ID"><?php echo $user_meme['MemeImage']['image']; ?></span>
                                                                    <span class="hidden_span hidden_image_ID"><?php echo $user_meme['MemeImage']['id']; ?></span>
                                                                    <span class="hidden_span hidden_header_text"><?php echo $header_text; ?></span>
                                                                    <span class="hidden_span hidden_footer_text"><?php echo $footer_text; ?></span>
  <a href="javascript:void(0);"  class="meme_image_link"><?php echo $this->Html->image('meme/thumb/' . $user_meme['MemeImage']['image'] , array('fullBase' => true , 'height'=>'100%', 'width'=>'100%')); ?></a>
                                                                </li>
    <?php }
} ?>
                                                    </ul>
                                                </section>
                                                <!--My Photos Closed-->
                                                <!--Photos Start-->
                                                <section class="allpics">
                                                    <h4>Photos</h4>
                                                    <ul class="meme-pics clearfix liststyle-none">
                                                        <?php if (!empty($datasets['admin'])) {
                                                            foreach ($datasets['admin'] as $key => $admin_meme) {
                                                             if (!empty($user_meme['Meme']['footer_text'])) {

                                                                    $footer_text = $admin_meme['Meme']['footer_text'];
                                                                } else {
                                                                    $footer_text = '';
                                                                }
                                                                if (!empty($admin_meme['Meme']['header_text'])) {

                                                                    $header_text = $admin_meme['Meme']['header_text'];
                                                                } else {
                                                                    $header_text = '';
                                                                }  
                                                                
                                                                
                                                                
                                                              ?>
    <li>  <span class="hidden_span hidden_image"><?php echo $admin_meme['MemeImage']['image']; ?></span>
      <span class="hidden_span hidden_meme_ID"><?php echo $admin_meme['MemeImage']['image']; ?></span>
      <span class="hidden_span hidden_image_ID"><?php echo $admin_meme['MemeImage']['id']; ?></span>
                                                                    <span class="hidden_span hidden_header_text"><?php echo $header_text; ?></span>
                                                                    <span class="hidden_span hidden_footer_text"><?php echo $footer_text; ?></span>                                                      
                                                        
                                                        
                                                               <span class="hidden_span"><?php echo $admin_meme['MemeImage']['image']; ?></span><a href="javascript:void(0);" class="meme_image_link"> <?php echo $this->Html->image('meme/thumb/' . $admin_meme['MemeImage']['image']); ?></a></li>
    <?php }
} ?>
</ul>
</section>
                                                <!--Photos Closed-->
                                            </section>
                                        </div>
    <div style="position: absolute; display: block;" class="mCSB_scrollTools"><a oncontextmenu="return false;" class="mCSB_buttonUp"></a><div class="mCSB_draggerContainer"><div oncontextmenu="return false;" style="position: absolute; height: 217px; top: 0px;" class="mCSB_dragger"><div style="position: relative; line-height: 217px;" class="mCSB_dragger_bar"></div></div><div class="mCSB_draggerRail"></div></div><a oncontextmenu="return false;" class="mCSB_buttonDown"></a></div>
                                    </div></section>
                            </section>
                            <section class="meme-mainpic">
                            <?php echo $this->Form->create('Meme', array('id' => 'form_image_text', 'url' => array('controller' => 'homes', 'action' => 'meme'))); ?>
                                <input id="meme_id" value="<?php echo @$id; ?>" name="data[Meme][meme_id]" type="hidden" />
                                <input type='hidden' name='content_id' id="contentId"   value="" />
                                <?php
                                if (!empty($datasets['Meme']['meme_image_id'])) {
                                    $image = $datasets['MemeImage']['image'];
                                    $hidden_id = $datasets['Meme']['meme_image_id'];
                                    }else{
                                   if(count($datasets['admin']['0']['MemeImage']))
                                    $image =  $datasets['admin']['0']['MemeImage']['image'];
                                    $hidden_id = $datasets['admin']['0']['MemeImage']['id'];
                                }
                                echo $this->Html->image('meme/original/'.$image, array('class' => 'original_image'));
                                ?>

                                    <?php echo $this->Form->input('image_ID', array('name' => 'data[Meme][meme_image_id]', 'id' => 'image_ID', 'type' => 'hidden', 'label' => false, 'div' => false ,'value'=>$hidden_id)); ?>
                                <?php echo $this->Form->input('header_text', array('name' => 'data[Meme][header_text]', 'id' => 'hidden_uppertext', 'type' => 'hidden', 'label' => false, 'div' => false)); ?>
<?php echo $this->Form->input('footer_text', array('name' => 'data[Meme][footer_text]', 'id' => 'hidden_lowertext', 'type' => 'hidden', 'label' => false, 'div' => false)); ?>
                                <?php $head_text = (isset($datasets['Meme']['id'])) ? $datasets['Meme']['header_text'] : 'Lorem ipsum dolor sit amet, conse ctetur' ?>
<p class="uppertext"><span class="meme_image_text" id="uppertext_text"><?php echo $head_text; ?></span>
<?php echo $this->HTML->image('edit.png', array('class' => 'edit_icon')); ?></p>
<?php $footer_text1 = (isset($datasets['Meme']['id'])) ? $datasets['Meme']['footer_text'] : 'Lorem ipsum dolor sit amet, conse ctetur' ?>

                                <p class="lowertext"><span class="meme_image_text" id="lowertext_text"><?php echo $footer_text1; ?> </span><?php echo $this->HTML->image('edit.png', array('class' => 'edit_icon')); ?></p>
<?php echo $this->Form->end(); ?>
                            </section>
                        </section>
                        <!--Add List Closed-->
                    </section>
                </section>
            </section>
        </section>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php 
 echo $this->Html->script('script/jquery.mousewheel.js'); 
 echo $this->Html->script('script/jquery.jscrollpane.min.js');
?>
<script>
    (function($) {
//        $(document).ready(function() {
//            $("#content_1").jScrollPane({
//                    autoReinitialise: true,
//                    showArrows: true,
//                    verticalArrowPositions: 'split',
//                    horizontalArrowPositions: 'split'
//            });
        
         
    })(jQuery);
    
    
    
    $(function()
        {
            $('#content_1').jScrollPane(
                {       
                    autoReinitialise: true,
                    //showArrows: true,
                    verticalArrowPositions: 'split',
                    horizontalArrowPositions: 'split'
                }
            );
        });
    
    
    
    
    
</script>

