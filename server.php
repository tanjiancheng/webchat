<?php

/**
 * 聊天服务器程序
*/

include("libs/Stroage.php");
include("libs/Common.php");

set_time_limit(0);

$msg = isset($_GET['msg']) ? $_GET['msg'] : ''; 
if ($msg != '') {
	Stroage::getInstance() -> set("msg", $msg);
	Stroage::getInstance() -> set("time", time());
	die(); 
}

$lastmodif = isset($_GET['timestamp']) ? (int)$_GET['timestamp'] : 0; 

$currentmodif = (int)Stroage::getInstance() -> get("time");


while ($currentmodif <= $lastmodif) // check if the data file has been modified 
{ 
	usleep(10000); 					// sleep 10ms to unload the CPU 
	$currentmodif = Stroage::getInstance() -> get("time");
}

$response = array();

$response['msg'] = Stroage::getInstance() -> get("msg");		//聊天信息
$response['timestamp'] = $currentmodif; 						//当前时间戳
$response['currentTime'] = date("Y-m-d H:i:s",$currentmodif); 	//格式化后的时间

if(isset($_GET['ip']) && $_GET['ip'] != '') {
	$response['ip'] = $_GET['ip'];
} else {
	$response['ip'] = get_ClientIP(); 
}

echo json_encode($response); 
flush();
?>
