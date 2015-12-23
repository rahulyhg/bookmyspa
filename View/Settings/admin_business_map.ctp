<style>
    #map_here img{max-width:none; !important;}
</style>
<div class="modal-dialog vendor-setting">
    <?php echo $this->Form->create('Address', array('url' => array('controller' => 'Settings', 'action' => 'business_map','admin'=>true),'id'=>'locationbtnForm','novalidate'));?>  
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
            <h2>Pin your location</h2>
        </div>
        <div class="modal-body clearfix">
            <?php echo $this->Form->hidden('Address.id',array('label'=>false,'div'=>false));?>
            <?php echo $this->Form->hidden('Address.user_id',array('label'=>false,'div'=>false));?>
            <?php echo $this->Form->hidden('Address.latitude',array('label'=>false,'div'=>false));?>
            <?php echo $this->Form->hidden('Address.longitude',array('label'=>false,'div'=>false));?>
            <div class="col-sm-12 nopadding">
                <div class="box">
                    <div class="box-content form-horizontal nopadding">
                        <div id="map-here" style="height: 250px">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer pdng20">
            <div class="col-sm-3 pull-right nopadding">
                <input type="submit" name="next" class="locationbtnForm btn btn-primary" value="Continue" />
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<?php
    echo $this->Html->script('admin/plugins/gmap/gmap3.min.js');
    echo $this->Html->script('admin/plugins/gmap/gmap3-menu.js');
?>
<script>
    Custom.init();
    function updateMarker(marker){
        var latLng = marker.getPosition();
        document.getElementById('AddressLatitude').value = latLng.lat();
        document.getElementById('AddressLongitude').value = latLng.lng();
    }
    $(document).ready(function(){
        
       
        var zoomlevel = 12;
        var lat    = 0;
        var long   = 0;
        <?php if(isset($this->data['Address']) && !empty($this->data['Address'])){
            if(isset($this->data['Address']['latitude']) && !empty($this->data['Address']['latitude'])){ ?>
                lat    = <?php echo $this->data['Address']['latitude']; ?>;
                long   = <?php echo $this->data['Address']['longitude']; ?>;
            <?php 
            }
            else{ ?>
            
                var showAddress =  "";
                <?php
                if(isset($this->data['Address']['address']) && !empty($this->data['Address']['address'])){ ?>
                showAddress =  '<?php echo $this->data['Address']['address']; ?>';
                <?php } ?>
                <?php
                if(isset($this->data['City']['city_name']) && !empty($this->data['City']['city_name'])){ ?>
                showAddress =  showAddress+', <?php echo $this->data['City']['city_name']; ?>';
                <?php } ?>
                <?php
                if(isset($this->data['State']['name']) && !empty($this->data['State']['name'])){ ?>
                showAddress =  showAddress+', <?php echo $this->data['State']['name']; ?>';
                <?php } ?>
                <?php
                if(isset($this->data['Country']['name']) && !empty($this->data['Country']['name'])){ ?>
                showAddress =  showAddress+', <?php echo $this->data['Country']['name']; ?>';
                <?php } ?>
                
                <?php
                }
            } ?>
              $('#map-here').gmap3('destroy');
             setTimeout(function(){
            
            if(lat){
          
                $("#map-here").gmap3({
                    map:{
                        options:{
                            center:[lat,long],
                            zoom:zoomlevel
                        }
                    },
                    marker:{
                        options:{draggable:true},
                        values:[
                            {latLng:[lat,long], data:" "},
                        ],
                        events:{
                            dragend: function(marker){
                                updateMarker(marker);
                            },
                        }
                    }
                });
            }
            else{
               
                $("#map-here").gmap3({
                    marker:{
                        address: showAddress,
                        options:{draggable:true},
                        events:{
                            dragend: function(marker){
                                updateMarker(marker);
                            },
                        },
                        callback: function(marker){
                            updateMarker(marker);
                        }
                    },
                    map:{
                        options:{
                            zoom: zoomlevel
                        }
                    }
                });
            }
        }, 1000);
        
    });
</script>
