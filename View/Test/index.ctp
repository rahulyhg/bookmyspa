<?php
if ( ! isset( $_GET['top_text'] ) && ! isset( $_GET['bottom_text'] ) ) {
    
?>
<form>
<p>Top text:<br /><input name="top_text" /></p>
<p>Bottom text:<br /><input name="bottom_text" /></p>
<p><input type="submit" /></p>
</form>
<img src="Map.gif" />
<?php
//die();
}

$top_text = isset( $_GET['top_text'] ) ? $_GET['top_text'] : 'Damnit Jim, I\'m a doctor one two';
$bottom_text = isset( $_GET['bottom_text'] ) ? $_GET['bottom_text'] : 'Not a plumber';
//$filename = memegen_sanitize('Map.gif');
//print_r($filename);die;
$args = array(
'top_text' => $top_text,
'bottom_text' => $bottom_text,
'filename' => 'Map.gif',
//
'font' => dirname(__FILE__) .'/Anton.ttf',
'memebase' => dirname(__FILE__) .'/Map.gif',
'textsize' => 40,
'textfit' => true,
'linespacing' => 0,
'padding' => 10,
);

memegen_build_image( $args );
?>
