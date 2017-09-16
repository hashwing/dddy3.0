<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/30
 * Time: 21:56
 */
require_once 'config.php';

$db=new \Common\myDb();
$sql="SELECT sid,ssq,ssh FROM dy_sj WHERE zx='1'";
$ret=$db->sRows($sql);
echo json_encode($ret);