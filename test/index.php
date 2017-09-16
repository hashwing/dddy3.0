<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/21
 * Time: 14:37
 */
require_once '../class/qiniusdk/autoload.php';
require_once 'config.php';
use Qiniu\Auth;
use Qiniu\Processing\PersistentFop;

$bucket = Config::BUCKET_NAME;
$accessKey = Config::ACCESS_KEY;
$secretKey = Config::SECRET_KEY;
$auth = new Auth($accessKey, $secretKey);

//要转码的文件所在的空间和文件名。
$key = 'FvZKg4Xpk1Ehr54D5FsyROps7IRO';

//转码是使用的队列名称。 https://portal.qiniu.com/mps/pipeline
//$pipeline = 'pipeline_name';

//转码完成后通知到你的业务服务器。
$notifyUrl = 'http://bike.ggproject.cn/index.php';
$pfop = new PersistentFop($auth, $bucket, $pipeline, $notifyUrl);

//要进行转码的转码操作。 http://developer.qiniu.com/docs/v6/api/reference/fop/av/avthumb.html
//$fops = "avthumb/mp4/s/640x360/vb/1.4m";
$saveas_key = \Qiniu\base64_urlSafeEncode("ggjk:自动控制-ATC.pdf");
$fops = "yifangyun_preview/v2/ext=doc|saveas/".$saveas_key;
//$fops = "yifangyun_preview/v2";
list($id, $err) = $pfop->execute($key, $fops);
echo "\n====> pfop avthumb result: \n";
if ($err != null) {
    var_dump($err);
} else {
    echo "PersistentFop Id: $id\n";
}

//查询转码的进度和状态
list($ret, $err) = $pfop->status($id);
echo "\n====> pfop avthumb status: \n";
if ($err != null) {
    var_dump($err);
} else {
    var_dump($ret);
}