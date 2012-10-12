<?php
	function checkFile($filename) {
		$allowedFormats = array(".jpg", ".png", ".gif"); 
		//tillåtna format på filerna som laddas upp
		$numberOfChars = strlen($filename);
		
		$fileformat = strtolower(substr($filename, $numberOfChars-4));
		
		if (! in_array($fileformat, $allowedFormats)) {
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
		//Skapar en svart/tom bild som är 300px hög och har samma ratio som originalet
		
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newWidth, 300, $orgWidth, $orgHeight);
		$thumbname = "thumbs/thumb_".$_FILES['filename']['name'];
		imagejpeg($thumb, $thumbname, 50); //resurser bild, filnamn som den ska få, kvalité 0-100
		
		//tar bort bilderna från minnet
		imagedestroy($image);
		imagedestroy($thumb);
		return "thumb_".$_FILES['filename']['name']; //Skickar tillbaka namnet på thumbnailen
	}

	function watermarkImage() {
		$image = imagecreatefromjpeg($_FILES['filename']['tmp_name']);
		
		$placeX = ceil(imagesx($image)/10);
		$placeY = ceil(imagesy($image)/10);
		
		$text_color = imagecolorallocatealpha($image, 255,255,255, 30);
		imagettftext($image, 50, -45, $placeX, $placeY, $text_color, "Chalkduster.ttf", "This image belongs to Kenths fotosite!");
		imagejpeg($image, "watermarked/wm_".$_FILES['filename']['name'], 80);
		imagedestroy($image);
		return "wm_".$_FILES['filename']['name']; //Skickar tillbaka namnet på watermarkade bilden
	}
?>