<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/28
 * Time: 13:36
 */
require_once 'config.php';

session_start();
$uid=$_POST['uid'];
if(isset($_SESSION['uid'])){
    $uid=$_SESSION['uid'];
}
//$uid="2016B27567746235905";
$db=new \Common\myDb();
$ddh=Null;
$sql="SELECT * FROM dy_file WHERE uid='$uid'AND zt='0'";
$ret=$db->sRows($sql);
if(count($ret)){
    echo json_encode($ret);
}else{
    echo 0;
}

