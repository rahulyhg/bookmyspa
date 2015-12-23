<div class="breadcrumb">
        <?php
              $user_type=$user['User']['type'];
              if($user_type == 4){
                  $user_type_text="Individual Salon";
              }else if($user_type == 2){
                  $user_type_text="Frenchise";
              }else if($user_type == 3){
                  $user_type_text="Multiple Location";
              }
              $logged_in_user_type = $this->Session->read('Auth.User.type');
              if($logged_in_user_type == 1){
                  $this->Html->addCrumb("Business", array('controller' => 'Business', 'action' => 'list', 'admin' => true)) ; 
              }else{
                  $this->Html->addCrumb("Business", array('controller' => 'Salons', 'action' => 'index', 'admin' => true)) ; 
              }
              $this->Html->addCrumb($user_type_text.' ( ' .$user['Salon']['eng_name'] .' ) ', '#') ; 
              $this->Html->addCrumb('View' ,  'javascript:void(0);' , array('class' => 'breadcrumbs')); 

//              if(isset($businessOwner['Salon']['eng_name']) && !empty($businessOwner['Salon']['eng_name'])){
//              $this->Html->addCrumb($businessOwner['Salon']['eng_name'],  
//                      array('controller' => 'Business', 
//                          'action' => 'view', 
//                          'admin' => true, 
//                          'bview' => base64_encode(base64_encode($businessOwner['User']['id']) . '-CODE-' . $businessOwner['User']['username'])
//                          )
//                      ) ; 
//             
//              }
              echo $this->Html->getCrumbs(' <i class="icon-angle-right"></i> ', 'Home');
         ?>
</div>
<?php

echo $this->Html->css('admin/plugins/tagsinput/jquery.tagsinput.css');
echo $this->Html->script('admin/plugins/tagsinput/jquery.tagsinput.min.js');
echo $this->Html->css('admin/plugins/select2/select2');
echo $this->Html->script('admin/plugins/select2/select2.min.js');
echo $this->Html->css('datepicker/datepicker-css');
echo $this->Html->script('datepicker/datepicker-js');
echo $this->Html->script('admin/jquery.geocomplete.js');
?>
<!-- gmap -->
<?php echo $this->Html->css('admin/plugins/gmap/gmap3-menu'); ?>
<!-- gmap -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>  
<?php
echo $this->Html->script('admin/plugins/gmap/gmap3.min.js');
echo $this->Html->script('admin/plugins/gmap/gmap3-menu.js');
?>

<div class="row">
    <div class="col-sm-12">
        <div class="cover">
            <?php                   
                if(isset($user['Salon']['cover_image']) && !empty($user['Salon']['cover_image']) ){
                    echo $this->Html->image("/images/".$user['User']['id']."/Salon/1423/".$user['Salon']['cover_image'],array('data-id'=>$user['User']['id']));
                }else{
                    echo '<img src="/img/cover-bckend.jpg" alt="" title="" />';
                }
             ?>
            <?php
                 echo $this->Form->input('Salon.cover_image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'class'=>'theImage'));
            ?>
            <div class="edit-icon">
                <?php  echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);',array('data-id'=>base64_encode($user['User']['id']),'escape'=>false,'class'=>'addedit_Business pull-right'));?>
            </div>
            <div class="profile-sec">
                <div class="profile-img">
                    <?php if(isset($user['User']['image']) && !empty($user['User']['image']) ){
                          echo $this->Html->image("/images/".$user['User']['id']."/User/150/".$user['User']['image'],array('width'=>'100','height'=>'100','data-id'=>$user['User']['id'],'class'=>'imageView'));
                      }else{
                          echo $this->Html->image("admin/upload2.png",array('width'=>'100','height'=>'100','class'=>'upUImg imageView','data-id'=>$user['User']['id']));
                      }?>
                      <?php
                      echo $this->Form->input('image',array('style'=>'display:none;','type'=>'file','div'=>false,'label'=>false,'class'=>'theImage'));
                      ?>
                    <div class="edit-icon">
                        <a  href="javascript:void(0);" escape="false" class="editUImg" data-id="<?php echo $user['User']['id']; ?>" >
                            <i class="fa fa-pencil"></i>
                        </a>                  
                        <a  href="javascript:void(0);" escape="false" class="deleteUImg" data-id="<?php echo $user['User']['id']; ?>" >
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </div>
                    <div class="delete-icon">
                       <?php // echo  $this->Html->link(__('<i class="fa fa-trash"></i>'),'javascript:void(0);',array('data-id'=>$user['User']['id'],'class'=>'deleteUImg')); ?>
                    </div>
                </div>
                <div class="description">
                    <h1>
                       <?php
                          if( !empty($user['Salon']['eng_name'])){
                            echo $user['Salon']['eng_name'];
                          }else{
                            echo '-';
                          }
                       ?>
                    </h1>
                    <p class="location"><i class="fa  fa-map-marker"></i>
                        <?php echo $user['Address']['address'].','.$user['Address']['po_box']; ?>
                    </p>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="vendor-deal-sec business-list">
            <?php  echo $this->element('admin/Business/all_details'); ?>
        </div>
        <script>
            var userId = '<?php echo base64_encode($user['User']['id']); ?> ';
            var addbusinessURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'create','admin'=>true)); ?>";
            var businessList = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'list','admin'=>true)); ?>";

            $(document).ready(function(){
//                $(document).find('#commonContainerModal')
                var $modal = $('#commonContainerModal');
               /**************************************************************************/    
                    $modal.on('click', '.submitSelectForm', function(e){
                    var options = {
                        //beforeSubmit:  showRequest,  // pre-submit callback 
                        success: function(res) {
                            // onResponse function in modal_common.js
                            if(onResponse($modal, 'ServiceSalon', res)){
                               window.location.reload();
                            }
                        }
                    };
                    $('#serviceSelectForm').submit(function(){
                        $(this).ajaxSubmit(options);
                        $(this).unbind('submit');
                        $(this).bind('submit');
                        return false;
                    });
                    
                });

                
                var itsId = "";       
                if("<?php echo @$_GET['service']?>"){
                    uid  = "<?php echo @$_GET['service']; ?>"; 
                    chk  = "<?php echo $this->Common->checkServiceStatus(@$_GET['service']);?>";
                    // alert(chk);
                    if(chk == 0){
                        serviceurl ="<?php echo $this->Html->url(array('controller'=>'Services','action'=>'select_service' ,'admin'=>true));?>"; 
                        addediturl = serviceurl+'/0/'+uid;
                        fetchModal($modal,addediturl);
                     }
                }
                /**************************************************************************/
                
                $(document).on('click', '.addedit_Business', function(){
                    itsId = $(this).attr('data-id');
                    addbusinessURLNew = addbusinessURL + '/' + itsId;
                    if (itsId) {
                        addbusinessURLNew += '/salon';
                    }
                    // function in modal_common.js
                    fetchModal($modal,addbusinessURLNew);
                });
                $modal.on('click', '.submitBusiness', function(e) {
                    var options = {
                        //beforeSubmit:  showRequest,  // pre-submit callback 
                        success: function(res) {
                            // onResponse function in modal_common.js
                            if (onResponse($modal, 'User', res)) {
                                var userDetailURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'view')); ?>";
                                userDetailURL = userDetailURL + '/' + itsId
                                $(document).find(".businessdataView").load(userDetailURL, function() {
                                });
                            }
                        }
                    };
                    $('#BusinessCreateForm').submit(function(){
                        $(this).ajaxSubmit(options);
                        $(this).unbind('submit');
                        $(this).bind('submit');
                        return false;
                    });
                    
                });

                $modal.on('hide.bs.modal', function(e) {
                    $modal.find("#map1").gmap3('destory');
                });

                $(document).find('.editDeleteImg , .imageView img').mouseover(function() {
                    if (!$(this).hasClass('upUImg')) {
                        $(document).find('.editDeleteImg').show();
                    }
                }).mouseout(function() {
                    $(document).find('.editDeleteImg').hide();
                });
                var userId = ''
                //    $(document).find('.editUImg , .upUImg').click(function(){
                //        userId = $(this).attr('data-id');
                //        
                //        $('body').find('.theImage').trigger('click');
                //    });
                $(document).on('click', '.editUImg , .upUImg', function() {
                    userId = $(this).attr('data-id');
                    $(this).parent().prev().click();
                });

                $(document).find('.deleteUImg').click(function() {
                    userId = $(this).attr('data-id');
                    $.ajax({
                        url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'delete_image','admin'=>true))?>",
                        type: "POST",
                        data: {id: userId},
                        success: function(res) {
                            if (res != 'f') {
                                $(document).find('.imageView img').attr('src', '/img/admin/upload2.png').addClass('upUImg');
                            } else {
                                alert('Error in Deleting Image. Please try again!');
                            }
                        }
                    });
                });

                $(document).on('change', ".theImage", function(e) {
                    e.preventDefault();
                    file = this.files[0];
                    var obj = $(this);
                    if (file == undefined) {
                        var msg = 'Please select an image.'
                    }
                    else {
                        name = file.name;
                        size = file.size;
                        type = file.type;
                        if (file.name.length < 1) {
                            var msg = 'Please select an image.'
                            alert(msg);
                        }
                        else if (file.size > 1500000) {
                            obj.prev().val('');
                            var msg = 'File is toobig.'
                            alert(msg);
                        }
                        else if (file.type != 'image/png' && file.type != 'image/jpg' && !file.type != 'image/gif' && file.type != 'image/jpeg') {
                            obj.prev().val('');
                            var msg = 'File doesnt match png, jpg or gif extension.'
                            alert(msg);
                        } else {
                            var formdata = new FormData();
                            formdata.append('image', file);
                            obj.prev().val('');
                            $.ajax({
                                url: "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'upload_image','admin'=>true))?>" + "/" + userId,
                                type: "POST",
                                data: formdata,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    if (res != 'f') {
                                        $(document).find('.imageView').attr('src', '/images/' + userId + '/User/150/' + res).removeClass('upUImg');
                                    } else {
                                        alert('Error in Uploading Image. Please try again!');
                                    }
                                }
                            });

                        }
                    }
                });

            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.changeStatus', function() {
                    var theJ = $(this);
                    var theId = theJ.closest('tr').attr('data-id');
                    var statusTo = theJ.attr('data-status');

                    $.ajax({
                        type: "POST",
                        url: "<?php echo $this->Html->url(array('controller'=>'business','action'=>'changeStatus','admin'=>true));?>",
                        data: {id: theId, status: statusTo}
                    })
                            .done(function(msg) {
                                if (msg == 0) {
                                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                                }
                                else {
                                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                                }
                            });
                });
                $modal.on('change','#UserImage',function(){
                    file = this.files[0];
                    var obj = $(this);
                    var valReturn = validate_image(file);
                    if(valReturn){
                        obj.val('');
                        bootbox.alert(valReturn);
                    }
                        
                });
                 $modal.on('change','#SalonCoverImage',function(){
                    file = this.files[0];
                    var obj = $(this);
                    var valReturn = validate_image(file);
                    if(valReturn){
                        obj.val('');
                        bootbox.alert(valReturn);
                    }
                        
                });
              
              
              
                
              });
            
    function validate_images(file){
//    console.log('herere');
    fileInput = '#'+$(file).attr('id');
//    console.log($fileInput);
 if (file.files && file.files[0]) {
               var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = new Image;
                        img.onload = function() {
                        var imageheight = img.height;
                        var imageWidth = img.width;
//                        if(imageheight >=  imageWidth)
//                        {
//                              $(document).find(fileInput).val('');
//                              $(document).find(fileInput).after($(fileInput).clone(true)).remove();
//                              $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
////                            $fileInput.replaceWith( $fileInput = $fileInput.clone( true ) );
//                            var msg = 'Image should be landscape.'
//                            bootbox.alert(msg);
//                            return msg;
//                        }
                        //for cover image
                        if(fileInput == '#SalonCoverImage')
                        {
                            if(imageWidth < 1423)
                            //if(imageheight != 476 || imageWidth != 1423)
                            {
                                    $(document).find(fileInput).val('');  
                                    $(document).find(fileInput).after($(fileInput).clone(true)).remove();
                                    //$(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
                                    //var msg = 'Height and width of file should be 476 * 1423.'
                                    var msg = 'Minimum width of file should be 1423.'
                                    bootbox.alert(msg);
                                    return msg;
                            }
                        }
                        //end
                       /* else if(imageheight < 310 || imageWidth < 554)
                        {
                             $(document).find(fileInput).val('');  
                            $(document).find(fileInput).after($(fileInput).clone(true)).remove();
                            $(document).find(fileInput).closest('.previewInput').prev('.preview').html('');
//obj.prev().val('');
//                             $(fileInput).replaceWith( $(fileInput) = $(fileInput).clone( true ) );
                            var msg = 'Minimum height and width of file should be 310 * 554.'
                            bootbox.alert(msg);
                            return msg;
                        }*/else{
                            $(document).find(fileInput).closest('.previewInput').prev('.preview').html('<img src='+e.target.result+' width="200" height="150" />');
                        }
                      };
                      img.src = reader.result;
                    };
                    reader.readAsDataURL(file.files[0]);
        }
}
            
        </script>
<?php //pr($user); ?>
