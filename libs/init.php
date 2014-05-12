<?php
if(!defined('BASE')){

	define("BASE", dirname( dirname( __FILE__ )));			//文件根位置
	define("LIB", BASE."/libs");  		//框架源文件的位置
	define("TPL",BASE."/templetes");   	//默认模板存放的目录
	define("ACTION",BASE."/action");   	//action存放目录
	define("BO",BASE."/bo");   			//bo存放目录
	define("DAO",BASE."/dao");   		//dao存放目录
	define("INDEX", "LoginAction.showLoginIndex"); //默认首页
	
	//定义项目web路径
	$domain = $_SERVER['SERVER_NAME'];	//优先域名
	if(!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] == "localhost") {
		$domain = $_SERVER['SERVER_ADDR'];
	}
	

	$baseUrl = dirname('http://'.$domain .":" . $_SERVER['SERVER_PORT'] . $_SERVER['SCRIPT_NAME']) ;
	define("APP", $baseUrl);        //设置当前应用的目录


	include('core.cls.php');
	include('Common.php');
	include('Stroage.php');

	@header( "Content-type: text/html; charset=utf-8" );

	if (get_magic_quotes_gpc()) { 				//如果开了magic_quotes，就用程序关掉。
		GameCore::array_stripslashes( $_POST );
		GameCore::array_stripslashes( $_GET );
		GameCore::array_stripslashes( $_COOKIE );
	}

}