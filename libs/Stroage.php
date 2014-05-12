<?php
/**
	新浪saekv存储类
**/

include("FactoryDb.php");

class Stroage {

	static $_obj = null;

	private function __construct() {
	}

	public static function getInstance() {
		if(self::$_obj == null) {
			self::$_obj = FactoryDb::createObj('file');
		}
		return self::$_obj;
	}

}