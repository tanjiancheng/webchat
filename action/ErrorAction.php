<?php

/**
 * 登录
 * @authors ctam
 * @date    2014-05-12 14:30:08
 * @version 1.00
 */



class ErrorAction {


	public function __construct() {

	}

	public function ErrorPage() {
		GameCore::display("404.php");
	}

}
