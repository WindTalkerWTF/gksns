<?php
/**
 * 
 * socket
 * @author kaihui.wang
 *
 */
class My_Tool_Socket
{
	private $host = null;
	private $port = null;
	private $timeOut = null;
	
	
	function __construct($host, $port, $timeOut=2){
		$this->host = $host;
		$this->port = $port;
		$this->timeOut = $timeOut;
	}
	
	/**
	 * 
	 * 初始化
	 * @param string $host
	 * @param int $port
	 * @param int $timeOut
	 * @throws My_Exception
	 */
 	function send($out, $getLength=128){
		$errno = "";
		$errstr = "";
		$str = "";
		$fp = @fsockopen($this->host, $this->port, $errno, $errstr, $this->timeOut);
		stream_set_timeout($fp, 3);
		if (!$fp) {
		    throw new My_Exception($errstr, $errno);
		} else {
		    fwrite($fp, $out);
		    $str = fgets($fp, $getLength);
		    fclose($fp);
		}
		return $str;
	}
}