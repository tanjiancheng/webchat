<?php
/**
 * 文件DB类
 * @authors ctam
 * @date    2014-04-28 09:40:52
 * @version 1.00
 */

include("MultiFileOperate.php");

class FileDb  {
    
    private $_dataCatalog = "data";     //数据保存目录

    function __construct(){
        $baseDir = dirname(dirname(__FILE__));
        $this -> _dataCatalog = $baseDir . "/" . $this -> _dataCatalog .'/';
    }

    public function get($key) {
    	$fileName = $this -> _dataCatalog . $key . '.txt';
        
    	$contents = 0;

    	if(file_exists($fileName) && filesize($fileName) > 0) {
    		$handle = fopen($fileName, "r");
    		$contents = fread($handle, filesize($fileName));
    	} 

    	return $contents;
    }


    public function set($key, $value) {
    	$fileName = $this -> _dataCatalog . $key . '.txt';
    	$handle = MultiFileOperate::cfopen($fileName, "w+");

    	if($handle) {
            MultiFileOperate::cfwrite ( $handle, $value);
    	}

    	MultiFileOperate::cfclose ( $handle);

    }

}