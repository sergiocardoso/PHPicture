<?php

namespace PHPicture\Core;

Class PHPCache extends PHPicture {

	private $parameters = [];
	private $file_original = null;
	private $string_original = null;
	private $hash = null;
	private $image_folder = null;
	private $cache_folder = null;

	public function __construct($image){

		//cache folder exists ?
		$this->cache_folder = parent::getApplicationPath().parent::getConfiguration()['cache_folder'];
		$this->images_folder = parent::getApplicationPath().parent::getConfiguration()['images_folder'];


		if(!file_exists($this->cache_folder)){
			mkdir($this->cache_folder, 0777, true);
		}

		self::makeParameters($image);
	}

	private function makeParameters($image){

		self::makeHash($this->string_original = $image);

		if(file_exists($this->cache_folder.'/'.$this->hash)){
			$this->load($this->hash);
		}

		else {

			$temp = explode('.', $image);
			$extension = end($temp);
			$parameters = explode('-', array_shift($temp));

			$file = array_shift($parameters).'.'.$extension;

			foreach($parameters as $value){
				$tempA = explode(':', $value);
				$this->parameters[$tempA[0]] = $tempA[1];
			}

			if(file_exists(parent::getApplicationPath().parent::getConfiguration()['images_folder'].'/'.$file)){
				$this->file_original = $file;
				\PHPicture\Core\PHPFactory::make($this->file_original, $this->hash, $this->parameters);
			}

			else {
				throw new PHPictureException('Image ['.$file.'] not exists!');
			}
		}
	}

	private function makeHash(){
		$this->hash = hash('ripemd160', $this->string_original);
	}

	public function info(){
		echo '--------------------------------------------';
		echo '<br>hash:        '.$this->hash;
		echo '<br>string:      '.$this->string_original;
		echo '<br>file:        '.$this->file_original;
		echo '<br>----------------------------------------';
		echo '<br>Parameters:';

		echo '<pre>';
		var_dump($this->parameters);
		echo '</pre>';
	}

}