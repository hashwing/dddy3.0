<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/30
 * Time: 22:30
 */
require_once 'config.php';
$sid=$_POST['sid'];
$db=new \Common\myDb();
$sql="SELECT id ,time FROM dy_dt WHERE sid='$sid' ORDER BY zt ASC ";
$data['GetTime']=$db->sRows($sql);
$sql="SELECT id ,time FROM dy_st WHERE sid='$sid' ORDER BY zt ASC ";
$data['SendTime']=$db->sRows($sql);
$sql="SELECT id ,adr FROM dy_psadr WHERE sid='$sid'  ";
$data['SendAdr']=$db->sRows($sql);

echo json_encode($data);