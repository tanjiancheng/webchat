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

/**
 * 更新在线列表
 * @param  array  $parame 关于在线用户信息的数组                
 * @param  push  true推送，false不推送，默认为true              
 * @return 
 */
function updateOnlineList($parame = array(),$push = true) {
    ini_set("auto_detect_line_endings", true);

    if(!$parame['userName'] || !$parame['pic'] || !$parame['ip'] ) {
        return;
    }

    $oldOnlineList = Stroage::getInstance() -> get("online");

    $newOnlineList = '';
    $oldOnlineArray = array();
    $newOnlineArray  = array();

    if($oldOnlineList === 0) {
        $oldOnlineList = '';
    } else {
        $tempArr = explode("\r\n", $oldOnlineList);
        foreach($tempArr as $val) {
            if(!empty($val)) {
                $oldOnlineArray[] = json_decode($val,true);
            }
        }
    }

    $userName = $parame['userName'];
    $pic = $parame['pic'];
    $ip = $parame['ip'];
    $expire = time()+EXPIRE;  //默认15秒没有回复就当下线

    $data[] = array(
        'userName' => $userName,
        'pic' => $pic,
        'ip' => $ip,
        'expire' => $expire
    );

    $flag = true;
    foreach($oldOnlineArray as $key => $val) {
        if($val['userName'] == $userName && $val['ip'] == $ip) {
            $oldOnlineArray[$key]['expire'] = $expire;
            $oldOnlineArray[$key]['pic'] = $pic;
            $oldOnlineArray[$key]['ip'] = $ip;
            $flag  = false;
            break;
        }
    }

    if($flag) {
        $newOnlineArray = array_merge($oldOnlineArray, $data);
    } else {
        $newOnlineArray = $oldOnlineArray;
    }
    

    if(is_array($newOnlineArray) && !empty($newOnlineArray)) {

        foreach($newOnlineArray as $key => $val) {
            $newOnlineList .= json_encode($val) . "\r\n";
        }

        Stroage::getInstance() -> set("online", $newOnlineList);

        //改变在线列表记录时间，推送出去
        if($push) {
            pushOnline();
        }
        
    }
    
}

/**
 * 推送当前在线人数
 * @return [type] [description]
 */
function pushOnline() {
    Stroage::getInstance() -> set("onlineTime",time());
}

/**
 * 获取用户列表
 * @return [type] [description]
 */
function getOnlineList() {
    $result = array();

    $online = Stroage::getInstance() -> get("online");

    if($online !== 0) {
        $tempArr = explode("\r\n", $online);
        foreach($tempArr as $val) {
            if(!empty($val)) {
                $user = json_decode($val,true); 
                if(time() - $user['expire'] < EXPIRE) {
                    $result[] = $user;
                } else {
                    deleteOnlineUser($user['userName'], $user['ip']);
                }
            }
        }

    }

    return $result;
}

/**
 * 根据用户名和ip地址删除在线用户
 * @return [type] [description]
 */
function deleteOnlineUser($userName, $ip, $push = true) {
    $result = array();
    $newOnlineList = '';

    $online = Stroage::getInstance() -> get("online");

    if($online !== 0) {
        $tempArr = explode("\r\n", $online);
        foreach($tempArr as $val) {
            if(!empty($val)) {
                $result[] = json_decode($val,true);
            }
        }

    }

    foreach($result as $key => $val) {
        if($val['userName'] == $userName && $val['ip'] == $ip) {
            unset($result[$key]);
        }
    }

    foreach($result as $key => $val) {
        $newOnlineList .= json_encode($val) . "\r\n";
    }

    Stroage::getInstance() -> set("online", $newOnlineList);
    
    if($push) {
        pushOnline();
    }
    
}