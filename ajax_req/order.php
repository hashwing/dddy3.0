<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/12/2
 * Time: 15:54
 */
include 'price.init.php';
function trade_no() {
    list($usec, $sec) = explode(" ", microtime());
    $usec = substr(str_replace('0.', '', $usec), 0 ,4);
    $str  = rand(10,99);
    return date("YmdHis").$usec.$str;
}
$uid=$_SESSION['uid'];
$price=$total;
$sh=$_POST['sh'];
$adr=$_POST["sendadr"].'-'.$_POST['sendssh'];
$phone=$_POST['phone'];
$st=$_POST['sendtime'];
$dt=$_POST['gettime'];
$time=date("Y-m-d H:m:s",time());
$ddh=trade_no();

$sql="UPDATE dy_file SET ddh='$ddh', zt='1' WHERE uid='$uid' AND  zt='0'";
$ret=$db->dbUC($sql);
$count=$ret;
if($ret){
    $sql="INSERT INTO dy_dd (ddh,sid,price,zf,sh,adr,phone,st,dt,zt,time)
VALUES ('$ddh','$sid','$price','0','$sh','$adr','$phone','$st','$dt','0','$time')";
    if($db->dbIUD($sql)){
        $data['ddh']=$ddh;
        $data['total']=$total;
        $data['count']=$count;
        echo json_encode($data);
    }
}


