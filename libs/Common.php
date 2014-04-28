<?php
/**
	公告函数类
**/

/**
 * 获取玩家IP地址
 *
 * @return string
 * @author Goku
 * @version 1.0.0
 */
function get_ClientIP()
{
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $thisip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        	$thisip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $thisip = $_SERVER["REMOTE_ADDR"];
        }    
    }

    return $thisip;
}