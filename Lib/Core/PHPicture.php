<?php

namespace PHPicture\Core;

Class PHPicture {

	private static $instance;
	private static $configuration = [];
	private static $parameters = [];

	private function __construct(){}
	private function __clone(){}

	public static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance = new PHPicture();
			self::setConfiguration();
		}

		return self::$instance;
	}

	public static function getApplicationPath(){
		return __DIR__.'/../../';
	}

	public function imagesPath(){
		return self::getConfiguration()['images_folder'];
	}

	public function cachePath(){
		return self::getApplicationPath().self::getConfiguration()['cache_folder'];
	}

	private static function setConfiguration(){

		$inifile = self::getApplicationPath().'PHPicture.ini';

		if(!file_exists($inifile)){
			throw new PHPictureException("PHPicture.ini not found!");
		}

		else {
			self::$configuration = parse_ini_file($inifile);
		}
	}

	public function getConfiguration(){
		return self::$configuration;
	}

	public function load($hash){

		$file = self::cachePath().'/'.$hash;
		$file_data = pathinfo($file);
		$source = null;

		switch($file_data['extension']){
			case 'png':
				$source = imagecreatefrompng($file);
				break;
			case 'jpeg':
				$source = imagecreatefromjpeg($file);
				break;
			case 'gif':
				$source = imagecreatefromgif($file);
				break;
			case 'jpg':
				$source = imagecreatefromjpeg($file);
				break;
		}

		switch($file_data['extension']){
			case 'png':
				header('Content-type: image/png');
				imagepng($source);
				imagedestroy($source);
				break;

			case 'jpeg':
				header('Content-type: image/png');
				imagejpeg($source);
				imagedestroy($source);
				break;

			case 'jpg':
				header('Content-type: image/png');
				imagejpeg($source);
				imagedestroy($source);
				break;

			case 'gif':
				header('Content-type: image/png');
				imagegif($source);
				imagedestroy($source);
				break;
		}

	}
}