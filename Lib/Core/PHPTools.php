<?php

namespace PHPicture\Core;

Trait PHPTools {

	public static $color_black = [ 0, 0, 0];

	public static function hexToRGB($hex){

		$RGB = [];
		$RGB[0] = hexdec(substr($hex, 0, 2));
		$RGB[1] = hexdec(substr($hex, 2, 2));
		$RGB[2] = hexdec(substr($hex, 4, 2));

		return $RGB;
	}

}