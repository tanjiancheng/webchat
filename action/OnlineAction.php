<?php

/**
 * 获取在线用户人数
 * @authors ctam
 * @date    2014-05-12 14:30:08
 * @version 1.00
 */

class OnlineAction {


	public function __construct() {

	}

	public function __destruct() {

	}

	public function connect($parame = array()) {
		set_time_limit(0);
		session_write_close();

		$lastmodif = isset($parame['timestamp']) ? (int)$parame['timestamp'] : 0; 

		$currentmodif = (int)Stroage::getInstance() -> get("onlineTime");

		if($currentmodif == 0) {
			$currentmodif = time();
		}

		while ($currentmodif <= $lastmodif) // check if the data file has been modified 
		{ 
			usleep(10000); 					// sleep 10ms to unload the CPU 
			$currentmodif = Stroage::getInstance() -> get("onlineTime");
		}

		$response = array();
		$response['online'] = getOnlineList();		//在线人数信息
		$response['timestamp'] = $currentmodif; 						    //当前时间戳

		echo json_encode($response); 
		flush();
	}

	public function deleteOnlineUser($parame = array()) {
		/*session_start();
		session_write_close();
		unset($_SESSION);
		*/
		$userName = $parame['userName'];
		$ip = $parame['ip'];
		deleteOnlineUser($userName, $ip);
		exit;
	}


}
