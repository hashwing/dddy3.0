<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/27
 * Time: 22:33
 */
require_once 'config.php';
session_start();
if(!$_POST){
    echo "error";
    exit;
}
$filename=$_POST['filename'];
$refilename=$_POST['refilename'];
$pagetype=$_POST['pagetype'];
$range=$_POST['range'];
$range2=$_POST['range2'];
$copys=$_POST['copys'];
$isbind=$_POST['isbind'];
$uid=$_SESSION['uid'];
$sql="INSERT INTO dy_file (uid,filename,wjm,dsm,sys,mys,fs,zd,zt)VALUES('$uid','$filename','$refilename','$pagetype','$range','$range2','$copys','$isbind','0')";
$db=new Common\myDb();
if($db->dbIUD($sql)){
    echo "1";
}else{
    echo 0;
}

