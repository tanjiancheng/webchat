<?php

/**
 * 登录
 * @authors ctam
 * @date    2014-05-12 14:30:08
 * @version 1.00
 */



class LoginAction {
	private $_password;		//登录密码

	public function __construct() {
		$this -> _password = "ctam";
	}


	/**
	 * 验证登录
	 * @return 
	 */
	public function checkLogin() {




	}

	public function showLoginIndex() {
		GameCore::display("login.php");
	}



}
