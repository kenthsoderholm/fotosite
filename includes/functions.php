<?php
	function checkFile($filename) {
		$allowedFormats = array(".jpg", ".png", ".gif");	//Array of allowed fileformats, jpeg is the only working one in this version.
		$numberOfChars = strlen($filename);
		
		$fileFormat = strtolower(substr($filename, $numberOfChars-4));
		
		if (! in_array($fileFormat, $allowedFormats)) {
			return false;
		}
		else {
			return true;
		}
	
	}
	
	function createThumb() {

		$image = imagecreatefromjpeg($_FILES['filename']['tmp_name']);
		
		$orgWidth = imagesx($image);
		$orgHeight = imagesy($image);
		
		$newWidth = ceil($orgWidth/$orgHeight * 300);
		$thumb = imagecreatetruecolor($newWidth, 300); 
		//Creates a black image with a height of 300px and the same ratio as the original image
		
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newWidth, 300, $orgWidth, $orgHeight);
		$thumbname = "thumbs/thumb_".$_FILES['filename']['name'];
		imagejpeg($thumb, $thumbname, 50); //Parameters imageresource, imagename and quality
		
		//removes images from memory
		imagedestroy($image);
		imagedestroy($thumb);
		return "thumb_".$_FILES['filename']['name']; //Returns name of thumbnail
	}

	function watermarkImage() {
		$image = imagecreatefromjpeg($_FILES['filename']['tmp_name']);
		
		$placeX = ceil(imagesx($image)/10); //Xplacement of watermark
		$placeY = ceil(imagesy($image)/10); //Yplacement of watermark
		
		$textColor = imagecolorallocatealpha($image, 255,255,255, 30); //White text_color of watermark
		imagettftext($image, 50, -45, $placeX, $placeY, $textColor, "Chalkduster.ttf", "This image belongs to Kenths fotosite!");
		imagejpeg($image, "watermarked/wm_".$_FILES['filename']['name'], 80);
		imagedestroy($image);
		return "wm_".$_FILES['filename']['name']; //Returns name of watermarked file
	}
?>