<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/12/2
 * Time: 16:00
 */
require_once 'config.php';
session_start();
$sid=$_POST['sid'];
$db=new Common\myDb();
$sql="SELECT * FROM dy_price WHERE sid='$sid'AND pid='1'";
$ret=$db->sRow($sql);
if(count($ret)){
    $SinglePrice=$ret['price'];
}else {
    $SinglePrice = 0.15;
}
$sql="SELECT *FROM dy_price WHERE sid='$sid' AND  pid='2'" ;
$ret=$db->sRow($sql);
if(count($ret)){
    $DoublePrice=$ret['price'];
}else{
    $DoublePrice=0.2;
}

$uid=$_SESSION['uid'];
$SinglePages=0;
$DoublePages=0;
$sql="SELECT *FROM dy_file WHERE uid='$uid' AND zt='0'";
$ret=$db->sRows($sql);
foreach($ret as $key=>$value ){
    if($value['dsm']=='1'){
        $SinglePages+=($value['mys']-$value['sys']+1)*$value['fs'];
    }else{
        if(($value['mys']-$value['sys']+1)%2==1){
            $SinglePages+=$value['fs'];
        }
        $DoublePages+=intval($value['dsm']/2)*$value['fs'];
    }
}

$SinglePrices=$SinglePrice*$SinglePages;
$DoublePrices=$DoublePrice*$DoublePages;
$total=$DoublePrices+$SinglePrices;

$price['SinglePrice']=$SinglePrice;
$price['SinglePrices']=$SinglePrices;
$price['SinglePages']=$SinglePages;
$price['DoublePrice']=$DoublePrice;
$price['DoublePrices']=$DoublePrices;
$price['DoublePages']=$DoublePages;
$price['total']=$total;