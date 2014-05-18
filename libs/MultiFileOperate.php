<?php
/**
 * 针对高并发文件操作类
 * @authors ctam
 * @date    2014-5-18 02:25:25
 * @version 1.00
 */

class MultiFileOperate  {
    
    const TMP_DIR = "tmp";     //数据保存目录
    
    static function getCataLog($filename) {
        clearstatcache();
        $baseDir = dirname($filename);
        $realDir = $baseDir."/".self::TMP_DIR . "/";
        if(!is_dir($realDir)) {
            @mkdir($realDir,0777);
        }
        return $realDir;
    }

    static function cfopen($filename, $mode) {
        clearstatcache();
        $tempfilename = self::getCataLog($filename). uniqid().md5 ( $filename ); 
        $fp = fopen ( $tempfilename, $mode );

        return $fp ? array (
                'tempHandle' => $fp, 
                'tempFilename' => $tempfilename,
                'oldFileName' => $filename,
            ) : false;
    }

    static function cfwrite($fp, $string) {
        if($fp) {
            @fwrite ( $fp ['tempHandle'], $string );
        }
    }


    static function cfclose($fp) {
        clearstatcache ();
        fclose ( $fp['tempHandle'] );

        $tempHandle = $fp['tempHandle'];
        $tempFilename = $fp['tempFilename'];
        $oldFileName = $fp['oldFileName'];

        
        if(!file_exists($oldFileName)) {
            @rename ( $tempFilename, $oldFileName );
        } else {            //文件存在，判定是否有锁定
            
            if ($f = fopen ( $oldFileName, 'w+' )) {

                do {
                    $canWrite = flock ( $f, LOCK_EX | LOCK_NB);
                    if (! $canWrite)
                        usleep ( round ( rand ( 0, 100 ) * 1000 ) );
                } while ( (! $canWrite) );

                if ($canWrite) {
                    $contents = file_get_contents($tempFilename);

                    if(!empty($contents)) {
                        fwrite($f, $contents);
                        //file_put_contents($oldFileName,$contets);
                    }
                    flock ( $f, LOCK_UN );
                    @unlink($tempFilename);
                }
                fclose ( $f );
            }

        }
  
    }

   

}