<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/28
 * Time: 16:30
 */
require_once 'config.php';

if(!$_POST){
   die("error");
}
$id=$_POST['id'];
$db=new \Common\myDb();
$sql="DELETE FROM dy_file WHERE id='$id'";
if($db->dbIUD($sql))
{
    echo 1;
}else{
    echo 0;
}