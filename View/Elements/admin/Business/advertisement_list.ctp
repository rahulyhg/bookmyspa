<style>
    .form-horizontal .col-sm-2 control-label {
        text-align: right;
    }
    
</style>
<div class="box-content">
<div class="box-title">
                <h2>
                    <i class="icon-table"></i>
                    Advertisements
                </h2>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_salonAd pull-right'));?>
            </div>
    <table class="table datatable table-striped table-bordered">
        <thead>
            <tr>
                    <th>English Title</th>
                    <th>English Description</th>
                    <th>No Of Clicks</th>
                    <th>Arabic Title</th>
                    <th>Arabic Description</th>
                    <th>Is Featured</th>
                    <!--<th>Status</th>-->
                    <th>Image</th>
                    <th>Video</th>
                    <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($ads)){
               foreach($ads as $adsValue){ ?>
                   <tr data-id="<?php echo $adsValue['SalonAd']['id']; ?>" >
                       <td><?php echo $adsValue['SalonAd']['eng_title']; ?></td>
                       <td><?php echo $adsValue['SalonAd']['eng_description']; ?></td>
                       <td><?php echo $adsValue['SalonAd']['no_of_click']; ?></td>
                       <td><?php echo $adsValue['SalonAd']['ara_title']; ?></td>
                       <td><?php echo $adsValue['SalonAd']['ara_description']; ?></td>
                       <td>
                           <span class="check_alert"> 
                          <?php 
                          $featured_status = ($adsValue['SalonAd']['is_featured'])?true:false;
                          $disabled='';
                          $plan='';
                           if($plan =='No Plan' || !empty($plan)){
                                 $disabled=FALSE;  
                                 $plan='No Plan';
                           }else{
                                 $disabled=TRUE;
                                 $plan=$plan;
                           }                                       
                          echo $this->Form->input('is_featured', array('disabled'=>$disabled,'checked'=>$featured_status,'data-active-id'=>$adsValue['SalonAd']['id'],'class'=>'custom_switch','hiddenField'=>false,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini','class'=>'alert_show','data-plan'=>$plan)); ?>					
                        </span> 
                       </td>
                       <!--<td><?php //echo $this->Common->theStatusImage($adsValue['SalonAd']['status']); ?></td>-->
                       <td><?php echo $this->Html->Image('/images/'.$uid.'/SalonAd/150/'.$adsValue['SalonAd']['image']); ?></td>
                       <td>
                       <?php
                           if($this->common->getYoutubeThumb($adsValue['SalonAd']['url'])){ ?>
                           <a href="#"><?php echo $this->Html->Image($this->common->getYoutubeThumb($adsValue['SalonAd']['url'])); ?></a>
                                   <div class="extras">
                                           <div class="extras-inner">
                                             <?php  $url = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","http://www.youtube.com/embed/$1?rel=0&amp;wmode=transparent",$adsValue['SalonAd']['url']); ?>
                                                           <a href="<?php echo $this->Html->url($url); ?>" class='youtube' rel="group-1"><i class="icon-search"></i></a>
                                           </div>
                                   </div>
                   <?php
                       } 
                    ?>
                       </td>
                       <td>
                                                   <?php echo $this->Html->link('<i class="icon-pencil"></i>','javascript:void(0);', array('data-id'=>$adsValue['SalonAd']['id'],'title'=>'Edit','class'=>'addedit_salonAd','escape'=>false) ) ?>
                           &nbsp;&nbsp;
                                                   <?php echo $this->Html->link('<i class=" icon-trash"></i>','javascript:void(0);', array('title'=>'Delete','class'=>'delete_salonAd','escape'=>false)); ?>
                       </td>
                   </tr>    
           <?php }
           }?>
           <input type="hidden" id="user-id" value="<?php echo $uid; ?>">
        </tbody>
        <tfoot>
            <tr>
                 <th>English Title</th>
                    <th>English Description</th>
                    <th>No Of Clicks</th>
                    <th>Arabic Title</th>
                    <th>Arabic Description</th>
                    <th>Is Featured</th>
                    <!--<th>Status</th>-->
                    <th>Image</th>
                    <th>Video</th>
                    <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    $(document).ready(function() {
        var itsId = "";
        $(document).on('click', '.addedit_salonAd', function() {
            var itsId = $(this).attr('data-id');
            var userViewId = $("#user-id").val();
            var $bigmodal = $('#commonContainerModal');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Business','action'=>'addeditAds')); ?>";
            addeditURL = addeditURL + '/' + itsId + '?userViewId=' + userViewId
            // function in modal_common.js
            fetchModal($bigmodal, addeditURL);
        });

        $(document).on('click', '.delete_salonAd', function() {
            var itsId = $(this).closest('tr').attr('data-id');
            $this = $(this);
            if (confirm(' Are you sure, you want to delete this Salon Advertisement ? ')) {
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller'=>'SalonAds','action'=>'deleteAd')); ?>",
                    type: 'POST',
                    data: {'id': itsId}
                }).done(function(response) {
                    $this.closest('tr').remove();
                });
            }
        });
        $modal = $('#commonContainerModal');
        $modal.on('click', '.update', function(e) {
            var options = {
                //beforeSubmit:  showRequest,  // pre-submit callback 
                success: function(res) {
                    // onResponse function in modal_common.js
                    if (onResponse($modal, 'SalonAd', res)) {
                       window.location.reload();
                    }
                }
            };
            $('#SalonAdAdminAddeditAdsForm').submit(function() {
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });

        //Is Featured
        $("[name='data[is_featured]']").bootstrapSwitch();

        $('.alert_show').parent('.bootstrap-switch-container').parent('.bootstrap-switch').parent('span.check_alert').on('click', function(){
                   if($(this).find('input[name="data[is_featured]"]').data('plan')=='No Plan' || $(this).find('input[name="data[is_featured]"]').data('plan')==''){                             
                               alert('Please Upgrade your plan to make advertisement featured!!');                            
                   }                             
               })

        $('input[name="data[is_featured]"]').on('switchChange.bootstrapSwitch', function(event, state){
                        //console.log(this); // DOM element
                        //console.log(event); // jQuery event
                        //console.log(state); // true | false
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