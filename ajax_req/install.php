<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/27
 * Time: 23:05
 */
require_once 'config.php';
$db=new \Common\myDb();
//文件
$sql = "CREATE TABLE dy_file
(
id int NOT NULL auto_increment,
uid VARCHAR(30),
filename varchar(30),
ddh varchar(30),
wjm varchar(255),
size varchar(30),
color int(2),
dsm int(2),
jb int(2),
sys int(5),
mys int(5),
fs int(5),
zd int(2),
bz varchar(255),
zt int(2),
 PRIMARY KEY  (`id`)
)";
/*if($db->dbIUD($sql))
{
    echo "dy_wj sucessful</br>";
}
else{echo "dy_wj bad!</br>";}*/

$sql="CREATE TABLE dy_hash
(
id int NOT NULL auto_increment,
hash VARCHAR(20),
filename varchar(30),
PRIMARY KEY (`id`)
)";
var_dump($db->dbIUD($sql)) ;