<?php

namespace PHPicture\Core;

Class PHPictureException extends \Exception {

	public function errorMessage(){

		$message = parent::getMessage();
		$font = realpath(dirname(__FILE__)).'/../Fonts/Lato-Bold.ttf';

		$image = imagecreatetruecolor(600,100);
		$red = imagecolorallocate($image, 255, 0, 0);
		$white = imagecolorallocate($image, 255, 255, 255);

		imagettftext($image, 13, 0, 10, 30, $red, $font, 'PHPicture Error');
		imagettftext($image, 15, 0, 10, 60, $white, $font, $message);

		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);

	}
}