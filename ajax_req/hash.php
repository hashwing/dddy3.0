<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/28
 * Time: 17:04
 */
require_once 'config.php';

$hash=$_POST['hash'];
$filename=$_POST['filename'];
$db=new \Common\myDb();
$sql="SELECT * FROM  dy_hash WHERE hash='$hash'";
$ret=$db->sRow($sql);
if(count($ret)){            //FkYIVH2TS4VWmO41CAIU
    echo $ret['filename'];//FkYIVH2TS4VWmO41CAIU
}else{
    $sql="INSERT INTO dy_hash SET hash='$hash',filename='$filename'";
    if($db->dbIUD($sql)){
        echo $filename;
    }
}