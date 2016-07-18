<?php

/**
 * EXAMPLE OF USE:
 * http://sergiocardoso.org/phpicture/sergio.png - display only the image
 * http://sergiocardoso.org/phpicture/sergio-w:10-h:20.png - display thumb with 10 pixel of width and 10 pixel of height
 * http://sergiocardoso.org/phpicture/sergio-f:jpg-q:9.png - display thumb in jpg format and 9 of compression quality
 */

require_once 'vendor/autoload.php';

try {

	$basename = basename($_GET['v']);
	$pict = \PHPicture\Core\PHPicture::getInstance();
	$cache = new \PHPicture\Core\PHPCache($basename);

} catch(Exception $e){
	$e->errorMessage();
}
