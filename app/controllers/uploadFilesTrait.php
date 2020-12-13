<?php
namespace App\controllers;

trait uploadFilesTrait
{
	protected $type;
	protected $filename;
	protected $alt_name;
	protected $size;
	protected $tmp_path;
	protected $imageFileType ;
	public $fileExtension = array('gif','jpg','png','jpeg',"gif","mp4");
	public $upload_directory= "images";
	public $error= array();
	public $upload_error_array= array(
      UPLOAD_ERR_OK=>"THERE IS NO ERROR",
      UPLOAD_ERR_INI_SIZE=>"the uploaded file exceeds the upload_max_filesize ",
      UPLOAD_ERR_FORM_SIZE=>"the uploaded file exceeds the max_file_size directive",
      UPLOAD_ERR_PARTIAL=>"the uploaded file was only partially uploaded",
      UPLOAD_ERR_NO_FILE=>"no file was upload",
      UPLOAD_ERR_NO_TMP_DIR =>"missing a temporary folder",
      UPLOAD_ERR_CANT_WRITE=>"failed to write file to disk",
      UPLOAD_ERR_EXTENSION=>"the php extension stopped the file upload"
    );

	protected function file_set($file){
		if(empty($file) || !$file || !is_array($file) ){
			$this->error= "there was no file uploaded here";
			return false;
		}else{
			if($file['error'] != 0){
				$this->error[]= $this->upload_error_array[$file['error']];
				return false;
			}else{
				$this->filename= basename($file['name']);
		        $this->imageFileType =  strtolower(pathinfo($this->picture_path(),PATHINFO_EXTENSION));
			    $this->type= $file['type'];
		        $this->size= $file['size'];
		        $this->tmp_path= $file['tmp_name'];
			}
		}
	}

	protected function picture_path()
	{
		return $this->upload_directory. "/". $this->filename;
	}

	/*
	|-----------------------------------------
	| TO CHECK FILE IS IMAGE OR NOT
	|-----------------------------------------
	| by default application path for image
	| is "public/images" but, if picture should be 
	| uploaded in subdirectories of the parent
	| folder we need to check wheater image 
	| already exist or not..
	*/
	protected function is_image()
	{
		if(!empty($this->error)){
			return false;
		}
		if(empty($this->filename) || empty($this->tmp_path)){
			$this->error[]= "the file was not available";
			return false;
		}
		if (file_exists($this->picture_path()) && filesize($this->picture_path()) === $this->size){
			$this->error[]= "the file { $this->filename } was already available";
			return false;
		}
		if ($this->size > 5000000) {
            $this->error[]= "Sorry, your file is too large.";
            return false;
        }
		if(false == getimagesize($this->tmp_path) ){
			$this->error[]= "File is not an image.";
			return false;
		}
		if(!in_array($this->imageFileType, $this->fileExtension)) {
            $this->error[]= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            header("Http/1.1 400 Invalid extension");
            return false;
        }
        return true;
	}

	
	public function save_it(){
		if ($this->is_image()) {
			if(move_uploaded_file($this->tmp_path, $this->picture_path())){
				unset($this->tmp_path);
				return true;
			}else{
				$this->error[] = "the file directory does not have permission..";
				return false;
			}
		}
	}

}