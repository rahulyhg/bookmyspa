<?php
echo $this->Html->script('fancy/jquery.fancybox.js?v=2.1.5');
echo $this->Html->css('fancy/jquery.fancybox.css?v=2.1.5');
echo $this->Html->script('fancy/jquery.fancybox-thumbs.js?v=1.0.7');
echo $this->Html->css('fancy/jquery.fancybox-thumbs.css?v=1.0.7');
if(isset($this->request->named) && !empty($this->request->named)){
    $this->request->data=$this->request->named;
}
$this->Paginator->options(array(
        'update' => '#update_ajax',
        'evalScripts' => true,
        'url' => array(
            'search_title' => @$this->request->data['search_keyword']        
        ),
        'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
        'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))
    ));
    ?>
<?php $lang =  Configure::read('Config.language'); ?>
<style>
ul
{
list-style-type: none;
}
.allVideos{float: right; margin-top: -40px; cursor: pointer;}
</style>
<div class="container video-tutorial">
    <!--main heading starts-->
    <h2 class="share-head">Feature: <span><?php echo $featured['VideoSetup'][$lang.'_title'];?></span></h2>
    <!--main heading ends-->
    <!--sort by-->
    <div class="top-recmnded">
        <label>Select by Title</label>
        <span class="option_wrapper">
            <?php 
            $valSel='';
            if(isset($this->request->data['search_title']) && !empty($this->request->data['search_title'])){
                $valSel=$this->request->data['search_title'];
            }
            echo $this->Form->input('VideoSetup.title',array('label'=>false,'type'=>'text','class'=>'form-control custom_optionLoc textbox','editable'=>false,'onkeyup'=>'auto_complete()','id'=>'search_auto','autocomplete'=>'off','value'=>$valSel));?>
            <?php echo $this->Form->hidden('title',array('value'=>''));?>
            <!--<span class="holder">Appointment Book</span>-->
            <ul class="auto-search" id="area_list_id"></ul>
            <div class="city_err"></div>
        </span>
    </div>
    <!--sort by ends-->
    <!--main body section-->
    <div class="big-video">
        <?php 
            $youtubeFirstId=$this->Common->getYoutubeId($featured['VideoSetup']['youtube_link']);
        ?>
    	<iframe width="1025" height="460" src="http://www.youtube.com/embed/<?php echo $youtubeFirstId;?>" frameborder="0"></iframe>
    </div>
    <p class="big-video-txt"><?php echo $featured['VideoSetup'][$lang.'_description'];?></p>
    <!--main body section-->
</div>
<div class="container">
    <!--feature video starts-->
    <div class="featured-deals-box clearfix">
        <h2 class="share-head">Videos</h2>
        <a id="watchAllVideos" class="allVideos">See All Videos</a>
        <div class="deal-box-outer clearfix">
            <?php 
            if(!empty($allVideos)){
            foreach($allVideos as $videos){
                if ($this->common->getYoutubeThumb($videos['VideoSetup']['youtube_link'])) {
                    $url = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "http://www.youtube.com/embed/$1?rel=0&amp;wmode=transparent", $videos['VideoSetup']['youtube_link']);
                ?>
            <div class="video-outer">
                <h3><?php echo $videos['VideoSetup'][$lang.'_title'];?></h3>
                <div class="big-deal">
                    <div class="photo-sec">
                        <!--<div><span><i class="fa  fa-play"></i></span></div>-->
                        <a class="fancyboxvid1 fancybox.iframe" href="<?php echo $url; ?>" title="<?php echo $videos['VideoSetup'][$lang.'_description'];?>">
                            <?php echo $this->Html->Image($this->common->getYoutubeThumb($videos['VideoSetup']['youtube_link'])); ?></a>
                    </div>
                    <div class="detail-area">
                        <?php
                        if(strlen($videos['VideoSetup'][$lang.'_description']) > 30){
                            $description= substr($videos['VideoSetup'][$lang.'_description'] , '0', '30').'...';
                        }else{
                            $description= $videos['VideoSetup'][$lang.'_description'];
                        }
                        ?>
                        <p><?php echo $description;?></p>
                        <div class="clearfix">
                            <?php //echo $this->Form->button('Watch Video',array('class'=>"book-now","type"=>"button"));?>
                            <a class="fancyboxvid1 fancybox.iframe book-now" href="<?php echo $url; ?>" title="<?php echo $videos['VideoSetup'][$lang.'_description'];?>">Watch Video</a>
                        </div>
                    </div>
                </div> 
            </div>
            <?php }}?>
            <?php 
            }else{?>
            <div class="video-outer">No Records</div>
            <?php }?>
         </div>
        <?php if(!empty($allVideos)){?>
        <div class="pdng-lft-rgt clearfix">
                <nav class="pagi-nation">
                    <?php if($this->Paginator->param('pageCount') > 1){
                            echo $this->element('pagination-frontend');
                           // echo $this->Js->writeBuffer();
                          }
                    ?>
                </nav>
            </div>
        <?php }?>
    </div>
    <!--feature video ends-->
</div>
 
<script>
    function auto_complete(){
       
    $('#area_list_id').hide();
        $('#area_list_id').html();
        var response = true;
        var keyword = $('#search_auto').val();
        if(keyword == ''){
                keyword = 'null';
        }
        
        $('.con').html('');
        var getURL = "<?php echo $this->Html->url(array('controller'=>'Videosetup','action'=>'getVideoTitles','admin'=>false)); ?>";
        $.ajax({
                url: getURL+'/'+keyword,	
                type: 'GET',
                beforeSend: function() {
                },
                success:function(data){
                        $('#area_list_id').hide();
                        if(data == ''){
                                $('#area_list_id').hide();
                                $('#area_list_id').html('');
                        }else{
                                $('#area_list_id').show();
                                $('#area_list_id').html(data);

                        }
                }
        });
        if(response = false){
                $('#area_list_id').hide();
        }
}
function set_useritem(item){
   vals = item.split(",");
   $('#city_id').val(vals[0]);
   $("#search_auto").val(vals[1]);
   $("#title").val(vals[1]);
   $('#area_list_id').hide();
   var search = $('#title').val();
        $.ajax({
       'type':'POST',
       data:{'search_title':search},
       URL: '<?php echo $this->Html->url(array('controller'=>'Videosetup','action'=>'index')); ?>',
       success:function(res){
           $(document).find('#update_ajax').html(res);
           return false;
       }
   });
   
   
}
$(document).ready(function(){
        $(".fancyboxvid1")
        .attr('rel', 'gallery')
        .fancybox({
            openEffect  : 'elastic',
          //title: this.title, 
            //description : '',
            closeEffect : 'elastic',
            nextEffect  : 'elastic',
            prevEffect  : 'elastic',
            padding     : 10,
            margin      : 50,
            helpers : {
            title : {
                type : 'inside'
            }},
            beforeShow  : function() {
                // Find the iframe ID
                var id = $.fancybox.inner.find('iframe').attr('id');
            }
        });
        
        $("#watchAllVideos").on('click',function(){
            var search = '';
        $.ajax({
       'type':'POST',
       data:{'search_title':search},
       URL: '<?php echo $this->Html->url(array('controller'=>'Videosetup','action'=>'index')); ?>',
       success:function(res){
           $(document).find('#update_ajax').html(res);
           return false;
       }
   });
        });
});
</script>
<!--Start of Tawk.to Script-->

<script type="text/javascript">

var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();

(function(){

	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	
	s1.async=true;
	
	s1.src='https://embed.tawk.to/55ff9b2aec060d141f446d58/default';
	
	s1.charset='UTF-8';
	
	s1.setAttribute('crossorigin','*');
	
	s0.parentNode.insertBefore(s1,s0);

})();

</script>

<!--End of Tawk.to Script-->
<?php echo $this->Js->writeBuffer();?>