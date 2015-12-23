<?php echo $this->element('frontend/StaticPages/enqnavigation'); ?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<div class="wrapper">
	<div class="container">
    <!--main body section starts-->
    <div class="contact">
    	<div class="fixed-rgt">
            <div class="booking-section about clearfix">
                <div class="info-details">
                    <h4 class="headding">Contact info</h4>
                    <h5>FALAK INFORMATION SERVCIES</h5>
                    <ul class="clearfix contact-details">
                        <li><i class="fa fa-map-marker"></i>
                            <span>312E-Ibn Battuta Gate Offices<br>Dubai, UAE, P.O.Box 126547</span>
                        </li>
                        <li><i class="fa fa-envelope"></i>
                            <span><a href="mailto:info@sieasta.com">info@sieasta.com</a></span>
                        </li>
                        <li><i class="fa fa-phone"></i>
                            <span>+971-44487668</span>
                        </li>
			<li><i class="fa fa-mobile-phone"></i>
                            <span>+971-529464293</span>
                        </li>
                        <li><i class="fa fa-clock-o"></i>
                            <span>Office Timings:<span> Sat-Thu: GST 9am to 6pm</span></span>
                        </li>
                        <li><i class="fa fa-globe"></i>
                            <span><a href="http://www.sieasta.com/">http://www.sieasta.com/</a></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="booking-section about chat clearfix">
            <div class="info-details">
              <h4 class="headding">Chat Live</h4>
              <ul class="clearfix contact-details">
                  <li><i class="fa  fa-comments-o"></i>
                      <span>Chat live with our customer care team. Get answers instantly.</span>
                  </li>
                  <li>
                  	<button type="button" class="purple-btn">Chat Now</button>
                  </li>
              </ul>
            </div>
           </div>
        </div>
        

        <div class="big-lft">
            <div class="map-box">
                    <div class="map" id="contctMap">
                        
                    </div>
                    <div class="caption-container">
                        <h3>FALAK INFORMATION SERVCIES</h3>
                        <p><i class="fa  fa-map-marker"></i> 312E-Ibn Battuta Gate Offices, Dubai, UAE, P.O.Box 126547</p>
                    </div>
                </div>
        </div>
        
    </div>
    <!--main body section ends-->
  </div>
</div>

<script>
    $(document).ready(function(){
        var lat     = '25.040645';
        var long    = '55.116898';
        var mapOptions = {
                zoom: 15,
                center: new google.maps.LatLng(lat, long)
        };
        var map = new google.maps.Map(document.getElementById('contctMap'),mapOptions);
        var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat,long),
                map: map
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