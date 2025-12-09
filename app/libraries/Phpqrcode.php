<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
include APPPATH.'third_party/phpqrcode/phpqrcode.php'; 
 
class Phpqrcode 
{
    public static function png($text, $outfile=false, $level=QR_ECLEVEL_L, $size=3, $margin=0, $saveandprint=false)    
	{   
		$enc = QRencode::factory($level, $size, $margin);   
		return $enc->encodePNG($text, $outfile, $saveandprint=false);   
	}  
}