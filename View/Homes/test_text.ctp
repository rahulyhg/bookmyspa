   <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--  <div class="fb-post" data-href="https://www.facebook.com/video.php?v=665365073583644" data-width="500"></div>-->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<?php  




$abc = "<p>here are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.<br />
<br />
https://twitter.com/MCFC/status/527615650022170624 <br />
<br />
or<br />
<br />
https://www.facebook.com/video.php?v=665365073583644   <br />
<br />
testing string<br/>
<br />
<br />
mbarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
";
//$rep_link_twitter = '<blockquote class="twitter-tweet"><a href="https://twitter.com/NSDCINDIA" target="_blank" rel="nofollow"></a></blockquote>';   
//$newdata =  str_replace("https://twitter.com/NSDCINDIA",$rep_link_twitter,$abc);
//echo $newdata; die;



$regex = '/https?\:\/\/[^\" ]+/i';
preg_match_all($regex, $abc, $matches);
foreach($matches[0] as $match){
$url =  parse_url($match);
$host =  $url['host'];
 if($host == 'www.facebook.com' ||$host =='facebook.com' ){
    $rep_link_fb = '<div class="fb-post" data-href="'.$match.'" data-width="500"></div>';
    $abc =   str_replace($match,$rep_link_fb,$abc);
   }elseif($host=='twitter.com' ||$host=='www.twitter.com'){
    $rep_link_twitter = '<blockquote class="twitter-tweet"><a href="'.$match.'" target="_blank" rel="nofollow"></a></blockquote>';   
    $abc =  str_replace($match,$rep_link_twitter,$abc);
 }
}
echo $abc;
?>

