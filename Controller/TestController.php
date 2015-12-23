<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');


/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class TestController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
 function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('mandrilltest');
    }

function  mandrilltest(){
     App::import('Vendor','/mandrill/Mandrill');
     $mandrill = new Mandrill('8AkmVSTShAQKoPTuF_qZUg');
    // $result = $mandrill->users->info();
    $message = array(
        'html' => '<p>Example HTML content</p>',
        'text' => 'Example text content',
        'subject' => 'example subject',
        'from_email' => 'sieasta.sdei@gmail.com',
        'from_name' => 'Example Name',
        'to' => array(
            array(
                'email' => 'sanjeev.smartdata@gmail.com',
                'name' => 'Sanjeev',
               )
        ),
        'headers' => array('Reply-To' => 'sieasta.sdei@gmail.com')
	);
        
    $async = false;
    $ip_pool = 'Main Pool';
    $send_at = '2015-12-10 06:45:45';
    $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
    print_r($result);
    
   exit;

}
    function memegen_build_image( $args = array() ) {

list( $width, $height ) = getimagesize( $args['memebase'] );

// $args['linespacing'] = intval( $args['linespacing'] );
// if ( count( $args['text'] ) < 2 ) $args['linespacing'] = 0;

$args['textsize'] = empty( $args['textsize'] ) ? round( $height/10 ) : $args['textsize'];

extract( $args );

// alright, lets make an image
$im = imagecreatefromjpeg( $args['memebase'] );

// make base image transparent
$black = imagecolorallocate( $im, 0, 0, 0 );
imagecolortransparent( $im, $black );

$textcolor = imagecolorallocate( $im, 255, 255, 255 );

$angle = 90;
/*
$boxes = array(); // text box boundaries

// we're stacking multiple lines - get the total height
$total_textbox_height = 0;
foreach( $text as $t ) {
// https://gist.github.com/trepmal/7940059
$_box = imageftbbox( $textsize, $angle, $font, $t );
$boxes[] = $_box;

$total_textbox_height += $_box[3] - $_box[5] + $linespacing;
}

// now go back through each line, and place it on the image
$tth = $total_textbox_height;
foreach ( $text as $k => $t ) {
$_box = $boxes[ $k ]; // our bounding boxes were calculated above, just retrieve them

$box_width = $_box[4] - $_box[6];
$box_height = $_box[3] - $_box[5] + $linespacing;
$tth -= $box_height;

$from_side = ($width - $box_width)/2;
// magic math to get vertical centering
$from_top = ($height + $total_textbox_height)/2 - $tth - $linespacing/2;

// add text to image
// imagealphablending($im, true); // must be set to make sure font renders properly
imagettftext( $im, $textsize, $angle, $from_side, $from_top, $textcolor, $font, $t );

}
*/

$top_text = strtoupper( trim( $args['top_text'] ) );
$bottom_text = strtoupper( trim( $args['bottom_text'] ) );

$fit = isset( $textfit ) ? $textfit : true;

// top layer text
extract( memegen_font_size_guess( $textsize, ($width-$padding*2), $font, $top_text, $fit ) );
$from_side = ($width - $box_width)/2;
$from_top = $box_height + $padding;
// imagettftext( $im, $textsize, $angle, $from_side, $from_top, $textcolor, $font, $top_text );
memegen_imagettfstroketext( $im, $fontsize, $angle, $from_side, $from_top, $textcolor, $black, $font, $top_text, 1 );

// bottom layer text
extract( memegen_font_size_guess( $textsize, ($width-$padding*2), $font, $bottom_text, $fit ) );
$from_side = ($width - $box_width)/2;
$from_top = $height - $padding;
// imagettftext( $im, $textsize, $angle, $from_side, $from_top, $textcolor, $font, $bottom_text );
memegen_imagettfstroketext( $im, $fontsize, $angle, $from_side, $from_top, $textcolor, $black, $font, $bottom_text, 1 );
//echo "here1234";die;
// output
//echo $filename;die;
header('Content-Type: image/jpeg');
header('Content-Disposition: filename="Map.gif"');
//e/cho $filename;die;
imagejpeg( $im );
imagedestroy( $im );

}

/**
* Font size guess
*
* Check if font box is too big for image and reduce recursively as needed till it does
*
* @param int $fontsize
* @param int $imwidth
* @param string $font TTF
* @param string $text
* @param bool $fit Try and fit text to image
* @return array Font size, font box width, font box height
*/
function memegen_font_size_guess( $fontsize, $imwidth, $font, $text, $fit ) {

$angle = 0;

$_box = imageftbbox( $fontsize, $angle, $font, $text );
$box_width = $_box[4] - $_box[6];
$box_height = $_box[3] - $_box[5];

if ( $box_width > $imwidth && $fit ) {

// $sub = round( ( $box_width - $imwidth) * .08, 0, PHP_ROUND_HALF_DOWN );
// if ( $sub < 1 ) $sub = 1;
$sub = 1;
$fontsize = $fontsize - $sub;

return memegen_font_size_guess( $fontsize, $imwidth, $font, $text, $fit );

}

return compact( 'fontsize', 'box_width', 'box_height' );

}

/**
* Writes the given text with a border into the image using TrueType fonts.
* http://www.johnciacia.com/2010/01/04/using-php-and-gd-to-add-border-to-text/
* @author John Ciacia
* @param image An image resource
* @param size The font size
* @param angle The angle in degrees to rotate the text
* @param x Upper left corner of the text
* @param y Lower left corner of the text
* @param textcolor This is the color of the main text
* @param strokecolor This is the color of the text border
* @param fontfile The path to the TrueType font you wish to use
* @param text The text string in UTF-8 encoding
* @param px Number of pixels the text border will be
* @see http://us.php.net/manual/en/function.imagettftext.php
*/
function memegen_imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {

for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
$bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}

/**
* Sanitize
*
* Replace non-alphanumeric characters with hyphens
* Reduce any multihyphens down to one
*
* @param string $input
* @return string $input
*/
function memegen_sanitize( $input ) {
$input = preg_replace( '/[^a-zA-Z0-9-_]/', '-', $input );
$input = preg_replace( '/--*/', '-', $input );
return $input;
}
function index(  ) {
    if(isset( $_GET['top_text'])){
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
    }
}

function testgi(){
       
}

}
