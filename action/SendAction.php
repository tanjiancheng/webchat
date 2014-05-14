<?php

/**
 * 发送信息类
 * @authors ctam
 * @date    2014-05-12 14:30:08
 * @version 1.00
 */

class SendAction {


	public function __construct() {

	}

	public function send($parame) {
		$msg = $parame['msg']; 
		Stroage::getInstance() -> set("msg", $msg);
		Stroage::getInstance() -> set("time", time());
		Stroage::getInstance() -> set("currentip", $parame['ip']);
		Stroage::getInstance() -> set("pic", $parame['pic']);
		Stroage::getInstance() -> set("userName", $parame['userName']);
		die();
	}

}