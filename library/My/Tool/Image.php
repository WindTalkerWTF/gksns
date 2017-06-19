<?php
require_once ROOT_LIB . '/Open/Image.class.php';
class My_Tool_Image extends Image{
	//生成缩略图 
	//$bFull为true：缩小后为原图，为false则切掉长边，取中间的
	static function makethumb($srcfile,$dstfile, $thumb_width=40, $thumb_height=40) {
		//判断文件是否存在
		if (!file_exists($srcfile)) {
			return '';
		}
		
		$tow = intval($thumb_width);
		$toh = intval($thumb_height);
		//获取图片信息
		$im = '';
		if($data = @getimagesize($srcfile)) {
			if($data[2] == 1) {
				if(function_exists("imagecreatefromgif")) {
					$im = imagecreatefromgif($srcfile);
				}
			} elseif($data[2] == 2) {
				if(function_exists("imagecreatefromjpeg")) {
					$im = imagecreatefromjpeg($srcfile);
				}
			} elseif($data[2] == 3) {
				if(function_exists("imagecreatefrompng")) {
					$im = imagecreatefrompng($srcfile);
				}
			}
		}
		if(!$im) return '';
		
		$src_w = $srcw = imagesx($im);
		$src_h = $srch = imagesy($im);
		
		$towh = $tow/$toh;
		$srcwh = $srcw/$srch;
		$src_x = $src_y = 0;
		if($towh <= $srcwh){
				$ftoh = $toh;
				$ftow = $thumb_width;
				
				$src_w = $srch*($ftow/$ftoh);
				$src_x = intval(($srcw - $src_w) / 2);
		} else {
				$ftow = $tow;
				$ftoh = $thumb_height;
				
				$src_h = $srcw*($ftoh/$ftow);
				$src_y = intval(($srch - $src_h) / 2);
		}
		
//		echo $srcw.'*'.$tow.'-'.$src_x.' '.$srch.' '.$toh.'<br>';exit;
		$ni = null;
		$maxni = null;
		if($srcw > $tow || $srch > $toh) {
			if(function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @$ni = imagecreatetruecolor($ftow, $ftoh)) {
				imagecopyresampled($ni, $im, 0, 0, $src_x, $src_y, $ftow, $ftoh, $src_w, $src_h);
				//大图片
				if(@$maxni = imagecreatetruecolor(0, 0)) {
					imagecopyresampled($maxni, $im, 0, 0, 0, 0, 0, 0, $srcw, $srch);
				}
			} elseif(function_exists("imagecreate") && function_exists("imagecopyresampled") && @$ni = imagecreate($ftow, $ftoh)) {
				imagecopyresampled($ni, $im, 0, 0, $src_x, $src_y, $ftow, $ftoh, $src_w, $src_h);
				//大图片
				if(@$maxni = imagecreate(0, 0)) {
					imagecopyresampled($maxni, $im, 0, 0, 0, 0, 0, 0, $srcw, $srch);
				}
			}
		}
		$ni = !$ni ? $im:$ni;
		$maxni = !$maxni ? $im:$maxni;
		imagejpeg($ni, $dstfile, 90);
		//大图片
		imagejpeg($maxni, $srcfile, 90);
		imagedestroy($ni);
		imagedestroy($maxni);
		imagedestroy($im);
		if(!file_exists($dstfile)) {
			return '';
		} else {
			return $dstfile;
		}
	}
}