<?php
/**
 * DB工厂类
 * @authors ctam
 * @date    2014-04-28 09:44:46
 * @version 1.00
 */

include("FileDb.php");

class FactoryDb  {
	static $obj = null;

    public static function createObj($type){
        switch ($type) {
            case 'file':
                self::$obj = new FileDb();
                break;
            
            case 'SaeKV':
                self::$obj = new SaeKV();
                self::$obj -> init();
                break;
        }

        return self::$obj;

    }

}
