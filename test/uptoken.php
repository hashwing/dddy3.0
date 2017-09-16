<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/25
 * Time: 10:44
 */
require_once 'qiniusdk/autoload.php';
//require_once 'db.php';
require_once 'config.php';

use Qiniu\Auth;

session_start();
$uid = $_SESSION['uid'];
if(!isset($uid))
{
    header('location: login.php');
    return;
}

$bucket = Config::BUCKET_NAME;
$accessKey = Config::ACCESS_KEY;
$secretKey = Config::SECRET_KEY;
$auth = new Auth($accessKey, $secretKey);

$policy = array(
    'callbackUrl' => 'http://172.30.251.210/callback.php',
    'callbackBody' => '{"fname":"$(fname)", "fkey":"$(key)", "desc":"$(x:desc)", "uid":' . $uid . '}'
);

$upToken = $auth->uploadToken($bucket, null, 3600, $policy);

header('Access-Control-Allow-Origin:*');
echo $upToken;