<?php 

namespace App\Helper;

class Helper{
	function slug_converter($string){
        $str = strtolower($string);
        $split = explode(' ',$str);
        $slug = implode('-',$split);
        return $slug;
    }
	public static function imageResize($file_path, $thumb_path, $filename, $extension, $width, $height){
			// Generate filename
			// Read RAW data
			$extension = strtolower($extension);
			$imageDetail = getimagesize($file_path);
			$thumb = imagecreatetruecolor($width, $height);
			$source = null;
			switch ($extension) {
				case 'png':
				imagealphablending($thumb, FALSE);
				imagesavealpha($thumb, TRUE);
				$source = imagecreatefrompng($file_path);
					break;
				case 'jpeg':
				$source = imagecreatefromjpeg($file_path);
					break;
				case 'jpg':
				$source = imagecreatefromjpeg($file_path);
					break;
				
				default:
					# code...
					break;
			}
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $imageDetail[0], $imageDetail[1]);
			
			switch ($extension) {
				case 'png':
				imagepng($thumb, $thumb_path);
					break;
				case 'jpeg':
				imagejpeg($thumb, $thumb_path);
					break;
				case 'jpg':
				imagejpeg($thumb, $thumb_path);
					break;
				
				default:
					# code...
					break;
			}
	echo $filename;
	}
}