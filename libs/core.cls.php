<?php
/**
* @version 1.0.0: core.cls.php
* @CreTime:2012-11-21
* @CreName:goku
* @Feature:定义游戏核心类
*/
/*=================方法==================
[GameCore][static]getMysql()						获得数据库连接对象
========================================*/

/**
 * @Content:game core
 * @Author:Goku
 * @CreateTime:2012-11-21 
 * @Version:1.0.0
 * @Note: null
 */
class GameCore{

	/**
	 * 引用文件目录对像(针对bo目录，所以不用带路径)
	 *
	 * @return 引用的对象
	 * @since 1.0.0
	 */
	static function getBO( $class ) {

		$s_File = BO."/".$class .".php";
		if(!file_exists($s_File)) {
			die($s_File. " file do not exist!");
		}

		require($s_File);

		if(!class_exists($class)) {
			die($class. " class do not exist!");
		}

		return new $class;
		
	}

	/**
	 * 引用文件目录对像(针对dao目录，所以不用带路径)
	 *
	 * @return 引用的对象
	 * @since 1.0.0
	 */
	static function getDAO( $class) {
		$s_File = DAO."/".$class .".php";

		if(!file_exists($s_File)) {
			die($s_File. " file do not exist!");
		}

		require($s_File);

		if(!class_exists($class)) {
			die($class. " class do not exist!");
		}

		return new $class;
		
	}
	
	
	static function display($tpl, $param = array() ) {
		extract($param);
		$APP  = APP;					//项目路径
		require TPL . '/' . $tpl;
	}

	 /**
	 * @Content:过滤传过来的字符串
	 * @Author:Goku
	 * @CreateTime:2012-11-21
	 * @Version:1.0.0
	 * @Note: null
	 */
	 static function array_stripslashes(&$arr) {
		foreach($arr as $key => $value) {
			if (is_array($value)) {
				self::array_stripslashes($value);
			}
			else {
				$arr[$key] = stripslashes($value);
			}
		}
	 }
	 
	 
	 /**
	 * 获取玩家IP地址
	 *
	 * @return string
	 * @author Goku
	 * @version 1.0.0
	 */
	static function get_ClientIP() {
	
		static $thisClientIp = "";
		
		if( !$thisClientIp ) {
			if($_SERVER["HTTP_X_FORWARDED_FOR"])
				$thisip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			else {
				if($_SERVER["HTTP_CLIENT_IP"])
					$thisip = $_SERVER["HTTP_CLIENT_IP"];
				else
					$thisip = $_SERVER["REMOTE_ADDR"];
			}
			$thisClientIp = $thisip;
		}
		
		return $thisClientIp;
	}
	

	 

	
	


	
}
?>