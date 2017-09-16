<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/27
 * Time: 20:42
 */
session_start();
date_default_timezone_set('PRC');
require_once 'config.php';
function get_uid(){
    $uid = date('Y') . strtoupper(dechex(date('m'))) . date('d') .
        substr(time(), -5) . substr(microtime(), 2, 5) .
        sprintf('%02d', rand(0, 99));
    return $uid;
}
if(!isset($_SESSION["uid"])){
    $uid=get_uid();
    $_SESSION['uid']=$uid;
}else{
    echo $_SESSION['uid'];
}

