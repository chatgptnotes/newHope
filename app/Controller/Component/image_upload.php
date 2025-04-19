<?php
class ImageUploadComponent extends Component {
	//var $fileType = array('image/jpg', 'image/jpeg', 'image/gif','image/png','image/pjpeg');
	var $fileType = array();
	var $showError;
	
	function uploadFile($data, $inputFileName, $folderName=NULL, $fileName=NULL, $checkSize=NULL, $checkWidth=NULL, $checkHeight=NULL) {
		$getModelName = array_keys($data['data']);
		$checkType = $this->fileType;
		// to check if limitation in height is specified by user //
		$errorFilesHeight = $this->checkFileHeight($data, $inputFileName, $checkHeight);
		if(!empty($errorFilesHeight)) {
			return $errorFilesHeight;
			exit;
		}
		// to check if limitation in width is specified by user //
		$errorFilesWidth = $this->checkFileWidth($data, $inputFileName, $checkWidth);
		if(!empty($errorFilesWidth)) {
			return $errorFilesWidth;
			exit;
		}
		// to check if limitation in size is specified by user //
		$errorFilesSize = $this->checkFileSize($data, $inputFileName, $checkSize);
		if(!empty($errorFilesSize)) {
			return $errorFilesSize;
			exit;
		}
		// to check file type //
		$errorFilesType = $this->checkFileType($data, $inputFileName, $checkType);
		if(!empty($errorFilesType)) {
		return $errorFilesType;
		exit;
		}
		
		// to check if folder name is specified by user //
		if(!empty($folderName)) {
		if(!file_exists(WWW_ROOT.$folderName)) {
			mkdir(WWW_ROOT.$folderName,0777,true); //set true for recursive directory creation
		}
		
		if(!is_writable(WWW_ROOT.$folderName)){
			//$isApplied = chmod(WWW_ROOT.$folderName, 0777);
			//$completePath = WWW_ROOT.$folderName;
			//$isApplied = system ("chmod 777 -R $completePath");
			if(!$isApplied){
				return "Directory is not writable" ;
				exit;
			}
		}
		
		$destinationFolder = WWW_ROOT.$folderName.DS;
		} else {
			$destinationFolder = WWW_ROOT.'img'.DS;
		
		}
		// to check if file name is changed by user //
		if(!empty($fileName)) {
			$destinationFile = $fileName;
			if(file_exists($destinationFolder.$destinationFile)) {
			$fileExistError = 'This File is already exist';
			return $this->showError($fileExistError);
			exit;
		} else {
			copy($data['data'][$getModelName[0]][$inputFileName]['tmp_name'], $destinationFolder.$destinationFile);
		}
		} else {
		if(file_exists($destinationFolder.$data['data'][$getModelName[0]][$inputFileName]['name'])) {
			$fileExistError = 'This File is already exist';
			return $this->showError($fileExistError);
			exit;
		} else {
			return copy($data['data'][$getModelName[0]][$inputFileName]['tmp_name'], $destinationFolder.$data['data'][$getModelName[0]][$inputFileName]['name']);
		}
		
		}
	
	}
	
	function removeFile($fileName, $folderName=NULL) {
		if(!empty($folderName)) {
			$destinationFolder = WWW_ROOT.$folderName.DS;
		} else {
			$destinationFolder = WWW_ROOT.'img'.DS;
		}
		if(file_exists($destinationFolder.$fileName)) {
			unlink($destinationFolder.$fileName);
		} else {
			$fileDeleteError = 'File Delete Error';
			return $this->showError($fileDeleteError);
		}
	}
	
	function checkFileType($data, $inputFile, $fileType=NULL) {
		$getModelName = array_keys($data['data']);
		if(!empty($fileType)) {
			$getFileType = $data['data'][$getModelName[0]][$inputFile]['type'];
		if(!in_array($getFileType,$fileType)) {
			$fileTypeError = 'File Type Error';
			return $this->showError($fileTypeError);
		}
		}
	}
	
	function checkFileSize($data, $inputFile, $fileSize=NULL) {
		$getModelName = array_keys($data['data']);
		if(!empty($fileSize)) {
			$getFileSize = $data['data'][$getModelName[0]][$inputFile]['size']/1024;
		if($getFileSize > $fileSize) {
			$fileSizeError = 'File size Error';
			return $this->showError($fileSizeError);
		}
		}
	}
	
	function checkFileWidth($data, $inputFile, $fileWidth=NULL) {
		$getModelName = array_keys($data['data']);
		$getFileDim = getimagesize($data['data'][$getModelName[0]][$inputFile]['tmp_name']);
		if(!empty($fileWidth)) {
		if($getFileDim[1] > $fileWidth) {
			$fileWidthError = 'File Width Error';
			return $this->showError($fileWidthError);
		}
		}
	}
	
	function checkFileHeight($data, $inputFile, $fileHeight=NULL) {
		 
		$getModelName = array_keys($data['data']);		  
		$getFileDim = getimagesize($data['data'][$getModelName[0]][$inputFile]['tmp_name']);
		if(!empty($fileHeight)) {
			if($getFileDim[0] > $fileHeight) {
				$fileHightError = 'File height Error';
				return $this->showError($fileHightError);
			}
		}
	}
	
	function showError($errorDisplay) {
		if(!empty($errorDisplay)) {
			$this->showError = $errorDisplay;
			return $this->showError; 
		}
	}	
	//functions for resizing images
	function load($filename) {
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		if( $this->image_type == IMAGETYPE_JPEG ) {
		$this->image = imagecreatefromjpeg($filename);
		} elseif( $this->image_type == IMAGETYPE_GIF ) {
		$this->image = imagecreatefromgif($filename);
		} elseif( $this->image_type == IMAGETYPE_PNG ) {
		$this->image = imagecreatefrompng($filename);
		}
	}
	function save($filename,$folderName,$image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
		if(!empty($folderName)) {
			if(!file_exists(WWW_ROOT.$folderName)) { 
				$isCreated = mkdir(WWW_ROOT.$folderName,0777,true);
				if(!$isCreated) return  "Unable To create directory" ;
				exit; 
			} 
			if(!is_writable(WWW_ROOT.$folderName)){ 
					return "Directory is not writable" ;
					exit; 
			} 
		}
		
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image,$filename,$compression);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif($this->image,$filename);
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($this->image,$filename);
		}
		if( $permissions != null) {
			chmod($filename,$permissions);
		}
	}
	function output($image_type=IMAGETYPE_JPEG) {
		if( $image_type == IMAGETYPE_JPEG ) {
		imagejpeg($this->image);
		} elseif( $image_type == IMAGETYPE_GIF ) {
		imagegif($this->image);
		} elseif( $image_type == IMAGETYPE_PNG ) {
		imagepng($this->image);
		}
	}
	function getWidth() {
		return imagesx($this->image);
	}
	function getHeight() {
		return imagesy($this->image);
	}
	function resizeToHeight($height) {
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width,$height);
	}
	function resizeToWidth($width) {
		$ratio = $width / $this->getWidth();
		$height = $this->getheight() * $ratio;
		$this->resize($width,$height);
	}
	function scale($scale) {
		$width = $this->getWidth() * $scale/100;
		$height = $this->getheight() * $scale/100;
		$this->resize($width,$height);
	}
	function resize($width,$height) {
		$new_image = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;
	}
	 
	
	}
?>