<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2017/01/29
 * Time: 23:21
 * Function:七牛云Token生成
 * Description：$accessKey、$secretKey分别为Access Key 和 Secret Key，$bucket为空间名
 */
require_once '../class/qiniusdk/autoload.php';
require_once 'config.php';
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
//设置时区
date_default_timezone_set('PRC');
//  Access Key 和 Secret Key
$accessKey = \Common\Config::ACCESS_KEY;
$secretKey = \Common\Config::SECRET_KEY;
// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);
// 要上传的空间
$bucket = \Common\Config::BUCKET_NAME;
//文件类型
$filetype=$_POST['filetype'];
//生成唯一文件名
function trade_no() {
    list($usec, $sec) = explode(" ", microtime());
    $usec = substr(str_replace('0.', '', $usec), 0 ,4);
    $str  = rand(10,99);
    return date("YmdHis").$usec.$str;
}
//生成文件名
$key=trade_no();
//上传策略
if($filetype==='pdf'){
    $policy=array(
        'saveKey'=>$key.'.pdf',
    );
}else{
    //转码队列
    $saveas_key=$key.'.pdf';
    $saveas_key = \Qiniu\base64_urlSafeEncode("ggjk:$saveas_key");
    $fops = "yifangyun_preview/v2|saveas/".$saveas_key;
    $policy=array(
        'saveKey'=>$key.'.'.$filetype,
        'persistentOps' => $fops
    );
}

$upToken = $auth->uploadToken($bucket, null, 3600, $policy);
header('Access-Control-Allow-Origin:*');
echo $upToken;