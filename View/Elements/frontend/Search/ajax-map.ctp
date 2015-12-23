
<div id="effectMap_<?php echo $user['User']['id']; ?>"  class=" clearfix map-view">
    <input type="text" style="display: none;" id="location" value="<?php echo $user['Address']['latitude'] ?>,<?php echo $user['Address']['longitude']; ?>">
    <h2 class="share-head">
            Map View
    <a id="<?php echo $user['User']['id']; ?>" href="javascript:void(0)" class="cross close-this"><img  src="/img/cross.png" alt="" title=""></a>
    </h2>
    <div class="deal-box-outer">
        <div style="height: 280px" id="map_<?php echo $user['User']['id']; ?>"></div>
    </div>
</div>
<script>
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places;&callback=loadMView";
    document.getElementsByTagName('body')[0].appendChild(script);


    function loadMView(){
	var lat     = <?php echo $user['Address']['latitude'] ?>;
	var long    = <?php echo $user['Address']['longitude']; ?>;
	var mapOptions = {
		zoom: 15,
		center: new google.maps.LatLng(lat, long)
	};
	
	var map = new google.maps.Map(document.getElementById('map_'+<?php echo $user['User']['id']; ?>),mapOptions);
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat,long),
		map: map
	});
    }
</script>