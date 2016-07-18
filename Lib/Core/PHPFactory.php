<?php

namespace PHPicture\Core;

Class PHPFactory {

	use PHPTools;

	private static $file = null;
	private static $file_absolute_path = null;

	public static function make($file, $hash, $parameters){

		$PHPicture = PHPicture::getInstance();

		self::$file = pathinfo($PHPicture->imagesPath().'/'.$file);
		self::$file_absolute_path = $PHPicture->imagesPath().'/'.self::$file['basename'];

		$source = self::makeSource();
		$sizes = getimagesize(self::$file_absolute_path);


		$newImage['width'] = (array_key_exists('w', $parameters)) ? $parameters['w'] : $sizes[0];
		$newImage['height'] = (array_key_exists('h', $parameters)) ? $parameters['h'] : $sizes[1];

		$extension = (array_key_exists('f', $parameters)) ? $parameters['f'] : self::$file['extension'];
		$hash = $hash.'.'.$extension;

		$quality = (array_key_exists('q', $parameters)) ? $parameters['q'] : 0;

		$aspectRatio['thumb'] = $newImage['width'] / $newImage['height'];
		$aspectRatio['original'] = $sizes[0] / $sizes[1];

		$newImageThumb = self::aspectRatio($aspectRatio, $newImage, $sizes);

		$new_image_temp = imagecreatetruecolor($newImageThumb['width'], $newImageThumb['height']);
		imagecopyresampled($new_image_temp, $source, 0, 0, 0, 0, $newImageThumb['width'], $newImageThumb['height'], $sizes[0], $sizes[1]);

		$new_image = imagecreatetruecolor($newImage['width'], $newImage['height']);;

		$backcolor = (array_key_exists('b', $parameters)) ? PHPTools::hexToRGB($parameters['b']) : PHPTools::color_black;
		$backcolor = imagecolorallocate($new_image, $backcolor[0], $backcolor[1], $backcolor[2]);
		imagefill($new_image, 0, 0, $backcolor);

		imagecopy($new_image, $new_image_temp, (imagesx($new_image)/2)-(imagesx($new_image_temp)/2), (imagesy($new_image)/2)-(imagesy($new_image_temp)/2), 0, 0, imagesx($new_image_temp), imagesy($new_image_temp));


		// echo 'arquivo:'.$PHPicture->cachePath().'/'.$hash;
		// die;

		switch($extension){
			case 'png':
				imagepng($new_image, $PHPicture->cachePath().'/'.$hash, $quality);
				break;

			case 'jpg':
				imagejpeg($new_image, $PHPicture->cachePath().'/'.$hash, $quality);
				break;

			case 'jpeg':
				imagejpeg($new_image, $PHPicture->cachePath().'/'.$hash, $quality);
				break;

			case 'gif':
				imagegif($new_image, $PHPicture->cachePath().'/'.$hash, $quality);
				break;
		}

		$PHPicture->load($hash);

	}

	/*
	 * Calculate ASPECT RATIO from image
	 */
	private static function aspectRatio($aspectRatio, $newImage, $sizes){

		$new_values = [];

		if($sizes[0] >= $newImage['width'] && $sizes[1] <= $newImage['height']){
			$new_values['width'] = $newImage['width'];
			$new_values['height'] = $newImage['height'];
		}

		else if ($aspectRatio['thumb'] > $aspectRatio['original']){
			$new_values['width'] = (int) ($newImage['height'] * $aspectRatio['original']);
			$new_values['height'] = $newImage['height'];
		}

		else {
			$new_values['width'] = $newImage['width'];
			$new_values['height'] = (int) ($newImage['width'] * $aspectRatio['original']);
		}

		return $new_values;
	}

	private static function makeSource(){

		switch(self::$file['extension']){
			case 'png':
				$source = imagecreatefrompng(self::$file_absolute_path);
				break;
			case 'jpeg':
				$source = imagecreatefromjpeg(self::$file_absolute_path);
				break;
			case 'gif':
				$source = imagecreatefromgif(self::$file_absolute_path);
				break;
			case 'jpg':
				$source = imagecreatefromjpeg(self::$file_absolute_path);
				break;
		}

		if($source === null){
			throw new PHPictureException("File error!");
		}

		return $source;
	}

}