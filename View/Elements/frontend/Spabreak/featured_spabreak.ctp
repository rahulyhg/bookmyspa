<?php //echo $loc;  ?>
<?php //echo $info;  ?>
<script>
    $(document).ready(function(){
        var $sModal = $(document).find('#mapSalonStylist');
        $(document).on('click','.largeMapStylist',function(e){
            $sModal.modal('show');
            setTimeout(function(){
                map_initialize(); 
            },500);
        });
    });
    function map_initialize(){
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap',
                zoom: 2,
                center: new google.maps.LatLng(-33.92, 151.25),
        };

        // Display a map on the page
        map = new google.maps.Map(document.getElementById("mapAllSalon"), mapOptions);
        map.setTilt(45);
        // Multiple Markers
        var markers = [<?php echo $loc;  ?>];
        var infoWindowContent = [<?php echo $info;  ?>];
        //alert(infoWindowContent);
        // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;

        // Loop through our array of markers & place each one on the map  
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
            });

            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }   
    }
</script>
<?php
        echo  $this->Paginator->options(array(
        'update' => '.v-middle-side',
        'evalScripts' => true
    ));
?>   
	<div class="booking-section clearfix">
            <h2 class="share-head">
            	<?php echo __('SpaBreaks' , TRUE); ?>
            </h2>
            <div class="deal-box-outer col-sm-12 clearfix">
            	<?php 
                //echo "spabreaks : ".count($allSpabreaks);
                //pr($allSpabreaks);  //die();
                //echo $criteria;
                if(!empty($allSpabreaks)){
                    $i=1;  
                    foreach($allSpabreaks as $break){
                ?> 
                    <div class="big-deal<?php echo ($i%2==0)?'mrgn-rgt0':'';?>">
                        <div class="photo-sec">
                            <?php 
                                if(!empty($break['SalonSpabreakImage'])){
                                        echo $this->Html->image($this->Common->getspabreakImage($break['SalonSpabreakImage'][0]['spabreak_id'],$break['SalonSpabreakImage'][0]['created_by'],350),array('class'=>" ")); 
                                }else{
                                    echo $this->Html->image('admin/treat-pic.png', array('alt' => 'image'));
                                }
                            ?>
                        </div>
                        <div class="detail-area">
                            <div class="heading">
                                <?php echo (!empty($break['Spabreak'][$lang.'_name']))?$break['Spabreak'][$lang.'_name']:$break['Spabreak']['eng_name']; ?>
                            </div>
                            <div class="add">
                                <?php echo (!empty($break['Salon'][$lang.'_name']))?$break['Salon'][$lang.'_name']:$break['Salon']['eng_name']; ?>
                                <span>
                                    <i class="fa fa-map-marker"></i> 
                                    <?php echo $this->Common->get_SalonAddress($break['User']['id']);?>
                                </span>
                            </div>
                            <div class="clearfix">
                                <?php
                                    $service_name = (!empty($break['Spabreak'][$lang.'_name']))?$break['Spabreak'][$lang.'_name']:$break['Spabreak']['eng_name'];
                                    $business_url = $this->frontCommon->getBusinessUrl($break['User']['id']);
                                    if(!empty($business_url)){
                                            if(!empty($service_name))
                                                    $service_name_book = str_replace(' ','-',trim($service_name));
                                            else
                                                    $service_name_book = '';
                                            $link_book = '/'.$business_url.'-spabreak/'.@$service_name_book.'-'.base64_encode($break['Spabreak']['id']);
                                    } else {
                                            $link_book = '/#';
                                    }
                                    
                                    echo $this->Html->link('<button class="book-now" type="button">Book Now</button>',
                                            $link_book,
                                            array('escape'=>false,'class'=>'salon-book-now')
                                    );
                                ?>
                                <div class="dutation-time">
                                    <div class="big-price">
                                        <?php
                                            $spaBreakPrice = $this->Common->get_spabreakPrice($break['Spabreak']['id']);

                                            if($spaBreakPrice['from']){
                                                echo 'from AED '.$spaBreakPrice['full'].'';
                                            }
                                            elseif($spaBreakPrice['sell']){
                                                echo '<span class="fullPrice" >AED'.$spaBreakPrice['full'].' </span><b> AED '.$spaBreakPrice['sell'].'</b>';
                                            }
                                            else{
                                                echo 'AED '. $spaBreakPrice['full'];
                                            }

                                        ?>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $i++; }}else{ ?>
            <div><?php echo __('No Results Found'); ?></div>
            <?php } ?>
        </div>
</div>

<nav class="pagi-nation">
    <?php if($this->Paginator->param('pageCount') > 1){
            echo $this->element('pagination-frontend');
            echo $this->Js->writeBuffer();
    } ?>
</nav>