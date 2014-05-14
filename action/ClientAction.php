<?php

/**
 * 聊天类
 * @authors ctam
 * @date    2014-05-12 14:30:08
 * @version 1.00
 */

class ClientAction {


	public function __construct() {

	}

	public function showClient() {
		session_start();
		if(!isset($_SESSION['user'])) {
			@header("location:index.php?func=LoginAction.showLoginIndex");
		}


		$userName = $_SESSION['user']['userName'];
		$pic = $_SESSION['user']['pic'];
		$ip = get_ClientIP();

		if(!$pic) {
			$pic = "default.gif";
		}


		GameCore::display("client.php",array(
			'userName' => $userName,
			'pic' => $pic,
			'ip' => $ip
		));


	}



}
