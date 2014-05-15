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
	public function checkLogin($parame) {
		session_start();
		$userName = $parame['userName'];
		$password = $parame['password'];
		$pic = $parame['pic'];
		$ip = get_ClientIP();

		if(!isset($pic)) {
			$pic = "default.gif";
		}

		$_SESSION['user'] = array(
			'userName' => $userName,
			'pic' => $pic,
			'ip' => $ip
		);

		if($password == $this -> _password) {	//登录成功
			$arr = array(
				'userName' => $userName,
				'pic' => $pic,
				'ip' => $ip
			); 
			updateOnlineList($arr);
			echo json_encode(1);
			exit;
		}

		echo json_encode(0);

	}

	public function showLoginIndex() {
		GameCore::display("login.php");
	}

}
