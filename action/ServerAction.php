<?php

/**
 * 服务端类
 * @authors ctam
 * @date    2014-05-12 14:30:08
 * @version 1.00
 */

class ServerAction {


	public function __construct() {

	}

	public function __destruct() {
		//ob_end_flush();
		//flush();
		//die();
	}

	public function connect($parame = array()) {
		set_time_limit(0);
    	session_write_close();

		$lastmodif = isset($parame['timestamp']) ? (int)$parame['timestamp'] : 0; 

		$currentmodif = (int)Stroage::getInstance() -> get("time");

		if($currentmodif == 0) {
			$currentmodif = time();
		}

		$startTime = time();
		$isExpire = false;		//每隔过期时间前3秒断开一次连接，以此保持连接
		while ($currentmodif <= $lastmodif) // check if the data file has been modified 
		{ 
			usleep(10000);					// sleep 10ms to unload the CPU 
			$currentmodif = Stroage::getInstance() -> get("time");
			if(time() - $startTime > (EXPIRE-3)) {
				$isExpire = true;
				break;
			}
		}

		$response = array();

		if(!$isExpire) {
			$lastmodif == 0 ? $response['isFirst'] = true : $response['isFirst'] = false; 
			$response['msg'] = Stroage::getInstance() -> get("msg");		//聊天信息
			$response['timestamp'] = $currentmodif; 						//当前时间戳
			$response['currentTime'] = date("Y-m-d H:i:s",$currentmodif); 	//格式化后的时间
			$response['ip'] = Stroage::getInstance() -> get("currentip");	//当前发送用户ip
			$response['pic'] = Stroage::getInstance() -> get("pic");	    //当前发送用户头像
			$response['userName'] = Stroage::getInstance() -> get("userName");	    //当前发送用户名称
			if(empty($response['pic'])) {
				$response['pic'] = "default.gif";
			}

		} else {
			$response = null;
		}
		

		updateOnlineList($parame,false);
		echo json_encode($response); 
		flush();
	}


}
