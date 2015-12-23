<?php
echo $this->Html->script('fancy/jquery.fancybox.js?v=2.1.5');
echo $this->Html->css('fancy/jquery.fancybox.css?v=2.1.5');
echo $this->Html->script('fancy/jquery.fancybox-thumbs.js?v=1.0.7');
echo $this->Html->css('fancy/jquery.fancybox-thumbs.css?v=1.0.7');
?>
<style>
.selected{
   /* box-shadow:0px 12px 22px 1px #333;*/
    border:1px dashed #74756f;
}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-content">
                <div class="alldataULLI vendor-setting full-w">
                    <?php echo $this->element('admin/Service/salon_treatment_gallery'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function callfordatarepace(){
        var activeId = $(document).find('div.in').attr('id');
        var imageList = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'treatment_gallery','admin'=>true))?>"
        $(document).find(".alldataULLI").load(imageList, function() {
            $(document).find('div.in').removeClass('in').css({'height':'0px'});
            $(document).find('div#'+activeId).addClass('in').css({'height':'auto'});
             $('.unbndTgle').unbind('click');
         $('.unbndTgle').bind('click');
        });    
        
    }
    
    //------------For delete image---------------------//
    
    $(document).ready(function(){
        $(document).on('click','.del-tpic',function(){
            var theOb = $(this);
            if(confirm('<?php echo __("Are you sure you want to Delete ?")?>')){
                $('body').modalmanager('loading');
                itsId = $(this).attr('data-id');
                imgVal = $(this).closest('li').attr('data-img');
                deleteUrl = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'deleteTreatmentImage','admin'=>true)); ?>";
                deleteUrl = deleteUrl+'/'+itsId+'/'+imgVal;
                $.ajax({
                    url:deleteUrl,
                    success:function(result){
                        var data = jQuery.parseJSON(result);
                        if(data.msg == 's'){
                            theOb.closest("li").remove();
                            callfordatarepace()
                        }else if(data.msg == 'e'){
                                if(data.data !=''){
                                    alert('You cannot delete this image as, treatments "'+data.data+'" has only one image associated with it.');
                                }else{
                                    alert('Unable to delete.');
                                }
                        }
                        
                        $('body').modalmanager('loading');
                    },
                });
            }
        });
   //------------Delete Image Ends---------------------//
   
   $(document).find(".headingOne").click(function(){
        if($(this).find("a").hasClass("collapsed")){
                    
        }else{
            //alert("hello");
            $(this).next().find(".removeEdit").trigger("click");
        }
    });
   
   
   //------------For Crop Popup---------------------//
        
   $(document).on('click','.crop-tpic',function(){
     var $themodal = $(document).find('#commonMediumModal');
            var itsId = $(this).attr('data-id');
            var itsImage = $(this).attr('data-image');
            edImgURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'cropnsave','admin'=>true)); ?>";
            edImgURL = edImgURL + '/' + itsId+ '/' + itsImage;
            $('body').modalmanager('loading');
            fetchModal($themodal,edImgURL);
        });
        
  //---------------------End-------------------------//      
        
        
        
    //------------For Multiupload image Popup---------------------//
        
         $(document).on('click','.uploadImg',function(){
     var $themodal = $(document).find('#commonSmallModal');
            var itsId = $(this).attr('data-id');
            edImgURL = "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'newupload','admin'=>true)); ?>";
            edImgURL = edImgURL + '/' + itsId;
            $('body').modalmanager('loading');
            fetchModal($themodal,edImgURL);
	    $('.no-img').css('display','none');
        });
        
     //------------------End-------------------------------//   
        
        
        
    //--------------Make Editable------------//    
        
    $(document).on('click','.unbndTgle',function(e){
	
	if($(this).hasClass("alert_error")){
	    alert('Sorry! there are no treatments for this service.');
	    return false;
	}else{
	    $(document).find('.accordion-toggle').addClass('collapsed');
	    $(document).find('.accordion-body').removeClass('in').removeClass('selected').css('height','0px');
	    var accHeading = $(this).parent().parent().parent();
	    accHeading.parent().find(".accordion-toggle").removeClass('collapsed');
	    accHeading.parent().find(".accordion-body").addClass('in').css('height','auto');
	    accHeading.parent().find(".editGallery").show();
	    $(".uploadImages").hide();
	    accHeading.next().find(".extras").addClass("editGal");
	    accHeading.next().addClass('selected');
	    accHeading.next().find('.removeEdit').show();
	    var check = accHeading.parent().find(".editGallery").prev('ul').html();
	    if(($.trim(check) == '')){
		$('.no-img').css('display','block');
		accHeading.parent().find(".editGallery").prev('ul').html('<span class="no-img">No Images Found</span>');
    
	    }
	}
        return false;
        });
    });
    //----------------------End----------------//
    
    
    
    //----------------Remove Editable----------------//
    $(document).on('click','.removeEdit',function(){
	 $(this).parent().parent().find('.editGallery').prev('ul').children('no-img').hide();
        $(this).parent().parent().parent().parent().find('.selected').removeClass( "selected" );
        $(this).parent().parent().parent().parent().find('.editGal').removeClass( "editGal" );
         $(this).parent().parent().find('.editGallery').hide();
         $(".uploadImages").show();
         $(this).hide();
    });
    //-------------------------End---------------------//
    
    
    
    
    
    //--------Select/Deselect li  ----------//
    
    
    $(document).on('click','.editGal',function(){
        $(this).closest('li').toggleClass( "selected" );
      
    });
    //------------------End-----------------------------//
    
   
    //------------------Associate Images--------------//
   
    $(document).on('click','#associateImages',function(){
       var elemnt = $(this).attr('data-id')/*.prepend('gallery_').find('li');*/
       var ele    = $("#gallery_"+elemnt+" li");
       var $theavgmodal = $(document).find('#commonSmallModal');
       selectedArr = new Array();
        var i=0;
         ele.each(function(idx, li) {
            var product = $(li);
            
            if(product.hasClass( "selected" )){
                selectedArr[i++]= $(this).attr('data-img');
            }
        });
         
       if(selectedArr==''){
            alert('Please select at least one record.');
            return false;
       }else{
    
            $.ajax({
                      url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'editTreatmentImage','admin'=>true))?>"+"/"+elemnt,
                      type: "POST",
                      data: {'image':selectedArr},
                      success: function(res) {
                        $("#commonSmallModal").html(res);
                        $('#commonSmallModal').modal('show');
                      }
            });
       }
    
    });
    
    //------------------------End--------------------------//
    
    
    //-----------------------Featured Image--------------//
    
     $(document).on('click','#featuredImage',function(){
        
       var elemnt = $(this).attr('data-id')/*.prepend('gallery_').find('li');*/
       var ele    = $("#gallery_"+elemnt+" li");
       var treatmentType = $("#treamenttype_"+elemnt).val();
       var treatmentTypeText = $("#treamenttype_"+elemnt).children("option").filter(":selected").text()
       
       if(treatmentType==''){
            alert('Please Select Treatment Type.');
            return false;
       }
        selectedArr = new Array();
        var i=0;
         ele.each(function(idx, li) {
            var product = $(li);
            
            if(product.hasClass( "selected" )){
                selectedArr[i++]= $(this).attr('data-img');
            }
        });
        if(selectedArr.length !=1){
            alert('Please select one image.');
            return false;
       }else{
         var serviceImg = selectedArr[0];
                $.ajax({
                      url: "<?php echo $this->Html->url(array('controller'=>'Services','action'=>'makeFeatured','admin'=>true))?>"+"/"+elemnt,
                      type: "POST",
                      data: {'image':serviceImg},
                      success: function(res) {
                        $("#commonSmallModal").html(res);
                        $('#commonSmallModal').modal('show');
                      }
            });
       }
      });
     //--------------------End---------------------------/
</script>
