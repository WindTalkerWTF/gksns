<?php
class Install_Tool{	
	static function fileModeInfo($file_path)
	{
	    if (!file_exists($file_path))
	    {
	        return false;
	    }
	    $mark = 0;
	    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
	    {
	        $test_file = $file_path . '/cf_test.txt';
	        if (is_dir($file_path))
	        {
	            $dir = @opendir($file_path);
	            if ($dir === false)
	            {
	                return $mark;
	            }
	            if (@readdir($dir) !== false)
	            {
	                $mark ^= 1;
	            }
	            @closedir($dir);
	            $fp = @fopen($test_file, 'wb');
	            if ($fp === false)
	            {
	                return $mark; 
	            }
	            if (@fwrite($fp, 'directory access testing.') !== false)
	            {
	                $mark ^= 2;
	            }
	            @fclose($fp);
	            @unlink($test_file);
	            $fp = @fopen($test_file, 'ab+');
	            if ($fp === false)
	            {
	                return $mark;
	            }
	            if (@fwrite($fp, "modify test.\r\n") !== false)
	            {
	                $mark ^= 4;
	            }
	            @fclose($fp);
	            if (@rename($test_file, $test_file) !== false)
	            {
	                $mark ^= 8;
	            }
	            @unlink($test_file);
	        }
	        elseif (is_file($file_path))
	        {
	            $fp = @fopen($file_path, 'rb');
	            if ($fp)
	            {
	                $mark ^= 6;
	            }
	            @fclose($fp);
	            /* 试着修改文件 */
	            $fp = @fopen($file_path, 'ab+');
	            if ($fp && @fwrite($fp, '') !== false)
	            {
	                $mark ^= 8;
	            }
	            @fclose($fp);
	        }
	    }
	    else
	    {
	        if (@is_readable($file_path))
	        {
	            $mark ^= 1;
	        }
	        if (@is_writable($file_path))
	        {
	            $mark ^= 14;
	        }
	    }
	    return $mark;
	}
	
	
}