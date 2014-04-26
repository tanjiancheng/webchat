<?php

/**
 * 
 */

set_time_limit(0);
$filename = dirname(__FILE__).'/data.txt';

$msg = isset($_GET['msg']) ? $_GET['msg'] : ''; 
if ($msg != '') { 
	file_put_contents($filename,$msg); 
	die(); 
}

$lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0; 

$currentmodif = filemtime($filename);

while ($currentmodif <= $lastmodif) // check if the data file has been modified 
{ 
	usleep(10000); // sleep 10ms to unload the CPU 
	clearstatcache(); 
	$currentmodif = filemtime($filename); 
}

$response = array(); 
$response['msg'] = file_get_contents($filename); 
$response['msg'].= $lastmodif ."|". $currentmodif;
$response['timestamp'] = $currentmodif; 
echo json_encode($response); 
flush();
?>
