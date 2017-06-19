<?php
/*
$path = "D:/www/test/1.jpg";
$mask = "D:/www/test/mask.80x80.png";
$imgSrc = Image::load($path);
$imgMask = imagecreatefrompng($mask);
$imgDest = Image::scaleFix($imgSrc, 80, 80);
$img = Image::mask($imgDest, $imgMask);
imagepng($img, "D:/www/test/80.png");
*/
class Image
{
	static public function createTransparentImage($width, $height)
	{
		$img = imagecreatetruecolor($width, $height);
		imagesavealpha($img, true);
		$color = imagecolorallocatealpha($img, 0, 0, 0, 127);
		imagefill($img, 0, 0, $color);
		return $img;
	}

	static public function scale($imgSrc, $maxWidth, $maxHeight)
	{
		$picWidth = imagesx($imgSrc);
		$picHeight = imagesy($imgSrc);

		if(($maxWidth && $picWidth > $maxWidth) || ($maxHeight && $picHeight > $maxHeight))
		{
			$bResizeWidth = false;
			$bResizeHeight = false;
			$widthRatio = 0;
			$heightRatio = 0;
			$ratio = 0;

			if($maxWidth && $picWidth>$maxWidth)
			{
				$widthRatio = $maxWidth/$picWidth;
				$bResizeWidth = true;
			}

			if($maxHeight && $picHeight>$maxHeight)
			{
				$heightRatio = $maxHeight/$picHeight;
				$bResizeHeight = true;
			}

			if($bResizeWidth && $bResizeHeight)
			{
				if($widthRatio<$heightRatio)
					$ratio = $widthRatio;
				else
					$ratio = $heightRatio;
			}

			if($bResizeWidth && !$bResizeHeight)
				$ratio = $widthRatio;
			if($bResizeHeight && !$bResizeWidth)
				$ratio = $heightRatio;

			$newWidth = $picWidth * $ratio;
			$newHeight = $picHeight * $ratio;

			$imgDest = imagecreatetruecolor($newWidth,$newHeight);
			if(function_exists("imagecopyresampled"))
				imagecopyresampled($imgDest,$imgSrc,0,0,0,0,$newWidth,$newHeight,$picWidth,$picHeight);
			else
				imagecopyresized($imgDest,$imgSrc,0,0,0,0,$newWidth,$newHeight,$picWidth,$picHeight);
			return $imgDest;
		}
		else
			return $imgSrc;
	}

	static public function scaleFix($imgSrc, $fixWidth, $fixHeight)
	{
		$picWidth = imagesx($imgSrc);
		$picHeight = imagesy($imgSrc);

		if($picWidth < $picHeight)
		{
			$ratio = $picWidth / $fixWidth;
			$srcWidth = $picWidth;
			$srcHeight = $fixHeight * $ratio;
			$srcX = 0;
			$srcY = ($picHeight - $srcHeight) / 2;
		}
		else
		{
			$ratio = $picHeight / $fixHeight;
			$srcWidth = $fixWidth * $ratio;
			$srcHeight = $picHeight;
			$srcX = ($picWidth - $srcWidth) / 2;
			$srcY = 0;
		}

		$imgDest = imagecreatetruecolor($fixWidth,$fixHeight);
		if(function_exists('imagecopyresampled'))
			imagecopyresampled($imgDest, $imgSrc, 0, 0, $srcX, $srcY, $fixWidth, $fixHeight, $srcWidth, $srcHeight);
		else
			imagecopyresized($imgDest, $imgSrc, 0, 0, $srcX, $srcY, $fixWidth, $fixHeight, $srcWidth, $srcHeight);
		return $imgDest;
	}

	static public function water($imgSrc,$imgMask,$markPos)
	{
		/*
		 * $markPos
		* 1  2  3
		* 4  5  6
		* 7  8  9
		*/
		$srcWidth  = imagesx($imgSrc);
		$srcHeight = imagesy($imgSrc);

		$maskWidth    = imagesx($imgMask);
		$maskHeight    = imagesy($imgMask);

		if($srcWidth < $maskWidth || $srcHeight < $maskHeight)
		{
			return $imgSrc;
		}

		switch($markPos)
		{
			case 1:
				$x = +5;
				$y = +5;
				break;
			case 2:
				$x = ($srcWidth - $maskWidth) / 2;
				$y = +5;
				break;
			case 3:
				$x = $srcWidth - $maskWidth - 5;
				$y = +15;
				break;
			case 4:
				$x = +5;
				$y = ($srcHeight - $maskHeight) / 2;
				break;
			case 5:
				$x = ($srcWidth - $maskWidth) / 2;
				$y = ($srcHeight - $maskHeight) / 2;
				break;
			case 6:
				$x = $srcWidth - $maskWidth - 5;
				$y = ($srcHeight - $maskHeight) / 2;
				break;
			case 7:
				$x = +5;
				$y = $srcHeight - $maskHeight - 5;
				break;
			case 8:
				$x = ($srcWidth - $maskWidth) / 2;
				$y = $srcHeight - $maskHeight - 5;
				break;
			case 9:
				$x = $srcWidth - $maskWidth - 5;
				$y = $srcHeight - $maskHeight -5;
				break;
			default: // default pos : 9
				$x = $srcWidth - $maskWidth - 5;
				$y = $srcHeight - $maskHeight -5;
				break;
		}

		$imgDest = @imagecreatetruecolor($srcWidth, $srcHeight);

		imagecopy($imgDest, $imgSrc, 0, 0, 0, 0, $srcWidth, $srcHeight);
		imagecopy($imgDest, $imgMask, $x, $y, 0, 0, $maskWidth, $maskHeight);

		return $imgDest;
	}

	static public function mask($imgSrc, $imgMask)
	{
		$srcWidth  = imagesx($imgSrc);
		$srcHeight = imagesy($imgSrc);

		$maskWidth    = imagesx($imgMask);
		$maskHeight    = imagesy($imgMask);

		$minWidth = min($srcWidth, $maskWidth);
		$minHeight = min($srcHeight, $maskHeight);

		$img = Image::createTransparentImage($srcWidth, $srcHeight);
		imagecopy($img, $imgMask, 0, 0, 0, 0, $minWidth, $minHeight);

		imagealphablending($img, true);

		for($y=0; $y<$minHeight; $y++)
		{
			for($x=0; $x<$minWidth; $x++)
			{
				$color = imagecolorat($img, $x, $y);
				$a = ($color & 0xFF000000) >> 24;

				$color = imagecolorat($imgSrc, $x, $y);
				$r = ($color & 0x00FF0000) >> 16;
				$g = ($color & 0x0000FF00) >> 8;
				$b = ($color & 0x000000FF);

				$color = imagecolorallocatealpha($img, $r, $g, $b, $a);
				imagesetpixel($img, $x, $y, $color);
			}
		}
		return $img;
	}

	static public function load($filePath)
	{
		$img = null;
		$imgInfo = @getimagesize($filePath);
		switch ($imgInfo[2])
		{
			case IMAGETYPE_GIF:
				$img =imagecreatefromgif($filePath);
				break;
			case IMAGETYPE_JPEG:
			case IMAGETYPE_JPEG2000:
				$img =imagecreatefromjpeg($filePath);
				break;
			case IMAGETYPE_PNG:
				$img =imagecreatefrompng($filePath);
				break;
		}
		return $img;
	}
}